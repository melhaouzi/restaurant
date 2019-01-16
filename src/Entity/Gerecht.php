<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GerechtRepository")
 */
class Gerecht
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GerechtType")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beschrijving;

    /**
     * @ORM\Column(type="float")
     */
    private $prijs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Btw")
     * @ORM\JoinColumn(nullable=false)
     */
    private $btw;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?GerechtType
    {
        return $this->type;
    }

    public function setType(?GerechtType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getPrijs(): ?float
    {
        return $this->prijs;
    }

    public function setPrijs(float $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    public function getBtw(): ?Btw
    {
        return $this->btw;
    }

    public function setBtw(?Btw $btw): self
    {
        $this->btw = $btw;

        return $this;
    }
}
