<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Types_model'); 
		$this->load->model('Users_model'); 
		$this->load->model('Shops_model'); 
		$this->load->model('Maintenance_shops_model'); 
		$this->load->model('Notifications_model'); 
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 		= 'Notifications';
		$data['typeData'] 	= $this->Types_model->getType();
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role			= '';
		if(isset($loggedInUserDetail->user_role)){
			$user_role = $loggedInUserDetail->user_role;
		}
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		$data['roleData'] 		= $this->Users_model->getRoleByAdmin();
		$data['shopData'] 		= $this->Shops_model->getShopCount($user_zone,$user_division);
		$data['mShopData'] 		= $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division);
		$data['allUserData']	= $this->Notifications_model->getAllUserData($user_zone,$user_division);
		if($this->input->post('submit')){
			$userlistArray = $this->input->post('userlist');
			if(!empty($userlistArray)){
				$userlist 				= implode(',',$userlistArray);
				$shop_id 				= $this->input->post('shop_id');
				$user_role 				= $this->input->post('user_role');
				$m_shop_id 				= $this->input->post('m_shop_id');
				$user_message 			= $this->input->post('user_message');
				$loggedInAdmin 			= $this->session->userdata('loggedInAdmin');
				$ticket_no				= '';
				$notification_title 	= $this->input->post('notification_title');
				$currentDate			= date('Y-m-d h:i:s a', time());
				$arr 					= array(
											'ticket_no' 			=> $ticket_no,
											'sender_id' 			=> $loggedInAdmin,
											'receiver_id' 			=> $userlist,
											'shop_id' 				=> $shop_id,
											'user_role' 			=> $user_role,
											'm_shop_id' 			=> $m_shop_id,
											'notification_title' 	=> $notification_title,
											'notification_msg' 		=> $user_message,
											'notification_status' 	=> '10',
											'notifiation_add_date' 	=> $currentDate,
										);
				$table 					= 'firebase_notification_tbl';
				$response 				= $this->Notifications_model->insertNotification($table,$arr);				
				if(isset($response)){
					$this->load->model('Firebase_model');
					$user_ids 	= $this->Notifications_model->getUserDeviceId($userlistArray);
					$allUserIds = [];
					foreach($user_ids as $idList){
						if(!empty($idList->user_device_id)){
							$allUserIds[] = $idList->user_device_id;
						}
					}	
					
					//$device_ids	= ["eTT13R9mTlo:APA91bGICAhAI8qu7R0BNiyWpk_m_KnIuYkSxJhUh_uS4Oc59uXdZYAEGOrvW-V6fDfzloBZI_iIE8ajn9wB_na7bWA2vtNkRVQGRxkOoX7VVjRTtdtlDWsqBRqeOCOVcyXV3gHCTRtn","dhZlt_7YffQ:APA91bFAnJvNWygW8-kZZifg3NizpDzP7TbDAkve1wEXKqle3eMh_sSZ-C6A3rf9F8KJCNA5UG7vSxCGW8r_wzQ5Bpu8c76hVGlp1YORzTGDILXW0krWlFD-DLBzlyKqBJCCihFQzkEr"];
					//$device_ids	= ["fE3D68TMFVk:APA91bEsd0_7iAjrGpNjl4sQw9Ial5FmUx02gH27rrFmg8Hgjs2scHxvPrTxrdIK4vIal-7k8ka_gL4bnZxFKo_Ck72WsGbBgD6eGBBNdMMyzlS51Gm-VbjiL6VGzsGK3-_TC0kZignh"];
					//$device_ids 				= json_encode($device_id);
					$res 						= array();
					$res['data']['title'] 		= $notification_title;
					//$res['body'] 				= $user_message;
					$res['data']['message'] 	= $user_message;
					//$res['image'] 				= '';
					//$res['payload'] 			= '';
					$responseNotificationData 	= $this->Firebase_model->sendMultiple($allUserIds,$res);
					//echo "<pre>";print_r($responseNotificationData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
					//$response = json_encode();
					//$responseNotificationData 	= $this->Firebase_model->sendMultiple($device_ids,$res);
					$responseNotifications		= json_decode($responseNotificationData);
					if(isset($responseNotifications)){
						$results 					= $responseNotifications->results[0];
						if(isset($results->message_id)){
							$this->session->set_flashdata('success', 'Notification Added successfully');
							redirect('notifications');
						}
					}else{
						$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
						redirect('notifications');
					}
				}else{
					$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
					redirect('notifications');
				} 
			}else{
				$this->load->view('header',$data);
				$this->load->view('notifications/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('notifications/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function getuserbyshop()
	{
		$data['title']			= 'Notification Filter';
		$shop_id 				= $this->input->post('shop_id');
		$UserList 				= '';
		if(!empty($shop_id)){
			$allUserData			= $this->Notifications_model->getUserByShopId($shop_id);
			if(!empty($allUserData)){
				foreach($allUserData as $singleUserData){
					$name = ''; 
					if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
						$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
					}
					$UserList .= '<option value="'.$singleUserData->user_info_id.'">'.$name.'</option>';
				}
			}else{
				$UserList .= '<option value=" ">No User Mapped </option>';
			}
		}else{
			$UserList .= '<option value=" ">No User Mapped </option>';
		}
		print_r($UserList);
	}	
	public function getuserbyrole()
	{
		$role_id 			= $this->input->post('role_id');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role			= '';
		if(isset($loggedInUserDetail->user_role)){
			$user_role = $loggedInUserDetail->user_role;
		}
		$user_zone 			= $loggedInUserDetail->user_zone;
		$user_division 		= $loggedInUserDetail->user_division;
		$UserList 	= '';
		if(!empty($role_id)){
			$allUserData			= $this->Notifications_model->getUserByRoleId($role_id,$user_zone,$user_division);
			if(!empty($allUserData)){
				foreach($allUserData as $singleUserData){
					$name = ''; 
					if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
						$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
					}
					$UserList .= '<option value="'.$singleUserData->user_info_id.'">'.$name.'</option>';
				}
			}else{
				$UserList .= '<option value=" ">No User Mapped </option>';
			}
		}else{
			$UserList .= '<option value=" ">No User Mapped </option>';
		}
		print_r($UserList);
	}
	public function getuserbymshop()
	{
		$m_shop_id 	= $this->input->post('m_shop_id');
		$UserList 	= '';
		if(!empty($m_shop_id)){
			$allUserData	= $this->Notifications_model->getUserBymShopId($m_shop_id);
			if(!empty($allUserData)){
				foreach($allUserData as $singleUserData){
					$name = ''; 
					if(isset($singleUserData->user_f_name) || isset($singleUserData->user_l_name)){
						$name = $singleUserData->user_f_name .' ' . $singleUserData->user_l_name;
					}
					$UserList .= '<option value="'.$singleUserData->user_info_id.'">'.$name.'</option>';
				}
			}else{
				$UserList .= '<option value=" ">No User Mapped </option>';
			}
		}else{
			$UserList .= '<option value=" ">No User Mapped </option>';
		}
		print_r($UserList);
	}
}