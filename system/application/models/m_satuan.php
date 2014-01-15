<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: satuan Model
	+ Description	: For record model process back-end
	+ Filename 		: c_satuan.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_satuan extends Model{
		
		//constructor
		function M_satuan() {
			parent::Model();
		}
		
		//function for get list record
		function satuan_list($filter,$start,$end){
			$query = "SELECT * FROM satuan";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (satuan_kode LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' )";
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
		function satuan_update($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ){
		if ($satuan_aktif=="")
			$satuan_aktif = "Aktif";
			$data = array(
				"satuan_id"=>$satuan_id,			
				"satuan_kode"=>$satuan_kode,			
				"satuan_nama"=>$satuan_nama,			
				"satuan_aktif"=>$satuan_aktif,			
				"satuan_update"=>$_SESSION[SESSION_USERID],			
				"satuan_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('satuan_id', $satuan_id);
			$this->db->update('satuan', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE satuan set satuan_revised=(satuan_revised+1) WHERE satuan_id='".$satuan_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function satuan_create($satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ){
		if ($satuan_aktif=="")
			$satuan_aktif = "Aktif";
			$data = array(
	
				"satuan_kode"=>$satuan_kode,	
				"satuan_nama"=>$satuan_nama,	
				"satuan_aktif"=>$satuan_aktif,	
				"satuan_creator"=>$_SESSION[SESSION_USERID],			
				"satuan_date_create"=>date('Y-m-d H:i:s'),			
				"satuan_update"=>$satuan_update,	
				"satuan_date_update"=>$satuan_date_update,	
				"satuan_revised"=>'0'	
			);
			$this->db->insert('satuan', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function satuan_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the satuans at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM satuan WHERE satuan_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM satuan WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "satuan_id= ".$pkid[$i];
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
		function satuan_search($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$start,$end){
			if($satuan_aktif=="")
				$satuan_aktif="Aktif";
			//full query
			$query="select * from satuan";
			
			if($satuan_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_id LIKE '%".$satuan_id."%'";
			};
			if($satuan_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_kode LIKE '%".$satuan_kode."%'";
			};
			if($satuan_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_nama LIKE '%".$satuan_nama."%'";
			};
			if($satuan_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_aktif LIKE '%".$satuan_aktif."%'";
			};
			if($satuan_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_creator LIKE '%".$satuan_creator."%'";
			};
			if($satuan_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_date_create LIKE '%".$satuan_date_create."%'";
			};
			if($satuan_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_update LIKE '%".$satuan_update."%'";
			};
			if($satuan_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_date_update LIKE '%".$satuan_date_update."%'";
			};
			if($satuan_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_revised LIKE '%".$satuan_revised."%'";
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
		function satuan_print($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$option,$filter){
			//full query
			$query="select * from satuan ";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (satuan_id LIKE '%".addslashes($filter)."%' OR satuan_kode LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR satuan_aktif LIKE '%".addslashes($filter)."%' OR satuan_creator LIKE '%".addslashes($filter)."%' OR satuan_date_create LIKE '%".addslashes($filter)."%' OR satuan_update LIKE '%".addslashes($filter)."%' OR satuan_date_update LIKE '%".addslashes($filter)."%' OR satuan_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($satuan_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_kode LIKE '%".$satuan_kode."%'";
				};
				if($satuan_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($satuan_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_aktif LIKE '%".$satuan_aktif."%'";
				};
				if($satuan_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_creator LIKE '%".$satuan_creator."%'";
				};
				if($satuan_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_date_create LIKE '%".$satuan_date_create."%'";
				};
				if($satuan_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_update LIKE '%".$satuan_update."%'";
				};
				if($satuan_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_date_update LIKE '%".$satuan_date_update."%'";
				};
				if($satuan_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_revised LIKE '%".$satuan_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function satuan_export_excel($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$option,$filter){
			//full query
			$query="SELECT 	satuan_kode AS kode,
							satuan_nama AS nama,
							satuan_aktif AS aktif
							
					from 	satuan ";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (satuan_id LIKE '%".addslashes($filter)."%' OR satuan_kode LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR satuan_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($satuan_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_kode LIKE '%".$satuan_kode."%'";
				};
				if($satuan_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($satuan_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_aktif LIKE '%".$satuan_aktif."%'";
				};
/* 				if($satuan_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_creator LIKE '%".$satuan_creator."%'";
				};
				if($satuan_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_date_create LIKE '%".$satuan_date_create."%'";
				};
				if($satuan_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_update LIKE '%".$satuan_update."%'";
				};
				if($satuan_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_date_update LIKE '%".$satuan_date_update."%'";
				};
				if($satuan_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " satuan_revised LIKE '%".$satuan_revised."%'";
				};
 */				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>