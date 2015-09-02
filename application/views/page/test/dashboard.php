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
        <h2 class="dashboard-heading">Dashboard</h2>
    </div>
</div><!--end of title div-->

<div class="row-fluid dashboard-icon-area">
    <div class="container">
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/create-a-note.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-success">Create a Note</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/notes.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">View Notes</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/class.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">View Classes</button>
        </div>
        <div class="span3 dashboard-icon-bg">
            <img src="<?php echo base_url('resources/img/dashboard-icons/teacher.png'); ?>" alt="Create a Note"/>
            <button type="submit" class="btn btn-large btn-primary">View Teachers</button>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="statistics-title">
                    <h5>Note Statistics</h5>
                </div>
                <div class="statistics-area">
                    <table class="table table-striped">
                        <tr>
                            <th>Title of Note<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                            <th>Created<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                            <th>Status<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                            <th>Out<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                        </tr>
                        <tr>
                            <td>Annual School Picnic</td>
                            <td>08/03/14</td>
                            <td>Not Sent</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Collection of Exam Fee for Exam
                                #983839 Grade 7 Math Olympiad
                            </td>
                            <td>08/03/14</td>
                            <td>Not Sent</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                        <tr>
                            <td>Field Trip to Sydney Zoo</td>
                            <td>08/07/14</td>
                            <td>Sent</td>
                            <td>15/07/13</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><!--end of note statistics div-->

        <div class="row-fluid">
            <div class="span12">
                <div class="statistics-title">
                    <h5>Financial Statistics</h5>
                </div>
                <div class="statistics-area">
                    <table class="table table-striped">
                        <tr>
                            <th>Transaction<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                            <th>Date<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                            <th>AUS $<span class="sort-down"><i class="fa fa-sort-down"></i></span><span class="sort-up"><i class="fa fa-sort-up"></i></span></th>
                        </tr>

                        <tr>
                            <td>Monthly Subscription Fee for CloudeNotes
                                (99 Plus Flexible Plan)
                            </td>
                            <td>01/12/13</td>
                            <td>14.83</td>
                        </tr>
                        <tr>
                            <td>Note Collection: Field Trip to Sydney Zoo</td>
                            <td>15/11/13</td>
                            <td>200.00</td>
                        </tr>
                        <tr>
                            <td>Monthly Subscription Fee for CloudeNotes
                                (99 Plus Flexible Plan)
                            </td>
                            <td>01/12/13</td>
                            <td>14.83</td>
                        </tr>
                        <tr>
                            <td>Monthly Subscription Fee for CloudeNotes
                                (99 Plus Flexible Plan)
                            </td>
                            <td>01/12/13</td>
                            <td>14.83</td>
                        </tr>
                        <tr>
                            <td>Note Collection: Field Trip to Sydney Zoo</td>
                            <td>15/11/13</td>
                            <td>200.00</td>
                        </tr>
                        <tr>
                            <td>Monthly Subscription Fee for CloudeNotes
                                (99 Plus Flexible Plan)
                            </td>
                            <td>01/12/13</td>
                            <td>14.83</td>
                        </tr>
                        <tr>
                            <td>Note Collection: Field Trip to Sydney Zoo</td>
                            <td>15/11/13</td>
                            <td>200.00</td>
                        </tr>
                        <tr>
                            <td>Monthly Subscription Fee for CloudeNotes
                                (99 Plus Flexible Plan)
                            </td>
                            <td>01/12/13</td>
                            <td>14.83</td>
                        </tr>
                        <tr>
                            <td>Note Collection: Field Trip to Sydney Zoo</td>
                            <td>15/11/13</td>
                            <td>200.00</td>
                        </tr>
                        <tr>
                            <td>Note Collection: Field Trip to Sydney Zoo</td>
                            <td>15/11/13</td>
                            <td>200.00</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><!--end of financial statistics div-->
    </div><!--endo of container div of-->
</div><!--statistics div end-->