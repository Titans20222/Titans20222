<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomFormation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectif_global;

    /**
     * @ORM\OneToMany(targetEntity=Paiement::class, mappedBy="formation")
     */
    private $paiements;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="formations")
     */
    private $createur;

    /**
     * @ORM\OneToMany(targetEntity=FormationClient::class, mappedBy="formation", orphanRemoval=true)
     */
    private $formationClients;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->formationClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormation(): ?string
    {
        return $this->nomFormation;
    }

    public function setNomFormation(string $nomFormation): self
    {
        $this->nomFormation = $nomFormation;

        return $this;
    }

    public function getObjectifGlobal(): ?string
    {
        return $this->objectif_global;
    }

    public function setObjectifGlobal(?string $objectif_global): self
    {
        $this->objectif_global = $objectif_global;

        return $this;
    }

    /**
     * @return Collection|Paiement[]
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setFormation($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getFormation() === $this) {
                $paiement->setFormation(null);
            }
        }

        return $this;
    }

    public function getCreateur(): ?users
    {
        return $this->createur;
    }

    public function setCreateur(?users $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|FormationClient[]
     */
    public function getFormationClients(): Collection
    {
        return $this->formationClients;
    }

    public function addFormationClient(FormationClient $formationClient): self
    {
        if (!$this->formationClients->contains($formationClient)) {
            $this->formationClients[] = $formationClient;
            $formationClient->setFormation($this);
        }

        return $this;
    }

    public function removeFormationClient(FormationClient $formationClient): self
    {
        if ($this->formationClients->removeElement($formationClient)) {
            // set the owning side to null (unless already changed)
            if ($formationClient->getFormation() === $this) {
                $formationClient->setFormation(null);
            }
        }

        return $this;
    }
}
