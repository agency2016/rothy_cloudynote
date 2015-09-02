<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/11/13
 * Time: 4:53 PM
 */
class Payment extends MY_Controller {

    private $create_new_order                   = false;
    private $user_exist                         = false;
    private $user_have_running_package          = false;
    private $user_already_has_a_transaction     = false;
    //package information
    private $package_code                       = false;
    private $user_taken_package_id              = ''; //taken packages id: md5 32 char
    private $user_running_package_code          = ''; //taken packages code: 3 char
    private $user_running_package_id            = ''; //taken packages code id: int type
    private $package_yearly_price               = '';
    private $package_monthly_price              = 0;
    private $package_recurring_payment          = 'N';

    //transaction
    private $new_order_id                       = false;
    private $order_id                           = false;
    private $transaction_id                     = false;

    //form validation group
    private $validation_for_new_user            = false;
    private $validation_for_new_order           = false;
    private $validation_for_both                = false;


    private $css_js_array       = array(
        'codeboxr_css'  => array('template'),
        'codeboxr_js'   => array('app')
    );



    public function __construct(){
        parent::__construct($this->css_js_array);
        $this->load->model('payment_model');
        $this->load->library('braintree_ci');
    }



    private function check_user_running_package($email) {
        if( !$result = $this->payment_model->user_has_running_package( $email ) ) {
            return false;
        } else {
            $this->order_id                     = $result[0]->order_id;
            $this->user_taken_package_id        = $result[0]->taken_packages_id;
            $this->user_running_package_code    = $result[0]->taken_packages_package_code;
            $this->user_running_package_id      = $result[0]->package_id;
            $this->transaction_id               = $result[0]->transaction_id;
            $this->user_have_running_package    = true;
            return true;
        }
    }



    private function is_user_choose_downgrade_package($pkg_code) {
        $result = $this->payment_model->get_package_id_by_code( $pkg_code );
        if( $this->user_running_package_id > $result[0]->package_id ) {
            return true;
        } else {
            return false;
        }
    }



    private function have_any_order_in_queue($email) {
        if( $result = $this->payment_model->have_any_order_left_for_processing( $email ) ) {
            $this->order_id = $result[0]->oorder_id;
            $this->transaction_id = $result[0]->transaction_id;
            return true;
        } else {
            return false;
        }
    }



    private function create_new_user( $new_user, $recurring = false ) {
        $login_email        = $new_user['email'];
        $login_password     = $new_user['login_password'];
        unset( $new_user['login_password'] );

        if( $this->users->create_user( $new_user ) ) {
            $this->dx_auth->user_activated( $this->db->insert_id() );
            $this->payment_model->create_taken_package_for_new_user( $new_user['email'], $new_user['package_code'], $this->new_order_id, $recurring );
            if( $this->dx_auth->login( $login_email, $login_password ) ) {
                redirect( base_url('dashboard/') );
            } else {
                redirect(base_url('login/'));
            }
        } else {
            $log_message = 'Could not create user with email '.$new_user['email'];
            log_message('error', $log_message);
        }
    }



