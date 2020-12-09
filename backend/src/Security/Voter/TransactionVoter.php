<?php

namespace App\Security\Voter;

use App\Entity\Transaction;
use App\Repository\AssignmentRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TransactionVoter extends Voter{

    private $asignmentRepo;

    public function __construct(AssignmentRepository $asignmentRepo)
    {
        $this->asignmentRepo = $asignmentRepo;
    }

    protected function supports($attribute, $subject) {
        return in_array($attribute, ['POST', 'PUT', 'DELETE']) && $subject instanceof Transaction;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getRoles()[0] === "ROLE_SUPER_ADMIN") {
            return true;
        }

        if($subject instanceof Transaction) {

            $today = new \DateTime();
            $assignmentSender = false;
            $assignmentReceiver = false;

            $assignSender = $this->asignmentRepo->findBy(
                array(
                    'account' => $subject->getAccountSender(),
                    'user' => $user
                )
            );

            for ($i=0; $i < sizeof($assignSender); $i++) { 
                $assignmentSender = $assignSender[$i]->getStartDate() < $today && $assignSender[$i]->getEndDate() > $today;
            }

            $assignReceiver = $this->asignmentRepo->findBy(
                array(
                    'account' => $subject->getAccountReceiver(),
                    'user' => $user
                )
            );

            for ($i=0; $i < sizeof($assignReceiver); $i++) { 
                $assignmentReceiver = $assignReceiver[$i]->getStartDate() < $today && $assignReceiver[$i]->getEndDate() > $today;
            }

            switch ($attribute) {
                case 'POST':
                    return $assignmentSender;
                break;

                case 'PUT':
                    return $assignmentReceiver;
                break;

                default:
                    return false;
                break;
            }
        }
    }
}