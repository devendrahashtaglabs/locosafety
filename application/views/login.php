<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> LOCOSAFETY </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jjquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.validate.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
	<script>
		$(document).ready(function() {
			$("#login-form").validate({
				rules: {
					admin_user: "required",
					admin_pass: "required",
				}
			});
			$(".toggle-password").click(function(e) {
				e.preventDefault();
				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text"); 
				} else {
					input.attr("type", "password");
				}
			});
		});
		/* window.onload = function() {
			var $recaptcha = document.querySelector('#g-recaptcha-response');
			if($recaptcha) {
				$recaptcha.setAttribute("required", "required");
			}
		}; */
	</script>
<!--===============================================================================================-->
	<style>
		.field-icon {
			float: right;
			margin-left: -25px;
			margin-top: -42px;
			position: relative;
			z-index: 2;
			margin-right: 10px;
		}
		.error{
			color:#a94442;
		}
		#content form .submit, .login_content form input[type=submit] {
			margin-left: 0px;
		}
		.mt-5{
			margin-top:3rem;
		}
.site-text h2 {
	color: #fff;
	text-align: center;
	font-size: 34px;
	margin: 25px 0 0;
	font-weight: bold;
	text-transform: uppercase;
}
body{
background: #ff00cc !important;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #333399, #ff00cc)!important;  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #333399, #ff00cc) !important; /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.submitbtn {
	float: left;
	width: 100%;
	margin: 0 0 20px;
}
.forgetpswd {
	float: left;
	width: 100%;
	text-align: center;
}
.submitbtn input {
	width: 100%;
	text-transform: uppercase;
}
	</style>
</head>
<body class="login login-apges">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
      	
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="site-text"><h2>RSW SAFETY</h2></div>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-8 minleft">
            	<div class="leftcontent">
                <div class="row">
                	<div class="col-md-4">
                    
                	<div class="logo">
                    	<img src="<?php echo base_url();?>assets/images/stc-loog.png">
                    </div>
                    </div>
                    <div class="col-md-8">
                    <div class="contentlogo">
                    	<h3>RSW Safety</h3>
                        <ul class="list-inline">
                        	<li>Hashtag Labs</li>
                            <li>Productivity</li>
                        </ul>
                    </div>
                    </div>
                </div>
                   <div class="slider">
                   	<section class="customer-logos slider">
      <div class="slide"><img src="<?php echo base_url();?>assets/images/sl1.jpg" alt="STC"></div>
      <div class="slide"><img src="<?php echo base_url();?>assets/images/sl2.jpg" alt="STC"></div>
      <div class="slide"><img src="<?php echo base_url();?>assets/images/sl3.jpg" alt="STC"></div>
      <div class="slide"><img src="<?php echo base_url();?>assets/images/sl4.jpg" alt="STC"></div>
      <div class="slide"><img src="<?php echo base_url();?>assets/images/sl5.jpg" alt="STC"></div>
    </section>
                   </div>
                  
      <h4>About RSW Safety</h4>
<p>* This is productivity app for monitoring health and upkeep of heavy machinery equipment and tools used in Railway's Locomotive Workshops.</p>
<p>* It is a pilot initiative taken at Locomotive Workshop, Charbagh, Lucknow (Northern Railway).</p>
<p>* This app essentially allows users to check and get alerts on scheduled maintenance checks, mark breakdowns, ticket management and maintaining healthy status of heavy machinery and tools.</p>
<p>* If tools and machinery are regularly checked and upkeep is well maintained - it ensures safe environment for staff working with these.</p>           
                </div>
                
                
            </div>
                <div class="col-md-4 thisform">
                	<div class="animate form login_form">
        
          <section class="login_content">
        
            <?php 
				$attributes = array('class' => 'validate-form','id'=> 'login-form');
				echo form_open('login', $attributes); 
			?>
              <h1>Admin Login</h1>
				<?php if(!empty($this->session->flashdata('loginError'))){ ?>
				  <h5 class="text-danger"><?php echo $this->session->flashdata('loginError'); ?></h5>
				<?php } ?>
              <div>
				<?php                               
					$data = array(
							'name'              => 'admin_user',
							'id'                => 'admin_user',
							'value'             => set_value('admin_user'),
							'class'             => 'form-control',
							'placeholder'		=> 'Username'
					);
					echo form_input($data);
					echo form_error('admin_user', '<div class="text-danger">', '</div>');
				?>
              </div>
              <div>
				<?php 								
					$data = array(
							'type'  			=> 'password',
							'name'  			=> 'admin_pass',
							'id'    			=> 'admin_pass',
							'value' 			=> set_value('admin_pass'), 
							'class' 			=> 'form-control',
							'placeholder'		=> 'Password'
					);
					echo form_password($data);
					echo form_error('admin_pass', '<div class="text-danger">', '</div>');
				?>
				<span toggle="#admin_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
              </div>
			  
              <div class="submitbtn">
				<?php echo form_submit('login', 'Sign in', "class='btn btn-primary submit'"); ?>
              </div>
              <div class="forgetpswd"> 
				<a href="<?php echo base_url().'forgotpass'; ?>">Forgot Password?</a>
			  </div>
              <div class="clearfix"></div>
            <?php echo form_close(); ?>
          </section>
        </div>
        
        
         <div class="diownloadbtn">
                    	<a href="https://play.google.com/store/apps/details?id=com.hashtaglabs.locosafety" target="_blank">
                        <img src="<?php echo base_url();?>assets/images/plystor.png" alt="Get it on Google Play">
                        </a>
                    </div> 
                
                <div class="coyrightcl">
            		<div class="trxtcopy">
					Powered by <a target="_blank" href="http://www.hashtaglabs.biz/">HashTag Labs</a>
                    </div>
            
            </div>
          
                      
                </div>
            </div>
            
            
            </div>
            
            
      
      
        
      </div>
    </div>
    <script>
$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
});
</script>
  </body> 
</html>