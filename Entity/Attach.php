<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attach
 *
 * @ORM\Table(name="messages_attach")
 * @ORM\Entity()
 */
class Attach
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
     * @var Message
     *
     * @ORM\ManyToOne(targetEntity="Youshido\MessagesBundle\Entity\Message", inversedBy="attaches")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id")
     */
    private $message;

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
     * Set message
     *
     * @param \Youshido\MessagesBundle\Entity\Message $message
     * @return Attach
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
}
