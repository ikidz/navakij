<?php
class Managelocationsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	public function get_locations( $limit=0, $offset=0 ){
		if( $limit > 0 ){
			$query = $this->db->limit( $limit );
		}
		
		if( $offset > 0 ){
			$query = $this->db->offset( $offset );
		}
		
		$query = $this->db->where('location_status !=','discard')
							->order_by('location_order','asc')
							->get('locations')
							->result_array();
		return $query;
	}
	
	public function count_locations(){
		$query = $this->db->where('location_status !=','discard')
							->order_by('location_order','asc')
							->count_all_results('locations');
		return $query;
	}
	
	public function get_locationinfo_byid( $locationid=0 ){
		$query = $this->db->where('location_id', $locationid)
							->get('locations')
							->row_array();
		return $query;
	}
	
	public function get_locationinfo_byorder( $order=0 ){
		$query = $this->db->where('location_order', $order)
							->where('location_status !=','discard')
							->limit(1)
							->get('locations')
							->row_array();
		return $query;
	}
	
	public function reOrder(){
		$lists = $this->get_locations();
		if( isset( $lists ) && count( $lists ) > 0 ){
			$i=0;
			foreach( $lists as $list ){
				$i++;
				$this->db->set('location_order', $i);
				$this->db->where('location_id', $list['location_id']);
				$this->db->update('locations');
			}
		}
	}
	
	public function create(){
		$message = array();
		
		$this->db->set('location_title_th', $this->input->post('location_title_th'));
		$this->db->set('location_title_en', $this->input->post('location_title_en'));
		$this->db->set('location_order', 0);
		$this->db->set('location_status',$this->input->post('location_status'));
		$this->db->set('location_createdtime', date("Y-m-d H:i:s"));
		$this->db->set('location_createdip', $this->input->ip_address());
		$this->db->insert('locations');
		
		$this->reOrder();
		
		$message = array(
			'status' => 'message-success',
			'text' => 'บันทึกข้อมูลสำเร็จ'
		);
		
		return $message;
	}
	
	public function update( $locationid=0 ){
		$message = array();
		
		$info = $this->get_locationinfo_byid( $locationid );
		
		$this->db->set('location_title_th', $this->input->post('location_title_th'));
		$this->db->set('location_title_en', $this->input->post('location_title_en'));
		$this->db->set('location_status',$this->input->post('location_status'));
		$this->db->set('location_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('location_updatedip', $this->input->ip_address());
		$this->db->where('location_id', $info['location_id']);
		$this->db->update('locations');
		
		$message = array(
			'status' => 'message-success',
			'text' => 'บันทึกข้อมูลสำเร็จ'
		);

		return $message;
		
	}
	
	public function setStatus( $setto='approved', $locationid=0 ){
		$message = array();
		$info = $this->get_locationinfo_byid( $locationid );
		
		$this->db->set('location_status', $setto);
		$this->db->set('location_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('location_updatedip', $this->input->ip_address());
		$this->db->where('location_id', $info['location_id']);
		$this->db->update('locations');
		
		if( $setto == 'discard' ){
			$message['text'] = 'ลบข้อมูลสำเร็จ';
			$this->reOrder();

			/* Update `applicant_jobs` to "discard" - Start */
			$this->db->set('job_status', 'discard');
			$this->db->where('location_id', $info['location_id']);
			$this->db->update('applicant_jobs');
			/* Update `applicant_jobs` to "discard" - End */
							
		}else{
			$message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
		}
		
		$message['status'] = 'message-success';
		
		return $message;
	}
	
	public function setOrder( $movement='up', $locationid=0 ){
		$message = array();
		$info = $this->get_locationinfo_byid( $locationid );
		$total = $this->count_locations();
		
		if( $movement == 'up' ){
			$newOrder = $info['location_order'] - 1;
			if( $newOrder <=0 ){
				$message = array(
					'status' => 'message-warning',
					'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
				);
			}else{
				
				$exists = $this->get_locationinfo_byorder( $newOrder );
				if( isset( $exists ) && count( $exists ) > 0 ){
					$exists_newOrder = $exists['location_order'] + 1;
					$this->db->set('location_order', $exists_newOrder);
					$this->db->where('location_id', $exists['location_id']);
					$this->db->update('locations');
				}
				
				$this->db->set('location_order', $newOrder);
				$this->db->where('location_id', $info['location_id']);
				$this->db->update('locations');
				
				$message = array(
					'status' => 'message-success',
					'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
				);
				
			}
		}else if( $movement == 'down' ){
			$newOrder = $info['location_order'] + 1;
			if( $newOrder > $total ){
				$message = array(
					'status' => 'message-warning',
					'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
				);
			}else{
				
				$exists = $this->get_locationinfo_byorder( $newOrder );
				if( isset( $exists ) && count( $exists ) > 0 ){
					$exists_newOrder = $exists['location_order'] - 1;
					$this->db->set('location_order', $exists_newOrder);
					$this->db->where('location_id', $exists['location_id']);
					$this->db->update('locations');
				}
				
				$this->db->set('location_order', $newOrder);
				$this->db->where('location_id', $info['location_id']);
				$this->db->update('locations');
				
				$message = array(
					'status' => 'message-success',
					'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
				);
				
			}
		}else{
			$message = array(
				'status' => 'message-error',
				'text' => 'ไม่สามารถจัดลำดับข้อมูลได้'
			);
		}
		
		return $message;
	}
}
?>