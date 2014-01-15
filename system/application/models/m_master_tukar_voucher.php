<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: master_tukar_voucher Model
	+ Description	: For record model process back-end
	+ Filename 		: c_master_tukar_voucher.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_master_tukar_voucher extends Model{
		
		//constructor
		function M_master_tukar_voucher() {
			parent::Model();
		}
		
		//function for get list record
		function master_tukar_voucher_list($filter,$start,$end){
			$query = "SELECT * FROM master_tukar_voucher";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (avoucher_id LIKE '%".addslashes($filter)."%' OR avoucher_cust LIKE '%".addslashes($filter)."%' OR avoucher_tanggal LIKE '%".addslashes($filter)."%' OR avoucher_kasir LIKE '%".addslashes($filter)."%' OR avoucher_novoucher LIKE '%".addslashes($filter)."%' )";
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
		function master_tukar_voucher_update($avoucher_id ,$avoucher_cust ,$avoucher_tanggal ,$avoucher_kasir ,$avoucher_novoucher ){
			$data = array(
				"avoucher_id"=>$avoucher_id,			
				"avoucher_cust"=>$avoucher_cust,			
				"avoucher_tanggal"=>$avoucher_tanggal,			
				"avoucher_kasir"=>$avoucher_kasir,			
				"avoucher_novoucher"=>$avoucher_novoucher			
			);
			$this->db->where('avoucher_id', $avoucher_id);
			$this->db->update('master_tukar_voucher', $data);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for create new record
		function master_tukar_voucher_create($avoucher_cust ,$avoucher_tanggal ,$avoucher_kasir ,$avoucher_novoucher ){
			$data = array(
	
				"avoucher_cust"=>$avoucher_cust,	
				"avoucher_tanggal"=>$avoucher_tanggal,	
				"avoucher_kasir"=>$avoucher_kasir,	
				"avoucher_novoucher"=>$avoucher_novoucher	
			);
			$this->db->insert('master_tukar_voucher', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_tukar_voucher_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the master_tukar_vouchers at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_tukar_voucher WHERE avoucher_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_tukar_voucher WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "avoucher_id= ".$pkid[$i];
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
		function master_tukar_voucher_search($avoucher_id ,$avoucher_cust ,$avoucher_tanggal ,$avoucher_kasir ,$avoucher_novoucher ,$start,$end){
			//full query
			$query="select * from master_tukar_voucher";
			
			if($avoucher_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " avoucher_id LIKE '%".$avoucher_id."%'";
			};
			if($avoucher_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " avoucher_cust LIKE '%".$avoucher_cust."%'";
			};
			if($avoucher_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " avoucher_tanggal LIKE '%".$avoucher_tanggal."%'";
			};
			if($avoucher_kasir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " avoucher_kasir LIKE '%".$avoucher_kasir."%'";
			};
			if($avoucher_novoucher!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " avoucher_novoucher LIKE '%".$avoucher_novoucher."%'";
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
		function master_tukar_voucher_print($avoucher_id ,$avoucher_cust ,$avoucher_tanggal ,$avoucher_kasir ,$avoucher_novoucher ,$option,$filter){
			//full query
			$query="select * from master_tukar_voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (avoucher_id LIKE '%".addslashes($filter)."%' OR avoucher_cust LIKE '%".addslashes($filter)."%' OR avoucher_tanggal LIKE '%".addslashes($filter)."%' OR avoucher_kasir LIKE '%".addslashes($filter)."%' OR avoucher_novoucher LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($avoucher_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_id LIKE '%".$avoucher_id."%'";
				};
				if($avoucher_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_cust LIKE '%".$avoucher_cust."%'";
				};
				if($avoucher_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_tanggal LIKE '%".$avoucher_tanggal."%'";
				};
				if($avoucher_kasir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_kasir LIKE '%".$avoucher_kasir."%'";
				};
				if($avoucher_novoucher!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_novoucher LIKE '%".$avoucher_novoucher."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function master_tukar_voucher_export_excel($avoucher_id ,$avoucher_cust ,$avoucher_tanggal ,$avoucher_kasir ,$avoucher_novoucher ,$option,$filter){
			//full query
			$query="select * from master_tukar_voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (avoucher_id LIKE '%".addslashes($filter)."%' OR avoucher_cust LIKE '%".addslashes($filter)."%' OR avoucher_tanggal LIKE '%".addslashes($filter)."%' OR avoucher_kasir LIKE '%".addslashes($filter)."%' OR avoucher_novoucher LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($avoucher_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_id LIKE '%".$avoucher_id."%'";
				};
				if($avoucher_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_cust LIKE '%".$avoucher_cust."%'";
				};
				if($avoucher_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_tanggal LIKE '%".$avoucher_tanggal."%'";
				};
				if($avoucher_kasir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_kasir LIKE '%".$avoucher_kasir."%'";
				};
				if($avoucher_novoucher!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " avoucher_novoucher LIKE '%".$avoucher_novoucher."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>