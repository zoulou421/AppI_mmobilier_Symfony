<?php

namespace App\Repository;
use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function add(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
     

     //les deux propriétés findLatest et findVisible se repètent un tout petit peu.
    //on va devoir les factoriser.
    private function finVisibleQuery():QueryBuilder
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false')
                    ;
    }

    /**
     * @return Property[]
     */
    public function findAllVisible():array
    {
        return $this->finVisibleQuery()
                    ->getQuery()
                    ->getResult()
           ;
    }
    /*public function findAllVisible():array
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false')
                    ->getQuery()
                    ->getResult()
           ;
    }*/

    /**
     * @return Property[]
     */
    public function findLatest():array
    {
        return $this->finVisibleQuery()
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult()
           ;
    }

//    /**
//     * @return Property[] Returns an array of Property objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
