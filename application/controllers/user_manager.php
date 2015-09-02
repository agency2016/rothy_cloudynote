<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/28/13
 * Time: 12:54 PM
 */

class User_manager extends MY_Controller {
    private $user_info = '';
    private $css_js_array = array('codeboxr_css' => array('super-admin'), 'codeboxr_js' => array('bootstrap-alert' /*, 'bootstrap-dropdown'*/));

    public function __construct() {
        parent::__construct($this->css_js_array);

        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }
        //var_dump($this->session);exit;

        $this->load->model(array('note_model', 'user_model', 'super_admin'));
        $this->load->helper('function');
        //print_r($this->super_admin->get_user_info($this->session->userdata('DX_user_id'))->result());exit;

        //Ater login somehow removed the user data from database
        //then protect site from showing error
        if ($user_info = $this->super_admin->get_user_info($this->session->userdata('DX_user_id'))) {
            $this->user_info = $user_info->row();
        } else {
            $this->session->sess_destroy();
            show_error('A critical error was found in system. Please try to login again.');
        }
    }

    public function index() {

        $css_js_for_notes = array(
            'codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js' => array('jquery.dataTables.min'));
        //print_r($this->user_info);exit;
        //print_r($this->session);exit;
        if (2 < $this->user_info->user_access_level && $this->user_info->user_access_level < 5) {
            if (!has_organisation()) {
                redirect(base_url('user/setup_profile'));
            }
        }

        /*$data['login_user_data']    = $this->user_info;
        $data['add_section_waring'] = $this->session->flashdata('add_section_waring');

        ($this->uri->segment(4)) ? $page_num = $this->uri->segment(4) : $page_num = 0;

        $config['base_url'] = base_url('notes/page');
        if ($this->dx_auth->is_admin()) {
            $config['total_rows'] = $this->note_model->get_total_rows_of_notes('notes', true);
            $note_list            = $this->note_model->get_all_note_list($limit = 3, $page_num);
        } else {
            $config['total_rows'] = $this->note_model->get_total_rows_of_notes('notes');
            $note_list            = $this->note_model->get_all_note_list_by_organisation_id($limit = 3, $page_num);
        }

        $this->load->library('pagination');

        $data['note_list'] = array();

//        if ($note_list->num_rows() > 0) {
         //   $data['note_list'] = $note_list->result();
       // }

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();*/

        //echo $data['add_section_waring']; exit;

        if ($this->user_info->user_access_level < 4) {
            redirect(base_url('notes'));
        } else if ($this->user_info->user_access_level == 5) {
            redirect(base_url('user/parent'));
        } else {
            redirect(base_url('notes'));
            // $this->_render_admin('note/index', $data, $css_js_for_notes);
        }
    }

    public function profile() {
        $data['login_user_data'] = $this->user_info;
        $this->_render_admin('user/view_profile', $data);
    }

    public function edit_profile() {

        $data['login_user_data'] = $this->user_info;

        $this->load->model(array('localization'));
        $data['country_list'] = $this->localization->get_all_country_list();
        $data['state_list'] = $this->localization->get_all_state_list();

        //print_r($data['state_list']);exit;

        $this->load->library('form_validation', '', 'frm_val');
        if ($this->user_info->user_access_level <= '3') {
            $this->frm_val->set_rules('org_name', 'Organisation Name', 'trim|required|xss_clean|strip_tags');
        }
        $this->frm_val->set_rules('fname', 'First Name', 'trim|required|xss_clean|strip_tags');
        $this->frm_val->set_rules('lname', 'Last Name', 'trim|xss_clean|strip_tags');
        $this->frm_val->set_rules('password', 'Password', 'xss_clean|alpha_numeric|matches[con_password]');
        $this->frm_val->set_rules('con_password', 'Confirm Password', 'xss_clean|alpha_numeric');

        $data['update_profile_success'] = $this->session->flashdata('update_profile_success');
        $data['update_profile_error'] = $this->session->flashdata('update_profile_error');

        if ($this->frm_val->run() == false) {
        } else {
            $org_name = '';
            if ($this->user_info->user_access_level <= '3') {
                $org_name = set_value('org_name');
            }
            if ($this->super_admin->update_user_info($this->user_info->id, set_value('fname'), set_value('lname'), set_value('password'), $org_name)) {
                if ($this->user_info->user_access_level <= '3') {
                    $this->session->set_userdata('CN_org_name', set_value('org_name'));
                }
                $this->session->set_userdata('CN_first_name', set_value('fname'));
                $this->session->set_flashdata('update_profile_success', 'Profile changes successfully.');
            } else {
                $this->session->set_flashdata('update_profile_error', '<strong>Ops! </strong>Something went wrong. Please try again.');
            }
            redirect(base_url('user/edit-profile'));
        }
        $this->_render_admin('user/edit_profile', $data);
    }

    public function invite_user() {

        $css_js_for_invite_user = array('codeboxr_js' => array('underscore-min', 'bootstrap-tab', 'bootstrap-filestyle.min', 'bootstrap.wizard.min', 'section-member'));
        //If the top level user has not set org name
        //they will redirect to profile editing page.
        if (!has_organisation()) {
            redirect(base_url('user/edit-profile'));
        }

        if ($this->user_info->user_access_level > 3) {
            redirect(base_url('notes'));
        }

        //Get all class list from logged in user.
        $section_list = $this->user_model->get_all_section_list();
        //check if there any class created or not.
        //if not redirect to home url.
        if ($section_list->num_rows() < 1) {
            $this->session->set_flashdata('add_section_waring', 'Add class before invite teacher.');
            redirect(base_url('user'));
        }

        $data['login_user_data'] = $this->user_info;
        $data['section_list'] = $section_list->result();

        //collect info from session
        $data['invite_section_id'] = $this->session->flashdata('invite_section_id');
        $data['send_invitation_success'] = $this->session->flashdata('send_invitation_success');
        $data['send_invitation_error'] = $this->session->flashdata('send_invitation_error');

        $this->load->library('form_validation', '', 'frm_val');

        $this->frm_val->set_rules('invite_email', 'Email of Teacher', 'trim|xss_clean|required|valid_email');
        $this->frm_val->set_rules('invite_first_name', 'First Name of Teacher', 'trim|required|xss_clean');
        $this->frm_val->set_rules('invite_last_name', 'Last Name of Teacher', 'trim|xss_clean');
        $this->frm_val->set_rules('invite_section_id', 'Class', 'trim|xss_clean|required');

        if ($this->frm_val->run() == false) {
        } else {
            $this->load->model('section_model');
            if (!$this->section_model->has_section(set_value('invite_section_id'))) {
                $this->session->set_flashdata('invite_section_id', '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sorry </strong>we have not found the class that you have selected. Please select right one.</div>');
                redirect(base_url('user/' . $this->uri->segment(2)));
            } elseif ($this->section_model->is_already_assigned(set_value('invite_email'), set_value('invite_section_id'))) {
                $this->session->set_flashdata('invite_section_id', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' . set_value('invite_email') . ' </strong>this email already assigned to that class, that you have selected.</div>');
                redirect(base_url('user/' . $this->uri->segment(2)));
            } else {
                $time = time();
                $section_assign_info = array('assign_id' => md5($time . set_value('invite_email') . $this->user_info->id), 'assign_organisation_id' => $this->user_info->id, 'assign_access_id' => md5(set_value('invite_email')), 'assign_section_id' => set_value('invite_section_id'), 'assign_group_id' => '', 'assign_time' => $time);
                if ($result = $this->section_model->assign_section($section_assign_info)) {
                    $this->load->library('email');
                    if ($assigned_user_info = $this->user_model->has_in_user(set_value('invite_email'))) {
                        $data['in_temp'] = false;
                        $data['auto_register'] = false;
                        $data['recipient_first_name'] = $assigned_user_info->first_name;
                    } elseif ($user_info = $this->user_model->has_in_temp_user(set_value('invite_email'))) {
                        $this->dx_auth->activate($user_info->activation_key);
                        $data['in_temp'] = true;
                        $data['auto_register'] = false;
                        $data['recipient_first_name'] = set_value('invite_first_name');
                    } else {
                        $this->config->set_item('DX_email_activation', false);
                        $pass = generateStrongPassword();
                        $invite_name_of_user = array('fname' => set_value('invite_first_name'), 'lname' => set_value('invite_last_name'));
                        $this->dx_auth->register('', $pass, set_value('invite_email'), $register_as = '5', $invite_name_of_user);
                        $data['in_temp'] = false;
                        $data['auto_register'] = true;
                        $data['recipient_first_name'] = set_value('invite_first_name');
                    }

                    $data['organisation_id'] = $this->user_info->id;
                    $data['assign_section_id'] = $section_assign_info['assign_section_id'];
                    $data['assign_access_id'] = $section_assign_info['assign_access_id'];
                    $data['password'] = $pass;

                    //get the content of email body
                    $invitation_content = $this->view('page/email/invitation', $data, true);
                    //email to assigned user
                    $this->email->from('no-reply@cloudenotes.com');
                    $this->email->to(set_value('invite_email'));
                    $this->email->subject('Invitation to ' . $this->session->userdata('CN_org_name'));
                    $this->email->message($invitation_content);

                    if ($this->email->send()) {
                        $this->session->set_flashdata('send_invitation_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Invitation send to ' . set_value('invite_email') . ' successfully.</div>');
                    } else {
                        $this->section_model->remove_assigned_info($result->insert_id());
                        $this->session->set_flashdata('send_invitation_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Critical error on sending invitation. Please <a href="' . base_url('contact-us') . '">contact</a> or provide <a href="' . base_url('feedback') . '">feedback</a> to CloudeNotes Owner.</div>');
                    }
                    redirect(base_url('user/' . $this->uri->segment(2)));
                } else {
                    $this->session->set_flashdata('send_invitation_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Something went wrong. Please try again.</div>');
                }
                redirect(base_url('user/' . $this->uri->segment(2)));
            }
        }
        $this->_render_admin('auth_user/invite_user', $data, $css_js_for_invite_user);
    }

    public function assigned_user_list() {
        $css_js_for_school_admin_staff_list = array(
            'codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables', 'bootstrap-wysihtml5', 'wysiwyg-color'),
            'codeboxr_js' => array('jquery.dataTables.min', 'wysihtml5-0.3.0', 'bootstrap-wysihtml5'));

        if (!has_organisation() && $this->user_info->user_access_level != '1') {
            redirect(base_url('user/edit-profile'));
        }
        if ($this->user_info->user_access_level != '3' && $this->user_info->user_access_level != '1') {
            redirect(base_url('user'));
        }

        $this->load->library('pagination');
        $this->load->model('section_model');
        $this->load->model('section_member_model');
        $data['login_user_data'] = $this->user_info;

        $limit = $this->section_model->common_for_section_and_assigned_user_list($this->user_info->organisation_id)->num_rows();
        //$this->debug($limit); exit();

        $config["base_url"] = base_url('user/teacher-list');
        $config["total_rows"] = $limit;
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

        $data['assigned_user_list'] = $this->section_model->get_all_assign_user_list_by_organisation_id($this->user_info->organisation_id, $config["per_page"], $page);
        $data['classList'] = $this->section_member_model->get_all_section_list_in_org($this->user_info->organisation_id);

        $data['classList'] = json_encode($data['classList']);
        $data["pagination"] = $this->pagination->create_links();
        //$this->_render_admin('auth_user/index', $data);
        $this->_render_admin('auth_user/index', $data, $css_js_for_school_admin_staff_list);
    }

    /**
     * view all the classes & assigned teachers
     * along with the total # of students & joined, unregistered
     */
    public function sections() {
        $css_js_for_school_admin_class_list = array('codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'), 'codeboxr_js' => array('jquery.dataTables.min'));

        $data['login_user_data'] = $this->user_info;
        $this->load->model('section_model');
        $this->load->library('pagination');

        if ($this->user_info->user_access_level > 3) {
            $section_list = $this->section_model->get_all_assign_section_list_by_assigned_user_id();
        } elseif ($this->user_info->user_access_level == 3) {
            $limit = $this->section_model->common_for_section_member_and_assigned_user_list($this->session->userdata('DX_user_id')); //->num_rows();

            $config["base_url"] = base_url('user/classes');
            $config["total_rows"] = $limit['row'];
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;

            //exit('ssdjdsf');

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $section_list = $this->section_model->common_for_section_member_and_assigned_user_list($this->session->userdata('DX_user_id'), $config["per_page"], $page);
            $section_list = $section_list['result'];
            //$this->debug($section_list); exit();
        } else {
            $section_list = $this->section_model->get_all_assign_section_list_by_organisation_id($this->session->userdata(''));
        }
        //var_dump($section_list);exit;
        $data['section_list'] = $section_list;
        $data["pagination"] = $this->pagination->create_links();
        $this->_render_admin('sections/index', $data, $css_js_for_school_admin_class_list);
    }

    public function add_sections() {
        //If the top level user has not set org name
        //they will redirect to profile editing page.

        if (!has_organisation()) {
            redirect(base_url('user/edit-profile'));
        }

        if ($this->user_info->user_access_level > 3) {
            redirect(base_url('notes'));
        }

        $data['login_user_data'] = $this->user_info;

        $this->load->library('form_validation', '', 'frm_val');

        $this->frm_val->set_rules('new_section', 'Class Name', 'trim|required|xss_clean|strip_tags|callback_is_section_exist');
        $this->frm_val->set_rules('invite_user_id', 'Teacher Name', 'trim|xss_clean');

        $data['add_class_success'] = $this->session->flashdata('add_class_success');
        $data['add_class_error'] = $this->session->flashdata('add_class_error');

        if ($this->frm_val->run() == false) {
        } else {
            $creation_info = array('section_id' => unique_id_generator(), 'section_hash_organisation_id' => md5($this->user_info->id), 'section_name' => set_value('new_section'));

            $assign_info = array();

            if (($accessible_user_info = $this->super_admin->get_user_info(set_value('invite_user_id'))) and ($accessible_user_info->num_rows() == '1')) {
                $assign_info = array('assign_id' => unique_id_generator(), 'assign_access_id' => $accessible_user_info->row()->hashing_email,);
                //print_r($accessible_user_info);exit;
            }
            $this->load->model('section_model');

            if ($this->section_model->create_section_and_assign_to($creation_info, $assign_info)) {
                $this->session->set_flashdata('add_class_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Class added successfully.</div>');
            } else {
                $this->session->set_flashdata('add_class_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
            }
            redirect(base_url('user/' . $this->uri->segment('2')));
        }

        $this->_render_admin('sections/add_sections', $data);
    }

    /**
     * Student adding controller
     */
    public function add_section_member() {
        $css_js_array = array('codeboxr_js' => array('underscore-min', 'bootstrap-tab', 'bootstrap-filestyle.min', 'bootstrap.wizard.min', 'section-member'));

        $data['login_user_data'] = $this->user_info;

        $this->load->model(array('user_model', 'section_model', 'localization'));
        $this->load->library('form_validation', '', 'frm_val');

        $data['country_list'] = $this->localization->get_all_country_list();
        $data['state_list'] = $this->localization->get_all_state_list();

        //echo($data['state_list']);exit;

        //Get all section list from logged in user.
        $section_list = $this->user_model->get_all_section_list();

        //check if there any class created or not.
        //if not redirect to home url.
        if ($section_list->num_rows() < 1) {
            $this->session->set_flashdata('add_student_waring', 'Add class before adding a member.');
            redirect(base_url('user'));
        }

        $data['section_list'] = $section_list->result();

        //Switch on That Tab Where User Come From
        $data['tab_import_active'] = true;
        $data['tab_single_active'] = false;


        //load section_member_model
        $this->load->model(array('payment_model', 'section_member_model'));
        //get package code from session of users
        $pkg_code = $this->session->userdata('CN_user_package_code');
        //how much members exist under users organisation
        $current_total_section_members = $this->section_member_model->count_all_section_member_by_organisation_id($this->user_info->organisation_id);
        //maximum allowed section numbers of users organisation.
        $max_allowed = $this->payment_model->get_max_allowed_members($pkg_code);

        $allowed_to_add_members = true;
        if ($current_total_section_members > $max_allowed) {
            $allowed_to_add_members = false;
            $data['allowed_number_exceed'] = '<div class="alert"><strong>Warning! </strong>You are exceed your limitation for more adding members.</div>';
        }


        if ($this->input->post('import_students')) {

            if ($allowed_to_add_members) {
                $this->frm_val->set_value('section_id', '', 'required');


                if ($this->section_model->has_section($this->input->post('section_id', true), $this->user_info->organisation_id)) {

                    $config['upload_path'] = './upload';
                    $config['allowed_types'] = 'csv';
                    $config['overwrite'] = true;
                    $config['file_name'] = md5(time() . $this->session->userdata('CN_user_email_hash'));
                    $this->load->library('upload', $config);

                    //print_r($this->upload);exit;
                    //$this->debug($this->input->post('section_id'));
                    if ($this->upload->do_upload('members')) {
                        //get uploaded file info.
                        $file_info = $this->upload->data();

                        //echo 'eikhane dorkar '; $this->debug(set_value('section_id')); exit();
                        //try to batch operation for uploaded section member info.
                        if ($this->section_member_model->create_section_member_info_from_file($file_info, $this->input->post('section_id'), $this->user_info->organisation_id)) {
                            $data['add_member_success'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Member added successfully.</div>'; //$this->session->flashdata('add_member_success');$this->session->set_flashdata('add_member_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Member added successfully.</div>');
                        } else {
                            $data['add_member_error'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>'; //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
                        }

                        @unlink($file_info['full_path']);
                    } else {
                        //$data['add_member_error'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>'.$this->upload->display_error().'</div>';//$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
                    }
                } else {
                    $data['add_member_error'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Class not specified.</div>'; //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
                }
            }
        } else {
            $data['tab_import_active'] = false;
            $data['tab_single_active'] = true;

            //Students OR Section Members Info
            //Members Validation Rule
            $this->frm_val->set_rules('section_member_first_name', 'Student First Name', 'trim|required|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_last_name', 'Student Last Name', 'trim|required|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_section_id', 'Student Class Name', 'trim|required|xss_clean|strip_tags|alpha_numeric');

            //Members Fathers Info
            //Members Fathers Validation Rule
            $this->frm_val->set_rules('section_member_fathers_first_name', 'Father\'s First Name', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_fathers_last_name', 'Father\'s Last Name', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_fathers_email', 'Father\'s Email', 'trim|xss_clean|strip_tags|valid_email');
            $this->frm_val->set_rules('section_member_fathers_phone_work', 'Father\'s Phone(work)', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_fathers_phone_home', 'Father\'s Phone(home)', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_fathers_mobile', 'Father\'s Mobile', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_fathers_first_line_address', 'Father\'s First Address Line', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_fathers_second_line_address', 'Father\'s Second Address Line', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_fathers_zip_code', 'Father\'s ZIP Code', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_fathers_city_name', 'Father\'s City', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_fathers_country_id', 'Father\'s Country', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_fathers_state_id', 'Father\'s State', 'trim|xss_clean|strip_tags|alpha');

            //Members Mothers Info
            //Members Mothers Validation Rule
            $this->frm_val->set_rules('section_member_mothers_first_name', 'Mother\'s First Name', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_mothers_last_name', 'Mother\'s Last Name', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_mothers_email', 'Mother\'s Email', 'trim|xss_clean|strip_tags|valid_email');
            $this->frm_val->set_rules('section_member_mothers_phone_work', 'Mother\'s Phone(work)', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_mothers_phone_home', 'Mother\'s Phone(home)', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_mothers_mobile', 'Mother\'s Mobile', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_mothers_first_line_address', 'Mother\'s  First Address Line', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_mothers_second_line_address', 'Mother\'s Second Address Line', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_mothers_zip_code', 'Mother\'s ZIP Code', 'trim|xss_clean|strip_tags|numeric');
            $this->frm_val->set_rules('section_member_mothers_city_name', 'Mother\'s City', 'trim|xss_clean|strip_tags');
            $this->frm_val->set_rules('section_member_mothers_country_id', 'Mother\'s Name', 'trim|xss_clean|strip_tags|alpha');
            $this->frm_val->set_rules('section_member_mothers_state_id', 'Mother\'s Name', 'trim|xss_clean|strip_tags|alpha');

            //if caregivers info checked the validate this criteria.
            if ($this->input->post('section_member_caregivers_if_available')) {
                //Members Caregiver Info
                //Members Caregiver Validation Rule
                $this->frm_val->set_rules('section_member_caregivers_first_name', 'Caregiver\'s First Name', 'trim|xss_clean|strip_tags|alpha');
                $this->frm_val->set_rules('section_member_caregivers_last_name', 'Caregiver\'s Last Name', 'trim|xss_clean|strip_tags|alpha');
                $this->frm_val->set_rules('section_member_caregivers_email', 'Caregiver\'s Email', 'trim|xss_clean|strip_tags|valid_email');
                $this->frm_val->set_rules('section_member_caregivers_phone_work', 'Caregiver\'s Phone(work)', 'trim|xss_clean|strip_tags|numeric');
                $this->frm_val->set_rules('section_member_caregivers_phone_home', 'Caregiver\'s Phone(home)', 'trim|xss_clean|strip_tags|numeric');
                $this->frm_val->set_rules('section_member_caregivers_mobile', 'Caregiver\'s Mobile', 'trim|xss_clean|strip_tags|numeric');
                $this->frm_val->set_rules('section_member_caregivers_first_line_address', 'Caregiver\'s  First Address Line', 'trim|xss_clean|strip_tags');
                $this->frm_val->set_rules('section_member_caregivers_second_line_address', 'Caregiver\'s Second Address Line', 'trim|xss_clean|strip_tags');
                $this->frm_val->set_rules('section_member_caregivers_zip_code', 'Caregiver\'s ZIP Code', 'trim|xss_clean|strip_tags|numeric');
                $this->frm_val->set_rules('section_member_caregivers_city_name', 'Caregiver\'s City', 'trim|xss_clean|strip_tags');
                $this->frm_val->set_rules('section_member_caregivers_country_id', 'Caregiver\'s Country', 'trim|xss_clean|strip_tags|alpha');
                $this->frm_val->set_rules('section_member_caregivers_state_id', 'Caregiver\'s State', 'trim|xss_clean|strip_tags|alpha');
            }


            if ($this->frm_val->run() == false) {

            } else {
                $single_row_info = array('id' => md5($this->user_info->organisation_id . unique_id_generator() . set_value('section_member_section_id')), 'section_member_first_name' => set_value('section_member_first_name'), 'section_member_last_name' => set_value('section_member_last_name'), 'section_member_section_id' => set_value('section_member_section_id'), 'section_member_fathers_first_name' => set_value('section_member_fathers_first_name'), 'section_member_fathers_last_name' => set_value('section_member_fathers_last_name'), 'section_member_fathers_email' => set_value('section_member_fathers_email'), 'section_member_fathers_email_hash' => md5(set_value('section_member_fathers_email')), 'section_member_fathers_work_phone' => set_value('section_member_fathers_phone_work'), 'section_member_fathers_home_phone' => set_value('section_member_fathers_phone_home'), 'section_member_fathers_mobile' => set_value('section_member_fathers_mobile'), 'section_member_fathers_first_address_line' => set_value('section_member_fathers_first_line_address'), 'section_member_fathers_second_address_line' => set_value('section_member_fathers_second_line_address'), 'section_member_fathers_zip_code' => set_value('section_member_fathers_zip_code'), 'section_member_fathers_city_name' => set_value('section_member_fathers_city_name'), 'section_member_fathers_country_id' => set_value('section_member_fathers_country_id'), 'section_member_fathers_state_id' => set_value('section_member_fathers_state_id'),

                    'section_member_mothers_first_name' => set_value('section_member_mothers_first_name'), 'section_member_mothers_last_name' => set_value('section_member_mothers_last_name'), 'section_member_mothers_email' => set_value('section_member_mothers_email'), 'section_member_mothers_email_hash' => md5(set_value('section_member_mothers_email')), 'section_member_mothers_work_phone' => set_value('section_member_mothers_phone_work'), 'section_member_mothers_home_phone' => set_value('section_member_mothers_phone_home'), 'section_member_mothers_mobile' => set_value('section_member_mothers_mobile'), 'section_member_mothers_first_address_line' => set_value('section_member_mothers_first_line_address'), 'section_member_mothers_second_address_line' => set_value('section_member_mothers_second_line_address'), 'section_member_mothers_zip_code' => set_value('section_member_mothers_zip_code'), 'section_member_mothers_city_name' => set_value('section_member_mothers_city_name'), 'section_member_mothers_country_id' => set_value('section_member_mothers_country_id'), 'section_member_mothers_state_id' => set_value('section_member_mothers_state_id'),);

                //if caregiver options checked then this database info added
                if ($this->input->post('section_member_caregivers_if_available')) {
                    $single_row_info['section_member_caregiver_first_name'] = set_value('section_member_caregivers_first_name');
                    $single_row_info['section_member_caregiver_last_name'] = set_value('section_member_caregivers_last_name');
                    $single_row_info['section_member_caregiver_email'] = set_value('section_member_caregivers_email');
                    $single_row_info['section_member_caregiver_email_hash'] = md5(set_value('section_member_caregivers_email'));
                    $single_row_info['section_member_caregiver_work_phone'] = set_value('section_member_caregivers_phone_work');
                    $single_row_info['section_member_caregiver_home_phone'] = set_value('section_member_caregivers_phone_home');
                    $single_row_info['section_member_caregiver_mobile'] = set_value('section_member_caregivers_mobile');
                    $single_row_info['section_member_caregiver_first_address_line'] = set_value('section_member_caregivers_first_line_address');
                    $single_row_info['section_member_caregiver_second_address_line'] = set_value('section_member_caregivers_second_line_address');
                    $single_row_info['section_member_caregiver_zip_code'] = set_value('section_member_caregivers_zip_code');
                    $single_row_info['section_member_caregiver_city_name'] = set_value('section_member_caregivers_city_name');
                    $single_row_info['section_member_caregiver_country_id'] = set_value('section_member_caregivers_country_id');
                    $single_row_info['section_member_caregiver_state_id'] = set_value('section_member_caregivers_state_id');
                    $single_row_info['section_member_group_id'] = 0;
                    $single_row_info['section_member_remove'] = 0;
                }

                //loading the section model
                $this->load->model('section_member_model');
                if ($allowed_to_add_members) {
                    if ($this->section_member_model->create_section_member_info($single_row_info)) {
                        $data['add_member_success'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Member added successfully.</div>'; //$this->session->flashdata('add_member_success');$this->session->set_flashdata('add_member_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Member added successfully.</div>');
                    } else {
                        $data['add_member_error'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>'; //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
                    }
                }
            }
        }

        $this->_render_admin('section_member/add_member', $data, $css_js_array);
    }

    /**
     * View all the students with all configuration
     */
    public function sections_member() {
        $css_js = array('codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables', 'bootstrap-wysihtml5'), 'codeboxr_js' => array('jquery.dataTables.min', 'wysihtml5-0.3.0', 'bootstrap-wysihtml5'));

        $this->load->model(array('section_member_model'));
        $this->load->library('pagination');
        $data['login_user_data'] = $this->user_info;

        $data['classList'] = $this->section_member_model->get_all_section_list_in_org($this->user_info->organisation_id);

        $data['classList'] = json_encode($data['classList']);

        $config["base_url"] = base_url('user/students');
        $config["total_rows"] = $this->section_member_model->count_section_member();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["section_member_list"] = $this->section_member_model->get_section_member_list($this->user_info->organisation_id, $config["per_page"], $page);

        $data["pagination"] = $this->pagination->create_links();

        $this->_render_admin('section_member/index', $data, $css_js);
    }

    /**
     * view single student
     */
    /* public function view_single_student(){
         $data['login_user_data'] = $this->user_info;
         $this->load->model('section_member_model');
         $id = $this->uri->segment(3);
         $data['single_student_data'] = $this->section_member_model->view_single_student_data($id);
         //print_r($data['single_student_data']);exit;
         $this->_render_admin('students/view_students', $data);
     }*/

    /**
     * update the class via ajax while on the class list view
     */
    public function get_Student_List_Within_Class_Via_Ajax() {
        $this->load->model('section_model');
        $getAjaxData = $this->input->post('dataArr');
        $getMoveClass = $this->input->post('moveTo');
        $sizeOfData = sizeof($getAjaxData);
        $tempArr = [];
        for ($i = 0; $i < $sizeOfData; $i++) {
            $tempArr[$i] = $getAjaxData[$i][0];
        }
        $result = $this->section_model->updateStudentClass($tempArr, $getMoveClass);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();
    }

    /**
     * post the class with ajax on student list class update
     */
    public function post_student_class_with_ajax() {
        $this->load->model('section_member_model');
        $getAjaxData = $this->input->post('dataArr'); //$this->debug($getAjaxData); exit();
        $getMoveClass = $this->input->post('moveTo'); //$this->debug($getMoveClass); //exit();
        $sizeOfData = sizeof($getAjaxData);
        $sectionIdArr = [];
        $stuIdArr = [];

        for ($i = 0; $i < $sizeOfData; $i++) {
            $stuIdArr[$i] = $getAjaxData[$i][0];
            $sectionIdArr[$i] = $getAjaxData[$i][1];
        }
        //$this->debug($sectionIdArr); exit();
        $result = $this->section_member_model->updateStudentClass($stuIdArr, $sectionIdArr, $getMoveClass);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();
    }

    public function post_staff_class_with_ajax() {
        $this->load->model('user_model');
        $this->load->model('section_model');
        $getclassname = $this->input->post('dataClassName'); //$this->debug($getAjaxData); exit();
        $getstaffname = $this->input->post('dataStaffName');
        $getstaffemail = $this->input->post('dataStaffEmail'); //$this->debug($getMoveClass); //exit();
        $getclassorg = $this->input->post('dataClassOrgId');
        $sizeOfData = sizeof($getclassname);
        //var_dump($sizeOfData);
        // var_dump($getstaffemail);
        // var_dump($getstaffname);
        // var_dump($getclassorg);


        $sectionIdArr = '';
        $stuIdArr = '';
        for ($i = 0; $i < $sizeOfData; $i++) {
            //var_dump('hello');
            $staffId = $getstaffemail[$i];
            $staffId = md5($staffId);
            $sectionUniqueId = unique_id_generator();
            $classname = $getclassname[$i];
            $class_org_id = $getclassorg[$i];
            $staff_organisation = $this->user_model->get_user_organisation($getstaffemail[$i]);
            if ($staff_organisation == false) {
                $staff_organisation = '';
            }
            // var_dump($staffId);
            // var_dump($sectionUniqueId);
            // var_dump($class_org_id);
            // var_dump($staff_organisation);
            // var_dump($classname);
            // var_dump($organisation);


            $result = $this->user_model->update_staff_class($sectionUniqueId, $staffId, $classname, $staff_organisation, $class_org_id);
            //if()
        }

        //$this->debug($sectionIdArr); exit();

        $result = true;
        if ($result) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();
    }

    /**
     * post the class with ajax on student list and delete
     */
    public function post_delete_student_with_ajax() {
        //$this->load->helper(array('form', 'url'));
        //$this->load->library('form_validation');
        //$this->form_validation->set_rules('section_member_first_name', 'section_member_first_name', 'required');
        /* if ($this->form_validation->run() == FALSE)
         {
             $this->load->view('myform');
         }
         else
         {*/
        //$this->load->view('formsuccess');
        $this->load->model('section_member_model');
        $getDelStudent = $this->input->post('deleteArr'); //$this->debug($getDelStudent); exit();

        $result = $this->section_member_model->deleteStudent($getDelStudent);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();
        //}

    }


    /**
     * post the class with ajax on student list and delete
     */
    public function post_delete_class_with_ajax() {
        $this->load->model('section_member_model');
        $this->load->model('section_model');
        $getDelClass = $this->input->post('deleteArr'); //$this->debug($getDelClass); exit();
        $result = $this->section_model->deleteClass($getDelClass);
        $unassign = $this->section_member_model->unAssignClass($getDelClass);

        // $this->debug($result); exit();
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();
    }

    /**
     * calendar view
     * make events calendar
     */
    public function view_calendar() {
        $css_js_for_calender = array('codeboxr_css' => array('calendar'), 'codeboxr_js' => array('bootstrap.min', 'underscore-min', 'calendar'), 'codeboxr_inject_js_after_footer' => array('app_calendar'));
        $data['login_user_data'] = $this->user_info;
        //$login_user_data = $this->user_info;
        //$this->debug($data['login_user_data']);
        //$this->debug($note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar($login_user_data->organisation_id, '', $login_user_data->id));
//        $this->load->model('note_model');
//
//        $note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar();
//        foreach($note_data as $data){
//            echo $data->note_name;
//        }
//        $this->debug($note_data);

        $this->_render_admin('calendar/index', $data, $css_js_for_calender);
    }

    /**
     * Calendar data rendering. Pass this data to events_source to manipulate the calendar events
     */
    public function calendar_data() {
        $this->load->model('note_model');
        $login_user_data = $this->user_info;
        //$this->debug($login_user_data);
        if ($login_user_data->user_access_level == 1) {
            $note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar();
        } elseif ($login_user_data->user_access_level == 3) {
            $note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar($login_user_data->organisation_id);
        } elseif ($login_user_data->user_access_level == 4) {
            $note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar($login_user_data->organisation_id, $login_user_data->id);
        } elseif ($login_user_data->user_access_level == 5) {
            $note_data = $this->note_model->get_all_note_list_by_organisation_id_calendar($login_user_data->organisation_id, '', $login_user_data->id);
        }

        $out = [];
        foreach ($note_data as $data) {
            array_push($out, array('id' => $data->note_id, 'title' => "$data->note_name", 'url' => base_url() . "note/note-result/$data->note_id", "class" => "event-info", 'start' => strtotime($data->note_event_date) . '000', 'end' => strtotime($data->note_event_date) . '000'));
        }
        //note/note-result/$data->note_id

        /*$this->load->model('note_model');

        $note_data = $this->note_model->get_all_note_list_by_organisation_id();*/

//        $out[] = array('id' => 23, 'title' => 'Visit to Zoo', 'url' => "http//google.com", "class" => "event-warning", 'start' => 1393911192000, 'end' => 1393911192000);
//        $out[] = array('id' => 24, 'title' => 'Payment for Note: School Annual Sports Due', 'url' => "http//google.com", "class" => "event-warning", 'start' => 1393997592000, 'end' => 1393997592000);
//        $out[] = array('id' => 25, 'title' => 'Note: Visit to Sydney Zoo | 9.00 am - 5.00 pm', 'url' => "http//google.com", "class" => "event-special", 'start' => 1394346792000, 'end' => 1394346792000);
//        $out[] = array('id' => 26, 'title' => 'Note: Scout Camp at Tasmania', 'url' => "http//google.com", "class" => "event-info", 'start' => 1394429592000, 'end' => 1394692392000);
        echo json_encode(array('success' => 1, 'result' => $out));
        exit;
    }


    public function parent_dashboard() {
        //print_r($this->user_info->id);
        $css_js = array('codeboxr_css' => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'), 'codeboxr_js' => array('jquery.dataTables.min'));
        $data['login_user_data'] = $this->user_info;
        $data['noteList'] = $this->note_model->get_all_note_list_of_child($this->user_info->id);
        $this->_render_admin('parent/dashboard', $data, $css_js);
    }

    public function parent_payment() {
        $css_js = array('codeboxr_css' => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'), 'codeboxr_js' => array('jquery.dataTables.min'));
        $data['login_user_data'] = $this->user_info;
        $this->_render_admin('parent/payment', $data, $css_js);
    }

    public function parent_profile() {
        $css_js = array('codeboxr_css' => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables', 'parentstyle', 'datepicker'), 'codeboxr_js' => array('jquery-ui', 'jquery.dataTables.min', 'bootstrap-datepicker', 'jquery.form.min', 'ajaximageupload'));

        $this->load->model(array('localization', 'user_model', 'section_member_model'));

        // $this->debug($this->user_info);
        $data['login_user_data'] = $this->user_info;

        $data['section_member_data'] = $this->section_member_model->get_section_member_data_of_parent($this->user_info->organisation_id, $this->user_info->caregiver_unique_id);

        foreach ($data['section_member_data'] as $child) {
            $child->other_parent = $this->user_model->get_parent_of_child($child->section_member_unique_id, $this->user_info->caregiver_unique_id);

        }
        //$this->debug($data['section_member_data']);
        /*foreach($data['section_member_data'] as $child) {
            $child_unique_id[] = $child->section_member_unique_id;
        }

        $child_unique_ids = implode(',',$child_unique_id);
        $this->debug($child_unique_id);
        $this->user_model->get_parent_of_child($child_unique_ids,$this->user_info->caregiver_unique_id);*/

        $data['country_list'] = $this->localization->get_all_country_list();
        $data['state_list'] = $this->localization->get_all_state_list();
        $data['timezone_list'] = $this->localization->get_all_timezone_list();

        $data['relation_with_child'] = $this->user_model->get_relation_with_child();
        //print_r($data['relation_with_child']);

        $this->_render_admin('parent/profile', $data, $css_js);


        /* $this->load->library('form_validation', '', 'frm_val');
         $data['note_create_error'] = $this->session->flashdata('note_create_error');
         $this->frm_val->set_rules('first_name', 'First Name', 'trim|required|xss_clean|strip_tags');
         $this->frm_val->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|strip_tags');
         $this->frm_val->set_rules('relationwithchild', ' Relation With Child', 'trim|required|xss_clean|strip_tags');
         $this->frm_val->set_rules('mobilephone', ' Mobile Phone', 'trim|required|xss_clean|strip_tags');

         if($this->frm_val->run() == false) {
             $data['id'] = $this->user_info->id;
             print_r('fdsfdsf');
             print_r($this->frm_val->run());
             $this->_render_admin('parent/profile', $data, $css_js_for_school_admin_staff_list);
         }  else {*/
        /* if($_POST){
         $this->debug($_POST);
             if($this->user_model->update_user($_POST, $this->user_info->id)) {
                 $this->session->set_flashdata('note_update_success', '<strong>Success! </strong>Note Creation success.');
                 redirect(base_url('user/parentProfile'));
             } else {
                 $this->session->set_flashdata('note_create_error', '<strong>Error! </strong>Something went error.');
                 $this->_render_admin('parent/profile', $data, $css_js_for_school_admin_staff_list);
             }

         }*/
        /*if($_POST){

            $this->debug($_POST);
        }*/

    }

    public function post_ajax_save_child_profile() {

        $this->load->model('section_member_model');
        $getUpdateChild = $this->input->post('childDataString'); //$this->debug($getDelStudent); exit();
        parse_str($getUpdateChild, $getUpdateChild);
        $getUpdateChild['section_member_date_of_birth'] = date("Y-m-d", strtotime($getUpdateChild['section_member_date_of_birth']));
        // print_r($getUpdateChild);exit();
        $result = $this->section_member_model->updateChild($getUpdateChild);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();

    }

    public function post_ajax_save_other_parent_profile() {

        $this->load->model('user_model');
        $getUpdateOtherParent = $this->input->post('otherParentDataString'); //$this->debug($getDelStudent); exit();
        parse_str($getUpdateOtherParent, $getUpdateOtherParent);
        //print_r($getUpdateChild);exit();
        $result = $this->user_model->update_user($getUpdateOtherParent);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();

    }

    public function post_ajax_save_parent_profile() {

        $this->load->model('user_model');
        $getUpdateOtherParent = $this->input->post('parentDataString'); //$this->debug($getDelStudent); exit();
        parse_str($getUpdateOtherParent, $getUpdateOtherParent);
        //print_r($getUpdateChild);exit();
        $result = $this->user_model->update_user($getUpdateOtherParent);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();

    }


    public function post_ajax_upload_profile_image() {

        if (isset($_POST)) {
            ############ Edit settings ##############
            //$ThumbSquareSize 		= 100; //Thumbnail will be 200x200
            $BigImageMaxSize = 150; //Image Maximum height or width
            // $ThumbPrefix			= "thumb_"; //Normal thumb Prefix
            if ($_POST['user_type'] == "parent") {
                $DestinationDirectory = 'upload/avatar/parent/';
            } elseif ($_POST['user_type'] == "student") {
                $DestinationDirectory = 'upload/avatar/student/';
            } elseif ($_POST['user_type'] == "staff") {
                $DestinationDirectory = 'upload/avatar/staff/';
            } elseif ($_POST['user_type'] == "note") {
                $DestinationDirectory = 'upload/avatar/note/';
            }
            /* if (!file_exists($DestinationDirectory)) {
                 mkdir($DestinationDirectory, 0777, true);
             }*/
            // var_dump($DestinationDirectory);

            //specify upload directory ends with / (slash)
            $Quality = 90; //jpeg quality
            ##########################################

            //check if this is an ajax request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                die();
            }

            // check $_FILES['ImageFile'] not empty
            if (!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])) {
                die('Something wrong with uploaded file, something missing!'); // output error when above checks fail.
            }

            if ($_POST['user_type'] == "note") {
                $RandomNumber = $_POST['image-profile'] . $_POST['group-id'];

            } else {
                $RandomNumber = md5(md5($_POST['image-profile']));
            }

            $ImageName = str_replace(' ', '-', strtolower($_FILES['ImageFile']['name'])); //get image name
            $ImageSize = $_FILES['ImageFile']['size']; // get original image size
            $TempSrc = $_FILES['ImageFile']['tmp_name']; // Temp name of image file stored in PHP tmp folder
            $ImageType = $_FILES['ImageFile']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.

            //Let's check allowed $ImageType, we use PHP SWITCH statement here
            switch (strtolower($ImageType)) {
                case 'image/png':
                    //Create a new image from file
                    $CreatedImage = imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
                    break;
                case 'image/gif':
                    $CreatedImage = imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                case 'image/jpg':
                    $CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
                    break;
                default:
                    die('Unsupported File!'); //output error and exit
            }

            //PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
            //Get first two values from image, width and height.
            //list assign svalues to $CurWidth,$CurHeight
            list($CurWidth, $CurHeight) = getimagesize($TempSrc);

            //Get file extension from Image name, this will be added after random name
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);

            //remove extension from filename
            //$ImageName = preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName);

            //Construct a new name with random number and extension.
            // $NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
            $NewImageName = $RandomNumber . '.' . $ImageExt;
            // var_dump($NewImageName);
            if (file_exists($NewImageName)) unlink($NewImageName);

            //set the Destination Image
            /// $thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumbnail name with destination directory
            $DestRandImageName = $DestinationDirectory . $NewImageName; // Image with destination directory

            //Resize image to Specified Size by calling resizeImage function.
            if ($this->resizeImage($CurWidth, $CurHeight, $BigImageMaxSize, $DestRandImageName, $CreatedImage, $Quality, $ImageType)) {
                if ($_POST['user_type'] == "parent" || $_POST['user_type'] == "staff") {
                    $this->load->model('user_model');
                    $this->user_model->update_user_image_extnsn($ImageExt, $_POST['image-profile']);
                } elseif ($_POST['user_type'] == "student") {
                    $this->load->model('section_member_model');
                    $this->section_member_model->update_user_image_extnsn($ImageExt, $_POST['image-profile']);
                } elseif ($_POST['user_type'] == "note") {
                    //  var_dump(' ia ma here ');
                    $data = array('img_ext' => $ImageExt);
                    $this->load->model('note_model');
                    $this->note_model->update_note($_POST['image-profile'], $data, 1);
                }

                //Create a square Thumbnail right after, this time we are using cropImage() function
                // if(!$this->cropImage($CurWidth,$CurHeight,/*$ThumbSquareSize,$thumb_DestRandImageName,*/$CreatedImage,$Quality,$ImageType))
                /* if(!$this->cropImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType))
                 {
                     echo 'Error Creating thumbnail';
                 }*/
                /*
                We have succesfully resized and created thumbnail image
                We can now output image to user's browser or store information in the database
                */
                if ($_POST['user_type'] == "note") {
                    echo '<table width="100%" border="0" cellpadding="4" cellspacing="0">';
                    echo '<tr>';
                    /*echo '<td align="center"><img src="'. base_url().'upload/user-image/'.$ThumbPrefix.$NewImageName.'" alt="Thumbnail"></td>';
                    echo '</tr><tr>';*/
                    echo '<td align="center"><img  class ="image-note" data-item-id="' . $_POST['item-id'] . '" data-group-id ="' . $_POST['group-id'] . '"  id="image-note-' . $_POST['group-id'] . '" src="' . base_url() . $DestinationDirectory . $NewImageName . '" alt="Resized Image"></td>';
                    echo '</tr>';
                    echo '</table>';
                } else {
                    echo '<table width="100%" border="0" cellpadding="4" cellspacing="0">';
                    echo '<tr>';
                    /*echo '<td align="center"><img src="'. base_url().'upload/user-image/'.$ThumbPrefix.$NewImageName.'" alt="Thumbnail"></td>';
                    echo '</tr><tr>';*/
                    echo '<td align="center"><img  id="image-of-parent-profile-after-upload" src="' . base_url() . $DestinationDirectory . $NewImageName . '" alt="Resized Image"></td>';
                    echo '</tr>';
                    echo '</table>';
                }

                /*
                // Insert info into database table!
                mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
                VALUES ($DestRandImageName, $thumb_DestRandImageName, 'uploads/')");
                */

            } else {
                die('Resize Error'); //output error
            }
        }

        /* $this->load->model('user_model');
         $getUpdateOtherParent = $this->input->post('otherParentDataString'); //$this->debug($getDelStudent); exit();
         parse_str($getUpdateOtherParent, $getUpdateOtherParent);
         //print_r($getUpdateChild);exit();
         $result = $this->user_model->update_user($getUpdateOtherParent);
         if ($result > 0) echo json_encode(array('output' => 1));
         else echo json_encode(array('output' => 0));
         exit();
         die();*/

    }

    public function editStudent($student_id = NULL) {
        $student_id = $this->uri->segment(3);
        $this->load->model('section_member_model');

        $css_js = array('codeboxr_css' => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables', 'parentstyle', 'datepicker'), 'codeboxr_js' => array('jquery-ui', 'jquery.dataTables.min', 'bootstrap-datepicker', 'jquery.form.min', 'ajaximageupload'));

        $data['login_user_data'] = $this->user_info;
        $data['section_member_data'] = $this->section_member_model->edit_section_member($student_id);

        $this->_render_admin('section_member/edit_student', $data, $css_js);
    }

    public function add_staff() {
        $css_js_array = array('codeboxr_js' => array('underscore-min', 'bootstrap-tab', 'bootstrap-filestyle.min', 'bootstrap.wizard.min', 'section-member', 'jquery.form.min', 'ajaximageupload', 'jquery.validate'));
        $this->load->library('form_validation', '', 'frm_val');
        $this->load->model(array('user_model'));
        $allowed_to_add_staff = true;

        $data['login_user_data'] = $this->user_info;

        if ($this->input->post('import_staffs')) {
            $config['upload_path'] = './upload/staff-csv-doc';
            $config['allowed_types'] = 'text/plain|text/anytext|csv|text/x-comma-separated-values|text/comma-separated-values|application/octet-stream|application/vnd.ms-excel|application/x-csv|text/x-csv|text/csv|application/csv|application/excel|application/vnd.msexcel';
            $config['overwrite'] = true;
            $config['file_name'] = md5(time() . $this->session->userdata('CN_user_email_hash'));
            $this->load->library('upload', $config);
            //print_r($this->session->userdata); print_r('ccvb');exit;
            //$this->debug($this->input->post('section_id'));
            if ($this->upload->do_upload('staffs')) {
                //get uploaded file info.
                $file_info = $this->upload->data();
                $staff_entry = $this->user_model->create_staff_info_from_file($file_info, $this->user_info->organisation_id);
                //try to batch operation for uploaded section member info.
                if ($staff_entry == 1) {
                    $data['message'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Staff added successfully.</div>';
                } elseif ($staff_entry == 2) {
                    $data['message'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Email Exists.</div>';
                } else {
                    $data['message'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>';

                }

                @unlink($file_info['full_path']);
            } else {
                $data['message'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>' . $this->upload->display_errors() . '</div>'; //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
            }

        } elseif ($this->input->post('add_staffs')) {
            $this->frm_val->set_rules('first_name', ' First Name', 'trim|xss_clean|strip_tags|alpha|required');
            $this->frm_val->set_rules('last_name', 'Last Name', 'trim|xss_clean|strip_tags|alpha|required');
            $this->frm_val->set_rules('email', 'Email', 'trim|xss_clean|strip_tags|valid_email|callback_isEmailExist|required');

            if ($this->frm_val->run() == false) {
                $data['message'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>' . validation_errors() . '</div>';

            } else {
                $single_row_info = array('first_name' => set_value('first_name'), 'last_name' => set_value('last_name'), 'email' => set_value('email'), 'hashing_email' => md5(set_value('email')), 'organisation_name' => $this->session->userdata('CN_org_name'), 'organisation_id' => $this->session->userdata('CN_user_organisation_id'), 'mobilephone' => set_value('mobilephone'), 'user_access_level' => '4', 'user_remove' => '0', 'invited_id' => '1', 'created' => date('Y-m-d H:m:s')

                );

                $user_id = $this->user_model->create_new_staff($single_row_info, $this->user_info->organisation_id);


                if ($user_id != 0 && $user_id != '') {
                    $file_name = $this->input->post('profilepic');
                    $config['upload_path'] = './upload/avatar/staff/';
                    $config['allowed_types'] = 'jpeg|gif|jpg|png';
                    $config['overwrite'] = true;
                    $config['file_name'] = $file_name;


                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);


                    if ($this->upload->do_upload('profilepic')) {
                        $old_file_name = $this->upload->file_name;
                        //Get file extension from Image name, this will be added after random name
                        $ImageExt = substr($old_file_name, strrpos($old_file_name, '.'));
                        $ImageExt = str_replace('.', '', $ImageExt);
                        $new_file_name = md5(md5($user_id)) . '.' . $ImageExt;
                        $path = FCPATH . "/upload/avatar/staff/";

                        rename($path . $old_file_name, $path . $new_file_name);
                        $this->user_model->update_user_image_extnsn($ImageExt, $user_id);


                    }
                    $url = base_url() . 'user/editStaff/' . $user_id;
                    $data['message'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Staff added successfully.&nbsp;<a href=' . $url . '>Edit</a> </div>';

                }

            }
        }

        $this->_render_admin('auth_user/add_staff', $data, $css_js_array);

    }


    public function post_ajax_del_staff() {


        $this->load->model('user_model');
        $getDelStaff = $this->input->post('deleteArr'); //$this->debug($getDelStudent); exit();

        $result = $this->user_model->deleteUser($getDelStaff);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();


    }

    public function editStaff($user_id = NULL) {
        $user_id = $this->uri->segment(3);
        $this->load->model('user_model');

        $css_js = array('codeboxr_css' => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables', 'parentstyle', 'datepicker', 'template'), 'codeboxr_js' => array('jquery-ui', 'jquery.dataTables.min', 'bootstrap-datepicker', 'jquery.form.min', 'ajaximageupload', 'jquery.validate'));

        $data['login_user_data'] = $this->user_info;
        $data['staff_data'] = $this->user_model->get_user_info($user_id);
        //echo "<pre>";print_r( $data['staff_data']);

        $this->_render_admin('auth_user/edit_staff', $data, $css_js);
    }


    public function post_ajax_update_staff() {


        $this->load->model('user_model');
        $getUpdateStaff = $this->input->post('staffDataString'); //$this->debug($getDelStudent); exit();
        parse_str($getUpdateStaff, $getUpdateStaff);
        //print_r($getUpdateChild);exit();
        $result = $this->user_model->update_user($getUpdateStaff);
        if ($result > 0) echo json_encode(array('output' => 1)); else echo json_encode(array('output' => 0));
        exit();
        die();

    }


    public function post_ajax_staff_invite() {


        $view_note_template = $this->load->view('page/email/staff_invitation', '' , true);

        $this->load->helper( 'function' );
        $getInvitedStaff = $this->input->post('inviteArr');
        $getInvitedText = $this->input->post('inviteText');
       // var_dump($getInvitedText);
        $this->load->model('user_model');
       foreach($getInvitedStaff as $getInvitedStaffalone)
       {
           $receive_all_mail = $this->user_model->get_user_details_more($getInvitedStaffalone);
          // $mail_sending_array = array();
           if( is_array( $receive_all_mail ) and count( $receive_all_mail ) > 0) {
               $mail_sending_array['from'] = 'no-reply@cloudenotes.com';
               $mail_sending_array['parent_fname']           = $receive_all_mail[0]->first_name;
               $mail_sending_array['parent_email']           = $receive_all_mail[0]->email;
               $mail_sending_array['parent_lname']           = $receive_all_mail[0]->last_name;
           }
           $mail_sending_array['organisation_name']      = $receive_all_mail[0]->organisation_name;
           $mail_sending_array['subject'] = 'You have a new CloudeNote';
           $mail_sending_array['message'] = $view_note_template;
           $mail_sending_array['message_text'] = $getInvitedText;
           $result = send_mail( $mail_sending_array, 3 );


       }

        exit;

    }
 public function post_ajax_parent_invite(){
     $view_note_template = $this->load->view('page/email/staff_invitation', '' , true);

     $this->load->helper( 'function' );
     $getInvitedStaff = $this->input->post('inviteArr');
     var_dump($getInvitedStaff);

 }
    public function isEmailExist($email) {
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $is_exist = $this->user_model->isEmailExist($email);

        if ($is_exist) {
            $this->frm_val->set_message('isEmailExist', 'Email address already exists.');

            return false;
        } else {
            return true;
        }
    }

    public function user_settings() {

        $css_js_array = array('codeboxr_css' => array('super-admin', 'bootstrap-table-responsive.min'), 'codeboxr_js' => array('bootstrap-alert' /*, 'bootstrap-dropdown'*/));
        $data['login_user_data'] = $this->user_info;

        $this->_render_admin('settings/user/index', $data, $css_js_array);
    }

    public function admin_user_settings() {

        $css_js_array = array('codeboxr_css' => array('super-admin', 'bootstrap-table-responsive.min'), 'codeboxr_js' => array('bootstrap-alert' /*, 'bootstrap-dropdown'*/));
        $data['login_user_data'] = $this->user_info;

        $this->_render_admin('settings/admin/index', $data, $css_js_array);
    }

    /*
     * Registered Institution view for super admin
     */
    public function admin_dashboard_ins_registration() {
        if ($this->user_info->user_access_level != 1) {
            redirect(base_url('user'));
        }
        $css_js_ins = array('codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'), 'codeboxr_js' => array('jquery.dataTables.min'));
        $data['login_user_data'] = $this->user_info;
        $this->load->model('user_model');
        $data['getData'] = $this->user_model->getRegIns();
        $this->_render_admin('registration_view/institute_view', $data, $css_js_ins);
    }

    /*
     * Registered Students/Parents view for super admin
     */
    public function admin_dashboard_parent_student_registration() {
        if ($this->user_info->user_access_level != 1) {
            redirect(base_url('user'));
        }
        $css_js_ins = array('codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'), 'codeboxr_js' => array('jquery.dataTables.min'));
        $data['login_user_data'] = $this->user_info;
        $this->load->model('user_model');
        $data['getData'] = $this->user_model->getAllSectionMember();
        $this->_render_admin('registration_view/parent_student_view', $data, $css_js_ins);
    }

    public function admin_user_permissions() {

        $css_js_array = array('codeboxr_css' => array('super-admin', 'bootstrap-table-responsive.min'), 'codeboxr_js' => array('bootstrap-alert' /*, 'bootstrap-dropdown'*/));
        $this->load->model('auth_user_model');
        $data['login_user_data'] = $this->user_info;
        if ($this->input->post()) {

            $capability = json_encode($this->input->post());
            $org_id = 0;
            $user_id = 0;
            $id = "";
            $function = 'insert_access_permission';

            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                $function = 'update_access_permission';
            }
            $insert_array = array('id' => $id, 'org_id' => $org_id, 'user_id' => $user_id, 'capability' => $capability, 'created' => date('Y:m:d h:m:s'));
            $is_exist = $this->auth_user_model->$function($insert_array);
        }

        if ($this->user_info->user_access_level == 1) {
            $access_capability = $this->auth_user_model->get_access_permission(0, 0);

            if (!$access_capability) {
                $this->load->helper('access_capability');
                $data['roles'] = get_access_capability_box();
                $data['id'] = '';

            } else {
                $data['roles'] = json_decode($access_capability['capability'], true);
                $data['id'] = $access_capability['id'];
            }
        }
        $this->_render_admin('settings/admin/permissions', $data, $css_js_array);
    }

    public function user_permissions() {
        if ($this->user_info->user_access_level > 4 && $this->user_info->user_access_level != 1) {
            redirect(base_url('user/settings'));
        }

        $css_js_array = array(
            'codeboxr_css' => array('super-admin', 'bootstrap-table-responsive.min', 'prettyCheckable'),
            'codeboxr_js' => array('bootstrap-alert', 'prettyCheckable'));
        $this->load->model('auth_user_model');
        $data['login_user_data'] = $this->user_info;

        if ($this->input->post()) {
            //  echo "<pre>"; print_r($this->input->post());  echo "</pre>";exit();
            $capability = json_encode($this->input->post());
            $org_id = $this->user_info->organisation_id;
            $user_id = 0;
            $id = "";
            $function = 'insert_access_permission';
            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                $function = 'update_access_permission';
            }
            $insert_array = array('id' => $id, 'org_id' => $org_id, 'user_id' => $user_id, 'capability' => $capability, 'created' => date('Y:m:d h:m:s'));
            $is_exist = $this->auth_user_model->$function($insert_array);


        }

        if ($this->user_info->user_access_level < 5 && $this->user_info->user_access_level > 1) {

            $access_capability = $this->auth_user_model->get_access_permission($this->user_info->organisation_id, 0);
            // echo "<pre>"; print_r($access_capability);  echo "</pre>";
            $access_capability = ($access_capability) ? ($access_capability) : $this->auth_user_model->get_access_permission(0, 0);

            if ($access_capability) {

                $data['roles'] = json_decode($access_capability['capability'], true);
                if ($access_capability['org_id'] == 0) {
                    $data['id'] = '';
                } else {
                    $data['id'] = $access_capability['id'];
                }

            } else {
                $this->load->helper('access_capability');
                $data['roles'] = get_access_capability_box();
                $data['id'] = '';
            }
        }
        //echo "<pre>"; print_r( $data['roles']);  echo "</pre>";

        $this->_render_admin('settings/user/permissions', $data, $css_js_array);
    }


    public function resizeImage($CurWidth, $CurHeight, $MaxSize, $DestFolder, $SrcImage, $Quality, $ImageType) {
        //Check Image size is not 0
        if ($CurWidth <= 0 || $CurHeight <= 0) {
            return false;
        }

        //Construct a proportional size of new image
        $ImageScale = min($MaxSize / $CurWidth, $MaxSize / $CurHeight);
        $NewWidth = ceil($ImageScale * $CurWidth);
        $NewHeight = ceil($ImageScale * $CurHeight);
        $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);

        // Resize Image
        if (imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight)) {
            switch (strtolower($ImageType)) {
                case 'image/png':
                    imagepng($NewCanves, $DestFolder);
                    break;
                case 'image/gif':
                    imagegif($NewCanves, $DestFolder);
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewCanves, $DestFolder, $Quality);
                    break;
                default:
                    return false;
            }
            //Destroy image, frees memory
            if (is_resource($NewCanves)) {
                imagedestroy($NewCanves);
            }

            return true;
        }
    }

    //This function corps image to create exact square images, no matter what its original size!
    /* public function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
     {
         //Check Image size is not 0
         if($CurWidth <= 0 || $CurHeight <= 0)
         {
             return false;
         }

         //abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
         if($CurWidth>$CurHeight)
         {
             $y_offset = 0;
             $x_offset = ($CurWidth - $CurHeight) / 2;
             $square_size 	= $CurWidth - ($x_offset * 2);
         }else{
             $x_offset = 0;
             $y_offset = ($CurHeight - $CurWidth) / 2;
             $square_size = $CurHeight - ($y_offset * 2);
         }

         $NewCanves 	= imagecreatetruecolor($iSize, $iSize);
         if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
         {
             switch(strtolower($ImageType))
             {
                 case 'image/png':
                     imagepng($NewCanves,$DestFolder);
                     break;
                 case 'image/gif':
                     imagegif($NewCanves,$DestFolder);
                     break;
                 case 'image/jpeg':
                 case 'image/pjpeg':
                     imagejpeg($NewCanves,$DestFolder,$Quality);
                     break;
                 default:
                     return false;
             }
             //Destroy image, frees memory
             if(is_resource($NewCanves)) {imagedestroy($NewCanves);}
             return true;

         }

     }*/

    public function is_section_exist($section_name = '') {
        if ($section_name == '') {
            show_404();
        }
        $trace = debug_backtrace();
        if (isset($trace[1]) and isset($trace[1]['class'])) {
            if ($trace[1]['class'] == 'CI_Form_validation') {
                $this->load->model('section_model');
                if ($this->section_model->has_section_by_name($section_name, md5($this->user_info->id))) {
                    $this->load->library('form_validation', 'frm_val');
                    $this->frm_val->set_message('is_section_exist', 'The %s \'' . $section_name . '\' already exist');

                    return false;
                } else {
                    return true;
                }
            } else {
                exit('No Direct access');
            }
        } else {
            exit('No Direct access');
        }
    }

    public function organisation_setup() {

        if ($this->input->post('json')) {
            $info_type = $this->input->post('info_type');
            switch ($info_type) {
                case 'profile':
                    $profile = json_decode($this->input->post('required_info'));
                    if (!is_object($profile) or empty($profile->org_name) or empty($profile->org_admin_fname) or empty($profile->org_admin_lname) or empty($profile->org_admin_city) or empty($profile->org_admin_country_id) or empty($profile->org_admin_timezone_id)) {
                        echo 'false';
                    } else {
                        $this->load->model('user_model');
                        $user_data['id'] = $this->user_info->id;
                        $user_data['organisation_setup'] = '1';
                        $user_data['organisation_name'] = $profile->org_name;
                        $user_data['first_name'] = $profile->org_admin_fname;
                        $user_data['last_name'] = $profile->org_admin_lname;
                        $user_data['city_name'] = $profile->org_admin_city;
                        $user_data['country_id'] = $profile->org_admin_country_id;
                        $user_data['timezone_id'] = $profile->org_admin_timezone_id;
                        if (!empty($profile->org_admin_state_id)) {
                            $user_data['state_id'] = $profile->org_admin_state_id;
                        }
                        if ($this->user_model->update_user($user_data)) {
                            $this->session->set_userdata('CN_org_name', $profile->org_name);
                            $this->session->set_userdata('CN_first_name', $profile->org_admin_fname);
                            $this->session->set_userdata('CN_last_name', $profile->org_admin_lname);
                            echo 'true';
                        } else {
                            echo 'false';
                        }
                    }
                    break;
                case 'create_section':
                    break;
                case 'add_staff':
                    break;
                case 'add_members':
                    break;
                default:
                    break;
            }
            exit;
        }

        $data['login_user_data'] = $this->user_info;
        $this->load->model(array('localization'));
        $data['country_list'] = $this->localization->get_all_country_list();
        $data['state_list'] = $this->localization->get_all_state_list();
        $data['timezone_list'] = $this->localization->get_all_timezone_list();

        //var_dump( $data['login_user_data'] );exit;

        /*if ( $this->user_info->user_access_level != '3' or has_organisation() ) {
            redirect( base_url('user/edit-profile') );
        } else {

        }*/

        $ext_css_js_array = array(

            'codeboxr_css' => array(
                'imgareaselect-animated',
                //'jquery.Jcrop.min',
                'cloud_crumbs',
            ),

            'codeboxr_js' => array(
                //'bootstrap-datepicker',
                //'date_picker',
                //'alertify.min',
                'bootstrap.wizard.min',
                'jquery.imgareaselect.pack',
                //'jquery.Jcrop.min',
                'bootstrap-filestyle.min',
                //'bootstrap-fileinput',
                'app',
                'org-setup',
                //'notes',
                //'jquery.dataTables.min',
                //'bootstrap-timepicker',
                //'jquery.classyedit',
                //'wysihtml5-0.3.0',
                //'bootstrap-wysihtml5',
                //'summernote',
                //'jquery.form.min',
                //'ajaximageupload'
            )

        );

        $this->_render_admin('user/setup_org', $data, $ext_css_js_array);
    }

    public function crop_image_for_org() {


        $valid_exts = array('jpeg', 'jpg');
        $max_file_size = ((800 * 400) * 1024); #200kb
        $nw = 800;
        $nh = 400; # image with # height

        $dst_w = (int)$_POST['w'] ? $_POST['w'] : $nw;
        $dst_h = (int)$_POST['h'] ? $_POST['h'] : $nh;

        if (isset($_FILES['org_image'])) {
            if (!$_FILES['org_image']['error'] && $_FILES['org_image']['size'] < $max_file_size) {
                $ext = strtolower(pathinfo($_FILES['org_image']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $valid_exts)) {

                    $TempSrc = $_FILES['org_image']['tmp_name']; // Temp name of image file stored in PHP tmp folder
                    $ImageType = $_FILES['org_image']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.

                    //Let's check allowed $ImageType, we use PHP SWITCH statement here
                    switch (strtolower($ImageType)) {
                        case 'image/png':
                            //Create a new image from file
                            $CreatedImage = imagecreatefrompng($_FILES['org_image']['tmp_name']);
                            break;
                        case 'image/gif':
                            $CreatedImage = imagecreatefromgif($_FILES['org_image']['tmp_name']);
                            break;
                        case 'image/jpeg':
                        case 'image/pjpeg':
                        case 'image/jpg':
                            $CreatedImage = imagecreatefromjpeg($_FILES['org_image']['tmp_name']);
                            break;
                        default:
                            die('Unsupported File!'); //output error and exit
                    }

                    //PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
                    //Get first two values from image, width and height.
                    //list assign svalues to $CurWidth,$CurHeight
                    list($CurWidth, $CurHeight) = getimagesize($TempSrc);

                    $new_image_name = (md5($this->user_info->id . microtime()));

                    $path = 'upload/' . $new_image_name . '.' . $ext;

                    $size = getimagesize($_FILES['org_image']['tmp_name']);

                    $dstImg = imagecreatetruecolor($dst_w, $dst_h);
                    $white = imagecolorallocate($dstImg, 255, 255, 255);
                    imagefill($dstImg, 0, 0, $white);
                    //var_dump($size);exit;
                    $src_x = (int)$_POST['x'];
                    $src_y = (int)$_POST['y'];
                    $src_w = $size[0];
                    $src_h = $size[1];
                    imagecopyresampled($dstImg, $CreatedImage, 0, 0, $dst_w, $src_y, $src_x, $dst_h, $src_w, $src_h);
                    imagejpeg($dstImg, $path);

                    //echo $w.'_'.$h;exit;
                    /*if( imagecopyresampled($dstImg, $CreatedImage, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) ) {
                        imagejpeg($dstImg, $path);
                        imagedestroy($dstImg);
                    }*/

                    /*//echo $x.'_'.$w.'_'.$w.'_'.$h;exit;
                    $data = file_get_contents($_FILES['org_image']['tmp_name']);
                    //var_dump( base64_decode($data));exit;
                    //$data = base64_encode( $data );
                    //$data = base64_decode( $data );
                    $vImg = imagecreatefromstring( $data );
                    $dstImg = imagecreatetruecolor($nw, $nh);
                    $white = imagecolorallocate($dstImg, 255, 255, 255);
                    imagefill($dstImg, 0, 0, $white);
                    imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
                    imagejpeg($dstImg, $path);
                    imagedestroy($dstImg);*/
                    echo "{upload: true, image_name: " . $new_image_name . "}";

                } else {
                    echo "{upload: false, error_message: 'Only jpeg file allowed'}";
                }
            } else {
                echo "{upload: false, error_message: 'file size is too small or too large'}";
            }
        } else {
            echo "{upload: false, error_message: 'file not set'}";
        }
    }


}