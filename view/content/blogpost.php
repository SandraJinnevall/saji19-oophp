<?php



?>
<p><a href="../content/blog">Tillbaka</a>   <a href="../content">Visa allt</a>    <a href="../content/reset">Reset</a>    <a href="../content/pages">Page</a></p>
<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($content->published) ?>" pubdate><?= esc($content->published) ?></time></i></p>
    </header>
        <?= $html ?>
</article>
