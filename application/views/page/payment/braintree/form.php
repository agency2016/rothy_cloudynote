<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/11/13
 * Time: 4:53 PM
 */

?>
    <div class="container well" style="background: #fff">
        <!--<div class="pricing-table-container">
            <div class="row-fluid">
                <div class="span4">
                    <ul class="plan plan-basic">
                        <li class="plan-name">
                            Enroll up to 99 Students
                        </li>
                        <li class="plan-price">
                            <strong>Enroll up to 99 Students</strong>
                        </li>
                        <li>
                            <strong>Send Unlimited CloudeNote</strong>
                        </li>
                        <li>
                            <strong>Upgrade Anytime</strong>
                        </li>
                        <li class="price-range">
                            <strong>$149 PER YEAR</strong>
                        </li>
                    </ul>
                </div>
                <div class="span4">
                    <ul class="plan plan-standard featured">
                        <li class="plan-name">
                            More Than 99 Students
                        </li>
                        <li class="plan-price">
                            <strong>Enroll more than 99 Students</strong>
                        </li>
                        <li>
                            <strong>Send Unlimited CloudeNote</strong>
                        </li>
                        <li>
                            <strong>Enter Students Number</strong>
                            <input type="text" id="students-number" >
                        </li>
                        <li class="price-range">
                            <span class="total_price"></span><br>
                            <div class="switch_on_text"><span>Total Price Per Year</span></div>
                            <div class="switch-large has-switch" id="price-switch">
                                <div class="switch-on switch-animate">
                                    <span class="switch-left switch-large">Left</span><label class="switch-large price-toggle-btn"><img src="<?php /*echo base_url('resources/img/slide-arrow.png'); */?>"></label><span class="switch-right switch-large">Right</span>
                                </div>
                            </div>

                            <div class="cb-price-switch">

                            </div>
                            <div class="switch_off_text"><span>Total Price per Student Per Year</span></div>
                        </li>
                    </ul>
                </div>
                <div class="span4">
                    <ul class="plan plan-premium">
                        <li class="plan-name">
                            Send 1 CloudeNote
                        </li>
                        <li class="plan-price">
                            <strong>Enroll up to 5000 Students</strong>
                        </li>
                        <li>
                            <strong>Send 1x CloudeNote</strong>
                        </li>
                        <li>
                            <strong>Upgrade Anytime</strong>
                        </li>
                        <li class="price-range">
                            <strong>$99</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>-->
        <!--<div class="row-fluid">
            <div class="span12 hero-unit">
                <div class="row-fluid">
                    <div class="span4"><p>Choose Your Plan: </p></div>
                    <div class="span4">
                        <select class="selectpicker" title='Choose one of the following...'>
                            <option selected="selected" disabled="disabled">Select a plan</option>
                            <option name="opt1">Enroll up to 99 Students</option>
                            <option name="opt2">More Than 99 Students </option>
                            <option name="opt3">Send 1 CloudeNote</option>
                        </select>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group stu_no_group">
                            <label class="control-label">Enter Student Number</label>
                            <div class="controls">
                                <input class="select_stu_no" type="text"  placeholder="Student Number"  name="student_no"/>
                            </div>
                        </div>
                        <div class="control-group price_group">
                            <label class="control-label">Total Price</label>
                            <div class="controls">
                                <span class="input-group-addon">$</span>
                                <input class="select_price" type="text"  placeholder="price" readonly name="total_price"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label"> Payment Subscription Type</label>
                                <div class="controls radio">
                                    <label class="radio">
                                        <input class="radioval" type="radio" name="subscribe" id="user_role_managing_editor" value="yearly" checked>
                                        Yearly
                                    </label>
                                    <label class="radio">
                                        <input class="radioval" type="radio" name="subscribe" id="user_role_area_editor" value="monthly">
                                        Monthly
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--><!--data-encrypted-name="cvv"--><!--data-encrypted-name="cvv"-->

        <div class="row-fluid">
        <!--$data['errors'] = validation_errors();-->
            <?php if(isset($success)) : ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success!</strong> <?php echo $success; ?>
            </div>
            <?php endif; ?>

            <?php if(isset($trans_id)) : ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success!</strong> <?php echo $trans_id; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($holderName)) : ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success!</strong> <?php echo $holderName; ?>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="POST" id="braintree-payment-form">

                <div class="">
                    <p  class="help-block"> You have selected <?php echo $package_min_member.'-'.$package_max_member; ?> Student Plan <?php echo $package_description; ?><!--<span class="amount"><?php /*echo $amount; */?></span>--> </p> <br>
                    <p>Pay via Credit Card or Bank?</p>
                    <input class="payment" type="radio" name="payment" value="credit"/> Via Credit Card <br/>
                    <input class="payment" type="radio" name="payment" value="bank"/> Via Bank Pay

                    <?php /*if ($recurring_payment == 'Y') : */?><!--
                        <p class="block-inline">Monthly Pay: <input style="margin-top:0px" type="checkbox" id="check" name="recurring_check"></p>
                        <p class="help-block"> Check this for monthly payment. </p>
                    --><?php /*endif; */?>
                </div>
                <div class="accordion" id="">

                </div>

                <div class="accordion" id="accordion2">

                    <div class="accordion-group">

                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#registration">
                                <legend>Login Details</legend>
                            </a>
                        </div>

                        <div id="registration" class="accordion-body collapse in">

                            <div class="accordion-inner">

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Email</label>
                                    <div class="controls">
                                        <input type="email" name="user_email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Password</label>
                                    <div class="controls">
                                        <input type="password" name="user_password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <select name="register_as">
                                            <option value="1">WE ARE A SCHOOL</option>
                                            <option value="2">WE ARE A SUMMER CAMP</option>
                                            <option value="3">WE ARE A SCOUT GROUP</option>
                                            <option value="4">WE ARE A SPORTS TEAM</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                <legend>Registration Details</legend>
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse">
                            <div class="accordion-inner span12">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">First Name</label>
                                            <div class="controls">
                                                <input type="text" name="customer_fname" placeholder="First Name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Last Name</label>
                                            <div class="controls">
                                                <input type="text" name="customer_lname" placeholder="Last Name"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Address Line 1</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Address Line 1" name="customer_email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Address Line 2</label>
                                            <div class="controls">
                                                <input  type="text" placeholder="Address Line 2" name="customer_company"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls">
                                                <input type="text" placeholder="City" name="customer_fax"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">State / Province / Region</label>
                                            <div class="controls">
                                                <input type="text" placeholder="State Province" name="customer_web"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Postl/Zip Code</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Postal code" name="customer_phone"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Your country" name="customer_role"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- endo of customer details-->
                        </div>
                    </div><!-- end of collapse two-->

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                                <legend>Customer Billing Information</legend>
                            </a>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse">
                            <div class="accordion-inner span12">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">First Name</label>
                                            <div class="controls">
                                                <input type="text" name="customer_billing_fname" placeholder="First Name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Last Name</label>
                                            <div class="controls">
                                                <input type="text" name="customer_billing_lname" placeholder="Last Name"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Address Line 1</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Address Line 1" name="customer_billing_company"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Address Line 2</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Address Line 2" name="customer_billing_country" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls">
                                                <input type="text" placeholder="City" name="customer_billing_countryCodeAlpha3" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">State / Province / Region</label>
                                            <div class="controls">
                                                <input type="text" placeholder="State / Province / Region" name="customer_billing_locality"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Postal /Zip Code</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Postal /Zip Code" name="customer_billing_postcode"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Country" name="customer_billing_region"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Street Address</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Street Address" name="customer_billing_streetAddress"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Street Address 2</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Street Address 2" name="customer_billing_streetAddress2"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- endo of customer billing details-->
                        </div>
                    </div><!-- end of collapse three -->

                    <div class="accordion-group" id="credit_card">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                <legend>Credit Card Details</legend>
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-body collapse">
                            <div class="control-group">
                                <label class="control-label">$<?php echo $amount; ?>/Year</label>
                                <div class="controls">
                                    <input type="radio" value="<?php echo $amount; ?>" name="amount"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">$<?php echo number_format ($amount/12, 2, ".", ""); ?>/Month</label>
                                <div class="controls">
                                    <input type="radio" value="<?php echo number_format ($amount/12, 2, ".", ""); ?>" name="amount"/>
                                </div>
                            </div>
                           <!-- <span>
                                <input type="radio" value="<?php /*echo $amount; */?>" name="yearly_price"/>$<?php /*echo $amount; */?>/Year or
                                <input type="radio" value="<?php /*echo $amount/12; */?>" name="monthly_price"/>$<?php /*echo $amount/12; */?>/Month
                            </span>-->
                            <div class="accordion-inner span12">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Card Number</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Card Number" autocomplete="off" name="number"/><!--data-encrypted-name="number"-->
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">CVV</label>
                                        <div class="controls">
                                            <input type="text"  placeholder="CVV" autocomplete="off" name="cvv"/><!--data-encrypted-name="cvv"-->
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Expiration (MM/YYYY)</label>
                                        <div class="controls">
                                            <div class="span2"><input type="text" placeholder="Month" size="2" name="month" /></div> <div class="span3"><input type="text" placeholder="Year" size="4" name="year" /></div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Holder Name</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Card Holder Name" autocomplete="off" name="chname"/> <!--data-encrypted-name="chname"-->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end of credit card details-->
                        </div>
                    </div><!-- end of collaps one -->

                    <div class="accordion-group" id="bank_pay">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsefour">
                                <legend>Pay By Bank Transfer</legend>
                            </a>
                        </div>
                        <div id="collapsefour" class="accordion-body collapse">
                            <div class="accordion-inner span12">
                                <p>Payment Option: $<?php echo $amount; ?> per year</p>
                                <p>Transfer Funds to:</p>
                                <p>Account Name: CloudeNotes</p>
                                <p>Account Number: 94 825 7417           BSB: 082-167</p>
                                <p>Reference: Refer your Organisation Name</p>
                                <p>We will send you an invoice once payment is received. Your account will be activated from now. Please arrange payment within 7 days.</p>
                            </div><!-- endo of customer billing details-->
                        </div>
                    </div><!-- end of collapse four -->

                    <input type="hidden" class="hidden_cost" name="hidden_cost" value=""/><br>
                    By Clicking The Button Below You Agree To our <a href="<?php echo base_url('term-of-service'); ?>">Terms of Service</a>.</span><br><br>
                    <input type="submit" class="btn-large btn-success" id="submit" name="submit" value="Agreed lets proceed"/>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#credit_card").hide();
            $("#bank_pay").hide();

            $(".payment").on('change', function(){
                if ($(this).val() == "credit") {
                    $("#credit_card").show();
                    $("#bank_pay").hide();
                }
                else {
                    $("#bank_pay").show();
                    $("#credit_card").hide();
                }
            });
        });
        $("#check").click(function(){
            var amount = <?php echo $amount; ?>;
            if($('#check').prop('checked')){
                amount = amount/12;
                $('.amount').html(amount.toFixed(2) + ' per month');
            } else {
                $('.amount').html(amount+' per year');
            }
        });
    </script>
    <!--<script src="https://js.braintreegateway.com/v1/braintree.js"></script>-->
    <!--<script src="http://accounts.tao.tw.shuttle.com/assets/js/bootstrap-collapse.js"></script>-->

    <!--<script>

        var braintree = Braintree.create("MIIBCgKCAQEAwW9SLVOc8LJ53QJEtTacXCbaYKoeZHTdJehVdmlxCu7GjpuQE4T6IHVvBD9VThFMqOQsrG3eQ//dX+RbtWaHUr4qtZN8kkQ4kGinNWxRrEeFHqiaaqMX9MrhfO/kzYiWyoR9dvkYqnqxMMqp4SmsqPJsn0bErEOwuD1TMI0JyD8k9ERSpnleCgfUwk0KmwZDcm6A3acUfZmQbjdYjrKGfcDinRgih56OF1CzN2xwCZmDPfZeJZkWPSTl61VsDGTrSw0VzO0hXBqwJb1PpwZehx1gd4jGXsLUNi3gE4MQnkbyc7oBBLxpwNPJC0RtUVNJ6GsUf7o6qayvn7YZj7wG5wIDAQAB");
        braintree.onSubmitEncryptForm('braintree-payment-form');

    </script>-->
