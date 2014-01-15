<? /* 
	+ Module  		: LAporan Tindakan Dokter Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_jum_tindakan_all_dokter.php
 	+ Author  		: Fred

*/

class m_lap_jum_tindakan_all_dokter extends Model{
		
	//constructor
	function m_lap_jum_tindakan_all_dokter() {
		parent::Model();
	}		

	function report_tindakan_update_temp($isiperiode, $tglpaket, $dokter_id, $report_groupby, $urutan, $cabang){
		$this->cabang = $this->load->database($cabang, TRUE);
			
		if ($report_groupby == 'Semua')
		{
			$query =   "select 
							
							sum(Jumlah_rawat) as Jumlah_rawat, perawatan_id
							from(
								(
								select 
									ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
									sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
									perawatan.rawat_id as perawatan_id,
									'satuan' as status
								from detail_jual_rawat
								left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
								left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
								left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
								where 
									".$isiperiode." 
									(rawat_id is not null and jrawat_stat_dok='Tertutup') 
									and (detail_jual_rawat.drawat_sales = '".$dokter_id."' or tindakan_detail.dtrawat_petugas1 = '".$dokter_id."' or tindakan_detail.dtrawat_petugas2 = '".$dokter_id."')
								group by karyawan_username, perawatan_id
								)
								union
								(
								select
									ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
									sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
									perawatan.rawat_id as perawatan_id,
									'paket' as status
								from detail_ambil_paket
								left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
								left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
								left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
								where 
									".$tglpaket." 
									(detail_ambil_paket.dapaket_referal = '".$dokter_id."' or tindakan_detail.dtrawat_petugas1 = '".$dokter_id."') 
									and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
								group by karyawan_username, perawatan_id
								)
								) as table_union
								group by karyawan_username, perawatan_id";
				
		}

		else if ($report_groupby == 'Perawatan')
		{			
			$query =   "select 
							ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_id as perawatan_id
						from detail_jual_rawat
						left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
						left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
						left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
						left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
						left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
						left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
						where 
							".$isiperiode." 
							(rawat_id is not null and jrawat_stat_dok='Tertutup') 
							and (detail_jual_rawat.drawat_sales = '".$dokter_id."' or tindakan_detail.dtrawat_petugas1 = '".$dokter_id."' or tindakan_detail.dtrawat_petugas2 = '".$dokter_id."')
						group by karyawan_username, perawatan_id	
			";

		}

		else if ($report_groupby == 'Pengambilan_Paket')
		{
			$query =   "select 
							ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_id as perawatan_id
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where 
								".$tglpaket." 
								(detail_ambil_paket.dapaket_referal = '".$dokter_id."' or tindakan_detail.dtrawat_petugas1 = '".$dokter_id."') 
								and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, perawatan_id";
		}	
		
		$result_query = $this->cabang->query($query);
		
		foreach($result_query->result() as $row_query){
			$sql_update =  "update temp_jml_tindakan t
							set t.tjt_ref".$urutan." = ".$row_query->Jumlah_rawat."
							where t.tjt_rawat = ".$row_query->perawatan_id;
			$this->cabang->query($sql_update);											
		};
	}	
			
