<?php

namespace App\Entity;

use App\Repository\DetailleOffreGazRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailleOffreGazRepository::class)
 */
class DetailleOffreGaz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OffreGaz::class, inversedBy="detailleOffreGazs")
     */
    private $offre;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prAbonnParMois;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prGaz;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tqa;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cee;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cta;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $budgetTTC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=BudgetGaz::class, mappedBy="DetailleOffreGaz")
     */
    private $budgetGazs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureEnMois;

    public function __construct()
    {
        $this->budgetGazs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffre(): ?OffreGaz
    {
        return $this->offre;
    }

    public function setOffre(?OffreGaz $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getPrAbonnParMois(): ?string
    {
        return $this->prAbonnParMois;
    }

    public function setPrAbonnParMois(?string $prAbonnParMois): self
    {
        $this->prAbonnParMois = $prAbonnParMois;
        return $this;
    }


    public function getPrGaz(): ?string
    {
        return $this->prGaz;
    }

    public function setPrGaz(?string $prGaz): self
    {
        $this->prGaz = $prGaz;

        return $this;
    }

    public function getTqa(): ?string
    {
        return $this->tqa;
    }

    public function setTqa(?string $tqa): self
    {
        $this->tqa = $tqa;

        return $this;
    }

    public function getCee(): ?string
    {
        return $this->cee;
    }

    public function setCee(?string $cee): self
    {
        $this->cee = $cee;

        return $this;
    }

    public function getCta(): ?string
    {
        return $this->cta;
    }

    public function setCta(?string $cta): self
    {
        $this->cta = $cta;

        return $this;
    }

    public function getBudgetTTC(): ?string
    {
        return $this->budgetTTC;
    }

    public function setBudgetTTC(?string $budgetTTC): self
    {
        $this->budgetTTC = $budgetTTC;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?string $fournisseur): self
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

    /**
     * @return Collection|BudgetGaz[]
     */
    public function getBudgetGazs(): Collection
    {
        return $this->budgetGazs;
    }

    public function addBudgetGaz(BudgetGaz $budgetGaz): self
    {
        if (!$this->budgetGazs->contains($budgetGaz)) {
            $this->budgetGazs[] = $budgetGaz;
            $budgetGaz->setDetailleOffreGaz($this);
        }

        return $this;
    }

    public function removeBudgetGaz(BudgetGaz $budgetGaz): self
    {
        if ($this->budgetGazs->removeElement($budgetGaz)) {
            // set the owning side to null (unless already changed)
            if ($budgetGaz->getDetailleOffreGaz() === $this) {
                $budgetGaz->setDetailleOffreGaz(null);
            }
        }

        return $this;
    }

    public function getDureEnMois(): ?int
    {
        return $this->dureEnMois;
    }

    public function setDureEnMois(?int $dureEnMois): self
    {
        $this->dureEnMois = $dureEnMois;

        return $this;
    }
}
