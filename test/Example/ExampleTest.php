<?php

namespace Saji\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class ExampleTest extends TestCase
{
    /**
     * Testar så att tärningarna finns och att det inte blir null
     */
    public function testDiceHand()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $this->assertNotNull($dice->values());
    }

    /**
     * Testar så att första tärningen inte är null
     */
    public function testDiceHandValue1()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $this->assertNotNull($dice->values1());
    }

    /**
     * Testar så att andra tärningen inte är null
     */
    public function testDiceHandValue2()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $this->assertNotNull($dice->values2());
    }

    /**
     * Kollar så isOne returnerar bool-värde
     */
    public function testDiceHandIsOne()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $dice->values();
        $this->assertIsBool($dice->IsOne());
    }

    /**
     * Testar så att sum() inte är null
     */
    public function testDiceHandSum()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $dice->values();
        $this->assertNotNull($dice->sum());
    }

    /**
     * Testar klassen dice så roll inte är null
     */
    public function testDiceRoll()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Saji\Dice\Dice", $dice);

        $this->assertNotNull($dice->roll());
    }

    /**
     * Testar klassen dice kollar så getDicesArray är en array
     */
    public function testDiceGetDicesArray()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Saji\Dice\Dice", $dice);
        $dice->roll();

        $this->assertIsArray($dice->getDicesArray());
    }

    /**
     * Testar klassen dice kollar så roll returnerar en array
     */
    public function testDiceRollIsArray()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Saji\Dice\Dice", $dice);
        $dice->roll();

        $this->assertIsArray($dice->roll());
    }
}
