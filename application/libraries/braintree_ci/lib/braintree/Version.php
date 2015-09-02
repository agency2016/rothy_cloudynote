<?php
/**
 * braintree Library Version
 *
 * @copyright  2010 braintree Payment Solutions
 */

/**
 * stores version information about the braintree library
 *
 *
 * @copyright  2010 braintree Payment Solutions
 */
final class Braintree_Version
{
    /**
     * class constants
     */
    const MAJOR = 2;
    const MINOR = 24;
    const TINY = 0;

    /**
     * @ignore
     * @access protected
     */
    protected function  __construct()
    {
    }

    /**
     *
     * @return string the current library version
     */
    public static function get()
    {
        return self::MAJOR.'.'.self::MINOR.'.'.self::TINY;
    }
}
