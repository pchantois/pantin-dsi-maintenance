<?php

namespace App\Entity\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Application\EditorRepository")
 */
class Editor {
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
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $chapo;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Application\Software", mappedBy="editor")
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

	public function getDescription():  ? string {
		return $this->description;
	}

	public function setDescription( ? string $description) : self{
		$this->description = $description;

		return $this;
	}

	public function getChapo() :  ? string {
		return $this->chapo;
	}

	public function setChapo( ? string $chapo) : self{
		$this->chapo = $chapo;

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
			$software->setEditor($this);
		}

		return $this;
	}

	public function removeSoftware(Software $software): self {
		if ($this->softwares->contains($software)) {
			$this->softwares->removeElement($software);
			// set the owning side to null (unless already changed)
			if ($software->getEditor() === $this) {
				$software->setEditor(null);
			}
		}

		return $this;
	}

	public function __toString(): string {
		return $this->getLibelle();
	}
}
