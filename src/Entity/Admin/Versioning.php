<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\VersioningRepository")
 */
class Versioning {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $repository;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $password;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Admin\User", mappedBy="versioning")
	 */
	private $users;

	public function __construct() {
		$this->users = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getRepository() :  ? string {
		return $this->repository;
	}

	public function setRepository(string $repository) : self{
		$this->repository = $repository;

		return $this;
	}

	public function getUsername():  ? string {
		return $this->username;
	}

	public function setUsername(string $username) : self{
		$this->username = $username;

		return $this;
	}

	public function getPassword():  ? string {
		return $this->password;
	}

	public function setPassword(string $password) : self{
		$this->password = $password;

		return $this;
	}

	public function __toString() {
		return $this->getSoftware()->getLibelle();
	}

	/**
	 * @return Collection|User[]
	 */
	public function getUsers(): Collection {
		return $this->users;
	}

	public function addUser(User $user): self {
		if (!$this->users->contains($user)) {
			$this->users[] = $user;
			$user->setVersioning($this);
		}

		return $this;
	}

	public function removeUser(User $user): self {
		if ($this->users->contains($user)) {
			$this->users->removeElement($user);
			// set the owning side to null (unless already changed)
			if ($user->getVersioning() === $this) {
				$user->setVersioning(null);
			}
		}

		return $this;
	}
}
