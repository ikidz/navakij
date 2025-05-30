<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageinsurancecontact extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageinsurancecontact/manageinsurancecontactmodel');
		$this->load->model('administrator/manageinsurance/manageinsurancemodel');
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2aa7829581f0044d116a6d8fad2a91fc');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการติดต่อเรา",'icon-list-alt');
	}

	public function index($insurance_id,$offset=0){
		
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$insurance_info = $this->manageinsurancemodel->get_insuranceinfo_byid($insurance_id);
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('รายการติดต่อเรา ('.$insurance_info['insurance_title_th'].')');
		$this->_data['insurance_id']= $insurance_id;
		$this->_data['category_id']= $insurance_info['insurance_category_id'];
		/* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('manageinsurancecontact/sorting', $this->_data);
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
			$perpage = $this->manageinsurancecontactmodel->count_insurancecontacts($aSort, $insurance_id);
		}

		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageinsurancecontactmodel->get_insurancecontacts($aSort, $insurance_id,$perpage, $offset));
		$totalrows = $this->manageinsurancecontactmodel->count_insurancecontacts($aSort, $insurance_id);
		/* Get Data Table - End */
		
		//$this->admin_model->set_top_button('Export','manageinsurancecontact/export','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('insurance_contact_id','ลำดับ','10%','icon-list');
		$this->admin_model->set_column('insurance_contact_name','ชื่อ-นามสกุล','20%','icon-font');
		$this->admin_model->set_column('insurance_contact_gender','เพศ','5%','icon-user');
		$this->admin_model->set_column('insurance_contact_email','ช่องทางการติดต่อ','25%','icon-font');
		$this->admin_model->set_column('province_id', 'จังหวัด','10%','icon-marker');
		$this->admin_model->set_column('insurance_contact_createdtime','15%','วันที่ลงชื่อ','icon-calendar-o');
		$this->admin_model->set_column_callback('insurance_contact_id','show_seq');
		$this->admin_model->set_column_callback('insurance_contact_name','show_contact_name');
		$this->admin_model->set_column_callback('insurance_contact_gender', 'show_gender');
		$this->admin_model->set_column_callback('insurance_contact_email','show_contact');
		$this->admin_model->set_column_callback('insurance_contact_createdtime', 'show_date');
		$this->admin_model->set_column_callback('province_id', 'show_province');
		$this->admin_model->set_action_button('รายละเอียด','manageinsurancecontact/update/[insurance_contact_id]','icon-eye','btn-primary','w');
		
		$this->admin_model->set_pagination("manageinsurancecontact/index/".$insurance_id,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	
	
	public function update($insurancecontactid=0){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('รายการติดต่อเรา');
		$this->_data['info'] = $this->manageinsurancecontactmodel->get_insurancecontactinfo_byid($insurancecontactid);
		
		$this->form_validation->set_rules('insurance_contact_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			
			
			$this->admin_library->add_breadcrumb("รายการติดต่อเรา","manageinsurancecontact/index","icon-list");
			$this->admin_library->add_breadcrumb("รายการติดต่อเรา","manageinsurancecontact/update/".$insurancecontactid,"icon-plus");
			
			$this->admin_library->view('manageinsurancecontact/update', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->manageinsurancecontactmodel->update($insurancecontactid);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('manageinsurancecontact/index/'.$this->_data['info']['insurance_id']);
			
		}
	}
	
	public function setstatus($setto='discard', $insurancecontactid=0, $insuranceid=0){
		
		$message = $this->manageinsurancecontactmodel->setStatus($setto, $insurancecontactid);
		
		$this->session->set_flashdata($message['status'], $message['text']);
		admin_redirect('manageinsurancecontact/index/'.$insuranceid);
		
	}
	
	public function export($insurance_id,$offset=0){
		
		$aSort['sort_keyword'] = $this->input->post('sort_keyword');
		$aSort['sort_start_date'] = $this->input->post('sort_start_date');
		$aSort['sort_end_date'] = $this->input->post('sort_end_date');
		
		$perpage = $this->manageinsurancecontactmodel->count_insurancecontacts($aSort,$insurance_id);
		$this->_data['aSort'] = $aSort;
		$this->_data['lists'] = $this->manageinsurancecontactmodel->get_insurancecontacts($aSort,$insurance_id);
		$this->_data['insurance'] = $this->manageinsurancemodel->get_insuranceinfo_byid($insurance_id);
		$this->load->view('administrator/views/manageinsurancecontact/export', $this->_data);
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_contact_name($text, $row){
		return $row['insurance_contact_name'].' '.$row['insurance_contact_lastname'];
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}

	public function show_gender( $text, $row ){
		if( $text == 'male' ){
			return 'ชาย';
		}else if( $text == 'female' ){
			return 'หญิง';
		}else{
			return 'N/A';
		}
	}
	
	public function show_contact( $text, $row ){
		$response = '<p>Email : '.$row['insurance_contact_email'].'</p>';
		$response .= '<p>Telephone : '.$row['insurance_contact_mobile'].'</p>';

		return $response;
	}

	public function show_province( $text, $row ){
		$province = $this->manageinsurancecontactmodel->get_provinceinfo_byid( $row['province_id'] );
		return $province['province_name_th'];
	}

	public function show_date( $text, $row ){
		return thai_convert_fulldate( $text );
	}
	/* Default function -  End */

}