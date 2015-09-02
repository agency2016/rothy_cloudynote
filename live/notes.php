<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/3/13
 * Time: 1:46 PM
 */

class Notes extends MY_Controller
{
    private $css_js_array = array(
        'codeboxr_css' => array('super-admin', 'template'),
        'codeboxr_js' => array('jquery-ui.min', 'app' /*, 'bootstrap-alert', 'bootstrap-dropdown'*/)
        //'codeboxr_js'                       => array( 'bootstrap-alert', 'bootstrap-dropdown')
        //'codeboxr_js'                       => array( 'jquery-sortable', 'bootstrap-alert', 'bootstrap-dropdown')
    );

    public function __construct()
    {
        parent::__construct($this->css_js_array);
        $this->load->model(array('note_model', 'super_admin'));
        $this->load->helper('function');

        if ($this->dx_auth->is_logged_in()) {
            $this->user_info = $this->super_admin->get_user_info($this->session->userdata('DX_user_id'))->row();
        }
    }

    public function index()
    {
        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }
        if (!$this->dx_auth->is_admin() and !has_organisation()) {
            redirect(base_url('user/edit-profile'));
        }

        $css_js_for_notes = array(
            'codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js' => array('jquery.dataTables.min')
        );
        $data['note_list'] = array();

        $this->load->library('pagination');
        ($this->uri->segment(3)) ? $page_num = $this->uri->segment(3) : $page_num = 0;

