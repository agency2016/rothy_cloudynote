<html>
<head>
<title> SetUp School </title>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script  src="<?php echo base_url('resources/js/jquery.cookie.js'); ?> "></script>

<script type="text/javascript">
    $(function() {

$('.childdiv' ).children('ul').children("li:first").children("img:first").hide();
        $('#addparent').live('click', function() {
            var check_id=$('.maindiv').children().last().attr('data_id');
            var check_id2=$(this).attr('data_pid');
            $(this).siblings('#removeparent').hide();
            $(this).hide();
            check_id++;
            var parentdiv_part1 ='<div data_id="'+check_id+'" id="parentdiv_'+check_id+'" class="parentdiv"><p>';
            var parentdiv_part2 =parentdiv_part1+'<input  class="required" data_pid="'+check_id+'" type="text" id="parent_new_'+check_id+'" size="20" name="parent_new_'+check_id+'" value="" placeholder="Add Year" /> <img data_pid="'+check_id+'" height="15px" width="15px" id="removeparent" src="<?php echo base_url('resources/icon/Minus.png'); ?>" alt="Add Class"/> <img data_pid="'+check_id+'" height="15px" width="15px" id="addparent" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/></p>';
            var parendiv =parentdiv_part2+'<div data_cdivid="'+check_id+'"  data_pid="'+check_id+'" style="margin-left:300px;"id="childdiv_'+check_id+'" class="childdiv"><ul class="child-list"><li class="child-list"><input  class="required" data_cid="1" data_pid="'+check_id+'" type="text" id="child_new_1_p_'+check_id+'" size="20" name="child_new_1_p_'+check_id+'" value="" placeholder="Input Class" />  <img data_cid="1" data_pid="'+check_id+'" height="15px" width="15px" id="addchild" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/></li><li class="child-list"><input  class="required" data_cid="2 " data_pid="'+check_id+'" type="text" id="child_new_2_p_'+check_id+'" size="20" name="child_new_2_p_'+check_id+'"  value="" placeholder="Input Class" />  <img data_cid="2" data_pid="'+check_id+'" height="15px" width="15px" id="removechild" src="<?php echo base_url('resources/icon/Minus.png'); ?>" alt="Add Class"/><img data_cid="2" data_pid="'+check_id+'" height="15px" width="15px" id="addchild" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/></li></ul></div></div>';
            $('.maindiv').append(parendiv);
            $(this).parent('p').parent('div').next('.parentdiv').children('.childdiv' ).children('ul').children("li:first").children("img:first").hide();
            return false;
        });

        $('#removeparent').live('click', function() {
            var chek_parent_id=$(this).attr('data_pid');
            $('#parentdiv_'+chek_parent_id).remove();
            $('.maindiv').children().last().children('p').children('img').show();
            return false;
        });

        $('#addchild').live('click', function() {
            var cid =$(this).attr('data_cid');
            var pid =$(this).attr('data_pid');
            cid++;
            $(this).parent().parent().append('<li class="child-list"><input  class="required" data_cid="'+cid+'" data_pid="'+pid+'" type="text" id="child_new_'+cid+'_p_'+pid+'" size="20" name="child_new_'+cid+'_p_'+pid+'" value="" placeholder="Add class" />  <img data_cid="'+cid+'" data_pid="'+pid+'" height="15px" width="15px" id="removechild" src="<?php echo base_url('resources/icon/Minus.png'); ?>" alt="Add Class"/> <img data_cid="'+cid+'" data_pid="'+pid+'" height="15px" width="15px" id="addchild" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/></li>');
            $(this).prev('#removechild').hide();
            $(this).hide();
            return false;
        });

        $('#removechild').live('click', function() {
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


});

</script>
<style>
    .child-list{
        list-style-type: none;
        margin:2px;
    }
    .createclass{
        margin-top:10%;
        min-height:500px;
        margin-left:5%;
    }
    .tooltip_side_p{
        margin-top:40px;
        height:130px;
        background-color:white;
        padding:22px;
		
    }
    .tooltip_side{
        margin-bottom:40px;
        width:450px;
		
    }
    .tooltip_under{
        color:black;
        margin-top:40px;
        height:30px;
        background-color:white;
        padding:22px;
		
    }
    .tooltip_side_close{
        background-color:#0D6DDD;
        width:90px;
        height:20px;
        padding:5px;
        color:white;
        margin-top:20px;
        margin-bottom:20px;
		
    }
    .tooltip_beside_close {
        background-color:#0D6DDD;
        width:90px;
        height:20px;
        padding:5px;
        color:white;
        margin-top:20px;
        margin-bottom:20px;
		
    }
    .setup_school_button{
        list-style-type: none;
        display:inline;
    }
    .cb_btn_list{
		
    }
	
    .cbactive:after{
        border-left-color:#0D6DDD;
    }
    #cbcrumbs ul li a:hover{
        background:#0D6DDD;
    }
    #cbcrumbs ul li a:hover:after {
        border-left-color:#0D6DDD;
    }
    .cbsetupschoolsuccess{
        min-height:400px;
        margin-left:10%;
        margin-top:50px;
    }
    .cb-dashboard-button {
        margin-top:100px;
    }
    #cbcrumbs ul li{
        list-style-type: none;
    }
    #cbcrumbs{
        background-color:white;
        height:40px;
    }
	
    #cbcrumbs ul li a {
        display: block;
        float: left;
        height: 30px;
        background: #aaaaaa;
        text-align: center;
        padding: 10px 15px 0 25px;
        position: relative;
        margin-left:20px;
        font-size: 15px;
        text-decoration: none;
        color: #fff;
    }

    #cbcrumbs ul li a:after {
        content:"";
        border-top: 20px solid white;
        border-bottom: 20px solid white;
        border-left: 20px solid #aaaaaa;
        position: absolute; right: -20px; top: 0;
    }
    #cbcrumbs ul li a.cbactive:after {
        content:"";
        border-top: 20px solid white;
        border-bottom: 20px solid white;
        border-left: 20px solid #0D6DDD;
        position: absolute; right: -20px; top: 0;
    }
    #cbcrumbs ul li a:before {
        content: "";
        border-top: 20px solid transparent;
        border-bottom: 20px solid transparent;
        border-left: 20px solid white;
        position: absolute; left: 0; top: 0;
	

}
    .cbheader{
        color:#3498db;
        font-size:20px;
        font-weight:bold;
    }
