<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 5:00 PM
 */

class User_model extends CI_Model {


    /*public function check_user_information($user_name, $user_pass) {
        $user_info = $this->mongo_db->select(array('email', 'user_name'))->where(
            array(
                'user_name' => $user_name,
                'password' => md5($user_pass)
            )
        )->get('user_list');

        if(count($user_info) > 0) {
            return $user_info[0];
        } else {
            return false;
        }
    }

    public function register_user_information($user_name, $email, $password) {
        $user_info = array(
            'user_name' => $user_name,
            'email' => $email,
            'password' => md5($password)
        );

        ///var_dump($user_info);

        if($this->mongo_db->insert('user_list', $user_info)) {
            return $user_info;
        } else {
            return false;
        }
    }

    public function check_user_availability($user_name, $email) {
        $return_info = array('type' => 'success', 'have_user_name' => '', 'have_email' => '');
        $user_info = $this->mongo_db->select(array('user_name'))->where('email', $email)->get('user_list');
        if(!empty($user_info)) {
            $return_info['type'] = 'error';
            $return_info['have_email'] = 'This email already use. Please try with new one.';
        }

        $user_info = $this->mongo_db->select(array('email'))->where('user_name', $user_name)->get('user_list');
        if(!empty($user_info)) {
            $return_info['type'] = 'error';
            $return_info['have_user_name'] = 'Username already exist.';
        }

        return $return_info;
    }*/

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function getRegIns(){
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('user_transaction ut', 'ut.organisation_id = u.id', 'left');
        $this->db->join('package_list pl', 'pl.package_code = ut.package_code', 'left');
        $this->db->where('u.id = u.organisation_id');

        $result = $this->db->get();
        if ($result->num_rows() > 0){
            return $result->result();
        } else {
            return false;
        }
    }

    public function getAllSectionMember() {
        $this->db->select('*');
        $this->db->from('section_member sm');
        $this->db->join('users u', 'u.id = sm.section_member_organisation_id','left');
        $result = $this->db->get();

        if ($result->num_rows() > 0){
            return $result->result();
        } else {
            return false;
        }
    }

