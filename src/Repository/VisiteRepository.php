<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * @param type $champ
     * @param type $ordre
     *
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre): array
    {
        return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, $ordre)
                ->getQuery()
                ->getResult();
    }

    /**
     * @param type $champ
     * @param type $valeur
     *
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur): array
    {
        if ('' == $valeur) {
            return $this->createQueryBuilder('v')
                    ->orderBy('v.'.$champ, 'ASC')
                    ->getQuery()
                    ->getResult();
        }

        return $this->createQueryBuilder('v')
                ->where('v.'.$champ.'=:valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();
    }

    /**
     * Supprime une visite.
     */
    public function remove(Visite $visite): void
    {
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }

    /**
     * Ajoute ou modifie une visite.
     */
    public function add(Visite $visite): void
    {
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }

    /**
     * Récupère les deux dernières visites.
     */
    public function findLastTwo(): array
    {
        return $this->createQueryBuilder('v')
                ->orderBy('v.datecreation', 'DESC')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult();
    }

    /**
     * Trouve les visites qui possèdent un environnement donné.
     */
    public function findByEnvironnement(string $environnement): array
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.environnements', 'e')
            ->where('e.nom LIKE :environnement')
            ->setParameter('environnement', $environnement)
            ->orderBy('v.datecreation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
