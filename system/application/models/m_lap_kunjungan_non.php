<? /* 
	+ Module  		: Laporan Kunjungan Non Transaksi Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_kunjungan_non.php
 	+ Author  		: Fred
*/

class M_lap_kunjungan_non extends Model{
		
	//constructor
	function M_lap_kunjungan_non() {
		parent::Model();
	}
		
	//function for get list record
	function lap_kunjungan_non_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			//$query="select count(distinct jpaket_cust) as jumlah_total
			//from master_jual_paket";
			$query="select count(distinct cust), tgl_tindakan from
(
	(
		select 
			tindakan.trawat_cust as cust,
			tindakan_detail.dtrawat_tglapp as tgl_tindakan
		from tindakan_detail
		left join tindakan on (tindakan.trawat_id=tindakan_detail.dtrawat_master)	
		left join perawatan on (tindakan_detail.dtrawat_perawatan = perawatan.rawat_id)
		where perawatan.rawat_harga = 0
	
	)
	union
	(
		select 
			master_jual_produk.jproduk_cust as cust,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		where master_jual_produk.jproduk_totalbiaya = 0
	)
) as table_union
where tgl_tindakan = '$date_now'
group by tgl_tindakan";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0 || $nbrows2>0 || $nbrows3>0){
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
		
	function lap_totalkunjungan_non_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			$query="select count(distinct cust) from
(
	(
		select 
			tindakan.trawat_cust as cust,
			tindakan_detail.dtrawat_tglapp as tgl_tindakan
		from tindakan_detail
		left join tindakan on (tindakan.trawat_id=tindakan_detail.dtrawat_master)	
		left join perawatan on (tindakan_detail.dtrawat_perawatan = perawatan.rawat_id)
		where perawatan.rawat_harga = 0
	
	)
	union
	(
		select 
			master_jual_produk.jproduk_cust as cust,
			master_jual_produk.jproduk_tanggal as tgl_tindakan
		from master_jual_produk
		where master_jual_produk.jproduk_totalbiaya = 0
	)
) as table_union
where tgl_tindakan = '$date_now'";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			if($nbrows>0 || $nbrows2>0 || $nbrows3>0 || $nbrows4>0){
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
		
	//function for advanced search record
	function lap_kunjungan_non_search($lap_kunjungan_nonkelamin, $lap_kunjungan_nonmember, $lap_kunjungan_noncust,$lap_kunjungan_id ,$trawat_tglapp_start ,$trawat_tglapp_end, $start,$end){

			
		if ($lap_kunjungan_nonkelamin == '' or $lap_kunjungan_nonkelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_nonkelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_nonkelamin'";
		}
		else if($lap_kunjungan_nonkelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_nonkelamin'";			
		}
		
		if ($lap_kunjungan_noncust == '' or $lap_kunjungan_noncust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_noncust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_noncust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}			
		
		if ($lap_kunjungan_nonmember == '' or $lap_kunjungan_nonmember == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_nonmember == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_nonmember == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_nonmember == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
			
		$query = "select count(distinct cust), tgl_tindakan 
				from
				(
					(
						select 
							tindakan.trawat_cust as cust,
							tindakan_detail.dtrawat_tglapp as tgl_tindakan,
							'tindakan' as status
						from tindakan_detail
						left join tindakan on (tindakan.trawat_id=tindakan_detail.dtrawat_master)	
						left join perawatan on (tindakan_detail.dtrawat_perawatan = perawatan.rawat_id)
						left join vu_customer on (tindakan.trawat_cust = vu_customer.cust_id) 
						where perawatan.rawat_harga = 0 ".$cust_kelamin."".$cust_daftar."".$stat_member."
					
					)
					union
					(
						select 
							master_jual_produk.jproduk_cust as cust,
							master_jual_produk.jproduk_tanggal as tgl_tindakan,
							'produk' as status
						from master_jual_produk
						left join vu_customer on (master_jual_produk.jproduk_cust=vu_customer.cust_id)
						where master_jual_produk.jproduk_totalbiaya = 0 ".$cust_kelamin."".$cust_daftar."".$stat_member."
					)
				) as table_union";
								
		
		
		if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
				$query.=eregi("WHERE",$query)?" WHERE ":" WHERE ";
				$query.= " tgl_tindakan BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."'";
			}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " tgl_tindakan='".$trawat_tglapp_start."'";
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
	function lap_kunjungan_non_search2($lap_kunjungan_nonkelamin, $lap_kunjungan_nonmember, $lap_kunjungan_noncust,$lap_kunjungan_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter,$start,$end){

		if ($lap_kunjungan_nonkelamin == '' or $lap_kunjungan_nonkelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_kunjungan_nonkelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_nonkelamin'";
		}
		else if($lap_kunjungan_nonkelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_kunjungan_nonkelamin'";			
		}
		
		if ($lap_kunjungan_noncust == '' or $lap_kunjungan_noncust == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($lap_kunjungan_noncust == 'Lama')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_noncust == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$trawat_tglapp_start' and '$trawat_tglapp_end'";			
		}			
		
		if ($lap_kunjungan_nonmember == '' or $lap_kunjungan_nonmember == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_kunjungan_nonmember == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_nonmember == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$trawat_tglapp_start' and '$trawat_tglapp_end'";
		}
		else if($lap_kunjungan_nonmember == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}

		$query = "select distinct count(cust) as jumlah
				from
				(
					(
						select 
							tindakan.trawat_cust as cust,
							tindakan_detail.dtrawat_tglapp as tgl_tindakan,
							'tindakan' as status
						from tindakan_detail
						left join tindakan on (tindakan.trawat_id=tindakan_detail.dtrawat_master)	
						left join perawatan on (tindakan_detail.dtrawat_perawatan = perawatan.rawat_id)
						left join vu_customer on (tindakan.trawat_cust = vu_customer.cust_id) 
						where perawatan.rawat_harga = 0 ".$cust_kelamin."".$cust_daftar."".$stat_member."
					
					)
					union
					(
						select 
							master_jual_produk.jproduk_cust as cust,
							master_jual_produk.jproduk_tanggal as tgl_tindakan,
							'produk' as status
						from master_jual_produk
						left join vu_customer on (master_jual_produk.jproduk_cust=vu_customer.cust_id)
						where master_jual_produk.jproduk_totalbiaya = 0 ".$cust_kelamin."".$cust_daftar."".$stat_member."
					)
				) as table_union";

			if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
				$query.=eregi("WHERE",$query)?" WHERE ":" WHERE ";
				$query.= " tgl_tindakan BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."'";
			}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " tgl_tindakan='".$trawat_tglapp_start."'";
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

	//function for print record
	/*function lap_kunjungan_non_print($trawat_id ,$trawat_cust ,$trawat_keterangan ,$option,$filter){
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
		}*/
		
	//function  for export to excel
	/*function lap_kunjungan_non_export_excel($trawat_id ,$trawat_dokter ,$option,$filter){
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