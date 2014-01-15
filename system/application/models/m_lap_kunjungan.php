<? /* 
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_kunjungan.php
 	+ Author  		: Freddy
*/

class M_lap_kunjungan extends Model{
		
	//constructor
	function M_lap_kunjungan() {
		parent::Model();
	}
	
	function get_laporan_tunggu($tgl_awal,$tgl_akhir,$periode,$group){
			
		switch($group){
			case "Tanggal": $order_by=" ORDER BY dtrawat_tglapp ASC";break;
			case "Customer": $order_by=" ORDER BY trawat_cust,dtrawat_tglapp ASC";break;
			case "Perawatan": $order_by=" ORDER BY dtrawat_perawatan,dtrawat_tglapp ASC";break;
			case "Dokter": $order_by=" ORDER BY dokter_id,dtrawat_tglapp ASC";break;
			case "Status": $order_by=" ORDER BY dtrawat_status,dtrawat_tglapp ASC";break;
			default: $order_by=" ORDER BY dtrawat_tglapp ASC";break;
		}
			
		if($periode=='all')
			$sql="SELECT *,date_format(dtrawat_tglapp,'%Y-%m-%d') as dtrawat_tglapp FROM vu_tindakan 
					WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama ='Anti Aging') OR (kategori_nama='Non Medis' AND terapis_id is NULL AND dokter_id is NULL) ".$order_by;
		else if($periode=='bulan')
			$sql="SELECT *,date_format(dtrawat_tglapp,'%Y-%m-%d') as dtrawat_tglapp FROM vu_tindakan 
					WHERE ((kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama ='Anti Aging') OR (kategori_nama='Non Medis' AND terapis_id is NULL AND dokter_id is NULL))
					AND date_format(dtrawat_tglapp,'%Y-%m')='".$tgl_awal."' ".$order_by;
		else if($periode=='tanggal')
			$sql="SELECT *,date_format(dtrawat_tglapp,'%Y-%m-%d') as dtrawat_tglapp FROM vu_tindakan 
					WHERE  ((kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama ='Anti Aging') OR (kategori_nama='Non Medis' AND terapis_id is NULL AND dokter_id is NULL)) 
					AND date_format(dtrawat_tglapp,'%Y-%m-%d')>='".$tgl_awal."' 
					AND date_format(dtrawat_tglapp,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
		
		$query=$this->db->query($sql);
		return $query->result();
	}
	
	//fcuntion for delete record
		function detail_kunjungan_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the phonegroups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM phonegrouped WHERE phonegrouped_cust = ".$pkid[0];
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok ='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal = '$date_now'
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal = '$date_now'
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal = '$date_now'
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  = '$date_now'

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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '$date_now'
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
			
			
		function get_daftar_customer($tgl_awal,$periode,$lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust,$tgl_tindakan,$start,$end){
		
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
		
	//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
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

				if($periode == 'bulan' || $periode == 'tanggal'){
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
					cust_id, cust_no, cust_nama					
					from
					(
						(
							/* MEDIS */
							select 
								cust_id, 
								cust_no,
								cust_nama,
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
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_medis
							group by cust_nama
						)
						
						/* SURGERY */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_surgery
							group by cust_nama

						)

						/* ANTI AGING */
						union
						(
							select 
							cust_id,
							cust_no,
							cust_nama,
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
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,									
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
									where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_antiaging 
							group by cust_nama

						)

						
						/*  NON-MEDIS */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_nonmedis
							group by cust_nama
						)

						/* PRODUK*/
						union
						(
							select 
								vu_customer.cust_id,
								vu_customer.cust_no,
								vu_customer.cust_nama,
								0 as jum_cust_medis,
								0 as jum_cust_surgery,
								0 as jum_cust_antiaging,
								0 as jum_cust_nonmedis,
								count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
								0 as jum_total,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
							group by cust_nama
						)

						/* TOTAL*/
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										master_jual_produk.jproduk_cust as cust,
										master_jual_produk.jproduk_tanggal as tgl_tindakan
									from master_jual_produk
									left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
									where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
								)
								
