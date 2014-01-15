<? /* 
	+ Description	: For record model process back-end
	+ Filename 		: m_summary_report.php
 	+ Author  		: Freddy
*/

class m_summary_report extends Model{
		
	//constructor
	function m_summary_report() {
		parent::Model();
	}
		
	//function for get list record
	function lap_kunjungan_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			
			$query="select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok ='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)	
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now' 
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now'
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)	
		)as table_union2
		group by tgl_tindakan
	)

) as table_union
group by tgl_tindakan";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0){
				if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
	function lap_kunjungan_non_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			$query="select
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now'
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now'
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)
			
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0 || $nbrows2>0){
				if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}	
		
	function lap_average_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			$query="
select
sum(jum_cust_medis)/count(distinct tgl_tindakan),
sum(jum_cust_surgery)/count(distinct tgl_tindakan),
sum(jum_cust_antiaging)/count(distinct tgl_tindakan),
sum(jum_cust_nonmedis)/count(distinct tgl_tindakan),
sum(jum_cust_produk)/count(distinct tgl_tindakan),
sum(jum_total)/count(distinct tgl_tindakan)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  = '$date_now'

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now'
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join customer on (master_jual_rawat.jrawat_cust = customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join customer on (master_jual_produk.jproduk_cust = customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '$date_now'
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join customer on (detail_ambil_paket.dapaket_cust = customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '$date_now'
			)
			
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0 || $nbrows2>0){
				if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}		
	
	//function for input Summary Report
	function summary_report_input
	($bulan_tujuan, $tahun_tujuan, $bulan_pembanding1, $tahun_pembanding1, $bulan_pembanding2, $tahun_pembanding2, $start,$end){
	
	//full query		
		if($bulan_tujuan!='' && $tahun_tujuan!=''){
		// TUJUAN
		$jum_hari_tujuan = cal_days_in_month(CAL_GREGORIAN, $bulan_tujuan, $tahun_tujuan);
		$tanggal_daftar_awal = $tahun_tujuan.'-'.$bulan_tujuan.'-01';
		$tanggal_daftar_akhir = $tahun_tujuan.'-'.$bulan_tujuan.'-'.$jum_hari_tujuan;
		
		// PEMBANDING 1
		$jum_hari_pembanding1 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding1, $tahun_pembanding1);
		$tanggal_awal_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-01';
		$tanggal_akhir_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-'.$jum_hari_pembanding1;
		
		// PEMBANDING 2
		$jum_hari_pembanding2 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding2, $tahun_pembanding2);
		$tanggal_awal_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-01';
		$tanggal_akhir_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-'.$jum_hari_pembanding2;
		$sr_cabang = 1;
		$username = $_SESSION[SESSION_USERID];
	
	// DELETE DATA SR LAMA
	
	
	
	// END OF DELETE DATA SR LAMA
	
	// POSISI INSERT KE SR
		
		// *********************************************************
		// * 					BULAN TUJUAN					   *
		// *********************************************************
		// ==================== KUNJUNGAN TUJUAN =================
			// SEMUA TUJUAN
			$query_kunjungan_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_tujuan= $this->db->query($query_kunjungan_tujuan);
			$row_kunjungan_tujuan= $result_kunjungan_tujuan->row();
			$kunjungan_tujuan= $row_kunjungan_tujuan->kunjungan_tujuan;
			
			$data_kunjungan_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$kunjungan_tujuan,
				"sr_jenis"=>'Kunjungan',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_tujuan); 
			
		// PRIA TUJUAN
		$query_kunjungan_pria_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_pria_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'L'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'L'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'L'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_pria_tujuan= $this->db->query($query_kunjungan_pria_tujuan);
			$row_kunjungan_pria_tujuan= $result_kunjungan_pria_tujuan->row();
			$kunjungan_pria_tujuan= $row_kunjungan_pria_tujuan->kunjungan_pria_tujuan;
			
			$data_kunjungan_pria_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$kunjungan_pria_tujuan,
				"sr_jenis"=>'Kunjungan Pria',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_pria_tujuan);
			
		// WANITA TUJUAN
		$query_kunjungan_wanita_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_wanita_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'P'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'P'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_kelamin = 'P'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_wanita_tujuan= $this->db->query($query_kunjungan_wanita_tujuan);
			$row_kunjungan_wanita_tujuan= $result_kunjungan_wanita_tujuan->row();
			$kunjungan_wanita_tujuan= $row_kunjungan_wanita_tujuan->kunjungan_wanita_tujuan;
			
			$data_kunjungan_wanita_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$kunjungan_wanita_tujuan,
				"sr_jenis"=>'Kunjungan Wanita',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_wanita_tujuan);
			
		// ==================== CUSTOMER BARU TUJUAN =================
		$query_customer_baru_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_baru_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."' and vu_customer.cust_terdaftar between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_terdaftar between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_terdaftar between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_baru_tujuan= $this->db->query($query_customer_baru_tujuan);
			$row_customer_baru_tujuan= $result_customer_baru_tujuan->row();
			$customer_baru_tujuan= $row_customer_baru_tujuan->customer_baru_tujuan;
			
			$data_customer_baru_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$customer_baru_tujuan,
				"sr_jenis"=>'Customer Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_baru_tujuan);
		// ==================== END OF CUSTOMER BARU TUJUAN =================	
		// ==================== CUSTOMER LAMA TUJUAN =================
		$query_customer_lama_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_lama_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."' and vu_customer.cust_terdaftar not between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_terdaftar not between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.cust_terdaftar not between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_lama_tujuan= $this->db->query($query_customer_lama_tujuan);
			$row_customer_lama_tujuan= $result_customer_lama_tujuan->row();
			$customer_lama_tujuan= $row_customer_lama_tujuan->customer_lama_tujuan;
			
			$data_customer_lama_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$customer_lama_tujuan,
				"sr_jenis"=>'Customer Lama',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_lama_tujuan);
		// ==================== END OF CUSTOMER LAMA TUJUAN =================
		
		// ==================== MEMBER BARU TUJUAN =================
		$query_member_baru_tujuan= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as member_baru_tujuan
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."' and vu_customer.member_register between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.member_register between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' and vu_customer.member_register between '".$tanggal_daftar_awal."' and '". $tanggal_daftar_akhir."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_member_baru_tujuan= $this->db->query($query_member_baru_tujuan);
			$row_member_baru_tujuan= $result_member_baru_tujuan->row();
			$member_baru_tujuan= $row_member_baru_tujuan->member_baru_tujuan;
			
			$data_member_baru_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$member_baru_tujuan,
				"sr_jenis"=>'Member Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_member_baru_tujuan);
		// ==================== END OF MEMBER BARU TUJUAN =================
		
		// ==================== MEDIS TUJUAN ==============================
		// JUMLAH MEDIS TUJUAN
		// SATUAN
		$query_jumlah_satuan_medis_tujuan= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_medis_tujuan
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 2";
			$result_jumlah_satuan_medis_tujuan= $this->db->query($query_jumlah_satuan_medis_tujuan);
			$row_jumlah_satuan_medis_tujuan= $result_jumlah_satuan_medis_tujuan->row();
			$jumlah_satuan_medis_tujuan= $row_jumlah_satuan_medis_tujuan->satuan_medis_tujuan;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_medis_tujuan= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_medis_tujuan
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 2";
			$result_jumlah_paket_medis_tujuan= $this->db->query($query_jumlah_paket_medis_tujuan);
			$row_jumlah_paket_medis_tujuan= $result_jumlah_paket_medis_tujuan->row();
			$jumlah_paket_medis_tujuan= $row_jumlah_paket_medis_tujuan->paket_medis_tujuan;	
			
			$total_jumlah_medis_tujuan = $jumlah_satuan_medis_tujuan + $jumlah_paket_medis_tujuan;
			
			$data_jumlah_medis_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$total_jumlah_medis_tujuan,
				"sr_jenis"=>'Perawatan Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_medis_tujuan);
		
		// NET SALES MEDIS TUJUAN
		$query_sales_medis_tujuan= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d')between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
				kategori_nama = 'Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
				kategori_nama = 'Medis')
			AS sales_medis_tujuan";
			$result_sales_medis_tujuan= $this->db->query($query_sales_medis_tujuan);
			$row_sales_medis_tujuan= $result_sales_medis_tujuan->row();
			$sales_medis_tujuan= $row_sales_medis_tujuan->sales_medis_tujuan;
			
			$data_sales_medis_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$sales_medis_tujuan,
				"sr_jenis"=>'Perawatan Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_medis_tujuan);
		// ==================== END OF MEDIS TUJUAN ==============================
		
		// ==================== NON MEDIS TUJUAN ==============================
		// JUMLAH NON MEDIS TUJUAN
		// SATUAN
		$query_jumlah_satuan_non_medis_tujuan= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_non_medis_tujuan
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 3";
			$result_jumlah_satuan_non_medis_tujuan= $this->db->query($query_jumlah_satuan_non_medis_tujuan);
			$row_jumlah_satuan_non_medis_tujuan= $result_jumlah_satuan_non_medis_tujuan->row();
			$jumlah_satuan_non_medis_tujuan= $row_jumlah_satuan_non_medis_tujuan->satuan_non_medis_tujuan;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_non_medis_tujuan= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_non_medis_tujuan
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 3";
			$result_jumlah_paket_non_medis_tujuan= $this->db->query($query_jumlah_paket_non_medis_tujuan);
			$row_jumlah_paket_non_medis_tujuan= $result_jumlah_paket_non_medis_tujuan->row();
			$jumlah_paket_non_medis_tujuan= $row_jumlah_paket_non_medis_tujuan->paket_non_medis_tujuan;	
			
			$total_jumlah_non_medis = $jumlah_satuan_non_medis_tujuan + $jumlah_paket_non_medis_tujuan;
			
			$data_jumlah_non_medis_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$total_jumlah_non_medis,
				"sr_jenis"=>'Perawatan Non Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_non_medis_tujuan);
		
		// NET SALES NON MEDIS TUJUAN
		$query_sales_non_medis_tujuan= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
				kategori_nama = 'Non Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
				kategori_nama = 'Non Medis')
			AS sales_non_medis_tujuan";
			$result_sales_non_medis_tujuan= $this->db->query($query_sales_non_medis_tujuan);
			$row_sales_non_medis_tujuan= $result_sales_non_medis_tujuan->row();
			$sales_non_medis_tujuan= $row_sales_non_medis_tujuan->sales_non_medis_tujuan;
			
			$data_sales_non_medis_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$sales_non_medis_tujuan,
				"sr_jenis"=>'Perawatan Non Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_non_medis_tujuan);
		// ==================== END OF MEDIS TUJUAN ==============================
		
		// ==================== PRODUK TUJUAN ==============================
		// JUMLAH PRODUK TUJUAN
		// SATUAN
		$query_jumlah_produk_tujuan= "
			SELECT 
			SUM(detail_jual_produk.dproduk_jumlah)-
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS jumlah_produk_tujuan,

			(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
			SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS sales_produk_tujuan
			
			FROM detail_jual_produk
			LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
			LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id WHERE master_jual_produk.jproduk_tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
			$result_jumlah_produk_tujuan= $this->db->query($query_jumlah_produk_tujuan);
			$row_jumlah_produk_tujuan= $result_jumlah_produk_tujuan->row();
			$jumlah_produk_tujuan= $row_jumlah_produk_tujuan->jumlah_produk_tujuan;
			$sales_produk_tujuan= $row_jumlah_produk_tujuan->sales_produk_tujuan;
			
			$data_jumlah_produk_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$jumlah_produk_tujuan,
				"sr_jenis"=>'Produk (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_produk_tujuan);
			
			$data_sales_produk_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$sales_produk_tujuan,
				"sr_jenis"=>'Produk (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_produk_tujuan);
		// ==================== END OF PRODUK TUJUAN ==============================
		
		// ==================== NET SALES TUJUAN ==============================
		// SURGERY
			$sql_sales_surgery_tujuan = "
			SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama = 'Surgery') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama = 'Surgery')
			AS sales_surgery_tujuan";
			$query_sql_sales_surgery_tujuan= $this->db->query($sql_sales_surgery_tujuan);
			$data_sql_sales_surgery_tujuan= $query_sql_sales_surgery_tujuan->row();
			$sales_surgery_tujuan= $data_sql_sales_surgery_tujuan->sales_surgery_tujuan;
		
		// ANTI AGING
			$sql_sales_antiaging_tujuan = "
					SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama = 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama = 'Anti Aging')
			AS sales_antiaging_tujuan";
			$query_sql_sales_antiaging_tujuan= $this->db->query($sql_sales_antiaging_tujuan);
			$data_sql_sales_antiaging_tujuan= $query_sql_sales_antiaging_tujuan->row();
			$sales_antiaging_tujuan= $data_sql_sales_antiaging_tujuan->sales_antiaging_tujuan;
		
		// LAIN-LAIN
			$sql_sales_lain2_tujuan = "
				SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_daftar_awal."' and '".$tanggal_daftar_akhir."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging')
			AS sales_lain2_tujuan";
			$query_sql_sales_lain2_tujuan= $this->db->query($sql_sales_lain2_tujuan);
			$data_sql_sales_lain2_tujuan= $query_sql_sales_lain2_tujuan->row();
			$sales_lain2_tujuan= $data_sql_sales_lain2_tujuan->sales_lain2_tujuan;
			
			$sales_total_tujuan = 
								$sales_medis_tujuan +
								$sales_non_medis_tujuan +
								$sales_produk_tujuan +
								$sales_surgery_tujuan +
								$sales_antiaging_tujuan +
								$sales_lain2_tujuan;
		
			$data_net_sales_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$sales_total_tujuan,
				"sr_jenis"=>'NS Bulan (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_net_sales_tujuan);
		// ==================== END OF NET SALES TUJUAN ==============================
		
		// ==================== SPENDING TUJUAN ==========================
			$spending_tujuan = $sales_total_tujuan / $kunjungan_tujuan;
			$data_spending_tujuan = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_tujuan,	
				"sr_tahun"=>$tahun_tujuan,	
				"sr_nilai"=>$spending_tujuan,
				"sr_jenis"=>'Spending (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_spending_tujuan);
		
		// ==================== END OF SPENDING TUJUAN ===================
		
		// *********************************************************
		// * 					END OF BULAN TUJUAN				   *
		// *********************************************************
		
		// *********************************************************
		// * 					BULAN PEMBANDING 1				   *
		// *********************************************************
		// ==================== KUNJUNGAN PEMBANDING 1 =================
			// SEMUA PEMBANDING 1
			$query_kunjungan_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_pembanding1= $this->db->query($query_kunjungan_pembanding1);
			$row_kunjungan_pembanding1= $result_kunjungan_pembanding1->row();
			$kunjungan_pembanding1= $row_kunjungan_pembanding1->kunjungan_pembanding1;
			
			$data_kunjungan_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$kunjungan_pembanding1,
				"sr_jenis"=>'Kunjungan',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_pembanding1); 
			
		// PRIA PEMBANDING 1
		$query_kunjungan_pria_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_pria_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'L'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'L'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'L'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_pria_pembanding1= $this->db->query($query_kunjungan_pria_pembanding1);
			$row_kunjungan_pria_pembanding1= $result_kunjungan_pria_pembanding1->row();
			$kunjungan_pria_pembanding1= $row_kunjungan_pria_pembanding1->kunjungan_pria_pembanding1;
			
			$data_kunjungan_pria_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$kunjungan_pria_pembanding1,
				"sr_jenis"=>'Kunjungan Pria',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_pria_pembanding1);
			
		// WANITA PEMBANDING 1
		$query_kunjungan_wanita_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_wanita_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'P'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'P'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_kelamin = 'P'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_wanita_pembanding1= $this->db->query($query_kunjungan_wanita_pembanding1);
			$row_kunjungan_wanita_pembanding1= $result_kunjungan_wanita_pembanding1->row();
			$kunjungan_wanita_pembanding1= $row_kunjungan_wanita_pembanding1->kunjungan_wanita_pembanding1;
			
			$data_kunjungan_wanita_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$kunjungan_wanita_pembanding1,
				"sr_jenis"=>'Kunjungan Wanita',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_wanita_pembanding1);
			
		// ==================== CUSTOMER BARU PEMBANDING 1 =================
		$query_customer_baru_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_baru_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_baru_pembanding1= $this->db->query($query_customer_baru_pembanding1);
			$row_customer_baru_pembanding1= $result_customer_baru_pembanding1->row();
			$customer_baru_pembanding1= $row_customer_baru_pembanding1->customer_baru_pembanding1;
			
			$data_customer_baru_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$customer_baru_pembanding1,
				"sr_jenis"=>'Customer Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_baru_pembanding1);
		// ==================== END OF CUSTOMER BARU PEMBANDING 1 =================	
		// ==================== CUSTOMER LAMA PEMBANDING 1 =================
		$query_customer_lama_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_lama_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_lama_pembanding1= $this->db->query($query_customer_lama_pembanding1);
			$row_customer_lama_pembanding1= $result_customer_lama_pembanding1->row();
			$customer_lama_pembanding1= $row_customer_lama_pembanding1->customer_lama_pembanding1;
			
			$data_customer_lama_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$customer_lama_pembanding1,
				"sr_jenis"=>'Customer Lama',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_lama_pembanding1);
		// ==================== END OF CUSTOMER LAMA PEMBANDING 1 =================
		
		// ==================== MEMBER BARU PEMBANDING 1 =================
		$query_member_baru_pembanding1= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as member_baru_pembanding1
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."' and vu_customer.member_register between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.member_register between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' and vu_customer.member_register between '".$tanggal_awal_pembanding1."' and '". $tanggal_akhir_pembanding1."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_member_baru_pembanding1= $this->db->query($query_member_baru_pembanding1);
			$row_member_baru_pembanding1= $result_member_baru_pembanding1->row();
			$member_baru_pembanding1= $row_member_baru_pembanding1->member_baru_pembanding1;
			
			$data_member_baru_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$member_baru_pembanding1,
				"sr_jenis"=>'Member Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_member_baru_pembanding1);
		// ==================== END OF MEMBER BARU PEMBANDING 1 =================
		
		// ==================== MEDIS PEMBANDING 1 ==============================
		// JUMLAH MEDIS PEMBANDING 1
		// SATUAN
		$query_jumlah_satuan_medis_pembanding1= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_medis_pembanding1
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 2";
			$result_jumlah_satuan_medis_pembanding1= $this->db->query($query_jumlah_satuan_medis_pembanding1);
			$row_jumlah_satuan_medis_pembanding1= $result_jumlah_satuan_medis_pembanding1->row();
			$jumlah_satuan_medis_pembanding1= $row_jumlah_satuan_medis_pembanding1->satuan_medis_pembanding1;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_medis_pembanding1= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_medis_pembanding1
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 2";
			$result_jumlah_paket_medis_pembanding1= $this->db->query($query_jumlah_paket_medis_pembanding1);
			$row_jumlah_paket_medis_pembanding1= $result_jumlah_paket_medis_pembanding1->row();
			$jumlah_paket_medis_pembanding1= $row_jumlah_paket_medis_pembanding1->paket_medis_pembanding1;	
			
			$total_jumlah_medis_pembanding1 = $jumlah_satuan_medis_pembanding1 + $jumlah_paket_medis_pembanding1;
			
			$data_jumlah_medis_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$total_jumlah_medis_pembanding1,
				"sr_jenis"=>'Perawatan Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_medis_pembanding1);
		
		// NET SALES MEDIS PEMBANDING 1
		$query_sales_medis_pembanding1= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d')between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
				kategori_nama = 'Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
				kategori_nama = 'Medis')
			AS sales_medis_pembanding1";
			$result_sales_medis_pembanding1= $this->db->query($query_sales_medis_pembanding1);
			$row_sales_medis_pembanding1= $result_sales_medis_pembanding1->row();
			$sales_medis_pembanding1= $row_sales_medis_pembanding1->sales_medis_pembanding1;
			
			$data_sales_medis_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$sales_medis_pembanding1,
				"sr_jenis"=>'Perawatan Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_medis_pembanding1);
		// ==================== END OF MEDIS PEMBANDING 1 ==============================
		
		// ==================== NON MEDIS PEMBANDING 1 ==============================
		// JUMLAH NON MEDIS PEMBANDING 1
		// SATUAN
		$query_jumlah_satuan_non_medis_pembanding1= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_non_medis_pembanding1
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 3";
			$result_jumlah_satuan_non_medis_pembanding1= $this->db->query($query_jumlah_satuan_non_medis_pembanding1);
			$row_jumlah_satuan_non_medis_pembanding1= $result_jumlah_satuan_non_medis_pembanding1->row();
			$jumlah_satuan_non_medis_pembanding1= $row_jumlah_satuan_non_medis_pembanding1->satuan_non_medis_pembanding1;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_non_medis_pembanding1= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_non_medis_pembanding1
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 3";
			$result_jumlah_paket_non_medis_pembanding1= $this->db->query($query_jumlah_paket_non_medis_pembanding1);
			$row_jumlah_paket_non_medis_pembanding1= $result_jumlah_paket_non_medis_pembanding1->row();
			$jumlah_paket_non_medis_pembanding1= $row_jumlah_paket_non_medis_pembanding1->paket_non_medis_pembanding1;	
			
			$total_jumlah_non_medis = $jumlah_satuan_non_medis_pembanding1 + $jumlah_paket_non_medis_pembanding1;
			
			$data_jumlah_non_medis_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$total_jumlah_non_medis,
				"sr_jenis"=>'Perawatan Non Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_non_medis_pembanding1);
		
		// NET SALES NON MEDIS PEMBANDING 1
		$query_sales_non_medis_pembanding1= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
				kategori_nama = 'Non Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
				kategori_nama = 'Non Medis')
			AS sales_non_medis_pembanding1";
			$result_sales_non_medis_pembanding1= $this->db->query($query_sales_non_medis_pembanding1);
			$row_sales_non_medis_pembanding1= $result_sales_non_medis_pembanding1->row();
			$sales_non_medis_pembanding1= $row_sales_non_medis_pembanding1->sales_non_medis_pembanding1;
			
			$data_sales_non_medis_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$sales_non_medis_pembanding1,
				"sr_jenis"=>'Perawatan Non Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_non_medis_pembanding1);
		// ==================== END OF MEDIS PEMBANDING 1 ==============================
		
		// ==================== PRODUK PEMBANDING 1 ==============================
		// JUMLAH PRODUK PEMBANDING 1
		// SATUAN
		$query_jumlah_produk_pembanding1= "
			SELECT 
			SUM(detail_jual_produk.dproduk_jumlah)-
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS jumlah_produk_pembanding1,

			(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
			SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS sales_produk_pembanding1
			
			FROM detail_jual_produk
			LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
			LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id WHERE master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
			$result_jumlah_produk_pembanding1= $this->db->query($query_jumlah_produk_pembanding1);
			$row_jumlah_produk_pembanding1= $result_jumlah_produk_pembanding1->row();
			$jumlah_produk_pembanding1= $row_jumlah_produk_pembanding1->jumlah_produk_pembanding1;
			$sales_produk_pembanding1= $row_jumlah_produk_pembanding1->sales_produk_pembanding1;
			
			$data_jumlah_produk_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$jumlah_produk_pembanding1,
				"sr_jenis"=>'Produk (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_produk_pembanding1);
			
			$data_sales_produk_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$sales_produk_pembanding1,
				"sr_jenis"=>'Produk (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_produk_pembanding1);
		// ==================== END OF PRODUK PEMBANDING 1 ==============================
		
		// ==================== NET SALES PEMBANDING 1 ==============================
		// SURGERY
			$sql_sales_surgery_pembanding1 = "
			SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama = 'Surgery') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama = 'Surgery')
			AS sales_surgery_pembanding1";
			$query_sql_sales_surgery_pembanding1= $this->db->query($sql_sales_surgery_pembanding1);
			$data_sql_sales_surgery_pembanding1= $query_sql_sales_surgery_pembanding1->row();
			$sales_surgery_pembanding1= $data_sql_sales_surgery_pembanding1->sales_surgery_pembanding1;
		
		// ANTI AGING
			$sql_sales_antiaging_pembanding1 = "
					SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama = 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama = 'Anti Aging')
			AS sales_antiaging_pembanding1";
			$query_sql_sales_antiaging_pembanding1= $this->db->query($sql_sales_antiaging_pembanding1);
			$data_sql_sales_antiaging_pembanding1= $query_sql_sales_antiaging_pembanding1->row();
			$sales_antiaging_pembanding1= $data_sql_sales_antiaging_pembanding1->sales_antiaging_pembanding1;
		
		// LAIN-LAIN
			$sql_sales_lain2_pembanding1 = "
				SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding1."' and '".$tanggal_akhir_pembanding1."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging')
			AS sales_lain2_pembanding1";
			$query_sql_sales_lain2_pembanding1= $this->db->query($sql_sales_lain2_pembanding1);
			$data_sql_sales_lain2_pembanding1= $query_sql_sales_lain2_pembanding1->row();
			$sales_lain2_pembanding1= $data_sql_sales_lain2_pembanding1->sales_lain2_pembanding1;
			
			$sales_total_pembanding1 = 
								$sales_medis_pembanding1 +
								$sales_non_medis_pembanding1 +
								$sales_produk_pembanding1 +
								$sales_surgery_pembanding1 +
								$sales_antiaging_pembanding1 +
								$sales_lain2_pembanding1;
		
			$data_net_sales_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$sales_total_pembanding1,
				"sr_jenis"=>'NS Bulan (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_net_sales_pembanding1);
		// ==================== END OF NET SALES PEMBANDING 1 ==============================

		// ==================== SPENDING PEMBANDING 1 ==========================
			$spending_pembanding1 = $sales_total_pembanding1 / $kunjungan_pembanding1;
			$data_spending_pembanding1 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding1,	
				"sr_tahun"=>$tahun_pembanding1,	
				"sr_nilai"=>$spending_pembanding1,
				"sr_jenis"=>'Spending (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_spending_pembanding1);
		
		// ==================== END OF SPENDING PEMBANDING 1 ===================
			
		// *********************************************************
		// * 					END OF BULAN PEMBANDING 1		   *
		// *********************************************************
		
		
		// *********************************************************
		// * 					BULAN PEMBANDING 2				   *
		// *********************************************************
		// ==================== KUNJUNGAN PEMBANDING 2 =================
			// SEMUA PEMBANDING 2
			$query_kunjungan_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_pembanding2= $this->db->query($query_kunjungan_pembanding2);
			$row_kunjungan_pembanding2= $result_kunjungan_pembanding2->row();
			$kunjungan_pembanding2= $row_kunjungan_pembanding2->kunjungan_pembanding2;
			
			$data_kunjungan_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$kunjungan_pembanding2,
				"sr_jenis"=>'Kunjungan',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_pembanding2); 
			
		// PRIA PEMBANDING 2
		$query_kunjungan_pria_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_pria_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'L'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'L'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'L'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_pria_pembanding2= $this->db->query($query_kunjungan_pria_pembanding2);
			$row_kunjungan_pria_pembanding2= $result_kunjungan_pria_pembanding2->row();
			$kunjungan_pria_pembanding2= $row_kunjungan_pria_pembanding2->kunjungan_pria_pembanding2;
			
			$data_kunjungan_pria_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$kunjungan_pria_pembanding2,
				"sr_jenis"=>'Kunjungan Pria',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_pria_pembanding2);
			
		// WANITA PEMBANDING 2
		$query_kunjungan_wanita_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as kunjungan_wanita_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'P'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'P'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_kelamin = 'P'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_kunjungan_wanita_pembanding2= $this->db->query($query_kunjungan_wanita_pembanding2);
			$row_kunjungan_wanita_pembanding2= $result_kunjungan_wanita_pembanding2->row();
			$kunjungan_wanita_pembanding2= $row_kunjungan_wanita_pembanding2->kunjungan_wanita_pembanding2;
			
			$data_kunjungan_wanita_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$kunjungan_wanita_pembanding2,
				"sr_jenis"=>'Kunjungan Wanita',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_kunjungan_wanita_pembanding2);
			
		// ==================== CUSTOMER BARU PEMBANDING 2 =================
		$query_customer_baru_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_baru_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_baru_pembanding2= $this->db->query($query_customer_baru_pembanding2);
			$row_customer_baru_pembanding2= $result_customer_baru_pembanding2->row();
			$customer_baru_pembanding2= $row_customer_baru_pembanding2->customer_baru_pembanding2;
			
			$data_customer_baru_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$customer_baru_pembanding2,
				"sr_jenis"=>'Customer Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_baru_pembanding2);
		// ==================== END OF CUSTOMER BARU PEMBANDING 2 =================	
		// ==================== CUSTOMER LAMA PEMBANDING 2 =================
		$query_customer_lama_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as customer_lama_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.cust_terdaftar not between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_customer_lama_pembanding2= $this->db->query($query_customer_lama_pembanding2);
			$row_customer_lama_pembanding2= $result_customer_lama_pembanding2->row();
			$customer_lama_pembanding2= $row_customer_lama_pembanding2->customer_lama_pembanding2;
			
			$data_customer_lama_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$customer_lama_pembanding2,
				"sr_jenis"=>'Customer Lama',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_customer_lama_pembanding2);
		// ==================== END OF CUSTOMER LAMA PEMBANDING 2 =================
		
		// ==================== MEMBER BARU PEMBANDING 2 =================
		$query_member_baru_pembanding2= "
			select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_total) as member_baru_pembanding2
			from
			(
				/* TOTAL*/
				(
					select 
						count(distinct cust) as jum_total,
						tgl_tindakan
						from
						((	
							select 
								master_jual_rawat.jrawat_cust as cust,
								master_jual_rawat.jrawat_tanggal as tgl_tindakan
							from detail_jual_rawat
							left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
							left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where master_jual_rawat.jrawat_stat_dok ='Tertutup'
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."' and vu_customer.member_register between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						union
						(
							select 
								master_jual_produk.jproduk_cust as cust,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.member_register between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						union
						(
						select 
								detail_ambil_paket.dapaket_cust as cust,
								detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
							from detail_ambil_paket
							left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
							left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' and vu_customer.member_register between '".$tanggal_awal_pembanding2."' and '". $tanggal_akhir_pembanding2."'
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";
			$result_member_baru_pembanding2= $this->db->query($query_member_baru_pembanding2);
			$row_member_baru_pembanding2= $result_member_baru_pembanding2->row();
			$member_baru_pembanding2= $row_member_baru_pembanding2->member_baru_pembanding2;
			
			$data_member_baru_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$member_baru_pembanding2,
				"sr_jenis"=>'Member Baru',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_member_baru_pembanding2);
		// ==================== END OF MEMBER BARU PEMBANDING 2 =================
		
		// ==================== MEDIS PEMBANDING 2 ==============================
		// JUMLAH MEDIS PEMBANDING 2
		// SATUAN
		$query_jumlah_satuan_medis_pembanding2= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_medis_pembanding2
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 2";
			$result_jumlah_satuan_medis_pembanding2= $this->db->query($query_jumlah_satuan_medis_pembanding2);
			$row_jumlah_satuan_medis_pembanding2= $result_jumlah_satuan_medis_pembanding2->row();
			$jumlah_satuan_medis_pembanding2= $row_jumlah_satuan_medis_pembanding2->satuan_medis_pembanding2;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_medis_pembanding2= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_medis_pembanding2
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 2";
			$result_jumlah_paket_medis_pembanding2= $this->db->query($query_jumlah_paket_medis_pembanding2);
			$row_jumlah_paket_medis_pembanding2= $result_jumlah_paket_medis_pembanding2->row();
			$jumlah_paket_medis_pembanding2= $row_jumlah_paket_medis_pembanding2->paket_medis_pembanding2;	
			
			$total_jumlah_medis_pembanding2 = $jumlah_satuan_medis_pembanding2 + $jumlah_paket_medis_pembanding2;
			
			$data_jumlah_medis_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$total_jumlah_medis_pembanding2,
				"sr_jenis"=>'Perawatan Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_medis_pembanding2);
		
		// NET SALES MEDIS PEMBANDING 2
		$query_sales_medis_pembanding2= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d')between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
				kategori_nama = 'Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
				kategori_nama = 'Medis')
			AS sales_medis_pembanding2";
			$result_sales_medis_pembanding2= $this->db->query($query_sales_medis_pembanding2);
			$row_sales_medis_pembanding2= $result_sales_medis_pembanding2->row();
			$sales_medis_pembanding2= $row_sales_medis_pembanding2->sales_medis_pembanding2;
			
			$data_sales_medis_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$sales_medis_pembanding2,
				"sr_jenis"=>'Perawatan Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_medis_pembanding2);
		// ==================== END OF MEDIS PEMBANDING 2 ==============================
		
		// ==================== NON MEDIS PEMBANDING 2 ==============================
		// JUMLAH NON MEDIS PEMBANDING 2
		// SATUAN
		$query_jumlah_satuan_non_medis_pembanding2= "
			SELECT 	SUM(detail_jual_rawat.drawat_jumlah) AS satuan_non_medis_pembanding2
					FROM detail_jual_rawat
					LEFT JOIN master_jual_rawat ON detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id
					LEFT JOIN perawatan ON detail_jual_rawat.drawat_rawat = perawatan.rawat_id
					LEFT JOIN kategori ON perawatan.rawat_kategori = kategori.kategori_id WHERE  master_jual_rawat.jrawat_tanggal 
					between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND  kategori.kategori_id = 3";
			$result_jumlah_satuan_non_medis_pembanding2= $this->db->query($query_jumlah_satuan_non_medis_pembanding2);
			$row_jumlah_satuan_non_medis_pembanding2= $result_jumlah_satuan_non_medis_pembanding2->row();
			$jumlah_satuan_non_medis_pembanding2= $row_jumlah_satuan_non_medis_pembanding2->satuan_non_medis_pembanding2;
		
		// PENGAMBILAN PAKET
		$query_jumlah_paket_non_medis_pembanding2= "
			select SUM(`detail_ambil_paket`.`dapaket_jumlah`) AS paket_non_medis_pembanding2
					  from (((((`detail_ambil_paket` 
					join `master_jual_paket` on((`master_jual_paket`.`jpaket_id` = `detail_ambil_paket`.`dapaket_jpaket`))) 
					left join `vu_jumlah_isi_paket` on((`detail_ambil_paket`.`dapaket_paket` = `vu_jumlah_isi_paket`.`paket_id`))) 
					left join `perawatan` on((`detail_ambil_paket`.`dapaket_item` = `perawatan`.`rawat_id`))) 
					left join `detail_jual_paket` on((`detail_ambil_paket`.`dapaket_dpaket` = `detail_jual_paket`.`dpaket_id`)))
					LEFT JOIN kategori ON ((perawatan.rawat_kategori = kategori.kategori_id))) WHERE date_format(detail_ambil_paket.dapaket_date_create, '%Y-%m-%d') between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND master_jual_paket.jpaket_stat_dok = 'Tertutup' AND kategori.kategori_id = 3";
			$result_jumlah_paket_non_medis_pembanding2= $this->db->query($query_jumlah_paket_non_medis_pembanding2);
			$row_jumlah_paket_non_medis_pembanding2= $result_jumlah_paket_non_medis_pembanding2->row();
			$jumlah_paket_non_medis_pembanding2= $row_jumlah_paket_non_medis_pembanding2->paket_non_medis_pembanding2;	
			
			$total_jumlah_non_medis = $jumlah_satuan_non_medis_pembanding2 + $jumlah_paket_non_medis_pembanding2;
			
			$data_jumlah_non_medis_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$total_jumlah_non_medis,
				"sr_jenis"=>'Perawatan Non Medis (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_non_medis_pembanding2);
		
		// NET SALES NON MEDIS PEMBANDING 2
		$query_sales_non_medis_pembanding2= "
			SELECT
			(SELECT  
				ifnull(sum(subtotal), 0)
			FROM vu_detail_jual_rawat 
			WHERE 
				jrawat_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
				kategori_nama = 'Non Medis')
			+			
			(SELECT  
				ifnull(sum(harga_satuan), 0)
			FROM vu_detail_ambil_paket_rawat 
			WHERE 
				jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
				date_format(tanggal, '%Y-%m-%d') between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
				kategori_nama = 'Non Medis')
			AS sales_non_medis_pembanding2";
			$result_sales_non_medis_pembanding2= $this->db->query($query_sales_non_medis_pembanding2);
			$row_sales_non_medis_pembanding2= $result_sales_non_medis_pembanding2->row();
			$sales_non_medis_pembanding2= $row_sales_non_medis_pembanding2->sales_non_medis_pembanding2;
			
			$data_sales_non_medis_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$sales_non_medis_pembanding2,
				"sr_jenis"=>'Perawatan Non Medis (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_non_medis_pembanding2);
		// ==================== END OF MEDIS PEMBANDING 2 ==============================
		
		// ==================== PRODUK PEMBANDING 2 ==============================
		// JUMLAH PRODUK PEMBANDING 2
		// SATUAN
		$query_jumlah_produk_pembanding2= "
			SELECT 
			SUM(detail_jual_produk.dproduk_jumlah)-
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah)  
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS jumlah_produk_pembanding2,

			(SUM((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100)) - 
			SUM((master_jual_produk.jproduk_diskon *((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)-((detail_jual_produk.dproduk_jumlah * detail_jual_produk.dproduk_harga)*detail_jual_produk.dproduk_diskon/100))) /100)) -
			IFNULL ((SELECT SUM(detail_retur_jual_produk.drproduk_jumlah*detail_retur_jual_produk.drproduk_harga) 
			FROM detail_retur_jual_produk
			LEFT JOIN master_retur_jual_produk ON detail_retur_jual_produk.drproduk_master = master_retur_jual_produk.rproduk_id
			WHERE detail_retur_jual_produk.drproduk_produk = produk_id AND master_retur_jual_produk.rproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND master_retur_jual_produk.rproduk_stat_dok = 'Tertutup' GROUP BY detail_retur_jual_produk.drproduk_produk ),0) AS sales_produk_pembanding2
			
			FROM detail_jual_produk
			LEFT JOIN master_jual_produk ON detail_jual_produk.dproduk_master = master_jual_produk.jproduk_id
			LEFT JOIN produk ON detail_jual_produk.dproduk_produk = produk.produk_id WHERE master_jual_produk.jproduk_tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND master_jual_produk.jproduk_stat_dok = 'Tertutup'";
			$result_jumlah_produk_pembanding2= $this->db->query($query_jumlah_produk_pembanding2);
			$row_jumlah_produk_pembanding2= $result_jumlah_produk_pembanding2->row();
			$jumlah_produk_pembanding2= $row_jumlah_produk_pembanding2->jumlah_produk_pembanding2;
			$sales_produk_pembanding2= $row_jumlah_produk_pembanding2->sales_produk_pembanding2;
			
			$data_jumlah_produk_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$jumlah_produk_pembanding2,
				"sr_jenis"=>'Produk (Qty)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_jumlah_produk_pembanding2);
			
			$data_sales_produk_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$sales_produk_pembanding2,
				"sr_jenis"=>'Produk (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_sales_produk_pembanding2);
		// ==================== END OF PRODUK PEMBANDING 2 ==============================
		
		// ==================== NET SALES PEMBANDING 2 ==============================
		// SURGERY
			$sql_sales_surgery_pembanding2 = "
			SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama = 'Surgery') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama = 'Surgery')
			AS sales_surgery_pembanding2";
			$query_sql_sales_surgery_pembanding2= $this->db->query($sql_sales_surgery_pembanding2);
			$data_sql_sales_surgery_pembanding2= $query_sql_sales_surgery_pembanding2->row();
			$sales_surgery_pembanding2= $data_sql_sales_surgery_pembanding2->sales_surgery_pembanding2;
		
		// ANTI AGING
			$sql_sales_antiaging_pembanding2 = "
					SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama = 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama = 'Anti Aging')
			AS sales_antiaging_pembanding2";
			$query_sql_sales_antiaging_pembanding2= $this->db->query($sql_sales_antiaging_pembanding2);
			$data_sql_sales_antiaging_pembanding2= $query_sql_sales_antiaging_pembanding2->row();
			$sales_antiaging_pembanding2= $data_sql_sales_antiaging_pembanding2->sales_antiaging_pembanding2;
		
		// LAIN-LAIN
			$sql_sales_lain2_pembanding2 = "
				SELECT	
				(SELECT  
					ifnull(sum(subtotal), 0)
				FROM vu_detail_jual_rawat 
				WHERE 
					jrawat_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging') 
				+
				(SELECT  
					ifnull(sum(harga_satuan), 0)
				FROM vu_detail_ambil_paket_rawat 
				WHERE 
					jpaket_stat_dok='Tertutup' AND dapaket_stat_dok='Tertutup' AND 
					tanggal between '".$tanggal_awal_pembanding2."' and '".$tanggal_akhir_pembanding2."' AND
					kategori_nama <> 'Medis' AND kategori_nama <> 'Non Medis' AND kategori_nama <> 'Surgery' AND kategori_nama <> 'Anti Aging')
			AS sales_lain2_pembanding2";
			$query_sql_sales_lain2_pembanding2= $this->db->query($sql_sales_lain2_pembanding2);
			$data_sql_sales_lain2_pembanding2= $query_sql_sales_lain2_pembanding2->row();
			$sales_lain2_pembanding2= $data_sql_sales_lain2_pembanding2->sales_lain2_pembanding2;
			
			$sales_total_pembanding2 = 
								$sales_medis_pembanding2 +
								$sales_non_medis_pembanding2 +
								$sales_produk_pembanding2 +
								$sales_surgery_pembanding2 +
								$sales_antiaging_pembanding2 +
								$sales_lain2_pembanding2;
		
			$data_net_sales_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$sales_total_pembanding2,
				"sr_jenis"=>'NS Bulan (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_net_sales_pembanding2);
		// ==================== END OF NET SALES PEMBANDING 2 ==============================
		
		// ==================== SPENDING PEMBANDING 1 ==========================
			$spending_pembanding2 = $sales_total_pembanding2 / $kunjungan_pembanding2;
			$data_spending_pembanding2 = array(
				"sr_cabang"=>$sr_cabang,	
				"sr_bulan"=>$bulan_pembanding2,	
				"sr_tahun"=>$tahun_pembanding2,	
				"sr_nilai"=>$spending_pembanding2,
				"sr_jenis"=>'Spending (Rp)',	
				"sr_author"=>$username,	
				"sr_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('sr', $data_spending_pembanding2);
		
		// ==================== END OF SPENDING PEMBANDING 2 ===================
		
		
		// *********************************************************
		// * 					END OF BULAN PEMBANDING 2		   *
		// *********************************************************
		
		}
	}

	
	//function for generate Summary Report
	function summary_report_generate
	($bulan_tujuan, $tahun_tujuan, $bulan_pembanding1, $tahun_pembanding1, $bulan_pembanding2, $tahun_pembanding2, $start,$end){
	//full query
		/*
		if ($lap_kunjungan_kelamin == '' or $lap_kunjungan_kelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_kelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";
		}
		else if($lap_kunjungan_kelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";			
		}
		
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}			
		
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
			
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}

		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}
		*/

		
		if($bulan_tujuan!='' && $tahun_tujuan!=''){
		// TUJUAN
		$jum_hari_tujuan = cal_days_in_month(CAL_GREGORIAN, $bulan_tujuan, $tahun_tujuan);
		$tanggal_daftar_awal = $tahun_tujuan.'-'.$bulan_tujuan.'-01';
		$tanggal_daftar_akhir = $tahun_tujuan.'-'.$bulan_tujuan.'-'.$jum_hari_tujuan;
		
		// PEMBANDING 1
		$jum_hari_pembanding1 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding1, $tahun_pembanding1);
		$tanggal_awal_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-01';
		$tanggal_akhir_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-'.$jum_hari_pembanding1;
		
		// PEMBANDING 2
		$jum_hari_pembanding2 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding2, $tahun_pembanding2);
		$tanggal_awal_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-01';
		$tanggal_akhir_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-'.$jum_hari_pembanding2;
		$sr_cabang = 1;
		$username = $_SESSION[SESSION_USERID];
		
		// POSISI INSERT KE SR
		
		
		// ===== PERBANDINGAN BULAN TUJUAN DENGAN TARGET =====
		if ($bulan_tujuan == 01)
			$bulan = 'setsr_jan';
		else if ($bulan_tujuan == 02)
			$bulan = 'setsr_feb';
		else if ($bulan_tujuan == 03)
			$bulan = 'setsr_mar';
		else if ($bulan_tujuan == 04)
			$bulan = 'setsr_apr';
		else if ($bulan_tujuan == 05)
			$bulan = 'setsr_may';
		else if ($bulan_tujuan == 06)
			$bulan = 'setsr_jun';
		else if ($bulan_tujuan == 07)
			$bulan = 'setsr_jul';
		else if ($bulan_tujuan == 08)
			$bulan = 'setsr_aug';
		else if ($bulan_tujuan == 09)
			$bulan = 'setsr_sep';
		else if ($bulan_tujuan == 10)
			$bulan = 'setsr_oct';
		else if ($bulan_tujuan == 11)
			$bulan = 'setsr_nov';
		else if ($bulan_tujuan == 12)
			$bulan = 'setsr_dec';
			
		if ($bulan_pembanding1 == 01)
			$bulan_pembanding1_text = 'setsr_jan';
		else if ($bulan_pembanding1 == 02)
			$bulan_pembanding1_text = 'setsr_feb';
		else if ($bulan_pembanding1 == 03)
			$bulan_pembanding1_text = 'setsr_mar';
		else if ($bulan_pembanding1 == 04)
			$bulan_pembanding1_text = 'setsr_apr';
		else if ($bulan_pembanding1 == 05)
			$bulan_pembanding1_text = 'setsr_may';
		else if ($bulan_pembanding1 == 06)
			$bulan_pembanding1_text = 'setsr_jun';
		else if ($bulan_pembanding1 == 07)
			$bulan_pembanding1_text = 'setsr_jul';
		else if ($bulan_pembanding1 == 08)
			$bulan_pembanding1_text = 'setsr_aug';
		else if ($bulan_pembanding1 == 09)
			$bulan_pembanding1_text = 'setsr_sep';
		else if ($bulan_pembanding1 == 10)
			$bulan_pembanding1_text = 'setsr_oct';
		else if ($bulan_pembanding1 == 11)
			$bulan_pembanding1_text = 'setsr_nov';
		else if ($bulan_pembanding1 == 12)
			$bulan_pembanding1_text = 'setsr_dec';
			
		if ($bulan_pembanding2 == 01)
			$bulan_pembanding2_text = 'setsr_jan';
		else if ($bulan_pembanding2 == 02)
			$bulan_pembanding2_text = 'setsr_feb';
		else if ($bulan_pembanding2 == 03)
			$bulan_pembanding2_text = 'setsr_mar';
		else if ($bulan_pembanding2 == 04)
			$bulan_pembanding2_text = 'setsr_apr';
		else if ($bulan_pembanding2 == 05)
			$bulan_pembanding2_text = 'setsr_may';
		else if ($bulan_pembanding2 == 06)
			$bulan_pembanding2_text = 'setsr_jun';
		else if ($bulan_pembanding2 == 07)
			$bulan_pembanding2_text = 'setsr_jul';
		else if ($bulan_pembanding2 == 08)
			$bulan_pembanding2_text = 'setsr_aug';
		else if ($bulan_pembanding2 == 09)
			$bulan_pembanding2_text = 'setsr_sep';
		else if ($bulan_pembanding2 == 10)
			$bulan_pembanding2_text = 'setsr_oct';
		else if ($bulan_pembanding2 == 11)
			$bulan_pembanding2_text = 'setsr_nov';
		else if ($bulan_pembanding2 == 12)
			$bulan_pembanding2_text = 'setsr_dec';
		
		$query_perhitungan_summary = "
		SELECT
			sr.sr_jenis AS jenis,
			sr.sr_nilai AS nilai_tujuan,
			sr_setup.".$bulan." AS target,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' )),2) AS rata_rata,
			ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2) AS pencapaian_target,
			
			/* pembanding 1 */
			ROUND((
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) AS rata2_pembanding1,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) AS naik_turun_rata2_1,
			
			(ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) / 
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			))*100 AS naik_turun_rata2_persen_1,
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			) AS nilai_pembanding1,
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding1_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			) AS pencapaian_pembanding1,
			( ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2)-
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding1_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			)) AS naik_turun_pencapaian_pembanding1,	
			(
				sr.sr_nilai-(SELECT sr.sr_nilai 
								FROM sr 
								WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
										sr.sr_tahun = '".$tahun_pembanding1."' AND 
										sr.sr_jenis = jenis)
			) AS naik_turun1,
			ROUND((	
				(sr.sr_nilai-(SELECT sr.sr_nilai 
								FROM sr 
								WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
										sr.sr_tahun = '".$tahun_pembanding1."' AND 
										sr.sr_jenis = jenis)) / sr.sr_nilai 
			),2) AS prosentase_naik_turun1,
			
			/* pembanding 2 */
			ROUND((
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) AS rata2_pembanding2,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) AS naik_turun_rata2_2,
			(ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) /
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis
			))*100 AS naik_turun_rata2_persen_2,
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis
			) AS nilai_pembanding2,
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding2_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			) AS pencapaian_pembanding2,
			( ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2)-
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding2_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			)) AS naik_turun_pencapaian_pembanding2,
			(
				sr.sr_nilai-
				(SELECT sr.sr_nilai 
					FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis)
			) AS naik_turun2,
			ROUND((
				(sr.sr_nilai-
				(SELECT sr.sr_nilai 
					FROM sr 
					WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis)) / sr.sr_nilai 
			),2) AS prosentase_naik_turun2
		FROM 
			sr
		LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
		WHERE sr.sr_bulan = '".$bulan_tujuan."' AND sr.sr_tahun = '".$tahun_tujuan."'";
		//$result_perhitungan_summary = $this->db->query($query_perhitungan_summary);
		//$data_perhitungan_summary= $result_perhitungan_summary->row();
		//$target_tujuan= $data_target_tujuan->nilai;
				
		$result = $this->db->query($query_perhitungan_summary);
		$nbrows = $result->num_rows();
			
		$limit = $query_perhitungan_summary." LIMIT ".$start.",".$end;		
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
		
		/*
			$query2 = "elect date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		/*
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and MONTH(master_jual_rawat.jrawat_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_rawat.jrawat_tanggal) = ".$tahun_tujuan."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and MONTH(detail_ambil_paket.dapaket_tgl_ambil) = ".$bulan_tujuan." and YEAR(detail_ambil_paket.dapaket_tgl_ambil) = ".$tahun_tujuan."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	/*
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and MONTH(master_jual_rawat.jrawat_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_rawat.jrawat_tanggal) = ".$tahun_tujuan."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and MONTH(detail_ambil_paket.dapaket_tgl_ambil) = ".$bulan_tujuan." and YEAR(detail_ambil_paket.dapaket_tgl_ambil) = ".$tahun_tujuan."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and MONTH(master_jual_rawat.jrawat_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_rawat.jrawat_tanggal) = ".$tahun_tujuan."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and MONTH(detail_ambil_paket.dapaket_tgl_ambil) = ".$bulan_tujuan." and YEAR(detail_ambil_paket.dapaket_tgl_ambil) = ".$tahun_tujuan."
			)) as table_sum_antiaging 
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and MONTH(master_jual_rawat.jrawat_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_rawat.jrawat_tanggal) = ".$tahun_tujuan."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and MONTH(detail_ambil_paket.dapaket_tgl_ambil) = ".$bulan_tujuan." and YEAR(detail_ambil_paket.dapaket_tgl_ambil) = ".$tahun_tujuan."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	/*
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and MONTH(master_jual_produk.jproduk_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_produk.jproduk_tanggal) = ".$tahun_tujuan."
		group by tgl_tindakan
	)

	/* TOTAL*/
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and MONTH(master_jual_rawat.jrawat_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_rawat.jrawat_tanggal) = ".$tahun_tujuan."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and MONTH(master_jual_produk.jproduk_tanggal) = ".$bulan_tujuan." and YEAR(master_jual_produk.jproduk_tanggal) = ".$tahun_tujuan."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and MONTH(detail_ambil_paket.dapaket_tgl_ambil) = ".$bulan_tujuan." and YEAR(detail_ambil_paket.dapaket_tgl_ambil) = ".$tahun_tujuan."
			)
			
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

}
		else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				
		$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		/*
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	/*
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	/*
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.fproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
		group by tgl_tindakan
	)

	/* TOTAL*/
	/*
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			)as table_union2
		group by tgl_tindakan
	)
) as table_union";
			}
		*/	
		}
	}
		
	//function for advanced search record
	function lap_kunjungan_search2($lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
			//full query

		
		if ($lap_kunjungan_kelamin == '' or $lap_kunjungan_kelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_kelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";
		}
		else if($lap_kunjungan_kelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";			
		}
		
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}			
		
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
		
			
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}


		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}

		
		//jika ada penggantian di query ini, sesuaikan juga query di m_crm_generator, bagian FREQUENCY, SPENDING, JUMLAH TX UTAMA
		if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
	
			$query = "select
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'and vu_customer.cust_kelamin = '".$lap_kunjungan_kelamin."'".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

}
	
			else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