    private function process_new_order($order_id, $order_info, $recurring = false) {
        if( $this->payment_model->create_new_order( $order_info ) ) {

            if( !$recurring ) {
                $result = $this->braintree_ci->braintreeConnect( $this->package_yearly_price, $order_id );
                $braintree_response_data = array(
                    'transaction_id'                            => $result->transaction->id,
                    'transaction_status'                        => $result->transaction->status,
                    'customer_billing_country_code_alpha_2'     => $result->transaction->billingDetails->countryCodeAlpha2,
                    'customer_billing_country_code_alpha_3'     => $result->transaction->billingDetails->countryCodeAlpha3,
                    'amount'                                    => $result->transaction->amount,
                    'credit_card_type'                          => $result->transaction->creditCardDetails->cardType,
                );

                if( $result->success ) {
                    $braintree_response_data['transaction_failure'] = 0;
                    if( !$this->payment_model->update_order_info( $braintree_response_data, $order_id ) ) {
                        $log_message = date('Y-m-d H:i:s').' A transaction has made with transaction ID '.$result->transaction->id.'. Transaction status is '.$result->transaction->status.'. Paid amount is '.$result->transaction->amount.', but could not update database.';
                        log_message('error', $log_message);
                    }
                } else {
                    $braintree_response_data['transaction_failure'] = 1;
                    if( !$this->payment_model->update_order_info( $braintree_response_data, $order_id ) ) {
                        $log_message = date('Y-m-d H:i:s').' A failure transaction has made with transaction ID '.$result->transaction->id.'. Transaction status is '.$result->transaction->status.'. Paid amount was '.$result->transaction->amount.', but could not update database.';
                        log_message('error', $log_message);
                    }
                }

            } else {
                $result = $this->braintree_ci->braintreeConnectForMonthly();

                //$this->package_monthly_price, $order_id
                if ( $result->success ) {
                    $subscribe_customer = $this->braintree_ci->createSubscription($result->customer->id, $this->package_code, $this->package_monthly_price );
                    /*$subscribe_customer = $this->braintree_ci->getSubscription( $result->customer->id, $this->package_code );
                    if ( $subscribe_customer->success ) {
                        $braintree_response_data = array(
                            'recurring_transaction'                     => 1,
                            'recurring_customer_id'                     => $result->customer->id,
                            'recurring_subscription_id'                 => $subscribe_customer->subscription->id,
                            'recurring_subscription_status'             => $subscribe_customer->subscription->status,
                            'recurring_next_billing_amount'             => $subscribe_customer->subscription->nextBillAmount,
                            'recurring_next_billing_date'               => $subscribe_customer->subscription->nextBillingDate->format('Y-m-d'),
                            'recurring_current_billing_cycle'           => $subscribe_customer->subscription->currentBillingCycle,
                            'recurring_payment_method_token'            => $subscribe_customer->subscription->paymentMethodToken,
                            'recurring_currency_code'                   => $subscribe_customer->subscription->transactions[0]->currencyIsoCode,
                            'recurring_transaction_failure'             => 0,
                            'transaction_id'                            => $subscribe_customer->subscription->transactions[0]->id,
                            'transaction_status'                        => $subscribe_customer->subscription->transactions[0]->status,
                            'customer_billing_country_code_alpha_2'     => $subscribe_customer->subscription->transactions[0]->billing[countryCodeAlpha2],
                            'customer_billing_country_code_alpha_3'     => $subscribe_customer->subscription->transactions[0]->billing[countryCodeAlpha3],
                            'amount'                                    => $subscribe_customer->subscription->transactions[0]->amount,
                            'credit_card_type'                          => '',
                        );
                    } else {
                        $recurring_fail = true;
                    }*/
                } else {
                    $braintree_response_data['transaction_failure'] = 1;
                    if( !$this->payment_model->update_order_info( $braintree_response_data, $order_id ) ) {
                        $log_message = date('Y-m-d H:i:s').' A failure transaction has made with order ID '.$order_id.'. Transaction status is '.$result->transaction->status.'. Paid amount was '.$result->transaction->amount.', but could not update database.';
                        log_message('error', $log_message);
                    }
                }
            }
        } else {
            $log_message = date('Y-m-d H:i:s').' An order comes from '.set_value('user_email').' with amount of '.$this->package_yearly_price.' whom use customer email as '.set_value('customer_email').', but could not saved to database.';
            log_message('error', $log_message);
        }
    }

