<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/10/13
 * Time: 1:07 PM
 */


class Section_model extends CI_Model {

    public function common_for_section_and_assigned_user_list($org_id, $limit='', $start='') {

        if ($limit != '' && $start != '') $this->db->limit($limit, $start);
        $this->db->select('u.id as user_id,asgn.assign_section_id,asgn.assign_section_id,asgn.assign_access_id, asgn.assign_creation_date, u.invited_id, u.first_name, u.last_name, u.organisation_name, ins.invite_status_name, s.section_name,u.email,u.mobilephone,sg.group_name');
        $this->db->from('users u');
        $this->db->join('invite_status ins', 'ins.invite_id = u.invited_id', 'left');
        $this->db->join('assign_section asgn', 'asgn.assign_access_id = u.hashing_email', 'left');
        $this->db->join('section s', 's.section_id = asgn.assign_section_id', 'left');
        $this->db->join('section_group sg', 'sg.section_id = s.section_id', 'left');
        $this->db->where('u.organisation_id', $org_id);
        $this->db->where('u.user_access_level =', '4');
        $this->db->where('u.user_remove =', '0');
        $this->db->or_where('asgn.assign_section_id =u.hashing_email');


       /* echo "<pre>";
        print_r($this->db);exit;*/
        return $this->db->get();
        //print_r($this->db);
        //echo $this->db->last_query();//exit;
    }


