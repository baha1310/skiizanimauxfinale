<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity()
 */
class Annonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_annonce", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_annonce;
    /**
     * @var string
     *
     * @ORM\Column(name="titre_annonce", type="string", nullable=false)
     */
    private $titre_annonce;
    /**
     * @var string
     *
     * @ORM\Column(name="description_annonce", type="string", nullable=false)
     */
    private $description_annonce;
    /**
     * @var date
     *
     * @ORM\Column(name="date_annonce", type="date", nullable=true)
     */
    private $date_annonce;
    /**
     * @var string
     *@Assert\NotBlank(message="Please, upload an image.")
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=2000, nullable=true)
     */
    private $image;
    /**
     * @var string
     *
     * @ORM\Column(name="type_annonce", type="string", nullable=true)
     */
    private $type_annonce;
    /**
     * @var \Animal
     *
     * @ORM\ManyToOne(targetEntity="Animal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_animal", referencedColumnName="id_animal")
     * })
     */
    private $id_animal;
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @return \User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \User $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitreAnnonce()
    {
        return $this->titre_annonce;
    }

    /**
     * @param string $titre_annonce
     */
    public function setTitreAnnonce($titre_annonce)
    {
        $this->titre_annonce = $titre_annonce;
    }

    /**
     * @return string
     */
    public function getDescriptionAnnonce()
    {
        return $this->description_annonce;
    }

    /**
     * @param string $description_annonce
     */
    public function setDescriptionAnnonce($description_annonce)
    {
        $this->description_annonce = $description_annonce;
    }

    /**
     * @return date
     */
    public function getDateAnnonce()
    {
        return $this->date_annonce;
    }

    /**
     * @param date $date_annonce
     */
    public function setDateAnnonce($date_annonce)
    {
        $this->date_annonce = $date_annonce;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * @return string
     */
    public function getTypeAnnonce()
    {
        return $this->type_annonce;
    }

    /**
     * @param string $type_annonce
     */
    public function setTypeAnnonce($type_annonce)
    {
        $this->type_annonce = $type_annonce;
    }

    /**
     * @return \Animal
     */
    public function getIdAnimal()
    {
        return $this->id_animal;
    }

    /**
     * @param \Animal $id_animal
     */
    public function setIdAnimal($id_animal)
    {
        $this->id_animal = $id_animal;
    }



    /**
     * @return int
     */
    public function getIdAnnonce()
    {
        return $this->id_annonce;
    }

    /**
     * @param int $id_annonce
     */
    public function setIdAnnonce($id_annonce)
    {
        $this->id_annonce = $id_annonce;
    }



}

