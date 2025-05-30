<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managesellagents extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managesellagents/managesellagentsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('d397784530797a82027ffb2fcc18542b');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการข้อมูลตัวแทน",'icon-list-alt');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('3e18efeb7bfa48a0531987fbaa68537d');
		$this->admin_model->set_detail('รายการข้อมูลตัวแทน');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managesellagentsmodel->get_agents($perpage, $offset));
		$totalrows = $this->managesellagentsmodel->count_agents();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มข้อมูลตัวแทน','managesellagents/create','icon-plus','btn-success','w');
		$this->admin_model->set_top_button('นำเข้ารายการข้อมูลตัวแทน','managesellagentbulks/index','icon-upload','btn-primary','w');
		
		$this->admin_model->set_column('agent_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('agent_name_th','ชื่อ','30%','icon-user');
		$this->admin_model->set_column('agent_license_no','เลขที่ใบอนุญาต','15%','icon-credit-card');
		$this->admin_model->set_column('agent_status','สถานะการแสดงผล','10%','icon-eye-slash');
		$this->admin_model->set_column_callback('agent_id','show_seq');
		$this->admin_model->set_column_callback('agent_status','show_status');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managesellagents/update/[agent_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managesellagents/delete/[agent_id]','icon-trash','btn-danger','d');
		
		$this->admin_model->set_pagination("managesellagents/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('3e18efeb7bfa48a0531987fbaa68537d');
		$this->admin_model->set_detail('เพิ่มข้อมูลตัวแทน');
		
		$this->form_validation->set_rules('agent_name_th','ชื่อตัวแทน (ไทย)','trim|required');
		$this->form_validation->set_rules('agent_name_en','ชื่อตัวแทน (En)','trim');
		$this->form_validation->set_rules('agent_license_no','เลขที่ใบอนุญาต','trim|required');
		$this->form_validation->set_rules('agent_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการข้อมูลตัวแทน","managesellagents/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มข้อมูลตัวแทน","managesellagents/create","icon-plus");
			
			$this->admin_library->view('managesellagents/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managesellagentsmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managesellagents/index');
		}
	}
	
	public function update( $agentid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('3e18efeb7bfa48a0531987fbaa68537d');
		$this->admin_model->set_detail('แก้ไขข้อมูลตัวแทน');

        $info = $this->managesellagentsmodel->get_agentinfo_byid( $agentid );
		
		$this->form_validation->set_rules('agent_name_th','ชื่อตัวแทน (ไทย)','trim|required');
		$this->form_validation->set_rules('agent_name_en','ชื่อตัวแทน (En)','trim');
		$this->form_validation->set_rules('agent_license_no','เลขที่ใบอนุญาต','trim|required');
		$this->form_validation->set_rules('agent_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการข้อมูลตัวแทน","managesellagents/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขข้อมูลตัวแทน","managesellagents/update/".$info['agent_id'],"icon-pencil-square-o");

            $this->_data['info'] = $info;
			
			$this->admin_library->view('managesellagents/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managesellagentsmodel->update( $info['agent_id'] );
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managesellagents/index');
		}
	}
	
	public function delete( $agentid=0 ){
		$message = $this->managesellagentsmodel->setStatus( 'discard', $agentid );
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managesellagents/index');
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
	/* Default function -  End */
	

}