<?php
/**
 * Created by PhpStorm.
 * User: tanim_000
 * Date: 3/29/14
 * Time: 5:06 PM
 */
?>

<div class="container">
    <div class="row-fluid dashboard-icon-area">
        <div class="span3 dashboard-icon-bg">
<!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/create-a-note.png'); */?>" alt="View Notes"/>
-->
            <a href="<?php echo base_url('user/parent'); ?>"><i class="fa fa-clipboard fa-5x"></i><br><button type="submit" class="btn btn-large btn-success">View Notes</button></a>
        </div>
        <div class="span3 dashboard-icon-bg">
<!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/notes.png'); */?>" alt="Payments"/><br>
-->
            <a href="<?php echo base_url('user/parentPayment'); ?>"><i class="fa fa-money   fa-5x"></i><br><button type="submit" class="btn btn-large btn-primary">Payments</button></a>
        </div>
        <div class="span3 dashboard-icon-bg">
<!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/class.png'); */?>" alt="Calendar"/><br>
-->
            <a href="<?php echo base_url('user/calendar'); ?>"><i class="fa fa-calendar fa-5x"></i><br><button type="submit" class="btn btn-large btn-primary">Calendar</button></a>
        </div>
        <div class="span3 dashboard-icon-bg">
<!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/teacher.png'); */?>" alt="Profile"/><br>
-->
            <a href="<?php echo base_url('user/parentProfile'); ?>"><i class="fa fa-user fa-5x"></i><br><button type="submit" class="btn btn-large btn-primary">Profile</button></a>
        </div>
    </div>
</div>