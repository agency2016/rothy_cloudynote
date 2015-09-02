<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 5/6/14
 * Time: 2:19 PM
 */
?>

<div class="row-fluid">
    <div class="container">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid table-area-filter-bg">
                    <div class="span2 print-result">
                        <a href="javascript:window.print()">
                            <i class="fa fa-print fa-2x"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <?php if(empty($getData)){
                                echo "No data Available.";
                            }else{?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Student Name</th>
                                        <th>School Name</th>
                                        <th>Parent 1 Name</th>
                                        <th>Email</th>
                                        <th>Parent 1 Name</th>
                                        <th>Email</th>
                                        <th>Date Registered</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =1; foreach($getData as $data) : ?>
                                        <tr>
                                            <td><?php echo $i++.'.'; ?></td>
                                            <td><?php echo $data->section_member_first_name.' '.$data->section_member_last_name; ?></td>
                                            <td><?php echo $data->organisation_name; ?></td>
                                            <td><?php echo $data->section_member_fathers_first_name.' '.$data->section_member_fathers_last_name; ?></td>
                                            <td><?php echo $data->section_member_fathers_email; ?></td>
                                            <td><?php echo $data->section_member_mothers_first_name.' '.$data->section_member_mothers_last_name; ?></td>
                                            <td><?php echo $data->section_member_mothers_email; ?></td>
                                            <td><?php echo $data->section_member_created_at; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
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

        $('.dataTables_filter input').attr("placeholder", "enter seach terms here");
    });
</script>
