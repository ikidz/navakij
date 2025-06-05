<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managehiddendocuments extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managehiddendocuments/managehiddendocumentsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2a6ec6243d5d491c9e32946fb1f2cf4b');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเอกสารบริษัท",'icon-list-alt');
	}

	public function index($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('6b72d5ae79fca6f7e9ae254bd0b159a8');
		$this->admin_model->set_detail('รายการเอกสารซ่อน');
		
        $this->admin_model->set_top_button('เพิ่มรายการเอกสาร','managehiddendocuments/create','icon-plus','btn-success','w');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managehiddendocumentsmodel->get_documents($perpage, $offset));
		$totalrows = $this->managehiddendocumentsmodel->count_documents();
		/* Get Data Table - End */
		
		$this->admin_model->set_column('document_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('document_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('document_meta_url','URL','20%','icon-link');
		$this->admin_model->set_column('document_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managehiddendocuments/update/[document_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managehiddendocuments/delete/[document_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('document_id','show_seq');
		$this->admin_model->set_column_callback('document_meta_url','show_url');
		$this->admin_model->set_column_callback('document_status','show_status');
		$this->admin_model->set_pagination("managehiddendocuments/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('6b72d5ae79fca6f7e9ae254bd0b159a8');
		$this->admin_model->set_detail('เพิ่มรายการเอกสารซ่อน');
		
		$this->form_validation->set_rules('document_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('document_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('document_publish_date', 'วันที่โพสต์','trim');
        $this->form_validation->set_rules('document_meta_title', 'Meta Title', 'trim');
        $this->form_validation->set_rules('document_meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('document_meta_keywords', 'Meta Keywords','trim');
        $this->form_validation->set_rules('document_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเอกสารซ่อน","managehiddendocuments/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการเอกสารซ่อน","managehiddendocuments/create","icon-plus");
			
			$this->admin_library->view('managehiddendocuments/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managehiddendocumentsmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehiddendocuments/index');
		}
	}
	
	public function update($documentid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('6b72d5ae79fca6f7e9ae254bd0b159a8');
		$this->admin_model->set_detail('แก้ไขรายการเอกสารซ่อน');
		
		$this->form_validation->set_rules('document_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('document_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('document_publish_date', 'วันที่โพสต์','trim');
        $this->form_validation->set_rules('document_meta_title', 'Meta Title', 'trim');
        $this->form_validation->set_rules('document_meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('document_meta_keywords', 'Meta Keywords','trim');
        $this->form_validation->set_rules('document_meta_url','Meta URL','trim');
		$this->form_validation->set_rules('document_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเอกสารซ่อน","managehiddendocuments/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขรายการเอกสารซ่อน","managehiddendocuments/update","icon-pencil-square");
			
			$this->_data['info'] = $this->managehiddendocumentsmodel->get_documentinfo_byid( $documentid );
			
			$this->admin_library->view('managehiddendocuments/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managehiddendocumentsmodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehiddendocuments/index');
		}
	}
	
	public function delete( $documentid=0 ){
		$message = $this->managehiddendocumentsmodel->setStatus('discard', $documentid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managehiddendocuments/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url( 'public/core/uploaded/documents/thumbnail/'.$row['document_thumbnail'] ).'" class="fancybox-button"><img src="'.base_url( 'public/core/uploaded/documents/thumbnail/'.$row['document_thumbnail'] ).'" alt="" style="width:150px;" /></a>';
		}else{
			return 'ไม่มีรูปภาพแสดง';
		}
	}
	
	public function show_title( $text, $row ){
		return $text.' / '.$row['document_title_en'];
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
		$text .= '(<a href="'.admin_url('managehiddendocuments/setorder/up/'.$row['category_id'].'/'.$row['document_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managehiddendocuments/setorder/down/'.$row['category_id'].'/'.$row['document_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}

	public function show_url( $text, $row ){
		$text_th = 'TH : <a href="'.site_url( 'th/'.$text, false ).'" target="_blank">'.site_url( 'th/'.$text, false ).'</a>';
		$text_en = 'EN : <a href="'.site_url( 'en/'.$text, false ).'" target="_blank">'.site_url( 'en/'.$text, false ).'</a>';
		return $text_th.'<br />'.$text_en;
		
	}

	public function show_button( $text, $row ){
		$editBtn = '';
		$delBtn = '';
		$filesBtn = '';
		if( $this->admin_model->check_permision('w') ){
			$editBtn = '<a href="'.admin_url('managehiddendocuments/update/'.$row['category_id'].'/'.$row['document_id']).'" class="btn btn-mini btn-primary "><i class="icon-pencil-square-o"></i> แก้ไข</a>';
		}
		if( $this->admin_model->check_permision('d') ){
			$delBtn = '<a href="'.admin_url('managehiddendocuments/delete/'.$row['category_id'].'/'.$row['document_id']).'" class="btn btn-mini btn-danger " onclick="return confirm("ยืนยันการลบรายการนี้ ?");"><i class="icon-trash"></i> ลบข้อมูล</a>';
		}
		if( $this->admin_model->check_permision('r') && $row['document_type'] == 'multi' ){
			$filesBtn = '<a href="'.admin_url('managedocumentfile/index/'.$row['document_id']).'" class="btn btn-mini btn-inverse "><i class="icon-files-o"></i> จัดการไฟล์</a>';
		}

		return '<div style="text-align:right;">'.$editBtn.' '.$delBtn.' '.$filesBtn.'</div>';
	}
	/* Default function -  End */

}