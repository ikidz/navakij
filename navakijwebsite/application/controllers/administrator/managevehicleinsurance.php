<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managevehicleinsurance extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	var $offset;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managevehicleinsurance/managevehicleinsurancemodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		
		$this->admin_model->initd($this);
		
		$this->admin_model->set_title("จัดการบทความ",'icon-list-alt');
	}

	public function index($insuranceid=0, $offset=0){

		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}

		$insurance = $this->managevehicleinsurancemodel->get_insuranceinfo_byid( $insuranceid );

		if( $insuranceid <= 0 ){

			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกประกันภัย'
			);

			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurance/index');
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		if( isset( $insurance ) && count( $insurance ) > 0 ){
			$this->admin_model->set_detail('รายการประกันภัยรถยนต์ "'.$insurance['insurance_title_th'].'"');
		}else{
			$this->admin_model->set_detail('รายการประกันภัยรถยนต์ทั้งหมด');
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

		$this->admin_model->set_dataTable($this->managevehicleinsurancemodel->get_vehicleinsurancelists($insurance['insurance_id'], $perpage, $offset));
		$totalrows = $this->managevehicleinsurancemodel->count_vehicleinsurancelists($insurance['insurance_id']);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มประกันภัยรถยนต์','managevehicleinsurance/create/'.$insurance['insurance_id'],'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการประกันภัย','manageinsurance/index/'.$insurance['insurance_category_id'],'icon-undo','btn-primary','w');
		
		$this->admin_model->set_column('vehicle_insurance_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('vehicle_group_id','ประเภทรถยนต์','15%','icon-eye-slash');
		$this->admin_model->set_column('sum_insured','เงินเอาประกันภัย','25%','icon-font');
		$this->admin_model->set_column('price','เบี้ยประกันภัย','15%','icon-font');
		$this->admin_model->set_column('vehicle_insurance_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managevehicleinsurance/update/[insurance_id]/[vehicle_insurance_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managevehicleinsurance/delete/[insurance_id]/[vehicle_insurance_id]','icon-trash','btn-danger','d');
		//$this->admin_model->set_action_button('จัดการแกลอรี','managegallery/index/[insurance_id]/[vehicleinsurance_id]','icon-picture-o','btn-inverse','r');
		$this->admin_model->set_column_callback('vehicle_insurance_id','show_seq');
		$this->admin_model->set_column_callback('insurance_id','show_insurance');
		$this->admin_model->set_column_callback('vehicle_group_id','show_vehicle_group');
		$this->admin_model->set_column_callback('vehicle_insurance_status','show_status');
		
		$this->admin_model->set_pagination("managevehicleinsurance/index/".$insurance['insurance_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create($insuranceid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('เพิ่มบทความ');
		
		$this->_data['insurance'] = $this->managevehicleinsurancemodel->get_insuranceinfo_byid( $insuranceid );
		$insurance = $this->_data['insurance'];
		
		$this->form_validation->set_rules('vehicle_group_id','ประเภทรถยนต์','trim|required');
		$this->form_validation->set_rules('sum_insured','เงินเอาประกันภัย','trim|required');
		$this->form_validation->set_rules('price','เบี้ยประกันภัย','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการประกันภัยรถยนต์","managevehicleinsurance/index/".$insurance['insurance_id'],"icon-list");
			$this->admin_library->add_breadcrumb("เพิ่มประกันภัยรถยนต์","managevehicleinsurance/create/".$insurance['insurance_id'],"icon-plus");
			$this->_data['vehicle_group'] = $this->managevehicleinsurancemodel->get_vehicle_group_list();
			$this->admin_library->view('managevehicleinsurance/create', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managevehicleinsurancemodel->create($insuranceid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managevehicleinsurance/index/'.$insurance['insurance_id']);
			
		}
	}
	
	public function update($insuranceid=0, $vehicleinsuranceid=0){
		if(!$this->admin_model->check_permision("w")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
		$this->admin_model->set_detail('แก้ไขบทความ');
		
		$this->_data['insurance'] = $this->managevehicleinsurancemodel->get_insuranceinfo_byid( $insuranceid );
		$insurance = $this->_data['insurance'];
		
		$this->form_validation->set_rules('vehicle_group_id','ประเภทรถยนต์','trim|required');
		$this->form_validation->set_rules('sum_insured','เงินเอาประกันภัย','trim|required');
		$this->form_validation->set_rules('price','เบี้ยประกันภัย','trim|required');
		$this->form_validation->set_message('required','"%s" is required.');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการประกันภัยรถยนต์","managevehicleinsurance/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขประกันภัยรถยนต์","managevehicleinsurance/update/".$insurance['insurance_id'].'/'.$vehicleinsuranceid,"icon-pencil-square-o");
			
			$this->_data['info'] = $this->managevehicleinsurancemodel->get_vehicleinsuranceinfo_byid($vehicleinsuranceid);
			$this->_data['vehicle_group'] = $this->managevehicleinsurancemodel->get_vehicle_group_list();
			$this->admin_library->view('managevehicleinsurance/update', $this->_data);
			$this->admin_library->output();
		}else{
			
			$message = $this->managevehicleinsurancemodel->update($vehicleinsuranceid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managevehicleinsurance/index/'.$insurance['insurance_id']);
			
		}
	}
	
	public function delete($insuranceid=0, $vehicleinsuranceid=0, $offset=0){
		//$this->offset = $offset;
		$message = $this->managevehicleinsurancemodel->setStatus('discard', $vehicleinsuranceid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managevehicleinsurance/index/'.$insuranceid.'/'.$offset);
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_insurance($text, $row){
		return $this->managevehicleinsurancemodel->get_insurance_name($text);
	}
	
	public function show_vehicle_group($text, $row){
		return $this->managevehicleinsurancemodel->get_vehicle_group_name($text);
	}
	/* Default function -  End */
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
}