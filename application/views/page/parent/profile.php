<?php
/**
 * Created by PhpStorm.
 * User: Ridhia
 * Date: 1/4/13
 * Time: 3:38 PM
 */
$this->view('page/dashboard-icon-menu/parent-icon');
$this->view('template/upload_image');
?>

<section class="main-content-body" xmlns="http://www.w3.org/1999/html">
<div class="container">
<div class="container-wrapper">


<div class="well">
<div class="cldnt-info-area">
<div class="alert" style="display: none;">Updated Successfully</div>
<div class="clearfix"></div>
<div class="row-fluid">

<!-- <div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
     <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
         <li class="ui-state-default ui-corner-top"><a class="ui-tabs-anchor">Parent/Caregiver Info</a></li>
         <li class="ui-state-default ui-corner-top"><a class="ui-tabs-anchor">Children Info</a></li>
     </ul>
 </div>-->
<!-- <div class="user-edit-form-header">
     <div class="user-innerheader">Parent/Caregiver Info</div>
     <div class="user-innerheader">Children Info</div>
 </div>-->
<div class="span6">
    <?php $this->view('page/parent/logged_parent'); ?>
</div>
<div class="span6">
<div class="user-innerheader">My Children</div>
<div id="studenttabs">
<ul>
    <?php foreach ($section_member_data as $key => $child) { ?>
        <li>
            <a href="#tabs-<?php echo $key; ?>"><?php echo $child->section_member_first_name . ' ' . $child->section_member_last_name; ?></a>
        </li>
    <?php } ?>
