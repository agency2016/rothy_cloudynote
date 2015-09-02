<?php
/**
 * Created by PhpStorm.
 * User: MANCHU
 * Date: 3/4/14
 * Time: 12:05 PM
 */

class Activity_model extends CI_Model {

    public function get_all_activities($limit = '3', $offset = '0') {
        $this->db->order_by( 'alog.activity_log_date', 'desc' );
        $this->db->select('*');
        $this->db->from('activity_log alog');
        $this->db->join('activity_label alab', 'alab.activity_label_id = alog.activity_log_label_id', 'left');
        $this->db->join('activity_type atype', 'atype.activity_type_id = alog.activity_log_type_id', 'left');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_total_rows($table) {
        return $this->db->count_all($table);
    }

    public function has_admin_access($organisation_id, $member_id) {
        $this->db->select( 'COUNT(*) AS has_permission' );
        $query = $this->db->get_where( 'note_permission_level', array( 'permission_author_id' => $organisation_id, 'permission_assigned_id' => $member_id ) );
        $result = $query->row();
        if( $result->has_permission > 0 ) {
            return true;
        } else {
            return false;
        }
    }

} 