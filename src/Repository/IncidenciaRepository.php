<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Incidencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incidencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidencia[]    findAll()
 * @method Incidencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incidencia::class);
    }

    // /**
    //  * @return Incidencia[] Returns an array of Incidencia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Incidencia
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByTitleAndCategory(Categoria $categoria, $titulo)
    {
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->orderBy('i.titulo');

        if($titulo != ''){
            $query->andWhere('i.titulo = :titulo')
                ->setParameter('titulo', $titulo);
        }

        return $query->getQuery()->getResult();

    }

}
