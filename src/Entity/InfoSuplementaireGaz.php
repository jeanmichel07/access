<?php

namespace App\Entity;

use App\Repository\InfoSuplementaireGazRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfoSuplementaireGazRepository::class)
 */
class InfoSuplementaireGaz
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
    private $cal24;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cal22;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cal23;

    /**
     * @ORM\OneToOne(targetEntity=OffreGaz::class, cascade={"persist", "remove"})
     */
    private $OffreGaz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCal24(): ?string
    {
        return $this->cal24;
    }

    public function setCal24(?string $cal24): self
    {
        $this->cal24 = $cal24;

        return $this;
    }

    public function getCal22(): ?string
    {
        return $this->cal22;
    }

    public function setCal22(?string $cal22): self
    {
        $this->cal22 = $cal22;

        return $this;
    }

    public function getCal23(): ?string
    {
        return $this->cal23;
    }

    public function setCal23(?string $cal23): self
    {
        $this->cal23 = $cal23;

        return $this;
    }

    public function getOffreGaz(): ?OffreGaz
    {
        return $this->OffreGaz;
    }

    public function setOffreGaz(?OffreGaz $OffreGaz): self
    {
        $this->OffreGaz = $OffreGaz;

        return $this;
    }
}
