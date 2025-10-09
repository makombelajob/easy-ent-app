<?php

namespace App\Entity;

use App\Repository\StudentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentsRepository::class)]
class Students
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $class = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $level = null;

    /**
     * @var Collection<int, Grades>
     */
    #[ORM\OneToMany(targetEntity: Grades::class, mappedBy: 'students')]
    private Collection $grades;

    /**
     * @var Collection<int, Courses>
     */
    #[ORM\ManyToMany(targetEntity: Courses::class, mappedBy: 'students')]
    private Collection $courses;

    /**
     * @var Collection<int, Payments>
     */
    #[ORM\OneToMany(targetEntity: Payments::class, mappedBy: 'students')]
    private Collection $payments;

    /**
     * @var Collection<int, ParentUsers>
     */
    #[ORM\ManyToMany(targetEntity: ParentUsers::class, mappedBy: 'students')]
    private Collection $parentUsers;

    #[ORM\OneToOne(mappedBy: 'students', cascade: ['persist', 'remove'])]
    private ?Users $users = null;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->parentUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeImmutable $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Grades>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grades $grade): static
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
            $grade->setStudents($this);
        }

        return $this;
    }

    public function removeGrade(Grades $grade): static
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getStudents() === $this) {
                $grade->setStudents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Courses>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Courses $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addStudent($this);
        }

        return $this;
    }

    public function removeCourse(Courses $course): static
    {
        if ($this->courses->removeElement($course)) {
            $course->removeStudent($this);
        }

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
            $payment->setStudents($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getStudents() === $this) {
                $payment->setStudents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParentUsers>
     */
    public function getParentUsers(): Collection
    {
        return $this->parentUsers;
    }

    public function addParentUser(ParentUsers $parentUser): static
    {
        if (!$this->parentUsers->contains($parentUser)) {
            $this->parentUsers->add($parentUser);
            $parentUser->addStudent($this);
        }

        return $this;
    }

    public function removeParentUser(ParentUsers $parentUser): static
    {
        if ($this->parentUsers->removeElement($parentUser)) {
            $parentUser->removeStudent($this);
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setStudents(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getStudents() !== $this) {
            $users->setStudents($this);
        }

        $this->users = $users;

        return $this;
    }
}