</ul>
<?php foreach ($section_member_data as $key => $child) { ?>
    <div id="tabs-<?php echo $key; ?>">
    <form class="form-horizontal" id="child-ajax-<?php echo $key; ?>" action="" name="child-form" method="POST">
        <?php echo validation_errors(); ?>
        <input type="hidden" name="section_member_id"
               value="<?php echo (set_value('section_member_id')) ? set_value('section_member_id') : $child->section_member_id; ?>">

        <div class="user-innerheader">Children Info</div>
        <div class="user-edit-form">
            <div class="control-group">
                <label class="control-label">First Name</label>

                <div class="controls">
                    <input type="text" name="section_member_first_name" placeholder="First Name"
                           value="<?php echo (set_value('section_member_first_name')) ? set_value('section_member_first_name') : $child->section_member_first_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Last Name</label>

                <div class="controls">
                    <input type="text" name="section_member_last_name" placeholder="Last Name"
                           value="<?php echo (set_value('section_member_last_name')) ? set_value('section_member_last_name') : $child->section_member_last_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Gender</label>
                <?php //echo($child->section_member_gender);?>
                <div class="controls">
                    <div class="radio">
                        <input type="radio" name="section_member_gender"
                               value="0" <?php echo($child->section_member_gender == '0'?'checked="checked"':''); ?>>
                        <label for="male">Male</label>
                        <input type="radio" name="section_member_gender"
                               value="1" <?php echo ($child->section_member_gender == '1'?'checked="checked"':''); ?>>
                        <label for="female">Female</label>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Date of Birth</label>
                <?php $date = date("d-m-Y", strtotime($child->section_member_date_of_birth)) ?>
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
                           value="<?php echo (set_value('section_member_allergie')) ? set_value('section_member_allergie') : $child->section_member_allergie; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Special</br>(if need any)</label>

                <div class="controls">
                    <textarea name="section_member_special" rows="4"
                              cols="50"><?php echo (set_value('section_member_special')) ? set_value('section_member_special') : $child->section_member_special; ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Profile Photo</label>
                <div class="controls">
                    <div class="cdimage">
                        <?php
                        $url= base_url().'upload/avatar/student/'.md5(md5($child->section_member_id)).'.'.$child->image_ext ;
                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                            $url =  base_url().'resources/img/blank.jpeg';
                        }
                        ?>
                        <img id = '<?php echo $child->section_member_id;?>' class="imageloadedparentprofile"  src="<?php echo $url ;?>" alt="Image Not Found" width="120" height="180">
                        <br>
                        <input  class="add-image buttonpp" type="button"  value="Add" data-user-id="<?php echo $child->section_member_id;?>" data-user-type="student">
                        <input  class="buttonpp" type="button"  value="Change" name="Submit">
                    </div>
                </div>

            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" data-formid="child-ajax-<?php echo $key; ?>"
                            class="child-save btn btn-success">Save Child Info
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="clearfix" style="border-bottom: 1px solid #000000;"></div>
    <!--user-edit-form of child-->
    <form class="form-horizontal" id="other-parent-ajax-<?php echo $key; ?>" action="" method="POST">
        <input type="hidden" name="id"
               value="<?php echo (set_value('id')) ? set_value('id') : $child->other_parent->id; ?>">

        <div class="user-innerheader">Parent/Caregiver Info</div>
        <div class="user-edit-form">

            <div class="control-group">
                <label class="control-label">First Name</label>

                <div class="controls">
                    <input type="text" name="first_name" placeholder="First Name"
                           value="<?php echo (set_value('first_name')) ? set_value('first_name') : $child->other_parent->first_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Last Name</label>

                <div class="controls">
                    <input type="text" name="last_name" placeholder="Last Name"
                           value="<?php echo (set_value('last_name')) ? set_value('last_name') : $child->other_parent->last_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Relation With Child</label>

                <div class="controls">
                    <select name="relationwithchild">
                        <option value="">Select your Relation</option>
                        <?php foreach ($relation_with_child as $relation):
                            $selected = "";
                            if ($relation->id == $child->other_parent->relationwithchild)
                                $selected = "selected";
                            ?>
                            <option value="<?php echo $relation->id; ?>"
                                    selected="<?php echo $selected; ?>"><?php echo $relation->relation; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address 1</label>

                <div class="controls">
                    <input type="text" name="address1" placeholder="Address 1"
                           value="<?php echo (set_value('address1')) ? set_value('address1') : $child->other_parent->address1; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address 2</label>

                <div class="controls">
                    <input type="text" name="address2" placeholder="Address 2"
                           value="<?php echo (set_value('address2')) ? set_value('address2') : $child->other_parent->address1; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">City</label>

                <div class="controls">
                    <input type="text" name="city_name" placeholder="City"
                           value="<?php echo (set_value('city_name')) ? set_value('city_name') : $child->other_parent->city_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country <!-- <span class="required">*</span> --></label>

                <div class="controls">
                    <select class="country-id" id="section_member_caregivers_country_id" name="country_id" data-country="state<?php echo $child->other_parent->id; ?>">
                        <option value="">Select your Country</option>
                        <?php foreach ($country_list as $clist):
                            $selected = "";
                            if ($clist->country_id == $child->other_parent->country_id)
                                $selected = 'selected ="selected"';
                            ?>
                            <option value="<?php echo $clist->country_id; ?>"
                                    data-country-code="<?php echo $clist->country_code_char2; ?>"
                                <?php echo $selected; ?>>
                                <?php echo $clist->country_name; ?>( <?php echo $clist->country_code_char3; ?> )
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">State / Provinces</label>
                <div class="controls">
                    <select class="state state<?php echo $child->other_parent->id; ?>" name="state_id"
                            id="section_member_caregivers_state_id"
                            data-state-of="section_member_caregivers_country_id">
                        <option value="">Select your State / Provinces</option>

                    </select>
                </div>

            </div>


            <div class="control-group">
                <label class="control-label">Postcode</label>

                <div class="controls">
                    <input type="text" name="postcode" placeholder="Postcode"
                           value="<?php echo (set_value('postcode')) ? set_value('postcode') : $child->other_parent->postcode; ?>">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Timezone</label>

                <div class="controls">
                    <select name="timezone_id">
                        <option value="">Select Timezone</option>
                        <?php foreach ($timezone_list as $tlist):
                            $selected = "";
                            if ($tlist->timezone_id == $child->other_parent->timezone_id)
                                $selected = 'selected ="selected"';
                            ?>
                            <option value="<?php echo $tlist->timezone_id; ?>" <?php echo $selected; ?>>
                                ( <?php echo $tlist->timezone_shown_as; ?>
                                ) <?php echo $tlist->timezone_full_name; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br>
            <br>

            <div class="control-group">
                <label class="control-label">Work Phone</label>

                <div class="controls">
                    <input type="text" name="workphone" placeholder="Work Phone"
                           value="<?php echo (set_value('workphone')) ? set_value('city_name') : $child->other_parent->workphone; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Home Phone</label>

                <div class="controls">
                    <input type="text" name="homephone" placeholder="Home Phone"
                           value="<?php echo (set_value('homephone')) ? set_value('homephone') : $child->other_parent->homephone; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Mobile Phone</label>

                <div class="controls">
                    <input type="text" name="mobilephone" placeholder="Mobile Phone"
                           value="<?php echo (set_value('mobilephone')) ? set_value('mobilephone') : $child->other_parent->mobilephone; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Profile Photo</label>

                <div class="controls">
                    <div class="cdimage">
                        <?php
                        $url= base_url().'upload/avatar/parent/'.md5(md5($child->other_parent->id)).'.'.$child->other_parent->image_ext ;
                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                            $url =  base_url().'resources/img/blank.jpeg';
                        }

                        ?>
                        <img id = '<?php echo $child->other_parent->id;?>' class="imageloadedparentprofile"  src="<?php echo $url ;?>" alt="Image Not Found" width="120" height="180">
                        <br>
                        <input  class="add-image buttonpp" type="button"  value="Add" data-user-id="<?php echo $child->other_parent->id;?>" data-user-type="parent">
                        <input  class="buttonpp" type="button"  value="Change" name="Submit">
                    </div>

                </div>

            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" data-formid="other-parent-ajax-<?php echo $key; ?>"
                            class="save-other-parent btn btn-success">Save Parent Info
                    </button>
                </div>
            </div>

        </div>
    </form>
    </div>
