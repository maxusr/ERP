<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *   fields={"email"},
 *   message="L'email est déjà utilisé."
 * )
 */
class User extends \CoreBundle\Utils\JsonObject implements EquatableInterface, UserInterface, \CoreBundle\Utils\Conditionnable
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
     * @var string
     *
     * @ORM\Column(name="longname", type="string", length=132)
     */
    private $longname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=64)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=32)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=64, nullable=true)
     */
    private $telephone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_embauche", type="date", nullable=true)
     */
    private $dateEmbauche;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128)
     * @Assert\Email(message="E-mail non valide")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128)
     * @Assert\Length(
     *      min = 6,
     *      max = 60,
     *      minMessage = "Votre mot de passe doit avoir au moins {{ limit }} caractères",
     *      maxMessage = "Votre mot de passe doit avoir au plus {{ limit }} caractères"
     * )
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", unique=false)
     */
    private $roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogin", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogout", type="datetime", nullable=true)
     */
    private $lastLogout;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, unique=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="domicile", type="text", nullable=true, unique=false)
     */
    private $domicile;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiant", type="string", length=128, nullable=true)
     */
    private $identifiant;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiantType", type="string", length=64, nullable=true)
     */
    private $identifiantType;

    const IDENTIFIANT_TYPES = array('CNI' => 0, 'Passport' => 1);

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=128, nullable=true)
     */
    private $lieuNaissance;


    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="employes")
     */
    private $regionOrigine;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="text", nullable=true)
     */
    private $competence;

    /**
     * @var Domaine
     *
     * @ORM\ManyToOne(targetEntity="Domaine", inversedBy="employes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $domaine;

    /**
     * @var Domaine
     *
     * @ORM\OneToOne(targetEntity="Contrat", inversedBy="employe", cascade={"persist", "remove"})
     */
    private $contrat;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Sanction", mappedBy="employe", cascade={"persist", "remove"})
     */
    private $sanctions;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Rappel", mappedBy="sender", cascade={"persist", "remove"})
     */
    private $rappels;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Note", mappedBy="sender", cascade={"persist", "remove"})
     */
    private $notes;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Mission", mappedBy="user", cascade={"persist", "remove"})
     */
    private $missions;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Note", mappedBy="receivers", cascade={"persist", "remove"})
     */
    private $notesReceived;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Message", mappedBy="sender", cascade={"persist", "remove"})
     */
    private $messageSent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Message", mappedBy="receiver", cascade={"persist", "remove"})
     */
    private $messageReceived;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Conge", mappedBy="employe", cascade={"persist", "remove"})
     */
    private $conges;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Email", mappedBy="sender", cascade={"persist", "remove"})
     */
    private $emailsSent;

    /**
     * @var UserEchelon
     *
     * @ORM\OneToMany(targetEntity="UserEchelon", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userEchelons;

    /**
     * @var File
     *
     * @ORM\OneToOne(targetEntity="File", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Penalite", mappedBy="user", cascade={"persist", "remove"})
     */
    private $penalites;
    
    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->roles = array('ROLE_USER');

        // Pour rendre plus difficile et unique le crytage des mots de passes
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        $this->dateEmbauche = new \DateTime;
        $this->date = new \DateTime;
        $this->photo = new File();
        $this->photo->setPath('avatar.png');
        $this->active = false;
    }

    public function hasRole($role) {

        if(in_array('ROLE_ADMIN', $this->roles) || in_array('ROLE_SUPER_ADMIN', $this->roles)){
            return true;
        }

        if($this->lastEchelon() && $this->lastEchelon()->getEchelon() != null && $this->lastEchelon()->getEchelon()->getPoste() != null) {
            $permissions = $this->lastEchelon()->getEchelon()->getPoste()->getPermissions();
            if(in_array($role, $permissions)){
                return true;
            }
        }
        
        return in_array($role, $this->roles);
    }

    public function getCni() {
        return $this->identifiant;
    }

    public function can($permission) {

        if(in_array('ROLE_ADMIN', $this->roles) || in_array('ROLE_SUPER_ADMIN', $this->roles)){
            return true;
        }

        if($this->lastEchelon() && $this->lastEchelon()->getEchelon() != null && $this->lastEchelon()->getEchelon()->getPoste() != null) {
            $permissions = $this->lastEchelon()->getEchelon()->getPoste()->getPermissions();
            if(in_array($permission, $permissions)){
                return true;
            }
        }
        return false;
    }

    public function calling() {
        return $this->civility.' '.$this->name.' '.$this->surname;
    }


    public function getUsername() {
        return $this->email;
    }

    public function eraseCredentials() {
        // Ici nous n'avons rien à effacer. 
        // Cela aurait été le cas si nous avions un mot de passe en clair.
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
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
     * @return User
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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set civility
     *
     * @param string $civility
     *
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
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
     * @return User
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     *
     * @return User
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set identifiantType
     *
     * @param string $identifiantType
     *
     * @return User
     */
    public function setIdentifiantType($identifiantType)
    {
        $this->identifiantType = $identifiantType;

        return $this;
    }

    /**
     * Get identifiantType
     *
     * @return string
     */
    public function getIdentifiantType()
    {
        return $this->identifiantType;
    }

    /**
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     *
     * @return User
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * Get lieuNaissance
     *
     * @return string
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set competence
     *
     * @param string $competence
     *
     * @return User
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     *
     * @return User
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
     * Add sanction
     *
     * @param \CoreBundle\Entity\Sanction $sanction
     *
     * @return User
     */
    public function addSanction(\CoreBundle\Entity\Sanction $sanction)
    {
        $this->sanctions[] = $sanction;

        return $this;
    }

    /**
     * Remove sanction
     *
     * @param \CoreBundle\Entity\Sanction $sanction
     */
    public function removeSanction(\CoreBundle\Entity\Sanction $sanction)
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
     * Add rappel
     *
     * @param \CoreBundle\Entity\Rappel $rappel
     *
     * @return User
     */
    public function addRappel(\CoreBundle\Entity\Rappel $rappel)
    {
        $this->rappels[] = $rappel;

        return $this;
    }

    /**
     * Remove rappel
     *
     * @param \CoreBundle\Entity\Rappel $rappel
     */
    public function removeRappel(\CoreBundle\Entity\Rappel $rappel)
    {
        $this->rappels->removeElement($rappel);
    }

    /**
     * Get rappels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRappels()
    {
        return $this->rappels;
    }

    /**
     * Add note
     *
     * @param \CoreBundle\Entity\Note $note
     *
     * @return User
     */
    public function addNote(\CoreBundle\Entity\Note $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \CoreBundle\Entity\Note $note
     */
    public function removeNote(\CoreBundle\Entity\Note $note)
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
     * Add notesReceived
     *
     * @param \CoreBundle\Entity\Note $notesReceived
     *
     * @return User
     */
    public function addNotesReceived(\CoreBundle\Entity\Note $notesReceived)
    {
        $this->notesReceived[] = $notesReceived;

        return $this;
    }

    /**
     * Remove notesReceived
     *
     * @param \CoreBundle\Entity\Note $notesReceived
     */
    public function removeNotesReceived(\CoreBundle\Entity\Note $notesReceived)
    {
        $this->notesReceived->removeElement($notesReceived);
    }

    /**
     * Get notesReceived
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotesReceived()
    {
        return $this->notesReceived;
    }

    /**
     * Add messageSent
     *
     * @param \CoreBundle\Entity\Message $messageSent
     *
     * @return User
     */
    public function addMessageSent(\CoreBundle\Entity\Message $messageSent)
    {
        $this->messageSent[] = $messageSent;

        return $this;
    }

    /**
     * Remove messageSent
     *
     * @param \CoreBundle\Entity\Message $messageSent
     */
    public function removeMessageSent(\CoreBundle\Entity\Message $messageSent)
    {
        $this->messageSent->removeElement($messageSent);
    }

    /**
     * Get messageSent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessageSent()
    {
        return $this->messageSent;
    }

    /**
     * Add messageReceived
     *
     * @param \CoreBundle\Entity\Message $messageReceived
     *
     * @return User
     */
    public function addMessageReceived(\CoreBundle\Entity\Message $messageReceived)
    {
        $this->messageReceived[] = $messageReceived;

        return $this;
    }

    /**
     * Remove messageReceived
     *
     * @param \CoreBundle\Entity\Message $messageReceived
     */
    public function removeMessageReceived(\CoreBundle\Entity\Message $messageReceived)
    {
        $this->messageReceived->removeElement($messageReceived);
    }

    /**
     * Get messageReceived
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessageReceived()
    {
        return $this->messageReceived;
    }

    /**
     * Add contrat
     *
     * @param \CoreBundle\Entity\Contrat $contrat
     *
     * @return User
     */
    public function addContrat(\CoreBundle\Entity\Contrat $contrat)
    {
        $this->contrats[] = $contrat;

        return $this;
    }

    /**
     * Remove contrat
     *
     * @param \CoreBundle\Entity\Contrat $contrat
     */
    public function removeContrat(\CoreBundle\Entity\Contrat $contrat)
    {
        $this->contrats->removeElement($contrat);
    }

    /**
     * Get contrats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContrats()
    {
        return $this->contrats;
    }

    /**
     * Add conge
     *
     * @param \CoreBundle\Entity\Conge $conge
     *
     * @return User
     */
    public function addConge(\CoreBundle\Entity\Conge $conge)
    {
        $this->conges[] = $conge;

        return $this;
    }

    /**
     * Remove conge
     *
     * @param \CoreBundle\Entity\Conge $conge
     */
    public function removeConge(\CoreBundle\Entity\Conge $conge)
    {
        $this->conges->removeElement($conge);
    }

    /**
     * Get conges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConges()
    {
        return $this->conges;
    }

    /**
     * Add emailsSent
     *
     * @param \CoreBundle\Entity\Email $emailsSent
     *
     * @return User
     */
    public function addEmailsSent(\CoreBundle\Entity\Email $emailsSent)
    {
        $this->emailsSent[] = $emailsSent;

        return $this;
    }

    /**
     * Remove emailsSent
     *
     * @param \CoreBundle\Entity\Email $emailsSent
     */
    public function removeEmailsSent(\CoreBundle\Entity\Email $emailsSent)
    {
        $this->emailsSent->removeElement($emailsSent);
    }

    /**
     * Get emailsSent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmailsSent()
    {
        return $this->emailsSent;
    }

    /**
     * Set photo
     *
     * @param \CoreBundle\Entity\File $photo
     *
     * @return User
     */
    public function setPhoto($photo = null)
    {
        if($photo instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $photo = new File($photo);
        }

        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \CoreBundle\Entity\File
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->longname = $this->civility.' '.$this->name.' '.$this->surname;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return User
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

    public function getObjectVars() {
        return get_object_vars($this);
    }

    /**
     * Set regionOrigine
     *
     * @param \CoreBundle\Entity\Region $regionOrigine
     *
     * @return User
     */
    public function setRegionOrigine(\CoreBundle\Entity\Region $regionOrigine = null)
    {
        $this->regionOrigine = $regionOrigine;

        return $this;
    }

    /**
     * Get regionOrigine
     *
     * @return \CoreBundle\Entity\Region
     */
    public function getRegionOrigine()
    {
        return $this->regionOrigine;
    }

    public function identifiantReadable() {
        $keys = array_flip(User::IDENTIFIANT_TYPES);

        return $keys[$this->identifiantType];
    }

    /**
     * Add userEchelon
     *
     * @param \CoreBundle\Entity\UserEchelon $userEchelon
     *
     * @return User
     */
    public function addUserEchelon(\CoreBundle\Entity\UserEchelon $userEchelon)
    {
        $this->userEchelons[] = $userEchelon;

        return $this;
    }

    /**
     * Remove userEchelon
     *
     * @param \CoreBundle\Entity\UserEchelon $userEchelon
     */
    public function removeUserEchelon(\CoreBundle\Entity\UserEchelon $userEchelon)
    {
        $this->userEchelons->removeElement($userEchelon);
    }

    /**
     * Get userEchelons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserEchelons()
    {
        return $this->userEchelons;
    }

    /**
     * Set domicile
     *
     * @param string $domicile
     *
     * @return User
     */
    public function setDomicile($domicile)
    {
        $this->domicile = $domicile;

        return $this;
    }

    /**
     * Get domicile
     *
     * @return string
     */
    public function getDomicile()
    {
        return $this->domicile;
    }

    public function lastEchelon() {
        $echelons = $this->userEchelons;
        if(empty($echelons)){
            return null;
        }else{
            if($this->userEchelons instanceof \Doctrine\Common\Collections\Collection){
                return $this->userEchelons->last();
            }else{
                return end($this->userEchelons);
            }
        }
    }

    public function firstEchelon() {
        $echelons = $this->userEchelons;
        if(empty($echelons)){
            return null;
        }else{
            if($this->userEchelons instanceof \Doctrine\Common\Collections\Collection){
                return $this->userEchelons->first();
            }else{
                return reset($this->userEchelons);
            }
        }
    }

    public function congeRestant() {
        $conge = array();
        foreach ($this->conges as $key => $co) {
            $debut = $co->getDebut(); 
            if($debut->format('Y') == date('Y')){
                $conge[] = $co;
            }
        }
        $duree = 0;
        foreach ($conge as $key => $c) {
            $duree = $duree + $c->duree();
        }
        if($this->lastEchelon() && !is_null($this->lastEchelon()->getEchelon())){
            $restant = $this->lastEchelon()->getEchelon()->getDureeConge();
        }else{
            $restant = 0;
        }
        if($duree){
            $restant = $restant - $duree;
        }

        return $restant;
    }

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     *
     * @return User
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return \DateTime
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return User
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

    public function dateReadable() {
        return \CoreBundle\Utils\Utils::dateFormat($this->date);
    }

    public function dateEmbaucheReadable() {
        $date = empty($this->dateEmbauche) ? new \DateTime():$this->dateEmbauche;
        return \CoreBundle\Utils\Utils::dateFormat($date);
    }

    public function congeCetteAnnee() {
        $a = array('duree' => 0, 'nombre' => 0);

        foreach ($this->conges as $key => $conge) {
            if($conge->getDebut()->format('Y') == date('Y')){
                $a['duree'] = $a['duree'] + $conge->duree();
                $a['nombre'] = $a['nombre'] + 1;
            }
        }

        return $a;
    }

    public function dureeAnneeConge() {
        $d = $this->congeCetteAnnee();

        return $d['duree'];
    }

    public function nombreAnneeConge() {
        $d = $this->congeCetteAnnee();

        return $d['nombre'];
    }

    public function congeCeMois() {
        $a = array('duree' => 0, 'nombre' => 0);

        foreach ($this->conges as $key => $conge) {
            if($conge->getDebut()->format('Y') == date('Y') && $conge->getDebut()->format('m') == date('m')){
                $a['duree'] = $a['duree'] + $conge->duree();
                $a['nombre'] = $a['nombre'] + 1;
            }
        }

        return $a;
    }

    public function dureeMoisConge() {
        $d = $this->congeCeMois();

        return $d['duree'];
    }

    public function nombreMoisConge() {
        $d = $this->congeCeMois();

        return $d['nombre'];
    }

    public function sanctionCetteAnnee() {
        $a = array('duree' => 0, 'nombre' => 0);

        foreach ($this->sanctions as $key => $conge) {
            if($conge->getDebut()->format('Y') == date('Y')){
                $a['duree'] = $a['duree'] + $conge->duree();
                $a['nombre'] = $a['nombre'] + 1;
            }
        }

        return $a;
    }

    public function sanctionCeMois() {
        $a = array('duree' => 0, 'nombre' => 0);

        foreach ($this->sanctions as $key => $conge) {
            if($conge->getDebut()->format('Y') == date('Y') && $conge->getDebut()->format('m') == date('m')){
                $a['duree'] = $a['duree'] + $conge->duree();
                $a['nombre'] = $a['nombre'] + 1;
            }
        }

        return $a;
    }

    /**
     * Set contrat
     *
     * @param \CoreBundle\Entity\Contrat $contrat
     *
     * @return User
     */
    public function setContrat(\CoreBundle\Entity\Contrat $contrat = null)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return \CoreBundle\Entity\Contrat
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Add mission
     *
     * @param \CoreBundle\Entity\Mission $mission
     *
     * @return User
     */
    public function addMission(\CoreBundle\Entity\Mission $mission)
    {
        $this->missions[] = $mission;

        return $this;
    }

    /**
     * Remove mission
     *
     * @param \CoreBundle\Entity\Mission $mission
     */
    public function removeMission(\CoreBundle\Entity\Mission $mission)
    {
        $this->missions->removeElement($mission);
    }

    /**
     * Get missions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMissions()
    {
        return $this->missions;
    }

    /**
     * Add penalite
     *
     * @param \CoreBundle\Entity\Penalite $penalite
     *
     * @return User
     */
    public function addPenalite(\CoreBundle\Entity\Penalite $penalite)
    {
        $this->penalites[] = $penalite;

        return $this;
    }

    /**
     * Remove penalite
     *
     * @param \CoreBundle\Entity\Penalite $penalite
     */
    public function removePenalite(\CoreBundle\Entity\Penalite $penalite)
    {
        $this->penalites->removeElement($penalite);
    }

    /**
     * Get penalites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPenalites()
    {
        return $this->penalites;
    }


    public function getAge() {
        $now = new \DateTime();
        $diff = $this->getDateNaissance()->diff($now);

        return $diff->y;
    }

    public function getSexe() {
        if(strtolower($this->civility) == 'm') {
            return 'm';
        }

        return 'f';
    }

    public function getRegion() {
        return $this->regionOrigine->getName();
    }

    public function getProfile() {
        return $this->getCompetence();
    }

    public function getDomaines() {
        return [$this->domaine];
    }

    public function conditionOf() {
        return 'user';
    }

    /**
     * Set lastLogout
     *
     * @param \DateTime $lastLogout
     *
     * @return User
     */
    public function setLastLogout($lastLogout)
    {
        $this->lastLogout = $lastLogout;

        return $this;
    }

    /**
     * Get lastLogout
     *
     * @return \DateTime
     */
    public function getLastLogout()
    {
        return $this->lastLogout;
    }
}