    public function has_in_temp_user($email) {
        $this->load->model('dx_auth/user_temp');
        $this->user_temp->prune_temp();
        $query = $this->db->get_where('user_temp', array('email' => $email));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function has_in_user($email) {
        $query = $this->db->get_where('users', array('email' => $email));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function has_this_organisation($user_id) {
        $query = $this->db->get_where('users', $array = array('id' => $user_id, 'user_access_level' => 3));
        if($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_all_section_list() {
        return $this->db->get_where('section', array('section_hash_organisation_id' => md5($this->session->userdata('DX_user_id'))));
    }

    public function enable_authorised_access_for_current_user($organisation_id, $section_id, $invited_hashed_email) {
        $this->load->model('super_admin');
        $org_info = $this->super_admin->get_user_info( $organisation_id )->row();
        $this->db->set('assign_hit', '1');
        $this->db->set('assign_status_id', '2');
        $this->db->where('assign_access_id', $invited_hashed_email);
        $this->db->where('assign_section_id', $section_id);
        $this->db->update('assign_section');
        if($this->db->affected_rows() == '1') {
            $this->session->set_userdata('CN_org_name', $org_info->organisation_name);
            $this->db->set('organisation_name', $org_info->organisation_name);
            $this->db->set('organisation_id', $organisation_id);
            $this->db->set('package_code', $org_info->package_code);
            $this->db->where('hashing_email', $invited_hashed_email);
            $this->db->update('users');
            return true;
        } else {
            return false;
        }
    }
    public function update_staff_class($assignid,$assignstaff, $classid,$stafforg,$classog){
       // var_dump($stu_id);
       // var_dump($sec_id);
        //var_dump($move_to);
        $assign_info['assign_section_id']=$classid;//class id
        $assign_info['assign_access_id']=$assignstaff;//staff id
        $assign_info['assign_id']=$assignid;
        $assign_info['assign_organisation_id']=$stafforg;//teacher er org
        $assign_info['assign_group_id']=$classog;// class er org
        $this->db->set('assign_creation_date', 'NOW()', false);
        $this->db->insert('assign_section', $assign_info);
        if($this->db->affected_rows() == '1') {
            return $this->db;
        } else {
            return false;
        }
    }

    //update logged parentProfile
    public function update_user($user_data) {
        $user_id = $user_data['id'];
        unset($user_data['id']);
        $this->db->where('id', $user_id);
        $this->db->update('users', $user_data);
        if($this->db->affected_rows()) {
            return true;
        }
        return false;
    }

    //get the child of logged parent
    public function get_parent_of_child($child_unique_ids,$caregiver_unique_id) {
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('caregiver_section_member_relationship  csmr', 'csmr.caregiver_unique_id = u.caregiver_unique_id');
        $this->db->where('u.caregiver_unique_id !=', $caregiver_unique_id);
        $this->db->where('csmr.section_member_unique_id =', $child_unique_ids);

        $query = $this->db->get();
        /* $this->output->enable_profiler(TRUE);
                echo "<pre>";
                print_r($this->db);*/
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function get_relation_with_child() {
        return $this->db->get('relation_with_child')->result();
    }
    public function update_user_image_extnsn($ImageExt,$user_id) {

        //$this->db->where('caregiver_unique_id', $caregiver_id);
        $this->db->where('id', $user_id);
        $this->db->set('image_ext', $ImageExt);
        $this->db->update('users');
      /* $this->output->enable_profiler(TRUE);
                echo "<pre>";
                print_r($user_id);*/
        if($this->db->affected_rows()) {
            return true;
        }
        return false;

    }

    //delete staff
    public function deleteUser($user_id) {
        $this->db->set('user_remove', 1);
        $this->db->where_in('id', $user_id);
        $this->db->update('users');
        //print_r($this->db);
        if($this->db->affected_rows()) {
            return true;
        }
        return false;

    }

    public function get_user_info($user_id) {
        $this->db->select('u.id,u.first_name,u.last_name,u.email,u.hashing_email,u.mobilephone,u.image_ext');
        $this->db->from('users u');
        $this->db->where('id =', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function get_user_organisation($user_id) {
        $this->db->select('u.organisation_id');
        $this->db->from('users u');
        $this->db->where('email =', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->organisation_id;
        } else {
            return false;
        }
    }

    public function get_user_details($user_id) {
        $this->db->select('u.id,u.first_name,u.last_name,u.email');
        $this->db->from('users u');
        $this->db->where_in('id ', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_user_details_more($user_id) {
        $this->db->select('u.id,u.first_name,u.last_name,u.email,u.organisation_name');
        $this->db->from('users u');
        $this->db->where_in('id ', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /**
     * Insert member information into database section_member table
     *
     * @param $section_member_info
     * @return bool
     */
    public function create_staff_info_from_file($file_info, $organization_id){
        $this->load->library('csv_reader');
        $this->load->helper('function');
        $this->csv_reader->read( $file_info['full_path'] );
        $row_count = $this->csv_reader->rowCount();




        //Direct Query will be like this
        //INSERT INTO `cb_cloudenote`.`section_member` (`id`, `section_member_first_name`, `section_member_last_name`, `section_member_section_id`, `section_member_fathers_first_name`, `section_member_fathers_last_name`, `section_member_fathers_email`, `section_member_fathers_email_hash`, `section_member_fathers_work_phone`, `section_member_fathers_home_phone`, `section_member_fathers_mobile`, `section_member_fathers_first_address_line`, `section_member_fathers_second_address_line`, `section_member_fathers_zip_code`, `section_member_fathers_city_name`, `section_member_fathers_state_id`, `section_member_fathers_time_zone_id`, `section_member_fathers_country_id`, `section_member_mothers_first_name`, `section_member_mothers_last_name`, `section_member_mothers_email`, `section_member_mothers_email_hash`, `section_member_mothers_work_phone`, `section_member_mothers_home_phone`, `section_member_mothers_mobile`, `section_member_mothers_first_address_line`, `section_member_mothers_second_address_line`, `section_member_mothers_zip_code`, `section_member_mothers_city_name`, `section_member_mothers_state_id`, `section_member_mothers_time_zone_id`, `section_member_mothers_country_id`, `section_member_caregiver_first_name`, `section_member_caregiver_last_name`, `section_member_caregiver_email`, `section_member_caregiver_email_hash`, `section_member_caregiver_work_phone`, `section_member_caregiver_home_phone`, `section_member_caregiver_mobile`, `section_member_caregiver_first_address_line`, `section_member_caregiver_second_address_line`, `section_member_caregiver_zip_code`, `section_member_caregiver_city_name`, `section_member_caregiver_state_id`, `section_member_caregiver_time_zone_id`, `section_member_caregiver_country_id`, `section_member_caregiver_phone_number`, `section_member_group_id`, `section_member_remove`) VALUES ('sdfsdf', 'Kuddus', 'Boati', 'dakjfhdf', 'ssddff', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfdsf', 'fgdfg', 'dfgff', 'dfgdf', 'dfgfdg', 'dfgdfg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgdfg', 'dgfgdf', 'dfgfdg', 'dfgfd', 'gfdgfdg', 'dfgfdg', 'dfgfdg', 'dfgdf', 'gdfgfd', 'gdfgfdg', 'dfgdfg', 'dfgfdg', '0', '0'), ('sdsdffdsf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', '0', '0');
        $data_batch_array = array();
        for($row = 4; $row <=$row_count ; $row++) {
            $single_row_info = array(
                'id' =>'',
                'organisation_name' => $this->session->userdata('CN_org_name'),
                'first_name' => $this->csv_reader->cellValue($row, 1),
                'last_name' => $this->csv_reader->cellValue($row, 2),
                'email' => $this->csv_reader->cellValue($row, 4),
                'hashing_email' => md5($this->csv_reader->cellValue($row, 4)),
                'organisation_id' => $this->session->userdata('CN_user_organisation_id'),
                'user_access_level' => '4',
                'user_remove' => '0',//$pkg_code,//Package id from school.
                'invited_id' => '1',
                'created'=>date('Y-m-d H:m:s')
            );
           // echo "<pre>";print_r($this->isEmailExist($single_row_info['email']));exit();
            if(!$this->isEmailExist($single_row_info['email'])){
                $data_batch_array[] = $single_row_info;
            }
            else{
                return 2;
            }
        }

       // echo "<pre>";print_r($data_batch_array);exit();

        //Use Transaction for , if one row data insert fail then previously inserted data will be wipe
        $this->db->trans_start();//start transaction
        $this->db->insert_batch('users', $data_batch_array);//doing batch operation
        $this->db->trans_complete();//stop transaction

        if( $this->db->trans_status() === false ) {
            return 0;
        } else {
            return 1;
        }

    }

    public function create_new_staff($data) {
        if( $this->db->insert('users', $data) ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function isEmailExist($email) {

        $this->db->where('email', $email);
        $query = $this->db->get('users');
      //  print_r($this->db);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

      

}