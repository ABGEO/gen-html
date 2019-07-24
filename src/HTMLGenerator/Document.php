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
use ReflectionClass;

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
    // Define language constants (ISO 639-1 Language Codes).
    const LANG_ABKHAZIAN = 'ab';
    const LANG_AFAR = 'aa';
    const LANG_AFRIKAANS = 'af';
    const LANG_AKAN = 'ak';
    const LANG_ALBANIAN = 'sq';
    const LANG_AMHARIC = 'am';
    const LANG_ARABIC = 'ar';
    const LANG_ARAGONESE = 'an';
    const LANG_ARMENIAN = 'hy';
    const LANG_ASSAMESE = 'as';
    const LANG_AVARIC = 'av';
    const LANG_AVESTAN = 'ae';
    const LANG_AYMARA = 'ay';
    const LANG_AZERBAIJANI = 'az';
    const LANG_BAMBARA = 'bm';
    const LANG_BASHKIR = 'ba';
    const LANG_BASQUE = 'eu';
    const LANG_BELARUSIAN = 'be';
    const LANG_BENGALI = 'bn';
    const LANG_BIHARI = 'bh';
    const LANG_BISLAMA = 'bi';
    const LANG_BOSNIAN = 'bs';
    const LANG_BRETON = 'br';
    const LANG_BULGARIAN = 'bg';
    const LANG_BURMESE = 'my';
    const LANG_CATALAN = 'ca';
    const LANG_CHAMORRO = 'ch';
    const LANG_CHECHEN = 'ce';
    const LANG_CHICHEWA = 'ny';
    const LANG_CHINESE = 'zh';
    const LANG_CHINESE_SIMPLIFIED = 'zh-Hans';
    const LANG_CHINESE_TRADITIONAL = 'zh-Hant';
    const LANG_CHUVASH = 'cv';
    const LANG_CORNISH = 'kw';
    const LANG_CORSICAN = 'co';
    const LANG_CREE = 'cr';
    const LANG_CROATIAN = 'hr';
    const LANG_CZECH = 'cs';
    const LANG_DANISH = 'da';
    const LANG_DIVEHI = 'dv';
    const LANG_DUTCH = 'nl';
    const LANG_DZONGKHA = 'dz';
    const LANG_ENGLISH = 'en';
    const LANG_ESPERANTO = 'eo';
    const LANG_ESTONIAN = 'et';
    const LANG_EWE = 'ee';
    const LANG_FAROESE = 'fo';
    const LANG_FIJIAN = 'fj';
    const LANG_FINNISH = 'fi';
    const LANG_FRENCH = 'fr';
    const LANG_FULA = 'ff';
    const LANG_GALICIAN = 'gl';
    const LANG_GAELIC_SCOTTISH = 'gd';
    const LANG_GAELIC_MANX = 'gv';
    const LANG_GEORGIAN = 'ka';
    const LANG_GERMAN = 'de';
    const LANG_GREEK = 'el';
    const LANG_GREENLANDIC = 'kl';
    const LANG_GUARANI = 'gn';
    const LANG_GUJARATI = 'gu';
    const LANG_HAITIAN_CREOLE = 'ht';
    const LANG_HAUSA = 'ha';
    const LANG_HEBREW = 'he';
    const LANG_HERERO = 'hz';
    const LANG_HINDI = 'hi';
    const LANG_HIRI_MOTU = 'ho';
    const LANG_HUNGARIAN = 'hu';
    const LANG_ICELANDIC = 'is';
    const LANG_IDO = 'io';
    const LANG_IGBO = 'ig';
    const LANG_INDONESIAN = 'id, in';
    const LANG_INTERLINGUA = 'ia';
    const LANG_INTERLINGUE = 'ie';
    const LANG_INUKTITUT = 'iu';
    const LANG_INUPIAK = 'ik';
    const LANG_IRISH = 'ga';
    const LANG_ITALIAN = 'it';
    const LANG_JAPANESE = 'ja';
    const LANG_JAVANESE = 'jv';
    const LANG_KALAALLISUT = 'kl';
    const LANG_KANNADA = 'kn';
    const LANG_KANURI = 'kr';
    const LANG_KASHMIRI = 'ks';
    const LANG_KAZAKH = 'kk';
    const LANG_KHMER = 'km';
    const LANG_KIKUYU = 'ki';
    const LANG_KINYARWANDA = 'rw';
    const LANG_KIRUNDI = 'rn';
    const LANG_KYRGYZ = 'ky';
    const LANG_KOMI = 'kv';
    const LANG_KONGO = 'kg';
    const LANG_KOREAN = 'ko';
    const LANG_KURDISH = 'ku';
    const LANG_KWANYAMA = 'kj';
    const LANG_LAO = 'lo';
    const LANG_LATIN = 'la';
    const LANG_LATVIAN = 'lv';
    const LANG_LIMBURGISH = 'li';
    const LANG_LINGALA = 'ln';
    const LANG_LITHUANIAN = 'lt';
    const LANG_LUGA_KATANGA = 'lu';
    const LANG_LUGANDA = 'lg';
    const LANG_LUXEMBOURGISH = 'lb';
    const LANG_MANX = 'gv';
    const LANG_MACEDONIAN = 'mk';
    const LANG_MALAGASY = 'mg';
    const LANG_MALAY = 'ms';
    const LANG_MALAYALAM = 'ml';
    const LANG_MALTESE = 'mt';
    const LANG_MAORI = 'mi';
    const LANG_MARATHI = 'mr';
    const LANG_MARSHALLESE = 'mh';
    const LANG_MOLDAVIAN = 'mo';
    const LANG_MONGOLIAN = 'mn';
    const LANG_NAURU = 'na';
    const LANG_NAVAJO = 'nv';
    const LANG_NDONGA = 'ng';
    const LANG_NORTHERN_NDEBELE = 'nd';
    const LANG_NEPALI = 'ne';
    const LANG_NORWEGIAN = 'no';
    const LANG_NORWEGIAN_BOKMAYL = 'nb';
    const LANG_NORWEGIAN_NYNORSK = 'nn';
    const LANG_NUOSU = 'ii';
    const LANG_OCCITAN = 'oc';
    const LANG_OJIBWE = 'oj';
    const LANG_OLD_CHURCH_SLAVONIC = 'cu';
    const LANG_ORIYA = 'or';
    const LANG_OROMO = 'om';
    const LANG_OSSETIAN = 'os';
    const LANG_PÄLI = 'pi';
    const LANG_PASHTO = 'ps';
    const LANG_PERSIAN = 'fa';
    const LANG_POLISH = 'pl';
    const LANG_PORTUGUESE = 'pt';
    const LANG_PUNJABI = 'pa';
    const LANG_QUECHUA = 'qu';
    const LANG_ROMANSH = 'rm';
    const LANG_ROMANIAN = 'ro';
    const LANG_RUSSIAN = 'ru';
    const LANG_SAMI = 'se';
    const LANG_SAMOAN = 'sm';
    const LANG_SANGO = 'sg';
    const LANG_SANSKRIT = 'sa';
    const LANG_SERBIAN = 'sr';
    const LANG_SERBO_CROATIAN = 'sh';
    const LANG_SESOTHO = 'st';
    const LANG_SETSWANA = 'tn';
    const LANG_SHONA = 'sn';
    const LANG_SICHUAN_YI = 'ii';
    const LANG_SINDHI = 'sd';
    const LANG_SINHALESE = 'si';
    const LANG_SISWATI = 'ss';
    const LANG_SLOVAK = 'sk';
    const LANG_SLOVENIAN = 'sl';
    const LANG_SOMALI = 'so';
    const LANG_SOUTHERN_NDEBELE = 'nr';
    const LANG_SPANISH = 'es';
    const LANG_SUNDANESE = 'su';
    const LANG_SWAHILI = 'sw';
    const LANG_SWATI = 'ss';
    const LANG_SWEDISH = 'sv';
    const LANG_TAGALOG = 'tl';
    const LANG_TAHITIAN = 'ty';
    const LANG_TAJIK = 'tg';
    const LANG_TAMIL = 'ta';
    const LANG_TATAR = 'tt';
    const LANG_TELUGU = 'te';
    const LANG_THAI = 'th';
    const LANG_TIBETAN = 'bo';
    const LANG_TIGRINYA = 'ti';
    const LANG_TONGA = 'to';
    const LANG_TSONGA = 'ts';
    const LANG_TURKISH = 'tr';
    const LANG_TURKMEN = 'tk';
    const LANG_TWI = 'tw';
    const LANG_UYGHUR = 'ug';
    const LANG_UKRAINIAN = 'uk';
    const LANG_URDU = 'ur';
    const LANG_UZBEK = 'uz';
    const LANG_VENDA = 've';
    const LANG_VIETNAMESE = 'vi';
    const LANG_VOLAPÃ¼K = 'vo';
    const LANG_WALLON = 'wa';
    const LANG_WELSH = 'cy';
    const LANG_WOLOF = 'wo';
    const LANG_WESTERN_FRISIAN = 'fy';
    const LANG_XHOSA = 'xh';
    const LANG_YIDDISH = 'yi, ji';
    const LANG_YORUBA = 'yo';
    const LANG_ZHUANG = 'za';
    const LANG_ZULU = 'zu';

    // Define Charset constants.
    const CHARSET_ASCII = 'ASCII';
    const CHARSET_WINDOWS_1252 = 'Windows-1252';
    const CHARSET_UTF_ISO_8859_1 = 'ISO-8859-1';
    const CHARSET_UTF_8 = 'UTF-8';

    /**
     * HTML Document language.
     *
     * @var string
     */
    private $_language = self::LANG_ENGLISH;

    /**
     * HTML Document charset.
     *
     * @var string
     */
    private $_charset = self::CHARSET_UTF_8;

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
     * HTML Document styles [optional].
     *
     * @var array
     */
    private $_styles;

    /**
     * HTML Document body.
     *
     * @var string
     */
    private $_body;

    /**
     * HTML Document scripts [optional].
     *
     * @var array
     */
    private $_scripts;

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
     * Set HTML Document language.
     *
     * @param string $language HTML Document language.
     *
     * @return \ABGEO\HTMLGenerator\Document
     *
     * @throws \ReflectionException
     * @throws InvalidDocumentException
     */
    public function setLanguage(string $language): self
    {
        $validLanguages = array_filter(
            $this->_getConstants(), function ($key) {
                return strpos($key, 'LANG_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given language is valid.
        if (!in_array($language, array_values($validLanguages))) {
            throw new InvalidDocumentException(
                'Language code "' . $language . '" is invalid!', 3
            );
        }

        $this->_language = $language;

        return $this;
    }

    /**
     * Set HTML Document charset.
     *
     * @param string $charset HTML Document charset.
     *
     * @return \ABGEO\HTMLGenerator\Document
     * @throws InvalidDocumentException
     * @throws \ReflectionException
     */
    public function setCharset(string $charset): self
    {
        $validCharsets = array_filter(
            $this->_getConstants(), function ($key) {
                return strpos($key, 'CHARSET_') === 0;
            }, ARRAY_FILTER_USE_KEY
        );

        // Check if given charset is valid.
        if (!in_array($charset, array_values($validCharsets))) {
            throw new InvalidDocumentException(
                'Charset "' . $charset . '" is invalid!', 4
            );
        }

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
     * Append to HTML Document styles.
     *
     * @param string $filePath Style file path.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function addStyle(string $filePath): self
    {
        $this->_styles[] = $filePath;
        $this->_styles = array_unique($this->_styles);

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
     * Append to HTML Document scripts.
     *
     * @param string $filePath Script file path.
     *
     * @return \ABGEO\HTMLGenerator\Document
     */
    public function addScript(string $filePath): self
    {
        $this->_scripts[] = $filePath;
        $this->_scripts = array_unique($this->_scripts);

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

        // Add styles.
        $styles = '';
        foreach ($this->_styles as $style) {
            $styles .= "<link rel=\"stylesheet\" href=\"{$style}\">\n\t";
        }
        $document = str_replace('{styles}', $styles, $document);

        // Add scripts.
        $scripts = '';
        foreach ($this->_scripts as $script) {
            $scripts .= "<script src=\"{$script}\"></script> \n\t";
        }
        $document = str_replace('{scripts}', $scripts, $document);

        return $document;
    }

    /**
     * Convert class to string.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getDocument();
        } catch (InvalidDocumentException $e) {
            exit($e->getMessage());
        }
    }
}
