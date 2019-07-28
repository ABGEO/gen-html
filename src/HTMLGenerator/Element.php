<?php
/**
 * Class Element | src/HTMLGenerator/Element.php
 *
 * PHP version 7
 *
 * @category Library
 * @package  ABGEO\HTMLGenerator
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  MIT https://github.com/ABGEO07/gen-html/blob/master/LICENSE
 * @version  GIT: $Id$.
 * @link     https://github.com/ABGEO07/gen-html
 */

namespace ABGEO\HTMLGenerator;

use ABGEO\HTMLGenerator\Exception\InvalidDocumentException;
use ReflectionClass;

/**
 * Class Element
 *
 * @category Library
 * @package  ABGEO\HTMLGenerator
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  MIT https://github.com/ABGEO07/gen-html/blob/master/LICENSE
 * @link     https://github.com/ABGEO07/gen-html
 */
class Element
{
    // Define link target constants.
    const TARGET_BLANK  = '_blank';
    const TARGET_PARENT = '_parent';
    const TARGET_SELF   = '_self';
    const TARGET_TOP    = '_top';

    // Define list types.
    const LIST_ORDERED = 'ol';
    const LIST_UNORDERED = 'ul';

    /**
     * HTML Content.
     *
     * @var string
     */
    private $_html;

    /**
     * Get all constants defined in Document class
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    private function _getConstants(): array
    {
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();

        return $constants;
    }

    /**
     * Add classes to HTML Element.
     *
     * @param array  $classes  HTML Classes.
     * @param string $template Element template.
     *
     * @return string
     */
    private function _addClasses(array $classes, string $template): string
    {
        $replace = null;

        if ([] !== $classes) {
            $classes = implode(array_unique($classes), ' ');
            $replace = " class=\"$classes\"";
        }

        $template = str_replace('{classes_area}', $replace, $template);

        return $template;
    }

    /**
     * Add ID to HTML Element.
     *
     * @param string|null $id       HTML Id.
     * @param string      $template Element template.
     *
     * @return string
     */
    private function _addId($id, string $template): string
    {
        $replace = null;

        if (null !== $id) {
            $replace = " id=\"$id\"";
        }

        $template = str_replace('{id_area}', $replace, $template);

        return $template;
    }

    /**
     * Create base element from template.
     *
     * @param string      $template Element template.
     * @param string      $content  Article content.
     * @param array       $classes  HTML Classes.
     * @param string|null $id       Element ID.
     *
     * @return string
     */
    private function _createBaseFromTemplate(
        string $template,
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = $this->_addClasses($classes, $template);
        $template = $this->_addId($id, $template);

        $template = str_replace('{content}', $content, $template);

        return $template;
    }

    /**
     * Add element to HTML content.
     *
     * @param string $html Element.
     *
     * @return Element
     */
    public function add2Content(string $html): self
    {
        $this->_html .= $html;

        return $this;
    }

    /**
     * Get HTML Content.
     *
     * @return string
     */
    public function getHtml(): string
    {
        return $this->_html;
    }

    /**
     * Concatenate given elements.
     *
     * @param string ...$elements HTML Elements.
     *
     * @return string
     */
    public function concatenateElements(string ...$elements): string
    {
        return implode($elements);
    }

    /**
     * Create link (a tag).
     *
     * @param string      $title   Link Title.
     * @param string      $href    Link Url.
     * @param string      $target  Link Target.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     *
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public function createLink(
        string $title,
        string $href,
        string $target = self::TARGET_BLANK,
        array $classes = [],
        string $id = null
    ): string {
        // Validation.

        $validTargets = array_filter(
            $this->_getConstants(), function ($key) {
                return strpos($key, 'TARGET_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given target is valid.
        if (!in_array($target, array_values($validTargets))) {
            throw new InvalidDocumentException(
                'Target "' . $target . '" is invalid!', 5
            );
        }

        $template = "<a href=\"{href}\"{classes_area}{id_area} " .
            "target=\"{target}\">{content}</a>\n\t";

        $template = $this->_createBaseFromTemplate(
            $template, $title, $classes, $id
        );

        $template = str_replace('{href}', $href, $template);
        $template = str_replace('{target}', $target, $template);

        return $template;
    }

    /**
     * Create article tag.
     *
     * @param string      $content Article content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createArticle(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<article{classes_area}{id_area}>
        {content}
    </article>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create b tag.
     *
     * @param string      $content Tag content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createBold(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<b{classes_area}{id_area}>{content}</b>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create blockquote tag.
     *
     * @param string      $content Tag content.
     * @param string      $cite    Specifies the source of the quotation.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createBlockquote(
        string $content,
        string $cite,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<blockquote cite=\"{cite}\"{classes_area}{id_area}>" .
            "{content}</blockquote>\n\t";

        $template = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        $template = str_replace('{cite}', $cite, $template);

        return $template;
    }

    /**
     * Create br element.
     *
     * @return string
     */
    public function createBreak(): string
    {
        return "<br>\n\t";
    }

