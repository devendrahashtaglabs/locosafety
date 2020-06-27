<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Users_model'); 
		$this->load->model('Hardwares_model'); 
		$this->load->model('Shops_model'); 
		$this->load->model('Sections_model'); 
		$this->load->library('session');
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 	= 'Dashboard';
		$allUser	 	= $this->Users_model->getUser();
		if(!empty($allUser)){
			$data['userCount'] = count($allUser);
		}
		$allHardware	= $this->Hardwares_model->getHardware();
		if(!empty($allHardware)){
			$data['hardwareCount'] = count($allHardware);
		}
		$allHMCount	= $this->Hardwares_model->getHMCount();
		if(!empty($allHMCount)){
			$allHMCount 		= $allHMCount[0];
			$data['hmCount'] 	= $allHMCount->HardwareInMaintenance;
		}
		$allShop		= $this->Shops_model->getShop();
		if(!empty($allShop)){
			$data['shopCount'] = count($allShop);
		}
		$allSection		= $this->Sections_model->getSection();
		if(!empty($allSection)){
			$data['sectionCount'] = count($allSection);
		}
		$this->load->view('header',$data);
		$this->load->view('dashboard/index',$data);
		$this->load->view('footer',$data);
	}
}