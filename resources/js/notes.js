/**
 * Created by Sudarshan Biswas on 12/11/13.
 */


var disableSendNote = false,
    cnote_response_info = {};

jQuery(document).ready(function ($) {

    var removeIntent = false,
        isNotDropped = true,
        isReceiveItem = false,
        sortableItemIndex = 0,
        group_id_counter = cnote_info.last_group_id,
        initial_item_id_counter = 1,

        group_id,
        data_type,
        caller_name,
        note_status = 1,
        tab_counter = 1,
        note_form = $('form#new-note'),
        preview_tab = $('#tab_preview_note'),
        preview_tab_fieldset = $('#tab-preview-note-fieldset'),
        preview_note_wizard_tab_counter = 0,
        preview_note_wizard = $('#preview-note-wizard');


    /*$('#previous-note').hasClass('disabled',function(){
     $('#previous-note').hide();
     });*/

// added new
    var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
    var dg = ['Zero', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth'];
    var tn = ['Tenth', 'Eleventh', 'Twelveth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth'];
    var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    function toWords(s) {
        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s)) return 'not a number';
        var x = s.indexOf('.');
        if (x == -1) x = s.length;
        if (x > 15) return 'too big';
        var n = s.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }

    var create_json_for_note = function (note_id) {
        preview_note_wizard_tab_counter = 0;
        var hiddenInput = $('#new-note').find('div.hidden-info');

        var serializedData = $('#new-note').find('input[type="hidden"]').serializeArray();

        if (Object.keys(cnote_info).length > 2 && hiddenInput.length == 0) {

            return;
        }

        if (hiddenInput.length == 0) {
            group_id_counter = 1;
            cnote_info = {};
            cnote_info.note_id = note_id;
            cnote_info.last_group_id = group_id_counter;
        }

        $(hiddenInput).each(function (index, currentItem) {
            //console.log(currentItem);
            data_type = $(currentItem).data('type');
            group_id = $(currentItem).data('group-id');

            cnote_info[index] = {};
            cnote_info[index][data_type] = {};
            cnote_info[index][data_type]['group_id'] = group_id;
            cnote_info[index][data_type]['label_name'] = $(this).find('input[data-id="' + data_type + '-label-' + group_id + '"]').val();

            if (data_type == 'checkbox' || data_type == 'radio' || data_type == 'select' || data_type == 'dropdown') {
                cnote_info[index][data_type]['last_item_id'] = $('.last-item-id[data-group-id="' + group_id + '"]').data('last-item-id');
                caller_name = $(currentItem).find('input[data-caller-name="cnote_form_info[' + group_id + '][' + data_type + '][total_items]"]');
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();
                cnote_info[index][data_type]['total_items'] = {};
                $(caller_name).each(function (caller_index, caller_element) {
                    var single_item = {},
                        item_id = $(caller_element).data('item-id');
                    single_item['item_id'] = item_id;
                    single_item['label_name'] = $(caller_element).val();
                    single_item['item_checked'] = $('input[data-id="' + data_type + '-chkd-' + group_id + item_id + '"]').val();
                    //console.log(cnote_info[index][data_type]['total_items'].length);
                    cnote_info[index][data_type]['total_items'][Object.keys(cnote_info[index][data_type]['total_items']).length] = single_item;
                });
            }
            else if (data_type == 'textbox') {
                cnote_info[index][data_type]['text_default_value'] = $(this).find('input[data-id="' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();

            } else if (data_type == 'number') {
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();

                cnote_info[index][data_type]['number_default_value'] = $(this).find('input[data-id="' + data_type + '-number-' + group_id + '"]').val();
                console.log( cnote_info);
            } else if (data_type == 'email') {
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();

                cnote_info[index][data_type]['email_default_value'] = $(this).find('input[data-id="' + data_type + '-email-' + group_id + '"]').val();
            } else if (data_type == 'date-of-event') {
                cnote_info[index][data_type]['event_date'] = $(this).find('input[data-id="' + data_type + '-text-' + group_id + '"]').val();
            } else if (data_type == 'reply-by-date') {
                cnote_info[index][data_type]['reply_by_default_date'] = $(this).find('input[data-id="' + data_type + '-text-' + group_id + '"]').val();
            } else if (data_type == 'reminder-date') {
                cnote_info[index][data_type]['reminder_default_date'] = $(this).find('input[data-id="' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['reminder_details'] = $(this).find('input[data-id="' + data_type + '-paragraph-' + group_id + '"]').val();

            } else if (data_type == 'ordinary-date') {
                cnote_info[index][data_type]['ordinary_default_date'] = $(this).find('input[data-id="' + data_type + '-text-' + group_id + '"]').val();
            } else if (data_type == 'time-of-event') {
                cnote_info[index][data_type]['event_start_time'] = $(this).find('input[data-id="start-' + data_type + '-' + group_id + '"]').val();
                cnote_info[index][data_type]['event_end_time'] = $(this).find('input[data-id="end-' + data_type + '-' + group_id + '"]').val();
            } else if (data_type == 'ordinary-time') {
                cnote_info[index][data_type]['ordinary_start_time'] = $(this).find('input[data-id="start-' + data_type + '-' + group_id + '"]').val();
                cnote_info[index][data_type]['ordinary_end_time'] = $(this).find('input[data-id="end-' + data_type + '-' + group_id + '"]').val();

            } else if (data_type == 'address-box') {
                cnote_info[index][data_type]['address'] = $(this).find('input[data-id="address-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['street'] = $(this).find('input[data-id="street-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['city'] = $(this).find('input[data-id="city-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['state'] = $(this).find('input[data-id="state-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['postalcode'] = $(this).find('input[data-id="postalcode-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['country'] = $(this).find('input[data-id="country-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();

            } else if (data_type == 'payment-due') {
                //console.log($(this).find('input[data-id="dollar-' + data_type + '-text-' + group_id + '"]').val());
                // cnote_info[index][data_type]['default_dollar_value'] = $(this).find('input[data-id="dollar-' + data_type + '-text-' + group_id + '"]').val();
                //  cnote_info[index][data_type]['default_cent_value'] = $(this).find('input[data-id="cent-' + data_type + '-text-' + group_id + '"]').val();
                var firstitem_id =1;
                cnote_info[index][data_type]['last_item_id'] = $('.last-item-id[data-group-id="' + group_id + '"]').data('last-item-id');
                caller_name = $(currentItem).find('input[data-caller-name="cnote_form_info[' + group_id + '][' + data_type + '][total_items]"]');
                cnote_info[index][data_type]['total'] = $(this).find('input[data-id="' + data_type + '-total-payment-' + group_id + '"]').val();
                cnote_info[index][data_type]['payment_type'] = $(this).find('input[data-id="payment-type-' + data_type + '-text-' + group_id + firstitem_id+'"]').val();
                cnote_info[index][data_type]['total_items'] = {};
                //  console.log(caller_name);

                $(caller_name).each(function (caller_index, caller_element) {
                    var single_item = {},
                        item_id = $(caller_element).data('item-id');
                    single_item['item_id'] = item_id;
                    single_item['label_name'] = $(caller_element).val();
                    single_item['dollar'] = $('input[data-id="dollar-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    single_item['cent'] = $('input[data-id="cent-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    single_item['required'] = $('input[data-id="payment-required-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    single_item['quantity'] = $('input[data-id="payment-quantity-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    //console.log(cnote_info[index][data_type]['total_items'].length);
                    cnote_info[index][data_type]['total_items'][Object.keys(cnote_info[index][data_type]['total_items']).length] = single_item;
                });
                console.log(cnote_info);
            }
            else if (data_type == 'pagename') {
                cnote_info[index][data_type]['pagename'] = $(this).find('input[data-id="' + data_type + '-pagename-' + group_id + '"]').val();
            }
            else if (data_type == 'sectionbreak') {
                cnote_info[index][data_type]['sectionbreak'] = $(this).find('input[data-id="' + data_type + '-sectionbreak-' + group_id + '"]').val();
            }
            else if (data_type == 'remark') {
                cnote_info[index][data_type]['remark'] = $(this).find('input[data-id="' + data_type + '-remark-' + group_id + '"]').val();
            }
            else if (data_type == 'paragraph') {

                cnote_info[index][data_type]['paragraph'] = $(this).find('input[data-id="' + data_type + '-paragraph-' + group_id + '"]').val();
            }
            else if (data_type == 'phone') {
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();
                cnote_info[index][data_type]['phone'] = $(this).find('input[data-id="' + data_type + '-phone-' + group_id + '"]').val();
            }
            else if (data_type == 'name') {
                cnote_info[index][data_type]['required'] = $(this).find('input[data-id="' + data_type + '-required-' + group_id + '"]').val();
                cnote_info[index][data_type]['first_name'] = $(this).find('input[data-id="' + data_type + '-first-name-' + group_id + '"]').val();
                cnote_info[index][data_type]['last_name'] = $(this).find('input[data-id="' + data_type + '-last-name-' + group_id + '"]').val();
            }
            else if (data_type == 'pagebreak') {
                cnote_info[index][data_type]['pagebreak'] = $(this).find('input[data-id="' + data_type + '-pagename-' + group_id + '"]').val();
                preview_note_wizard_tab_counter++;
            }
            else if (data_type == 'signature') {
                cnote_info[index][data_type]['text'] = $(this).find('input[data-id="hidden-' + data_type + '-text-' + group_id + '"]').val();
                cnote_info[index][data_type]['firstname'] = $(this).find('input[data-id="hidden-' + data_type + '-firstname-' + group_id + '"]').val();
                cnote_info[index][data_type]['lastname'] = $(this).find('input[data-id="hidden-' + data_type + '-lastname-' + group_id + '"]').val();
                cnote_info[index][data_type]['consent'] = $(this).find('input[data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val();
                cnote_info[index][data_type]['nonconsent'] = $(this).find('input[data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val();
            }
            else if (data_type == 'sign') {
                cnote_info[index][data_type]['last_item_id'] = 3;
                caller_name = $(currentItem).find('input[data-caller-name="cnote_form_info[' + group_id + '][' + data_type + ']"]');

                cnote_info[index][data_type]['total_items'] = {};
                $(caller_name).each(function (caller_index, caller_element) {
                    var single_item = {},
                        item_id = $(caller_element).data('item-id');
                    single_item['item_id'] = item_id;
                    single_item['label_name'] = $(caller_element).val();
                    cnote_info[index][data_type]['total_items'][Object.keys(cnote_info[index][data_type]['total_items']).length] = single_item;
                });


            }
        });
    };


    var create_json_for_response = function (note_id) {

        var hiddenInput = $('#response-form').find('div.hidden-info');

        //var serializedData = $('#new-note').find('input[type="hidden"]').serializeArray();

        if (hiddenInput.length == 0) {
            return;
        }

        $(hiddenInput).each(function (index, currentItem) {
            //console.log(currentItem);
            data_type = $(currentItem).data('type');
            group_id = $(currentItem).data('group-id');

            cnote_response_info[index] = {};
            cnote_response_info[index][data_type] = {};
            cnote_response_info[index][data_type]['group_id'] = group_id;

            if (data_type == 'checkbox' || data_type == 'radio' || data_type == 'select' || data_type == 'dropdown') {
                cnote_response_info[index][data_type]['total_items'] = {};
                caller_name = $(currentItem).find('input[data-caller-name="cnote_form_info[' + group_id + '][' + data_type + '][total_items]"]');
                $(caller_name).each(function (caller_index, caller_element) {
                    var single_item = {},
                        item_id = $(caller_element).data('item-id');
                    single_item['item_id'] = item_id;
                    single_item['item_checked'] = $('input[data-id="' + data_type + '-chkd-' + group_id + item_id + '"]').val();
                    cnote_response_info[index][data_type]['total_items'][Object.keys(cnote_response_info[index][data_type]['total_items']).length] = single_item;

                });
            }
            else if (data_type == 'payment-due') {
                cnote_response_info[index][data_type]['total'] = $(this).find('input[data-id="' + data_type + '-total-payment-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['total_items'] = {};
                caller_name = $(currentItem).find('input[data-caller-name="cnote_form_info[' + group_id + '][' + data_type + '][total_items]"]');
                $(caller_name).each(function (caller_index, caller_element) {
                    var single_item = {},
                        item_id = $(caller_element).data('item-id');
                    single_item['item_id'] = item_id;
                    single_item['required'] = $('input[data-id="payment-required-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    single_item['quantity'] = $('input[data-id="payment-quantity-' + data_type + '-text-' + group_id + item_id + '"]').val();
                    cnote_response_info[index][data_type]['total_items'][Object.keys(cnote_response_info[index][data_type]['total_items']).length] = single_item;

                });
                console.log(cnote_response_info[index][data_type]['total']);
            }
            else if (data_type == 'address-box') {

                cnote_response_info[index][data_type]['address'] = $(this).find('input[data-id="address-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['street'] = $(this).find('input[data-id="street-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['city'] = $(this).find('input[data-id="city-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['state'] = $(this).find('input[data-id="state-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['postalcode'] = $(this).find('input[data-id="postalcode-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['country'] = $(this).find('input[data-id="country-' + data_type + '-text-' + group_id + '"]').val();
            }

            else if (data_type == 'remark') {
                cnote_response_info[index][data_type]['remark'] = $(this).find('input[data-id="' + data_type + '-remark-' + group_id + '"]').val();
            }
            else if (data_type == 'phone') {
                cnote_response_info[index][data_type]['phone'] = $(this).find('input[data-id="' + data_type + '-phone-' + group_id + '"]').val();
            }
            else if (data_type == 'name') {
                cnote_response_info[index][data_type]['first_name'] = $(this).find('input[data-id="' + data_type + '-first-name-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['last_name'] = $(this).find('input[data-id="' + data_type + '-last-name-' + group_id + '"]').val();
            }
            else if (data_type == 'number') {
                cnote_response_info[index][data_type]['number_default_value'] = $(this).find('input[data-id="' + data_type + '-number-' + group_id + '"]').val();
            }
            else if (data_type == 'email') {
                cnote_response_info[index][data_type]['email_default_value'] = $(this).find('input[data-id="' + data_type + '-email-' + group_id + '"]').val();
            }
            else if (data_type == 'signature') {
                cnote_response_info[index][data_type]['text'] = $(this).find('input[data-id="hidden-' + data_type + '-text-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['firstname'] = $(this).find('input[data-id="hidden-' + data_type + '-firstname-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['lastname'] = $(this).find('input[data-id="hidden-' + data_type + '-lastname-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['consent'] = $(this).find('input[data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val();
                cnote_response_info[index][data_type]['nonconsent'] = $(this).find('input[data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val();
            }

        });
    };

    //this function was made for wizard in wizard
    /*var create_wizard_for_note_preview = function() {
        console.log(preview_note_wizard_tab_counter);
        var preview_wizard_form = [];
        preview_wizard_form.push( draggableItem.preview_note_wizard_start );
        preview_wizard_form.push( draggableItem.preview_note_wizard_tabbable_ul_start );
        for(var i = 1; i<= (preview_note_wizard_tab_counter+1); i++ ) {
            preview_wizard_form.push(
                draggableItem
                    .preview_note_wizard_tabbable_li
                    .replace(/{tab_counter}/g, i)
            );
        }
        preview_wizard_form.push( draggableItem.preview_note_wizard_tabbable_ul_end );
        preview_wizard_form.push( draggableItem.preview_note_wizard_tab_content_start );
        for(var i = 1; i<= (preview_note_wizard_tab_counter+1); i++ ) {
            preview_wizard_form.push(
                draggableItem
                    .preview_note_wizard_tab_div
                    .replace(/{tab_counter}/g, i)
            );
        }
        preview_wizard_form.push( draggableItem.preview_note_wizard_tab_content_end );
        preview_wizard_form.push( draggableItem.preview_note_wizard_end );
        console.log(preview_wizard_form.join( '' ));
        console.log(preview_tab.children( 'fieldset.preview-wizard-container'));
        preview_tab.children( 'fieldset.preview-wizard-container').html( preview_wizard_form.join( '' ) );
    }*/

    var render_preview_form = function (cnote_info, val_note_name) {
        var preview_form = [],
            input_type,
            chkdStr,
            have_page_break = false;
        // console.log('i am in preview');
        preview_form.push(draggableItem.preview_form_start);
        preview_form.push(draggableItem.preview_form_note_title.replace(/{note_title}/g, val_note_name));

        


        $.each(cnote_info, function (index, item) {
            if (typeof item === 'object') {
                input_type = Object.keys(item).toString();
                //console.log(input_type) ; 
                switch (input_type) {

                    case 'checkbox':
                        //console.log(item[input_type]);
                        if (item[input_type].hasOwnProperty('total_items')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name )
                                );
                            }


                            $.each(item[input_type].total_items, function (item_index, list_item) {


                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_checkbox_radio_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;


                    case 'textbox':
                        //
                        //  console.log(preview_form);
                        if (item[input_type].hasOwnProperty('text_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push (
                                draggableItem
                                    .preview_text_default_value_item
                                    .replace(/{text_default_value}/g, item[input_type].text_default_value)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'number':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('number_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                           if(item[input_type].required == "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_number_required_default_value_item
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_number_default_value_item
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                );
                          }




                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'email':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('email_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );

                            if(item[input_type].required == "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_email_required_default_value_item
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_email_default_value_item
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                );
                            }

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'date-of-event':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('event_date')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_event_date_item
                                    .replace(/{event_date}/g, item[input_type].event_date)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;

                    case 'phone':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('phone')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );

                            if(item[input_type].required == "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_phone_required_default_value_item
                                        .replace(/{phone}/g, item[input_type].phone)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_phone_default_value_item
                                        .replace(/{phone}/g, item[input_type].phone)
                                );
                            }


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'name':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('first_name')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            preview_form.push(
                                draggableItem
                                    .preview_name_default_value_item
                                    .replace(/{first_name}/g, item[input_type].first_name)
                                    .replace(/{last_name}/g, item[input_type].last_name)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'paragraph':
                        // console.log(preview_form);
                        if (item[input_type].hasOwnProperty('paragraph')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_paragraph_default_value_item
                                    .replace(/{paragraph}/g, item[input_type].paragraph)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'pagename':
                        // console.log('hello');

                        preview_form.push(
                            draggableItem
                                .preview_pagename_default_value_item
                                .replace(/{pagename}/g, item[input_type].pagename)
                        );

                        break;
                    case 'sectionbreak':

                        preview_form.push(
                            draggableItem
                                .preview_sectionbreak_default_value_item
                                .replace(/{sectionbreak}/g, item[input_type].sectionbreak)
                        );

                        break;
                    case 'pagebreak':
                        preview_form.push(
                            draggableItem
                                .preview_pagebreak_default_value_item
                                .replace(/{pagebreak}/g, item[input_type].pagebreak)
                                .replace(/{group_id}/g, item[input_type].group_id)
                        );
                        break;
                    case 'remark':
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_remark_default_value_item
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                                .replace(/{remark}/g, item[input_type].remark)
                        );

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'signature':
                        console.log(item[input_type].label_name);
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_control_signature_item
                                .replace(/{text}/g, item[input_type].text)
                                .replace(/{firstname}/g, item[input_type].firstname)
                                .replace(/{lastname}/g, item[input_type].lastname)
                                .replace(/{group_id}/g, item[input_type].group_id)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;

                    case 'radio':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            //// console.log(item[input_type]);
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                // console.log(draggableItem.preview_control_checkbox_radio_item);
                                // console.log(list_item.item_checked);
                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_checkbox_radio_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'dropdown':
                        if (item[input_type].hasOwnProperty('total_items')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            preview_form.push(
                                draggableItem
                                    .preview_control_dropdown_sitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{item_type}/g, input_type)

                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    var selected = 'selected';
                                    chkdStr = 'selected="' + selected + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_dropdown_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/selected="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                );
                            });
                            preview_form.push(
                                draggableItem
                                    .preview_control_dropdown_eitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'sign':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            //console.log(item[input_type]);
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                //  console.log(list_item.item_id)
                                if (list_item.item_id == '1') {
                                    preview_form.push(
                                        draggableItem
                                            .preview_control_sign_pic
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                    );
                                }
                                else {
                                    preview_form.push(
                                        draggableItem
                                            .preview_control_sign_item
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                    );
                                }

                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'ordinary-date':
                        //console.log(item);
                        if (item[input_type].hasOwnProperty('ordinary_default_date')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_default_date
                                    .replace(/{ordinary_default_date}/g, item[input_type].ordinary_default_date)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;

                    case 'time-of-event':
                        //console.log(item);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        if (item[input_type].event_start_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_event_start_time_item
                                    .replace(/{event_start_time}/g, item[input_type].event_start_time)
                            );
                        }
                        if (item[input_type].event_end_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_event_end_time_item
                                    .replace(/{event_end_time}/g, item[input_type].event_end_time)
                            );
                        }

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'ordinary-time':
                        // console.log(item);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        if (item[input_type].ordinary_start_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_start_time_item
                                    .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)
                            );
                        }
                        if (item[input_type].ordinary_end_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_end_time_item
                                    .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)
                            );
                        }

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;

                    case 'address-box':
                        // console.log(item);

                        if (item[input_type].required =='required'){
                            preview_form.push(
                                draggableItem
                                    .preview_control_required_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                        }
                        else{
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                        }
                        preview_form.push(
                            draggableItem
                                .preview_address_item
                                .replace(/{address_1}/g, item[input_type].address)
                                .replace(/{address_2}/g, item[input_type].street)
                                .replace(/{address_3}/g, item[input_type].city)
                                .replace(/{address_4}/g, item[input_type].state)
                                .replace(/{address_5}/g, item[input_type].postalcode)
                                .replace(/{address_6}/g, item[input_type].country)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'reply-by-date':
                        //console.log(preview_form);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_reply_by_date_item
                                .replace(/{reply_by_default_date}/g, item[input_type].reply_by_default_date)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    /*case 'reminder-date':
                        //console.log(preview_form);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_reminder_date_item
                                .replace(/{reminder_default_date}/g, item[input_type].reminder_default_date)
                                .replace(/{reminder_details}/g, item[input_type].reminder_details)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);*/

                        break;
                    case 'payment-due':
                        // console.log(item);
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        $.each(item[input_type].total_items, function (item_index, list_item) {
                            if (list_item.required == "required") {
                                is_checked = 'checked="checked"';
                            }
                            else {
                                is_checked = '';
                            }
                           if(item[input_type].payment_type =="variable"){
                               if (list_item.required == "required") {
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_required
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );

                               }else{
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }

                           }else{
                               if (list_item.required == "required") {
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_first_required
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }else{
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_first
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }

                           }

                        });
                        preview_form.push(
                            draggableItem
                                .preview_payment_due_total
                                .replace(/{total}/g, item[input_type].total)

                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;


                    default :
                        break;
                }

            }
        });

        preview_form.push(draggableItem.preview_form_end);
        preview_tab.children( 'div.well').html( preview_form.join( '' ) );
    };

    var have_page_break_in_note = function(cnote_info) {
        var pagebreak = false;
        $.each(cnote_info, function (index, item) {
            if (typeof item === 'object') {
                input_type = Object.keys(item).toString();
                if ( input_type == 'pagebreak' ) {
                    pagebreak = true;
                }
            }
        });
        return pagebreak;
    }

    var render_preview_form_for_public = function (cnote_info, val_note_name) {
        var preview_form = [],
            input_type,
            chkdStr,
            have_page_break = have_page_break_in_note( cnote_info );

        //preview_form.push(draggableItem.preview_form_start);
        //preview_form.push(draggableItem.preview_control_group_start.replace(/{label_name}/g, 'Note Name'));
        preview_form.push(draggableItem.preview_form_note_title.replace(/{note_title}/g, val_note_name));
        if ( have_page_break ) {
            preview_note_wizard.before( preview_form.join('') );
            preview_form.length = 0;
        }

        //preview_form.push(draggableItem.preview_control_group_end);
        $.each(cnote_info, function (index, item) {
            if (typeof item === 'object') {
                input_type = Object.keys(item).toString();
                //console.log(input_type) ;
                switch (input_type) {

                    case 'checkbox':
                        //console.log(item[input_type]);
                        if (item[input_type].hasOwnProperty('total_items')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }


                            $.each(item[input_type].total_items, function (item_index, list_item) {


                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_checkbox_radio_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;


                    case 'textbox':
                        //
                        //  console.log(preview_form);
                        if (item[input_type].hasOwnProperty('text_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_text_default_value_item
                                    .replace(/{text_default_value}/g, item[input_type].text_default_value)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'number':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('number_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            if(item[input_type].required = "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_number_required_default_value_item
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_number_default_value_item
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                );
                            }




                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'email':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('email_default_value')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );

                            if(item[input_type].required = "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_email_required_default_value_item
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_email_default_value_item
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                );
                            }

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'date-of-event':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('event_date')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_event_date_item
                                    .replace(/{event_date}/g, item[input_type].event_date)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;

                    case 'phone':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('phone')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );

                            if(item[input_type].required = "required"){
                                preview_form.push(
                                    draggableItem
                                        .preview_phone_required_default_value_item
                                        .replace(/{phone}/g, item[input_type].phone)
                                );

                            }else{
                                preview_form.push(
                                    draggableItem
                                        .preview_phone_default_value_item
                                        .replace(/{phone}/g, item[input_type].phone)
                                );
                            }


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'name':
                        //console.log(preview_form);
                        if (item[input_type].hasOwnProperty('first_name')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            preview_form.push(
                                draggableItem
                                    .preview_name_default_value_item
                                    .replace(/{first_name}/g, item[input_type].first_name)
                                    .replace(/{last_name}/g, item[input_type].last_name)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'paragraph':
                        // console.log(preview_form);
                        if (item[input_type].hasOwnProperty('paragraph')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_paragraph_default_value_item
                                    .replace(/{paragraph}/g, item[input_type].paragraph)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'pagename':
                        // console.log('hello');

                        preview_form.push(
                            draggableItem
                                .preview_pagename_default_value_item
                                .replace(/{pagename}/g, item[input_type].pagename)
                        );

                        break;
                    case 'sectionbreak':

                        preview_form.push(
                            draggableItem
                                .preview_sectionbreak_default_value_item
                                .replace(/{sectionbreak}/g, item[input_type].sectionbreak)
                        );

                        break;
                    case 'pagebreak':
                        $( '#tab' + tab_counter ).html( preview_form.join('') );
                        tab_counter++;
                        preview_form.length = 0;
                        break;
                    case 'remark':
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_remark_default_value_item
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                                .replace(/{remark}/g, item[input_type].remark)
                        );

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'signature':
                        console.log(item[input_type].label_name);
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_control_signature_item
                                .replace(/{text}/g, item[input_type].text)
                                .replace(/{firstname}/g, item[input_type].firstname)
                                .replace(/{lastname}/g, item[input_type].lastname)
                                .replace(/{group_id}/g, item[input_type].group_id)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;

                    case 'radio':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            //// console.log(item[input_type]);
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                // console.log(draggableItem.preview_control_checkbox_radio_item);
                                // console.log(list_item.item_checked);
                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_checkbox_radio_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'dropdown':
                        if (item[input_type].hasOwnProperty('total_items')) {
                            if (item[input_type].required =='required'){
                                preview_form.push(
                                    draggableItem
                                        .preview_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                preview_form.push(
                                    draggableItem
                                        .preview_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            preview_form.push(
                                draggableItem
                                    .preview_control_dropdown_sitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{item_type}/g, input_type)

                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    var selected = 'selected';
                                    chkdStr = 'selected="' + selected + '"';
                                }
                                preview_form.push(
                                    draggableItem
                                        .preview_control_dropdown_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/selected="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                );
                            });
                            preview_form.push(
                                draggableItem
                                    .preview_control_dropdown_eitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'sign':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            //console.log(item[input_type]);
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                //  console.log(list_item.item_id)
                                if (list_item.item_id == '1') {
                                    preview_form.push(
                                        draggableItem
                                            .preview_control_sign_pic
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                    );
                                }
                                else {
                                    preview_form.push(
                                        draggableItem
                                            .preview_control_sign_item
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                    );
                                }

                            });

                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;
                    case 'ordinary-date':
                        //console.log(item);
                        if (item[input_type].hasOwnProperty('ordinary_default_date')) {
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_default_date
                                    .replace(/{ordinary_default_date}/g, item[input_type].ordinary_default_date)
                            );


                            preview_form.push(draggableItem.preview_control_group_end);
                        }
                        break;

                    case 'time-of-event':
                        //console.log(item);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        if (item[input_type].event_start_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_event_start_time_item
                                    .replace(/{event_start_time}/g, item[input_type].event_start_time)
                            );
                        }
                        if (item[input_type].event_end_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_event_end_time_item
                                    .replace(/{event_end_time}/g, item[input_type].event_end_time)
                            );
                        }

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'ordinary-time':
                        // console.log(item);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        if (item[input_type].ordinary_start_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_start_time_item
                                    .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)
                            );
                        }
                        if (item[input_type].ordinary_end_time != undefined) {
                            preview_form.push(
                                draggableItem
                                    .preview_ordinary_end_time_item
                                    .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)
                            );
                        }

                        preview_form.push(draggableItem.preview_control_group_end);

                        break;

                    case 'address-box':
                        // console.log(item);

                        if (item[input_type].required =='required'){
                            preview_form.push(
                                draggableItem
                                    .preview_control_required_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                        }
                        else{
                            preview_form.push(
                                draggableItem
                                    .preview_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                        }
                        preview_form.push(
                            draggableItem
                                .preview_address_item
                                .replace(/{address_1}/g, item[input_type].address)
                                .replace(/{address_2}/g, item[input_type].street)
                                .replace(/{address_3}/g, item[input_type].city)
                                .replace(/{address_4}/g, item[input_type].state)
                                .replace(/{address_5}/g, item[input_type].postalcode)
                                .replace(/{address_6}/g, item[input_type].country)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'reply-by-date':
                        //console.log(preview_form);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_reply_by_date_item
                                .replace(/{reply_by_default_date}/g, item[input_type].reply_by_default_date)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'reminder-date':
                        //console.log(preview_form);

                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        preview_form.push(
                            draggableItem
                                .preview_reminder_date_item
                                .replace(/{reminder_default_date}/g, item[input_type].reminder_default_date)
                                .replace(/{reminder_details}/g, item[input_type].reminder_details)
                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;
                    case 'payment-due':
                        // console.log(item);
                        preview_form.push(
                            draggableItem
                                .preview_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        $.each(item[input_type].total_items, function (item_index, list_item) {
                            if (list_item.required == "required") {
                                is_checked = 'checked="checked"';
                            }
                            else {
                                is_checked = '';
                            }
                           if(item[input_type].last_item_id >1){
                               if (list_item.required == "required") {
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_required
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );

                               }else{
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }

                           }else{
                               if (list_item.required == "required") {
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_first_required
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }else{
                                   preview_form.push(
                                       draggableItem
                                           .preview_payment_due_item_first
                                           .replace(/{dollar}/g, list_item.dollar)
                                           .replace(/{cent}/g, list_item.cent)
                                           .replace(/{item_label}/g, list_item.label_name)
                                           .replace(/{item_checked}/g, is_checked)
                                           .replace(/{quantity}/g, list_item.quantity)
                                   );
                               }

                           }

                        });
                        preview_form.push(
                            draggableItem
                                .preview_payment_due_total
                                .replace(/{total}/g, item[input_type].total)

                        );
                        preview_form.push(draggableItem.preview_control_group_end);

                        break;


                    default :
                        break;
                }

            }
        });

        if( have_page_break ) {
            $( '#tab' + tab_counter )
                .html(
                    preview_form.join( '' )
                );
            preview_form.length = 0;
        } else {
            preview_tab_fieldset.html( preview_form.join( '' ) );
        }
    };

    var render_dragged_item = function (cnote_info) {
            //return;
            var dragged_form = [],
                input_type,
                chkdStr;

            $.each(cnote_info, function (index, item) {
                    if (typeof item === 'object') {
                        input_type = Object.keys(item).toString();
                        switch (input_type) {
                            case 'checkbox':
                                //start group item
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_checkbox_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(draggableItem.dragged_item_checkbox_start_disable_control);

                                //start disable item listing
                                if (item[input_type].hasOwnProperty('total_items')) {

                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'checked="' + list_item.item_checked + '"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_checkbox_item
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });
                                }
                                //end control
                                dragged_form.push(draggableItem.dragged_item_checkbox_end_disable_control);
                                //start hidden info
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_checkbox_start_hidden_info
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{required}/g, item[input_type].required)
                                );

                                //start hidden item list
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_checkbox_hidden_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });

                                }

                                //start hidden checked item
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_checkbox_hidden_item_list_checked
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, list_item.item_checked)
                                        );
                                    });

                                }

                                //end hidden info
                                dragged_form.push(draggableItem.dragged_item_checkbox_end_hidden_info);
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_checkbox_start_item_holder
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, item[input_type].last_item_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{checked_required}/g, isRequired)
                                );

                                //start actionable checked item
                                var single_action_item_enable = true;
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'checked="checked"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_checkbox_start_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );

                                        if (single_action_item_enable) {
                                            single_action_item_enable = false;
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_checkbox_item_list_single_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                            );
                                        } else {
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_checkbox_item_list_double_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                            );
                                        }

                                        dragged_form.push(draggableItem.dragged_item_checkbox_end_item_list);
                                    });

                                }

                                //end item holder and end group item
                                dragged_form.push(draggableItem.dragged_item_checkbox_end_item_holder
                                    .replace(/{checked_required}/g, isRequired)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                );
                                break;
                            case 'textbox':
                                //start group item
                                console.log(input_type);
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_textbox_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_textbox_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{text_default_value}/g, item[input_type].text_default_value)
                                );

                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }


                                //start disable item listing
                                if (item[input_type].hasOwnProperty('text_default_value')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_textbox_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, item[input_type].required)
                                            .replace(/{text_default_value}/g, item[input_type].text_default_value)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_textbox_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, item[input_type].isRequired)
                                            .replace(/{text_default_value}/g, item[input_type].text_default_value)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_textbox_end);

                                }
                                break;
                            case 'number':
                                //start group item
                                //console.log(input_type);
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_number_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_number_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                );

                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }


                                //start disable item listing
                                if (item[input_type].hasOwnProperty('number_default_value')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_number_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, item[input_type].required)
                                            .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_number_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, item[input_type].isRequired)
                                            .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_number_end
                                        .replace(/{checked_required}/g, isRequired));

                                }
                                break;
                            case 'email':
                                //start group item
                                console.log(input_type);
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_email_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_email_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                );

                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }


                                //start disable item listing
                                if (item[input_type].hasOwnProperty('email_default_value')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_email_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, isRequired)
                                            .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_email_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, isRequired)
                                            .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_email_end);

                                }
                                break;
                            case 'date-of-event':
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_date_of_event
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{event_date}/g, item[input_type].event_date)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );

                                break;
                            case 'ordinary-date':
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_ordinary_date
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{ordinary_default_date}/g, item[input_type].ordinary_default_date)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );

                                break;
                            case 'time-of-event':
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_time_of_event_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                if (item[input_type].event_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_start_time_of_event_controls
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{event_start_time}/g, item[input_type].event_start_time)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                    );
                                }
                                if (item[input_type].event_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_end_time_of_event_controls
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{event_end_time}/g, item[input_type].event_end_time)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                    );
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_hidden_time_of_event_start
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );
                                if (item[input_type].event_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_hidden_start_time_of_event
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{event_start_time}/g, item[input_type].event_start_time)

                                    );
                                }
                                if (item[input_type].event_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_hidden_end_time_of_event
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{event_end_time}/g, item[input_type].event_end_time)

                                    );
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_hidden_time_of_event_end
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                if (item[input_type].event_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_control_group_start_time_of_event
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{event_start_time}/g, item[input_type].event_start_time)

                                    );
                                }
                                if (item[input_type].event_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_control_group_end_time_of_event
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{event_end_time}/g, item[input_type].event_end_time)

                                    );
                                }
                                dragged_form.push(draggableItem.dragged_time_of_event_end);

                                break;
                            case
                            'ordinary-time'
                            :
                                //start group item
                                var item_id = 1;
                                /*dragged_form.push(
                                 draggableItem
                                 .dragged_ordinary_time
                                 .replace(/{data_type}/g, input_type)
                                 .replace(/{group_id}/g, item[input_type].group_id)
                                 .replace(/{group_label}/g, item[input_type].label_name)
                                 .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)
                                 .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)
                                 .replace(/{item_id}/g, item[input_type].item_id)
                                 );*/
                                dragged_form.push(
                                    draggableItem
                                        .dragged_ordinary_time_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                if (item[input_type].ordinary_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_start_ordinary_time_controls
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                    );
                                }
                                if (item[input_type].ordinary_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_end_ordinary_time_controls
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                    );
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_hidden_ordinary_time_start
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );
                                if (item[input_type].ordinary_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_hidden_start_ordinary_time
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)

                                    );
                                }
                                if (item[input_type].ordinary_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_hidden_end_ordinary_time
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)

                                    );
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_hidden_ordinary_time_end
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                if (item[input_type].ordinary_start_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_control_group_start_ordinary_time
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)

                                    );
                                }
                                if (item[input_type].ordinary_end_time != undefined) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_control_group_end_ordinary_time
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)

                                    );
                                }
                                dragged_form.push(draggableItem.dragged_ordinary_time_end);

                                break;
                            case
                            'address-box'
                            :
                                //start group item
                                var item_id = 1;
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_address_box
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                        .replace(/{checked_required}/g, isRequired)
                                );

                                break;
                            case
                            'reply-by-date'
                            :
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_reply_by_date
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{reply_by_default_date}/g, item[input_type].reply_by_default_date)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );
                                break;
                            case
                            'reminder-date'
                            :
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_reminder_date
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{reminder_default_date}/g, item[input_type].reminder_default_date)
                                        .replace(/{item_id}/g, item[input_type].item_id)
                                );
                                break;
                            case
                            'payment-due'
                            :
                                //start group item
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                );
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_disable_item_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                );
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_disable_item
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_label}/g, list_item.label_name)
                                                .replace(/{dollar}/g, list_item.dollar)
                                                .replace(/{cent}/g, list_item.cent)
                                        );
                                    });
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_disable_item_end
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_disable_total_item
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{item_id}/g, item_id)
                                        .replace(/{total}/g, item[input_type].total)
                                );
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_hidden_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{total}/g, item[input_type].total)
                                        .replace(/{payment_type}/g, item[input_type].payment_type)
                                        .replace(/{item_id}/g, item_id)
                                        .replace(/{data_type}/g, input_type)
                                );
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_hidden_item_required
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{required}/g, list_item.required)
                                                .replace(/{data_type}/g, input_type)
                                        );
                                    });
                                }
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_hidden_item_label
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_label}/g, list_item.label_name)
                                                .replace(/{data_type}/g, input_type)
                                        );
                                    });
                                }
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_hidden_item_dollar
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{dollar}/g, list_item.dollar)
                                                .replace(/{data_type}/g, input_type)
                                        );
                                    });
                                }
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_hidden_item_cent
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{cent}/g, list_item.cent)
                                                .replace(/{data_type}/g, input_type)
                                        );
                                    });
                                }
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {

                                        dragged_form.push(
                                            draggableItem
                                                .dragged_payment_due_hidden_item_quantity
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{quantity}/g, list_item.quantity)
                                                .replace(/{data_type}/g, input_type)
                                        );
                                    });
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_hidden_end
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                );

                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_disable_end
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                );
                                if (item[input_type].payment_type == "fixed") {
                                    var fixed_checked = 'checked="checked"';
                                    var variable_checked = '';
                                    var displaytrue = 'display:none';

                                }
                                else {
                                    var fixed_checked = '';
                                    var variable_checked = 'checked="checked"';
                                    var displaytrue = '';

                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_item_holder_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{fixed}/g, fixed_checked)
                                        .replace(/{variable}/g, variable_checked)
                                );
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        if (list_item.required == 'required') {
                                            is_checked = 'checked="checked"';
                                        }
                                        else {
                                            is_checked = '';
                                        }
                                        if (list_item.item_id == 1 || list_item.item_id == '1') {
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_payment_due_item_holder_list_item_first
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{item_label}/g, list_item.label_name)
                                                    .replace(/{dollar}/g, list_item.dollar)
                                                    .replace(/{cent}/g, list_item.cent)
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{display}/g, displaytrue)
                                                    .replace(/{item_checked}/g, is_checked)
                                                    .replace(/{display_item}/g, displaytrue)


                                            );
                                        }
                                        else {
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_payment_due_item_holder_list_item
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{item_label}/g, list_item.label_name)
                                                    .replace(/{dollar}/g, list_item.dollar)
                                                    .replace(/{cent}/g, list_item.cent)
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{display}/g, displaytrue)
                                                    .replace(/{item_checked}/g, is_checked)
                                            );

                                        }

                                    });
                                }
                                if (item[input_type].last_item_id > 1) {
                                    $('.payment-icon-plus').show();
                                    $('.payment-fixed').attr('disabled', 'disabled');
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_payment_due_item_holder_end
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{total}/g, item[input_type].total)
                                );
                                break;

                            case
                            'radio'
                            :
