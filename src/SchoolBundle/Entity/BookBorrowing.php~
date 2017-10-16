<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookBorrowing
 *
 * @ORM\Table(name="book_borrowing")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\BookBorrowingRepository")
 * @ORM\HasLifecycleCallBacks()
 */
class BookBorrowing
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
     * @ORM\Column(name="madeAt", type="datetime")
     */
    private $madeAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="returnAt", type="datetime", nullable=true)
     */
    private $returnAt;

    /**
     * @var int
     *
     * @ORM\Column(name="daysOfBorrowing", type="integer")
     */
    private $daysOfBorrowing;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="borrows")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $student;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Book")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $books;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();
        $this->madeAt = new \DateTime;
        $this->daysOfBorrowing = 14;
    }


    /**
     * PrePersist/PreUpdate Function
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preAction() {
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
     * Set madeAt
     *
     * @param \DateTime $madeAt
     *
     * @return BookBorrowing
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

    /**
     * Set returnAt
     *
     * @param \DateTime $returnAt
     *
     * @return BookBorrowing
     */
    public function setReturnAt($returnAt)
    {
        $this->returnAt = $returnAt;

        return $this;
    }

    /**
     * Get returnAt
     *
     * @return \DateTime
     */
    public function getReturnAt()
    {
        return $this->returnAt;
    }

    /**
     * Set daysOfBorrowing
     *
     * @param integer $daysOfBorrowing
     *
     * @return BookBorrowing
     */
    public function setDaysOfBorrowing($daysOfBorrowing)
    {
        $this->daysOfBorrowing = $daysOfBorrowing;

        return $this;
    }

    /**
     * Get daysOfBorrowing
     *
     * @return int
     */
    public function getDaysOfBorrowing()
    {
        return $this->daysOfBorrowing;
    }

    /**
     * Set student
     *
     * @param \SchoolBundle\Entity\Student $student
     *
     * @return BookBorrowing
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
     * Add book
     *
     * @param \SchoolBundle\Entity\Book $book
     *
     * @return BookBorrowing
     */
    public function addBook(\SchoolBundle\Entity\Book $book)
    {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book
     *
     * @param \SchoolBundle\Entity\Book $book
     */
    public function removeBook(\SchoolBundle\Entity\Book $book)
    {
        $this->books->removeElement($book);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooks()
    {
        return $this->books;
    }

    public function finished() {
        $fin = clone $this->getMadeAt();
        $interval = new \DateInterval('P'.$this->getDaysOfBorrowing().'D');
        $today = new \DateTime;
        $fin = $fin->add($interval);
        if($fin >= $today) {
            return true;
        }
        return false;
    }

    public function toReturnAt() {
        $interval = new \DateInterval('P'.$this->getDaysOfBorrowing().'D');
        $date = $this->madeAt->add($interval);

        return $date;
    }
}
