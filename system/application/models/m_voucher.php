<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: voucher Model
	+ Description	: For record model process back-end
	+ Filename 		: c_voucher.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
*/

class M_voucher extends Model{
		
		//constructor
		function M_voucher() {
			parent::Model();
		}
		
		function get_member_no($query,$start,$end){
		$sql="SELECT * FROM vu_customer WHERE cust_aktif='Aktif'";
		if($query<>""){
			$sql=$sql." and (cust_id = '".$query."' or cust_no like '%".$query."%' or cust_alamat like '%".$query."%' or cust_nama like '%".$query."%' or cust_telprumah like '%".$query."%' or cust_telprumah2 like '%".$query."%' or cust_telpkantor like '%".$query."%' or cust_hp like '%".$query."%' or cust_hp2 like '%".$query."%' or cust_hp3 like '%".$query."%') ";
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		$limit = $sql." LIMIT ".$start.",".$end;			
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
		function voucher_list($filter,$start,$end){
			$query =   "select c.cust_no as cust_no, c.cust_nama as cust_nama, v.*
						from voucher v
						left join vu_customer c on (c.member_no = v.voucher_cust) or (replace(c.member_no, '-', '') = v.voucher_cust)
						";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (voucher_no LIKE '%".addslashes($filter)."%' OR 
							 voucher_nama LIKE '%".addslashes($filter)."%' OR 
							 voucher_cust LIKE '%".addslashes($filter)."%' )";
			}
			else //default hari ini
			{
				$query .= " WHERE (date_format(voucher_tgl, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d'))";
			}
			
			$query .= " order by v.voucher_tgl desc ";
			
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
		
		
		//fcuntion for delete record
		function voucher_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the vouchers at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM voucher WHERE voucher_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM voucher WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "voucher_id= ".$pkid[$i];
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
		function voucher_search($voucher_no ,$voucher_nama ,$voucher_member_no, $voucher_cust, $voucher_point ,$voucher_tanggal_start, $voucher_tanggal_end, $voucher_kadaluarsa ,$voucher_cashback ,$start,$end){
			//full query
			$query=    "select c.cust_no as cust_no, c.cust_nama as cust_nama, v.*
						from voucher v
						left join vu_customer c on c.member_no = v.voucher_cust
						";
			
			
			if($voucher_member_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_cust LIKE '%".$voucher_member_no."%'";
			};
			
			if($voucher_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_no LIKE '%".$voucher_no."%'";
			};
			
			if($voucher_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_cust LIKE '%".$voucher_cust."%'";
			};
			
			if($voucher_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_nama LIKE '%".$voucher_nama."%'";
			};

			if($voucher_point!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_point LIKE '%".$voucher_point."%'";
			};
			if($voucher_kadaluarsa!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_kadaluarsa LIKE '%".$voucher_kadaluarsa."%'";
			};
			if($voucher_cashback!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " voucher_cashback LIKE '%".$voucher_cashback."%'";
			};
			if($voucher_tanggal_start!='' && $voucher_tanggal_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(v.voucher_tgl, '%Y-%m-%d') BETWEEN '".$voucher_tanggal_start."' AND '".$voucher_tanggal_end."'";
			}
	
			$query.= " order by v.voucher_tgl desc ";
			
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
		function voucher_print($voucher_no ,$voucher_nama , $voucher_member_no, $voucher_cust, $voucher_point ,$voucher_kadaluarsa ,$voucher_cashback ,$option,$filter){
			//full query
			$query="select * from voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (voucher_no LIKE '%".addslashes($filter)."%' OR 
							 voucher_nama LIKE '%".addslashes($filter)."%' OR
							 voucher_member_no LIKE '%".addslashes($filter)."%' OR
							 voucher_cust LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($voucher_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_no LIKE '%".$voucher_no."%'";
				};
				
				if($voucher_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_cust LIKE '%".$voucher_cust."%'";
				};
				if($voucher_member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_nama LIKE '%".$voucher_member_no."%'";
				};
				if($voucher_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_nama LIKE '%".$voucher_nama."%'";
				};
				if($voucher_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_point LIKE '%".$voucher_point."%'";
				};
				
				if($voucher_kadaluarsa!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_kadaluarsa LIKE '%".$voucher_kadaluarsa."%'";
				};
				if($voucher_cashback!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_cashback LIKE '%".$voucher_cashback."%'";
				};
			}
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function voucher_export_excel($voucher_no ,$voucher_nama , $voucher_member_no, $voucher_cust, $voucher_point ,$voucher_kadaluarsa ,$voucher_cashback ,
									  $option,$filter){
			//full query
			$query="SELECT ifnull(voucher_no,'-') as 'No Voucher', voucher_point as Poin, voucher_cashback as 'Nilai (Rp)',
					voucher_kadaluarsa as Kadaluarsa, ifnull(voucher_cust,'-') as 'No Member', voucher_nama as 'Jenis Transaksi' FROM voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (voucher_no LIKE '%".addslashes($filter)."%' OR 
							 voucher_nama LIKE '%".addslashes($filter)."%' OR
							 voucher_member_no LIKE '%".addslashes($filter)."%' OR
							 voucher_cust LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($voucher_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_no LIKE '%".$voucher_no."%'";
				};
				
				if($voucher_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_cust LIKE '%".$voucher_cust."%'";
				};
				if($voucher_member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_nama LIKE '%".$voucher_member_no."%'";
				};
				if($voucher_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_nama LIKE '%".$voucher_nama."%'";
				};
				if($voucher_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_point LIKE '%".$voucher_point."%'";
				};
				
				if($voucher_kadaluarsa!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_kadaluarsa LIKE '%".$voucher_kadaluarsa."%'";
				};
				if($voucher_cashback!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " voucher_cashback LIKE '%".$voucher_cashback."%'";
				};
			}
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>