<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/3/13
 * Time: 3:49 PM
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
                                        <?php echo (isset($update_profile_error) and !empty($update_profile_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sorry! </strong>'.$update_profile_error.'</div>' : ''; ?>
                                        <?php echo form_error('org_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('fname', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('lname', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('password', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <form class="form-horizontal" action="<?php echo base_url('dashboard/user/edit/'.$user_id); ?>" method="post">

                                            <div class="control-group">
                                                <label class="control-label">Organisation Name</label>
                                                <div class="controls">
                                                    <input type="text" name="org_name" placeholder="Organisation Name" value="<?php echo (set_value('org_name')) ? set_value('org_name'): $user_data->organisation_name; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">First Name</label>
                                                <div class="controls">
                                                    <input type="text" name="fname" placeholder="First Name" value="<?php echo (set_value('fname')) ? set_value('fname'): $user_data->first_name; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Last Name</label>
                                                <div class="controls">
                                                    <input type="text" name="lname" placeholder="Last Name" value="<?php echo (set_value('lname')) ? set_value('lname'): $user_data->last_name; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Email</label>
                                                <div class="controls">
                                                    <span class="input-xlarge uneditable-input"><?php echo $user_data->email; ?></span>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Password</label>
                                                <div class="controls">
                                                    <input type="password" name="password" placeholder="Password">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Confirm Password</label>
                                                <div class="controls">
                                                    <input type="password" name="con_password" placeholder="Password">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" class="btn btn-success">Update Profile</button>
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