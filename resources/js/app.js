/**
 * Created by Sudarshan Biswas on 11/26/13.
 */




//My own written form validation function
/*******************************************************
 * *****************************************************
 * *****************************************************
 * *****************************************************
 */


var FormValidation = {
    currentValidationPoint: '',
    originalValue: '',
    valueAfterValidation: '',
    result: true,
    validation: true,
    validationResult: [],
    optional: true,

    freeValidationResult: function() {
        this.validationResult = [];
    },

    init: function() {
        this.currentValidationPoint = '';
        this.originalValue = '';
        this.valueAfterValidation = '';
        this.result = true;
        this.optional = true;
    },

    valid: function() {
        return this.validation;
    },



    trim: function() {
        if(this.valueAfterValidation === '') {
            this.valueAfterValidation = $.trim(this.originalValue);
        } else {
            this.valueAfterValidation = $.trim(this.valueAfterValidation);
        }
        return true;
    },

    required: function() {
        this.optional = false;
        if(this.originalValue === '' || this.originalValue.length === 0) {
            this.currentValidationPoint = 'required';this.result = false;
            return false;
        } else {
            this.valueAfterValidation = this.valueAfterValidation;this.result = true;
            return true;
        }
    },

    email: function() {
        if(this.optional && this.originalValue === '') {
            this.valueAfterValidation = this.valueAfterValidation;this.result = true;
            return true;
        } else {
            if(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(this.originalValue)) {
                this.valueAfterValidation = this.valueAfterValidation;this.result = true;
                return true;
            } else {
                this.currentValidationPoint = 'required';this.result = false;
                return false;
            }
        }
    },

    url: function() {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(this.originalValue);
    },

    numeric: function() {
        if(this.optional && this.originalValue === '') {
            this.valueAfterValidation = this.originalValue;this.result = true;
            return true;
        } else {
            if(!$.isNumeric(this.originalValue)) {
                this.currentValidationPoint = 'numeric';this.result = false;
                return false;
            } else {
                this.valueAfterValidation = this.originalValue;this.result = true;
                return true;
            }
        }
    },

    number: function() {
        return /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/i.test(this.originalValue);
    },

    alpha: function() {
        return /^[a-zA-Z]?$/i.test(this.originalValue);
    },

    alphaNumeric: function() {
        return /^[a-zA-Z0-9]?$/i.test(this.originalValue);
    }
};

var defaultValidationRules = {
    input: {
        //type: 'text',
        trim: false,
        required: false,
        numeric: false,
        email: false,
        html: false,
        url: false,
        alpha: false,
        alphaNumeric: true,
        checked: false,
        filter: false
    },

    select: {
        //type: 'text',
        required: false,
        numeric: false,
        email: false,
        html: false,
        url: false,
        alpha: false,
        alphaNumeric: true,
        filter: false
    },

    checkbox: {
        //type: 'text',
        required: false,
        numeric: false,
        email: false,
        html: false,
        url: false,
        alpha: false,
        alphaNumeric: false,
        filter: false
    }
};

var findIndexOf = function(validationResultList, selector){
    for( var i=0; i<validationResultList.length; i++) {
        if(validationResultList[i].selector == selector) { return i;}
    }
    return -1;
};

