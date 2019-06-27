<?php


namespace App\Security;


use App\Entity\Incidencia;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class IncidenciaVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

	protected function supports($attribute, $subject)
	{

	    if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE]))
	        return false;

	    if (!$subject instanceof Incidencia)
	        return false;

	    return true;

	}

	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{

	    $user = $token->getUser();

	    if (!$user instanceof User)
	        return false;

	    $incidencia = $subject;

	    if ($this->security->isGranted('ROLE_ADMIN'))
	        return true;

	    switch ($attribute) {

            case self::VIEW:
                return $this->canView($incidencia, $user);
                break;

            case self::EDIT:
                return $this->canEdit($incidencia, $user);
                break;

            case self::DELETE:
                return $this->canDelete($incidencia, $user);
                break;
        }

        throw new \LogicException('This code should not be reached!');

	}

	private function canView(Incidencia $incidencia,User $user)
    {

        if ($incidencia->getUser()->getId() == $user->getId())
            return true;
        else
            return false;

    }

    private function canEdit(Incidencia $incidencia,User $user)
    {

        if ($incidencia->getUser()->getId() == $user->getId())
            return true;
        else
            return false;

    }

    private function canDelete(Incidencia $incidencia,User $user)
    {

        if ($incidencia->getUser()->getId() == $user->getId())
            return true;
        else
            return false;

    }
}