<?php

namespace App\Entity;

use App\Repository\PermetreGazRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermetreGazRepository::class)
 */
class PermetreGaz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="permetreGazs")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFourniture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PCE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomPtLivraison;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tarifDistribution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $CAR;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDateFourniture(): ?\DateTimeInterface
    {
        return $this->dateFourniture;
    }

    public function setDateFourniture(?\DateTimeInterface $dateFourniture): self
    {
        $this->dateFourniture = $dateFourniture;

        return $this;
    }

    public function getPCE(): ?string
    {
        return $this->PCE;
    }

    public function setPCE(?string $PCE): self
    {
        $this->PCE = $PCE;

        return $this;
    }

    public function getNomPtLivraison(): ?string
    {
        return $this->nomPtLivraison;
    }

    public function setNomPtLivraison(string $nomPtLivraison): self
    {
        $this->nomPtLivraison = $nomPtLivraison;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(?string $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getTarifDistribution(): ?string
    {
        return $this->tarifDistribution;
    }

    public function setTarifDistribution(?string $tarifDistribution): self
    {
        $this->tarifDistribution = $tarifDistribution;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getCAR(): ?float
    {
        return $this->CAR;
    }

    public function setCAR(?float $CAR): self
    {
        $this->CAR = $CAR;

        return $this;
    }
}
