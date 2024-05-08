<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PharmacieRepository;

/**
 * Pharmacie
 *
 *
 * @ORM\Table(name="pharmacie")
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass=PharmacieRepository::class)
 * @ORM\Table(name="pharmacie")
 */
class Pharmacie
{
    /**
     * @var int
     *
     * 
     * @ORM\Column(name="Id_pharmacie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPharmacie;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=200, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=200, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact", type="string", length=200, nullable=false)
     */
    private $contact;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    public function getIdPharmacie(): ?int
    {
        return $this->idPharmacie;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }


}
