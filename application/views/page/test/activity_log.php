<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 3/3/14
 * Time: 12:50 PM
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



<div class="row-fluid">
    <div class="container">
        <div class="span8 log-bg">
            <!--<h3>Activity Log</h3>-->
            <table class="table table-act">
                <tr>
                    <td>
                        <p><strong>Today</strong></p>
                        <p>January 3, 2014</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil account-act"></i></span><span class="label account-act-bg label-override">Account</span><span class="profile-name">John Doe</span>changed billing information 11.54am</li>
                            <li><span><i class="fa fa-sign-in user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged in. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-sign-out user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged out. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-sign-in user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged in. 9.09am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">David Thomas</span>created note: Visit to Taranga Zoo. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil signup-act"></i></span><span class="label signup-act-bg label-override">Signup</span><span class="profile-name">South Breeze Jr School</span>signed up for free trial. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">Larry Thomas</span>replied to note: Visit to Taranga Zoo. 11.53am</li>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">David Luis</span>view the note: Visit to Taranga Zoo. 12.53am</li>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">Shah Butt</span>replied to note: Visit to Taranga Zoo. 12.59am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil signup-act"></i></span><span class="label signup-act-bg label-override">Signup</span><span class="profile-name">South Breeze Jr School</span>signed up $269 Plan. 11.53am</li>
                            <li><span><i class="fa fa-sign-out user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged out. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil account-act"></i></span><span class="label account-act-bg label-override">Account</span><span class="profile-name">John Doe</span>changed billing information 11.54am</li>
                            <li><span><i class="fa fa-sign-in user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged in. 11.53am</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <div class="footer-table">
                <div class="pagination">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="form-group">
                <label for="User Filter">Show Me</label>
                <select id="class-filter" class="selectpicker">
                    <option selected="selected" >All Activities</option>
                    <option>Signup Activity</option>
                    <option>Account Activity</option>
                    <option>Note Activity</option>
                    <option>User Activity</option>
                </select>
            </div>
            <div class="legend-unit">
                <label for="Legend">Activity Legend</label>
                <ul>
                    <li class="signup-act"><i class="fa fa-circle"></i>Signup Activity</li>
                    <li class="account-act"><i class="fa fa-circle"></i>Account Activity</li>
                    <li class="note-act"><i class="fa fa-circle"></i>Note Activity</li>
                    <li class="user-act"><i class="fa fa-circle"></i>User Activity</li>
                </ul>
            </div>
        </div>
    </div>
</div>