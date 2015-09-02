

<div class="container">
    <div class="row-fluid">
        <div class="page-header">
            <div class="span4">
                <h3 style="text-align: left; color: #000000"></h3>
            </div>
            <div class="span8">
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
                <div class="pull-right form-inline">
                    <!--<div class="btn-group">
                        <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                        <button class="btn" data-calendar-nav="today">Today</button>
                        <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-warning" data-calendar-view="year">Year</button>
                        <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                        <button class="btn btn-warning" data-calendar-view="week">Week</button>
                        <button class="btn btn-warning" data-calendar-view="day">Day</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span9" style="background: #ffffff; margin-bottom: 50px">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>
<script>




</script>

<script type="text/javascript">
    (function($) {

        "use strict";


        var newDate = new Date(2014,2,2,11,33,12);
        var newDate1 = new Date(2014,2,24,12,33,12);

        var jstime 		= newDate.getTime();
        var jstime1 	= newDate1.getTime();

        var jsonData = [{
            "success": 1,
            "result": [
                {
                    "id": "293",
                    "title": "This is warning class event with very long title to check how it fits to evet in day view",
                    "url": "http://www.example.com/",
                    "class": "event-warning",
                    "start": "1396416792000",
                    "end":   "1396416792000"
                }
            ]
        }];

        //jsonData = JSON.stringify(jsonData);

        var dateString;
        var newDate = new Date();

        // Get the month, day, and year.
        dateString = newDate.getFullYear() + "-";
        dateString += ("0" + (newDate.getMonth() + 1)).slice(-2) + "-";
        dateString += ("0" + (newDate.getDate())).slice(-2);

        var options = {
            events_source: "<?php echo base_url('home/calendar_data'); ?>",
            //events_source: 'http://localhost/codeboxr/projects/cloudenotes/events.json.php',
            //events_source : jsonData,
            view: 'month',
            tmpl_path: 'http://localhost/codeboxr/projects/cloudenotes/resources/tmpls/',
            tmpl_cache: false,
            day : dateString,
            //day: '2013-03-12',


            onAfterEventsLoad: function(events) {
                //alert(events);
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