<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByRecent():array{
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->orderBy('o.jourDeb', 'ASC') // Assuming you want to order by the 'jourDeb' field
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

    public function search(string $searchText = ''): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.nomOffre', 'ASC');

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('o.nomOffre', ':searchText')
            ))->setParameter('searchText', '%'.$searchText.'%');
        }

        return $qb->getQuery()->getResult();
    }

}

