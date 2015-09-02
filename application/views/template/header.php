<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 3:57 PM
 */

?>

<header id="header" class="header">
    <div class="container">
        <div class="header_row">
            <div class="row-fluid">
                <div class="span5">
                    <div class="logo">
                        <?php echo base_url(); ?>
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('resources/img/cloudenote_header_logo.png'); ?>" /></a><!-- End of logo -->
                    </div><!-- End of logo div -->
                </div><!-- End of logo column -->
                <div class="span7">
                    <div class="cb_navigation">
                        <ul class="nav nav-pills">
                            <li>
                                <a href="<?php echo base_url('pricing/'); ?>">Pricing</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('how-it-work'); ?>">How it Works</a>
                            </li>
                            <!-- <li>
                                <a href="#">Customers</a>
                            </li> -->
                            <li>
                                <a href="<?php echo base_url('faq'); ?>">FAQ</a>
                            </li>
                            <!-- <li>
                                <a href="#">Help</a>
                            </li> -->
                            <li class="login_signup_group">
                                <a href="<?php echo base_url('register/');?>" class="login_signup_btn"><button class="btn btn-success btn-small">Sign Up</button></a>
                                <a href="<?php echo base_url('login/');?>" class="login_signup_btn"><button class="btn btn-primary btn-small">Login</button></a>
                            </li>
                        </ul><!-- End of navigation -->
                    </div><!-- End of menu div -->
                </div><!-- End of header menu column -->
            </div><!-- End of header main row -->
        </div><!-- End of header row -->
    </div><!-- End of header container -->
</header><!-- End of header -->