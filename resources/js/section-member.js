/**
 * Created by Sudarshan Biswas on 1/9/14.
 */


jQuery(document).ready(function($) {

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
            //console.log(this.originalValue);
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
            numeric: true,
            email: false,
            html: false,
            url: false,
            alpha: true,
            alphaNumeric: true,
            checked: true,
            filter: false
        },

        select: {
            //type: 'text',
            required: false,
            numeric: false,
            email: false,
            html: false,
            url: false,
            alpha: true,
            alphaNumeric: false,
            filter: false
        },

        checkbox: {
            //type: 'text',
            required: false,
            numeric: false,
            email: false,
            html: false,
            url: false,
            alpha: true,
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

    $('#new-section-member-wizard').bootstrapWizard({
        tabClass: 'nav nav-tabs',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var validationRules;
            if((index-1) === 0) {
                validationRules = {
                    rules: [{
                        field: 'input',
                        name: 'section_member_first_name',
                        id: 'section_member_first_name',
                        required: true,
                        email: false,
                        html: false,
                        url: true,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_last_name',
                        id: 'section_member_last_name',
                        required: true,
                        trim: true,
                        alpha: true
                    }, {
                        field: 'select',
                        name: 'section_member_section_id',
                        id: 'section_member_section_id',
                        required: true,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: true,
                        trim: false
                    }]
                };
            } else {
                validationRules = {
                    rules: [{
                        field: 'input',
                        name: 'section_member_fathers_first_name',
                        id: 'section_member_fathers_first_name',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_last_name',
                        id: 'section_member_fathers_last_name',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_email',
                        id: 'section_member_fathers_email',
                        required: false,
                        email: true,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_phone_work',
                        id: 'section_member_fathers_phone_work',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_phone_home',
                        id: 'section_member_fathers_phone_home',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_mobile',
                        id: 'section_member_fathers_mobile',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_first_line_address',
                        id: 'section_member_fathers_first_line_address',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_second_line_address',
                        id: 'section_member_fathers_second_line_address',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_zip_code',
                        id: 'section_member_fathers_zip_code',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_fathers_city_name',
                        id: 'section_member_fathers_city_name',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'select',
                        name: 'section_member_fathers_country_id',
                        id: 'section_member_fathers_country_id',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'select',
                        name: 'section_member_fathers_state_id',
                        id: 'section_member_fathers_state_id',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_first_name',
                        id: 'section_member_mothers_first_name',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_last_name',
                        id: 'section_member_mothers_last_name',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_email',
                        id: 'section_member_mothers_email',
                        required: false,
                        email: true,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_phone_work',
                        id: 'section_member_mothers_phone_work',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_phone_home',
                        id: 'section_member_mothers_phone_home',
                        required: false,
                        email: false,
                        html: false,
                        url: true,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: true
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_mobile',
                        id: 'section_member_mothers_mobile',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_first_line_address',
                        id: 'section_member_mothers_first_line_address',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_second_line_address',
                        id: 'section_member_mothers_second_line_address',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_zip_code',
                        id: 'section_member_mothers_zip_code',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: true,
                        alpha: false,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'input',
                        name: 'section_member_mothers_city_name',
                        id: 'section_member_mothers_city_name',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: false,
                        alphaNumeric: true,
                        trim: false
                    }, {
                        field: 'select',
                        name: 'section_member_mothers_country_id',
                        id: 'section_member_mothers_country_id',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: false
                    }, {
                        field: 'select',
                        name: 'section_member_mothers_state_id',
                        id: 'section_member_mothers_state_id',
                        required: false,
                        email: false,
                        html: false,
                        url: false,
                        numeric: false,
                        alpha: true,
                        alphaNumeric: false,
                        trim: false
                    }/*, {
                     field: 'select',
                     name: 'section_member_mothers_timezone_id',
                     id: 'section_member_mothers_timezone_id',
                     required: false,
                     email: false,
                     html: false,
                     url: false,
                     numeric: false,
                     alpha: false,
                     alphaNumeric: false,
                     trim: false
                     }*/]
                };
            }

            return validateForm(navigation.children().eq(index-1).children().attr('href'), validationRules, function(formValidationObject) {
                //return true;
                console.log(formValidationObject);
                if(!formValidationObject.valid()) {
                    for(var list in formValidationObject.validationResult) {
                        if(!formValidationObject.validationResult[list].validate) {
                            $(formValidationObject.validationResult[list].selector).parents('div.control-group').removeClass('success').addClass('error');
                        } else {
                            $(formValidationObject.validationResult[list].selector).parents('div.control-group').removeClass('error').addClass('success');
                        }
                    }
                    return formValidationObject.valid();
                } else {
                    for(var list in formValidationObject.validationResult) {
                        $(formValidationObject.validationResult[list].selector).parents('div.control-group').removeClass('error').addClass('success');
                    }
                    return formValidationObject.valid();
                }
            });
        },
        onPrevious: function(tab, navigation, index) {
            //console.log(index);
        }
    });

    $('#add-student').on('click', function(event) {
        var formElm = $(this).parents('form');
        event.preventDefault();

        if( $('#section_member_caregivers_if_available').is(':checked') ) {
            console.log('checked');
            var validationRules = {
                rules: [{
                    field: 'input',
                    name: 'section_member_caregivers_first_name',
                    id: 'section_member_caregivers_first_name',
                    required: false,
                    email: false,
                    html: false,
                    url: true,
                    numeric: false,
                    alpha: true,
                    alphaNumeric: false,
                    trim: true
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_last_name',
                    id: 'section_member_caregivers_last_name',
                    required: false,
                    email: false,
                    html: false,
                    url: true,
                    numeric: false,
                    alpha: true,
                    alphaNumeric: false,
                    trim: true
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_email',
                    id: 'section_member_caregivers_email',
                    required: false,
                    email: true,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: false,
                    alphaNumeric: false,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_phone_work',
                    id: 'section_member_caregivers_phone_work',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: true,
                    alpha: false,
                    alphaNumeric: false,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_phone_home',
                    id: 'section_member_caregivers_phone_home',
                    required: false,
                    email: false,
                    html: false,
                    url: true,
                    numeric: true,
                    alpha: false,
                    alphaNumeric: false,
                    trim: true
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_mobile',
                    id: 'section_member_caregivers_mobile',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: true,
                    alpha: false,
                    alphaNumeric: false,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_first_line_address',
                    id: 'section_member_caregivers_first_line_address',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: false,
                    alphaNumeric: true,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_second_line_address',
                    id: 'section_member_caregivers_second_line_address',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: false,
                    alphaNumeric: true,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_zip_code',
                    id: 'section_member_caregivers_zip_code',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: true,
                    alpha: false,
                    alphaNumeric: false,
                    trim: false
                }, {
                    field: 'input',
                    name: 'section_member_caregivers_city_name',
                    id: 'section_member_caregivers_city_name',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: false,
                    alphaNumeric: true,
                    trim: false
                }, {
                    field: 'select',
                    name: 'section_member_caregivers_country_id',
                    id: 'section_member_caregivers_country_id',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: true,
                    alphaNumeric: false,
                    trim: false
                }, {
                    field: 'select',
                    name: 'section_member_caregivers_state_id',
                    id: 'section_member_caregivers_state_id',
                    required: false,
                    email: false,
                    html: false,
                    url: false,
                    numeric: false,
                    alpha: true,
                    alphaNumeric: false,
                    trim: false
                }]
            };

            validateForm('#section-member-caregiver-info', validationRules, function(formValidationObject) {
                //return true;
                console.log(formValidationObject);
                if(!formValidationObject.valid()) {
                    for(var list in formValidationObject.validationResult) {
                        if(!formValidationObject.validationResult[list].validate) {
                            $(formValidationObject.validationResult[list].selector).parents('div.control-group').removeClass('success').addClass('error');
                        } else {
                            $(formValidationObject.validationResult[list].selector).parents('div.control-group').removeClass('error').addClass('success');
                        }
                    }
                    //return formValidationObject.valid();
                } else {
                    formElm.submit();
                }
            });
        } else {
            console.log('not checked');
            formElm.submit();
        }
    });
    
    
    
    
    //smooth scroll
    /*
    var top = 0,
        step = 55,
        viewport = $(window).height(),
        console.log($.browser);
        body = $.browser.webkit ? $('body') : $('html'),
        wheel = false;


    $('body').mousewheel(function(event, delta) {

        wheel = true;

        if (delta < 0) {

            top = (top+viewport) >= $(document).height() ? top : top+=step;

            body.stop().animate({scrollTop: top}, 400, function () {
                wheel = false;
            });
        } else {

            top = top <= 0 ? 0 : top-=step;

            body.stop().animate({scrollTop: top}, 400, function () {
                wheel = false;
            });
        }

        return false;
    });

    $(window).on('resize', function (e) {
        viewport = $(this).height();
    });

    $(window).on('scroll', function (e) {
        if (!wheel)
            top = $(this).scrollTop();
    });*/
    
    
    
    
    

});