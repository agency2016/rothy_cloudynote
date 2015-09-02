<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/25/13
 * Time: 3:13 PM
 */
?>

<div class="span12">
    <ul class="plan plan-free">
        <li class="plan-name">
            30 Day Free Trial
        </li>
        <li class="span4 offset2 plan-details">
            <strong>Enroll up to 30 Students</strong>
        </li>
        <li class="span4 plan-details">
            <strong>Send up to 10 CloudeNotes</strong>
        </li>
        <li class="span12">
            <strong>You can upgrade at any time to a plan below. </strong>
        </li>
        <li class="span4 offset8">
            <a href="<?php echo base_url('payment/plan/pk1');?>" class="btn btn-large btn-success">Sign up</a>
        </li>
    </ul>
</div><!--end of free trail plan-->

<div class="span12 hero-body" style="margin-left:0px">
    <!--<div class="row-fluid">-->
        <div class="span3 offset3"><p>Select Student Number: </p></div>
        <div class="span4">
            <select id="pricing-select" class="selectpicker" title='Choose one of the following...'>
                <!--<option selected="selected" disabled="disabled">Choose Student Number</option>-->
                <option selected="selected" value="opt1">1 to 99 Students</option>
                <option value="opt2">100 to 250 Students</option>
                <option value="opt3">251 to 500 Students</option>
                <option value="opt4">501 to 750 Students</option>
                <option value="opt5">751 to 1000 Students</option>
                <option value="opt6">1001+ Students</option>
            </select>
        <!--</div>-->
    </div>
</div>

<div id="opt1" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $149.00/Year or $12.42/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll up to 99 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk2');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 149$ plan-->

<div id="opt2" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $269.00/Year or $22.42/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll 100-250 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk3');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 269$ plan-->

<div id="opt3" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $469.00/Year or $39.08/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll 251-500 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk4');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 469$ offer-->

<div id="opt4" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $669.00/Year or $55.75/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll 501-750 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk5');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 669$ plan-->

<div id="opt5" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $869.00/Year or $72.42/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll 751-1000 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk6');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 869$ plan-->

<div id="opt6" class="pricing-plans active">
    <div class="span12">
        <ul class="plan plan-basic">
            <li class="plan-name">
                $1269.00/Year or $105.75/Month
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll 1000+ Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send unlimited CloudeNotes</strong>
            </li>
            <li class="span12">
                <strong>No Set Up Fee. Choose Monthly or Annual billing. You can upgrade at any time.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk7');?>" class="btn btn-large btn-primary">Sign up</a>
            </li>
        </ul>
    </div>
</div><!--end of 1269$ plan-->

<div class="opt7">
    <div class="span12">
        <ul class="plan plan-premium">
            <li class="one-cloudenote">
                SEND 1 CloudeNote For $99.00
            </li>
            <li class="span4 offset2 plan-details">
                <strong>Enroll up to 5000 Students</strong>
            </li>
            <li class="span4 plan-details">
                <strong>Send 1 CloudeNote</strong>
            </li>
            <li class="span12">
                <strong>One off Charge.</strong>
            </li>
            <li class="span4 offset8">
                <a href="<?php echo base_url('payment/plan/pk8');?>" class="btn btn-large btn-warning">Sign up</a>
            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        var selectorOnRefresh = $("#pricing-select").val();
        $('div.pricing-plans').not("#"+selectorOnRefresh).hide();
        $("#pricing-select").change(function() {
            var val = $(this).val();
            $(".pricing-plans").hide();
            $("#" + val).show();
        });
    });
</script>