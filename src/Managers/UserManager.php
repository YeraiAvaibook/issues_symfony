<?php


namespace App\Managers;


use App\Entity\User;
use App\Interfaces\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserManager implements ManagerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function newObject(): User
    {
        $user = new User();

        return $user;
    }

    public function create($user): User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update($user)
    {
        $this->entityManager->flush();
    }

    public function delete($user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}