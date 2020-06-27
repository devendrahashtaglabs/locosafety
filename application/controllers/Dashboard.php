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
		$this->load->model('Maintenance_shops_model'); 
		$this->load->model('Maintenance_sections_model'); 
		$this->load->model('Dashboard_model'); 
		$this->load->model('Tickets_model'); 
		$this->load->model('Categories_model'); 
		$this->load->library('session');
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$this->load->model('Zones_model'); 
		$this->load->model('Divisions_model');  
		$data['title'] 		= 'Dashboard';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role			= '';
		if(isset($loggedInUserDetail->user_role)){
			$user_role = $loggedInUserDetail->user_role;
		}
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		$data['user_role'] 		= $user_role; 
		$data['user_zone'] 		= $user_zone; 
		$data['user_division'] 	= $user_division; 
		$allUser				= 0;
		if($user_role == '1'){
			$allUser	 		= $this->Users_model->getAdminCount($user_zone);
		}else{
			$allUser	 		= $this->Users_model->getUserCount($user_zone,$user_division);		
			$allUser	 		= count($allUser);		
		}
		if(!empty($allUser)){
			$data['userCount'] 	= $allUser;
		}
		//$allHardware			= $this->Hardwares_model->getHardwareCount($user_zone,$user_division);
		//$allHardware			= $this->Hardwares_model->getallhwcount($user_zone,$user_division);
		$hwstatus				= '10';
		$allHardware			= $this->Hardwares_model->Getallhardwarelist($user_zone,$user_division,$hwstatus);
		//echo "<pre>";print_r($allHardware);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		$data['hardwareCount']  = 0;
		if(!empty($allHardware)){
			$data['hardwareCount'] = count($allHardware);
		}
		//$allHMCount	= $this->Hardwares_model->getallMhwcount($user_zone,$user_division);
		$hwstatus				= '20';
		$allHMCount	= $this->Dashboard_model->getUnderMaintenance($hwstatus,$user_zone,$user_division);
		//echo "<pre>";print_r($allHMCount);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		if(!empty($allHMCount)){
			$data['hmCount'] 	= count($allHMCount);
		}
		$allShop		= $this->Shops_model->getShopCount($user_zone,$user_division);
		if(!empty($allShop)){
			$data['shopCount'] = count($allShop);
		}
		$shopIdArray = [];
		foreach($allShop as $singleShop){
			$shopIdArray[] = $singleShop->shop_id;			
		}
		if(!empty($shopIdArray)){
			$allSection		= $this->Sections_model->getSectionCount($shopIdArray);
			if(!empty($allSection)){
				$data['sectionCount'] = $allSection;
			}
		}
		$allMShop		= $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division);
		if(!empty($allMShop)){
			$data['mshopCount'] = count($allMShop);
		}
		$mshopIdArray = [];
		foreach($allMShop as $singleMShop){
			$mshopIdArray[] = $singleMShop->maintenance_shop_id;			
		}
		if(!empty($mshopIdArray)){
			$allMSection		= $this->Maintenance_sections_model->getMSectionCount($mshopIdArray);
			if(!empty($allMSection)){
				$data['mSectionCount'] = $allMSection;
			}
		}		
		$allTickets		= $this->Tickets_model->getRaiseTicket();
		if(!empty($allTickets)){
			$data['allticket'] = count($allTickets);		
		}
		$closedTicket 			= [];
		$openTicket 			= [];
		foreach($allTickets as $allTicket){
			if($allTicket->ticket_status == '50'){
				$closedTicket[] = $allTicket->ticket_status;
			}
			if($allTicket->ticket_status == '20'){
				$openTicket[] = $allTicket->ticket_status;
			}
		}
		if(!empty($closedTicket)){
			$data['closedTicket'] = count($closedTicket);
		}
		if(!empty($openTicket)){
			$data['openTicket'] = count($openTicket);
		}		
		$this->load->view('header',$data);
		$this->load->view('dashboard/index',$data);
		$this->load->view('footer',$data);
	}
	public function getfiltermapall($status=NULL){
		$loggedInUserDetail 			= $this->session->userdata('loggedInUserDetail');		
		$data['user_zone'] 				= $loggedInUserDetail->user_zone;
		$data['user_division'] 			= $loggedInUserDetail->user_division;
		$data['status'] 				= $status;
		
		$data['title'] 		= 'Dashboard';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role			= '';
			if(isset($loggedInUserDetail->user_role)){
			$user_role = $loggedInUserDetail->user_role;
		}
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		$data['user_role'] 		= $user_role; 
		$data['user_zone'] 		= $user_zone; 
		$data['user_division'] 	= $user_division; 
		
		
		//$this->load->view('header',$data);
		$this->load->view('dashboard/getfiltermapall',$data);
		//$this->load->view('footer',$data);		
	}
	public function getfiltermap($status=NULL){
		$loggedInUserDetail 			= $this->session->userdata('loggedInUserDetail');		
		$data['user_zone'] 				= $loggedInUserDetail->user_zone;
		$data['user_division'] 			= $loggedInUserDetail->user_division;
		$data['status'] 				= $status;
		
		$data['title'] 		= 'Dashboard';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role			= '';
			if(isset($loggedInUserDetail->user_role)){
			$user_role = $loggedInUserDetail->user_role;
		}
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		$data['user_role'] 		= $user_role; 
		$data['user_zone'] 		= $user_zone; 
		$data['user_division'] 	= $user_division; 
		
		
		//$this->load->view('header',$data);
		$this->load->view('dashboard/getfiltermap',$data);
		//$this->load->view('footer',$data);		
	}

	public function dashboard_config(){
		$data['title'] 		= 'Dashboard Setting';
		$loggedInUserDetail 		= $this->session->userdata('loggedInUserDetail');
		$user_zone 					= $loggedInUserDetail->user_zone;
		$user_division 				= $loggedInUserDetail->user_division;
		$data['shopData'] 			= $this->Shops_model->getShopCount($user_zone,$user_division);
		
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');		
		$data['user_zone'] 				= $loggedInUserDetail->user_zone;
		$data['user_division'] 			= $loggedInUserDetail->user_division;		
		$this->load->view('header',$data);
		$this->load->view('dashboard/dashboard_config',$data);
		$this->load->view('footer',$data);
	
	}	
	
	public function insertmapsection(){
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');	
		if(!empty($this->input->post('submit'))){
			$InsertDate = array(					
				'user_zone'                     =>		$loggedInUserDetail->user_zone,		
				'user_division'			=>		$loggedInUserDetail->user_division,		
				'section_id'			=>		$this->input->post('hardware_section_id'),		
				'section_position'		=>		$this->input->post('section_pos'),		
				'status'			=>		10,		
				'created'			=>		date('Y-m-d H:i:s'),		
				'modified'			=>		date('Y-m-d H:i:s'),
			);
			$ResultData = $this->Dashboard_model->insertTableDate('section_map_mapping_tbl',$InsertDate);
			if($ResultData > 0){
				$this->session->set_flashdata('success', 'Section map Successfully.');
				redirect('dashboard/dashboard_config');
			}else{
				$this->session->set_flashdata('error', 'Please try again.');
				redirect('dashboard/dashboard_config');
			}
		}else{
			redirect('dashboard/dashboard_config');
		}
	}
	
	public function insertmapdata(){	
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');	
		if(!empty($this->input->post('submit'))){
	
			$target_dir = "uploads/dashboard/";
			$target_file_name = time().basename($_FILES["imageN"]["name"]);
			$target_file = $target_dir . $target_file_name;
			$uploadOk = 1;
			if (move_uploaded_file($_FILES["imageN"]["tmp_name"], $target_file)) {
				$imageName = $target_file_name;
			} else {
				$imageName = "";
			}
			
			$InsertDate = array(					
				'user_zone'		=>	$loggedInUserDetail->user_zone,		
				'user_division'	=>	$loggedInUserDetail->user_division,		
				'row'			=>	$this->input->post('row'),		
				'column'		=>	$this->input->post('column'),		
				'status'		=>	10,		
				'image'			=>	$imageName,		
				'created'		=>	date('Y-m-d H:i:s'),		
				'modified'		=>	date('Y-m-d H:i:s'),
			);
			$ResultData = $this->Dashboard_model->insertTableDate('map_image_dashboard_tbl',$InsertDate);
			if($ResultData > 0){
				$this->session->set_flashdata('success', 'Map Data inserted Successfully.');
				redirect('dashboard/dashboard_config');
			}else{
				$this->session->set_flashdata('error', 'Please try again.');
				redirect('dashboard/dashboard_config');
			}			
		}else{
			redirect('dashboard/dashboard_config');
		}
	}
	
	public function updatemapdata(){	
		$InsertDate = array();
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');	
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES["image"])){
				$target_dir = "uploads/dashboard/";
				$target_file_name = time().basename($_FILES["image"]["name"]);
				$target_file = $target_dir . $target_file_name;
				$uploadOk = 1;
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					$imageName = $target_file_name;
					
				} else {
					$imageName = "";				
				}
			}
			$ID = $this->input->post('id');
			$InsertDate = array(					
				'user_zone'		=>	$loggedInUserDetail->user_zone,		
				'user_division'     	=>	$loggedInUserDetail->user_division,		
				'row'			=>	$this->input->post('row'),		
				'column'		=>	$this->input->post('column'),			
				'modified'		=>	date('Y-m-d H:i:s'),
			);
			if($imageName != ""){
				$InsertDate['image'] = $imageName;
			}
			$ResultData = $this->Dashboard_model->updateTableDate('map_image_dashboard_tbl',$InsertDate,$ID);
			if($ResultData > 0){
				$this->session->set_flashdata('success', 'Map Data inserted Successfully.');
				redirect('dashboard/dashboard_config');
			}else{
				$this->session->set_flashdata('error', 'Please try again.');
				redirect('dashboard/dashboard_config');
			}			
		}else{
			redirect('dashboard/dashboard_config');
		}
	}
	
	function deletesection(){
	
		$id = $_POST['map_id'];
		$result = $this->Dashboard_model->deleteSection($id);
	
		if($result>0){
			echo  1;
		}else{
			echo 0;
		}
		
	}
	public function getSectionByShopOnDash()
	{		
		$postData 		= $this->input->post();
		$shopId 		= $postData['shop_id'];
		$sections 		= $this->Users_model->getShopSection($shopId);
                
//		$allmapsections = $this->Dashboard_model->getSectionOnDash();
//		
//		$mappedsection 	= [];
//		foreach($allmapsections as $allmapsection){
//			$mappedsection[] = $allmapsection->section_id;
//		}
		
		$html 			= "";
                foreach($sections as $res){
//                    if(!in_array($res->section_id,$mappedsection)){
                    $html .= '<option value="'.$res->section_id.'">'.$res->section_name.'</option>'; 
//                    }
                }
		
		print_r($html);
		exit;
		print_r($html);
	}
        
	public function getSectionByShopOnDashNew()
	{		
		$postData 		= $this->input->post();
		$shopId 		= $postData['shop_id'];
		$sections 		= $this->Users_model->getShopSection($shopId);
                
		$allmapsections = $this->Dashboard_model->getSectionOnDash();
		
		$mappedsection 	= [];
		foreach($allmapsections as $allmapsection){
			$mappedsection[] = $allmapsection->section_id;
		}
		
		$html 			= "";
                foreach($sections as $res){
                    if(!in_array($res->section_id,$mappedsection)){
                            $html .= '<option value="'.$res->section_id.'">'.$res->section_name.'</option>'; 
                    }
                }
		
		print_r($html);
		exit;
		print_r($html);
	}
        function updatemeta(){
             
            $loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
            if($this->input->post('meta_key')){                
                
                $dataArr = array(
                    'zone'		=>	$loggedInUserDetail->user_zone,		
		    'division'     	=>	$loggedInUserDetail->user_division,
                    'meta_key'          =>      'JIB_EOT_CAT_ID',
                    'meta_status'       =>      '10',
                    'meta_value'        =>      $this->input->post('meta_value'),                    
                );                    
                
                if($this->input->post('meta_id')){
                    $id = $this->input->post('meta_id');                    
                   $ResultData = $this->Dashboard_model->updatemeta($id,$dataArr);
                }else{
                   $ResultData =  $this->Dashboard_model->insertmeta($dataArr);
                }
                
                if($ResultData > 0){
                        $this->session->set_flashdata('success', 'Category updated Successfully.');
                        redirect('dashboard/dashboard_config');
                }else{
                        $this->session->set_flashdata('error', 'Please try again.');
                        redirect('dashboard/dashboard_config');
                }                
            }
            
        }
	
}