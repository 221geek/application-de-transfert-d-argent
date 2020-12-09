<?php
namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Account;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Account;
    }

    public function persist($data)
    {
        $num = 'SN-'.rand(1000, 9999).'-'.substr(strval(time()), -4).'-'.substr($data->getOwner()->getNinea(), -4).'-'.substr($data->getOwner()->getRc(), -4);
        $data->setNumber($num);
            
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}