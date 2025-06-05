<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

    var $_data;
	var $_language;
    public function __construct(){
        parent::__construct();

        /* Settle META for SEO - Start */
		$meta_title = $this->mainmodel->get_web_setting('seo_meta_title');
		$meta_description = $this->mainmodel->get_web_setting('seo_meta_description');
		$meta_keywords = $this->mainmodel->get_web_setting('seo_meta_keyword');
        $this->_data['meta_title'] = $meta_title['setting_value'];
        $this->_data['meta_keyword'] = $meta_description['setting_value'];
        $this->_data['meta_description'] = $meta_keywords['setting_value'];
        $this->_data['meta_image'] = base_url('public/core/img/facebook_share.jpg');
        $this->_data['meta_image_width'] = 1200;
        $this->_data['meta_image_height'] = 630;
		/* Settle META for SEO -  End */
		
        $this->load->model('jobs/jobsmodel');
		$this->languagemodel->uritosession( $this->uri->uri_string() );
        $this->_language = $this->languagemodel->get_language();
        $this->load->library('pagination');
        $this->load->library('form_validation');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    

    public function index(){

        $this->_data['jobs'] = $this->jobsmodel->get_jobs();
        $this->_data['employees'] = $this->jobsmodel->get_employees();
        
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('jobs/index');
        $this->load->view('included/footer');
        
    }

    public function info( $jobid=0 ){

        $info = $this->jobsmodel->get_jobinfo_byid( $jobid );
        $this->_data['meta_title'] = ( $info['job_meta_title_'.$this->_language] != '' ? $info['job_meta_title_'.$this->_language] : $this->_data['meta_title'] );
        $this->_data['meta_keyword'] = ( $info['job_meta_keywords_'.$this->_language] != '' ? $info['job_meta_keywords_'.$this->_language] : $this->_data['meta_keyword'] );
        $this->_data['meta_description'] = ( $info['job_meta_description_'.$this->_language] != '' ? $info['job_meta_description_'.$this->_language] : $this->_data['meta_description'] );
        $this->_data['info'] = $info;

        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('jobs/info');
        $this->load->view('included/footer');

    }

    public function applicant( $jobid=0 ){

        /* Language File loaded - Start */
        $this->lang->load('jobs_applicant', $this->_language);
        /* Language File loaded - End */

        $this->form_validation->set_rules('location_id','lang:form_location_id','trim');
        $this->form_validation->set_rules('job_id','lang:form_postion_id','trim');
        $this->form_validation->set_rules('applicant_salary','lang:form_salary','trim');
        $this->form_validation->set_rules('applicant_prefix_id','lang:form_prefix_id','trim');
        $this->form_validation->set_rules('applicant_fname_th','lang:form_fullname_th','trim|required');
        $this->form_validation->set_rules('applicant_lname_th','lang:form_fullname_th','trim|required');
        $this->form_validation->set_rules('applicant_fname_en','lang:form_fullname_en','trim|required');
        $this->form_validation->set_rules('applicant_lname_en','lang:form_fullname_en','trim|required');
        $this->form_validation->set_rules('applicant_birthdate','lang:form_birthdate','trim');
        $this->form_validation->set_rules('applicant_idcard','lang:form_idcard','trim|required');
        $this->form_validation->set_rules('applicant_idcard_expired','lang:form_idcard_expired','trim');
        $this->form_validation->set_rules('applicant_height','lang:form_height','trim');
        $this->form_validation->set_rules('applicant_weight','lang:form_weight','trim');
        $this->form_validation->set_rules('applicant_military_status','lang:form_military_status','trim');
        $this->form_validation->set_rules('applicant_current_address_no','lang:form_current_address_no','trim');
        $this->form_validation->set_rules('applicant_current_building','lang:form_current_building','trim');
        $this->form_validation->set_rules('applicant_current_soi','lang:form_current_soi','trim');
        $this->form_validation->set_rules('applicant_current_road','lang:form_current_road','trim');
        $this->form_validation->set_rules('applicant_current_province_id','lang:form_current_province_id','trim');
        $this->form_validation->set_rules('applicant_current_district_id','lang:form_current_district_id','trim');
        $this->form_validation->set_rules('applicant_current_subdistrict_id','lang:form_current_subdistrict_id','trim');
        $this->form_validation->set_rules('applicant_current_postcode','lang:form_current_postcode','trim');
        $this->form_validation->set_rules('applicant_current_telephone','lang:form_current_telephone','trim');
        $this->form_validation->set_rules('applicant_current_mobile','lang:form_current_mobile','trim|required');
        $this->form_validation->set_rules('applicant_current_email','lang:form_current_email','trim|required|valid_email');
        $this->form_validation->set_rules('applicant_register_same_address','lang:form_register_same_address','trim');

        if( $this->input->post('applicant_register_same_address') != 1 ){
            $this->form_validation->set_rules('applicant_register_address_no','lang:form_register_address_no','trim');
            $this->form_validation->set_rules('applicant_register_building','lang:form_register_building','trim');
            $this->form_validation->set_rules('applicant_register_soi','lang:form_register_soi','trim');
            $this->form_validation->set_rules('applicant_register_road','lang:form_register_road','trim');
            $this->form_validation->set_rules('applicant_register_province_id','lang:form_register_province_id','trim');
            $this->form_validation->set_rules('applicant_register_district_id','lang:form_register_district_id','trim');
            $this->form_validation->set_rules('applicant_register_subdistrict_id','lang:form_register_subdistrict_id','trim');
            $this->form_validation->set_rules('applicant_register_postcode','lang:form_register_postcode','trim');
            $this->form_validation->set_rules('applicant_register_telephone','lang:form_register_telephone','trim');
            $this->form_validation->set_rules('applicant_register_mobile','lang:form_register_mobile','trim|required');
            $this->form_validation->set_rules('applicant_register_email','lang:form_register_email','trim|required|valid_email');
        }

        $this->form_validation->set_rules('applicant_news_source_id','lang:form_news_source','trim');
        $this->form_validation->set_rules('applicant_applied_status','lang:form_applied_status','trim');
        $this->form_validation->set_rules('applicant_applied_year','lang:form_applied_year','trim');
        $this->form_validation->set_rules('applicant_accident_status','lang:form_accident_status','trim');
        $this->form_validation->set_rules('applicant_studying_status','lang:form_studying_status','trim');
        $this->form_validation->set_rules('applicant_education_highschool_name','lang:form_education_highschool_name','trim');
        $this->form_validation->set_rules('applicant_education_highschool_province_id','lang:form_education_highschool_province_id','trim');
        $this->form_validation->set_rules('applicant_education_highschool_year','lang:form_education_highschool_year','trim');
        $this->form_validation->set_rules('applicant_education_highschool_major','lang:form_education_highschool_major','trim');
        $this->form_validation->set_rules('applicant_education_highschool_gpa','lang:form_education_highschool_gpa','trim');
        $this->form_validation->set_rules('applicant_education_vocational_name','lang:form_education_vocational_name','trim');
        $this->form_validation->set_rules('applicant_education_vocational_province_id','lang:form_education_vocational_province_id','trim');
        $this->form_validation->set_rules('applicant_education_vocational_year','lang:form_education_vocational_year','trim');
        $this->form_validation->set_rules('applicant_education_vocational_major','lang:form_education_vocational_major','trim');
        $this->form_validation->set_rules('applicant_education_vocational_gpa','lang:form_education_vocational_gpa','trim');
        $this->form_validation->set_rules('applicant_education_diploma_name','lang:form_education_diploma_name','trim');
        $this->form_validation->set_rules('applicant_education_diploma_province_id','lang:form_education_diploma_province_id','trim');
        $this->form_validation->set_rules('applicant_education_diploma_year','lang:form_education_diploma_year','trim');
        $this->form_validation->set_rules('applicant_education_diploma_major','lang:form_education_diploma_major','trim');
        $this->form_validation->set_rules('applicant_education_diploma_gpa','lang:form_education_diploma_gpa','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_name','lang:form_education_bachelor_name','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_province_id','lang:form_education_bachelor_province_id','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_year','lang:form_education_bachelor_year','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_major','lang:form_education_bachelor_major','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_gpa','lang:form_education_bachelor_gpa','trim');
        $this->form_validation->set_rules('applicant_education_master_name','lang:form_education_master_name','trim');
        $this->form_validation->set_rules('applicant_education_master_province_id','lang:form_education_master_province_id','trim');
        $this->form_validation->set_rules('applicant_education_master_year','lang:form_education_master_year','trim');
        $this->form_validation->set_rules('applicant_education_master_major','lang:form_education_master_major','trim');
        $this->form_validation->set_rules('applicant_education_master_gpa','lang:form_education_master_gpa','trim');
        $this->form_validation->set_rules('applicant_education_other_name','lang:form_education_other_name','trim');
        $this->form_validation->set_rules('applicant_education_other_province_id','lang:form_education_other_province_id','trim');
        $this->form_validation->set_rules('applicant_education_other_year','lang:form_education_other_year','trim');
        $this->form_validation->set_rules('applicant_education_other_major','lang:form_education_other_major','trim');
        $this->form_validation->set_rules('applicant_education_other_gpa','lang:form_education_other_gpa','trim');
        $this->form_validation->set_rules('applicant_skill_computer','lang:form_skill_computer','trim');
        $this->form_validation->set_rules('applicant_skill_typing_thai','lang:form_skill_typing_thai','trim');
        $this->form_validation->set_rules('applicant_skill_typing_english','lang:form_skill_typing_english','trim');
        $this->form_validation->set_rules('applicant_skill_office_tools','lang:form_skill_office_tools','trim');
        $this->form_validation->set_rules('applicant_skill_specials','lang:form_skill_specials','trim');
        $this->form_validation->set_rules('applicant_skill_activities','lang:form_skill_activities','trim');
        $this->form_validation->set_rules('applicant_skill_driving_status','lang:form_skill_driving_status','trim');
        $this->form_validation->set_rules('applicant_skill_driving_license','lang:form_skill_driving_license','trim');
        $this->form_validation->set_rules('applicant_skill_riding_status','lang:form_skill_riding_status','trim');
        $this->form_validation->set_rules('applicant_skill_riding_license','lang:form_skill_riding_license','trim');

        $this->form_validation->set_rules('applicant_skill_languages[]["listen"]','lang:form_skill_languages_listen','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["speaking"]','lang:form_skill_languages_speaking','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["reading"]','lang:form_skill_languages_reading','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["writing"]','lang:form_skill_languages_writing','trim');

        $this->form_validation->set_rules('applicant_experienced_status','lang:form_experienced_status','trim');

        $this->form_validation->set_rules('applicant_experiences[]["company_name"]','lang:form_experiences_company_name','trim');
        $this->form_validation->set_rules('applicant_experiences[]["company_address"]','lang:form_experiences_company_address','trim');
        $this->form_validation->set_rules('applicant_experiences[]["company_telephone"]','lang:form_experiences_company_telephone','trim');
        $this->form_validation->set_rules('applicant_experiences[]["start"]','lang:form_experiences_company_start','trim');
        $this->form_validation->set_rules('applicant_experiences[]["end"]','lang:form_experiences_company_end','trim');
        $this->form_validation->set_rules('applicant_experiences[]["superior"]','lang:form_experiences_superior','trim');
        $this->form_validation->set_rules('applicant_experiences[]["responsibility"]','lang:form_experiences_responsibility','trim');
        $this->form_validation->set_rules('applicant_experiences[]["salary"]','lang:form_experiences_salary','trim');
        $this->form_validation->set_rules('applicant_experiences[]["cost_of_living"]','lang:form_experiences_cost_of_living','trim');
        $this->form_validation->set_rules('applicant_experiences[]["bonus"]','lang:form_experiences_bonus','trim');
        $this->form_validation->set_rules('applicant_experiences[]["other"]','lang:form_experiences_other','trim');
        $this->form_validation->set_rules('applicant_experiences[]["total"]','lang:form_experiences_total_income','trim');
        $this->form_validation->set_rules('applicant_experiences[]["reason"]','lang:form_experiences_respon','trim');
        
        $this->form_validation->set_rules('applicant_introduction','lang:form_introduction','trim');
        $this->form_validation->set_rules('applicant_forbidden_person', 'lang:form_forbidden_person','trim');
        $this->form_validation->set_rules('applicant_broker', 'lang:form_broker','trim');
        $this->form_validation->set_rules('applicant_revoked', 'lang:form_revoked','trim');
        $this->form_validation->set_rules('applicant_pdpa_consent', 'lang:form_pdpa_consent','trim');
        $this->form_validation->set_rules('applicant_consent','lang:form_agreement','trim');
        $this->form_validation->set_rules('applicant_signed_name','lang:form_signed_name','trim');

        $this->form_validation->set_message('required',( $this->_language == 'en' ? '"%s" is required.' : 'กรุณาระบุ "%s"' ));
        $this->form_validation->set_message('valid_email', ( $this->_language == 'en' ? '"%s" is not in correct format' : '"%s" มีรูปแบบไม่ถูกต้อง' ));
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){

            $this->_data['locations'] = $this->jobsmodel->get_locations();
            $this->_data['positions'] = $this->jobsmodel->get_jobs(0, 1);
            $this->_data['prefixes'] = $this->jobsmodel->get_prefixes();
            $this->_data['provinces'] = $this->jobsmodel->get_provinces();
            $this->_data['sources'] = $this->jobsmodel->get_news_sources();
            $this->_data['jobInfo'] = $this->jobsmodel->get_jobinfo_byid( $jobid );

            $this->load->view('included/header', $this->_data);
            $this->load->view('included/navigation');
            $this->load->view('jobs/apply');
            $this->load->view('included/footer');

        }else{
            $message = $this->jobsmodel->create();

            if( $message['status'] = 'message-success' ){
                $this->sendEmail( $message['payLoads']['applicant_id'] );

                $this->session->set_flashdata( $message['status'], $message['text'] );
                redirect('job-vacancy');
            }else{
                $this->session->set_flashdata( $message['status'], $message['text'] );
                redirect('job-vacancy');
            }
        }

    }

    public function edit_applicant( $uuid='' ){

        if( $uuid == '' ){
            $message = array(
                'status' => 'message-warning',
                'text' => 'คุณไม่ได้รับอนุญาตให้เข้าถึงการแก้ไขของใบสมัครนี้'
            );

            $this->session->set_flashdata( $message['status'], $message['text'] );
            redirect('job-vacancy');
        }else{
            $info = $this->jobsmodel->get_applicantinfo_byuuid( $uuid );
            if( isset( $info ) && count( $info ) > 0 ){
                $this->_data['info'] = $info;
            }else{
                $message = array(
                    'status' => 'message-error',
                    'text' => 'ข้อมูลการเข้าถึงของคุณไม่ถูกต้อง'
                );

                $this->session->set_flashdata( $message['status'], $message['text'] );
                redirect('job-vacancy');
            }
        }
        /* Language File loaded - Start */
        $this->lang->load('jobs_applicant', $this->_language);
        /* Language File loaded - End */

        $this->form_validation->set_rules('location_id','lang:form_location_id','trim');
        $this->form_validation->set_rules('job_id','lang:form_postion_id','trim');
        $this->form_validation->set_rules('applicant_salary','lang:form_salary','trim');
        $this->form_validation->set_rules('applicant_prefix_id','lang:form_prefix_id','trim');
        $this->form_validation->set_rules('applicant_fname_th','lang:form_fullname_th','trim|required');
        $this->form_validation->set_rules('applicant_lname_th','lang:form_fullname_th','trim|required');
        $this->form_validation->set_rules('applicant_fname_en','lang:form_fullname_en','trim|required');
        $this->form_validation->set_rules('applicant_lname_en','lang:form_fullname_en','trim|required');
        $this->form_validation->set_rules('applicant_birthdate','lang:form_birthdate','trim');
        $this->form_validation->set_rules('applicant_idcard','lang:form_idcard','trim|required');
        $this->form_validation->set_rules('applicant_idcard_expired','lang:form_idcard_expired','trim');
        $this->form_validation->set_rules('applicant_height','lang:form_height','trim');
        $this->form_validation->set_rules('applicant_weight','lang:form_weight','trim');
        $this->form_validation->set_rules('applicant_military_status','lang:form_military_status','trim');
        $this->form_validation->set_rules('applicant_current_address_no','lang:form_current_address_no','trim');
        $this->form_validation->set_rules('applicant_current_building','lang:form_current_building','trim');
        $this->form_validation->set_rules('applicant_current_soi','lang:form_current_soi','trim');
        $this->form_validation->set_rules('applicant_current_road','lang:form_current_road','trim');
        $this->form_validation->set_rules('applicant_current_province_id','lang:form_current_province_id','trim');
        $this->form_validation->set_rules('applicant_current_district_id','lang:form_current_district_id','trim');
        $this->form_validation->set_rules('applicant_current_subdistrict_id','lang:form_current_subdistrict_id','trim');
        $this->form_validation->set_rules('applicant_current_postcode','lang:form_current_postcode','trim');
        $this->form_validation->set_rules('applicant_current_telephone','lang:form_current_telephone','trim');
        $this->form_validation->set_rules('applicant_current_mobile','lang:form_current_mobile','trim|required');
        $this->form_validation->set_rules('applicant_current_email','lang:form_current_email','trim|required|valid_email');
        $this->form_validation->set_rules('applicant_register_same_address','lang:form_register_same_address','trim');

        if( $this->input->post('applicant_register_same_address') != 1 ){
            $this->form_validation->set_rules('applicant_register_address_no','lang:form_register_address_no','trim');
            $this->form_validation->set_rules('applicant_register_building','lang:form_register_building','trim');
            $this->form_validation->set_rules('applicant_register_soi','lang:form_register_soi','trim');
            $this->form_validation->set_rules('applicant_register_road','lang:form_register_road','trim');
            $this->form_validation->set_rules('applicant_register_province_id','lang:form_register_province_id','trim');
            $this->form_validation->set_rules('applicant_register_district_id','lang:form_register_district_id','trim');
            $this->form_validation->set_rules('applicant_register_subdistrict_id','lang:form_register_subdistrict_id','trim');
            $this->form_validation->set_rules('applicant_register_postcode','lang:form_register_postcode','trim');
            $this->form_validation->set_rules('applicant_register_telephone','lang:form_register_telephone','trim');
            $this->form_validation->set_rules('applicant_register_mobile','lang:form_register_mobile','trim|required');
            $this->form_validation->set_rules('applicant_register_email','lang:form_register_email','trim|required|valid_email');
        }

        $this->form_validation->set_rules('applicant_news_source_id','lang:form_news_source','trim');
        $this->form_validation->set_rules('applicant_applied_status','lang:form_applied_status','trim');
        $this->form_validation->set_rules('applicant_applied_year','lang:form_applied_year','trim');
        $this->form_validation->set_rules('applicant_accident_status','lang:form_accident_status','trim');
        $this->form_validation->set_rules('applicant_studying_status','lang:form_studying_status','trim');
        $this->form_validation->set_rules('applicant_education_highschool_name','lang:form_education_highschool_name','trim');
        $this->form_validation->set_rules('applicant_education_highschool_province_id','lang:form_education_highschool_province_id','trim');
        $this->form_validation->set_rules('applicant_education_highschool_year','lang:form_education_highschool_year','trim');
        $this->form_validation->set_rules('applicant_education_highschool_major','lang:form_education_highschool_major','trim');
        $this->form_validation->set_rules('applicant_education_highschool_gpa','lang:form_education_highschool_gpa','trim');
        $this->form_validation->set_rules('applicant_education_vocational_name','lang:form_education_vocational_name','trim');
        $this->form_validation->set_rules('applicant_education_vocational_province_id','lang:form_education_vocational_province_id','trim');
        $this->form_validation->set_rules('applicant_education_vocational_year','lang:form_education_vocational_year','trim');
        $this->form_validation->set_rules('applicant_education_vocational_major','lang:form_education_vocational_major','trim');
        $this->form_validation->set_rules('applicant_education_vocational_gpa','lang:form_education_vocational_gpa','trim');
        $this->form_validation->set_rules('applicant_education_diploma_name','lang:form_education_diploma_name','trim');
        $this->form_validation->set_rules('applicant_education_diploma_province_id','lang:form_education_diploma_province_id','trim');
        $this->form_validation->set_rules('applicant_education_diploma_year','lang:form_education_diploma_year','trim');
        $this->form_validation->set_rules('applicant_education_diploma_major','lang:form_education_diploma_major','trim');
        $this->form_validation->set_rules('applicant_education_diploma_gpa','lang:form_education_diploma_gpa','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_name','lang:form_education_bachelor_name','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_province_id','lang:form_education_bachelor_province_id','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_year','lang:form_education_bachelor_year','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_major','lang:form_education_bachelor_major','trim');
        $this->form_validation->set_rules('applicant_education_bachelor_gpa','lang:form_education_bachelor_gpa','trim');
        $this->form_validation->set_rules('applicant_education_master_name','lang:form_education_master_name','trim');
        $this->form_validation->set_rules('applicant_education_master_province_id','lang:form_education_master_province_id','trim');
        $this->form_validation->set_rules('applicant_education_master_year','lang:form_education_master_year','trim');
        $this->form_validation->set_rules('applicant_education_master_major','lang:form_education_master_major','trim');
        $this->form_validation->set_rules('applicant_education_master_gpa','lang:form_education_master_gpa','trim');
        $this->form_validation->set_rules('applicant_education_other_name','lang:form_education_other_name','trim');
        $this->form_validation->set_rules('applicant_education_other_province_id','lang:form_education_other_province_id','trim');
        $this->form_validation->set_rules('applicant_education_other_year','lang:form_education_other_year','trim');
        $this->form_validation->set_rules('applicant_education_other_major','lang:form_education_other_major','trim');
        $this->form_validation->set_rules('applicant_education_other_gpa','lang:form_education_other_gpa','trim');
        $this->form_validation->set_rules('applicant_skill_computer','lang:form_skill_computer','trim');
        $this->form_validation->set_rules('applicant_skill_typing_thai','lang:form_skill_typing_thai','trim');
        $this->form_validation->set_rules('applicant_skill_typing_english','lang:form_skill_typing_english','trim');
        $this->form_validation->set_rules('applicant_skill_office_tools','lang:form_skill_office_tools','trim');
        $this->form_validation->set_rules('applicant_skill_specials','lang:form_skill_specials','trim');
        $this->form_validation->set_rules('applicant_skill_activities','lang:form_skill_activities','trim');
        $this->form_validation->set_rules('applicant_skill_driving_status','lang:form_skill_driving_status','trim');
        $this->form_validation->set_rules('applicant_skill_driving_license','lang:form_skill_driving_license','trim');
        $this->form_validation->set_rules('applicant_skill_riding_status','lang:form_skill_riding_status','trim');
        $this->form_validation->set_rules('applicant_skill_riding_license','lang:form_skill_riding_license','trim');

        $this->form_validation->set_rules('applicant_skill_languages[]["listen"]','lang:form_skill_languages_listen','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["speaking"]','lang:form_skill_languages_speaking','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["reading"]','lang:form_skill_languages_reading','trim');
        $this->form_validation->set_rules('applicant_skill_languages[]["writing"]','lang:form_skill_languages_writing','trim');

        $this->form_validation->set_rules('applicant_experienced_status','lang:form_experienced_status','trim');

        $this->form_validation->set_rules('applicant_experiences[]["company_name"]','lang:form_experiences_company_name','trim');
        $this->form_validation->set_rules('applicant_experiences[]["company_address"]','lang:form_experiences_company_address','trim');
        $this->form_validation->set_rules('applicant_experiences[]["company_telephone"]','lang:form_experiences_company_telephone','trim');
        $this->form_validation->set_rules('applicant_experiences[]["start"]','lang:form_experiences_company_start','trim');
        $this->form_validation->set_rules('applicant_experiences[]["end"]','lang:form_experiences_company_end','trim');
        $this->form_validation->set_rules('applicant_experiences[]["superior"]','lang:form_experiences_superior','trim');
        $this->form_validation->set_rules('applicant_experiences[]["responsibility"]','lang:form_experiences_responsibility','trim');
        $this->form_validation->set_rules('applicant_experiences[]["salary"]','lang:form_experiences_salary','trim');
        $this->form_validation->set_rules('applicant_experiences[]["cost_of_living"]','lang:form_experiences_cost_of_living','trim');
        $this->form_validation->set_rules('applicant_experiences[]["bonus"]','lang:form_experiences_bonus','trim');
        $this->form_validation->set_rules('applicant_experiences[]["other"]','lang:form_experiences_other','trim');
        $this->form_validation->set_rules('applicant_experiences[]["total"]','lang:form_experiences_total_income','trim');
        $this->form_validation->set_rules('applicant_experiences[]["reason"]','lang:form_experiences_respon','trim');
        
        $this->form_validation->set_rules('applicant_introduction','lang:form_introduction','trim');
        $this->form_validation->set_rules('applicant_forbidden_person', 'lang:form_forbidden_person','trim');
        $this->form_validation->set_rules('applicant_broker', 'lang:form_broker','trim');
        $this->form_validation->set_rules('applicant_revoked', 'lang:form_revoked','trim');
        $this->form_validation->set_rules('applicant_pdpa_consent', 'lang:form_pdpa_consent','trim');
        $this->form_validation->set_rules('applicant_consent','lang:form_agreement','trim');
        $this->form_validation->set_rules('applicant_signed_name','lang:form_signed_name','trim');

        $this->form_validation->set_message('required',( $this->_language == 'en' ? '"%s" is required.' : 'กรุณาระบุ "%s"' ));
        $this->form_validation->set_message('valid_email', ( $this->_language == 'en' ? '"%s" is not in correct format' : '"%s" มีรูปแบบไม่ถูกต้อง' ));
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){

            $this->_data['locations'] = $this->jobsmodel->get_locations();
            $this->_data['positions'] = $this->jobsmodel->get_jobs(0, 1);
            $this->_data['prefixes'] = $this->jobsmodel->get_prefixes();
            $this->_data['provinces'] = $this->jobsmodel->get_provinces();
            $this->_data['sources'] = $this->jobsmodel->get_news_sources();
            $this->_data['jobInfo'] = $this->jobsmodel->get_jobinfo_byid( 0 );
            $address = [
                'current' => $this->jobsmodel->get_address( $info['applicant_id'], 'current' ),
                'registration' => $this->jobsmodel->get_address( $info['applicant_id'], 'registration' )
            ];
            $this->_data['current'] = $address['current'][0];
            $this->_data['registration'] = $address['registration'][0];
            $this->_data['languages'] = $this->jobsmodel->get_languages( $info['applicant_id'] );
            $this->_data['experiences'] = $this->jobsmodel->get_experiences( $info['applicant_id'] );

            $this->load->view('included/header', $this->_data);
            $this->load->view('included/navigation');
            $this->load->view('jobs/edit_apply');
            $this->load->view('included/footer');

        }else{
            $message = $this->jobsmodel->update( $info['applicant_id'] );

            if( $message['status'] = 'message-success' ){
                //$this->sendEmail( $message['payLoads']['applicant_id'] );

                $this->session->set_flashdata( $message['status'], $message['text'] );
                redirect('job-vacancy');
            }else{
                $this->session->set_flashdata( $message['status'], $message['text'] );
                redirect('job-vacancy');
            }
        }

    }

    public function saveProfile(){

        $response = $this->jobsmodel->saveProfile();

        if( $response['status'] == 200 ){
            $this->sendEmailLeavingProfile( $response['profileId'] );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    /* Email Sender - Start */
    public function sendEmail( $applicantId=0 ){
        if( $applicantId > 0 ){
            $info = $this->jobsmodel->get_applicantinfo_byid( $applicantId );
            if( $info['job_id'] > 0 ){
                $jobinfo = $this->jobsmodel->get_jobinfo_byid( $info['job_id'] );
            }else{
                $jobinfo = array();
            }
            $adminSubject = $this->mainmodel->get_web_setting('admin_email_subject');
            $adminBody = $this->mainmodel->get_web_setting('admin_email_body');
            $applicantSubject = $this->mainmodel->get_web_setting('applicant_email_subject');
            $applicantBody = $this->mainmodel->get_web_setting('applicant_email_body');
            $hrAdminEmails = $this->mainmodel->get_web_setting('hr_admin_emails');

            /* Email Setup - Start */
            $this->load->library('email');
            /* Email Setup - End */

            /* Send email to candidate - Start */
            $this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $info['address_email'] );

            $patterns = array(
                '/{\$applicant_fname}/',
                '/{\$applicant_lname}/',
                '/{\$applicant_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['applicant_fname_th'],
                $info['applicant_lname_th'],
                $info['applicant_createdtime'],
                ( $info['job_id'] > 0 ? $jobinfo['job_title_th'] : '' ),
                ''
            );
            
            $subject = preg_replace( $patterns, $replacements, $applicantSubject['setting_value']);
            $body = preg_replace( $patterns, $replacements, $applicantBody['setting_value']);

            $this->email->subject( $subject );
            $this->_data['body'] = $body;
            $this->_data['info'] = $info;
            $this->_data['jobinfo'] = $jobinfo;
            $mailbody = $this->load->view('jobs/email/email_template', $this->_data, TRUE);
            $this->email->message( $mailbody );
            $this->email->send();
            /* Send email to candidate - End */

            /* Send email to Administrator - Start */
            $this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $hrAdminEmails['setting_value'] );
            
            $patterns = array(
                '/{\$applicant_fname}/',
                '/{\$applicant_lname}/',
                '/{\$applicant_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['applicant_fname_th'],
                $info['applicant_lname_th'],
                $info['applicant_createdtime'],
                ( $info['job_id'] > 0 ? $jobinfo['job_title_th'] : '' ),
                '<a href="'.site_url('administrator/applicantsreport/info/'.$info['applicant_id'], false).'">คลิก</a>'
            );
            
            $subject = preg_replace( $patterns, $replacements, $adminSubject['setting_value']);
            $body = preg_replace( $patterns, $replacements, $adminBody['setting_value']);

            $this->email->subject( $subject );
            $this->_data['body'] = $body;
            $this->_data['info'] = $info;
            $this->_data['jobinfo'] = $jobinfo;
            $mailbody = $this->load->view('jobs/email/admin_template', $this->_data, TRUE);
            $this->email->message( $mailbody );
            $this->email->send();
            /* Send email to Administrator - End */
        }
    }

    public function sendEmailLeavingProfile( $profileId=0 ){
        if( $profileId > 0 ){
            $info = $this->jobsmodel->get_profileinfo_byid( $profileId );
            if( $info['profile_id'] > 0 ){
                $jobinfo = $this->jobsmodel->get_jobinfo_byid( $info['job_id'] );
            }else{
                $jobinfo = array();
            }
            $adminSubject = $this->mainmodel->get_web_setting('admin_profile_email_subject');
            $adminBody = $this->mainmodel->get_web_setting('admin_profile_email_body');
            $applicantSubject = $this->mainmodel->get_web_setting('profile_email_subject');
            $applicantBody = $this->mainmodel->get_web_setting('profile_email_body');
            $hrAdminEmails = $this->mainmodel->get_web_setting('hr_admin_emails');

            /* Email Setup - Start */
            $this->load->library('email');
            /* Email Setup - End */

            /* Send email to candidate - Start */
            $this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $info['profile_email'] );

            $patterns = array(
                '/{\$profile_name}/',
                '/{\$profile_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['profile_name'],
                $info['profile_createdtime'],
                ( $info['job_id'] > 0 ? $jobinfo['job_title_th'] : '' ),
                ''
            );
            
            $subject = preg_replace( $patterns, $replacements, $applicantSubject['setting_value']);
            $body = preg_replace( $patterns, $replacements, $applicantBody['setting_value']);

            $this->email->subject( $subject );
            $this->_data['body'] = $body;
            $this->_data['info'] = $info;
            $this->_data['jobinfo'] = $jobinfo;
            $mailbody = $this->load->view('jobs/email/email_template', $this->_data, TRUE);
            $this->email->message( $mailbody );
            $this->email->send();
            /* Send email to candidate - End */

            /* Send email to Administrator - Start */
            $this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $hrAdminEmails['setting_value'] );
            
            $patterns = array(
                '/{\$profile_name}/',
                '/{\$profile_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['profile_name'],
                $info['profile_createdtime'],
                ( $info['job_id'] > 0 ? $jobinfo['job_title_th'] : '' ),
                '<a href="'.site_url('administrator/applicantsreport/profile_info/'.$info['profile_id'], false).'">คลิก</a>'
            );
            
            $subject = preg_replace( $patterns, $replacements, $adminSubject['setting_value']);
            $body = preg_replace( $patterns, $replacements, $adminBody['setting_value']);

            $this->email->subject( $subject );
            $this->_data['body'] = $body;
            $this->_data['info'] = $info;
            $this->_data['jobinfo'] = $jobinfo;
            $mailbody = $this->load->view('jobs/email/admin_template', $this->_data, TRUE);
            $this->email->message( $mailbody );
            $this->email->send();
            /* Send email to Administrator - End */
        }
    }

    public function debug( $type='applicant',  $applicantId=0 ){
        $adminSubject = $this->mainmodel->get_web_setting('admin_email_subject');
        $adminBody = $this->mainmodel->get_web_setting('admin_email_body');
        $applicantSubject = $this->mainmodel->get_web_setting('applicant_email_subject');
        $applicantBody = $this->mainmodel->get_web_setting('applicant_email_body');
        $info = $this->jobsmodel->get_applicantinfo_byid( $applicantId );
        if( $info['job_id'] > 0 ){
            $this->_data['jobinfo'] = $this->jobsmodel->get_jobinfo_byid( $info['job_id'] );
        }else{
            $this->_data['jobinfo'] = array();
        }

        /* Email Setup - Start */
        $this->load->library('email');
        /* Email Setup - End */

        if( $type == 'admin' ){
            $patterns = array(
                '/{\$applicant_fname}/',
                '/{\$applicant_lname}/',
                '/{\$applicant_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['applicant_fname_th'],
                $info['applicant_lname_th'],
                $info['applicant_createdtime'],
                ( $info['job_id'] > 0 ? $info['job_title_th'] : '' ),
                '<a href="'.site_url('administrator/applicantsreport/info/'.$info['applicant_id'], false).'">คลิก</a>'
            );
            
            $this->_data['body'] = preg_replace( $patterns, $replacements, $adminBody['setting_value']);
            $this->load->view('jobs/email/admin_template', $this->_data);
            
        }else{
            $patterns = array(
                '/{\$applicant_fname}/',
                '/{\$applicant_lname}/',
                '/{\$applicant_createdtime}/',
                '/{\$position_title_th}/',
                '/{\$admin_link_back}/'
            );
            $replacements = array(
                $info['applicant_fname_th'],
                $info['applicant_lname_th'],
                $info['applicant_createdtime'],
                ( $info['job_id'] > 0 ? $info['job_title_th'] : '' ),
                ''
            );
            
            $subject = preg_replace( $patterns, $replacements, $applicantSubject['setting_value']);
            $this->_data['body'] = preg_replace( $patterns, $replacements, $applicantBody['setting_value']);
            // $this->load->view('jobs/email/email_template', $this->_data);
            $this->email->subject( $subject );
            $this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $info['address_email'] );
            $mailbody = $this->load->view('jobs/email/email_template', $this->_data, TRUE);
            $this->email->message( $mailbody );
            $this->email->send();
            echo $this->email->print_debugger();
        }
    }
    /* Email Sender - End */

    /* APIs - Start */
    public function api_get_jobs(){
        $locationId = htmlspecialchars( $this->input->post('location_id') );
        $options = $this->jobsmodel->get_jobs( $locationId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['job_id'],
                    'name' => ( $this->_language == 'en' ? $option['job_title_en'] : $option['job_title_th'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_districts(){
        $provinceId = htmlspecialchars( $this->input->post('province_id') );
        $options = $this->jobsmodel->get_districts( $provinceId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['amphoe_id'],
                    'name' => ( $this->_language == 'en' ? $option['name_alt'] : $option['name'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_subdistricts(){
        $districtId = htmlspecialchars( $this->input->post('district_id') );
        $options = $this->jobsmodel->get_subdistricts( $districtId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['tambon_id'],
                    'name' => ( $this->_language == 'en' ? $option['name_alt'] : $option['name'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_postcodes(){
        $subdistrictId = htmlspecialchars( $this->input->post('subdistrict_id') );
        $options = $this->jobsmodel->get_zipcodes( $subdistrictId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['postcode_id'],
                    'name' => $option['code']
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }
    /* APIs - End */

}

/* End of file Jobs.php */
