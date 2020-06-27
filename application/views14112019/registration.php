<!------ Include the above in your HEAD tag ---------->
<?php 
	//echo "<pre>";print_r($loginType); echo "</pre>";die(__FILE__ .' on line no. ' .__LINE__);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet" id="bootstrap-css">

    <title> Locosafety </title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>registration">Register</a>
            </li>
        </ul>

    </div>
    </div>
</nav>

<main class="my-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
				<div class="card">
					<div class="card-body mt-3">
						<h2 class="text-center mb-3">User Registration</h2>
						<?php 
							$attributes = array('class' => 'registration-form');
							echo form_open_multipart('registration', $attributes); 
						?>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_f_name',
												'id'    		=> 'user_f_name',
												'value' 		=> set_value('user_f_name'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'First Name*',
										);
										echo form_input($data);
										echo form_error('user_f_name', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_l_name',
												'id'    		=> 'user_l_name',
												'value' 		=> set_value('user_l_name'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Last Name*',
										);
										echo form_input($data);
										echo form_error('user_l_name', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12">
									<?php
										$allCountry 		= [];
										$allCountry['-1'] 	= 'Select Country';
										foreach($country as $countryList){
											$allCountry[$countryList->country_id] = $countryList->country_name;
										}					 
										echo form_dropdown('user_country', $allCountry, '-1', 'class="form-control" id="user_country"');
										echo form_error('user_country', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12">
									<?php 
										$allState 		= [];
										$allState['-1'] 	= 'Select State';
										foreach($state as $stateList){
											$allState[$stateList->state_id] = $stateList->state_name;
										}
										echo form_dropdown('user_state', $allState, '-1', 'class="form-control" id="user_state"');
										echo form_error('user_state', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_city',
												'id'    		=> 'user_city',
												'value' 		=> set_value('user_city'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'City* ',
										);
										echo form_input($data);
										echo form_error('user_city', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_zipcode',
												'id'    		=> 'user_zipcode',
												'value' 		=> set_value('user_zipcode'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Zipcode* ',
										);
										echo form_input($data);
										echo form_error('user_zipcode', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_address',
												'id'    		=> 'user_address',
												'value' 		=> set_value('user_address'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Address',
										);
										echo form_input($data);
										echo form_error('user_address', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'type'  		=> 'text',
												'name'  		=> 'user_dob',
												'id'    		=> 'user_dob',
												'value' 		=> set_value('user_dob'),
												'class' 		=> 'form-control datepicker',
												'placeholder' 	=> 'DOB',
										);
										echo form_input($data);
										echo form_error('user_dob', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php $selected = 'M'; ?>
									<?php echo form_label('Gender: ', 'user_gender'); ?>
									<?php echo form_radio(array('name' => 'user_gender', 'value' => 'M', 'checked' => ('M' == $selected) ? TRUE : FALSE, 'id' => 'male')).form_label('Male', 'male'); ?>
									<?php echo form_radio(array('name' => 'user_gender', 'value' => 'F', 'checked' => ('F' == $selected) ? TRUE : FALSE, 'id' => 'female')).form_label('Female', 'female'); ?>
									<?php echo form_error('user_gender'); ?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 
										$state = array(
											"-1" => "Select Division",
											"1" => "1",
											"2" => "2",
											"3" => "3",
											"4" => "4",
											"5" => "5"
										);
										echo form_dropdown('user_division', $state, '-1', 'class="form-control" id="user_division"');
										echo form_error('user_division', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 
										$state = array(
											"-1" => "Select Zone",
											"1" => "1",
											"2" => "2",
											"3" => "3",
											"4" => "4",
											"5" => "5"
										);
										echo form_dropdown('user_zone', $state, '-1', 'class="form-control" id="user_zone"');
										echo form_error('user_zone', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php
										$data = array(
												'type'  		=> 'email',
												'name'  		=> 'user_email',
												'id'    		=> 'user_email',
												'value' 		=> set_value('user_email'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Email *',
										);
										echo form_input($data);
										echo form_error('user_email', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php								
										$data = array(
												'type'  		=> 'tel',
												'name'  		=> 'user_phone',
												'id'    		=> 'user_phone',
												'value' 		=> set_value('user_phone'),
												'minlength' 	=> '10',
												'maxlength' 	=> '10',
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Phone *',
										);
										echo form_input($data);
										echo form_error('user_phone', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 								
										$data = array(
												'name'  		=> 'user_pass',
												'id'    		=> 'user_pass',
												'value' 		=> set_value('user_pass'),
												'class' 		=> 'form-control',
												'placeholder' 	=> 'Password *',
										);
										echo form_password($data);
										echo form_error('user_pass', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 
										$userTypeArray = [];
										$userTypeArray['-1'] = 'Select User Type';
										foreach($loginType as $userType){
											$userTypeArray[$userType->login_type] = $userType->login_type_name;
										}
										echo form_dropdown('user_type', $userTypeArray, '-1', 'class="form-control" id="user_type"');
										echo form_error('user_type', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 
										$state = array(
											"-1" => "Select Section",
											"DI" => "Diesel",
										);
										echo form_dropdown('section_id', $state, '-1', 'class="form-control" id="section_id"');
										echo form_error('section_id', '<div class="text-danger">', '</div>');
									?>
								</div>
								<div class="col-md-6 col-xs-12 mb-3">
									<?php 
										$state = array(
											"-1" 		=> "Select Shop",
											"workshop" 	=> "Workshop",
										);
										echo form_dropdown('shop_id', $state, '-1', 'class="form-control" id="shop_id"');
										echo form_error('shop_id', '<div class="text-danger">', '</div>');
									?>
								</div>
							</div>

							<div class="col-md-6 offset-md-4">
								<?php 
									echo form_submit('register', 'Register', "class='btn btn-primar'");
								?>
							</div>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
 $(function() {
	$( "#user_dob" ).datepicker();
 });
</script>
</body>
</html>