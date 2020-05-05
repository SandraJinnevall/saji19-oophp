<?php
/**
 * Show all content.
 */
$app->router->get("content", function () use ($app) {
    $title = "My Content Database";

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("content/index", [
        "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * RESET
 */
$app->router->get("content/reset", function () use ($app) {
    $title = "My Content Database";

    $output = $_SESSION["output"] ?? null;
    $resReset = $_SESSION["resReset"] ?? null;

    $app->page->add("content/reset", [
        "reset" => $reset ?? null,
        "output" => $output,
        "resReset" => $resReset,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("content/reset", function () use ($app) {
    $reset = $_POST["reset"] ?? null;

    // Restore the database to its original settings
    $file   = "../sql/content/setup.sql";
    $mysql  = "/usr/local/mysql-8.0.19-macos10.15-x86_64/bin/mysql";
    $output = null;
    $resReset = null;

    // Extract hostname and databasename from dsn
    $app->db->connect();
    $dsnDetail = [];
    preg_match("/mysql:host=(.+);dbname=([^;.]+)/", "mysql:host=localhost;dbname=oophp;", $dsnDetail);
    $host = $dsnDetail[1];
    $database = $dsnDetail[2];
    $login = "user";
    $password = "pass";

    if (getPost("reset")) {
        $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
        $output = [];
        $status = null;
        $res = exec($command, $output, $status);
        $output = "<p>The command was: <code>$command</code>.<br>The command exit status was $status."
            . "<br>The output from the command was:</p><pre>"
            . print_r($output, 1);
        $resReset = "Du har nu återställt databasen!";

        return $app->response->redirect("content");
    }
});

/**
 * ADMIN PAGE GET
 */
$app->router->get("content/admin", function () use ($app) {
    $title = "My Content Database";

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("content/admin", [
        "res" => $res,
        "doDelete" => $doDelete ?? null,
        "doEdit" => $doEdit ?? null,
        "contentId" => $contentId ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * ADMIN PAGE POST
 */
$app->router->post("content/admin", function () use ($app) {
    $app->db->connect();
    $contentId = getPost("contentId");

    if (getPost("doEdit")) {
        return $app->response->redirect("content/content-edit?route=content-edit&id=$contentId");
    }

    if (getPost("doDelete")) {
        return $app->response->redirect("content/delete?route=delete&id=$contentId");
    }
});

/**
 * ADMIN EDIT
 */
$app->router->get("content/content-edit", function () use ($app) {
    $title = "Edit content";
    $app->db->connect();

    $contentId = getPost("contentId") ?: getGet("id");

    $sql = "SELECT * FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);

    $app->page->add("content/content-edit", [
        "contentId" => $contentId,
        "doSave" => $doSave ?? null,
        "doReset" => $doReset ?? null,
        "doDelete" => $doDelete ?? null,
        "content" => $content,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("content/content-edit", function () use ($app) {
    $app->db->connect();
    $contentId = getPost("contentId") ?: getGet("id");
    $contentTitle = getPost("contentTitle");
    $contentPath  = getPost("contentPath");
    $contentSlug = getPost("contentSlug");
    $contentData = getPost("contentData");
    $contentType  = getPost("contentType");
    $contentFilter = getPost("contentFilter");
    $contentPublish  = getPost("contentPublish");

    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if (hasKeyPost("doDelete")) {
        return $app->response->redirect("content/delete?route=delete&id=$contentId");
    }

    if (hasKeyPost("doSave")) {
        if (!$contentSlug) {
            $contentSlug = slugify($contentTitle);
        }

        //felhantering ifall det finns finns två likadana slugs
        if ($contentSlug) {
            $app->db->connect();
            $sql = "SELECT * FROM content;";
            $res = $app->db->executeFetchAll($sql);
            $count = 0;
            foreach ($res as $row) :
                if ($contentId != $row->id) {
                    if ($contentSlug === $row->slug) {
                        $contentSlug = "Får-inte-finnas-två-likadana-slugs" . $count;
                        $count++;
                    }
                }
            endforeach;
        }

        //felhantering så path kan vara tom.
        if (!$contentPath) {
            $contentPath = null;
        }

        //formaterar texten efter textfilter
        if ($contentFilter) {
            $filter = new Saji\TextFilter\MyTextFilter();
            $filterArray = explode(",", $contentFilter);
            $html = $filter->parse($contentData, $filterArray);
            $contentData = $html;
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $app->db->execute($sql, [$contentTitle, $contentPath, $contentSlug, $contentData, $contentType, $contentFilter, $contentPublish, $contentId]);
        header("Location: ?route=content-edit&id=$contentId");
        exit;
    }

    $sql = "SELECT * FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);
    return $app->response->redirect("content/admin");
});

/**
 * ADMIN DELETE
 */
$app->router->get("content/delete", function () use ($app) {
    $title = "Delete content";
    $app->db->connect();

    $contentId = getPost("contentId") ?: getGet("id");

    $sql = "SELECT * FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);

    $app->page->add("content/delete", [
        "contentId" => $contentId,
        "doDelete" => $doDelete ?? null,
        "content" => $content,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("content/delete", function () use ($app) {
    $app->db->connect();
    $contentId = getPost("contentId") ?: getGet("id");

    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if (hasKeyPost("doDelete")) {
        $contentId = getPost("contentId");
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $app->db->execute($sql, [$contentId]);
        return $app->response->redirect("content/admin");
    }

    $sql = "SELECT id, title FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);
    return $app->response->redirect("content/admin");
});


/**
 * ADMIN CREATE
 */
$app->router->get("content/create", function () use ($app) {
    $title = "Create content";

    $app->page->add("content/create", [
        "doCreate" => $doCreate ?? null,
        "contentTitle" => $contentTitle ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("content/create", function () use ($app) {
    $app->db->connect();
    if (hasKeyPost("doCreate")) {
            $title = getPost("contentTitle");

            $sql = "INSERT INTO content (title) VALUES (?);";
            $app->db->execute($sql, [$title]);
            $id = $app->db->lastInsertId();
            return $app->response->redirect("content/content-edit?route=content-edit&id=$id");
    }

    $sql = "SELECT id, title FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);
    return $app->response->redirect("content/admin");
});
