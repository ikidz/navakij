<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Project Name : CI Master V3
* Build Date : 2/25/2558 BE
* Author Name : Jarak Kritkiattisak
* File Name : import_luckydraw.php
* File Location : /Volumes/Macintosh HD/Users/mycools/Documents/htdocs/cimaster_v3/application/controllers/administrator
* File Type : Controller	
* Remote URL : /application/controllers/administrator/import_luckydraw.php
*/
class Luckydraw extends CI_Controller {
	var $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('admin_library');
		$this->load->model('administrator/admin_model');
		$this->load->model('administrator/luckydraw_model');	
		$this->load->helper('thai');
		$this->admin_library->forceLogin();
		$this->admin_model->set_menu_key('0914413975b88c951f08f2dc073a5079');
		$this->admin_library->add_breadcrumb("จัดรายชื่อผู้โชคดี","luckydraw/index","icon-smile-o");
		$this->data['allowgift'] = array('gold','giftcard');
		$this->data['allowgiftqty']['gold'] = 51;
		$this->data['allowgiftqty']['giftcard'] = 10;
	}
	public function index($page=1)
	{
		if(!$this->admin_model->check_permision("r")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$limitRecord = 100;
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดรายชื่อผู้โชคดี","icon-smile-o");
		
		$this->admin_model->set_top_button("นำเข้าข้อมูลใหม่","luckydraw/newimport",'icon-upload','btn-success  btn-mini','w');
		
		$this->admin_model->set_datatable($this->luckydraw_model->getKeydateDataTable($limitRecord,$page));
		
		$this->admin_model->set_column("key_date","วันที่ข้อมูล",0,'icon-clock-o');
		$this->admin_model->set_column("key_addby","ผู้นำเข้าข้อมูล",150,'icon-user-md','hidden-phone');
		$this->admin_model->set_column("key_status","สถานะข้อมูล",120,'icon-check-square-o');
		$this->admin_model->set_column_callback("key_date",'_toDisplayDate');
		$this->admin_model->set_column_callback("key_addby",'_toDisplayOwner');
		$this->admin_model->set_column_callback("key_status",'_toDisplayStatus');
		
		$this->admin_model->set_action_button("จัดการข้อมูล","luckydraw/manageimport/[key_id]/[key_date]",'icon-file-excel-o','btn-info','w');
		$this->admin_model->set_tools_width(80);
		$this->admin_model->make_list();
		
		
		
		$this->admin_library->output();
	}
	/**
	* new import
	*
	* Function description
	*
	* @return	array
	*/
	public function newimport()
	{
		
		$this->load->library("form_validation");
		$this->form_validation->set_rules("key_date","วันที่ข้อมูล","trim|required");
		$this->form_validation->set_rules("file_import","ไฟล์ข้อมูล","trim|callback_valid_file[xls,xlsx]");
		$this->form_validation->set_message("required","กรุณาให้%sที่ถูกต้อง เนื่องจากเป็นข้อมูลที่จำเป็น");
		
		$this->admin_library->add_breadcrumb("นำเข้าข้อมูลใหม่","luckydraw/newimport","icon-upload");
		$this->admin_library->setTitle('นำเข้าข้อมูลใหม่','icon-upload');
		$this->admin_library->setDetail("นำเข้าข้อมูลใหม่ด้วยข้อมูลจาก Excel");
			
		if($this->form_validation->run()==false){
			$this->admin_library->view("luckydraw/newimport",$this->data);
			$this->admin_library->output();
		}else{
			if(!($fullpath=$this->upload_excel())){
				$this->admin_library->view("luckydraw/newimport",$this->data);
				$this->admin_library->output();
				return false;
			}
			
			if(!$this->read_excel($fullpath)){
				$this->admin_library->view("luckydraw/newimport",$this->data);
				$this->admin_library->output();
				return false;
			}
			admin_redirect("luckydraw/newimport_preview");
		}
		
	}
	/**
	* newimport_preview
	*
	* Function description
	*
	* @return	array
	*/
	public function newimport_preview($page=1)
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$limitRecord = 100;
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดรายชื่อผู้โชคดี","icon-smile-o");
		
		$this->admin_model->set_top_button("นำเข้าใหม่อีกอีกครั้ง","luckydraw/newimport",'icon-refresh','btn-success  btn-mini','w');
		$this->admin_model->set_top_button("บันทึกการนำเข้า","luckydraw/newimport_save",'icon-floppy-o','btn-info  btn-mini','w');
		
		$this->admin_model->set_datatable($this->luckydraw_model->getTempDataTable($limitRecord,$page));
		
		$this->admin_model->set_column("lucky_id","ลำดับ",50,'icon-bookmark-o');
		$this->admin_model->set_column("lucky_date","วันที่ข้อมูล",0,'icon-clock-o');
		$this->admin_model->set_column("lucky_phoneno","เบอร์โทรศัพท์",150,'icon-mobile','hidden-phone');
		$this->admin_model->set_column("lucky_smscode","รหัส SMS",150,'icon-comments','hidden-phone');
		$this->admin_model->set_column("lucky_prize","ของรางวัล",150,'icon-gift','hidden-phone');
		$this->admin_model->set_column("lucky_status","สถานะข้อมูล",120,'icon-check-square-o');
		$this->admin_model->set_column_callback("lucky_date",'_toDisplayDate');
		$this->admin_model->set_column_callback("lucky_status",'_toLuckyStatus');
		$this->admin_model->set_column_callback("lucky_prize",'_toLuckyPrize');
/*
		$this->admin_model->set_column_callback("key_date",'_toDisplayDate');
		$this->admin_model->set_column_callback("key_addby",'_toDisplayOwner');
		$this->admin_model->set_column_callback("key_status",'_toDisplayStatus');
*/
		//$this->admin_model->set_tools_width(80);
		$this->admin_model->make_list();
		
		
		
		$this->admin_library->output();
	}
	/**
	* newimport_save
	*
	* Function description
	*
	* @return	array
	*/
	public function newimport_save()
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->db->where("key_date",$key_date);
		$this->db->count_all_results("lucky_list");
		$tmp_rec = $this->luckydraw_model->getTempDataTable();
		$key_date = '';
		$rec_c=0;
		foreach($tmp_rec->result_array() as $row){
			$key_date = $row['lucky_date'];
			$this->db->set("lucky_phoneno",$row['lucky_phoneno']);
			$this->db->set("lucky_smscode",$row['lucky_smscode']);
			$this->db->set("lucky_prize",$row['lucky_prize']);
			$this->db->set("lucky_date",$row['lucky_date']);
			$this->db->set("lucky_status",'pending');
			$this->db->set("luckydraw_by",$this->admin_library->user_id());
			$this->db->set("luckydraw_ip",$this->input->ip_address());
			$this->db->set("luckydraw_date",date("Y-m-d H:i:s"));
			$this->db->insert("lucky_list");
			$rec_c++;
		}
		if($rec_c==0){
			$key_status="nodata";
		}else{
			$key_status="pending";
		}
		$this->db->set("key_date",$key_date);
		$this->db->set("key_addby",$this->admin_library->user_id());
		$this->db->set("key_addip",$this->input->ip_address());
		$this->db->set("key_addtime",date("Y-m-d H:i:s"));
		$this->db->set("key_status",$key_status);
		$this->db->insert("lucky_keydate");
		$this->session->set_flashdata("message-success","นำเข้าข้อมูลสำเร็จ.");
		admin_redirect("luckydraw/index");
	}
	public function upload_excel()
	{
		$config['upload_path'] = './public/uploads/excel_import/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['encrypt_name'] = true;
		$config['max_size'] = ($this->admin_library->get_upload_max_filesize()/1024);
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file_import'))
		{
			$this->data['error_message']=$this->upload->display_errors();
			return false;
		}
		else
		{
			$data = $this->upload->data();
			$filename = @$data['file_name'];
			$fullpath = @$data['full_path'];
			return $fullpath;
		}
	}
	
	public function read_excel($fullpath)
	{
		$objExcel = IOFactory::load($fullpath);
		$sheet = $objExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		$key_date = date("Y-m-d",strtotime($this->input->post("key_date")));
		$this->db->truncate("lucky_list_tmp");
		$prize_count = array();
		foreach($this->data['allowgift'] as $p){
			$prize_count[$p]=0;
		}
		
		for ($row = 1; $row <= $highestRow; $row++){ 
		    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                    NULL,
		                                    TRUE,
		                                    FALSE);
		    if(isset($rowData[0])){
			    $resdata = $rowData[0];
			    if($row==1){
				    if(($resdata[0]!="Phone Number") || ($resdata[1]!="SMS Code") || ($resdata[2]!="Reward(gold,giftcard)") ){
					    $this->data['error_message']="รูปแบบไฟล์ไม่ถูกต้อง กรุณาใช้รูปแบบไฟล์ที่ถูกต้องอีกครั้ง";
					    return false;
				    }
				}else{
					$phoneno = sprintf("%010d",$resdata[0]);
					$smscode = sprintf("%010d",$resdata[1]);
					$prize = $resdata[2];
					if(in_array($prize, $this->data['allowgift'])){
						$lucky_status="pass";
						$prize_count[$prize]++;
						$lucky_issue=NULL;
					}else{
						$lucky_status="error";
						$lucky_issue="ของรางวัลไม่ถูกต้อง ($prize)";
					}
					
					$this->db->set("lucky_phoneno",$phoneno);
					$this->db->set("lucky_smscode",$smscode);
					$this->db->set("lucky_prize",$prize);
					$this->db->set("lucky_date",$key_date);
					$this->db->set("lucky_status",$lucky_status);
					$this->db->set("lucky_issue",$lucky_issue);
					$this->db->insert("lucky_list_tmp");
				}
		    }
		    
		}
		foreach($this->data['allowgift'] as $p){
			if($prize_count[$p] <> $this->data['allowgiftqty'][$p]){
				$this->data['error_message']="จำนวนของรางวัล ($p) ไม่ครบตามจำนวน (".$this->data['allowgiftqty'][$p]." รายชื่อ ตอนนี้มี ".$prize_count[$p]." รายชื่อ)";
				$this->db->truncate("lucky_list_tmp");
				return false;
			}
		}
		unlink($fullpath);
		return true;
	}
	/**
	* To Display Date
	*
	* Convert Database Date To Display Date
	*
	* @return	string
	*/
	public function _toDisplayDate($date,$row)
	{
		$strdate_short = thai_convert_shortdate($date);
		$strdate = thai_convert_fulldate($date);
		$str = '<span class="hidden-phone">'.$strdate.'</span>';
		$str .= '<span class="hidden-desktop  hidden-tablet">'.$strdate_short.'</span>';
		return $str;
	}
	/**
	* _toDisplayOwner
	*
	* Function description
	*
	* @return	string
	*/
	public function _toDisplayOwner($currtext,$row)
	{
		$writer_id=$row['key_addby'];
		$writer_date=$row['key_addtime'];
		$userinfo = $this->admin_library->getuserinfo($writer_id);
		if(!$userinfo){ return "(ไม่รู้จัก)"; }
		$user_fullname = $userinfo['user_fullname'];
		$strdate = thai_convert_fulldate($writer_date);
		$text  = '<span><i class="icon-user-md"></i> '.$user_fullname.'</span><br />';
		$text .= '<small><span><i class="icon-clock-o"></i> '.$strdate.'</span><small>';
		return $text;
	}
	/**
	* _toDisplayStatus
	*
	* Function description
	*
	* @return	array
	*/
	public function _toDisplayStatus($currtext,$row)
	{
		if($currtext=="approved"){
			return '<span class="green"><i class="icon-check-square-o"></i> เปิดออกรางวัล</span>';
		}
		if($currtext=="nodata"){
			return '<span class="red"><i class="icon-upload"></i> ยังไม่นำเข้าข้อมูล</span>';
		}
		if($currtext=="pending"){
			return '<i class="icon-times-circle-o"></i> ยังไม่ออกรางวัล';
		}
		return '(ไม่รู้จัก)';
	}
	/**
	* _toLuckyStatus
	*
	* Function description
	*
	* @return	array
	*/
	public function _toLuckyStatus($currtext,$row)
	{
		if($currtext=="pass"){
			return '<span class="green"><i class="icon-check-square-o"></i> ข้อมูลถูกต้อง</span>';
		}
		if($currtext=="error"){
			return '<span class="red"><i class="icon-exclamation-triangle"></i> ข้อมูลผิดพลาด '.$row['lucky_issue'].'</span>';
		}
	}
	/**
	* _toLuckyPrize
	*
	* Function description
	*
	* @return	array
	*/
	public function _toLuckyPrize($currtext,$row)
	{
		if($currtext=="gold"){
			return 'ทองคำมูลค่า 5,000 บาท';
		}
		if($currtext=="giftcard"){
			return '7 Gift Card มูลค่า 999 บาท';
		}
	}
	public function valid_file()
	{
		$allow_type = func_get_arg(1);
		if($allow_type){
			$allow_type = explode(',', $allow_type);
		}
		if(!trim(@$_FILES['file_import']['name'])){
			$this->form_validation->set_message("valid_file","คุณยังไม่เลือก%s");
			return false;
		}
		$fileinf = pathinfo($_FILES['file_import']['name']);
		$extension = @$fileinf['extension'];
		
		if(!in_array($extension,$allow_type)){
			$this->form_validation->set_message("valid_file","คุณยังไม่เลือกไฟล์ในสกุลที่ถูกต้องสำหรับ%s ");
			return false;
		}
		return true;
	}
}

/* End of file import_luckydraw.php */
/* Location: ./application/controllers/import_luckydraw.php */