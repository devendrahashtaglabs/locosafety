<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		} 
	}
	public function index()
	{
			$this->session->unset_userdata('loggedInAdmin');
			$this->session->unset_userdata('loggedInDetail');
			redirect('login');
	}
}