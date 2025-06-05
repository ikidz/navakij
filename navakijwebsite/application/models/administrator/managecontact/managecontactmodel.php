<?php
class Managecontactmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}


	
	public function get_contacts($aSort=array(),$limit=10, $offset=0){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				contact_name like "%'.$keyword.'%" OR 
				contact_lastname like "%'.$keyword.'%" OR 
				contact_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('contact_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('contact_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('contact_status !=','discard')
							->order_by('contact_id','desc')
							->get('contact', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_contacts($aSort=array()){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				contact_name like "%'.$keyword.'%" OR 
				contact_lastname like "%'.$keyword.'%" OR 
				contact_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('contact_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('contact_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('contact_status !=','discard')
							->count_all_results('contact');
		return $query;
	}
	
	public function get_contactinfo_byid($contactid=0){
		$query = $this->db->where('contact_id', $contactid)
							->get('contact')->row_array();
		return $query;
	}
	
	public function get_contactinfo_byorder($order){
		$query = $this->db->where('contact_status !=','discard')
							->order_by('contact_createdtime','desc')
							->limit(1)
							->get('contact')->row_array();
		return $query;
	}

	public function get_provinces_name($province_id){
		$row = $this->db->where('province_id',$province_id)
                            ->get('system_province')
                            ->row_array();
        return $row['province_name_th'];
	}
	
	public function update($contactid=0){
		$info = $this->get_contactinfo_byid($contactid);
		
		$this->db->set('contact_status', $this->input->post('contact_status'));
		$this->db->set('contact_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('contact_updatedip', $this->input->ip_address());
		$this->db->where('contact_id', $info['contact_id']);
		$this->db->update('contact');
		
		$message = array();
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		
		
		return $message;
	}

	public function setStatus($setto='approved', $contactid=0){
		$message = array();
		
		$this->db->set('contact_status', $setto);
		$this->db->set('contact_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('contact_updatedip', $this->input->ip_address());
		$this->db->where('contact_id', $contactid);
		$this->db->update('contact');
		
		$message['status'] = 'message-success';
		if($setto=='discard'){
			$message['text'] = 'ลบข้อมูลเรียบร้อยแล้ว';
		}else{
			$message['text'] = 'แก้ไขสถานะการแสดงผลเรียบร้อยแล้ว';
		}
		
		return $message;
	}
	
}
?>