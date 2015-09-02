<section class="main-content-body" xmlns="http://www.w3.org/1999/html">

<?php
 //echo "<pre>"; print_r($note_name);

/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 3:21 PM
 */

$this->view('page/dashboard-icon-menu/index');
$this->view('template/upload_sign_note');
$this->view('template/upload_sign');
?>


<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span4">
                    <!-- Left Sidebar Menu Start -->

                    <?php if( isset( $load_drag_items ) and $load_drag_items == true ): ?>
                    <?php $this->load->view('page/include/load_drag_element'); ?>
                    <?php endif; ?>

                    <!-- Left Sidebar Menu End -->
                </div>
                <div class="span8">
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">

                                    <div class="user-edit-form">
                                        <?php //echo (isset($note_create_error) and !empty($note_create_error)) ? $note_create_error : ''; ?>
                                        <?php echo (isset($note_create_success) and !empty($note_create_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$note_create_success.'</div>' : ''; ?>
                                        <?php echo (isset($legal_notice) and !empty($legal_notice)) ? $legal_notice : ''; ?>
                                        <?php echo form_error('note_name', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('note_details', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('schedule_date', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('payment', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('additional_payment', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('is_draft', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error! </strong>', '</div>'); ?>
                                        <div class="note-popover-holder">
                                                <i id="note-popover" class="help-popover control-group-help-icon fa fa-question-circle" data-placement="left" data-content="Begin your CloudeNote here. After you have filled in the Name of the Note, simply Drag and Drop a Button you want into the Note Area. This creates the Field. You can re-arrange Fields as needed. If you wish to delete a Field, click the X"></i>
                                        </div>
                                            <h3 id="note-area" class="note-area-text pull-left">Note Area</h3>
                                            <a class="btn btn-success pull-right save-as-draft" href="#" ><i class="fa fa-save"></i> Save</a>
                                            <div class="clearfix"></div>

                                            <div class="preview-note-url-area">
                                                <?php if( !empty( $note_public_preview_url ) ): ?>
                                                    <div class="preview-note-url alert alert-info">
                                                        <a target="_blank" href="<?php echo $note_public_preview_url; ?>"><?php echo $note_public_preview_url; ?></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <ul class="pager wizard breadcumb-wizard">
                                                <li id="previous-note" class="previous"><a href="#note-area">Back</a></li>
                                                <li class="next"><a href="#note-area">Next Step</a></li>
                                            </ul>
                                            <form id="new-note" class="form-horizontal" action="<?php echo base_url('notes/new'); ?>" method="post">

                                                <div class="pre-defined-hidden-item hidden">
                                                    <input type="hidden" name="note_status" value="<?php echo (set_value('note_status')) ? set_value('note_status'): '1'; ?>">
                                                    <input type="hidden" name="note_id" value="<?php echo $note_id; ?>" id="note_id">
                                                    <input type="hidden" name="reply_end_date" id="dpd2" data-date-format="yyyy/mm/dd" value="<?php echo (set_value('reply_end_date')) ? set_value('reply_end_date'): ''; ?>">

                                                </div>

                                                <div class="tab-content">

                                                    <div class="tab-pane" id="tab_begin_note">

                                                        <div class="not-sortable-note-area">

                                                            <div class="control-group">
                                                                <label class="control-label">Name of Note </label>
                                                                <div class="controls">
                                                                    <?php isset($note_name) ? $note_name :  ''; ?>
                                                                    <input type="text" class="cnote-text" name="note_name" placeholder="Name of Note" value="<?php echo set_value('note_name') ? set_value('note_name') : $note_name ; ?>">
                                                                    <span class="help-block" style="color: #f00;"></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="sortable-note-area  add-remove-holder">
                                                          <!--
                                                            $this->view('template/upload_sign');?>-->


                                                        </div>

                                                    </div>

                                                    <div class="tab-pane" id="tab_add_receivers">
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <a id="add-receiver" class="btn btn-success add-receiver-button" href="#">Add Receivers</a>
                                                                <a id="delete-receiver" class="btn btn-danger add-receiver-button" href="#">Delete Receivers</a>
                                                                <div id="demo">
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="receiver-main-form">
                                                                        <thead>
                                                                        <tr>
                                                                            <th style="text-align: left"><input type="checkbox" name="checkall" class="data-check-parent-remove"></th>
                                                                            <th style="display: none"></th>
                                                                            <th style="display: none"></th>
                                                                            <th style="text-align: left"></th>
                                                                            <th style="text-align: left">First Name</th>
                                                                            <th style="text-align: left">Last Name</th>
                                                                            <th style="text-align: left">Parent1 First Name</th>
                                                                            <th style="text-align: left">Parent1 Last Name</th>
                                                                            <th style="text-align: left">Recepient's Email</th>
                                                                            <th style="text-align: left">Status</th>
                                                                            <th style="display: none">Classes</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!--Dynamically load data via javascript-->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="tab-pane" id="tab_preview_note">

                                                        <div class="well" style="text-align: left; background-color: #FFF;">



                                                        </div>

                                                    </div>

                                                    <div class="tab-pane" id="tab_send_note">

                                                        <div class=" well well-small">
                                                            <span class="send-note-message"></span>
                                                        </div>

                                                        <div class="button-area" style="text-align: center;">
                                                            <a id="save-as-draft" class="btn btn-large btn-success save-as-draft" href="#">Save As Draft</a>
                                                            <a id="send-note-now" class="btn btn-large btn-info send-note-now" href="#">Send Note Now</a>
                                                            <a id="add-schedule" class="btn btn-large btn-warning" href="#schedule-modal" role="modal" data-toggle="modal">Schedule Note</a>

                                                            <!-- Modal for Schedule Date -->
                                                            <div id="schedule-modal" class="modal hide fade"  role="modal" aria-hidden="true">
                                                                <div class="modal-header">
                                                                    <h3>Date of Note</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!--<div class="form-horizontal">-->
                                                                        <div class="control-group">
                                                                            <label class="control-label">Date of Note</label>
                                                                            <div class="controls">
                                                                                <div class="input-append">
                                                                                    <input type="text" name="schedule_date" placeholder="yyyy/mm/dd" id="dpd1" data-date-format="yyyy/mm/dd" value="<?php echo (set_value('schedule_date')) ? set_value('schedule_date'): date('Y/m/d', ( time() + 86400 ) ); ?>">
                                                                                    <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                                <span class="help-block" style="color: #f00;"></span>
                                                                            </div>
                                                                        </div>
                                                                    <!--</div>-->
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn cancel-schedule" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                                                    <button class="btn btn-success confirm-schedule" >Confirm</button>
                                                                </div>
                                                            </div> <!-- Modal End -->

                                                        </div>

                                                    </div>

                                                </div>

<!--                                                <button class="btn btn-success" type="submit" name="new_note" id="new_note_submit">Submit</button>
-->
                                            </form>

                                            <!--Modal Window Loader Div for Add Receiver -->
                                            <div id="add-receiver-modal" class="modal hide fade in" style="display: none; ">
                                                <div class="modal-header">
                                                    <a class="close" data-dismiss="modal">×</a>
                                                    <h3>Add Receivers</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row-fluid table-area-filter-bg">
                                                        <div class="span4">
                                                            <ul id="table-footer">
                                                                <li style="display: none"><input type="checkbox" name="checkall" class="data-check-parent"></li>
                                                                <li style="display: none"></li>
                                                                <li style="display: none"></li>

                                                                <li style="display: none"></li>
                                                                <li style="display: none">First Name</li>
                                                                <li style="display: none">Last Name</li>
                                                                <li style="display: none">Parent1 First Name</li>
                                                                <li style="display: none">Parent1 Last Name</li>
                                                                <li style="display: none">Recepient's Email</li>
                                                                <li>Status</li>
                                                                <li>Year</li>
                                                                <li>Classes</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div id="demo">
                                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="add-receiver-form">
                                                            <thead>
                                                            <tr>
                                                                <th style="text-align: left"><input type="checkbox" name="checkall" class="data-check-parent"></th><!-- for checkbox -->
                                                                <th style="display: none"></th>
                                                                <th style="display: none"></th>
                                                                <th style="display: none"></th>

                                                                <th style="text-align: left">First Name</th>
                                                                <th style="text-align: left">Last Name</th>
                                                                <th style="text-align: left">Parent1 First Name</th>
                                                                <th style="text-align: left">Parent1 Last Name</th>
                                                                <th style="text-align: left">Recepient's Email</th>
                                                                <th style="text-align: left">Status</th>
                                                                <th style="text-align: left">Year</th>
                                                                <th style="display: none">Classes</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>


                                                            <?php if( isset( $get_receiver_and_member_list ) and !empty( $get_receiver_and_member_list ) ): ?>
                                                                <?php echo $get_receiver_and_member_list; ?>
                                                            <?php endif; ?>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" id="receiver-choosen-insert" class="btn btn-success">Add Receiver</a>
                                                    <a href="#" id="receiver-choosen-close" class="btn" data-dismiss="modal">Close</a>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div><!-- End of Well -->
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

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
    function fnCreateSelect( aData, heading ){
        var r='<select id="selectOption'+heading+'"><option value=" " selected="selected">All '+heading+'</option>', i, iLen=aData.length;
        for ( i=0 ; i<iLen ; i++ ){
            r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
        }
        return r+'</select>';
    }

    /* Initialise the DataTable */
    var oTable = jQuery('#add-receiver-form').dataTable( {
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

    jQuery('.dataTables_filter').hide();

    /* Add a select menu for each TH element in the table footer */
    jQuery("#table-footer li").each( function ( i ) {
        var heading = $(this).text();
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i), heading );
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

    jQuery(document).ready(function($){

        var insertedData = [];
        $('#add-receiver').on('click', function(){
            $('#add-receiver-modal').modal();

            $("#selectOptionClasses").on('change', function(){
                var selected = $(this).val();
            });

            var flag, countCheck = 0;
            $('.data-check-parent').on('change', function () {
                if ($(this).is(':checked')) {
                    flag = 0; countCheck++;
                    $('.data-check').attr('checked', true);
                } else {
                    flag = 1;
                    $('.data-check').attr('checked', false);
                }
            });

            var receiverClickCount = 0;
            $("#receiver-choosen-insert").on('click', function(){
                receiverClickCount++;
                if ( $("#selectOptionClasses").find('option:selected').val() == '' ){
                    alert('Please Select A Class First Then Click Add Receiver!');
                } else {
                    /*Checking for checked ones values*/
                    var dataArr = [];
                    $('input[type=checkbox]:checked', oTable.fnGetNodes()).each(function(){
                        var rowIndex = oTable.fnGetPosition( $(this).closest('tr')[0] );
                        ////console.log(rowIndex);
                        //alert(oTable.fnGetData(rowIndex)); //to get the data we can also use this method from datatable
                        //oTable.fnDeleteRow(rowIndex);
                        dataArr.push(oTable.fnGetData(rowIndex));
                    } );

                    /*$.each($("input[type=checkbox]:checked"), function () {
                        var checkedVal      = $(this).parent().parent().html(); //getting each choosen data from data-table
                        var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                        singleElement       = removeNewLines.split(' ');        //making the string an array
                        dataArr.push(singleElement);                            //pushing the collected data into dataArray which will go to the modal
                    });*/

                    //console.log(dataArr);

                    if (flag == 0 && countCheck == 1){
                        dataArr.splice(0,2); //remove first two index as data table row will be in the text value item.
                    } else if(flag == 0 && countCheck > 1){
                        dataArr.splice(0,1); //remove first one index as data table row will be in the text value item.
                    }

                    if(receiverClickCount == 1){
                        for (var i=0; i<dataArr.length; i++){
                            var bodyTable = $("#receiver-main-form").dataTable({
                                "bRetrieve": true,
                                "bLengthChange" : true,
                                "bPaginate"   : true,
                                "iDisplayLength": 50,
                                "aLengthMenu": [[25, 50, 100, -1], [50, 100, "All"]],
                                "aoColumnDefs": [
                                    { "sClass": "display_none", "aTargets": [ 1, 2, 9 ] },
                                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                            ]}).fnAddData([
                                "<input type='checkbox' value='1' class='data-check-remove'>",
                                //dataArr[i][0],
                                dataArr[i][1],
                                dataArr[i][2],
                                dataArr[i][3],
                                dataArr[i][4],
                                dataArr[i][5],
                                dataArr[i][6],
                                dataArr[i][7],
                                dataArr[i][8],
                                dataArr[i][9],
                                dataArr[i][10]
                            ]);
                            ////console.log(dataArr[i][8]);
                        }
                    } else if(receiverClickCount > 1){
                        for(var i=0;i<dataArr.length;i++){
                            var cflag = true;
                            for(var j=0;j<insertedData.length;j++){
                                if(insertedData[j][1]==dataArr[i][1] && insertedData[j][8]==dataArr[i][8]){
                                    //console.log('ins data first index' + insertedData[j][0])
                                    //console.log('data first index' + dataArr[i][0])
                                    cflag = false;
                                }
                            }
                            if(cflag==false){alert('You\'ve Already Added Some Of Choosen Data. Please Choose Different Data.'); exit();}
                            else {
                                var bodyTable = $("#receiver-main-form").dataTable({
                                    "bRetrieve": true,
                                    "bLengthChange" : true,
                                    "bPaginate"   : true,
                                    "iDisplayLength": 50,
                                    "aLengthMenu": [[25, 50, 100, -1], [50, 100, "All"]],
                                    "aoColumnDefs": [
                                        { "sClass": "display_none", "aTargets": [ 1, 2, 9 ] },
                                        { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                                    ]}).fnAddData([
                                    "<input type='checkbox' value='1' class='data-check-remove'>",
                                    //dataArr[i][0],
                                    dataArr[i][1],
                                    dataArr[i][2],
                                    dataArr[i][3],
                                    dataArr[i][4],
                                    dataArr[i][5],
                                    dataArr[i][6],
                                    dataArr[i][7],
                                    dataArr[i][8],
                                    dataArr[i][9],
                                    dataArr[i][10]
                                ]);
                            }
                        }
                    }

                    for(var i=0;i<dataArr.length;i++){
                        var cflag = true;
                        for(var j=0;j<insertedData.length;j++){
                            if(insertedData[j][1]==dataArr[i][1]){
                                cflag = false;
                            }
                        }
                        if(cflag==true) insertedData.push(dataArr[i]);
                    }//console.log(insertedData);
                      $("#add-receiver-modal").modal('hide');
                }

            });
        });

        bodyTable = $("#receiver-main-form").dataTable({
            "bLengthChange" : true,
            "bPaginate"   : true,
            "iDisplayLength": 50,
            "aLengthMenu": [[25, 50, 100, -1], [50, 100, "All"]],
            "aoColumnDefs": [
                { "sClass": "display_none", "aTargets": [ 1, 2, 10 ] },
                { 'bSortable': false, 'aTargets': [ 0, 1 ] }
            ]
        });

        var delflag;
        $('.data-check-parent-remove').on('change', function () {
            if ($(this).is(':checked')) {
                delflag = 0;
                $('.data-check-remove').attr('checked', true);
            } else {
                delflag = 1;
                $('.data-check-remove').attr('checked', false);
            }
        });

        $('#delete-receiver').on('click', function(){
            /*Checking for checked ones values*/
            var dataArrForDelete = [];
            $.each($("input[type=checkbox]:checked"), function () {
                var checkedVal      = $(this).parent().parent().text(); //getting each choosen data from data-table
                var removeNewLines  = removeNewlines(checkedVal);       //removing the new lines
                singleElement       = removeNewLines.split(' ');        //making the string an array
                dataArrForDelete.push(singleElement);                   //pushing the collected data into dataArray which will go to the modal
            });

            if (delflag == 0){
                //console.log(delflag);
                dataArrForDelete.splice(0,3); //remove first three index as data table row will be in the text value item.
            }

            $('input[type=checkbox]:checked', bodyTable.fnGetNodes()).each(function(){
                var rowIndex = bodyTable.fnGetPosition( $(this).closest('tr')[0] );
                //console.log(rowIndex);
                //alert(bodyTable.fnGetData(rowIndex)); //to get the data we can also use this method from datatable
                bodyTable.fnDeleteRow(rowIndex);
            } );
        });
    });

</script>
</section>
