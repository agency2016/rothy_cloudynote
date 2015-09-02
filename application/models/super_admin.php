<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/2/13
 * Time: 5:15 PM
 */

class Super_admin extends CI_Model {

    /**
     * @param string $limit how much row want to show at a time
     * @param string $offset start from which row.
     * @param string $order_by order by which column
     * @param string $order_type how would like to see ordering asc or desc
     * @return mixed|object
     */
    public function get_all_user_list($limit = '3', $offset = '0', $order_by = '', $order_type = 'asc') {
        if($order_by != '') {
            $this->db->order_by($order_by, $order_type);
        }

        return $this->db->get('users', $limit, $offset);
    }

    /**
     * @param $table_name
     * @return mixed
     */
    public function get_total_rows_of_table($table_name) {
        return $this->db->count_all($table_name);
    }

    public function get_user_info($user_id) {
        $query = $this->db->get_where('users', array('id' => $user_id));
        if($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function update_user_info($user_id, $fname, $lname, $password, $org_name = '') {

        $data = array(
            'first_name' => $fname,
            'last_name' => $lname,
            'organisation_id' => $user_id,
            'newpass' => '',
            'newpass_key' => ''
        );

        if($password != '') {
            $data['password'] = md5($password);//crypt($this->dx_auth->_encode($password));
        }

        if($org_name != '') {
            $data['organisation_name'] = $org_name;
        }

        //print_r($data);exit;

        return $this->db->update('users', $data, array('id' => $user_id));
    }

    public function remove_user_info($user_id) {
        return $this->db->delete('users', array('id' => $user_id));
    }

    public function get_activity_log(){

        $this->db->select('*');
        $this->db->from('activity_log alog');
        $this->db->join('activity_label alab', 'alab.activity_label_id = alog.activity_log_label_id', 'left');
        $this->db->join('activity_type atype', 'atype.activity_type_id = alog.activity_log_type_id', 'left');

        return $result = $this->db->get();

    }
} 