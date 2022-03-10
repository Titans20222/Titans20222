<?php

namespace App\Entity;

use App\Repository\FormationRepository;
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
}
