<?php
/**
 * Show all movies.
 */
$app->router->get("movie", function () use ($app) {
    $title = "Movie database | oophp";

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("movie/index", [
        "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search for movie title.
 */
$app->router->get("movie/search-title", function () use ($app) {
    $title = "Movie database | oophp";
    $res = getGet("res");
    $searchTitle = getGet("searchTitle");

    $app->db->connect();
    $sql = "SELECT * FROM movie WHERE title LIKE ?;";
    $res = $app->db->executeFetchAll($sql, [$searchTitle]);

    $app->page->add("movie/search-title", [
        "res" => $res,
        "searchTitle" => $searchTitle,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search for movie years.
 */
$app->router->get("movie/search-year", function () use ($app) {
    $title = "Movie database | oophp";

    $year1 = getGet("year1");
    $year2 = getGet("year2");
    $res = getGet("res");

    $app->db->connect();

    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year2]);
    }


    $app->page->add("movie/search-year", [
        "res" => $res,
        "year1" => $year1,
        "year2" => $year2,
        "doSearch" => $doSearch ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search for movie select.
 */
$app->router->get("movie/movie-select", function () use ($app) {
    $title = "Movie database | oophp";

    $succeed = $_SESSION["succeeds"] ?? null;
    $_SESSION["succeeds"] = null;

    $app->db->connect();

    $sql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($sql);

    $app->page->add("movie/movie-select", [
        "movies" => $movies,
        "doDelete" => $doDelete ?? null,
        "doAdd" => $doAdd ?? null,
        "doEdit" => $doEdit ?? null,
        "succeed" => $succeed,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("movie/movie-select", function () use ($app) {
   // $doDelete = $_POST["doDelete"] ?? null;
   // $doAdd = $_POST["doAdd"] ?? null;
   // $doEdit = $_POST["doEdit"] ?? null;

    $movieId = getPost("movieId");
    $app->db->connect();

    $succeed = null;

    if (getPost("doDelete")) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
        header("Location: ?route=movie-select");
        exit;
    } elseif (getPost("doAdd")) {
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
        $movieId = $app->db->lastInsertId();
        header("Location: ?route=movie-edit&movieId=$movieId");
        exit;
    } elseif (getPost("doEdit") && is_numeric($movieId)) {
        // header("Location: ?route=movie-edit&movieId=$movieId");
        return $app->response->redirect("movie/movie-edit?route=movie-edit&movieId=$movieId");
        // exit;
    }
    return $app->response->redirect("movie/movie-select");
});



/**
 * Search for movie edit.
 */
$app->router->get("movie/movie-edit", function () use ($app) {
    $title = "Movie database | oophp";
    $app->db->connect();

    $movieId    = getPost("movieId") ?: getGet("movieId");

    $sql = "SELECT * FROM movie WHERE id = ?;";
    $movie = $app->db->executeFetchAll($sql, [$movieId]);
    $movie = $movie[0];

    $app->page->add("movie/movie-edit", [
        "movie" => $movie,
        "movieId" => $movieId,
        "doSave" => $doSave ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("movie/movie-edit", function () use ($app) {
    $app->db->connect();

    $movieId    = getPost("movieId") ?: getGet("movieId");
    $movieTitle = getPost("movieTitle");
    $movieYear  = getPost("movieYear");
    $movieImage = getPost("movieImage");

    if (getPost("doSave")) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        header("Location: ?route=movie-edit&movieId=$movieId");
        exit;
    }

    $sql = "SELECT * FROM movie WHERE id = ?;";
    $movie = $app->db->executeFetchAll($sql, [$movieId]);
    $movie = $movie[0];
    return $app->response->redirect("movie/movie-edit");
});
