<?php
class Login extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->library("form_validation");
		$this->load->library('email');		
	}
	function index()
	{
		$this->form_validation->set_rules("username","Username","trim|required");
		$this->form_validation->set_rules("password","Password","trim|required");
		if($this->form_validation->run()===false){
			$error_message = $this->session->flashdata('error_message');
			$success_message = $this->session->flashdata('success_message');
			if($error_message){
				$this->admin_library->assign("error_message",$error_message);
			}else{
				$this->admin_library->assign("error_message",validation_errors(' ',' '));
			}
			if($success_message){
				$this->admin_library->assign("success_message",$success_message);
			}
			$this->admin_library->loginoutput();
		}else{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$auth = $this->admin_library->auth($username,$password);
			
			if(!$auth){
				$this->session->set_flashdata("error_message","User is not exists or Invalid username/password.");
				admin_redirect("login/?next=" . $this->input->get_post("next"));
			}else{
				$this->admin_library->setLogin($auth['user_id']);	
				$next = $this->input->get_post("next");
				if($next){
					redirect( $this->input->get_post("next"), 'auto', null, false);
				}else{
					admin_redirect( $this->input->get_post("next"));
				}
			}
		}
	}
	function forgotpass()
	{
		
		$this->form_validation->set_rules("user_email","E-mail Address","required|valid_email");
		if($this->form_validation->run()===false){
			$this->admin_library->assign("forgotpassfocus","yes");
			$this->admin_library->assign("error_message",validation_errors(' ',' '));
			$this->admin_library->loginoutput();
		}else{
			$user_email = $this->input->post("user_email");	
			$user_data = $this->admin_library->getuserinfo_byemail($user_email);
			if(!$user_data){
				$this->admin_library->assign("forgotpassfocus","yes");
				$this->admin_library->assign("error_message","E-mail address is not exists.");
			}else{
				$reset_key = $this->admin_library->getResetPassUUID($user_data['user_id']);
				$reset_link = admin_url("login/resetpassword/{$reset_key}");
				$user_data['reset_link']=$reset_link;
				$email = $this->config->item("email");
				$this->email->initialize($email['settings']);
				
				$this->email->from($email['sender_email'], $email['sender_name']);
				$this->email->to($user_data['user_email']);
				$this->email->subject('Reset password confirmation');

				
				$this->email->message($this->admin_library->view("email_template/resetpassword",$user_data,true));
				$this->email->send();
				$this->session->set_flashdata("success_message","Reset password link has send to your email. Please check your email.");
				admin_redirect("login/?next=" . $this->input->get_post("next"));
			}
			
		}
		
	}
	public function resetpassword($reset_key)
	{
		$user_id = $this->admin_library->getResetUserFromKey($reset_key);
		if(!$user_id){
			$this->session->set_flashdata("error_message","Reset password link is expired.");
			admin_redirect("login");
		}
		$this->admin_library->assign("reset_key",$reset_key);
		$this->form_validation->set_rules("newpassword","New Password","required|min_length[6]");
		$this->form_validation->set_rules("renewpassword","Re-Enter New Password","required|min_length[6]");
		if($this->form_validation->run()===false){
			$this->admin_library->assign("error_message",validation_errors(' ',' '));
			$this->admin_library->resetpassoutput();
		}else{
			$newpassword = $this->input->post("newpassword");
			$renewpassword = $this->input->post("renewpassword");
			if($newpassword != $renewpassword){
				$this->admin_library->assign("error_message","Please Re-enter password again.");
				$this->admin_library->resetpassoutput();
				return false;
			}
			$this->admin_library->updatePassword($user_id,$newpassword);
			$this->session->set_flashdata("success_message","New Password is ready to use. Please login with new password.");
			admin_redirect("login");
		}
	}
}