<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 3:57 PM
 */


?>
<header id="header" class="header">
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
                            <?php if ($login_user_data->user_access_level != 1) { ?>
                            <li>
                                <a href="<?php echo base_url('user/'); ?>">Dashboard</a>
                            </li>
                            <?php } else { ?>
                            <li>
                                <a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
                            </li>
                            <?php } ?>
                            <?php if ($login_user_data->user_access_level == 1) : ?>
                            <li>
                                <a href="<?php echo base_url('user/parent-student-view'); ?>">Parents Registration</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('user/institute-view'); ?>">Institute Registration</a>
                            </li>
                            <?php endif; ?>
                            <?php if ($login_user_data->user_access_level > 1) : ?>
                            <li>
                                <a href="<?php echo base_url( 'notes/new' ); ?>">Create New</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('notes/page') ?>">View Notes</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('user/classes') ?>">Classes</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('user/students') ?>">Students</a>
                            </li>
                              <?php if($login_user_data->user_access_level < '4'):?>
                            <li>
                                <a href="<?php echo base_url('user/staff-list') ?>">Teachers</a>
                            </li>
                              <?php endif; endif;?>
                            <li>
                                <a href="#">Help</a>
                            </li>
                        </ul><!-- End of navigation -->

                    </div><!-- End of menu div -->
                </div><!-- End of header menu column -->
                <div class="span1">
                    <div class="btn-group pull-right dashboard-user-icon">
                        <button class="btn"><i class="fa fa-user"></i> <?php echo $this->session->userdata('CN_first_name'); ?></button>
                        <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo ($login_user_data->user_access_level > '2') ? base_url('user/profile') : base_url('dashboard/profile'); ?>"><i class="fa fa-info-circle"></i> View Profile</a></li>
                            <li><a href="<?php echo ($login_user_data->user_access_level > '2') ? base_url('user/settings') : base_url('dashboard/settings'); ?>"><i class="fa fa-wrench"></i> Settings</a></li>
                            <li><a href="<?php echo ($login_user_data->user_access_level > '2') ? base_url('setupschool') : base_url('dashboard/settings'); ?>"><i class="fa fa-wrench"></i> SetUp</a></li>
                            <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
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
            <h2 class="dashboard-heading"><?php echo $page_title; ?></h2>
        </div>
    </div><!--end of title div-->


    <?php if( isset( $load_drag_items ) and $load_drag_items == true ): ?>

    <div class="row-fluid breadcrumb-row-bg">
        <div class="container">
            <div class="span2">
                <img src="<?php echo base_url('resources/img/icon-dashboard.png'); ?>" alt="">
            </div>
            <div class="span10">
                <div id="note-wizard">
                    <div id="cloud_crumbs">
                        <div class="tabbable">
                            <ul class="breadcumb nav nav-tabs">
                                <li><a href="#tab_begin_note"  data-toggle="tab">Begin Note</a></li>
                                <li><a href="#tab_preview_note"  data-toggle="tab">Preview</a></li>
                                <li><a href="#tab_add_receivers"  data-toggle="tab">Receivers</a></li>
                                <li><a href="#tab_send_note"  data-toggle="tab">Send</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end of drag item-->


    <!--<div class="row-fluid breadcrumb-row-bg">
        <div class="container">
            <div class="span2">
                <img src="<?php /*echo base_url('resources/img/icon-dashboard.png'); */?>" alt="">
            </div>
            <div class="span10">
                <div id="note-wizard">
                    <div id="cloud_crumbs">
                        <div class="tabbable">
                            <ul>
                                <li><a href="#tab_begin_note">Begin Note</a></li>
                                <li><a href="#tab_add_receivers">Receivers</a></li>
                                <li><a href="#tab_preview_note">Preview</a></li>
                                <li><a href="#tab_send_note">Send</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <?php endif; ?>


</header>

