<?php
class Manageapplicantdocumentsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_setting_bykey( $key = '' ){
        $query = $this->db->where('setting_key', $key)
                            ->get('system_setting')
                            ->row_array();
        return $query;
    }

    public function update( $key='' ){
        $this->db->set('setting_value', $this->input->post('setting_value'));
        $this->db->where('setting_key', $key);
        $this->db->update('system_setting');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }
}
?>