								union
								(
								select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
								where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)
								
								)as table_union2
							group by cust_nama
						)

					) as table_union group by cust_nama";

					}
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$limit = $query." LIMIT ".$start.",".$end;			
			//$result = $this->db->query($limit);  
			
			$i = 0;
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
					$i+=$i;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}	
			
			
			
			
	//function for advanced search record
	/*	PENTING!!! jika mengubah query ini, perhatikan juga:
		1. m_public_function->get_laporan_kunjungan_dashboard
		2. pr_kunjungan
	*/
	function lap_kunjungan_search($tgl_awal,$periode,$lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
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
		
		//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
		
		//untuk pencarian tanggal lahir	
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}

		//untuk pencarian umur
		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}
		
	//untuk periode
		if ($periode == 'bulan'){
			$periode_produk =" (date_format(master_jual_produk.jproduk_tanggal,'%Y-%m')='".$tgl_awal."') " ;
			$periode_paket =" (date_format(detail_ambil_paket.dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') " ;				
			$periode_rawat = " (date_format(master_jual_rawat.jrawat_tanggal,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode_produk = " (master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_paket =" (detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_rawat = " (master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
		}
		
		
		if($periode == 'bulan' || $periode == 'tanggal'){
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
					left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
					left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
			)
			
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

}

			$query.=" group by tgl_tindakan";
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
	function lap_kunjungan_search2($tgl_awal,$periode,$lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
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
		
		//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
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

		//untuk periode
		if ($periode == 'bulan'){
			$periode_produk =" (date_format(master_jual_produk.jproduk_tanggal,'%Y-%m')='".$tgl_awal."') " ;
			$periode_paket =" (date_format(detail_ambil_paket.dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') " ;				
			$periode_rawat = " (date_format(master_jual_rawat.jrawat_tanggal,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode_produk = " (master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_paket =" (detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_rawat = " (master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
		}
		
		//jika ada penggantian di query ini, sesuaikan juga query di m_crm_generator, bagian FREQUENCY, SPENDING, JUMLAH TX UTAMA
		if($periode == 'bulan' || $periode == 'tanggal'){
	
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
			)
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

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

	function lap_kunjungan_search3($tgl_awal,$periode,$lap_kunjungan_id  ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
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
		
		//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
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

		//untuk periode
		if ($periode == 'bulan'){
			$periode_produk =" (date_format(master_jual_produk.jproduk_tanggal,'%Y-%m')='".$tgl_awal."') " ;
			$periode_paket =" (date_format(detail_ambil_paket.dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') " ;				
			$periode_rawat = " (date_format(master_jual_rawat.jrawat_tanggal,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode_produk = " (master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_paket =" (detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_rawat = " (master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
		}
			
		if($periode == 'bulan' || $periode == 'tanggal'){
	
			$query = "select
round(sum(jum_cust_medis)/count(distinct tgl_tindakan),2) as avg_jum_cust_medis,
round(sum(jum_cust_surgery)/count(distinct tgl_tindakan),2) as avg_jum_cust_surgery,
round(sum(jum_cust_antiaging)/count(distinct tgl_tindakan),2) as avg_jum_cust_antiaging,
round(sum(jum_cust_nonmedis)/count(distinct tgl_tindakan),2) as avg_jum_cust_nonmedis,
round(sum(jum_cust_produk)/count(distinct tgl_tindakan),2) as avg_jum_cust_produk,
round(sum(jum_total)/count(distinct tgl_tindakan),2) as avg_jum_total
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."/**/".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
			)
			)as table_union2
		group by tgl_tindakan
	)

) as table_union";

}
	
	/*		else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				
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
		/* MEDIS 
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
					where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
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
				where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."
			)) as table_sum_medis
		group by tgl_tindakan
	)
	
	/* SURGERY 
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
				where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."
			)) as table_sum_surgery
		group by tgl_tindakan

	)

	/* ANTI AGING 
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
				where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."
			)) as table_sum_antiaging
		group by tgl_tindakan

	)

	
	/*  NON-MEDIS 
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
				where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."

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
				where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
			)) as table_sum_nonmedis
		group by tgl_tindakan
	)

	/* PRODUK
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
		where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
		group by tgl_tindakan
	)

	/* TOTAL
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
				and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
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
				where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
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
				where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil = '".$trawat_tglapp_start."'".$cust_kelamin."".$stat_member."".$umur."".$tgllahir."
			)
			
			)as table_union2
		group by tgl_tindakan
	)
) as table_union";
	}*/
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
		
		
		
	//function for print record
	function lap_kunjungan_print($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
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
		
		//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
		
		//untuk pencarian tanggal lahir	
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}

		//untuk pencarian umur
		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}
		
	//untuk periode
		if ($periode == 'bulan'){
			$periode_produk =" (date_format(master_jual_produk.jproduk_tanggal,'%Y-%m')='".$tgl_awal."') " ;
			$periode_paket =" (date_format(detail_ambil_paket.dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') " ;				
			$periode_rawat = " (date_format(master_jual_rawat.jrawat_tanggal,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode_produk = " (master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_paket =" (detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_rawat = " (master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
		}
		
		
		if($periode == 'bulan' || $periode == 'tanggal'){
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_cust_medis) as Medis,
			sum(jum_cust_surgery) as Surgery,
			sum(jum_cust_antiaging) as Anti_Aging,
			sum(jum_cust_nonmedis)as Non_Medis,
			sum(jum_cust_produk) as Produk, 
			sum(jum_total) as Total
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
								where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
							where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
					where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";

		}

		$query.=" group by tgl_tindakan";
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		
		$limit = $query." LIMIT ".$start.",".$end;		
		$result = $this->db->query($limit);    
		return $result;
		}
	
		//function  for print
		function detail_kunjungan_print($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $tgl_tindakan,$option,$filter){
		
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
		
	//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
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

				if($periode == 'bulan' || $periode == 'tanggal'){
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
					cust_id, cust_no, cust_nama					
					from
					(
						(
							/* MEDIS */
							select 
								cust_id, 
								cust_no,
								cust_nama,
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
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_medis
							group by cust_nama
						)
						
						/* SURGERY */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_surgery
							group by cust_nama

						)

						/* ANTI AGING */
						union
						(
							select 
							cust_id,
							cust_no,
							cust_nama,
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
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,									
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
									where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_antiaging 
							group by cust_nama

						)

						
						/*  NON-MEDIS */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_nonmedis
							group by cust_nama
						)

						/* PRODUK*/
						union
						(
							select 
								vu_customer.cust_id,
								vu_customer.cust_no,
								vu_customer.cust_nama,
								0 as jum_cust_medis,
								0 as jum_cust_surgery,
								0 as jum_cust_antiaging,
								0 as jum_cust_nonmedis,
								count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
								0 as jum_total,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
							group by cust_nama
						)

						/* TOTAL*/
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
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
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
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
									and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										master_jual_produk.jproduk_cust as cust,
										master_jual_produk.jproduk_tanggal as tgl_tindakan
									from master_jual_produk
									left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
									where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
								)
								
								union
								(
								select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
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
								where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
								)
								
								)as table_union2
							group by cust_nama
						)

					) as table_union group by cust_nama";

					}
				
			$result = $this->db->query($query);
			return $result->result();
		}
	
	//function  for export to excel
	function lap_kunjungan_export_excel($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end){
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
		
		//untuk pencarian customer
		if ($lap_kunjungan_cust == '' or $lap_kunjungan_cust == 'Semua')
		{
			//$cust_daftar = "";
			$cust_daftar_jproduk 	= "";
			$cust_daftar_jrawat 	= "";
			$cust_daftar_dapaket 	= "";
		}
		else if ($lap_kunjungan_cust == 'Lama')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end') or (vu_customer.cust_terdaftar is null))";
			}

			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal <> vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil <> vu_customer.cust_tglawaltrans ";
		}
		else if($lap_kunjungan_cust == 'Baru')
		{
			if ($periode == 'bulan'){
				//$cust_daftar = " and (date_format(vu_customer.cust_terdaftar,'%Y-%m')='".$tgl_awal."') ";
			}else{
				//$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}
			
			$cust_daftar_jproduk 	= " and master_jual_produk.jproduk_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_jrawat 	= " and master_jual_rawat.jrawat_tanggal = vu_customer.cust_tglawaltrans ";
			$cust_daftar_dapaket 	= " and detail_ambil_paket.dapaket_tgl_ambil = vu_customer.cust_tglawaltrans ";
		}			
		
		//untuk pencarian berdasarkan member
		if ($lap_kunjungan_member == '' or $lap_kunjungan_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_member == 'Lama')
		{
			if ($periode == 'bulan'){
				$stat_member = " and (date_format(vu_customer.member_register,'%Y-%m')<>'".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
			}
		}
		else if($lap_kunjungan_member == 'Baru')
		{
			if ($periode == 'bulan'){
				$stat_member 		= " and (date_format(vu_customer.member_register,'%Y-%m')='".$tgl_awal."') ";
			}else{
				$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end' ";
			}	
		}
		else if($lap_kunjungan_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
		
		//untuk pencarian tanggal lahir	
		if($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir!='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_kunjungan_tgllahir' AND now()";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_kunjungan_tgllahirend'";
		}else if ($lap_kunjungan_tgllahir=='' and $lap_kunjungan_tgllahirend==''){
			$tgllahir= "";
		}

		//untuk pencarian umur
		if($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_kunjungan_umurstart' AND '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart!='' and $lap_kunjungan_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_kunjungan_umurstart'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_kunjungan_umurend'";
		}else if ($lap_kunjungan_umurstart=='' and $lap_kunjungan_umurend==''){
			$umur= "";
		}
		
	//untuk periode
		if ($periode == 'bulan'){
			$periode_produk =" (date_format(master_jual_produk.jproduk_tanggal,'%Y-%m')='".$tgl_awal."') " ;
			$periode_paket =" (date_format(detail_ambil_paket.dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') " ;				
			$periode_rawat = " (date_format(master_jual_rawat.jrawat_tanggal,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode_produk = " (master_jual_produk.jproduk_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_paket =" (detail_ambil_paket.dapaket_tgl_ambil between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
			$periode_rawat = " (master_jual_rawat.jrawat_tanggal between '".$trawat_tglapp_start."' and '".$trawat_tglapp_end."') ";
		}
		
		
		if($periode == 'bulan' || $periode == 'tanggal'){
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
			sum(jum_cust_medis) as Medis,
			sum(jum_cust_surgery) as Surgery,
			sum(jum_cust_antiaging) as Anti_Aging,
			sum(jum_cust_nonmedis)as Non_Medis,
			sum(jum_cust_produk) as Produk, 
			sum(jum_total) as Total
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
								where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
							where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
							left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
							where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."

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
							where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
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
					where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
							and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0 or master_jual_rawat.jrawat_cashback_medis <> 0 or detail_jual_rawat.drawat_diskon_jenis = 'Ultah') and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and ".$periode_rawat."".$cust_kelamin."".$cust_daftar_jrawat."".$stat_member."".$umur."".$tgllahir."
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
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and ".$periode_produk."".$cust_kelamin."".$cust_daftar_jproduk."".$stat_member."".$umur."".$tgllahir."
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
							where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and ".$periode_paket."".$cust_kelamin."".$cust_daftar_dapaket."".$stat_member."".$umur."".$tgllahir."
						)
						
						)as table_union2
					group by tgl_tindakan
				)

			) as table_union";

		}

		$query.=" group by tgl_tindakan";
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		
		$limit = $query." LIMIT ".$start.",".$end;		
		$result = $this->db->query($limit);    
		return $result;
	}
		
}
?>