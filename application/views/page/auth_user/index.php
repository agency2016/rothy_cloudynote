<?php $this->view('page/dashboard-icon-menu/index'); ?>
<div class="container">
    <div class="row-fluid">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid cnote-table-menu-bg">
                    <div class="span12">
                        <ul class="cnote-table-menu">
                            <li style="width: 50%;"><a class="cnote-table-menu-blue" href="<?php echo base_url('user/students'); ?>">All
                                    Students</a></li>
                            <li style="width: 50%;" class="cnote-table-menu-active"><a class="cnote-table-menu-white"
                                                                   href="<?php echo base_url('user/staff-list') ?>">All
                                    Staff</a></li>
                           <!-- <li><a class="cnote-table-menu-green" href="#">Opened(97)</a></li>
                            <li><a class="cnote-table-menu-black" href="#">Unopened(36)</a></li>
                            <li><a class="cnote-table-menu-red" href="#">Undelivered(3)</a></li>-->
                        </ul>
                    </div>
                </div><!--cnote-table-menu-bg-->
                <div class="row-fluid table-area-header">
                    <div class="span4">
                        <h3>Staff List</h3>
                    </div>
                    <div class="span2 offset6" style="padding-top: 6px">
                        <a href="<?php echo base_url('user/add-staff'); ?>">
                            <button type="submit" name="submit" class="btn btn-large btn-primary">Import Staff</button>
                        </a>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span9">
                        <ul id="table-footer">
                            <li style="display: none"><input type="checkbox" name="checkall" class="data-check-parent"></li>
                            <li style="display: none"></li>
                            <li style="display: none"></li>
                            <li style="display: none">First Name</li>
                            <li style="display: none">Last Name</li>
                            <li style="display: none">Staff's Email</li>
                            <li style="display: none">Phone</li>
                            <li>Year</li>
                            <li>Class</li>
                            <li>Status</li>
                            <li style="display: none">Join Date</li>
                        </ul>
                    </div>
                    <div class="span3 custom-span">
                        <div class="student-form-group">
                            <label for="User Filter">Action</label>
                            <select id="action-filter" class="selectpicker">
                                <option selected="selected">Select Action</option>
                                <option value="edit_staff">Edit Staff</option>
                                <option value="delete_staff">Delete Staff</option>
                                <option value="assign_staff">Assign to Class</option>
                                <option value="send_invite">Send Invite</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" class="data-check-parent staff-checkbox"></th>
                                    <th></th>
                                    <th style="display: none;"></th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Staff's Email</th>
                                    <th>Phone</th>
                                    <th style="display: none;">Year</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($assigned_user_list != false and count($assigned_user_list) > 0):
                                    $i = 1;
                                    foreach ($assigned_user_list as $row):
                                        //echo "<pre>"; print_r($row); echo "</pre>";
                                        ?>
                                        <tr>

                                            <td>
                                                <input type="checkbox" name="data[1][id]" value="1" class="data-check staff-checkbox">
                                            </td>
                                            <td style="display: none;"><?php echo $row->user_id; ?></td>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row->first_name; ?></td>
                                            <td><?php echo $row->last_name; ?></td>
                                            <td><?php echo $row->email; ?></td>
                                            <td><?php echo $row->mobilephone; ?></td>
                                            <td style="display: none;"><?php echo $row->group_name; ?></td>
                                            <td><?php echo ($row->section_name != '') ? $row->section_name : "Not Assigned"; ?></td>

                                            <?php
                                            if ($row->invited_id == 2) {
                                                $label = 'warning';
                                            } else if ($row->invited_id == 3) {
                                                $label = 'success';
                                            } else if ($row->invited_id == 4) {
                                                $label = 'important';
                                            } else {
                                                $label = 'info';
                                            }
                                            ?>
                                            <td class="label label-<?php echo $label; ?>"><?php echo ($row->invite_status_name != '') ? $row->invite_status_name : "Not Invited"; ?></td>
                                            <td><?php echo ($row->assign_creation_date != '') ? date("d-M-Y", strtotime($row->assign_creation_date)) : " "; ?>
                                                <?php //echo $date = date("d-m-Y", strtotime($row->assign_creation_date)) ?></td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4 selected-stu">
                    </div>
                    <div class="span4">
                        <div class="pagination">
                            <?php //echo $pagination; ?>
                        </div>
                    </div>
                    <div class="span4 selected-stu">
                        <p></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="staff_modal" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3></h3>
    </div>
    <div class="modal-body">
        <h4></h4>
        <h6></h6>

        <div class="select_moveto_class" style="display: none;">

        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="move_member" class="btn btn-success">Move</a>
        <a href="#" id="closenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
