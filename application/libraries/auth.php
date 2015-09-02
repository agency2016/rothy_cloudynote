<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/5/13
 * Time: 12:02 PM
 */

class Auth {
    private $session;

    public function __construct() {
        $CI =& get_instance();
        $this->session = $CI->session;
        $this->load->model('auth_user_model', 'auth_model');
    }

    public function is_logged_in() {
        if($this->session->userdata('user_id') and $this->session->userdata('user_email')) {
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        if($this->session->sess_destroy()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_user_availability($email) {
        return $this->auth_model->check_user_availability($email);
    }

    public function register($email, $password, $user_type) {

        $availability_info = $this->check_user_availability($email);
        if($$availability_info['type'] == true) {
            $register_data = array(
                'temp_user_id'              => '',
                'temp_user_email'           => $email,
                'temp_user_password'        => md5($password),
                'temp_user_type'            => $user_type,
                'temp_user_validation_key'  => md5(rand().microtime().$email)
            );
            return $this->auth_model->register($register_data);
        } else {
            return $availability_info;
        }
    }
} 