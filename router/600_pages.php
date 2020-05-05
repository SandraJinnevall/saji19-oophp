<?php

/**
 * GET PAGES
 */
$app->router->get("content/pages", function () use ($app) {
    $title = "Pages";

    $app->db->connect();
    $sql = <<<EOD
SELECT
*,
CASE
    WHEN (deleted <= NOW()) THEN "isDeleted"
    WHEN (published <= NOW()) THEN "isPublished"
    ELSE "notPublished"
END AS status
FROM content
WHERE type = ?
;
EOD;
    $res = $app->db->executeFetchAll($sql, ["page"]);

    $app->page->add("content/pages", [
        "res" => $res,
        "doEnterPage" => $doEnterPage ?? null,
        "contentPath" => $contentPath ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * POST PAGES
 */
$app->router->post("content/pages", function () use ($app) {
    $app->db->connect();
    $contentPath = getPost("contentPath");

    if (getPost("doEnterPage")) {
        return $app->response->redirect("content/page?route=page&path=$contentPath");
    }
});


$app->router->get("content/page", function () use ($app) {
    $title = "Page";
    $app->db->connect();

    $contentPath = getPost("contentPath") ?: getGet("path");

    $sql = "SELECT * FROM content WHERE path = ? AND (deleted IS NULL);";
    $content = $app->db->executeFetch($sql, [$contentPath]);

    if (!$content) {
        return $app->response->redirect("content/404");
    }

    //formaterar texten efter textfilter
    $filter = new Saji\TextFilter\MyTextFilter();
    $filterArray = explode(",", $content->filter);
    $html = $filter->parse($content->data, $filterArray);

    $app->page->add("content/page", [
        "contentPath" => $contentPath,
        "content" => $content,
        "html" => $html,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * GET 404
 */
$app->router->get("content/404", function () use ($app) {
    $title = "404";
    $app->page->add("content/404");

    return $app->page->render([
        "title" => $title,
    ]);
});
