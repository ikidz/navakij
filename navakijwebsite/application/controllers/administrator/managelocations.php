<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managelocations extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managelocations/managelocationsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("รายการสถานที่ปฏิบัติงาน",'icon-list-alt');
	}

	public function index($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('รายการสถานที่ปฏิบัติงาน');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managelocationsmodel->get_locations($perpage, $offset));
		$totalrows = $this->managelocationsmodel->count_locations();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มรายการสถานที่','managelocations/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('location_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('location_title_th','ชื่อสถานที่','15%','icon-font');
		$this->admin_model->set_column('location_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('location_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managelocations/update/[location_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managelocations/delete/[location_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_action_button('จัดการตำแหน่งงาน','managejobvacancy/index/[location_id]','icon-list-ol','btn-default','r');
		$this->admin_model->set_column_callback('location_id','show_seq');
		$this->admin_model->set_column_callback('location_order','show_order');
		$this->admin_model->set_column_callback('location_status','show_status');
		$this->admin_model->set_pagination("managelocations/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('เพิ่มรายการสถานที่');
		
		$this->form_validation->set_rules('location_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('location_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('location_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการสถานที่ปฏิบัติงาน","managelocations/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการสถานที่","managelocations/create","icon-plus");
			
			$this->admin_library->view('managelocations/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managelocationsmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managelocations/index');
		}
	}
	
	public function update( $locationid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$info = $this->managelocationsmodel->get_locationinfo_byid( $locationid );
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('แก้ไขรายการสถานที่');
		
		$this->form_validation->set_rules('location_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('location_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('location_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการสถานที่ปฏิบัติงาน","managelocations/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขรายการสถานที่","managelocations/update/".$info['location_id'],"icon-pencil-square-o");

            $this->_data['info'] = $info;
			
			$this->admin_library->view('managelocations/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managelocationsmodel->update($locationid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managelocations/index');
		}
	}
	
	public function delete( $locationid=0 ){
		$message = array();
		$message = $this->managelocationsmodel->setStatus('discard', $locationid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managelocations/index');
	}
	
	public function setorder( $movement='up', $locationid=0 ){
		$message = array();
		$message = $this->managelocationsmodel->setOrder( $movement, $locationid );
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managelocations/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
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
		$text .= '(<a href="'.admin_url('managelocations/setorder/up/'.$row['location_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managelocations/setorder/down/'.$row['location_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}