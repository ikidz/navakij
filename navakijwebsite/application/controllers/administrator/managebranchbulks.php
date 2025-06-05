<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managebranchbulks extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managebranchbulks/managebranchbulksmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('95249f054e1caa96054bf35140e42d90');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเครือข่ายสินไหมฯ",'icon-list-alt');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('4783f6556a275c79ebf0fcdebd47dd6c');
		$this->admin_model->set_detail('รายการอัพโหลด');
		
		/* Set Custom Tools - Start */
		$this->_data['categories'] = $this->managebranchbulksmodel->get_branch_categories();
		$this->admin_model->set_custom_tools('managebranchbulks/upload', $this->_data);
        /* Set Custom Tools - End */
        
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchbulksmodel->get_bulks($perpage, $offset));
		$totalrows = $this->managebranchbulksmodel->count_bulks();
		/* Get Data Table - End */
		
		$this->form_validation->set_rules('category_id','หมวดหมู่','trim|required');
		$this->form_validation->set_rules('bulk_title','ชื่อ','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_model->set_column('bulk_id','ลำดับ','10%','icon-list-ol');
			$this->admin_model->set_column('category_id', 'หมวดหมู่','15%','icon-star');
			$this->admin_model->set_column('bulk_file','ไฟล์','15%','icon-file');
			$this->admin_model->set_column('bulk_title','ชื่อ','15%','icon-font');
			$this->admin_model->set_column('bulk_status','สถานะ','15%','icon-info');
			$this->admin_model->set_column('bulk_createdtime','วันที่อัพโหลดไฟล์','15%','icon-calendar-o');
			$this->admin_model->set_action_button('ลบข้อมูล','managebranchbulks/delete/[bulk_id]','icon-trash','btn-danger','d');
			$this->admin_model->set_column_callback('bulk_id','show_seq');
			$this->admin_model->set_column_callback('category_id','show_category');
			$this->admin_model->set_column_callback('bulk_file','show_file');
			$this->admin_model->set_column_callback('bulk_status','show_status');
			$this->admin_model->set_column_callback('bulk_createdtime','show_datetime');
			$this->admin_model->set_pagination("managebranchbulks/index",$totalrows,$perpage,4);
			$this->admin_model->make_list();
					
			$this->admin_library->output();
		}else{
			$message = $this->managebranchbulksmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranchbulks/index');
		}

	}
	
	public function delete( $bulkid=0 ){
		$message = array();
		$message = $this->managebranchbulksmodel->setStatus('discard', $bulkid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managebranchbulks/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}

	public function show_category( $text, $row ){
		$category = $this->managebranchbulksmodel->get_branch_categorinfo_byid( $text );
		return $category['category_title_th'];
	}
	
	public function show_file($text, $row){
		if($text!=''){
			return '<a href="'.base_url('public/core/uploaded/branch_bulks/'.$row['bulk_file']).'" class="fancybox-button">ดาวน์โหลด <i class="icon-download"></i></a>';
		}else{
			return 'ไม่มีไฟล์';
		}
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'finished'	    	: return '<span class="label label-success"><i class="icon-check"></i> เสร็จสมบูรณ์</span><br />(เมื่อวันที่ '.thai_convert_fulldate( $row['bulk_finished_time'] ).' )'; break;
			case 'patial_finished'	: return '<span class="label label-success"><i class="icon-check"></i> สำเร็จบางส่วน</span><br />(เมื่อวันที่ '.thai_convert_fulldate( $row['bulk_finished_time'] ).' )<br />หมายเหตุ : '.$row['bulk_remark'].'<br />รายงาน : <a href="'.base_url('public/core/uploaded/branch_bulks/'.$row['bulk_report']).'">ดาวน์โหลด</a>'; break;
			case 'processing'		: return '<span class="label label-info"><i class="icon-spinner"></i> กำลังประมวลผล</span>'; break;
			case 'error'    		: return '<span class="label label-important"><i class="icon-exclamation-triangle"></i> เกิดข้อผิดพลาด</span><br />เนื่องจาก : '.$row['bulk_remark']; break;
			case 'pending'	    	: return '<span class="label label-warning"><i class="icon-cogs"></i> อยู่ระหว่างการตรวจสอบ</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	
	public function show_datetime($text, $row){
		$date_th = thai_convert_fulldate( $row['bulk_createdtime'] ).' '.date( "H:i:s", strtotime($row['bulk_createdtime']) );
		return $date_th;
	}
	
	/* Default function -  End */

}