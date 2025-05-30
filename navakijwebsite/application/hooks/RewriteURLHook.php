<?php
class RewriteURLHook {
	function make_rewrite()
	{
		global $cms_dyn_route;
		require_once( BASEPATH .'database/DB'. EXT );
		$db =& DB();
		$query = $db->get( 'system_url_rewrite' );
		$result = $query->result();
		$allow_lang = $db->get("system_language")->result_array();
		$allow = array();
		
		foreach( $result as $row )
		{
			$route[ $row->request_path ] = $row->target_path;
			foreach($allow_lang  as $arr){
				$allow[]=$arr['lang_id'];
				$route[ $arr['lang_id']. "/". $row->request_path ] = $row->target_path;
				$route[ "customer/" . $arr['lang_id']. "/". $row->request_path ] = $row->target_path;
				$route[ "business/" . $arr['lang_id']. "/". $row->request_path ] = $row->target_path;
			}
		}
		foreach($allow_lang  as $arr){
			$allow[]=$arr['lang_id'];
			$route[ $arr['lang_id']. "/(:any)"] = "$1";
			$route[ "customer/" . $arr['lang_id']. "/(:any)"] = "$1";
			$route[ "business/" . $arr['lang_id']. "/(:any)"] = "$1";
			$route[ "customer/" . $arr['lang_id']. "/"] = "home";
			$route[ "business/" . $arr['lang_id']. "/"] = "home";
		}
		$cms_dyn_route = $route;
	}
}