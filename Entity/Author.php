<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="messages_author")
 * @ORM\Entity(repositoryClass="Youshido\MessagesBundle\Entity\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=255)
     */
    private $authorClass;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $authorId;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\MessageRelation", mappedBy="author")
     */
    private $messageRelations;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\Message", mappedBy="author")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="Youshido\MessagesBundle\Entity\Conversation", inversedBy="authors")
     * @ORM\JoinTable(name="messages_user_conversation_map")
     */
    private $conversations;

    public function __construct()
    {
        $this->messageRelations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->conversations = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entity
     *
     * @param string $authorClass
     * @return Author
     */
    public function setAuthorClass($authorClass)
    {
        $this->authorClass = $authorClass;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getAuthorClass()
    {
        return $this->authorClass;
    }

    /**
     * Set entityId
     *
     * @param integer $authorId
     * @return Author
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer 
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Add message relation
     *
     * @param \Youshido\MessagesBundle\Entity\MessageRelation $messageRelations
     * @return Author
     */
    public function addMessageRelations(MessageRelation $messageRelations)
    {
        $this->messageRelations[] = $messageRelations;

        return $this;
    }

    /**
     * Remove message relation
     *
     * @param \Youshido\MessagesBundle\Entity\MessageRelation $messageRelation
     */
    public function removeMessageRelation(MessageRelation $messageRelation)
    {
        $this->messageRelations->removeElement($messageRelation);
    }

    /**
     * Get message relations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessageRelations()
    {
        return $this->messageRelations;
    }

    /**
     * Add messages
     *
     * @param \Youshido\MessagesBundle\Entity\Message $messages
     * @return Author
     */
    public function addMessage(\Youshido\MessagesBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \Youshido\MessagesBundle\Entity\Message $messages
     */
    public function removeMessage(\Youshido\MessagesBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add conversations
     *
     * @param \Youshido\MessagesBundle\Entity\Conversation $conversation
     * @return Author
     */
    public function addConversation(Conversation $conversation)
    {
        $this->conversations[] = $conversation;

        return $this;
    }

    /**
     * Remove conversations
     *
     * @param \Youshido\MessagesBundle\Entity\Conversation $conversation
     */
    public function removeConversation(Conversation $conversation)
    {
        $this->conversations->removeElement($conversation);
    }

    /**
     * Get conversations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConversations()
    {
        return $this->conversations;
    }
}
