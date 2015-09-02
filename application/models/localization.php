<?php
/**
 * Created by PhpStorm.
 * User: SUDARSHAN BISWAS
 * Date: 1/19/14
 * Time: 8:10 PM
 */

class Localization extends CI_Model {

    public function get_all_country_list() {
        $this->db->order_by('country_name');
        return $this->db->get('country_list')->result();
    }

    public function get_all_state_list() {
        $this->db->order_by('country_code_char2');
        $state_list = $this->db->get('states_subdivisions')->result_array();
        //echo count($state_list);
        //print_r($state_list);exit;
        $state_string = '{\'state_list\': {';
        $prev_country_code_char = '';
        $first_time = true;
        //print_r($state_list);exit;
        foreach($state_list as $slist) {
            if($slist['country_code_char2'] == $prev_country_code_char) {
                //$state_string .= ', \''.$slist['state_subdivision_name'].'\'';
                $state_string .= '<option class="removable" value="'.$slist['state_subdivision_id'].'">'.trim(str_replace("'", " ", $slist['state_subdivision_name'])).'</option>';
            } else {
                $prev_country_code_char = $slist['country_code_char2'];
                if($first_time) {
                    $first_time = false;
                    //$state_string .= $slist['country_code_char2'].':[\''.$slist['state_subdivision_name'].'\'';
                    $state_string .= '\''.$slist['country_code_char2'].'\':\'<option class="removable" value="'.$slist['state_subdivision_id'].'">'.trim(str_replace("'", " ", $slist['state_subdivision_name'])).'</option>';
                } else {
                    $state_string .= '\', \''.$slist['country_code_char2'].'\':\'<option class="removable" value="'.$slist['state_subdivision_id'].'">'.trim(str_replace("'", " ", $slist['state_subdivision_name'])).'</option>';
                }
            }
        }

        $state_string .= '\'} };';

        //echo $state_string;exit;

        return $state_string;
    }

   /* public function get_state_list($country_code_char2) {
        $this->db->order_by('country_code_char2');
        $this->db->where('country_code_char2 =', $country_code_char2);
        $query = $this->db->get('states_subdivisions')->result_array();

        /* $this->output->enable_profiler(TRUE);
                echo "<pre>";
                print_r($this->db);*/
       /* if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }

    }*/

    public function get_all_timezone_list() {
        return $this->db->get('timezone')->result();
    }
}


