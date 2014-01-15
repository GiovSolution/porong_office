<? /* 	
	+ Description	: For record model process back-end
	+ Filename 		: c_history_transaksi.php
 	+ creator 		:  Freddy
*/

class M_history_transaksi extends Model{
		
		//constructor
		function M_history_transaksi() {
			parent::Model();
		}
		
		
		function history_transaksi_list($cust_id, $tanggal_start,$tanggal_end,$jenis,$query,$start,$end){
		
			//full query
			if ($jenis == '')
				$jenis = 'Semua';
			
			if ($jenis == 'Perawatan')
			{
				$query = "SELECT customer.cust_id, customer.cust_no, customer.cust_nama,
								master_jual_rawat.jrawat_nobukti AS no_bukti, master_jual_rawat.jrawat_tanggal AS tanggal_transaksi, master_jual_rawat.jrawat_stat_dok,
								detail_jual_rawat.drawat_jumlah AS jumlah_transaksi,
								IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username) AS referal,
								perawatan.rawat_kode AS kode_transaksi, perawatan.rawat_nama,
								concat('Penjualan Perawatan ', perawatan.rawat_nama) as keterangan
						FROM detail_jual_rawat
						LEFT OUTER JOIN master_jual_rawat ON master_jual_rawat.jrawat_id = detail_jual_rawat.drawat_master
						LEFT OUTER JOIN customer ON master_jual_rawat.jrawat_cust = customer.cust_id
						LEFT OUTER JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
						LEFT OUTER JOIN tindakan_detail ON detail_jual_rawat.drawat_dtrawat = tindakan_detail.dtrawat_id
						LEFT JOIN karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
               			LEFT JOIN karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)";
			