        $config['base_url'] = base_url('notes/page');
        $config['uri_segment'] = 3;
        if ($this->dx_auth->is_admin()) {
            $config['total_rows'] = $this->note_model->get_total_rows_of_notes('notes', true);
            $note_list = $this->note_model->get_all_note_list($limit = 10, $page_num);
            if ($note_list->num_rows() > 0) {
                $data['note_list'] = $note_list->result();
            }
            $financial_stat = $this->note_model->get_financial_stat($limit = 10, $page_num);
            if ($financial_stat->num_rows() > 0) {
                $data['financial_stat'] = $financial_stat->result();
            }
        } else {
            if ($this->user_info->user_access_level > 3) {

                $note_list = $this->note_model->get_all_note_list_by_assigned_id();

                if ($note_list != false and $note_list->num_rows() > 0) {
                    $config['total_rows'] = $note_list->num_rows();
                    $note_list = $note_list->result();
                } else {
                    $note_list = false;
                }
                //unset($note_list['total_rows']);
            } else {
                $org_id = $this->session->userdata('CN_user_organisation_id');
                $financial_stat = $this->note_model->get_financial_stat($org_id, $limit = 10, $page_num);
                if ($financial_stat->num_rows() > 0) {
                    $data['financial_stat'] = $financial_stat->result();
                }
                //$config['total_rows']           = $this->note_model->get_total_rows_of_notes('notes');
                $note_list = $this->note_model->get_all_note_list_by_organisation_id($limit = 10, $page_num);

                // echo "<pre>";print_r($note_list);exit;
                //$this->debug($note_list); exit();
                if ($note_list != false and $note_list->num_rows() > 0) {
                    $config['total_rows'] = $note_list->num_rows();
                    $note_list = $note_list->result();
                } else {
                    $note_list = 0;
                }
            }
            //if ($note_list != false) {
            $data['note_list'] = $note_list;
            //}
        }
        $data['login_user_data'] = $this->user_info;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->_render_admin('note/index', $data, $css_js_for_notes);


    }

    public function view_note_list()
    {

        $css_js_for_notes = array(
            'codeboxr_css' => array('demo_page', 'demo_table', 'jquery.dataTables'),
            'codeboxr_js' => array('jquery.dataTables.min')
        );
        ($this->uri->segment(3)) ? $page_num = $this->uri->segment(3) : $page_num = 0;
        $data['login_user_data'] = $this->user_info;
        $data['note_list'] = array();

        $this->load->library('pagination');

        $config['base_url'] = base_url('notes/page');
        $config['uri_segment'] = 3;

        if ($this->dx_auth->is_admin()) {

            $config['total_rows'] = $this->note_model->get_total_rows_of_notes('notes', true);
            $note_list = $this->note_model->get_all_note_list($limit = 100, $page_num);

            if ($note_list->num_rows() > 0) {
                $data['note_list'] = $note_list->result();
            }

        } else {
            if ($this->user_info->user_access_level > 3) {
                //exit('sdsd');
                $note_list = $this->note_model->get_all_note_list_by_assigned_id();
                $config['total_rows'] = $note_list->num_rows();
                if ($note_list->num_rows() > 0) {
                    $note_list = $note_list->result();
                } else {
                    $note_list = false;
                }

            } else {
                // $config['total_rows']           = $this->note_model->get_total_rows_of_notes('notes');
                $note_list = $this->note_model->get_all_note_list_by_organisation_id($page_num);
                $config['total_rows'] = $note_list->num_rows();

                // echo "<pre>";print_r($note_list);exit;
                if ($note_list->num_rows() > 0) {
                    $note_list = $note_list->result();
                } else {
                    $note_list = false;
                }
            }
            if ($note_list != false) {
                $data['note_list'] = $note_list;
            }

        }


        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        //print_r($data['pagination']);

        $this->_render_admin('note/view_note_list', $data, $css_js_for_notes);

    }

    public function new_note()
    {
        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }

        if (!$this->dx_auth->is_admin() and !has_organisation()) {
            redirect(base_url('user/edit-profile'));
        }

        //print_r( $this->session);exit;

        if ($this->dx_auth->is_admin()) {
            redirect(base_url('notes'));
        }

        if ($json_cnote_info = $this->input->post('cnote_form_info') and !is_array($json_cnote_info)) {
            $json_cnote_info = json_decode($json_cnote_info);
            if (is_object($json_cnote_info) and (count((array)$json_cnote_info) > 2)) {
                if (property_exists($json_cnote_info, 'note_id') and $json_cnote_info->note_id > 0) {
                    if (property_exists($json_cnote_info, 'last_group_id') and $json_cnote_info->last_group_id >= 1) {
                        if ($this->note_model->update_note($json_cnote_info->note_id, $this->input->post('cnote_form_info'), $this->input->post('note_status'))) {
                            $note_info = '{"note_info":{"type":"success","msg":"Form data update successfully."}}';
                        } else {
                            $note_info = '{"note_info":{"type":"error","msg":"Form data not valid.Please submit again"}}';
                        }
                    }
                }
            } else {
                $note_info = '{"note_info":{"type":"success","msg":""}}';
            }
            echo $note_info;
            exit; // this is important. this only execute when ajax call. so don't remove this line
        }

        $data['set_tab_to_send_note'] = 'false';
        $data['login_user_data'] = $this->user_info;
        $data['load_drag_items'] = true;
        $data['draggable_item'] = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form.html'))));
        $ext_css_js_array = array(

            'codeboxr_css' => array('jquery.classyedit', 'bootstrap-wysihtml5', 'summernote', 'demo_page', 'demo_table', 'jquery.dataTables', 'datepicker', 'alertify.core', 'alertify.default', 'note', 'cloud_crumbs', 'bootstrap-timepicker'),
            'codeboxr_js' => array('bootstrap-datepicker', 'date_picker', 'alertify.min', 'bootstrap.wizard.min', 'notes', 'jquery.dataTables.min', 'bootstrap-timepicker', 'jquery.classyedit', 'wysihtml5-0.3.0', 'bootstrap-wysihtml5', 'summernote', 'jquery.form.min', 'ajaximageupload')

        );


        //$this->load->model('section_model');
        //$data['section_list']               = array();
        //$data['note_create_error']          = $this->session->flashdata('note_create_error');
        //$data['draggable_item']             = $this->load->view('note_template/form.html', '', true);

        /*if($this->dx_auth->is_admin()) {
                      redirect(base_url('notes'));
                  } else {
                      if($this->user_info->user_access_level > 3) {
                          $section_list                       = $this->section_model->get_all_section_list_by_assigned_id();
                          //print_r($section_list->result());exit;
                          if($section_list->num_rows() > 0) {
                              $data['section_list']           = $section_list->result();
                          }
                      } else {
                          $section_list                       = $this->section_model->get_all_section_list_by_organise_id($this->user_info->id);
                          //print_r($section_list->result());exit;
                          if($section_list->num_rows() > 0) {
                              $data['section_list']           = $section_list->result();
                          }
                      }
                  }*/

        $this->load->model(array('section_member_model'));
        //$data["get_receiver_and_member_list"] = $this->section_member_model->get_receiver_and_member_list($this->user_info->organisation_id);
        $get_receiver_and_member_list = $this->section_member_model->get_receiver_and_member_list($this->user_info->organisation_id);

        //print_r($get_receiver_and_member_list);exit;
        $table_col_start = '';
        $note_receiver_table_list = '';
        if (is_array($get_receiver_and_member_list)  and count($get_receiver_and_member_list) > 0) {
            $number = 1;
            foreach ($get_receiver_and_member_list as $list) {
                $note_receiver_table_list .= '
                <tr>
                    <td >
                        <input type="checkbox" name="data[1][id]" value="1" class="data-check">
                    </td>
                    <td style="display: none">
                        ' . $list->member_id . '
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][section_member_id]" value="' . $list->member_id . '">
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][caregiver_id]" value="' . $list->caregiver_id . '">
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][caregiver_unique_id]" value="' . $list->caregiver_unique_id . '">
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][caregiver_first_name]" value="' . $list->first_name . '">
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][caregiver_last_name]" value="' . $list->last_name . '">
                        <input type="hidden" name="receiver_list[' . ($number - 1) . '][caregiver_email]" value="' . $list->email . '">
                    </td>
                    <td style="display: none">' . $list->section_member_section_id . '</td>
                    <td>' . $number++ . '</td>
                    <td>' . $list->section_member_first_name . '</td>
                    <td>' . $list->section_member_last_name . '</td>
                    <td>' . $list->first_name . '</td>
                    <td>' . $list->last_name . '</td>
                    <td>' . $list->email . '</td>
                    <td class="label label-success">JOINED</td>
                    <td style="display: none">' . $list->section_name . '</td>
                </tr>';
            }

        }


        $data['get_receiver_and_member_list'] = $note_receiver_table_list;
        //$data['get_receiver_and_member_list'] = $get_receiver_and_member_list;
        //print_r( $data["get_receiver_and_member_list"] );
        // print_r($this->uri->segment(3));
        if (($this->uri->segment(2) == 'new' && $note_id = $this->input->post('note_id')) || ($this->uri->segment(2) == 'edit' && $note_id = (int)$this->uri->segment(3))) {


            $note_sended_or_not = false;
            if ($get_note_info = $this->note_model->get_note_information_by_id($note_id)) {
                //print_r($this->user_info->organisation_id);


                if ($get_note_info->note_organisation_id != $this->user_info->organisation_id) {
                    redirect(base_url('notes/page'));
                    $this->session->set_flashdata('alert_message', '<strong>Ops! </strong>Access Denied.');

                }

                $data['note_json_form_options'] = $get_note_info->note_json_form_options;
                $data['note_name'] = $get_note_info->note_name;
                if ($get_note_info->note_send == '1') {
                    $note_sended_or_not = true;
                    $note_json = json_decode($get_note_info->note_json_form_options);
                    $note_json->note_name =  $get_note_info->note_name;
                    $data['note_json_form_options'] = json_encode($note_json);
                   // echo "<pre>"; print_r($note_json);
                }


            }

            if ($note_sended_or_not == true) {

                $data['draggable_item'] = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form.html'))));
                $data['edit_note_preview'] = 'true';
                $data['set_tab_to_preview_note'] = 'true';
                $ext_css_js_array = array(
                    'codeboxr_css' => array('note', 'template', 'cloud_crumbs',),
                    'codeboxr_js' => array('bootstrap.wizard.min', 'notes')
                );

                $this->_render_admin('note/edit_note_preview', $data, $ext_css_js_array);
            } else {
                $this->load->library('form_validation', '', 'frm_val');
                //$this->frm_val->set_message('is_draft', 'Form does not submit in legal way.');
                $this->frm_val->set_rules('note_name', 'Name of Note', 'trim|required|xss_clean|max_length[300]');
                $this->frm_val->set_rules('note_status', 'Name of Note', 'trim|required|xss_clean|max_length[300]|int');
                //$this->frm_val->set_rules('schedule_date', 'Date of Note', 'trim|required|xss_clean');
                //$this->frm_val->set_rules('reply_end_date', 'Reply By', 'trim|xss_clean');
                //$this->frm_val->set_rules('event_date', 'When', 'trim|xss_clean');
                //$this->frm_val->set_rules('note_details', 'Note Details', 'trim|required|xss_clean|max_length[5000]');
                //$this->frm_val->set_rules('payment', 'Payment', 'trim|xss_clean|decimal');
                //$this->frm_val->set_rules('additional_payment', 'Additional Payment', 'trim|xss_clean|decimal');
                //$this->frm_val->set_rules('is_draft', '', 'trim|required|xss_clean|numeric|less_than[2]');

                if ($this->frm_val->run() !== false) {
                    //print_r($this->user_info->organisation_id);
                    //print_r(set_value('section_id')); exit();
                    /*
                                  if($this->section_model->has_section( set_value('section_id'), $this->user_info->organisation_id ) /*and $this->section_model->is_already_assigned( $this->user_info->email, set_value('section_id') ) ) {


                                  } else {
                                      $data['legal_notice'] = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>The form is not submitted leggally.</div>';
                                  }*/


                    $note_data = array(
                        'note_organisation_id' => $this->user_info->organisation_id,
                        'note_creator_id' => $this->session->userdata('DX_user_id'),
                        //'note_section_id'           => (set_value('is_draft')) ? '0' : set_value('section_id'),
                        'note_name' => set_value('note_name'),
                        //'note_details'              => set_value('note_details'),
                        //'note_payment'              => set_value('payment'),
                        //'note_additional_payment'   => set_value('additional_payment'),
                        //'note_json_form_options'    => set_value('note_json_form_options'),
                        'note_schedule_date' => (set_value('schedule_date')) ? date("Y-m-d", strtotime(set_value('schedule_date'))) : date("Y-m-d"), //Date ofschedule_date
                        //'note_end_date'             => (set_value('end_date')) ? set_value('end_date') : '',
                        //'note_event_date'           => (set_value('event_date')) ? set_value('event_date') : '',
                        //'note_draft'                => set_value('is_draft'),
                        'note_auto_draft' => '0'
                    );
                    //Note status for meaning note is draft or scheduled or send
                    /*
                                   * $note_status = 1; draft
                                   * $note_status = 2; schedule
                                   * $note_status = 3; send
                                   */
                    $note_status = '1';
                    if ($this->input->post('note_status')) {
                        $note_status = $this->input->post('note_status');
                    }


                    //print_r($note_status);exit;
                    if (($note_status == '3' or $note_status == '2') and count($this->input->post('receiver_list')) < 1) {
                        if ($note_status == '2') {
                            $note_status_text = 'scheduling';
                        } else {
                            $note_status_text = 'sending';
                        }
                        $note_status = '1';
                        $data['note_sending_or_scheduling_error'] = 'You must add receiver before ' . $note_status_text . ' note.';
                    }

                    if ($this->note_model->update_note($note_id, $note_data, $note_status)) {
                        $this->note_model->update_note_response($note_id, $this->user_info->organisation_id, $this->input->post('receiver_list'));
                        //var_dump( $this->input->post( 'receiver_list' ) );
                        if ($note_status == '1' or $note_status == '2') {
                            $data['set_tab_to_send_note'] = 'true';
                        } else {
                            redirect(base_url('notes'));
                        }
                        //$this->session->set_flashdata('note_create_success', '<strong>Success! </strong>Note Creation success.');
                        //$data['note_create_success']        = $this->session->flashdata('note_create_success');
                        //Send note access via email
                        //$this->email->from('no-reply@cloudenote.com');
                        //$this->email->to('sudarshan955@gmail.com');
                        //$this->email->subject($note_data['note_name']);
                        //$this->email->message();
                        //redirect(base_url('notes/'));
                    } else {
                        //$this->session->set_flashdata('note_create_error', '<strong>Error! </strong>Something went error.');
                    }
                }
                $data['note_id'] = $note_id;
                $this->_render_admin('note/new_note', $data, $ext_css_js_array);
            }
        } else {
            $note_data = array(
                'note_id' => '',
                'note_organisation_id' => $this->user_info->organisation_id,
                'note_creator_id' => $this->session->userdata('DX_user_id'),
                'note_auto_draft' => 1,
                'note_draft' => 0,
                'note_schedule' => 0,
                'note_send' => 0
            );
            if ($note_id = $this->note_model->create_new_note($note_data)) {
                $data['note_id'] = $note_id;
                $data['note_name'] = '';
            }
            $this->_render_admin('note/new_note', $data, $ext_css_js_array);
        }

        /*        if ($note_id = (int) $this->uri->segment(3)) {

                    if ($get_note_info = $this->note_model->get_note_information_by_id($note_id)) {
                        $data['note_json_form_options'] = $get_note_info->note_json_form_options;
                    }

                    $this->load->library('form_validation', '', 'frm_val');
                    //$this->frm_val->set_message('is_draft', 'Form does not submit in legal way.');
                    $this->frm_val->set_rules('note_name', 'Name of Note', 'trim|required|xss_clean|max_length[300]');
                    $this->frm_val->set_rules('note_status', 'Name of Note', 'trim|required|xss_clean|max_length[300]|int');
                    //$this->frm_val->set_rules('schedule_date', 'Date of Note', 'trim|required|xss_clean');
                    //$this->frm_val->set_rules('reply_end_date', 'Reply By', 'trim|xss_clean');
                    //$this->frm_val->set_rules('event_date', 'When', 'trim|xss_clean');
                    //$this->frm_val->set_rules('note_details', 'Note Details', 'trim|required|xss_clean|max_length[5000]');
                    //$this->frm_val->set_rules('payment', 'Payment', 'trim|xss_clean|decimal');
                    //$this->frm_val->set_rules('additional_payment', 'Additional Payment', 'trim|xss_clean|decimal');
                    //$this->frm_val->set_rules('is_draft', '', 'trim|required|xss_clean|numeric|less_than[2]');

                    if ($this->frm_val->run() !== false) {
                        //print_r($this->user_info->organisation_id);
                        //print_r(set_value('section_id')); exit();
                        /*
                                      if($this->section_model->has_section( set_value('section_id'), $this->user_info->organisation_id ) /*and $this->section_model->is_already_assigned( $this->user_info->email, set_value('section_id') ) ) {


                                      } else {
                                          $data['legal_notice'] = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>The form is not submitted leggally.</div>';
                                      }*/


        /*$note_data = array(
            'note_organisation_id' => $this->user_info->organisation_id,
            'note_creator_id'      => $this->session->userdata('DX_user_id'),
            //'note_section_id'           => (set_value('is_draft')) ? '0' : set_value('section_id'),
            'note_name'            => set_value('note_name'),
            //'note_details'              => set_value('note_details'),
            //'note_payment'              => set_value('payment'),
            //'note_additional_payment'   => set_value('additional_payment'),
            //'note_json_form_options'    => set_value('note_json_form_options'),
            'note_schedule_date'        => (set_value('schedule_date')) ? date("Y-m-d", strtotime(set_value('schedule_date'))) :date("Y-m-d") ,//Date ofschedule_date
            //'note_end_date'             => (set_value('end_date')) ? set_value('end_date') : '',
            //'note_event_date'           => (set_value('event_date')) ? set_value('event_date') : '',
            //'note_draft'                => set_value('is_draft'),
            'note_auto_draft'     =>'0'
        );*/
        //Note status for meaning note is draft or scheduled or send
        /*
                       * $note_status = 1; draft
                       * $note_status = 2; schedule
                       * $note_status = 3; send
                       */
        /* $note_status = '1';
         if ($this->input->post('note_status')) {
             $note_status = $this->input->post('note_status');
         }


         //print_r($note_status);exit;
         if (($note_status == '3' or $note_status == '2') and count($this->input->post('receiver_list')) < 1) {
             if ($note_status == '2') {
                 $note_status_text = 'scheduling';
             } else {
                 $note_status_text = 'sending';
             }
             $note_status                              = '1';
             $data['note_sending_or_scheduling_error'] = 'You must add receiver before ' . $note_status_text . ' note.';
         }

         if ($this->note_model->update_note($note_id, $note_data, $note_status)) {
             $this->note_model->update_note_response($note_id, $this->user_info->organisation_id, $this->input->post('receiver_list'));
             //var_dump( $this->input->post( 'receiver_list' ) );
             if ($note_status == '1' or $note_status == '2') {
                 $data['set_tab_to_send_note'] = 'true';
             } else {
                 redirect(base_url('notes'));
             }
             //$this->session->set_flashdata('note_create_success', '<strong>Success! </strong>Note Creation success.');
             //$data['note_create_success']        = $this->session->flashdata('note_create_success');
             //Send note access via email
             //$this->email->from('no-reply@cloudenote.com');
             //$this->email->to('sudarshan955@gmail.com');
             //$this->email->subject($note_data['note_name']);
             //$this->email->message();
             //redirect(base_url('notes/'));
         } else {
             //$this->session->set_flashdata('note_create_error', '<strong>Error! </strong>Something went error.');
         }
     }
     $data['note_id'] = $note_id;
 }*/
        // echo "<pre>"; print_r($data);

    }

    public function edit_note($note_id)
    {
        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }

        if (!$this->dx_auth->is_admin() and !has_organisation()) {
            redirect(base_url('user/edit-profile'));
        }

        $data['login_user_data'] = $this->user_info;

        //I will write some code for teacher authentication.
        //If teacher have no permission for this he will redirect to his profile with warning message.


        $note_details = $this->note_model->get_note_information_by_id($note_id);
        if ($note_details->num_rows() == '0') {
            redirect(base_url('notes/'));
        }

        $data['load_drag_items'] = true;
        $note_details = $note_details->row();

        //print_r($note_details);exit;

        $ext_css_js_array = array(
            'codeboxr_css' => array('datepicker'),
            'codeboxr_js' => array('bootstrap-datepicker', 'date_picker')
        );

        $this->load->library('form_validation', '', 'frm_val');
        $data['note_create_error'] = $this->session->flashdata('note_create_error');
        $this->frm_val->set_rules('note_name', 'Note Name', 'trim|required|xss_clean|strip_tags|max_length[300]');
        $this->frm_val->set_rules('schedule_date', 'Schedule Date', 'trim|required|xss_clean|strip_tags');
        //$this->frm_val->set_rules('end_date', 'End Date', 'trim|required|xss_clean|strip_tags');
        //$this->frm_val->set_rules('note_details', 'Note Details', 'trim|required|xss_clean|strip_tags|max_length[5000]');

        if ($this->frm_val->run() == false) {
            $data['note_id'] = $note_id;
            $data['note_name'] = $note_details->note_name;
            $data['schedule_date'] = $note_details->note_schedule_date;
            $data['cnote_form_info'] = $note_details->note_json_form_options;
            //$data['end_date'] = $note_details->note_end_date;
            //$data['note_details'] = $note_details->note_details;
            $this->_render_admin('note/edit_note', $data, $ext_css_js_array);
        } else {
            $note_data = array(
                'note_name' => set_value('note_name'),
                'note_schedule_date' => set_value('schedule_date'),
                //'note_end_date'         => set_value('end_date'),
                //'note_details'          => set_value('note_details'),
            );
            if ($this->note_model->update_note($note_id, $note_data)) {
                $this->session->set_flashdata('note_update_success', '<strong>Success! </strong>Note Creation success.');
                redirect(base_url('notes/'));
            } else {
                $this->session->set_flashdata('note_create_error', '<strong>Error! </strong>Something went error.');
                $this->_render_admin('note/new_note', $data, $ext_css_js_array);
            }
        }
    }

    public function replies($note_response_id)
    {
        //http://cloudenotes.com/note/reply/public/5434ab8b392d934b4562a14f26126892/bd499eb92ce6ec000f0d16fd6a85e9bc/ZWxlbmFAZW1haWwuY29t
        if (!$this->dx_auth->is_logged_in()) {
            redirect(base_url());
        }

        if ($this->user_info->user_access_level == 5 or $this->user_info->user_access_level == '5') {
            $response_note_data = $this->note_model->check_note_status($note_response_id, $this->user_info->id);
            //$response_note_data = $this->note_model->check_note_status( $note_response_id, '98' );
            //$response_note_data = $this->note_model->check_note_status( 'c74e46e0fe991443fc5906b1fc4d9839', '98' );


            if ($response_note_data == false) {
                //exit('sds');
                show_error('Invalid Note ID', 200);
                exit;
            } else {

                if ($json_cnote_response_info = $this->input->post('note_response_json')) {
                    $note_json = json_decode($response_note_data['form_json'], true);
                    $note_fields_id = array();
                    $note_fields = array();
                    foreach ($note_json as $index => $item_object) {
                        //var_dump($item_object);
                        if (is_array($item_object)) {

                            foreach ($item_object as $indexi => $item_objecti) {
                                //var_dump($indexi);
                                array_push($note_fields, $indexi);
                                array_push($note_fields_id, $item_objecti['group_id']);
                            }
                        }

                        //array_push($note_fields,$item_object);
                    }
                    // var_dump($note_fields_id);
                    $json_cnote_response_info = json_decode($json_cnote_response_info, true);
                    $response_json_error = false;

                    foreach ($json_cnote_response_info as $index => $item_object) {
                        //  var_dump($item_object);
                        foreach ($item_object as $item_type_key => $item_value_object) {

                            if (array_key_exists($item_type_key, $note_json[$index])) {

                                if ($note_json[$index][$item_type_key]['group_id'] == $item_value_object['group_id']) {

                                    if ($item_type_key == 'checkbox' or $item_type_key == 'radio' or $item_type_key == 'select' or $item_type_key == 'dropdown') {

                                        if (count($note_json[$index][$item_type_key]['total_items']) == count($item_value_object['total_items'])) {
                                            // echo('kita');
                                            foreach ($note_json[$index][$item_type_key]['total_items'] as $item_key => $item_array) {
                                                $note_json[$index][$item_type_key]['total_items'][$item_key]['item_checked'] = $item_value_object['total_items'][$item_key]['item_checked'];
                                            }
                                        } else {
                                            $response_json_error = true;
                                        }
                                    } else if ($item_type_key == 'signature') {

                                        $note_json[$index][$item_type_key]['firstname'] = $item_value_object['firstname'];
                                        $note_json[$index][$item_type_key]['lastname'] = $item_value_object['lastname'];
                                        $note_json[$index][$item_type_key]['consent'] = $item_value_object['consent'];
                                        $note_json[$index][$item_type_key]['nonconsent'] = $item_value_object['nonconsent'];

                                    } else if ($item_type_key == 'remark') {

                                        $note_json[$index][$item_type_key]['remark'] = $item_value_object['remark'];

                                    } else if ($item_type_key == 'phone') {

                                        $note_json[$index][$item_type_key]['phone'] = $item_value_object['phone'];

                                    } else if ($item_type_key == 'email') {

                                        $note_json[$index][$item_type_key]['email_default_value'] = $item_value_object['email_default_value'];

                                    } else if ($item_type_key == 'number') {

                                        $note_json[$index][$item_type_key]['number_default_value'] = $item_value_object['number_default_value'];

                                    }
                                    else if( $item_type_key == 'payment-due' ){

                                        $note_json[$index][$item_type_key]['total']=$item_value_object['total'];
                                        if( count( $note_json[$index][$item_type_key]['total_items'] ) == count( $item_value_object['total_items'] ) ){
                                            // echo('kita');
                                            foreach( $note_json[$index][$item_type_key]['total_items'] as $item_key => $item_array ) {
                                                $note_json[$index][$item_type_key]['total_items'][$item_key]['required'] = $item_value_object['total_items'][$item_key]['required'];
                                                $note_json[$index][$item_type_key]['total_items'][$item_key]['quantity'] = $item_value_object['total_items'][$item_key]['quantity'];
                                            }
                                        } else {
                                            $response_json_error = true;
                                        }

                                    }
                                    else if ($item_type_key == 'address-box') {

                                        $note_json[$index][$item_type_key]['address'] = $item_value_object['address'];
                                        $note_json[$index][$item_type_key]['street'] = $item_value_object['street'];
                                        $note_json[$index][$item_type_key]['city'] = $item_value_object['city'];
                                        $note_json[$index][$item_type_key]['state'] = $item_value_object['state'];
                                        $note_json[$index][$item_type_key]['postalcode'] = $item_value_object['postalcode'];
                                        $note_json[$index][$item_type_key]['country'] = $item_value_object['country'];

                                    }
                                } else {
                                    $response_json_error = true;
                                }
                            }
                        }
                    }

                    if (!$response_json_error) {

                        $update_info = $this->note_model->update_note_response_json($note_response_id, json_encode($note_json));
                    } else {
                        $update_info['return_type'] = false;
                        $update_info['return_message'] = 'Form submission error. Please try again.';
                    }
                    header("Content-type:application/json");
                    echo json_encode($update_info);
                    exit;
                } else {
                    $note_json = json_decode($response_note_data['form_json']);
                    $note_json->note_response_id = $note_response_id;
                    $note_json->note_name = $response_note_data['note_name'];
                    $response_note_data['response_note_response_json'] = json_encode($note_json);

                    $data['note_json_form_options'] = $response_note_data['response_note_response_json'];
                    if ($response_note_data['disable']) {
                        $data['note_replier_name'] = $response_note_data['replier_first_name'];
                        $data['note_replier_id'] = $response_note_data['replier_id'];
                        $data['note_reply_time'] = date_format(date_create($response_note_data['reply_time']), 'g:i a \o\n l jS F Y');
                        $data['draggable_item'] = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form.html'))));
                        $data['public_preview'] = 'true';
                        $data['reply_preview'] = 'false';
                    } else {
                        $data['draggable_item'] = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form-response.html'))));
                        $data['public_preview'] = 'false';
                        $data['reply_preview'] = 'true';
                    }
                    $ext_css_js_array = array(
                        'codeboxr_css' => array('note', 'template'),
                        'codeboxr_js' => array('bootstrap.wizard.min', 'notes')
                    );

                    $this->_render('note/public_note_view', $data, $ext_css_js_array);
                }
            }
        }

    }

    public function note_public_view($section_member_id, $note_public_view_id, $encode_email)
    {
        //http://cloudenotes.com/note/reply/public/5434ab8b392d934b4562a14f26126892/f753ab7f57aeb79238a0f41cefa10c48/ZWxlbmFAZW1haWwuY29t
        $this->load->model('note_model');
        $response_note_data = $this->note_model->get_response_note_for_public($section_member_id, $note_public_view_id);
        if ($response_note_data == false) {
            show_404();
            exit();
        }

        if ($this->dx_auth->is_logged_in()) {
            redirect(base_url('note/reply/' . $response_note_data->response_id));
        }

        $note_json = json_decode($response_note_data->response_note_response_json);
        $note_json->note_name = $response_note_data->note_name;
        $response_note_data->response_note_response_json = json_encode($note_json);

        $data['note_json_form_options'] = $response_note_data->response_note_response_json;
        $data['draggable_item'] = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form.html'))));
        $data['public_preview'] = 'true';
        $ext_css_js_array = array(
            'codeboxr_css' => array('note', 'template'),
            'codeboxr_js' => array('bootstrap.wizard.min', 'notes')
        );

        $this->_render('note/public_note_view', $data, $ext_css_js_array);
    }

    /*  public function edit_note_preview($section_member_id, $note_public_view_id, $encode_email) {
          //http://cloudenotes.com/note/reply/public/5434ab8b392d934b4562a14f26126892/f753ab7f57aeb79238a0f41cefa10c48/ZWxlbmFAZW1haWwuY29t
          $this->load->model('note_model');
          $response_note_data = $this->note_model->get_response_note_for_public($section_member_id, $note_public_view_id);
          if ($response_note_data == false) {
              show_404();exit();
          }

          if( $this->dx_auth->is_logged_in() ) {
              redirect( base_url( 'note/reply/'.$response_note_data->response_id ) );
          }

          $note_json                                       = json_decode($response_note_data->response_note_response_json);
          $note_json->note_name                            = $response_note_data->note_name;
          $response_note_data->response_note_response_json = json_encode($note_json);

          $data['note_json_form_options'] = $response_note_data->response_note_response_json;
          $data['draggable_item']         = preg_replace('/\s\s+/', '', (str_replace(array("\r\n", "\r", "\n"), "", file_get_contents(APPPATH . 'views/note_template/form.html'))));
          $data['public_preview']         = 'true';
          $ext_css_js_array               = array(
              'codeboxr_css' => array('note', 'template'),
              'codeboxr_js'  => array('bootstrap.wizard.min', 'notes')
          );

          $this->_render('note/public_note_view', $data, $ext_css_js_array);
      }*/

    public function view_note_result()
    {
        $css_js = array('codeboxr_css' => array('bootstrap-switch'), 'codeboxr_js' => array('bootstrap-switch', 'jquery.smooth-scroll.min'));
        $data['login_user_data'] = $this->user_info;
        $this->load->model('note_model');
        $note_id = $this->uri->segment(3);
        if ($this->user_info->user_access_level > 3) {
            $creator_id = (int)$this->session->userdata('DX_user_id');
            $data['note_result'] = $this->note_model->get_note_result($note_id, $this->user_info->organisation_id, $creator_id);
        } else {
            $data['note_result'] = $this->note_model->get_note_result($note_id, $this->user_info->organisation_id, $this->user_info->organisation_id);

        }
        $data['note_parent_student'] = $this->note_model->get_note_parent_student($note_id);
        //echo "<pre>";print_r($data['note_result']);
        $this->_render_admin('note/view_note_result', $data, $css_js);
    }
}
