<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forgotpass extends CI_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Forgotpass_model'); 
		$this->load->model('Users_model'); 
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(!empty($loggedInAdmin)){
			redirect('dashboard');
		}
	}
	public function index(){
		$this->load->helper('email');
		$this->load->model('Mail_model'); 
		$data['title'] 	= 'Forgot Password Page';
		if($this->input->post('submit')){
			$this->form_validation->set_rules('admin_email', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run()){
				$email 		= $this->input->post('admin_email');
				$userData 	= $this->Forgotpass_model->getUserByEmail($email);
				if(empty($userData)){
					$this->session->set_flashdata('error','Failed! Email id not exits.');
					redirect('forgotpass');
				}elseif($userData->user_status != 10){
					$this->session->set_flashdata('error','Account inactive, Please contact your Admin.');
					redirect('forgotpass');
				}else{
					$activation_hash = md5(uniqid(mt_rand(), true));
					$data = array(
						'email' => $email,
						'token' => $activation_hash
					);
					$response 	= $this->Forgotpass_model->add_token($data);
					$link 		= base_url()."forgotpass/reset_password/?activation_id=".$activation_hash;
								
					if(!empty($response)) {		   
						$subject = 'RSW SAFETY - Forgot Password';
						$content = 'Hi<br><br>Please click the link to change password..<br><br>
							'.$link.'
							<br><br><br>Thanks';
						$headers  = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= "From: devendra.nai@hashtaglabs.in" . "\r\n";

						$responsemail = mail($email,$subject,$content,$headers);
						if($responsemail){
							$this->session->set_flashdata('success','Please check your email to reset password.');
							redirect('forgotpass');
						}
                    }
                } 
			}else{
				$this->load->view('forgot_password');
			}
		}else{
			$this->load->view('forgot_password');
		}
	}
	public function reset_password() {
        $token = $this->input->get('activation_id');
        $data['title'] = "Reset Password";
        $data['token'] = $token;
        $response = $this->Forgotpass_model->get_token($token);
		/* echo "<pre>";print_r($response);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ ); */
		if($response->status == '1'){
			$this->session->set_flashdata('error','Link expired! Please try again.');
			redirect('forgotpass');
		}elseif (empty($response)) {
			$this->session->set_flashdata('error','Link expired! Please try again.');
			redirect('forgotpass');
		}else if (!empty($response) && $response->status == '1') {
			$this->session->set_flashdata('error','Link expired! Please try again.');
			redirect('forgotpass');
		}else{
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$email = $response->email;
				$data = array(
					'user_pass' => md5($this->input->post('admin_pass')),
				);
				$this->Forgotpass_model->update_token($token);
				$result = $this->Forgotpass_model->update_admin_password($data, $email);
				if(!empty($result)) {
					$this->session->set_flashdata('success','Password reset successfully.');
					redirect('forgotpass');
				}
			}
			$this->load->view('reset_password',$data);
		}
    }
}