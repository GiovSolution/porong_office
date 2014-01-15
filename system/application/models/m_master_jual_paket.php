<? /* 	
	Miracle IT Team
*/

class M_master_jual_paket extends Model{
		
		//constructor
		function M_master_jual_paket() {
			parent::Model();
		}
		
	
	function get_info_pajak(){
		$sql="SELECT cabang_pajak FROM cabang where cabang_id = (select info_cabang from info) and cabang_pajak = '1'";
		
		$result = $this->db->query($sql);		
		$nbrows = $result->num_rows();
		return $nbrows;
	}
	
	
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group){
			$order_by="";
			switch($group){
				case "Tanggal": $order_by=" ORDER BY tanggal ASC";break;
				case "Customer": $order_by=" ORDER BY cust_id ASC";break;
				case "No Faktur": $order_by=" ORDER BY no_bukti ASC";break;
				case "Paket": $order_by=" ORDER BY produk_id ASC";break;
				case "Sales": $order_by=" ORDER BY sales ASC";break;
				case "Jenis Diskon": $order_by=" ORDER BY diskon_jenis ASC";break;
				default: $order_by=" ORDER BY no_bukti ASC";break;
			}
			
			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT distinct * FROM vu_trans_paket WHERE jpaket_stat_dok='Tertutup' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT distinct * FROM vu_trans_paket WHERE jpaket_stat_dok='Tertutup' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT distinct * FROM vu_trans_paket WHERE jpaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='detail'){
				if($opsi_status=='semua') {
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}  else if($opsi_status=='tertutup') {
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}
			
			//echo $sql;
			
			$query=$this->db->query($sql);
			return $query->result();
		}
		
		function get_reveral_list($query,$start,$end){
			$sql="SELECT karyawan_id,karyawan_no,karyawan_username,karyawan_nama,karyawan_tgllahir,karyawan_alamat
			FROM karyawan where karyawan_aktif='Aktif'";
			if($query<>""){
				$sql=$sql." and (karyawan_no like '%".$query."%' or karyawan_nama like '%".$query."%') ";
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
		
				
		function get_customer_list($query,$start,$end){
			/*$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_cust="SELECT distinct(sjpaket_cust) FROM submaster_jual_paket WHERE sjpaket_master='$query'";
				$rs=$this->db->query($sql_cust);
				$rs_rows=$rs->num_rows();
			}*/
			
			$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah FROM customer where cust_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (cust_nama like '%".$query."%' ) ";
			}/*else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$query)? " OR ":" AND ";
					foreach($rs->result() as $row_cust){
						
						$filter.="OR cust_id='".$row_cust->sjpaket_cust."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}*/
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
			}
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
		
		function get_customer_pengguna_list($jpaket_id,$query,$start,$end){
			$rs_rows=0;
			if(is_numeric($jpaket_id)==true){
				$sql_cust="SELECT distinct(ppaket_cust) FROM pengguna_paket WHERE ppaket_master='$jpaket_id'";
				$rs=$this->db->query($sql_cust);
				$rs_rows=$rs->num_rows();
			}
			
			$sql="SELECT cust_id
					,cust_no
					,cust_nama
					,cust_tgllahir
					,cust_alamat
					,cust_telprumah
					,CONCAT(vu_customer.cust_nama, ' (', vu_customer.cust_no, ')') as cust_display
				FROM vu_customer
				WHERE cust_aktif='Aktif'";
			if($query<>""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (cust_nama LIKE '%".$query."%' OR cust_no LIKE '%".$query."%') ";
			}else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$jpaket_id)? " OR ":" AND ";
					foreach($rs->result() as $row_cust){
						
						$filter.="OR cust_id='".$row_cust->ppaket_cust."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
			}
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
		
		function detail_pengguna_paket_list($master_id,$start,$end){
			$query="SELECT ppaket_id ,ppaket_master ,ppaket_cust
				FROM pengguna_paket
					INNER JOIN master_jual_paket ON(ppaket_master=jpaket_id)
				WHERE ppaket_master='".$master_id."' AND ppaket_cust!=jpaket_cust";
			
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
		
		function detail_pengguna_paket_insert($array_ppaket_id, $ppaket_master, $array_ppaket_cust){
			$datetime_now = date('Y-m-d H:i:s');
			//if master id not capture from view then capture it from max pk from master table
			if($ppaket_master=="" || $ppaket_master==NULL || $ppaket_master==0){
				$ppaket_master=$this->get_master_id();
			}
			
			$size_array = sizeof($array_ppaket_id) - 1;
			
			for($i = 0; $i < sizeof($array_ppaket_id); $i++){
				$ppaket_id = $array_ppaket_id[$i];
				$ppaket_cust = $array_ppaket_cust[$i];
				
				/*
				 * JIKA $ppaket_id==0 <== berarti penambahan pemakai baru
				 * JIKA $ppaket_id<>0 <== berarti sudah ada sebagai pengguna paket, sehingga masuk mode EDIT
				 * ==> di mode EDIT, ada pengecheckan apakah Customer itu sudah pernah mengambil paket untuk Faktur yang dimaksud atau belum???
				 * ==> Jika Customer itu sudah pernah ambil paket, maka tidak boleh di-EDIT
				 * ==> Jika Customer itu belum pernah ambil paket, maka boleh di-GANTI itu Customer
				*/
				
				$sql = "SELECT dapaket_id FROM detail_ambil_paket WHERE dapaket_jpaket='".$ppaket_master."' AND dapaket_cust='".$ppaket_cust."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()){
					if($i==$size_array){
						return '1';
					}
				}else{
					if($ppaket_id==0){
						//penambahan pemakai baru
						$dti_ppaket = array(
						"ppaket_master"=>$ppaket_master, 
						"ppaket_cust"=>$ppaket_cust
						);
						$sql="SELECT ppaket_id FROM pengguna_paket WHERE ppaket_master='$ppaket_master' AND ppaket_cust='$ppaket_cust'";
						$rs=$this->db->query($sql);
						if(!$rs->num_rows()){
							//* Customer ini belum masuk ke dalam Daftar Pemakai Paket dari Faktur ppaket_master /
							$this->db->insert('pengguna_paket', $dti_ppaket); 
						}
						if($i==$size_array){
							return '1';
						}
					}else{
						//mode EDIT pemakai paket
						$dtu_ppaket = array(
						"ppaket_cust"=>$ppaket_cust
						);
						$this->db->where('ppaket_id' ,$ppaket_id);
						$this->db->update('pengguna_paket' ,$dtu_ppaket);
						if($i==$size_array){
							return '1';
						}
					}
				}
			}
			
		}
		
		function get_paket_list($query,$start,$end,$aktif){
			$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_paket="SELECT distinct(dpaket_paket) FROM detail_jual_paket WHERE dpaket_master='$query'";
				$rs=$this->db->query($sql_paket);
				$rs_rows=$rs->num_rows();
			}
			
			if($aktif=='yes'){
				$sql=  "SELECT 
						paket_id, paket_harga, paket_kode, paket_edit_harga,
						paket_du, paket_dm, paket_dultah, paket_dcard, paket_dkolega, paket_dkeluarga, paket_downer, paket_dgrooming, paket_dwartawan, paket_dstaffdokter, paket_dstaffnondokter,paket_dpromo,
						paket_nama, paket_expired, kategori_nama
					FROM paket
					LEFT JOIN kategori on (kategori_id = paket_kategori)
					WHERE paket_aktif='Aktif'";
			}else{
				$sql=  "SELECT 
						paket_id, paket_harga, paket_kode, paket_edit_harga,
						paket_du, paket_dm, paket_dultah, paket_dcard, paket_dkolega, paket_dkeluarga, paket_downer, paket_dgrooming, paket_dwartawan, paket_dstaffdokter, paket_dstaffnondokter,paket_dpromo,
						paket_nama, paket_expired 
					FROM paket";
			}
			
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (paket_kode LIKE '%".addslashes($query)."%' OR paket_nama LIKE '%".addslashes($query)."%' ) ";
			}else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("WHERE",$query)? " AND ":" WHERE ";
					foreach($rs->result() as $row_paket){
						
						$filter.="OR paket_id='".$row_paket->dpaket_paket."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
			}
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
		function detail_detail_jual_paket_list($master_id,$query,$start,$end) {
			$query = "SELECT detail_jual_paket.*,master_jual_paket.jpaket_bayar,master_jual_paket.jpaket_diskon,dpaket_harga*dpaket_jumlah as dpaket_subtotal,dpaket_harga*dpaket_jumlah*((100-dpaket_diskon)/100) as dpaket_subtotal_net, kategori.kategori_nama as kategori_nama FROM detail_jual_paket 
			LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
			LEFT JOIN paket on (dpaket_paket = paket_id)
			LEFT JOIN kategori on (paket_kategori = kategori_id) WHERE dpaket_master='".$master_id."'";
			
			//$query = "SELECT *,dpaket_harga*dpaket_jumlah as dpaket_subtotal, dpaket_harga*dpaket_jumlah*(100-dpaket_diskon)/100 as dpaket_subtotal_net FROM detail_jual_paket where dpaket_master='".$master_id."'";
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
		
		function get_voucher_list($query,$start,$end){
			$sql = "SELECT * FROM voucher,voucher_kupon where kvoucher_master=voucher_id";
			if ($query<>""){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (kvoucher_nomor LIKE '%".addslashes($query)."%')";
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
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(jpaket_id) as master_id FROM master_jual_paket WHERE jpaket_creator='".$_SESSION[SESSION_USERID]."'";
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
		
		function get_point_per_rupiah(){
			$query = "SELECT setmember_point_perrp FROM member_setup LIMIT 1";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$setmember_point_perrp=$data->setmember_point_perrp;
				return $setmember_point_perrp;
			}else{
				return 0;
			}
		}
		
		function catatan_piutang_update($jpaket_id){
			/*if($jpaket_id=="" || $jpaket_id==NULL || $jpaket_id==0){
				$jpaket_id=$this->get_master_id();
			}*/
			$sql="SELECT * FROM vu_piutang_jpaket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$lpiutang_faktur=$rs_record["jpaket_nobukti"];
				$lpiutang_cust=$rs_record["jpaket_cust"];
				$lpiutang_faktur_tanggal=$rs_record["jpaket_tanggal"];
				$lpiutang_total=$rs_record["piutang_total"];
				/* ini artinya: No.Faktur Penjualan Produk ini masih BELUM LUNAS */
				/* untuk itu, No.Faktur ini akan dimasukkan ke db.master_lunas_piutang sebagai daftar yang harus ditagihkan ke Customer */
				
				/* Checking terlebih dahulu ke db.master_lunas_piutang WHERE =$lpiutang_faktur:
				* JIKA 'ada' ==> Lakukan UPDATE db.master_lunas_piutang
				* JIKA 'tidak ada' ==> Lakukan INSERT db.master_lunas_piutang
				*/
				$sql="SELECT lpiutang_id FROM master_lunas_piutang WHERE lpiutang_faktur='$lpiutang_faktur'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					/* 1. DELETE db.master_lunas_piutang AND db.detail_jual_piutang
					 * 2. INSERT to db.master_lunas_piutang
					*/
					$sql = "DELETE detail_lunas_piutang, master_lunas_piutang
						FROM master_lunas_piutang
						LEFT JOIN detail_lunas_piutang ON(dpiutang_master=lpiutang_id)
						WHERE lpiutang_faktur='".$lpiutang_faktur."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						//INSERT to db.master_lunas_piutang
						$dti_lpiutang=array(
						"lpiutang_faktur"=>$lpiutang_faktur,
						"lpiutang_cust"=>$lpiutang_cust,
						"lpiutang_faktur_tanggal"=>$lpiutang_faktur_tanggal,
						"lpiutang_total"=>$lpiutang_total,
						"lpiutang_sisa"=>$lpiutang_total,
						"lpiutang_jenis_transaksi"=>'jual_paket',
						"lpiutang_stat_dok"=>'Terbuka'
						);
						$this->db->insert('master_lunas_piutang', $dti_lpiutang);
						if($this->db->affected_rows()){
							return 1;
						}
					}
				}else{
					/* INSERT db.master_lunas_piutang */
					$dti_lpiutang=array(
					"lpiutang_faktur"=>$lpiutang_faktur,
					"lpiutang_cust"=>$lpiutang_cust,
					"lpiutang_faktur_tanggal"=>$lpiutang_faktur_tanggal,
					"lpiutang_total"=>$lpiutang_total,
					"lpiutang_sisa"=>$lpiutang_total,
					"lpiutang_jenis_transaksi"=>'jual_paket',
					"lpiutang_stat_dok"=>'Terbuka'
					);
					$this->db->insert('master_lunas_piutang', $dti_lpiutang);
					if($this->db->affected_rows()){
						return 1;
					}
				}
			}else{
				return 1;
			}
		}
		
		function catatan_piutang_batal($jpaket_id){
			/* 1. Cari jpaket_nobukti
			 * 2. UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
			*/
			$datetime_now = date('Y-m-d H:i:s');
			
			$sql = "SELECT jpaket_nobukti FROM master_jual_paket WHERE jpaket_id='".$jpaket_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$jpaket_nobukti = $record['jpaket_nobukti'];
				
				//UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
				$sqlu = "UPDATE master_lunas_piutang
					SET lpiutang_stat_dok='Batal'
						,lpiutang_update='".@$_SESSION[SESSION_USERID]."'
						,lpiutang_date_update='".$datetime_now."'
						,lpiutang_revised=(lpiutang_revised+1)
					WHERE lpiutang_faktur='".$jpaket_nobukti."'";
				$this->db->query($sqlu);
				if($this->db->affected_rows()>-1){
					return 1;
				}else{
					return 1;
				}
			}else{
				return 1;
			}
			
		}
		
		function member_point_update($jpaket_id){
			$date_now=date('Y-m-d');
			
			$sqlu = "UPDATE master_jual_paket JOIN (SELECT vu_jpaket_total_point.jpaket_id, 
						vu_jpaket_total_point.jpaket_total_point
					FROM vu_jpaket_total_point
					WHERE vu_jpaket_total_point.jpaket_id = ".$jpaket_id."
					LIMIT 1) AS vu_jpaket_total_point_temp ON (vu_jpaket_total_point_temp.jpaket_id = master_jual_paket.jpaket_id)
			SET master_jual_paket.jpaket_point = vu_jpaket_total_point_temp.jpaket_total_point
			WHERE master_jual_paket.jpaket_id=".$jpaket_id;
			$this->db->query($sqlu);
			if($this->db->affected_rows()){
				$sqlu_cust = "UPDATE customer JOIN (SELECT vu_jpaket_total_point.jpaket_id, 
							vu_jpaket_total_point.jpaket_cust,
							vu_jpaket_total_point.jpaket_total_point
						FROM vu_jpaket_total_point
						WHERE vu_jpaket_total_point.jpaket_id = ".$jpaket_id."
						LIMIT 1) AS vu_jpaket_total_point_temp 
				SET customer.cust_point = (customer.cust_point + vu_jpaket_total_point_temp.jpaket_total_point)
				WHERE vu_jpaket_total_point_temp.jpaket_cust = customer.cust_id";
				$this->db->query($sqlu_cust);
				if($this->db->affected_rows()>-1){
					return 1;
				}
			}else{
				return 1;
			}
			
		}
		
		function member_point_batal($jpaket_id){
			$sqlu = "UPDATE customer, master_jual_paket
				SET customer.cust_point = (customer.cust_point - jpaket_point)
				WHERE master_jual_paket.jpaket_id='".$jpaket_id."'
					AND customer.cust_id=master_jual_paket.jpaket_cust";
			$this->db->query($sqlu);
			if($this->db->affected_rows()>-1){
				return 1;
			}
		}
		
		function cara_bayar_batal($jpaket_id){
			//updating db.jual_card ==> pembatalan
			$sqlu_jcard = "UPDATE jual_card JOIN master_jual_paket ON(jual_card.jcard_ref=master_jual_paket.jpaket_nobukti)
				SET jual_card.jcard_stat_dok = master_jual_paket.jpaket_stat_dok
				WHERE master_jual_paket.jpaket_id='$jpaket_id'";
			$this->db->query($sqlu_jcard);
			if($this->db->affected_rows()>-1){
				//updating db.jual_cek ==> pembatalan
				$sqlu_jcek = "UPDATE jual_cek JOIN master_jual_paket ON(jual_cek.jcek_ref=master_jual_paket.jpaket_nobukti)
					SET jual_cek.jcek_stat_dok = master_jual_paket.jpaket_stat_dok
					WHERE master_jual_paket.jpaket_id='$jpaket_id'";
				$this->db->query($sqlu_jcek);
				if($this->db->affected_rows()>-1){
					//updating db.jual_kwitansi ==> pembatalan
					$sqlu_jkwitansi = "UPDATE jual_kwitansi JOIN master_jual_paket ON(jual_kwitansi.jkwitansi_ref=master_jual_paket.jpaket_nobukti)
						SET jual_kwitansi.jkwitansi_stat_dok = master_jual_paket.jpaket_stat_dok
						WHERE master_jual_paket.jpaket_id='$jpaket_id'";
					$this->db->query($sqlu_jkwitansi);
					if($this->db->affected_rows()>-1){
						$sql = "SELECT jkwitansi_master
							FROM jual_kwitansi
							JOIN master_jual_paket ON(jkwitansi_ref=jpaket_nobukti)
							WHERE jpaket_id='".$jpaket_id."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()){
							foreach($rs->result() as $row){
								//updating sisa kwitansi
								$sqlu = "UPDATE cetak_kwitansi
											LEFT JOIN (SELECT sum(jkwitansi_nilai) AS total_kwitansi
												,jkwitansi_master 
											FROM jual_kwitansi
											WHERE jkwitansi_master<>0
												AND jkwitansi_stat_dok<>'Batal'
												AND jkwitansi_master='".$row->jkwitansi_master."'
											GROUP BY jkwitansi_master) AS vu_kw ON(vu_kw.jkwitansi_master=kwitansi_id)
										SET kwitansi_sisa=(kwitansi_nilai - ifnull(vu_kw.total_kwitansi,0))
										WHERE kwitansi_id='".$row->jkwitansi_master."'";
								$this->db->query($sqlu);
							}
						}
						
						//updating db.jual_transfer ==> pembatalan
						$sqlu_jtransfer = "UPDATE jual_transfer JOIN master_jual_paket ON(jual_transfer.jtransfer_ref=master_jual_paket.jpaket_nobukti)
							SET jual_transfer.jtransfer_stat_dok = master_jual_paket.jpaket_stat_dok
							WHERE master_jual_paket.jpaket_id='$jpaket_id'";
						$this->db->query($sqlu_jtransfer);
						if($this->db->affected_rows()>-1){
							//updating db.jual_tunai ==> pembatalan
							$sqlu_jtunai = "UPDATE jual_tunai JOIN master_jual_paket ON(jual_tunai.jtunai_ref=master_jual_paket.jpaket_nobukti)
								SET jual_tunai.jtunai_stat_dok = master_jual_paket.jpaket_stat_dok
								WHERE master_jual_paket.jpaket_id='$jpaket_id'";
							$this->db->query($sqlu_jtunai);
							if($this->db->affected_rows()>-1){
								//updating db.voucher_terima ==> pembatalan
								$sqlu_tvoucher = "UPDATE voucher_terima JOIN master_jual_paket ON(voucher_terima.tvoucher_ref=master_jual_paket.jpaket_nobukti)
									SET voucher_terima.tvoucher_stat_dok = master_jual_paket.jpaket_stat_dok
									WHERE master_jual_paket.jpaket_id='$jpaket_id'";
								$this->db->query($sqlu_tvoucher);
								if($this->db->affected_rows()>-1){
									return 1;
								}
							}
						}
					}
				}
			}
			
		}
		
		function membership_insert($jpaket_id){
			$date_now=date('Y-m-d');
			$this->db->where('membert_register <', $date_now);
			$this->db->delete('member_temp');
			
			$sql="SELECT setmember_transhari
					,setmember_periodeaktif
					,setmember_periodetenggang
					,setmember_transtenggang
					,setmember_pointhari
				FROM member_setup LIMIT 1";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$min_trans_member_baru=$rs_record['setmember_transhari'];
				$periode_tenggang=$rs_record['setmember_periodetenggang'];
				$min_trans_tenggang=$rs_record['setmember_transtenggang'];
				$setmember_pointhari=$rs_record['setmember_pointhari'];
				$periode_aktif=$rs_record['setmember_periodeaktif'];
			}
			
			$sql="SELECT jpaket_cust
					,jpaket_tanggal
				FROM master_jual_paket
				WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$cust_id = $rs_record['jpaket_cust'];
				$tanggal_transaksi = $rs_record['jpaket_tanggal'];
				
				$jproduk_total_trans=0;
				$jproduk_total_point=0;
				$jpaket_total_trans=0;
				$jpaket_total_point=0;
				$jrawat_total_trans=0;
				$jrawat_total_point=0;
				$cust_total_trans_now=0;
				$cust_total_point=0;
				
				$trans_jproduk = "SELECT sum(jproduk_totalbiaya) AS jproduk_total_trans
						,sum(jproduk_point) AS jproduk_total_point
					FROM master_jual_produk
					WHERE jproduk_cust='$cust_id'
						AND jproduk_tanggal='$date_now'
						AND jproduk_stat_dok='Tertutup'
					GROUP BY jproduk_cust";
				$rs_trans_jproduk=$this->db->query($trans_jproduk);
				if($rs_trans_jproduk->num_rows()){
					$rs_trans_jproduk_record=$rs_trans_jproduk->row_array();
					$jproduk_total_trans=$rs_trans_jproduk_record['jproduk_total_trans'];
					$jproduk_total_point=$rs_trans_jproduk_record['jproduk_total_point'];
				}
				
				$trans_jpaket = "SELECT sum(jpaket_totalbiaya) AS jpaket_total_trans
						,sum(jpaket_point) AS jpaket_total_point
					FROM master_jual_paket
					WHERE jpaket_cust='$cust_id'
						AND jpaket_tanggal='$date_now'
						AND jpaket_stat_dok='Tertutup'
					GROUP BY jpaket_cust";
				$rs_trans_jpaket=$this->db->query($trans_jpaket);
				if($rs_trans_jpaket->num_rows()){
					$rs_trans_jpaket_record=$rs_trans_jpaket->row_array();
					$jpaket_total_trans=$rs_trans_jpaket_record['jpaket_total_trans'];
					$jpaket_total_point=$rs_trans_jpaket_record['jpaket_total_point'];
				}
				
				$trans_jrawat = "SELECT sum(jrawat_totalbiaya) AS jrawat_total_trans
						,sum(jrawat_point) AS jrawat_total_point
					FROM master_jual_rawat
					WHERE jrawat_cust='$cust_id'
						AND jrawat_tanggal='$date_now'
						AND jrawat_stat_dok='Tertutup'
					GROUP BY jrawat_cust";
				$rs_trans_jrawat=$this->db->query($trans_jrawat);
				if($rs_trans_jrawat->num_rows()){
					$rs_trans_jrawat_record=$rs_trans_jrawat->row_array();
					$jrawat_total_trans=$rs_trans_jrawat_record['jrawat_total_trans'];
					$jrawat_total_point=$rs_trans_jrawat_record['jrawat_total_point'];
				}
				
				$cust_total_trans_now = $jproduk_total_trans + $jpaket_total_trans + $jrawat_total_trans;
				$cust_total_point = $jproduk_total_point + $jpaket_total_point + $jrawat_total_point;
				
				$sql="SELECT member_cust, member_valid, 
							case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end as member_no
						FROM member WHERE member_cust='$cust_id'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					//* artinya: customer sudah menjadi MEMBER.
					//* untuk itu: check tanggal member_valid /
					$rs_record=$rs->row_array();
					$member_cust=$rs_record['member_cust'];
					$member_valid=$rs_record['member_valid'];
					$member_no=$rs_record['member_no'];
					
					$akhir_tenggang=date('Y-m-d', strtotime("$member_valid +$periode_tenggang days"));
					
					if(($member_valid < $tanggal_transaksi) && ($member_valid < $akhir_tenggang)){
						//* kartu member masuk masa tenggang /
						//* untuk itu: check total_transaksi si customer di hari ini /
						
						$set_member_valid = date('Y-m-d', strtotime("$tanggal_transaksi +$periode_aktif days"));
						
						if($cust_total_trans_now >= $min_trans_tenggang){
							//* Perpanjangan kartu member /
							$sql = "SELECT membert_id FROM member_temp WHERE membert_cust='$cust_id'";
							$rs = $this->db->query($sql);
							if(!($rs->num_rows())){
								$dti_membert=array(
								"membert_cust"=>$cust_id,
								"membert_no"=>$member_no,
								"membert_register"=>$tanggal_transaksi,
								"membert_valid"=>$set_member_valid,
								"membert_jenis"=>'perpanjangan',
								"membert_status"=>'Daftar'
								);
								$this->db->insert('member_temp', $dti_membert);
								if($this->db->affected_rows()>-1){
									return 1;
								}else{
									return 1;
								}
							}else{
								return 1;
							}
						}else{
							//* message: kartu member customer ini sementara tidak bisa digunakan, karena sudah masuk masa tenggang /
							//* deleting customer pada db.member_temp (yang mungkin sebelumnya dimasukkan), dikarenakan ada pembatalan transaksi sehingga $cust_total_trans_now tidak memenuhi syarat /
							$this->db->where('membert_cust', $cust_id);
							$this->db->delete('member_temp');
							if($this->db->affected_rows()>-1){
								return 1;
							}else{
								return 1;
							}
						}
					}else{
						//* check tanggal member_valid, apakah member_valid > $tanggal_transaksi ? /
						//* JIKA 'YA': kartu member customer ini masih Aktif ==> NO ACTION/
						//* JIKA 'TIDAK': kartu member sudah hangus ==> message: kartu member customer ini sudah tidak bisa digunakan lagi karena kartu sudah hangus.
						if($member_valid > $tanggal_transaksi){
							//* NO ACTION /
						}else{
							//* message: kartu member customer ini sudah tidak bisa digunakan lagi karena kartu sudah hangus.
						}
						return 1;
					}
				}else{
					//* artinya: customer belum pernah menjadi MEMBER (belum masuk ke db.member). /
					//* untuk itu: check total_transaksi si customer di hari ini dan bandingkan dengan db.member_setup.setmember_transhari /
					if($cust_total_trans_now >= $min_trans_member_baru){
						//* Pendaftaran MEMBER BARU /
						$set_member_valid = date('Y-m-d', strtotime("$tanggal_transaksi +$periode_aktif days"));
						
						$sql = "SELECT membert_id FROM member_temp WHERE membert_cust='$cust_id'";
						$rs = $this->db->query($sql);
						if(!($rs->num_rows())){
							$dti_membert=array(
							"membert_cust"=>$cust_id,
							"membert_register"=>$tanggal_transaksi,
							"membert_valid"=>$set_member_valid,
							"membert_jenis"=>'baru',
							"membert_status"=>'Daftar'
							);
							$this->db->insert('member_temp', $dti_membert);
							if($this->db->affected_rows()>-1){
								return 1;
							}else{
								return 1;
							}
						}else{
							return 1;
						}
					}else{
						//* Syarat menjadi MEMBER belum terpenuhi /
						//* deleting di db.member_temp (jika sebelumnya sudah diinsert), karena melakukan pembatalan transaksi sehingga total transaksi hari ini tidak memenuhi syarat menjadi member /
						$this->db->where('membert_cust', $cust_id);
						$this->db->delete('member_temp');
						if($this->db->affected_rows()>-1){
							return 1;
						}else{
							return 1;
						}
					}
				}
			}
		}
		
		//insert detail record
		function detail_detail_jual_paket_insert($array_dpaket_id ,$dpaket_master ,$array_dpaket_paket, $array_dpaket_karyawan
												 ,$array_dpaket_kadaluarsa ,$array_dpaket_jumlah ,$array_dpaket_harga
												 ,$array_dpaket_diskon ,$array_dpaket_diskon_jenis ,$array_dpaket_sales, $cetak){
			$datetime_now = date('Y-m-d H:i:s');
			//if master id not capture from view then capture it from max pk from master table
			if($dpaket_master=="" || $dpaket_master==NULL || $dpaket_master==0){
				$dpaket_master=$this->get_master_id();
			}
			
			$size_array = sizeof($array_dpaket_paket) - 1;
			
			for($i = 0; $i < sizeof($array_dpaket_paket); $i++){
				$dpaket_id = $array_dpaket_id[$i];
				$dpaket_paket = $array_dpaket_paket[$i];
				$dpaket_karyawan = $array_dpaket_karyawan[$i];
				$dpaket_kadaluarsa = $array_dpaket_kadaluarsa[$i];
				$dpaket_jumlah = $array_dpaket_jumlah[$i];
				$dpaket_harga = $array_dpaket_harga[$i];
				$dpaket_diskon = $array_dpaket_diskon[$i];
				$dpaket_diskon_jenis = $array_dpaket_diskon_jenis[$i];
				$dpaket_sales = $array_dpaket_sales[$i];
				
				if($dpaket_kadaluarsa==""){
					$dpaket_kadaluarsa=NULL;
				}
				
				$dpaket_sisa_paket=0;
				$rpaket_jumlah_total=0;
				$ipaket_jumlah_total=0;
				
				//* mendapatkan jumlah_total_perawatan dalam paket /
				$sql_rpaket="SELECT sum(rpaket_jumlah) AS rpaket_jumlah_total
					FROM paket_isi_perawatan
					WHERE rpaket_master='$dpaket_paket'
					ORDER BY rpaket_master";
				$rs_rpaket=$this->db->query($sql_rpaket);
				if($rs_rpaket->num_rows()){
					$rs_rpaket_record=$rs_rpaket->row_array();
					$rpaket_jumlah_total=$rs_rpaket_record["rpaket_jumlah_total"];
				}
				
				//* mendapatkan jumlah_total_produk dalam paket /
				$sql_ipaket="SELECT sum(ipaket_jumlah) AS ipaket_jumlah_total
					FROM paket_isi_produk
					WHERE ipaket_master='$dpaket_paket'
					ORDER BY ipaket_master";
				$rs_ipaket=$this->db->query($sql_ipaket);
				if($rs_ipaket->num_rows()){
					$rs_ipaket_record=$rs_ipaket->row_array();
					$ipaket_jumlah_total=$rs_ipaket_record["ipaket_jumlah_total"];
				}
				
				//* jumlah total yang masuk ke detail_jual_paket.dpaket_sisa_paket = jumlah paket yang dibeli * (jumlah isi paket) /
				$dpaket_sisa_paket=$dpaket_jumlah*($rpaket_jumlah_total+$ipaket_jumlah_total);
				
				//* checking $dpaket_id ==> apakah is_numeric AND sudah ada di db.detail_jual_paket.dpaket_id ?? /
				$sql = "SELECT dpaket_id
						,dpaket_revised
						,paket_point
					FROM detail_jual_paket
						JOIN paket ON(dpaket_paket=paket_id)
					WHERE dpaket_id='".$dpaket_id."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()){
					$record = $rs->row_array();
					$dpaket_revised = $record['dpaket_revised'];
					$paket_point = $record['paket_point'];
					
					//* detail ini sudah ada dalam db.detail_jual_paket ==> updating /
					//* checking lagi, apakah $dpaket_master(identik = db.master_jual_paket.jpaket_id) AND $dpaket_id sudah diambil ataukah belum di db.detail_ambil_paket,
					//* JIKA sudah pernah diambil ==> maka $dpaket_id ini tidak boleh dilakukan updating atau penghapusan /
					$sql = "SELECT dapaket_id
						FROM detail_ambil_paket
						WHERE dapaket_jpaket='$dpaket_master'
							AND dapaket_dpaket='$dpaket_id'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()){
						//* artinya: isi paket sudah pernah diambil, sehingga tidak boleh di-edit ==> tidak ada action /
						
					}else{
						//* artinya: isi paket belum pernah diambil, sehingga masih boleh di-edit /
						$dtu_dpaket = array(
							//"dpaket_master"=>$dpaket_master, 
							"dpaket_paket"=>$dpaket_paket,
							"dpaket_set_point"=>$paket_point,
							"dpaket_karyawan"=>$dpaket_karyawan,
							"dpaket_kadaluarsa"=>$dpaket_kadaluarsa, 
							"dpaket_jumlah"=>$dpaket_jumlah, 
							"dpaket_harga"=>$dpaket_harga, 
							"dpaket_diskon"=>$dpaket_diskon,
							"dpaket_diskon_jenis"=>$dpaket_diskon_jenis,
							"dpaket_sales"=>$dpaket_sales,
							"dpaket_sisa_paket"=>$dpaket_sisa_paket,
							"dpaket_isi_paket"=>$dpaket_sisa_paket, //dpaket_isi_paket menyimpan total dari jumlah isi paket yg di beli, kondisi awal ketika insert/Create, dpaket_isi_paket akan selalu sama dengan dpaket_sisa_paket
							"dpaket_update"=>@$_SESSION[SESSION_USERID],
							"dpaket_date_update"=>$datetime_now,
							"dpaket_revised"=>$dpaket_revised+1
						);
						$this->db->where('dpaket_id', $dpaket_id);
						$this->db->update('detail_jual_paket', $dtu_dpaket); 
						
					}
				}else{
					$sql_paket = "SELECT paket_point FROM paket WHERE paket_id='".$dpaket_paket."'";
					$rs_paket = $this->db->query($sql_paket);
					$record_paket = $rs_paket->row_array();
					$paket_point = $record_paket['paket_point'];
					//* Adding detail baru /
					$data = array(
						"dpaket_master"=>$dpaket_master, 
						"dpaket_paket"=>$dpaket_paket,
						"dpaket_set_point"=>$paket_point,
						"dpaket_karyawan"=>$dpaket_karyawan,
						"dpaket_kadaluarsa"=>$dpaket_kadaluarsa, 
						"dpaket_jumlah"=>$dpaket_jumlah, 
						"dpaket_harga"=>$dpaket_harga, 
						"dpaket_diskon"=>$dpaket_diskon,
						"dpaket_diskon_jenis"=>$dpaket_diskon_jenis,
						"dpaket_sales"=>$dpaket_sales,
						"dpaket_sisa_paket"=>$dpaket_sisa_paket,
						"dpaket_isi_paket"=>$dpaket_sisa_paket, //dpaket_isi_paket menyimpan total dari jumlah isi paket yg di beli, kondisi awal ketika insert/Create, dpaket_isi_paket akan selalu sama dengan dpaket_sisa_paket
						"dpaket_creator"=>@$_SESSION[SESSION_USERID]
					);
					$this->db->insert('detail_jual_paket', $data); 
					
				}
				if(($cetak==1 or $cetak==2) && $i==$size_array){
					//* proses cetak /
					$rs_stat_dok = $this->master_jual_paket_status_update($dpaket_master);
					if($rs_stat_dok==1){
						$rs_point_update = $this->member_point_update($dpaket_master);
						if($rs_point_update==1){
							$rs_membership = $this->membership_insert($dpaket_master);
							if($rs_membership==1){
								$rs_piutang_update = $this->catatan_piutang_update($dpaket_master);
								if($rs_piutang_update==1){
									return $dpaket_master;
								}else{
									return '0';
								}
							}else{
								return '0';
							}
						}else{
							return '0';
						}
					}else{
						return '0';
					}
				}else if($cetak<>1 && $i==$size_array){
					return '0';
				}
				
			}
			
		}
		//end of function
		
		//function for get list record
		function master_jual_paket_list($filter,$start,$end){
			$date_now=date('Y-m-d');
		
			//backup: 2010-05-19 ==> $query = "SELECT jpaket_id, jpaket_nobukti, cust_nama, cust_no, cust_member, jpaket_cust, jpaket_tanggal, jpaket_diskon, jpaket_cashback, jpaket_cara, jpaket_cara2, jpaket_cara3, jpaket_bayar, IF(vu_jpaket.jpaket_totalbiaya!=0,vu_jpaket.jpaket_totalbiaya,vu_jpaket_totalbiaya.jpaket_totalbiaya) AS jpaket_totalbiaya, jpaket_keterangan, jpaket_stat_dok, jpaket_creator, jpaket_date_create, jpaket_update, jpaket_date_update, jpaket_revised FROM vu_jpaket LEFT JOIN vu_jpaket_totalbiaya ON(vu_jpaket_totalbiaya.dpaket_master=vu_jpaket.jpaket_id)";
			$query = "SELECT jpaket_id
					,jpaket_nobukti
					,jpaket_nobukti_pajak
					,CONCAT(cust_nama, ' (', cust_no, ')') as cust_nama_edit
					,cust_nama
					,cust_no
					,cust_priority_star
					,member_no
					,jpaket_cust
					,jpaket_tanggal
					,jpaket_diskon
					,jpaket_cashback
					,jpaket_cashback_medis
					,jpaket_cara
					,jpaket_cara2
					,jpaket_cara3
					,jpaket_bayar
					,IF(vu_jpaket.jpaket_totalbiaya!=0,vu_jpaket.jpaket_totalbiaya,vu_jpaket_totalbiaya.jpaket_totalbiaya) AS jpaket_totalbiaya
					,jpaket_keterangan
					,jpaket_ket_disk
					,jpaket_ket_disk_medis
					,jpaket_stat_dok
					,jpaket_creator
					,jpaket_date_create
					,jpaket_update
					,jpaket_date_update
					,jpaket_revised
				FROM vu_jpaket
				LEFT JOIN vu_jpaket_totalbiaya ON(vu_jpaket_totalbiaya.dpaket_master=vu_jpaket.jpaket_id)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jpaket_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%'  )";
			}
			//normal LIST by Hendri
			else {
				$query .= eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " date_format(jpaket_date_create,'%Y-%m-%d')='$date_now'";
			}	
			
			$query .= " ORDER BY jpaket_nobukti DESC ";
			
			$query_nbrows="SELECT jpaket_id FROM master_jual_paket LEFT JOIN customer ON(jpaket_cust=cust_id)";
			if ($filter<>""){
				$query_nbrows .=eregi("WHERE",$query_nbrows)? " AND ":" WHERE ";
				$query_nbrows .= " (jpaket_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%'  )";
			}
			else {
				$query_nbrows .= eregi("WHERE",$query_nbrows)? " AND ":" WHERE ";
				$query_nbrows .= " date_format(jpaket_date_create,'%Y-%m-%d')='$date_now'";
			}	
			
			$result = $this->db->query($query_nbrows);
			$nbrows = $result->num_rows();
			//$result = $this->db->query($query);
			//$nbrows = $result->num_rows();
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
		function master_jual_paket_update($jpaket_id
										  ,$jpaket_nobukti
										  ,$jpaket_cust
										  ,$jpaket_tanggal
										  ,$jpaket_stat_dok
										  ,$jpaket_diskon
										  ,$jpaket_cara
										  ,$jpaket_cara2
										  ,$jpaket_cara3
										  ,$jpaket_keterangan
										  ,$jpaket_cashback
										  ,$jpaket_cashback_medis
										  ,$jpaket_tunai_nilai
										  ,$jpaket_tunai_nilai2
										  ,$jpaket_tunai_nilai3
										  ,$jpaket_voucher_no
										  ,$jpaket_voucher_cashback
										  ,$jpaket_voucher_no2
										  ,$jpaket_voucher_cashback2
										  ,$jpaket_voucher_no3
										  ,$jpaket_voucher_cashback3
										  ,$jpaket_bayar
										  ,$jpaket_subtotal
										  ,$jpaket_total
										  ,$jpaket_hutang
										  ,$jpaket_kwitansi_no
										  ,$jpaket_kwitansi_nama
										  ,$jpaket_kwitansi_nilai
										  ,$jpaket_kwitansi_no2
										  ,$jpaket_kwitansi_nama2
										  ,$jpaket_kwitansi_nilai2
										  ,$jpaket_kwitansi_no3
										  ,$jpaket_kwitansi_nama3
										  ,$jpaket_kwitansi_nilai3
										  ,$jpaket_card_nama
										  ,$jpaket_card_edc
										  ,$jpaket_card_no
										  ,$jpaket_card_nilai
										  ,$jpaket_card_nama2
										  ,$jpaket_card_edc2
										  ,$jpaket_card_no2
										  ,$jpaket_card_nilai2
										  ,$jpaket_card_nama3
										  ,$jpaket_card_edc3
										  ,$jpaket_card_no3
										  ,$jpaket_card_nilai3
										  ,$jpaket_cek_nama
										  ,$jpaket_cek_no
										  ,$jpaket_cek_valid
										  ,$jpaket_cek_bank
										  ,$jpaket_cek_nilai
										  ,$jpaket_cek_nama2
										  ,$jpaket_cek_no2
										  ,$jpaket_cek_valid2
										  ,$jpaket_cek_bank2
										  ,$jpaket_cek_nilai2
										  ,$jpaket_cek_nama3
										  ,$jpaket_cek_no3
										  ,$jpaket_cek_valid3
										  ,$jpaket_cek_bank3
										  ,$jpaket_cek_nilai3
										  ,$jpaket_transfer_bank
										  ,$jpaket_transfer_nama
										  ,$jpaket_transfer_nilai
										  ,$jpaket_transfer_bank2
										  ,$jpaket_transfer_nama2
										  ,$jpaket_transfer_nilai2
										  ,$jpaket_transfer_bank3
										  ,$jpaket_transfer_nama3
										  ,$jpaket_transfer_nilai3
										  ,$cetak
										  ,$jpaket_ket_disk
										  ,$jpaket_ket_disk_medis
										  ,$jual_kwitansi_id
										  ,$jual_kwitansi_id2
										  ,$jual_kwitansi_id3){
			$date_now = date('Y-m-d');
			
			$jenis_transaksi = 'jual_paket';
			
			$datetime_now=date('Y-m-d H:i:s');
			if ($jpaket_stat_dok=="")
				$jpaket_stat_dok = "Terbuka";
			$jpaket_revised=0;
			
			$sql="SELECT jpaket_cara, jpaket_cara2, jpaket_cara3, jpaket_date_create, jpaket_revised FROM master_jual_paket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$jpaket_revised=$rs_record["jpaket_revised"];
			}
			if($jpaket_diskon=="")
				$jpaket_diskon=0;
			$data = array(
				"jpaket_nobukti"=>$jpaket_nobukti, 
				"jpaket_tanggal"=>$jpaket_tanggal, 
				"jpaket_diskon"=>$jpaket_diskon,
				"jpaket_cashback"=>$jpaket_cashback,
				"jpaket_cashback_medis"=>$jpaket_cashback_medis,
				"jpaket_bayar"=>$jpaket_bayar,
				"jpaket_totalbiaya"=>$jpaket_total,
				"jpaket_cara"=>$jpaket_cara,
				"jpaket_keterangan"=>$jpaket_keterangan,
				"jpaket_ket_disk"=>$jpaket_ket_disk,
				"jpaket_ket_disk_medis"=>$jpaket_ket_disk_medis,
				"jpaket_stat_dok"=>$jpaket_stat_dok,
				"jpaket_update"=>@$_SESSION[SESSION_USERID],
				"jpaket_date_update"=>$datetime_now,
				"jpaket_revised"=>$jpaket_revised+1
			);
			/*
			if($jpaket_tanggal<>$date_now){
				$data["jpaket_date_update"] = $jpaket_tanggal;
				//$bayar_date_create = $jpaket_tanggal;
			}else{
				$data["jpaket_date_update"] = $datetime_now;
				//$bayar_date_create = $datetime_now;
			}
			*/
			if($jpaket_cara2!=null){
				if(($jpaket_kwitansi_nilai2<>'' && $jpaket_kwitansi_nilai2<>0)
				   || ($jpaket_card_nilai2<>'' && $jpaket_card_nilai2<>0)
				   || ($jpaket_cek_nilai2<>'' && $jpaket_cek_nilai2<>0)
				   || ($jpaket_transfer_nilai2<>'' && $jpaket_transfer_nilai2<>0)
				   || ($jpaket_tunai_nilai2<>'' && $jpaket_tunai_nilai2<>0)
				   || ($jpaket_voucher_cashback2<>'' && $jpaket_voucher_cashback2<>0)){
					$data["jpaket_cara2"]=$jpaket_cara2;
				}else{
					$data["jpaket_cara2"]=NULL;
				}
			}
			if($jpaket_cara3!=null){
				if(($jpaket_kwitansi_nilai3<>'' && $jpaket_kwitansi_nilai3<>0)
				   || ($jpaket_card_nilai3<>'' && $jpaket_card_nilai3<>0)
				   || ($jpaket_cek_nilai3<>'' && $jpaket_cek_nilai3<>0)
				   || ($jpaket_transfer_nilai3<>'' && $jpaket_transfer_nilai3<>0)
				   || ($jpaket_tunai_nilai3<>'' && $jpaket_tunai_nilai3<>0)
				   || ($jpaket_voucher_cashback3<>'' && $jpaket_voucher_cashback3<>0)){
					$data["jpaket_cara3"]=$jpaket_cara3;
				}
			}
			$sql="select cust_id from customer where cust_id='".$jpaket_cust."'";
			$query=$this->db->query($sql);
			if($query->num_rows())
				$data["jpaket_cust"]=$jpaket_cust;
			
			$this->db->where('jpaket_id', $jpaket_id);
			$this->db->update('master_jual_paket', $data);
			if($this->db->affected_rows()>-1){
				$time_now = date('H:i:s');
				$bayar_date_create_temp = $jpaket_tanggal.' '.$time_now;
				$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
				
				//delete all transaksi
				//$sql="delete from jual_kwitansi where jkwitansi_ref='".$jpaket_nobukti."'";
				//$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_card where jcard_ref='".$jpaket_nobukti."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_cek where jcek_ref='".$jpaket_nobukti."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_transfer where jtransfer_ref='".$jpaket_nobukti."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								$sql="delete from jual_tunai where jtunai_ref='".$jpaket_nobukti."'";
								$this->db->query($sql);
								if($this->db->affected_rows()>-1){
									$sql="delete from voucher_terima where tvoucher_ref='".$jpaket_nobukti."'";
									$this->db->query($sql);
									if($this->db->affected_rows()>-1){
										if($jpaket_cara!=null || $jpaket_cara!=''){
											if($jpaket_kwitansi_nilai<>'' && $jpaket_kwitansi_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no
																								  ,$jpaket_kwitansi_nilai
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id);
												
											}elseif($jpaket_card_nilai<>'' && $jpaket_card_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama
																							  ,$jpaket_card_edc
																							  ,$jpaket_card_no
																							  ,$jpaket_card_nilai
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai<>'' && $jpaket_cek_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama
																							 ,$jpaket_cek_no
																							 ,$jpaket_cek_valid
																							 ,$jpaket_cek_bank
																							 ,$jpaket_cek_nilai
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai<>'' && $jpaket_transfer_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank
																								  ,$jpaket_transfer_nama
																								  ,$jpaket_transfer_nilai
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai<>'' && $jpaket_tunai_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback<>'' && $jpaket_voucher_cashback<>0){
												$result_bayar = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
										if($jpaket_cara2!=null || $jpaket_cara2!=''){
											if($jpaket_kwitansi_nilai2<>'' && $jpaket_kwitansi_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no2
																								  ,$jpaket_kwitansi_nilai2
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id2);
												
											}elseif($jpaket_card_nilai2<>'' && $jpaket_card_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama2
																							  ,$jpaket_card_edc2
																							  ,$jpaket_card_no2
																							  ,$jpaket_card_nilai2
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai2<>'' && $jpaket_cek_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama2
																							 ,$jpaket_cek_no2
																							 ,$jpaket_cek_valid2
																							 ,$jpaket_cek_bank2
																							 ,$jpaket_cek_nilai2
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai2<>'' && $jpaket_transfer_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank2
																								  ,$jpaket_transfer_nama2
																								  ,$jpaket_transfer_nilai2
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai2<>'' && $jpaket_tunai_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai2
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback2<>'' && $jpaket_voucher_cashback2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no2
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback2
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
										if($jpaket_cara3!=null || $jpaket_cara3!=''){
											if($jpaket_kwitansi_nilai3<>'' && $jpaket_kwitansi_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no3
																								  ,$jpaket_kwitansi_nilai3
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id3);
												
											}elseif($jpaket_card_nilai3<>'' && $jpaket_card_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama3
																							  ,$jpaket_card_edc3
																							  ,$jpaket_card_no3
																							  ,$jpaket_card_nilai3
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai3<>'' && $jpaket_cek_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama3
																							 ,$jpaket_cek_no3
																							 ,$jpaket_cek_valid3
																							 ,$jpaket_cek_bank3
																							 ,$jpaket_cek_nilai3
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai3<>'' && $jpaket_transfer_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank3
																								  ,$jpaket_transfer_nama3
																								  ,$jpaket_transfer_nilai3
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai3<>'' && $jpaket_tunai_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai3
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback3<>'' && $jpaket_voucher_cashback3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no3
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback3
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
									}
								}
							}
						}
					}
				}
				
				return '1';
			}
			else{
				return '0';
			}
		}
		
		//function for create new record
		function master_jual_paket_create($jpaket_nobukti ,$jpaket_cust ,$jpaket_tanggal ,$jpaket_diskon ,$jpaket_stat_dok, $jpaket_cara ,$jpaket_cara2 ,$jpaket_cara3 ,$jpaket_keterangan , $jpaket_cashback, $jpaket_cashback_medis,$jpaket_tunai_nilai, $jpaket_tunai_nilai2, $jpaket_tunai_nilai3, $jpaket_voucher_no, $jpaket_voucher_cashback, $jpaket_voucher_no2, $jpaket_voucher_cashback2, $jpaket_voucher_no3, $jpaket_voucher_cashback3, $jpaket_bayar, $jpaket_subtotal, $jpaket_total, $jpaket_hutang, $jpaket_kwitansi_no, $jpaket_kwitansi_nama, $jpaket_kwitansi_nilai, $jpaket_kwitansi_no2, $jpaket_kwitansi_nama2, $jpaket_kwitansi_nilai2, $jpaket_kwitansi_no3, $jpaket_kwitansi_nama3, $jpaket_kwitansi_nilai3, $jpaket_card_nama, $jpaket_card_edc, $jpaket_card_no, $jpaket_card_nilai, $jpaket_card_nama2, $jpaket_card_edc2, $jpaket_card_no2, $jpaket_card_nilai2, $jpaket_card_nama3, $jpaket_card_edc3, $jpaket_card_no3, $jpaket_card_nilai3, $jpaket_cek_nama, $jpaket_cek_no, $jpaket_cek_valid, $jpaket_cek_bank, $jpaket_cek_nilai, $jpaket_cek_nama2, $jpaket_cek_no2, $jpaket_cek_valid2, $jpaket_cek_bank2, $jpaket_cek_nilai2, $jpaket_cek_nama3, $jpaket_cek_no3, $jpaket_cek_valid3, $jpaket_cek_bank3, $jpaket_cek_nilai3, $jpaket_transfer_bank, $jpaket_transfer_nama, $jpaket_transfer_nilai, $jpaket_transfer_bank2, $jpaket_transfer_nama2, $jpaket_transfer_nilai2, $jpaket_transfer_bank3, $jpaket_transfer_nama3, $jpaket_transfer_nilai3, $cetak, $jpaket_ket_disk,$jpaket_ket_disk_medis, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3){
			$date_now = date('Y-m-d');
			$datetime_now=date('Y-m-d H:i:s');
			
			$jenis_transaksi = 'jual_paket';
			
			$jpaket_tanggal_pattern=strtotime($jpaket_tanggal);
			$pattern="PK/".date("ym",$jpaket_tanggal_pattern)."-";
			//$pattern="PK/".date("ym")."-";
			$jpaket_nobukti=$this->m_public_function->get_kode_1('master_jual_paket','jpaket_nobukti',$pattern,12);	//sementara, utk input manual
			if ($jpaket_stat_dok=="")
				$jpaket_stat_dok = "Terbuka";
			
			$data = array(
				"jpaket_nobukti"=>$jpaket_nobukti, 
				"jpaket_cust"=>$jpaket_cust, 
				"jpaket_tanggal"=>$jpaket_tanggal, 
				"jpaket_diskon"=>$jpaket_diskon, 
				"jpaket_cashback"=>$jpaket_cashback,
				"jpaket_cashback_medis"=>$jpaket_cashback_medis,
				"jpaket_bayar"=>$jpaket_bayar,
				"jpaket_totalbiaya"=>$jpaket_total,
				"jpaket_cara"=>$jpaket_cara,
				"jpaket_keterangan"=>$jpaket_keterangan,
				"jpaket_ket_disk"=>$jpaket_ket_disk,
				"jpaket_ket_disk_medis"=>$jpaket_ket_disk_medis,
				"jpaket_stat_dok"=>$jpaket_stat_dok,
				"jpaket_creator"=>$_SESSION[SESSION_USERID]
			);
			/* membuat date create menjadi ikut tanggal dipilih
			if($jpaket_tanggal<>$date_now){
				$data["jpaket_date_create"] = $jpaket_tanggal;
			}
			*/
			$data["jpaket_date_create"] = $datetime_now;
			
			
			if($jpaket_cara2!=null){
				if(($jpaket_kwitansi_nilai2<>'' && $jpaket_kwitansi_nilai2<>0)
				   || ($jpaket_card_nilai2<>'' && $jpaket_card_nilai2<>0)
				   || ($jpaket_cek_nilai2<>'' && $jpaket_cek_nilai2<>0)
				   || ($jpaket_transfer_nilai2<>'' && $jpaket_transfer_nilai2<>0)
				   || ($jpaket_tunai_nilai2<>'' && $jpaket_tunai_nilai2<>0)
				   || ($jpaket_voucher_cashback2<>'' && $jpaket_voucher_cashback2<>0)){
					$data["jpaket_cara2"]=$jpaket_cara2;
				}else{
					$data["jpaket_cara2"]=NULL;
				}
			}
			if($jpaket_cara3!=null){
				if(($jpaket_kwitansi_nilai3<>'' && $jpaket_kwitansi_nilai3<>0)
				   || ($jpaket_card_nilai3<>'' && $jpaket_card_nilai3<>0)
				   || ($jpaket_cek_nilai3<>'' && $jpaket_cek_nilai3<>0)
				   || ($jpaket_transfer_nilai3<>'' && $jpaket_transfer_nilai3<>0)
				   || ($jpaket_tunai_nilai3<>'' && $jpaket_tunai_nilai3<>0)
				   || ($jpaket_voucher_cashback3<>'' && $jpaket_voucher_cashback3<>0)){
					$data["jpaket_cara3"]=$jpaket_cara3;
				}
			}
			$this->db->insert('master_jual_paket', $data); 
			if($this->db->affected_rows()){
				$time_now = date('H:i:s');
				$bayar_date_create_temp = $jpaket_tanggal.' '.$time_now;
				$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
				
				//delete all transaksi
				//$sql="delete from jual_kwitansi where jkwitansi_ref='".$jpaket_nobukti."'";
				//$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_card where jcard_ref='".$jpaket_nobukti."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_cek where jcek_ref='".$jpaket_nobukti."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_transfer where jtransfer_ref='".$jpaket_nobukti."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								$sql="delete from jual_tunai where jtunai_ref='".$jpaket_nobukti."'";
								$this->db->query($sql);
								if($this->db->affected_rows()>-1){
									$sql="delete from voucher_terima where tvoucher_ref='".$jpaket_nobukti."'";
									$this->db->query($sql);
									if($this->db->affected_rows()>-1){
										if($jpaket_cara!=null || $jpaket_cara!=''){
											if($jpaket_kwitansi_nilai<>'' && $jpaket_kwitansi_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no
																								  ,$jpaket_kwitansi_nilai
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id);
												
											}elseif($jpaket_card_nilai<>'' && $jpaket_card_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama
																							  ,$jpaket_card_edc
																							  ,$jpaket_card_no
																							  ,$jpaket_card_nilai
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai<>'' && $jpaket_cek_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama
																							 ,$jpaket_cek_no
																							 ,$jpaket_cek_valid
																							 ,$jpaket_cek_bank
																							 ,$jpaket_cek_nilai
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai<>'' && $jpaket_transfer_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank
																								  ,$jpaket_transfer_nama
																								  ,$jpaket_transfer_nilai
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai<>'' && $jpaket_tunai_nilai<>0){
												$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback<>'' && $jpaket_voucher_cashback<>0){
												$result_bayar = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
										if($jpaket_cara2!=null || $jpaket_cara2!=''){
											if($jpaket_kwitansi_nilai2<>'' && $jpaket_kwitansi_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no2
																								  ,$jpaket_kwitansi_nilai2
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id2);
												
											}elseif($jpaket_card_nilai2<>'' && $jpaket_card_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama2
																							  ,$jpaket_card_edc2
																							  ,$jpaket_card_no2
																							  ,$jpaket_card_nilai2
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai2<>'' && $jpaket_cek_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama2
																							 ,$jpaket_cek_no2
																							 ,$jpaket_cek_valid2
																							 ,$jpaket_cek_bank2
																							 ,$jpaket_cek_nilai2
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai2<>'' && $jpaket_transfer_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank2
																								  ,$jpaket_transfer_nama2
																								  ,$jpaket_transfer_nilai2
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai2<>'' && $jpaket_tunai_nilai2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai2
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback2<>'' && $jpaket_voucher_cashback2<>0){
												$result_bayar2 = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no2
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback2
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
										if($jpaket_cara3!=null || $jpaket_cara3!=''){
											if($jpaket_kwitansi_nilai3<>'' && $jpaket_kwitansi_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_kwitansi_insert($jpaket_kwitansi_no3
																								  ,$jpaket_kwitansi_nilai3
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak
																								  ,$jual_kwitansi_id3);
												
											}elseif($jpaket_card_nilai3<>'' && $jpaket_card_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_card_insert($jpaket_card_nama3
																							  ,$jpaket_card_edc3
																							  ,$jpaket_card_no3
																							  ,$jpaket_card_nilai3
																							  ,$jpaket_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak);
											}elseif($jpaket_cek_nilai3<>'' && $jpaket_cek_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_cek_insert($jpaket_cek_nama3
																							 ,$jpaket_cek_no3
																							 ,$jpaket_cek_valid3
																							 ,$jpaket_cek_bank3
																							 ,$jpaket_cek_nilai3
																							 ,$jpaket_nobukti
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak);
											}elseif($jpaket_transfer_nilai3<>'' && $jpaket_transfer_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_transfer_insert($jpaket_transfer_bank3
																								  ,$jpaket_transfer_nama3
																								  ,$jpaket_transfer_nilai3
																								  ,$jpaket_nobukti
																								  ,$bayar_date_create
																								  ,$jenis_transaksi
																								  ,$cetak);
											}elseif($jpaket_tunai_nilai3<>'' && $jpaket_tunai_nilai3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_tunai_insert($jpaket_tunai_nilai3
																							   ,$jpaket_nobukti
																							   ,$bayar_date_create
																							   ,$jenis_transaksi
																							   ,$cetak);
											}elseif($jpaket_voucher_cashback3<>'' && $jpaket_voucher_cashback3<>0){
												$result_bayar3 = $this->m_public_function->cara_bayar_voucher_insert($jpaket_voucher_no3
																								 ,$jpaket_nobukti
																								 ,$jpaket_voucher_cashback3
																								 ,$bayar_date_create
																								 ,$jenis_transaksi
																								 ,$cetak);
											}
										}
									}
								}
							}
						}
					}
				}
				
				/* Ambil db.master_jual_paket.jpaket_id ==> untuk memasukkan Customer yang membeli Paket ke db.submaster_jual_paket sebagai daftar pengguna Faktur Penjualan Paket */
				$sql="SELECT jpaket_id FROM master_jual_paket WHERE jpaket_nobukti='$jpaket_nobukti'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$data_sjpaket=array(
					"ppaket_master"=>$rs_record["jpaket_id"],
					"ppaket_cust"=>$jpaket_cust
					);
					$this->db->insert('pengguna_paket', $data_sjpaket);
				}
				
				return '1';
			}
			else
				return '0';
		}
		
		//Delete detail_jual_paket
        function detail_jual_paket_delete($dpaket_id){
            $date_now = date('Y-m-d');
			$datetime_now = date('Y-m-d H:i:s');
			$sql = "SELECT dapaket_id FROM detail_ambil_paket WHERE dapaket_dpaket='$dpaket_id'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				//* artinya: Customer sudah pernah mengambil perawatan di paket ini. Sehingga tidak boleh di-Batal-kan. /
				return '0';
			}else{
				//* artinya: Customer belum pernah ambil perawatan di paket ini. Sehingga masih boleh di-delete /
				$query = "DELETE FROM detail_jual_paket WHERE dpaket_id = ".$dpaket_id;
				$this->db->query($query);
				if($this->db->affected_rows()>0)
					return '1';
				else
					return '-1';
			}
			
		}
		
		function pengguna_paket_delete($ppaket_master ,$ppaket_cust){
            $date_now = date('Y-m-d');
			$datetime_now = date('Y-m-d H:i:s');
			$sql = "SELECT dapaket_id
				FROM detail_ambil_paket
				WHERE dapaket_jpaket='".$ppaket_master."'
					AND dapaket_cust='".$ppaket_cust."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				//* artinya: Customer sudah pernah mengambil perawatan di paket ini. Sehingga tidak boleh di-Delete. /
				return '0';
			}else{
				//* artinya: Customer belum pernah ambil perawatan di paket ini. Sehingga masih boleh di-delete /
				$query = "DELETE FROM pengguna_paket WHERE ppaket_master='".$ppaket_master."' AND ppaket_cust='".$ppaket_cust."'";
				$this->db->query($query);
				if($this->db->affected_rows()>0)
					return '1';
				else
					return '-1';
			}
			
		}
		
		function master_jual_paket_batal($jpaket_id, $jpaket_tanggal){
			$date = date('Y-m-d');
			$date_1 = '01';
			$date_2 = '02';
			$date_3 = '03';
			$month = substr($jpaket_tanggal,5,2);
			$year = substr($jpaket_tanggal,0,4);
			$begin=mktime(0,0,0,$month,1,$year);
			$nextmonth=strtotime("+1month",$begin);
			
			$month_next = substr(date("Y-m-d",$nextmonth),5,2);
			$year_next = substr(date("Y-m-d",$nextmonth),0,4);
			
			$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
			$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
			$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
			
			
			//$date_now = date('Y-m-d');
			$datetime_now = date('Y-m-d H:i:s');
			//$sql = "SELECT dapaket_id FROM detail_ambil_paket WHERE dapaket_jpaket='$jpaket_id'";
			$sql = "SELECT dapaket_id FROM detail_ambil_paket WHERE dapaket_jpaket='$jpaket_id' AND dapaket_stat_dok<>'Batal'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				//* artinya: Customer sudah pernah mengambil paket pada Faktur ini. Sehingga tidak boleh di-Batal-kan. /
				return '0';
			}else{
				//* artinya: Customer belum pernah ambil paket pada Faktur ini. Sehingga masih boleh di-Batal-kan /
				$sql = "UPDATE master_jual_paket
					SET jpaket_stat_dok='Batal'
						,jpaket_update='".@$_SESSION[SESSION_USERID]."'
						,jpaket_date_update='".$datetime_now."'
						,jpaket_revised=jpaket_revised+1
					WHERE jpaket_id='".$jpaket_id."' " ;
						
						 //AND ('".$date."'<='".$tanggal_3."' OR  jpaket_tanggal='".$date."')";
						
				$this->db->query($sql);
				if($this->db->affected_rows()>0){
					//* udpating db.customer.cust_point ==> proses mengurangi jumlah poin (dikurangi dengan db.master_jual_paket.jpaket_point yg sudah dimasukkan ketika cetak faktur), karena dilakukan pembatalan /
					$result_point_batal = $this->member_point_batal($jpaket_id);
					if($result_point_batal==1){
						$result_membership = $this->membership_insert($jpaket_id);
						if($result_membership==1){
							$result_piutang = $this->catatan_piutang_batal($jpaket_id);
							if($result_piutang==1){
								$result_cara_bayar = $this->cara_bayar_batal($jpaket_id);
								if($result_cara_bayar==1){
									return '1';
								}
							}
						}
					}
				}else
					return '-1';
			}
			
		}
		
		//function for advanced search record
		function master_jual_paket_search($jpaket_nobukti ,$jpaket_cust ,$jpaket_tanggal, $jpaket_tanggal_akhir, $jpaket_diskon ,$jpaket_cashback ,$jpaket_cashback_medis,$jpaket_voucher ,$jpaket_cara ,$jpaket_bayar , $jpaket_keterangan, $jpaket_stat_dok, $start, $end){
			//full query
			/*$query="SELECT * FROM master_jual_paket,customer,member
					WHERE jpaket_cust=cust_id and member_id = cust_member";*/
					
			$query = "SELECT jpaket_id
					,jpaket_nobukti
					,jpaket_nobukti_pajak
					,CONCAT(cust_nama, ' (', cust_no, ')') as cust_nama_edit
					,cust_nama
					,cust_no
					,cust_priority_star
					,member_no
					,jpaket_cust
					,jpaket_tanggal
					,jpaket_diskon
					,jpaket_cashback
					,jpaket_cashback_medis
					,jpaket_ket_disk
					,jpaket_ket_disk_medis
					,jpaket_cara
					,jpaket_cara2
					,jpaket_cara3
					,jpaket_bayar
					,IF(vu_jpaket.jpaket_totalbiaya!=0,vu_jpaket.jpaket_totalbiaya,vu_jpaket_totalbiaya.jpaket_totalbiaya) AS jpaket_totalbiaya
					,jpaket_keterangan
					,jpaket_stat_dok
					,jpaket_creator
					,jpaket_date_create
					,jpaket_update
					,jpaket_date_update
					,jpaket_revised
				FROM vu_jpaket
				LEFT JOIN vu_jpaket_totalbiaya ON(vu_jpaket_totalbiaya.dpaket_master=vu_jpaket.jpaket_id)";
			
			if($jpaket_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_nobukti LIKE '%".$jpaket_nobukti."%'";
			};
			if($jpaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_cust = '".$jpaket_cust."'";
			};
			if($jpaket_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_tanggal>= '".$jpaket_tanggal."'";
			};
			if($jpaket_tanggal_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_tanggal<= '".$jpaket_tanggal_akhir."'";
			};
			if($jpaket_diskon!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_diskon LIKE '%".$jpaket_diskon."%'";
			};
			if($jpaket_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_cara LIKE '%".$jpaket_cara."%'";
			};
			if($jpaket_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_keterangan LIKE '%".$jpaket_keterangan."%'";
			};
			if($jpaket_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_stat_dok LIKE '%".$jpaket_stat_dok."%'";
			};
			
			$query .= " ORDER BY jpaket_nobukti DESC ";
			
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
		function master_jual_paket_print($jpaket_nobukti
										,$jpaket_cust
										,$jpaket_tanggal
										,$jpaket_tanggal_akhir
										,$jpaket_diskon
										,$jpaket_cashback
										,$jpaket_voucher
										,$jpaket_cara
										,$jpaket_bayar
										,$jpaket_keterangan
										,$jpaket_stat_dok
										,$option
										,$filter){
			//full query
			$query = "SELECT vu_jpaket.jpaket_tanggal
					,vu_jpaket.jpaket_nobukti
					,vu_jpaket.cust_no
					,vu_jpaket.cust_nama
					,INSERT(INSERT(vu_jpaket.member_no,7,0,'-'),14,0,'-') AS no_member
					,vu_jpaket.jpaket_totalbiaya
					,vu_jpaket.jpaket_bayar
					,vu_jpaket.jpaket_keterangan
					,vu_jpaket.jpaket_stat_dok
				FROM vu_jpaket
				LEFT JOIN vu_jpaket_totalbiaya ON(vu_jpaket_totalbiaya.dpaket_master=vu_jpaket.jpaket_id)";
				
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jpaket_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($jpaket_nobukti!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_nobukti LIKE '%".$jpaket_nobukti."%'";
				};
				if($jpaket_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_cust = '".$jpaket_cust."'";
				};
				if($jpaket_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_tanggal>= '".$jpaket_tanggal."'";
				};
				if($jpaket_tanggal_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_tanggal<= '".$jpaket_tanggal_akhir."'";
				};
				if($jpaket_diskon!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_diskon LIKE '%".$jpaket_diskon."%'";
				};
				if($jpaket_cara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_cara LIKE '%".$jpaket_cara."%'";
				};
				if($jpaket_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_keterangan LIKE '%".$jpaket_keterangan."%'";
				};
				if($jpaket_stat_dok!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_stat_dok LIKE '%".$jpaket_stat_dok."%'";
				};
				$result = $this->db->query($query);
			}
			return $result->result();
		}
		
		//function  for export to excel
		function master_jual_paket_export_excel($jpaket_nobukti
												,$jpaket_cust
												,$jpaket_tanggal
												,$jpaket_tanggal_akhir
												,$jpaket_diskon
												,$jpaket_cashback
												,$jpaket_voucher
												,$jpaket_cara
												,$jpaket_bayar
												,$jpaket_keterangan
												,$jpaket_stat_dok
												,$option
												,$filter){
			//full query
			$query = "SELECT vu_jpaket.jpaket_tanggal AS tanggal
					,vu_jpaket.jpaket_nobukti AS no_faktur
					,vu_jpaket.cust_no AS no_cust
					,vu_jpaket.cust_nama AS customer
					,INSERT(INSERT(vu_jpaket.member_no,7,0,'-'),14,0,'-') AS no_member
					,vu_jpaket.jpaket_totalbiaya AS 'Total (Rp)'
					,vu_jpaket.jpaket_bayar AS 'Total Bayar (Rp)'
					,vu_jpaket.jpaket_keterangan AS keterangan
					,vu_jpaket.jpaket_stat_dok AS stat_dok
				FROM vu_jpaket
				LEFT JOIN vu_jpaket_totalbiaya ON(vu_jpaket_totalbiaya.dpaket_master=vu_jpaket.jpaket_id)";
				
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (jpaket_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($jpaket_nobukti!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_nobukti LIKE '%".$jpaket_nobukti."%'";
				};
				if($jpaket_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_cust = '".$jpaket_cust."'";
				};
				if($jpaket_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_tanggal>= '".$jpaket_tanggal."'";
				};
				if($jpaket_tanggal_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_tanggal<= '".$jpaket_tanggal_akhir."'";
				};
				if($jpaket_diskon!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_diskon LIKE '%".$jpaket_diskon."%'";
				};
				if($jpaket_cara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_cara LIKE '%".$jpaket_cara."%'";
				};
				if($jpaket_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_keterangan LIKE '%".$jpaket_keterangan."%'";
				};
				if($jpaket_stat_dok!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_stat_dok LIKE '%".$jpaket_stat_dok."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		function master_jual_paket_status_update($jpaket_id){
			$date_now = date('Y-m-d');
			$datetime_now=date('Y-m-d H:i:s');
			//* status dokumen menjadi tertutup setelah Faktur selesai di-cetak /
			$sql = "SELECT jpaket_tanggal FROM master_jual_paket WHERE jpaket_id='".$jpaket_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$jpaket_tanggal = $record['jpaket_tanggal'];
				/*
				if($jpaket_tanggal<>$date_now){
					$jpaket_date_update = $jpaket_tanggal;
				}else{
					$jpaket_date_update = $datetime_now;
				}
				*/
				
				$sql="UPDATE master_jual_paket
					SET jpaket_stat_dok='Tertutup'
						,jpaket_update='".@$_SESSION[SESSION_USERID]."'
						,jpaket_date_update='".$datetime_now."'
						,jpaket_revised=jpaket_revised+1,
						jpaket_total_isi_paket = 
							(select sum(dpaket_isi_paket) 
							from detail_jual_paket
							where dpaket_master = '$jpaket_id')
					WHERE jpaket_id='$jpaket_id'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					return 1;
				}else{
					return 1;
				}
			}else{
				return 1;
			}
		}
		
		function print_paper($jpaket_id){
			//$this->master_jual_paket_status_update($jpaket_id);
			$sql="
			SELECT 
				jpaket_tanggal, 
				cust_no, 
				cust_nama, 
				cust_alamat, 
				jpaket_nobukti, 
				paket_nama, 
				dpaket_jumlah, 
				dpaket_harga, 
				dpaket_diskon, 
				(dpaket_harga*((100-dpaket_diskon)/100)) AS jumlah_subtotal, 
				jpaket_creator, 
				jpaket_diskon, 
				jpaket_cashback,
				TIME(jpaket_date_create) AS jpaket_jam,
				date_format(dpaket_kadaluarsa,'%d-%m-%Y')  AS tgl_kadaluarsa
			FROM detail_jual_paket 
			LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
			LEFT JOIN customer ON(jpaket_cust=cust_id) 
			LEFT JOIN paket ON(dpaket_paket=paket_id) 
			WHERE jpaket_id='$jpaket_id'";
			$result = $this->db->query($sql);
			return $result;
		}
		
	/*Function Print Paper utk penjualan paket Medis */
	function print_paper_medis($jpaket_id){
		// QUERY UTK PRINT PAPER.. 

		$sql="
			SELECT 
				jpaket_tanggal, 
				cust_no, 
				cust_nama, 
				cust_alamat, 
				jpaket_nobukti, 
				jpaket_bayar,
				paket_nama, 
				dpaket_jumlah, 
				dpaket_harga, 
				dpaket_diskon, 
				((dpaket_harga*((100-dpaket_diskon)/100))*dpaket_jumlah) as jumlah_subtotal_medis, 
				jpaket_creator, 
				jpaket_diskon, 
				jpaket_cashback,
				TIME(jpaket_date_create) AS jpaket_jam,
				date_format(dpaket_kadaluarsa,'%d-%m-%Y')  AS tgl_kadaluarsa,
				jpaket_nobukti_pajak,
				0 as diskon,
				0 as pajak,
				(select sum(detail_jual_paket.dpaket_isi_paket)
					from detail_jual_paket
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
					left join paket on (paket.paket_id = detail_jual_paket.dpaket_paket)
					left join kategori on (kategori.kategori_id = paket.paket_kategori)
					where master_jual_paket.jpaket_id = '$jpaket_id' and kategori.kategori_nama = 'Medis'
				)/(select sum(dpaket_isi_paket)
					from detail_jual_paket
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
					where master_jual_paket.jpaket_id = '$jpaket_id'
				   )*jpaket_cashback as voucher_total_medis
			FROM detail_jual_paket 
			LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
			LEFT JOIN customer ON(jpaket_cust=cust_id) 
			LEFT JOIN paket ON(dpaket_paket=paket_id) 
			LEFT JOIN kategori ON (kategori_id = paket_kategori)
			WHERE jpaket_id='$jpaket_id' and kategori_nama = 'Medis'";
		
		$result = $this->db->query($sql);
		//$this->master_jual_rawat_tertutup($jrawat_id);
		return $result;
	}
		
		
	function print_paper_nonmedis($jpaket_id){
		$sql_pajak = "SELECT jpaket_nobukti_pajak FROM master_jual_paket WHERE jpaket_id = ".$jpaket_id."";
		$result_pajak = $this->db->query($sql_pajak);
		$data_nobukti_pajak= $result_pajak->row();
		$nobukti_pajak= $data_nobukti_pajak->jpaket_nobukti_pajak;
	
		// JUMLAH Paket NON MEDIS
		$sql_cek_nonmedis="SELECT kategori_nama
					FROM vu_detail_jual_paket
					WHERE dpaket_master ='".$jpaket_id."' AND kategori_nama='Non Medis'";
		$result_cek_nonmedis = $this->db->query($sql_cek_nonmedis);
		$jum_rawat_nonmedis= $result_cek_nonmedis->num_rows();
	
		if ($nobukti_pajak =='-' && $jum_rawat_nonmedis > 0) {
		$pattern="010.000-".date("y").".";
		$length = 19;
		
		// AMBIL DARI M PUBLIC FUNCTION
		$len_pattern=strlen($pattern);
		$len_lpad=$length-$len_pattern;
		$sql="select concat(left(max(nobukti_pajak),".$len_pattern."),LPAD((right(max(nobukti_pajak),".$len_lpad.")+1),".$len_lpad.",0)) as max_key from 
					(
						select jproduk_nobukti_pajak AS nobukti_pajak from master_jual_produk
						union
						select dapaket_nobukti_pajak AS nobukti_pajak from detail_ambil_paket					
						union 					
						select jrawat_nobukti_pajak AS nobukti_pajak from master_jual_rawat
						union
						select jpaket_nobukti_pajak As nobukti_pajak from master_jual_paket
					) AS table_union
				where nobukti_pajak like '".$pattern."%' AND nobukti_pajak is not null";
				
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			$kode=$data->max_key;
			if(is_null($kode))
			{
				$pad="";
				for($i=1;$i<$len_lpad;$i++)
					$pad.="0";
				$kode=$pattern.$pad."1";
			}
			//return $kode;
		}else{
			$pad="";
			for($i=1;$i<$len_lpad;$i++)
				$pad.="0";
			$kode=$pattern.$pad."1";
			//return $kode;
		}
		// END OF GENERATE PAJAK	

		
		// UPDATE FAKTUR PAJAK
		$sql_update = "UPDATE master_jual_paket
				SET jpaket_nobukti_pajak = '".$kode."'
				WHERE jpaket_id='$jpaket_id'";
		$this->db->query('LOCK TABLE master_jual_paket WRITE');
		$this->db->query($sql_update);
		$this->db->query('UNLOCK TABLES');
		// END UPDATE FAKTUR PAJAK
		}
		
		$sql_print="
			SELECT 
				jpaket_tanggal, 
				cust_no, 
				cust_nama, 
				cust_alamat, 
				jpaket_nobukti, 
				jpaket_bayar,
				paket_nama, 
				dpaket_jumlah, 
				dpaket_harga, 
				dpaket_diskon, 
				((dpaket_harga*((100-dpaket_diskon)/100))*dpaket_jumlah) AS jumlah_subtotal_nonmedis, 
				jpaket_creator, 
				jpaket_diskon, 
				jpaket_cashback,
				TIME(jpaket_date_create) AS jpaket_jam,
				date_format(dpaket_kadaluarsa,'%d-%m-%Y')  AS tgl_kadaluarsa,
				jpaket_nobukti_pajak,
				(dpaket_harga / 1.1) as dpp,
				((dpaket_harga * dpaket_jumlah) / 1.1) as sub_tot_dpp,
				(jpaket_cashback/1.1) as diskon,
				(((dpaket_harga * dpaket_jumlah) / 1.1)-(jpaket_cashback/1.1)) as subtotal,
				(((dpaket_harga * dpaket_jumlah) / 1.1)-(jpaket_cashback/1.1))*0.1 as pajak,
				((dpaket_jumlah*dpaket_harga)/1.1) - (((dpaket_jumlah*dpaket_harga)/1.1)*dpaket_diskon/100) as subtotnet_dpp,
				(select sum(detail_jual_paket.dpaket_isi_paket)
					from detail_jual_paket
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
					left join paket on (paket.paket_id = detail_jual_paket.dpaket_paket)
					left join kategori on (kategori.kategori_id = paket.paket_kategori)
					where master_jual_paket.jpaket_id = '$jpaket_id' and kategori.kategori_nama = 'Non Medis'
				)/(select sum(dpaket_isi_paket)
					from detail_jual_paket
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
					where master_jual_paket.jpaket_id = '$jpaket_id'
				   )*jpaket_cashback as voucher_total_nonmedis
			FROM detail_jual_paket 
			LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
			LEFT JOIN customer ON(jpaket_cust=cust_id) 
			LEFT JOIN paket ON(dpaket_paket=paket_id) 
			LEFT JOIN kategori ON (kategori_id = paket_kategori)
			WHERE jpaket_id='$jpaket_id' and kategori_nama = 'Non Medis'";
	
		$result = $this->db->query($sql_print);
		//$this->master_jual_rawat_tertutup($jrawat_id);
		return $result;
	}	
	
		
		function get_cara_bayar($jpaket_id){
			$sql="SELECT jpaket_nobukti, jpaket_cara FROM master_jual_paket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$record=$rs->row_array();
				$sql = "SELECT cek ,card ,kuitansi ,transfer ,tunai FROM vu_trans_paket WHERE no_bukti='".$record['jpaket_nobukti']."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()){
					return $rs->result();
				}else{
					return '';
				}
			}else{
				return '';
			}
			
		}
		
		function cara_bayar($jpaket_id){
			$sql="SELECT jpaket_nobukti, jpaket_cara FROM master_jual_paket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$record=$rs->row();
				$jpaket_nobukti = $record->jpaket_nobukti;
				if(($record->jpaket_cara !== NULL || $record->jpaket_cara !== '')){
					if($record->jpaket_cara == 'tunai'){
						$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, jtunai_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}elseif($record->jpaket_cara == 'kwitansi'){
						$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, jkwitansi_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}elseif($record->jpaket_cara == 'card'){
						$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, jcard_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}elseif($record->jpaket_cara == 'cek/giro'){
						$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, jcek_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}elseif($record->jpaket_cara == 'transfer'){
						$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, jtransfer_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}elseif($record->jpaket_cara == 'voucher'){
						$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						
						$sql="SELECT jpaket_nobukti, jpaket_cara, tvoucher_nilai AS bayar_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 0,1";
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
		
		function cara_bayar2($jpaket_id){
			$sql="SELECT jpaket_nobukti, jpaket_cara2 FROM master_jual_paket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$record=$rs->row();
				$jpaket_nobukti = $record->jpaket_nobukti;
				if(($record->jpaket_cara2 !== NULL || $record->jpaket_cara2 !== '')){
					if($record->jpaket_cara2 == 'tunai'){
						$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara2 == 'kwitansi'){
						$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara2 == 'card'){
						$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara2 == 'cek/giro'){
						$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara2 == 'transfer'){
						$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara2 == 'voucher'){
						$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}
				}else{
					return NULL;
				}
			}else{
				return NULL;
			}
		}
		
		function cara_bayar3($jpaket_id){
			$sql="SELECT jpaket_nobukti, jpaket_cara3 FROM master_jual_paket WHERE jpaket_id='$jpaket_id'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$record=$rs->row();
				$jpaket_nobukti = $record->jpaket_nobukti;
				if(($record->jpaket_cara3 !== NULL || $record->jpaket_cara3 !== '')){
					if($record->jpaket_cara3 == 'tunai'){
						$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_tunai ON(jtunai_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara3 == 'kwitansi'){
						$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara3 == 'card'){
						$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_card ON(jcard_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara3 == 'cek/giro'){
						$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_cek ON(jcek_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara3 == 'transfer'){
						$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN jual_transfer ON(jtransfer_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}elseif($record->jpaket_cara3 == 'voucher'){
						$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jpaket_nobukti."'";
						$rs = $this->db->query($sql);
						if($rs->num_rows()==1){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id'";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==2){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 1,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}else if($rs->num_rows()==3){
							$sql="SELECT jpaket_nobukti, jpaket_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_paket LEFT JOIN voucher_terima ON(tvoucher_ref=jpaket_nobukti) WHERE jpaket_id='$jpaket_id' LIMIT 2,1";
							$rs=$this->db->query($sql);
							if($rs->num_rows()){
								return $rs->row();
							}else{
								return NULL;
							}
						}
					}
				}else{
					return NULL;
				}
			}else{
				return NULL;
			}
		}
		
			function iklan(){
			$sql="SELECT * from iklan_today";
			$result = $this->db->query($sql);
			return $result;
		}
		
		
		
}
?>