sum(jum_cust_medis),
sum(jum_cust_surgery),
sum(jum_cust_antiaging),
sum(jum_cust_nonmedis),
sum(jum_cust_produk), 
sum(jum_total)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			)as table_union2
		group by tgl_tindakan
	)
) as table_union";
	}
			//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			//$query.=" k.karyawan_id != 60 and p.rawat_id is not null"; //60 = Available . Dr
			//$query.=" group by k.karyawan_username, p.rawat_nama)as vu_kredit";
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

	function lap_kunjungan_search3($lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
			//full query
		
		
		if ($lap_kunjungan_kelamin == '' or $lap_kunjungan_kelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_kelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";
		}
		else if($lap_kunjungan_kelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";			
		}
		
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}	
	
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
		
		
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}
	
		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}

			
		if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
	
			$query = "select
sum(jum_cust_medis)/count(distinct tgl_tindakan),
sum(jum_cust_surgery)/count(distinct tgl_tindakan),
sum(jum_cust_antiaging)/count(distinct tgl_tindakan),
sum(jum_cust_nonmedis)/count(distinct tgl_tindakan),
sum(jum_cust_produk)/count(distinct tgl_tindakan), 
sum(jum_total)/count(distinct tgl_tindakan)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

}
	
			else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
sum(jum_cust_medis)/count(distinct tgl_tindakan),
sum(jum_cust_surgery)/count(distinct tgl_tindakan),
sum(jum_cust_antiaging)/count(distinct tgl_tindakan),
sum(jum_cust_nonmedis)/count(distinct tgl_tindakan),
sum(jum_cust_produk)/count(distinct tgl_tindakan), 
sum(jum_total)/count(distinct tgl_tindakan)
from
(
	(
		/* MEDIS */
		select 
			count(distinct temp_jum_cust_medis) as jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
					from detail_jual_rawat
					left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY */
	union
	(
		select 
			jum_cust_medis,
			count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS */
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
			jum_cust_produk,
			jum_total,
			tgl_tindakan
			from
			((
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
					0 as jum_cust_produk,
					0 as jum_total,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK*/
	union
	(
		select 
			0 as jum_cust_medis,
			0 as jum_cust_surgery,
			0 as jum_cust_antiaging,
			0 as jum_cust_nonmedis,
			count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
			0 as jum_total,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
		group by tgl_tindakan
	)

	/* TOTAL*/
	union
	(
		select 
			jum_cust_medis,
			jum_cust_surgery,
			jum_cust_antiaging,
			jum_cust_nonmedis,
			jum_cust_produk,
			count(distinct cust) as jum_total,
			tgl_tindakan
			from
			((	
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_rawat.jrawat_cust as cust,
					master_jual_rawat.jrawat_tanggal as tgl_tindakan
				from detail_jual_rawat
				left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
				where master_jual_rawat.jrawat_stat_dok ='Tertutup'
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			union
			(
				select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					master_jual_produk.jproduk_cust as cust,
					master_jual_produk.jproduk_tanggal as tgl_tindakan
				from master_jual_produk
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			union
			(
			select 
					0 as jum_cust_medis,
					0 as jum_cust_surgery,
					0 as jum_cust_antiaging,
					0 as jum_cust_nonmedis,
					0 as jum_cust_produk,
					detail_ambil_paket.dapaket_cust as cust,
					detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
				from detail_ambil_paket
				left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
				left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
			)
			
			)as table_union2
		group by tgl_tindakan
	)
) as table_union";
	}
			//$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			//$query.=" k.karyawan_id != 60 and p.rawat_id is not null"; //60 = Available . Dr
			//$query.=" group by k.karyawan_username, p.rawat_nama)as vu_kredit";
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
		
		
	//function for print Summary Report
	function summary_report_print
	($bulan_tujuan, $tahun_tujuan, $bulan_pembanding1, $tahun_pembanding1, $bulan_pembanding2, $tahun_pembanding2){
	//full query
		/*
		if ($lap_kunjungan_kelamin == '' or $lap_kunjungan_kelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_kelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";
		}
		else if($lap_kunjungan_kelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_kelamin'";			
		}
		
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}			
		
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
			
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}

		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}
		*/

		
		if($bulan_tujuan!='' && $tahun_tujuan!=''){
		// TUJUAN
		$jum_hari_tujuan = cal_days_in_month(CAL_GREGORIAN, $bulan_tujuan, $tahun_tujuan);
		$tanggal_daftar_awal = $tahun_tujuan.'-'.$bulan_tujuan.'-01';
		$tanggal_daftar_akhir = $tahun_tujuan.'-'.$bulan_tujuan.'-'.$jum_hari_tujuan;
		
		// PEMBANDING 1
		$jum_hari_pembanding1 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding1, $tahun_pembanding1);
		$tanggal_awal_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-01';
		$tanggal_akhir_pembanding1 = $tahun_pembanding1.'-'.$bulan_pembanding1.'-'.$jum_hari_pembanding1;
		
		// PEMBANDING 2
		$jum_hari_pembanding2 = cal_days_in_month(CAL_GREGORIAN, $bulan_pembanding2, $tahun_pembanding2);
		$tanggal_awal_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-01';
		$tanggal_akhir_pembanding2 = $tahun_pembanding2.'-'.$bulan_pembanding2.'-'.$jum_hari_pembanding2;
		$sr_cabang = 1;
		$username = $_SESSION[SESSION_USERID];
		
		// POSISI INSERT KE SR
		
		
		// ===== PERBANDINGAN BULAN TUJUAN DENGAN TARGET =====
		if ($bulan_tujuan == 01)
			$bulan = 'setsr_jan';
		else if ($bulan_tujuan == 02)
			$bulan = 'setsr_feb';
		else if ($bulan_tujuan == 03)
			$bulan = 'setsr_mar';
		else if ($bulan_tujuan == 04)
			$bulan = 'setsr_apr';
		else if ($bulan_tujuan == 05)
			$bulan = 'setsr_may';
		else if ($bulan_tujuan == 06)
			$bulan = 'setsr_jun';
		else if ($bulan_tujuan == 07)
			$bulan = 'setsr_jul';
		else if ($bulan_tujuan == 08)
			$bulan = 'setsr_aug';
		else if ($bulan_tujuan == 09)
			$bulan = 'setsr_sep';
		else if ($bulan_tujuan == 10)
			$bulan = 'setsr_oct';
		else if ($bulan_tujuan == 11)
			$bulan = 'setsr_nov';
		else if ($bulan_tujuan == 12)
			$bulan = 'setsr_dec';
			
		if ($bulan_pembanding1 == 01)
			$bulan_pembanding1_text = 'setsr_jan';
		else if ($bulan_pembanding1 == 02)
			$bulan_pembanding1_text = 'setsr_feb';
		else if ($bulan_pembanding1 == 03)
			$bulan_pembanding1_text = 'setsr_mar';
		else if ($bulan_pembanding1 == 04)
			$bulan_pembanding1_text = 'setsr_apr';
		else if ($bulan_pembanding1 == 05)
			$bulan_pembanding1_text = 'setsr_may';
		else if ($bulan_pembanding1 == 06)
			$bulan_pembanding1_text = 'setsr_jun';
		else if ($bulan_pembanding1 == 07)
			$bulan_pembanding1_text = 'setsr_jul';
		else if ($bulan_pembanding1 == 08)
			$bulan_pembanding1_text = 'setsr_aug';
		else if ($bulan_pembanding1 == 09)
			$bulan_pembanding1_text = 'setsr_sep';
		else if ($bulan_pembanding1 == 10)
			$bulan_pembanding1_text = 'setsr_oct';
		else if ($bulan_pembanding1 == 11)
			$bulan_pembanding1_text = 'setsr_nov';
		else if ($bulan_pembanding1 == 12)
			$bulan_pembanding1_text = 'setsr_dec';
			
		if ($bulan_pembanding2 == 01)
			$bulan_pembanding2_text = 'setsr_jan';
		else if ($bulan_pembanding2 == 02)
			$bulan_pembanding2_text = 'setsr_feb';
		else if ($bulan_pembanding2 == 03)
			$bulan_pembanding2_text = 'setsr_mar';
		else if ($bulan_pembanding2 == 04)
			$bulan_pembanding2_text = 'setsr_apr';
		else if ($bulan_pembanding2 == 05)
			$bulan_pembanding2_text = 'setsr_may';
		else if ($bulan_pembanding2 == 06)
			$bulan_pembanding2_text = 'setsr_jun';
		else if ($bulan_pembanding2 == 07)
			$bulan_pembanding2_text = 'setsr_jul';
		else if ($bulan_pembanding2 == 08)
			$bulan_pembanding2_text = 'setsr_aug';
		else if ($bulan_pembanding2 == 09)
			$bulan_pembanding2_text = 'setsr_sep';
		else if ($bulan_pembanding2 == 10)
			$bulan_pembanding2_text = 'setsr_oct';
		else if ($bulan_pembanding2 == 11)
			$bulan_pembanding2_text = 'setsr_nov';
		else if ($bulan_pembanding2 == 12)
			$bulan_pembanding2_text = 'setsr_dec';
		
		$query_perhitungan_summary = "
		SELECT
			sr.sr_jenis AS jenis,
			sr.sr_nilai AS nilai_tujuan,
			sr_setup.".$bulan." AS target,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' )),2) AS rata_rata,
			ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2) AS pencapaian_target,
			
			/* pembanding 1 */
			ROUND((
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) AS rata2_pembanding1,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) AS naik_turun_rata2_1,
			
			(ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding1_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding1."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			),2) / 
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			))*100 AS naik_turun_rata2_persen_1,
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			) AS nilai_pembanding1,
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding1_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			) AS pencapaian_pembanding1,
			( ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2)-
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding1_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
					sr.sr_tahun = '".$tahun_pembanding1."' AND 
					sr.sr_jenis = jenis
			)) AS naik_turun_pencapaian_pembanding1,	
			(
				sr.sr_nilai-(SELECT sr.sr_nilai 
								FROM sr 
								WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
										sr.sr_tahun = '".$tahun_pembanding1."' AND 
										sr.sr_jenis = jenis)
			) AS naik_turun1,
			ROUND((	
				(sr.sr_nilai-(SELECT sr.sr_nilai 
								FROM sr 
								WHERE  sr.sr_bulan = '".$bulan_pembanding1."' AND 
										sr.sr_tahun = '".$tahun_pembanding1."' AND 
										sr.sr_jenis = jenis)) / sr.sr_nilai 
			),2) AS prosentase_naik_turun1,
			
			/* pembanding 2 */
			ROUND((
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) AS rata2_pembanding2,
			ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) AS naik_turun_rata2_2,
			(ROUND((sr.sr_nilai / (SELECT ".$bulan." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_tujuan."' ))-
			(
				SELECT sr.sr_nilai/(SELECT ".$bulan_pembanding2_text." FROM sr_setup WHERE sr_setup.setsr_jenis = 'Jum Hari' AND sr_setup.setsr_tahun = '".$tahun_pembanding2."' )
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			),2) /
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis
			))*100 AS naik_turun_rata2_persen_2,
			(
				SELECT sr.sr_nilai 
				FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis
			) AS nilai_pembanding2,
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding2_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			) AS pencapaian_pembanding2,
			( ROUND((sr.sr_nilai / sr_setup.".$bulan." *100),2)-
			(
				SELECT ROUND((sr.sr_nilai / sr_setup.".$bulan_pembanding2_text." *100),2)
				FROM sr 
				LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis
			)) AS naik_turun_pencapaian_pembanding2,
			(
				sr.sr_nilai-
				(SELECT sr.sr_nilai 
					FROM sr 
				WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
					sr.sr_tahun = '".$tahun_pembanding2."' AND 
					sr.sr_jenis = jenis)
			) AS naik_turun2,
			ROUND((
				(sr.sr_nilai-
				(SELECT sr.sr_nilai 
					FROM sr 
					WHERE  sr.sr_bulan = '".$bulan_pembanding2."' AND 
						sr.sr_tahun = '".$tahun_pembanding2."' AND 
						sr.sr_jenis = jenis)) / sr.sr_nilai 
			),2) AS prosentase_naik_turun2
		FROM 
			sr
		LEFT JOIN sr_setup ON (sr.sr_tahun = sr_setup.setsr_tahun AND sr.sr_jenis = sr_setup.setsr_jenis)
		WHERE sr.sr_bulan = '".$bulan_tujuan."' AND sr.sr_tahun = '".$tahun_tujuan."'";
		//$result_perhitungan_summary = $this->db->query($query_perhitungan_summary);
		//$data_perhitungan_summary= $result_perhitungan_summary->row();
		//$target_tujuan= $data_target_tujuan->nilai;
				
		$result = $this->db->query($query_perhitungan_summary);
		return $result;
		}
	}
		
	//function  for export to excel
	/*function lap_lunjungan_export_excel($trawat_id ,$trawat_dokter ,$option,$filter){
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
				$query.=" group by k.karyawan_username, p.rawat_nama";
				$result = $this->db->query($query);	
			}
			return $result;
		}*/
		
}
?>