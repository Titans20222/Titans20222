<?php

namespace App\Entity;

use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=LigneDeCommandeRepository::class)
 */
class LigneDeCommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="ligneDeCommande")
     */
    private $commande;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Numcommande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit")
     */
    private $produit;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $qte;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ligne;


    public function getNumcommande(): ?string
    {
        return $this->Numcommande;
    }

    public function setNumcommande(string $Numcommande): self
    {
        $this->Numcommande = $Numcommande;

        return $this;
    }
    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
    public function getProduit(): ?produit
    {
        return $this->produit;
    }

    public function setProduit(?produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQte(): ?string
    {
        return $this->qte;
    }

    public function setQte(string $qte): self
    {
        $this->qte = $qte;

        return $this;
    }



    public function getLigne(): ?string
    {
        return $this->ligne;
    }

    public function setLig(string $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
}
