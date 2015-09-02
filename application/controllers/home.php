<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/20/13
 * Time: 2:54 PM
 */

class Home extends MY_Controller {

    private $css_js_array = array(
        'codeboxr_css' => array(),
        'codeboxr_js' => array('app')
    );

    public function __construct() {
        parent::__construct($this->css_js_array);
        if($this->dx_auth->is_logged_in()) {
            //redirect(base_url('dashboard'));
        }
    }

	public function index() {
        $css_js_for_note_counter = array(
            'codeboxr_css'  => array('notes-counter', 'tinyscrollbar-custom'),
            'codeboxr_inject_js_after_footer' => array('jquery.tinyscrollbar','imagesloaded.pkgd.min')
        );
        $this->load->model('note_model');
        $data['note_count'] = $this->note_model->note_count();
        $data['length']     = strlen($data['note_count']); //echo $len;
        $data['remaining']  = 6 - $data['length'];
        $data['note_count_show']  = array_map('intval', str_split($data['note_count']));
        for ($i = 0; $i < $data['remaining']; $i++){
            array_unshift($data['note_count_show'], 0);
        }
        $this->_render('home/index', $data, $css_js_for_note_counter);
        //$this->output->enable_profiler();
    }

    public function contact() {
        $css_js_for_contact = array(
            'codeboxr_js' => array('jquery','jquery.validate.min','app','bootstrap.min'),
            'codeboxr_css' => array('bootstrap.min','bootstrap-responsive.min','font-awesome','template'),
        );
        $data['success_message'] = $this->session->flashdata('success_message');
        $data['failure_message'] = $this->session->flashdata('failure_message');
        $data['error_login']     = $this->session->flashdata('error_login');
        $this->_render('contact/index', $data, $css_js_for_contact);
    }

    public function feature() {
        $css_js_for_pricing = array(
            'codeboxr_js' => array('jquery.smooth-scroll')
        );
        $this->_render('feature/index', '', $css_js_for_pricing);
    }

