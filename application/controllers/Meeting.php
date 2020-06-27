<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Meeting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Categories_model');
		$this->load->model('Users_model');
		$this->load->model('Meeting_model');		
		$this->load->model('Shops_model');
		$this->load->model('Sections_model');
		$this->load->model('Notifications_model');
		$this->load->model('Maintenance_shops_model');
		$this->load->model('Maintenance_sections_model');
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){
			redirect('login');
		} 
	}
	public function index()
	{
		$data['meetingData'] = $this->Meeting_model->GetAllMeeting();
		$data['title'] 		= 'Safety Meeting';
		$this->load->view('header',$data);
		$this->load->view('meeting/index',$data);
		$this->load->view('footer',$data);
	}
	
	public function add(){
		$data['title'] 		= 'Add Meeting';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$data['Users'] = $this->Users_model->GetAllUserByZoneDiv($zone_id,$division_id);
		$data['Shops'] = $this->Shops_model->getShopActive($zone_id,$division_id,10);
		$data['M_Shops'] = $this->Maintenance_shops_model->getActiveMShop($zone_id,$division_id);
		$data['allmeeting'] = $this->Meeting_model->GetAllMeeting();
		$this->load->view('header',$data);
		$this->load->view('meeting/add',$data);
		$this->load->view('footer',$data);
	}
	public function addAction(){
		
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		if($this->input->post('submit')){
			$ShopID 		= $this->input->post('ShopID');
			$Section 		= $this->input->post('Section');
			$M_ShopID 		= $this->input->post('M_ShopID');
			$M_SectionID 	= $this->input->post('M_SectionID');
			$shop_ids 		= !empty($ShopID)? implode(',',$ShopID) :'';
			$section_ids 	= !empty($Section)? implode(',',$Section) :'';
			$m_shop_ids 	= !empty($M_ShopID)? implode(',',$M_ShopID) :'';
			$m_section_ids 	= !empty($M_SectionID)? implode(',',$M_SectionID) :'';
			$usertype 		= $this->input->post('UserType');
			$user_role_id 	= '';
			if($usertype == 'manager'){
				$user_role_id = '3';
			}elseif($usertype == 'shop'){
				$user_role_id = '4';				
			}elseif($usertype == 'section'){
				$user_role_id = '5';				
			}elseif($usertype == 'm_shop'){
				$user_role_id = '6';				
			}elseif($usertype == 'm_section'){
				$user_role_id = '7';				
			}
			$managerlist 	= $this->input->post('managerlist');
			$shopInlist 	= $this->input->post('shopInlist');
			$sectionInlist 	= $this->input->post('sectionInlist');
			$mshopInlist 	= $this->input->post('mshopInlist');
			$msectionInlist = $this->input->post('msectionInlist');
			$userslist 		= array_merge($managerlist,$shopInlist,$sectionInlist,$mshopInlist,$msectionInlist);
			$arrData = array(
				'title'					=>	htmlentities($this->input->post('title')),
				'description'			=>	htmlentities($this->input->post('description')),
				'shop_id'				=>	$shop_ids,
				'section_id'			=>	$section_ids,
				'm_shop_id'				=>	$m_shop_ids,
				'm_section_id'			=>	$m_section_ids,
				'user_ids'				=>	implode(',',$userslist),
				'user_role'				=>	$user_role_id,
				'prev_meeting'			=>	$this->input->post('prevmeeting'),
				'location'				=>	$this->input->post('location'),
				'meeting_date'			=>	date('Y-m-d',strtotime($this->input->post('date'))),
				'meeting_in_time'		=>	date('H:i:s',strtotime($this->input->post('intime'))),
				'meeting_out_time'		=>	date('H:i:s',strtotime($this->input->post('outtime'))),
				'zone'					=>	$zone_id,
				'division'				=>	$division_id,
				'status'				=>	10,
				'created_by'			=>	$loggedInUserDetail->user_info_id,
				'created'				=>	date('Y-m-d H:i:s'),
				'modified'				=>	date('Y-m-d H:i:s'),
			);
			//echo "<pre>";print_r(arrData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			$response =  $this->Meeting_model->insertMeeting($arrData);
			
			if($response){
				$this->session->set_flashdata('Success', 'Safety Meeting Added successfully');
				redirect('meeting/get_meeting_list');
			}else{
				$this->session->set_flashdata('Error', 'Error! Safety Meeting not added.');
				redirect('meeting');
			}
		}
		
	}
	
	public function agenda( $MapDate , $mapID){
		
		if($MapDate != '' && $mapID != ''){
			$data['title'] 		= 'Add Meeting Agenda';			
			$data['MapDate'] = date('d-m-Y',strtotime($MapDate));
			$data['mapID'] = $mapID;			
			$data['users'] = $this->Users_model->GetAllUserForAgenda();
			$this->load->view('header',$data);
			$this->load->view('meeting/add_agenda',$data);
			$this->load->view('footer',$data);		
		}else{
			redirect('meeting');
		}
		
	}
	
	public function addAgenda(){
		
		
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$title = $_POST['title'];
		$description = $_POST['description'];
		$users = implode(',',$_POST['users']);
		
		//$i = 0;
		//foreach($users as $row){			
			$insertData = array(
				'title'				=>		$title,
				'description'		=>		$description,
				'user_ids'			=>		$users,
				'meeting_id'		=>		$this->input->post('meeting_id'),
				'start_time'		=>		'0:00',
				'end_time'			=>		'23:59',
				'start_date'		=>		date('Y-m-d',strtotime($this->input->post('startdate'))),
				'end_date'			=>		date('Y-m-d',strtotime($this->input->post('enddate'))),
				'status'			=>		10,
				'created'			=>		date('Y-m-d H:i:s'),
				'modified'			=>		date('Y-m-d H:i:s'),
				'created_by'		=>		$loggedInUserDetail->user_info_id,
			);		
		$response =  $this->Meeting_model->insertAgend($insertData);			
			//$i++;
		//}
			
		$MapDate =  $_POST['MapDate'];
		$mapID =  $_POST['mapID'];
			
		if($response){
			$this->session->set_flashdata('Success', 'Agenda Added successfully');
			if($_POST['addmore'] == "Add More"){
				redirect('meeting/agenda/'.$MapDate.'/'.$mapID);
			}else{
				redirect('meeting');
			}
		}else{
			$this->session->set_flashdata('Error', 'Error! Safety Agenda not added.');
			redirect('meeting');
		}
		
	}
	
	public function checkmapid(){
		
		$map_id = $_POST['map_id'];
		$response = $data['MapData'] =   $this->Meeting_model->CheckMapid($map_id);	
		if(count($response) > 0){
			$this->load->view('meeting/ajaxlist',$data);
		}else{
			echo 0;
		}
	}
	
	public function getuserbyshop()
	{
		$shop_ids 		= $this->input->post('shop_id');
		$section_ids 	= $this->input->post('section_id');
		$m_shop_ids 	= $this->input->post('m_shop_id');
		$m_section_ids 	= $this->input->post('m_section_id');
		$data['title']	= '';
		$shop_id 		= $shop_ids;
		$SectionID		= $section_ids;
		$m_shop_id 		= $m_shop_ids;
		$m_SectionID	= $m_section_ids;
		$UserList 		= '';
		$SectionList 	= '';
		$MSectionList 	= '';
		$allUserData 	= [];
		//$allUserDetail 	= [];
		if(!empty($shop_id) || !empty($m_shop_id)){
			if(!empty($shop_id)){
				foreach($shop_id as $shid){
					$allUserData['shop'][] = $this->Meeting_model->getUserByShopId($shid,'4');
				}
			}
			if(!empty($m_shop_id)){
				foreach($m_shop_id as $m_shid){
					$allUserData['mshop'][] = $this->Meeting_model->getUserByMShopId($m_shid);
				}
			}
			if($SectionID != ''){
				foreach($SectionID as $Section_id){
					$allSectionData = $this->Sections_model->getSectionBy($Section_id);
					$allUserData['section'][] 	= $this->Meeting_model->getUserByShopIdAndSectionID($allSectionData->shop_id,$Section_id);
				}					
			}
			if($m_SectionID != ''){
				foreach($m_SectionID as $m_Section_id){
					$allSectionData = $this->Maintenance_sections_model->getMSectionBy($m_Section_id);
					$allUserData['msection'][] 	= $this->Meeting_model->getUserByMShopIdAndSectionID($allSectionData->maintenance_shop_id,$m_Section_id);
				}					
			}
			$shopuserlist = ''; 
			if(!empty($allUserData['shop'])){
				$shopuserlist = $this->get_user_list($allUserData['shop']);
			}
			$mshopuserlist = ''; 
			if(!empty($allUserData['mshop'])){
				$mshopuserlist = $this->get_user_list($allUserData['mshop']);
			}
			$sectionuserlist = ''; 
			if(!empty($allUserData['section'])){
				$sectionuserlist = $this->get_user_list($allUserData['section']);
			}
			$msectionuserlist = ''; 
			if(!empty($allUserData['msection'])){
				$msectionuserlist = $this->get_user_list($allUserData['msection']);
			}
			if($SectionID == ''){
				$allSection 	= [];
				$allSectionData = [];
				if(!empty($shop_id)){
					foreach($shop_id as $shid){
						$allSection[] = $this->Sections_model->getSectionByShopID($shid);
					}
				}
				foreach($allSection as $key=>$value){
					foreach($value as $val){
						$allSectionData[] = $val;
					}
				}
				
				//$SectionList .= '<option value="">-All-</option>';
				if(!empty($allSectionData)){
					foreach($allSectionData as $Section){
						$SectionList .= '<option value="'.$Section->section_id.'">'.$Section->section_name.'</option>';
					}
				}else{
					$SectionList .= '<option value="">No section found. </option>';
				}
			}else{
				$SectionID = '';
			}
			if($m_SectionID == ''){
				$allSection 	= [];
				$allSectionData = [];
				if(!empty($m_shop_id)){
					foreach($m_shop_id as $m_shid){
						$allSection[] = $this->Maintenance_sections_model->getMSectionByMshopId($m_shid);
					}
				}
				foreach($allSection as $key=>$value){
					foreach($value as $val){
						$allSectionData[] = $val;
					}
				}
				
				//$SectionList .= '<option value="">-All-</option>';
				if(!empty($allSectionData)){
					foreach($allSectionData as $Section){
						$MSectionList .= '<option value="'.$Section->maintenance_section_id.'">'.$Section->maintenance_section_name.'</option>';
					}
				}else{
					$MSectionList .= '<option value="">No section found. </option>';
				}
			}else{
				$m_SectionID = '';
			}
			
		}else{
			$allUserDetail = $this->Meeting_model->getUserByShopId('','');
			foreach($allUserDetail as $singleUserData){
				$name = ''; 
				if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
					$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
				}
				$UserList .= '<option value="'.$singleUserData->user_info_id.'" selected="selected" > '.$name.' </option>';
			}
		}
		//$res['UserList'] 		=  $UserList;
		$res['shopuserlist'] 		=  $shopuserlist;
		$res['mshopuserlist'] 		=  $mshopuserlist;
		$res['sectionuserlist'] 	=  $sectionuserlist;
		$res['msectionuserlist'] 	=  $msectionuserlist;
		$res['SectionList'] 		=  $SectionList;
		$res['MSectionList'] 		=  $MSectionList;
		//$res['usercount'] 			=  count($allUserDetail);		
		print_r(json_encode($res));
	}	
	public function getMuserbyshop($ShopID,$SectionID=NULL)
	{
		$data['title']			= '';
		$shop_id 				= $ShopID;
		$UserList 				= '';
		$SectionList 			= '';
		
		if(!empty($shop_id)){
			$allUserData = $this->Meeting_model->getUserByMShopId($shop_id);
			
			if($SectionID != ''){				
				$allUserData = $this->Meeting_model->getUserByMShopIdAndSectionID($shop_id,$SectionID);		
						
			}
			
			if(!empty($allUserData)){
				//$UserList .= '<option value="">-All-</option>';
				foreach($allUserData as $singleUserData){
					$name = ''; 
					if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
						$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
					}
					$UserList .= '<option value="'.$singleUserData->user_info_id.'" selected="selected">'.$name.'</option>';
				}
			}else{
				$UserList .= '<option value="">No User Mapped </option>';
			}
			if($SectionID == ''){
				$allSectionData = $this->Maintenance_sections_model->getMSectionByMshopId($shop_id);
						
				if(!empty($allSectionData)){
					$SectionList .= '<option value="">-All-</option>';
					foreach($allSectionData as $Section){
						$SectionList .= '<option value="'.$Section->maintenance_section_id.'">'.$Section->maintenance_section_name.'</option>';
					}
				}else{
					$SectionList .= '<option value="">No section found. </option>';
				}
			}else{
				$SectionID = '';
			}
			
		}else{
			$UserList .= '<option value="">No User Mapped. </option>';
		}
		
		$res['UserList'] 	=  $UserList;
		$res['SectionList'] =  $SectionList;
		print_r(json_encode($res));
		exit;
		
	}
	
	function getuserbyusertype($type = null){
		$UserList 		= '';
		$allUserData 	= $this->Meeting_model->GetAllUserByType($type);
		if(!empty($allUserData)){
			//$UserList .= '<option value="">-All-</option>';
			foreach($allUserData as $singleUserData){
				$name = ''; 
				if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
					$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
				}
				$UserList .= '<option value="'.$singleUserData->user_info_id.'" selected="selected" >'.$name.'</option>';
			}
		}else{
			$UserList .= '<option value="">No User Mapped </option>';
		}
		$res['UserList'] 	= $UserList;
		$res['Usercount'] 	= count($allUserData);
		$res['Usertype'] 	= $type;
		print_r(json_encode($res));
		exit;
	}
	public function get_user_list ($allUserData){
		$msectionuserlist = '';
		if(!empty($allUserData)){
			$allmsectionUserDetail 	= [];
			foreach($allUserData as $key=>$value){
				foreach($value as $val){
					$allmsectionUserDetail[] = $val;
				}
			}
			if(!empty($allmsectionUserDetail)){					
				foreach($allmsectionUserDetail as $singleUserData){
					$name = ''; 
					if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
						$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
					}
					$msectionuserlist .= '<option value="'.$singleUserData->user_info_id.'" selected="selected" > '.$name.' </option>';
				}
			}else{
				$msectionuserlist .= '<option value="">No User Mapped </option>';
			}
		}
		return $msectionuserlist;
	}	
	// Yash code 
	public function get_meeting_list (){
		$data['meetingData'] = $this->Meeting_model->get_meeting_list();
		$data['title'] 		 = 'Meeting List';
		$this->load->view('header',$data);
		$this->load->view('meeting/meeting_list',$data);
		$this->load->view('footer',$data);
	}
	public function get_agenda_list (){
		$data['title'] 		= 'Agenda List';		
		$id 				= $this->input->post('meeting_id'); 
	    $data['agendaData'] = $this->Meeting_model->get_agenda_list($id);
		$this->load->view('meeting/agenda_list',$data);	
	}
}