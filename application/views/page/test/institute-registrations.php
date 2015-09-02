<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 3/4/14
 * Time: 11:48 AM
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
        <h2 class="dashboard-heading">Institute Registrations</h2>
    </div>
</div><!--end of title div-->

<div class="row-fluid">
    <div class="container">
        <div class="span12" style="padding-top: 55px">
            <div class="table-area">
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4">
                        <div class="student-form-group">
                            <label for="User Filter" style="padding-right: 10px">Lorem Ipsum </label>
                            <select id="class-filter" class="selectpicker">
                                <option selected="selected" >Primary Schools</option>
                                <option>Secondary Schools</option>
                            </select>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="student-form-group">
                            <label for="User Filter" style="padding-right: 10px">Search Filter </label>
                            <select id="class-filter" class="selectpicker">
                                <option selected="selected" >Admin Contact</option>
                                <option>Mobile</option>
                                <option>Email</option>
                            </select>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="student-form-group">
                            <input type="text" id="rg-to" name="rg-to" value="" class="form-control" placeholder="Search....">
                        </div>
                    </div>

                    <div class="span1 print-result">
                        <img src="<?php echo base_url('resources/img/icon-printer.png'); ?>" alt=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-striped registration-table">
                            <tr>
                                <th></th>
                                <th>Name of Schol etc<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                                <th>Admin Contact<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Registered<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                                <th>Plan<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                                <th>Revenue MTD<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                                <th>Revenue YTD<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>

                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>9.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>10.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>11.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>12.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>13.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>14.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>15.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>16.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>17.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>18.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>19.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                            <tr>
                                <td>20.</td>
                                <td>Lane Cove Public</td>
                                <td>John Smith</td>
                                <td>js@gmail.com</td>
                                <td>423666777</td>
                                <td>2/02/2014</td>
                                <td>A</td>
                                <td>$45</td>
                                <td>$149</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row-fluid table-area-filter-bg">
                    <div class="span4">
                        <div class="student-form-group">
                            <label for="User Filter" style="padding-right: 10px">Lorem Ipsum </label>
                            <select id="class-filter" class="selectpicker">
                                <option selected="selected" >USA</option>
                                <option>AUS</option>
                            </select>
                        </div>
                    </div>
                    <div class="span4">
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