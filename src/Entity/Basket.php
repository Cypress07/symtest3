<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\BasketLine;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BasketLine", mappedBy="basket")
     */
    private $basketLines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function __construct()
    {
        $this->basketLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BasketLine[]
     */
    public function getBasketLines(): Collection
    {
        return $this->basketLines;
    }

    public function addBasketLine(BasketLine $basketLine): self
    {
        if (!$this->basketLines->contains($basketLine)) {
            $this->basketLines[] = $basketLine;
            $basketLine->setBasket($this);
        }

        return $this;
    }

    public function removeBasketLine(BasketLine $basketLine): self
    {
        if ($this->basketLines->contains($basketLine)) {
            $this->basketLines->removeElement($basketLine);
            // set the owning side to null (unless already changed)
            if ($basketLine->getBasket() === $this) {
                $basketLine->setBasket(null);
            }
        }

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTotalHT (){
        //Refactoriser code avec la fontion array_reduce()
        /*
        $total = 0;
        foreach ($this->basketLines as $basketLine) {
            $total += $basketLine->getQuantity * $basketLine->getProduct()->getPrice();
        }
        return $total;
        */
      /** @var BasketLine $basketline*/
        return array_reduce($this->basketLines->toArray(), function ($sum, $basketLine){
            return $sum + $basketLine->getQuantity() * $basketLine->getProduct()->getPrice();
      }, 0);
        
        
    }
}