</style>
</head>
<body>
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-title">
                <h1>Set Up Your Institute/Organization</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row-fluid">
        <div class="span12">

            <div class="row-fluid breadcrumb-row-bg">
                <div class="container">
                    <div class="span2">
                        <img src="<?php echo base_url('resources/img/icon-dashboard.png'); ?>" alt="">
                    </div>
                    <div class="span10">
                        <div id="note-wizard">
                            <div id="cloud_crumbs">
                                <div class="tabbable">
                                    <ul class="breadcumb nav nav-tabs">
                                        <li><a href="#tab_begin_note"  data-toggle="tab">Begin Note</a></li>
                                        <li><a href="#tab_add_receivers"  data-toggle="tab">Receivers</a></li>
                                        <li><a href="#tab_preview_note"  data-toggle="tab">Preview</a></li>
                                        <li><a href="#tab_send_note"  data-toggle="tab">Send</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="cbcrumbs">
				<ul>
					<li><a  href="<?php /*echo base_url('setupschool/') */?>" class="link"> 1. Create Class</a></li>
					<li><a href="<?php /*echo base_url('addstaff/') */?>"     class="link"> 2. Add Staff</a></li>
					<li><a href="<?php /*echo base_url('addstudents/') */?>"  class="link">  3. Add Students</a></li>
					<li><a href="<?php /*echo base_url('addsuccess/') */?>"   class="link"> 4.Finish</a></li>
				</ul>
			</div>-->
        </div>
    </div>
</div>




<script>

</script>

</body>
</html>