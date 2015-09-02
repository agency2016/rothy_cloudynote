<?php
/**
 * Created by PhpStorm.
 * User: ridhia
 * Date: 29/03/14
 * Time: 10:20
 */
$this->view('page/dashboard-icon-menu/parent-icon');
?>
<div class="container">
    <div class="row-fluid">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid table-area-header">
                    <div class="span4">
                        <h3>Cloud Notes List</h3>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4 custom-span">
                        <div class="student-form-group">
                            <label for="User Filter">Action</label>
                            <select id="action-filter" class="selectpicker">
                                <option selected="selected" >Select Action</option>
                                <option value="add_email">View Note</option>
                                <option value="send_invitation">Reply to Note</option>
                            </select>
                        </div>
                    </div>
                    <div class="span4">
                        <ul id="table-footer">
                            <li style="display: none"><input type="checkbox" name="checkall" class="data-check-parent"></li>
                            <li>Viewing Notes for</li>
                        </ul>
                    </div>
                    <!-- <div class="span4 custom-span">
                         <div class="student-form-group">
                             <label for="User Filter">Viewing Notes for</label>
                             <select id="alert-filter" class="selectpicker">
                                 <option>Child Name</option>
                             </select>
                         </div>
                     </div>-->
                    <div class="span4 custom-span">
                        <div class="student-form-group">
                            <label for="User Filter">Filter</label>
                            <select id="note-filter" class="selectpicker">
                                <option selected="selected" >None</option>
                                <option>Opened</option>
                                <option>Unopened</option>
                                <option>Replied</option>
                                <option>Not Replied</option>
                                <option>Paid</option>
                                <option>Due</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div id="demo">
                            <?php /*if(empty($section_member_list)){
                                echo "No data Available.";
                            }else{*/
                            ?>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="adnanform">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" class="data-check-parent"></th>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Payment Reference</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                <?php// foreach ($section_member_list as $list): ?>
                                <tr>
                                    <td ><input type="checkbox" name="data[1][id]" value="1" class="data-check"></td>
                                    <td ><?php echo ++$i.'.'; ?></td>
                                    <td>10/05/2012</td>
                                    <td ><?php echo "Lane Cove Public Athletics Carnival"; ?></td>
                                    <td ><?php echo "50.00"; ?></td>
                                    <td ><?php echo "paid"; ?></td>
                                </tr>
                                <?php // endforeach; ?>
                                </tbody>
                                <?php //}?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span12" style="text-align: center">
                        <div class="pagination">
                            <?php //echo $pagination; ?>
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