    public function index($package_code = '') {
        $data = array();
        if($package_code == '') {
            redirect( base_url( 'pricing' ) );
        }

        if( !$result = $this->payment_model->get_package_ammount( $package_code ) ) {
            redirect(base_url('pricing'));
        }

        $this->package_code                 = $package_code;
        $this->package_yearly_price         = $result[0]->package_yearly_price;
        $this->package_monthly_price        = sprintf('%.2f', ( $this->package_yearly_price / 12) );
        $this->package_recurring_payment    = $result[0]->package_recurring_payment;


        $data['amount'] = $this->package_yearly_price;
        $data['recurring_payment'] = $this->package_recurring_payment;
        $data['package_min_member'] = $result[0]->package_min_members;
        $data['package_max_member'] = $result[0]->package_max_members;
        $data['package_description'] = $result[0]->package_description;

        $css_js_for_pricing = array(
            'codeboxr_css' => array('bootstrap-switch','bootstrap-select.min'),
            'codeboxr_js' => array('jquery.smooth-scroll', 'bootstrap-select.min','bootsrap-collapse'),
        );

        $this->load->library('form_validation', '', 'frm_val');
        $this->load->model('dx_auth/users', 'users');
        $this->load->model('dx_auth/user_temp', 'user_temp');


        if( $this->dx_auth->is_logged_in() and $this->dx_auth->is_admin() ) { //if the logged in user is admin just redirect to dashboard

            redirect(base_url('dashboard'));

        } else if( $this->input->post('user_email') and $this->users->check_email( $this->input->post('user_email') ) ){ //if user in user table
            $this->user_exist                       = true;

            if( $this->check_user_running_package( $this->input->post('user_email') ) ) { // if the user already have a running or pending package
                $transaction_result = $this->braintree_ci->transactionSettlement( $this->transaction_id );
                $result->payment_model->update_order_info($transaction_result, $this->order_id, $this->user_taken_package_id);

                /*$braintree_response_data = array(
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
                if( ( $this->dx_auth->is_logged_in() ) or ( $this->dx_auth->login( $this->input->post('user_email'), $this->input->post( 'user_password' ) ) ) ) { //if user logged in redirect with package code
                    redirect( base_url('user/upgrade/'.$package_code) );
                } else {

                    redirect( base_url('login/?return_url='.base64_encode( base_url( 'user/upgrade/'.$package_code ) ).'&email='.$this->input->post('user_email').'&eauth='.md5( $this->input->post('user_email') ) ) );
                }
            } else if( $this->have_any_order_in_queue( $this->input->post( 'email' ) ) ) { // check if user have previous order for processing
                //braintree process code

                if( $this->dx_auth->is_logged_in() ) { //if user logged in redirect with package code
                    redirect( base_url('user/upgrade/'.$package_code) );
                } else if( $this->dx_auth->login( $this->input->post('user_email'), $this->input->post( 'user_password' ) )) {
                    redirect( base_url('user/upgrade/'.$package_code) );
                } else {
                    redirect( base_url('login/?return_url='.base_url( 'user/upgrade/'.$package_code ).'&email='.$this->input->post('user_email').'&eauth='.md5( $this->input->post('user_email') ) ) );
                }

            } else { // set validate rules if user have no running package or no previous order
                $this->validation_for_new_order     = true;
                $this->create_new_order             = true;
            }

        } else if( $this->input->post('user_email') and $this->have_any_order_in_queue( $this->input->post('user_email') ) ) { // if user have any previous order
            $this->validation_for_new_user          = true;
            $this->user_already_has_a_transaction   = true;
        } else {
            $this->validation_for_both = true;
        }

        if( $this->validation_for_both or $this->validation_for_new_user ) {
            //for new user
            // User registration info
            $min_password = 4;
            $max_password = 20;
            $this->frm_val->set_rules( 'user_email', 'Email', 'trim|required|xss_clean|valid_email' );
            $this->frm_val->set_rules( 'user_password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']' );
            $this->frm_val->set_rules( 'register_as', 'User Type', 'trim|required|xss_clean|numeric' );
        }

        if( $this->validation_for_both or $this->validation_for_new_order ) {
            // credit card details validation
            $this->frm_val->set_rules('number', 'Card Number', 'trim|required|min_length[15]|max_length[16]|xss_clean');
            $this->frm_val->set_rules('cvv', 'CVV', 'trim|required|min_length[3]|max_length[3]|xss_clean');
            $this->frm_val->set_rules('month', 'Expiration (MM/YYYY)', 'required|min_length[1]|max_length[2]|trim|xss_clean|required|is_natural_no_zero');
            $this->frm_val->set_rules('year', 'Expiration (MM/YYYY)', 'required|trim|min_length[3]|max_length[4]|xss_clean|required|is_natural_no_zero');
            $this->frm_val->set_rules('chname', 'Card Holder Name', 'required|trim|xss_clean');

            // customer details validation
            $this->frm_val->set_rules('customer_fname', 'First Name', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_lname', 'Last Name', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_email', 'Email', 'required|trim|xss_clean|valid_email');
            $this->frm_val->set_rules('customer_company', 'Company', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_phone', 'Phone', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_fax', 'Fax', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_web', 'Website', 'required|trim|xss_clean');

            // customer details validation
            $this->frm_val->set_rules('customer_billing_fname', 'First Name', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_lname', 'Last Name', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_company', 'Company', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_country', 'Country', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_countryCodeAlpha3', 'Country Code', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_locality', 'Locality', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_postcode', 'Post Code', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_region', 'Region', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_streetAddress', 'Stree Address', 'required|trim|xss_clean');
            $this->frm_val->set_rules('customer_billing_streetAddress2', 'Stree Address 2', 'trim|xss_clean');
        }


        if($this->frm_val->run() === false) {

        } else {

            $this->load->helper('function');

            $this->new_order_id = md5( time().unique_id_generator() );

            $order_info = array(
                'order_id'                                  => $this->new_order_id,
                'package_code'                              => $package_code,
                'customer_identity'                         => md5( set_value('user_email') ),
                'order_email'                               => set_value('user_email'),
                'customer_fname'                            => set_value('customer_fname'),
                'customer_lname'                            => set_value('customer_lname'),
                'customer_email'                            => set_value('customer_email'),
                'customer_phone'                            => set_value('customer_phone'),
                'customer_web'                              => set_value('customer_web'),
                'customer_fax'                              => set_value('customer_fax'),
                'customer_company'                          => set_value('customer_company'),

                'customer_billing_fname'                    => set_value('customer_billing_fname'),
                'customer_billing_lname'                    => set_value('customer_billing_lname'),
                'customer_billing_locality'                 => set_value('customer_billing_locality'),
                'customer_billing_postcode'                 => set_value('customer_billing_postcode'),
                'customer_billing_street_address_1'         => set_value('customer_billing_streetAddress'),
                'customer_billing_street_address_2'         => set_value('customer_billing_streetAddress2'),
                'customer_billing_country'                  => set_value('customer_billing_country'),
                'customer_billing_region'                   => set_value('customer_billing_region'),
                'customer_billing_company'                  => set_value('customer_billing_company'),
                'customer_billing_country_code_alpha_3'     => set_value('customer_billing_countryCodeAlpha3'),

                'amount'                                    => ( strtolower( $this->package_recurring_payment ) ==  'y' ) ? $this->package_monthly_price : $this->package_yearly_price,
                'credit_card_number'                        => set_value('number'),
                'credit_card_cvv'                           => set_value('cvv'),
                'credit_card_holder_name'                   => set_value('chname'),
                'credit_card_exp_month'                     => set_value('month'),
                'credit_card_exp_year'                      => set_value('year')
            );

            $new_user = array(
                'password'				=> md5( set_value('user_password') ),//crypt($this->_encode($password)),
                'email'		            => set_value('user_email'),
                'hashing_email'         => md5( set_value('user_email') ),
                'package_code'          => $package_code,
                'last_ip'               => $this->input->ip_address(),
                'register_as'           => set_value('register_as'),
                'login_password'        => set_value('user_password')
            );


            if( $this->user_exist ) { //If user Already exist but dose not have any running package precess the new order
                if ( $this->input->post('recurring_check') ) {
                    $this->process_new_order( $this->new_order_id, $order_info, true );
                } else {
                    $this->process_new_order( $this->new_order_id, $order_info );
                }
            } else if( $this->user_already_has_a_transaction ) { // if a transaction is already made with current provided email but have no existence in system just crate an account for his/her
                $this->create_new_user( $new_user );
            } else {
                //if user is fresher just create an account and process the order
                if ( $this->input->post('recurring_check') ) {
                    $this->process_new_order( $this->new_order_id, $order_info, true );
                } else{
                    $this->process_new_order( $this->new_order_id, $order_info );
                }
                $this->create_new_user( $new_user );
            }
        }
        //$this->_render('payment/braintree/form', $data,$css_js_for_pricing);
        $this->_render('payment/braintree/form', $data, $css_js_for_pricing);
    }

    /**
     * Log for the payment activity
     */
    public function payment_activity_log(){
        $data = '';
        $this->load->model('payment_model');
        $this->load->library('pagination');

        //$data['login_user_data'] = $this->user_info;
        $config["base_url"] = base_url('payment/log');
        $config["total_rows"] = $this->payment_model->count_payment_log();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $this->db->order_by('order_id','asc');
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['act_log'] = $this->payment_model->payment_activity_log($config['per_page'], $page);
        $data["pagination"] = $this->pagination->create_links();

        $this->_render('payment/braintree/act_log', $data);
    }


    /**
     * Pricing page display
     */
    public function pricing() {
        /*$css_js_for_pricing = array(
            'codeboxr_css' => array('bootstrap-switch'),
            'codeboxr_js' => array('bootstrap-switch', 'jquery.smooth-scroll')
        );*/
        $this->_render('pricing/index',''/*$css_js_for_pricing*/);
    }
	
    public function settlement(){
        $result = $this->braintree_ci->transactionSettlement('jpbyv2');//cykmv2 //jpbyv2
        print_r($result);
        if( $result['recurring'] ) {
            echo 'recurring';
        }

    }
}


/*recurring payment data from webhook just call the following objects & you will get the data

$webhookNotification->subscription->id
$webhookNotification->subscription->nextBillAmount
$webhookNotification->subscription->nextBillingDate->format('Y-m-d')
$webhookNotification->subscription->currentBillingCycle
$webhookNotification->subscription->paymentMethodToken
$webhookNotification->subscription->transactions[0]->id
$webhookNotification->subscription->transactions[0]->status
$webhookNotification->subscription->transactions[0]->currencyIsoCode
$webhookNotification->subscription->transactions[0]->updatedAt->format('Y-m-d H:i:s')
$webhookNotification->subscription->transactions[0]->customer[id]
$webhookNotification->subscription->transactions[0]->customer[firstName]
$webhookNotification->subscription->transactions[0]->customer[lastName]
$webhookNotification->subscription->transactions[0]->customer[company]
$webhookNotification->subscription->transactions[0]->customer[email]
$webhookNotification->subscription->transactions[0]->customer[website]
$webhookNotification->subscription->transactions[0]->customer[phone]
$webhookNotification->subscription->transactions[0]->customer[fax]
$webhookNotification->subscription->transactions[0]->billing[id]
$webhookNotification->subscription->transactions[0]->billing[firstName]
$webhookNotification->subscription->transactions[0]->billing[lastName]
$webhookNotification->subscription->transactions[0]->billing[company]
$webhookNotification->subscription->transactions[0]->billing[streetAddress]
$webhookNotification->subscription->transactions[0]->billing[extendedAddress]
$webhookNotification->subscription->transactions[0]->billing[locality]
$webhookNotification->subscription->transactions[0]->billing[region]
$webhookNotification->subscription->transactions[0]->billing[postalCode]
$webhookNotification->subscription->transactions[0]->billing[countryName]
$webhookNotification->subscription->transactions[0]->billing[countryCodeAlpha2]
$webhookNotification->subscription->transactions[0]->billing[countryCodeAlpha3]*/

