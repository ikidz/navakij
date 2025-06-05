<?php
class Manageemailtemplatesmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_settinginfo( $type='applicant' ){

        if( $type == 'admin' ){
            $subject = $this->db->where('setting_key', 'admin_email_subject')
                                ->get('system_setting')
                                ->row_array();
            $body = $this->db->where('setting_key', 'admin_email_body')
                                ->get('system_setting')
                                ->row_array();
        }else if( $type == 'applicant' ){
            $subject = $this->db->where('setting_key', 'applicant_email_subject')
                                ->get('system_setting')
                                ->row_array();
            $body = $this->db->where('setting_key', 'applicant_email_body')
                                ->get('system_setting')
                                ->row_array();
        }else{
            $subject = [];
            $body = [];
        }

        $response = [
            'subject' => $subject,
            'body' => $body
        ];

        return $response;

    }

    public function update( $type='applicant' ){

        if( $type == 'admin' ){
            $key = 'admin';
        }else if( $type == 'applicant' ){
            $key = 'applicant';
        }

        $this->db->set('setting_value', $this->input->post('email_subject'));
        $this->db->where('setting_key', $key.'_email_subject');
        $this->db->update('system_setting');

        $this->db->set('setting_value', $this->input->post('email_body'));
        $this->db->where('setting_key', $key.'_email_body');
        $this->db->update('system_setting');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;

    }

    public function get_profile_settinginfo( $type='profile' ){

        if( $type == 'admin' ){
            $subject = $this->db->where('setting_key', 'admin_profile_email_subject')
                                ->get('system_setting')
                                ->row_array();
            $body = $this->db->where('setting_key', 'admin_profile_email_body')
                                ->get('system_setting')
                                ->row_array();
        }else if( $type == 'profile' ){
            $subject = $this->db->where('setting_key', 'profile_email_subject')
                                ->get('system_setting')
                                ->row_array();
            $body = $this->db->where('setting_key', 'profile_email_body')
                                ->get('system_setting')
                                ->row_array();
        }else{
            $subject = [];
            $body = [];
        }

        $response = [
            'subject' => $subject,
            'body' => $body
        ];

        return $response;

    }

    public function profile_update( $type='profile' ){

        if( $type == 'admin' ){
            $key = 'admin_profile';
        }else if( $type == 'profile' ){
            $key = 'profile';
        }

        $this->db->set('setting_value', $this->input->post('email_subject'));
        $this->db->where('setting_key', $key.'_email_subject');
        $this->db->update('system_setting');

        $this->db->set('setting_value', $this->input->post('email_body'));
        $this->db->where('setting_key', $key.'_email_body');
        $this->db->update('system_setting');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;

    }
}
?>