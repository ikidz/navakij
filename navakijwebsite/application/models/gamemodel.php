<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Project Name : Lactasoycampaign.com
* Build Date : 12/24/2557 BE
* Author Name : Jarak Kritkiattisak
* File Name : gamemodel.php
* File Location : /Volumes/Macintosh HD/Users/mycools/Library/Caches/Coda 2/C1748AD6-4670-437C-A779-C23F1D3A2E1C
* File Type : Model	
* Remote URL : http://www.lactasoycampaign.com/standbyyou/application/models/gamemodel.php
*/
class Gamemodel extends CI_Model {
	public function gettoptanking()
	{
		/* Index Coding - Start */
		return $this->db->query('SELECT u.id,u.fbname,u.game_score ,u.profile_image,
CASE 
WHEN @prevRank = game_score THEN @curRank 
WHEN @prevRank := game_score THEN @curRank := @curRank + 1
END AS rank
FROM users u, 
(SELECT @curRank :=0, @prevRank := NULL) r
WHERE u.game_score > 0
AND u.status = "authorize"
ORDER BY u.game_score DESC LIMIT 100')->result_array();
		/* Index Coding - End */
	}
}

/* End of file gamemodel.php */
/* Location: ./application/controllers/gamemodel.php */