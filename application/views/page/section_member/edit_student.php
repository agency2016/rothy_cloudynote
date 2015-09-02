<?php
/**
 * Created by PhpStorm.
 * User: Ridhia
 * Date: 1/4/13
 * Time: 3:38 PM
 */
$this->view('page/dashboard-icon-menu/index');
$this->view('template/upload_image');
?>

<section class="main-content-body" xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="container-wrapper">
            <div class="well">
                <div class="cldnt-info-area">
                    <div class="row-fluid">
                        <div class="alert" style="display: none;">Student Information Updated Successfully</div>
                        <form class="form-horizontal"
                              id="student-ajax-<?php echo $section_member_data->section_member_id; ?>" action=""
                              name="student-form"
                              method="POST">
                            <input type="hidden" name="section_member_id"
                                   value="<?php echo (set_value('section_member_id')) ? set_value('section_member_id') : $section_member_data->section_member_id; ?>">

                            <div class="user-innerheader">Student Info</div>
                            <div class="user-edit-form">
                                <div class="control-group">
                                    <label class="control-label">First Name</label>

                                    <div class="controls">
                                        <input type="text" name="section_member_first_name" placeholder="First Name"
                                               value="<?php echo (set_value('section_member_first_name')) ? set_value('section_member_first_name') : $section_member_data->section_member_first_name; ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Last Name</label>

                                    <div class="controls">
                                        <input type="text" name="section_member_last_name" placeholder="Last Name"
                                               value="<?php echo (set_value('section_member_last_name')) ? set_value('section_member_last_name') : $section_member_data->section_member_last_name; ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <?php //echo($section_member_data->section_member_gender);?>
                                    <div class="controls">
                                        <div class="radio">
                                            <input type="radio" name="section_member_gender"
                                                   value="0" <?php echo($section_member_data->section_member_gender == '0' ? 'checked="checked"' : ''); ?>>
                                            <label for="male">Male</label>
                                            <input type="radio" name="section_member_gender"
                                                   value="1" <?php echo($section_member_data->section_member_gender == '1' ? 'checked="checked"' : ''); ?>>
                                            <label for="female">Female</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Date of Birth</label>
                                    <?php $date = date("d-m-Y", strtotime($section_member_data->section_member_date_of_birth)) ?>
                                    <div class="controls">
                                        <input class="date-of-birth" name="section_member_date_of_birth"
                                               value="<?php echo (set_value('section_member_date_of_birth')) ? set_value('section_member_date_of_birth') : $date; ?>"
                                               data-date-format="dd-mm-yyyy" type="text">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Allergies</br>(seperate by comma)</label>

                                    <div class="controls">
                                        <input type="text" name="section_member_allergie" placeholder="alergie"
                                               value="<?php echo (set_value('section_member_allergie')) ? set_value('section_member_allergie') : $section_member_data->section_member_allergie; ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Special</br>(if need any)</label>

                                    <div class="controls">
                                        <textarea name="section_member_special" rows="4"
                                                  cols="50"><?php echo (set_value('section_member_special')) ? set_value('section_member_special') : $section_member_data->section_member_special; ?></textarea>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Profile Photo</label>

                                    <div class="controls">
                                        <div class="cdimage">
                                            <?php
                                            $url = base_url() . 'upload/avatar/student/' . md5(md5($section_member_data->section_member_id)) . '.' . $section_member_data->image_ext;
                                            if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                                                $url = base_url() . 'resources/img/blank.jpeg';
                                            }
                                            ?>
                                            <img id='<?php echo $section_member_data->section_member_id; ?>'
                                                 class="imageloadedparentprofile" src="<?php echo $url; ?>"
                                                 alt="Image Not Found" width="120" height="180">
                                            <br>
                                            <input class="add-image buttonpp" type="button" value="Add"
                                                   data-user-id="<?php echo $section_member_data->section_member_id; ?>"
                                                   data-user-type="student">
                                            <input class="buttonpp" type="button" value="Change" name="Submit">
                                        </div>
                                    </div>

                                </div>


                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit"
                                                data-formid="student-ajax-<?php echo $section_member_data->section_member_id; ?>"
                                                class="student-save btn btn-success">Save Student Info
                                        </button>
                                        <a class="btn btn-success" href="<?php echo base_url('user/students'); ?>">Back
                                            To Student List</a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--row-fluid-->
                </div>
                <!--cldnt-info-area-->

            </div>
            <!-- End of Well -->

        </div>
        <!--container-wrapper-->
    </div>
    <!--container-->
</section>
<script>
    jQuery(document).ready(function ($) {
        $('.date-of-birth').datepicker();
    });
    $("button.student-save").on('click', function (e) {
        e.preventDefault();

        var formid = $(this).attr('data-formid');

        //var form = $(this).parents('form:first').attr('id');
        ////console.log(form);
        //var childDataString = $(this.form).serialize();
        var childDataString = $("#" + formid).serialize();
        //console.log(childDataString);

        $.ajax({
            url: "<?php echo base_url('user/post-ajax-save-child-profile'); ?>",
            type: "POST",
            async: false,
            data: {childDataString: childDataString},
            //dataType: "json",
            success: function (response) {
                //console.log(response);
                ajaxResponse = jQuery.parseJSON(response);
                if (parseInt(ajaxResponse.output)) {
                    $(".alert").show();


                } else {
                    $(".alert").show().text("Not Updated");
                }
            },
            error: function (request, status, error) {
                //console.log("something fishy!");
            }
        });
    });

</script>
