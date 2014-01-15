<? /* 
	+ Module  		: Laporan Semua Produk Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_jum_all_produk.php
 	+ Author  		: Isaac

*/

class m_lap_jum_all_produk extends Model{
		
	//constructor
	function m_lap_jum_all_produk() {
		parent::Model();
	}		

	function report_tindakan_update_temp($isiperiode, $karyawan_id, $report_groupby, $urutan, $cabang){
		$this->cabang = $this->load->database($cabang, TRUE);
			
		if ($report_groupby == 'Semua')
		{
			$query =   "select
							karyawan.karyawan_username,
							sum(detail_jual_produk.dproduk_jumlah) as jumlah_produk,
							detail_jual_produk.dproduk_produk
						from detail_jual_produk
						left join master_jual_produk on master_jual_produk.jproduk_id = detail_jual_produk.dproduk_master
						left join karyawan on karyawan.karyawan_id = detail_jual_produk.dproduk_karyawan
						left join produk on produk.produk_id = detail_jual_produk.dproduk_produk
						where 
							".$isiperiode."
							(produk_id is not null and jproduk_stat_dok='Tertutup') and
							(detail_jual_produk.dproduk_karyawan = '".$karyawan_id."')
						group by karyawan_username, detail_jual_produk.dproduk_produk";
				
		}
		
		$result_query = $this->cabang->query($query);
		
		foreach($result_query->result() as $row_query){
			$sql_update =  "update temp_jml_jual_produk t
							set t.tjjp_ref".$urutan." = ".$row_query->jumlah_produk."
							where t.tjjp_produk = ".$row_query->dproduk_produk;
			$this->cabang->query($sql_update);											
		};
	}	
			
	//function for advanced search record
	function report_tindakan_therapis_search($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $start, $end, $cabang){
			$this->cabang = $this->load->database($cabang, TRUE);
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jproduk_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jproduk_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
			}
			
			if ($report_groupby == '')
				$report_groupby = 'Semua';
			
				$sql_del = "delete from temp_jml_jual_produk";
				$this->cabang->query($sql_del);
				
				$sql_rawat =   "insert into temp_jml_jual_produk (tjjp_produk)
									select distinct d1.dproduk_produk
									from detail_jual_produk d1
									left join produk r1 on r1.produk_id = d1.dproduk_produk
									left join master_jual_produk m1 on m1.jproduk_id = d1.dproduk_master
									where 
									".$isiperiode."
									m1.jproduk_stat_dok = 'Tertutup'";
				$this->cabang->query($sql_rawat);
			
				$sql_karyawan =  "select 
									DISTINCT detail_jual_produk.dproduk_karyawan as karyawan_id, karyawan.karyawan_nama
								from detail_jual_produk
									left join produk on detail_jual_produk.dproduk_produk = produk.produk_id
									left join master_jual_produk on detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
									left join karyawan on detail_jual_produk.dproduk_karyawan = karyawan.karyawan_id
								where
									".$isiperiode."
									master_jual_produk.jproduk_stat_dok = 'Tertutup' and
									detail_jual_produk.dproduk_karyawan is not null and 
									detail_jual_produk.dproduk_karyawan <> 0
								order by karyawan_nama
								";
				$res_karyawan = $this->cabang->query($sql_karyawan);
				
				$i = 0;
				foreach($res_karyawan->result() as $row_dokter){
					$row = $res_karyawan->row($i);		
					//print_r($row->karyawan_id); print_r(' ');
					$this->report_tindakan_update_temp($isiperiode, $row->karyawan_id, $report_groupby, $i, $cabang);
					$i++;
				}
				
				/* //sama saja tidak bisa, karena kalau null di columnmodelnya ditampilkan 0
				for($i2 = $i; $i2 < 14; $i2++){
					$sql_clean =   "update temp_jml_tindakan
									set tjt_ref".$i2." = null";
					$this->db->query($sql_clean);
				}
				*/
				
			$query_temp =  "select t.*, p.produk_kode, p.produk_nama
							from temp_jml_jual_produk t
							left join produk p on p.produk_id = t.tjjp_produk
							order by produk_kode";
			
			$result_temp = $this->cabang->query($query_temp);
			$nbrows = $result_temp->num_rows();
			
			$limit = $query_temp." LIMIT ".$start.",".$end;		
			
			$result_temp = $this->cabang->query($limit);    
			
