<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageinsurance extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	var $offset;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageinsurance/manageinsurancemodel');
		$this->load->model('administrator/manageicons/manageiconsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2aa7829581f0044d116a6d8fad2a91fc');
		
		$this->admin_model->initd($this);
		
		$this->admin_model->set_title("จัดการประกันภัย",'icon-list-alt');
	}

	public function index($categoryid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}

		$category = $this->manageinsurancemodel->get_categoryinfo_byid( $categoryid );

		if( $categoryid <= 0 ){

			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกหมวดหมู่'
			);

			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurancecategory/index');
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		if( isset( $category ) && count( $category ) > 0 ){
			$this->admin_model->set_detail('รายการประกันภัยของ "'.$category['insurance_category_title_th'].'"');
		}else{
			$this->admin_model->set_detail('รายการประกันภัยทั้งหมด');
		}
		
		
		/* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageinsurancemodel->get_insurancelists($category['insurance_category_id'], $perpage, $offset));
		$totalrows = $this->manageinsurancemodel->count_insurancelists($category['insurance_category_id']);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มประกันภัย','manageinsurance/create/'.$category['insurance_category_id'],'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการหมวดหมู่','manageinsurancecategory/index','icon-undo','btn-primary','r');
		
		$this->admin_model->set_column('insurance_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('insurance_thumbnail','รูปภาพ','12%','icon-picture-o');
		$this->admin_model->set_column('insurance_title_th','ชื่อเรื่อง','20%','icon-font');
		$this->admin_model->set_column('insurance_contact_form','ฟอร์มติดต่อกลับ','10%','icon-check');
		$this->admin_model->set_column('insurance_highlight', 'Highlight','10%','icon-star');
		$this->admin_model->set_column('insurance_start_date','ช่วงวันที่แสดงผล','15%','icon-calendar-o');
		$this->admin_model->set_column('insurance_status','สถานะการแสดงผล','10%','icon-eye-slash');
		$this->admin_model->set_action_button('ตัวอย่าง', site_url('[insurance_meta_url]'),'icon-eye','btn-default','e');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','manageinsurance/update/[insurance_category_id]/[insurance_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','manageinsurance/delete/[insurance_category_id]/[insurance_id]/'.$offset,'icon-trash','btn-danger','d');
		
		//$this->admin_model->set_action_button('ติดต่อ','manageinsurancecontact/index/[insurance_id]','icon-picture-o','btn-inverse','r');
		
		$this->admin_model->set_column_callback('insurance_id','show_seq');
		$this->admin_model->set_column_callback('insurance_thumbnail','show_thumbnail');
		$this->admin_model->set_column_callback('insurance_status','show_status');
		$this->admin_model->set_column_callback('insurance_start_date', 'show_period');
		$this->admin_model->set_column_callback('insurance_contact_form','show_contact_status');
		$this->admin_model->set_column_callback('insurance_highlight','show_highlight_status');
		
		$this->admin_model->set_pagination("manageinsurance/index/".$category['insurance_category_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create($categoryid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('เพิ่มประกันภัย');
		
		$this->_data['category'] = $this->manageinsurancemodel->get_categoryinfo_byid( $categoryid );
		$category = $this->_data['category'];
		
		$this->form_validation->set_rules('insurance_file_th_delete','ลบไฟล์ใบคำขอ (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_en_delete','ลบไฟล์ใบคำขอ (En)','trim');
		$this->form_validation->set_rules('insurance_file_2_th_delete','ลบไฟล์ Factsheet (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_2_en_delete','ลบไฟล์ Factsheet (En)','trim');
		$this->form_validation->set_rules('insurance_file_3_th_delete','ลบไฟล์ 3 (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_3_en_delete','ลบไฟล์ 3 (En)','trim');
		$this->form_validation->set_rules('insurnace_file_3_label_th','ชื่อปุ่มสำหรับ File 3 (ไทย)','trim');
		$this->form_validation->set_rules('insurnace_file_3_label_en','ชื่อปุ่มสำหรับ File 3 (En)','trim');
		$this->form_validation->set_rules('insurance_file_4_th_delete','ลบไฟล์ 4 (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_4_en_delete','ลบไฟล์ 4 (En)','trim');
		$this->form_validation->set_rules('insurnace_file_4_label_th','ชื่อปุ่มสำหรับ File 4 (ไทย)','trim');
		$this->form_validation->set_rules('insurnace_file_4_label_en','ชื่อปุ่มสำหรับ File 4 (En)','trim');
		$this->form_validation->set_rules('insurance_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('insurance_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('sum_insured','จำนวนเงินเอาประกันสูงสุด','trim|required');
		$this->form_validation->set_rules('price','เบี้ยประกันภัยเริ่มต้น','trim|required');
		$this->form_validation->set_rules('insurance_sdesc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('insurance_sdesc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('insurance_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('insurance_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('insurance_start_date','วันที่เริ่มต้น','trim|required');
		$this->form_validation->set_rules('insurance_end_date','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('insurance_contact_form','ฟอร์มติดต่อกลับ','trim');
		$this->form_validation->set_rules('insurance_highlight', 'Highlight','trim');
		$this->form_validation->set_rules('insurance_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_rules('insurance_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('insurance_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('insurance_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการประกันภัย","manageinsurance/index/".$category['insurance_category_id'],"icon-list");
			$this->admin_library->add_breadcrumb("เพิ่มประกันภัย","manageinsurance/create/".$category['insurance_category_id'],"icon-plus");
			$this->_data['icons'] = $this->manageiconsmodel->get_icons();
			$this->admin_library->view('manageinsurance/create', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->manageinsurancemodel->create($categoryid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurance/index/'.$category['insurance_category_id']);
			
		}
	}
	
	public function update($categoryid=0, $insuranceid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('แก้ไขประกันภัย');
		
		$this->_data['category'] = $this->manageinsurancemodel->get_categoryinfo_byid( $categoryid );
		$category = $this->_data['category'];
		
		$this->form_validation->set_rules('insurance_file_th_delete','ลบไฟล์ใบคำขอ (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_en_delete','ลบไฟล์ใบคำขอ (En)','trim');
		$this->form_validation->set_rules('insurance_file_2_th_delete','ลบไฟล์ Factsheet (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_2_en_delete','ลบไฟล์ Factsheet (En)','trim');
		$this->form_validation->set_rules('insurance_file_3_th_delete','ลบไฟล์ 3 (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_3_en_delete','ลบไฟล์ 3 (En)','trim');
		$this->form_validation->set_rules('insurnace_file_3_label_th','ชื่อปุ่มสำหรับ File 3 (ไทย)','trim');
		$this->form_validation->set_rules('insurnace_file_3_label_en','ชื่อปุ่มสำหรับ File 3 (En)','trim');
		$this->form_validation->set_rules('insurance_file_4_th_delete','ลบไฟล์ 4 (ไทย)','trim');
		$this->form_validation->set_rules('insurance_file_4_en_delete','ลบไฟล์ 4 (En)','trim');
		$this->form_validation->set_rules('insurnace_file_4_label_th','ชื่อปุ่มสำหรับ File 4 (ไทย)','trim');
		$this->form_validation->set_rules('insurnace_file_4_label_en','ชื่อปุ่มสำหรับ File 4 (En)','trim');
		$this->form_validation->set_rules('insurance_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('insurance_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('sum_insured','จำนวนเงินเอาประกันสูงสุด','trim|required');
		$this->form_validation->set_rules('price','เบี้ยประกันภัยเริ่มต้น','trim|required');
		$this->form_validation->set_rules('insurance_sdesc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('insurance_sdesc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('insurance_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('insurance_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('insurance_start_date','วันที่เริ่มต้น','trim|required');
		$this->form_validation->set_rules('insurance_end_date','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('insurance_contact_form','ฟอร์มติดต่อกลับ','trim');
		$this->form_validation->set_rules('insurance_highlight', 'Highlight','trim');
		$this->form_validation->set_rules('insurance_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_rules('insurance_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('insurance_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('insurance_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_rules('insurance_meta_url','URL สำหรับ SEO','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการประกันภัย","manageinsurance/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขประกันภัย","manageinsurance/update/".$category['insurance_category_id'].'/'.$insuranceid,"icon-pencil-square-o");
			
			$this->_data['info'] = $this->manageinsurancemodel->get_insuranceinfo_byid($insuranceid);
			$this->_data['icons'] = $this->manageiconsmodel->get_icons();
			$this->_data['insurance_icon'] = $this->manageinsurancemodel->get_insurance_icon($insuranceid);
			
			$this->admin_library->view('manageinsurance/update', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->manageinsurancemodel->update($insuranceid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurance/index/'.$category['insurance_category_id']);
			
		}
	}
	
	public function delete($categoryid=0,$insuranceid=0, $offset){
		$this->offset = $offset;
		$message = $this->manageinsurancemodel->setStatus('discard', $insuranceid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageinsurance/index/'.$categoryid.'/'.$this->offset);
		
	}

	public function setcontactform( $status='active', $categoryid=0, $insuranceid=0 ){
		$this->offset = $offset;
		$message = $this->manageinsurancemodel->set_contactform_status( $status, $insuranceid );

		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageinsurance/index/'.$categoryid.'/'.$this->offset);
	}

	public function sethighlight( $status = 'active', $categoryid=0, $insuranceid=0 ){
		$this->offset = $offset;
		$message = $this->manageinsurancemodel->set_highlight_status( $status, $insuranceid );

		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageinsurance/index/'.$categoryid.'/'.$this->offset);
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url( 'public/core/uploaded/insurance/thumb/'.$row['insurance_thumbnail'] ).'" class="fancybox-button"><img src="'.base_url( 'public/core/uploaded/insurance/thumb/'.$row['insurance_thumbnail'] ).'" alt="" style="width:150px;" /></a>';
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

	public function show_contact_status( $text, $row ){
		if( $text == 1 ){
			$response = '<p style="margin-bottom:0.5rem;"><span class="label label-success"><i class="icon-check"></i></span> [ <a href="'.admin_url('manageinsurance/setcontactform/inactive/'.$row['insurance_category_id'].'/'.$row['insurance_id']).'"><i class="icon-times"></i> ตั้งค่าปิดใช้งาน</a> ]</p>';
		}else{
			$response = '<p style="margin-bottom:0.5rem;"><span class="label label-important"><i class="icon-times"></i></span> [ <a href="'.admin_url('manageinsurance/setcontactform/active/'.$row['insurance_category_id'].'/'.$row['insurance_id']).'"><i class="icon-check"></i> ตั้งค่าใช้งาน</a> ]</p>';
		}

		$response .= '<p style="text-align:center; margin-bottom:0;"><a href="'.admin_url('manageinsurancecontact/index/'.$row['insurance_id']).'" class="btn btn-mini btn-primary"><i class="icon-file-text"></i> ดูรายงาน</a></p>';
		return $response;

	}

	public function show_highlight_status( $text, $row ){
		if( $text == 1 ){
			return '<span class="label label-success"><i class="icon-star"></i></span> [ <a href="'.admin_url('manageinsurance/sethighlight/inactive/'.$row['insurance_category_id'].'/'.$row['insurance_id']).'"><i class="icon-star-o"></i> ปิดตั้งค่า</a> ]';
		}else{
			return '<span class="label label-important"><i class="icon-star-o"></i></span> [ <a href="'.admin_url('manageinsurance/sethighlight/active/'.$row['insurance_category_id'].'/'.$row['insurance_id']).'"><i class="icon-star"></i> ตั้งค่า</a> ]';
		}
	}

	public function show_period( $text, $row ){
		$start = ( !$row['insurance_start_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['insurance_start_date'] ) );
		$end = ( !$row['insurance_end_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['insurance_end_date'] ) );

		$status = ( $row['insurance_start_date'] > date("Y-m-d") ? '<span class="label label-warning">ยังไม่ถึงเวลาแสดงผล</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		if( $row['insurance_end_date'] != null || $row['insurance_end_date'] != '' ){
			$status = ( $row['insurance_end_date'] < date("Y-m-d") ? '<span class="label label-inverse">หมดอายุ</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		}
		
		
		$response = ( !$row['insurance_start_date'] ? 'ไม่กำหนด' : $start.' - '.$end ).'<br />'.$status;
		return $response;
	}
	/* Default function -  End */

}