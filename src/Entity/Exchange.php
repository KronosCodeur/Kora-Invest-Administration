<?php

namespace App\Entity;

use App\Repository\ExchangeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExchangeRepository::class)]
class Exchange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $basename = null;

    #[ORM\Column(length: 255)]
    private ?string $currencyName = null;

    #[ORM\Column]
    private ?float $baseValue = null;

    #[ORM\Column]
    private ?float $currencyValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasename(): ?string
    {
        return $this->basename;
    }

    public function setBasename(string $basename): static
    {
        $this->basename = $basename;

        return $this;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): static
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getBaseValue(): ?float
    {
        return $this->baseValue;
    }

    public function setBaseValue(float $baseValue): static
    {
        $this->baseValue = $baseValue;

        return $this;
    }

    public function getCurrencyValue(): ?float
    {
        return $this->currencyValue;
    }

    public function setCurrencyValue(float $currencyValue): static
    {
        $this->currencyValue = $currencyValue;

        return $this;
    }

}
