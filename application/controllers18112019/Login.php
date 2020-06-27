 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Login_model'); 
		$this->load->model('Users_model'); 
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(!empty($loggedInAdmin)){
			redirect('dashboard');
		}
	}
	public function index()
	{
		$data['title'] 			= 'Admin Login Page';
		if($this->input->post('login')){
			
			$gRecaptchaResponse = $this->input->post('g-recaptcha-response');
			/* $errMsg = "";
			if(isset($gRecaptchaResponse) && !empty($gRecaptchaResponse))
			{
				$secret = '6LepE8IUAAAAAMjqvAmbtMgWsEWPvhN0oO64iGbx';
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
				$responseData = json_decode($verifyResponse);
				if($responseData->success){
					$succMsg = 'Your contact request have submitted successfully.';
				}else{
					$errMsg = 'Robot verification failed, please try again.';
					//$data['errMsg'] = $errMsg;
					$this->load->view('login');
				}
			} */
			$postData = $this->input->post();
			unset($postData['login']);
			$postData['admin_pass'] = md5($postData['admin_pass']);
			$loggedInAdmin 			= $this->Login_model->login($postData);	
			if(!empty($loggedInAdmin)){
				$loggedInUserDetail = $this->Users_model->getUserById($loggedInAdmin);
				$this->session->set_userdata('loggedInUserDetail', $loggedInUserDetail);
				redirect('dashboard');
			}else{
				$this->load->view('login');
			}
		}else{
			$this->load->view('login'); 
		}
	}
}