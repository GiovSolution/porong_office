<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: gudang Model
	+ Description	: For record model process back-end
	+ Filename 		: c_gudang.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_gudang extends Model{
		
		//constructor
		function M_gudang() {
			parent::Model();
		}
		
		//function for get list record
		function gudang_list($filter,$start,$end){
			$query = "SELECT * FROM gudang";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' )";
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
		function gudang_update($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ){
			if ($gudang_aktif=="")
				$gudang_aktif = "Aktif";
			$data = array(
				"gudang_id"=>$gudang_id,			
				"gudang_nama"=>$gudang_nama,			
				"gudang_lokasi"=>$gudang_lokasi,			
				"gudang_keterangan"=>$gudang_keterangan,			
				"gudang_aktif"=>$gudang_aktif,			
				"gudang_update"=>$_SESSION[SESSION_USERID],			
				"gudang_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('gudang_id', $gudang_id);
			$this->db->update('gudang', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE gudang set gudang_revised=(gudang_revised+1) WHERE gudang_id='".$gudang_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function gudang_create($gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ){
			if ($gudang_aktif=="")
				$gudang_aktif = "Aktif";
			$data = array(
	
				"gudang_nama"=>$gudang_nama,	
				"gudang_lokasi"=>$gudang_lokasi,	
				"gudang_keterangan"=>$gudang_keterangan,	
				"gudang_aktif"=>$gudang_aktif,	
				"gudang_creator"=>$_SESSION[SESSION_USERID],	
				"gudang_date_create"=>date('Y-m-d H:i:s'),	
				"gudang_update"=>$gudang_update,	
				"gudang_date_update"=>$gudang_date_update,	
				"gudang_revised"=>'0'	
			);
			$this->db->insert('gudang', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function gudang_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the gudangs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM gudang WHERE gudang_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM gudang WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "gudang_id= ".$pkid[$i];
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
		function gudang_search($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$start,$end){
			if($gudang_aktif=="")
				$gudang_aktif="Aktif";
			//full query
			$query="select * from gudang";
			
			if($gudang_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_id LIKE '%".$gudang_id."%'";
			};
			if($gudang_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
			};
			if($gudang_lokasi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
			};
			if($gudang_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
			};
			if($gudang_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
			};
			if($gudang_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
			};
			if($gudang_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
			};
			if($gudang_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_update LIKE '%".$gudang_update."%'";
			};
			if($gudang_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
			};
			if($gudang_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
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
		function gudang_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select * from gudang";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR gudang_update LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($gudang_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_update LIKE '%".$gudang_update."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function gudang_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select 	gudang_nama AS nama,
							gudang_lokasi AS lokasi,
							gudang_keterangan AS keterangan,
							gudang_aktif AS aktif

					from gudang";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR gudang_update LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($gudang_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_update LIKE '%".$gudang_update."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>