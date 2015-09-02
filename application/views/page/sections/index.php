<section class="main-content-body" xmlns="http://www.w3.org/1999/html">

<?php error_reporting(0);
$this->view('page/dashboard-icon-menu/index'); ?>

<div class="container">
    <div class="row-fluid">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid cnote-table-menu-bg">
                    <div class="span12">
                        <ul class="cnote-table-menu">
                            <li class="cnote-table-menu-active">
                                <a class="cnote-table-menu-white" href="<?php echo base_url('user/students'); ?>">All Students</a>
                            </li>
                            <li>
                                <a class="cnote-table-menu-blue" href="<?php echo base_url('user/teacher-list') ?>">All Staff</a>
                            </li>
                            <li><a class="cnote-table-menu-green" href="#">Opened(97)</a></li>
                            <li><a class="cnote-table-menu-black" href="#">Unopened(36)</a></li>
                            <li><a class="cnote-table-menu-red" href="#">Undelivered(3)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row-fluid table-area-header">
                    <h3>Class List</h3>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4">
                        <div class="span4">
                            <ul id="table-footer">
                                <li style="display: none">
                                    <input type="checkbox" name="checkall" class="data-check-parent"></li>
                                <li style="display: none"></li>
                                <li style="display: none"></li>
                                <li>Year</li>
                                <li>Classes</li>
                                <li>Teacher</li>
                                <li style="display: none"># of Students</li>
                                <li style="display: none">Joined</li>
                                <li style="display: none">Unregistered</li>
                                <li style="display: none">Invited</li>
                            </ul>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="student-form-group">
                            <label for="User Filter">Action</label>
                            <select id="action-filter" class="selectpicker">
                                <option selected="selected">Select Action</option>
                                <option value="create_class">Create Class</option>
                                <option value="edit_class">Edit Class</option>
                                <option value="delete_class">Delete Class</option>
                                <option value="move_class">Move Student</option>
                                <option value="send_cloudenotes">Send CloudeNote</option>
                                <option value="send_reminders">Send Reminders</option>
                            </select>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="student-form-group">
                            <select id="class-view-status-filter" class="selectpicker">
                                <option selected="selected">Select Status</option>
                                <option>Registered (parents)</option>
                                <option>Unregistered (parents)</option>
                                <option>Invited (parents)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <?php if (empty($section_list)) {
                                echo "No data Available.";
                            } else {
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">

                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall" class="data-check-parent"></th>
                                        <th style="display: none"></th>
                                        <th></th>
                                        <th>Year</th>
                                        <th>Title of Class</th>
                                        <th>Teacher</th>
                                        <th># of Students</th>
                                        <th>Joined</th>
                                        <th>Unregistered</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php ?>
                                    <?php $i = 0;
                                    $total_student =0;
                                    $total_parent_joined =0;
                                    ?>
                                    <?php foreach ($section_list as $list): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="data[1][id]" value="1" class="data-check">
                                            </td>
                                            <td style="display: none"><?php echo $list->class_id ?></td>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $list->group_name; ?></td>
                                            <td><?php echo $list->section_name; ?></td>
                                            <td><?php echo ($list->first_name != '') ? $list->first_name : "Not Assigned"; ?></td>
                                            <td><?php echo $total_student_per_class = ($list->total_student != '') ? $list->total_student : 0; ?></td>
                                            <td><?php echo $parent_joined = ($list->parent_joined != '') ? $list->parent_joined : 0; ?></td>
                                            <td><?php echo $total_student_per_class - $parent_joined; ?></td>
                                        </tr>

                                    <?php
                                        $total_student += $total_student_per_class;
                                        $total_parent_joined +=$parent_joined;
                                    endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <?php $total_student; ?>
                                    <?php /*for ($i = 0; $i < sizeof($section_list); $i++): */?><!--
                                        <?php /*if (isset($section_list[$i + 1]->section_name)) { */?>
                                            <?php /*if ($section_list[$i]->section_name != $section_list[$i + 1]->section_name): */?>
                                                <?php /*$total_student += $section_list[$i]->total_student; */?>
                                            <?php /*endif; */?>
                                        <?php /*} else { */?>
                                            <?php /*$total_student += $section_list[$i]->total_student; */?>
                                        <?php /*} */?>
                                    --><?php //endfor; ?>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total:</th>
                                    <th><?php echo $total_student; ?></th>
                                    <th><?php echo $total_parent_joined; ?></th>
                                    <th><?php echo $total_student-$total_parent_joined; ?></th>

                                    </tfoot>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--<div class="row-fluid table-area-filter-bg">
                    <div class="row-fluid">
                        <div class="span3 offset9 steps">
                            <a class="btn btn-prev-step" href="#">Previous Step</a>
                            <a class="btn btn-primary" href="#">Next Step</a>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!--Modal loading view-->
<div id="move_student" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3></h3>
    </div>
    <div class="modal-body">
        <h4></h4>

        <div class="select_moveto_class">

        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="move_member" class="btn btn-success">Move</a>
        <a href="#" id="closenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
<div id="delete_class" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3></h3>
    </div>
    <div class="modal-body">
        <h4></h4>
        <h6></h6>

        <div class="select_moveto_class">

        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="delete_section" class="btn btn-success">Yes</a>
        <a href="#" id="delclosenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
<!--<p><a data-toggle="modal" href="#move_student" class="btn btn-primary btn-large">Launch demo modal</a></p>-->

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

            //I've commited here by commenting on this line. for later please remove the comment from this line
            //if no error occurs
            // ignore empty values?
            //if (bIgnoreEmpty == true && sValue.length == 0) continue;

            // ignore unique values?
            // here if the previous if is enabled then please add else if condition otherwise it'll not work correctly
            //else
            if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

            // else push the value onto the result data array
            else asResultData.push(sValue);
        }

        return asResultData;
    }
}(jQuery));


