<?php
class Managejobvacancymodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_locationinfo_byid( $locationid=0 ){
        $query = $this->db->where('location_id', $locationid)
                            ->get('locations')
                            ->row_array();
        return $query;
    }

    public function get_jobs( $locationid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('location_id', $locationid)
                            ->where('job_status !=','discard')
                            ->order_by('job_order','asc')
                            ->get('applicant_jobs')
                            ->result_array();
        return $query;
    }

    public function count_jobs( $locationid=0 ){
        $query = $this->db->where('location_id', $locationid)
                            ->where('job_status !=','discard')
                            ->order_by('job_order','asc')
                            ->count_all_results('applicant_jobs');
        return $query;
    }

    public function get_jobinfo_byid( $jobid=0 ){
        $query = $this->db->where('job_id', $jobid)
                            ->get('applicant_jobs')
                            ->row_array();
        return $query;
    }

    public function get_jobinfo_byorder( $locationid=0, $order=0 ){
        $query = $this->db->where('location_id', $locationid)
                            ->where('job_order', $order)
                            ->where('job_status !=','discard')
                            ->limit(1)
                            ->get('applicant_jobs')
                            ->row_array();
        return $query;
    }

    public function reOrder( $locationid=0 ){
        $lists = $this->get_jobs( $locationid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('job_order', $i);
                $this->db->where('job_id', $list['job_id']);
                $this->db->update('applicant_jobs');
            }
        }
    }

    public function create( $locationid=0 ){
        $message = array();
        $location = $this->get_locationinfo_byid( $locationid );

        /* Generate META URL - Start */
        $metaURL = $this->input->post('job_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'applicant_jobs', 'job_' );
        /* Generate META URL - End */

        $this->db->set('location_id', $location['location_id']);
        $this->db->set('job_title_th', $this->input->post('job_title_th'));
        $this->db->set('job_title_en', $this->input->post('job_title_en'));
        $this->db->set('job_remark_label_th', $this->input->post('job_remark_label_th'));
        $this->db->set('job_remark_label_en', $this->input->post('job_remark_label_en'));
        $this->db->set('job_responsibility_th', $this->input->post('job_responsibility_th'));
        $this->db->set('job_responsibility_en', $this->input->post('job_responsibility_en'));
        $this->db->set('job_qualification_th', $this->input->post('job_qualification_th'));
        $this->db->set('job_qualification_en', $this->input->post('job_qualification_en'));
        $this->db->set('job_start_date', date( "Y-m-d", strtotime( $this->input->post('job_start_date') ) ));
        $this->db->set('job_end_date', ( $this->input->post('job_end_date') != '' ? date( "Y-m-d", strtotime( $this->input->post('job_end_date') ) ) : null ));
        $this->db->set('job_amount', $this->input->post('job_amount'));
        $this->db->set('is_appliable', $this->input->post('is_appliable'));
        $this->db->set('is_profile_leaving', $this->input->post('is_profile_leaving'));
        $this->db->set('job_order', 0);
        $this->db->set('job_status', $this->input->post('job_status'));
        $this->db->set('job_meta_url', $validatedURL);
        $this->db->set('job_meta_title_th', $this->input->post('job_meta_title_th'));
        $this->db->set('job_meta_title_en', $this->input->post('job_meta_title_en'));
        $this->db->set('job_meta_description_th', $this->input->post('job_meta_description_th'));
        $this->db->set('job_meta_description_en', $this->input->post('job_meta_description_en'));
        $this->db->set('job_meta_keywords_th', $this->input->post('job_meta_keywords_th'));
        $this->db->set('job_meta_keywords_en', $this->input->post('job_meta_keywords_en'));
        $this->db->set('job_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('job_createdip', $this->input->ip_address());
        $this->db->insert('applicant_jobs');

        $this->reOrder( $location['location_id'] );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update( $locationid=0, $jobid=0 ){
        $message = array();
        $location = $this->get_locationinfo_byid( $locationid );
        $info = $this->get_jobinfo_byid( $jobid );

        /* Generate META URL - Start */
        $metaURL = $this->input->post('job_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'applicant_jobs', 'job_', $info['job_id'] );
        /* Generate META URL - End */

        $this->db->set('location_id', $location['location_id']);
        $this->db->set('job_title_th', $this->input->post('job_title_th'));
        $this->db->set('job_title_en', $this->input->post('job_title_en'));
        $this->db->set('job_remark_label_th', $this->input->post('job_remark_label_th'));
        $this->db->set('job_remark_label_en', $this->input->post('job_remark_label_en'));
        $this->db->set('job_responsibility_th', $this->input->post('job_responsibility_th'));
        $this->db->set('job_responsibility_en', $this->input->post('job_responsibility_en'));
        $this->db->set('job_qualification_th', $this->input->post('job_qualification_th'));
        $this->db->set('job_qualification_en', $this->input->post('job_qualification_en'));
        $this->db->set('job_start_date', date( "Y-m-d", strtotime( $this->input->post('job_start_date') ) ));
        $this->db->set('job_end_date', ( $this->input->post('job_end_date') != '' ? date( "Y-m-d", strtotime( $this->input->post('job_end_date') ) ) : null ));
        $this->db->set('job_amount', $this->input->post('job_amount'));
        $this->db->set('is_appliable', $this->input->post('is_appliable'));
        $this->db->set('is_profile_leaving', $this->input->post('is_profile_leaving'));
        $this->db->set('job_status', $this->input->post('job_status'));
        $this->db->set('job_meta_url', $validatedURL);
        $this->db->set('job_meta_title_th', $this->input->post('job_meta_title_th'));
        $this->db->set('job_meta_title_en', $this->input->post('job_meta_title_en'));
        $this->db->set('job_meta_description_th', $this->input->post('job_meta_description_th'));
        $this->db->set('job_meta_description_en', $this->input->post('job_meta_description_en'));
        $this->db->set('job_meta_keywords_th', $this->input->post('job_meta_keywords_th'));
        $this->db->set('job_meta_keywords_en', $this->input->post('job_meta_keywords_en'));
        $this->db->set('job_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('job_createdip', $this->input->ip_address());
        $this->db->where('job_id', $info['job_id']);
        $this->db->update('applicant_jobs');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $jobid=0 ){
        $message = array();
        $info = $this->get_jobinfo_byid( $jobid );

        $this->db->set('job_status', $setto);
        $this->db->set('job_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('job_updatedip', $this->input->ip_address());
        $this->db->where('job_id', $info['job_id']);
        $this->db->update('applicant_jobs');

        if( $setto == 'discard' ){
            $this->reOrder( $info['location_id'] );
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }
        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement = 'up', $jobid=0 ){
        $message = array();
        $info = $this->get_jobinfo_byid( $jobid );
        $total = $this->count_jobs( $info['location_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['job_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_jobinfo_byorder( $info['location_id'], $newOrder);
                if( isset( $exists ) && count( $exists ) > 0 ){

                    $exists_newOrder = intval( $exists['job_order'] + 1 );
                    $this->db->set('job_order', $exists_newOrder);
                    $this->db->where('job_id', $exists['job_id']);
                    $this->db->update('applicant_jobs');

                }

                $this->db->set('job_order', $newOrder);
                $this->db->set('job_updatedtime', date("Y-m-d H:i:s"));
                $this->db->set('job_updatedip', $this->input->ip_address());
                $this->db->where('job_id', $info['job_id']);
                $this->db->update('applicant_jobs');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลสำเร็จ'
                );

            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['job_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{

                $exists = $this->get_jobinfo_byorder( $info['location_id'], $newOrder);
                if( isset( $exists ) && count( $exists ) > 0 ){

                    $exists_newOrder = intval( $exists['job_order'] - 1 );
                    $this->db->set('job_order', $exists_newOrder);
                    $this->db->where('job_id', $exists['job_id']);
                    $this->db->update('applicant_jobs');

                }

                $this->db->set('job_order', $newOrder);
                $this->db->set('job_updatedtime', date("Y-m-d H:i:s"));
                $this->db->set('job_updatedip', $this->input->ip_address());
                $this->db->where('job_id', $info['job_id']);
                $this->db->update('applicant_jobs');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลสำเร็จ'
                );

            }
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }
        
        return $message;
    }
}
?>