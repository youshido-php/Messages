<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Youshido\MessagesBundle\Entity\Author;

class MessageRelationRepository extends EntityRepository
{

    public function countMessagesWithStatus(Author $author, $status)
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->where('m.author = :author')
            ->andWhere('m.status = :status')
            ->setParameter('author', $author)
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function setStatusForMessages($messagesIds, Author $author, $status)
    {
        $builder = $this->createQueryBuilder('m');

        $builder
            ->update()
            ->set('m.status', $status)
            ->where($builder->expr()->in('m.message', $messagesIds))
            ->andWhere('m.author = :author')
            ->setParameter('author', $author)
            ->getQuery()
            ->execute();
    }
}