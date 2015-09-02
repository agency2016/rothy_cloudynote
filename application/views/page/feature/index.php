<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/26/13
 * Time: 6:19 PM
 */


?>



<section class="main-body-content">
    <div class="container">

        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">
                    <?php $this->view('page/include/page_title', array('page_name' => 'Features')); ?>
                </div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>


        <div class="feature-notes-container">
            <div class="row-fluid">
                <div class="span12">
                    <?php $this->view('page/feature/feature_block'); ?>
                </div>
            </div>
        </div><!-- End of cloud-note-feature container -->


        <div class="feature-page-list-container">
            <div class="row-fluid">
                <div class="span12">
                    <?php $this->view('page/feature/feature_list'); ?>
                </div><!-- End of Feature List Column -->
            </div><!-- End of Feature List row-fluid -->
        </div>

        <div
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->