<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 * @UniqueEntity(fields={"date", "etudiant"})
 */
class Note {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")    
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * Many notes have one etudiant. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="notes")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id")
     */
    private $etudiant;

    /**
     * Many notes have one matiere. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="notes")
     * @ORM\JoinColumn(name="matiere_id", referencedColumnName="id")
     */
    private $matiere;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Note
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set note
     *
     * @param float $note
     *
     * @return Note
     */
    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Note
     */
    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire() {
        return $this->commentaire;
    }

    /**
     * Set etudiant
     *
     * @param \AppBundle\Entity\Etudiant $etudiant
     *
     * @return Note
     */
    public function setEtudiant(\AppBundle\Entity\Etudiant $etudiant = null) {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \AppBundle\Entity\Etudiant
     */
    public function getEtudiant() {
        return $this->etudiant;
    }

    /**
     * Set matiere
     *
     * @param \AppBundle\Entity\Matiere $matiere
     *
     * @return Note
     */
    public function setMatiere(\AppBundle\Entity\Matiere $matiere = null) {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AppBundle\Entity\Matiere
     */
    public function getMatiere() {
        return $this->matiere;
    }

}
