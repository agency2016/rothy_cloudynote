<html>
<head>
<title> SetUp School </title>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script  src="<?php echo base_url('resources/js/jquery.cookie.js'); ?> "></script>
   
  
<script type="text/javascript">

  $( document ).ready(function() {
    var urlArray = window.location.pathname.split( '/' );
    var pagAtual =urlArray[urlArray.length -1];
    $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").css("background-color","#0D6DDD");
     $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").parent().addClass('cbactive');
      $('#cbcrumbs').children().children().children("a[href*="+pagAtual+"]").addClass('cbactive');
    var widthcbcrumb =$('#cbcrumbs').parent('div').width();
	////console.log(widthcbcrumb);
	$('#cbcrumbs').css('width',widthcbcrumb);
	$(".cbactive:after").css("border-left-color","red");
 
$('#button_tip_right').click( function() {
		//console.log('clicked');
		var cookieValue = $.cookie("cb_tip_right");
		if(cookieValue ==null){
			$.cookie('cb_tip_right', '1', { expires:1 });
		}
		$(this).parent().remove();		
		$(this).remove();		
		return false;
	});
	$('#button_tip_left').click( function() {
		var cookieValue = $.cookie("cb_tip_left");
		if(cookieValue ==null){
			$.cookie('cb_tip_left', '1', { expires:1 });
		}
		$(this).parent().remove();		
		$(this).remove();		
		return false;
	});
	$('#addparent').live('click', function() {
		var check_id=$('.cbaddstaffinput').children().last().attr('data_id');
		var check_id2=$(this).attr('data_pid');
		$(this).siblings('#removeparent').hide();
		$(this).hide();
		check_id++;
		 
							
							
		var parentdiv_part1 ='<div data_id="'+check_id+'" id="parentdiv_'+check_id+'" class="parentdiv"><ul style="list-style-type: :none;display:inline;">';
		var parentdiv_part2 =parentdiv_part1+'<li style="margin:2px;list-style-type: :none;display:inline;"><input class="cbsmall" data_pid="'+check_id+'" type="text" id="firstname_'+check_id+'" size="20" name="firstname_'+check_id+'" value="" placeholder="FirstName" /></li>';
		var parentdiv_part3 =parentdiv_part2+'<li style="margin:2px;list-style-type: :none;display:inline;"><input class="cbsmall" data_pid="'+check_id+'" type="text" id="lastname_'+check_id+'" size="20" name="lastname_'+check_id+'" value="" placeholder="LastName" /></li>';
		var parentdiv_part4 =parentdiv_part3+'<li style="margin:2px;list-style-type: :none;display:inline;"><input class="cbsmall" data_pid="'+check_id+'" type="text" id="email_'+check_id+'" size="20" name="email_'+check_id+'" value="" placeholder="Email" /></li>';
		var parendiv= parentdiv_part4+'<li style="margin:2px;list-style-type: :none;display:inline;"><img data_pid="'+check_id+'" height="15px" width="15px" id="removeparent" src="<?php echo base_url('resources/icon/Minus.png'); ?>" alt="Add Class"/> <img data_pid="'+check_id+'" height="15px" width="15px" id="addparent" src="<?php echo base_url('resources/icon/feature-icon-plus.png'); ?>" alt="Add Class"/></li></ul></div>';
		
		$('.cbaddstaffinput').append(parendiv);		
		//$(this).parent('p').parent('div').next('.parentdiv').children('.childdiv' ).children('ul').children("li:first").children("img:first").hide();
		return false;
	});

      $('.cblink').click( function() {
          ////console.log('a clicked');

          return false;
      });
	$('#removeparent').live('click', function() {
		 var chek_parent_id=$(this).attr('data_pid');	
		$('#parentdiv_'+chek_parent_id).remove();
		$('.cbaddstaffinput').children().last().children('ul').children().last().children('img').show();	
		return false;
	});
	
	  var intervalFunc = function () {
        $('#upload-file').val($('#file-upload-btn').val());
    };
    $('#file-upload-btn-show').live('click', function () { // use .live() for older versions of jQuery
        $('#file-upload-btn').click();
        setInterval(intervalFunc, 1);
        return false;
    });
    
 });
</script>
<style>
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
.divider{
    position:absolute;
    left:50%;
    top:50%;
    bottom:1%;
    border-left:1px solid #aaaaaa;
}
.cbheaderright{
	margin:5% 0%;
	color:#3498db;
	font-size:20px;
	font-weight:bold;
}
.cbheader{
	color:#3498db;
	font-size:20px;
	font-weight:bold;
}
.addstaff{
	padding-top:5%;
	padding-left:5%;
	min-height:400px;
}
.setup_school_button_addstaff{
		list-style-type: none;
		display:inline;
	}
.cb_btn_list_addstaff{
			margin-top:30%;
			margin-bottom:20%;
			
		}
.cbsmall {
	font-size:8px;
	 width: 90px;
	font-family:tahoma arial;
}
.tooltip_right_close{
		background-color:#0D6DDD;
		width:90px;
		height:20px;
		padding:5px;
		color:white;
		margin-top:20px;
		
	}
	.tooltip_right{
		margin-top:20px;
		margin-bottom:20px;
		height:100px;	
		background-color:white;		
		padding:22px;
		
	}
	.tooltip_left_close{
		background-color:#0D6DDD;
		width:90px;
		height:20px;
		padding:5px;
		color:white;
		margin-top:20px;
		
	}
	.tooltip_left{
		margin-top:20px;
		margin-bottom:20px;
		height:100px;		
		background-color:white;		
		padding:22px;
		
	}
</style>
</head>
<body>


	
	
	<div class="container">
		<div class="row-fluid">


			


			
			<!----ok --><!----ok --><!----ok -->
		</div>
	</div>
 
</body>
</html>