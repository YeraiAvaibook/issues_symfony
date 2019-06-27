<?php


namespace App\Managers;


use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;

class CategoriaManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function newObject(): Categoria
    {
        $categoria = new Categoria();

        return $categoria;
    }

    public function create($categoria): Categoria
    {
        $this->entityManager->persist($categoria);
        $this->entityManager->flush();

        return $categoria;
    }

    public function update($categoria)
    {
        $this->entityManager->flush();
    }

    public function delete($categoria)
    {
        $this->entityManager->remove($categoria);
        $this->entityManager->flush();
    }
}