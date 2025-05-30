<?php
class MY_Form_validation extends CI_Form_validation {
	public function __construct()
    {
        parent::__construct();
    }
    public function valid_file()
	{
		$allow_type = func_get_arg(1);
		if($allow_type){
			$allow_type = explode(',', $allow_type);
		}
		if(!isset($_FILES['file_import'])){
			$this->form_validation->set_message("valid_excel","คุณยังไม่เลือกไฟล์สำหรับ %s");
			return false;
		}
		$fileinf = pathinfo($_FILES['file_import']['name']);
		$extension = @$fileinf['extension'];
		
		if(!in_array($extension,$allow_type)){
			$this->form_validation->set_message("valid_excel","คุณยังไม่เลือกไฟล์ในสกุลที่ถูกต้องสำหรับ %s (รองรับไฟล์สกุล ".func_get_arg(1)." เท่านั้น)");
			return false;
		}
		return true;
	}
}