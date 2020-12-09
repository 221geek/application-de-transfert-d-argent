<?php
namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Deposit;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class DepositDataPersister implements DataPersisterInterface
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Deposit;
    }

    public function persist($data)
    {
        $amount = $data->getAmount();
        $account = $data->getAccount();

        $account->setBalance($account->getBalance()+$amount);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}