<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MedicamentRepository;


/**
 * Medicament
 *
 * @ORM\Table(name="medicament", indexes={@ORM\Index(name="fk", columns={"Id_pharmacie"})})
 * @ORM\Entity
 * * @ORM\Table(name="medicament", indexes={@ORM\Index(name="fk", columns={"Id_pharmacie"})})
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 */
class Medicament
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_medicament", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMedicament;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=200, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Prix", type="string", length=200, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \Pharmacie
     *
     * @ORM\ManyToOne(targetEntity="Pharmacie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_pharmacie", referencedColumnName="Id_pharmacie")
     * })
     */
    private $idPharmacie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qrCode;


    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(?string $qrCode): self
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getIdMedicament(): ?int
    {
        return $this->idMedicament;
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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

    public function getIdPharmacie(): ?Pharmacie
    {
        return $this->idPharmacie;
    }

    public function setIdPharmacie(?Pharmacie $idPharmacie): static
    {
        $this->idPharmacie = $idPharmacie;

        return $this;
    }


}
