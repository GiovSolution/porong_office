<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: cetak_kwitansi Model
	+ Description	: For record model process back-end
	+ Filename 		: c_cetak_kwitansi.php
 	+ Author  		: masongbee
 	+ Created on 26/Jan/2010 12:21:55
	
*/

class M_cetak_kwitansi extends Model{
		
		//constructor
		function M_cetak_kwitansi() {
			parent::Model();
		}
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$bulan,$tahun){
			
			$tanggal = "";
			if($periode=='all') {
				$tanggal = "";
			}
			else if($periode=='bulan') {
				$tanggal = " AND date_format(tanggal, '%Y-%m')<='".$tahun."-".$bulan."'";
			} 
			else if($periode=='tanggal') {
				$tanggal = " AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."'";
			}
			
			switch($group){
				case "Tanggal": $order_by=" ORDER BY tanggal";break;
				case "Tanggal (Adjustment)": $order_by=" ORDER BY tgl_jual_kuitansi";break;
				case "Customer": $order_by=" ORDER BY cust_nama ASC";break;
				case "Sisa Kuitansi (Akumulatif)": $order_by=" ORDER BY tanggal ASC";break;
				case "No Kuitansi": $order_by=" ORDER BY no_bukti";break;
				case "No Faktur": $order_by=" ORDER BY no_faktur";break;
				case "Produk": $order_by=" ORDER BY produk_kode";break;
				default: $order_by=" ORDER BY no_bukti ASC";break;
			}
			
			if($opsi=='rekap'){
				if($group=='Sisa Kuitansi (Akumulatif)'){
						$sql="SELECT * FROM vu_trans_kuitansi WHERE stat_dok<>'Batal' and total_sisa <>0 ".$tanggal.$order_by;
				} else {
					if($periode=='all')
						$sql="SELECT distinct * FROM vu_trans_kuitansi WHERE stat_dok<>'Batal' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT distinct * FROM vu_trans_kuitansi WHERE stat_dok<>'Batal' 
								AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT distinct * FROM vu_trans_kuitansi WHERE stat_dok<>'Batal' 
								AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
								AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}else if($opsi=='detail'){
				if($group=='Tanggal (Adjustment)'){
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal'  AND jual_stat_dok<>'Batal' AND jenis_transaksi = 'jual_adj' 
								AND date_format(tgl_jual_kuitansi,'%Y-%m-%d')>='".$tgl_awal."'
								AND date_format(tgl_jual_kuitansi,'%Y-%m-%d')<='".$tgl_akhir."' 
								".$order_by;
				} else {
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal'
								 ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal'
								AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' 
								".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal' 
								AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."'
								AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' 
								".$order_by;
				}
			}
			//echo $sql;
			//$this->firephp->log($sql);
			
			$query=$this->db->query($sql);
			return $query->result();
		}
		
		function kuitansi_status_adj($kwitansi_id,$adj_kwitansi_nilai, $adj_kwitansi_ket){
			$sql = "SELECT * from cetak_kwitansi where kwitansi_id = '".$kwitansi_id."'";
			$rs = $this->db->query($sql);
			$datetime_now = date('Y-m-d H:i:s');			
			$jenis_transaksi = 'jual_adj';
			$adj_kwitansi_ref = 'Adjustment';
			$cetak = '1'; //untuk mengeset agar status langsung tertutup
			$jual_kwitansi_id = '0'; //untuk mengeset selalu insert ke jual kwitansi (tidak ada update)
			
			$this->m_public_function->cara_bayar_kwitansi_insert($kwitansi_id
																  ,$adj_kwitansi_nilai
																  ,$adj_kwitansi_ref
																  ,$datetime_now
																  ,$jenis_transaksi
																  ,$cetak
																  ,$jual_kwitansi_id);
			
			$sql_id = "select max(jkwitansi_id) as jkwitansi_id from jual_kwitansi";
			$rs_id = $this->db->query($sql_id);
			$jkw_id= $rs_id->row();
			$jkwitansi_id= $jkw_id->jkwitansi_id;
			
			$sql_update = "update jual_kwitansi set jkwitansi_keterangan = '".$adj_kwitansi_ket."' where jkwitansi_id ='".$jkwitansi_id."'";
			$this->db->query($sql_update);
			if($this->db->affected_rows()>0){
				return 1;
			}else{
				return 2;
			}
			
			/*if($rs->num_rows()){
				$record = $rs->row_array();
				$dapaket_dpaket = $record['dapaket_dpaket'];
				$dapaket_jpaket = $record['dapaket_jpaket'];
				$dapaket_paket = $record['dapaket_paket'];
				
				//Mengubah status pengambilan paket menjadi Adj/
				if (sizeof($dapaket_id) == 1){
					$query = "UPDATE detail_ambil_paket 
								SET dapaket_stat_dok='Adj',
									dapaket_date_update='".$datetime_now."',
									dapaket_update='".@$_SESSION[SESSION_USERID]."',
									dapaket_revised=(dapaket_revised+1)
						WHERE dapaket_id = ".$dapaket_id[0];
					$this->db->query($query);
					if($this->db->affected_rows()>0){
						$dpaket_sisa_update = $this->total_sisa_paket_update($dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket);
						//echo $dpaket_sisa_update;
						if($dpaket_sisa_update>0){
							return 1;
						}else{
							return 2;
						}
					}
					else
						return 2;
				}		
				else{
					return 2;
				}
			}
			else{
				return 2;
			}*/
		}
		
		function get_customer_kwitansi_list($query,$start,$end){
			$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah
			FROM customer where cust_aktif='Aktif'";
			if($query<>""){
				$sql=$sql." and (cust_no like '%".$query."%' or cust_nama like '%".$query."%' or cust_telprumah like '%".$query."%' or cust_telprumah2 like '%".$query."%' or cust_telpkantor like '%".$query."%' or cust_hp like '%".$query."%' or cust_hp2 like '%".$query."%' or cust_hp3 like '%".$query."%') ";
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
		
		//function for detail
		//get record list
		function detail_jual_kwitansi_list($master_id,$query,$start,$end) {
			//$query = "SELECT * FROM jual_kwitansi WHERE jkwitansi_master='".$master_id."'";
			$query = "SELECT vu_catatan_kwitansi.jkwitansi_id
					,vu_catatan_kwitansi.jkwitansi_master
					,vu_catatan_kwitansi.jkwitansi_ref
					,vu_catatan_kwitansi.jkwitansi_nilai
					,vu_catatan_kwitansi.customer_id
					,vu_catatan_kwitansi.jkwitansi_keterangan
					,vu_catatan_kwitansi.jkwitansi_date_create
					,customer.cust_nama AS customer_nama
					,customer.cust_no AS customer_no
				FROM (select
						jkwitansi_id
						,jkwitansi_master
						,jkwitansi_ref
						,jkwitansi_nilai
						,jkwitansi_keterangan
						,date_format(jkwitansi_date_create,'%d-%m-%Y') as jkwitansi_date_create
						,if(jproduk_cust!='null',jproduk_cust,if(jrawat_cust!='null',jrawat_cust,jpaket_cust)) AS customer_id
					FROM jual_kwitansi
					LEFT JOIN master_jual_produk on(jkwitansi_ref=jproduk_nobukti)
					LEFT JOIN master_jual_rawat on(jkwitansi_ref=jrawat_nobukti)
					LEFT JOIN master_jual_paket ON(jkwitansi_ref=jpaket_nobukti)
					WHERE jkwitansi_stat_dok = 'Tertutup') as vu_catatan_kwitansi
				LEFT JOIN customer ON(vu_catatan_kwitansi.customer_id=customer.cust_id)
				WHERE jkwitansi_master='$master_id'";
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
		//end of function
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(kwitansi_id) as master_id from cetak_kwitansi";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$master_id=$data->master_id;
				return $master_id;
			}else{
				return '0';
			}
		}
		//eof
		
		//purge all detail from master
		function detail_jual_kwitansi_purge($master_id){
			$sql="DELETE from jual_kwitansi where jkwitansi_no='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
		//insert detail record
		function detail_jual_kwitansi_insert($jkwitansi_id ,$jkwitansi_master ,$jkwitansi_no ,$jkwitansi_nilai ,$jkwitansi_ref ,$jkwitansi_creator ,$jkwitansi_date_create ,$jkwitansi_update ,$jkwitansi_date_update ,$jkwitansi_revised ){
			//if master id not capture from view then capture it from max pk from master table
			if($jkwitansi_no=="" || $jkwitansi_no==NULL){
				$jkwitansi_no=$this->get_master_id();
			}
			
			$data = array(
				"jkwitansi_master"=>$jkwitansi_master, 
				"jkwitansi_no"=>$jkwitansi_no, 
				"jkwitansi_nilai"=>$jkwitansi_nilai, 
				"jkwitansi_ref"=>$jkwitansi_ref, 
				"jkwitansi_creator"=>$jkwitansi_creator, 
				"jkwitansi_date_create"=>$jkwitansi_date_create, 
				"jkwitansi_update"=>$jkwitansi_update, 
				"jkwitansi_date_update"=>$jkwitansi_date_update, 
				"jkwitansi_revised"=>$jkwitansi_revised 
			);
			$this->db->insert('jual_kwitansi', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';

		}
		//end of function
		
		//function for get list record
		function cetak_kwitansi_list($filter,$start,$end){
			$query = "SELECT kwitansi_id
					,kwitansi_no
					,kwitansi_cust
					,cust_nama
					,kwitansi_tanggal
					,cust_id
					,cust_no
					,kwitansi_cara
					,kwitansi_nilai
					,kwitansi_bayar
					,kwitansi_keterangan
					,kwitansi_status
					,kwitansi_creator
					,date_format(kwitansi_date_create,'%Y-%m-%d') AS kwitansi_date_create
					,kwitansi_update
					,kwitansi_date_update
					,kwitansi_revised
					,kwitansi_sisa AS total_sisa
					/*,(kwitansi_nilai-IF(sum(jkwitansi_nilai)!='null',sum(jkwitansi_nilai),0)) AS total_sisa*/
				FROM cetak_kwitansi
				/*LEFT JOIN jual_kwitansi ON(jkwitansi_master=kwitansi_id)*/
				LEFT JOIN customer ON(kwitansi_cust=cust_id)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kwitansi_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR kwitansi_keterangan LIKE '%".addslashes($filter)."%' OR kwitansi_ref LIKE '%".addslashes($filter)."%' )";
			}
			$query .= " GROUP BY kwitansi_id ORDER BY kwitansi_id DESC";
			
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
		function cetak_kwitansi_update($kwitansi_id
									   ,$kwitansi_no
									   ,$kwitansi_cust
									   ,$kwitansi_tanggal
									   ,$kwitansi_ref
									   ,$kwitansi_nilai
									   ,$kwitansi_keterangan
									   ,$kwitansi_status
									   ,$kwitansi_cara
									   ,$kwitansi_bayar
									   ,$kwitansi_tunai_nilai
									   ,$kwitansi_card_nama
									   ,$kwitansi_card_edc
									   ,$kwitansi_card_no
									   ,$kwitansi_card_nilai
									   ,$kwitansi_cek_nama
									   ,$kwitansi_cek_no
									   ,$kwitansi_cek_valid
									   ,$kwitansi_cek_bank
									   ,$kwitansi_cek_nilai
									   ,$kwitansi_transfer_bank
									   ,$kwitansi_transfer_nama
									   ,$kwitansi_transfer_nilai
									   ,$kwitansi_update
									   ,$cetak ){
			$datetime_now = date('Y-m-d H:i:s');
			$time_now = date('H:i:s');
			$datetime_create = $kwitansi_tanggal.' '.$time_now;
			$kwitansi_date_create = date('Y-m-d H:i:s', strtotime($datetime_create));
			$kwitansi_date_update = $kwitansi_date_create;
			
			$sql = "SELECT kwitansi_cara FROM cetak_kwitansi WHERE kwitansi_id='".$kwitansi_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$kwitansi_cara_awal = $record['kwitansi_cara'];
				
				if($cetak==1){
					$sqlu = "UPDATE cetak_kwitansi
						SET kwitansi_cara='".$kwitansi_cara."'
							,kwitansi_nilai='".$kwitansi_nilai."'
							,kwitansi_sisa='".$kwitansi_nilai."'
							,kwitansi_bayar='".$kwitansi_bayar."'
							,kwitansi_status='Tertutup'
							,kwitansi_keterangan='".$kwitansi_keterangan."'
							,kwitansi_update='".$kwitansi_update."'
							,kwitansi_date_update='".$kwitansi_date_update."'
							,kwitansi_revised=(kwitansi_revised+1)
						WHERE kwitansi_id='".$kwitansi_id."'";
					$this->db->query($sqlu);
				}else{
					$sqlu = "UPDATE cetak_kwitansi
						SET kwitansi_cara='".$kwitansi_cara."'
							,kwitansi_nilai='".$kwitansi_nilai."'
							,kwitansi_sisa='".$kwitansi_nilai."'
							,kwitansi_bayar='".$kwitansi_bayar."'
							,kwitansi_keterangan='".$kwitansi_keterangan."'
							,kwitansi_update='".$kwitansi_update."'
							,kwitansi_date_update='".$kwitansi_date_update."'
							,kwitansi_revised=(kwitansi_revised+1)
						WHERE kwitansi_id='".$kwitansi_id."'";
					$this->db->query($sqlu);
				}
				if($this->db->affected_rows()>-1){
					//Delete ALL cara bayar ==> kemudian di-INSERT-kan sesuai dengan update
					/*if($kwitansi_cara_awal=='tunai'){
						$sql="delete from jual_tunai where jtunai_ref='".$kwitansi_no."'";
						$this->db->query($sql);
					}else if($kwitansi_cara_awal=='card'){
						$sql="delete from jual_card where jcard_ref='".$kwitansi_no."'";
						$this->db->query($sql);
					}else if($kwitansi_cara_awal=='cek/giro'){
						$sql="delete from jual_cek where jcek_ref='".$kwitansi_no."'";
						$this->db->query($sql);
					}else if($kwitansi_cara_awal=='transfer'){
						$sql="delete from jual_transfer where jtransfer_ref='".$kwitansi_no."'";
						$this->db->query($sql);
					}*/
					
					$sql="delete from jual_tunai where jtunai_ref='".$kwitansi_no."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_card where jcard_ref='".$kwitansi_no."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_cek where jcek_ref='".$kwitansi_no."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								$sql="delete from jual_transfer where jtransfer_ref='".$kwitansi_no."'";
								$this->db->query($sql);
								if($this->db->affected_rows()>-1){
									if($kwitansi_tunai_nilai<>'' && $kwitansi_tunai_nilai<>0){
										$result_bayar = $this->cara_bayar_tunai_insert($kwitansi_tunai_nilai
																					   ,$kwitansi_no
																					   ,$kwitansi_date_create
																					   ,$cetak);
										if($result_bayar==1){
											if($cetak==1){
												/*
												 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
												*/
												return $kwitansi_id;
											}else{
												//proses simpan saja tanpa cetak
												return '1';
											}
										}elseif($result_bayar==0){
											return '0';
										}
									}elseif($kwitansi_transfer_nilai<>'' && $kwitansi_transfer_nilai<>0){
										$result_bayar = $this->cara_bayar_transfer_insert($kwitansi_transfer_bank
																						  ,$kwitansi_transfer_nama
																						  ,$kwitansi_transfer_nilai
																						  ,$kwitansi_no
																						  ,$kwitansi_date_create
																						  ,$cetak);
										if($result_bayar==1){
											if($cetak==1){
												/*
												 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
												*/
												return $kwitansi_id;
											}else{
												//proses simpan saja tanpa cetak
												return '1';
											}
										}elseif($result_bayar==0){
											return '0';
										}
									}elseif($kwitansi_card_nilai<>'' && $kwitansi_card_nilai<>0){
										$result_bayar = $this->cara_bayar_card_insert($kwitansi_card_nama
																					  ,$kwitansi_card_edc
																					  ,$kwitansi_card_no
																					  ,$kwitansi_card_nilai
																					  ,$kwitansi_no
																					  ,$kwitansi_date_create
																					  ,$cetak);
										if($result_bayar==1){
											if($cetak==1){
												/*
												 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
												*/
												return $kwitansi_id;
											}else{
												//proses simpan saja tanpa cetak
												return '1';
											}
										}elseif($result_bayar==0){
											return '0';
										}
									}elseif($kwitansi_cek_nilai<>'' && $kwitansi_cek_nilai<>0){
										$result_bayar = $this->cara_bayar_cek_insert($kwitansi_cek_nama
																					 ,$kwitansi_cek_no
																					 ,$kwitansi_cek_valid
																					 ,$kwitansi_cek_bank
																					 ,$kwitansi_cek_nilai
																					 ,$kwitansi_no
																					 ,$kwitansi_date_create
																					 ,$cetak);
										if($result_bayar==1){
											if($cetak==1){
												/*
												 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
												*/
												return $kwitansi_id;
											}else{
												//proses simpan saja tanpa cetak
												return '1';
											}
										}elseif($result_bayar==0){
											return '0';
										}
									}
									
								}
							}
						}
					}
				}else{
					return '0';
				}
				
			}else{
				return '0';
			}
		}
		
		function cetak_kwitansi_batal($kwitansi_id ,$kwitansi_status ,$kwitansi_update ){
			$datetime_now = date('Y-m-d H:i:s');
			
			$sql_cek = "SELECT vu_catatan_kwitansi.jkwitansi_id
					,vu_catatan_kwitansi.jkwitansi_master
					,vu_catatan_kwitansi.jkwitansi_ref
					,vu_catatan_kwitansi.jkwitansi_nilai
					,vu_catatan_kwitansi.customer_id
					,customer.cust_nama AS customer_nama
					,customer.cust_no AS customer_no
				FROM (select
						jkwitansi_id
						,jkwitansi_master
						,jkwitansi_ref
						,jkwitansi_nilai
						,if(jproduk_cust!='null',jproduk_cust,if(jrawat_cust!='null',jrawat_cust,jpaket_cust)) AS customer_id
					FROM jual_kwitansi
					LEFT JOIN master_jual_produk on(jkwitansi_ref=jproduk_nobukti)
					LEFT JOIN master_jual_rawat on(jkwitansi_ref=jrawat_nobukti)
					LEFT JOIN master_jual_paket ON(jkwitansi_ref=jpaket_nobukti)
					WHERE jkwitansi_stat_dok<>'Batal') as vu_catatan_kwitansi
				LEFT JOIN customer ON(vu_catatan_kwitansi.customer_id=customer.cust_id)
				WHERE jkwitansi_master='$kwitansi_id'";
			$rs_cek = $this->db->query($sql_cek);
			if($rs_cek->num_rows()){
			
				return '10';
			}
			else
			{
			$sql = "SELECT kwitansi_no, kwitansi_cara FROM cetak_kwitansi WHERE kwitansi_id='".$kwitansi_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$kwitansi_cara = $record['kwitansi_cara'];
				$kwitansi_no = $record['kwitansi_no'];
				
				$sqlu = "UPDATE cetak_kwitansi
					SET kwitansi_status='Batal'
						,kwitansi_update='".$kwitansi_update."'
						,kwitansi_date_update='".$datetime_now."'
						,kwitansi_revised=(kwitansi_revised+1)
					WHERE kwitansi_id='".$kwitansi_id."'";
				$this->db->query($sqlu);
				if($this->db->affected_rows()){
					if($kwitansi_cara=='card'){
						$sqlu = "UPDATE jual_card
							SET jcard_stat_dok='Batal'
								,jcard_update='".$kwitansi_update."'
								,jcard_date_update='".$datetime_now."'
								,jcard_revised=(jcard_revised+1)
							WHERE jcard_ref='".$kwitansi_no."'";
						$this->db->query($sqlu);
						if($this->db->affected_rows()){
							return '0';
						}
					}else if($kwitansi_cara=='cek/giro'){
						$sqlu = "UPDATE jual_cek
							SET jcek_stat_dok='Batal'
								,jcek_update='".$kwitansi_update."'
								,jcek_date_update='".$datetime_now."'
								,jcek_revised=(jcek_revised+1)
							WHERE jcek_ref='".$kwitansi_no."'";
						$this->db->query($sqlu);
						if($this->db->affected_rows()){
							return '0';
						}
					}else if($kwitansi_cara=='transfer'){
						$sqlu = "UPDATE jual_transfer
							SET jtransfer_stat_dok='Batal'
								,jtransfer_update='".$kwitansi_update."'
								,jtransfer_date_update='".$datetime_now."'
								,jtransfer_revised=(jtransfer_revised+1)
							WHERE jtransfer_ref='".$kwitansi_no."'";
						$this->db->query($sqlu);
						if($this->db->affected_rows()){
							return '0';
						}
					}else if($kwitansi_cara=='tunai'){
						$sqlu = "UPDATE jual_tunai
							SET jtunai_stat_dok='Batal'
								,jtunai_update='".$kwitansi_update."'
								,jtunai_date_update='".$datetime_now."'
								,jtunai_revised=(jtunai_revised+1)
							WHERE jtunai_ref='".$kwitansi_no."'";
						$this->db->query($sqlu);
						if($this->db->affected_rows()){
							return '0';
						}
					}
				}
			}
		
		
		}
			
		}
		
		function cara_bayar_tunai_insert($kwitansi_tunai_nilai
										,$kwitansi_no
										,$kwitansi_date_create
										,$cetak){
			$stat_dok = 'Terbuka';
			if($cetak==1){
				$stat_dok = 'Tertutup';
			}
			$data=array(
				"jtunai_nilai"=>$kwitansi_tunai_nilai,
				"jtunai_ref"=>$kwitansi_no,
				"jtunai_transaksi"=>"jual_kwitansi",
				"jtunai_date_create"=>$kwitansi_date_create,
				"jtunai_stat_dok"=>$stat_dok
				);
			$this->db->insert('jual_tunai', $data);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return 0;
			}
		}
		
		function cara_bayar_transfer_insert($kwitansi_transfer_bank
											,$kwitansi_transfer_nama
											,$kwitansi_transfer_nilai
											,$kwitansi_no
											,$kwitansi_date_create
											,$cetak){
			$stat_dok = 'Terbuka';
			if($cetak==1){
				$stat_dok = 'Tertutup';
			}
			$data=array(
				"jtransfer_bank"=>$kwitansi_transfer_bank,
				"jtransfer_nama"=>$kwitansi_transfer_nama,
				"jtransfer_nilai"=>$kwitansi_transfer_nilai,
				"jtransfer_ref"=>$kwitansi_no,
				"jtransfer_transaksi"=>"jual_kwitansi",
				"jtransfer_date_create"=>$kwitansi_date_create,
				"jtransfer_stat_dok"=>$stat_dok
				);
			$this->db->insert('jual_transfer', $data);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return 0;
			}
		}
		
		function cara_bayar_card_insert($kwitansi_card_nama
										,$kwitansi_card_edc
										,$kwitansi_card_no
										,$kwitansi_card_nilai
										,$kwitansi_no
										,$kwitansi_date_create
										,$cetak){
			$stat_dok = 'Terbuka';
			if($cetak==1){
				$stat_dok = 'Tertutup';
			}
			$data=array(
				"jcard_nama"=>$kwitansi_card_nama,
				"jcard_edc"=>$kwitansi_card_edc,
				"jcard_no"=>$kwitansi_card_no,
				"jcard_nilai"=>$kwitansi_card_nilai,
				"jcard_ref"=>$kwitansi_no,
				"jcard_transaksi"=>"jual_kwitansi",
				"jcard_date_create"=>$kwitansi_date_create,
				"jcard_stat_dok"=>$stat_dok
				);
			$this->db->insert('jual_card', $data);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return 0;
			}
		}
		
		function cara_bayar_cek_insert($kwitansi_cek_nama
										,$kwitansi_cek_no
										,$kwitansi_cek_valid
										,$kwitansi_cek_bank
										,$kwitansi_cek_nilai
										,$kwitansi_no
										,$kwitansi_date_create
										,$cetak){
			$stat_dok = 'Terbuka';
			if($cetak==1){
				$stat_dok = 'Tertutup';
			}
			if($kwitansi_cek_nama=="" || $kwitansi_cek_nama==NULL){
				if(is_int($kwitansi_cek_nama)){
					$sql="select cust_nama from customer where cust_id='".$kwitansi_cust."'";
					$query=$this->db->query($sql);
					if($query->num_rows()){
						$data=$query->row();
						$kwitansi_cek_nama=$data->cust_nama;
					}
				}else{
					$kwitansi_cek_nama=$kwitansi_cust;
				}
			}
			$data=array(
				"jcek_nama"=>$kwitansi_cek_nama,
				"jcek_no"=>$kwitansi_cek_no,
				"jcek_valid"=>$kwitansi_cek_valid,
				"jcek_bank"=>$kwitansi_cek_bank,
				"jcek_nilai"=>$kwitansi_cek_nilai,
				"jcek_ref"=>$kwitansi_no,
				"jcek_transaksi"=>"jual_kwitansi",
				"jcek_date_create"=>$kwitansi_date_create,
				"jcek_stat_dok"=>$stat_dok
				);
			$this->db->insert('jual_cek', $data);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return 0;
			}
		}
		
		//function for create new record
		function cetak_kwitansi_create($kwitansi_no
									   ,$kwitansi_cust
									   ,$kwitansi_tanggal
									   ,$kwitansi_ref
									   ,$kwitansi_nilai
									   ,$kwitansi_keterangan
									   ,$kwitansi_status
									   ,$kwitansi_cara
									   ,$kwitansi_bayar
									   ,$kwitansi_tunai_nilai
									   ,$kwitansi_card_nama
									   ,$kwitansi_card_edc
									   ,$kwitansi_card_no
									   ,$kwitansi_card_nilai
									   ,$kwitansi_cek_nama
									   ,$kwitansi_cek_no
									   ,$kwitansi_cek_valid
									   ,$kwitansi_cek_bank
									   ,$kwitansi_cek_nilai
									   ,$kwitansi_transfer_bank
									   ,$kwitansi_transfer_nama
									   ,$kwitansi_transfer_nilai
									   ,$kwitansi_creator
									   ,$cetak ){
			$datetime_now = date('Y-m-d H:i:s');
			$time_now = date('H:i:s');
			$datetime_create = $kwitansi_tanggal.' '.$time_now;
			$kwitansi_date_create = date('Y-m-d H:i:s', strtotime($datetime_create));
			if($kwitansi_status=="")
				$kwitansi_status="Terbuka";
			
			//$pattern="KW/".date('ym')."-";
			$kwitansi_tanggal_pattern=strtotime($kwitansi_tanggal);
			$pattern="KU/".date("ym",$kwitansi_tanggal_pattern)."-";			
			
			//$pattern="KU/".date('ym')."-";
			$kwitansi_no=$this->m_public_function->get_kode_1("cetak_kwitansi","kwitansi_no",$pattern,12);
			$data = array(
				"kwitansi_no"=>$kwitansi_no, 
				"kwitansi_cust"=>$kwitansi_cust,
				"kwitansi_tanggal"=>$kwitansi_tanggal,
				"kwitansi_ref"=>$kwitansi_ref, 
				"kwitansi_nilai"=>$kwitansi_nilai,
				"kwitansi_sisa"=>$kwitansi_nilai,
				"kwitansi_bayar"=>$kwitansi_bayar,
				"kwitansi_keterangan"=>$kwitansi_keterangan, 
				//"kwitansi_status"=>$kwitansi_status,
				"kwitansi_cara"=>$kwitansi_cara,
				"kwitansi_creator"=>$kwitansi_creator,
				"kwitansi_date_create"=>$datetime_now
			);
			if($cetak==1)
				$data['kwitansi_status'] = 'Tertutup';
			$this->db->insert('cetak_kwitansi', $data); 
			if($this->db->affected_rows()){
				//$id_cetak = $this->db->insert_id();
				//Ambil kwitansi_id yang telah ter-create
				$sql = "SELECT max(kwitansi_id) AS kwitansi_id FROM cetak_kwitansi WHERE kwitansi_creator='".$kwitansi_creator."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()){
					$record = $rs->row_array();
					$kwitansi_id = $record['kwitansi_id'];
				}
				
				$sql="delete from jual_tunai where jtunai_ref='".$kwitansi_no."'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_card where jcard_ref='".$kwitansi_no."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_cek where jcek_ref='".$kwitansi_no."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_transfer where jtransfer_ref='".$kwitansi_no."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								if($kwitansi_tunai_nilai<>'' && $kwitansi_tunai_nilai<>0){
									$result_bayar = $this->cara_bayar_tunai_insert($kwitansi_tunai_nilai
																				   ,$kwitansi_no
																				   ,$kwitansi_date_create
																				   ,$cetak);
									if($result_bayar==1){
										if($cetak==1){
											/*
											 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
											*/
											return $kwitansi_id;
										}else{
											//proses simpan saja tanpa cetak
											return '1';
										}
									}elseif($result_bayar==0){
										return '0';
									}
								}elseif($kwitansi_transfer_nilai<>'' && $kwitansi_transfer_nilai<>0){
									$result_bayar = $this->cara_bayar_transfer_insert($kwitansi_transfer_bank
																					  ,$kwitansi_transfer_nama
																					  ,$kwitansi_transfer_nilai
																					  ,$kwitansi_no
																					  ,$kwitansi_date_create
																					  ,$cetak);
									if($result_bayar==1){
										if($cetak==1){
											/*
											 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
											*/
											return $kwitansi_id;
										}else{
											//proses simpan saja tanpa cetak
											return '1';
										}
									}elseif($result_bayar==0){
										return '0';
									}
								}elseif($kwitansi_card_nilai<>'' && $kwitansi_card_nilai<>0){
									$result_bayar = $this->cara_bayar_card_insert($kwitansi_card_nama
																				  ,$kwitansi_card_edc
																				  ,$kwitansi_card_no
																				  ,$kwitansi_card_nilai
																				  ,$kwitansi_no
																				  ,$kwitansi_date_create
																				  ,$cetak);
									if($result_bayar==1){
										if($cetak==1){
											/*
											 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
											*/
											return $kwitansi_id;
										}else{
											//proses simpan saja tanpa cetak
											return '1';
										}
									}elseif($result_bayar==0){
										return '0';
									}
								}elseif($kwitansi_cek_nilai<>'' && $kwitansi_cek_nilai<>0){
									$result_bayar = $this->cara_bayar_cek_insert($kwitansi_cek_nama
																				 ,$kwitansi_cek_no
																				 ,$kwitansi_cek_valid
																				 ,$kwitansi_cek_bank
																				 ,$kwitansi_cek_nilai
																				 ,$kwitansi_no
																				 ,$kwitansi_date_create
																				 ,$cetak);
									if($result_bayar==1){
										if($cetak==1){
											/*
											 * return db.cetak_kwitansi.kwitansi_id untuk proses cetak
											*/
											return $kwitansi_id;
										}else{
											//proses simpan saja tanpa cetak
											return '1';
										}
									}elseif($result_bayar==0){
										return '0';
									}
								}
								
							}
						}
					}
				}
				
			}else
				return '0';
		}
		
		//fcuntion for delete record
		function cetak_kwitansi_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the cetak_kwitansis at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM cetak_kwitansi WHERE kwitansi_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM cetak_kwitansi WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "kwitansi_id= ".$pkid[$i];
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
		function cetak_kwitansi_search($kwitansi_no ,$kwitansi_cust , $kwitansi_tanggal_start, $kwitansi_tanggal_end,$kwitansi_keterangan ,$kwitansi_status ,$start,$end){
			//full query
			//$query="select * from cetak_kwitansi";
			$query = "SELECT kwitansi_id
					,kwitansi_no
					,kwitansi_cust
					,cust_nama
					,kwitansi_tanggal
					,cust_id
					,cust_no
					,kwitansi_cara
					,kwitansi_nilai
					,kwitansi_bayar
					,kwitansi_keterangan
					,kwitansi_status
					,kwitansi_creator
					,date_format(kwitansi_date_create,'%Y-%m-%d') AS kwitansi_date_create
					,kwitansi_update
					,kwitansi_date_update
					,kwitansi_revised
					,kwitansi_sisa AS total_sisa
					/*,(kwitansi_nilai-IF(sum(jkwitansi_nilai)!='null',sum(jkwitansi_nilai),0)) AS total_sisa*/
				FROM cetak_kwitansi
				LEFT JOIN jual_kwitansi ON(jkwitansi_master=kwitansi_id)
				LEFT JOIN customer ON(kwitansi_cust=cust_id)";
			
			if($kwitansi_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_no LIKE '%".$kwitansi_no."%'";
			};
			if($kwitansi_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_cust = '".$kwitansi_cust."'";
			};
			if($kwitansi_tanggal_start!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_tanggal>= '".$kwitansi_tanggal_start."'";
			};
			if($kwitansi_tanggal_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_tanggal<= '".$kwitansi_tanggal_end."'";
			};
			if($kwitansi_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_keterangan LIKE '%".$kwitansi_keterangan."%'";
			};
			if($kwitansi_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kwitansi_status = '".$kwitansi_status."'";
			};
			$query .= " GROUP BY kwitansi_id ORDER BY kwitansi_id DESC";
			
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
		function cetak_kwitansi_print($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
			//full query
			if($option=='LIST'){
				$query = "SELECT kwitansi_tanggal
						,kwitansi_no
						,cust_no
						,cust_nama
						,kwitansi_nilai
						,kwitansi_sisa
						,replace(kwitansi_keterangan,'\n',' ') AS keterangan
						,kwitansi_status
					FROM cetak_kwitansi
					LEFT JOIN customer ON(kwitansi_cust=cust_id)";
					
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kwitansi_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR kwitansi_keterangan LIKE '%".addslashes($filter)."%' OR kwitansi_ref LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				$query = "SELECT kwitansi_tanggal AS tanggal
						,kwitansi_no AS no_kuitansi
						,cust_no AS no_cust
						,cust_nama AS customer
						,kwitansi_nilai AS 'Nilai (Rp)'
						,kwitansi_sisa AS 'Sisa (Rp)'
						,kwitansi_keterangan AS keterangan
						,kwitansi_status AS status
					FROM cetak_kwitansi
					LEFT JOIN jual_kwitansi ON(jkwitansi_master=kwitansi_id)
					LEFT JOIN customer ON(kwitansi_cust=cust_id)";
					
				if($kwitansi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_no LIKE '%".$kwitansi_no."%'";
				};
				if($kwitansi_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_cust = '".$kwitansi_cust."'";
				};
				if($kwitansi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_keterangan LIKE '%".$kwitansi_keterangan."%'";
				};
				if($kwitansi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_status = '".$kwitansi_status."'";
				};
				$result = $this->db->query($query);
			}
			return $result->result();
		}
		
		//function  for export to excel
		function cetak_kwitansi_export_excel($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
			//full query
			
			if($option=='LIST'){
				$query = "SELECT kwitansi_tanggal AS tanggal
						,kwitansi_no AS no_kuitansi
						,cust_no AS no_cust
						,cust_nama AS customer
						,kwitansi_nilai AS 'Nilai (Rp)'
						,kwitansi_sisa AS 'Sisa (Rp)'
						,replace(kwitansi_keterangan,'\n',' ') AS keterangan
						,kwitansi_status AS status
					FROM cetak_kwitansi
					LEFT JOIN customer ON(kwitansi_cust=cust_id)";
					
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (kwitansi_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR kwitansi_keterangan LIKE '%".addslashes($filter)."%' OR kwitansi_ref LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				$query = "SELECT kwitansi_tanggal AS tanggal
						,kwitansi_no AS no_kuitansi
						,cust_no AS no_cust
						,cust_nama AS customer
						,kwitansi_nilai AS 'Nilai (Rp)'
						,kwitansi_sisa AS 'Sisa (Rp)'
						,kwitansi_keterangan AS keterangan
						,kwitansi_status AS status
					FROM cetak_kwitansi
					LEFT JOIN jual_kwitansi ON(jkwitansi_master=kwitansi_id)
					LEFT JOIN customer ON(kwitansi_cust=cust_id)";
					
				if($kwitansi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_no LIKE '%".$kwitansi_no."%'";
				};
				if($kwitansi_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_cust = '".$kwitansi_cust."'";
				};
				if($kwitansi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_keterangan LIKE '%".$kwitansi_keterangan."%'";
				};
				if($kwitansi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kwitansi_status = '".$kwitansi_status."'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		function print_paper($kwitansi_id){
			
			$sql="SELECT kwitansi_id,kwitansi_no,kwitansi_tanggal,cust_no,cust_nama,kwitansi_nilai,kwitansi_keterangan,kwitansi_cara FROM cetak_kwitansi,customer WHERE kwitansi_cust=cust_id AND kwitansi_id='".$kwitansi_id."'";
			$result = $this->db->query($sql);
			return $result;
		}
		
		function cara_bayar($kwitansi_id){
			$sql="SELECT kwitansi_id,kwitansi_no,kwitansi_date_create,cust_no,cust_nama,kwitansi_nilai,kwitansi_keterangan FROM cetak_kwitansi,customer WHERE kwitansi_cust=cust_id AND kwitansi_id='".$kwitansi_id."'";
			$result = $this->db->query($sql);
			return $result;
		}
		
}
?>