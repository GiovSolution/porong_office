<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: kategori2 Model
	+ Description	: For record model process back-end
	+ Filename 		: c_kategori2.php
 	+ Author  		: 
 	+ Created on 22/Oct/2009 16:24:37
	
*/

class M_kategori2 extends Model{
		
		//constructor
		function M_kategori2() {
			parent::Model();
		}
		
		//function for get list record
		function kategori2_list($filter,$start,$end){
			$query = "SELECT * FROM kategori2,kategori WHERE kategori2_jenis=kategori_id";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori2_nama LIKE '%".addslashes($filter)."%' OR kategori2_jenis LIKE '%".addslashes($filter)."%' OR kategori2_keterangan LIKE '%".addslashes($filter)."%' )";
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
		function kategori2_update($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ){
		if ($kategori2_aktif=="")
			$kategori2_aktif = "Aktif";
			$data = array(
				"kategori2_id"=>$kategori2_id, 
				"kategori2_nama"=>$kategori2_nama, 
				"kategori2_keterangan"=>$kategori2_keterangan, 
				"kategori2_aktif"=>$kategori2_aktif,
				"kategori2_update"=>$_SESSION[SESSION_USERID],	
				"kategori2_date_update"=>date('Y-m-d H:i:s')			
			);
			$sql="SELECT kategori_id FROM kategori WHERE kategori_id='$kategori2_jenis'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["kategori2_jenis"]=$kategori2_jenis;
			$this->db->where('kategori2_id', $kategori2_id);
			$this->db->update('kategori2', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE kategori2 set kategori2_revised=(kategori2_revised+1) WHERE kategori2_id='".$kategori2_id."'";
				$this->db->query($sql);
			}
			return '1';
			
		}
		
		//function for create new record
		function kategori2_create($kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ){
		if ($kategori2_aktif=="")
			$kategori2_aktif = "Aktif";
			$data = array(
				"kategori2_nama"=>$kategori2_nama, 
				"kategori2_jenis"=>$kategori2_jenis, 
				"kategori2_keterangan"=>$kategori2_keterangan, 
				"kategori2_aktif"=>$kategori2_aktif, 
				"kategori2_creator"=>$_SESSION[SESSION_USERID],	
				"kategori2_date_create"=>date('Y-m-d H:i:s'),
				"kategori2_revised"=>'0'	
			);
			$this->db->insert('kategori2', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function kategori2_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the kategori2s at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM kategori2 WHERE kategori2_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM kategori2 WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "kategori2_id= ".$pkid[$i];
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
		function kategori2_search($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$start,$end){
			//full query
			if($kategori2_aktif=="")
				$kategori2_aktif="Aktif";
			$query="SELECT * FROM kategori2,kategori WHERE kategori2_jenis=kategori_id";
			
			if($kategori2_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_id LIKE '%".$kategori2_id."%'";
			};
			if($kategori2_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_nama LIKE '%".$kategori2_nama."%'";
			};
			if($kategori2_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_jenis LIKE '%".$kategori2_jenis."%'";
			};
			if($kategori2_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_keterangan LIKE '%".$kategori2_keterangan."%'";
			};
			if($kategori2_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_aktif LIKE '%".$kategori2_aktif."%'";
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
		function kategori2_print($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$option,$filter){
			//full query
			$query="select * from kategori2";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori2_id LIKE '%".addslashes($filter)."%' OR kategori2_nama LIKE '%".addslashes($filter)."%' OR kategori2_jenis LIKE '%".addslashes($filter)."%' OR kategori2_keterangan LIKE '%".addslashes($filter)."%' OR kategori2_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($kategori2_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_id LIKE '%".$kategori2_id."%'";
				};
				if($kategori2_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_nama LIKE '%".$kategori2_nama."%'";
				};
				if($kategori2_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_jenis LIKE '%".$kategori2_jenis."%'";
				};
				if($kategori2_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_keterangan LIKE '%".$kategori2_keterangan."%'";
				};
				if($kategori2_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_aktif LIKE '%".$kategori2_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function kategori2_export_excel($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$option,$filter){
			//full query
			$query="SELECT
						`kategori2`.`kategori2_nama` AS `nama`,
						`kategori`.`kategori_nama` AS `jenis`,
						`kategori2`.`kategori2_keterangan` AS `keterangan`,
						`kategori2`.`kategori2_aktif` AS `aktif`			
					FROM `kategori2`
					Inner Join `kategori` ON `kategori2`.`kategori2_jenis` = `kategori`.`kategori_id`
					WHERE kategori2_jenis=kategori_id";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kategori2_id LIKE '%".addslashes($filter)."%' OR kategori2_nama LIKE '%".addslashes($filter)."%' OR kategori2_jenis LIKE '%".addslashes($filter)."%' OR kategori2_keterangan LIKE '%".addslashes($filter)."%' OR kategori2_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($kategori2_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_id LIKE '%".$kategori2_id."%'";
				};
				if($kategori2_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_nama LIKE '%".$kategori2_nama."%'";
				};
				if($kategori2_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_jenis LIKE '%".$kategori2_jenis."%'";
				};
				if($kategori2_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_keterangan LIKE '%".$kategori2_keterangan."%'";
				};
				if($kategori2_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori2_aktif LIKE '%".$kategori2_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>