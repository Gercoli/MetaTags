<?php
use GErcoli\MetaTags\MetaTags as MetaTags;

class HTMLTagTest extends PHPUnit_Framework_TestCase {
    public function testCreateInstance()
    {
        $a = MetaTags::getInstance();
        $b = MetaTags::getInstance();

        $this->assertInstanceOf('GErcoli\MetaTags\HTMLTagTest',$a,"First instance is NOT an instance of 'MetaTags'.");
        $this->assertInstanceOf('GErcoli\MetaTags\MetaTags',$b,"Second instance is NOT an instance of 'MetaTags'.");
        $this->assertTrue($a === $b, "getInstance() returned two different instance.");
    }
}