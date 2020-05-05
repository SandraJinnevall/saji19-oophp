<?php
/**
 * GET BLOG
 */
$app->router->get("content/blog", function () use ($app) {
    $title = "Blog";

    $app->db->connect();
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    type=?
    AND (deleted IS NULL)
ORDER BY published DESC
;
EOD;
    $res = $app->db->executeFetchAll($sql, ["post"]);

    $app->page->add("content/blog", [
        "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * POST BLOG
 */
$app->router->post("content/blog", function () use ($app) {
    $app->db->connect();
    $contentSlug = getPost("contentSlug");

    if (getPost("doEnterPage")) {
        return $app->response->redirect("content/blogpost?route=blogpost&slug=$contentSlug");
    }
});


$app->router->get("content/blogpost", function () use ($app) {
    $title = "Page";
    $app->db->connect();

    $contentSlug = getPost("contentSlug") ?: getGet("slug");

    $sql = "SELECT * FROM content WHERE slug = ? AND type = ?;";
    $content = $app->db->executeFetch($sql, [$contentSlug, "post"]);

    //formaterar texten efter textfilter
    $filter = new Saji\TextFilter\MyTextFilter();
    $filterArray = explode(",", $content->filter);
    $html = $filter->parse($content->data, $filterArray);

    $app->page->add("content/blogpost", [
        "contentSlug" => $contentSlug,
        "content" => $content,
        "html" => $html,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});
