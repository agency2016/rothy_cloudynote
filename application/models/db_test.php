<?php
/**
 * Created by PhpStorm.
 * User: MANCHU
 * Date: 2/12/14
 * Time: 12:16 PM
 */

class Db_test extends CI_Model {

    public function db_tran() {
        //$this->db->trans_start();//start transaction
        $data1 = array(
            'id' => '',
            'name' => null
        );

        $data2 = array(
            'id' => '' ,
            'name' => 'Sudarshan'
        );

        if($this->db->insert('test_user1', $data1)) {
            //echo $this->db->last_query();
            exit('Success');
        } else {
            exit('Fail');
        }
        //$this->db->trans_complete();//stop transaction

        /*if( $this->db->trans_status() === false ) {
            return false;
        } else {
            return true;
        }*/
    }

} 