//start group item
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_radio_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
//start control
                                dragged_form.push(draggableItem.dragged_item_radio_start_disable_control);

//start disable item listing
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'checked="' + list_item.item_checked + '"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_radio_item
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });
                                }
                                //end control
                                dragged_form.push(draggableItem.dragged_item_radio_end_disable_control);
                                //start hidden info
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_radio_start_hidden_info
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{required}/g, item[input_type].required)
                                );

                                //start hidden item list
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_radio_hidden_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });

                                }

                                //start hidden checked item
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_radio_hidden_item_list_checked
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, list_item.item_checked)
                                        );
                                    });

                                }

                                //end hidden info
                                dragged_form.push(draggableItem.dragged_item_radio_end_hidden_info);
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_radio_start_item_holder
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, item[input_type].last_item_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{checked_required}/g, isRequired)
                                );

                                //start actionable checked item
                                var single_action_item_enable = true;
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'checked="checked"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_radio_start_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                                .replace(/{checked_required}/g, isRequired)
                                        );

                                        if (single_action_item_enable) {
                                            single_action_item_enable = false;
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_radio_item_list_single_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{checked_required}/g, isRequired)
                                            );
                                        } else {
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_radio_item_list_double_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{checked_required}/g, isRequired)
                                            );
                                        }

                                        dragged_form.push(draggableItem.dragged_item_radio_end_item_list);
                                    });

                                }

                                //end item holder and end group item
                                dragged_form.push(draggableItem.dragged_item_radio_end_item_holder
                                    .replace(/{checked_required}/g, isRequired)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                );
                                break;

                            case
                            'dropdown'
                            :
