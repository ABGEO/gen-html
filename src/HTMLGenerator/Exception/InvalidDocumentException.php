<?php
/**
 * Class InvalidDocumentException |
 * src/HTMLGenerator/Exception/InvalidDocumentException.php
 *
 * PHP version 5
 *
 * @category Library
 * @package  ABGEO\HTMLGenerator
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  MIT https://github.com/ABGEO07/gen-html/blob/master/LICENSE
 * @version  GIT: $Id$.
 * @link     https://github.com/ABGEO07/gen-html
 */

namespace ABGEO\HTMLGenerator\Exception;

use Exception;

/**
 * Class InvalidDocumentException
 *
 * @category Library
 * @package  ABGEO\HTMLGenerator
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  MIT https://github.com/ABGEO07/gen-html/blob/master/LICENSE
 * @link     https://github.com/ABGEO07/gen-html
 */
class InvalidDocumentException extends \Exception
{
    /**
     * InvalidCurrencyException constructor.
     *
     * @param string     $message  Error message.
     * @param int        $code     [optional] The Exception code.
     *                             1: Empty Document title,
     *                             2: Empty document body,
     *                             3: Invalid Language Code,
     *                             4: Invalid Charset.
     * @param \Exception $previous [optional] The previous throwable
     *                             used for the exception chaining.
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct('Invalid HTML Document: ' . $message, $code, $previous);
    }

    /**
     * Convert exception to string.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
