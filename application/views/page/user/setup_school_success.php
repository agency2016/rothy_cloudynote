<html>
<head>

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
      $('.link').click( function() {
          ////console.log('a clicked');

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


</style>
</head>
<body><?php
	// load Breadcrumbs
//$this->load->library('breadcrumbs');

// add breadcrumbs
//$//this->breadcrumbs->push('Section', '/section');
  // $this->breadcrumbs->push('Section', site_url('section') );
//$this->breadcrumbs->push('Page', '/section/page');
  // $this->breadcrumbs->push('Page', site_url('section/page') );

// unshift crumb
//$this->breadcrumbs->unshift('Home', '/');
  // $this->breadcrumbs->unshift('Home', site_url('') );

// output
//$this->breadcrumbs->show();?>
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
			<div id="cbcrumbs">
				<ul>
					<li><a href="<?php echo base_url('setupschool/') ?>" class="link"> 1. Create Class</a></li>
					<li><a href="<?php echo base_url('addstaff/') ?>"  class="link"> 2. Add Staff</a></li>
					<li><a href="<?php echo base_url('addstudents/') ?>"  class="link">  3. Add Students</a></li>
					<li><a href="<?php echo base_url('addsuccess/') ?>"  class="link"> 4.Finish</a></li>
				</ul>
			</div>
		</div>
		</div>
	</div>

	
	
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<div class=" cbsetupschoolsuccess">	
					<p><?php  echo $this->session->flashdata('add_member_success'); ?></p>	 
						<p><?php  echo $this->session->flashdata('result_msg'); ?></p>
						<p><?php  echo $this->session->flashdata('year_count'); ?></p>
						<p><?php  echo $this->session->flashdata('class_count'); ?></p>
						<p><?php  echo $this->session->flashdata('student_count'); ?></p>
						<a href="<?php echo base_url('user/') ?>"><button class="cb-dashboard-button btn btn-success btn-large">Go To Dashboard</button></a>
				</div>
			</div>
		</div>
	</div>

</body>
</html>