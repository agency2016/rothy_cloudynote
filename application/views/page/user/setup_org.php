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
        <div class="org-setup-container">

            <div class="row-fluid">
                <div class="span12">
                    <div class="page-title">
                        <h1>Set Up Your Institute/Organization</h1>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span12">
                    <div class="breadcrumb-row-bg">
                        <div class="row-fluid">
                            <div class="span2">
                                <img src="<?php echo base_url('resources/img/icon-dashboard.png'); ?>" alt="">
                            </div>

                            <div class="span10">
                                <div id="org-setup-wizard">
                                    <div id="cloud_crumbs">
                                        <div class="tabbable">

                                            <ul class="breadcumb nav nav-tabs">
                                                <li><a href="#profile" class="link" data-toggle="tab">Fill-up Profile</a></li>
                                                <li><a href="#create-section" class="link" data-toggle="tab">Create Class</a></li>
                                                <li><a href="#add-staff" class="link" data-toggle="tab">Add Staff</a></li>
                                                <li><a href="#add-members" class="link" data-toggle="tab">Add Students</a></li>
                                                <li><a href="#finish" class="link" data-toggle="tab">Finish</a></li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span10 offset1">
                                <div class="org-setup-form-container">
                                    <form class="form-horizontal" action="<?php echo base_url('user/edit-profile'); ?>" method="post">
                                        <div class="tab-content">

                                            <div class="tab-pane" id="profile">

                                                <div class="control-group">
                                                    <label class="control-label">Profile For</label>
                                                    <div class="controls">
                                                        <span class="org-setup-email uneditable-input"><?php echo $login_user_data->email; ?></span>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Organisation Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="org_name" id="org-name" placeholder="Organisation Name" value="<?php echo (set_value('org_name')) ? set_value('org_name'): $login_user_data->organisation_name; ?>">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Organisation Logo</label>
                                                    <div class="controls">
                                                        <input type="hidden" name="org_logo" value="">
                                                        <a href="#org-modal" role="button" class="btn" data-toggle="modal">Upload Logo</a>
                                                    </div>
                                                </div><!-- End organisation logo -->




                                                <div class="control-group">
                                                    <label class="control-label">First Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="org_admin_fnames" id="org-admin-fname" placeholder="First Name" value="<?php echo (set_value('fname')) ? set_value('fname'): $login_user_data->first_name; ?>">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Last Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="org_admin_lname" id="org-admin-lname" placeholder="Last Name" value="<?php echo (set_value('lname')) ? set_value('lname'): $login_user_data->last_name; ?>">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Profile Picture</label>
                                                    <div class="controls">
                                                        <input type="file">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">City</label>
                                                    <div class="controls">
                                                        <input type="text" name="city" id="org-admin-city" placeholder="City">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Country</label>
                                                    <div class="controls">
                                                        <select name="country_list" id="org-admin-country-id" class="country-list">
                                                            <option value="">Select a country</option>
                                                            <?php foreach($country_list as $clist): ?>
                                                                <option value="<?php echo $clist->country_id; ?>" data-country-code="<?php echo $clist->country_code_char2; ?>"><?php echo $clist->country_name; ?> ( <?php echo $clist->country_code_char3; ?> )</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">State / Provinces</label>
                                                    <div class="controls">
                                                        <select name="state" id="org-admin-state-id" class="state">
                                                            <option value="">Select your State / Provinces</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Timezone</label>
                                                    <div class="controls">
                                                        <select name="timezone_id" id="org-admin-timezone-id">
                                                            <option value="">Select your timezone</option>
                                                            <?php foreach($timezone_list as $tlist): ?>
                                                                <option value="<?php echo $tlist->timezone_id; ?>">( <?php echo $tlist->timezone_shown_as; ?> ) <?php echo $tlist->timezone_full_name; ?> </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <!--set up class -->
                                            <div class="tab-pane" id="create-section">
                                                <div class="row-fluid">
                                                    <div class="span8">
                                                        <div class="maindiv">
                                                            <div data_id='1' id="parentdiv_1" class="parentdiv">
                                                                <p>
                                                                    <input  class="required" data_pid='1' type="text" id="parent_new_1" size="20" name="parent_new_1" value="" placeholder="Input Year Name" />  <i class="fa fa-plus-circle" height="15px" data_pid='1' width="15px" id="addparent"></i>
                                                                </p>
                                                                <div data_cdivid='1' data_pid='1' style="margin-left:300px;"id="childdiv_1" class="childdiv">
                                                                    <ul class="child-list">
                                                                        <li class="child-list"><input   class="required" data_cid='1' data_pid='1' type="text" id="child_new_1_p_1" size="20" name="child_new_1_p_1" value="" placeholder="Add Class" />  <i class="fa fa-plus-circle" data_cid='1' data_pid='1' height="15px" width="15px" id="addchild" ></i></li>
                                                                        <li class="child-list"><input  class="required" data_cid='2' data_pid='1' type="text" id="child_new_2_p_1" size="20" name="child_new_2_p_1" value="" placeholder="Add Class" />  <i class="fa fa-minus-circle" data_cid='2' data_pid='1' height="15px" width="15px" id="removechild"></i> <i class="fa fa-plus-circle" data_cid='2' data_pid='1' height="15px" width="15px" id="addchild"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <div class="tooltip_side" >
                                                            <p class="tooltip_side_p">Start by creating a Year eg. Year K <br> and then add the Class Names in Year K.
                                                                <br>once completed add another Year and then <br>the Class Names for that year .You can do this<br> by Year and Class or Grade and Teacher or Age group. and then Team name for Sports Clubs and so on...<br>
                                                            </p>
                                                            <p class="tooltip_side_close pull-right" id="button_bellow">OK GOT IT</p>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="tooltip_beside">
                                                            <p class="tooltip_under">Tip:You can add multiple Class Names for each Year Name <br>
                                                            </p>
                                                            <p class="tooltip_beside_close pull-right" id="button_side">OK GOT IT</p>
                                                            <p class="">
                                                            <div class="cb_btn_list" style="margin-top:300px;">
                                                                <ul class="setup_school_button pull-right">
                                                                    <li class="setup_school_button">
                                                                        <button type="submit" class=" btn btn-success btn-small">Save</button>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="add-staff">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="addstaff">
                                                            <p class="cbheader">Import Staff</p>
                                                            <p>Important:<span style="text-decoration:underline">Click to download Import Template for Staff</span>(Excel File)</p>
                                                            <p>Upload the file after saving as CSV file.</p>
                                                            <input id="upload-file" type="text" name="datafilename" size="40">

                                                            <input style="position: absolute;left:-9999px;" id="file-upload-btn" type="file" name="members" class="filestyle" data-input="false">
                                                            <label   id ="file-upload-btn-show"  class="btn btn-primary change-file-value">Choose File</label>
                                                            <button type="submit" name="import_staff" value="import_students" class="btn btn-success">Import</button>

                                                        </div>
                                                        <div class="tooltip_left_div" style = "width:370px;">
                                                            <p class="tooltip_left">Importing Staff by file is really easy -<br> just double check spelling and email
                                                                <br>address details carefully.Download the<br> the template to ensure you prepare in the correct format for the system
                                                            </p>
                                                            <p class="tooltip_left_close pull-right" id="button_tip_left">OK GOT IT</p>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <ul><li style="list-style-type: none;">
                                                                <p class="cbheaderright">Add Staff</p>
                                                            </li></ul>


                                                        <div class="cbaddstaffinput">
                                                            <div data_id='1' id="parentdiv_1" class="parentdiv">
                                                                <ul style="list-style-type:none;">
                                                                    <li style="list-style-type :none;">
                                                                        <input class="cbsmall" data_pid='1' type="text" id="firstname_1" size="10" name="firstname_1" value="" placeholder="FirstName" />
                                                                    </li>
                                                                    <li style="list-style-type:none;">
                                                                        <input class="cbsmall"data_pid='1' type="text" id="lastname_1" size="10" name="lastname_1" value="" placeholder="LastName" />
                                                                    </li>
                                                                    <li style="list-style-type:none;">
                                                                        <input class="cbsmall" data_pid='1' type="text" id="email_1" size="10" name="email_1" value="" placeholder="Email" />
                                                                    </li>
                                                                    <li style="list-style-type:none;">
                                                                        <img height="15px" data_pid='1' width="15px" id="addparent" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/>
                                                                    </li>

                                                                </ul>

                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li style = "list-style-type: none;">
                                                                <div class="tooltip_right_div" style ="width:370px;">
                                                                    <p class="tooltip_right">There are two ways to add staff -<br> by import-download the Excel file and
                                                                        <br>follow the format or Manually by entering <br>in the Name and Email above <br>Remember to double check the spelling etc
                                                                    </p>
                                                                    <p class="tooltip_right_close pull-right" id="button_tip_right">OK GOT IT</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="cb_btn_list_addstaff" >
                                                            <ul class="setup_school_button_addstaff">
                                                                <li class="setup_school_button_addstaff">
                                                                    <button type="submit" name="add_staffs" value="import_students" class="btn btn-success"> Save</button>
                                                                </li>
                                                            </ul>
                                                            <ul style="padding-top:10px;">
                                                                <li style="list-style-type: none;">
                                                                    <a href="<?php echo base_url('addstudents/') ?>"><span style="text-decoration:underline;color:#3498db;">Skip add staff and go to next <br>(You can add staff later)</span></a>
                                                                </li>
                                                            </ul>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                                <div class="tab-pane" id="add-members">
                                                        <div class="row-fluid">
                                                                <div class="span3" style="padding:5px;" >
                                                                    Available Year
                                                                </div>
                                                                <div class="span3"style="padding:5px;">
                                                                    Available Classes
                                                                </div>
                                                                <div class="span6"style="padding:5px;">
                                                                    Upload Prepared CSV
                                                                </div>
                                                        </div>
                                                        <div class="row-fluid">

                                                                <div class="span3" style="padding:12px;" >
                                                                    <p style="border:1px solid #aaaaaa;">group_name</p>
                                                                </div>
                                                                <div class="span3"style="padding:12px;">
                                                                    <p>section_name </p>
                                                                </div>
                                                              <div class="span6"style="padding:12px;">
                                                                Upload The file after saving as CSV file
                                                                 	<div>
                                                                      <input class = "upload-file-text" id="'.$x.'" type="text" name="upload-file-info-'.$x.'" size="40"  >
                                                                      <input  id="sectioninfo-'.$x.'"  type="hidden" name="sectioninfo-'. $x .'" value="'.${'data' . $x}[0] ->section_id.'"  size="40" >
                                                                      <input  id="groupinfo-'.$x.'"  type="hidden" name="groupinfo-'. $x .'" value="'.${'data' . $x}[0] ->group_name.'"  size="40" >
                                                                      <input  style="display:none;" class ="upload" id="files-'.$x.'" type="file" name="files'.$x.'" multiple>
                                                                      <label   id ="file-upload-btn-show'.$x.'"  class="file-upload-btn-show btn btn-primary">Choose File</label>
                                                                    </div>

                                                                </div>

                                                        </div>

                                                       <div class="tooltip_bellow">
                                                            <p class="tooltip_bellow_student">Tip:First select the year or group then prepare a separate file for each class
                                                                within that year.Once completed click save and upload students.You can check all is imported corectly and then come back
                                                                and complete the following years.  <br>
                                                            </p>
                                                            <p class="tooltip_bellow_close" id="button_bellow">OK GOT IT</p>
                                                        </div>
                                                 </div>

                                            <div class="tab-pane" id="finish">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="cbsetupschoolsuccess">
                                                            <p><?php  echo $this->session->flashdata('add_member_success'); ?></p>
                                                            <p><?php  echo $this->session->flashdata('result_msg'); ?></p>
                                                            <p><?php  echo $this->session->flashdata('year_count'); ?></p>
                                                            <p><?php  echo $this->session->flashdata('class_count'); ?></p>
                                                            <p><?php  echo $this->session->flashdata('student_count'); ?></p>
                                                            <a href="<?php echo base_url('user/') ?>"><button class="cb-dashboard-button btn btn-success btn-large">Go To Dashboard</button></a>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

    <ul class="pager wizard breadcumb-wizard">
        <li class="previous"><a href="#note-area">Back</a></li>
        <li class="next"><a href="#note-area">Next Step</a></li>
    </ul>

    </div>
    </form>


                                    <!-- Modal for organisation logo-->
                                    <div id="org-modal" class="modal hide fade">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel">Upload Organisation Logo(550pxX75px)</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id="org-logo-upload-form" action="<?php echo base_url( 'user/org_image_upload' ) ;?>" method="post" enctype="multipart/form-data">
                                                <div class="control-group">
                                                    <input type="file" accept="image/jpeg" name="org_image" id="upload-org-image"/>
                                                    <img class="uploadPreview" id="org-logo-preview" style="display:none;"/>
                                                    <!-- hidden inputs -->
                                                    <input type="hidden" id="x" name="x" />
                                                    <input type="hidden" id="y" name="y" />
                                                    <input type="hidden" id="w" name="w" />
                                                    <input type="hidden" id="h" name="h" />
                                                </div>
                                                <div class="control-group">
                                                    <input type="submit" class="btn btn-info" value="Save Changes">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    </div>
</div>

</section>