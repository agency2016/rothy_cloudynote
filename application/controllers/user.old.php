<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 3:16 PM
 */

class User extends MY_Controller {

    public $ci_data =array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * The common section of register and login.
     * Can't access from outside of Class
     * @param $user_id
     * @param $user_email
     */
    private function do_login($user_id, $user_email) {
        $this->session->set_userdata('user_id', $user_id);
        $this->session->set_userdata('user_email', $user_email);
        redirect(base_url('blog/'));
    }

    /**
     * Automatically load login panel
     */
    public function index() {
        $this->login();
    }

    /**
     * For user registration
     */
    public function register() {
        //Check is user already logged in or not
        if($this->auth->is_logged_in()) {
            redirect(base_url('blog/'));
        }

        //Load Form Validation
        $this->load->library('form_validation');

        //Set Validation Rules.
        $this->form_validation->set_rules('user_name', 'Username ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email ', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password ', 'trim|required|min_length[6]|max_length[12]');

        if($this->form_validation->run() === false) {

        } else {
            //get username
            $user_name = $this->input->post('user_name');
            //get email
            $email = $this->input->post('email');
            //get password
            $password = $this->input->post('password');
            //retype password for confirmation
            $con_password = $this->input->post('con_password');

            if($password == $con_password) {
                //Load User Model To Register User.
                $this->load->model('user_model');

                //Check the database is the provided data already exist or not
                $availability_info = $this->user_model->check_user_availability($user_name, $email);

                //if the data has error type the show the error message
                if($availability_info['type'] == 'error') {
                    $this->ci_data['user_name_exist'] = $availability_info['have_user_name'];
                    $this->ci_data['email_exist'] = $availability_info['have_email'];
                } else {
                    //No error found. so register and login the user :).
                    if($user_info = $this->user_model->register_user_information($user_name, $email, $password)) {
                        $this->do_login($user_info['_id']->{'$id'},$user_info['email']);
                    }
                }

            } else {
                $this->ci_data['pass_not_match'] = 'Password did not match.';
            }
        }
        $this->load->view('user/register_view', $this->ci_data);
    }

    /**
     * For user login
     */
    public function login() {
        //Check is user already logged in or not
        if($this->auth->is_logged_in()) {
            redirect(base_url('blog/'));
        }

        //Load Form Validation
        $this->load->library('form_validation');

        //Set Validation Rules.
        $this->form_validation->set_rules('user_name', 'Username ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password ', 'trim|required|min_length[6]|max_length[12]|xss_clean');

        if($this->form_validation->run() === false) {
        } else {
            //Load User Model
            $this->load->model('user_model');
            //get username
            $user_name = $this->input->post('user_name');
            //get password
            $password = $this->input->post('password');
            //verify user provided data in our database
            if($user_profile = $this->user_model->check_user_information($user_name, $password)) {
                //doing login the user
                $this->do_login($user_profile['_id']->{'$id'}, $user_name['email']);
            } else {
                $this->ci_data['invalid_login'] = "Invalid user information. Please provide right information.";
            }
        }
        //load login panel
        $this->_render('user/login_view', $this->ci_data);
    }

    public function logout() {
        //Check is user already logged in or not
        if($this->auth->is_logged_in()) {
            $this->auth->logout();
        }

        redirect(base_url('user/login'));
    }
} 