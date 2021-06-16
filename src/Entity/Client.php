<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client implements UserInterface
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
    private $raisonSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSignataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomSignataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonctionSignataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=PerimetreElectricite::class, mappedBy="client")
     */
    private $perimetreElectricites;

    /**
     * @ORM\OneToMany(targetEntity=PermetreGaz::class, mappedBy="client")
     */
    private $permetreGazs;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeur::class, inversedBy="clients")
     */
    private $vendeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrSiteElec;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrSiteGaz;

    /**
     * @ORM\OneToMany(targetEntity=OffreElectricite::class, mappedBy="client")
     */
    private $offreElectricites;

    /**
     * @ORM\OneToMany(targetEntity=OffreGaz::class, mappedBy="client")
     */
    private $offreGazs;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Objectif::class, mappedBy="user")
     */
    private $objectifs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    public function __construct()
    {
        $this->perimetreElectricites = new ArrayCollection();
        $this->permetreGazs = new ArrayCollection();
        $this->offreElectricites = new ArrayCollection();
        $this->offreGazs = new ArrayCollection();
        $this->objectifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raisonSocial;
    }

    public function setRaisonSocial(?string $raisonSocial): self
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    public function getNomSignataire(): ?string
    {
        return $this->nomSignataire;
    }

    public function setNomSignataire(?string $nomSignataire): self
    {
        $this->nomSignataire = $nomSignataire;

        return $this;
    }

    public function getPrenomSignataire(): ?string
    {
        return $this->prenomSignataire;
    }

    public function setPrenomSignataire(?string $prenomSignataire): self
    {
        $this->prenomSignataire = $prenomSignataire;

        return $this;
    }

    public function getFonctionSignataire(): ?string
    {
        return $this->fonctionSignataire;
    }

    public function setFonctionSignataire(?string $fonctionSignataire): self
    {
        $this->fonctionSignataire = $fonctionSignataire;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_CLIENT';

        return array_unique($roles);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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
            $perimetreElectricite->setClient($this);
        }

        return $this;
    }

    public function removePerimetreElectricite(PerimetreElectricite $perimetreElectricite): self
    {
        if ($this->perimetreElectricites->removeElement($perimetreElectricite)) {
            // set the owning side to null (unless already changed)
            if ($perimetreElectricite->getClient() === $this) {
                $perimetreElectricite->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PermetreGaz[]
     */
    public function getPermetreGazs(): Collection
    {
        return $this->permetreGazs;
    }

    public function addPermetreGaz(PermetreGaz $permetreGaz): self
    {
        if (!$this->permetreGazs->contains($permetreGaz)) {
            $this->permetreGazs[] = $permetreGaz;
            $permetreGaz->setClient($this);
        }

        return $this;
    }

    public function removePermetreGaz(PermetreGaz $permetreGaz): self
    {
        if ($this->permetreGazs->removeElement($permetreGaz)) {
            // set the owning side to null (unless already changed)
            if ($permetreGaz->getClient() === $this) {
                $permetreGaz->setClient(null);
            }
        }

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getNbrSiteElec(): ?int
    {
        return $this->nbrSiteElec;
    }

    public function setNbrSiteElec(?int $nbrSiteElec): self
    {
        $this->nbrSiteElec = $nbrSiteElec;

        return $this;
    }

    public function getNbrSiteGaz(): ?int
    {
        return $this->nbrSiteGaz;
    }

    public function setNbrSiteGaz(?int $nbrSiteGaz): self
    {
        $this->nbrSiteGaz = $nbrSiteGaz;

        return $this;
    }

    /**
     * @return Collection|OffreElectricite[]
     */
    public function getOffreElectricites(): Collection
    {
        return $this->offreElectricites;
    }

    public function addOffreElectricite(OffreElectricite $offreElectricite): self
    {
        if (!$this->offreElectricites->contains($offreElectricite)) {
            $this->offreElectricites[] = $offreElectricite;
            $offreElectricite->setClient($this);
        }

        return $this;
    }

    public function removeOffreElectricite(OffreElectricite $offreElectricite): self
    {
        if ($this->offreElectricites->removeElement($offreElectricite)) {
            // set the owning side to null (unless already changed)
            if ($offreElectricite->getClient() === $this) {
                $offreElectricite->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OffreGaz[]
     */
    public function getOffreGazs(): Collection
    {
        return $this->offreGazs;
    }

    public function addOffreGaz(OffreGaz $offreGaz): self
    {
        if (!$this->offreGazs->contains($offreGaz)) {
            $this->offreGazs[] = $offreGaz;
            $offreGaz->setClient($this);
        }

        return $this;
    }

    public function removeOffreGaz(OffreGaz $offreGaz): self
    {
        if ($this->offreGazs->removeElement($offreGaz)) {
            // set the owning side to null (unless already changed)
            if ($offreGaz->getClient() === $this) {
                $offreGaz->setClient(null);
            }
        }

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
     * @return Collection|Objectif[]
     */
    public function getObjectifs(): Collection
    {
        return $this->objectifs;
    }

    public function addObjectif(Objectif $objectif): self
    {
        if (!$this->objectifs->contains($objectif)) {
            $this->objectifs[] = $objectif;
            $objectif->setUser($this);
        }

        return $this;
    }

    public function removeObjectif(Objectif $objectif): self
    {
        if ($this->objectifs->removeElement($objectif)) {
            // set the owning side to null (unless already changed)
            if ($objectif->getUser() === $this) {
                $objectif->setUser(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->raisonSocial;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
