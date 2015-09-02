<?php
/**
 * Created by PhpStorm.
 * User: MANCHU
 * Date: 3/3/14
 * Time: 12:19 PM
 */

class Activity_log extends MY_Controller {

    private $unauthorised_access_prevent_for_admin      = true;
    private $unauthorised_access_prevent_for_institute  = true;
    private $unauthorised_access_prevent_for_auth_user  = true;
    private $unauthorised_access_prevent_for_caregiver  = true;
    private $css_js_array                               = array(
        'codeboxr_css'                      => array('super-admin', 'bootstrap-table-responsive.min'),
        'codeboxr_js'                       => array('bootstrap-alert'/*, 'bootstrap-dropdown'*/)
    );

    public function __construct() {
        parent::__construct($this->css_js_array);
        $this->load->model('super_admin');
        if( !$this->dx_auth->is_logged_in() ) {
            redirect(base_url());
        }

        $this->load->model( 'activity_model' );
        $this->load->helper( 'function' );
        $this->user_info = $this->super_admin->get_user_info($this->session->userdata('DX_user_id'))->row();
    }

    public function index() {
        //print_r($this->user_info);exit;
        if( $this->dx_auth->is_admin() ) {
            //print_r($this->user_info);exit;
            $this->unauthorised_access_prevent_for_admin = false;
            $this->activity_log_for_super_admin();
        } else if( $this->user_info->user_access_level == 3 or $this->activity_model->has_admin_access($this->user_info->organisation_id, $this->user_info->id) ) {
            $this->unauthorised_access_prevent_for_institute = false;
            $this->activity_log_for_institute();
        } else if( $this->user_info->user_access_level == 4 ) {
            $this->unauthorised_access_prevent_for_auth_user = false;
            $this->activity_log_for_auth_user();
        } else {
            $this->unauthorised_access_prevent_for_caregiver = false;
            $this->activity_log_for_caregiver_or_parents();
        }

    }


    public function activity_log_for_super_admin() {
        if( $this->unauthorised_access_prevent_for_admin ) {
            show_404();
        }
        //exit('admin activity');

        $data = array();
        if( !$result = $this->activity_model->get_all_activities() ) {
            //$data['']
        } else {

        }
        //$this->_render_admin( '' )
    }

    public function activity_log_for_institute() {
        if( $this->unauthorised_access_prevent_for_institute ) {
            show_404();
        }
        //exit('school activity');
    }

    public function activity_log_for_auth_user() {
        if( $this->unauthorised_access_prevent_for_auth_user ) {
            show_404();
        }
        //exit('auth user activity');
    }

    public function activity_log_for_caregiver_or_parents() {
        if( $this->unauthorised_access_prevent_for_caregiver ) {
            show_404();
        }
        //exit('caregiver activity');
    }





} 