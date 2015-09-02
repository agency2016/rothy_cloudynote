<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/1/13
 * Time: 1:29 PM
 */

class Auth extends MY_Controller {

    private $css_js_array = array(
        'codeboxr_css' => array('template'),
        'codeboxr_js' => array('app')
    );

    public function __construct() {
        parent::__construct($this->css_js_array);
        /*if($this->dx_auth->is_logged_in()) {
            redirect(base_url('dashboard'));
        }*/
    }

    private function message($message, $message_type) {
        $data = array(
            'cl_note_msg' => $message,
            'alert_type' => $message_type
        );
        $this->_render('auth/message', $data);
    }

    public function success() {
        if(!$auth_message = $this->session->flashdata('auth_message')) {
            exit('503 Access Forbidden.');
        }
        $this->message($auth_message, 'success');
    }

    public function error() {
        if(!$auth_message = $this->session->flashdata('auth_message')) {
            exit('503 Access Forbidden.');
        }
        $this->message($auth_message, 'error');
    }

    public function activate()
    {
        if($this->dx_auth->is_logged_in()) {
            redirect(base_url('dashboard'));
        }
        // Get username and key
        if(!$activation_key = $this->uri->segment(2)) {
            exit('503 Access Forbidden');
        }

        // Activate user
        if ($this->dx_auth->activate($activation_key)) {
            $data['auth_message'] = 'Your account have been successfully activated. '.anchor(base_url('login/'), 'Login');
            $this->session->set_flashdata('auth_message', $data['auth_message']);
            redirect(base_url('success/'));
        } else {
            $data['auth_message'] = 'The activation code you entered was incorrect. Please check your email again.';
            $this->session->set_flashdata('auth_message', $data['auth_message']);
            redirect(base_url('error/'));
        }
    }

    public function register() {

        if($this->dx_auth->is_logged_in()) {
            redirect(base_url('dashboard'));
        }

        $css_js_for_auth = array(
            'codeboxr_js' => array('bootstrap-alert')
        );

        $min_username = 4;
        $max_username = 20;
        $min_password = 4;
        $max_password = 20;

        $this->load->library('Form_validation');
        if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
        {
            $val = $this->form_validation;

            // Set form validation rules
            //$val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$min_username.']|max_length['.$max_username.']|callback_username_check|alpha_dash');
            $val->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']');
            $val->set_rules('register_as', 'User Type', 'trim|required|xss_clean|numeric');
            //$val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']|matches[confirm_password]');
            $val->set_rules('user_email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            // Is registration using captcha
            if ($this->dx_auth->captcha_registration)
            {
                // Set recaptcha rules.
                // IMPORTANT: Do not change 'recaptcha_response_field' because it's used by reCAPTCHA API,
                // This is because the limitation of reCAPTCHA, not DX Auth library
                $val->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback_recaptcha_check');
            }

            // Run form validation and register user if it's pass the validation
            if ($val->run() AND ($temp_register_info = $this->dx_auth->register(/*$val->set_value('username')*/'', $val->set_value('user_password'), $val->set_value('user_email'), $val->set_value('register_as'))))
            {
                // Set success message accordingly
                if ($this->dx_auth->email_activation)
                {
                    $data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
                }
                else
                {
                    $data['auth_message'] = 'You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
                }

                // Load registration success page

                $this->session->set_flashdata('auth_message', $data['auth_message']);
                if($temp_register_info['user_access_role_id'] > 3 ) {
                    redirect(base_url('plant-a-tree/'));
                } else {
                    redirect(base_url('success/'));
                }

            }
            else
            {
                // Load registration page
                $data['auth_email_exist_error'] = $this->dx_auth->get_auth_error();
                $this->_render('auth/index', $data, $css_js_for_auth);
            }
        }

    }

    public function login() {
        if ($this->dx_auth->is_logged_in()) {
            redirect(base_url('dashboard'));
        } else {
            if( $this->input->get('email') AND $this->input->get('eauth') ) {
                $hash_email = md5($this->input->get('email'));

                if ( $hash_email == $this->input->get('eauth') ) {

                    $data['user_email_system_received'] = $this->input->get('email');
                }
            }
            $this->load->library('form_validation');
            $css_js_for_auth = array(
                'codeboxr_js' => array('bootstrap-alert')
            );
            $min_password = 4;
            $max_password = 20;
            $val = $this->form_validation;

            // Set form validation rules


            $val->set_rules('user_login_password', 'Password', 'trim|required|min_length['.$min_password.']|max_length['.$max_password.']');
            //$val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']|matches[confirm_password]');
            $val->set_rules('user_login_email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            // Set captcha rules if login attempts exceed max attempts in config
            if ($this->dx_auth->is_max_login_attempts_exceeded())
            {
                $val->set_rules('captcha', 'Confirmation Code', 'trim|required|xss_clean|callback_captcha_check');
            }

            if ($val->run() AND $this->dx_auth->login($val->set_value('user_login_email'), $val->set_value('user_login_password'), $val->set_value('remember_me')))
            {
                if ( $this->input->get( 'return_url' ) ){
                    $decode_url = base64_decode( $this->input->get( 'return_url' ) );
                    redirect( $decode_url );
                }
                // Redirect to homepage
                redirect(base_url('dashboard/'));
            }
            else
            {
                // Check if the user is failed logged in because user is banned user or not
                if ($this->dx_auth->is_banned()) {
                    // Redirect to banned uri
                    //$this->dx_auth->deny_access('banned');
                    $data['banned'] = 'Sorry! your banned for this site.';
                } else {
                    // Default is we don't show captcha until max login attempts eceeded
                    //$data['show_captcha'] = FALSE;

                    // Show captcha if login attempts exceed max attempts in config


                    $data['auth_error'] = $this->dx_auth->get_auth_error();

                    // Load login page view
                }
                $this->_render('auth/index', $data);
            }
        }
    }

    public function logout() {
        if($this->dx_auth->is_logged_in()) {
            $this->dx_auth->logout();
            redirect(base_url());
        } else {
            redirect(base_url('login/'));
        }
    }

    public function forgot_password() {

        $this->load->library('Form_validation');
        $val = $this->form_validation;

        // Set form validation rules
        $val->set_rules('user_forgot_email', 'Email Address', 'trim|required|xss_clean|valid_email');

        // Validate rules and call forgot password function
        $data = array();
        if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('user_forgot_email'))) {
            $data['forgot_mail_send_success'] = 'An email has been sent to your email with instructions with how to activate your new password.';
        } else {
            $data['auth_forgot_pass_error'] = $this->dx_auth->get_auth_error();
        }



        $this->_render('auth/index', $data);
    }

    public function change_password() {

    }
    //assign_organisation_id
    public function accept_invite_user($organisation_id, $section_id, $invited_hashed_email) {
        if(!$this->dx_auth->is_logged_in()) {
            redirect(base_url('login/'));
        } else {
            $this->load->model(array('section_model', 'user_model'));
            if(!$this->user_model->has_this_organisation($organisation_id) or !$this->section_model->has_section($section_id, $organisation_id) or ($this->session->userdata('CN_user_email_hash') != $invited_hashed_email)) {
                show_404();
            } else {
                if(!$this->section_model->accept_request_is_valid($organisation_id, $section_id, $invited_hashed_email)) {
                    show_error('wrong code submission');
                } else {
                    if($this->user_model->enable_authorised_access_for_current_user($organisation_id, $section_id, $invited_hashed_email)) {
                        redirect(base_url('user'));
                    } else {
                        show_error('wrong code submission');
                    }
                }
            }
        }
    }
} 