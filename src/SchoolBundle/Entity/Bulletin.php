<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bulletin
 *
 * @ORM\Table(name="bulletin")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\BulletinRepository")
 * @ORM\HasLifecycleCallBacks()
 */
class Bulletin
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
     * @var int
     *
     * @ORM\Column(name="marks", type="float", precision=3, scale=3)
     */
    private $marks;

    /**
     * @var int
     *
     * @ORM\Column(name="coefficients", type="integer")
     */
    private $coefficients;

    /**
     * @var string
     *
     * @ORM\Column(name="average", type="float", precision=3, scale=3)
     */
    private $average;

    /**
     * @var string
     *
     * @ORM\Column(name="period", type="string")
     */
    private $period;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="bulletins")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $student;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StudentNote", mappedBy="bulletin")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $notes;



    /**
     * PrePersist/PreUpdate Function
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preAction() {
        $marks = 0;
        $coefficients = 0;
        $average = 0;
        foreach ($this->notes as $key => $note) {
            $marks = $marks + $note->getTotal();
            $coefficients = $coefficients + $note->getMatter()->getCoefficient();
        }

        $average = $marks / $coefficients;
        $this->marks = $marks;
        $this->setCoefficients($coefficients);
        $this->setAverage($average);
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
     * Set marks
     *
     * @param integer $marks
     *
     * @return Bulletin
     */
    public function setMarks($marks)
    {
        $this->marks = $marks;

        return $this;
    }

    /**
     * Get marks
     *
     * @return int
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Set coefficients
     *
     * @param integer $coefficients
     *
     * @return Bulletin
     */
    public function setCoefficients($coefficients)
    {
        $this->coefficients = $coefficients;

        return $this;
    }

    /**
     * Get coefficients
     *
     * @return int
     */
    public function getCoefficients()
    {
        return $this->coefficients;
    }

    /**
     * Set average
     *
     * @param string $average
     *
     * @return Bulletin
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return string
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set student
     *
     * @param \SchoolBundle\Entity\Student $student
     *
     * @return Bulletin
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
     * Constructor
     */
    public function __construct()
    {
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set period
     *
     * @param string $period
     *
     * @return Bulletin
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Add note
     *
     * @param \SchoolBundle\Entity\StudentNote $note
     *
     * @return Bulletin
     */
    public function addNote(\SchoolBundle\Entity\StudentNote $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \SchoolBundle\Entity\StudentNote $note
     */
    public function removeNote(\SchoolBundle\Entity\StudentNote $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
