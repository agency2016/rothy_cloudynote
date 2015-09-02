<?php
/**
 * Customer details from a transaction
 *
 * @package    braintree
 * @subpackage transaction
 * @copyright  2010 braintree Payment Solutions
 */

/**
 * Creates an instance of customer details as returned from a transaction
 *
 * @package    braintree
 * @subpackage transaction
 * @copyright  2010 braintree Payment Solutions
 * 
 * @property-read string $company
 * @property-read string $email
 * @property-read string $fax
 * @property-read string $firstName
 * @property-read string $id
 * @property-read string $lastName
 * @property-read string $phone
 * @property-read string $website
 * @uses Braintree_Instance inherits methods
 */
class Braintree_Transaction_CustomerDetails extends Braintree_Instance
{
}
