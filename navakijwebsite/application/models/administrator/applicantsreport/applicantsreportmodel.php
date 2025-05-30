<?php
class Applicantsreportmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_locations(){
        $query = $this->db->where('locations.location_status','approved')
                            ->order_by('locations.location_order','asc')
                            ->join('applicant_jobs','applicant_jobs.location_id = locations.location_id','inner')
                            ->group_by('locations.location_id')
                            ->get('locations')
                            ->result_array();
        return $query;
    }

    public function get_locationinfo_byid( $locationid=0 ){
        $query = $this->db->where('location_id', $locationid)
                            ->get('locations')
                            ->row_array();
        return $query;
    }

    public function get_jobs( $locationid=0, $appliable=1, $leavingProfile=0 ){
        if( $locationid > 0 ){
            $query = $this->db->where('location_id', $locationid);
        }
        if( $appliable > 0 ){
            $query = $this->db->where('is_appliable', 1);
        }
        if( $leavingProfile > 0 ){
            $query = $this->db->where('is_profile_leaving', 1);
        }

        $query = $this->db->where('job_status','approved')
                            ->order_by('job_order','asc')
                            ->get('applicant_jobs')
                            ->result_array();
        return $query;
    }

    public function get_jobinfo_byid( $jobid=0 ){
        $query = $this->db->where('job_id', $jobid)
                            ->get('applicant_jobs')
                            ->row_array();
        return $query;
    }

    public function get_applicants( $aSort=array(), $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        if( isset( $aSort ) && count( $aSort ) > 0 ){
            if( $aSort['sort_location_id'] ){
                $query = $this->db->where('applicants.location_id', $aSort['sort_location_id']);
            }
            if( $aSort['sort_job_id'] ){
                $query = $this->db->where('applicants.job_id', $aSort['sort_job_id']);
            }
            if( $aSort['sort_start_date'] ){
                $startTime = '00:00:00';
                $query = $this->db->where('applicants.applicant_createdtime >=', date("Y-m-d H:i:s", strtotime( $aSort['sort_start_date'].' '.$startTime )));
            }
            if( $aSort['sort_end_date'] ){
                $endTime = '23:59:59';
                $query = $this->db->where('applicants.applicant_createdtime <=', date("Y-m-d H:i:s", strtotime( $aSort['sort_end_date'].' '.$endTime )));
            }
            if( $aSort['sort_keywords'] != '' ){
                $conditions = '(
                    applicants.applicant_fname_th like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_lname_th like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_fname_en like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_lname_en like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_tel like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_mobile like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_email like "%'.$aSort['sort_keywords'].'%"
                )';
                $query = $this->db->where( $conditions );
            }
        }

        $query = $this->db->where('applicants.applicant_status !=','discard')
                            ->join('applicant_addresses','applicants.applicant_id = applicant_addresses.applicant_id')
                            ->order_by('applicants.applicant_createdtime','desc')
                            ->group_by('applicants.applicant_id')
                            ->get('applicants')
                            ->result_array();
        return $query;
    }

    public function count_applicants( $aSort = array() ){
        if( isset( $aSort ) && count( $aSort ) > 0 ){
            if( $aSort['sort_location_id'] ){
                $query = $this->db->where('location_id', $aSort['sort_location_id']);
            }
            if( $aSort['sort_job_id'] ){
                $query = $this->db->where('job_id', $aSort['sort_job_id']);
            }
            if( $aSort['sort_start_date'] ){
                $query = $this->db->where('applicant_createdtime >=', $aSort['sort_start_date']);
            }
            if( $aSort['sort_end_date'] ){
                $query = $this->db->where('applicant_createdtime <=', $aSort['sort_end_date']);
            }
            if( $aSort['sort_keywords'] != '' ){
                $conditions = '(
                    applicants.applicant_fname_th like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_lname_th like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_fname_en like "%'.$aSort['sort_keywords'].'%" OR
                    applicants.applicant_lname_en like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_tel like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_mobile like "%'.$aSort['sort_keywords'].'%" OR
                    applicant_addresses.address_email like "%'.$aSort['sort_keywords'].'%"
                )';
                $query = $this->db->where( $conditions );
            }
        }

        $query = $this->db->where('applicants.applicant_status !=','discard')
                            ->where('applicant_addresses.address_type', 'current')
                            ->join('applicant_addresses','applicants.applicant_id = applicant_addresses.applicant_id')
                            ->order_by('applicants.applicant_createdtime','desc')
                            ->count_all_results('applicants');

        return $query;
    }

    public function get_applicantinfo_byid( $applicantid=0 ){
        $query = $this->db->where('applicant_id', $applicantid)
                            ->get('applicants')
                            ->row_array();
        return $query;
    }

    public function get_addresss( $applicantid=0, $type='' ){
        if( $type != '' ){
            $query = $this->db->where('address_type', $type)
                                ->limit(1);
        }else{
            $this->db->limit(2);
        }
        $query = $this->db->where('applicant_id', $applicantid)
                            ->order_by('address_createdtime','desc')
                            ->get('applicant_addresses')
                            ->result_array();
        return $query;
    }

    public function get_prefixes(){
        $query = $this->db->where('prefix_status','approved')
                            ->order_by('prefix_order','asc')
                            ->get('prefixes')
                            ->result_array();
        return $query;
    }

    public function get_prefixinfo_byid( $prefixid=0 ){
        $query = $this->db->where('prefix_id', $prefixid)
                            ->get('prefixes')
                            ->row_array();
        return $query;
    }

    public function get_news_sources(){
        $query = $this->db->where('source_status','approved')
                            ->order_by('source_order','asc')
                            ->get('news_sources')
                            ->result_array();
        return $query;
    }

    public function get_news_sourceinfo_byid( $sourceid=0 ){
        $query = $this->db->where('source_id', $sourceid)
                            ->get('news_sources')
                            ->row_array();
        return $query;
    }
    
    public function get_provinces(){
        $query = $this->db->where('is_actived','Y')
                            ->where('is_deleted','N')
                            ->order_by('province_id','asc')
                            ->get('province')
                            ->result_array();
        return $query;
    }

    public function get_provinceinfo_byid( $provinceid=0 ){
        $query = $this->db->where('province_id', $provinceid)
                            ->get('province')
                            ->row_array();
        return $query;
    }

    public function get_districts( $provinceid=0 ){
        if( $provinceid > 0 ){
            $query = $this->db->where('province_id', $provinceid);
        }
        $query = $this->db->where('is_actived','Y')
                            ->where('is_deleted','N')
                            ->order_by('code','asc')
                            ->get('amphoe')
                            ->result_array();
        return $query;
    }

    public function get_districtinfo_byid( $districtid=0 ){
        $query = $this->db->where('amphoe_id', $districtid)
                            ->get('amphoe')
                            ->row_array();
        return $query;
    }

    public function get_subdistricts( $districtid=0 ){
        if( $districtid > 0 ){
            $query = $this->db->where('amphoe_id', $districtid);
        }
        $query = $this->db->where('is_actived','Y')
                            ->where('is_deleted','N')
                            ->order_by('code','asc')
                            ->get('tambon')
                            ->result_array();
        return $query;
    }

    public function get_subdistrictinfo_byid( $subdistrictid=0 ){
        $query = $this->db->where('tambon_id', $subdistrictid)
                            ->get('tambon')
                            ->row_array();
        return $query;
    }

    public function get_zipcodes( $subdistrictid=0 ){
        if( $subdistrictid > 0 ){
            $query = $this->db->where('postcode_tambon.tambon_id', $subdistrictid);
        }
        $query = $this->db->where('postcode_tambon.is_actived','Y')
                            ->where('postcode_tambon.is_deleted','N')
                            ->join('postcode','postcode_tambon.postcode_id = postcode.postcode_id','inner')
                            ->order_by('postcode','asc')
                            ->get('postcode_tambon')
                            ->result_array();
        return $query;
    }

    public function get_postcodeinfo_byid( $postcodeid=0 ){
        $query = $this->db->where('postcode_id', $postcodeid)
                            ->get('postcode')
                            ->row_array();
        return $query;
    }

    public function setStatus( $setto='approved', $applicantid=0 ){
        $message = array();
        $info = $this->get_applicantinfo_byid ( $applicantid );

        $this->db->set('applicant_status', $setto);
        $this->db->set('applicant_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('applicant_updatedip', $this->input->ip_address());
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->update('applicants');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setEdit( $setto='disabled', $applicantid=0 ){
        $message = array();
        $this->load->library('uuid');
        $info = $this->get_applicantinfo_byid( $applicantid );

        if( $setto == 'enabled' ){
            $uuid = $this->uuid->v4( false );

            $this->db->set('is_editable', 1);
            $this->db->set('applicant_status','request_edit');
            $this->db->set('applicant_uuid', strtoupper( $uuid ));
            $this->db->where('applicant_id', $info['applicant_id']);
            $this->db->update('applicants');

            $message['text'] = 'ตั้งค่าสถานะแก้ไขสำเร็จ';
        }else{
            $this->db->set('is_editable', null);
            $this->db->set('applicant_status','pending');
            $this->db->set('applicant_uuid', null);
            $this->db->where('applicant_id', $info['applicant_id']);
            $this->db->update('applicants');

            $message['text'] = 'ปิดการตั้งค่าสถานะแก้ไข';
        }

        $message['status'] ='message-success';
        $message['payLoads'] = [
            'applicant_id' => $info['applicant_id']
        ];

        return $message;
    }

    public function get_languages( $applicantid=0 ){
        $query = $this->db->where('applicant_id', $applicantid)
                            ->order_by('language_createdtime','desc')
                            ->get('applicant_language_skills')
                            ->result_array();
        return $query;
    }

    public function get_experiences( $applicantid=0 ){
        $query = $this->db->where('applicant_id', $applicantid)
                            ->order_by('experience_createdtime','desc')
                            ->get('applicant_experiences')
                            ->result_array();
        return $query;
    }

    public function stamp_printed( $applicantid=0 ){
        $info = $this->get_applicantinfo_byid( $applicantid );

        $this->db->set('is_print', 1);
        $this->db->set('applicant_printedtime', date('Y-m-d H:i:s'));
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->update('applicants');
    }

    public function get_profiles( $aSort=array(), $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        if( isset( $aSort ) && count( $aSort ) > 0 ){
            if( $aSort['sort_job_id'] ){
                $query = $this->db->where('leaving_profile.job_id', $aSort['sort_job_id']);
            }
            if( $aSort['sort_start_date'] ){
                $startTime = '00:00:00';
                $query = $this->db->where('leaving_profile.profile_createdtime >=', date("Y-m-d H:i:s", strtotime( $aSort['sort_start_date'].' '.$startTime )));
            }
            if( $aSort['sort_end_date'] ){
                $endTime = '23:59:59';
                $query = $this->db->where('leaving_profile.profile_createdtime <=', date("Y-m-d H:i:s", strtotime( $aSort['sort_end_date'].' '.$endTime )));
            }
            if( $aSort['sort_keywords'] != '' ){
                $conditions = '(
                    leaving_profile.profile_name like "%'.$aSort['sort_keywords'].'%" OR
                    leaving_profile.profile_mobile like "%'.$aSort['sort_keywords'].'%" OR
                    leaving_profile.profile_email like "%'.$aSort['sort_keywords'].'%"
                )';
                $query = $this->db->where( $conditions );
            }
        }

        $query = $this->db->where('leaving_profile.profile_status !=','discard')
                            ->order_by('leaving_profile.profile_createdtime','desc')
                            ->get('leaving_profile')
                            ->result_array();
        return $query;
    }

    public function count_profiles( $aSort=array() ){
        if( isset( $aSort ) && count( $aSort ) > 0 ){
            if( $aSort['sort_job_id'] ){
                $query = $this->db->where('leaving_profile.job_id', $aSort['sort_job_id']);
            }
            if( $aSort['sort_start_date'] ){
                $startTime = '00:00:00';
                $query = $this->db->where('leaving_profile.profile_createdtime >=', date("Y-m-d H:i:s", strtotime( $aSort['sort_start_date'].' '.$startTime )));
            }
            if( $aSort['sort_end_date'] ){
                $endTime = '23:59:59';
                $query = $this->db->where('leaving_profile.profile_createdtime <=', date("Y-m-d H:i:s", strtotime( $aSort['sort_end_date'].' '.$endTime )));
            }
            if( $aSort['sort_keywords'] != '' ){
                $conditions = '(
                    leaving_profile.profile_name like "%'.$aSort['sort_keywords'].'%" OR
                    leaving_profile.profile_mobile like "%'.$aSort['sort_keywords'].'%" OR
                    leaving_profile.profile_email like "%'.$aSort['sort_keywords'].'%"
                )';
                $query = $this->db->where( $conditions );
            }
        }

        $query = $this->db->where('leaving_profile.profile_status !=','discard')
                            ->order_by('leaving_profile.profile_createdtime','desc')
                            ->count_all_results('leaving_profile');
        return $query;
    }

    public function get_profileinfo_byid( $profileid=0 ){
        $query = $this->db->where('profile_id', $profileid)
                            ->get('leaving_profile')
                            ->row_array();
        return $query;
    }

    public function setProfileStatus( $setto='approved', $profileid=0 ){
        $message = array();
        $info = $this->get_profileinfo_byid ( $profileid );

        $this->db->set('profile_status', $setto);
        $this->db->set('profile_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('profile_updatedip', $this->input->ip_address());
        $this->db->where('profile_id', $info['profile_id']);
        $this->db->update('leaving_profile');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

}
?>