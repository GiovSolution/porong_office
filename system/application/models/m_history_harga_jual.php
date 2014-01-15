<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: history_harga_jual Model
	+ Description	: For record model process back-end
	+ Filename 		: c_history_harga_jual.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_history_harga_jual extends Model{
		
		//constructor
		function M_history_harga_jual() {
			parent::Model();
		}
		
		//function for get list record
		function history_harga_jual_list($filter,$start,$end){
			$query = "SELECT * FROM history_harga_jual";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (hjual_no LIKE '%".addslashes($filter)."%' OR hjual_tanggal LIKE '%".addslashes($filter)."%' OR hjual_harga LIKE '%".addslashes($filter)."%' OR hjual_jenis LIKE '%".addslashes($filter)."%' OR hjual_update LIKE '%".addslashes($filter)."%' OR hjual_date_update LIKE '%".addslashes($filter)."%' OR hjual_revised LIKE '%".addslashes($filter)."%' )";
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
		function history_harga_jual_update($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ){
			$data = array(
				"hjual_no"=>$hjual_no,			
				"hjual_tanggal"=>$hjual_tanggal,			
				"hjual_harga"=>$hjual_harga,			
				"hjual_jenis"=>$hjual_jenis,			
				"hjual_update"=>$hjual_update,			
				"hjual_date_update"=>$hjual_date_update,			
				"hjual_revised"=>$hjual_revised			
			);
			$this->db->where('hjual_no,hjual_tanggal', $hjual_no,hjual_tanggal);
			$this->db->update('history_harga_jual', $data);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for create new record
		function history_harga_jual_create($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ){
			$data = array(
				"hjual_no"=>$hjual_no,	
				"hjual_tanggal"=>$hjual_tanggal,	
				"hjual_harga"=>$hjual_harga,	
				"hjual_jenis"=>$hjual_jenis,	
				"hjual_update"=>$hjual_update,	
				"hjual_date_update"=>$hjual_date_update,	
				"hjual_revised"=>$hjual_revised	
			);
			$this->db->insert('history_harga_jual', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function history_harga_jual_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the history_harga_juals at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM history_harga_jual WHERE hjual_no,hjual_tanggal = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM history_harga_jual WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "hjual_no,hjual_tanggal= ".$pkid[$i];
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
		function history_harga_jual_search($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$start,$end){
			//full query
			$query="select * from history_harga_jual";
			
			if($hjual_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_no LIKE '%".$hjual_no."%'";
			};
			if($hjual_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_tanggal LIKE '%".$hjual_tanggal."%'";
			};
			if($hjual_harga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_harga LIKE '%".$hjual_harga."%'";
			};
			if($hjual_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_jenis LIKE '%".$hjual_jenis."%'";
			};
			if($hjual_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_update LIKE '%".$hjual_update."%'";
			};
			if($hjual_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_date_update LIKE '%".$hjual_date_update."%'";
			};
			if($hjual_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " hjual_revised LIKE '%".$hjual_revised."%'";
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
		function history_harga_jual_print($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$option,$filter){
			//full query
			$query="select * from history_harga_jual";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (hjual_no LIKE '%".addslashes($filter)."%' OR hjual_tanggal LIKE '%".addslashes($filter)."%' OR hjual_harga LIKE '%".addslashes($filter)."%' OR hjual_jenis LIKE '%".addslashes($filter)."%' OR hjual_update LIKE '%".addslashes($filter)."%' OR hjual_date_update LIKE '%".addslashes($filter)."%' OR hjual_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($hjual_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_no LIKE '%".$hjual_no."%'";
				};
				if($hjual_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_tanggal LIKE '%".$hjual_tanggal."%'";
				};
				if($hjual_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_harga LIKE '%".$hjual_harga."%'";
				};
				if($hjual_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_jenis LIKE '%".$hjual_jenis."%'";
				};
				if($hjual_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_update LIKE '%".$hjual_update."%'";
				};
				if($hjual_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_date_update LIKE '%".$hjual_date_update."%'";
				};
				if($hjual_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_revised LIKE '%".$hjual_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function history_harga_jual_export_excel($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$option,$filter){
			//full query
			$query="select * from history_harga_jual";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (hjual_no LIKE '%".addslashes($filter)."%' OR hjual_tanggal LIKE '%".addslashes($filter)."%' OR hjual_harga LIKE '%".addslashes($filter)."%' OR hjual_jenis LIKE '%".addslashes($filter)."%' OR hjual_update LIKE '%".addslashes($filter)."%' OR hjual_date_update LIKE '%".addslashes($filter)."%' OR hjual_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($hjual_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_no LIKE '%".$hjual_no."%'";
				};
				if($hjual_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_tanggal LIKE '%".$hjual_tanggal."%'";
				};
				if($hjual_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_harga LIKE '%".$hjual_harga."%'";
				};
				if($hjual_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_jenis LIKE '%".$hjual_jenis."%'";
				};
				if($hjual_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_update LIKE '%".$hjual_update."%'";
				};
				if($hjual_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_date_update LIKE '%".$hjual_date_update."%'";
				};
				if($hjual_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " hjual_revised LIKE '%".$hjual_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>