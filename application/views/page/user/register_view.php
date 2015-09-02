<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 5:43 PM
 */


//Load Doctype Part
$this->load->view('include/doctype');

?>

    <div class="container">
        <div class="content-container">
            <div class="row">
                <div class="content-row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="register-form">

                            <div class="well">
                                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" style="padding: 15px">
                                    <div class="form-group">
                                        <?php echo form_error('email', '<div class="alert alert-danger">', '</div>'); ?>
                                        <?php echo form_error('user_name', '<div class="alert alert-danger">', '</div>'); ?>
                                        <?php echo form_error('password', '<div class="alert alert-danger">', '</div>'); ?>
                                        <?php
                                        if(isset($pass_not_match) and !empty($pass_not_match)) {
                                            echo '<div class="alert alert-danger">'.$pass_not_match.'</div>';
                                        }
                                        if(isset($user_name_exist) and !empty($user_name_exist)) {
                                            echo '<div class="alert alert-danger">'.$user_name_exist.'</div>';
                                        }
                                        if(isset($email_exist) and !empty($email_exist)) {
                                            echo '<div class="alert alert-danger">'.$email_exist.'</div>';
                                        }
                                        ?>

                                    </div>

                                    <div class="form-group <?php echo (form_error('user_name') != '') ? 'has-error' : ''; ?>">
                                        <input type="text" name="user_name" id="user_name" class="form-control input-lg" placeholder="Username" value="<?php echo set_value('user_name'); ?>" autocomplete="off">
                                    </div>

                                    <div class="form-group <?php echo (form_error('email') != '') ? 'has-error' : ''; ?>">
                                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="<?php echo set_value('email'); ?>" autocomplete="off">
                                    </div>

                                    <div class="form-group <?php echo ((isset($pass_not_match) and !empty($pass_not_match)) or form_error('password') != '') ? 'has-error' : ''; ?>">
                                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" value="">
                                    </div>

                                    <div class="form-group <?php echo ((isset($pass_not_match) and !empty($pass_not_match)) or form_error('con_password') != '') ? 'has-error' : ''; ?>">
                                        <input type="password" name="con_password" id="con_password" class="form-control input-lg" placeholder="Confirm Password">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" name="register" id="register" class="btn btn-primary btn-lg btn-block" value="Register">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6"><a href="<?php echo base_url('user/forgot'); ?>">Forgot Password</a></div>
                                            <div class="col-md-6"><a href="<?php echo base_url('user/login'); ?>">login here</a></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

$this->load->view('include/footer');

?>