<? /* 
	GIOV Solution - Keep IT Simple
*/

class M_master_produksi extends Model{
		
		//constructor
		function M_master_produksi() {
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
								AND jual_stat_dok<>'Batal' 
								 ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal'  
								AND jual_stat_dok<>'Batal' 
								AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' 
								".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_kuitansi WHERE stat_dok<>'Batal'  AND jual_stat_dok<>'Batal' 
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
		
	// Function get produk list
	function get_produk_bahan_list($query,$start,$end,$aktif){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dbahan_produk FROM detail_persiapan_bahan WHERE dbahan_master='$query'";
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
					
					$filter.="OR produk_id='".$row_dproduk->dbahan_produk."' ";
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


	// Function get produk list
	function get_produk_jadi_list($query,$start,$end,$aktif){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT djadi_produk FROM detail_persiapan_produksi WHERE djadi_master='$query'";
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
					
					$filter.="OR produk_id='".$row_dproduk->djadi_produk."' ";
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

	
	//Get Gudang Tujuan List 
	function get_gudang_tujuan_list(){
			$sql="SELECT gudang_id, gudang_nama, gudang_lokasi FROM gudang where gudang_aktif='Aktif'";
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

	//Get Gudang Asal List 
	function get_gudang_asal_list(){
			$sql="SELECT gudang_id, gudang_nama, gudang_lokasi FROM gudang where gudang_aktif='Aktif'";
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

	// Function utk Ambil Satuan dari detail Bahan Produksi
	function get_satuan_bybahan_jadi_list($djproduk_id,$produk_id){
		if($djproduk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) LEFT JOIN detail_persiapan_bahan ON(dbahan_produk=produk_id) LEFT JOIN master_persiapan_produksi ON(dbahan_master=produksi_id) WHERE produksi_id='$djproduk_id'";
		
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

	
	// Function utk Ambil satuan dari detail produksi jadi
	function get_satuan_byproduksi_jadi_list($djproduk_id,$produk_id){
		if($djproduk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) LEFT JOIN detail_persiapan_produksi ON(djadi_produk=produk_id) LEFT JOIN master_persiapan_produksi ON(djadi_master=produksi_id) WHERE produksi_id='$djproduk_id'";
		
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
		$query = "SELECT max(produksi_id) as master_id from master_persiapan_produksi";
		$result = $this->db->query($query);
		if($result->num_rows()){
			$data=$result->row();
			$master_id=$data->master_id;
			return $master_id;
		}
		else{
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
		
	function detail_bahan_jadi_produksi_list($master_id,$query,$start,$end) {
			$query = "SELECT detail_persiapan_bahan.* ,
							produk.produk_nama , 
							satuan.satuan_kode as satuan_nama

					 FROM detail_persiapan_bahan
					 LEFT JOIN produk on (produk.produk_id = detail_persiapan_bahan.dbahan_produk)
					 LEFT JOIN satuan on (satuan.satuan_id = detail_persiapan_bahan.dbahan_satuan)
					 where dbahan_master='".$master_id."'";

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
	

	//Delete detail_fcl
	function detail_lcl_delete($dfcl_id){
		$query = "DELETE FROM detail_fcl WHERE dfcl_id = ".$dfcl_id;
		$this->db->query($query);
		if($this->db->affected_rows()>0)
			return '1';
		else
			return '0';
	}

	//Delete detail_final_status_fcl
	function detail_final_status_delete($fs_id){
		$query = "DELETE FROM detail_final_status_fcl WHERE fs_id = ".$fs_id;
		$this->db->query($query);
		if($this->db->affected_rows()>0)
			return '1';
		else
			return '0';
	}

	function detail_produksi_jadi_list($master_id,$query,$start,$end) {
		$query = "SELECT detail_persiapan_produksi.* ,
					produk.produk_nama,
					satuan.satuan_kode as satuan_nama
				FROM detail_persiapan_produksi 
				LEFT JOIN produk on (produk.produk_id = detail_persiapan_produksi.djadi_produk)
				LEFT JOIN satuan on (satuan.satuan_id = detail_persiapan_produksi.djadi_satuan)
				where djadi_master='".$master_id."'";

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
		}
		else {
			return '({"total":"0", "results":""})';
			}
		}
		//end of function

		
	// Function untuk insert detail Bahan Produksi
	function detail_bahan_produksi_insert($array_dbahan_id, $dbahan_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $djadi_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak){
	
		if($dbahan_master=="" || $dbahan_master==NULL || $dbahan_master==0){
				$dbahan_master=$this->get_master_id();
		}
		
		$size_array = sizeof($array_dbahan_produk) - 1;
			for($i = 0; $i < sizeof($array_dbahan_produk); $i++){
				$dbahan_id = $array_dbahan_id[$i];
				$dbahan_master = $dbahan_master;
				$dbahan_produk = $array_dbahan_produk[$i];
				$dbahan_satuan = $array_dbahan_satuan[$i];
				$dbahan_jumlah = $array_dbahan_jumlah[$i];
				$dbahan_keterangan = $array_dbahan_keterangan[$i];
	
				$sql = "SELECT dbahan_id
					FROM detail_persiapan_bahan
					WHERE dbahan_id='".$dbahan_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_bahan_produksi = array(
						"dbahan_master"=>$dbahan_master,
						"dbahan_produk"=>$dbahan_produk,
						"dbahan_satuan"=>$dbahan_satuan,
						"dbahan_jumlah"=>$dbahan_jumlah,
						"dbahan_keterangan"=>$dbahan_keterangan,
					);
					$this->db->where('dbahan_id', $dbahan_id);
					$this->db->update('detail_persiapan_bahan', $dtu_detail_bahan_produksi); 
				}else {
					$data = array(
						"dbahan_master"=>$dbahan_master,
						"dbahan_produk"=>$dbahan_produk,
						"dbahan_satuan"=>$dbahan_satuan,
						"dbahan_jumlah"=>$dbahan_jumlah,
						"dbahan_keterangan"=>$dbahan_keterangan,
					);
					$this->db->insert('detail_persiapan_bahan', $data); 	
				}	
		}
				
		
		// Untuk insert detail Produksi Jadi nya
		if($djadi_master=="" || $djadi_master==NULL || $djadi_master==0){
				$djadi_master=$this->get_master_id();
		}		
		$size_array = sizeof($array_djadi_produk) - 1;
			for($i = 0; $i < sizeof($array_djadi_produk); $i++){
				$djadi_id = $array_djadi_id[$i];
				$djadi_master = $djadi_master;
				$djadi_produk = $array_djadi_produk[$i];
				$djadi_satuan = $array_djadi_satuan[$i];
				$djadi_jumlah = $array_djadi_jumlah[$i];
				$djadi_keterangan = $array_djadi_keterangan[$i];
	
				$sql = "SELECT djadi_id
					FROM detail_persiapan_produksi
					WHERE djadi_id='".$djadi_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_produksi_jadi = array(
						"djadi_master"=>$djadi_master,
						"djadi_produk"=>$djadi_produk,
						"djadi_satuan"=>$djadi_satuan,
						"djadi_jumlah"=>$djadi_jumlah,
						"djadi_keterangan"=>$djadi_keterangan,
					);
					$this->db->where('djadi_id', $djadi_id);
					$this->db->update('detail_persiapan_produksi', $dtu_detail_produksi_jadi); 
				}else {
					$data = array(
						"djadi_master"=>$djadi_master,
						"djadi_produk"=>$djadi_produk,
						"djadi_satuan"=>$djadi_satuan,
						"djadi_jumlah"=>$djadi_jumlah,
						"djadi_keterangan"=>$djadi_keterangan,
					);
					$this->db->insert('detail_persiapan_produksi', $data); 	
				}	
		}
		
		if($cetak==1){
		return $dbahan_master;
		}
		else{
		return 0;
		}
	}
		
		
	//function for get list record
	function produksi_list($filter,$start,$end){
			$query = "
					SELECT master_persiapan_produksi.* , 
						gudang_asal.gudang_nama as gudang_asal_nama,
						gudang_tujuan.gudang_nama as gudang_tujuan_nama
					FROM master_persiapan_produksi
					LEFT JOIN gudang gudang_asal ON (gudang_asal.gudang_id = master_persiapan_produksi.produksi_gudang_asal)
					LEFT JOIN gudang gudang_tujuan ON (gudang_tujuan.gudang_id = master_persiapan_produksi.produksi_gudang_tujuan)
			";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (produksi_no LIKE '%".addslashes($filter)."%' OR produksi_keterangan LIKE '%".addslashes($filter)."%' OR produksi_status LIKE '%".addslashes($filter)."%')";
			}
			$query .= " GROUP BY produksi_id ORDER BY produksi_id DESC";
			
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
		function produksi_update($produksi_id, $produksi_no, $produksi_gudang_asal, $produksi_gudang_tujuan, $produksi_tanggal, $produksi_keterangan, $produksi_status,
			$array_dbahan_id, $dlcl_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $dlcl_fs_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak){
			$data = array(
				"produksi_no"=>$produksi_no, 
				"produksi_tanggal"=>$produksi_tanggal,
				"produksi_keterangan"=>$produksi_keterangan,
				"produksi_status"=>$produksi_status
			
			);
			
			// Cara untuk mengakali combobox yang pny datastore sendiri
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$produksi_gudang_asal."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["produksi_gudang_asal"]=$produksi_gudang_asal;

			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$produksi_gudang_tujuan."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["produksi_gudang_tujuan"]=$produksi_gudang_tujuan;
					
			
			$this->db->where('produksi_id', $produksi_id);
			$this->db->update('master_persiapan_produksi', $data);
		
			// Function utk mengupdate detail Bahan Jadi dan Detail Produksi Jadi
			$temp_dlcl_ins = $this->detail_bahan_produksi_insert($array_dbahan_id, $dlcl_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $dlcl_fs_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak);
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		function produksi_batal($kwitansi_id ,$kwitansi_status ,$kwitansi_update ){
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
		function produksi_create($produksi_no, $produksi_gudang_asal, $produksi_gudang_tujuan, $produksi_tanggal, $produksi_keterangan, $produksi_status,
			$array_dbahan_id, $dbahan_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $djadi_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak){
							
			$datetime_now = date('Y-m-d H:i:s');
			$time_now = date('H:i:s');
			$datetime_create = $produksi_tanggal.' '.$time_now;
			$produksi_date_create = date('Y-m-d H:i:s', strtotime($datetime_create));
		
			$produksi_tanggal_pattern=strtotime($produksi_tanggal);
			//$pattern= $data_parameter->temp."-F"."-";
			
			/*
			if($lcl_type == 'By Air'){
				$pattern="MRK-A/".$data_parameter->temp."-".date('ym')."-";
				$lcl_kode=$this->m_public_function->get_kode_1("master_lcl","lcl_kode",$pattern,18);
			}
			else if($lcl_type == 'By Sea'){
				$pattern="MRK-S/".$data_parameter->temp."-".date('ym')."-";
				$lcl_kode=$this->m_public_function->get_kode_1("master_lcl","lcl_kode",$pattern,18);
			}
			*/

			$pattern="PP"."/".date('ym')."-";
			//$pattern="L/".$data_parameter->temp."-".date('ym')."-";
			$produksi_no=$this->m_public_function->get_kode_1("master_persiapan_produksi","produksi_no",$pattern,12);
			$data = array(
				"produksi_no"=>$produksi_no, 
				"produksi_tanggal"=>$produksi_tanggal,
				"produksi_gudang_asal"=>$produksi_gudang_asal,
				"produksi_gudang_tujuan"=>$produksi_gudang_tujuan,
				"produksi_keterangan"=>$produksi_keterangan,
				// "produksi_status"=>$produksi_status,
				// "produksi_status"=>'Tertutup', 
				"produksi_creator"=>$_SESSION[SESSION_USERID]
				
			);
			if($cetak==1)
				$data['produksi_status'] = 'Tertutup';
			else
				$data['produksi_status'] = 'Terbuka';

			$this->db->insert('master_persiapan_produksi', $data); 
			
		 	//function insert detail Bahan Jadi disini
			$temp_dlcl_ins = $this->detail_bahan_produksi_insert($array_dbahan_id, $dbahan_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $djadi_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak);
			
			if($this->db->affected_rows())
				return $temp_dlcl_ins;
			else
				return '0';
	
		}
		
		//fcuntion for delete record
		function produksi_delete($pkid){
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
		function produksi_search($kwitansi_no ,$kwitansi_cust , $kwitansi_tanggal_start, $kwitansi_tanggal_end,$kwitansi_keterangan ,$kwitansi_status , $dfcl_status, $final_status, $start,$end){
			//full query
			$query = "SELECT master_lcl.lcl_id , master_lcl.lcl_kode, master_lcl.lcl_cust, master_lcl.lcl_supplier, master_lcl.lcl_marking, master_lcl.lcl_awb, master_lcl.lcl_type, master_lcl.lcl_keterangan, master_lcl.lcl_jumlah, master_lcl.lcl_weight, master_lcl.lcl_dim, master_lcl.lcl_volume, master_lcl.lcl_status, master_lcl.lcl_city,
						date_format(master_lcl.lcl_tanggal, '%d-%m-%Y') as lcl_tanggal, date_format(master_lcl.lcl_shipment_date, '%d-%m-%Y') as lcl_shipment_date, date_format(master_lcl.lcl_actual_time, '%d-%m-%Y') as lcl_actual_time,
						ifnull(cust.cust_firstname,'') as cust_name,
						ifnull(supplier.cust_firstname,'') as supplier_name,
						ifnull(country.country_nama,'') as country_nama,
						ifnull(pod.country_nama,'') as pod_nama,
						ifnull(detail_cust_warehouse.dcust_warehouse_address,'') as warehouse_address
						from master_lcl
						LEFT JOIN customer as cust ON (cust.cust_id = master_lcl.lcl_cust)
						LEFT JOIN customer as supplier ON (supplier.cust_id = master_lcl.lcl_supplier)
						LEFT JOIN detail_cust_warehouse ON (detail_cust_warehouse.dcust_warehouse_id = master_lcl.lcl_address)
						LEFT JOIN country as country ON (country.country_id = master_lcl.lcl_city)
						LEFT JOIN country as pod ON (pod.country_id = master_lcl.lcl_pod)
					";
			
			if($kwitansi_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produksi_no LIKE '%".$kwitansi_no."%'";
			};
			if($kwitansi_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " lcl_cust = '".$kwitansi_cust."'";
			};
			if($kwitansi_tanggal_start!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " lcl_tanggal>= '".$kwitansi_tanggal_start."'";
			};
			if($kwitansi_tanggal_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " lcl_tanggal<= '".$kwitansi_tanggal_end."'";
			};
			if($kwitansi_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produksi_keterangan LIKE '%".$kwitansi_keterangan."%'";
			};
			if($kwitansi_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " lcl_status = '".$kwitansi_status."'";
			};
			if($dfcl_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dbahan_produk = '".$dfcl_status."'";
			};
			if($final_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dlcl_fs_status = '".$final_status."'";
			};
			if($final_status == ''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dlcl_fs_status is null";
			};
			$query .= " GROUP BY lcl.lcl_id ORDER BY lcl_id DESC";
			
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
		function produksi_print($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
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
		function produksi_export_excel($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
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