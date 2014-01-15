<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: tindakan Model
	+ Description	: For record model process back-end
	+ Filename 		: c_tindakan.php
 	+ Author  		: masongbee
 	+ Created on 27/Oct/2009 14:21:34
	
*/

class M_kartu_rekomendasi extends Model{
		
	//constructor
	function M_kartu_rekomendasi() {
		parent::Model();
	}
		
	function get_nonmedis_in_rekomendasi_list($query,$start,$end){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dapp="SELECT distinct(dtrawat_perawatan) FROM tindakan_detail INNER JOIN perawatan ON(dtrawat_perawatan=rawat_id) LEFT JOIN kategori ON(kategori_id=rawat_kategori) WHERE dtrawat_master='$query' AND dtrawat_petugas2='0' AND kategori_nama='Non Medis'";
			$rs=$this->db->query($sql_dapp);
			$rs_rows=$rs->num_rows();
		}
		
		$sql="SELECT * FROM vu_perawatan WHERE kategori_nama='Non Medis' AND rawat_aktif='Aktif'";//join dr tabel: perawatan,produk_group,kategori2,kategori,jenis,gudang
		if($query<>"" && is_numeric($query)==false){
			$sql.=" and (rawat_kode like '%".$query."%' or rawat_nama like '%".$query."%')";
			//$sql.=" and (rawat_kode like '%".$query."%' or rawat_nama like '%".$query."%' or group_nama like '%".$query."%')";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("AND",$query)? " OR ":" AND ";
				foreach($rs->result() as $row_dapp){
					
					$filter.="OR rawat_id='".$row_dapp->dtrawat_perawatan."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		$sql.=" ORDER BY rawat_nama ASC";
	
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		$limit = $sql." LIMIT ".$start.",".$end;			
		//echo $limit;
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
		
	//function for detail
	//get record list
	function detail_rekomendasi_detail_list($master_id,$query,$start,$end) {
		//$query = "SELECT * FROM tindakan_detail,perawatan,karyawan WHERE dtrawat_perawatan=rawat_id AND dtrawat_petugas1=karyawan_id AND dtrawat_master='".$master_id."'";
		//$query="SELECT * FROM tindakan_detail INNER JOIN perawatan ON(dtrawat_perawatan=rawat_id) INNER JOIN karyawan ON(dtrawat_petugas1=karyawan_id) LEFT JOIN kategori ON(rawat_kategori=kategori_id) WHERE dtrawat_master='".$master_id."' AND kategori_nama='Medis'";
		$query="SELECT drawatm_id, drawatm_master, drawatm_perawatan, date_format(drawatm_tanggal,'%Y-%m-%d') as drawatm_tanggal, drawatm_keterangan FROM detail_rekomendasi_medis INNER JOIN perawatan ON(drawatm_perawatan=rawat_id) WHERE drawatm_master='".$master_id."'";
		
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
	//end of function
		
	//get master id, note : not done yet
	function get_master_id() {
		$query = "SELECT max(card_id) as master_id from rekomendasi_card";
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
		
	/* DELETE db.master_jual_rawat IF jrawat_id TIDAK ADA di daftar db.detail_jual_rawat.drawat_master */
	function master_jual_rawat_delete($jrawat_id){
		$sql="SELECT drawat_id FROM detail_jual_rawat WHERE drawat_master='$jrawat_id'";
		$rs=$this->db->query($sql);
		if(!$rs->num_rows()){
			$this->db->where('jrawat_id',$jrawat_id);
			$this->db->delete('master_jual_rawat');
		}
	}
	/* END delete db.master_jual_rawat */
	
	/* DELETE db.detail_jual_rawat IF jrawat_id TIDAK ADA di daftar db.detail_jual_rawat.drawat_master */
	function detail_jual_rawat_delete($dtrawat_id, $dtrawat_dapp){
		/* ambil nilai $jrawat_id */
		$sql="SELECT drawat_master FROM detail_jual_rawat WHERE drawat_dtrawat='$dtrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$jrawat_id=$rs_record["drawat_master"];
			$this->db->where('drawat_dtrawat', $dtrawat_id);
			$this->db->delete('detail_jual_rawat');
			if($this->db->affected_rows()){
				$this->master_jual_rawat_delete($jrawat_id);
				
				$dtu_dapp=array(
				"dapp_locked"=>0
				);
				$this->db->where('dapp_id', $dtrawat_dapp);
				$this->db->update('appointment_detail', $dtu_dapp);
			}
		}
	}
	/* eof detail_jual_rawat_delete */
	
	/* INSERT ke db.detail_jual_rawat */
	function detail_jual_rawat_insert($trawat_id, $cust_member, $card_cust_id, $dtrawat_id, $dtrawat_perawatan_id, $rawat_harga, $rawat_dm, $rawat_du, $dtrawat_dapp){
		/*
		1. check di master_jual_rawat, apakah customer ini pada hari sekarang sudah masuk ke Kasir
		2. JIKA customer ini sudah 'ada' di db.master_jual_rawat ==> INSERT ke db.detail_jual_rawat
		3. JIKA customer ini belum 'ada' di db.master_jual_rawat ==> INSERT ke db.master_jual_rawat AND db.detail_jual_rawat
		4. Proses insert ke db.detail_jual_rawat ini artinya status di db.tindakan_detail.status adalah ='selesai', sehingga db.appointment_detail harus di-LOCKED
		*/
		$date_now=date('Y-m-d');
		
		if($cust_member!=""){
			$diskon_jenis="DM";
			$diskon=$rawat_dm;
		}elseif($cust_member==""){
			$diskon_jenis="DU";
			$diskon=$rawat_du;
		}
		
		$sql="SELECT jrawat_id FROM master_jual_rawat WHERE jrawat_cust='$card_cust_id' AND jrawat_tanggal='$date_now'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			/* artinya: customer yang dimaksud 'sudah masuk' di db.master_jual_rawat pada hari ini
			 * maka Hanya INSERT ke db.detail_jual_rawat
			 */
			$rs_record=$rs->row_array();
			$jrawat_id=$rs_record["jrawat_id"];
			$dti_drawat=array(
			"drawat_master"=>$jrawat_id,
			"drawat_dtrawat"=>$dtrawat_id,
			"drawat_rawat"=>$dtrawat_perawatan_id,
			"drawat_jumlah"=>1,
			"drawat_harga"=>$rawat_harga,
			"drawat_diskon"=>$diskon,
			"drawat_diskon_jenis"=>$diskon_jenis
			);
			$this->db->insert('detail_jual_rawat', $dti_drawat);
			if($this->db->affected_rows()){
				/* Karena db.tindakan_detail.status sudah 'selesai' ==> db.appointment_detail di-LOCKED */
				$dtu_dapp=array(
				"dapp_locked"=>1
				);
				$this->db->where('dapp_id', $dtrawat_dapp);
				$this->db->update('appointment_detail', $dtu_dapp);
				
				/* Checking di db.tindakan_detail WHERE tindakan_detail.dtrawat_master = $trawat_id 
				 * AND kategori = 'Non Medis',
				 * JIKA "ada" ini artinya di menu Tindakan Medis juga menjual Tindakan Non-Medis
				 */
				$sql="SELECT dtrawat_id,dtrawat_perawatan,dtrawat_keterangan,rawat_harga,rawat_dm,rawat_du FROM tindakan_detail INNER JOIN perawatan ON(dtrawat_perawatan=rawat_id) LEFT JOIN kategori ON(rawat_kategori=kategori_id) WHERE dtrawat_master='$trawat_id' AND kategori_nama='Non Medis'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					/* hasilnya "ADA", maka akan ditambahkan ke db.detail_jual_rawat */
					$rs_record=$rs->row_array();
					$dtj_nonmedis_perawatan=$rs_record["dtrawat_perawatan"];
					$dtj_nonmedis_rawat_harga=$rs_record["rawat_harga"];
					if($cust_member!=""){
						$dtj_nonmedis_diskon_jenis="DM";
						$dtj_nonmedis_diskon=$rs_record["rawat_dm"];
					}elseif($cust_member==""){
						$diskon_jenis="DU";
						$dtj_nonmedis_diskon=$rs_record["rawat_du"];
					}
					$data_dtj_nonmedis=array(
					"drawat_master"=>$jrawat_id,
					"drawat_dtrawat"=>$dtrawat_id,
					"drawat_rawat"=>$dtj_nonmedis_perawatan,
					"drawat_jumlah"=>1,
					"drawat_harga"=>$dtj_nonmedis_rawat_harga,
					"drawat_diskon"=>$dtj_nonmedis_diskon,
					"drawat_diskon_jenis"=>$dtj_nonmedis_diskon_jenis
					);
					$sql="SELECT drawat_id FROM detail_jual_rawat WHERE drawat_master='$jrawat_id' AND drawat_rawat='$dtj_nonmedis_perawatan' AND drawat_date_create LIKE '$date_now%'";
					$rs=$this->db->query($sql);
					if(!$rs->num_rows()){
						$this->db->insert('detail_jual_rawat', $data_dtj_nonmedis);
					}
				}
			}
		}else{ 
			/* artinya: di db.master_jual_rawat BELUM ADA */
			/* INSERT to db.master_jual_rawat AND table.detail_jual_rawat */
			$pattern="PR/".date("ym")."-";
			$jrawat_nobukti=$this->m_public_function->get_kode_1('master_jual_rawat','jrawat_nobukti',$pattern,12);
			$data_jrawat=array(
			"jrawat_nobukti"=>$jrawat_nobukti,
			"jrawat_cust"=>$card_cust_id,
			"jrawat_tanggal"=>$date_now
			);
			$this->db->insert('master_jual_rawat', $data_jrawat);
			if($this->db->affected_rows()){
				/* INSERT to db.detail_jual_rawat */
				$sql="SELECT jrawat_id FROM master_jual_rawat WHERE jrawat_cust='$card_cust_id' AND jrawat_tanggal='$date_now'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$jrawat_id=$rs_record["jrawat_id"];
				}
				
				$dti_drawat=array(
				"drawat_master"=>$jrawat_id,
				"drawat_dtrawat"=>$dtrawat_id,
				"drawat_rawat"=>$dtrawat_perawatan_id,
				"drawat_jumlah"=>1,
				"drawat_harga"=>$rawat_harga,
				"drawat_diskon"=>$diskon,
				"drawat_diskon_jenis"=>$diskon_jenis
				);
				$this->db->insert('detail_jual_rawat', $dti_drawat);
				if($this->db->affected_rows()){
					/* Karena db.tindakan_detail.status sudah 'selesai' ==> db.appointment_detail di-LOCKED */
					$dtu_dapp=array(
					"dapp_locked"=>1
					);
					$this->db->where('dapp_id', $dtrawat_dapp);
					$this->db->update('appointment_detail', $dtu_dapp);
					
					/* Checking di db.tindakan_detail WHERE tindakan_detail.dtrawat_master = $trawat_id 
					 * AND kategori = 'Non Medis',
					 * JIKA "ada" ini artinya di menu Tindakan Medis juga menjual Tindakan Non-Medis
					 */
					$sql="SELECT dtrawat_id,dtrawat_perawatan,dtrawat_keterangan,rawat_harga,rawat_dm,rawat_du FROM tindakan_detail INNER JOIN perawatan ON(dtrawat_perawatan=rawat_id) LEFT JOIN kategori ON(rawat_kategori=kategori_id) WHERE dtrawat_master='$trawat_id' AND kategori_nama='Non Medis'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						/* hasilnya "ADA", maka akan ditambahkan ke db.detail_jual_rawat */
						$rs_record=$rs->row_array();
						$dtj_nonmedis_perawatan=$rs_record["dtrawat_perawatan"];
						$dtj_nonmedis_rawat_harga=$rs_record["rawat_harga"];
						if($cust_member!=""){
							$dtj_nonmedis_diskon_jenis="DM";
							$dtj_nonmedis_diskon=$rs_record["rawat_dm"];
						}elseif($cust_member==""){
							$diskon_jenis="DU";
							$dtj_nonmedis_diskon=$rs_record["rawat_du"];
						}
						$data_dtj_nonmedis=array(
						"drawat_master"=>$jrawat_id,
						"drawat_dtrawat"=>$dtrawat_id,
						"drawat_rawat"=>$dtj_nonmedis_perawatan,
						"drawat_jumlah"=>1,
						"drawat_harga"=>$dtj_nonmedis_rawat_harga,
						"drawat_diskon"=>$dtj_nonmedis_diskon,
						"drawat_diskon_jenis"=>$dtj_nonmedis_diskon_jenis
						);
						$sql="SELECT drawat_id FROM detail_jual_rawat WHERE drawat_master='$jrawat_id' AND drawat_rawat='$dtj_nonmedis_perawatan' AND drawat_date_create LIKE '$date_now%'";
						$rs=$this->db->query($sql);
						if(!$rs->num_rows()){
							$this->db->insert('detail_jual_rawat', $data_dtj_nonmedis);
						}
					}
				}
			}
		}
	}
	/* eof detail_jual_rawat_insert */
	
	/* UPDATE db.detail_jual_rawat */
	function detail_jual_rawat_update($dtrawat_perawatan, $dtrawat_id, $cust_member){
		/* ambil data detail dari $dtrawat_perawatan */
		$sql="SELECT rawat_harga, rawat_dm, rawat_du FROM perawatan WHERE rawat_id='$dtrawat_perawatan'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$rawat_harga=$rs_record["rawat_harga"];
			if($cust_member!=""){
				$diskon_jenis="DM";
				$diskon=$rs_record["rawat_dm"];
			}elseif($cust_member==""){
				$diskon_jenis="DU";
				$diskon=$rs_record["rawat_du"];
			}
		}
		
		$dtu_drawat=array(
		"drawat_rawat"=>$dtrawat_perawatan,
		"drawat_harga"=>$rawat_harga,
		"drawat_diskon"=>$diskon,
		"drawat_diskon_jenis"=>$diskon_jenis
		);
		$this->db->where('drawat_dtrawat', $dtrawat_id);
		$this->db->update('detail_jual_rawat', $dtu_drawat);
	}
	/* eof detail_jual_rawat_update */
	
	/* Checking kepemilikan Paket, dengan parameter:
	* 1. id_customer pengguna paket 
	* 2. id_perawatan dari perawatan yang telah dilakukan pada Tindakan Perawatan
	* 3. dengan syarat sisa perawatan masih >0
	*/
	/*function having_rpaket_checking($sjpaket_cust, $rpaket_perawatan){
		$sql="SELECT jpaket_nobukti, apaket_id, apaket_paket, apaket_sisa_paket FROM ((((submaster_jual_paket INNER JOIN master_jual_paket ON(sjpaket_master=jpaket_id)) INNER JOIN master_ambil_paket ON(jpaket_nobukti=apaket_faktur)) INNER JOIN paket ON(apaket_paket=paket_id)) INNER JOIN paket_isi_perawatan ON(paket_id=rpaket_master)) LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id) WHERE sjpaket_cust='$sjpaket_cust' AND rpaket_perawatan='$rpaket_perawatan' AND apaket_sisa_paket>0 LIMIT 1";
		$rs=$this->db->query($sql);
		return $rs;
	}*/
	/* eof having_rpaket_checking */
	
	/* DELETE db.detail_ambil_paket yang otomatis akan UPDATE db.submaster_apaket_item.sapaket_sisa_item = +1 */
	/*function dapaket_sapaket_du($dapaket_dtrawat){
		$sql="UPDATE submaster_apaket_item INNER JOIN detail_ambil_paket ON(submaster_apaket_item.sapaket_master=detail_ambil_paket.dapaket_master AND submaster_apaket_item.sapaket_item=detail_ambil_paket.dapaket_item AND submaster_apaket_item.sapaket_jenis_item='perawatan') SET sapaket_sisa_item =((submaster_apaket_item.sapaket_sisa_item)+1) WHERE detail_ambil_paket.dapaket_dtrawat='$dapaket_dtrawat'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$this->db->where('dapaket_dtrawat',$dapaket_dtrawat);
			$this->db->delete('detail_ambil_paket');
		}
	}*/
	/* eof dapaket_sapaket_du */
	
	function having_cust_member_checking($cust_id){
		$sql="SELECT cust_member FROM customer WHERE cust_id='$cust_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$cust_member=$rs_record["cust_member"];
			return $cust_member;
		}else{
			return '';
		}
	}
	
	/**/
	function kasir_jual_rawat_i($jrawat_cust,$dtrawat_perawatan,$dtrawat_id){
		
		/*Checking di db.master_jual_rawat WHERE jrawat_cust=$card_cust_id AND jrawat_tanggal=$date_now 
		 * Jika SUDAH ADA maka INSERT hanya ke db.detail_jual_rawat
		 * Jika TIDAK ADA maka INSERT ke db.master_jual_rawat AND db.detail_jual_rawat
		 */
		$date_now=date('Y-m-d');
		
		$sql="SELECT jrawat_id FROM master_jual_rawat WHERE jrawat_cust='$jrawat_cust' AND jrawat_tanggal='$date_now'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			/* artinya: di db.master_jual_rawat 'sudah ada', 
			 * maka Hanya INSERT ke db.detail_jual_rawat
			 */
			$rs_record=$rs->row_array();
			$jrawat_id=$rs_record["jrawat_id"];
			
			$sql="SELECT rawat_harga, rawat_dm, rawat_du FROM perawatan WHERE rawat_id='$dtrawat_perawatan'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$rawat_harga=$rs_record["rawat_harga"];
				$rawat_dm=$rs_record["rawat_dm"];
				$rawat_du=$rs_record["rawat_du"];
			}
			
			$cust_member=$this->having_cust_member_checking($jrawat_cust);
			if($cust_member!=""){
				$diskon_jenis="DM";
				
				$data_djrawat=array(
				"drawat_master"=>$jrawat_id,
				"drawat_dtrawat"=>$dtrawat_id,
				"drawat_rawat"=>$dtrawat_perawatan,
				"drawat_jumlah"=>1,
				"drawat_harga"=>$rawat_harga,
				"drawat_diskon"=>$rawat_dm,
				"drawat_diskon_jenis"=>$diskon_jenis
				);
				$this->db->insert('detail_jual_rawat', $data_djrawat);
				
			}else if($cust_member==""){
				$diskon_jenis="DU";
				
				$data_djrawat=array(
				"drawat_master"=>$jrawat_id,
				"drawat_dtrawat"=>$dtrawat_id,
				"drawat_rawat"=>$dtrawat_perawatan,
				"drawat_jumlah"=>1,
				"drawat_harga"=>$rawat_harga,
				"drawat_diskon"=>$rawat_du,
				"drawat_diskon_jenis"=>$diskon_jenis
				);
				$this->db->insert('detail_jual_rawat', $data_djrawat);
				
			}
		}else{ 
			/* artinya: di db.master_jual_rawat BELUM ADA */
			/* INSERT to db.master_jual_rawat AND table.detail_jual_rawat */
			$pattern="PR/".date("ym")."-";
			$jrawat_nobukti=$this->m_public_function->get_kode_1('master_jual_rawat','jrawat_nobukti',$pattern,12);
			$data_jrawat=array(
			"jrawat_nobukti"=>$jrawat_nobukti,
			"jrawat_cust"=>$jrawat_cust,
			"jrawat_tanggal"=>$date_now
			);
			$this->db->insert('master_jual_rawat', $data_jrawat);
			if($this->db->affected_rows()){
				/* INSERT to db.detail_jual_rawat */
				$sql="SELECT jrawat_id FROM master_jual_rawat WHERE jrawat_cust='$jrawat_cust' AND jrawat_tanggal='$date_now'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$jrawat_id=$rs_record["jrawat_id"];
				}
				
				$sql="SELECT rawat_harga, rawat_dm, rawat_du FROM perawatan WHERE rawat_id='$dtrawat_perawatan'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$rawat_harga=$rs_record["rawat_harga"];
					$rawat_dm=$rs_record["rawat_dm"];
					$rawat_du=$rs_record["rawat_du"];
				}
				
				$cust_member=$this->having_cust_member_checking($jrawat_cust);
				if($cust_member!=""){
					$diskon_jenis="DM";
					
					$data_djrawat=array(
					"drawat_master"=>$jrawat_id,
					"drawat_dtrawat"=>$dtrawat_id,
					"drawat_rawat"=>$dtrawat_perawatan,
					"drawat_jumlah"=>1,
					"drawat_harga"=>$rawat_harga,
					"drawat_diskon"=>$rawat_dm,
					"drawat_diskon_jenis"=>$diskon_jenis
					);
					$this->db->insert('detail_jual_rawat', $data_djrawat);
					
				}else if($cust_member==""){
					$diskon_jenis="DU";
					
					$data_djrawat=array(
					"drawat_master"=>$jrawat_id,
					"drawat_dtrawat"=>$dtrawat_id,
					"drawat_rawat"=>$dtrawat_perawatan,
					"drawat_jumlah"=>1,
					"drawat_harga"=>$rawat_harga,
					"drawat_diskon"=>$rawat_du,
					"drawat_diskon_jenis"=>$diskon_jenis
					);
					$this->db->insert('detail_jual_rawat', $data_djrawat);
				}
			}
		}
	
	}
	/**/
	
	/* DIGANTI ke db.history_ambil_paket */
	function kasir_ambil_paket_i($apaket_id, $apaket_paket, $dtrawat_perawatan, $dtrawat_cust, $dtrawat_id){
		/* sebelum insert ke db.detail_ambil_paket, tampung dulu db.submaster_apaket_item.sapaket_sisa_item */
		$sql="SELECT sapaket_sisa_item FROM submaster_apaket_item WHERE sapaket_master='$apaket_id' AND sapaket_item='$dtrawat_perawatan' AND sapaket_jenis_item='perawatan'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$sapaket_sisa_item_temp=$rs_record["sapaket_sisa_item"];
		}
		
		$dti_dapaket=array(
		"dapaket_master"=>$apaket_id,
		"dapaket_dpaket"=>$apaket_paket,
		"dapaket_item"=>$dtrawat_perawatan,
		"dapaket_jumlah"=>1,
		"dapaket_cust"=>$dtrawat_cust,
		"dapaket_dtrawat"=>$dtrawat_id
		);
		$this->db->insert('detail_ambil_paket', $dti_dapaket);
		if($this->db->affected_rows()){
			/* UPDATE db.master_ambil_paket.apaket_sisa_paket = -1 */
			$dtu_sapaket=array(
			"sapaket_sisa_item"=>$sapaket_sisa_item_temp-1
			);
			$this->db->where('sapaket_master', $apaket_id);
			$this->db->where('sapaket_item', $dtrawat_perawatan);
			$this->db->where('sapaket_jenis_item', 'perawatan');
			$this->db->update('submaster_apaket_item', $dtu_sapaket);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	/**/
	
	/* INSERT ke db.history_ambil_paket */
	function history_ambil_paket_insert($dpaket_id, $rpaket_perawatan, $card_cust, $dtrawat_id, $dtrawat_dapp){
		$dti_hapaket=array(
		"hapaket_dpaket"=>$dpaket_id,
		"hapaket_rawat"=>$rpaket_perawatan,
		"hapaket_jumlah"=>1,
		"hapaket_cust"=>$card_cust,
		"hapaket_dtrawat"=>$dtrawat_id
		);
		$this->db->insert('history_ambil_paket', $dti_hapaket);
		if($this->db->affected_rows()){
			/* me-LOCKED db.appointment_detail */
			$dtu_dapp=array(
			"dapp_locked"=>1
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
			
			/* UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'true' */
			$dtu_dtrawat=array(
			"dtrawat_ambil_paket"=>'true'
			);
			$this->db->where('dtrawat_id', $dtrawat_id);
			$this->db->update('tindakan_detail', $dtu_dtrawat);
		}
	}
	/* eof history_ambil_paket_insert */
	
	/* INSERT ke db.history_ambil_paket */
	function history_ambil_paket_delete($dtrawat_id, $dtrawat_dapp){
		$this->db->where('hapaket_dtrawat', $dtrawat_id);
		$this->db->delete('history_ambil_paket');
		if($this->db->affected_rows()){
			/* meng-UNLOCK db.appointment_detail */
			$dtu_dapp=array(
			"dapp_locked"=>0
			);
			$this->db->where('dapp_id', $dtrawat_dapp);
			$this->db->update('appointment_detail', $dtu_dapp);
		}
	}
	/* eof history_ambil_paket_insert */
	
	//purge all detail from master
	function detail_rekomendasi_medisdetail_purge($master_id){
		$sql="DELETE tindakan_detail FROM tindakan_detail INNER JOIN perawatan ON dtrawat_perawatan=rawat_id LEFT JOIN kategori ON rawat_kategori=kategori_id WHERE kategori_nama='Medis' AND dtrawat_master='".$master_id."'";
		$result=$this->db->query($sql);
	}
	//*eof
	
	function detail_rekomendasi_medisdetail_insert($drawatm_id ,$drawatm_master ,$drawatm_perawatan, $drawatm_tanggal, $drawatm_keterangan){
		/* hanya INSERT record tindakan_detail-medis yang baru */
		
		if($drawatm_master=="" || $drawatm_master==NULL){
				$drawatm_master=$this->get_master_id();
			}
		$date_now=date('Y-m-d');
		if(!is_numeric($drawatm_id)){
			$dti_dtrawat=array(
			"drawatm_master"=>$drawatm_master,
			"drawatm_perawatan"=>$drawatm_perawatan,
			//"dtrawat_petugas1"=>$dtrawat_petugas1,
			"drawatm_tanggal"=>$drawatm_tanggal,
			//"dtrawat_jam"=>$dtrawat_jamreservasi,
			"drawatm_keterangan"=>$drawatm_keterangan
			);
			$this->db->insert('detail_rekomendasi_medis', $dti_dtrawat);
		
		}

	}
		
	//insert detail record
	function detail_rekomendasi_medisdetail_insert_temp($dtrawat_id ,$dtrawat_master ,$dtrawat_perawatan ,$dtrawat_petugas1 ,$dtrawat_petugas2 ,$dtrawat_jamreservasi ,$dtrawat_kategori ,$dtrawat_status ,$dtrawat_keterangan ,$dtrawat_ambil_paket ,$dtrawat_cust){
		/* Check Centang checkbox ambil paket 'false'>>'true' atau 'true'>>'false' */
		/* Untuk mengetahui kondisi awal dari db.tindakan_detail.dtrawat_ambil_paket */
		$apaket=0;
		$sql="SELECT dtrawat_ambil_paket FROM tindakan_detail WHERE dtrawat_id='$dtrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			$dtrawat_ambil_paket_awal=$rs_record["dtrawat_ambil_paket"];
		}
		
		$dtrawat_locked=0;
		$sql="SELECT dtrawat_id,dtrawat_locked FROM tindakan_detail WHERE dtrawat_id='$dtrawat_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			/* ini artinya: detail tindakan medis pada Form-Edit sudah masuk dalam db.tindakan_detail, sehingga akan dilakukan editing JIKA record db.tindakan_detail ini UNLOCK */
			$rs_record=$rs->row_array();
			$dtrawat_locked=$rs_record["dtrawat_locked"];
			
			if($dtrawat_status=='selesai' && $dtrawat_ambil_paket_awal=='false' && $dtrawat_ambil_paket=='true' && $dtrawat_locked==0){
				/* boleh dilakukan editing karena belum terjadi transaksi di Kasir */
				/* ini artinya: telah masuk ke tagihan Kasir Perawatan */
				
				/* Checking kepemilikan paket akibat $dtrawat_ambil_paket=='true'(di-centang) */
				$having_rpaket = $this->having_rpaket_checking($dtrawat_cust, $dtrawat_perawatan);
				if($having_rpaket->num_rows()){
					/* 1. DELETE dari Kasir Perawatan */
					/* sebelum men-DELETE db.detail_jual_rawat, ambil terlebih dahulu db.detail_jual_rawat.drawat_master ==> untuk men-DELETE master_jual_rawat JIKA jrawat_id sudah tidak ada dalam daftar db.detail_jual_rawat */
					$sql="SELECT drawat_master FROM detail_jual_rawat WHERE drawat_dtrawat='$dtrawat_id'";
					$rs=$this->db->query($sql);
					$rs_record=$rs->row_array();
					$jrawat_id_temp=$rs_record["drawat_master"];
					
					$this->db->where('drawat_dtrawat',$dtrawat_id);
					$this->db->delete('detail_jual_rawat');
					if($this->db->affected_rows()){
						/* DELETE master_jual_rawat JIKA tidak punya detail di db.detail_jual_rawat */
						$this->master_jual_rawat_delete($jrawat_id_temp);
					}
					
					/* 2. INSERT ke Kasir Pengambilan Paket */
					$having_rpaket_record=$having_rpaket->row();
					
					$apaket_id_temp=$having_rpaket_record->apaket_id;
					$apaket_paket_temp=$having_rpaket_record->apaket_paket;
					/* kasir_ambil_paket_i() ==> DIGANTI ke db.history_ambil_paket */
					$this->history_ambil_paket_insert($dpaket_id, $rpaket_perawatan, $card_cust_id, $dtrawat_id, $dtrawat_dapp);
					return 'Detail telah berhasil ditambahkan';
				}else{
					return "Maaf, Customer ini tidak memiliki paket dari perawatan yang dipilih";
				}
			}elseif($dtrawat_status!='selesai' && $dtrawat_ambil_paket_awal=='false' && $dtrawat_ambil_paket=='true' && $dtrawat_locked==0){
				/* ini artinya: tindakan perawatan ini belum masuk ke Kasir manapun, karena masuk ke Kasir JIKA $dtrawat_status='selesai' */
				$having_rpaket = $this->having_rpaket_checking($dtrawat_cust, $dtrawat_perawatan);
				//$rs_having_rpaket = $having_rpaket->result();
				if($having_rpaket->num_rows()){
					/* UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'true' */
					$dtu_dtrawat=array(
					"dtrawat_ambil_paket"=>'true'
					);
					$this->db->where('dtrawat_id',$dtrawat_id);
					$this->db->update('tindakan_detail',$dtu_dtrawat);
					return 'success';
				}else{
					/* Customer dan Perawatan yang dipilih tidak terdapat dalam kepemilikan Paket */
					return 'Maaf, ada satu atau lebih perawatan yang tidak terdapat dalam kepemilikan paket';
				}
			}elseif($dtrawat_status=='selesai' && $dtrawat_ambil_paket_awal=='true' && $dtrawat_ambil_paket=='false' && $dtrawat_locked==0){
				/* ini artinya: Customer dengan detail perawatan ini telah masuk ke Kasir Pengambilan Paket */
				/* 1. DELETE data pada list Pengambilan Paket ==> DIGANTI ke db.history_ambil_paket */
				$this->history_ambil_paket_delete($dtrawat_id, $dtrawat_dapp);
				
				/* 2. INSERT ke tagihan Kasir Perawatan */
				$this->detail_jual_rawat_insert($trawat_id, $cust_member, $card_cust_id, $dtrawat_id, $dtrawat_perawatan_id, $rawat_harga, $rawat_dm, $rawat_du, $dtrawat_dapp);
				return 'success';
			}elseif($dtrawat_status!='selesai' && $dtrawat_ambil_paket_awal=='true' && $dtrawat_ambil_paket=='false' && $dtrawat_locked==0){
				/* ini artinya: data belum masuk ke Kasir manapun, dan hanya perlu dilakukan update db.tindakan_detail.dtrawat_ambil_paket = 'false' */
				$dtu_dtrawat=array(
				"dtrawat_ambil_paket"=>'false'
				);
				$this->db->where('dtrawat_id',$dtrawat_id);
				$this->db->update('tindakan_detail',$dtu_dtrawat);
				return 'success';
			}
			
		}else{
			$date_now=date('Y-m-d');
			/* artinya: data ini adalah "data baru".
			* Data Baru ini otomatis ber-status='datang', maka db.report_tindakan dari Dokter yang dipilih akan ditambahkan +1
			*/
			/* 
			* JIKA $dtrawat_ambil_paket=true ==> Lakukan Checking di db.submaster_jual_paket,db.master_jual_paket,db.master_ambil_paket WHERE db.submaster_jual_paket.sjpaket_cust=[customer yg diupdate]
			*/
			if($dtrawat_ambil_paket=='true'){
				$having_rpaket = $this->having_rpaket_checking($dtrawat_cust, $dtrawat_perawatan);
				if($having_rpaket->num_rows()){
					/* Customer ini dengan perawatan yang telah dilakukan terdapat pada daftar pemilik paket yang ([total sisa paketnya] > 0) */
					/* Karena CheckBox Pengambilan Paket di-Centang, maka akan dimasukkan ke dalam Daftar Pengambilan Paket sehingga total_sisa_paket akan berkurang */
					$rs_record=$rs->row_array();
					$data_dapaket=array(
					"dapaket_master"=>$rs_record["apaket_id"],
					"dapaket_dpaket"=>$rs_record["apaket_paket"],
					"dapaket_item"=>$dtrawat_perawatan,
					"dapaket_jumlah"=>1,
					"dapaket_cust"=>$dtrawat_cust
					);
					$apaket=1;
					$this->db->insert('detail_ambil_paket', $data_dapaket);
				}
			}
			
			$data=array(
			"dtrawat_master"=>$dtrawat_master,
			"dtrawat_perawatan"=>$dtrawat_perawatan,
			"dtrawat_petugas1"=>$dtrawat_petugas1,
			"dtrawat_tglapp"=>$date_now,
			"dtrawat_jam"=>$dtrawat_jamreservasi,
			"dtrawat_keterangan"=>$dtrawat_keterangan
			);
			if($apaket==1)
					$data["dtrawat_ambil_paket"]=$dtrawat_ambil_paket;
			$this->db->insert('tindakan_detail', $data);
			if($this->db->affected_rows()){
				$bln_now=date('Y-m');
				/* meng-Counter db.report_tindakan dari Dokter yang dipilih */
				$sql="SELECT reportt_jmltindakan FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%' AND reportt_karyawan_id='$dtrawat_petugas1'";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$data_reportt=array(
					"reportt_jmltindakan"=>$rs_record["reportt_jmltindakan"]+1
					);
					$this->db->where('reportt_karyawan_id', $dtrawat_petugas1);
					$this->db->update('report_tindakan', $data_reportt);
				}else if(!$rs->num_rows()){
					$data_reportt=array(
					"reportt_karyawan_id"=>$dtrawat_petugas1,
					"reportt_bln"=>$date_now,
					"reportt_jmltindakan"=>1
					);
					$this->db->insert('report_tindakan', $data_reportt);
				}
				return '1';
			}else {
				return '0';
			}
		}
		
	}
	//end of function
		
		/* START NON-MEDIS Function */
		function rekomendasi_nonmedis_list($master_id,$query,$start,$end) {
			//$query = "SELECT * FROM tindakan_detail,perawatan,karyawan WHERE dtrawat_perawatan=rawat_id AND dtrawat_petugas1=karyawan_id AND dtrawat_master='".$master_id."'";
			$query="SELECT drawatn_id, drawatn_master, drawatn_perawatan, date_format(drawatn_tanggal,'%Y-%m-%d') as drawatn_tanggal, drawatn_keterangan
			FROM detail_rekomendasi_nonmedis
			INNER JOIN perawatan ON(drawatn_perawatan=rawat_id)
			WHERE drawatn_master='".$master_id."'";
		
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
		
		function detail_rekomendasi_nonmedis_detail_purge($master_id){
			$sql="DELETE tindakan_detail FROM tindakan_detail INNER JOIN perawatan ON(dtrawat_perawatan=rawat_id) LEFT JOIN kategori ON(rawat_kategori=kategori_id) WHERE dtrawat_master='".$master_id."' AND kategori_nama='Non Medis'";
			$result=$this->db->query($sql);
		}
		
		function rekomendasi_nonmedisdetail_insert($drawatn_id ,$drawatn_master ,$drawatn_perawatan , $drawatn_tanggal, $drawatn_keterangan){
			//if master id not capture from view then capture it from max pk from master table
			if($drawatn_master=="" || $drawatn_master==NULL){
				$drawatn_master=$this->get_master_id();
			}
			
			if(is_numeric($drawatn_id)==false && is_numeric($drawatn_perawatan)==true){
				$date_now=date('Y-m-d');
				$data = array(
					"drawatn_master"=>$drawatn_master, 
					"drawatn_perawatan"=>$drawatn_perawatan, 
					"drawatn_keterangan"=>$drawatn_keterangan,
					"drawatn_tanggal"=>$drawatn_tanggal,
					//"dtrawat_status"=>"selesai"
				);
				$this->db->insert('detail_rekomendasi_nonmedis', $data); 
				
				
				if($this->db->affected_rows()){
					//$sql="SELECT * FROM tindakan_detail WHERE dtrawat_master='$dtrawat_master' AND ";
					$sql="SELECT rawat_harga,rawat_dm,rawat_du FROM perawatan WHERE rawat_id='$drawatn_perawatan'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$rawat_harga=$rs_record["rawat_harga"];
						$rawat_dm=$rs_record["rawat_dm"];
						$rawat_du=$rs_record["rawat_du"];
					}
				}
								
			}elseif(is_numeric($drawatn_id)==true){
				$sql="SELECT drawatn_id,drawatn_perawatan FROM detail_rekomendasi_nonmedis WHERE drawatn_perawatan='$drawatn_perawatan' AND drawatn_id='$drawatn_id'";
				$rs=$this->db->query($sql);
				if(!$rs->num_rows()){
					$data = array(
					"drawatn_perawatan"=>$drawatn_perawatan, 
					"drawatn_keterangan"=>$drawatn_keterangan
					);
					$this->db->where('drawatn_id',$drawatn_id);
					$this->db->update('detail_rekomendasi_nonmedis',$data);
				}
			}
		}
		/* END NON-MEDIS Function */
		
		function get_produk_list($query,$start,$end){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dproduk_produk FROM detail_jual_produk WHERE dproduk_master='$query'";
			$rs=$this->db->query($sql_dproduk);
			$rs_rows=$rs->num_rows();
		}
		
		$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' or satuan_nama like '%".$query."%' or kategori_nama like '%".$query."%' or group_nama like '%".$query."%') ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("AND",$sql)? " OR ":" AND ";
				foreach($rs->result() as $row_dproduk){
					
					$filter.="OR produk_id='".$row_dproduk->dproduk_produk."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if($end!=0){
			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);
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
				
		function detail_produk_list($master_id,$query,$start,$end) {
			//$query="SELECT *,konversi_nilai FROM detail_jual_produk LEFT JOIN satuan_konversi ON(dproduk_produk=konversi_produk AND dproduk_satuan=konversi_satuan) WHERE dproduk_master='".$master_id."'";
			$query = "SELECT dproduk_id, dproduk_master, dproduk_produk, date_format(dproduk_tanggal,'%Y-%m-%d') as dproduk_tanggal, dproduk_keterangan
			FROM detail_rekomendasi_produk
			INNER JOIN produk ON(dproduk_produk=produk_id)
			WHERE dproduk_master='".$master_id."'";
			
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
		
		function rekomendasi_produkdetail_insert($dproduk_id ,$dproduk_master ,$dproduk_produk , $dproduk_tanggal, $dproduk_keterangan){
			//if master id not capture from view then capture it from max pk from master table
			if($dproduk_master=="" || $dproduk_master==NULL){
				$dproduk_master=$this->get_master_id();
			}
			
			if(is_numeric($dproduk_id)==false && is_numeric($dproduk_produk)==true){
				$date_now=date('Y-m-d');
				$data = array(
					"dproduk_master"=>$dproduk_master, 
					"dproduk_produk"=>$dproduk_produk, 
					"dproduk_keterangan"=>$dproduk_keterangan,
					"dproduk_tanggal"=>$dproduk_tanggal,
					
				);
				$this->db->insert('detail_rekomendasi_produk', $data); 
			}
		}
		
		function detail_produk_purge($master_id){
			$sql="DELETE detail_rekomendasi_produk FROM detail_rekomendasi_produk INNER JOIN produk ON(dproduk_produk=produk_id) WHERE dproduk_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		
		//function for get list record
		function kartu_rekomendasi_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			//$query = "SELECT * FROM vu_tindakan WHERE kategori_nama='Medis' AND dtrawat_tglapp='$date_now'"; //TAMPILAN MEDIS SAJA
			//$query = "SELECT medis.* FROM vu_tindakan medis WHERE (medis.kategori_nama='Medis' OR medis.dtrawat_master IN(SELECT nonmedis.dtrawat_master FROM vu_tindakan nonmedis WHERE nonmedis.kategori_nama='Non Medis' AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND nonmedis.dtrawat_dapp='0')) AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d')";
			//$query = "SELECT * FROM vu_tindakan WHERE date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND (kategori_nama='Medis' OR dtrawat_petugas2='0')";
			$query = "select rekomendasi_card.*,customer.cust_no, customer.cust_nama, karyawan.karyawan_username, karyawan.karyawan_id, karyawan.karyawan_nama
from rekomendasi_card
left join customer on (customer.cust_id=rekomendasi_card.card_cust)
left join karyawan on (karyawan.karyawan_id = rekomendasi_card.card_dokter)";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$limit = $query." LIMIT ".$start.",".$end;		
			//$result = $this->db->query($limit);  
			
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
		
	//function for update record
	function kartu_rekomendasi_update($card_id, $card_cust ,$card_keterangan ,$card_dokter ,$card_tgl, $card_wl1, $card_wl2, $card_wl3, $card_wl4, $card_wl5, $card_wl6, $card_wl7, $card_wl8, $card_wl9, $card_wl10, $card_wl11, $card_wl12, $card_wl13, $card_wl14, $card_wl15, $card_wl16, $card_wl17, $card_wl18, $card_wl19, $card_wl20, $card_wl21, $card_wl22, $mode_edit){
		/* Checking db.tindakan_detail WHERE db.tindakan_detail.dtrawat_id = $dtrawat_id DAN semua Field,
		 * JIKA ada salah satu Field yang berubah maka akan di-UPDATE
		 */ 
		$data=array(
		"card_keterangan"=>$card_keterangan);

			if($card_wl1=='true')
				$data["card_wl1"]=1;
			if($card_wl1=='false')
				$data["card_wl1"]=0;
			if($card_wl2=='true')
				$data["card_wl2"]=1;
			if($card_wl2=='false')
				$data["card_wl2"]=0;
			if($card_wl3=='true')
				$data["card_wl3"]=1;
			if($card_wl3=='false')
				$data["card_wl3"]=0;
			if($card_wl4=='true')
				$data["card_wl4"]=1;
			if($card_wl4=='false')
				$data["card_wl4"]=0;
			if($card_wl5=='true')
				$data["card_wl5"]=1;
			if($card_wl5=='false')
				$data["card_wl5"]=0;
			if($card_wl6=='true')
				$data["card_wl6"]=1;
			if($card_wl6=='false')
				$data["card_wl6"]=0;
			if($card_wl7=='true')
				$data["card_wl7"]=1;
			if($card_wl7=='false')
				$data["card_wl7"]=0;
			if($card_wl8=='true')
				$data["card_wl8"]=1;
			if($card_wl8=='false')
				$data["card_wl8"]=0;
			if($card_wl9=='true')
				$data["card_wl9"]=1;
			if($card_wl9=='false')
				$data["card_wl9"]=0;
			if($card_wl10=='true')
				$data["card_wl10"]=1;
			if($card_wl10=='false')
				$data["card_wl10"]=0;
			if($card_wl11=='true')
				$data["card_wl11"]=1;
			if($card_wl11=='false')
				$data["card_wl11"]=0;
			if($card_wl12=='true')
				$data["card_wl12"]=1;
			if($card_wl12=='false')
				$data["card_wl12"]=0;
			if($card_wl13=='true')
				$data["card_wl13"]=1;
			if($card_wl13=='false')
				$data["card_wl13"]=0;
			if($card_wl14=='true')
				$data["card_wl14"]=1;
			if($card_wl14=='false')
				$data["card_wl14"]=0;
			if($card_wl15=='true')
				$data["card_wl15"]=1;
			if($card_wl15=='false')
				$data["card_wl15"]=0;
			if($card_wl16=='true')
				$data["card_wl16"]=1;
			if($card_wl16=='false')
				$data["card_wl16"]=0;
			if($card_wl17=='true')
				$data["card_wl17"]=1;
			if($card_wl17=='false')
				$data["card_wl17"]=0;
			if($card_wl18=='true')
				$data["card_wl18"]=1;
			if($card_wl18=='false')
				$data["card_wl18"]=0;
			if($card_wl19=='true')
				$data["card_wl19"]=1;
			if($card_wl19=='false')
				$data["card_wl19"]=0;
			if($card_wl20=='true')
				$data["card_wl20"]=1;
			if($card_wl20=='false')
				$data["card_wl20"]=0;
			if($card_wl21=='true')
				$data["card_wl21"]=1;
			if($card_wl21=='false')
				$data["card_wl21"]=0;
			if($card_wl22=='true')
				$data["card_wl22"]=1;
			if($card_wl22=='false')
				$data["card_wl22"]=0;
		
		//"card_dokter"=>$card_dokter
		$this->db->where("card_id", $card_id);
		$this->db->update("rekomendasi_card", $data);
		
		if($mode_edit=="update_list"){
			$sql_check="SELECT card_id,card_keterangan, card_cust, card_dokter, card_locked FROM rekomendasi_card WHERE card_id='$card_id'";
			$rs_check=$this->db->query($sql_check);
			if($rs_check->num_rows()){
				$rs_check_record=$rs_check->row_array();
				$card_locked=$rs_check_record["card_locked"];
				//$dtrawat_perawatan_awal=$rs_check_record["dtrawat_perawatan"];
				$card_dokter_awal=$rs_check_record["card_dokter"];
				$trawat_keterangan_awal=$rs_check_record["card_keterangan"];
				
				$sql="SELECT rawat_id FROM perawatan WHERE rawat_id='$dtrawat_perawatan'";
				$rs=$this->db->query($sql);
				if($rs->num_rows())
					$dtrawat_perawatan=$dtrawat_perawatan;
				else 
					$dtrawat_perawatan=$dtrawat_perawatan_id;
				
				$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='$card_dokter'";
				$rs=$this->db->query($sql);
				if($rs->num_rows())
					$card_dokter=$card_dokter;
				else 
					$card_dokter=$card_dokter_id;
				
				if($dtrawat_status_awal<>$dtrawat_status && $dtrawat_locked==0){ 
					/*artinya: Status BErubah && db.tindakan_detail is UNLOCK
					 * perubahan hanya pada STATUS di mode VIEW.LIST
					 */ 
					$date_now=date('Y-m-d');
					/*$data_tindakan=array(
					"trawat_keterangan"=>$trawat_keterangan
					);
					$this->db->where("trawat_id", $trawat_id);
					$this->db->update("tindakan", $data_tindakan);*/
					
					$data_dtindakan=array(
					"dtrawat_status"=>$dtrawat_status,
					);
					/*$sql="SELECT rawat_id FROM perawatan WHERE rawat_id='$dtrawat_perawatan'";
					$rs=$this->db->query($sql);
					if($rs->num_rows())
						$data_dtindakan["dtrawat_perawatan"]=$dtrawat_perawatan;*/
					
					$this->db->where("card_id", $card_id);
					$this->db->update("rekomendasi_card", $data_dtindakan);
					
					
					if($dtrawat_status_awal!='selesai' && $dtrawat_status=='selesai' && $dtrawat_ambil_paket=='true'){
						/* 
						# status ['!selesai'>>'selesai']: ini artinya bahwa customer dengan perawatan yang terpilih belum masuk ke Kasir manapun dan akan dimasukkan ke Kasir.
						# kemudian checkbox "ambil paket" = 'true', maka ini berarti Customer dengan perawatan yg terpilih sudah di-check kepemilikan paketnya dan memang benar dia punya paket itu, tp untuk akurasi di-check kembali kepemilikan paketnya sebelum dimasukkan ke Kasir Pengambilan Paket:
						1. Checking kepemilikan paket => db.vu_tindakan.cust_punya_paket='ada'
						2. INSERT ke db.history_ambil_paket
						3. UPDATE db.tindakan_detail.status = 'selesai' ==> sudah dilakukan sebelum masuk fungsi IF ini
						*/
						$sql="SELECT cust_punya_paket FROM vu_tindakan WHERE dtrawat_id='$dtrawat_id' AND cust_punya_paket='ada'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							$dti_hapaket=array(
							"hapaket_dpaket"=>$dpaket_id,
							"hapaket_rawat"=>$rpaket_perawatan,
							"hapaket_jumlah"=>1,
							"hapaket_cust"=>$card_cust_id,
							"hapaket_dtrawat"=>$dtrawat_id
							);
							$this->db->insert('history_ambil_paket', $dti_hapaket);
							if($this->db->affected_rows()){
								/* me-LOCKED db.appointment_detail */
								$data_dapp_locked=array(
								"dapp_locked"=>1
								);
								$this->db->where('dapp_id', $dtrawat_dapp);
								$this->db->update('appointment_detail', $data_dapp_locked);
								return '1';
							}else{
								return '0';
							}
						}
					}elseif($dtrawat_status_awal!='selesai' && $dtrawat_status=='selesai' && $dtrawat_ambil_paket=='false'){
						/*
						# status ['!selesai'>>'selesai']: ini artinya bahwa customer dengan perawatan yang terpilih belum masuk ke Kasir manapun dan akan dimasukkan ke Kasir.
						# kemudian checkbox "ambil paket" = 'false', maka ini berarti Customer dengan perawatan yg terpilih akan dimasukkan ke Kasir Perawatan:
						1. INSERT ke db.detail_jual_rawat
						2. UPDATE db.tindakan_detail.status = 'selesai' ==> sudah dilakukan sebelum masuk fungsi IF ini
						*/
						$this->detail_jual_rawat_insert($trawat_id, $cust_member, $card_cust_id, $dtrawat_id, $dtrawat_perawatan_id, $rawat_harga, $rawat_dm, $rawat_du, $dtrawat_dapp);
						return '1';
						
					}elseif($dtrawat_status_awal=='selesai' && $dtrawat_status!='selesai' && $dtrawat_ambil_paket=='true'){
						/*
						# status ['selesai'>>'!selesai']: ini artinya bahwa sebelumnya customer dengan perawatan yang terpilih ini sudah masuk ke Kasir.
						# kemudian checkbox "ambil paket" = 'true', maka ini berarti masuk ke Kasir Pengambilan Paket:
						1. DELETE dari db.history_ambil_paket
						2. UPDATE db.tindakan_detail.status = '!selesai' ==> sudah dilakukan sebelum fungsi IF ini
						3. meng-UNLOCK db.appointment_detail.dapp_locked
						*/
						$this->db->where('hapaket_dtrawat', $dtrawat_id);
						$this->db->delete('history_ambil_paket');
						if($this->db->affected_rows()){
							/* meng-UNLOCK db.appointment_detail */
							$data_dapp_locked=array(
							"dapp_locked"=>0
							);
							$this->db->where('dapp_id', $dtrawat_dapp);
							$this->db->update('appointment_detail', $data_dapp_locked);
							return '1';
						}else{
							return '0';
						}
					}elseif($dtrawat_status_awal=='selesai' && $dtrawat_status!='selesai' && $dtrawat_ambil_paket=='false'){
						/*
						# status ['selesai'>>'!selesai']: ini artinya bahwa sebelumnya customer dengan perawatan yang terpilih ini sudah masuk ke Kasir.
						# kemudian checkbox "ambil paket" = 'false', maka ini berarti masuk ke Kasir Perawatan:
						1. DELETE dari detail_jual_paket
						2. UPDATE db.tindakan_detail.status = '!selesai' ==> sudah dilakukan sebelum fungsi IF ini
						3. meng-UNLOCK db.appointment_detail.dapp_locked
						*/
						$this->detail_jual_rawat_delete($dtrawat_id, $dtrawat_dapp);
						return '1';
					}
					return '1';
				}elseif($dtrawat_ambil_paket_awal=='false' && $dtrawat_ambil_paket=='true' && $dtrawat_status_awal=='selesai'){
					/*
					# status='selesai': ini artinya bahwa customer dengan perawatan yang terpilih sudah masuk ke Kasir Perawatan.
					# kemudian checkbox "ambil paket" diganti dari [false ke true], maka ini berarti perawatan saat tindakan-perawatan ini akan diambilkan dari Paket yang dimiliki Customer sehingga secara otomatis akan memindahkan dari yg sebelumnya di Kasir Perawatan ke Kasir Pengambilan Paket:
					1. Checking kepemilikan paket => db.vu_tindakan.cust_punya_paket='ada'
					2. DELETE dari detail_jual_rawat
					3. INSERT ke db.history_ambil_paket
					4. UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'true'
					*/
					$sql="SELECT cust_punya_paket FROM vu_tindakan WHERE dtrawat_id='$dtrawat_id' AND cust_punya_paket='ada'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$this->detail_jual_rawat_delete($dtrawat_id, $dtrawat_dapp);
						$this->history_ambil_paket_insert($dpaket_id, $rpaket_perawatan, $card_cust_id, $dtrawat_id, $dtrawat_dapp);
						return '1';
					}else{
						return '0';
					}
				}elseif($dtrawat_ambil_paket_awal=='false' && $dtrawat_ambil_paket=='true' && $dtrawat_status_awal!='selesai'){
					/*
					# status='!selesai': ini artinya bahwa customer dengan perawatan yang terpilih belum masuk ke Kasir manapun.
					# kemudian checkbox "ambil paket" diganti dari [false ke true], maka ini berarti perawatan saat tindakan-perawatan ini akan diambilkan dari Paket yang dimiliki Customer ketika statusnya nanti berubah ke 'selesai':
					1. Checking kepemilikan paket => db.vu_tindakan.cust_punya_paket='ada'
					2. UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'true'
					*/
					$sql="SELECT cust_punya_paket FROM vu_tindakan WHERE dtrawat_id='$dtrawat_id' AND cust_punya_paket='ada'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$dtu_dtrawat=array(
						"dtrawat_ambil_paket"=>'true'
						);
						$this->db->where('dtrawat_id', $dtrawat_id);
						$this->db->update('rekomendasi_card', $dtu_dtrawat);
						if($this->db->affected_rows()){
							return '1';
						}else{
							return '0';
						}
					}else{
						return '0';
					}
				}elseif($dtrawat_ambil_paket_awal=='true' && $dtrawat_ambil_paket=='false' && $dtrawat_status_awal=='selesai'){
					/*
					# status='selesai' && checkbox "ambil paket" sebelumnya 'true': ini berarti customer dengan perawatan yang terpilih sudah masuk ke Kasir Pengambilan Paket.
					# kemudian checkbox "ambil paket" diganti dari [true ke false], maka ini berarti Pengambilan Paket di-Batal-kan, dan secara otomatis akan memindahkan dari yg sebelumnya di Kasir Pengambilan Paket ke Kasir Perawatan:
					1. UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'false'
					2. DELETE dari db.history_ambil_paket
					3. INSERT ke db.detail_jual_rawat
					*/
					$dtu_dtrawat=array(
					"dtrawat_ambil_paket"=>'false'
					);
					$this->db->where('dtrawat_id', $dtrawat_id);
					$this->db->update('rekomendasi_card', $dtu_dtrawat);
					
					$this->history_ambil_paket_delete($dtrawat_id, $dtrawat_dapp);
					
					$this->detail_jual_rawat_insert($trawat_id, $cust_member, $card_cust_id, $dtrawat_id, $dtrawat_perawatan_id, $rawat_harga, $rawat_dm, $rawat_du, $dtrawat_dapp);
					return '1';
					
				}elseif($dtrawat_ambil_paket_awal=='true' && $dtrawat_ambil_paket=='false' && $dtrawat_status_awal!='selesai'){
					/*
					# status='!selesai': ini berarti customer dengan perawatan yang terpilih belum masuk ke Kasir manapun.
					# kemudian checkbox "ambil paket" diganti dari [true ke false], maka:
					1. UPDATE db.tindakan_detail.dtrawat_ambil_paket = 'false'
					*/
					$dtu_dtrawat=array(
					"dtrawat_ambil_paket"=>'false'
					);
					$this->db->where('card_id', $card_id);
					$this->db->update('rekomendasi_card', $dtu_dtrawat);
					if($this->db->affected_rows()){
						return '1';
					}else{
						return '0';
					}
					
				}elseif($dtrawat_perawatan_awal<>$dtrawat_perawatan && $dtrawat_locked==0){
					if($dtrawat_ambil_paket=='true' && $dtrawat_status=='selesai'){
						/*
						# ini berarti tindakan perawatan ini sudah masuk ke Kasir Pengambilan Paket, maka:
						1. Checking kepemilikan paket ==> db.vu_tindakan.cust_punya_paket='ada'
						2. JIKA 'ada' ==> UPDATE db.tindakan_detail.dtrawat_perawatan <= [rawat_id pengganti = $dtrawat_perawatan], JIKA 'tidak ada' ==> message
						3. UPDATE db.history_ambil_paket.hapaket_rawat <= [rawat_id pengganti = $dtrawat_perawatan]
						*/
						$sql="SELECT cust_punya_paket FROM vu_tindakan WHERE dtrawat_id='$dtrawat_id' AND cust_punya_paket='ada'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							/* UPDATE db.tindakan_detail */
							$dtu_dtrawat=array(
							"dtrawat_perawatan"=>$dtrawat_perawatan
							);
							$this->db->where('dtrawat_id', $dtrawat_id);
							$this->db->update('rekomendasi_card', $dtu_dtrawat);
							/* UPDATE db.history_ambil_paket */
							$dtu_hapaket=array(
							"hapaket_rawat"=>$dtrawat_perawatan
							);
							$this->db->where('hapaket_dtrawat', $dtrawat_id);
							$this->db->update('history_ambil_paket', $dtu_hapaket);
							return '1';
						}else{
							return '0';
						}
					}elseif($dtrawat_ambil_paket=='true' && $dtrawat_status!='selesai'){
						/*
						# ini artinya tindakan perawatan ini belum masuk ke Kasir manapun:
						1. UDPATE db.tindakan_detail.dtrawat_perawatan = [rawat_id pengganti]
						*/
						$dtu_dtrawat=array(
						"dtrawat_perawatan"=>$dtrawat_perawatan
						);
						$this->db->where('dtrawat_id', $dtrawat_id);
						$this->db->update('rekomendasi_card', $dtu_dtrawat);
						if($this->db->affected_rows()){
							return '1';
						}else{
							return '0';
						}
					}elseif($dtrawat_ambil_paket=='false' && $dtrawat_status=='selesai'){
						/*
						# ini artinya: dari status='selesai', perawatan sebelum diganti sudah masuk ke Kasir Perawatan.
						# untuk itu:
						1. UPDATE db.tindakan_detail.dtrawat_rawat = [rawat_id pengganti]
						2. UPDATE Kasir Perawatan WHERE db.detail_jual_rawat.drawat_dtrawat = db.tindakan_detail.dtrawat_id
						*/
						$dtu_dtrawat=array(
						"dtrawat_perawatan"=>$dtrawat_perawatan
						);
						$this->db->where('dtrawat_id', $dtrawat_id);
						$this->db->update('rekomendasi_card', $dtu_dtrawat);
						
						$this->detail_jual_rawat_update($dtrawat_perawatan, $dtrawat_id, $cust_member);
						return '1';
					}elseif($dtrawat_ambil_paket=='false' && $dtrawat_status!='selesai'){
						/*
						# ini artinya: perawatan ini belum masuk ke Kasir manapun, maka: 
						1. UPDATE db.tindakan_detail.dtrawat_perawatan saja =[rawat_id pengganti]
						*/
						$dtu_dtrawat=array(
						"dtrawat_perawatan"=>$dtrawat_perawatan
						);
						$this->db->where('dtrawat_id', $dtrawat_id);
						$this->db->update('rekomendasi_card', $dtu_dtrawat);
						if($this->db->affected_rows()){
							return '1';
						}else{
							return '0';
						}
					}
					
					return '1';
				}/*elseif($card_dokter_awal<>$card_dokter && $card_locked==0){ /* ada perubahan pada db.tindakan_detail.dtrawat_petugas1 */
					/* UPDATE db.tindakan_detail  
					$data_dtindakan=array(
					"card_dokter"=>$card_dokter
					);
					$this->db->where('card_id', $card_id);
					$this->db->update('rekomendasi_card',$data_dtindakan);
					return '1';
				}*/elseif($trawat_keterangan_awal<>$card_keterangan && $card_locked==0){
					/* ada perubahan keterangan_detail */
					/* UPDATE db.tindakan_detail  */
					$data_dtindakan=array(
					"card_keterangan"=>$card_keterangan
					);
					$this->db->where('card_id', $card_id);
					$this->db->update('rekomendasi_card',$data_dtindakan);
					return '1';
				}elseif($card_locked==1){
					return '2';
				}else{
					return '1';
				}
			}else{
				return '0';
			}
		}else{
			return '1';
		}
	}
		
		//function for create new record
		function kartu_rekomendasi_create($card_cust ,$card_dokter, $card_keterangan, $card_wl1, $card_wl2, $card_wl3, $card_wl4, $card_wl5, $card_wl6, $card_wl7, $card_wl8, $card_wl9, $card_wl10, $card_wl11, $card_wl12, $card_wl13, $card_wl14, $card_wl15, $card_wl16, $card_wl17, $card_wl18, $card_wl19, $card_wl20, $card_wl21, $card_wl22){
			$time_now=date('H:i:s');
			$date_now=date('Y-m-d');
			$data = array(
			"card_cust"=>$card_cust,
			"card_dokter"=>$card_dokter,
			"card_tgl"=>$date_now,
			//"trawat_date_create"=>$date_now,
			"card_keterangan"=>$card_keterangan
			);
			if($card_wl1=='true')
				$data["card_wl1"]=1;
			if($card_wl1=='false')
				$data["card_wl1"]=0;
			if($card_wl2=='true')
				$data["card_wl2"]=1;
			if($card_wl2=='false')
				$data["card_wl2"]=0;
			if($card_wl3=='true')
				$data["card_wl3"]=1;
			if($card_wl3=='false')
				$data["card_wl3"]=0;
			if($card_wl4=='true')
				$data["card_wl4"]=1;
			if($card_wl4=='false')
				$data["card_wl4"]=0;
			if($card_wl5=='true')
				$data["card_wl5"]=1;
			if($card_wl5=='false')
				$data["card_wl5"]=0;
			if($card_wl6=='true')
				$data["card_wl6"]=1;
			if($card_wl6=='false')
				$data["card_wl6"]=0;
			if($card_wl7=='true')
				$data["card_wl7"]=1;
			if($card_wl7=='false')
				$data["card_wl7"]=0;
			if($card_wl8=='true')
				$data["card_wl8"]=1;
			if($card_wl8=='false')
				$data["card_wl8"]=0;
			if($card_wl9=='true')
				$data["card_wl9"]=1;
			if($card_wl9=='false')
				$data["card_wl9"]=0;
			if($card_wl10=='true')
				$data["card_wl10"]=1;
			if($card_wl10=='false')
				$data["card_wl10"]=0;
			if($card_wl11=='true')
				$data["card_wl11"]=1;
			if($card_wl11=='false')
				$data["card_wl11"]=0;
			if($card_wl12=='true')
				$data["card_wl12"]=1;
			if($card_wl12=='false')
				$data["card_wl12"]=0;
			if($card_wl13=='true')
				$data["card_wl13"]=1;
			if($card_wl13=='false')
				$data["card_wl13"]=0;
			if($card_wl14=='true')
				$data["card_wl14"]=1;
			if($card_wl14=='false')
				$data["card_wl14"]=0;
			if($card_wl15=='true')
				$data["card_wl15"]=1;
			if($card_wl15=='false')
				$data["card_wl15"]=0;
			if($card_wl16=='true')
				$data["card_wl16"]=1;
			if($card_wl16=='false')
				$data["card_wl16"]=0;
			if($card_wl17=='true')
				$data["card_wl17"]=1;
			if($card_wl17=='false')
				$data["card_wl17"]=0;
			if($card_wl18=='true')
				$data["card_wl18"]=1;
			if($card_wl18=='false')
				$data["card_wl18"]=0;
			if($card_wl19=='true')
				$data["card_wl19"]=1;
			if($card_wl19=='false')
				$data["card_wl19"]=0;
			if($card_wl20=='true')
				$data["card_wl20"]=1;
			if($card_wl20=='false')
				$data["card_wl20"]=0;
			if($card_wl21=='true')
				$data["card_wl21"]=1;
			if($card_wl21=='false')
				$data["card_wl21"]=0;
			if($card_wl22=='true')
				$data["card_wl22"]=1;
			if($card_wl22=='false')
				$data["card_wl22"]=0;
			
			$this->db->insert('rekomendasi_card', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function kartu_rekomendasi_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the tindakans at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM rekomendasi_card WHERE card_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM rekomendasi_card WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "card_id= ".$pkid[$i];
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
		function kartu_rekomendasi_search($trawat_id ,$card_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$start,$end){
			//full query
			//$query="SELECT * FROM vu_tindakan WHERE kategori_nama='Medis'";
			$query = "SELECT * FROM vu_tindakan WHERE (kategori_nama='Medis' OR dtrawat_petugas2='0')";
			
			if($trawat_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " trawat_id LIKE '%".$trawat_id."%'";
			};
			if($card_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " card_cust LIKE '%".$card_cust."%'";
			};
			if($trawat_rawat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dtrawat_perawatan LIKE '%".$trawat_rawat."%'";
			};
			if($trawat_dokter!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dtrawat_petugas1 LIKE '%".$trawat_dokter."%'";
			};
			if($trawat_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dtrawat_status LIKE '%".$trawat_status."%'";
			};
			if($trawat_tglapp_start!='' && $trawat_tglapp_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dtrawat_tglapp BETWEEN '".$trawat_tglapp_start."' AND '".$trawat_tglapp_end."'";
			}else if($trawat_tglapp_start!='' && $trawat_tglapp_end==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dtrawat_tglapp='".$trawat_tglapp_start."'";
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
		
		//function for print record
		function kartu_rekomendasi_print($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter){
			//full query
			$query="select * from tindakan";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (trawat_id LIKE '%".addslashes($filter)."%' OR card_cust LIKE '%".addslashes($filter)."%' OR card_keterangan LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_id LIKE '%".$trawat_id."%'";
				};
				if($card_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " card_cust LIKE '%".$card_cust."%'";
				};
				if($card_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " card_keterangan LIKE '%".$card_keterangan."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function kartu_rekomendasi_export_excel($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter){
			//full query
			$query="select * from tindakan";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (trawat_id LIKE '%".addslashes($filter)."%' OR card_cust LIKE '%".addslashes($filter)."%' OR card_keterangan LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($trawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " trawat_id LIKE '%".$trawat_id."%'";
				};
				if($card_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " card_cust LIKE '%".$card_cust."%'";
				};
				if($card_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " card_keterangan LIKE '%".$card_keterangan."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>