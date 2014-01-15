<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: tutup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_tutup.php
 	+ creator 		: 
 	+ Created on 12/Mar/2010 10:42:59
	
*/

class M_tutup extends Model{
		
		//constructor
		function M_tutup() {
			parent::Model();
		}
		
		function tutup_transaksi(){
			
			/*$sql="SELECT if(akun_saldo = 'Debet',
				  sum(buku_debet) - sum(buku_kredit),
				  sum(buku_kredit) - sum(buku_debet))
				  AS saldo_akhir,
				  akun_id, akun_kode,akun_nama
			  FROM vu_buku_besar
				  GROUP BY akun_id,akun_kode,akun_nama";
				
			foreach($result->result() as $row){
				$updatesql="UPDATE akun SET akun_debet=akun_debet+".$row->saldo_akhir."
							WHERE akun_saldo='Debet' AND akun_id='".$row->akun_id."'";
				$this->db->query($updatesql);
				//$this->firephp->log($updatesql);
				
				$updatesql="UPDATE akun SET akun_kredit=akun_kredit+".$row->saldo_akhir."
							WHERE akun_saldo='Kredit' AND akun_id='".$row->akun_id."'";
				$this->db->query($updatesql);
			}
			*/
			

		//Hapus semua saldo awal di periode berikutnya.
			$sql_del_sa =  "DELETE FROM akun_sa 
							WHERE sa_periode_awal = (select date_add(setup_periode_akhir, interval 1 day) from akun_setup limit 1)";
			$this->db->query($sql_del_sa);
			

		//1. utk NERACA:
			$sql = "
						(
						SELECT
							if (a.akun_saldo = 'debet', a.akun_debet - a.akun_kredit + (sum(ifnull(buku_debet, 0)) - sum(ifnull(buku_kredit, 0))), 0) as saldo_akhir_debet, 
							if (a.akun_saldo = 'kredit', a.akun_kredit - a.akun_debet + (sum(ifnull(buku_kredit, 0)) - sum(ifnull(buku_debet, 0))), 0) as saldo_akhir_kredit,
							akun_id
						FROM buku_besar b
						left join akun a on a.akun_id = b.buku_akun
						where 
							b.buku_tanggal >= (select s.setup_periode_awal from akun_setup s limit 1) and
							b.buku_tanggal <= (select s.setup_periode_akhir from akun_setup s limit 1) and
							a.akun_jenis = 'BS'
						GROUP BY akun_id
						)
						
						union
						
						(
						select
							if (a.akun_saldo = 'debet', ifnull(a.akun_debet, 0) - ifnull(a.akun_kredit, 0), 0) as saldo_akhir_debet,
							if (a.akun_saldo = 'kredit', ifnull(a.akun_kredit, 0) - ifnull(a.akun_debet, 0), 0) as saldo_akhir_kredit,
							akun_id
						from akun a
						where 
							a.akun_jenis = 'BS' and
							(a.akun_debet <> 0 or a.akun_kredit <> 0) and
							a.akun_id not in
							(
							SELECT
								akun_id
							FROM buku_besar v
							left join akun a on a.akun_id = v.buku_akun
							where 
								v.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
								v.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) and
								a.akun_jenis = 'BS'
							GROUP BY akun_id
							)
						)";
			$result=$this->db->query($sql);
					
			//insertkan saldo awal utk periode yg baru
			foreach($result->result() as $row){
				$sql_ins_sa =  "INSERT akun_sa(sa_master, sa_debet, sa_kredit, sa_periode_awal)
								VALUES (".$row->akun_id.", ".$row->saldo_akhir_debet.", ".$row->saldo_akhir_kredit.", 
									(select date_add(setup_periode_akhir, interval 1 day) from akun_setup limit 1))";
				$this->db->query($sql_ins_sa);
			}
			
					
		//2. untuk LABA RUGI
			$sql = "select
						sum(saldo_akhir_kredit) - sum(saldo_akhir_debet) as total_laba
					FROM
					(	
						(
						SELECT
							if (a.akun_saldo = 'debet', a.akun_debet - a.akun_kredit + (sum(ifnull(buku_debet, 0)) - sum(ifnull(buku_kredit, 0))), 0) as saldo_akhir_debet, 
							if (a.akun_saldo = 'kredit', a.akun_kredit - a.akun_debet + (sum(ifnull(buku_kredit, 0)) - sum(ifnull(buku_debet, 0))), 0) as saldo_akhir_kredit,
							akun_id
						FROM buku_besar b
						left join akun a on a.akun_id = b.buku_akun
						where 
							b.buku_tanggal >= (select s.setup_periode_awal from akun_setup s limit 1) and
							b.buku_tanggal <= (select s.setup_periode_akhir from akun_setup s limit 1) and
							a.akun_jenis = 'R/L'
						GROUP BY akun_id
						)

						union

						(
						select
							if (a.akun_saldo = 'debet', ifnull(a.akun_debet, 0) - ifnull(a.akun_kredit, 0), 0) as saldo_akhir_debet,
							if (a.akun_saldo = 'kredit', ifnull(a.akun_kredit, 0) - ifnull(a.akun_debet, 0), 0) as saldo_akhir_kredit,
							akun_id
						from akun a
						where 
							a.akun_jenis = 'R/L' and
							(a.akun_debet <> 0 or a.akun_kredit <> 0) and
							a.akun_id not in
							(
							SELECT
								akun_id
							FROM buku_besar v
							left join akun a on a.akun_id = v.buku_akun
							where 
								v.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
								v.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) and
								a.akun_jenis = 'R/L'
							GROUP BY akun_id
							)
						) 
					) as tabel";
			
			$result			= $this->db->query($sql);
			$data_result	= $result->row();
			
			//update Laba Ditahan
			$sql_update =  "UPDATE akun_sa
							SET sa_kredit = sa_kredit + ".$data_result->total_laba."
							WHERE 
								sa_periode_awal = (select date_add(setup_periode_akhir, interval 1 day) from akun_setup limit 1) and
								sa_master = 228";
			$this->db->query($sql_update);
							
			//insertkan saldo awal = 0 utk periode yg baru
			foreach($result->result() as $row){
				$sql_ins_sa =  "INSERT akun_sa(sa_master, sa_debet, sa_kredit, sa_periode_awal)
								SELECT akun_id, 0, 0, (select date_add(setup_periode_akhir, interval 1 day) from akun_setup limit 1)
								FROM akun
								WHERE akun_jenis = 'R/L'";								
				$this->db->query($sql_ins_sa);
			}

			
			//ARSIPKAN
			$sql = "UPDATE buku_besar 
					SET buku_arsip = 'Y'
					WHERE
						buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
						buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) ";
			$this->db->query($sql);
			
			$sql = "UPDATE kasbank 
					SET kasbank_arsip = 'Y'
					WHERE
						kasbank_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
						kasbank_tanggal <= (select setup_periode_akhir from akun_setup limit 1) ";
			$this->db->query($sql);
			
			$sql = "UPDATE jurnal 
					SET jurnal_arsip = 'Y'
					WHERE
						jurnal_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
						jurnal_tanggal <= (select setup_periode_akhir from akun_setup limit 1) ";
			$this->db->query($sql);
			

			//ubah akun_setup menjadi periode tahun berikutnya
			$sql_periode = "UPDATE akun_setup s
							SET 
								s.setup_periode_awal = date_add(s.setup_periode_akhir, interval 1 day),
								s.setup_periode_akhir = date_add(s.setup_periode_akhir, interval 1 year),
								s.setup_periode_tahun = s.setup_periode_tahun + 1";
			$this->db->query($sql_periode);

			return '1';
		}
}
?>