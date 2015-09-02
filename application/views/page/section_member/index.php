<?php $this->view('page/dashboard-icon-menu/index'); ?>

<div class="container">
    <div class="row-fluid">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid cnote-table-menu-bg">
                    <div class="span12">
                        <ul class="cnote-table-menu">
                            <li style="width: 50%;" class="cnote-table-menu-active"><a class="cnote-table-menu-white" href="<?php echo base_url('user/students'); ?>">All Students</a></li>
                            <li style="width: 50%;"><a class="cnote-table-menu-blue" href="<?php echo base_url('user/staff-list') ?>">All Staff</a></li>
                           <!-- <li><a class="cnote-table-menu-green" href="#">Opened(97)</a></li>
                            <li><a class="cnote-table-menu-black" href="#">Unopened(36)</a></li>
                            <li><a class="cnote-table-menu-red" href="#">Undelivered(3)</a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="row-fluid table-area-header">
                    <div class="span4">
                        <h3>Student List</h3>
                    </div>
                    <div class="span2 offset6" style="padding-top: 6px">
                        <!--<a class="btn btn-large btn-success" href="#">Save Student</a>-->
                        <a href="<?php echo base_url('user/add-students'); ?>"><button type="submit" name="submit" class="btn btn-large btn-primary">Import Students</button></a>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4">
                        <ul id="table-footer">
                            <li style="display: none"><input type="checkbox" name="checkall" class="data-check-parent"></li>
                            <li style="display: none"></li>
                            <li style="display: none"></li>
                            <li style="display: none"></li>
                            <li style="display: none">First Name</li>
                            <li style="display: none">Last Name</li>
                            <li style="display: none">Recepient's Email</li>
                            <li>Status</li>
                            <li style="display: none">Join Date</li>
                            <li style="display: none">Alerts</li>
                            <li>Year</li>
                            <li>Classes</li>
                        </ul>
                    </div>
                    <div class="span3 custom-span">
                        <div class="student-form-group">
                            <label for="User Filter">Action</label>
                            <select id="action-filter" class="selectpicker">
                                <option selected="selected" >Select Action</option>
                                <option value="edit_student">Edit Student</option>
                                <option value="delete_student">Delete Student</option>
                                <option value="move_student">Move Student</option>
                               <!-- <option value="send_cloudenote">Send CloudeNote</option>
                                <option value="add_email">Add Email</option>-->
                                <option value="send_invitation">Send Invitation</option>
                            </select>
                        </div>
                    </div>
                    <div class="span2 custom-span">
                        <!--<div class="student-form-group">
                            <select id="alert-filter" class="selectpicker">
                                <option selected="selected" >Alert</option>
                                <option>New Message</option>
                                <option>Payment In</option>
                                <option>Payment Due</option>
                                <option>Consent In</option>
                                <option>Not-Consented</option>
                            </select>
                        </div>-->
                    </div>
                    <div class="span3 custom-span">
                        <!--<div class="student-form-group">
                            <label for="User Filter">Notes</label>
                            <select id="note-filter" class="selectpicker">
                                <option selected="selected" >Pulls list of Notes in</option>
                                <option>System and Modify</option>
                                <option>Student list accordingly</option>
                            </select>
                        </div>-->
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <?php if(empty($section_member_list)){
                                echo "No data Available.";
                            }else{
                            ?>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" class="data-check-parent"></th>
                                    <th style="display: none"></th>
                                    <th style="display: none"></th>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Recepient's Email</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                    <th>Alerts&nbsp;&nbsp;&nbsp;<i class="fa fa-cog"></i> </th>
                                    <th style="display: none">Year</th>
                                    <th style="display: none">Classes</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                <?php foreach ($section_member_list as $list): ?>
                                <tr>
                                    <td >
                                        <input type="checkbox" name="data[1][id]" value="1" class="data-check">
                                    </td>
                                    <td style="display: none" class="cbsection_id"><?php echo $list->id; ?></td>
                                    <td style="display: none"><?php echo $list->section_member_section_id; ?></td>
                                    <td ><?php echo ++$i; ?></td>
                                    <td ><?php echo $list->section_member_first_name; ?></td>
                                    <td ><?php echo $list->section_member_last_name; ?></td>
                                    <td ><?php echo $list->section_member_fathers_email.', '.$list->section_member_mothers_email; ?></td>
                                    <td class="label label-success">JOINED</td>
                                    <td>10/05/2012</td>
                                    <td ><span class="red-act"><i class="fa fa-envelope"></i></span>&nbsp;<span class="user-act"><i class="fa fa-dollar"></i></span>&nbsp;<span class="note-act"><i class="fa fa-check-circle"></i></span></td>
                                    <td style="display: none"><?php echo $list->group_name; ?></td>
                                    <td style="display: none"><?php echo ($list->section_name != '') ? $list->section_name : "Not Assigned"; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span12" style="text-align: center">
                        <div class="pagination">
                            <?php echo $pagination; ?>
                        </div>
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

<!--Modal Window Loader Div-->
<div id="move_student" class="modal hide fade in" style="display: none; ">
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
        <a href="#" id="move_member" class="btn btn-success">Move</a>
        <a href="#" id="closenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
<div id="delete_student" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3></h3>
    </div>
    <div class="modal-body">
        <h4></h4>
        <h6></h6>
        <div class="select_moveto_class">
            <?php $this->view('page/auth_user/staff_invite'); ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="delete_member" class="btn btn-success">Yes</a>
        <a href="#" id="delclosenRefresh" class="btn" data-dismiss="modal">Close</a>
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

/*jQuery("#selectOptionClasses").find('option:selected').val()*/
    function fnCreateSelect( aData, heading )
    {
        var r='<select id="selectOption'+heading+'"><option value="">'+heading+'</option>', i, iLen=aData.length;
        //r += '<option value="Not Assigned">Not Assigned</option>';
        for ( i=0 ; i<iLen ; i++ ){
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

        $('.dataTables_filter').hide();

        /* Add a select menu for each TH element in the table footer */
        $("#table-footer li").each( function ( i ) {
            var heading = $(this).text();
            this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i), heading );
            ////console.log(this.innerHTML);
            $('select', this).change( function () {

                oTable.fnFilter( $(this).val(), i );
            } );
        } );

        function removeNewlines(str) {
            //remove line breaks from str
            str = str.replace(/\s{2,}/g, ' ');
            str = str.replace(/\t/g, ' ');
            str = str.replace(/\n{2,}/g, ' ');
            str = str.toString().trim().replace(/(\r\n|\n|\r)/g,"");
            return str;
        }

        $("#action-filter").on('change', function(){
            var selectedVal =  $(this).val();
           // //console.log($("input[type=checkbox]:checked");
            if ( selectedVal == 'move_student' ){
                if ( $("#selectOptionClasses").find('option:selected').val() != '' ){
                    $("#move_student").modal();
                    $(".modal-header h3").html("Move Student");
                    $(".modal-body h4").html("Choose Your Class:");

                    var dataArr = [];
                    $.each($("input[type=checkbox]:checked"), function () {
                        var checkedVal      = $(this).parent().parent().text(); //getting each choosen data from data-table
                        var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                        singleElement       = removeNewLines.split(' ');        //making the string an array
                        dataArr.push(singleElement);                            //pushing the collected data into dataArray which will go to the modal
                    });
                    if (flag == 0){
                        dataArr.splice(0,2); //remove first two index as data table row will be in the text value item.
                    }

                    var classListFromPHP    = <?php echo $classList; ?>;
                    classListFromPHP        = JSON.stringify(classListFromPHP);
                    classListFromPHP        = $.parseJSON(classListFromPHP);

                    var classListArr = [];

                    $.each(classListFromPHP, function(i, val) {
                        var prod =[];
                        prod[0] = val.section_id;
                        prod[1] = val.section_hash_organisation_id;
                        prod[2] = val.section_name;
                        prod[3] = val.section_created_date;
                        classListArr.push(prod);
                    });

                    //console.log ('array : '+ classListArr[0]);

                    var classListFiltered = [];
                    $.each(classListArr, function(i, val){
                        if (val[2] != $("#selectOptionClasses").find('option:selected').val())  classListFiltered.push(val);
                    });

                    var selectClassOption = '<div class="student-form-group">';
                            selectClassOption += '<label for="User Filter">Action</label>';
                            selectClassOption += '<select id="class-filter" class="selectpicker">';
                                selectClassOption += '<option selected="selected" >Select Action</option>';
                                for (i=0; i<classListFiltered.length; i++){
                                    selectClassOption += '<option value="'+classListFiltered[i][0]+'">'+classListFiltered[i][2]+'</option>';
                                }
                            selectClassOption += '</select>';
                    selectClassOption += '</div>';
                    $(".modal-body .select_moveto_class").html(selectClassOption);
                } else {
                    $("#move_student").modal();
                    $(".modal-header h3").html("Move Student");
                    $(".modal-body h4").html("Please Filter Students by Class First!");
                    $(".modal-body h6").html("Hit close to refresh the page!");
                    $("#move_member").hide();
                    $("#closenRefresh").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                }
            }else if ( selectedVal == 'delete_student' ){
                var studentschecked = $( "input:checked" ).length;
                ////console.log(studentschecked);
                if (studentschecked > 0 ){
                    var deleteArr = [];
                    $.each($("input[type=checkbox]:checked"), function () {

                       var checkedVal      = $(this).parent().parent().text(); //getting each choosen data from data-table
                       var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                       singleElement       = removeNewLines.split(' ');        //making the string an array
                       deleteArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal

                    });
                    if (flag == 0){
                        deleteArr.splice(0,2); //remove first two index as data table row will be in the text value item.
                    }
                   // //console.log(deleteArr);
                    $("#delete_student").modal();
                    $(".modal-header h3").html("Delete Student");
                    $(".modal-body h4").html("Are you sure you want to delete?");
                    $(".modal-body h6").html("Hit close to refresh the page!");
                    $("#delclosenRefresh").text("No").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                    $("#delete_member").on('click', function(){
                        $.ajax({
                            url     : "<?php echo base_url('user/post-ajax-del-student'); ?>",
                            type    : "POST",
                            async   : false,
                            data    : {deleteArr : deleteArr},
                            //dataType: "json",
                            success : function(response) {
                                //console.log (response);
                                ajaxResponse = jQuery.parseJSON(response);
                                if ( parseInt(ajaxResponse.output) ){
                                    $(".modal-body h4").hide();
                                    $("#delete_member").hide();
                                   // $(".modal-body .select_moveto_class").hide();
                                   $(".modal-body").html("<h4>Student Deleted Successfully!</h4>");
                                    $("#delclosenRefresh").text('Close').on('click', function(){
                                        window.location = "<?php echo base_url('user/students'); ?>";
                                    });

                                } else{
                                    //console.log('false');
                                    $(".modal-body h4").hide();
                                    $(".modal-body .select_moveto_class").hide();
                                    $("#delete_member").hide();
                                    $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                                    $("#delclosenRefresh").on('click', function(){
                                        window.location = "<?php echo base_url('user/students'); ?>";
                                    });
                                }
                            },
                            error   : function (request, status, error) {
                                //console.log("something fishy!");
                            }
                        });
                    });

                } else {
                    $("#delete_student").modal();
                    $(".modal-header h3").html("Delete Student");
                    $(".modal-body h4").html("Please Select Students First!");
                    $(".modal-body h6").html("Hit close to refresh the page!");
                    $("#delete_member").hide();
                    $("#delclosenRefresh").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                }
            } else if ( selectedVal == 'edit_student' ){
                var studentschecked = $( "input:checked" ).length;
                //console.log(studentschecked);
                if (studentschecked == 1 ){
                    var editArr = [];
                    $.each($("input[type=checkbox]:checked"), function () {

                        var checkedVal      = $(this).parent().parent().text(); //getting each choosen data from data-table
                        var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                        singleElement       = removeNewLines.split(' ');        //making the string an array
                        editArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal

                    });
                    var url = "<?php echo base_url('user/editStudent'); ?>";
                    window.location = url+'/'+editArr;

                }else {
                    $("#delete_student").modal();
                    $(".modal-header h3").html("Edit Student");
                    $(".modal-body h4").html("Please Select One Student");
                    $(".modal-body h6").html("Hit close to refresh the page!");
                    $("#delete_member").hide();
                    $("#delclosenRefresh").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                }
            }else if ( selectedVal == 'send_invitation' ){

                var studentschecked = $( "input:checked" ).length;

                if (studentschecked > 0 ){
                    var inviteArr = [];
                    $.each($("input[type=checkbox]:checked"), function () {

                        var checkedVal      = $(this).parent().parent().text(); //getting each choosen data from data-table
                        var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                        singleElement       = removeNewLines.split(' ');        //making the string an array
                        inviteArr.push(singleElement[0]);                       //pushing the collected data into dataArray which will go to the modal
                        ////console.log(singleElement);
                    });
                    //console.log(inviteArr);
                    if (flag == 0){
                        inviteArr.splice(0,3); //remove first two index as data table row will be in the text value item.
                    }

                    $("#delete_student").modal();
                    $(".modal-header h3").html("Send Invitation To Parent");
                    $(".modal-body h4").html("");
                    $(".modal-body .select_moveto_class").show();
                    //$(".modal-body h6").html("Hit close to refresh the page!");
                    $("#delete_member").text("Send");
                    $("#closenRefresh").text("No").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                    $("#delete_member").on('click', function(){
                        $.ajax({
                            url     : "<?php echo base_url('user/post-ajax-parent-invite'); ?>",
                            type    : "POST",
                            async   : false,
                            data    : {inviteArr : inviteArr},
                            //dataType: "json",
                            success : function(response) {
                                ////console.log (response);
                                ajaxResponse = jQuery.parseJSON(response);
                            },
                            error   : function (request, status, error) {
                                //console.log("something fishy!");
                            }
                        });
                    });

                } else {
                    $("#delete_student").modal();
                    $(".modal-header h3").html("Send Invitation To Student");
                    $(".modal-body h4").html("Please Select Student First!");
                    $(".modal-body h6").html("Hit close to refresh the page!");
                    $("#delete_member").hide();
                    $("#closenRefresh").on('click', function(){
                        window.location = "<?php echo base_url('user/students'); ?>";
                    });
                }

            }

            var selectedClassVal;
            $("#class-filter").on('change', function(){
                selectedClassVal = $(this).val();
            });

            $("#move_member").on('click', function(){
                $.ajax({
                    url     : "<?php echo base_url('user/post-ajax-class-list'); ?>",
                    type    : "POST",
                    async   : false,
                    data    : {dataArr : dataArr, moveTo : selectedClassVal},
                    //dataType: "json",
                    success : function(response) {
                        ajaxResponse = jQuery.parseJSON(response);
                        if ( parseInt(ajaxResponse.output) ){
                            //console.log ('True');
                            $(".modal-body h4").hide();
                            $("#move_member").hide();
                            $(".modal-body .select_moveto_class").hide();
                            $(".modal-body").html("<h4>Student Moved Successfully!</h4>");
                            $("#closenRefresh").on('click', function(){
                                window.location = "<?php echo base_url('user/students'); ?>";
                            });
                        } else{
                            //console.log('false');
                            $(".modal-body h4").hide();
                            $(".modal-body .select_moveto_class").hide();
                            $("#move_member").hide();
                            $(".modal-body").html("<h4>Something Wrong! Please Check Again.</h4>");
                            $("#closenRefresh").on('click', function(){
                                window.location = "<?php echo base_url('user/students'); ?>";
                            });
                        }
                    },
                    error   : function (request, status, error) {
                        //console.log("something fishy!");
                    }
                });
            });

        });
    } );
</script>
