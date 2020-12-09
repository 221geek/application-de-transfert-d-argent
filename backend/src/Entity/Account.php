<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      itemOperations = {
 *          "get" = {"security"="is_granted('ROLE_ADMIN')"},
 *          "put" = {"security"="is_granted('ROLE_ADMIN')"},
 *          "delete" = {"security"="is_granted('ROLE_ADMIN')"}
 *      },
 *      collectionOperations = {
 *          "post" = {"security"="is_granted('ROLE_ADMIN')"},
 *          "get" = {"security"="is_granted('ROLE_ADMIN')"}
 *      }
 * )
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Partner::class, inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\Column(type="bigint")
     */
    private $balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getOwner(): ?Partner
    {
        return $this->owner;
    }

    public function setOwner(?Partner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
