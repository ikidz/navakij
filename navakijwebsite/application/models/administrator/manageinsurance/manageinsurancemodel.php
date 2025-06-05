<?php
class Manageinsurancemodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function get_categoryinfo_byid( $categoryid=0 ){
		$query = $this->db->where('insurance_category_id', $categoryid)
							->get('insurance_categories')
							->row_array();
		return $query;
	}
	
	public function get_insurancelists($categoryid=0, $limit=10, $offset=0){
		if( $categoryid > 0 ){
			$query = $this->db->where('insurance_category_id', $categoryid);
		}else{
			$query = $this->db->where('insurance_category_id !=', 0);
		}
		$query = $this->db->where('insurance_status !=','discard')
							->order_by('insurance_createdtime','desc')
							->get('insurance', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_insurancelists($categoryid=0){
		if( $categoryid > 0 ){
			$query = $this->db->where('insurance_category_id', $categoryid);
		}else{
			$query = $this->db->where('insurance_category_id !=', 0);
		}
		$query = $this->db->where('insurance_status !=','discard')
							->count_all_results('insurance');
		return $query;
	}
	
	public function get_insuranceinfo_byid($insuranceid=0){
		$query = $this->db->where('insurance_id', $insuranceid)
							->get('insurance')->row_array();
		return $query;
	}

	public function get_aboutus(){
		$query = $this->db->where('insurance_id', 0)
							->where('insurance_category_id', 0)
							->get('insurance')
							->row_array();
		return $query;
	}
	
	public function create( $categoryid=0 ){
		$message = array();
		$category = $this->get_categoryinfo_byid( $categoryid );
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
		
		if( $_FILES['insurance_image']['tmp_name'] != '' ){
			$image = $this->uploadmodel->do_upload($config, 'insurance_image', $_FILES['insurance_image']);
			if( !$image || !is_file( realpath( 'public/core/uploaded/insurance/'.$image ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลักได้');
			}
		}
		/* Upload - End */

		/* Upload (Thumb) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/thumb';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
		
		if( $_FILES['insurance_thumbnail']['tmp_name'] != '' ){
			$thumb = $this->uploadmodel->do_upload($config, 'insurance_thumbnail', $_FILES['insurance_thumbnail']);
			if( !$thumb || !is_file( realpath( 'public/core/uploaded/insurance/thumb/'.$thumb ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพปกได้');
			}
		}
		/* Upload (Thumb) - End */

		/* Upload (files) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/file';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
		$config['max_size'] = 10240;
		$config['encrypt_name'] = true;
		
			/* File 1 - Start */
			if( $_FILES['insurance_file_th']['tmp_name'] != '' ){
				$file_th = $this->uploadmodel->do_upload($config, 'insurance_file_th', $_FILES['insurance_file_th']);
				if( !$file_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			if( $_FILES['insurance_file_en']['tmp_name'] != '' ){
				$file_en = $this->uploadmodel->do_upload($config, 'insurance_file_en', $_FILES['insurance_file_en']);
				if( !$file_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			/* File 1 - End */

			/* File 2 - Start */
			if( $_FILES['insurance_file_2_th']['tmp_name'] != '' ){
				$file_2_th = $this->uploadmodel->do_upload($config, 'insurance_file_2_th', $_FILES['insurance_file_2_th']);
				if( !$file_2_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_2_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			if( $_FILES['insurance_file_2_en']['tmp_name'] != '' ){
				$file_2_en = $this->uploadmodel->do_upload($config, 'insurance_file_2_en', $_FILES['insurance_file_2_en']);
				if( !$file_2_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_2_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			/* File 2 - End */

			/* File 3 - Start */
			if( $_FILES['insurance_file_3_th']['tmp_name'] != '' ){
				$file_3_th = $this->uploadmodel->do_upload($config, 'insurance_file_3_th', $_FILES['insurance_file_3_th']);
				if( !$file_3_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_3_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			if( $_FILES['insurance_file_3_en']['tmp_name'] != '' ){
				$file_3_en = $this->uploadmodel->do_upload($config, 'insurance_file_3_en', $_FILES['insurance_file_3_en']);
				if( !$file_3_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_3_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			/* File 3 - End */

			/* File 4 - Start */
			if( $_FILES['insurance_file_4_th']['tmp_name'] != '' ){
				$file_4_th = $this->uploadmodel->do_upload($config, 'insurance_file_4_th', $_FILES['insurance_file_4_th']);
				if( !$file_4_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_4_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			if( $_FILES['insurance_file_4_en']['tmp_name'] != '' ){
				$file_4_en = $this->uploadmodel->do_upload($config, 'insurance_file_4_en', $_FILES['insurance_file_4_en']);
				if( !$file_4_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_4_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}
			/* File 4 - End */
		/* Upload (files) - End */

		/* Upload (Facebook) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/facebook';
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
		
		if( $_FILES['insurance_facebook']['tmp_name'] != '' ){
			$facebook = $this->uploadmodel->do_upload($config, 'insurance_facebook', $_FILES['insurance_facebook']);
			if( !$facebook || !is_file( realpath( 'public/core/uploaded/insurance/facebook/'.$facebook ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพเฟสบุคได้');
			}
		}
		/* Upload (Facebook) - End */

		/* Generate META URL - Start */
        $metaURL = $this->input->post('insurance_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'insurance', 'insurance_' );
        /* Generate META URL - End */

		/* Check exists highlight in same category - Start */
		if( $this->input->post('insurance_highlight') == 1 ){
			$exists = $this->db->where('insurance_category_id', $category['category_id'])
					->where('insurance_highlight', 1)
					->where('insurance_status !=','discard')
					->get('insurance')
					->result_array();
			if( isset( $exists ) && count( $exists ) ){
				foreach( $exists as $item ){
					$this->db->set('insurance_highlight', 0);
					$this->db->where('insurance_id', $item['insurance_id']);
					$this->db->update('insurance');
				}
			}
		}
		/* Check exists highlight in same category - End */
		
		$this->db->set('insurance_thumbnail', $thumb);
		$this->db->set('insurance_image', $image);
		$this->db->set('insurance_file_th', $file_th);
		$this->db->set('insurance_file_en', $file_en);
		$this->db->set('insurance_file_2_th', $file_2_th);
		$this->db->set('insurance_file_2_en', $file_2_en);
		$this->db->set('insurance_file_3_th', $file_3_th);
		$this->db->set('insurance_file_3_en', $file_3_en);
		$this->db->set('insurance_file_3_label_th', $this->input->post('insurance_file_3_label_th'));
		$this->db->set('insurance_file_3_label_en', $this->input->post('insurance_file_3_label_en'));
		$this->db->set('insurance_file_4_th', $file_4_th);
		$this->db->set('insurance_file_4_en', $file_4_en);
		$this->db->set('insurance_file_4_label_th', $this->input->post('insurance_file_4_label_th'));
		$this->db->set('insurance_file_4_label_en', $this->input->post('insurance_file_4_label_en'));
		$this->db->set('insurance_facebook_image', $facebook);
		$this->db->set('insurance_category_id', $category['insurance_category_id']);
		$this->db->set('insurance_title_th', $this->input->post('insurance_title_th'));
		$this->db->set('insurance_title_en', $this->input->post('insurance_title_en'));
		$this->db->set('insurance_sdesc_th', $this->input->post('insurance_sdesc_th'));
		$this->db->set('insurance_sdesc_en', $this->input->post('insurance_sdesc_en'));
		$this->db->set('insurance_desc_th', $this->input->post('insurance_desc_th'));
		$this->db->set('insurance_desc_en', $this->input->post('insurance_desc_en'));
		$this->db->set('insurance_start_date', date("Y-m-d", strtotime( $this->input->post('insurance_start_date') )));
		$this->db->set('insurance_end_date', ( $this->input->post('insurance_end_date') != '' ? date("Y-m-d", strtotime( $this->input->post('insurance_end_date') )) : null));
		$this->db->set('price', $this->input->post('price'));
		$this->db->set('sum_insured', $this->input->post('sum_insured'));
		$this->db->set('insurance_meta_title', $this->input->post('insurance_meta_title'));
		$this->db->set('insurance_meta_description', $this->input->post('insurance_meta_description'));
		$this->db->set('insurance_meta_keyword', $this->input->post('insurance_meta_keyword'));
		$this->db->set('insurance_meta_url', $category['insurance_category_meta_url'].'/'.$validatedURL);
		$this->db->set('insurance_contact_form', $this->input->post('insurance_contact_form'));
		$this->db->set('insurance_highlight', $this->input->post('insurance_highlight'));
		$this->db->set('insurance_status', $this->input->post('insurance_status'));
		$this->db->set('insurance_createdtime', date("Y-m-d H:i:s"));
		$this->db->set('insurance_createdip', $this->input->ip_address());
		$this->db->insert('insurance');

		$insurance_id = $this->db->insert_id();
		foreach($this->get_icons_list() as $key => $rs_icon){
			
			if($this->input->post('insurance_icons_'.$key) == 'yes')
			{
				$this->db->set('icon_id', $rs_icon['icon_id']);
				$this->db->set('insurance_id', $insurance_id);
				$this->db->set('insurance_label_th', $this->input->post('insurance_label_th_'.$key));
				$this->db->set('insurance_label_en', $this->input->post('insurance_label_en_'.$key));
				$this->db->insert('insurance_icons');
			}
		}
		
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}
	
	public function update($insuranceid=0){
		$message = array();
		$info = $this->get_insuranceinfo_byid($insuranceid);
		
		/* Upload - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
					
		$image = $this->uploadmodel->edit_upload($config, 'insurance_image', $_FILES['insurance_image'], $info['insurance_image']);
		if( $_FILES['insurance_image']['tmp_name'] != '' ){
			if( !$image || !is_file( realpath( 'public/core/uploaded/insurance/'.$image ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพหลักได้');
			}
		}
		/* Upload - End */

		/* Upload (Thumb) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/thumb';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg';
		$config['max_size'] = 1024;
		$config['encrypt_name'] = true;
					
		$thumb = $this->uploadmodel->edit_upload($config, 'insurance_thumbnail', $_FILES['insurance_thumbnail'], $info['insurance_thumbnail']);
		if( $_FILES['insurance_thumbnail']['tmp_name'] != '' ){
			if( !$thumb || !is_file( realpath( 'public/core/uploaded/insurance/thumb/'.$thumb ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพปกได้');
			}
		}
		/* Upload (Thumb) - End */

		/* Upload (files) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/file';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
		$config['max_size'] = 10240;
		$config['encrypt_name'] = true;
		
			/* File 1 - Start */
			if( $_FILES['insurance_file_th']['tmp_name'] != '' ){
				$file_th = $this->uploadmodel->edit_upload($config, 'insurance_file_th', $_FILES['insurance_file_th'], $info['insurance_file_th']);
				if( !$file_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_th = $info['insurance_file_th'];
			}
			if( $_FILES['insurance_file_en']['tmp_name'] != '' ){
				$file_en = $this->uploadmodel->edit_upload($config, 'insurance_file_en', $_FILES['insurance_file_en'], $info['insurance_file_en']);
				if( !$file_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_en = $info['insurance_file_en'];
			}
			/* File 1 - End */

			/* File 2 - Start */
			if( $_FILES['insurance_file_2_th']['tmp_name'] != '' ){
				$file_2_th = $this->uploadmodel->edit_upload($config, 'insurance_file_2_th', $_FILES['insurance_file_2_th'], $info['insurance_file_2_th']);
				if( !$file_2_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_2_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_2_th = $info['insurance_file_2_th'];
			}
			if( $_FILES['insurance_file_2_en']['tmp_name'] != '' ){
				$file_2_en = $this->uploadmodel->edit_upload($config, 'insurance_file_2_en', $_FILES['insurance_file_2_en'], $info['insurance_file_2_en']);
				if( !$file_2_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_2_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_2_en = $info['insurance_file_2_en'];
			}
			/* File 2 - End */

			/* File 3 - Start */
			if( $_FILES['insurance_file_3_th']['tmp_name'] != '' ){
				$file_3_th = $this->uploadmodel->edit_upload($config, 'insurance_file_3_th', $_FILES['insurance_file_3_th'], $info['insurance_file_3_th']);
				if( !$file_3_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_3_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_3_th = $info['insurance_file_3_th'];
			}
			if( $_FILES['insurance_file_3_en']['tmp_name'] != '' ){
				$file_3_en = $this->uploadmodel->edit_upload($config, 'insurance_file_3_en', $_FILES['insurance_file_3_en'], $info['insurance_file_3_en']);
				if( !$file_3_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_3_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_3_en = $info['insurance_file_3_en'];
			}
			/* File 3 - End */

			/* File 4 - Start */
			if( $_FILES['insurance_file_4_th']['tmp_name'] != '' ){
				$file_4_th = $this->uploadmodel->edit_upload($config, 'insurance_file_4_th', $_FILES['insurance_file_4_th'], $info['insurance_file_4_th']);
				if( !$file_4_th || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_4_th ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_4_th = $info['insurance_file_4_th'];
			}
			if( $_FILES['insurance_file_4_en']['tmp_name'] != '' ){
				$file_4_en = $this->uploadmodel->edit_upload($config, 'insurance_file_4_en', $_FILES['insurance_file_4_en'], $info['insurance_file_4_en']);
				if( !$file_4_en || !is_file( realpath( 'public/core/uploaded/insurance/file/'.$file_4_en ) ) ){
					$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดไฟล์ได้');
				}
			}else{
				$file_4_en = $info['insurance_file_4_en'];
			}
			/* File 4 - End */
		/* Upload (files) - End */

		/* Upload (Facebook) - Start */
		$uploadpath = realpath('').'/public/core/uploaded/insurance/facebook';
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
					
		$facebook = $this->uploadmodel->edit_upload($config, 'insurance_facebook', $_FILES['insurance_facebook'], $info['insurance_facebook_image']);
		if( $_FILES['insurance_facebook']['tmp_name'] != '' ){
			if( !$facebook || !is_file( realpath( 'public/core/uploaded/insurance/facebook/'.$facebook ) ) ){
				$this->session->set_flashdata('message-warning','ไม่สามารถอัพโหลดรูปภาพเฟสบุคได้');
			}
		}
		/* Upload (Facebook) - End */

		/* Check exists highlight in same category - Start */
		if( $this->input->post('insurance_highlight') == 1 ){
			$exists = $this->db->where('insurance_category_id', $info['insurance_category_id'])
					->where('insurance_highlight', 1)
					->where('insurance_status !=','discard')
					->get('insurance')
					->result_array();
			if( isset( $exists ) && count( $exists ) ){
				foreach( $exists as $item ){
					$this->db->set('insurance_highlight', 0);
					$this->db->where('insurance_id', $item['insurance_id']);
					$this->db->update('insurance');
				}
			}
		}
		/* Check exists highlight in same category - End */

		/* Generate META URL - Start */
        $metaURL = $this->input->post('insurance_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'insurance', 'insurance_', $info['insurance_id'] );
        /* Generate META URL - End */

		// exit( $file_2 );
		
		$this->db->set('insurance_thumbnail', $thumb);
		$this->db->set('insurance_image', $image);
		$this->db->set('insurance_file_th', ( $this->input->post('insurance_file_th_delete') == 1 ? null : $file_th ));
		$this->db->set('insurance_file_en', ( $this->input->post('insurance_file_en_delete') == 1 ? null : $file_en ));
		$this->db->set('insurance_file_2_th', ( $this->input->post('insurance_file_2_th_delete') == 1 ? null : $file_2_th ));
		$this->db->set('insurance_file_2_en', ( $this->input->post('insurance_file_2_en_delete') == 1 ? null : $file_2_en ));
		$this->db->set('insurance_file_3_th', ( $this->input->post('insurance_file_3_th_delete') == 1 ? null : $file_3_th ));
		$this->db->set('insurance_file_3_en', ( $this->input->post('insurance_file_3_en_delete') == 1 ? null : $file_3_en ));
		$this->db->set('insurance_file_3_label_th', ( $this->input->post('insurance_file_3_delete') == 1 ? null : $this->input->post('insurance_file_3_label_th') ));
		$this->db->set('insurance_file_3_label_en', ( $this->input->post('insurance_file_3_delete') == 1 ? null : $this->input->post('insurance_file_3_label_en') ));
		$this->db->set('insurance_file_4_th', ( $this->input->post('insurance_file_4_th_delete') == 1 ? null : $file_4_th ));
		$this->db->set('insurance_file_4_en', ( $this->input->post('insurance_file_4_en_delete') == 1 ? null : $file_4_en ));
		$this->db->set('insurance_file_4_label_th', ( $this->input->post('insurance_file_4_delete') == 1 ? null : $this->input->post('insurance_file_4_label_th') ));
		$this->db->set('insurance_file_4_label_en', ( $this->input->post('insurance_file_4_delete') == 1 ? null : $this->input->post('insurance_file_4_label_en') ));
		$this->db->set('insurance_facebook_image', $facebook);
		$this->db->set('insurance_title_th', $this->input->post('insurance_title_th'));
		$this->db->set('insurance_title_en', $this->input->post('insurance_title_en'));
		$this->db->set('insurance_sdesc_th', $this->input->post('insurance_sdesc_th'));
		$this->db->set('insurance_sdesc_en', $this->input->post('insurance_sdesc_en'));
		$this->db->set('insurance_desc_th', $this->input->post('insurance_desc_th'));
		$this->db->set('insurance_desc_en', $this->input->post('insurance_desc_en'));
		$this->db->set('price', $this->input->post('price'));
		$this->db->set('sum_insured', $this->input->post('sum_insured'));
		$this->db->set('insurance_meta_title', $this->input->post('insurance_meta_title'));
		$this->db->set('insurance_meta_description', $this->input->post('insurance_meta_description'));
		$this->db->set('insurance_meta_keyword', $this->input->post('insurance_meta_keyword'));
		$this->db->set('insurance_meta_url', $validatedURL);
		$this->db->set('insurance_start_date', date("Y-m-d", strtotime( $this->input->post('insurance_start_date') )));
		$this->db->set('insurance_end_date', ( $this->input->post('insurance_end_date') != '' ? date("Y-m-d", strtotime( $this->input->post('insurance_end_date') )) : null));
		$this->db->set('insurance_contact_form', $this->input->post('insurance_contact_form'));
		$this->db->set('insurance_highlight', $this->input->post('insurance_highlight'));
		$this->db->set('insurance_status', $this->input->post('insurance_status'));
		$this->db->set('insurance_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('insurance_updatedip', $this->input->ip_address());
		$this->db->where('insurance_id', $info['insurance_id']);
		$this->db->update('insurance');

		#########insurance icon#############
		$del = 	$this->db->where('insurance_id', $info['insurance_id']);
				$this->db->delete('insurance_icons');

		foreach($this->get_icons_list() as $key => $rs_icon){
			
			if($this->input->post('insurance_icons_'.$key) == 'yes')
			{
				$this->db->set('icon_id', $rs_icon['icon_id']);
				$this->db->set('insurance_id', $info['insurance_id']);
				$this->db->set('insurance_label_th', $this->input->post('insurance_label_th_'.$key));
				$this->db->set('insurance_label_en', $this->input->post('insurance_label_en_'.$key));
				$this->db->insert('insurance_icons');
			}
		}
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}

	
	
	public function setStatus($setto='approved', $insuranceid=0){
		$message = array();
		
		$this->db->set('insurance_status', $setto);
		$this->db->set('insurance_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('insurance_updatedip', $this->input->ip_address());
		$this->db->where('insurance_id', $insuranceid);
		$this->db->update('insurance');
		
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


	public function get_icons_list( ){

        $query = $this->db->where('icon_status !=','discard')
                            ->order_by('icon_order','asc')
                            ->get('icons')
                            ->result_array();
        return $query;
	}
	
	public function get_insurance_icon($insurance_id)
	{
		$query = $this->db->select('icon_id')
							->where('insurance_id',$insurance_id)
                            ->get('insurance_icons')
							->result_array();
		$tmp = array();
		foreach( $query as $rs)
		{
			//echo $rs['icon_id'];
			array_push($tmp, $rs['icon_id']);
		}	
		
        return $tmp;
	}

	public function get_insurance_icon_info( $insurance_id=0, $iconid=0 ){
		$query = $this->db->where('icon_id', $iconid)
							->where('insurance_id', $insurance_id )
							->limit(1)
							->get('insurance_icons')
							->row_array();
		return $query;
	}

	public function set_contactform_status( $status='active', $insuranceid=0 ){
		$message = array();
		$info = $this->get_insuranceinfo_byid( $insuranceid );

		if( isset( $info ) && count( $info ) > 0 ){
			$indicator = 0;
			if( $status == 'active' ){
				$indicator = 1;
			}
			$this->db->set('insurance_contact_form', $indicator);
			$this->db->set('insurance_updatedtime', date("Y-m-d H:i:s"));
			$this->db->set('insurance_updatedip', $this->input->ip_address());
			$this->db->where('insurance_id', $info['insurance_id']);
			$this->db->update('insurance');

			$message = array(
				'status' => 'message-success',
				'text' => 'บันทึกข้อมูลการตั้งค่าสำเร็จ'
			);
		}else{
			$message = array(
				'status' => 'message-warning',
				'text' => 'ไม่พบข้อมูลประกันภัย'
			);
		}

		return $message;
	}

	public function set_highlight_status( $status='active', $insuranceid=0 ){
		$message = array();
		$info = $this->get_insuranceinfo_byid( $insuranceid );

		if( isset( $info ) && count( $info ) > 0 ){
			$indicator = 0;
			if( $status == 'active' ){
				$indicator = 1;

				/* Check exists highlight in same category - Start */
				$exists = $this->db->where('insurance_category_id', $info['insurance_category_id'])
									->where('insurance_highlight', 1)
									->where('insurance_status !=','discard')
									->get('insurance')
									->result_array();
				if( isset( $exists ) && count( $exists ) ){
					foreach( $exists as $item ){
						$this->db->set('insurance_highlight', 0);
						$this->db->where('insurance_id', $item['insurance_id']);
						$this->db->update('insurance');
					}
				}
				/* Check exists highlight in same category - End */

			}
			$this->db->set('insurance_highlight', $indicator);
			$this->db->set('insurance_updatedtime', date("Y-m-d H:i:s"));
			$this->db->set('insurance_updatedip', $this->input->ip_address());
			$this->db->where('insurance_id', $info['insurance_id']);
			$this->db->update('insurance');

			$message = array(
				'status' => 'message-success',
				'text' => 'บันทึกข้อมูลการตั้งค่าสำเร็จ'
			);
		}else{
			$message = array(
				'status' => 'message-warning',
				'text' => 'ไม่พบข้อมูลประกันภัย'
			);
		}

		return $message;
	}
}
?>