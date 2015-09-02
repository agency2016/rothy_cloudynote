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
                                    <th>Title of Note</th>
                                    <th>Date Received</th>
                                    <th>Status</th>
                                    <th>Replied</th>
                                    <th>Payment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                <?php// foreach ($section_member_list as $list): ?>
                                    <tr>
                                        <td ><input type="checkbox" name="data[1][id]" value="1" class="data-check"></td>
                                        <td ><?php echo ++$i.'.'; ?></td>
                                        <td ><?php echo "Visit os tarango Zoo"; ?></td>
                                        <td>10/05/2012</td>
                                        <td class="label label-success">Opened</td>
                                        <td ><?php echo "true"; ?></td>
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
    </div>
    <div class="modal-footer">
        <a href="#" id="delete_member" class="btn btn-success">Yes</a>
        <a href="#" id="delclosenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>

