<?php

namespace App\Entity;

use App\Repository\PerimetreElectriciteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerimetreElectriciteRepository::class)
 */
class PerimetreElectricite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="perimetreElectricites")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFourniture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PDL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomPtLivraison;


    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $pte;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $HPH;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $HCH;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $HPE;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $HCE;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $volume;

    /**
     * @ORM\ManyToOne(targetEntity=Segmentation::class, inversedBy="perimetreElectricites")
     */
    private $segmentation;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $seg;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $psHPH;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $psHCH;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $psHPE;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $psHCE;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $psPte;

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

    public function getDateFourniture()
    {
        return $this->dateFourniture;
    }

    public function setDateFourniture($dateFourniture): self
    {
        $this->dateFourniture = $dateFourniture;

        return $this;
    }

    public function getPDL(): ?string
    {
        return $this->PDL;
    }

    public function setPDL(?string $PDL): self
    {
        $this->PDL = $PDL;

        return $this;
    }

    public function getNomPtLivraison(): ?string
    {
        return $this->nomPtLivraison;
    }

    public function setNomPtLivraison(?string $nomPtLivraison): self
    {
        $this->nomPtLivraison = $nomPtLivraison;

        return $this;
    }

    public function getPte(): ?float
    {
        return $this->pte;
    }

    public function setPte(?float $pte): self
    {
        $this->pte = $pte;

        return $this;
    }

    public function getHPH(): ?float
    {
        return $this->HPH;
    }

    public function setHPH(?float $HPH): self
    {
        $this->HPH = $HPH;

        return $this;
    }

    public function getHCH(): ?float
    {
        return $this->HCH;
    }

    public function setHCH(float $HCH): self
    {
        $this->HCH = $HCH;

        return $this;
    }

    public function getHPE(): ?float
    {
        return $this->HPE;
    }

    public function setHPE(?float $HPE): self
    {
        $this->HPE = $HPE;

        return $this;
    }

    public function getHCE(): ?float
    {
        return $this->HCE;
    }

    public function setHCE(?float $HCE): self
    {
        $this->HCE = $HCE;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

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

    public function getSegmentation(): ?Segmentation
    {
        return $this->segmentation;
    }

    public function setSegmentation(?Segmentation $segmentation): self
    {
        $this->segmentation = $segmentation;

        return $this;
    }

    public function getSeg(): ?string
    {
        return $this->seg;
    }

    public function setSeg(?string $seg): self
    {
        $this->seg = $seg;

        return $this;
    }

    public function getPsHPH(): ?float
    {
        return $this->psHPH;
    }

    public function setPsHPH(float $psHPH): self
    {
        $this->psHPH = $psHPH;

        return $this;
    }

    public function getPsHCH(): ?float
    {
        return $this->psHCH;
    }

    public function setPsHCH(float $psHCH): self
    {
        $this->psHCH = $psHCH;

        return $this;
    }

    public function getPsHPE(): ?float
    {
        return $this->psHPE;
    }

    public function setPsHPE(float $psHPE): self
    {
        $this->psHPE = $psHPE;

        return $this;
    }

    public function getPsHCE(): ?float
    {
        return $this->psHCE;
    }

    public function setPsHCE(float $psHCE): self
    {
        $this->psHCE = $psHCE;
        return $this;
    }

    public function getPsPte(): ?string
    {
        return $this->psPte;
    }

    public function setPsPte(?string $psPte): self
    {
        $this->psPte = $psPte;

        return $this;
    }
}
