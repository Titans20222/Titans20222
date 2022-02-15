<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Linecommande::class, mappedBy="commande", orphanRemoval=true)
     */
    private $linecommandes;

    public function __construct()
    {
        $this->linecommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Linecommande[]
     */
    public function getLinecommandes(): Collection
    {
        return $this->linecommandes;
    }

    public function addLinecommande(Linecommande $linecommande): self
    {
        if (!$this->linecommandes->contains($linecommande)) {
            $this->linecommandes[] = $linecommande;
            $linecommande->setCommande($this);
        }

        return $this;
    }

    public function removeLinecommande(Linecommande $linecommande): self
    {
        if ($this->linecommandes->removeElement($linecommande)) {
            // set the owning side to null (unless already changed)
            if ($linecommande->getCommande() === $this) {
                $linecommande->setCommande(null);
            }
        }

        return $this;
    }
}