				if($cust_id!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_rawat.jrawat_stat_dok='Tertutup' and master_jual_rawat.jrawat_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
			
				if($tanggal_start!='' && $tanggal_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_rawat.jrawat_stat_dok='Tertutup' and master_jual_rawat.jrawat_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				}else if($tanggal_start!='' && $tanggal_end=='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_rawat.jrawat_stat_dok='Tertutup' and master_jual_rawat.jrawat_tanggal='".$tanggal_start."''";
				}	
				// union dengan table history_transaksi
				$query.="
						UNION
						select 
							history_transaksi.thistory_cust,
							history_transaksi.thistory_kode_cust,
							customer.cust_nama,
							history_transaksi.thistory_nobukti,
							history_transaksi.thistory_tanggal,
							'Tertutup' AS stat_dok,
							history_transaksi.thistory_jumlah,
							'NA' AS referal,
							history_transaksi.thistory_kode,
							'NA' AS rawat_nama,
							history_transaksi.thistory_keterangan
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust";
				if($cust_id!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE history_transaksi.thistory_jenis='perawatan' and customer.cust_id = '".$cust_id."' and history_transaksi.thistory_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
				//$query.=" GROUP BY master_jual_rawat.jrawat_cust ORDER BY SUM(master_jual_rawat.jrawat_bayar) DESC";
			}

			else if ($jenis == 'Produk')
			{
				$query = "SELECT customer.cust_id, customer.cust_no, customer.cust_nama,
								master_jual_produk.jproduk_nobukti AS no_bukti, master_jual_produk.jproduk_tanggal AS tanggal_transaksi, master_jual_produk.jproduk_stat_dok,
								detail_jual_produk.dproduk_jumlah as jumlah_transaksi, detail_jual_produk.dproduk_karyawan,
								karyawan.karyawan_username as referal,
								produk.produk_kode AS kode_transaksi, produk.produk_nama,
								concat('Penjualan Produk ', produk.produk_nama) as keterangan
						FROM detail_jual_produk
						LEFT OUTER JOIN master_jual_produk ON master_jual_produk.jproduk_id = detail_jual_produk.dproduk_master
						LEFT OUTER JOIN customer ON master_jual_produk.jproduk_cust = customer.cust_id
						LEFT OUTER JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id
						LEFT OUTER JOIN karyawan ON detail_jual_produk.dproduk_karyawan = karyawan_id
						";
			
				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_produk.jproduk_stat_dok = 'Tertutup' and master_jual_produk.jproduk_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
			
				if($tanggal_start!='' && $tanggal_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_produk.jproduk_stat_dok = 'Tertutup' and master_jual_produk.jproduk_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				}else if($tanggal_start!='' && $tanggal_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_produk.jproduk_stat_dok = 'Tertutup' and master_jual_produk.jproduk_tanggal='".$tanggal_start."'";
				}
				// union dengan table history_transaksi
				$query.="UNION
						select 
							history_transaksi.thistory_cust,
							history_transaksi.thistory_kode_cust,
							customer.cust_nama,
							history_transaksi.thistory_nobukti,
							history_transaksi.thistory_tanggal,
							'Tertutup' AS stat_dok,
							history_transaksi.thistory_jumlah,
							'NA' AS karyawan,
							'NA' AS referal,
							history_transaksi.thistory_kode,
							'NA' AS rawat_nama,
							history_transaksi.thistory_keterangan
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust";
				if($cust_id!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE history_transaksi.thistory_jenis='produk' and customer.cust_id = '".$cust_id."' and history_transaksi.thistory_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
				
				/*
				if($tanggal_start!='' && $tanggal_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and temp_history_transaksi.stat_dok = 'Tertutup' and temp_history_transaksi.thistory_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				}else if($tanggal_start!='' && $tanggal_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and temp_history_transaksi.stat_dok = 'Tertutup' and temp_history_transaksi.thistory_tanggal='".$tanggal_start."'";
				}
				*/
				
				//$query.=" GROUP BY master_jual_produk.jproduk_cust";
			}
			else if ($jenis == 'Paket')
			{
				$query = "SELECT customer.cust_id, customer.cust_no, customer.cust_nama,
								master_jual_paket.jpaket_nobukti AS no_bukti, master_jual_paket.jpaket_tanggal AS tanggal_transaksi, master_jual_paket.jpaket_stat_dok,
								detail_jual_paket.dpaket_jumlah as jumlah_transaksi, detail_jual_paket.dpaket_karyawan,
								karyawan.karyawan_username as referal,
								paket.paket_kode, paket.paket_nama,
								concat('Penjualan Paket ', paket.paket_nama) as keterangan
						FROM detail_jual_paket
						LEFT OUTER JOIN master_jual_paket ON master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master
						LEFT OUTER JOIN customer ON master_jual_paket.jpaket_cust = customer.cust_id
						LEFT OUTER JOIN paket ON detail_jual_paket.dpaket_paket = paket.paket_id
						LEFT OUTER JOIN karyawan ON detail_jual_paket.dpaket_karyawan = karyawan_id";
			
				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_paket.jpaket_stat_dok = 'Tertutup' and master_jual_paket.jpaket_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
			
				if($tanggal_start!='' && $tanggal_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_paket.jpaket_stat_dok = 'Tertutup' and master_jual_paket.jpaket_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				}else if($tanggal_start!='' && $tanggal_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and master_jual_paket.jpaket_stat_dok = 'Tertutup' and master_jual_paket.jpaket_tanggal='".$tanggal_start."'";
				}
				//$query.=" GROUP BY master_jual_paket.jpaket_cust ORDER BY SUM(master_jual_paket.jpaket_bayar) DESC";
			}
			
			else if ($jenis == 'Pengambilan Paket')
			{
				$query = "SELECT
								customer.cust_nama,
								master_jual_paket.jpaket_nobukti as no_bukti,
								detail_ambil_paket.dapaket_jumlah as jumlah_transaksi, detail_ambil_paket.dapaket_tgl_ambil AS tanggal_transaksi,
								perawatan.rawat_kode as kode_transaksi,
								karyawan.karyawan_username as referal,
								concat('Pengambilan Paket ', perawatan.rawat_nama) as keterangan
						FROM detail_ambil_paket
						LEFT OUTER JOIN master_jual_paket ON master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket
						LEFT OUTER JOIN perawatan ON detail_ambil_paket.dapaket_item = perawatan.rawat_id
						LEFT OUTER JOIN karyawan ON detail_ambil_paket.dapaket_referal = karyawan.karyawan_id
						LEFT OUTER JOIN customer ON detail_ambil_paket.dapaket_cust = customer.cust_id";
			
				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and (detail_ambil_paket.dapaket_stat_dok = 'Tertutup' or detail_ambil_paket.dapaket_stat_dok = 'Terbuka') and detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
			
				if($tanggal_start!='' && $tanggal_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and (detail_ambil_paket.dapaket_stat_dok = 'Tertutup' or detail_ambil_paket.dapaket_stat_dok = 'Terbuka') and detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				}else if($tanggal_start!='' && $tanggal_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " customer.cust_id = '".$cust_id."' and (detail_ambil_paket.dapaket_stat_dok = 'Tertutup' or detail_ambil_paket.dapaket_stat_dok = 'Terbuka') and detail_ambil_paket.dapaket_tgl_ambil ='".$tanggal_start."'";
				}
				// union dengan table history_transaksi
				$query.="
							UNION
						select 
							customer.cust_nama,
							history_transaksi.thistory_nobukti,
							history_transaksi.thistory_jumlah,
							history_transaksi.thistory_tanggal,	
							history_transaksi.thistory_kode,
							'NA' AS referal,
							history_transaksi.thistory_keterangan
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust";
				if($cust_id!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE history_transaksi.thistory_jenis='ambil paket' and customer.cust_id = '".$cust_id."' and history_transaksi.thistory_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
				};
				//$query.=" GROUP BY master_jual_paket.jpaket_cust ORDER BY SUM(master_jual_paket.jpaket_bayar) DESC";
			}
			
			
			else if ($jenis == 'Semua')
			{
				$query = "(
SELECT 							master_jual_rawat.jrawat_nobukti AS no_bukti, 
								master_jual_rawat.jrawat_tanggal AS tanggal_transaksi,
								detail_jual_rawat.drawat_jumlah AS jumlah_transaksi,
								IF((dtrawat_petugas1=0),IF((dtrawat_petugas2=0),NULL,terapis.karyawan_username),dokter.karyawan_username) AS referal,
								perawatan.rawat_kode AS kode_transaksi,
								concat('Penjualan Perawatan ', perawatan.rawat_nama) as keterangan
						FROM detail_jual_rawat
						LEFT OUTER JOIN master_jual_rawat ON master_jual_rawat.jrawat_id = detail_jual_rawat.drawat_master
						LEFT OUTER JOIN customer ON master_jual_rawat.jrawat_cust = customer.cust_id
						LEFT OUTER JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
						LEFT OUTER JOIN tindakan_detail ON detail_jual_rawat.drawat_dtrawat = tindakan_detail.dtrawat_id
						LEFT JOIN karyawan AS dokter ON(dtrawat_petugas1=dokter.karyawan_id)
               			LEFT JOIN karyawan AS terapis ON(dtrawat_petugas2=terapis.karyawan_id)
						where customer.cust_id = '".$cust_id."' and master_jual_rawat.jrawat_stat_dok='Tertutup' and master_jual_rawat.jrawat_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'
)
UNION
(
SELECT 							master_jual_produk.jproduk_nobukti AS no_bukti, 
								master_jual_produk.jproduk_tanggal AS tanggal_transaksi,
								detail_jual_produk.dproduk_jumlah as jumlah_transaksi,
								karyawan.karyawan_username as referal,
								produk.produk_kode AS kode_transaksi,
								concat('Penjualan Produk ', produk.produk_nama) as keterangan
						FROM detail_jual_produk
						LEFT OUTER JOIN master_jual_produk ON master_jual_produk.jproduk_id = detail_jual_produk.dproduk_master
						LEFT OUTER JOIN customer ON master_jual_produk.jproduk_cust = customer.cust_id
						LEFT OUTER JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id
						LEFT OUTER JOIN karyawan ON detail_jual_produk.dproduk_karyawan = karyawan_id
						where customer.cust_id = '".$cust_id."' and master_jual_produk.jproduk_stat_dok = 'Tertutup' and master_jual_produk.jproduk_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'
)
UNION
(
SELECT 							master_jual_paket.jpaket_nobukti AS no_bukti, 
								master_jual_paket.jpaket_tanggal AS tanggal_transaksi,
								detail_jual_paket.dpaket_jumlah as jumlah_transaksi,
								karyawan.karyawan_username as referal,
								paket.paket_kode,
								concat('Penjualan Paket ', paket.paket_nama) as keterangan
						FROM detail_jual_paket
						LEFT OUTER JOIN master_jual_paket ON master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master
						LEFT OUTER JOIN customer ON master_jual_paket.jpaket_cust = customer.cust_id
						LEFT OUTER JOIN paket ON detail_jual_paket.dpaket_paket = paket.paket_id
						LEFT OUTER JOIN karyawan ON detail_jual_paket.dpaket_karyawan = karyawan_id
						where customer.cust_id = '".$cust_id."' and master_jual_paket.jpaket_stat_dok = 'Tertutup' and master_jual_paket.jpaket_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'
)
UNION
(
SELECT 							master_jual_paket.jpaket_nobukti as no_bukti,
								detail_ambil_paket.dapaket_tgl_ambil AS tanggal_transaksi,
								detail_ambil_paket.dapaket_jumlah as jumlah_transaksi, 
								karyawan.karyawan_username as referal,
								perawatan.rawat_kode as kode_transaksi,
								concat('Pengambilan Paket ', perawatan.rawat_nama) as keterangan
						FROM detail_ambil_paket
						LEFT OUTER JOIN master_jual_paket ON master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket
						LEFT OUTER JOIN perawatan ON detail_ambil_paket.dapaket_item = perawatan.rawat_id
						LEFT OUTER JOIN karyawan ON detail_ambil_paket.dapaket_referal = karyawan.karyawan_id
						LEFT OUTER JOIN customer ON detail_ambil_paket.dapaket_cust = customer.cust_id
						where customer.cust_id = '".$cust_id."' and (detail_ambil_paket.dapaket_stat_dok = 'Tertutup' or detail_ambil_paket.dapaket_stat_dok = 'Terbuka') and detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'
)
UNION
(
						select 
							history_transaksi.thistory_nobukti,
							history_transaksi.thistory_tanggal,
							history_transaksi.thistory_jumlah,
							'NA' AS referal,
							history_transaksi.thistory_kode,
							history_transaksi.thistory_keterangan
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust
						WHERE customer.cust_id = '".$cust_id."' and history_transaksi.thistory_tanggal BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'
)
order by tanggal_transaksi

";
		
			}
			//$start = 0;
			//$end = $top_jumlah;
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
		
		
		
		//function for print record
		function kartu_stok_print($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from kartu_stok";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR satuan_id LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR stok_saldo LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_nama!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($satuan_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_nama!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($stok_saldo!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " stok_saldo LIKE '%".$stok_saldo."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function kartu_stok_export_excel($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from kartu_stok";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR satuan_id LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR stok_saldo LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($satuan_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($stok_saldo!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " stok_saldo LIKE '%".$stok_saldo."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>