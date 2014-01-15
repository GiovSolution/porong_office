<? /* 
	GIOV Solution - Keep IT Simple
*/

class M_master_mutasi extends Model{
		
		//constructor
		function M_master_mutasi() {
			parent::Model();
		}
		
		
		function get_laporan_racikan($faktur){
	
				$sql="select mutasi_noref, mutasi_racikan, mutasi_id, status_mutasi, produk_id, produk_kode, produk_nama, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, jumlah_out, jumlah_in
					from
						(
						(
							select master_mutasi.mutasi_racikan as mutasi_racikan,master_mutasi.mutasi_id as mutasi_id ,'mutasi out' as status_mutasi, produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama, satuan.satuan_nama as satuan_nama,
							master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							detail_mutasi_racikan.dmracikan_jumlah as jumlah_out,
							' ' as jumlah_in,
							0 as mutasi_noref
							from detail_mutasi_racikan
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi_racikan.dmracikan_produk = produk.produk_id)
							 join satuan on (detail_mutasi_racikan.dmracikan_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where dmracikan_jenis = 0

						)
						union
						(
									select master_mutasi.mutasi_racikan as mutasi_racikan, master_mutasi.mutasi_id as mutasi_id,  'mutasi in' as status_mutasi, produk.produk_id as produk_id, produk_kode, produk_nama, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																		
									master_mutasi.mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
									' ' as jumlah_out,
									d.dmracikan_jumlah as jumlah_in,
									(select distinct(a.mutasi_no) from detail_mutasi_racikan d
										JOIN master_mutasi a on (a.mutasi_id = d.dmracikan_noref)
										where d.dmracikan_mutasi_id = '".$faktur."'
									) as mutasi_noref
									FROM detail_mutasi_racikan c
									LEFT JOIN detail_mutasi_racikan d on c.dmracikan_noref = d.dmracikan_id
									LEFT JOIN produk on produk.produk_id = d.dmracikan_produk
									LEFT JOIN satuan on satuan.satuan_id = d.dmracikan_satuan
									LEFT JOIN master_mutasi on master_mutasi.mutasi_id = c.dmracikan_mutasi_id
									LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
									LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
									where c.dmracikan_jenis =1
						)
						) as table_union	
						where mutasi_id = '".$faktur."'";
	
			$query=$this->db->query($sql);
			//if($opsi=='faktur')
				return $query;
			//else
			//	return $query->result();
		}
		
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur){
			
			switch($group){
				case "Tanggal": $order_by=" ORDER BY mutasi_tanggal ASC";break;
				case "No Bukti": $order_by=" ORDER BY mutasi_no ASC";break;
				case "Gudang Asal": $order_by=" ORDER BY mutasi_asal ASC";break;
				case "Gudang Tujuan": $order_by=" ORDER BY mutasi_tujuan ASC";break;
				case "Produk": $order_by=" ORDER BY produk_id";break;
				case "Produk Racikan": $order_by=" ORDER BY produk_id";break;
				case "Produk Non Racikan(Retail)": $order_by=" ORDER BY produk_id";break;
				case "Barang Keluar": $order_by=" ORDER BY mutasi_no";break;
				default: $order_by=" ORDER BY mutasi_no ASC";break;
			}
			
			if($opsi=='rekap'){
				if($group=='Produk Racikan')
				{
				if($periode=='all')
					/*$sql="SELECT * FROM  vu_lap_mutasi_racikan WHERE mutasi_status='Tertutup' ".$order_by;*/
					$sql="select a.dmracikan_produk as dmracikan_produk, produk.produk_id, produk.produk_kode as produk_kode , produk.produk_nama 	as produk_nama, produk.produk_volume as produk_volume, 
							satuan.satuan_nama as satuan_nama, 
						(select sum(dmracikan_jumlah)
								from detail_mutasi_racikan as b
								where b.dmracikan_jenis =0	and a.dmracikan_id = b.dmracikan_id
								group by b.dmracikan_produk
						) as mutasi_out_qty,
						ifnull((select sum(
						(
							select sum(c.dmracikan_jumlah) as jumlah
							from detail_mutasi_racikan as c where c.dmracikan_id = d.dmracikan_noref 
						))
								from detail_mutasi_racikan as d
								where d.dmracikan_jenis =1 and d.dmracikan_noref = a.dmracikan_id 
								GROUP BY d.dmracikan_noref
						) ,0)as mutasi_in_qty, master_mutasi.mutasi_status as mutasi_status, master_mutasi.mutasi_tanggal as mutasi_tanggal
							from detail_mutasi_racikan as a
							join master_mutasi on (master_mutasi.mutasi_id = a.dmracikan_mutasi_id)
							join produk on (produk.produk_id = a.dmracikan_produk)
							join satuan on (satuan.satuan_id = a.dmracikan_satuan)
							WHERE mutasi_status='Tertutup'
							group by produk_id
							ORDER BY produk_id";
				else if($periode=='bulan')
					$sql="select status_mutasi, produk_id, produk_kode, produk_nama, produk_volume, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, sum(jumlah_out) as jumlah_out, sum(jumlah_in) as jumlah_in
					from
						(
						(
								select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama, produk_volume, satuan.satuan_nama as satuan_nama,
														master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
													detail_mutasi.dmutasi_jumlah as jumlah_out,
														' ' as jumlah_in
							from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where master_mutasi.mutasi_racikan = 1 and dmracikan_jenis = 0 AND master_mutasi.mutasi_status ='Tertutup' AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."' 

						)
						union
						(
									select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, produk_volume, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
									master_mutasi.mutasi_keterangan,  master_mutasi.mutasi_no as mutasi_no,
									' ' as jumlah_out,
									detail_mutasi.dmutasi_jumlah as jumlah_in
									from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where master_mutasi.mutasi_racikan = 1 and dmracikan_jenis = 1 AND master_mutasi.mutasi_status ='Tertutup' AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."' 
						)
						) as table_union	
							GROUP BY produk_id
						 ORDER BY produk_id";
				else if($periode=='tanggal')
					$sql="select status_mutasi, produk_id, produk_kode, produk_nama, produk_volume, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, sum(jumlah_out) as jumlah_out, sum(jumlah_in) as jumlah_in
					from
						(
						(
								select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama, produk_volume, satuan.satuan_nama as satuan_nama,
														master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
													detail_mutasi.dmutasi_jumlah as jumlah_out,
														' ' as jumlah_in
							from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where master_mutasi.mutasi_racikan = 1 and dmracikan_jenis = 0 AND master_mutasi.mutasi_status ='Tertutup' AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'

						)
						union
						(
									select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, produk_volume, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
									master_mutasi.mutasi_keterangan,  master_mutasi.mutasi_no as mutasi_no,
									' ' as jumlah_out,
									detail_mutasi.dmutasi_jumlah as jumlah_in
									from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where master_mutasi.mutasi_racikan = 1 and dmracikan_jenis = 1 AND master_mutasi.mutasi_status ='Tertutup' AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'
						)
						) as table_union	
							GROUP BY produk_id
						 ORDER BY produk_id";
				}
				
				/*Jika memilih opsi Rekap dan memilih Produk Non Racikan Retail maka masuk ke sini */
				else if($group=='Produk Non Racikan(Retail)')
				{
					if($periode=='all'){
					$sql="select * from detail_mutasi";
					}
					else if($periode=='bulan'){
						$sql="select status_mutasi, produk_id, produk_kode, produk_nama, produk_volume, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, sum(jumlah_out) as jumlah_out, sum(jumlah_in) as jumlah_in
							from
							(
							(
								select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama, produk_volume, satuan.satuan_nama as satuan_nama,
														master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
													detail_mutasi.dmutasi_jumlah as jumlah_out,
														' ' as jumlah_in
							from detail_mutasi
							left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
							left join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							left join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
							left join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							left join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where (master_mutasi.mutasi_racikan = 0 and master_mutasi.mutasi_asal =2 AND master_mutasi.mutasi_status ='Tertutup') AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."'
							)
							union
							(
									select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, produk_volume, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
									master_mutasi.mutasi_keterangan,  master_mutasi.mutasi_no as mutasi_no,
									' ' as jumlah_out,
									detail_mutasi.dmutasi_jumlah as jumlah_in
									from detail_mutasi
									left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
									left join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
									left join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
									left join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
									left join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
									where (master_mutasi.mutasi_racikan = 0 and master_mutasi.mutasi_tujuan= 2 AND master_mutasi.mutasi_status ='Tertutup') AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."'
							)
							) as table_union	
							GROUP BY produk_id
							ORDER BY produk_id";
					}
					else if($periode=='tanggal'){
						$sql="select status_mutasi, produk_id, produk_kode, produk_nama, produk_volume, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, sum(jumlah_out) as jumlah_out, sum(jumlah_in) as jumlah_in
							from
							(
							(
								select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama, produk_volume, satuan.satuan_nama as satuan_nama,
														master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
													detail_mutasi.dmutasi_jumlah as jumlah_out,
														' ' as jumlah_in
							from detail_mutasi
							left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
							left join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							left join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
							left join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							left join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where (master_mutasi.mutasi_racikan = 0 and master_mutasi.mutasi_asal =2 AND master_mutasi.mutasi_status ='Tertutup') AND (date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."')
							)
							union
							(
									select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, produk_volume, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
									master_mutasi.mutasi_keterangan,  master_mutasi.mutasi_no as mutasi_no,
									' ' as jumlah_out,
									detail_mutasi.dmutasi_jumlah as jumlah_in
									from detail_mutasi
									left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
									left join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
									left join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
									left join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
									left join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
									where (master_mutasi.mutasi_racikan = 0 and master_mutasi.mutasi_tujuan= 2 AND master_mutasi.mutasi_status ='Tertutup') AND (date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
									AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."')
							)
							) as table_union	
							GROUP BY produk_id
							ORDER BY produk_id";
						}
				}
				else
				{
				if($periode=='all')
					$sql="SELECT distinct * FROM  vu_trans_mutasi WHERE mutasi_status='Tertutup' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT distinct * FROM vu_trans_mutasi WHERE mutasi_status='Tertutup' 
							AND date_format(mutasi_tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT distinct * FROM vu_trans_mutasi WHERE mutasi_status='Tertutup'
							AND date_format(mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			
			/*Jika Opsi Detail masuk ke option ini */
			}else if($opsi=='detail'){
				if($group=='Produk Racikan'){
					if($periode=='all')
					$sql="select status_mutasi, produk_id, produk_kode, produk_nama, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, jumlah_out, jumlah_in
					from
						(
						(
							select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama,satuan.satuan_nama as satuan_nama,
							master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							detail_mutasi.dmutasi_jumlah as jumlah_out,
							' ' as jumlah_in
							from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where dmracikan_jenis = 0 and master_mutasi.mutasi_status = 'Tertutup'

						)
						union
						(
							select 'mutasi in' as status_mutasi, produk.produk_id as produk_id, produk_kode, produk_nama, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																		
							master_mutasi.mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							' ' as jumlah_out,
							d.dmracikan_jumlah as jumlah_in
							FROM detail_mutasi_racikan c
							LEFT JOIN detail_mutasi_racikan d on c.dmracikan_noref = d.dmracikan_mutasi_id
							LEFT JOIN produk on produk.produk_id = d.dmracikan_produk
							LEFT JOIN satuan on satuan.satuan_id = d.dmracikan_satuan
							LEFT JOIN master_mutasi on master_mutasi.mutasi_id = c.dmracikan_mutasi_id
							LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where c.dmracikan_jenis =1 and master_mutasi.mutasi_status = 'Tertutup'
						)
						) as table_union	
						".$order_by;
						
					else if($periode=='bulan')
					$sql="select status_mutasi, produk_id, produk_kode, produk_nama, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, jumlah_out, jumlah_in
					from
						(
						(
							select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama,satuan.satuan_nama as satuan_nama,
							master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							detail_mutasi.dmutasi_jumlah as jumlah_out,
							' ' as jumlah_in
							from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where dmracikan_jenis = 0 AND master_mutasi.mutasi_status = 'Tertutup' and date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."'  

						)
						union
						(
							select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, satuan.satuan_nama as satuan_nama, master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
							master_mutasi.mutasi_keterangan,  master_mutasi.mutasi_no as mutasi_no,
							' ' as jumlah_out,
							d.dmracikan_jumlah as jumlah_in
							FROM detail_mutasi_racikan c
							LEFT JOIN detail_mutasi_racikan d on c.dmracikan_noref = d.dmracikan_mutasi_id
							LEFT JOIN produk on produk.produk_id = d.dmracikan_produk
							LEFT JOIN satuan on satuan.satuan_id = d.dmracikan_satuan
							LEFT JOIN master_mutasi on master_mutasi.mutasi_id = c.dmracikan_mutasi_id
							LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where c.dmracikan_jenis =1 AND master_mutasi.mutasi_status = 'Tertutup' and  date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."' 
						)
						) as table_union	
						" .$order_by;
			
							
					else if($periode=='tanggal')
					$sql="select status_mutasi,produk_id, produk_kode, produk_nama, satuan_nama, mutasi_no, mutasi_tanggal, gudang_tujuan, gudang_asal, mutasi_keterangan, jumlah_out, jumlah_in
					from
						(
						(
							select 'mutasi out' as status_mutasi,produk.produk_id as produk_id, produk.produk_kode as produk_kode , produk.produk_nama as produk_nama,satuan.satuan_nama as satuan_nama,
							master_mutasi.mutasi_tanggal as mutasi_tanggal, if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal , if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,  master_mutasi.mutasi_keterangan as mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							detail_mutasi.dmutasi_jumlah as jumlah_out,
							' ' as jumlah_in
							from detail_mutasi
							join detail_mutasi_racikan on (detail_mutasi_racikan.dmracikan_mutasi_id = detail_mutasi.dmutasi_master)
							join master_mutasi on (detail_mutasi_racikan.dmracikan_mutasi_id = master_mutasi.mutasi_id)
							join produk on (detail_mutasi.dmutasi_produk = produk.produk_id)
							 join satuan on (detail_mutasi.dmutasi_satuan = satuan.satuan_id)
						  join gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							join gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where dmracikan_jenis = 0 AND master_mutasi.mutasi_status = 'Tertutup' and date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'

						)
						union
						(
							select 'mutasi in' as status_mutasi,produk.produk_id as produk_id, produk_kode, produk_nama, satuan.satuan_nama as satuan_nama,master_mutasi.mutasi_tanggal,  if((asal.gudang_nama = 'Gudang Temporary'),' ', asal.gudang_nama) as gudang_asal ,  if((tujuan.gudang_nama = 'Gudang Temporary'),' ', tujuan.gudang_nama) as gudang_tujuan,																	
							master_mutasi.mutasi_keterangan, master_mutasi.mutasi_no as mutasi_no,
							' ' as jumlah_out,
							d.dmracikan_jumlah as jumlah_in
							FROM detail_mutasi_racikan c
							LEFT JOIN detail_mutasi_racikan d on c.dmracikan_noref = d.dmracikan_mutasi_id
							LEFT JOIN produk on produk.produk_id = d.dmracikan_produk
							LEFT JOIN satuan on satuan.satuan_id = d.dmracikan_satuan
							LEFT JOIN master_mutasi on master_mutasi.mutasi_id = c.dmracikan_mutasi_id
							LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
							LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
							where c.dmracikan_jenis =1 AND master_mutasi.mutasi_status = 'Tertutup' and   date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'
						)
						) as table_union	
						" .$order_by;
	
				}
				// Utk opsi barang keluar
				else if($group=='Barang Keluar'){
					if($periode=='bulan'){
					$sql="SELECT mutasi_no, mutasi_tanggal, dmutasi_jumlah, mutasi_id, tujuan.gudang_nama as gudang_tujuan_nama, asal.gudang_nama as gudang_asal_nama , produk_nama, satuan_nama
					FROM detail_mutasi  
					left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
					left join kategori_barang_keluar on (master_mutasi.mutasi_kategori_barang_keluar = kategori_barang_keluar.kbk_id) 
					LEFT JOIN produk on (produk.produk_id = detail_mutasi.dmutasi_produk)
					LEFT JOIN satuan on (satuan.satuan_id = produk.produk_satuan)
					LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
					LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
					WHERE mutasi_status='Tertutup' and master_mutasi.mutasi_barang_keluar = 1 and date_format(master_mutasi.mutasi_tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				}
				else if($periode=='tanggal'){
					$sql="SELECT mutasi_no, mutasi_tanggal, dmutasi_jumlah, mutasi_id, tujuan.gudang_nama as gudang_tujuan_nama, asal.gudang_nama as gudang_asal_nama , produk_nama, satuan_nama
					FROM detail_mutasi  
					left join master_mutasi on (detail_mutasi.dmutasi_master = master_mutasi.mutasi_id)
					left join kategori_barang_keluar on (master_mutasi.mutasi_kategori_barang_keluar = kategori_barang_keluar.kbk_id) 
					LEFT JOIN produk on (produk.produk_id = detail_mutasi.dmutasi_produk)
					LEFT JOIN satuan on (satuan.satuan_id = produk.produk_satuan)
					LEFT JOIN gudang tujuan on (_utf8'' = _utf8'' and tujuan.gudang_id = master_mutasi.mutasi_tujuan)
					LEFT JOIN gudang asal on (asal.gudang_id = master_mutasi.mutasi_asal)
					WHERE mutasi_status='Tertutup' and master_mutasi.mutasi_barang_keluar = 1 and date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(master_mutasi.mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}

				}
			
				else{
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_mutasi WHERE mutasi_status='Tertutup' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_mutasi WHERE mutasi_status='Tertutup'
							AND date_format(mutasi_tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_mutasi WHERE mutasi_status='Tertutup' 
							AND date_format(mutasi_tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(mutasi_tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}else if($opsi=='faktur'){
				$sql="SELECT * FROM vu_detail_mutasi WHERE mutasi_id='".$faktur."'";
			}
			
			//$this->firephp->log($sql);
			$query=$this->db->query($sql);
			if($opsi=='faktur')
				return $query;
			else
				return $query->result();
		}
		
	/*Function utk mencari List Gudang */
	function get_gudang_list(){
		/*Jika yang login adalah Suster */
		if($_SESSION[SESSION_GROUPID]==12)
		{
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 4";
		}
		/*Jika yang login adalah Terapis */
		else if($_SESSION[SESSION_GROUPID]==7){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 3";
		}
		/*Jika yang login adalah Gudang Besar */
		else if($_SESSION[SESSION_GROUPID]==23){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 1";
		}
		/*Jika yang login adalah Kasir / Apoteker */
		else if($_SESSION[SESSION_GROUPID]==4 || $_SESSION[SESSION_GROUPID]==26){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and (gudang_id = 2 OR gudang_id = 1)";
		}
		/*Jika yang login adalah administrator*/
		else if($_SESSION[SESSION_GROUPID]==1){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif'";
		}
		else
		$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' AND gudang_nama NOT LIKE 'Gudang Temporary'";
	
		//$sql="SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif'";
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
	
		
	/*Function utk mencari List Gudang Semua (Gudang Tujuan)*/
	function get_gudang_all_list(){
		$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' AND gudang_nama NOT LIKE 'Gudang Temporary'";
	
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
		
		
	/* Ambil stok akhir utk Mutasi Barang dengan gudang tertentu*/
	function get_stok_akhir_mutasi($gudang,$produk_id,$tanggal){
			
			/*
			$sql="SELECT 	satuan_terkecil,satuan_id, produk_id, sum(jml_terima_barang*konversi_nilai)
										+sum(jml_terima_bonus*konversi_nilai)
										-sum(jml_retur_beli*konversi_nilai)
										-sum(jml_mutasi_keluar*konversi_nilai)
										+sum(jml_mutasi_masuk*konversi_nilai)
										+sum(jml_koreksi_stok*konversi_nilai)
										-sum(jml_jual_produk*konversi_nilai)
										-sum(jml_jual_grooming*konversi_nilai)
										+sum(jml_retur_produk*konversi_nilai)
										+sum(jml_retur_paket*konversi_nilai)
										-sum(jml_pakai_cabin*konversi_nilai)
										as jumlah_stok, 
										produk_harga*(sum(jml_terima_barang*konversi_nilai)
										+sum(jml_terima_bonus*konversi_nilai)
										-sum(jml_retur_beli*konversi_nilai)
										-sum(jml_mutasi_keluar*konversi_nilai)
										+sum(jml_mutasi_masuk*konversi_nilai)
										+sum(jml_koreksi_stok*konversi_nilai)
										-sum(jml_jual_produk*konversi_nilai)
										+sum(jml_retur_produk*konversi_nilai)) as harga
								FROM	vu_stok_new_produk
								WHERE   produk_id='".$produk_id."'
										AND gudang='".$gudang."'
										AND status='Tertutup'
										AND date_format(tanggal,'%Y-%m-%d') <= '".$tanggal."'
								GROUP BY produk_id";
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			*/
			
			$sql_temp="SELECT konversi_satuan, konversi_nilai FROM satuan_konversi
						WHERE konversi_default=true
						AND konversi_produk='".$produk_id."'";
			$rs=$this->db->query($sql_temp);
			if($rs->num_rows()){
				$row=$rs->row();
				$current_satuan=$row->konversi_satuan;
				$current_konversi=$row->konversi_nilai;
			}
			
			
			$sql = "SELECT SUM(ks_masuk*ks_satuan_nilai/".$current_konversi."), SUM(ks_keluar*ks_satuan_nilai/".$current_konversi."), SUM(ks_masuk*ks_satuan_nilai/".$current_konversi.")-SUM(ks_keluar*ks_satuan_nilai/".$current_konversi.") AS stok_akhir, kartu_stok_fix.ks_satuan_id as satuan_id, kartu_stok_fix.ks_produk_id as produk_id 
			FROM kartu_stok_fix
					WHERE kartu_stok_fix.ks_produk_id = ".$produk_id."
					AND ks_gudang_id = '".$gudang."' ";
					
			
					

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();

			
			if($nbrows<1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 as jumlah_stok,satuan_kode,satuan_id, satuan_nama 
						FROM vu_produk_satuan_terkecil
						WHERE produk_id='".$produk_id."'";
				$result = $this->db->query($sql);
				$nbrows = $result->num_rows();
			}
			
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
	
		
	/*Function utk mencari List Kategori Barang Keluar */
	function get_kategori_barang_keluar_list(){
		$sql = "SELECT * FROM kategori_barang_keluar where kbk_aktif = 'Aktif'";
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
	
		function get_produk_selected_list($gudang,$selected_id,$query,$start,$end){

			if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}
			
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id IN(".$selected_id.")";
			}

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
				
		function get_produk_all_list($gudang,$selected_id,$query,$start,$end){
			/*
			if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
				//$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_nama,jumlah_stok FROM vu_stok_gudang_besar_saldo"; //by masongbee
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}
			*/
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
		
			
		function get_produk_detail_list($gudang,$master_id,$query,$start,$end){
			/*if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok FROM vu_stok_gudang_besar_saldo";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok FROM vu_stok_gudang_produk_saldo";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok FROM vu_stok_gudang_all";
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." gudang_id =".$gudang."";
			}*/
			
			if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
			}
			
			if($master_id<>""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ");
				$sql.=" produk_id IN(SELECT dmutasi_produk FROM detail_mutasi WHERE dmutasi_master='".$master_id."')";
			}
			
			/*if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}*/
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
		
		function get_satuan_produk_list($selected_id){
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
			if($selected_id!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id='".$selected_id."'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		function get_satuan_selected_list($selected_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE satuan_id IN(".$selected_id.")";
			}

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		function get_satuan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($master_id<>"")
				$sql.=" WHERE satuan_id IN(SELECT dmutasi_satuan FROM detail_mutasi WHERE dmutasi_master='".$master_id."')";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
	
	
	/*Function utk memanggil satuan racikan list by produk */
	function get_satuan_racikan_produk_list($selected_id){
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
			if($selected_id!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id='".$selected_id."'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
	/*Function utk memanggil satuan list berdasarkan selected satuan */	
	function get_satuan_racikan_selected_list($selected_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE satuan_id IN(".$selected_id.")";
			}

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
	/* Function racikan by detail list*/	
	function get_satuan_racikan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($master_id<>"")
				$sql.=" WHERE satuan_id IN(SELECT dmracikan_satuan FROM detail_mutasi_racikan WHERE dmracikan_mutasi_id='".$master_id."')";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		
	/*Funtion utk memanggil produk_jadi List */
	function get_produk_jadi_list($query,$aktif,$master_id){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dproduk_produk FROM detail_jual_produk WHERE dproduk_master='$query'";
			$rs=$this->db->query($sql_dproduk);
			$rs_rows=$rs->num_rows();
		}
		
		if($aktif=='yes'){
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
		}
		
		if($master_id!=0){
			$sql = "select dmracikan_produk , produk_nama, produk_id
						dmracikan_satuan, satuan_nama, satuan_id
					from detail_mutasi_racikan 
					left join produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
					left join satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
					where dmracikan_mutasi_id='$master_id'
					";
		}
		
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' ) ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				foreach($rs->result() as $row_dproduk){
					
					$filter.="OR produk_id='".$row_dproduk->dproduk_produk."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		/*
		if($aktif<>'yesno'){
			//$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);
		}
		*/
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
	
	/* Function tempp*/
	function get_produk_jadi_detail_list2($query,$aktif){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dmracikan_produk FROM detail_mutasi_racikan WHERE dmracikan_mutasi_id='$query'";
			$rs=$this->db->query($sql_dproduk);
			$rs_rows=$rs->num_rows();
		}
		
		if($aktif=='yes'){
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
		}else{
			$sql="select * from vu_produk";
		}
		
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' ) ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				foreach($rs->result() as $row_dproduk){
					
					$filter.="OR produk_id='".$row_dproduk->dmracikan_produk."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if(($aktif<>'yesno')){
			
			$result = $this->db->query($sql);
		}
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
	
	
	/*Function utk mengload detail produk jadi list ketika form EDIT */
	function get_produk_jadi_detail_list($master_id,$query){

			$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 FROM vu_produk_satuan_default";
		
			if($master_id<>""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ");
				$sql.=" produk_id IN(SELECT dmracikan_produk FROM detail_mutasi_racikan WHERE dmracikan_mutasi_id='".$master_id."')";
			}

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
	
		
	/*Function utk mengambil produk list berdasarkan No Ref yang dipilih */
	function get_produk_no_ref_list($no_ref,$query,$start,$end){
			/*
			$query_temp = "SELECT dmracikan_mutasi_id from detail_mutasi_racikan
						WHERE dmracikan_id = '".$no_ref."'";
				$result = $this->db->query($query_temp);
				$data=$result->row();
				$dmracikan_mutasi_id=$data->dmracikan_mutasi_id;
			*/
			
			$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_nama,0 FROM vu_produk_satuan_default
					WHERE produk_id IN(SELECT dmracikan_produk FROM detail_mutasi_racikan WHERE dmracikan_mutasi_id='$no_ref')";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit); */

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
		
	/*Function utk menampilkan semua satuan yg masih aktif*/
	function get_satuan_all_list(){
			$sql="SELECT * from satuan where satuan_aktif = 'Aktif'";

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit); */

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
	
	
	/*Function utk browse No Ref  */
	function get_racikan_noref_list($query,$start,$end){
		$sql="SELECT distinct(master_mutasi.mutasi_no) as mutasi_no,  mutasi_id, mutasi_status
				FROM master_mutasi
				LEFT JOIN detail_mutasi_racikan on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
				LEFT JOIN produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
				LEFT JOIN satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
				WHERE detail_mutasi_racikan.dmracikan_jenis = 0 AND master_mutasi.mutasi_status = 'Tertutup' AND mutasi_id NOT IN(
					SELECT dmracikan_noref
					FROM detail_mutasi_racikan
					LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
					WHERE master_mutasi.mutasi_status <> 'Batal' and dmracikan_jenis = 1)
			";
		
		if($query<>""){
			$sql=$sql." and (mutasi_no = '".$query."' or mutasi_no like '%".$query."%') ";
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		//$limit = $sql." LIMIT ".$start.",".$end;			
		//$result = $this->db->query($limit);  
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
		
	/*Function utk mendapatkan produk Jadi yang di cari berdasarkan No Ref */
	function get_detail_item_by_noref($no_ref){
		/*Mengambil primary key dari master_mutasi untuk dijadikan acuan */
		/*
		$query_temp = "SELECT dmracikan_mutasi_id from detail_mutasi_racikan
						WHERE dmracikan_id = '".$no_ref."'
						";
		$result = $this->db->query($query_temp);
		$data=$result->row();
		$dmracikan_mutasi_id=$data->dmracikan_mutasi_id;				
		*/			
						
		$sql="SELECT *
				FROM detail_mutasi_racikan
				LEFT JOIN produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
				LEFT JOIN satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
				WHERE detail_mutasi_racikan.dmracikan_mutasi_id = '".$no_ref."'";
		
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
		
		
		
	//function for detail mutasi racikan list
	//get record list
	function detail_detail_mutasi_racikan_list($master_id,$query,$start,$end) {
			
			$query = "SELECT detail_mutasi_racikan.*, produk.produk_nama, satuan.satuan_nama, /*master_mutasi.mutasi_no, */
(select distinct(master_mutasi.mutasi_no) from detail_mutasi_racikan 
				LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
				WHERE detail_mutasi_racikan.dmracikan_mutasi_id = '".$master_id."'
)as mutasi_no
						FROM detail_mutasi_racikan 
						LEFT JOIN produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
						LEFT JOIN satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
						LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
						where dmracikan_mutasi_id='".$master_id."' ORDER by dmracikan_id DESC";
			
/*			
	select detail_mutasi_racikan.* 
from detail_mutasi_racikan
LEFT JOIN produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
LEFT JOIN satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
where dmracikan_mutasi_id = '".$master_id."' order by dmracikan_id DESC					
	*/					
						
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			*/
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
	//end of function	
		
		
	//function for detail mutasi racikan list
	//get record list
	function detail_detail_mutasi_produk_jadi_list($master_id,$query,$start,$end) {
			
			$query = "SELECT detail_mutasi_racikan.*, produk.produk_nama, satuan.satuan_nama, /*master_mutasi.mutasi_no, */
(select distinct(master_mutasi.mutasi_no) from detail_mutasi_racikan 
				LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
				WHERE detail_mutasi_racikan.dmracikan_mutasi_id = '".$master_id."'
)as mutasi_no
						FROM detail_mutasi_racikan 
						LEFT JOIN produk on (produk.produk_id = detail_mutasi_racikan.dmracikan_produk)
						LEFT JOIN satuan on (satuan.satuan_id = detail_mutasi_racikan.dmracikan_satuan)
						LEFT JOIN master_mutasi on (master_mutasi.mutasi_id = detail_mutasi_racikan.dmracikan_mutasi_id)
						where dmracikan_mutasi_id='".$master_id."' ORDER by dmracikan_id DESC";
									
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			*/
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
	//end of function	
	
	/*Load No Ref , ketika memasuki fungsi EDIT / Set Form */
	function load_noref_edit($no_ref,$query,$start,$end) {
			
			$query = "select distinct(a.mutasi_no) as mutasi_no from detail_mutasi_racikan d
				JOIN master_mutasi a on (a.mutasi_id = d.dmracikan_noref)
				where d.dmracikan_mutasi_id = '".$no_ref."'";
									
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();

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
	//end of function	
	
		//function for detail
		//get record list
		function detail_detail_mutasi_list($master_id,$query,$start,$end) {
			
			$query = "SELECT dmutasi_id,dmutasi_master,dmutasi_produk,dmutasi_satuan,dmutasi_jumlah
						FROM detail_mutasi where dmutasi_master='".$master_id."' ORDER by dmutasi_id DESC";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			*/
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
		//end of function
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(mutasi_id) as master_id from master_mutasi";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$master_id=$data->master_id;
				return $master_id;
			}else{
				return '0';
			}
		}
		//eof
		
		//purge all detail from master
		function detail_detail_mutasi_purge($master_id){
			$sql="DELETE from detail_mutasi where dmutasi_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
		//insert detail record
		function detail_detail_mutasi_insert($array_dmutasi_id ,$dmutasi_master ,$array_dmutasi_produk 
											 ,$array_dmutasi_satuan ,$array_dmutasi_jumlah ){

			$query="";
			for($i = 0; $i < sizeof($array_dmutasi_produk); $i++){
           
				$data = array(
					"dmutasi_master"=>$dmutasi_master, 
					"dmutasi_produk"=>$array_dmutasi_produk[$i], 
					"dmutasi_satuan"=>$array_dmutasi_satuan[$i], 
					"dmutasi_jumlah"=>$array_dmutasi_jumlah[$i] 
				);
				/*
				if($array_dmutasi_id[$i]!=0){
					$query = $query.$array_dmutasi_id[$i];
					if($i<sizeof($array_dmutasi_id)-1){
						$query = $query . ",";
					} 
					
					$this->db->where('dmutasi_id', $array_dmutasi_id[$i]);
					$this->db->update('detail_mutasi', $data);
				}
				else
				{
					$this->db->insert('detail_mutasi', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dmutasi_id)-1){
						$query = $query . ",";
					}
				}
				*/
				
				if($array_dmutasi_id[$i]==0){
					$this->db->insert('detail_mutasi', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dmutasi_id)-1){
						$query = $query . ",";
					}
					
				}else{
					$query = $query.$array_dmutasi_id[$i];
					if($i<sizeof($array_dmutasi_id)-1){
						$query = $query . ",";
					} 
					
					$this->db->where('dmutasi_id', $array_dmutasi_id[$i]);
					$this->db->update('detail_mutasi', $data);
				}
				
			 }
				
			 if($query<>""){
				$sql="DELETE FROM detail_mutasi WHERE  dmutasi_master='".$dmutasi_master."' AND
						dmutasi_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return '1';
		}
		//end of function
		
		/*Function for insert to detail_mutasi_racikan yang keluar */
		function detail_mutasi_racikan_keluar_insert($cetak, $mracikan_mutasi_id, $array_dmracikan_id, $array_dmracikan_produk, $array_dmracikan_jumlah, $array_dmracikan_satuan){
			
		$size_array = sizeof($array_dmracikan_produk) - 1;
		
		for($i = 0; $i < sizeof($array_dmracikan_produk); $i++){
			$dmracikan_id = $array_dmracikan_id[$i];
			$dmracikan_produk = $array_dmracikan_produk[$i];
			$dmracikan_satuan = $array_dmracikan_satuan[$i];
			$dmracikan_jumlah = $array_dmracikan_jumlah[$i];
		
		$data = array(
				"dmracikan_mutasi_id"=>$mracikan_mutasi_id,
				"dmracikan_jenis"=>0,
				"dmracikan_produk"=>$dmracikan_produk,
				"dmracikan_jumlah"=>$dmracikan_jumlah,
				"dmracikan_satuan"=>$dmracikan_satuan,
				"dmracikan_creator"=>$_SESSION[SESSION_USERID],
				"dmracikan_date_create"=>date('Y-m-d H:i:s')
			);
			
			$this->db->insert('detail_mutasi_racikan', $data); 

		}
			
			
			

			
			if($this->db->affected_rows())
			{
				/*Jika langsung di Save and Print, maka status dokumen lgsg jadi Tertutup dan status_terima akan dibuat string kosong.. */
				if($cetak==1)
				{
				$sql="UPDATE master_mutasi SET mutasi_status='Tertutup', mutasi_status_terima = '' WHERE mutasi_id='".$mracikan_mutasi_id."'";
				$result = $this->db->query($sql);
				}
			
					return $mracikan_mutasi_id;
			}
			else
				return '0';
		}
		
		/*Function utk melakukan insert detail mutasi racikan yang masuk*/
		//function for create new record
		function detail_mutasi_racikan_masuk_insert($cetak, $mracikan_mutasi_id, $racikan_dmracikan_id){
					
			$data = array(
				"dmracikan_mutasi_id"=>$mracikan_mutasi_id,
				"dmracikan_noref"=>$racikan_dmracikan_id,
				"dmracikan_jenis"=>1,
				"dmracikan_creator"=>$_SESSION[SESSION_USERID],
				"dmracikan_date_create"=>date('Y-m-d H:i:s')
			);

			$this->db->insert('detail_mutasi_racikan', $data); 
			if($this->db->affected_rows())
			{
				/*Jika langsung di Save and Print, maka status dokumen lgsg jadi Tertutup dan status_terima akan dibuat string kosong.. */
				if($cetak==1)
				{
				$sql="UPDATE master_mutasi SET mutasi_status='Tertutup', mutasi_status_terima = '' WHERE mutasi_id='".$mracikan_mutasi_id."'";
				$result = $this->db->query($sql);
				}
				
					return $mracikan_mutasi_id;
			}
			else
				return '0';
		}
		
		/*Pengecekan Dokumen utk Mutasi Barang */
		function pengecekan_dokumen($tanggal_pengecekan,$mutasi_asal ,$mutasi_tujuan){

			$sql_day = "SELECT mb_days from transaksi_setting";
			$query_day= $this->db->query($sql_day);
			$data_day= $query_day->row();
			$day= $data_day->mb_days;
			
			$sql_tgl = "SELECT date_format(date_add('".$tanggal_pengecekan."',interval ".$day." day),'%Y-%m-%d') as tanggal";			
			$query_tgl=$this->db->query($sql_tgl);
				if($query_tgl->num_rows()){
					$tgl=$query_tgl->row();
					$tanggal=$tgl->tanggal;
				}
				
			//$sql_status = "SELECT mutasi_no from vu_trans_mutasi where group_id = '".$_SESSION[SESSION_GROUPID]."' and (mutasi_status_terima = 'Tunggu' AND mutasi_status = 'Tunggu')";			
			
			$sql_status = "SELECT mutasi_no from vu_trans_mutasi where (mutasi_asal = '".$mutasi_asal."' or gudang_asal_nama= '".$mutasi_asal."') and (mutasi_tujuan = '".$mutasi_tujuan."'  or gudang_tujuan_nama = '".$mutasi_tujuan."') and (mutasi_status_terima = 'Tunggu' AND mutasi_status = 'Tunggu')";			

			$query_status=$this->db->query($sql_status);
			$nbrows = $query_status->num_rows();

			$date = date('Y-m-d');
			
			if ($date <= $tanggal || $tanggal_pengecekan == $date) 
			{
				if ($nbrows <> 0){
					//return $query_status;
					foreach($query_status->result() as $row){
						$arr[] = $row;
					}
					$jsonresult = json_encode($arr);
					return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
				}else
					return '1';
			
			}else
			{
				return '0';
			}
		}
		
		function master_mutasi_pengecekan_saveclose($tanggal_pengecekan,$no_mb,$mutasi_asal ,$mutasi_tujuan){

			$sql_day = "SELECT mb_days from transaksi_setting";
			$query_day= $this->db->query($sql_day);
			$data_day= $query_day->row();
			$day= $data_day->mb_days;
			
			$sql_tgl = "SELECT date_format(date_add('".$tanggal_pengecekan."',interval ".$day." day),'%Y-%m-%d') as tanggal";			
			$query_tgl=$this->db->query($sql_tgl);
				if($query_tgl->num_rows()){
					$tgl=$query_tgl->row();
					$tanggal=$tgl->tanggal;
				}
				
			$sql_status = "SELECT mutasi_id from vu_trans_mutasi where mutasi_asal = '".$mutasi_asal."' and mutasi_tujuan = '".$mutasi_tujuan."' and (mutasi_status_terima = 'Tunggu' AND mutasi_status = 'Tunggu') and mutasi_id <> '".$no_mb."'";			
			$query_status=$this->db->query($sql_status);
			$nbrows_status = $query_status->num_rows();

			$date = date('Y-m-d');
			
			if ($date <= $tanggal || $tanggal_pengecekan == $date) 
			{
					return '1';
			}
			else
			{
				return '0';
			}
		}
		
		//function for get list record
		function master_mutasi_list($filter,$start,$end){
			/*Jika yang login adalah Suster */
			if($_SESSION[SESSION_GROUPID]==12)
			{
				$query = "SELECT * FROM vu_trans_mutasi where (mutasi_asal = 4 or mutasi_tujuan = 4)";
			}
			/*Jika yang login adalah Terapis */
			else if($_SESSION[SESSION_GROUPID]==7){
				$query = "SELECT * FROM vu_trans_mutasi where (mutasi_asal = 3 or mutasi_tujuan = 3)";
			}
			/*Jika yang login adalah Gudang Besar */
			else if($_SESSION[SESSION_GROUPID]==23){
				$query = "SELECT * FROM vu_trans_mutasi where (mutasi_asal = 1 or mutasi_tujuan = 1)";
			}
			/*Jika yang login adalah Kasir / Apoteker */
			else if($_SESSION[SESSION_GROUPID]==4 || $_SESSION[SESSION_GROUPID]==26){
				$query = "SELECT * FROM vu_trans_mutasi where (mutasi_asal = 2 or mutasi_tujuan = 2 or mutasi_asal = 1 or mutasi_tujuan = 1)";
			}
			else
			$query = "SELECT * FROM vu_trans_mutasi";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (mutasi_no LIKE '%".addslashes($filter)."%' OR gudang_asal_nama LIKE '%".addslashes($filter)."%' OR 
							gudang_tujuan_nama LIKE '%".addslashes($filter)."%' OR mutasi_keterangan LIKE '%".addslashes($filter)."%' )";
			}
			
			$query .= " ORDER BY mutasi_id DESC ";
			
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
		
		//function for update record
		function master_mutasi_update($mutasi_id ,$mutasi_no, $mutasi_spb, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tanggal ,$mutasi_keterangan, $mutasi_status, $mutasi_status_terima, $mutasi_barang_keluar, $mutasi_racikan, $mutasi_kategori_barang_keluar, $cetak, $printonly){
			
			if($mutasi_barang_keluar=='true')
			{
				$barang_keluar = 1;
			}
			else
			{
				$barang_keluar = 0;
			}
			$data = array(
				"mutasi_id"=>$mutasi_id, 
				"mutasi_no"=>$mutasi_no,
				"mutasi_spb"=>$mutasi_spb,
//				"mutasi_asal"=>$mutasi_asal, 
//				"mutasi_tujuan"=>$mutasi_tujuan, 
				"mutasi_tanggal"=>$mutasi_tanggal, 
				"mutasi_keterangan"=>$mutasi_keterangan,
				"mutasi_status"=>$mutasi_status,
				"mutasi_status_terima"=>$mutasi_status_terima,
				"mutasi_kategori_barang_keluar"=>$mutasi_kategori_barang_keluar,
				"mutasi_update"=>$_SESSION[SESSION_USERID],
				"mutasi_date_update"=>date('Y-m-d H:i:s')
			);
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$mutasi_asal."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["mutasi_asal"]=$mutasi_asal;
			
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$mutasi_tujuan."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["mutasi_tujuan"]=$mutasi_tujuan;
				
			if ($cetak==1)
			{
				if($barang_keluar!=1 && $mutasi_racikan=='false' && $printonly==0){
					$data['mutasi_status'] = 'Tunggu'; //ini mestie nanti Tunggu
					$data['mutasi_status_terima'] = 'Tunggu';
				}
				else if(($barang_keluar==1 || $mutasi_racikan=='true') && $printonly==0)
				{
					$data['mutasi_status'] = 'Tertutup';
				}
				else if($printonly==1)
				{
					$data['mutasi_status'] = $mutasi_status;
				}
			}
			//else{
				//$data['terima_status'] = 'Terbuka';
			//}
			
			$this->db->where('mutasi_id', $mutasi_id);
			$this->db->update('master_mutasi', $data);
			
			$sql="UPDATE master_mutasi SET mutasi_revised=0 WHERE mutasi_id='".$mutasi_id."' AND mutasi_revised is NULL";
			$result = $this->db->query($sql);
			
			$sql="UPDATE master_mutasi SET mutasi_revised=(mutasi_revised+1) WHERE mutasi_id='".$mutasi_id."'";
			$result = $this->db->query($sql);
			
			/*Tambahin IF disini, jika mutasi_status_terima menerima value Diterima, maka mutasi_status diupdate menjadi Tertutup.. */
			if($mutasi_status_terima=='Diterima' && $mutasi_status!='Batal')
			{
			$sql="UPDATE master_mutasi SET mutasi_status='Tertutup' WHERE mutasi_id='".$mutasi_id."'";
			$result = $this->db->query($sql);
			}
			if($mutasi_status_terima=='Ditolak')
			{
			$sql="UPDATE master_mutasi SET mutasi_status='Batal' WHERE mutasi_id='".$mutasi_id."'";
			$result = $this->db->query($sql);
			}
			
			return $mutasi_id;
		}
		
		//function for create new record
		function master_mutasi_create($mutasi_no, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tanggal ,$mutasi_keterangan, $mutasi_status, $mutasi_spb, $mutasi_racikan, $racikan_keluar, $racikan_masuk, $racikan_produk, $racikan_jumlah, $racikan_satuan, $racikan_dmracikan_id, $mutasi_barang_keluar, $mutasi_status_terima, $mutasi_kategori_barang_keluar, $cetak , $printonly, $array_dmracikan_id, $array_dmracikan_produk, $array_dmracikan_satuan, $array_dmracikan_jumlah){
		
			$racikan = 0;
			$temp_kode_gudang = "";
			$barang_keluar = 0;
			if($mutasi_asal==1)
				$temp_kode_gudang = "GB";
			if($mutasi_asal==2)
				$temp_kode_gudang = "GR";
			if($mutasi_asal==3)
				$temp_kode_gudang = "KT";
			if($mutasi_asal==4)
				$temp_kode_gudang = "KS";
			if($mutasi_racikan=='true')
			{
				$temp_kode_gudang = "RC";
				$racikan = 1;
			}
			if($racikan_keluar=='true')
			{
				$mutasi_asal = 2;
				$mutasi_tujuan = 99;
			}
			if($racikan_masuk=='true')
			{
				$mutasi_tujuan = 2;
				$mutasi_asal = 99;
			}
			if($mutasi_barang_keluar=='true')
			{
				$mutasi_status_terima = '';
				$barang_keluar = 1;
				$mutasi_tujuan = 99;
			}
			
			
			$mutasi_tanggal_pattern=strtotime($mutasi_tanggal);
			$pattern="MB-".$temp_kode_gudang."/".date("ym",$mutasi_tanggal_pattern)."-";
			$mutasi_no=$this->m_public_function->get_kode_1('master_mutasi','mutasi_no',$pattern,15);
			
			$data = array(
				"mutasi_no"=>$mutasi_no,
				"mutasi_asal"=>$mutasi_asal, 
				"mutasi_tujuan"=>$mutasi_tujuan, 
				"mutasi_tanggal"=>$mutasi_tanggal, 
				"mutasi_keterangan"=>$mutasi_keterangan,
				"mutasi_status"=>$mutasi_status,
				"mutasi_status_terima"=>$mutasi_status_terima,
				"mutasi_kategori_barang_keluar"=>$mutasi_kategori_barang_keluar,
				"mutasi_spb"=>$mutasi_spb,
				"mutasi_racikan"=>$racikan, 
				"mutasi_barang_keluar"=>$barang_keluar,
				"mutasi_creator"=>$_SESSION[SESSION_USERID],
				"mutasi_date_create"=>date('Y-m-d H:i:s'),
				"mutasi_revised"=>0
			);
			
			if($cetak==1 && $barang_keluar!=1){
				$data['mutasi_status'] = 'Tunggu'; //ini mesti e nanti Tunggu
				$data['mutasi_status_terima'] = 'Tunggu';
			}
			else if($cetak==1 && $barang_keluar==1)
			{
				$data['mutasi_status'] = 'Tertutup';
			}
			else{
				$data['mutasi_status'] = 'Terbuka';
			}
			
			$this->db->insert('master_mutasi', $data); 
			if($this->db->affected_rows())
			{
			
				if($racikan_keluar=='true' && $mutasi_racikan=='true'){
					$mracikan_mutasi_id = $this->db->insert_id();
					$rs_dmracikan_insert = $this->detail_mutasi_racikan_keluar_insert($cetak, $mracikan_mutasi_id, $array_dmracikan_id, $array_dmracikan_produk, $array_dmracikan_jumlah, $array_dmracikan_satuan);
					return $rs_dmracikan_insert;
				
				}
				else if($racikan_masuk=='true' && $mutasi_racikan=='true'){
					$mracikan_mutasi_id = $this->db->insert_id();
					$rs_dmracikan_insert = $this->detail_mutasi_racikan_masuk_insert($cetak, $mracikan_mutasi_id, $racikan_dmracikan_id);
					return $rs_dmracikan_insert;
				}
				else
					return $this->db->insert_id();
			
				//return $this->db->insert_id();
				
			}
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_mutasi_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the master_mutasis at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_mutasi WHERE mutasi_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_mutasi WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "mutasi_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function master_mutasi_search($mutasi_id, $mutasi_no,$mutasi_asal ,$mutasi_tujuan ,$mutasi_tgl_awal, $mutasi_tgl_akhir ,
									  $mutasi_keterangan ,$mutasi_status, $mutasi_status_terima, $start,$end){
			/*Jika yang login adalah Suster */
			if($_SESSION[SESSION_GROUPID]==12)
			{
				$query = "SELECT * FROM vu_trans_mutasi
							where mutasi_asal = 4
							";
			}
			/*Jika yang login adalah Terapis */
			else if($_SESSION[SESSION_GROUPID]==7){
				$query = "SELECT * FROM vu_trans_mutasi
							where mutasi_asal = 3
							";
			}
			/*Jika yang login adalah Gudang Besar */
			else if($_SESSION[SESSION_GROUPID]==23){
				$query = "SELECT * FROM vu_trans_mutasi
							where mutasi_asal = 1
							";
			}
			/*Jika yang login adalah Kasir / Apoteker */
			else if($_SESSION[SESSION_GROUPID]==4 || $_SESSION[SESSION_GROUPID]==26){
				$query = "SELECT * FROM vu_trans_mutasi
							where mutasi_asal = 2 or mutasi_asal = 1
							";
			}
			else
			$query = "SELECT * FROM vu_trans_mutasi";
			
			if($mutasi_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_no LIKE '%".$mutasi_no."%'";
			};
			if($mutasi_asal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_asal='".$mutasi_asal."'";
			};
			if($mutasi_tujuan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_tujuan='".$mutasi_tujuan."'";
			};
			if($mutasi_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') >='".$mutasi_tgl_awal."'";
			};
			if($mutasi_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') <='".$mutasi_tgl_akhir."'";
			};
			if($mutasi_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_keterangan LIKE '%".$mutasi_keterangan."%'";
			};
			if($mutasi_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_status='".$mutasi_status."'";
			};
			if($mutasi_status_terima!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " mutasi_status_terima='".$mutasi_status_terima."'";
			};
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$this->firephp->log($query);
			
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
		function master_mutasi_print($mutasi_id, $mutasi_no,$mutasi_asal ,$mutasi_tujuan ,$mutasi_tgl_awal, $mutasi_tgl_akhir ,
									  $mutasi_keterangan ,$mutasi_status,$option,$filter){
			//full query
			$query = "SELECT * FROM vu_trans_mutasi";
			
			// For simple search
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (mutasi_no LIKE '%".addslashes($filter)."%' OR gudang_asal_nama LIKE '%".addslashes($filter)."%' OR 
								gudang_tujuan_nama LIKE '%".addslashes($filter)."%' OR mutasi_keterangan LIKE '%".addslashes($filter)."%' )";
					
				}
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($mutasi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_no LIKE '%".$mutasi_no."%'";
				};
				if($mutasi_asal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_asal='".$mutasi_asal."'";
				};
				if($mutasi_tujuan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_tujuan='".$mutasi_tujuan."'";
				};
				if($mutasi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') >='".$mutasi_tgl_awal."'";
				};
				if($mutasi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') <='".$mutasi_tgl_akhir."'";
				};
				if($mutasi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_keterangan LIKE '%".$mutasi_keterangan."%'";
				};
				if($mutasi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_status='".$mutasi_status."'";
				};
				$result = $this->db->query($query);
			}
			return $result->result();
		}
		
		//function  for export to excel
		function master_mutasi_export_excel($mutasi_id ,$mutasi_asal ,$mutasi_tujuan ,$mutasi_tanggal ,$mutasi_keterangan ,$option,$filter){
			//full query
			$query = "SELECT if(mutasi_no='','-',ifnull(mutasi_no,'-')) as 'No MB',
						date_format(mutasi_tanggal,'%Y-%m-%d') as Tanggal,
						if(gudang_asal_nama='','-',ifnull(gudang_asal_nama,'-'))  as 'Gudang Asal',
						if(gudang_tujuan_nama='','-',ifnull(gudang_tujuan_nama,'-'))  as 'Gudang Tujuan',
						ifnull(jumlah_barang,0) as 'Jumlah Barang',
						if(mutasi_keterangan='','-',ifnull(mutasi_keterangan,'-')) as 'Keterangan',
						mutasi_status as 'Status'
						FROM vu_trans_mutasi";
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (mutasi_no LIKE '%".addslashes($filter)."%' OR gudang_asal_nama LIKE '%".addslashes($filter)."%' OR 
								gudang_tujuan_nama LIKE '%".addslashes($filter)."%' OR mutasi_keterangan LIKE '%".addslashes($filter)."%' )";
					
				}
			} else if($option=='SEARCH'){
				if($mutasi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_no LIKE '%".$mutasi_no."%'";
				};
				if($mutasi_asal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_asal='".$mutasi_asal."'";
				};
				if($mutasi_tujuan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_tujuan='".$mutasi_tujuan."'";
				};
				if($mutasi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') >='".$mutasi_tgl_awal."'";
				};
				if($mutasi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(mutasi_tanggal,'%Y-%m-%d') <='".$mutasi_tgl_akhir."'";
				};
				if($mutasi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_keterangan LIKE '%".$mutasi_keterangan."%'";
				};
				if($mutasi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " mutasi_status='".$mutasi_status."'";
				};
				
			}
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>