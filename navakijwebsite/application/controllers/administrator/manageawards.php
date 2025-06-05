<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageawards extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageawards/manageawardsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('ba16b1ff048a487c8a2a6c943ae1e607');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรางวัล",'icon-list-alt');
	}

	public function index($offset=0){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('503eb6036a432392ef4cc5ff2a0bd381');
        $this->admin_model->set_detail('รายการรางวัล');

        $this->admin_model->set_top_button('เพิ่มข้อมูล','manageawards/create','icon-plus','btn-success','w');

        /* Get Data Table - Start */
        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
            $this->seq = $offset;
        }else{
            $offset = 0;
        }
        $this->admin_model->set_dataTable($this->manageawardsmodel->get_awards($perpage, $offset));
        $totalrows = $this->manageawardsmodel->count_awards();
        /* Get Data Table - End */

        $this->admin_model->set_column('award_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('award_image','รูปภาพ','15%','icon-picture-o');
        $this->admin_model->set_column('award_title_th','ชื่อ','15%','icon-font');
        $this->admin_model->set_column('award_order','การจัดลำดับ','15%','icon-sort');
        $this->admin_model->set_column('award_status','สถานะการแสดงผล','15%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไข','manageawards/update/[award_id]','icon-pencil-square-o','btn-primary','w');
        $this->admin_model->set_action_button('ลบข้อมูล','manageawards/delete/[award_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_column_callback('award_id','show_seq');
        $this->admin_model->set_column_callback('award_image','show_thumbnail');
        $this->admin_model->set_column_callback('award_order','show_order');
        $this->admin_model->set_column_callback('award_status','show_status');
        $this->admin_model->set_pagination("manageawards/index",$totalrows,$perpage,4);
        $this->admin_model->make_list();
                
        $this->admin_library->output();
	}

    public function create(){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('503eb6036a432392ef4cc5ff2a0bd381');
        $this->admin_model->set_detail('เพิ่มรายการรางวัล');

        $this->form_validation->set_rules('award_title_th','ชื่อ (ไทย)','trim|required');
        $this->form_validation->set_rules('award_title_en','ชื่อ (En)','trim|required');
        $this->form_validation->set_rules('award_desc_th','รายละเอียด (ไทย)','trim|required');
        $this->form_validation->set_rules('award_desc_en','รายละเอียด (En)','trim|required');
        $this->form_validation->set_rules('award_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            $this->admin_library->view('manageawards/create', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->manageawardsmodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageawards/index');
        }
    }

    public function update($awardid=0){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('503eb6036a432392ef4cc5ff2a0bd381');
        $this->admin_model->set_detail('แก้ไขรายการรางวัล');

        $this->form_validation->set_rules('award_title_th','ชื่อ (ไทย)','trim|required');
        $this->form_validation->set_rules('award_title_en','ชื่อ (En)','trim|required');
        $this->form_validation->set_rules('award_desc_th','รายละเอียด (ไทย)','trim|required');
        $this->form_validation->set_rules('award_desc_en','รายละเอียด (En)','trim|required');
        $this->form_validation->set_rules('award_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            $this->_data['info'] = $this->manageawardsmodel->get_awardinfo_byid( $awardid );

            $this->admin_library->view('manageawards/update', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->manageawardsmodel->update($awardid);
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageawards/index');
        }
    }

    public function setorder( $movement='up', $awardid=0 ){
        $message = array();
        $message = $this->manageawardsmodel->setOrder( $movement, $awardid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('manageawards/index');
    }

    public function delete( $awardid=0 ){
        $message = array();
        $message = $this->manageawardsmodel->setStatus('discard', $awardid);

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('manageawards/index');
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_thumbnail($text, $row){
        if($text!=''){
            return '<a href="'.base_url('public/core/uploaded/awards/'.$row['award_image']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/awards/'.$row['award_image']).'" alt="" style="width:150px;" /></a>';
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

    public function show_order($text, $row){
        $text = $text.' ';
        $text .= '(<a href="'.admin_url('manageawards/setorder/up/'.$row['award_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('manageawards/setorder/down/'.$row['award_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }
    /* Default function -  End */

}