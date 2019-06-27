<?php


namespace App\Managers;


use App\Entity\Tag;
use App\Interfaces\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class TagManager implements ManagerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function newObject(): Tag
    {
        $tag = new Tag();

        return $tag;
    }

    public function create($tag): Tag
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag;
    }

    public function update($tag)
    {
        $this->entityManager->flush();
    }

    public function delete($tag)
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}