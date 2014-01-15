<? /* 
	Miracle IT Team
	** last edited by : Windra
	** @function master_lunas_piutang_update() add $fpiutang_cara on line 496
*/

class M_master_lunas_piutang extends Model{
		
	//constructor
	function M_master_lunas_piutang() {
		parent::Model();
	}
	
	function get_cabang(){
		$sql="SELECT info_nama FROM info";
		
		$query2=$this->db->query($sql);
		return $query2; //by isaac
	}
	
	function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$customer,$lunas){
		
		/*switch($group){
			case "Tanggal": $order_by=" ORDER BY tanggal";break;
			case "Customer": $order_by=" ORDER BY cust_id";break;
			default: $order_by=" ORDER BY no_bukti";break;
		}*/
		$order_by="";
		
		if($lunas=='1'){
			$query_lunas = " lpiutang_sisa = 0 AND lpiutang_stat_dok='Tertutup'";
		}else{
			$query_lunas = " lpiutang_sisa >0 AND lpiutang_stat_dok='Terbuka'";
		}
		
		//$sql="SELECT * FROM vu_trans_piutang WHERE tanggal > '2010-07-20' AND lpiutang_sisa>0 AND lpiutang_stat_dok='Terbuka' ".$order_by;
		if($opsi=='rekap'){
			$order_by=" ORDER BY cust_id";
			if($periode=='all')
				$sql="SELECT vu_trans_piutang.*,
					sum(vu_trans_piutang.lpiutang_total) AS piutang_total,
					sum(vu_trans_piutang.lpiutang_sisa) AS piutang_sisa,
					sum(vu_trans_piutang.piutang_tunai) AS piutang_tunai,
					sum(vu_trans_piutang.piutang_card) AS piutang_card,
					sum(vu_trans_piutang.piutang_cek) AS piutang_cek,
					sum(vu_trans_piutang.piutang_transfer) AS piutang_transfer FROM vu_trans_piutang WHERE (tanggal > '2010-07-20') AND  ".$query_lunas." GROUP BY vu_trans_piutang.lpiutang_cust";
			else if($periode=='bulan')
				$sql="SELECT vu_trans_piutang.*,
					sum(vu_trans_piutang.lpiutang_total) AS piutang_total,
					sum(vu_trans_piutang.lpiutang_sisa) AS piutang_sisa,
					sum(vu_trans_piutang.piutang_tunai) AS piutang_tunai,
					sum(vu_trans_piutang.piutang_card) AS piutang_card,
					sum(vu_trans_piutang.piutang_cek) AS piutang_cek,
					sum(vu_trans_piutang.piutang_transfer) AS piutang_transfer FROM vu_trans_piutang WHERE (tanggal > '2010-07-20') AND ".$query_lunas ." AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' GROUP BY cust_id ";
			else if($periode=='tanggal')
				$sql="SELECT vu_trans_piutang.*,
					sum(vu_trans_piutang.lpiutang_total) AS piutang_total,
					sum(vu_trans_piutang.lpiutang_sisa) AS piutang_sisa,
					sum(vu_trans_piutang.piutang_tunai) AS piutang_tunai,
					sum(vu_trans_piutang.piutang_card) AS piutang_card,
					sum(vu_trans_piutang.piutang_cek) AS piutang_cek,
					sum(vu_trans_piutang.piutang_transfer) AS piutang_transfer FROM vu_trans_piutang WHERE (tanggal > '2010-07-20') AND ".$query_lunas ." AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' GROUP BY cust_id ";
		}else if($opsi=='detail'){
			$order_by=" ORDER BY cust_id, no_bukti, dpiutang_nobukti";
			if($periode=='all')
				$sql="SELECT * FROM vu_detail_lunas_piutang WHERE (tanggal > '2010-07-20') AND ".$query_lunas ." ";
			else if($periode=='bulan')
				$sql="SELECT * FROM vu_detail_lunas_piutang WHERE (tanggal > '2010-07-20') AND ".$query_lunas ." AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ";
			else if($periode=='tanggal')
				$sql="SELECT * FROM vu_detail_lunas_piutang WHERE (tanggal > '2010-07-20') AND ".$query_lunas ." AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ";
		}
		
		if(is_numeric($customer)){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" cust_id=".$customer;
		}
		$sql.=$order_by;
		
		$query=$this->db->query($sql);
		if($opsi=='faktur')
			return $query;
		else
			return $query->result();
	}
	
	
	function get_faktur_piutang_selected_list($fpiutang_id,$query,$start,$end){
		if($fpiutang_id>0){
			$sql_dpiutang="SELECT dpiutang_master
				FROM detail_lunas_piutang
					JOIN master_faktur_lunas_piutang ON(fpiutang_nobukti=dpiutang_nobukti)
				WHERE fpiutang_id='".$fpiutang_id."'";
			$rs=$this->db->query($sql_dpiutang);
			$rs_rows=$rs->num_rows();
		}
		
		$sql="SELECT lpiutang_id
				,lpiutang_faktur
				,lpiutang_cust
				,date_format(lpiutang_faktur_tanggal,'%d-%m-%Y') AS lpiutang_faktur_tanggal
				,lpiutang_total
				,lpiutang_sisa
				,lpiutang_stat_dok
			FROM master_lunas_piutang";
			
		if($rs_rows){
			$filter="";
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			foreach($rs->result() as $row_dpiutang){
				
				$filter.="OR lpiutang_id='".$row_dpiutang->dpiutang_master."' ";
			}
			$sql=$sql."(".substr($filter,2,strlen($filter)).")";
		}
		/*
		if($query!==""){
			$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
		}*/
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
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
			
	/*function get_faktur_piutang_all_list($cust_id,$query,$start,$end){
		
		$sql="SELECT lpiutang_id
				,lpiutang_faktur
				,lpiutang_cust
				,date_format(lpiutang_faktur_tanggal,'%d-%m-%Y') AS lpiutang_faktur_tanggal
				,lpiutang_total
				,lpiutang_sisa
				,lpiutang_stat_dok
			FROM master_lunas_piutang
			WHERE lpiutang_cust='".$cust_id."' and lpiutang_stat_dok='Tertutup'";
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		
		if($nbrows>0){
			foreach($result->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}*/
	
		
	function get_faktur_piutang_detail_list($cust_id,$query,$start,$end){
		$sql="SELECT lpiutang_id
				,lpiutang_faktur
				,lpiutang_cust
				,date_format(lpiutang_faktur_tanggal,'%d-%m-%Y') AS lpiutang_faktur_tanggal
				,lpiutang_total
				,lpiutang_sisa
				,lpiutang_stat_dok
			FROM master_lunas_piutang
			WHERE lpiutang_sisa<>0 and lpiutang_stat_dok='Terbuka'";
		if($cust_id<>""){
			$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ");
			$sql.=" lpiutang_cust='".$cust_id."'  AND lpiutang_faktur_tanggal > '2010-07-20'";
		}
		
		/*if($query!==""){
			$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
		}*/
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		
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
	
	//function for detail
	//get record list
	function detail_fpiutang_bylp_list($fpiutang_nobukti,$query,$start,$end){
		$sql = "SELECT lpiutang_id
				,lpiutang_faktur
				,lpiutang_faktur_tanggal
				,lpiutang_total
				,lpiutang_sisa
				,lpiutang_stat_dok
				,lpiutang_status
				,lpiutang_keterangan
				,dpiutang_id
				,dpiutang_nilai
				,dpiutang_keterangan
			FROM detail_lunas_piutang
				LEFT JOIN master_lunas_piutang ON(lpiutang_id=dpiutang_master)
			WHERE dpiutang_nobukti='".$fpiutang_nobukti."'";
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		
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
	//end of function
		
		//get master id, note : not done yet
		/*function get_master_id() {
			$query = "SELECT max(order_id) as master_id from master_lunas_piutang";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$master_id=$data->master_id;
				return $master_id;
			}else{
				return '0';
			}
		}*/
		//eof
		
		//purge all detail from master
		function detail_detail_lunas_piutang_purge($master_id){
			$sql="DELETE from detail_lunas_piutang where dorder_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
	//insert detail record
	function detail_lunas_piutang_insert($fpiutang_cust ,$array_dpiutang_id ,$array_lpiutang_id ,$fpiutang_no ,$array_dpiutang_nilai
										 ,$fpiutang_cara ,$array_dpiutang_keterangan ,$cetak_lp){
		$date_now=date('Y-m-d');
		
		$size_array = sizeof($array_lpiutang_id) - 1;
		
		for($i = 0; $i < sizeof($array_lpiutang_id); $i++){
			$dpiutang_id = $array_dpiutang_id[$i];
			$lpiutang_id = $array_lpiutang_id[$i];
			$dpiutang_nilai = $array_dpiutang_nilai[$i];
			$dpiutang_keterangan = $array_dpiutang_keterangan[$i];
			
			if($dpiutang_id==0){
				//proses insert detail
				$dti = array(
					"dpiutang_master"=>$lpiutang_id,
					"dpiutang_nobukti"=>$fpiutang_no,
					"dpiutang_nilai"=>$dpiutang_nilai,
					"dpiutang_cara"=>$fpiutang_cara,
					"dpiutang_keterangan"=>$dpiutang_keterangan
				);
				$this->db->query('LOCK TABLE detail_lunas_piutang WRITE');
				$this->db->insert('detail_lunas_piutang', $dti);
				$this->db->query('UNLOCK TABLES');
			}else{
				//proses edit detail
				$dtu = array(
					"dpiutang_master"=>$lpiutang_id,
					"dpiutang_nobukti"=>$fpiutang_no,
					"dpiutang_nilai"=>$dpiutang_nilai,
					"dpiutang_cara"=>$fpiutang_cara,
					"dpiutang_keterangan"=>$dpiutang_keterangan
				);
				$this->db->query('LOCK TABLE detail_lunas_piutang WRITE');
				$this->db->where('dpiutang_id', $dpiutang_id);
				$this->db->update('detail_lunas_piutang', $dtu);
				$this->db->query('UNLOCK TABLES');
			}
			if($cetak_lp==1 && $i==$size_array){
				/*update db.master_lunas_piutang.lpiutang_sisa*/
				$sql = "SELECT * FROM vu_piutang_total_lunas WHERE vu_piutang_total_lunas.fpiutang_cust='".$fpiutang_cust."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()>0){
					foreach($rs->result() as $row){
						$sqlu = "UPDATE master_lunas_piutang
							SET lpiutang_sisa = (lpiutang_total-".$row->total_pelunasan.")
							WHERE lpiutang_id=".$row->dpiutang_master;
						$this->db->query('LOCK TABLE master_lunas_piutang WRITE');
						$this->db->query($sqlu);
						$this->db->query('UNLOCK TABLES');
						
						$sqlu_status = "UPDATE master_lunas_piutang
							SET lpiutang_status = 'lunas', lpiutang_stat_dok = 'Tertutup'
							WHERE lpiutang_sisa=0 AND lpiutang_id=".$row->dpiutang_master;
						$this->db->query('LOCK TABLE master_lunas_piutang WRITE');
						$this->db->query($sqlu_status);
						$this->db->query('UNLOCK TABLES');
					}
				}
				/*proses cetak*/
				$sql = "SELECT fpiutang_id FROM master_faktur_lunas_piutang WHERE fpiutang_nobukti='".$fpiutang_no."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()>0){
					$record = $rs->row_array();
					$fpiutang_id = $record['fpiutang_id'];
					return $fpiutang_id;
				}else{
					return 0;
				}
				
			}else if($cetak_lp<>1 && $i==$size_array){
				/*update db.master_lunas_piutang.lpiutang_sisa*/
				$sql = "SELECT * FROM vu_piutang_total_lunas WHERE vu_piutang_total_lunas.fpiutang_cust='".$fpiutang_cust."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()>0){
					foreach($rs->result() as $row){
						$sqlu = "UPDATE master_lunas_piutang
							SET lpiutang_sisa = (lpiutang_total-".$row->total_pelunasan.")
							WHERE lpiutang_id=".$row->dpiutang_master;
						$this->db->query('LOCK TABLE master_lunas_piutang WRITE');
						$this->db->query($sqlu);
						$this->db->query('UNLOCK TABLES');
						
						$sqlu_status = "UPDATE master_lunas_piutang
							SET lpiutang_status = 'lunas', lpiutang_stat_dok = 'Tertutup'
							WHERE lpiutang_sisa=0 AND lpiutang_id=".$row->dpiutang_master;
						$this->db->query('LOCK TABLE master_lunas_piutang WRITE');
						$this->db->query($sqlu_status);
						$this->db->query('UNLOCK TABLES');
					}
				}
				return 0;
			}
			
		}
		
	}
	//end of function
		
		
		//function for get list record
		function master_lunas_piutang_list($filter,$start,$end){
			$query = "SELECT fpiutang_id
					,fpiutang_nobukti
					,fpiutang_cust
					,date_format(fpiutang_tanggal,'%Y-%m-%d') AS fpiutang_tanggal
					,fpiutang_cara
					,fpiutang_bayar
					,fpiutang_stat_dok
					,cust_id
					,cust_nama
					,cust_no
					,vu_piutang_total_bycust.lpiutang_total
					,vu_piutang_total_bycust.lpiutang_sisa
				FROM master_faktur_lunas_piutang
					LEFT JOIN customer ON(cust_id=fpiutang_cust)
					LEFT JOIN vu_piutang_total_bycust ON(vu_piutang_total_bycust.lpiutang_cust=master_faktur_lunas_piutang.fpiutang_cust)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (fpiutang_nobukti LIKE '%".addslashes($filter)."%' OR 
							 cust_nama LIKE '%".addslashes($filter)."%' )";
			}
			
			$query.=" ORDER BY fpiutang_tanggal DESC";
			
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
	function master_lunas_piutang_update($fpiutang_id ,$fpiutang_no ,$fpiutang_cust ,$fpiutang_tanggal, $fpiutang_keterangan ,$fpiutang_status
										,$fpiutang_cara ,$fpiutang_bayar
										,$fpiutang_kwitansi_no ,$fpiutang_kwitansi_nama
										,$fpiutang_card_nama ,$fpiutang_card_edc ,$fpiutang_card_no
										,$fpiutang_cek_nama ,$fpiutang_cek_no ,$fpiutang_cek_valid ,$fpiutang_cek_bank
										,$fpiutang_transfer_bank ,$fpiutang_transfer_nama
										,$array_dpiutang_id ,$array_lpiutang_id ,$array_dpiutang_nilai ,$array_dpiutang_keterangan
										,$cetak_lp){
		$date_now=date('Y-m-d');
		$datetime_now=date('Y-m-d H:i:s');
		
		$jenis_transaksi = 'jual_lunas';
		
		$data = array(
			"fpiutang_tanggal"=>$fpiutang_tanggal,
			"fpiutang_cara"=>$fpiutang_cara,
			"fpiutang_bayar"=>$fpiutang_bayar,
			"fpiutang_keterangan"=>$fpiutang_keterangan,
			"fpiutang_date_update"=>$datetime_now,
			"fpiutang_update"=>$_SESSION[SESSION_USERID]
		);
		
		if($cetak_lp==1){
			$data['fpiutang_stat_dok'] = 'Tertutup';
		}else{
			$data['fpiutang_stat_dok'] = 'Terbuka';
		}
		
		$this->db->query('LOCK TABLE master_faktur_lunas_piutang WRITE');
		$this->db->where('fpiutang_id' ,$fpiutang_id);
		$this->db->update('master_faktur_lunas_piutang', $data);
		$rs = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($rs>-1){
			$time_now = date('H:i:s');
			$bayar_date_create_temp = $fpiutang_tanggal.' '.$time_now;
			$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
			
			//delete all transaksi
			$sql="delete from jual_kwitansi where jkwitansi_ref='".$fpiutang_no."'";
			$this->db->query($sql);
			if($this->db->affected_rows()>-1){
				$sql="delete from jual_card where jcard_ref='".$fpiutang_no."'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_cek where jcek_ref='".$fpiutang_no."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_transfer where jtransfer_ref='".$fpiutang_no."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_tunai where jtunai_ref='".$fpiutang_no."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								if($fpiutang_cara!=null || $fpiutang_cara!=''){
									if($fpiutang_cara=='kwitansi'){
										$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($fpiutang_kwitansi_no
																						  ,$fpiutang_bayar
																						  ,$fpiutang_no
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_lp);
										
									}elseif($fpiutang_cara=='card'){
										$result_bayar = $this->m_public_function->cara_bayar_card_insert($fpiutang_card_nama
																					  ,$fpiutang_card_edc
																					  ,$fpiutang_card_no
																					  ,$fpiutang_bayar
																					  ,$fpiutang_no
																					  ,$bayar_date_create
																					  ,$jenis_transaksi
																					  ,$cetak_lp);
									}elseif($fpiutang_cara=='cek/giro'){
										$result_bayar = $this->m_public_function->cara_bayar_cek_insert($fpiutang_cek_nama
																					 ,$fpiutang_cek_no
																					 ,$fpiutang_cek_valid
																					 ,$fpiutang_cek_bank
																					 ,$fpiutang_bayar
																					 ,$fpiutang_no
																					 ,$bayar_date_create
																					 ,$jenis_transaksi
																					 ,$cetak_lp);
									}elseif($fpiutang_cara=='transfer'){
										$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($fpiutang_transfer_bank
																						  ,$fpiutang_transfer_nama
																						  ,$fpiutang_bayar
																						  ,$fpiutang_no
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_lp);
									}elseif($fpiutang_cara=='tunai'){
										$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($fpiutang_bayar
																					   ,$fpiutang_no
																					   ,$bayar_date_create
																					   ,$jenis_transaksi
																					   ,$cetak_lp);
									}
								}
							}
						}
					}
				}
			}
			
			$rs_dpiutang_insert = $this->detail_lunas_piutang_insert($fpiutang_cust ,$array_dpiutang_id ,$array_lpiutang_id ,$fpiutang_no ,$array_dpiutang_nilai ,$fpiutang_cara ,$array_dpiutang_keterangan ,$cetak_lp);

			
			if($cetak_lp==1){
				return $rs_dpiutang_insert;
			}else{
				return '0';
			}
			
		}else{
			return '-1';
		}
	}
	
	//function for create new record
	function master_lunas_piutang_create($fpiutang_cust ,$fpiutang_tanggal, $fpiutang_keterangan ,$fpiutang_status
										,$fpiutang_cara ,$fpiutang_bayar
										,$fpiutang_kwitansi_no ,$fpiutang_kwitansi_nama
										,$fpiutang_card_nama ,$fpiutang_card_edc ,$fpiutang_card_no
										,$fpiutang_cek_nama ,$fpiutang_cek_no ,$fpiutang_cek_valid ,$fpiutang_cek_bank
										,$fpiutang_transfer_bank ,$fpiutang_transfer_nama
										,$array_dpiutang_id ,$array_lpiutang_id ,$array_dpiutang_nilai ,$array_dpiutang_keterangan
										,$cetak_lp){
		$date_now=date('Y-m-d');
		
		$jenis_transaksi = 'jual_lunas';
		
		$pattern="LP/".date("ym")."-";
		$fpiutang_no=$this->m_public_function->get_kode_1('master_faktur_lunas_piutang','fpiutang_nobukti',$pattern,12);
		
		$data = array(
			"fpiutang_nobukti"=>$fpiutang_no,
			"fpiutang_cust"=>$fpiutang_cust,
			"fpiutang_tanggal"=>$fpiutang_tanggal,
			"fpiutang_cara"=>$fpiutang_cara,
			"fpiutang_bayar"=>$fpiutang_bayar,
			"fpiutang_keterangan"=>$fpiutang_keterangan,
			"fpiutang_creator"=>$_SESSION[SESSION_USERID]
		);
		
		if($cetak_lp==1){
			$data['fpiutang_stat_dok'] = 'Tertutup';
		}else{
			$data['fpiutang_stat_dok'] = 'Terbuka';
		}
		
		$this->db->query('LOCK TABLE master_faktur_lunas_piutang WRITE');
		$this->db->insert('master_faktur_lunas_piutang', $data);
		$fpiutang_id = $this->db->insert_id();
		$rs = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($rs>0){
			$time_now = date('H:i:s');
			$bayar_date_create_temp = $fpiutang_tanggal.' '.$time_now;
			$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
			
			//delete all transaksi
			$sql="delete from jual_kwitansi where jkwitansi_ref='".$fpiutang_no."'";
			$this->db->query($sql);
			if($this->db->affected_rows()>-1){
				$sql="delete from jual_card where jcard_ref='".$fpiutang_no."'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_cek where jcek_ref='".$fpiutang_no."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_transfer where jtransfer_ref='".$fpiutang_no."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_tunai where jtunai_ref='".$fpiutang_no."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								if($fpiutang_cara!=null || $fpiutang_cara!=''){
									if($fpiutang_cara=='kwitansi'){
										$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($fpiutang_kwitansi_no
																						  ,$fpiutang_bayar
																						  ,$fpiutang_no
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_lp);
										
									}elseif($fpiutang_cara=='card'){
										$result_bayar = $this->m_public_function->cara_bayar_card_insert($fpiutang_card_nama
																					  ,$fpiutang_card_edc
																					  ,$fpiutang_card_no
																					  ,$fpiutang_bayar
																					  ,$fpiutang_no
																					  ,$bayar_date_create
																					  ,$jenis_transaksi
																					  ,$cetak_lp);
									}elseif($fpiutang_cara=='cek/giro'){
										$result_bayar = $this->m_public_function->cara_bayar_cek_insert($fpiutang_cek_nama
																					 ,$fpiutang_cek_no
																					 ,$fpiutang_cek_valid
																					 ,$fpiutang_cek_bank
																					 ,$fpiutang_bayar
																					 ,$fpiutang_no
																					 ,$bayar_date_create
																					 ,$jenis_transaksi
																					 ,$cetak_lp);
									}elseif($fpiutang_cara=='transfer'){
										$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($fpiutang_transfer_bank
																						  ,$fpiutang_transfer_nama
																						  ,$fpiutang_bayar
																						  ,$fpiutang_no
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_lp);
									}elseif($fpiutang_cara=='tunai'){
										$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($fpiutang_bayar
																					   ,$fpiutang_no
																					   ,$bayar_date_create
																					   ,$jenis_transaksi
																					   ,$cetak_lp);
									}
								}
							}
						}
					}
				}
			}
			
			$rs_dpiutang_insert = $this->detail_lunas_piutang_insert($fpiutang_cust ,$array_dpiutang_id ,$array_lpiutang_id ,$fpiutang_no
																	 ,$array_dpiutang_nilai ,$fpiutang_cara ,$array_dpiutang_keterangan ,$cetak_lp);
			
			if($cetak_lp==1){
				return $rs_dpiutang_insert;
			}else{
				return '0';
			}
			
		}else{
			return '-1';
		}
	}
		
		//fcuntion for delete record
		function master_lunas_piutang_delete($pkid){
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_lunas_piutang WHERE order_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_lunas_piutang WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "order_id= ".$pkid[$i];
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
	function master_lunas_piutang_search($fpiutang_no, $fpiutang_tgl_awal, $fpiutang_tgl_akhir, $fpiutang_carabayar, $fpiutang_keterangan, $fpiutang_status, $start, $end){

		$query = "SELECT fpiutang_id
					,fpiutang_nobukti
					,fpiutang_cust
					,date_format(fpiutang_tanggal,'%Y-%m-%d') AS fpiutang_tanggal
					,fpiutang_cara
					,fpiutang_bayar
					,fpiutang_stat_dok
					,cust_id
					,cust_nama
					,cust_no
					,vu_piutang_total_bycust.lpiutang_total
					,vu_piutang_total_bycust.lpiutang_sisa
				FROM master_faktur_lunas_piutang
					LEFT JOIN customer ON(cust_id=fpiutang_cust)
					LEFT JOIN vu_piutang_total_bycust ON(vu_piutang_total_bycust.lpiutang_cust=master_faktur_lunas_piutang.fpiutang_cust)";
		
		if($fpiutang_no!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " fpiutang_nobukti LIKE '%".$fpiutang_no."%'";
		};
		if($fpiutang_tgl_awal!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " date_format(fpiutang_tanggal,'%Y-%m-%d')>= '".$fpiutang_tgl_awal."'";
		};
		if($fpiutang_tgl_akhir!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " date_format(fpiutang_tanggal,'%Y-%m-%d')<= '".$fpiutang_tgl_akhir."'";
		};
		if($fpiutang_carabayar!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " fpiutang_cara LIKE '%".$fpiutang_carabayar."%'";
		};
		if($fpiutang_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " fpiutang_keterangan LIKE '%".$fpiutang_keterangan."%'";
		};
		if($fpiutang_status!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " fpiutang_stat_dok LIKE '%".$fpiutang_status."%'";
		};
		
		$query.=" ORDER BY fpiutang_tanggal DESC";
		
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
	
	
	
	function print_paper($fpiutang_id){
		$sql="SELECT fpiutang_tanggal
				,cust_no
				,cust_nama
				,cust_alamat
				,fpiutang_nobukti
				,lpiutang_faktur
				,dpiutang_nilai
			FROM detail_lunas_piutang
				LEFT JOIN master_lunas_piutang ON(lpiutang_id=dpiutang_master)
				LEFT JOIN master_faktur_lunas_piutang ON(fpiutang_nobukti=dpiutang_nobukti)
				LEFT JOIN customer ON(cust_id=fpiutang_cust)
			WHERE fpiutang_id='".$fpiutang_id."'
			ORDER BY lpiutang_faktur ASC";
		$result = $this->db->query($sql);
		return $result;
	}
	
	function cara_bayar($fpiutang_id){
		$sql="SELECT fpiutang_nobukti, fpiutang_cara FROM master_faktur_lunas_piutang WHERE fpiutang_id='".$fpiutang_id."'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
			$fpiutang_nobukti = $record->fpiutang_nobukti;
			if(($record->fpiutang_cara !== NULL || $record->fpiutang_cara !== '')){
				if($record->fpiutang_cara == 'tunai'){
					$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$fpiutang_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT fpiutang_nobukti, fpiutang_cara, jtunai_nilai AS bayar_nilai
						FROM master_faktur_lunas_piutang
							LEFT JOIN jual_tunai ON(jtunai_ref=fpiutang_nobukti)
						WHERE fpiutang_id='".$fpiutang_id."' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->fpiutang_cara == 'kwitansi'){
					$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$fpiutang_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT fpiutang_nobukti, fpiutang_cara, jkwitansi_nilai AS bayar_nilai
						FROM master_faktur_lunas_piutang
							LEFT JOIN jual_kwitansi ON(jkwitansi_ref=fpiutang_nobukti)
						WHERE fpiutang_id='".$fpiutang_id."' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->fpiutang_cara == 'card'){
					$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$fpiutang_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT fpiutang_nobukti, fpiutang_cara, jcard_nilai AS bayar_nilai
						FROM master_faktur_lunas_piutang
							LEFT JOIN jual_card ON(jcard_ref=fpiutang_nobukti)
						WHERE fpiutang_id='".$fpiutang_id."' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->fpiutang_cara == 'cek/giro'){
					$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$fpiutang_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT fpiutang_nobukti, fpiutang_cara, jcek_nilai AS bayar_nilai
						FROM master_faktur_lunas_piutang
							LEFT JOIN jual_cek ON(jcek_ref=fpiutang_nobukti)
						WHERE fpiutang_id='".$fpiutang_id."' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->fpiutang_cara == 'transfer'){
					$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$fpiutang_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT fpiutang_nobukti, fpiutang_cara, jtransfer_nilai AS bayar_nilai
						FROM master_faktur_lunas_piutang
							LEFT JOIN jual_transfer ON(jtransfer_ref=fpiutang_nobukti)
						WHERE fpiutang_id='".$fpiutang_id."' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	
	function master_lunas_piutang_batal($fpiutang_id, $fpiutang_tanggal){
		$date = date('Y-m-d');
		$date_1 = '01';
		$date_2 = '02';
		$date_3 = '03';
		$month = substr($fpiutang_tanggal,5,2);
		$year = substr($fpiutang_tanggal,0,4);
		$begin=mktime(0,0,0,$month,1,$year);
		$nextmonth=strtotime("+1month",$begin);
		
		$month_next = substr(date("Y-m-d",$nextmonth),5,2);
		$year_next = substr(date("Y-m-d",$nextmonth),0,4);
		
		$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
		$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
		$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
		$datetime_now = date('Y-m-d H:i:s');
		$sql = "UPDATE master_faktur_lunas_piutang
			SET fpiutang_stat_dok='Batal'
				,fpiutang_update='".@$_SESSION[SESSION_USERID]."'
				,fpiutang_date_update='".$datetime_now."'
				,fpiutang_revised=fpiutang_revised+1
			WHERE fpiutang_id='".$fpiutang_id."' " ;
		$this->db->query('LOCK TABLE master_faktur_lunas_piutang WRITE');
		$this->db->query($sql);
		$rs = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($rs>0){
			/*update db.master_lunas_piutang.lpiutang_sisa*/
			$sql = "SELECT dpiutang_master, fpiutang_nobukti, fpiutang_cara
				FROM detail_lunas_piutang
					LEFT JOIN master_faktur_lunas_piutang ON(fpiutang_nobukti=dpiutang_nobukti)
				WHERE fpiutang_id='".$fpiutang_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()>0){
				$record = $rs->row_array();
				$fpiutang_nobukti = $record['fpiutang_nobukti'];
				$fpiutang_cara = $record['fpiutang_cara'];
				
				if($fpiutang_cara=='card'){
					$sql = "UPDATE jual_card
						SET jcard_stat_dok='Batal'
						WHERE jcard_ref='".$fpiutang_nobukti."'";
					$this->db->query($sql);
				}elseif($fpiutang_cara=='cek/giro'){
					$sql = "UPDATE jual_cek
						SET jcek_stat_dok='Batal'
						WHERE jcek_ref='".$fpiutang_nobukti."'";
					$this->db->query($sql);
				}elseif($fpiutang_cara=='transfer'){
					$sql = "UPDATE jual_transfer
						SET jtransfer_stat_dok='Batal'
						WHERE jtransfer_ref='".$fpiutang_nobukti."'";
					$this->db->query($sql);
				}elseif($fpiutang_cara=='tunai'){
					$sql = "UPDATE jual_tunai
						SET jtunai_stat_dok='Batal'
						WHERE jtunai_ref='".$fpiutang_nobukti."'";
					$this->db->query($sql);
				}
				
				foreach($rs->result() as $row){
					$sqlu = "UPDATE master_lunas_piutang
							LEFT JOIN vu_piutang_total_lunas ON(vu_piutang_total_lunas.dpiutang_master=master_lunas_piutang.lpiutang_id)
						SET lpiutang_sisa = (lpiutang_total-(ifnull(vu_piutang_total_lunas.total_pelunasan,0))), lpiutang_stat_dok = 'Terbuka', lpiutang_status = 'piutang'
						WHERE lpiutang_id=".$row->dpiutang_master;
					$this->db->query('LOCK TABLE master_lunas_piutang WRITE, vu_piutang_total_lunas WRITE');
					$this->db->query($sqlu);
					$this->db->query('UNLOCK TABLES');
				}
			}
			return '1';
			
		}else{
			return '0';
		}
	}
}
?>