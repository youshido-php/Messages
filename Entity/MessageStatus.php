<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageStatus
 *
 * @ORM\Table(name="messages_statuses")
 * @ORM\Entity(repositoryClass="Youshido\MessagesBundle\Entity\Repository\MessageStatusRepository")
 */
class MessageStatus
{

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

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
    private $status = self::STATUS_UNREAD;

    /**
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Message", inversedBy="statuses")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id")
     */
    private $message;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Author", inversedBy="statuses")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;

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
     * @return MessageStatus
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
     * @return MessageStatus
     */
    public function setMessage(\Youshido\MessagesBundle\Entity\Message $message = null)
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
     * @return MessageStatus
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
}
