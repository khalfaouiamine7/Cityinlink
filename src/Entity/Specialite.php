<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

       public function getId(): ?int
    {
        return $this->id;
    }

       public function getNom(): ?string
       {
           return $this->nom;
       }

       public function setNom(string $nom): static
       {
           $this->nom = $nom;

           return $this;
       }

       public function getDescription(): ?string
       {
           return $this->description;
       }

       public function setDescription(string $description): static
       {
           $this->description = $description;

           return $this;
       }

       public function getType(): ?string
       {
           return $this->type;
       }

       public function setType(string $type): static
       {
           $this->type = $type;

           return $this;
       }

       public function __toString()
       {
           return $this->getNom(); // Assuming Specialite has a property called 'name'
       }
       
}
