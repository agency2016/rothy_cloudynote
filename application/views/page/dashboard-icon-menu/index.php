<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 27/03/14
 * Time: 10:59
 */

?>
<div class="container">
    <div class="row-fluid dashboard-icon-area">
        <div class="span3 dashboard-icon-bg">

            <!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/create-a-note.png'); */?>" alt="Create a Note"/>-->
            <a href="<?php echo base_url('notes/new'); ?>">
                <i class="fa fa-clipboard fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-success">Create a Note</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/notes.png'); */?>" alt="View Notes"/>-->
            <a href="<?php echo base_url('notes/page'); ?>">
                <i class="fa fa-crosshairs fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">View Notes</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/class.png'); */?>" alt="Calendar"/><br>-->
            <a href="<?php echo base_url('user/calendar'); ?>">
                <i class="fa fa-calendar fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Calendar</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <!--            <img src="<?php /*echo base_url('resources/img/dashboard-icons/teacher.png'); */?>" alt="Student & Staff"/>-->
            <a href="<?php echo base_url('user/students'); ?>">
                <i class="fa fa-users fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Student &amp; Staff</button>
            </a>
        </div>
    </div>
</div>