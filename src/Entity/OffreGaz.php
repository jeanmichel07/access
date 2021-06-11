<?php

namespace App\Entity;

use App\Repository\OffreGazRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreGazRepository::class)
 */
class OffreGaz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=DetailleOffreGaz::class, mappedBy="offre")
     */
    private $detailleOffreGazs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrOffre;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="offreGazs")
     */
    private $client;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profil;

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

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $dureeEnMois = [];

    public function __construct()
    {
        $this->detailleOffreGazs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|DetailleOffreGaz[]
     */
    public function getDetailleOffreGazs(): Collection
    {
        return $this->detailleOffreGazs;
    }

    public function addDetailleOffreGaz(DetailleOffreGaz $detailleOffreGaz): self
    {
        if (!$this->detailleOffreGazs->contains($detailleOffreGaz)) {
            $this->detailleOffreGazs[] = $detailleOffreGaz;
            $detailleOffreGaz->setOffre($this);
        }

        return $this;
    }

    public function removeDetailleOffreGaz(DetailleOffreGaz $detailleOffreGaz): self
    {
        if ($this->detailleOffreGazs->removeElement($detailleOffreGaz)) {
            // set the owning side to null (unless already changed)
            if ($detailleOffreGaz->getOffre() === $this) {
                $detailleOffreGaz->setOffre(null);
            }
        }

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
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

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(?string $profil): self
    {
        $this->profil = $profil;

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

    public function getDureeEnMois(): ?array
    {
        return $this->dureeEnMois;
    }

    public function setDureeEnMois(?array $dureeEnMois): self
    {
        $this->dureeEnMois = $dureeEnMois;

        return $this;
    }
}
