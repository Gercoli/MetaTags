<?php
/**
 * Created by PhpStorm.
 * User: Garry
 * Date: 2/11/15
 * Time: 9:21 PM
 */

namespace GErcoli\MetaTags;


use GErcoli\HTMLTags\HTMLTag;

interface MetaTagsInterface {
    public static function getInstance();

    public static function setEncodingXHTML($enable);
    public static function getEncodingXHTML();

    public static function setTitle($page_title, $max_length = 55);
    public static function getTitle();

    public static function setDescription($page_description, $max_length = 155);
    public static function getDescription();

    public static function setKeywords($page_keywords, $max_length = 150);
    public static function getKeywords();

    public static function setAuthor($page_author);
    public static function getAuthor();

    public static function setCharset($charset = "UTF-8");
    public static function getCharset();

    public static function setRefresh($seconds, $url = null);
    public static function getRefresh(); // ['sec']=$seconds,['url']=$url

    public static function setAppleTouchIcon($icon_url, $resolution = null, $precomposed = true);   // http://stackoverflow.com/questions/5110776/apple-touch-icon-for-websites
    public static function getAppleTouchIcons();

    public static function setViewPort(array $extra_options = []);    // <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    public static function getViewPort();

    public static function setPhoneLinking($enable = true); // <meta name="format-detection" content="telephone=no" /> <meta name="x-rim-auto-match" http-equiv="x-rim-auto-match" forua="true" content="none"/>
    public static function getPhoneLinking();

    public static function setIECompatibility($engine = 'Edge,chrome=1');   // http://stackoverflow.com/questions/6771258/whats-the-difference-if-meta-http-equiv-x-ua-compatible-content-ie-edge-e
    public static function getIECompatibility();

    public static function addCustomTag(HTMLTag $tag);
    public static function getCustomTags();

    public static function setRenderPrefix($prefix = null);
    public static function getRenderPrefix();

    public static function renderLast($return = false);
    public static function renderAll($return = false);
    public static function renderTitle($return = false);
    public static function renderDescription($return = false);
    public static function renderKeywords($return = false);
    public static function renderAuthor($return = false);
    public static function renderCharset($return = false);
    public static function renderRefresh($return = false);
    public static function renderAppleTouchIcon($return = false);
    public static function renderViewPort($return = false);
    public static function renderPhoneLinking($return = false);
    public static function renderIECompatibility($return = false);
    public static function renderCustom($return = false);
}