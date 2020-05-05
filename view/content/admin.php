<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>
<p><a href="../content">Visa allt</a>    <a href="../content/reset">Reset</a></p>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
          <form method="post">
              <input type="hidden" name="contentId" value="<?= $row->id ?>">
              <input type="submit" name="doEdit" value="Edit">
              <input type="submit" name="doDelete" value="Delete">
          </form>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<a href="../content/create">Skapa nytt inlägg</a></p>