//start group item
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_dropdown_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
//start control
                                dragged_form.push(draggableItem.dragged_item_dropdown_start_disable_control);

//start disable item listing
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'selected="selected"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_dropdown_item
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/selected="{item_checked}"/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });
                                }
                                //end control
                                dragged_form.push(draggableItem.dragged_item_dropdown_end_disable_control);
                                //start hidden info
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_dropdown_start_hidden_info
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{required}/g, item[input_type].required)
                                );

                                //start hidden item list
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_dropdown_hidden_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });

                                }

                                //start hidden checked item
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_dropdown_hidden_item_list_checked
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, list_item.item_checked)
                                        );
                                    });

                                }

                                //end hidden info
                                dragged_form.push(draggableItem.dragged_item_dropdown_end_hidden_info);
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_dropdown_start_item_holder
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, item[input_type].last_item_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{checked_required}/g, isRequired)
                                );

                                //start actionable checked item
                                var single_action_item_enable = true;
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        chkdStr = '';
                                        if (list_item.item_checked == 'checked') {
                                            chkdStr = 'checked="checked"';
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_dropdown_start_item_list
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{item_checked}/g, chkdStr)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );

                                        if (single_action_item_enable) {
                                            single_action_item_enable = false;
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_dropdown_item_list_single_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                            );
                                        } else {
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_dropdown_item_list_double_action_item
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                            );
                                        }

                                        dragged_form.push(draggableItem.dragged_item_dropdown_end_item_list);
                                    });

                                }

                                //end item holder and end group item
                                dragged_form.push(draggableItem.dragged_item_dropdown_end_item_holder
                                    .replace(/{checked_required}/g, isRequired)
                                    .replace(/{group_id}/g, item[input_type].group_id)


                                );
                                break;

                            case 'phone':

                                //start group item
                                //console.log(input_type);
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_phone_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_phone_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{phone}/g, item[input_type].phone)
                                );
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                //start disable item listing
                                if (item[input_type].hasOwnProperty('phone')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_phone_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, isRequired)
                                            .replace(/{phone}/g, item[input_type].phone)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_phone_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, isRequired)
                                            .replace(/{phone}/g, item[input_type].phone)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_phone_end);
                                }
                                break;
                            case 'name':
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_name_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_name_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{last_name}/g, item[input_type].last_name)
                                        .replace(/{first_name}/g, item[input_type].first_name)

                                );
                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }
                                //start disable item listing
                                if (item[input_type].hasOwnProperty('first_name')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_name_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, isRequired)
                                            .replace(/{last_name}/g, item[input_type].last_name)
                                            .replace(/{first_name}/g, item[input_type].first_name)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_name_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, isRequired)
                                            .replace(/{last_name}/g, item[input_type].last_name)
                                            .replace(/{first_name}/g, item[input_type].first_name)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_name_end);
                                }
                                break;
                            case
                            'paragraph'
                            :
                                //start group item
                                // console.log(input_type);
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_paragraph_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_paragraph_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{paragraph}/g, item[input_type].paragraph)
                                );

                                var isRequired = '';
                                if (item[input_type].required == 'required') {
                                    isRequired = 'checked="checked"';
                                }


                                //start disable item listing
                                if (item[input_type].hasOwnProperty('paragraph')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_paragraph_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, item[input_type].required)
                                            .replace(/{paragraph}/g, item[input_type].paragraph)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_paragraph_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, isRequired)
                                            .replace(/{paragraph}/g, item[input_type].paragraph)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_paragraph_end);

                                }
                                break;
                            case
                            'pagename'
                            :
                                var item_id = 1;
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_pagename_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_pagename_disable_control
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{pagename}/g, item[input_type].pagename)
                                );
                                //start disable item listing
                                if (item[input_type].hasOwnProperty('pagename')) {
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_pagename_start_hidden_info
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{required}/g, item[input_type].required)
                                            .replace(/{pagename}/g, item[input_type].pagename)
                                    );
                                    dragged_form.push(
                                        draggableItem
                                            .dragged_item_pagename_start_item_holder
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, item[input_type].item_id)
                                            .replace(/{group_label}/g, item[input_type].label_name)
                                            .replace(/{checked_required}/g, item[input_type].isRequired)
                                            .replace(/{pagename}/g, item[input_type].pagename)
                                    );
                                    dragged_form.push(draggableItem.dragged_item_pagename_end);
                                }
                                break;
                            case
                            'sectionbreak'
                            :
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_sectionbreak_start_item_holder
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                );
                                break;
                            case
                            'pagebreak'
                            :
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_pagebreak_start_item_holder
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{pagebreak}/g, item[input_type].pagebreak)
                                        .replace(/{data_type}/g, input_type)
                                );
                                break;
                            case
                            'remark'
                            :
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_remark_start_item_holder
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{remark}/g, item[input_type].remark)
                                );
                                break;
                            case
                            'signature'
                            :
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_signature
                                        .replace(/{text}/g, item[input_type].text)
                                        .replace(/{firstname}/g, item[input_type].firstname)
                                        .replace(/{lastname}/g, item[input_type].lastname)
                                        .replace(/{Consent}/g, item[input_type].consent)
                                        .replace(/{NonConsent}/g, item[input_type].nonconsent)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{data_type}/g, input_type)
                                );
                                break;
                            case
                            'sign'
                            :
                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_sign_start
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)
                                );
                                //start control
                                dragged_form.push(draggableItem.dragged_item_sign_start_disable_control);
                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        if (list_item.item_id == 1) {
                                            type = "pic";
                                        }
                                        else if (list_item.item_id == 2) {
                                            type = "name";
                                        }
                                        else {
                                            type = "des";
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_sign_disable_item
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{input_type}/g, type)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });
                                }

                                dragged_form.push(draggableItem.dragged_item_sign_end_disable_control);

                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_sign_start_hidden_info
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)


                                );

                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        if (list_item.item_id == 1) {
                                            type = "pic";
                                        }
                                        else if (list_item.item_id == 2) {
                                            type = "name";
                                        }
                                        else {
                                            type = "des";
                                        }
                                        dragged_form.push(
                                            draggableItem
                                                .dragged_item_sign_list_hidden_info
                                                .replace(/{data_type}/g, input_type)
                                                .replace(/{group_id}/g, item[input_type].group_id)
                                                .replace(/{item_id}/g, list_item.item_id)
                                                .replace(/{input_type}/g, type)
                                                .replace(/{item_label}/g, list_item.label_name)
                                        );
                                    });
                                }


                                dragged_form.push(
                                    draggableItem
                                        .dragged_item_sign_start_item_holder
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{group_label}/g, item[input_type].label_name)


                                );

                                if (item[input_type].hasOwnProperty('total_items')) {
                                    $.each(item[input_type].total_items, function (item_index, list_item) {
                                        if (list_item.item_id == 1) {
                                            type = "pic";

                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_sign_start_item_pic_list
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{input_type}/g, type)
                                                    .replace(/{item_label}/g, list_item.label_name)

                                            );
                                        }
                                        else if (list_item.item_id == 2) {
                                            type = "name";
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_sign_start_item_list
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{input_type}/g, type)
                                                    .replace(/{item_label}/g, list_item.label_name)
                                            );
                                        }
                                        else {
                                            type = "des";
                                            dragged_form.push(
                                                draggableItem
                                                    .dragged_item_sign_start_item_list
                                                    .replace(/{data_type}/g, input_type)
                                                    .replace(/{group_id}/g, item[input_type].group_id)
                                                    .replace(/{item_id}/g, list_item.item_id)
                                                    .replace(/{input_type}/g, type)
                                                    .replace(/{item_label}/g, list_item.label_name)
                                            );
                                        }

                                    });
                                }

                                dragged_form.push(draggableItem.dragged_item_sign_end_item_list);
                                dragged_form.push(draggableItem.dragged_item_sign_end_item_holder);

                                // }
                                break;
                            default :
                                break;
                        }

                    }
                }
            )
            ;
            $('#tab_begin_note div.sortable-note-area').append(dragged_form.join(''));
        };

    var render_reply_form = function (cnote_info, val_note_name) {
        var reply_form = [],
            input_type,
            chkdStr;
        //console.log(cnote_info);
        reply_form.push(draggableItem.reply_form_start);
        reply_form.push(draggableItem.reply_control_group_start.replace(/{label_name}/g, 'Note Name'));
        reply_form.push(draggableItem.reply_form_note_title.replace(/{note_title}/g, val_note_name));
        reply_form.push(draggableItem.reply_control_group_end);
        $.each(cnote_info, function (index, item) {
            if (typeof item === 'object') {
                input_type = Object.keys(item).toString();
                //console.log(input_type) ;
                switch (input_type) {

                    case 'checkbox':
                        //console.log(item[input_type]);
                        if (item[input_type].hasOwnProperty('total_items')) {

                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );

                            reply_form.push(
                                draggableItem
                                    .reply_item_checkbox_start_hidden_info
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                reply_form.push(
                                    draggableItem
                                        .reply_item_checkbox_hidden_item_list_checked
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{item_checked}/g, list_item.item_checked)
                                );
                            });

                            reply_form.push(draggableItem.reply_item_checkbox_end_hidden_info);

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                reply_form.push(
                                    draggableItem
                                        .reply_control_checkbox_radio_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;


                    case 'radio':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            console.log(item[input_type]);
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_item_checkbox_start_hidden_info
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                reply_form.push(
                                    draggableItem
                                        .reply_item_radio_hidden_item_list_checked
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{item_checked}/g, list_item.item_checked)
                                );
                            });

                            reply_form.push(draggableItem.reply_item_checkbox_end_hidden_info);
                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    chkdStr = 'checked="' + list_item.item_checked + '"';
                                }
                                reply_form.push(
                                    draggableItem
                                        .reply_control_radio_item

                                        .replace(/{item_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/checked="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                );
                            });

                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'dropdown':
                        if (item[input_type].hasOwnProperty('total_items')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_item_checkbox_start_hidden_info
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                reply_form.push(
                                    draggableItem
                                        .reply_control_dropdown_hidden_checked_item
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{item_checked}/g, list_item.item_checked)
                                );
                            });

                            reply_form.push(draggableItem.reply_item_checkbox_end_hidden_info);
                            reply_form.push(
                                draggableItem
                                    .reply_control_dropdown_sitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{item_type}/g, input_type)

                            );

                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                chkdStr = '';
                                if (list_item.item_checked == 'checked') {
                                    var selected = 'selected';
                                    chkdStr = 'selected="' + selected + '"';
                                }
                                reply_form.push(
                                    draggableItem
                                        .reply_control_dropdown_item
                                        .replace(/{item_type}/g, input_type)
                                        .replace(/selected="{item_checked}"/g, chkdStr)
                                        .replace(/{item_label}/g, list_item.label_name)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                );
                            });
                            reply_form.push(
                                draggableItem
                                    .reply_control_dropdown_eitem
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'signature':

                        reply_form.push(
                            draggableItem
                                .reply_control_signature_item

                                .replace(/{data_type}/g, input_type)
                                .replace(/{text}/g, item[input_type].text)
                                .replace(/{firstname}/g, item[input_type].firstname)
                                .replace(/{lastname}/g, item[input_type].lastname)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{Consent}/g, item[input_type].consent)
                                .replace(/{NonConsent}/g, item[input_type].nonconsent)
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );

                        break;
                    case 'textbox':
                        console.log(reply_form);
                        if (item[input_type].hasOwnProperty('text_default_value')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_text_default_value_item
                                    .replace(/{text_default_value}/g, item[input_type].text_default_value)
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );


                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'number':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('number_default_value')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            if(item[input_type].required ='required'){
                                reply_form.push(
                                    draggableItem
                                        .reply_number_default_value_item_required
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }else{
                                reply_form.push(
                                    draggableItem
                                        .reply_number_default_value_item
                                        .replace(/{number_default_value}/g, item[input_type].number_default_value)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }

                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'email':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('email_default_value')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            if(item[input_type].required = 'required'){
                                reply_form.push(
                                    draggableItem
                                        .reply_email_default_value_item_required
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }
                            else{
                                reply_form.push(
                                    draggableItem
                                        .reply_email_default_value_item
                                        .replace(/{email_default_value}/g, item[input_type].email_default_value)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                            }

                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'date-of-event':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('event_date')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_event_date_item
                                    .replace(/{event_date}/g, item[input_type].event_date)
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );


                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;

                    case 'phone':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('phone')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            if(item[input_type].required ='required'){
                                reply_form.push(
                                    draggableItem
                                        .reply_phone_default_value_item_required
                                        .replace(/{phone}/g, item[input_type].phone)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );

                            }else{
                                reply_form.push(
                                    draggableItem
                                        .reply_phone_default_value_item
                                        .replace(/{phone}/g, item[input_type].phone)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );

                            }


                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;

                    case 'name':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('first_name')) {
                            if (item[input_type].required ='required'){
                                reply_form.push(
                                    draggableItem
                                        .reply_control_required_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                                reply_form.push(
                                    draggableItem
                                        .reply_name_default_value_item_required
                                        .replace(/{first_name}/g, item[input_type].first_name)
                                        .replace(/{last_name}/g, item[input_type].last_name)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );

                            }else{
                                reply_form.push(
                                    draggableItem
                                        .reply_control_group_start
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );
                                reply_form.push(
                                    draggableItem
                                        .reply_name_default_value_item
                                        .replace(/{first_name}/g, item[input_type].first_name)
                                        .replace(/{last_name}/g, item[input_type].last_name)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{label_name}/g, item[input_type].label_name)
                                );

                            }



                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'paragraph':
                        //console.log(reply_form);
                        if (item[input_type].hasOwnProperty('paragraph')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_paragraph_default_value_item
                                    .replace(/{paragraph}/g, item[input_type].paragraph)
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );


                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'pagename':
                        console.log('hello');

                        reply_form.push(
                            draggableItem
                                .reply_pagename_default_value_item
                                .replace(/{pagename}/g, item[input_type].pagename)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );

                        break;
                    case 'sectionbreak':

                        reply_form.push(
                            draggableItem
                                .reply_sectionbreak_default_value_item
                                .replace(/{sectionbreak}/g, item[input_type].sectionbreak)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );

                        break;
                    case 'pagebreak':

                        reply_form.push(
                            draggableItem
                                .reply_pagebreak_default_value_item
                                .replace(/{pagebreak}/g, item[input_type].pagebreak)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );

                        break;
                    case 'remark':

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_hidden_remark_default_value_item
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{remark}/g, item[input_type].remark)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_remark_default_value_item
                                .replace(/{remark}/g, item[input_type].sectionbreak)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{remark}/g, item[input_type].remark)
                        );

                        reply_form.push(draggableItem.reply_control_group_end);


                        break;


                    case 'sign':

                        if (item[input_type].hasOwnProperty('total_items')) {
                            console.log(item[input_type]);
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                if (list_item.item_id == '1') {
                                    reply_form.push(
                                        draggableItem
                                            .reply_control_sign_pic
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{label_name}/g, item[input_type].label_name)
                                    );
                                }
                                else {
                                    reply_form.push(
                                        draggableItem
                                            .reply_control_sign_item
                                            .replace(/{item_id}/g, list_item.label_name)
                                            .replace(/{item_label}/g, list_item.label_name)
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{label_name}/g, item[input_type].label_name)
                                    );
                                }

                            });

                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;
                    case 'ordinary-date':
                        console.log(item);
                        if (item[input_type].hasOwnProperty('ordinary_default_date')) {
                            reply_form.push(
                                draggableItem
                                    .reply_control_group_start
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );
                            reply_form.push(
                                draggableItem
                                    .reply_ordinary_default_date
                                    .replace(/{ordinary_default_date}/g, item[input_type].ordinary_default_date)
                                    .replace(/{data_type}/g, input_type)
                                    .replace(/{group_id}/g, item[input_type].group_id)
                                    .replace(/{label_name}/g, item[input_type].label_name)
                            );


                            reply_form.push(draggableItem.reply_control_group_end);
                        }
                        break;

                    case 'time-of-event':
                        console.log(item);

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_event_time_item
                                .replace(/{event_start_time}/g, item[input_type].event_start_time)
                                .replace(/{event_end_time}/g, item[input_type].event_end_time)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)

                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;
                    case 'ordinary-time':
                        console.log(item);

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_ordinary_time_item
                                .replace(/{ordinary_start_time}/g, item[input_type].ordinary_start_time)
                                .replace(/{ordinary_end_time}/g, item[input_type].ordinary_end_time)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)

                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;

                    case 'address-box':

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_address_item
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;
                    case 'reply-by-date':
                        //console.log(reply_form);

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_reply_by_date_item
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                                .replace(/{reply_by_default_date}/g, item[input_type].reply_by_default_date)
                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;
                    case 'reminder-date':
                        //console.log(reply_form);

                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        reply_form.push(
                            draggableItem
                                .reply_reminder_date_item
                                .replace(/{data_type}/g, input_type)
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{label_name}/g, item[input_type].label_name)
                                .replace(/{reminder_default_date}/g, item[input_type].reminder_default_date)
                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;
                    case 'payment-due':
                        // console.log(item);
                        reply_form.push(
                            draggableItem
                                .reply_control_group_start
                                .replace(/{label_name}/g, item[input_type].label_name)
                        );
                        var item_id = 1;
                        reply_form.push(
                            draggableItem
                                .reply_payment_due_start
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                        );

                        reply_form.push(
                            draggableItem
                                .reply_payment_due_hidden_start
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{total}/g, item[input_type].total)
                                .replace(/{item_id}/g, item_id)
                                .replace(/{data_type}/g, input_type)
                        );
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                reply_form.push(
                                    draggableItem
                                        .reply_payment_due_hidden_item_required
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{required}/g, list_item.required)
                                        .replace(/{data_type}/g, input_type)
                                );
                            });
                        }
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                reply_form.push(
                                    draggableItem
                                        .reply_payment_due_hidden_item_label
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{item_label}/g, list_item.label_name)
                                        .replace(/{data_type}/g, input_type)
                                );
                            });
                        }
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                reply_form.push(
                                    draggableItem
                                        .reply_payment_due_hidden_item_dollar
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{dollar}/g, list_item.dollar)
                                        .replace(/{data_type}/g, input_type)
                                );
                            });
                        }
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                if (list_item.dollar == '') {
                                    var cbdollar = 0;
                                } else {
                                    var cbdollar = list_item.dollar;
                                }
                                if (list_item.cent == '') {
                                    var cbcent = 0;
                                } else {
                                    var cbcent = list_item.cent;
                                }
                                var item_total = cbdollar + '.' + cbcent;
                                reply_form.push(
                                    draggableItem
                                        .reply_payment_due_hidden_item_cent
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{cent}/g, list_item.cent)
                                        .replace(/{data_type}/g, input_type)
                                        .replace(/{dollar_cent}/g, item_total)
                                );
                            });
                        }
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {

                                reply_form.push(
                                    draggableItem
                                        .reply_payment_due_hidden_item_quantity
                                        .replace(/{group_id}/g, item[input_type].group_id)
                                        .replace(/{item_id}/g, list_item.item_id)
                                        .replace(/{quantity}/g, list_item.quantity)
                                        .replace(/{data_type}/g, input_type)
                                );
                            });
                        }
                        reply_form.push(
                            draggableItem
                                .reply_payment_due_hidden_end
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                        );

                        reply_form.push(
                            draggableItem
                                .reply_payment_due_disable_end
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                        );
                        if (item[input_type].last_item_id == 1) {
                            var fixed_checked = 'checked="checked"';
                            var variable_checked = '';
                            var displaytrue = 'display:none';


                        }
                        else {
                            var fixed_checked = 'disabled="disabled"';
                            var variable_checked = 'checked="checked"';
                            var displaytrue = '';

                        }
                        reply_form.push(
                            draggableItem
                                .reply_payment_due_item_holder_start
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{fixed}/g, fixed_checked)
                                .replace(/{variable}/g, variable_checked)
                        );
                        if (item[input_type].hasOwnProperty('total_items')) {
                            $.each(item[input_type].total_items, function (item_index, list_item) {
                                if (list_item.required == 'required') {
                                    is_checked = 'checked="checked"';
                                    var msg = "You Must Pay For This.";
                                    is_disabled = 'disabled="disabled"';
                                }
                                else {
                                    is_checked = '';
                                    var msg = "Do You Want To Pay For This?"
                                    is_disabled = '';
                                }

                                if (list_item.item_id == 1 || list_item.item_id == '1') {
                                    reply_form.push(
                                        draggableItem
                                            .reply_payment_due_item_holder_list_item_first
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, list_item.item_id)
                                            .replace(/{item_label}/g, list_item.label_name)
                                            .replace(/{dollar}/g, list_item.dollar)
                                            .replace(/{cent}/g, list_item.cent)
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{display}/g, displaytrue)
                                            .replace(/{item_checked}/g, is_checked)
                                            .replace(/{display_item}/g, displaytrue)
                                            .replace(/{msg_to_show}/g, msg)
                                            .replace(/{must_pay}/g, is_disabled)
                                            .replace(/{quantity}/g, list_item.quantity)


                                    );
                                }
                                else {
                                    reply_form.push(
                                        draggableItem
                                            .reply_payment_due_item_holder_list_item
                                            .replace(/{group_id}/g, item[input_type].group_id)
                                            .replace(/{item_id}/g, list_item.item_id)
                                            .replace(/{item_label}/g, list_item.label_name)
                                            .replace(/{quantity}/g, list_item.quantity)
                                            .replace(/{dollar}/g, list_item.dollar)
                                            .replace(/{cent}/g, list_item.cent)
                                            .replace(/{data_type}/g, input_type)
                                            .replace(/{display}/g, displaytrue)
                                            .replace(/{item_checked}/g, is_checked)
                                            .replace(/{msg_to_show}/g, msg)
                                    );

                                }

                            });
                        }
                        if (item[input_type].last_item_id > 1) {
                            $('.payment-icon-plus').show();
                            $('.payment-fixed').attr('disabled', 'disabled');
                        }
                        reply_form.push(
                            draggableItem
                                .reply_payment_due_item_holder_end
                                .replace(/{group_id}/g, item[input_type].group_id)
                                .replace(/{group_label}/g, item[input_type].label_name)
                                .replace(/{data_type}/g, input_type)
                                .replace(/{total}/g, item[input_type].total)
                        );
                        reply_form.push(draggableItem.reply_control_group_end);

                        break;

                    default :
                        break;
                }

            }
        });
        reply_form.push(draggableItem.reply_form_end);
        preview_tab.html(reply_form.join(''));
    };

    var destroyAllPopover = function (ui) {
        //$('*').popover('hide');
        console.log('called');
        if (ui.item.data('sorted') == 'sorted') {
            ui.item.css('height', 'auto');
        }
        $('div.item-holder').hide();
    };


    var slideUpAllItem = function () {
        var iconItem, itemHolder;
        $('div.sortable-note-area').children('div.group-item').each(function (index, eachGroupItem) {
            //console.log(eachGroupItem);
            iconItem = $(eachGroupItem).find('i.control-group-icon');
            itemHolder = $(eachGroupItem).children('div.item-holder');
            if ($(iconItem).hasClass('fa-minus-circle')) {
                $(iconItem).removeClass('fa-minus-circle').addClass('fa-plus-circle');
                $(itemHolder).slideUp('', function () {
                    $(this).addClass('slide-up');
                });
            }
        });
    };

    //Note Save and Send
    var send_form_json = function () {
        $.ajax({
            url: site_url + 'notes/new',
            type: "POST",
            data: 'note_status=' + note_status + '&cnote_form_info=' + JSON.stringify(cnote_info),
            success: function (response_data) {
                //console.log(response_data);
                var res_json_ob = $.parseJSON(response_data);
                if ( res_json_ob.note_info.type == 'success') {
                    if ( note_status == 2 ) {
                        $('#schedule-modal').modal('hide');
                    } else if( note_status == 1 ) {
                        note_form.submit();
                    } else {

                    }
                } else {

                }
            }
        });
    };

