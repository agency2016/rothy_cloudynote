<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 4:14 PM
 */

?>

            <footer id="footer" class="footer">
                <div class="container">
                    <div class="footer-menu">
                        <div class="row-fluid">
                            <div class="span7">
                            	<div class="row-fluid">
                            		<div class="span4" >
                            			<div class="index-clogo">
                            			    <a href="#"><img src="<?php echo base_url('resources/img/cloudenote_footer_logo.png'); ?>" /></a><!-- End of footer logo -->
                            			</div><!-- End of footer logo div -->                           			
                            		</div>                            		
                            		<div class="span8" >
                            			<div class="index-clogo" style="padding-top:10px;">                                
                            			    <div class="cb_navigation">
                            			   		<ul class="" style="display:block;">
                            			   		    <li class="login_signup_group" style="display:inline;">
                            			   		        <a href="<?php echo base_url('refer-a-friend'); ?>" class="login_signup_btn"><button class="btn btn-primary">Refer A Friend</button></a>
                            			   		        <a href="<?php echo base_url('save-paper'); ?>" class="login_signup_btn"><button class="btn btn-success"> Save Paper Ticker</button></a>
                            			   		        <!-- <a href="#" class="login_signup_btn"><button class="btn btn-primary">Plant-A-Tree</button></a> -->
                            			   		    </li>
                            			   		</ul><!-- End of navigation -->
                            			    </div><!-- End of menu div -->
                            			</div>
                            		</div>
                            	</div>                              
                            </div>
                            <div class="span5 text-center">
                                <div class="cb_navigation cb_newnav text-center" >
                                    <ul class="text-center " style="display:block;">
                                        <li>
                                            <a href="<?php echo base_url('about-us');?>">About Us</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('term-of-service');?>">Terms of Service</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('privacy-policy');?>">Privacy Policy</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('contact-us/'); ?>">Contact Us</a>
                                        </li>
                                    </ul><!-- End of navigation -->
                                </div><!-- End of menu div -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container" >                   
                        <div class="row-fluid">
                            <div class="span6">
                             <p class="index-clogo" style="font-size:13px; color:#0D6DDD;">Copyright  &copy; 2014 CloudeNotes ABN 79 142 676 819  </p>   
                               
                            </div>
                            <div class="span6" >
                              <p class="text-center" style="font-size:13px; color:#0D6DDD;">CloudeNotes™ is a registered Trademark. All rights reserved. Proudly made in Australia</p>   
                            </div>
                        </div>                  
                </div>
            </footer>

        <!-- Load stylesheet -->
    <?php foreach($codeboxr_inject_css_after_footer as $key => $css_file_name): ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/css/'.$css_file_name.'.css');?>">
    <?php endforeach; ?>

        <!-- Load Javascript -->
    <?php foreach($codeboxr_inject_js_after_footer as $key => $js_file_name): ?>
        <script type="text/javascript" src="<?php echo base_url('resources/js/'.$js_file_name.'.js');?>"></script>
    <?php endforeach; ?>