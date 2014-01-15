<? /* 
	+ Module  		: LAporan Tindakan Dokter Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_jum_tindakan_dokter.php
 	+ Author  		: Fred

*/

class M_lap_jum_tindakan_dokter extends Model{
		
	//constructor
	function M_lap_jum_tindakan_dokter() {
		parent::Model();
	}
		
	function get_petugas_list($query, $tgl_app="", $karyawan_jabatan){
		$user_id=$_SESSION[SESSION_USERID];

		// query ambil karyawan id
		$sql_karyawan ="select * from users where user_name = '".$user_id."'";
		$query_sql_karyawan= $this->db->query($sql_karyawan);
		if ($query_sql_karyawan->num_rows()){
			$data_sql_karyawan= $query_sql_karyawan->row();
			$karyawan_id= $data_sql_karyawan->user_karyawan;
		}
		
		$bln_now=date('Y-m');
		
		
		if(eregi('H',$this->m_security->get_access_group_by_kode('MENU_LAPJUMTINDDOKTER'))){
			$sql=  "SELECT karyawan_id,karyawan_no,karyawan_nama, karyawan_sip,karyawan_username,reportt_jmltindakan FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) LEFT JOIN (SELECT * FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%') as rt ON(karyawan_id=rt.reportt_karyawan_id) 
					left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_id)
					WHERE karyawan_jabatan=jabatan_id AND (jabatan_nama='$karyawan_jabatan' OR jabatan_nama='Suster') AND karyawan_aktif='Aktif'
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1) 
						OR substring(karyawan_cabang2,
						(select cabang_value 
							from cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id)
						,1) = '1')";
		} else {
			$sql=  "SELECT karyawan_id,karyawan_no,karyawan_nama, karyawan_sip,karyawan_username,reportt_jmltindakan FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) LEFT JOIN (SELECT * FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%') as rt ON(karyawan_id=rt.reportt_karyawan_id) 
				left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_id)
				WHERE karyawan_jabatan=jabatan_id AND (jabatan_nama='$karyawan_jabatan' OR jabatan_nama='Suster') AND karyawan_aktif='Aktif' AND karyawan_id = '".$karyawan_id."'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id)
						,1) = '1')";
		}
		
		if($query<>""){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (absensi_tgl='".addslashes($tgl_app)."')";
		}
		//echo $sql;
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
		
	//function for advanced search record
	function report_tindakan_search($tgl_awal,$periode,$report_tindakan_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end){
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
			
			if ($report_groupby == 'Semua')
			{
			$query="select rawat_kode as rawat_kode, rawat_nama as rawat_nama, sum(Jumlah_rawat) as Jumlah_rawat, rawat_kredit as rawat_kredit, rawat_kreditrp as rawat_kreditrp, total_kredit as Total_Kredit, sum(Total_kredit) as Total_kredit, sum(Total_kreditrp) as Total_kreditrp
						from(
							(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, 
							perawatan.rawat_kredit, 
							perawatan.rawat_kreditrp, 
							perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama
							)
							) as table_union
							group by karyawan_username, rawat_nama
							";
							
			}
		
			else if ($report_groupby == 'Perawatan')
			{			
			$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama	
						";
		
			}
		
			else if ($report_groupby == 'Pengambilan_Paket')
			{
				$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama";
			}
			
			$query.= " order by rawat_kode ";
			
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
		
	//function for advanced search record
	function report_tindakan_search2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end){
			//full query
			
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
		
			if ($report_groupby == 'Semua')
			{
			$query="select sum(table_union.Total_kredit) as grand_total, sum(table_union.Total_kreditrp) as grand_total_rp 
						from(
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode."(rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama
							)
							) as table_union
							";
							
			}
		
			/*if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " ";
			}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " master_jual_rawat.jrawat_tanggal='".$trawat_tglapp_start."'";

			
			}*/

			else if ($report_groupby == 'Perawatan')
			{
			$query="select sum(vu_kredit.Total_kredit) as grand_total, sum(vu_kredit.Total_kreditrp) as grand_total_rp
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama) as vu_kredit
								";
			}
			
			else if ($report_groupby == 'Pengambilan_Paket')
			{
			$query="select sum(vu_kredit.Total_kredit) as grand_total, sum(vu_kredit.Total_kreditrp) as grand_total_rp
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." and (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama) as vu_kredit";
	
		
			}
			
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
	function report_tindakan_print($tgl_awal,$periode,$report_groupby,$trawat_dokter,$trawat_tglapp_start,$trawat_tglapp_end,$option,$filter){
			//full query
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
			
			if ($report_groupby == 'Semua')
			{
			$query="select karyawan_username, rawat_kode as rawat_kode, rawat_nama as rawat_nama, sum(Jumlah_rawat) as Jumlah_rawat, rawat_kredit as rawat_kredit, rawat_kreditrp as rawat_kreditrp, sum(Total_kredit) as Total_kredit, sum(Total_kreditrp) as Total_kreditrp  
						from(
							(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama
							)
							) as table_union
							group by karyawan_username, rawat_nama
							";
							
			}
		
			else if ($report_groupby == 'Perawatan')
			{
			$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama	
						";
		
			}
		
			else if ($report_groupby == 'Pengambilan_Paket')
			{
				$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama";
			}
		 
			$result = $this->db->query($query);  
			return $result;
		}
		
		//function for advanced search record
	function report_tindakan_print2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby){
			//full query
			
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
		
			if ($report_groupby == 'Semua')
			{
			$query="select sum(table_union.Total_kredit) as grand_total, sum(table_union.Total_kreditrp) as grand_total_rp 
						from(
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode."(rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama
							)
							) as table_union
							";
							
			}
		
			/*if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " ";
			}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " master_jual_rawat.jrawat_tanggal='".$trawat_tglapp_start."'";

			
			}*/

			else if ($report_groupby == 'Perawatan')
			{
			$query="select sum(vu_kredit.Total_kredit) as grand_total, sum(vu_kredit.Total_kreditrp) as grand_total_rp
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama) as vu_kredit
								";
			}
			
			else if ($report_groupby == 'Pengambilan_Paket')
			{
			$query="select sum(vu_kredit.Total_kredit) as grand_total, sum(vu_kredit.Total_kreditrp) as grand_total_rp
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." and (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama) as vu_kredit";
	
		
			}
			
			/*$result = $this->db->query($query);
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
			}*/
			$result = $this->db->query($query);  
			return $result;
		}
		
	//function  for export to excel
	function report_tindakan_export_excel($tgl_awal,$periode,$trawat_id ,$trawat_tglapp_start , $trawat_tglapp_end, $trawat_dokter,
										$report_groupby, $option, $filter){
			//full query
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."') and " ;
			}
			
			if ($report_groupby == 'Semua')
			{
			$query="select karyawan_username as Karyawan, rawat_kode as Kode, rawat_nama as Perawatan, sum(Jumlah_rawat) as Jumlah, rawat_kredit as 'Kredit (Poin)', rawat_kreditrp as 'Kredit (Rp)', sum(Total_kredit) as 'Tot Kredit (Poin)', sum(Total_kreditrp) as 'Tot Kredit (Rp)'
						from(
							(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as Total_kreditrp,
							'satuan' as status
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kreditrp, perawatan.rawat_kode,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as Total_kreditrp,
							'paket' as status
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username,rawat_nama
							)
							) as table_union
							group by karyawan_username, rawat_nama
							order by rawat_kode
							";
							
			}
		
			else if ($report_groupby == 'Perawatan')
			{
			$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS Karyawan,
							perawatan.rawat_nama as Perawatan, perawatan.rawat_kredit as 'Kredit (Poin)', perawatan.rawat_kreditrp as 'Kredit (Rp)', perawatan.rawat_kode,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as 'Tot Kredit (Poin)',
							perawatan.rawat_kreditrp * sum(detail_jual_rawat.drawat_jumlah) as 'Tot Kredit (Rp)',
							'satuan' as status
							from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)			
							where ".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup') and (detail_jual_rawat.drawat_sales = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas2 = '".$trawat_dokter."')
							group by Karyawan, rawat_nama
							order by rawat_kode							
						";
		
			}
		
			else if ($report_groupby == 'Pengambilan_Paket')
			{
				$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS Karyawan, perawatan.rawat_kode as Kode,
							perawatan.rawat_nama as Perawatan, perawatan.rawat_kredit as 'Kredit (Poin)', perawatan.rawat_kreditrp as 'Kredit (Rp)', 
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as 'Tot Kredit (Poin)',
							perawatan.rawat_kreditrp * sum(detail_ambil_paket.dapaket_jumlah) as 'Tot Kredit (Rp)'
							/*, 'paket' as status*/
							from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							where ".$tglpaket." (detail_ambil_paket.dapaket_referal = '".$trawat_dokter."' or tindakan_detail.dtrawat_petugas1 = '".$trawat_dokter."') and (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by Karyawan,rawat_nama
							order by rawat_kode
							";
			}
		 
			$result = $this->db->query($query);  
			return $result;
		}
		
}
?>