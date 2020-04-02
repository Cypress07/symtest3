<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity(message="Un autre produit existe déjà avec ce nom", fields={"name"})
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(min="2", minMessage="Le nom devrait faire au minimum 2 caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(min="10", minMessage="La description devrait faire au minimum 10 caractères.")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="text", nullable=true)
     */
    private $imageUrl;

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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl ?? "http://placehold.it/700x400";
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getVatRate()
    {
        return $this->category->getVatRate();
    }

    public function getPriceIncludingVAT()
    {
        return $this->price * (1 + $this->getVatRate());
    }

    public function getVAT()
    {
        return $this->price * $this->getVatRate();
    }

    /**
     * @Assert\IsTrue(message="Le nom et la description doivent être différents")
     */
    public function isNameDifferentFromDescription()
    {
        return $this->name != $this->description;
    }

    /**
     * @Assert\Callback(message="Le nom ne doit pas contenir le terme arnaque ou escroquerie")
     */
    public function isNameValid(ExecutionContextInterface $context)
    {
        if (preg_match('/arnaque|escroquerie/', $this->name)) {
            $context->buildViolation('Nom de produit invalide (ne doit pas arnaque ou escroquerie")')
                ->atPath('name')
                ->addViolation();
        }
    }
}
