<?php
class Sourcefile extends CI_Controller{
	public function __construct()
	{
			parent::__construct();
			//$this->db->close();
			
			
	}
	public function index()
	{
		 $numargs = func_num_args();
		 $arg_list = func_get_args();
		 $file_path = "public/uploads";
		 
		 for ($i = 1; $i < $numargs-1; $i++) {
			$file_path .= "/";
			 $file_path .= $arg_list[$i];
		 }
		$file_path .= "/".$arg_list[$numargs-1];
		$info = pathinfo($file_path);
		if(in_array($info['extension'],array("jpeg","jpg","png"))){
			@list($width,$height) = explode("x",$arg_list[0]);
			if(!$height){
				$height=$width;	
			}
			$this->makeImageCache($width,$height,$file_path);
		}else{
			$this->download($file_path);
		}
	}
	private function makeImageCache($width,$height,$file_path)
	{
		$info = pathinfo($file_path);
		$file_paths = realpath('') . "/" . $file_path;
		
		if(!file_exists($file_paths)){
			$file_path = $info['dirname'] . "default.jpg";
		}
		if(!file_exists($file_path)){
			$file_path =  "public/uploads/default.png";
		}
		$info = pathinfo($file_path);
		$new_image = $info['dirname'] . "/thumb_{$width}x{$height}_" . $info['basename'];
		
		if(!file_exists($new_image)){
			$config['source_image']	= $file_path;
			$config['new_image']	= $new_image;
			$config['create_thumb'] = false;
			$config['maintain_ratio'] = true;
			$config['width']	 = $width;
			$config['height']	= $height;
			$this->load->library('image_lib', $config); 
			if ( ! $this->image_lib->resize())
			{
				show_error($this->image_lib->display_errors() . "<br />" . $file_path);
			}
		}
		header('Content-Type: image/' . $info['extension']);
		//header('Content-Disposition: attachment; filename="'.$info['basename'].'"'); 
		//header('Content-Transfer-Encoding: binary');	
		readfile(realpath('') . "/" . $new_image);
	}
	private function download($file_path)
	{
		$file_path = realpath('') . "/" . $file_path;
		if(!file_exists($file_path)){
			show_404();	
		}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="example.zip"'); 
		header('Content-Transfer-Encoding: binary');	
		readfile($file_path);
	}
}
?>