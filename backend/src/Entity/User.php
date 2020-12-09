<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *      itemOperations = {
 *          "get" = {
 *              "normalization_context"={"groups"={"read"}},
 *              "security"="is_granted('ROLE_ADMIN')"
 *          },
 *          "get_current_user" = {
 *              "route_name"="current_user"
 *          },
 *          "put" = {
 *              "access_control"="is_granted('PUT', object)"
 *          },
 *          "delete" = {
 *              "access_control"="is_granted('DELETE', object)"
 *          }
 *      },
 *      collectionOperations = {
 *          "get" = {
 *              "normalization_context"={"groups"={"read"}},
 *              "security"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post" = {
 *              "access_control"="is_granted('POST', object)"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("read")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("read")
     */
    private $signAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("read")
     */
    private $role;

    public function __construct()
    {
        $this->isActive = true;
        $this->signAt = new \DateTime();
        $this->assignments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSignAt(): ?\DateTimeInterface
    {
        return $this->signAt;
    }

    public function setSignAt(\DateTimeInterface $signAt): self
    {
        $this->signAt = $signAt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @Groups("read")
     */
    public function getRoles()
    {
        return $this->roles = array('ROLE_'.strtoupper($this->getRole()->getWording()));;
    }

    public function __toString()
    {
        return $this->email;
    }
}