<?php

namespace App\Repository;

use App\Entity\SkillDemander;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillDemander>
 *
 * @method SkillDemander|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillDemander|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillDemander[]    findAll()
 * @method SkillDemander[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillDemanderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillDemander::class);
    }

//    /**
//     * @return SkillDemander[] Returns an array of SkillDemander objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SkillDemander
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getSkillLibellesByOffreId(int $offreId): array
    {
        $qb = $this->createQueryBuilder('skillDe')
            ->select('s.libelle')
            ->leftJoin('skillDe.skill', 's')
            ->where('skillDe.offre = :id')
            ->orderBy('s.libelle', 'ASC')
            ->setParameter('id', $offreId);

        $results = $qb->getQuery()->getResult();

        $libelles = array_column($results, 'libelle');

        return $libelles;
    }
}
