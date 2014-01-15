<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: bank_master Model
	+ Description	: For record model process back-end
	+ Filename 		: c_bank_master.php
 	+ Author  		: 
 	+ Created on 13/Oct/2009 10:17:38
	
*/

class M_bank_master extends Model{
		
		//constructor
		function M_bank_master() {
			parent::Model();
		}
		
		//function for get list record
		function bank_master_list($filter,$start,$end){
			$query = "SELECT * FROM bank_master";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (mbank_nama LIKE '%".addslashes($filter)."%' OR mbank_keterangan LIKE '%".addslashes($filter)."%' )";
			}
			
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
		function bank_master_update($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ){
			if ($mbank_aktif=="")
				$mbank_aktif = "Aktif";
			$data = array(
				"mbank_id"=>$mbank_id, 
				"mbank_nama"=>$mbank_nama, 
				"mbank_keterangan"=>$mbank_keterangan, 
				"mbank_aktif"=>$mbank_aktif, 
				"mbank_update"=>$_SESSION[SESSION_USERID],			
				"mbank_date_update"=>date('Y-m-d H:i:s'),			
			);
			$this->db->where('mbank_id', $mbank_id);
			$this->db->update('bank_master', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE bank_master set mbank_revised=(mbank_revised+1) WHERE mbank_id='".$mbank_id."'";
				$this->db->query($sql);
			}
			return '1';
		}
		
		//function for create new record
		function bank_master_create($mbank_nama ,$mbank_keterangan ,$mbank_aktif ){
			if ($mbank_aktif=="")
				$mbank_aktif = "Aktif";
			$data = array(
				"mbank_nama"=>$mbank_nama, 
				"mbank_keterangan"=>$mbank_keterangan, 
				"mbank_aktif"=>$mbank_aktif,
				"mbank_creator"=>$_SESSION[SESSION_USERID],	
				"mbank_date_create"=>date('Y-m-d H:i:s'),	
				"mbank_revised"=>'0'
			);
			$this->db->insert('bank_master', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function bank_master_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the bank_masters at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM bank_master WHERE mbank_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM bank_master WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "mbank_id= ".$pkid[$i];
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
		function bank_master_search($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$start,$end){
			if ($mbank_aktif=="")
				$mbank_aktif = "Aktif";
			//full query
			$query="select * from bank_master";
			
			if($mbank_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mbank_id LIKE '%".$mbank_id."%'";
			};
			if($mbank_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mbank_nama LIKE '%".$mbank_nama."%'";
			};
			if($mbank_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mbank_keterangan LIKE '%".$mbank_keterangan."%'";
			};
			if($mbank_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mbank_aktif LIKE '%".$mbank_aktif."%'";
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
		function bank_master_print($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$option,$filter){
			//full query
			$query="select * from bank_master";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (mbank_id LIKE '%".addslashes($filter)."%' OR mbank_nama LIKE '%".addslashes($filter)."%' OR mbank_keterangan LIKE '%".addslashes($filter)."%' OR mbank_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($mbank_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_id LIKE '%".$mbank_id."%'";
				};
				if($mbank_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_nama LIKE '%".$mbank_nama."%'";
				};
				if($mbank_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_keterangan LIKE '%".$mbank_keterangan."%'";
				};
				if($mbank_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_aktif LIKE '%".$mbank_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function bank_master_export_excel($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$option,$filter){
			//full query
			$query="SELECT
						`bank_master`.`mbank_nama` AS `nama`,
						`bank_master`.`mbank_keterangan` AS `keterangan`,
						`bank_master`.`mbank_aktif` AS `aktif`
					from bank_master";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (mbank_id LIKE '%".addslashes($filter)."%' OR mbank_nama LIKE '%".addslashes($filter)."%' OR mbank_keterangan LIKE '%".addslashes($filter)."%' OR mbank_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($mbank_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_id LIKE '%".$mbank_id."%'";
				};
				if($mbank_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_nama LIKE '%".$mbank_nama."%'";
				};
				if($mbank_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_keterangan LIKE '%".$mbank_keterangan."%'";
				};
				if($mbank_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mbank_aktif LIKE '%".$mbank_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>