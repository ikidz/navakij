<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageiplogs extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageiplogs/manageiplogsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('493478a294919ad4fe6283cbb8fb9762');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("รายงานข้อมูล IP ผู้เข้าเยี่ยมชมเว็บไซต์",'icon-laptop');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('5473059bd6bec8f4a84959a551ac3c3a');
		$this->admin_model->set_detail('รายการ IP');

        $aSort = array();
		
		$aSort['sort_keyword'] = $this->input->get('sort_keyword');
        $aSort['sort_start_date'] = $this->input->get('sort_start_date');
        $aSort['sort_end_date'] = $this->input->get('sort_end_date');
        if( !isset( $_GET['sort_keyword'] ) ){
            $aSort['sort_onlythai'] = 1;
        }else{
            $aSort['sort_onlythai'] = ( !$this->input->get('sort_onlythai') ? 0 : $this->input->get('sort_onlythai') );
        }
        $this->dateStart = $this->input->get('sort_start_date');
        $this->dateEnd = $this->input->get('sort_end_date');
        $perpage = 10;

        /* Set Custom Tools - Start */
        $this->_data['aSort'] = $aSort;
		$this->admin_model->set_custom_tools('manageiplogs/sorting', $this->_data);
		/* Set Custom Tools - End */

        /* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageiplogsmodel->get_iplogs($aSort, $perpage, $offset));
		$totalrows = $this->manageiplogsmodel->count_iplogs( $aSort );
		/* Get Data Table - End */
		
		// $this->admin_model->set_column('hash','ลำดับ','10%','icon-list');
        $this->admin_model->set_column('hash', 'HASH', '20%', 'icon-lock');
		$this->admin_model->set_column('ip','IP','10%','icon-laptop');
		$this->admin_model->set_column('country_code','ประเทศ','15%','icon-flag');
		$this->admin_model->set_column('created_at','วันที่','15%','icon-calendar');
		// $this->admin_model->set_column_callback('hash','show_seq');
		$this->admin_model->set_column_callback('country_code','show_country');
		$this->admin_model->set_action_button('ดูข้อมูลการเข้าเว็บไซต์','manageiplogs/transactions/[hash]','icon-eye','btn-info','r');
		
		$this->admin_model->set_pagination("manageiplogs/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}

    public function exportiplogs(){
        $aSort = array();
		
		$aSort['sort_keyword'] = $this->input->get('sort_keyword');
        $aSort['sort_start_date'] = $this->input->get('sort_start_date');
        $aSort['sort_end_date'] = $this->input->get('sort_end_date');
        if( !isset( $_GET['sort_keyword'] ) ){
            $aSort['sort_onlythai'] = 1;
        }else{
            $aSort['sort_onlythai'] = ( !$this->input->get('sort_onlythai') ? 0 : $this->input->get('sort_onlythai') );
        }
        $this->dateStart = $this->input->get('sort_start_date');
        $this->dateEnd = $this->input->get('sort_end_date');

		$perpage = $this->manageiplogsmodel->count_export_iplogs( $aSort );

        $this->_data['aSort'] = $aSort;
        $this->_data['lists'] = $this->manageiplogsmodel->export_iplogs($aSort, $perpage);
        $this->_data['total'] = count( $this->_data['lists'] );

        $this->load->view('administrator/views/manageiplogs/exportiplogs', $this->_data);
    }

    public function transactions( $hash, $offset=0 ){
        if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}

        $this->_data['info'] = $this->manageiplogsmodel->get_iploginfo_byhash( $hash );
		
		$this->admin_model->set_menu_key('5473059bd6bec8f4a84959a551ac3c3a');
		$this->admin_model->set_detail('รายการข้อมูลการเข้าถึงของ IP : '.$this->_data['info']['ip']);

        $aSort = array();
		
		$aSort['sort_keyword'] = $this->input->get('sort_keyword');
        $aSort['sort_start_date'] = $this->input->get('sort_start_date');
        $aSort['sort_end_date'] = $this->input->get('sort_end_date');
        $this->dateStart = $this->input->get('sort_start_date');
        $this->dateEnd = $this->input->get('sort_end_date');

        /* Set Custom Tools - Start */
        $this->_data['aSort'] = $aSort;
		$this->admin_model->set_custom_tools('manageiplogs/transaction_sorting', $this->_data);
		/* Set Custom Tools - End */

        /* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageiplogsmodel->get_transactionlogs_byhash($this->_data['info']['hash'], $aSort, $perpage, $offset));
		$totalrows = $this->manageiplogsmodel->count_transactionlogs_byhash($this->_data['info']['hash'], $aSort );
		/* Get Data Table - End */

        // $this->admin_model->set_column('hash','ลำดับ','10%','icon-list');
        $this->admin_model->set_column('hash', 'HASH', '20%', 'icon-lock');
		$this->admin_model->set_column('ip','IP','10%','icon-laptop');
		$this->admin_model->set_column('current_url','URL ที่เข้า','30%','icon-flag');
		$this->admin_model->set_column('created_at','วันที่','15%','icon-calendar');
		// $this->admin_model->set_column_callback('hash','show_seq');
		
		$this->admin_model->set_pagination("manageiplogs/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();

    }

    public function exporttransactionlogs( $hash='' ){
        $this->_data['info'] = $this->manageiplogsmodel->get_iploginfo_byhash( $hash );
        $aSort = array();
		
		$aSort['sort_keyword'] = $this->input->get('sort_keyword');
        $aSort['sort_start_date'] = $this->input->get('sort_start_date');
        $aSort['sort_end_date'] = $this->input->get('sort_end_date');
        $this->dateStart = $this->input->get('sort_start_date');
        $this->dateEnd = $this->input->get('sort_end_date');

		$perpage = $this->manageiplogsmodel->count_transactionlogs_byhash($hash, $aSort);

        $this->_data['aSort'] = $aSort;
        $this->_data['lists'] = $this->manageiplogsmodel->get_transactionlogs_byhash($hash, $aSort, $perpage);

        $this->load->view('administrator/views/manageiplogs/exporttransactionlogs', $this->_data);
    }

    /* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}

    public function show_country( $text, $row ){
        return $this->translateCountryCodeToThai( $text );
    }

    private function translateCountryCodeToThai( $countryCode ){
        $countryList = [
            'TH' => 'ประเทศไทย',
            'US' => 'สหรัฐอเมริกา',
            'GB' => 'สหราชอาณาจักร',
            'JP' => 'ญี่ปุ่น',
            'KR' => 'เกาหลีใต้',
            'CN' => 'จีน',
            'FR' => 'ฝรั่งเศส',
            'DE' => 'เยอรมนี',
            'IN' => 'อินเดีย',
            'IT' => 'อิตาลี',
            'AU' => 'ออสเตรเลีย',
            'CA' => 'แคนาดา',
            'RU' => 'รัสเซีย',
            'BR' => 'บราซิล',
            'MX' => 'เม็กซิโก',
            'SG' => 'สิงคโปร์',
            'MY' => 'มาเลเซีย',
            'PH' => 'ฟิลิปปินส์',
            'VN' => 'เวียดนาม',
            'ID' => 'อินโดนีเซีย',
            'ZA' => 'แอฟริกาใต้',
            'EG' => 'อียิปต์',
            'AR' => 'อาร์เจนตินา',
            'SA' => 'ซาอุดีอาระเบีย',
            'AE' => 'สหรัฐอาหรับเอมิเรตส์',
            // Add more countries as needed
        ];
    
        // Convert the country code to uppercase for consistency
        $countryCode = strtoupper($countryCode);
    
        return $countryList[$countryCode] ?? 'ไม่ทราบประเทศ';
    }
    /* Default function - End */

}