<?php
class Dashboard extends CI_Controller{
	var $_data=array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');	
		$this->admin_library->forceLogin();
		$this->load->model('administrator/admin_model');
		$this->mssql = $this->load->database("mssql");
	}
	function index()
	{
		//admin_redirect("qrcode/dashboard");
		$this->admin_library->setTitle("Dashboard",'icon-dashboard'); 
		$this->admin_library->setDetail("Statistic &amp; Summary");
		//$this->load->library("administrator/controller_lib");
		//$this->controller_lib->controller_list();
		$this->admin_library->output();
	}
	function example_upload()
	{
		$this->load->model("mobile_upload");
		$this->mobile_upload->set_upload_path("public/uploads/path");
		if($this->mobile_upload->upload("inputname")){
			$res_data = $this->mobile_upload->data();
			$filename = $res_data['file_name'];
		}
		
	}
}  