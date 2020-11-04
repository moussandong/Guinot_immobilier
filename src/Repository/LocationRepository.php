<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @return Location[] Returns an array of Location objects
     */
        public function findLastArticles()
        {
            return $this->findBy([], ['createdAt' => 'DESC']);
        }
    
        
        
    /**
    * Requetespour les Recherches des Terrains
    * @param 
    * @method findByCatTerrains()
    * 
    */
        public function findByCatTerrains()
        {
            $qb = $this->createQueryBuilder('p');      
            $qb
                ->innerJoin('App\Entity\Categorie',  'c', 'WITH', 'c = p.categorie')
                ->where('p.createdAt IS NOT NULL')
                ->andWhere('c.titre like :titre')
                ->setParameter('titre', 'Terrains');
               
                dump($qb->getQuery()->getResult());

            return $qb->getQuery()->getResult();
        }
        
        /**
         * Requetespour les Recherches des Appartements
         * @param 
         * @method
         * 
         */
        public function findByCatHostels()
        {
            $qb = $this->createQueryBuilder('p');
            $qb
                ->innerJoin('App\Entity\Categorie',  'c', 'WITH', 'c = p.categorie')
                ->where(
                    $qb->expr()->IsNotNull('p.createdAt'),
                    $qb->expr()->like('c.titre like :titre')
                )
                ->setParameter('titre', 'Hostels'); 
               // dump($qb->getQuery()->getResult());

            return $qb->getQuery()->getResult();
        }



        /**
         * Requetespour les Recherches des Appartements
         * @param 
         * @method
         *          * 
         */
        public function findByCatAppartements()
        {
            $qb = $this->createQueryBuilder('p');
            
            $qb
                ->innerJoin('App\Entity\Categorie',  'c', 'WITH', 'c = p.categorie')
                ->where('p.createdAt IS NOT NULL')
                ->andWhere('c.titre like :titre')
                ->setParameter('titre', 'Appartements'); 
               // dump($qb->getQuery()->getResult());

            return $qb->getQuery()->getResult();
        }

        /**
         * Requetespour les Recherches des Appartements
         * @param 
         * @method
         * 
         */
        public function findByCatMaisons()
        {
            $qb = $this->createQueryBuilder('p');
            
            $qb
                ->innerJoin('App\Entity\Categorie',  'c', 'WITH', 'c = p.categorie')
                ->where('p.createdAt IS NOT NULL')
                ->andWhere('c.titre like :titre')
                ->setParameter('titre', 'Maisons'); 
               // dump($qb->getQuery()->getResult());

            return $qb->getQuery()->getResult();
        }


    /** 
     * 
     * 
    */

/*        public function getLocation($categorie_id = null, $max = null)
        {
            $qb = $this->createQueryBuilder('e')
                ->orderBy('e.location', 'DESC');
     
            if($max)
            {
                $qb->setMaxResults($max);
            }
     
            if($category_id)
            {
                $qb->andWhere('e.categorie = :categorie_id')
                    ->setParameter('categorie_id', $categorie_id);
            }
     
            $query = $qb->getQuery();
     
            return $query->getResult();
        }



        



        public function findAllWithCategories()
        {
            $qb = $this->createQueryBuilder('a')
                ->innerJoin('a.categorie', 'c' )
                ->orderBy('a.categorie', 'ASC')
                ->addSelect('c')
                ->getQuery();
    
            return $qb->execute();
        }

        public function findLatest()
        {
            $qb = $this->createQueryBuilder('p')
                ->addSelect('a', 't')
                ->innerJoin('p.id', 'a')
                ->leftJoin('p.categories', 't')
                ->where('p.categories == :Maisons')
               # ->orderBy('p.publishedAt', 'DESC')
              #  ->setParameter('now', new \DateTime())
            ;
        }
            


/*
        public function findAllWithCategoriesAndTags()
        {
            $qb = $this->createQueryBuilder('a')
                ->innerJoin('a.categorie', 'c' )
                ->andWhere('c.categorie = :Maisons')
                ->addSelect('c')
                ->leftJoin('a.', 'Categorie' )
                ->addSelect('t')
                ->getQuery();
    
            return $qb->execute();
        }
*/
        
        // /**
    //  * @return Location[] Returns an array of Location objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Location
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
