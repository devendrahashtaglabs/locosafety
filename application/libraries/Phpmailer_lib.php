<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	class Phpmailer_lib
	{

		public function __construct()
		{
			log_message('Debug','PHP Mailer class is loaded.');
		}

		public function load()
		{
			require APPPATH.'third_party/PHPMailer/Exception.php';
			require APPPATH.'third_party/PHPMailer/PHPMailer.php';
			require APPPATH.'third_party/PHPMailer/SMTP.php';
			$mail = new PHPMailer;
			return $mail;
		}
	}