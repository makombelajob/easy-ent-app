<?php

namespace App\Entity;

use App\Repository\TeachersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeachersRepository::class)]
class Teachers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $teacherNumber = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $speciality = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $hireDate = null;

    /**
     * @var Collection<int, Grades>
     */
    #[ORM\OneToMany(targetEntity: Grades::class, mappedBy: 'teachers')]
    private Collection $grades;

    /**
     * @var Collection<int, Courses>
     */
    #[ORM\ManyToMany(targetEntity: Courses::class, inversedBy: 'teachers')]
    private Collection $courses;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacherNumber(): ?string
    {
        return $this->teacherNumber;
    }

    public function setTeacherNumber(string $teacherNumber): static
    {
        $this->teacherNumber = $teacherNumber;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function setSpeciality(?string $speciality): static
    {
        $this->speciality = $speciality;

        return $this;
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
            $grade->setTeachers($this);
        }

        return $this;
    }

    public function removeGrade(Grades $grade): static
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getTeachers() === $this) {
                $grade->setTeachers(null);
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
        }

        return $this;
    }

    public function removeCourse(Courses $course): static
    {
        $this->courses->removeElement($course);

        return $this;
    }
}
