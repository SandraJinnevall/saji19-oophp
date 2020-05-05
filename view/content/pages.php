<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>
<p><a href="../content">Visa allt</a>    <a href="../content/reset">Reset</a>    <a href="../content/blog">Blog</a></p>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td>
          <form method="post">
              <input type="hidden" name="contentPath" value="<?= $row->path ?>">
              <input type="submit" class="titlar" name="doEnterPage" value="<?= $row->title ?>">
          </form>
        </td>
        <td><?= $row->type ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
