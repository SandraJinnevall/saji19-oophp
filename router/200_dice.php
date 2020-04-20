<?php
/**
 * init game och kallar på spelet.
 */
$app->router->get("dice/init", function () use ($app) {
    $player1 = new Saji\Dice\DiceHand();
    $player1->roll();
    $_SESSION["player1"] = $player1->values();
    $computerplay = new Saji\Dice\DiceHand();
    $computerplay->roll();
    $_SESSION["computerplay"] = $computerplay->values();
    $_SESSION["end"] = false;

    if ($computerplay->values1() > $player1->values1()) {
        $_SESSION["turn"] = true;
        $whoBegin = "Datorn börjar";
        $whoBegin = "Datorn börjar då den slog " . $computerplay->values1() . " och du slog " . $player1->values1();
        $_SESSION["whoBegin"] = $whoBegin;
    } else {
        $_SESSION["turn"] = false;
        $whoBegin = "Du börjar då du slog " . $player1->values1() . " och datorn slog " . $computerplay->values1();
        $_SESSION["whoBegin"] = $whoBegin;
    }

    $_SESSION["sum"] = 0;
    $_SESSION["currentSum"] = 0;
    $_SESSION["savedSum"] = 0;
    $_SESSION["computerSaved"] = 0;
    return $app->response->redirect("dice/playdice");
});



/**
 * Get för play
 */
$app->router->get("dice/playdice", function () use ($app) {
    $title = "Play Dice100!";

    $res = $_SESSION["res"] ?? null;
    $_SESSION["res"] = null;

    $value1 = $_SESSION["value1"] ?? null;
    $_SESSION["value1"] = null;

    $turn = $_SESSION["turn"] ?? null;
    $end = $_SESSION["end"] ?? null;


    //Summan från de olika.
    $sum = $_SESSION["sum"] ?? null;
    $currentSum = $_SESSION["currentSum"] ?? null;
    $computerSaved = $_SESSION["computerSaved"] ?? null;
    $savedSum = $_SESSION["savedSum"] ?? null;
    $whoBegin = $_SESSION["whoBegin"] ?? null;

    $data = [
        "res" => $res,
        "sum" => $sum,
        "whoBegin" => $whoBegin,
        "value1" => $value1,
        "turn" => $turn,
        "end" => $end,
        "computerSaved" => $computerSaved,
        "currentSum" => $currentSum,
        "savedSum" => $savedSum,
        "doPlay" => $doPlay ?? null,
        "doSave" => $doSave ?? null,
        "doInit" => $doSave ?? null,
        "doComputer" => $doComputer ?? null,
    ];

    $app->page->add("dice/playdice", $data);
    // $app->page->add("dice/debugdice");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Post för play
 */
$app->router->post("dice/playdice", function () use ($app) {
    $title = "Play Dice100!";
    //knapparna
    $doPlay = $_POST["doPlay"] ?? null;
    $doSave = $_POST["doSave"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doComputer = $_POST["doComputer"] ?? null;

    //Innehåller tärningarna och summernade poäng
    $res = null;
    $sum = null;
    $currentSum = $_SESSION["currentSum"] ?? null;
    $savedSum = $_SESSION["savedSum"] ?? null;
    $computerSaved = $_SESSION["computerSaved"] ?? null;

    //Innehåller vems tur det är, vem som börjar och vem som vann.
    $turn = $_SESSION["turn"] ?? null;
    $end = $_SESSION["end"] ?? null;
    $_SESSION["end"] = false;
    $_SESSION["whoBegin"] = " ";


    if ($doComputer) {
        $_SESSION["turn"] = true;
        $computer = new Saji\Dice\DiceHand();
        $computer->roll();
        $res = $computer->values();
        $_SESSION["res"] = $res;
        $sum = $computer->sum();
        $_SESSION["sum"] = $sum;

        //Håller koll på om det är en 1:a
        $value1 = $computer->isOne();
        $_SESSION["value1"] = $value1;

        if ($value1 == true) {
            $_SESSION["sum"] = 0;
            $_SESSION["currentSum"] = 0;
            $_SESSION["turn"] = false;
        } else {
            $_SESSION["sum"] = $computer->sum();
            $_SESSION["currentSum"] += $_SESSION["sum"];
            $_SESSION["computerSaved"] += $_SESSION["currentSum"];
            $_SESSION["currentSum"] = 0;
            $_SESSION["turn"] = false;
        }
    }

    if ($doPlay) {
        $_SESSION["turn"] = false;
        $player = new Saji\Dice\DiceHand();
        $player->roll();
        $res = $player->values();
        $_SESSION["res"] = $res;
        $sum = $player->sum();
        $_SESSION["sum"] = $sum;

        //Håller koll på om det är en 1:a
        $value1 = $player->isOne();
        $_SESSION["value1"] = $value1;

        if ($value1 == true) {
            $_SESSION["sum"] = 0;
            $_SESSION["currentSum"] = 0;
            $_SESSION["turn"] = true;
        } else {
            $_SESSION["sum"] = $player->sum();
            $_SESSION["currentSum"] += $_SESSION["sum"];
        }
    }

    if ($doSave) {
        $_SESSION["savedSum"] += $_SESSION["currentSum"];
        $_SESSION["currentSum"] = 0;
        $_SESSION["turn"] = true;
    }

    if ($doInit) {
        return $app->response->redirect("dice/init");
    }
    return $app->response->redirect("dice/playdice");
});
