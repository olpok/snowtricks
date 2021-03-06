<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * Returns all Comments per page
     * @return void 
     */
    public function getPaginatedComments($page, $limit, $trick){
        return $this->createQueryBuilder('c')
            ->where('c.trick = :trick' )
            ->setParameter('trick', $trick)
            ->orderBy('c.created_at', 'DESC') 
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
        ;
        
    } 

    /**
     * Returns all Comments less displayed per page
     * @return void 
     */
    public function getLoadMoreComments($page, $limitlm, $trick){
        return $this->createQueryBuilder('c')
            ->where('c.trick = :trick' )
            ->setParameter('trick', $trick)
            ->orderBy('c.created_at', 'DESC') 
            ->setFirstResult(($page * $limitlm) +2)
            ->setMaxResults($limitlm)
            ->getQuery()
            ->getResult()
            ;
        ;       
    }

    /**
     * Returns showed Comments // per page
     * @return void 
     */
    public function getShowedComments($page, $limitShowed, $trick){
        return $this->createQueryBuilder('c')
            ->where('c.trick = :trick' )
            ->setParameter('trick', $trick)
            ->orderBy('c.created_at', 'DESC') 
            ->setFirstResult(($page * $limitShowed) - $limitShowed)
            ->setMaxResults($limitShowed)
            ->getQuery()
            ->getResult()
            ;
        ;
        
    } 

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
