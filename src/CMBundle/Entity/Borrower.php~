<?php

namespace CMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Borrower
 *
 * @ORM\Table(name="borrower")
 * @ORM\Entity(repositoryClass="CMBundle\Repository\BorrowerRepository")
 */
class Borrower
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=64, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="cni", type="string", length=255, nullable=true)
     */
    private $cni;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var Output
     *
     * @ORM\OneToOne(targetEntity="Output", mappedBy="borrower")
     * @ORM\JoinColumn(nullable=true)
     */
    private $output;

    /**
     * @var Input
     *
     * @ORM\OneToOne(targetEntity="Input", mappedBy="borrower")
     * @ORM\JoinColumn(nullable=true)
     */
    private $input;


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
     * @return Borrower
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
     * @return Borrower
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Borrower
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
     * Set cni
     *
     * @param string $cni
     *
     * @return Borrower
     */
    public function setCni($cni)
    {
        $this->cni = $cni;

        return $this;
    }

    /**
     * Get cni
     *
     * @return string
     */
    public function getCni()
    {
        return $this->cni;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Borrower
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
     * Set output
     *
     * @param \CMBundle\Entity\Output $output
     *
     * @return Borrower
     */
    public function setOutput(\CMBundle\Entity\Output $output = null)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Get output
     *
     * @return \CMBundle\Entity\Output
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Set input
     *
     * @param \CMBundle\Entity\Input $input
     *
     * @return Borrower
     */
    public function setInput(\CMBundle\Entity\Input $input = null)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return \CMBundle\Entity\Input
     */
    public function getInput()
    {
        return $this->input;
    }
}
