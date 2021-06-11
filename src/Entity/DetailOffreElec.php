<?php

namespace App\Entity;

use App\Repository\DetailOffreElecRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailOffreElecRepository::class)
 */
class DetailOffreElec
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prAbonnementParAn;

    /**
     * @ORM\Column(type="float")
     */
    private $prPte;

    /**
     * @ORM\Column(type="float")
     */
    private $prHPH;

    /**
     * @ORM\Column(type="float")
     */
    private $prHCH;

    /**
     * @ORM\Column(type="float")
     */
    private $prHPE;

    /**
     * @ORM\Column(type="float")
     */
    private $prHCE;

    /**
     * @ORM\Column(type="float")
     */
    private $budgetHTT;

    /**
     * @ORM\ManyToOne(targetEntity=OffreElectricite::class, inversedBy="detailOffreElecs")
     */
    private $offre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="float")
     */
    private $totalHT;

    /**
     * @ORM\Column(type="float")
     */
    private $totalHTVA;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrAbonnementParAn(): ?float
    {
        return $this->prAbonnementParAn;
    }

    public function setPrAbonnementParAn(?float $prAbonnementParAn): self
    {
        $this->prAbonnementParAn = $prAbonnementParAn;

        return $this;
    }

    public function getPrPte(): ?float
    {
        return $this->prPte;
    }

    public function setPrPte(?float $prPte): self
    {
        $this->prPte = $prPte;

        return $this;
    }

    public function getPrHPH(): ?float
    {
        return $this->prHPH;
    }

    public function setPrHPH(?float $prHPH): self
    {
        $this->prHPH = $prHPH;

        return $this;
    }

    public function getPrHCH(): ?float
    {
        return $this->prHCH;
    }

    public function setPrHCH(?float $prHCH): self
    {
        $this->prHCH = $prHCH;

        return $this;
    }

    public function getPrHPE(): ?float
    {
        return $this->prHPE;
    }

    public function setPrHPE(?float $prHPE): self
    {
        $this->prHPE = $prHPE;

        return $this;
    }

    public function getPrHCE(): ?float
    {
        return $this->prHCE;
    }

    public function setPrHCE(?float $prHCE): self
    {
        $this->prHCE = $prHCE;

        return $this;
    }

    public function getBudgetHTT(): ?float
    {
        return $this->budgetHTT;
    }

    public function setBudgetHTT(?float $budgetHTT): self
    {
        $this->budgetHTT = $budgetHTT;

        return $this;
    }

    public function getOffre(): ?OffreElectricite
    {
        return $this->offre;
    }

    public function setOffre(?OffreElectricite $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

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

    public function getTotalHT(): ?float
    {
        return $this->totalHT;
    }

    public function setTotalHT(float $totalHT): self
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTotalHTVA(): ?float
    {
        return $this->totalHTVA;
    }

    public function setTotalHTVA(float $totalHTVA): self
    {
        $this->totalHTVA = $totalHTVA;

        return $this;
    }
}
