<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TafelRepository")
 */
class Tafel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $personen;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonen(): ?int
    {
        return $this->personen;
    }

    public function setPersonen(int $personen): self
    {
        $this->personen = $personen;

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
    public function __toString() {
	    return $this->getNaam() . ' (' . $this->getPersonen() . ' personen)';
    }
}
