<?php

namespace App\Entity;

use App\Exception\BadVatRateException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    const STANDARD_VAT_RATE = 0.2;
    const REDUCED_VAT_RATE_10 = 0.1;
    const REDUCED_VAT_RATE_55 = 0.055;
    const REDUCED_VAT_RATE_21 = 0.021;

    const VALID_VAT_RATES = [
        self::STANDARD_VAT_RATE,
        self::REDUCED_VAT_RATE_10,
        self::REDUCED_VAT_RATE_55,
        self::REDUCED_VAT_RATE_21
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, options={"default": 0.2})
     */
    private $vatRate = 0.2;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getVatRate(): ?string
    {
        return $this->vatRate;
    }
    
    public function setVatRate(string $vatRate): self
    {     
        if ($vatRate >=1) $vatRate = $vatRate /100;

        if (!in_array ($vatRate, self::VALID_VAT_RATES)){
            throw new BadVatRateException(
            $vatRate." is not a valid VAT rate (use one of the foolwing : )"
            .implode (',', self ::VALID_VAT_RATES)
            );
        }

        $this->vatRate = $vatRate;
        return $this;
    }  
}