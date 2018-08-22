<?php

namespace App\Repository;

use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Subject|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subject|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subject[]    findAll()
 * @method Subject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectRepository extends EntityRepository
{
/*    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subject::class);
    }
*/

    public function getSubjectsOrderByDate() 
    {
        $qb = $this->createQueryBuilder('s')
                   ->orderBy('s.createdAt_subject', 'ASC')
                   ->getQuery()
                   ->getResult();
        return $qb;
    }

//    /**
//     * @return Subject[] Returns an array of Subject objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    //Retrieve title of subject
    public function findSubjectById($subject)
    {
        return $this
            ->createQueryBuilder('s')
            ->andWhere('s.id = :val')
            ->setParameter('val', $subject)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
