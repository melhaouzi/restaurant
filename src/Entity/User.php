<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservering", mappedBy="klant")
     */
    private $reserveringen;

	public function __construct()
                        	{
                        		parent::__construct();
                          $this->reserveringen = new ArrayCollection();
                        		// your own logic
                        	}

    /**
     * @return Collection|Reservering[]
     */
    public function getReserveringen(): Collection
    {
        return $this->reserveringen;
    }

    public function addReserveringen(Reservering $reserveringen): self
    {
        if (!$this->reserveringen->contains($reserveringen)) {
            $this->reserveringen[] = $reserveringen;
            $reserveringen->setKlant($this);
        }

        return $this;
    }

    public function removeReserveringen(Reservering $reserveringen): self
    {
        if ($this->reserveringen->contains($reserveringen)) {
            $this->reserveringen->removeElement($reserveringen);
            // set the owning side to null (unless already changed)
            if ($reserveringen->getKlant() === $this) {
                $reserveringen->setKlant(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}