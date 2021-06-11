<?php

namespace App\Entity;

use App\Repository\CompGestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompGestionRepository::class)
 */
class CompGestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Segmentation::class, inversedBy="compGestions")
     */
    private $segmentation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $value;

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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
