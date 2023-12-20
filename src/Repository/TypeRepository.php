<?php

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Type>
 *
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type::class);
    }

    /**
     * Recherche les identifiants de tous les types.
     *
     * @return Type[] un tableau d'objets Type ordonnés par libellé
     */
    public function findTypesIds(): array
    {
        $qb = $this->createQueryBuilder('t')
            ->orderBy('t.libelle', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
