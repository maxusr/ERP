<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dossier
 *
 * @ORM\Table(name="dossier")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\DossierRepository")
 */
class Dossier extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=128)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=128)
     */
    private $type;

    const TYPES = array("Demande emploi CDD" => 0, "Demande emploi CDI" => 1, "Demande de stage" => 2, "consultant" => 3, "Stage pré-emploi" => 4);

    /**
     * @var bool
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDepot", type="date", length=128)
     */
    private $dateDepot;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="File", mappedBy="dossier", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $documents;

    /**
     * @var Personne
     *
     * @ORM\OneToOne(targetEntity="Personne", inversedBy="dossier", cascade={"persist"})
     */
    private $personne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Domaine
     *
     * @ORM\ManyToOne(targetEntity="Domaine", inversedBy="dossiers")
     */
    private $domaine;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $saver;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateDepot = new \DateTime();
        $this->archive = false;
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
     * Set name
     *
     * @param string $name
     *
     * @return Dossier
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Dossier
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Dossier
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
     * Set archive
     *
     * @param boolean $archive
     *
     * @return Dossier
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean
     */
    public function getArchive()
    {
        return $this->archive;
    }
    
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Dossier
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
     * Add document
     *
     * @param \CoreBundle\Entity\File $document
     *
     * @return Dossier
     */
    public function addDocument($document)
    {
        if($document instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $document = new File($document);
        }
        $document->setDossier($this);
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \CoreBundle\Entity\File $document
     */
    public function removeDocument(\CoreBundle\Entity\File $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set personne
     *
     * @param \CoreBundle\Entity\Personne $personne
     *
     * @return Dossier
     */
    public function setPersonne(\CoreBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \CoreBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     *
     * @return Dossier
     */
    public function setDomaine(\CoreBundle\Entity\Domaine $domaine = null)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return \CoreBundle\Entity\Domaine
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set saver
     *
     * @param \CoreBundle\Entity\User $saver
     *
     * @return Dossier
     */
    public function setSaver(\CoreBundle\Entity\User $saver = null)
    {
        $this->saver = $saver;

        return $this;
    }

    /**
     * Get saver
     *
     * @return \CoreBundle\Entity\User
     */
    public function getSaver()
    {
        return $this->saver;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    public function typeReadable() {

        $values = array_flip(self::TYPES); // transform keys to values and values to keys

        return $values[$this->type];
    }

    public function dateDepotReadable() {
        $date = new \DateTime();

        return \CoreBundle\Utils\Utils::dateFormat($this->getDateDepot());
    }

    /**
     * Set dateDepot
     *
     * @param \DateTime $dateDepot
     *
     * @return Dossier
     */
    public function setDateDepot($dateDepot)
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    /**
     * Get dateDepot
     *
     * @return \DateTime
     */
    public function getDateDepot()
    {
        return $this->dateDepot;
    }
}