    public function common_for_section_member_and_assigned_user_list($org_id='', $limit='', $start='') {
       /* $sql = "SELECT *
            FROM (
            (
            SELECT c.section_name, t.first_name, c.section_id AS class_id
            FROM section c
            LEFT JOIN assign_section AS asgn_t ON asgn_t.assign_section_id = c.section_id
            LEFT JOIN users t ON t.hashing_email = asgn_t.assign_access_id
            LEFT JOIN invite_status ins ON ins.invite_id = asgn_t.assign_status_id
            WHERE c.section_hash_organisation_id =  md5($org_id)
            )A
            LEFT JOIN (

            SELECT sm.section_member_section_id, COUNT( sm.section_member_section_id ) AS counts
            FROM section_member sm
            LEFT JOIN section c ON c.section_id = sm.section_member_section_id
            GROUP BY sm.section_member_section_id
            ) AS m ON m.section_member_section_id = A.class_id
            )";*/
        //change made by ridhia i do not joined invite_status cause database is changed if needed then do new sql please
        /*$sql = "SELECT *
            FROM (
            (
            SELECT c.section_name, t.first_name, c.section_id AS class_id
            FROM section c
            LEFT JOIN assign_section AS asgn_t ON asgn_t.assign_section_id = c.section_id
            LEFT JOIN users t ON t.hashing_email = asgn_t.assign_access_id
            WHERE c.section_hash_organisation_id =  md5($org_id)
            )A
            LEFT JOIN (
            SELECT sm.section_member_section_id, COUNT( sm.section_member_section_id ) AS counts
            FROM section_member sm
            LEFT JOIN section c ON c.section_id = sm.section_member_section_id
            GROUP BY sm.section_member_section_id
            ) AS m ON m.section_member_section_id = A.class_id
            )";*/
        $sql = "SELECT *
                FROM (
                (
                SELECT c.section_name, t.first_name, c.section_id AS class_id
                FROM section c
                LEFT JOIN assign_section AS asgn_t ON asgn_t.assign_section_id = c.section_id
                LEFT JOIN users t ON t.hashing_email = asgn_t.assign_access_id
                WHERE c.section_hash_organisation_id =  md5($org_id)
                )A

                LEFT JOIN section_group sg ON class_id =sg.section_id

                LEFT JOIN (
                SELECT total_student,parent_joined,ts.section_member_section_id
                FROM
                (SELECT count( DISTINCT (
                sm.id
                ) ) AS total_student, sm.section_member_section_id, u.invited_id
                FROM section_member sm
                LEFT JOIN caregiver_section_member_relationship csmr ON sm.id = csmr.section_member_unique_id
                LEFT JOIN users u ON csmr.caregiver_unique_id = u.caregiver_unique_id
                GROUP BY sm.section_member_section_id)ts


                LEFT JOIN (
                SELECT count( DISTINCT (
                sm.id
                ) ) AS parent_joined, sm.section_member_section_id, u.invited_id
                FROM section_member sm
                LEFT JOIN caregiver_section_member_relationship csmr ON sm.id = csmr.section_member_unique_id
                LEFT JOIN users u ON csmr.caregiver_unique_id = u.caregiver_unique_id
                WHERE u.invited_id = '3'
                GROUP BY sm.section_member_section_id
                )pj ON pj.section_member_section_id = ts.section_member_section_id) AS m ON m.section_member_section_id = A.class_id
                )";

        $limit_cond = ($limit != '' && $start != '') ? "limit $start, $limit" : "";
        $sql = $sql.$limit_cond;
        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            //return $query;
            $res = array( 'row' => $query->num_rows(), 'result' => $query->result() );
            return $res;
        } else {
            return false;
        }
    }

    /**
     * It's not in use but will need it in future
     * @param $getAjaxData
     * @return bool
     */
    public function getClassList($getAjaxData){
        $this->db->select('section_name');
        $this->db->from('section');
        $this->db->where('section_id', $getAjaxData);
        $query = $this->db->get();

        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_section_group($getAjaxData){
        $this->db->select('group_id');
        $this->db->from('section_group');
        $this->db->where('section_id', $getAjaxData);
        $query = $this->db->get();

        if ($query->num_rows() > 0){
            return $query->row()->group_id;
        } else {
            return false;
        }
    }
    public function updateStudentClass($ajaxData, $moveTo){
        $data = array('section_member_section_id' => $moveTo);
        $this->db->where('section_member_section_id =', $ajaxData[0]);
        $getSize = sizeof($ajaxData);
        if ( $getSize > 1 ){
            for( $i=1; $i<$getSize; $i++ ){
                $this->db->or_where('section_member_section_id =', $ajaxData[$i]);
            }
        }
        $this->db->update('section_member', $data);
        return $this->db->affected_rows();
    }

    public function has_section($section_id, $org_id = '') {
        if($org_id == '') {
            $query = $this->db->get_where('section', array('section_id' => $section_id));
            if($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $query = $this->db->get_where('section', array('section_id' => $section_id, 'section_hash_organisation_id' => md5($org_id)));
            if($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function has_section_by_name($section_name, $organiser_id) {
        $this->db->like('section_name', $section_name, 'none');
        $query = $this->db->get_where('section', array('section_hash_organisation_id' => $organiser_id));
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function create_section_and_assign_to($creation_info, $assign_info) {
        if($this->db->insert('section', $creation_info)) {
            if(count($assign_info) > 0) {
                $assign_info['assign_class_id'] = $this->db->insert_id();
                $this->db->insert('assign_section', $assign_info);
            }
            return true;
        } else {
            return false;
        }
    }

    public function assign_section($assign_info) {
        $this->db->set('assign_creation_date', 'NOW()', false);
        $this->db->insert('assign_section', $assign_info);
        if($this->db->affected_rows() == '1') {
            return $this->db;
        } else {
            return false;
        }
    }

    public function is_already_assigned($assign_email, $section_id) {
        $query = $this->db->get_where('assign_section', array('assign_access_id' => md5($assign_email), 'assign_section_id' =>$section_id));
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_all_section_list_by_organise_id($org_id) {
        return $this->db->get_where('section', array('section_hash_organisation_id' => md5($org_id)));
    }

    public function get_all_section_list_by_assigned_id() {
        $where = array(
            'asgn.assign_access_id' => $this->session->userdata('CN_user_email_hash'),
            'asgn.assign_hit'       => '1'
        );

        $this->db->select('asgn.assign_section_id AS section_id, s.section_name');
        $this->db->join('section s', 's.section_id = asgn.assign_section_id', 'inner');
        return $this->db->get_where('assign_section asgn', $where);
    }

    public function get_all_assign_section_list_by_assigned_user_id() {

        $access_id = $this->session->userdata('CN_user_email_hash');
        $sql = "SELECT * FROM ((SELECT DISTINCT `asgn`.`assign_section_id`, `asgn`.`assign_creation_date`, `asgn`.`assign_status_id`, `asgn`.`assign_access_id`, `u`.`first_name`,`u`.`last_name`, `ins`.`invite_status_name`, `s`.`section_name` FROM (`assign_section` asgn) INNER JOIN assign_section asgn2 ON asgn2.assign_section_id = asgn.assign_section_id LEFT JOIN `section` s ON `s`.`section_id` = `asgn`.`assign_section_id` LEFT JOIN `users` u ON `u`.`hashing_email` = `asgn`.`assign_access_id` LEFT JOIN `invite_status` ins ON `ins`.`invite_id` = `asgn`.`assign_status_id`) AS R) WHERE R.assign_section_id IN (SELECT assign_section_id FROM (SELECT DISTINCT `asgn`.`assign_section_id`, `asgn`.`assign_access_id`, `u`.`first_name`, `ins`.`invite_status_name`, `s`.`section_name` FROM (`assign_section` asgn) INNER JOIN assign_section asgn2 ON asgn2.assign_section_id = asgn.assign_section_id LEFT JOIN `section` s ON `s`.`section_id` = `asgn`.`assign_section_id` LEFT JOIN `users` u ON `u`.`hashing_email` = `asgn`.`assign_access_id` LEFT JOIN `invite_status` ins ON `ins`.`invite_id` = `asgn`.`assign_status_id`) AS T WHERE assign_access_id = '$access_id');";
        //$sql = "SELECT * FROM ((SELECT DISTINCT 'asgn'.'assign_section_id', 'asgn'.'assign_access_id', 'u'.'first_name','u'.'last_name','ins'.'invite_id', 'ins'.'invite_status_name', 's'.'section_name' FROM ('assign_section' asgn) INNER JOIN assign_section asgn2 ON asgn2.assign_section_id = asgn.assign_section_id LEFT JOIN 'section' s ON 's'.'section_id' = 'asgn'.'assign_section_id' LEFT JOIN 'users' u ON 'u'.'hashing_email' = 'asgn'.'assign_access_id' LEFT JOIN 'invite_status' ins ON 'ins'.'invite_id' = 'asgn'.'assign_status_id')) AS R WHERE R.assign_section_id IN (SELECT assign_section_id FROM (SELECT DISTINCT 'asgn'.'assign_section_id', 'asgn'.'assign_access_id', 'u'.'first_name', 'ins'.'invite_status_name', 's'.'section_name' FROM ('assign_section' asgn) INNER JOIN assign_section asgn2 ON asgn2.assign_section_id = asgn.assign_section_id LEFT JOIN 'section' s ON 's'.'section_id' = 'asgn'.'assign_section_id' LEFT JOIN 'users' u ON 'u'.'hashing_email' = 'asgn'.'assign_access_id' LEFT JOIN 'invite_status' ins ON 'ins'.'invite_id' = 'asgn'.'assign_status_id') AS T WHERE assign_access_id = '$access_id'";
        $query = $this->db->query($sql);

        //echo "<pre>"; print_r($this->db);exit;
        //echo $this->db->last_query(); exit;

        if($query->num_rows() > 0) {
            $result = array();
            $temp_array = array();
            foreach($query->result() as $section_list) {
                $result[$section_list->assign_section_id]['section_name'] = $section_list->section_name;

                $temp_array['first_name'] = $section_list->first_name;
                $temp_array['last_name'] = $section_list->last_name;
                $temp_array['invite_status_name'] = $section_list->invite_status_name;
                $temp_array['assign_creation_date'] = $section_list->assign_creation_date;
                $temp_array['assign_status_id'] = $section_list->assign_status_id;

                $result[$section_list->assign_section_id]['assigned_user_list'][] = $temp_array;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function get_all_assign_section_list_by_organisation_id($org_id) {
        $query = $this->common_for_section_and_assigned_user_list($org_id);
        echo "<pre>"; print_r($this->db);exit;

        if($query->num_rows() > 0) {
            $result = array();
            $temp_array = array();
            foreach($query->result() as $section_list) {
                $result[$section_list->assign_section_id]['section_name'] = $section_list->section_name;

                $temp_array['first_name'] = $section_list->first_name;
                $temp_array['last_name'] = $section_list->last_name;
                $temp_array['invite_status_name'] = $section_list->invite_status_name;
                $temp_array['assign_creation_date'] = $section_list->assign_creation_date;
                $temp_array['assign_status_id'] = $section_list->assign_status_id;

                $result[$section_list->assign_section_id]['assigned_user_list'][] = $temp_array;
            }
            //echo "<pre>"; print_r($result); echo "</pre>"; exit();
            return $result;
        } else {
            return false;
        }
    }

    public function get_all_assign_user_list_by_organisation_id($org_id, $limit, $start) {
        $query = $this->common_for_section_and_assigned_user_list($org_id, $limit, $start);
        //print_r($query); exit();
        //echo $this->db->last_query();exit;
        if($query->num_rows() > 0) {
            $result = array();
            $temp_array = array();
            foreach($query->result() as $section_list) {
                /*$result[$section_list->assign_access_id]['assigned_user_name'] = $section_list->first_name.' '.$section_list->last_name;$section_list->section_name;
                $result[$section_list->assign_access_id]['organisation_name'] = $section_list->organisation_name;

                $temp_array['section_name'] = $section_list->section_name;;
                $temp_array['invite_status_name'] = $section_list->invite_status_name;
                $temp_array['assign_creation_date'] = $section_list->assign_creation_date;
                $temp_array['assign_status_id'] = $section_list->assign_status_id;

                $result[$section_list->assign_access_id]['assigned_section_list'][] = $temp_array;*/
                $temp_array[] = $section_list;
            }
            //echo "<pre>";print_r($temp_array); exit();
            //$count = count($temp_array);
            //var_dump($count); exit();
            return $temp_array;//$result;
        } else {
            return false;
        }
    }

    public function accept_request_is_valid($org_id, $section_id, $hashed_email) {
        $query = $this->db->get_where('assign_section', array('assign_organisation_id' => $org_id, 'assign_section_id' => $section_id, 'assign_access_id' => $hashed_email, 'assign_hit' => '0'));
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // section_member_remove is set to 1 temporarily deleted
    public function deleteClass($class_id){
        //$this->output->enable_profiler(TRUE);
        $this->db->set('section_remove', 1);
        $this->db->where_in('section_id', $class_id);
        $this->db->update('section');
        //print_r($this->db);
        return $this->db->affected_rows();
    }
}