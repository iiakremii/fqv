<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'The tutor name must be at least {{ limit }} characters long',
        maxMessage: 'The tutor name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]

    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $type = null;
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column]


    private ?int $montant = null;
    #[Assert\NotBlank]
    #[Assert\GreaterThan("today")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;
    #[Assert\GreaterThan("today")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contrat $contrat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $favoris = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function isFavoris(): ?bool
    {
        return $this->favoris;
    }

    public function setFavoris(?bool $favoris): static
    {
        $this->favoris = $favoris;

        return $this;
    }
}
