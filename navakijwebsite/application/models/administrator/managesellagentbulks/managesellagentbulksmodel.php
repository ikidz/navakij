<?php
class Managesellagentbulksmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	public function get_bulks( $limit=0, $offset=0 ){
		if( $limit > 0 ){
			$query = $this->db->limit( $limit );
		}
		if( $offset > 0 ){
			$query = $this->db->offset( $offset );
		}
		
		$query = $this->db->where('status !=','discard')
							->order_by('created_at','desc')
							->get('sell_agent_bulks')
							->result_array();
		return $query;
	}
	
	public function count_bulks(){
		$query = $this->db->where('status !=','discard')
							->order_by('created_at','desc')
							->count_all_results('sell_agent_bulks');
		return $query;
	}
	
	public function get_bulkinfo_byid( $bulkid=0 ){
		$query = $this->db->where('id', $bulkid)
							->get('sell_agent_bulks')
							->row_array();
		return $query;
	}
	
	public function setStatus( $setto='approved', $bulkid=0 ){
		$message = array();
		$info = $this->get_bulkinfo_byid( $bulkid );
		
		$this->db->set('status', $setto);
		$this->db->set('updated_at', date("Y-m-d H:i:s"));
		$this->db->where('id', $info['id']);
		$this->db->update('sell_agent_bulks');
		
		if( $setto == 'discard' ){
			$message['text'] = 'ลบข้อมูลสำเร็จ';
		}else{
			$message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
		}
		
		$message['status'] = 'message-success';
		
		return $message;
	}
	
	public function create(){
		$message = array();
		
		/* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/sellagent_bulks';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'file', $_FILES['file']);
        /* Upload - End */
        
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('file', $file);
        $this->db->set('status','pending');
        $this->db->set('created_at', date("Y-m-d H:i:s"));
		$this->db->insert('sell_agent_bulks');
        
        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ ระบบนำเข้าจะเข้ามาอ่านข้อมูลในอีก 5 นาที'
        );

        return $message;
	}
}
?>