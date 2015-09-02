<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/28/13
 * Time: 3:49 PM
 */

class Auth_user_model extends CI_Model {

    private $return_message = array('type' => '', 'message' => '');
    private $last_insert_id = '';

    public function check_user_availability($email) {
        $this->db->select('*');
        $query = $this->db->get_where('user', array('user_email' => $email));
        if($query->num_rows() > 0) {
            $this->return_message['type'] = false;
            $this->return_message['message'] = 'This email already registered. Please try with new one.';
        } else {
            $this->db->select('*');
            $query = $this->db->get_where('temp_user', array('user_email' => $email));

            if($query->num_rows() > 0) {
                $this->return_message['type'] = false;
                $this->return_message['message'] = 'Already we sent an email to active your account. If you did not find plz check your junk mail.';
            } else {
                $this->return_message['type'] = true;
                $this->return_message['message'] = 'This email is available for registration';
            }
        }
        return $this->return_message;
    }

    public function register($register_data) {
        $query = $this->db->insert($register_data);
        if($query->affect_rows() > 0) {
            $this->last_insert_id = $query->insert_id();

            $this->return_message['type'] = true;
            $this->return_message['message'] = 'Please check your email to complete your registration process.';
        } else {
            $this->return_message['type'] = false;
            $this->return_message['message'] = 'Something went wrong. Please Try again.';
        }
    }

    public function insert_access_permission($insert_array) {
        $this->db->set($insert_array);
        $this->db->insert('user_access_capabilty');

        if($this->db->affected_rows() > 0) {
           return $this->db->insert_id();

        }
        return false;
    }

    public function update_access_permission($insert_array) {

        $id=$insert_array['id'];
        unset($insert_array['id']);
        $this->db->where('id', $id);
        $this->db->update('user_access_capabilty', $insert_array);
        if($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function get_access_permission($org_id,$user_id) {

        $this->db->select('*');
        $this->db->from('user_access_capabilty u');

        $this->db->where('u.org_id =', $org_id);
        $this->db->where('u.user_id =', $user_id);

        $query = $this->db->get();
        /* $this->output->enable_profiler(TRUE);
                echo "<pre>";
                print_r($this->db);*/
        if ($query->row_array() > 0) {
            return $query->row_array();
        } else {
            return false;
        }


    }

} 