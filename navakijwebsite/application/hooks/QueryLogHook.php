<?php
class QueryLogHook {

    function log_queries() {   
        $CI =& get_instance();
        $times = $CI->db->query_times;
        $dbs    = array();
        $output = NULL;    
        $queries = $CI->db->queries;
		$admin_path = admin_url();
		$curr = current_url();
		if(strpos($curr,$admin_path) === false){
			return false;
		}
        if (count($queries) == 0)
        {
            $output .= "no queries\n";
        }
        else
        {
            foreach ($queries as $key=>$query)
            {
            	$query = str_replace("\n"," ",$query);
                $output .= date("Y-m-d H:i:s") . "\t" . $query . "\n";
            }
            $took = round(doubleval($times[$key]), 3);
            $output .= "===[took:{$took}]\n\n";
        }

        $CI->load->helper('file');
        $path = APPPATH  . "/logs/query/".date("Y-m-d")."/";
        if(!is_dir($path)){
	        mkdir($path,0777,true);
        }
        if ( ! write_file($path  . "queries.log", $output, 'a+'))
        {
             show_error('debug','Unable to write query the file');
        }  
    }

} 