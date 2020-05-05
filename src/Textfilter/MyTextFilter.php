<?php

namespace Saji\TextFilter;

use \Michelf\MarkdownExtra;

/**
* @SuppressWarnings(PHPMD.UnusedLocalVariable)
* @SuppressWarnings(PHPMD.StaticAccess)
*/

/**
 * Filter and format text content.
 */
class MyTextFilter
{
    // /**
    //  * @var array $filters Supported filters with method names of
    //  *                     their respective handler.
    //  */
    private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
    ];



    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($string, $filter)
    {
        if (!is_array($filter)) {
            $filter = strtolower($filter);
            $filter = preg_replace('/\s/', '', explode(',', $filter));
        }
        foreach ($filter as $key) {
            if (!isset($this->filters[$key])) {
                $string = "Filtret finns inte";
            }
            $string = call_user_func_array([$this, $this->filters[$key]], [$string]);
        }
        return $string;
    }

    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     * @SuppressWarnings(PHPMD.LongVariable)
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function markdown($text)
    {
        $parser = new MarkdownExtra;
        $parser->fn_id_prefix = "post22-";
        return $parser->transform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }
}
