<? /* 	
	
	+ Module  		: Top Spender Model
	+ Description	: For record model process back-end
	+ Filename 		: c_report_rekap_penjuualan.php
 	+ Author  		: Isaac
	Edited by		: Fred

*/

class M_report_rekap_penjualan extends Model{
		
	//constructor
	function M_report_rekap_penjualan() {
		parent::Model();
	}


	/* INSERT ke db.history_ambil_paket */
	/*
	function history_ambil_paket_insert($dpaket_id, $rpaket_perawatan, $trawat_cust, $dtrawat_id, $dtrawat_dapp){
		$dti_hapaket=array(
		"hapaket_dpaket"=>$dpaket_id,
		"hapaket_rawat"=>$rpaket_perawatan,
		"hapaket_jumlah"=>1,
		"hapaket_cust"=>$trawat_cust,
		"hapaket_dtrawat"=>$dtrawat_id
		);
		$this->db->insert('history_ambil_paket', $dti_hapaket);
		if($this->db->affected_rows()){
	
			$dtu_dapp=array(
			"dapp_locked"=>1
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
			
			$dtu_dtrawat=array(
			"dtrawat_ambil_paket"=>'true'
			);
			$this->db->where('dtrawat_id', $dtrawat_id);
			$this->db->update('tindakan_detail', $dtu_dtrawat);
		}
	}*/
	/* eof history_ambil_paket_insert */
	
	/* INSERT ke db.history_ambil_paket */
	/*
	function history_ambil_paket_delete($dtrawat_id, $dtrawat_dapp){
		$this->db->where('hapaket_dtrawat', $dtrawat_id);
		$this->db->delete('history_ambil_paket');
		if($this->db->affected_rows()){

			$dtu_dapp=array(
			"dapp_locked"=>0
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
		}
	}*/
	/* eof history_ambil_paket_insert */

