<?php

namespace App\Entity;

use App\Repository\RandezvouRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RandezvouRepository::class)
 */
class Randezvou
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="time")
     */
    private $heuredebut;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="time")
     */
    private $heurefin;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="randezvous")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=Consultation::class, inversedBy="randezvous")
     * @ORM\JoinColumn(nullable=false)
     */
    private $consultation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeuredebut(): ?\DateTimeInterface
    {
        return $this->heuredebut;
    }

    public function setHeuredebut($heuredebut): self
    {
        $this->heuredebut = $heuredebut;

        return $this;
    }

    public function getHeurefin(): ?\DateTimeInterface
    {
        return $this->heurefin;
    }

    public function setHeurefin($heurefin): self
    {
        $this->heurefin = $heurefin;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): self
    {
        $this->consultation = $consultation;

        return $this;
    }
}
