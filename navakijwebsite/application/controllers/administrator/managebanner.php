<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managebanner extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managebanner/managebannermodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('5f6c44248c82076ee0be15a9e3959ba4');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการแบนเนอร์หลัก",'icon-list-alt');
	}

	public function index($offset=0){
		
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('427bc1f1e5e754b9668f940f51c5f6b8');
		$this->admin_model->set_detail('รายการแบนเนอร์หลัก');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebannermodel->get_banners($perpage, $offset));
		$totalrows = $this->managebannermodel->count_banners();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มแบนเนอร์ใหม่','managebanner/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('banner_id','ลำดับ','10%','icon-list');
		$this->admin_model->set_column('banner_image','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('banner_title_th','ชื่อแบนเนอร์','20%','icon-font');
		$this->admin_model->set_column('banner_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('banner_start_date','ช่วงวันที่แสดงผล','15%','icon-calendar-o');
		$this->admin_model->set_column('banner_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column_callback('banner_id','show_seq');
		$this->admin_model->set_column_callback('banner_image','show_image');
		$this->admin_model->set_column_callback('banner_order','show_order');
		$this->admin_model->set_column_callback('banner_start_date','show_period');
		$this->admin_model->set_column_callback('banner_status','show_status');
		$this->admin_model->set_action_button('แก้ไข','managebanner/update/[banner_id]','icon-pencil-square-o','btn-success','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managebanner/setstatus/discard/[banner_id]','icon-trash','btn-danger','d');
		
		$this->admin_model->set_pagination("managebanner/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	public function create(){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('427bc1f1e5e754b9668f940f51c5f6b8');
		$this->admin_model->set_detail('เพิ่มแบนเนอร์');
		
		$this->form_validation->set_rules('article_id','ลิงก์ไปยังบทความ','trim');
		if( $this->input->post('article_id') == 9999 ){
			$this->form_validation->set_rules('banner_url','URL','trim|required');
		}
		$this->form_validation->set_rules('banner_title_th','ชื่อแบนเนอร์ (ไทย)','trim|required');
		$this->form_validation->set_rules('banner_title_en','ชื่อแบนเนอร์ (En)','trim|required');
		$this->form_validation->set_rules('banner_caption_th','แคปชั่นของแบนเนอร์','trim');
		$this->form_validation->set_rules('banner_caption_en','แคปชั่นของแบนเนอร์','trim');
		$this->form_validation->set_rules('banner_start','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('banner_end','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('banner_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			$this->admin_library->add_breadcrumb("รายการแบนเนอร์","managebanner/index","icon-list");
			$this->admin_library->add_breadcrumb("เพิ่มแบนเนอร์","managebanner/create","icon-plus");
			
			$this->admin_library->view('managebanner/create', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->managebannermodel->create();
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managebanner/index');
			
		}
	}
	
	public function update($bannerid=0){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('427bc1f1e5e754b9668f940f51c5f6b8');
		$this->admin_model->set_detail('แก้ไขแบนเนอร์');
		
		$this->form_validation->set_rules('article_id','ลิงก์ไปยังบทความ','trim');
		if( $this->input->post('article_id') == 9999 ){
			$this->form_validation->set_rules('banner_url','URL','trim|required');
		}
		$this->form_validation->set_rules('banner_title_th','ชื่อแบนเนอร์ (ไทย)','trim|required');
		$this->form_validation->set_rules('banner_title_en','ชื่อแบนเนอร์ (En)','trim|required');
		$this->form_validation->set_rules('banner_caption_th','แคปชั่นของแบนเนอร์','trim');
		$this->form_validation->set_rules('banner_caption_en','แคปชั่นของแบนเนอร์','trim');
		$this->form_validation->set_rules('banner_start','วันที่เริ่ม','trim');
		$this->form_validation->set_rules('banner_end','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('banner_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			$this->_data['info'] = $this->managebannermodel->get_bannerinfo_byid($bannerid);
			
			$this->admin_library->add_breadcrumb("รายการแบนเนอร์","managebanner/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขแบนเนอร์","managebanner/update/".$bannerid,"icon-plus");
			
			$this->admin_library->view('managebanner/update', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->managebannermodel->update($bannerid);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managebanner/index');
			
		}
	}
	
	public function setstatus($setto='discard', $bannerid=0){
		
		$message = $this->managebannermodel->setStatus($setto, $bannerid);
		
		$this->session->set_flashdata($message['status'], $message['text']);
		admin_redirect('managebanner/index');
		
	}
	
	public function setorder($movement='up', $bannerid=0){
		
		$message = $this->managebannermodel->setOrder($movement, $bannerid);
		
		$this->session->set_flashdata($message['status'], $message['text']);
		admin_redirect('managebanner/index');
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_image($text, $row){
		if($text!=''){
			return '<a href="../core/uploaded/banner/'.$text.'" class="fancybox-button"><img src="../core/uploaded/banner/'.$text.'" alt="" style="width:150px;" /></a>';
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

	public function show_period( $text, $row ){
		$start = ( !$row['banner_start_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['banner_start_date'] ) );
		$end = ( !$row['banner_end_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['banner_end_date'] ) );

		$status = ( $row['banner_start_date'] > date("Y-m-d") ? '<span class="label label-warning">ยังไม่ถึงเวลาแสดงผล</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		if( $row['banner_end_date'] != null || $row['banner_end_date'] != '' ){
			$status = ( $row['banner_end_date'] < date("Y-m-d") ? '<span class="label label-inverse">หมดอายุ</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		}
		
		$response = ( !$row['banner_start_date'] ? 'ไม่กำหนด' : $start.' - '.$end ).'<br />'.$status;
		return $response;
	}
	
	public function show_order($text, $row){
		$text = $text.' ';
		$text .= '(<a href="'.admin_url('managebanner/setorder/up/'.$row['banner_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managebanner/setorder/down/'.$row['banner_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}