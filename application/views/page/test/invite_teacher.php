<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 3/6/14
 * Time: 9:39 AM
 */
?>

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
        <h2 class="dashboard-heading">Invite Teachers</h2>
    </div>
</div><!--end of title div-->

<div class="row-fluid invite-teacher-form-bg">
    <div class="container invite-teacher-form-body">
        <div class="row-fluid">
            <div class="span12">
                <p>Please use the form below to invite an individual teacher to class. The teacher will receive the invitation via email. Create class first (click here) if it doesn't already exist.</p>
            </div>
        </div>
        <div class="row-fluid invite-teacher-form-part">
            <div class="span4 offset3">
                <form action="#" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Email of Teacher</label>
                        <div class="controls">
                            <input type="email" name="teacher_email" placeholder="Email of Teacher">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputTeacherfName">First Name of Teacher</label>
                        <div class="controls">
                            <input type="text" name="teacher_f_name" placeholder="First Name of Teacher">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputTeacherlName">Last Name of Teacher</label>
                        <div class="controls">
                            <input type="text" name="teacher_l_name" placeholder="Last Name of Teacher">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="inputTeacherlName">Class</label>
                        <div class="controls">
                            <select name="register_as">
                                <option value="1">3BJ</option>
                                <option value="2">5TK</option>
                                <option value="3">3ABD</option>
                                <option value="4">1XL</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="submit" class="btn-large btn-success" id="submit" name="submit" value="Send Invitation" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid dashboard-icon-area">
    <div class="container">
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/create-a-note.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Dashboard</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Invite Teachers</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Upload Teachers</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/class.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Create Class</button>
        </div>
    </div>
</div>