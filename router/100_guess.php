<?php
/**
 * Create routes using $app programming style.
 */

/**
 * init game och kallar på spelet.
 */
$app->router->get("guess/init", function () use ($app) {
    $game = new Saji\Guess\Guess(0, 6);
    $game->random();
    $_SESSION["number"] = $game->getNumber();
    $_SESSION["tries"] = $game->getTries();
    return $app->response->redirect("guess/play");
});



/**
 * Get för play
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game!";
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $_SESSION["res"] = null;
    $cheat = $_SESSION["cheat"] ?? null;
    $_SESSION["cheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "res" => $res,
        "cheat" => $cheat,
        "number" => $number ?? null,
        "tries" => $tries,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Post för play
 */$app->router->post("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game!";

    $guess = $_POST["guess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = null;
    $cheat = null;

    if ($doGuess) {
        $game = new Saji\Guess\Guess($number, $tries);
        // $res = $game->makeGuess($guess);
        // $_SESSION["tries"] = $game->getTries();
        // $_SESSION["res"] = $res;
        try {
            $res = $game->makeGuess($guess);
            $_SESSION["tries"] = $game->getTries();
            $_SESSION["res"] = $res;
        } catch (Saji\Guess\GuessException $e) {
            $res = $e->getMessage();
            $_SESSION["res"] = $res;
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    if ($doCheat) {
        $cheat = $number;
        $_SESSION["cheat"] = $cheat;
    }

    if ($doInit) {
        return $app->response->redirect("guess/init");
    }

    return $app->response->redirect("guess/play");
});
