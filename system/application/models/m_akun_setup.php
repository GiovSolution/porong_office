<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun_setup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_akun_setup.php
 	+ creator 		: 
 	+ Created on 18/Oct/2010 13:31:54
	
*/

class M_akun_setup extends Model{
		
		//constructor
		function M_akun_setup() {
			parent::Model();
		}
		
		function get_akun_setup(){
			$sql="select * from akun_setup";
			$result=$this->db->query($sql);
			$nbrows = $result->num_rows();
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"1","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
				
		//function for get list record
		function akun_setup_list($filter,$start,$end){
			$query = "SELECT * FROM akun_setup";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (setup_id LIKE '%".addslashes($filter)."%' OR setup_periode_tahun LIKE '%".addslashes($filter)."%' OR setup_periode_awal LIKE '%".addslashes($filter)."%' OR setup_periode_akhir LIKE '%".addslashes($filter)."%' OR setup_author LIKE '%".addslashes($filter)."%' OR setup_date_create LIKE '%".addslashes($filter)."%' OR setup_update LIKE '%".addslashes($filter)."%' OR setup_date_update LIKE '%".addslashes($filter)."%' OR setup_revised LIKE '%".addslashes($filter)."%' )";
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
		
		//function for create new record
		function akun_setup_create($setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,$setup_date_create ){
			$data = array(
				"setup_periode_tahun"=>$setup_periode_tahun, 
				"setup_periode_awal"=>$setup_periode_awal, 
				"setup_periode_akhir"=>$setup_periode_akhir, 
				"setup_author"=>$setup_author, 
				"setup_date_create"=>$setup_date_create 
			);
			$this->db->insert('akun_setup', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function akun_setup_update($setup_id,$setup_periode_tahun,$setup_periode_awal,$setup_periode_akhir,$setup_update,$setup_date_update){
			$data = array(
				"setup_periode_tahun"=>$setup_periode_tahun, 
				"setup_periode_awal"=>$setup_periode_awal, 
				"setup_periode_akhir"=>$setup_periode_akhir, 
				"setup_update"=>$setup_update, 
				"setup_date_update"=>$setup_date_update 
			);
			
			$this->db->update('akun_setup', $data);
			$sql="UPDATE akun_setup set setup_revised=(setup_revised+1)";
			$this->db->query($sql);
			return '1';
		}
		
		//fcuntion for delete record
		function akun_setup_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the akun_setups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM akun_setup WHERE setup_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM akun_setup WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "setup_id= ".$pkid[$i];
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
		function akun_setup_search($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,$setup_date_create ,$setup_update ,$setup_date_update ,$setup_revised ,$start,$end){
			//full query
			$query="select * from akun_setup";
			
			if($setup_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_id LIKE '%".$setup_id."%'";
			};
			if($setup_periode_tahun!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_periode_tahun LIKE '%".$setup_periode_tahun."%'";
			};
			if($setup_periode_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_periode_awal LIKE '%".$setup_periode_awal."%'";
			};
			if($setup_periode_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_periode_akhir LIKE '%".$setup_periode_akhir."%'";
			};
			if($setup_author!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_author LIKE '%".$setup_author."%'";
			};
			if($setup_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_date_create LIKE '%".$setup_date_create."%'";
			};
			if($setup_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_update LIKE '%".$setup_update."%'";
			};
			if($setup_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_date_update LIKE '%".$setup_date_update."%'";
			};
			if($setup_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " setup_revised LIKE '%".$setup_revised."%'";
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
		function akun_setup_print($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,$setup_date_create ,$setup_update ,$setup_date_update ,$setup_revised ,$option,$filter){
			//full query
			$sql="select * from akun_setup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (setup_id LIKE '%".addslashes($filter)."%' OR setup_periode_tahun LIKE '%".addslashes($filter)."%' OR setup_periode_awal LIKE '%".addslashes($filter)."%' OR setup_periode_akhir LIKE '%".addslashes($filter)."%' OR setup_author LIKE '%".addslashes($filter)."%' OR setup_date_create LIKE '%".addslashes($filter)."%' OR setup_update LIKE '%".addslashes($filter)."%' OR setup_date_update LIKE '%".addslashes($filter)."%' OR setup_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($setup_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_id LIKE '%".$setup_id."%'";
				};
				if($setup_periode_tahun!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_periode_tahun LIKE '%".$setup_periode_tahun."%'";
				};
				if($setup_periode_awal!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_periode_awal LIKE '%".$setup_periode_awal."%'";
				};
				if($setup_periode_akhir!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_periode_akhir LIKE '%".$setup_periode_akhir."%'";
				};
				if($setup_author!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_author LIKE '%".$setup_author."%'";
				};
				if($setup_date_create!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_date_create LIKE '%".$setup_date_create."%'";
				};
				if($setup_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_update LIKE '%".$setup_update."%'";
				};
				if($setup_date_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_date_update LIKE '%".$setup_date_update."%'";
				};
				if($setup_revised!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " setup_revised LIKE '%".$setup_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function akun_setup_export_excel($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,$setup_date_create ,$setup_update ,$setup_date_update ,$setup_revised ,$option,$filter){
			//full query
			$sql="select * from akun_setup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (setup_id LIKE '%".addslashes($filter)."%' OR setup_periode_tahun LIKE '%".addslashes($filter)."%' OR setup_periode_awal LIKE '%".addslashes($filter)."%' OR setup_periode_akhir LIKE '%".addslashes($filter)."%' OR setup_author LIKE '%".addslashes($filter)."%' OR setup_date_create LIKE '%".addslashes($filter)."%' OR setup_update LIKE '%".addslashes($filter)."%' OR setup_date_update LIKE '%".addslashes($filter)."%' OR setup_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($setup_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_id LIKE '%".$setup_id."%'";
				};
				if($setup_periode_tahun!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_periode_tahun LIKE '%".$setup_periode_tahun."%'";
				};
				if($setup_periode_awal!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_periode_awal LIKE '%".$setup_periode_awal."%'";
				};
				if($setup_periode_akhir!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_periode_akhir LIKE '%".$setup_periode_akhir."%'";
				};
				if($setup_author!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_author LIKE '%".$setup_author."%'";
				};
				if($setup_date_create!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_date_create LIKE '%".$setup_date_create."%'";
				};
				if($setup_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_update LIKE '%".$setup_update."%'";
				};
				if($setup_date_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_date_update LIKE '%".$setup_date_update."%'";
				};
				if($setup_revised!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " setup_revised LIKE '%".$setup_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>