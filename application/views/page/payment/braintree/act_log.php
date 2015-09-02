<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/29/14
 * Time: 5:51 PM
 */
?>
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div>
                <h2 style="color:#000000">Activity Log For User Subscription</h2>
            </div>
            <table class="table table-stripped well">
                <tr>
                    <th>Name</th>
                    <th>Organization</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Time</th>
                    <th>Paid By</th>
                    <th>Status</th>
                </tr>
                <?php foreach($act_log as $log): ?>
                <tr>
                    <td><?php echo $log->order_id; ?></td>
                    <td><?php echo $log->school_id; ?></td>
                    <td><?php echo $log->amount; ?></td>
                    <td><?php echo $log->transaction_id; ?></td>
                    <td><?php echo $log->created_at; ?></td>
                    <td><?php echo $log->credit_card_type.' '.$log->credit_card_number; ?></td>
                    <td><?php echo $log->credit_card_status; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
