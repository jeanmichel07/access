<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjectifRepository::class)
 */
class Objectif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="objectifs")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $perimetre;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valeur;

    /**
     * @ORM\Column(type="text")
     */
    private $strategieCommercial;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Client
    {
        return $this->user;
    }

    public function setUser(?Client $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPerimetre(): ?string
    {
        return $this->perimetre;
    }

    public function setPerimetre(?string $perimetre): self
    {
        $this->perimetre = $perimetre;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(?float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getStrategieCommercial(): ?string
    {
        return $this->strategieCommercial;
    }

    public function setStrategieCommercial(string $strategieCommercial): self
    {
        $this->strategieCommercial = $strategieCommercial;

        return $this;
    }
}
