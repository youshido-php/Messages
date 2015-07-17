<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Youshido\MessagesBundle\Entity\Author;
use Youshido\MessagesBundle\Entity\Conversation;

class MessageRepository extends EntityRepository
{

    public function findMessages(Conversation $conversation, $limit = false, $offset = 0)
    {
        $builder = $this->createQueryBuilder('m')
            ->select('m, s, a')
            ->where('m.conversation = :conversation')
            ->setParameter('conversation', $conversation)
            ->leftJoin('m.messageRelations', 's')
            ->leftJoin('m.attaches', 'a')
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