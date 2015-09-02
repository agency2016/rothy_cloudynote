<?php
/**
 * Created by PhpStorm.
 * User: MANCHU
 * Date: 2/23/14
 * Time: 5:33 PM
 */

class Webhooks extends MY_Controller {

    public function __construct() {
        $config = array(
            'environment' => 'sandbox',
            'merchantId'  => 'yv7v3d5f833vjkp2',
            'publicKey'   => 'chg92p6xsjrx4nhj',
            'privateKey'  => 'da8986a0ea0ffa58ef149c5f101faee5'
        );
        require_once('application/libraries/braintree_ci/lib/braintree.php');

        Braintree_Configuration::environment("sandbox");
        Braintree_Configuration::merchantId("yv7v3d5f833vjkp2");
        Braintree_Configuration::publicKey("chg92p6xsjrx4nhj");
        Braintree_Configuration::privateKey("da8986a0ea0ffa58ef149c5f101faee5");

        if($_GET["bt_challenge"]) {
            echo ( Braintree_WebhookNotification::verify($_GET["bt_challenge"]) );
            mail('sudarshan@codeboxr.net','Web Hook Notification', 'Message From get notification');
        }

        if( isset( $_POST["bt_signature"] ) and isset( $_POST["bt_payload"] ) ) {
            $webHookNotification = Braintree_WebhookNotification::parse( $_POST["bt_signature"], $_POST["bt_payload"] );

            mail('sudarshan@codeboxr.net','Web Hook Notification', print_r($webHookNotification, true));

            /*$this->load->model( 'payment' );

            $braintree_response_data = array(
                'recurring_transaction'                     => 1,
                'recurring_customer_id'                     => $webHookNotification->subscription->transactions[0]->customer[id],
                'recurring_subscription_id'                 => $webHookNotification->subscription->id,
                'recurring_subscription_status'             => $webHookNotification->subscription->status,
                'recurring_next_billing_amount'             => $webHookNotification->subscription->nextBillAmount,
                'recurring_next_billing_date'               => $webHookNotification->subscription->nextBillingDate->format( 'Y-m-d' ),
                'recurring_current_billing_cycle'           => $webHookNotification->subscription->currentBillingCycle,
                'recurring_payment_method_token'            => $webHookNotification->subscription->paymentMethodToken,
                'recurring_currency_code'                   => $webHookNotification->subscription->transactions[0]->currencyIsoCode,
                'recurring_transaction_failure'             => 0,

                'transaction_id'                            => $webHookNotification->subscription->transactions[0]->id,
                'transaction_status'                        => $webHookNotification->subscription->transactions[0]->status,

                'customer_billing_country_code_alpha_2'     => $webHookNotification->subscription->transactions[0]->billing[countryCodeAlpha2],
                'customer_billing_country_code_alpha_3'     => $webHookNotification->subscription->transactions[0]->billing[countryCodeAlpha3],
                'amount'                                    => $webHookNotification->subscription->transactions[0]->amount,
                'credit_card_type'                          => '',
            );*/
        }

    }

    public function index() {

    }
}