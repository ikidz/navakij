<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageemployees extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageemployees/manageemployeesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("รายการพนักงาน",'icon-list-alt');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('4d50ec3692dcf78a57ac1d26a55824c6');
		$this->admin_model->set_detail('รายการพนักงาน');
		
		$this->admin_model->set_top_button('เพิ่มรายการพนักงาน','manageemployees/create','icon-plus','btn-success','w');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageemployeesmodel->get_employees($perpage, $offset));
		$totalrows = $this->manageemployeesmodel->count_employees();
		/* Get Data Table - End */
		
		$this->admin_model->set_column('employee_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('employee_image_th','รูปภาพ','25%','icon-picture-o');
		$this->admin_model->set_column('employee_name_th','ชื่อ','15%','icon-user');
		$this->admin_model->set_column('employee_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('employee_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','manageemployees/update/[employee_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','manageemployees/delete/[employee_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_column_callback('employee_id', 'show_seq');
        $this->admin_model->set_column_callback('employee_image_th', 'show_thumbnail');
        $this->admin_model->set_column_callback('employee_order', 'show_order');
        $this->admin_model->set_column_callback('employee_status', 'show_status');
		$this->admin_model->set_pagination("manageemployees/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('4d50ec3692dcf78a57ac1d26a55824c6');
		$this->admin_model->set_detail('เพิ่มรายการพนักงาน');
		
		$this->form_validation->set_rules('employee_name_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('employee_name_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('employee_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการพนักงาน","manageemployees/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการพนักงาน","manageemployees/create","icon-plus");
			
			$this->admin_library->view('manageemployees/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageemployeesmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageemployees/index');
		}
	}
	
	public function update( $employeeid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('4d50ec3692dcf78a57ac1d26a55824c6');
		$this->admin_model->set_detail('แก้ไขรายการพนักงาน');
		
		$this->form_validation->set_rules('employee_name_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('employee_name_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('employee_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการพนักงาน","manageemployees/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการพนักงาน","manageemployees/create","icon-plus");
			
			$this->_data['info'] = $this->manageemployeesmodel->get_employeeinfo_byid( $employeeid );
			
			$this->admin_library->view('manageemployees/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageemployeesmodel->update( $employeeid );
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageemployees/index');
		}
	}
	
	public function delete( $employeeid=0 ){
		$message = array();
		$message = $this->manageemployeesmodel->setStatus('discard', $employeeid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageemployees/index');
	}
	
	public function setorder( $movement='up', $employeeid=0 ){
		$message = array();
		$message = $this->manageemployeesmodel->setOrder( $movement, $employeeid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageemployees/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url('public/core/uploaded/employees/'.$row['employee_image_th']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/employees/'.$row['employee_image_th']).'" alt="" style="width:150px;" /></a>';
		}else{
			return 'ไม่มีรูปภาพแสดง';
		}
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	
	public function show_order($text, $row){
		$text = $text.' ';
		$text .= '(<a href="'.admin_url('manageemployees/setorder/up/'.$row['employee_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('manageemployees/setorder/down/'.$row['employee_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}