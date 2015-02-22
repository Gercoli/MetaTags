# MetaTags #
An extension for GErcoli/HTMLTags to make managing common meta tags easier.

## Installation ##

Include this into your composer.json file:
```javascript
{
    "require": {
        "gercoli/metatags": "dev-master"
    }
}
```

## Using the class ##
The MetaTags class uses fully qualified name spaces, so for easier use, add ```use GErcoli\MetaTags\MetaTags``` into your php file.
Secondly, the class has been designed to be used statically and the various setter methods can be chained together.

### Example of a simple tag ###
```PHP
    MetaTags::setTitle("This is the page title");

    echo MetaTags::getTitle();
    // output:
    // "This is the page title"

    MetaTags::renderTitle();
    // output:
    // <title>This is the page title</title>

    MetaTags::setCharset("UTF-8")
        ->setDescription("This is the page \"description\".")
        ->renderAll();
    // output:
    //  <meta charset="UTF-8">
    //  <title>This is the page title</title>
    //  <meta name="description" content="This is the page &quot;description&quot;.">
```

### Custom tags ###
It is inevitable that there will tags that you need to output/render that do not have easy-to-access class methods,
for this purpose I've added the addCustomTag(HTMLTag) method, where you can use the dependant
class [\GErcoli\HTMLTags\HTMLTag](https://github.com/Gercoli/HTMLTags) to create an HTMLTag and insert it manually.
```PHP
    // Create the custom tag via the HTMLTag class:
    $tag = (new HTMLTag("meta"))
        ->setAttribute("http-equiv","Content-Language")
        ->setAttribute("content","en");

    // Add the created tag to the MetaTags object,
    // and render only the very last tag that was added:
    MetaTags::addCustomTag($tag)->renderLast();

    // output:
    // <meta http-equiv="Content-Language" content="en">
```