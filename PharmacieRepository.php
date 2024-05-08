<?php

namespace App\Repository;

use App\Entity\Pharmacie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Pharmacie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pharmacie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pharmacie[]    findAll()
 * @method Pharmacie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PharmacieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pharmacie::class);
    }

    /**
     * Find pharmacies by search term with pagination.
     *
     * @param string $term The search term
     * @param int $page The current page number
     * @param PaginatorInterface $paginator Paginator service
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findByTerm($term, $page, PaginatorInterface $paginator)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :term OR p.adresse LIKE :term')
            ->setParameter('term', '%' . $term . '%');

        return $paginator->paginate(
            $queryBuilder, // Query builder instance
            $page,         // Current page number
            10             // Limit per page
        );
    }
}
