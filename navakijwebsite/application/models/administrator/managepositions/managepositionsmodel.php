<?php
class Managepositionsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_positions( $mainid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('main_id', $mainid)
                            ->where('position_status !=', 'discard')
                            ->order_by('position_order','asc')
                            ->get('positions')
                            ->result_array();
        return $query;
    }

    public function count_positions( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('position_status !=', 'discard')
                            ->order_by('position_order','asc')
                            ->count_all_results('positions');
        return $query;
    }

    public function get_positioninfo_byid( $positionid=0 ){
        $query = $this->db->where('position_id', $positionid)
                            ->get('positions')
                            ->row_array();
        return $query;
    }

    public function get_positioninfo_byorder( $mainid=0, $order=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('position_order', $order)
                            ->where('position_status !=','discard')
                            ->limit(1)
                            ->get('positions')
                            ->row_array();
        return $query;
    }

    public function reOrder( $mainid=0 ){
        $lists = $this->get_positions( $mainid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('position_order', $i);
                $this->db->where('position_id', $list['position_id']);
                $this->db->update('positions');
            }
        }
    }

    public function create(){
        $message = array();

        $newOrder = 0;

        $this->db->set('main_id', $this->input->post('main_id'));
        $this->db->set('position_title_th', $this->input->post('position_title_th'));
        $this->db->set('position_title_en', $this->input->post('position_title_en'));
        $this->db->set('position_order', $newOrder);
        $this->db->set('position_status', $this->input->post('position_status'));
        $this->db->set('position_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('position_createdip', $this->input->ip_address());
        $this->db->insert('positions');

        $this->reOrder( $this->input->post('main_id') );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update($positionid=0){
        $message = array();
        $info = $this->get_positioninfo_byid( $positionid );

        $this->db->set('position_title_th', $this->input->post('position_title_th'));
        $this->db->set('position_title_en', $this->input->post('position_title_en'));
        $this->db->set('position_status', $this->input->post('position_status'));
        $this->db->set('position_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('position_updatedip', $this->input->ip_address());
        $this->db->where('position_id', $info['position_id']);
        $this->db->update('positions');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='discard', $positionid=0 ){
        $message = array();
        $info = $this->get_positioninfo_byid( $positionid );

        $this->db->set('position_status', $setto);
        $this->db->set('position_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('position_updatedip', $this->input->ip_address());
        $this->db->where('position_id', $info['position_id']);
        $this->db->update('positions');

        if( $setto == 'discard' ){
            $this->reOrder( $info['main_id'] );
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement='up', $positionid=0 ){
        $message = array();
        $info = $this->get_positioninfo_byid( $positionid );
        $total = $this->count_positions( $info['main_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['position_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_positioninfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['position_order'] + 1 );
                    $this->db->set('position_order', $exists_newOrder);
                    $this->db->where('position_id', $exists['position_id']);
                    $this->db->update('positions');
                }

                $this->db->set('position_order', $newOrder);
                $this->db->where('position_id', $info['position_id']);
                $this->db->update('positions');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );

            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['position_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{

                $exists = $this->get_positioninfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['position_order'] - 1 );
                    $this->db->set('position_order', $exists_newOrder);
                    $this->db->where('position_id', $exists['position_id']);
                    $this->db->update('positions');
                }

                $this->db->set('position_order', $newOrder);
                $this->db->where('position_id', $info['position_id']);
                $this->db->update('positions');

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
}
?>