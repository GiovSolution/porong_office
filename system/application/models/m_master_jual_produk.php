<? /* 	
		GIOV Solution - Keep IT Simple
*/

class M_master_jual_produk extends Model{
		
	//constructor
	function M_master_jual_produk() {
		parent::Model();
	}
	
	function get_allkaryawan_list($query,$start,$end){
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
	
	function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group){
		
		switch($group){
			case "Tanggal": $order_by=" ORDER BY tanggal ASC";break;
			case "Customer": $order_by=" ORDER BY cust_nama ASC";break;
			case "Karyawan": $order_by=" ORDER BY cust_nama ASC";break;
			case "No Faktur": $order_by=" ORDER BY no_bukti ASC";break;
			case "Produk": $order_by=" ORDER BY produk_id,satuan_nama ASC";break;
			case "Sales": $order_by=" ORDER BY sales ASC";break;
			case "Jenis Diskon": $order_by=" ORDER BY diskon_jenis";break;
			case "Group 1": $order_by=" ORDER BY group_nama, produk_nama";break;
			default: $order_by=" ORDER BY no_bukti ASC";break;
		}
		
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT * FROM vu_trans_produk WHERE jproduk_stat_dok='Tertutup' ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT distinct * FROM vu_trans_produk WHERE jproduk_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT distinct * FROM vu_trans_produk WHERE jproduk_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
		}else if($opsi=='detail'){
			if($opsi_status=='semua') {			
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_jual_produk WHERE jproduk_stat_dok<>'Terbuka' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT vu_detail_jual_produk.*, produk_group.group_nama AS group_nama FROM vu_detail_jual_produk 
						left join produk_group on produk_group.group_id = vu_detail_jual_produk.produk_group
					WHERE jproduk_stat_dok<>'Terbuka' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT vu_detail_jual_produk.*, produk_group.group_nama AS group_nama FROM vu_detail_jual_produk 
						left join produk_group on produk_group.group_id = vu_detail_jual_produk.produk_group
					WHERE jproduk_stat_dok<>'Terbuka' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			} else if($opsi_status=='tertutup') {
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_jual_produk WHERE jproduk_stat_dok='Tertutup' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT vu_detail_jual_produk.*, produk_group.group_nama AS group_nama FROM vu_detail_jual_produk 
						left join produk_group on produk_group.group_id = vu_detail_jual_produk.produk_group
					WHERE jproduk_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT vu_detail_jual_produk.*, produk_group.group_nama AS group_nama FROM vu_detail_jual_produk 
						left join produk_group on produk_group.group_id = vu_detail_jual_produk.produk_group
					WHERE jproduk_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}
			//query untuk yang bpom
			if($group=="No Faktur BPOM"){
				$sql_bpom = "SELECT no_bukti FROM vu_detail_jual_produk left join produk_group on produk_group.group_id = vu_detail_jual_produk.produk_group WHERE jproduk_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' and vu_detail_jual_produk.produk_bpom = 0 ".$order_by;
				
				$sql= "SELECT data.* FROM ( ".$sql." ) data WHERE no_bukti NOT IN (".$sql_bpom.")";
			}
		}
		else if($opsi=='grooming'){
			if($periode=='all')
				$sql="SELECT * FROM vu_detail_jual_produk_grooming WHERE jproduk_stat_dok='Tertutup' AND jproduk_grooming <> 0 ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT * FROM vu_detail_jual_produk_grooming WHERE jproduk_stat_dok='Tertutup' AND jproduk_grooming <> 0 AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT * FROM vu_detail_jual_produk_grooming WHERE jproduk_stat_dok='Tertutup' AND jproduk_grooming <> 0 AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
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
		
	function get_produk_list($query,$start,$end,$aktif){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dproduk_produk FROM detail_jual_produk WHERE dproduk_master='$query'";
			$rs=$this->db->query($sql_dproduk);
			$rs_rows=$rs->num_rows();
		}
		
		if($aktif=='yes'){
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
		}else{
			$sql="select * from vu_produk";
		}
		
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' ) ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				foreach($rs->result() as $row_dproduk){
					
					$filter.="OR produk_id='".$row_dproduk->dproduk_produk."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if(($end!=0)  && ($aktif<>'yesno')){
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
	
	function get_satuan_bydjproduk_list($djproduk_id,$produk_id){
		if($djproduk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) LEFT JOIN detail_jual_produk ON(dproduk_produk=produk_id) LEFT JOIN master_jual_produk ON(dproduk_master=jproduk_id) WHERE jproduk_id='$djproduk_id'";
		
		if($produk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) WHERE produk_id='$produk_id'";
			
		if($djproduk_id==0 && $produk_id==0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM produk,satuan_konversi,satuan WHERE produk_id=konversi_produk AND konversi_satuan=satuan_id";
		//$sql="SELECT satuan_id,satuan_nama,satuan_kode FROM satuan";
		$query = $this->db->query($sql);
		$nbrows = $query->num_rows();
		if($nbrows>0){
			foreach($query->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}
	
	function get_satuan_byproduk_list($jproduk_id, $produk_id){
		$rs_rows=0;
		
		if($produk_id!=0 && is_numeric($produk_id)==true){
			$sql="SELECT satuan_id, satuan_nama, konversi_nilai, satuan_kode, konversi_default, produk_harga FROM satuan_konversi LEFT JOIN produk ON(konversi_produk=produk_id) LEFT JOIN satuan ON(konversi_satuan=satuan_id) WHERE konversi_produk='$produk_id'";
			$rs=$this->db->query($sql);
			$rs_rows=$rs->num_rows();
			if($produk_id<>"" && is_numeric($produk_id)==false){
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql.=" (satuan_nama like '%".$produk_id."%' or satuan_kode like '%".$produk_id."%') ";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			/*if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
			}*/
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}elseif($jproduk_id!=0 && is_numeric($jproduk_id)==true){
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM produk,satuan_konversi,satuan WHERE produk_id=konversi_produk AND konversi_satuan=satuan_id AND produk_id='$jproduk_id'";
			if($jproduk_id==0)
				$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM produk,satuan_konversi,satuan WHERE produk_id=konversi_produk AND konversi_satuan=satuan_id";
			$query = $this->db->query($sql);
			$nbrows = $query->num_rows();
			if($nbrows>0){
				foreach($query->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
	}
		
	//function for detail
	//get record list
	function detail_detail_jual_produk_list($master_id,$query,$start,$end) {
		//$query="SELECT *,konversi_nilai FROM detail_jual_produk LEFT JOIN satuan_konversi ON(dproduk_produk=konversi_produk AND dproduk_satuan=konversi_satuan) WHERE dproduk_master='".$master_id."'";
		
		$query = "SELECT detail_jual_produk.*,master_jual_produk.jproduk_bayar,master_jual_produk.jproduk_diskon,dproduk_harga*dproduk_jumlah as dproduk_subtotal,dproduk_harga*dproduk_jumlah*((100-dproduk_diskon)/100) as dproduk_subtotal_net, produk_point, dproduk_harga AS produk_harga_default FROM detail_jual_produk LEFT JOIN satuan_konversi ON(dproduk_produk=konversi_produk AND dproduk_satuan=konversi_satuan) LEFT JOIN master_jual_produk ON(dproduk_master=jproduk_id) LEFT JOIN produk ON(dproduk_produk=produk_id) WHERE dproduk_master='".$master_id."'";
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
		$query = "SELECT * FROM voucher,voucher_kupon where kvoucher_master=voucher_id";
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
	
	//get master id, note : not done yet
	function get_master_id() {
		$query = "SELECT max(jproduk_id) AS master_id FROM master_jual_produk WHERE jproduk_creator='".$_SESSION[SESSION_USERID]."'";
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
	
	function catatan_piutang_update($jproduk_id){
		/* INSERT db.master_lunas_piutang */
		/*$dti_lpiutang=array(
			"lpiutang_faktur"=>$jproduk_nobukti,
			"lpiutang_cust"=>$jproduk_cust,
			"lpiutang_faktur_tanggal"=>$jproduk_tanggal,
			"lpiutang_total"=>$piutang_total,
			"lpiutang_sisa"=>$piutang_total,
			"lpiutang_jenis_transaksi"=>'jual_produk',
			"lpiutang_stat_dok"=>'Terbuka'
		);
		$this->db->insert('master_lunas_piutang', $dti_lpiutang);
		if($this->db->affected_rows()){
			return 1;
		}*/
		$sql="SELECT * FROM vu_piutang_jproduk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$lpiutang_faktur=$rs_record["jproduk_nobukti"];
			$lpiutang_cust=$rs_record["jproduk_cust"];
			$lpiutang_faktur_tanggal=$rs_record["jproduk_tanggal"];
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
					"lpiutang_jenis_transaksi"=>'jual_produk',
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
				"lpiutang_jenis_transaksi"=>'jual_produk',
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
	
	function catatan_piutang_batal($jproduk_id){
		/* 1. Cari jproduk_nobukti
		 * 2. UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
		*/
		$datetime_now = date('Y-m-d H:i:s');
		
		$sql = "SELECT jproduk_nobukti FROM master_jual_produk WHERE jproduk_id='".$jproduk_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jproduk_nobukti = $record['jproduk_nobukti'];
			
			//UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
			$sqlu = "UPDATE master_lunas_piutang
				SET lpiutang_stat_dok='Batal'
					,lpiutang_update='".@$_SESSION[SESSION_USERID]."'
					,lpiutang_date_update='".$datetime_now."'
					,lpiutang_revised=(lpiutang_revised+1)
				WHERE lpiutang_faktur='".$jproduk_nobukti."'";
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
	
	function member_point_update($jproduk_id){
		$date_now=date('Y-m-d');
		
		$sqlu = "UPDATE master_jual_produk JOIN (SELECT vu_jproduk_total_point.jproduk_id, 
						vu_jproduk_total_point.jproduk_total_point
					FROM vu_jproduk_total_point
					WHERE vu_jproduk_total_point.jproduk_id = ".$jproduk_id."
					LIMIT 1) AS vu_jproduk_total_point_temp ON (vu_jproduk_total_point_temp.jproduk_id = master_jual_produk.jproduk_id)
			SET master_jual_produk.jproduk_point = vu_jproduk_total_point_temp.jproduk_total_point
			WHERE master_jual_produk.jproduk_id=".$jproduk_id;
		$this->db->query($sqlu);
		if($this->db->affected_rows()){
			$sqlu_cust = "UPDATE customer JOIN (SELECT vu_jproduk_total_point.jproduk_id,
							vu_jproduk_total_point.jproduk_cust,
							vu_jproduk_total_point.jproduk_total_point
						FROM vu_jproduk_total_point
						WHERE vu_jproduk_total_point.jproduk_id = ".$jproduk_id."
						LIMIT 1) AS vu_jproduk_total_point_temp 
				SET customer.cust_point = (customer.cust_point + vu_jproduk_total_point_temp.jproduk_total_point)
				WHERE vu_jproduk_total_point_temp.jproduk_cust = customer.cust_id";
			$this->db->query($sqlu_cust);
			if($this->db->affected_rows()>-1){
				return 1;
			}
		}else{
			return 1;
		}
		
	}
	
	function member_point_batal($jproduk_id){
		$sqlu = "UPDATE customer, master_jual_produk
			SET customer.cust_point = (customer.cust_point - jproduk_point)
			WHERE master_jual_produk.jproduk_id='".$jproduk_id."'
				AND customer.cust_id=master_jual_produk.jproduk_cust";
		$this->db->query($sqlu);
		if($this->db->affected_rows()>-1){
			return 1;
		}
	}
	
	function cara_bayar_batal($jproduk_id){
		//updating db.jual_card ==> pembatalan
		$sqlu_jcard = "UPDATE jual_card JOIN master_jual_produk ON(jual_card.jcard_ref=master_jual_produk.jproduk_nobukti)
			SET jual_card.jcard_stat_dok = master_jual_produk.jproduk_stat_dok
			WHERE master_jual_produk.jproduk_id='$jproduk_id'";
		$this->db->query($sqlu_jcard);
		if($this->db->affected_rows()>-1){
			//updating db.jual_cek ==> pembatalan
			$sqlu_jcek = "UPDATE jual_cek JOIN master_jual_produk ON(jual_cek.jcek_ref=master_jual_produk.jproduk_nobukti)
				SET jual_cek.jcek_stat_dok = master_jual_produk.jproduk_stat_dok
				WHERE master_jual_produk.jproduk_id='$jproduk_id'";
			$this->db->query($sqlu_jcek);
			if($this->db->affected_rows()>-1){
				//updating db.jual_kwitansi ==> pembatalan
				$sqlu_jkwitansi = "UPDATE jual_kwitansi JOIN master_jual_produk ON(jual_kwitansi.jkwitansi_ref=master_jual_produk.jproduk_nobukti)
					SET jual_kwitansi.jkwitansi_stat_dok = master_jual_produk.jproduk_stat_dok
					WHERE master_jual_produk.jproduk_id='$jproduk_id'";
				$this->db->query($sqlu_jkwitansi);
				if($this->db->affected_rows()>-1){
					/* UPDATE db.cetak_kwitansi.kwitansi_sisa <== dikembalikan sesuai dengan nilai kwitansi yg diambil di Faktur ini. */
					$sql = "SELECT jkwitansi_master
						FROM jual_kwitansi
						JOIN master_jual_produk ON(jkwitansi_ref=jproduk_nobukti)
						WHERE jproduk_id='".$jproduk_id."'";
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
					$sqlu_jtransfer = "UPDATE jual_transfer JOIN master_jual_produk ON(jual_transfer.jtransfer_ref=master_jual_produk.jproduk_nobukti)
						SET jual_transfer.jtransfer_stat_dok = master_jual_produk.jproduk_stat_dok
						WHERE master_jual_produk.jproduk_id='$jproduk_id'";
					$this->db->query($sqlu_jtransfer);
					if($this->db->affected_rows()>-1){
						//updating db.jual_tunai ==> pembatalan
						$sqlu_jtunai = "UPDATE jual_tunai JOIN master_jual_produk ON(jual_tunai.jtunai_ref=master_jual_produk.jproduk_nobukti)
							SET jual_tunai.jtunai_stat_dok = master_jual_produk.jproduk_stat_dok
							WHERE master_jual_produk.jproduk_id='$jproduk_id'";
						$this->db->query($sqlu_jtunai);
						if($this->db->affected_rows()>-1){
							//updating db.voucher_terima ==> pembatalan
							$sqlu_tvoucher = "UPDATE voucher_terima JOIN master_jual_produk ON(voucher_terima.tvoucher_ref=master_jual_produk.jproduk_nobukti)
								SET voucher_terima.tvoucher_stat_dok = master_jual_produk.jproduk_stat_dok
								WHERE master_jual_produk.jproduk_id='$jproduk_id'";
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
	
	function membership_insert($jproduk_id){
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
		
		$sql="SELECT jproduk_cust
				,jproduk_tanggal
			FROM master_jual_produk
			WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$cust_id = $rs_record['jproduk_cust'];
			$tanggal_transaksi = $rs_record['jproduk_tanggal'];
			
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
				WHERE jproduk_cust='".$cust_id."'
					AND jproduk_tanggal='".$tanggal_transaksi."'
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
				WHERE jpaket_cust='".$cust_id."'
					AND jpaket_tanggal='".$tanggal_transaksi."'
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
				WHERE jrawat_cust='".$cust_id."'
					AND jrawat_tanggal='".$tanggal_transaksi."'
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
			
			$sql="SELECT member_cust, 
					member_valid, 
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
					
					if(($cust_total_trans_now >= $min_trans_tenggang) || ($cust_total_point >= $setmember_pointhari)){
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
		}else{
			return 1;
		}
	}
	
	function stat_dok_tertutup_update($jproduk_id){
		$date_now = date('Y-m-d');
		$datetime_now = date('Y-m-d H:i:s');
		//* status dokumen menjadi tertutup setelah Faktur selesai di-cetak_jproduk /
		$sql = "SELECT jproduk_tanggal FROM master_jual_produk WHERE jproduk_id='".$jproduk_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jproduk_tanggal = $record['jproduk_tanggal'];
			/*
			if($jproduk_tanggal<>$date_now){
				$jproduk_date_update = $jproduk_tanggal;
			}else{
				$jproduk_date_update = $datetime_now;
			}
			*/
			
			$sql="UPDATE master_jual_produk
				SET jproduk_stat_dok='Tertutup'
					,jproduk_update='".@$_SESSION[SESSION_USERID]."'
					,jproduk_date_update='".$datetime_now."'
					,jproduk_revised=jproduk_revised+1
				WHERE jproduk_id='".$jproduk_id."'";
			$this->db->query($sql);
			if($this->db->affected_rows()>-1){
				return 1;
			}
		}else{
			return 1;
		}
	}
	
	//insert detail record
	function detail_detail_jual_produk_insert($array_dproduk_id ,$dproduk_master ,$array_dproduk_karyawan ,$array_dproduk_produk
											  ,$array_dproduk_satuan ,$array_dproduk_jumlah ,$array_dproduk_harga
											  ,$array_dproduk_diskon ,$array_dproduk_diskon_jenis ,$cetak_jproduk){
		$date_now=date('Y-m-d');
		
		$size_array = sizeof($array_dproduk_produk) - 1;
		
		for($i = 0; $i < sizeof($array_dproduk_produk); $i++){
			$dproduk_id = $array_dproduk_id[$i];
			$dproduk_karyawan = $array_dproduk_karyawan[$i];
			$dproduk_produk = $array_dproduk_produk[$i];
			$dproduk_satuan = $array_dproduk_satuan[$i];
			$dproduk_jumlah = $array_dproduk_jumlah[$i];
			$dproduk_harga = $array_dproduk_harga[$i];
			$dproduk_diskon = $array_dproduk_diskon[$i];
			$dproduk_diskon_jenis = $array_dproduk_diskon_jenis[$i];
			
			$sql = "SELECT produk_point AS produk_point
				FROM detail_jual_produk
					JOIN produk ON(dproduk_produk=produk_id)
				WHERE dproduk_id='".$dproduk_id."'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$produk_point = $record['produk_point'];
				//* artinya: detail produk ini sudah diinsertkan ke db.detail_jual_produk /
				$dtu_dproduk = array(
					"dproduk_produk"=>$dproduk_produk,
					"dproduk_set_point"=>$produk_point,
					"dproduk_karyawan"=>$dproduk_karyawan,
					"dproduk_satuan"=>$dproduk_satuan, 
					"dproduk_jumlah"=>$dproduk_jumlah, 
					"dproduk_harga"=>$dproduk_harga, 
					"dproduk_diskon"=>$dproduk_diskon,
					"dproduk_diskon_jenis"=>$dproduk_diskon_jenis,
					"dproduk_creator"=>@$_SESSION[SESSION_USERID]
				);
				$this->db->query('LOCK TABLE detail_jual_produk WRITE');
				$this->db->where('dproduk_id', $dproduk_id);
				$this->db->update('detail_jual_produk', $dtu_dproduk);
				$this->db->query('UNLOCK TABLES');
			}else{
				$sql_produk = "SELECT produk_point AS produk_point FROM produk WHERE produk_id='".$dproduk_produk."'";
				$rs_produk = $this->db->query($sql_produk);
				$record_produk = $rs_produk->row_array();
				$produk_point = $record_produk['produk_point'];
				//* artinya: detail produk ini adalah penambahan detail baru /
				$dti_jproduk = array(
					"dproduk_master"=>$dproduk_master, 
					"dproduk_produk"=>$dproduk_produk,
					"dproduk_set_point"=>$produk_point,
					"dproduk_karyawan"=>$dproduk_karyawan,
					"dproduk_satuan"=>$dproduk_satuan, 
					"dproduk_jumlah"=>$dproduk_jumlah, 
					"dproduk_harga"=>$dproduk_harga, 
					"dproduk_diskon"=>$dproduk_diskon,
					"dproduk_diskon_jenis"=>$dproduk_diskon_jenis,
					"dproduk_creator"=>@$_SESSION[SESSION_USERID]
				);
				$this->db->query('LOCK TABLE detail_jual_produk WRITE');
				$this->db->insert('detail_jual_produk', $dti_jproduk);
				$this->db->query('UNLOCK TABLES');
			}
			
			if(($cetak_jproduk==1 || $cetak_jproduk==2) && $i==$size_array){
				/*proses cetak_jproduk*/
				$rs_stat_dok = $this->stat_dok_tertutup_update($dproduk_master);
				if($rs_stat_dok==1){
					$rs_point_update = $this->member_point_update($dproduk_master);
					if($rs_point_update==1){
						$rs_membership = $this->membership_insert($dproduk_master);
						if($rs_membership==1){
							$rs_piutang_update = $this->catatan_piutang_update($dproduk_master);
							if($rs_piutang_update==1){
								return $dproduk_master;
							}else{
								return '0';
							}
						}else{
							return 0;
						}
					}else{
						return 0;
					}
				}else{
					return 0;
				}
				
			}else if(($cetak_jproduk<>1 || $cetak_jproduk<>2) && $i==$size_array){
				return 0;
			}
			
		}
		
	}
	//end of function
	
	//function for get list record
	function master_jual_produk_list($filter,$start,$end){
		$date_now=date('Y-m-d');

		$query = "SELECT jproduk_id
				,jproduk_nobukti
				,jproduk_nobukti_pajak
				,karyawan_no
				,karyawan_nama
				,CONCAT(cust_nama, ' (', cust_no, ')') as cust_nama_edit
				,cust_nama
				,cust_no
				,cust_priority_star
				,cust_member
				,member_no
				,member_valid
				,jproduk_cust
				,jproduk_tanggal
				,jproduk_diskon
				,jproduk_cashback
				,jproduk_cara
				,jproduk_cara2
				,jproduk_cara3
				,jproduk_bayar
				,IF(vu_jproduk.jproduk_totalbiaya!=0, vu_jproduk.jproduk_totalbiaya, vu_jproduk_totalbiaya.jproduk_totalbiaya) AS jproduk_totalbiaya
				,jproduk_keterangan
				,jproduk_ket_disk
				,jproduk_stat_dok
				,jproduk_creator
				,jproduk_date_create
				,jproduk_update
				,jproduk_date_update
				,jproduk_revised
			FROM vu_jproduk
			LEFT JOIN vu_jproduk_totalbiaya ON(vu_jproduk_totalbiaya.dproduk_master=vu_jproduk.jproduk_id)
			LEFT JOIN karyawan ON(karyawan.karyawan_id = vu_jproduk.jproduk_grooming)";
		
		// For simple search
		if ($filter<>""){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (jproduk_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' )";
		}
		//normal LIST by Hendri
		else {
			$query .= eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " date_format(jproduk_date_create,'%Y-%m-%d')='$date_now'";
		}
		
		$query .= " ORDER BY jproduk_nobukti DESC";
		
		$query_nbrows="SELECT jproduk_id, karyawan_no, karyawan_nama FROM master_jual_produk 
						LEFT JOIN customer ON(jproduk_cust=cust_id)
						LEFT JOIN karyawan ON(karyawan.karyawan_id = master_jual_produk .jproduk_grooming)";
		// For simple search
		if ($filter<>""){
			$query_nbrows .=eregi("WHERE",$query_nbrows)? " AND ":" WHERE ";
			$query_nbrows .= " (jproduk_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' )";
		}
		else {
			$query_nbrows .= eregi("WHERE",$query_nbrows)? " AND ":" WHERE ";
			$query_nbrows .= " date_format(jproduk_date_create,'%Y-%m-%d')='$date_now'";
		}
		
		$result2 = $this->db->query($query_nbrows);
		$nbrows = $result2->num_rows();
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
	function master_jual_produk_update($jproduk_id ,$jproduk_nobukti ,$jproduk_cust ,$jproduk_tanggal ,$jproduk_stat_dok ,$jproduk_diskon
									   ,$jproduk_cara ,$jproduk_cara2 ,$jproduk_cara3 ,$jproduk_keterangan ,$jproduk_cashback
									   ,$jproduk_tunai_nilai ,$jproduk_tunai_nilai2 ,$jproduk_tunai_nilai3 ,$jproduk_voucher_no
									   ,$jproduk_voucher_cashback ,$jproduk_voucher_no2 ,$jproduk_voucher_cashback2 ,$jproduk_voucher_no3
									   ,$jproduk_voucher_cashback3 ,$jproduk_bayar ,$jproduk_subtotal ,$jproduk_total ,$jproduk_hutang
									   ,$jproduk_kwitansi_no ,$jproduk_kwitansi_nama ,$jproduk_kwitansi_nilai ,$jproduk_kwitansi_no2
									   ,$jproduk_kwitansi_nama2 ,$jproduk_kwitansi_nilai2 ,$jproduk_kwitansi_no3 ,$jproduk_kwitansi_nama3
									   ,$jproduk_kwitansi_nilai3 ,$jproduk_card_nama ,$jproduk_card_edc ,$jproduk_card_no ,$jproduk_card_nilai
									   ,$jproduk_card_nama2 ,$jproduk_card_edc2 ,$jproduk_card_no2 ,$jproduk_card_nilai2 ,$jproduk_card_nama3
									   ,$jproduk_card_edc3 ,$jproduk_card_no3 ,$jproduk_card_nilai3 ,$jproduk_cek_nama ,$jproduk_cek_no
									   ,$jproduk_cek_valid ,$jproduk_cek_bank ,$jproduk_cek_nilai ,$jproduk_cek_nama2 ,$jproduk_cek_no2
									   ,$jproduk_cek_valid2 ,$jproduk_cek_bank2 ,$jproduk_cek_nilai2 ,$jproduk_cek_nama3 ,$jproduk_cek_no3
									   ,$jproduk_cek_valid3 ,$jproduk_cek_bank3 ,$jproduk_cek_nilai3 ,$jproduk_transfer_bank
									   ,$jproduk_transfer_nama ,$jproduk_transfer_nilai ,$jproduk_transfer_bank2 ,$jproduk_transfer_nama2
									   ,$jproduk_transfer_nilai2 ,$jproduk_transfer_bank3 ,$jproduk_transfer_nama3 ,$jproduk_transfer_nilai3
									   ,$cetak_jproduk ,$jproduk_ket_disk
									   ,$array_dproduk_id ,$array_dproduk_produk ,$array_dproduk_satuan
									   ,$array_dproduk_jumlah ,$array_dproduk_harga ,$array_dproduk_diskon_jenis
									   ,$array_dproduk_diskon ,$array_dproduk_karyawan, $jproduk_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3, $jproduk_nobukti_pajak){
		$date_now = date('Y-m-d');
		$datetime_now=date('Y-m-d H:i:s');
		
		$jproduk_revised=0;
		
		$jenis_transaksi = 'jual_produk';
		$bayar_date_create = $datetime_now;
		
		$sql="SELECT jproduk_revised FROM master_jual_produk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$jproduk_revised=$rs_record["jproduk_revised"];
		}
				
		// GENERATE NOBUKTI_PAJAK
			$pattern="010.000-".date("y").".";		
			$jproduk_nobukti_pajak = $this->m_public_function->get_kode_pajak($pattern, 19);
		
		if($cetak_jproduk==1){
			$jproduk_nobukti_pajak = '-';
		}
		
		$data = array(
			"jproduk_nobukti"=>$jproduk_nobukti, 
			"jproduk_nobukti_pajak"=>$jproduk_nobukti_pajak, 
			"jproduk_tanggal"=>$jproduk_tanggal, 
			"jproduk_diskon"=>$jproduk_diskon,
			"jproduk_cashback"=>$jproduk_cashback,
			"jproduk_bayar"=>$jproduk_bayar,
			"jproduk_totalbiaya"=>$jproduk_total,
			"jproduk_cara"=>$jproduk_cara,
			"jproduk_keterangan"=>$jproduk_keterangan,
			"jproduk_ket_disk"=>$jproduk_ket_disk,
			"jproduk_update"=>@$_SESSION[SESSION_USERID],
			"jproduk_date_update"=>$datetime_now,
			"jproduk_revised"=>$jproduk_revised+1
		);
		
		if($cetak_jproduk==1 || $cetak_jproduk==2){
			$data['jproduk_stat_dok'] = 'Tertutup';
		}else{
			$data['jproduk_stat_dok'] = 'Terbuka';
		}
		
		/* membuat date update ikut tanggal yang dipilih
		if($jproduk_tanggal<>$date_now){
			$data["jproduk_date_update"] = $jproduk_tanggal;
		}else{
			$data["jproduk_date_update"] = $datetime_now;
		}
		*/
		$data["jproduk_date_update"] = $datetime_now;
		
		if($jproduk_cara2!=null){
			if(($jproduk_kwitansi_nilai2<>'' && $jproduk_kwitansi_nilai2<>0)
			   || ($jproduk_card_nilai2<>'' && $jproduk_card_nilai2<>0)
			   || ($jproduk_cek_nilai2<>'' && $jproduk_cek_nilai2<>0)
			   || ($jproduk_transfer_nilai2<>'' && $jproduk_transfer_nilai2<>0)
			   || ($jproduk_tunai_nilai2<>'' && $jproduk_tunai_nilai2<>0)
			   || ($jproduk_voucher_cashback2<>'' && $jproduk_voucher_cashback2<>0)){
				$data["jproduk_cara2"]=$jproduk_cara2;
			}else{
				$data["jproduk_cara2"]=NULL;
			}
		}
		if($jproduk_cara3!=null){
			if(($jproduk_kwitansi_nilai3<>'' && $jproduk_kwitansi_nilai3<>0)
			   || ($jproduk_card_nilai3<>'' && $jproduk_card_nilai3<>0)
			   || ($jproduk_cek_nilai3<>'' && $jproduk_cek_nilai3<>0)
			   || ($jproduk_transfer_nilai3<>'' && $jproduk_transfer_nilai3<>0)
			   || ($jproduk_tunai_nilai3<>'' && $jproduk_tunai_nilai3<>0)
			   || ($jproduk_voucher_cashback3<>'' && $jproduk_voucher_cashback3<>0)){
				$data["jproduk_cara3"]=$jproduk_cara3;
			}else{
				$data["jproduk_cara3"]=NULL;
			}
		}
		
		$this->db->query('LOCK TABLE master_jual_produk WRITE');
		$this->db->where('jproduk_id', $jproduk_id);
		$this->db->update('master_jual_produk', $data);
		$rs = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($rs>(-1)){
			/*
			if(($cetak_jproduk==1) && ($piutang_total>0)){
				$this->catatan_piutang_update($jproduk_nobukti ,$jproduk_cust ,$jproduk_tanggal ,$piutang_total);
			}*/
			
			$time_now = date('H:i:s');
			$bayar_date_create_temp = $jproduk_tanggal.' '.$time_now;
			$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
			
			//delete all transaksi
			//$sql="delete from jual_kwitansi where jkwitansi_ref='".$jproduk_nobukti."'";
			//$this->db->query($sql);
			if($this->db->affected_rows()>-1){
				$sql="delete from jual_card where jcard_ref='".$jproduk_nobukti."'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_cek where jcek_ref='".$jproduk_nobukti."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_transfer where jtransfer_ref='".$jproduk_nobukti."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_tunai where jtunai_ref='".$jproduk_nobukti."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								$sql="delete from voucher_terima where tvoucher_ref='".$jproduk_nobukti."'";
								$this->db->query($sql);
								if($this->db->affected_rows()>-1){
									if($jproduk_cara!=null || $jproduk_cara!=''){
										if($jproduk_kwitansi_nilai<>'' && $jproduk_kwitansi_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no
																							  ,$jproduk_kwitansi_nilai
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id);
											
										}elseif($jproduk_card_nilai<>'' && $jproduk_card_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama
																						  ,$jproduk_card_edc
																						  ,$jproduk_card_no
																						  ,$jproduk_card_nilai
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai<>'' && $jproduk_cek_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_cek_insert($jproduk_cust
																						 ,$jproduk_cek_nama
																						 ,$jproduk_cek_no
																						 ,$jproduk_cek_valid
																						 ,$jproduk_cek_bank
																						 ,$jproduk_cek_nilai
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai<>'' && $jproduk_transfer_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank
																							  ,$jproduk_transfer_nama
																							  ,$jproduk_transfer_nilai
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai<>'' && $jproduk_tunai_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback<>'' && $jproduk_voucher_cashback<>0){
											$result_bayar = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
									if($jproduk_cara2!=null || $jproduk_cara2!=''){
										if($jproduk_kwitansi_nilai2<>'' && $jproduk_kwitansi_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no2
																							  ,$jproduk_kwitansi_nilai2
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id2);
											
										}elseif($jproduk_card_nilai2<>'' && $jproduk_card_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama2
																						  ,$jproduk_card_edc2
																						  ,$jproduk_card_no2
																						  ,$jproduk_card_nilai2
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai2<>'' && $jproduk_cek_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_cek_insert($jproduk_cust
																						 ,$jproduk_cek_nama2
																						 ,$jproduk_cek_no2
																						 ,$jproduk_cek_valid2
																						 ,$jproduk_cek_bank2
																						 ,$jproduk_cek_nilai2
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai2<>'' && $jproduk_transfer_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank2
																							  ,$jproduk_transfer_nama2
																							  ,$jproduk_transfer_nilai2
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai2<>'' && $jproduk_tunai_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai2
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback2<>'' && $jproduk_voucher_cashback2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no2
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback2
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
									if($jproduk_cara3!=null || $jproduk_cara3!=''){
										if($jproduk_kwitansi_nilai3<>'' && $jproduk_kwitansi_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no3
																							  ,$jproduk_kwitansi_nilai3
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id3);
											
										}elseif($jproduk_card_nilai3<>'' && $jproduk_card_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama3
																						  ,$jproduk_card_edc3
																						  ,$jproduk_card_no3
																						  ,$jproduk_card_nilai3
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai3<>'' && $jproduk_cek_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_cek_insert($jproduk_cust
																						 ,$jproduk_cek_nama3
																						 ,$jproduk_cek_no3
																						 ,$jproduk_cek_valid3
																						 ,$jproduk_cek_bank3
																						 ,$jproduk_cek_nilai3
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai3<>'' && $jproduk_transfer_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank3
																							  ,$jproduk_transfer_nama3
																							  ,$jproduk_transfer_nilai3
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai3<>'' && $jproduk_tunai_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai3
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback3<>'' && $jproduk_voucher_cashback3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no3
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback3
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
								}
							}
						}
					}
				}
			}
			
			$rs_dproduk_insert = $this->detail_detail_jual_produk_insert($array_dproduk_id ,$jproduk_id ,$array_dproduk_karyawan ,$array_dproduk_produk
																		 ,$array_dproduk_satuan ,$array_dproduk_jumlah ,$array_dproduk_harga
																		 ,$array_dproduk_diskon ,$array_dproduk_diskon_jenis ,$cetak_jproduk);
			
			return $rs_dproduk_insert;
		}
		else
			return '-1';
	}
	
	//function for create new record
	function master_jual_produk_create($jproduk_nobukti ,$jproduk_cust ,$jproduk_tanggal ,$jproduk_stat_dok ,$jproduk_diskon
									   ,$jproduk_cara ,$jproduk_cara2 ,$jproduk_cara3 ,$jproduk_keterangan ,$jproduk_cashback
									   ,$jproduk_tunai_nilai ,$jproduk_tunai_nilai2 ,$jproduk_tunai_nilai3 ,$jproduk_voucher_no
									   ,$jproduk_voucher_cashback ,$jproduk_voucher_no2 ,$jproduk_voucher_cashback2 ,$jproduk_voucher_no3
									   ,$jproduk_voucher_cashback3 ,$jproduk_bayar ,$jproduk_subtotal ,$jproduk_total ,$jproduk_hutang
									   ,$jproduk_kwitansi_no ,$jproduk_kwitansi_nama ,$jproduk_kwitansi_nilai ,$jproduk_kwitansi_no2
									   ,$jproduk_kwitansi_nama2 ,$jproduk_kwitansi_nilai2 ,$jproduk_kwitansi_no3 ,$jproduk_kwitansi_nama3
									   ,$jproduk_kwitansi_nilai3 ,$jproduk_card_nama ,$jproduk_card_edc ,$jproduk_card_no ,$jproduk_card_nilai
									   ,$jproduk_card_nama2 ,$jproduk_card_edc2 ,$jproduk_card_no2 ,$jproduk_card_nilai2 ,$jproduk_card_nama3
									   ,$jproduk_card_edc3 ,$jproduk_card_no3 ,$jproduk_card_nilai3 ,$jproduk_cek_nama ,$jproduk_cek_no
									   ,$jproduk_cek_valid ,$jproduk_cek_bank ,$jproduk_cek_nilai ,$jproduk_cek_nama2 ,$jproduk_cek_no2
									   ,$jproduk_cek_valid2 ,$jproduk_cek_bank2 ,$jproduk_cek_nilai2 ,$jproduk_cek_nama3 ,$jproduk_cek_no3
									   ,$jproduk_cek_valid3 ,$jproduk_cek_bank3 ,$jproduk_cek_nilai3 ,$jproduk_transfer_bank
									   ,$jproduk_transfer_nama ,$jproduk_transfer_nilai ,$jproduk_transfer_bank2 ,$jproduk_transfer_nama2
									   ,$jproduk_transfer_nilai2 ,$jproduk_transfer_bank3 ,$jproduk_transfer_nama3 ,$jproduk_transfer_nilai3
									   ,$cetak_jproduk ,$jproduk_ket_disk
									   ,$array_dproduk_id ,$array_dproduk_produk ,$array_dproduk_satuan
									   ,$array_dproduk_jumlah ,$array_dproduk_harga ,$array_dproduk_diskon_jenis
									   ,$array_dproduk_diskon ,$array_dproduk_karyawan, $jproduk_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3){
		$date_now = date('Y-m-d');
		$datetime_now = date('Y-m-d H:i:s');
		
		$jproduk_tanggal_pattern=strtotime($jproduk_tanggal);
		$pattern="FT/".date("ym",$jproduk_tanggal_pattern)."-";
		$jproduk_nobukti=$this->m_public_function->get_kode_1('master_jual_produk','jproduk_nobukti',$pattern,12);
		
		$jenis_transaksi = 'jual_produk';
		
		if($cetak_jproduk==1 || $cetak_jproduk==0){
			$jproduk_nobukti_pajak = '-';		
		}else if($cetak_jproduk==2){
				$pattern="010.000-".date("y").".";		
			$jproduk_nobukti_pajak = $this->m_public_function->get_kode_pajak($pattern, 19);
		}		
		
		$data = array(
			"jproduk_nobukti"=>$jproduk_nobukti, 
			"jproduk_nobukti_pajak"=>$jproduk_nobukti_pajak, 
			"jproduk_cust"=>$jproduk_cust, 
			"jproduk_grooming"=>$jproduk_grooming,
			"jproduk_tanggal"=>$jproduk_tanggal, 
			"jproduk_diskon"=>$jproduk_diskon, 
			"jproduk_cashback"=>$jproduk_cashback,
			"jproduk_bayar"=>$jproduk_bayar,
			"jproduk_totalbiaya"=>$jproduk_total,
			"jproduk_cara"=>$jproduk_cara,
			"jproduk_keterangan"=>$jproduk_keterangan,
			"jproduk_ket_disk"=>$jproduk_ket_disk,
			"jproduk_creator"=>$_SESSION[SESSION_USERID]
		);
		
		if($cetak_jproduk==1 || $cetak_jproduk==2){
			$data['jproduk_stat_dok'] = 'Tertutup';
		}else{
			$data['jproduk_stat_dok'] = 'Terbuka';
		}
		
		/* membuat date create menjadi sesuai tanggal yg dipilih
		if($jproduk_tanggal<>$date_now){
			$data["jproduk_date_create"] = $jproduk_tanggal;
		}
		*/
		
		$data["jproduk_date_create"] = $datetime_now;
		
		if($jproduk_cara2!=null){
			if(($jproduk_kwitansi_nilai2<>'' && $jproduk_kwitansi_nilai2<>0)
			   || ($jproduk_card_nilai2<>'' && $jproduk_card_nilai2<>0)
			   || ($jproduk_cek_nilai2<>'' && $jproduk_cek_nilai2<>0)
			   || ($jproduk_transfer_nilai2<>'' && $jproduk_transfer_nilai2<>0)
			   || ($jproduk_tunai_nilai2<>'' && $jproduk_tunai_nilai2<>0)
			   || ($jproduk_voucher_cashback2<>'' && $jproduk_voucher_cashback2<>0)){
				$data["jproduk_cara2"]=$jproduk_cara2;
			}else{
				$data["jproduk_cara2"]=NULL;
			}
		}
		if($jproduk_cara3!=null){
			if(($jproduk_kwitansi_nilai3<>'' && $jproduk_kwitansi_nilai3<>0)
			   || ($jproduk_card_nilai3<>'' && $jproduk_card_nilai3<>0)
			   || ($jproduk_cek_nilai3<>'' && $jproduk_cek_nilai3<>0)
			   || ($jproduk_transfer_nilai3<>'' && $jproduk_transfer_nilai3<>0)
			   || ($jproduk_tunai_nilai3<>'' && $jproduk_tunai_nilai3<>0)
			   || ($jproduk_voucher_cashback3<>'' && $jproduk_voucher_cashback3<>0)){
				$data["jproduk_cara3"]=$jproduk_cara3;
			}else{
				$data["jproduk_cara3"]=NULL;
			}
		}
		$this->db->query('LOCK TABLE master_jual_produk WRITE');
		$this->db->insert('master_jual_produk', $data);
		$jproduk_id = $this->db->insert_id();
		$rs = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($rs>0){
			/*
			if(($cetak_jproduk==1) && ($piutang_total>0)){
				$this->catatan_piutang_update($jproduk_nobukti ,$jproduk_cust ,$jproduk_tanggal ,$piutang_total);
			}*/
			
			$time_now = date('H:i:s');
			$bayar_date_create_temp = $jproduk_tanggal.' '.$time_now;
			$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
			
			//delete all transaksi
			//$sql="delete from jual_kwitansi where jkwitansi_ref='".$jproduk_nobukti."'";
			//$this->db->query($sql);
			if($this->db->affected_rows()>-1){
				$sql="delete from jual_card where jcard_ref='".$jproduk_nobukti."'";
				$this->db->query($sql);
				if($this->db->affected_rows()>-1){
					$sql="delete from jual_cek where jcek_ref='".$jproduk_nobukti."'";
					$this->db->query($sql);
					if($this->db->affected_rows()>-1){
						$sql="delete from jual_transfer where jtransfer_ref='".$jproduk_nobukti."'";
						$this->db->query($sql);
						if($this->db->affected_rows()>-1){
							$sql="delete from jual_tunai where jtunai_ref='".$jproduk_nobukti."'";
							$this->db->query($sql);
							if($this->db->affected_rows()>-1){
								$sql="delete from voucher_terima where tvoucher_ref='".$jproduk_nobukti."'";
								$this->db->query($sql);
								if($this->db->affected_rows()>-1){
									if($jproduk_cara!=null || $jproduk_cara!=''){
										if($jproduk_kwitansi_nilai<>'' && $jproduk_kwitansi_nilai<>0){							
											$result_bayar = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no
																							  ,$jproduk_kwitansi_nilai
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id);
											
										}elseif($jproduk_card_nilai<>'' && $jproduk_card_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama
																						  ,$jproduk_card_edc
																						  ,$jproduk_card_no
																						  ,$jproduk_card_nilai
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai<>'' && $jproduk_cek_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_cek_insert($jproduk_cek_nama
																						 ,$jproduk_cek_no
																						 ,$jproduk_cek_valid
																						 ,$jproduk_cek_bank
																						 ,$jproduk_cek_nilai
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai<>'' && $jproduk_transfer_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank
																							  ,$jproduk_transfer_nama
																							  ,$jproduk_transfer_nilai
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai<>'' && $jproduk_tunai_nilai<>0){
											$result_bayar = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback<>'' && $jproduk_voucher_cashback<>0){
											$result_bayar = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
									if($jproduk_cara2!=null || $jproduk_cara2!=''){
										if($jproduk_kwitansi_nilai2<>'' && $jproduk_kwitansi_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no2
																							  ,$jproduk_kwitansi_nilai2
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id2);
											
										}elseif($jproduk_card_nilai2<>'' && $jproduk_card_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama2
																						  ,$jproduk_card_edc2
																						  ,$jproduk_card_no2
																						  ,$jproduk_card_nilai2
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai2<>'' && $jproduk_cek_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_cek_insert($jproduk_cek_nama2
																						 ,$jproduk_cek_no2
																						 ,$jproduk_cek_valid2
																						 ,$jproduk_cek_bank2
																						 ,$jproduk_cek_nilai2
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai2<>'' && $jproduk_transfer_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank2
																							  ,$jproduk_transfer_nama2
																							  ,$jproduk_transfer_nilai2
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai2<>'' && $jproduk_tunai_nilai2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai2
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback2<>'' && $jproduk_voucher_cashback2<>0){
											$result_bayar2 = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no2
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback2
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
									if($jproduk_cara3!=null || $jproduk_cara3!=''){
										if($jproduk_kwitansi_nilai3<>'' && $jproduk_kwitansi_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_kwitansi_insert($jproduk_kwitansi_no3
																							  ,$jproduk_kwitansi_nilai3
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk
																							  ,$jual_kwitansi_id3);
											
										}elseif($jproduk_card_nilai3<>'' && $jproduk_card_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_card_insert($jproduk_card_nama3
																						  ,$jproduk_card_edc3
																						  ,$jproduk_card_no3
																						  ,$jproduk_card_nilai3
																						  ,$jproduk_nobukti
																						  ,$bayar_date_create
																						  ,$jenis_transaksi
																						  ,$cetak_jproduk);
										}elseif($jproduk_cek_nilai3<>'' && $jproduk_cek_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_cek_insert($jproduk_cek_nama3
																						 ,$jproduk_cek_no3
																						 ,$jproduk_cek_valid3
																						 ,$jproduk_cek_bank3
																						 ,$jproduk_cek_nilai3
																						 ,$jproduk_nobukti
																						 ,$bayar_date_create
																						 ,$jenis_transaksi
																						 ,$cetak_jproduk);
										}elseif($jproduk_transfer_nilai3<>'' && $jproduk_transfer_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_transfer_insert($jproduk_transfer_bank3
																							  ,$jproduk_transfer_nama3
																							  ,$jproduk_transfer_nilai3
																							  ,$jproduk_nobukti
																							  ,$bayar_date_create
																							  ,$jenis_transaksi
																							  ,$cetak_jproduk);
										}elseif($jproduk_tunai_nilai3<>'' && $jproduk_tunai_nilai3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_tunai_insert($jproduk_tunai_nilai3
																						   ,$jproduk_nobukti
																						   ,$bayar_date_create
																						   ,$jenis_transaksi
																						   ,$cetak_jproduk);
										}elseif($jproduk_voucher_cashback3<>'' && $jproduk_voucher_cashback3<>0){
											$result_bayar3 = $this->m_public_function->cara_bayar_voucher_insert($jproduk_voucher_no3
																							 ,$jproduk_nobukti
																							 ,$jproduk_voucher_cashback3
																							 ,$bayar_date_create
																							 ,$jenis_transaksi
																							 ,$cetak_jproduk);
										}
									}
								}
							}
						}
					}
				}
			}
			
			$rs_dproduk_insert = $this->detail_detail_jual_produk_insert($array_dproduk_id ,$jproduk_id ,$array_dproduk_karyawan ,$array_dproduk_produk
																		 ,$array_dproduk_satuan ,$array_dproduk_jumlah ,$array_dproduk_harga
																		 ,$array_dproduk_diskon ,$array_dproduk_diskon_jenis ,$cetak_jproduk);
			
			return $rs_dproduk_insert;
		}
		else
			return '-1';
	}
	
	//fcuntion for delete record
	function master_jual_produk_delete($pkid){
		// You could do some checkups here and return '0' or other error consts.
		// Make a single query to delete all of the master_jual_produks at the same time :
		if(sizeof($pkid)<1){
			return '0';
		} else if (sizeof($pkid) == 1){
			$query = "DELETE FROM master_jual_produk WHERE jproduk_id = ".$pkid[0];
			$this->db->query($query);
		} else {
			$query = "DELETE FROM master_jual_produk WHERE ";
			for($i = 0; $i < sizeof($pkid); $i++){
				$query = $query . "jproduk_id= ".$pkid[$i];
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
	
	//Delete detail_jual_produk
	function detail_jual_produk_delete($dproduk_id){
		$query = "DELETE FROM detail_jual_produk WHERE dproduk_id = ".$dproduk_id;
		$this->db->query($query);
		if($this->db->affected_rows()>0)
			return '1';
		else
			return '0';
	}
	
	function master_jual_produk_batal($jproduk_id, $jproduk_tanggal){
		$date = date('Y-m-d');
		$date_1 = '01';
		$date_2 = '02';
		$date_3 = '03';
		$month = substr($jproduk_tanggal,5,2);
		$year = substr($jproduk_tanggal,0,4);
		$begin=mktime(0,0,0,$month,1,$year);
		$nextmonth=strtotime("+1month",$begin);
		
		$month_next = substr(date("Y-m-d",$nextmonth),5,2);
		$year_next = substr(date("Y-m-d",$nextmonth),0,4);
		
		$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
		$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
		$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
		$datetime_now = date('Y-m-d H:i:s');
		$sql = "UPDATE master_jual_produk
			SET jproduk_stat_dok='Batal'
				,jproduk_update='".@$_SESSION[SESSION_USERID]."'
				,jproduk_date_update='".$datetime_now."'
				,jproduk_revised=jproduk_revised+1
			WHERE jproduk_id='".$jproduk_id."' " ;
				//AND ('".$date."'<='".$tanggal_3."' OR  jproduk_tanggal='".$date."')";
		$this->db->query($sql);
		if($this->db->affected_rows()){
			//* udpating db.customer.cust_point ==> proses mengurangi jumlah poin (dikurangi dengan db.master_jual_produk.jproduk_point yg sudah dimasukkan ketika cetak_jproduk faktur), karena dilakukan pembatalan /
			$result_point_batal = $this->member_point_batal($jproduk_id);
			if($result_point_batal==1){
				$result_membership = $this->membership_insert($jproduk_id);
				if($result_membership==1){
					$result_piutang = $this->catatan_piutang_batal($jproduk_id);
					if($result_piutang==1){
						$result_cara_bayar = $this->cara_bayar_batal($jproduk_id);
						if($result_cara_bayar==1){
							return '1';
						}
					}
				}
			}
			
		}else{
			return '0';
		}
	}
	
	//function for advanced search record
	function master_jual_produk_search($jproduk_nobukti, $jproduk_cust, $jproduk_tanggal, $jproduk_tanggal_akhir, $jproduk_diskon, $jproduk_cara, $jproduk_keterangan, $jproduk_stat_dok, $start, $end){
		//full query
		//$date_temp = strtotime(date('Y-m-d', strtotime($date)) . " +20 days");
		//$query="SELECT jproduk_id, jproduk_nobukti, cust_nama, cust_no, cust_member, member_no, jproduk_cust, jproduk_tanggal, jproduk_diskon, jproduk_cashback, jproduk_cara, jproduk_cara2, jproduk_cara3, jproduk_bayar, jproduk_totalbiaya, jproduk_keterangan, jproduk_creator, jproduk_date_create, jproduk_update, jproduk_date_update, jproduk_revised, jproduk_stat_dok FROM vu_jproduk";
		$query = "SELECT jproduk_id
				,jproduk_nobukti
				,jproduk_nobukti_pajak
				,CONCAT(cust_nama, ' (', cust_no, ')') as cust_nama_edit
				,cust_nama
				,cust_no
				,cust_priority_star
				,cust_member
				,member_no
				,member_valid
				,karyawan.karyawan_no
				,karyawan.karyawan_nama
				,jproduk_cust
				,jproduk_tanggal
				,jproduk_diskon
				,jproduk_cashback
				,jproduk_cara
				,jproduk_cara2
				,jproduk_cara3
				,jproduk_bayar
				,IF(vu_jproduk.jproduk_totalbiaya!=0, vu_jproduk.jproduk_totalbiaya, vu_jproduk_totalbiaya.jproduk_totalbiaya) AS jproduk_totalbiaya
				,jproduk_keterangan
				,jproduk_stat_dok
				,jproduk_creator
				,jproduk_date_create
				,jproduk_update
				,jproduk_date_update
				,jproduk_revised
			FROM vu_jproduk
			LEFT JOIN vu_jproduk_totalbiaya ON(vu_jproduk_totalbiaya.dproduk_master=vu_jproduk.jproduk_id)
			LEFT JOIN karyawan ON(karyawan.karyawan_id = vu_jproduk.jproduk_grooming)";
		
		if($jproduk_nobukti!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_nobukti LIKE '%".$jproduk_nobukti."%'";
		};
		if($jproduk_cust!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_cust = '".$jproduk_cust."'";
		};
		if($jproduk_tanggal!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_tanggal>= '".$jproduk_tanggal."'";
		};
		if($jproduk_tanggal_akhir!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_tanggal<= '".$jproduk_tanggal_akhir."'";
		};
/*			if($jproduk_diskon!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_diskon LIKE '%".$jproduk_diskon."%'";
		};
*/			if($jproduk_cara!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_cara LIKE '%".$jproduk_cara."%'";
		};
		if($jproduk_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_keterangan LIKE '%".$jproduk_keterangan."%'";
		};
		if($jproduk_stat_dok!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " jproduk_stat_dok LIKE '%".$jproduk_stat_dok."%'";
		};
		
		$query .= " ORDER BY jproduk_nobukti DESC";
		
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
	function master_jual_produk_print($jproduk_nobukti
									,$jproduk_cust
									,$jproduk_tanggal
									,$jproduk_tanggal_akhir
									,$jproduk_diskon
									,$jproduk_cara
									,$jproduk_keterangan
									,$jproduk_stat_dok
									,$option
									,$filter){
		//full query
		$query="SELECT jproduk_tanggal
				,jproduk_nobukti
				,cust_no
				,cust_nama
				,INSERT(INSERT(member_no,7,0,'-'),14,0,'-') AS no_member
				,vu_jproduk.jproduk_totalbiaya AS jproduk_totalbiaya
				,jproduk_bayar
				,jproduk_keterangan
				,jproduk_stat_dok
			FROM vu_jproduk
			LEFT JOIN vu_jproduk_totalbiaya ON(vu_jproduk_totalbiaya.dproduk_master=vu_jproduk.jproduk_id)";
		if($option=='LIST'){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (jproduk_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' )";
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			if($jproduk_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_nobukti LIKE '%".$jproduk_nobukti."%'";
			};
			if($jproduk_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_cust = '".$jproduk_cust."'";
			};
			if($jproduk_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_tanggal>= '".$jproduk_tanggal."'";
			};
			if($jproduk_tanggal_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_tanggal<= '".$jproduk_tanggal_akhir."'";
			};
			if($jproduk_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_cara LIKE '%".$jproduk_cara."%'";
			};
			if($jproduk_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_keterangan LIKE '%".$jproduk_keterangan."%'";
			};
			if($jproduk_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_stat_dok LIKE '%".$jproduk_stat_dok."%'";
			};
			$result = $this->db->query($query);
		}
		return $result->result();
	}
	
	//function  for export to excel
	function master_jual_produk_export_excel($jproduk_nobukti
											,$jproduk_cust
											,$jproduk_tanggal
											,$jproduk_tanggal_akhir
											,$jproduk_diskon
											,$jproduk_cara
											,$jproduk_keterangan
											,$jproduk_stat_dok
											,$option
											,$filter){
		//full query
		$query="SELECT jproduk_tanggal AS tanggal
				,jproduk_nobukti AS no_faktur
				,cust_no AS no_cust
				,cust_nama AS customer
				,INSERT(INSERT(member_no,7,0,'-'),14,0,'-') AS no_member
				,vu_jproduk.jproduk_totalbiaya AS 'Total (Rp)'
				,jproduk_bayar AS 'Total Bayar (Rp)'
				,jproduk_keterangan AS keterangan
				,jproduk_stat_dok AS stat_dok
			FROM vu_jproduk
			LEFT JOIN vu_jproduk_totalbiaya ON(vu_jproduk_totalbiaya.dproduk_master=vu_jproduk.jproduk_id)";
		if($option=='LIST'){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (jproduk_nobukti LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' )";
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			if($jproduk_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_nobukti LIKE '%".$jproduk_nobukti."%'";
			};
			if($jproduk_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_cust = '".$jproduk_cust."'";
			};
			if($jproduk_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_tanggal>= '".$jproduk_tanggal."'";
			};
			if($jproduk_tanggal_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_tanggal<= '".$jproduk_tanggal_akhir."'";
			};
			if($jproduk_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_cara LIKE '%".$jproduk_cara."%'";
			};
			if($jproduk_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_keterangan LIKE '%".$jproduk_keterangan."%'";
			};
			if($jproduk_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jproduk_stat_dok LIKE '%".$jproduk_stat_dok."%'";
			};
			$result = $this->db->query($query);
		}
		return $result;
	}
	
	function print_paper($jproduk_id){
		//$sql="SELECT jproduk_tanggal, cust_no, cust_nama, cust_alamat, jproduk_nobukti, produk_nama, dproduk_jumlah, satuan_nama, dproduk_harga, dproduk_diskon, (dproduk_harga*((100-dproduk_diskon)/100)) AS jumlah_subtotal, jproduk_creator, jtunai_nilai, jproduk_diskon, jproduk_cashback FROM detail_jual_produk LEFT JOIN master_jual_produk ON(dproduk_master=jproduk_id) LEFT JOIN customer ON(jproduk_cust=cust_id) LEFT JOIN produk ON(dproduk_produk=produk_id) LEFT JOIN satuan ON(dproduk_satuan=satuan_id) LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE dproduk_master='$jproduk_id'";
		$sql="SELECT 
			jproduk_tanggal, 
			cust_no, 
			cust_nama, 
			cust_alamat, 
			jproduk_nobukti, 
			produk_nama, 
			dproduk_jumlah, 
			satuan_nama, 
			dproduk_harga, 
			dproduk_diskon, 
			(dproduk_harga*((100-dproduk_diskon)/100)) AS jumlah_subtotal, 
			jproduk_creator, 
			jproduk_diskon, 
			jproduk_cashback, 
			jproduk_bayar,
			TIME(jproduk_date_create) AS jproduk_jam,
			IFNULL(karyawan_nama,'NA') AS jproduk_karyawan,
			IFNULL(karyawan_no,'NA') AS jproduk_karyawan_no
		FROM detail_jual_produk 
		LEFT JOIN master_jual_produk ON(dproduk_master=jproduk_id) 
		LEFT JOIN customer ON(jproduk_cust=cust_id) 
		LEFT JOIN produk ON(dproduk_produk=produk_id) 
		LEFT JOIN satuan ON(dproduk_satuan=satuan_id)
		LEFT JOIN karyawan ON (jproduk_grooming = karyawan_id)
		WHERE dproduk_master='$jproduk_id' 
		ORDER BY dproduk_diskon ASC";
		$result = $this->db->query($sql);
		return $result;
	}
	
	function print_paper2($jproduk_id){
	
		$sql="SELECT 
			jproduk_tanggal, 
			cust_no, 
			cust_nama, 
			cust_alamat, 
			jproduk_nobukti, 
			jproduk_nobukti_pajak, 
			produk_nama, 
			dproduk_jumlah, 
			satuan_nama, 
			dproduk_harga, 
			dproduk_diskon, 
			(dproduk_harga*((100-dproduk_diskon)/100)) AS jumlah_subtotal, 
			jproduk_creator, 
			jproduk_diskon, 
			jproduk_cashback, 
			jproduk_bayar,
			TIME(jproduk_date_create) AS jproduk_jam,
			IFNULL(karyawan_nama,'NA') AS jproduk_karyawan,
			IFNULL(karyawan_no,'NA') AS jproduk_karyawan_no
		FROM detail_jual_produk 
		LEFT JOIN master_jual_produk ON(dproduk_master=jproduk_id) 
		LEFT JOIN customer ON(jproduk_cust=cust_id) 
		LEFT JOIN produk ON(dproduk_produk=produk_id) 
		LEFT JOIN satuan ON(dproduk_satuan=satuan_id)
		LEFT JOIN karyawan ON (jproduk_grooming = karyawan_id)
		WHERE dproduk_master='$jproduk_id' 
		ORDER BY dproduk_diskon ASC";
		$result = $this->db->query($sql);
		return $result;
	}
	
	function get_cara_bayar($jproduk_id){
		$sql="SELECT jproduk_nobukti, jproduk_cara FROM master_jual_produk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row_array();
			$sql = "SELECT cek ,card ,kuitansi ,transfer ,tunai FROM vu_trans_produk WHERE no_bukti='".$record['jproduk_nobukti']."'";
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
	
	function cara_bayar($jproduk_id){
		$sql="SELECT jproduk_nobukti, jproduk_cara FROM master_jual_produk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
			$jproduk_nobukti = $record->jproduk_nobukti;
			if(($record->jproduk_cara !== NULL || $record->jproduk_cara !== '')){
				if($record->jproduk_cara == 'tunai'){
					$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, jtunai_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->jproduk_cara == 'kwitansi'){
					$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, jkwitansi_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->jproduk_cara == 'card'){
					$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, jcard_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->jproduk_cara == 'cek/giro'){
					$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, jcek_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->jproduk_cara == 'transfer'){
					$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, jtransfer_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						return $rs->row();
					}else{
						return NULL;
					}
				}elseif($record->jproduk_cara == 'voucher'){
					$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					
					$sql="SELECT jproduk_nobukti, jproduk_cara, tvoucher_nilai AS bayar_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 0,1";
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
	
	function cara_bayar2($jproduk_id){
		$sql="SELECT jproduk_nobukti, jproduk_cara2 FROM master_jual_produk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
			$jproduk_nobukti = $record->jproduk_nobukti;
			if(($record->jproduk_cara2 !== NULL || $record->jproduk_cara2 !== '')){
				if($record->jproduk_cara2 == 'tunai'){
					$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara2 == 'kwitansi'){
					$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara2 == 'card'){
					$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara2 == 'cek/giro'){
					$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara2 == 'transfer'){
					$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara2 == 'voucher'){
					$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
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
	
	function cara_bayar3($jproduk_id){
		$sql="SELECT jproduk_nobukti, jproduk_cara3 FROM master_jual_produk WHERE jproduk_id='$jproduk_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
			$jproduk_nobukti = $record->jproduk_nobukti;
			if(($record->jproduk_cara3 !== NULL || $record->jproduk_cara3 !== '')){
				if($record->jproduk_cara3 == 'tunai'){
					$sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_tunai ON(jtunai_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara3 == 'kwitansi'){
					$sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara3 == 'card'){
					$sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_card ON(jcard_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara3 == 'cek/giro'){
					$sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_cek ON(jcek_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara3 == 'transfer'){
					$sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN jual_transfer ON(jtransfer_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jproduk_cara3 == 'voucher'){
					$sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jproduk_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jproduk_nobukti, jproduk_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_produk LEFT JOIN voucher_terima ON(tvoucher_ref=jproduk_nobukti) WHERE jproduk_id='$jproduk_id' LIMIT 2,1";
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