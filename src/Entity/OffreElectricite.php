<?php

namespace App\Entity;

use App\Repository\OffreElectriciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreElectriciteRepository::class)
 */
class OffreElectricite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segmentation;

    /**
     * @ORM\OneToMany(targetEntity=DetailOffreElec::class, mappedBy="offre")
     */
    private $detailOffreElecs;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="offreElectricites")
     */
    private $client;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrOffre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $fournisseur = [];

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrAccepted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrDeclined;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vue;

    public function __construct()
    {
        $this->detailOffreElecs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSegmentation(): ?string
    {
        return $this->segmentation;
    }

    public function setSegmentation(?string $segmentation): self
    {
        $this->segmentation = $segmentation;

        return $this;
    }

    /**
     * @return Collection|DetailOffreElec[]
     */
    public function getDetailOffreElecs(): Collection
    {
        return $this->detailOffreElecs;
    }

    public function addDetailOffreElec(DetailOffreElec $detailOffreElec): self
    {
        if (!$this->detailOffreElecs->contains($detailOffreElec)) {
            $this->detailOffreElecs[] = $detailOffreElec;
            $detailOffreElec->setOffre($this);
        }

        return $this;
    }

    public function removeDetailOffreElec(DetailOffreElec $detailOffreElec): self
    {
        if ($this->detailOffreElecs->removeElement($detailOffreElec)) {
            // set the owning side to null (unless already changed)
            if ($detailOffreElec->getOffre() === $this) {
                $detailOffreElec->setOffre(null);
            }
        }

        return $this;
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

    public function getNbrOffre(): ?int
    {
        return $this->nbrOffre;
    }

    public function setNbrOffre(?int $nbrOffre): self
    {
        $this->nbrOffre = $nbrOffre;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?String $status)
    {
        $this->status = $status;

        return $this;
    }

    public function getFournisseur(): ?array
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?array $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNbrAccepted(): ?int
    {
        return $this->nbrAccepted;
    }

    public function setNbrAccepted(?int $nbrAccepted): self
    {
        $this->nbrAccepted = $nbrAccepted;

        return $this;
    }

    public function getNbrDeclined(): ?int
    {
        return $this->nbrDeclined;
    }

    public function setNbrDeclined(?int $nbrDeclined): self
    {
        $this->nbrDeclined = $nbrDeclined;

        return $this;
    }

    public function getVue(): ?bool
    {
        return $this->vue;
    }

    public function setVue(?bool $vue): self
    {
        $this->vue = $vue;

        return $this;
    }
}
