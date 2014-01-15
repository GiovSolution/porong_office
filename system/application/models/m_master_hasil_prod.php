<? /* 
	GIOV Solution - Keep IT Simple
*/

class M_master_hasil_prod extends Model{
		
		//constructor
		function M_master_hasil_prod() {
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
	

	//ini utk menampilkan produk list dari Permintaan Produksi
	function get_produk_pp_list($produksi_id,$query,$start,$end){
			$sql="SELECT produk_id,produk_nama,produk_kode,detail_persiapan_produksi.djadi_jumlah as jumlah_order FROM produk
				LEFT JOIN detail_persiapan_produksi on (detail_persiapan_produksi.djadi_produk = produk.produk_id)
			";
			if($produksi_id<>"")
				$sql.=" WHERE produk_id IN(SELECT djadi_produk FROM detail_persiapan_produksi WHERE djadi_master='".$produksi_id."')";

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}

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

	function get_produk_all_list($query,$start,$end){
			
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk
						WHERE produk_aktif='Aktif'";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." (produk_nama like '%".$query."%' OR produk_kode like '%".$query."%')";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit); */ 
			
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


	function get_satuan_produk_list($selected_id){	
			$sql="SELECT satuan_id,satuan_kode,satuan_nama,konversi_default FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
			if($selected_id!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id='".$selected_id."'";
			}
			
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


	function get_satuan_selected_list($selected_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE satuan_id IN(".$selected_id.")";
			}

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

	//Function utk menampilkan List Produk dari nomer PP
	function get_item_detail_by_produksi_id($produksi_id){
		$sql="SELECT detail_persiapan_produksi.djadi_id, detail_persiapan_produksi.djadi_master, detail_persiapan_produksi.djadi_produk,detail_persiapan_produksi.djadi_satuan,
							detail_persiapan_produksi.djadi_jumlah as jumlah_order,
							detail_persiapan_produksi.djadi_harga,
					master_persiapan_produksi.produksi_id as produksi_id
				FROM detail_persiapan_produksi
				LEFT JOIN master_persiapan_produksi on (master_persiapan_produksi.produksi_id = detail_persiapan_produksi.djadi_master)
				WHERE detail_persiapan_produksi.djadi_master = '".$produksi_id."'
				group by djadi_produk, djadi_satuan";
				
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

	//Function utk menampilkan List dari tabel Permintaan Produksi
		function get_no_permintaan_produksi_list($filter,$start,$end){
			$date = date('Y-m-d');
			//$date_1 = '01';
			//$date_2 = '02';
			$date_3 = '03';
			$month = substr($date,5,2);
			$year = substr($date,0,4);
			$begin=mktime(0,0,0,$month,1,$year);
			$nextmonth=strtotime("+2months",$begin);
			
			$month_next = substr(date("Y-m-d",$nextmonth),5,2);
			$year_next = substr(date("Y-m-d",$nextmonth),0,4);
			
			//$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
			//$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
			$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
            $datetime_now = date('Y-m-d H:i:s');

			$date_now=date('Y-m-d');
		
			$sql_day = "SELECT trans_op_days from transaksi_setting";
			$query_day= $this->db->query($sql_day);
			$data_day= $query_day->row();
			$day= $data_day->trans_op_days;
			
			$sql=  "SELECT produksi_no, produksi_id, produksi_tanggal, gudang_nama, gudang_id, sum(djadi_jumlah) as jumlah_order
					FROM detail_persiapan_produksi
					LEFT JOIN master_persiapan_produksi on (master_persiapan_produksi.produksi_id = detail_persiapan_produksi.djadi_master)
					LEFT JOIN gudang on (master_persiapan_produksi.produksi_gudang_asal = gudang.gudang_id)
					WHERE master_persiapan_produksi.produksi_status = 'Tertutup' AND '".$date_now."' < (produksi_tanggal + INTERVAL '".$day."' DAY)
					";
					
			if ($filter<>""){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (produksi_no LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%')";
			}
			
			$sql .= " GROUP BY produksi_no desc 
						HAVING (sum(detail_persiapan_produksi.djadi_jumlah) - (select sum(detail_hasil_produksi.dhasil_jumlah)
																		from detail_hasil_produksi
																		left join master_hasil_produksi on (master_hasil_produksi.hasil_id = detail_hasil_produksi.dhasil_master)
																		where (master_hasil_produksi.hasil_produksi = master_persiapan_produksi.produksi_id AND master_hasil_produksi.hasil_status <> 'Batal')
																		)
								) <> 0 OR
								(sum(detail_persiapan_produksi.djadi_jumlah) - (select sum(detail_hasil_produksi.dhasil_jumlah)
																		from detail_hasil_produksi
																		left join master_hasil_produksi on (master_hasil_produksi.hasil_id = detail_hasil_produksi.dhasil_master)
																		where (master_hasil_produksi.hasil_produksi = master_persiapan_produksi.produksi_id AND master_hasil_produksi.hasil_status <> 'Batal')
																		)
								) IS NULL
						ORDER BY produksi_no desc ";
		
			$start=($start==""?0:$start);
			$end=($end==""?15:$end);
			
			$query = $this->db->query($sql);
			$nbrows = $query->num_rows();
			$limit = $sql." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit); 

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

	// Function utk automatis ambil satuan dari event combo produk
	function get_satuan_bybahan_jadi_list($djproduk_id,$produk_id){
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

	
	// Function utk automatis ambil satuan dari event combo produk
	function get_satuan_byproduksi_jadi_list($djproduk_id,$produk_id){
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
		$query = "SELECT max(hasil_id) as master_id from master_hasil_produksi";
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

	//Delete detail serah bahan
	function detail_serahbahan_delete($dserah_id){
		$query = "DELETE FROM detail_serah_bahan WHERE dserah_id = ".$dserah_id;
		$this->db->query($query);
		if($this->db->affected_rows()>0)
			return '1';
		else
			return '0';
	}

	function get_satuan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($master_id<>"")
				$sql.=" WHERE satuan_id IN(SELECT dserah_satuan FROM detail_serah_bahan WHERE dserah_master='".$master_id."')";
			
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

	function get_produk_detail_list($master_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode 
					FROM produk";
			if($master_id<>"")
				$sql.=" WHERE produk_id IN(SELECT dhasil_produk FROM detail_hasil_produksi WHERE dhasil_master='".$master_id."')";
				
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

	function detail_hasil_produksi_list($master_id,$query,$start,$end) {
		$query = "SELECT detail_hasil_produksi.* ,
					produk.produk_nama,
					satuan.satuan_kode as satuan_nama
				FROM detail_hasil_produksi 
				LEFT JOIN produk on (produk.produk_id = detail_hasil_produksi.dhasil_produk)
				LEFT JOIN satuan on (satuan.satuan_id = detail_hasil_produksi.dhasil_satuan)
				where dhasil_master='".$master_id."'";

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

		
	// Function untuk insert detail Hasil Produksi
	function detail_hasilproduksi_insert($array_dhasil_id, $dhasil_master, $array_dhasil_produk, $array_dhasil_satuan, $array_dhasil_jumlah, $array_dhasil_keterangan, $cetak){
	
		if($dhasil_master=="" || $dhasil_master==NULL || $dhasil_master==0){
				$dhasil_master=$this->get_master_id();
		}
		
		$size_array = sizeof($array_dhasil_produk) - 1;
			for($i = 0; $i < sizeof($array_dhasil_produk); $i++){
				$dhasil_id = $array_dhasil_id[$i];
				$dhasil_master = $dhasil_master;
				$dhasil_produk = $array_dhasil_produk[$i];
				$dhasil_satuan = $array_dhasil_satuan[$i];
				$dhasil_jumlah = $array_dhasil_jumlah[$i];
				$dhasil_keterangan = $array_dhasil_keterangan[$i];
	
				$sql = "SELECT dhasil_id
					FROM detail_hasil_produksi
					WHERE dhasil_id='".$dhasil_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_hasil_produksi = array(
						"dhasil_master"=>$dhasil_master,
						"dhasil_produk"=>$dhasil_produk,
						"dhasil_satuan"=>$dhasil_satuan,
						"dhasil_jumlah"=>$dhasil_jumlah,
						"dhasil_keterangan"=>$dhasil_keterangan,
					);
					$this->db->where('dhasil_id', $dhasil_id);
					$this->db->update('detail_hasil_produksi', $dtu_detail_hasil_produksi); 
				}else {
					$data = array(
						"dhasil_master"=>$dhasil_master,
						"dhasil_produk"=>$dhasil_produk,
						"dhasil_satuan"=>$dhasil_satuan,
						"dhasil_jumlah"=>$dhasil_jumlah,
						"dhasil_keterangan"=>$dhasil_keterangan,
					);
					$this->db->insert('detail_hasil_produksi', $data); 	
				}	
		}
		
		if($cetak==1){
		return $dhasil_master;
		}
		else if($cetak==0){
		return 0;
		}
	}
		
		
	//function for get list record
	function hasilprod_list($filter,$start,$end){
			$query = "
					SELECT master_hasil_produksi.* , 
						master_persiapan_produksi.produksi_tanggal, master_persiapan_produksi.produksi_no,
						gudang.gudang_nama
					FROM master_hasil_produksi
					LEFT JOIN master_persiapan_produksi ON (master_persiapan_produksi.produksi_id = master_hasil_produksi.hasil_produksi)
					LEFT JOIN gudang ON (gudang.gudang_id = master_persiapan_produksi.produksi_gudang_asal)

			";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (hasil_no LIKE '%".addslashes($filter)."%' OR hasil_keterangan LIKE '%".addslashes($filter)."%' OR hasil_status LIKE '%".addslashes($filter)."%')";
			}
			$query .= " GROUP BY hasil_id ORDER BY hasil_id DESC";
			
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
	function hasilprod_update($hasil_id, $hasil_no, $hasil_tanggal, $hasil_keterangan, $hasil_status, $hasil_produksi,
			$array_dhasil_id, $dhasil_master, $array_dhasil_produk, $array_dhasil_satuan, $array_dhasil_jumlah, $array_dhasil_keterangan, $cetak){
			$data = array(
				"hasil_no"=>$hasil_no, 
				"hasil_tanggal"=>$hasil_tanggal,
				"hasil_keterangan"=>$hasil_keterangan,
				"hasil_status"=>$hasil_status,
				"hasil_updater"=>$_SESSION[SESSION_USERID]
			);
			
			// Cara untuk mengakali combobox yang pny datastore sendiri
			$sql="SELECT hasil_produksi FROM master_hasil_produksi WHERE hasil_produksi='".$hasil_produksi."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["hasil_produksi"]=$hasil_produksi;
					
			$this->db->where('hasil_id', $hasil_id);
			$this->db->update('master_hasil_produksi', $data);
		
			// Function utk mengupdate detail Hasil Produksi
			$temp_update = $this->detail_hasilproduksi_insert($array_dhasil_id, $dhasil_master, $array_dhasil_produk, $array_dhasil_satuan, $array_dhasil_jumlah, $array_dhasil_keterangan,$cetak);
			
			if($this->db->affected_rows())
				return $temp_update;
			else
				return '0';
		}
		

	function penyerahan_bahan_batal($kwitansi_id ,$kwitansi_status ,$kwitansi_update ){
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
	function hasilprod_create($hasil_no, $hasil_tanggal, $hasil_keterangan, $hasil_status, $hasil_produksi,
			$array_dhasil_id, $dhasil_master, $array_dhasil_produk, $array_dhasil_satuan, $array_dhasil_jumlah, $array_dhasil_keterangan, $cetak){
							
			$datetime_now = date('Y-m-d H:i:s');
			$time_now = date('H:i:s');
			$datetime_create = $hasil_tanggal.' '.$time_now;
			$produksi_date_create = date('Y-m-d H:i:s', strtotime($datetime_create));
		
			$hasil_tanggal_pattern=strtotime($hasil_tanggal);

			$pattern="HP"."/".date('ym')."-";
			$hasil_no=$this->m_public_function->get_kode_1("master_hasil_produksi","hasil_no",$pattern,12);
			$data = array(
				"hasil_no"=>$hasil_no, 
				"hasil_tanggal"=>$hasil_tanggal,
				"hasil_produksi"=>$hasil_produksi,
				"hasil_keterangan"=>$hasil_keterangan,
				"hasil_creator"=>$_SESSION[SESSION_USERID],
				"hasil_date_create"=>$datetime_now
			);

			if($cetak==1)
				$data['hasil_status'] = 'Tertutup';
			else
				$data['hasil_status'] = 'Terbuka';

			$this->db->insert('master_hasil_produksi', $data); 
			
		 	//function insert detail disini
			$temp_insert = $this->detail_hasilproduksi_insert($array_dhasil_id, $dhasil_master, $array_dhasil_produk, $array_dhasil_satuan, $array_dhasil_jumlah, $array_dhasil_keterangan, $cetak);
			
			if($this->db->affected_rows())
				return $temp_insert;
			else
				return '0';
		
		}
		
		//fcuntion for delete record
		function penyerahan_bahan_delete($pkid){
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
		function penyerahan_bahan_search($kwitansi_no ,$kwitansi_cust , $kwitansi_tanggal_start, $kwitansi_tanggal_end,$kwitansi_keterangan ,$kwitansi_status , $dfcl_status, $final_status, $start,$end){
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
		function penyerahan_bahan_print($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
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
		function penyerahan_bahan_excel($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter){
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