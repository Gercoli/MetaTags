<?php namespace GErcoli\MetaTags;

class MetaTags implements MetaTagsInterface {

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