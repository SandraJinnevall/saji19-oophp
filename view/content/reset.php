<?php
namespace Anax\View;

?>
<p><a href="../content">Visa allt</a>    <a href="../content/admin">Admin</a></p>
<form method="post">
    <input type="submit" name="reset" value="Reset database">
</form>

<?php if ($output) : ?>
    <p><?= $output ?></p>
<?php endif; ?>


<?php if ($resReset) : ?>
    <p>Hej<?= $resReset ?></p>
<?php endif; ?>
