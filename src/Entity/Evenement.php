<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="nomEvenement is required")
      * @Groups("evenement")
     */
    private $nomEvenement;
      /**
     * @ORM\Column(type="float")
    * @Assert\Positive 
     */

    private $prix;
  
 
   /**
   * @ORM\Column(type="string")
   *  * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="required")
  */
    private $nomLieu;
 
    /**
   * @ORM\Column(type="integer")
    * @Assert\Positive
   */
  private $nbrplacedispo;
  
    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank(message="date is required")
    * @Groups("evenement")
     */
    
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="idevenement", orphanRemoval=true)
     */
    private $reservation;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

   


    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setNbrplacedispo(int  $nbrplacedispo): self
    {
        $this->nbrplacedispo = $nbrplacedispo;

        return $this;
    }
    public function getNbrplacedispo(): ?int
    {
        return $this->nbrplacedispo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(?string $nomEvenement): self
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }
   
    



    public function getNomLieu(): ?string
    {
        return $this->nomLieu;
    }

    public function setNomLieu(?string $nomLieu): self
    {
        $this->nomLieu = $nomLieu;

        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setIdevenement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getIdevenement() === $this) {
                $reservation->setIdevenement(null);
            }
        }

        return $this;
    }


    

   

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getNomEvenement();
    }  

   
}
