<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 5/6/14
 * Time: 12:03 PM
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
                                    <th>Name of School</th>
                                    <th>Admin Contact</th>
                                    <th>Email</th>
                                    <th>Date Registered </th>
                                    <th>Plan</th>
                                    <th>Revenue MTD</th>
                                    <th>Revenue YTD</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i =1; foreach($getData as $data) : ?>
                                <tr>
                                    <td><?php echo $i++.'.'; ?></td>
                                    <td><?php echo $data->organisation_name; ?></td>
                                    <td><?php echo $data->first_name.' '.$data->last_name; ?></td>
                                    <td><?php echo $data->email; ?></td>
                                    <td><?php echo $data->created; ?></td>
                                    <td><?php echo ($data->package_description != '') ? $data->package_description : 'Not Yet Choosen'; ?></td>
                                    <?php if($data->order_id != '') { ?>
                                    <td><?php echo ($data->recurring_transaction == 1) ? $data->amount : ''; ?></td>
                                    <td><?php echo ($data->recurring_transaction == 1) ? '' : $data->amount; ?></td>
                                    <?php } else { ?>
                                    <td>No Transaction made!</td>
                                    <td>No Transaction made!</td>
                                    <?php } ?>
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
