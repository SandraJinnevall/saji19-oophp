<?php
namespace Saji\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    public $number;
    public $tries;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    /*
    public function __construct(int $number = -1, int $tries = 6)
    { }
    */
    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number;
        $this->tries = $tries;
    }


    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    /*
    public function random()
    { }
    */
    public function random()
    {
        $this->number = rand(1, 100);
    }


    public function getNumber()
    {
        return $this->number;
    }

    public function getTries()
    {
        return $this->tries;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    /*
    public function makeGuess($number)
    { }
    */
    public function makeGuess($guess)
    {
        if ($this->tries == 6 or $this->tries > 1) {
            $this->tries -= 1;
            if ($guess == $this->number) {
                $this->tries = 0;
                return $res = $guess . " är rätt, GRATTIS! Tryck spela igen för att spela om.";
            } elseif ($guess > $this->number) {
                if ($guess > 100) {
                    throw new GuessException("Du får bara gissa mellan 0-100");
                }
                return $res = $guess . " är för högt! :-(";
            } elseif ($guess < $this->number) {
                if ($guess <= -1) {
                    throw new GuessException(" Du får bara gissa mellan 0-100");
                }
                return $res = $guess . " är för lågt! :-(";
            }
        } elseif ($this->tries >= 1) {
            $this->tries -= 1;
            return $res = '<h4>Slut på gissningar och du har förlorat. Tryck spela igen, för att få spela.</h4>';
        }
    }
}
