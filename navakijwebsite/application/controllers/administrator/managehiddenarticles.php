<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managehiddenarticles extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	var $offset;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managehiddenarticles/managehiddenarticlesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1d8bd8e6fde38fdd6e03c1103afdd9e2');
		
		$this->admin_model->initd($this);
		
		$this->admin_model->set_title("จัดการบทความ",'icon-list-alt');
	}

	public function index($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('1eb815007963660b4be2c762f7986496');
		$this->admin_model->set_detail('รายการบทความซ่อนทั้งหมด');

		/* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managehiddenarticlesmodel->get_articlelists($perpage, $offset));
		$totalrows = $this->managehiddenarticlesmodel->count_articlelists();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มบทความ','managehiddenarticles/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('article_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('article_thumbnail','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('article_title_th','ชื่อเรื่อง','20%','icon-font');
		$this->admin_model->set_column('article_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column('article_meta_url','URL','20%','icon-link');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managehiddenarticles/update/[article_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managehiddenarticles/delete/[article_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('article_id','show_seq');
		$this->admin_model->set_column_callback('article_thumbnail','show_thumbnail');
		$this->admin_model->set_column_callback('article_meta_url','show_url');
		$this->admin_model->set_column_callback('article_status','show_status');
		
		$this->admin_model->set_pagination("managehiddenarticles/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('1eb815007963660b4be2c762f7986496');
		$this->admin_model->set_detail('เพิ่มบทความซ่อน');
		
		$this->form_validation->set_rules('article_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('article_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('article_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('article_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('article_postdate', 'วันที่','trim|required');
		$this->form_validation->set_rules('article_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_status','Display Status','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการบทความซ่อน","managehiddenarticles/index","icon-list");
			$this->admin_library->add_breadcrumb("เพิ่มบทความซ่อน","managehiddenarticles/create","icon-plus");
			
			$this->admin_library->view('managehiddenarticles/create', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managehiddenarticlesmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehiddenarticles/index');
			
		}
	}
	
	public function update($articleid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('1eb815007963660b4be2c762f7986496');
		$this->admin_model->set_detail('แก้ไขบทความ');
		
		$this->form_validation->set_rules('article_title_th','ชื่อเรื่อง (ไทย)','trim|required');
		$this->form_validation->set_rules('article_title_en','ชื่อเรื่อง (En)','trim|required');
		$this->form_validation->set_rules('article_desc_th','รายละเอียด (ไทย)','trim');
		$this->form_validation->set_rules('article_desc_en','รายละเอียด (En)','trim');
		$this->form_validation->set_rules('article_postdate', 'วันที่','trim|required');
		$this->form_validation->set_rules('article_meta_title', 'Title สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_description','Description สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_keyword','Keyword สำหรับ SEO','trim');
		$this->form_validation->set_rules('article_meta_url','URL สำหรับ SEO','trim|required');
		$this->form_validation->set_rules('article_status','Display Status','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการบทความ","managehiddenarticles/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขบทความ","managehiddenarticles/update/".$articleid,"icon-pencil-square-o");
			
			$this->_data['info'] = $this->managehiddenarticlesmodel->get_articleinfo_byid($articleid);
			
			$this->admin_library->view('managehiddenarticles/update', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managehiddenarticlesmodel->update($articleid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehiddenarticles/index');
			
		}
	}

	public function delete($articleid=0, $offset=0){
		$this->offset = $offset;
		$message = $this->managehiddenarticlesmodel->setStatus('discard', $articleid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managehiddenarticles/index/'.$this->offset);
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url( 'public/core/uploaded/hidden_article/'.$row['article_image_th'] ).'" class="fancybox-button"><img src="'.base_url( 'public/core/uploaded/hidden_article/thumb/'.$row['article_thumbnail'] ).'" alt="" style="width:150px;" /></a>';
		}else{
			return 'ไม่มีรูปภาพแสดง';
		}
	}

	public function show_url( $text, $row ){
		return '<a href="'.site_url( $text ).'" target="_blank">'.site_url( $text ).'</a>';
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