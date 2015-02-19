<?php
use GErcoli\MetaTags\MetaTags as MetaTags;

class HTMLTagTest extends PHPUnit_Framework_TestCase {

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
}