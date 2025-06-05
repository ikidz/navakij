<?php
class Manageawardsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_awards( $limit=0, $offset=0 ){

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('award_status !=','discard')
                            ->order_by('award_order','asc')
                            ->get('awards')
                            ->result_array();
        return $query;

    }

    public function count_awards(){

        $query = $this->db->where('award_status !=','discard')
                            ->order_by('award_order','asc')
                            ->count_all_results('awards');
        return $query;

    }

    public function get_awardinfo_byid( $awardid=0 ){
        $query = $this->db->where('award_id', $awardid)
                            ->get('awards')
                            ->row_array();
        return $query;
    }

    public function get_awardinfo_byorder( $order=0 ){
        $query = $this->db->where('award_status','approved')
                            ->where('award_order', $order)
                            ->limit(1)
                            ->get('awards')
                            ->row_array();
        return $query;
    }

    public function reOrder(){
        $lists = $this->get_awards();
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('award_order', $i);
                $this->db->where('award_id', $list['award_id']);
                $this->db->update('awards');
            }
        }
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/awards';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'award_image', $_FILES['award_image']);
        /* Upload - End */

        $newOrder = 0;

        $this->db->set('award_image', $file);
        $this->db->set('award_title_th', $this->input->post('award_title_th'));
        $this->db->set('award_title_en', $this->input->post('award_title_en'));
        $this->db->set('award_desc_th', $this->input->post('award_desc_th'));
        $this->db->set('award_desc_en', $this->input->post('award_desc_en'));
        $this->db->set('award_order', $newOrder);
        $this->db->set('award_status', $this->input->post('award_status'));
        $this->db->set('award_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('award_createdip', $this->input->ip_address());
        $this->db->insert('awards');

        $this->reOrder();

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update( $awardid=0 ){
        $message = array();
        $info = $this->get_awardinfo_byid( $awardid );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/awards';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'award_image', $_FILES['award_image'], $info['award_image']);
        /* Upload - End */

        $this->db->set('award_image', $file);
        $this->db->set('award_title_th', $this->input->post('award_title_th'));
        $this->db->set('award_title_en', $this->input->post('award_title_en'));
        $this->db->set('award_desc_th', $this->input->post('award_desc_th'));
        $this->db->set('award_desc_en', $this->input->post('award_desc_en'));
        $this->db->set('award_status', $this->input->post('award_status'));
        $this->db->set('award_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('award_updatedip', $this->input->ip_address());
        $this->db->where('award_id', $info['award_id']);
        $this->db->update('awards');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setOrder( $movement='up', $awardid=0 ){
        $message = array();
        $info = $this->get_awardinfo_byid( $awardid );
        $total = $this->count_awards();

        if( $movement == 'up' ){
            $newOrder = intval( $info['award_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_awardinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['award_order'] + 1 );
                    $this->db->set('award_order', $exists_newOrder);
                    $this->db->where('award_id', $exists['award_id']);
                    $this->db->update('awards');
                }

                $this->db->set('award_order', $newOrder);
                $this->db->where('award_id', $info['award_id']);
                $this->db->update('awards');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
                
            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['award_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{

                $exists = $this->get_awardinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['award_order'] - 1 );
                    $this->db->set('award_order', $exists_newOrder);
                    $this->db->where('award_id', $exists['award_id']);
                    $this->db->update('awards');
                }

                $this->db->set('award_order', $newOrder);
                $this->db->where('award_id', $info['award_id']);
                $this->db->update('awards');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
                
            }
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ไม่สามารถบันทึกข้อมูลการจัดลำดับได้'
            );
        }

        return $message;
    }

    public function setStatus( $setto='approved', $awardid=0 ){
        $message = array();
        $info = $this->get_awardinfo_byid( $awardid );

        $this->db->set('award_status', $setto);
        $this->db->set('award_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('award_updatedip', $this->input->ip_address());
        $this->db->where('award_id', $info['award_id']);
        $this->db->update('awards');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
            $this->reOrder();
        }else{
            $message['text'] = 'บันทึกข้อมูลการแสดงผลสำเร็จ';
        }

        return $message;
    }
}
?>