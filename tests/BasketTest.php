<?php

namespace App\Tests;

use App\Entity\Basket;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    public function testTotalHTOnNewBasket()
    {
        $basket = new Basket ();
        $this->assertSame(0, $basket->getTotalHT());
    }
}
