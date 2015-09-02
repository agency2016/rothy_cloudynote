<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 1:47 PM
 */

class Createclass_Model extends CI_Model {
	public function create_year($creation_info) {
		$parent_info=array('group_id'=>$creation_info['group_id'],'section_id'=>$creation_info['section_id'],'group_name'=>$creation_info['group_name'],'user_id'=>$creation_info['user_id'],'organisation_id'=>$creation_info['organisation_id']);
      	$child_info=array('section_id'=>$creation_info['section_id'],'section_name'=>$creation_info['section_name'],'section_hash_organisation_id'=>md5($creation_info['user_id']),'section_created_date'=>time());
	    if($this->db->insert('section_group', $parent_info) &&  $this->db->insert('section', $child_info)) {
            
            return true;
        } else {
            return false;
        }
    
	}
	
	public function get_year($user_id,$organisation_id){
		$where = array(
            'sg.user_id' 		=>$user_id,
            'sg.organisation_id'   => $organisation_id
        );
		
		$this->db->select('sg.group_name ,sg.group_id,s.section_name,s.section_id');
        $this->db->from('section_group sg');
        $this->db->join('section s', 'sg.section_id = s.section_id');        
        $this->db->where('sg.user_id', $user_id);
        $this->db->where('sg.organisation_id ', $organisation_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
		//$query = $this->db->get('section');
		
		//if ( $query->num_rows() > 0 ){
        //    return $query->result();
       // } else {
       //     return false;
       // }
		//return $query;
	}
	public function years_Add() {
        //If the top level user has not set org name
        //they will redirect to profile editing page.

       
        $data['login_user_data'] = $this->user_info;

        $this->load->library('form_validation', '', 'frm_val');

        $this->frm_val->set_rules('new_section', 'Class Name', 'trim|required|xss_clean|strip_tags|callback_is_section_exist');
        $this->frm_val->set_rules('invite_user_id', 'Teacher Name', 'trim|xss_clean');

        $data['add_class_success'] = $this->session->flashdata('add_class_success');
        $data['add_class_error']   = $this->session->flashdata('add_class_error');

        if ($this->frm_val->run() == false) {
        } else {
            $creation_info = array(
                'section_id'                   => unique_id_generator(),
                'section_hash_organisation_id' => md5($this->user_info->id),
                'section_name'                 => set_value('new_section')
            );

            $assign_info = array();

            if (($accessible_user_info = $this->super_admin->get_user_info(set_value('invite_user_id'))) and ($accessible_user_info->num_rows() == '1')) {
                $assign_info = array(
                    'assign_id'        => unique_id_generator(),
                    'assign_access_id' => $accessible_user_info->row()->hashing_email,
                );
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
	
}

?>