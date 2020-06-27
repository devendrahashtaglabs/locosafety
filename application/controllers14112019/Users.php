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
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 	= 'Users';
		$status			=  $this->input->get('searchByStatus');
		if( $status === NULL ){
			$status					= '10';
			$data['userData'] 		= $this->Users_model->getFilterUser($status);
		}elseif($status == 'all'){			
			$data['userData'] 		= $this->Users_model->getUser();			
		}else{			
			$data['userData'] 		= $this->Users_model->getFilterUser($status);			
		}
		$data['status'] 			= $status;
		$this->load->view('header',$data);
		$this->load->view('users/index',$data);
		$this->load->view('footer',$data);
	}
	public function addUser()
	{

		$data['title'] 			= 'Add User';
		$data['loginType'] 		= $this->Users_model->getLoginType();
		$data['country'] 		= $this->Users_model->getCountry();
		$data['state'] 			= $this->Users_model->getState();
		$data['divisionData'] 	= $this->Divisions_model->getDivision();
		$data['zoneData'] 		= $this->Zones_model->getZone();
		$data['shopData'] 		= $this->Shops_model->getShop();
		$data['sectionData'] 	= $this->Sections_model->getSection();
		if($this->input->post('submit')){
			//echo "<pre>";print_r($this->input->post());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			$this->form_validation->set_rules('user_email','Email id','required|valid_email|is_unique[login_tbl.login_email]');
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
				$postData['currentDate']	= date('Y-m-d h:i:s a', time());
				$date 						= date_create($postData['user_dob']);
				$postData['user_dob'] 		= date_format($date,"Y-m-d");
				$postData['user_id'] 		= $this->CreateUserID($postData['user_type']);
				$postData['user_pass'] 		= md5($postData['user_pass']);
				$postData['user_division'] 	= '0';
				$postData['user_zone'] 		= '0';
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
				$this->Users_model->insertUser($postData);				
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
	}
	public function editUser($id)
	{
		$data['title'] 				= 'Edit User';
		$getUserDataBy['user_id']	= $id;
		$data['editedId'] 			= $id;
		$editUserData				= $this->Users_model->getUserBy($getUserDataBy);
		$data['editUserData'] 		= $editUserData[0];
		$data['country'] 			= $this->Users_model->getCountry();
		$data['loginType'] 			= $this->Users_model->getLoginType();
		$data['state'] 				= $this->Users_model->getState();
		$data['divisionData'] 		= $this->Divisions_model->getDivision();
		$data['zoneData'] 			= $this->Zones_model->getZone();
		$data['shopData'] 			= $this->Shops_model->getShop();
		$data['sectionData'] 		= $this->Sections_model->getSection();
		if($this->input->post('update')){
			$userDataById 			= $data['editUserData'];
			$postData = $this->input->post();
			unset($postData['update']);
			$postData['user_division'] 	= '0';
			$postData['user_zone'] 		= '0';
			$postData['currentDate']	= date('Y-m-d h:i:s a', time());
			$date 						= date_create($postData['user_dob']);
			$postData['user_dob'] 		= date_format($date,"Y-m-d");
			$postData['user_id'] 		= $id;
			if(empty($postData['section_id'])){
				$postData['section_id'] = 'Null';
			}
			if(empty($postData['shop_id'])){
				$postData['shop_id'] = 'Null';
			}
			$this->Users_model->updateUser($postData);				
		}else{
			$this->load->view('header',$data);
			$this->load->view('users/edit_user',$data);
			$this->load->view('footer',$data);
		}
	}
	public function viewUser($id)
	{
		$data['title'] 				= 'View User';
		$getUserDataBy['user_id']	= $id;
		$viewUserData				= $this->Users_model->getUserBy($getUserDataBy);
		$data['country'] 			= $this->Users_model->getCountry();
		$data['loginType'] 			= $this->Users_model->getLoginType();
		$data['state'] 				= $this->Users_model->getState();
		$data['divisionData'] 		= $this->Divisions_model->getDivision();
		$data['zoneData'] 			= $this->Zones_model->getZone();
		$data['shopData'] 			= $this->Shops_model->getShop();
		$data['sectionData'] 		= $this->Sections_model->getSection();
		if(!empty($viewUserData)){
			$data['userDataById'] 	= $viewUserData[0];
			$data['editedId'] 		= $id;
			$this->load->view('header',$data);
			$this->load->view('users/view_user',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('users');
		}
	}
	public static function CreateUserID($user_type) {
        $rno = Users::uniqueid(11);
        $today = Date("Ymd");
        $u_type = "P";
        switch ($user_type) {
            case "SI":
                $u_type = "S";
                break;
            case "CSA":
                $u_type = "CA";
                $rno = Users::uniqueid(10);
                break;
        }
        $userid = $u_type . $today . $rno;
        return $userid;
    }
    public static function uniqueid($ct) {
        $code = '';
        $data = '';
        srand((double) microtime() * 1000000);
        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";
        for ($i = 0; $i < $ct; $i++) {
            $code .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $code;
    }
    public function deleteUser($id)
	{
		$data['title'] 			= 'Delete User';
		$postData['user_id']	= $id; 
		$deletedStatus 			= $this->Users_model->deleteUser($postData);
	}
	/* public function filterUser()
	{
		echo "<pre>";print_r($this->input->post());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
	} */
}
