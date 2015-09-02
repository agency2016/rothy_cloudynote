<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 5/7/14
 * Time: 11:06 AM
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CloudeNotes</title>
    <!-- <link rel="stylesheet" type="text/css" href="mail.css" />  -->
</head>

<body style="background-color:#e4f3f8;padding:1% 6%;">
<!-- HEADER -->
<table class="head-wrap" style="background-color:#e4f3f8;width:100%!important;">

    <tr>
        <td>  </td>
        <td class="header container" >
            <div class="content">
                <div class="clearfix" style="padding-top:15px;padding-bottom:15px;">
                    <img src="<?php echo $logo_url; ?>" height="" alt="CloudeNotes Logo" />
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" style="background-color:#e4f3f8;" bgcolor="#FFFFFF">
            <div class="content-new"style=" width: 95%;margin: 0 auto !important; border:1px solid #0D6DDD;background: #fff; box-shadow: 0px 3px 5px #6389BA;
                ">
                <div style="padding:1% 10%;">
                    <div style="margin-top: 30px;clear:both;"></div>

                    <div>
                        <p style="color: #000!important;">Dear<?php echo (isset($fname)) ? ' '.$fname: ''; ?>,</p>
                        <p style="color: #000!important;">CloudeNotes is a new Web Application designed to replace Permission Notes. It allows you to E-sign an online document which is far better way to manage this important process involving our kids.</p>
                        <p style="color: #000!important;">This note is viewable online and is the sort of form that could be created using their easy drag and drop form builder. CloudeNotes will also allow you to collect payment, collect data and importantly keep records that are easily accessed through your Dashboard.</p>
                        <p style="color: #000!important;"> Regards <br/><?php echo (isset($name)) ? ' '.$name: ''; ?>   </p>
                        <div style="margin-top:40px;"></div>
                        <div align="center">
                            <div style="float:left; margin-left: 100px; padding: 5px 0px">
                                <a href="<?php echo base_url('payment/plan/pk1'); ?>" style=" padding: 10px; background: #58ccf3; color: #fff;text-decoration: none;font-weight: bold; font-size: 15px; border:2px solid #37a5f3;">Trial</a>
                            </div>
                            <div style="float:left; margin-left: 15px; padding: 5px 0px">
                                <a href="<?php echo base_url(); ?>" style=" padding: 10px; background: #0d6ddd; color: #fff;text-decoration: none;font-weight: bold; font-size: 15px; border:2px solid #1351dd;">CloudeNotes</a>
                            </div>
                        </div>
                        <br/><br/>
                        <div style="margin-top: 20px;clear:both;"></div>
                        <div align="center">
                            <div style="float:left; margin-left: 120px; padding: 5px 0px">
                                <a href="<?php echo base_url('refer-a-friend'); ?>" style=" padding: 10px; background: #51a351; color: #fff;text-decoration: none;font-weight: bold; font-size: 15px; border:2px solid #2ea332;">Refer a Friend</a>
                            </div>
                        </div>

                        <div style="margin-top:40px;"></div>
                    </div>
                    <div style="margin-top: 40px;clear:both;"></div>
                    <br/><br/><br/>

                </div>
            </div><!-- /content -->
        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap" style="background-color:#e4f3f8;width:100%!important;">
    <tr>
        <td></td>
        <td class="container">
            <!-- content -->
            <div class="content">
                <div align="center">
                    <p>
                        <a style="color: #0D6DDD!important;" href="http://techspiritu.com/cnote/term-of-service">Terms of Service</a> |
                        <a style="color: #0D6DDD!important;" href="http://techspiritu.com/cnote/privacy-policy">Privacy Policy</a> |
                        <a style="color: #0D6DDD!important;" href="http://techspiritu.com/cnote/about-us">About CloudeNotes</a>
                    </p>
                    <div align="center" style="padding-bottom:5px;">
                        <span style="color:#818284">CloudeNotes ABN 79 142 676 819  </span><br/>
                        <span style="color:#818284">CloudeNotes &reg; is a Registered Trademark. </span>

                    </div>
                </div>
            </div><!-- /content -->
        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>