    public function register() {
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
            $val->set_rules('user_level', 'User Type', 'trim|required|xss_clean|numeric');
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
            if ($val->run() AND $this->dx_auth->register(/*$val->set_value('username')*/'', $val->set_value('user_password'), $val->set_value('user_email'), $val->set_value('user_level')))
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
                //$this->_render('auth/success', $data);
                //$this->_render('auth/success', $data);
                $this->session->set_flashdata('auth_message', $data['auth_message']);
                redirect(base_url('success/'));
            }
            else
            {
                // Load registration page
                $this->_render('auth/index', '', $css_js_for_auth);
            }
        }

    }

    public function login() {

        if ($this->dx_auth->is_logged_in()) {
            redirect(base_url('dashboard'));
        } else {

            $this->load->library('Form_validation');
            $css_js_for_auth = array(
            'codeboxr_js' => array('bootstrap-alert')
            );
            $min_password = 4;
            $max_password = 20;
            $val = $this->form_validation;

            // Set form validation rules
            /*$val->set_rules('username', 'Username', 'trim|required|xss_clean');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean');
            $val->set_rules('remember', 'Remember me', 'integer');*/

            $val->set_rules('user_login_password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']');
            //$val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']|matches[confirm_password]');
            $val->set_rules('user_login_email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            // Set captcha rules if login attempts exceed max attempts in config
            if ($this->dx_auth->is_max_login_attempts_exceeded())
            {
                $val->set_rules('captcha', 'Confirmation Code', 'trim|required|xss_clean|callback_captcha_check');
            }

            if ($val->run() AND $this->dx_auth->login($val->set_value('user_login_email'), $val->set_value('user_login_password'), $val->set_value('remember_me')))
            {
                // Redirect to homepage
                redirect(base_url('dashboard/'));
            }
            else
            {
                //exit('test');
                // Check if the user is failed logged in because user is banned user or not
                if ($this->dx_auth->is_banned()) {
                    // Redirect to banned uri
                    //$this->dx_auth->deny_access('banned');
                    $data['banned'] = 'Sorry! your banned for this site.';
                } else {
                    // Default is we don't show captcha until max login attempts eceeded
                    $data['show_captcha'] = FALSE;

                    // Show captcha if login attempts exceed max attempts in config
                    if ($this->dx_auth->is_max_login_attempts_exceeded())
                    {
                        // Create catpcha
                        $this->dx_auth->captcha();

                        // Set view data to show captcha on view file
                        $data['show_captcha'] = TRUE;
                    }

                    $data['auth_error'] = $this->dx_auth->get_auth_error();

                    // Load login page view
                    $this->_render('auth/index', $data);
                }
            }
        }
    }

    public function logout() {
        $this->dx_auth->logout();
        redirect(base_url());
    }

    private function message($message) {
        $data = array(
            'cl_note_msg' => $message
        );
        $this->_render('auth/message', $data);
    }

    public function success() {
        if(!$auth_message = $this->session->flashdata('auth_message')) {
            exit('503 Access Forbidden.');
        }
        $this->message($auth_message);
    }

    public function activate()
    {
        // Get username and key
        if(!$activation_key = $this->uri->segment(2)) {
            exit('503 Access Forbidden');
        }

        // Activate user
        if ($this->dx_auth->activate($activation_key)) {
            $data['auth_message'] = 'Your account have been successfully activated. '.anchor(base_url('login/'), 'Login');
        } else {
            $data['auth_message'] = 'The activation code you entered was incorrect. Please check your email again.';
        }

        $this->session->set_flashdata('auth_message', $data['auth_message']);
        redirect(base_url('success/'));
    }


    public function email() {
        $this->load->view('page/email/activation');
    }

    /**
     * Student View in dashboard
     * needs to move this method on dashboard controller
     */
    public function student_view(){
        $css_js_for_dashboard = array(
            'codeboxr_css'  => array('cloud_crumbs', 'dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js'   => array ('jquery.dataTables.min')
        );

        $this->load->model('section_member_model');
        $data['student_list'] = $this->section_member_model->get_students();
        //echo "<pre>"; print_r($res); echo "</pre>";exit();

        $this->_render('test/test', $data, $css_js_for_dashboard);
    }

    /**
     * Dashboard for admin panel
     * needs to change the controller
     */
    public function admin_dashboard(){
        $css_js_for_dashboard = array(
            'codeboxr_css'  => array('dashboard'),
        );

        $this->_render('test/dashboard', '', $css_js_for_dashboard);
    }

    /**
     * Activity log of cloudenotes for super admin
     * needs to change the controller
     */
    public function activity_log(){
        $css_js_for_dashboard = array(
            'codeboxr_css'  => array('dashboard'),
        );
        $this->_render('test/activity_log', '', $css_js_for_dashboard);
    }


    /**
     * Controller for sending email from contact us page
     */
    public function email_admin() {
		//echo 'i am here';
		//exit();
        $this->load->library('form_validation');
        $css_js_for_contact = array(
            'codeboxr_js' => array('bootstrap-alert', 'jquery.validate.min')
        );
        $min_password = 4;
        $max_password = 20;
        $val = $this->form_validation;

        if ( !$this->dx_auth->is_logged_in() ) :
            $val->set_rules('user_login_password', 'Password', 'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']');
            $val->set_rules('user_login_email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
        endif;

        $val->set_rules('email_subject', 'Subject', 'trim|required|xss_clean');
        $val->set_rules('email_message', 'Message', 'trim|required|xss_clean');

       
			
            $this->load->library('email');

            $this->email->from($_POST['inputmail'], 'CloudeNotes');
            $this->email->to('gavin@cloudenotes.com');
            $this->email->subject($_POST['email_subject']);
            $this->email->message($_POST['email_message']);

            //set the header information in email
           // $this->email->_set_header( 'From', $this->session->userdata['CN_user_email'] );
            $this->email->_set_header( 'Name',$_POST['inputname'] );
           // $this->email->_set_header( 'Organization', $this->session->userdata['CN_org_name'] );

            if ( $this->email->send() ){
                $data['success_message'] = 'Mail Sent Successfully. Please wait for admin reply!';
                $this->session->set_flashdata( 'success_message', $data['success_message'] );
                redirect(base_url('index.php/contact-us'));
            } else {
                $data['failure_message'] = 'Something wrong with the server. Please try again later!';
                $this->session->set_flashdata( 'failure_message', $data['failure_message'] );
                redirect(base_url('index.php/contact-us'));
            }
       /* if ( $val->run() == false ) {
            $data['errorsss'] = validation_errors();
            $user_login_email   = $this->input->post('user_login_email');
            $user_subject       = $this->input->post('user_email');
            $user_message       = $this->input->post('user_message');
            $data['success_message'] = $this->session->flashdata('success_message');
            $data['failure_message'] = $this->session->flashdata('failure_message');
            $data['error_login']     = $this->session->flashdata('error_login');
            redirect(base_url('contact-us'));
            $this->_render('contact/index', $data, $css_js_for_contact);
        } elseif ( $val->run()) {
            //print_r("ok");
            if ( !$this->dx_auth->login($val->set_value('user_login_email'), $val->set_value('user_login_password'), $val->set_value('remember_me')) ) {
                //var_dump('login failed'); exit;
                $data['error_login'] = 'Username or password is incorrect!';
                $this->session->set_flashdata( 'error_login', $data['error_login'] );
                redirect(base_url('contact-us'));
            }*/
        //}
    }

    /**
     * Institute Registrations view
     */
    public function institute_registrations () {
        $css_js_for_registration = array(
            'codeboxr_css'  => array('dashboard'),
        );
        $this->_render('test/institute-registrations', '', $css_js_for_registration);
    }

    /**
     * Parent/Student Registrations view
     */
    public function parent_student_registrations () {
        $css_js_for_registration = array(
            'codeboxr_css'  => array('dashboard'),
        );
        $this->_render('test/parent_students_registrations', '', $css_js_for_registration);
    }

    /**
     * Teacher Invitation
     */
    public function invite_teacher () {
        $css_js_for_invite_teacher = array(
            'codeboxr_css'  => array('dashboard'),
        );

        $this->_render('test/invite_teacher', '', $css_js_for_invite_teacher);
    }



    public function view_email_template () {
        $this->_render('email/test5.php');
    }

    /**
     * Class view
     */
    public function class_view () {
        $css_js_for_class_view = array(
            'codeboxr_css'  => array('dashboard'),
        );

        $this->_render('test/class_view', '', $css_js_for_class_view);
    }

    /**
     * Student list view for school admin
     */
    public function school_admin_student_list () {
        $css_js_for_school_admin_student_list = array(
            'codeboxr_css'  => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js'   => array ('jquery.dataTables.min')
        );

        $this->_render('test/school_admin_student_list', '', $css_js_for_school_admin_student_list);
    }

    /**
     * Class list view for school admin
     */
    public function school_admin_class_list () {
        $css_js_for_school_admin_class_list = array(
            'codeboxr_css'  => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js'   => array ('jquery.dataTables.min')
        );

        $this->_render('test/school_admin_class_list', '', $css_js_for_school_admin_class_list);
    }

    /**
     * Staff list view for school admin
     */
    public function school_admin_staff_list () {
        $css_js_for_school_admin_staff_list = array(
            'codeboxr_css'  => array('dashboard', 'demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js'   => array ('jquery.dataTables.min')
        );

        $this->load->library('pagination');
        $this->load->model('section_model');
        //$data['login_user_data'] = $this->user_info;

        $limit = $this->section_model->common_for_section_and_assigned_user_list(20)->num_rows();

        $config["base_url"]         = base_url('staff-list');
        $config["total_rows"]       = $limit;
        $config["per_page"]         = 100;
        $config["uri_segment"]      = 2;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 1;

        //echo $this->uri->segment(2); exit;

        $data['assigned_user_list'] = $this->section_model->get_all_assign_user_list_by_organisation_id(20, $config["per_page"], $page);//send organization id ($this->user_info->organisation_id)

        //$data["section_member_list"] = $this->section_member_model->get_section_member_list($config["per_page"], $page);

        //$data['section_member_group'] = $this->section_member_model->join_member_section();
        //print_r($data['section_member_group']); exit;

        $data["pagination"] = $this->pagination->create_links();

        $this->_render('test/school_admin_staff_list', $data, $css_js_for_school_admin_staff_list);
    }
    public function parent_dashboard() {
        $css_js_for_school_admin_staff_list = array(
            'codeboxr_css'  => array('dashboard','demo_page', 'demo_table', 'jquery.dataTables','bootstrap-combined.min'),
            'codeboxr_js'   => array ('jquery.dataTables.min')
        );

        $this->_render('test/parent' ,null, $css_js_for_school_admin_staff_list);
    }

    public function about(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/about' ,null, $css_js);
    }


    public function save_paper(){
        $css_js = array(
            'codeboxr_css'  => array('template','notes-counter'),

        );
        $this->load->model('note_model');
        $data['note_count'] = $this->note_model->note_count();
        $data['length']     = strlen($data['note_count']); //echo $len;
        $data['remaining']  = 6 - $data['length'];
        $data['note_count_show']  = array_map('intval', str_split($data['note_count']));
        for ($i = 0; $i < $data['remaining']; $i++){
            array_unshift($data['note_count_show'], 0);
        }

        $this->_render('home/save-paper' ,$data, $css_js);
    }

    public function privacy(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/privacy' ,null, $css_js);
    }

    public function howItWork(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/how_it_works' ,null, $css_js);
    }
    public function termOfService(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/terms_of_service' ,null, $css_js);
    }

    public function faq(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/faq' ,null, $css_js);
    }
    public function error_not_found(){
        $css_js = array(
            'codeboxr_css'  => array('template'),

        );

        $this->_render('home/error_not_found' ,null, $css_js);
    }

    public function refer_a_friend(){
        $css_js_refer = array(
            'codeboxr_css'  => array('bootstrap-wysihtml5'),
            'codeboxr_js'   => array('wysihtml5-0.3.0', 'bootstrap-wysihtml5')
        );
        $data[] = '';
        $this->load->library('form_validation', '', 'frm_val');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->frm_val->set_rules('name', 'Name', 'trim|xss_clean|required');
            $this->frm_val->set_rules('from', 'Email', 'trim|xss_clean|required|valid_email');
            $this->frm_val->set_rules('fname', 'Friends Name', 'trim|xss_clean|required');
            $this->frm_val->set_rules('to', 'Friends Email', 'trim|xss_clean|required|valid_email');
            //$this->frm_val->set_rules('message', 'Referral Message', 'trim|xss_clean|required');

            if ($this->frm_val->run() == FALSE){
                $data['error'] = $this->getErrors(validation_errors());
            } else{
                $data['fname'] = set_value('fname');
                $data['to'] = set_value('to');
                $data['name'] = set_value('name');
                $data['from'] = set_value('from');
                $data['logo_url'] = base_url('resources/img/cloudenote_header_logo.png');

                $refer_friend_content = $this->load->view('page/email/refer-a-friend', $data, true);
                //$message = $this->ci->load->view('page/email/activation', '', true);
                $this->load->library('email');

                $this->email->from(set_value('from'));
                $this->email->to(set_value('to'));
                $this->email->subject('You have '.set_value('fname'));
                $this->email->message($refer_friend_content);

                if ($this->email->send()) {
                    $this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Referral sent to ' . set_value('to') . ' successfully.</div>');
                } else {
                    //$this->section_model->remove_assigned_info($result->insert_id());
                    $this->session->set_flashdata('error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Critical error on sending invitation. Please <a href="' . base_url('contact-us') . '">contact</a> or provide <a href="' . base_url('feedback') . '">feedback</a> to CloudeNotes Owner.</div>');
                }
                redirect(base_url('refer-a-friend'));
            }
        }

        $this->_render('home/refer-a-friend', $data, $css_js_refer);
    }

}