<?php
/**
 * Created by PhpStorm.
 * User: MANCHU
 * Date: 2/24/14
 * Time: 3:57 PM
 */

require_once( 'application/libraries/braintree_ci/lib/braintree.php' );

class Braintree_ci {

    private $input = '';

    public function __construct() {
        $this->ci =& get_instance();
        $this->input = $this->ci->input;

        Braintree_Configuration::environment("sandbox");
        Braintree_Configuration::merchantId("yv7v3d5f833vjkp2");
        Braintree_Configuration::publicKey("chg92p6xsjrx4nhj");
        Braintree_Configuration::privateKey("da8986a0ea0ffa58ef149c5f101faee5");
    }


    /**
     * Customer Details Data Fetch
     */
    public function customerDetails(){
        //needs to be fetch data from website [customer]
        $custDetails = array(
            'firstName' => $_POST['customer_fname'],
            'lastName'  => $_POST['customer_lname'],
            'email'     => $_POST['customer_email'],
            'website'   => $_POST['customer_web'],
            'company'   => $_POST['customer_company'],
            'phone'     => $_POST['customer_phone'],
            'fax'       => $_POST['customer_fax']
        );
        return $custDetails;
    }


    /**
     * Billing Information Data Fetch [billing]
     */
    public function billingDetails(){
        //needs to pull these data from db
        $billDetails = array(
            'firstName'         => $_POST['customer_billing_fname'],
            'lastName'          => $_POST['customer_billing_lname'],
            'company'           => $_POST['customer_billing_company'],
            'countryName'       => $_POST['customer_billing_country'],
            'streetAddress'     => $_POST['customer_billing_streetAddress'],
            'extendedAddress'   => $_POST['customer_billing_streetAddress2'],
            'locality'          => $_POST['customer_billing_locality'],
            'region'            => $_POST['customer_billing_region'],
            'postalCode'        => $_POST['customer_billing_postcode'],
            'countryCodeAlpha3' => $_POST['customer_billing_countryCodeAlpha3']
        );
        return $billDetails;
    }


    /**
     * Credit Card Details [creditCard]
     */
    public function creditCardDetails(){
        //needs to pull these data from form submission
        $creditCard = array(
            "number" 			=> $_POST["number"],
            "cvv" 	 			=> $_POST["cvv"],
            "expirationMonth" 	=> $_POST["month"],
            "expirationYear" 	=> $_POST["year"],
            "cardholderName"	=> $_POST["chname"]
        );

        return $creditCard;
    }


    /**
     * Connect & Grab The data
     */
    public function braintreeConnect($amount, $order_id){
        $paymentData = array(
            'amount'    => $amount,
            'orderId'   => $order_id,
            'creditCard'=> $this->creditCardDetails(),
            'customer'  => $this->customerDetails(),
            'billing'   => $this->billingDetails(),
            'options'   => array(
                'submitForSettlement' => true
            )
        );
        return Braintree_Transaction::sale($paymentData);
    }

    /**
     * Transaction settlement method
     * for cronjob
     * @param $trans_id
     * @return object
     */
    public function transactionSettlement($trans_id){

        $transaction = Braintree_Transaction::find( $trans_id );
        //return $transaction;
        if ( $transaction->status == Braintree_Transaction::SETTLED ) {
            $result = array(
                'is_settlement'     => true
            );
        } else {
            $result = array(
                'is_settlement'     => false
            );
        }

        $result['recurring']            = $transaction->recurring;
        $result['status']               = $transaction->status;
        $result['package_id']           = $transaction->planId;
        $result['subscription_id']      = $transaction->subscriptionId;
        return $result;
    }

    public function createSubscription($customer_id, $package_code, $monthly_price) {
        try {
            $customer               = Braintree_Customer::find( $customer_id );
            $payment_method_token   = $customer->creditCards[0]->token;

            $result = Braintree_Subscription::create(array(
                'paymentMethodToken'        => $payment_method_token,
                'planId'                    => $package_code,
                'price'                     => $monthly_price
             ));
            return $result;

        } catch( Braintree_Exception_NotFound $e ) {
            $bexcption = print_r( $e, true );
            log_message('error', date( 'Y-m-d H:i:s' ).' '.$bexcption, true);
            $result = new stdClass();
            $result->success = false;
            return $result;
        }
    }

    /**
     * Connect braintree for monthly payment system
     *
     * @param $ammount
     * @return array
     */

    public function braintreeConnectForMonthly() {
        $customer_data = array(
            'firstName' => $this->input->post( 'customer_fname' ),
            'lastName' => $this->input->post( 'customer_lname' ),
            'email' => $this->input->post( 'customer_email' ),
            'company' => $this->input->post( 'customer_company' ),
            'fax' => $this->input->post( 'customer_fax' ),
            'website' => $this->input->post( 'customer_web' ),
            'phone' => $this->input->post( 'customer_phone' ),
            'creditCard'=> $this->creditCardDetails()
        );

        $customer_data['creditCard']['billingAddress'] = $this->billingDetails();
        try {
            return Braintree_Customer::create( $customer_data );
        } catch (InvalidArgumentException $BraintreeException) {
            $bexcption = print_r($BraintreeException, true);
            log_message('error', date('Y-m-d H:i:s').' '.$bexcption);
            $result = new stdClass();
            $result->success = false;
            return $result;
        }
    }



} 