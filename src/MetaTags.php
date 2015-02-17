<?php namespace GErcoli\MetaTags;

use GErcoli\HTMLTags\HTMLTag;
use GErcoli\MetaTags\MetaTagException;

class MetaTags implements MetaTagsInterface {

    /**
     * @var static|null
     */
    protected static $instance = null;

    /**
     * The last tag that was accessed/modified
     * @var string
     */
    protected static $last_tag;

    /**
     * A string to output before the tag, such as a tab.
     * @var string
     */
    protected static $render_prefix = "\t";

    /**
     * @var string[]
     */
    protected static $tags = [
        "charset"           => null,
        "title"             => null,
        "description"       => null,
        "keywords"          => null,
        "author"            => null,
        "IECompatibility"   => null,
        "refresh"           => null,
        "viewport"          => null,
        "phoneLinking"      => null,
        "appleTouch"        => [],
        "custom"            => []
    ];

    /**
     * Singleton constructor, only accessible internally by getInstance()
     * @see getInstance()
     */
    final private function __construct()
    {
        // No implementation.
    }

    /**
     * Singleton clone method, to stop the object from being cloned.
     */
    final private function __clone()
    {
        // No implementation.
    }

    /**
     * Returns the instance of this class, if one doesn't exist, it creates one first.
     * @return MetaTags|static
     */
    public static function getInstance()
    {
        if(!(static::$instance instanceof static))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Set the page title to the given string value.
     * @param   string  $page_title
     * @param   int     $max_length
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setTitle($page_title, $max_length = 55)
    {
        if(!is_string($page_title))
        {
            throw new MetaTagException('$page_title should be a string.');
        }

        self::$last_tag = 'title';
        self::$tags[self::$last_tag] = self::truncateAtWord($page_title,$max_length);
        return self::getInstance();
    }

    /**
     * Return the title that has been set for the page.
     * @return string
     */
    public static function getTitle()
    {
        self::$last_tag = 'title';
        return self::$tags[self::$last_tag];
    }

    public static function setDescription($page_description, $max_length = 155)
    {
        // TODO: Implement setDescription() method.
    }

    public static function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    public static function setKeywords($page_keywords, $max_length = 150)
    {
        // TODO: Implement setKeywords() method.
    }

    public static function getKeywords()
    {
        // TODO: Implement getKeywords() method.
    }

    public static function setAuthor($page_author)
    {
        // TODO: Implement setAuthor() method.
    }

    public static function getAuthor()
    {
        // TODO: Implement getAuthor() method.
    }

    public static function setCharset($charset = "UTF-8")
    {
        // TODO: Implement setCharset() method.
    }

    public static function getCharset()
    {
        // TODO: Implement getCharset() method.
    }

    public static function setRefresh($seconds, $url = null)
    {
        // TODO: Implement setRefresh() method.
    }

    public static function getRefresh()
    {
        // TODO: Implement getRefresh() method.
    }

    public static function setAppleTouchIcon($icon_url, $resolution = null, $precomposed = true)
    {
        // TODO: Implement setAppleTouchIcon() method.
    }

    public static function getAppleTouchIcons()
    {
        // TODO: Implement getAppleTouchIcons() method.
    }

    public static function setViewPort($extra_options = "")
    {
        // TODO: Implement setViewPort() method.
    }

    public static function getViewPort()
    {
        // TODO: Implement getViewPort() method.
    }

    public static function setPhoneLinking($enable = true)
    {
        // TODO: Implement setPhoneLinking() method.
    }

    public static function getPhoneLinking()
    {
        // TODO: Implement getPhoneLinking() method.
    }

    public static function setIECompatibility($engine = 'Edge,chrome=1')
    {
        // TODO: Implement setIECompatibility() method.
    }

    public static function getIECompatibility()
    {
        // TODO: Implement getIECompatibility() method.
    }

    public static function setCustomTag(HTMLTag $tag)
    {
        // TODO: Implement setCustomTag() method.
    }

    public static function getCustomTags()
    {
        // TODO: Implement getCustomTags() method.
    }

    public static function renderPrefix($prefix = null)
    {
        // TODO: Implement renderPrefix() method.
    }

    public static function renderLast()
    {
        // TODO: Implement renderLast() method.
    }

    public static function renderAll()
    {
        // TODO: Implement renderAll() method.
    }

    public static function renderTitle()
    {
        // TODO: Implement renderTitle() method.
    }

    public static function renderDescription()
    {
        // TODO: Implement renderDescription() method.
    }

    public static function renderKeywords()
    {
        // TODO: Implement renderKeywords() method.
    }

    public static function renderAuthor()
    {
        // TODO: Implement renderAuthor() method.
    }

    public static function renderCharset()
    {
        // TODO: Implement renderCharset() method.
    }

    public static function searchThenRender(array $search)
    {
        // TODO: Implement searchThenRender() method.
    }

    /**
     * Truncate a given string at the end of the word closest (but not past) to the max length
     * @param   string  $string
     * @param   int     $maximum_length
     * @return  string|null
     */
    public static function truncateAtWord($string, $maximum_length)
    {
        if($maximum_length < 1 || $string === null)
        {
            return $string;
        }

        $string = trim(substr($string, 0, $maximum_length + 1),",x \t\n\r\0\x0B");
        return (strlen($string) > $maximum_length) ? preg_replace('/([,.!;])?\s+?(\S+)?$/', '', $string) : $string;
    }

    /**
     * Removes multiple consecutive spaces and replaces it with a single space.
     * @param   string  $string
     * @return  string
     */
    public static function removeMultipleSpaces($string)
    {
        return preg_replace('/[ ]{2,}/', ' ', $string);
    }

    /**
     * Returns the first string in an array.
     * @param   array   $array
     * @return  string|null
     */
    public static function firstString(array $array)
    {
        $contents = array_filter($array,"is_string");
        if(isset($contents[0]))
        {
            return $contents[0];
        }
        return null;
    }
}