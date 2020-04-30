<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>
<p><a href="movie/search-title">Sök på titlar</a>    <a href="movie/search-year">Sök på årtal</a>   <a href="movie/movie-select">Ändra, radera & skapa ny</a></p>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
