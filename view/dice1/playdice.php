<?php

namespace Anax\View;

// namespace Saji\Dice;


?><h1>Spela Dice100</h1>
<?php if ($res) :
    foreach ($res as $num) {
        ?>
        <p><?= $num ?></p>
        <?php
    }
endif; ?>


<?php if ($sum) : ?>
    <p>Summan av alla träningar är: <?= $sum ?> </p>
<?php endif; ?>

<p>Player1 har: <?= $savedSum ?> </p>
<p>Datorn har: <?= $computerSaved ?> </p>
<p>Nuvarande poäng: <?= $currentSum ?> </p>

<pre>
Ditt histogram:
1. <?= $one ?>

2. <?= $two ?>

3. <?= $three ?>

4. <?= $four ?>

5. <?= $five ?>

6. <?= $six ?>
</pre>

<pre>
Datorns histogram:
1. <?= $oneC ?>

2. <?= $twoC ?>

3. <?= $threeC ?>

4. <?= $fourC ?>

5. <?= $fiveC ?>

6. <?= $sixC ?>
</pre>

<?php if ($whoBegin) : ?>
    <p> <?= $whoBegin ?> </p>
<?php endif; ?>

<?php if ($savedSum >= 100) : ?>
    <p> Du vann!</p>
    <?= $end = true; ?>
<?php endif; ?>

<?php if ($computerSaved >= 100) : ?>
    <p> Datorn vann!</p>
    <?= $end = true; ?>
<?php endif; ?>

<?php
$doPlay = "";
$doComputer = "";
$doSave = "";

if ($turn || $end) {
    $doPlay = "disabled='disabled'";
}

if ($turn == false || $end) {
    $doComputer = "disabled='disabled'";
}

if ($turn == true || $end) {
    $doSave = "disabled='disabled'";
}
?>

<form method="post">
    <input type="submit" <?= $doPlay ?> name="doPlay" value="Spela">
    <input type='submit' <?= $doComputer ?> name='doComputer' value='Datorns tur'>
    <input type='submit' <?= $doSave ?> name='doSave' value='Spara'>
    <input type="submit" name="doInit" value="Börja om">
</form>


<!-- <pre>
<?= var_dump($_POST) ?> -->
