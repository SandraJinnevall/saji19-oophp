<?php

namespace Anax\View;

?>
<p><a href="../movie">Se allt</a>    <a href="../movie/search-year">Sök på årtal</a>   <a href="../movie/search-title">Sök på titel</a></p>
<form method="post">
    <fieldset>
    <legend>Select Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Add">
        <input type="submit" name="doEdit" value="Edit">
        <input type="submit" name="doDelete" value="Delete">
    </p>
    <p><a href="../movie">Show all</a></p>
    </fieldset>
</form>
