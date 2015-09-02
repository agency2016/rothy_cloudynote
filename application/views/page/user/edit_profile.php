<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/8/13
 * Time: 3:38 PM
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
                                            <?php echo (isset($update_profile_success) and !empty($update_profile_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success! </strong>'.$update_profile_success.'</div>' : ''; ?>
                                            <?php echo form_error('org_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                            <?php echo form_error('password', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                            <form class="form-horizontal" action="<?php echo base_url('user/edit-profile'); ?>" method="post">
                                                <?php if($login_user_data->user_access_level <= '3'): ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Organisation Name</label>
                                                        <div class="controls">
                                                            <input type="text" name="org_name" placeholder="Organisation Name" value="<?php echo (set_value('org_name')) ? set_value('org_name'): $login_user_data->organisation_name; ?>">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="control-group">
                                                    <label class="control-label">First Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="fname" placeholder="First Name" value="<?php echo (set_value('fname')) ? set_value('fname'): $login_user_data->first_name; ?>">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Last Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo (set_value('lname')) ? set_value('lname'): $login_user_data->last_name; ?>">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Email</label>
                                                    <div class="controls">
                                                        <span class="input-xlarge uneditable-input"><?php echo $login_user_data->email; ?></span>
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
                                                    <label class="control-label">City</label>
                                                    <div class="controls">
                                                        <input type="text" name="city" placeholder="City">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Country</label>
                                                    <div class="controls">
                                                        <select name="country_id" class="country-id">
                                                            <?php foreach($country_list as $clist): ?>
                                                                <option value="<?php echo $clist->country_code_char3; ?>"><?php echo $clist->country_name; ?> ( <?php echo $clist->country_code_char3; ?> )</option>
                                                            <?php endforeach; ?>
                                                        </select>
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
                                                    <label class="control-label">State/Provenance</label>
                                                    <div class="controls">
                                                        <select name="state_id" class="state">
                                                            <option value="">Select your State / Provinces</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Timezone</label>
                                                    <div class="controls">
                                                        <select name="timezone_id">
                                                            <?php foreach($timezone_list as $tlist): ?>
                                                                <option value="<?php echo $tlist->timezone_id; ?>">( <?php echo $tlist->timezone_shown_as; ?> ) <?php echo $tlist->timezone_full_name; ?> </option>
                                                            <?php endforeach; ?>
                                                        </select>
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

    <script>
        jQuery(document).ready(function( $ ) {

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