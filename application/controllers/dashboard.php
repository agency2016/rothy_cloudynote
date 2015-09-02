<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/2/13
 * Time: 4:16 PM
 */

class Dashboard extends MY_Controller {
    private $css_js_array = array(
        'codeboxr_css'                      => array('super-admin', 'bootstrap-table-responsive.min'),
        'codeboxr_js'                       => array('bootstrap-alert'/*, 'bootstrap-dropdown'*/)
    );

    public function __construct() {
        parent::__construct($this->css_js_array);
        $this->load->model('super_admin');
        if( !$this->dx_auth->is_logged_in() ) {
            redirect(base_url());
        } else {
            if( !$this->dx_auth->is_admin() ) {
                redirect( base_url( 'user/' ) );
            }
        }
        $this->load->helper('function');
        $this->user_info = $this->super_admin->get_user_info($this->session->userdata('DX_user_id'))->row();

    }

    public function index() {
        ($this->uri->segment(4)) ? $page_num = $this->uri->segment(4): $page_num = 0;
        $this->load->library('pagination');

        $user_list = $this->super_admin->get_all_user_list($limit = 3, $page_num);//$offset= ($limit*($page_num-1))

        $data['user_list']                  = array();
        $data['login_user_data']            = $this->user_info;
        $data['user_no_found']              = $this->session->flashdata('user_no_found');
        $data['update_profile_success']     = $this->session->flashdata('update_profile_success');
        $data['remove_user_error']          = $this->session->flashdata('remove_user_error');
        $data['remove_user_success']        = $this->session->flashdata('remove_user_success');

        if($user_list->num_rows() > 0) {
            $data['user_list']              = $user_list->result();
        }

        $config['base_url']                 = base_url('dashboard/user/page');
        $config['total_rows']               = $this->super_admin->get_total_rows_of_table('users');
        //print_r($config);exit;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();


        /*statistics*/
        $css_js_for_notes  = array(
            'codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js'  => array('jquery.dataTables.min')
        );
        $data['note_list'] = array();

        //$this->load->library('pagination');
        $this->load->model('note_model');
        //($this->uri->segment(3)) ? $page_num = $this->uri->segment(3) : $page_num = 0;

        //$config['base_url']    = base_url('notes/page');
        //$config['uri_segment'] = 3;
        if ($this->dx_auth->is_admin()) {
            //$config['total_rows'] = $this->note_model->get_total_rows_of_notes('notes', true);
            $note_list            = $this->note_model->get_all_note_list($limit = 10, $page_num);
            if ($note_list->num_rows() > 0) {
                $data['note_list'] = $note_list->result();
            }
            $financial_stat = $this->note_model->get_financial_stat($limit = 10, $page_num);
            if ($financial_stat->num_rows() > 0){
                $data['financial_stat'] = $financial_stat->result();
            }
        } else {
            if ($this->user_info->user_access_level > 3) {

                $note_list = $this->note_model->get_all_note_list_by_assigned_id();

                if ( $note_list != false and $note_list->num_rows() > 0) {
                    //$config['total_rows'] = $note_list->num_rows();
                    $note_list = $note_list->result();
                } else {
                    $note_list = false;
                }
                //unset($note_list['total_rows']);
            } else {
                $org_id = $this->session->userdata('CN_user_organisation_id');
                $financial_stat = $this->note_model->get_financial_stat($org_id, $limit = 10, $page_num);
                if ($financial_stat->num_rows() > 0){
                    $data['financial_stat'] = $financial_stat->result();
                }
                //$config['total_rows']           = $this->note_model->get_total_rows_of_notes('notes');
                $note_list            = $this->note_model->get_all_note_list_by_organisation_id($limit = 10, $page_num);

                // echo "<pre>";print_r($note_list);exit;
                //$this->debug($note_list); exit();
                if ( $note_list != false and $note_list->num_rows() > 0) {
                    //$config['total_rows'] = $note_list->num_rows();
                    $note_list = $note_list->result();
                } else {
                    $note_list = 0;
                }
            }
            //if ($note_list != false) {
            $data['note_list'] = $note_list;
            //}
        }
        $data['login_user_data'] = $this->user_info;
        //$this->pagination->initialize($config);
        //$data['pagination'] = $this->pagination->create_links();

        $this->_render_admin('dashboard/index', $data, $css_js_for_notes);
    }

