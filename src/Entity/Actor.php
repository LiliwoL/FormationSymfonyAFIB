<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Pour pouvoir utiliser les contraintes d'assertion
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * Assertion pour obliger à remplir ce champ
     * @Assert\NotBlank (message="Veuillez saisir un nom valide!")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     *
     * On exige un age supérieur à 18 ans
     * @Assert\Type(type = "integer", message = "L'âge doit être numérique")
     *
     * L'assertion suivante est commentée
     * Assert\GreaterThan(
     *      value = "18",
     *      message = "Vous devez avoir plus de 18 ans pour être acteur.rice"
     *  )
     * @Assert\Regex(
     *     pattern="/^[2-9]{1}$/",
     *     htmlPattern = "^[2-9]{1}$"
     * )
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $biography;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", mappedBy="actors")
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            $movie->removeActor($this);
        }

        return $this;
    }

    // Une fonction pour renvoyer un affichage du nom complet
    public function getDisplayName()
    {
        return $this->firstname . " " . $this->lastname;
    }
}
