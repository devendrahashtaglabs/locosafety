<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Users_model'); 
		$this->load->model('Divisions_model'); 
		$this->load->model('Zones_model'); 
		$this->load->model('Shops_model'); 
		$this->load->model('Sections_model');  
		$this->load->model('Reports_model');  
		$this->load->model('Hardwares_model');  
		$this->load->model('Maintenance_shops_model'); 
		$this->load->model('Maintenance_sections_model'); 
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
		$config = array(
				'upload_path' 		=> "./uploads/",
				'allowed_types' 	=> "jpg|png|jpeg",
				'overwrite' 		=> TRUE,
				'max_size'			=> "2048000",
			);
		$this->load->library('upload', $config);
	}
	public function index()
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_roles			= $loggedInUserDetail->user_role;
		if($user_roles != '1'){
			$this->load->model('Reports_model');
			$user_status 		= $this->input->post('user_status');
			$user_ids 			= $this->input->post('user_ids');
			$data['title'] 		= 'All Users';
			$status				= $this->input->get('searchByStatus');
			$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
			$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
			$user_role			= '';
			
			$user_zone 			= $loggedInUserDetail->user_zone;
			$user_division 		= $loggedInUserDetail->user_division;
			if(isset($loggedInUserDetail->user_role)){
				$user_role = $loggedInUserDetail->user_role;
			}
			if($user_role == '3'){
			//	$data['userData'] 	= $this->Users_model->getAllUser();
				$data['userData'] 	= $this->Users_model->getUserCount($user_zone,$user_division,'all');
			}else{
				if(!empty($user_role)){
					//$data['userData'] 	= $this->Users_model->getUser($user_role);
					$data['userData'] 	= $this->Users_model->getUserCount($user_zone,$user_division,'all');
				}
			}
			//echo "<pre>";print_r($data['userData']);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			$data['userstatus'] = $this->Users_model->getStatus($user_status, $user_ids);						
			$data['status'] 	= $status;	
			$this->load->view('header',$data);
			$this->load->view('users/index',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('login');
		}
	}
	public function alladmin()
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if($user_role == '1'){
			$data['title'] 	= 'All Users';
			$status			=  $this->input->get('searchByStatus');

			if( $status === NULL ){
				//$status					= '10';
				//$data['userData'] 		= $this->Users_model->getFilterUser($status); 
				$data['userData'] 		= $this->Users_model->getFilterUser(); 
				//$data['userData'] 		= $this->Users_model->getUser($loggedInUserDetail->user_info_id);
			}elseif($status == 'all'){			
				$data['userData'] 		= $this->Users_model->getAdmin();	 		
			}else{			
				$data['userData'] 		= $this->Users_model->getFilterUser($status);	
			}
			$loggedInAdmin 				= $this->session->userdata('loggedInAdmin');
			//$data['userData'] 		= $this->Users_model->getUser();	 		
			$data['status'] 		= $status;	
			$this->load->view('header',$data);
			$this->load->view('users/alladmin',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('login');
		}
	}
	public function addAdmin()
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if($user_role == '1'){
			$data['title'] 			= 'Add User';
			$data['loginType'] 		= $this->Users_model->getRoleType();
			$data['zoneData'] 		= $this->Zones_model->getZone();
			$data['divisionData'] 	= $this->Divisions_model->getDivision();
			$data['shopData'] 		= $this->Shops_model->getShop();
			$data['sectionData'] 	= $this->Sections_model->getSection();
			$data['getData']		= $this->input->get();
			if($this->input->post('submit')){
				//$gRecaptchaResponse = $this->input->post('g-recaptcha-response');
				//$errMsg = "";
				/* if(isset($gRecaptchaResponse) && !empty($gRecaptchaResponse))
				{
					$secret = '6LepE8IUAAAAAMjqvAmbtMgWsEWPvhN0oO64iGbx';
					$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$gRecaptchaResponse);
					$responseData = json_decode($verifyResponse);
					if($responseData->success){
						$succMsg = 'Your contact request have submitted successfully.';
					}else{
						$errMsg = 'Robot verification failed, please try again.';
						//$data['errMsg'] = $errMsg;
						$this->load->view('login');
					}
				} */
				//$this->form_validation->set_rules('user_email','Email id','required|valid_email|is_unique[user_info_tbl.user_email]');
				$this->form_validation->set_rules('user_phone','Mobile Number','required|is_unique[user_info_tbl.user_mobile]');
				$this->form_validation->set_rules('user_division','Division','required|is_unique[user_info_tbl.user_division]');
				//echo "<pre>";print_r($this->input->post());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
				if($this->form_validation->run()){
					$postData = $this->input->post(); 
					//echo "<pre>";print_r($postData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
					unset($postData['submit']);
					if(!empty($data['getData'])){
						$postData['user_zone'] 		= $data['getData']['zoneId'];	
						$postData['user_division'] 	= $data['getData']['divisionId'];
					}				
					$currentDate	= date('Y-m-d h:i:s a', time());
					if(!empty($postData['user_dob'])){
						$date 						= date_create($postData['user_dob']);
						$postData['user_dob'] 		= date_format($date,"Y-m-d");
					}
					$postData['user_pass'] 		= md5($postData['user_pass']);
					$uploadedData 				= [];
					if($this->upload->do_upload('user_profile_pic'))
					{
						$upload_data 	= array('upload_data' => $this->upload->data());
						$uploadedData	= $upload_data['upload_data'];
					}
					else
					{
						$error = array('error' => $this->upload->display_errors());
					}
					if(empty($postData['section_id'])){
						$postData['section_id'] = 'Null';
					}
					if(empty($postData['shop_id'])){
						$postData['shop_id'] = 'Null';
					}
					if(!empty($uploadedData['file_name'])){
						$postData['user_profile_pic'] = $uploadedData['file_name'];
					}					
					$postData['user_status'] = '10';
					$user_type      =  $postData['user_type'];
					$currentUserId 	= $this->session->userdata('loggedInAdmin');
					if(isset($postData['shop_id'])){
						$shop_id        =  $postData['shop_id'];
					}else{
						$shop_id =  '';			
					}
					if(isset($postData['shop_id'])){
						$section_id     =  $postData['section_id'];
					}else{
						$section_id =  '';			
					}
					$user_f_name    =  $postData['user_f_name'];
					$user_l_name    =  $postData['user_l_name'];
					$user_email     =  $postData['user_email'];
					$user_phone     =  $postData['user_phone'];
					$user_pass      =  $postData['user_pass'];
					$user_pin      	=  $postData['user_pin'];
					$user_division  =  $postData['user_division']; 
					$user_zone      =  $postData['user_zone'];
					$user_address   =  $postData['user_address'];
					$user_dob       =  $postData['user_dob'];
					$user_gender    =  $postData['user_gender'];
					if(isset($postData['user_profile_pic'])){
						$user_profile_pic =  $postData['user_profile_pic'];
					}else{
						$user_profile_pic =  'no-available.jpg';			
					}
					$user_status 	= $postData['user_status'];
					$userInfoData 	= array(
										'user_zone'   		=>  $user_zone,
										'user_division'   	=>  $user_division,
										'user_role'   		=>  $user_type,
										'user_email'   		=>  $user_email,
										'user_mobile'   	=>  $user_phone,
										'user_pin'   		=>  $user_pin,
										'user_pass'   		=>  $user_pass,
										'user_status'   	=>  $user_status,
										'user_add_date'   	=>  $currentDate,
										'user_created_by'   =>  $currentUserId,
									);
					if(isset($userInfoData)){
						$table 		= 'user_info_tbl';
						$insertedUserId = $this->Users_model->insertAdmin($userInfoData,$table);
						if(isset($insertedUserId)){
							$userPersonalData 	= array(
												'user_info_id'   	=>  $insertedUserId,
												'user_f_name'   	=>  $user_f_name,
												'user_l_name'   	=>  $user_l_name,
												'user_dob'   		=>  $user_dob,
												'user_gender'   	=>  $user_gender,
												'user_address'   	=>  $user_address,
												'user_profile_pic'  =>  $user_profile_pic,
												'user_add_date'   	=>  $currentDate,
												'user_created_by'   =>  $currentUserId,
											);
							$tables 		= 'user_details_tbl';
							$insertedDetailId = $this->Users_model->insertAdmin($userPersonalData,$tables);
							if(isset($insertedDetailId)){
								$this->session->set_flashdata('success', 'User Added successfully');
								redirect('users/alladmin');
							}else{
								$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
								redirect('users/alladmin');
							} 
						}else{
							$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
							redirect('users/alladmin');
						} 
					}
					
				}else{
					$postData = $this->input->post();
					if(isset($postData['user_zone'])){
						$user_zone = $postData['user_zone'];
					}else{
						$user_zone = $this->input->get('zoneId');
					}
					$data['divisionData'] 	= $this->Divisions_model->getDivisionByZone($user_zone);
					
					$this->load->view('header',$data);
					$this->load->view('users/add_admin',$data);
					$this->load->view('footer',$data);	
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('users/add_admin',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('login');
		}
	}
	public function editAdmin($id)
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if($user_role == '1'){
			$data['title'] 				= 'Edit User';
			$getUserDataBy['user_id']	= $id;
			$data['editedId'] 			= $id;
			$editUserData				= $this->Users_model->getUserById($id);
			$data['editUserData'] 		= $editUserData;
			$data['loginType'] 			= $this->Users_model->getRoleType();
			$data['divisionData'] 		= $this->Divisions_model->getDivision();
			$data['zoneData'] 			= $this->Zones_model->getZone();
			if($this->input->post('update')){
				$userDataById 			= $data['editUserData'];
				$postData 				= $this->input->post();
				unset($postData['update']);
				$uploadedData 				= [];
				if($this->upload->do_upload('user_profile_pic'))
				{
					$upload_data 	= array('upload_data' => $this->upload->data());
					$uploadedData	= $upload_data['upload_data'];
				}
				else
				{
					$error = array('error' => $this->upload->display_errors());
				}
				if(!empty($uploadedData['file_name'])){
					$postData['user_profile_pic'] = $uploadedData['file_name'];
				}
				if(isset($postData['user_profile_pic'])){
					$user_profile_pic =  $postData['user_profile_pic'];
				}else{
					if(!empty($editUserData->user_profile_pic)){
						$user_profile_pic =  $editUserData->user_profile_pic;			
					}else{
						$user_profile_pic =  'no-available.jpg';
					}					
				}
				//echo "<pre>";print_r($user_profile_pic);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				$date 						= date_create($postData['user_dob']);
				$postData['user_dob'] 		= date_format($date,"Y-m-d");
				$user_f_name        		= $postData['user_f_name'];
				$user_l_name        		= $postData['user_l_name'];
				$user_address       		= $postData['user_address'];
				$user_dob           		= $postData['user_dob'];
				$user_gender        		= $postData['user_gender'];
                                if(!empty($postData['user_division'])){
                                    $user_division      		= $postData['user_division'];   
                                }
				$user_email      			= $postData['user_email'];   
				$user_mobile      			= $postData['user_phone'];   
				$currentDate	 			= date('Y-m-d h:i:s a', time());
				$currentUserId 				= $this->session->userdata('loggedInAdmin');
				$updatedInfoData       	 	= array(
					'user_email'     		=> $user_email,
					'user_mobile'     		=> $user_mobile,
					'user_update_date'     	=> $currentDate,
					'user_updated_by'     	=> $currentUserId,
				);
				$updatedData       	 		= array(
					'user_f_name'       	=> $user_f_name,
					'user_l_name'       	=> $user_l_name,
					'user_address'      	=> $user_address,
					'user_dob'          	=> $user_dob,
					'user_gender'       	=> $user_gender,
					'user_profile_pic'  	=> $user_profile_pic,
					'user_update_date'     	=> $currentDate,
					'user_updated_by'     	=> $currentUserId,
				); 
				$user_email 	= $editUserData->user_email;
				$user_mobile 	= $editUserData->user_mobile;
				if($user_mobile != $postData['user_phone']){
					$this->form_validation->set_rules('user_phone','Mobile Number','required|is_unique[user_info_tbl.user_mobile]');
				}else{
					$this->form_validation->set_rules('user_phone','Mobile Number','required');
				}
				if($user_email != $postData['user_email']){
					$this->form_validation->set_rules('user_email','Email id','required|valid_email|is_unique[user_info_tbl.user_email]');
				}else{
					$this->form_validation->set_rules('user_email','Email id','required');
				}
				if($this->form_validation->run()){
					if(!empty($updatedInfoData)){
						$table = 'user_info_tbl';
						$query = $this->Users_model->updateUser($updatedInfoData,$id,$table);
						if($query){
							if(!empty($updatedInfoData)){
								$tables = 'user_details_tbl';
								$newquery 	= $this->Users_model->updateUser($updatedData,$id,$tables);
								if($newquery){
									$this->session->set_flashdata('updateUser', 'Admin updated Successfully');
									redirect('users/editAdmin/'.$id);
								}else{
									$this->session->set_flashdata('errorUser', 'Somthing went worng. Error!!');
									redirect('users/editAdmin/'.$id);
								}
							}
						}else{
							$this->session->set_flashdata('errorUser', 'Somthing went worng. Error!!');
							redirect('users/editAdmin/'.$user_id);
						}
					}
				}else{
					$this->load->view('header',$data);
					$this->load->view('users/edit_admin',$data);
					$this->load->view('footer',$data);
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('users/edit_admin',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('login');
		}
	}
	public function viewUser($id)
	{
		$data['title'] 				= 'View User';
		$viewUserData				= $this->Users_model->getUserById($id);
		//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		$data['divisionData'] 		= $this->Divisions_model->getDivision();
		$data['zoneData'] 			= $this->Zones_model->getZone();
		if(!empty($viewUserData)){
			$data['userDataById'] 	= $viewUserData;
			$data['editedId'] 		= $id;
			$this->load->view('header',$data);
			$this->load->view('users/view_user',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('users');
		}
	}
    public function deleteUser($id)
	{
		$data['title'] 		= 'Delete User';
		$table 				= 'user_info_tbl';
		$currentDate	 	= date('Y-m-d h:i:s a', time());
		$currentUserId 		= $this->session->userdata('loggedInAdmin');
		$postData			= array(
								'user_status' 		 => '80',
								'user_update_date'   => $currentDate,
								'user_updated_by'    => $currentUserId,
							);
		$query 				= $this->Users_model->deleteUser($postData,$id,$table);
		if($query){
			$this->session->set_flashdata('success', 'User inactivated successfully');
			if($currentUserId == '1'){
				redirect('users/alladmin');
			}else{
				redirect('users');				
			}
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			if($currentUserId == '1'){
				redirect('users/alladmin');
			}else{
				redirect('users');				
			}
		} 
	}
	public function activateUser($id)
	{
		$data['title'] 		= 'Activate User';
		$table 				= 'user_info_tbl';
		$currentDate	 	= date('Y-m-d h:i:s a', time());
		$currentUserId 		= $this->session->userdata('loggedInAdmin');
		$postData			= array(
								'user_status' 		 => '10',
								'user_update_date'   => $currentDate,
								'user_updated_by'    => $currentUserId,
							);
		$query 				= $this->Users_model->activateUser($postData,$id,$table);
		if($query){
			$this->session->set_flashdata('success', 'User activated  successfully');
			if($currentUserId == '1'){
				redirect('users/alladmin');
			}else{
				redirect('users');				
			}
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			if($currentUserId == '1'){
				redirect('users/alladmin');
			}else{
				redirect('users');				
			}
		} 
	}
	public function getDivisionByZone()
	{
		$postData 		= $this->input->post();
		$zoneId 		= $postData['zone'];
		$divisions 		= $this->Divisions_model->getDivisionByZone($zoneId);
		$divisionList 	= '';
		foreach($divisions as $division){
			$divisionList .= '<option value="'.$division->division_id.'">'.$division->division_name.'</option>';
		}
		print_r($divisionList);
	}
	public function changePass($id)
	{
		$data['title'] 	= 'Change Password';
		$data['userId'] = $id;
		if($this->input->post('submit')){
			$postData = $this->input->post();
			unset($postData['user_cpass']);
			unset($postData['submit']);
			if(!empty($postData['user_old_pass'])){
				$postData['user_old_pass'] 		= md5($postData['user_old_pass']);
			}
			$passwordcheck = $this->Users_model->check_password($id,$postData['user_old_pass']);
			if(isset($passwordcheck)){
				unset($postData['user_old_pass']);
				if(!empty($postData['user_pass'])){
					$postData['user_pass'] 		= md5($postData['user_pass']);
				}
				$table = 'user_info_tbl';
				$query = $this->Users_model->changePass($postData,$id,$table);
				if($query){
					$this->session->set_flashdata('success', 'Password has been changed successfully');
					redirect('users/changePass/'.$id);
				}else{
					$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
					redirect('users/changePass/'.$id);
				} 
			}else{
				$this->session->set_flashdata('error', 'Old password is incorrect.');
				redirect('users/changePass/'.$id);
			}
		}else{		
			$this->load->view('header',$data);
			$this->load->view('users/changepass',$data);
			$this->load->view('footer',$data);
		}
	}
	/**** Neha Code ******/
	public function addUser()
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if($user_role != '1'){
			$data['title'] 			= 'Add User';
			$data['loginType'] 		= $this->Users_model->getLoginType();
			$data['divisionData'] 	= $this->Divisions_model->getDivision();
			$data['zoneData'] 		= $this->Zones_model->getZone();
			
			$data['shopData'] 		= $this->Shops_model->getShop();
			$data['sectionData'] 	= $this->Sections_model->getSection();
			$data['getData']		= $this->input->get();
			$loggedInDetail 		= $this->session->userdata('loggedInDetail');

			$loggedInAdmin 				= $this->session->userdata('loggedInAdmin');
			$data['zoneDataadmin'] 		= $this->Zones_model->getZonebyadmin($loggedInAdmin);
			$data['divisionDataadmin'] 		= $this->Divisions_model->getDivisionByadmin($loggedInAdmin);			
			if($this->input->post('submit')){
			
				$this->form_validation->set_rules('user_email','Email id','valid_email|is_unique[user_info_tbl.user_email]');
				$this->form_validation->set_rules('user_phone','Mobile Number','required|is_unique[user_info_tbl.user_mobile]');
				//$this->form_validation->set_rules('user_cpass', 'Confirm Password', 'required|matches[user_pass]');
				//$this->form_validation->set_rules('user_cpin', 'Confirm Pin', 'required|matches[user_pin]');
				$config = array(
						'upload_path' 		=> "./uploads/",
						'allowed_types' 	=> "jpg|png|jpeg",
						'overwrite' 		=> TRUE,
						'max_size'			=> "2048000",
					);
				$this->load->library('upload', $config);
				if($this->form_validation->run()){
					$postData = $this->input->post(); 
					unset($postData['register']);
					// if(!empty($data['getData'])){
					// 	$postData['user_zone'] 		= $data['getData']['zoneId'];	
					// 	$postData['user_division'] 	= $data['getData']['divisionId'];
					// }	
					// $postData['user_zone']	= $this->input->post('user_zone');
					// $postData['user_division']	= $this->input->post('user_division');
					$postData['loggedInAdmin']	= $loggedInAdmin;			
					$postData['currentDate']	= date('Y-m-d h:i:s a', time());
					$date 						= date_create($postData['user_dob']);
					$postData['user_dob'] 		= date_format($date,"Y-m-d");
					$postData['user_pass'] 		= md5($postData['user_pass']);
					$uploadedData 				= [];
					if($this->upload->do_upload('user_profile_pic'))
					{
						$upload_data 	= array('upload_data' => $this->upload->data());
						$uploadedData	= $upload_data['upload_data'];
					}
					else
					{
						$error = array('error' => $this->upload->display_errors());
					}
					if(empty($postData['section_id'])){
						$postData['section_id'] = 'Null';
					}
					if(empty($postData['shop_id'])){
						$postData['shop_id'] = 'Null';
					}
					$postData['user_profile_pic'] = $uploadedData['file_name'];			
					$postData['user_status'] = '80';
					//echo "<pre>";print_r($postData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );				
					$responce = $this->Users_model->insertUser($postData);
						if($responce){
							$this->session->set_flashdata('success', 'User Added successfully');
							redirect('users');
						}else{
							$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
							redirect('users');
						} 				
				}else{
					$this->load->view('header',$data);
					$this->load->view('users/add_user',$data);
					$this->load->view('footer',$data);	
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('users/add_user',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('login');
		}
	}
	public function editUser($id)
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if($user_role != '1'){
			$data['title'] 				= 'Edit User';
			$getUserDataBy['user_id']	= $id;
			$data['editedId'] 			= $id;
			$editUserData				= $this->Users_model->getUserById($id);
			$data['editUserData'] 		= $editUserData;
			$data['loginType'] 			= $this->Users_model->getLoginType();
			$data['divisionData'] 		= $this->Divisions_model->getDivision();
			$data['zoneData'] 			= $this->Zones_model->getZone();
			if($this->input->post('update')){
				$userDataById 			= $data['editUserData'];
				$postData 				= $this->input->post();
				unset($postData['update']);
				$uploadedData 				= [];
				if($this->upload->do_upload('user_profile_pic'))
				{
					$upload_data 	= array('upload_data' => $this->upload->data());
					$uploadedData	= $upload_data['upload_data'];
				}
				else
				{
					$error = array('error' => $this->upload->display_errors());
				}
				if(!empty($uploadedData['file_name'])){
					$postData['user_profile_pic'] = $uploadedData['file_name'];
				}
				if(isset($postData['user_profile_pic'])){
					$user_profile_pic =  $postData['user_profile_pic'];
				}else{
					if(!empty($editUserData->user_profile_pic)){
						$user_profile_pic =  $editUserData->user_profile_pic;			
					}else{
						$user_profile_pic =  'no-available.jpg';
					}					
				}
				//echo "<pre>";print_r($postData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				$date 						= date_create($postData['user_dob']);
				$postData['user_dob'] 		= date_format($date,"Y-m-d");
				$user_f_name        		= $postData['user_f_name'];
				$user_l_name        		= $postData['user_l_name'];
				$user_address       		= $postData['user_address'];
				$user_dob           		= $postData['user_dob'];
				$user_gender        		= $postData['user_gender'];
				//$user_division      		= $postData['user_division'];   
				$user_email      			= $postData['user_email'];   
				$user_mobile      			= $postData['user_phone'];   
				$currentDate	 			= date('Y-m-d h:i:s a', time());
				$currentUserId 				= $this->session->userdata('loggedInAdmin');
				$updatedInfoData       	 	= array(
					'user_email'     		=> $user_email,
					'user_mobile'     		=> $user_mobile,
					'user_update_date'     	=> $currentDate,
					'user_updated_by'     	=> $currentUserId,
				);
				$updatedData       	 		= array(
					'user_f_name'       	=> $user_f_name,
					'user_l_name'       	=> $user_l_name,
					'user_address'      	=> $user_address,
					'user_dob'          	=> $user_dob,
					'user_gender'       	=> $user_gender,
					'user_profile_pic'  	=> $user_profile_pic,
					'user_update_date'     	=> $currentDate,
					'user_updated_by'     	=> $currentUserId,
				); 
				$user_email 	= $editUserData->user_email;
				$user_mobile 	= $editUserData->user_mobile;
				if($user_mobile != $postData['user_phone']){
					$this->form_validation->set_rules('user_phone','Mobile Number','required|is_unique[user_info_tbl.user_mobile]');
				}else{
					$this->form_validation->set_rules('user_phone','Mobile Number','required');
				}
				/* if($user_email != $postData['user_email']){
					$this->form_validation->set_rules('user_email','Email id','required|valid_email|is_unique[user_info_tbl.user_email]');
				}else{
					$this->form_validation->set_rules('user_email','Email id','required');
				} */
				
				if($this->form_validation->run()){
					if(!empty($updatedInfoData)){
						$table = 'user_info_tbl';
						$query = $this->Users_model->updateUser($updatedInfoData,$id,$table);
						if($query){
							if(!empty($updatedInfoData)){
								$tables = 'user_details_tbl';
								$newquery 	= $this->Users_model->updateUser($updatedData,$id,$tables);
								if($newquery){
									$this->session->set_flashdata('updateUser', 'User updated successfully');
//									redirect('users/editUser/'.$id);
                                                                        redirect('users');
								}else{
									$this->session->set_flashdata('errorUser', 'Somthing went worng. Error!!');
//									redirect('users/editUser/'.$id);
                                                                        redirect('users');
								}
							}
						}else{
							$this->session->set_flashdata('errorUser', 'Somthing went worng. Error!!');
//							redirect('users/editUser/'.$user_id);
                                                        redirect('users');
						}
					}
				}else{
					$this->load->view('header',$data);
					$this->load->view('users/edit_user',$data);
					$this->load->view('footer',$data);
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('users/edit_user',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('login');
		}
	}
	public function assignUser($id,$activity=NULL)
	{
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
				
		$data['UserSectionData'] = $this->Reports_model->GetUserSectionByID($id);
		
		if($user_role != '1'){
			$shop_id 					= $this->input->post('shop_id');
			$data['title'] 				= 'Assign Shop';
			$loggedInUserDetail 		= $this->session->userdata('loggedInUserDetail');
			$user_zone 					= $loggedInUserDetail->user_zone;
			$user_division 				= $loggedInUserDetail->user_division;
			$data['editedId'] 			= $id;
			$data['activity'] 			= $activity;
			if(!empty($activity)){
				$editUserData				= $this->Users_model->getUserByIdMapID($id,$activity);
				$data['editUserData'] 		= $editUserData;
			}else{
				//$editUserData				= $this->Users_model->getUserById($id);
				$editUserData				= $this->Users_model->getUserById($id);
				$data['editUserData'] 		= $editUserData;
			}
			
			$data['loginType'] 			= $this->Users_model->getLoginType();
			$data['divisionData'] 		= $this->Divisions_model->getDivision();
			$data['zoneData'] 			= $this->Zones_model->getZone();
			$data['usershop'] 			= $this->Shops_model->getShopCount($user_zone,$user_division);
			$data['usersection'] 		= $this->Users_model->getShopSection($shop_id);
			$data['usermshop'] 			= $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division);
			$last 						= $this->uri->total_segments();
			$getuserid 					= $this->uri->segment($last);
			$data['shopidByuser'] 		= $this->Users_model->getshopbyuser($getuserid);
			//$shop_id = $data['shopidByuser']->shop_id;
			$data['sectionidByuser'] 	= $this->Users_model->getsectionbyuser($getuserid);		
			//$data['getallsection'] 		= $this->Users_model->getallsection($shop_id);
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				//if ($this->form_validation->run()) {
					$postData = $this->input->post();
					if(isset($postData['map_id'])){
						$map_id		= $postData['map_id'];
						if(isset($postData['m_shop_type'])){
							$updateData = [
											'maintenance_shop_id'  		=> $this->input->post('m_shop_type'),
											'maintenance_section_id'	=> $this->input->post('m_section_type'),
											'user_map_update_date'     	=> date('Y-m-d H:i:s'),
										];
							$response = $this->Users_model->updateUserMapping($map_id,$updateData); 
						}else{
							$updateData = [
											'shop_id'  				=> $this->input->post('shop_type'),
											'section_id'			=> $this->input->post('section_type'),
											'user_map_update_date'  => date('Y-m-d H:i:s'),
										];
							$response = $this->Users_model->updateUserMapping($map_id,$updateData); 
						}
						//echo "<pre>";print_r($activity);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						if($response){
							$this->session->set_flashdata('success', 'Shop reassigned successfully');
							//redirect('users/assignUser/' .$id.'/' .$activity);
							redirect('users');
						}else{
							$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
							redirect('users/assignUser/' .$id.'/' .$activity);
						}
					}else{
						//$postData['m_shop_type']
						if(isset($postData['m_shop_type'])){
							$response = $this->Users_model->assignSection([
										'user_info_id'    		=> $id,
										'maintenance_shop_id'  	=> $this->input->post('m_shop_type'),
										'maintenance_section_id'=> $this->input->post('m_section_type'),
										'user_map_add_date'     => date('Y-m-d H:i:s'),
									]
							);
						}else{
							$response = $this->Users_model->assignSection([
										'user_info_id'    		=> $id,
										'shop_id'  				=> $this->input->post('shop_type'),
										'section_id'			=> $this->input->post('section_type'),
										'user_map_add_date'     => date('Y-m-d H:i:s'),
									]
							);
						}
						if($response){
							$this->session->set_flashdata('success', 'Assigned successfully');
							//redirect('users/assignUser/' .$id.'/' .$activity);
							redirect('users');
						}else{
							$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
							redirect('users/assignUser/' .$id.'/' .$activity);
						}
					}
				//}        
			}		
			$this->load->view('header',$data);
			$this->load->view('users/assign_user',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('login');
		}
	}
	public function getSectionByShop()
	{
		$postData 		= $this->input->post();
		$shopId 		= $postData['shop_id'];
		$sections 		= $this->Users_model->getShopSection($shopId);
		$html = "";
		$sectionArry = array();
		$GetAllAbleSectionCount = $this->Users_model->GetMapSectionIDs();				
		/* ============ */
		foreach($GetAllAbleSectionCount as $row){
			$sectionID =  $row->section_id;
			array_push($sectionArry,$sectionID);
		}
		/* ============ */		
		
        foreach($sections as $res){
			if(!in_array($res->section_id,$sectionArry)){ 
				$html .= '<option value="'.$res->section_id.'">'.$res->section_name.'</option>'; 
			}
        }
		print_r($html);
	}
	/**** Neha Code ******/
	/**** devendra Code ******/
	public function getMSectionByMShop()
	{
		$postData 		= $this->input->post();
		$shopId 		= $postData['shop_id'];
		$sections 		= $this->Maintenance_sections_model->getMSectionByMshopId($shopId);
		$html = "";
        foreach($sections as $res){
            $html .= '<option value="'.$res->maintenance_section_id.'">'.$res->maintenance_section_name.'</option>'; 
        }
		print_r($html);
	}
	
	/**** devendra Code ******/
	
	public function usermapinactive($userID,$mapID){
		
		$arr = array(
			'map_status'		=>   '80'
		);
		
		$response = $this->Users_model->UpdateMapTable($mapID,$arr);
		
		if($response){
			$this->session->set_flashdata('success', 'Inactive successfully');
			//redirect('users/assignUser/' .$userID);
			redirect('users');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			//redirect('users/assignUser/' .$userID);
			redirect('users');
		}
		
	}
	
}
