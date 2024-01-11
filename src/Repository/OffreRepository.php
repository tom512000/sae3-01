<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    /**
     * Recherche les offres les plus récentes.
     *
     * @return Offre[] un tableau d'objets Offre correspondant aux offres les plus récentes
     */
    public function findByRecent(): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o', 'entreprise', 'Type', 'inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
            ->orderBy('o.jourDeb', 'ASC')
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

    /**
     * Recherche les identifiants de toutes les offres.
     *
     * @return array un tableau d'objets Offre ordonnés par nom d'offre
     */
    public function findOffresIds(): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.nomOffre', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Recherche les offres en fonction des filtres fournis, pour une entreprise spécifique.
     *
     * @param int    $id         L'identifiant de l'entreprise
     * @param int    $type       L'identifiant du type d'offre (0 pour tous)
     * @param string $searchText le texte de recherche
     * @param int    $niveau     le niveau d'études requis (-1 pour tous)
     * @param string $date       la date limite de début
     * @param int    $dateFiltre le filtre de date (1 pour avant, 2 pour après, 3 pour exacte)
     *
     * @return array un tableau d'objets Offre correspondant aux critères de recherche
     *
     * @throws \Exception
     */
    public function findByFilterByEntrepriseId(int $id, int $type, string $searchText, int $niveau, string $date, int $dateFiltre, string $lieu): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.entreprise = :idEnt')
            ->setParameter('idEnt', $id);

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre, $lieu);
    }

    /**
     * Recherche les offres en fonction des filtres fournis.
     *
     * @param int    $type       L'identifiant du type d'offre (0 pour tous)
     * @param string $searchText le texte de recherche
     * @param int    $niveau     le niveau d'études requis (-1 pour tous)
     * @param string $date       la date limite de début
     * @param int    $dateFiltre le filtre de date (1 pour avant, 2 pour après, 3 pour exacte)
     *
     * @return array un tableau d'objets Offre correspondant aux critères de recherche
     *
     * @throws \Exception
     */
    public function findByFilter(int $type, string $searchText, int $niveau, string $date, int $dateFiltre, string $lieu): array
    {
        $qb = $this->createQueryBuilder('o');

        return $this->Filter($type, $qb, $searchText, $niveau, $date, $dateFiltre, $lieu);
    }

    /**
     * Recherche le nombre d'offres par entreprise et retourne un tableau associatif.
     *
     * @param array $entreprises un tableau d'objets Entreprise
     *
     * @return array un tableau associatif avec les identifiants d'entreprises comme clés et le nombre d'offres comme valeurs
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
        for ($i = 0; $i < count($entreprises); ++$i) {
            $nbOffres[$entreprises[$i]->getId()] = 0;
        }

        foreach ($results as $result) {
            $nbOffres[$result['entrepriseId']] = $result['nbOffers'];
        }

        return $nbOffres;
    }

    /**
     * Filtrage des offres en fonction des critères fournis.
     *
     * @param int          $type       L'identifiant du type d'offre (0 pour tous)
     * @param QueryBuilder $qb         L'objet QueryBuilder
     * @param string       $searchText le texte de recherche
     * @param int          $niveau     le niveau d'études requis (-1 pour tous)
     * @param string       $date       la date limite de début
     * @param int          $dateFiltre le filtre de date (1 pour avant, 2 pour après, 3 pour exacte)
     *
     * @return array un tableau d'objets Offre correspondant aux critères de recherche
     *
     * @throws \Exception
     */
    protected function Filter(int $type, QueryBuilder $qb, string $searchText, int $niveau, string $date, int $dateFiltre, string $lieux): mixed
    {
        $qb->select('o', 'entreprise', 'Type', 'inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
            ->leftJoin('inscrires.User', 'User');

        if (0 != $type) {
            $qb->join('o.Type', 't')
                ->andwhere('t.id = :type')
                ->setParameter('type', $type);
        }

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('UPPER(o.nomOffre)', 'UPPER(:searchText)')
            ))->setParameter('searchText', '%'.$searchText.'%');
        }

        if (!empty($lieux)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('UPPER(o.lieux)', 'UPPER(:searchLieu)')
            ))->setParameter('searchLieu', '%'.$lieux.'%');
        }

        if (-1 != $niveau) {
            if (0 == $niveau) {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC');
            } else {
                $qb->andWhere('o.level = :niveau')
                    ->setParameter('niveau', 'BAC +'.$niveau);
            }
        }

        if (!empty($date)) {
            $formattedDate = new \DateTime($date);

            if (1 == $dateFiltre) {
                $qb->andWhere('o.jourDeb < :date')
                    ->setParameter('date', $formattedDate);
            } elseif (2 == $dateFiltre) {
                $qb->andWhere('o.jourDeb > :date')
                    ->setParameter('date', $formattedDate);
            } else {
                $qb->andWhere('o.jourDeb = :date')
                    ->setParameter('date', $formattedDate);
            }
        }

        $qb->addOrderBy('o.nomOffre');

        return $qb->getQuery()->getResult();
    }

    /**
     * Recherche une offre par son identifiant.
     *
     * @param int $id L'identifiant de l'offre
     *
     * @return offre L'objet Offre correspondant à l'identifiant donné, ou null si non trouvé
     *
     * @throws NonUniqueResultException
     */
    public function findById(int $id): ?Offre
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o', 'entreprise', 'Type', 'inscrires')
            ->leftJoin('o.entreprise', 'entreprise')
            ->leftJoin('o.inscrires', 'inscrires')
            ->leftJoin('o.Type', 'Type')
            ->where('o.id = :id')
            ->orderBy('o.jourDeb', 'ASC')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Obtient le nombre d'inscriptions acceptées pour un ensemble d'offres.
     *
     * @param array $offres un tableau d'objets Offre
     *
     * @return array un tableau associatif avec les identifiants d'offres comme clés et le nombre d'inscriptions acceptées comme valeurs
     */
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

        for ($i = 0; $i < count($offres); ++$i) {
            $result[$i] = 0;
        }

        foreach ($queryResult as $row) {
            $result[$row['offre_id']] = (int) $row['nbInscriptionsAccepter'];
        }

        return $result;
    }
}
