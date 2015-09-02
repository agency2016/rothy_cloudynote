<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/25/13
 * Time: 11:01 AM
 */


?>


<section class="main-body-content">
    <div class="container">

        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">
                    <?php $this->view('page/include/page_title', array('page_name' => 'Pricing')); ?>
                </div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>

        <div class="pricing-table-container">
            <?php if( $this->session->flashdata('choose_dwn_pkg') ): ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert">
                            <!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
                            <strong>Warning! </strong><?php echo $this->session->flashdata('choose_dwn_pkg'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row-fluid">
                <div class="span12">
                    <?php $this->view('page/pricing/pricing_details'); ?>
                </div>
            </div>
        </div><!-- End of Pricing Table Container -->

        <div class="plan-details-container">
            <div class="row-fluid">
                <div class="span12">

                    <div class="plan-details-header">
                        <div class="row-fluid">
                            <div class="span12">
                                <h3 class="plan-title">Plan Details</h3>
                            </div>
                        </div>
                    </div>

                    <div class="plan-details">
                        <div class="row-fluid">
                            <?php $this->view('page/pricing/plan_details'); ?>
                        </div>
                    </div>

                    <div class="plan-details-footer">
                        <div class="row-fluid">
                            <!--<div class="span12">
                                <h5 class="plan-details-footer-text">* Monthly payments are available for More than 99 students enrolled - Unlimited CloudeNotes Plan only</h5>
                            </div>-->
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- End of Pricing Table Container -->

        <div class="faq-container">

            <div class="row-fluid">
                <div class="span12">

                    <div class="faq-details-header">
                        <div class="row-fluid">
                            <div class="span12">
                                <h3 class="faq-title">Have some Questions about Pricing?</h3>
                            </div>
                        </div>
                    </div>

                    <div class="faq-details">
                        <div class="row-fluid">
                            <?php $this->view('page/pricing/pricing_question'); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="fees-schedule-container">
            <div class="row-fluid">
                <div class="span12">

                    <div class="fees-schedule-header">
                        <div class="row-fluid">
                            <div class="span12">
                                <h3 id="fees" class="fees-title">Fees Schedule</h3>
                                <h4 class="fees-title">CloudeNotes Subscription Pricing</h4>
                            </div>
                        </div>
                    </div>

                    <div class="fees-schedule-list">
                        <div class="row-fluid">
                            <?php $this->view('page/pricing/fees_schedule'); ?>
                        </div>
                    </div>

                    <div class="payments-schedule-header">
                        <div class="row-fluid">
                            <div class="span12">
                                <h4 class="fees-title">CloudeNotes Service Fees Pricing</h4>
                            </div>
                        </div>
                    </div>

                    <div class="payment-description-container">
                        <div class="row-fluid">
                            <?php $this->view('page/pricing/payment_pricing'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div>
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->

<script type="text/javascript">
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            || location.hostname == this.hostname) {

            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
</script>
