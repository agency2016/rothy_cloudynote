<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 1:47 PM
 */

class Note_model extends CI_Model {

    private $return_msg = array(
        'type'    => false,
        'message' => ''
    );

    /**
     * @param $status_id
     */
    private function set_note_status($status_id) {
        $this->db->set('note_auto_draft', 0);
        if ($status_id == 2) { //for scheduling note
            $this->db->set('note_draft', 0);
            $this->db->set('note_schedule', 1);
            $this->db->set('note_send', 0);
        } elseif ($status_id == 3 ) { //for sending note
            $this->db->set('note_draft', 0);
            $this->db->set('note_schedule', 0);
            $this->db->set('note_send', 1);
        } else { //for draft note
            $this->db->set('note_draft', 1);
            $this->db->set('note_schedule', 0);
            $this->db->set('note_send', 0);
        }
    }

    private function get_note_json_data($note_id) {
        $query = $this->db->select('note_json_form_options')->get_where('notes', array('note_id' => $note_id));
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }


    private function remove_note_response($note_id) {
        $this->db->delete('note_response', array('response_note_id' => $note_id));
    }

    public function get_total_rows_of_notes($table_name, $is_admin = false) {
        if ($is_admin) {
            //exit('admin');
            $this->db->join('users', 'users.id = notes.note_creator_id');

            return $this->db->count_all_results($table_name);
            // Need to be fix letter
            //return $this->db->count_all($table_name);
        } else {
            $this->db->join('users', 'users.id = notes.note_organisation_id');
            $this->db->where('note_organisation_id', $this->session->userdata('DX_user_id'));

            return $this->db->count_all_results($table_name);
        }

    }

    public function get_all_note_list($limit = '3', $offset = '0', $order_by = '', $order_type = 'asc') {
        if ($order_by != '') {
            $this->db->order_by($order_by, $order_type);
        }

        $this->db->join('users', 'users.id = notes.note_creator_id');

        return $this->db->get('notes', $limit, $offset);
    }

    public function get_all_note_list_by_organisation_id_calendar($org_id='', $staff='', $parent=''){

        //$organisation_id = (int)$this->session->userdata('CN_user_organisation_id');

        $this->db->select('*');
        $this->db->from('notes');
        if($staff != '') $this->db->join('users u', 'u.id=notes.note_creator_id','left');
        if($parent != '') $this->db->join('note_response nr', 'nr.response_note_id = notes.note_id','left');
        //if($parent != '') $this->db->join('users u', 'u.id=nr.response_receiver_id','left');
        if($org_id != '') $this->db->where('note_organisation_id', $org_id);
        if($staff != '') $this->db->where('notes.note_creator_id', $staff);
        if($parent != '') $this->db->where('nr.response_receiver_id', $parent);
        //$this->db->get();
        //echo $this->db->last_query();
        return $this->db->get()->result();
    }

    public function get_financial_stat($org_id = '', $limit = '', $page_num = '') {
        $this->db->select('*');
        $this->db->from('user_transaction ut');
        $this->db->join('package_list pl', 'pl.package_code = ut.package_code', 'left');
        if($org_id != '') $this->db->where('ut.organisation_id', $org_id);
        $this->db->limit($limit);
        $this->db->order_by("ut.order_id", "desc");

        return $this->db->get();
    }

