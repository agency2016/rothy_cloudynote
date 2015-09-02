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
        <h2 class="dashboard-heading">Dashboard</h2>
    </div>
</div><!--end of title div-->

<div class="row-fluid dashboard-icon-area">
    <div class="container">
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/create-a-note.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-success">Create a Note</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">View Notes</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/class.png'); ?>" alt="Create a Note"/><br>
            <button type="submit" class="btn btn-large btn-primary">Classes</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Student Staff</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row-fluid">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid cnote-table-menu-bg">
                    <div class="span12">
                        <ul class="cnote-table-menu">
                            <li><a class="cnote-table-menu-blue" href="#">All Students</a></li>
                            <li class="cnote-table-menu-active"><a class="cnote-table-menu-white" href="#">All Staff</a></li>
                            <li><a class="cnote-table-menu-green" href="#">Opened(97)</a></li>
                            <li><a class="cnote-table-menu-black" href="#">Unopened(36)</a></li>
                            <li><a class="cnote-table-menu-red" href="#">Undelivered(3)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row-fluid table-area-header-bg">
                    <div class="span4">
                        <h2>Staff List</h2>
                    </div>
                    <div class="span2 offset6" style="padding-top: 6px">
                        <!--<a class="btn btn-large btn-success" href="#">Save Student</a>-->
                        <button type="submit" name="submit" class="btn btn-large btn-primary">Import Staff</button>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span6">
                        <ul id="table-footer">
                            <li style="display: none"><input type="checkbox" name="checkall" class="data-check-parent"></li>
                            <li style="display: none"></li>
                            <li style="display: none">First Name</li>
                            <li style="display: none">Last Name</li>
                            <li style="display: none">Staff's Email</li>
                            <li style="display: none">Phone</li>
                            <li>Class Assigned</li>
                            <li>Status</li>
                            <li style="display: none">Join Date</li>
                        </ul>
                    </div>
                    <div class="span3 custom-span">
                        <div class="student-form-group">
                            <label for="User Filter">Action</label>
                            <select id="action-filter" class="selectpicker">
                                <option selected="selected" >Select Action</option>
                                <option>Add Staff</option>
                                <option>Edit Staff</option>
                                <option>Delete Staff</option>
                                <option>Assign to Class</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">

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
                                            <th>Staff's Email</th>
                                            <th>Phone</th>
                                            <th>Class Assigned</th>
                                            <th>Status</th>
                                            <th>Join Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    //if($assigned_user_list != false and count($assigned_user_list) > 0):
                                    $i = 1;
                                    foreach($assigned_user_list as $row):
                                        //echo "<pre>"; print_r($row); echo "</pre>";
                                        ?>
                                    <tr>
                                        <td >
                                            <input type="hidden" name="data[1][name]" value="Tanim1" class="data-check">
                                            <input type="hidden" name="data[1][email]" value="adnan1@codeboxr.net" class="data-check">
                                            <input type="hidden" name="data[1][pname]" value="Shawkat1" class="data-check">
                                            <input type="checkbox" name="data[1][id]" value="1" class="data-check">
                                        </td>
                                        <td ><?php echo $i++; ?></td>
                                        <td ><?php echo $row->first_name; ?></td>
                                        <td ><?php echo $row->last_name; ?></td>
                                        <td ><?php echo $row->email; ?></td>
                                        <td>4xx xxx xxx</td>
                                        <td ><?php echo $row->section_name; ?></td>

                                        <?php
                                            if ($row->assign_status_id == 2) { $label = 'success'; $status = 'JOINED';}
                                            else if ($row->assign_status_id == 3) { $label = 'important'; $status = 'UNREGISTERED'; }
                                            else { $label = 'warning'; $status = 'INVITED'; }
                                        ?>
                                        <td class="label label-<?php echo $label; ?>"><?php echo $status; ?></td>
                                        <td><?php echo $row->assign_creation_date; ?></td>
                                    </tr>
                                    <?php endforeach; //endif;?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4 selected-stu">

                    </div>
                    <div class="span4">
                        <div class="pagination">
                            <?php echo $pagination; ?>
                            <!--<ul>
                                <li><a href="#">Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Next</a></li>
                            </ul>-->
                        </div>
                    </div>
                    <div class="span4 selected-stu">
                        <p></p>
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

   (function($) {
       /*
        * Function: fnGetColumnData
        * Purpose:  Return an array of table values from a particular column.
        * Returns:  array string: 1d data array
        * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
        *           int:iColumn - the id of the column to extract the data from
        *           bool:bUnique - optional - if set to false duplicated values are not filtered out
        *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
        *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
        * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
        */
       $.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
           // check that we have a column id
           if ( typeof iColumn == "undefined" ) return new Array();

           // by default we only wany unique data
           if ( typeof bUnique == "undefined" ) bUnique = true;

           // by default we do want to only look at filtered data
           if ( typeof bFiltered == "undefined" ) bFiltered = true;

           // by default we do not wany to include empty values
           if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;

           // list of rows which we're going to loop through
           var aiRows;

           // use only filtered rows
           if (bFiltered == true) aiRows = oSettings.aiDisplay;
           // use all rows
           else aiRows = oSettings.aiDisplayMaster; // all row numbers

           // set up data array
           var asResultData = new Array();

           for (var i=0,c=aiRows.length; i<c; i++) {
               iRow = aiRows[i];
               var aData = this.fnGetData(iRow);
               var sValue = aData[iColumn];

               // ignore empty values?
               if (bIgnoreEmpty == true && sValue.length == 0) continue;

               // ignore unique values?
               else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

               // else push the value onto the result data array
               else asResultData.push(sValue);
           }

           return asResultData;
       }}(jQuery));


   function fnCreateSelect( aData, heading )
   {
       var r='<select><option value="">'+heading+'</option>', i, iLen=aData.length;
       for ( i=0 ; i<iLen ; i++ )
       {
           r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
       }
       return r+'</select>';
   }


   $(document).ready(function() {
       /* Initialise the DataTable */
       var oTable = $('#adnanform').dataTable( {
           "bLengthChange" : false,
           //"bFilter" : false,
           "bPaginate"   : true,
           "iDisplayLength": 50,
           "aLengthMenu": [[25, 50, 100, -1], [50, 100, "All"]],
           "aoColumnDefs": [
               { 'bSortable': false, 'aTargets': [ 0, 1 ] }
           ],
           "oLanguage": {
               "sSearch": ""
           }
       } );
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

       $('.dataTables_filter input').attr("placeholder", "enter seach terms here");
       //$('.dataTables_filter').hide();

       /* Add a select menu for each TH element in the table footer */
       $("#table-footer li").each( function ( i ) {
           var heading = $(this).text();
           this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i), heading );
           $('select', this).change( function () {
               oTable.fnFilter( $(this).val(), i );
           } );
       } );
   } );