    /**
     * Get the activity log for super admin
     */
    public function activity_log(){
        ($this->uri->segment(3)) ? $page_num = $this->uri->segment(3): $page_num = 0;
        $this->load->library('pagination');
        $this->load->model('activity_model');

        $data['login_user_data'] = $this->user_info;

        $data['log'] = $this->activity_model->get_all_activities($limit = 3, $page_num);

        $config['base_url']                 = base_url('dashboard/activity');
        $config['total_rows']               = $this->activity_model->get_total_rows('activity_log');

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->_render_admin('dashboard/activity_log', $data);
    }

    public function vew_user_info($user_id) {
        if($user_data = $this->super_admin->get_user_info($user_id) and ($user_data->num_rows() == 0)) {
            $this->session->set_flashdata('user_no_found', 'We could not found any user with this <strong>'.$user_id.'</strong> ID.');
            redirect(base_url('dashboard/'));
        }

        $data['login_user_data']            = $this->user_info;
        $data['user_data']                  = $user_data->row();

        $this->_render_admin('dashboard/view_user_profile', $data);
    }

    public function edit_user_profile($user_id) {
        //echo $user_id;exit;
        if($user_data = $this->super_admin->get_user_info($user_id) and ($user_data->num_rows() == 0)) {
            $this->session->set_flashdata('user_no_found', 'We could not found any user with this <strong>'.$user_id.'</strong> ID.');
            redirect(base_url('dashboard/'));
        }

        $data['login_user_data']            = $this->user_info;
        $data['user_id']                    = $user_id;
        $data['user_data']                  = $user_data->row();

        $this->load->library('form_validation', '', 'frm_val');
        $this->frm_val->set_rules('org_name', 'Organisation Name', 'trim|xss_clean');
        $this->frm_val->set_rules('fname', 'First Name', 'trim|xss_clean|alpha');
        $this->frm_val->set_rules('lname', 'Last Name', 'trim|xss_clean|alpha');
        $this->frm_val->set_rules('password', 'Password', 'xss_clean|alpha_numeric|matches[con_password]');
        $this->frm_val->set_rules('con_password', 'Confirm Password', 'xss_clean|alpha_numeric');

        if ($this->frm_val->run() == false) {
        } else {
            if($this->super_admin->update_user_info($user_id, set_value('fname'), set_value('lname'), set_value('password'))) {
                $this->session->set_flashdata('update_profile_success', 'Profile changes successfully.');
                redirect(base_url('dashboard/user/'));
            } else {
                $this->session->set_flashdata('update_profile_error', '<strong>Ops! </strong>Something went wrong. Please try again.');
                redirect(base_url('dashboard/user/edit/'.$user_id));
            }
        }
        $data['update_profile_error']       = $this->session->flashdata('update_profile_error');
        $this->_render_admin('dashboard/edit_user_profile', $data);
    }

    public function remove_user($user_id) {
        $data['login_user_data']            = $this->user_info;
        if($user_data = $this->super_admin->get_user_info($user_id) and ($user_data->num_rows() == 0)) {
            $this->session->set_flashdata('user_no_found', 'We could not found any user with this <strong>'.$user_id.'</strong> ID.');
            redirect(base_url('dashboard/'));
        } else {
            if($this->super_admin->remove_user_info($user_id)) {
                $this->session->set_flashdata('remove_user_success', 'Account removed successfully.');
                redirect(base_url('dashboard/user/'));
            } else {
                $this->session->set_flashdata('remove_user_error', '<strong>Ops! </strong>Something went wrong. Please try again.');
                redirect(base_url('dashboard/user/'));
            }
        }
    }

    /**
     * General email template for the notification to anyone
     *
     * general_email_template_view();
     * @param array $to
     * @param $from
     * @param $subject
     * @param array $message
     * @param null $note
     * @param null $student_id
     */
    public function general_email_template_view($to, $from, $subject, array $message, $note_id = NULL, $student_id = NULL){
        $this->load->library('email');
        $this->load->model('user_model', 'note_model');
        $this->email->to($to);
        $this->email->from($from);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function settings (){
        $this->load->model('super_admin');
        if( !$this->dx_auth->is_logged_in() ) {
            redirect(base_url());
        } else {
            if( !$this->dx_auth->is_admin() ) {
                redirect( base_url( 'user/settings' ) );
            }
            redirect( base_url( 'admin/settings' ) );
        }
    }
} 