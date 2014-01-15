<? /* 	
	
	+ Module  		: Top Spender Model
	+ Description	: For record model process back-end
	+ Filename 		: c_report_top_spender_netsales.php
 	+ Author  		: Isaac
	Edited by		: Fred

*/

class M_report_top_spender_netsales extends Model{
		
	//constructor
	function M_report_top_spender_netsales() {
		parent::Model();
	}


	/* INSERT ke db.history_ambil_paket */
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
			/* me-LOCKED db.appointment_detail */
			$dtu_dapp=array(
			"dapp_locked"=>1
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
			
			/* UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'true' */
			$dtu_dtrawat=array(
			"dtrawat_ambil_paket"=>'true'
			);
			$this->db->where('dtrawat_id', $dtrawat_id);
			$this->db->update('tindakan_detail', $dtu_dtrawat);
		}
	}
	/* eof history_ambil_paket_insert */
	
	/* INSERT ke db.history_ambil_paket */
	function history_ambil_paket_delete($dtrawat_id, $dtrawat_dapp){
		$this->db->where('hapaket_dtrawat', $dtrawat_id);
		$this->db->delete('history_ambil_paket');
		if($this->db->affected_rows()){
			/* meng-UNLOCK db.appointment_detail */
			$dtu_dapp=array(
			"dapp_locked"=>0
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
		}
	}
	/* eof history_ambil_paket_insert */

		//function for advanced search record
	function top_spender_netsales_search($tgl_start, $tgl_end, $top_jenis, $top_jumlah, $umur_start, $umur_end){
		
		if ($top_jenis == '')	$top_jenis = 'Semua';		
		if ($top_jumlah == '')	$top_jumlah = '10';		
		if ($umur_start == '')	$umur_start = 0;
		if ($umur_end == '')	$umur_end = 3000;
		
		if ($top_jenis == 'Perawatan Satuan')
		{
			$query =   "SELECT
							c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.jrawat_bayar) as total 
						FROM master_jual_rawat m LEFT OUTER JOIN vu_customer c ON m.jrawat_cust = c.cust_id
						WHERE
							m.jrawat_tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' 
							AND m.jrawat_stat_dok = 'Tertutup'
							AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
						GROUP BY m.jrawat_cust ORDER BY SUM(m.jrawat_bayar) DESC";
		}
		else if ($top_jenis == 'Penjualan Produk')
		{
			$query =   "SELECT 
							c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.jproduk_bayar) as total 
						FROM master_jual_produk m 
						LEFT OUTER JOIN vu_customer c ON m.jproduk_cust = c.cust_id
						WHERE 
							m.jproduk_tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' AND m.jproduk_stat_dok = 'Tertutup'
							AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
						GROUP BY m.jproduk_cust ORDER BY SUM(m.jproduk_bayar) DESC";					
		}
		else if ($top_jenis == 'Pengambilan Paket')
		{
			$query =   "SELECT 
							c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.total_harga_satuan) as total 
						FROM vu_detail_ambil_paket_rawat_simple m
						LEFT OUTER JOIN vu_customer c ON m.dapaket_cust = c.cust_id
						WHERE
							m.tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' AND m.dapaket_stat_dok = 'Tertutup'
							AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
						GROUP BY m.dapaket_cust ORDER BY SUM(m.total_harga_satuan) DESC";				
		}
		else if ($top_jenis == 'Perawatan Satuan & Pengambilan Paket')
		{
			$query =   "SELECT 
							cust_no, cust_nama, member_no, cust_umur, SUM(total) AS total
						FROM
						(
							SELECT
								c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.jrawat_bayar) as total 
							FROM master_jual_rawat m LEFT OUTER JOIN vu_customer c ON m.jrawat_cust = c.cust_id
							WHERE
								m.jrawat_tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' 
								AND m.jrawat_stat_dok = 'Tertutup'
								AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
								GROUP BY m.jrawat_cust 
								
							UNION ALL
				
							SELECT 
								c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.total_harga_satuan) as total 
							FROM vu_detail_ambil_paket_rawat_simple m
							LEFT OUTER JOIN vu_customer c ON m.dapaket_cust = c.cust_id
							WHERE
								m.tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' AND m.dapaket_stat_dok = 'Tertutup'
								AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
							GROUP BY m.dapaket_cust
						)
						AS table_union
						GROUP BY cust_no ORDER BY SUM(total) DESC";				
		}	
		else if ($top_jenis == 'Semua')
		{
			$query =   "SELECT 
							cust_no, cust_nama, member_no, cust_umur, SUM(total) AS total
						FROM
						(
							SELECT
								c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.jrawat_bayar) as total 
							FROM master_jual_rawat m LEFT OUTER JOIN vu_customer c ON m.jrawat_cust = c.cust_id
							WHERE
								m.jrawat_tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' 
								AND m.jrawat_stat_dok = 'Tertutup'
								AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
								GROUP BY m.jrawat_cust 
								
							UNION ALL
				
							SELECT 
								c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.total_harga_satuan) as total 
							FROM vu_detail_ambil_paket_rawat_simple m
							LEFT OUTER JOIN vu_customer c ON m.dapaket_cust = c.cust_id
							WHERE
								m.tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' AND m.dapaket_stat_dok = 'Tertutup'
								AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
							GROUP BY m.dapaket_cust
							
							UNION ALL
							
							SELECT 
								c.cust_no, c.cust_nama, c.member_no, c.cust_umur, SUM(m.jproduk_bayar) as total 
							FROM master_jual_produk m 
							LEFT OUTER JOIN vu_customer c ON m.jproduk_cust = c.cust_id
							WHERE 
								m.jproduk_tanggal BETWEEN '".$tgl_start."' AND '".$tgl_end."' AND m.jproduk_stat_dok = 'Tertutup'
								AND c.cust_umur BETWEEN '$umur_start' AND '$umur_end'
							GROUP BY m.jproduk_cust
						)
						AS table_union
						GROUP BY cust_no ORDER BY SUM(total) DESC";		
		}
		$start = 0;
		$end = $top_jumlah;
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
		function tindakan_print($trawat_id ,$trawat_cust ,$trawat_keterangan ,$option,$filter){
			//full query
			$query="select * from tindakan";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (trawat_id LIKE '%".addslashes($filter)."%' OR trawat_cust LIKE '%".addslashes($filter)."%' OR trawat_keterangan LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_id LIKE '%".$trawat_id."%'";
				};
				if($trawat_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_cust LIKE '%".$trawat_cust."%'";
				};
				if($trawat_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_keterangan LIKE '%".$trawat_keterangan."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function tindakan_export_excel($trawat_id, $trawat_tglapp_start ,$trawat_tglapp_end, $top_jenis ,$top_jumlah ,$option,$filter){
			
			if ($top_jenis == '')
				$top_jenis = 'Semua';
			
			if ($top_jumlah == '')
				$top_jumlah = '10';
			
			if ($top_jenis == 'Perawatan')
			{
				$query = "SELECT vu_customer.cust_no, vu_customer.cust_nama, vu_customer.member_no, SUM(master_jual_rawat.jrawat_bayar) as total 
						FROM master_jual_rawat LEFT OUTER JOIN vu_customer
						ON master_jual_rawat.jrawat_cust = vu_customer.cust_id";
			
				if($trawat_id!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				};
			
				if($trawat_tglapp_start!='' && $trawat_tglapp_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}else if($trawat_tglapp_start!='' && $trawat_tglapp_end=='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_rawat.jrawat_tanggal='".$trawat_tglapp_start."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup'";
				}
				$query.=" GROUP BY master_jual_rawat.jrawat_cust ORDER BY SUM(master_jual_rawat.jrawat_bayar) DESC";
			}
			else if ($top_jenis == 'Produk')
			{
				$query = "SELECT vu_customer.cust_no, vu_customer.cust_nama, vu_customer.member_no, SUM(master_jual_produk.jproduk_bayar) as total 
						FROM master_jual_produk LEFT OUTER JOIN vu_customer
						ON master_jual_produk.jproduk_cust = vu_customer.cust_id";
			
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_produk.jproduk_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				};
			
				if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_produk.jproduk_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_produk.jproduk_tanggal='".$trawat_tglapp_start."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
				}
				$query.=" GROUP BY master_jual_produk.jproduk_cust ORDER BY SUM(master_jual_produk.jproduk_bayar) DESC";
			}
			else if ($top_jenis == 'Paket')
			{
				$query = "SELECT vu_customer.cust_no, vu_customer.cust_nama, vu_customer.member_no, SUM(master_jual_paket.jpaket_bayar) as total 
						FROM master_jual_paket LEFT OUTER JOIN vu_customer
						ON master_jual_paket.jpaket_cust = vu_customer.cust_id";
			
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				};
			
				if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " master_jual_paket.jpaket_tanggal='".$trawat_tglapp_start."' AND master_jual_paket.jpaket_stat_dok = 'Tertutup'";
				}
				$query.=" GROUP BY master_jual_paket.jpaket_cust ORDER BY SUM(master_jual_paket.jpaket_bayar) DESC";
			}
			else if ($top_jenis == 'Kuitansi')
			{
				$query = "SELECT vu_customer.cust_no, vu_customer.cust_nama, vu_customer.member_no, SUM(cetak_kwitansi.kwitansi_nilai) as total 
						FROM cetak_kwitansi LEFT OUTER JOIN vu_customer
						ON cetak_kwitansi.kwitansi_cust = vu_customer.cust_id";
			
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cetak_kwitansi.kwitansi_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND cetak_kwitansi.kwitansi_status = 'Tertutup' AND cetak_kwitansi.kwitansi_cara <> 'Retur' ";
				};
			
				if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cetak_kwitansi.kwitansi_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."' AND cetak_kwitansi.kwitansi_status = 'Tertutup' AND cetak_kwitansi.kwitansi_cara <> 'Retur'";
				}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cetak_kwitansi.kwitansi_tanggal ='".$trawat_tglapp_start."' AND cetak_kwitansi.kwitansi_status = 'Tertutup' AND cetak_kwitansi.kwitansi_cara <> 'Retur'";
				}
				$query.=" GROUP BY cetak_kwitansi.kwitansi_cust ORDER BY SUM(cetak_kwitansi.kwitansi_nilai) DESC";
			}
			else if ($top_jenis == 'Semua')
			{
				$query = "SELECT  vu_customer.cust_no,vu_customer.cust_nama,vu_customer.member_no,SUM(total) as total
					FROM
					(
						(	
							SELECT paket.jpaket_cust AS customer, paket.jpaket_bayar AS total  FROM master_jual_paket AS paket WHERE paket.jpaket_bayar IS NOT NULL AND (paket.jpaket_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') AND paket.jpaket_stat_dok = 'Tertutup' ORDER BY paket.jpaket_bayar DESC 
						) 
						UNION
						(
							SELECT produk.jproduk_cust AS customer, produk.jproduk_bayar AS total  FROM master_jual_produk AS produk WHERE produk.jproduk_bayar IS NOT NULL AND (produk.jproduk_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') AND produk.jproduk_stat_dok = 'Tertutup' ORDER BY produk.jproduk_bayar DESC
						) 
						UNION	
						(
							SELECT rawat.jrawat_cust AS customer, rawat.jrawat_bayar AS total  FROM master_jual_rawat AS rawat WHERE rawat.jrawat_bayar IS NOT NULL AND (rawat.jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') AND rawat.jrawat_stat_dok = 'Tertutup' ORDER BY rawat.jrawat_bayar DESC
						)
						UNION	
						(
							SELECT kwitansi.kwitansi_cust AS customer, kwitansi.kwitansi_nilai AS total  FROM cetak_kwitansi AS kwitansi WHERE kwitansi.kwitansi_nilai IS NOT NULL AND (kwitansi.kwitansi_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') AND kwitansi.kwitansi_status = 'Tertutup' AND kwitansi.kwitansi_cara <> 'Retur' ORDER BY kwitansi.kwitansi_nilai DESC
						)
					)AS table_union
					LEFT OUTER JOIN vu_customer
					ON vu_customer.cust_id = customer
					GROUP BY vu_customer.cust_id
					ORDER BY SUM(total) DESC";
		
			}
			$start = 0;
			$end = $top_jumlah;
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);    
			return $result;
		}
		
}
?>