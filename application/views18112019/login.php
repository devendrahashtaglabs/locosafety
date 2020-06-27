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
	</style>
</head>
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
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
              <div class="mt-5">
				<?php echo form_submit('login', 'Sign in', "class='btn btn-default submit'"); ?>
              </div>
              <div class="clearfix"></div>
            <?php echo form_close(); ?>
          </section>
        </div>
      </div>
    </div>
  </body> 
</html>