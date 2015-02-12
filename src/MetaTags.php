<?php namespace GErcoli\MetaTags;

class MetaTags implements MetaTagsInterface {

    /**
     * @var static
     */
    protected static $instance = null;

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

    public static function title($page_title)
    {
        // TODO: Implement title() method.
    }

    public static function description()
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
    private function truncateAtWord($string, $maximum_length = 120)
    {
        $string = trim(substr($string, 0, $maximum_length + 1),", \t\n\r\0\x0B");
        return (strlen($string) > $maximum_length) ? preg_replace('/\s+?(\S+)?$/', '', $string) : $string;
    }

    /**
     * Removes multiple consecutive spaces and replaces it with a single space.
     * @param   string  $string
     * @return  string
     */
    private function removeMultipleSpaces($string)
    {
        return preg_replace('/[ ]{2,}/', ' ', $string);
    }
}