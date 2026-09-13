<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $preisProQm = null;

    #[ORM\Column]
    private ?bool $glasInklusive = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $leistungen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPreisProQm(): ?float
    {
        return $this->preisProQm;
    }

    public function setPreisProQm(float $preisProQm): static
    {
        $this->preisProQm = $preisProQm;

        return $this;
    }

    public function isGlasInklusive(): ?bool
    {
        return $this->glasInklusive;
    }

    public function setGlasInklusive(bool $glasInklusive): static
    {
        $this->glasInklusive = $glasInklusive;

        return $this;
    }

    public function getLeistungen(): ?string
    {
        return $this->leistungen;
    }

    public function setLeistungen(string $leistungen): static
    {
        $this->leistungen = $leistungen;

        return $this;
    }
}
