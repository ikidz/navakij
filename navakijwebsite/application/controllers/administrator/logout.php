<?php
class Logout extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');	
		$this->admin_library->forceLogin();
	}
	function index()
	{
		$this->admin_library->logout();
		admin_redirect("login");
	}
}