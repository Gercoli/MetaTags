<?php
/**
 * Created by PhpStorm.
 * User: Garry
 * Date: 2/11/15
 * Time: 9:21 PM
 */

namespace GErcoli\MetaTags;


interface MetaTagsInterface {
    public static function getInstance();
    public static function title($page_title);
    public static function description();
    public static function keywords($keywords, $max_length = 150);
    public static function author();
    public static function charset($charset = "UTF-8");
    public static function refresh($seconds = 0);
    public static function appleTouchIcon($resolution, $icon_url, $precomposed = true); // http://stackoverflow.com/questions/5110776/apple-touch-icon-for-websites
    public static function viewport($extra_options = "");  // <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    public static function phoneLinking($enable = true);    // <meta name="format-detection" content="telephone=no" /> <meta name="x-rim-auto-match" http-equiv="x-rim-auto-match" forua="true" content="none"/>

    public static function renderLast();
    public static function renderAll();
    public static function renderTitle();
    public static function renderDescription();
    public static function renderKeywords();
    public static function renderAuthor();
    public static function renderCharset();
    public static function searchThenRender(array $search);
}