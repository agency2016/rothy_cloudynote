<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/6/13
 * Time: 12:59 PM
 */

class Test extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $some_change = array(
            'title' => 'Sudarshan Blog',
        );

        $ext_css = array(
            'codeboxr_css' => array('bootstrap6.min')
        );

        $this->_render('test', $some_change, $ext_css);
    }

    public function db_tran_test() {
        $this->load->model('db_test');
        $this->db_test->db_tran();
    }
} 