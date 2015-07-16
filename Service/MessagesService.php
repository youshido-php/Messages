<?php
/**
 * Date: 16.07.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\MessagesBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;
use Youshido\MessagesBundle\Entity\Author;
use Youshido\MessagesBundle\Entity\Message;
use Youshido\MessagesBundle\Entity\MessageStatus;
use Youshido\MessagesBundle\Entity\Room;

class MessagesService extends ContainerAware
{

    /**
     * @param $user
     * @param integer|boolean $limit
     * @param integer $offset
     * @return Room[]
     */
    public function getRooms($user, $limit = false, $offset = 0)
    {
        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if ($author) {
            return $this->container->get('doctrine')
                ->getRepository('YMessagesBundle:Room')
                ->findRoomsOfUser($author, $limit, $offset);
        } else {
            return [];
        }
    }

    /**
     * @param $user
     * @return integer
     */
    public function countUnreadMessages($user)
    {
        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if ($author) {
            return $this->container->get('doctrine')
                ->getRepository('YMessagesBundle:MessageStatus')
                ->countUnReadMessages($author);
        } else {
            return 0;
        }
    }

    public function getMessages($roomId, $user = false, $limit = false, $offset = 0)
    {
        $room = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Room')
            ->find($roomId);

        if (!$room) {
            throw new \InvalidArgumentException();
        }

        $messages = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Message')
            ->findMessages($room, $limit, $offset);

        if ($user) {
            $author = $this->container->get('doctrine')
                ->getRepository('YMessagesBundle:Author')
                ->findOne($user);

            if ($author) {
                $this->unreadMessagesForUser($messages, $author);
            } else {
                return [];
            }
        }

        return $messages;
    }

    public function sendMessage($roomId, $user, $content)
    {
        $room = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Room')
            ->find($roomId);

        if (!$room) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            throw new \InvalidArgumentException();
        }

        $message = $this->createMessage($author, $room, $content);
        $this->container->get('doctrine')->getManager()->persist($message);

        foreach($room->getAuthors() as $member){
            $messageStatus = new MessageStatus();
            $messageStatus
                ->setAuthor($member)
                ->setMessage($message)
                ->setStatus($member->getId() == $author->getId() ? MessageStatus::STATUS_READ : MessageStatus::STATUS_UNREAD);

            $this->container->get('doctrine')->getManager()->persist($messageStatus);
        }

        $this->container->get('doctrine')->getManager()->flush();
    }

    public function joinRoom($roomId, $user)
    {
        $room = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Room')
            ->find($roomId);

        if (!$room) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            $author = $this->createAuthor($user);
        }

        //check exist
        if (!$this->container->get('doctrine')->getRepository('YMessagesBundle:Room')
            ->checkExistAuthor($room, $author)
        ) {
            $room->addAuthor($author);
            $author->addRoom($room);

            $this->container->get('doctrine')->getManager()->persist($author);
            $this->container->get('doctrine')->getManager()->persist($room);
            $this->container->get('doctrine')->getManager()->flush();
        }

    }

    public function leaveRoom($roomId, $user)
    {
        $room = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Room')
            ->find($roomId);

        if (!$room) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            throw new \InvalidArgumentException();
        }

        $room->removeAuthor($author);
        $author->removeRoom($room);

        $this->container->get('doctrine')->getManager()->persist($author);
        $this->container->get('doctrine')->getManager()->persist($room);
        $this->container->get('doctrine')->getManager()->flush();
    }

    public function getMembers($roomId)
    {
        $room = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Room')
            ->find($roomId);

        if (!$room) {
            throw new \InvalidArgumentException();
        }

        $members = [];
        $em = $this->container->get('doctrine')->getManager();
        foreach($room->getAuthors() as $author)
        {
            /** @var Author $author */
            $members[] = $em->getReference($author->getAuthorClass(), $author->getAuthorId());
        }

        return $members;
    }

    /**
     * @param $messages []
     * @param $author
     */
    private function unreadMessagesForUser($messages, $author)
    {
        $messagesIds = array_map(function ($message) {
            /** @var $message Message */
            return $message->getId();
        }, $messages);

        $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:MessageStatus')
            ->unreadMessages($messagesIds, $author);
    }

    private function createMessage(Author $author, Room $room, $content)
    {
        $message = new Message();
        $message
            ->setRoom($room)
            ->setAuthor($author)
            ->setContent($content);

        return $message;
    }

    private function createAuthor($user)
    {
        $author = new Author();
        $author
            ->setAuthorClass(get_class($user))
            ->setAuthorId($user->getId());

        return $author;
    }
}