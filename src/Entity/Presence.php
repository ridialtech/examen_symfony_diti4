<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(targetEntity: Seance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $status = null; // present/absent/retard

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;
        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(Seance $seance): self
    {
        $this->seance = $seance;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
