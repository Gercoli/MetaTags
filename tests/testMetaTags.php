<?php
use GErcoli\MetaTags\MetaTags as MetaTags;
use GErcoli\MetaTags\MetaTagException as MetaTagException;

class HTMLTagTest extends PHPUnit_Framework_TestCase {

    public function testCommonTagExceptions()
    {
        // ====================================================================================
        // setTitle() : argument 1
        // ====================================================================================
        $exception_thrown = false;
        try
        {
            MetaTags::setTitle(10); // giving it an INT should throw an exception.
        }
        catch(MetaTagException $e)
        {
            $exception_thrown = true;
        }

        $this->assertTrue(
            $exception_thrown,
            "Exception was not thrown for setTitle()."
        );

        // ====================================================================================
        // setDescription() : argument 1
        // ====================================================================================
        $exception_thrown = false;
        try
        {
            MetaTags::setDescription(10); // giving it an INT should throw an exception.
        }
        catch(MetaTagException $e)
        {
            $exception_thrown = true;
        }

        $this->assertTrue(
            $exception_thrown,
            "Exception was not thrown for setDescription() when given an INT (SHOULD BE STRING)."
        );

        // ====================================================================================
        // setDescription() : argument 2
        // ====================================================================================
        $exception_thrown = false;
        try
        {
            MetaTags::setDescription('hello','hello'); // Giving it a string should throw an exception.
        }
        catch(MetaTagException $e)
        {
            $exception_thrown = true;
        }

        $this->assertTrue(
            $exception_thrown,
            "Exception was not thrown for setDescription() when given an string (SHOULD BE INT)."
        );

        // ====================================================================================
        // setKeywords() : argument 1
        // ====================================================================================
        $exception_thrown = false;
        try
        {
            MetaTags::setKeywords(10); // Giving it a string should throw an exception.
        }
        catch(MetaTagException $e)
        {
            $exception_thrown = true;
        }

        $this->assertTrue(
            $exception_thrown,
            "Exception was not thrown for setDescription() when given an string (SHOULD BE INT)."
        );

        // ====================================================================================
        // setKeywords() : argument 2
        // ====================================================================================
        $exception_thrown = false;
        try
        {
            MetaTags::setKeywords("This, is, a, keyword", "hi"); // Giving it a string should throw an exception.
        }
        catch(MetaTagException $e)
        {
            $exception_thrown = true;
        }

        $this->assertTrue(
            $exception_thrown,
            "Exception was not thrown for setDescription() when given an string (SHOULD BE INT)."
        );

    }

    public function testTitle()
    {
        $title_original = "This is the page title!";
        $title_received = null;

        // Set the title, and disable truncation.
        MetaTags::setTitle($title_original,0);

        // Get the title:
        $title_received = MetaTags::getTitle();

        // Make sure that the titles are the same:
        $this->assertEquals(
            $title_original,
            $title_received,
            "The titles were not the same!"
        );

        // Re-set the title, with truncation, and get the value:
        $title_received = MetaTags::setTitle($title_original, 10)->getTitle();

        // Make sure the truncated version is giving us the expected value.
        $this->assertEquals(
            MetaTags::truncateAtWord($title_original,10),
            $title_received,
            "Truncated title was not correct."
        );

        // Test the rendering method:
        $title_tag = MetaTags::renderTitle(true);

        // We should have been given a HTMLTag:
        $this->assertInstanceOf(
            'GErcoli\HTMLTags\HTMLTag',
            $title_tag,
            "We were NOT given an HTMLTag!"
        );

        // Test the __toString() method:
        $this->assertEquals(
            "<title>{$title_received}</title>",
            $title_tag->__toString(),
            "The __toString() method for the title was different than expected."
        );

        // UNSET THE TITLE:
        MetaTags::setTitle(null);

        // getTitle() should return null:
        $this->assertNull(
            MetaTags::getTitle(),
            "The title was not set to NULL!"
        );

        // The renderTitle() should also be null:
        $this->assertNull(
            MetaTags::renderTitle(true),
            "The renderTitle() DID NOT return null!"
        );
    }

    public function testDescription()
    {
        // Set up the original text with some quotes in it to test escaping.
        $description_original = "This is the original \"description\".";
        $description_received =
            MetaTags::setDescription($description_original,0)
                ->getDescription();

        // Make sure what we got back is what we put in. (not truncated)
        $this->assertEquals(
            $description_original,
            $description_received,"The original description was not a match"
        );

        // Do the same test, but with truncation turned on.
        $description_received =
            MetaTags::setDescription($description_original,10)
                ->getDescription();

        // Test to make sure truncation is working.
        $this->assertEquals(
            $description_received,
            MetaTags::truncateAtWord($description_original,10)
        );

        $tag_text = MetaTags::renderDescription(true)->__toString();
        $this->assertStringStartsWith("<meta ",$tag_text);
        $this->assertStringEndsWith(">",$tag_text);


    }
}