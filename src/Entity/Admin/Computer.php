<?php

namespace App\Entity\Admin;

use App\Entity\Application\Software;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ComputerRepository")
 */
class Computer {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $libelle;

	/**
	 * @ORM\Column(type="string", length=15, nullable=true)
	 */
	private $ip;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $type;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $os;

	/**
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	private $environnement;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Application\Software", mappedBy="machines")
	 */
	private $softwares;

	public function __construct() {
		$this->softwares = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getLibelle() :  ? string {
		return $this->libelle;
	}

	public function setLibelle(string $libelle) : self{
		$this->libelle = $libelle;

		return $this;
	}

	public function getIp():  ? string {
		return $this->ip;
	}

	public function setIp( ? string $ip) : self{
		$this->ip = $ip;

		return $this;
	}

	public function getType() :  ? string {
		return $this->type;
	}

	public function setType(string $type) : self{
		$this->type = $type;

		return $this;
	}

	public function getOs():  ? string {
		return $this->os;
	}

	public function setOs(string $os) : self{
		$this->os = $os;

		return $this;
	}

	public function getEnvironnement():  ? string {
		return $this->environnement;
	}

	public function setEnvironnement( ? string $environnement) : self{
		$this->environnement = $environnement;

		return $this;
	}

	/**
	 * @return Collection|Software[]
	 */
	public function getSoftwares() : Collection {
		return $this->softwares;
	}

	public function addSoftware(Software $software): self {
		if (!$this->softwares->contains($software)) {
			$this->softwares[] = $software;
			$software->addMachine($this);
		}

		return $this;
	}

	public function removeSoftware(Software $software): self {
		if ($this->softwares->contains($software)) {
			$this->softwares->removeElement($software);
			$software->removeMachine($this);
		}

		return $this;
	}

	public function __toString(): string {
		return $this->getLibelle();
	}
}
