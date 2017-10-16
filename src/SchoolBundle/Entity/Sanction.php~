<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sanction
 *
 * @ORM\Table(name="sanction_student")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\SanctionRepository")
 */
class Sanction
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
     * @ORM\Column(name="type", type="string", length=80)
     */
    private $type;
    const TYPES = array("Blame" => "blame", "Exclusion Temporaire" => "exclutemp", "Exclusion définitive" => "excludef");

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="madeAt", type="datetime")
     */
    private $madeAt;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="sanctions")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $student;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->madeAt = new \DateTime;
        $this->duration = 7;
    }


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
     * Set type
     *
     * @param string $type
     *
     * @return Sanction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Sanction
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Sanction
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set student
     *
     * @param \SchoolBundle\Entity\Student $student
     *
     * @return Sanction
     */
    public function setStudent(\SchoolBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \SchoolBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set madeAt
     *
     * @param \DateTime $madeAt
     *
     * @return Sanction
     */
    public function setMadeAt($madeAt)
    {
        $this->madeAt = $madeAt;

        return $this;
    }

    /**
     * Get madeAt
     *
     * @return \DateTime
     */
    public function getMadeAt()
    {
        return $this->madeAt;
    }

    public function debutReadable() {
        if(is_string($this->madeAt)) {
            $date = new \DateTime($this->madeAt);
        }else{
            $date = $this->madeAt;
        }

        return $date != null ? \CoreBundle\Utils\Utils::dateFormat($date) : null;
    }

    public function finReadable() {
        $interval = new \DateInterval('P'.$this->duration.'D');
        if(is_string($this->madeAt)) {
            $date = new \DateTime($this->madeAt);
        }else{
            $date = $this->madeAt;
        }
        $date->add($interval);

        return $date != null ? \CoreBundle\Utils\Utils::dateFormat($date) : null;
    }

    public function typeReadable() {
        $types = array_flip(self::TYPES);

        return $types[$this->type];
    }
}
