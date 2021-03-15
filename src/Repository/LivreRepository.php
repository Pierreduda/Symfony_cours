<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Emprunt;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[] Returns an array of Livre objects
    */
    public function recherche($search)
    {
        // SELECT l.* FROM livre l WHERE l.titre LIKE '%une%'
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :search')
            ->orWhere('l.auteur LIKE :search')
            ->setParameter('search', "%$search%")
            ->orderBy('l.auteur', 'ASC')
            ->orderBy('l.titre')
            // ->setMaxResults(10)
            ->getQuery() // execute la requete
            ->getResult() // retourne le résultat
        ;
    }
    // SELECT l.* FROM livre l INNER JOIN emprunt e ON l.id = e.livre_id WHERE e.date_retour IS NULL
    public function livresIndisponibles(){
        return $this->createQueryBuilder('l')
        ->join(Emprunt::class, "e", "WITH", "l.id = e.livre")
        ->andWhere('e.date_retour IS NULL')
        ->orderBy('l.auteur', 'ASC')
        ->orderBy('l.titre')
        ->getQuery()
        ->getResult() 
    ;
    }

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
