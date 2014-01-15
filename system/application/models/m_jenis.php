<? /* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#GIOV SOLUTION
	
	+ Module  		: jenis Model
	+ Description	: For record Model
	+ Filename 		: m_jenis.php
 	+ Author  		: Isaac & Freddy
	
*/

class M_jenis extends Model{
		
		//constructor
		function M_jenis() {
			parent::Model();
		}
		
		//function for get list record
		function jenis_list($filter,$start,$end){
			$query = "SELECT * FROM jenis";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jenis_id LIKE '%".addslashes($filter)."%' OR jenis_nama LIKE '%".addslashes($filter)."%' OR jenis_jenis LIKE '%".addslashes($filter)."%' OR jenis_keterangan LIKE '%".addslashes($filter)."%' OR jenis_aktif LIKE '%".addslashes($filter)."%' OR jenis_creator LIKE '%".addslashes($filter)."%' OR jenis_date_create LIKE '%".addslashes($filter)."%' OR jenis_update LIKE '%".addslashes($filter)."%' OR jenis_date_update LIKE '%".addslashes($filter)."%' OR jenis_revised LIKE '%".addslashes($filter)."%' )";
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
		function jenis_update($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ){
			if ($jenis_aktif=="")
				$jenis_aktif = "Aktif";
			$data = array(
				"jenis_id"=>$jenis_id,			
				"jenis_nama"=>$jenis_nama,			
				"jenis_jenis"=>$jenis_jenis,			
				"jenis_keterangan"=>$jenis_keterangan,			
				"jenis_aktif"=>$jenis_aktif,			
				"jenis_update"=>$_SESSION[SESSION_USERID],			
				"jenis_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('jenis_id', $jenis_id);
			$this->db->update('jenis', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE jenis set jenis_revised=(jenis_revised+1) WHERE jenis_id='".$jenis_id."'";
				$this->db->query($sql);
			}
			return '1';
		}
		
		//function for create new record
		function jenis_create($jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ){
			if ($jenis_aktif=="")
				$jenis_aktif = "Aktif";
			$data = array(
	
				"jenis_nama"=>$jenis_nama,	
				"jenis_jenis"=>$jenis_jenis,	
				"jenis_keterangan"=>$jenis_keterangan,	
				"jenis_aktif"=>$jenis_aktif,	
				"jenis_creator"=>$_SESSION[SESSION_USERID],	
				"jenis_date_create"=>date('Y-m-d H:i:s'),	
				"jenis_update"=>$jenis_update,	
				"jenis_date_update"=>$jenis_date_update,	
				"jenis_revised"=>'0'	
			);
			$this->db->insert('jenis', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function jenis_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the kategoris at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM jenis WHERE jenis_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM jenis WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "jenis_id= ".$pkid[$i];
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
		function jenis_search($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$start,$end){
			if ($jenis_aktif=="")
				$jenis_aktif = "Aktif";
			//full query
			$query="select * from jenis";
			
			if($jenis_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_id LIKE '%".$jenis_id."%'";
			};
			if($jenis_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_nama LIKE '%".$jenis_nama."%'";
			};
			if($jenis_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_jenis LIKE '%".$jenis_jenis."%'";
			};
			if($jenis_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_keterangan LIKE '%".$jenis_keterangan."%'";
			};
			if($jenis_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_aktif LIKE '%".$jenis_aktif."%'";
			};
			if($jenis_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_creator LIKE '%".$jenis_creator."%'";
			};
			if($jenis_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_date_create LIKE '%".$jenis_date_create."%'";
			};
			if($jenis_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_update LIKE '%".$jenis_update."%'";
			};
			if($jenis_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_date_update LIKE '%".$jenis_date_update."%'";
			};
			if($jenis_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis_revised LIKE '%".$jenis_revised."%'";
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
		function jenis_print($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$option,$filter){
			//full query
			$query="select * from jenis";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jenis_id LIKE '%".addslashes($filter)."%' OR jenis_nama LIKE '%".addslashes($filter)."%' OR jenis_jenis LIKE '%".addslashes($filter)."%' OR jenis_keterangan LIKE '%".addslashes($filter)."%' OR jenis_aktif LIKE '%".addslashes($filter)."%' OR jenis_creator LIKE '%".addslashes($filter)."%' OR jenis_date_create LIKE '%".addslashes($filter)."%' OR jenis_update LIKE '%".addslashes($filter)."%' OR jenis_date_update LIKE '%".addslashes($filter)."%' OR jenis_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($jenis_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_id LIKE '%".$jenis_id."%'";
				};
				if($jenis_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_nama LIKE '%".$jenis_nama."%'";
				};
				if($jenis_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_jenis LIKE '%".$jenis_jenis."%'";
				};
				if($jenis_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_keterangan LIKE '%".$jenis_keterangan."%'";
				};
				if($jenis_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_aktif LIKE '%".$jenis_aktif."%'";
				};
				if($jenis_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_creator LIKE '%".$jenis_creator."%'";
				};
				if($jenis_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_date_create LIKE '%".$jenis_date_create."%'";
				};
				if($jenis_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_update LIKE '%".$jenis_update."%'";
				};
				if($jenis_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_date_update LIKE '%".$jenis_date_update."%'";
				};
				if($jenis_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_revised LIKE '%".$jenis_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function jenis_export_excel($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$option,$filter){
			//full query
			$query="SELECT
					jenis_nama AS nama,
					jenis_jenis AS jenis,
					jenis_akun AS akun,
					jenis_keterangan AS keterangan,
					jenis_aktif AS aktif
					from jenis
					";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jenis_id LIKE '%".addslashes($filter)."%' OR jenis_nama LIKE '%".addslashes($filter)."%' OR jenis_jenis LIKE '%".addslashes($filter)."%' OR jenis_keterangan LIKE '%".addslashes($filter)."%' OR jenis_aktif LIKE '%".addslashes($filter)."%' OR jenis_creator LIKE '%".addslashes($filter)."%' OR jenis_date_create LIKE '%".addslashes($filter)."%' OR jenis_update LIKE '%".addslashes($filter)."%' OR jenis_date_update LIKE '%".addslashes($filter)."%' OR jenis_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($jenis_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_id LIKE '%".$jenis_id."%'";
				};
				if($jenis_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_nama LIKE '%".$jenis_nama."%'";
				};
				if($jenis_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_jenis LIKE '%".$jenis_jenis."%'";
				};
				if($jenis_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_keterangan LIKE '%".$jenis_keterangan."%'";
				};
				if($jenis_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_aktif LIKE '%".$jenis_aktif."%'";
				};
				if($jenis_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_creator LIKE '%".$jenis_creator."%'";
				};
				if($jenis_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_date_create LIKE '%".$jenis_date_create."%'";
				};
				if($jenis_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_update LIKE '%".$jenis_update."%'";
				};
				if($jenis_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_date_update LIKE '%".$jenis_date_update."%'";
				};
				if($jenis_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis_revised LIKE '%".$jenis_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>