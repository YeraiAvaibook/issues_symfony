<?php


namespace App\Services;


use Symfony\Component\Security\Core\Security;

class SecurityService
{

	private $user;

	public function __construct(Security $security)
	{
		$this->user = $security->getUser();
	}

	public function getUser()
	{
		return $this->user;
	}

}