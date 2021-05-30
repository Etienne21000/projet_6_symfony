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
    private $manager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
        $this->manager = $this->getEntityManager();
    }

    /**
     * @param int $id
     * @param int|null $status
     * @return array
     */
    public function get_comments(int $id, int $status = null):array
    {
        $db = $this->manager->createQueryBuilder();
        $db
            ->select('c')
            ->from('App\Entity\Comment', 'c')
            ->innerJoin('c.user', 'u')
            ->where('c.post_id = :id')
            ->setParameter('id', $id);

        if($status !== null){
            $db->andWhere('c.status = '.$status);
        }

        $resp = $db->getQuery();

        return $resp->execute();
    }

    /**
     * @param int|null $status
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function count_comments(int $status = null)
    {
        $db = $this->manager->createQueryBuilder();
        $db
            ->select('count(c.id)')
            ->from('App\Entity\Comment', 'c');

        if($status !== null) {
            $db->where('c.status = '.$status);
        }

        $resp = $db->getQuery();

        return $resp->getSingleScalarResult();
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
