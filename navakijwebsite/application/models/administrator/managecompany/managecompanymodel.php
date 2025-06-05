<?php
class Managecompanymodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	public function get_companyinfo(){
		$query = $this->db->where('company_id', 1)
							->get('system_company')->row_array();
		return $query;
	}
	
	public function update(){
		
		$message = array();
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/system_company_logo';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->do_upload($config, 'company_logo', $_FILES['company_logo']);
		/* Upload - End */
		
		if( $file && is_file( UPLOAD_PATH.'/system_company_logo/'.$file ) ){
			$this->db->set('company_logo', $file);
		}
		
		$this->db->set( 'company_name', $this->input->post('company_name') );
		$this->db->where( 'company_id', 1 );
		$this->db->update( 'system_company' );
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
		
	}
}
?>