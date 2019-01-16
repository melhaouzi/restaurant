<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestelRegelRepository")
 */
class BestelRegel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bestelling", inversedBy="bestelRegels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bestelling;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gerecht")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gerecht;

    /**
     * @ORM\Column(type="integer")
     */
    private $aantal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBestelling(): ?Bestelling
    {
        return $this->bestelling;
    }

    public function setBestelling(?Bestelling $bestelling): self
    {
        $this->bestelling = $bestelling;

        return $this;
    }

    public function getGerecht(): ?Gerecht
    {
        return $this->gerecht;
    }

    public function setGerecht(?Gerecht $gerecht): self
    {
        $this->gerecht = $gerecht;

        return $this;
    }

    public function getAantal(): ?int
    {
        return $this->aantal;
    }

    public function setAantal(int $aantal): self
    {
        $this->aantal = $aantal;

        return $this;
    }
}
