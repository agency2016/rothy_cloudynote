<html>
	<head>
		<title> SetUp School </title>
		<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script  src="<?php echo base_url('resources/js/jquery.cookie.js'); ?> "></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var urlArray = window.location.pathname.split('/');
				var pagAtual = urlArray[urlArray.length - 1];
				$('#cbcrumbs').children().children().children("a[href*=" + pagAtual + "]").css("background-color", "#0D6DDD");
				$('#cbcrumbs').children().children().children("a[href*=" + pagAtual + "]").parent().addClass('cbactive');
				$('#cbcrumbs').children().children().children("a[href*=" + pagAtual + "]").addClass('cbactive');
				var widthcbcrumb = $('#cbcrumbs').parent('div').width();
				////console.log(widthcbcrumb);
				$('#cbcrumbs').css('width', widthcbcrumb);
				$(".cbactive:after").css("border-left-color", "red");

				$('#button_bellow').click(function() {
					var cookieValue = $.cookie("cb_success_cookie");
					if (cookieValue == null) {
						$.cookie('cb_success_cookie', '1', {
							expires : 1
						});
					}
					$(this).parent().remove();
					$(this).remove();
					return false;
				});
				var size=<?php echo $size;?>;
				////console.log(size);
				var intervalFunc = function () {
					
			       // $('.upload-file-text').val($(this).next('.upload').val());
			       // var value=  $('.upload-file-text').attr('id');
			       // var value2 =$('#files-'+value).val();
			       // //console.log(value2);
			       ////$('.upload-file-text').val(value);
			      //  $(this).siblings('.upload-file-text').val(value);
			    };
				//for (var i=0;i<size;i++)
				//{				
                $('.upload').live('change', function () {
                    ////console.log(i);
                    $(this).siblings('.upload-file-text').val($(this).val());
                });
			    $('.file-upload-btn-show').live('click', function () {
			    	////console.log(i);
			    	 // use .live() for older versions of jQuery
			        $(this).siblings('.upload').click();			       
			        setInterval(intervalFunc, 1);
			        return false;
			    });
                $('.cblink').click( function() {
                    ////console.log('a clicked');

                    return false;
                });
				  
				//}
			});

		</script>
		<style>
			.cbactive:after {
				border-left-color: #0D6DDD;
			}
			#cbcrumbs ul li a:hover {
				background: #0D6DDD;
			}
			#cbcrumbs ul li a:hover:after {
				border-left-color: #0D6DDD;
			}
			.cbsetupschoolsuccess {
				min-height: 400px;
				margin-left: 10%;
				margin-top: 50px;
			}
			.cb-dashboard-button {
				margin-top: 100px;
			}
			#cbcrumbs ul li {
				list-style-type: none;
			}
			#cbcrumbs {
				background-color: white;
				height: 40px;
			}

			#cbcrumbs ul li a {
				display: block;
				float: left;
				height: 30px;
				background: #aaaaaa;
				text-align: center;
				padding: 10px 15px 0 25px;
				position: relative;
				margin-left: 20px;
				font-size: 15px;
				text-decoration: none;
				color: #fff;
			}

			#cbcrumbs ul li a:after {
				content: "";
				border-top: 20px solid white;
				border-bottom: 20px solid white;
				border-left: 20px solid #aaaaaa;
				position: absolute;
				right: -20px;
				top: 0;
			}
			#cbcrumbs ul li a.cbactive:after {
				content: "";
				border-top: 20px solid white;
				border-bottom: 20px solid white;
				border-left: 20px solid #0D6DDD;
				position: absolute;
				right: -20px;
				top: 0;
			}
			#cbcrumbs ul li a:before {
				content: "";
				border-top: 20px solid transparent;
				border-bottom: 20px solid transparent;
				border-left: 20px solid white;
				position: absolute;
				left: 0;
				top: 0;
			}
			.cbheader {
				color: #3498db;
				font-size: 20px;
				font-weight: bold;
			}
			.tooltip_bellow_close {
				background-color: #0D6DDD;
				width: 90px;
				height: 20px;
				padding: 5px;
				color: white;
				margin-top: 30px;
				margin-bottom: 20px;
				margin-left: 90%;
			}
			.tooltip_bellow {
				margin-top: 10px;
				margin-bottom: 20px;
				height: 50px;
				width: 79%;
				background-color: white;
				padding: 22px;
			}

			.setup_school_button_addstaff {
				list-style-type: none;
				display: inline;
			}
			.cb_btn_list_addstaff {
				margin-top: 3%;
				margin-bottom: 3%;
				margin-left: 60%;
			}
			.upload{
				position:absolute;
				left:-9999px;
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
					<div id="cbcrumbs">
						<ul>
							<li>
								<a href="<?php echo base_url('setupschool/') ?>" class = "cblink"> 1. Create Class</a>
							</li>
							<li>
								<a href="<?php echo base_url('addstaff/') ?>" class = "cblink"> 2. Add Staff</a>
							</li>
							<li>
								<a href="<?php echo base_url('addstudents/') ?>" class = "cblink"> 3. Add Students</a>
							</li>
							<li>
								<a href="<?php echo base_url('addsuccess/') ?>" class = "cblink"> 4.Finish</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row-fluid">
				<div class="span12">
					

					<div class=" cbsetupschoolsuccess">
						<p class="cbheader">
							Import Students
						</p>

						<p>	<p><?php  echo $this->session->flashdata('add_member_error'); ?></p>	
							<p><?php  echo $this->session->flashdata('add_staff_wrong'); ?></p>	
							<p><?php  echo $this->session->flashdata('add_staff_success'); ?></p>	
							Important:<span style="text-decoration:underline">Click to download Import Template for Students</span>(Excel File)
						</p>

						<div class="row-fluid">
							<div class="span10" style="background-color: #aaaaaa;text-align:left;">
								<div class="span3" style="padding:5px;" >
									Available Year
								</div>
								<div class="span3"style="padding:5px;">
									Available Classes
								</div>
								<div class="span6"style="padding:5px;">
									Upload Prepared CSV
								</div>
							</div>
						</div>
						 						<?php
					
						$addstudent = '';

						for ($x = 0; $x < $size; $x++) {						
							$upload_file_name_text = '	<div>						
							<input class = "upload-file-text" id="'.$x.'" type="text" name="upload-file-info-'.$x.'" size="40"  >
							<input  id="sectioninfo-'.$x.'"  type="hidden" name="sectioninfo-'. $x .'" value="'.${'data' . $x}[0] ->section_id.'"  size="40" >
							<input  id="groupinfo-'.$x.'"  type="hidden" name="groupinfo-'. $x .'" value="'.${'data' . $x}[0] ->group_name.'"  size="40" >';
							$cbfilebutton = '<input class ="upload" id="files-'.$x.'" type="file" name="files'.$x.'" multiple>
							<label   id ="file-upload-btn-show'.$x.'"  class="file-upload-btn-show btn btn-primary">Choose File</label></div>';
                           if(is_array(${'data' . $x})){
                                        $addstudent .= '<div class="row-fluid">
                                                            <div class="span10" style="height:150px;margin-top:10px;background-color:  #FFFFFF;text-align:left;">
                                                                <div class="span3" style="padding:12px;" >
                                                                    <p style="border:1px solid #aaaaaa;">' . ${'data' . $x}[0] -> group_name . '</p>
                                                                </div>
                                                                <div class="span3"style="padding:12px;">
                                                                    <p>' . ${'data' . $x}[0] -> section_name . '</p>
                                                                </div>
                                                            <div class="span6"style="padding:12px;">
                                                                Upload The file after saving as CSV file
                                                            <div class="span12">
                                                                    <div class="span6" style"" >
                                                                    ' . $upload_file_name_text . '
                                                                    ' . $cbfilebutton . '
                                                                    </div>
                                                                    <div class="span6">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>';
                                    }

                                    echo $addstudent;
                        }

						?>
						
						<div class="row-fluid"
							<div class="span10">
							<?php if(isset($_COOKIE['cb_success_cookie']) && $_COOKIE['cb_success_cookie'] == "1"){}else{?>
								<div class="tooltip_bellow">
									<p class="tooltip_bellow_student">Tip:First select the year or group then prepare a separate file for each class
									within that year.Once completed click save and upload students.You can check all is imported corectly and then come back
									and complete the following years.  <br>
									</p>
									<p class="tooltip_bellow_close" id="button_bellow">OK GOT IT</p>
								</div>
							<?php } ?>
	
							</div>

						</div>
						<div class="row-fluid"
							<div class="span10">
								<div class="cb_btn_list_addstaff">
									<ul class="setup_school_button_addstaff">
										<li class="setup_school_button_addstaff">
											<button type="submit" name="import_students" value="import_students" class="btn btn-success"> Import</button>
										
										</li>
										
										<li class="setup_school_button_addstaff">
											<a href="<?php echo base_url('addsuccess/') ?>"><label  class="btn btn-primary btn-medium">
												Next Step
											</label></a>
										</li>
									</ul>
									<ul style="margin-top:5px;"><li style="list-style-type: none;"><a href="<?php echo base_url('addsuccess/') ?>"><span style="text-decoration:underline;color:#3498db;">Skip add students and go to next <br>(You can add students later)</span></a></li></ul>
								</div>
								
							</div>
						</div>	
					</div>
				</form>
			</div>
		</div>

	</body>
</html>