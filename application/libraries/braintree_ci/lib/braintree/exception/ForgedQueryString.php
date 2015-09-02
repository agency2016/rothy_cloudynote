<?php
/**
 * Raised when a suspected forged query string is present
 *
 * @package    braintree
 * @subpackage exception
 * @copyright  2010 braintree Payment Solutions
 */

/**
 * Raised from methods that confirm transparent request requests
 * when the given query string cannot be verified. This may indicate
 * an attempted hack on the merchant's transparent redirect
 * confirmation URL.
 *
 * @package    braintree
 * @subpackage exception
 * @copyright  2010 braintree Payment Solutions
 */
class Braintree_Exception_ForgedQueryString extends Braintree_Exception
{

}
