<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageboardmembers extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageboardmembers/manageboardmembersmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('c8bec918fcbcb6b3b1fee2ee23e36105');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการผู้บริหาร",'icon-list-alt');
	}

	public function index( $offset=0 ){

        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('fb3e9f62442e33645b1624683b303d65');
        $this->admin_model->set_detail('รายการผู้บริหาร');

        $aSort['sort_keyword'] = $this->input->get('sort_keyword');

        /* Set Custom Tools - Start */
        $this->_data['aSort'] = $aSort;
		$this->admin_model->set_custom_tools('manageboardmembers/sorting', $this->_data);
		/* Set Custom Tools - End */

        $this->admin_model->set_top_button('เพิ่มข้อมูล','manageboardmembers/create','icon-plus','btn-success','w');

        /* Get Data Table - Start */
        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
            $this->seq = $offset;
        }else{
            $offset = 0;
        }
        $this->admin_model->set_dataTable($this->manageboardmembersmodel->get_members($aSort, $perpage, $offset));
        $totalrows = $this->manageboardmembersmodel->count_members($aSort);
        /* Get Data Table - End */

        $this->admin_model->set_column('member_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('member_image','รูปภาพ','15%','icon-picture-o');
        $this->admin_model->set_column('member_name_th','ชื่อ - นามสกุล','15%','icon-quote');
        $this->admin_model->set_column('member_status','สถานะการแสดงผล','15%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไขข้อมูล','manageboardmembers/update/[member_id]','icon-pencil-square','btn-primary','w');
        $this->admin_model->set_action_button('ลบข้อมูล','manageboardmembers/delete/[member_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_column_callback('member_id','show_seq');
        $this->admin_model->set_column_callback('member_image','show_thumbnail');
        $this->admin_model->set_column_callback('member_status','show_status');
        $this->admin_model->set_pagination("manageboardmembers/index",$totalrows,$perpage,4);
        $this->admin_model->make_list();
                
        $this->admin_library->output();
        
	}

    public function create(){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('fb3e9f62442e33645b1624683b303d65');
        $this->admin_model->set_detail('เพิ่มรายการผู้บริหาร');

        $this->form_validation->set_rules('member_name_th','ชื่อ (ไทย)','trim|required');
        $this->form_validation->set_rules('member_name_en','ชื่อ (En)','trim|required');
        $this->form_validation->set_rules('member_position_th','ตำแหน่ง (ไทย)','trim');
        $this->form_validation->set_rules('member_position_en','ตำแหน่ง (En)','trim');
        $this->form_validation->set_rules('member_type_th', 'ประเภทกรรมการที่เสนอแต่งตั้ง (ไทย)', 'trim');
        $this->form_validation->set_rules('member_type_en', 'ประเภทกรรมการที่เสนอแต่งตั้ง (En)', 'trim');
        $this->form_validation->set_rules('member_history_th', 'จำนวนปีที่ดำรงตำแหน่งกรรมการ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_history_en', 'จำนวนปีที่ดำรงตำแหน่งกรรมการ (En)', 'trim');
        $this->form_validation->set_rules('member_age', 'อายุ', 'trim|numeric');
        $this->form_validation->set_rules('member_nationality_th', 'สัญชาติ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_nationality_en', 'สัญชาติ (En)', 'trim');
        $this->form_validation->set_rules('member_educational_th', 'คุณวุฒิการศึกษา (ไทย)', 'trim');
        $this->form_validation->set_rules('member_educational_en', 'คุณวุฒิการศึกษา (En)', 'trim');
        $this->form_validation->set_rules('member_committee_seminar_th', 'การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (ไทย)', 'trim');
        $this->form_validation->set_rules('member_committee_seminar_en', 'การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (En)', 'trim');
        $this->form_validation->set_rules('member_other_seminar_th', 'การอบรมอื่น (ไทย)', 'trim');
        $this->form_validation->set_rules('member_other_seminar_en', 'การอบรมอื่น (En)', 'trim');
        $this->form_validation->set_rules('member_expertise_th', 'ความเชี่ยวชาญ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_expertise_en', 'ความเชี่ยวชาญ (En)', 'trim');
        $this->form_validation->set_rules('member_current_position_th', 'ตำแหน่งปัจจุบันในบริษัท (ไทย)', 'trim');
        $this->form_validation->set_rules('member_current_position_en', 'ตำแหน่งปัจจุบันในบริษัท (En)', 'trim');
        $this->form_validation->set_rules('member_registered_company_th', 'บริษัทจดทะเบียน (ไทย)', 'trim');
        $this->form_validation->set_rules('member_registered_company_en', 'บริษัทจดทะเบียน (En)', 'trim');
        $this->form_validation->set_rules('member_unregister_company_th', 'กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (ไทย)', 'trim');
        $this->form_validation->set_rules('member_unregister_company_en', 'กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (En)', 'trim');
        $this->form_validation->set_rules('member_sharedholding_ratio', 'สัดส่วนการถือหุ้นของบริษัท (จำนวนหุ้น)', 'trim|numeric');
        $this->form_validation->set_rules('member_sharedholding_percentage', 'สัดส่วนการถือหุ้นของบริษัท (ร้อยละ)', 'trim');
        $this->form_validation->set_rules('member_sharedholding_updatedat', 'วันที่ปรับปรุงสัดส่วนการถือหุ้นของบริษัท', 'trim');
        $this->form_validation->set_rules('member_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการผู้บริหาร","manageboardmembers/index","icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการผู้บริหาร","manageboardmembers/create","icon-plus");

            $this->admin_library->view('manageboardmembers/create', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->manageboardmembersmodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageboardmembers/index');
        }
    }

    public function update($memberid=0){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('fb3e9f62442e33645b1624683b303d65');
        $this->admin_model->set_detail('แก้ไขรายการผู้บริหาร');

        $this->form_validation->set_rules('member_name_th','ชื่อ (ไทย)','trim|required');
        $this->form_validation->set_rules('member_name_en','ชื่อ (En)','trim|required');
        $this->form_validation->set_rules('member_position_th','ตำแหน่ง (ไทย)','trim');
        $this->form_validation->set_rules('member_position_en','ตำแหน่ง (En)','trim');
        $this->form_validation->set_rules('member_type_th', 'ประเภทกรรมการที่เสนอแต่งตั้ง (ไทย)', 'trim');
        $this->form_validation->set_rules('member_type_en', 'ประเภทกรรมการที่เสนอแต่งตั้ง (En)', 'trim');
        $this->form_validation->set_rules('member_history_th', 'จำนวนปีที่ดำรงตำแหน่งกรรมการ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_history_en', 'จำนวนปีที่ดำรงตำแหน่งกรรมการ (En)', 'trim');
        $this->form_validation->set_rules('member_age', 'อายุ', 'trim|numeric');
        $this->form_validation->set_rules('member_nationality_th', 'สัญชาติ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_nationality_en', 'สัญชาติ (En)', 'trim');
        $this->form_validation->set_rules('member_educational_th', 'คุณวุฒิการศึกษา (ไทย)', 'trim');
        $this->form_validation->set_rules('member_educational_en', 'คุณวุฒิการศึกษา (En)', 'trim');
        $this->form_validation->set_rules('member_committee_seminar_th', 'การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (ไทย)', 'trim');
        $this->form_validation->set_rules('member_committee_seminar_en', 'การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (En)', 'trim');
        $this->form_validation->set_rules('member_other_seminar_th', 'การอบรมอื่น (ไทย)', 'trim');
        $this->form_validation->set_rules('member_other_seminar_en', 'การอบรมอื่น (En)', 'trim');
        $this->form_validation->set_rules('member_expertise_th', 'ความเชี่ยวชาญ (ไทย)', 'trim');
        $this->form_validation->set_rules('member_expertise_en', 'ความเชี่ยวชาญ (En)', 'trim');
        $this->form_validation->set_rules('member_current_position_th', 'ตำแหน่งปัจจุบันในบริษัท (ไทย)', 'trim');
        $this->form_validation->set_rules('member_current_position_en', 'ตำแหน่งปัจจุบันในบริษัท (En)', 'trim');
        $this->form_validation->set_rules('member_registered_company_th', 'บริษัทจดทะเบียน (ไทย)', 'trim');
        $this->form_validation->set_rules('member_registered_company_en', 'บริษัทจดทะเบียน (En)', 'trim');
        $this->form_validation->set_rules('member_unregister_company_th', 'กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (ไทย)', 'trim');
        $this->form_validation->set_rules('member_unregister_company_en', 'กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (En)', 'trim');
        $this->form_validation->set_rules('member_sharedholding_ratio', 'สัดส่วนการถือหุ้นของบริษัท (จำนวนหุ้น)', 'trim|numeric');
        $this->form_validation->set_rules('member_sharedholding_percentage', 'สัดส่วนการถือหุ้นของบริษัท (ร้อยละ)', 'trim');
        $this->form_validation->set_rules('member_sharedholding_updatedat', 'วันที่ปรับปรุงสัดส่วนการถือหุ้นของบริษัท', 'trim');
        $this->form_validation->set_rules('member_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการผู้บริหาร","manageboardmembers/index","icon-list-ol");
            $this->admin_library->add_breadcrumb("แก้ไขรายการผู้บริหาร","manageboardmembers/update/".$memberid,"icon-pencil-square");

            $this->_data['info'] = $this->manageboardmembersmodel->get_memberinfo_byid( $memberid );

            $this->admin_library->view('manageboardmembers/update', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->manageboardmembersmodel->update($memberid);
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageboardmembers/index');
        }
    }

    public function delete( $memberid=0 ){
        $message = array();
        $message = $this->manageboardmembersmodel->setStatus('discard', $memberid);

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('manageboardmembers/index');
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_thumbnail($text, $row){
        if($text!=''){
            return '<a href="'.base_url('public/core/uploaded/boardmembers/'.$row['member_image']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/boardmembers/'.$row['member_image']).'" alt="" style="width:150px;" /></a>';
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
    /* Default function -  End */

}