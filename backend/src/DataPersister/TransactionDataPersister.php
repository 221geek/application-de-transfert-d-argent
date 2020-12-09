<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Transaction;
use App\Repository\TarifsRepository;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $transactionrepository;
    private $tarifrepo;
    private $token;

    public function __construct(EntityManagerInterface $entityManager, TransactionRepository $transactionrepository, TokenStorageInterface $token, TarifsRepository $tarifrepo)
    {
        $this->entityManager = $entityManager;
        $this->transactionrepository = $transactionrepository;
        $this->token = $token;
        $this->tarifrepo = $tarifrepo;
    }

    public function supports($data): bool
    {
        return $data instanceof Transaction;
    }

    public function persist($data)
    {
        

        if (($data->getAccountSender()->getBalance() - $data->getAmount()) <= 500000) {
            $array = array(
                "message" => "The status of your account does not allow you to make a transfer"
            );
            $content = json_encode($array);

            return new Response($content, 403);
        }
        else {
            $charge = 0;
            $amount = $data->getAmount();
            $currentUser = $this->token->getToken()->getUser();

            $arrayCharges = $this->tarifrepo->findAll();

            for ($i=0; $i < sizeOf($arrayCharges); $i++) { 
                if ($arrayCharges[$i]->getMin() <= $amount && $arrayCharges[$i]->getMax() >= $amount) {
                    $charge = $arrayCharges[$i]->getFrais();
                }
            }

            $codeexist = null;
            do {
                $code = substr(time(), -4).rand(000, 999).$data->getAccountSender()->getId();
                $codeexist = $this->transactionrepository->findOneBy([
                    'code' => $code,
                    'completed' => false
                ]);
            } while($codeexist == !null);

            $data->setCharge($charge);
            $data->setCode($code);
            $data->getAccountSender()->setBalance($data->getAccountSender()->getBalance() - $data->getAmount());

            $data->setEmployeeSender($currentUser);
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}