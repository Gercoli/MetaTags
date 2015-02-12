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
     * The length where the $page_title will be truncated. 0 = never.
     * @var int
     */
    protected static $page_title_length = 0;

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

        self::$page_title = $page_title;

        return self::getInstance();
    }

    public static function description($page_description = null, $max_length = 115)
    {
        // TODO: Implement description() method.
    }

    public static function keywords()
    {
        // TODO: Implement keywords() method.
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
        return (strlen($string) > $maximum_length) ? preg_replace('/\s+?(\S+)?$/', '', $string) : $string;
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
}