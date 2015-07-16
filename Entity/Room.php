<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Room
 *
 * @ORM\Table(name="messages_room")
 * @ORM\Entity(repositoryClass="Youshido\MessagesBundle\Entity\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Youshido\MessagesBundle\Entity\Message", mappedBy="room")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="Youshido\MessagesBundle\Entity\Author", mappedBy="rooms")
     */
    private $authors;

    /**
     * @ORM\OneToOne(targetEntity="Youshido\MessagesBundle\Entity\Message", mappedBy="room")
     * @ORM\JoinColumn(name="last_message_id", referencedColumnName="id")
     */
    private $lastMessage;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->authors = new ArrayCollection();
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
     * Set theme
     *
     * @param string $theme
     * @return Room
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Room
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
     * Add messages
     *
     * @param \Youshido\MessagesBundle\Entity\Message $messages
     * @return Room
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
     * Add authors
     *
     * @param \Youshido\MessagesBundle\Entity\Author $authors
     * @return Room
     */
    public function addAuthor(\Youshido\MessagesBundle\Entity\Author $authors)
    {
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \Youshido\MessagesBundle\Entity\Author $authors
     */
    public function removeAuthor(\Youshido\MessagesBundle\Entity\Author $authors)
    {
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set lastMessage
     *
     * @param \Youshido\MessagesBundle\Entity\Message $lastMessage
     * @return Room
     */
    public function setLastMessage(\Youshido\MessagesBundle\Entity\Message $lastMessage = null)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage
     *
     * @return \Youshido\MessagesBundle\Entity\Message 
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }
}
