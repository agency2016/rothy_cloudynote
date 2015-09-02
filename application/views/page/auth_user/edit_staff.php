<?php
/**
 * Created by PhpStorm.
 * User: Ridhia
 * Date: 1/4/13
 * Time: 3:38 PM
 */

?>

<section class="main-content-body" xmlns="http://www.w3.org/1999/html">
    <?php
    $this->view('page/dashboard-icon-menu/index');
    $this->view('template/upload_image');
    ?>
    <div class="container">
        <div class="container-wrapper">
            <div class="well">
                <div class="cldnt-info-area">
                    <div class="row-fluid">
                        <div class="alert" style="display: none;"></div>
                        <form class="form-horizontal edit-staff-form" id="staff-ajax-<?php echo $staff_data->id; ?>"
                              action="" name="staff-form"
                              method="POST">
                            <input type="hidden" name="id"
                                   value="<?php echo (set_value('id')) ? set_value('id') : $staff_data->id; ?>">

                            <div class="user-innerheader">Staff Info</div>

                            <div class="user-edit-form">
                                <div class="control-group">
                                    <label class="control-label">First Name</label>

                                    <div class="controls">
                                        <input type="text" name="first_name" placeholder="First Name" required
                                               value="<?php echo (set_value('first_name')) ? set_value('first_name') : $staff_data->first_name; ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Last Name</label>

                                    <div class="controls">
                                        <input type="text" name="last_name" placeholder="Last Name" required
                                               value="<?php echo (set_value('last_name')) ? set_value('last_name') : $staff_data->last_name; ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Email</label>

                                    <div class="controls">
                                        <?php if ($login_user_data->user_access_level < 3) {
                                            $email_show_style = ' <input type="text" name="email" placeholder="Email" required  value="' . (set_value('email')) ? set_value('email') : $staff_data->email . '">';
                                        } else {
                                            $email_show_style = '<div class="show-as-input" >' . $staff_data->email . '</div>';
                                        }
                                        echo $email_show_style;
                                        ?>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Phone Number</label>

                                    <div class="controls">
                                        <input type="text" name="mobilephone" placeholder="Phone Number"
                                               value="<?php echo (set_value('mobilephone')) ? set_value('mobilephone') : $staff_data->mobilephone; ?>">
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Profile Photo</label>

                                    <div class="controls">
                                        <div class="cdimage">
                                            <?php
                                            $url = base_url() . 'upload/avatar/staff/' . md5(md5($staff_data->id)) . '.' . $staff_data->image_ext;
                                            if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                                                $url = base_url() . 'resources/img/blank.jpeg';
                                            }
                                            ?>
                                            <img id='<?php echo $staff_data->id; ?>' class="imageloadedparentprofile"
                                                 src="<?php echo $url; ?>" alt="Image Not Found" width="120"
                                                 height="180">
                                            <br>
                                            <input class="add-image buttonpp" type="button" value="Add"
                                                   data-user-id="<?php echo $staff_data->id; ?>" data-user-type="staff">
                                            <input class="buttonpp" type="button" value="Change" name="Submit">
                                        </div>
                                    </div>

                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" data-formid="staff-ajax-<?php echo $staff_data->id; ?>"
                                                class="staff-save btn btn-success">Save Staff Info
                                        </button>
                                        <a class="btn btn-success" href="<?php echo base_url('user/staff-list'); ?>">Back
                                            To Staff List</a>
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
<script>
    jQuery(document).ready(function ($) {
        $('.edit-staff-form').validate({
            rules: {
                first_name: {
                    minlength: 3,
                    required: true
                },
                last_name: {
                    minlength: 3,
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobilephone: {
                    digits: true,
                    required: true
                }
                /* profilepic: {
                 accept: "image/jpeg, image/pjpeg,image/jpg, image/png"
                 }*/
            },
            highlight: function (element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            }
        });
    });

    $("button.staff-save").on('click', function (e) {
        // $(".alert").hide();
        e.preventDefault();
        var formid = $(this).attr('data-formid');
        var staffDataString = $("#" + formid).serialize();
        //console.log(staffDataString);

        $.ajax({
            url: "<?php echo base_url('user/post-ajax-update-staff'); ?>",
            type: "POST",
            async: false,
            data: {staffDataString: staffDataString},
            //dataType: "json",
            success: function (response) {
                //console.log(response);
                ajaxResponse = jQuery.parseJSON(response);
                if (parseInt(ajaxResponse.output)) {
                    $(".alert").show().text("Staff Information Updated Successfully");
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
</section>

