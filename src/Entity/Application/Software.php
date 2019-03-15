<?php

namespace App\Entity\Application;

use App\Entity\Admin\Computer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Application\SoftwareRepository")
 */
class Software {
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
	 * @ORM\ManyToOne(targetEntity="App\Entity\Application\Editor", inversedBy="softwares")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $editor;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Admin\Computer", inversedBy="softwares")
	 */
	private $machines;

	public function __construct() {
		$this->machines = new ArrayCollection();
		$this->versionings = new ArrayCollection();
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

	public function getEditor():  ? Editor {
		return $this->editor;
	}

	public function setEditor( ? Editor $editor) : self{
		$this->editor = $editor;

		return $this;
	}

	/**
	 * @return Collection|Computer[]
	 */
	public function getMachines() : Collection {
		return $this->machines;
	}

	public function addMachine(Computer $machine): self {
		if (!$this->machines->contains($machine)) {
			$this->machines[] = $machine;
		}

		return $this;
	}

	public function removeMachine(Computer $machine): self {
		if ($this->machines->contains($machine)) {
			$this->machines->removeElement($machine);
		}

		return $this;
	}

	public function __toString() {
		return $this->getLibelle();
	}
}
