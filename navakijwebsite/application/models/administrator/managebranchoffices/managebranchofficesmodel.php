<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managebranchofficesmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_regions( $limit=0, $offset=0 ){
        
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->order_by('region_order','asc')
                            ->get('system_region')
                            ->result_array();
        return $query;
    }

    public function count_regions(){
        $query = $this->db->count_all_results('system_region');
        return $query;
    }

    public function get_regioninfo_byid( $regionid=0 ){
        $query = $this->db->where('region_id', $regionid)
                            ->get('system_region')
                            ->row_array();
        return $query;
    }

    public function get_branches( $regionid=0, $limit=0, $offset=0 ){
        
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        if( $regionid > 0 ){
            $query = $this->db->where('region_id', $regionid);
        }

        $query = $this->db->where('status !=', 'discard')
                            ->order_by('order','asc')
                            ->get('branch_offices')
                            ->result_array();
        return $query;
    }

    public function count_branches( $regionid=0 ){
        if( $regionid > 0 ){
            $this->db->where('region_id', $regionid);
        }
        $query = $this->db->where('status !=', 'discard')
                            ->count_all_results('branch_offices');
        return $query;
    }

    public function get_branchinfo_byid( $branchid=0 ){
        $query = $this->db->where('id', $branchid)
                            ->get('branch_offices')
                            ->row_array();
        return $query;
    }

    public function get_branchinfo_byorder( $regionid=0, $order=0 ){
        $query = $this->db->where('region_id', $regionid )
                            ->where('order', $order )
                            ->where('status !=','discard')
                            ->order_by('createdtime','desc')
                            ->limit(1)
                            ->get('branch_offices')
                            ->row_array();
        return $query;
    }

    public function reOrder( $regionid=0 ){
        $lists = $this->get_branches($regionid);
        if( isset( $lists ) && count( $lists ) > 0 ){
            $order=0;
            foreach( $lists as $list ){
                $order++;
                $this->db->set('order', $order);
                $this->db->where('id', $list['id']);
                $this->db->update('branch_offices');
            }
        }
    }


    public function create( $regionid=0 ){
        $message = array();
        $region = $this->get_regioninfo_byid( $regionid );

        $newOrder = 0;

        /* Upload Desktop - Start */
		$uploadpath = realpath('').'/public/core/uploaded/branchoffices';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg|pdf';
		$config['max_size'] = 5120;
		// $config['max_width'] = 1920;
		// $config['min_width'] = 1920;
		// $config['max_height'] = 500;
		// $config['min_height'] = 500;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->do_upload($config, 'map_img', $_FILES['map_img']);
		/* Upload Desktop - End */

        $this->db->set('region_id', $region['region_id']);
        $this->db->set('name_th', $this->input->post('name_th'));
        $this->db->set('name_en', $this->input->post('name_en'));
        $this->db->set('tel', $this->input->post('tel'));
        $this->db->set('map_img', $file);
        $this->db->set('map_google', $this->input->post('map_google'));
        $this->db->set('order', $newOrder);
        $this->db->set('status', $this->input->post('status'));
        $this->db->set('createdtime', date("Y-m-d H:i:s"));
        $this->db->set('createdip', $this->input->ip_address());
        $this->db->insert('branch_offices');

        $this->reOrder($region['region_id']);

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been created.'
        );
        return $message;
    }

    public function update( $id=0 ){
        $message = array();
        $info = $this->get_branchinfo_byid( $id );
        $region = $this->get_regioninfo_byid( $info['region_id'] );

        /* Upload Desktop - Start */
		$uploadpath = realpath('').'/public/core/uploaded/branchoffices';
		if(is_dir($uploadpath)===false){
			mkdir($uploadpath, 0777);
			chmod($uploadpath, 0777);
		}
					
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = 'jpg|png|gif|jpeg|pdf';
		$config['max_size'] = 5120;
		// $config['max_width'] = 1920;
		// $config['min_width'] = 1920;
		// $config['max_height'] = 500;
		// $config['min_height'] = 500;
		$config['encrypt_name'] = true;
					
		$file = $this->uploadmodel->edit_upload($config, 'map_img', $_FILES['map_img'], $info['map_img']);
		/* Upload Desktop - End */

        $this->db->set('region_id', $region['region_id']);
        $this->db->set('name_th', $this->input->post('name_th'));
        $this->db->set('name_en', $this->input->post('name_en'));
        $this->db->set('tel', $this->input->post('tel'));
        $this->db->set('map_img', $file);
        $this->db->set('map_google', $this->input->post('map_google'));
        $this->db->set('status', $this->input->post('status'));
        $this->db->set('createdtime', date("Y-m-d H:i:s"));
        $this->db->set('createdip', $this->input->ip_address());
        $this->db->where('id', $info['id']);
        $this->db->update('branch_offices');

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been updated.'
        );
        return $message;
    }

    public function setStatus( $setto='approved', $id=0 ){
        $message = array();
        $info = $this->get_branchinfo_byid( $id );

        $this->db->set('status', $setto);
        $this->db->where('id', $info['id']);
        $this->db->update('branch_offices');

        if( $setto == 'discard' ){
            $this->reOrder( $info['region_id'] );
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

    public function setOrder($movement='up', $id=0){
		$info = $this->get_branchinfo_byid($id);
		$total = $this->count_branches($regionid);
		$message = array();
		
		if($movement=='up'){
			$neworder = intval($info['order']-1);
			if($neworder<=0){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับบนสุดไม่สามารถเลื่อนขึ้นได้';
			}else{
				
				$exists = $this->get_branchinfo_byorder($info['region_id'], $neworder);
				if($exists){
					$exists_neworder = intval($exists['order']+1);
					$this->db->set('order', $exists_neworder);
					$this->db->where('id', $exists['id']);
					$this->db->update('branch_offices');
				}
				
				$this->db->set('order', $neworder);
				$this->db->where('id', $info['id']);
				$this->db->update('branch_offices');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else if($movement=='down'){
			$neworder = intval($info['order']+1);
			if($neworder>$total){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับล่างสุดไม่สามารถเลื่อนลงได้';
			}else{
				
				$exists = $this->get_categoryinfo_byorder($info['region_id'], $neworder);
				if($exists){
					$exists_neworder = intval($exists['order']-1);
					$this->db->set('order', $exists_neworder);
					$this->db->where('id', $exists['id']);
					$this->db->update('branch_offices');
				}
				
				$this->db->set('order', $neworder);
				$this->db->where('id', $info['id']);
				$this->db->update('branch_offices');
				
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

/* End of file Managecategorymodel.php */
