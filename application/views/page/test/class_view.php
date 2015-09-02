<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/23/14
 * Time: 11:58 AM
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
        <h2 class="dashboard-heading">Class View</h2>
    </div>
</div><!--end of title div-->

<div class="row-fluid dashboard-icon-area">
    <div class="container">
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/create-a-note.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-success">Add New Class</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Upload Teachers</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/class.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Upload Students</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">Not Decided</button>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="container">
        <div class="row-fluid table-area-filter-bg class-view-filter-bg-top">
            <div class="span5">
                <h3 class="class-view-heading">Existing Classes</h3>
            </div>
            <div class="span4">
                <div class="student-form-group class-view-form-group">
                    <label for="User Filter" style="padding-right: 10px">Search Filter </label>
                    <select id="class-filter" class="selectpicker">
                        <option selected="selected" >Title of Class</option>
                        <option>Teacher</option>
                    </select>
                </div>
            </div>
            <div class="span3 class-view-search">
                <div class="student-form-group">
                    <input type="text" id="rg-to" name="rg-to" value="" class="form-control" placeholder="Search....">
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <table class="table table-striped class-view-table">
                    <tr>
                        <th><input type="checkbox"/> </th>
                        <th></th>
                        <th>Title of Class<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                        <th>Teacher<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                        <th>Not. of Students</th>
                        <th>Created</th>
                        <th>Created by<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>1.</td>
                        <td><span class="class-name">1xx</span></td>
                        <td><span class="not-assigned">Not Assigned</span></td>
                        <td>12</td>
                        <td>03/01/14</td>
                        <td>School Admin</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>2.</td>
                        <td><span class="class-name">Class Names Can Also be Login for Clubs etc.</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 1</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>3.</td>
                        <td><span class="class-name">2BJ</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>4.</td>
                        <td><span class="class-name">2AJ</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>5.</td>
                        <td><span class="class-name">2BJ</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>6.</td>
                        <td><span class="class-name">2BJ</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>7.</td>
                        <td><span class="class-name">2BD</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"/></td>
                        <td>8.</td>
                        <td><span class="class-name">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto cum doloribus magni nulla optio quaerat, quam quisquam sunt veritatis voluptatem. A aliquid atque beatae consectetur fugiat iste porro quasi voluptatem.</span></td>
                        <td><span>Mr. James Falkner</span></td>
                        <td>25</td>
                        <td>03/08/14</td>
                        <td>Admin Teacher 2</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row-fluid table-area-filter-bg class-view-filter-bg">
            <div class="span4 selected-class">
                <p>Viewing 8 of total 18 classes</p>
            </div>
            <div class="span4">
                <div class="pagination class-view-pagi">
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
            <div class="span4">
                <div class="view-button">
                    <button class="btn btn-primary">View All</button>
                </div>
            </div>
        </div>
    </div><!--endo of container div of-->
</div><!--statistics div end-->