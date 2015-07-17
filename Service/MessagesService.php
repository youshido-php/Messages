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
use Youshido\MessagesBundle\Entity\MessageRelation;
use Youshido\MessagesBundle\Entity\Conversation;

class MessagesService extends ContainerAware
{

    /**
     * @param $user
     * @param integer|boolean $limit
     * @param integer $offset
     * @return Conversation[]
     */
    public function getConversations($user, $limit = false, $offset = 0)
    {
        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if ($author) {
            return $this->container->get('doctrine')
                ->getRepository('YMessagesBundle:Conversation')
                ->findConversationsOfUser($author, $limit, $offset);
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
                ->getRepository('YMessagesBundle:MessageRelation')
                ->countMessagesWithStatus($author, MessageRelation::STATUS_NEW);
        } else {
            return 0;
        }
    }

    public function getMessages($conversationId, $user = false, $limit = false, $offset = 0)
    {
        $conversation = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Conversation')
            ->find($conversationId);

        if (!$conversation) {
            throw new \InvalidArgumentException();
        }

        $messages = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Message')
            ->findMessages($conversation, $limit, $offset);

        if ($user) {
            $author = $this->container->get('doctrine')
                ->getRepository('YMessagesBundle:Author')
                ->findOne($user);

            if ($author) {
                $this->setStatusForMessages($messages, $author, MessageRelation::STATUS_SEEN);
            } else {
                return [];
            }
        }

        return $messages;
    }

    public function sendMessage($conversationId, $user, $content)
    {
        $conversation = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Conversation')
            ->find($conversationId);

        if (!$conversation) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            throw new \InvalidArgumentException();
        }

        $message = $this->createMessage($author, $conversation, $content);
        $this->container->get('doctrine')->getManager()->persist($message);

        foreach($conversation->getAuthors() as $member){
            $messageRelation = new MessageRelation();
            $messageRelation
                ->setAuthor($member)
                ->setMessage($message)
                ->setStatus($member->getId() == $author->getId() ? MessageRelation::STATUS_SEEN : MessageRelation::STATUS_NEW);

            $this->container->get('doctrine')->getManager()->persist($messageRelation);
        }

        $this->container->get('doctrine')->getManager()->flush();
    }

    public function joinConversation($conversationId, $user)
    {
        $conversation = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Conversation')
            ->find($conversationId);

        if (!$conversation) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            $author = $this->createAuthor($user);
        }

        //check exist
        if (!$this->container->get('doctrine')->getRepository('YMessagesBundle:Conversation')
            ->checkExistAuthor($conversation, $author)
        ) {
            $conversation->addAuthor($author);
            $author->addConversation($conversation);

            $this->container->get('doctrine')->getManager()->persist($author);
            $this->container->get('doctrine')->getManager()->persist($conversation);
            $this->container->get('doctrine')->getManager()->flush();
        }

    }

    public function leaveConversation($conversationId, $user)
    {
        $conversation = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Conversation')
            ->find($conversationId);

        if (!$conversation) {
            throw new \InvalidArgumentException();
        }

        $author = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Author')
            ->findOne($user);

        if(!$author){
            throw new \InvalidArgumentException();
        }

        $conversation->removeAuthor($author);
        $author->removeConversation($conversation);

        $this->container->get('doctrine')->getManager()->persist($author);
        $this->container->get('doctrine')->getManager()->persist($conversation);
        $this->container->get('doctrine')->getManager()->flush();
    }

    public function getMembers($conversationId)
    {
        $conversation = $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:Conversation')
            ->find($conversationId);

        if (!$conversation) {
            throw new \InvalidArgumentException();
        }

        $members = [];
        $em = $this->container->get('doctrine')->getManager();
        foreach($conversation->getAuthors() as $author)
        {
            /** @var Author $author */
            $members[] = $em->getReference($author->getAuthorClass(), $author->getAuthorId());
        }

        return $members;
    }

    /**
     * @param $messages []
     * @param $author
     * @param $status
     */
    private function setStatusForMessages($messages, $author, $status)
    {
        $messagesIds = array_map(function ($message) {
            /** @var $message Message */
            return $message->getId();
        }, $messages);

        $this->container->get('doctrine')
            ->getRepository('YMessagesBundle:MessageRelation')
            ->setStatusForMessages($messagesIds, $author, $status);
    }

    private function createMessage(Author $author, Conversation $conversation, $content)
    {
        $message = new Message();
        $message
            ->setConversation($conversation)
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