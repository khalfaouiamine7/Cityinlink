<?php

namespace App\Repository;

use App\Entity\Consultaion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultaion>
 *
 * @method Consultaion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultaion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultaion[]    findAll()
 * @method Consultaion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultaionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultaion::class);
    }
    public function findBySearchTerm($searchTerm)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.adresse LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }
    

//    /**
//     * @return Consultaion[] Returns an array of Consultaion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Consultaion
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
