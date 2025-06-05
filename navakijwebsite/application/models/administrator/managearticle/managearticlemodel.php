<?php
class Managearticlemodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function get_categoryinfo_byid( $categoryid=0 ){
		$query = $this->db->where('category_id', $categoryid)
							->get('categories')
							->row_array();
		return $query;
	}
	
	public function get_articlelists($categoryid=0, $limit=10, $offset=0){
		if( $categoryid > 0 ){
			$query = $this->db->where('category_id', $categoryid);
		}else{
			$query = $this->db->where('category_id !=', 0);
		}
		$query = $this->db->where('article_status !=','discard')
							->order_by('article_createdtime','desc')
							->get('articles')->result_array();
		return $query;
	}
	
	public function count_articlelists($categoryid=0){
		if( $categoryid > 0 ){
			$query = $this->db->where('category_id', $categoryid);
		}else{
			$query = $this->db->where('category_id !=', 0);
		}
		$query = $this->db->where('article_status !=','discard')
							->count_all_results('articles');
		return $query;
	}
	
	public function get_articleinfo_byid($articleid=0){
		$query = $this->db->where('article_id', $articleid)
							->get('articles')->row_array();
		return $query;
	}

	public function get_aboutus(){
		$query = $this->db->where('article_id', 0)
							->where('category_id', 0)
							->get('articles')
							->row_array();
		return $query;
	}
	
	public function create( $categoryid=0 ){
		$message = array();
		$category = $this->get_categoryinfo_byid( $categoryid );
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
		
		if( $_FILES['article_image_th']['tmp_name'] != '' ){
			$image_th = $this->uploadmodel->do_upload($config, 'article_image_th', $_FILES['article_image_th']);
			if( !$image_th || !is_file( realpath( 'public/core/uploaded/article/'.$image_th ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลัก (ไทย) ได้');
			}
		}
		if( $_FILES['article_image_en']['tmp_name'] != '' ){
			$image_en = $this->uploadmodel->do_upload($config, 'article_image_en', $_FILES['article_image_en']);
			if( !$image_en || !is_file( realpath( 'public/core/uploaded/article/'.$image_en ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลัก (En) ได้');
			}
		}
		/* Upload - End */

		/* Upload (Thumb) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/thumb';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
		
		if( $_FILES['article_thumbnail']['tmp_name'] != '' ){
			$thumb = $this->uploadmodel->do_upload($config, 'article_thumbnail', $_FILES['article_thumbnail']);
			if( !$thumb || !is_file( realpath( 'public/core/uploaded/article/thumb/'.$thumb ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพปกได้');
			}
		}
		/* Upload (Thumb) - End */

		/* Upload (file) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/file';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 10240;
		$config['encrypt_name'] = true;
		
		if( $_FILES['article_file']['tmp_name'] != '' ){
			$file = $this->uploadmodel->do_upload($config, 'article_file', $_FILES['article_file']);
			if( !$file || !is_file( realpath( 'public/core/uploaded/article/file/'.$file ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
			}
		}
		/* Upload (file) - End */

		/* Upload (Facebook) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/facebook';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_width'] = 1200;
		$config['max_height'] = 630;
		$config['min_width'] = 1200;
		$config['min_height'] = 630;
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
		
		if( $_FILES['article_facebook']['tmp_name'] != '' ){
			$facebook = $this->uploadmodel->do_upload($config, 'article_facebook', $_FILES['article_facebook']);
			if( !$facebook || !is_file( realpath( 'public/core/uploaded/article/facebook/'.$facebook ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพเฟสบุคได้');
			}
		}
		/* Upload (Facebook) - End */

		/* Generate META URL - Start */
		$metaURL = $category['category_meta_url'].'/'.$this->input->post('article_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'articles', 'article_' );
		/* Generate META URL - End */
		
		$this->db->set('article_thumbnail', $thumb);
		$this->db->set('article_image_th', $image_th);
		$this->db->set('article_image_en', $image_en);
		$this->db->set('article_file', $file);
		$this->db->set('article_facebook_image', $facebook);
		$this->db->set('category_id', $category['category_id']);
		$this->db->set('article_title_th', $this->input->post('article_title_th'));
		$this->db->set('article_title_en', $this->input->post('article_title_en'));
		$this->db->set('article_desc_th', $this->input->post('article_desc_th'));
		$this->db->set('article_desc_en', $this->input->post('article_desc_en'));
		$this->db->set('article_postdate', date( "Y-m-d", strtotime( $this->input->post('article_postdate') ) ) );
		$this->db->set('article_start_date', date( "Y-m-d", strtotime( $this->input->post('article_start_date') ) ) );
		$this->db->set('article_end_date', ( $this->input->post('article_end_date') != '' ? date( "Y-m-d", strtotime( $this->input->post('article_end_date') ) ) : null ) );
		$this->db->set('article_meta_title', $this->input->post('article_meta_title'));
		$this->db->set('article_meta_description', $this->input->post('article_meta_description'));
		$this->db->set('article_meta_keyword', $this->input->post('article_meta_keyword'));
		$this->db->set('article_meta_url', $validatedURL);
		$this->db->set('article_status', $this->input->post('article_status'));
		$this->db->set('article_createdtime', date("Y-m-d H:i:s"));
		$this->db->set('article_createdip', $this->input->ip_address());
		$this->db->insert('articles');
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}
	
	public function update($articleid=0){
		$message = array();
		$info = $this->get_articleinfo_byid($articleid);
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
					
		$image_th = $this->uploadmodel->edit_upload($config, 'article_image_th', $_FILES['article_image_th'], $info['article_image_th']);
		if( $_FILES['article_image_th']['tmp_name'] != '' ){
			if( !$image_th || !is_file( realpath( 'public/core/uploaded/article/'.$image_th ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลัก (ไทย) ได้');
			}
		}
		$image_en = $this->uploadmodel->edit_upload($config, 'article_image_en', $_FILES['article_image_en'], $info['article_image_en']);
		if( $_FILES['article_image_en']['tmp_name'] != '' ){
			if( !$image_en || !is_file( realpath( 'public/core/uploaded/article/'.$image_en ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลัก (En) ได้');
			}
		}
		/* Upload - End */

		/* Upload (Thumb) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/thumb';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
					
		$thumb = $this->uploadmodel->edit_upload($config, 'article_thumbnail', $_FILES['article_thumbnail'], $info['article_thumbnail']);
		if( $_FILES['article_thumbnail']['tmp_name'] != '' ){
			if( !$thumb || !is_file( realpath( 'public/core/uploaded/article/thumb/'.$thumb ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพปกได้');
			}
		}
		/* Upload (Thumb) - End */

		/* Upload (file) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/file';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 10240;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->edit_upload($config, 'article_file', $_FILES['article_file'], $info['article_file']);
		if( $_FILES['article_file']['tmp_name'] != '' ){
			if( !$file || !is_file( realpath( 'public/core/uploaded/article/file/'.$file ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
			}
		}
		/* Upload (file) - End */

		/* Upload (Facebook) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article/facebook';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_width'] = 1200;
		$config['max_height'] = 630;
		$config['min_width'] = 1200;
		$config['min_height'] = 630;
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
					
		$facebook = $this->uploadmodel->edit_upload($config, 'article_facebook', $_FILES['article_facebook'], $info['article_facebook_image']);
		if( $_FILES['article_facebook']['tmp_name'] != '' ){
			if( !$facebook || !is_file( realpath( 'public/core/uploaded/article/facebook/'.$facebook ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพเฟสบุคได้');
			}
		}
		/* Upload (Facebook) - End */

		/* Generate META URL - Start */
		$metaURL = $this->input->post('article_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'articles', 'article_', $info['article_id'] );
		/* Generate META URL - End */
		
		$this->db->set('article_thumbnail', $thumb);
		$this->db->set('article_image_th', $image_th);
		$this->db->set('article_image_en', $image_en);
		$this->db->set('article_file', $file);
		$this->db->set('article_facebook_image', $facebook);
		$this->db->set('article_title_th', $this->input->post('article_title_th'));
		$this->db->set('article_title_en', $this->input->post('article_title_en'));
		$this->db->set('article_desc_th', $this->input->post('article_desc_th'));
		$this->db->set('article_desc_en', $this->input->post('article_desc_en'));
		$this->db->set('article_postdate', date( "Y-m-d", strtotime( $this->input->post('article_postdate') ) ) );
		$this->db->set('article_start_date', date( "Y-m-d", strtotime( $this->input->post('article_start_date') ) ) );
		$this->db->set('article_end_date', ( $this->input->post('article_end_date') != '' ? date( "Y-m-d", strtotime( $this->input->post('article_end_date') ) ) : null ) );
		$this->db->set('article_meta_title', $this->input->post('article_meta_title'));
		$this->db->set('article_meta_description', $this->input->post('article_meta_description'));
		$this->db->set('article_meta_keyword', $this->input->post('article_meta_keyword'));
		$this->db->set('article_meta_url', $validatedURL);
		$this->db->set('article_status', $this->input->post('article_status'));
		$this->db->set('article_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('article_updatedip', $this->input->ip_address());
		$this->db->where('article_id', $info['article_id']);
		$this->db->update('articles');
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}

	public function updateAboutUs(){
		$message = array();
		$info = $this->get_aboutus();
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/article';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
					
		$image = $this->uploadmodel->edit_upload($config, 'article_image_th', $_FILES['article_image_th'], $info['article_image_th']);
		if( !$image || !is_file( realpath( 'public/core/uploaded/article/'.$image ) ) ){
			$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลักได้');
		}
		/* Upload - End */

		/* Generate META URL - Start */
		$metaURL = $this->input->post('article_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'articles', 'article_', $info['article_id'] );
		/* Generate META URL - End */
		
		$this->db->set('article_image_th', $image);
		$this->db->set('article_title_th', $this->input->post('article_title_th'));
		$this->db->set('article_title_en', $this->input->post('article_title_en'));
		$this->db->set('article_desc_th', $this->input->post('article_desc_th'));
		$this->db->set('article_desc_en', $this->input->post('article_desc_en'));
		$this->db->set('article_meta_url', $validatedURL);
		$this->db->set('article_status', 'approved');
		$this->db->set('article_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('article_updatedip', $this->input->ip_address());
		$this->db->where('article_id', 0);
		$this->db->where('category_id', 0);
		$this->db->update('articles');
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}
	
	public function setStatus($setto='approved', $articleid=0){
		$message = array();
		
		$this->db->set('article_status', $setto);
		$this->db->set('article_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('article_updatedip', $this->input->ip_address());
		$this->db->where('article_id', $articleid);
		$this->db->update('articles');
		
		$message['status'] = 'message-success';
		if($setto=='discard'){
			$message['text'] = 'ลบข้อมูลเรียบร้อยแล้ว';
		}else{
			$message['text'] = 'แก้ไขสถานะการแสดงผลเรียบร้อยแล้ว';
		}
		
		return $message;
	}

	function get_icons()
	{
		$pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s*{\s*content:\s*"(.+)";\s+}/';
		$subject = file_get_contents(realpath('') . '/public/panel/assets/font-awesome-4.1.0/css/font-awesome.css');
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$icons = array();
		
		foreach($matches as $match){
			$icons[$match[1]] = $match[2];
		}
		
		//$icons = var_export($icons, TRUE);
		//$icons = stripslashes($icons);
		return $icons;
	}
}
?>