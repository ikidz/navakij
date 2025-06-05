<?php
class Mobile_upload extends CI_Model{
	var $_filepath = "";
	var $_uploadpath = "./public/uploads/";
	var $_error = "";
	var $_data = array();
	public function __construct()
	{
		$this->load->library('upload');
		$this->load->library('image_lib');
	}
	function data()
	{
		return $this->_data;	
	}
	function set_upload_path($path)
	{
		$this->_uploadpath = $path;
	}
	function display_errors()
	{
		return $this->_error;
	}
	function upload($filename){
		
		$config['upload_path'] = $this->_uploadpath;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['encrypt_name']  = true;
		
		if(@$_FILES[$filename]['name']==""){
			return true;
		}
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($filename)){
			$this->_error = $this->upload->display_errors(" "," ");
			//exit("error.".$this->upload->display_errors());
			return false;
		}else{
			$this->_data = $this->upload->data();
			$this->_filepath = $this->_data['full_path'];
		}
		if(!$this->auto_rotate()){
			return false;	
		}
		/*
if(!$this->auto_resize()){
			return false;	
		}
*/
		return true;
	}
	
	public function auto_rotate()
	{
		if(!is_file($this->_filepath))
		{
			$this->_error = "Cannot file image.";
			return false;
		}
		$info = pathinfo($this->_filepath);
		$allow_ext = array("jpg","jpeg","png","gif","JPG","JPEG","PNG","GIF");
		if(!in_array($info['extension'],$allow_ext)){
			$this->_error = "Extension is invalid.";
			return false;
		}
		$exif = @exif_read_data($this->_filepath, 0, true);	
		if(!$exif){
			return true;	
		}
		if(!@$exif['IFD0']){
			return true;	
		}
		if(!@$exif['IFD0']['Orientation']){
			return true;	
		}
		$Orientation = $exif['IFD0']['Orientation'];
		switch($Orientation){
			case 1:
			return $this->rotate(0);
			break;
			case 3:
			return $this->rotate(180);
			break;	
			case 6:
			return $this->rotate(270);
			break;
			case 8:
			return $this->rotate(90);
			break;
			default:
			return $this->rotate(0);
			break;
		}
	}
	function rotate($rotation_angle)
	{
		if($rotation_angle == 0){
			return true;
		}
		$config=array();
		$config['image_library'] = 'gd2';
		$config['source_image']	= $this->_filepath;
		$config['new_image']	= $this->_filepath;
		$config['rotation_angle'] = $rotation_angle;
		$this->image_lib->initialize($config); 
		if ( ! $this->image_lib->rotate())
		{
			$this->_error = $this->image_lib->display_errors(" "," ");
			return false;
		}
		return true;
	}
	function auto_resize()
	{
		if(!is_file($this->_filepath))
		{
			$this->_error = "Cannot file image.";
			return false;
		}
		$config=array();
		$config['image_library'] = 'gd2';
		$config['source_image']	= $this->_filepath;
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width']	 = 800;
		$config['height']	= 800;
		$config['quality']	= 70;
		$this->image_lib->initialize($config); 
		if ( ! $this->image_lib->resize()){
			$this->_error = $this->image_lib->display_errors(" "," ");
			return false;
		}else{
			return true;
		}
	}
}
?>