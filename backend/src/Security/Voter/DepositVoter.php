<?php

namespace App\Security\Voter;

use App\Entity\Deposit;
use App\Entity\User;
use App\Repository\AssignmentRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;

class DepositVoter extends Voter{

    private $asignmentRepo;

    public function __construct(AssignmentRepository $asignmentRepo)
    {
        $this->asignmentRepo = $asignmentRepo;
    }

    protected function supports($attribute, $subject) {
        return in_array($attribute, ['POST', 'PUT', 'DELETE']) && $subject instanceof Deposit;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getRoles()[0] === "ROLE_SUPER_ADMIN") {
            return true;
        }

        if($subject instanceof Deposit) {

            $today = new \DateTime();

            $assign = $this->asignmentRepo->findBy(
                array(
                    'account' => $subject->getAccount(),
                    'user' => $subject->getDepositor()
                )
            );

            for ($i=0; $i < sizeof($assign); $i++) { 
                $assignment = $assign[$i]->getStartDate() < $today && $assign[$i]->getEndDate() > $today;
            }

            switch ($attribute) {
                case 'POST':
                    return $assignment && $user === $subject->getDepositor();
                break;

                case 'DELETE':
                    return $user->getRoles()[0] === "ROLE_SUPER_ADMIN";
                break;
                
                default:
                    return false;
                break;
            }
        }
    }
}