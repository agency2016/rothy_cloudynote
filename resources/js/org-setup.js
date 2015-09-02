/**
 * Created by MANCHU on 5/12/14.
 */

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;

function setInfo(i, e) {
    $('#x').val(e.x1);
    $('#y').val(e.y1);
    $('#w').val(e.width);
    $('#h').val(e.height);
}

jQuery(document).ready(function ($) {


    //styling image upload
    $( "#upload-org-image:file" ).filestyle({
        buttonText: "Select Logo",
        classButton: "btn btn-primary"
    });


    var org_logo_preview = $("#org-logo-preview");

    // prepare instant preview
    $("#upload-org-image").on('change', function(){
        // fadeOut or hide preview
        org_logo_preview.fadeOut();

        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("upload-org-image").files[0]);

        oFReader.onload = function (oFREvent) {
            var imageReader = new Image();
            imageReader.src = oFREvent.target.result;
            imageReader.onload = function() {
                alert( imageReader.width );
                alert( imageReader.height );
                if( imageReader.width <= 800 && imageReader.height <= 400 ) {
                    org_logo_preview.attr('src', imageReader.src).fadeIn();
                } else {
                    org_logo_preview.attr('src', '').css( 'display', 'none' );
                    $( '.bootstrap-filestyle input[type="text"]').val( '' );
                }
                //$( '#org-modal').css( 'width',  imageReader.width + "px");
            }
        };
    });

    $('img.uploadPreview').imgAreaSelect({
        // set crop ratio (optional)
        //maxWidth: 800,
        //maxHeight: 400,
        aspectRatio: '1:1',
        onSelectEnd: setInfo
    });

    $( '#org-logo-upload-form').on( 'submit', function(evnt) {
        evnt.preventDefault();
        var logoFormData = FormData( this );

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:logoFormData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });

    });

    $('.country-list').on('change', function(evnt) {
        var country_code = $(this).find(':selected').data('country-code');
        $( 'select.state' ).children( 'option.removable' ).remove();
        $( 'select.state' ).append( json_state_list.state_list[country_code] );
    });

    var fill_profile = function() {

        //Required Profile Section
        var org_name                            = $( '#org-name').val();
        var org_name_logo_name                  = $( '#org-logo-name').val();
        var org_admin_fname                     = $( '#org-admin-fname').val();
        var org_admin_lname                     = $( '#org-admin-lname').val();
        var org_admin_profile_picture_name      = $( '#org-admin-profile-picture-name').val();
        var org_admin_city                      = $( '#org-admin-city').val();
        var org_admin_country_id                = $( '#org-admin-country-id').val();
        var org_admin_timezone_id               = $( '#org-admin-timezone-id').val();

        //Optional
        var org_admin_state_id                  = $( '#org-admin-state-id').val();

        var validationRules = {
            rules: [{
                field: 'input',
                id: 'org-name',
                required: true,
                trim: true
            }, {
                field: 'input',
                id: 'org-logo-name',
                required: true,
                alpha: true,
                trim: true
            }, {
                field: 'input',
                id: 'org-admin-fname',
                required: true,
                alpha: true,
                trim: true
            }, {
                field: 'input',
                id: 'org-admin-lname',
                required: true,
                alpha: true,
                trim: true
            }, {
                field: 'input',
                id: 'org-admin-profile-picture-name',
                required: true,
                alpha: true,
                trim: true
            }, {
                field: 'input',
                id: 'org-admin-city',
                required: true,
                alpha: true,
                trim: true
            }, {
                field: 'select',
                id: 'org-admin-country-id',
                required: true,
                numeric: true
            }, {
                field: 'select',
                id: 'org-admin-timezone-id',
                required: true,
                numeric: true
            }, {
                field: 'select',
                id: 'org-admin-state-id',
                required: false,
                numeric: true
            }]
        };


        return validateForm('#profile', validationRules, function( formValidationObject ) {
            //return true;
                //console.log(formValidationObject);
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
                        $(formValidationObject.validationResult[list].selector).parents('div.control-group').addClass('success');
                    }

                    var profile = {
                        'org_name': org_name,
                        'org_name_logo_name': org_name_logo_name,
                        'org_admin_fname': org_admin_fname,
                        'org_admin_lname': org_admin_lname,
                        'org_admin_profile_picture_name': org_admin_profile_picture_name,
                        'org_admin_city': org_admin_city,
                        'org_admin_country_id': org_admin_country_id,
                        'org_admin_timezone_id': org_admin_timezone_id,
                        'org_admin_state_id': org_admin_state_id
                    };
                    $.ajax({
                        type: "POST",
                        url: site_url + 'user/setup_profile',
                        data: 'required_info=' + JSON.stringify( profile ) + '&json=true&info_type=profile',
                        success: function( response_json ) {
                            console.log(typeof response_json);
                            if( response_json == 'true' ) {
                                $( '.dashboard-user-icon button:eq( 0 )' ).append( org_admin_fname );
                                return true;
                            } else {
                                return false;
                            }
                        }
                    });
                }
            }
        );


    };

    $('#org-setup-wizard').bootstrapWizard({
        'tabClass': 'nav nav-tabs',
        'onInit': function (tab, navigation, index) {
        },
        'onTabClick': function (tab, navigation, index) {
            //console.log(tab);
            //return false;
            return true;
        },

        'onNext': function (tab, navigation, index) {
            switch(index) {
                case 1:
                    return true;
                    return fill_profile();
                    break;
                case 2:
                    break;
                case 3:
                    break;
                default:
                    break;
            }
        },

    'onPrevious': function (tab, navigation, index) {
            console.log(index);
        }
    });


    /********************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     */



    $('.childdiv' ).children('ul').children("li:first").children("img:first").hide();
    $('#addparent').on('click', function() {
        var check_id=$('.maindiv').children().last().attr('data_id');
        var check_id2=$(this).attr('data_pid');
        $(this).siblings('#removeparent').hide();
        $(this).hide();
        check_id++;
        var parentdiv_part1 ='<div data_id="'+check_id+'" id="parentdiv_'+check_id+'" class="parentdiv"><p>';
        var parentdiv_part2 =parentdiv_part1+'<input  class="required" data_pid="'+check_id+'" type="text" id="parent_new_'+check_id+'" size="20" name="parent_new_'+check_id+'" value="" placeholder="Add Year" /> <i class="fa fa-minus-circle" data_pid="'+check_id+'" height="15px" width="15px" id="removeparent"></i> <i class="fa fa-plus-circle" data_pid="'+check_id+'" height="15px" width="15px" id="addparent"></i></p>';
        var parendiv =parentdiv_part2+'<div data_cdivid="'+check_id+'"  data_pid="'+check_id+'" style="margin-left:300px;"id="childdiv_'+check_id+'" class="childdiv"><ul class="child-list"><li class="child-list"><input  class="required" data_cid="1" data_pid="'+check_id+'" type="text" id="child_new_1_p_'+check_id+'" size="20" name="child_new_1_p_'+check_id+'" value="" placeholder="Input Class" />  <i class="fa fa-plus-circle" data_cid="1" data_pid="'+check_id+'" height="15px" width="15px" id="addchild" ></i></li><li class="child-list"><input  class="required" data_cid="2 " data_pid="'+check_id+'" type="text" id="child_new_2_p_'+check_id+'" size="20" name="child_new_2_p_'+check_id+'"  value="" placeholder="Input Class" />  <i class="fa fa-minus-circle" data_cid="2" data_pid="'+check_id+'" height="15px" width="15px" id="removechild"></i><i class="fa fa-plus-circle" data_cid="2" data_pid="'+check_id+'" height="15px" width="15px" id="addchild"></i></li></ul></div></div>';
        $('.maindiv').append(parendiv);
        $(this).parent('p').parent('div').next('.parentdiv').children('.childdiv' ).children('ul').children("li:first").children("img:first").hide();
        return false;
    });

    $('#removeparent').on('click', function() {
        var chek_parent_id=$(this).attr('data_pid');
        $('#parentdiv_'+chek_parent_id).remove();
        $('.maindiv').children().last().children('p').children('img').show();
        return false;
    });

    $('#addchild').on('click', function() {
        var cid =$(this).attr('data_cid');
        var pid =$(this).attr('data_pid');
        cid++;
        $(this).parent().parent().append('<li class="child-list"><input  class="required" data_cid="'+cid+'" data_pid="'+pid+'" type="text" id="child_new_'+cid+'_p_'+pid+'" size="20" name="child_new_'+cid+'_p_'+pid+'" value="" placeholder="Add class" />  <i class="fa fa-minus-circle" data_cid="'+cid+'" data_pid="'+pid+'" height="15px" width="15px" id="removechild"></i> <i class="fa fa-plus-circle" data_cid="'+cid+'" data_pid="'+pid+'" height="15px" width="15px" id="addchild"></i></li>');
        $(this).prev('#removechild').hide();
        $(this).hide();
        return false;
    });

    $('#removechild').on('click', function() {
        var cid =$(this).attr('data_cid');
        var pid =$(this).attr('data_pid');
        $('#child_new_'+cid+'_p_'+pid).parent().remove();
        $('#child_new_'+cid+'_p_'+pid).remove();
        $(this).next('#addchild').remove();
        $(this).remove();
        cid--;
        $('#child_new_'+cid+'_p_'+pid).next('#removechild').next('#addchild').show();
        $('#child_new_'+cid+'_p_'+pid).next('#addchild').show();
        $('#child_new_'+cid+'_p_'+pid).next('#removechild').show();
        return false;
    });
    $('#button_bellow').click( function() {
        var cookieValue = $.cookie("cb_bellow_cookie");
        if(cookieValue ==null){
            $.cookie('cb_bellow_cookie', '1', { expires:1 });
        }
        $(this).parent().remove();

        $(this).remove();

        return false;
    });


    $('#button_side').click( function() {
        var cookieValue = $.cookie("cb_side_cookie");
        if(cookieValue ==null){
            $.cookie('cb_side_cookie', '1', { expires:1 });
        }
        $(this).siblings('.tooltip_under').remove();

        $(this).remove();

        return false;
    });
    $('.link').click( function() {
        ////console.log('a clicked');

        return false;
    });

    var urlArray = window.location.pathname.split( '/' );
    var pagAtual =urlArray[urlArray.length -1];
    ////console.log(pagAtual);

    $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").css("background-color","#0D6DDD");
    $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").parent().addClass('cbactive');
    $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").addClass('cbactive');
    var widthcbcrumb =$('#cbcrumbs').parent('div').width();
    ////console.log(widthcbcrumb);
    $('#cbcrumbs').css('width',widthcbcrumb);
    $(".cbactive:after").css("border-left-color","red");


    /********************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     * ******************************************************************************
     */

});