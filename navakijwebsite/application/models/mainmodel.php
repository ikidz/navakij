<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mainmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
    }
    
    public function get_navigations( $mainid=0, $limit=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }
        $query = $this->db->where('main_id', $mainid)
                            ->where('nav_status','approved')
                            ->order_by('nav_order', 'asc')
                            ->get('navigations')
                            ->result_array();
        return $query;
    }

    public function get_banners(){
        $where = 'banner_status = "approved" AND banner_start_date <= "'.date("Y-m-d").'" AND ( banner_end_date >= "'.date("Y-m-d").'" OR banner_end_date is null )';
        $query = $this->db->where( $where )
                            ->order_by('banner_order','asc')
                            ->get('banners')
                            ->result_array();
        return $query;
    }

    public function get_insurance_categories(){
        $query = $this->db->select('insurance_category_meta_url as `category_meta_url`')
                            ->where('insurance_category_status','approved')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->row_array();
        return $query;
    }

    public function get_insurance_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->select('insurance_category_meta_url as `category_meta_url`')
                            ->where('insurance_category_id', $categoryid)
                            ->where('insurance_category_status','approved')
                            ->get('insurance_categories')
                            ->row_array();
        return $query;
    }

    public function get_insuranceinfo_byid( $contentid=0 ){
        $query = $this->db->select('insurance_meta_url as `content_meta_url`')
                            ->where('insurance_id', $contentid)
                            ->get('insurance')
                            ->row_array();
        return $query;
    }

    public function get_article_categories( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }

    public function get_article_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('category_status','approved')
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_articleinfo_byid( $contentid=0 ){
        $query = $this->db->select('article_meta_url as `content_meta_url`')
                            ->where('article_id', $contentid)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_document_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_document_main_categoryinfo_byid( $categoryid=0 ){
        $info = $this->get_document_categoryinfo_byid( $categoryid );
        $maininfo = array();
        if( isset( $info ) && count( $info ) > 0 ){
            if( $info['main_id'] > 0 ){
                $maininfo = $this->get_document_categoryinfo_byid( $info['main_id'] );
            }
        }

        return $maininfo;
    }

    public function get_documentinfo_byid( $contentid=0 ){
        $query = $this->db->select('document_meta_url as `content_meta_url`')
                            ->where('document_id', $contentid)
                            ->get('documents')
                            ->row_array();
        return $query;
    }

    public function get_web_setting( $key='' ){
        $query = $this->db->where('setting_key', $key)
                            ->get('system_setting')
                            ->row_array();
        return $query;
    }

    public function get_intro(){
        $where = 'intro_status = "approved" AND intro_start_date <= "'.date("Y-m-d").'" AND ( intro_end_date >= "'.date("Y-m-d").'" OR intro_end_date is null )';
        $query = $this->db->where( $where )
                            ->order_by('intro_createdtime','desc')
                            ->limit(1)
                            ->get('intro')
                            ->row_array();
        return $query;
    }

    public function get_jobs( $locationid=0, $appliable=0, $leavingProfile=0 ){
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

    public function iplog($ip, $lang='th', $current_url='', $current_uri=''){

        /* Verify cookies - Start */
        $cookieContent = $this->verify_cookie($ip);
        /* Verify cookies - End */

        if( !$cookieContent ){ //No Cookie

            /* Check if ip exists within same month - Start */
            $sameIp = $this->db->where('ip', $ip)
                                ->where('MONTH(created_at)', date('m'))
                                ->where('YEAR(created_at)', date('Y'))
                                ->order_by('created_at','desc')
                                ->limit(1)
                                ->get('ip_logs')
                                ->row_array();
            // print_r($sameIp);
            // exit();
            /* Check if ip exists within same month - End */
            if( !$sameIp ){

                $resp = $this->get_geolocation( $ip, $lang );
                if( isset($resp) && $resp['status'] == 200 ){
                    $decodeResp = $resp['payLoads'];
                    //if( $decodeResp['country_code2'] == 'TH' ){
                        /* Setting Cookies - Start */
                        $hash = md5('NKI_'.date('YmdHis'));
                        //$content = $hash.'|'.$decodeResp['ip'].'|'.$decodeResp['continent_code'].'|'.$decodeResp['country_code2'].'|'.date('Y-m-d H:i:s');
                        $content = $hash.'|'.$decodeResp['ip'].date('Y-m-d H:i:s');
                        $this->set_cookie_ip( $content );
                        /* Setting Cookies - End */

                        /* Log to DB - Start */
                        $this->db->set('hash', $hash);
                        $this->db->set('ip', $ip);
                        // $this->db->set('continental_code', $decodeResp['continent_code']);
                        // $this->db->set('country_code', $decodeResp['country_code2']);
                        $this->db->set('created_at', date('Y-m-d H:i:s'));
                        $this->db->insert('ip_logs');
                        // $logId = $this->db->insert_id();
                        /* Log to DB - End */

                        /* Log transaction - Start */
                        $this->db->set('hash', $hash);
                        $this->db->set('ip', $ip);
                        // $this->db->set('ref_id', $logId);
                        $this->db->set('current_url', urldecode( $current_url ));
                        $this->db->set('current_uri', urldecode( $current_uri ));
                        $this->db->set('created_at', date('Y-m-d H:i:s'));
                        $this->db->insert('ip_transaction_logs');
                        /* Log transaction - End */
                    //}
                }

            }

        }else{ //Cookie exists

            $stacks = explode('|', $cookieContent);
            $query = $this->db->select('hash')
                        ->where('hash', $stacks[0])
                        ->where('ip', $stacks[1])
                        ->order_by('created_at','desc')
                        ->limit(1)
                        ->get('ip_logs')
                        ->row_array();
            if( $query ){
                $countLogs = $this->db->where('hash', $stacks[0])
                                    ->where('ip', $stacks[1])
                                    ->where('current_uri', urldecode( $current_uri ))
                                    ->count_all_results('ip_transaction_logs');
                if( $countLogs <= 0 ){

                    /* Log transaction - Start */
                    $this->db->set('hash', $query['hash']);
                    $this->db->set('ip', $stacks[1]);
                    // $this->db->set('ref_id', $query['id']);
                    $this->db->set('current_url', urldecode( $current_url ));
                    $this->db->set('current_uri', urldecode( $current_uri ));
                    $this->db->set('created_at', date('Y-m-d H:i:s'));
                    $this->db->insert('ip_transaction_logs');
                    /* Log transaction - End */

                }
            }else{
                /* Log to DB - Start */
                $this->db->set('hash', $stacks[0]);
                $this->db->set('ip', $stacks[1]);
                // $this->db->set('continental_code', $stacks[2]);
                // $this->db->set('country_code', $stacks[3]);
                $this->db->set('created_at', $stacks[4]);
                $this->db->insert('ip_logs');
                // $logId = $this->db->insert_id();
                /* Log to DB - End */

                /* Log transaction - Start */
                $this->db->set('hash', $stacks[0]);
                $this->db->set('ip', $stacks[1]);
                // $this->db->set('ref_id', $logId);
                $this->db->set('current_url', urldecode( $current_url ));
                $this->db->set('current_uri', urldecode( $current_uri ));
                $this->db->set('created_at', $stacks[4]);
                $this->db->insert('ip_transaction_logs');
                /* Log transaction - End */
            }
        }

        $response = [
            'status' => 200,
            'message' => null
        ];

        return $response;

    }

    private function get_geolocation($ip, $lang = "th", $fields = "*", $excludes = "") {
        // $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".IPGEO_API_KEY."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        // $cURL = curl_init();

        // curl_setopt($cURL, CURLOPT_URL, $url);
        // curl_setopt($cURL, CURLOPT_HTTPGET, true);
        // curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Accept: application/json',
        //     'User-Agent: '.$_SERVER['HTTP_USER_AGENT']
        // ));

        // $location = curl_exec($cURL);
        // $decodeResp = json_decode( $location, true );

        $decodeResp = [
            'ip' => $ip
        ];

        if( @$decodeResp['message'] != '' ){
            $resp = [
                'status' => 500,
                'message' => $decodeResp['message'],
                'payLoads' => null
            ];
            return $resp;
        }else{
            $resp = [
                'status' => 200,
                'message' => null,
                'payLoads' => $decodeResp
            ];
            return $resp;
        }

    }

    private function verify_cookie($ip=''){
        if( !get_cookie( IPGEO_COOKIE_NAME ) ){
            return null;
        }else{
            $cookieContent = get_cookie( IPGEO_COOKIE_NAME );
            $aContent = explode('|', $cookieContent);
            if( $ip != $aContent[1] ){
                delete_cookie( IPGEO_COOKIE_NAME );
                return null;
            }else{
                return $cookieContent;
            }
        }
    }

    private function set_cookie_ip($content=''){
        if( $content != '' ){
            set_cookie( IPGEO_COOKIE_NAME, $content, time()+86400 );

            $response = array(
                'status' => 200
            );

            return json_encode($response);
        }
    }

}

/* End of file Mainmodel.php */
