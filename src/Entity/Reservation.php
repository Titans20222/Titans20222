<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(
     *     message = "le nombre doit etre positive "
     * )
     */
    private $nbrplace;
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
    
     * * @Assert\Email(
     *     message = "le email '{{ value }}' n'est pas valide."
     * )
     * 
     * **/
    private $adresseemail;
     

    
    /**
     * @ORM\Column(type="integer")
      * @Assert\Positive(
     *     message = "le numero doit etre positive " )
     * )
     */
     private $numtel;
    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="reservation")
     * @ORM\JoinColumn(nullable=false)
     
     */
    private $idevenement;

    public function getId(): ?int
    {
        return $this->id;
    }
   

    
    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getNbrplace(): ?int
    {
        return $this->nbrplace;
    }


    
    public function setNbrplace(int $nbrplace): self
    {
        $this->nbrplace = $nbrplace;

        return $this;
    }
    public function getNumtel(): ?int
    {
        return $this->numtel;
    }


    
    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }
    public function getAdresseemail(): ?string
    {
        return $this->adresseemail;
    }

    public function setAdresseemail(string $adresseemail): self
    {
        $this-> adresseemail= $adresseemail;

        return $this;
    }
    public function getIdevenement(): ?Evenement
    {
        return $this->idevenement;
    }

    public function setIdevenement(?Evenement $idevenement): self
    {
        $this->idevenement = $idevenement;

        return $this;
    }
}
