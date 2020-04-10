<?php

require __DIR__ . '/config.php';
require __DIR__ . '/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("saji");
    session_start();
    if (!isset($_SESSION["guessclass"])) {
        $_SESSION["guessclass"] = new Guess(0, 6);
    }
}

$guessclass = $_SESSION["guessclass"];
$guessclass->number = $_POST["number"] ?? null;
$guessclass->tries = $_POST["tries"] ?? null;
$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;


if ($doInit || $guessclass->number === null) {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    $guessclass->tries = 6;
    $guessclass->random();
} elseif ($doGuess) {
    if ($guessclass->tries >= 0) {
        try {
            $res = $guessclass->makeGuess($guess);
        } catch (GuessException $e) {
            $res = "<p>Du får bara gissa mellan 0-100</p>";
            echo "Got exception: " . get_class($e) . $e->getMessage() . "<hr>";
        }
    }
}

require __DIR__ . '/view/view_post.php';
require __DIR__ . '/view/debug_session_post_get.php';
