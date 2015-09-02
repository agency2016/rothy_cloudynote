<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CloudeNotes</title>
</head>

<body style="background-color:#e4f3f8;padding:1% 6%;">

<table class="head-wrap" style="background-color:#e4f3f8;width:100%!important;">
    <tr>
        <td>  </td>
        <td class="header container" >
            <div class="content">
                <div class="clearfix" style="padding-top:15px;padding-bottom:15px;">
                    <img src="{{logo_url}}" height="" alt="CloudeNotes Logo" />
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>


<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" style="background-color:#e4f3f8;" bgcolor="#FFFFFF">
            <div class="content-new" style=" width: 95%; margin: 0 auto !important; border:1px solid #0D6DDD; background: #fff; box-shadow: 0px 3px 5px #6389BA;">
                <div style="padding:1% 10%;">
                    <div style="margin-top: 30px;clear:both;"></div>
                    <div>
                        <h2 style="color:#0D6DDD;text-align:center;padding-top:10px;">New CloudeNote</h2>
                    </div>
                    <div>
                        <p style="color:#0D6DDD;text-align:center;">You have a new CloudeNote from {{organisation_name}} </p>
                    </div>
                    <div style="margin-top: 50px;clear:both;"></div>
                    <div align="center">
                        <a href="{{note_public_url}}" style="padding: 18px; background: #00B030; color: #fff; text-decoration: none; font-weight: bold; font-size: 22px; border:2px solid #008000;">View <span style="background-color:#008000; border:1px solid #0D6DDD; padding: 3px;" >CloudeNote</span></a>
                    </div>
                    <div style="
                            border-top: 1px solid  #818284;
                            margin-top: 60px;
                            box-shadow: 0px 1px 2px #5e5e5e;
                        "></div>


                    <div style="margin-top:40px;"></div>
                    <div style="word-wrap:break-word;">
                        <p>Dear {{note_receiver_name}},</p>
                        <p>You have received a new CloudeNote from {{organisation_name}}. Click the link above to View CloudeNote.</p>

                        <p>
                            If clicking the link above does not work, copy and paste the following URL in a new browser window:
                            <a href="{{note_public_url}}">{{note_public_url}}</a>
                        </p>

                        <p> Thanks! <br/> Team CloudeNotes   </p>
                    </div>
                    <div style="margin-top:50px;"></div>

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
                        <a style="color: #0D6DDD!important;" href="{{terms_of_service_url}}">Terms of Service</a> |
                        <a style="color: #0D6DDD!important;" href="{{privacy_policy}}">Privacy Policy</a> |
                        <a style="color: #0D6DDD!important;" href="{{about_clodenotes}}">About CloudeNotes</a>
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