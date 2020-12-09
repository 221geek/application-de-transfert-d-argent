<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Controller\Api\TransactionController;

/**
 * @ApiResource(
 *      itemOperations = {
 *          "get",
 *          "completedTransaction" = {
 *              "method"="PUT",
 *              "path"="/transactions/{id}/completed",
 *              "controller"=TransactionController::class,
 *              "access_control"="is_granted('PUT', object)",
 *              "normalization_context"={"groups"={"edit"}}
 *          }
 *      },
 *      collectionOperations = {
 *          "post" = {
 *              "normalization_context"={"groups"={"write"}},
 *              "access_control"="is_granted('POST', object)"
 *          },
 *          "get"
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"code": "exact"})
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("write")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $charge;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("edit")
     */
    private $completed;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("write")
     */
    private $accountSender;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @Groups("edit")
     */
    private $accountReceiver;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("write")
     */
    private $clientSender;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("write")
     */
    private $clientReceiver;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $employeeSender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Groups("edit")
     */
    private $employeeReceiver;

    public function __construct()
    {
        $this->completed = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCharge(): ?int
    {
        return $this->charge;
    }

    public function setCharge(int $charge): self
    {
        $this->charge = $charge;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getAccountSender(): ?Account
    {
        return $this->accountSender;
    }

    public function setAccountSender(?Account $accountSender): self
    {
        $this->accountSender = $accountSender;

        return $this;
    }

    public function getAccountReceiver(): ?Account
    {
        return $this->accountReceiver;
    }

    public function setAccountReceiver(?Account $accountReceiver): self
    {
        $this->accountReceiver = $accountReceiver;

        return $this;
    }

    public function getClientSender(): ?Client
    {
        return $this->clientSender;
    }

    public function setClientSender(?Client $clientSender): self
    {
        $this->clientSender = $clientSender;

        return $this;
    }

    public function getClientReceiver(): ?Client
    {
        return $this->clientReceiver;
    }

    public function setClientReceiver(?Client $clientReceiver): self
    {
        $this->clientReceiver = $clientReceiver;

        return $this;
    }

    public function getEmployeeSender(): ?User
    {
        return $this->employeeSender;
    }

    public function setEmployeeSender(?User $employeeSender): self
    {
        $this->employeeSender = $employeeSender;

        return $this;
    }

    public function getEmployeeReceiver(): ?User
    {
        return $this->employeeReceiver;
    }

    public function setEmployeeReceiver(?User $employeeReceiver): self
    {
        $this->employeeReceiver = $employeeReceiver;

        return $this;
    }
}