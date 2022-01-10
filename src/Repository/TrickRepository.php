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
     * 
     */
    public function findAllDetails(): array
    {

         return $this->findBy(array());
   // return $this->findBy(array(), array('username' => 'ASC'));

      /*  return $this->createQueryBuilder('t')
                ->getQuery()
                //$result = $query->getResult(Query::HYDRATE_ARRAY);
                //->setMaxResults(4)
                ->getResult() ;*/

           // $this->hydratePicture($properties);
           //$tricksn = $query->getArrayResult();
           // dd(tricks);

           // return $tricks;
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
