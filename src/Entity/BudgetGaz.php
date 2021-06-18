<?php

namespace App\Entity;

use App\Repository\BudgetGazRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetGazRepository::class)
 */
class BudgetGaz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=DetailleOffreGaz::class, inversedBy="budgetGazs")
     */
    private $DetailleOffreGaz;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $abonnementParAn;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TermeProportionnelparAn;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TermededistributionparAn;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TotalTaxeshorsTVAparAn;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $CTAparan;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TICGNparan;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $CEEparan;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TOTALBUDGETANNUELTTCouCTRS;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $Totalsurladureducontrat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TotalTaxeshorsTVAparAnTTC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $budgetTTC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $TotalsurladureducontratenTTC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetailleOffreGaz(): ?DetailleOffreGaz
    {
        return $this->DetailleOffreGaz;
    }

    public function setDetailleOffreGaz(?DetailleOffreGaz $DetailleOffreGaz): self
    {
        $this->DetailleOffreGaz = $DetailleOffreGaz;

        return $this;
    }

    public function getAbonnementParAn(): ?float
    {
        return $this->abonnementParAn;
    }

    public function setAbonnementParAn(?float $abonnementParAn): self
    {
        $this->abonnementParAn = $abonnementParAn;

        return $this;
    }

    public function getTermeProportionnelparAn(): ?float
    {
        return $this->TermeProportionnelparAn;
    }

    public function setTermeProportionnelparAn(?float $TermeProportionnelparAn): self
    {
        $this->TermeProportionnelparAn = $TermeProportionnelparAn;

        return $this;
    }

    public function getTermededistributionparAn(): ?float
    {
        return $this->TermededistributionparAn;
    }

    public function setTermededistributionparAn(?float $TermededistributionparAn): self
    {
        $this->TermededistributionparAn = $TermededistributionparAn;

        return $this;
    }

    public function getTotalTaxeshorsTVAparAn(): ?float
    {
        return $this->TotalTaxeshorsTVAparAn;
    }

    public function setTotalTaxeshorsTVAparAn(?float $TotalTaxeshorsTVAparAn): self
    {
        $this->TotalTaxeshorsTVAparAn = $TotalTaxeshorsTVAparAn;

        return $this;
    }

    public function getCTAparan(): ?float
    {
        return $this->CTAparan;
    }

    public function setCTAparan(?float $CTAparan): self
    {
        $this->CTAparan = $CTAparan;

        return $this;
    }

    public function getTICGNparan(): ?float
    {
        return $this->TICGNparan;
    }

    public function setTICGNparan(?float $TICGNparan): self
    {
        $this->TICGNparan = $TICGNparan;

        return $this;
    }

    public function getCEEparan(): ?float
    {
        return $this->CEEparan;
    }

    public function setCEEparan(?float $CEEparan): self
    {
        $this->CEEparan = $CEEparan;

        return $this;
    }

    public function getTOTALBUDGETANNUELTTCouCTRS(): ?float
    {
        return $this->TOTALBUDGETANNUELTTCouCTRS;
    }

    public function setTOTALBUDGETANNUELTTCouCTRS(?float $TOTALBUDGETANNUELTTCouCTRS): self
    {
        $this->TOTALBUDGETANNUELTTCouCTRS = $TOTALBUDGETANNUELTTCouCTRS;

        return $this;
    }

    public function getTotalsurladureducontrat(): ?float
    {
        return $this->Totalsurladureducontrat;
    }

    public function setTotalsurladureducontrat(?float $Totalsurladureducontrat): self
    {
        $this->Totalsurladureducontrat = $Totalsurladureducontrat;

        return $this;
    }

    public function getTotalTaxeshorsTVAparAnTTC(): ?float
    {
        return $this->TotalTaxeshorsTVAparAnTTC;
    }

    public function setTotalTaxeshorsTVAparAnTTC(?float $TotalTaxeshorsTVAparAnTTC): self
    {
        $this->TotalTaxeshorsTVAparAnTTC = $TotalTaxeshorsTVAparAnTTC;

        return $this;
    }

    public function getBudgetTTC(): ?float
    {
        return $this->budgetTTC;
    }

    public function setBudgetTTC(?float $budgetTTC): self
    {
        $this->budgetTTC = $budgetTTC;

        return $this;
    }

    public function getTotalsurladureducontratenTTC(): ?float
    {
        return $this->TotalsurladureducontratenTTC;
    }

    public function setTotalsurladureducontratenTTC(?float $TotalsurladureducontratenTTC): self
    {
        $this->TotalsurladureducontratenTTC = $TotalsurladureducontratenTTC;

        return $this;
    }
}
