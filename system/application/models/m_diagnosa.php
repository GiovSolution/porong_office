<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: diagnosa Model
	+ Description	: For record model process back-end
	+ Filename 		: c_diagnosa.php
 	+ Author  		: 
 	+ Created on 03/Oct/2009 22:52:15
	
*/

class M_diagnosa extends Model{
		
		//constructor
		function M_diagnosa() {
			parent::Model();
		}
		
		//function for get list record
		function diagnosa_list($filter,$start,$end){
			$query = "SELECT * FROM diagnosa";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (diagnosa_id LIKE '%".addslashes($filter)."%' OR diagnosa_kode LIKE '%".addslashes($filter)."%' OR diagnosa_kategori LIKE '%".addslashes($filter)."%' OR diagnosa_nama LIKE '%".addslashes($filter)."%' OR diagnosa_keterangan LIKE '%".addslashes($filter)."%' )";
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
		function diagnosa_update($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan){
			$data = array(
				"diagnosa_id"=>$diagnosa_id, 
				"diagnosa_kode"=>$diagnosa_kode, 
				"diagnosa_kategori"=>$diagnosa_kategori, 
				"diagnosa_nama"=>$diagnosa_nama, 
				"diagnosa_keterangan"=>$diagnosa_keterangan 
			);
			$this->db->where('diagnosa_id', $diagnosa_id);
			$this->db->update('diagnosa', $data);
			
			return '1';
		}
		
		//function for create new record
		function diagnosa_create($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan){
			$data = array(
				"diagnosa_id"=>$diagnosa_id, 
				"diagnosa_kode"=>$diagnosa_kode, 
				"diagnosa_kategori"=>$diagnosa_kategori, 
				"diagnosa_nama"=>$diagnosa_nama, 
				"diagnosa_keterangan"=>$diagnosa_keterangan 
			);
			$this->db->insert('diagnosa', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function diagnosa_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the diagnosas at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM diagnosa WHERE diagnosa_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM diagnosa WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "diagnosa_id= ".$pkid[$i];
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
		function diagnosa_search($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keteranga,$start,$end){
			//full query
			$query="select * from diagnosa";
			
			if($diagnosa_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " diagnosa_id LIKE '%".$diagnosa_id."%'";
			};
			if($diagnosa_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " diagnosa_kode LIKE '%".$diagnosa_kode."%'";
			};
			if($diagnosa_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " diagnosa_kategori LIKE '%".$diagnosa_kategori."%'";
			};
			if($diagnosa_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " diagnosa_nama LIKE '%".$diagnosa_nama."%'";
			};
			if($diagnosa_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " diagnosa_keterangan LIKE '%".$diagnosa_keterangan."%'";
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
		function diagnosa_print($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan,$option,$filter){
			//full query
			$query="select * from diagnosa";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (diagnosa_id LIKE '%".addslashes($filter)."%' OR diagnosa_kode LIKE '%".addslashes($filter)."%' OR diagnosa_kategori LIKE '%".addslashes($filter)."%' OR diagnosa_nama LIKE '%".addslashes($filter)."%' OR diagnosa_keterangan LIKE '%".addslashes($filter)."%' diagnosa_author LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($diagnosa_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_id LIKE '%".$diagnosa_id."%'";
				};
				if($diagnosa_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_kode LIKE '%".$diagnosa_kode."%'";
				};
				if($diagnosa_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_kategori LIKE '%".$diagnosa_kategori."%'";
				};
				if($diagnosa_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_nama LIKE '%".$diagnosa_nama."%'";
				};
				if($diagnosa_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_keterangan LIKE '%".$diagnosa_keterangan."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function diagnosa_export_excel($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan,$option,$filter){
			//full query
			$query="select * from diagnosa";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (diagnosa_id LIKE '%".addslashes($filter)."%' OR diagnosa_kode LIKE '%".addslashes($filter)."%' OR diagnosa_kategori LIKE '%".addslashes($filter)."%' OR diagnosa_nama LIKE '%".addslashes($filter)."%' OR diagnosa_keterangan LIKE '%".addslashes($filter)."%' diagnosa_author LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($diagnosa_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_id LIKE '%".$diagnosa_id."%'";
				};
				if($diagnosa_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_kode LIKE '%".$diagnosa_kode."%'";
				};
				if($diagnosa_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_kategori LIKE '%".$diagnosa_kategori."%'";
				};
				if($diagnosa_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_nama LIKE '%".$diagnosa_nama."%'";
				};
				if($diagnosa_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " diagnosa_keterangan LIKE '%".$diagnosa_keterangan."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>