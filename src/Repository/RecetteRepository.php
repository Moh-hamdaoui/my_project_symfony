<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    // Vous pouvez ajouter des méthodes personnalisées pour récupérer des recettes selon vos besoins.

    // Exemple d'une méthode pour rechercher par titre
    public function findByTitle(string $title)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->getQuery()
            ->getResult();
    }
}
