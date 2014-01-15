<? /* 	
	
	+ Module  		: Penyesuaian Tindakan
	+ Description	: For record model process back-end
	+ Filename 		: m_penyesuaian_tindakan.php
 	+ Author  		: Fred
	
*/

class M_penyesuaian_tindakan extends Model{
		
		//constructor
		function M_penyesuaian_tindakan() {
			parent::Model();
		}
		
		//function for get list record
		function penyesuaian_list($filter,$start,$end){

		$bln_now = date('Y-m');
		
			$query="
			select 
				tindakan_adjust.adj_id, 
				date_format(tindakan_adjust.adj_bln,'%Y-%m'), 
				karyawan.karyawan_username, 
				adj_count, 
				vu_report_tindakan_terapis.terapis_count+ifnull(vu_report_tindakan_terapis_hf.terapis_count,0) as terapis_count, 
				(vu_report_tindakan_terapis.terapis_count+ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as new_count,
				'A' as diff
			from tindakan_adjust 
			left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=tindakan_adjust.karyawan_id) and vu_report_tindakan_terapis.terapis_bulan=date_format(tindakan_adjust.adj_bln,'%Y-%m')
			left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=tindakan_adjust.karyawan_id) and vu_report_tindakan_terapis_hf.terapis_bulan=date_format(tindakan_adjust.adj_bln,'%Y-%m')
			left join karyawan on karyawan.karyawan_id=tindakan_adjust.karyawan_id where date_format(tindakan_adjust.adj_bln, '%Y-%m') = '$bln_now'";
			// For simple search
			/*if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_id LIKE '%".addslashes($filter)."%' OR user_name LIKE '%".addslashes($filter)."%' OR user_passwd LIKE '%".addslashes($filter)."%' OR user_karyawan LIKE '%".addslashes($filter)."%' OR user_log LIKE '%".addslashes($filter)."%' OR user_groups LIKE '%".addslashes($filter)."%' OR user_aktif LIKE '%".addslashes($filter)."%' )";
			}*/
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			
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
		
		//function for update record
		function penyesuaian_update($adj_id, $adj_count){
	
		$sql="select * from tindakan_adjust where adj_id = '$adj_id'";
	
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
		$data = array(
		
				"adj_count"=>$adj_count
			);
			$this->db->where('adj_id', $adj_id);
			$this->db->update('tindakan_adjust', $data);
		}
	
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		
		//function for print record
		/*function users_print($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query="select * from users";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_id LIKE '%".addslashes($filter)."%' OR user_name LIKE '%".addslashes($filter)."%' OR user_passwd LIKE '%".addslashes($filter)."%' OR user_karyawan LIKE '%".addslashes($filter)."%' OR user_log LIKE '%".addslashes($filter)."%' OR user_groups LIKE '%".addslashes($filter)."%' OR user_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($user_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_id LIKE '%".$user_id."%'";
				};
				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_passwd!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_passwd LIKE '%".$user_passwd."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan LIKE '%".$user_karyawan."%'";
				};
				if($user_log!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_log LIKE '%".$user_log."%'";
				};
				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups LIKE '%".$user_groups."%'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}*/
		
		//function  for export to excel
		/*function users_export_excel($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query="select * from users";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_id LIKE '%".addslashes($filter)."%' OR user_name LIKE '%".addslashes($filter)."%' OR user_passwd LIKE '%".addslashes($filter)."%' OR user_karyawan LIKE '%".addslashes($filter)."%' OR user_log LIKE '%".addslashes($filter)."%' OR user_groups LIKE '%".addslashes($filter)."%' OR user_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($user_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_id LIKE '%".$user_id."%'";
				};
				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_passwd!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_passwd LIKE '%".$user_passwd."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan LIKE '%".$user_karyawan."%'";
				};
				if($user_log!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_log LIKE '%".$user_log."%'";
				};
				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups LIKE '%".$user_groups."%'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}*/
		

}
?>