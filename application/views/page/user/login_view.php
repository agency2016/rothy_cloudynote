<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 4:10 PM
 */


//Load Doctype Part

?>

    <div class="container">
        <div class="content-container">
            <div class="row">
                <div class="content-row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-form">

                            <div class="well">
                                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" style="padding: 15px">
                                    <div class="form-group">
                                        <?php echo form_error('user_name', '<div class="alert alert-danger">', '</div>'); ?>
                                        <?php echo form_error('password', '<div class="alert alert-danger">', '</div>'); ?>
                                        <?php
                                        if(isset($invalid_login) and !empty($invalid_login)) {
                                            echo '<div class="alert alert-danger">'.$invalid_login.'</div>';
                                        }
                                        ?>

                                    </div>

                                    <div class="form-group <?php echo (form_error('user_name') != '') ? 'has-error' : ''; ?>">
                                        <input type="text" name="user_name" id="user_name" class="form-control input-lg" placeholder="Username" value="<?php echo set_value('user_name'); ?>" autocomplete="off">
                                    </div>

                                    <div class="form-group <?php echo (form_error('password') != '') ? 'has-error' : ''; ?>">
                                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" value="">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" name="login" id="login" class="btn btn-success btn-lg btn-block" value="Login">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6"><a href="<?php echo base_url('user/forgot'); ?>">Forgot Password</a></div>
                                            <div class="col-md-6"><a href="<?php echo base_url('user/register/'); ?>">Sign-Up here</a></div>
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