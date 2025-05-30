<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageicons extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageicons/manageiconsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2aa7829581f0044d116a6d8fad2a91fc');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการประกันภัย",'icon-list-alt');
	}

	public function index($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('e2f9f76482878428f2f7741c00c8bc26');
        $this->admin_model->set_detail('รายการไอคอน');
        
        /* Get Data Table - Start */
        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
            $this->seq = $offset;
        }else{
            $offset = 0;
        }
        $this->admin_model->set_dataTable($this->manageiconsmodel->get_icons($perpage, $offset));
        $totalrows = $this->manageiconsmodel->count_icons();
        /* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มรายการไอคอน','manageicons/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('icon_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('icon_image','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('icon_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('icon_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('icon_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไข','manageicons/update/[icon_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','manageicons/delete/[icon_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('icon_id','show_seq');
		$this->admin_model->set_column_callback('icon_title_th','show_title');
		$this->admin_model->set_column_callback('icon_image','show_thumbnail');
		$this->admin_model->set_column_callback('icon_order','show_order');
		$this->admin_model->set_column_callback('icon_status','show_status');
		
		$this->admin_model->set_pagination("manageicons/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();

	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('e2f9f76482878428f2f7741c00c8bc26');
		$this->admin_model->set_detail('เพิ่มรายการไอคอน');
		
		$this->form_validation->set_rules('icon_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('icon_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('icon_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการไอคอน","manageicons/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการไอคอน","manageicons/create","icon-plus");
			
			$this->admin_library->view('manageicons/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageiconsmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageicons/index');
		}
	}
	
	public function update( $iconid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('e2f9f76482878428f2f7741c00c8bc26');
		$this->admin_model->set_detail('แก้ไขรายการไอคอน');
		
		$this->form_validation->set_rules('icon_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('icon_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('icon_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการไอคอน","manageicons/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการไอคอน","manageicons/create","icon-plus");
			
			$this->_data['info'] = $this->manageiconsmodel->get_iconinfo_byid( $iconid );
			
			$this->admin_library->view('manageicons/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageiconsmodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageicons/index');
		}
	}
	
	public function delete( $iconid=0 ){
		$message = $this->manageiconsmodel->setStatus( 'discard', $iconid );
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageicons/index');
	}
	
	public function setorder( $movement='up', $iconid=0 ){
		$message = $this->manageiconsmodel->setOrder( $movement, $iconid );
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageicons/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}

	public function show_title( $text, $row ){
		return $text.' / '.$row['icon_title_en'];
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url('public/core/uploaded/icons/'.$text).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/icons/'.$text).'" alt="" style="width:150px;" /></a>';
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
		$text .= '(<a href="'.admin_url('manageicons/setorder/up/'.$row['icon_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('manageicons/setorder/down/'.$row['icon_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}