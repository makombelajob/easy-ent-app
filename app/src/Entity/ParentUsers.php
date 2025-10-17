<?php

namespace App\Entity;

use App\Repository\ParentUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParentUsersRepository::class)]
class ParentUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $workspace = null;

    /**
     * @var Collection<int, Payments>
     */
    #[ORM\OneToMany(targetEntity: Payments::class, mappedBy: 'parentUsers')]
    private Collection $payments;

    /**
     * @var Collection<int, Students>
     */
    #[ORM\ManyToMany(targetEntity: Students::class, inversedBy: 'parentUsers')]
    private Collection $students;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getWorkspace(): ?string
    {
        return $this->workspace;
    }

    public function setWorkspace(string $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * @return Collection<int, Payments>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payments $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setParentUsers($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getParentUsers() === $this) {
                $payment->setParentUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Students>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Students $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }

        return $this;
    }

    public function removeStudent(Students $student): static
    {
        $this->students->removeElement($student);

        return $this;
    }
}
