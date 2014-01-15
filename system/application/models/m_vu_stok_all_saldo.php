<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: vu_stok_all_saldo Model
	+ Description	: For record model process back-end
	+ Filename 		: c_vu_stok_all_saldo.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

class M_vu_stok_all_saldo extends Model{
		
		//constructor
		function M_vu_stok_all_saldo() {
			parent::Model();
		}
		
		function get_stok_query($tgl_awal,$periode,$produk_id,$tanggal_start,$tanggal_end, $gudang,$isiperiode){
			if ($periode == 'bulan'){
				$isiperiode="'%Y-%m')='".$tgl_awal."'" ;
				$isistart="'%Y-%m-%d')<'".$tgl_awal."-01'" ;
			}else if($periode == 'tanggal'){
				$isiperiode="'%Y-%m-%d') BETWEEN '".$tanggal_start."'
								AND '".$tanggal_end."'";
				$isistart="'%Y-%m-%d')<'".$tanggal_start."'" ;
			}	
			
			$sql_stok="SELECT 	
									sum(stok.jml_terima_barang)+ 
									sum(stok.jml_terima_bonus) as jumlah_terima,
									sum(stok.jml_mutasi_masuk) as jumlah_masuk,
									sum(stok.jml_retur_produk) as jumlah_retur_produk,
									sum(stok.jml_retur_paket) as jumlah_retur_paket,
									sum(stok.jml_koreksi_stok) as jumlah_koreksi,
									sum(stok.jml_retur_beli) as jumlah_retur_beli,
									sum(stok.jml_mutasi_keluar) as jumlah_keluar,
									sum(stok.jml_jual_produk)+sum(jml_jual_grooming) as jumlah_jual,
									sum(stok.jml_pakai_cabin) as jumlah_pakai_cabin
								FROM
								
					(SELECT `mt`.`terima_tanggal` AS `tanggal`,
					          `mt`.`terima_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mt`.`terima_no` AS `no_bukti`,
					          _UTF8 'PB' AS `jenis_transaksi`,
					          `mt`.`terima_status` AS `status`,
					          `dt`.`dterima_produk` AS `produk`,
					          `dt`.`dterima_satuan` AS `satuan`,
					          `dt`.`dterima_jumlah`*sk.konversi_nilai AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'beli' AS `keterangan`,
					          `dt`.`dterima_id` AS `detail_id`
					     FROM `detail_terima_beli` `dt`,`master_terima_beli` `mt`,
					           satuan_konversi sk					              
					    WHERE `dt`.`dterima_master` = `mt`.`terima_id`
					    AND  sk.konversi_satuan=dt.dterima_satuan
					    AND  sk.konversi_produk=dt.dterima_produk
					    AND  dt.dterima_produk='".$produk_id."'
					    AND  date_format(mt.terima_tanggal,".$isiperiode." 
					    AND  mt.terima_status='Tertutup'
					    
					    UNION ALL
					    SELECT `mt`.`terima_tanggal` AS `tanggal`,
					          `mt`.`terima_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mt`.`terima_no` AS `no_bukti`,
					          _UTF8 'PB' AS `jenis_transaksi`,
					          `mt`.`terima_status` AS `status`,
					          `db`.`dtbonus_produk` AS `produk`,
					          `db`.`dtbonus_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          `db`.`dtbonus_jumlah`*sk.konversi_nilai AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'bonus' AS `keterangan`,
					          `db`.`dtbonus_id` AS `detail_id`
					     FROM `detail_terima_bonus` `db`,`master_terima_beli` `mt`,satuan_konversi sk
					    WHERE `db`.`dtbonus_master` = `mt`.`terima_id`
					    AND  sk.konversi_satuan=db.dtbonus_satuan
					    AND  sk.konversi_produk=db.dtbonus_produk
					    AND  db.dtbonus_produk='".$produk_id."'
					    AND  date_format(mt.terima_tanggal,".$isiperiode."
					    AND  mt.terima_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mmm`.`mutasi_tanggal` AS `tanggal`,
					          `mmm`.`mutasi_asal` AS `asal`,
					          `mmm`.`mutasi_tujuan` AS `tujuan`,
					          `mmm`.`mutasi_tujuan` AS `gudang`,
					          `mmm`.`mutasi_no` AS `no_bukti`,
					          _UTF8 'mutasi' AS `jenis_transaksi`,
					          `mmm`.`mutasi_status` AS `status`,
					          `dmm`.`dmutasi_produk` AS `produk`,
					          `dmm`.`dmutasi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          `dmm`.`dmutasi_jumlah`*konversi_nilai AS `jml_mutasi_masuk`,
					          0 AS `jml_mutasi_keluar`,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'mutasi masuk' AS `keterangan`,
					          `dmm`.`dmutasi_id` AS `detail_id`
					     FROM `master_mutasi` `mmm`,`detail_mutasi` `dmm`,satuan_konversi sk
					    WHERE `dmm`.`dmutasi_master` = `mmm`.`mutasi_id`
					    AND  sk.konversi_produk=dmm.dmutasi_produk
					    AND  sk.konversi_satuan=dmm.dmutasi_satuan
					    AND  dmm.dmutasi_produk='".$produk_id."'
					    AND  date_format(mmm.mutasi_tanggal,".$isiperiode."
					    AND  mmm.mutasi_status='Tertutup'
					    
					   UNION ALL  
					   SELECT `mmk`.`mutasi_tanggal` AS `tanggal`,
					          `mmk`.`mutasi_asal` AS `asal`,
					          `mmk`.`mutasi_tujuan` AS `tujuan`,
					          `mmk`.`mutasi_asal` AS `gudang`,
					          `mmk`.`mutasi_no` AS `no_bukti`,
					          _UTF8 'mutasi' AS `jenis_transaksi`,
					          `mmk`.`mutasi_status` AS `status`,
					          `dmk`.`dmutasi_produk` AS `produk`,
					          `dmk`.`dmutasi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 AS `jml_mutasi_masuk`,
					          `dmk`.`dmutasi_jumlah`*sk.konversi_nilai AS `jml_mutasi_keluar`,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'mutasi keluar' AS `keterangan`,
					          `dmk`.`dmutasi_id` AS `detail_id`
					    FROM  master_mutasi mmk,detail_mutasi dmk,satuan_konversi sk
					    WHERE `dmk`.`dmutasi_master` = `mmk`.`mutasi_id`
					    AND  sk.konversi_produk=dmk.dmutasi_produk
					    AND  sk.konversi_satuan=dmk.dmutasi_satuan
					    AND  dmk.dmutasi_produk='".$produk_id."'
					    AND  date_format(mmk.mutasi_tanggal,".$isiperiode."
					    AND  mmk.mutasi_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mr`.`rbeli_tanggal` AS `tanggal`,
					          `mr`.`rbeli_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mr`.`rbeli_nobukti` AS `no_bukti`,
					          _UTF8 'RB' AS `jenis_transaksi`,
					          `mr`.`rbeli_status` AS `status`,
					          `dr`.`drbeli_produk` AS `produk`,
					          `dr`.`drbeli_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          `dr`.`drbeli_jumlah`*sk.konversi_nilai AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'retur' AS `keterangan`,
					          `dr`.`drbeli_id` AS `detail_id`
					     FROM `detail_retur_beli` `dr`,`master_retur_beli` `mr`, satuan_konversi sk
					    WHERE `dr`.`drbeli_master` = `mr`.`rbeli_id`
					    AND  sk.konversi_satuan=dr.drbeli_satuan
					    AND  dr.drbeli_produk='".$produk_id."'
					    AND  date_format(mr.rbeli_tanggal,".$isiperiode."
					    AND  mr.rbeli_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mk`.`koreksi_tanggal` AS `tanggal`,
					          `mk`.`koreksi_gudang` AS `asal`,
					          `mk`.`koreksi_gudang` AS `tujuan`,
					          `mk`.`koreksi_gudang` AS `gudang`,
					          `mk`.`koreksi_no` AS `no_bukti`,
					          _UTF8 'koreksi' AS `jenis_transaksi`,
					          `mk`.`koreksi_status` AS `status`,
					          `dk`.`dkoreksi_produk` AS `produk`,
					          `dk`.`dkoreksi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          `dk`.`dkoreksi_jmlkoreksi`*sk.konversi_nilai AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'koreksi' AS `keterangan`,
					          `dk`.`dkoreksi_id` AS `detail_id`
					     FROM `master_koreksi_stok` `mk`,`detail_koreksi_stok` `dk`, satuan_konversi sk
					    WHERE (`mk`.`koreksi_id` = `dk`.`dkoreksi_master`)
					    AND sk.konversi_satuan=dk.dkoreksi_satuan
					    AND  sk.konversi_produk=dk.dkoreksi_produk
					    AND  dk.dkoreksi_produk='".$produk_id."'
					    AND  date_format(mk.koreksi_tanggal,".$isiperiode."
					    AND  mk.koreksi_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mj`.`jproduk_tanggal` AS `tanggal`,
					          2 AS `asal`,
					          `mj`.`jproduk_cust` AS `tujuan`,
					          2 AS `gudang`,
					          `mj`.`jproduk_nobukti` AS `no_bukti`,
					          _UTF8 'jual produk' AS `jenis_traksaksi`,
					          `mj`.`jproduk_stat_dok` AS `status`,
					          `dj`.`dproduk_produk` AS `produk`,
					          `dj`.`dproduk_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          `dj`.`dproduk_jumlah`*sk.konversi_nilai AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'customer' AS `keterangan`,
					          `dj`.`dproduk_id` AS `detail_id`
					     FROM  `master_jual_produk` `mj`,`detail_jual_produk` `dj`, satuan_konversi sk
					    WHERE (`dj`.`dproduk_master` = `mj`.`jproduk_id`)
					    AND  dj.dproduk_satuan=sk.konversi_satuan
					    AND  sk.konversi_produk=dj.dproduk_produk
					    AND  dj.dproduk_produk='".$produk_id."'
					    AND  date_format(mj.jproduk_tanggal,".$isiperiode."
					    AND  mj.jproduk_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `mjg`.`jpgrooming_tanggal` AS `tanggal`,
					          2 AS `asal`,
					          `mjg`.`jpgrooming_karyawan` AS `tujuan`,
					          2 AS `gudang`,
					          `mjg`.`jpgrooming_nobukti` AS `no_bukti`,
					          _UTF8 'jual produk' AS `jenis_transaksi`,
					          _UTF8 'Tertutup' AS `status`,
					          `djg`.`dpgrooming_produk` AS `produk`,
					          `djg`.`dpgrooming_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          `djg`.`dpgrooming_jumlah`*sk.konversi_nilai AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'grooming' AS `keterangan`,
					          `djg`.`dpgrooming_id` AS `detail_id`
					     FROM `master_jualproduk_grooming` `mjg`,`detail_jualproduk_grooming` `djg`,
					          satuan_konversi sk
					    WHERE (`mjg`.`jpgrooming_id` = `djg`.`dpgrooming_master`)
					    AND  sk.konversi_satuan=djg.dpgrooming_satuan
					    AND  sk.konversi_produk=djg.dpgrooming_produk
					    AND  djg.dpgrooming_produk='".$produk_id."'
					    AND  date_format(mjg.jpgrooming_tanggal,".$isiperiode."
					    
					   UNION ALL
					   SELECT `mrj`.`rproduk_tanggal` AS `tanggal`,
					          `mrj`.`rproduk_cust` AS `asal`,
					          2 AS `tujuan`,
					          2 AS `gudang`,
					          `mrj`.`rproduk_nobukti` AS `no_bukti`,
					          _UTF8 'retur jual' AS `jenis_transaksi`,
					          `mrj`.`rproduk_stat_dok` AS `status`,
					          `drj`.`drproduk_produk` AS `produk`,
					          `drj`.`drproduk_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          `drj`.`drproduk_jumlah`*sk.konversi_nilai AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'produk retur' AS `keterangan`,
					          `drj`.`drproduk_id` AS `detail_id`
					     FROM `master_retur_jual_produk` `mrj`,`detail_retur_jual_produk` `drj`,
					           satuan_konversi sk
					    WHERE (`mrj`.`rproduk_id` = `drj`.`drproduk_master`)
					    AND  sk.konversi_satuan=drj.drproduk_satuan
					    AND  sk.konversi_produk=drj.drproduk_produk
					    AND  drj.drproduk_produk='".$produk_id."'
					    AND  date_format(mrj.rproduk_tanggal,".$isiperiode."
					    AND  mrj.rproduk_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `mrp`.`rpaket_tanggal` AS `tanggal`,
					          `mrp`.`rpaket_cust` AS `asal`,
					          2 AS `tujuan`,
					          2 AS `gudang`,
					          `mrp`.`rpaket_nobukti` AS `no_bukti`,
					          _UTF8 'retur jual' AS `jenis_transaksi`,
					          `mrp`.`rpaket_stat_dok` AS `status`,
					          `drp`.`drpaket_produk` AS `produk`,
					          `drp`.`drpaket_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          `drp`.`drpaket_jumlah`*sk.konversi_nilai AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'paket retur' AS `keterangan`,
					          `drp`.`drpaket_id` AS `detail_id`
					     FROM `master_retur_jual_paket` `mrp`,
					           `detail_retur_paket_produk` `drp`,
					           satuan_konversi  sk
					    WHERE (`mrp`.`rpaket_id` = `drp`.`drpaket_master`)
					    AND	 sk.konversi_satuan=drp.drpaket_satuan
					    AND  sk.konversi_produk=drp.drpaket_produk
					    AND  drp.drpaket_produk='".$produk_id."'
					    AND  date_format(mrp.rpaket_tanggal,".$isiperiode."
					    AND  mrp.rpaket_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `cb`.`cabin_date_create` AS `tanggal`,
					          `cb`.`cabin_gudang` AS `asal`,
					          `cb`.`cabin_cust` AS `tujuan`,
					          `cb`.`cabin_gudang` AS `gudang`,
					          `cb`.`cabin_bukti` AS `no_bukti`,
					          _UTF8 'pakai cabin' AS `jenis_transaksi`,
					          _UTF8 'Tertutup' AS `status`,
					          `cb`.`cabin_produk` AS `produk`,
					          `cb`.`cabin_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          `cb`.`cabin_jumlah`*sk.konversi_nilai AS `jml_pakai_cabin`,
					          _UTF8 'pakai cabin' AS `keterangan`,
					          `cb`.`cabin_dtrawat` AS `detail_id`
					     FROM `detail_pakai_cabin` `cb`, satuan_konversi sk
					    WHERE  cb.cabin_produk='".$produk_id."'
					    AND sk.konversi_satuan=cb.cabin_satuan
					    AND  sk.konversi_produk=cb.cabin_produk
					    AND  date_format(cb.cabin_date_create,".$isiperiode."
					) as stok ";
			if($gudang<>0 || $gudang<>""){
					$sql_stok.=" WHERE stok.gudang='".$gudang."'";
			}
			$sql_stok.=" GROUP by stok.produk";
			return $sql_stok;
		}
		
		function get_stok_awal($tgl_awal,$periode,$produk_id,$tanggal_start,$gudang,$isiperiode){
			
			$stok_awal=0;
			if($gudang==0 || $gudang==""){
				$sqlawal="SELECT 	produk_saldo_awal*konversi_nilai as jumlah
						FROM 	produk, satuan_konversi
						WHERE 	konversi_produk=produk_id
						AND 	konversi_default=true
						AND		produk_id='".$produk_id."'";
				$rsawal=$this->db->query($sqlawal);
				if($rsawal->num_rows()){
					$row=$rsawal->row();
					$stok_awal=$row->jumlah;
				}
			}

			if ($periode == 'bulan'){
				$isistart="'%Y-%m-%d')<'".$tgl_awal."-01'" ;
			}else if($periode == 'tanggal'){
				$isistart="'%Y-%m-%d')<'".$tanggal_start."'" ;
			}
			
				$sql_stok_awal="SELECT 	sum(stok.jml_terima_barang)
										+sum(stok.jml_terima_bonus)
										-sum(stok.jml_retur_beli)
										+sum(stok.jml_koreksi_stok)
										-sum(stok.jml_jual_produk)
										-sum(stok.jml_jual_grooming)
										+sum(stok.jml_retur_produk)
										+sum(stok.jml_retur_paket)
										-sum(stok.jml_pakai_cabin)
										as jumlah_awal
								FROM
								
					(SELECT `mt`.`terima_tanggal` AS `tanggal`,
					          `mt`.`terima_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mt`.`terima_no` AS `no_bukti`,
					          _UTF8 'PB' AS `jenis_transaksi`,
					          `mt`.`terima_status` AS `status`,
					          `dt`.`dterima_produk` AS `produk`,
					          `dt`.`dterima_satuan` AS `satuan`,
					          `dt`.`dterima_jumlah`*sk.konversi_nilai AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'beli' AS `keterangan`,
					          `dt`.`dterima_id` AS `detail_id`
					     FROM `detail_terima_beli` `dt`,`master_terima_beli` `mt`,
					           satuan_konversi sk					              
					    WHERE `dt`.`dterima_master` = `mt`.`terima_id`
					    AND  sk.konversi_satuan=dt.dterima_satuan
					    AND  sk.konversi_produk=dt.dterima_produk
					    AND  dt.dterima_produk='".$produk_id."'
					    AND  date_format(mt.terima_tanggal,".$isistart."
					    AND  mt.terima_status='Tertutup'
					    
					    UNION ALL
					    SELECT `mt`.`terima_tanggal` AS `tanggal`,
					          `mt`.`terima_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mt`.`terima_no` AS `no_bukti`,
					          _UTF8 'PB' AS `jenis_transaksi`,
					          `mt`.`terima_status` AS `status`,
					          `db`.`dtbonus_produk` AS `produk`,
					          `db`.`dtbonus_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          `db`.`dtbonus_jumlah`*sk.konversi_nilai AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'bonus' AS `keterangan`,
					          `db`.`dtbonus_id` AS `detail_id`
					     FROM `detail_terima_bonus` `db`,`master_terima_beli` `mt`,
					     		satuan_konversi sk
					    WHERE `db`.`dtbonus_master` = `mt`.`terima_id`
					    AND  sk.konversi_satuan=db.dtbonus_satuan
					    AND  sk.konversi_produk=db.dtbonus_produk
					    AND  db.dtbonus_produk='".$produk_id."'
					    AND  date_format(mt.terima_tanggal,".$isistart."
					    AND  mt.terima_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mmm`.`mutasi_tanggal` AS `tanggal`,
					          `mmm`.`mutasi_asal` AS `asal`,
					          `mmm`.`mutasi_tujuan` AS `tujuan`,
					          `mmm`.`mutasi_tujuan` AS `gudang`,
					          `mmm`.`mutasi_no` AS `no_bukti`,
					          _UTF8 'mutasi' AS `jenis_transaksi`,
					          `mmm`.`mutasi_status` AS `status`,
					          `dmm`.`dmutasi_produk` AS `produk`,
					          `dmm`.`dmutasi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          `dmm`.`dmutasi_jumlah`*konversi_nilai AS `jml_mutasi_masuk`,
					          0 AS `jml_mutasi_keluar`,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'mutasi masuk' AS `keterangan`,
					          `dmm`.`dmutasi_id` AS `detail_id`
					     FROM `master_mutasi` `mmm`,`detail_mutasi` `dmm`,satuan_konversi sk
					    WHERE `dmm`.`dmutasi_master` = `mmm`.`mutasi_id`
					    AND  sk.konversi_produk=dmm.dmutasi_produk
					    AND  sk.konversi_satuan=dmm.dmutasi_satuan
					    AND  dmm.dmutasi_produk='".$produk_id."'
					    AND  date_format(mmm.mutasi_tanggal,".$isistart."
					    AND  mmm.mutasi_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mmk`.`mutasi_tanggal` AS `tanggal`,
					          `mmk`.`mutasi_asal` AS `asal`,
					          `mmk`.`mutasi_tujuan` AS `tujuan`,
					          `mmk`.`mutasi_asal` AS `gudang`,
					          `mmk`.`mutasi_no` AS `no_bukti`,
					          _UTF8 'mutasi' AS `jenis_transaksi`,
					          `mmk`.`mutasi_status` AS `status`,
					          `dmk`.`dmutasi_produk` AS `produk`,
					          `dmk`.`dmutasi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					          0 AS `jml_mutasi_masuk`,
					          `dmk`.`dmutasi_jumlah`*sk.konversi_nilai AS `jml_mutasi_keluar`,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'mutasi keluar' AS `keterangan`,
					          `dmk`.`dmutasi_id` AS `detail_id`
					    FROM  master_mutasi mmk,detail_mutasi dmk, satuan_konversi sk
					    WHERE dmk.dmutasi_master = mmk.mutasi_id
					    AND  sk.konversi_produk=dmk.dmutasi_produk
					    AND  sk.konversi_satuan=dmk.dmutasi_satuan
					    AND  dmk.dmutasi_produk='".$produk_id."'
					    AND  date_format(mmk.mutasi_tanggal,".$isistart."
					    AND  mmk.mutasi_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mr`.`rbeli_tanggal` AS `tanggal`,
					          `mr`.`rbeli_supplier` AS `asal`,
					          1 AS `tujuan`,
					          1 AS `gudang`,
					          `mr`.`rbeli_nobukti` AS `no_bukti`,
					          _UTF8 'RB' AS `jenis_transaksi`,
					          `mr`.`rbeli_status` AS `status`,
					          `dr`.`drbeli_produk` AS `produk`,
					          `dr`.`drbeli_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          `dr`.`drbeli_jumlah`*sk.konversi_nilai AS `jml_retur_beli`,
					          0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'retur' AS `keterangan`,
					          `dr`.`drbeli_id` AS `detail_id`
					     FROM `detail_retur_beli` `dr`,`master_retur_beli` `mr`, satuan_konversi sk
					    WHERE `dr`.`drbeli_master` = `mr`.`rbeli_id`
					    AND  sk.konversi_satuan=dr.drbeli_satuan
					    AND  dr.drbeli_produk='".$produk_id."'
					    AND  date_format(mr.rbeli_tanggal,".$isistart."
					    AND  mr.rbeli_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mk`.`koreksi_tanggal` AS `tanggal`,
					          `mk`.`koreksi_gudang` AS `asal`,
					          `mk`.`koreksi_gudang` AS `tujuan`,
					          `mk`.`koreksi_gudang` AS `gudang`,
					          `mk`.`koreksi_no` AS `no_bukti`,
					          _UTF8 'koreksi' AS `jenis_transaksi`,
					          `mk`.`koreksi_status` AS `status`,
					          `dk`.`dkoreksi_produk` AS `produk`,
					          `dk`.`dkoreksi_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          `dk`.`dkoreksi_jmlkoreksi`*sk.konversi_nilai AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'koreksi' AS `keterangan`,
					          `dk`.`dkoreksi_id` AS `detail_id`
					     FROM `master_koreksi_stok` `mk`,`detail_koreksi_stok` `dk`, satuan_konversi sk
					    WHERE (`mk`.`koreksi_id` = `dk`.`dkoreksi_master`)
					    AND sk.konversi_satuan=dk.dkoreksi_satuan
					    AND  sk.konversi_produk=dk.dkoreksi_produk
					    AND  dk.dkoreksi_produk='".$produk_id."'
					    AND  date_format(mk.koreksi_tanggal,".$isistart."
					    AND  mk.koreksi_status='Tertutup'
					    
					   UNION ALL
					   SELECT `mj`.`jproduk_tanggal` AS `tanggal`,
					          2 AS `asal`,
					          `mj`.`jproduk_cust` AS `tujuan`,
					          2 AS `gudang`,
					          `mj`.`jproduk_nobukti` AS `no_bukti`,
					          _UTF8 'jual produk' AS `jenis_traksaksi`,
					          `mj`.`jproduk_stat_dok` AS `status`,
					          `dj`.`dproduk_produk` AS `produk`,
					          `dj`.`dproduk_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          `dj`.`dproduk_jumlah`*sk.konversi_nilai AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'customer' AS `keterangan`,
					          `dj`.`dproduk_id` AS `detail_id`
					     FROM  `master_jual_produk` `mj`,`detail_jual_produk` `dj`, satuan_konversi sk
					    WHERE (`dj`.`dproduk_master` = `mj`.`jproduk_id`)
					    AND  dj.dproduk_satuan=sk.konversi_satuan
					    AND  sk.konversi_produk=dj.dproduk_produk
					    AND  dj.dproduk_produk='".$produk_id."'
					    AND  date_format(mj.jproduk_tanggal,".$isistart."
					    AND  mj.jproduk_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `mjg`.`jpgrooming_tanggal` AS `tanggal`,
					          2 AS `asal`,
					          `mjg`.`jpgrooming_karyawan` AS `tujuan`,
					          2 AS `gudang`,
					          `mjg`.`jpgrooming_nobukti` AS `no_bukti`,
					          _UTF8 'jual produk' AS `jenis_transaksi`,
					          _UTF8 'Tertutup' AS `status`,
					          `djg`.`dpgrooming_produk` AS `produk`,
					          `djg`.`dpgrooming_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          `djg`.`dpgrooming_jumlah`*sk.konversi_nilai AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'grooming' AS `keterangan`,
					          `djg`.`dpgrooming_id` AS `detail_id`
					     FROM `master_jualproduk_grooming` `mjg`,`detail_jualproduk_grooming` `djg`,
					          satuan_konversi sk
					    WHERE (`mjg`.`jpgrooming_id` = `djg`.`dpgrooming_master`)
					    AND  sk.konversi_satuan=djg.dpgrooming_satuan
					    AND  sk.konversi_produk=djg.dpgrooming_produk
					    AND  djg.dpgrooming_produk='".$produk_id."'
					    AND  date_format(mjg.jpgrooming_tanggal,".$isistart."
					    
					   UNION ALL
					   SELECT `mrj`.`rproduk_tanggal` AS `tanggal`,
					          `mrj`.`rproduk_cust` AS `asal`,
					          2 AS `tujuan`,
					          2 AS `gudang`,
					          `mrj`.`rproduk_nobukti` AS `no_bukti`,
					          _UTF8 'retur jual' AS `jenis_transaksi`,
					          `mrj`.`rproduk_stat_dok` AS `status`,
					          `drj`.`drproduk_produk` AS `produk`,
					          `drj`.`drproduk_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          `drj`.`drproduk_jumlah`*sk.konversi_nilai AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'produk retur' AS `keterangan`,
					          `drj`.`drproduk_id` AS `detail_id`
					     FROM `master_retur_jual_produk` `mrj`,`detail_retur_jual_produk` `drj`,
					           satuan_konversi sk
					    WHERE (`mrj`.`rproduk_id` = `drj`.`drproduk_master`)
					    AND  sk.konversi_satuan=drj.drproduk_satuan
					    AND  sk.konversi_produk=drj.drproduk_produk
					    AND  drj.drproduk_produk='".$produk_id."'
					    AND  date_format(mrj.rproduk_tanggal,".$isistart."
					    AND  mrj.rproduk_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `mrp`.`rpaket_tanggal` AS `tanggal`,
					          `mrp`.`rpaket_cust` AS `asal`,
					          2 AS `tujuan`,
					          2 AS `gudang`,
					          `mrp`.`rpaket_nobukti` AS `no_bukti`,
					          _UTF8 'retur jual' AS `jenis_transaksi`,
					          `mrp`.`rpaket_stat_dok` AS `status`,
					          `drp`.`drpaket_produk` AS `produk`,
					          `drp`.`drpaket_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          `drp`.`drpaket_jumlah`*sk.konversi_nilai AS `jml_retur_paket`,
					          0 AS `jml_pakai_cabin`,
					          _UTF8 'paket retur' AS `keterangan`,
					          `drp`.`drpaket_id` AS `detail_id`
					     FROM `master_retur_jual_paket` `mrp`,
					           `detail_retur_paket_produk` `drp`,
					           satuan_konversi  sk
					    WHERE (`mrp`.`rpaket_id` = `drp`.`drpaket_master`)
					    AND	 sk.konversi_satuan=drp.drpaket_satuan
					    AND  sk.konversi_produk=drp.drpaket_produk
					    AND  drp.drpaket_produk='".$produk_id."'
					    AND  date_format(mrp.rpaket_tanggal,".$isistart."
					    AND  mrp.rpaket_stat_dok='Tertutup'
					    
					   UNION ALL
					   SELECT `cb`.`cabin_date_create` AS `tanggal`,
					          `cb`.`cabin_gudang` AS `asal`,
					          `cb`.`cabin_cust` AS `tujuan`,
					          `cb`.`cabin_gudang` AS `gudang`,
					          `cb`.`cabin_bukti` AS `no_bukti`,
					          _UTF8 'pakai cabin' AS `jenis_transaksi`,
					          _UTF8 'Tertutup' AS `status`,
					          `cb`.`cabin_produk` AS `produk`,
					          `cb`.`cabin_satuan` AS `satuan`,
					          0 AS `jml_terima_barang`,
					          0 AS `jml_terima_bonus`,
					          0 AS `jml_retur_beli`,
					           0 as jml_mutasi_masuk,
					          0 as jml_mutasi_keluar,
					          0 AS `jml_koreksi_stok`,
					          0 AS `jml_jual_produk`,
					          0 AS `jml_jual_grooming`,
					          0 AS `jml_retur_produk`,
					          0 AS `jml_retur_paket`,
					          `cb`.`cabin_jumlah`*sk.konversi_nilai AS `jml_pakai_cabin`,
					          _UTF8 'pakai cabin' AS `keterangan`,
					          `cb`.`cabin_dtrawat` AS `detail_id`
					     FROM `detail_pakai_cabin` `cb`, satuan_konversi sk
					    WHERE  cb.cabin_produk='".$produk_id."'
					    AND sk.konversi_satuan=cb.cabin_satuan
					    AND  sk.konversi_produk=cb.cabin_produk
					    AND  date_format(cb.cabin_date_create,".$isistart."
					) as stok ";
				
				if($gudang<>0 || $gudang<>""){
					$sql_stok_awal.=" WHERE stok.gudang='".$gudang."'";
				}
				
				$sql_stok_awal.=" GROUP by stok.produk";
				
				$q_stokawal=$this->db->query($sql_stok_awal);
				if($q_stokawal->num_rows())
				{
					$ds_stokawal=$q_stokawal->row();
					$stok_awal+=$ds_stokawal->jumlah_awal;
				}
				
				return $stok_awal;
				
		}
		
		function get_detail_stok($tgl_awal,$periode,$opsi_satuan,$tanggal_start,$tanggal_end,$produk_id,$query,$start,$end){
			$sql="select distinct * from gudang";
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
			$limit = $sql." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			$i=0;
			
			if($opsi_satuan=='terkecil')
				$sql_produk="SELECT distinct * FROM vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			else
				$sql_produk="SELECT distinct * FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";
			$sql_produk.=" AND produk_id='".$produk_id."'";
			
			if ($periode == 'bulan'){
				$isiperiode="'%Y-%m')='".$tgl_awal."'" ;
				$isistart="'%Y-%m-%d')<'".$tgl_awal."-01'" ;
			}else if($periode == 'tanggal'){
				$isiperiode="'%Y-%m-%d') BETWEEN '".$tanggal_start."'
								AND '".$tanggal_end."'";
				$isistart="'%Y-%m-%d')<'".$tanggal_start."'" ;
			}	
			
			foreach($result->result() as $row){
				
				$data[$i]["gudang_id"]=$row->gudang_id;
				$data[$i]["gudang_nama"]=$row->gudang_nama;
				$data[$i]["jumlah_masuk"]=0;
				$data[$i]["jumlah_keluar"]=0;
				$data[$i]["jumlah_koreksi"]=0;
				$data[$i]["jumlah_stok"]=0;
				
				$result_produk=$this->db->query($sql_produk);
				
				if($result_produk->num_rows()){
					$rowproduk=$result_produk->row();
					$data[$i]["produk_id"]=$rowproduk->produk_id;
					$data[$i]["produk_kode"]=$rowproduk->produk_kode;
					$data[$i]["produk_nama"]=$rowproduk->produk_nama;
					$data[$i]["satuan_id"]=$rowproduk->satuan_id;
					$data[$i]["satuan_kode"]=$rowproduk->satuan_kode;
					$data[$i]["satuan_nama"]=$rowproduk->satuan_nama;	
					if($opsi_satuan=='terkecil')
						$data[$i]["konversi_nilai"]=1;
					else
						$data[$i]["konversi_nilai"]=1/$rowproduk->konversi_nilai;

					$data[$i]["jumlah_awal"]=round($this->get_stok_awal($tgl_awal,$periode,$rowproduk->produk_id,$tanggal_start,$row->gudang_id,$isiperiode)*$data[$i]["konversi_nilai"],3);

					$sql_stok_mutasi=$this->get_stok_query($tgl_awal,$periode,$rowproduk->produk_id,$tanggal_start,$tanggal_end,$row->gudang_id,$isiperiode);
					$sql_stok_mutasi="SELECT ifnull(sum(jml_terima_barang*konversi_nilai)
										+sum(jml_terima_bonus*konversi_nilai)
										+sum(jml_mutasi_masuk*konversi_nilai)
										+sum(jml_retur_produk*konversi_nilai)
										+sum(jml_retur_paket*konversi_nilai),0) as jumlah_masuk,
										ifnull(sum(jml_koreksi_stok*konversi_nilai),0) as jumlah_koreksi,
										ifnull(sum(jml_retur_beli*konversi_nilai)
										+sum(jml_mutasi_keluar*konversi_nilai)
										+sum(jml_jual_produk*konversi_nilai)
										+sum(jml_jual_grooming*konversi_nilai)
										+sum(jml_pakai_cabin*konversi_nilai),0) as jumlah_keluar
								FROM	vu_stok_new_produk
								WHERE   date_format(tanggal,".$isistart."
										AND produk_id='".$rowproduk->produk_id."'
										AND gudang='".$row->gudang_id."'
										AND status='Tertutup'
								GROUP BY produk_id";

					$rs_mutasi=$this->db->query($sql_stok_mutasi);
					if($rs_mutasi->num_rows()>0)
					{
						$ds_mutasi=$rs_mutasi->row();
						$data[$i]["jumlah_masuk"]=round($ds_mutasi->jumlah_masuk*$data[$i]["konversi_nilai"],3);;
						$data[$i]["jumlah_keluar"]=round($ds_mutasi->jumlah_keluar*$data[$i]["konversi_nilai"],3);;
						$data[$i]["jumlah_koreksi"]=round($ds_mutasi->jumlah_koreksi*$data[$i]["konversi_nilai"],3);
						$data[$i]["jumlah_stok"]=round(($data[$i]["jumlah_awal"]+$data[$i]["jumlah_masuk"]+$data[$i]["jumlah_koreksi"]-$data[$i]["jumlah_keluar"]),3);
						
					}else{
						$data[$i]["jumlah_masuk"]=0;
						$data[$i]["jumlah_keluar"]=0;
						$data[$i]["jumlah_koreksi"]=0;
						$data[$i]["jumlah_stok"]=round(($data[$i]["jumlah_awal"]+$data[$i]["jumlah_masuk"]+$data[$i]["jumlah_koreksi"]-$data[$i]["jumlah_keluar"]),3);
					}
					$i++;
				}

			}
			
			if($nbrows>0){
				
				$jsonresult = json_encode($data);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
			
		}
		
		//function for get list record
		function vu_stok_all_saldo_list($tgl_awal,$periode,$opsi_produk,$group1_id,$produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$filter,$start,$end){
			
			if($opsi_satuan=='terkecil')
				$sql="SELECT distinct * FROM vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			else
				$sql="SELECT distinct * FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";

			if ($periode == 'bulan'){
				$isiperiode="'%Y-%m')='".$tgl_awal."'" ;
				$isistart="'%Y-%m-%d')<'".$tgl_awal."-01'" ;
			}else if($periode == 'tanggal'){
				$isiperiode="'%Y-%m-%d') BETWEEN '".$tanggal_start."'
								AND '".$tanggal_end."'";
				$isistart="'%Y-%m-%d')<'".$tanggal_start."'" ;
			}	
			
			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_group='".$group1_id."' ";
				//$opsi="	produk_group='".$group1_id."' AND ";
			}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_id='".$produk_id."' ";
				//$opsi="	 produk_id='".$rowproduk->produk_id."' AND ";
			}

			
			if($filter!==""&&$filter!==NULL){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_kode LIKE '%".addslashes($filter)."%' OR
						produk_nama LIKE '%".addslashes($filter)."%' ";
			}
			
			$query_first=$this->db->query($sql);
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
			if($produk_id=="")
				$sql = $sql." LIMIT ".$start.",".$end;		
			
			//echo $sql;
			
			$result = $this->db->query($sql); 
			$i=0;
			
			foreach($result->result() as $rowproduk){
	
				$data[$i]["produk_id"]=$rowproduk->produk_id;
				$data[$i]["produk_kode"]=$rowproduk->produk_kode;
				$data[$i]["tanggal_start"]=$tanggal_start;
				$data[$i]["tanggal_end"]=$tanggal_end;
				$data[$i]["produk_nama"]=$rowproduk->produk_nama;
				$data[$i]["satuan_id"]=$rowproduk->satuan_id;
				$data[$i]["satuan_kode"]=$rowproduk->satuan_kode;
				$data[$i]["satuan_nama"]=$rowproduk->satuan_nama;	
				if($opsi_satuan=='terkecil')
					$data[$i]["konversi_nilai"]=1;
				else
					$data[$i]["konversi_nilai"]=1/$rowproduk->konversi_nilai;

				$sql_stok=$this->get_stok_query($tgl_awal,$periode,$rowproduk->produk_id,$tanggal_start,$tanggal_end,0,$isiperiode);
				$rsdata=$this->db->query($sql_stok);
				
				if($rsdata->num_rows()){
					$row=$rsdata->row();
					$data[$i]["stok_awal"]=$this->get_stok_awal($tgl_awal,$periode,$rowproduk->produk_id,$tanggal_start,0,$isiperiode)*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_terima"]=$row->jumlah_terima*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_masuk"]=$row->jumlah_masuk*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_keluar"]=$row->jumlah_keluar*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_retur_beli"]=$row->jumlah_retur_beli*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_jual"]=$row->jumlah_jual*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_retur_produk"]=$row->jumlah_retur_produk*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_retur_paket"]=$row->jumlah_retur_paket*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_koreksi"]=$row->jumlah_koreksi*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_pakai_cabin"]=$row->jumlah_pakai_cabin*$data[$i]["konversi_nilai"];
					$data[$i]["stok_saldo"]=round($data[$i]["stok_awal"]+$data[$i]["jumlah_terima"]+$data[$i]["jumlah_masuk"]-$data[$i]["jumlah_keluar"]-$data[$i]["jumlah_retur_beli"]-$data[$i]["jumlah_jual"]+$data[$i]["jumlah_retur_produk"]+$data[$i]["jumlah_retur_paket"]+$data[$i]["jumlah_koreksi"]-$data[$i]["jumlah_pakai_cabin"],3);	
				}else{
					$data[$i]["stok_awal"]=$this->get_stok_awal($tgl_awal,$periode,$rowproduk->produk_id,$tanggal_start,0,$isiperiode)*$data[$i]["konversi_nilai"];
					$data[$i]["jumlah_terima"]=0;
					$data[$i]["jumlah_masuk"]=0;
					$data[$i]["jumlah_keluar"]=0;
					$data[$i]["jumlah_retur_beli"]=0;
					$data[$i]["jumlah_jual"]=0;
					$data[$i]["jumlah_retur_produk"]=0;
					$data[$i]["jumlah_retur_paket"]=0;
					$data[$i]["jumlah_koreksi"]=0;
					$data[$i]["jumlah_pakai_cabin"]=0;
					$data[$i]["stok_saldo"]=round($data[$i]["stok_awal"]+$data[$i]["jumlah_terima"]+$data[$i]["jumlah_masuk"]-$data[$i]["jumlah_keluar"]-$data[$i]["jumlah_retur_beli"]-$data[$i]["jumlah_jual"]+$data[$i]["jumlah_retur_produk"]+$data[$i]["jumlah_retur_paket"]+$data[$i]["jumlah_koreksi"]-$data[$i]["jumlah_pakai_cabin"],3);
				}
				$i++;

			}
			
			if($nbrows>0){
				
				$jsonresult = json_encode($data);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		
	
		//function for advanced search record
		function vu_stok_all_saldo_search($group1_id,$opsi_produk,$produk_kode ,$produk_nama,$satuan_nama ,$stok_saldo ,$start,$end){
			//full query
			$query="select * from vu_stok_all_saldo";
			
			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_group='".$group1_id."' ";
			}elseif($opsi_produk=='produk' & $produk_kode!=="" & $produk_kode!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_id='".$produk_kode."' ";
			}
			
			/*if($produk_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_id LIKE '%".$produk_kode."%'";
			};*/
			if($produk_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_nama LIKE '%".$produk_nama."%'";
			};
			if($satuan_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_nama LIKE '%".$satuan_nama."%'";
			};
			if($stok_saldo!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " stok_saldo LIKE '%".$stok_saldo."%'";
			};
			
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
		function vu_stok_all_saldo_print($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from vu_stok_all_saldo";
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
		function vu_stok_all_saldo_export_excel($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from vu_stok_all_saldo";
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