</script>











/*******************************************/
<!--<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span3">-->
                    <!-- Left Sidebar Menu Start -->


                    <?php //$this->view('page/include/left_side_menu'); ?>

                    <!-- Left Sidebar Menu End -->


                <!--</div>
                <div class="span9">
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="cldnt-user-list">
                                        <?php /*echo (isset($add_section_waring) and !empty($add_section_waring)) ? '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>'.$add_section_waring.'</div>' : ''; */?>
                                        <?php /*echo (isset($note_create_success) and !empty($note_create_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$note_create_success.'</div>' : ''; */?>
                                        <?php /*echo (isset($user_no_found) and !empty($user_no_found)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sorry! </strong>'.$user_no_found.'</div>' : ''; */?>
                                        <?php /*echo (isset($remove_user_error) and !empty($remove_user_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$remove_user_error.'</div>' : ''; */?>
                                        <?php /*echo (isset($update_profile_success) and !empty($update_profile_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$update_profile_success.'</div>' : ''; */?>
                                        <?php /*echo (isset($remove_user_success) and !empty($remove_user_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$remove_user_success.'</div>' : ''; */?>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name of Organisation</th>
                                                <th>Name of Teacher</th>
                                                <th>Assigned Class(es)</th>
                                                <th>Assigned Date</th>
                                                <th colspan="3">Action</th>
                                            </tr>
                                            </thead>-->
                                            <?php
                                            /*if($assigned_user_list != false and count($assigned_user_list) > 0):
                                                foreach($assigned_user_list as $row):
                                                    */?><!--
                                                    <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><?php /*echo $row['organisation_name']; */?></td>
                                                        <td><?php /*echo $row['assigned_user_name']; */?></td>
                                                        <td>
                                                            <ul class="nav nav-list">
                                                                <?php /*foreach($row['assigned_section_list'] as $list): */?>
                                                                    <?php
/*                                                                    switch($list['assign_status_id']) {
                                                                        case 2:
                                                                            $label_status = 'success';
                                                                            break;
                                                                        case 3:
                                                                            $label_status = 'danger';
                                                                            break;
                                                                        default:
                                                                            $label_status = 'warning';
                                                                            break;
                                                                    }
                                                                    */?>
                                                                    <li style="border-bottom: 1px dashed;"><a href="#"><?php /*echo $list['section_name']; */?> <span class="label label-<?php /*echo $label_status; */?>"> (<?php /*echo $list['invite_status_name']; */?>)</span></a></li>
                                                                <?php /*endforeach; */?>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul class="nav nav-list">
                                                                <?php /*foreach($row['assigned_section_list'] as $list): */?>
                                                                    <li style="border-bottom: 1px dashed;"><a href="#"><?php /*echo $list['assign_creation_date']; */?></a></li>
                                                                <?php /*endforeach; */?>
                                                            </ul>
                                                        </td>
                                                        <td class="action-btn"><a href="<?php /*echo base_url('notes/view/'); */?>"><button class="btn btn-success"><i class="fa fa-user"></i></button></a></td>
                                                        <td class="action-btn"><a href="<?php /*echo base_url('notes/edit/'); */?>"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a></td>
                                                        <td class="action-btn"><a href="<?php /*echo base_url('notes/remove/'); */?>" onclick="return confirm('Are you sure want to delete this notes?')"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a></td>
                                                    </tr>
                                                    </tbody>
                                                <?php
/*                                                endforeach;
                                            endif;
                                            */?>
                                        </table>
                                    </div>
                                    <div class="cldnt-pagination">
                                        <div class="pagination">-->
                                            <?php //echo $pagination; ?>
                                       <!-- </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row-fluid"><div class="span12"></div></div>
                        </div>
                    </div><!-- End of Well -->
                <!--/div>
            </div>
        </div>
    </div>
</section>-->