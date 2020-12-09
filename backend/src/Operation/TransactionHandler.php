<?php

namespace App\Operation;

use App\Entity\Transaction;

class TransactionHandler {

    public function handle(Transaction $data) {
        return true;
    }
}