var validationProcess = function(value, formValidationRules) {
    for(var key in formValidationRules) {//'key=field:name:id', value = Object of rules
        if( defaultValidationRules.hasOwnProperty(formValidationRules.field) ) { //formValidationRules.field = input; formValidationRules.field = select
            if(defaultValidationRules[formValidationRules.field].hasOwnProperty(key)) {
                defaultValidationRules[formValidationRules.field][key] = formValidationRules[key];
            }
        } else {

        }
    }

    var IndexOf = findIndexOf(FormValidation.validationResult, value.selector);

    if(IndexOf == -1) {
        FormValidation.validationResult.push({
            validate: FormValidation.result,
            selector: value.selector,
            value: FormValidation.valueAfterValidation,
            validationBreakPoint: []
        });
    }

    /*_.find(FormValidation.validationResult, function(item) {
     if(item.selector == value.selector) {
     FormValidation.validationResult.push({
     validate: FormValidation.result,
     selector: value.selector,
     value: FormValidation.valueAfterValidation,
     validationBreakPoint: []
     });
     }
     });*/


    for(var rules in defaultValidationRules[formValidationRules.field]) {//formValidationRules.field = input, select, checkbox
        if( FormValidation.hasOwnProperty(rules) && defaultValidationRules[formValidationRules.field][rules]) {
            FormValidation.originalValue = $(value.selector).val();
            if( !FormValidation[rules]() ) {
                if(IndexOf === -1) {
                    FormValidation.validationResult[(FormValidation.validationResult.length-1)].validate = FormValidation.result;
                    FormValidation.validationResult[(FormValidation.validationResult.length-1)].value = FormValidation.valueAfterValidation;
                    FormValidation.validationResult[(FormValidation.validationResult.length-1)].validationBreakPoint.push(FormValidation.currentValidationPoint);
                } else {
                    FormValidation.validationResult[IndexOf].validate = FormValidation.result;
                    FormValidation.validationResult[(FormValidation.validationResult.length-1)].value = FormValidation.valueAfterValidation;
                    FormValidation.validationResult[IndexOf].validationBreakPoint.push(FormValidation.currentValidationPoint);
                }
            } else {
                if(IndexOf !== -1) {
                    FormValidation.validationResult[IndexOf].validate = FormValidation.result;
                    FormValidation.validationResult[(FormValidation.validationResult.length-1)].value = FormValidation.valueAfterValidation;
                    FormValidation.validationResult[IndexOf].validationBreakPoint = [];
                } else {

                }
            }
        }
    }

    var flagForFormValidation = true;
    for(var indexOfValidationResult in FormValidation.validationResult) {
        if(FormValidation.validationResult[indexOfValidationResult].validate === false) {
            flagForFormValidation = false;
        }
    }

    FormValidation.validation = (flagForFormValidation) ? true : false;

    FormValidation.init();
    return FormValidation;
};

var validateForm = function(selector, validationRules, callback_func) {//section_member_first_name,
    var validationStatus = false;
    if(!validationRules.hasOwnProperty('rules')) {
        alert('Validation rules are not set.');
        return callback_func(false);
    }
    FormValidation.freeValidationResult();
    validationRules.rules.forEach(function(value, index) {
        if( !value.hasOwnProperty('field') && ( !value.hasOwnProperty('id') && !value.hasOwnProperty('name') ) ) {
            alert('Validation rules are not set correctly.');
            return callback_func(false);
        }

        var selector = (value.hasOwnProperty('id') && (typeof value.id != 'undefined' && value.id !== false)) ? value.id : value.name;
        if(typeof selector == 'undefined' || selector === false || selector === null) {
            alert('Selector is not defined.');
            return callback_func(false);
        } else {
            var selectorObject = $('#'+selector);
            if(selectorObject.length === 0) {
                value.selector = value.field+'[name='+selector+']';
                //validationProcess(value, validationRules);
            } else {
                value.selector = value.field+'#'+selector;
                validationStatus = validationProcess(value, validationRules.rules[index]);
            }
        }
    });

    return callback_func(validationStatus);
};


/***********************************************************
 * *********************************************************
 * *********************************************************
 * *********************************************************
 * *********************************************************
 */


jQuery( document ).ready(function( $ ) {

    $('#price-switch .price-toggle-btn').click(function() {
        if ( $( this ).parent().hasClass( "switch-on" ) ) {
            $( this ).parent().removeClass("switch-on").addClass("switch-off");
        } else {
            $( this ).parent().removeClass("switch-off").addClass("switch-on");
        }
    });

    $('.read-more').click(function() {
        $feature_description = $(this).parents('.row-fluid:eq(0)').prev().find('.feature-list-description');
        //$(this).parents('.row-fluid:eq(0)').prev().find('.feature-list-content-container').remove();//.children('.feature-list-description').html('Test');
        if($(this).hasClass('not-expanded')) {
            $(this).removeClass('not-expanded').text('OK. Got it!');
            var des_height = $feature_description.css('height', 'auto').height(); // get real height
            $feature_description.css('height','40px');
            $feature_description.animate({
                height: des_height+'px'
            }, 200);
        } else {
            $(this).addClass('not-expanded').text('Learn More?');
            $feature_description.animate({
                height: '40px'
            }, 200 );
        }
        return false;
    });

    //$('div.feature-block-single a').smoothScroll();

    $('.have-account').click(function() {
       $(this).parents('form').hide().prev().fadeIn(1000);
       return false;
    });

    $('.forgot-password').click(function() {
       $(this).parents('form').hide().next().fadeIn(1000);
       return false;
    });
});

