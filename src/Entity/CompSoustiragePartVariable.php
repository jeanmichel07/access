<?php

namespace App\Entity;

use App\Repository\CompSoustiragePartVariableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompSoustiragePartVariableRepository::class)
 */
class CompSoustiragePartVariable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Segmentation::class, inversedBy="compSoustiragePartVariables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $segmentation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hph;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hch;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hpe;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hce;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPte(): ?float
    {
        return $this->pte;
    }

    public function setPte(?float $pte): self
    {
        $this->pte = $pte;

        return $this;
    }

    public function getHph(): ?float
    {
        return $this->hph;
    }

    public function setHph(?float $hph): self
    {
        $this->hph = $hph;

        return $this;
    }

    public function getHch(): ?float
    {
        return $this->hch;
    }

    public function setHch(?float $hch): self
    {
        $this->hch = $hch;

        return $this;
    }

    public function getHpe(): ?float
    {
        return $this->hpe;
    }

    public function setHpe(?float $hpe): self
    {
        $this->hpe = $hpe;

        return $this;
    }

    public function getHce(): ?float
    {
        return $this->hce;
    }

    public function setHce(?float $hce): self
    {
        $this->hce = $hce;

        return $this;
    }
}
