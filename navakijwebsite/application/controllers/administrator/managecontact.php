<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managecontact extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managecontact/managecontactmodel');
		//$this->load->model('administrator/manageinsurance/manageinsurancemodel');
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('4d34a369da05061d2d7d88db63a3946f');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการติดต่อเรา",'icon-list-alt');
	}

	public function index($offset=0){
		
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$this->admin_model->set_menu_key('4d34a369da05061d2d7d88db63a3946f');
		$this->admin_model->set_detail('รายการติดต่อเรา');
		/* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('managecontact/sorting', $this->_data);
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
			$perpage = $this->managecontactmodel->count_contacts($aSort);
		}

		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managecontactmodel->get_contacts($aSort,$perpage, $offset));
		$totalrows = $this->managecontactmodel->count_contacts($aSort);
		/* Get Data Table - End */
		
		//$this->admin_model->set_top_button('Export','managecontact/export','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('contact_id','ลำดับ','10%','icon-list');
		$this->admin_model->set_column('contact_name','ชื่อ-นามสกุล','25%','icon-font');
		//$this->admin_model->set_column('_contact_gender','เพศ','15%','icon-font');
		$this->admin_model->set_column('contact_email','อีเมล','25%','icon-font');
		$this->admin_model->set_column('contact_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column_callback('contact_id','show_seq');
		$this->admin_model->set_column_callback('contact_name','show_contact_name');
		$this->admin_model->set_column_callback('contact_status','show_status');
		$this->admin_model->set_action_button('แก้ไข','managecontact/update/[contact_id]','icon-pencil-square-o','btn-success','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managecontact/setstatus/discard/[contact_id]','icon-trash','btn-danger','d');
		
		$this->admin_model->set_pagination("managecontact/index/",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	
	
	public function update($contactid=0){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('4d34a369da05061d2d7d88db63a3946f');
		$this->admin_model->set_detail('ติดต่อเรา');
		
		$this->form_validation->set_rules('article_id','ลิงก์ไปยังบทความ','trim');
		if( $this->input->post('article_id') == 9999 ){
			$this->form_validation->set_rules('contact_url','URL','trim|required');
		}
		$this->form_validation->set_rules('contact_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			$this->_data['info'] = $this->managecontactmodel->get_contactinfo_byid($contactid);
			
			$this->admin_library->add_breadcrumb("รายการติดต่อเรา","managecontact/index","icon-list");
			$this->admin_library->add_breadcrumb("ติดต่อเรา","managecontact/update/".$contactid,"icon-plus");
			
			$this->admin_library->view('managecontact/update', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->managecontactmodel->update($contactid);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managecontact/index');
			
		}
	}
	
	public function setstatus($setto='discard', $contactid=0){
		
		$message = $this->managecontactmodel->setStatus($setto, $contactid);
		
		$this->session->set_flashdata($message['status'], $message['text']);
		admin_redirect('managecontact/index');
		
	}
	
	public function export($offset=0){
		
		$aSort['sort_keyword'] = $this->input->post('sort_keyword');
		$aSort['sort_start_date'] = $this->input->post('sort_start_date');
		$aSort['sort_end_date'] = $this->input->post('sort_end_date');
		
		$perpage = $this->managecontactmodel->count_contacts($aSort);
		$this->_data['aSort'] = $aSort;
		$this->_data['lists'] = $this->managecontactmodel->get_contacts($aSort);
		
		$this->load->view('administrator/views/managecontact/export', $this->_data);
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_contact_name($text, $row){
		return $row['contact_name'].' '.$row['contact_lastname'];
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