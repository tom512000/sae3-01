<?php

namespace App\Repository;

use App\Entity\Offre;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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
            ->select('o', 'entreprise', 'Type','inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
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

    /**
     * @throws Exception
     */
    public function findByFilterByEntrepriseId(int $id, int $type, string $searchText, int $niveau, string $date, int $dateFiltre): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.entreprise = :idEnt')
            ->setParameter('idEnt', $id);

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre);
    }

    /**
     * @throws Exception
     */
    public function findByFilter(int $type, string $searchText, int $niveau, string $date, int $dateFiltre): array
    {
        $qb = $this->createQueryBuilder('o');

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findNbOffresByEntreprisesReturnArray(array $entreprises): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('IDENTITY(o.entreprise) as entrepriseId, COUNT(o.id) as nbOffers')
            ->where('o.entreprise IN (:entreprises)')
            ->groupBy('o.entreprise')
            ->setParameter('entreprises', $entreprises);

        $results = $qb->getQuery()->getResult();

        $nbOffres = [];
        for($i = 0; $i<count($entreprises);$i++) {
            $nbOffres[$entreprises[$i]->getId()] = 0;
        }


        foreach ($results as $result) {
            $nbOffres[$result['entrepriseId']] = $result['nbOffers'];
        }

        return $nbOffres;
    }

    /**
     * @param int $type
     * @param QueryBuilder $qb
     * @param string $searchText
     * @param int $niveau
     * @param string $date
     * @param int $dateFiltre
     * @return float|int|mixed|string
     * @throws Exception
     */
    protected function Filter(int $type, QueryBuilder $qb, string $searchText, int $niveau, string $date, int $dateFiltre): mixed
    {
        $qb ->select('o', 'entreprise', 'Type','inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
            ->leftJoin('inscrires.User','User');


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

        if ($niveau != -1) {
            if ($niveau == 0) {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC');
            } else {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC +' . $niveau);
            }
        }

        if (!empty($date)) {
            $formattedDate = new DateTime($date);

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

    /**
     * @throws NonUniqueResultException
     */
    public function findById(int $id):Offre
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o', 'entreprise', 'Type','inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
            ->where('o.id = :id')
            ->orderBy('o.jourDeb', 'ASC')
            ->setParameter('id',$id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getNbInscriptionsAccepter(array $offres): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o.id as offre_id, COUNT(i.User) as nbInscriptionsAccepter')
            ->leftJoin('o.inscrires', 'i')
            ->where('o IN (:offres)')
            ->andWhere('i.Status = :status')
            ->setParameter('offres', $offres)
            ->setParameter('status', 1)
            ->groupBy('o.id');

        $queryResult = $qb->getQuery()->getScalarResult();

        $result = [];

        for($i = 0; $i<count($offres);$i++) {
            $result[$i] = 0;
        }

        foreach ($queryResult as $row) {
            $result[$row['offre_id']] = (int)$row['nbInscriptionsAccepter'];
        }

        return $result;
    }



}

