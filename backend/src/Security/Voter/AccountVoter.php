<?php

namespace App\Security\Voter;

use App\Entity\Account;
use App\Entity\User;
use App\Repository\AssignmentRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountVoter extends Voter{

    protected function supports($attribute, $subject) {
        return in_array($attribute, ['POST', 'PUT', 'DELETE']) && $subject instanceof Account;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getRoles()[0] === "ROLE_SUPER_ADMIN") {
            return true;
        }

        if($subject instanceof Account) {

            switch ($attribute) {
                case 'PUT':
                    return $user->getRoles()[0] === "ROLE_ADMIN";
                break;

                case 'POST':
                    return $user->getRoles()[0] === "ROLE_ADMIN";
                break;

                case 'DELETE':
                    return $user->getRoles()[0] === "ROLE_ADMIN";
                break;

                default:
                    return false;
                break;
            }
        }
    }
}