<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpeningstijdenRepository")
 */
class Openingstijden
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dag;

    /**
     * @ORM\Column(type="time")
     */
    private $opening;

    /**
     * @ORM\Column(type="time")
     */
    private $sluiting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDag(): ?string
    {
        return $this->dag;
    }

    public function setDag(string $dag): self
    {
        $this->dag = $dag;

        return $this;
    }

    public function getOpening(): ?\DateTimeInterface
    {
        return $this->opening;
    }

    public function setOpening(\DateTimeInterface $opening): self
    {
        $this->opening = $opening;

        return $this;
    }

    public function getSluiting(): ?\DateTimeInterface
    {
        return $this->sluiting;
    }

    public function setSluiting(\DateTimeInterface $sluiting): self
    {
        $this->sluiting = $sluiting;

        return $this;
    }
}
