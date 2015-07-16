<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Youshido\MessagesBundle\Entity\Author;
use Youshido\MessagesBundle\Entity\MessageStatus;

class MessageStatusRepository extends EntityRepository
{

    public function countUnReadMessages(Author $author)
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->where('m.author = :author')
            ->andWhere('m.status = :status')
            ->setParameter('author', $author)
            ->setParameter('status', MessageStatus::STATUS_UNREAD)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function unreadMessages($messagesIds, Author $author)
    {
        $builder = $this->createQueryBuilder('m');

        $builder
            ->update()
            ->set('m.status', MessageStatus::STATUS_READ)
            ->where($builder->expr()->in('m.message', $messagesIds))
            ->andWhere('m.author = :author')
            ->setParameter('author', $author)
            ->getQuery()
            ->execute();
    }

}