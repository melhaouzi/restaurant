<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestellingRepository")
 */
class Bestelling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservering", inversedBy="bestellingen")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reservering;

	/**
	 * @ORM\Column(name="datum", type="datetime")
	 */
	private $datum;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BestelRegel", mappedBy="bestelling")
     */
    private $bestelRegels;

    public function __construct()
    {
        $this->bestelRegels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservering(): ?Reservering
    {
        return $this->reservering;
    }

    public function setReservering(?Reservering $reservering): self
    {
        $this->reservering = $reservering;

        return $this;
    }

    /**
     * @return Collection|BestelRegel[]
     */
    public function getBestelRegels(): Collection
    {
        return $this->bestelRegels;
    }

    public function addBestelRegel(BestelRegel $bestelRegel): self
    {
        if (!$this->bestelRegels->contains($bestelRegel)) {
            $this->bestelRegels[] = $bestelRegel;
            $bestelRegel->setBestelling($this);
        }

        return $this;
    }

    public function removeBestelRegel(BestelRegel $bestelRegel): self
    {
        if ($this->bestelRegels->contains($bestelRegel)) {
            $this->bestelRegels->removeElement($bestelRegel);
            // set the owning side to null (unless already changed)
            if ($bestelRegel->getBestelling() === $this) {
                $bestelRegel->setBestelling(null);
            }
        }

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }
}
