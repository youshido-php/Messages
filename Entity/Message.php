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
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Room", inversedBy="messages")
     * @ORM\JoinColumn(name="root_id", referencedColumnName="id")
     */
    private $room;

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
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\MessageStatus", mappedBy="message")
     */
    private $statuses;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();
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
     * Set room
     *
     * @param \Youshido\MessagesBundle\Entity\Room $room
     * @return Message
     */
    public function setRoom(\Youshido\MessagesBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \Youshido\MessagesBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
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
    public function addAttach(\Youshido\MessagesBundle\Entity\Attach $attaches)
    {
        $this->attaches[] = $attaches;

        return $this;
    }

    /**
     * Remove attaches
     *
     * @param \Youshido\MessagesBundle\Entity\Attach $attaches
     */
    public function removeAttach(\Youshido\MessagesBundle\Entity\Attach $attaches)
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
     * Add statuses
     *
     * @param \Youshido\MessagesBundle\Entity\MessageStatus $statuses
     * @return Message
     */
    public function addStatus(\Youshido\MessagesBundle\Entity\MessageStatus $statuses)
    {
        $this->statuses[] = $statuses;

        return $this;
    }

    /**
     * Remove statuses
     *
     * @param \Youshido\MessagesBundle\Entity\MessageStatus $statuses
     */
    public function removeStatus(\Youshido\MessagesBundle\Entity\MessageStatus $statuses)
    {
        $this->statuses->removeElement($statuses);
    }

    /**
     * Get statuses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStatuses()
    {
        return $this->statuses;
    }
}
