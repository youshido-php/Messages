<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Message
 *
 * @ORM\Table(name="messages_message")
 * @ORM\Entity(repositoryClass="Youshido\MessagesBundle\Entity\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var Conversation
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Conversation", inversedBy="messages")
     * @ORM\JoinColumn(name="root_id", referencedColumnName="id")
     */
    private $conversation;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Author", inversedBy="messages")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\Attach", mappedBy="message")
     */
    private $attaches;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\MessageRelation", mappedBy="message")
     */
    private $messageRelations;

    public function __construct()
    {
        $this->messageRelations = new ArrayCollection();
        $this->attaches = new ArrayCollection();
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
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set conversation
     *
     * @param \Youshido\MessagesBundle\Entity\Conversation $conversation
     * @return Message
     */
    public function setConversation(Conversation $conversation = null)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return \Youshido\MessagesBundle\Entity\Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Set author
     *
     * @param \Youshido\MessagesBundle\Entity\Author $author
     * @return Message
     */
    public function setAuthor(\Youshido\MessagesBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Youshido\MessagesBundle\Entity\Author 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add attaches
     *
     * @param \Youshido\MessagesBundle\Entity\Attach $attaches
     * @return Message
     */
    public function addAttach(Attach $attaches)
    {
        $this->attaches[] = $attaches;

        return $this;
    }

    /**
     * Remove attaches
     *
     * @param \Youshido\MessagesBundle\Entity\Attach $attaches
     */
    public function removeAttach(Attach $attaches)
    {
        $this->attaches->removeElement($attaches);
    }

    /**
     * Get attaches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttaches()
    {
        return $this->attaches;
    }

    /**
     * Add Message Relation
     *
     * @param \Youshido\MessagesBundle\Entity\MessageRelation $messageRelation
     * @return Message
     */
    public function addMessageRelation(MessageRelation $messageRelation)
    {
        $this->messageRelations[] = $messageRelation;

        return $this;
    }

    /**
     * Remove Message Relation
     *
     * @param \Youshido\MessagesBundle\Entity\MessageRelation $messageRelation
     */
    public function removeMessageRelation(MessageRelation $messageRelation)
    {
        $this->messageRelations->removeElement($messageRelation);
    }

    /**
     * Get Message Relations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessageRelations()
    {
        return $this->messageRelations;
    }
}
