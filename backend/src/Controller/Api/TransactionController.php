<?php

namespace App\Controller\Api;

use App\Entity\Transaction;
use App\Operation\TransactionHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionController {

    protected $token;
    private $transactionHandler;

    public function __construct(TokenStorageInterface $token, TransactionHandler $transactionHandler)
    {
        $this->token = $token;
        $this->transactionHandler = $transactionHandler;
    }

    public function __invoke($data): Transaction
    {
        $current_user = $this->token->getToken()->getUser();

        $data->setCompleted(true);
        $data->setemployeeReceiver($current_user);

        $this->transactionHandler->handle($data);
        return $data;
    }
}