
<section class="main-body-content">
    <div class="container">

        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">                 
			        <div class="page-title">
			            <h1>Contact Us</h1>
			        </div><!-- End of Page Title -->                
        		</div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>      
        <div class="contact-us-container">
        	<div class="row-fluid">
        		<div class="span12">
        			<div class="row-fluid clearfix">
						<div class="span12">
							<div class="new-contact-title">
								<p><?php  echo $this->session->flashdata('success_message'); ?></p>
								<p><?php  echo $this->session->flashdata('failure_message'); ?></p>
								<p>We'd love to hear from you! Please let us  know your role at your school so we can help you better.</p>
							</div>
						</div>						
        			</div><!-- title row-fluid end --> 
        			<div class="row-fluid clearfix">
        				<div class="span11 offset1">
        					<div class="contact-form-new">
        						<form id="contact-form"  name="contact_form"  class="form-horizontal" method="post" action="<?php echo base_url('home/email_admin') ?>" >
        							<div class="control-group">									    	
										<div class="controls">
										   	<input name="inputname" class="input-lg-new input-xlarge span7" type="text" id="inputname" placeholder="Name">
										</div>
									</div>
								    <div class="control-group">									    
									    <div class="controls">
									    	<input name="inputmail" class="input-lg-new input-xlarge span7" type="email" id="inputmail" placeholder="Email">
									    </div>
								    </div>
								    <div class="control-group">									    
									    <div class="controls ">
										    <select name="email_subject" class="span7 contact-form-select" >									    		
												<option selected disabled style="color:#ccc;">Select one</option>
												<option value="Principal">Principal</option>
												<option value="Teacher" >Teacher</option>
												<option value="Coach" >Coach</option>
												<option value="Administrator" >Administrator</option>
												<option value="Parent">Parent</option>
												<option value="P&C/PTA Leader" >P&C/PTA Leader</option>
												<option value="Press">Press</option>												
												<option value="Other">Other</option>
											</select>
									    </div>
								    </div>
								    <div class="control-group">									    
									    <div class="controls">									    	
									    	<textarea id="message" class="input-lg-new span7 input-xxlarge input-lg  " rows="6" placeholder="Message..." name="email_message" value=""></textarea>
									    </div>									    
									</div>
									<div class="control-group">
									    <div class="controls">									    	
									    	<button type="submit" class="btn btn-large"><i class="fa fa-envelope"></i> <strong>Send Message</strong></button>
									    </div>                                        
                                    </div>                                    							
        						</form>        						
        					</div><!-- contact-us-form end     -->
        					<div class="row-fluid">
        						<div class="span10 offset2">
        							<div class="feedback">
        								<p><i class="fa fa-phone-square fa-2x"></i>  <span>  Need to speak to us, give us a call on <a href="#">+ 612 8011 4568</a></span></p>
        								<p><i class="fa fa-envelope fa-2x"></i>  <span>  Email us at  <a href="#">info@cloudenotes.com</a></span></p>
        								<p><i class="fa fa-twitter-square fa-2x"></i> <span>  <a href="#">Tweet Us.</a> We love to hear suggestions or feedback on CloudeNotes.</span></p>
        								<p><i class="fa fa-suitcase fa-2x"></i> <span> Please email us for Media Kit using form above or  <a href="#">press@cloudenotes.com</a> </span></p>
        							</div>
        						</div>        							
        					</div>    					
        				</div><!-- span110 offset2 end -->
        			</div><!-- row of span110 offset2 end -->        			
        		</div> <!-- span12 end     -->  		
        	</div> <!-- row-fluid end -->
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
            inputmail: {
                required: true,
                email: true
            },
            user_login_password: {
                minlength: 3,
                required: true
            },
            email_subject: {
               
                required: true
            },
             inputname: {
                minlength: 3,
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