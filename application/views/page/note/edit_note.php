<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 3:21 PM
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
                                        <?php echo (isset($note_create_error) and !empty($note_create_error)) ? $note_create_error : ''; ?>
                                        <?php echo form_error('note_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('note_details', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('schedule_date', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('end_date', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <form class="form-horizontal" action="<?php echo base_url('notes/edit/'.$note_id); ?>" method="post">

                                            <div class="control-group">
                                                <label class="control-label">Note Name</label>
                                                <div class="controls">
                                                    <input type="text" name="note_name" placeholder="Note Name" value="<?php echo (set_value('note_name')) ? set_value('note_name'): $note_name; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Schedule Date</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <input type="text" name="schedule_date" id="dpd1" data-date-format="yyyy/mm/dd" value="<?php echo (set_value('schedule_date')) ? set_value('schedule_date'): $schedule_date; ?>">
                                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">End Date</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <input type="text" name="end_date" id="dpd2" data-date-format="yyyy/mm/dd"  value="<?php echo (set_value('end_date')) ? set_value('end_date'): $end_date; ?>">
                                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Note Details</label>
                                                <div class="controls">
                                                    <textarea class="span12" rows="10" name="note_details"><?php echo (set_value('note_details')) ? set_value('note_details'): $note_details; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-file-text"></i> Update Note</button>
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