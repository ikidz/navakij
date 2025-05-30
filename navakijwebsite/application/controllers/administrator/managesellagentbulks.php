<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managesellagentbulks extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managesellagentbulks/managesellagentbulksmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('d397784530797a82027ffb2fcc18542b');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("รายการนำเข้าข้อมูลตัวแทน",'icon-list-alt');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('3e18efeb7bfa48a0531987fbaa68537d');
		$this->admin_model->set_detail('รายการนำเข้าข้อมูล');

        /* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('managesellagentbulks/upload', $this->_data);
        /* Set Custom Tools - End */
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managesellagentbulksmodel->get_bulks($perpage, $offset));
		$totalrows = $this->managesellagentbulksmodel->count_bulks();
		/* Get Data Table - End */
		
		$this->form_validation->set_rules('name','ชื่อ','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
		
			$this->admin_model->set_column('id','ลำดับ','10%','icon-list-ol');
			$this->admin_model->set_column('file','ไฟล์','15%','icon-upload');
			$this->admin_model->set_column('name','ชื่อรายการ','30%','icon-font');
			$this->admin_model->set_column('status','สถานะ','15%','icon-cog');
			$this->admin_model->set_column('created_at','สร้างเมื่อวันที่','15%','icon-calendar');
			$this->admin_model->set_column_callback('id','show_seq');
			$this->admin_model->set_column_callback('file','show_file');
			$this->admin_model->set_column_callback('status','show_status');
			$this->admin_model->set_column_callback('created_at','show_datetime');
			$this->admin_model->set_action_button('ลบข้อมูล','managedsellagentbulks/delete/[id]','icon-trash','btn-danger','d');
			$this->admin_model->set_pagination("managesellagentbulks/delete/[id]",$totalrows,$perpage,4);
			$this->admin_model->make_list();
					
			$this->admin_library->output();
			
		}else{
			$message = $this->managesellagentbulksmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managesellagentbulks/index');
		}
	}
	
	public function delete( $bulkid=0 ){
		$message = $this->managesellagentbulksmodel->setStatus('discard', $bulkid);
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managesellagentbulks/index');
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_file($text, $row){
		if($text!=''){
			return '<a href="'.base_url('public/core/uploaded/sellagent_bulks/'.$row['file']).'" class="fancybox-button">ดาวน์โหลด <i class="icon-download"></i></a>';
		}else{
			return 'ไม่มีไฟล์';
		}
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'finished'	    	: return '<span class="label label-success"><i class="icon-check"></i> เสร็จสมบูรณ์</span><br />(เมื่อวันที่ '.thai_convert_fulldate( $row['finished_time'] ).' )'; break;
			case 'patial_finished'	: return '<span class="label label-success"><i class="icon-check"></i> สำเร็จบางส่วน</span><br />(เมื่อวันที่ '.thai_convert_fulldate( $row['finished_time'] ).' )<br />หมายเหตุ : '.$row['bulk_remark'].'<br />รายงาน : <a href="'.base_url('public/core/uploaded/branch_bulks/'.$row['bulk_report']).'">ดาวน์โหลด</a>'; break;
			case 'processing'		: return '<span class="label label-info"><i class="icon-spinner"></i> กำลังประมวลผล</span>'; break;
			case 'error'    		: return '<span class="label label-important"><i class="icon-exclamation-triangle"></i> เกิดข้อผิดพลาด</span><br />เนื่องจาก : '.$row['bulk_remark']; break;
			case 'pending'	    	: return '<span class="label label-warning"><i class="icon-cogs"></i> อยู่ระหว่างการตรวจสอบ</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	public function show_datetime($text, $row){
		$date_th = thai_convert_fulldate( $row['created_at'] );
		return $date_th.' '.date('H:i:s', strtotime( $row['created_at']));
	}
	/* Default function -  End */

}