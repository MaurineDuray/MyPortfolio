<?php

namespace App\Entity;

use App\Repository\TechnicsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicsRepository::class)]
class Technics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Technic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechnic(): ?string
    {
        return $this->Technic;
    }

    public function setTechnic(string $Technic): self
    {
        $this->Technic = $Technic;

        return $this;
    }
}
