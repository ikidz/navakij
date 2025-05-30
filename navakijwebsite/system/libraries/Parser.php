<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Parser Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/parser.html
 */
class CI_Parser {

	var $l_delim = '{';
	var $r_delim = '}';
	var $object;
	var $ci;

	/**
	 *  Parse a template
	 *
	 * Parses pseudo-variables contained in the specified template view,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	public function parse($template, $data, $return = FALSE)
	{
		$CI =& get_instance();
		$this->ci=& get_instance();
		$template = $CI->load->view($template, $data, TRUE);

		return $this->_parse($template, $data, $return);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse a String
	 *
	 * Parses pseudo-variables contained in the specified string,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function parse_string($template, $data, $return = FALSE)
	{
		return $this->_parse($template, $data, $return);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse a template
	 *
	 * Parses pseudo-variables contained in the specified template,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function _parse($template, $data, $return = FALSE)
	{
		if ($template == '')
		{
			return FALSE;
		}
		foreach($data as $n=>$v){
			$$n=$v;	
		}
		//$template = $this->_parse_function_statements($template,$data);
		$template = $this->_parse_function($template,$data);
		$output = @ob_get_contents();
		@ob_end_clean();
		ob_start();
		$response = eval(' ?> '.$template.' <?php ');
		$template = $output . @ob_get_contents(); 
		@ob_end_clean();
		foreach ($data as $key => $val)
		{
			if (is_array($val))
			{
				$template = $this->_parse_pair($key, $val, $template);
			}
			else
			{
				$template = $this->_parse_single($key, (string)$val, $template);
			}
			
		}

		if ($return == FALSE)
		{
			$CI =& get_instance();
			$CI->output->append_output($template);
		}

		return $template;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the left/right variable delimiters
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	function set_delimiters($l = '{', $r = '}')
	{
		$this->l_delim = $l;
		$this->r_delim = $r;
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse a single key/value
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function _parse_single($key, $val, $string)
	{
		return str_replace($this->l_delim.$key.$this->r_delim, $val, $string);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse a tag pair
	 *
	 * Parses tag pairs:  {some_tag} string... {/some_tag}
	 *
	 * @access	private
	 * @param	string
	 * @param	array
	 * @param	string
	 * @return	string
	 */
	function _parse_pair($variable, $data, $string)
	{
		if (FALSE === ($match = $this->_match_pair($string, $variable)))
		{
			return $string;
		}

		$str = '';
		foreach ($data as $row)
		{
			$temp = $match['1'];
			foreach ($row as $key => $val)
			{
				if ( ! is_array($val))
				{
					$temp = $this->_parse_single($key, $val, $temp);
				}
				else
				{
					$temp = $this->_parse_pair($key, $val, $temp);
				}
			}

			$str .= $temp;
		}

		return str_replace($match['0'], $str, $string);
	}

	// --------------------------------------------------------------------

