<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: kategori Model
	+ Description	: For record model process back-end
	+ Filename 		: c_kategori.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_kategori extends Model{
		
		//constructor
		function M_kategori() {
			parent::Model();
		}
		
		//function for get list record
		function kategori_list($filter,$start,$end){
			$query = "SELECT * FROM kategori";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori_id LIKE '%".addslashes($filter)."%' OR kategori_nama LIKE '%".addslashes($filter)."%' OR kategori_jenis LIKE '%".addslashes($filter)."%' OR kategori_keterangan LIKE '%".addslashes($filter)."%' OR kategori_aktif LIKE '%".addslashes($filter)."%' OR kategori_creator LIKE '%".addslashes($filter)."%' OR kategori_date_create LIKE '%".addslashes($filter)."%' OR kategori_update LIKE '%".addslashes($filter)."%' OR kategori_date_update LIKE '%".addslashes($filter)."%' OR kategori_revised LIKE '%".addslashes($filter)."%' )";
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
		function kategori_update($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ){
			if ($kategori_aktif=="")
				$kategori_aktif = "Aktif";
			$data = array(
				"kategori_id"=>$kategori_id,			
				"kategori_nama"=>$kategori_nama,			
				"kategori_jenis"=>$kategori_jenis,			
				"kategori_keterangan"=>$kategori_keterangan,			
				"kategori_aktif"=>$kategori_aktif,			
				"kategori_update"=>$_SESSION[SESSION_USERID],			
				"kategori_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('kategori_id', $kategori_id);
			$this->db->update('kategori', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE kategori set kategori_revised=(kategori_revised+1) WHERE kategori_id='".$kategori_id."'";
				$this->db->query($sql);
			}
			return '1';
		}
		
		//function for create new record
		function kategori_create($kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ){
			if ($kategori_aktif=="")
				$kategori_aktif = "Aktif";
			$data = array(
	
				"kategori_nama"=>$kategori_nama,	
				"kategori_jenis"=>$kategori_jenis,	
				"kategori_keterangan"=>$kategori_keterangan,	
				"kategori_aktif"=>$kategori_aktif,	
				"kategori_creator"=>$_SESSION[SESSION_USERID],	
				"kategori_date_create"=>date('Y-m-d H:i:s'),	
				"kategori_update"=>$kategori_update,	
				"kategori_date_update"=>$kategori_date_update,	
				"kategori_revised"=>'0'	
			);
			$this->db->insert('kategori', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function kategori_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the kategoris at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM kategori WHERE kategori_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM kategori WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "kategori_id= ".$pkid[$i];
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
		function kategori_search($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$start,$end){
			if ($kategori_aktif=="")
				$kategori_aktif = "Aktif";
			//full query
			$query="select * from kategori";
			
			if($kategori_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_id LIKE '%".$kategori_id."%'";
			};
			if($kategori_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_nama LIKE '%".$kategori_nama."%'";
			};
			if($kategori_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_jenis LIKE '%".$kategori_jenis."%'";
			};
			if($kategori_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_keterangan LIKE '%".$kategori_keterangan."%'";
			};
			if($kategori_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_aktif LIKE '%".$kategori_aktif."%'";
			};
			if($kategori_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_creator LIKE '%".$kategori_creator."%'";
			};
			if($kategori_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_date_create LIKE '%".$kategori_date_create."%'";
			};
			if($kategori_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_update LIKE '%".$kategori_update."%'";
			};
			if($kategori_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_date_update LIKE '%".$kategori_date_update."%'";
			};
			if($kategori_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_revised LIKE '%".$kategori_revised."%'";
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
		function kategori_print($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$option,$filter){
			//full query
			$query="select * from kategori";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori_id LIKE '%".addslashes($filter)."%' OR kategori_nama LIKE '%".addslashes($filter)."%' OR kategori_jenis LIKE '%".addslashes($filter)."%' OR kategori_keterangan LIKE '%".addslashes($filter)."%' OR kategori_aktif LIKE '%".addslashes($filter)."%' OR kategori_creator LIKE '%".addslashes($filter)."%' OR kategori_date_create LIKE '%".addslashes($filter)."%' OR kategori_update LIKE '%".addslashes($filter)."%' OR kategori_date_update LIKE '%".addslashes($filter)."%' OR kategori_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($kategori_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_id LIKE '%".$kategori_id."%'";
				};
				if($kategori_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_nama LIKE '%".$kategori_nama."%'";
				};
				if($kategori_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_jenis LIKE '%".$kategori_jenis."%'";
				};
				if($kategori_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_keterangan LIKE '%".$kategori_keterangan."%'";
				};
				if($kategori_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_aktif LIKE '%".$kategori_aktif."%'";
				};
				if($kategori_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_creator LIKE '%".$kategori_creator."%'";
				};
				if($kategori_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_date_create LIKE '%".$kategori_date_create."%'";
				};
				if($kategori_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_update LIKE '%".$kategori_update."%'";
				};
				if($kategori_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_date_update LIKE '%".$kategori_date_update."%'";
				};
				if($kategori_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_revised LIKE '%".$kategori_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function kategori_export_excel($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$option,$filter){
			//full query
			$query="SELECT
					kategori_nama AS nama,
					kategori_jenis AS jenis,
					kategori_akun AS akun,
					kategori_keterangan AS keterangan,
					kategori_aktif AS aktif
					from kategori
					";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori_id LIKE '%".addslashes($filter)."%' OR kategori_nama LIKE '%".addslashes($filter)."%' OR kategori_jenis LIKE '%".addslashes($filter)."%' OR kategori_keterangan LIKE '%".addslashes($filter)."%' OR kategori_aktif LIKE '%".addslashes($filter)."%' OR kategori_creator LIKE '%".addslashes($filter)."%' OR kategori_date_create LIKE '%".addslashes($filter)."%' OR kategori_update LIKE '%".addslashes($filter)."%' OR kategori_date_update LIKE '%".addslashes($filter)."%' OR kategori_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($kategori_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_id LIKE '%".$kategori_id."%'";
				};
				if($kategori_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_nama LIKE '%".$kategori_nama."%'";
				};
				if($kategori_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_jenis LIKE '%".$kategori_jenis."%'";
				};
				if($kategori_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_keterangan LIKE '%".$kategori_keterangan."%'";
				};
				if($kategori_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_aktif LIKE '%".$kategori_aktif."%'";
				};
				if($kategori_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_creator LIKE '%".$kategori_creator."%'";
				};
				if($kategori_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_date_create LIKE '%".$kategori_date_create."%'";
				};
				if($kategori_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_update LIKE '%".$kategori_update."%'";
				};
				if($kategori_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_date_update LIKE '%".$kategori_date_update."%'";
				};
				if($kategori_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_revised LIKE '%".$kategori_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>