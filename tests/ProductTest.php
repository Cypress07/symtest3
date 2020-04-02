<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private function getProduct ($vatRate = 20)
    {
        $category = new Category ();
        $category->setVatRate ($vatRate / 100);

        $product = new Product();
        $product->setCategory($category);

        return $product;
    }

    public function testVatForFoodProduct() {

        //Arrange
        $pizza = $this->getProduct(5.5);
        $pizza->setPrice(10);

        //Act
        $ttc = $pizza->getPriceIncludingVAT();

        //Assert
        $this->assertEquals(10.55, $ttc);
    }
   
}
