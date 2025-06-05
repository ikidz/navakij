<?php
class Managevehicleinsurancemodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function get_insuranceinfo_byid( $insuranceid=0 ){
		$query = $this->db->where('insurance_id', $insuranceid)
							->get('insurance')
							->row_array();
		return $query;
	}
	
	public function get_vehicleinsurancelists($insuranceid=0, $limit=10, $offset=0){
		if( $insuranceid > 0 ){
			$query = $this->db->where('insurance_id', $insuranceid);
		}else{
			$query = $this->db->where('insurance_id !=', 0);
		}
		$query = $this->db->where('vehicle_insurance_status !=','discard')
							->order_by('vehicle_insurance_id','desc')
							->get('vehicle_insurance', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_vehicleinsurancelists($insuranceid=0){
		if( $insuranceid > 0 ){
			$query = $this->db->where('insurance_id', $insuranceid);
		}else{
			$query = $this->db->where('insurance_id !=', 0);
		}
		$query = $this->db->where('vehicle_insurance_status !=','discard')
						->count_all_results('vehicle_insurance');
		return $query;
	}
	
	public function get_vehicleinsuranceinfo_byid($vehicleinsuranceid=0){
		$query = $this->db->where('vehicle_insurance_id', $vehicleinsuranceid)
							->get('vehicle_insurance')->row_array();
		return $query;
	}
	
	public function create( $insuranceid=0 ){
		$message = array();
		$insurance = $this->get_insuranceinfo_byid( $insuranceid );

		
		$this->db->set('insurance_id', $insurance['insurance_id']);
		$this->db->set('vehicle_group_id', $this->input->post('vehicle_group_id'));
		$this->db->set('sum_insured', $this->input->post('sum_insured'));
		$this->db->set('vehicle_insurance_desc_th', $this->input->post('vehicle_insurance_desc_th'));
		$this->db->set('vehicle_insurance_desc_en', $this->input->post('vehicle_insurance_desc_en'));
		$this->db->set('price', $this->input->post('price'));
		$this->db->set('vehicle_insurance_status', $this->input->post('vehicle_insurance_status'));
		$this->db->set('vehicle_insurance_createdtime', date("Y-m-d H:i:s"));
		$this->db->set('vehicle_insurance_createdip', $this->input->ip_address());
		
		$this->db->insert('vehicle_insurance');
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}
	
	public function update($vehicleinsuranceid=0){
		$message = array();
		$info = $this->get_vehicleinsuranceinfo_byid($vehicleinsuranceid);
		
		$this->db->set('insurance_id', $info['insurance_id']);
		$this->db->set('vehicle_group_id', $this->input->post('vehicle_group_id'));
		$this->db->set('sum_insured', $this->input->post('sum_insured'));
		$this->db->set('vehicle_insurance_desc_th', $this->input->post('vehicle_insurance_desc_th'));
		$this->db->set('vehicle_insurance_desc_en', $this->input->post('vehicle_insurance_desc_en'));
		$this->db->set('price', $this->input->post('price'));
		$this->db->set('vehicle_insurance_status', $this->input->post('vehicle_insurance_status'));
		$this->db->set('vehicle_insurance_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('vehicle_insurance_updatedip', $this->input->ip_address());
		$this->db->where('vehicle_insurance_id', $info['vehicle_insurance_id']);
		$this->db->update('vehicle_insurance');
		
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		return $message;
	}

	
	
	public function setStatus($setto='approved', $vehicleinsuranceid=0){
		$message = array();
		
		$this->db->set('vehicle_insurance_status', $setto);
		$this->db->set('vehicle_insurance_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('vehicle_insurance_updatedip', $this->input->ip_address());
		$this->db->where('vehicle_insurance_id', $vehicleinsuranceid);
		$this->db->update('vehicle_insurance');
		
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

	public function get_insurance_name($insurance_id)
	{
		$query = $this->db->where('insurance_id', $insurance_id)
							->get('insurance')
							->row_array();
		return $query['insurance_title_th'];
	}

	public function get_vehicle_group_name($vehicle_group_id)
	{
		$query = $this->db->where('vehicle_group_id', $vehicle_group_id)
							->get('vehicle_group')
							->row_array();
		return $query['vehicle_group_title_th'];
	}

	public function get_vehicle_group_list()
	{
		$query = $this->db->get('vehicle_group')
							->result_array();
		return $query;
	}

	
}
?>