//All Drag and Drop working code start from here

    $('.draggable .btn').draggable({
        connectToSortable: '.sortable-note-area',
        cursor: 'move',
        helper: 'clone',
        start: function (event, ui) {
            $('.add-remove-holder i.help-popover').popover('hide');
            if (ui.helper.data('item') == 'movable') {
                $(this).hide();
            }
        },
        stop: function (event, ui) {
            // body...
            if (isNotDropped) {
                $(this).show();
            }
        },
        revert: function (isDropped) {
            // body...
            if (isDropped) {
                isNotDropped = false;
                return false;
            } else {
                isNotDropped = true;
                return true;
            }
        }
    });

    $('.sortable-note-area').sortable({
        appendTo: '.sortable-note-area, :not("div.control-group")',
        cancel: "div.item-holder",
        placeholder: "control-group-highlight",
        //revert: true,
        start: function (event, ui) {
            $('.add-remove-holder i.help-popover').popover('hide');
            var currentItemHolder = ui.item.children('div.item-holder');
            if (typeof currentItemHolder.html() != 'undefined' && !currentItemHolder.hasClass('slide-up')) {
                ui.item.css('height', 'auto');
                ui.item.find('i.control-group-icon').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');
                ui.item.children('div.item-holder').slideUp('', function () {
                    $(this).addClass('slide-up');
                });
            }
        },
        over: function (event, ui) {
            removeIntent = false;
            state = 'over';
        },
        receive: function (event, ui) {
            isReceiveItem = true;
            var chtml = [],
                itemStr = '',
                data_type = ui.item.data('type');

            if (data_type == 'radio') {
                chtml.push(
                    draggableItem.radio
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(initial_item_id_counter)))
                );
                group_id_counter++;
            } else if (data_type == 'checkbox') {
                chtml.push(
                    draggableItem.checkbox
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(initial_item_id_counter)))
                );
                group_id_counter++;
            }
            else if (data_type == 'textbox') {
                chtml.push(
                    draggableItem.textbox
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }
            else if (data_type == 'name') {
                chtml.push(
                    draggableItem.name
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            } else if (data_type == 'number') {
                chtml.push(
                    draggableItem.number
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            } else if (data_type == 'email') {
                chtml.push(
                    draggableItem.email
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }
            else if (data_type == 'signature') {
                chtml.push(
                    draggableItem.signature
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }
            else if (data_type == 'pagename') {
                chtml.push(
                    draggableItem.pagename
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }
            else if (data_type == 'sectionbreak') {
                chtml.push(
                    draggableItem.sectionbreak
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }
            else if (data_type == 'dropdown') {
                chtml.push(
                    draggableItem.dropdown
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(initial_item_id_counter)))
                );
                group_id_counter++;
            }
            else if (data_type == 'sign') {

                // console.log('hello');
                var note_id = $('#new-note :input[name="note_id"]');
                var note = note_id.val();
                //console.log(note);
                chtml.push(
                    draggableItem.sign
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{note_id}/g, note)
                );
                group_id_counter++;
            }
            else if (data_type == 'paragraph') {

                // console.log('hello');
                var note_id = $('#new-note :input[name="note_id"]');
                var note = note_id.val();
                //console.log(note);
                chtml.push(
                    draggableItem.paragraph
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{note_id}/g, note)
                );
                group_id_counter++;

            }
            else if (data_type == 'remark') {

                // console.log('hello');
                var note_id = $('#new-note :input[name="note_id"]');
                var note = note_id.val();
                //console.log(note);
                chtml.push(
                    draggableItem.remark
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{note_id}/g, note)
                );
                group_id_counter++;

            }
            else if (data_type == 'phone') {

                // console.log('hello');
                var note_id = $('#new-note :input[name="note_id"]');
                var note = note_id.val();
                //console.log(note);
                chtml.push(
                    draggableItem.phone
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{note_id}/g, note)
                );
                group_id_counter++;

            }
            else if (data_type == 'pagebreak') {

                // console.log('hello');
                var note_id = $('#new-note :input[name="note_id"]');
                var note = note_id.val();
                //console.log(note);
                chtml.push(
                    draggableItem.pagebreak
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{note_id}/g, note)
                );
                group_id_counter++;

            }
            else if (data_type == 'date-of-event') {
                var d = new Date();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var output = d.getFullYear() + '/' + month + '/' + day;
                // console.log(output);
                chtml.push(
                    draggableItem.date_of_event
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{event_date_raw}/g, output)
                        .replace(/{event_date}/g, getFormattedDate(output.toString()))
                );
                group_id_counter++;
            } else if (data_type == 'ordinary-date') {
                var d = new Date();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var output = d.getFullYear() + '/' + month + '/' + day;
                // console.log(output);
                chtml.push(
                    draggableItem.ordinary_date
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{ordinary_default_date}/g, getFormattedDate(output.toString()))
                        .replace(/{ordinary_default_date_raw}/g, output)
                );
                group_id_counter++;
            } else if (data_type == 'time-of-event') {
                chtml.push(
                    draggableItem.time_of_event
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );

                group_id_counter++;
            } else if (data_type == 'ordinary-time') {
                chtml.push(
                    draggableItem.ordinary_time
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            } else if (data_type == 'address-box') {
                chtml.push(
                    draggableItem.address_box
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            } else if (data_type == 'reply-by-date') {
                var d = new Date();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var output = d.getFullYear() + '/' + month + '/' + day;
                // console.log(output);
                chtml.push(
                    draggableItem.reply_by_date
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{reply_by_default_date_raw}/g, output)
                        .replace(/{reply_by_default_date}/g, getFormattedDate(output.toString()))

                );
                group_id_counter++;
            } else if (data_type == 'reminder-date') {
                var d = new Date();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var output = d.getFullYear() + '/' + month + '/' + day;
                // console.log(output);
                chtml.push(
                    draggableItem.reminder_date
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{reminder_default_date_raw}/g, output)
                        .replace(/{reminder_default_date}/g, getFormattedDate(output.toString()))

                );
                group_id_counter++;
            } else if (data_type == 'payment-due') {
                chtml.push(
                    draggableItem.payment_due
                        .replace(/{group_id}/g, parseInt(group_id_counter))
                        .replace(/{item_id}/g, parseInt(initial_item_id_counter))
                        .replace(/{data_type}/g, data_type)
                );
                group_id_counter++;
            }

            else {
            }

            cnote_info.last_group_id = group_id_counter;
            $(this).find('a').replaceWith(chtml.join(''));
            var currentItem = $(this).find('.group-item:eq(' + sortableItemIndex + ')');
            var current_type = currentItem.children('div.control-group').data('type');
            if (data_type == 'time-of-event' || data_type == 'ordinary-time') {
                //console.log(currentItem);
                //console.log(currentItem);
                currentItem.find('.change-time').each(function (i, elem) {
                    // console.log(elem);
                    $(elem).timepicker();
                });
            }
            if (current_type == 'paragraph') {
                // console.log(currentItem);
                //$(currentItem).find('.cnote-textarea').summernote();
//                  var myt = $(currentItem).find('.cnote-textarea').attr('id');
//                  nicEditors.findEditor(myt+'');
                //nicEditors.allTextAreas;
                //$(currentItem).find('.cnote-textarea').ClassyEdit();
//                var myt = $(currentItem).find('.cnote-textarea').each(function(){
//                      $(this).wysihtml5();
//                  });
                //$('#'+myt).wysihtml5();
//                var current_type_id = currentItem.children('div.control-group').data('group-id');
//               //console.log(current_type_id+current_type);
//                var cclass=  $('#'+current_type_id+current_type).attr('class');
//               // console.log(cclass);
//                $('.cnote-textarea').ClassyEdit();
//                $('#'+current_type_id+current_type).removeClass('cnote-textarea');
//                $('#'+current_type_id+current_type).hide();

            }
            // $('.cnote-textarea').ClassyEdit();
            //$(".cnote-textarea").each(function(){$(this).ClassyEdit();

            //  $(this).removeClass('cnote-textarea');
            //  });
            var iconItem = $(currentItem).find('i.control-group-icon');
            var itemHolder = $(currentItem).children('div.item-holder');
            $(iconItem).addClass('fa-minus-circle').removeClass('fa-plus-circle');
            $(itemHolder).slideDown();
        },
        out: function (event, ui) {
            removeIntent = true;
            state = 'out';
        },

        beforeStop: function (event, ui) {
            //console.log('ting');
            sortableItemIndex = ui.item.index();
            slideUpAllItem();

            //destroyAllPopover();
            if (removeIntent == true) {
                ui.item.remove();
            }
            //console.log(state+'->'+removeIntent);
        },
        stop: function (event, ui) {
            //when an item will be sorted, the sorted item expand and all others will hide
            if (typeof ui.item.children('div.item-holder').html() != 'undefined') {
                ui.item.find('i.control-group-icon').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');
                ui.item.children('div.item-holder').slideDown('', function () {
                    $(this).removeClass('slide-up');
                });
            }
        }

    });

    $('div.sortable-note-area').on('click', 'i.control-group-icon', function (ev) {
        slideUpAllItem();
        var currentGroupIcon = $(this);
        var currentItemHolder = $(currentGroupIcon).parent('div.control-group').next('div.item-holder');

        if ($(currentItemHolder).hasClass('slide-up')) {
            $(currentGroupIcon).removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            $(currentItemHolder).slideDown('', function () {
                $(currentItemHolder).removeClass('slide-up');
            });
        } else {
            $(currentGroupIcon).removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            $(currentItemHolder).slideUp('', function () {
                $(currentItemHolder).addClass('slide-up');
            });
        }
        //$(this).parent('div.control-group').next('div.item-holder').slideToggle();
    });

    //operation will be occurred when label changed
    $('.add-remove-holder').on('keyup', '.change-label', function () {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');
        root_parent.find('div.control-group:eq(0) [data-label-id="' + $(this).data('append-to') + '"]').text($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-label-' + group_id + '"]').val($(this).val());
    });

    $('.add-remove-holder').on('keyup', '.change-text', function () {
        console.log('hello');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        root_parent.find('div.control-group:eq(0) [data-textbox-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-text-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-number-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-email-' + group_id + '"]').val($(this).val());

    });
    $('.add-remove-holder').on('keyup', '.change-numbers', function (e) {

        var nKeyCode = e.keyCode;
        // console.log(nKeyCode);
        if ((nKeyCode > 95 && nKeyCode < 106) || (nKeyCode > 47 && nKeyCode < 58 ) || nKeyCode == 8 || nKeyCode == 46) {
            console.log(nKeyCode);
            var root_parent = $(this).parents('div.group-item'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            data_name = $(this).attr('data-name');
            if ($.isNumeric($(this).val()) == true || nKeyCode == 8 || nKeyCode == 46) {

                if (data_name == 'cent' && this.value.length > 2) {
                    return;
                }

                root_parent.find('div.control-group:eq(0) [data-' + data_name + '-' + data_type + '-id="' + data_name + '-' + data_type + '-id-' + group_id + '"]').val($(this).val());
                root_parent.find('.hidden-info [data-id="' + data_name + '-' + data_type + '-text-' + group_id + '"]').val($(this).val());
            }
        } else {
            e.preventDefault();
        }


    });

    /* $('.add-remove-holder').on('keyup', '.change-address', function () {

     var root_parent = $(this).parents('div.group-item'),
     data_type = $(this).data('type'),
     group_id = $(this).data('group-id');//$(this).val()
     data_name = $(this).attr('data-name');
     console.log(data_name);
     root_parent.find('div.control-group:eq(0) [data-' + data_name + '-' + data_type + '-id="' + data_name + '-' + data_type + '-id-' + group_id + '"]').val($(this).val());
     root_parent.find('.hidden-info [data-id="' + data_name + '-' + data_type + '-text-' + group_id + '"]').val($(this).val());

     });*/

    $('.add-remove-holder').on('focus', '.change-date', function () {
        console.log('I am focus');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');


        $(this).datepicker({
            // show:true,
            onRender: function (date) {
                if (date.valueOf() <= now.valueOf()) {
                    return 'disabled';
                } else {
                    return '';
                }
            },

            fillMonths: true

        }).on('changeDate',function (ev) {
                date_value_change = $(this).val();

                // console.log( getFormattedDate(date_value_change.toString()) );
                // console.log( getFormattedDate("6/1/2013") );
                root_parent.find('div.control-group:eq(0) [data-' + data_type + '-id="' + data_type + '-id-' + group_id + '"]').val(getFormattedDate(date_value_change.toString()));
                root_parent.find('.hidden-info [data-id="' + data_type + '-text-' + group_id + '"]').val($(this).val());
            }).data('datepicker');

    });
    var getFormattedDate = function (input) {
        // console.log(input);
        var pattern = /(.*?)\/(.*?)\/(.*?)$/;
        var result = input.replace(pattern, function (match, p2, p1, p3) {
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return p3 + " " + months[(p1 - 1)] + " " + (p2 < 10 ? "0" + p2 : p2);
        });
        return result;
    };

    $('.add-remove-holder').on('click', '.add-on-remove-time', function () {


        var item = $(this).prevAll('.change-time');
        var root_parent = item.parents('div.group-item'),
            item_parent = $(this).parents('div.control-group'),
            data_type = item.data('type'),
            group_id = item.data('group-id'),
            data_name = item.attr('data-name');

        //delete same parent div
        item_parent.remove();
        //delete linked field and linkedin hidden field
        root_parent.find('div.control-group:eq(0) [data-' + data_name + '-' + data_type + '-id="' + data_name + '-' + data_type + '-id-' + group_id + '"]').parents('div.controls').remove();
        root_parent.find('.hidden-info [data-id="' + data_name + '-' + data_type + '-' + group_id + '"]').remove();


    });

    $('.add-remove-holder').on('click', '.add-on-time', function () {

        //console.log('I am focus');
        var item = $(this).prev('.change-time');
        item.timepicker('showWidget');
        //console.log(item);

        var root_parent = item.parents('div.group-item'),
            data_type = item.data('type'),
            group_id = item.data('group-id');
        data_name = item.attr('data-name');

        item.on('changeTime.timepicker', function (ev) {
            // console.log(root_parent.find('div.control-group:eq(0) [data-'+data_name+'-'+ data_type + '-id="'+data_name+'-'+ data_type + '-id-' + group_id + '"]').val( $(this).val()));
            root_parent.find('div.control-group:eq(0) [data-' + data_name + '-' + data_type + '-id="' + data_name + '-' + data_type + '-id-' + group_id + '"]').val(item.val());
            root_parent.find('.hidden-info [data-id="' + data_name + '-' + data_type + '-' + group_id + '"]').val(item.val());
        });


    });

    $('.add-remove-holder').on('keyup', '.change-pagename', function () {
        // console.log('hello');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        root_parent.find('div.control-group:eq(0) [data-pagename-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-pagename-' + group_id + '"]').val($(this).val());
    });
    $('.add-remove-holder').on('keyup', '.change-phone', function () {
        console.log('hello');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        root_parent.find('div.control-group:eq(0) [data-phone-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-phone-' + group_id + '"]').val($(this).val());
    });
    $('.add-remove-holder').on('keydown', '.change-phone', function (event) {
        //if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        // console.log(event.keyCode);
        if (event.keyCode == 46 || event.keyCode == 8) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || (event.keyCode > 57 && event.keyCode < 97) || event.keyCode > 105) {
                event.preventDefault();
            }
        }
    });
    // $(".change-phone").keypress(function (e) {
    //change-signature
    //});
    $('.add-remove-holder').on('keyup', '.change-sign-value', function () {
        // console.log('i am caled');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        type_id = $(this).data('input-type');
        if (type_id == 'pic') {
            var item_id = 1;
        }
        else if (type_id == 'name') {
            var item_id = 2;

        }
        else if (type_id == 'des') {
            var item_id = 3;
        }
        root_parent.find('div.control-group:eq(0) [data-sign-item-id="' + data_type + '-id-' + group_id + item_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + item_id + '"]').val($(this).val());
    });
    $('.add-remove-holder').on('keyup', '.change-signature', function () {
        // console.log('i am caled');
        // console.log('i am caled');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        type_id = $(this).data('input-type');
        console.log(type_id);
        if (type_id == '0') {
            var item_id = 'text';
        }
        else if (type_id == '1') {
            var item_id = 'firstname';

        }
        else if (type_id == '2') {
            var item_id = 'lastname';
        }
        root_parent.find('div.control-group:eq(0) [data-signature-id="' + data_type + '-id-' + group_id + '-' + item_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-' + item_id + '-' + group_id + '"]').val($(this).val());
    });

    ////////////for file upload only sign field
    $('.add-remove-holder').on('change', '.change-file-value', function () {
        //setInterval(cbintervalFunc, 1);
        console.log('hello');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        type_id = $(this).data('input-type');
        var item_id = 1;
        root_parent.find('div.control-group:eq(0) [data-sign-item-id="' + data_type + '-id-' + group_id + item_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + item_id + '"]').val($(this).val());

    });
    $('.add-remove-holder').on('click', '.add-image', function () {

        $("#upload-image").modal();
        $(this).parent().addClass('change-image');
        $("#image-profile").val($(this).attr('data-user-id'));
        // console.log($(this).attr('data-user-id'));
        $("#user_type").val($(this).attr('data-user-type'));
        var type = $(this).attr('data-user-type');
        if (type == 'note') {
            $("#item-id").val($(this).attr('data-item-id'));
            $("#group-id").val($(this).attr('data-group-id'));
        }
        else {
            $("#item-id").val('not applicable');
            $("#group-id").val('not applicable');
        }
        $('#output').html('');
        $('#outputshow').addClass($(this).attr('data-group-id'));
        $('#outputshow').hide();
    });
    $('.add-remove-holder').on('click', '.non-consent', function () {
        console.log('clicked');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-nonconsent"]').attr('checked','checked');
        // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-consent"]').removeAttr('checked');
        // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
        root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val('');
        root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val('checked');
        $("#upload-sign").modal();
        $("#upload-sign .modal-body .sign_data_type").val(group_id);
        $("#upload-sign .modal-header .consent_header").html('Non Consent Recorded');


    });

    $('.add-remove-holder').on('click', '.btn-consent', function () {
        console.log('clicked2');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()

        // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-consent"]').attr('checked','checked');
        // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-nonconsent"]').removeAttr('checked');
        // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
        root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val('');
        root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val('checked');
        $("#upload-sign").modal();
        $("#upload-sign .modal-body .sign_data_type").val(group_id);
        $("#upload-sign .modal-header .consent_header").html('Consent Recorded');
    });
    $('#upload-sign .modal-body .removeconsent').click(function () {

        var hidden_group_id = $("#upload-sign .modal-body .sign_data_type").val();

        $('.btn-consent').each(function () {
            var this_grp_id = $(this).data('group-id');
            //  console.log(this_grp_id);
            if (this_grp_id == hidden_group_id) {
                console.log(hidden_group_id);
                var root_parent = $(this).parents('div.group-item'),
                    data_type = $(this).data('type'),
                    group_id = $(this).data('group-id');//$(this).val()
                // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-nonconsent"]').removeAttr('checked');
                // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-consent"]').removeAttr('checked');
                // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
                root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val('');
                root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val('');

            }
        });

        $("#upload-sign").modal('hide');

    });
    var cbintervalFunc = function () {
        $('#cbupload-file').val($('#cbfile-upload-btn').val());
    };

    $('.add-remove-holder').on('keyup', '.change-sign-text-value', function () {
        //  console.log('hello');
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        type_id = $(this).data('input-type');
        if (type_id == 'pic') {
            var item_id = 1;
        }
        else if (type_id == 'name') {
            var item_id = 2;
        }
        else if (type_id == 'des') {
            var item_id = 3;
        }
        var id = $(this).data('applied-for');
        console.log(id);
        root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="' + id + '"]').text($(this).val());
        // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + item_id + '"]').val($(this).val());
    });

    //operation will be occurred when click new item
    $('.add-remove-holder').on('click', '.new-item-list', function () {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id'),
            last_item_id = $('.last-item-id[data-group-id="' + group_id + '"]').data('last-item-id');
        $('.last-item-id[data-group-id="' + group_id + '"]').data('last-item-id', (last_item_id + 1));


        if (data_type == 'checkbox') {
            //change in visible section
            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .checkbox_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in hidden item
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .checkbox_hidden_label_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in wich items are checked
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .checkbox_hidden_checked_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

            //change for sliding item
            $(this).
                parents('div.item-list')
                .after(
                    draggableItem
                        .checkbox_list_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

        } else if (data_type == 'dropdown') {
            //change in visible section
            root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .dropdown_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in hidden item
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .dropdown_hidden_label_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in wich items are checked
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .dropdown_hidden_checked_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

            //change for sliding item
            $(this).
                parents('div.item-list')
                .after(
                    draggableItem
                        .dropdown_list_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

        }

        else if (data_type == 'radio') {
            //change in visible section
            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .radio_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in hidden item
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .radio_hidden_label_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in wich items are checked
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .radio_hidden_checked_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

            //change for sliding item
            $(this).
                parents('div.item-list')
                .after(
                    draggableItem
                        .radio_list_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

        } else if (data_type == 'payment-due') {
            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_disabled_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
           var payment_type = root_parent.find('.hidden-info [data-id="payment-type-' + data_type + '-text-' + group_id + 1 + '"]').val();
           var show_hide  ='';
           if(payment_type == "fixed"){
               show_hide = 'display:none';
           }
            else{
               show_hide = '';
           }
            console.log(show_hide);
            $(this).
                parents('div.payment-item-holder')
                .after(
                    draggableItem
                        .payment_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{display}/g, show_hide)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );

            //change in hidden item
            // dollar-{data_type}-text-{group_id}{item_id}

            root_parent.find('.hidden-info [data-id="payment-required-' + data_type + '-text-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_hidden_required_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            root_parent.find('.hidden-info [data-id="payment-quantity-' + data_type + '-text-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_hidden_quantity_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            root_parent.find('.hidden-info [data-id="payment-label-' + data_type + '-text-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_hidden_label_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_hidden_dollar_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );
            //change in wich items are checked
            // dollar-{data_type}-text-{group_id}{item_id}
            root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]')
                .after(
                    draggableItem
                        .payment_hidden_cent_item
                        .replace(/{group_id}/g, parseInt(group_id))
                        .replace(/{item_id}/g, parseInt(last_item_id + 1))
                        .replace(/{data_type}/g, data_type)
                        .replace(/{item_name_word}/g, toWords(parseInt(last_item_id + 1)))
                );


        }
    });


    //operation will be occurred when click remove item
    $('.add-remove-holder').on('keyup', '.cnote-textarea', function () {

        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id');//$(this).val()
        root_parent.find('div.control-group:eq(0) [data-paragraph-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
        root_parent.find('.hidden-info [data-id="' + data_type + '-paragraph-' + group_id + '"]').val($(this).val());

    });
//    function getSelectionParentElement() {
//        var parentEl = null, sel;
//        if (window.getSelection) {
//            sel = window.getSelection();
//            if (sel.rangeCount) {
//                parentEl = sel.getRangeAt(0).commonAncestorContainer;
//                if (parentEl.nodeType != 1) {
//                    parentEl = parentEl.parentNode;
//                }
//            }
//        } else if ( (sel = document.selection) && sel.type != "Control") {
//            parentEl = sel.createRange().parentElement();
//        }
//        return parentEl;
//    }
    $('.add-remove-holder').on('click', '.remove-exist-list', function () {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id');

        if (data_type == 'checkbox') {

            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();

            //change in hidden item
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]').remove();
            //change in which items are checked
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').remove();

            $(this).parents('.group-item').find('label.checkbox[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            $(this).parents('.item-list').remove();
        }
        if (data_type == 'radio') {
            if (root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val() == "checked") {


                //console.log(root_parent.find('div.item-holder').find('input.toggle-check').eq(0));
                root_parent.find('div.item-holder').find('input.toggle-check').eq(0).prop('checked', true);
                var this_group_id = root_parent.find('div.item-holder').find('input.toggle-check').eq(0).data('group-id');
                var this_item_id = root_parent.find('div.item-holder').find('input.toggle-check').eq(0).data('current-item-id');
                root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_item_id + '"]').val('checked');

            }

            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').remove();
            //  $(this).parents('.item-list');
            $(this).parents('.group-item').find('label.radio[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            $(this).parents('.item-list').remove();

        }
        if (data_type == 'payment-due') {

            var check_minus = root_parent.find('.add-button-payment[data-plus-id="add-payment-button-' + data_type + group_id + current_item_id + '"]').attr('disabled');
            if (check_minus == 'disabled') {
                var dollar_payment = root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').val();

                var cent_payment = root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').val();
                var amount = parseFloat(dollar_payment + '.' + cent_payment);
                var prev_amount = root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val();
                if (prev_amount == '') {
                    var previous_amount_float = 0.0;
                }

                else {
                    var previous_amount_float = parseFloat(prev_amount);
                    previous_amount_float -= amount;
                }
                root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(previous_amount_float.toFixed(2));
                root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(previous_amount_float.toFixed(2));

            }

            //////////////////////////////////
            root_parent.find('div.control-group:eq(0) .controls input[data-label-payment-due-id="label-payment-due-id-' + group_id + current_item_id + '"]').remove();
            root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="payment-label-' + data_type + '-text-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').remove();
            //  $(this).parents('.item-list');
            // $(this).parents('.group-item').find('label.radio[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            $(this).parents('.payment-item-holder').remove();


        }
        if (data_type == 'dropdown') {
            if (root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val() == "checked") {


                //console.log(root_parent.find('div.item-holder').find('input.toggle-check').eq(0));
                root_parent.find('div.item-holder').find('input.toggle-check').eq(0).prop('checked', true);
                var this_group_id = root_parent.find('div.item-holder').find('input.toggle-check').eq(0).data('group-id');
                var this_item_id = root_parent.find('div.item-holder').find('input.toggle-check').eq(0).data('current-item-id');
                root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_item_id + '"]').val('checked');

            }

            root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]').remove();
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').remove();
            $(this).parents('.group-item').find('label.radio[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
            $(this).parents('.item-list').remove();
        }

    });

    $('.add-remove-holder').on('click', '.toggle-check', function (ev) {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id');


        if (data_type == 'checkbox') {
            if ($(this).prop('checked')) {
                root_parent.find('div.control-group:eq(0) [data-chkbx-item-id="' + $(this).data('applied-for') + '"]').prop('checked', true);
                root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');

            } else {
                //checkbox-chkd-11
                root_parent.find('div.control-group:eq(0) [data-chkbx-item-id="' + $(this).data('applied-for') + '"]').prop('checked', false);
                root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('');
            }

        } else if (data_type == 'radio') {

            $('.toggle-check').each(function () {
                var this_group_id = $(this).data('group-id');
                var this_current_item_id = $(this).data('current-item-id');
                if (this_group_id == group_id && this_current_item_id != current_item_id) {
                    //console.log($(this).data('applied-for'));
                    $(this).removeAttr('checked');
                    root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').attr('checked', '');
                    root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').prop('checked', false);
                    root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('');
                }
                else {
                    ///console.log($(this).data('applied-for'));
                    root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').attr('checked', 'checked');
                    root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').prop('checked', true);
                    root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('checked');
                }
            });

            root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').attr('checked', 'checked');
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');


        }
        else if (data_type == 'dropdown') {

            $('.toggle-check').each(function () {
                var this_group_id = $(this).data('group-id');
                var this_current_item_id = $(this).data('current-item-id');
                if (this_group_id == group_id && this_current_item_id != current_item_id) {
                    //console.log($(this).data('applied-for'));
                    $(this).removeAttr('checked');
                    //  console.log
                    //$('select>option:eq(3)').attr('selected', true);
                    root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + this_current_item_id + '"]').removeAttr('selected');
                    root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + this_current_item_id + '"]').prop('selected', false);
                    root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('');
                }
                else if (this_group_id == group_id && this_current_item_id == current_item_id) {
                    // console.log(this_current_item_id);
                    root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + this_current_item_id + '"]').attr('selected', 'selected');
                    root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + this_current_item_id + '"]').prop('selected', true);
                    // root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + this_current_item_id + '"]').prop('selected', true);
                    ///console.log($(this).data('applied-for'));
                    root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('checked');
                }
            });
            root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + current_item_id + '"]').attr('selected', 'selected');
            //  root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').attr('checked', 'checked');
            root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');


        }
        /*else if (data_type == 'radio') {
         $(this).parents('div.controls').children('div.item-list').each(function (index, currentRadioItem) {
         $(this).find('input[type="radio"]').prop('checked', false);
         });
         $(this).prop('checked', true);
         resources\js\notes.js:3750change-paymentdescription
         }*/
    });

    $('.add-remove-holder').on('keyup', '.change-paymentdescription', function (ev) {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('item-id');
        root_parent.find('div.control-group:eq(0) .controls input[data-label-payment-due-id="label-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
        // root_parent.find('div.control-group:eq(0) .controls label[data-item-id="lb-id-' + group_id + current_item_id + '"]').remove();
        root_parent.find('.hidden-info [data-id="payment-label-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());
        // root_parent.find('div.control-group:eq(0) [data-label-payment-due-id="label-payment-due-id-' +group_id+current_item_id+ '"]').text($(this).val());

        //  root_parent.find('.hidden-info [data-id="payment-label-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());
        // console.log(current_item_id);
    });
    $('.add-remove-holder').on('keyup', '.change-payment-due', function (e) {
        var nKeyCode = e.keyCode;
        // console.log(nKeyCode);
        if ((nKeyCode > 95 && nKeyCode < 106) || (nKeyCode > 47 && nKeyCode < 58 ) || nKeyCode == 8 || nKeyCode == 46) {
            //console.log('hello');
            var root_parent = $(this).parents('div.group-item'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id'),
                current_item_id = $(this).data('current-item-id');
            //  console.log(current_item_id);
            input_type = $(this).data('name');
            if (input_type == 'dollar') {
                root_parent.find('div.control-group:eq(0) .controls input[data-dollar-payment-due-id="dollar-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
                root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());
            }
            if (input_type == 'cent') {
                if (this.value.length > 2) {
                    return;
                }
                root_parent.find('div.control-group:eq(0) .controls input[data-cent-payment-due-id="cent-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
                root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());

            }

        } else {
            e.preventDefault();
        }

    });
    $('.add-remove-holder').on('click', '.payment-radio', function (ev) {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('item-id');
        //console.log(current_item_id);
        input_type = $(this).val();
        if (input_type == 'fixed') {//disable-when-fixed
            // root_parent.find('div.control-group:eq(0) .controls input[data-dollar-payment-due-id="dollar-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
            root_parent.find('.hidden-info [data-id="payment-type-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());

            root_parent.find('span.payment-quantity').hide();
        }
        if (input_type == 'variable') {
            //root_parent.find('span.payment-icon-plus').show();
            root_parent.find('span.payment-quantity').show();
            // root_parent.find('div.control-group:eq(0) .controls input[data-cent-payment-due-id="cent-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
            root_parent.find('.hidden-info [data-id="payment-type-' + data_type + '-text-' + group_id + current_item_id + '"]').val($(this).val());

        }
    });

    $('.add-remove-holder').on('click', '.add-remove-payment', function (ev) {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id');
        //console.log(current_item_id);
        input_type = $(this).data('name');
        if (input_type == 'add-payment') {//disable-when-fixed

            var dollar_payment = root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').val();
            if (dollar_payment == '') {
                dollar_payment = 0;
            }
            // root_parent.find('div.control-group:eq(0) .controls input[data-cent-payment-due-id="cent-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
            var cent_payment = root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').val();
            if (cent_payment == '') {
                cent_payment = 0;
            }
            var amount = parseFloat(dollar_payment + '.' + cent_payment);

            var prev_amount = root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val();
            if (prev_amount == '') {
                var previous_amount_float = 0.0;
            }

            else {
                var previous_amount_float = parseFloat(prev_amount);
            }
            previous_amount_float += amount;
            root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(previous_amount_float.toFixed(2));
            root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(previous_amount_float.toFixed(2));
            //console.log(previous_amount_float);
            $(this).attr("disabled", 'disabled');
            $(this).siblings('.add-remove-payment').removeAttr('disabled');

        }
        if (input_type == 'minus-payment') {

            var dollar_payment = root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').val();

            // root_parent.find('div.control-group:eq(0) .controls input[data-cent-payment-due-id="cent-payment-due-id-' + group_id + current_item_id + '"]').val($(this).val());
            var cent_payment = root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').val();
            var amount = parseFloat(parseFloat(dollar_payment) + '.' + parseFloat(cent_payment));
            var prev_amount = root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val();
            if (amount == '') {
                var amount = parseFloat(0);
            }


            if (prev_amount == '') {
                var previous_amount_float = parseFloat(0);
            }

            else {
                var previous_amount_float = parseFloat(prev_amount);
                previous_amount_float -= amount;
            }

            root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(previous_amount_float.toFixed(2));
            root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(previous_amount_float.toFixed(2));
            //console.log(previous_amount_float);
            $(this).attr("disabled", 'disabled');
            $(this).siblings('.add-remove-payment').removeAttr('disabled');
            root_parent.find('div.control-group:eq(0) .controls input[data-dollar-payment-due-id="dollar-payment-due-id-' + group_id + current_item_id + '"]').val('');
            root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + current_item_id + '"]').val('');
            root_parent.find('div.control-group:eq(0) .controls input[data-cent-payment-due-id="cent-payment-due-id-' + group_id + current_item_id + '"]').val('');
            root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + current_item_id + '"]').val('');
            root_parent.find('.change-payment-due[data-current-item-id="' + current_item_id + '"]').val('');

        }
    });
    $('.add-remove-holder').on('keyup', '.change-list-value', function (ev) {
        var root_parent = $(this).parents('div.group-item'),

            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id');
        //console.log(current_item_id);
        root_parent.find('div.control-group:eq(0) [data-chkbx-item-text-id="' + $(this).data('applied-for') + '"]').text($(this).val());

        root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id + current_item_id + '"]').val($(this).val());
        if (data_type == 'radio') {
            root_parent.find('div.control-group:eq(0) [data-radio-item-text-id="' + $(this).data('applied-for') + '"]').text($(this).val());
        }
        if (data_type == 'dropdown') {
            root_parent.find('div.control-group:eq(0) .controls .dropdown option[data-item-id="dropdown-id-' + group_id + current_item_id + '"] ').text($(this).val());
            //root_parent.find('div.item-holder:eq(0) [data-radio-item-text-id="' + $(this).data('applied-for') + '"]').text($(this).val());
        }

    });

    $('.add-remove-holder').on('click', '.item-required', function (ev) {

        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('current-item-id');
        console.log(current_item_id);
        console.log(group_id);
        if ($(this).prop('checked')) {
            root_parent.find('.hidden-info [data-id="' + data_type + '-required-' + group_id + '"]').val('required');
        } else {
            root_parent.find('.hidden-info [data-id="' + data_type + '-required-' + group_id + '"]').val('');
        }
    });
    $('.add-remove-holder').on('click', '.change-payment-required', function (ev) {
        var root_parent = $(this).parents('div.group-item'),
            data_type = $(this).data('type'),
            group_id = $(this).data('group-id'),
            current_item_id = $(this).data('item-id');
        if ($(this).prop('checked')) {
            root_parent.find('.hidden-info [data-id="payment-required-' + data_type + '-text-' + group_id + current_item_id + '"]').val('required');
        } else {
            root_parent.find('.hidden-info [data-id="payment-required-' + data_type + '-text-' + group_id + current_item_id + '"]').val('');
        }
    });

    $('.add-remove-holder').on('click', 'i.help-popover', function (evnt) {
        //evnt.preventDefault();
        //console.log(this);
        var divPopover = $(this).next('.popover');
        if (divPopover.length == 0) {
            $('.add-remove-holder i.help-popover').each(function () {
                $(this).popover('hide');
            });
            $(this).popover('show');
        }
    });
    $('.note-popover-holder').on('click', 'i.help-popover', function (evnt) {
        //evnt.preventDefault();
        //console.log(this);
        var divPopover = $(this).next('.popover');
        if (divPopover.length == 0) {
            $('.add-remove-holder i.help-popover').each(function () {
                $(this).popover('hide');
            });
            $(this).popover('show');
        }
    });



    $( '.save-as-draft' ).on( 'click', function (ev) {
        var note_name = $('#new-note :input[name="note_name"]');
        var note_id = $('#new-note :input[name="note_id"]');
        if( !note_id.val() ) {
            return false;
        }

        if( !note_name.val() ) {
            note_name.next().html('Name of Note is Required').show();
            return false;
        }
        ev.preventDefault();
        note_status = 1;
        $( 'input[name="note_status"]' ).val( note_status );
        cnote_info.note_id = note_id.val();
        //render_dragged_item(cnote_info);
        create_json_for_note( note_id.val() );
        send_form_json();
    });

    $('#send-note-now').on('click', function (ev) {
        ev.preventDefault();
        if (disableSendNote) {
            return;
        }
        note_status = 3;
        $('input[name="note_status"]').val(note_status);
        send_form_json();
        $.ajax({
            url: site_url + 'notes/send',
            type: "POST",
            data: 'note_id=' + cnote_info.note_id,
            success: function (response_data) {
                console.log(response_data);
                if( response_data == 'true' ) {
                    $( '.send-note-message').text( 'Note send success' );
                } else if( response_data == 'false' ) {
                    $( '.send-note-message').text( 'Note send fail' );
                } else {
                    $( '.send-note-message').text( response_data );
                }
            }
        });

        /*alertify.set({
         labels: {
         ok     : "Ok",
         cancel : "Cancel"
         }
         }, { buttonReverse: true });

         alertify.confirm("If you click confirm then note will send on date of note.", function (e) {
         if (e) {
         form.submit();
         } else {
         //alertify.log("You canceled your submission");
         }
         });*/
    });

    $('#add-schedule').on('click', function () {
        note_status = 2;
        $('input[name="note_status"]').val(note_status);
    });
    $('.removeconsent').on('click', function () {


    });
    $('.cancel-schedule').on('click', function (ev) {
        ev.preventDefault();
        disableSendNote = false;
        schedule_date.setValue(now);
        reply_end_date.setValue(now);
    });

    $('.confirm-schedule').on('click', function (event) {
        event.preventDefault();
        send_form_json();
    });
    var options = {
        target: '#output',   // target element(s) to be updated with server response
        beforeSubmit: beforeSubmit,  // pre-submit callback
        success: afterSuccess,  // post-submit callback
        resetForm: true        // reset the form after successful submit
    };
    //End Drag and Drop
    $('#MyUploadForm').submit(function () {
        // console.log('hello');
        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });
    function afterSuccess(data) {
        // console.log($(".change-image img").attr('src'));

        //$(".imageloadedparentprofile").html($(".image-of-parent-profile-after-upload").clone()).html();
        var item_id = $(".image-note").data('item-id');
        var group_id = $(".image-note").data('group-id');
        var src = $(".image-note").attr('src');
        $('#outputshow').html('Upload Complete');
        $('#outputshow').show();
        $('.cnote_sign_image').each(function () {
            var group_id_img = $(this).data('group-id');
            if (group_id_img == group_id) {
                var data_type = 'sign';

                //var root_parent = $('#add-image').parents('div.group-item');
                // root_parent.find('div.control-group:eq(0) [data-sign-item-id="' + data_type + '-id-' + group_id +item_id+ '"]').val(src);
                //root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id +item_id+'"]').val(src);
                // $(".change-image img").attr('src',$("#image-of-parent-profile-after-upload").attr('src'));
                //root_parent.find('div.item-holder:eq(0) [data-sign-item-id="' + data_type + '-id-' + group_id +item_id+ '"]').val(src);
                var img = '<img class ="cnote_sign" src="' + src + '"/>';
                $(this).html(img);
                var root_parent = $(this).parents('div.group-item');
                root_parent.find('div.control-group:eq(0) [data-sign-item-id="' + data_type + '-id-' + group_id_img + item_id + '"]').val(src);
                root_parent.find('.hidden-info [data-id="' + data_type + '-item-label-' + group_id_img + item_id + '"]').val(src);


            }
            //console.log(group_id_img);
            // cnote_sign_image
        });

        //  $("#cnote_sign").attr('src',$("#image-of-parent-profile-after-upload").attr('src'));
        $(".change-image").removeClass("change-image");
        $('#submit-btn').show(); //hide submit button
        $('#loading-img').hide(); //hide submit button


    }

//function to check file size before uploading.
    function beforeSubmit() {
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob) {

            if (!$('#imageInput').val()) //check empty input filed
            {
                $("#output").html("Are you kidding me?");
                return false
            }

            var fsize = $('#imageInput')[0].files[0].size; //get file size
            var ftype = $('#imageInput')[0].files[0].type; // get file type


            //allow only valid image file types
            switch (ftype) {
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                    break;
                default:
                    $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
                    return false
            }

            //Allowed file size is less than 1 MB (1048576)
            if (fsize > 1048576) {
                $("#output").html("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }

            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");
        }
        else {
            //Output error to older unsupported browsers that doesn't support HTML5 File API
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
        }
    }

//function to format bites bit.ly/19yoIPO
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Bytes';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }


    //Note Tab Wizard
    $('#note-wizard').bootstrapWizard({
        'nextSelector': '.breadcumb-wizard li.next',
        'previousSelector': '.breadcumb-wizard li.previous',
        'tabClass': 'nav nav-tabs',
        'onInit': function (tab, navigation, index) {

            render_preview_form(cnote_info);
            render_dragged_item(cnote_info);
        },
        'onTabClick': function (tab, navigation, index) {
            return false;
        },

        'onNext': function (tab, navigation, index) {
            var error = false,
                note_id = $('#new-note :input[name="note_id"]'),
                note_name = $('#new-note :input[name="note_name"]'),
                schedule_date = $('#new-note :input[name="schedule_date"]'),
                note_details = $('#new-note :input[name="note_details"]'),

                val_note_id = note_id.val(),
                val_note_name = note_name.val(),
                val_schedule_date = schedule_date.val(),
                val_note_details = note_details.val();

            if (!val_note_id) {
                error = true;
            }

            if (!val_note_name) {
                note_name.next().html('Name of Note is Required').show();
                error = true;
            } else {
                note_name.next().html('').hide();
            }

            if (!val_schedule_date) {
                schedule_date.parents('div:eq(0)').next().html('This Field id Required').show();
                error = true;
            } else {
                schedule_date.parents('div:eq(0)').next().html('').hide();
            }

            if (error) {
                return false;
            }


            if (index == 1) {

                //$('#new_note_submit').click();
                cnote_info.note_id = val_note_id;
                //render_dragged_item(cnote_info);
                create_json_for_note(val_note_id);
                render_preview_form(cnote_info, val_note_name);
                
                //console.log($( 'div#tab_preview_note #preview-note-wizard' ));
            }

            if (index == 2) {
                //console.log(val_note_name);
                $('.send-note-message').html(
                    draggableItem
                        .send_note_message_for_school
                        .replace(/{note_title}/g, val_note_name)
                        .replace(/{number_of_receivers}/g, 0)
                );
            }

            return true;
        },

        'onPrevious': function (tab, navigation, index) {

            /*if( index < 1) {
             $('.draggable').removeClass('draggable-item-list');
             }*/
            //console.log(index);
        }
    });


    //End Tab Wizard

    //by ridhia
    //i have commented this lines cause on click create note send tab was active
    //if (set_tab_to_send_note) {
    // $('#note-wizard').bootstrapWizard('show', 3);
    //}
    /*if ( typeof set_tab_to_send_note != 'undefined' ) {
     $('#note-wizard').bootstrapWizard('show', 3);
     }*/


    /*if (typeof public_preview != 'undefined' && public_preview == true) {
        //render_preview_form(cnote_info, cnote_info.note_name);
    }*/

    if (typeof set_tab_to_preview_note != 'undefined' && set_tab_to_preview_note == true) {
        $('#note-wizard').bootstrapWizard('show', 1);
    }
    if (typeof edit_note_preview != 'undefined' && edit_note_preview == true) {
        render_preview_form(cnote_info, cnote_info.note_name);
    }

    if (typeof reply_preview != 'undefined' && reply_preview == true) {
        render_reply_form(cnote_info, cnote_info.note_name);

        $('#response-form').on('click', 'input.checkbox', function (evnt) {
            var root_parent = $(this).parents('div.control-group'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id'),
                current_item_id = $(this).data('item-id');
            if (data_type == 'checkbox') {
                if ($(this).prop('checked')) {
                    //$(this).prop('checked', true);
                    root_parent.find('.hidden-info input[data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');
                } else {
                    //$(this).prop('checked', false);
                    root_parent.find('.hidden-info input[data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('');
                }
            }

        });

        $('#response-form').on('change', '.reply-change-dropdown', function (evnt) {
            //  console.log('i got it');
            var root_parent = $(this).parents('div.control-group'),
                data_type = $(this).find(':selected').data('type'),
                group_id = $(this).find(':selected').data('group-id'),
                current_item_id = $(this).find(':selected').data('item-id');


            if (data_type == 'dropdown') {

                $('.dropdown-hidden').each(function () {

                    var this_group_id = $(this).data('group-id');
                    var this_current_item_id = $(this).data('item-id');
                    //console.log(this_group_id);
                    //console.log(group_id);
                    // console.log(this_current_item_id);
                    // console.log(current_item_id);

                    if (this_group_id == group_id && this_current_item_id != current_item_id) {
                        $(this).val('');
                        // console.log('i got it'+this_group_id+this_current_item_id);

                    }
                    else if (this_group_id == group_id && this_current_item_id == current_item_id) {
                        // $(this).attr('checked','checked');

                        // {
                        $(this).val('checked');
                        // }

                    }
                });

                console.log(root_parent.find('.hidden-info input[data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val());

            }

        });
        $('#response-form').on('click', 'input.radio', function (evnt) {
            var root_parent = $(this).parents('div.control-group'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id'),
                current_item_id = $(this).data('item-id');
            // console.log(data_type);
            if (data_type == 'radio') {

                $('.change-radio').each(function () {

                    var this_group_id = $(this).data('group-id');
                    var this_current_item_id = $(this).data('item-id');
                    //  console.log(this_group_id); console.log(this_current_item_id);
                    if (this_group_id == group_id && this_current_item_id != current_item_id) {
                        //console.log(this_current_item_id);
                        $(this).removeAttr('checked');
                        root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('');
                    }
                    else {
                        root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + this_group_id + this_current_item_id + '"]').val('checked');
                    }
                });

                root_parent.find('div.control-group:eq(0) [data-radio-item-id="' + $(this).data('applied-for') + '"]').attr('checked', 'checked');
                root_parent.find('.hidden-info [data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');

                /* if ($(this).prop('checked')) {
                 //$(this).prop('checked', true);
                 root_parent.find('.hidden-info input[data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('checked');
                 } else {
                 //$(this).prop('checked', false);
                 root_parent.find('.hidden-info input[data-id="' + data_type + '-chkd-' + group_id + current_item_id + '"]').val('');
                 }*/
            }

        });
        $('#response-form').on('click', '.non-consent', function () {
            // console.log('clicked');
            var root_parent = $(this).parents('div.group-item-signature'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-nonconsent"]').attr('checked','checked');
            // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-consent"]').removeAttr('checked');
            // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
            root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val('');
            root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val('checked');
            $("#upload-sign").modal();
            $("#upload-sign .modal-body .sign_data_type").val(group_id);
            $("#upload-sign .modal-header .consent_header").html('Non Consent Recorded');


        });
        $('#response-form').on('keyup', '.change-signature', function () {
            // console.log('i am caled');
            // console.log('i am caled');
            var root_parent = $(this).parents('div.group-item-signature'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            type_id = $(this).data('input-type');
            console.log(type_id);
            if (type_id == '0') {
                var item_id = 'text';
            }
            else if (type_id == '1') {
                var item_id = 'firstname';

            }
            else if (type_id == '2') {
                var item_id = 'lastname';
            }
            //root_parent.find('div.control-group:eq(0) [data-signature-id="' + data_type + '-id-' + group_id +'-'+item_id+ '"]').val($(this).val());
            root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-' + item_id + '-' + group_id + '"]').val($(this).val());
        });

        $('#response-form').on('click', '.btn-consent', function () {
            //console.log('clicked2');
            var root_parent = $(this).parents('div.group-item-signature'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()

            // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-consent"]').attr('checked','checked');
            // root_parent.find('div.control-group:eq(0) [data-signature-id="signature-id-' +group_id+ '-nonconsent"]').removeAttr('checked');
            // root_parent.find('div.control-group:eq(0) [data-sign-item-text-id="'+id+'"]).val($(this).val());
            root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-non-consent-' + group_id + '"]').val('');
            root_parent.find('.hidden-info [data-id="hidden-' + data_type + '-consent-' + group_id + '"]').val('checked');
            $("#upload-sign").modal();
            $("#upload-sign .modal-body .sign_data_type").val(group_id);
            $("#upload-sign .modal-header .consent_header").html('Consent Recorded');
        });
        $('#response-form').on('keyup', '.disable-remark', function () {
            //console.log('hello there');
            var root_parent = $(this).parents('div.group-item-remark'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');
            root_parent.find('.hidden-info [data-id="' + data_type + '-remark-' + group_id + '"]').val($(this).val());
        });
        $('#response-form').on('keyup', '.change-address', function () {
            // console.log(input_id);
            var root_parent = $(this).parents('div.all_address_box'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');
            input_type = $(this).data('input-type');

            switch (input_type) {
                case 'streetaddress':
                    // console.log($(this).val());
                    // console.log(  root_parent.find('.hidden-info [data-id="street-'+ data_type + '-text-'+ group_id +'"]').val());
                    root_parent.find('.hidden-info [data-id="street-' + data_type + '-text-' + group_id + '"]').val($(this).val());
                    break;
                case 'addressline2':
                    root_parent.find('.hidden-info [data-id="address-' + data_type + '-text-' + group_id + '"]').val($(this).val());
                    break;
                case 'city':
                    root_parent.find('.hidden-info [data-id="city-' + data_type + '-text-' + group_id + '"]').val($(this).val());

                    break;
                case 'state':
                    root_parent.find('.hidden-info [data-id="state-' + data_type + '-text-' + group_id + '"]').val($(this).val());
                    break;
                case 'zip':
                    root_parent.find('.hidden-info [data-id="postalcode-' + data_type + '-text-' + group_id + '"]').val($(this).val());
                    break;
                case 'country':
                    console.log(data_type);
                    console.log(group_id);
                    // console.log(root_parent.find('.hidden-info [data-id="test-'+ data_type + '-text-'+ group_id +'"]').val());
                    root_parent.find('.hidden-info [data-id="country-' + data_type + '-text-' + group_id + '"] ').val($(this).val());
                    break;
                default :
                    break;

            }

            //root_parent.find('.hidden-info [data-id="'+ data_type + '-remark-'+ group_id +'"]').val($(this).val());
        });
        $('#response-form').on('keyup mouseup', '.change-text', function () {
            //console.log('hello');
            var root_parent = $(this).parents('div.group-item-change'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            // root_parent.find('div.control-group:eq(0) [data-textbox-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
            if (data_type == "phone")  root_parent.find('.hidden-info [data-id="' + data_type + '-phone-' + group_id + '"]').val($(this).val());
            else if (data_type == "number")  root_parent.find('.hidden-info [data-id="' + data_type + '-number-' + group_id + '"]').val($(this).val());
            else if (data_type == "email") root_parent.find('.hidden-info [data-id="' + data_type + '-email-' + group_id + '"]').val($(this).val());

        });
        $('#response-form').on('keyup', '.change-name-data', function () {
            //console.log('hello');
            var root_parent = $(this).parents('div.group-item-change'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            input_type = $(this).data('input-type');
            // root_parent.find('div.control-group:eq(0) [data-textbox-id="' + data_type + '-id-' + group_id + '"]').val($(this).val());
            if (input_type == "firstname")  root_parent.find('.hidden-info [data-id="' + data_type + '-first-name-' + group_id + '"]').val($(this).val());
            else if (input_type == "lastname")  root_parent.find('.hidden-info [data-id="' + data_type + '-last-name-' + group_id + '"]').val($(this).val());


        });
        $('#response-form').on('keyup mouseup', '.change-payment-quantity', function (e) {
            //console.log('hello');

            var root_parent = $(this).parents('div.payment-due-parent-view'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id');//$(this).val()
            input_id = $(this).data('current-item-id');
            root_parent.find('.hidden-info [data-id="payment-quantity-' + data_type + '-text-' + group_id + input_id + '"]').val($(this).val());
            var unit_dollar = root_parent.find('.hidden-info [data-id="dollar-' + data_type + '-text-' + group_id + input_id + '"]').val();
            var unit_cent = root_parent.find('.hidden-info [data-id="cent-' + data_type + '-text-' + group_id + input_id + '"]').val();
            var item_unit = parseFloat(parseFloat(unit_dollar) + '.' + parseFloat(unit_cent));
            root_parent.find('.hidden-info [data-id="item-total-' + data_type + '-text-' + group_id + input_id + '"]').val($(this).val() * item_unit);
            var new_total = parseFloat(0);
            $('.change-payment-required').each(function () {
                if ($(this).prop('checked')) {
                    var _data_type = $(this).data('type'),
                        _group_id = $(this).data('group-id'),
                        _current_item_id = $(this).data('item-id');
                    var item_total = root_parent.find('.hidden-info [data-id="item-total-' + _data_type + '-text-' + _group_id + _current_item_id + '"]').val();
                    new_total += parseFloat(item_total);
                }
            });
            root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(new_total.toFixed(2));
            root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(new_total.toFixed(2));
            //console.log();
        });
        $('#response-form').on('click', '.change-payment-required', function (ev) {
            var root_parent = $(this).parents('div.payment-due-parent-view'),
                data_type = $(this).data('type'),
                group_id = $(this).data('group-id'),
                current_item_id = $(this).data('item-id');
            var new_total = parseFloat(0);
            $('.change-payment-required').each(function () {
                if ($(this).prop('checked')) {
                    var _data_type = $(this).data('type'),
                        _group_id = $(this).data('group-id'),
                        _current_item_id = $(this).data('item-id');
                    var item_total = root_parent.find('.hidden-info [data-id="item-total-' + _data_type + '-text-' + _group_id + _current_item_id + '"]').val();
                    new_total += parseFloat(item_total);
                }
            });
            root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(new_total.toFixed(2));
            root_parent.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(new_total.toFixed(2));
            //console.log(new_total);
            if ($(this).prop('checked')) {
                root_parent.find('.hidden-info [data-id="payment-required-' + data_type + '-text-' + group_id + current_item_id + '"]').val('required');
                /* var item_total =  root_parent.find('.hidden-info [data-id="item-total-' + data_type + '-text-' + group_id +current_item_id+ '"]').val();
                 var prev_total =  root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val();

                 prev_total =parseFloat(prev_total).toFixed(2);
                 item_total =parseFloat(item_total).toFixed(2);
                 prev_total += item_total;

                 prev_total = (prev_total).toFixed(2);
                 root_parent.find('.hidden-info [data-id="item-total-' + data_type + '-text-' + group_id +current_item_id+ '"]').val('');
                 root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(prev_total);
                 root_pare*///nt.find('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(prev_total);
            } else {
                root_parent.find('.hidden-info [data-id="payment-required-' + data_type + '-text-' + group_id + current_item_id + '"]').val('');
                /* var item_total =  root_parent.find('.hidden-info [data-id="item-total-' + data_type + '-text-' + group_id +current_item_id+ '"]').val();
                 var prev_total =  root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val();
                 prev_total =parseFloat(prev_total).toFixed(2);
                 item_total =parseFloat(item_total).toFixed(2);

                 prev_total -= item_total;
                 prev_total = (prev_total).toFixed(2);
                 root_parent.find('.hidden-info [data-id="item-total-' + data_type + '-text-' + group_id +current_item_id+ '"]').val('');
                 root_parent.find('.hidden-info [data-id="' + data_type + '-total-payment-' + group_id + '"]').val(prev_total);
                 root_parent.find*///('.total-item-holder [data-total-item="total-amount-' + group_id + data_type + '"]').val(prev_total);
            }
        });
        $('#response-form').on('click', '#reply-btn', function (evnt) {
            evnt.preventDefault();
            if (cnote_info.note_response_id.length < 32) {
                //console.log('no response id');
                return false;
            }
           var all_filled =true;
           $('.need-to-fill-up').each(function(){
               console.log($(this).val());
                   if($(this).val()==''){
                       $('div.alert-msg').removeClass('hidden');
                       $('div.alert-msg').addClass('alert-error');
                       $('strong.msg-type').empty().text('Error!Fill Up All Required Fields ');
                       all_filled =false;

                   }
               else{
                       $('div.alert-msg').addClass('alert-success');
                   }
           });
            if(all_filled){
                create_json_for_response(cnote_info.note_id);
                //console.log('info to sent'+cnote_response_info);
                $.ajax({
                    url: site_url + 'note/reply/' + cnote_info.note_response_id,
                    type: "POST",
                    data: 'note_response_json=' + JSON.stringify(cnote_response_info),
                    success: function (response_data) {
                        //console.log(response_data);
                        $('div.alert-msg').removeClass('hidden');
                        if (response_data.return_type == false) {
                            $('div.alert-msg').addClass('alert-error');
                            $('strong.msg-type').empty().text('Error! ');
                        } else {
                            $('div.alert-msg').addClass('alert-success');
                            $('strong.msg-type').empty().text('Success! ');
                        }
                        $('span.msg').empty().text(response_data.return_message);
                    }
                });
            }

        });

    };

    if (typeof public_preview != 'undefined' && public_preview == true) {
        render_preview_form_for_public(cnote_info, cnote_info.note_name);
    }

    $('#preview-note-wizard').bootstrapWizard({
        'tabClass': 'nav nav-tabs',

        'onInit': function (tab, navigation, index) {
            if (typeof public_preview != 'undefined' && public_preview == true) {
                //render_preview_form_for_public(cnote_info, cnote_info.note_name);
                $( '.total-page' ).text( tab_counter );
                $( '.current-page').text( (index + 1) );
            }
        },

        'onNext': function (tab, navigation, index) {
            if( index >= tab_counter ) {
                return false;
            } else {
                $( '.current-page').text( (index + 1) );
            }
        },

        'onPrevious': function (tab, navigation, index) {
            if( index < 0 ) {
                return false;
            } else {
                $( '.current-page').text( (index + 1) );
            }
        }

    });


    $(window).scroll( function() {
        if( $( window ).scrollTop() > 460 ) {
            if( !$( '#cbsidebar-nav').hasClass('drag-position') ) {
                $( '#cbsidebar-nav').addClass('drag-position');
            }
        } else {
            $( '#cbsidebar-nav').removeClass('drag-position');
        }
    });

});