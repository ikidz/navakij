<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managebranchcategoriesmodel extends CI_Model {

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

        $query = $this->db->where('category_status !=','discard')
                            ->order_by('category_order','asc')
                            ->get('branch_categories')
                            ->result_array();
        return $query;
    }

    public function count_categories(){
        $query = $this->db->where('category_status !=','discard')
                            ->count_all_results('branch_categories');
        return $query;
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('branch_categories')
                            ->row_array();
        return $query;
    }

    public function get_categoryinfo_byorder( $order=0 ){
        $query = $this->db->where('category_order', $order )
                            ->where('category_status !=','discard')
                            ->order_by('category_createdtime','desc')
                            ->limit(1)
                            ->get('branch_categories')
                            ->row_array();
        return $query;
    }

    public function reOrder(){
        $lists = $this->get_categories();
        if( isset( $lists ) && count( $lists ) > 0 ){
            $order=0;
            foreach( $lists as $list ){
                $order++;
                $this->db->set('category_order', $order);
                $this->db->where('category_id', $list['category_id']);
                $this->db->update('branch_categories');
            }
        }
    }

    public function create(){
        $message = array();

        $total = $this->count_categories();
        $newOrder = 0;

        /* Generate META URL - Start */
        $metaURL = $this->input->post('category_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'branch_categories', 'category_' );
        /* Generate META URL - End */

        $this->db->set('category_title_th', $this->input->post('category_title_th'));
        $this->db->set('category_title_en', $this->input->post('category_title_en'));
        $this->db->set('category_order', $newOrder);
        $this->db->set('category_meta_url', $validatedURL);
        $this->db->set('category_status', $this->input->post('category_status'));
        $this->db->set('category_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('category_createdip', $this->input->ip_address());
        $this->db->insert('branch_categories');

        $this->reOrder();

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been created.'
        );

        return $message;
    }

    public function update( $categoryid=0 ){
        $message = array();
        $info = $this->get_categoryinfo_byid( $categoryid );

        /* Generate META URL - Start */
        $metaURL = $this->input->post('category_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'branch_categories', 'category_', $info['category_id'] );
        /* Generate META URL - End */

        $this->db->set('category_title_th', $this->input->post('category_title_th'));
        $this->db->set('category_title_en', $this->input->post('category_title_en'));
        $this->db->set('category_meta_url', $validatedURL);
        $this->db->set('category_status', $this->input->post('category_status'));
        $this->db->set('category_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('category_updatedip', $this->input->ip_address());
        $this->db->where('category_id', $info['category_id']);
        $this->db->update('branch_categories');

        $message = array(
            'status' => 'message-success',
            'text' => 'Your information has been updated.'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $categoryid=0 ){
        $message = array();
        $info = $this->get_categoryinfo_byid( $categoryid );

        $this->db->set('category_status', $setto);
        $this->db->where('category_id', $info['category_id']);
        $this->db->update('branch_categories');

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

    public function setOrder($movement='up', $categoryid=0){
		$info = $this->get_categoryinfo_byid($categoryid);
		$total = $this->count_categories();
		$message = array();
		
		if($movement=='up'){
			$neworder = intval($info['category_order']-1);
			if($neworder<=0){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับบนสุดไม่สามารถเลื่อนขึ้นได้';
			}else{
				
				$exists = $this->get_categoryinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['category_order']+1);
					$this->db->set('category_order', $exists_neworder);
					$this->db->where('category_id', $exists['category_id']);
					$this->db->update('branch_categories');
				}
				
				$this->db->set('category_order', $neworder);
				$this->db->where('category_id', $info['category_id']);
				$this->db->update('branch_categories');
				
				$message['status'] = 'message-success';
				$message['text'] = 'บันทึกข้อมูลการจัดลำดับสำเร็จ';
				
			}
		}else if($movement=='down'){
			$neworder = intval($info['category_order']+1);
			if($neworder>$total){
				$message['status'] = 'message-warning';
				$message['text'] = 'ลำดับล่างสุดไม่สามารถเลื่อนลงได้';
			}else{
				
				$exists = $this->get_categoryinfo_byorder($neworder);
				if($exists){
					$exists_neworder = intval($exists['category_order']-1);
					$this->db->set('category_order', $exists_neworder);
					$this->db->where('category_id', $exists['category_id']);
					$this->db->update('branch_categories');
				}
				
				$this->db->set('category_order', $neworder);
				$this->db->where('category_id', $info['category_id']);
				$this->db->update('branch_categories');
				
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
