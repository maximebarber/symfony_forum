<?php

namespace App\Repository;

use App\Entity\Message;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends EntityRepository
{
/*     public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    } 
*/

    //Retrieve the messages correspondong to the subject
    public function findMessagesBySubject($subject)
    {
        return $this
            ->createQueryBuilder('m')
            ->join('m.visitor', 'v')
            ->andWhere('m.subject = :val')
            ->orderBy('m.createdAt_message', 'ASC')
            ->setParameter('val', $subject)
            ->getQuery()
            ->getResult();
    }

/*     public function getMessagesFromSubject() 
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT s, m, v
             FROM App\Entity\Subject s, App\Entity\Message m, App\Entity\Visitor v
             WHERE v.id = m.visitor
             AND s.id = m.subject
             AND s.id = 1'
        );

        return $query->execute();
    }
 */
/*     public function findAllWithSubject(): ?Message
    {
        return $this->createQueryBuilder('m')
                    ->join('m.subject')
                    ->getQuery()
                    ->getResult();
    } 
*/

//    /**
//     * @return Message[] Returns an array of Message objects
//     */
/*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
*/
}
