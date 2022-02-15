<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=categorie::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="produits")
     */
    private $createur;

    /**
     * @ORM\OneToMany(targetEntity=Linecommande::class, mappedBy="produit", orphanRemoval=true)
     */
    private $linecommandes;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="produit", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->linecommandes = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRelation(): ?categorie
    {
        return $this->relation;
    }

    public function setRelation(?categorie $relation): self
    {
        $this->relation = $relation;

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
            $linecommande->setProduit($this);
        }

        return $this;
    }

    public function removeLinecommande(Linecommande $linecommande): self
    {
        if ($this->linecommandes->removeElement($linecommande)) {
            // set the owning side to null (unless already changed)
            if ($linecommande->getProduit() === $this) {
                $linecommande->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProduit() === $this) {
                $commentaire->setProduit(null);
            }
        }

        return $this;
    }
}
