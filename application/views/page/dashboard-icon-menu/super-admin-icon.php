<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 5/7/14
 * Time: 1:01 PM
 */
?>

<div class="container">
    <div class="row-fluid dashboard-icon-area">
        <div class="span3 dashboard-icon-bg">
            <a href="<?php echo base_url('user/parent-student-view'); ?>">
                <i class="fa fa-users fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-success">Parent/Student Registration</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <a href="<?php echo base_url('user/institute-view'); ?>">
                <i class="fa fa-building-o fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Institute Registration</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <a href="<?php echo base_url('dashboard/activity'); ?>">
                <i class="fa fa-bar-chart-o fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Activity Log</button>
            </a>
        </div>
        <div class="span3 dashboard-icon-bg">
            <a href="<?php echo base_url('user/calendar'); ?>">
                <i class="fa fa-calendar fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Calendar</button>
            </a>
        </div>
    </div>
    <div class="row-fluid dashboard-icon-area">
        <div class="span3 dashboard-icon-bg">
            <a href="<?php echo base_url('dashboard'); ?>">
                <i class="fa fa-money fa-5x"></i><br>
                <button type="submit" class="btn btn-large btn-primary">Financial Statistics</button>
            </a>
        </div>
    </div>
</div>