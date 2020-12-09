<?php

namespace App\Controller\Api;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetCurrentUser {

    protected $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function get_current_user()
    {
        $current_user = $this->token->getToken()->getUser();
        return $current_user;
    }
}