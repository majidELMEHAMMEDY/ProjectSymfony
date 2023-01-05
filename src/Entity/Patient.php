<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $nom;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;

    /**
     * @Assert\NotBlank
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=1)
     */
    private $sexe;

    /**
     * @Assert\NotBlank
     * @ORM\OneToMany(targetEntity=Randezvou::class, mappedBy="patient")
     */
    private $randezvous;


  

    public function __construct()
    {
        $this->randezvous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, Randezvou>
     */
    public function getRandezvous(): Collection
    {
        return $this->randezvous;
    }

    public function addRandezvou(Randezvou $randezvou): self
    {
        if (!$this->randezvous->contains($randezvou)) {
            $this->randezvous[] = $randezvou;
            $randezvou->setPatient($this);
        }

        return $this;
    }

    public function removeRandezvou(Randezvou $randezvou): self
    {
        if ($this->randezvous->removeElement($randezvou)) {
            // set the owning side to null (unless already changed)
            if ($randezvou->getPatient() === $this) {
                $randezvou->setPatient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom." ".$this->prenom;
    }
   
}
