<?php
class Managesellagentsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	public function get_agents( $limit=0, $offset=0 ){
		if( $limit > 0 ){
			$query = $this->db->limit( $limit );
		}
		if( $offset > 0 ){
			$query = $this->db->offset( $offset );
		}
		$query = $this->db->where('agent_status !=','discard')
							->order_by('agent_createdtime','desc')
							->get('sell_agents')
							->result_array();
		return $query;
	}
	
	public function count_agents(){
		$query = $this->db->where('agent_status !=','discard')
							->count_all_results('sell_agents');
		return $query;
	}
	
	public function get_agentinfo_byid( $agentid=0 ){
		$query = $this->db->where('agent_id', $agentid)
							->get('sell_agents')
							->row_array();
		return $query;
	}
	
	public function create(){
		$message = array();
		
		$this->db->set('agent_name_th', $this->input->post('agent_name_th'));
		$this->db->set('agent_name_en', $this->input->post('agent_name_en'));
		$this->db->set('agent_license_no', $this->input->post('agent_license_no'));
		$this->db->set('agent_status', $this->input->post('agent_status'));
		$this->db->set('agent_createdtime', date('Y-m-d H:i:s'));
		$this->db->set('agent_createdip', $this->input->ip_address());
		$this->db->insert('sell_agents');
		
		return $message = array(
			'stauts' => 'message-success',
			'text' => 'บันทึกข้อมูลสำเร็จ'
		);
	}
	
	public function update($agentid=0){
		$info = $this->get_agentinfo_byid( $agentid );
		$message = array();
		
		$this->db->set('agent_name_th', $this->input->post('agent_name_th'));
		$this->db->set('agent_name_en', $this->input->post('agent_name_en'));
		$this->db->set('agent_license_no', $this->input->post('agent_license_no'));
		$this->db->set('agent_status', $this->input->post('agent_status'));
		$this->db->set('agent_updatedtime', date('Y-m-d H:i:s'));
		$this->db->set('agent_updatedip', $this->input->ip_address());
		$this->db->where('agent_id', $info['agent_id']);
		$this->db->update('sell_agents');
		
		return $message = array(
			'stauts' => 'message-success',
			'text' => 'บันทึกข้อมูลสำเร็จ'
		);
	}
	
	public function setStatus( $setto='approved', $agentid=0 ){
		$message = array();
		$info = $this->get_agentinfo_byid( $agentid );
		
		$this->db->set('agent_status', $setto);
		$this->db->set('agent_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('agent_updatedip', $this->input->ip_address());
		$this->db->where('agent_id', $info['agent_id']);
		$this->db->update('sell_agents');
		
		if( $setto == 'approved' ){
			$message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
		}else{
			$message['text'] = 'ลบข้อมูลสำเร็จ';
		}
		$message['status'] = 'message-success';
		
		return $message;
	}
}
?>