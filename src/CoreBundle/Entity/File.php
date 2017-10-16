<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=32, nullable=true)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=128, nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="bigint", nullable=true)
     */
    private $size;

    /**
     * @var Email
     *
     * @ORM\ManyToOne(targetEntity="Email", inversedBy="attachments")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $attachedTo;

    /**
     * @var Dossier
     *
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="documents")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $dossier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    public $file;

    /**
     * Constructor
     *
     */
    public function __construct(UploadedFile $file = null) {
        $this->date = new \DateTime();

        if(!is_null($file))
            $this->file = $file;
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
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return File
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
     * Set extension
     *
     * @param string $extension
     *
     * @return File
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
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
     * Set size
     *
     * @param integer $size
     *
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return File
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
     * Set attachedTo
     *
     * @param \CoreBundle\Entity\Email $attachedTo
     *
     * @return File
     */
    public function setAttachedTo(\CoreBundle\Entity\Email $attachedTo = null)
    {
        $this->attachedTo = $attachedTo;

        return $this;
    }

    /**
     * Get attachedTo
     *
     * @return \CoreBundle\Entity\Email
     */
    public function getAttachedTo()
    {
        return $this->attachedTo;
    }

    /**
     * Set dossier
     *
     * @param \CoreBundle\Entity\Dossier $dossier
     *
     * @return File
     */
    public function setDossier(\CoreBundle\Entity\Dossier $dossier = null)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return \CoreBundle\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = time().'_'.sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
            $this->type = $this->file->getMimeType();
            $this->size = $this->file->getClientSize();
            $this->extension = $this->file->guessExtension();
            $this->name = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null === $this->file)
        {
            return;
        }

        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        try{
            $file = $this->file->move($this->getUploadRootDir(), $this->path);  
        }catch(\FileException $e){
            die($e->getMessage());
        }

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->path = $this->file->getClientOriginalName();
        
    }

    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($file = $this->getAbsolutePath()))
        {
            if($file = $this->getAbsolutePath()) {
                unlink($file);
            }
        }
    }
	
	public function sizeFormalize(){
		$size = $this->size;
		$result = $size.' Octets';
		if($size > 1000000000){
			$size = round($size / 1000000000, 2);
			$result = $size.' Go';
		}else if($size > 1000000){
			$size = round($size / 1000000, 2);
			$result = $size.' Mo';
		}else if($size > 1000){
			$size = round($size / 1000, 2);
			$result = $size.' Ko';
		}
		
		return $result;
	}

	public function isImage() {
		return preg_match('#image#', $this->type);
	}

	public function editeur() {
		switch ($this->getExtension()) {
			case 'pdf':
				return 'pdf';
				break;
			case 'docx':
			case 'doc':
				return 'word';
				break;
			case 'xlsx':
			case 'xls':
				return 'excel';
				break;
			case 'pptx':
			case 'ppt':
				return 'powerpoint';
				break;
			case 'rar':
			case 'gz':
			case 'gzip':
			case 'tar':
			case 'zip':
				return 'zip';
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				return 'image';
				break;
			
			default:
				return 'text';
				break;
		}
	}

    public function getObjectVars() {
        return get_object_vars($this);
    }
}
