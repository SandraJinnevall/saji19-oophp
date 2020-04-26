<?php

namespace Saji\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class ExampleTest extends TestCase
{
    /**
     * Testar hela klassen diceHand
     */
    public function testDiceHand()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Saji\Dice\DiceHand", $dice);

        $dice->roll();
        $dice->values();
        $this->assertNotNull($dice->values());
        $this->assertNotNull($dice->values1());
        $this->assertNotNull($dice->values2());
        $this->assertIsBool($dice->IsOne());
        $this->assertNotNull($dice->sum());
    }


    /**
     * Testar klassen dice
     */
    public function testDiceRoll()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Saji\Dice\Dice", $dice);
        $dice->roll();
        $dice->values();
        $this->assertNotNull($dice->sum());
        $this->assertNotNull($dice->roll());
        $this->assertIsArray($dice->getDicesArray());
        $this->assertIsArray($dice->roll());
        $this->assertIsArray($dice->values());
        $this->assertNotNull($dice->values1());
        $this->assertNotNull($dice->values2());
        $this->assertNotNull($dice->getLastRoll());
        $this->assertIsBool($dice->IsOne());
    }

    /**
     * Kollar så getHistogramMax() inte är tom
     */
    public function testDiceHistogram2()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Saji\Dice\DiceHistogram2", $dice);

        $dice->roll();
        $this->assertNotNull($dice->getHistogramMax());
    }

    /**
     * Kollar så getAsText(), getSerie(),
     * och injectData() returnerar string
     */
    public function testHistograminjectData()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Saji\Dice\DiceHistogram2", $dice);
        $dice->roll();
        $class = new Histogram();
        $class->injectData($dice);
        $this->assertIsObject($class);
        $out = $class->getAsText();
        $this->assertIsString($out->one);
        $this->assertIsArray($class->getSerie());
        $this->assertIsArray($dice->getHistogramSerie());
    }

    /**
     * Kollar getHistogramMin() och getHistogramMax i HistogramTrait2
     */
    public function testHistogramTrait2getMin()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Saji\Dice\DiceHistogram2", $dice);
        $res = $dice->getHistogramMin();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $dice->roll();
        $this->assertSame(max($dice->getHistogramSerie()), $dice->getHistogramMax());
    }

}
