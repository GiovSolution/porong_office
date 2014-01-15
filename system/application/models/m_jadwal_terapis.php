<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: users Model
	+ Description	: For record model process back-end
	+ Filename 		: c_users.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 15:35:27
	
*/

class M_jadwal_terapis extends Model{
		
		//constructor
		function M_jadwal_terapis() {
			parent::Model();
		}
		
		
		//function for get list record
		function jadwal_terapis_list($filter,$start,$end,$tgl_app){
			
			$month=date('Y-m');
			
			if($tgl_app<>''){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$absensi_shift = 'absensi_shift_'.date('j', strtotime($tgl_app));
			}else{
				$dt=date('Y-m-d');
				$absensi_shift = 'absensi_shift_'.date('j');
			}
			
			/* Utk absensi shift "PAGI"*/
			/* Setiap UNION adalah menggabungkan dengan vu_report_tindakan_terapis_hf dan vu_jterapis_hf (ke dua view itu adalah view yang hanya  menghitung treatment dengan nilai setengah [Hand Treatment dan Foot Treatment])*/
			$query = "SELECT karyawan_username,  sum(terapis_count) as terapis_count, absensi_shift,
						sum(terapis_count_day) as terapis_count_day, absensi_keterangan
					FROM(
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'a' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis on (absensi_bt.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'P' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					
					UNION
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis_hf.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'b' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis_hf.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis_hf on (absensi_bt.absensi_karyawan_id = vu_jterapis_hf.terapis_id and vu_jterapis_hf.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'P' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					) union_table
					GROUP BY  karyawan_username";
					
		/*Utk absensi shift "SIANG"*/
		$query2 = "SELECT karyawan_username,  sum(terapis_count) as terapis_count, absensi_shift,
						sum(terapis_count_day) as terapis_count_day, absensi_keterangan
					FROM(
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'a' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis on (absensi_bt.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'S' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					
					UNION
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis_hf.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'b' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis_hf.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis_hf on (absensi_bt.absensi_karyawan_id = vu_jterapis_hf.terapis_id and vu_jterapis_hf.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'S' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					) union_table
					GROUP BY  karyawan_username";
					
		/*Utk absensi shift "MALAM"*/
		$query3 ="SELECT karyawan_username,  sum(terapis_count) as terapis_count, absensi_shift,
						sum(terapis_count_day) as terapis_count_day, absensi_keterangan
					FROM(
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'a' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis on (absensi_bt.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'M' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					
					UNION
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis_hf.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'b' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis_hf.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis_hf on (absensi_bt.absensi_karyawan_id = vu_jterapis_hf.terapis_id and vu_jterapis_hf.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'M' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					) union_table
					GROUP BY  karyawan_username";
					
		/*Utk absensi shift "OFF"*/
		$query4 = "SELECT karyawan_username,  sum(terapis_count) as terapis_count, absensi_shift,
						sum(terapis_count_day) as terapis_count_day, absensi_keterangan
					FROM(
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'a' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis on (absensi_bt.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'OFF' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					
					UNION
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis_hf.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'b' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis_hf.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis_hf on (absensi_bt.absensi_karyawan_id = vu_jterapis_hf.terapis_id and vu_jterapis_hf.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'OFF' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					) union_table
					GROUP BY  karyawan_username";
		
		/*Utk absensi shift "CUTI"*/
		$query5 = "SELECT karyawan_username,  sum(terapis_count) as terapis_count, absensi_shift,
						sum(terapis_count_day) as terapis_count_day, absensi_keterangan
					FROM(
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'a' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis on (absensi_bt.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'CT' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					
					UNION
						(SELECT distinct
							karyawan.karyawan_username,
							(ifnull(vu_report_tindakan_terapis_hf.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
							absensi_bt.".$absensi_shift." as absensi_shift,
							ifnull(vu_jterapis_hf.terapis_count_day,0) as terapis_count_day,
							absensi_bt.absensi_keterangan,
							'b' as diff
						FROM absensi_bt
							left join vu_report_tindakan_terapis_hf on (vu_report_tindakan_terapis_hf.terapis_id=absensi_bt.absensi_karyawan_id and vu_report_tindakan_terapis_hf.terapis_bulan = '$month')
							left join karyawan on (absensi_bt.absensi_karyawan_id = karyawan.karyawan_id)
							left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi_bt.absensi_karyawan_id and date_format(tindakan_adjust.adj_bln, '%Y-%m') = date_format('$dt', '%Y-%m') )
							left join vu_jterapis_hf on (absensi_bt.absensi_karyawan_id = vu_jterapis_hf.terapis_id and vu_jterapis_hf.terapis_bulan = '$dt')
							left join cabang on(karyawan.karyawan_cabang=cabang.cabang_id)
						where absensi_bt.".$absensi_shift." = 'CT' and absensi_bt.absensi_bulan = date_format('$dt', '%m') and absensi_bt.absensi_tahun = date_format('$dt', '%Y')
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(SELECT cabang_value 
							FROM cabang
							left join info on (cabang.cabang_id = info.info_cabang)
							where info.info_cabang = cabang.cabang_id),1) = '1')
						order by terapis_count_day desc, karyawan.karyawan_username asc) 
					) union_table
					GROUP BY  karyawan_username";
			
		$nbrows = 0;
		$nbrows2 = 0;
		$nbrows3 = 0;
		$nbrows4 = 0;
		$nbrows5 = 0;
		
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();

		$result2 = $this->db->query($query2);
		$nbrows2 = $result2->num_rows();
		
		$result3 = $this->db->query($query3);
		$nbrows3 = $result3->num_rows();
		
		$result4 = $this->db->query($query4);
		$nbrows4 = $result4->num_rows();
		
		$result5 = $this->db->query($query5);
		$nbrows5 = $result5->num_rows();
		
		$nbrows = $nbrows + $nbrows2 + $nbrows3 + $nbrows4 + $nbrows5;
		
		if($nbrows>0 || $nbrows2>0 || $nbrows3>0 || $nbrows4>0 || $nbrows5>0){
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
			}
			if($nbrows2>0){
				foreach($result2->result() as $row2){
					$arr[] = $row2;
				}
			}
			if($nbrows3>0){
				foreach($result3->result() as $row3){
					$arr[] = $row3;
				}
			}
			if($nbrows4>0){
				foreach($result4->result() as $row4){
					$arr[] = $row4;
				}
			}
			if($nbrows5>0){
				foreach($result5->result() as $row5){
					$arr[] = $row5;
				}
			}
			
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}
		
		
		function jadwal_terapis_search($lap_kunjungan_id ,$trawat_tglapp_start, $start,$end){
			//full query
			$dt=date('Y-m-d');
			$month=date('Y-m');
			if($trawat_tglapp_start!='')
			{
			$query = "SELECT distinct
						karyawan.karyawan_username,
						(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
						absensi.absensi_shift,
						absensi.absensi_tgl,
						ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
						absensi.absensi_keterangan
					FROM absensi
						left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = date_format('$trawat_tglapp_start','%Y-%m'))
						left join karyawan on (absensi.absensi_karyawan_id = karyawan.karyawan_id)
						left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi.absensi_karyawan_id and date_format(absensi.absensi_tgl, '%Y-%m') = date_format(tindakan_adjust.adj_bln, '%Y-%m'))
						left join vu_jterapis on (absensi.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$trawat_tglapp_start')
					where absensi.absensi_tgl = '$trawat_tglapp_start' and absensi.absensi_shift = 'P'";
		
			$query2 = "SELECT distinct
						karyawan.karyawan_username,
						(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
						absensi.absensi_shift,
						absensi.absensi_tgl,
						ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
						absensi.absensi_keterangan
					FROM absensi
						left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = date_format('$trawat_tglapp_start','%Y-%m'))
						left join karyawan on (absensi.absensi_karyawan_id = karyawan.karyawan_id)
						left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi.absensi_karyawan_id and date_format(absensi.absensi_tgl, '%Y-%m') = date_format(tindakan_adjust.adj_bln, '%Y-%m'))
						left join vu_jterapis on (absensi.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$trawat_tglapp_start')
					where absensi.absensi_tgl = '$trawat_tglapp_start' and absensi.absensi_shift = 'S'";
		
			$query3 = "SELECT distinct
						karyawan.karyawan_username,
						(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
						absensi.absensi_shift,
						absensi.absensi_tgl,
						ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
						absensi.absensi_keterangan
					FROM absensi
						left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = date_format('$trawat_tglapp_start','%Y-%m'))
						left join karyawan on (absensi.absensi_karyawan_id = karyawan.karyawan_id)
						left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi.absensi_karyawan_id and date_format(absensi.absensi_tgl, '%Y-%m') = date_format(tindakan_adjust.adj_bln, '%Y-%m'))
						left join vu_jterapis on (absensi.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$trawat_tglapp_start')
					where absensi.absensi_tgl = '$trawat_tglapp_start' and absensi.absensi_shift = 'M'";
	
			$query4 = "SELECT distinct
						karyawan.karyawan_username,
						(ifnull(vu_report_tindakan_terapis.terapis_count,0)+tindakan_adjust.adj_count) as terapis_count,
						absensi.absensi_shift,
						absensi.absensi_tgl,
						ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day,
						absensi.absensi_keterangan
					FROM absensi
						left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = date_format('$trawat_tglapp_start','%Y-%m'))
						left join karyawan on (absensi.absensi_karyawan_id = karyawan.karyawan_id)
						left join tindakan_adjust on (tindakan_adjust.karyawan_id = absensi.absensi_karyawan_id and date_format(absensi.absensi_tgl, '%Y-%m') = date_format(tindakan_adjust.adj_bln, '%Y-%m'))
						left join vu_jterapis on (absensi.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$trawat_tglapp_start')
					where absensi.absensi_tgl = '$trawat_tglapp_start' and absensi.absensi_shift = 'OFF'";
			}
			
			
			/*{
	$query = "SELECT distinct
						karyawan.karyawan_username,
						ifnull(vu_report_tindakan_terapis.terapis_count,0) as terapis_count,
						absensi.absensi_shift,
						absensi.absensi_tgl,
						ifnull(vu_jterapis.terapis_count_day,0) as terapis_count_day
					FROM absensi
						left join vu_report_tindakan_terapis on (vu_report_tindakan_terapis.terapis_id=absensi.absensi_karyawan_id and vu_report_tindakan_terapis.terapis_bulan = date_format('$trawat_tglapp_start','%Y-%m'))
						left join karyawan on (absensi.absensi_karyawan_id = karyawan.karyawan_id)
						left join vu_jterapis on (absensi.absensi_karyawan_id = vu_jterapis.terapis_id and vu_jterapis.terapis_bulan = '$trawat_tglapp_start')
					where absensi.absensi_tgl = '$trawat_tglapp_start'"; 
	}*/

	
			
			//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			//$query.=" k.karyawan_id != 60 and p.rawat_id is not null"; //60 = Available . Dr
			//$query.=" GROUP BY  karyawan.karyawan_username";
		
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();

		$result2 = $this->db->query($query2);
		$nbrows2 = $result2->num_rows();
		
		$result3 = $this->db->query($query3);
		$nbrows3 = $result3->num_rows();
		
		$result4 = $this->db->query($query4);
		$nbrows4 = $result4->num_rows();
		
		
		if($nbrows>0 || $nbrows2>0 || $nbrows3>0 || $nbrows4>0){
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
			}
			if($nbrows2>0){
				foreach($result2->result() as $row2){
					$arr[] = $row2;
				}
			}
			if($nbrows3>0){
				foreach($result3->result() as $row3){
					$arr[] = $row3;
				}
			}
			if($nbrows4>0){
				foreach($result4->result() as $row4){
					$arr[] = $row4;
				}
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
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
			}
		}*/
		
		
		
		//function for update record
		function penyesuaian_update($adj_id, $adj_count){
	
		$sql="SELECT * FROM tindakan_adjust where adj_id = '$adj_id'";
	
	$rs=$this->db->query($sql);
		if($rs->num_rows()){
		$data = array(
		
				"adj_count"=>$adj_count
			);
			$this->db->where('adj_id', $adj_id);
			$this->db->update('tindakan_adjust', $data);
		}
	
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		
		//function for print record
		/*function users_print($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query="SELECT * FROM users";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_id LIKE '%".addslashes($filter)."%' OR user_name LIKE '%".addslashes($filter)."%' OR user_passwd LIKE '%".addslashes($filter)."%' OR user_karyawan LIKE '%".addslashes($filter)."%' OR user_log LIKE '%".addslashes($filter)."%' OR user_groups LIKE '%".addslashes($filter)."%' OR user_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($user_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_id LIKE '%".$user_id."%'";
				};
				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_passwd!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_passwd LIKE '%".$user_passwd."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan LIKE '%".$user_karyawan."%'";
				};
				if($user_log!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_log LIKE '%".$user_log."%'";
				};
				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups LIKE '%".$user_groups."%'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}*/
		
		//function  for export to excel
		/*function users_export_excel($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query="SELECT * FROM users";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_id LIKE '%".addslashes($filter)."%' OR user_name LIKE '%".addslashes($filter)."%' OR user_passwd LIKE '%".addslashes($filter)."%' OR user_karyawan LIKE '%".addslashes($filter)."%' OR user_log LIKE '%".addslashes($filter)."%' OR user_groups LIKE '%".addslashes($filter)."%' OR user_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($user_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_id LIKE '%".$user_id."%'";
				};
				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_passwd!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_passwd LIKE '%".$user_passwd."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan LIKE '%".$user_karyawan."%'";
				};
				if($user_log!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_log LIKE '%".$user_log."%'";
				};
				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups LIKE '%".$user_groups."%'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}*/
		

}
?>