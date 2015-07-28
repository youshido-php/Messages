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

class ConversationRepository extends EntityRepository
{

    /**
     * @param $author Author
     * @param bool|false $limit
     * @param int $offset ]
     * @return Conversation[]
     */
    public function findConversationsOfUser(Author $author, $limit = false, $offset = 0)
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

    public function checkExistAuthor(Conversation $conversation, Author $author)
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->innerJoin('r.authors', 'authors')
            ->where('authors.id = :author_id')
            ->andWhere('r.id = :id')
            ->setParameter('id', $conversation->getId())
            ->setParameter('author_id', $author->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findConversationsBetween(Author $firstAuthor, Author $secondAuthor)
    {
        $subQuery = $this->createQueryBuilder('d');

        $dql = $this->createQueryBuilder('c')
            ->innerJoin('c.authors', 'a')
            ->having('COUNT(a) = 2')
            ->getDQL();

        $dql2 = $this->createQueryBuilder('c1')
            ->innerJoin('c1.authors', 'a2')
            ->where($subQuery->expr()->in('c1.id', $dql))
            ->andWhere('a2.id = :author1')
            ->getDQL();

        return $this->createQueryBuilder('c2')
            ->innerJoin('c2.authors', 'a3')
            ->where($subQuery->expr()->in('c2.id', $dql2))
            ->andWhere('a3.id = :author2')
            ->setParameters([
                'author2' => $firstAuthor,
                'author1' => $secondAuthor,
            ])
            ->getQuery()
            ->getResult();
    }
}