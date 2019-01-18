<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReserveringRepository")
 */
class Reservering {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(name="klant",type="string",length=100)
	 */
	private $klant;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $datum;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $aantal_personen;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Bestelling", mappedBy="reservering")
	 */
	private $bestellingen;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Tafel")
	 */
	private $tafels;

	public function __construct() {
		$this->bestellingen = new ArrayCollection();
		$this->tafels       = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getKlant() {
		return $this->klant;
	}

	public function setKlant( $klant ): self {
		$this->klant = $klant;

		return $this;
	}

	public function getDatum(): ?\DateTimeInterface {
		return $this->datum;
	}

	public function setDatum( \DateTimeInterface $datum ): self {
		$this->datum = $datum;

		return $this;
	}

	public function getAantalPersonen(): ?int {
		return $this->aantal_personen;
	}

	public function setAantalPersonen( int $aantal_personen ): self {
		$this->aantal_personen = $aantal_personen;

		return $this;
	}

	/**
	 * @return Collection|Bestelling[]
	 */
	public function getBestellingen(): Collection {
		return $this->bestellingen;
	}

	public function addBestellingen( Bestelling $bestellingen ): self {
		if ( ! $this->bestellingen->contains( $bestellingen ) ) {
			$this->bestellingen[] = $bestellingen;
			$bestellingen->setReservering( $this );
		}

		return $this;
	}

	public function removeBestellingen( Bestelling $bestellingen ): self {
		if ( $this->bestellingen->contains( $bestellingen ) ) {
			$this->bestellingen->removeElement( $bestellingen );
			// set the owning side to null (unless already changed)
			if ( $bestellingen->getReservering() === $this ) {
				$bestellingen->setReservering( null );
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Tafel[]
	 */
	public function getTafels(): Collection {
		return $this->tafels;
	}

	public function addTafel( Tafel $tafel ): self {
		if ( ! $this->tafels->contains( $tafel ) ) {
			$this->tafels[] = $tafel;
		}

		return $this;
	}

	public function removeTafel( Tafel $tafel ): self {
		if ( $this->tafels->contains( $tafel ) ) {
			$this->tafels->removeElement( $tafel );
		}

		return $this;
	}

	public function __toString() {
		return $this->getKlant() .
		       ' -> ' . $this->getDatum()->format( 'd M Y H:i' ) .
		       ' -> '. implode(', ', $this->getTafels()->getValues()) .'';
	}
}
