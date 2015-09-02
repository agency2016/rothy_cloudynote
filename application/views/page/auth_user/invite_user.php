<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/9/13
 * Time: 2:33 PM
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
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#import-staff" data-toggle="tab">Import Staff</a></li>
                                        <li><a href="#add-staff-single" data-toggle="tab">Add Single Staff</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="import-staff">
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
                                                        <button type="submit" name="import_staff" value="import_staff" class="btn btn-success"><i class="fa fa-envelope"></i> Import</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="tab-pane" id="add-staff-single">
                                            <div class="user-edit-form">
                                                <?php echo (isset($invite_section_id) and !empty($invite_section_id)) ? $invite_section_id : ''; ?>
                                                <?php echo (isset($send_invitation_success) and !empty($send_invitation_success)) ? $send_invitation_success : ''; ?>
                                                <?php echo (isset($send_invitation_error) and !empty($send_invitation_error)) ? $send_invitation_error : ''; ?>
                                                <?php echo form_error('invite_email', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                                <?php echo form_error('invite_first_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                                <?php echo form_error('invite_section_id', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                                <form class="form-horizontal" action="<?php echo base_url('user/'.$this->uri->segment(2)); ?>" method="post">

                                                    <div class="control-group">
                                                        <label class="control-label">Email of Teacher</label>
                                                        <div class="controls">
                                                            <input type="text" name="invite_email" placeholder="Email of Teacher" value="<?php echo (set_value('invite_email')) ? set_value('invite_email'): ''; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">First Name of Teacher</label>
                                                        <div class="controls">
                                                            <input type="text" name="invite_first_name" placeholder="First Name of Teacher" value="<?php echo (set_value('invite_first_name')) ? set_value('invite_first_name'): ''; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Last Name of Teacher</label>
                                                        <div class="controls">
                                                            <input type="text" name="invite_last_name" placeholder="Last Name of Teacher" value="<?php echo (set_value('invite_last_name')) ? set_value('invite_last_name'): ''; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Class</label><!-- Class or Section -->
                                                        <div class="controls">
                                                            <select name="invite_section_id">
                                                                <?php foreach($section_list as $list):?>
                                                                    <option value="<?php echo $list->section_id; ?>" <?php echo (set_value('invite_section_id') == $list->section_id) ? 'selected="selected"': '';?>><?php echo $list->section_name; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Send Invitation</button>
                                                        </div>
                                                    </div>
                                                </form>
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
</section>