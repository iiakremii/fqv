<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column]
    private ?int $duree = null;
    #[Assert\NotBlank]
    #[Assert\GreaterThan("today")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_de_souscription = null;

    #[ORM\Column(length: 255)]
    private ?string $type_couverture = null;

    #[ORM\OneToMany(mappedBy: 'contrat', targetEntity: Assurance::class, orphanRemoval: true)]
    private Collection $assurances;

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getTypeCouverture();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateDeSouscription(): ?\DateTimeInterface
    {
        return $this->date_de_souscription;
    }

    public function setDateDeSouscription(\DateTimeInterface $date_de_souscription): static
    {
        $this->date_de_souscription = $date_de_souscription;

        return $this;
    }

    public function getTypeCouverture(): ?string
    {
        return $this->type_couverture;
    }

    public function setTypeCouverture(string $type_couverture): static
    {
        $this->type_couverture = $type_couverture;

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): static
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances->add($assurance);
            $assurance->setContrat($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): static
    {
        if ($this->assurances->removeElement($assurance)) {
            // set the owning side to null (unless already changed)
            if ($assurance->getContrat() === $this) {
                $assurance->setContrat(null);
            }
        }

        return $this;
    }
}
