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
    public function __construct(int $times = null)
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
}
