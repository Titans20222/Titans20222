<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Numc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     */
    private $users;

    /**
     * @ORM\Column(type="date")
     */
    private $datecommande;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255, nullable=true)
     */
    private $ville = 'NULL';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresselivraison;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prix_total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumc(): ?string
    {
        return $this->Numc;
    }

    public function setNumc(string $Numc): self
    {
        $this->Numc = $Numc;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->users;
    }

    public function setUser(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getdatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setdatecommande(\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

        return $this;
    }
    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville)
    {
        $this->ville = $ville;
    }

    public function getAdresselivraison(): ?string
    {
        return $this->adresselivraison;
    }

    public function setAdresselivraison(string $adresselivraison): self
    {
        $this->adresselivraison = $adresselivraison;

        return $this;
    }

    public function getPrixtotal(): ?string
    {
        return $this->prix_total;
    }

    public function setPrixtotal(string $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

}
