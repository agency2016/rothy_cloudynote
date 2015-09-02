<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/10/13
 * Time: 5:16 PM
 */

if(!class_exists('braintree_ci')) {

    /**
     * Class braintree_ci
     */
    class Braintree_ci {

        private $braintree = '';
        private $input = '';

        public function __construct(){
            //$this->showFormInstance();
            $this->ci =& get_instance();
            $this->input = $this->ci->input;
            require_once 'application/libraries/braintree_ci/braintreelibrary.php';
            $this->braintree = new BraintreeLibrary( $this->getConfig() );
        }

        /**
         * Configuration settings for braintree api
         */
        public function getConfig(){
            $config = array(
                'environment' => 'sandbox',
                'merchantId'  => 'yv7v3d5f833vjkp2',
                'publicKey'   => 'chg92p6xsjrx4nhj',
                'privateKey'  => 'da8986a0ea0ffa58ef149c5f101faee5'
            );
            return $config;
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
            return $this->braintree->transaction($paymentData);
        }

        /**
         * Transaction settlement method
         * for cronjob
         * @param $trans_id
         * @return object
         */
        public function transactionSettlement($trans_id){
            return $this->braintree->transSettlement($trans_id);
        }
        
        public function createSubscription($customer_id, $package_code, $monthly_price) {
            return $this->braintree->getSubscription( $customer_id, $package_code, $monthly_price );
        }

        /**
         * Connect braintree for monthly payment system
         *
         * @param $ammount
         * @return array
         */
        public function braintreeConnectForMonthly(){
            $customer_data = array(
                'firstName' => $this->input->post( 'customer_fname' ),
                'lastName' => $this->input->post( 'customer_lname' ),
                'email' => $this->input->post( 'customer_email' ),
                'company' => $this->input->post( 'customer_company' ),
                'fax' => $this->input->post( 'customer_fax' ),
                'website' => $this->input->post( 'customer_web' ),
                'phone' => $this->input->post( 'customer_phone' ),
                'customer' => array(),
                'creditCard'=> $this->creditCardDetails()
            );
            $customer_data['creditCard']['billingAddress'] = $this->billingDetails();
            try {
                return $this->braintree->customerCreate($customer_data);
            } catch (InvalidArgumentException $BraintreeException) {
                $bexcption = print_r($BraintreeException, true);
                log_message('error', date('Y-m-d H:i:s').' '.$bexcption, true);
                $result = new stdClass();
                $result->success = false;
                return $result;
            }
        }

        /**
         * Getting the visual data on the frontend
         */
//        public function showFormInstance(){
//
//
//        }

        /**
         * Verify webhooks
         * @param $bt_challenge
         * @return mixed
         */
        public function webhooks_verify($bt_challenge) {
            return $this->braintree->webHookVerify( $bt_challenge );
        }


        /**
         * Get WebHookNotification
         * @param $bt_signature
         * @param $bt_payload
         * @return mixed
         */
        public function webhooksNotification($bt_signature, $bt_payload) {
            return $this->braintree->webHookNotification( $bt_signature, $bt_payload );
        }
    }

}