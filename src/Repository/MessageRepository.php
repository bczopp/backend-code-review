<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // additional Methods in here are not necessary. given methods already do everything needed that concerns reading from the database
    // also the method by() contained too much knowledge of the system.
    // for example a repository does not need to know the possible values for a attribute of the entity (status in this case)
}
