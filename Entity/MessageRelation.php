<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageRelation
 *
 * @ORM\Table(name="messages_relation")
 * @ORM\Entity(repositoryClass="Youshido\MessagesBundle\Entity\Repository\MessageRelationRepository")
 */
class MessageRelation
{

    const STATUS_NEW = 0;
    const STATUS_SENT = 1;
    const STATUS_SEEN = 2;
    const STATUS_DELETED = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status = self::STATUS_NEW;

    /**
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Message", inversedBy="messageRelations")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id")
     */
    private $message;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Author", inversedBy="messageRelations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;

    private $seenAt;
    private $sentAt;
    private $deleteAt;

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
     * Set status
     *
     * @param integer $status
     * @return MessageRelation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set message
     *
     * @param \Youshido\MessagesBundle\Entity\Message $message
     * @return MessageRelation
     */
    public function setMessage(Message $message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Youshido\MessagesBundle\Entity\Message 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set author
     *
     * @param \Youshido\MessagesBundle\Entity\Author $author
     * @return MessageRelation
     */
    public function setAuthor(Author $author = null)
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
}
