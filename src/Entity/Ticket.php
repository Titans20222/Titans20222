<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prixtotale;

    /**
     * @ORM\ManyToOne(targetEntity=evenement::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evennement;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixtotale(): ?float
    {
        return $this->prixtotale;
    }

    public function setPrixtotale(float $prixtotale): self
    {
        $this->prixtotale = $prixtotale;

        return $this;
    }

    public function getEvennement(): ?evenement
    {
        return $this->evennement;
    }

    public function setEvennement(?evenement $evennement): self
    {
        $this->evennement = $evennement;

        return $this;
    }

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(?users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
