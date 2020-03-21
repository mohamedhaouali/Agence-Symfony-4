<?php

namespace App\Repository;

use App\Entity\PropertySearch;
use App\Entity\Proprety;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Proprety|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proprety|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proprety[]    findAll()
 * @method Proprety[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropretyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proprety::class);
    }

    /**
 * @return Query
 */

    public function findAllVisibleQuery(PropertySearch $search)
    {

        $query = $this->findVisibleQuery();

        //pour le max prix
        if ($search->getMaxPrice()) {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()){
            $query = $query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }
        return $query->getQuery();

        if ($search->getOptions()->count() >0){
            foreach ($search->getOptions() as $k =>$option){
                dump($k);
              $query =$query
                   ->andWhere(":option$k MEMBER OF p.options")
                   ->setParameter("option", $option);
            }
        }


    }

    /**
     * @return Proprety[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->Where('p.sold = false')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()

            ;
    }

    public function findVisibleQuery(){
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    // /**
    //  * @return Proprety[] Returns an array of Proprety objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Proprety
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
