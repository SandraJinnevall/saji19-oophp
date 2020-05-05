<?php


?>
<p><a href="../content/pages">Tillbaka</a>   <a href="../content">Visa allt</a>    <a href="../content/reset">Reset</a>    <a href="../content/blog">Blog</a></p>
<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($content->updated) ?>" pubdate><?= esc($content->created) ?></time></i></p>
    </header>
    <?= $html ?>
</article>
