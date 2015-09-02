<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/11/13
 * Time: 4:53 PM
 */
class Createclass extends My_Controller {
    private $user_info = '';
    private $css_js_array = array('codeboxr_css' => array('super-admin','template'), 'codeboxr_js' => array('bootstrap-alert','app' /*, 'bootstrap-dropdown'*/));



    public function __construct(){
        parent::__construct($this->css_js_array);
        $this->load->model('payment_model');
        $this->load->library('braintree_ci');
		$this->load->helper('function');
        $this->load->model(array('note_model', 'user_model', 'super_admin'));
        if ($user_info = $this->super_admin->get_user_info($this->session->userdata('DX_user_id'))) {
            $this->user_info = $user_info->row();
        } else {
            $this->session->sess_destroy();
            show_error('A critical error was found in system. Please try to login again.');
        }
        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }
    }
    public function profile() {
        $data['login_user_data'] = $this->user_info;
        $this->_render_admin('user/view_profile', $data);
    }

    public function savestudent() {
	 	 	
	$this->load->model(array('section_member_model'));
	if ($this->input->post('not_import_students')) {
		echo 'i am mad';
		redirect(base_url('addsuccess'));
	}
	 if ($this->input->post('import_students')) {	 				
					$this->load->library('session');
	 				$stddata = $this->input->post();
					$input_number_cb = (int)(count($stddata)/3);
					//var_dump($stddata);
					$year_array = array();
		for($x=0; $x < $input_number_cb;$x++){
			
			$section_id = $this->input->post('sectioninfo-'.$x);			
			$group_id = $this->input->post('groupinfo-'.$x);
			array_push($year_array,$group_id);
			$config['upload_path']   = './upload';
            $config['allowed_types'] = 'csv';
            $config['overwrite']     = true;
            $config['file_name']     = md5(rand().time().rand().$this->session->userdata('CN_user_email_hash'));
           $name='files'.$x;
		  
		    $this->load->library('upload', $config);
					if ($this->upload->do_upload($name)) {
                        //get uploaded file info.
                        $file_info = $this->upload->data();
						
						 if ($this->section_member_model->create_section_member_info_from_file($file_info, $section_id, $this->session->userdata('CN_user_organisation_id'))) {
                       	     
                       		$count = $this->section_member_model->count_all_section_member_by_organisation_id($this->session->userdata('CN_user_organisation_id'));
                        	$success = true;
						 } else {
						 	$success = false;
                          
                        }
					}
				else{
					  $success = false;
					  $data['add_member_error'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>'; //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
				}
		
			}
			if($success){
				$years = array_unique($year_array);
				$this->session->set_flashdata('add_member_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Member added successfully.</div>');
				$this->session->set_flashdata('result_msg', '<span>Congratulations !You have now successfully added:</span>');
				$this->session->set_flashdata('student_count', '<span>'.$count.'Students are added in your organisation.</span>');
				$this->session->set_flashdata('year_count', '<span>'.count($years).'Years</span>');
				$this->session->set_flashdata('class_count', '<span>'.$input_number_cb.'Class</span>');
				redirect(base_url('addsuccess'));
			}
			else{
				redirect(base_url('addstudents'));
				$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>'); //$this->session->set_flashdata('add_member_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
			}
			//var_dump($count);
			 // redirect(base_url('index.php/addsuccess'));
		}
	 }

public function savestaff() {
		
		  $css_js_array = array(
            'codeboxr_js' => array('underscore-min', 'bootstrap-tab', 'bootstrap-filestyle.min', 'bootstrap.wizard.min', 'section-member', 'jquery.form.min', 'ajaximageupload','jquery.validate')
        );
        $this->load->library('form_validation', '', 'frm_val');
        $this->load->model(array('user_model'));
        $allowed_to_add_staff = true;

      
		

        if ($this->input->post('import_staff')) {
        	if($this->input->post('datafilename') == ''){
        		$this->session->set_flashdata('add_staff_wrong', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Alert! </strong>Please Upload A File.</div>');
				redirect(base_url('addstaff'));
        	}
        	//var_dump('$expression');
            $config['upload_path']   = './upload/staff-csv-doc';
            $config['allowed_types'] = 'csv';
            $config['overwrite']     = true;
            $config['file_name']     = md5(time() . $this->session->userdata('CN_user_email_hash'));
            $this->load->library('upload', $config);
            // print_r($this->upload->do_upload('staffs')); print_r('ccvb');exit;
            //$this->debug($this->input->post('section_id'));
            if ($this->upload->do_upload('members')) {
                //get uploaded file info.
                $file_info = $this->upload->data();

                //try to batch operation for uploaded section member info.
                if ($this->user_model->create_staff_info_from_file($file_info, $this->session->userdata('CN_user_organisation_id'))) {
                   	 	
                   	 $this->session->set_flashdata('add_staff_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Staff added successfully.</div>');
                	 redirect(base_url('addstudents'));
				} else {
                   $this->session->set_flashdata('add_staff_wrong', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Alart! Not Inserted.Something Wrong.Please Try Again</strong></div>');
					redirect(base_url('addstaff'));
                }

                @unlink($file_info['full_path']);
            } else {
            	
          			$this->session->set_flashdata('add_staff_wrong', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Alart! Not Inserted.Something Wrong.Please Try Again</div>');
          			redirect(base_url('addstaff'));
		    }

        } 
        
        if ($this->input->post('add_staffs')) {
           /* $this->frm_val->set_rules('first_name', ' First Name', 'trim|xss_clean|strip_tags|alpha|required');
            $this->frm_val->set_rules('last_name', 'Last Name', 'trim|xss_clean|strip_tags|alpha|required');
            $this->frm_val->set_rules('email', 'Email', 'trim|xss_clean|strip_tags|valid_email|callback_isEmailExist|required');

            if ($this->frm_val->run() == false) {
                $data['message'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>' . validation_errors() . '</div>';

            } else {*/
           //echo 'i am here';
		    $staffs = $this->input->post();
		   	$cbstaffcount =(int)((count($staffs)/3));
		   	for($x=1;$x <=$cbstaffcount;$x++){
		   		$email = $this->input->post('email_'.$x);
		   		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
				  {
				  	$emailErr =true;
				  }
				if( $this->input->post('firstname_'.$x) == '' || $this->input->post('lastname_'.$x) == '' || $emailErr == true){
					$this->session->set_flashdata('add_staff_wrong', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Alart! Insert All Fields .Insert Emails Properly.Please Try Again</strong></div>');
					redirect(base_url('addstaff'));
				}	   		
                $single_row_info = array(
                    'first_name'        => $this->input->post('firstname_'.$x),
                    'last_name'         => $this->input->post('lastname_'.$x),
                    'email'             => $this->input->post('email_'.$x),
                    'hashing_email'     => md5( $this->input->post('email_'.$x)),
                    'organisation_name' => $this->session->userdata('organisation_name'),
                    'organisation_id'   => $this->session->userdata('CN_user_organisation_id'),                    
                    'user_access_level' => '4',
                    'user_remove'       => '0',
                    'invited_id'       => '1',

                );
				//var_dump($single_row_info);
				  if ($this->user_model->create_new_staff($single_row_info)) {
                   	//echo 'he;';$
                   	$cbsucess = true;
					 
                } else {
                   $cbsucess = false;
                  

                }
				
                //$user_id = $this->user_model->create_new_staff($single_row_info);
		   	}
				if($cbsucess){
					$this->session->set_flashdata('add_staff_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>'.$cbstaffcount.'Staff added successfully.</div>');
					 redirect(base_url('addstudents'));	
				}
				else{
					 $this->session->set_flashdata('add_staff_wrong', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Alart! Not Inserted.Something Wrong.Please Try Again</div>');
					 redirect(base_url('addstaff'));
				}

            }
       // }

      

	}
	
   public function saveclass() {
      $this->load->library('session');
	  $user_id = $this->session->userdata('DX_user_id');
	  $organisation_id = $this->session->userdata('CN_user_organisation_id');
	  $this->load->model('user_model');
	  //var_dump($session_id2);
	 // var_dump($session_id);
	if($user_id > 0){
	 $classdata = array (); 
	 $classdata = $this->input->post();
	
	  $post = array();
		foreach ( $_POST as $key => $value )
		{
			if($value == '')	{
				 $this->session->set_flashdata('add_class_fill_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Please Fill All The Fields.</div>');
          		redirect(base_url('/setupschool'));
			}
		    $post[$key] = $this->input->post($key);
		}
		$parent_array = array();
		$child_array = array();
		
		foreach ( $post as $key => $value )
		{
		  if (strpos($key,'parent') !== false) {  			 
			  $parent_array[$key]=$value;
			} 
		  elseif (strpos($key,'parent') == false) {
				  $child_array[$key] = $value;
				  $pattern = '/_p_/';
				  $string = $key;					
				  preg_match($pattern, $string, $matches, PREG_OFFSET_CAPTURE);			
				  $length=strlen($string)-1;				
				  $parent_id= substr($string,($matches[0][1]+3),$length);			
				
					foreach($classdata as $parentkey => $parentvalue){
						if($parentkey =='parent_new_'.$parent_id){
							  $return_value =  $parentvalue;							
							  $creation_info = array(
					                'group_id'                   => unique_id_generator(). rand(). time(),               
					                'group_name'                 => $return_value,
					                'section_id'				 => unique_id_generator(). rand(). time(), 
					                'section_name'				 =>$value,
					                'user_id'					 =>$user_id,
					                'organisation_id'             =>$organisation_id
					            );
								$this->load->model('createclass_model');								
		 						$this->createclass_model->create_year($creation_info);		  
		  						$insert=true;							
						}
						else {
							$return_value = '';
						}						
					}			
    		  }		  	  
		}
		
		/*foreach ( $parent_array as $key => $value )
		{
			
		  $creation_info = array(
                'group_id'                   => unique_id_generator(). rand(). time(),               
                'group_name'                 => $value
            );
			//var_dump($creation_info);
		  $this->load->model('createclass_model');
		  $this->createclass_model->create_year($creation_info);
		  
		  	$insert=true;
		 
		}*/
		  

            if ($insert) {
                $this->session->set_flashdata('add_class_success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success! </strong>Class added successfully.</div>');
            	redirect(base_url('/addstaff'));
			} else {
                $this->session->set_flashdata('add_class_error', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>Something went wrong. Please try again.</div>');
          		redirect(base_url('/setupschool'));
		    }
            
		
		
		}
		else{
				
			$this->session->set_flashdata('add_class_notpermitted', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Alert! </strong>Not A Logged In USER.Cant Add Data.</div>');
			redirect(base_url('setupschool'));
		}
    } 
   
	public function create_class_view() {
        $data['login_user_data'] = $this->user_info;
	  
        $css_js_for_contact = array(
            'codeboxr_js' => array('jquery','jquery.validate.min','app','bootstrap.min'),
             'codeboxr_css' => array('bootstrap.min','bootstrap-responsive.min','font-awesome','template'),
        );
        $this->_render_admin('setupschool/createclass',$data);
    }
	public function add_staff() {
        $data['login_user_data'] = $this->user_info;
        $css_js_for_pricing = array(
            'codeboxr_css' => array(),
            'codeboxr_js' => array()
        );
        $this->_render_admin('setupschool/addstaff',$data);
    }
	public function add_students() {

		$this->load->library('session');
	    $user_id = $this->session->userdata('DX_user_id');
	    $organisation_id = $this->session->userdata('CN_user_organisation_id');
		
		$this->load->model('createclass_model');
		$datas = $this->createclass_model->get_year($user_id,$organisation_id);
        $css_js_for_pricing = array(
            'codeboxr_css' => array(),
            'codeboxr_js' => array()
        );
		$class_data=array();
		foreach($datas as $key=>$data){
			$class_data['data'.$key] = array($data);
		}
        $class_data['login_user_data'] = $this->user_info;
		$class_data['size']=(count($class_data)-1);
        $this->_render_admin('setupschool/addstudents',$class_data);
    }
	public function setup_school_success() {
        $data['login_user_data'] = $this->user_info;
      //  $data['page_title'] = 'Set Up';
        $css_js_for_pricing = array(
            'codeboxr_css' => array(),
            'codeboxr_js' => array()
        );
        $this->_render_admin('setupschool/setupschoolsuccess',$data);
    }
   
}
 

