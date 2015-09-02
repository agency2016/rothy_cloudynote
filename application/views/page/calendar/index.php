<section class="main-content-body" xmlns="http://www.w3.org/1999/html">

<?php
/**
 * Created by PhpStorm.
 * User: Adnan
 * Date: 27/03/14
 * Time: 10:20
 */
if ($login_user_data->user_access_level == 1){
    $this->view('page/dashboard-icon-menu/super-admin-icon');
}elseif ($login_user_data->user_access_level == 5) {
    $this->view('page/dashboard-icon-menu/parent-icon');
}else{
    $this->view('page/dashboard-icon-menu/index');
}
?>

<div class="container">
    <div class="row-fluid">
        <div class="table-area">
            <div class="row-fluid table-area-header">
                <h3>Calendar</h3>
            </div>
            <div class="row-fluid">
                <div class="page-header">
                    <div class="span3 offset1">
                        <h3 style="text-align: left; color: #000000"></h3>
                    </div>
                    <div class="span7 offset1" style="text-align: center; margin-top:12px">
                        <div class="btn-group">
                            <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                            <button class="btn" data-calendar-nav="today">Today</button>
                            <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-warning" data-calendar-view="year">Year</button>
                            <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                            <button class="btn btn-warning" data-calendar-view="week">Week</button>
                            <button class="btn btn-warning" data-calendar-view="day">Day</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span10 offset1" style="background: #ffffff; margin-bottom: 50px">
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {

        "use strict";

        var dateString;
        var newDate = new Date();

        // Get the month, day, and year.
        dateString = newDate.getFullYear() + "-";
        dateString += ("0" + (newDate.getMonth() + 1)).slice(-2) + "-";
        dateString += ("0" + (newDate.getDate())).slice(-2);

        var options = {
            events_source: "<?php echo base_url('user/calendar-data'); ?>",
            view: 'month',
            tmpl_path: '<?php echo base_url('resources/tmpls'); ?>/',
            tmpl_cache: false,
            day : dateString,

            onAfterEventsLoad: function(events) {
                if(!events) {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function(key, val) {
                    $(document.createElement('li'))
                        .html('<a href="' + val.url + '">' + val.title + '</a>')
                        .appendTo(list);
                });
            },
            onAfterViewLoad: function(view) {
                $('.page-header h3').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };

        var calendar = $('#calendar').calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function(){
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function(){
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function(){
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
            //e.preventDefault();
            //e.stopPropagation();
        });
    }(jQuery));
</script>
    </section>
