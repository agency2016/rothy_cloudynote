<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/20/14
 * Time: 4:31 PM
 */
?>

<div class="row-fluid row-bg">
    <div class="dashboard-header">
        <div class="container">
            <div class="span3">
                <div class="dashboard-logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('resources/img/cloudenote_header_logo.png'); ?>" /></a><!-- End of logo -->
                </div><!-- End of logo div -->
            </div><!-- End of logo column -->
            <div class="span8">
                <div class="cb_navigation_dashboard">
                    <ul class="nav nav-pills">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            <a href="#">Create New</a>
                        </li>
                        <li>
                            <a href="#">View Notes</a>
                        </li>
                        <li>
                            <a href="#">Students</a>
                        </li>
                        <li>
                            <a href="#">Teachers</a>
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                    </ul><!-- End of navigation -->

                </div><!-- End of menu div -->
            </div><!-- End of header menu column -->
            <div class="span1">
                <div class="btn-group pull-right dashboard-user-icon">
                    <button class="btn"><i class="fa fa-user"></i> <?php //echo $this->session->userdata('CN_first_name'); ?></button>
                    <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php //echo ($login_user_data->user_access_level > '2') ? base_url('user/profile') : base_url('dashboard/profile'); ?>"><i class="fa fa-info-circle"></i> View Profile</a></li>
                        <li><a href="<?php //echo ($login_user_data->user_access_level > '2') ? base_url('user/settings') : base_url('dashboard/settings'); ?>"><i class="fa fa-wrench"></i> Settings</a></li>
                        <li><a href="<?php //echo base_url('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        <!--<li class="divider"></li>
                        <li><a href="#">Separated link</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid row-title-bg">
    <div class="container">
        <h2 class="dashboard-heading">Add Student</h2>
    </div>
</div>

<!-- Div for the cutom breadcrumb for cloudenotes-->
<div class="row-fluid breadcrumb-row-bg">
    <div class="container">
        <div class="span2">
            <img src="<?php echo base_url('resources/img/icon-dashboard.png'); ?>" alt="">
        </div>
        <div class="span10">
            <div id="cloud_crumbs">
                <ul>
                    <li><a href="#1">1. Begin Note</a></li>
                    <li><a href="#2">2. Add Details</a></li>
                    <li><a href="#3">3. Add Receivers</a></li>
                    <li><a href="#4">4. Preview</a></li>
                    <li><a href="#5">5. Send</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="container">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid table-area-header-bg">
                    <div class="span4">
                        <h2>Student List</h2>
                    </div>
                    <div class="span2 offset6" style="padding-top: 6px">
                        <!--<a class="btn btn-large btn-success" href="#">Save Student</a>-->
                        <button type="submit" name="submit" class="btn btn-large btn-success">Save Student</button>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4">
                        <div class="student-form-group">
                            <label for="User Filter">User Filter </label>
                            <select id="class-filter" class="selectpicker">
                                <option selected="selected" >All Classes</option>
                                <option>Class 1</option>
                                <option>Class 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="span5">
                        <div class="student-form-group">
                            <label for="Search Student">Search Student </label>
                            <input type="text" id="rg-to" name="rg-to" value="" class="form-control">
                        </div>
                    </div>
                    <div class="span1 offset2 print-result">
                        <img src="<?php echo base_url('resources/img/icon-printer.png'); ?>" alt=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <form id="form" action="" method="post">
                                <!--<div style="text-align:right; padding-bottom:1em;">
                                    <button type="submit" name="submit">Submit form</button>
                                </div>-->

                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" class="data-check-parent"></th>
                                            <th></th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Student ID</th>
                                            <th>Caregiver Name</th>
                                            <th>Recepient's Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; ?>
                                    <?php foreach ($student_list as $list): ?>
                                        <tr>
                                            <td class="center">
                                                <input type="hidden" name="data[1][name]" value="Tanim1" class="data-check">
                                                <input type="hidden" name="data[1][email]" value="adnan1@codeboxr.net" class="data-check">
                                                <input type="hidden" name="data[1][pname]" value="Shawkat1" class="data-check">
                                                <input type="checkbox" name="data[1][id]" value="1" class="data-check">
                                            </td>
                                            <td class="center"><?php echo ++$i; ?></td>
                                            <td class="center"><?php echo $list->section_member_first_name; ?></td>
                                            <td class="center"><?php echo $list->section_member_last_name; ?></td>
                                            <td class="center"><?php echo $list->section_member_roll_number; ?></td>
                                            <td class="center"><?php echo $list->section_member_fathers_first_name; ?></td>
                                            <td class="center"><?php echo $list->section_member_fathers_email; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4 selected-stu">
                        <div class="student-form-group1" style="margin-left:-5px">
                            <label for="User Filter">Total 4 students found. Showing </label>
                            <select id="class-filter" class="selectpicker span3">
                                <option selected="selected" >10</option>
                                <option>20</option>
                                <option>30</option>
                            </select>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="pagination">
                            <ul>
                                <li><a href="#">Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="span4 selected-stu">
                        <p>Selected 4 students of 4 students</p>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3 offset9 steps">
                        <a class="btn btn-prev-step" href="#">Previous Step</a>
                        <a class="btn btn-primary" href="#">Next Step</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var oTable = $('#adnanform').dataTable( {
            "bLengthChange" : false,
            "bPaginate"   : true,
            "iDisplayLength": 50,
            "aLengthMenu": [[25, 50, 100, -1], [50, 100, "All"]],
        } );

        /*$('#example').on('click', "tr", function(){
         var oData = oTable.fnGetData(this);
         //console.log(oData);
         })*/

        $('.data-check-parent').on('change', function () {
            if ($(this).is(':checked')) {
                $('.data-check').attr('checked', true);
            } else {
                $('.data-check').attr('checked', false);
            }
        });

        $( "#form" ).on( "submit", function( event ) {
            //event.preventDefault();
            //console.log( $( this ).serialize() );
            ////console.log( $( this ).serializeArray() );
        });
    } );
</script>
