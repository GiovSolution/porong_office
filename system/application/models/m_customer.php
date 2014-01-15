<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: customer Model
	+ Description	: For record model process back-end
	+ Filename 		: c_customer.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 17:02:19
	
*/

class M_customer extends Model{
		
		//constructor
		function M_customer() {
			parent::Model();
		}
		
		function get_profesi_list($query){
			$sql="SELECT distinct(cust_profesi) FROM customer WHERE (cust_profesi!=null OR cust_profesi!='')";
			if($query<>""){
				$sql=$sql." AND (cust_profesi like '%".$query."%') ";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$result = $this->db->query($sql);  
			
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
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(cust_id) as master_id from customer";
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
		
		function get_cabang_list(){
		$sql="SELECT cabang_id,cabang_nama
				FROM cabang 
				LEFT JOIN info on (info.info_cabang = cabang.cabang_id)
				where cabang.cabang_id = info.info_cabang";
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
		
		//purge all detail from master
		function cust_note_purge($master_id){
			$sql="DELETE from customer_note where note_customer='".$master_id."'";
			$result=$this->db->query($sql);
			return $result;
		}
		//*eof
		
		//insert detail record
		function cust_note_insert($note_cust, $note_detail){
			//if master id not capture from view then capture it from max pk from master table
			if($note_cust=="" || $note_cust==NULL){
				$note_cust=$this->get_master_id();
			}
			
			$data = array(
				"note_customer"=>$note_cust, 
				"note_tanggal"=>date('Y-m-d'), 
				"note_detail"=>$note_detail
			);
			$this->db->insert('customer_note', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';

		}
		//end of function
		
		
		function get_cust_member($cust_id,$start,$end){
			$sql = "SELECT member.* FROM customer,member where member_cust=cust_id and cust_id='".$cust_id."'";
			
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
		
		function get_cust_note($cust_id,$start,$end){
			$sql = "SELECT customer_note.* FROM customer,customer_note where note_customer=cust_id and cust_id='".$cust_id."' and note_aktif='Aktif'";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;		
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
		
		function get_hobi_list($query){
			$sql="SELECT distinct(cust_hobi) FROM customer WHERE (cust_hobi!=null OR cust_hobi!='')";
			if($query<>""){
				$sql=$sql." AND (cust_hobi LIKE '%".$query."%') ";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$result = $this->db->query($sql);  
			
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
		
				
		function get_reflain_list(){
			$sql="select distinct(cust_referensilain) from customer where cust_referensilain!=null or cust_referensilain!=''";
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$result = $this->db->query($sql);  
			
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
		function customer_list($filter,$start,$end){
			$query =   "SELECT 
							v.*
						FROM vu_customer v
						WHERE cust_aktif = 'Aktif' ";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_alamat LIKE '%".addslashes($filter)."%' OR cust_alamat2 LIKE '%".addslashes($filter)."%' OR cust_telprumah LIKE '%".addslashes($filter)."%' OR cust_telprumah2 LIKE '%".addslashes($filter)."%' OR cust_telpkantor LIKE '%".addslashes($filter)."%' OR cust_hp LIKE '%".addslashes($filter)."%' OR cust_hp2 LIKE '%".addslashes($filter)."%' OR cust_hp3 LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%' OR member_no LIKE '%".addslashes($filter)."%' )";
				$query .= " AND cust_aktif = 'Aktif'"; // by hendri, simple search khusus aktif only
			}
			
			$query .= " order by cust_id desc ";
			
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

		//function for get list record
		function phonegroup_list($query,$start,$end){
			$sql = "SELECT * FROM phonegroup where phonegroup_aktif = 'Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" (phonegroup_nama like '%".$query."%' ) ";
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
		
			//function for create new record
		function customer_phonegroup_create($query,$phonegroup_nama ,$phonegroup_id,/*$phonegroup_data ,*/$cust_id ,$cust_no, $cust_no_awal ,$cust_no_akhir ,$cust_nama, $cust_panggilan, $cust_foreigner ,$cust_kelamin ,$cust_alamat ,$cust_alamat2 ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir ,$cust_tgllahirend,$cust_referensi ,$cust_keterangan ,$cust_member ,$cust_member2, $cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif, $sortby,$cust_fretfulness,$cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$option,$filter, $cust_umurstart, $cust_umurend, $cust_umur, $cust_bb,$cust_tgldaftarend, $cust_tglawaltransend,$cust_referensilain,$hapus_cust, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $member_terdaftarstart, $member_terdaftarend,$cust_tgl, $cust_bulan,$cust_tglEnd, $cust_bulanEnd){
			
			if($hapus_cust == 1){
				$query_delete = "DELETE FROM phonegrouped WHERE phonegrouped_group = '$phonegroup_id'";
				$this->db->query($query_delete);
			}
			
			//return '({"total":"'.$query.'","results":'.$filter.'})';
			$query="select cust_id from vu_customer";

			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_alamat LIKE '%".addslashes($filter)."%' OR cust_alamat2 LIKE '%".addslashes($filter)."%' OR cust_telprumah LIKE '%".addslashes($filter)."%' OR cust_telprumah2 LIKE '%".addslashes($filter)."%' OR cust_telpkantor LIKE '%".addslashes($filter)."%' OR cust_hp LIKE '%".addslashes($filter)."%' OR cust_hp2 LIKE '%".addslashes($filter)."%' OR cust_hp3 LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%' )";
				$query .= " AND cust_aktif = 'Aktif'";
			} 
			else if($option=='SEARCH'){
				/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($cust_transaksi_start!='' and $cust_transaksi_end!='')
			{
			$sql = "SELECT distinct(cust_id)
					FROM
					((((
						SELECT distinct(jrawat_cust) as cust_id,
						'rawat' as status
						FROM master_jual_rawat
						WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$cust_transaksi_start."' and '".$cust_transaksi_end."') order by cust_id
					)
					union
					(
						SELECT distinct(jpaket_cust) as cust_id,
						'paket' as status
						FROM master_jual_paket
						WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$cust_transaksi_start."' and '".$cust_transaksi_end."')
					)
					union
					(
						SELECT distinct(jproduk_cust) as cust_id,
						'produk' as status
						FROM master_jual_produk
						WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$cust_transaksi_start."' and '".$cust_transaksi_end."')
					)
					union
					(
						SELECT distinct(dapaket_cust) as cust_id,
						'ambil_paket' as status
						FROM detail_ambil_paket
						WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$cust_transaksi_start."' and '".$cust_transaksi_end."')
					)
					union
					(
						select distinct
						history_transaksi.thistory_cust as cust_id,
						'prog_lama' AS referal
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust
						WHERE history_transaksi.thistory_tanggal BETWEEN '".$cust_transaksi_start."' AND '".$cust_transaksi_end."' AND
						cust_id IS NOT NULL
					)
					)))
					as table_union
					order by cust_id";
			$result_sql = $this->db->query($sql);
			$string = '0';
			foreach($result_sql->result() as $row){
				$string_cust=$row->cust_id;
				$string = $string.','.$string_cust;
			}
			}
			
			if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!='')
			{
			$sql = "SELECT distinct(cust_id)
					FROM
					((((
						SELECT distinct(jrawat_cust) as cust_id,
						'rawat' as status
						FROM master_jual_rawat
						WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."') order by cust_id
					)
					union
					(
						SELECT distinct(jpaket_cust) as cust_id,
						'paket' as status
						FROM master_jual_paket
						WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."')
					)
					union
					(
						SELECT distinct(jproduk_cust) as cust_id,
						'produk' as status
						FROM master_jual_produk
						WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."')
					)
					union
					(
						SELECT distinct(dapaket_cust) as cust_id,
						'ambil_paket' as status
						FROM detail_ambil_paket
						WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."')
					)
					union
					(
						select distinct
						history_transaksi.thistory_cust as cust_id,
						'prog_lama' AS referal
						from history_transaksi
						left join customer on customer.cust_id = history_transaksi.thistory_cust
						WHERE history_transaksi.thistory_tanggal BETWEEN '".$cust_tidak_transaksi_start."' AND '".$cust_tidak_transaksi_end."' AND
						cust_id IS NOT NULL
					)
					)))
					as table_union
					order by cust_id";
			$result_sql = $this->db->query($sql);
			$string_not = '0';
			foreach($result_sql->result() as $row){
				$string_cust=$row->cust_id;
				$string_not = $string_not.','.$string_cust;
			}
			}
					if($cust_id!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_id LIKE '%".$cust_id."%'";
					};
					if($cust_no!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_no LIKE '%".$cust_no."%'";
					};
					if($cust_no_awal!=''){
							$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
							$query.= " right(cust_no,6) BETWEEN '".$cust_no_awal."' AND '".$cust_no_akhir."'";
						};
					if($cust_nama!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_nama LIKE '%".$cust_nama."%'";
					};
					if($cust_panggilan!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_panggilan LIKE '%".$cust_panggilan."%'";
					};
					if($cust_foreigner!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_foreigner LIKE '%".$cust_foreigner."%'";
					};
					if($cust_kelamin!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_kelamin LIKE '%".$cust_kelamin."%'";
					};
					if($cust_alamat!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_alamat LIKE '%".$cust_alamat."%' OR cust_alamat2 LIKE '%".$cust_alamat."%'";
					};
					if($cust_kota!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_kota LIKE '%".$cust_kota."%'";
					};
					if($cust_kodepos!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_kodepos LIKE '%".$cust_kodepos."%'";
					};
					if($cust_propinsi!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_propinsi LIKE '%".$cust_propinsi."%'";
					};
					if($cust_negara!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_negara LIKE '%".$cust_negara."%'";
					};
					if($cust_telprumah!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_telprumah LIKE '%".$cust_telprumah."%' OR cust_telprumah2 LIKE '%".$cust_telprumah."%' OR cust_telpkantor LIKE '%".$cust_telprumah."%' ";
					};
					if($cust_bb!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_bb LIKE '%".$cust_bb."%'";
					};
					if($cust_email!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_email LIKE '%".$cust_email."%'  OR cust_email2 LIKE '%".$cust_email."%'   ";
					};
					if($cust_agama!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_agama LIKE '%".$cust_agama."%'";
					};
					if($cust_pendidikan!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_pendidikan LIKE '%".$cust_pendidikan."%'";
					};
					if($cust_profesi!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_profesi LIKE '%".$cust_profesi."%'";
					};
					
					/*if($cust_tgllahir!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
					};	*/
					
					if($cust_tgllahir!='' or $cust_tgllahirend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						
						if($cust_tgllahir!='' and $cust_tgllahirend!=''){
							$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
						}else if ($cust_tgllahir!='' and $cust_tgllahirend==''){
							$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND now()";
						}else if ($cust_tgllahir=='' and $cust_tgllahirend!=''){
							$query.= " cust_tgllahir < '".$cust_tgllahirend."'";
						}
					};
					
					/*search berdasarkan tgl dan bulan lahir */			
					if($cust_tgl!='' and $cust_bulan!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						if ($cust_tglEnd!='' and $cust_bulanEnd!=''){
							$query.= " (day(cust_tgllahir) BETWEEN '".$cust_tgl."' AND '".$cust_tglEnd."') AND (month(cust_tgllahir) BETWEEN '".$cust_bulan."' AND '".$cust_bulanEnd."') ";
						}else{
							$query.= " day(cust_tgllahir)='".$cust_tgl."' AND month(cust_tgllahir)='".$cust_bulan."' ";
						}
					}else if($cust_tgl=='' and $cust_bulan!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " month(cust_tgllahir)='".$cust_bulan."'";
					};	
					
					if($cust_umurstart!='' or $cust_umurend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						
						if($cust_umurstart!='' and $cust_umurend!=''){
							$query.= " (year(now())-year(cust_tgllahir)) BETWEEN '".$cust_umurstart."' AND '".$cust_umurend."'";
						}else if ($cust_umurstart!='' and $cust_umurend==''){
							$query.= " (year(now())-year(cust_tgllahir)) > '".$cust_umurstart."'";
						}else if ($cust_umurstart=='' and $cust_umurend!=''){
							$query.= " (year(now())-year(cust_tgllahir)) < '".$cust_umurend."'";
						}
					};	
					
					if($cust_referensi!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_referensi LIKE '%".$cust_referensi."%'";
					};
					if($cust_referensilain!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_referensilain LIKE '%".$cust_referensilain."%'";
					};
					if($cust_keterangan!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_keterangan LIKE '%".$cust_keterangan."%'";
					};
					if($cust_member!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member LIKE '%".$cust_member."%'";
					};
					if($cust_member2!=''){
						$date_now = date('Y-m-d');
						if($cust_member2=='Semua'){
							$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
							$query.= " cust_member <> ''";
						} 
						else if($cust_member2=='Aktif'){
							$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
							$query.= " member_valid > '".$date_now."'";
						}
						else if($cust_member2=='Tidak Aktif'){
							$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
							$query.= " member_valid < '".$date_now."'";
						}
						else if($cust_member2=='Non Member'){
							$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
							$query.= " cust_member = ''";
						}				
					};
					/*if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";						
					};*/
					
					if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						
						if($cust_terdaftar!='' and $cust_tgldaftarend!=''){
							$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";
						}else if ($cust_terdaftar!='' and $cust_tgldaftarend==''){
							$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND now()";
						}else if ($cust_terdaftar=='' and $cust_tgldaftarend!=''){
							$query.= " cust_terdaftar < '".$cust_tgldaftarend."'";
						}
					};
					
					/*utk Search Member Register */
					if($member_terdaftarstart!='' or $member_terdaftarend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				
						if($member_terdaftarstart!='' and $member_terdaftarend!=''){
							$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND '".$member_terdaftarend."'";
						}else if ($member_terdaftarstart!='' and $member_terdaftarend==''){
							$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND now()";
						}else if ($member_terdaftarstart=='' and $member_terdaftarend!=''){
							$query.= " member_register < '".$member_terdaftarend."'";
						}
					};
					
					
					if($cust_tglawaltrans!='' or $cust_tglawaltransend!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						
						if($cust_tglawaltrans!='' and $cust_tglawaltransend!=''){
							$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND '".$cust_tglawaltransend."'";
						}else if ($cust_tglawaltrans!='' and $cust_tglawaltransend==''){
							$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND now()";
						}else if ($cust_tglawaltrans=='' and $cust_tglawaltransend!=''){
							$query.= " cust_tglawaltrans < '".$cust_tglawaltransend."'";
						}
						
					};
								
					if($cust_statusnikah!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_statusnikah='".$cust_statusnikah."'";
					};
					if($cust_priority!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_priority='".$cust_priority."'";
					};
					if($cust_jmlanak!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_jmlanak LIKE '%".$cust_jmlanak."%'";
					};
					if($cust_unit!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_unit LIKE '%".$cust_unit."%'";
					};
					if($cust_aktif!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_aktif = '".$cust_aktif."'";
					};
					/*if($cust_fretfulness!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_fretfulness LIKE '%".$cust_fretfulness."%'";
					};*/
					if($sortby=='Nama'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_nama";
					};
					if($sortby=='No Cust'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_no";
					};
					if($sortby=='Alamat'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_alamat";
					};
					if($sortby=='Tgl Lahir'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_tgllahir";
					};
					if($sortby=='Telp Rmh'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_telprumah";
					};
					if($sortby=='Handphone'){
						$query.=eregi("WHERE",$query)?" ":" WHERE ";
						$query.= " ORDER BY cust_hp";
					};
					if($cust_creator!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_creator LIKE '%".$cust_creator."%'";
					};
					if($cust_date_create!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_date_create LIKE '%".$cust_date_create."%'";
					};
					if($cust_update!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_update LIKE '%".$cust_update."%'";
					};
					if($cust_date_update!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_date_update LIKE '%".$cust_date_update."%'";
					};
					if($cust_revised!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_revised LIKE '%".$cust_revised."%'";
					};
					
					if($cust_transaksi_start!='' and $cust_transaksi_end!='')
					{
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_id IN($string)";
					}
					if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!='')
					{
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_id NOT IN($string_not)";
					}
					
					$query.= " order by cust_id desc ";
				}
			
				$rs = $this->db->query($query);
				//$datetime_now = date('Y-m-d H:i:s');
				
				$ret = 0;
				$jum_baris = $rs->num_rows();
				
				for ($i = 0; $i < $jum_baris; $i++) {
						$record = $rs->row($i);
						$data_arr= $record->cust_id;				
						
						$data=array(
							"phonegrouped_group"	=> $phonegroup_id,
							"phonegrouped_cust"		=> $data_arr
						);
						
						
						$query2 = "SELECT phonegrouped_cust FROM phonegrouped WHERE phonegrouped_group = '".$phonegroup_id."' AND phonegrouped_cust='".$data_arr."'";
						
						$result2=$this->db->query($query2);
						$jum_baris2 = $result2->num_rows();
						if ($jum_baris2 <= 0){
							$this->db->insert('phonegrouped',$data);
							$ret = 1;
						}
				}
			if ($ret == 1)
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function customer_update($cust_id, $cust_no ,$cust_nolama ,$cust_nama, $cust_title, $cust_panggilan , $cust_foreigner, $cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara,$cust_alamat2 ,$cust_kota2 ,$cust_kodepos2 ,$cust_propinsi2 ,$cust_negara2 ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_fb ,$cust_tweeter , $cust_email2 ,$cust_fb2 ,$cust_tweeter2 ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tmptlahir ,$cust_tgllahir ,$cust_referensi,$cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah, /*$cust_priority, */$cust_jmlanak ,$cust_unit ,$cust_aktif ,$cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$cust_cp ,$cust_cptelp ,$cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_bb ){
		
			if ($cust_aktif=="")
				$cust_aktif = "Aktif";
			if ($cust_unit=="Miracle Thamrin")
				$cust_unit = 1;
			if ($cust_unit=="Miracle HR Muhammad")
				$cust_unit = 2;
			if ($cust_unit=="Corporate")
				$cust_unit = 7;
			if ($cust_unit=="Miracle Kertajaya Indah")
				$cust_unit = 8;
			if ($cust_unit=="Miracle Tunjungan Plaza")
				$cust_unit = 9;
			if ($cust_unit=="Miracle Malang")
				$cust_unit = 10;
			if ($cust_unit=="Miracle Denpasar")
				$cust_unit = 11;
			if ($cust_unit=="Miracle Kuta")
				$cust_unit = 12;
			if ($cust_unit=="Miracle Jakarta")
				$cust_unit = 13;
			if ($cust_unit=="Miracle Makassar")
				$cust_unit = 14;
			if ($cust_unit=="Miracle Balikpapan")
				$cust_unit = 15;
			if ($cust_unit=="Miracle Batam")
				$cust_unit = 16;
			if ($cust_unit=="Manyar Garden")
				$cust_unit = 17;
			if ($cust_unit=="Miracle Medan")
				$cust_unit = 18;
			$date_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			
			if($cust_terdaftar=='')
			$cust_terdaftar=$date;
			
			/*if($cust_tglawaltrans=='')
			$cust_tglawaltrans=$date;*/
			
			if($cust_fretfulness=='')
			$cust_fretfulness='Medium';
			
/*			if($cust_kota=="" || $cust_kota==NULL)
				$cust_kota="Surabaya";
			if($cust_propinsi=="" || $cust_kota==NULL)
				$cust_propinsi="Jawa Timur";
			if($cust_negara=="" || $cust_kota==NULL)
				$cust_negara="Indonesia";*/
				
			if($cust_hobi_baca=='true')
			$baca="1";
			if($cust_hobi_baca=='false')
			$baca="0";	
			
			if($cust_hobi_olah=='true')
			$olah="1";
			if($cust_hobi_olah=='false')
			$olah="0";	
			
			if($cust_hobi_masak=='true')
			$masak="1";
			if($cust_hobi_masak=='false')
			$masak="0";	
			
			if($cust_hobi_foto=='true')
			$foto="1";
			if($cust_hobi_foto=='false')
			$foto="0";	
			
			if($cust_hobi_travel=='true')
			$travel="1";
			if($cust_hobi_travel=='false')
			$travel="0";	
			
			if($cust_hobi_nari=='true')
			$nari="1";
			if($cust_hobi_nari=='false')
			$nari="0";	
			
			if($cust_hobi_lukis=='true')
			$lukis="1";
			if($cust_hobi_lukis=='false')
			$lukis="0";	
			
			if($cust_hobi_lain=='true')
			$lain="1";
			if($cust_hobi_lain=='false')
			$lain="0";	
			
			$temp_hobi=$baca.$olah.$masak.$travel.$foto.$lukis.$nari.$lain;	 
			
			if($cust_aktif=='Tidak Aktif'){
				$sql="SELECT detail_jual_paket.dpaket_sisa_paket
				FROM master_jual_paket 
				LEFT JOIN detail_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
				LEFT JOIN customer on (customer.cust_id = master_jual_paket.jpaket_cust)
				where detail_jual_paket.dpaket_sisa_paket>0 and master_jual_paket.jpaket_stat_dok='Tertutup' and customer.cust_id = '$cust_id'";

				$rs = $this->db->query($sql);
				$nbrows = $rs->num_rows();
							
				if ($nbrows>0){
					return 2;
				}
				else
				{
					if($cust_no=='' && $cust_aktif !='Tidak Aktif'){
					//Generate Nomor Customer
					$cust_no = $this->m_public_function->get_custno_gen('customer','cust_no','',6);
					}
					
				$data = array(
					"cust_id"=>$cust_id,			
					"cust_no"=>$cust_no,
					"cust_nolama"=>$cust_nolama,
					"cust_nama"=>$cust_nama,
					"cust_panggilan"=>$cust_panggilan,
					"cust_foreigner"=>$cust_foreigner,
					"cust_kelamin"=>$cust_kelamin,
					"cust_title"=>$cust_title,
					"cust_alamat"=>$cust_alamat,			
					"cust_kota"=>$cust_kota,			
					"cust_kodepos"=>$cust_kodepos,			
					"cust_propinsi"=>$cust_propinsi,			
					"cust_negara"=>$cust_negara,
					"cust_alamat2"=>$cust_alamat2,
					"cust_kota2"=>$cust_kota2,			
					"cust_kodepos2"=>$cust_kodepos2,			
					"cust_propinsi2"=>$cust_propinsi2,			
					"cust_negara2"=>$cust_negara2,
					"cust_telprumah"=>$cust_telprumah,			
					"cust_telprumah2"=>$cust_telprumah2,			
					"cust_telpkantor"=>$cust_telpkantor,			
					"cust_hp"=>$cust_hp,			
					"cust_hp2"=>$cust_hp2,			
					"cust_hp3"=>$cust_hp3,
					"cust_bb"=>$cust_bb,
					"cust_email"=>$cust_email,
					"cust_email2"=>$cust_email2,
					"cust_agama"=>$cust_agama,			
					"cust_pendidikan"=>$cust_pendidikan,			
					"cust_profesi"=>$cust_profesi,			
					"cust_tmptlahir"=>$cust_tmptlahir,
					"cust_tgllahir"=>$cust_tgllahir,				
					"cust_hobi"=>$temp_hobi,			
					"cust_referensilain"=>$cust_referensilain,			
					"cust_keterangan"=>$cust_keterangan,			
					"cust_terdaftar"=>$cust_terdaftar,	
					//"cust_tglawaltrans"=>$cust_tglawaltrans,					
					"cust_statusnikah"=>$cust_statusnikah,
					//"cust_priority"=>$cust_priority,
					"cust_jmlanak"=>$cust_jmlanak,
					"cust_aktif"=>$cust_aktif,
					"cust_fretfulness"=>$cust_fretfulness,
					"cust_update"=>$_SESSION[SESSION_USERID],
					"cust_date_update"=>$date_now,			
					//"cust_revised"=>"(cust_revised+1)",
					"cust_cp"=>$cust_cp,
					"cust_cptelp"=>$cust_cptelp
				);
				if($cust_fb=='true')
					$data["cust_fb"]=1;
				if($cust_fb=='false')
					$data["cust_fb"]=0;
				if($cust_tweeter=='true')
					$data["cust_tweeter"]=1;
				if($cust_tweeter=='false')
					$data["cust_tweeter"]=0;
				if($cust_fb2=='true')
					$data["cust_fb2"]=1;
				if($cust_fb2=='false')
					$data["cust_fb2"]=0;
				if($cust_tweeter2=='true')
					$data["cust_tweeter2"]=1;
				if($cust_tweeter2=='false')
					$data["cust_tweeter2"]=0;
				
				$sql="select cabang_id from cabang where cabang_id='".$cust_unit."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["cust_unit"]=$cust_unit;
				
				$sql="SELECT cust_id FROM customer WHERE cust_id='".$cust_referensi."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["cust_referensi"]=$cust_referensi;
				
				$this->db->where('cust_id', $cust_id);
				$this->db->update('customer', $data);
				$sql="UPDATE customer SET cust_revised=(cust_revised+1) WHERE cust_id='$cust_id'";
				$this->db->query($sql);
				
				return '1';
				}
			} 
			else if ($cust_aktif=='Aktif') {
				if($cust_no==''/* && $cust_aktif !='Tidak Aktif'*/){
					//Generate Nomor Customer
					$cust_no = $this->m_public_function->get_custno_gen('customer','cust_no','',6);
					}
					
				$data = array(
					"cust_id"=>$cust_id,			
					"cust_no"=>$cust_no,
					"cust_nolama"=>$cust_nolama,
					"cust_nama"=>$cust_nama,
					"cust_panggilan"=>$cust_panggilan,
					"cust_foreigner"=>$cust_foreigner,
					"cust_kelamin"=>$cust_kelamin,
					"cust_title"=>$cust_title,
					"cust_alamat"=>$cust_alamat,			
					"cust_kota"=>$cust_kota,			
					"cust_kodepos"=>$cust_kodepos,			
					"cust_propinsi"=>$cust_propinsi,			
					"cust_negara"=>$cust_negara,
					"cust_alamat2"=>$cust_alamat2,
					"cust_kota2"=>$cust_kota2,			
					"cust_kodepos2"=>$cust_kodepos2,			
					"cust_propinsi2"=>$cust_propinsi2,			
					"cust_negara2"=>$cust_negara2,
					"cust_telprumah"=>$cust_telprumah,			
					"cust_telprumah2"=>$cust_telprumah2,			
					"cust_telpkantor"=>$cust_telpkantor,			
					"cust_hp"=>$cust_hp,			
					"cust_hp2"=>$cust_hp2,			
					"cust_hp3"=>$cust_hp3,	
					"cust_bb"=>$cust_bb,					
					"cust_email"=>$cust_email,
					"cust_email2"=>$cust_email2,
					"cust_agama"=>$cust_agama,			
					"cust_pendidikan"=>$cust_pendidikan,			
					"cust_profesi"=>$cust_profesi,			
					"cust_tmptlahir"=>$cust_tmptlahir,
					"cust_tgllahir"=>$cust_tgllahir,				
					"cust_hobi"=>$temp_hobi,			
					"cust_referensilain"=>$cust_referensilain,			
					"cust_keterangan"=>$cust_keterangan,			
					"cust_terdaftar"=>$cust_terdaftar,	
					//"cust_tglawaltrans"=>$cust_tglawaltrans,						
					"cust_statusnikah"=>$cust_statusnikah,
					//"cust_priority"=>$cust_priority,
					"cust_jmlanak"=>$cust_jmlanak,
					"cust_aktif"=>$cust_aktif,
					"cust_fretfulness"=>$cust_fretfulness,
					"cust_update"=>$_SESSION[SESSION_USERID],
					"cust_date_update"=>$date_now,			
					//"cust_revised"=>"(cust_revised+1)",
					"cust_cp"=>$cust_cp,
					"cust_cptelp"=>$cust_cptelp
				);
				if($cust_fb=='true')
					$data["cust_fb"]=1;
				if($cust_fb=='false')
					$data["cust_fb"]=0;
				if($cust_tweeter=='true')
					$data["cust_tweeter"]=1;
				if($cust_tweeter=='false')
					$data["cust_tweeter"]=0;
				if($cust_fb2=='true')
					$data["cust_fb2"]=1;
				if($cust_fb2=='false')
					$data["cust_fb2"]=0;
				if($cust_tweeter2=='true')
					$data["cust_tweeter2"]=1;
				if($cust_tweeter2=='false')
					$data["cust_tweeter2"]=0;
				
				$sql="select cabang_id from cabang where cabang_id='".$cust_unit."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["cust_unit"]=$cust_unit;
				
				$sql="SELECT cust_id FROM customer WHERE cust_id='".$cust_referensi."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["cust_referensi"]=$cust_referensi;
				
				$this->db->where('cust_id', $cust_id);
				$this->db->update('customer', $data);
				$sql="UPDATE customer SET cust_revised=(cust_revised+1) WHERE cust_id='$cust_id'";
				$this->db->query($sql);
				
				return '1';
				}
	}
		
		//function for create new record
		function customer_create($cust_no ,$cust_nolama ,$cust_nama, $cust_title, $cust_panggilan , $cust_foreigner, $cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara,$cust_alamat2 ,$cust_kota2 ,$cust_kodepos2 ,$cust_propinsi2 ,$cust_negara2 ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_fb ,$cust_tweeter , $cust_email2 ,$cust_fb2 ,$cust_tweeter2 ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tmptlahir ,$cust_tgllahir ,$cust_referensi,$cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_terdaftar ,$cust_tglawaltrans,$cust_statusnikah, /*$cust_priority,*/ $cust_jmlanak ,$cust_unit ,$cust_aktif , $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$cust_cp ,$cust_cptelp,$cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain , $cust_umurstart, $cust_umurend, $cust_umur,$cust_bb){
			if($cust_no=='' && $cust_aktif != 'Tidak Aktif'){
				//Generate Nomor Customer
				$cust_no = $this->m_public_function->get_custno_gen('customer','cust_no','',6);
			}
			
			$query =   "SELECT * FROM info";
			
			if ($cust_aktif=="")
				$cust_aktif = "Aktif";
			if ($cust_unit=="Miracle Thamrin")
				$cust_unit = 1;
			if ($cust_unit=="Miracle HR Muhammad")
				$cust_unit = 2;
			if ($cust_unit=="Corporate")
				$cust_unit = 7;
			if ($cust_unit=="Miracle Kertajaya Indah")
				$cust_unit = 8;
			if ($cust_unit=="Miracle Tunjungan Plaza")
				$cust_unit = 9;
			if ($cust_unit=="Miracle Malang")
				$cust_unit = 10;
			if ($cust_unit=="Miracle Denpasar")
				$cust_unit = 11;
			if ($cust_unit=="Miracle Kuta")
				$cust_unit = 12;
			if ($cust_unit=="Miracle Jakarta")
				$cust_unit = 13;
			if ($cust_unit=="Miracle Makassar")
				$cust_unit = 14;
			if ($cust_unit=="Miracle Balikpapan")
				$cust_unit = 15;
			if ($cust_unit=="Miracle Batam")
				$cust_unit = 16;
			if ($cust_unit=="Manyar Garden")
				$cust_unit = 17;
			if ($cust_unit=="Miracle Medan")
				$cust_unit = 18;
				
			$date_now = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			
			if($cust_terdaftar=='')
			$cust_terdaftar=$date;
			
			if($cust_tglawaltrans=='')
			$cust_tglawaltrans=$date;
			
			if($cust_fretfulness=='')
			$cust_fretfulness='Medium';
			
			if($cust_hobi_baca=='true')
			$baca="1";
			if($cust_hobi_baca=='false')
			$baca="0";	
			
			if($cust_hobi_olah=='true')
			$olah="1";
			if($cust_hobi_olah=='false')
			$olah="0";	
			
			if($cust_hobi_masak=='true')
			$masak="1";
			if($cust_hobi_masak=='false')
			$masak="0";	
			
			if($cust_hobi_foto=='true')
			$foto="1";
			if($cust_hobi_foto=='false')
			$foto="0";	
			
			if($cust_hobi_travel=='true')
			$travel="1";
			if($cust_hobi_travel=='false')
			$travel="0";	
			
			if($cust_hobi_nari=='true')
			$nari="1";
			if($cust_hobi_nari=='false')
			$nari="0";	
			
			if($cust_hobi_lukis=='true')
			$lukis="1";
			if($cust_hobi_lukis=='false')
			$lukis="0";	
			
			if($cust_hobi_lain=='true')
			$lain="1";
			if($cust_hobi_lain=='false')
			$lain="0";	
			
			$temp_hobi=$baca.$olah.$masak.$travel.$foto.$lukis.$nari.$lain;	
			
/*			if($cust_kota=="" || $cust_kota==NULL)
				$cust_kota="Surabaya";
			if($cust_propinsi=="" || $cust_kota==NULL)
				$cust_propinsi="Jawa Timur";
			if($cust_negara=="" || $cust_kota==NULL)
				$cust_negara="Indonesia";*/
			$data = array(
				"cust_no"=>$cust_no,
				"cust_nolama"=>$cust_nolama,
				"cust_nama"=>$cust_nama,
				"cust_panggilan"=>$cust_panggilan,
				"cust_foreigner"=>$cust_foreigner,
				"cust_kelamin"=>$cust_kelamin,
				"cust_title"=>$cust_title,
				"cust_alamat"=>$cust_alamat,			
				"cust_kota"=>$cust_kota,			
				"cust_kodepos"=>$cust_kodepos,			
				"cust_propinsi"=>$cust_propinsi,			
				"cust_negara"=>$cust_negara,
				"cust_alamat2"=>$cust_alamat2,
				"cust_kota2"=>$cust_kota2,			
				"cust_kodepos2"=>$cust_kodepos2,			
				"cust_propinsi2"=>$cust_propinsi2,			
				"cust_negara2"=>$cust_negara2,
				"cust_telprumah"=>$cust_telprumah,			
				"cust_telprumah2"=>$cust_telprumah2,			
				"cust_telpkantor"=>$cust_telpkantor,			
				"cust_hp"=>$cust_hp,			
				"cust_hp2"=>$cust_hp2,			
				"cust_hp3"=>$cust_hp3,	
				"cust_bb"=>$cust_bb,				
				"cust_email"=>$cust_email,
				"cust_email2"=>$cust_email2,
				"cust_agama"=>$cust_agama,			
				"cust_pendidikan"=>$cust_pendidikan,			
				"cust_profesi"=>$cust_profesi,
				"cust_tmptlahir"=>$cust_tmptlahir,
				"cust_tgllahir"=>$cust_tgllahir,	
				//"cust_umur"=>$cust_umur,
				"cust_hobi"=>$temp_hobi,			
				"cust_referensi"=>$cust_referensi,			
				"cust_referensilain"=>$cust_referensilain,			
				"cust_keterangan"=>$cust_keterangan,			
				"cust_terdaftar"=>$cust_terdaftar,	
				//"cust_tglawaltrans"=>$cust_tglawaltrans,				
				"cust_statusnikah"=>$cust_statusnikah,
				//"cust_priority"=>$cust_priority,
				"cust_jmlanak"=>$cust_jmlanak,
				"cust_unit"=>$cust_unit,
				"cust_aktif"=>$cust_aktif,
				"cust_fretfulness"=>$cust_fretfulness,
				"cust_creator"=>$_SESSION[SESSION_USERID],
				"cust_date_create"=>$date_now,
				// "cust_update"=>$_SESSION[SESSION_USERID],
				// "cust_date_update"=>$date_now,
				"cust_revised"=>0,
				"cust_cp"=>$cust_cp,
				"cust_cptelp"=>$cust_cptelp
			);
			if($cust_fb=='true')
				$data["cust_fb"]=1;
			if($cust_fb=='false')
				$data["cust_fb"]=0;
			if($cust_tweeter=='true')
				$data["cust_tweeter"]=1;
			if($cust_tweeter=='false')
				$data["cust_tweeter"]=0;
			if($cust_fb2=='true')
				$data["cust_fb2"]=1;
			if($cust_fb2=='false')
				$data["cust_fb2"]=0;
			if($cust_tweeter2=='true')
				$data["cust_tweeter2"]=1;
			if($cust_tweeter2=='false')
				$data["cust_tweeter2"]=0;
			$this->db->insert('customer', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function customer_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the customers at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM customer WHERE cust_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM customer WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "cust_id= ".$pkid[$i];
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
		function customer_search($cust_id ,$cust_no ,$cust_no_awal ,$cust_no_akhir, $cust_nama, $cust_panggilan, $cust_foreigner ,$cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir, $cust_tgllahirend,$cust_referensi ,$cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_member2 ,$cust_terdaftar , $cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans, $cust_tglawaltransend, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif , $sortby, $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$start,$end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end){
			
			/*untuk pengecekan transaksi*/
			if($cust_transaksi_start!='' and $cust_transaksi_end!=''){
				$string_query_transcust = " between '".$cust_transaksi_start."' and '".$cust_transaksi_end."' ";
			}else if($cust_transaksi_start!='' and $cust_transaksi_end==''){
				$string_query_transcust = " >= '".$cust_transaksi_start."' ";
			}else if($cust_transaksi_start=='' and $cust_transaksi_end!=''){
				$string_query_transcust = " <= '".$cust_transaksi_end."' ";
			}
			
			/*untuk pengecekan yg tidak transaksi*/
			if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."' ";
			}else if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end==''){
				$string_query_nontranscust = " >= '".$cust_tidak_transaksi_start."' ";
			}else if($cust_tidak_transaksi_start=='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " <= '".$cust_tidak_transaksi_end."' ";
			}
			
			/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($cust_transaksi_start!='' or $cust_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_transcust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_transcust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_transcust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_nontranscust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_nontranscust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_nontranscust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}
	
			if ($cust_aktif=="")
				$cust_aktif = "Aktif";

			$query = "SELECT v.*
						FROM vu_customer v";

			if($cust_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id LIKE '%".$cust_id."%'";
			};
			if($cust_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_no LIKE '%".$cust_no."%'";
			};
			if($cust_no_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " right(cust_no,6) BETWEEN '".$cust_no_awal."' AND '".$cust_no_akhir."'";
				};
			if($cust_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_nama LIKE '%".$cust_nama."%'";
			};
			if($cust_panggilan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_panggilan LIKE '%".$cust_panggilan."%'";
			};
			if($cust_foreigner!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_foreigner LIKE '%".$cust_foreigner."%'";
			};
			if($cust_kelamin!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_kelamin LIKE '%".$cust_kelamin."%'";
			};
			if($cust_alamat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_alamat LIKE '%".$cust_alamat."%' OR cust_alamat2 LIKE '%".$cust_alamat."%'";
			};
			if($cust_kota!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_kota LIKE '%".$cust_kota."%'";
			};
			if($cust_kodepos!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_kodepos LIKE '%".$cust_kodepos."%'";
			};
			if($cust_propinsi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_propinsi LIKE '%".$cust_propinsi."%'";
			};
			if($cust_negara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_negara LIKE '%".$cust_negara."%'";
			};
			if($cust_telprumah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_telprumah LIKE '%".$cust_telprumah."%' OR cust_telprumah2 LIKE '%".$cust_telprumah."%' OR cust_telpkantor LIKE '%".$cust_telprumah."%'  OR cust_hp LIKE '%".$cust_telprumah."%' OR cust_hp2 LIKE '%".$cust_telprumah."%' OR cust_hp3 LIKE '%".$cust_telprumah."%'";
			};
			if($cust_bb!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_bb LIKE '%".$cust_bb."%'";
			};
			if($cust_email!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_email LIKE '%".$cust_email."%'  OR cust_email2 LIKE '%".$cust_email."%'   ";
			};
			if($cust_agama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_agama LIKE '%".$cust_agama."%'";
			};
			if($cust_pendidikan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_pendidikan LIKE '%".$cust_pendidikan."%'";
			};
			if($cust_profesi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_profesi LIKE '%".$cust_profesi."%'";
			};							
			if($cust_hobi_baca == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,1,1)) = '1'";
			};		
			if($cust_hobi_olah == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,2,1)) = '1'";
			};		
			if($cust_hobi_masak == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,3,1)) = '1'";
			};		
			if($cust_hobi_travel == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,4,1)) = '1'";
			};		
			if($cust_hobi_foto == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,5,1)) = '1'";
			};		
			if($cust_hobi_lukis == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,6,1)) = '1'";
			};		
			if($cust_hobi_nari == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,7,1)) = '1'";
			};		
			if($cust_hobi_lain == 'true'){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " (SELECT SUBSTRING(cust_hobi,8,1)) = '1'";
			};		
			if($cust_referensi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_referensi LIKE '%".$cust_referensi."%'";
			};
			if($cust_referensilain!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_referensilain LIKE '%".$cust_referensilain."%'";
			};
			if($cust_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_keterangan LIKE '%".$cust_keterangan."%'";
			};
			if($cust_member!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_member LIKE '%".$cust_member."%'";
			};
			if($cust_member2!=''){
				$date_now = date('Y-m-d');
				if($cust_member2=='Semua'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_member <> ''";
				} 
				else if($cust_member2=='Aktif'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid > '".$date_now."'";
				}
				else if($cust_member2=='Tidak Aktif'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid < '".$date_now."'";
				}
				else if($cust_member2=='Non Member'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_member = ''";
				}				
			};			
			if($cust_statusnikah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_statusnikah='".$cust_statusnikah."'";
			};
			if($cust_priority!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_priority='".$cust_priority."'";
			};
			if($cust_jmlanak!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_jmlanak LIKE '%".$cust_jmlanak."%'";
			};
			if($cust_unit!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_unit LIKE '%".$cust_unit."%'";
			};
			if($cust_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_aktif = '".$cust_aktif."'";
			};
			if($cust_fretfulness!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_fretfulness LIKE '%".$cust_fretfulness."%'";
			};
			if($sortby=='Nama'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_nama";
			};
			if($sortby=='No Cust'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_no";
			};
			if($sortby=='Alamat'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_alamat";
			};
			if($sortby=='Tgl Lahir'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_tgllahir";
			};
			if($sortby=='Telp Rmh'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_telprumah";
			};
			if($sortby=='Handphone'){
				$query.=eregi("WHERE",$query)?" ":" WHERE ";
				$query.= " ORDER BY cust_hp";
			};
			if($cust_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_creator LIKE '%".$cust_creator."%'";
			};
			if($cust_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_date_create LIKE '%".$cust_date_create."%'";
			};
			if($cust_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_update LIKE '%".$cust_update."%'";
			};
			if($cust_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_date_update LIKE '%".$cust_date_update."%'";
			};
			if($cust_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_revised LIKE '%".$cust_revised."%'";
			};
			/*search berdasarkan tgl lahir */
			if($cust_tgllahir!='' or $cust_tgllahirend!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";				
				if($cust_tgllahir!='' and $cust_tgllahirend!=''){
					$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
				}else if ($cust_tgllahir!='' and $cust_tgllahirend==''){
					$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND now()";
				}else if ($cust_tgllahir=='' and $cust_tgllahirend!=''){
					$query.= " cust_tgllahir < '".$cust_tgllahirend."'";
				}
			};	
			/*search berdasarkan tgl dan bulan lahir */			
			if($cust_tgl!='' and $cust_bulan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if ($cust_tglEnd!='' and $cust_bulanEnd!=''){
					$query.= " (day(cust_tgllahir) BETWEEN '".$cust_tgl."' AND '".$cust_tglEnd."') AND (month(cust_tgllahir) BETWEEN '".$cust_bulan."' AND '".$cust_bulanEnd."') ";
				}else{
					$query.= " day(cust_tgllahir)='".$cust_tgl."' AND month(cust_tgllahir)='".$cust_bulan."' ";
				}
			}else if($cust_tgl=='' and $cust_bulan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " month(cust_tgllahir)='".$cust_bulan."'";
			};	
			/*search berdasarkan umur*/			
			if($cust_umurstart!='' or $cust_umurend!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($cust_umurstart!='' and $cust_umurend!=''){
					$query.= " (year(now())-year(cust_tgllahir)) BETWEEN '".$cust_umurstart."' AND '".$cust_umurend."'";
				}else if ($cust_umurstart!='' and $cust_umurend==''){
					$query.= " (year(now())-year(cust_tgllahir)) > '".$cust_umurstart."'";
				}else if ($cust_umurstart=='' and $cust_umurend!=''){
					$query.= " (year(now())-year(cust_tgllahir)) < '".$cust_umurend."'";
				}
			};			
			/*search berdasarkan transaksi customer*/			
			if($cust_transaksi_start!='' or $cust_transaksi_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id IN($string)";
			}
			if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cust_id NOT IN($string_not)";
			}
			if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				
				if($cust_terdaftar!='' and $cust_tgldaftarend!=''){
					$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";
				}else if ($cust_terdaftar!='' and $cust_tgldaftarend==''){
					$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND now()";
				}else if ($cust_terdaftar=='' and $cust_tgldaftarend!=''){
					$query.= " cust_terdaftar < '".$cust_tgldaftarend."'";
				}	
			};
			/*search berdasarkan tgl awal transaksi */
			if($cust_tglawaltrans!='' or $cust_tglawaltransend!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
				if($cust_tglawaltrans!='' and $cust_tglawaltrans!=''){
					$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND '".$cust_tglawaltransend."'";
				}else if ($cust_tglawaltrans!='' and $cust_tglawaltrans==''){
					$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND now()";
				}else if ($cust_tglawaltrans=='' and $cust_tglawaltrans!=''){
					$query.= " cust_tglawaltrans < '".$cust_tglawaltrans."'";
				}	
			};
			/*search berdasarkan Member Register */
			if($member_terdaftarstart!='' or $member_terdaftarend!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
				if($member_terdaftarstart!='' and $member_terdaftarend!=''){
					$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND '".$member_terdaftarend."'";
				}else if ($member_terdaftarstart!='' and $member_terdaftarend==''){
					$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND now()";
				}else if ($member_terdaftarstart=='' and $member_terdaftarend!=''){
					$query.= " member_register < '".$member_terdaftarend."'";
				}				
			};		
			
			
			$query.= " order by cust_id desc ";
			
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
		
		//function for search label
		function customer_print_label($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter){
		$query =   "SELECT 
							v.*
						FROM vu_customer v
						WHERE cust_aktif = 'Aktif' ";
						
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_alamat LIKE '%".addslashes($filter)."%' OR cust_alamat2 LIKE '%".addslashes($filter)."%' OR cust_telprumah LIKE '%".addslashes($filter)."%' OR cust_telprumah2 LIKE '%".addslashes($filter)."%' OR cust_telpkantor LIKE '%".addslashes($filter)."%' OR cust_hp LIKE '%".addslashes($filter)."%' OR cust_hp2 LIKE '%".addslashes($filter)."%' OR cust_hp3 LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%' )";
				$query .= " AND cust_aktif = 'Aktif'";
			} 
			else if($option=='SEARCH'){

				/*untuk pengecekan transaksi*/
				if($cust_transaksi_start!='' and $cust_transaksi_end!=''){
					$string_query_transcust = " between '".$cust_transaksi_start."' and '".$cust_transaksi_end."' ";
				}else if($cust_transaksi_start!='' and $cust_transaksi_end==''){
					$string_query_transcust = " >= '".$cust_transaksi_start."' ";
				}else if($cust_transaksi_start=='' and $cust_transaksi_end!=''){
					$string_query_transcust = " <= '".$cust_transaksi_end."' ";
				}
				
				/*untuk pengecekan yg tidak transaksi*/
				if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!=''){
					$string_query_nontranscust = " between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."' ";
				}else if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end==''){
					$string_query_nontranscust = " >= '".$cust_tidak_transaksi_start."' ";
				}else if($cust_tidak_transaksi_start=='' and $cust_tidak_transaksi_end!=''){
					$string_query_nontranscust = " <= '".$cust_tidak_transaksi_end."' ";
				}
				
				/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
				if($cust_transaksi_start!='' or $cust_transaksi_end!=''){
					$sql = "SELECT distinct(cust_id)
							FROM
							((((
								SELECT distinct(jrawat_cust) as cust_id,
								'rawat' as status
								FROM master_jual_rawat
								WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_transcust) order by cust_id
							)
							union
							(
								SELECT distinct(jpaket_cust) as cust_id,
								'paket' as status
								FROM master_jual_paket
								WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_transcust)
							)
							union
							(
								SELECT distinct(jproduk_cust) as cust_id,
								'produk' as status
								FROM master_jual_produk
								WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_transcust)
							)
							union
							(
								SELECT distinct(dapaket_cust) as cust_id,
								'ambil_paket' as status
								FROM detail_ambil_paket
								WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_transcust)
							)
							union
							(
								select distinct
								history_transaksi.thistory_cust as cust_id,
								'prog_lama' AS referal
								from history_transaksi
								left join customer on customer.cust_id = history_transaksi.thistory_cust
								WHERE history_transaksi.thistory_tanggal $string_query_transcust AND
								cust_id IS NOT NULL
							)
							)))
							as table_union
							order by cust_id";
					$result_sql = $this->db->query($sql);
					$string = '0';
					foreach($result_sql->result() as $row){
						$string_cust=$row->cust_id;
						$string = $string.','.$string_cust;
					}
				}
				if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!=''){
					$sql = "SELECT distinct(cust_id)
							FROM
							((((
								SELECT distinct(jrawat_cust) as cust_id,
								'rawat' as status
								FROM master_jual_rawat
								WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_nontranscust) order by cust_id
							)
							union
							(
								SELECT distinct(jpaket_cust) as cust_id,
								'paket' as status
								FROM master_jual_paket
								WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_nontranscust)
							)
							union
							(
								SELECT distinct(jproduk_cust) as cust_id,
								'produk' as status
								FROM master_jual_produk
								WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_nontranscust)
							)
							union
							(
								SELECT distinct(dapaket_cust) as cust_id,
								'ambil_paket' as status
								FROM detail_ambil_paket
								WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_nontranscust)
							)
							union
							(
								select distinct
								history_transaksi.thistory_cust as cust_id,
								'prog_lama' AS referal
								from history_transaksi
								left join customer on customer.cust_id = history_transaksi.thistory_cust
								WHERE history_transaksi.thistory_tanggal $string_query_nontranscust AND
								cust_id IS NOT NULL
							)
							)))
							as table_union
							order by cust_id";
					$result_sql = $this->db->query($sql);
					$string_not = '0';
					foreach($result_sql->result() as $row){
						$string_cust=$row->cust_id;
						$string_not = $string_not.','.$string_cust;
					}
				}

				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id LIKE '%".$cust_id."%'";
				};
				if($cust_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_no LIKE '%".$cust_no."%'";
				};
				if($cust_no_awal!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " right(cust_no,6) BETWEEN '".$cust_no_awal."' AND '".$cust_no_akhir."'";
					};
				if($cust_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_nama LIKE '%".$cust_nama."%'";
				};
				if($cust_panggilan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_panggilan LIKE '%".$cust_panggilan."%'";
				};
				if($cust_foreigner!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_foreigner LIKE '%".$cust_foreigner."%'";
				};
				if($cust_kelamin!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kelamin LIKE '%".$cust_kelamin."%'";
				};
				if($cust_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_alamat LIKE '%".$cust_alamat."%' OR cust_alamat2 LIKE '%".$cust_alamat."%'";
				};
				if($cust_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kota LIKE '%".$cust_kota."%'";
				};
				if($cust_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kodepos LIKE '%".$cust_kodepos."%'";
				};
				if($cust_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_propinsi LIKE '%".$cust_propinsi."%'";
				};
				if($cust_negara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_negara LIKE '%".$cust_negara."%'";
				};
				if($cust_telprumah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_telprumah LIKE '%".$cust_telprumah."%' OR cust_telprumah2 LIKE '%".$cust_telprumah."%' OR cust_telpkantor LIKE '%".$cust_telprumah."%' ";
				};
				if($cust_bb!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_bb LIKE '%".$cust_bb."%'";
				};
				if($cust_email!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_email LIKE '%".$cust_email."%'  OR cust_email2 LIKE '%".$cust_email."%'   ";
				};
				if($cust_agama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_agama LIKE '%".$cust_agama."%'";
				};
				if($cust_pendidikan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_pendidikan LIKE '%".$cust_pendidikan."%'";
				};
				if($cust_profesi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_profesi LIKE '%".$cust_profesi."%'";
				};							
				if($cust_hobi_baca == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,1,1)) = '1'";
				};		
				if($cust_hobi_olah == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,2,1)) = '1'";
				};		
				if($cust_hobi_masak == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,3,1)) = '1'";
				};		
				if($cust_hobi_travel == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,4,1)) = '1'";
				};		
				if($cust_hobi_foto == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,5,1)) = '1'";
				};		
				if($cust_hobi_lukis == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,6,1)) = '1'";
				};		
				if($cust_hobi_nari == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,7,1)) = '1'";
				};		
				if($cust_hobi_lain == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,8,1)) = '1'";
				};		
				if($cust_referensi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensi LIKE '%".$cust_referensi."%'";
				};
				if($cust_referensilain!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensilain LIKE '%".$cust_referensilain."%'";
				};
				if($cust_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_keterangan LIKE '%".$cust_keterangan."%'";
				};
				if($cust_member!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_member LIKE '%".$cust_member."%'";
				};
				if($cust_member2!=''){
					$date_now = date('Y-m-d');
					if($cust_member2=='Semua'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member <> ''";
					} 
					else if($cust_member2=='Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid > '".$date_now."'";
					}
					else if($cust_member2=='Tidak Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid < '".$date_now."'";
					}
					else if($cust_member2=='Non Member'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member = ''";
					}				
				};			
				if($cust_statusnikah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_statusnikah='".$cust_statusnikah."'";
				};
				if($cust_priority!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_priority='".$cust_priority."'";
				};
				if($cust_jmlanak!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_jmlanak LIKE '%".$cust_jmlanak."%'";
				};
				if($cust_unit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_unit LIKE '%".$cust_unit."%'";
				};
				if($cust_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_aktif = '".$cust_aktif."'";
				};
				if($cust_fretfulness!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_fretfulness LIKE '%".$cust_fretfulness."%'";
				};
				if($sortby=='Nama'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_nama";
				};
				if($sortby=='No Cust'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_no";
				};
				if($sortby=='Alamat'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_alamat";
				};
				if($sortby=='Tgl Lahir'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_tgllahir";
				};
				if($sortby=='Telp Rmh'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_telprumah";
				};
				if($sortby=='Handphone'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_hp";
				};
				if($cust_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_creator LIKE '%".$cust_creator."%'";
				};
				if($cust_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_create LIKE '%".$cust_date_create."%'";
				};
				if($cust_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_update LIKE '%".$cust_update."%'";
				};
				if($cust_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_update LIKE '%".$cust_date_update."%'";
				};
				if($cust_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_revised LIKE '%".$cust_revised."%'";
				};
				/*search berdasarkan tgl lahir */
				if($cust_tgllahir!='' or $cust_tgllahirend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";				
					if($cust_tgllahir!='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
					}else if ($cust_tgllahir!='' and $cust_tgllahirend==''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND now()";
					}else if ($cust_tgllahir=='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir < '".$cust_tgllahirend."'";
					}
				};	
				/*search berdasarkan tgl dan bulan lahir */			
				if($cust_tgl!='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if ($cust_tglEnd!='' and $cust_bulanEnd!=''){
						$query.= " (day(cust_tgllahir) BETWEEN '".$cust_tgl."' AND '".$cust_tglEnd."') AND (month(cust_tgllahir) BETWEEN '".$cust_bulan."' AND '".$cust_bulanEnd."') ";
					}else{
						$query.= " day(cust_tgllahir)='".$cust_tgl."' AND month(cust_tgllahir)='".$cust_bulan."' ";
					}
				}else if($cust_tgl=='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " month(cust_tgllahir)='".$cust_bulan."'";
				};	
				/*search berdasarkan umur*/			
				if($cust_umurstart!='' or $cust_umurend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($cust_umurstart!='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) BETWEEN '".$cust_umurstart."' AND '".$cust_umurend."'";
					}else if ($cust_umurstart!='' and $cust_umurend==''){
						$query.= " (year(now())-year(cust_tgllahir)) > '".$cust_umurstart."'";
					}else if ($cust_umurstart=='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) < '".$cust_umurend."'";
					}
				};			
				/*search berdasarkan transaksi customer*/			
				if($cust_transaksi_start!='' or $cust_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id IN($string)";
				}
				if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id NOT IN($string_not)";
				}
				if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					
					if($cust_terdaftar!='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";
					}else if ($cust_terdaftar!='' and $cust_tgldaftarend==''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND now()";
					}else if ($cust_terdaftar=='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar < '".$cust_tgldaftarend."'";
					}	
				};
				/*search berdasarkan tgl transaksi */
				if($cust_tglawaltrans!='' or $cust_tglawaltransend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($cust_tglawaltrans!='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND '".$cust_tglawaltransend."'";
					}else if ($cust_tglawaltrans!='' and $cust_tglawaltrans==''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND now()";
					}else if ($cust_tglawaltrans=='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans < '".$cust_tglawaltrans."'";
					}	
				};
				/*search berdasarkan Member Register */
				if($member_terdaftarstart!='' or $member_terdaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($member_terdaftarstart!='' and $member_terdaftarend!=''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND '".$member_terdaftarend."'";
					}else if ($member_terdaftarstart!='' and $member_terdaftarend==''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND now()";
					}else if ($member_terdaftarstart=='' and $member_terdaftarend!=''){
						$query.= " member_register < '".$member_terdaftarend."'";
					}				
				};		
			}
			
			$query.= " order by cust_id desc ";
			$result = $this->db->query($query);
			return $result;
		}
		
		//function for print record
		function customer_print
		($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter)
		
		
	/*	($cust_id ,$cust_no ,$cust_no_awal ,$cust_no_akhir, $cust_nama ,$cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir, $cust_tgllahirend,$cust_referensi ,$cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_member2 ,$cust_terdaftar , $cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans, $cust_tglawaltransend, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif , $sortby, $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$start,$end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end)*/
		{
			$query =   "SELECT v.*
						FROM vu_customer v
						WHERE cust_aktif = 'Aktif' ";
						
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_alamat LIKE '%".addslashes($filter)."%' OR cust_alamat2 LIKE '%".addslashes($filter)."%' OR cust_telprumah LIKE '%".addslashes($filter)."%' OR cust_telprumah2 LIKE '%".addslashes($filter)."%' OR cust_telpkantor LIKE '%".addslashes($filter)."%' OR cust_hp LIKE '%".addslashes($filter)."%' OR cust_hp2 LIKE '%".addslashes($filter)."%' OR cust_hp3 LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%' )";
				$query .= " AND cust_aktif = 'Aktif'";
			} 
			else if($option=='SEARCH'){
				
			/*untuk pengecekan transaksi*/
			if($cust_transaksi_start!='' and $cust_transaksi_end!=''){
				$string_query_transcust = " between '".$cust_transaksi_start."' and '".$cust_transaksi_end."' ";
			}else if($cust_transaksi_start!='' and $cust_transaksi_end==''){
				$string_query_transcust = " >= '".$cust_transaksi_start."' ";
			}else if($cust_transaksi_start=='' and $cust_transaksi_end!=''){
				$string_query_transcust = " <= '".$cust_transaksi_end."' ";
			}
			
			/*untuk pengecekan yg tidak transaksi*/
			if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."' ";
			}else if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end==''){
				$string_query_nontranscust = " >= '".$cust_tidak_transaksi_start."' ";
			}else if($cust_tidak_transaksi_start=='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " <= '".$cust_tidak_transaksi_end."' ";
			}
			
			/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($cust_transaksi_start!='' or $cust_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_transcust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_transcust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_transcust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_nontranscust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_nontranscust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_nontranscust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}	
			
				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id LIKE '%".$cust_id."%'";
				};
				if($cust_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_no LIKE '%".$cust_no."%'";
				};
				if($cust_no_awal!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " right(cust_no,6) BETWEEN '".$cust_no_awal."' AND '".$cust_no_akhir."'";
					};
				if($cust_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_nama LIKE '%".$cust_nama."%'";
				};
				if($cust_panggilan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_panggilan LIKE '%".$cust_panggilan."%'";
				};
				if($cust_foreigner!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_foreigner LIKE '%".$cust_foreigner."%'";
				};
				if($cust_kelamin!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kelamin LIKE '%".$cust_kelamin."%'";
				};
				if($cust_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_alamat LIKE '%".$cust_alamat."%' OR cust_alamat2 LIKE '%".$cust_alamat."%'";
				};
				if($cust_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kota LIKE '%".$cust_kota."%'";
				};
				if($cust_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kodepos LIKE '%".$cust_kodepos."%'";
				};
				if($cust_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_propinsi LIKE '%".$cust_propinsi."%'";
				};
				if($cust_negara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_negara LIKE '%".$cust_negara."%'";
				};
				if($cust_telprumah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_telprumah LIKE '%".$cust_telprumah."%' OR cust_telprumah2 LIKE '%".$cust_telprumah."%' OR cust_telpkantor LIKE '%".$cust_telprumah."%' ";
				};
				if($cust_bb!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_bb LIKE '%".$cust_bb."%'";
				};
				if($cust_email!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_email LIKE '%".$cust_email."%'  OR cust_email2 LIKE '%".$cust_email."%'   ";
				};
				if($cust_agama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_agama LIKE '%".$cust_agama."%'";
				};
				if($cust_pendidikan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_pendidikan LIKE '%".$cust_pendidikan."%'";
				};
				if($cust_profesi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_profesi LIKE '%".$cust_profesi."%'";
				};							
				if($cust_hobi_baca == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,1,1)) = '1'";
				};		
				if($cust_hobi_olah == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,2,1)) = '1'";
				};		
				if($cust_hobi_masak == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,3,1)) = '1'";
				};		
				if($cust_hobi_travel == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,4,1)) = '1'";
				};		
				if($cust_hobi_foto == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,5,1)) = '1'";
				};		
				if($cust_hobi_lukis == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,6,1)) = '1'";
				};		
				if($cust_hobi_nari == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,7,1)) = '1'";
				};		
				if($cust_hobi_lain == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,8,1)) = '1'";
				};		
				if($cust_referensi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensi LIKE '%".$cust_referensi."%'";
				};
				if($cust_referensilain!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensilain LIKE '%".$cust_referensilain."%'";
				};
				if($cust_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_keterangan LIKE '%".$cust_keterangan."%'";
				};
				if($cust_member!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_member LIKE '%".$cust_member."%'";
				};
				if($cust_member2!=''){
					$date_now = date('Y-m-d');
					if($cust_member2=='Semua'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member <> ''";
					} 
					else if($cust_member2=='Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid > '".$date_now."'";
					}
					else if($cust_member2=='Tidak Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid < '".$date_now."'";
					}
					else if($cust_member2=='Non Member'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member = ''";
					}				
				};			
				if($cust_statusnikah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_statusnikah='".$cust_statusnikah."'";
				};
				if($cust_priority!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_priority='".$cust_priority."'";
				};
				if($cust_jmlanak!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_jmlanak LIKE '%".$cust_jmlanak."%'";
				};
				if($cust_unit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_unit LIKE '%".$cust_unit."%'";
				};
				if($cust_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_aktif = '".$cust_aktif."'";
				};
				if($cust_fretfulness!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_fretfulness LIKE '%".$cust_fretfulness."%'";
				};
				if($sortby=='Nama'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_nama";
				};
				if($sortby=='No Cust'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_no";
				};
				if($sortby=='Alamat'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_alamat";
				};
				if($sortby=='Tgl Lahir'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_tgllahir";
				};
				if($sortby=='Telp Rmh'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_telprumah";
				};
				if($sortby=='Handphone'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_hp";
				};
				if($cust_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_creator LIKE '%".$cust_creator."%'";
				};
				if($cust_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_create LIKE '%".$cust_date_create."%'";
				};
				if($cust_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_update LIKE '%".$cust_update."%'";
				};
				if($cust_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_update LIKE '%".$cust_date_update."%'";
				};
				if($cust_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_revised LIKE '%".$cust_revised."%'";
				};
				/*search berdasarkan tgl lahir */
				if($cust_tgllahir!='' or $cust_tgllahirend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";				
					if($cust_tgllahir!='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
					}else if ($cust_tgllahir!='' and $cust_tgllahirend==''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND now()";
					}else if ($cust_tgllahir=='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir < '".$cust_tgllahirend."'";
					}
				};	
				/*search berdasarkan tgl dan bulan lahir */			
				if($cust_tgl!='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if ($cust_tglEnd!='' and $cust_bulanEnd!=''){
						$query.= " (day(cust_tgllahir) BETWEEN '".$cust_tgl."' AND '".$cust_tglEnd."') AND (month(cust_tgllahir) BETWEEN '".$cust_bulan."' AND '".$cust_bulanEnd."') ";
					}else{
						$query.= " day(cust_tgllahir)='".$cust_tgl."' AND month(cust_tgllahir)='".$cust_bulan."' ";
					}
				}else if($cust_tgl=='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " month(cust_tgllahir)='".$cust_bulan."'";
				};	
				/*search berdasarkan umur*/			
				if($cust_umurstart!='' or $cust_umurend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($cust_umurstart!='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) BETWEEN '".$cust_umurstart."' AND '".$cust_umurend."'";
					}else if ($cust_umurstart!='' and $cust_umurend==''){
						$query.= " (year(now())-year(cust_tgllahir)) > '".$cust_umurstart."'";
					}else if ($cust_umurstart=='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) < '".$cust_umurend."'";
					}
				};			
				/*search berdasarkan transaksi customer*/			
				if($cust_transaksi_start!='' or $cust_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id IN($string)";
				}
				if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id NOT IN($string_not)";
				}
				if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					
					if($cust_terdaftar!='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";
					}else if ($cust_terdaftar!='' and $cust_tgldaftarend==''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND now()";
					}else if ($cust_terdaftar=='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar < '".$cust_tgldaftarend."'";
					}	
				};
				/*search berdasarkan tgl transaksi */
				if($cust_tglawaltrans!='' or $cust_tglawaltransend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($cust_tglawaltrans!='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND '".$cust_tglawaltransend."'";
					}else if ($cust_tglawaltrans!='' and $cust_tglawaltrans==''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND now()";
					}else if ($cust_tglawaltrans=='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans < '".$cust_tglawaltrans."'";
					}	
				};
				/*search berdasarkan Member Register */
				if($member_terdaftarstart!='' or $member_terdaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($member_terdaftarstart!='' and $member_terdaftarend!=''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND '".$member_terdaftarend."'";
					}else if ($member_terdaftarstart!='' and $member_terdaftarend==''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND now()";
					}else if ($member_terdaftarstart=='' and $member_terdaftarend!=''){
						$query.= " member_register < '".$member_terdaftarend."'";
					}				
				};		
			}
			$query.= " order by cust_id desc ";
			$result = $this->db->query($query);
			return $result;
		}
		
		//function  for export to excel
		function customer_export_excel($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter){
			$query =   "select
						if(cust_no='','-',ifnull(cust_no,'-')) AS no_cust,
						if(cust_nama='','-',ifnull(cust_nama,'-')) AS nama_lengkap,
						if(member_no='','-',ifnull(member_no,'-')) AS no_member,
						if(member_valid='','-',ifnull(member_valid,'-')) AS tgl_valid,
						if(cust_kelamin='','-',ifnull(cust_kelamin,'-')) AS 'L/P',
						if(cust_alamat='','-',ifnull(cust_alamat,'-')) AS alamat,
						if(cust_kota='','-',ifnull(cust_kota,'-')) AS kota,
						/*if(cust_telprumah='','-',ifnull(cust_telprumah,'-')) AS telp_rumah,
						if(cust_hp='','-',ifnull(cust_hp,'-')) AS no_ponsel,*/
						if(cust_email='','-',ifnull(cust_email,'-')) AS email,
						if(cust_tgllahir='','-',ifnull(cust_tgllahir,'-')) AS tgl_lahir,
						if(cust_statusnikah='','-',ifnull(cust_statusnikah,'-')) AS status_nikah,
						/*if(cust_priority='','-',ifnull(cust_priority,'-')) AS priority,*/
						cust_aktif AS status
					from vu_customer";
						
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR cust_alamat LIKE '%".addslashes($filter)."%' OR cust_alamat2 LIKE '%".addslashes($filter)."%' OR cust_telprumah LIKE '%".addslashes($filter)."%' OR cust_telprumah2 LIKE '%".addslashes($filter)."%' OR cust_telpkantor LIKE '%".addslashes($filter)."%' OR cust_hp LIKE '%".addslashes($filter)."%' OR cust_hp2 LIKE '%".addslashes($filter)."%' OR cust_hp3 LIKE '%".addslashes($filter)."%' OR cust_member LIKE '%".addslashes($filter)."%' )";
				$query .= " AND cust_aktif = 'Aktif'";
			} 
			else if($option=='SEARCH'){
			/*untuk pengecekan transaksi*/
			if($cust_transaksi_start!='' and $cust_transaksi_end!=''){
				$string_query_transcust = " between '".$cust_transaksi_start."' and '".$cust_transaksi_end."' ";
			}else if($cust_transaksi_start!='' and $cust_transaksi_end==''){
				$string_query_transcust = " >= '".$cust_transaksi_start."' ";
			}else if($cust_transaksi_start=='' and $cust_transaksi_end!=''){
				$string_query_transcust = " <= '".$cust_transaksi_end."' ";
			}
			
			/*untuk pengecekan yg tidak transaksi*/
			if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " between '".$cust_tidak_transaksi_start."' and '".$cust_tidak_transaksi_end."' ";
			}else if($cust_tidak_transaksi_start!='' and $cust_tidak_transaksi_end==''){
				$string_query_nontranscust = " >= '".$cust_tidak_transaksi_start."' ";
			}else if($cust_tidak_transaksi_start=='' and $cust_tidak_transaksi_end!=''){
				$string_query_nontranscust = " <= '".$cust_tidak_transaksi_end."' ";
			}
			
			/*Utk mengambil cust_id yang melakukan transaksi / yang tidak melakukan transaksi lalu disimpan ke sebuah string */
			if($cust_transaksi_start!='' or $cust_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_transcust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_transcust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_transcust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_transcust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string = $string.','.$string_cust;
				}
			}
			if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!=''){
				$sql = "SELECT distinct(cust_id)
						FROM
						((((
							SELECT distinct(jrawat_cust) as cust_id,
							'rawat' as status
							FROM master_jual_rawat
							WHERE master_jual_rawat.jrawat_stat_dok = 'Tertutup' AND (master_jual_rawat.jrawat_tanggal $string_query_nontranscust) order by cust_id
						)
						union
						(
							SELECT distinct(jpaket_cust) as cust_id,
							'paket' as status
							FROM master_jual_paket
							WHERE master_jual_paket.jpaket_stat_dok = 'Tertutup' AND (master_jual_paket.jpaket_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(jproduk_cust) as cust_id,
							'produk' as status
							FROM master_jual_produk
							WHERE master_jual_produk.jproduk_stat_dok = 'Tertutup' AND (master_jual_produk.jproduk_tanggal $string_query_nontranscust)
						)
						union
						(
							SELECT distinct(dapaket_cust) as cust_id,
							'ambil_paket' as status
							FROM detail_ambil_paket
							WHERE detail_ambil_paket.dapaket_stat_dok = 'Tertutup' AND (detail_ambil_paket.dapaket_tgl_ambil $string_query_nontranscust)
						)
						union
						(
							select distinct
							history_transaksi.thistory_cust as cust_id,
							'prog_lama' AS referal
							from history_transaksi
							left join customer on customer.cust_id = history_transaksi.thistory_cust
							WHERE history_transaksi.thistory_tanggal $string_query_nontranscust AND
							cust_id IS NOT NULL
						)
						)))
						as table_union
						order by cust_id";
				$result_sql = $this->db->query($sql);
				$string_not = '0';
				foreach($result_sql->result() as $row){
					$string_cust=$row->cust_id;
					$string_not = $string_not.','.$string_cust;
				}
			}		
				if($cust_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id LIKE '%".$cust_id."%'";
				};
				if($cust_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_no LIKE '%".$cust_no."%'";
				};
				if($cust_no_awal!=''){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " right(cust_no,6) BETWEEN '".$cust_no_awal."' AND '".$cust_no_akhir."'";
					};
				if($cust_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_nama LIKE '%".$cust_nama."%'";
				};
				if($cust_panggilan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_panggilan LIKE '%".$cust_panggilan."%'";
				};
				if($cust_foreigner!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_foreigner LIKE '%".$cust_foreigner."%'";
				};
				if($cust_kelamin!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kelamin LIKE '%".$cust_kelamin."%'";
				};
				if($cust_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_alamat LIKE '%".$cust_alamat."%' OR cust_alamat2 LIKE '%".$cust_alamat."%'";
				};
				if($cust_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kota LIKE '%".$cust_kota."%'";
				};
				if($cust_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_kodepos LIKE '%".$cust_kodepos."%'";
				};
				if($cust_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_propinsi LIKE '%".$cust_propinsi."%'";
				};
				if($cust_negara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_negara LIKE '%".$cust_negara."%'";
				};
				if($cust_telprumah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_telprumah LIKE '%".$cust_telprumah."%' OR cust_telprumah2 LIKE '%".$cust_telprumah."%' OR cust_telpkantor LIKE '%".$cust_telprumah."%' ";
				};
				if($cust_bb!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_bb LIKE '%".$cust_bb."%'";
				};
				if($cust_email!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_email LIKE '%".$cust_email."%'  OR cust_email2 LIKE '%".$cust_email."%'   ";
				};
				if($cust_agama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_agama LIKE '%".$cust_agama."%'";
				};
				if($cust_pendidikan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_pendidikan LIKE '%".$cust_pendidikan."%'";
				};
				if($cust_profesi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_profesi LIKE '%".$cust_profesi."%'";
				};							
				if($cust_hobi_baca == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,1,1)) = '1'";
				};		
				if($cust_hobi_olah == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,2,1)) = '1'";
				};		
				if($cust_hobi_masak == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,3,1)) = '1'";
				};		
				if($cust_hobi_travel == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,4,1)) = '1'";
				};		
				if($cust_hobi_foto == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,5,1)) = '1'";
				};		
				if($cust_hobi_lukis == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,6,1)) = '1'";
				};		
				if($cust_hobi_nari == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,7,1)) = '1'";
				};		
				if($cust_hobi_lain == 'true'){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " (SELECT SUBSTRING(cust_hobi,8,1)) = '1'";
				};		
				if($cust_referensi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensi LIKE '%".$cust_referensi."%'";
				};
				if($cust_referensilain!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_referensilain LIKE '%".$cust_referensilain."%'";
				};
				if($cust_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_keterangan LIKE '%".$cust_keterangan."%'";
				};
				if($cust_member!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_member LIKE '%".$cust_member."%'";
				};
				if($cust_member2!=''){
					$date_now = date('Y-m-d');
					if($cust_member2=='Semua'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member <> ''";
					} 
					else if($cust_member2=='Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid > '".$date_now."'";
					}
					else if($cust_member2=='Tidak Aktif'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " member_valid < '".$date_now."'";
					}
					else if($cust_member2=='Non Member'){
						$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
						$query.= " cust_member = ''";
					}				
				};			
				if($cust_statusnikah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_statusnikah='".$cust_statusnikah."'";
				};
				if($cust_priority!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_priority='".$cust_priority."'";
				};
				if($cust_jmlanak!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_jmlanak LIKE '%".$cust_jmlanak."%'";
				};
				if($cust_unit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_unit LIKE '%".$cust_unit."%'";
				};
				if($cust_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_aktif = '".$cust_aktif."'";
				};
				if($cust_fretfulness!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_fretfulness LIKE '%".$cust_fretfulness."%'";
				};
				if($sortby=='Nama'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_nama";
				};
				if($sortby=='No Cust'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_no";
				};
				if($sortby=='Alamat'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_alamat";
				};
				if($sortby=='Tgl Lahir'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_tgllahir";
				};
				if($sortby=='Telp Rmh'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_telprumah";
				};
				if($sortby=='Handphone'){
					$query.=eregi("WHERE",$query)?" ":" WHERE ";
					$query.= " ORDER BY cust_hp";
				};
				if($cust_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_creator LIKE '%".$cust_creator."%'";
				};
				if($cust_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_create LIKE '%".$cust_date_create."%'";
				};
				if($cust_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_update LIKE '%".$cust_update."%'";
				};
				if($cust_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_date_update LIKE '%".$cust_date_update."%'";
				};
				if($cust_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_revised LIKE '%".$cust_revised."%'";
				};
				/*search berdasarkan tgl lahir */
				if($cust_tgllahir!='' or $cust_tgllahirend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";				
					if($cust_tgllahir!='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND '".$cust_tgllahirend."'";
					}else if ($cust_tgllahir!='' and $cust_tgllahirend==''){
						$query.= " cust_tgllahir BETWEEN '".$cust_tgllahir."' AND now()";
					}else if ($cust_tgllahir=='' and $cust_tgllahirend!=''){
						$query.= " cust_tgllahir < '".$cust_tgllahirend."'";
					}
				};	
				/*search berdasarkan tgl dan bulan lahir */			
				if($cust_tgl!='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if ($cust_tglEnd!='' and $cust_bulanEnd!=''){
						$query.= " (day(cust_tgllahir) BETWEEN '".$cust_tgl."' AND '".$cust_tglEnd."') AND (month(cust_tgllahir) BETWEEN '".$cust_bulan."' AND '".$cust_bulanEnd."') ";
					}else{
						$query.= " day(cust_tgllahir)='".$cust_tgl."' AND month(cust_tgllahir)='".$cust_bulan."' ";
					}
				}else if($cust_tgl=='' and $cust_bulan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " month(cust_tgllahir)='".$cust_bulan."'";
				};	
				/*search berdasarkan umur*/			
				if($cust_umurstart!='' or $cust_umurend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($cust_umurstart!='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) BETWEEN '".$cust_umurstart."' AND '".$cust_umurend."'";
					}else if ($cust_umurstart!='' and $cust_umurend==''){
						$query.= " (year(now())-year(cust_tgllahir)) > '".$cust_umurstart."'";
					}else if ($cust_umurstart=='' and $cust_umurend!=''){
						$query.= " (year(now())-year(cust_tgllahir)) < '".$cust_umurend."'";
					}
				};			
				/*search berdasarkan transaksi customer*/			
				if($cust_transaksi_start!='' or $cust_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id IN($string)";
				}
				if($cust_tidak_transaksi_start!='' or $cust_tidak_transaksi_end!='')
				{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cust_id NOT IN($string_not)";
				}
				if($cust_terdaftar!='' or $cust_tgldaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					
					if($cust_terdaftar!='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND '".$cust_tgldaftarend."'";
					}else if ($cust_terdaftar!='' and $cust_tgldaftarend==''){
						$query.= " cust_terdaftar BETWEEN '".$cust_terdaftar."' AND now()";
					}else if ($cust_terdaftar=='' and $cust_tgldaftarend!=''){
						$query.= " cust_terdaftar < '".$cust_tgldaftarend."'";
					}	
				};
				/*search berdasarkan tgl transaksi */
				if($cust_tglawaltrans!='' or $cust_tglawaltransend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($cust_tglawaltrans!='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND '".$cust_tglawaltransend."'";
					}else if ($cust_tglawaltrans!='' and $cust_tglawaltrans==''){
						$query.= " cust_tglawaltrans BETWEEN '".$cust_tglawaltrans."' AND now()";
					}else if ($cust_tglawaltrans=='' and $cust_tglawaltrans!=''){
						$query.= " cust_tglawaltrans < '".$cust_tglawaltrans."'";
					}	
				};
				/*search berdasarkan Member Register */
				if($member_terdaftarstart!='' or $member_terdaftarend!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";	
					if($member_terdaftarstart!='' and $member_terdaftarend!=''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND '".$member_terdaftarend."'";
					}else if ($member_terdaftarstart!='' and $member_terdaftarend==''){
						$query.= " member_register BETWEEN '".$member_terdaftarstart."' AND now()";
					}else if ($member_terdaftarstart=='' and $member_terdaftarend!=''){
						$query.= " member_register < '".$member_terdaftarend."'";
					}				
				};		
			}
			
			$query.= " order by cust_id desc ";
			$result = $this->db->query($query);
			return $result;
		}
}
