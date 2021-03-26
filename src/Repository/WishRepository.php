<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }


    public function findWishesListByPage(int $page = 1): ?array {
        // requete pour obtenir les wishes
        $queryBuilder = $this->createQueryBuilder('w');
        $queryBuilder->andWhere('w.isPublished = true');
        //$queryBuilder->andWhere('w.likes > :likesCount');
        //$queryBuilder->setParameter(':likesCount', 5);

        // requete pour obtenir le nombre de resultat
        $queryBuilder->select("COUNT(w)");

        // on execute la requete et recupere juste le chiffre :
        $countQuery = $queryBuilder->getQuery();
        $totalResultCount = $countQuery->getSingleScalarResult();

        // on remodifie notre queryBuilder
        $queryBuilder->select('w');

        // l'offset
        $offset = ($page - 1) * 20;
        $queryBuilder->setFirstResult($offset);
        //nombre max de resultat
        $queryBuilder->setMaxResults(20);

        // on tri
        $queryBuilder->addOrderBy('w.dateCreated', 'DESC');

        // on recupere l'objet Query de doctrine
        $query = $queryBuilder->getQuery();

        // on execute la requete et on recupere les resultats
        $result = $query->getResult();

        // Deux données sont à renvoyer
        return [
            "result" => $result,
            "totalResultCount" => $totalResultCount,
        ];
    }


    public function findWishAndReactionsByWishId(int $id) {
        $wishAndReactions = [];
        // requete pour obtenir le wish
        $queryBuilder = $this->createQueryBuilder('w');
        $queryBuilder->andWhere('w.id = :id');
        $queryBuilder->setParameter(':id', $id);
        $queryBuilder->join('w.reactions', 'reactions');
        $queryBuilder->addOrderBy('reactions.dateCreated', 'DESC');
        $queryBuilder->addSelect('reactions');
        $query = $queryBuilder-> getQuery();

        $query->setMaxResults(10);

//dd($query->getResult());
        return $query->getResult();
    }










    // /**
    //  * @return Wish[] Returns an array of Wish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wish
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
