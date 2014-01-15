<? /* 	
	
	+ Module  		: Welcome Message Model
	+ Description	: For record model process back-end
	+ Filename 		: c_report_top_spender.php
 	+ Author  		: Isaac
*/

class M_report_welcome_msg extends Model{
		
	//constructor
	function M_report_welcome_msg() {
		parent::Model();
	}

		//function for advanced search record
		function welcome_msg_search(){
			//full query
			$group_id = $_SESSION[SESSION_GROUPID];
			$query =   "select
							w.welcome_group,
							w.welcome_tglawal,
							w.welcome_tglakhir,
							w.welcome_msg,
							w.welcome_title
						from welcome_msg as w
						where
							w.welcome_group='".$group_id."'
						order by w.welcome_tglawal desc ";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		
}
?>