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
     * Get HTML Content.
     *
     * @return string
     */
    public function getHtml(): string
    {
        return $this->_html;
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
     * @return \ABGEO\HTMLGenerator\Element
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public function createLink(
        string $title,
        string $href,
        string $target = self::TARGET_BLANK,
        array $classes = [],
        string $id = null
    ) {
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

        $this->_html .= $template;

        return $this;
    }

    /**
     * Create article tag.
     *
     * @param string      $content Article content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createArticle(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = <<<EOF
<article{classes_area}{id_area}>
        {content}
    </article>\n\t
EOF;

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create b tag.
     *
     * @param string      $content Tag content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createBold(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = "<b{classes_area}{id_area}>{content}</b>\n\t";

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create blockquote tag.
     *
     * @param string      $content Tag content.
     * @param string      $cite    Specifies the source of the quotation.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createBlockquote(
        string $content,
        string $cite,
        array $classes = [],
        string $id = null
    ) {
        $template = "<blockquote cite=\"{cite}\"{classes_area}{id_area}>" .
            "{content}</blockquote>\n\t";

        $template = $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        $template = str_replace('{cite}', $cite, $template);

        $this->_html .= $template;

        return $this;
    }

    /**
     * Create br element.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createBreak()
    {
        $this->_html .= "<br>\n\t";

        return $this;
    }

    /**
     * Create code tag.
     *
     * @param string      $code    Code content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createCode(
        string $code,
        array $classes = [],
        string $id = null
    ) {
        $template = "<code{classes_area}{id_area}>{content}</code>\n\t";

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $code, $classes, $id
        );

        return $this;
    }

    /**
     * Create div tag.
     *
     * @param string      $content Div content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createDiv(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = <<<EOF
<div{classes_area}{id_area}>
        {content}
    </div>\n\t
EOF;

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create em tag.
     *
     * @param string      $content Em content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createEm(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = "<em{classes_area}{id_area}>{content}</em>\n\t";

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create footer tag.
     *
     * @param string      $content Footer content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createFooter(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = <<<EOF
<footer{classes_area}{id_area}>
        {content}
    </footer>\n\t
EOF;

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create heading (h1-h6 tag).
     *
     * @param string      $content Heading content.
     * @param int         $size    Heading size (1-6).
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     *
     * @throws InvalidDocumentException
     */
    public function createHeading(
        string $content,
        int $size = 1,
        array $classes = [],
        string $id = null
    ) {
        // Validation.

        if (1 > $size || 6 < $size) {
            throw new InvalidDocumentException(
                'Header size must be from 1 to 6!', 6
            );
        }

        $template = "<h{$size}{classes_area}{id_area}>{content}</h{$size}>\n\t";

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create header tag.
     *
     * @param string      $content header content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createHeader(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = <<<EOF
<header{classes_area}{id_area}>
        {content}
    </header>\n\t
EOF;

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Create hr element.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createLine()
    {
        $this->_html .= "<hr>\n\t";

        return $this;
    }

    /**
     * Create i tag.
     *
     * @param string      $content I content.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createI(
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = "<i{classes_area}{id_area}>{content}</i>\n\t";

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
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
     * @return \ABGEO\HTMLGenerator\Element
     */
    public function createImg(
        string $src,
        string $alt = null,
        int $height = -1,
        int $width = -1,
        array $classes = [],
        string $id = null
    ) {
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

        $this->_html .= $template;

        return $this;
    }

    /**
     * Create ol or ul elements.
     *
     * @param array       $items   List items.
     * @param string      $type    List type (ol or ul).
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return \ABGEO\HTMLGenerator\Element
     *
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public function createList(
        array $items,
        string $type = self::LIST_ORDERED,
        array $classes = [],
        string $id = null
    ) {
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
    </$type>
EOF;

        $this->_html .= $this->_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $this;
    }

    /**
     * Clear HTML Content.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->_html = null;
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
