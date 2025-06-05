<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managehierarchy extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managehierarchy/managehierarchymodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('c8bec918fcbcb6b3b1fee2ee23e36105');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการผู้บริหาร",'icon-list-alt');
	}

	public function index($mainid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('712db0b1c5fce63a76799b73f0def0f1');
		$this->admin_model->set_detail('รายการตำแหน่งโครงสร้างองค์กร');

		if( $mainid > 0 ){
			$this->admin_model->set_top_button('กลับไปยังตำแหน่งหลัก','managehierarchy/index','icon-undo','btn-primary','r');
		}
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managehierarchymodel->get_positions($mainid, $perpage, $offset));
		$totalrows = $this->managehierarchymodel->count_positions($mainid);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('position_id','ลำดับ','10%','icon-list-ol');
		if( $mainid > 0 ){
			$this->admin_model->set_column('main_id','ตำแหน่งหลัก','15%','icon-quote');
		}
		$this->admin_model->set_column('position_title_th','ชื่อตำแหน่ง','15%','icon-font');
		$this->admin_model->set_column('position_createdtime','','60%','');
		$this->admin_model->set_column_callback('position_id','show_seq');
		$this->admin_model->set_column_callback('main_id','show_position');
		$this->admin_model->set_column_callback('position_createdtime','show_buttons');
		$this->admin_model->set_pagination("managehierarchy/index/".$mainid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function hierarchy( $positionid=0, $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$position = $this->managehierarchymodel->get_positioninfo_byid( $positionid );
		if( !isset( $position ) ){
			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกตำแหน่ง'
			);

			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehierarchy/index');
		}
		
		$this->admin_model->set_menu_key('712db0b1c5fce63a76799b73f0def0f1');
		$this->admin_model->set_detail('โครงสร้างองค์กร ตำแหน่ง : '.$position['position_title_th']);
		
		$this->admin_model->set_top_button('เพิ่มลำดับชั้นโครงสร้างองค์กร','managehierarchy/create/'.$positionid,'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังตำแหน่ง','managehierarchy/index/'.$position['main_id'],'icon-undo','btn-primary','r');
		
		/* Get Data Table - Start */
		$perpage = 20;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
			$this->seq = 0;
		}
		$this->admin_model->set_dataTable($this->managehierarchymodel->get_hierarchy($positionid, $perpage, $offset));
		$totalrows = $this->managehierarchymodel->count_hierarchy($positionid);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('hierarchy_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('member_id','ชื่อผู้บริหาร','15%','icon-user');
		$this->admin_model->set_column('hierarchy_level','ลำดับชั้น','10%','icon-level-up');
		$this->admin_model->set_column('hierarchy_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('hierarchy_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managehierarchy/update/[position_id]/[hierarchy_id]','icon-pencil-square','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managehierarchy/delete/[position_id]/[hierarchy_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('hierarchy_id','show_seq');
		$this->admin_model->set_column_callback('member_id','show_member');
		$this->admin_model->set_column_callback('hierarchy_order','show_order');
		$this->admin_model->set_column_callback('hierarchy_status','show_status');
		$this->admin_model->set_pagination("managehierarchy/hierarchy/".$positionid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create( $positionid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('712db0b1c5fce63a76799b73f0def0f1');
		$this->admin_model->set_detail('เพิ่มลำดับชั้นโครงสร้างองค์กร');
		
		$this->form_validation->set_rules('member_id','ผู้บริหาร','trim|required');
		$this->form_validation->set_rules('hierarchy_level','ลำดับชั้น','trim|required');
        $this->form_validation->set_rules('hierarchy_position_th','ชื่อตำแหน่ง (ไทย)','trim|required');
        $this->form_validation->set_rules('hierarchy_position_en','ชื่อตำแหน่ง (En)','trim|required');
		$this->form_validation->set_rules('hierarchy_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$position = $this->managehierarchymodel->get_positioninfo_byid( $positionid );
			$this->_data['position'] = $position;
            $this->_data['members'] = $this->managehierarchymodel->get_boardmembers();

			$this->admin_library->add_breadcrumb("โครงสร้างองค์กร ตำแหน่ง : ".$position['position_title_th'],"managehierarchy/hierarchy/".$position['position_title_th'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มโครงลำดับชั้นโครงสร้างองค์กร","managehierarchy/create/".$position['position_id'],"icon-plus");
			
			$this->admin_library->view('managehierarchy/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managehierarchymodel->create($positionid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehierarchy/hierarchy/'.$positionid);
		}
	}
	
	public function update( $positionid=0, $hierarchyid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('712db0b1c5fce63a76799b73f0def0f1');
		$this->admin_model->set_detail('แก้ไขลำดับชั้นโครงสร้างองค์กร');
		
		$this->form_validation->set_rules('member_id','ผู้บริหาร','trim|required');
		$this->form_validation->set_rules('hierarchy_level','ลำดับชั้น','trim|required');
        $this->form_validation->set_rules('hierarchy_position_th','ชื่อตำแหน่ง (ไทย)','trim|required');
        $this->form_validation->set_rules('hierarchy_position_en','ชื่อตำแหน่ง (En)','trim|required');
		$this->form_validation->set_rules('hierarchy_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$position = $this->managehierarchymodel->get_positioninfo_byid( $positionid );
			$this->_data['position'] = $position;
            $this->_data['members'] = $this->managehierarchymodel->get_boardmembers();
            $this->_data['info'] = $this->managehierarchymodel->get_hierarchyinfo_byid( $hierarchyid );
			$this->admin_library->add_breadcrumb("โครงสร้างองค์กร ตำแหน่ง : ".$position['position_title_th'],"managehierarchy/hierarchy/".$position['position_title_th'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขโครงลำดับชั้นโครงสร้างองค์กร","managehierarchy/update/".$position['position_id'].'/'.$hierarchyid,"icon-pencil-square");
			
			$this->admin_library->view('managehierarchy/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managehierarchymodel->update($positionid, $hierarchyid);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managehierarchy/hierarchy/'.$positionid);
		}
	}
	
	public function delete( $positionid=0, $hierarchyid=0 ){
		$message = array();
		$message = $this->managehierarchymodel->setStatus('discard', $hierarchyid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managehierarchy/hierarchy/'.$positionid);
	}
	
	public function setorder( $movement='up', $positionid=0, $hierarchyid=0 ){
		$message = array();
		$message = $this->managehierarchymodel->setOrder($movement, $hierarchyid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managehierarchy/hierarchy/'.$positionid);
	}

	public function api_get_boardmemberinfo(){
		$member = $this->managehierarchymodel->get_boardmemberinfo_byid( $this->input->post('memberId') );
		if( isset( $member ) && count( $member ) > 0 ){
			$response = array(
				'status' => 200,
				'position_th' => $member['member_position_th'],
				'position_en' => $member['member_position_en']
			);
		}else{
			$response = array(
				'status' => 404
			);
		}

		$this->json->set('response', $response);
		$this->json->send();
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}

	public function show_position( $text, $row ){
		$position = $this->managehierarchymodel->get_positioninfo_byid( $row['position_id'] );
		return $position['position_title_th'];
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	
	public function show_order($text, $row){
		$text = $text.' ';
		$text .= '(<a href="'.admin_url('managehierarchy/setorder/up/'.$row['position_id'].'/'.$row['hierarchy_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managehierarchy/setorder/down/'.$row['position_id'].'/'.$row['hierarchy_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	
	public function show_buttons( $text, $row ){
		$subPosition = $this->managehierarchymodel->get_positions( $row['position_id'] );
		if(	isset( $subPosition ) && count( $subPosition ) > 0 ){
			return '<p style="text-align:right; margin:0;"><a href="'.admin_url('managehierarchy/index/'.$row['position_id']).'" class="btn btn-mini"><i class="icon-level-down"></i> ดูตำแหน่งย่อย</a></p>';
		}else{
			return '<p style="text-align:right; margin:0;"><a href="'.admin_url('managehierarchy/hierarchy/'.$row['position_id']).'" class="btn btn-mini btn-primary"><i class="icon-sitemap"></i> จัดการโครงสร้างองค์กร</a></p>';
		}
	}

	public function show_member( $text, $row ){
		$member = $this->managehierarchymodel->get_boardmemberinfo_byid( $row['member_id'] );
		return $member['member_name_th'];
	}
	/* Default function -  End */

}