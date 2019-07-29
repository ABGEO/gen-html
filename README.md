# gen-html
PHP Library for generating HTML document

[![GitHub license](https://img.shields.io/github/license/ABGEO07/gen-html.svg)](https://github.com/ABGEO07/gen-html/blob/master/LICENSE)

[![GitHub release](https://img.shields.io/github/release/ABGEO07/gen-html.svg)](https://github.com/ABGEO07/gen-html/releases)

[![Packagist Version](https://img.shields.io/packagist/v/abgeo/gen-html.svg "Packagist Version")](https://packagist.org/packages/abgeo/gen-html "Packagist Version")

---

## Installation

You can install this library with [Composer](https://getcomposer.org/):

- `composer require abgeo/gen-html`
    
## Usage

Include composer autoloader in your main file (Ex.: index.php)

- `require_once __DIR__ . '/../vendor/autoload.php';`

### Classes

The library has two classes:

* `\ABGEO\HTMLGenerator\Document` - For generating Full HTML5 Document;
* `\ABGEO\HTMLGenerator\Element` - For generating HTML element;

#### Class `Document`

Import `ABGEO\HTMLGenerator\Document` class.

##### Public Methods

- `setLanguage()` - Set document content language (Document::LANG_* constants);
- `setCharset()` - Set charset for document (Document::CHARSET_* constants);
- `setTitle()` - Set Document title;
- `setDescription()` - Set Document description;
- `setKeywords()` - Set Document keywords;
- `addStyle()` - Add CSS file path;
- `setBody()` - Set Document body content;
- `addScript()` - Set JS file path;
- `getDocument()` - Get generated HTML code;

**Note: See usage in [example.php](examples/example.php)**

#### Class `Element`

Import `ABGEO\HTMLGenerator\Element` class.

##### Public Methods

- `add2Content()` - Add given string to HTML content;
- `getHtml()` - Get HTML Content;
- `concatenateElements()` - Concatenate given elements;
- `createLink()` - Generate a tag;
- `createArticle()` - Generate article tag;
- `createBlockquote()` - Generate blockquote tag;
- `createBreak()` - Generate br tag;
- `createCode()` - Generate code tag;
- `createDiv()` - Generate div tag;
- `createEm()` - Generate em tag;
- `createForm()` - Generate form tag;
- `createFooter()` - Generate footer tag;
- `createHeading()` - Generate h1-h6 tags;
- `createHeader()` - Generate header tag;
- `createLine()` - Generate hr tag;
- `createI()` - Generate i tag;
- `createImg()` - Generate img tag;
- `createInput()` - Generate input tag;
- `createLabel()` - Generate label tag;
- `createList()` - Generate ol or ul tags;
- `createNav()` - Generate nav tag;
- `createParagraph()` - Generate p tag;
- `createPre()` - Generate pre tag;
- `createProgress()` - Generate progress tag;
- `createSection()` - Generate section tag;
- `createSelect()` - Generate select tag;
- `createSpan()` - Generate span tag;
- `createStrong()` - Generate strong tag;
- `createSub()` - Generate sub tag;
- `createSup()` - Generate sup tag;
- `createTable()` - Generate table tag;
- `createTextarea()` - Generate textarea tag;
- `clear()` - Clear HTML content;

**Note: See usage in [example.php](examples/example.php)**

## Examples

See full example in [example.php](examples/example.php) and sample Bootstrap 4 page in 
[bootstrap.php](examples/bootstrap.php).

## Authors

* **Temuri Takalandze** - *Initial work* - [ABGEO](https://abgeo.dev)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details