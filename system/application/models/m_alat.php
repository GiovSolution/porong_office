<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: alat Model
	+ Description	: For record model process back-end
	+ Filename 		: c_alat.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_alat extends Model{
		
		//constructor
		function M_alat() {
			parent::Model();
		}
		
		//function for get list record
		function alat_list($filter,$start,$end){
			$query = "SELECT * FROM alat";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (alat_nama LIKE '%".addslashes($filter)."%' )";
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
		function alat_update($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ){
			if ($alat_aktif=="")
				$alat_aktif = "Aktif";
			$data = array(
				"alat_id"=>$alat_id,			
				"alat_nama"=>$alat_nama,			
				"alat_jumlah"=>$alat_jumlah,			
				"alat_aktif"=>$alat_aktif,			
				"alat_update"=>$_SESSION[SESSION_USERID],			
				"alat_date_update"=>date('Y-m-d H:i:s')
			);
			$this->db->where('alat_id', $alat_id);
			$this->db->update('alat', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE alat set alat_revised=(alat_revised+1) WHERE alat_id='".$alat_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function alat_create($alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ){
			if ($alat_aktif=="")
				$alat_aktif = "Aktif";
			$data = array(
	
				"alat_nama"=>$alat_nama,	
				"alat_jumlah"=>$alat_jumlah,	
				"alat_aktif"=>$alat_aktif,	
				"alat_creator"=>$_SESSION[SESSION_USERID],	
				"alat_date_create"=>date('Y-m-d H:i:s'),	
				"alat_update"=>$alat_update,	
				"alat_date_update"=>$alat_date_update,
				"alat_revised"=>'0'	
			);
			$this->db->insert('alat', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function alat_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the alats at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM alat WHERE alat_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM alat WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "alat_id= ".$pkid[$i];
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
		function alat_search($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$start,$end){
			if ($alat_aktif=="")
				$alat_aktif = "Aktif";
			//full query
			$query="select * from alat";
			
			if($alat_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_id LIKE '%".$alat_id."%'";
			};
			if($alat_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_nama LIKE '%".$alat_nama."%'";
			};
			if($alat_jumlah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_jumlah LIKE '%".$alat_jumlah."%'";
			};
			if($alat_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_aktif LIKE '%".$alat_aktif."%'";
			};
			if($alat_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_creator LIKE '%".$alat_creator."%'";
			};
			if($alat_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_date_create LIKE '%".$alat_date_create."%'";
			};
			if($alat_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_update LIKE '%".$alat_update."%'";
			};
			if($alat_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_date_update LIKE '%".$alat_date_update."%'";
			};
			if($alat_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " alat_revised LIKE '%".$alat_revised."%'";
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
		function alat_print($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$option,$filter){
			//full query
			$query="select * from alat";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (alat_id LIKE '%".addslashes($filter)."%' OR alat_nama LIKE '%".addslashes($filter)."%' OR alat_jumlah LIKE '%".addslashes($filter)."%' OR alat_aktif LIKE '%".addslashes($filter)."%' OR alat_creator LIKE '%".addslashes($filter)."%' OR alat_date_create LIKE '%".addslashes($filter)."%' OR alat_update LIKE '%".addslashes($filter)."%' OR alat_date_update LIKE '%".addslashes($filter)."%' OR alat_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($alat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_id LIKE '%".$alat_id."%'";
				};
				if($alat_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_nama LIKE '%".$alat_nama."%'";
				};
				if($alat_jumlah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_jumlah LIKE '%".$alat_jumlah."%'";
				};
				if($alat_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_aktif LIKE '%".$alat_aktif."%'";
				};
				if($alat_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_creator LIKE '%".$alat_creator."%'";
				};
				if($alat_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_date_create LIKE '%".$alat_date_create."%'";
				};
				if($alat_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_update LIKE '%".$alat_update."%'";
				};
				if($alat_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_date_update LIKE '%".$alat_date_update."%'";
				};
				if($alat_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_revised LIKE '%".$alat_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function alat_export_excel($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$option,$filter){
			//full query
			$query="select 	alat_nama AS nama,
							alat_jumlah AS jumlah,
							alat_aktif AS aktif

					from 	alat";

			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (alat_id LIKE '%".addslashes($filter)."%' OR alat_nama LIKE '%".addslashes($filter)."%' OR alat_jumlah LIKE '%".addslashes($filter)."%' OR alat_aktif LIKE '%".addslashes($filter)."%' OR alat_creator LIKE '%".addslashes($filter)."%' OR alat_date_create LIKE '%".addslashes($filter)."%' OR alat_update LIKE '%".addslashes($filter)."%' OR alat_date_update LIKE '%".addslashes($filter)."%' OR alat_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($alat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_id LIKE '%".$alat_id."%'";
				};
				if($alat_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_nama LIKE '%".$alat_nama."%'";
				};
				if($alat_jumlah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_jumlah LIKE '%".$alat_jumlah."%'";
				};
				if($alat_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_aktif LIKE '%".$alat_aktif."%'";
				};
				if($alat_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_creator LIKE '%".$alat_creator."%'";
				};
				if($alat_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_date_create LIKE '%".$alat_date_create."%'";
				};
				if($alat_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_update LIKE '%".$alat_update."%'";
				};
				if($alat_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_date_update LIKE '%".$alat_date_update."%'";
				};
				if($alat_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " alat_revised LIKE '%".$alat_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>