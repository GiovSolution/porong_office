<? /* 	
	Miracle IT Team
*/

class M_master_jual_rawat extends Model{
		
	//constructor
	function M_master_jual_rawat() {
		parent::Model();
	}
	
	function get_info_pajak(){
		$sql="SELECT cabang_pajak FROM cabang where cabang_id = (select info_cabang from info) and cabang_pajak = '1'";
		
		$result = $this->db->query($sql);		
		$nbrows = $result->num_rows();
		return $nbrows;
	}
	
	function get_allkaryawan_list($query,$start,$end){
		$sql="SELECT karyawan_id,karyawan_no,karyawan_username,karyawan_nama,karyawan_tgllahir,karyawan_alamat
		FROM vu_karyawan where karyawan_aktif='Aktif'";
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
			case "Customer": $order_by=" ORDER BY cust_id ASC";break;
			case "Karyawan": $order_by=" ORDER BY cust_id ASC";break;
			case "No Faktur": $order_by=" ORDER BY no_bukti ASC";break;
			case "Perawatan Semua": $order_by=" ORDER BY produk_id ASC";break;
			case "Perawatan Medis": $order_by="AND kategori_nama = 'Medis' ORDER BY produk_id ASC";break;
			case "Perawatan Non Medis": $order_by="AND kategori_nama = 'Non Medis' ORDER BY produk_id ASC";break;
			case "Perawatan Surgery": $order_by="AND kategori_nama = 'Surgery' ORDER BY produk_id ASC";break;
			case "Perawatan Anti Aging": $order_by="AND kategori_nama = 'Anti Aging' ORDER BY produk_id ASC";break;
			case "Perawatan Lain-Lain": $order_by="AND kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging' ORDER BY produk_id ASC";break;
			case "Referal": $order_by=" ORDER BY sales ASC";break;
			case "Jenis Diskon": $order_by=" ORDER BY diskon_jenis ASC";break;
			default: $order_by=" ORDER BY no_bukti ASC";break;
		}
		
		if($opsi=='rekap'){		
			if($periode=='all')
				$sql="SELECT distinct * FROM vu_trans_rawat WHERE jrawat_stat_dok='Tertutup'  ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT distinct * FROM vu_trans_rawat WHERE jrawat_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT distinct * FROM vu_trans_rawat WHERE jrawat_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
		}else if($opsi=='detail'){
			if($opsi_status=='semua') {
				if($periode=='all')
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Terbuka' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Terbuka' AND date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')	
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Terbuka' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}  else if($opsi_status=='tertutup') {
				if($periode=='all')
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok='Tertutup' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT  * FROM vu_detail_jual_rawat WHERE jrawat_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}		
		}
		else if($opsi=='grooming'){
			if($periode=='all')
				$sql="SELECT  * FROM vu_detail_jual_rawat_grooming WHERE jrawat_grooming <> 0 and jrawat_stat_dok='Tertutup' ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT  * FROM vu_detail_jual_rawat_grooming WHERE jrawat_grooming <> 0 and jrawat_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT  * FROM vu_detail_jual_rawat_grooming WHERE jrawat_grooming <> 0 and jrawat_stat_dok='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
		}
		
