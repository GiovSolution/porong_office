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

class M_aset_group extends Model{
		
		//constructor
		function M_aset_group() {
			parent::Model();
		}
		
		//function for get list record
		function group_aset_list($filter,$start,$end){
			$query = "SELECT * FROM aset_grup";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (aset_grup_kode LIKE '%".addslashes($filter)."%' OR aset_grup_nama LIKE '%".addslashes($filter)."%' OR aset_grup_keterangan LIKE '%".addslashes($filter)."%' )";
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
		function group_aset_update($group_aset_id ,$group_aset_kode ,$group_aset_nama ,$group_aset_kelas ,$group_aset_usia, $group_aset_keterangan, $group_aset_aktif){
			if ($group_aset_aktif=="")
				$group_aset_aktif = "Aktif";
			$data = array(
				"aset_grup_id"=>$group_aset_id,			
				"aset_grup_kode"=>$group_aset_kode,	
				"aset_grup_nama"=>$group_aset_nama,	
				"aset_grup_kelas"=>$group_aset_kelas,	
				"aset_grup_usia"=>$group_aset_usia,
				"aset_grup_keterangan"=>$group_aset_keterangan,
				"aset_grup_aktif"=>$group_aset_aktif,		
				"aset_grup_update"=>$_SESSION[SESSION_USERID],			
				"aset_grup_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('aset_grup_id', $group_aset_id);
			$this->db->update('aset_grup', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE aset_grup set aset_grup_revised=(aset_grup_revised+1) WHERE aset_grup_id='".$group_aset_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function group_aset_create($group_aset_kode ,$group_aset_nama ,$group_aset_kelas ,$group_aset_usia, $group_aset_keterangan, $group_aset_aktif){
			if ($group_aset_aktif=="")
				$group_aset_aktif = "Aktif";
			$data = array(
	
				"aset_grup_kode"=>$group_aset_kode,	
				"aset_grup_nama"=>$group_aset_nama,	
				"aset_grup_kelas"=>$group_aset_kelas,	
				"aset_grup_usia"=>$group_aset_usia,
				"aset_grup_keterangan"=>$group_aset_keterangan,
				"aset_grup_aktif"=>$group_aset_aktif,
				"aset_grup_creator"=>$_SESSION[SESSION_USERID],	
				"aset_grup_date_create"=>date('Y-m-d H:i:s'),	
				"aset_grup_revised"=>'0'	
			);
			$this->db->insert('aset_grup', $data); 
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