<?php namespace GErcoli\MetaTags;

class MetaTags implements MetaTagsInterface {

    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * The page <title>
     * @var string
     */
    protected static $page_title;

    /**
     * The page meta description.
     * @var string
     */
    protected static $page_description;

    /**
     * An array of page keywords.
     * @var string
     */
    protected static $page_keywords;

    /**
     * The last tag that was accessed/modified
     * @var string
     */
    protected static $last_tag;

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
     * Sets or gets the title of the page, set returns an instance of this class.
     * @param   string  $page_title The title of the page.
     * @param   int     $max_length Truncate input at this number of letters.
     * @return MetaTags|string
     */
    public static function title($page_title = null, $max_length = 55)
    {
        if($page_title === null)
        {
            return self::$page_title;
        }

        if(!is_int($max_length))
        {
            $max_length = strlen($page_title);
        }

        if(strlen($page_title) > $max_length && $max_length > 0)
        {
            $page_title = self::truncateAtWord($page_title,$max_length);
        }

        self::$last_tag = 'title';
        self::$page_title = $page_title;
        return self::getInstance();
    }

    /**
     * Set or gets the page description, set returns an instance of this class.
     * @param   string  $page_description
     * @param   int     $max_length
     * @return  MetaTags|string
     */
    public static function description($page_description = null, $max_length = 115)
    {
        if($page_description === null)
        {
            return self::$page_description;
        }

        if(!is_int($max_length))
        {
            $max_length = strlen($page_description);
        }

        if(strlen($page_description) > $max_length && $max_length > 0)
        {
            $page_description = self::truncateAtWord($page_description,$max_length);
        }

        self::$last_tag = 'description';
        self::$page_description = $page_description;
        return self::getInstance();
    }

    /**
     * Sets or gets the page keyword tags in the form of an array.
     * @param   string|string[]   $keywords
     * @param   int               $max_length
     * @return  MetaTags|string
     */
    public static function keywords($keywords = null, $max_length = 150)
    {
        if($keywords == null)
        {
            return self::$page_keywords;
        }

        if(is_array($keywords))
        {
            $keywords = implode(", ", array_map('trim', $keywords));
        }

        if(!is_string($keywords))
        {
            $keywords = "";
        }

        if(strlen($keywords) > $max_length && $max_length > 0)
        {
            var_dump($keywords);
            $keywords = self::truncateAtWord($keywords,$max_length);
            var_dump($keywords);
        }

        self::$last_tag = 'keywords';
        self::$page_keywords = $keywords;
        return self::getInstance();
    }

    public static function author()
    {
        // TODO: Implement author() method.
    }

    public static function charset($charset = "UTF-8")
    {
        // TODO: Implement charset() method.
    }

    public static function refresh($seconds = 0)
    {
        // TODO: Implement refresh() method.
    }

    public static function appleTouchIcon($resolution, $icon_url, $precomposed = true)
    {
        // TODO: Implement appleTouchIcon() method.
    }

    public static function viewport($extra_options = "")
    {
        // TODO: Implement viewport() method.
    }

    public static function phoneLinking($enable = true)
    {
        // TODO: Implement phoneLinking() method.
    }

    /**
     * Truncate a given string at the end of the word closest (but not past) to the max length
     * @param   string  $string
     * @param   int     $maximum_length
     * @return  string
     */
    public static function truncateAtWord($string, $maximum_length)
    {
        $string = trim(substr($string, 0, $maximum_length + 1),", \t\n\r\0\x0B");
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
}