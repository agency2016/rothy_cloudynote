<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/28/13
 * Time: 6:16 PM
 */

?>



<section class="main-body-content">
    <div class="container">
        <div class="auth-form-container">
            <div class="row-fluid">
                <div class="span8 offset2">
                    <div class="form-container">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="register-form">
                                    <form class="form-horizontal" action="<?php echo base_url('register/');?>" method="post">

                                        <legend>Register</legend>

                                        <?php echo form_error('user_email', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('user_password', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('registration_as', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo (isset($auth_email_exist_error) and !empty($auth_email_exist_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$auth_email_exist_error.'</div>': ''; ?>

                                        <div class="control-group">
                                            <input type="email" name="user_email" placeholder="Email">
                                        </div>
                                        <div class="control-group">
                                            <input type="password" name="user_password" placeholder="Password">
                                        </div>
                                        <div class="control-group">
                                            <select name="register_as">
                                                <option>Select from List</option>
                                                <option value="1">WE ARE A SCHOOL</option>
                                                <option value="2">WE ARE A SUMMER CAMP</option>
                                                <option value="3">WE ARE A SCOUT GROUP</option>
                                                <option value="4">WE ARE A SPORTS TEAM</option>
                                                <option value="5">I AM A TEACHER</option>
                                                <option value="6">I AM A PARENT</option>
                                                <option value="7">I AM A STUDENT</option>
                                                <option value="8">OTHERS</option>
                                            </select>
                                        </div>
                                        <div class="control-group">
                                            <button class="btn btn-large btn-primary" type="submit">Sign Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="login-form">
                                    <form class="form-horizontal form-login" action="<?php echo base_url('login/');?>" method="post">

                                        <legend>Login</legend>

                                        <?php echo form_error('user_login_email', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo form_error('user_login_password', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo (isset($auth_error) and !empty($auth_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$auth_error.'</div>': ''; ?>
                                        <?php echo (isset($forgot_mail_send_success) and !empty($forgot_mail_send_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success! </strong>'.$forgot_mail_send_success.'</div>': ''; ?>

                                        <div class="control-group">
                                            <input type="email" name="user_login_email" placeholder="Email" value="<?php echo !empty($user_email_system_received) ? $user_email_system_received : set_value( 'user_login_email' ) ; ?>">
                                        </div>

                                        <div class="control-group">
                                            <input type="password" name="user_login_password" placeholder="Password">
                                        </div>

                                        <div class="control-group">
                                            <label class="checkbox">
                                                <input type="checkbox" name="remember_me"> Remember me
                                            </label>
                                            <span class="checkbox">Forgot password ? <a href="#" class="forgot-password">Change Password</a></span>
                                        </div>

                                        <div class="control-group">
                                        </div>

                                        <div class="control-group">
                                            <button class="btn btn-large btn-success" type="submit">Login</button>
                                        </div>
                                    </form>


                                    <!-- Forgot form -->

                                    <form class="form-horizontal form-forgot" action="<?php echo base_url('forgot-password/');?>" method="post">

                                        <legend>Forgot Password</legend>

                                        <?php echo form_error('user_forgot_email', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>', '</div>'); ?>
                                        <?php echo (isset($auth_forgot_pass_error) and !empty($auth_forgot_pass_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong>'.$auth_forgot_pass_error.'</div>': ''; ?>

                                        <div class="control-group">
                                            <input type="email" name="user_forgot_email" placeholder="Email">
                                        </div>

                                        <div class="control-group">
                                            Already have account. Please <a href="#" class="have-account">Login</a>
                                        </div>

                                        <div class="control-group">
                                            <button class="btn btn-large btn-success" type="submit">Send Password</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->