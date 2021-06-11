<?php

namespace App\Entity;

use App\Repository\PrixForPerimetreElecRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrixForPerimetreElecRepository::class)
 */
class PrixForPerimetreElec
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
    private $compComptage;

    /**
     * @ORM\Column(type="float")
     */
    private $compGestion;

    /**
     * @ORM\Column(type="float")
     */
    private $partFixe;

    /**
     * @ORM\Column(type="float")
     */
    private $partVariable;

    /**
     * @ORM\Column(type="float")
     */
    private $totalHT;

    /**
     * @ORM\Column(type="float")
     */
    private $cspe;

    /**
     * @ORM\Column(type="float")
     */
    private $cta;

    /**
     * @ORM\Column(type="float")
     */
    private $tcfe;

    /**
     * @ORM\Column(type="float")
     */
    private $totalHTVA;

    /**
     * @ORM\OneToOne(targetEntity=PerimetreElectricite::class, cascade={"persist", "remove"})
     */
    private $PerimetreElectricite;

    /**
     * @ORM\Column(type="float")
     */
    private $budgetHTT;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompComptage(): ?float
    {
        return $this->compComptage;
    }

    public function setCompComptage(float $compComptage): self
    {
        $this->compComptage = $compComptage;

        return $this;
    }

    public function getCompGestion(): ?float
    {
        return $this->compGestion;
    }

    public function setCompGestion(float $compGestion): self
    {
        $this->compGestion = $compGestion;

        return $this;
    }

    public function getPartFixe(): ?float
    {
        return $this->partFixe;
    }

    public function setPartFixe(float $partFixe): self
    {
        $this->partFixe = $partFixe;

        return $this;
    }

    public function getPartVariable(): ?float
    {
        return $this->partVariable;
    }

    public function setPartVariable(float $partVariable): self
    {
        $this->partVariable = $partVariable;

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

    public function getCspe(): ?float
    {
        return $this->cspe;
    }

    public function setCspe(float $cspe): self
    {
        $this->cspe = $cspe;

        return $this;
    }

    public function getCta(): ?float
    {
        return $this->cta;
    }

    public function setCta(float $cta): self
    {
        $this->cta = $cta;

        return $this;
    }

    public function getTcfe(): ?float
    {
        return $this->tcfe;
    }

    public function setTcfe(float $tcfe): self
    {
        $this->tcfe = $tcfe;

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

    public function getPerimetreElectricite(): ?PerimetreElectricite
    {
        return $this->PerimetreElectricite;
    }

    public function setPerimetreElectricite(?PerimetreElectricite $PerimetreElectricite): self
    {
        $this->PerimetreElectricite = $PerimetreElectricite;

        return $this;
    }

    public function getBudgetHTT(): ?float
    {
        return $this->budgetHTT;
    }

    public function setBudgetHTT(float $budgetHTT): self
    {
        $this->budgetHTT = $budgetHTT;

        return $this;
    }
}
