<?php
class Languagemodel extends CI_Model{
	function __construct(){
		parent:: __construct();
		$this->get_language();
	}
	
	function uritosession($uri){

		/* Stripped language from URI - Start */
		$aUri = explode('/', $uri);
		unset( $aUri[0] );
		$uri = implode('/', $aUri);
		/* Stripped language from URI - End */

		$aSession = array(
			'uri' => $uri
		);

		$this->session->set_userdata('urisession', $aSession);
	}
	
	function switch_language($lang=DEFAULT_LANGUAGE){
		$aSession = array(
			'lang' => $lang
		);
		
		$this->session->set_userdata('languagesession', $aSession);
	}
	
	function get_language(){
		$aLang = $this->session->userdata('languagesession');
		$lang_slug = ( $this->uri->segment(1) == 'en' || $this->uri->segment(1) == 'th' ? $this->uri->segment(1) : 'th' );
		//$aLocalization = $this->session->userdata( 'localizeSess' );
		if($lang_slug){
			$lang = $lang_slug;
		}else{
			
			if( !$aLang ){

				$lang = DEFAULT_LANGUAGE;

				$aSession = array(
					'lang' => $lang
				);
				
				$this->session->set_userdata('languagesession', $aSession);

			}else{
				$lang = $aLang['lang'];
			}

		}
		return $lang;
	}
}
?>