<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managesubscribe extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managesubscribe/managesubscribemodel');
		//$this->load->model('administrator/manageinsurance/manageinsurancemodel');
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('56d68815c73b57a37420efb3bf6371b8');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการติดต่อเรา",'icon-list-alt');
	}

	public function index($offset=0){
		
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$this->admin_model->set_menu_key('56d68815c73b57a37420efb3bf6371b8');
		$this->admin_model->set_detail('รายการติดต่อเรา');
		/* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('managesubscribe/sorting', $this->_data);
		/* Set Custom Tools - End */
		
		$aSort = array();
		
		$this->form_validation->set_rules('sort_keyword','Keyword','trim');
		$this->form_validation->set_rules('sort_start_date','Start Date','trim');
		$this->form_validation->set_rules('sort_end_date','End Date','trim');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			//$aSort['sort_campaigns'] = '';
			$aSort['sort_keyword'] = '';
			$aSort['sort_start_date'] = '';
			$aSort['sort_end_date'] = '';
			$this->dateStart = '';
			$this->dateEnd = '';
			$perpage = 10;
		}else{
			//$aSort['sort_campaigns'] = $this->input->post('sort_campaigns');
			$aSort['sort_keyword'] = $this->input->post('sort_keyword');
			$aSort['sort_start_date'] = $this->input->post('sort_start_date');
			$aSort['sort_end_date'] = $this->input->post('sort_end_date');
			$this->dateStart = $this->input->post('sort_start_date');
			$this->dateEnd = $this->input->post('sort_end_date');
			$perpage = $this->managesubscribemodel->count_subscribes($aSort);
		}

		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managesubscribemodel->get_subscribes($aSort,$perpage, $offset));
		$totalrows = $this->managesubscribemodel->count_subscribes($aSort);
		/* Get Data Table - End */
		
		//$this->admin_model->set_top_button('Export','managesubscribe/export','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('subscribe_id','ลำดับ','10%','icon-list');
		$this->admin_model->set_column('subscribe_email','อีเมล','45%','icon-font');
		$this->admin_model->set_column('subscribe_createdtime','เวลา','15%','icon-calendar');
		$this->admin_model->set_column('subscribe_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column_callback('subscribe_id','show_seq');
		$this->admin_model->set_column_callback('subscribe_status','show_status');
		$this->admin_model->set_column_callback('subscribe_createdtime','show_subscribe_createdtime');
		$this->admin_model->set_action_button('ลบข้อมูล','managesubscribe/setstatus/discard/[subscribe_id]','icon-trash','btn-danger','d');
		
		$this->admin_model->set_pagination("managesubscribe/index/",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	
	public function setstatus($setto='discard', $subscribeid=0){
		
		$message = $this->managesubscribemodel->setStatus($setto, $subscribeid);
		
		$this->session->set_flashdata($message['status'], $message['text']);
		admin_redirect('managesubscribe/index');
		
	}
	
	public function export($offset=0){
		
		$aSort['sort_keyword'] = $this->input->post('sort_keyword');
		$aSort['sort_start_date'] = $this->input->post('sort_start_date');
		$aSort['sort_end_date'] = $this->input->post('sort_end_date');
		
		$perpage = $this->managesubscribemodel->count_subscribes($aSort);
		$this->_data['aSort'] = $aSort;
		$this->_data['lists'] = $this->managesubscribemodel->get_subscribes($aSort);
		
		$this->load->view('administrator/views/managesubscribe/export', $this->_data);
		
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

	public function show_subscribe_createdtime($text, $row)
	{
		return date("d-m-Y H:i:s", strtotime($text));
	}
	
	
	/* Default function -  End */

}