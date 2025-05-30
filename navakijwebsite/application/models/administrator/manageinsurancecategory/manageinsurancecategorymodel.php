<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageinsurancecategorymodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_categories( $limit=0, $offset=0 ){
        
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('insurance_category_status !=','discard')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->result_array();
        return $query;
    }

    public function count_categories(){
        $query = $this->db->where('insurance_category_status !=','discard')
                            ->count_all_results('insurance_categories');
        return $query;
    }

    public function get_insurance_categoryinfo_byid( $insurance_categoryid=0 ){
        $query = $this->db->where('insurance_category_id', $insurance_categoryid)
                            ->get('insurance_categories')
                            ->row_array();
        return $query;
    }

    public function get_insurance_categoryinfo_byorder( $order=0 ){
        $query = $this->db->where('insurance_category_order', $order )
                            ->where('insurance_category_status !=','discard')
                            ->order_by('insurance_category_createdtime','desc')
                            ->limit(1)
                            ->get('insurance_categories')
                            ->row_array();
        return $query;
    }

    public function reOrder(){
        $lists = $this->get_categories();
        if( isset( $lists ) && count( $lists ) > 0 ){
            $order=0;
            foreach( $lists as $list ){
                $order++;
                $this->db->set('insurance_category_order', $order);
                $this->db->where('insurance_category_id', $list['insurance_category_id']);
                $this->db->update('insurance_categories');
            }
        }
    }

    public function create(){
        $message = array();

        $total = $this->count_categories();
        $newOrder = 0;

        /* Generate META URL - Start */
        $metaURL = $this->input->post('insurance_category_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'insurance_categories', 'insurance_category_' );
        /* Generate META URL - End */

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/insurance_categories';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'insurance_category_banner', $_FILES['insurance_category_banner']);
        /* Upload - End */

        $this->db->set('insurance_category_banner', $file);
        $this->db->set('insurance_category_icon', $this->input->post('insurance_category_icon'));
        $this->db->set('insurance_category_banner', $file);
        $this->db->set('insurance_category_title_th', $this->input->post('insurance_category_title_th'));
        $this->db->set('insurance_category_title_en', $this->input->post('insurance_category_title_en'));
        $this->db->set('insurance_category_order', $newOrder);
        $this->db->set('insurance_category_meta_url', 'products/'.$validatedURL);
        $this->db->set('insurance_category_status', $this->input->post('insurance_category_status'));
        $this->db->set('insurance_category_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('insurance_category_createdip', $this->input->ip_address());
        $this->db->insert('insurance_categories');

        $this->reOrder();

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been created.'
        );

        return $message;
    }

    public function update( $insurance_categoryid=0 ){
        $message = array();
        $info = $this->get_insurance_categoryinfo_byid( $insurance_categoryid );

        /* Generate META URL - Start */
        $metaURL = $this->input->post('insurance_category_title_en');
        $validatedURL = validate_meta_url( $metaURL, 'insurance_categories', 'insurance_category_', $info['insurance_category_id'] );
        /* Generate META URL - End */

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/insurance_categories';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'insurance_category_banner', $_FILES['insurance_category_banner'], $info['insurance_category_banner']);
        /* Upload - End */

        $this->db->set('insurance_category_banner', $file);
        $this->db->set('insurance_category_icon', $this->input->post('insurance_category_icon'));
        $this->db->set('insurance_category_title_th', $this->input->post('insurance_category_title_th'));
        $this->db->set('insurance_category_title_en', $this->input->post('insurance_category_title_en'));
        $this->db->set('insurance_category_meta_url', 'products/'.$validatedURL);
        $this->db->set('insurance_category_status', $this->input->post('insurance_category_status'));
        $this->db->set('insurance_category_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('insurance_category_updatedip', $this->input->ip_address());
        $this->db->where('insurance_category_id', $info['insurance_category_id']);
        $this->db->update('insurance_categories');

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been updated.'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $insurance_categoryid=0 ){
        $message = array();
        $info = $this->get_insurance_categoryinfo_byid( $insurance_categoryid );

        $this->db->set('insurance_category_status', $setto);
        $this->db->where('insurance_category_id', $info['insurance_category_id']);
        $this->db->update('insurance_categories');

        if( $setto == 'discard' ){
            $this->reOrder();
            $message = array(
                'status' => 'message-success',
                'text' => 'Your item has been deleted.'
            );
        }else{
            $message = array(
                'status' => 'message-success',
                'text' => 'Your status has been updated.'
            );
        }

        return $message;
    }

    public function setOrder($movement='up', $insurance_categoryid=0){
		$info = $this->get_insurance_categoryinfo_byid($insurance_categoryid);
		$total = $this->count_categories();
		$message = array();
		
		if($movement=='up'){
			$neworder = intval($info['insurance_category_order']-1);
			if($neworder<=0){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับบนสุดไม่สามารถเลื่อนขึ้นได้';
			}else{
				
				$exists = $this->get_insurance_categoryinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['insurance_category_order']+1);
					$this->db->set('insurance_category_order', $exists_neworder);
					$this->db->where('insurance_category_id', $exists['insurance_category_id']);
					$this->db->update('insurance_categories');
				}
				
				$this->db->set('insurance_category_order', $neworder);
				$this->db->where('insurance_category_id', $info['insurance_category_id']);
				$this->db->update('insurance_categories');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else if($movement=='down'){
			$neworder = intval($info['insurance_category_order']+1);
			if($neworder>$total){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับล่างสุดไม่สามารถเลื่อนลงได้';
			}else{
				
				$exists = $this->get_insurance_categoryinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['insurance_category_order']-1);
					$this->db->set('insurance_category_order', $exists_neworder);
					$this->db->where('insurance_category_id', $exists['insurance_category_id']);
					$this->db->update('insurance_categories');
				}
				
				$this->db->set('insurance_category_order', $neworder);
				$this->db->where('insurance_category_id', $info['insurance_category_id']);
				$this->db->update('insurance_categories');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else{
			$message['status'] = 'message-error';
			$message['text'] = 'ไม่สามารถบันทึกข้อมูลการจัดลำดับได้';
		}

		return $message;
    }
    
    function get_icons()
	{
        //$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content:\s*"(.+)";\s+}/';
        $pattern = '/\.(icon_(?:\w+(?:-)?)+):before\s*{\s*content:\s*"(.+)";\s+/';
        $subject = file_get_contents(realpath('') . '/public/core/vendors/icomoon/style.css');
        
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

/* End of file Manageinsurance_categorymodel.php */
