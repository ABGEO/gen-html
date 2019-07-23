<?php
/**
 * Class Document | src/HTMLGenerator/Document.php
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

/**
 * Class Document
 *
 * @category Library
 * @package  ABGEO\HTMLGenerator
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  MIT https://github.com/ABGEO07/gen-html/blob/master/LICENSE
 * @link     https://github.com/ABGEO07/gen-html
 */
class Document
{
    /**
     * HTML Document language.
     *
     * @var string
     */
    private $_language = 'en';

    /**
     * HTML Document charset.
     *
     * @var string
     */
    private $_charset = 'UTF-8';

    /**
     * HTML Document title.
     *
     * @var string
     */
    private $_title;

    /**
     * HTML Document description [optional].
     *
     * @var string
     */
    private $_description;

    /**
     * HTML Document keywords [optional].
     *
     * @var array
     */
    private $_keywords;

    /**
     * HTML Document body.
     *
     * @var string
     */
    private $_body;

    /**
     * Set HTML Document language.
     *
     * @param string $language HTML Document language.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setLanguage(string $language): self
    {
        $this->_language = $language;

        return $this;
    }

    /**
     * Set HTML Document charset.
     *
     * @param string $charset HTML Document charset.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setCharset(string $charset): self
    {
        $this->_charset = $charset;

        return $this;
    }

    /**
     * Set HTML Document title.
     *
     * @param string $title HTML Document title.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setTitle($title): self
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * Set HTML Document description.
     *
     * @param string $description HTML Document description.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setDescription($description): self
    {
        $this->_description = $description;

        return $this;
    }

    /**
     * Set HTML Document keywords.
     *
     * @param array $keywords HTML Document keywords.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setKeywords($keywords): self
    {
        $this->_keywords = $keywords;

        return $this;
    }

    /**
     * Set HTML Document body.
     *
     * @param string $body HTML Document body.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function setBody($body): self
    {
        $this->_body = $body;

        return $this;
    }

    /**
     * Get generated HTML Document.
     *
     * @return string
     *
     * @throws \ABGEO\HTMLGenerator\Exception\InvalidDocumentException
     */
    public function getDocument(): string
    {
        // Get document template.
        $document = file_get_contents(__DIR__ . '/../../templates/html5.html');

        if (null === $this->_title) {
            throw new InvalidDocumentException('Set document title!', 1);
        } elseif (null === $this->_body) {
            throw new InvalidDocumentException('Set document body!', 2);
        }

        // Replace data in template.
        $document = str_replace('{language}', $this->_language, $document);
        $document = str_replace('{charset}', $this->_charset, $document);
        $document = str_replace('{title}', $this->_title, $document);
        $document = str_replace('{description}', $this->_description, $document);
        $document = str_replace(
            '{keywords}',
            implode(array_unique($this->_keywords), ', '),
            $document
        );
        $document = str_replace('{body}', $this->_body, $document);

        return $document;
    }
}
