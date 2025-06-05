<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managedataclearingbot extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managedataclearingbot/managedataclearingbotmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรับสมัครงาน",'icon-list-alt');
	}

	public function index(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('86ca86d3109936019c878557dad203ac');
		$this->admin_model->set_detail('ตั้งค่าลบข้อมูลอัตโนมัติ');
		
		$this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->managedataclearingbotmodel->get_setting_bykey( 'pdpa_clearing_range' );

            $this->admin_library->view('managedataclearingbot/index', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managedataclearingbotmodel->update( 'pdpa_clearing_range' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managedataclearingbot/index');

        }
	}

    public function report( $offset=0 ){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('28836e23832a61877f59534272cd09ed');
        $this->admin_model->set_detail('รายการข้อมูลที่ลบไป');

        /* Get Data Table - Start */
        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
            $this->seq = $offset;
        }else{
            $offset = 0;
        }
        $this->admin_model->set_dataTable($this->managedataclearingbotmodel->get_report($perpage, $offset));
        $totalrows = $this->managedataclearingbotmodel->count_report();
        /* Get Data Table - End */

        $this->admin_model->set_column('deleted_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('deleted_name','ชื่อ - นามสกุล','25%','icon-user');
        $this->admin_model->set_column('deleted_idcard','หมายเลขบัตรประชาชน','15%','icon-credit-card');
        $this->admin_model->set_column('deleted_tel','เบอร์โทรศัพท์','10%','icon-mobile');
        $this->admin_model->set_column('deleted_email','อีเมล','10%','icon-envelope-o');
        $this->admin_model->set_column('deleted_createdtime','วันที่ลบ','15%','icon-calendar-o');
        $this->admin_model->set_column_callback( 'deleted_id','show_seq' );

        $this->admin_model->set_pagination("managedataclearingbot/report",$totalrows,$perpage,4);
        $this->admin_model->make_list();
                
        $this->admin_library->output();
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }
    /* Default function -  End */

}