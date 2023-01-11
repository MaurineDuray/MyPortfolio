<?php

namespace App\Entity;

use App\Repository\UserImgModifyRepository;
use Doctrine\ORM\Mapping as ORM;


class UserImgModify
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $newPicture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewPicture(): ?string
    {
        return $this->newPicture;
    }

    public function setNewPicture(string $newPicture): self
    {
        $this->newPicture = $newPicture;

        return $this;
    }
}
