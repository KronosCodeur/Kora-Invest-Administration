<?php

namespace App\Entity;

use App\Repository\InvestmentRepository;
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

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $makedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $availableAt = null;

    #[ORM\Column]
    private ?int $return = null;


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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMakedAt(): ?\DateTimeImmutable
    {
        return $this->makedAt;
    }

    public function setMakedAt(\DateTimeImmutable $makedAt): static
    {
        $this->makedAt = $makedAt;

        return $this;
    }

    public function getAvailableAt(): ?\DateTimeImmutable
    {
        return $this->availableAt;
    }

    public function setAvailableAt(\DateTimeImmutable $availableAt): static
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

}
