<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matter
 *
 * @ORM\Table(name="matter")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\MatterRepository")
 */
class Matter
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="coefficient", type="smallint")
     */
    private $coefficient;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Classroom", mappedBy="borrows")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $classrooms;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StudentNote", mappedBy="matter")
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
     * @return Matter
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
     * Set coefficient
     *
     * @param integer $coefficient
     *
     * @return Matter
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return int
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classrooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add classroom
     *
     * @param \SchoolBundle\Entity\Classroom $classroom
     *
     * @return Matter
     */
    public function addClassroom(\SchoolBundle\Entity\Classroom $classroom)
    {
        $this->classrooms[] = $classroom;

        return $this;
    }

    /**
     * Remove classroom
     *
     * @param \SchoolBundle\Entity\Classroom $classroom
     */
    public function removeClassroom(\SchoolBundle\Entity\Classroom $classroom)
    {
        $this->classrooms->removeElement($classroom);
    }

    /**
     * Get classrooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassrooms()
    {
        return $this->classrooms;
    }

    /**
     * Add note
     *
     * @param \SchoolBundle\Entity\StudentNote $note
     *
     * @return Matter
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
