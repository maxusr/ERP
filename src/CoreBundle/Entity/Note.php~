<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\NoteRepository")
 */
class Note extends \CoreBundle\Utils\JsonObject
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=true)
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="display", type="boolean")
     */
    private $display;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notes")
     */
    private $sender;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="notesReceived")
     */
    private $receivers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->receivers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime;
        $this->display = true;
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
     *
     * @return Note
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
     * Set title
     *
     * @param string $title
     *
     * @return Note
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Note
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
     * Set display
     *
     * @param boolean $display
     *
     * @return Note
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set sender
     *
     * @param \CoreBundle\Entity\User $sender
     *
     * @return Note
     */
    public function setSender(\CoreBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \CoreBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Add receiver
     *
     * @param \CoreBundle\Entity\User $receiver
     *
     * @return Note
     */
    public function addReceiver(\CoreBundle\Entity\User $receiver)
    {
        $this->receivers[] = $receiver;

        return $this;
    }

    /**
     * Remove receiver
     *
     * @param \CoreBundle\Entity\User $receiver
     */
    public function removeReceiver(\CoreBundle\Entity\User $receiver)
    {
        $this->receivers->removeElement($receiver);
    }

    /**
     * Get receivers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Note
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

    public function getObjectVars() {
        return get_object_vars($this);
    }
}
