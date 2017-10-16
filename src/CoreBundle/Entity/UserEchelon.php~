<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEchelon
 *
 * @ORM\Table(name="user_echelon")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserEchelonRepository")
 */
class UserEchelon
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;

    /**
     * @var Echelon
     *
     * @ORM\ManyToOne(targetEntity="Echelon", inversedBy="userEchelons")
     */
    private $echelon;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userEchelons")
     */
    private $user;

    public function __construct() {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return UserEchelon
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
     * Set details
     *
     * @param string $details
     *
     * @return UserEchelon
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set echelon
     *
     * @param \CoreBundle\Entity\Echelon $echelon
     *
     * @return UserEchelon
     */
    public function setEchelon(\CoreBundle\Entity\Echelon $echelon = null)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon
     *
     * @return \CoreBundle\Entity\Echelon
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * Set user
     *
     * @param \CoreBundle\Entity\User $user
     *
     * @return UserEchelon
     */
    public function setUser(\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function dateReadable() {
        return \CoreBundle\Utils\Utils::dateFormat($this->date);
    }
}