    public function get_all_note_list_by_organisation_id($limit = '', $offset = '0', $order_by = '', $order_type = 'asc') {
        /*if($order_by != '') {
                      $this->db->order_by($order_by, $order_type);
                  }

                  $this->db->join('users', 'users.id = notes.note_creator_id');
                  $this->db->where('note_organisation_id', $this->session->userdata('DX_user_id'));//CN_organisation_id
                  return $this->db->get('notes', $limit, $offset);*/
        $organisation_id = (int)$this->session->userdata('DX_user_id');
        //print_r($organisation_id);

        $sql = "SELECT `notes`.`note_id` , `notes`.`note_name` , `notes`.`note_schedule_date` ,`notes`.`note_created_date`,`notes`.`note_send` , `notes`.`note_reply_end_date` , stdc.student_per_note, pc.parent_consent,pnc.parent_non_consent,nr.not_replied
                          FROM `notes`

                          LEFT JOIN (
                          SELECT `note_id` , `note_name` ,Count(DISTINCT (`response_section_member_id`) ) AS student_per_note
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          GROUP BY `note_id`)stdc ON stdc.note_id = notes.note_id

                          LEFT JOIN (
                          SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_consent
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_consent` = '0'
                          GROUP BY `note_id` )pc ON pc.note_id = notes.note_id

                          LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_non_consent
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_consent` = '1'
                          GROUP BY `note_id` )pnc ON pnc.note_id = notes.note_id

                          LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS not_replied
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_note_reply` = '0'
                          GROUP BY `note_id` )nr ON nr.note_id = notes.note_id

                          WHERE `note_organisation_id` = '$organisation_id'
                          AND `note_auto_draft` = '0'
                          AND `note_remove` = '0'";

        $sql .= " ORDER BY note_created_date DESC";
        if ($limit != ''){
            $sql .= " LIMIT $limit";

        }


                  $query = $this->db->query($sql);
       //echo "<pre>"; print_r($this->db);exit();

                  return $query;


    }

    public function get_all_note_list_by_assigned_id($limit = '3', $offset = '0', $order_by = '', $order_type = 'asc') {
        $organisation_id = (int)$this->session->userdata('CN_user_organisation_id');
        $creator_id      = (int)$this->session->userdata('DX_user_id');
        //echo "<pre>";print_r($this->session);exit();
        $sql = "SELECT `notes`.`note_id` , `notes`.`note_name` , `notes`.`note_schedule_date` ,`notes`.`note_created_date`,`notes`.`note_send` , `notes`.`note_reply_end_date` , stdc.student_per_note, pc.parent_consent,pnc.parent_non_consent,nr.not_replied
                          FROM `notes`

                          LEFT JOIN (
                          SELECT `note_id` , `note_name` ,Count(DISTINCT (`response_section_member_id`) ) AS student_per_note
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          GROUP BY `note_id`)stdc ON stdc.note_id = notes.note_id

                          LEFT JOIN (
                          SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_consent
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_consent` = '0'
                          GROUP BY `note_id` )pc ON pc.note_id = notes.note_id

