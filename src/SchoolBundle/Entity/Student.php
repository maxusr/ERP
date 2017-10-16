<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\StudentRepository")
 * @ORM\HasLifecycleCallBacks()
 */
class Student
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
     * @ORM\Column(name="firstname", type="string", length=80)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=80, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="longname", type="string", length=160)
     */
    private $longname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=160, nullable=true)
     */
    private $matricule;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    const STATUS = array("Actif" => 2, "Renvoyé" => 0, "Exclu" => 1);

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=128, nullable=true)
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=128, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sanction", mappedBy="student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $sanctions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StudentNote", mappedBy="student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $notes;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Classroom", inversedBy="students")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $classrooms;

    /**
     * @var Classroom
     *
     * @ORM\ManyToOne(targetEntity="Classroom", inversedBy="students")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $currentClassroom;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bulletin", mappedBy="student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $bulletins;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookBorrowing", mappedBy="student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $borrows;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sanctions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classrooms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bulletins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->borrows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * PrePersist/PreUpdate Function
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preAction() {
        $this->longname = $this->firstname;
        if($this->lastname != null) {
            $this->longname = $this->longname." ".$this->lastname;
        }
        if($this->currentClassroom != null) {
            if(count($this->classrooms) > 0) {
                if(!$this->classrooms->contains($this->currentClassroom)) {
                    $this->addClassroom($this->currentClassroom);
                }
            }else{
                $this->addClassroom($this->currentClassroom);
            }
        }
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Student
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Student
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Student
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Student
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Student
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Student
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return Student
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Student
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add sanction
     *
     * @param \SchoolBundle\Entity\Sanction $sanction
     *
     * @return Student
     */
    public function addSanction(\SchoolBundle\Entity\Sanction $sanction)
    {
        $this->sanctions[] = $sanction;

        return $this;
    }

    /**
     * Remove sanction
     *
     * @param \SchoolBundle\Entity\Sanction $sanction
     */
    public function removeSanction(\SchoolBundle\Entity\Sanction $sanction)
    {
        $this->sanctions->removeElement($sanction);
    }

    /**
     * Get sanctions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSanctions()
    {
        return $this->sanctions;
    }

    /**
     * Add note
     *
     * @param \SchoolBundle\Entity\StudentNote $note
     *
     * @return Student
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

    /**
     * Add classroom
     *
     * @param \SchoolBundle\Entity\Classroom $classroom
     *
     * @return Student
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
     * Add bulletin
     *
     * @param \SchoolBundle\Entity\Bulletin $bulletin
     *
     * @return Student
     */
    public function addBulletin(\SchoolBundle\Entity\Bulletin $bulletin)
    {
        $this->bulletins[] = $bulletin;

        return $this;
    }

    /**
     * Remove bulletin
     *
     * @param \SchoolBundle\Entity\Bulletin $bulletin
     */
    public function removeBulletin(\SchoolBundle\Entity\Bulletin $bulletin)
    {
        $this->bulletins->removeElement($bulletin);
    }

    /**
     * Get bulletins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBulletins()
    {
        return $this->bulletins;
    }

    /**
     * Add borrow
     *
     * @param \SchoolBundle\Entity\BookBorrowing $borrow
     *
     * @return Student
     */
    public function addBorrow(\SchoolBundle\Entity\BookBorrowing $borrow)
    {
        $this->borrows[] = $borrow;

        return $this;
    }

    /**
     * Remove borrow
     *
     * @param \SchoolBundle\Entity\BookBorrowing $borrow
     */
    public function removeBorrow(\SchoolBundle\Entity\BookBorrowing $borrow)
    {
        $this->borrows->removeElement($borrow);
    }

    /**
     * Get borrows
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBorrows()
    {
        return $this->borrows;
    }

    /**
     * Set currentClassroom
     *
     * @param \SchoolBundle\Entity\Classroom $currentClassroom
     *
     * @return Student
     */
    public function setCurrentClassroom(\SchoolBundle\Entity\Classroom $currentClassroom = null)
    {
        $this->currentClassroom = $currentClassroom;

        return $this;
    }

    /**
     * Get currentClassroom
     *
     * @return \SchoolBundle\Entity\Classroom
     */
    public function getCurrentClassroom()
    {
        return $this->currentClassroom;
    }
}
