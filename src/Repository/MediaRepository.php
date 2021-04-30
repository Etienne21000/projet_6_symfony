<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function get_media(int $id):array
    {
        $manager = $this->getEntityManager()->getConnection();

        $sql = 'SELECT m.*, r.*
            FROM media AS m
            INNER JOIN ressource AS r 
            ON r.media_id = m.id
            WHERE m.post_id = :id';

        try {
            $req = $manager->prepare($sql);
        } catch (Exception $e) {
            $e->getMessage();
        }

        $req->execute([':id' => $id]);

        return $req->fetchAllAssociative();
    }

    public function get_status(int $id, $limit, $offset):array
    {
        $manager = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.*, r.*
        FROM media AS m
        LEFT JOIN ressource AS r 
        ON r.media_id = m.id
        WHERE m.post_id = :id
        AND r.type = 1
        LIMIT $limit, $offset";

        $req = $manager->prepare($sql);

        $req->execute([':id' => $id]);

        return $req->fetchAllAssociative();
    }

    // /**
    //  * @return Media[] Returns an array of Media objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Media
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
