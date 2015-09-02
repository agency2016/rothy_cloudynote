<?php
/**
 * Created by ridhia.
 * User: User
 * Date: 7/4/13
 * Time: 4:05 PM
 */
?>
<script>
    //image preview start
    function showPreview(ele) {
        $('#imgAvatar').attr('src', ele.value); // for IE
        if (ele.files && ele.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgAvatar').attr('src', e.target.result)
                    .width(100)
                    .height(100);
            }

            reader.readAsDataURL(ele.files[0]);
        }
    }
    //image preview End
    jQuery(document).ready(function ($) {
        $('#add-staff-form').validate({
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
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            }
        });
    });

</script>
<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">

            <div class="well">
                <div class="cldnt-info-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="user-edit-form">
                                <?php echo (isset($message) and !empty($message)) ? $message : ''; ?>

                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#import-staff" data-toggle="tab">Import Staff</a></li>
                                    <li><a href="#add-staff" data-toggle="tab">Add Single Staff</a></li>
                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane active" id="import-staff">
                                        <form class="form-horizontal"
                                              action="<?php echo base_url('user/' . $this->uri->segment(2)); ?>"
                                              method="post"
                                              enctype="multipart/form-data">

                                            <div class="control-group">
                                                <label class="control-label">Select File</label>

                                                <div class="control-group">
                                                    <div class="controls">
                                                        <input type="file" name="staffs" class="filestyle"
                                                               data-input="false">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" name="import_staffs" value="import_staffs"
                                                            class="btn btn-success"><i
                                                            class="fa fa-envelope"></i> Import
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="tab-pane" id="add-staff">

                                        <form class="form-horizontal" id="add-staff-form"
                                              action="<?php echo base_url('user/' . $this->uri->segment(2)); ?>"
                                              method="post" enctype="multipart/form-data">


                                            <div class="user-innerheader">Staff Info</div>
                                            <div class="user-edit-form">
                                                <div class="control-group">
                                                    <label class="control-label">First Name</label>

                                                    <div class="controls">
                                                        <input type="text" name="first_name" placeholder="First Name"
                                                               required
                                                            >
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Last Name</label>

                                                    <div class="controls">
                                                        <input type="text" name="last_name" placeholder="Last Name"
                                                               required
                                                            >
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Email</label>

                                                    <div class="controls">
                                                        <input type="text" name="email" placeholder="Email">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Phone Number</label>

                                                    <div class="controls">
                                                        <input type="text" name="mobilephone" placeholder="Phone Number"
                                                            >
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Profile Photo</label>

                                                    <div class="controls">
                                                        <div class="cdimage">
                                                            <?php
                                                            $url = base_url() . 'resources/img/blank.jpeg';
                                                            ?>
                                                            <img id="imgAvatar" class="imageloadedparentprofile"
                                                                 src="<?php echo $url; ?>" alt="Image Not Found"
                                                                 width="120" height="180">
                                                            <br>
                                                            <input class="add-image buttonpp" type="file"
                                                                   name="profilepic"  data-user-type="staff" onchange='showPreview(this)'
                                                                   />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <button type="submit" name="add_staffs" value="add_staffs"
                                                                class="btn btn-success"><i
                                                                class="fa fa-envelope"></i> Save
                                                        </button>
                                                        <a class="btn btn-success"
                                                           href="<?php echo base_url('user/staff-list'); ?>">Back To
                                                            Staff List</a>

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
            <!-- End of Well -->

        </div>
    </div>


    <script>
        jQuery(document).ready(function ($) {

            $(".filestyle:file").filestyle({classButton: "btn btn-primary"});

        });


    </script>

</section>



