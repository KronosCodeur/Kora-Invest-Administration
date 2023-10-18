<?php

namespace App\Entity;

use App\Repository\InvestmentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestmentRepository::class)]
class Investment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column]
    private ?int $solde = null;

    #[ORM\Column]
    private ?bool $blocked = null;

    #[ORM\Column]
    private ?string $makedAt = null;

    #[ORM\Column]
    private ?string $availableAt = null;

    #[ORM\Column]
    private ?int $return = null;

    #[ORM\ManyToOne(inversedBy: 'investments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?InvestmentType $type = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'investments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getMakedAt(): ?string
    {
        return $this->makedAt;
    }

    public function setMakedAt(string $makedAt): static
    {
        $this->makedAt = $makedAt;

        return $this;
    }

    public function getAvailableAt(): ?string
    {
        return $this->availableAt;
    }

    public function setAvailableAt(string $availableAt): static
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    public function getReturn(): ?int
    {
        return $this->return;
    }

    public function setReturn(int $return): static
    {
        $this->return = $return;

        return $this;
    }

    public function getType(): ?InvestmentType
    {
        return $this->type;
    }

    public function setType(?InvestmentType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

}
