<?php
namespace Saji\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of diceclass.
     */
    private $dices;
    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices hämtar dice() klassen och säger hur många gånger den ska slå.
     */
    public function __construct()
    {
        $this->dices  = new Dice(2);
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        // foreach ($this->dices->roll() as $result) {
        //     return '<pre>'. $result .'</pre>';
        // }
        $this->dices->roll();
    }

    /*
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->dices->getDicesArray();
    }

    public function values1()
    {
        return $this->dices->getDicesArray()[0];
    }

    public function values2()
    {
        return $this->dices->getDicesArray()[1];
    }

    public function isOne()
    {
        $bool = false;
        if ($this->dices->getDicesArray()[0] == 1) {
            $bool = true;
        } elseif ($this->dices->getDicesArray()[1] == 1) {
            $bool = true;
        } else {
            $bool = false;
        }

        return $bool;
    }

    public function sum()
    {
        return array_sum($this->dices->getDicesArray());
    }
}