		$query=$this->db->query($sql);
		return $query->result();
	}
	
	function get_total_item($tgl_awal,$tgl_akhir,$periode,$opsi){
		$sql="";
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}else if($opsi=='detail'){
			if($periode=='all')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal'";
			else if($periode=='bulan')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(jumlah_barang) as total_item FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_item;
		}else
			return "";
	}
	
	function get_total_diskon($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(cashback) as total_diskon FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(cashback) as total_diskon FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(cashback) as total_diskon FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}else if($opsi=='detail'){
			if($periode=='all')
				$sql="SELECT SUM(diskon_nilai) as total_diskon FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal'";
			else if($periode=='bulan')
				$sql="SELECT SUM(diskon_nilai) as total_diskon FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(diskon_nilai) as total_diskon FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_diskon;
		}else
			return "";
	}
	
	function get_total_nilai($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(total_nilai) as total_nilai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  ";
			else if($periode=='bulan')
				$sql="SELECT SUM(total_nilai) as total_nilai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(total_nilai) as total_nilai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}else if($opsi=='detail'){
			if($periode=='all')
				$sql="SELECT SUM(subtotal) as total_nilai FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal'";
			else if($periode=='bulan')
				$sql="SELECT SUM(subtotal) as total_nilai FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(subtotal) as total_nilai FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_nilai;
		}else
			return "";
	}
	
	function get_total_bayar($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(total_bayar) as total_bayar FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  ";
			else if($periode=='bulan')
				$sql="SELECT SUM(total_bayar) as total_bayar FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(total_bayar) as total_bayar FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}else if($opsi=='detail'){
			if($periode=='all')
				$sql="SELECT SUM(subtotal) as total_bayar FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal'";
			else if($periode=='bulan')
				$sql="SELECT SUM(subtotal) as total_bayar FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(subtotal) as total_bayar FROM vu_detail_jual_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_bayar;
		}else
			return "";
	}
	
	function get_total_cek($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(cek) as total_cek FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  ";
			else if($periode=='bulan')
				$sql="SELECT SUM(cek) as total_cek FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(cek) as total_cek FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_cek;
		}else
			return "";
	}
	
	function get_total_tunai($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(tunai) as total_tunai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(tunai) as total_tunai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(tunai) as total_tunai FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal'  AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_tunai;
		}else
			return "";
	}
	
	function get_total_transfer($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(transfer) as total_transfer FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(transfer) as total_transfer FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(transfer) as total_transfer FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_transfer;
		}else
			return "";
	}
	
	function get_total_card($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(card) as total_card FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(card) as total_card FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(card) as total_card FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_card;
		}else
			return "";
	}
	
	function get_total_kredit($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(kredit) as total_kredit FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(kredit) as total_kredit FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(kredit) as total_kredit FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_kredit;
		}else
			return "";
	}
	
	function get_total_kuitansi($tgl_awal,$tgl_akhir,$periode,$opsi){
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT SUM(kuitansi) as total_kuitansi FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' ";
			else if($periode=='bulan')
				$sql="SELECT SUM(kuitansi) as total_kuitansi FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal, '%Y-%m') like  '".$tgl_awal."%'";
			else if($periode=='tanggal')
				$sql="SELECT SUM(kuitansi) as total_kuitansi FROM vu_trans_rawat WHERE jrawat_stat_dok<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$data=$query->row();
			return $data->total_kuitansi;
		}else
			return "";
	}
	
	function get_referal_list($query){
			$sql=  "SELECT 
						karyawan_id,karyawan_nama,karyawan_username
					FROM vu_karyawan 
					INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
					WHERE karyawan_aktif='Aktif' AND (jabatan_nama='Dokter' OR jabatan_nama='Therapist' OR jabatan_nama='Staff')";
			if($query<>"" && is_numeric($query)==false){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (karyawan_username LIKE '%".addslashes($query)."%')";
			}
		
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
	
	
	
	//fungsi untuk pengambilan paket
	//get record list
	function detail_ambil_paket_list($dpaket_id,$tanggal,$dapaket_cust,$query,$dapaket_stat_dok,$start,$end, $dapaket_nobukti_pajak, $dapaket_nobukti_medis) {
		$date_now=date('Y-m-d');
		/* ambil history pengambilan paket dari $master_id===customer_id untuk transaksi hari ini */
		$query = "/*SELECT *
						FROM vu_detail_ambil_paket_rawat
						WHERE tanggal='$tanggal'
						AND dapaket_cust='$dapaket_cust'
						AND dapaket_stat_dok='$dapaket_stat_dok'
						AND dapaket_nobukti_pajak = '$dapaket_nobukti_pajak' (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')
					UNION
					SELECT *
						FROM vu_detail_ambil_paket_rawat
						WHERE tanggal='$tanggal'
						AND dapaket_cust='$dapaket_cust'
						AND dapaket_stat_dok='$dapaket_stat_dok'
						AND dapaket_nobukti_medis='$dapaket_nobukti_medis' AND kategori_nama = 'Medis'*/
						
				SELECT dapaket_id
				,jpaket_nobukti
				,paket_nama
				,vu_perawatan.rawat_nama
				,dapaket_jumlah
				,pemakai.cust_nama
				,CONCAT(pemilik.cust_nama, ' (', pemilik.cust_no, ')') as cust_display
				,(ifnull(((((((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100) * detail_jual_paket.dpaket_jumlah) - (((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100)) * detail_jual_paket.dpaket_jumlah) / 100)) / detail_jual_paket.dpaket_jumlah) / (detail_jual_paket.dpaket_isi_paket / detail_jual_paket.dpaket_jumlah)),0) / 1.1) as dpp
				,(ifnull((((((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100) * detail_jual_paket.dpaket_jumlah) - (((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100)) * detail_jual_paket.dpaket_jumlah) / 100)) / detail_jual_paket.dpaket_isi_paket),0) - if((master_jual_paket.jpaket_tanggal < '2012-01-01'),0,(master_jual_paket.jpaket_cashback / (select sum(dj2.dpaket_isi_paket) AS a from detail_jual_paket dj2 where (dj2.dpaket_master = master_jual_paket.jpaket_id))))) as harga_satuan
				,((ifnull(((((((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100) * detail_jual_paket.dpaket_jumlah) - (((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_harga * (100 - detail_jual_paket.dpaket_diskon)) / 100)) * detail_jual_paket.dpaket_jumlah) / 100)) / detail_jual_paket.dpaket_jumlah) / (detail_jual_paket.dpaket_isi_paket / detail_jual_paket.dpaket_jumlah)),0) / 1.1) * detail_ambil_paket.dapaket_jumlah) as sub_tot_dpp
				,vu_perawatan.kategori_nama as kategori_nama
				,detail_ambil_paket.dapaket_nobukti_medis as dapaket_nobukti_medis
			FROM detail_ambil_paket
			LEFT JOIN master_jual_paket ON(dapaket_jpaket=jpaket_id)
			LEFT JOIN paket ON(dapaket_paket=paket_id)
			left JOIN vu_perawatan ON((detail_ambil_paket.dapaket_item = vu_perawatan.rawat_id)) 
			LEFT JOIN customer as pemakai ON(detail_ambil_paket.dapaket_cust=pemakai.cust_id)
			LEFT JOIN customer as pemilik ON(master_jual_paket.jpaket_cust=pemilik.cust_id)
			LEFT JOIN perawatan ON(dapaket_item=perawatan.rawat_id)
			left JOIN detail_jual_paket ON((detail_ambil_paket.dapaket_dpaket = detail_jual_paket.dpaket_id)) 
			WHERE date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$tanggal'
				AND dapaket_cust='$dapaket_cust'
				AND dapaket_stat_dok='$dapaket_stat_dok'";
		
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
	
	//function for detail
	//get record list
	function detail_detail_jual_rawat_list($master_id,$query,$start,$end) {
		//$query = "SELECT *,drawat_harga*drawat_jumlah as drawat_subtotal, drawat_harga*drawat_jumlah*(100-drawat_diskon)/100 as drawat_subtotal_net FROM detail_jual_rawat where drawat_master='".$master_id."'";
		$query = "SELECT
				drawat_id
				,drawat_master
				,drawat_rawat
				,drawat_jumlah
				,drawat_harga
				,drawat_diskon
				,drawat_sales
				,drawat_diskon_jenis
				,drawat_harga*drawat_jumlah as drawat_subtotal
				,drawat_harga*drawat_jumlah*(100-drawat_diskon)/100 as drawat_subtotal_net
				,dtrawat_keterangan
				,IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username) AS referal
				,drawat_dtrawat
				,kategori_nama
			FROM detail_jual_rawat
			LEFT JOIN perawatan ON(rawat_id=drawat_rawat)
			LEFT JOIN tindakan_detail ON(drawat_dtrawat=dtrawat_id)
			LEFT JOIN vu_karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
			LEFT JOIN vu_karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
			LEFT JOIN kategori ON(perawatan.rawat_kategori = kategori.kategori_id)
			WHERE drawat_master='".$master_id."'";
		
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		//$limit = $query." LIMIT ".$start.",".$end;			
		//$result = $this->db->query($limit);  
		
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
		$sql = "SELECT * FROM voucher,voucher_kupon WHERE kvoucher_master=voucher_id";
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
		//2010-07-04 ==> $query = "SELECT max(jrawat_id) AS master_id FROM master_jual_rawat WHERE jrawat_update='".$_SESSION[SESSION_USERID]."'";
		$query = "SELECT max(jrawat_id) AS master_id FROM master_jual_rawat WHERE jrawat_creator='".$_SESSION[SESSION_USERID]."'";
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
	
	function member_point_update($jrawat_id){
		$date_now=date('Y-m-d');
		
		$sqlu = "UPDATE master_jual_rawat JOIN (SELECT vu_jrawat_total_point.jrawat_id, 
						vu_jrawat_total_point.jrawat_total_point
					FROM vu_jrawat_total_point
					WHERE vu_jrawat_total_point.jrawat_id = ".$jrawat_id."
					LIMIT 1) AS vu_jrawat_total_point_temp ON (vu_jrawat_total_point_temp.jrawat_id = master_jual_rawat.jrawat_id)
			SET master_jual_rawat.jrawat_point = vu_jrawat_total_point_temp.jrawat_total_point
			WHERE master_jual_rawat.jrawat_id=".$jrawat_id;
		$this->db->query($sqlu);
		if($this->db->affected_rows()){
			$sqlu_cust = "UPDATE customer JOIN (SELECT vu_jrawat_total_point.jrawat_id, 
							vu_jrawat_total_point.jrawat_cust,
							vu_jrawat_total_point.jrawat_total_point
						FROM vu_jrawat_total_point
						WHERE vu_jrawat_total_point.jrawat_id = ".$jrawat_id."
						LIMIT 1) AS vu_jrawat_total_point_temp 
				SET customer.cust_point = (customer.cust_point + vu_jrawat_total_point_temp.jrawat_total_point)
				WHERE vu_jrawat_total_point_temp.jrawat_cust = customer.cust_id";
			$this->db->query($sqlu_cust);
			if($this->db->affected_rows()>-1){
				return 1;
			}
		}else{
			return 1;
		}
		
	}
	
	function member_point_delete($drawat_master){
		$date_now=date('Y-m-d');
		
		$sql="SELECT jrawat_cust FROM master_jual_rawat WHERE jrawat_id='$drawat_master'";
		$rs=$this->db->query($sql);
		$record=$rs->row_array();
		$jrawat_cust=$record['jrawat_cust'];
		
		$sql="SELECT member_id FROM member WHERE member_cust='$jrawat_cust' AND (member_valid >= '$date_now')";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$sql="SELECT setmember_point_perrp FROM member_setup LIMIT 1";
			$rs=$this->db->query($sql);
			$record=$rs->row_array();
			$setmember_point_perrp=$record['setmember_point_perrp'];
			
			$sql="SELECT drawat_jumlah, drawat_harga, rawat_point, drawat_diskon, jrawat_diskon, jrawat_cashback FROM detail_jual_rawat LEFT JOIN master_jual_rawat ON(drawat_master=jrawat_id) LEFT JOIN rawat ON(drawat_rawat=rawat_id) WHERE drawat_master='$drawat_master'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$one_record = $rs->row();
				$jrawat_cashback = $one_record->jrawat_cashback;
				$jrawat_diskon = $one_record->jrawat_diskon;
				$jumlah_rupiah = 0;
				$jumlah_point = 0;
				foreach($rs->result() as $row){
					//$jumlah_point += ($row->drawat_jumlah) * ($row->rawat_point) * (floor(($row->drawat_harga)/$setmember_point_perrp));
					$jumlah_rupiah += ($row->drawat_jumlah) * ($row->rawat_point) * ($row->drawat_harga) * ((100 - $row->drawat_diskon)/100);
				}
				$jumlah_rupiah -= $jrawat_cashback;
				if($setmember_point_perrp<>0){
					$jumlah_point = floor($jumlah_rupiah/$setmember_point_perrp);
				}
				$sql="UPDATE customer SET cust_point = (cust_point - $jumlah_point) WHERE cust_id='$jrawat_cust'";
				$this->db->query($sql);
				return 1;
			}else{
				return 1;
			}
		}else{
			return 1;
		}
	}
	
	function member_point_batal($jrawat_id){
		$sqlu = "UPDATE customer, master_jual_rawat
			SET customer.cust_point = (customer.cust_point - jrawat_point)
			WHERE master_jual_rawat.jrawat_id='".$jrawat_id."'
				AND customer.cust_id=master_jual_rawat.jrawat_cust";
		$this->db->query($sqlu);
		if($this->db->affected_rows()>-1){
			return 1;
		}
	}
	
	function cara_bayar_batal($jrawat_id){
		//updating db.jual_card ==> pembatalan
		$sqlu_jcard = "UPDATE jual_card JOIN master_jual_rawat ON(jual_card.jcard_ref=master_jual_rawat.jrawat_nobukti)
			SET jual_card.jcard_stat_dok = master_jual_rawat.jrawat_stat_dok
			WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
		$this->db->query($sqlu_jcard);
		if($this->db->affected_rows()>-1){
			//updating db.jual_cek ==> pembatalan
			$sqlu_jcek = "UPDATE jual_cek JOIN master_jual_rawat ON(jual_cek.jcek_ref=master_jual_rawat.jrawat_nobukti)
				SET jual_cek.jcek_stat_dok = master_jual_rawat.jrawat_stat_dok
				WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
			$this->db->query($sqlu_jcek);
			if($this->db->affected_rows()>-1){
				//updating db.jual_kwitansi ==> pembatalan
				$sqlu_jkwitansi = "UPDATE jual_kwitansi JOIN master_jual_rawat ON(jual_kwitansi.jkwitansi_ref=master_jual_rawat.jrawat_nobukti)
					SET jual_kwitansi.jkwitansi_stat_dok = master_jual_rawat.jrawat_stat_dok
					WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
				$this->db->query($sqlu_jkwitansi);
				if($this->db->affected_rows()>-1){
					$sql = "SELECT jkwitansi_master
						FROM jual_kwitansi
						JOIN master_jual_rawat ON(jkwitansi_ref=jrawat_nobukti)
						WHERE jrawat_id='".$jrawat_id."'";
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
					$sqlu_jtransfer = "UPDATE jual_transfer JOIN master_jual_rawat ON(jual_transfer.jtransfer_ref=master_jual_rawat.jrawat_nobukti)
						SET jual_transfer.jtransfer_stat_dok = master_jual_rawat.jrawat_stat_dok
						WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
					$this->db->query($sqlu_jtransfer);
					if($this->db->affected_rows()>-1){
						//updating db.jual_tunai ==> pembatalan
						$sqlu_jtunai = "UPDATE jual_tunai JOIN master_jual_rawat ON(jual_tunai.jtunai_ref=master_jual_rawat.jrawat_nobukti)
							SET jual_tunai.jtunai_stat_dok = master_jual_rawat.jrawat_stat_dok
							WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
						$this->db->query($sqlu_jtunai);
						if($this->db->affected_rows()>-1){
							//updating db.voucher_terima ==> pembatalan
							$sqlu_tvoucher = "UPDATE voucher_terima JOIN master_jual_rawat ON(voucher_terima.tvoucher_ref=master_jual_rawat.jrawat_nobukti)
								SET voucher_terima.tvoucher_stat_dok = master_jual_rawat.jrawat_stat_dok
								WHERE master_jual_rawat.jrawat_id='$jrawat_id'";
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
	
	function catatan_piutang_update($jrawat_id){
		$sql="SELECT * FROM vu_piutang_jrawat WHERE jrawat_id='$jrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$lpiutang_faktur=$rs_record["jrawat_nobukti"];
			$lpiutang_cust=$rs_record["jrawat_cust"];
			$lpiutang_faktur_tanggal=$rs_record["jrawat_tanggal"];
			$lpiutang_total=$rs_record["piutang_total"];
			/* ini artinya: No.Faktur Penjualan Produk ini masih BELUM LUNAS */
			/* untuk itu, No.Faktur ini akan dimasukkan ke db.master_lunas_piutang sebagai daftar yang harus ditagihkan ke Customer */
			
			/* Checking terlebih dahulu ke db.master_lunas_piutang WHERE =$lpiutang_faktur:
			* JIKA 'ada' ==> Lakukan UPDATE db.master_lunas_piutang
			* JIKA 'tidak ada' ==> Lakukan INSERT db.master_lunas_piutang
			*/
			$sql="SELECT * FROM master_lunas_piutang WHERE lpiutang_faktur='".$lpiutang_faktur."'";
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
					"lpiutang_jenis_transaksi"=>'jual_rawat',
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
				"lpiutang_jenis_transaksi"=>'jual_rawat',
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
	
	function catatan_piutang_batal($jrawat_id){
		/* 1. Cari jrawat_nobukti
		 * 2. UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
		*/
		$datetime_now = date('Y-m-d H:i:s');
		
		$sql = "SELECT jrawat_nobukti FROM master_jual_rawat WHERE jrawat_id='".$jrawat_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jrawat_nobukti = $record['jrawat_nobukti'];
			
			//UPDATE db.master_lunas_piutang.lpiutang_stat_dok = 'Batal'
			$sqlu = "UPDATE master_lunas_piutang
				SET lpiutang_stat_dok='Batal'
					,lpiutang_update='".@$_SESSION[SESSION_USERID]."'
					,lpiutang_date_update='".$datetime_now."'
					,lpiutang_revised=(lpiutang_revised+1)
				WHERE lpiutang_faktur='".$jrawat_nobukti."'";
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
	
	function membership_insert($jrawat_id){
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
		
		$sql="SELECT jrawat_cust
				,jrawat_tanggal
			FROM master_jual_rawat
			WHERE jrawat_id='$jrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$cust_id = $rs_record['jrawat_cust'];
			$tanggal_transaksi = $rs_record['jrawat_tanggal'];
			
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
			
			$sql="SELECT 
					member_cust, 
					member_valid, 
					case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end as member_no
				FROM member 
				WHERE member_cust='$cust_id'";
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
					//* check tanggal member_valid, apakah member_valid > $date_now ? /
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
	
	//purge all detail from master
	function detail_detail_jual_rawat_purge($master_id){
		$result_point_delete = $this->member_point_delete($master_id);
		if($result_point_delete==1){
			$sql="DELETE from detail_jual_rawat where drawat_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
	}
	//*eof
	
	function detail_jual_rawat_cu($array_drawat_id
									  ,$drawat_master
									  ,$array_drawat_dtrawat
									  ,$array_drawat_rawat
									  ,$array_drawat_jumlah
									  ,$array_drawat_harga
									  ,$array_drawat_diskon
									  ,$array_drawat_diskon_jenis
									  ,$array_drawat_sales
									  ,$cetak
									  ,$cust_id
									  ,$tanggal_transaksi){
		/*if($drawat_master=="" || $drawat_master==NULL || $drawat_master==0){
			$drawat_master=$this->get_master_id();
		}*/
		if($drawat_master=="" || $drawat_master==NULL || $drawat_master==0){
			$sql = "SELECT jrawat_id
				FROM master_jual_rawat
				WHERE jrawat_cust='".$cust_id."'
					AND jrawat_tanggal='".$tanggal_transaksi."'
					AND jrawat_stat_dok='Terbuka'";
			$rs = $this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$drawat_master = $record['jrawat_id'];
			}
			
		}
		
		$size_array = sizeof($array_drawat_rawat) - 1;
		if((sizeof($array_drawat_rawat))>0){
			for($i = 0; $i < sizeof($array_drawat_rawat); $i++){
				$drawat_id = $array_drawat_id[$i];
				$drawat_dtrawat = $array_drawat_dtrawat[$i];
				$drawat_rawat = $array_drawat_rawat[$i];
				$drawat_jumlah = $array_drawat_jumlah[$i];
				$drawat_harga = $array_drawat_harga[$i];
				$drawat_diskon = $array_drawat_diskon[$i];
				$drawat_diskon_jenis = $array_drawat_diskon_jenis[$i];
				$drawat_sales = $array_drawat_sales[$i];
				
				if($drawat_id==0){
					//* Insert to db.detail_jual_rawat WHERE detail yang ditambahkan adalah data baru /
					$dti_drawat=array(
					"drawat_master"=>$drawat_master,
					"drawat_rawat"=>$drawat_rawat,
					"drawat_jumlah"=>$drawat_jumlah,
					"drawat_harga"=>$drawat_harga,
					"drawat_diskon"=>$drawat_diskon,
					"drawat_diskon_jenis"=>$drawat_diskon_jenis,
					"drawat_sales"=>$drawat_sales
					);
                    $this->db->query('LOCK TABLE detail_jual_rawat WRITE');
					$this->db->insert('detail_jual_rawat', $dti_drawat);
                    $this->db->query('UNLOCK TABLES');
                    
				}elseif(($drawat_id>0) && ($drawat_dtrawat==0)){
					//* Update to db.detail_jual_rawat WHERE detail yang ditambahkan dari Kasir Perawatan bukan dari Tindakan /
					$dtu_drawat=array(
					"drawat_rawat"=>$drawat_rawat,
					"drawat_jumlah"=>$drawat_jumlah,
					"drawat_harga"=>$drawat_harga,
					"drawat_diskon"=>$drawat_diskon,
					"drawat_diskon_jenis"=>$drawat_diskon_jenis,
					"drawat_sales"=>$drawat_sales
					);
                    $this->db->query('LOCK TABLE detail_jual_rawat WRITE');
					$this->db->where('drawat_id', $drawat_id);
					$this->db->update('detail_jual_rawat', $dtu_drawat);
                    $this->db->query('UNLOCK TABLES');
					
				}elseif(($drawat_id>0) && ($drawat_dtrawat>0)){
					//* Update to db.detail_jual_rawat WHERE data detail adalah dari Tindakan /
					$dtu_drawat=array(
					"drawat_diskon"=>$drawat_diskon,
					"drawat_diskon_jenis"=>$drawat_diskon_jenis
					);
                    $this->db->query('LOCK TABLE detail_jual_rawat WRITE');
					$this->db->where('drawat_id', $drawat_id);
					$this->db->update('detail_jual_rawat', $dtu_drawat);
                    $this->db->query('UNLOCK TABLES');
					
				}else{
					/* Belum diketahui */
				}
				
				if($i==$size_array && $cetak==1){
					//LOCKED db.tindakan_detail
					$sql="SELECT drawat_dtrawat
						FROM detail_jual_rawat
						WHERE drawat_master='".$drawat_master."'
							AND drawat_dtrawat > 0";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$sql="UPDATE tindakan_detail SET dtrawat_locked=1 ";
						foreach($rs->result() as $row_drawat){
							$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
							$sql.="dtrawat_id='".$row_drawat->drawat_dtrawat."' ";
						}
						$this->db->query($sql);
					}
					
					return 0;
					
				}elseif($i==$size_array && $cetak==0){
					return 0;
				}
				
			}
		}else{
			return 0;
		}
		
	}
	
	//fcuntion for delete record
	function master_jual_rawat_delete($jrawat_id){
		/*
		 * DELETE db.master_jual_rawat akibatnya adalah
		 * 1. Harus men-DELETE juga Cara Bayar-nya
		 * NB: Tidak men-delete db.master_lunas_piutang <== karena db.master_lunas_piutang ter-Create saat terjadi Print Faktur (status_dokumen = 'Tertutup'), dan
		 * proses delete hanya terjadi di DETAIL Penjualan Perawatan. Jika status_dokumen = 'Tertutup', maka tombol 'delete' di-disable,
		 * sehingga proses delete tidak pernah terjadi.
		*/
		$sql = "SELECT jrawat_nobukti,jrawat_cara,jrawat_cara2,jrawat_cara3 FROM master_jual_rawat WHERE jrawat_id='".$jrawat_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jrawat_nobukti = $record['jrawat_nobukti'];
			$jrawat_cara = $record['jrawat_cara'];
			$jrawat_cara2 = $record['jrawat_cara2'];
			$jrawat_cara3 = $record['jrawat_cara3'];
			
			if($jrawat_cara=='tunai'){
				$sqld = "DELETE FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara=='kwitansi'){
				$sqld = "DELETE FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara=='card'){
				$sqld = "DELETE FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara=='cek/giro'){
				$sqld = "DELETE FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara=='transfer'){
				$sqld = "DELETE FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara=='voucher'){
				$sqld = "DELETE FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}
			
			if($jrawat_cara2=='tunai'){
				$sqld = "DELETE FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara2=='kwitansi'){
				$sqld = "DELETE FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara2=='card'){
				$sqld = "DELETE FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara2=='cek/giro'){
				$sqld = "DELETE FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara2=='transfer'){
				$sqld = "DELETE FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara2=='voucher'){
				$sqld = "DELETE FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}
			
			if($jrawat_cara3=='tunai'){
				$sqld = "DELETE FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara3=='kwitansi'){
				$sqld = "DELETE FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara3=='card'){
				$sqld = "DELETE FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara3=='cek/giro'){
				$sqld = "DELETE FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara3=='transfer'){
				$sqld = "DELETE FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}elseif($jrawat_cara3=='voucher'){
				$sqld = "DELETE FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
				$this->db->query($sqld);
			}
			
			$sqld = "DELETE FROM master_jual_rawat WHERE jrawat_id='".$jrawat_id."'";
			$this->db->query($sqld);
			if($this->db->affected_rows()>-1){
				return 1;
			}
			
		}else{
			return 1;
		}
	}
	
	function detail_jual_rawat_delete($drawat_id ,$array_drawat_master){
		// You could do some checkups here and return '0' or other error consts.
		// Make a single query to delete all of the master_jual_rawats at the same time :
		if(sizeof($drawat_id)<1){
			return '0';
		} else if (sizeof($drawat_id) == 1){
			$query = "DELETE FROM detail_jual_rawat WHERE drawat_id = ".$drawat_id[0];
			$this->db->query($query);
			if($this->db->affected_rows()){
				/*
				 * CHECK db.detail_jual_rawat.drawat_master WHERE $array_drawat_master[0]
				 * ==> JIKA $array_drawat_master[0] TIDAK ADA di db.detail_jual_rawat, maka DELETE di db.master_jual_rawat
				*/
				$sql = "SELECT drawat_master FROM detail_jual_rawat WHERE drawat_master='".$array_drawat_master[0]."'";
				$this->db->query($sql);
				if($this->db->affected_rows()<1){
					$rs_jrawat_d = $this->master_jual_rawat_delete($array_drawat_master[0]);
					if($rs_jrawat_d==1){
						return '1';
					}
				}else{
					return '1';
				}
			}else{
				return '0';
			}
		} else {
			return '0';
		}
	}
    
    function jrawat_drawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cashback ,$jrawat_cashback_medis,$jrawat_bayar ,$jrawat_total
                                ,$jrawat_keterangan ,$jrawat_ket_disk ,$jrawat_ket_disk_medis, $datetime_now
                                ,$jrawat_cara
                                ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                                ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                                ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                                ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                                ,$jrawat_tunai_nilai
                                ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                                ,$jrawat_cara2
                                ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                                ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                                ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                                ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                                ,$jrawat_tunai_nilai2
                                ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                                ,$jrawat_cara3
                                ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                                ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                                ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                                ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                                ,$jrawat_tunai_nilai3
                                ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                                ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
                                ,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales
                                ,$jenis_transaksi ,$cetak, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3){
        $date_now = date('Y-m-d');
        
        $sql="SELECT jrawat_cara, jrawat_cara2, jrawat_cara3, jrawat_date_create, jrawat_revised FROM master_jual_rawat WHERE jrawat_id='$jrawat_id'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()){
            $rs_record=$rs->row_array();
            $jrawat_revised = $rs_record['jrawat_revised'];
        }
        //UPDATE table.master_jual_rawat
        $data = array(
            "jrawat_tanggal"=>$jrawat_tanggal, 
            "jrawat_diskon"=>$jrawat_diskon,
			"jrawat_nobukti"=>$jrawat_nobukti, 
			"jrawat_nobukti_medis"=>$jrawat_nobukti_medis, 
			"jrawat_nobukti_pajak"=>$jrawat_nobukti_pajak, 
			"jrawat_total_medis"=>$jrawat_total_medis, 
			"jrawat_total_nonmedis"=>$jrawat_total_nonmedis, 
            "jrawat_cashback"=>$jrawat_cashback,
			"jrawat_cashback_medis"=>$jrawat_cashback_medis,
            "jrawat_bayar"=>$jrawat_bayar,
            "jrawat_totalbiaya"=>$jrawat_total,
            "jrawat_keterangan"=>$jrawat_keterangan,
            "jrawat_ket_disk"=>$jrawat_ket_disk,
			"jrawat_ket_disk_medis"=>$jrawat_ket_disk_medis,
            "jrawat_update"=>$_SESSION[SESSION_USERID],
            "jrawat_date_update"=>$datetime_now,
            "jrawat_revised"=>$jrawat_revised+1
        );
        
        if($cetak==1 || $cetak==2){
            /* UPDATE db.master_jual_rawat.jrawat_stat_dok = 'Tertutup' */
            /*
			if($jrawat_tanggal<>$date_now){
                $jrawat_date_update = $jrawat_tanggal;
            }else{
                $jrawat_date_update = $datetime_now;
            }
			*/
            
            $data["jrawat_stat_dok"] = 'Tertutup';
        }
        /*
        if($jrawat_tanggal<>$date_now){
            $data["jrawat_date_update"] = $jrawat_tanggal;
            $bayar_date_create = $jrawat_tanggal;
        }else{
            $data["jrawat_date_update"] = $datetime_now;
            $bayar_date_create = $datetime_now;
        }
		*/
        if($jrawat_cara!=null){
            if(($jrawat_kwitansi_nilai<>'' && $jrawat_kwitansi_nilai<>0)
                || ($jrawat_card_nilai<>'' && $jrawat_card_nilai<>0)
                || ($jrawat_cek_nilai<>'' && $jrawat_cek_nilai<>0)
                || ($jrawat_transfer_nilai<>'' && $jrawat_transfer_nilai<>0)
                || ($jrawat_tunai_nilai<>'' && $jrawat_tunai_nilai<>0)
                || ($jrawat_voucher_cashback<>'' && $jrawat_voucher_cashback<>0)){
                $data["jrawat_cara"]=$jrawat_cara;
            }else{
                $data["jrawat_cara"]=NULL;
            }
        }
        if($jrawat_cara2!=null){
            if(($jrawat_kwitansi_nilai2<>'' && $jrawat_kwitansi_nilai2<>0)
                || ($jrawat_card_nilai2<>'' && $jrawat_card_nilai2<>0)
                || ($jrawat_cek_nilai2<>'' && $jrawat_cek_nilai2<>0)
                || ($jrawat_transfer_nilai2<>'' && $jrawat_transfer_nilai2<>0)
                || ($jrawat_tunai_nilai2<>'' && $jrawat_tunai_nilai2<>0)
                || ($jrawat_voucher_cashback2<>'' && $jrawat_voucher_cashback2<>0)){
                $data["jrawat_cara2"]=$jrawat_cara2;
            }else{
                $data["jrawat_cara2"]=NULL;
            }
        }
        if($jrawat_cara3!=null){
            if(($jrawat_kwitansi_nilai3<>'' && $jrawat_kwitansi_nilai3<>0)
                || ($jrawat_card_nilai3<>'' && $jrawat_card_nilai3<>0)
                || ($jrawat_cek_nilai3<>'' && $jrawat_cek_nilai3<>0)
                || ($jrawat_transfer_nilai3<>'' && $jrawat_transfer_nilai3<>0)
                || ($jrawat_tunai_nilai3<>'' && $jrawat_tunai_nilai3<>0)
                || ($jrawat_voucher_cashback3<>'' && $jrawat_voucher_cashback3<>0)){
                $data["jrawat_cara3"]=$jrawat_cara3;
            }else{
                $data["jrawat_cara3"]=NULL;
            }
        }
        $sql="select cust_id from customer where cust_id='".$jrawat_cust."'";
        $query=$this->db->query($sql);
        if($query->num_rows())
            $data["jrawat_cust"]=$jrawat_cust;
        
        $this->db->query('LOCK TABLE master_jual_rawat WRITE');
        $this->db->where('jrawat_id', $jrawat_id);
        $this->db->update('master_jual_rawat', $data);
        $affected_rows = $this->db->affected_rows();
        $this->db->query('UNLOCK TABLES');
        if($affected_rows>-1){
            $time_now = date('H:i:s');
            $bayar_date_create_temp = $jrawat_tanggal.' '.$time_now;
            $bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
            
            $this->detail_jual_rawat_cu($array_drawat_id ,$jrawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
                                        ,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis , $array_drawat_sales, 0 ,$jrawat_cust
                                        ,$jrawat_tanggal);
            
            $this->m_public_function->cara_bayar_ftpkpr_insert($jrawat_nobukti ,$jrawat_cara ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                       ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                       ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                       ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                       ,$jrawat_tunai_nilai
                       ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                       ,$jrawat_cara2
                       ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                       ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                       ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                       ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                       ,$jrawat_tunai_nilai2
                       ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                       ,$jrawat_cara3
                       ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                       ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                       ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                       ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                       ,$jrawat_tunai_nilai3
                       ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                       ,$bayar_date_create ,$jenis_transaksi ,$cetak, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
            
            return 1;
            
        }
    }
	
	//function for get list record
	function master_jual_rawat_list($filter,$start,$end){
		$date_now=date('Y-m-d');
		$query = "SELECT
				jrawat_id,
				jrawat_nobukti,
				karyawan_no,
				karyawan_nama,
				CONCAT(vu_jrawat_pr.cust_nama, ' (', vu_jrawat_pr.cust_no, ')') as cust_nama_edit,
				cust_nama,
				cust_priority_star,
				jrawat_cust,
				vu_jrawat_pr.cust_no,
				vu_jrawat_pr.cust_member,
				vu_jrawat_pr.member_no,
				/*vu_jrawat_pr.member_valid,*/
				jrawat_tanggal,
				jrawat_diskon,
				jrawat_cashback,
				jrawat_cashback_medis,
				jrawat_cara,
				jrawat_cara2,
				jrawat_cara3,
				/*IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS jrawat_totalbiaya,*/
                /*vu_jrawat_totalbiaya.jrawat_totalbiaya AS jrawat_totalbiaya,*/
				   (select 
						((sum(((d.drawat_jumlah * d.drawat_harga) * ((100 - d.drawat_diskon) / 100))) * ((100 - m.jrawat_diskon) / 100)) - m.jrawat_cashback) - m.jrawat_cashback_medis
					from detail_jual_rawat d
					left join master_jual_rawat m on d.drawat_master = m.jrawat_id
					where m.jrawat_id = vu_jrawat_pr.jrawat_id
					group by d.drawat_master) as jrawat_totalbiaya,
				jrawat_bayar,
				jrawat_keterangan,
				jrawat_ket_disk,
				jrawat_ket_disk_medis,
				jrawat_stat_dok,
				jrawat_creator,
				jrawat_date_create,
				jrawat_update,
				jrawat_date_update,
				jrawat_revised,
				keterangan_paket,
				0 AS dpaket_id,
				jrawat_nobukti_pajak,
				jrawat_nobukti_medis
			FROM vu_jrawat_pr
			/*LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)*/
			LEFT JOIN vu_karyawan ON(vu_karyawan.karyawan_id = vu_jrawat_pr.jrawat_grooming)";
			
		// For simple search
		if ($filter<>""){
			$query .= " WHERE ";
			$query .= " (jrawat_nobukti LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%')";
		}
		else{
			$query .= " WHERE ";
			$query .= " vu_jrawat_pr.jrawat_stat_dok='Terbuka' AND date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d')='$date_now'";
		}
		
		//$query .= " ORDER BY jrawat_date_create DESC";
		//$query .= " UNION";
		
		// utk simple search, tidak perlu mencari pengambilan paket. 2012-03-01
		$query2 = "SELECT
				jrawat_id,
				jrawat_nobukti,
				0 as karyawan_no,
				0 as karyawan_nama,
				CONCAT(vu_jrawat_pk.cust_nama, ' (', vu_jrawat_pk.cust_no, ')') as cust_nama_edit,
				vu_jrawat_pk.cust_nama,
				cust_priority_star,
				jrawat_cust,
				vu_jrawat_pk.cust_no,
				vu_jrawat_pk.cust_member,
				vu_jrawat_pk.member_no,
				jrawat_tanggal,
				jrawat_diskon,
				jrawat_cashback,
				0 as cashback_medis,
				jrawat_cara,
				jrawat_cara2,
				jrawat_cara3,
				jrawat_totalbiaya,
				jrawat_bayar,
				jrawat_keterangan,
				0 as keterangan_diskon,
				0 as keterangan_diskon_medis,
				jrawat_creator,
				jrawat_date_create,
				jrawat_update,
				jrawat_date_update,
				jrawat_revised,
				keterangan_paket,
				dpaket_id,
				dapaket_stat_dok AS jrawat_stat_dok,
				dapaket_nobukti_pajak AS jrawat_nobukti_pajak,
				dapaket_nobukti_medis AS jrawat_nobukti_medis
			
			FROM vu_jrawat_pk
			WHERE date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d')='$date_now'
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d')='$date_now'
						AND vu_jrawat_pr.jrawat_stat_dok='Terbuka')
				AND vu_jrawat_pk.dapaket_stat_dok='Terbuka'";
		
		// For simple search
		if ($filter<>""){
			$query2 .=eregi("WHERE",$query2)? " AND ":" WHERE ";
			$query2 .= " (jrawat_nobukti LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%')";
		}
		//$query2 .= " ORDER BY vu_jrawat_pk.dapaket_stat_dok DESC";
		
		$nbrows=0;
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();

		
		$nbrows2=0;
		$result2 = $this->db->query($query2);
		$nbrows2 = $result2->num_rows();
		
		if($nbrows>0 || $nbrows2>0){
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
			}
			if($nbrows2>0){
				foreach($result2->result() as $row2){
					$arr[] = $row2;
				}
			}
			$nbrows=$nbrows+$nbrows2;
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}
	
	//function for update record
	function master_jual_rawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal ,$jrawat_stat_dok, $jrawat_diskon
									  ,$jrawat_cara ,$jrawat_cara2 ,$jrawat_cara3 ,$jrawat_keterangan , $jrawat_cashback, $jrawat_cashback_medis,$jrawat_tunai_nilai
									  ,$jrawat_tunai_nilai2, $jrawat_tunai_nilai3, $jrawat_voucher_no, $jrawat_voucher_cashback
									  ,$jrawat_voucher_no2, $jrawat_voucher_cashback2, $jrawat_voucher_no3, $jrawat_voucher_cashback3
									  ,$jrawat_total, $jrawat_bayar, $jrawat_subtotal, $jrawat_hutang, $jrawat_kwitansi_no, $jrawat_kwitansi_nama
									  ,$jrawat_kwitansi_nilai, $jrawat_kwitansi_no2, $jrawat_kwitansi_nama2, $jrawat_kwitansi_nilai2
									  ,$jrawat_kwitansi_no3, $jrawat_kwitansi_nama3, $jrawat_kwitansi_nilai3, $jrawat_card_nama, $jrawat_card_edc
									  ,$jrawat_card_no, $jrawat_card_nilai, $jrawat_card_nama2, $jrawat_card_edc2, $jrawat_card_no2
									  ,$jrawat_card_nilai2, $jrawat_card_nama3, $jrawat_card_edc3, $jrawat_card_no3, $jrawat_card_nilai3
									  ,$jrawat_cek_nama, $jrawat_cek_no, $jrawat_cek_valid, $jrawat_cek_bank, $jrawat_cek_nilai, $jrawat_cek_nama2
									  ,$jrawat_cek_no2, $jrawat_cek_valid2, $jrawat_cek_bank2, $jrawat_cek_nilai2, $jrawat_cek_nama3
									  ,$jrawat_cek_no3, $jrawat_cek_valid3, $jrawat_cek_bank3, $jrawat_cek_nilai3, $jrawat_transfer_bank
									  ,$jrawat_transfer_nama, $jrawat_transfer_nilai, $jrawat_transfer_bank2, $jrawat_transfer_nama2
									  ,$jrawat_transfer_nilai2, $jrawat_transfer_bank3, $jrawat_transfer_nama3, $jrawat_transfer_nilai3
									  ,$cetak, $jrawat_ket_disk, $jrawat_ket_disk_medis,$drawat_count, $dcount_drawat_id
									  ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat
									  ,$array_drawat_jumlah ,$array_drawat_harga ,$array_drawat_diskon
									  ,$array_drawat_diskon_jenis, $array_drawat_sales, $array_drawat_karyawan, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3){
		$date_now = date('Y-m-d');
		$datetime_now = date('Y-m-d H:i:s');
		
		$jenis_transaksi = 'jual_rawat';
		
		$datetime_now = date('Y-m-d H:i:s');
		/*if ($jrawat_stat_dok=="")
			$jrawat_stat_dok = "Terbuka";*/
		$jrawat_revised=0;
		
		if($jrawat_nobukti<>''){
			$sql = "SELECT drawat_id
				FROM detail_jual_rawat
					JOIN master_jual_rawat ON(drawat_master=jrawat_id)
				WHERE jrawat_nobukti='".$jrawat_nobukti."'";
			$rs = $this->db->query($sql);
			$rs_rows = $rs->num_rows();
		}else{
			/*$sql = "SELECT drawat_id
				FROM detail_jual_rawat
					JOIN master_jual_rawat ON(drawat_master=jrawat_id)
				WHERE jrawat_cust='".$jrawat_cust."'
					AND jrawat_tanggal='".$jrawat_tanggal."'
					AND jrawat_stat_dok='Terbuka'";*/
			$sql = "SELECT jrawat_id
				FROM master_jual_rawat
				WHERE jrawat_cust='".$jrawat_cust."'
					AND jrawat_tanggal='".$jrawat_tanggal."'
					AND jrawat_stat_dok='Terbuka'";
			$rs = $this->db->query($sql);
			$rs_rows = $rs->num_rows();
		}
		
		if($jrawat_nobukti==''){
			if(($rs_rows>0) && ((sizeof($array_drawat_rawat))<1)){
				return '-7';
			}else if((sizeof($array_drawat_rawat))>0){
				/*
				 * Ketika di Pengambilan Paket saja, terjadi penambahan Detail Penjualan Perawatan
				 * 1. Check apakah Customer ini punya Faktur Perawatan yang masih terbuka di Tanggal-Transaksi
				 * 2. JIKA YA ==> Ambil db.master_jual_rawat.jrawat_id dari Faktur dgn status "Terbuka" itu untuk menjadi db.detail_jual_rawat.drawat_master
				 * 3. ==> Insert db.detail_jual_rawat dengan [drawat_master] = [jrawat_id dari No.2]
				 * 2. JIKA TIDAK ==> maka Create Faktur Baru (gunakan function master_jual_rawat_create())
				 * 3. ==> Insert db.detail_jual_rawat dengan [drawat_master] = [select jrawat_id dari db.master_jual_rawat yang di tanggal transaksi dan status="Terbuka"]
				 * 4. Selesai Tanpa Cetak Faktur (List-View di Reload)
				*/
				if($rs_rows>0){
					//Customer MEMILIKI Faktur Perawatan yang masih terbuka
					$record = $rs->row_array();
					$jrawat_id = $record['jrawat_id'];
					$rs_drawat_cu = $this->detail_jual_rawat_cu($array_drawat_id ,$jrawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
												,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis , $array_drawat_sales, 0 ,$jrawat_cust
												,$jrawat_tanggal);
					return $rs_drawat_cu;
				}else{
					//Customer TIDAK MEMILIKI Faktur Perawatan yang masih terbuka
					$rs_jrawat = $this->master_jual_rawat_create($jrawat_cust ,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cara ,'Terbuka' , $jrawat_cara2 ,$jrawat_cara3
													,$jrawat_keterangan , $jrawat_cashback,$jrawat_cashback_medis, $jrawat_tunai_nilai, $jrawat_tunai_nilai2, $jrawat_tunai_nilai3
													,$jrawat_voucher_no, $jrawat_voucher_cashback, $jrawat_voucher_no2, $jrawat_voucher_cashback2
													,$jrawat_voucher_no3, $jrawat_voucher_cashback3, $jrawat_total, $jrawat_bayar, $jrawat_subtotal
													,$jrawat_hutang, $jrawat_kwitansi_no, $jrawat_kwitansi_nama, $jrawat_kwitansi_nilai, $jrawat_kwitansi_no2
													,$jrawat_kwitansi_nama2, $jrawat_kwitansi_nilai2, $jrawat_kwitansi_no3, $jrawat_kwitansi_nama3
													,$jrawat_kwitansi_nilai3, $jrawat_card_nama, $jrawat_card_edc, $jrawat_card_no, $jrawat_card_nilai
													,$jrawat_card_nama2, $jrawat_card_edc2, $jrawat_card_no2, $jrawat_card_nilai2, $jrawat_card_nama3
													,$jrawat_card_edc3, $jrawat_card_no3, $jrawat_card_nilai3, $jrawat_cek_nama, $jrawat_cek_no, $jrawat_cek_valid
													,$jrawat_cek_bank, $jrawat_cek_nilai, $jrawat_cek_nama2, $jrawat_cek_no2, $jrawat_cek_valid2
													,$jrawat_cek_bank2, $jrawat_cek_nilai2, $jrawat_cek_nama3, $jrawat_cek_no3, $jrawat_cek_valid3
													,$jrawat_cek_bank3, $jrawat_cek_nilai3, $jrawat_transfer_bank, $jrawat_transfer_nama, $jrawat_transfer_nilai
													,$jrawat_transfer_bank2, $jrawat_transfer_nama2, $jrawat_transfer_nilai2, $jrawat_transfer_bank3
													,$jrawat_transfer_nama3, $jrawat_transfer_nilai3 ,0 ,$jrawat_ket_disk, $jrawat_ket_disk_medis
													,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah ,$array_drawat_harga
													,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales, $array_drawat_karyawan,$jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
					if($rs_jrawat=='0'){
						/*$rs_drawat_cu = $this->detail_jual_rawat_cu($array_drawat_id ,0 ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
													,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis ,0 ,$jrawat_cust
													,$jrawat_tanggal);
						return $rs_drawat_cu;*/
                        return '0';
					}else{
						return $rs_jrawat;
					}
				}
			}else{
				return '-3';
			}
		}else if($jrawat_nobukti<>''){
			/*
			 * Masuk Faktur Perawatan Lepas
			 * ($dcount_drawat_id<1) <== tidak ada penambahan detail di View Kasir Penjualan Perawatan
			 * ($drawat_count==0) <== Faktur Perawatan tidak memiliki detail di View,, ini kesalahan belum ditemukan sebabnya, seharusnya Faktur Perawatan
			 * ...yang tidak punya detail akan di-Cancel dulu u/ dilakukan update List
			 * ($rs_rows==$drawat_count) <== antara View di Kasir Penjualan Perawatan sudah sama dengan detail di Database
			*/
			if(($dcount_drawat_id<1) && ($drawat_count>0) && ($rs_rows==$drawat_count)){
				/*
				 * $jrawat_id ==> milik dari db.master_jual_rawat
				 * 1. Checking db.detail_jual_rawat apakah == $drawat_count
				 * ==> JIKA sama, maka lanjutkan ke kondisi berikutnya(No.2)
				 * ==> JIKA tidak sama, maka kirim('return') "WARNING" bahwa "ada ketidaksamaan detail dengan database, maka dari itu silakan klik Tombol 'Save' atau 'Cancel' kemudian dibuka lagi."
				 * 2. Check apakah $cetak==1
				 * ==> JIKA sama, maka update status_dokumen dari db.master_jual_rawat terlebih dahulu untuk mengunci Faktur ini agar Tidak Ada detail dari Tindakan yang bisa masuk.
				 * ==> JIKA tidak sama, maka langsung dilanjutkan ke proses selanjutnya
				*/
                
                $jrawat_drawat_u = $this->jrawat_drawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cashback ,$jrawat_cashback_medis,$jrawat_bayar ,$jrawat_total
                                                            ,$jrawat_keterangan ,$jrawat_ket_disk ,$jrawat_ket_disk_medis,$datetime_now
                                                            ,$jrawat_cara
                                                            ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                                                            ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                                                            ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                                                            ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                                                            ,$jrawat_tunai_nilai
                                                            ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                                                            ,$jrawat_cara2
                                                            ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                                                            ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                                                            ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                                                            ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                                                            ,$jrawat_tunai_nilai2
                                                            ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                                                            ,$jrawat_cara3
                                                            ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                                                            ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                                                            ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                                                            ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                                                            ,$jrawat_tunai_nilai3
                                                            ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                                                            ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
                                                            ,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales
                                                            ,$jenis_transaksi ,$cetak, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
                
                if($jrawat_drawat_u==1){
                    if($cetak==1 || $cetak==2){
						//LOCKED db.tindakan_detail
						$sql="SELECT drawat_dtrawat
							FROM detail_jual_rawat
							WHERE drawat_master='".$jrawat_id."'
								AND drawat_dtrawat > 0";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							$sql="UPDATE tindakan_detail SET dtrawat_locked=1 ";
							foreach($rs->result() as $row_drawat){
								$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
								$sql.="dtrawat_id='".$row_drawat->drawat_dtrawat."' ";
							}
							$this->db->query($sql);
						}
						
						$result_point = $this->member_point_update($jrawat_id);
						if($result_point==1){
							$result_membership = $this->membership_insert($jrawat_id);
							if($result_membership==1){
								$result_piutang = $this->catatan_piutang_update($jrawat_id);
								if($result_piutang==1){
									return $jrawat_id;
								}
							}
						}
						
					}else{
						return '0';
					}
                }
				
			}else if(($dcount_drawat_id<1) && ($drawat_count>0) && ($rs_rows<>$drawat_count)){
				/*
				 * Tidak ada penambahan detail di View Kasir Penjualan Perawatan, tapi ada penambahan detail dari Tindakan
				 * maka keluarkan peringatan "untuk mengcancel terlebih dahulu, kemudian dibuka lagi"
				*/
                $cetak = 0;
                $this->jrawat_drawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cashback ,$jrawat_cashback_medis,$jrawat_bayar ,$jrawat_total
                                ,$jrawat_keterangan ,$jrawat_ket_disk ,$jrawat_ket_disk_medis,$datetime_now
                                ,$jrawat_cara
                                ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                                ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                                ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                                ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                                ,$jrawat_tunai_nilai
                                ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                                ,$jrawat_cara2
                                ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                                ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                                ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                                ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                                ,$jrawat_tunai_nilai2
                                ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                                ,$jrawat_cara3
                                ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                                ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                                ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                                ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                                ,$jrawat_tunai_nilai3
                                ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                                ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
                                ,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales
                                ,$jenis_transaksi ,$cetak, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
				return '-7';
			}else if(($dcount_drawat_id<1) && ($drawat_count==0) && ($rs_rows==0)){
				/*
				 * Faktur Perawatan ini tidak memiliki detail dan tidak ada penambahan detail di View Kasir Penjualan Perawatan (ini kesalahan)
				 * maka: Batalkan Faktur, kemudian mencetak Faktur Pengambilan Paket Saja
				*/
				$sqlu = "UPDATE master_jual_rawat
					SET jrawat_stat_dok='Batal'
						,jrawat_update='".@$_SESSION[SESSION_USERID]."'
						,jrawat_date_update='".$datetime_now."'
						,jrawat_revised=jrawat_revised+1
					WHERE jrawat_nobukti='$jrawat_nobukti'";
				$this->db->query('LOCK TABLE master_jual_rawat WRITE');
				$this->db->query($sqlu);
				$affected_rows = $this->db->affected_rows();
				$this->db->query('UNLOCK TABLES');
				
				if($cetak==1){
					return '-3';
				}else{
					return '-5';
				}
			}else if(($dcount_drawat_id>0)){
				/*
				 * di View Kasir Penjualan Perawatan ada penambahan detail baru
				*/
                $jrawat_drawat_u = $this->jrawat_drawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cashback ,$jrawat_cashback_medis, $jrawat_bayar ,$jrawat_total
                                                            ,$jrawat_keterangan ,$jrawat_ket_disk ,$jrawat_ket_disk_medis,$datetime_now
                                                            ,$jrawat_cara
                                                            ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                                                            ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                                                            ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                                                            ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                                                            ,$jrawat_tunai_nilai
                                                            ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                                                            ,$jrawat_cara2
                                                            ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                                                            ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                                                            ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                                                            ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                                                            ,$jrawat_tunai_nilai2
                                                            ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                                                            ,$jrawat_cara3
                                                            ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                                                            ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                                                            ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                                                            ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                                                            ,$jrawat_tunai_nilai3
                                                            ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                                                            ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
                                                            ,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales
                                                            ,$jenis_transaksi ,$cetak, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
                
                if($jrawat_drawat_u==1){
                    if($cetak==1 || $cetak==2){
                        $result_point = $this->member_point_update($jrawat_id);
                        if($result_point==1){
                            $result_membership = $this->membership_insert($jrawat_id);
                            if($result_membership==1){
                                $result_piutang = $this->catatan_piutang_update($jrawat_id);
                                if($result_piutang==1){
                                    return $jrawat_id;
                                }
                            }
                        }
                    }else{
                        return '0';
                    }
                }else{
                    return '-13';
                }
                
            }else{
				return '-11';
			}
			
		}else{
			return '-1';
		}
		
	}
	
	//function for create new record
	function master_jual_rawat_create($jrawat_cust ,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cara ,$jrawat_stat_dok, $jrawat_cara2 ,$jrawat_cara3
									  ,$jrawat_keterangan , $jrawat_cashback, $jrawat_cashback_medis,$jrawat_tunai_nilai, $jrawat_tunai_nilai2, $jrawat_tunai_nilai3
									  ,$jrawat_voucher_no, $jrawat_voucher_cashback, $jrawat_voucher_no2, $jrawat_voucher_cashback2
									  ,$jrawat_voucher_no3, $jrawat_voucher_cashback3, $jrawat_total, $jrawat_bayar, $jrawat_subtotal
									  ,$jrawat_hutang, $jrawat_kwitansi_no, $jrawat_kwitansi_nama, $jrawat_kwitansi_nilai, $jrawat_kwitansi_no2
									  ,$jrawat_kwitansi_nama2, $jrawat_kwitansi_nilai2, $jrawat_kwitansi_no3, $jrawat_kwitansi_nama3
									  ,$jrawat_kwitansi_nilai3, $jrawat_card_nama, $jrawat_card_edc, $jrawat_card_no, $jrawat_card_nilai
									  ,$jrawat_card_nama2, $jrawat_card_edc2, $jrawat_card_no2, $jrawat_card_nilai2, $jrawat_card_nama3
									  ,$jrawat_card_edc3, $jrawat_card_no3, $jrawat_card_nilai3, $jrawat_cek_nama, $jrawat_cek_no, $jrawat_cek_valid
									  ,$jrawat_cek_bank, $jrawat_cek_nilai, $jrawat_cek_nama2, $jrawat_cek_no2, $jrawat_cek_valid2
									  ,$jrawat_cek_bank2, $jrawat_cek_nilai2, $jrawat_cek_nama3, $jrawat_cek_no3, $jrawat_cek_valid3
									  ,$jrawat_cek_bank3, $jrawat_cek_nilai3, $jrawat_transfer_bank, $jrawat_transfer_nama, $jrawat_transfer_nilai
									  ,$jrawat_transfer_bank2, $jrawat_transfer_nama2, $jrawat_transfer_nilai2, $jrawat_transfer_bank3
									  ,$jrawat_transfer_nama3, $jrawat_transfer_nilai3, $cetak, $jrawat_ket_disk, $jrawat_ket_disk_medis
									  ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah ,$array_drawat_harga
									  ,$array_drawat_diskon ,$array_drawat_diskon_jenis, $array_drawat_sales, $array_drawat_karyawan, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3){
		$date_now = date('Y-m-d');
		$datetime_now=date('Y-m-d H:i:s');
		
		$jenis_transaksi = 'jual_rawat';
		
		$jrawat_tanggal_pattern=strtotime($jrawat_tanggal);
		$pattern="PR/".date("ym",$jrawat_tanggal_pattern)."-";
		//$pattern="PR/".date("ym")."-";
		$jrawat_nobukti=$this->m_public_function->get_kode_1('master_jual_rawat','jrawat_nobukti',$pattern,12);
		
		$jrawat_stat_dok = "Terbuka";
        $cetak = 0;
		
		$data = array(
			"jrawat_nobukti"=>$jrawat_nobukti, 
			"jrawat_total_medis"=>$jrawat_total_medis, 
			"jrawat_total_nonmedis"=>$jrawat_total_nonmedis,  
			"jrawat_cust"=>$jrawat_cust, 
			"jrawat_tanggal"=>$jrawat_tanggal, 
			"jrawat_grooming"=>$jrawat_grooming,
			"jrawat_diskon"=>$jrawat_diskon, 
			"jrawat_cashback"=>$jrawat_cashback,
			"jrawat_cashback_medis"=>$jrawat_cashback_medis,
			"jrawat_totalbiaya"=>$jrawat_total,
			"jrawat_bayar"=>$jrawat_bayar,
			"jrawat_keterangan"=>$jrawat_keterangan,
			"jrawat_ket_disk"=>$jrawat_ket_disk,
			"jrawat_ket_disk_medis"=>$jrawat_ket_disk_medis,
			"jrawat_stat_dok"=>$jrawat_stat_dok,
			"jrawat_creator"=>$_SESSION[SESSION_USERID]
		);
		/* membuat date create ikut ke tanggal yg dipilih
		if($jrawat_tanggal<>$date_now){
			$data["jrawat_date_create"] = $jrawat_tanggal;
		}
		*/
		$data["jrawat_date_create"] = $datetime_now;
		
        if($jrawat_cara!=null){
            if(($jrawat_kwitansi_nilai<>'' && $jrawat_kwitansi_nilai<>0)
                || ($jrawat_card_nilai<>'' && $jrawat_card_nilai<>0)
                || ($jrawat_cek_nilai<>'' && $jrawat_cek_nilai<>0)
                || ($jrawat_transfer_nilai<>'' && $jrawat_transfer_nilai<>0)
                || ($jrawat_tunai_nilai<>'' && $jrawat_tunai_nilai<>0)
                || ($jrawat_voucher_cashback<>'' && $jrawat_voucher_cashback<>0)){
                $data["jrawat_cara"]=$jrawat_cara;
            }else{
                $data["jrawat_cara"]=NULL;
            }
        }
		if($jrawat_cara2!=null){
			if(($jrawat_kwitansi_nilai2<>'' && $jrawat_kwitansi_nilai2<>0)
			   || ($jrawat_card_nilai2<>'' && $jrawat_card_nilai2<>0)
			   || ($jrawat_cek_nilai2<>'' && $jrawat_cek_nilai2<>0)
			   || ($jrawat_transfer_nilai2<>'' && $jrawat_transfer_nilai2<>0)
			   || ($jrawat_tunai_nilai2<>'' && $jrawat_tunai_nilai2<>0)
			   || ($jrawat_voucher_cashback2<>'' && $jrawat_voucher_cashback2<>0)){
				$data["jrawat_cara2"]=$jrawat_cara2;
			}else{
				$data["jrawat_cara2"]=NULL;
			}
		}
		if($jrawat_cara3!=null){
			if(($jrawat_kwitansi_nilai3<>'' && $jrawat_kwitansi_nilai3<>0)
			   || ($jrawat_card_nilai3<>'' && $jrawat_card_nilai3<>0)
			   || ($jrawat_cek_nilai3<>'' && $jrawat_cek_nilai3<>0)
			   || ($jrawat_transfer_nilai3<>'' && $jrawat_transfer_nilai3<>0)
			   || ($jrawat_tunai_nilai3<>'' && $jrawat_tunai_nilai3<>0)
			   || ($jrawat_voucher_cashback3<>'' && $jrawat_voucher_cashback3<>0)){
				$data["jrawat_cara3"]=$jrawat_cara3;
			}else{
				$data["jrawat_cara3"]=NULL;
			}
		}
		
		$this->db->query('LOCK TABLE master_jual_rawat WRITE');
		$this->db->insert('master_jual_rawat', $data); 
		$affected_rows = $this->db->affected_rows();
		$this->db->query('UNLOCK TABLES');
		if($affected_rows>0){
            $jrawat_id = $this->db->insert_id();
			$time_now = date('H:i:s');
			$bayar_date_create_temp = $jrawat_tanggal.' '.$time_now;
			$bayar_date_create = date('Y-m-d H:i:s', strtotime($bayar_date_create_temp));
			
			$this->m_public_function->cara_bayar_ftpkpr_insert($jrawat_nobukti ,$jrawat_cara ,$jrawat_kwitansi_no ,$jrawat_kwitansi_nilai
                               ,$jrawat_card_nama ,$jrawat_card_edc ,$jrawat_card_no ,$jrawat_card_nilai
                               ,$jrawat_cek_nama ,$jrawat_cek_no ,$jrawat_cek_valid ,$jrawat_cek_bank ,$jrawat_cek_nilai
                               ,$jrawat_transfer_bank ,$jrawat_transfer_nama ,$jrawat_transfer_nilai
                               ,$jrawat_tunai_nilai
                               ,$jrawat_voucher_no ,$jrawat_voucher_cashback
                               ,$jrawat_cara2
                               ,$jrawat_kwitansi_no2 ,$jrawat_kwitansi_nilai2
                               ,$jrawat_card_nama2 ,$jrawat_card_edc2 ,$jrawat_card_no2 ,$jrawat_card_nilai2
                               ,$jrawat_cek_nama2 ,$jrawat_cek_no2 ,$jrawat_cek_valid2 ,$jrawat_cek_bank2 ,$jrawat_cek_nilai2
                               ,$jrawat_transfer_bank2 ,$jrawat_transfer_nama2 ,$jrawat_transfer_nilai2
                               ,$jrawat_tunai_nilai2
                               ,$jrawat_voucher_no2 ,$jrawat_voucher_cashback2
                               ,$jrawat_cara3
                               ,$jrawat_kwitansi_no3 ,$jrawat_kwitansi_nilai3
                               ,$jrawat_card_nama3 ,$jrawat_card_edc3 ,$jrawat_card_no3 ,$jrawat_card_nilai3
                               ,$jrawat_cek_nama3 ,$jrawat_cek_no3 ,$jrawat_cek_valid3 ,$jrawat_cek_bank3 ,$jrawat_cek_nilai3
                               ,$jrawat_transfer_bank3 ,$jrawat_transfer_nama3 ,$jrawat_transfer_nilai3
                               ,$jrawat_tunai_nilai3
                               ,$jrawat_voucher_no3 ,$jrawat_voucher_cashback3
                               ,$bayar_date_create ,$jenis_transaksi ,$cetak, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
			
			$rs_drawat_cu = $this->detail_jual_rawat_cu($array_drawat_id ,$jrawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat ,$array_drawat_jumlah
														,$array_drawat_harga ,$array_drawat_diskon ,$array_drawat_diskon_jenis , $array_drawat_sales, 0 ,$jrawat_cust
														,$jrawat_tanggal);
			return $rs_drawat_cu;
			
		}else{
			return '-1';
		}
	}
	
	function master_jual_rawat_batal($jrawat_nobukti, $jrawat_tanggal){
		$date = date('Y-m-d');
		$date_1 = '01';
		$date_2 = '02';
		$date_3 = '03';
		$month = substr($jrawat_tanggal,5,2);
		$year = substr($jrawat_tanggal,0,4);
		$begin=mktime(0,0,0,$month,1,$year);
		$nextmonth=strtotime("+4months",$begin);
		
		$month_next = substr(date("Y-m-d",$nextmonth),5,2);
		$year_next = substr(date("Y-m-d",$nextmonth),0,4);
		
		$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
		$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
		$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
		
		
		//$date_now = date('Y-m-d');
		$datetime_now = date('Y-m-d H:i:s');
		$jrawat_id = 0;
		
		$sql = "SELECT jrawat_id, jrawat_revised FROM master_jual_rawat WHERE jrawat_nobukti='$jrawat_nobukti'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jrawat_id = $record['jrawat_id'];
		}
		
		$sql = "UPDATE master_jual_rawat
			SET jrawat_stat_dok='Batal'
				,jrawat_update='".@$_SESSION[SESSION_USERID]."'
				,jrawat_date_update='".$datetime_now."'
				,jrawat_revised=jrawat_revised+1
			WHERE jrawat_id=".$jrawat_id."
				AND ('".$date."'<='".$tanggal_3."' OR  jrawat_tanggal='".$date."')";
		$this->db->query($sql);
		if($this->db->affected_rows()){
			//* udpating db.customer.cust_point ==> proses mengurangi jumlah poin (dikurangi dengan db.master_jual_produk.jproduk_point yg sudah dimasukkan ketika cetak faktur), karena dilakukan pembatalan /
			$result_point_batal = $this->member_point_batal($jrawat_id);
			if($result_point_batal==1){
				$result_membership = $this->membership_insert($jrawat_id);
				if($result_membership==1){
					$result_piutang = $this->catatan_piutang_batal($jrawat_id);
					if($result_piutang==1){
						$result_cara_bayar = $this->cara_bayar_batal($jrawat_id);
						if($result_cara_bayar==1){
							return '1';
						}else{
							return '1';
						}
					}else{
						return '1';
					}
				}else{
					return '1';
				}
			}else{
				return '1';
			}
			
		}else{
			return '0';
		}
	}
	
	//function for advanced search record
	function master_jual_rawat_search($jrawat_nobukti ,$jrawat_cust ,$jrawat_diskon , $jrawat_stat_dok, $jrawat_cashback ,$jrawat_voucher ,$jrawat_cara ,$jrawat_bayar ,$jrawat_keterangan ,$jrawat_tgl_start ,$jrawat_tgl_end ,$start,$end){
		//pencarian perawatan satuan di db.detail_jual_rawat
		$query = "SELECT
				vu_jrawat_pr.jrawat_id,
				vu_jrawat_pr.jrawat_nobukti,
				CONCAT(vu_jrawat_pr.cust_nama, ' (', vu_jrawat_pr.cust_no, ')') as cust_nama_edit,
				cust_nama,
				cust_priority_star,
				vu_karyawan.karyawan_no,
				vu_karyawan.karyawan_nama,
				vu_jrawat_pr.jrawat_cust,
				vu_jrawat_pr.cust_no,
				vu_jrawat_pr.member_no,
				vu_jrawat_pr.jrawat_tanggal,
				vu_jrawat_pr.jrawat_diskon,
				vu_jrawat_pr.jrawat_cashback,
				vu_jrawat_pr.jrawat_cashback_medis,
				vu_jrawat_pr.jrawat_cara,
				vu_jrawat_pr.jrawat_cara2,
				vu_jrawat_pr.jrawat_cara3,
				/*IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS jrawat_totalbiaya,*/
                vu_jrawat_totalbiaya.jrawat_totalbiaya AS jrawat_totalbiaya,
				vu_jrawat_pr.jrawat_bayar,
				vu_jrawat_pr.jrawat_keterangan,
				vu_jrawat_pr.jrawat_ket_disk,
				vu_jrawat_pr.jrawat_ket_disk_medis,
				vu_jrawat_pr.jrawat_stat_dok,
				vu_jrawat_pr.jrawat_creator,
				vu_jrawat_pr.jrawat_date_create,
				vu_jrawat_pr.jrawat_update,
				vu_jrawat_pr.jrawat_date_update,
				vu_jrawat_pr.jrawat_revised,
				vu_jrawat_pr.keterangan_paket,
				0 AS dpaket_id,
				jrawat_nobukti_pajak,
				jrawat_nobukti_medis
			FROM vu_jrawat_pr
			LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)
			LEFT JOIN vu_karyawan ON(vu_karyawan.karyawan_id = vu_jrawat_pr.jrawat_grooming)
			WHERE vu_jrawat_pr.jrawat_id<>0";

			
		if($jrawat_nobukti!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
		};
		if($jrawat_cust!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_cust = '".$jrawat_cust."'";
		};
		if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_tanggal BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'";
		}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_tanggal='".$jrawat_tgl_start."'";
		}
		if($jrawat_cara!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_cara LIKE '%".$jrawat_cara."%'";
		};
		if($jrawat_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
		};
		if($jrawat_stat_dok!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pr.jrawat_stat_dok = '".$jrawat_stat_dok."'";
		};
		
		$query .= " UNION ";
		
		//pencarian pengambilan paket di db.detail_ambil_paket
		$query .= "SELECT
				vu_jrawat_pk.jrawat_id,
				vu_jrawat_pk.jrawat_nobukti,
				CONCAT(vu_jrawat_pk.cust_nama, ' (', vu_jrawat_pk.cust_no, ')') as cust_nama_edit,
				vu_jrawat_pk.cust_nama,
				cust_priority_star,
				'temp' as temp,
				'temp2' as temp2,
				vu_jrawat_pk.jrawat_cust,
				vu_jrawat_pk.cust_no,
				vu_jrawat_pk.member_no,
				vu_jrawat_pk.jrawat_tanggal,
				vu_jrawat_pk.jrawat_diskon,
				vu_jrawat_pk.jrawat_cashback,
				vu_jrawat_pk.jrawat_cashback_medis,
				vu_jrawat_pk.jrawat_cara,
				vu_jrawat_pk.jrawat_cara2,
				vu_jrawat_pk.jrawat_cara3,
				vu_jrawat_pk.jrawat_totalbiaya,
				vu_jrawat_pk.jrawat_bayar,
				vu_jrawat_pk.jrawat_keterangan,
				vu_jrawat_pk.jrawat_ket_disk,
				vu_jrawat_pk.jrawat_ket_disk_medis,
				vu_jrawat_pk.dapaket_stat_dok AS jrawat_stat_dok,
				vu_jrawat_pk.jrawat_creator,
				vu_jrawat_pk.jrawat_date_create,
				vu_jrawat_pk.jrawat_update,
				vu_jrawat_pk.jrawat_date_update,
				vu_jrawat_pk.jrawat_revised,
				vu_jrawat_pk.keterangan_paket,
				vu_jrawat_pk.dpaket_id,
				dapaket_nobukti_pajak AS jrawat_nobukti_pajak,
				dapaket_nobukti_medis AS jrawat_nobukti_medis
			FROM vu_jrawat_pk
			WHERE jrawat_id<>0";
			
		if($jrawat_nobukti!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
		};
		if($jrawat_cust!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
		};
		if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."')";
		}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."'
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."')";
		}
		if($jrawat_cara!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
		};
		if($jrawat_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
		};
		if($jrawat_stat_dok!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
		};	
			
		/*if($jrawat_nobukti!=''){
			//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
			}
		};
		
		if($jrawat_cust!=''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
			}
		};
		
		if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'";	
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'";
			}
			
			if($jrawat_stat_dok!=''){
				$query.=" AND vu_jrawat_pr.jrawat_stat_dok = '".$jrawat_stat_dok."')";
			}
			else{
				$query.=")";
			}
			
		}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."' ";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND date_format(vu_jrawat_pk.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
				AND vu_jrawat_pk.jrawat_cust NOT IN(
					SELECT vu_jrawat_pr.jrawat_cust
					FROM vu_jrawat_pr
					WHERE date_format(vu_jrawat_pr.jrawat_tanggal,'%Y-%m-%d') = '".$jrawat_tgl_start."' ";
			}
			
			if($jrawat_stat_dok!=''){
				$query.=" AND vu_jrawat_pr.jrawat_stat_dok = '".$jrawat_stat_dok."')";
			}
			else{
				$query.=")";
			}
		}*/
		
		/*if($jrawat_cara!=''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
			}
		};
		
		if($jrawat_keterangan!=''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
			}
		};
		
		if($jrawat_stat_dok!=''){
			if(substr_count($query, " WHERE ")<2){
				$query.=" WHERE vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
			}elseif(substr_count($query, " WHERE ")>=2){
				$query.=" AND vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
			}
		};*/
		
		$result = $this->db->query($query);
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
		
		/*$nbrows=0;
		$nbrows2=0;
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		
		$result2 = $this->db->query($query2);
		$nbrows2 = $result2->num_rows();
		
		if($nbrows>0 || $nbrows2>0){
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
			}
			if($nbrows2>0){
				foreach($result2->result() as $row2){
					$arr[] = $row2;
				}
			}
			$nbrows=$nbrows+$nbrows2;
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}*/
		
	}
	
	//function for print record
	function master_jual_rawat_print($jrawat_nobukti
									,$jrawat_cust
									,$jrawat_diskon
									,$jrawat_stat_dok
									,$jrawat_cashback
									,$jrawat_voucher
									,$jrawat_cara
									,$jrawat_bayar
									,$jrawat_keterangan
									,$jrawat_tgl_start
									,$jrawat_tgl_end
									,$option
									,$filter){
		//full query
		if($option=='LIST'){
			$date_now=date('Y-m-d');
			$query = "SELECT
					vu_jrawat_pr.jrawat_tanggal AS tanggal,
					vu_jrawat_pr.jrawat_nobukti AS no_bukti,
					vu_jrawat_pr.cust_no AS no_cust,
					vu_jrawat_pr.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pr.member_no,7,0,'-'),14,0,'-') AS no_member,
					IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS jrawat_totalbiaya,
					vu_jrawat_pr.jrawat_bayar AS jrawat_bayar,
					vu_jrawat_pr.jrawat_keterangan AS keterangan,
					vu_jrawat_pr.keterangan_paket AS paket,
					vu_jrawat_pr.jrawat_stat_dok AS stat_dok,
					'' AS paket_nama
				FROM vu_jrawat_pr
				LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)
				WHERE vu_jrawat_pr.jrawat_stat_dok='Terbuka' AND date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d')='$date_now'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (vu_jrawat_pr.jrawat_nobukti LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_no LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_nama LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_member LIKE '%".addslashes($filter)."%')";
			}
			
			$query .= " UNION ";
			
			$query .= "SELECT
					vu_jrawat_pk.jrawat_tanggal AS tanggal,
					vu_jrawat_pk.jrawat_nobukti AS no_bukti,
					vu_jrawat_pk.cust_no AS no_cust,
					vu_jrawat_pk.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pk.member_no,7,0,'-'),14,0,'-') AS no_member,
					vu_jrawat_pk.jrawat_totalbiaya AS jrawat_totalbiaya,
					vu_jrawat_pk.jrawat_bayar AS jrawat_bayar,
					vu_jrawat_pk.jrawat_keterangan AS keterangan,
					vu_jrawat_pk.keterangan_paket AS paket,
					vu_jrawat_pk.dapaket_stat_dok AS stat_dok,
					vu_jrawat_pk.paket_nama AS paket_nama
				FROM vu_jrawat_pk
				WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d')='$date_now'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d')='$date_now'
							AND vu_jrawat_pr.jrawat_stat_dok='Terbuka')
					AND vu_jrawat_pk.dapaket_stat_dok='Terbuka'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (vu_jrawat_pk.jrawat_nobukti LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_no LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_nama LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_member LIKE '%".addslashes($filter)."%')";
			}
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			$query = "SELECT
					vu_jrawat_pr.jrawat_tanggal AS tanggal,
					vu_jrawat_pr.jrawat_nobukti AS no_bukti,
					vu_jrawat_pr.cust_no AS no_cust,
					vu_jrawat_pr.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pr.member_no,7,0,'-'),14,0,'-') AS no_member,
					IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS jrawat_totalbiaya,
					vu_jrawat_pr.jrawat_bayar AS jrawat_bayar,
					vu_jrawat_pr.jrawat_keterangan AS keterangan,
					vu_jrawat_pr.keterangan_paket AS paket,
					vu_jrawat_pr.jrawat_stat_dok AS stat_dok,
					'' AS paket_nama
				FROM vu_jrawat_pr
				LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)";
				
			if($jrawat_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
			};
			if($jrawat_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_cust = '".$jrawat_cust."'";
			};
			if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_tanggal BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'";
			}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_tanggal='".$jrawat_tgl_start."'";
			}
			if($jrawat_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_cara LIKE '%".$jrawat_cara."%'";
			};
			if($jrawat_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
			};
			if($jrawat_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_stat_dok = '".$jrawat_stat_dok."'";
			};
			
			$query .= " UNION ";
			
			//pencarian pengambilan paket di db.detail_ambil_paket
			$query .= "SELECT
					vu_jrawat_pk.jrawat_tanggal AS tanggal,
					vu_jrawat_pk.jrawat_nobukti AS no_bukti,
					vu_jrawat_pk.cust_no AS no_cust,
					vu_jrawat_pk.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pk.member_no,7,0,'-'),14,0,'-') AS no_member,
					vu_jrawat_pk.jrawat_totalbiaya AS jrawat_totalbiaya,
					vu_jrawat_pk.jrawat_bayar AS jrawat_bayar,
					vu_jrawat_pk.jrawat_keterangan AS keterangan,
					vu_jrawat_pk.keterangan_paket AS paket,
					vu_jrawat_pk.dapaket_stat_dok AS stat_dok,
					vu_jrawat_pk.paket_nama AS paket_nama
				FROM vu_jrawat_pk ";
				
			if($jrawat_nobukti!=''){
				//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
				}
			};
			
			if($jrawat_cust!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
				}
			};
			
			if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."')";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."')";
				}
			}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' )";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' )";
				}
			}
			
			if($jrawat_cara!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
				}
			};
			
			if($jrawat_keterangan!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
				}
			};
			
			if($jrawat_stat_dok!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
				}
			};
			
			$result = $this->db->query($query);
		}
		return $result->result();
	}
	
	//function  for export to excel
	function master_jual_rawat_export_excel($jrawat_nobukti
											,$jrawat_cust
											,$jrawat_diskon
											,$jrawat_stat_dok
											,$jrawat_cashback
											,$jrawat_voucher
											,$jrawat_cara
											,$jrawat_bayar
											,$jrawat_keterangan
											,$jrawat_tgl_start
											,$jrawat_tgl_end
											,$option
											,$filter){
		if($option=='LIST'){
			$date_now=date('Y-m-d');
			$query = "SELECT
					vu_jrawat_pr.jrawat_tanggal AS tanggal,
					vu_jrawat_pr.jrawat_nobukti AS no_bukti,
					vu_jrawat_pr.cust_no AS no_cust,
					vu_jrawat_pr.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pr.member_no,7,0,'-'),14,0,'-') AS no_member,
					IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS 'Total (Rp)',
					vu_jrawat_pr.jrawat_bayar AS 'Total Bayar (Rp)',
					vu_jrawat_pr.jrawat_keterangan AS keterangan,
					vu_jrawat_pr.keterangan_paket AS paket,
					vu_jrawat_pr.jrawat_stat_dok AS stat_dok,
					'' AS paket_nama
				FROM vu_jrawat_pr
				LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)
				WHERE vu_jrawat_pr.jrawat_stat_dok='Terbuka' AND date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d')='$date_now'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (vu_jrawat_pr.jrawat_nobukti LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_no LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_nama LIKE '%".addslashes($filter)."%' OR vu_jrawat_pr.cust_member LIKE '%".addslashes($filter)."%')";
			}
			
			$query .= " UNION ";
			
			$query .= "SELECT
					vu_jrawat_pk.jrawat_tanggal AS tanggal,
					vu_jrawat_pk.jrawat_nobukti AS no_bukti,
					vu_jrawat_pk.cust_no AS no_cust,
					vu_jrawat_pk.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pk.member_no,7,0,'-'),14,0,'-') AS no_member,
					vu_jrawat_pk.jrawat_totalbiaya AS 'Total (Rp)',
					vu_jrawat_pk.jrawat_bayar AS 'Total Bayar (Rp)',
					vu_jrawat_pk.jrawat_keterangan AS keterangan,
					vu_jrawat_pk.keterangan_paket AS paket,
					vu_jrawat_pk.dapaket_stat_dok AS stat_dok,
					vu_jrawat_pk.paket_nama AS paket_nama
				FROM vu_jrawat_pk
				WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d')='$date_now'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d')='$date_now'
							AND vu_jrawat_pr.jrawat_stat_dok='Terbuka')
					AND vu_jrawat_pk.dapaket_stat_dok='Terbuka'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (vu_jrawat_pk.jrawat_nobukti LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_no LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_nama LIKE '%".addslashes($filter)."%' OR vu_jrawat_pk.cust_member LIKE '%".addslashes($filter)."%')";
			}
			$result = $this->db->query($query);
			
		} else if($option=='SEARCH'){
			$query = "SELECT
					vu_jrawat_pr.jrawat_tanggal AS tanggal,
					vu_jrawat_pr.jrawat_nobukti AS no_bukti,
					vu_jrawat_pr.cust_no AS no_cust,
					vu_jrawat_pr.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pr.member_no,7,0,'-'),14,0,'-') AS no_member,
					IF(vu_jrawat_pr.jrawat_totalbiaya!=0, vu_jrawat_pr.jrawat_totalbiaya, vu_jrawat_totalbiaya.jrawat_totalbiaya) AS 'Total (Rp)',
					vu_jrawat_pr.jrawat_bayar AS 'Total Bayar (Rp)',
					vu_jrawat_pr.jrawat_keterangan AS keterangan,
					vu_jrawat_pr.keterangan_paket AS paket,
					vu_jrawat_pr.jrawat_stat_dok AS stat_dok,
					'' AS paket_nama
				FROM vu_jrawat_pr
				LEFT JOIN vu_jrawat_totalbiaya ON(vu_jrawat_totalbiaya.drawat_master=vu_jrawat_pr.jrawat_id)";
				
			if($jrawat_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
			};
			if($jrawat_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_cust = '".$jrawat_cust."'";
			};
			if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_tanggal BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'";
			}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_tanggal='".$jrawat_tgl_start."'";
			}
			if($jrawat_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_cara LIKE '%".$jrawat_cara."%'";
			};
			if($jrawat_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
			};
			if($jrawat_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " vu_jrawat_pr.jrawat_stat_dok = '".$jrawat_stat_dok."'";
			};
			
			$query .= " UNION ";
			
			//pencarian pengambilan paket di db.detail_ambil_paket
			$query .= "SELECT
					vu_jrawat_pk.jrawat_tanggal AS tanggal,
					vu_jrawat_pk.jrawat_nobukti AS no_bukti,
					vu_jrawat_pk.cust_no AS no_cust,
					vu_jrawat_pk.cust_nama AS customer,
					INSERT(INSERT(vu_jrawat_pk.member_no,7,0,'-'),14,0,'-') AS no_member,
					vu_jrawat_pk.jrawat_totalbiaya AS 'Total (Rp)',
					vu_jrawat_pk.jrawat_bayar AS 'Total Bayar (Rp)',
					vu_jrawat_pk.jrawat_keterangan AS keterangan,
					vu_jrawat_pk.keterangan_paket AS paket,
					vu_jrawat_pk.dapaket_stat_dok AS stat_dok,
					vu_jrawat_pk.paket_nama AS paket_nama
				FROM vu_jrawat_pk ";
				
			if($jrawat_nobukti!=''){
				//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_nobukti LIKE '%".$jrawat_nobukti."%'";
				}
			};
			
			if($jrawat_cust!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_cust = '".$jrawat_cust."'";
				}
			};
			
			if($jrawat_tgl_start!='' && $jrawat_tgl_end!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."')";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."'
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') BETWEEN '".$jrawat_tgl_start."' AND '".$jrawat_tgl_end."')";
				}
			}else if($jrawat_tgl_start!='' && $jrawat_tgl_end==''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' )";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND date_format(vu_jrawat_pk.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' 
					AND vu_jrawat_pk.jrawat_cust NOT IN(
						SELECT vu_jrawat_pr.jrawat_cust
						FROM vu_jrawat_pr
						WHERE date_format(vu_jrawat_pr.jrawat_date_create,'%Y-%m-%d') = '".$jrawat_tgl_start."' )";
				}
			}
			
			if($jrawat_cara!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_cara LIKE '%".$jrawat_cara."%'";
				}
			};
			
			if($jrawat_keterangan!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.jrawat_keterangan LIKE '%".$jrawat_keterangan."%'";
				}
			};
			
			if($jrawat_stat_dok!=''){
				if(substr_count($query, " WHERE ")<2){
					$query.=" WHERE vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
				}elseif(substr_count($query, " WHERE ")>=2){
					$query.=" AND vu_jrawat_pk.dapaket_stat_dok = '".$jrawat_stat_dok."'";
				}
			};
			
			$result = $this->db->query($query);
		}
		return $result;
	}
	
	function get_rawat_list($query,$start,$end,$aktif){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_drawat="SELECT distinct(drawat_rawat) FROM detail_jual_rawat WHERE drawat_master='$query'";
			$rs=$this->db->query($sql_drawat);
			$rs_rows=$rs->num_rows();
		}
		
		if($aktif=='yes'){
			$sql="SELECT rawat_id
					,rawat_harga
					,rawat_kode
					,group_nama
					,kategori_nama
					,rawat_du
					,rawat_dm
					,rawat_dultah
					,rawat_dcard
					,rawat_dkolega
					,rawat_dkeluarga
					,rawat_downer
					,rawat_dgrooming
					,rawat_dwartawan
					,rawat_dstaffdokter
					,rawat_dstaffnondokter
					,rawat_dpromo
					,rawat_nama
					,rawat_edit_harga
				FROM perawatan
					LEFT JOIN produk_group ON(rawat_group=group_id)
					LEFT JOIN kategori ON(rawat_kategori=kategori_id)
				WHERE rawat_aktif='Aktif'";//join dr tabel: perawatan,produk_group,kategori2,kategori,jenis,gudang
		}else{
			$sql="SELECT rawat_id
				,rawat_harga
				,rawat_kode
				,group_nama
				,kategori_nama
				,rawat_du
				,rawat_dm
				,rawat_dultah
				,rawat_dcard
				,rawat_dkolega
				,rawat_dkeluarga
				,rawat_downer
				,rawat_dgrooming
				,rawat_dwartawan
				,rawat_dstaffdokter
				,rawat_dstaffnondokter
				,rawat_nama
				,rawat_edit_harga
			FROM perawatan
				LEFT JOIN produk_group ON(rawat_group=group_id)
				LEFT JOIN kategori ON(rawat_kategori=kategori_id)";
		}
		
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
			$sql.=" (rawat_kode like '%".$query."%' or rawat_nama like '%".$query."%' or kategori_nama like '%".$query."%') ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("WHERE",$query)? " AND ":" WHERE ";
				foreach($rs->result() as $row_drawat){
					
					$filter.="OR rawat_id='".$row_drawat->drawat_rawat."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if(($end!=0) && ($aktif<>'yesno')){
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
	
	function master_jual_rawat_tertutup($jrawat_id){
		$date_now = date('Y-m-d');
		$datetime_now = date('Y-m-d H:i:s');
		//* status dokumen menjadi tertutup setelah Faktur selesai di-cetak /
		$sql = "SELECT jrawat_tanggal FROM master_jual_rawat WHERE jrawat_id='".$jrawat_id."' AND jrawat_stat_dok='Terbuka'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$jrawat_tanggal = $record['jrawat_tanggal'];
			/*
			if($jrawat_tanggal<>$date_now){
				$jrawat_date_update = $jrawat_tanggal;
			}else{
				$jrawat_date_update = $datetime_now;
			}
			*/
			
			$sql="UPDATE master_jual_rawat
				SET jrawat_stat_dok='Tertutup'
					,jrawat_update='".@$_SESSION[SESSION_USERID]."'
					,jrawat_date_update='".$datetime_now."'
					,jrawat_revised=jrawat_revised+1
				WHERE jrawat_id='$jrawat_id'";
			$this->db->query('LOCK TABLE master_jual_rawat WRITE');
			$this->db->query($sql);
			$affected_rows = $this->db->affected_rows();
			$this->db->query('UNLOCK TABLES');
			if($affected_rows>(-1)){
				return 1;
			}else{
				return 1;
			}
		}else{
			return 1;
		}
	}
	
	function detail_ambil_paket_status_update($dapaket_id){
		$sql = "SELECT dapaket_dtrawat FROM detail_ambil_paket WHERE dapaket_id='".$dapaket_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$dapaket_dtrawat = $record['dapaket_dtrawat'];
			/* db.detail_ambil_paket.dapaket_stat_dok = 'Tertutup' */
            $sql = "UPDATE detail_ambil_paket
                SET dapaket_stat_dok='Tertutup'
                WHERE dapaket_id='".$dapaket_id."'
                    AND dapaket_stat_dok='Terbuka'";
            $this->db->query('LOCK TABLE detail_ambil_paket WRITE');
            $this->db->query($sql);
            $this->db->query('UNLOCK TABLES');
			
			/* me-Lock db.tindakan_detail agar tidak bisa di-edit */
			$dtu_dtrawat = array(
				"dtrawat_locked"=>1
			);
			$this->db->where('dtrawat_id', $dapaket_dtrawat);
			$this->db->update('tindakan_detail', $dtu_dtrawat);
		}
		
	}
	
	function tindakan_detail_locked($dtrawat_id){
		$datetime_now = date('Y-m-d H:i:s');
		$sqlu = "UPDATE tindakan_detail
			SET dtrawat_locked=1
			WHERE dtrawat_id='".$dtrawat_id."'";
		$this->db->query($sqlu);
		if($this->db->affected_rows()>-1){
			return 1;
		}
	}
	
	function print_paper($jrawat_id){
		$sql="SELECT jrawat_tanggal
				,cust_no
				,cust_nama
				,cust_alamat
				,jrawat_nobukti
				,rawat_nama
				,drawat_jumlah
				,drawat_harga
				,drawat_diskon
				,(drawat_harga*((100-drawat_diskon)/100)) AS jumlah_subtotal
				,jrawat_creator
				,jrawat_diskon
				,jrawat_cashback
				,jrawat_cashback_medis
				,jrawat_bayar
				,TIME(jrawat_date_create) AS jrawat_jam
				,IFNULL(karyawan_nama,'NA') AS jrawat_karyawan
				,IFNULL(karyawan_no,'NA') AS jrawat_karyawan_no
			FROM detail_jual_rawat
			LEFT JOIN master_jual_rawat ON(drawat_master=jrawat_id)
			LEFT JOIN customer ON(jrawat_cust=cust_id)
			LEFT JOIN perawatan ON(drawat_rawat=rawat_id)
			LEFT JOIN karyawan ON (jrawat_grooming = karyawan_id)
			WHERE jrawat_id='$jrawat_id'";
		$result = $this->db->query($sql);
		//$this->master_jual_rawat_tertutup($jrawat_id);
		return $result;
	}

