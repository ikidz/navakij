<?php
class Managedataclearingbotmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_setting_bykey( $key = '' ){
        $query = $this->db->where('setting_key', $key)
                            ->get('system_setting')
                            ->row_array();
        return $query;
    }

    public function update( $key = '' ){
        $this->db->set('setting_value', $this->input->post('setting_value'));
        $this->db->where('setting_key', $key);
        $this->db->update('system_setting');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function get_report( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->order_by('deleted_createdtime','desc')
                            ->get('deleted_data')
                            ->result_array();
        return $query;
    }

    public function count_report(){
        $query = $this->db->order_by('deleted_createdtime','desc')
                            ->count_all_results('deleted_data');
        return $query;
    }
}
?>