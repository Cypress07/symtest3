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

    /*
    public function testVatForFoodProduct() {

        //Arrange
        $pizza = $this->getProduct(5.5);
        $pizza->setPrice(10);

        //Act
        $ttc = $pizza->getPriceIncludingVAT();

        //Assert
        $this->assertEquals(10.55, $ttc);
    }
   
    public function testVatForStandardProduct(){

        //Arrange
        $car = $this->getProduct();
        $car->setPrice(100000);

        //Act
        $ttc = $car->getPriceIncludingVAT();

        //Assert
        $this->assertEquals(120000, $ttc);
    }
   */ 
    public function setUp() {
        parent::setUp();
        //todo
    }

    public function tearDown(){
        parent::tearDown();
        //todo
    }

   /**
    * @dataProvider getPricesForProducts
    */
    public function testVatForProducts (Product $product, $expectedPriceIncludingVAT)
    {
        $this->assertEquals ($expectedPriceIncludingVAT, $product->getPriceIncludingVAT());
    }

    public function getPricesForProducts()
    {
        return [
            [
                $this->getProduct(20)->setname('Porsche Carrera')->setPrice(100000), 120000
            ],
            [
                $this->getProduct(10)->setName('Doliprane')->setPrice(3), 3.3
            ],
            [
                $this->getProduct(5.5)->setName('Gatsby, Le Magnifique')->setPrice(10), 10.55
            ],
            
            [
                $this->getProduct(2.1)->setName('Télé7Jours')->setPrice(1), 1.021
            ],
        ];
    }

    /**
     * @expectedException App\Exception\BadVatRateException
     */
    public function testBadVatRateException ()
    {
        $category = new Category();
        $category->setVatRate (50);
    }
}