<?php
class Manageresponsesmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_responses( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('response_status !=','discard')
                            ->order_by('response_createdtime','desc')
                            ->get('responses')
                            ->result_array();
        return $query;
    }

    public function count_responses(){
        $query = $this->db->where('response_status !=','discard')
                            ->order_by('response_createdtime','desc')
                            ->count_all_results('responses');
        return $query;
    }

    public function get_responseinfo_byid( $responseid=0 ){
        $query = $this->db->where('response_id', $responseid)
                            ->get('responses')
                            ->row_array();
        return $query;
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/responses';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'response_image', $_FILES['response_image']);
        /* Upload - End */

        $this->db->set('response_image', $file);
        $this->db->set('response_title_th', $this->input->post('response_title_th'));
        $this->db->set('response_title_en', $this->input->post('response_title_en'));
        $this->db->set('response_caption_th', $this->input->post('response_caption_th'));
        $this->db->set('response_caption_en', $this->input->post('response_caption_en'));
        $this->db->set('response_remark_th', $this->input->post('response_remark_th'));
        $this->db->set('response_remark_en', $this->input->post('response_remark_th'));
        $this->db->set('response_button_1_url', $this->input->post('response_button_1_url'));
        $this->db->set('response_button_1_label_th', $this->input->post('response_button_1_label_th'));
        $this->db->set('response_button_1_label_en', $this->input->post('response_button_1_label_en'));
        $this->db->set('response_button_2_url', $this->input->post('response_button_2_url'));
        $this->db->set('response_button_2_label_th', $this->input->post('response_button_2_label_th'));
        $this->db->set('response_button_2_label_en', $this->input->post('response_button_2_label_en'));
        $this->db->set('response_status', $this->input->post('response_status'));
        $this->db->set('response_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('response_createdip', $this->input->ip_address());
        $this->db->insert('responses');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update( $responseid=0 ){
        $message = array();
        $info = $this->get_responseinfo_byid( $responseid );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/responses';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'response_image', $_FILES['response_image'], $info['response_image']);
        /* Upload - End */

        $this->db->set('response_image', $file);
        $this->db->set('response_title_th', $this->input->post('response_title_th'));
        $this->db->set('response_title_en', $this->input->post('response_title_en'));
        $this->db->set('response_caption_th', $this->input->post('response_caption_th'));
        $this->db->set('response_caption_en', $this->input->post('response_caption_en'));
        $this->db->set('response_button_1_url', $this->input->post('response_button_1_url'));
        $this->db->set('response_button_1_label_th', $this->input->post('response_button_1_label_th'));
        $this->db->set('response_button_1_label_en', $this->input->post('response_button_1_label_en'));
        $this->db->set('response_button_2_url', $this->input->post('response_button_2_url'));
        $this->db->set('response_button_2_label_th', $this->input->post('response_button_2_label_th'));
        $this->db->set('response_button_2_label_en', $this->input->post('response_button_2_label_en'));
        $this->db->set('response_status', $this->input->post('response_status'));
        $this->db->set('response_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('response_updatedip', $this->input->ip_address());
        $this->db->where('response_id', $info['response_id']);
        $this->db->update('responses');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $responseid=0 ){
        $message = array();
        $info = $this->get_responseinfo_byid( $responseid );

        $this->db->set('response_status', $setto);
        $this->db->set('response_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('response_updatedip', $this->input->ip_address());
        $this->db->where('response_id', $info['response_id']);
        $this->db->update('responses');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการดแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }
}
?>