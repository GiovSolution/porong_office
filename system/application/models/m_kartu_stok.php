<? /* 	

	GIOV Solution - Keep IT Simple
*/

class M_kartu_stok extends Model{

		//constructor
		function M_kartu_stok() {
			parent::Model();
		}

		var $stok_awal=0;
		var $stok_masuk=0;
		var $stok_keluar=0;
		var $stok_koreksi=0;
		var $stok_akhir=0;

		function get_produk_list($filter,$start,$end){
			$sql="select * from vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			if($filter<>""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="( produk_kode LIKE '%".addslashes($filter)."%' OR
						 produk_nama LIKE '%".addslashes($filter)."%' OR
						 satuan_kode LIKE '%".addslashes($filter)."%' OR
						 satuan_nama LIKE '%".addslashes($filter)."%')";
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

		function kartu_stok_awal($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$filter,$start,$end){
			if ($periode == 'bulan'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' and date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m-%d') < date_format('".$tanggal_start."','%Y-%m-%d')";
			}
			
			// CEK SATUAN
			if($opsi_satuan=='terkecil')
			{
				$sql="SELECT konversi_satuan FROM satuan_konversi
						WHERE konversi_nilai=1
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=1;
				}else{
					return 0;
					exit();
				}

			}else{

				$sql="SELECT konversi_satuan, konversi_nilai FROM satuan_konversi
						WHERE konversi_default=true
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=$row->konversi_nilai;
				}else{
					return 0;
					exit();
				}

			}
			// EOF CEK SATUAN

			$sql="
			SELECT 
				IFNULL(SUM(ks_satuan_nilai/".$current_konversi." * ks_masuk) - SUM(ks_satuan_nilai/".$current_konversi." * ks_keluar),0) as stok_awal
			FROM kartu_stok_fix
			WHERE 
				ks_gudang_id='".$gudang."' AND
				kartu_stok_fix.ks_produk_id = '".$produk_id."'
				".$isiperiode."";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			//printf($nbrows);
			
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

		function stok_resume($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end){
			if ($periode == 'bulan'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' and date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m-%d') BETWEEN date_format('".$tanggal_start."','%Y-%m-%d') AND 
								date_format('".$tanggal_end."','%Y-%m-%d') ";
			}
			
			// CEK SATUAN
			if($opsi_satuan=='terkecil')
			{
				$sql="SELECT konversi_satuan FROM satuan_konversi
						WHERE konversi_nilai=1
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=1;
				}else{
					return 0;
					exit();
				}

			}else{

				$sql="SELECT konversi_satuan, konversi_nilai FROM satuan_konversi
						WHERE konversi_default=true
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=$row->konversi_nilai;
				}else{
					return 0;
					exit();
				}

			}
			// EOF CEK SATUAN
			$sql="
			SELECT 
				SUM(ks_satuan_nilai/".$current_konversi." * ks_masuk) as masuk,
				SUM(ks_satuan_nilai/".$current_konversi." * ks_keluar) as keluar
			FROM kartu_stok_fix
			WHERE 
				ks_gudang_id='".$gudang."' AND
				kartu_stok_fix.ks_produk_id = '".$produk_id."'
				".$isiperiode."";

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

		function kartu_stok_awal_print($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$filter,$start,$end){
			if ($periode == 'bulan'){
				$isiperiode="'%Y-%m')<'".$tgl_awal."' ";

			}else if($periode == 'tanggal'){
				$isiperiode="'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d') ";
			}
		
			if($opsi_satuan=='terkecil')
				$sql="SELECT * FROM vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			else
				$sql="SELECT * FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";

			$this->stok_awal=0;

			if($produk_id!==""&&$produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_id='".$produk_id."' ";
			}

			if($filter!==""&&$filter!==NULL){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_kode LIKE '%".addslashes($filter)."%' OR
						produk_nama LIKE '%".addslashes($filter)."%' ";
			}

			$sql.=" LIMIT 1";

			$data[0]["stok_awal"]=0;

			$result=$this->db->query($sql);
			$nbrows=$result->num_rows();
			//$this->firephp->log('sql : '.$sql);

			if($nbrows>0){
				$rowproduk=$result->row();
				if($opsi_satuan=='terkecil')
					$konversi=1;
				else
					$konversi=1/$rowproduk->konversi_nilai;

				$i=0;

				//Stok Saldo Awal
				$sqlawal="SELECT 	produk_saldo_awal*konversi_nilai/".$rowproduk->konversi_nilai." as jumlah
						FROM 	produk, satuan_konversi
						WHERE 	konversi_produk=produk_id
						AND 	konversi_default=true
						AND		produk_id='".$produk_id."'";
				$rsawal=$this->db->query($sqlawal);
				if($rsawal->num_rows()){
					$row=$rsawal->row();
					$data[0]["stok_awal"]=$row->jumlah;
				}

				//STOK AWAL
				$sql_stok_awal="SELECT ifnull(
								sum(jml_mutasi_masuk*konversi_nilai/".$rowproduk->konversi_nilai.")
								+ sum(jml_koreksi_stok*konversi_nilai/".$rowproduk->konversi_nilai.")
								- sum(jml_mutasi_keluar*konversi_nilai/".$rowproduk->konversi_nilai.")
								+ sum(jml_terima_barang*konversi_nilai/".$rowproduk->konversi_nilai.")
								+ sum(jml_terima_bonus*konversi_nilai/".$rowproduk->konversi_nilai.")";

				if($gudang==1){
					//GUDANG UTAMA
					$sql_stok_awal.="- sum(jml_retur_beli*konversi_nilai/".$rowproduk->konversi_nilai.")";
				}elseif($gudang==4 || $gudang==3){
					//GUDANG PERAWATAN
					$sql_stok_awal.="- sum(jml_pakai_cabin*konversi_nilai/".$rowproduk->konversi_nilai.")";
				}elseif($gudang==2){
					//GUDANG RETAIL
					$sql_stok_awal.="-sum(jml_jual_produk*konversi_nilai/".$rowproduk->konversi_nilai.")
									-sum(jml_jual_grooming*konversi_nilai/".$rowproduk->konversi_nilai.")
									+sum(jml_retur_produk*konversi_nilai/".$rowproduk->konversi_nilai.")
									+sum(jml_retur_paket*konversi_nilai/".$rowproduk->konversi_nilai.")";
				}

				$sql_stok_awal.=" ,0) AS jumlah_awal
							FROM (
							  SELECT `mmm`.`mutasi_tanggal` AS `tanggal`,
								   `mmm`.`mutasi_asal` AS `asal`,
								   `mmm`.`mutasi_tujuan` AS `tujuan`,
								   `mmm`.`mutasi_tujuan` AS `gudang`,
								   `mmm`.`mutasi_no` AS `no_bukti`,
								   _UTF8 'mutasi' AS `jenis_transaksi`,
								   `mmm`.`mutasi_status` AS `status`,
								   `dmm`.`dmutasi_produk` AS `produk`,
								   `dmm`.`dmutasi_satuan` AS `satuan`,
								   konversi_nilai,
								   0 AS `jml_terima_barang`,
								   0 AS `jml_terima_bonus`,
								   0 AS `jml_retur_beli`,
								   `dmm`.`dmutasi_jumlah` AS `jml_mutasi_masuk`,
								   0 AS `jml_mutasi_keluar`,
								   0 AS `jml_koreksi_stok`,
								   0 AS `jml_jual_produk`,
								   0 AS `jml_jual_grooming`,
								   0 AS `jml_retur_produk`,
								   0 AS `jml_retur_paket`,
								   0 AS `jml_pakai_cabin`,
								   _UTF8 'mutasi masuk' AS `keterangan`,
								   `dmm`.`dmutasi_id` AS `detail_id`
							  FROM `master_mutasi` `mmm`, `detail_mutasi` `dmm`, satuan_konversi
							 WHERE     `dmm`.`dmutasi_master` = `mmm`.`mutasi_id`
								   AND konversi_satuan = dmm.dmutasi_satuan
								   AND konversi_produk = dmm.dmutasi_produk
									AND date_format(mutasi_tanggal,".$isiperiode."
									AND dmutasi_produk='".$rowproduk->produk_id."'
									AND mutasi_tujuan='".$gudang."'
									AND mutasi_status='Tertutup'
							UNION
							SELECT `mmk`.`mutasi_tanggal` AS `tanggal`,
								   `mmk`.`mutasi_asal` AS `asal`,
								   `mmk`.`mutasi_tujuan` AS `tujuan`,
								   `mmk`.`mutasi_asal` AS `gudang`,
								   `mmk`.`mutasi_no` AS `no_bukti`,
								   _UTF8 'mutasi' AS `jenis_transaksi`,
								   `mmk`.`mutasi_status` AS `status`,
								   `dmk`.`dmutasi_produk` AS `produk`,
								   `dmk`.`dmutasi_satuan` AS `satuan`,
								   konversi_nilai,
								   0 AS `jml_terima_barang`,
								   0 AS `jml_terima_bonus`,
								   0 AS `jml_retur_beli`,
								   0 AS `jml_mutasi_masuk`,
								   `dmk`.`dmutasi_jumlah` AS `jml_mutasi_keluar`,
								   0 AS `jml_koreksi_stok`,
								   0 AS `jml_jual_produk`,
								   0 AS `jml_jual_grooming`,
								   0 AS `jml_retur_produk`,
								   0 AS `jml_retur_paket`,
								   0 AS `jml_pakai_cabin`,
								   _UTF8 'mutasi keluar' AS `keterangan`,
								   `dmk`.`dmutasi_id` AS `detail_id`
							  FROM `master_mutasi` `mmk`, `detail_mutasi` `dmk`, satuan_konversi
							 WHERE     `dmk`.`dmutasi_master` = `mmk`.`mutasi_id`
								   AND konversi_satuan = dmk.dmutasi_satuan
								   AND konversi_produk = dmk.dmutasi_produk
									AND date_format(mutasi_tanggal,".$isiperiode."
									AND dmutasi_produk='".$rowproduk->produk_id."'
									AND mutasi_asal='".$gudang."'
									AND mutasi_status='Tertutup'
							UNION
							SELECT `mk`.`koreksi_tanggal` AS `tanggal`,
								   `mk`.`koreksi_gudang` AS `asal`,
								   `mk`.`koreksi_gudang` AS `tujuan`,
								   `mk`.`koreksi_gudang` AS `gudang`,
								   `mk`.`koreksi_no` AS `no_bukti`,
								   _UTF8 'koreksi' AS `jenis_transaksi`,
								   `mk`.`koreksi_status` AS `status`,
								   `dk`.`dkoreksi_produk` AS `produk`,
								   `dk`.`dkoreksi_satuan` AS `satuan`,
								   konversi_nilai,
								   0 AS `jml_terima_barang`,
								   0 AS `jml_terima_bonus`,
								   0 AS `jml_retur_beli`,
								   0 AS `jml_mutasi_masuk`,
								   0 AS `jml_mutasi_keluar`,
								   `dk`.`dkoreksi_jmlkoreksi` AS `jml_koreksi_stok`,
								   0 AS `jml_jual_produk`,
								   0 AS `jml_jual_grooming`,
								   0 AS `jml_retur_produk`,
								   0 AS `jml_retur_paket`,
								   0 AS `jml_pakai_cabin`,
								   _UTF8 'koreksi' AS `keterangan`,
								   `dk`.`dkoreksi_id` AS `detail_id`
							  FROM `master_koreksi_stok` `mk`,
								   `detail_koreksi_stok` `dk`,
								   satuan_konversi
							 WHERE     `mk`.`koreksi_id` = `dk`.`dkoreksi_master`
								   AND konversi_satuan = dk.dkoreksi_satuan
								   AND konversi_produk = dk.dkoreksi_produk
									AND date_format(koreksi_tanggal,".$isiperiode."
									AND dkoreksi_produk='".$rowproduk->produk_id."'
									AND koreksi_gudang='".$gudang."'
									AND koreksi_status='Tertutup'
							UNION
							SELECT `mt`.`terima_tanggal` AS `tanggal`,
										   `mt`.`terima_supplier` AS `asal`,
										   1 AS `tujuan`,
										   `mt`.`terima_gudang_id` AS `gudang`,
										   `mt`.`terima_no` AS `no_bukti`,
										   _UTF8 'PB' AS `jenis_transaksi`,
										   `mt`.`terima_status` AS `status`,
										   `dt`.`dterima_produk` AS `produk`,
										   `dt`.`dterima_satuan` AS `satuan`,
										   konversi_nilai,
										   `dt`.`dterima_jumlah` AS `jml_terima_barang`,
										   0 AS `jml_terima_bonus`,
										   0 AS `jml_retur_beli`,
										   0 AS `jml_mutasi_masuk`,
										   0 AS `jml_mutasi_keluar`,
										   0 AS `jml_koreksi_stok`,
										   0 AS `jml_jual_produk`,
										   0 AS `jml_jual_grooming`,
										   0 AS `jml_retur_produk`,
										   0 AS `jml_retur_paket`,
										   0 AS `jml_pakai_cabin`,
										   _UTF8 'beli' AS `keterangan`,
										   `dt`.`dterima_id` AS `detail_id`
									  FROM `detail_terima_beli` `dt`, `master_terima_beli` `mt`, satuan_konversi
									 WHERE     `dt`.`dterima_master` = `mt`.`terima_id`
											AND konversi_satuan = dt.dterima_satuan
											AND konversi_produk = dt.dterima_produk
											AND date_format(terima_tanggal,".$isiperiode."
											AND dterima_produk='".$rowproduk->produk_id."'
											AND `mt`.`terima_gudang_id`='".$gudang."'
											AND terima_status='Tertutup'

									UNION
									SELECT `mt`.`terima_tanggal` AS `tanggal`,
										   `mt`.`terima_supplier` AS `asal`,
										   1 AS `tujuan`,
										   `mt`.`terima_gudang_id` AS `gudang`,
										   `mt`.`terima_no` AS `no_bukti`,
										   _UTF8 'PB' AS `jenis_transaksi`,
										   `mt`.`terima_status` AS `status`,
										   `db`.`dtbonus_produk` AS `produk`,
										   `db`.`dtbonus_satuan` AS `satuan`,
										   konversi_nilai,
										   0 AS `jml_terima_barang`,
										   `db`.`dtbonus_jumlah` AS `jml_terima_bonus`,
										   0 AS `jml_retur_beli`,
										   0 AS `jml_mutasi_masuk`,
										   0 AS `jml_mutasi_keluar`,
										   0 AS `jml_koreksi_stok`,
										   0 AS `jml_jual_produk`,
										   0 AS `jml_jual_grooming`,
										   0 AS `jml_retur_produk`,
										   0 AS `jml_retur_paket`,
										   0 AS `jml_pakai_cabin`,
										   _UTF8 'bonus' AS `keterangan`,
										   `db`.`dtbonus_id` AS `detail_id`
									  FROM `detail_terima_bonus` `db`, `master_terima_beli` `mt`, satuan_konversi
									 WHERE     `db`.`dtbonus_master` = `mt`.`terima_id`
											AND konversi_satuan = db.dtbonus_satuan
											AND konversi_produk = db.dtbonus_produk
											AND date_format(terima_tanggal,".$isiperiode."
											AND dtbonus_produk='".$rowproduk->produk_id."'
											AND `mt`.`terima_gudang_id`='".$gudang."'
											AND terima_status='Tertutup'";


				if($gudang==1){
					//GUDANG UTAMA
					$sql_stok_awal.="
									UNION
									SELECT `mr`.`rbeli_tanggal` AS `tanggal`,
										   `mr`.`rbeli_supplier` AS `asal`,
										   1 AS `tujuan`,
										   1 AS `gudang`,
										   `mr`.`rbeli_nobukti` AS `no_bukti`,
										   _UTF8 'RB' AS `jenis_transaksi`,
										   `mr`.`rbeli_status` AS `status`,
										   `dr`.`drbeli_produk` AS `produk`,
										   `dr`.`drbeli_satuan` AS `satuan`,
										   konversi_nilai,
										   0 AS `jml_terima_barang`,
										   0 AS `jml_terima_bonus`,
										   `dr`.`drbeli_jumlah` AS `jml_retur_beli`,
										   0 AS `jml_mutasi_masuk`,
										   0 AS `jml_mutasi_keluar`,
										   0 AS `jml_koreksi_stok`,
										   0 AS `jml_jual_produk`,
										   0 AS `jml_jual_grooming`,
										   0 AS `jml_retur_produk`,
										   0 AS `jml_retur_paket`,
										   0 AS `jml_pakai_cabin`,
										   _UTF8 'retur' AS `keterangan`,
										   `dr`.`drbeli_id` AS `detail_id`
									  FROM `detail_retur_beli` `dr`, `master_retur_beli` `mr`, satuan_konversi
									 WHERE     `dr`.`drbeli_master` = `mr`.`rbeli_id`
										   AND konversi_satuan = dr.drbeli_satuan
										   AND konversi_produk = dr.drbeli_produk
											AND date_format(rbeli_tanggal,".$isiperiode."
											AND drbeli_produk='".$rowproduk->produk_id."'
											AND 1='".$gudang."'
											AND rbeli_status='Tertutup'";

				}elseif($gudang==4 || $gudang==3){
					//GUDANG PERAWATAN
					$sql_stok_awal.=" UNION
									SELECT `cb`.`cabin_date_create` AS `tanggal`,
										   `cb`.`cabin_gudang` AS `asal`,
										   `cb`.`cabin_cust` AS `tujuan`,
										   `cb`.`cabin_gudang` AS `gudang`,
										   `cb`.`cabin_bukti` AS `no_bukti`,
										   _UTF8 'pakai cabin' AS `jenis_transaksi`,
										   _UTF8 'Tertutup' AS `status`,
										   `cb`.`cabin_produk` AS `produk`,
										   `cb`.`cabin_satuan` AS `satuan`,
										   konversi_nilai,
										   0 AS `jml_terima_barang`,
										   0 AS `jml_terima_bonus`,
										   0 AS `jml_retur_beli`,
										   0 AS `jml_mutasi_masuk`,
										   0 AS `jml_mutasi_keluar`,
										   0 AS `jml_koreksi_stok`,
										   0 AS `jml_jual_produk`,
										   0 AS `jml_jual_grooming`,
										   0 AS `jml_retur_produk`,
										   0 AS `jml_retur_paket`,
										   `cb`.`cabin_jumlah` AS `jml_pakai_cabin`,
										   _UTF8 'pakai cabin' AS `keterangan`,
										   `cb`.`cabin_dtrawat` AS `detail_id`
									  FROM `detail_pakai_cabin` `cb`, satuan_konversi
									 WHERE konversi_produk = cabin_produk
											AND konversi_satuan = cabin_satuan
											AND date_format(cabin_date_create,".$isiperiode."
											AND cabin_produk='".$rowproduk->produk_id."'
											AND cabin_gudang='".$gudang."'";
				}elseif($gudang==2){
					//GUDANG RETAIL
					$sql_stok_awal.="UNION
											SELECT `mj`.`jproduk_tanggal` AS `tanggal`,
												   2 AS `asal`,
												   `mj`.`jproduk_cust` AS `tujuan`,
												   2 AS `gudang`,
												   `mj`.`jproduk_nobukti` AS `no_bukti`,
												   _UTF8 'jual produk' AS `jenis_traksaksi`,
												   `mj`.`jproduk_stat_dok` AS `status`,
												   `dj`.`dproduk_produk` AS `produk`,
												   `dj`.`dproduk_satuan` AS `satuan`,
												   konversi_nilai,
												   0 AS `jml_terima_barang`,
												   0 AS `jml_terima_bonus`,
												   0 AS `jml_retur_beli`,
												   0 AS `jml_mutasi_masuk`,
												   0 AS `jml_mutasi_keluar`,
												   0 AS `jml_koreksi_stok`,
												   `dj`.`dproduk_jumlah` AS `jml_jual_produk`,
												   0 AS `jml_jual_grooming`,
												   0 AS `jml_retur_produk`,
												   0 AS `jml_retur_paket`,
												   0 AS `jml_pakai_cabin`,
												   _UTF8 'customer' AS `keterangan`,
												   `dj`.`dproduk_id` AS `detail_id`
											  FROM `master_jual_produk` `mj`, `detail_jual_produk` `dj`, satuan_konversi
											 WHERE     `dj`.`dproduk_master` = `mj`.`jproduk_id`
												   AND konversi_satuan = dj.dproduk_satuan
												   AND konversi_produk = dj.dproduk_produk
													AND date_format(jproduk_tanggal,".$isiperiode."
													AND dproduk_produk='".$rowproduk->produk_id."'
													AND 2='".$gudang."'
													AND jproduk_stat_dok='Tertutup'

											UNION
											SELECT `mjg`.`jpgrooming_tanggal` AS `tanggal`,
												   2 AS `asal`,
												   `mjg`.`jpgrooming_karyawan` AS `tujuan`,
												   2 AS `gudang`,
												   `mjg`.`jpgrooming_nobukti` AS `no_bukti`,
												   _UTF8 'jual produk' AS `jenis_transaksi`,
												   _UTF8 'Tertutup' AS `status`,
												   `djg`.`dpgrooming_produk` AS `produk`,
												   `djg`.`dpgrooming_satuan` AS `satuan`,
												   konversi_nilai,
												   0 AS `jml_terima_barang`,
												   0 AS `jml_terima_bonus`,
												   0 AS `jml_retur_beli`,
												   0 AS `jml_mutasi_masuk`,
												   0 AS `jml_mutasi_keluar`,
												   0 AS `jml_koreksi_stok`,
												   0 AS `jml_jual_produk`,
												   `djg`.`dpgrooming_jumlah` AS `jml_jual_grooming`,
												   0 AS `jml_retur_produk`,
												   0 AS `jml_retur_paket`,
												   0 AS `jml_pakai_cabin`,
												   _UTF8 'grooming' AS `keterangan`,
												   `djg`.`dpgrooming_id` AS `detail_id`
											  FROM `master_jualproduk_grooming` `mjg`,
												   `detail_jualproduk_grooming` `djg`,
												   satuan_konversi
											 WHERE     `mjg`.`jpgrooming_id` = `djg`.`dpgrooming_master`
												   AND konversi_satuan = djg.dpgrooming_satuan
												   AND konversi_produk = djg.dpgrooming_produk
													AND date_format(jpgrooming_tanggal,".$isiperiode."
													AND dpgrooming_produk='".$rowproduk->produk_id."'
													AND 2='".$gudang."'
											UNION
											SELECT `mrj`.`rproduk_tanggal` AS `tanggal`,
												   `mrj`.`rproduk_cust` AS `asal`,
												   2 AS `tujuan`,
												   2 AS `gudang`,
												   `mrj`.`rproduk_nobukti` AS `no_bukti`,
												   _UTF8 'retur jual' AS `jenis_transaksi`,
												   `mrj`.`rproduk_stat_dok` AS `status`,
												   `drj`.`drproduk_produk` AS `produk`,
												   `drj`.`drproduk_satuan` AS `satuan`,
												   konversi_nilai,
												   0 AS `jml_terima_barang`,
												   0 AS `jml_terima_bonus`,
												   0 AS `jml_retur_beli`,
												   0 AS `jml_mutasi_masuk`,
												   0 AS `jml_mutasi_keluar`,
												   0 AS `jml_koreksi_stok`,
												   0 AS `jml_jual_produk`,
												   0 AS `jml_jual_grooming`,
												   `drj`.`drproduk_jumlah` AS `jml_retur_produk`,
												   0 AS `jml_retur_paket`,
												   0 AS `jml_pakai_cabin`,
												   _UTF8 'produk retur' AS `keterangan`,
												   `drj`.`drproduk_id` AS `detail_id`
											  FROM `master_retur_jual_produk` `mrj`,
												   `detail_retur_jual_produk` `drj`,
												   satuan_konversi
											 WHERE     `mrj`.`rproduk_id` = `drj`.`drproduk_master`
												   AND konversi_satuan = drj.drproduk_satuan
												   AND konversi_produk = drj.drproduk_produk
													AND date_format(rproduk_tanggal,".$isiperiode."
													AND drproduk_produk='".$rowproduk->produk_id."'
													AND 2='".$gudang."'
													AND rproduk_stat_dok='Tertutup'
											UNION
											SELECT `mrp`.`rpaket_tanggal` AS `tanggal`,
												   `mrp`.`rpaket_cust` AS `asal`,
												   2 AS `tujuan`,
												   2 AS `gudang`,
												   `mrp`.`rpaket_nobukti` AS `no_bukti`,
												   _UTF8 'retur jual' AS `jenis_transaksi`,
												   `mrp`.`rpaket_stat_dok` AS `status`,
												   `drp`.`drpaket_produk` AS `produk`,
												   `drp`.`drpaket_satuan` AS `satuan`,
												   konversi_nilai,
												   0 AS `jml_terima_barang`,
												   0 AS `jml_terima_bonus`,
												   0 AS `jml_retur_beli`,
												   0 AS `jml_mutasi_masuk`,
												   0 AS `jml_mutasi_keluar`,
												   0 AS `jml_koreksi_stok`,
												   0 AS `jml_jual_produk`,
												   0 AS `jml_jual_grooming`,
												   0 AS `jml_retur_produk`,
												   `drp`.`drpaket_jumlah` AS `jml_retur_paket`,
												   0 AS `jml_pakai_cabin`,
												   _UTF8 'paket retur' AS `keterangan`,
												   `drp`.`drpaket_id` AS `detail_id`
											  FROM `master_retur_jual_paket` `mrp`,
												   `detail_retur_paket_produk` `drp`,
												   satuan_konversi
											 WHERE     `mrp`.`rpaket_id` = `drp`.`drpaket_master`
												   AND konversi_satuan = drpaket_satuan
												   AND konversi_produk = drpaket_produk
													AND date_format(rpaket_tanggal,".$isiperiode."
													AND drpaket_produk='".$rowproduk->produk_id."'
													AND 2='".$gudang."'
													AND rpaket_stat_dok='Tertutup'";
				}

				$sql_stok_awal.= ") as mutasi
									GROUP BY mutasi.produk
									ORDER BY mutasi.produk ";

				//---END OF STOK AWAL

			}

			$result = $this->db->query($sql_stok_awal);
			
			//if($q_stokawal->num_rows()){
			if($nbrows = $result->num_rows()){ //jumlah baris
			$data = $result->row(); //ambil data 1 row
			$jumlah_awal = $data->jumlah_awal;
			}
			if($nbrows>0)
				return $jumlah_awal;
			else
				return NULL;
		}
		
		
		// ubah sistem stok disini
		function generate_kartu_stok($bulan, $tahun, $periode, $gudang, $produk_id, $opsi_satuan, $tanggal_start, $tanggal_end){
			
			/*if ($periode == 'bulan'){
				$isiperiode="'%Y-%m')='".$tgl_awal."'" ;
				$isistart=" AND date_format(tanggal_awal,'%Y-%m')>='".$tgl_awal."'
					AND date_format(tanggal_akhir,'%Y-%m')<='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode="'%Y-%m-%d') BETWEEN '".$tanggal_start."'
								AND '".$tanggal_end."'";
				$isistart=" AND date_format(tanggal_awal,'%Y-%m-%d')>='".$tanggal_start."'
					AND date_format(tanggal_akhir,'%Y-%m-%d')<='".$tanggal_end."' " ;
			}*/
			
			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			}
			
			$isiperiode	="'%Y-%m-%d') BETWEEN '".$tanggal_start."' AND '".$tanggal_end."'";
			$isistart	=" AND date_format(tanggal_awal,'%Y-%m-%d')>='".$tanggal_start."' AND date_format(tanggal_akhir,'%Y-%m-%d')<='".$tanggal_end."' " ;
			
			
			/* CEK SATUAN */
			if($opsi_satuan=='terkecil')
			{
				$sql="SELECT konversi_satuan FROM satuan_konversi
						WHERE konversi_nilai=1
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=1;
				}else{
					return 0;
					exit();
				}

			}else{

				$sql="SELECT konversi_satuan, konversi_nilai FROM satuan_konversi
						WHERE konversi_default=true
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=$row->konversi_nilai;
				}else{
					return 0;
					exit();
				}

			}

			
			// SISTEM KARTU STOK LAMA //
			/*
			//DELETE ALL REPORT
			$sql="DELETE FROM kartu_stok WHERE produk_id=".$produk_id."
					".$isistart."
					AND gudang_id='".$gudang."'";
			$result=$this->db->query($sql);

			//UNTUK SEMUA GUDANG //

			//MUTASI MASUK
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`mutasi_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.mutasi_no as no_bukti,
						   	concat('Mutasi dari ',`gd`.`gudang_nama`) AS keterangan,
						   	dt.dmutasi_jumlah*konversi_nilai/".$current_konversi.",
							0 as keluar,
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_mutasi` `dt`, `master_mutasi` `mt`, satuan_konversi, gudang gd
					 WHERE     `dt`.`dmutasi_master` = `mt`.`mutasi_id`
							AND mt.mutasi_asal=gd.gudang_id
							AND konversi_satuan = dt.dmutasi_satuan
							AND konversi_produk = dt.dmutasi_produk
							AND date_format(mutasi_tanggal,".$isiperiode."
							AND dmutasi_produk='".$produk_id."'
							AND mutasi_status='Tertutup'
							AND mutasi_tujuan='".$gudang."'";
			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			//MUTASI KELUAR
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`mutasi_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.mutasi_no as no_bukti,
						   	concat('Mutasi ke ',`gd`.`gudang_nama`) AS keterangan,
							0 as masuk,
							dt.dmutasi_jumlah*konversi_nilai/".$current_konversi.",
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_mutasi` `dt`, `master_mutasi` `mt`, satuan_konversi, gudang gd
					 WHERE     `dt`.`dmutasi_master` = `mt`.`mutasi_id`
							AND mt.mutasi_tujuan=gd.gudang_id
							AND konversi_satuan = dt.dmutasi_satuan
							AND konversi_produk = dt.dmutasi_produk
							AND date_format(mutasi_tanggal,".$isiperiode."
							AND dmutasi_produk='".$produk_id."'
							AND mutasi_status='Tertutup'
							AND mutasi_asal='".$gudang."'";
			//$this->firephp->log($sql);
			$result=$this->db->query($sql);


			//KOREKSI MASUK
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`koreksi_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.koreksi_no as no_bukti,
						   	concat('Koreksi di ',`gd`.`gudang_nama`) AS keterangan,
						   	dt.dkoreksi_jmlkoreksi*konversi_nilai/".$current_konversi.",
							0 as keluar,
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_koreksi_stok` `dt`, `master_koreksi_stok` `mt`, satuan_konversi, gudang gd
					 WHERE     `dt`.`dkoreksi_master` = `mt`.`koreksi_id`
							AND mt.koreksi_gudang=gd.gudang_id
							AND konversi_satuan = dt.dkoreksi_satuan
							AND konversi_produk = dt.dkoreksi_produk
							AND date_format(koreksi_tanggal,".$isiperiode."
							AND dkoreksi_produk='".$produk_id."'
							AND koreksi_status='Tertutup'
							AND koreksi_gudang='".$gudang."'
							AND dt.dkoreksi_jmlkoreksi>0";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			//KOREKSI KELUAR
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`koreksi_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.koreksi_no as no_bukti,
						   	concat('Koreksi di ',`gd`.`gudang_nama`) AS keterangan,
						   	0 as masuk,
							abs(dt.dkoreksi_jmlkoreksi*konversi_nilai/".$current_konversi."),
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_koreksi_stok` `dt`, `master_koreksi_stok` `mt`, satuan_konversi, gudang gd
					 WHERE     `dt`.`dkoreksi_master` = `mt`.`koreksi_id`
							AND mt.koreksi_gudang=gd.gudang_id
							AND konversi_satuan = dt.dkoreksi_satuan
							AND konversi_produk = dt.dkoreksi_produk
							AND date_format(koreksi_tanggal,".$isiperiode."
							AND dkoreksi_produk='".$produk_id."'
							AND koreksi_status='Tertutup'
							AND koreksi_gudang='".$gudang."'
							AND dt.dkoreksi_jmlkoreksi<0";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);
			
			// PENERIMAAN BARANG PRODUK
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`terima_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.terima_no as no_bukti,
						   	concat('Pembelian dari ',`sp`.`supplier_nama`) AS keterangan,
						   	dt.dterima_jumlah*konversi_nilai/".$current_konversi." as masuk,
						   	0 as keluar,
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_terima_beli` `dt`, `master_terima_beli` `mt`, satuan_konversi, supplier sp
					 WHERE     `dt`.`dterima_master` = `mt`.`terima_id`
							AND mt.terima_supplier=sp.supplier_id
							AND konversi_satuan = dt.dterima_satuan
							AND konversi_produk = dt.dterima_produk
							AND date_format(terima_tanggal,".$isiperiode."
							AND dterima_produk='".$produk_id."'
							AND terima_status='Tertutup'
							AND mt.terima_gudang_id=".$gudang;
			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			//PENERIMAAN BARANG BONUS
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`terima_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.terima_no as no_bukti,
						   	concat('Bonus Pembelian dari ',`sp`.`supplier_nama`) AS keterangan,
						   	dt.dtbonus_jumlah*konversi_nilai/".$current_konversi." as masuk,
						   	0 as keluar,
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_terima_bonus` `dt`, `master_terima_beli` `mt`, satuan_konversi, supplier sp
					 WHERE     `dt`.`dtbonus_master` = `mt`.`terima_id`
							AND mt.terima_supplier=sp.supplier_id
							AND konversi_satuan = dt.dtbonus_satuan
							AND konversi_produk = dt.dtbonus_produk
							AND date_format(terima_tanggal,".$isiperiode."
							AND dtbonus_produk='".$produk_id."'
							AND terima_status='Tertutup'
							AND mt.terima_gudang_id=".$gudang;
			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			if($gudang==1){


			//RETUR PEMBELIAN
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`rbeli_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.rbeli_nobukti as no_bukti,
						   	concat('Retur Pembelian ke ',`sp`.`supplier_nama`) AS keterangan,
						   	0 as masuk,
							dt.drbeli_jumlah*konversi_nilai/".$current_konversi.",
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_retur_beli` `dt`, `master_retur_beli` `mt`, satuan_konversi, supplier sp
					 WHERE     `dt`.`drbeli_master` = `mt`.`rbeli_id`
							AND mt.rbeli_supplier=sp.supplier_id
							AND konversi_satuan = dt.drbeli_satuan
							AND konversi_produk = dt.drbeli_produk
							AND date_format(rbeli_tanggal,".$isiperiode."
							AND drbeli_produk='".$produk_id."'
							AND rbeli_status='Tertutup'
							AND 1=".$gudang;
			//$this->firephp->log($sql);
			$result=$this->db->query($sql);
			}elseif($gudang==4 || $gudang==3){

			//PAKAI CABIN
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT date_format(cabin_date_create,'%Y-%m-%d') as tanggal,
						  	".$produk_id.", konversi_satuan, cabin_bukti as no_bukti,
						   	concat('Pemakaian Perawatan Customer : ',`cust`.`cust_nama`) AS keterangan,
							0 as masuk,
							cabin_jumlah*konversi_nilai/".$current_konversi.",
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM  detail_pakai_cabin, satuan_konversi, customer cust
					 WHERE  cabin_cust=cust.cust_id
							AND konversi_satuan = cabin_satuan
							AND konversi_produk = cabin_produk
							AND date_format(cabin_date_create,".$isiperiode."
							AND cabin_produk='".$produk_id."'
							AND cabin_gudang='".$gudang."'";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			}elseif($gudang==2){

			//PENJUALAN PRODUK
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`jproduk_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.jproduk_nobukti as no_bukti,
						   	concat('Penjualan ke Customer : ',`cust`.`cust_nama`) AS keterangan,
						   	0 as masuk,
							dt.dproduk_jumlah*konversi_nilai/".$current_konversi.",
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_jual_produk` `dt`, `master_jual_produk` `mt`, satuan_konversi, customer cust
					 WHERE  `dt`.`dproduk_master` = `mt`.`jproduk_id`
					 		AND jproduk_cust=cust.cust_id
							AND konversi_satuan = dt.dproduk_satuan
							AND konversi_produk = dt.dproduk_produk
							AND date_format(jproduk_tanggal,".$isiperiode."
							AND dproduk_produk='".$produk_id."'
							AND jproduk_stat_dok='Tertutup'";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			//RETUR PENJUALAN PRODUK
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`rproduk_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.rproduk_nobukti as no_bukti,
						   	concat('Retur Penjualan dari Customer : ',`cust`.`cust_nama`) AS keterangan,
							dt.drproduk_jumlah*konversi_nilai/".$current_konversi.",
							0 as keluar,
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_retur_jual_produk` `dt`, `master_retur_jual_produk` `mt`, satuan_konversi, customer cust
					 WHERE     `dt`.`drproduk_master` = `mt`.`rproduk_id`
					 		AND rproduk_cust=cust.cust_id
							AND konversi_satuan = dt.drproduk_satuan
							AND konversi_produk = dt.drproduk_produk
							AND date_format(rproduk_tanggal,".$isiperiode."
							AND drproduk_produk='".$produk_id."'
							AND rproduk_stat_dok='Tertutup'";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			//PENJUALAN PRODUK GROOMING
			$sql="INSERT INTO kartu_stok(tanggal, produk_id, satuan_id, no_bukti,
										 keterangan, masuk, keluar, gudang_id, tanggal_awal,
										 tanggal_akhir)

					SELECT `mt`.`jpgrooming_tanggal` AS `tanggal`,
						  	".$produk_id.", konversi_satuan, mt.jpgrooming_nobukti as no_bukti,
						   	concat('Penjualan Grooming ke Karyawan : ',`kar`.`karyawan_nama`) AS keterangan,
							0 as masuk,
							dt.dpgrooming_jumlah*konversi_nilai/".$current_konversi.",
							".$gudang." AS `gudang`,
							date_format('".$tanggal_start."','%Y-%m-%d'),
							date_format('".$tanggal_end."','%Y-%m-%d')
					  FROM `detail_jualproduk_grooming` `dt`, `master_jualproduk_grooming` `mt`, satuan_konversi, karyawan kar
					 WHERE  dt.`dpgrooming_master` = `mt`.`jpgrooming_id`
							AND konversi_satuan = dt.dpgrooming_satuan
							AND konversi_produk = dt.dpgrooming_produk
							AND jpgrooming_karyawan=kar.karyawan_id
							AND date_format(jpgrooming_tanggal,".$isiperiode."
							AND dpgrooming_produk='".$produk_id."'";

			//$this->firephp->log($sql);
			$result=$this->db->query($sql);

			}
			*/
			return '1';
		}

		function kartu_stok_list($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$filter,$start,$end){
			if ($periode == 'bulan'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' and date_format(ks_tgl_faktur,'%Y-%m')='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode=" AND date_format(ks_tgl_faktur,'%Y-%m-%d') BETWEEN date_format('".$tanggal_start."','%Y-%m-%d') AND 
								date_format('".$tanggal_end."','%Y-%m-%d') ";
			}
			
			// CEK SATUAN
			if($opsi_satuan=='terkecil')
			{
				$sql="SELECT konversi_satuan FROM satuan_konversi
						WHERE konversi_nilai=1
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=1;
				}else{
					return 0;
					exit();
				}

			}else{

				$sql="SELECT konversi_satuan, konversi_nilai FROM satuan_konversi
						WHERE konversi_default=true
						AND konversi_produk='".$produk_id."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$row=$rs->row();
					$current_satuan=$row->konversi_satuan;
					$current_konversi=$row->konversi_nilai;
				}else{
					return 0;
					exit();
				}

			}
			// EOF CEK SATUAN

			$sql="SELECT 
					ks_tgl_faktur as tanggal,
					ks_produk_id as produk_id,
					ks_satuan_id as satuan_id,
					ks_no_faktur as no_bukti,
					IF(ks_keterangan='jual_produk', CONCAT('Penjualan Produk ',produk.produk_nama),
					IF(ks_keterangan='terima_beli', CONCAT('Pembelian Produk ',produk.produk_nama),
					IF(ks_keterangan='retur_produk', CONCAT('Retur Penjualan Produk ',produk.produk_nama),
					IF(ks_keterangan='mutasi_masuk', CONCAT('Mutasi Masuk ',produk.produk_nama),
					IF(ks_keterangan='mutasi_keluar', CONCAT('Mutasi Keluar ',produk.produk_nama), 
					IF(ks_keterangan='koreksi_stok', CONCAT('Koreksi Stok ',produk.produk_nama),
					IF(ks_keterangan='bahan_produksi', CONCAT('Pengurangan Bahan Dasar ',produk.produk_nama),
					IF(ks_keterangan='produksi_jadi', CONCAT('Penambahan Produksi Jadi ',produk.produk_nama),
					IF(ks_keterangan='mutasi_barang_keluar', CONCAT('Mutasi Barang Keluar ',produk.produk_nama), 'false'))))))))) as keterangan,
					ks_masuk*ks_satuan_nilai/".$current_konversi." as masuk,
					ks_keluar*ks_satuan_nilai/".$current_konversi." as keluar,
					ks_gudang_id as gudang_id	
				FROM kartu_stok_fix
				LEFT JOIN produk ON (produk.produk_id = kartu_stok_fix.ks_produk_id)
				
				WHERE 
					ks_gudang_id='".$gudang."' AND
					kartu_stok_fix.ks_produk_id = '".$produk_id."'
					".$isiperiode."";
			
			// SISTEM STOK LAMA
			/*
			$sql="SELECT * from kartu_stok
				  	WHERE gudang_id='".$gudang."'
				  	AND produk_id='".$produk_id."'
				 	".$isiperiode."
					ORDER BY tanggal ASC";
			*/
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

		//function for print record
		function kartu_stok_print($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end ,$option,$filter){
			if ($periode == 'bulan'){
				$isiperiode=" AND date_format(tanggal_awal,'%Y-%m')='".$tgl_awal."' and date_format(tanggal_akhir,'%Y-%m')='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode=" AND date_format(tanggal_awal,'%Y-%m-%d')=date_format('".$tanggal_start."','%Y-%m-%d')
					AND date_format(tanggal_akhir,'%Y-%m-%d')=date_format('".$tanggal_end."','%Y-%m-%d') ";
			}	
			
			$sql="SELECT tanggal, no_bukti, keterangan, masuk, keluar
					from kartu_stok
				  	WHERE gudang_id='".$gudang."'
				  	AND produk_id='".$produk_id."'
				 	".$isiperiode."
					ORDER BY tanggal ASC";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($nbrows>0)
				return $result->result();
			else
				return NULL;
		}

		//function  for export to excel
		function kartu_stok_export_excel($tgl_awal,$periode,$produk_id ,$tanggal_start ,$tanggal_end ,$opsi_satuan ,$gudang ,$option,$filter){
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" AND date_format(tanggal_awal,'%Y-%m')='".$tgl_awal."' and date_format(tanggal_akhir,'%Y-%m')='".$tgl_awal."' ";
			}else if($periode == 'tanggal'){
				$isiperiode=" AND date_format(tanggal_awal,'%Y-%m-%d')=date_format('".$tanggal_start."','%Y-%m-%d')
					AND date_format(tanggal_akhir,'%Y-%m-%d')=date_format('".$tanggal_end."','%Y-%m-%d') ";
			}	
			
			$sql="SELECT tanggal, no_bukti, keterangan, masuk, keluar
					from kartu_stok
				  	WHERE gudang_id='".$gudang."'
				  	AND produk_id='".$produk_id."'
				 	".$isiperiode."
					ORDER BY tanggal ASC";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($nbrows>0)
				return $result;
			else
				return NULL;
		}

}
?>