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
            "target=\"{target}\">{title}</a>\n\t";

        $template = str_replace('{href}', $href, $template);
        $template = str_replace('{target}', $target, $template);
        $template = str_replace('{title}', $title, $template);
        $template = $this->_addClasses($classes, $template);
        $template = $this->_addId($id, $template);

        $this->_html .= $template;

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