    /**
     * Create code tag.
     *
     * @param string      $code    Code content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createCode(
        string $code,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<code{classes_area}{id_area}>{content}</code>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $code, $classes, $id
        );

        return $return;
    }

    /**
     * Create div tag.
     *
     * @param string      $content Div content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createDiv(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<div{classes_area}{id_area}>
        {content}
    </div>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create em tag.
     *
     * @param string      $content Em content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createEm(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<em{classes_area}{id_area}>{content}</em>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create footer tag.
     *
     * @param string      $content Footer content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createFooter(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<footer{classes_area}{id_area}>
        {content}
    </footer>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create heading (h1-h6 tag).
     *
     * @param string      $content Heading content.
     * @param int         $size    Heading size (1-6).
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     *
     * @throws InvalidDocumentException
     */
    public function createHeading(
        string $content,
        int $size = 1,
        array $classes = [],
        string $id = null
    ): string {
        // Validation.

        if (1 > $size || 6 < $size) {
            throw new InvalidDocumentException(
                'Header size must be from 1 to 6!', 6
            );
        }

        $template = "<h{$size}{classes_area}{id_area}>{content}</h{$size}>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create header tag.
     *
     * @param string      $content header content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createHeader(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<header{classes_area}{id_area}>
        {content}
    </header>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create hr element.
     *
     * @return string
     */
    public function createLine(): string
    {
        return "<hr>\n\t";
    }

    /**
     * Create i tag.
     *
     * @param string      $content I content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createI(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<i{classes_area}{id_area}>{content}</i>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create img tag.
     *
     * @param string      $src     Image Source.
     * @param string|null $alt     Image Alt Text.
     * @param int         $height  Image Height.
     * @param int         $width   Image with.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createImg(
        string $src,
        string $alt = null,
        int $height = -1,
        int $width = -1,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<img src=\"{src}\"{alt_area}{height_area}" .
            "{width_area}{classes_area}{id_area}>\n\t";

        $altArea = null;
        $heightArea = null;
        $widthArea = null;
        $classesArea = null;
        $idArea = null;

        if (null != $alt) {
            $altArea = " alt=\"$alt\"";
        }
        if (-1 != $height) {
            $heightArea = " height=\"$height\"";
        }
        if (-1 != $width) {
            $widthArea = " width=\"$width\"";
        }
        if ([] != $classes) {
            $classes = implode(array_unique($classes), ' ');
            $classesArea = " class=\"$classes\"";
        }
        if (null != $id) {
            $idArea = " id=\"$id\"";
        }

        $template = str_replace('{src}', $src, $template);
        $template = str_replace('{alt_area}', $altArea, $template);
        $template = str_replace('{height_area}', $heightArea, $template);
        $template = str_replace('{width_area}', $widthArea, $template);
        $template = str_replace('{classes_area}', $classesArea, $template);
        $template = str_replace('{id_area}', $idArea, $template);

        return $template;
    }

    /**
     * Create ol or ul elements.
     *
     * @param array       $items   List items.
     * @param string      $type    List type (ol or ul).
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     *
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public function createList(
        array $items,
        string $type = self::LIST_ORDERED,
        array $classes = [],
        string $id = null
    ): string {
        // Validation.

        $validTypes = array_filter(
            $this->_getConstants(), function ($key) {
                return strpos($key, 'LIST_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given target is valid.
        if (!in_array($type, array_values($validTypes))) {
            throw new InvalidDocumentException(
                'Invalid list type "' . $type . '"!', 7
            );
        }

        $content = '';
        foreach ($items as $item) {
            $content .= "<li>{$item}</li>\n\t";
        }

        $template = <<<EOF
<{$type}{classes_area}{id_area}>
        {content}
    </$type>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create nav tag.
     *
     * @param array       $items     Array of a tags.
     * @param string|null $separator Nav separator
     * @param array       $classes   HTML Classes.
     * @param string|null $id        Element ID.
     *
     * @return string
     */
    public function createNav(
        array $items,
        string $separator = null,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<nav{classes_area}{id_area}>
        {content}
    </nav>\n\t
EOF;

        $content = implode($items, "{$separator}\n\t");

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create p tag.
     *
     * @param string      $content I content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createParagraph(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<p{classes_area}{id_area}>{content}</p>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create pre tag.
     *
     * @param string      $content Pre content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createPre(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<pre{classes_area}{id_area}>
{content}
    </pre>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create progress tag.
     *
     * @param int         $value   Current value.
     * @param int         $max     Max value.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createProgress(
        int $value,
        int $max = 100,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<progress value=\"{value}\" max=\"{max}\"" .
            "{classes_area}{id_area}></progress>\n\t";

        $template = $this->_createBaseFromTemplate(
            $template, '', $classes, $id
        );

        $template = str_replace('{value}', $value, $template);
        $template = str_replace('{max}', $max, $template);

        return $template;
    }

    /**
     * Create section tag.
     *
     * @param string      $content Section content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createSection(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<section{classes_area}{id_area}>
{content}
    </section>\n\t
EOF;

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create span tag.
     *
     * @param string      $content Span content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createSpan(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<span{classes_area}{id_area}>{content}</span>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create strong tag.
     *
     * @param string      $content Strong content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createStrong(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<strong{classes_area}{id_area}>{content}</strong>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create sub tag.
     *
     * @param string      $content Sub content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createSub(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<sub{classes_area}{id_area}>{content}</sub>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create sup tag.
     *
     * @param string      $content Sup content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public function createSup(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<sup{classes_area}{id_area}>{content}</sup>\n\t";

        $return = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Clear HTML Content.
     *
     * @return Element
     */
    public function clear(): self
    {
        $this->_html = null;

        return $this;
    }

    /**
     * Convert class to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->_html;
    }
}
