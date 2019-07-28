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

    // Define form methods.
    const FORM_METHOD_GET = 'get';
    const FORM_METHOD_POST = 'post';

    // Define form enctypes.
    const FORM_TYPE_URLENCODED = 'application/x-www-form-urlencoded';
    const FORM_TYPE_FORM_DATA = 'multipart/form-data';
    const FORM_TYPE_TEXT = 'text/plain';

    // Define input types.
    const INPUT_BUTTON = 'button';
    const INPUT_CHECKBOX = 'checkbox';
    const INPUT_COLOR = 'color';
    const INPUT_DATE = 'date';
    const INPUT_EMAIL = 'email';
    const INPUT_FILE = 'file';
    const INPUT_HIDDEN = 'hidden';
    const INPUT_MONTH = 'month';
    const INPUT_NUMBER = 'number';
    const INPUT_PASSWORD = 'password';
    const INPUT_RADIO = 'radio';
    const INPUT_RANGE = 'range';
    const INPUT_RESET = 'reset';
    const INPUT_SEARCH = 'search';
    const INPUT_SUBMIT = 'submit';
    const INPUT_TEL = 'tel';
    const INPUT_TEXT = 'text';
    const INPUT_TIME = 'time';
    const INPUT_URL = 'url';
    const INPUT_WEEK = 'week';

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
    private static function _getConstants(): array
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
    private static function _addClasses(array $classes, string $template): string
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
    private static function _addId($id, string $template): string
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
    private static function _createBaseFromTemplate(
        string $template,
        string $content,
        array $classes = [],
        string $id = null
    ) {
        $template = self::_addClasses($classes, $template);
        $template = self::_addId($id, $template);

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
    public static function concatenateElements(string ...$elements): string
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
    public static function createLink(
        string $title,
        string $href,
        string $target = self::TARGET_BLANK,
        array $classes = [],
        string $id = null
    ): string {
        // Validation.

        $validTargets = array_filter(
            self::_getConstants(), function ($key) {
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

        $template = self::_createBaseFromTemplate(
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
    public static function createArticle(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<article{classes_area}{id_area}>
        {content}
    </article>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
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
    public static function createBold(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<b{classes_area}{id_area}>{content}</b>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createBlockquote(
        string $content,
        string $cite,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<blockquote cite=\"{cite}\"{classes_area}{id_area}>" .
            "{content}</blockquote>\n\t";

        $template = self::_createBaseFromTemplate(
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
    public static function createBreak(): string
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
    public static function createCode(
        string $code,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<code{classes_area}{id_area}>{content}</code>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createDiv(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<div{classes_area}{id_area}>
        {content}
    </div>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
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
    public static function createEm(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<em{classes_area}{id_area}>{content}</em>\n\t";

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create form tag.
     *
     * @param string      $content Form content.
     * @param string      $action  Form action.
     * @param string|null $method  Form HTTP method.
     * @param string|null $enctype Form type
     * @param string      $target  Form target.
     * @param string|null $name    Form name.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     *
     * @throws \ReflectionException
     * @throws InvalidDocumentException
     */
    public static function createForm(
        string $content,
        string $action,
        string $method = self::FORM_METHOD_GET,
        string $enctype = self::FORM_TYPE_TEXT,
        string $target = self::TARGET_SELF,
        string $name = null,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<form{action_area}{method_area}{type_area}{name_area}{target_area}{classes_area}{id_area}>
        {content}
    </form>\n\t
EOF;
        // Validation.

        $validTargets = array_filter(
            self::_getConstants(), function ($key) {
                return strpos($key, 'TARGET_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        $validFormTypes = array_filter(
            self::_getConstants(), function ($key) {
                return strpos($key, 'FORM_TYPE_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        $validFormMethods = array_filter(
            self::_getConstants(), function ($key) {
                return strpos($key, 'FORM_METHOD_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given target is valid.
        if (!in_array($target, array_values($validTargets))) {
            throw new InvalidDocumentException(
                'Target "' . $target . '" is invalid!', 5
            );
        }

        // Check if given enctype is valid.
        if (!in_array($enctype, array_values($validFormTypes))) {
            throw new InvalidDocumentException(
                'Enctype "' . $enctype . '" is invalid!', 8
            );
        }

        // Check if given method is valid.
        if (!in_array($method, array_values($validFormMethods))) {
            throw new InvalidDocumentException(
                'Form method "' . $method . '" is invalid!', 9
            );
        }

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        $nameArea = null;
        if (null !== $name) {
            $nameArea = " name=\"{$name}\"";
        }

        $return = str_replace('{action_area}', " action=\"{$action}\"", $return);
        $return = str_replace('{method_area}', " method=\"{$method}\"", $return);
        $return = str_replace('{type_area}', " enctype=\"{$enctype}\"", $return);
        $return = str_replace('{name_area}', $nameArea, $return);
        $return = str_replace('{target_area}', " target=\"{$target}\"", $return);

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
    public static function createFooter(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<footer{classes_area}{id_area}>
        {content}
    </footer>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
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
    public static function createHeading(
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

        $return = self::_createBaseFromTemplate(
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
    public static function createHeader(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<header{classes_area}{id_area}>
        {content}
    </header>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create hr element.
     *
     * @return string
     */
    public static function createLine(): string
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
    public static function createI(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<i{classes_area}{id_area}>{content}</i>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createImg(
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
     * Create input tag.
     *
     * @param string      $type        Input type.
     * @param string|null $name        Input name.
     * @param string|null $value       Input value
     * @param string|null $placeholder Input placeholder.
     * @param array       $classes     HTML Classes.
     * @param string|null $id          Element ID.
     *
     * @return string
     *
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public static function createInput(
        string $type = self::INPUT_TEXT,
        string $name = null,
        string $value = null,
        string $placeholder = null,
        array $classes = [],
        string $id = null
    ): string {

        // Validation.
        $validTypes = array_filter(
            self::_getConstants(), function ($key) {
                return strpos($key, 'INPUT_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given type is valid.
        if (!in_array($type, array_values($validTypes))) {
            throw new InvalidDocumentException(
                'Input type "' . $type . '" is invalid!', 10
            );
        }

        $template = "<input type=\"{content}\"{name_area}{value_area}" .
            "{placeholder_area}{classes_area}{id_area}>\n\t";

        $return = self::_createBaseFromTemplate(
            $template, $type, $classes, $id
        );

        $nameArea = null;
        $valueArea = null;
        $placeholderArea = null;

        if (null !== $name) {
            $nameArea = " name=\"{$name}\"";
        }
        if (null !== $value) {
            $valueArea = " value=\"{$value}\"";
        }
        if (null !== $placeholder) {
            $placeholderArea = " placeholder=\"{$placeholder}\"";
        }

        $return = str_replace('{name_area}', $nameArea, $return);
        $return = str_replace('{value_area}', $valueArea, $return);
        $return = str_replace(
            '{placeholder_area}', $placeholderArea, $return
        );

        return $return;
    }

    /**
     * Create label tag.
     *
     * @param string      $content I content.
     * @param string      $for     Related element ID.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public static function createLabel(
        string $content,
        string $for,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<label for=\"{for}\"{classes_area}{id_area}>".
            "{content}</label>\n\t";

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        $return = str_replace('{for}', $for, $return);

        return $return;
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
    public static function createList(
        array $items,
        string $type = self::LIST_ORDERED,
        array $classes = [],
        string $id = null
    ): string {
        // Validation.

        $validTypes = array_filter(
            self::_getConstants(), function ($key) {
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

        $return = self::_createBaseFromTemplate(
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
    public static function createNav(
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

        $return = self::_createBaseFromTemplate(
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
    public static function createParagraph(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<p{classes_area}{id_area}>{content}</p>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createPre(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<pre{classes_area}{id_area}>
{content}
    </pre>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
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
    public static function createProgress(
        int $value,
        int $max = 100,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<progress value=\"{value}\" max=\"{max}\"" .
            "{classes_area}{id_area}></progress>\n\t";

        $template = self::_createBaseFromTemplate(
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
    public static function createSection(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<section{classes_area}{id_area}>
{content}
    </section>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create select tag.
     *
     * @param array       $data    Options data.
     * @param string|null $name    Select name.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public static function createSelect(
        array $data,
        string $name = null,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<select{name_area}{classes_area}{id_area}>
{content}
    </select>\n\t
EOF;

        $content = '';
        foreach ($data as $k => $v) {
            $content .= "<option value=\"{$k}\">{$v}</option>\n\t\t";
        }

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        $nameArea = null;
        if (null !== $name) {
            $nameArea = " name=\"{$name}\"";
        }

        $return = str_replace('{name_area}', $nameArea, $return);

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
    public static function createSpan(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<span{classes_area}{id_area}>{content}</span>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createStrong(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<strong{classes_area}{id_area}>{content}</strong>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createSub(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<sub{classes_area}{id_area}>{content}</sub>\n\t";

        $return = self::_createBaseFromTemplate(
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
    public static function createSup(
        string $content,
        array $classes = [],
        string $id = null
    ): string {
        $template = "<sup{classes_area}{id_area}>{content}</sup>\n\t";

        $return = self::_createBaseFromTemplate(
            $template, $content, $classes, $id
        );

        return $return;
    }

    /**
     * Create table tag.
     *
     * @param array       $data    Table data.
     * @param array       $classes HTML Classes.
     * @param string|null $id      Element ID.
     *
     * @return string
     */
    public static function createTable(
        array $data,
        array $classes = [],
        string $id = null
    ): string {
        $template = <<<EOF
<table{classes_area}{id_area}>
    <thead>
        {thead}
    </thead>
    <tbody>
        {tbody}
    </tbody>
</table>\n\t
EOF;

        $return = self::_createBaseFromTemplate(
            $template, '', $classes, $id
        );

        // Generate thead content;

        $theadArray = $data[0];
        unset($data[0]);

        $theadTr = null;
        if ([] !== $theadArray) {
            $theadTr = "<tr>\n\t\t\t<th>";
            $theadTr .= implode($theadArray, "</th>\n\t\t\t<th>");
            $theadTr .= "</th>\n\t\t</tr>";
        }

        // Generate tbody content;

        $tbody = '';
        foreach ($data as $td) {
            $tbodyTr = "<tr>\n\t\t\t<td>";
            $tbodyTr .= implode($td, "</td>\n\t\t\t<td>");
            $tbodyTr .= "</td>\n\t\t</tr>\n\t\t";

            $tbody .= $tbodyTr;
        }

        $return = str_replace('{thead}', $theadTr, $return);
        $return = str_replace('{tbody}', $tbody, $return);

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
