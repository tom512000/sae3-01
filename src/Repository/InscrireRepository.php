<?php

namespace App\Repository;

use App\Entity\Inscrire;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Offre;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscrire::class);
    }

    public function findByUserId(int $userId) : array
    {
        return $this->createQueryBuilder('i')
            ->select('i','User','Offre','entreprise','Type')
            ->join('i.User', 'u')
            ->andWhere('u.id = :userId')
            ->leftJoin('i.User','User')
            ->leftJoin('i.Offre','Offre')
            ->leftJoin('Offre.entreprise','entreprise')
            ->leftJoin('Offre.Type','Type')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function IsInscrit(int $idOffre, Security $security):bool
    {
        $user = $security->getUser();
        if ($user) {
        $userId = $user->getId();
        return $this->findOneBy(['Offre' => $idOffre, 'User' => $userId]) != null;
        }
        return false;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function inscription(Offre $Offre, Security $security):void{

        $user = $security->getUser();

        if ($user instanceof User) {
            $userId = $user->getId();
            $offreId= $Offre->getId();

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

            if ($inscrire === null) {
                $inscrire = new Inscrire();
                $inscrire->setUser($user);
                $inscrire->setOffre($Offre);
                $inscrire->setStatus(1);
                $inscrire->setDateDemande(new DateTime());

                $this->_em->persist($inscrire);
                $this->_em->flush();
            }
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function desinscription(Offre $Offre, Security $security):void
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

            if ($inscrire !== null) {
                $this->_em->remove($inscrire);
                $this->_em->flush();
            }
        }
    }

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
