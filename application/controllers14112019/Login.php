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
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(!empty($loggedInAdmin)){
			redirect('dashboard');
		}
	}
	public function index()
	{
		if($this->input->post('login')){
			$postData = $this->input->post();
			unset($postData['login']);
			$postData['admin_pass'] = md5($postData['admin_pass']);
			$loggedInAdmin 			= $this->Login_model->login($postData);	
			if(!empty($loggedInAdmin)){
				$loggedInDetail	= $this->Login_model->loggedInDetail($loggedInAdmin);
				$loggedInDetail = $loggedInDetail[0];
				$this->session->set_userdata('loggedInDetail', $loggedInDetail);				
				redirect('dashboard');
			}else{
				$this->load->view('login');
			}
		}else{
			$this->load->view('login'); 
		}
	}
}