<?php

namespace App\Repository;

use App\Entity\Inscrire;
use App\Entity\Offre;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Inscrire>
 *
 * @method Inscrire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscrire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscrire[]    findAll()
 * @method Inscrire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscrireRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry le service ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscrire::class);
    }

    /**
     * Recherche les inscriptions d'un utilisateur.
     *
     * @param int $userId L'identifiant de l'utilisateur
     *
     * @return Inscrire[] un tableau d'objets Inscrire correspondant à l'utilisateur donné
     */
    public function findByUserId(int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->select('i', 'User', 'Offre', 'entreprise', 'Type')
            ->join('i.User', 'u')
            ->andWhere('u.id = :userId')
            ->leftJoin('i.User', 'User')
            ->leftJoin('i.Offre', 'Offre')
            ->leftJoin('Offre.entreprise', 'entreprise')
            ->leftJoin('Offre.Type', 'Type')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Vérifie si un utilisateur est inscrit à une offre donnée.
     *
     * @param int      $idOffre  L'identifiant de l'offre
     * @param Security $security le service de sécurité Symfony
     *
     * @return bool true si l'utilisateur est inscrit, sinon false
     */
    public function IsInscrit(int $idOffre, Security $security): bool
    {
        $user = $security->getUser();

        if ($user) {
            $userId = $user->getId();

            return null != $this->findOneBy(['Offre' => $idOffre, 'User' => $userId]);
        }

        return false;
    }

    /**
     * Inscription d'un utilisateur à une offre.
     *
     * @param Offre    $Offre    L'objet Offre auquel l'utilisateur s'inscrit
     * @param Security $security le service de sécurité Symfony
     *
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    public function inscription(Offre $Offre, Security $security): void
    {
        $user = $security->getUser();

        if ($user instanceof User) {
            $userId = $user->getId();
            $offreId = $Offre->getId();

            $inscrire = $this->createQueryBuilder('i')
                ->select('i')
                ->where('i.User = :userId')
                ->andWhere('i.Offre = :offreId')
                ->setParameters([
                    'userId' => $userId,
                    'offreId' => $offreId,
                ])
                ->getQuery()
                ->getOneOrNullResult();

            if (null === $inscrire) {
                $inscrire = new Inscrire();
                $inscrire->setUser($user);
                $inscrire->setOffre($Offre);

                $randomStatus = random_int(1, 3);
                $inscrire->setStatus($randomStatus);

                $inscrire->setDateDemande(new \DateTime());

                $this->_em->persist($inscrire);
                $this->_em->flush();
            }
        }
    }

    /**
     * Désinscription d'un utilisateur d'une offre.
     *
     * @param Offre    $Offre    L'objet Offre de laquelle l'utilisateur se désinscrit
     * @param Security $security le service de sécurité Symfony
     *
     * @throws NonUniqueResultException
     */
    public function desinscription(Offre $Offre, Security $security): void
    {
        $user = $security->getUser();

        if ($user instanceof User) {
            $userId = $user->getId();

            $inscrire = $this->createQueryBuilder('i')
                ->select('i')
                ->where('i.User = :userId')
                ->andWhere('i.Offre = :offreId')
                ->setParameters([
                    'userId' => $userId,
                    'offreId' => $Offre->getId(),
                ])
                ->getQuery()
                ->getOneOrNullResult();

            if (null !== $inscrire) {
                $this->_em->remove($inscrire);
                $this->_em->flush();
            }
        }
    }

    /**
     * Récupère les inscriptions d'un utilisateur pour un ensemble d'offres données.
     *
     * @param Offre[]  $offres   un tableau d'objets Offre
     * @param Security $security le service de sécurité Symfony
     *
     * @return array un tableau associatif avec les identifiants d'offres comme clés et les objets Inscrire correspondants
     */
    public function getInscriptions(array $offres, Security $security): array
    {
        $offreIds = array_map(function (Offre $offre) {
            return $offre->getId();
        }, $offres);

        $qb = $this->createQueryBuilder('i')
            ->andWhere('i.Offre IN (:offreIds)')
            ->andWhere('i.User = :user')
            ->setParameter('offreIds', $offreIds)
            ->setParameter('user', $security->getUser());

        $inscriptions = $qb->getQuery()->getResult();

        $result = [];
        foreach ($inscriptions as $inscription) {
            $result[$inscription->getOffre()->getId()] = $inscription;
        }

        return $result;
    }
}
