<h1>Gissa nummret mellan 0-100! Lycka till :-)</h1>
<p>Du har <?= $guessclass->getTries() ?> gissningar kvar.</p>
<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $guessclass->getNumber() ?>">
    <input type="hidden" name="tries" value="<?= $guessclass->getTries() ?>">
    <input type="submit" name="doGuess" value="Gissa">
    <input type="submit" name="doInit" value="Spela igen">
    <input type="submit" name="doCheat" value="Fuska">
</form>

<?php if ($doGuess) : ?>
    <p><b> <?= $res ?> </b> </p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>Fusk!! <?= $guessclass->getNumber() ?>.</p>
<?php endif; ?>

<!-- <pre>
<?= var_dump($_POST) ?> -->
