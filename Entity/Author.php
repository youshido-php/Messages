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
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\MessageStatus", mappedBy="author")
     */
    private $statuses;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\Message", mappedBy="author")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="Youshido\MessagesBundle\Entity\Room", inversedBy="authors")
     * @ORM\JoinTable(name="messages_user_room_map")
     */
    private $rooms;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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
     * Add statuses
     *
     * @param \Youshido\MessagesBundle\Entity\MessageStatus $statuses
     * @return Author
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
     * Add rooms
     *
     * @param \Youshido\MessagesBundle\Entity\Room $rooms
     * @return Author
     */
    public function addRoom(\Youshido\MessagesBundle\Entity\Room $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \Youshido\MessagesBundle\Entity\Room $rooms
     */
    public function removeRoom(\Youshido\MessagesBundle\Entity\Room $rooms)
    {
        $this->rooms->removeElement($rooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRooms()
    {
        return $this->rooms;
    }
}
