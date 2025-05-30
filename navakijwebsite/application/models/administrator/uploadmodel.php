<?php
class Uploadmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function do_upload($aConfig=array(), $fieldname='', $files){
		$this->load->library('upload');

		/* Check directory exists - Start */
		if(is_dir($aConfig['upload_path'])===FALSE){
			mkdir($aConfig['upload_path'], 0777);
			chmod($aConfig['upload_path'], 0777);
		}
		/* Check directory exists - End */
		
		/* Set config - Start */
		foreach($aConfig as $key=>$value){
			$config[$key] = $value;
		}
		
		$this->upload->initialize($config);
		/* Set config - End */
		
		if($files['tmp_name']!=''){
			if($this->upload->do_upload($fieldname)){
				$ext = $this->upload->data();
			}else{
				$ext['file_name'] = NULL;
			}
		}else{
			$ext['file_name'] = NULL;
		}
		
		return $ext['file_name'];
	}
	
	function edit_upload($aConfig=array(), $fieldname='', $files, $existsfile=''){
		$this->load->library('upload');
		
		/* Check directory exists - Start */
		if(is_dir($aConfig['upload_path'])===FALSE){
			mkdir($aConfig['upload_path'], 0777);
			chmod($aConfig['upload_path'], 0777);
		}
		/* Check directory exists - End */
		
		/* Set config - Start */
		foreach($aConfig as $key=>$value){
			$config[$key] = $value;
		}
		
		$this->upload->initialize($config);
		/* Set config - End */
		
		if($files['tmp_name']!=''){
			if($this->upload->do_upload($fieldname)){
				$files = $this->upload->data();
				if(is_file($aConfig['upload_path'].'/'.$existsfile)===TRUE){
					unlink($aConfig['upload_path'].'/'.$existsfile);
				}
			}else{
				$files['file_name'] = $existsfile;
			}
		}else{
			$files['file_name'] = $existsfile;
		}
		
		return $files['file_name'];
	}
}
?>