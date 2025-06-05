<?php
class Filemanager extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');	
		$this->admin_library->forceLogin();
	}
	function index()
	{
		
	}
	function upload()
	{
		$callback = ($_GET['CKEditorFuncNum']); 
		$uploadpath = realpath('').'/public/core/uploaded/editor';
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name']  = true;
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('upload'))
		{
			$error = $this->upload->display_errors();
			echo '<script type="text/javascript">alert("'.$error.'"); window.parent.CKEDITOR.tools.callFunction('.$callback.', "","");</script>';
		}
		else
		{
			$data = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image']	= $data['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 800;
			$config['height']	= 800;
			$this->load->library('image_lib', $config); 
			if($this->image_lib->resize()){
				$image_url = base_url('public/core/uploaded/editor/'.$data['file_name']);
				echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$image_url .'","");</script>';
			}else{
				$error = $this->image_lib->display_errors();
			echo '<script type="text/javascript">alert("'.$error.'"); window.parent.CKEDITOR.tools.callFunction('.$callback.', "","");</script>';
			}
		}
		
	}
}  