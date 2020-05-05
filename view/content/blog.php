<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>
<p><a href="../content">Visa allt</a>    <a href="../content/reset">Reset</a>    <a href="../content/pages">Page</a></p>
<article>

<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1>
          <form method="post">
              <input type="hidden" name="contentSlug" value="<?= $row->slug ?>">
              <input type="submit" class="titlar" name="doEnterPage" value="<?= $row->title ?>">
          </form>
        </h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>