	/**
	 *  Matches a variable pair
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	function _match_pair($string, $variable)
	{
		if ( ! preg_match("|" . preg_quote($this->l_delim) . $variable . preg_quote($this->r_delim) . "(.+?)". preg_quote($this->l_delim) . '/' . $variable . preg_quote($this->r_delim) . "|s", $string, $match))
		{
			return FALSE;
		}

		return $match;
	}
	function _parse_function($template, $data)
	{
		
		$allow_func = array();
		$allow_func['count']=array("echo count({condition})",";");
		$allow_func['get']=array("echo \$this->ci->input->get('{condition}');");
		$allow_func['post']=array("echo \$this->ci->input->post('{condition}');");
		$allow_func['request']=array("echo \$this->ci->input->get_post('{condition}');");
		$allow_func['debug']=array('echo "<pre>"; var_dump({condition});','echo "</pre>";');
		$allow_func['var']=array('$${condition}',";");
		$allow_func['forloop']=array("for({condition}){","}");
		$allow_func['foreach']=array("foreach({condition}){","}");
		$allow_func['if']=array("if({condition}){","}");
		$allow_func['elseif']=array("}elseif({condition}){","}");
		$allow_func['else']=array("}else{");
		
		foreach($allow_func as $function=>$rep){
			if (preg_match_all("|".$this->l_delim . "{$function}(.+?)" . $this->r_delim."(.+?)".$this->l_delim . "/{$function}" . $this->r_delim."|s", $template, $match) ){
				
				for ($offset = 0; $offset < sizeof($match[0]); $offset++){
				//if(strpos($rep[0],"{condition}") !==false && trim($match[1][$offset])){
					$body = $this->_parse_function($match[2][$offset],$data);
					$body = $this->_parse_strval($body);
					$statement = '<?php ';
					$statement .= str_replace("{condition}",trim($match[1][$offset]),$rep[0]);
					if($body){
					$statement .= " ?>";
					$statement .= $body;
					}else{
						$statement .= " ?>";
					}
					if(@$rep[1]){
						$statement .= "<?php ";
						$statement .= $rep[1];
						$statement .= " ?>"; 
					}
					/*echo $statement;
					$output = @ob_get_contents();
					@ob_end_clean();
					ob_start();
					$response = eval(' ?> '.$statement.' <?php ');
					$output = $output . @ob_get_contents();
					@ob_end_clean();*/
					$template = str_replace($match[0][$offset], trim($statement), $template);
				//}
				
				}
			}
			if (preg_match_all("|".$this->l_delim . "{$function}(.+?)" . " /" . $this->r_delim."|s", $template, $match) ){
				
				for ($offset = 0; $offset < sizeof($match[0]); $offset++){
				//if(strpos($rep[0],"{condition}") !==false && trim($match[1][$offset])){
					$body = $this->_parse_function(@$match[2][$offset],$data);
					$body = $this->_parse_strval($body);
					$statement = '<?php ';
					$statement .= str_replace("{condition}",trim($match[1][$offset]),$rep[0]);
					if($body){
					$statement .= " ?>";
					$statement .= $body;
					}else{
						$statement .= " ?>";
					}
					if(@$rep[1]){
						$statement .= "<?php ";
						$statement .= $rep[1];
						$statement .= " ?>"; 
					}
					/*$output = @ob_get_contents();
					@ob_end_clean();
					ob_start();
					$response = eval(' ?> '.$statement.' <?php ');
					$output = $output . @ob_get_contents();
					@ob_end_clean();*/
					$template = str_replace($match[0][$offset], trim($statement), $template);
				//}
				
				}
			}
			if (preg_match_all("|".$this->l_delim . "{$function}(.+?)" . $this->r_delim."|s", $template, $match) ){
				
				for ($offset = 0; $offset < sizeof($match[0]); $offset++){
				//if(strpos($rep[0],"{condition}") !==false && trim($match[1][$offset])){
					if(@$match[2][$offset]){
					$body = $this->_parse_function($match[2][$offset],$data);
					$body = $this->_parse_strval($body);
					}else{
						$body = NULL;	
					}
					$statement = '<?php ';
					$statement .= str_replace("{condition}",trim($match[1][$offset]),$rep[0]);
					if($body){
					$statement .= " ?>";
					$statement .= $body;
					}else{
						$statement .= " ?>";
					}
					if(@$rep[1]){
						$statement .= " <?php ";
						$statement .= $rep[1];
						$statement .= " ?>"; 
					}
					/*$output = @ob_get_contents();
					@ob_end_clean();
					ob_start();
					$response = eval(' ?> '.$statement.' <?php ');
					$output = $output . @ob_get_contents();
					@ob_end_clean();*/
					$template = str_replace($match[0][$offset], trim($statement), $template);
				//}
				
				}
			}
		}
		$template = $this->_parse_strval($template);
		return $template;
	}
	function _parse_strval($template)
	{
		if (preg_match_all("|".$this->l_delim . "\\$(.+?)" . $this->r_delim."|s", $template, $match) ){
			for ($offset = 0; $offset < sizeof($match[0]); $offset++)
        	{
				$template = str_replace($match[0][$offset], '<?php echo $' . $match['1'][$offset] . '; ?>', $template);
			}
		}
		return $template;
	}
	function _parse_function_statements($template, $data)
    {
        if ( ! preg_match_all("|".$this->l_delim . "if (.+?)" . $this->r_delim."(.+?)".$this->l_delim . "endif" . $this->r_delim."|s", $template, $match) )
        {
            return $template;
        }
        for ($offset = 0; $offset < sizeof($match[0]); $offset++)
        {
            $return = array();
            $return['original'] = trim($match[0][$offset]);
            $return['keyword'] = trim($match[1][$offset]);
            $return['if_data'] = trim($match[2][$offset]);

            if ( preg_match_all("|(.*?)".$this->l_delim . "else" . $this->r_delim . "(.*)|s", $match[2][$offset], $else_match) ) {
                $return['else_left'] = trim($else_match[1][0]);
                $return['else_right'] = trim($else_match[2][0]);
            } else {
                $return['else_left'] =  $return['if_data'];
                $return['else_right'] = '';
            }

            $statement = $return['keyword'];
            foreach ( $data as $key => $var ) {
                if (strpos($statement, '$'.$key) !== FALSE) {
                    $statement = str_replace('$'.$key, '$data[\''.$key.'\']', $statement);
                }
            }
            $result = '';
            $eval = "\$result = (" . $statement . ") ? 'true' : 'false';";
            eval($eval);

            if ( $result == 'true' ) {
                if ( isset($else_match) && isset($return['else_left']) ) $template = str_replace($return['original'], $return['else_left'], $template);
            } else {
                if ( isset($else_match) && isset($return['else_right'])  ) $template = str_replace($return['original'], $return['else_right'], $template);
                else $template = str_replace($return['original'], $return['if_data'], $template);
            }
        }

        return $template;
    } 

}
// END Parser Class

/* End of file Parser.php */
/* Location: ./system/libraries/Parser.php */
