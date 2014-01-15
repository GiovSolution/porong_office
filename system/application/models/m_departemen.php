<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: departemen Model
	+ Description	: For record model process back-end
	+ Filename 		: c_departemen.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 06/Aug/2009 15:46:36
	
*/

class M_departemen extends Model{
		
		//constructor
		function M_departemen() {
			parent::Model();
		}
		
		//function for get list record
		function departemen_list($filter,$start,$end){
			$query = "SELECT * FROM departemen";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (departemen_id LIKE '%".addslashes($filter)."%' OR departemen_nama LIKE '%".addslashes($filter)."%' OR departemen_keterangan LIKE '%".addslashes($filter)."%' OR departemen_aktif LIKE '%".addslashes($filter)."%' )";
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
		function departemen_update($departemen_id ,$departemen_nama ,$departemen_kode_akun,$departemen_keterangan ,$departemen_aktif ){
			if ($departemen_aktif=="")
				$departemen_aktif = "Aktif";
			$data = array(
				"departemen_id"=>$departemen_id,			
				"departemen_nama"=>$departemen_nama,
				"departemen_kode_akun"=>$departemen_kode_akun,				
				"departemen_keterangan"=>$departemen_keterangan,			
				"departemen_aktif"=>$departemen_aktif,			
//				"departemen_creator"=>$departemen_creator,			
//				"departemen_date_create"=>$departemen_date_create,			
				"departemen_update"=>$_SESSION[SESSION_USERID],			
				"departemen_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('departemen_id', $departemen_id);
			$this->db->update('departemen', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE departemen set departemen_revised=(departemen_revised+1) WHERE departemen_id='".$departemen_id."'";
				$this->db->query($sql);
			}
			return '1';
		}
		
		//function for create new record
		function departemen_create($departemen_nama ,$departemen_kode_akun,$departemen_keterangan ,$departemen_aktif ){
			if ($departemen_aktif=="")
				$departemen_aktif = "Aktif";
			$data = array(
	
				"departemen_nama"=>$departemen_nama,
				"departemen_kode_akun"=>$departemen_kode_akun,				
				"departemen_keterangan"=>$departemen_keterangan,	
				"departemen_aktif"=>$departemen_aktif,	
				"departemen_creator"=>$_SESSION[SESSION_USERID],	
				"departemen_date_create"=>date('Y-m-d H:i:s'),	
//				"departemen_update"=>$departemen_update,	
//				"departemen_date_update"=>$departemen_date_update,	
				"departemen_revised"=>'0'
			);
			$this->db->insert('departemen', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function departemen_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the departemens at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM departemen WHERE departemen_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM departemen WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "departemen_id= ".$pkid[$i];
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
		function departemen_search($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$start,$end){
			if ($departemen_aktif=="")
				$departemen_aktif = "Aktif";
			//full query
			$query="select * from departemen";
			
			if($departemen_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " departemen_id LIKE '%".$departemen_id."%'";
			};
			if($departemen_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " departemen_nama LIKE '%".$departemen_nama."%'";
			};
			if($departemen_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " departemen_keterangan LIKE '%".$departemen_keterangan."%'";
			};
			if($departemen_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " departemen_aktif LIKE '%".$departemen_aktif."%'";
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
		function departemen_print($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$option,$filter){
			//full query
			$query="select * from departemen";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (departemen_id LIKE '%".addslashes($filter)."%' OR departemen_nama LIKE '%".addslashes($filter)."%' OR departemen_keterangan LIKE '%".addslashes($filter)."%' OR departemen_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($departemen_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_id LIKE '%".$departemen_id."%'";
				};
				if($departemen_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_nama LIKE '%".$departemen_nama."%'";
				};
				if($departemen_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_keterangan LIKE '%".$departemen_keterangan."%'";
				};
				if($departemen_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_aktif LIKE '%".$departemen_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function departemen_export_excel($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$option,$filter){
			//full query
			$query="select departemen_nama AS nama,
							departemen_keterangan AS keterangan,
							departemen_aktif AS aktif
					from departemen";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (departemen_id LIKE '%".addslashes($filter)."%' OR departemen_nama LIKE '%".addslashes($filter)."%' OR departemen_keterangan LIKE '%".addslashes($filter)."%' OR departemen_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($departemen_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_id LIKE '%".$departemen_id."%'";
				};
				if($departemen_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_nama LIKE '%".$departemen_nama."%'";
				};
				if($departemen_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_keterangan LIKE '%".$departemen_keterangan."%'";
				};
				if($departemen_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " departemen_aktif LIKE '%".$departemen_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>