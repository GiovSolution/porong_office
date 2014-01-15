<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: poin_faktur Model
	+ Description	: For record model process back-end
	+ Filename 		: c_poin_faktur.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
*/

class M_poin_faktur extends Model{
		
		//constructor
		function M_poin_faktur() {
			parent::Model();
		}
		
		//function for get list record
		function poin_faktur_list($filter,$start,$end){
			$query = "SELECT * FROM vu_history_poin_faktur ";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR 
							 cust_nama LIKE '%".addslashes($filter)."%' OR 
							 cust_no LIKE '%".addslashes($filter)."%' OR 
							 cust_member LIKE '%".addslashes($filter)."%' OR
							 jenis LIKE '%".addslashes($filter)."%')";
			}
			$query.=" ORDER BY tanggal desc, no_bukti ASC";
			
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
		
				
		//function for advanced search record
		function poin_faktur_search($poin_faktur_no ,$poin_faktur_jenis ,$poin_faktur_cust, $poin_faktur_tanggal ,$poin_tanggal_start, $poin_tanggal_end, $start,$end){
			//full query
			$query="select * from vu_history_poin_faktur";
			
			if($poin_faktur_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " no_bukti LIKE '%".$poin_faktur_no."%'";
			};
			
			if($poin_faktur_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id = '".$poin_faktur_cust."'";
			};
			
			if($poin_faktur_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jenis LIKE '%".$poin_faktur_jenis."%'";
			};

			if($poin_tanggal_start!='' && $poin_tanggal_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal, '%Y-%m-%d') BETWEEN '".$poin_tanggal_start."' AND '".$poin_tanggal_end."'";
			}
			
			/*if($poin_faktur_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " tanggal LIKE '%".$poin_faktur_tanggal."%'";
			};*/
			
			$query.=" ORDER BY tanggal DESC, no_bukti ASC";
			
			//$this->firephp->log($query);
			
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
		function poin_faktur_print($poin_faktur_no ,$poin_faktur_jenis , $poin_faktur_cust ,$poin_faktur_tanggal,$option,$filter){
			//full query
			$query="select * from vu_history_poin_faktur";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR 
							 cust_nama LIKE '%".addslashes($filter)."%' OR 
							 cust_no LIKE '%".addslashes($filter)."%' OR 
							 cust_member LIKE '%".addslashes($filter)."%' OR
							 jenis LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($poin_faktur_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$poin_faktur_no."%'";
				};
				
				if($poin_faktur_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id ='".$poin_faktur_cust."'";
				};
				
				if($poin_faktur_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis LIKE '%".$poin_faktur_jenis."%'";
				};
	
				
				if($poin_faktur_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " tanggal LIKE '%".$poin_faktur_tanggal."%'";
				};
			}
			
			$query.=" ORDER BY tanggal, no_bukti ASC";
		
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function poin_faktur_export_excel($poin_faktur_no ,$poin_faktur_jenis , $poin_faktur_cust ,$poin_faktur_tanggal,$option,$filter){
			//full query
			$query="SELECT ifnull(no_bukti,'-') as 'No Faktur', date_format(tanggal,'%Y-%m-%d') as 'Tanggal', point as 'Point',
					ifnull(cust_no,'-') as 'No Customer', ifnull(cust_nama,'-') as 'Nama Customer', 
					jenis as 'Jenis Transaksi' FROM vu_history_poin_faktur";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR 
							 cust_nama LIKE '%".addslashes($filter)."%' OR 
							 cust_no LIKE '%".addslashes($filter)."%' OR 
							 cust_member LIKE '%".addslashes($filter)."%' OR
							 jenis LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($poin_faktur_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$poin_faktur_no."%'";
				};
				
				if($poin_faktur_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id ='".$poin_faktur_cust."'";
				};
				
				if($poin_faktur_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jenis LIKE '%".$poin_faktur_jenis."%'";
				};
	
				
				if($poin_faktur_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " tanggal LIKE '%".$poin_faktur_tanggal."%'";
				};
			}
			
			$query.=" ORDER BY tanggal, no_bukti ASC";
			
			$this->firephp->log($query);
				
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>