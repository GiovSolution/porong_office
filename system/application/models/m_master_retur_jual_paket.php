<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: master_retur_jual_paket Model
	+ Description	: For record model process back-end
	+ Filename 		: c_master_retur_jual_paket.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 14:53:56
	
*/

class M_master_retur_jual_paket extends Model{
		
	//constructor
	function M_master_retur_jual_paket() {
		parent::Model();
	}
	
	function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group){
			
		switch($group){
			case "Tanggal": $order_by=" ORDER BY tanggal ASC";break;
			case "Customer": $order_by=" ORDER BY cust_nama ASC";break;
			case "No Faktur": $order_by=" ORDER BY no_bukti ASC";break;
			case "Paket": $order_by=" ORDER BY paket_kode ASC";break;
			case "No Faktur Jual": $order_by=" ORDER BY no_bukti_jual ASC";break;
			default: $order_by=" ORDER BY no_bukti ASC";break;
		}
		
		if($opsi=='rekap'){
			if($periode=='all')
				$sql="SELECT distinct * FROM vu_trans_retur_paket WHERE rpaket_stat_dok<>'Batal' ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT distinct * FROM vu_trans_retur_paket WHERE date_format(tanggal,'%Y-%m')='".$tgl_awal."' 
						AND rpaket_stat_dok<>'Batal' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT distinct * FROM vu_trans_retur_paket WHERE date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
						AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' AND rpaket_stat_dok<>'Batal' ".$order_by;
		}else if($opsi=='detail'){
			if($periode=='all')
				$sql="SELECT * FROM vu_detail_retur_paket_rawat WHERE rpaket_stat_dok<>'Batal' ".$order_by;
			else if($periode=='bulan')
				$sql="SELECT * FROM vu_detail_retur_paket_rawat WHERE date_format(tanggal,'%Y-%m')='".$tgl_awal."' 
						AND  rpaket_stat_dok<>'Batal' ".$order_by;
			else if($periode=='tanggal')
				$sql="SELECT * FROM vu_detail_retur_paket_rawat WHERE date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
						AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' AND rpaket_stat_dok<>'Batal' ".$order_by;
		}
		
		//$this->firephp->log($sql);
		
		$query=$this->db->query($sql);
		return $query->result();
	}
		
	/*function get_rawat_list($query,$start,$end){
		$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dpaket="SELECT dpaket_paket FROM detail_jual_paket WHERE dpaket_master='$query'";
			echo $sql_dpaket;
			$rs=$this->db->query($sql_dpaket);
			$rs_rows=$rs->num_rows();
		}
		
		$sql="SELECT rawat_id
				,rawat_nama
				,rawat_kode
				,((dpaket_harga*((100-dpaket_diskon)/100))*((100-jpaket_diskon)/100)) AS rawat_harga
			FROM paket_isi_perawatan
			LEFT JOIN paket ON(rpaket_master=paket_id)
			LEFT JOIN detail_jual_paket ON(dpaket_paket=paket_id)
			LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id)
			LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id)
			WHERE jpaket_id='$query'";
		
		if($rs_rows){
			$filter="";
			$sql.=eregi("AND",$sql)? " OR ":" AND ";
			foreach($rs->result() as $row_dpaket){
				
				$filter.="OR dpaket_paket='".$row_dpaket->dpaket_paket."' ";
			}
			$sql=$sql."(".substr($filter,2,strlen($filter)).")";
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
	}*/
	
	function get_rawat_list($query,$start,$end){
		$sql="SELECT rawat_id
				,rawat_nama
				,rawat_kode
				,((dpaket_harga*((100-dpaket_diskon)/100))*((100-jpaket_diskon)/100)) AS rawat_harga
			FROM paket_isi_perawatan
				LEFT JOIN paket ON(rpaket_master=paket_id)
				LEFT JOIN detail_jual_paket ON(dpaket_paket=paket_id)
				LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id)
				LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id)
			WHERE jpaket_id='$query'";
			
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
	
	function get_dpaket_byjpaket_list($mode,$jpaket_id,$start,$end){
	$date_now=date('Y-m-d');
		if($mode=='create'){
			$sql = "SELECT vu_dpaket_total_bayar.dpaket_id AS dpaket_id
					,vu_dpaket_total_bayar.dpaket_paket AS dpaket_paket
					,vu_dpaket_total_bayar.paket_nama AS paket_nama
					,(vu_dpaket_total_bayar.bayar_per_detail
						- (ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0) * vu_paket_harga_satu_rawat_now.harga_per_satu)) AS rupiah_retur
					,ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0) AS total_ambil_paket
					,(vu_dpaket_total_bayar.total_isi_paket - ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0)) AS total_sisa_paket
					,vu_paket_harga_satu_rawat_now.harga_per_satu AS harga_per_satu
					, master_jual_paket.jpaket_cashback as voucher, master_jual_paket.jpaket_nobukti as jpaket_nobukti
				FROM vu_dpaket_total_bayar
					LEFT JOIN vu_dapaket_group_dpaket ON(vu_dapaket_group_dpaket.dapaket_dpaket = vu_dpaket_total_bayar.dpaket_id)
					LEFT JOIN vu_paket_harga_satu_rawat_now ON(vu_paket_harga_satu_rawat_now.paket_id=vu_dpaket_total_bayar.dpaket_paket)
					left join detail_jual_paket on (detail_jual_paket.dpaket_id = vu_dpaket_total_bayar.dpaket_id)
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
				WHERE vu_dpaket_total_bayar.jpaket_id='".$jpaket_id."'
					AND vu_dpaket_total_bayar.dpaket_id NOT IN
						(SELECT detail_retur_paket_rawat.drpaket_dpaket
						FROM detail_retur_paket_rawat
							JOIN master_retur_jual_paket ON (drpaket_master = rpaket_id)
						WHERE master_retur_jual_paket.rpaket_stat_dok = 'Tertutup') /*and '".$date_now."' <= (detail_jual_paket.dpaket_kadaluarsa + INTERVAL 1 YEAR)*/";
		}else{
			$sql = "SELECT vu_dpaket_total_bayar.dpaket_id AS dpaket_id
					,vu_dpaket_total_bayar.dpaket_paket AS dpaket_paket
					,vu_dpaket_total_bayar.paket_nama AS paket_nama
					,(vu_dpaket_total_bayar.bayar_per_detail
						- (ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0) * vu_paket_harga_satu_rawat_now.harga_per_satu)) AS rupiah_retur
					,ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0) AS total_ambil_paket
					,(vu_dpaket_total_bayar.total_isi_paket - ifnull(vu_dapaket_group_dpaket.total_ambil_dpaket,0)) AS total_sisa_paket
					,vu_paket_harga_satu_rawat_now.harga_per_satu AS harga_per_satu
					, master_jual_paket.jpaket_cashback as voucher, master_jual_paket.jpaket_nobukti as jpaket_nobukti
				FROM vu_dpaket_total_bayar
					LEFT JOIN vu_dapaket_group_dpaket ON(vu_dapaket_group_dpaket.dapaket_dpaket = vu_dpaket_total_bayar.dpaket_id)
					LEFT JOIN vu_paket_harga_satu_rawat_now ON(vu_paket_harga_satu_rawat_now.paket_id=vu_dpaket_total_bayar.dpaket_paket)
					left join detail_jual_paket on (detail_jual_paket.dpaket_id = vu_dpaket_total_bayar.dpaket_id)
					left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
				WHERE detail_jual_paket.dpaket_master='".$jpaket_id."' /*and '".$date_now."' <= (detail_jual_paket.dpaket_kadaluarsa + INTERVAL 1 YEAR)*/";
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
	
	function get_retur_rawat_list($query,$start,$end){
		//$query = harga perawatan
		/*$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dproduk="SELECT dpaket_paket FROM detail_jual_paket WHERE dpaket_master='$query'";
			$rs=$this->db->query($sql_dproduk);
			$rs_rows=$rs->num_rows();
		}elseif(is_string($query)==true){
			$sql_dproduk="SELECT dpaket_master FROM detail_jual_paket LEFT JOIN master_jual_paket ON(dpaket_master=jproduk_id) WHERE jpaket_nobukti='$query'";
			$rs=$this->db->query($sql_dproduk);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$query=$rs_record["dpaket_master"];
			}
		}*/
		
		$sql="SELECT rawat_id, rawat_nama, rawat_kode, rawat_harga FROM perawatan WHERE rawat_harga<='$query'";
		/*if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' or satuan_nama like '%".$query."%' or kategori_nama like '%".$query."%' or group_nama like '%".$query."%') ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("AND",$sql)? " OR ":" AND ";
				foreach($rs->result() as $row_dpaket){
					
					$filter.="OR dpaket_paket='".$row_dpaket->dpaket_paket."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}*/
		
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
	
	function get_jual_paket_list($query,$start,$end){
		/*$sql="SELECT master_jual_paket.jpaket_id
				,jpaket_nobukti
				,jpaket_tanggal
				,cust_id
				,cust_nama
				,cust_alamat
				,vu_jpaket_total_bayar.jpaket_total_bayar
				,vu_jpaket_total_pakai.jpaket_total_pakai
				,(vu_jpaket_total_bayar.jpaket_total_bayar-vu_jpaket_total_pakai.jpaket_total_pakai) AS jpaket_total_retur
			FROM master_jual_paket
			LEFT JOIN customer ON(jpaket_cust=cust_id)
			LEFT JOIN vu_jpaket_total_bayar ON(vu_jpaket_total_bayar.jpaket_id=master_jual_paket.jpaket_id)
			LEFT JOIN vu_jpaket_total_pakai ON(vu_jpaket_total_pakai.jpaket_id=master_jual_paket.jpaket_id)
			WHERE jpaket_cust=cust_id";*/
		$sql = "SELECT master_jual_paket.jpaket_id
				,master_jual_paket.jpaket_nobukti
				,master_jual_paket.jpaket_cust
				,customer.cust_nama
				,detail_jual_paket.dpaket_paket
				,detail_jual_paket.dpaket_sisa_paket
			FROM detail_jual_paket
				JOIN master_jual_paket
					ON (dpaket_master = jpaket_id)
				JOIN customer
					ON (master_jual_paket.jpaket_cust = customer.cust_id)
			WHERE detail_jual_paket.dpaket_sisa_paket > 0
				AND master_jual_paket.jpaket_stat_dok='Tertutup'
				AND detail_jual_paket.dpaket_id NOT IN (
					SELECT detail_retur_paket_rawat.drpaket_dpaket
					FROM detail_retur_paket_rawat
						JOIN master_retur_jual_paket ON(drpaket_master = rpaket_id)
					WHERE master_retur_jual_paket.rpaket_stat_dok <> 'Batal'
				)";
		if($query<>""){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (master_jual_paket.jpaket_nobukti like '%".$query."%' or customer.cust_nama like '%".$query."%' ) "; 
		}
		$query = $this->db->query($sql);
		$nbrows = $query->num_rows();
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
	
	/* START Detail Retur tokwitansi */
	//get record list
	function drpaket_list($master_id,$query) {
		/* Menampilkan detail paket yang terpakai dari No.Faktur Jual yang terpilih + harga asli dari isi paket*/
		$sql = "SELECT * 
			FROM 
				(
				SELECT dpaket_id 
					,dpaket_master
					,dpaket_paket
					,dpaket_jumlah
					,rpaket_perawatan
					,rawat_nama
					,rawat_harga
					,rpaket_jumlah
					,(dpaket_jumlah*rpaket_jumlah) AS total_isi_item
				FROM (detail_jual_paket
				INNER JOIN paket_isi_perawatan ON(rpaket_master=dpaket_paket))
				LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id)
				WHERE dpaket_master='$master_id'
				) AS total_milik
			LEFT JOIN 
				(
				SELECT dapaket_dpaket 
					,dapaket_paket 
					,dapaket_item
					,dapaket_keterangan 
					,sum(dapaket_jumlah) AS total_ambil_item 
				FROM detail_ambil_paket 
				WHERE dapaket_jpaket='$master_id'
				GROUP BY dapaket_item
					,dapaket_dpaket
				) as vu_total_pakai on(vu_total_pakai.dapaket_dpaket=total_milik.dpaket_id 
					and vu_total_pakai.dapaket_item=total_milik.rpaket_perawatan)
			WHERE total_ambil_item>0";
			
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
	//end of function
	
	function drpaket_tokwitansi_list($rpaket_id){
		/* Menampilkan detail paket yang telah di-Retur dari No.Faktur Jual yang terpilih */
		/*$sql = "SELECT detail_jual_paket.dpaket_id AS dpaket_id
				,paket.paket_nama AS paket_nama
				,(((detail_jual_paket.dpaket_jumlah * detail_jual_paket.dpaket_harga) * ((100 - detail_jual_paket.dpaket_diskon) / 100))
					- (ifnull(sum(detail_ambil_paket.dapaket_jumlah), 0) * (detail_jual_paket.dpaket_harga / paket.paket_jmlisi)))
					AS rupiah_retur
				,ifnull(sum(detail_ambil_paket.dapaket_jumlah), 0) AS total_ambil_paket
				,(paket.paket_jmlisi - ifnull(sum(detail_ambil_paket.dapaket_jumlah), 0)) AS total_sisa_paket
				,(detail_jual_paket.dpaket_harga / paket.paket_jmlisi) AS harga_per_satu
		   FROM detail_retur_paket_rawat
				JOIN master_retur_jual_paket ON(detail_retur_paket_rawat.drpaket_master = master_retur_jual_paket.rpaket_id)
				JOIN detail_jual_paket ON(detail_jual_paket.dpaket_id = detail_retur_paket_rawat.drpaket_dpaket)
				JOIN paket ON(detail_jual_paket.dpaket_paket = paket.paket_id)
				LEFT JOIN detail_ambil_paket ON((detail_jual_paket.dpaket_id = detail_ambil_paket.dapaket_dpaket)
					AND (detail_ambil_paket.dapaket_stat_dok <> 'Batal'))
			WHERE master_retur_jual_paket.rpaket_nobuktijual = '".$jpaket_id."'
			GROUP BY detail_ambil_paket.dapaket_dpaket";*/
		$sql = "SELECT detail_retur_paket_rawat.drpaket_id
				,detail_retur_paket_rawat.drpaket_dpaket
				,detail_retur_paket_rawat.drpaket_paket
				,paket.paket_nama AS paket_nama
				,detail_retur_paket_rawat.drpaket_rupiah_retur
				,detail_retur_paket_rawat.drpaket_jumlah_terambil
				,detail_retur_paket_rawat.drpaket_jumlah_diretur
				,detail_retur_paket_rawat.drpaket_harga_satu
		   FROM detail_retur_paket_rawat
				JOIN master_retur_jual_paket ON(detail_retur_paket_rawat.drpaket_master = master_retur_jual_paket.rpaket_id)
				JOIN paket ON(detail_retur_paket_rawat.drpaket_paket = paket.paket_id)
			WHERE master_retur_jual_paket.rpaket_id = '".$rpaket_id."'";
			
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
	
	//purge all detail from master
	function detail_retur_paket_tokwitansi_purge($master_id){
		$sql="DELETE from detail_retur_paket_rawat where drpaket_master='".$master_id."'";
		$result=$this->db->query($sql);
	}
	//*eof
	
	//insert detail record
	/*function detail_retur_paket_tokwitansi_insert($drpaket_id ,$drpaket_master ,$drpaket_rawat ,$drpaket_jumlah ,$drpaket_harga ){
		//if master id not capture from view then capture it from max pk from master table
		if($drpaket_master=="" || $drpaket_master==NULL){
			$drpaket_master=$this->get_master_id();
		}
		
		$data = array(
			"drpaket_master"=>$drpaket_master, 
			"drpaket_rawat"=>$drpaket_rawat, 
			"drpaket_jumlah"=>$drpaket_jumlah, 
			"drpaket_harga"=>$drpaket_harga 
		);
		$this->db->insert('detail_retur_paket_rawat', $data); 
		if($this->db->affected_rows())
			return '1';
		else
			return '0';

	}*/
	//end of function
	
	//insert detail record
	/*function detail_retur_paket_tokwitansi_insert($drpaket_master ){
		//if master id not capture from view then capture it from max pk from master table
		if($drpaket_master=="" || $drpaket_master==NULL){
			$drpaket_master=$this->get_master_id();
		}
		
		//* ambil db.master_retur_jual_paket.rpaket_nobuktijual (identik = db.master_jual_paket.jpaket_id) /
		$sql = "SELECT rpaket_nobuktijual, rpaket_cust FROM master_retur_jual_paket WHERE rpaket_id='$drpaket_master'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$drpaket_jpaket = $record['rpaket_nobuktijual'];
			$rpaket_cust = $record['rpaket_cust'];
		}
		
		//* ambil sisa perawatan yang belum diambil di Paket yang dimiliki Customer /
		$sql = "SELECT *, (total_milik.total_isi_item - if((vu_total_pakai.total_ambil_item<>'null'),vu_total_pakai.total_ambil_item,0)) AS sisa 
			FROM 
				(
				SELECT dpaket_id 
					,dpaket_master
					,dpaket_paket
					,dpaket_jumlah
					,rpaket_perawatan
					,rawat_nama
					,rawat_harga
					,rpaket_jumlah
					,(dpaket_jumlah*rpaket_jumlah) AS total_isi_item
				FROM (detail_jual_paket
				INNER JOIN paket_isi_perawatan ON(rpaket_master=dpaket_paket))
				LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id)
				WHERE dpaket_master='$drpaket_jpaket'
				) AS total_milik
			LEFT JOIN 
				(
				SELECT dapaket_dpaket 
					,dapaket_paket 
					,dapaket_item 
					,sum(dapaket_jumlah) AS total_ambil_item 
				FROM detail_ambil_paket 
				WHERE dapaket_jpaket='$drpaket_jpaket'
				GROUP BY dapaket_item
					,dapaket_dpaket
				) as vu_total_pakai on(vu_total_pakai.dapaket_dpaket=total_milik.dpaket_id 
					and vu_total_pakai.dapaket_item=total_milik.rpaket_perawatan)
			WHERE (total_milik.total_isi_item - if((vu_total_pakai.total_ambil_item<>'null'),vu_total_pakai.total_ambil_item,0)) > 0";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			foreach($rs->result() as $row){
				$dti_drpaket = array(
					"drpaket_master"=>$drpaket_master,
					"drpaket_jpaket"=>$row->dpaket_master,
					"drpaket_dpaket"=>$row->dpaket_id,
					"drpaket_rawat"=>$row->rpaket_perawatan,
					"drpaket_jumlah"=>$row->sisa
				);
				$this->db->insert('detail_retur_paket_rawat', $dti_drpaket);
				
				//* mencatat juga ke db.detail_ambil_paket dengan status 'retur' /
				$dti_dapaket = array(
				"dapaket_dpaket"=>$row->dpaket_id,
				"dapaket_jpaket"=>$row->dpaket_master,
				"dapaket_paket"=>$row->dpaket_paket,
				"dapaket_item"=>$row->rpaket_perawatan,
				"dapaket_jenis_item"=>'perawatan',
				"dapaket_jumlah"=>$row->sisa,
				"dapaket_cust"=>$rpaket_cust,
				"dapaket_keterangan"=>'retur'
				);
				$this->db->insert('detail_ambil_paket', $dti_dapaket);
				
			}
			return '1';
		}else{
			return '0';
		}
		
	}*/
	//end of function
	
	function detail_retur_paket_tokwitansi_insert($array_drpaket_id
												,$drpaket_master
												,$drpaket_jpaket
												,$drpaket_cust
												,$array_drpaket_dpaket
												,$array_drpaket_paket
												,$array_drpaket_jumlah_terambil
												,$array_drpaket_harga_satu
												,$array_drpaket_jumlah_diretur
												,$array_drpaket_rupiah_retur
												,$drpaket_tanggal){
		//if master id not capture from view then capture it from max pk from master table
		if($drpaket_master=="" || $drpaket_master==NULL || $drpaket_master==0){
			$drpaket_master=$this->get_master_id();
		}
		
		//INSERT to db.detail_retur_paket_rawat
		$size_array = sizeof($array_drpaket_dpaket) - 1;
		
		for($i = 0; $i < sizeof($array_drpaket_dpaket); $i++){
			$drpaket_id = $array_drpaket_id[$i];
			$drpaket_dpaket = $array_drpaket_dpaket[$i];
			$drpaket_paket = $array_drpaket_paket[$i];
			$drpaket_jumlah_terambil = $array_drpaket_jumlah_terambil[$i];
			$drpaket_harga_satu = $array_drpaket_harga_satu[$i];
			$drpaket_jumlah_diretur = $array_drpaket_jumlah_diretur[$i];
			$drpaket_rupiah_retur = $array_drpaket_rupiah_retur[$i];
			
			if($drpaket_id==0){
				//INSERT BARU to db.detail_retur_paket_rawat
				$dti_drpaket = array(
					"drpaket_master"=>$drpaket_master,
					"drpaket_jpaket"=>$drpaket_jpaket,
					"drpaket_dpaket"=>$drpaket_dpaket,
					"drpaket_paket"=>$drpaket_paket,
					"drpaket_jumlah_diretur"=>$drpaket_jumlah_diretur,
					"drpaket_jumlah_terambil"=>$drpaket_jumlah_terambil,
					"drpaket_harga_satu"=>$drpaket_harga_satu,
					"drpaket_rupiah_retur"=>$drpaket_rupiah_retur
				);
				$this->db->insert('detail_retur_paket_rawat', $dti_drpaket);
				
				//* mencatat juga ke db.detail_ambil_paket dengan status 'retur' /
				$sqli = "INSERT INTO detail_ambil_paket (dapaket_dpaket
						,dapaket_jpaket
						,dapaket_paket
						,dapaket_item
						,dapaket_jenis_item
						,dapaket_jumlah
						,dapaket_cust
						,dapaket_keterangan
						,dapaket_tgl_ambil
						,dapaket_stat_dok)
					VALUES ('".$drpaket_dpaket."'
						,'".$drpaket_jpaket."'
						,'".$drpaket_paket."'
						,(SELECT rpaket_perawatan
							FROM paket_isi_perawatan
							WHERE rpaket_master='".$drpaket_paket."'
								AND rpaket_jumlah>0 LIMIT 1)
						,'perawatan'
						,'".$drpaket_jumlah_diretur."'
						,'".$drpaket_cust."'
						,''
						,'".$drpaket_tanggal."'
						,'RETUR'
						)";
				$this->db->query($sqli);
				if($this->db->affected_rows()){
					$sqlu = "UPDATE detail_jual_paket
						SET dpaket_sisa_paket=0
						WHERE dpaket_id='".$drpaket_dpaket."'";
					$this->db->query($sqlu);
				}
				if($i==$size_array){
					return 1;
				}
			}else{
				if($i==$size_array){
					return 1;
				}
			}
		}
		
		
		//* ambil db.master_retur_jual_paket.rpaket_nobuktijual (identik = db.master_jual_paket.jpaket_id) /
		/*$sql = "SELECT rpaket_nobuktijual, rpaket_cust FROM master_retur_jual_paket WHERE rpaket_id='$drpaket_master'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$drpaket_jpaket = $record['rpaket_nobuktijual'];
			$rpaket_cust = $record['rpaket_cust'];
		}
		
		//* ambil sisa perawatan yang belum diambil di Paket yang dimiliki Customer /
		$sql = "SELECT *, (total_milik.total_isi_item - if((vu_total_pakai.total_ambil_item<>'null'),vu_total_pakai.total_ambil_item,0)) AS sisa 
			FROM 
				(
				SELECT dpaket_id 
					,dpaket_master
					,dpaket_paket
					,dpaket_jumlah
					,rpaket_perawatan
					,rawat_nama
					,rawat_harga
					,rpaket_jumlah
					,(dpaket_jumlah*rpaket_jumlah) AS total_isi_item
				FROM (detail_jual_paket
				INNER JOIN paket_isi_perawatan ON(rpaket_master=dpaket_paket))
				LEFT JOIN perawatan ON(rpaket_perawatan=rawat_id)
				WHERE dpaket_master='$drpaket_jpaket'
				) AS total_milik
			LEFT JOIN 
				(
				SELECT dapaket_dpaket 
					,dapaket_paket 
					,dapaket_item 
					,sum(dapaket_jumlah) AS total_ambil_item 
				FROM detail_ambil_paket 
				WHERE dapaket_jpaket='$drpaket_jpaket'
				GROUP BY dapaket_item
					,dapaket_dpaket
				) as vu_total_pakai on(vu_total_pakai.dapaket_dpaket=total_milik.dpaket_id 
					and vu_total_pakai.dapaket_item=total_milik.rpaket_perawatan)
			WHERE (total_milik.total_isi_item - if((vu_total_pakai.total_ambil_item<>'null'),vu_total_pakai.total_ambil_item,0)) > 0";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			foreach($rs->result() as $row){
				$dti_drpaket = array(
					"drpaket_master"=>$drpaket_master,
					"drpaket_jpaket"=>$row->dpaket_master,
					"drpaket_dpaket"=>$row->dpaket_id,
					"drpaket_rawat"=>$row->rpaket_perawatan,
					"drpaket_jumlah"=>$row->sisa
				);
				$this->db->insert('detail_retur_paket_rawat', $dti_drpaket);
				
				//* mencatat juga ke db.detail_ambil_paket dengan status 'retur' /
				$dti_dapaket = array(
				"dapaket_dpaket"=>$row->dpaket_id,
				"dapaket_jpaket"=>$row->dpaket_master,
				"dapaket_paket"=>$row->dpaket_paket,
				"dapaket_item"=>$row->rpaket_perawatan,
				"dapaket_jenis_item"=>'perawatan',
				"dapaket_jumlah"=>$row->sisa,
				"dapaket_cust"=>$rpaket_cust,
				"dapaket_keterangan"=>'retur'
				);
				$this->db->insert('detail_ambil_paket', $dti_dapaket);
				
			}
			return '1';
		}else{
			return '0';
		}*/
		
	}
	/* END Detail Retur tokwitansi */
	
	/* START Detail Retur torawat */
	//get record list
	/*function detail_detail_retur_paket_rawat_list($master_id,$query,$start,$end) {
		$query = "SELECT * FROM detail_retur_paket_rawat where drpaket_master='".$master_id."'";
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
	
	//purge all detail from master
	function detail_detail_retur_paket_rawat_purge($master_id){
		$sql="DELETE from detail_retur_paket_rawat where drpaket_master='".$master_id."'";
		$result=$this->db->query($sql);
	}
	//eof
	
	//insert detail record
	function detail_detail_retur_paket_rawat_insert($drpaket_id ,$drpaket_master ,$drpaket_rawat ,$drpaket_jumlah ,$drpaket_harga ){
		//if master id not capture from view then capture it from max pk from master table
		if($drpaket_master=="" || $drpaket_master==NULL){
			$drpaket_master=$this->get_master_id();
		}
		
		$data = array(
			"drpaket_master"=>$drpaket_master, 
			"drpaket_rawat"=>$drpaket_rawat, 
			"drpaket_jumlah"=>$drpaket_jumlah, 
			"drpaket_harga"=>$drpaket_harga 
		);
		$this->db->insert('detail_retur_paket_rawat', $data); 
		if($this->db->affected_rows())
			return '1';
		else
			return '0';

	}
	//end of function*/
	/* END Detail Retur torawat */
	
	//get master id, note : not done yet
	function get_master_id() {
		$query = "SELECT max(rpaket_id) AS master_id FROM master_retur_jual_paket WHERE rpaket_creator='".@$_SESSION[SESSION_USERID]."'";
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
	
	//function for get list record
	function master_retur_jual_paket_list($filter,$start,$end){
//		$query = "SELECT * FROM master_retur_jual_paket,customer,master_jual_paket WHERE rpaket_cust=cust_id AND rpaket_nobuktijual=jpaket_id";
	
		$query = "SELECT rpaket_id
				,rpaket_nobukti
				,jpaket_id
				,jpaket_nobukti
				,cust_no
				,cust_nama
				,cust_id
				,rpaket_tanggal
				,rpaket_keterangan
				,kwitansi_nilai
				,rpaket_stat_dok
				,rpaket_creator
				,rpaket_date_create
				,rpaket_update
				,rpaket_date_update
				,rpaket_revised
				,jpaket_bayar
				,rpaket_voucher
			FROM master_retur_jual_paket
			LEFT JOIN customer ON(master_retur_jual_paket.rpaket_cust = customer.cust_id)
			LEFT JOIN master_jual_paket ON(master_retur_jual_paket.rpaket_nobuktijual = master_jual_paket.jpaket_id)
			LEFT JOIN cetak_kwitansi ON(cetak_kwitansi.kwitansi_ref = master_retur_jual_paket.rpaket_nobukti)";
	
		// For simple search
		if ($filter<>""){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR rpaket_nobukti LIKE '%".addslashes($filter)."%' OR jpaket_nobukti LIKE '%".addslashes($filter)."%' )";
		}
		
		$query .= ' ORDER BY rpaket_nobukti DESC ';
		
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
	function master_retur_jual_paket_update($rpaket_id ,$rpaket_nobukti ,$rpaket_nobuktijual ,$rpaket_cust ,$rpaket_tanggal ,$rpaket_keterangan, $rpaket_stat_dok ){
		$data = array(
			"rpaket_id"=>$rpaket_id, 
			"rpaket_nobukti"=>$rpaket_nobukti, 
			//"rpaket_nobuktijual"=>$rpaket_nobuktijual, 
			"rpaket_cust"=>$rpaket_cust, 
			"rpaket_tanggal"=>$rpaket_tanggal, 
			"rpaket_keterangan"=>$rpaket_keterangan,
			"rpaket_stat_dok"=>$rpaket_stat_dok
		);
		$sql="SELECT jpaket_id FROM master_jual_paket WHERE jpaket_id='".$rpaket_nobuktijual."'";
		$rs=$this->db->query($sql);
		if($rs->num_rows())
			$data["rpaket_nobuktijual"]=$rpaket_nobuktijual;
		
		$this->db->where('rpaket_id', $rpaket_id);
		$this->db->update('master_retur_jual_paket', $data);
		
		return '1';
	}
	
	//function for create new record
	function master_retur_jual_paket_create($rpaket_nobukti ,$rpaket_nobuktijual ,$rpaket_cust ,$rpaket_tanggal ,$rpaket_keterangan ,$rpaket_stat_dok, $rpaket_kwitansi_nilai ,$rpaket_kwitansi_keterangan, $rpaket_voucher ){
		//* karena retur paket langsung print kuitansi maka $rpaket_stat_dok='Tertutup' /
		$rpaket_stat_dok='Tertutup';
		//$pattern="RPK/".date("ym")."-";
		$pattern="RP/".date("ym")."-";
		$rpaket_nobukti=$this->m_public_function->get_kode_1('master_retur_jual_paket','rpaket_nobukti',$pattern,12);
		
		$data = array(
			"rpaket_nobukti"=>$rpaket_nobukti, 
			"rpaket_nobuktijual"=>$rpaket_nobuktijual, 
			"rpaket_cust"=>$rpaket_cust, 
			"rpaket_tanggal"=>$rpaket_tanggal, 
			"rpaket_keterangan"=>$rpaket_keterangan,
			"rpaket_stat_dok"=>$rpaket_stat_dok,
			"rpaket_voucher"=>$rpaket_voucher,
			"rpaket_creator"=>@$_SESSION[SESSION_USERID]
		);
		$this->db->insert('master_retur_jual_paket', $data); 
		if($this->db->affected_rows()){
			$pattern="KU/".date('ym')."-";
			$kwitansi_no=$this->m_public_function->get_kode_1("cetak_kwitansi","kwitansi_no",$pattern,12);
			$dti_kwitansi=array(
			"kwitansi_no"=>$kwitansi_no, 
			"kwitansi_cust"=>$rpaket_cust,
			"kwitansi_tanggal"=>$rpaket_tanggal,
			"kwitansi_ref"=>$rpaket_nobukti, 
			"kwitansi_cara"=>'retur',
			"kwitansi_bayar"=>$rpaket_kwitansi_nilai,
			"kwitansi_nilai"=>$rpaket_kwitansi_nilai,
			"kwitansi_sisa"=>$rpaket_kwitansi_nilai,
			"kwitansi_keterangan"=>$rpaket_kwitansi_keterangan, 
			"kwitansi_status"=>'Tertutup',
			"kwitansi_creator"=>@$_SESSION[SESSION_USERID]
			);
			$this->db->insert('cetak_kwitansi', $dti_kwitansi);
			if($this->db->affected_rows()){
				return $rpaket_nobukti;
			}else{
				return '1';
			}
		}else
			return '0';
	}
	
	//fcuntion for delete record
	function master_retur_jual_paket_delete($pkid){
		// You could do some checkups here and return '0' or other error consts.
		// Make a single query to delete all of the master_retur_jual_pakets at the same time :
		if(sizeof($pkid)<1){
			return '0';
		} else if (sizeof($pkid) == 1){
			$query = "DELETE FROM master_retur_jual_paket WHERE rpaket_id = ".$pkid[0];
			$this->db->query($query);
		} else {
			$query = "DELETE FROM master_retur_jual_paket WHERE ";
			for($i = 0; $i < sizeof($pkid); $i++){
				$query = $query . "rpaket_id= ".$pkid[$i];
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
	function master_retur_jual_paket_search($rpaket_nobukti ,$rpaket_nobuktijual ,$rpaket_cust ,$rpaket_tanggal , $rpaket_tanggal_akhir, $rpaket_keterangan ,$rpaket_stat_dok, $start,$end){
		//full query
		$query="SELECT rpaket_id
				,rpaket_nobukti
				,jpaket_id
				,jpaket_nobukti
				,cust_no
				,cust_nama
				,cust_id
				,rpaket_tanggal
				,rpaket_keterangan
				,kwitansi_nilai
				,rpaket_stat_dok
				,rpaket_creator
				,rpaket_date_create
				,rpaket_update
				,rpaket_date_update
				,rpaket_revised
				,jpaket_bayar
				,rpaket_voucher
			FROM master_retur_jual_paket
			LEFT JOIN customer ON(master_retur_jual_paket.rpaket_cust = customer.cust_id)
			LEFT JOIN master_jual_paket ON(master_retur_jual_paket.rpaket_nobuktijual = master_jual_paket.jpaket_id)
			LEFT JOIN cetak_kwitansi ON(cetak_kwitansi.kwitansi_ref = master_retur_jual_paket.rpaket_nobukti)";
		
		if($rpaket_nobukti!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rpaket_nobukti LIKE '%".$rpaket_nobukti."%'";
		};
		if($rpaket_nobuktijual!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rpaket_nobuktijual LIKE '%".$rpaket_nobuktijual."%'";
		};
		if($rpaket_cust!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rpaket_cust = '".$rpaket_cust."'";
		};
		if($rpaket_tanggal!='' && $rpaket_tanggal_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_tanggal BETWEEN '".$rpaket_tanggal."' AND '".$rpaket_tanggal_akhir."'";
			}
		else if($rpaket_tanggal!='' && $rpaket_tanggal_akhir==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_tanggal='".$rpaket_tanggal."'";
			}
		if($rpaket_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rpaket_keterangan LIKE '%".$rpaket_keterangan."%'";
		};
		
		if($rpaket_stat_dok!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rpaket_stat_dok = '".$rpaket_stat_dok."'";
		};
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
	function master_retur_jual_paket_print($rpaket_nobukti
											,$rpaket_nobuktijual
											,$rpaket_cust
											,$rpaket_tanggal
											,$rpaket_tanggal_akhir
											,$rpaket_keterangan
											,$rpaket_stat_dok
											,$option
											,$filter){
		//full query
		$query="SELECT rpaket_tanggal
				,rpaket_nobukti
				,jpaket_nobukti
				,cust_no
				,cust_nama
				,kwitansi_nilai
				,rpaket_keterangan
				,rpaket_stat_dok
			FROM master_retur_jual_paket
			LEFT JOIN customer ON(master_retur_jual_paket.rpaket_cust = customer.cust_id)
			LEFT JOIN master_jual_paket ON(master_retur_jual_paket.rpaket_nobuktijual = master_jual_paket.jpaket_id)
			LEFT JOIN cetak_kwitansi ON(cetak_kwitansi.kwitansi_ref = master_retur_jual_paket.rpaket_nobukti)";
		if($option=='LIST'){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR rpaket_nobukti LIKE '%".addslashes($filter)."%' OR jpaket_nobukti LIKE '%".addslashes($filter)."%' )";
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			if($rpaket_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_nobukti LIKE '%".$rpaket_nobukti."%'";
			};
			if($rpaket_nobuktijual!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_nobuktijual LIKE '%".$rpaket_nobuktijual."%'";
			};
			if($rpaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_cust = '".$rpaket_cust."'";
			};
			if($rpaket_tanggal!='' && $rpaket_tanggal_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rpaket_tanggal BETWEEN '".$rpaket_tanggal."' AND '".$rpaket_tanggal_akhir."'";
				}
			else if($rpaket_tanggal!='' && $rpaket_tanggal_akhir==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rpaket_tanggal='".$rpaket_tanggal."'";
				}
			if($rpaket_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_keterangan LIKE '%".$rpaket_keterangan."%'";
			};
			
			if($rpaket_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_stat_dok = '".$rpaket_stat_dok."'";
			};
			$result = $this->db->query($query);
		}
		return $result->result();
	}
	
	//function  for export to excel
	function master_retur_jual_paket_export_excel($rpaket_nobukti
												,$rpaket_nobuktijual
												,$rpaket_cust
												,$rpaket_tanggal
												,$rpaket_tanggal_akhir
												,$rpaket_keterangan
												,$rpaket_stat_dok
												,$option
												,$filter){
		//full query
		$query="SELECT rpaket_tanggal AS tanggal
				,rpaket_nobukti AS no_faktur
				,jpaket_nobukti AS no_faktur_jual
				,cust_no AS no_cust
				,cust_nama AS customer
				,kwitansi_nilai AS nilai_kuitansi
				,rpaket_keterangan AS keterangan
				,rpaket_stat_dok AS stat_dok
			FROM master_retur_jual_paket
			LEFT JOIN customer ON(master_retur_jual_paket.rpaket_cust = customer.cust_id)
			LEFT JOIN master_jual_paket ON(master_retur_jual_paket.rpaket_nobuktijual = master_jual_paket.jpaket_id)
			LEFT JOIN cetak_kwitansi ON(cetak_kwitansi.kwitansi_ref = master_retur_jual_paket.rpaket_nobukti)";
			
		if($option=='LIST'){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR rpaket_nobukti LIKE '%".addslashes($filter)."%' OR jpaket_nobukti LIKE '%".addslashes($filter)."%' )";
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			if($rpaket_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_nobukti LIKE '%".$rpaket_nobukti."%'";
			};
			if($rpaket_nobuktijual!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_nobuktijual LIKE '%".$rpaket_nobuktijual."%'";
			};
			if($rpaket_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_cust = '".$rpaket_cust."'";
			};
			if($rpaket_tanggal!='' && $rpaket_tanggal_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rpaket_tanggal BETWEEN '".$rpaket_tanggal."' AND '".$rpaket_tanggal_akhir."'";
				}
			else if($rpaket_tanggal!='' && $rpaket_tanggal_akhir==''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rpaket_tanggal='".$rpaket_tanggal."'";
				}
			if($rpaket_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_keterangan LIKE '%".$rpaket_keterangan."%'";
			};
			
			if($rpaket_stat_dok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rpaket_stat_dok = '".$rpaket_stat_dok."'";
			};
			$result = $this->db->query($query);
		}
		return $result;
	}
	
	function master_retur_jual_paket_batal($rpaket_id){
		/*
		 * db.master_retur_jual_paket.rpaket_id == di-Batalkan, maka tabel yang lain juga dibatalkan yaitu:
		 * 1. db.detail_jual_paket.dpaket_sisa_paket <== dikembalikan sebelum di-Retur
		 * 2. db.detail_ambil_paket <== di-Batalkan
		 * 3. db.cetak_kwitansi <== di-Batalkan
		*/
		$datetime_now = date('Y-m-d H:i:s');
		
		$sql = "SELECT drpaket_dpaket
				,rpaket_nobukti
				,drpaket_jumlah_diretur
			FROM detail_retur_paket_rawat
				JOIN master_retur_jual_paket ON(drpaket_master=rpaket_id)
			WHERE rpaket_id='".$rpaket_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$rpaket_nobukti = $record['rpaket_nobukti'];
			
			$sqlu_rpaket = "UPDATE master_retur_jual_paket
				SET rpaket_stat_dok='Batal'
					,rpaket_update='".@$_SESSION[SESSION_USERID]."'
					,rpaket_date_update='".$datetime_now."'
					,rpaket_revised=(rpaket_revised+1)
				WHERE rpaket_id='".$rpaket_id."'";
			$this->db->query($sqlu_rpaket);
			
			$sqlu_kwitansi = "UPDATE cetak_kwitansi, detail_ambil_paket
				SET kwitansi_status='Batal'
					,kwitansi_update='".@$_SESSION[SESSION_USERID]."'
					,kwitansi_date_update='".$datetime_now."'
					,kwitansi_revised=(kwitansi_revised+1)
				WHERE kwitansi_ref='".$rpaket_nobukti."'";
			$this->db->query($sqlu_kwitansi);
			
			foreach($rs->result() as $row){
				$sqlu_dapaket = "UPDATE detail_ambil_paket
					SET dapaket_stat_dok='Batal'
						,dapaket_update='".@$_SESSION[SESSION_USERID]."'
						,dapaket_date_update='".$datetime_now."'
						,dapaket_revised=(dapaket_revised+1)
					WHERE dapaket_dpaket='".$row->drpaket_dpaket."'
						AND dapaket_stat_dok='Retur'";
				$this->db->query($sqlu_dapaket);
				
				$sqlu_dpaket = "UPDATE detail_jual_paket
					SET dpaket_sisa_paket=(dpaket_sisa_paket+".$row->drpaket_jumlah_diretur.")
					WHERE dpaket_id='".$row->drpaket_dpaket."'";
				$this->db->query($sqlu_dpaket);
			}
			if($this->db->affected_rows()>-1){
				return 1;
			}
		}else{
			return 0;
		}
		
	}
	
	function print_paper($kwitansi_ref){
		$sql="SELECT kwitansi_id
				,kwitansi_no
				,kwitansi_date_create
				,cust_no
				,cust_nama
				,kwitansi_nilai
				,kwitansi_keterangan
				,kwitansi_cara
			FROM cetak_kwitansi,customer
			WHERE kwitansi_cust=cust_id
				AND kwitansi_ref='".$kwitansi_ref."'";
		$result = $this->db->query($sql);
		return $result;
	}
	
	function cara_bayar($kwitansi_ref){
		$sql="SELECT kwitansi_id,kwitansi_no,kwitansi_date_create,cust_no,cust_nama,kwitansi_nilai,kwitansi_keterangan FROM cetak_kwitansi,customer WHERE kwitansi_cust=cust_id AND kwitansi_ref='".$kwitansi_ref."'";
		$result = $this->db->query($sql);
		return $result;
	}
		
}
?>