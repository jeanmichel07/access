<?php

namespace App\Entity;

use App\Repository\SegmentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SegmentationRepository::class)
 */
class Segmentation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=CompComptage::class, mappedBy="segmentation")
     */
    private $compComptages;

    /**
     * @ORM\OneToMany(targetEntity=CompGestion::class, mappedBy="segmentation")
     */
    private $compGestions;

    /**
     * @ORM\OneToMany(targetEntity=CompSoustiragePartFixe::class, mappedBy="segmentation")
     */
    private $compSoustiragePartFixes;

    /**
     * @ORM\OneToMany(targetEntity=CompSoustiragePartVariable::class, mappedBy="segmentation")
     */
    private $compSoustiragePartVariables;

    /**
     * @ORM\OneToMany(targetEntity=PerimetreElectricite::class, mappedBy="segmentation")
     */
    private $perimetreElectricites;

    public function __construct()
    {
        $this->compComptages = new ArrayCollection();
        $this->compGestions = new ArrayCollection();
        $this->compSoustiragePartFixes = new ArrayCollection();
        $this->compSoustiragePartVariables = new ArrayCollection();
        $this->perimetreElectricites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|CompComptage[]
     */
    public function getCompComptages(): Collection
    {
        return $this->compComptages;
    }

    public function addCompComptage(CompComptage $compComptage): self
    {
        if (!$this->compComptages->contains($compComptage)) {
            $this->compComptages[] = $compComptage;
            $compComptage->setSegmentation($this);
        }

        return $this;
    }

    public function removeCompComptage(CompComptage $compComptage): self
    {
        if ($this->compComptages->removeElement($compComptage)) {
            // set the owning side to null (unless already changed)
            if ($compComptage->getSegmentation() === $this) {
                $compComptage->setSegmentation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompGestion[]
     */
    public function getCompGestions(): Collection
    {
        return $this->compGestions;
    }

    public function addCompGestion(CompGestion $compGestion): self
    {
        if (!$this->compGestions->contains($compGestion)) {
            $this->compGestions[] = $compGestion;
            $compGestion->setSegmentation($this);
        }

        return $this;
    }

    public function removeCompGestion(CompGestion $compGestion): self
    {
        if ($this->compGestions->removeElement($compGestion)) {
            // set the owning side to null (unless already changed)
            if ($compGestion->getSegmentation() === $this) {
                $compGestion->setSegmentation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompSoustiragePartFixe[]
     */
    public function getCompSoustiragePartFixes(): Collection
    {
        return $this->compSoustiragePartFixes;
    }

    public function addCompSoustiragePartFix(CompSoustiragePartFixe $compSoustiragePartFix): self
    {
        if (!$this->compSoustiragePartFixes->contains($compSoustiragePartFix)) {
            $this->compSoustiragePartFixes[] = $compSoustiragePartFix;
            $compSoustiragePartFix->setSegmentation($this);
        }

        return $this;
    }

    public function removeCompSoustiragePartFix(CompSoustiragePartFixe $compSoustiragePartFix): self
    {
        if ($this->compSoustiragePartFixes->removeElement($compSoustiragePartFix)) {
            // set the owning side to null (unless already changed)
            if ($compSoustiragePartFix->getSegmentation() === $this) {
                $compSoustiragePartFix->setSegmentation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompSoustiragePartVariable[]
     */
    public function getCompSoustiragePartVariables(): Collection
    {
        return $this->compSoustiragePartVariables;
    }

    public function addCompSoustiragePartVariable(CompSoustiragePartVariable $compSoustiragePartVariable): self
    {
        if (!$this->compSoustiragePartVariables->contains($compSoustiragePartVariable)) {
            $this->compSoustiragePartVariables[] = $compSoustiragePartVariable;
            $compSoustiragePartVariable->setSegmentation($this);
        }

        return $this;
    }

    public function removeCompSoustiragePartVariable(CompSoustiragePartVariable $compSoustiragePartVariable): self
    {
        if ($this->compSoustiragePartVariables->removeElement($compSoustiragePartVariable)) {
            // set the owning side to null (unless already changed)
            if ($compSoustiragePartVariable->getSegmentation() === $this) {
                $compSoustiragePartVariable->setSegmentation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PerimetreElectricite[]
     */
    public function getPerimetreElectricites(): Collection
    {
        return $this->perimetreElectricites;
    }

    public function addPerimetreElectricite(PerimetreElectricite $perimetreElectricite): self
    {
        if (!$this->perimetreElectricites->contains($perimetreElectricite)) {
            $this->perimetreElectricites[] = $perimetreElectricite;
            $perimetreElectricite->setSegmentation($this);
        }

        return $this;
    }

    public function removePerimetreElectricite(PerimetreElectricite $perimetreElectricite): self
    {
        if ($this->perimetreElectricites->removeElement($perimetreElectricite)) {
            // set the owning side to null (unless already changed)
            if ($perimetreElectricite->getSegmentation() === $this) {
                $perimetreElectricite->setSegmentation(null);
            }
        }

        return $this;
    }
    public function __toString() :string
    {
        return $this->nom;
    }
}
