<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Gissa nummret mellan 0-100! Lycka till :-)</h1>
<p>Du har <?= $tries ?> gissningar kvar.</p>
<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Gissa">
    <input type="submit" name="doInit" value="Spela igen">
    <input type="submit" name="doCheat" value="Fuska">
</form>

<?php if ($res) : ?>
    <p><b> <?= $res ?></b> </p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>Fusk!! <?= $cheat ?>.</p>
<?php endif; ?>

<!-- <pre>
<?= var_dump($_POST) ?> -->
