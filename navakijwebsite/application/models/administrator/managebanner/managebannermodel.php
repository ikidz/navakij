<?php
class Managebannermodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function get_categories(){
		$query = $this->db->where('category_status !=','discard')
							->order_by('category_order','asc')
							->get('categories')
							->result_array();
		return $query;
	}
	
	public function get_articles_bycategoryid( $categoryid=0 ){
		$query = $this->db->where('category_id', $categoryid)
							->where('article_status !=','discard')
							->order_by('article_createdtime','desc')
							->get('articles')
							->result_array();
		return $query;
	}
	
	public function get_banners($limit=10, $offset=0){
		$query = $this->db->where('banner_status !=','discard')
							->order_by('banner_order','asc')
							->get('banners', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_banners(){
		$query = $this->db->where('banner_status !=','discard')
							->count_all_results('banners');
		return $query;
	}
	
	public function get_bannerinfo_byid($bannerid=0){
		$query = $this->db->where('banner_id', $bannerid)
							->get('banners')->row_array();
		return $query;
	}
	
	public function get_bannerinfo_byorder($order){
		$query = $this->db->where('banner_status !=','discard')
							->where('banner_order', $order)
							->order_by('banner_createdtime','desc')
							->limit(1)
							->get('banners')->row_array();
		return $query;
	}
	
	public function create(){
		
		/* Upload Desktop - Start */
		$uploadpath = realpath('').'/public/core/uploaded/banner';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		// $config['max_width'] = 1920;
		// $config['min_width'] = 1920;
		// $config['max_height'] = 500;
		// $config['min_height'] = 500;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->do_upload($config, 'banner_image', $_FILES['banner_image']);
		/* Upload Desktop - End */

		/* Upload Mobile - Start */
		$mobilePath = $uploadpath.'/mobile';
		if(is_dir($mobilePath)===false){
			mkdir($mobilePath, 0777);
			chmod($mobilePath, 0777);
		}
					
		$mobileConfig['upload_path'] = $mobilePath;
		$mobileConfig['allowed_types'] = 'jpg|png|gif';
		$mobileConfig['max_size'] = 2048;
		// $mobileConfig['max_width'] = 640;
		// $mobileConfig['min_width'] = 640;
		// $mobileConfig['max_height'] = 709;
		// $mobileConfig['min_height'] = 709;
		$mobileConfig['encrypt_name'] = true;
					
		$fileMobile = $this->uploadmodel->do_upload($mobileConfig, 'banner_image_mobile', $_FILES['banner_image_mobile']);
		/* Upload Mobile - End */
		
		$total = $this->managebannermodel->count_banners();
		$neworder = 0;
		
		$this->db->set('banner_image', $file);
		$this->db->set('banner_image_mobile', $fileMobile);
		$this->db->set('banner_title_th', $this->input->post('banner_title_th'));
		$this->db->set('banner_title_en', $this->input->post('banner_title_en'));
		$this->db->set('banner_caption_th', $this->input->post('banner_caption_th'));
		$this->db->set('banner_caption_en', $this->input->post('banner_caption_en'));
		$this->db->set('article_id', $this->input->post('article_id'));
		if( $this->input->post('article_id') == 9999 ){
			$this->db->set('banner_url', $this->input->post('banner_url'));
		}
		$this->db->set('banner_start_date', date("Y-m-d", strtotime( $this->input->post('banner_start_date') )));
		$this->db->set('banner_end_date', ( $this->input->post('banner_end_date') != '' ? date("Y-m-d", strtotime( $this->input->post('banner_end_date') )) : null ));
		$this->db->set('banner_order', $neworder);
		$this->db->set('banner_status', $this->input->post('banner_status'));
		$this->db->set('banner_createdtime', date("Y-m-d H:i:s"));
		$this->db->set('banner_createdip', $this->input->ip_address());
		$this->db->insert('banners', $aInsert);

		$this->reorder();
		
		$message = array();
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		if(!$file){
			$this->session->set_flashdata('message-warning','ยังไม่ได้อัพโหลดรูปแบนเนอร์');
		}
		
		return $message;
		
	}
	
	public function update($bannerid=0){
		$info = $this->get_bannerinfo_byid($bannerid);
		
		/* Upload Desktop - Start */
		$uploadpath = realpath('').'/public/core/uploaded/banner';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['max_width'] = 1920;
		$config['min_width'] = 1920;
		$config['max_height'] = 915;
		$config['min_height'] = 915;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->edit_upload($config, 'banner_image', $_FILES['banner_image'], $info['banner_image']);
		/* Upload Desktop - End */

		/* Upload Mobile - Start */
		$mobilePath = realpath('').'/public/core/uploaded/banner/mobile';
		if(is_dir($mobilePath)===false){
			mkdir($mobilePath, 0777);
			chmod($mobilePath, 0777);
		}
					
		$mobileConfig['upload_path'] = $mobilePath;
		$mobileConfig['allowed_types'] = 'jpg|png|gif';
		$mobileConfig['max_size'] = 2048;
		$mobileConfig['max_width'] = 640;
		$mobileConfig['min_width'] = 640;
		$mobileConfig['max_height'] = 709;
		$mobileConfig['min_height'] = 709;
		$mobileConfig['encrypt_name'] = true;
					
		$fileMobile = $this->uploadmodel->edit_upload($mobileConfig, 'banner_image_mobile', $_FILES['banner_image_mobile'], $info['banner_image_mobile']);
		/* Upload Mobile - End */
		
		$this->db->set('banner_image', $file);
		$this->db->set('banner_image_mobile', $fileMobile);
		$this->db->set('banner_title_th', $this->input->post('banner_title_th'));
		$this->db->set('banner_title_en', $this->input->post('banner_title_en'));
		$this->db->set('banner_caption_th', $this->input->post('banner_caption_th'));
		$this->db->set('banner_caption_en', $this->input->post('banner_caption_en'));
		$this->db->set('article_id', $this->input->post('article_id'));
		if( $this->input->post('article_id') == 9999 ){
			$this->db->set('banner_url', $this->input->post('banner_url'));
		}else{
			$this->db->set('banner_url', '');
		}
		$this->db->set('banner_start_date', date("Y-m-d", strtotime( $this->input->post('banner_start_date') )));
		$this->db->set('banner_end_date', ( $this->input->post('banner_end_date') != '' ? date("Y-m-d", strtotime( $this->input->post('banner_end_date') )) : null ));
		$this->db->set('banner_status', $this->input->post('banner_status'));
		$this->db->set('banner_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('banner_updatedip', $this->input->ip_address());
		$this->db->where('banner_id', $info['banner_id']);
		$this->db->update('banners', $aUpdate);
		
		$message = array();
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		if(!$file){
			$this->session->set_flashdata('message-warning','ยังไม่ได้อัพโหลดรูปแบนเนอร์');
		}
		
		return $message;
	}
	
	public function setStatus($setto='discard', $bannerid=0){
		
		$this->db->set('banner_status', $setto);
		$this->db->set('banner_updatedtime',date("Y-m-d H:i:s"));
		$this->db->set('banner_updatedip', $this->input->ip_address());
		$this->db->where('banner_id', $bannerid);
		$this->db->update('banners');
		
		$message = array();
		$message['status'] = 'message-success';
		
		if($setto=='discard'){
			$this->reorder();
			$message['text'] = 'ลบข้อมูลสำเร็จ';
		}else{
			$message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
		}
		
		return $message;
		
	}
	
	public function reorder(){
		$bannerlist = $this->get_banners();
		if($bannerlist){
			$i=0;
			foreach($bannerlist as $banner){
				$i++;
				$this->db->set('banner_order', $i);
				$this->db->where('banner_id', $banner['banner_id']);
				$this->db->update('banners');
			}
		}
	}
	
	public function setOrder($movement='up', $bannerid=0){
		$info = $this->get_bannerinfo_byid($bannerid);
		$total = $this->count_banners();
		$message = array();
		
		if($movement=='up'){
			$neworder = intval($info['banner_order']-1);
			if($neworder<=0){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับบนสุดไม่สามารถเลื่อนขึ้นได้';
			}else{
				
				$exists = $this->get_bannerinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['banner_order']+1);
					$this->db->set('banner_order', $exists_neworder);
					$this->db->where('banner_id', $exists['banner_id']);
					$this->db->update('banners');
				}
				
				$this->db->set('banner_order', $neworder);
				$this->db->where('banner_id', $info['banner_id']);
				$this->db->update('banners');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else if($movement=='down'){
			$neworder = intval($info['banner_order']+1);
			if($neworder>$total){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับล่างสุดไม่สามารถเลื่อนลงได้';
			}else{
				
				$exists = $this->get_bannerinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['banner_order']-1);
					$this->db->set('banner_order', $exists_neworder);
					$this->db->where('banner_id', $exists['banner_id']);
					$this->db->update('banners');
				}
				
				$this->db->set('banner_order', $neworder);
				$this->db->where('banner_id', $info['banner_id']);
				$this->db->update('banners');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else{
			$message['status'] = 'message-error';
			$message['text'] = 'ไม่สามารถบันทึกข้อมูลการจัดลำดับได้';
		}

		return $message;
	}
}
?>