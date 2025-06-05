<?php
class Manageinsurancecontactmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function get_provinceinfo_byid( $provinceid=0 ){
		$query = $this->db->where('province_id', $provinceid)
							->get('system_province')
							->row_array();
		return $query;
	}
	
	public function get_insurancecontacts($aSort=array(), $insurance_id,$limit=10, $offset=0){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				insurance_contact_name like "%'.$keyword.'%" OR 
				insurance_contact_lastname like "%'.$keyword.'%" OR 
				insurance_contact_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('insurance_contact_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('insurance_contact_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('insurance_contact_status !=','discard')
							->where('insurance_id',$insurance_id)
							->order_by('insurance_contact_id','desc')
							->get('insurance_contact', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_insurancecontacts($aSort=array(), $insurance_id){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				insurance_contact_name like "%'.$keyword.'%" OR 
				insurance_contact_lastname like "%'.$keyword.'%" OR 
				insurance_contact_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('insurance_contact_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('insurance_contact_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('insurance_contact_status !=','discard')
							->where('insurance_id',$insurance_id)
							->count_all_results('insurance_contact');
		return $query;
	}
	
	public function get_insurancecontactinfo_byid($insurancecontactid=0){
		$query = $this->db->where('insurance_contact_id', $insurancecontactid)
							->get('insurance_contact')->row_array();
		return $query;
	}
	
	public function get_insurancecontactinfo_byorder($order){
		$query = $this->db->where('insurance_contact_status !=','discard')
							->order_by('insurance_contact_createdtime','desc')
							->limit(1)
							->get('insurance_contact')->row_array();
		return $query;
	}

	public function get_provinces_name($province_id){
		$row = $this->db->where('province_id',$province_id)
                            ->get('system_province')
                            ->row_array();
        return $row['province_name_th'];
	}
	
	public function update($insurancecontactid=0){
		$info = $this->get_insurancecontactinfo_byid($insurancecontactid);
		
		$this->db->set('insurance_contact_status', $this->input->post('insurance_contact_status'));
		$this->db->set('insurance_contact_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('insurance_contact_updatedip', $this->input->ip_address());
		$this->db->where('insurance_contact_id', $info['insurance_contact_id']);
		$this->db->update('insurance_contact');
		
		$message = array();
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		
		
		return $message;
	}

	public function setStatus($setto='approved', $insurancecontactid=0){
		$message = array();
		
		$this->db->set('insurance_contact_status', $setto);
		$this->db->set('insurance_contact_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('insurance_contact_updatedip', $this->input->ip_address());
		$this->db->where('insurance_contact_id', $insurancecontactid);
		$this->db->update('insurance_contact');
		
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