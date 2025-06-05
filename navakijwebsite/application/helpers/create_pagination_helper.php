<?php
if ( ! function_exists('create_pagination'))
{
	function create_pagination($url,$total_rows,$perpage,$uri_segment=3)
	{
		$CI =& get_instance();
		$curr_page = intval($CI->uri->segment($uri_segment));
		$curr_page = ($curr_page < 1)?1:$curr_page;
		$curr = intval($curr_page-1)*$perpage;
		$end = intval($curr_page)*$perpage;
		$curr = ($curr < 0)?0:$curr;
		$curr = $curr+1;
		$end = ($end < 1)?1:$end;
		$CI->load->library('pagination');
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = admin_url($url);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $perpage; 
		$config['uri_segment'] = $uri_segment;
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next →';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '← Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['full_tag_open'] = '<div class="row-fluid">
  <div class="span6">
    <div class="dataTables_info" id="sample_1_info">Showing '.$curr.' to '.$end.' of '.$total_rows.' entries</div>
  </div>
  <div class="span6">
    <div class="dataTables_paginate paging_bootstrap pagination">
      <ul>';
		$config['full_tag_close'] = '</ul>
    </div>
  </div>
</div>
';
		$CI->pagination->initialize($config); 
		
		echo $CI->pagination->create_links();
	}
}
?>