<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/20/13
 * Time: 3:38 PM
 */

?>

<section class="main-body-content">
    <div class="container">
        <div class="cloudenote-feature-container">
            <div class="row-fluid">
                <div class="span12">

                    <div class="cloud-note-feature">
                        <!--<h1 class="feature-headline">CLOUDeNOTES Makes Collecting Parental Consent Easy!</h1>-->

                        <?php $this->view('page/home/home_slider'); ?>


                        <div class="registration-bar">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="registration-panel">
                                        <form class="form-inline">
                                            <!-- new style -->
                                                <div class="row-fluid">
                                                    <div class="span3">                                                        
                                                        <h4 class="text-center" style="color:#fff;">Create an Account</h4>                                                       
                                                    </div>
                                                    <div class="span9">
                                                        <div class="row-fluid">
                                                            <div class="span3">
                                                                <div class="input-content">
                                                                    <input type="text" class="" placeholder="Email"> 
                                                                </div>                                                               
                                                                                                                              
                                                            </div>
                                                            <div class="span3 text-center"> 
                                                                <div class="input-content">
                                                                    <input type="password" class="" placeholder="Password">
                                                                </div>                                                         
                                                                
                                                             </div>
                                                            <div class="span3 text-center">                                                        
                                                                <div class="input-content">
                                                                    <select>
                                                                        <option>Select from List</option>
                                                                        <option>WE ARE A SCHOOL</option>
                                                                        <option>WE ARE A SUMMER CAMP</option>
                                                                        <option>WE ARE A SCOUT GROUP</option>
                                                                        <option>WE ARE A SPORTS TEAM</option>
                                                                        <option>I AM A TEACHER</option>
                                                                        <option>I AM A PARENT</option>
                                                                        <option>I AM A STUDENT</option>
                                                                        <option>OTHERS</option>
                                                                    </select> 
                                                                </div>                                                                                                                                                                                            
                                                            </div>
                                                            <div class="span3 text-center">                                                          
                                                                <div class="input-content">
                                                                    <button type="submit" class="btn btn-success">Get Started!</button> 
                                                                </div>                                                           
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            <!-- new style end -->


                                        </form><!-- End of Form -->
                                    </div><!-- End of Registration Panel -->
                                </div><!-- End of Registration column -->
                            </div><!-- End of Registration row-fluid -->
                        </div><!-- End of Registration Bar -->

                    </div><!-- End of cloud-note-feature container -->

                </div><!-- End of bootstrap feature note span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>


        <div class="index-ticker">
            <?php
            $this->view('page/include/count-ticker');
            ?>
        </div>



        <!-- counter-ticker here -->

        <div class="feature-list-container">
            <div class="row-fluid">
                <div class="span12">

                </div><!-- End of Feature List Column -->
            </div><!-- End of Feature List row-fluid -->
        </div>
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->

