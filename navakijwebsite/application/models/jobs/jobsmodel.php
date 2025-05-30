<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobsmodel extends CI_Model {

    public function __construct(){
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

    public function get_applicantinfo_byuuid( $uuid='' ){
        if( $uuid != '' ){
            $query = $this->db->where('applicant_uuid', $uuid)
                                ->where('is_editable', 1)
                                ->get('applicants')
                                ->row_array();
        }else{
            $query = array();
        }

        return $query;
    }

    public function get_employees(){
        $query = $this->db->where('employee_status','approved')
                            ->limit(3)
                            ->order_by('employee_order','random')
                            ->get('employees')
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

    public function get_news_sources(){
        $query = $this->db->where('source_status','approved')
                            ->order_by('source_order','asc')
                            ->get('news_sources')
                            ->result_array();
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

    public function get_districts( $provinceid=0 ){
        $query = $this->db->where('province_id', $provinceid)
                            ->where('is_actived','Y')
                            ->where('is_deleted','N')
                            ->order_by('code','asc')
                            ->get('amphoe')
                            ->result_array();
        return $query;
    }

    public function get_subdistricts( $districtid=0 ){
        $query = $this->db->where('amphoe_id', $districtid)
                            ->where('is_actived','Y')
                            ->where('is_deleted','N')
                            ->order_by('code','asc')
                            ->get('tambon')
                            ->result_array();
        return $query;
    }

    public function get_zipcodes( $subdistrictid=0 ){
        $query = $this->db->where('postcode_tambon.tambon_id', $subdistrictid)
                            ->where('postcode_tambon.is_actived','Y')
                            ->where('postcode_tambon.is_deleted','N')
                            ->join('postcode','postcode_tambon.postcode_id = postcode.postcode_id','inner')
                            ->order_by('postcode','asc')
                            ->get('postcode_tambon')
                            ->result_array();
        return $query;
    }

    public function get_applicantinfo_byid( $applicantId=0 ){
        $query = $this->db->where('applicants.applicant_id', $applicantId)
                            ->where('applicant_addresses.address_type', 'current')
                            ->join('applicant_addresses','applicants.applicant_id = applicant_addresses.applicant_id', 'inner')
                            ->get('applicants')
                            ->row_array();
        return $query;
    }

    public function get_address( $applicantid=0, $type='' ){
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

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/applicants';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|gif|xls|xlsx';
        $config['max_size'] = 51200;
        $config['encrypt_name'] = true;
                    
        $file_1 = $this->uploadmodel->do_upload($config, 'applicant_file_1', $_FILES['applicant_file_1']);
        $file_2 = $this->uploadmodel->do_upload($config, 'applicant_file_2', $_FILES['applicant_file_2']);
        $file_3 = $this->uploadmodel->do_upload($config, 'applicant_file_3', $_FILES['applicant_file_3']);
        /* Upload - End */

        // print_r( $aLanguages );
        // print_r( $this->input->post() );
        // exit();
        
        /* Personal information - Start */
        $this->db->set('location_id', (int) $this->input->post('location_id'));
        $this->db->set('job_id', (int) $this->input->post('job_id'));
        $this->db->set('applicant_salary', $this->input->post('applicant_salary'));
        $this->db->set('prefix_id', (int) $this->input->post('prefix_id'));
        $this->db->set('applicant_fname_th', $this->input->post('applicant_fname_th'));
        $this->db->set('applicant_lname_th', $this->input->post('applicant_lname_th'));
        $this->db->set('applicant_fname_en', $this->input->post('applicant_fname_en'));
        $this->db->set('applicant_lname_en', $this->input->post('applicant_lname_en'));
        $this->db->set('applicant_birthdate', ( $this->input->post('applicant_birthdate') != '' ? date("Y-m-d", strtotime( $this->input->post('applicant_birthdate') )) : null ));
        $this->db->set('applicant_idcard', $this->input->post('applicant_idcard'));
        $this->db->set('applicant_idcard_expired', ( $this->input->post('applicant_idcard_expired') != '' ? date("Y-m-d" , strtotime( $this->input->post('applicant_idcard_expired') )) : null ));
        $this->db->set('applicant_height', floatval($this->input->post('applicant_height')));
        $this->db->set('applicant_weight', floatval($this->input->post('applicant_weight')));
        $this->db->set('applicant_military_status', ( !$this->input->post('applicant_military_status') ? null : $this->input->post('applicant_military_status') ));
        /* Personal Information - End */

        /* Announcement Source - Start */
        $this->db->set('applicant_news_source_id', (int) $this->input->post('applicant_news_source_id'));
        $this->db->set('applicant_applied_status', $this->input->post('applicant_applied_status'));
        $this->db->set('applicant_applied_year', $this->input->post('applicant_applied_year'));
        $this->db->set('applicant_accident_status', $this->input->post('applicant_accident_status'));
        /* Announcement Source - End */

        /* Education - Start */
        $this->db->set('applicant_studying_status', $this->input->post('applicant_studying_status'));

            /* High School - Start */
            $this->db->set('applicant_education_highschool_name', $this->input->post('applicant_education_highschool_name'));
            $this->db->set('applicant_education_highschool_province_id', (int) $this->input->post('applicant_education_highschool_province_id'));
            $this->db->set('applicant_education_highschool_year', $this->input->post('applicant_education_highschool_year'));
            $this->db->set('applicant_education_highschool_major', $this->input->post('applicant_education_highschool_major'));
            $this->db->set('applicant_education_highschool_gpa', floatval($this->input->post('applicant_education_highschool_gpa')));
            /* High School - End */

            /* Vocational - Start */
            $this->db->set('applicant_education_vocational_name', $this->input->post('applicant_education_vocational_name'));
            $this->db->set('applicant_education_vocational_province_id', (int) $this->input->post('applicant_education_vocational_province_id'));
            $this->db->set('applicant_education_vocational_year', $this->input->post('applicant_education_vocational_year'));
            $this->db->set('applicant_education_vocational_major', $this->input->post('applicant_education_vocational_major'));
            $this->db->set('applicant_education_vocational_gpa', floatval($this->input->post('applicant_education_vocational_gpa')));
            /* Vocational - End */

            /* Diploma - Start */
            $this->db->set('applicant_education_diploma_name', $this->input->post('applicant_education_diploma_name'));
            $this->db->set('applicant_education_diploma_province_id', (int) $this->input->post('applicant_education_diploma_province_id'));
            $this->db->set('applicant_education_diploma_year', $this->input->post('applicant_education_diploma_year'));
            $this->db->set('applicant_education_diploma_major', $this->input->post('applicant_education_diploma_major'));
            $this->db->set('applicant_education_diploma_gpa', floatval($this->input->post('applicant_education_diploma_gpa')));
            /* Diploma - End */

            /* Bachelor - Start */
            $this->db->set('applicant_education_bachelor_name', $this->input->post('applicant_education_bachelor_name'));
            $this->db->set('applicant_education_bachelor_province_id', (int) $this->input->post('applicant_education_bachelor_province_id'));
            $this->db->set('applicant_education_bachelor_year', $this->input->post('applicant_education_bachelor_year'));
            $this->db->set('applicant_education_bachelor_major', $this->input->post('applicant_education_bachelor_major'));
            $this->db->set('applicant_education_bachelor_gpa', floatval($this->input->post('applicant_education_bachelor_gpa')));
            /* Bachelor - End */

            /* Master - Start */
            $this->db->set('applicant_education_master_name', $this->input->post('applicant_education_master_name'));
            $this->db->set('applicant_education_master_province_id', (int) $this->input->post('applicant_education_master_province_id'));
            $this->db->set('applicant_education_master_year', $this->input->post('applicant_education_master_year'));
            $this->db->set('applicant_education_master_major', $this->input->post('applicant_education_master_major'));
            $this->db->set('applicant_education_master_gpa', floatval($this->input->post('applicant_education_master_gpa')));
            /* Master - End */

            /* Other - Start */
            $this->db->set('applicant_education_other_name', $this->input->post('applicant_education_other_name'));
            $this->db->set('applicant_education_other_province_id', (int) $this->input->post('applicant_education_other_province_id'));
            $this->db->set('applicant_education_other_year', $this->input->post('applicant_education_other_year'));
            $this->db->set('applicant_education_other_major', $this->input->post('applicant_education_other_major'));
            $this->db->set('applicant_education_other_gpa', floatval($this->input->post('applicant_education_other_gpa')));
            /* Other - End */

        /* Education - End */

        /* Skills - Start */
        $this->db->set('applicant_skill_computer', $this->input->post('applicant_skill_computer'));
        $this->db->set('applicant_skill_typing_thai', (int) $this->input->post('applicant_skill_typing_thai'));
        $this->db->set('applicant_skill_typing_english', (int) $this->input->post('applicant_skill_typing_english'));
        $this->db->set('applicant_skill_office_tools', $this->input->post('applicant_skill_office_tools'));
        $this->db->set('applicant_skill_specials', $this->input->post('applicant_skill_specials'));
        $this->db->set('applicant_skill_activities', $this->input->post('applicant_skill_activities'));
        $this->db->set('applicant_skill_driving_status', $this->input->post('applicant_skill_driving_status'));
        $this->db->set('applicant_skill_driving_license', $this->input->post('applicant_skill_driving_license'));
        $this->db->set('applicant_skill_riding_status', $this->input->post('applicant_skill_riding_status'));
        $this->db->set('applicant_skill_riding_license', $this->input->post('applicant_skill_riding_license'));
        /* Skills - End */

        /* Experiences - Start */
        $this->db->set('applicant_experienced_status', $this->input->post('applicant_experienced_status'));
        /* Experiences - End */

        /* Introduction - Start */
        $this->db->set('applicant_introduction', $this->input->post('applicant_introduction'));
        /* Introduction - End */

        /* Files - Start */
        $this->db->set('applicant_file_1', $file_1);
        $this->db->set('applicant_file_2', $file_2);
        $this->db->set('applicant_file_3', $file_3);
        /* Files - End */

        /* Consent & Agreement - Start */
        $this->db->set( 'applicant_forbidden_person', $this->input->post('applicant_forbidden_person') );
        $this->db->set( 'applicant_broker', $this->input->post('applicant_broker') );
        $this->db->set( 'applicant_revoked', $this->input->post('applicant_revoked') );
        $this->db->set( 'applicant_pdpa_consent', $this->input->post('applicant_pdpa_consent') );
        $this->db->set( 'applicant_agreement', $this->input->post('applicant_consent') );
        $this->db->set( 'applicant_signed_name', $this->input->post('applicant_signed_name'));
        /* Consent & Agreement - End */

        /* Date & Time - Start */
        $this->db->set('applicant_status','pending');
        $this->db->set('applicant_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('applicant_createdip', $this->input->ip_address());
        $this->db->insert('applicants');
        $applicantId = $this->db->insert_id();
        /* Date & Time - End */

        /* Addresses - Start */
        $this->db->set('applicant_id', $applicantId);
        $this->db->set('address_type', 'current');
        $this->db->set('address_no', $this->input->post('applicant_current_address_no'));
        $this->db->set('address_building', $this->input->post('applicant_current_village'));
        $this->db->set('address_avenue', $this->input->post('applicant_current_avenue'));
        $this->db->set('address_street', $this->input->post('applicant_current_road'));
        $this->db->set('province_id', (int) $this->input->post('applicant_current_province_id'));
        $this->db->set('district_id', (int) $this->input->post('applicant_current_district_id'));
        $this->db->set('subdistrict_id', (int) $this->input->post('applicant_current_subdistrict_id'));
        $this->db->set('postcode_id', (int) $this->input->post('applicant_current_postcode_id'));
        $this->db->set('address_tel', $this->input->post('applicant_current_telephone'));
        $this->db->set('address_mobile', $this->input->post('applicant_current_mobile'));
        $this->db->set('address_email', $this->input->post('applicant_current_email'));
        $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('address_createdip', $this->input->ip_address());
        $this->db->insert('applicant_addresses');

        /* Register Address - Start */
        if( $this->input->post('applicant_register_same_address') != 1 ){ //Case register address is different with current address
            $this->db->set('applicant_id', $applicantId);
            $this->db->set('address_type', 'registration');
            $this->db->set('address_no', $this->input->post('applicant_register_address_no'));
            $this->db->set('address_building', $this->input->post('applicant_register_village'));
            $this->db->set('address_avenue', $this->input->post('applicant_register_avenue'));
            $this->db->set('address_street', $this->input->post('applicant_register_road'));
            $this->db->set('province_id', (int) $this->input->post('applicant_register_province_id'));
            $this->db->set('district_id', (int) $this->input->post('applicant_register_district_id'));
            $this->db->set('subdistrict_id', (int) $this->input->post('applicant_register_subdistrict_id'));
            $this->db->set('postcode_id', (int) $this->input->post('applicant_register_postcode_id'));
            $this->db->set('address_tel', $this->input->post('applicant_register_telephone'));
            $this->db->set('address_mobile', $this->input->post('applicant_register_mobile'));
            $this->db->set('address_email', $this->input->post('applicant_register_email'));
            $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
            $this->db->set('address_createdip', $this->input->ip_address());
            $this->db->insert('applicant_addresses');
        }else{
            $this->db->set('applicant_id', $applicantId);
            $this->db->set('address_type', 'registration');
            $this->db->set('address_no', $this->input->post('applicant_current_address_no'));
            $this->db->set('address_building', $this->input->post('applicant_current_village'));
            $this->db->set('address_avenue', $this->input->post('applicant_current_avenue'));
            $this->db->set('address_street', $this->input->post('applicant_current_road'));
            $this->db->set('province_id', (int) $this->input->post('applicant_current_province_id'));
            $this->db->set('district_id', (int) $this->input->post('applicant_current_district_id'));
            $this->db->set('subdistrict_id', (int) $this->input->post('applicant_current_subdistrict_id'));
            $this->db->set('postcode_id', (int) $this->input->post('applicant_current_postcode_id'));
            $this->db->set('address_tel', $this->input->post('applicant_current_telephone'));
            $this->db->set('address_mobile', $this->input->post('applicant_current_mobile'));
            $this->db->set('address_email', $this->input->post('applicant_current_email'));
            $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
            $this->db->set('address_createdip', $this->input->ip_address());
            $this->db->insert('applicant_addresses');
        }
        /* Register Address - End */
        /* Addresses - End */

        /* Languages - Start */

        // print_r( $this->input->post('applicant_skill_languages') );
        // exit();
        if( $this->input->post('applicant_skill_languages') && count( $this->input->post('applicant_skill_languages') ) > 0 && $applicantId ){
            $aLanguages = array();
            foreach( $this->input->post('applicant_skill_languages') as $index => $groups ){
                foreach( $groups as $key => $data ){
                    $aLanguages[$key][$index] = $data;
                }
            }
            
            foreach( $aLanguages as $groups ){
                // echo $groups['name'].'<br />';
                if( $groups['name'] != '' ){
                    $this->db->set('applicant_id', $applicantId);
                    $this->db->set('language_name', ( !$groups['name'] ? null : $groups['name'] ));
                    $this->db->set('language_listen', ( !$groups['listen'] ? null : $groups['listen'] ));
                    $this->db->set('language_speaking', ( !$groups['speaking'] ? null : $groups['speaking'] ));
                    $this->db->set('language_reading', ( !$groups['reading'] ? null : $groups['reading'] ));
                    $this->db->set('language_writing', ( !$groups['writing'] ? null : $groups['writing'] ));
                    $this->db->set('language_createdtime', date("Y-m-d H:i:s"));
                    $this->db->set('language_createdip', $this->input->ip_address());
                    $this->db->insert('applicant_language_skills');
                }
            }

            // exit();

        }
        /* Languages - End */

        /* Experiences - Start */
        if( $this->input->post('applicant_experiences') && count( $this->input->post('applicant_experiences') ) > 0 && $applicantId ){
            $aExperiences = array();
            foreach( $this->input->post('applicant_experiences') as $index => $experiences ){
                foreach( $experiences as $key => $data ){
                    $aExperiences[$key][$index] = $data;
                }
            }

            foreach( $aExperiences as $experiences ){
                if( $experiences['company_name'] != '' ){
                    $this->db->set('applicant_id', $applicantId);
                    $this->db->set('experience_company_name', ( !$experiences['company_name'] ? null : $experiences['company_name'] ));
                    $this->db->set('experience_company_address', ( !$experiences['company_address'] ? null : $experiences['company_address'] ));
                    $this->db->set('experience_company_tel', ( !$experiences['company_tel'] ? null : $experiences['company_tel'] ));
                    $this->db->set('experience_start', ( !$experiences['start'] ? null : date("Y-m-d", strtotime( $experiences['start'] )) ));
                    $this->db->set('experience_end', ( !$experiences['end'] ? null : date("Y-m-d", strtotime( $experiences['end'] )) ));
                    $this->db->set('experience_superior', ( !$experiences['superior'] ? null : $experiences['superior'] ));
                    $this->db->set('experience_job_description', ( !$experiences['responsibility'] ? null : $experiences['responsibility'] ));
                    $this->db->set('experience_salary', ( !$experiences['salary'] ? 0 : $experiences['salary'] ));
                    $this->db->set('experience_cost_of_living', ( !$experiences['cost_of_living'] ? 0 : $experiences['cost_of_living'] ));
                    $this->db->set('experience_bonus', ( !$experiences['bonus'] ? 0 : $experiences['bonus'] ));
                    $this->db->set('experience_other', ( !$experiences['other'] ? 0 : $experiences['other'] ));
                    $this->db->set('experience_total', ( !$experiences['total'] ? 0 : $experiences['total'] ));
                    $this->db->set('experience_reason', ( !$experiences['reason'] ? null : $experiences['reason'] ));
                    $this->db->set('experience_createdtime', date("Y-m-d H:i:s"));
                    $this->db->set('experience_createdip', $this->input->ip_address());
                    $this->db->insert('applicant_experiences');
                }
            }
        }
        /* Experiences - End */

        if( $applicantId ){
            $message = array(
                'status' => 'message-success',
                'text' => 'บันทึกข้อมูลสำเร็จ',
                'payLoads' => [
                    'applicant_id' => $applicantId
                ]
            );
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
            );
        }

        return $message;
        
    }

    public function update( $applicantid=0 ){
        $info = $this->get_applicantinfo_byid( $applicantid );
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/applicants';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|gif|xls|xlsx';
        $config['max_size'] = 51200;
        $config['encrypt_name'] = true;
                    
        $file_1 = $this->uploadmodel->edit_upload($config, 'applicant_file_1', $_FILES['applicant_file_1'], $info['applicant_file_1']);
        $file_2 = $this->uploadmodel->edit_upload($config, 'applicant_file_2', $_FILES['applicant_file_2'], $info['applicant_file_2']);
        $file_3 = $this->uploadmodel->edit_upload($config, 'applicant_file_3', $_FILES['applicant_file_3'], $info['applicant_file_3']);
        /* Upload - End */

        // print_r( $aLanguages );
        // print_r( $this->input->post() );
        // exit();
        
        /* Personal information - Start */
        $this->db->set('location_id', (int) $this->input->post('location_id'));
        $this->db->set('job_id', (int) $this->input->post('job_id'));
        $this->db->set('applicant_salary', $this->input->post('applicant_salary'));
        $this->db->set('prefix_id', (int) $this->input->post('prefix_id'));
        $this->db->set('applicant_fname_th', $this->input->post('applicant_fname_th'));
        $this->db->set('applicant_lname_th', $this->input->post('applicant_lname_th'));
        $this->db->set('applicant_fname_en', $this->input->post('applicant_fname_en'));
        $this->db->set('applicant_lname_en', $this->input->post('applicant_lname_en'));
        $this->db->set('applicant_birthdate', ( $this->input->post('applicant_birthdate') != '' ? date("Y-m-d", strtotime( $this->input->post('applicant_birthdate') )) : null ));
        $this->db->set('applicant_idcard', $this->input->post('applicant_idcard'));
        $this->db->set('applicant_idcard_expired', ( $this->input->post('applicant_idcard_expired') != '' ? date("Y-m-d" , strtotime( $this->input->post('applicant_idcard_expired') )) : null ));
        $this->db->set('applicant_height', floatval($this->input->post('applicant_height')));
        $this->db->set('applicant_weight', floatval($this->input->post('applicant_weight')));
        $this->db->set('applicant_military_status', ( !$this->input->post('applicant_military_status') ? null : $this->input->post('applicant_military_status') ));
        /* Personal Information - End */

        /* Announcement Source - Start */
        $this->db->set('applicant_news_source_id', (int) $this->input->post('applicant_news_source_id'));
        $this->db->set('applicant_applied_status', $this->input->post('applicant_applied_status'));
        $this->db->set('applicant_applied_year', $this->input->post('applicant_applied_year'));
        $this->db->set('applicant_accident_status', $this->input->post('applicant_accident_status'));
        /* Announcement Source - End */

        /* Education - Start */
        $this->db->set('applicant_studying_status', $this->input->post('applicant_studying_status'));

            /* High School - Start */
            $this->db->set('applicant_education_highschool_name', $this->input->post('applicant_education_highschool_name'));
            $this->db->set('applicant_education_highschool_province_id', (int) $this->input->post('applicant_education_highschool_province_id'));
            $this->db->set('applicant_education_highschool_year', $this->input->post('applicant_education_highschool_year'));
            $this->db->set('applicant_education_highschool_major', $this->input->post('applicant_education_highschool_major'));
            $this->db->set('applicant_education_highschool_gpa', floatval($this->input->post('applicant_education_highschool_gpa')));
            /* High School - End */

            /* Vocational - Start */
            $this->db->set('applicant_education_vocational_name', $this->input->post('applicant_education_vocational_name'));
            $this->db->set('applicant_education_vocational_province_id', (int) $this->input->post('applicant_education_vocational_province_id'));
            $this->db->set('applicant_education_vocational_year', $this->input->post('applicant_education_vocational_year'));
            $this->db->set('applicant_education_vocational_major', $this->input->post('applicant_education_vocational_major'));
            $this->db->set('applicant_education_vocational_gpa', floatval($this->input->post('applicant_education_vocational_gpa')));
            /* Vocational - End */

            /* Diploma - Start */
            $this->db->set('applicant_education_diploma_name', $this->input->post('applicant_education_diploma_name'));
            $this->db->set('applicant_education_diploma_province_id', (int) $this->input->post('applicant_education_diploma_province_id'));
            $this->db->set('applicant_education_diploma_year', $this->input->post('applicant_education_diploma_year'));
            $this->db->set('applicant_education_diploma_major', $this->input->post('applicant_education_diploma_major'));
            $this->db->set('applicant_education_diploma_gpa', floatval($this->input->post('applicant_education_diploma_gpa')));
            /* Diploma - End */

            /* Bachelor - Start */
            $this->db->set('applicant_education_bachelor_name', $this->input->post('applicant_education_bachelor_name'));
            $this->db->set('applicant_education_bachelor_province_id', (int) $this->input->post('applicant_education_bachelor_province_id'));
            $this->db->set('applicant_education_bachelor_year', $this->input->post('applicant_education_bachelor_year'));
            $this->db->set('applicant_education_bachelor_major', $this->input->post('applicant_education_bachelor_major'));
            $this->db->set('applicant_education_bachelor_gpa', floatval($this->input->post('applicant_education_bachelor_gpa')));
            /* Bachelor - End */

            /* Master - Start */
            $this->db->set('applicant_education_master_name', $this->input->post('applicant_education_master_name'));
            $this->db->set('applicant_education_master_province_id', (int) $this->input->post('applicant_education_master_province_id'));
            $this->db->set('applicant_education_master_year', $this->input->post('applicant_education_master_year'));
            $this->db->set('applicant_education_master_major', $this->input->post('applicant_education_master_major'));
            $this->db->set('applicant_education_master_gpa', floatval($this->input->post('applicant_education_master_gpa')));
            /* Master - End */

            /* Other - Start */
            $this->db->set('applicant_education_other_name', $this->input->post('applicant_education_other_name'));
            $this->db->set('applicant_education_other_province_id', (int) $this->input->post('applicant_education_other_province_id'));
            $this->db->set('applicant_education_other_year', $this->input->post('applicant_education_other_year'));
            $this->db->set('applicant_education_other_major', $this->input->post('applicant_education_other_major'));
            $this->db->set('applicant_education_other_gpa', floatval($this->input->post('applicant_education_other_gpa')));
            /* Other - End */

        /* Education - End */

        /* Skills - Start */
        $this->db->set('applicant_skill_computer', $this->input->post('applicant_skill_computer'));
        $this->db->set('applicant_skill_typing_thai', (int) $this->input->post('applicant_skill_typing_thai'));
        $this->db->set('applicant_skill_typing_english', (int) $this->input->post('applicant_skill_typing_english'));
        $this->db->set('applicant_skill_office_tools', $this->input->post('applicant_skill_office_tools'));
        $this->db->set('applicant_skill_specials', $this->input->post('applicant_skill_specials'));
        $this->db->set('applicant_skill_activities', $this->input->post('applicant_skill_activities'));
        $this->db->set('applicant_skill_driving_status', $this->input->post('applicant_skill_driving_status'));
        $this->db->set('applicant_skill_driving_license', $this->input->post('applicant_skill_driving_license'));
        $this->db->set('applicant_skill_riding_status', $this->input->post('applicant_skill_riding_status'));
        $this->db->set('applicant_skill_riding_license', $this->input->post('applicant_skill_riding_license'));
        /* Skills - End */

        /* Experiences - Start */
        $this->db->set('applicant_experienced_status', $this->input->post('applicant_experienced_status'));
        /* Experiences - End */

        /* Introduction - Start */
        $this->db->set('applicant_introduction', $this->input->post('applicant_introduction'));
        /* Introduction - End */

        /* Files - Start */
        $this->db->set('applicant_file_1', $file_1);
        $this->db->set('applicant_file_2', $file_2);
        $this->db->set('applicant_file_3', $file_3);
        /* Files - End */

        /* Consent & Agreement - Start */
        $this->db->set( 'applicant_forbidden_person', $this->input->post('applicant_forbidden_person') );
        $this->db->set( 'applicant_broker', $this->input->post('applicant_broker') );
        $this->db->set( 'applicant_revoked', $this->input->post('applicant_revoked') );
        $this->db->set( 'applicant_pdpa_consent', $this->input->post('applicant_pdpa_consent') );
        $this->db->set( 'applicant_agreement', $this->input->post('applicant_consent') );
        $this->db->set( 'applicant_signed_name', $this->input->post('applicant_signed_name'));
        /* Consent & Agreement - End */

        /* Date & Time - Start */
        $this->db->set('is_editable', 0);
        $this->db->set('applicant_status','pending');
        $this->db->set('applicant_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('applicant_updatedip', $this->input->ip_address());
        $this->db->set('applicant_editedtime', date("Y-m-d H:i:s"));
        $this->db->set('applicant_editedip', $this->input->ip_address());
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->update('applicants');
        $applicantId = $info['applicant_id'];
        // $this->db->insert('applicants');
        // $applicantId = $this->db->insert_id();
        /* Date & Time - End */

        /* Delete Addresses Record by `applicant_id` - Start */
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->delete('applicant_addresses');
        /* Delete Addresses Record by `applicant_id` - End */

        /* Addresses - Start */
        $this->db->set('applicant_id', $applicantId);
        $this->db->set('address_type', 'current');
        $this->db->set('address_no', $this->input->post('applicant_current_address_no'));
        $this->db->set('address_building', $this->input->post('applicant_current_village'));
        $this->db->set('address_avenue', $this->input->post('applicant_current_avenue'));
        $this->db->set('address_street', $this->input->post('applicant_current_road'));
        $this->db->set('province_id', (int) $this->input->post('applicant_current_province_id'));
        $this->db->set('district_id', (int) $this->input->post('applicant_current_district_id'));
        $this->db->set('subdistrict_id', (int) $this->input->post('applicant_current_subdistrict_id'));
        $this->db->set('postcode_id', (int) $this->input->post('applicant_current_postcode_id'));
        $this->db->set('address_tel', $this->input->post('applicant_current_telephone'));
        $this->db->set('address_mobile', $this->input->post('applicant_current_mobile'));
        $this->db->set('address_email', $this->input->post('applicant_current_email'));
        $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('address_createdip', $this->input->ip_address());
        $this->db->insert('applicant_addresses');

        $this->db->set('applicant_id', $applicantId);
        $this->db->set('address_type', 'registration');
        $this->db->set('address_no', $this->input->post('applicant_current_address_no'));
        $this->db->set('address_building', $this->input->post('applicant_current_village'));
        $this->db->set('address_avenue', $this->input->post('applicant_current_avenue'));
        $this->db->set('address_street', $this->input->post('applicant_current_road'));
        $this->db->set('province_id', (int) $this->input->post('applicant_current_province_id'));
        $this->db->set('district_id', (int) $this->input->post('applicant_current_district_id'));
        $this->db->set('subdistrict_id', (int) $this->input->post('applicant_current_subdistrict_id'));
        $this->db->set('postcode_id', (int) $this->input->post('applicant_current_postcode_id'));
        $this->db->set('address_tel', $this->input->post('applicant_current_telephone'));
        $this->db->set('address_mobile', $this->input->post('applicant_current_mobile'));
        $this->db->set('address_email', $this->input->post('applicant_current_email'));
        $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('address_createdip', $this->input->ip_address());
        $this->db->insert('applicant_addresses');

        /* Register Address - Start */
        // if( $this->input->post('applicant_register_same_address') != 1 ){ //Case register address is different with current address
        //     $this->db->set('applicant_id', $applicantId);
        //     $this->db->set('address_type', 'registration');
        //     $this->db->set('address_no', $this->input->post('applicant_register_address_no'));
        //     $this->db->set('address_building', $this->input->post('applicant_register_village'));
        //     $this->db->set('address_avenue', $this->input->post('applicant_register_avenue'));
        //     $this->db->set('address_street', $this->input->post('applicant_register_road'));
        //     $this->db->set('province_id', (int) $this->input->post('applicant_register_province_id'));
        //     $this->db->set('district_id', (int) $this->input->post('applicant_register_district_id'));
        //     $this->db->set('subdistrict_id', (int) $this->input->post('applicant_register_subdistrict_id'));
        //     $this->db->set('postcode_id', (int) $this->input->post('applicant_register_postcode_id'));
        //     $this->db->set('address_tel', $this->input->post('applicant_register_telephone'));
        //     $this->db->set('address_mobile', $this->input->post('applicant_register_mobile'));
        //     $this->db->set('address_email', $this->input->post('applicant_register_email'));
        //     $this->db->set('address_createdtime', date("Y-m-d H:i:s"));
        //     $this->db->set('address_createdip', $this->input->ip_address());
        //     $this->db->insert('applicant_addresses');
        // }else{
            
        // }
        /* Register Address - End */
        /* Addresses - End */

        /* Languages - Start */

        // print_r( $this->input->post('applicant_skill_languages') );
        // exit();

        /* Delete `applicant_language_skills` by `applicant_id` - Start */
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->delete('applicant_language_skills');
        /* Delete `applicant_language_skills` by `applicant_id` - End */

        if( $this->input->post('applicant_skill_languages') && count( $this->input->post('applicant_skill_languages') ) > 0 && $applicantId ){
            $aLanguages = array();
            foreach( $this->input->post('applicant_skill_languages') as $index => $groups ){
                foreach( $groups as $key => $data ){
                    $aLanguages[$key][$index] = $data;
                }
            }
            
            foreach( $aLanguages as $groups ){
                // echo $groups['name'].'<br />';
                if( $groups['name'] != '' ){
                    $this->db->set('applicant_id', $applicantId);
                    $this->db->set('language_name', ( !$groups['name'] ? null : $groups['name'] ));
                    $this->db->set('language_listen', ( !$groups['listen'] ? null : $groups['listen'] ));
                    $this->db->set('language_speaking', ( !$groups['speaking'] ? null : $groups['speaking'] ));
                    $this->db->set('language_reading', ( !$groups['reading'] ? null : $groups['reading'] ));
                    $this->db->set('language_writing', ( !$groups['writing'] ? null : $groups['writing'] ));
                    $this->db->set('language_createdtime', date("Y-m-d H:i:s"));
                    $this->db->set('language_createdip', $this->input->ip_address());
                    $this->db->insert('applicant_language_skills');
                }
            }

            // exit();

        }
        /* Languages - End */

        /* Delete `applicant_experiences` - Start */
        $this->db->where('applicant_id', $info['applicant_id']);
        $this->db->delete('applicant_experiences');
        /* Delete `applicant_experiences` - End */

        /* Experiences - Start */
        if( $this->input->post('applicant_experiences') && count( $this->input->post('applicant_experiences') ) > 0 && $applicantId ){
            $aExperiences = array();
            foreach( $this->input->post('applicant_experiences') as $index => $experiences ){
                foreach( $experiences as $key => $data ){
                    $aExperiences[$key][$index] = $data;
                }
            }

            foreach( $aExperiences as $experiences ){
                if( $experiences['company_name'] != '' ){
                    $this->db->set('applicant_id', $applicantId);
                    $this->db->set('experience_company_name', ( !$experiences['company_name'] ? null : $experiences['company_name'] ));
                    $this->db->set('experience_company_address', ( !$experiences['company_address'] ? null : $experiences['company_address'] ));
                    $this->db->set('experience_company_tel', ( !$experiences['company_tel'] ? null : $experiences['company_tel'] ));
                    $this->db->set('experience_start', ( !$experiences['start'] ? null : date("Y-m-d", strtotime( $experiences['start'] )) ));
                    $this->db->set('experience_end', ( !$experiences['end'] ? null : date("Y-m-d", strtotime( $experiences['end'] )) ));
                    $this->db->set('experience_superior', ( !$experiences['superior'] ? null : $experiences['superior'] ));
                    $this->db->set('experience_job_description', ( !$experiences['responsibility'] ? null : $experiences['responsibility'] ));
                    $this->db->set('experience_salary', ( !$experiences['salary'] ? 0 : $experiences['salary'] ));
                    $this->db->set('experience_cost_of_living', ( !$experiences['cost_of_living'] ? 0 : $experiences['cost_of_living'] ));
                    $this->db->set('experience_bonus', ( !$experiences['bonus'] ? 0 : $experiences['bonus'] ));
                    $this->db->set('experience_other', ( !$experiences['other'] ? 0 : $experiences['other'] ));
                    $this->db->set('experience_total', ( !$experiences['total'] ? 0 : $experiences['total'] ));
                    $this->db->set('experience_reason', ( !$experiences['reason'] ? null : $experiences['reason'] ));
                    $this->db->set('experience_createdtime', date("Y-m-d H:i:s"));
                    $this->db->set('experience_createdip', $this->input->ip_address());
                    $this->db->insert('applicant_experiences');
                }
            }
        }
        /* Experiences - End */

        if( $applicantId ){
            $message = array(
                'status' => 'message-success',
                'text' => 'บันทึกข้อมูลสำเร็จ',
                'payLoads' => [
                    'applicant_id' => $applicantId
                ]
            );
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
            );
        }

        return $message;
        
    }

    public function saveProfile(){

        if( $this->input->post('profile_fullname') == '' ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณากรอกชื่อ-สกุล'
            );
        }else if( $this->input->post('profile_job_id') <= 0 ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณาระบุตำแหน่งงานที่สนใจ'
            );
        }else if( $this->input->post('profile_mobile') == '' ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณาระบุเบอร์ติดต่อกลับ'
            );
        }else if( $this->input->post('profile_email') == '' ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณาระบุอีเมล'
            );
        }else if( !$_FILES['profile_file'] ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณาแนบไฟล์สมัครงาน'
            );
        }else if( $this->input->post('applicant_consent') == '' ){
            $response = array(
                'status' => 500,
                'text' => 'กรุณายอมรับข้อตกลง'
            );
        }else if( $this->input->post('applicant_signed_name') == '' ){
            $response = array(
                'status' => 500,
                'text' => 'กรณาลงชื่อเพื่อยอมรับข้อตกลง'
            );
        }else{

            /* Upload - Start */
            $uploadpath = realpath('').'/public/core/uploaded/leaving_profile';
            if(is_dir($uploadpath)===false){
                mkdir($uploadpath, 0777);
                chmod($uploadpath, 0777);
            }
                        
            $config['upload_path'] = $uploadpath;
            $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|gif|xls|xlsx';
            $config['max_size'] = 51200;
            $config['encrypt_name'] = true;
                        
            $file = $this->uploadmodel->do_upload($config, 'profile_file', $_FILES['profile_file']);
            // var_dump( $_FILES );
            // print_r( $this->upload->display_errors() );
            // exit();
            /* Upload - End */

            $this->db->set('profile_name', $this->input->post('profile_fullname'));
            $this->db->set('job_id', $this->input->post('profile_job_id'));
            $this->db->set('profile_mobile', $this->input->post('profile_mobile'));
            $this->db->set('profile_email', $this->input->post('profile_email'));
            $this->db->set('profile_file', $file);
            $this->db->set('profile_createdtime', date("Y-m-d H:i:s"));
            $this->db->set('profile_createdip', $this->input->ip_address());
            $this->db->insert('leaving_profile');
            $profile_id = $this->db->insert_id();

            $response = array(
                'status' => 200,
                'profileId' => $profile_id,
                'text' => 'บันทึกข้อมูลสำเร็จ'
            );

        }

        return $response;

    }

    public function get_profileinfo_byid( $profileid=0 ){
        $query = $this->db->where('profile_id', $profileid)
                            ->where('profile_status !=','discard')
                            ->get('leaving_profile')
                            ->row_array();
        return $query;
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

}

/* End of file Jobsmodel.php */
