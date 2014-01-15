<? /* 	
		Miracle IT Team
*/

class M_master_ambil_paket extends Model{
		
		//constructor
		function M_master_ambil_paket() {
			parent::Model();
		}
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group,$bulan,$tahun){
			$order_by="";
			$group_by="";
			$tanggal="";
			if($periode=='all') {
				$tanggal = "";
			}
			else if($periode=='bulan') {
				$tanggal = " AND date_format(m.jpaket_tanggal, '%Y-%m')<='".$tahun."-".$bulan."'";
			} 
			else if($periode=='tanggal') {	
				$tanggal = " AND date_format(m.jpaket_tanggal, '%Y-%m-%d')<='".$tgl_akhir."'";
			}
			
			
			switch($group){
				case "Tanggal": $order_by=" ORDER BY tanggal";$group_by=" GROUP BY tanggal";break;
				case "Customer": $order_by=" ORDER BY cust_id";break;
				case "No Faktur": $order_by=" ORDER BY no_bukti";break;
				case "Paket": $order_by=" ORDER BY paket_kode";break;
				case "Sisa Paket (Akumulatif)": $order_by=" GROUP BY no_bukti, dpaket_id
					UNION
					(
						SELECT
						m.jpaket_nobukti as no_bukti,
						m.jpaket_tanggal as tanggal,
						m.jpaket_tanggal as tanggal_beli,
						p.paket_nama as paket_nama,
						p.paket_kode as paket_kode,
						m.jpaket_cust as cust_id,
						c.cust_nama as cust_nama,
						c.cust_no as cust_no,
						0 as dapaket_paket,
						0 as jumlah,
						ifnull(((((((d.dpaket_harga * (100 - d.dpaket_diskon)) / 100) * d.dpaket_jumlah) - (((m.jpaket_diskon * ((d.dpaket_harga * (100 - d.dpaket_diskon)) / 100)) * d.dpaket_jumlah) / 100)) / d.dpaket_jumlah) / vu_jumlah_isi_paket.isi_paket),0) AS harga_satuan,
						vu_jumlah_isi_paket.isi_paket AS isi_paket,
						(d.dpaket_jumlah * vu_jumlah_isi_paket.isi_paket) AS total_jumlah,
						((d.dpaket_jumlah * vu_jumlah_isi_paket.isi_paket) - d.dpaket_sisa_paket) as pengambilan,
						d.dpaket_sisa_paket AS sisa_paket,
						((d.dpaket_harga * d.dpaket_jumlah) - (((d.dpaket_harga * d.dpaket_jumlah) * d.dpaket_diskon) / 100)) 
						AS nilai_paket,
						0 as nilai_ambil_paket,
						((d.dpaket_harga * d.dpaket_jumlah) - (((d.dpaket_harga * d.dpaket_jumlah) * d.dpaket_diskon) / 100)) 
						AS nilai_sisa_paket	
					FROM
						detail_jual_paket d
					LEFT JOIN master_jual_paket m ON (d.dpaket_master = m.jpaket_id)
					LEFT JOIN paket p ON (d.dpaket_paket = p.paket_id)
					LEFT JOIN customer c ON (m.jpaket_cust = c.cust_id)
					LEFT JOIN vu_jumlah_isi_paket ON (d.dpaket_paket = vu_jumlah_isi_paket.paket_id)
					WHERE
						(d.dpaket_jumlah * vu_jumlah_isi_paket.isi_paket) = d.dpaket_sisa_paket
						".$tanggal."
				)";
				break;
				case "Perawatan Semua": $order_by=" ORDER BY rawat_id";break;
				case "Perawatan Medis": $order_by="AND kategori_nama = 'Medis' ORDER BY rawat_id";break;
				case "Perawatan Non Medis": $order_by="AND kategori_nama = 'Non Medis' ORDER BY rawat_id";break;
				case "Perawatan Anti Aging": $order_by="AND kategori_nama = 'Anti Aging' ORDER BY rawat_id";break;
				case "Perawatan Surgery": $order_by="AND kategori_nama = 'Surgery' ORDER BY rawat_id";break;
				case "Perawatan Lain-Lain": $order_by="AND kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging' ORDER BY rawat_id";break;
				case "Pemakai": $order_by=" ORDER BY pemakai_nama";break;
				case "Referal": $order_by=" ORDER BY referal";break;
				default: $order_by=" ORDER BY no_bukti";break;
			}
			
			if($opsi=='rekap'){
				if($opsi_status=='tertutup'){
					if($periode=='all')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup'".$order_by;
					else if($periode=='bulan')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal'){
						if ($group == 'Sisa Paket (Akumulatif)') {
							$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
						} else {
							$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
						}
					}
				}else if($opsi_status=='adjustment'){
					if($periode=='all')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj'".$order_by;
					else if($periode=='bulan')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}else if($opsi_status=='batal'){
					if($periode=='all')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_paket, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal'".$order_by;
					else if($periode=='bulan')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_paket, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_paket, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}else if($opsi=='detail'){
				if($opsi_status=='tertutup'){
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' ".$order_by;
					else if($periode=='bulan') {
						if ($group == 'Sisa Paket (Akumulatif)') {
							$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
						} else {	
							$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
						}
					}
					else if($periode=='tanggal') {
						if ($group == 'Sisa Paket (Akumulatif)') {
							$sql="SELECT no_bukti,tanggal,tanggal_beli,paket_nama,paket_kode,cust_id,cust_nama,cust_no,dapaket_paket,dapaket_jumlah as jumlah, harga_satuan, isi_paket, total_jumlah, pengambilan, sisa_paket, nilai_paket, nilai_ambil_paket, nilai_sisa_paket FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
						} else {
							$sql="SELECT distinct * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
						}
					}
				}else if($opsi_status=='adjustment'){
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal') 
						$sql="SELECT distinct * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Adj' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;	
					
				}else if($opsi_status=='batal'){
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal' ".$order_by;
					else if($periode=='bulan') 
						$sql="SELECT * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal') 
						$sql="SELECT distinct * FROM vu_detail_ambil_paket_rawat WHERE jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Batal' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}
			
			//echo $sql;
			
			$query=$this->db->query($sql);
			return $query->result();
		}
		
	/* UPDATE db.detail_jual_paket.dpaket_sisa_paket */
	function total_sisa_paket_update($dapaket_dpaket, $dapaket_jpaket, $dapaket_paket){
		$sql_sisa_paket = "UPDATE detail_jual_paket
			LEFT JOIN paket ON(dpaket_paket=paket_id)
			LEFT JOIN vu_total_ambil_paket ON(vu_total_ambil_paket.dapaket_dpaket=dpaket_id 
				AND vu_total_ambil_paket.dapaket_jpaket=detail_jual_paket.dpaket_master
				AND vu_total_ambil_paket.dapaket_paket=detail_jual_paket.dpaket_paket)
			SET dpaket_sisa_paket=((dpaket_jumlah*paket_jmlisi)- IF(isnull(vu_total_ambil_paket.total_ambil_paket),0,vu_total_ambil_paket.total_ambil_paket))
			WHERE detail_jual_paket.dpaket_id='$dapaket_dpaket'
				AND detail_jual_paket.dpaket_master='$dapaket_jpaket'
				AND detail_jual_paket.dpaket_paket='$dapaket_paket'";
		$this->db->query($sql_sisa_paket);
		return 1;		
		
	}
		
//function for get list record
		function phonegroup_list($query,$start,$end){
			$sql = "SELECT * FROM phonegroup where phonegroup_aktif = 'Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (phonegroup_nama like '%".$query."%' ) ";
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
	
		function get_referal_list($query){
			$sql=  "SELECT 
						karyawan_id,karyawan_nama,karyawan_username
					FROM vu_karyawan 
					INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
					WHERE karyawan_aktif='Aktif' AND (jabatan_nama='Dokter' OR jabatan_nama='Therapist' OR jabatan_nama='Staff' OR jabatan_nama='Supervisor')";
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
		
		function get_paket_list($query,$start,$end){
			/*$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_paket="SELECT distinct(dpaket_paket) FROM detail_jual_paket WHERE dpaket_master='$query'";
				$rs=$this->db->query($sql_paket);
				$rs_rows=$rs->num_rows();
			}*/
			
			$sql="SELECT paket_id, paket_kode, group_nama, paket_nama FROM paket INNER JOIN produk_group ON paket.paket_group=produk_group.group_id INNER JOIN kategori ON produk_group.group_kelompok=kategori.kategori_id WHERE kategori.kategori_jenis='paket' AND paket_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (paket_kode LIKE '%".addslashes($query)."%' OR paket_nama LIKE '%".addslashes($query)."%' ) ";
			}/*else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$query)? " OR ":" AND ";
					foreach($rs->result() as $row_paket){
						
						$filter.="OR paket_id='".$row_paket->dpaket_paket."' ";
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
		
		function get_customer_list($query,$start,$end){
			$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah FROM customer WHERE cust_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (cust_nama like '%".$query."%' ) ";
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
		
		function get_pengguna_paket_list($dpaket_master){
			$query = "SELECT cust_id, cust_nama, cust_no, cust_tgllahir, cust_alamat, cust_telprumah FROM pengguna_paket LEFT JOIN customer ON(ppaket_cust=cust_id) LEFT JOIN master_jual_paket ON(ppaket_master=jpaket_id AND ppaket_cust=jpaket_cust) WHERE ppaket_master='$dpaket_master'";
			
			//$query2 = "SELECT cust_id, cust_nama, cust_no, cust_tgllahir, cust_alamat, cust_telprumah FROM pengguna_paket LEFT JOIN customer ON(ppaket_cust=cust_id) LEFT JOIN master_jual_paket ON(ppaket_master=jpaket_id AND ppaket_cust<>jpaket_cust) WHERE ppaket_master='$jpaket_id'";
			//echo $query."<br />";
			//echo $query2;
			
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			//$result2 = $this->db->query($query2);
			//$nbrows2 = $result2->num_rows();
			
			//$nbrows=0;
			//$nbrows2=0;
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				/*if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				if($nbrows2>0){
					foreach($result2->result() as $row2){
						$arr[] = $row2;
					}
				}
				$nbrows=$nbrows+$nbrows2;*/
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		function get_history_ambil_paket($dapaket_dpaket,$start,$end){
			/* Ambil dari db.detail_ambil_paket */
			/*$query_backup_byhendri =   "SELECT 
							pr.rawat_nama, 
							d.dapaket_jumlah, 
							c.cust_nama,
							date_format(d.tgl_ambil, '%Y-%m-%d') as tgl_ambil
						FROM detail_ambil_paket d
						LEFT JOIN submaster_apaket_item s ON ( d.dapaket_sapaket= s.sapaket_id ) 
						LEFT JOIN perawatan pr ON ( s.sapaket_item = pr.rawat_id ) 
						LEFT JOIN customer c ON ( d.dapaket_cust = c.cust_id )
						WHERE dapaket_master='$apaket_id'
						ORDER BY tgl_ambil"; //by hendri*/
			
			//$query = "SELECT date_format(dapaket_date_create, '%Y-%m-%d') AS tgl_ambil, rawat_nama, dapaket_jumlah, cust_nama FROM detail_ambil_paket LEFT JOIN master_ambil_paket ON(dapaket_master=apaket_id) LEFT JOIN perawatan ON(apaket_item=rawat_id) LEFT JOIN customer ON(dapaket_cust=cust_id) WHERE apaket_jpaket='$dpaket_master' AND apaket_paket='$dpaket_paket' ORDER BY dapaket_date_create";
			
			/*$query = "SELECT dapaket_id
					,date_format(dapaket_date_create, '%Y-%m-%d') AS tgl_ambil
					,rawat_nama
					,dapaket_jumlah
					,cust_nama
					,IF((isnull(terapis.karyawan_username) AND isnull(dokter.karyawan_username)),referal.karyawan_username,IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username)) AS referal
					,dapaket_stat_dok
				FROM detail_ambil_paket
				LEFT JOIN perawatan ON(dapaket_item=rawat_id)
				LEFT JOIN customer ON(dapaket_cust=cust_id)
				LEFT JOIN tindakan_detail ON(dapaket_dtrawat=dtrawat_id)
				LEFT JOIN vu_karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
                LEFT JOIN vu_karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
				LEFT JOIN vu_karyawan AS referal ON(dapaket_referal=referal.karyawan_id)
				WHERE dapaket_dpaket='$dapaket_dpaket'
				ORDER BY dapaket_date_create DESC";*/
			$query = "SELECT dapaket_id
					,dapaket_tgl_ambil AS tgl_ambil
					,rawat_nama
					,dapaket_jumlah
					,cust_nama
					,dapaket_keterangan
					,IF((isnull(terapis.karyawan_username) AND isnull(dokter.karyawan_username)),referal.karyawan_username,IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username)) AS referal
					,dapaket_stat_dok
				FROM detail_ambil_paket
				LEFT JOIN perawatan ON(dapaket_item=rawat_id)
				LEFT JOIN customer ON(dapaket_cust=cust_id)
				LEFT JOIN tindakan_detail ON(dapaket_dtrawat=dtrawat_id)
				LEFT JOIN vu_karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
                LEFT JOIN vu_karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
				LEFT JOIN vu_karyawan AS referal ON(dapaket_referal=referal.karyawan_id)
				WHERE dapaket_dpaket='$dapaket_dpaket'
				ORDER BY dapaket_tgl_ambil DESC";
			
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
		
		function get_daftar_pemakai_paket($dpaket_master,$start,$end){
			$query = "select customer.cust_nama, customer.cust_alamat, customer.cust_no, customer.cust_id
						from pengguna_paket
						left join detail_jual_paket on (detail_jual_paket.dpaket_master = pengguna_paket.ppaket_master)
						left join customer on (customer.cust_id = pengguna_paket.ppaket_cust)
					where ppaket_master = '$dpaket_master'
					group by customer.cust_nama";
			
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

		//Ambil Perawatan berdasarkan db.paket_isi_perawatan.rpaket_perawatan yang dihasilkan dari (db.paket_isi_perawatan.rpaket_master = paket.paket_id)
		function get_isi_rawat_list($dapaket_dpaket,$dapaket_jpaket,$dapaket_paket,$start,$end){
			$rs_rows=0;
			if(is_numeric($dapaket_dpaket)==true AND is_numeric($dapaket_jpaket)==true AND is_numeric($dapaket_paket)==true){
				/*$sql_rpaket="SELECT distinct(rpaket_perawatan) FROM paket_isi_perawatan WHERE rpaket_master='$paket_id'";
				$rs=$this->db->query($sql_rpaket);
				$rs_rows=$rs->num_rows();*/
				
				//$sql_backup_20100404 = "SELECT sapaket_id, rawat_id,rawat_kode,rawat_nama,sapaket_sisa_item FROM submaster_apaket_item LEFT JOIN perawatan ON(sapaket_item=rawat_id) WHERE sapaket_jenis_item='perawatan' AND sapaket_master='$apaket_id' AND (rawat_aktif='Aktif' OR rawat_aktif='Tidak Aktif')";
				
				/*if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$paket_id)? " OR ":" AND ";
					foreach($rs->result() as $row_rpaket){
						
						$filter.="OR rpaket_perawatan='".$row_rpaket->rpaket_perawatan."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}*/
				
				//$sql_backup20100405="SELECT apaket_id, rawat_id, rawat_kode, rawat_nama, apaket_sisa_item FROM master_ambil_paket LEFT JOIN perawatan ON(apaket_item=rawat_id) WHERE apaket_jpaket='$apaket_jpaket' AND apaket_paket='$apaket_paket'";
				$sql="SELECT rawat_id, rawat_kode, rawat_nama FROM paket_isi_perawatan LEFT JOIN paket ON(rpaket_master=paket_id) LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id) WHERE rpaket_master='$dapaket_paket'";
				
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
		}
		
		//function for detail
		//get record list
		function detail_ambil_paket_isi_perawatan_list($master_id,$query,$start,$end) {
			$query = "SELECT rpaket_id,rpaket_perawatan,rpaket_jumlah FROM paket_isi_perawatan WHERE rpaket_master='".$master_id."'";
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
			$query = "SELECT max(paket_id) as master_id from paket";
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
		function detail_ambil_paket_isi_perawatan_purge($master_id){
			$sql="DELETE from paket_isi_perawatan where rpaket_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
		
		//insert detail record
		function detail_ambil_paket_isi_perawatan_insert($dapaket_dpaket
														 ,$dapaket_jpaket
														 ,$dapaket_paket
														 ,$dapaket_item
														 ,$dapaket_jumlah
														 ,$dapaket_cust
														 ,$tgl_ambil
														 ,$keterangan
														 ,$dapaket_referal
														 ,$count
														 ,$dcount){
			$nilai_return='0';
			//* Check apakah sisa_item dari $dapaket_item tsb masih memiliki sisa ? /
			$sql_punya_paket="SELECT (dpaket_jumlah*rpaket_jumlah) AS rpaket_jumlah
					,dpaket_id
					,dpaket_master
					,dpaket_paket
					,dpaket_sisa_paket
				FROM paket_isi_perawatan
					LEFT JOIN detail_jual_paket ON(rpaket_master=dpaket_paket)
					LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id)
				WHERE dpaket_id='$dapaket_dpaket'
					AND rpaket_perawatan='$dapaket_item'";
			$rs_punya_paket=$this->db->query($sql_punya_paket);
			if($rs_punya_paket->num_rows()){
				$punya_paket_rows = $rs_punya_paket->num_rows();
				
				$i=0;
				foreach($rs_punya_paket->result() as $row_punya_paket){
					$i++;
					$sql_paket_terpakai="SELECT sum(dapaket_jumlah) AS total_item_terpakai
						FROM detail_ambil_paket
						WHERE dapaket_dpaket='$row_punya_paket->dpaket_id'
							AND dapaket_stat_dok<>'Batal'
						GROUP BY dapaket_dpaket";
					$rs_paket_terpakai=$this->db->query($sql_paket_terpakai);
					if($rs_paket_terpakai->num_rows()){
						$record_paket_terpakai = $rs_paket_terpakai->row();
						if((($row_punya_paket->rpaket_jumlah > $record_paket_terpakai->total_item_terpakai) && ($row_punya_paket->dpaket_sisa_paket >= $dapaket_jumlah)) || (($row_punya_paket->rpaket_jumlah==0) && ($row_punya_paket->dpaket_sisa_paket >= $dapaket_jumlah))){
							//return $row_punya_paket;
							//* INSERT ke db.detail_ambil_paket sebagai History Pengambilan Paket /
							$dti_dapaket=array(
							"dapaket_dpaket"=>$dapaket_dpaket,
							"dapaket_jpaket"=>$dapaket_jpaket,
							"dapaket_paket"=>$dapaket_paket,
							"dapaket_item"=>$dapaket_item,
							"dapaket_jenis_item"=>'perawatan',
							"dapaket_jumlah"=>$dapaket_jumlah,
							"dapaket_cust"=>$dapaket_cust,
							"dapaket_creator"=>@$_SESSION[SESSION_USERID],
							"dapaket_tgl_ambil"=>$tgl_ambil,
							"dapaket_referal"=>$dapaket_referal,
							"dapaket_keterangan"=>$keterangan
							);
							$this->db->insert('detail_ambil_paket', $dti_dapaket);
							
							if($this->db->affected_rows()){
								//* UPDATE db.detail_jual_paket.dpaket_sisa_paket ==> sisa paket dari paket yang dibeli akan diupdate akibat dari pengambilan paket /
								$dpaket_sisa_update = $this->total_sisa_paket_update($dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket);
								if($dpaket_sisa_update==1){
									$nilai_return='1';
									break;
								}else{
									$nilai_return='0';
									break;
								}
								
							}else{
								$nilai_return='0';
								break;
							}
						}else{
							if($i==$punya_paket_rows){
								$nilai_return='0';
								break;
							}
						}
						
					}else{
					
					if(($row_punya_paket->dpaket_sisa_paket >= $dapaket_jumlah) || (($row_punya_paket->rpaket_jumlah==0) && ($row_punya_paket->dpaket_sisa_paket >= $dapaket_jumlah)))
					{
						//return $row_punya_paket;
						//* INSERT ke db.detail_ambil_paket sebagai History Pengambilan Paket /
						$dti_dapaket=array(
						"dapaket_dpaket"=>$dapaket_dpaket,
						"dapaket_jpaket"=>$dapaket_jpaket,
						"dapaket_paket"=>$dapaket_paket,
						"dapaket_item"=>$dapaket_item,
						"dapaket_jenis_item"=>'perawatan',
						"dapaket_jumlah"=>$dapaket_jumlah,
						"dapaket_cust"=>$dapaket_cust,
						"dapaket_creator"=>@$_SESSION[SESSION_USERID],
						"dapaket_tgl_ambil"=>$tgl_ambil,
						"dapaket_referal"=>$dapaket_referal,
						"dapaket_keterangan"=>$keterangan
						);
						$this->db->insert('detail_ambil_paket', $dti_dapaket);
						
						if($this->db->affected_rows()){
							//* UPDATE db.detail_jual_paket.dpaket_sisa_paket ==> sisa paket dari paket yang dibeli akan diupdate akibat dari pengambilan paket /
							$dpaket_sisa_update = $this->total_sisa_paket_update($dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket);
							if($dpaket_sisa_update==1){
								$nilai_return='1';
								break;
							}else{
								$nilai_return='0';
								break;
							}
							
						}else{
							$nilai_return='0';
							break;
						}
						
						
					}
					else 
					{
						$nilai_return='0';
						break;
					}

					}
				}
				if($count==($dcount-1)){
					return $nilai_return;
				}
			}else{
				return '-1';
			}

		}
		//end of function
		
		//function for get list record
		function ambil_paket_list($filter,$start,$end){
			/* Untuk menampilkan ke View.LIST = {Customer, No.Faktur Penjualan Paket, Tanggal Pembelian, Tanggal Expired Paket, Nama Paket } */
			//$query = "SELECT customer.cust_id, customer.cust_nama, customer.cust_no, master_jual_paket.jpaket_id, master_jual_paket.jpaket_nobukti, master_jual_paket.jpaket_tanggal, detail_jual_paket.dpaket_id, detail_jual_paket.dpaket_kadaluarsa, paket.paket_id, paket.paket_nama, paket.paket_kode, master_ambil_paket.apaket_sisa_paket, master_ambil_paket.apaket_id FROM master_ambil_paket INNER JOIN detail_jual_paket ON(dpaket_id=apaket_dpaket) LEFT JOIN master_jual_paket ON(jpaket_id=dpaket_master) LEFT JOIN customer ON(cust_id=jpaket_cust) LEFT JOIN paket ON(paket_id=dpaket_paket)";
			//$query = "SELECT * FROM vu_kasir_ambil_paket_list";
			/*$query =   "SELECT
							apaket_id, apaket_jpaket, apaket_faktur, apaket_faktur_tanggal, apaket_kadaluarsa, apaket_cust, 
							apaket_paket, 
							apaket_paket_jumlah, apaket_sisa_paket ,
							c.cust_no, c.cust_nama, p.paket_kode, p.paket_nama
						FROM master_ambil_paket m
						LEFT OUTER JOIN customer c on c.cust_id = m.apaket_cust
						LEFT OUTER JOIN paket p on p.paket_id = m.apaket_paket
						WHERE apaket_sisa_paket >= 0 AND apaket_faktur_tanggal >= '2007-01-01'"; //by hendri*/
			$query = "SELECT dpaket_master
					,dpaket_paket
					,cust_id
					,cust_no
					,cust_nama
					,date_format(jpaket_tanggal,'%d-%m-%Y') as jpaket_tanggal
					,jpaket_nobukti
					,paket_kode
					,paket_nama
					,dpaket_id
					,dpaket_jumlah
					,dpaket_sisa_paket
					,date_format(dpaket_kadaluarsa,'%d-%m-%Y') as dpaket_kadaluarsa
					,date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) as tanggal_hangus
				FROM detail_jual_paket 
				LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
				LEFT JOIN customer ON(jpaket_cust=cust_id) 
				LEFT JOIN paket ON(dpaket_paket=paket_id) 
				WHERE dpaket_sisa_paket > 0
					AND date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')
					AND jpaket_stat_dok='Tertutup' ";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%'
					OR cust_no LIKE '%".addslashes($filter)."%'
					OR paket_kode LIKE '%".addslashes($filter)."%'
					OR paket_nama LIKE '%".addslashes($filter)."%'
					OR jpaket_nobukti LIKE '%".addslashes($filter)."%')";
			}

			$query .= " ORDER BY jpaket_nobukti DESC";
			
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
		function ambil_paket_update($paket_id ,$paket_kode ,$paket_nama ,$paket_expired ){
			/* Check di db.master_ambil_paket apakah No.Faktur Penjualan Paket && Paket_ID telah ada di db.master_ambil_paket ? */
			/*$data = array(
				"paket_id"=>$paket_id, 
				"paket_kode"=>$paket_kode, 
				"paket_nama"=>$paket_nama, 
				"paket_expired"=>$paket_expired
			);
			$this->db->where('paket_id', $paket_id);
			$this->db->update('paket', $data);*/
			
			return '1';
		}
		
		//function for create new record
		function ambil_paket_create($paket_kode ,$paket_nama ,$paket_expired ){
			$data = array(
				"paket_kode"=>$paket_kode, 
				"paket_nama"=>$paket_nama, 
				"paket_expired"=>$paket_expired
			);
			$this->db->insert('paket', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function ambil_paket_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the pakets at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM paket WHERE paket_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM paket WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "paket_id= ".$pkid[$i];
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

		
		
		/* Pengecekan Dokumen untuk membatalkan paket yang sudah terambil*/ 
		function pengecekan_dokumen_untuk_batal($tanggal_pengecekan){
			
		$date = date('Y-m-d');
			//$date_1 = '01';
			//$date_2 = '02';
			$date_3 = '03';
			$month = substr($tanggal_pengecekan[0],5,2);
			$year = substr($tanggal_pengecekan[0],0,4);
			$begin=mktime(0,0,0,$month,1,$year);
			$nextmonth=strtotime("+1month",$begin);
			
			$month_next = substr(date("Y-m-d",$nextmonth),5,2);
			$year_next = substr(date("Y-m-d",$nextmonth),0,4);
			
			//$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
			//$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
			$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
            $datetime_now = date('Y-m-d H:i:s');
     
			if ($date <= $tanggal_3 || $tanggal_pengecekan[0] == $date)
			{
				return '1';
			}
			else
			{
				return '0';
			}
		
		}
		
		function ambil_paket_status_adj($dapaket_id){
			$sql = "SELECT dapaket_dpaket ,dapaket_jpaket ,dapaket_paket FROM detail_ambil_paket WHERE dapaket_id='".$dapaket_id[0]."'";
			$rs = $this->db->query($sql);
			$datetime_now = date('Y-m-d H:i:s');
			
			if($rs->num_rows()){
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
			}
			
				
				
		}

	
		function ambil_paket_batal($dapaket_id){
			$sql = "SELECT dapaket_dpaket ,dapaket_jpaket ,dapaket_paket FROM detail_ambil_paket WHERE dapaket_id='".$dapaket_id[0]."'";
			$rs = $this->db->query($sql);
			$datetime_now = date('Y-m-d H:i:s');

			if($rs->num_rows()){
				$record = $rs->row_array();
				$dapaket_dpaket = $record['dapaket_dpaket'];
				$dapaket_jpaket = $record['dapaket_jpaket'];
				$dapaket_paket = $record['dapaket_paket'];
				
				//Membatalkan satu pengambilan paket /
				if (sizeof($dapaket_id) == 1){
					$query = "UPDATE detail_ambil_paket 
								SET dapaket_stat_dok='Batal',
									dapaket_date_update='".$datetime_now."',
									dapaket_update='".@$_SESSION[SESSION_USERID]."',
									dapaket_revised=(dapaket_revised+1)
						WHERE dapaket_id = ".$dapaket_id[0];
						//DATE_ADD(date_format(dapaket_date_create, '%Y-%m-%d'),INTERVAL 40 DAY)>date_format(now(), '%Y-%m-%d') 
					$this->db->query($query);
					if($this->db->affected_rows()>0){
						$dpaket_sisa_update = $this->total_sisa_paket_update($dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket);
						if($dpaket_sisa_update==1){
							return '1';
						}else{
							return '0';
						}
						
					}else
						return '0';
				}else{
					return '0';
				}
			}else{
				return '0';
			}
			
		}
		
		//function for advanced search record
		function ambil_paket_search($apaket_faktur, $apaket_cust, $apaket_paket, $apaket_kadaluarsa, $apaket_kadaluarsa_akhir, $apaket_tgl_faktur, $apaket_tgl_faktur_akhir, $apaket_sisa, $apaket_jenis, $apaket_sortby, $apaket_jenis_kadaluarsa, $apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end,$start, $end){
			//full query
			//$query="select * from paket";
			//$query = "SELECT apaket_id, apaket_jpaket, apaket_faktur, apaket_faktur_tanggal, apaket_kadaluarsa, apaket_cust, apaket_cust_no, apaket_cust_nama, apaket_paket, apaket_paket_kode, apaket_paket_nama, apaket_paket_jumlah, apaket_sisa_paket FROM master_ambil_paket";
//			$query =   "SELECT 
//							apaket_id, apaket_jpaket, apaket_faktur, apaket_faktur_tanggal, apaket_kadaluarsa, apaket_cust, 
//							/*apaket_cust_no, apaket_cust_nama, */ 
//							apaket_paket, 
//							/*apaket_paket_kode, apaket_paket_nama, */ 
//							apaket_paket_jumlah, apaket_sisa_paket , 
//							c.cust_no, c.cust_nama, p.paket_kode, p.paket_nama 
//						FROM master_ambil_paket m 
//						LEFT OUTER JOIN customer c on c.cust_id = m.apaket_cust 
//						LEFT OUTER JOIN paket p on p.paket_id = m.apaket_paket ";

		/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_transaksi_start."' AND '".$apaket_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_tidak_transaksi_start."' AND '".$apaket_tidak_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}
			
			$query =   "SELECT 
							dpaket_master, 
							dpaket_paket, 
							cust_id, cust_no, 
							cust_nama, 
							date_format(jpaket_tanggal,'%d-%m-%Y') as jpaket_tanggal, 
							jpaket_nobukti, 
							paket_kode, 
							paket_nama, 
							dpaket_id, 
							dpaket_jumlah, dpaket_sisa_paket, 
							date_format(dpaket_kadaluarsa,'%d-%m-%Y') as dpaket_kadaluarsa,
							date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) as tanggal_hangus
						FROM detail_jual_paket 
						LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
						LEFT JOIN customer ON(jpaket_cust=cust_id) 
						LEFT JOIN paket ON(dpaket_paket=paket_id)
						WHERE jpaket_stat_dok='Tertutup'";
						
			$datetime_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			
			if($apaket_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_nobukti LIKE '%".$apaket_faktur."%'";
			};
			if($apaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id = '".$apaket_cust."'";
			};
			if($apaket_paket!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_id = '".$apaket_paket."'";
			};
			
			if($apaket_sisa=='1'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket > 0 ";	
			};
			
			if($apaket_sisa=='Sisa 0'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket = 0 ";	
			};
			
			if($apaket_kadaluarsa!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$apaket_kadaluarsa'";
			};
			if($apaket_kadaluarsa_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') <= '$apaket_kadaluarsa_akhir'";
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif&Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')";	
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$date' ";	
			};
			
			if($apaket_jenis_kadaluarsa=='Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa between date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) and date_format(now(),'%Y-%m-%d'))";	
			};
			
			if($apaket_jenis_kadaluarsa=='Hangus'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) )";	
			};
			
			if($apaket_jenis=='Medis'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '2' ";	
			};
			
			if($apaket_jenis=='Non'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '3' ";	
			};
			
			if($apaket_jenis=='Anti'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '16' ";	
			};
			
			if($apaket_jenis=='Surgery'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '4' ";	
			};
			
			if($apaket_tgl_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') >= '$apaket_tgl_faktur'";
			};
			if($apaket_tgl_faktur_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') <= '$apaket_tgl_faktur_akhir'";
			};
			/*search berdasarkan transaksi customer*/			
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id IN($string)";
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id NOT IN($string_not)";
			}
			
			if($apaket_sortby == ''){
				$query .= " ORDER BY jpaket_nobukti DESC";
			} else {
				$query .= " ORDER BY $apaket_sortby ASC";
			};
			
			//$query .= " ORDER BY jpaket_nobukti DESC";

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
		
		//function for create new record
		function ambil_paket_phonegroup_create($apaket_faktur, $apaket_cust, $apaket_paket, $apaket_kadaluarsa, $apaket_kadaluarsa_akhir, $apaket_tgl_faktur, $apaket_tgl_faktur_akhir, $apaket_sisa, $apaket_jenis, $apaket_jenis_kadaluarsa,$apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end, $hapus_cust,$option,$filter,$phonegroup_id){
			$datetime_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			if($hapus_cust == 1){
				$query_delete = "DELETE FROM phonegrouped WHERE phonegrouped_group = '$phonegroup_id'";
				$this->db->query($query_delete);
			}
			
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_transaksi_start."' AND '".$apaket_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_tidak_transaksi_start."' AND '".$apaket_tidak_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}
			
			
			$query = "SELECT cust_id,
						cust_no AS no_cust
						,cust_nama AS customer
						,jpaket_tanggal AS tanggal_faktur
						,jpaket_nobukti AS no_faktur
						,paket_kode AS kode_paket
						,paket_nama AS nama_paket
						,dpaket_sisa_paket AS sisa
						,dpaket_kadaluarsa AS tgl_kadaluarsa
					FROM detail_jual_paket 
					LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
					LEFT JOIN customer ON(jpaket_cust=cust_id) 
					LEFT JOIN paket ON(dpaket_paket=paket_id) 
					WHERE date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')
						AND jpaket_stat_dok='Tertutup' ";

			if($option=='LIST'){		
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " dpaket_sisa_paket > 0
						AND (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR paket_kode LIKE '%".addslashes($filter)."%' OR paket_nama LIKE '%".addslashes($filter)."%' OR jpaket_nobukti LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($apaket_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_nobukti LIKE '%".$apaket_faktur."%'";
			};
			if($apaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id = '".$apaket_cust."'";
			};
			if($apaket_paket!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_id = '".$apaket_paket."'";
			};
			
			if($apaket_sisa=='1'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket > 0 ";	
			};
			
			if($apaket_sisa=='Sisa 0'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket = 0 ";	
			};
			
			if($apaket_kadaluarsa!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$apaket_kadaluarsa'";
			};
			if($apaket_kadaluarsa_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') <= '$apaket_kadaluarsa_akhir'";
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif&Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')";	
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$date' ";	
			};
			
			if($apaket_jenis_kadaluarsa=='Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa between date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) and date_format(now(),'%Y-%m-%d'))";	
			};
			
			if($apaket_jenis_kadaluarsa=='Hangus'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) )";	
			};
			
			if($apaket_jenis=='Medis'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '2' ";	
			};
			
			if($apaket_jenis=='Non'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '3' ";	
			};
			
			if($apaket_jenis=='Anti'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '16' ";	
			};
			
			if($apaket_jenis=='Surgery'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '4' ";	
			};
			
			if($apaket_tgl_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') >= '$apaket_tgl_faktur'";
			};
			if($apaket_tgl_faktur_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') <= '$apaket_tgl_faktur_akhir'";
			};
			
			/*search berdasarkan transaksi customer*/			
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id IN($string)";
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id NOT IN($string_not)";
			}
			$query .= " ORDER BY jpaket_nobukti DESC";
			
			}
				$result = $this->db->query($query);
				$rs = $this->db->query($query);
				//$datetime_now = date('Y-m-d H:i:s');
				
				$ret = 0;
				$jum_baris = $rs->num_rows();
				
				for ($i = 0; $i < $jum_baris; $i++) {
						$record = $rs->row($i);
						$data_arr= $record->cust_id;				
						
						$data=array(
							"phonegrouped_group"	=> $phonegroup_id,
							"phonegrouped_cust"		=> $data_arr
						);
						
						$query2 = "SELECT phonegrouped_cust FROM phonegrouped WHERE phonegrouped_group = '".$phonegroup_id."' AND phonegrouped_cust='".$data_arr."'";
						
						$result2=$this->db->query($query2);
						$jum_baris2 = $result2->num_rows();
						if ($jum_baris2 <= 0){
							$this->db->insert('phonegrouped',$data);
							$ret = 1;
						}
				}
			if ($ret == 1)
				return '1';
			else
				return '0';
		}
		
		//function for print record
		function ambil_paket_print($apaket_faktur
									,$apaket_cust
									,$apaket_paket
									,$apaket_kadaluarsa
									,$apaket_kadaluarsa_akhir
									,$apaket_tgl_faktur
									,$apaket_tgl_faktur_akhir
									,$apaket_sisa
									, $apaket_jenis
									,$apaket_jenis_kadaluarsa
									,$apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end
									,$option
									,$filter){
									
			$datetime_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			
			/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_transaksi_start."' AND '".$apaket_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_tidak_transaksi_start."' AND '".$apaket_tidak_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}
			
			//full query
			if($option=='LIST'){
				$query = "SELECT cust_no AS no_cust
						,cust_nama AS customer
						,date_format(jpaket_tanggal,'%d-%m-%Y') AS tanggal_faktur    
						,jpaket_nobukti AS no_faktur
						,paket_kode AS kode_paket
						,paket_nama AS nama_paket
						,dpaket_sisa_paket AS sisa
						,date_format(dpaket_kadaluarsa,'%d-%m-%Y')  AS tgl_kadaluarsa
					FROM detail_jual_paket 
					LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
					LEFT JOIN customer ON(jpaket_cust=cust_id) 
					LEFT JOIN paket ON(dpaket_paket=paket_id) 
					WHERE dpaket_sisa_paket > 0
						AND date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')
						AND jpaket_stat_dok='Tertutup' ";	
						
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%'
					OR cust_no LIKE '%".addslashes($filter)."%'
					OR paket_kode LIKE '%".addslashes($filter)."%'
					OR paket_nama LIKE '%".addslashes($filter)."%'
					OR jpaket_nobukti LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				$query = "SELECT cust_no AS no_cust
						,cust_nama AS customer
						,jpaket_tanggal AS tanggal_faktur
						,jpaket_nobukti AS no_faktur
						,paket_kode AS kode_paket
						,paket_nama AS nama_paket
						,dpaket_sisa_paket AS sisa
						,dpaket_kadaluarsa AS tgl_kadaluarsa
					FROM detail_jual_paket 
					LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
					LEFT JOIN customer ON(jpaket_cust=cust_id) 
					LEFT JOIN paket ON(dpaket_paket=paket_id)
					WHERE jpaket_stat_dok='Tertutup'";
					
				if($apaket_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jpaket_nobukti LIKE '%".$apaket_faktur."%'";
			};
			if($apaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id = '".$apaket_cust."'";
			};
			if($apaket_paket!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_id = '".$apaket_paket."'";
			};
			
			if($apaket_sisa=='1'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket > 0 ";	
			};
			
			if($apaket_sisa=='Sisa 0'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " detail_jual_paket.dpaket_sisa_paket = 0 ";	
			};
			
			if($apaket_kadaluarsa!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$apaket_kadaluarsa'";
			};
			if($apaket_kadaluarsa_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') <= '$apaket_kadaluarsa_akhir'";
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif&Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')";	
			};
			
			if($apaket_jenis_kadaluarsa=='Aktif'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$date' ";	
			};
			
			if($apaket_jenis_kadaluarsa=='Tenggang'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa between date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) and date_format(now(),'%Y-%m-%d'))";	
			};
			
			if($apaket_jenis_kadaluarsa=='Hangus'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) )";	
			};
			
			if($apaket_jenis=='Medis'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '2' ";	
			};
			
			if($apaket_jenis=='Non'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '3' ";	
			};
			
			if($apaket_jenis=='Anti'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '16' ";	
			};
			
			if($apaket_jenis=='Surgery'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " paket_kategori = '4' ";	
			};
				
			if($apaket_tgl_faktur!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') >= '$apaket_tgl_faktur'";
			};
			if($apaket_tgl_faktur_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') <= '$apaket_tgl_faktur_akhir'";
			};
			/*search berdasarkan transaksi customer*/			
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id IN($string)";
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!='')
			{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id NOT IN($string_not)";
			}
			$query .= " ORDER BY jpaket_nobukti DESC";
			$result = $this->db->query($query);
			}
				return $result->result();
		}
		
		//function  for print
		function daftar_ambil_paket_print($rawat_nama ,$dapaket_jumlah,$tgl_ambil,$referal,$keterangan,$dapaket_stat_dok,$cust_nama,$option,$filter,$dapaket_dpaket){
		
			//full query
			$query = "SELECT apaket_faktur,apaket_faktur_tanggal,apaket_cust_no,apaket_paket_nama,date_format(dapaket_tgl_ambil,'%d-%m-%Y') AS tanggal_ambil
					,cust_no as client_card
					,cust_nama as customer
					,rawat_nama as perawatan
					,dapaket_jumlah as jumlah
					,IF((isnull(terapis.karyawan_username) AND isnull(dokter.karyawan_username)),referal.karyawan_username,IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username)) AS referal
					,dapaket_keterangan as keterangan
					,dapaket_stat_dok as status
				FROM detail_ambil_paket
				LEFT JOIN perawatan ON(dapaket_item=rawat_id)
				LEFT JOIN customer ON(dapaket_cust=cust_id)
				LEFT JOIN tindakan_detail ON(dapaket_dtrawat=dtrawat_id)
				LEFT JOIN vu_karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
                LEFT JOIN vu_karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
				LEFT JOIN vu_karyawan AS referal ON(dapaket_referal=referal.karyawan_id)
				LEFT JOIN master_ambil_paket on (dapaket_paket=apaket_id)
				WHERE dapaket_dpaket='$dapaket_dpaket'
				ORDER BY dapaket_tgl_ambil DESC";
				
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function ambil_paket_export_excel($apaket_faktur
										,$apaket_cust
										,$apaket_paket
										,$apaket_kadaluarsa
										,$apaket_kadaluarsa_akhir
										,$apaket_tgl_faktur
										,$apaket_tgl_faktur_akhir
										,$apaket_jenis
										,$apaket_jenis_kadaluarsa
										,$apaket_sisa,$apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end
										,$option
										,$filter){
			$datetime_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			
				/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($apaket_transaksi_start!='' and $apaket_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_transaksi_start."' and '".$apaket_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_transaksi_start."' AND '".$apaket_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."') order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$apaket_tidak_transaksi_start."' and '".$apaket_tidak_transaksi_end."')
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal BETWEEN '".$apaket_tidak_transaksi_start."' AND '".$apaket_tidak_transaksi_end."' AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}
			
			//full query
			$query = "SELECT 
						cust_no as no_cust
						,cust_nama as customer
						,jpaket_tanggal as tanggal_faktur
						,jpaket_nobukti as no_faktur
						,paket_kode as kode_paket
						,paket_nama as nama_paket
						,dpaket_sisa_paket as sisa
						,dpaket_kadaluarsa as tgl_kadaluarsa
					FROM detail_jual_paket 
					LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
					LEFT JOIN customer ON(jpaket_cust=cust_id) 
					LEFT JOIN paket ON(dpaket_paket=paket_id) 
					WHERE jpaket_stat_dok='Tertutup' ";
						
			if($option=='LIST'){	
				$query .= " AND dpaket_sisa_paket > 0
							AND date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR paket_kode LIKE '%".addslashes($filter)."%' OR paket_nama LIKE '%".addslashes($filter)."%' OR jpaket_nobukti LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($apaket_faktur!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " jpaket_nobukti LIKE '%".$apaket_faktur."%'";
				};
				if($apaket_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id = '".$apaket_cust."'";
				};
				if($apaket_paket!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " paket_id = '".$apaket_paket."'";
				};
				
				if($apaket_sisa=='1'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " detail_jual_paket.dpaket_sisa_paket > 0 ";	
				};
				
				if($apaket_sisa=='Sisa 0'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " detail_jual_paket.dpaket_sisa_paket = 0 ";	
				};
				
				if($apaket_kadaluarsa!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$apaket_kadaluarsa'";
				};
				if($apaket_kadaluarsa_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') <= '$apaket_kadaluarsa_akhir'";
				};
				
				if($apaket_jenis_kadaluarsa=='Aktif&Tenggang'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) >= date_format(now(),'%Y-%m-%d')";	
				};
				
				if($apaket_jenis_kadaluarsa=='Aktif'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(dpaket_kadaluarsa,'%Y-%m-%d') >= '$date' ";	
				};
				
				if($apaket_jenis_kadaluarsa=='Tenggang'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (detail_jual_paket.dpaket_kadaluarsa between date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) and date_format(now(),'%Y-%m-%d'))";	
				};
				
				if($apaket_jenis_kadaluarsa=='Hangus'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY) )";	
				};
			
				if($apaket_jenis=='Medis'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " paket_kategori = '2' ";	
				};
				
				if($apaket_jenis=='Non'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " paket_kategori = '3' ";	
				};
				
				if($apaket_jenis=='Anti'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " paket_kategori = '16' ";	
				};
				
				if($apaket_jenis=='Surgery'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " paket_kategori = '4' ";	
				};
				
				if($apaket_tgl_faktur!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') >= '$apaket_tgl_faktur'";
				};
				if($apaket_tgl_faktur_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(jpaket_tanggal,'%Y-%m-%d') <= '$apaket_tgl_faktur_akhir'";
				};	
				/*search berdasarkan transaksi customer*/			
				if($apaket_transaksi_start!='' and $apaket_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id IN($string)";
				}
				if($apaket_tidak_transaksi_start!='' and $apaket_tidak_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id NOT IN($string_not)";
				}
				$query .= " ORDER BY jpaket_nobukti DESC";				
			}
			
			$result = $this->db->query($query);
			return $result;
		}
		
		//function  for export to excel
		function daftar_ambil_paket_export_excel($rawat_nama ,$dapaket_jumlah,$tgl_ambil,$referal,$keterangan,$dapaket_stat_dok,$cust_nama,$option,$filter,$dapaket_dpaket){
		
			//full query
			$query = "SELECT dapaket_tgl_ambil AS tanggal_ambil
					,rawat_nama as perawatan
					,dapaket_jumlah as jumlah
					,cust_no as client_card
					,cust_nama as customer
					,IF((isnull(terapis.karyawan_username) AND isnull(dokter.karyawan_username)),referal.karyawan_username,IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username)) AS referal
					,dapaket_keterangan as keterangan
					,dapaket_stat_dok as status
				FROM detail_ambil_paket
				LEFT JOIN perawatan ON(dapaket_item=rawat_id)
				LEFT JOIN customer ON(dapaket_cust=cust_id)
				LEFT JOIN tindakan_detail ON(dapaket_dtrawat=dtrawat_id)
				LEFT JOIN vu_karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
                LEFT JOIN vu_karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
				LEFT JOIN vu_karyawan AS referal ON(dapaket_referal=referal.karyawan_id)
				WHERE dapaket_dpaket='$dapaket_dpaket'
				ORDER BY dapaket_tgl_ambil DESC";
				
			$result = $this->db->query($query);
			return $result;
		}
}
?>