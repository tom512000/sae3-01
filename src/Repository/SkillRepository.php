<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 *
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    /**
     * Recherche les identifiants de toutes les compétences.
     *
     * @return Skill[] un tableau d'objets Skill ordonnés par libellé
     */
    public function findSkillsIds()
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.libelle', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
