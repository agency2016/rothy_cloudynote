<?php
/**
 * braintree base class and initialization
 *
 *  PHP version 5
 *
 * @copyright  2010 braintree Payment Solutions
 */


set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__)));

/**
 * braintree PHP Library
 *
 * Provides methods to child classes. This class cannot be instantiated.
 *
 * @copyright  2010 braintree Payment Solutions
 */
abstract class Braintree
{
    /**
     * @ignore
     * don't permit an explicit call of the constructor!
     * (like $t = new Braintree_Transaction())
     */
    protected function __construct()
    {
    }
    /**
     * @ignore
     *  don't permit cloning the instances (like $x = clone $v)
     */
    protected function __clone()
    {
    }

    /**
     * returns private/nonexistent instance properties
     * @ignore
     * @access public
     * @param string $name property name
     * @return mixed contents of instance properties
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }
        else {
            trigger_error('Undefined property on ' . get_class($this) . ': ' . $name, E_USER_NOTICE);
            return null;
        }
    }

    /**
     * used by isset() and empty()
     * @access public
     * @param string $name property name
     * @return boolean
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->_attributes);
    }

    public function _set($key, $value)
    {
        $this->_attributes[$key] = $value;
    }

    /**
     *
     * @param string $className
     * @param object $resultObj
     * @return object returns the passed object if successful
     * @throws Braintree_Exception_ValidationsFailed
     */
    public static function returnObjectOrThrowException($className, $resultObj)
    {
        $resultObjName = Braintree_Util::cleanClassName($className);
        if ($resultObj->success) {
            return $resultObj->$resultObjName;
        } else {
            throw new Braintree_Exception_ValidationsFailed();
        }
    }
}

require_once('braintree/Modification.php');
require_once('braintree/Instance.php');

require_once('braintree/Address.php');
require_once('braintree/AddOn.php');
require_once('braintree/Collection.php');
require_once('braintree/Configuration.php');
require_once('braintree/CreditCard.php');
require_once('braintree/Customer.php');
require_once('braintree/CustomerSearch.php');
require_once('braintree/DisbursementDetails.php');
require_once('braintree/Descriptor.php');
require_once('braintree/Digest.php');
require_once('braintree/Discount.php');
require_once('braintree/IsNode.php');
require_once('braintree/EqualityNode.php');
require_once('braintree/Exception.php');
require_once('braintree/Http.php');
require_once('braintree/KeyValueNode.php');
require_once('braintree/MerchantAccount.php');
require_once('braintree/merchantaccount/BusinessDetails.php');
require_once('braintree/merchantaccount/FundingDetails.php');
require_once('braintree/merchantaccount/IndividualDetails.php');
require_once('braintree/merchantaccount/AddressDetails.php');
require_once('braintree/MultipleValueNode.php');
require_once('braintree/MultipleValueOrTextNode.php');
require_once('braintree/PartialMatchNode.php');
require_once('braintree/Plan.php');
require_once('braintree/RangeNode.php');
require_once('braintree/ResourceCollection.php');
require_once('braintree/SettlementBatchSummary.php');
require_once('braintree/Subscription.php');
require_once('braintree/SubscriptionSearch.php');
require_once('braintree/TextNode.php');
require_once('braintree/Transaction.php');
require_once('braintree/TransactionSearch.php');
require_once('braintree/TransparentRedirect.php');
require_once('braintree/Util.php');
require_once('braintree/Version.php');
require_once('braintree/Xml.php');
require_once('braintree/error/Codes.php');
require_once('braintree/error/ErrorCollection.php');
require_once('braintree/error/Validation.php');
require_once('braintree/error/ValidationErrorCollection.php');
require_once('braintree/exception/Authentication.php');
require_once('braintree/exception/Authorization.php');
require_once('braintree/exception/Configuration.php');
require_once('braintree/exception/DownForMaintenance.php');
require_once('braintree/exception/ForgedQueryString.php');
require_once('braintree/exception/InvalidSignature.php');
require_once('braintree/exception/NotFound.php');
require_once('braintree/exception/ServerError.php');
require_once('braintree/exception/SSLCertificate.php');
require_once('braintree/exception/SSLCaFileNotFound.php');
require_once('braintree/exception/Unexpected.php');
require_once('braintree/exception/UpgradeRequired.php');
require_once('braintree/exception/ValidationsFailed.php');
require_once('braintree/result/CreditCardVerification.php');
require_once('braintree/result/Error.php');
require_once('braintree/result/Successful.php');
require_once('braintree/test/CreditCardNumbers.php');
require_once('braintree/test/MerchantAccount.php');
require_once('braintree/test/TransactionAmounts.php');
require_once('braintree/test/VenmoSdk.php');
require_once('braintree/transaction/AddressDetails.php');
require_once('braintree/transaction/CreditCardDetails.php');
require_once('braintree/transaction/CustomerDetails.php');
require_once('braintree/transaction/StatusDetails.php');
require_once('braintree/transaction/SubscriptionDetails.php');
require_once('braintree/WebhookNotification.php');
require_once('braintree/WebhookTesting.php');
require_once('braintree/xml/Generator.php');
require_once('braintree/xml/Parser.php');
require_once('braintree/CreditCardVerification.php');
require_once('braintree/CreditCardVerificationSearch.php');
require_once('braintree/PartnerMerchant.php');

if (version_compare(PHP_VERSION, '5.2.1', '<')) {
    throw new Braintree_Exception('PHP version >= 5.2.1 required');
}


function requireDependencies() {
    $requiredExtensions = array('xmlwriter', 'SimpleXML', 'openssl', 'dom', 'hash', 'curl');
    foreach ($requiredExtensions AS $ext) {
        if (!extension_loaded($ext)) {
            throw new Braintree_Exception('The braintree library requires the ' . $ext . ' extension.');
        }
    }
}

requireDependencies();
