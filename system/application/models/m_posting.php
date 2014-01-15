<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: posting Model
	+ Description	: For record model process back-end
	+ Filename 		: c_posting.php
 	+ creator 		:
 	+ Created on 12/Mar/2010 10:42:59

*/

class M_posting extends Model{

		//constructor
		function M_posting() {
			parent::Model();
		}

		function post_transaksi($tgl_awal,$tgl_akhir,$bulan,$tahun,$periode){

			$tanggal=date('Y-m-d H:i:s');
			if($periode=='tanggal'){
			
				//KOSONGKAN buku_besar_temp
				$sql_del = "DELETE FROM buku_besar_temp";
				$this->db->query($sql_del);
			
			
				//POSTING KE buku_besar_temp
				//tujuan menggunakan buku_besar_temp supaya jika proses posting gagal ditengah2 (komp mati misalnya), maka seluruh proses posting dibatalkan dulu. Jika tidak menggunakan buku_besar_temp, maka kemungkinan double posting cukup besar.
				
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						SELECT 
							N.tanggal, N.no_jurnal, N.akun, N.akun_kode, N.keterangan, N.debet, N.kredit, '".@$_SESSION[SESSION_USERID]."'
						FROM (
							SELECT
								concat('JU-',J.djurnal_id) as no_id, 
								J.`jurnal_no` AS `no_jurnal`, 
								date_format(J.`jurnal_tanggal`,'%Y-%m-%d') AS `tanggal`,
								J.`djurnal_akun` AS `akun`,
								J.`akun_kode` AS `akun_kode`,
								J.`akun_nama` AS `akun_nama`,
								J.`djurnal_detail` AS `keterangan`,
								J.`djurnal_debet` AS `debet`,
								J.`djurnal_kredit` AS `kredit`,
								J.`jurnal_post` AS `post`,
								J.`jurnal_date_post` AS `post_date`
							FROM `vu_jurnal` J
							WHERE (J.jurnal_post<>'Y' OR J.jurnal_post IS NULL)
								AND date_format(J.jurnal_tanggal,'%Y-%m-%d')>=date_format('".$tgl_awal."','%Y-%m-%d')
								AND date_format(J.jurnal_tanggal,'%Y-%m-%d')<=date_format('".$tgl_akhir."','%Y-%m-%d')";

				//JURNAL KASBANK
				$sql.= 	   "UNION 
							SELECT
								concat('JK-',K.kasbank_detid) as no_id,
								K.`no_jurnal` AS `no_jurnal`,
								date_format(K.`tanggal`,'%Y-%m-%d') AS `tanggal`,
								K.`akun` AS `akun`,
								K.`akun_kode` AS `akun_kode`,
								K.`akun_nama` AS `akun_nama`,
								K.`keterangan` AS `keterangan`,
								K.`debet` AS `debet`,
								K.`kredit` AS `kredit`,
								K.`post` AS `post`,
								K.`post_date` AS `post_date`
							FROM `vu_jurnal_bank` K
							WHERE (K.post<>'Y' OR K.post is NULL)
								AND date_format(K.tanggal,'%Y-%m-%d')>=date_format('".$tgl_awal."','%Y-%m-%d')
								AND date_format(K.tanggal,'%Y-%m-%d')<=date_format('".$tgl_akhir."','%Y-%m-%d')
							) 
							as N";
					
				$this->db->query($sql);

				
				// PENJUALAN PRODUK
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*TUNAI*/
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							4, /*->Kas Kecil*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 4) as akun_kode,
							'' as keterangan,
							sum(j.jtunai_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_tunai j
						RIGHT JOIN master_jual_produk m on m.jproduk_nobukti = j.jtunai_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jtunai_transaksi = 'jual_produk' OR j.jtunai_transaksi is null)
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal
							
						UNION
						
						/*KARTU KREDIT*/
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							57, /*->Piutang Card*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 57) as akun_kode,
							'' as keterangan,
							sum(j.jcard_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_card j
						RIGHT JOIN master_jual_produk m on m.jproduk_nobukti = j.jcard_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jcard_transaksi = 'jual_produk' OR j.jcard_transaksi is null)
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal
							
						UNION
						
						/*TRANSFER, CEK GIRO*/
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							54, /*->Piutang Usaha Produk*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 53) as akun_kode,
							'' as keterangan,							
							ifnull((
								SELECT sum(ifnull(j.jtransfer_nilai, 0)) FROM jual_transfer j
								LEFT JOIN master_jual_produk m2 on m2.jproduk_nobukti = j.jtransfer_ref
								WHERE m2.jproduk_tanggal = m.jproduk_tanggal
									AND j.jtransfer_transaksi = 'jual_produk'
									AND j.jtransfer_stat_dok = 'Tertutup'
									AND m2.jproduk_post <> 'Y'						
							)
							+
							(
								SELECT sum(ifnull(j.jcek_nilai, 0)) FROM jual_cek j
								LEFT JOIN master_jual_produk m2 on m2.jproduk_nobukti = j.jcek_ref
								WHERE m2.jproduk_tanggal = m.jproduk_tanggal
									AND j.jcek_transaksi = 'jual_produk'
									AND j.jcek_stat_dok = 'Tertutup'
									AND m2.jproduk_post <> 'Y'						
							), 0)
							as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'	
						GROUP BY m.jproduk_tanggal
							
						UNION
						
						/*KUITANSI*/
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							199, /*->Uang Muka Kuitansi*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 199) as akun_kode,
							'' as keterangan,
							sum(j.jkwitansi_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_kwitansi j
						RIGHT JOIN master_jual_produk m on m.jproduk_nobukti = j.jkwitansi_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jkwitansi_transaksi = 'jual_produk' OR j.jkwitansi_transaksi is null)
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal								
							
						UNION
							
						/*VOUCHER*/
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							243, /*->Potongan Voucher Penjualan Produk*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 243) as akun_kode,
							'' as keterangan,
							sum(m.jproduk_cashback) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal								
							
						UNION
						
						/*PIUTANG USAHA PRODUK*/						
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							54, /*Piutang Usaha Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 54) as akun_kode,
							'' as keterangan,
							sum(m.jproduk_totalbiaya - m.jproduk_bayar) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal
						
						UNION
						
						/*PENJUALAN PRODUK*/						
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							234, /*Penjualan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 234) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(m.jproduk_totalbiaya + m.jproduk_cashback) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal
						
						UNION
						
						/*HARGA POKOK PENJUALAN*/						
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							259, /*Harga Pokok Penjualan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 259) as akun_kode,
							'' as keterangan,
							sum(m.jproduk_totalbiaya + m.jproduk_cashback) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal
						
						UNION
						
						/*PERSEDIAAN*/						
						SELECT 
							m.jproduk_tanggal,
							concat
							(	
								min(m.jproduk_nobukti), ' - ', max(m.jproduk_nobukti) 
							) as no_ref,
							82, /*Persediaan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 82) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(m.jproduk_totalbiaya + m.jproduk_cashback) as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_produk m
						WHERE m.jproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jproduk_stat_dok = 'Tertutup'
							AND m.jproduk_post <> 'Y'
						GROUP BY m.jproduk_tanggal";
					
				$this->db->query($sql);
				
				
				// PENJUALAN PERAWATAN
				$sql = 
				   "INSERT INTO buku_besar_temp
						   (buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*TUNAI*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti) 
							) as no_ref,
							4, /*->Kas Kecil*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 4) as akun_kode,
							'' as keterangan,
							sum(j.jtunai_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_tunai j
						RIGHT JOIN master_jual_rawat m on m.jrawat_nobukti = j.jtunai_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jtunai_transaksi = 'jual_rawat' OR j.jtunai_transaksi is null)
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
							
						UNION
						
						/*KARTU KREDIT*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							57, /*->Piutang Card*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 57) as akun_kode,
							'' as keterangan,
							sum(j.jcard_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_card j
						RIGHT JOIN master_jual_rawat m on m.jrawat_nobukti = j.jcard_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jcard_transaksi = 'jual_rawat' OR j.jcard_transaksi is null)
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
							
						UNION
						
						/*TRANSFER, CEK GIRO*/
						SELECT
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							55, /*->Piutang Usaha Perawatan*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 53) as akun_kode,
							'' as keterangan,							
							ifnull((
								SELECT sum(j.jtransfer_nilai) FROM jual_transfer j
								LEFT JOIN master_jual_rawat m2 on m2.jrawat_nobukti = j.jtransfer_ref
								WHERE m2.jrawat_tanggal = m.jrawat_tanggal
									AND j.jtransfer_transaksi = 'jual_rawat'
									AND j.jtransfer_stat_dok = 'Tertutup'
									AND m2.jrawat_post <> 'Y'						
							), 0)
							+
							ifnull((
								SELECT sum(j.jcek_nilai) FROM jual_cek j
								LEFT JOIN master_jual_rawat m2 on m2.jrawat_nobukti = j.jcek_ref
								WHERE m2.jrawat_tanggal = m.jrawat_tanggal
									AND j.jcek_transaksi = 'jual_rawat'
									AND j.jcek_stat_dok = 'Tertutup'
									AND m2.jrawat_post <> 'Y'						
							), 0)
							as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_rawat m
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'	
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
							
						UNION
						
						/*KUITANSI*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							199, /*->Uang Muka Kuitansi*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 199) as akun_kode,
							'' as keterangan,
							sum(j.jkwitansi_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_kwitansi j
						RIGHT JOIN master_jual_rawat m on m.jrawat_nobukti = j.jkwitansi_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jkwitansi_transaksi = 'jual_rawat' OR j.jkwitansi_transaksi is null)
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal								
							
						UNION
							
						/*VOUCHER MEDIS*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							245, /*->Potongan Voucher Pendapatan Medis*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 245) as akun_kode,
							'' as keterangan,
							sum(m.jrawat_cashback_medis) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_rawat m
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal		
							
						UNION
						
						/*VOUCHER NON MEDIS*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							247, /*->Potongan Voucher Pendapatan Non Medis*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 247) as akun_kode,
							'' as keterangan,
							sum(m.jrawat_cashback) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_rawat m
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal		
							
						UNION
						
						/*PIUTANG USAHA PERAWATAN*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							55, /*Piutang Usaha Perawatan*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 55) as akun_kode,
							'' as keterangan,
							sum(m.jrawat_totalbiaya - m.jrawat_bayar) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_rawat m
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
						
						UNION
						
						/*PENDAPATAN MEDIS*/							
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							235, /*Pendapatan Medis*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 235) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(d.drawat_harga - d.drawat_harga * d.drawat_diskon / 100) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_jual_rawat d
						LEFT JOIN master_jual_rawat m on m.jrawat_id = d.drawat_master
						LEFT JOIN perawatan r on r.rawat_id = d.drawat_rawat
						LEFT JOIN kategori k on k.kategori_id = r.rawat_kategori
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND k.kategori_id = 2
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
						
						UNION
						
						/*PENDAPATAN NON MEDIS*/							
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							236, /*Pendapatan Non Medis*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 236) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(d.drawat_harga - d.drawat_harga * d.drawat_diskon / 100) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_jual_rawat d
						LEFT JOIN master_jual_rawat m on m.jrawat_id = d.drawat_master
						LEFT JOIN perawatan r on r.rawat_id = d.drawat_rawat
						LEFT JOIN kategori k on k.kategori_id = r.rawat_kategori
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND k.kategori_id = 3
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
						
						UNION
						
						/*PENDAPATAN ANTI AGING*/							
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							238, /*Pendapatan MAAC*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 238) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(d.drawat_harga - d.drawat_harga * d.drawat_diskon / 100) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_jual_rawat d
						LEFT JOIN master_jual_rawat m on m.jrawat_id = d.drawat_master
						LEFT JOIN perawatan r on r.rawat_id = d.drawat_rawat
						LEFT JOIN kategori k on k.kategori_id = r.rawat_kategori
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND k.kategori_id = 16
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
						
						UNION
						
						/*PENDAPATAN SURGERY*/							
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							237, /*Pendapatan Surgery*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 237) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(d.drawat_harga - d.drawat_harga * d.drawat_diskon / 100) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_jual_rawat d
						LEFT JOIN master_jual_rawat m on m.jrawat_id = d.drawat_master
						LEFT JOIN perawatan r on r.rawat_id = d.drawat_rawat
						LEFT JOIN kategori k on k.kategori_id = r.rawat_kategori
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND k.kategori_id = 4
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal
						
						UNION
						
						/*PENDAPATAN SENAM*/
						SELECT 
							m.jrawat_tanggal,
							concat
							(	
								min(m.jrawat_nobukti), ' - ', max(m.jrawat_nobukti)
							) as no_ref,
							239, /*Pendapatan Senam*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 239) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(d.drawat_harga - d.drawat_harga * d.drawat_diskon / 100) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_jual_rawat d
						LEFT JOIN master_jual_rawat m on m.jrawat_id = d.drawat_master
						LEFT JOIN perawatan r on r.rawat_id = d.drawat_rawat
						LEFT JOIN kategori k on k.kategori_id = r.rawat_kategori
						WHERE m.jrawat_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jrawat_stat_dok = 'Tertutup'
							AND k.kategori_id = 17
							AND m.jrawat_post <> 'Y'
						GROUP BY m.jrawat_tanggal";
					
				$this->db->query($sql);
				
				// PENJUALAN PAKET
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*TUNAI*/
						SELECT
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							4, /*->Kas Kecil*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 4) as akun_kode,
							'' as keterangan,
							sum(j.jtunai_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_tunai j
						RIGHT JOIN master_jual_paket m on m.jpaket_nobukti = j.jtunai_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jtunai_transaksi = 'jual_paket' OR j.jtunai_transaksi is null)
							AND m.jpaket_stat_dok = 'Tertutup'
							AND m.jpaket_post <> 'Y'
						GROUP BY m.jpaket_tanggal
							
						UNION
						
						/*KARTU KREDIT*/
						SELECT 
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							57, /*->Piutang Card*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 57) as akun_kode,
							'' as keterangan,
							sum(j.jcard_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_card j
						RIGHT JOIN master_jual_paket m on m.jpaket_nobukti = j.jcard_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jcard_transaksi = 'jual_paket' OR j.jcard_transaksi is null)
							AND m.jpaket_stat_dok = 'Tertutup'
							AND m.jpaket_post <> 'Y'
						GROUP BY m.jpaket_tanggal
							
						UNION
						
						/*TRANSFER, CEK GIRO*/
						SELECT 
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							55, /*->Piutang Usaha Perawatan*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 53) as akun_kode,
							'' as keterangan,							
							ifnull((
								SELECT sum(j.jtransfer_nilai) FROM jual_transfer j
								LEFT JOIN master_jual_paket m2 on m2.jpaket_nobukti = j.jtransfer_ref
								WHERE m2.jpaket_tanggal = m.jpaket_tanggal
									AND j.jtransfer_transaksi = 'jual_paket'
									AND j.jtransfer_stat_dok = 'Tertutup'
									AND m2.jpaket_post <> 'Y'						
							), 0)
							+
							ifnull((
								SELECT sum(j.jcek_nilai) FROM jual_cek j
								LEFT JOIN master_jual_paket m2 on m2.jpaket_nobukti = j.jcek_ref
								WHERE m2.jpaket_tanggal = m.jpaket_tanggal
									AND j.jcek_transaksi = 'jual_paket'
									AND j.jcek_stat_dok = 'Tertutup'
									AND m2.jpaket_post <> 'Y'						
							), 0)
							as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_paket m
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'												
							AND m.jpaket_post <> 'Y'
							
						UNION
						
						/*KUITANSI*/
						SELECT 
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							199, /*->Uang Muka Kuitansi*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 199) as akun_kode,
							'' as keterangan,
							sum(j.jkwitansi_nilai) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM jual_kwitansi j
						RIGHT JOIN master_jual_paket m on m.jpaket_nobukti = j.jkwitansi_ref /*dibuat RIGHT JOIN supaya concat no_buktinya bisa lengkap 1 hari*/
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND (j.jkwitansi_transaksi = 'jual_paket' OR j.jkwitansi_transaksi is null)
							AND m.jpaket_stat_dok = 'Tertutup'
							AND m.jpaket_post <> 'Y'
						GROUP BY m.jpaket_tanggal								
							
						UNION
							
						/*VOUCHER --> langsung mengurangi UANG MUKA PAKET*/
												
						/*PIUTANG USAHA PERAWATAN*/						
						SELECT 
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							55, /*Piutang Usaha Perawatan*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 55) as akun_kode,
							'' as keterangan,
							sum(m.jpaket_totalbiaya - m.jpaket_bayar) as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_paket m
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jpaket_stat_dok = 'Tertutup'
							AND m.jpaket_post <> 'Y'
						GROUP BY m.jpaket_tanggal
						
						UNION
						
						/*UANG MUKA PAKET*/
						SELECT 
							m.jpaket_tanggal,
							concat
							(	
								min(m.jpaket_nobukti), ' - ', max(m.jpaket_nobukti)
							) as no_ref,
							200, /*Uang Muka Paket*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 200) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(m.jpaket_totalbiaya) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_jual_paket m
						WHERE m.jpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.jpaket_stat_dok = 'Tertutup'
							AND m.jpaket_post <> 'Y'
						GROUP BY m.jpaket_tanggal";
					
				$this->db->query($sql);

				
				//PENGAMBILAN PAKET
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*PENDAPATAN MEDIS*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							235, /*Pendapatan Medis*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 235) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(v.total_harga_satuan) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.rawat_kategori = 2
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal
						
						UNION
						
						/*PENDAPATAN NON MEDIS*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							236, /*Pendapatan Non Medis*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 236) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(v.total_harga_satuan) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.rawat_kategori = 3
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal
						
						UNION
						
						/*PENDAPATAN ANTI AGING*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							238, /*Pendapatan Anti Aging*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 238) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(v.total_harga_satuan) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.rawat_kategori = 16
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal
						
						UNION
						
						/*PENDAPATAN SURGERY*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							237, /*Pendapatan Surgery*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 237) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(v.total_harga_satuan) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.rawat_kategori = 4
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal
						
						UNION
						
						/*PENDAPATAN SENAM*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							239, /*Pendapatan Senam*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 239) as akun_kode,
							'' as keterangan,
							0 as debet,
							sum(v.total_harga_satuan) as kredit,							
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.rawat_kategori = 17
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal
						
						UNION
						
						/*UANG MUKA PAKET*/
						SELECT 
							v.tanggal,
							'' as no_ref,
							200, /*Uang Muka Paket*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 200) as akun_kode,
							'' as keterangan,
							sum(v.total_harga_satuan) as debet,							
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_ambil_paket_rawat_simple v
						WHERE v.tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.dapaket_stat_dok = 'Tertutup'
							AND v.dapaket_post <> 'Y'
						GROUP BY v.tanggal";						
				
				$this->db->query($sql);
				
				
				// RETUR PENJUALAN PRODUK
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*PENJUALAN PRODUK*/						
						SELECT 
							m.rproduk_tanggal,
							concat
							(	
								min(m.rproduk_nobukti), ' - ', max(m.rproduk_nobukti)
							) as no_ref,
							234, /*Penjualan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 234) as akun_kode,
							'' as keterangan,
							k.kwitansi_nilai as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_retur_jual_produk m
						LEFT JOIN cetak_kwitansi k ON k.kwitansi_ref = m.rproduk_nobukti
						WHERE m.rproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.rproduk_stat_dok = 'Tertutup'
							AND m.rproduk_post <> 'Y'
						GROUP BY m.rproduk_tanggal
						
						UNION
						
						/*KUITANSI*/
						SELECT 
							m.rproduk_tanggal,
							concat
							(	
								min(m.rproduk_nobukti), ' - ', max(m.rproduk_nobukti)
							) as no_ref,
							199, /*->Uang Muka Kuitansi*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 199) as akun_kode,
							'' as keterangan,
							0 as debet,
							k.kwitansi_nilai as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_retur_jual_produk m
						LEFT JOIN cetak_kwitansi k ON k.kwitansi_ref = m.rproduk_nobukti
						WHERE m.rproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.rproduk_stat_dok = 'Tertutup'
							AND m.rproduk_post <> 'Y'
						GROUP BY m.rproduk_tanggal
						
						UNION
						
						/*PERSEDIAAN*/							
						SELECT 
							m.rproduk_tanggal,
							concat
							(	
								min(m.rproduk_nobukti), ' - ', max(m.rproduk_nobukti)
							) as no_ref,
							82, /*Persediaan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 82) as akun_kode,
							'' as keterangan,
							k.kwitansi_nilai as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_retur_jual_produk m
						LEFT JOIN cetak_kwitansi k ON k.kwitansi_ref = m.rproduk_nobukti
						WHERE m.rproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.rproduk_stat_dok = 'Tertutup'
							AND m.rproduk_post <> 'Y'
						GROUP BY m.rproduk_tanggal
						
						UNION
						
						/*HARGA POKOK PENJUALAN*/		
						SELECT 
							m.rproduk_tanggal,
							concat
							(	
								min(m.rproduk_nobukti), ' - ', max(m.rproduk_nobukti)
							) as no_ref,
							259, /*Harga Pokok Penjualan Produk*/	
							(SELECT akun_kode FROM akun	WHERE akun_id = 259) as akun_kode,
							'' as keterangan,
							0 as debet,
							k.kwitansi_nilai as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM master_retur_jual_produk m
						LEFT JOIN cetak_kwitansi k ON k.kwitansi_ref = m.rproduk_nobukti
						WHERE m.rproduk_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.rproduk_stat_dok = 'Tertutup'
							AND m.rproduk_post <> 'Y'
						GROUP BY m.rproduk_tanggal";

				$this->db->query($sql);
				
				
				// RETUR PENJUALAN PAKET
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
												
						/*UANG MUKA PAKET*/
						SELECT 
							v.rpaket_tanggal,
							concat
							(	
								min(v.rpaket_nobukti), ' - ', max(v.rpaket_nobukti)
							) as no_ref,
							200, /*Uang Muka Paket*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 200) as akun_kode,
							'' as keterangan,
							v.nilai_sisa_paket as debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_retur_paket_rawat v
						WHERE v.rpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.rpaket_stat_dok = 'Tertutup'
							AND v.rpaket_post <> 'Y'
						GROUP BY v.rpaket_tanggal
						
						UNION
						
						/*KUITANSI*/
						SELECT 
							v.rpaket_tanggal,
							concat
							(	
								min(v.rpaket_nobukti), ' - ', max(v.rpaket_nobukti)
							) as no_ref,
							199, /*Uang Muka Kuitansi*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 199) as akun_kode,
							'' as keterangan,
							0 as debet,
							v.drpaket_rupiah_retur as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_retur_paket_rawat v
						WHERE v.rpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.rpaket_stat_dok = 'Tertutup'
							AND v.rpaket_post <> 'Y'
						GROUP BY v.rpaket_tanggal
						
						UNION
						
						/*PENDAPATAN LAIN-LAIN*/
						SELECT 
							v.rpaket_tanggal,
							concat
							(	
								min(v.rpaket_nobukti), ' - ', max(v.rpaket_nobukti)
							) as no_ref,
							2060, /*Pendapatan Lain-lain*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 2060) as akun_kode,
							'' as keterangan,
							0 as debet,
							v.selisih_retur_sisa as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM vu_detail_retur_paket_rawat v
						WHERE v.rpaket_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."'
							AND v.rpaket_stat_dok = 'Tertutup'
							AND v.rpaket_post <> 'Y'
						GROUP BY v.rpaket_tanggal";

				$this->db->query($sql);
				
				
				//PENERIMAAN BARANG
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						
						/*PERSEDIAAN PRODUK (Gudang Retail)*/
						SELECT
							m.terima_tanggal,
							concat
							(
								min(m.terima_no), ' - ', max(m.terima_no)
							) as no_ref,
							82, /*Persediaan Produk*/							
							(SELECT akun_kode FROM akun	WHERE akun_id = 82) as akun_kode,
							'' as keterangan,							
							ifnull(((do.dorder_harga * d.dterima_jumlah) * (100 - do.dorder_diskon) / 100), 0) AS debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_terima_beli d
						LEFT JOIN master_terima_beli m ON m.terima_id = d.dterima_master
						LEFT JOIN master_order_beli mo ON m.terima_order = mo.order_id
						LEFT JOIN detail_order_beli do ON do.dorder_master = mo.order_id 
																AND do.dorder_produk = d.dterima_produk 
																AND do.dorder_satuan = d.dterima_satuan
						WHERE m.terima_tanggal BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.terima_gudang_id = 2						
							AND m.terima_status = 'Tertutup'
							AND m.terima_post <> 'Y'
						GROUP BY m.terima_tanggal
						
						UNION
						
						/*PERSEDIAAN KABIN (Gudang Besar & Kabin)*/
						SELECT
							m.terima_tanggal,
							concat
							(
								min(m.terima_no), ' - ', max(m.terima_no)
							) as no_ref,
							99, /*Persediaan Cabin*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 99) as akun_kode,
							'' as keterangan,							
							ifnull(((do.dorder_harga * d.dterima_jumlah) * (100 - do.dorder_diskon) / 100), 0) AS debet,
							0 as kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_terima_beli d
						LEFT JOIN master_terima_beli m ON m.terima_id = d.dterima_master
						LEFT JOIN master_order_beli mo ON m.terima_order = mo.order_id
						LEFT JOIN detail_order_beli do ON do.dorder_master = mo.order_id 
																AND do.dorder_produk = d.dterima_produk 
																AND do.dorder_satuan = d.dterima_satuan
						WHERE m.terima_tanggal BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.terima_gudang_id <> 2						
							AND m.terima_status = 'Tertutup'
							AND m.terima_post <> 'Y'
						GROUP BY m.terima_tanggal
						
						UNION
						
						/*HUTANG USAHA*/
						SELECT
							m.terima_tanggal,
							concat
							(
								min(m.terima_no), ' - ', max(m.terima_no)
							) as no_ref,
							169, /*Hutang Usaha*/
							(SELECT akun_kode FROM akun	WHERE akun_id = 169) as akun_kode,
							'' as keterangan,							
							0 as debet,
							ifnull(((do.dorder_harga * d.dterima_jumlah) * (100 - do.dorder_diskon) / 100), 0) AS kredit,
							'".@$_SESSION[SESSION_USERID]."'
						FROM detail_terima_beli d
						LEFT JOIN master_terima_beli m ON m.terima_id = d.dterima_master
						LEFT JOIN master_order_beli mo ON m.terima_order = mo.order_id
						LEFT JOIN detail_order_beli do ON do.dorder_master = mo.order_id 
																AND do.dorder_produk = d.dterima_produk 
																AND do.dorder_satuan = d.dterima_satuan
						WHERE m.terima_tanggal BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							AND m.terima_gudang_id <> 2						
							AND m.terima_status = 'Tertutup'
							AND m.terima_post <> 'Y'
						GROUP BY m.terima_tanggal";
				
				$this->db->query($sql);
				
								
				//DELETE HASIL POSTING YG D/K NYA 0
				$sql_del = "DELETE FROM buku_besar_temp 
							WHERE buku_debet = 0 AND buku_kredit = 0 
								AND ((buku_tanggal between '".$tgl_awal."' AND '".$tgl_akhir."') 
									OR buku_tanggal is null)";
				$this->db->query($sql_del);

				
				//PINDAHKAN DARI buku_besar_temp KE buku_besar
				$sql_move = "INSERT INTO buku_besar(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_arsip, buku_author, 
								buku_date_create, buku_update, buku_date_update, buku_revised)
							SELECT 
								buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_arsip, buku_author, 
								buku_date_create, buku_update, buku_date_update, buku_revised 
							FROM buku_besar_temp";
				$this->db->query($sql_move);
				
				//UPDATE STATUS POSTING
				$sql_post_umum		=  "UPDATE jurnal
										SET jurnal_post = 'Y', jurnal_date_post='".$tanggal."'
										WHERE date_format(jurnal_tanggal,'%Y-%m-%d')>='".$tgl_awal."'
											AND date_format(jurnal_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'
											AND jurnal_post<>'Y'";
				$this->db->query($sql_post_umum);

				$sql_post_bank		=  "UPDATE kasbank
										SET kasbank_post='Y', kasbank_date_post='".$tanggal."'
										WHERE date_format(kasbank_tanggal,'%Y-%m-%d')>='".$tgl_awal."'
											AND date_format(kasbank_tanggal,'%Y-%m-%d')<='".$tgl_akhir."'
											AND kasbank_post<>'Y'";
				$this->db->query($sql_post_bank);

				$sql_post_jproduk 	=  "UPDATE master_jual_produk
										SET jproduk_post = 'Y',	jproduk_date_post = '".$tanggal."'
										WHERE date_format(jproduk_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(jproduk_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND jproduk_post <> 'Y'";
				$this->db->query($sql_post_jproduk);
				
				$sql_post_jrawat 	=  "UPDATE master_jual_rawat
										SET jrawat_post = 'Y', jrawat_date_post = '".$tanggal."'
										WHERE date_format(jrawat_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(jrawat_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND jrawat_post <> 'Y'";
				$this->db->query($sql_post_jrawat);

				$sql_post_jpaket 	=  "UPDATE master_jual_paket
										SET jpaket_post = 'Y', jpaket_date_post = '".$tanggal."'
										WHERE date_format(jpaket_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(jpaket_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND jpaket_post <> 'Y'";
				$this->db->query($sql_post_jpaket);

				$sql_post_apaket 	=  "UPDATE detail_ambil_paket
										SET dapaket_post = 'Y', dapaket_date_post = '".$tanggal."'
										WHERE date_format(dapaket_tgl_ambil,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(dapaket_tgl_ambil,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND dapaket_post <> 'Y'";
				$this->db->query($sql_post_apaket);

				$sql_post_rproduk 	=  "UPDATE master_retur_jual_produk
										SET rproduk_post = 'Y',	rproduk_date_post = '".$tanggal."'
										WHERE date_format(rproduk_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(rproduk_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND rproduk_post <> 'Y'";
				$this->db->query($sql_post_rproduk);

				$sql_post_rpaket 	=  "UPDATE master_retur_jual_paket
										SET rpaket_post = 'Y', rpaket_date_post = '".$tanggal."'
										WHERE date_format(rpaket_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(rpaket_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND rpaket_post <> 'Y'";
				$this->db->query($sql_post_rpaket);
				
				$sql_post_terima 	=  "UPDATE master_terima_beli
										SET terima_post = 'Y', terima_date_post = '".$tanggal."'
										WHERE date_format(terima_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'
											AND date_format(terima_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'
											AND terima_post <> 'Y'";
				$this->db->query($sql_post_terima);

			}else if($periode=='bulan'){
			/*yg periode 'bulan' belum dikerjakan [2012-06-19]*/


				//POSTING KE BUKU BESAR
				
				$sql = 
				   "INSERT INTO buku_besar_temp
							(buku_tanggal, buku_ref, buku_akun, buku_akun_kode, buku_keterangan, buku_debet, buku_kredit, buku_author)
						SELECT 
							N.tanggal, N.no_jurnal, N.akun, N.akun_kode, N.keterangan, N.debet, N.kredit, '".@$_SESSION[SESSION_USERID]."'
						FROM (
							SELECT 
								concat('JU-',J.djurnal_id) as no_id,
								J.`jurnal_no` AS `no_jurnal`,
								date_format(J.`jurnal_tanggal`,'%Y-%m-%d') AS `tanggal`, 
								J.`djurnal_akun` AS `akun`,
								J.`akun_kode` AS `akun_kode`,
								J.`akun_nama` AS `akun_nama`,
								J.`djurnal_detail` AS `keterangan`,
								J.`djurnal_debet` AS `debet`,
								J.`djurnal_kredit` AS `kredit`
								J.`jurnal_post` AS `post`,
								J.`jurnal_date_post` AS `post_date`
							FROM `vu_jurnal` J
							WHERE (J.jurnal_post<>'Y' OR J.jurnal_post IS NULL)
								AND date_format(J.jurnal_tanggal,'%Y-%m')='".$tahun."-".$bulan."'";

					//JURNAL KASBANK
				   $sql.= " UNION 
							SELECT
								concat('JK-',K.kasbank_detid) as no_id,
								K.`no_jurnal` AS `no_jurnal`, 
								date_format(K.`tanggal`,'%Y-%m-%d') AS `tanggal`,
								K.`akun` AS `akun`,
								K.`akun_kode` AS `akun_kode`,
								K.`akun_nama` AS `akun_nama`,
								K.`keterangan` AS `keterangan`,
								K.`debet` AS `debet`,
								K.`kredit` AS `kredit`,
								K.`post` AS `post`,
								K.`post_date` AS `post_date`
							FROM `vu_jurnal_bank` K
							WHERE (K.post<>'Y' OR K.post is NULL)
								AND date_format(K.tanggal,'%Y-%m')='".$tahun."-".$bulan."'
							) 
							as N";
					
				$result=$this->db->query($sql);
				//$this->firephp->log($sql);

				//UPDATE STATUS POSTING
				$sql_post_umum="UPDATE 	jurnal
								SET 	jurnal_post='Y',
										jurnal_date_post='".$tanggal."'
								WHERE 	date_format(jurnal_tanggal,'%Y-%m')='".$tahun."-".$bulan."'
										AND jurnal_post<>'Y'";
				$this->db->query($sql_post_umum);
				//$this->firephp->log($sql);

				$sql_post_bank="UPDATE 	kasbank
								SET 	kasbank_post='Y',
										kasbank_date_post='".$tanggal."'
								WHERE 	date_format(kasbank_tanggal,'%Y-%m')='".$tahun."-".$bulan."'
										AND kasbank_post<>'Y'";
				$this->db->query($sql_post_bank);

			}

			return '1';
		}
}
?>