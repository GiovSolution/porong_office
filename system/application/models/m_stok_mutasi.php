<?
/*
	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: stok_mutasi Model
	+ Description	: For record model process back-end
	+ Filename 		: c_stok_mutasi.php
 	+ creator 		:
 	+ Created on 09/Apr/2010 10:47:15
*/

class M_stok_mutasi extends Model{

		//constructor
		function M_stok_mutasi() {
			parent::Model();
		}

		function get_produk_list($filter,$start,$end){
			$sql="select * from vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			if($filter<>""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="( produk_kode LIKE '%".addslashes($filter)."%' OR
						 produk_nama LIKE '%".addslashes($filter)."%' OR
						 satuan_kode LIKE '%".addslashes($filter)."%' OR
						 satuan_nama LIKE '%".addslashes($filter)."%')";
			}
			$sql.=" order by produk_nama";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$limit = $sql." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit);
			//$this->firephp->log($sql);

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

		function stok_mutasi_list($bulan, $tahun,$tgl_awal,$periode,$gudang, $produk_id, $group1_id, $opsi_produk, $opsi_satuan, $tanggal_start,
													   $tanggal_end,$query,$start,$end, $mutasi_jumlah, $stok_akhir,$stok_awal,$stok_masuk,$stok_keluar){
			
			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			}									   
													   
													   
			$sql="select * from stok_mutasi sm,produk pr, satuan
					WHERE sm.produk_id=pr.produk_id
					AND satuan.satuan_id=sm.satuan_id
					AND (date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."')
								AND gudang_id='".$gudang."'";

			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_group='".$group1_id."' ";
			}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_id='".$produk_id."' ";
			}

			
			if($stok_akhir=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir = '0' ";
			}elseif($stok_akhir=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir < '0' ";
			}elseif($stok_akhir=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir > '0' ";
			}elseif($stok_akhir=='!='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir <> '0' ";
			}
			
			if($stok_awal=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal = '0' ";
			}elseif($stok_awal=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal < '0' ";
			}elseif($stok_awal=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal > '0' ";
			}
			
			if($stok_masuk=='S'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk like '%' ";
			}elseif($stok_masuk=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk = '0' ";
			}elseif($stok_masuk=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk < '0' ";
			}elseif($stok_masuk=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk > '0' ";
			}
			
			if($stok_keluar=='S'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar like '%' )";
			}elseif($stok_keluar=='='){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar = '0' )";
			}elseif($stok_keluar=='<'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar < '0' )";
			}elseif($stok_keluar=='> 0'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar > '0' )";
			}

			$sql.=" ORDER BY pr.produk_kode ";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$limit = $sql." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit);
			//$this->firephp->log($limit);

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

		function stok_mutasi_print($gudang, $produk_id, $group1_id, $opsi_produk, 
										$opsi_satuan, $tanggal_start, $tanggal_end, 
										$query,$start,$end, $mutasi_jumlah, $stok_akhir	,$stok_awal,$stok_masuk,$stok_keluar,$bulan, $tahun, $periode, $tgl_awal){

			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			}							
										
										
			$sql="select * from stok_mutasi sm,produk pr, satuan
					WHERE sm.produk_id=pr.produk_id
					AND satuan.satuan_id=sm.satuan_id
					AND (date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."')
								AND gudang_id='".$gudang."'";

			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_group='".$group1_id."' ";
			}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_id='".$produk_id."' ";
			}

			
			if($stok_akhir=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir = '0' ";
			}elseif($stok_akhir=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir < '0' ";
			}elseif($stok_akhir=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir > '0' ";
			}elseif($stok_akhir=='!='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir <> '0' ";
			}
			
			if($stok_awal=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal = '0' ";
			}elseif($stok_awal=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal < '0' ";
			}elseif($stok_awal=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal > '0' ";
			}
			
			if($stok_masuk=='S'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk like '%' ";
			}elseif($stok_masuk=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk = '0' ";
			}elseif($stok_masuk=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk < '0' ";
			}elseif($stok_masuk=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk > '0' ";
			}
			
			if($stok_keluar=='S'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar like '%' )";
			}elseif($stok_keluar=='='){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar = '0' )";
			}elseif($stok_keluar=='<'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar < '0' )";
			}elseif($stok_keluar=='> 0'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar > '0' )";
			}

			$sql.=" ORDER BY pr.produk_kode ";

			$result = $this->db->query($sql);
			if($result->num_rows())
				return $result->result();
			else
				return NULL;

		}
		
		/* Function for Eksport 2 Excel*/
		function stok_mutasi_export_excel($bulan, $tahun, $tgl_awal,$periode,$gudang, $produk_id, $group1_id, $opsi_produk, 
																$opsi_satuan, $tanggal_start, $tanggal_end, 
																$mutasi_jumlah, $stok_akhir	,$stok_awal,$stok_masuk,$stok_keluar,$option,$filter){

			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			}
			
			$sql="select pr.produk_kode, pr.produk_nama, satuan.satuan_nama,
						sm.stok_awal, sm.stok_masuk, sm.stok_keluar, sm.stok_akhir
					from stok_mutasi sm,produk pr, satuan
					WHERE sm.produk_id=pr.produk_id
					AND satuan.satuan_id=sm.satuan_id
					AND (date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
					AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."')
					AND gudang_id='".$gudang."'";

			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_group='".$group1_id."' ";
			}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	pr.produk_id='".$produk_id."' ";
			}

			
			if($stok_akhir=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir = '0' ";
			}elseif($stok_akhir=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir < '0' ";
			}elseif($stok_akhir=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir > '0' ";
			}elseif($stok_akhir=='!='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_akhir <> '0' ";
			}
			
			if($stok_awal=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal = '0' ";
			}elseif($stok_awal=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal < '0' ";
			}elseif($stok_awal=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	sm.stok_awal > '0' ";
			}
			
			if($stok_masuk=='S'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk like '%' ";
			}elseif($stok_masuk=='='){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk = '0' ";
			}elseif($stok_masuk=='<'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk < '0' ";
			}elseif($stok_masuk=='> 0'){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	(sm.stok_masuk > '0' ";
			}
			
			if($stok_keluar=='S'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar like '%' )";
			}elseif($stok_keluar=='='){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar = '0' )";
			}elseif($stok_keluar=='<'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar < '0' )";
			}elseif($stok_keluar=='> 0'){
				$sql.=eregi("WHERE",$sql)?" OR ":" WHERE ";
				$sql.="	sm.stok_keluar > '0' )";
			}
			
			$sql.=" ORDER BY pr.produk_kode ";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($nbrows>0)
				return $result;
			else
				return NULL;

		}
		

		function generate_stok_mutasi($bulan, $tahun, $periode, $gudang, $produk_id, $group1_id, $opsi_produk, $opsi_satuan, $tanggal_start,
									  $tanggal_end, $mutasi_jumlah, $stok_akhir	,$stok_awal, $stok_masuk, $stok_keluar){

			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			}
			
			//DELETE ALL REPORT
			$sql="DELETE FROM stok_mutasi
					WHERE date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
					AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
					AND gudang_id='".$gudang."'";
						
			$result=$this->db->query($sql);

			if($opsi_satuan=='terkecil')
				$sql="SELECT * FROM vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			else
				$sql="SELECT * FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";

			if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_group='".$group1_id."' ";
			}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="	produk_id='".$produk_id."' ";
			}

			//$this->firephp->log($sql);

			$sql.=" GROUP BY produk_kode ASC";
			$result=$this->db->query($sql) or die("ERROR-0 : ".$sql);;


			//INSERT KE TEMPORARY STOK_MUTASI
			if($result->num_rows()){

				if($opsi_satuan=='terkecil'){
					$sqlinsert="INSERT INTO stok_mutasi(produk_id,satuan_id,gudang_id,tanggal_awal,tanggal_akhir)
								SELECT 	produk_id,satuan_id,".$gudang.",date_format('".$tanggal_start."','%Y-%m-%d'),
										date_format('".$tanggal_end."','%Y-%m-%d')
								FROM vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
				}else{
					$sqlinsert="INSERT INTO stok_mutasi(produk_id,satuan_id,gudang_id,tanggal_awal,tanggal_akhir)
								SELECT 	produk_id,satuan_id,".$gudang.",date_format('".$tanggal_start."','%Y-%m-%d'),
										date_format('".$tanggal_end."','%Y-%m-%d')
								FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";

				}

				if($opsi_produk=='group1' & $group1_id!=="" & $group1_id!==0){
					$sqlinsert.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sqlinsert.="	produk_group='".$group1_id."' ";
				}elseif($opsi_produk=='produk' & $produk_id!=="" & $produk_id!==0){
					$sqlinsert.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sqlinsert.="	produk_id='".$produk_id."' ";
				}

				//$this->firephp->log($sqlinsert);

				$sqlinsert.=" GROUP BY produk_kode ASC";
				$this->db->query($sqlinsert) or die("ERROR-1 : ".$sqlinsert);

			}


			foreach($result->result() as $rowproduk){

			//Stok Awal
			$sqlawal="SELECT 	produk_saldo_awal*konversi_nilai/".$rowproduk->konversi_nilai." as jumlah
						FROM 	produk, satuan_konversi
						WHERE 	konversi_produk=produk_id
						AND 	konversi_default=true
						AND		produk_id='".$rowproduk->produk_id."'";
			//$this->firephp->log($sqlawal);

			$rsawal=$this->db->query($sqlawal) or die("ERROR-1.1 : ".$sqlawal);
			if($rsawal->num_rows()){
				$row=$rsawal->row();
				$sqlupdate="UPDATE stok_mutasi SET stok_awal='".$row->jumlah."'
							WHERE produk_id='".$rowproduk->produk_id."'
							AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
							AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
							AND gudang_id='1'";

				//$this->firephp->log($sqlupdate);

				$this->db->query($sqlupdate) or die("ERROR-2 : ".$sqlupdate);
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
									AND date_format(mutasi_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
									AND date_format(mutasi_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
									AND date_format(koreksi_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
									AND dkoreksi_produk='".$rowproduk->produk_id."'
									AND koreksi_gudang='".$gudang."'
									AND koreksi_status='Tertutup'
							UNION SELECT `mt`.`terima_tanggal` AS `tanggal`,
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
											AND date_format(terima_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
										   AND date_format(terima_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
											AND date_format(rbeli_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
											AND date_format(cabin_date_create,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
													AND date_format(jproduk_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
													AND date_format(jpgrooming_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
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
													AND date_format(rproduk_tanggal,'%Y-%m-%d')<date_format('".$tanggal_start."','%Y-%m-%d')
													AND drproduk_produk='".$rowproduk->produk_id."'
													AND 2='".$gudang."'
													AND rproduk_stat_dok='Tertutup'";
				}

				$sql_stok_awal.= ") as mutasi
									GROUP BY mutasi.produk
									ORDER BY mutasi.produk ";
				//$this->firephp->log($sql_stok_awal);

				$rstawal=$this->db->query($sql_stok_awal) or die("ERROR-3 : ".$sql_stok_awal);;
				if($rstawal->num_rows()){
					$row=$rstawal->row();
					$sqlupdate="UPDATE stok_mutasi SET stok_awal=stok_awal+'".$row->jumlah_awal."'
								WHERE produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";
					//$this->firephp->log($sql_stok_awal);

					$this->db->query($sqlupdate) or die("ERROR-4 : ".$sql_stok_awal);
				}

				//MUTASINYA DI SINI

				//MUTASI MASUK
				$sqlupdate="UPDATE stok_mutasi M SET stok_masuk=stok_masuk+ifnull((

						SELECT 	sum(dt.dmutasi_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as masuk
						  FROM `detail_mutasi` `dt`, `master_mutasi` `mt`, satuan_konversi, gudang gd
						 WHERE  `dt`.`dmutasi_master` = `mt`.`mutasi_id`
								AND mt.mutasi_asal=gd.gudang_id
								AND konversi_satuan = dt.dmutasi_satuan
								AND konversi_produk = dt.dmutasi_produk
								AND date_format(mutasi_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(mutasi_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dmutasi_produk='".$rowproduk->produk_id."'
								AND mutasi_status='Tertutup'
								AND mutasi_tujuan='".$gudang."'
								AND M.produk_id=dt.dmutasi_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-8 : ".$sqlupdate);

				//MUTASI KELUAR
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

						SELECT 	sum(dt.dmutasi_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as keluar
						  FROM `detail_mutasi` `dt`, `master_mutasi` `mt`, satuan_konversi, gudang gd
						 WHERE  `dt`.`dmutasi_master` = `mt`.`mutasi_id`
								AND mt.mutasi_tujuan=gd.gudang_id
								AND konversi_satuan = dt.dmutasi_satuan
								AND konversi_produk = dt.dmutasi_produk
								AND date_format(mutasi_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(mutasi_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dmutasi_produk='".$rowproduk->produk_id."'
								AND mutasi_status='Tertutup'
								AND mutasi_asal='".$gudang."'
								AND M.produk_id=dt.dmutasi_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";
				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-9 : ".$sqlupdate);

				//KOREKSI MASUK
				$sqlupdate="UPDATE stok_mutasi M SET stok_masuk=stok_masuk+ifnull((

						SELECT 	sum(dt.dkoreksi_jmlkoreksi*konversi_nilai/".$rowproduk->konversi_nilai.") as masuk
						  FROM `detail_koreksi_stok` `dt`, `master_koreksi_stok` `mt`, satuan_konversi, gudang gd
						 WHERE     `dt`.`dkoreksi_master` = `mt`.`koreksi_id`
								AND mt.koreksi_gudang=gd.gudang_id
								AND konversi_satuan = dt.dkoreksi_satuan
								AND konversi_produk = dt.dkoreksi_produk
								AND date_format(koreksi_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(koreksi_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dkoreksi_produk='".$rowproduk->produk_id."'
								AND koreksi_status='Tertutup'
								AND koreksi_gudang='".$gudang."'
								AND dt.dkoreksi_jmlkoreksi>0
								AND M.produk_id=dt.dkoreksi_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-10 : ".$sqlupdate);

				//KOREKSI KELUAR
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

						SELECT 	abs(sum(dt.dkoreksi_jmlkoreksi*konversi_nilai/".$rowproduk->konversi_nilai.")) as keluar
						  FROM `detail_koreksi_stok` `dt`, `master_koreksi_stok` `mt`, satuan_konversi, gudang gd
						 WHERE   `dt`.`dkoreksi_master` = `mt`.`koreksi_id`
								AND mt.koreksi_gudang=gd.gudang_id
								AND konversi_satuan = dt.dkoreksi_satuan
								AND konversi_produk = dt.dkoreksi_produk
								AND date_format(koreksi_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(koreksi_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dkoreksi_produk='".$rowproduk->produk_id."'
								AND koreksi_status='Tertutup'
								AND koreksi_gudang='".$gudang."'
								AND dt.dkoreksi_jmlkoreksi<0
								AND M.produk_id=dt.dkoreksi_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-11 : ".$sqlupdate);

				//PENERIMAAN BARANG
				$sqlupdate="UPDATE stok_mutasi M SET stok_masuk=stok_masuk+ifnull((

						SELECT 	sum(dt.dterima_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as masuk
						  FROM `detail_terima_beli` `dt`, `master_terima_beli` `mt`, satuan_konversi
						 WHERE     `dt`.`dterima_master` = `mt`.`terima_id`
									AND konversi_satuan = dt.dterima_satuan
								AND konversi_produk = dt.dterima_produk
								AND date_format(terima_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(terima_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dterima_produk='".$rowproduk->produk_id."'
								AND terima_status='Tertutup'
								AND `mt`.`terima_gudang_id`=".$gudang."
								AND M.produk_id=dt.dterima_produk),0)
					WHERE produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";
				//$this->firephp->log($sqlupdate);
				$this->db->query($sqlupdate) or die("ERROR-5 : ".$sqlupdate);

				//PENERIMAAN BARANG BONUS
				$sqlupdate="UPDATE stok_mutasi M SET stok_masuk=stok_masuk+ifnull((

						SELECT 	sum(dt.dtbonus_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as masuk
						  FROM `detail_terima_bonus` `dt`, `master_terima_beli` `mt`, satuan_konversi
						 WHERE  `dt`.`dtbonus_master` = `mt`.`terima_id`
								AND konversi_satuan = dt.dtbonus_satuan
								AND konversi_produk = dt.dtbonus_produk
								AND date_format(terima_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(terima_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dtbonus_produk='".$rowproduk->produk_id."'
								AND terima_status='Tertutup'
								AND `mt`.`terima_gudang_id`=".$gudang."
								AND M.produk_id=dt.dtbonus_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";
				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-6 : ".$sqlupdate);

		if($gudang==1){


				//RETUR PEMBELIAN
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

						SELECT 	sum(dt.drbeli_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as keluar
						  FROM `detail_retur_beli` `dt`, `master_retur_beli` `mt`, satuan_konversi
						 WHERE  `dt`.`drbeli_master` = `mt`.`rbeli_id`
								AND konversi_satuan = dt.drbeli_satuan
								AND konversi_produk = dt.drbeli_produk
								AND date_format(rbeli_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(rbeli_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND drbeli_produk='".$rowproduk->produk_id."'
								AND rbeli_status='Tertutup'
								AND 1 =".$gudang."
								AND M.produk_id=dt.drbeli_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";
				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-7 : ".$sqlupdate);
		}elseif($gudang==4 || $gudang==3){
				//PAKAI CABIN
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

								SELECT 	sum(cabin_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as keluar
						  FROM  detail_pakai_cabin, satuan_konversi
						 WHERE  konversi_satuan = cabin_satuan
								AND konversi_produk = cabin_produk
								AND date_format(cabin_date_create,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(cabin_date_create,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND cabin_produk='".$rowproduk->produk_id."'
								AND M.produk_id=cabin_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-15 : ".$sqlupdate);
		}elseif($gudang==2){
				//PENJUALAN PRODUK
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

						 SELECT sum(dt.dproduk_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as keluar
						  FROM `detail_jual_produk` `dt`, `master_jual_produk` `mt`, satuan_konversi
						 WHERE  `dt`.`dproduk_master` = `mt`.`jproduk_id`
								AND konversi_satuan = dt.dproduk_satuan
								AND konversi_produk = dt.dproduk_produk
								AND date_format(jproduk_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(jproduk_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dproduk_produk='".$rowproduk->produk_id."'
								AND jproduk_stat_dok='Tertutup'
								AND M.produk_id=dt.dproduk_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-12 : ".$sqlupdate);

				//RETUR PENJUALAN PRODUK
				$sqlupdate="UPDATE stok_mutasi M SET stok_masuk=stok_masuk+ifnull((

								SELECT 	sum(dt.drproduk_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as masuk
						  FROM `detail_retur_jual_produk` `dt`, `master_retur_jual_produk` `mt`, satuan_konversi
						 WHERE  `dt`.`drproduk_master` = `mt`.`rproduk_id`
								AND konversi_satuan = dt.drproduk_satuan
								AND konversi_produk = dt.drproduk_produk
								AND date_format(rproduk_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(rproduk_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND drproduk_produk='".$rowproduk->produk_id."'
								AND rproduk_stat_dok='Tertutup'
								AND M.produk_id=dt.drproduk_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-13 : ".$sqlupdate);

				//PENJUALAN PRODUK GROOMING
				$sqlupdate="UPDATE stok_mutasi M SET stok_keluar=stok_keluar+ifnull((

								SELECT 	sum(dt.dpgrooming_jumlah*konversi_nilai/".$rowproduk->konversi_nilai.") as keluar
						  FROM `detail_jualproduk_grooming` `dt`, `master_jualproduk_grooming` `mt`, satuan_konversi
						 WHERE  `dt`.`dpgrooming_master` = `mt`.`jpgrooming_id`
								AND konversi_satuan = dt.dpgrooming_satuan
								AND konversi_produk = dt.dpgrooming_produk
								AND date_format(jpgrooming_tanggal,'%Y-%m-%d')>=date_format('".$tanggal_start."','%Y-%m-%d')
								AND date_format(jpgrooming_tanggal,'%Y-%m-%d')<=date_format('".$tanggal_end."','%Y-%m-%d')
								AND dpgrooming_produk='".$rowproduk->produk_id."'
								AND M.produk_id=dt.dpgrooming_produk),0)
						WHERE 	produk_id='".$rowproduk->produk_id."'
								AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
								AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
								AND gudang_id='".$gudang."'";

				//$this->firephp->log($sqlupdate);
				$result=$this->db->query($sqlupdate) or die("ERROR-14 : ".$sqlupdate);
		}


				$sql_update="UPDATE stok_mutasi SET stok_akhir=stok_awal+stok_masuk-stok_keluar
							WHERE 	produk_id='".$rowproduk->produk_id."'
									AND date_format(tanggal_awal,'%Y-%m-%d')='".$tanggal_start."'
									AND date_format(tanggal_akhir,'%Y-%m-%d')='".$tanggal_end."'
									AND gudang_id='".$gudang."'";
				//$this->firephp->log($sqlupdate);

				$result=$this->db->query($sql_update) or die("ERROR-16 : ".$sql_update);

			}



			return '1';
		}


}
?>