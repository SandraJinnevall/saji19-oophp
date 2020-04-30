<?php
/**
 * Test textfilter.
 */
$app->router->get("textfilter", function () use ($app) {
    $title = "Testar textfilter";

    $filter = new Saji\TextFilter\MyTextFilter();
    $text = "Testar bbcode: Idag är det [b]fredag[/b]!";
    $html = $filter->parse($text, "bbcode");

    $filter2 = new Saji\TextFilter\MyTextFilter();
    $text2 = "Testar link: http://dbwebb.se";
    $html2 = $filter2->parse($text2, "link");

    $filter3 = new Saji\TextFilter\MyTextFilter();
    $text3 = "Testar markdown: \n" .
        "### Header level 3 {#id3} \n" .
        "* Unordered list \n" .
        "* Unordered list again \n\n" .
        "Here will be a table.\n" .
        "
| Header 1 | Header 2     | Header 3 | Header 4      |
|----------|:-------------|:--------:|--------------:|
| Data 1   | Left aligned | Centered | Right aligned |
| Data     | Data         | Data     | Data          |
        \n" .

        "Here is a paragraph with some **bold** text and some *italic* text
        and a [link to dbwebb.se](http://dbwebb.se).";
    $html3 = $filter3->parse($text3, "markdown");


    $filter4 = new Saji\TextFilter\MyTextFilter();
    $text4 = "Testar nl2br: \n Hej\r\nmitt\n\rnamn\när\r\nSandra\r";
    $html4 = $filter4->parse($text4, "nl2br");

    $app->page->add("textfilter/index", [
        "html" => $html,
        "html2" => $html2,
        "html3" => $html3,
        "html4" => $html4,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});
