<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Youshido\MessagesBundle\Entity\Author;
use Youshido\MessagesBundle\Entity\Room;

class MessageRepository extends EntityRepository
{

    public function findMessages(Room $room, $limit = false, $offset = 0)
    {
        $builder = $this->createQueryBuilder('m')
            ->select('m, s')
            ->where('m.room = :room')
            ->setParameter('room', $room)
            ->leftJoin('m.statuses', 's')
            ->orderBy('m.createdAt', 'DESC');

        if ($limit) {
            $builder->setMaxResults($limit);
        }

        if ($offset) {
            $builder->setFirstResult($offset);
        }

        return $builder
            ->getQuery()
            ->getResult();
    }

}