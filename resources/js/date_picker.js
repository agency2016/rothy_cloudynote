/**
 * Created by Sudarshan Biswas on 12/4/13.
 */

var nowTemp = new Date(),
    now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0),
    reply_end_date,
    schedule_date;

jQuery( document ).ready(function( $ ) {

    reply_end_date = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() < schedule_date.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            schedule_date.setValue(newDate);
        }
    }).data('datepicker');

    schedule_date = $('#dpd1').datepicker({
        onRender: function(date) {
            if( date.valueOf() <= now.valueOf() ) {
                return 'disabled';
            } else {
                return '';
            }
        }
    }).on('changeDate', function(ev) {
        if( ev.date.valueOf() > now.valueOf() ) {
            disableSendNote = true;
        } else {
            disableSendNote = false;
        }

        if (ev.date.valueOf() > reply_end_date.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 5);
            reply_end_date.setValue(newDate);
        }
    }).data('datepicker');
});
