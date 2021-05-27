<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use http\Params;
use Symfony\Component\Serializer\SerializerInterface;

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
        $this->manager = $this->getEntityManager();
    }

    public function get_media(int $id, int $status = null):array
    {
        $manager = $this->getEntityManager();

        $db = $manager->createQueryBuilder();
        $db
            ->select('m')
            ->from('App\Entity\Media', 'm')
            ->innerJoin('m.ressource', 'r')
            ->where('m.post_id = :id')
            ->setParameter('id', $id);

        if($status !== null){
            $db->andWhere('r.status = '.$status);
        }

        $resp = $db->getQuery();

        return $resp->execute();
    }

    /*public function update_status(int $id){
        $db = $this->manager->createQueryBuilder();
        $db
            ->select('m')
            ->from('App\Entity\Media', 'm')
            ->innerJoin('m.ressource', 'r')
            ->where('m.id = :id')
            ->setParameter('id', $id);

        $resp = $db->getQuery();

        return $resp->execute();
    }*/

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

    public function get_by_status(int $id) {
        $manager = $this->getEntityManager();

        $db = $manager->createQueryBuilder();
        $db
            ->select('m')
            ->from('App\Entity\Media', 'm')
            ->where('m.post_id = :id')
            ->setParameter('id', $id);

        $resp = $db->getQuery();

        return $resp->execute();
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
