<?php
namespace Saji\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    /**
     * @var integer $times  times to roll the dice.
     * @var integer $game  hand.
     */
    public $times;
    public $dices;

    /**
     * Constructor to create a Person.
     *
     * @param null|int    $times
     */
    public function __construct(int $times = 2)
    {
        $this->times = $times;
        $this->dices = [];
    }

    public function getDicesArray()
    {
        return $this->dices;
    }

    public function roll()
    {
        $diceRoll = 0;
        do {
            $roll = rand(1, 6);
            $diceRoll ++;
            array_push($this->dices, $roll);
        } while ($diceRoll < $this->times);
        return $this->dices;
    }

    public function values()
    {
        return $this->getDicesArray();
    }

    public function values1()
    {
        return $this->getDicesArray()[0];
    }

    public function values2()
    {
        return $this->getDicesArray()[1];
    }

    public function isOne()
    {
        $bool = false;
        if ($this->getDicesArray()[0] == 1) {
            $bool = true;
        } elseif ($this->getDicesArray()[1] == 1) {
            $bool = true;
        } else {
            $bool = false;
        }

        return $bool;
    }

    public function sum()
    {
        return array_sum($this->getDicesArray());
    }

    public function getLastRoll()
    {
        return $this->getDicesArray()[1];
    }
}
