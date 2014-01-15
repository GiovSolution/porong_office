<? /* 
	+ Module  		: join_customer Model
	+ Description	: For record model process back-end
	+ Filename 		: c_join_customer.php
 	+ creator 		: Fred
	
*/

class M_join_customer extends Model{
		
		//constructor
		function M_join_customer() {
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
		
	function set_cust_point($cust_id){
		$sql = "SELECT cust_point from customer where cust_id='".$cust_id."' and cust_aktif!='Tidak Aktif' order by cust_id desc limit 1";
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
		
		

		//function for get list record
		function join_customer_list($filter,$start,$end){
		
			$query = "SELECT join_id, join_tanggal, c1.cust_nama as cust_nama_asal , c2.cust_nama as cust_nama_tujuan,  join_keterangan 
						FROM join_customer
						left join customer c1 on (c1.cust_id = join_customer.join_cust_asal)
						left join customer c2 on (c2.cust_id = join_customer.join_cust_tujuan)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bank_kode LIKE '%".addslashes($filter)."%' OR bank_nama LIKE '%".addslashes($filter)."%' OR bank_norek LIKE '%".addslashes($filter)."%' OR bank_atasnama LIKE '%".addslashes($filter)."%' )";
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
		
		
		//function for update record
		function join_customer_create($join_id, $cust_asal_id, $cust_tujuan_id, $cust_point, $join_tanggal, $join_keterangan, $join_creator, $join_date_create){
			
			$datetime_now=date('Y-m-d H:i:s');
		
		
			$data = array(
	
				"join_id"=>$join_id,	
				"join_cust_asal"=>$cust_asal_id,	
				"join_cust_tujuan"=>$cust_tujuan_id,
				"join_tanggal"=>$join_tanggal,
				"join_keterangan"=>$join_keterangan,
				"join_author"=>$_SESSION[SESSION_USERID],
				"join_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('join_customer', $data); 
			
			$sql_joincust_1 = "UPDATE appointment
				SET app_customer ='$cust_tujuan_id',
					app_update = '".@$_SESSION[SESSION_USERID]."',
					app_date_update = '".$datetime_now."',
					app_revised = (app_revised+1)
				WHERE app_customer='$cust_asal_id'";
			$this->db->query($sql_joincust_1);
			
			$sql_joincust_2 = "UPDATE cetak_kwitansi
				SET kwitansi_cust = '$cust_tujuan_id',
					kwitansi_update = '".@$_SESSION[SESSION_USERID]."',
					kwitansi_date_update = '".$datetime_now."',
					kwitansi_revised = (kwitansi_revised+1)
				WHERE kwitansi_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_2);
	
			$sql_joincust_3 = "UPDATE customer_note
				SET note_customer = '$cust_tujuan_id',
					note_update = '".@$_SESSION[SESSION_USERID]."',
					note_date_update = '".$datetime_now."',
					note_revised = (note_revised+1)
				WHERE note_customer='$cust_asal_id'";
			$this->db->query($sql_joincust_3);
			
			$sql_joincust_4 = "UPDATE detail_ambil_paket
				SET dapaket_cust = '$cust_tujuan_id',
					dapaket_update = '".@$_SESSION[SESSION_USERID]."',
					dapaket_date_update = '".$datetime_now."',
					dapaket_revised = (dapaket_revised+1)
				WHERE dapaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_4);
	
			$sql_joincust_5 = "UPDATE detail_pakai_cabin
				SET cabin_cust = '$cust_tujuan_id',
					cabin_update = '".@$_SESSION[SESSION_USERID]."',
					cabin_date_update = '".$datetime_now."',
					cabin_revised = (cabin_revised+1)
				WHERE cabin_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_5);
			
			$sql_joincust_6 = "UPDATE history_ambil_paket
				SET hapaket_cust = '$cust_tujuan_id',
					hapaket_update = '".@$_SESSION[SESSION_USERID]."',
					hapaket_date_update = '".$datetime_now."',
					hapaket_revised = (hapaket_revised+1)
				WHERE hapaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_6);
			
