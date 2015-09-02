<section class="main-body-content">
    <div class="container">
        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">                 
                    <div class="page-title">
                        <h1 class="text-center">Refer A Friend</h1>
                    </div><!-- End of Page Title -->                
                </div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>

        <div class="contact-us-container"> 
            <div class="row-fluid">
                <div class="span12">              
                    <div class="about-content clearfix" style="padding:20px;">

                        <?php if(isset($error)): foreach($error as $error) : ?>
                            <div class="alert alert-error alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Oops!</strong> <?php echo $error; ?>
                            </div>
                        <?php endforeach; endif; ?>
                        <?php if($this->session->flashdata('success')) : ?>
                        <?php echo $this->session->flashdata('success'); ?>
                        <?php endif; ?>

                        <p style="text-align:justify; text-justify:inter-word;">We are so excited about CloudeNotes  and are sure its going to help all those in the care and
                            development of our kids. We hope to make it an easy decision for any Organization to implement our
                            Application. If you know of a School, Sports Club or even another Parent who haven't heard of us – be
                            sure to send them a CloudeNote Referral Notification.</p>

                        <br/>

                        <p>Fill in the form below to refer your friend</p><br/>

                        <form action="<?php echo base_url('refer-a-friend'); ?>" class="form-horizontal" method="post">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Your Name</label>
                                    <div class="controls">
                                        <input type="text" name="name" value="<?php echo set_value('name'); ?>" placeholder="Enter Your Name">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Your Email</label>
                                    <div class="controls">
                                        <input type="email" name="from" value="<?php echo set_value('from'); ?>" placeholder="Enter Your Email">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Your Friends Name</label>
                                    <div class="controls">
                                        <input type="text" name="fname" value="<?php echo set_value('fname'); ?>" placeholder="Enter Your Friends Name">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Your Friends Email</label>
                                    <div class="controls">
                                        <input type="email" name="to" value="<?php echo set_value('to'); ?>" placeholder="Enter Your Friends Email">
                                    </div>
                                </div>
                            </div>
                            <textarea style="width: 99%;height: 250px;" id="refer-friend" placeholder="Enter text ..." name="message" disabled>
                                Dear [ Your Friends Name ],

                                CloudeNotes is a new Web Application designed to replace Permission Notes. It allows you to E –sign an online
                                document which is far better way to manage this important process involving our kids.

                                This note is viewable online and is the sort of form that could be created using their easy drag and drop form
                                builder. CloudeNotes will also allow you to collect payment, collect data and importantly keep records that are
                                easily accessed through your Dashboard.

                                Regards
                                [Your Name]
                            </textarea><br/><br/>

                            <input type="submit" class="btn btn-success" value="Refer To Friend"/>
                        </form>


                

                    </div> <!-- span einner end -->              
                </div> <!-- span 12 end -->
            </div> 
        </div><!-- End of Contact Us form Container -->
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->