function fnCreateSelect(aData, heading) {
    var r = '<select><option value="">' + heading + '</option>', i, iLen = aData.length;
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

    $('.dataTables_filter input').attr("placeholder", "enter seach terms here");

    /* Add a select menu for each TH element in the table footer */
    $("#table-footer li").each(function (i) {
        var heading = $(this).text();
        this.innerHTML = fnCreateSelect(oTable.fnGetColumnData(i), heading);
        $('select', this).change(function () {
            oTable.fnFilter($(this).val(), i);
        });
    });

    /*modal operations*/
    function removeNewlines(str) {
        //remove line breaks from str
        str = str.replace(/\s{2,}/g, ' ');
        str = str.replace(/\t/g, ' ');
        str = str.replace(/\n{2,}/g, ' ');
        str = str.toString().trim().replace(/(\r\n|\n|\r)/g, "");
        return str;
    }

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

    $('#action-filter').on('change', function () {
        var selectedVal = $(this).val();
        ////console.log(selectedVal);
        if (selectedVal == 'create_class') {
            window.location = "<?php echo base_url('user/add-class'); ?>";
        } else if (selectedVal == 'move_class') {
            $("#move_student").modal();
            $(".modal-header h3").html("Move Student");
            $(".modal-body h4").html("Choose Your Class:");

            /*Checking for checked ones values*/
            var dataArr = [];
            $.each($("input[type=checkbox]:checked"), function () {
                var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                singleElement = removeNewLines.split(' ');        //making the string an array
                dataArr.push(singleElement);                            //pushing the collected data into dataArray which will go to the modal
            });
            if (flag == 0) {
                dataArr.splice(0, 2); //remove first two index as data table row will be in the text value item.
            }

            /*if any duplicacy is there than unify it*/
            var checkedTempArray = new Array();
            checkedTempArray[0] = dataArr[0];
            for (var i = 0; i < dataArr.length; i++) {
                var cflag = true;
                for (var j = 0; j < checkedTempArray.length; j++) {
                    if (checkedTempArray[j][0] == dataArr[i][0]) {
                        cflag = false;
                    }
                }
                if (cflag == true) checkedTempArray.push(dataArr[i]);
            }
            ////console.log(checkedTempArray);
            /*End of checked value checking*/

            /*If any option is not choosen than this one will call*/
            uncheckedDataArr = [];
            $.each($("input:checkbox:not(:checked)"), function () {
                var uncheckedVal = $(this).parent().parent().text();
                var uncheckedRemoveNewLines = removeNewlines(uncheckedVal);
                singleElem = uncheckedRemoveNewLines.split(' ');
                uncheckedDataArr.push(singleElem);
            });
            uncheckedDataArr.splice(0, 2); // remove first two index as data table row will be in the text value item.

            /*if any duplicacy is there than unify it*/
            var uncheckedTempArray = new Array();
            uncheckedTempArray[0] = uncheckedDataArr[0];
            for (var i = 0; i < uncheckedDataArr.length; i++) {
                var uflag = true;
                for (var j = 0; j < uncheckedTempArray.length; j++) {
                    if (uncheckedTempArray[j][0] == uncheckedDataArr[i][0]) {
                        uflag = false;
                    }
                }
                if (uflag == true) uncheckedTempArray.push(uncheckedDataArr[i]);
            }


            var filteredTempArr = [];
            $.each(uncheckedTempArray, function (old_index, old_obj) {

                if (typeof old_obj == 'undefined') {
                    var old_id = '';
                } else {
                    var old_id = old_obj[0];
                }
                var found = false;
                $.each(checkedTempArray, function (new_index, new_obj) {
                    if (new_obj[0] == old_id) {
                        found = true;
                    }
                });
                if (!found) {
                    filteredTempArr.push(uncheckedTempArray[old_index]);
                }
            });////console.log(filteredTempArr);
            ////console.log(uncheckedTempArray);

            var selectClassOption = '<div class="student-form-group">';
            selectClassOption += '<label for="User Filter">Action</label>';
            selectClassOption += '<select id="class-filter" class="selectpicker">';
            selectClassOption += '<option selected="selected" >Select Action</option>';
            for (i = 0; i < filteredTempArr.length; i++) {
                if (typeof filteredTempArr[i] == 'undefined') {
                    selectClassOption += '';
                } else {
                    selectClassOption += '<option value="' + filteredTempArr[i][0] + '">' + filteredTempArr[i][2] + ' ' + filteredTempArr[i][3] + '</option>';
                }
            }
            selectClassOption += '</select>';
            selectClassOption += '</div>';
            $(".modal-body .select_moveto_class").html(selectClassOption);

            var selectedClassVal;
            $("#class-filter").on('change', function () {
                selectedClassVal = $(this).val();
            });

            $("#move_member").on('click', function () {
                $.ajax({
                    url: "<?php echo base_url('user/postAjaxList'); ?>",
                    type: "POST",
                    async: false,
                    data: {dataArr: checkedTempArray, moveTo: selectedClassVal},
                    //dataType: "json",
                    success: function (response) {
                        ////console.log(response.output);
                        //response = JSON.parse(response);
                        var response = jQuery.parseJSON(response);

                        //$.parse
                        //console.log(response.output);
                        if (parseInt(response.output)) {
                            //console.log ('True');
                            $(".modal-body h4").hide();
                            $("#move_member").hide();
                            $(".modal-body .select_moveto_class").hide();
                            $(".modal-body").html("<h4>Student Moved Successfully!</h4>");
                            $("#closenRefresh").on('click', function () {
                                window.location = "<?php echo base_url('user/classes'); ?>";
                            });
                        } else {
                            //console.log('false');
                            $(".modal-body h4").hide();
                            $(".modal-body .select_moveto_class").hide();
                            $("#move_member").hide();
                            $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                        }
                    },
                    error: function (request, status, error) {
                        //console.log("something fishy!");
                        //alert(request.responseText);
                    }
                });
            });
        } else if (selectedVal == 'delete_class') {
            var studentschecked = $("input:checked").length;
            //console.log(studentschecked);
            if (studentschecked > 0) {
                var deleteArr = [];
                $.each($("input[type=checkbox]:checked"), function () {

                    var checkedVal = $(this).parent().parent().text(); //getting each choosen data from data-table
                    var removeNewLines = removeNewlines(checkedVal);       //removing the new lines
                    singleElement = removeNewLines.split(' ');        //making the string an array
                    deleteArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal

                });
                if (flag == 0) {
                    deleteArr.splice(0, 2); //remove first two index as data table row will be in the text value item.
                }
                //console.log(deleteArr);
                $("#delete_class").modal();
                $(".modal-header h3").html("Delete Student");
                $(".modal-body h4").html("Are you sure you want to delete?");
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#delclosenRefresh").text("No").on('click', function () {
                    window.location = "<?php echo base_url('user/classes'); ?>";
                });
                $("#delete_section").on('click', function () {
                    $.ajax({
                        url: "<?php echo base_url('user/post-ajax-del-class'); ?>",
                        type: "POST",
                        async: false,
                        data: {deleteArr: deleteArr},
                        //dataType: "json",
                        success: function (response) {
                            //console.log (response);
                            ajaxResponse = jQuery.parseJSON(response);
                            if (parseInt(ajaxResponse.output)) {
                                $(".modal-body h4").hide();
                                $("#delete_section").hide();
                                // $(".modal-body .select_moveto_class").hide();
                                $(".modal-body").html("<h4>Class Deleted Successfully!</h4>");
                                $("#delclosenRefresh").text('Close').on('click', function () {
                                    window.location = "<?php echo base_url('user/classes'); ?>";
                                });

                            } else {
                                //console.log('false');
                                $(".modal-body h4").hide();
                                $(".modal-body .select_moveto_class").hide();
                                $("#delete_section").hide();
                                $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                                $("#delclosenRefresh").on('click', function () {
                                    window.location = "<?php echo base_url('user/classes'); ?>";
                                });
                            }
                        },
                        error: function (request, status, error) {
                            //console.log("something fishy!");
                        }
                    });
                });

            } else {
                $("#delete_class").modal();
                $(".modal-header h3").html("Delete Class");
                $(".modal-body h4").html("Please Select Class First!");
                $(".modal-body h6").html("Hit close to refresh the page!");
                $("#delete_section").hide();
                $("#delclosenRefresh").on('click', function () {
                    window.location = "<?php echo base_url('user/classes'); ?>";
                });
            }
        }

    });
});
</script>
</section>
