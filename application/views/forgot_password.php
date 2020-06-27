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
			$("#forgotpass-form").validate({
				rules: {
					admin_email: "required",
				}
			});
		});
	</script>
<!--===============================================================================================-->
	<style>
		#admin_email-error{
			text-align:left;
		}
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
			margin: 15px 0 20px;
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
        <div class="animate form login_form">
		<div class="site-text"><h2>RSW SAFETY</h2></div>
          <section class="login_content">
            <?php 
				$attributes = array('class' => 'validate-form','id'=> 'forgotpass-form');
				echo form_open('forgotpass', $attributes); 
			?>
			<h1>Forgot Password</h1>
			<?php if(!empty($this->session->flashdata('loginError'))){ ?>
			  <h5 class="text-danger"><?php echo $this->session->flashdata('loginError'); ?></h5>
			<?php } ?>
			<?php if(!empty($this->session->flashdata('error'))){ ?>
			  <h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
			<?php } ?>
			<?php if(!empty($this->session->flashdata('success'))){ ?>
			  <h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
			<?php } ?>
				<div>
				<?php                               
					$data = array(
							'name'              => 'admin_email',
							'id'                => 'admin_email',
							'value'             => set_value('admin_email'),
							'class'             => 'form-control',
							'placeholder'		=> 'Email *'
					);
					echo form_input($data);
					echo form_error('admin_email', '<div class="text-danger">', '</div>');
				?>
				</div>
				<div class="mt-5 submitbtn">
					<?php echo form_submit('submit', 'Submit', "class='btn btn-primary submit'"); ?>
				</div>
				<div class="forgetpswd"> 
					<a href="<?php echo base_url().'login'; ?>">Login</a>
				</div>
              <div class="clearfix"></div>
            <?php echo form_close(); ?>
          </section>
        </div>
      </div>
    </div>
  </body> 
</html>