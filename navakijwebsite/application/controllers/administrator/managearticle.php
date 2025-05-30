<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managearticle extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	var $offset;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managearticle/managearticlemodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1d8bd8e6fde38fdd6e03c1103afdd9e2');
		
		$this->admin_model->initd($this);
		
		$this->admin_model->set_title("จัดการบทความ",'icon-list-alt');
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

			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managecategory/index');
		}

		$category = $this->managearticlemodel->get_categoryinfo_byid( $categoryid );
		
		$this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
		if( isset( $category ) && count( $category ) > 0 ){
			$this->admin_model->set_detail('รายการบทความของ "'.$category['category_title_th'].'"');
		}else{
			$this->admin_model->set_detail('รายการบทความทั้งหมด');
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
		$this->admin_model->set_dataTable($this->managearticlemodel->get_articlelists($category['category_id'], $perpage, $offset));
		$totalrows = $this->managearticlemodel->count_articlelists($category['category_id']);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มบทความ','managearticle/create/'.$category['category_id'],'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการหมวดหมู่','managecategory/index/'.$category['main_id'],'icon-undo','btn-primary','w');
		
		$this->admin_model->set_column('article_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('article_thumbnail','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('article_title_th','ชื่อเรื่อง','25%','icon-font');
		$this->admin_model->set_column('article_start_date','ช่วงวันที่แสดงผล','20%','icon-calendar-o');
		$this->admin_model->set_column('article_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managearticle/update/[category_id]/[article_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managearticle/delete/[category_id]/[article_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_action_button('จัดการแกลอรี','managegallery/index/[category_id]/[article_id]','icon-picture-o','btn-inverse','r');
		$this->admin_model->set_column_callback('article_id','show_seq');
		$this->admin_model->set_column_callback('article_thumbnail','show_thumbnail');
		$this->admin_model->set_column_callback('article_start_date','show_period');
		$this->admin_model->set_column_callback('article_status','show_status');
		
		$this->admin_model->set_pagination("managearticle/index/".$category['category_id'],$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create($categoryid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
		$this->admin_model->set_detail('เพิ่มบทความ');
		
		$this->_data['category'] = $this->managearticlemodel->get_categoryinfo_byid( $categoryid );
		$category = $this->_data['category'];
		
		$this->form_validation->set_rules('article_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('article_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('article_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('article_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('article_postdate', 'วันที่','trim|required');
		$this->form_validation->set_rules('article_start_date','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('article_end_date','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('article_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_status','Display Status','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการบทความ","managearticle/index/".$category['category_id'],"icon-list");
			$this->admin_library->add_breadcrumb("เพิ่มบทความ","managearticle/create/".$category['category_id'],"icon-plus");
			
			$this->admin_library->view('managearticle/create', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managearticlemodel->create($categoryid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managearticle/index/'.$category['category_id']);
			
		}
	}
	
	public function update($categoryid=0, $articleid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
		$this->admin_model->set_detail('แก้ไขบทความ');
		
		$this->_data['category'] = $this->managearticlemodel->get_categoryinfo_byid( $categoryid );
		$category = $this->_data['category'];
		
		$this->form_validation->set_rules('article_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('article_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('article_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('article_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('article_postdate', 'วันที่','trim|required');
		$this->form_validation->set_rules('article_start_date','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('article_end_date','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('article_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_url','URL สำหรับ SEO','trim|required');
		$this->form_validation->set_rules('article_status','Display Status','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการบทความ","managearticle/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขบทความ","managearticle/update/".$category['category_id'].'/'.$articleid,"icon-pencil-square-o");
			
			$this->_data['info'] = $this->managearticlemodel->get_articleinfo_byid($articleid);
			
			$this->admin_library->view('managearticle/update', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managearticlemodel->update($articleid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managearticle/index/'.$category['category_id']);
			
		}
	}

	public function aboutus(){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('06d3a34d63ae6296af51e01a7ee47429');
		$this->admin_model->set_detail('แก้ไขข้อมูลเกี่ยวกับเรา');
		
		$this->form_validation->set_rules('article_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('article_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('article_desc_th','รายละเอียด (ไทย)','trim|required');
		$this->form_validation->set_rules('article_desc_en','รายละเอียด (En)','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("แก้ไขข้อมูลเกี่ยวกับเรา","managearticle/aboutus","icon-pencil-square-o");
			
			$this->_data['info'] = $this->managearticlemodel->get_aboutus();
			
			$this->admin_library->view('managearticle/aboutus', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managearticlemodel->updateAboutUs();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managearticle/aboutus');
			
		}
	}
	
	public function delete($categoryid=0, $articleid=0, $offset=0){
		$this->offset = $offset;
		$message = $this->managearticlemodel->setStatus('discard', $articleid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managearticle/index/'.$categoryid.'/'.$this->offset);
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url( 'public/core/uploaded/article/'.$row['article_image_th'] ).'" class="fancybox-button"><img src="'.base_url( 'public/core/uploaded/article/thumb/'.$row['article_thumbnail'] ).'" alt="" style="width:150px;" /></a>';
		}else{
			return 'ไม่มีรูปภาพแสดง';
		}
	}

	public function show_period( $text, $row ){
		$start = ( !$row['article_start_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['article_start_date'] ) );
		$end = ( !$row['article_end_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['article_end_date'] ) );

		$status = ( $row['article_start_date'] > date("Y-m-d") ? '<span class="label label-warning">ยังไม่ถึงเวลาแสดงผล</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		if( $row['article_end_date'] != null || $row['article_end_date'] != '' ){
			$status = ( $row['article_end_date'] < date("Y-m-d") ? '<span class="label label-inverse">หมดอายุ</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		}
		
		$response = ( !$row['article_start_date'] ? 'ไม่กำหนด' : $start.' - '.$end ).'<br />'.$status;
		return $response;
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	/* Default function -  End */

}