<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentNote
 *
 * @ORM\Table(name="student_note")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\StudentNoteRepository")
 * @ORM\HasLifecycleCallBacks()
 */
class StudentNote
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
     * @ORM\Column(name="note", type="float", precision=3, scale=3)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="float", precision=3, scale=3, nullable=true)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="to_string", type="string", nullable=true)
     */
    private $toString;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $student;

    /**
     * @var Bulletin
     *
     * @ORM\ManyToOne(targetEntity="Bulletin", inversedBy="notes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $bulletin;

    /**
     * @var Classroom
     *
     * @ORM\ManyToOne(targetEntity="Classroom", inversedBy="notes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $studentClassroom;

    /**
     * @var Exam
     *
     * @ORM\ManyToOne(targetEntity="Exam", inversedBy="notes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $exam;

    /**
     * @var Matter
     *
     * @ORM\ManyToOne(targetEntity="Matter", inversedBy="notes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $matter;


    /**
     * PrePersist/PreUpdate Function
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preAction() {
        $this->total = $this->note * $this->matter->getCoefficient();
        if(is_null($this->studentClassroom)){
            $this->studentClassroom = $this->student->getCurrentClassroom();
        }
        $classroom = '';
        if(!is_null($this->studentClassroom)){
            $classroom = ' - '.$this->studentClassroom->getName();
        }
        $this->toString = $this->note.' - '.$this->matter->getName().' - '.$this->exam->getName().$classroom;
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
     * Set note
     *
     * @param string $note
     *
     * @return StudentNote
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return StudentNote
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set student
     *
     * @param \SchoolBundle\Entity\Student $student
     *
     * @return StudentNote
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
     * Set exam
     *
     * @param \SchoolBundle\Entity\Exam $exam
     *
     * @return StudentNote
     */
    public function setExam(\SchoolBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \SchoolBundle\Entity\Exam
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set matter
     *
     * @param \SchoolBundle\Entity\Matter $matter
     *
     * @return StudentNote
     */
    public function setMatter(\SchoolBundle\Entity\Matter $matter = null)
    {
        $this->matter = $matter;

        return $this;
    }

    /**
     * Get matter
     *
     * @return \SchoolBundle\Entity\Matter
     */
    public function getMatter()
    {
        return $this->matter;
    }

    /**
     * Set toString
     *
     * @param string $toString
     *
     * @return StudentNote
     */
    public function setToString($toString)
    {
        $this->toString = $toString;

        return $this;
    }

    /**
     * Get toString
     *
     * @return string
     */
    public function getToString()
    {
        return $this->toString;
    }

    /**
     * Set studentClassroom
     *
     * @param \SchoolBundle\Entity\Classroom $studentClassroom
     *
     * @return StudentNote
     */
    public function setStudentClassroom(\SchoolBundle\Entity\Classroom $studentClassroom = null)
    {
        $this->studentClassroom = $studentClassroom;

        return $this;
    }

    /**
     * Get studentClassroom
     *
     * @return \SchoolBundle\Entity\Classroom
     */
    public function getStudentClassroom()
    {
        return $this->studentClassroom;
    }

    /**
     * Set bulletin
     *
     * @param \SchoolBundle\Entity\Bulletin $bulletin
     *
     * @return StudentNote
     */
    public function setBulletin(\SchoolBundle\Entity\Bulletin $bulletin = null)
    {
        $this->bulletin = $bulletin;

        return $this;
    }

    /**
     * Get bulletin
     *
     * @return \SchoolBundle\Entity\Bulletin
     */
    public function getBulletin()
    {
        return $this->bulletin;
    }
}
