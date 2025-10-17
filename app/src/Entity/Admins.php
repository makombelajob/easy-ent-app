<?php

namespace App\Entity;

use App\Repository\AdminsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminsRepository::class)]
class Admins
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $hireDate = null;

    #[ORM\Column]
    private ?bool $isSuperAdmin = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getHireDate(): ?\DateTimeImmutable
    {
        return $this->hireDate;
    }

    public function setHireDate(?\DateTimeImmutable $hireDate): static
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function isSuperAdmin(): ?bool
    {
        return $this->isSuperAdmin;
    }

    public function setIsSuperAdmin(bool $isSuperAdmin): static
    {
        $this->isSuperAdmin = $isSuperAdmin;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

        return $this;
    }
}
