<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classroom
 *
 * @ORM\Table(name="classroom")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\ClassroomRepository")
 */
class Classroom
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="numberPlaces", type="integer", nullable=true)
     */
    private $numberPlaces;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="classrooms")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $students;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StudentNote", mappedBy="studentClassroom")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $notes;


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
     * Set name
     *
     * @param string $name
     *
     * @return Classroom
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set numberPlaces
     *
     * @param integer $numberPlaces
     *
     * @return Classroom
     */
    public function setNumberPlaces($numberPlaces)
    {
        $this->numberPlaces = $numberPlaces;

        return $this;
    }

    /**
     * Get numberPlaces
     *
     * @return int
     */
    public function getNumberPlaces()
    {
        return $this->numberPlaces;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \SchoolBundle\Entity\Student $student
     *
     * @return Classroom
     */
    public function addStudent(\SchoolBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \SchoolBundle\Entity\Student $student
     */
    public function removeStudent(\SchoolBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Add note
     *
     * @param \SchoolBundle\Entity\StudentNote $note
     *
     * @return Classroom
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
