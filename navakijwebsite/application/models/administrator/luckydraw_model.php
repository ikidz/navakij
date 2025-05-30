<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Project Name : CI Master V3
* Build Date : 2/25/2558 BE
* Author Name : Jarak Kritkiattisak
* File Name : luckydraw_model.php
* File Location : /Volumes/Macintosh HD/Users/mycools/Documents/htdocs/cimaster_v3/application/models/administrator
* File Type : Model	
* Remote URL : /application/models/administrator/luckydraw_model.php
*/
class luckydraw_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	/**
	* Get keydate DataTable
	*
	* Get Record from table "lucky_keydate"
	*
	* @param	integer
	* @param	integer
	* @return	object
	*/
	public function getKeydateDataTable($limit=100,$page=1)
	{
		// Calculate page nunber to database offset.
		$offset = $this->_pageOffset($limit,$page);
		// Set query condition
		//$this->db->where("key_status","approved");
		$this->db->limit($limit,$offset);
		$lucky_keydate=$this->db->get("lucky_keydate");
		// Return database result.
		return $lucky_keydate;
	}
	/**
	* Get keydate datatable record count
	*
	* Get Total Record Count from table "lucky_keydate"
	*
	* @return	integer
	*/
	public function getKeydateDataTableCount()
	{
		// Set query condition
		//$this->db->where("key_status","approved");
		$lucky_keydate=$this->db->count_all_results("lucky_keydate");
		// Return total record.
		return $lucky_keydate;
	}
	
	public function getTempDataTable($limit=100,$page=1)
	{
		// Calculate page nunber to database offset.
		$offset = $this->_pageOffset($limit,$page);
		// Set query condition
		//$this->db->where("key_status","approved");
		$this->db->limit($limit,$offset);
		$lucky_keydate=$this->db->get("lucky_list_tmp");
		// Return database result.
		return $lucky_keydate;
	}
	/**
	* Get keydate datatable record count
	*
	* Get Total Record Count from table "lucky_keydate"
	*
	* @return	integer
	*/
	public function getTempDataTableCount()
	{
		// Set query condition
		//$this->db->where("key_status","approved");
		$lucky_keydate=$this->db->count_all_results("lucky_list_tmp");
		// Return total record.
		return $lucky_keydate;
	}
	
	/**
	* Page offset calculate
	*
	* Calculate page number to database offset
	*
	* @param	integer
	* @param	integer
	* @return	integer
	*/
	private function _pageOffset($limit=100,$page=1)
	{
		$page 	= (int) ($page-1);
		$page 	= (int) ($page < 0)?0:$page;
		$offset	= (int) ($page*$limit);
		$offset	= (int) ($offset < 0)?0:$offset;
		return $offset;
	}
}

/* End of file luckydraw_model.php */
/* Location: ./application/models/luckydraw_model.php */