	//function for advanced search record
	function report_tindakan_search($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $start, $end, $cabang){
			$this->cabang = $this->load->database($cabang, TRUE);
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
			
			if ($report_groupby == '')
				$report_groupby = 'Semua';
			
				$sql_del = "delete from temp_jml_tindakan";
				$this->cabang->query($sql_del);
				
				$sql_rawat =   "insert into temp_jml_tindakan (tjt_rawat)
								select * from
								(
									select d1.drawat_rawat
									from detail_jual_rawat d1
									left join perawatan r1 on r1.rawat_id = d1.drawat_rawat
									left join master_jual_rawat m1 on m1.jrawat_id = d1.drawat_master
									where 
										".$isiperiode."
										m1.jrawat_stat_dok = 'Tertutup'
										and (r1.rawat_kategori = 2 or r1.rawat_kategori = 4 or r1.rawat_kategori = 16)
										
									union

									select d2.dapaket_item
									from detail_ambil_paket d2
									left join perawatan r2 on r2.rawat_id = d2.dapaket_item
									where 
										".$tglpaket."
										d2.dapaket_stat_dok = 'Tertutup'
										and (r2.rawat_kategori = 2 or r2.rawat_kategori = 4 or r2.rawat_kategori = 16)	
										and d2.dapaket_referal <> 0
								)
								as tb_union";
				$this->cabang->query($sql_rawat);
			
				$sql_dokter =  "select dokter_id, karyawan_nama
								from
								(
								select 
									distinct t1.dtrawat_petugas1 as dokter_id, k1.karyawan_nama
								from detail_jual_rawat d1
								left join perawatan r1 on r1.rawat_id = d1.drawat_rawat
								left join master_jual_rawat m1 on m1.jrawat_id = d1.drawat_master
								left join tindakan_detail t1 on t1.dtrawat_id = d1.drawat_dtrawat
								left join karyawan as k1 on t1.dtrawat_petugas1 = k1.karyawan_id
								where 
									".$isiperiode."
									m1.jrawat_stat_dok = 'Tertutup'
									and (r1.rawat_kategori = 2 or r1.rawat_kategori = 4 or r1.rawat_kategori = 16)
									and t1.dtrawat_petugas1 <> 0 and t1.dtrawat_petugas1 <> 5 /*suster*/ and k1.karyawan_nama not like '%available%' /*available dr*/
									
								union
								
								select 
									distinct d2.drawat_sales as dokter_id, k2.karyawan_nama
								from detail_jual_rawat d2
								left join perawatan r2 on r2.rawat_id = d2.drawat_rawat
								left join master_jual_rawat m2 on m2.jrawat_id = d2.drawat_master
								left join karyawan k2 on d2.drawat_sales = k2.karyawan_id
								where 
									 ".$isiperiode."
									m2.jrawat_stat_dok = 'Tertutup'
									and (r2.rawat_kategori = 2 or r2.rawat_kategori = 4 or r2.rawat_kategori = 16)
									and d2.drawat_sales <> 5 /*suster*/ and k2.karyawan_nama not like '%available%' /*available dr*/
									
								union

								select
									distinct t3.dtrawat_petugas1 as dokter_id, k3.karyawan_nama
								from detail_ambil_paket d3
								left join perawatan r3 on r3.rawat_id = d3.dapaket_item
								left join tindakan_detail t3 on t3.dtrawat_id = d3.dapaket_dtrawat
								left join karyawan k3 on t3.dtrawat_petugas1 = k3.karyawan_id
								where 
									".$tglpaket."
									d3.dapaket_stat_dok = 'Tertutup'
									and (r3.rawat_kategori = 2 or r3.rawat_kategori = 4 or r3.rawat_kategori = 16)
									and t3.dtrawat_petugas1 <> 0 and t3.dtrawat_petugas1 <> 5 /*suster*/ and k3.karyawan_nama not like '%available%' /*available dr*/

								union
								
								select
									distinct d4.dapaket_referal as dokter_id, k4.karyawan_nama
								from detail_ambil_paket d4
								left join perawatan r4 on r4.rawat_id = d4.dapaket_item
								left join karyawan k4 on d4.dapaket_referal = k4.karyawan_id
								where 
									".$tglpaket."
									d4.dapaket_stat_dok = 'Tertutup'
									and (r4.rawat_kategori = 2 or r4.rawat_kategori = 4 or r4.rawat_kategori = 16)
									and d4.dapaket_referal <> 5 /*suster*/ and k4.karyawan_nama not like '%available%' /*available dr*/
								)
								as t
								order by karyawan_nama
								";
				$res_dokter = $this->cabang->query($sql_dokter);
				
				$i = 0;
				foreach($res_dokter->result() as $row_dokter){
					$row = $res_dokter->row($i);		
					//print_r($row->dokter_id); print_r(' ');
					$this->report_tindakan_update_temp($isiperiode, $tglpaket, $row->dokter_id, $report_groupby, $i, $cabang);
					$i++;
				}
				
				/* //sama saja tidak bisa, karena kalau null di columnmodelnya ditampilkan 0
				for($i2 = $i; $i2 < 14; $i2++){
					$sql_clean =   "update temp_jml_tindakan
									set tjt_ref".$i2." = null";
					$this->db->query($sql_clean);
				}
				*/
				
			$query_temp =  "select t.*, r.rawat_kode, r.rawat_nama
							from temp_jml_tindakan t
							left join perawatan r on r.rawat_id = t.tjt_rawat
							order by rawat_kode";
			
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
								sum(t.tjt_ref0) as tjt_total_ref0,
								sum(t.tjt_ref1) as tjt_total_ref1,
								sum(t.tjt_ref2) as tjt_total_ref2,
								sum(t.tjt_ref3) as tjt_total_ref3,
								sum(t.tjt_ref4) as tjt_total_ref4,
								sum(t.tjt_ref5) as tjt_total_ref5,
								sum(t.tjt_ref6) as tjt_total_ref6,
								sum(t.tjt_ref7) as tjt_total_ref7,
								sum(t.tjt_ref8) as tjt_total_ref8,
								sum(t.tjt_ref9) as tjt_total_ref9,
								sum(t.tjt_ref10) as tjt_total_ref10,
								sum(t.tjt_ref11) as tjt_total_ref11,
								sum(t.tjt_ref12) as tjt_total_ref12,
								sum(t.tjt_ref13) as tjt_total_ref13
							from temp_jml_tindakan t";
			
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


	function report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start, $end, $cabang, $print){
		$this->cabang = $this->load->database($cabang, TRUE);
			
		//full query
		if ($periode == 'bulan'){
			$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
			$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
		}else if($periode == 'tanggal'){
			$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
			$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
		}
	
		$sql_dokter =  "select dokter_id, karyawan_nama, karyawan_username
						from
						(
						select 
							distinct t1.dtrawat_petugas1 as dokter_id, k1.karyawan_nama, k1.karyawan_username
						from detail_jual_rawat d1
						left join perawatan r1 on r1.rawat_id = d1.drawat_rawat
						left join master_jual_rawat m1 on m1.jrawat_id = d1.drawat_master
						left join tindakan_detail t1 on t1.dtrawat_id = d1.drawat_dtrawat
						left join karyawan as k1 on t1.dtrawat_petugas1 = k1.karyawan_id
						where 
							".$isiperiode."
							m1.jrawat_stat_dok = 'Tertutup'
							and (r1.rawat_kategori = 2 or r1.rawat_kategori = 4 or r1.rawat_kategori = 16)
							and t1.dtrawat_petugas1 <> 0 and t1.dtrawat_petugas1 <> 5 /*suster*/ and k1.karyawan_nama not like '%available%' /*available dr*/
							
						union
						
						select 
							distinct d2.drawat_sales as dokter_id, k2.karyawan_nama, k2.karyawan_username
						from detail_jual_rawat d2
						left join perawatan r2 on r2.rawat_id = d2.drawat_rawat
						left join master_jual_rawat m2 on m2.jrawat_id = d2.drawat_master
						left join karyawan k2 on d2.drawat_sales = k2.karyawan_id
						where 
							 ".$isiperiode."
							m2.jrawat_stat_dok = 'Tertutup'
							and (r2.rawat_kategori = 2 or r2.rawat_kategori = 4 or r2.rawat_kategori = 16)
							and d2.drawat_sales <> 5 /*suster*/ and k2.karyawan_nama not like '%available%' /*available dr*/
							
						union

						select
							distinct t3.dtrawat_petugas1 as dokter_id, k3.karyawan_nama, k3.karyawan_username
						from detail_ambil_paket d3
						left join perawatan r3 on r3.rawat_id = d3.dapaket_item
						left join tindakan_detail t3 on t3.dtrawat_id = d3.dapaket_dtrawat
						left join karyawan k3 on t3.dtrawat_petugas1 = k3.karyawan_id
						where 
							".$tglpaket."
							d3.dapaket_stat_dok = 'Tertutup'
							and (r3.rawat_kategori = 2 or r3.rawat_kategori = 4 or r3.rawat_kategori = 16)
							and t3.dtrawat_petugas1 <> 0 and t3.dtrawat_petugas1 <> 5 /*suster*/ and k3.karyawan_nama not like '%available%' /*available dr*/

						union
						
						select
							distinct d4.dapaket_referal as dokter_id, k4.karyawan_nama, k4.karyawan_username
						from detail_ambil_paket d4
						left join perawatan r4 on r4.rawat_id = d4.dapaket_item
						left join karyawan k4 on d4.dapaket_referal = k4.karyawan_id
						where 
							".$tglpaket."
							d4.dapaket_stat_dok = 'Tertutup'
							and (r4.rawat_kategori = 2 or r4.rawat_kategori = 4 or r4.rawat_kategori = 16)
							and d4.dapaket_referal <> 5 /*suster*/ and k4.karyawan_nama not like '%available%' /*available dr*/
						)
						as t
						order by karyawan_nama
						";
		$res_dokter = $this->cabang->query($sql_dokter);
				//echo $sql_dokter;
				
				
		$nbrows = $res_dokter->num_rows();
		
		$limit = $sql_dokter." LIMIT ".$start.",".$end;		
		
		$res_dokter = $this->cabang->query($limit);    
		
		if($nbrows>0){
			foreach($res_dokter->result() as $row){
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

				
			$query_temp =  "select t.*, r.rawat_kode, r.rawat_nama
							from temp_jml_tindakan t
							left join perawatan r on r.rawat_id = t.tjt_rawat
							order by rawat_kode";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp->result();
		}
		
	//function for print total
	function report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang){
			$this->cabang = $this->load->database($cabang, TRUE);
			
			$query_temp =  "select 
								sum(t.tjt_ref0) as tjt_total_ref0,
								sum(t.tjt_ref1) as tjt_total_ref1,
								sum(t.tjt_ref2) as tjt_total_ref2,
								sum(t.tjt_ref3) as tjt_total_ref3,
								sum(t.tjt_ref4) as tjt_total_ref4,
								sum(t.tjt_ref5) as tjt_total_ref5,
								sum(t.tjt_ref6) as tjt_total_ref6,
								sum(t.tjt_ref7) as tjt_total_ref7,
								sum(t.tjt_ref8) as tjt_total_ref8,
								sum(t.tjt_ref9) as tjt_total_ref9,
								sum(t.tjt_ref10) as tjt_total_ref10,
								sum(t.tjt_ref11) as tjt_total_ref11,
								sum(t.tjt_ref12) as tjt_total_ref12,
								sum(t.tjt_ref13) as tjt_total_ref13
							from temp_jml_tindakan t";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp->result();
		}
		
	//function  for export to excel
	function report_tindakan_export_excel($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang){
			//full query
			$this->cabang = $this->load->database($cabang, TRUE);

				
			$query_temp =  "select 
								sum(t.tjt_ref0) as tjt_total_ref0,
								sum(t.tjt_ref1) as tjt_total_ref1,
								sum(t.tjt_ref2) as tjt_total_ref2,
								sum(t.tjt_ref3) as tjt_total_ref3,
								sum(t.tjt_ref4) as tjt_total_ref4,
								sum(t.tjt_ref5) as tjt_total_ref5,
								sum(t.tjt_ref6) as tjt_total_ref6,
								sum(t.tjt_ref7) as tjt_total_ref7,
								sum(t.tjt_ref8) as tjt_total_ref8,
								sum(t.tjt_ref9) as tjt_total_ref9,
								sum(t.tjt_ref10) as tjt_total_ref10,
								sum(t.tjt_ref11) as tjt_total_ref11,
								sum(t.tjt_ref12) as tjt_total_ref12,
								sum(t.tjt_ref13) as tjt_total_ref13
							from temp_jml_tindakan t";
			
			$result_temp = $this->cabang->query($query_temp);
			return $result_temp;
		}
		
}
?>