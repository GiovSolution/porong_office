<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_setup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_member_setup.php
 	+ creator 		: 
 	+ Created on 06/Apr/2010 12:55:05
	
*/

class M_iklan_today extends Model{
		
		//constructor
		function M_iklan_today() {
			parent::Model();
		}
		
		//function for get list record
		function iklan_today_list($filter,$start,$end){
			$query = "SELECT * FROM iklan_today";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (iklantoday_id LIKE '%".addslashes($filter)."%' OR iklantoday_tanggal LIKE '%".addslashes($filter)."%' OR iklantoday_keterangan LIKE '%".addslashes($filter)."%' OR iklantoday_author LIKE '%".addslashes($filter)."%' OR iklantoday_date_create LIKE '%".addslashes($filter)."%' OR iklantoday_update LIKE '%".addslashes($filter)."%' OR iklantoday_date_update LIKE '%".addslashes($filter)."%' OR iklantoday_revised LIKE '%".addslashes($filter)."%' )";
			}
			
			
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
		
		//function for create new record
		function iklan_today_create($iklantoday_tanggal, $iklantoday_keterangan,$iklantoday_author ,$iklantoday_date_create){
			$data = array(
				"iklantoday_tanggal"=>$iklantoday_tanggal,
				"iklantoday_keterangan"=>$iklantoday_keterangan,
				"iklantoday_author"=>$iklantoday_author, 
				"iklantoday_date_create"=>$iklantoday_date_create 
			);
			$this->db->insert('iklan_today', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function iklan_today_update($iklantoday_id, $iklantoday_tanggal, $iklantoday_keterangan, $iklantoday_update, $iklantoday_date_update){
			$data = array(
				"iklantoday_tanggal"=>$iklantoday_tanggal,
				"iklantoday_keterangan"=>$iklantoday_keterangan, 				
				"iklantoday_update"=>$iklantoday_update, 
				"iklantoday_date_update"=>$iklantoday_date_update 
			);
			
			//$this->db->where('setmember_id', $setmember_id);
			$this->db->update('iklan_today', $data);
			$sql="UPDATE iklan_today set iklantoday_revised=(iklantoday_revised+1)";
			$this->db->query($sql);
			return '1';
		}
		
		//fcuntion for delete record
		function member_setup_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the member_setups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM member_setup WHERE setmember_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM member_setup WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "setmember_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function member_setup_search($setmember_id ,$setmember_transhari, $setmember_pointhari ,$setmember_transbulan, $setmember_pointbulan ,$setmember_periodeaktif ,$setmember_periodetenggang ,$setmember_transtenggang, $setmember_pointtenggang ,$setmember_author ,$setmember_date_create ,$setmember_update ,$setmember_date_update ,$setmember_revised ,$start,$end){
			//full query
			$query="select * from member_setup";
			
			if($setmember_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_id LIKE '%".$setmember_id."%'";
			};
			if($setmember_transhari!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_transhari LIKE '%".$setmember_transhari."%'";
			};
			if($setmember_transbulan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_transbulan LIKE '%".$setmember_transbulan."%'";
			};
			if($setmember_periodeaktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_periodeaktif LIKE '%".$setmember_periodeaktif."%'";
			};
			if($setmember_periodetenggang!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_periodetenggang LIKE '%".$setmember_periodetenggang."%'";
			};
			if($setmember_transtenggang!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_transtenggang LIKE '%".$setmember_transtenggang."%'";
			};
			if($setmember_author!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_author LIKE '%".$setmember_author."%'";
			};
			if($setmember_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_date_create LIKE '%".$setmember_date_create."%'";
			};
			if($setmember_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_update LIKE '%".$setmember_update."%'";
			};
			if($setmember_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_date_update LIKE '%".$setmember_date_update."%'";
			};
			if($setmember_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setmember_revised LIKE '%".$setmember_revised."%'";
			};
			
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
		
		//function for print record
		function member_setup_print($setmember_id ,$setmember_transhari, $setmember_pointhari ,$setmember_transbulan, $setmember_pointbulan ,$setmember_periodeaktif ,$setmember_periodetenggang ,$setmember_transtenggang, $setmember_pointtenggang ,$setmember_author ,$setmember_date_create ,$setmember_update ,$setmember_date_update ,$setmember_revised ,$option,$filter){
			//full query
			$sql="select * from member_setup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (setmember_id LIKE '%".addslashes($filter)."%' OR setmember_transhari LIKE '%".addslashes($filter)."%' OR setmember_transbulan LIKE '%".addslashes($filter)."%' OR setmember_periodeaktif LIKE '%".addslashes($filter)."%' OR setmember_periodetenggang LIKE '%".addslashes($filter)."%' OR setmember_transtenggang LIKE '%".addslashes($filter)."%' OR setmember_author LIKE '%".addslashes($filter)."%' OR setmember_date_create LIKE '%".addslashes($filter)."%' OR setmember_update LIKE '%".addslashes($filter)."%' OR setmember_date_update LIKE '%".addslashes($filter)."%' OR setmember_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($setmember_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_id LIKE '%".$setmember_id."%'";
				};
				if($setmember_transhari!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_transhari LIKE '%".$setmember_transhari."%'";
				};
				if($setmember_transbulan!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_transbulan LIKE '%".$setmember_transbulan."%'";
				};
				if($setmember_periodeaktif!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_periodeaktif LIKE '%".$setmember_periodeaktif."%'";
				};
				if($setmember_periodetenggang!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_periodetenggang LIKE '%".$setmember_periodetenggang."%'";
				};
				if($setmember_transtenggang!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_transtenggang LIKE '%".$setmember_transtenggang."%'";
				};
				if($setmember_author!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_author LIKE '%".$setmember_author."%'";
				};
				if($setmember_date_create!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_date_create LIKE '%".$setmember_date_create."%'";
				};
				if($setmember_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_update LIKE '%".$setmember_update."%'";
				};
				if($setmember_date_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_date_update LIKE '%".$setmember_date_update."%'";
				};
				if($setmember_revised!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setmember_revised LIKE '%".$setmember_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function member_setup_export_excel($setmember_id ,$setmember_transhari, $setmember_pointhari ,$setmember_transbulan, $setmember_pointbulan ,$setmember_periodeaktif ,$setmember_periodetenggang ,$setmember_transtenggang, $setmember_pointtenggang,$setmember_transtenggang ,$setmember_author ,$setmember_date_create ,$setmember_update ,$setmember_date_update ,$setmember_revised ,$option,$filter){
			//full query
			$sql="select * from member_setup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (setmember_id LIKE '%".addslashes($filter)."%' OR setmember_transhari LIKE '%".addslashes($filter)."%' OR setmember_transbulan LIKE '%".addslashes($filter)."%' OR setmember_periodeaktif LIKE '%".addslashes($filter)."%' OR setmember_periodetenggang LIKE '%".addslashes($filter)."%' OR setmember_transtenggang LIKE '%".addslashes($filter)."%' OR setmember_author LIKE '%".addslashes($filter)."%' OR setmember_date_create LIKE '%".addslashes($filter)."%' OR setmember_update LIKE '%".addslashes($filter)."%' OR setmember_date_update LIKE '%".addslashes($filter)."%' OR setmember_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($setmember_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_id LIKE '%".$setmember_id."%'";
				};
				if($setmember_transhari!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_transhari LIKE '%".$setmember_transhari."%'";
				};
				if($setmember_transbulan!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_transbulan LIKE '%".$setmember_transbulan."%'";
				};
				if($setmember_periodeaktif!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_periodeaktif LIKE '%".$setmember_periodeaktif."%'";
				};
				if($setmember_periodetenggang!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_periodetenggang LIKE '%".$setmember_periodetenggang."%'";
				};
				if($setmember_transtenggang!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_transtenggang LIKE '%".$setmember_transtenggang."%'";
				};
				if($setmember_author!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_author LIKE '%".$setmember_author."%'";
				};
				if($setmember_date_create!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_date_create LIKE '%".$setmember_date_create."%'";
				};
				if($setmember_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_update LIKE '%".$setmember_update."%'";
				};
				if($setmember_date_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_date_update LIKE '%".$setmember_date_update."%'";
				};
				if($setmember_revised!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setmember_revised LIKE '%".$setmember_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>