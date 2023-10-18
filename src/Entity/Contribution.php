<?php

namespace App\Entity;

use App\Repository\ContributionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContributionRepository::class)]
class Contribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $contributor = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column]
    private ?string $makedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContributor(): ?User
    {
        return $this->contributor;
    }

    public function setContributor(?User $contributor): static
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

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
}
