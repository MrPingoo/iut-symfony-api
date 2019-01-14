<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Stars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stars[]    findAll()
 * @method Stars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StarsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stars::class);
    }

    public function countNumberByGame(Game $game)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.game = :game')
            ->setParameter('game', $game)
            ->select('SUM(s.star) as total, COUNT(s.star) as count')
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Stars[] Returns an array of Stars objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stars
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
