<?php

namespace App\Entity;

use App\Repository\AnfrageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnfrageRepository::class)]
class Anfrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $wohnflaeche = null;

    #[ORM\Column(length: 255)]
    private ?string $plz = null;

    #[ORM\Column]
    private ?int $selbstbeteiligung = null;

    #[ORM\Column]
    private ?bool $fahrrad = null;

    #[ORM\Column]
    private ?bool $glas = null;

    #[ORM\Column]
    private ?bool $elementar = null;

    #[ORM\Column]
    private array $ergebnis = [];

    #[ORM\Column(length: 255)]
    private ?string $empfehlung = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $erstelltAm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWohnflaeche(): ?int
    {
        return $this->wohnflaeche;
    }

    public function setWohnflaeche(int $wohnflaeche): static
    {
        $this->wohnflaeche = $wohnflaeche;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): static
    {
        $this->plz = $plz;

        return $this;
    }

    public function getSelbstbeteiligung(): ?int
    {
        return $this->selbstbeteiligung;
    }

    public function setSelbstbeteiligung(int $selbstbeteiligung): static
    {
        $this->selbstbeteiligung = $selbstbeteiligung;

        return $this;
    }

    public function isFahrrad(): ?bool
    {
        return $this->fahrrad;
    }

    public function setFahrrad(bool $fahrrad): static
    {
        $this->fahrrad = $fahrrad;

        return $this;
    }

    public function isGlas(): ?bool
    {
        return $this->glas;
    }

    public function setGlas(bool $glas): static
    {
        $this->glas = $glas;

        return $this;
    }

    public function isElementar(): ?bool
    {
        return $this->elementar;
    }

    public function setElementar(bool $elementar): static
    {
        $this->elementar = $elementar;

        return $this;
    }

    public function getErgebnis(): array
    {
        return $this->ergebnis;
    }

    public function setErgebnis(array $ergebnis): static
    {
        $this->ergebnis = $ergebnis;

        return $this;
    }

    public function getEmpfehlung(): ?string
    {
        return $this->empfehlung;
    }

    public function setEmpfehlung(string $empfehlung): static
    {
        $this->empfehlung = $empfehlung;

        return $this;
    }

    public function getErstelltAm(): ?\DateTimeImmutable
    {
        return $this->erstelltAm;
    }

    public function setErstelltAm(\DateTimeImmutable $erstelltAm): static
    {
        $this->erstelltAm = $erstelltAm;

        return $this;
    }
}
