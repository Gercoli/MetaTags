<?php
use GErcoli\MetaTags\MetaTags as MetaTags;

class HTMLTagTest extends PHPUnit_Framework_TestCase {
    public function testCreateInstance()
    {
        $a = MetaTags::getInstance();
        $b = MetaTags::getInstance();

        $this->assertInstanceOf('GErcoli\MetaTags\MetaTags',$a,"First instance is NOT an instance of 'MetaTags'.");
        $this->assertInstanceOf('GErcoli\MetaTags\MetaTags',$b,"Second instance is NOT an instance of 'MetaTags'.");
        $this->assertTrue($a === $b, "getInstance() returned two different instances.");
    }

    public function testTitleMethod()
    {
        $a = MetaTags::title("testing");        // Testing static access to the class.
        $b = MetaTags::title();                 // Testing return type is a string.
        $c = MetaTags::title("again")->title(); // Testing chaining instanced method from static method.

        $this->assertInstanceOf('GErcoli\MetaTags\MetaTags',$a,"Setter didn't return an instance of MetaTags.");
        $this->assertTrue(is_string($b) && $b === "testing", "Static getter didn't return the correct string.");
        $this->assertTrue(is_string($c) && $c === "again", "Instanced getter didn't return the correct string.");

        // Test title truncation:
        // Truncation should happen at the closest WORD not LETTER.
        $string = "This is a test string that will be truncated.";
        $d = MetaTags::title($string, 25)->title();
        $this->assertTrue($d == "This is a test string", "Truncated title string failed." );

        $title_tag = MetaTags::renderTitle(true);
        $this->assertInstanceOf('GErcoli\HTMLTags\HTMLTag',$title_tag);

        $this->assertContains("<title>",$title_tag->__toString());
        $this->assertContains($d,$title_tag->__toString());
        $this->assertContains("</title>",$title_tag->__toString());

    }

    public function testDescriptionMethod()
    {
        $original_text = "this is the website description";
        $a = MetaTags::description($original_text,15);
        $b = $a->description();

        $this->assertTrue($b == "this is the");

        $c = MetaTags::description($original_text,0)->description();
        $this->assertTrue($c == $original_text);

    }

    public function testKeywordsMethod()
    {
        $kw_array   = array("keyword1","keyword2","keyword3");
        $kw_string  = "keyword1, keyword2, keyword3";

        $a = MetaTags::keywords($kw_array)->keywords();
        $b = MetaTags::keywords($kw_string)->keywords();

        $this->assertTrue($a == $kw_string);
        $this->assertTrue($b == $kw_string);
        $c = MetaTags::keywords($kw_array,20)->keywords();
        $this->assertTrue($c == "keyword1, keyword2");
    }

    public function testAuthorMethod()
    {
        $author = "Garry Ercoli";
        $a = MetaTags::author($author)->author();
        $this->assertTrue($author == $a, "Author tag did not get set properly.");
    }

    public function testCharsetMethod()
    {
        $charset = "UTF-8";
        $b = MetaTags::charset();
        $a = MetaTags::charset($charset)->charset();
        $this->assertTrue($charset == $a);
        $this->assertTrue($b === null);
    }

    public function testCustomTagMethod()
    {
        $tag = new \GErcoli\HTMLTags\HTMLTag("style",true);
        $tag->appendContent(".body {\n\tbackground: black;\n}");
        MetaTags::customTag($tag);

    }
}