			$sql_joincust_7 = "UPDATE jual_kredit
				SET jkredit_cust = '$cust_tujuan_id',
					jkredit_update = '".@$_SESSION[SESSION_USERID]."',
					jkredit_date_update = '".$datetime_now."',
					jkredit_revised = (jkredit_revised+1)
				WHERE jkredit_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_7);
			
			$sql_joincust_8 = "UPDATE konsultansi
				SET konsul_cust = '$cust_tujuan_id',
					konsul_update = '".@$_SESSION[SESSION_USERID]."',
					konsul_date_update = '".$datetime_now."',
					konsul_revised = (konsul_revised+1)
				WHERE konsul_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_8);
			
			$sql_joincust_9 = "UPDATE master_ambil_paket
				SET apaket_cust = '$cust_tujuan_id',
					apaket_update = '".@$_SESSION[SESSION_USERID]."',
					apaket_date_update = '".$datetime_now."',
					apaket_revised = (apaket_revised+1)
				WHERE apaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_9);
			
			$sql_joincust_10 = "UPDATE master_jual_paket
				SET jpaket_cust = '$cust_tujuan_id',
					jpaket_update = '".@$_SESSION[SESSION_USERID]."',
					jpaket_date_update = '".$datetime_now."',
					jpaket_revised = (jpaket_revised+1)
				WHERE jpaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_10);
			
			$sql_joincust_11 = "UPDATE master_jual_produk
				SET jproduk_cust = '$cust_tujuan_id',
					jproduk_update = '".@$_SESSION[SESSION_USERID]."',
					jproduk_date_update = '".$datetime_now."',
					jproduk_revised = (jproduk_revised+1)
				WHERE jproduk_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_11);
			
			$sql_joincust_12 = "UPDATE master_jual_rawat
				SET jrawat_cust = '$cust_tujuan_id',
					jrawat_update = '".@$_SESSION[SESSION_USERID]."',
					jrawat_date_update = '".$datetime_now."',
					jrawat_revised = (jrawat_revised+1)
				WHERE jrawat_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_12);
			
			$sql_joincust_13 = "UPDATE master_lunas_piutang
				SET lpiutang_cust = '$cust_tujuan_id',
					lpiutang_update = '".@$_SESSION[SESSION_USERID]."',
					lpiutang_date_update = '".$datetime_now."',
					lpiutang_revised = (lpiutang_revised+1)
				WHERE lpiutang_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_13);
			
			$sql_joincust_14 = "UPDATE master_retur_jual_paket
				SET rpaket_cust = '$cust_tujuan_id',
					rpaket_update = '".@$_SESSION[SESSION_USERID]."',
					rpaket_date_update = '".$datetime_now."',
					rpaket_revised = (rpaket_revised+1)
				WHERE rpaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_14);
			
			$sql_joincust_15 = "UPDATE master_retur_jual_produk
				SET rproduk_cust = '$cust_tujuan_id',
					rproduk_update = '".@$_SESSION[SESSION_USERID]."',
					rproduk_date_update = '".$datetime_now."',
					rproduk_revised = (rproduk_revised+1)
				WHERE rproduk_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_15);
			
			$sql_joincust_16 = "UPDATE master_tukar_voucher
				SET avoucher_cust = '$cust_tujuan_id'
				WHERE avoucher_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_16);
			
			//update member tidak perlu, karena pemindahan member harus dilakukan secara manual
			/* 
			$sql_joincust_17 = "UPDATE member
				SET member_cust = '$cust_tujuan_id',
					member_update = '".@$_SESSION[SESSION_USERID]."',
					member_date_update = '".$datetime_now."',
					member_revised = (member_revised+1)
				WHERE member_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_17);
			*/
			
			$sql_joincust_18 = "UPDATE member_temp
				SET membert_cust = '$cust_tujuan_id'
				WHERE membert_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_18);
			
			$sql_joincust_19 = "UPDATE outbox
				SET outbox_cust = '$cust_tujuan_id',
					outbox_update = '".@$_SESSION[SESSION_USERID]."',
					outbox_date_update = '".$datetime_now."',
					outbox_revised = (outbox_revised+1)
				WHERE outbox_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_19);
			
			$sql_joincust_20 = "UPDATE pengguna_paket
				SET ppaket_cust = '$cust_tujuan_id',
					ppaket_update = '".@$_SESSION[SESSION_USERID]."',
					ppaket_date_update = '".$datetime_now."',
					ppaket_revised = (ppaket_revised+1)
				WHERE ppaket_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_20);
					
			$sql_joincust_22 = "UPDATE rekomendasi_card
				SET card_cust = '$cust_tujuan_id',
					card_update = '".@$_SESSION[SESSION_USERID]."',
					card_date_update = '".$datetime_now."',
					card_revised = (card_revised+1)
				WHERE card_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_22);
			
			$sql_joincust_23 = "UPDATE resep_dokter
				SET resep_custid = '$cust_tujuan_id',
					resep_update = '".@$_SESSION[SESSION_USERID]."',
					resep_date_update = '".$datetime_now."',
					resep_revised = (resep_revised+1)
				WHERE resep_custid ='$cust_asal_id'";
			$this->db->query($sql_joincust_23);
			
			$sql_joincust_24 = "UPDATE tindakan
				SET trawat_cust = '$cust_tujuan_id',
					trawat_update = '".@$_SESSION[SESSION_USERID]."',
					trawat_date_update = '".$datetime_now."',
					trawat_revised = (trawat_revised+1)
				WHERE trawat_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_24);
			
			$sql_joincust_25 = "UPDATE tukar_point
				SET epoint_cust = '$cust_tujuan_id',
					epoint_update = '".@$_SESSION[SESSION_USERID]."',
					epoint_date_update = '".$datetime_now."',
					epoint_revised = (epoint_revised+1)
				WHERE epoint_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_25);
			
			$sql_joincust_26 = "UPDATE voucher_kupon
				SET kvoucher_cust = '$cust_tujuan_id',
					kvoucher_update = '".@$_SESSION[SESSION_USERID]."',
					kvoucher_date_update = '".$datetime_now."',
					kvoucher_revised = (kvoucher_revised+1)
				WHERE kvoucher_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_26);
			
			$sql_joincust_27 = "UPDATE voucher_terima
				SET tvoucher_cust = '$cust_tujuan_id',
					tvoucher_update = '".@$_SESSION[SESSION_USERID]."',
					tvoucher_date_update = '".$datetime_now."',
					tvoucher_revised = (tvoucher_revised+1)
				WHERE tvoucher_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_27);
			
			$sql_joincust_28 = "UPDATE waiting_list
				SET cust_id = '$cust_tujuan_id',
					wl_update = '".@$_SESSION[SESSION_USERID]."',
					wl_date_update = '".$datetime_now."',
					wl_revised = (wl_revised+1)
				WHERE cust_id ='$cust_asal_id'";
			$this->db->query($sql_joincust_28);
			
			$sql_joincust_29 = "UPDATE customer
				SET cust_point = (cust_point + '$cust_point')
				WHERE cust_id ='$cust_tujuan_id'";
			$this->db->query($sql_joincust_29);
			
			$sql_joincust_30 = "UPDATE log_poin_reset 
				SET log_cust = '$cust_tujuan_id'
				WHERE log_cust ='$cust_asal_id'";
			$this->db->query($sql_joincust_30);
			
			$sql_set_cust_tidak_aktif = "UPDATE customer
				SET cust_aktif = 'Tidak Aktif',
					cust_update = '".@$_SESSION[SESSION_USERID]."',
					cust_date_update = '".$datetime_now."',
					cust_revised = (cust_revised+1),
					cust_keterangan = CONCAT(cust_keterangan,'Telah digabungkan ke cust_id '  '".$cust_tujuan_id."')
				WHERE cust_id ='$cust_asal_id'";
			$this->db->query($sql_set_cust_tidak_aktif);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
			
			
			//return '1';
		}
		
		
}
?>