			if($nbrows>0){
				foreach($result_temp->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
	function report_tindakan_searchtotal($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang){
			$this->cabang = $this->load->database($cabang, TRUE);
			
			$query_temp =  "select 
								sum(t.tjjp_ref0) as tjjp_total_ref0,
								sum(t.tjjp_ref1) as tjjp_total_ref1,
								sum(t.tjjp_ref2) as tjjp_total_ref2,
								sum(t.tjjp_ref3) as tjjp_total_ref3,
								sum(t.tjjp_ref4) as tjjp_total_ref4,
								sum(t.tjjp_ref5) as tjjp_total_ref5,
								sum(t.tjjp_ref6) as tjjp_total_ref6,
								sum(t.tjjp_ref7) as tjjp_total_ref7,
								sum(t.tjjp_ref8) as tjjp_total_ref8,
								sum(t.tjjp_ref9) as tjjp_total_ref9,
								sum(t.tjjp_ref10) as tjjp_total_ref10,
								sum(t.tjjp_ref11) as tjjp_total_ref11,
								sum(t.tjjp_ref12) as tjjp_total_ref12,
								sum(t.tjjp_ref13) as tjjp_total_ref13,
								sum(t.tjjp_ref14) as tjjp_total_ref14,
								sum(t.tjjp_ref15) as tjjp_total_ref15,
								sum(t.tjjp_ref16) as tjjp_total_ref16,
								sum(t.tjjp_ref17) as tjjp_total_ref17,
								sum(t.tjjp_ref18) as tjjp_total_ref18,
								sum(t.tjjp_ref19) as tjjp_total_ref19,
								sum(t.tjjp_ref20) as tjjp_total_ref20,
								sum(t.tjjp_ref21) as tjjp_total_ref21,
								sum(t.tjjp_ref22) as tjjp_total_ref22
							from temp_jml_jual_produk t";
			
			$result_temp = $this->cabang->query($query_temp);
			$nbrows = $result_temp->num_rows();
			
			if($nbrows>0){
				foreach($result_temp->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}


	function report_daftar_karyawan($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start, $end, $cabang, $print){
		$this->cabang = $this->load->database($cabang, TRUE);
			
		//full query
		if ($periode == 'bulan'){
				$isiperiode=" (date_format(jproduk_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jproduk_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
			}
	
		$sql_karyawan =  "select distinct
							karyawan.karyawan_id as karyawan_id,
							karyawan.karyawan_nama as karyawan_nama,
							karyawan.karyawan_username as karyawan_username
						from detail_jual_produk
						left join master_jual_produk on master_jual_produk.jproduk_id = detail_jual_produk.dproduk_master
						left join karyawan on karyawan.karyawan_id = detail_jual_produk.dproduk_karyawan
						left join produk on produk.produk_id = detail_jual_produk.dproduk_produk
						where 
							".$isiperiode."
							(karyawan_id is not null and jproduk_stat_dok='Tertutup')
						order by karyawan_nama"; 

		$res_karyawan = $this->cabang->query($sql_karyawan);
		$nbrows = $res_karyawan->num_rows();
		$limit = $sql_karyawan." LIMIT ".$start.",".$end;		
		$res_karyawan = $this->cabang->query($limit);    
		
		if($nbrows>0){
			foreach($res_karyawan->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			if ($print == 0)
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			else if ($print == 1)
				return $jsonresult;
		} else {
			return '({"total":"0", "results":""})';
		}
	}

	//function for print record
	function report_tindakan_print($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby,$cabang){
			//full query
			$this->cabang = $this->load->database($cabang, TRUE);

				
			$query_temp =  "select t.*, p.produk_kode, p.produk_nama
							from temp_jml_jual_produk t
							left join produk p on p.produk_id = t.tjjp_produk
							order by produk_kode";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp->result();
		}
		
	//function for print total
	function report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang){
			$this->cabang = $this->load->database($cabang, TRUE);
			
			$query_temp =  "select 
								sum(t.tjjp_ref0) as tjjp_total_ref0,
								sum(t.tjjp_ref1) as tjjp_total_ref1,
								sum(t.tjjp_ref2) as tjjp_total_ref2,
								sum(t.tjjp_ref3) as tjjp_total_ref3,
								sum(t.tjjp_ref4) as tjjp_total_ref4,
								sum(t.tjjp_ref5) as tjjp_total_ref5,
								sum(t.tjjp_ref6) as tjjp_total_ref6,
								sum(t.tjjp_ref7) as tjjp_total_ref7,
								sum(t.tjjp_ref8) as tjjp_total_ref8,
								sum(t.tjjp_ref9) as tjjp_total_ref9,
								sum(t.tjjp_ref10) as tjjp_total_ref10,
								sum(t.tjjp_ref11) as tjjp_total_ref11,
								sum(t.tjjp_ref12) as tjjp_total_ref12,
								sum(t.tjjp_ref13) as tjjp_total_ref13,
								sum(t.tjjp_ref14) as tjjp_total_ref14,
								sum(t.tjjp_ref15) as tjjp_total_ref15,
								sum(t.tjjp_ref16) as tjjp_total_ref16,
								sum(t.tjjp_ref17) as tjjp_total_ref17,
								sum(t.tjjp_ref18) as tjjp_total_ref18,
								sum(t.tjjp_ref19) as tjjp_total_ref19,
								sum(t.tjjp_ref20) as tjjp_total_ref20,
								sum(t.tjjp_ref21) as tjjp_total_ref21,
								sum(t.tjjp_ref22) as tjjp_total_ref22
								
							from temp_jml_jual_produk t";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp->result();
		}
		
	//function  for export to excel
	function report_tindakan_export_excel($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang){
			//full query
			$this->cabang = $this->load->database($cabang, TRUE);

				
			$query_temp =  "select r.rawat_kode,
								r.rawat_nama as perawatan, 
								t.tjt_ref0 as Dr_Chandra, 
								t.tjt_ref1 as Prof_David, 
								t.tjt_ref2 as Dr_Fanny,
								t.tjt_ref3 as Dr_Lanny, 
								t.tjt_ref4 as Dr_Leni, 
								t.tjt_ref5 as Dr_Novita, 
								t.tjt_ref6 as Dr_Nunin, 
								t.tjt_ref7 as Dr_Lince, 
								t.tjt_ref8 as Dr_Sandra, 
								t.tjt_ref9 as Dr_Vera, 
								t.tjt_ref10 as Dr_Yurika

							from temp_jml_tindakan t
							left join perawatan r on r.rawat_id = t.tjt_rawat
							order by rawat_kode";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp;
		}
		
}
?>