<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Tickets_model extends CI_Model{
	public function getRaiseTicket(){
		$user_stored_proc 	= "CALL get_all_raise_tickets_sp()";
        $query 				= $this->db->query($user_stored_proc);
        $result				= $query->result();
        $query->next_result(); 
		$query->free_result(); 
		return $result; 
	}
}