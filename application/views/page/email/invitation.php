<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/1/13
 * Time: 4:04 PM
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CloudeNotes</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resources/css/email.css');?>" />
    <style type="text/css ">
        .test {
            color: #000000;
        }
    </style>
</head>

<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#e4f3f8">
    <tr>
        <td></td>
        <td class="header container" >

            <div class="content">
                <table bgcolor="#e4f3f8">
                    <tr style="text-align: center;">
                        <td colspan="2"><img src="<?php echo base_url('resources/img/cloudenote_header_logo.png'); ?>" /></td>
                    </tr>
                </table>
            </div>

        </td>
        <td></td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <div class="content">
                <table>
                    <tr>

                        <td>
                            <h3>Hi<?php echo (isset($recipient_first_name) and !empty($recipient_first_name)) ? ' '.$recipient_first_name: ''; ?>,</h3>

                        <?php if($in_temp): ?>
                            <!-- Callout Panel -->
                            <p class="callout" style="display: block">
                                To activate your account, <a href="<?php echo $activate_url;?>" target="_blank" style="text-decoration:none;">Click Here</a><br />
                                If Click does not work please copy and paste the link from bellow and hit by your browser.<br />
                                <a href="<?php echo $activate_url;?>" style="font-size:12px;font-weight:normal;text-decoration:none;"><?php echo $activate_url;?></a>
                            </p><!-- /Callout Panel -->

                        <?php endif; ?>

                        <?php if($auto_register): ?>
                            <!-- Callout Panel -->
                            <p class="callout" style="display: block">
                                Password: <?php echo $password; ?>
                                You are auto registerd by your school admin. Plz confirm you invitation in next 24 hours
                            </p><!-- /Callout Panel -->

                        <?php endif; ?>


                            <p class="lead">
                                <!-- url-format: http://example.com/org-(organasation-id)/in/(section-id)/acpt-invt/con-md5(invite-email)-->
                                <a href="<?php echo base_url('org-'.$organisation_id.'/in/'.$assign_section_id.'/acpt-invt/con-'.$assign_access_id); ?>" class="btn btn-primary">Accept Invitation</a>
                                <a href="<?php echo base_url('org-'.$organisation_id.'/in/'.$assign_section_id.'/dn-invt/con-'.$assign_access_id); ?>" class="btn btn-primary">Deny Invitation</a>
                            </p>

                            <!-- social & contact -->
                            <table class="social" width="100%">
                                <tr>
                                    <td>

                                        <!-- column 1 -->
                                        <table align="left" class="column">
                                            <tr>
                                                <td>

                                                    <h5 class="">Connect with Us:</h5>
                                                    <p class=""><a href="#" class="soc-btn fb">Facebook</a> <a href="#" class="soc-btn tw">Twitter</a> <a href="#" class="soc-btn gp">Google+</a></p>


                                                </td>
                                            </tr>
                                        </table><!-- /column 1 -->

                                        <!-- column 2 -->
                                        <table align="left" class="column">
                                            <tr>
                                                <td>

                                                    <h5 class="">Contact Info:</h5>
                                                    <p>Phone: <strong>408.341.0600</strong><br/>
                                                        Email: <strong><a href="emailto:hseldon@trantor.com">hseldon@trantor.com</a></strong></p>

                                                </td>
                                            </tr>
                                        </table><!-- /column 2 -->

                                        <span class="clear"></span>

                                    </td>
                                </tr>
                            </table><!-- /social & contact -->

                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>
                                <a href="#">Terms</a> |
                                <a href="#">Privacy</a> |
                                <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>