////////////////PAJAK/////////////
	// SATUAN MEDIS 
	function print_paper_medis($jrawat_id, $jrawat_cust, $jrawat_tanggal){
		
		$sql_nobukti_medis = "SELECT jrawat_nobukti_medis FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_medis = $this->db->query($sql_nobukti_medis);
		$data_nobukti_medis= $result_medis->row();
		$nobukti_medis= $data_nobukti_medis->jrawat_nobukti_medis;	
		
		// JUMLAH RAWAT MEDIS
		$sql_cek_medis="SELECT kategori_nama
					FROM vu_detail_jual_rawat
					WHERE drawat_master ='".$jrawat_id."' AND kategori_nama='Medis'";
		$result_cek_medis = $this->db->query($sql_cek_medis);
		$jum_rawat_medis= $result_cek_medis->num_rows();
		
		// JUMLAH PAKET MEDIS
		$sql_cek_paketmedis="SELECT kategori_nama
					FROM vu_jrawat_pk
					WHERE jrawat_id ='".$jrawat_id."' AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery')";
		$result_cek_paketmedis = $this->db->query($sql_cek_paketmedis);
		$jum_paket_medis= $result_cek_paketmedis->num_rows();
		
		if (($jum_rawat_medis > 0 || $jum_paket_medis > 0) && $nobukti_medis == '-') {
		// GENERATE FAKTUR MEDIS
		$jrawat_tanggal_pattern=strtotime($jrawat_tanggal);
		$pattern="PRM/".date("ym",$jrawat_tanggal_pattern)."-";
		//$pattern="010.000-".date("y").".";
		$length = 13;
		
		// AMBIL DARI M PUBLIC FUNCTION
		$len_pattern=strlen($pattern);
		$len_lpad=$length-$len_pattern;
		$sql="select concat(left(max(nobukti_medis),".$len_pattern."),LPAD((right(max(nobukti_medis),".$len_lpad.")+1),".$len_lpad.",0)) as max_key from 
			(
			select master_jual_rawat.jrawat_nobukti_medis AS nobukti_medis from master_jual_rawat

			union

			select detail_ambil_paket.dapaket_nobukti_medis AS nobukti_medis from detail_ambil_paket
			) AS table_union
		where nobukti_medis like '".$pattern."%' AND
		nobukti_medis is not null and nobukti_medis <> 'M'";
		
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
		// END OF GENERATE FAKTUR MEDIS
		
		// UPDATE FAKTUR PAJAK
		$sql_medis = "UPDATE master_jual_rawat
				SET jrawat_nobukti_medis = '".$kode."'
				WHERE jrawat_id='$jrawat_id'";
		$this->db->query('LOCK TABLE master_jual_rawat WRITE');
		$this->db->query($sql_medis);
		$this->db->query('UNLOCK TABLES');
		// END UPDATE FAKTUR PAJAK
		}
		// QUERY UTK PRINT PAPER.. 
		$sql="SELECT jrawat_tanggal
				,cust_no
				,cust_nama
				,cust_alamat
				,jrawat_nobukti
				,rawat_nama
				,drawat_jumlah
				,drawat_harga
				,drawat_diskon
				,(drawat_harga*((100-drawat_diskon)/100)) AS jumlah_subtotal
				,jrawat_creator
				,jrawat_diskon as diskon
				,jrawat_cashback_medis
				,master_jual_rawat.jrawat_cashback_medis
				,jrawat_bayar
				,TIME(jrawat_date_create) AS jrawat_jam
				,0 as uang_muka
				,jrawat_nobukti_medis
				,jrawat_diskon
				,0 as pajak
			FROM detail_jual_rawat
			LEFT JOIN master_jual_rawat ON(drawat_master=jrawat_id)
			LEFT JOIN vu_jrawat_totalbiaya ON(master_jual_rawat.jrawat_id = vu_jrawat_totalbiaya.drawat_master)
			LEFT JOIN customer ON(jrawat_cust=cust_id)
			LEFT JOIN perawatan ON(drawat_rawat=rawat_id)
			LEFT JOIN kategori ON(perawatan.rawat_kategori = kategori.kategori_id)
			WHERE jrawat_id='$jrawat_id' AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery')";
		$result = $this->db->query($sql);
		$this->master_jual_rawat_tertutup($jrawat_id);
		return $result;
	}
	
	// SATUAN NON MEDIS
	function print_paper_nonmedis($jrawat_id){
		$sql_pajak = "SELECT jrawat_nobukti_pajak FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_pajak = $this->db->query($sql_pajak);
		$data_nobukti_pajak= $result_pajak->row();
		$nobukti_pajak= $data_nobukti_pajak->jrawat_nobukti_pajak;
	
		// JUMLAH RAWAT NON MEDIS
		$sql_cek_nonmedis	=
				   "select k.kategori_nama
					from detail_jual_rawat d
					left join perawatan r on r.rawat_id = d.drawat_rawat
					left join kategori k on k.kategori_id = r.rawat_kategori
					WHERE d.drawat_master = '".$jrawat_id."' AND kategori_nama='Non Medis'";
		$result_cek_nonmedis = $this->db->query($sql_cek_nonmedis);
		$jum_rawat_nonmedis= $result_cek_nonmedis->num_rows();
		
		// JUMLAH PAKET NON MEDIS
		$sql_cek_paketnonmedis="SELECT kategori_nama
					FROM vu_jrawat_pk
					WHERE jrawat_id ='".$jrawat_id."' AND (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')";
		$result_cek_paketnonmedis = $this->db->query($sql_cek_paketnonmedis);
		$jum_paket_nonmedis= $result_cek_paketnonmedis->num_rows();
	
	
		if (($jum_rawat_nonmedis > 0 || $jum_paket_nonmedis > 0) && $nobukti_pajak =='-') {
		// GENERATE FAKTUR PAJAK
		$pattern="010.000-".date("y").".";
		$jrawat_nobukti_pajak = $this->m_public_function->get_kode_pajak($pattern, 19);
	
		// UPDATE FAKTUR PAJAK
		$sql = "UPDATE master_jual_rawat
				SET jrawat_nobukti_pajak = '".$jrawat_nobukti_pajak."'
				WHERE jrawat_id='$jrawat_id'";
		$this->db->query('LOCK TABLE master_jual_rawat WRITE');
		$this->db->query($sql);
		$this->db->query('UNLOCK TABLES');
		// END UPDATE FAKTUR PAJAK
		}
		
		
		//QUERY UTK mengkaitkan.. tambahin DPP dll disini.. 
		$sql="SELECT jrawat_tanggal
				,cust_no
				,cust_nama
				,cust_alamat
				,jrawat_nobukti
				,rawat_nama
				,drawat_jumlah
				,drawat_harga
				,drawat_diskon
				,(drawat_harga*((100-drawat_diskon)/100)) AS jumlah_subtotal
				,jrawat_creator
				,((drawat_harga*((100-drawat_diskon)/100))*drawat_jumlah) AS jumlah_subtotal /*nat*/
				,jrawat_creator
				,jrawat_diskon
				,jrawat_cashback
				,jrawat_bayar
				,TIME(jrawat_date_create) AS jrawat_jam
				,jrawat_nobukti_pajak
	/*nat*/		,(drawat_harga / 1.1) as dpp
				,((drawat_harga * drawat_jumlah) / 1.1) as sub_tot_dpp
				,jrawat_cashback as voucher_nonmedis
				,(jrawat_cashback/1.1) as diskon
				,(((drawat_harga * drawat_jumlah) / 1.1)-(jrawat_cashback/1.1)) as subtotal
				,(((drawat_harga * drawat_jumlah) / 1.1)-(jrawat_cashback/1.1))*0.1 as pajak /*nat*/
				,0 as uang_muka
				, ((((drawat_harga * drawat_jumlah) / 1.1)+(drawat_harga / 1.1)) - ((jrawat_cashback/1.1)+0)) as total
			FROM detail_jual_rawat
			LEFT JOIN master_jual_rawat ON(drawat_master=jrawat_id)
			LEFT JOIN vu_jrawat_totalbiaya ON(master_jual_rawat.jrawat_id = vu_jrawat_totalbiaya.drawat_master)
			LEFT JOIN customer ON(jrawat_cust=cust_id)
			LEFT JOIN perawatan ON(drawat_rawat=rawat_id)
			LEFT JOIN kategori ON(perawatan.rawat_kategori = kategori.kategori_id)
			WHERE jrawat_id='$jrawat_id' AND kategori_nama = 'Non Medis'";
		$result = $this->db->query($sql);
		$this->master_jual_rawat_tertutup($jrawat_id);
		return $result;
	}
	
	/*Dari Isaac */
	
	// PRINT PAPER KHUSUS PAKET SAJA
	// PAKET SAJA MEDIS													
	function print_paper_apaket_medis($dapaket_cust ,$dapaket_tgl_ambil, $dapaket_nobukti_medis){
		$sql = "SELECT dapaket_id
            FROM detail_ambil_paket
			LEFT JOIN perawatan ON(perawatan.rawat_id = detail_ambil_paket.dapaket_item)
			LEFT JOIN kategori ON(perawatan.rawat_kategori = kategori.kategori_id)
            WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_tgl_ambil'
                AND dapaket_stat_dok='Terbuka'
				AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery') ";
        $rss = $this->db->query($sql);
		
		// GENERATE FAKTUR MEDIS
		
		$jrawat_tanggal_pattern=strtotime($dapaket_tgl_ambil);
		$pattern="PRM/".date("ym",$jrawat_tanggal_pattern)."-";
		//$pattern="010.000-".date("y").".";
		$length = 13;
		
		// AMBIL DARI M PUBLIC FUNCTION
		$len_pattern=strlen($pattern);
		$len_lpad=$length-$len_pattern;
		$sql="select concat(left(max(nobukti_medis),".$len_pattern."),LPAD((right(max(nobukti_medis),".$len_lpad.")+1),".$len_lpad.",0)) as max_key from 
			(
			select master_jual_rawat.jrawat_nobukti_medis AS nobukti_medis from master_jual_rawat

			union

			select detail_ambil_paket.dapaket_nobukti_medis AS nobukti_medis from detail_ambil_paket
			) AS table_union
		where nobukti_medis like '".$pattern."%' AND
		nobukti_medis is not null and nobukti_medis <> 'M'";
		
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
		// END OF GENERATE FAKTUR MEDIS
		
		
		foreach($rss->result() as $row){
		
			$sql = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_medis = '".$kode."'
                WHERE dapaket_id='".$row->dapaket_id."'";
		
			$this->db->query('LOCK TABLE detail_ambil_paket WRITE');
            $this->db->query($sql);
            $this->db->query('UNLOCK TABLES');
			$this->detail_ambil_paket_status_update($row->dapaket_id);
		}
		$sql = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket
			FROM
				vu_detail_ambil_paket_rawat
			WHERE dapaket_cust='$dapaket_cust' AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery')
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_tgl_ambil'
				AND dapaket_stat_dok='Tertutup'";

		
		if ($dapaket_nobukti_medis<>"-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_medis='".$dapaket_nobukti_medis."')";

		}
		if ($dapaket_nobukti_medis=="-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_medis='".$kode."')";

		}
        $result = $this->db->query($sql);
		return $result;
	}
	
	//PAKET SAJA NON MEDIS
	function print_paper_apaket_nonmedis($dapaket_cust ,$dapaket_date_create, $dapaket_nobukti_pajak){
		$sql = "SELECT dapaket_id
            FROM detail_ambil_paket
			LEFT JOIN perawatan ON(perawatan.rawat_id = detail_ambil_paket.dapaket_item)
			LEFT JOIN kategori ON(perawatan.rawat_kategori = kategori.kategori_id)
            WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
                AND dapaket_stat_dok='Terbuka'
				AND (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')";
        $rss = $this->db->query($sql);
		
		// GENERATE FAKTUR PAJAK
			$pattern="010.000-".date("y").".";		
			$dapaket_nobukti_pajak = $this->m_public_function->get_kode_pajak($pattern, 19);
			
      foreach($rss->result() as $row){
			$sql = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_pajak = '".$dapaket_nobukti_pajak."'
                WHERE dapaket_id='".$row->dapaket_id."'";
			$this->db->query($sql);
		
			$this->db->query('LOCK TABLE detail_ambil_paket WRITE');
			$this->db->query('UNLOCK TABLES');
			$this->detail_ambil_paket_status_update($row->dapaket_id);
		}
		
		// QUERY UNTUK PRINT PAPER --> tambahin DPP , PPN , dLL disini.. 
		$sql = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
				,dapaket_nobukti_pajak
				,dapaket_jumlah*harga_satuan as uang_muka /*end of nat */
			FROM
				vu_detail_ambil_paket_rawat
			WHERE dapaket_cust='$dapaket_cust' AND (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				AND dapaket_stat_dok='Tertutup'";
		
		if ($dapaket_nobukti_pajak<>"-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_pajak='".$dapaket_nobukti_pajak."')";
		}
		
		if ($dapaket_nobukti_pajak=="-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_pajak='".$kode."')";
		}
		
        $result = $this->db->query($sql);
		return $result;
	}
	
	// PENGAMBILAN PAKET MEDIS UNTUK ADA SATUAN
	function print_paper_apaket_bycust_medis($dapaket_cust, $dapaket_date_create, $jrawat_id, $stat_dok){
		
		$sql_pajak = "SELECT jrawat_nobukti_pajak FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_pajak = $this->db->query($sql_pajak);
		$data_nobukti_pajak= $result_pajak->row();
		$nobukti_pajak= $data_nobukti_pajak->jrawat_nobukti_pajak;	
		
		$sql_nobukti_medis = "SELECT jrawat_nobukti_medis FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_medis = $this->db->query($sql_nobukti_medis);
		$data_nobukti_medis= $result_medis->row();
		$nobukti_medis= $data_nobukti_medis->jrawat_nobukti_medis;	
		
		if($nobukti_medis=='-')
		{
		// GENERATE FAKTUR MEDIS
		$jrawat_tanggal_pattern=strtotime($dapaket_date_create);
		$pattern="PRM/".date("ym",$jrawat_tanggal_pattern)."-";
		//$pattern="010.000-".date("y").".";
		$length = 13;
		
		// AMBIL DARI M PUBLIC FUNCTION
		$len_pattern=strlen($pattern);
		$len_lpad=$length-$len_pattern;
		$sql="select concat(left(max(nobukti_medis),".$len_pattern."),LPAD((right(max(nobukti_medis),".$len_lpad.")+1),".$len_lpad.",0)) as max_key from 
			(
			select master_jual_rawat.jrawat_nobukti_medis AS nobukti_medis from master_jual_rawat

			union

			select detail_ambil_paket.dapaket_nobukti_medis AS nobukti_medis from detail_ambil_paket
			) AS table_union
		where nobukti_medis like '".$pattern."%' AND
		nobukti_medis is not null and nobukti_medis <> 'M'";
		
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
		
		// UPDATE ke master_jual_rawat , agar nobukti_medis di master_jual_rawat sama dengan di detail_ambil_paket.. 
		/*$sql_update_master = "UPDATE master_jual_rawat
                SET jrawat_nobukti_medis = '".$kode."'
                WHERE jrawat_id='".$jrawat_id."'";
         $this->db->query($sql_update_master);*/
		
		// END OF GENERATE FAKTUR MEDIS
	
		}
		
	
		// UPDATE STATUS DAN NOBUKTI PAJAK MEDIS
		/*$sql_update = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
			FROM
				vu_detail_ambil_paket_rawat
			WHERE cust_id='$dapaket_cust' AND kategori_nama = 'Medis'
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				AND dapaket_stat_dok='Terbuka'";
		*/
		$sql_update =
			"SELECT
				dapaket_id, dapaket_dtrawat
			FROM
				detail_ambil_paket d
			left join customer c on c.cust_id = d.dapaket_cust
			left join perawatan r on r.rawat_id = d.dapaket_item
			left join kategori k on k.kategori_id = r.rawat_kategori
			WHERE 
				cust_id = '$dapaket_cust' 
				AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery')
				AND date_format(d.dapaket_tgl_ambil,'%Y-%m-%d') = '$dapaket_date_create'
				AND dapaket_stat_dok='Terbuka'";
		
		$result_update = $this->db->query($sql_update);
		foreach($result_update->result() as $row){
		
			if($nobukti_medis=='-')
			{
			$sql = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_medis = '".$kode."'
                WHERE dapaket_id='".$row->dapaket_id."'";
			}
			else if($nobukti_medis!='-')
			{
			$sql = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_medis = '".$nobukti_medis."'
                WHERE dapaket_id='".$row->dapaket_id."'";
			}
			$this->db->query($sql);
			
			$sql2 = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_pajak = '".$nobukti_pajak."'
                WHERE dapaket_id='".$row->dapaket_id."'";
				
			$this->db->query($sql2);
		
			$this->db->query('LOCK TABLE detail_ambil_paket WRITE');
            $this->db->query('UNLOCK TABLES');
			
			$this->detail_ambil_paket_status_update($row->dapaket_id);
			$this->tindakan_detail_locked($row->dapaket_dtrawat);
		}
		
		
		
		// SELECT MENGAITKAN NOBUKTI MEDIS DAN NOBUKTI PAJAK		
		$sql = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
			FROM
				vu_detail_ambil_paket_rawat_simple
			WHERE dapaket_cust='$dapaket_cust' AND (kategori_nama = 'Medis' OR kategori_nama = 'Anti Aging' OR kategori_nama = 'Surgery')
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				/*AND master_jual_rawat.jrawat_stat_dok = '$stat_dok'*/
				";
		
		if ($nobukti_medis<>"-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_medis='".$nobukti_medis."')";
		}
		if ($nobukti_medis=="-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_medis='".$kode."')";		
		}
		
		

		$result = $this->db->query($sql);
		/*
		foreach($result->result() as $row){
			$this->detail_ambil_paket_status_update($row->dapaket_id, $nobukti_pajak);
			$this->tindakan_detail_locked($row->dapaket_dtrawat);
		}
		*/
		return $result;
	}
	
	// PENGAMBILAN PAKET NON MEDIS UNTUK ADA SATUAN
	function print_paper_apaket_bycust_nonmedis($dapaket_cust, $dapaket_date_create, $jrawat_id, $stat_dok){
		
		$sql_pajak = "SELECT jrawat_nobukti_pajak FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_pajak = $this->db->query($sql_pajak);
		$data_nobukti_pajak= $result_pajak->row();
		$nobukti_pajak= $data_nobukti_pajak->jrawat_nobukti_pajak;
		
		if($nobukti_pajak=='-'){
		// GENERATE FAKTUR PAJAK
		$pattern="010.000-".date("y").".";
		$length = 19;
		
		// AMBIL DARI M PUBLIC FUNCTION
		$len_pattern=strlen($pattern);
		$len_lpad=$length-$len_pattern;
		$sql="select concat(left(max(nobukti_pajak),".$len_pattern."),LPAD((right(max(nobukti_pajak),".$len_lpad.")+1),".$len_lpad.",0)) as max_key from 
			(
			select master_jual_rawat.jrawat_nobukti_pajak AS nobukti_pajak from master_jual_rawat

			union

			select detail_ambil_paket.dapaket_nobukti_pajak AS nobukti_pajak from detail_ambil_paket
			) AS table_union
		where nobukti_pajak like '".$pattern."%' AND
		nobukti_pajak is not null and nobukti_pajak <> 'M'";
		
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
		
		// UPDATE ke master_jual_rawat , agar nobukti_pajak di master_jual_rawat sama dengan di detail_ambil_paket.. 
		/*$sql_update_master = "UPDATE master_jual_rawat
                SET jrawat_nobukti_pajak = '".$kode."'
                WHERE jrawat_id='".$jrawat_id."'";
         $this->db->query($sql_update_master);*/
		
		// END OF GENERATE PAJAK
		}
		
		
		$sql_nobukti_medis = "SELECT jrawat_nobukti_medis FROM master_jual_rawat WHERE jrawat_id = ".$jrawat_id."";
		$result_medis = $this->db->query($sql_nobukti_medis);
		$data_nobukti_medis= $result_medis->row();
		$nobukti_medis= $data_nobukti_medis->jrawat_nobukti_medis;	
		
		
		// UPDATE STATUS DAN NOBUKTI PAJAK
		$sql_update = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
				,dapaket_nobukti_pajak
			FROM
				vu_detail_ambil_paket_rawat_simple
			WHERE dapaket_cust='$dapaket_cust' AND (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				AND dapaket_stat_dok='Terbuka'";
		
		$result_update = $this->db->query($sql_update);
		foreach($result_update->result() as $row){
			
			$sql = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_medis = '".$nobukti_medis."'
                WHERE dapaket_id='".$row->dapaket_id."'";
            $this->db->query($sql);
			
			if($nobukti_pajak=='-')
			{
			$sql2 = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_pajak = '".$kode."'
                WHERE dapaket_id='".$row->dapaket_id."'";
			}
			else if($nobukti_pajak!='-')
			{
			$sql2 = "UPDATE detail_ambil_paket
                SET dapaket_nobukti_pajak = '".$nobukti_pajak."'
                WHERE dapaket_id='".$row->dapaket_id."'";
			}
			
			$this->db->query($sql2);
			$this->db->query('LOCK TABLE detail_ambil_paket WRITE');
            $this->db->query('UNLOCK TABLES');
			
			$this->detail_ambil_paket_status_update($row->dapaket_id);
			$this->tindakan_detail_locked($row->dapaket_dtrawat);
		}
		
		// SELECT MENGAITKAN NOBUKTI PAJAK Tambahin disini utk dPP dll
		$sql = "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,0 as jrawat_diskon 
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
				,dapaket_nobukti_pajak
				,dpp
				,sub_tot_dpp
				,dapaket_jumlah*harga_satuan as uang_muka
			FROM
				vu_detail_ambil_paket_rawat
			WHERE dapaket_cust='$dapaket_cust' AND (kategori_nama = 'Non Medis' OR kategori_nama = 'SENAM' OR kategori_nama = 'Lain-lain')
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				/*AND master_jual_rawat.jrawat_stat_dok ='$stat_dok'*/
				";
		
		if ($nobukti_pajak<>"-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_pajak='".$nobukti_pajak."')";
		}
		if ($nobukti_pajak=="-"){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (dapaket_nobukti_pajak='".$kode."')";		
		}
		/*
		$sql .= " UNION ";
			
		$sql .= "SELECT
				dapaket_id
				,no_bukti AS jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,tanggal AS dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,harga_satuan
				,dapaket_jumlah*harga_satuan AS jum_paket 
				,dapaket_nobukti_pajak
				,dpp
				,sub_tot_dpp
				,jrawat_cashback as voucher_nonmedis
				,(jrawat_cashback/1.1) as voucher_dpp
				,(dpp-(jrawat_cashback/1.1))*0.1 as pajak
				,dapaket_jumlah*harga_satuan as uang_muka
			FROM
				vu_detail_ambil_paket_rawat
				left join master_jual_rawat on (master_jual_rawat.jrawat_nobukti_medis = vu_detail_ambil_paket_rawat.dapaket_nobukti_medis)
			WHERE dapaket_cust='$dapaket_cust' AND kategori_nama = 'Medis'
				AND date_format(tanggal,'%Y-%m-%d')='$dapaket_date_create'
				AND master_jual_rawat.jrawat_stat_dok ='$stat_dok'
				AND dapaket_nobukti_medis='".$nobukti_medis."'";
		*/
		$result = $this->db->query($sql);

		return $result;
	}
	
	
	/* End of isaac*/
////////////////EOFPAJAK/////////////

	function print_paper_apaket($dapaket_cust ,$dapaket_date_create){
		$sql = "SELECT dapaket_id
            FROM detail_ambil_paket
            WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
                AND dapaket_stat_dok='Terbuka'";
        $rss = $this->db->query($sql);
        foreach($rss->result() as $row){
			$this->detail_ambil_paket_status_update($row->dapaket_id);
		}
        
        $sql = "SELECT dapaket_id
				,jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,jpaket_customer.cust_nama AS jpaket_cust_nama
				,jpaket_customer.cust_no AS jpaket_cust_no
				,jpaket_customer.cust_alamat AS jpaket_cust_alamat
				,dapaket_customer.cust_no AS dapaket_cust_no
				,dapaket_customer.cust_nama AS dapaket_cust_nama
				,dapaket_customer.cust_alamat AS dapaket_cust_alamat
				,dapaket_tgl_ambil
				,detail_jual_paket.dpaket_sisa_paket AS dpaket_sisa_paket
				,dpaket_kadaluarsa
			FROM detail_ambil_paket
			LEFT JOIN master_jual_paket ON(dapaket_jpaket=jpaket_id)
			LEFT JOIN paket ON(dapaket_paket=paket_id)
			LEFT JOIN customer AS dapaket_customer ON(dapaket_cust=dapaket_customer.cust_id)
			LEFT JOIN perawatan ON(dapaket_item=rawat_id)
			LEFT JOIN customer AS jpaket_customer ON(jpaket_cust=jpaket_customer.cust_id)
			LEFT JOIN detail_jual_paket ON(detail_ambil_paket.dapaket_dpaket=detail_jual_paket.dpaket_id)
			WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
                AND dapaket_stat_dok='Tertutup'"; //mencetak semua pengambilan paket dari customer dalam tanggal yang dipilih
		
        $result = $this->db->query($sql);
		
		return $result;
	}

	function print_paper_apaket2($dapaket_cust ,$dapaket_date_create){
		$sql = "SELECT dapaket_id
            FROM detail_ambil_paket
            WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
                AND dapaket_stat_dok='Terbuka'";
        $rss = $this->db->query($sql);
        foreach($rss->result() as $row){
			$this->detail_ambil_paket_status_update($row->dapaket_id);
		}
        
        $sql = "SELECT dapaket_id
				,jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,jpaket_customer.cust_nama AS jpaket_cust_nama
				,jpaket_customer.cust_no AS jpaket_cust_no
				,jpaket_customer.cust_alamat AS jpaket_cust_alamat
				,dapaket_customer.cust_no AS dapaket_cust_no
				,dapaket_customer.cust_nama AS dapaket_cust_nama
				,dapaket_customer.cust_alamat AS dapaket_cust_alamat
				,dapaket_tgl_ambil
				,detail_jual_paket.dpaket_sisa_paket AS dpaket_sisa_paket
				,dpaket_kadaluarsa
			FROM detail_ambil_paket
			LEFT JOIN master_jual_paket ON(dapaket_jpaket=jpaket_id)
			LEFT JOIN paket ON(dapaket_paket=paket_id)
			LEFT JOIN customer AS dapaket_customer ON(dapaket_cust=dapaket_customer.cust_id)
			LEFT JOIN perawatan ON(dapaket_item=rawat_id)
			LEFT JOIN customer AS jpaket_customer ON(jpaket_cust=jpaket_customer.cust_id)
			LEFT JOIN detail_jual_paket ON(detail_ambil_paket.dapaket_dpaket=detail_jual_paket.dpaket_id)
			WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
                AND dapaket_stat_dok='Tertutup'"; //mencetak semua pengambilan paket dari customer dalam tanggal yang dipilih
		
        $result = $this->db->query($sql);
		
		return $result;
	}
	
	function print_paper_apaket_bycust($dapaket_cust, $dapaket_date_create){
		$sql = "SELECT dapaket_id
				,jpaket_nobukti
				,paket_nama
				,rawat_nama
				,dapaket_jumlah
				,cust_no
				,cust_nama
				,cust_alamat
				,dapaket_tgl_ambil
				,dapaket_dtrawat
				,dpaket_sisa_paket
				,dpaket_kadaluarsa
			FROM detail_ambil_paket
			LEFT JOIN master_jual_paket ON(dapaket_jpaket=jpaket_id)
			LEFT JOIN paket ON(dapaket_paket=paket_id)
			LEFT JOIN customer ON(dapaket_cust=cust_id)
			LEFT JOIN perawatan ON(dapaket_item=rawat_id)
			LEFT JOIN detail_jual_paket ON(dapaket_dpaket=dpaket_id)
			WHERE dapaket_cust='$dapaket_cust'
				AND date_format(dapaket_tgl_ambil,'%Y-%m-%d')='$dapaket_date_create'
				AND dapaket_stat_dok='Terbuka'";
		
		$result = $this->db->query($sql);
		foreach($result->result() as $row){
			$this->detail_ambil_paket_status_update($row->dapaket_id);
			$this->tindakan_detail_locked($row->dapaket_dtrawat);
		}
		return $result;
	}
	
	function cara_bayar($jrawat_id){
		$sql="SELECT jrawat_nobukti, jrawat_cara FROM master_jual_rawat WHERE jrawat_id='$jrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
            $jrawat_nobukti = $record->jrawat_nobukti;
			if(($record->jrawat_cara !== NULL || $record->jrawat_cara !== '')){
				if($record->jrawat_cara == 'tunai'){
                    $sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, jtunai_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
                    $rs=$this->db->query($sql);
                    if($rs->num_rows()){
                        return $rs->row();
                    }else{
                        return NULL;
                    }
				}elseif($record->jrawat_cara == 'kwitansi'){
                    $sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, jkwitansi_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
                    $rs=$this->db->query($sql);
                    if($rs->num_rows()){
                        return $rs->row();
                    }else{
                        return NULL;
                    }
				}elseif($record->jrawat_cara == 'card'){
                    $sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, jcard_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
                    $rs=$this->db->query($sql);
                    if($rs->num_rows()){
                        return $rs->row();
                    }else{
                        return NULL;
                    }
				}elseif($record->jrawat_cara == 'cek/giro'){
                    $sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, jcek_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
                    $rs=$this->db->query($sql);
                    if($rs->num_rows()){
                        return $rs->row();
                    }else{
                        return NULL;
                    }
				}elseif($record->jrawat_cara == 'transfer'){
                    $sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, jtransfer_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
                    $rs=$this->db->query($sql);
                    if($rs->num_rows()){
                        return $rs->row();
                    }else{
                        return NULL;
                    }
				}elseif($record->jrawat_cara == 'voucher'){
                    $sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
                    
                    $sql="SELECT jrawat_nobukti, jrawat_cara, tvoucher_nilai AS bayar_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 0,1";
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
	
	function cara_bayar2($jrawat_id){
		$sql="SELECT jrawat_nobukti, jrawat_cara2 FROM master_jual_rawat WHERE jrawat_id='$jrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
            $jrawat_nobukti = $record->jrawat_nobukti;
			if(($record->jrawat_cara2 !== NULL || $record->jrawat_cara2 !== '')){
				if($record->jrawat_cara2 == 'tunai'){
                    $sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jtunai_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara2 == 'kwitansi'){
                    $sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jkwitansi_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara2 == 'card'){
                    $sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jcard_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara2 == 'cek/giro'){
                    $sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara2 == 'transfer'){
                    $sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jtransfer_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara2 == 'voucher'){
                    $sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, tvoucher_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
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
	
	function cara_bayar3($jrawat_id){
		$sql="SELECT jrawat_nobukti, jrawat_cara3 FROM master_jual_rawat WHERE jrawat_id='$jrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$record=$rs->row();
            $jrawat_nobukti = $record->jrawat_nobukti;
			if(($record->jrawat_cara3 !== NULL || $record->jrawat_cara3 !== '')){
				if($record->jrawat_cara3 == 'tunai'){
                    $sql = "SELECT jtunai_id FROM jual_tunai WHERE jtunai_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtunai_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_tunai ON(jtunai_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara3 == 'kwitansi'){
                    $sql = "SELECT jkwitansi_id FROM jual_kwitansi WHERE jkwitansi_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jkwitansi_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_kwitansi ON(jkwitansi_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara3 == 'card'){
                    $sql = "SELECT jcard_id FROM jual_card WHERE jcard_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jcard_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_card ON(jcard_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara3 == 'cek/giro'){
                    $sql = "SELECT jcek_id FROM jual_cek WHERE jcek_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara2, jcek_nilai AS bayar2_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jcek_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_cek ON(jcek_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara3 == 'transfer'){
                    $sql = "SELECT jtransfer_id FROM jual_transfer WHERE jtransfer_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, jtransfer_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN jual_transfer ON(jtransfer_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}
				}elseif($record->jrawat_cara3 == 'voucher'){
                    $sql = "SELECT tvoucher_id FROM voucher_terima WHERE tvoucher_ref='".$jrawat_nobukti."'";
					$rs = $this->db->query($sql);
					if($rs->num_rows()==1){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==2){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 1,1";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							return $rs->row();
						}else{
							return NULL;
						}
					}else if($rs->num_rows()==3){
						$sql="SELECT jrawat_nobukti, jrawat_cara3, tvoucher_nilai AS bayar3_nilai FROM master_jual_rawat LEFT JOIN voucher_terima ON(tvoucher_ref=jrawat_nobukti) WHERE jrawat_id='$jrawat_id' LIMIT 2,1";
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