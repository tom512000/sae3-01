<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entreprise>
 *
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    /**
     * Méthode du constructeur.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

    /**
     * Recherche des entreprises en fonction d'un texte de recherche.
     *
     * @param string $searchText le texte à rechercher dans les noms d'entreprise
     *
     * @return Entreprise[] un tableau d'objets Entreprise correspondant aux critères de recherche
     */
    public function search(string $searchText = ''): array
    {
        $qb = $this->createQueryBuilder('e')
            ->orderBy('e.nomEnt', 'ASC');

        if (!empty($searchText)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('e.nomEnt', ':searchText')
            ))->setParameter('searchText', '%'.$searchText.'%');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Récupérer toutes les entreprises.
     *
     * @return Entreprise[] un tableau de tous les objets Entreprise
     */
    public function findEntreprises(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->orderBy('e.nomEnt', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
