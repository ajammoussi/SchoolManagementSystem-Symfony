<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $coursename = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $teacher = null;

    #[ORM\Column(length: 255)]
    private ?string $field = null;

    #[ORM\Column(length: 255)]
    private ?string $studylevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCoursename(): ?string
    {
        return $this->coursename;
    }

    public function setCoursename(string $coursename): static
    {
        $this->coursename = $coursename;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getStudylevel(): ?string
    {
        return $this->studylevel;
    }

    public function setStudylevel(string $studylevel): static
    {
        $this->studylevel = $studylevel;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'coursename' => $this->getCoursename(),
            'teacher' => $this->getTeacher(),
            'field' => $this->getField(),
            'studylevel' => $this->getStudylevel(),
        ];
    }
}
