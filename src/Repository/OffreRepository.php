<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
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
            ->orderBy('o.jourDeb', 'ASC')
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }



    public function findOffresIds(): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.nomOffre', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByFilterByEntrepriseId(int $id,int $type, string $searchText, int $niveau, string $date, int $dateFiltre): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.entreprise = :idEnt')
            ->setParameter('idEnt', $id);

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre);
    }

    /**
     * @throws \Exception
     */
    public function findByFilter(int $type, string $searchText, int $niveau, string $date, int $dateFiltre): array
    {
        $qb = $this->createQueryBuilder('o');

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre);
    }

    /**
     * @throws NonUniqueResultException
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

    /**
     * @param int $type
     * @param QueryBuilder $qb
     * @param string $searchText
     * @param string $niveau
     * @param string $date
     * @return float|int|mixed|string
     * @throws \Exception
     */
    protected function Filter(int $type, QueryBuilder $qb, string $searchText, int $niveau, string $date, int $dateFiltre): mixed
    {
        if ($type != 0) {
            $qb->join('o.Type', 't')
                ->andwhere('t.id = :type')
                ->setParameter('type', $type);
        }

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('UPPER(o.nomOffre)', 'UPPER(:searchText)')
            ))->setParameter('searchText', '%' . $searchText . '%');
        }

        if (!empty($niveau) && $niveau != -1) {
            if ($niveau == 0) {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC');
            } else {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC +' . $niveau);
            }
        }

        if (!empty($date)) {
            $formattedDate = new \DateTime($date);

            if ($dateFiltre == 1) {
                $qb->andWhere('o.jourDeb < :date')
                    ->setParameter('date', $formattedDate);
            } elseif ($dateFiltre == 2) {
                $qb->andWhere('o.jourDeb > :date')
                    ->setParameter('date', $formattedDate);
            }
            else{
                $qb->andWhere('o.jourDeb = :date')
                    ->setParameter('date', $formattedDate);
            }
        }

        $qb -> addOrderBy('o.nomOffre');

        return $qb->getQuery()->getResult();
    }
}

