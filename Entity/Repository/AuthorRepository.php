<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Youshido\MessagesBundle\Entity\Author;
use Youshido\MessagesBundle\Service\Interfaces\UserInterface;

class AuthorRepository extends EntityRepository
{

    /**
     * @param $user UserInterface
     * @return Author
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOne($user)
    {
        return $this->createQueryBuilder('a')
            ->where('a.authorClass = :class')
            ->andWhere('a.authorId = :id')
            ->setParameters([
                'class' => get_class($user),
                'id' => $user->getId()
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

}