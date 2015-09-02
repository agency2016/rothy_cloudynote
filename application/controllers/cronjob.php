<?php

class Cronjob extends CI_Controller {

    private $accessible = false;
    public function __construct() {
        parent::__construct();
        if($this->input->is_cli_request()) {
            $this->accessible = true;
        }
        $this->load->library('braintree_ci');
    }
    
    public function process($msg = 'World') {
        if($this->accessible) {
            echo "Hello {$msg}";
        }
    }

    public function webhooks() {

        require_once('application/libraries/braintree_ci/lib/braintree.php');

        Braintree_Configuration::environment("sandbox");
        Braintree_Configuration::merchantId("yv7v3d5f833vjkp2");
        Braintree_Configuration::publicKey("chg92p6xsjrx4nhj");
        Braintree_Configuration::privateKey("da8986a0ea0ffa58ef149c5f101faee5");

        if($_GET["bt_challenge"]) {
            echo ( Braintree_WebhookNotification::verify($_GET["bt_challenge"]) );
        }

        if( $this->input->post('bt_signature') and $this->input->post('bt_payload') ) {
            if( !$webhookNotification = $this->braintree_ci->webhooks_for_braintree( $this->input->post('bt_signature'), $this->input->post('bt_payload') ) ) {
                $braintree_response_data = array(
                    'recurring_transaction'                     => 1,
                    'recurring_customer_id'                     => $webhookNotification->subscription->transactions[0]->customer[id],
                    'recurring_subscription_id'                 => $webhookNotification->subscription->id,
                    'recurring_subscription_status'             => $webhookNotification->subscription->status,
                    'recurring_next_billing_amount'             => $webhookNotification->subscription->nextBillAmount,
                    'recurring_next_billing_date'               => $webhookNotification->subscription->nextBillingDate->format('Y-m-d'),
                    'recurring_current_billing_cycle'           => $webhookNotification->subscription->currentBillingCycle,
                    'recurring_payment_method_token'            => $webhookNotification->subscription->paymentMethodToken,
                    'recurring_currency_code'                   => $webhookNotification->subscription->transactions[0]->currencyIsoCode,
                    'recurring_transaction_failure'             => 0,
                    'transaction_id'                            => $webhookNotification->subscription->transactions[0]->id,
                    'transaction_status'                        => $webhookNotification->subscription->transactions[0]->status,
                    'customer_billing_country_code_alpha_2'     => $webhookNotification->subscription->transactions[0]->billing[countryCodeAlpha2],
                    'customer_billing_country_code_alpha_3'     => $webhookNotification->subscription->transactions[0]->billing[countryCodeAlpha3],
                    'amount'                                    => $webhookNotification->subscription->transactions[0]->amount,
                    'credit_card_type'                          => '',
                );

                $this->load->model('payment_model');

                if( !$this->payment_model->update_order_info( $braintree_response_data, $webhookNotification->subscription->transactions[0]->orderId, true ) ) {
                    $log_message = date('Y-m-d H:i:s').' A transaction has made with Customer ID'.$webhookNotification->subscription->transactions[0]->customer[id].'. Transaction status is '.$webhookNotification->subscription->transactions[0]->status.'. Paid amount is '.$webhookNotification->subscription->transactions[0]->amount.', but could not update database.';
                    log_message('error', $log_message);
                }
            }
        }
    }

    public function note_scheduler() {

        $view_note_template = $this->load->view('page/email/view_note', '' , true);

        $this->load->model( 'note_model' );
        $this->load->helper( 'function' );
        $receive_all_mail = $this->note_model->get_all_email_list_for_sending_note();
        //print_r($receive_all_mail);exit;
        $mail_sending_array = array();

        /*$mail_info = array(
 *      'from' => (string),
 *      'to' => (string|array),
 *      'cc' => (string|array),
 *      'bcc' => (string|array),
 *      'subject' => (string),
 *      'message' => (string),
 *      'header' => (string|array),
 *      'attachment' => (array|string)
        *  )*/

        if( is_array( $receive_all_mail ) and count( $receive_all_mail ) > 0) {
            $mail_sending_array['from'] = 'no-reply@cloudenotes.com';
            foreach($receive_all_mail as $mail_list) {
                $temp_mail_to['children_id']            = $mail_list['children_id'];
                if( empty( $mail_list['parent_id'] ) or empty( $mail_list['caregiver_unique_id'] ) or empty( $mail_list['parent_email'] ) ) {
                    $temp_mail_to['parent_fname']           = $mail_list['response_note_receiver_first_name'];
                    $temp_mail_to['parent_email']           = $mail_list['response_note_receiver_email'];
                } else {
                    $temp_mail_to['parent_email']           = $mail_list['parent_email'];
                    $temp_mail_to['parent_fname']           = $mail_list['parent_first_name'];
                }
                $temp_mail_to['public_note_view_id']    = $mail_list['response_public_view_id'];
                $temp_mail_to['note_response_id']       = $mail_list['response_id'];
                $temp_mail_to['organisation_name']      = $mail_list['organisation_name'];
                $temp_mail_to['note_title']             = $mail_list['note_title'];
                $mail_sending_array['to'][] = $temp_mail_to;
            }
            $mail_sending_array['subject'] = 'You have a new CloudeNote';
            $mail_sending_array['message'] = $view_note_template;
            $result = send_mail( $mail_sending_array, 5 );
            var_dump($result);exit;
        }
    }

}

?>