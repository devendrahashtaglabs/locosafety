<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tickets extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Tickets_model'); 
		$this->load->model('Users_model'); 
		$this->load->model('Sections_model'); 
		$this->load->model('Shops_model');
		$this->load->model('Categories_model');
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 	= 'Tickets';
		$status			=  $this->input->get('searchByStatus');
		$session_data 	= $this->session->userdata('loggedInUserDetail');
		$zone_id 		= $session_data->user_zone;
		$division_id 	= $session_data->user_division; 
		if( $status === NULL ){
			$status					= '10';		
			$data['ticketData'] 	= $this->Tickets_model->Getallhardwarebystatus($zone_id,$division_id);
		}elseif($status == 'all'){			
			$data['ticketData'] 	= $this->Tickets_model->getRaiseTicket();		
		}else{
			$data['ticketData'] 	= $this->Tickets_model->Getallhardwarebystatus($zone_id,$division_id,$status);	
		}
		$this->load->view('header',$data);
		$this->load->view('tickets/index',$data);
		$this->load->view('footer',$data);
		
	}

	public function getticketlog($TicketID){
		//echo "<pre>";print_r($TicketID);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		$data['title'] 			= 'Tickets Logs';
		$data['ticketDataLog'] 	= $this->Tickets_model->getTicketLog($TicketID);
		$this->load->view('tickets/ticketLog',$data);
	}	

}