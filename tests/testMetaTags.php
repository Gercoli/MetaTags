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
    }
}