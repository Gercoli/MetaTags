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
     * @var string[]|null[]
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
     * Sets the <title> value to this value, the max_length will truncate
     * the string at the previous word, using a length of 0 will disable truncation,
     * and setting the title to null will disable the tag from being output.
     * @param   string  $page_title
     * @param   int     $max_length
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setTitle($page_title, $max_length = 55)
    {
        if(!is_string($page_title) && $page_title !== null)
        {
            throw new MetaTagException('$page_title should be a string.');
        }

        self::$tags[self::setLastTag('title')->getLastTag()]
            = self::truncateAtWord($page_title,$max_length);

        return self::getInstance();
    }

    /**
     * Return the title that has been set for the page.
     * @return  null|string
     */
    public static function getTitle()
    {
        self::setLastTag('title');
        return self::$tags[self::getLastTag()];
    }

    /**
     * Sets the meta description value to this value, the max_length will truncate
     * the string at the previous word, using a length of 0 will disable truncation,
     * and setting the description to null will disable the tag from being output.
     * @param   string  $page_description
     * @param   int     $max_length
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setDescription($page_description, $max_length = 155)
    {
        if(!is_string($page_description) & $page_description !== null)
        {
            throw new MetaTagException('$page_description should be a string.');
        }

        self::$tags[self::setLastTag('description')->getLastTag()]
            = self::truncateAtWord(self::removeMultipleSpaces($page_description),$max_length);

        return self::getInstance();
    }

    /**
     * Returns the meta description value
     * @return  null|string
     */
    public static function getDescription()
    {
        self::setLastTag('description');
        return self::$tags[self::getLastTag()];
    }

    /**
     * Sets the meta keywords value
     * @param   string|null $page_keywords
     * @param   int         $max_length
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setKeywords($page_keywords, $max_length = 150)
    {
        if(!is_string($page_keywords) & $page_keywords !== null)
        {
            throw new MetaTagException('$page_keywords should be a string.');
        }

        self::$tags[self::setLastTag('keywords')->getLastTag()]
            = self::truncateAtWord(self::removeMultipleSpaces($page_keywords),$max_length);

        return self::getInstance();
    }

    /**
     * Gets the value of the keywords meta tag.
     * @return  null|string
     */
    public static function getKeywords()
    {
        self::setLastTag('keywords');
        return self::$tags[self::getLastTag()];
    }

    /**
     * Sets the meta author value
     * @param   string|null $page_author
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setAuthor($page_author)
    {
        if(!is_string($page_author) & $page_author !== null)
        {
            throw new MetaTagException('$page_author should be a string.');
        }

        self::$tags[self::setLastTag('author')->getLastTag()] = $page_author;
        return self::getInstance();

    }

    /**
     * Returns the meta author tag value.
     * @return null|string
     */
    public static function getAuthor()
    {
        self::setLastTag('author');
        return self::$tags[self::getLastTag()];
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

    /**
     * Sets the last tag variable, for internal use.
     * @param   string  $name
     * @return  MetaTags
     */
    protected static function setLastTag($name)
    {
        self::$last_tag = $name;
        return self::getInstance();
    }

    /**
     * Gets the last tag used, for internal use.
     * @return string
     */
    protected static function getLastTag()
    {
        return self::$last_tag;
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
     * @param   string|null $string
     * @param   int         $maximum_length
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
     * @param   string|null $string
     * @return  string|null
     */
    public static function removeMultipleSpaces($string)
    {
        return ($string !== null) ? preg_replace('/[ ]{2,}/', ' ', $string) : null;
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