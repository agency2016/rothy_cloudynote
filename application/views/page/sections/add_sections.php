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

                                    <div class="user-edit-form">
                                        <?php echo (isset($add_class_error) and !empty($add_class_error)) ? $add_class_error : ''; ?>
                                        <?php echo (isset($add_class_success) and !empty($add_class_success)) ? $add_class_success : ''; ?>
                                        <?php echo form_error('new_section', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('invite_user_id', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <form class="form-horizontal" action="<?php echo base_url('user/'.$this->uri->segment(2)); ?>" method="post">

                                            <div class="control-group">
                                                <label class="control-label">Class Name</label>
                                                <div class="controls">
                                                    <input type="text" name="new_section" placeholder="Class Name" value="<?php echo (set_value('new_section')) ? set_value('new_section'): ''; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Assign To</label><!-- Class or Section -->
                                                <div class="controls">
                                                    <select name="invite_user_id">
                                                        <option value="0">Invite Teacher</option>
                                                        <option value="1">Teacher A</option>
                                                        <option value="1">Teacher B</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--<div class="control-group">
                                                <label class="control-label">Group</label>
                                                <div class="controls">
                                                    <input type="text" name="invite_group" placeholder="Note Name" value="<?php /*echo (set_value('invite_group')) ? set_value('invite_group'): ''; */?>">
                                                </div>
                                            </div>-->

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Create Class &amp; Send Invitation</button>
                                                </div>
                                            </div>
                                        </form>
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