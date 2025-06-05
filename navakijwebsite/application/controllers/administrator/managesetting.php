<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managesetting extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managesetting/managesettingmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('bf8e0a60f0edbf926277baf71999b22c');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("การตั้งค่าเว็บไซต์",'icon-list-alt');
	}

	public function index($key=''){

        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }
        $this->_data['key'] = $key;
        switch( $key ){
            case 'seo_meta_title' :
                $menukey = '9eb596baa6295588d46b8e12f54715a4';
                $this->_data['_menu_name']="ตั้งค่า Default ของ SEO Meta Title";
            break;
            case 'seo_meta_description' :
                $menukey = '5c2315bfbf0092e5abaefbc0a3c43b05';
                $this->_data['_menu_name']="ตั้งค่า Default ของ SEO Meta Description";
            break;
            case 'seo_meta_keyword' :
                $menukey = '14e9be132b929014dfe563f24cff897b';
                $this->_data['_menu_name']='ตั้งค่า Default ของ SEO Meta Keyword';
            break;
            case 'admin_email' : 
                $menukey = 'df2178e8646e1f433d208bd1fb8963b9';
                $this->_data['_menu_name']='ตั้งค่า Email ของผู้ดูแลระบบ';
            break;
            default :
                $menukey = 'bf8e0a60f0edbf926277baf71999b22c';
                $this->_data['_menu_name'] = '';
        }

        $this->admin_model->set_menu_key( $menukey );
        $this->admin_model->set_detail( $this->_data['_menu_name'] );
        $this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->managesettingmodel->get_setting_bykey( $key  );

            $this->admin_library->view('managesetting/index', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managesettingmodel->update( $key );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managesetting/index/'.$key);

        }

    }
    
    public function socials($channel=''){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        switch( $channel ){
            case 'facebook' :
                $menukey = 'c47c2c1ae21d44164f3b31a810750b23';
                $this->_data['_menu_name']="Facebook URL";
            break;
            case 'instagram' :
                $menukey = '4fa9684950432706eb4a6febdb86239d';
                $this->_data['_menu_name']='ลิงก์ Instagram';
            break;
            case 'youtube' :
                $menukey = '38720c800383ec0904a75ce45fa15b4a';
                $this->_data['_menu_name'] = 'ลิงก์ YouTube';
            break;
            default :
                $menukey = 'bf8e0a60f0edbf926277baf71999b22c';
                $this->_data['_menu_name'] = '';
        }

        $this->admin_model->set_menu_key( $menukey );
        $this->admin_model->set_detail( $this->_data['_menu_name'] );
        $this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->managesettingmodel->get_setting_bykey( 'social_'.$channel );

            $this->admin_library->view('managesetting/index_input', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managesettingmodel->update( 'social_'.$channel );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managesetting/socials/'.$channel);

        }
    }

    public function marketingTags(){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }
        $this->admin_model->set_menu_key( 'e55444d336be97eb56a84497cacb0b1e' );
        $this->_data['_menu_name'] = 'Marketing Tags';
        $this->admin_model->set_detail( $this->_data['_menu_name'] );
        $this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->managesettingmodel->get_setting_bykey( 'marketing_tags' );

            $this->admin_library->view('managesetting/index_textarea', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managesettingmodel->update( 'marketing_tags' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managesetting/marketingTags');

        }
    }

    public function staticPage( $page='' ){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        switch( $page ){
            case 'terms' :
                $menukey = 'bbec7974821338dce817fcb9bf20f597';
                $this->_data['_menu_name']="Terms of Use";
            break;
            case 'privacy' :
                $menukey = 'd90a849c5d8c718ee120ae410a0cdb7c';
                $this->_data['_menu_name']='Privacy Policy';
            break;
            default :
                $menukey = 'bbec7974821338dce817fcb9bf20f597';
                $this->_data['_menu_name'] = '';
        }

        $this->admin_model->set_menu_key( $menukey );
        $this->admin_model->set_detail( $this->_data['_menu_name'] );
        $this->form_validation->set_rules('setting_value_th','รายละเอียด (ไทย)','trim');
        $this->form_validation->set_rules('setting_value_en','รายละเอียด (En)','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info_th'] = $this->managesettingmodel->get_setting_bykey( $page.'_th' );
            $this->_data['info_en'] = $this->managesettingmodel->get_setting_bykey( $page.'_en' );

            $this->admin_library->view('managesetting/index_texteditor', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managesettingmodel->updateStaticPage( $page );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managesetting/staticPage/'.$page);

        }
    }

    public function address(){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key( '3f87fcf63b96c014b41625241eda96f7' );
        $this->admin_model->set_detail( 'ที่อยู่' );
        $this->form_validation->set_rules('company_title_th','ชื่อองค์กร (ไทย)','trim');
        $this->form_validation->set_rules('company_title_en','ชื่อองค์กร (En)','trim');
        $this->form_validation->set_rules('company_address_th','ที่อยู่องค์กร (ไทย)','trim');
        $this->form_validation->set_rules('company_address_en','ที่อยู่องค์กร (en)','trim');
        // $this->form_validation->set_rules('company_tel','เบอร์โทรศัพท์','trim');
        // $this->form_validation->set_rules('company_fax','เบอร์โทรสาร','trim');
        // $this->form_validation->set_rules('company_email','อีเมล','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['companyTitle_th'] = $this->managesettingmodel->get_setting_bykey( 'company_title_th' );
            $this->_data['companyTitle_en'] = $this->managesettingmodel->get_setting_bykey( 'company_title_en' );
            $this->_data['companyAddress_th'] = $this->managesettingmodel->get_setting_bykey( 'company_address_th' );
            $this->_data['companyAddress_en'] = $this->managesettingmodel->get_setting_bykey( 'company_address_en' );
            // $this->_data['companyTel'] = $this->managesettingmodel->get_setting_bykey( 'company_tel' );
            // $this->_data['companyFax'] = $this->managesettingmodel->get_setting_bykey( 'company_fax' );
            // $this->_data['companyEmail'] = $this->managesettingmodel->get_setting_bykey( 'company_email' );
            $this->_data['companyGoogleMap'] = $this->managesettingmodel->get_setting_bykey( 'company_google_map' );
            $this->_data['companyLocation_lat'] = $this->managesettingmodel->get_setting_bykey( 'company_location_lat' );
            $this->_data['companyLocation_lng'] = $this->managesettingmodel->get_setting_bykey( 'company_location_lng' );

            $this->admin_library->view('managesetting/address', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->managesettingmodel->updateAddress();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managesetting/address');

        }
    }

}