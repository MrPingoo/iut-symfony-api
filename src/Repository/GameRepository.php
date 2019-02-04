<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @return Game[] Returns an array of Game objects
     */
    public function search($params)
    {
        $q = $this->createQueryBuilder('g')
            ->orderBy('g.date', 'DESC')
            ->setMaxResults($params['rows'])
            ->setFirstResult($params['offset'])
            ;

        if (!empty($params['category'])) {
            $q->andWhere('g.category = :category');
            $q->setParameter('category', $params['category']);
        }

        if (!empty($params['author'])) {
            $q->andWhere('g.author = :author');
            $q->setParameter('author', $params['author']);
        }

        if (!empty($params['title'])) {
            $q->andWhere('g.title like :title');
            $q->setParameter('title', '%' . $params['title'] . '%');
        }

        if (!empty($params['begin']) && !empty($params['end'])) {
            $q->andWhere('g.release_date BETWEEN :begin AND :end')
                ->setParameter('begin', $params['begin']->format('Y-m-d'))
                ->setParameter('end', $params['end']->format('Y-m-d'));
        } elseif(!empty($params['begin']) && empty($params['end'])) {
            $q->andWhere('g.releaseDate > :begin')
                ->setParameter('end', $params['begin']->format('Y-m-d'));
        }

        if (!empty($params['sort_releasedate'])) {
            $q->orderBy('releaseDate', $params['sort_releasedate']);
        }

        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