<?php } ?>


</div>
</div>
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
        var json_state_list = <?php echo $state_list; ?>


        /*$(".country-id").each(function() {
            var state_selector = $(this).attr('id');
            var country_code = $(this).find(':selected').data('country-code');
            //console.log(country_code);
            $('select[data-state-of=' + state_selector + ']').children('option.removable').remove();
            //$('option [data-state-of=' + state_selector + ']').append(json_state_list.state_list[country_code]);
            $('#section_member_caregivers_state_id').append("<option></option>").attr("value", json_state_list.state_list[country_code]).text(json_state_list.state_list[country_code]);
            //c($('select[data-state-of=' + state_selector + ']').append(json_state_list.state_list[country_code]));
        });*/

      var output = [];

        $(".country-id").each( function(){
            var state_selector = $(this).attr('id');
            var data_country = $(this).attr('data-country');
            var country_code = $(this).find(':selected').data('country-code');
            $('select[data-state-of=' + state_selector + ']').children('option.removable').remove();
            output.push('<option value="'+ json_state_list.state_list[country_code] +'">'+ json_state_list.state_list[country_code] +'</option>');
        //console.log(data_country);
            $('.'+data_country).html(output.join(''));

        });


        $('.country-id').on('change', function (evnt) {
            var state_selector = $(this).attr('id');
            //$(".section_member_caregivers_state_id").remove();
            var country_code = $(this).find(':selected').data('country-code');
            $('select[data-state-of=' + state_selector + ']').children('option').remove();
            $('select[data-state-of=' + state_selector + ']').append(json_state_list.state_list[country_code]);
        });
        $(function () {
            $("#studenttabs").tabs();
        });
        $('.date-of-birth').datepicker();






        $("button.save-parent").on('click', function (e) {
            e.preventDefault();
            var form_id = $(this).attr('data-formid');
            var parentDataString = $("#" + form_id).serialize();
            ////console.log(parentDataString);
            $.ajax({
                url: "<?php echo base_url('user/save-parent'); ?>",
                type: "POST",
                async: false,
                data: {parentDataString: parentDataString},
                //dataType: "json",
                success: function (response) {
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
        $("button.child-save").on('click', function (e) {
            e.preventDefault();
            ////console.log('hello');
            var formid = $(this).attr('data-formid');
            var childDataString = $("#" + formid).serialize();
           // //console.log(childDataString);
            $.ajax({
                url: "<?php echo base_url('user/post-ajax-save-child-profile'); ?>",
                type: "POST",
                async: false,
                data: {childDataString: childDataString},
                success: function (response) {
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

        $("button.save-other-parent").on('click', function (e) {
            e.preventDefault();
            //console.log('hello');
            var formid = $(this).attr('data-formid');
            //var form = $(this).parents('form:first').attr('id');
            ////console.log(form);
            //var childDataString = $(this.form).serialize();
            var otherParentDataString = $("#" + formid).serialize();
            ////console.log(otherParentDataString);
            $.ajax({
                url: "<?php echo base_url('user/save-other-parent'); ?>",
                type: "POST",
                async: false,
                data: {otherParentDataString: otherParentDataString},
                //dataType: "json",

                success: function (response) {
                   // //console.log(response);
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
    });
</script>