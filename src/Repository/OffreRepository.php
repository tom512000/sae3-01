<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function findByRecent():array{
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->orderBy('o.jourDeb', 'ASC') // Assuming you want to order by the 'jourDeb' field
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }



    public function findOffresIds(): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.nomOffre', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByTypeAndTextByEntrepriseId(int $id,int $type, string $searchText = ''): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.entreprise = :idEnt')
            ->orderBy('o.jourDeb', 'ASC')
            ->setParameter('idEnt', $id);

        if ($type != 0){
            $qb->join('o.Type', 't')
                ->andwhere('t.id = :type')
                ->setParameter('type', $type);
        }

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('o.nomOffre', ':searchText')
            ))->setParameter('searchText', '%' . $searchText . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findByTypeAndText(int $type, string $searchText = ''): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.nomOffre', 'ASC');

        if ($type != 0){
            $qb = $this->createQueryBuilder('o')
                ->join('o.Type', 't')
                ->where('t.id = :type')
                ->setParameter('type', $type)
                ->orderBy('o.nomOffre', 'ASC');
        }

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('o.nomOffre', ':searchText')
            ))->setParameter('searchText', '%' . $searchText . '%');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findNbOffreByEntreprise(int $id) : int
    {
        $qb = $this->createQueryBuilder('o')
            ->select('count(o.id)')
            ->where('o.entreprise = :idEnt')
            ->groupBy('o.entreprise')
            ->setParameter('idEnt', $id);

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }
}

