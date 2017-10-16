<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\EmailRepository")
 */
class Email extends \CoreBundle\Utils\JsonObject
{
    /**
     * @var int
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
     * @var array
     *
     * @ORM\Column(name="receivers", type="array")
     */
    private $receivers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="File", mappedBy="attachedTo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $attachments;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="emailsSent")
     */
    private $sender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Email
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
     * Set receivers
     *
     * @param array $receivers
     *
     * @return Email
     */
    public function setReceivers($receivers)
    {
        $this->receivers = $receivers;

        return $this;
    }

    /**
     * Get receivers
     *
     * @return array
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * Set sender
     *
     * @param \stdClass $sender
     *
     * @return Email
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \stdClass
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Email
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attachment
     *
     * @param \CoreBundle\Entity\File $attachment
     *
     * @return Email
     */
    public function addAttachment($attachment)
    {
        if($attachment instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $attachment = new File($attachment);
        }
        $attachment->setAttachedTo($this);
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param \CoreBundle\Entity\File $attachment
     */
    public function removeAttachment(\CoreBundle\Entity\File $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    /**
     * Get attachments
     *
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }
}
