<?php


namespace App\Security;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class IncidenciaVoter extends Voter
{

	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

	protected function supports($attribute, $subject)
	{
		// TODO: Implement supports() method.
	}

	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{
		// TODO: Implement voteOnAttribute() method.
	}
}