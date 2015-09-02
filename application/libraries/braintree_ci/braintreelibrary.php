<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/10/13
 * Time: 3:01 PM
 */


require_once 'application/libraries/braintree_ci/lib/braintree.php';

    /**
     * braintree Custom Library
     */
    class BraintreeLibrary{

        //All the encryption key
        public $environment;
        public $merchantId;
        public $publicKey;
        public $privateKey;
        public $publicEncryptKey;
        public $mainContent;

        /**
         * Constructor method to call the main braintree php api
         * & set the configuration there
         *
         * included since v1.0
         *
         * @param $config
         */
        public function __construct($config){

            //Including main braintree library for connection
            //braintree configuration
            Braintree_Configuration::environment($config['environment']);
            Braintree_Configuration::merchantId($config['merchantId']);
            Braintree_Configuration::publicKey($config['publicKey']);
            Braintree_Configuration::privateKey($config['privateKey']);
        }

        /**
         * Main transaction part to do all the things
         *
         * Included since v1.0
         *
         * @param $mainContent
         */
        public function transaction($mainContent){
            $result = Braintree_Transaction::sale($mainContent);
            return $result;
        }

        /**
         * Recurring Billing transaction
         *
         * Include since v1.0
         *
         * @param $mainContent
         */
        public function recurring_billing($mainContent){
            $result = Braintree_Customer::create($mainContent);
            return $result;
        }

        /**
         * Transaction Settlement
         *
         * @param $trans_id
         * @return object
         */
        public function transSettlement($trans_id){
            $transaction = Braintree_Transaction::find($trans_id);
            if ($transaction->status == Braintree_Transaction::SETTLED) {
                $result = array(
                    'status'        => $transaction->status,
                    'is_settlement'  => true
                );
                return $result;
            } else {
                $result = array(
                    'status'         => $transaction->status,
                    'is_settlement'  => false
                );
                return $result;
            }
        }

        /**
         * Braintree Fetch the customer id
         *
         * @param $payment_data
         * @return object
         */
        public function customerCreate($customer_data){
            return Braintree_Customer::create( $customer_data );
        }

        /**
         * Create a subscription according to the package user wants
         *
         * @param $customer_id
         * @param $package_code
         * @return Braintree_Result_Error|Braintree_Result_Successful
         */
        public function getSubscription($customer_id, $package_code, $monthly_price){

            try {
                $customer               = Braintree_Customer::find( $customer_id );
                $payment_method_token   = $customer->creditCards[0]->token;

                $result = Braintree_Subscription::create(array(
                     'paymentMethodToken'       => $payment_method_token,
                     'planId'                   => $package_code,
                     'price'                    => $monthly_price
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

        public function webHookVerify($bt_challenge) {
            echo ( Braintree_WebhookNotification::verify( $bt_challenge ) );
        }


        /**
         * Get notification for recurring billing
         * @param $bt_signature
         * @param $bt_payload
         * @return Braintree_WebhookNotification
         */
        public function webHookNotification($bt_signature, $bt_payload) {
            return Braintree_WebhookNotification::parse( $bt_signature, $bt_payload );
        }
    }