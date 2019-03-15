<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Versioning", inversedBy="users")
	 */
	private $versioning;

	public function __construct() {
		parent::__construct();
		$this->profils = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getVersioning() :  ? Versioning {
		return $this->versioning;
	}

	public function setVersioning( ? Versioning $versioning) : self{
		$this->versioning = $versioning;

		return $this;
	}
}