	//function for advanced search record
	function rekap_penjualan_search($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1, $start,$end){
			//full query
			if ($rekap_penjualan_jenis == '')
				$rekap_penjualan_jenis = 'Produk';

			if ($rekap_penjualan_jenis == 'Perawatan')
			{
				$query = "SELECT perawatan.rawat_kode AS kode, perawatan.rawat_nama AS nama, 
					SUM(detail_jual_rawat.drawat_jumlah) AS total_jumlah,
					SUM(detail_jual_rawat.drawat_jumlah) AS tot_jum_item,
					SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) AS subtotal,
					SUM((master_jual_rawat.jrawat_diskon * ((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) AS tot_net
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				$query.=" GROUP BY detail_jual_rawat.drawat_rawat ORDER BY grand_total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Produk')
			{
				$query = "SELECT produk.produk_id AS produk_id, produk.produk_kode AS kode, produk.produk_nama AS nama, 
					SUM(detail_jual_produk.dproduk_jumlah) AS total_jumlah,

					SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) AS subtotal,

					SUM((master_jual_produk.jproduk_diskon * ((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100) AS diskon_tambahan,

					(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
					SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) AS grand_total,

					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah) 
					 FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS jum_retur, 

					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
					FROM detail_retur_jual_produk 
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_retur,

					SUM(detail_jual_produk.dproduk_jumlah)-
					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
					FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_jum_item,

					(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
					SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
					FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_net
					
					FROM detail_jual_produk
					LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
					LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id";
				
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group_1!='Semua' && $rekap_penjualan_group_1!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk.produk_group='".$rekap_penjualan_group_1."'";
				}
				$query.="GROUP BY detail_jual_produk.dproduk_produk ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Paket')
			{
				$query = "SELECT paket.paket_kode AS kode, paket.paket_nama AS nama, 
					SUM(detail_jual_paket.dpaket_jumlah) AS total_jumlah,
					SUM(detail_jual_paket.dpaket_jumlah) AS tot_jum_item,
					SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) AS subtotal,
					SUM((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS tot_net

					FROM detail_jual_paket
					LEFT JOIN master_jual_paket ON detail_jual_paket.dpaket_master = master_jual_paket.jpaket_id
					LEFT JOIN paket ON detail_jual_paket.dpaket_paket = paket.paket_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}
				$query.="GROUP BY detail_jual_paket.dpaket_paket ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Pengambilan_Paket')
			{
				$query = "select `perawatan`.`rawat_kode` AS kode,`perawatan`.`rawat_nama` AS nama,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS total_jumlah,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS tot_jum_item,
					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)) AS subtotal,

					0 AS diskon_tambahan,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)) AS grand_total,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)) AS tot_net

					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id)))";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "date_format(detail_ambil_paket.dapaket_tgl_ambil, '%Y-%m-%d') BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "date_format(detail_ambil_paket.dapaket_tgl_ambil, '%Y-%m-%d')='".$rekap_penjualan_tglapp_start."' AND detail_ambil_paket.dapaket_stat_dok  = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}			
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				$query.=" GROUP BY `perawatan`.`rawat_kode` ORDER BY grand_total DESC";
				
			}
			
			$start = 0;
			$end = 10000;
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
		
		function rekap_penjualan_search2($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1,$start,$end){
			//full query
			$voucher = 0;
			if ($rekap_penjualan_jenis == '')
				$rekap_penjualan_jenis = 'Produk';

			if ($rekap_penjualan_jenis == 'Perawatan')
			{
				// hitung voucher
				if ($rekap_penjualan_group == 3)
				{
					$query_v = "select ifnull(sum(m.jrawat_cashback), 0) as voucher
							from master_jual_rawat m
							where 
								m.jrawat_stat_dok = 'Tertutup'";
					if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
						$query_v.=eregi("WHERE",$query_v)?" AND ":" WHERE ";
						$query_v.= " m.jrawat_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."'";
					}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
						$query_v.=eregi("WHERE",$query_v)?" AND ":" WHERE ";
						$query_v.= " m.jrawat_tanggal='".$rekap_penjualan_tglapp_start."'";
					}
					$query_sql= $this->db->query($query_v);
					$data_sql= $query_sql->row();
					$voucher= $data_sql->voucher;
					
				}
				// eof hitung voucher
				$query = "SELECT 
					SUM(detail_jual_rawat.drawat_jumlah) AS total_jumlah,
					SUM(detail_jual_rawat.drawat_jumlah) AS tot_jum_item,
					SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) AS subtotal,
					SUM((master_jual_rawat.jrawat_diskon * ((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) - ".$voucher." AS tot_net
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				//$query.="GROUP BY detail_jual_rawat.drawat_rawat ORDER BY grand_total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Produk')
			{
				// hitung voucher
				$query_v = "select ifnull(sum(m.jproduk_cashback), 0) as voucher
							from master_jual_produk m
							where 
								m.jproduk_stat_dok = 'Tertutup'";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query_v.=eregi("WHERE",$query_v)?" AND ":" WHERE ";
					$query_v.= " m.jproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query_v.=eregi("WHERE",$query_v)?" AND ":" WHERE ";
					$query_v.= " m.jproduk_tanggal='".$rekap_penjualan_tglapp_start."'";
				}
				$query_sql= $this->db->query($query_v);
				$data_sql= $query_sql->row();
				$voucher= $data_sql->voucher;
				// eof hitung voucher
				
			
				$query = "SELECT SUM(detail_jual_produk.dproduk_jumlah) AS total_jumlah,

					SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) AS subtotal,

					SUM((master_jual_produk.jproduk_diskon * ((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100) AS diskon_tambahan,

					(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
					SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) AS grand_total,

					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah) 
					 FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' ),0) AS jum_retur, 

					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
					FROM detail_retur_jual_produk 
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' ),0) AS tot_retur,

					SUM(detail_jual_produk.dproduk_jumlah)-
					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
					FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' ),0) AS tot_jum_item,

					(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
					SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
					IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
					FROM detail_retur_jual_produk
					LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
					WHERE master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' ),0) - ".$voucher."  AS tot_net
					
					FROM detail_jual_produk
					LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
					LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group_1!='Semua' && $rekap_penjualan_group_1!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk.produk_group='".$rekap_penjualan_group_1."'";
				}
				//$query.="GROUP BY detail_jual_produk.dproduk_produk ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Paket')
			{
				$query = "SELECT 
					SUM(detail_jual_paket.dpaket_jumlah) AS total_jumlah,
					SUM(detail_jual_paket.dpaket_jumlah) AS tot_jum_item,
					SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) AS subtotal,
					SUM((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS tot_net
					FROM detail_jual_paket
					LEFT JOIN master_jual_paket ON detail_jual_paket.dpaket_master = master_jual_paket.jpaket_id
					LEFT JOIN paket ON detail_jual_paket.dpaket_paket = paket.paket_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}
				//$query.="GROUP BY detail_jual_paket.dpaket_paket ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Pengambilan_Paket')
			{
					$query = "select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS total_jumlah,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS tot_jum_item,
					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS subtotal,

					0 AS diskon_tambahan,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS grand_total,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS tot_net
					
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id)))";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil='".$rekap_penjualan_tglapp_start."' AND detail_ambil_paket.dapaket_stat_dok  = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}			
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				//$query.=" ORDER BY grand_total DESC";
			}
			$start = 0;
			$end = 10000;
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
		
		function rekap_penjualan_search3($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1, $start,$end){
			//full query
			if ($rekap_penjualan_jenis == '')
				$rekap_penjualan_jenis = 'Produk';

			if ($rekap_penjualan_jenis == 'Perawatan')
			{
				$query = "select ifnull(sum(m.jrawat_cashback), 0) as voucher,
								 ifnull(sum(m.jrawat_cashback_medis), 0) as voucher_medis
						from master_jual_rawat m
						where 
							m.jrawat_stat_dok = 'Tertutup'";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jrawat_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jrawat_tanggal='".$rekap_penjualan_tglapp_start."'";
				}
				/*
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				*/
				//$query.="GROUP BY detail_jual_rawat.drawat_rawat ORDER BY grand_total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Produk')
			{
				$query = "select ifnull(sum(m.jproduk_cashback), 0) as voucher
							from master_jual_produk m
							where 
								m.jproduk_stat_dok = 'Tertutup'";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jproduk_tanggal='".$rekap_penjualan_tglapp_start."'";
				}
				//$query.="GROUP BY detail_jual_produk.dproduk_produk ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Paket')
			{
				$query = "select ifnull(sum(m.jpaket_cashback), 0) as voucher
							from master_jual_paket m
							where 
								m.jpaket_stat_dok = 'Tertutup'";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jpaket_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.jpaket_tanggal='".$rekap_penjualan_tglapp_start."'";
				}
				
			}
			else if ($rekap_penjualan_jenis == 'Pengambilan_Paket')
			{
					$query = "select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS total_jumlah,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS tot_jum_item,
					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS subtotal,

					0 AS diskon_tambahan,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS grand_total,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * (((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)-(`master_jual_paket`.`jpaket_cashback`/ `master_jual_paket`.`jpaket_total_isi_paket`))) AS tot_net
					
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id)))";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil='".$rekap_penjualan_tglapp_start."' AND detail_ambil_paket.dapaket_stat_dok  = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}			
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				//$query.=" ORDER BY grand_total DESC";
			}
			$start = 0;
			$end = 10000;
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
		function tindakan_print( $rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1){
		//full query
		
			
			if ($rekap_penjualan_jenis == '')
				$rekap_penjualan_jenis = 'Produk';

			if ($rekap_penjualan_jenis == 'Perawatan')
			{
				$query = "SELECT perawatan.rawat_kode AS kode, perawatan.rawat_nama AS nama, 
					0 AS jum_retur, 0 AS tot_retur,
					SUM(detail_jual_rawat.drawat_jumlah) AS total_jumlah,
					SUM(detail_jual_rawat.drawat_jumlah) AS tot_jum_item,
					SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) AS subtotal,
					SUM((master_jual_rawat.jrawat_diskon * ((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100)) - 
					SUM((master_jual_rawat.jrawat_diskon *((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)-((detail_jual_rawat.drawat_jumlah * detail_jual_rawat.drawat_harga)*detail_jual_rawat.drawat_diskon/100))) /100)) AS tot_net
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				$query.=" GROUP BY detail_jual_rawat.drawat_rawat ORDER BY grand_total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Produk')
			{
				$query = "SELECT produk.produk_id AS produk_id, produk.produk_kode AS kode, produk.produk_nama AS nama, 
							SUM(detail_jual_produk.dproduk_jumlah) AS total_jumlah,

							SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) AS subtotal,

							SUM((master_jual_produk.jproduk_diskon * ((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100) AS diskon_tambahan,

							(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
							SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) AS grand_total,

							IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah) 
							 FROM detail_retur_jual_produk
							LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
							WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS jum_retur, 

							IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
							FROM detail_retur_jual_produk 
							LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
							WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_retur,

							SUM(detail_jual_produk.dproduk_jumlah)-
							IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
							FROM detail_retur_jual_produk
							LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
							WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_jum_item,

							(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
							SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
							IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
							FROM detail_retur_jual_produk
							LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
							WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup'	 GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS tot_net
							
							FROM detail_jual_produk
							LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
							LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " WHERE master_jual_produk.jproduk_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}
				if($rekap_penjualan_group_1!='Semua' && $rekap_penjualan_group_1!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk.produk_group='".$rekap_penjualan_group_1."'";
				}
				$query.="GROUP BY detail_jual_produk.dproduk_produk ORDER BY tot_net DESC";
			}
			else if ($rekap_penjualan_jenis == 'Paket')
			{
				$query = "SELECT paket.paket_kode AS kode, paket.paket_nama AS nama, 
					0 AS jum_retur, 0 AS tot_retur,
					SUM(detail_jual_paket.dpaket_jumlah) AS total_jumlah,
					SUM(detail_jual_paket.dpaket_jumlah) AS tot_jum_item,
					SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) AS subtotal,
					SUM((master_jual_paket.jpaket_diskon * ((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100) AS diskon_tambahan,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS grand_total,
					(SUM((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100)) - 
					SUM((master_jual_paket.jpaket_diskon *((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)-((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga)*detail_jual_paket.dpaket_diskon/100))) /100)) AS tot_net
					FROM detail_jual_paket
					LEFT JOIN master_jual_paket ON detail_jual_paket.dpaket_master = master_jual_paket.jpaket_id
					LEFT JOIN paket ON detail_jual_paket.dpaket_paket = paket.paket_id";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal='".$rekap_penjualan_tglapp_start."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}
				$query.="GROUP BY detail_jual_paket.dpaket_paket ORDER BY Grand_Total DESC";
			}
			else if ($rekap_penjualan_jenis == 'Pengambilan_Paket')
			{
				$query = "select `perawatan`.`rawat_kode` AS kode,`perawatan`.`rawat_nama` AS nama,
					0 AS jum_retur, 0 AS tot_retur,
					0 AS jum_retur, 0 AS tot_retur,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS total_jumlah,
					SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS tot_jum_item,
					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`)) AS subtotal,

					SUM((((((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`) AS diskon_tambahan,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`) -
(((((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`) AS grand_total,

					SUM(`detail_ambil_paket`.`dapaket_jumlah` * ((((((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100) * `detail_jual_paket`.`dpaket_jumlah`) - (((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`) -
(((((`master_jual_paket`.`jpaket_diskon` * ((`detail_jual_paket`.`dpaket_harga` * (100 - `detail_jual_paket`.`dpaket_diskon`)) / 100)) * `detail_jual_paket`.`dpaket_jumlah`) / 100)) / `detail_jual_paket`.`dpaket_jumlah`) / `vu_jumlah_isi_paket`.`isi_paket`) AS tot_net
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id)))";
				if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil BETWEEN '".$rekap_penjualan_tglapp_start."' AND '".$rekap_penjualan_tglapp_end."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($rekap_penjualan_tglapp_start!='' && $rekap_penjualan_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "detail_ambil_paket.dapaket_tgl_ambil='".$rekap_penjualan_tglapp_start."' AND detail_ambil_paket.dapaket_stat_dok  = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}			
				if($rekap_penjualan_group!='' && $rekap_penjualan_group!='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= "kategori.kategori_id = ".$rekap_penjualan_group."";
				}
				$query.=" GROUP BY `perawatan`.`rawat_kode` ORDER BY grand_total DESC";
				
			}
			
			//$start = 0;
			//$end = 10000;
			$result = $this->db->query($query);
			//$nbrows = $result->num_rows();
			
			//$limit = $query." LIMIT ".$start.",".$end;		
			//$result = $this->db->query($limit);    
			/*
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}*/
			return $result;
		}
		
		//function  for export to excel
		function tindakan_export_excel($trawat_id ,$trawat_dokter ,$option,$filter){
			//full query
			$query="select k.karyawan_username, p.rawat_nama, count(p.rawat_nama) as Jumlah_rawat, p.rawat_kredit, p.rawat_kredit*count(p.rawat_nama) as Total_kredit from tindakan_detail d left outer join karyawan k on k.karyawan_id=d.dtrawat_petugas1 left outer join perawatan p on p.rawat_id = d.dtrawat_perawatan";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (trawat_id LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_id LIKE '%".$trawat_id."%'";
				};
				if($trawat_dokter!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " karyawan_username LIKE '%".$trawat_dokter."%'";
				};
				/*if($rawat_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_nama LIKE '%".$rawat_nama."%'";
				};*/
				//$query.=" p.rawat_id is not null";
				$query.=" group by k.karyawan_username, p.rawat_nama";
				$result = $this->db->query($query);
				
				
				
			}
			return $result;
		}
		
}
?>