<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: lap_poin_hangus Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_poin_hangus.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
*/

class M_lap_poin_hangus extends Model{
		
		//constructor
		function M_lap_poin_hangus() {
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
		function lap_poin_hangus_list($filter,$start,$end){
			$query =   "select c.cust_no as cust_no, c.cust_nama as cust_nama, l.*, c.member_no
						from log_poin_reset l
						left join vu_customer c on c.cust_id = l.log_cust
						";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " ( cust_nama LIKE '%".addslashes($filter)."%' )";
			}
			//else //default hari ini
			//{
				//$query .= " WHERE (date_format(log_date_create, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d'))";
			//}
			
			$query .= " order by l.log_date_create desc ";
			
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
		function lap_poin_hangus_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the lap_poin_hanguss at the same time :
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
		
		
		//fcuntion for mengembalikan poin customer
		function lap_poin_return($pkid, $tgl_id,$keterangan, $cust_id){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to confirm all of the lap_poin_hanguss at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				//Ngecek dulu apakah id log poin ini sudah perna di lakukan pengembalian, jika sudah pernah, maka akan return 2 utk menampilkan bahwa sudah perna dilakukan pengembalian, Jika blom pernah, maka akan melakukan pengecekan tanggal penguncian kembali_poin_days, jika lolos, maka akan mengupdate cust_point, jika tidak akan return 3
				$sql_cek = "select log_id from log_poin_reset WHERE log_id = '".$pkid[0]."' and log_stat_poin_return = 'Sudah Pernah'";
				$rs_cek =$this->db->query($sql_cek);
				if($rs_cek->num_rows())
				{
					return 2;
				}
				
				else
				{
					$sql_days = "select kembali_poin_days from transaksi_setting where date_format(now(), '%Y-%m-%d') < adddate('".$tgl_id[0]."',INTERVAL kembali_poin_days day)  limit 1";
					$rs_cek_days =$this->db->query($sql_days);
					
					if($rs_cek_days->num_rows()){
						$sql_update = "UPDATE customer
										LEFT JOIN log_poin_reset on (customer.cust_id = log_poin_reset.log_cust)
										SET cust_point = cust_point + log_poin,log_tgl_poin_return = now(),log_keterangan = '".$keterangan."', log_stat_poin_return = 'Sudah Pernah'
										WHERE log_id = '".$pkid[0]."' and cust_id = '".$cust_id[0]."'";
						$this->db->query($sql_update);
						return 1;
					}
					else
					{
						return 3;
					}
				}
			} 
		
		}
		
		//function for advanced search record
		function lap_poin_hangus_search($log_id, $lap_poin_hangus_nmcust, $lap_poin_hangus_tanggal_start, $lap_poin_hangus_tanggal_end,$start,$end){
			//full query
			$query=    "select c.cust_no as cust_no, c.cust_nama as cust_nama, l.*
						from log_poin_reset l
						left join vu_customer c on c.cust_id = l.log_cust
						";
			
			if($log_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " log_id LIKE '%".$log_id."%'";
			};
			
			//if($log_cust!=''){
				//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				//$query.= " log_cust LIKE '%".$log_cust."%'";
			//};
			
			//if($log_poin!=''){
				//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				//$query.= " log_poin LIKE '%".$log_poin."%'";
			//};
			
			//if($cust_no!=''){
				//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				//$query.= " cust_no LIKE '%".$cust_no."%'";
			//};

			if($lap_poin_hangus_nmcust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id = '".$lap_poin_hangus_nmcust."'";
			};

			if($lap_poin_hangus_tanggal_start!='' && $lap_poin_hangus_tanggal_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(l.log_date_create, '%Y-%m-%d') BETWEEN '".$lap_poin_hangus_tanggal_start."' AND '".$lap_poin_hangus_tanggal_end."'";
			}
	
			$query.= " order by l.log_date_create desc ";
			
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
		function lap_poin_hangus_print($lap_poin_hangus_no ,$lap_poin_hangus_nama , $lap_poin_hangus_member_no, $lap_poin_hangus_cust, $lap_poin_hangus_point ,$lap_poin_hangus_kadaluarsa ,$lap_poin_hangus_cashback ,$option,$filter){
			//full query
			$query="select * from voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (lap_poin_hangus_no LIKE '%".addslashes($filter)."%' OR 
							 lap_poin_hangus_nama LIKE '%".addslashes($filter)."%' OR
							 lap_poin_hangus_member_no LIKE '%".addslashes($filter)."%' OR
							 lap_poin_hangus_cust LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($lap_poin_hangus_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_no LIKE '%".$lap_poin_hangus_no."%'";
				};
				
				if($lap_poin_hangus_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_cust LIKE '%".$lap_poin_hangus_cust."%'";
				};
				if($lap_poin_hangus_member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_nama LIKE '%".$lap_poin_hangus_member_no."%'";
				};
				if($lap_poin_hangus_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_nama LIKE '%".$lap_poin_hangus_nama."%'";
				};
				if($lap_poin_hangus_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_point LIKE '%".$lap_poin_hangus_point."%'";
				};
				
				if($lap_poin_hangus_kadaluarsa!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_kadaluarsa LIKE '%".$lap_poin_hangus_kadaluarsa."%'";
				};
				if($lap_poin_hangus_cashback!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_cashback LIKE '%".$lap_poin_hangus_cashback."%'";
				};
			}
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function lap_poin_hangus_export_excel($lap_poin_hangus_no ,$lap_poin_hangus_nama , $lap_poin_hangus_member_no, $lap_poin_hangus_cust, $lap_poin_hangus_point ,$lap_poin_hangus_kadaluarsa ,$lap_poin_hangus_cashback ,
									  $option,$filter){
			//full query
			$query="SELECT ifnull(voucher_no,'-') as 'No Voucher', voucher_point as Poin, voucher_cashback as 'Nilai (Rp)',
					voucher_kadaluarsa as Kadaluarsa, ifnull(voucher_cust,'-') as 'No Member', voucher_nama as 'Jenis Transaksi' FROM voucher";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (lap_poin_hangus_no LIKE '%".addslashes($filter)."%' OR 
							 lap_poin_hangus_nama LIKE '%".addslashes($filter)."%' OR
							 lap_poin_hangus_member_no LIKE '%".addslashes($filter)."%' OR
							 lap_poin_hangus_cust LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($lap_poin_hangus_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_no LIKE '%".$lap_poin_hangus_no."%'";
				};
				
				if($lap_poin_hangus_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_cust LIKE '%".$lap_poin_hangus_cust."%'";
				};
				if($lap_poin_hangus_member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_nama LIKE '%".$lap_poin_hangus_member_no."%'";
				};
				if($lap_poin_hangus_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_nama LIKE '%".$lap_poin_hangus_nama."%'";
				};
				if($lap_poin_hangus_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_point LIKE '%".$lap_poin_hangus_point."%'";
				};
				
				if($lap_poin_hangus_kadaluarsa!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_kadaluarsa LIKE '%".$lap_poin_hangus_kadaluarsa."%'";
				};
				if($lap_poin_hangus_cashback!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " lap_poin_hangus_cashback LIKE '%".$lap_poin_hangus_cashback."%'";
				};
			}
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>