<div id="staff_email_modal" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3></h3>
    </div>
    <div class="modal-body">
        <h4></h4>
        <h6></h6>

        <div class="select_moveto_class" style="display: none;">
            <?php $this->view('page/auth_user/staff_invite'); ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="email_member" class="btn btn-success">Send</a>
        <a href="#" id="closen_refresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>

<script>

(function ($) {
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
    $.fn.dataTableExt.oApi.fnGetColumnData = function (oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty) {
        // check that we have a column id
        if (typeof iColumn == "undefined") return new Array();

        // by default we only wany unique data
        if (typeof bUnique == "undefined") bUnique = true;

        // by default we do want to only look at filtered data
        if (typeof bFiltered == "undefined") bFiltered = true;

        // by default we do not wany to include empty values
        if (typeof bIgnoreEmpty == "undefined") bIgnoreEmpty = true;

        // list of rows which we're going to loop through
        var aiRows;

        // use only filtered rows
        if (bFiltered == true) aiRows = oSettings.aiDisplay;
        // use all rows
        else aiRows = oSettings.aiDisplayMaster; // all row numbers

        // set up data array
        var asResultData = new Array();

        for (var i = 0, c = aiRows.length; i < c; i++) {
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
    }
}(jQuery));


function fnCreateSelect(aData, heading) {
    var r = '<select id="selectOption' + heading + '"><option value="">' + heading + '</option>', i, iLen = aData.length;
    //r += '<option value="Not Assigned">Not Assigned</option>';
    for (i = 0; i < iLen; i++) {
        r += '<option value="' + aData[i] + '">' + aData[i] + '</option>';
    }
    return r + '</select>';
}


$(document).ready(function () {
    /* Initialise the DataTable */
    var oTable = $('#adnanform').dataTable({
        "bLengthChange": false,
        //"bFilter" : false,
        "bPaginate": true,
        "iDisplayLength": 50,
        "aLengthMenu": [
            [25, 50, 100, -1],
            [50, 100, "All"]
        ],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0, 1 ] }
        ],
        "oLanguage": {
            "sSearch": ""
        }
    });

    var flag;
    $('.data-check-parent').on('change', function () {
        if ($(this).is(':checked')) {
            flag = 0;
            $('.data-check').attr('checked', true);
        } else {
            flag = 1;
            $('.data-check').attr('checked', false);
        }
    });

    $("#form").on("submit", function (event) {
        //event.preventDefault();
        console.log($(this).serialize());
        //console.log( $( this ).serializeArray() );
    });

    $('.dataTables_filter input').attr("placeholder", "enter seach terms here");
    //$('.dataTables_filter').hide();

    /* Add a select menu for each TH element in the table footer */
    $("#table-footer li").each(function (i) {
        var heading = $(this).text();
        this.innerHTML = fnCreateSelect(oTable.fnGetColumnData(i), heading);
        $('select', this).change(function () {
            oTable.fnFilter($(this).val(), i);
        });
    });

    function removeNewlines(str) {
        //remove line breaks from str
        str = str.replace(/\s{2,}/g, ' ');
        str = str.replace(/\t/g, ' ');
        str = str.replace(/\n{2,}/g, ' ');
        str = str.toString().trim().replace(/(\r\n|\n|\r)/g, "");
        return str;
    }

    $("#action-filter").on('change', function () {
        var selectedOpt = $(this).val();
        if (selectedOpt == 'assign_staff') {

          if ($("#selectOptionClass").find('option:selected').val() != '' ){
            $("#staff_modal").modal();
            $(".modal-header h3").html("Assign Staff");
            $(".modal-body h4").html("Choose Your Class:");

            var staffDataArr = [];
            $.each($(".staff-checkbox:checked"), function () {
                var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                singleElement = removeNewLines.split(' ');
                staffDataArr.push(singleElement);                       //pushing the collected data into dataArray which will go to the modal
            });
            if (flag == 0) {
                staffDataArr.splice(0, 2); //remove first two index as data table row will be in the text value item.
            }

            var classListFromPHP    = <?php echo $classList; ?>;
            classListFromPHP        = JSON.stringify(classListFromPHP);
            classListFromPHP        = $.parseJSON(classListFromPHP);
               // console.log (classListFromPHP);
            var classListArr = [];
            $.each(classListFromPHP, function(i, val) {
                var prod =[];
                prod[0] = val.section_id;
                prod[1] = val.section_hash_organisation_id;
                prod[2] = val.section_name;
                prod[3] = val.section_created_date;
                classListArr.push(prod);
            });

            var classListFiltered = [];
            $.each(classListArr, function(i, val){
              // console.log(val);

                if (val !='Not Invited' && val !='Not Invite' && val !='undefined')  classListFiltered.push(val);
            });
            //console.log ('array : '+ classListFiltered);

                var  selectClass ='';
                var classchecked = '';
                for (i = 0; i < staffDataArr.length; i++) {
                     var staffclass = $("#selectOptionClass").find('option:selected').val();
                     var name = staffDataArr[i][2] + ' ' + staffDataArr[i][3];
                      // console.log ($("#selectOptionClass").find('option:selected').val());
                        selectClass += '<div class="'+name+'">';
                        selectClass += '<p>'+name+'</p>';
                    for (j=0; j<classListFiltered.length; j++){
                        //console.log(classListFiltered[j]);
                       if(staffclass == classListFiltered[j][2] && classListFiltered[j][2] != 't' )
                        {classchecked ='checked ="checked"';

                        }
                        else{
                           classchecked ='';
                       }
                      // console.log(classchecked);
                       if(classListFiltered[j][2] != 't'){
                           selectClass += '<p data-staff-email ="'+staffDataArr[i][4]+'" data-staff-name="'+name+'" data-class-name ="'+classListFiltered[j][0]+'" data-class-org-id ="'+classListFiltered[j][1]+'"><input data-check ="" class="staff-assign-class" type="checkbox" '+classchecked+'><span class ="get-class">'+classListFiltered[j][2]+'</span></p>';
                       }

                    }
                    selectClass += '</div>';

                }
                $(".modal-body  .select_moveto_class").show();
                $(".modal-footer #move_member").show();
                $(".modal-body .select_moveto_class").html(selectClass);


          /*  var selectClassOption = '<div class="student-form-group">';
            selectClassOption += '<label for="User Filter">Action</label>';
            selectClassOption += '<select id="class-filter" class="selectpicker">';
            selectClassOption += '<option selected="selected" >Select Action</option>';
            for (i=0; i<classListFiltered.length; i++){
                selectClassOption += '<option value="'+classListFiltered[i][0]+'">'+classListFiltered[i][2]+'</option>';
            }
            selectClassOption += '</select>';
            selectClassOption += '</div>';*/
              //  console.log(selectClassOption);
           ///$(".modal-body").append(selectClassOption);

        } else {
                $("#staff_modal").modal();
                $(".modal-header h3").html("Move Staff");
                $(".modal-body h4").html("Please Filter Staff by Class First!");
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#move_member").hide();
                $("#closenRefresh").on('click', function(){
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
            }
        } else if (selectedOpt == 'delete_staff') {

            var staffchecked = $(".staff-checkbox:checked").length;
           // console.log(staffchecked);
            if (staffchecked > 0) {
                var deleteArr = [];
                $.each($(".staff-checkbox:checked"), function () {

                    var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                    var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                    singleElement = removeNewLines.split(' ');        //making the string an array
                    deleteArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal
                    //console.log(singleElement);
                });
                if (flag == 0) {
                    deleteArr.splice(0, 2); //remove first two index as data table row will be in the text value item.
                }
                 console.log(deleteArr);
                $("#staff_modal").modal();
                $(".modal-header h3").html("Delete Staff");
                $(".modal-body h4").html("Are you sure you want to delete?");
                $(".modal-body .select_moveto_class").hide();
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#move_member").text("Yes");
                $("#closenRefresh").text("No").on('click', function () {
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
                $("#move_member").on('click', function () {
                  //  console.log('clicked');
                    $.ajax({
                        url: "<?php echo base_url('user/post-ajax-del-staff'); ?>",
                        type: "POST",
                        async: false,
                        data: {deleteArr: deleteArr},
                        //dataType: "json",
                        success: function (response) {
                            console.log(response);
                            ajaxResponse = jQuery.parseJSON(response);
                            if (parseInt(ajaxResponse.output)) {
                                $(".modal-body h4").hide();
                                $("#move_member").hide();
                                $(".modal-body .select_moveto_class").hide();
                                $(".modal-body").html("<h4>Staff Deleted Successfully!</h4>");
                                $("#closenRefresh").text('Close').on('click', function () {
                                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                                });

                            } else {
                                console.log('false');
                                $(".modal-body h4").hide();
                                $(".modal-body .select_moveto_class").hide();
                                $("#move_member").hide();
                                $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                                $("#delclosenRefresh").on('click', function () {
                                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                                });
                            }
                        },
                        error: function (request, status, error) {
                            console.log("something fishy!");
                        }
                    });
                });

            } else {
                $("#staff_modal").modal();
                $(".modal-header h3").html("Delete Staff");
                $(".modal-body h4").html("Please Select Staff First!");
                $(".modal-body .select_moveto_class").hide();
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#move_member").hide();
                $("#closenRefresh").on('click', function () {
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
            }

        } else if (selectedOpt == 'edit_staff') {
            var staffchecked = $(".staff-checkbox:checked").length;
            //console.log(staffchecked);
            if (staffchecked == 1) {
                var editArr = [];
                $.each($(".staff-checkbox:checked"), function () {

                    var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                    var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                    singleElement = removeNewLines.split(' ');        //making the string an array
                    editArr.push(singleElement[0]);                         //pushing the collected data into dataArray which will go to the modal

                });
                //console.log(editArr);
                var url = "<?php echo base_url('user/editStaff'); ?>";
                window.location = url + '/' + editArr;

            } else {
                $("#staff_modal").modal();
                $(".modal-header h3").html("Edit Staff");
                $(".modal-body h4").html("Please Select One Staff");
                $(".modal-body h6").html("Hit close to refresh the page!");
                $(".modal-body .select_moveto_class").hide();
                $("#move_member").hide();
                $("#closenRefresh").on('click', function () {
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
            }
        } else if (selectedOpt == 'send_invite') {

            var staffchecked = $(".staff-checkbox:checked").length;
          //  console.log(staffchecked);
            if (staffchecked > 0) {
                var inviteArr = [];
                $.each($(".staff-checkbox:checked"), function () {

                    var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                    var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                    singleElement = removeNewLines.split(' ');        //making the string an array
                    inviteArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal
                    //console.log(singleElement);
                });
               // console.log(inviteArr);
                if (flag == 0) {
                    inviteArr.splice(0, 3); //remove first two index as data table row will be in the text value item.
                }

                $("#staff_email_modal").modal();
                $(".modal-header h3").html("Send Invitation To Staff");
                $(".modal-body h4").html("");
                $(".modal-body .select_moveto_class").show();
                //$(".modal-body h6").html("Hit close to refresh the page!");
                $("#email_member").text("Send");
                $("#closen_refresh").text("No").on('click', function () {
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
                $("#email_member").on('click', function () {
                  var editorText = $('iframe').contents().find('.wysihtml5-editor').text();
                    $.ajax({
                        url: "<?php echo base_url('user/post-ajax-staff-invite'); ?>",
                        type: "POST",
                        async: false,
                        data: {inviteArr: inviteArr, inviteText: editorText},
                        //dataType: "json",
                        success: function (response) {
                            //console.log (response);
                            ajaxResponse = jQuery.parseJSON(response);
                        },
                        error: function (request, status, error) {
                            console.log("something fishy!");
                        }
                    });
                });

            } else {
                $("#staff_modal").modal();
                $(".modal-header h3").html("Send Invitation To Staff");
                $(".modal-body h4").html("Please Select Staff First!");
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#move_member").hide();
                $("#closenRefresh").on('click', function () {
                    window.location = "<?php echo base_url('user/staff-list'); ?>";
                });
            }

        }
        var selectedClassName = [];
        var selectedStaffName = [];
        var selectedClassOrgID = [];
        var selectedStaffEmail = [];

        $(".staff-assign-class").on('click', function(){

            if($(this).prop('checked',true) && $(this).data('check')=='' ){
                console.log('checked');
                selectedClassName.push ($(this).parent().data('class-name')) ;
                selectedStaffName.push( $(this).parent().data('staff-name'));
                selectedClassOrgID.push( $(this).parent().data('class-org-id'));
                selectedStaffEmail.push($(this).parent().data('staff-email'));
                $(this).data('check','check');
                $(this).attr("data-check", "new value");
            }
            else{

            }


        });

        $("#move_member").on('click', function(){
           // console.log(selectedClassVal);
           // console.log(selectedMemberVal);
            $.ajax({
                url     : "<?php echo base_url('user/post-ajax-staff-class-list'); ?>",
                type    : "POST",
                async   : false,
                data    : {dataStaffName : selectedStaffName, dataClassName : selectedClassName,dataClassOrgId :selectedClassOrgID ,dataStaffEmail :selectedStaffEmail},
                //dataType: "json",
                success : function(response) {
                    ajaxResponse = jQuery.parseJSON(response);
                    if ( parseInt(ajaxResponse.output) ){
                       // console.log ('True');
                        $(".modal-body h4").hide();
                        $("#move_member").hide();
                        $(".modal-body .select_moveto_class").hide();
                        $(".modal-body").html("<h4>Staff Moved Successfully!</h4>");
                        $("#closenRefresh").on('click', function(){
                            window.location = "<?php echo base_url('user/staff-list'); ?>";
                        });
                    } else{
                        //console.log('false');
                        $(".modal-body h4").hide();
                        $(".modal-body .select_moveto_class").hide();
                        $("#move_member").hide();
                        $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                        $("#closenRefresh").on('click', function(){
                            window.location = "<?php echo base_url('user/staff-list'); ?>";
                        });
                    }
                },
                error   : function (request, status, error) {
                    console.log("something fishy!");
                }
            });
        });


    });
});
</script>
<script type="text/javascript">
    $('#some-textarea').wysihtml5();
</script>