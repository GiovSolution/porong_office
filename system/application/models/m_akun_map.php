<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun_map Model
	+ Description	: For record model process back-end
	+ Filename 		: c_akun_map.php
 	+ creator 		: 
 	+ Created on 06/Oct/2010 10:15:56
	
*/

class M_akun_map extends Model{
		
		//constructor
		function M_akun_map() {
			parent::Model();
		}
		
		function get_map_kategori_list($filter,$start,$end){
			$query = "SELECT map_kategori FROM vu_akun_map";
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (map_kategori LIKE '%".addslashes($filter)."%' )";
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
		
		//function for get list record
		function akun_map_list($filter,$start,$end){
			$query = "SELECT * FROM vu_akun_map";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (map_kategori LIKE '%".addslashes($filter)."%' OR 
							 map_nama LIKE '%".addslashes($filter)."%' OR 
							 akun_nama LIKE '%".addslashes($filter)."%' OR 
							 map_akun_kode LIKE '%".addslashes($filter)."%')";
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
		function akun_map_create($map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ){
			$data = array(
				"map_kategori"=>$map_kategori, 
				"map_nama"=>$map_nama, 
				"map_akun"=>$map_akun, 
				"map_akun_kode"=>$map_akun_kode, 
				"map_aktif"=>$map_aktif, 
				"map_author"=>$map_author, 
				"map_date_create"=>$map_date_create 
			);
			$this->db->insert('akun_map', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function akun_map_update($map_id,$map_kategori,$map_nama,$map_akun,$map_akun_kode,$map_aktif,$map_update,$map_date_update){
			$data = array(
				"map_kategori"=>$map_kategori, 
				"map_nama"=>$map_nama, 
				"map_akun"=>$map_akun, 
				"map_akun_kode"=>$map_akun_kode, 
				"map_aktif"=>$map_aktif, 
				"map_update"=>$map_update, 
				"map_date_update"=>$map_date_update 
			);
			
			$this->db->where('map_id', $map_id);
			$this->db->update('akun_map', $data);
			$sql="UPDATE akun_map set map_revised=(map_revised+1) where map_id='".$map_id."'";
			$this->db->query($sql);
			return '1';
		}
		
		//fcuntion for delete record
		function akun_map_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the akun_maps at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM akun_map WHERE map_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM akun_map WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "map_id= ".$pkid[$i];
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
		function akun_map_search($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$start,$end){
			//full query
			$query="select * from akun_map";
			
			if($map_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_id LIKE '%".$map_id."%'";
			};
			if($map_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_kategori LIKE '%".$map_kategori."%'";
			};
			if($map_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_nama LIKE '%".$map_nama."%'";
			};
			if($map_akun!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_akun LIKE '%".$map_akun."%'";
			};
			if($map_akun_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_akun_kode LIKE '%".$map_akun_kode."%'";
			};
			if($map_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_aktif LIKE '%".$map_aktif."%'";
			};
			if($map_author!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_author LIKE '%".$map_author."%'";
			};
			if($map_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_date_create LIKE '%".$map_date_create."%'";
			};
			if($map_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_update LIKE '%".$map_update."%'";
			};
			if($map_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_date_update LIKE '%".$map_date_update."%'";
			};
			if($map_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " map_revised LIKE '%".$map_revised."%'";
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
		function akun_map_print($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$option,$filter){
			//full query
			$sql="select * from akun_map";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (map_id LIKE '%".addslashes($filter)."%' OR map_kategori LIKE '%".addslashes($filter)."%' OR map_nama LIKE '%".addslashes($filter)."%' OR map_akun LIKE '%".addslashes($filter)."%' OR map_akun_kode LIKE '%".addslashes($filter)."%' OR map_aktif LIKE '%".addslashes($filter)."%' OR map_author LIKE '%".addslashes($filter)."%' OR map_date_create LIKE '%".addslashes($filter)."%' OR map_update LIKE '%".addslashes($filter)."%' OR map_date_update LIKE '%".addslashes($filter)."%' OR map_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($map_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_id LIKE '%".$map_id."%'";
				};
				if($map_kategori!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_kategori LIKE '%".$map_kategori."%'";
				};
				if($map_nama!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_nama LIKE '%".$map_nama."%'";
				};
				if($map_akun!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_akun LIKE '%".$map_akun."%'";
				};
				if($map_akun_kode!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_akun_kode LIKE '%".$map_akun_kode."%'";
				};
				if($map_aktif!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_aktif LIKE '%".$map_aktif."%'";
				};
				if($map_author!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_author LIKE '%".$map_author."%'";
				};
				if($map_date_create!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_date_create LIKE '%".$map_date_create."%'";
				};
				if($map_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_update LIKE '%".$map_update."%'";
				};
				if($map_date_update!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_date_update LIKE '%".$map_date_update."%'";
				};
				if($map_revised!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " map_revised LIKE '%".$map_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function akun_map_export_excel($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$option,$filter){
			//full query
			$sql="select * from akun_map";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (map_id LIKE '%".addslashes($filter)."%' OR map_kategori LIKE '%".addslashes($filter)."%' OR map_nama LIKE '%".addslashes($filter)."%' OR map_akun LIKE '%".addslashes($filter)."%' OR map_akun_kode LIKE '%".addslashes($filter)."%' OR map_aktif LIKE '%".addslashes($filter)."%' OR map_author LIKE '%".addslashes($filter)."%' OR map_date_create LIKE '%".addslashes($filter)."%' OR map_update LIKE '%".addslashes($filter)."%' OR map_date_update LIKE '%".addslashes($filter)."%' OR map_revised LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($map_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_id LIKE '%".$map_id."%'";
				};
				if($map_kategori!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_kategori LIKE '%".$map_kategori."%'";
				};
				if($map_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_nama LIKE '%".$map_nama."%'";
				};
				if($map_akun!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_akun LIKE '%".$map_akun."%'";
				};
				if($map_akun_kode!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_akun_kode LIKE '%".$map_akun_kode."%'";
				};
				if($map_aktif!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_aktif LIKE '%".$map_aktif."%'";
				};
				if($map_author!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_author LIKE '%".$map_author."%'";
				};
				if($map_date_create!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_date_create LIKE '%".$map_date_create."%'";
				};
				if($map_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_update LIKE '%".$map_update."%'";
				};
				if($map_date_update!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_date_update LIKE '%".$map_date_update."%'";
				};
				if($map_revised!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " map_revised LIKE '%".$map_revised."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>