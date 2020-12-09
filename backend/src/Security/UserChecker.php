<?php
namespace App\Security;
 
use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return false;
        }
    }
 
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) { 
            return;
        }
 
        if (!$user->getIsActive()) {
            throw new AccountExpiredException();
        }
    }
}