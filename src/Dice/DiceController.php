<?php

namespace Saji\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;


    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "INDEX!!";
    }

    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Det funkar!!";
    }

    public function initAction() : object
    {
        $player1 = new DiceHistogram2();
        $player1->roll();
        $this->app->session->set("player1", $player1->values());
        $computerplay = new DiceHistogram2();
        $computerplay->roll();

        $this->app->session->set("computerplay", $computerplay->values());
        $this->app->session->set("end", false);

        if ($computerplay->values1() > $player1->values1()) {
            $this->app->session->set("turn", true);
            $whoBegin = "Datorn börjar";
            $whoBegin = "Datorn börjar då den slog " . $computerplay->values1() . " och du slog " . $player1->values1();
            $this->app->session->set("whoBegin", $whoBegin);
        } else {
            $this->app->session->set("turn", false);
            $whoBegin = "Du börjar då du slog " . $player1->values1() . " och datorn slog " . $computerplay->values1();
            $this->app->session->set("whoBegin", $whoBegin);
        }

        $this->app->session->set("sum", 0);
        $this->app->session->set("currentSum", 0);
        $this->app->session->set("savedSum", 0);
        $this->app->session->set("computerSaved", 0);

        $this->app->session->set("one", "");
        $this->app->session->set("two", "");
        $this->app->session->set("three", "");
        $this->app->session->set("four", "");
        $this->app->session->set("five", "");
        $this->app->session->set("six", "");

        $this->app->session->set("oneC", "");
        $this->app->session->set("twoC", "");
        $this->app->session->set("threeC", "");
        $this->app->session->set("fourC", "");
        $this->app->session->set("fiveC", "");
        $this->app->session->set("sixC", "");
        return $this->app->response->redirect("dice1/playdice");
    }

    public function playdiceActionGet() : object
    {
        $title = "Play Dice100!";

        $res = $this->app->session->get("res");
        $this->app->session->set("res", null);

        $one = $this->app->session->get("one");
        $two = $this->app->session->get("two");
        $three = $this->app->session->get("three");
        $four = $this->app->session->get("four");
        $five = $this->app->session->get("five");
        $six = $this->app->session->get("six");

        $oneC = $this->app->session->get("oneC");
        $twoC = $this->app->session->get("twoC");
        $threeC = $this->app->session->get("threeC");
        $fourC = $this->app->session->get("fourC");
        $fiveC = $this->app->session->get("fiveC");
        $sixC = $this->app->session->get("sixC");

        $turn = $this->app->session->get("turn");
        $end = $this->app->session->get("end");


        //Summan från de olika.
        $sum = $this->app->session->get("sum");
        $currentSum = $this->app->session->get("currentSum");
        $computerSaved = $this->app->session->get("computerSaved");
        $savedSum = $this->app->session->get("savedSum");
        $whoBegin = $this->app->session->get("whoBegin");


        $data = [
            "res" => $res,
            "one" => $one,
            "two" => $two,
            "three" => $three,
            "four" => $four,
            "five" => $five,
            "six" => $six,
            "oneC" => $oneC,
            "twoC" => $twoC,
            "threeC" => $threeC,
            "fourC" => $fourC,
            "fiveC" => $fiveC,
            "sixC" => $sixC,
            "sum" => $sum,
            "whoBegin" => $whoBegin,
            "turn" => $turn,
            "end" => $end,
            "computerSaved" => $computerSaved,
            "currentSum" => $currentSum,
            "savedSum" => $savedSum
        ];

        $this->app->page->add("dice1/playdice", $data);
        // $this->app->page->add("dice1/debugdice");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function playdiceActionPost() : string
    {
        $doPlay = $this->app->request->getPost("doPlay");
        $doSave = $this->app->request->getPost("doSave");
        $doInit = $this->app->request->getPost("doInit");
        $doComputer = $this->app->request->getPost("doComputer");
        $this->app->session->set("end", false);
        $this->app->session->set("whoBegin", " ");
        $svd = $this->app->session->get("savedSum");
        if ($doComputer) {
            $this->app->session->set("turn", true);
            $computer = new DiceHistogram2();
            $computer->roll();
            $this->app->session->set("res", $computer->values());
            $this->app->session->set("sum", $computer->sum());
            $histograms = new Histogram();
            $histograms->injectData($computer);
            $histograms->getSerie();
            $computerHistogram = $histograms->getAsText();
            $oneC = $this->app->session->get("oneC");
            $this->app->session->set("oneC", $oneC .= $computerHistogram->one);
            $twoC = $this->app->session->get("twoC");
            $this->app->session->set("twoC", $twoC .= $computerHistogram->two);
            $threeC = $this->app->session->get("threeC");
            $this->app->session->set("threeC", $threeC .= $computerHistogram->three);
            $fourC = $this->app->session->get("fourC");
            $this->app->session->set("fourC", $fourC .= $computerHistogram->four);
            $fiveC = $this->app->session->get("fiveC");
            $this->app->session->set("fiveC", $fiveC .= $computerHistogram->five);
            $sixC = $this->app->session->get("sixC");
            $this->app->session->set("sixC", $sixC .= $computerHistogram->six);
            if ($computer->isOne() == true) {
                $this->app->session->set("sum", 0);
                $this->app->session->set("currentSum", 0);
                $this->app->session->set("turn", false);
            } else {
                $curr = $this->app->session->get("currentSum");
                $summ = $this->app->session->get("sum");
                $csv = $this->app->session->get("computerSaved");
                $this->app->session->set("sum", $computer->sum());
                $this->app->session->set("currentSum", $curr += $summ);
                if ($csv < $svd) {
                    $this->app->session->set("turn", true);
                    if ($curr > $svd) {
                        $this->app->session->set("computerSaved", $csv += $curr);
                        $this->app->session->set("currentSum", 0);
                        $this->app->session->set("turn", false);
                    }
                } else {
                    $this->app->session->set("computerSaved", $csv += $curr);
                    $this->app->session->set("currentSum", 0);
                    $this->app->session->set("turn", false);
                }
            }
        }
        if ($doPlay) {
            $this->app->session->set("turn", false);
            $player = new DiceHistogram2();
            $player->roll();
            $histogram = new Histogram();
            $histogram->injectData($player);
            $histogram->getSerie();
            $yourHistogram = $histogram->getAsText();
            $one = $this->app->session->get("one");
            $this->app->session->set("one", $one .= $yourHistogram->one);
            $two = $this->app->session->get("two");
            $this->app->session->set("two", $two .= $yourHistogram->two);
            $three = $this->app->session->get("three");
            $this->app->session->set("three", $three .= $yourHistogram->three);
            $four = $this->app->session->get("four");
            $this->app->session->set("four", $four .= $yourHistogram->four);
            $five = $this->app->session->get("five");
            $this->app->session->set("five", $five .= $yourHistogram->five);
            $six = $this->app->session->get("six");
            $this->app->session->set("six", $six .= $yourHistogram->six);
            $this->app->session->set("res", $player->values());
            $this->app->session->set("sum", $player->sum());
            if ($player->isOne() == true) {
                $this->app->session->set("sum", 0);
                $this->app->session->set("currentSum", 0);
                $this->app->session->set("turn", true);
            } else {
                $curr = $this->app->session->get("currentSum");
                $summ = $this->app->session->get("sum");
                $this->app->session->set("sum", $player->sum());
                $this->app->session->set("currentSum", $curr += $summ);
            }
        }
        if ($doSave) {
            $curr = $this->app->session->get("currentSum");
            $this->app->session->set("savedSum", $svd += $curr);
            $this->app->session->set("currentSum", 0);
            $this->app->session->set("turn", true);
        }
        if ($doInit) {
            return $this->app->response->redirect("dice1/init");
        }
        return $this->app->response->redirect("dice1/playdice");
    }
}
