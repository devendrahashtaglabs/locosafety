<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Categories_model extends CI_Model{
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getAllCategory(){
                $loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
                $zone_id = $loggedInUserDetail->user_zone;
                $division_id = $loggedInUserDetail->user_division;
                $this->db->select('*');
		$this->db->from('master_hardware_category_tbl');                
                $this->db->where('zone_id',$zone_id);
		$this->db->where('division_id',$division_id);
		$this->db->where('category_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getCategory($zone_id=NULL,$division_id=NULL){
	//	$this->db->where('zone_id',$zone_id);
	//	$this->db->where('division_id',$division_id);
	//	$this->db->where('category_status','10');
		$query = $this->db->get('master_hardware_category_tbl');
		return $query->result();
	}
	public function getCategoryByZoneDivision($zone_id,$division_id,$status=NULL){
		$this->db->where('zone_id',$zone_id);
		$this->db->where('division_id',$division_id);
		if($status != NULL){
			$this->db->where('category_status','10');
		}
		$query = $this->db->get('master_hardware_category_tbl');
		return $query->result();
	}
	public function insertCategory($data){
		$parent_category_id = $data['parent_category_id'];
		$category_code 		= $data['category_code'];
		$category_name 		= $data['category_name'];
		//$cat_stored_proc 	= "CALL insert_category_sp('$parent_category_id', '$category_code', '$category_name');";
		$session_data 		= $this->session->userdata('loggedInUserDetail');
		$zone_id 			= $session_data->user_zone;
		$division_id 		= $session_data->user_division;
		$currentDate 		= date('Y-m-d H:i:s');
		$loggedInId 		= $session_data->user_info_id;
                $priority               =   $data['priority'];
                
		$catData			= array(
								'zone_id'				=> 	$zone_id,
								'division_id'			=> 	$division_id,
								'parent_category_id'	=> 	$parent_category_id,
								'category_code'			=>	$category_code,
								'category_name' 		=> 	$category_name,
								'category_status'		=> 	"10",
								'category_add_date'		=> 	$currentDate,
								'category_created_by'	=> 	$loggedInId,
                                                                'priority'                      =>      $priority
							); 

		$query = $this->db->insert('master_hardware_category_tbl',$catData);

		if($query){
			$this->session->set_flashdata('success', 'Category added successfully.');
			redirect('categories');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('categories');
		}
	}
	public function updateCategory($data){
		$id 				= $data['id'];
		$parent_category_id = $data['parent_category_id'];
		if($parent_category_id != $id){
			$category_code 		= $data['category_code'];
			$category_name 		= $data['category_name'];
                        $priority 		= $data['priority'];
			/*$cat_stored_proc 	= "CALL update_category_sp('$id', '$parent_category_id', '$category_code','$category_name');";
			$catData			= array('id'=> $id,'parent_category_id'=> $parent_category_id,'category_code'=>$category_code,'category_name' => $category_name); 
	        $query 				= $this->db->query($cat_stored_proc, $catData);
	        $query->next_result(); 
			$query->free_result();  
*/
			$catData	= 	array(
								'parent_category_id'=> $parent_category_id,
								'category_code'=>$category_code,
								'category_name' => $category_name,
								'priority' => $priority
                                ); 
			$this->db->where('id',$id);
			$query = $this->db->update('master_hardware_category_tbl',$catData);
			if($query){
				$this->session->set_flashdata('updateCategory', 'Category updated successfully');
				redirect('categories/editCat/'.$id);
			}else{
				$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
				redirect('categories/editCat/'.$id);
			}
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('categories/editCat/'.$id);
		}
	}
	public function deleteCategory($id){
		$this->db->set('category_status','80');
		$this->db->where('id',$id);
		$query = $this->db->update('master_hardware_category_tbl');

		if($query){
			$this->session->set_flashdata('deleteCategory', 'Inactive successfully');
			redirect('categories');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('categories');
		}
	}

	public function activeCategory($id){
		$this->db->set('category_status','10');
		$this->db->where('id',$id);
		$query = $this->db->update('master_hardware_category_tbl');

		if($query){
			$this->session->set_flashdata('deleteCategory', 'Active successfully');
			redirect('categories');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('categories');
		}
	}
	/* public function getCategory(){
		$user_stored_proc 	= "CALL select_all_category_sp()";
        $query 				= $this->db->query($user_stored_proc);
        $result				= $query->result();
        $query->next_result(); 
		$query->free_result(); 
		return $result; 
	} */
	public function getCategoryBy($parent){
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		//$this->db->where('parent_category_id', $parent);
		$this->db->where('id', $parent);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result; 
	}
	public function getCatById($id){
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('id', $id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result; 
	}
	public function checkCategoryExist($category_code,$zone_id,$division_id){
		$this->db->select('category_code');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('category_code', $category_code);
		$this->db->where('zone_id', $zone_id);
		$this->db->where('division_id', $division_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
}