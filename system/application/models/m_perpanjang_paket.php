<? /* 
	+ Module  		: perpanjang_paket Model
	+ Description	: For record model process back-end
	+ Filename 		: m_perpanjang_paket.php
 	+ creator 		: Fred
	
*/

class M_perpanjang_paket extends Model{
		
		//constructor
		function M_perpanjang_paket() {
			parent::Model();
		}
		
		
	function get_paket_list($query,$start,$end){
		$sql="SELECT dpaket_master
					,dpaket_paket
					,cust_id
					,cust_no
					,cust_nama
					,jpaket_tanggal
					,jpaket_nobukti
					,paket_kode
					,paket_nama
					,CONCAT((jpaket_nobukti),' - ',  paket_nama, ' (', cust_nama, ')') as paket_nama_cust
					,dpaket_id
					,dpaket_jumlah
					,dpaket_sisa_paket
					,dpaket_kadaluarsa 
				FROM detail_jual_paket 
				LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
				LEFT JOIN customer ON(jpaket_cust=cust_id) 
				LEFT JOIN paket ON(dpaket_paket=paket_id) 
				WHERE dpaket_sisa_paket > 0
					AND jpaket_stat_dok='Tertutup'";
		if($query<>""){
			$sql=$sql." and (jpaket_nobukti like '%".$query."%' or cust_no like '%".$query."%' or paket_nama like '%".$query."%' or cust_nama like '%".$query."%') ";
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
	function perpanjang_paket_list($filter,$start,$end){
		
			$query = "SELECT 
						CONCAT(customer.cust_nama, ' (', customer.cust_no, ')') as cust_display,
						CONCAT(paket.paket_nama, ' (', master_jual_paket.jpaket_nobukti, ')') as paket_display,
						detail_jual_paket.dpaket_kadaluarsa,
						perpanjang_paket.*,
						date_add(date_format(detail_jual_paket.dpaket_kadaluarsa,'%Y-%m-%d'),INTERVAL -perpanjang_hari DAY) as kadaluarsa_sebelum,
						date_add(date_format(detail_jual_paket.dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) as tanggal_hangus
					FROM perpanjang_paket
					LEFT JOIN detail_jual_paket on (detail_jual_paket.dpaket_id=perpanjang_paket.perpanjang_djpaket_id)
					LEFT JOIN master_jual_paket on (master_jual_paket.jpaket_id=detail_jual_paket.dpaket_master)
					LEFT JOIN customer on (customer.cust_id=master_jual_paket.jpaket_cust)
					LEFT JOIN paket on (paket.paket_id=detail_jual_paket.dpaket_paket)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bank_kode LIKE '%".addslashes($filter)."%' OR bank_nama LIKE '%".addslashes($filter)."%' OR bank_norek LIKE '%".addslashes($filter)."%' OR bank_atasnama LIKE '%".addslashes($filter)."%' )";
			}
			
			$query.=" ORDER BY perpanjang_tanggal DESC";
			
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
		function perpanjang_paket_create($perpanjang_id, $perpanjang_djpaket_id, $perpanjang_hari, $cust_point, $perpanjang_tanggal, $perpanjang_keterangan, $perpanjang_creator, $perpanjang_date_create){
		
		$datetime_now=date('Y-m-d H:i:s');
		
		$sql_check = "select * from perpanjang_paket where perpanjang_djpaket_id = '$perpanjang_djpaket_id'";
		$rs = $this->db->query($sql_check);
		$rs_rows = $rs->num_rows();
		if($rs_rows>0){
			return '2';
		}
		else
		{
			$data = array(
				"perpanjang_id"=>$perpanjang_id,	
				"perpanjang_djpaket_id"=>$perpanjang_djpaket_id,	
				"perpanjang_hari"=>$perpanjang_hari,
				"perpanjang_tanggal"=>$perpanjang_tanggal,
				"perpanjang_keterangan"=>$perpanjang_keterangan,
				"perpanjang_author"=>$_SESSION[SESSION_USERID],
				"perpanjang_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('perpanjang_paket', $data); 
			
			$sql_joincust_1 = "UPDATE detail_jual_paket
				SET dpaket_kadaluarsa = date_add(date_format(detail_jual_paket.dpaket_kadaluarsa,'%Y-%m-%d'),INTERVAL '$perpanjang_hari' DAY)
				WHERE detail_jual_paket.dpaket_id='$perpanjang_djpaket_id'";
			$this->db->query($sql_joincust_1);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}

		}
		
		
}
?>