<?php
/**
 * Disbursement details from a transaction
 *
 * @package    braintree
 * @copyright  2010 braintree Payment Solutions
 */

/**
 * Creates an instance of DisbursementDetails as returned from a transaction
 *
 *
 * @package    braintree
 * @copyright  2010 braintree Payment Solutions
 *
 * @property-read string $settlementAmount
 * @property-read string $settlementCurrencyIsoCode
 * @property-read string $settlementCurrencyExchangeRate
 * @property-read string $settlementFundsHeld
 * @property-read string $disbursementDate
 * @uses Braintree_Instance inherits methods
 */
class Braintree_DisbursementDetails extends Braintree_Instance
{
    protected $_attributes = array();

    function isValid() {
        return !is_null($this->disbursementDate);
    }
}
