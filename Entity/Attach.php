<?php

namespace Youshido\MessagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Youshido\UploadableBundle\Annotations as Youshido;

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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     *
     * @Youshido\Uploadable(override="true", asserts={@Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid Image"
     * )})
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255)
     *
     * @Youshido\Uploadable(override="true")
     */
    private $file;

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
