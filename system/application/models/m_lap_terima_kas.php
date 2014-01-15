<?

class M_lap_terima_kas extends Model{
	
	function M_lap_terima_kas(){
		parent::Model();
	}
	
	function get_laporan_terima_kas_total2($tgl_awal,$tgl_akhir,$periode, $cabang){
		$this->cabang = $this->load->database($cabang, TRUE);
		
		/*function ini tidak menghitung PR & Pelunasan Piutang, karena memang tidak termasuk pencapaian target*/
		
		$sql="";
		if($periode=='bulan')
			$sql=	   "SELECT 									
							sum(nilai_card) as nilai_card_total,
							sum(nilai_cek) as nilai_cek_total, 
							sum(nilai_kredit) as nilai_kredit_total, 
							sum(nilai_kwitansi) as nilai_kwitansi_total, 
							sum(nilai_transfer) as nilai_transfer_total,
							sum(nilai_tunai) as nilai_tunai_total,
							sum(nilai_voucher) as nilai_voucher_total,
							sum(nilai_card+nilai_cek+nilai_kwitansi+nilai_transfer+nilai_tunai) as nilai_grand_total
				FROM 		vu_trans_terima_jual 
				WHERE 		date_format(tanggal,'%Y-%m')='".$tgl_awal."' 
							AND stat_dok='Tertutup'
							AND no_ref<>'' AND jenis_transaksi <> 'jual_rawat' AND jenis_transaksi <> 'jual_lunas'";
		else if($periode=='tanggal')
			$sql=	   "SELECT 				
							sum(nilai_card) as nilai_card_total,
							sum(nilai_cek) as nilai_cek_total, 
							sum(nilai_kredit) as nilai_kredit_total, 
							sum(nilai_kwitansi) as nilai_kwitansi_total, 
							sum(nilai_transfer) as nilai_transfer_total,
							sum(nilai_tunai) as nilai_tunai_total,
							sum(nilai_voucher) as nilai_voucher_total,
							sum(nilai_card+nilai_cek+nilai_kwitansi+nilai_transfer+nilai_tunai) as nilai_grand_total
						FROM vu_trans_terima_jual 
						WHERE date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND 
							date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' AND 
							stat_dok='Tertutup' AND jenis_transaksi <> 'jual_rawat' AND jenis_transaksi <> 'jual_lunas'";

		//echo $sql;
		$query = $this->cabang->query($sql);
					
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
	
}
?>