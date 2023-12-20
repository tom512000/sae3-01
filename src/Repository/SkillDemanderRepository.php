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
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillDemander::class);
    }

    /**
     * Obtient les libellés des compétences demandées pour une offre spécifique.
     *
     * @param int $offreId L'identifiant de l'offre
     *
     * @return array un tableau contenant les libellés des compétences demandées pour l'offre donnée
     */
    public function getSkillLibellesByOffreId(int $offreId): array
    {
        $qb = $this->createQueryBuilder('skillDe')
            ->select('s.libelle')
            ->leftJoin('skillDe.skill', 's')
            ->where('skillDe.offre = :id')
            ->orderBy('s.libelle', 'ASC')
            ->setParameter('id', $offreId);

        $results = $qb->getQuery()->getResult();

        return array_column($results, 'libelle');
    }
}
