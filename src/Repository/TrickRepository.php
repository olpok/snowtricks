<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    /**
     * Returns all Tricks per page
     * @return void 
     */
    public function getPaginatedTricks($page, $limit){
        $query = $this->createQueryBuilder('t')
           // ->where('a.active = 1')
            ;

        // On filtre les données
       // if($filters != null){
          //  $query->andWhere('a.categories IN(:cats)')
          //      ->setParameter(':cats', array_values($filters));
       // }

        $query->orderBy('t.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns all Tricks less displayed allready per page
     * @return void 
     */
    public function getLoadMoreTricks($page, $limit){
        $query = $this->createQueryBuilder('t');

        $query->orderBy('t.createdAt', 'DESC')
            ->setFirstResult($page* $limit )
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of Tricks
     * @return void 
     */
    public function getTotalTricks($filters = null){
        $query = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            //->where('a.active = 1')
            ;
        // On filtre les données
       /* if($filters != null){
            $query->andWhere('a.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }*/
       // return single scalar value(not arrays nor objects)
        return $query->getQuery()->getSingleScalarResult();
    }

/*
    public function findByIdThenReturnArray($id){
    $query = $this->getEntityManager()
        ->createQuery("SELECT e FROM YourOwnBundle:Entity e WHERE e.id = :id")
        ->setParameter('id', $id);
    return $query->getArrayResult();
}*/

    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
