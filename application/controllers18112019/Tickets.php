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
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 		= 'Tickets';
		$data['ticketData'] 	= $this->Tickets_model->getRaiseTicket();
		$this->load->view('header',$data);
		$this->load->view('tickets/index',$data);
		$this->load->view('footer',$data);
		
	}
}