                          LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_non_consent
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_consent` = '1'
                          GROUP BY `note_id` )pnc ON pnc.note_id = notes.note_id

                          LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS not_replied
                          FROM `notes`
                          JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                          WHERE `response_note_reply` = '0'
                          GROUP BY `note_id` )nr ON nr.note_id = notes.note_id

                          WHERE `note_organisation_id` = '$organisation_id'
                          AND `note_creator_id` ='$creator_id'";

        $query = $this->db->query($sql);
        //echo "<pre>";print_r($this->db->affected_rows());exit;
        if ($this->db->affected_rows() > 0) {
            return $query;
        } else {
            return false;
        }
        /*if ($order_by != '') {
                        $this->db->order_by($order_by, $order_type);
                  }
                  $assign_access_id = $this->session->userdata('CN_user_email_hash');
                  $sub_sql          = "SELECT COUNT(*) FROM (`notes` n) INNER JOIN `assign_section` a ON `n`.`note_section_id` = `a`.`assign_section_id` INNER JOIN `users` u ON `n`.`note_creator_id` = `u`.`id` WHERE `a`.`assign_access_id` = '$assign_access_id'";
                  $this->db->select('u.organisation_name, u.first_name, u.last_name, n.note_id, n.note_name, n.note_created_date, n.note_schedule_date, n.note_reply_end_date, (' . $sub_sql . ') AS total_rows');
                  $this->db->join('assign_section a', 'n.note_section_id = a.assign_section_id', 'inner');
                  $this->db->join('users u', 'n.note_creator_id = u.id', 'inner');
                  $this->db->where('a.assign_access_id', $this->session->userdata('CN_user_email_hash'));
                  $query = $this->db->get('notes n', $limit, $offset)->result();
                  //print_r($this->db->last_query()); exit();
                  if ($query[0]->total_rows > 0) {
                        $query['total_rows'] = $query[0]->total_rows;

                        return $query;
                  } else {
                        return false;
                  }*/
    }

    public function create_new_note($note_info) {
        $this->db->set('note_created_date', 'NOW()', false);
        $this->db->insert('notes', $note_info);
        if ($this->db->affected_rows() > 0) {
            /*$note_id = $this->db->insert_id();
            $this->db->set( 'note_public_id', md5( $note_id ) );*/
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function update_note($note_id, $note_data, $note_status = 1) {
        $this->set_note_status($note_status);
        $this->db->set('note_last_update_date', 'NOW()', false);
        if (is_array($note_data)) {
            $this->db->where('note_id', $note_id);
            $this->db->update('notes', $note_data);
        } else {
            $this->db->set('note_json_form_options', $note_data);
            $this->db->where('note_id', $note_id);
            $this->db->update('notes');
        }

        if ($this->db->affected_rows()) {
            /*$log_data = array(
                            'log_id' => '',
                            'log_notes_id' => $note_id,
                            'log_notes_changer_id' => $this->session->userdata('DX_user_id'),
                        );

                        $this->db->set('log_notes_changing_time', 'NOW()', false);
                        $this->db->insert('note_updates_log', $log_data);*/
            return true;
        }

        return false;
    }

    public function update_note_response($note_id, $organisation_id, $note_receiver_info) {
        $this->remove_note_response($note_id);
        $note_form_json = $this->get_note_json_data($note_id);
        $this->load->helper('function');
        $single_note_info = array();
        $batch_note       = array();

        if (!is_array($note_receiver_info)) {
            return false;
        }

        $batch_operation_format_ok = true;
        foreach ($note_receiver_info as $receiver_info) {
            $single_note_info['response_id']              = md5(md5(unique_id_generator(12)) . microtime());
            $single_note_info['response_note_id']         = $note_id;
            $single_note_info['response_organisation_id'] = $organisation_id;

            if (!isset($receiver_info['caregiver_id'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_receiver_id'] = $receiver_info['caregiver_id'];
            }

            if (!isset($receiver_info['caregiver_unique_id'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_receiver_unique_id'] = $receiver_info['caregiver_unique_id'];
            }

            if (!isset($receiver_info['section_member_id'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_section_member_id'] = $receiver_info['section_member_id'];
            }

            if (!isset($receiver_info['caregiver_email'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_public_view_id']      = md5($note_id . $receiver_info['section_member_id'] . $receiver_info['caregiver_email']);
                $single_note_info['response_note_receiver_email'] = $receiver_info['caregiver_email'];
            }

            if (!isset($receiver_info['caregiver_first_name'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_note_receiver_first_name'] = $receiver_info['caregiver_first_name'];
            }

            if (!isset($receiver_info['caregiver_last_name'])) {
                $batch_operation_format_ok = false;
                break;
            } else {
                $single_note_info['response_note_receiver_last_name'] = $receiver_info['caregiver_last_name'];
            }

            $single_note_info['response_note_response_json'] = $note_form_json->note_json_form_options;

            $batch_note[] = $single_note_info;
        }
        if ($batch_operation_format_ok) {
            $this->db->insert_batch('note_response', $batch_note);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }


        return false;
    }

    public function get_note_information_by_id($note_id) {
        $result = $this->db->get_where('notes', array('note_id' => $note_id));
        if ($result->num_rows() == 1) {
            return $result->row();
        } else {
            return false;
        }
    }

    /**
     * Note counter
     */
    public function note_count() {
        return $this->db->count_all('notes');
    }


    public function get_all_note_list_of_child($parent_id) {
        $this->db->select('*');


        return null;

    }

    public function get_all_email_list_for_sending_note( $note_id = '' ) {

        $sql   = '
                  SELECT 	A.response_id, A.u_organisation_name organisation_name, A.n_note_name note_title,
                            A.response_section_member_id children_id, A.response_public_view_id,
                            A.response_note_receiver_email, A.response_note_receiver_first_name,
                            u2.id parent_id, u2.caregiver_unique_id, u2.email parent_email, u2.first_name parent_first_name
                            FROM	(
                              SELECT
                                      nr.response_id, nr.response_note_id, nr.response_organisation_id,
                                          nr.response_receiver_id, nr.response_receiver_unique_id,
                                      nr.response_section_member_id, nr.response_public_view_id,
                                          nr.response_note_receiver_email,
                                      nr.response_note_receiver_first_name, csmr.caregiver_unique_id,
                                          u.organisation_name u_organisation_name, n.note_name n_note_name
                              FROM note_response nr
                              LEFT JOIN caregiver_section_member_relationship csmr
                              ON (
                                  nr.response_section_member_id = csmr.section_member_unique_id
                                     AND nr.response_receiver_unique_id = csmr.caregiver_unique_id
                              )
                              JOIN users u ON nr.response_organisation_id = u.id
                              JOIN notes n ON nr.response_note_id = n.note_id
                              WHERE nr.response_mail_sent = \'0\' AND nr.response_remove = \'0\'
                            ) as A
                            LEFT JOIN users u2 ON A.caregiver_unique_id = u2.caregiver_unique_id
                ';

        if( $note_id != '') {
            $sql .= 'WHERE A.response_note_id = '.$note_id;
        }

        $query = $this->db->query( $sql );
        //echo $this->db->last_query(); exit;
        if( $query->num_rows() > 0 ) {
            return $query->result_array();
        }
        return false;
    }

    public function get_response_note_for_public($section_member_id, $response_public_view_id ) {
        $this->db->select('n.note_name, nr.*');
        $this->db->join('notes n', 'nr.response_note_id = n.note_id');
        $query = $this->db->get_where( 'note_response nr', array( 'nr.response_section_member_id' => $section_member_id, 'nr.response_public_view_id' => $response_public_view_id) );
        //echo $this->db->last_query();exit;
        if( $query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_note_json_for_public_preview( $note_public_id ) {
        $this->db->select( 'n.note_name, n.note_json_form_options' );
        $query = $this->db->get_where( 'notes n', array( 'n.note_public_id' => $note_public_id ) );
        //echo $this->db->last_query();exit;
        if( $query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function get_note_result($note_id, $organisation_id) {


        $sql = "SELECT `notes`.`note_id` , `notes`.`note_name` , `notes`.`note_schedule_date` ,`notes`.`note_created_date`,`notes`.`note_send` ,
                `notes`.`note_reply_end_date` , stdc.student_per_note, pc.parent_consent,
                pnc.parent_non_consent,nr.not_replied,users.first_name,users.last_name,notes.note_json_form_options

                FROM `notes`
                LEFT JOIN (
                SELECT `note_id` , `note_name` ,Count(DISTINCT (`response_section_member_id`) ) AS student_per_note
                FROM `notes`
                JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                GROUP BY `note_id`)stdc ON stdc.note_id = notes.note_id

                LEFT JOIN (
                SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_consent
                FROM `notes`
                JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                WHERE `response_consent` = '0'
                GROUP BY `note_id` )pc ON pc.note_id = notes.note_id

                LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS parent_non_consent
                FROM `notes`
                JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                WHERE `response_consent` = '1'
                GROUP BY `note_id` )pnc ON pnc.note_id = notes.note_id

                LEFT JOIN(SELECT `note_id` , Count( DISTINCT (`response_section_member_id`) ) AS not_replied
                FROM `notes`
                JOIN `note_response` ON `note_response`.`response_note_id` = `notes`.`note_id`
                WHERE `response_note_reply` = '0'
                GROUP BY `note_id` )nr ON nr.note_id = notes.note_id

                LEFT JOIN `users` ON `users`.`id`=`notes`.`note_creator_id`

                WHERE `note_organisation_id` = '$organisation_id'
                AND `notes`.`note_id` = '$note_id'";


        $query = $this->db->query($sql);
       // echo "<pre>";print_r($this->db);exit;
        if ($query->num_rows() == 1)
            return $query->row();
        else return false;

    }


    public function get_note_parent_student($note_id) {


        /*$sql = "SELECT *
                    FROM `note_response`
                    JOIN `section_member` ON `note_response`.`response_section_member_id` = `section_member`.`id`
                    JOIN `section` ON `section`.`section_id` = `section_member`.`section_member_section_id`
                    WHERE `response_note_id` = '$note_id'";*/

        /*$sql = "SELECT DISTINCT (sm.id), nr.response_note_response_json, sm.section_member_first_name, sm.section_member_last_name, s.section_name,nr.response_consent,nr.response_note_reply
                FROM note_response nr
                JOIN section_member sm ON nr.response_section_member_id = sm.id
                JOIN section s ON s.section_id = sm.section_member_section_id
                WHERE nr.response_note_id = '$note_id'
                GROUP BY sm.id";*/
        $sql = "SELECT Distinct(sm.id), nr.response_note_response_json, sm.section_member_first_name, sm.section_member_last_name, s.section_name, nr.response_consent, nr.response_note_reply, nr.response_real_replier
                FROM note_response nr
                JOIN section_member sm ON nr.response_section_member_id = sm.id
                JOIN section s ON s.section_id = sm.section_member_section_id
                WHERE nr.response_note_id = '$note_id'
                AND ((nr.response_real_replier = '1' AND nr.response_note_reply = '1')
                  OR ((nr.response_real_replier = '0' AND nr.response_note_reply = '0'))
                ) ";
        $query = $this->db->query($sql);
      // echo "<pre>";print_r($this->db);exit;
        if ($query->num_rows() > 0)
            return $query->result();
        else return false;
        /*$result = $this->db->get_where( 'notes', array( 'note_id' => $note_id ) );
                  if( $result->num_rows() == 1 ) {
                        return $result->row();
                  } else {
                        return false;
                  }*/
    }

    public function get_consent_note_parent_student($note_id) {


        $sql = "SELECT DISTINCT (sm.id), nr.response_note_response_json, sm.section_member_first_name, sm.section_member_last_name, s.section_name,nr.response_consent
                FROM note_response nr
                JOIN section_member sm ON nr.response_section_member_id = sm.id
                JOIN section s ON s.section_id = sm.section_member_section_id
                WHERE nr.response_note_id = '$note_id'
                AND nr.response_consent = '0'";


        $query = $this->db->query($sql);
       // echo "<pre>";print_r($this->db);exit;
        if ($query->num_rows() > 0)
            return $query->result();
        else return false;
        /*$result = $this->db->get_where( 'notes', array( 'note_id' => $note_id ) );
                  if( $result->num_rows() == 1 ) {
                        return $result->row();
                  } else {
                        return false;
                  }*/
    }

    public function get_non_consent_note_parent_student($note_id) {


        $sql = "SELECT DISTINCT (sm.id), nr.response_note_response_json, sm.section_member_first_name, sm.section_member_last_name, s.section_name,nr.response_consent
                FROM note_response nr
                JOIN section_member sm ON nr.response_section_member_id = sm.id
                JOIN section s ON s.section_id = sm.section_member_section_id
                WHERE nr.response_note_id = '$note_id'
                AND nr.response_consent = '1'";


        $query = $this->db->query($sql);
        // echo "<pre>";print_r($this->db);exit;
        if ($query->num_rows() > 0)
            return $query->result();
        else return false;
        /*$result = $this->db->get_where( 'notes', array( 'note_id' => $note_id ) );
                  if( $result->num_rows() == 1 ) {
                        return $result->row();
                  } else {
                        return false;
                  }*/
    }

    public function get_not_replied_note_parent_student($note_id) {


        $sql = "SELECT DISTINCT (sm.id), nr.response_note_response_json, sm.section_member_first_name, sm.section_member_last_name, s.section_name,nr.response_consent
                FROM note_response nr
                JOIN section_member sm ON nr.response_section_member_id = sm.id
                JOIN section s ON s.section_id = sm.section_member_section_id
                WHERE nr.response_note_id = '$note_id'
                AND nr.response_note_reply = '0'";


        $query = $this->db->query($sql);
        // echo "<pre>";print_r($this->db);exit;
        if ($query->num_rows() > 0)
            return $query->result();
        else return false;
        /*$result = $this->db->get_where( 'notes', array( 'note_id' => $note_id ) );
                  if( $result->num_rows() == 1 ) {
                        return $result->row();
                  } else {
                        return false;
                  }*/
    }
    //check the status for note is replied or not. if replied then return replier info.
    /**
     * @param $response_id //response_id of note_response
     * @param $receiver_id //response_receiver_id of note_response
     * @return array|bool
     */
    public function check_note_status($response_id, $receiver_id ) {
        $return_info = array();

        $query = $this->db->select( 'response_note_reply, response_note_response_json, response_reply_time,
                                    response_note_id, response_organisation_id, response_section_member_id' )
            ->where( array( 'response_id' => $response_id, 'response_receiver_id' => $receiver_id ) )
            ->get( 'note_response' );

        if( $query->num_rows() > 0 ) {
            $row_data = $query->row();
            $return_info['disable'] = false;
            $return_info['form_json'] = $row_data->response_note_response_json;
            $return_info['reply_time'] = $row_data->response_reply_time;
            //echo $row_data->response_note_reply;exit;
            if( $row_data->response_note_reply == 1 ) {
                $return_info['disable'] = true;

                $query = $this->db->select( 'nr.response_receiver_id, nr.response_reply_time, u.first_name, n.note_name' )
                    ->join( 'users u', 'nr.response_receiver_id = u.id' )
                    ->join( 'notes n', 'nr.response_note_id = n.note_id' )
                    ->where(
                        array(
                            'nr.response_note_id' => $row_data->response_note_id,
                            'nr.response_organisation_id' => $row_data->response_organisation_id,
                            'nr.response_section_member_id' => $row_data->response_section_member_id,
                            'nr.response_real_replier' => '1'
                        )
                    )
                    ->get( 'note_response nr' );

                $real_replier_data_row = $query->row();
                //print_r($real_replier_data_row);exit;
                $return_info['replier_first_name'] = $real_replier_data_row->first_name;
                $return_info['replier_id'] = $real_replier_data_row->response_receiver_id;
                $return_info['reply_time'] = $real_replier_data_row->response_reply_time;
                $return_info['note_name'] = $real_replier_data_row->note_name;
            } else {
                $query = $this->db->select( 'n.note_name' )
                    ->join( 'notes n', 'nr.response_note_id = n.note_id' )
                    ->where( 'nr.response_id', $response_id)
                    ->get( 'note_response nr' );

                $real_replier_data_row = $query->row();
                $return_info['note_name'] = $real_replier_data_row->note_name;
            }
            return $return_info;
        }
        return false;
    }

    public function update_note_response_json($response_id, $response_json) {
        //{"0":{"checkbox":{"group_id":1,"label_name":"Checkbox 1","last_item_id":3,"required":"required","total_items":{"0":{"item_id":1,"label_name":"Checkbox Item 1","item_checked":"checked"},"1":{"item_id":3,"label_name":"Checkbox Item 3","item_checked":""},"2":{"item_id":2,"label_name":"Checkbox Item 2","item_checked":"checked"}}}},"last_group_id":2,"note_id":"504"}
        $return_array = array();
        $query = $this->db->select( 'nr.response_note_id, nr.response_organisation_id, nr.response_receiver_id, nr.response_section_member_id, nr.response_note_reply, nr.response_reply_time' )
            ->where( array( 'nr.response_id' => $response_id ) )
            ->get( 'note_response nr' );

        //echo $this->db->last_query();exit;
        if( $query->num_rows() == 1 ) {
            $response_row_data = $query->row();
            if( $response_row_data->response_note_reply ) {
                $return_array['return_type'] = false;
                $return_array['return_message'] = 'Sorry! already replied this note';
            } else {
                $this->db->trans_start();

                $this->db->set( 'response_note_response_json',  $response_json);
                $this->db->set( 'response_note_reply',  '1');
                $this->db->set( 'response_reply_time',  'NOW()', false);

                $this->db->where( array(
                                      'response_mail_sent' => '1',
                                      'response_remove' => '0',
                                      'response_note_reply' => '0',
                                      'response_note_id' => $response_row_data->response_note_id,
                                      'response_organisation_id' => $response_row_data->response_organisation_id,
                                      'response_section_member_id' => $response_row_data->response_section_member_id
                                  ) );

                $this->db->update( 'note_response' );

                if( $this->db->affected_rows() > 0 ) {
                    $this->db->set( 'response_real_replier',  '1');
                    $this->db->where( 'response_id', $response_id );

                    $this->db->update( 'note_response' );

                    if( $this->db->affected_rows() > 0 ) {
                        $return_array['return_type'] = true;
                        $return_array['return_message'] = 'Thanks for giving your answer.';
                    } else {
                        $return_array['return_type'] = false;
                        $return_array['return_message'] = 'Thanks for your try, but we could not save your query unfortunately. Please try again.';
                    }
                } else {

                }
                $this->db->trans_complete();
            }
        } else {
            $return_array['return_type'] = false;
            $return_array['return_message'] = 'Sorry, wrong submission. Please try again.';
        }
        return $return_array;
    }
    public function deleteNote($note_id) {
       // $this->output->enable_profiler(TRUE);
        $this->db->set('note_remove', '1');
        $this->db->where_in('note_id', $note_id);
        $this->db->update('notes');
       // print_r($this->db);
        if($this->db->affected_rows()) {
            return true;
        }
        return false;

    }
}
