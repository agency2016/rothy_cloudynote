<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/17/13
 * Time: 4:05 PM
 */
?>

<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span3">
                    <!-- Left Sidebar Menu Start -->

                    <?php $this->view('page/include/left_side_menu'); ?>

                    <!-- Left Sidebar Menu End -->

                </div>
                <div class="span9">
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="user-edit-form">
                                        <?php echo (isset($add_member_error) and !empty($add_member_error)) ? $add_member_error : ''; ?>
                                        <?php echo (isset($add_member_success) and !empty($add_member_success)) ? $add_member_success : ''; ?>
                                        <?php echo form_error('section_member_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('section_member_f_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('section_member_m_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('section_member_cell', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('section_member_address', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>



                                        <div class="tabbable"> <!-- Only required for left/right tabs -->

                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#import-section-member" data-toggle="tab">Import Students</a></li>
                                                <li><a href="#add-section-member" data-toggle="tab">Add Single Student</a></li>
                                            </ul>

                                            <div class="tab-content">

                                                <div class="tab-pane active" id="import-section-member">
                                                    <form class="form-horizontal" action="<?php echo base_url('user/'.$this->uri->segment(2)); ?>" method="post" enctype="multipart/form-data">

                                                        <div class="control-group">
                                                            <label class="control-label">Class Name</label>
                                                            <div class="controls">
                                                                <select name="section_id">
                                                                    <?php foreach($section_list as $list):?>
                                                                        <option value="<?php echo $list->section_id; ?>" <?php echo (set_value('invite_section_id') == $list->section_id) ? 'selected="selected"': '';?>><?php echo $list->section_name; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="file" name="members" class="filestyle" data-input="false">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <button type="submit" name="import_students" value="import_students" class="btn btn-success"><i class="fa fa-envelope"></i> Import</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane" id="add-section-member">

                                                    <form class="form-horizontal" action="<?php echo base_url('user/'.$this->uri->segment(2)); ?>" method="post">

                                                        <div id="new-section-member-wizard">

                                                            <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->

                                                                <ul>
                                                                    <li><a href="#section-member-info" data-toggle="tab">Student Info</a></li>
                                                                    <li><a href="#section-member-parents-info" data-toggle="tab">Parents Info</a></li>
                                                                    <li><a href="#section-member-caregiver-info" data-toggle="tab">Caregiver Info</a></li>
                                                                </ul>

                                                                <div class="tab-content">

                                                                    <span class="required">(All * filed is required)</span>

                                                                    <ul class="pager wizard">
                                                                        <li class="previous"><a href="#">Back</a></li>
                                                                        <li class="next"><a href="#">Next Step</a></li>
                                                                    </ul>

                                                                    <div class="tab-pane" id="section-member-info">

                                                                        <legend>Students Information</legend>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Student's First Name <span class="required">*</span></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_first_name" name="section_member_first_name" placeholder="Student's First Name" value="<?php echo (set_value('student_name')) ? set_value('student_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Student's Last Name <span class="required">*</span></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_last_name" name="section_member_last_name" placeholder="Student's Last Name" value="<?php echo (set_value('student_name')) ? set_value('student_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Class Name <span class="required">*</span></label>
                                                                            <div class="controls">
                                                                                <select id="section_member_section_id" name="section_member_section_id">
                                                                                    <?php foreach($section_list as $list):?>
                                                                                        <option value="<?php echo $list->section_id; ?>" <?php echo (set_value('invite_section_id') == $list->section_id) ? 'selected="selected"': '';?>><?php echo $list->section_name; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="tab-pane" id="section-member-parents-info">

                                                                        <legend>Father's Information</legend>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's First Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_first_name" name="section_member_fathers_first_name" placeholder="Father's First Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Last Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_last_name" name="section_member_fathers_last_name" placeholder="Father's Last Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Email <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_email" name="section_member_fathers_email" placeholder="Father's Email" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Phone(Work) <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_phone_work" name="section_member_fathers_phone_work" placeholder="Father's Phone(Work)" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Phone(Home)</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_phone_home" name="section_member_fathers_phone_home" placeholder="Father's Phone(Home)" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Mobile <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_mobile" name="section_member_fathers_mobile" placeholder="Father's Mobile" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Father's Address <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_first_line_address" name="section_member_fathers_first_line_address" placeholder="Address Line One" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                                <span class="help-block">First address line</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_second_line_address" name="section_member_fathers_second_line_address" placeholder="Address Line Two" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">ZIP Code <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_zip_code" name="section_member_fathers_zip_code" placeholder="ZIP Code" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">City Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_city_name" name="section_member_fathers_city_name" placeholder="City Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Country <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <select class="country-id" id="section_member_fathers_country_id" name="section_member_fathers_country_id">
                                                                                    <?php foreach($country_list as $clist): ?>
                                                                                        <option value="<?php echo $clist->country_code_char3; ?>" data-country-code="<?php echo $clist->country_code_char2; ?>"><?php echo $clist->country_name; ?> ( <?php echo $clist->country_code_char3; ?> )</option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">State / Provinces</label>
                                                                            <div class="controls">
                                                                                <select class="state" name="section_member_fathers_state_id" id="section_member_fathers_state_id" data-state-of="section_member_fathers_country_id">
                                                                                    <option value="">Select your State / Provinces</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <!--<div class="control-group">
                                                                            <label class="control-label">Timezone <span class="required">*</span></label>
                                                                            <div class="controls">
                                                                                <input type="text" id="section_member_fathers_timezone_id" name="section_member_fathers_timezone_id" placeholder="Father's Name" value="<?php /*echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; */?>">
                                                                            </div>
                                                                        </div>-->

                                                                        <legend>Mother's Information</legend>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Same as father</label>
                                                                            <div class="controls">
                                                                                <input type="checkbox" name="section_member_m_name" placeholder="Mother's Name" value="<?php echo (set_value('student_m_name')) ? set_value('student_m_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's First Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_first_name" id="section_member_mothers_first_name" placeholder="Mother's First Name" value="<?php echo (set_value('student_m_name')) ? set_value('student_m_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Last Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_last_name" id="section_member_mothers_last_name" placeholder="Mother's Last Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Email <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_email" id="section_member_mothers_email" placeholder="Mother's Email" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Phone(Work) <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_phone_work" id="section_member_mothers_phone_work" placeholder="Mother's Phone(Work)" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Phone(Home)</label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_phone_home" id="section_member_mothers_phone_home" placeholder="Mother's Phone(Home)" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Mobile <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_mobile" id="section_member_mothers_mobile" placeholder="Mother's Mobile" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Mother's Address <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_first_line_address" id="section_member_mothers_first_line_address" placeholder="Address Line One" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                                <span class="help-block">First address line</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_second_line_address" id="section_member_mothers_second_line_address" placeholder="Address Line Two" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">ZIP Code <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_zip_code" id="section_member_mothers_zip_code" placeholder="ZIP Code" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">City Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_mothers_city_name" id="section_member_mothers_city_name" placeholder="City Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Country <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <select class="country-id" id="section_member_mothers_country_id" name="section_member_mothers_country_id">
                                                                                    <?php foreach($country_list as $clist): ?>
                                                                                        <option value="<?php echo $clist->country_code_char3; ?>" data-country-code="<?php echo $clist->country_code_char2; ?>"><?php echo $clist->country_name; ?> ( <?php echo $clist->country_code_char3; ?> )</option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">State / Provinces</label>
                                                                            <div class="controls">
                                                                                <select class="state"  name="section_member_mothers_state_id" id="section_member_mothers_state_id" data-state-of="section_member_mothers_country_id">
                                                                                    <option value="">Select your State / Provinces</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <!--<div class="control-group">
                                                                            <label class="control-label">Timezone</label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_f_name" placeholder="Father's Name" value="<?php /*echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; */?>">
                                                                            </div>
                                                                        </div>-->

                                                                    </div>

                                                                    <div class="tab-pane" id="section-member-caregiver-info">

                                                                        <legend>Caregiver's Information</legend>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's (If available) <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="checkbox" name="section_member_caregivers_if_available" id="section_member_caregivers_if_available" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's First Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_first_name" id="section_member_caregivers_first_name" placeholder="Caregiver's First Name" value="<?php echo (set_value('student_m_name')) ? set_value('student_m_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Last Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_last_name" id="section_member_caregivers_last_name" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Email <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_email" id="section_member_caregivers_email" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Phone(Work) <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_phone_work" id="section_member_caregivers_phone_work" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Phone(Home)</label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_phone_home" id="section_member_caregivers_phone_home" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Mobile <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_mobile" id="section_member_caregivers_mobile" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Caregiver's Address <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_first_line_address" id="section_member_caregivers_first_line_address" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                                <span class="help-block">First address line</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_second_line_address" id="section_member_caregivers_second_line_address" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">ZIP Code <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_zip_code" id="section_member_caregivers_zip_code" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">City Name <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_caregivers_city_name" id="section_member_caregivers_city_name" placeholder="Father's Name" value="<?php echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Country <!-- <span class="required">*</span> --></label>
                                                                            <div class="controls">
                                                                                <select class="country-id" id="section_member_caregivers_country_id" name="section_member_caregivers_country_id">
                                                                                    <?php foreach($country_list as $clist): ?>
                                                                                        <option value="<?php echo $clist->country_code_char3; ?>" data-country-code="<?php echo $clist->country_code_char2; ?>"><?php echo $clist->country_name; ?> ( <?php echo $clist->country_code_char3; ?> )</option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">State / Provinces</label>
                                                                            <div class="controls">
                                                                                <select class="state" name="section_member_caregivers_state_id" id="section_member_caregivers_state_id" data-state-of="section_member_caregivers_country_id">
                                                                                    <option value="">Select your State / Provinces</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <button type="submit" id="add-student" name="add_student" class="btn btn-success"><i class="fa fa-plus"></i> Add Student</button>
                                                                            </div>
                                                                        </div>

                                                                        <!--<div class="control-group">
                                                                            <label class="control-label">Timezone <span class="required">*</span></label>
                                                                            <div class="controls">
                                                                                <input type="text" name="section_member_f_name" placeholder="Father's Name" value="<?php /*echo (set_value('student_f_name')) ? set_value('student_f_name'): ''; */?>">
                                                                            </div>
                                                                        </div>-->

                                                                    </div>

                                                                    <ul class="pager wizard">
                                                                        <li class="previous"><a href="#">Back</a></li>
                                                                        <li class="next"><a href="#">Next Step</a></li>
                                                                    </ul>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End of Well -->
                </div>
            </div>
        </div>
    </div>



    <script>
        jQuery(document).ready(function( $ ) {

            $(".filestyle:file").filestyle( {classButton: "btn btn-primary"} );
            var json_state_list = <?php echo $state_list; ?>

                $('.country-id').on('change', function(evnt) {
                    var state_selector = $(this).attr('id');
                    var country_code = $(this).find(':selected').data('country-code');
                    $('select[data-state-of='+state_selector+']').children('option.removable').remove();
                    $('select[data-state-of='+state_selector+']').append(json_state_list.state_list[country_code]);
                });
        });


    </script>

</section>



