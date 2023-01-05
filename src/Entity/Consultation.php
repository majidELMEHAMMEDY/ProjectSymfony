<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @Assert\NotBlank
     * @ORM\OneToMany(targetEntity=Randezvou::class, mappedBy="consultation")
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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
            $randezvou->setConsultation($this);
        }

        return $this;
    }

    public function removeRandezvou(Randezvou $randezvou): self
    {
        if ($this->randezvous->removeElement($randezvou)) {
            // set the owning side to null (unless already changed)
            if ($randezvou->getConsultation() === $this) {
                $randezvou->setConsultation(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->type;
    }
}
