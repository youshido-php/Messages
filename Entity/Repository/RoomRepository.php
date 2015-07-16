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

class RoomRepository extends EntityRepository
{

    /**
     * @param $author Author
     * @param bool|false $limit
     * @param int $offset ]
     * @return Room[]
     */
    public function findRoomsOfUser(Author $author, $limit = false, $offset = 0)
    {
        $builder = $this->createQueryBuilder('r')
            ->innerJoin('r.authors', 'authors')
            ->where('authors.id = :author')
            ->setParameter('author', $author)
            ->leftJoin('r.lastMessage', 'l')
            ->orderBy('l.createdAt', 'desc');

        if ($limit) {
            $builder->setMaxResults($limit);
        }

        if ($offset) {
            $builder->setFirstResult($offset);
        }

        return $builder->getQuery()->getResult();
    }

    public function checkExistAuthor(Room $room, Author $author)
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->innerJoin('r.authors', 'authors')
            ->where('authors.id = :author_id')
            ->andWhere('r.id = :id')
            ->setParameter('id', $room->getId())
            ->setParameter('author_id', $author->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

}