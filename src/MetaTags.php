<?php namespace GErcoli\MetaTags;

use GErcoli\HTMLTags\HTMLTag;

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
        "refresh"           => [],
        "viewport"          => [],
        "phoneLinking"      => null,
        "appleTouch"        => [],
        "custom"            => []
    ];

    /**
     * Are we outputing tags in XHTML?
     * @var bool
     */
    protected static $encode_XHTML = false;

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
     * Are we outputting tags in XHTML with self-closing tags?
     * @param   bool    $enable
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setEncodingXHTML($enable)
    {
        if(!is_bool($enable))
        {
            throw new MetaTagException('Acceptable type for $enable is bool.');
        }

        self::$encode_XHTML = $enable;
        return self::getInstance();
    }

    /**
     * The XHTML setting.
     * @return  bool
     */
    public static function getEncodingXHTML()
    {
        return self::$encode_XHTML;
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
            throw new MetaTagException('Acceptable types for $page_title are string and null.');
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
            throw new MetaTagException('Acceptable types for $page_description is string and null.');
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
            throw new MetaTagException('Acceptable types for $page_keywords is string and null.');
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
            throw new MetaTagException('Acceptable types for $page_author is string and null.');
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

    /**
     * Sets the meta charset value
     * @param   null|string $charset
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setCharset($charset = "UTF-8")
    {
        if(!is_string($charset) & $charset !== null)
        {
            throw new MetaTagException('Acceptable types for $charset is string and null.');
        }

        self::$tags[self::setLastTag('charset')->getLastTag()] = $charset;

        return self::getInstance();
    }

    /**
     * Get the value of the meta charset tag.
     * @return  null|string
     */
    public static function getCharset()
    {
        self::setLastTag('charset');
        return self::$tags[self::getLastTag()];
    }

    /**
     * Sets the meta refresh/redirect tag, $url is optional.
     * @param   null|int    $seconds
     * @param   null|string $url
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setRefresh($seconds, $url = null)
    {
        if(!is_int($seconds) & $seconds !== null)
        {
            throw new MetaTagException('Acceptable type for $seconds is int.');
        }

        $seconds = ($seconds === null) ? 0 : $seconds;

        self::$tags[self::setLastTag('refresh')->getLastTag()] = array('sec' => $seconds, 'url' => $url);

        return self::getInstance();
    }

    /**
     * Gets the refresh array which contains 'sec' and 'url' keys, if 'url' is null,
     * the tag will refresh the page, if the 'url' IS NOT null, it will redirect.
     * @return array
     */
    public static function getRefresh()
    {
        return self::$tags[self::setLastTag('refresh')->getLastTag()];
    }

    /**
     * Sets the apple-touch-icon values, precomposed images are deprecated but for backwards
     * compatibility, you are able to add them here.
     * @param   string      $icon_url
     * @param   null|string $resolution
     * @param   bool        $precomposed
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setAppleTouchIcon($icon_url, $resolution = null, $precomposed = false)
    {
        if(!is_string($icon_url))
        {
            throw new MetaTagException('Acceptable type for $icon_url is string.');
        }

        $key = ($precomposed === true) ? 'apple-touch-icon-precomposed' : 'apple-touch-icon';
        self::$tags['appleTouch'][$key][] = array('size' => $resolution, 'href'=>$icon_url);

        $tag_name = "appleTouch;{$key};" . (count(self::$tags['appleTouch'][$key]) - 1);
        self::setLastTag($tag_name);

        return self::getInstance();
    }

    /**
     * Gets the array of apple-touch icons.
     * @return  array()
     */
    public static function getAppleTouchIcons()
    {
        return self::$tags[self::setLastTag('appleTouch')->getLastTag()];
    }

    /**
     * Sets the viewport meta tag value for mobile devices.
     * @param   array   $extra_options  - These options will overwrite default values.
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setViewPort(array $extra_options = [])
    {
        if(!is_array($extra_options) & $extra_options !== null)
        {
            throw new MetaTagException('Acceptable type for $extra_options is array.');
        }

        $defaults = array(
            'width'         => 'device-width',
            'initial-scale' => '1',
            'minimum-scale' => '1',
            'user-scalable' => 'yes'
        );

        foreach($extra_options as $key => $value)
        {
            $key = trim(strtolower($key));
            if(strlen($key) < 1)
            {
                continue;
            }
            $defaults[$key] = trim(strtolower($value));
        }

        self::$tags[self::setLastTag('viewport')->getLastTag()] = $defaults;

        return self::getInstance();
    }

    /**
     * Returns the settings of the viewport meta tag
     * @return null|array
     */
    public static function getViewPort()
    {
        return self::$tags[self::setLastTag('viewport')->getLastTag()];
    }

    /**
     * Enables/Disables the tag that tells mobile devices if they should parse out
     * phone numbers into clickable links.
     * @param   null|bool   $enable
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setPhoneLinking($enable = true)
    {
        if(!is_bool($enable) && $enable !== null)
        {
            throw new MetaTagException(
                'Acceptable types for $enable are boolean and null, but got ' . gettype($enable)
            );
        }

        self::$tags[self::setLastTag('phoneLinking')->getLastTag()] = $enable;
        return self::getInstance();
    }

    /**
     * Will mobile devices be told to parse phone numbers as links?
     * @return  null|bool
     */
    public static function getPhoneLinking()
    {
        return self::$tags[self::setLastTag('phoneLinking')->getLastTag()];
    }


    /**
     * Sets the Internet Explorer compatibility string that will be used,
     * more info: http://stackoverflow.com/questions/6771258
     * @param   null|string $engine - The string that will be used, null disables the tag.
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setIECompatibility($engine = 'Edge,chrome=1')
    {
        if(!is_string($engine) && $engine !== null)
        {
            throw new MetaTagException(
                'Acceptable types for $engine are string and null, but got ' . gettype($engine)
            );
        }

        self::$tags[self::setLastTag('IECompatibility')->getLastTag()] = $engine;
        return self::getInstance();
    }

    /**
     * Returns the string that will be used in the Internet Explorer compatibility tag,
     * see: http://stackoverflow.com/questions/6771258
     * @return  null|string
     */
    public static function getIECompatibility()
    {
        return self::$tags[self::setLastTag('IECompatibility')->getLastTag()];
    }

    /**
     * Adds a custom HTMLTag to the list of tags that will be rendered.
     * @param   HTMLTag $tag
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function addCustomTag(HTMLTag $tag)
    {
        if(!($tag instanceof HTMLTag))
        {
            throw new MetaTagException('Acceptable type for $tag is HTMLTag, but got ' . gettype($tag));
        }

        self::$tags[self::setLastTag('custom')->getLastTag()][] = $tag;
        return self::getInstance();
    }

    /**
     * Gets an array of the custom tags that will be rendered,
     * an empty array means that none will be output.
     * @return  HTMLTag[]
     */
    public static function getCustomTags()
    {
        return self::$tags[self::setLastTag('custom')->getLastTag()];
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

    /**
     * Sets the string that will prefix any output tag, such as a tab
     * @param   string  $prefix - The string to prefix tags with, default is a tab.
     * @return  MetaTags
     * @throws  MetaTagException
     */
    public static function setRenderPrefix($prefix = "\t")
    {
        if(!is_string($prefix))
        {
            throw new MetaTagException('Acceptable type for $prefix is string, but got ' . gettype($prefix));
        }

        self::$render_prefix = $prefix;
        return self::getInstance();
    }

    /**
     * Returns the string that will prefix all tags that are output.
     * @return string
     */
    public static function getRenderPrefix()
    {
        return self::$render_prefix;
    }

    /**
     * Renders the last tag that was accessed or modified.
     * @param   bool $return
     * @return  MetaTags|HTMLTag|null
     * @throws  MetaTagException
     */
    public static function renderLast($return = false)
    {
        if( !is_string(self::getLastTag()) || !isset(self::$tags[self::getLastTag()]) )
        {
            throw new MetaTagException("Unable to find a valid last tag to render.");
        }

        switch(strtolower(self::getLastTag()))
        {
            case 'title':
                $tag = self::renderTitle(true);
                break;
            case 'description':
                $tag = self::renderDescription(true);
                break;
            case 'keywords':
                $tag = self::renderKeywords(true);
                break;
            case 'author':
                $tag = self::renderAuthor(true);
                break;
            case 'charset':
                $tag = self::renderCharset(true);
                break;
            case 'refresh':
                $tag = self::renderRefresh(true);
                break;
            case 'appletouch':
                $tag = self::renderAppleTouchIcon(true);
                break;
            case 'viewport':
                $tag = self::renderViewPort(true);
                break;
            case 'phonelinking':
                $tag = self::renderPhoneLinking(true);
                break;
            case 'iecompatibility':
                $tag = self::renderIECompatibility(true);
                break;
            case 'custom':
                $tag = end(self::$tags['custom']);
                break;
            default:
                $tag = null;
                throw new MetaTagException("Unknown last tag.");
                break;
        }

        if(!isset($tag))
        {
            throw new MetaTagException("Tag was not set.");
        }

        if($return)
        {
            if(!($tag instanceof HTMLTag))
            {
                return null;
            }
            return $tag;
        }

        echo $tag;
        return self::getInstance();
    }

    public static function renderAll($return = false)
    {
        // TODO: Implement renderAll() method.
    }

    /**
     * Render the title tag, if one is set.
     * @param   bool    $return - If true, the tag is returned INSTEAD of echo'd
     * @return  HTMLTag|MetaTags|null
     * @throws  \GErcoli\HTMLTags\HTMLTagException
     */
    public static function renderTitle($return = false)
    {
        $title = self::getTitle();
        $tag = null;
        if($title !== null && is_string($title))
        {
            $tag = (new HTMLTag("title", true, self::getEncodingXHTML()))
                ->appendContent($title);
        }


        if($return)
        {
            return $tag;
        }

        echo $tag;
        return self::getInstance();
    }

    /**
     * Render the meta description tag, if one is set.
     * @param   bool    $return - If true, the tag is returned INSTEAD of echo'd
     * @return  HTMLTag|MetaTags|null
     * @throws  \GErcoli\HTMLTags\HTMLTagException
     */
    public static function renderDescription($return = false)
    {
        $description = self::getDescription();
        $tag = null;
        if(is_string($description))
        {
           $tag = (new HTMLTag("meta", false, self::getEncodingXHTML()))
               ->setAttribute("name","description")
               ->setAttribute("content",$description);
        }

        if($return)
        {
            return $tag;
        }

        echo $tag;
        return self::getInstance();
    }

    public static function renderKeywords($return = false)
    {
        // TODO: Implement renderKeywords() method.
    }

    public static function renderAuthor($return = false)
    {
        // TODO: Implement renderAuthor() method.
    }

    public static function renderCharset($return = false)
    {
        // TODO: Implement renderCharset() method.
    }

    public static function renderRefresh($return = false)
    {

    }
    public static function renderAppleTouchIcon($return = false)
    {

    }
    public static function renderViewPort($return = false)
    {

    }
    public static function renderPhoneLinking($return = false)
    {

    }
    public static function renderIECompatibility($return = false)
    {

    }
    public static function renderCustom($return = false)
    {

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