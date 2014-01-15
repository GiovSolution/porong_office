<? /* 
	+ Module  		: Crm Generator Model
	+ Description	: For record model process back-end
	+ Filename 		: c_crm_generator.php
 	+ creator 		: Fred
	
*/

class M_crm_generator extends Model{
		
		//constructor
		function M_crm_generator() {
			parent::Model();
		}
		
		
	function get_customer_list2($query,$start,$end){
		$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point FROM customer WHERE cust_aktif='Aktif'";
		if($query<>""){
			$sql=$sql." and (cust_id = '".$query."' or cust_no like '%".$query."%' or cust_alamat like '%".$query."%' or cust_nama like '%".$query."%' or cust_telprumah like '%".$query."%' or cust_telprumah2 like '%".$query."%' or cust_telpkantor like '%".$query."%' or cust_hp like '%".$query."%' or cust_hp2 like '%".$query."%' or cust_hp3 like '%".$query."%') ";
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
		
	
		//function for get list record
		function crm_generator_list($filter,$start,$end){
		
			$query = 
			   "SELECT 
					crmvalue_id, crmvalue_date, c1.cust_nama as crmvalue_cust, c1.cust_no as crmvalue_cust_no, crmvalue_frequency, crmvalue_recency, 
					crmvalue_spending, crmvalue_highmargin, crmvalue_referal, crmvalue_kerewelan, crmvalue_disiplin_batal, crmvalue_disiplin_telat, crmvalue_treatment,
					crmvalue_total,	crmvalue_priority,
					crmvalue_frequency_real, crmvalue_recency_real, crmvalue_spending_real_rp, crmvalue_spending_real_kunj, crmvalue_highmargin_real, crmvalue_referal_real,
					crmvalue_kerewelan_real, crmvalue_disiplin_batal_real, crmvalue_disiplin_telat_real, crmvalue_treatment_medis_real, crmvalue_treatment_non_medis_real
				FROM crm_value
				left join customer c1 on (c1.cust_id = crm_value.crmvalue_cust)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (crmvalue_id LIKE '%".addslashes($filter)."%' OR crmvalue_date LIKE '%".addslashes($filter)."%' OR crmvalue_cust LIKE '%".addslashes($filter)."%' OR crmvalue_frequency LIKE '%".addslashes($filter)."%' )";
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
		
		
		//function for generate value CRM. 2011-03-22 --> function ini sudah dipindahkan ke m_public_function
/*		function crm_generator_create($query, $crmvalue_id, $crmvalue_cust, $crmvalue_date, $crmvalue_frequency, $crmvalue_recency, $crmvalue_spending, $crmvalue_highmargin, $crmvalue_referal, $crmvalue_kerewelan, $crmvalue_disiplin, $crmvalue_treatment, $crmvalue_author){
			$datetime_now=date('Y-m-d H:i:s');
			
			//untuk mendapatkan parameter di crm_setup
			$sql_parameter = 
			   "select max(setcrm_id) as setcrm_id, 
					c.setcrm_frequency_count, c.setcrm_frequency_days, 
					c.setcrm_frequency_value_morethan, c.setcrm_frequency_value_equal, c.setcrm_frequency_value_lessthan,
					c.setcrm_recency_days, c.setcrm_recency_value_morethan, c.setcrm_recency_value_lessthan, 
					c.setcrm_spending_days, c.setcrm_spending_value_lessthan, c.setcrm_spending_value_equal, c.setcrm_spending_value_morethan,
					c.setcrm_highmargin_treatment, c.setcrm_highmargin_days, 
					c.setcrm_highmargin_value_morethan, c.setcrm_highmargin_value_equal, c.setcrm_highmargin_value_lessthan,
					c.setcrm_referal_person, c.setcrm_referal_days, c.setcrm_referal_morethan, c.setcrm_referal_equal, c.setcrm_referal_lessthan,
					c.setcrm_kerewelan_high, c.setcrm_kerewelan_normal, c.setcrm_kerewelan_low,
					c.setcrm_result_nilai_atas, c.setcrm_result_nilai_bawah,
					c.setcrm_disiplin_days, c.setcrm_disiplin_persentase_pembatalan, 
					c.setcrm_disiplin_batal_value_morethan, c.setcrm_disiplin_batal_value_lessthan,
					c.setcrm_disiplin_persentase_telat, c.setcrm_disiplin_menit_telat, c.setcrm_disiplin_telat_value_morethan, c.setcrm_disiplin_telat_value_lessthan,
					c.setcrm_treatment_days, c.setcrm_treatment_nonmedis, c.setcrm_treatment_medis, c.setcrm_treatment_morethan, c.setcrm_treatment_equal, c.setcrm_treatment_lessthan
				from crm_setup c";
			
			$query_parameter				= $this->db->query($sql_parameter);
			$data_parameter 				= $query_parameter->row();
			
			$setcrm_frequency_count			= $data_parameter->setcrm_frequency_count;
			$setcrm_frequency_days 			= $data_parameter->setcrm_frequency_days;
			$setcrm_frequency_value_lessthan= $data_parameter->setcrm_frequency_value_lessthan;
			$setcrm_frequency_value_equal 	= $data_parameter->setcrm_frequency_value_equal;
			$setcrm_frequency_value_morethan= $data_parameter->setcrm_frequency_value_morethan;
			
			$setcrm_recency_days 			= $data_parameter->setcrm_recency_days;
			$setcrm_recency_value_lessthan 	= $data_parameter->setcrm_recency_value_lessthan;
			$setcrm_recency_value_morethan 	= $data_parameter->setcrm_recency_value_morethan;
			
			$setcrm_spending_days			= $data_parameter->setcrm_spending_days;
			$setcrm_spending_value_lessthan	= $data_parameter->setcrm_spending_value_lessthan;
			$setcrm_spending_value_equal 	= $data_parameter->setcrm_spending_value_equal;
			$setcrm_spending_value_morethan	= $data_parameter->setcrm_spending_value_morethan;
			
			$setcrm_highmargin_treatment		= $data_parameter->setcrm_highmargin_treatment;
			$setcrm_highmargin_days				= $data_parameter->setcrm_highmargin_days;
			$setcrm_highmargin_value_morethan	= $data_parameter->setcrm_highmargin_value_morethan;
			$setcrm_highmargin_value_equal		= $data_parameter->setcrm_highmargin_value_equal;
			$setcrm_highmargin_value_lessthan	= $data_parameter->setcrm_highmargin_value_lessthan;
			
			$setcrm_referal_person			= $data_parameter->setcrm_referal_person;
			$setcrm_referal_days			= $data_parameter->setcrm_referal_days;
			$setcrm_referal_morethan		= $data_parameter->setcrm_referal_morethan;
			$setcrm_referal_equal			= $data_parameter->setcrm_referal_equal;
			$setcrm_referal_lessthan		= $data_parameter->setcrm_referal_lessthan;
			
			$setcrm_kerewelan_high			= $data_parameter->setcrm_kerewelan_high;
			$setcrm_kerewelan_normal		= $data_parameter->setcrm_kerewelan_normal;
			$setcrm_kerewelan_low			= $data_parameter->setcrm_kerewelan_low;
			
			$setcrm_disiplin_days					= $data_parameter->setcrm_disiplin_days;
			$setcrm_disiplin_persentase_pembatalan	= $data_parameter->setcrm_disiplin_persentase_pembatalan;
			$setcrm_disiplin_batal_value_morethan	= $data_parameter->setcrm_disiplin_batal_value_morethan;
			$setcrm_disiplin_batal_value_lessthan	= $data_parameter->setcrm_disiplin_batal_value_lessthan;
			$setcrm_disiplin_persentase_telat		= $data_parameter->setcrm_disiplin_persentase_telat;
			$setcrm_disiplin_menit_telat			= $data_parameter->setcrm_disiplin_menit_telat;
			$setcrm_disiplin_telat_value_morethan	= $data_parameter->setcrm_disiplin_telat_value_morethan;
			$setcrm_disiplin_telat_value_lessthan	= $data_parameter->setcrm_disiplin_telat_value_lessthan;
			
			$setcrm_treatment_days					= $data_parameter->setcrm_treatment_days; 
			$setcrm_treatment_nonmedis				= $data_parameter->setcrm_treatment_nonmedis; 
			$setcrm_treatment_medis					= $data_parameter->setcrm_treatment_medis;
			$setcrm_treatment_morethan				= $data_parameter->setcrm_treatment_morethan; 
			$setcrm_treatment_equal					= $data_parameter->setcrm_treatment_equal;
			$setcrm_treatment_lessthan				= $data_parameter->setcrm_treatment_lessthan;
			
			$setcrm_result_nilai_atas		= $data_parameter->setcrm_result_nilai_atas;
			$setcrm_result_nilai_bawah		= $data_parameter->setcrm_result_nilai_bawah;
			
	
			//UNTUK MENGHITUNG FREQUENCY:
			//selalu sesuaikan query dengan query di m_lap_kunjungan.php
			
			$sql_value_kunjungan_by_freq =
			   "select 
					sum(jum_total) as tot_kunjungan_cust
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0  
							and (p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and date_add(m.jrawat_tanggal, interval '$setcrm_frequency_days' day) >= date_format(now(), '%Y-%m-%d') and m.jrawat_cust = '$crmvalue_cust'
						
						union
						
						select 
							m.jproduk_cust as cust,
							m.jproduk_tanggal as tgl_tindakan
						from master_jual_produk m
						where 
							m.jproduk_stat_dok = 'Tertutup' and m.jproduk_bayar <> 0 
							and date_add(m.jproduk_tanggal, interval '$setcrm_frequency_days' day) >= date_format(now(), '%Y-%m-%d') and m.jproduk_cust = '$crmvalue_cust'
												
						union
						
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						where 
							(p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and d.dapaket_stat_dok = 'Tertutup' 							
							and date_add(d.dapaket_tgl_ambil, interval '$setcrm_frequency_days' day) >= date_format(now(), '%Y-%m-%d') and d.dapaket_cust = '$crmvalue_cust'
						
						)
						as table_union2
						
					group by tgl_tindakan
					)
				as tabel
			";
			   

			$query_kunjungan_by_freq	= $this->db->query($sql_value_kunjungan_by_freq);
			$data_kunjungan_by_freq		= $query_kunjungan_by_freq->row();
			$tot_kunjungan_cust_by_freq	= $data_kunjungan_by_freq->tot_kunjungan_cust;
			
			if ($tot_kunjungan_cust_by_freq <= $setcrm_frequency_count){
				$crmvalue_frequency = $setcrm_frequency_value_lessthan;
			}
			else if ($tot_kunjungan_cust_by_freq == $setcrm_frequency_count){
				$crmvalue_frequency = $setcrm_frequency_value_equal;
			}
			else if ($tot_kunjungan_cust_by_freq >= $setcrm_frequency_count){
				$crmvalue_frequency = $setcrm_frequency_value_morethan;
			}
			
			
			//UNTUK MENGHITUNG RECENCY:
			
			$sql_value_recency = 
			   "select dapaket_id as id
				from detail_ambil_paket d
				where date_add(d.dapaket_tgl_ambil, interval '$setcrm_recency_days' day) >= date_format(now(), '%Y-%m-%d') and dapaket_cust = '$crmvalue_cust'
				
				union
				
				select d2.drawat_id as id
				from detail_jual_rawat d2
				left join master_jual_rawat m2 on m2.jrawat_id = d2.drawat_master
				where date_add(m2.jrawat_tanggal, interval '$setcrm_recency_days' day) >= date_format(now(), '%Y-%m-%d') and m2.jrawat_cust = '$crmvalue_cust'

				union
				
				select d3.dproduk_id as id
				from detail_jual_produk d3
				left join master_jual_produk m3 on m3.jproduk_id = d3.dproduk_master
				where date_add(m3.jproduk_tanggal, interval '$setcrm_recency_days' day) >= date_format(now(), '%Y-%m-%d') and m3.jproduk_cust = '$crmvalue_cust'
				";
			$query_recency	= $this->db->query($sql_value_recency);
			$recency_row 	= $query_recency->num_rows();
			
			if($recency_row==0){
				$crmvalue_recency = $setcrm_recency_value_lessthan;
			}
			else if($recency_row>=1){
				$crmvalue_recency = $setcrm_recency_value_morethan;
			}
			
			
			//UNTUK MENGHITUNG SPENDING:
			
			//menghitung Total Spending ALL-->(selalu sesuaikan dg m_report_rekap_penjualan)
			//Spending Produk:
			$sql_spending_produk_all = 
			   "SELECT 
					(SUM((d.dproduk_jumlah * d.dproduk_harga)-((d.dproduk_jumlah * d.dproduk_harga)*d.dproduk_diskon/100)) - 
					SUM((m.jproduk_diskon *((d.dproduk_jumlah * d.dproduk_harga)-((d.dproduk_jumlah * d.dproduk_harga)*d.dproduk_diskon/100))) /100)) -
					IFNULL 
					  ((SELECT SUM(dr.drproduk_jumlah*dr.drproduk_harga) 
						FROM detail_retur_jual_produk dr
						LEFT JOIN master_retur_jual_produk mr ON dr.drproduk_master = mr.rproduk_id
						WHERE 
							date_add(mr.rproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND mr.rproduk_stat_dok = 'Tertutup' ),0) 
					AS tot_net
				FROM detail_jual_produk d
				LEFT JOIN master_jual_produk m ON d.dproduk_master = m.jproduk_id
				WHERE
					date_add(m.jproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND m.jproduk_stat_dok = 'Tertutup'";
			
			$query_spending_produk_all	= $this->db->query($sql_spending_produk_all);
			$data_spending_produk_all	= $query_spending_produk_all->row();
			$jum_spending_produk_all	= $data_spending_produk_all->tot_net;
			
			//Spending Perawatan:
			$sql_spending_perawatan_all = 
			   "SELECT 
					(SUM((d.drawat_jumlah * d.drawat_harga)-((d.drawat_jumlah * d.drawat_harga)*d.drawat_diskon/100)) - 
						SUM((M.jrawat_diskon *((d.drawat_jumlah * d.drawat_harga)-((d.drawat_jumlah * d.drawat_harga)*d.drawat_diskon/100))) /100)) AS grand_total
				FROM detail_jual_rawat d
				LEFT JOIN master_jual_rawat M ON d.drawat_master = M.jrawat_id
				LEFT JOIN perawatan ON d.drawat_rawat = perawatan.rawat_id
				LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id
				WHERE
					date_add(m.jrawat_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND m.jrawat_stat_dok = 'Tertutup'";
			
			$query_spending_perawatan_all	= $this->db->query($sql_spending_perawatan_all);
			$data_spending_perawatan_all	= $query_spending_perawatan_all->row();
			$jum_spending_perawatan_all		= $data_spending_perawatan_all->grand_total;
			
			//Spending Pengambilan Paket:
			 $sql_spending_apaket_all =
			   "select 
					SUM(d.dapaket_jumlah * 
						(((((dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100) * dj.dpaket_jumlah) - 
						(((m.jpaket_diskon * (dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100)) * dj.dpaket_jumlah) / 100)) / dj.dpaket_jumlah) / v.isi_paket) -
						(((((m.jpaket_diskon * (dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100)) * dj.dpaket_jumlah) / 100)) / dj.dpaket_jumlah) / v.isi_paket) AS tot_net
				from detail_ambil_paket d
				join master_jual_paket m on m.jpaket_id = d.dapaket_jpaket 
				left join vu_jumlah_isi_paket v on d.dapaket_paket = v.paket_id
				left join detail_jual_paket dj on d.dapaket_dpaket = dj.dpaket_id
				WHERE
					date_add(d.dapaket_tgl_ambil, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND d.dapaket_stat_dok = 'Tertutup'";
			
			$query_spending_apaket_all	= $this->db->query($sql_spending_apaket_all);
			$data_spending_apaket_all	= $query_spending_apaket_all->row();
			$jum_spending_apaket_all	= $data_spending_apaket_all->tot_net;
			
			//Total Spending (Produk + Perawatan + Pengambilan Paket):
			$tot_spending_all	= $jum_spending_produk_all + $jum_spending_perawatan_all + $jum_spending_apaket_all;
			
			//menghitung Total Kunjungan ALL
			//selalu sesuaikan query dengan query di m_lap_kunjungan.php
			$sql_value_kunjungan_all =
			   "select 
					sum(jum_total) as tot_kunjungan_all
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0  
							and (p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and date_add(m.jrawat_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d')
						
						union
						
						select 
							m.jproduk_cust as cust,
							m.jproduk_tanggal as tgl_tindakan
						from master_jual_produk m
						where 
							m.jproduk_stat_dok = 'Tertutup' and m.jproduk_bayar <> 0 
							and date_add(m.jproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d')
												
						union
						
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						where 
							(p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and d.dapaket_stat_dok = 'Tertutup' 							
							and date_add(d.dapaket_tgl_ambil, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d')
						
						)
						as table_union2
						
					group by tgl_tindakan
			)
			as tabel
			";
			   
			$query_kunjungan_all	= $this->db->query($sql_value_kunjungan_all);
			$data_kunjungan_all		= $query_kunjungan_all->row();
			$tot_kunjungan_all		= $data_kunjungan_all->tot_kunjungan_all;
			
			$spending_avg			= $tot_spending_all / $tot_kunjungan_all;
			
			//menghitung Total Spending CUST ybs-->(selalu sesuaikan dg m_report_rekap_penjualan)
			//Spending Produk:
			$sql_spending_produk_cust = 
			   "SELECT 
					(SUM((d.dproduk_jumlah * d.dproduk_harga)-((d.dproduk_jumlah * d.dproduk_harga)*d.dproduk_diskon/100)) - 
					SUM((m.jproduk_diskon *((d.dproduk_jumlah * d.dproduk_harga)-((d.dproduk_jumlah * d.dproduk_harga)*d.dproduk_diskon/100))) /100)) -
					IFNULL 
					  ((SELECT SUM(dr.drproduk_jumlah*dr.drproduk_harga) 
						FROM detail_retur_jual_produk dr
						LEFT JOIN master_retur_jual_produk mr ON dr.drproduk_master = mr.rproduk_id
						WHERE 
							date_add(mr.rproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND mr.rproduk_cust = '$crmvalue_cust' AND
							mr.rproduk_stat_dok = 'Tertutup' ),0) 
					AS tot_net
				FROM detail_jual_produk d
				LEFT JOIN master_jual_produk m ON d.dproduk_master = m.jproduk_id
				WHERE
					date_add(m.jproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND m.jproduk_cust = '$crmvalue_cust' AND
					m.jproduk_stat_dok = 'Tertutup'";
			
			$query_spending_produk_cust	= $this->db->query($sql_spending_produk_cust);
			$data_spending_produk_cust	= $query_spending_produk_cust->row();
			$jum_spending_produk_cust	= $data_spending_produk_cust->tot_net;
			
			//Spending Perawatan:
			$sql_spending_perawatan_cust = 
			   "SELECT 
					(SUM((d.drawat_jumlah * d.drawat_harga)-((d.drawat_jumlah * d.drawat_harga)*d.drawat_diskon/100)) - 
						SUM((M.jrawat_diskon *((d.drawat_jumlah * d.drawat_harga)-((d.drawat_jumlah * d.drawat_harga)*d.drawat_diskon/100))) /100)) AS grand_total
				FROM detail_jual_rawat d
				LEFT JOIN master_jual_rawat M ON d.drawat_master = M.jrawat_id
				LEFT JOIN perawatan ON d.drawat_rawat = perawatan.rawat_id
				LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id
				WHERE
					date_add(m.jrawat_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND m.jrawat_cust = '$crmvalue_cust' AND
					m.jrawat_stat_dok = 'Tertutup'";
			
			$query_spending_perawatan_cust	= $this->db->query($sql_spending_perawatan_cust);
			$data_spending_perawatan_cust	= $query_spending_perawatan_cust->row();
			$jum_spending_perawatan_cust	= $data_spending_perawatan_cust->grand_total;
			
			//Spending Pengambilan Paket:
			 $sql_spending_apaket_cust =
			   "select 
					SUM(d.dapaket_jumlah * 
						(((((dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100) * dj.dpaket_jumlah) - 
						(((m.jpaket_diskon * (dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100)) * dj.dpaket_jumlah) / 100)) / dj.dpaket_jumlah) / v.isi_paket) -
						(((((m.jpaket_diskon * (dj.dpaket_harga * (100 - dj.dpaket_diskon) / 100)) * dj.dpaket_jumlah) / 100)) / dj.dpaket_jumlah) / v.isi_paket) AS tot_net
				from detail_ambil_paket d
				join master_jual_paket m on m.jpaket_id = d.dapaket_jpaket 
				left join vu_jumlah_isi_paket v on d.dapaket_paket = v.paket_id
				left join detail_jual_paket dj on d.dapaket_dpaket = dj.dpaket_id
				WHERE
					date_add(d.dapaket_tgl_ambil, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') AND m.jpaket_cust = '$crmvalue_cust' AND
					d.dapaket_stat_dok = 'Tertutup'";
			
			$query_spending_apaket_cust	= $this->db->query($sql_spending_apaket_cust);
			$data_spending_apaket_cust	= $query_spending_apaket_cust->row();
			$jum_spending_apaket_cust	= $data_spending_apaket_cust->tot_net;
			
			//Total Spending (Produk + Perawatan + Pengambilan Paket):
			if ($jum_spending_produk_cust == null) {$jum_spending_produk_cust = 0;}
			if ($jum_spending_perawatan_cust == null) {$jum_spending_perawatan_cust = 0;}
			if ($jum_spending_apaket_cust == null) {$jum_spending_apaket_cust = 0;}
			
			$tot_spending_cust	= $jum_spending_produk_cust + $jum_spending_perawatan_cust + $jum_spending_apaket_cust;
			
			//menghitung Total Kunjungan CUST
			//selalu sesuaikan query dengan query di m_lap_kunjungan.php
			$sql_value_kunjungan_cust =
			   "select 
					sum(jum_total) as tot_kunjungan_cust
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0  
							and (p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and date_add(m.jrawat_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') and m.jrawat_cust = '$crmvalue_cust'
						
						union
						
						select 
							m.jproduk_cust as cust,
							m.jproduk_tanggal as tgl_tindakan
						from master_jual_produk m
						where 
							m.jproduk_stat_dok = 'Tertutup' and m.jproduk_bayar <> 0 
							and date_add(m.jproduk_tanggal, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') and m.jproduk_cust = '$crmvalue_cust'
												
						union
						
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						where 
							(p.rawat_kategori = 2 or p.rawat_kategori = 3 or p.rawat_kategori = 4 or p.rawat_kategori = 16)
							and d.dapaket_stat_dok = 'Tertutup' 							
							and date_add(d.dapaket_tgl_ambil, interval '$setcrm_spending_days' day) >= date_format(now(), '%Y-%m-%d') and d.dapaket_cust = '$crmvalue_cust'
						
						)
						as table_union2
						
					group by tgl_tindakan
			)
			as tabel
			";
			   
			$query_kunjungan_cust	= $this->db->query($sql_value_kunjungan_cust);
			$data_kunjungan_cust	= $query_kunjungan_cust->row();
			$tot_kunjungan_cust		= $data_kunjungan_cust->tot_kunjungan_cust;
			
			if (($tot_kunjungan_cust == 0) or ($tot_kunjungan_cust == null)) {
				$tot_kunjungan_cust	= 0;
				$spending_avg_cust 	= 0;
			} 
			else {
				$spending_avg_cust	= $tot_spending_cust / $tot_kunjungan_cust;
			}

			if ($spending_avg_cust > $spending_avg) {
				$crmvalue_spending = $setcrm_spending_value_morethan;
			}
			else if ($spending_avg_cust == $spending_avg) {
				$crmvalue_spending = $setcrm_spending_value_equal;
			}
			else if ($spending_avg_cust < $spending_avg) {
				$crmvalue_spending = $setcrm_spending_value_lessthan;
			}
			
			
						//UNTUK MENENTUKAN HIGH MARGIN TX
			$sql_value_highmargin =
			   "select 
					sum(jum_total) as tot_highmargin
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0 and p.rawat_highmargin = 1 and
							date_add(m.jrawat_tanggal, interval '$setcrm_highmargin_days' day) >= date_format(now(), '%Y-%m-%d') and m.jrawat_cust = '$crmvalue_cust'
						
						union
												
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							d.dapaket_stat_dok = 'Tertutup' and p.rawat_highmargin = 1 and
							date_add(d.dapaket_tgl_ambil, interval '$setcrm_highmargin_days' day) >= date_format(now(), '%Y-%m-%d') and d.dapaket_cust = '$crmvalue_cust'
						
						)
						as table_union2
						
					group by tgl_tindakan
			)
			as tabel";
			

			$query_highmargin	= $this->db->query($sql_value_highmargin);
			$data_highmargin	= $query_highmargin->row();
			$tot_highmargin		= $data_highmargin->tot_highmargin;
			
			if ($tot_highmargin == null) {$tot_highmargin = 0;}
			
			if ($tot_highmargin > $setcrm_highmargin_treatment){
				$crmvalue_highmargin = $setcrm_highmargin_value_morethan;
			}
			else if ($tot_highmargin == $setcrm_highmargin_treatment){
				$crmvalue_highmargin = $setcrm_highmargin_value_equal;
			}
			else {
				$crmvalue_highmargin = $setcrm_highmargin_value_lessthan;
			}
			
			
			//UNTUK MENGHITUNG REFERAL RATE:
			
			$sql_value_referal = 
			   "select count(c.cust_id) as jum_referal
			    from customer c
				where date_add(c.cust_terdaftar, interval '$setcrm_referal_days' day) >= date_format(now(), '%Y-%m-%d') and c.cust_referensi = '$crmvalue_cust'
				";
			$query_referal	= $this->db->query($sql_value_referal);
			$data_referal	= $query_referal->row();
			$jum_referal	= $data_referal->jum_referal;
			
			
			if ($jum_referal > $setcrm_referal_person) {
				$crmvalue_referal = $setcrm_referal_morethan;
			}
			else if ($jum_referal == $setcrm_referal_person) {
				$crmvalue_referal = $setcrm_referal_equal;
			}
			else if ($jum_referal < $setcrm_referal_person) {
				$crmvalue_referal = $setcrm_referal_lessthan;
			}
			
			
			//UNTUK MENGHITUNG FRETFULNESSS
			
			$sql_value_fretfulness = 
			   "SELECT cust_fretfulness FROM customer WHERE cust_id = '$crmvalue_cust'";
			$query_fretfulness	= $this->db->query($sql_value_fretfulness);
			$data_fretfulness	= $query_fretfulness->row();
			$cust_fretfulness	= $data_fretfulness->cust_fretfulness;
			
			if ($cust_fretfulness == 'High') {
				$crmvalue_fretfulness = $setcrm_kerewelan_high;
			}
			else if (($cust_fretfulness == 'Medium') or ($cust_fretfulness == 'Undefined')) {
				$crmvalue_fretfulness = $setcrm_kerewelan_normal;
			}
			else if ($cust_fretfulness == 'Low') {
				$crmvalue_fretfulness = $setcrm_kerewelan_low;
			}
				
			
			//UNTUK MENGHITUNG DISIPLIN: BATAL
			
			$sql_value_app_batal = 
			   "SELECT count(d.dapp_id) as total_app_batal
				FROM appointment_detail d
				LEFT JOIN appointment a on a.app_id = d.dapp_master
				WHERE 
					d.dapp_status = 'batal' AND 
					date_add(a.app_tanggal, interval '$setcrm_disiplin_days' day) >= date_format(now(), '%Y-%m-%d') AND a.app_customer = '$crmvalue_cust'";
			$query_app_batal 	= $this->db->query($sql_value_app_batal);
			$data_app_batal		= $query_app_batal->row();
			$total_app_batal	= $data_app_batal->total_app_batal;

			$sql_value_app_all = 
			   "SELECT count(d.dapp_id) as total_app_all
				FROM appointment_detail d
				LEFT JOIN appointment a on a.app_id = d.dapp_master
				WHERE 
					date_add(a.app_tanggal, interval '$setcrm_disiplin_days' day) >= date_format(now(), '%Y-%m-%d') AND a.app_customer = '$crmvalue_cust'";
			$query_app_all 		= $this->db->query($sql_value_app_all);
			$data_app_all		= $query_app_all->row();
			$total_app_all		= $data_app_all->total_app_all;
			
			if ($total_app_all == 0) {	//menghindari division by zero
				$crmvalue_disiplin_batal = $setcrm_disiplin_batal_value_morethan;
			} else {
				if (($total_app_batal / $total_app_all) >= ($setcrm_disiplin_persentase_pembatalan / 100)) {
					$crmvalue_disiplin_batal = $setcrm_disiplin_batal_value_morethan;
				}
				else {
					$crmvalue_disiplin_batal = $setcrm_disiplin_batal_value_lessthan;
				}				
			}
						
			
			//UNTUK MENGHITUNG DISIPLIN: TELAT
			
			$sql_value_app_dtg_telat = 
			   "SELECT count(d.dapp_id) as total_app_dtg_telat
				FROM appointment_detail d
				LEFT JOIN appointment a on a.app_id = d.dapp_master
				WHERE 
					d.dapp_status = 'datang' AND time_to_sec(timediff(d.dapp_jamdatang, d.dapp_jamreservasi)) > ($setcrm_disiplin_menit_telat * 60) AND
					date_add(a.app_tanggal, interval '$setcrm_disiplin_days' day) >= date_format(now(), '%Y-%m-%d') AND a.app_customer = '$crmvalue_cust'";
			$query_app_dtg_telat 	= $this->db->query($sql_value_app_dtg_telat);
			$data_app_dtg_telat		= $query_app_dtg_telat->row();
			$total_app_dtg_telat	= $data_app_dtg_telat->total_app_dtg_telat;

			$sql_value_app_dtg_all = 
			   "SELECT count(d.dapp_id) as total_app_dtg_all
				FROM appointment_detail d
				LEFT JOIN appointment a on a.app_id = d.dapp_master
				WHERE 
					d.dapp_status = 'datang' AND
					date_add(a.app_tanggal, interval '$setcrm_disiplin_days' day) >= date_format(now(), '%Y-%m-%d') AND a.app_customer = '$crmvalue_cust'";
			$query_app_dtg_all 		= $this->db->query($sql_value_app_dtg_all);
			$data_app_dtg_all		= $query_app_dtg_all->row();
			$total_app_dtg_all		= $data_app_dtg_all->total_app_dtg_all;
			
			if ($total_app_dtg_all == 0) { //menghindari division by zero
				$crmvalue_disiplin_telat = $setcrm_disiplin_telat_value_morethan;
			} else {
				if (($total_app_dtg_telat / $total_app_dtg_all) >= ($setcrm_disiplin_persentase_telat / 100)) {
					$crmvalue_disiplin_telat = $setcrm_disiplin_telat_value_morethan;
				}
				else {
					$crmvalue_disiplin_telat = $setcrm_disiplin_telat_value_lessthan;
				}				
			}
			
			
			//UNTUK MENGHITUNG JUMLAH TREATMENT UTAMA
			//selalu sesuaikan query dengan query di m_lap_kunjungan.php
			
			//medis
			$sql_value_tx_utama_medis =
			   "select 
					sum(jum_total) as tot_tx_utama_medis
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0  and g1.group_treatment_utama = 1 and
							(p.rawat_kategori = 2 or p.rawat_kategori = 4 or p.rawat_kategori = 16) and
							date_add(m.jrawat_tanggal, interval '$setcrm_treatment_days' day) >= date_format(now(), '%Y-%m-%d') and m.jrawat_cust = '$crmvalue_cust'
						
						union
												
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							d.dapaket_stat_dok = 'Tertutup' and g1.group_treatment_utama = 1 and
							(p.rawat_kategori = 2 or p.rawat_kategori = 4 or p.rawat_kategori = 16) and
							date_add(d.dapaket_tgl_ambil, interval '$setcrm_treatment_days' day) >= date_format(now(), '%Y-%m-%d') and d.dapaket_cust = '$crmvalue_cust'
						
						)
						as table_union2
						
					group by tgl_tindakan
			)
			as tabel";
			
			$query_tx_utama_medis	= $this->db->query($sql_value_tx_utama_medis);
			$data_tx_utama_medis	= $query_tx_utama_medis->row();
			$tot_tx_utama_medis		= $data_tx_utama_medis->tot_tx_utama_medis;
			
			//medis
			$sql_value_tx_utama_non_medis =
			   "select 
					sum(jum_total) as tot_tx_utama_non_medis
				from
				   (select 
						count(distinct cust) as jum_total
					from
						(
						select 
							m.jrawat_cust as cust,
							m.jrawat_tanggal as tgl_tindakan
						from detail_jual_rawat d
						left join master_jual_rawat m on (d.drawat_master = m.jrawat_id)
						left join perawatan p on (d.drawat_rawat=p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							m.jrawat_stat_dok = 'Tertutup' and m.jrawat_bayar <> 0  and g1.group_treatment_utama = 1 and
							p.rawat_kategori = 3 and
							date_add(m.jrawat_tanggal, interval '$setcrm_treatment_days' day) >= date_format(now(), '%Y-%m-%d') and m.jrawat_cust = '$crmvalue_cust'
						
						union
												
						select 
							d.dapaket_cust as cust,
							d.dapaket_tgl_ambil as tgl_tindakan
						from detail_ambil_paket d
						left join perawatan p on (d.dapaket_item = p.rawat_id)
						left join produk_group g1 on g1.group_id = p.rawat_group
						where 
							d.dapaket_stat_dok = 'Tertutup' and g1.group_treatment_utama = 1 and
							p.rawat_kategori = 3 and
							date_add(d.dapaket_tgl_ambil, interval '$setcrm_treatment_days' day) >= date_format(now(), '%Y-%m-%d') and d.dapaket_cust = '$crmvalue_cust'
						
						)
						as table_union2
						
					group by tgl_tindakan
			)
			as tabel";
			

			$query_tx_utama_non_medis	= $this->db->query($sql_value_tx_utama_non_medis);
			$data_tx_utama_non_medis	= $query_tx_utama_non_medis->row();
			$tot_tx_utama_non_medis		= $data_tx_utama_non_medis->tot_tx_utama_non_medis;
			
			if (($tot_tx_utama_non_medis > $setcrm_treatment_nonmedis) and ($tot_tx_utama_medis > $setcrm_treatment_medis)){
				$crmvalue_treatment = $setcrm_treatment_morethan;
			}
			else if (($tot_tx_utama_non_medis == $setcrm_treatment_nonmedis) and ($tot_tx_utama_medis == $setcrm_treatment_medis)){
				$crmvalue_treatment = $setcrm_treatment_equal;
			}
			else {
				$crmvalue_treatment = $setcrm_treatment_lessthan;
			}
			

			//UNTUK MENENTUKAN PRIORITY
			$crmvalue_total   = $crmvalue_frequency + $crmvalue_recency + $crmvalue_spending + $crmvalue_highmargin + $crmvalue_referal + $crmvalue_fretfulness +
								$crmvalue_disiplin_batal + $crmvalue_disiplin_telat + $crmvalue_treatment;
			
			if ($crmvalue_total > $setcrm_result_nilai_atas){
				$crmvalue_priority = 'Core';
			}
			else if (($crmvalue_total <= $setcrm_result_nilai_atas) and ($crmvalue_total >= $setcrm_result_nilai_bawah)){
				$crmvalue_priority = 'Medium';
			}
			else if ($crmvalue_total < $setcrm_result_nilai_bawah){
				$crmvalue_priority = 'Low';
			}
			
			if ($total_app_all == 0) {$crmvalue_disiplin_batal_real = 0;} else {$crmvalue_disiplin_batal_real = ($total_app_batal / $total_app_all);}
			if ($total_app_dtg_all == 0) {$crmvalue_disiplin_telat_real = 0;} else {$crmvalue_disiplin_telat_real = ($total_app_dtg_telat / $total_app_dtg_all);}					
			$data=array(
				"crmvalue_frequency"			=> $crmvalue_frequency,
				"crmvalue_frequency_real"		=> $tot_kunjungan_cust_by_freq,
				"crmvalue_recency"				=> $crmvalue_recency,
				"crmvalue_recency_real"			=> $recency_row,
				"crmvalue_spending"				=> $crmvalue_spending,	
				"crmvalue_spending_real_rp"		=> $tot_spending_cust,	
				"crmvalue_spending_real_kunj"	=> $tot_kunjungan_cust,		
				"crmvalue_highmargin"			=> $crmvalue_highmargin,
				"crmvalue_highmargin_real"		=> $tot_highmargin,
				"crmvalue_referal"				=> $crmvalue_referal,
				"crmvalue_referal_real"			=> $jum_referal,
				"crmvalue_kerewelan"			=> $crmvalue_fretfulness,
				"crmvalue_kerewelan_real"		=> $cust_fretfulness,
				"crmvalue_disiplin_batal"		=> $crmvalue_disiplin_batal,
				"crmvalue_disiplin_batal_real"	=> $crmvalue_disiplin_batal_real,
				"crmvalue_disiplin_telat"		=> $crmvalue_disiplin_telat,
				"crmvalue_disiplin_telat_real"	=> $crmvalue_disiplin_telat_real,
				"crmvalue_treatment"				=> $crmvalue_treatment,
				"crmvalue_treatment_medis_real"		=> $tot_tx_utama_medis,
				"crmvalue_treatment_non_medis_real"	=> $tot_tx_utama_non_medis,
				"crmvalue_priority"				=> $crmvalue_priority,
				"crmvalue_total"				=> $crmvalue_total,
				"crmvalue_cust"					=> $crmvalue_cust,	
				"crmvalue_date"					=> $crmvalue_date,
				"crmvalue_author"				=> $_SESSION[SESSION_USERID]
			);
			$this->db->insert('crm_value',$data);
			
			
			
			
			if($this->db->affected_rows()){
				$sql_cust_priority = 
				   "UPDATE customer c
					SET c.cust_crm_value = 
					   (select max(crm.crmvalue_id)
						from crm_value crm
						WHERE crm.crmvalue_cust = '$crmvalue_cust')
					WHERE cust_id = '$crmvalue_cust'
					";
				$query_cust_priority	= $this->db->query($sql_cust_priority);				
				return '1';
			}
			else
				return '0';
				
				
			//UPDATE PRIORITY KE CUSTOMER
			$sql_cust_priority = 
			   "UPDATE customer c
				SET c.cust_crm_value = 
				   (select max(crm.crmvalue_id)
					from crm_value crm
					WHERE crm.crmvalue_cust = '$crmvalue_cust')
				WHERE cust_id = '$crmvalue_cust'
				";
			$query_cust_priority	= $this->db->query($sql_cust_priority);
			
		}
*/		
		
}
?>