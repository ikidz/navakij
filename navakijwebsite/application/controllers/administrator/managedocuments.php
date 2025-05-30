<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managedocuments extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managedocuments/managedocumentsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2a6ec6243d5d491c9e32946fb1f2cf4b');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเอกสารบริษัท",'icon-list-alt');
	}

	public function index($categoryid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		if( $categoryid <= 0 ){
			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกหมวดหมู่'
			);
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managedocumentcategories/index');
		}
		
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		$category = $this->managedocumentsmodel->get_categoryinfo_byid( $categoryid );
		$this->admin_model->set_detail('รายการเอกสารของ '.$category['category_title_th']);
		
        $this->admin_model->set_top_button('เพิ่มรายการเอกสาร','managedocuments/create/'.$category['category_id'],'icon-plus','btn-success','w');
        $this->admin_model->set_top_button('กลับไปยังรายการหมวดหมู่','managedocumentcategories/index/'.$category['main_id'],'icon-undo','btn-primary','w');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managedocumentsmodel->get_documents($category['category_id'], $perpage, $offset));
		$totalrows = $this->managedocumentsmodel->count_documents($category['category_id']);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('document_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('document_thumbnail','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('document_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('document_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('document_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column('document_createdtime', '', '25%','');
		$this->admin_model->set_column_callback('document_id','show_seq');
		$this->admin_model->set_column_callback('document_thumbnail','show_thumbnail');
		$this->admin_model->set_column_callback('document_title_th','show_title');
		$this->admin_model->set_column_callback('document_order','show_order');
		$this->admin_model->set_column_callback('document_status','show_status');
		$this->admin_model->set_column_callback('document_createdtime','show_button');
		$this->admin_model->set_pagination("managedocuments/index/".$category['category_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create($categoryid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		$category = $this->managedocumentsmodel->get_categoryinfo_byid( $categoryid );
		$this->admin_model->set_detail('เพิ่มรายการเอกสารของ '.$category['category_title_th']);
		
		$this->form_validation->set_rules('document_type','ประเภทของไฟล์','trim|required');
		$this->form_validation->set_rules('document_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('document_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('document_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('document_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('document_publish_date', 'วันที่โพสต์','trim');
        $this->form_validation->set_rules('document_meta_title', 'Meta Title', 'trim');
        $this->form_validation->set_rules('document_meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('document_meta_keywords', 'Meta Keywords','trim');
        $this->form_validation->set_rules('document_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเอกสารของ ".$category['category_title_th'],"managedocuments/index/".$category['category_id'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการเอกสาร","managedocuments/create/".$category['category_id'],"icon-plus");
			
			$this->_data['category'] = $category;
			
			$this->admin_library->view('managedocuments/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managedocumentsmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managedocuments/index/'.$category['category_id']);
		}
	}
	
	public function update($categoryid=0, $documentid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		$category = $this->managedocumentsmodel->get_categoryinfo_byid( $categoryid );
		$this->admin_model->set_detail('แก้ไขรายการเอกสารของ '.$category['category_title_th']);
		
		$this->form_validation->set_rules('document_type','ประเภทของไฟล์','trim|required');
		$this->form_validation->set_rules('document_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('document_title_en','ชื่อ (En)','trim|required');
		$this->form_validation->set_rules('document_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('document_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('document_publish_date', 'วันที่โพสต์','trim');
        $this->form_validation->set_rules('document_meta_title', 'Meta Title', 'trim');
        $this->form_validation->set_rules('document_meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('document_meta_keywords', 'Meta Keywords','trim');
        $this->form_validation->set_rules('document_meta_url','Meta URL','trim');
		$this->form_validation->set_rules('document_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$info = $this->managedocumentsmodel->get_documentinfo_byid( $documentid );
			$this->admin_library->add_breadcrumb("รายการเอกสารของ ".$category['category_title_th'],"managedocuments/index/".$category['category_id'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขรายการเอกสาร","managedocuments/update/".$category['category_id'].'/'.$info['document_id'],"icon-pencil-square");
			
			$this->_data['category'] = $category;
			$this->_data['info'] = $info;
			
			$this->admin_library->view('managedocuments/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managedocumentsmodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managedocuments/index/'.$category['category_id']);
		}
	}
	
	public function delete( $categoryid=0, $documentid=0 ){
		$message = $this->managedocumentsmodel->setStatus('discard', $documentid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managedocuments/index/'.$categoryid);
	}
	
	public function setorder( $movement='up', $categoryid=0, $documentid=0 ){
		$message = $this->managedocumentsmodel->setOrder( $movement, $documentid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managedocuments/index/'.$categoryid);
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
		$text .= '(<a href="'.admin_url('managedocuments/setorder/up/'.$row['category_id'].'/'.$row['document_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managedocuments/setorder/down/'.$row['category_id'].'/'.$row['document_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}

	public function show_button( $text, $row ){
		$editBtn = '';
		$delBtn = '';
		$filesBtn = '';
		if( $this->admin_model->check_permision('w') ){
			$editBtn = '<a href="'.admin_url('managedocuments/update/'.$row['category_id'].'/'.$row['document_id']).'" class="btn btn-mini btn-primary "><i class="icon-pencil-square-o"></i> แก้ไข</a>';
		}
		if( $this->admin_model->check_permision('d') ){
			$delBtn = '<a href="'.admin_url('managedocuments/delete/'.$row['category_id'].'/'.$row['document_id']).'" class="btn btn-mini btn-danger " onclick="return confirm("ยืนยันการลบรายการนี้ ?");"><i class="icon-trash"></i> ลบข้อมูล</a>';
		}
		if( $this->admin_model->check_permision('r') && $row['document_type'] == 'multi' ){
			$filesBtn = '<a href="'.admin_url('managedocumentfile/index/'.$row['document_id']).'" class="btn btn-mini btn-inverse "><i class="icon-files-o"></i> จัดการไฟล์</a>';
		}

		return '<div style="text-align:right;">'.$editBtn.' '.$delBtn.' '.$filesBtn.'</div>';
	}
	/* Default function -  End */

}