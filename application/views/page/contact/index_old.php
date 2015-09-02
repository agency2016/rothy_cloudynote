<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/24/13
 * Time: 5:21 PM
 */

?>

<section class="main-body-content">
    <div class="container">

        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">
                    <?php $this->load->view('page/include/page_title', array('page_name' => 'Contact Us')); ?>
                </div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>

        <div class="contact-us-container">
            <div class="span12">
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="span10 offset1">
                            <div class="form-title">
                                <?php if ( !$this->dx_auth->is_logged_in()) { ?>
                                    <h4>Please Login with your current account or <a href=" <?php echo base_url("login"); ?>">click here</a> to create a new one with just an email and password</h4>
                                <?php } else { ?>
                                    <h4>Please fill up the form to submit your query</h4>
                                <?php } ?>
                            </div><!-- End of Form Title -->

                            <div class="flashdata">
                                <?php if ( $success_message ) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php echo $success_message; ?>
                                    </div>
                                <?php } if ( $failure_message ) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php echo $failure_message; ?>
                                    </div>
                                <?php } if ( $error_login ) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php echo $error_login; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="contact-us-form">
                                <form id="contact-form" class="form-horizontal" action="<?php echo base_url("home/email_admin"); ?>" method="post">

                                <?php if( !$this->dx_auth->is_logged_in()): ?>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="control-group <?php if ( form_error('user_login_email') ) echo 'error'; ?>">
                                                <input id="email" class="input-lg" type="email" placeholder="Email" name="user_login_email" value="<?php echo set_value('user_login_email'); ?>">
                                                <span class="help-block"><?php echo form_error('user_login_email'); ?></span>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group <?php if ( form_error('user_login_password') ) echo 'error'; ?>">
                                                <input id="password" class="input-lg" type="password" placeholder="Password" name="user_login_password">
                                                <span class="help-block"><?php echo form_error('user_login_password'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <?php endif; ?>

                                    <div class="control-group <?php if ( form_error('email_subject') ) echo 'error'; ?>">
                                        <input id="subject" class="input-lg input-half" type="text"  placeholder="Subject" size="30" name="email_subject" value="<?php echo set_value('email_subject'); ?>">
                                        <span class="help-block"><?php echo form_error('email_subject'); ?></span>
                                    </div>
                                    <div class="control-group <?php if ( form_error('email_message') ) echo 'error'; ?>">
                                        <textarea id="message" class="input-xxlarge input-lg input-half" rows="7" placeholder="Message..." name="email_message" value="<?php echo set_value('email_message'); ?>"><?php echo set_value('email_message'); ?></textarea>
                                        <span class="help-block"><?php echo form_error('email_message'); ?></span>
                                    </div>
                                    <div class="control-group">
                                        <button type="submit" class="btn btn-large"><i class="fa fa-envelope"></i> <strong>Send Message</strong></button>
                                    </div>
                                </form><!-- End of form -->
                            </div><!-- End of Contact Us form -->
                        </div><!-- End of Contact Us form Column -->
                    </div><!-- End of Contact Us form row-fluid -->
                </div><!-- End of Contact Page Form span12 -->
            </div><!-- End of Contact Page Form row-fluid -->
        </div><!-- End of Contact Us form Container -->
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->

<script type="text/javascript">
    $('#contact-form').validate({
        rules: {
            user_login_email: {
                required: true,
                email: true
            },
            user_login_password: {
                minlength: 3,
                required: true
            },
            email_subject: {
                minlength: 6,
                required: true
            },
            email_message: {
                minlength: 20,
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
                .addClass('valid').text('Valid!')
                .closest('.control-group').removeClass('error').addClass('success');
        }
    });
</script>

