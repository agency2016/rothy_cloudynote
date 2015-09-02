<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/6/13
 * Time: 12:19 PM
 */

class MY_Controller extends CI_Controller {

    public $default_load_list = array(
        'codeboxr_css'                      => array('bootstrap.min', 'bootstrap-responsive.min', 'font-awesome', 'tinyscrollbar-custom'),
        //'codeboxr_css'                      => array('bootstrap.min', 'bootstrap-responsive.min'),
        'codeboxr_js'                       => array('jquery', 'bootstrap.min'),
        'codeboxr_font'                     => array('Patua+One', 'Roboto'),
        'codeboxr_inject_css_after_footer'  => array(),
        'codeboxr_inject_js_after_footer'   => array()
    );

    public $default_load_list_admin = array(
        'codeboxr_css'                      => array('bootstrap.min', 'bootstrap-responsive.min', 'font-awesome', 'dashboard', 'tinyscrollbar-custom', 'super-admin' ),
        //'codeboxr_css'                      => array('bootstrap.min', 'bootstrap-responsive.min', 'dashboard' ),
        'codeboxr_js'                       => array('jquery', 'bootstrap.min'),
        'codeboxr_font'                     => array('Patua+One', 'Roboto'),
        'codeboxr_inject_css_after_footer'  => array(),
        'codeboxr_inject_js_after_footer'   => array()
    );

    private $page_data = array();
    private $template_data = array();

    //Page Meta Data
    private $title = false;
    private $description = false;
    private $keywords = false;
    private $author = false;

    public function __construct($extend_css_js = array()) {
        parent::__construct();
        $this->config->load('development/custom');

        $this->lang->load('page', 'english');

        $this->merging_extend_css_js($extend_css_js);
        $this->title = $this->config->item('site_title');
        $this->description = $this->config->item('site_description');
        $this->keywords = $this->config->item('site_keywords');
        $this->author = $this->config->item('site_author');
        $this->template_data['home_url'] = base_url();
    }

    /**
     * @param $extended_load_list
     */

    private function merging_extend_css_js($extended_load_list) {
        if(!empty($extended_load_list)) {
            foreach($extended_load_list as $index => $list) {
                foreach($list as $sort_list) {
                    if(!in_array($sort_list, $this->default_load_list[$index])) {
                        array_push($this->default_load_list[$index], $sort_list);
                    }
                }
            }
        }

        foreach($this->default_load_list as $index => $list) {
            $this->template_data[$index] = $list;
        }
    }

    /**
     * @param $view
     * @param array $page_data
     * @param array $extend_css_js
     */

    public function _render($view, $page_data = array(), $extend_css_js = array()) {

       // render any page
        if(!is_array($page_data)) {
            $page_data = array();
        }

        $only_content_view = false;

        if( $this->input->get( 'content_only' ) === 'enable' ) {
            $only_content_view = true;
        }
        $this->merging_extend_css_js($extend_css_js);

        $this->template_data['title']       = $this->title;
        $this->template_data['description'] = $this->description;
        $this->template_data['keywords']    = $this->keywords;
        $this->template_data['author']      = $this->author;

        if( !$only_content_view ) {
            $this->template_data['codeboxr_header'] = $this->load->view('template/header', $page_data, true);
            $this->template_data['codeboxr_footer'] = $this->load->view('template/footer', array_merge($this->template_data, $page_data), true);
        }

        $this->template_data['codeboxr_page_content'] = $this->load->view('page/'.$view, $page_data, true);

        $this->template_data['codeboxr_main_body'] = $this->load->view('template/main_body', $this->template_data, true);
        $this->load->view('template/skeleton', array_merge($this->template_data, $page_data));

    }

    /**
     * @param $view
     * @param array $page_data
     * @param array $extend_css_js
     */
    public function _render_admin($view, $page_data = array(), $extend_css_js = array()) {
        if(!is_array($page_data)) {
            $page_data = array();
        }

        $only_content_view = false;
        if( $this->input->get( 'content_only' ) === 'enable' ) {
            $only_content_view = true;
        }

        $extend_css_js['codeboxr_css'][] = 'dashboard';

        $this->merging_extend_css_js($extend_css_js);

        $language_key = $this->uri->segment( 1 );
        $language_key .= ( $this->uri->segment( 2 ) ) ? '_'.$this->uri->segment( 2 )     : '';

        //var_dump( $language_key );exit;
        $additional_title = ( $this->lang->line( $language_key ) != '' ) ? ' || '.$this->lang->line( $language_key ) : 'Dashboard';
        $page_data['page_title'] = ( $this->lang->line( $language_key ) != '' ) ? $this->lang->line( $language_key ) : 'Dashboard';

        $this->template_data['title']                       = $this->title.$additional_title;
        $this->template_data['description']                 = $this->description;
        $this->template_data['keywords']                    = $this->keywords;
        $this->template_data['author']                      = $this->author;

        if( !$only_content_view ) {
            $this->template_data['codeboxr_header']             = $this->load->view('template/admin/header', $page_data, true);
            $this->template_data['codeboxr_footer']             = $this->load->view('template/admin/footer', array_merge($this->template_data, $page_data), true);
        }

        $this->template_data['codeboxr_page_content']       = $this->load->view('page/'.$view, $page_data, true);

        $this->template_data['codeboxr_main_body'] = $this->load->view('template/main_body', $this->template_data, true);
        $this->load->view('template/skeleton', array_merge($this->template_data, $page_data));

    }

    public function view($page, $data = array(), $print = true) {
        if($print) {
            $this->load->view($page, $data, $print);
        } else {
            return $this->load->view($page, $data, false);
        }
    }

    /**
     * Simple function for debugging
     * Just pass the argument & it'll return the print_r value
     * @param $debugArray
     */
    public function debug($debugArray){
        echo "<pre>";
        print_r($debugArray);
        echo "</pre>";
    }

    /**
     * Get the error strings given separatedly by validation errors
     * @param $errorString
     * @return array
     */
    function getErrors($errorString){
        $return = array();
        $errors = explode('</p>', $errorString);
        foreach ($errors as $key => $value) {
            $error = substr($value, strpos($value, '<p>') + 3);
            if ($error == '') {
                continue;
            }
            $return[] = $error;
        }
        return $return;
    }
} 