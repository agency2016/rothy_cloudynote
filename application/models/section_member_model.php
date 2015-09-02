<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/13
 * Time: 3:34 PM
 */

class Section_member_model extends CI_Model {


    private function count_all_section_members_by_org($org_id, $pkg_code) {

    }


    /**
     * Checks if there's any data in the section_member table
     *
     * @param $section_member_id
     * @return bool
     */
    public function has_section_member($section_member_id) {
        $query = $this->db->get_where('section_member', array('id' => $section_member_id));
        if($query->num_rows() > 0) {
            return true;
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
    public function create_section_member_info($section_member_info){
        if($this->db->insert('section_member', $section_member_info)) {
            return true;
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
    public function create_section_member_info_from_file($file_info, $section_id, $organization_id){
        $this->load->library('csv_reader');
        $this->load->model('payment_model');
        $this->load->helper('function');

        $this->csv_reader->read( $file_info['full_path'] );
        $row_count = $this->csv_reader->rowCount();

        /*if( $row_count < 6 or $this->session->userdata('CN_user_package_code') == false ) {
            return false;
        }*/

        //Direct Query will be like this
        //INSERT INTO `cb_cloudenote`.`section_member` (`id`, `section_member_first_name`, `section_member_last_name`, `section_member_section_id`, `section_member_fathers_first_name`, `section_member_fathers_last_name`, `section_member_fathers_email`, `section_member_fathers_email_hash`, `section_member_fathers_work_phone`, `section_member_fathers_home_phone`, `section_member_fathers_mobile`, `section_member_fathers_first_address_line`, `section_member_fathers_second_address_line`, `section_member_fathers_zip_code`, `section_member_fathers_city_name`, `section_member_fathers_state_id`, `section_member_fathers_time_zone_id`, `section_member_fathers_country_id`, `section_member_mothers_first_name`, `section_member_mothers_last_name`, `section_member_mothers_email`, `section_member_mothers_email_hash`, `section_member_mothers_work_phone`, `section_member_mothers_home_phone`, `section_member_mothers_mobile`, `section_member_mothers_first_address_line`, `section_member_mothers_second_address_line`, `section_member_mothers_zip_code`, `section_member_mothers_city_name`, `section_member_mothers_state_id`, `section_member_mothers_time_zone_id`, `section_member_mothers_country_id`, `section_member_caregiver_first_name`, `section_member_caregiver_last_name`, `section_member_caregiver_email`, `section_member_caregiver_email_hash`, `section_member_caregiver_work_phone`, `section_member_caregiver_home_phone`, `section_member_caregiver_mobile`, `section_member_caregiver_first_address_line`, `section_member_caregiver_second_address_line`, `section_member_caregiver_zip_code`, `section_member_caregiver_city_name`, `section_member_caregiver_state_id`, `section_member_caregiver_time_zone_id`, `section_member_caregiver_country_id`, `section_member_caregiver_phone_number`, `section_member_group_id`, `section_member_remove`) VALUES ('sdfsdf', 'Kuddus', 'Boati', 'dakjfhdf', 'ssddff', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfdsf', 'fgdfg', 'dfgff', 'dfgdf', 'dfgfdg', 'dfgdfg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgdfg', 'dgfgdf', 'dfgfdg', 'dfgfd', 'gfdgfdg', 'dfgfdg', 'dfgfdg', 'dfgdf', 'gdfgfd', 'gdfgfdg', 'dfgdfg', 'dfgfdg', '0', '0'), ('sdsdffdsf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', '0', '0');
        $data_batch_array = array();
        for($row = 6; $row <=$row_count ; $row++) {
            $single_row_info = array(
                'id' => md5($organization_id.unique_id_generator().$section_id.microtime()),
                'section_member_first_name' => $this->csv_reader->cellValue($row, 1),
                'section_member_last_name' => $this->csv_reader->cellValue($row, 2),
                'section_member_roll_number' => $this->csv_reader->cellValue($row, 3),
                'section_member_email' => $this->csv_reader->cellValue($row, 4),
                'section_member_email_hash' => md5($this->csv_reader->cellValue($row, 4)),
                'section_member_date_of_birth' => $this->csv_reader->cellValue($row, 5),
                'section_member_section_id' => $section_id,
                'section_member_package_code' => 'pk5',//$pkg_code,//Package id from school.
                'section_member_organisation_id' => $this->session->userdata('CN_user_organisation_id'),//Organisation id of uploader.

                'section_member_fathers_first_name' => $this->csv_reader->cellValue($row, 6),
                'section_member_fathers_last_name' => $this->csv_reader->cellValue($row, 7),
                'section_member_fathers_email' => $this->csv_reader->cellValue($row, 8),
                'section_member_fathers_email_hash' => md5( $this->csv_reader->cellValue($row, 8) ),/*
                'section_member_fathers_work_phone' => $this->csv_reader->cellValue($row, 9),
                'section_member_fathers_home_phone' => $this->csv_reader->cellValue($row, 10),
                'section_member_fathers_mobile' => $this->csv_reader->cellValue($row, 11),
                'section_member_fathers_first_address_line' => $this->csv_reader->cellValue($row, 12),
                'section_member_fathers_second_address_line' => $this->csv_reader->cellValue($row, 13),
                'section_member_fathers_zip_code' => $this->csv_reader->cellValue($row, 14),
                'section_member_fathers_city_name' => $this->csv_reader->cellValue($row, 15),
                'section_member_fathers_state_id' => '',
                'section_member_fathers_time_zone_id' => 1,//$this->csv_reader->cellValue($row, $col),
                'section_member_fathers_country_id' => '',*/

                'section_member_mothers_first_name' => $this->csv_reader->cellValue($row, 9),
                'section_member_mothers_last_name' => $this->csv_reader->cellValue($row, 10),
                'section_member_mothers_email' => $this->csv_reader->cellValue($row, 11),
                'section_member_mothers_email_hash' => md5( $this->csv_reader->cellValue($row, 11) ),/*
                'section_member_mothers_work_phone' => $this->csv_reader->cellValue($row, 19),
                'section_member_mothers_home_phone' => $this->csv_reader->cellValue($row, 20),
                'section_member_mothers_mobile' => $this->csv_reader->cellValue($row, 21),
                'section_member_mothers_first_address_line' => $this->csv_reader->cellValue($row, 22),
                'section_member_mothers_second_address_line' => $this->csv_reader->cellValue($row, 23),
                'section_member_mothers_zip_code' => $this->csv_reader->cellValue($row, 24),
                'section_member_mothers_city_name' => $this->csv_reader->cellValue($row, 25),
                'section_member_mothers_state_id' => '',
                'section_member_mothers_time_zone_id' => 1,//$this->csv_reader->cellValue($row, $col),
                'section_member_mothers_country_id' => '',

                'section_member_caregiver_first_name' => $this->csv_reader->cellValue($row, 26),
                'section_member_caregiver_last_name' => $this->csv_reader->cellValue($row, 27),
                'section_member_caregiver_email' => $this->csv_reader->cellValue($row, 28),
                'section_member_caregiver_email_hash' => md5( $this->csv_reader->cellValue($row, 28) ),
                'section_member_caregiver_work_phone' => $this->csv_reader->cellValue($row, 29),
                'section_member_caregiver_home_phone' => $this->csv_reader->cellValue($row, 30),
                'section_member_caregiver_mobile' => $this->csv_reader->cellValue($row, 31),
                'section_member_caregiver_first_address_line' => $this->csv_reader->cellValue($row, 32),
                'section_member_caregiver_second_address_line' => $this->csv_reader->cellValue($row, 33),
                'section_member_caregiver_zip_code' => $this->csv_reader->cellValue($row, 34),
                'section_member_caregiver_city_name' => $this->csv_reader->cellValue($row, 35),
                'section_member_caregiver_state_id' => '',
                'section_member_caregiver_time_zone_id' => 1,//$this->csv_reader->cellValue($row, $col),
                'section_member_caregiver_country_id' => '',

                'section_member_primary_mail_receiver' => $this->csv_reader->cellValue($row, 36),*/

                'section_member_group_id' => 0,
                'section_member_remove' => 0
            );
            $data_batch_array[] = $single_row_info;
        }

        //Use Transaction for , if one row data insert fail then previously inserted data will be wipe
        $this->db->trans_start();//start transaction
        $this->db->insert_batch('section_member', $data_batch_array);//doing batch operation
        $this->db->trans_complete();//stop transaction

        if( $this->db->trans_status() === false ) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * count the row number of section_member table
     * @return mixed
     */
    public function count_section_member(){
        return $this->db->count_all('section_member');
    }

    public function count_all_section_member_by_organisation_id($org_id) {
        $this->db->select( 'COUNT(*) AS total_members' );
        $query = $this->db->get_where( 'section_member', array( 'section_member_organisation_id' => $org_id, 'section_member_remove' => 0 ) );
        $result = $query->result();
        return $result[0]->total_members;
    }

    /**
     * Get all the students list
     * @param $limit
     * @param $start
     * @return bool
     */
    public function get_section_member_list($org_id, $limit='', $start='') {

        if ($limit != '' && $start != ''){
            $this->db->limit($limit, $start);
        }
        $this->db->select('sm.id,sm.section_member_section_id,sm.section_member_first_name,sm.section_member_last_name,sm.section_member_fathers_email,sm.section_member_mothers_email,s.section_name, sg.group_name');
        $this->db->from('section_member sm');
        $this->db->join('section s', 's.section_id = sm.section_member_section_id', 'left');
        $this->db->join('section_group sg', 'sg.section_id = s.section_id', 'left');
        $this->db->where('section_member_organisation_id =', $org_id);
        $this->db->where('section_member_remove =','0');


        $query = $this->db->get();
        /*echo "<pre>";
        print_r($this->db);exit;*/
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_receiver_and_member_list($org_id, $limit='', $start='') {

        if ($limit != '' && $start != ''){
            $this->db->limit($limit, $start);
        }
        $this->db->select('sm.id AS member_id, sm.section_member_section_id, sm.section_member_first_name, sm.section_member_last_name, s.section_name, u.id AS caregiver_id, u.caregiver_unique_id AS caregiver_unique_id, u.first_name, u.last_name, u.email,sg.group_name');
        $this->db->from('section_member sm');
        $this->db->join('section s', 's.section_id = sm.section_member_section_id', 'left');
        $this->db->join('section_group sg', 'sg.section_id = s.section_id', 'left');
        $this->db->join('caregiver_section_member_relationship csmr', 'csmr.section_member_unique_id = sm.id');
        $this->db->join('users u', 'u.caregiver_unique_id = csmr.caregiver_unique_id');
        $this->db->where('sm.section_member_organisation_id = ', $org_id);
        $this->db->where('sm.section_member_remove = ','0');
        $this->db->order_by('sm.id', 'asc');

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_all_section_list_in_org($org){
        $this->db->select('*');
        $this->db->from('section c');
        $this->db->where('c.section_hash_organisation_id =',md5($org));
        $query = $this->db->get();

        if ( $query->num_rows() > 0 ){
            return $query->result();
        } else {
            return false;
        }
    }

    public function updateStudentClass($stu_id, $sec_id, $move_to){
        $this->db->set('section_member_section_id', $move_to);
        //$data = array('section_member_section_id' => $move_to);
        $this->db->where('id =', $stu_id[0]);
        for ($i=1; $i<sizeof($stu_id); $i++){
            $this->db->or_where('id =', $stu_id[$i]);
        }
        $this->db->where('section_member_section_id = ', $sec_id[0]);

        /*$getSize = sizeof($stu_id);
        if ( $getSize > 1 ){
            for( $i=1; $i<$getSize; $i++ ){
                $this->db->and_where('section_member_section_id =', $stu_id[$i]);
            }
        }*/
        $this->db->update('section_member');
        return $this->db->affected_rows();
    }

    /**
     * Load single student data from his id
     * @param $id
     * @return bool
     */
    public function view_single_student_data($id){

        $this->db->select('section.section_name, section_member.section_member_address,
                           section_member.section_member_cell, section_member.section_member_f_name,
                           section_member.section_member_m_name, section_member.id,
                           section_member.section_member_name');
        $this->db->join('section', 'section.section_id = section_member.section_member_group');

        $query = $this->db->get_where('section_member', array('id' => $id));

        if ($query->num_rows() == 1){
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_students(){
        $query = $this->db->get('section_member');
        /*$query =  $this->db->get('section_member');*/
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }
// section_member_remove is set to 1 temporarily deleted
    public function deleteStudent($student_id){
       ///$this->output->enable_profiler(TRUE);
        $this->db->set('section_member_remove', '1');
        $this->db->where_in('id', $student_id);
        $this->db->update('section_member');
        //print_r($this->db);
        return $this->db->affected_rows();
    }
    // section_remove is set to 1 temporarily deleted and class unassigned in section_member
    public function unAssignClass($class_id){
        // $this->output->enable_profiler(TRUE);
        $this->db->set('section_member_section_id', 0);
        $this->db->where_in('section_member_section_id', $class_id);
        $this->db->update('section_member');
        //print_r($this->db);
        return $this->db->affected_rows();
    }

    public function get_section_member_data_of_parent($organisation_id,$caregiver_unique_id) {
        //$this->db->select('sm.id,sm.section_member_first_name');

        $this->db->select('csmr.section_member_unique_id,sm.id as section_member_id,sm.section_member_first_name,sm.section_member_last_name,sm.section_member_gender,sm.section_member_date_of_birth,sm.section_member_allergie,sm.section_member_special,sm.image_ext');
        $this->db->from('section_member sm');
        $this->db->join('caregiver_section_member_relationship  csmr', 'csmr.section_member_unique_id = sm.id');
        $this->db->where('sm.section_member_organisation_id =', $organisation_id);
        $this->db->where('csmr.caregiver_unique_id =', $caregiver_unique_id);
        $this->db->where('section_member_remove =','0');


        $query = $this->db->get();
       /* $this->output->enable_profiler(TRUE);
               echo "<pre>";
               print_r($this->db);*/
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function updateChild($getUpdateChild){
       //$this->output->enable_profiler(TRUE);
       $section_member_id=$getUpdateChild['section_member_id'];

        unset($getUpdateChild['section_member_id']);
        $this->db->where('id', $section_member_id);
        $this->db->update('section_member', $getUpdateChild);
      /* echo "<pre>";
        print_r($this->db);
        exit();*/

        if($this->db->affected_rows()) {
            return true;
        }
        return false;
    }
    public function update_user_image_extnsn($ImageExt,$caregiver_id) {

        $this->db->where('id', $caregiver_id);
        $this->db->set('image_ext', $ImageExt);
        $this->db->update('section_member');
        /* $this->output->enable_profiler(TRUE);
                 echo "<pre>";
                 print_r($this->db);*/
        if($this->db->affected_rows()) {
            return true;
        }
        return false;

    }
    public function edit_section_member($student_id){
        $this->db->select('sm.id as section_member_id,sm.section_member_first_name,sm.section_member_last_name,sm.section_member_gender,sm.section_member_date_of_birth,sm.section_member_allergie,sm.section_member_special,sm.image_ext');
        $this->db->from('section_member sm');
        $this->db->where('id =', $student_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }


    }

}