<?php

namespace Saji\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;

    public $one;
    public $two;
    public $three;
    public $four;
    public $five;
    public $six;

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $out = new Histogram();
        $out->one = "";
        $out->two = "";
        $out->three = "";
        $out->four = "";
        $out->five = "";
        $out->six = "";

        $keys = array_keys($this->serie);
        for ($i = 0; $i < count($this->serie); $i++) {
            foreach ($this->serie[$keys[$i]] as $value) {
                if ($value === 1) {
                    $out->one .= "*";
                }
                if ($value === 2) {
                    $out->two .= "*";
                }
                if ($value === 3) {
                    $out->three .= "*";
                }
                if ($value === 4) {
                    $out->four .= "*";
                }
                if ($value === 5) {
                    $out->five .= "*";
                }
                if ($value === 6) {
                    $out->six .= "*";
                }
            }
        }
        return $out;
    }
}
