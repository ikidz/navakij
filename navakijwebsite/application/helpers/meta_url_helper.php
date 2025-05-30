<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('validate_meta_url') ){

    function validate_meta_url( $metaURL = '', $tablename = '', $prefix = '', $currentid=0 ){
        $metaURL = strtolower($metaURL);
        $metaURL = preg_replace('/[^a-z0-9ก-๙เ\/\s-]/', '', $metaURL);
        $metaURL = preg_replace('/[\s_]/', '-', $metaURL);
        $metaURL = preg_replace('/\&+/','-and-', $metaURL);
        $fullURL = site_url(strtolower($metaURL));
        $validatedURL = $metaURL;
        if(mb_strlen($fullURL) > 2000){
            $remove_len = mb_strlen($fullURL)-2000;
            $validatedURL = iconv_set_encoding(sub_str($metaURL,0,mb_strlen($fullURL)-$remove_len), 'UTF-8');
        }

        return check_meta_exists($validatedURL, $tablename, $prefix, $currentid);
    }

}

if( ! function_exists('check_meta_exists') ){
    function check_meta_exists( $validatedURL = '', $tablename='', $prefix='', $currentid=0 ){
        $CI =& get_instance();

        if( $validatedURL != '' ){
            if( $tablename != '' && $prefix != '' ){

                if( $currentid > 0 ){
                    $query = $CI->db->where($prefix.'id !=', $currentid);
                }
                $exists = $CI->db->where( $prefix.'status !=', 'discard')
                                    ->where( $prefix.'meta_url', $validatedURL )
                                    ->get( $tablename )
                                    ->result_array();
                
                if( isset($exists) && count( $exists ) == 0 ){
                    return $validatedURL;
                }else{
                    $validatedURL = $validatedURL.'-copy';
                    return check_meta_exists($validatedURL, $tablename, $prefix, $currentid);
                }
            }
        }
        return $validatedURL;
    }
}
