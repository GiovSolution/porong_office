<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: hpp Model
	+ Description	: For record model process back-end
	+ Filename 		: c_hpp.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

class M_hpp extends Model{
		
		//constructor
		function M_hpp() {
			parent::Model();
		}
		
		function get_produk_list($filter,$start,$end,$satuan){
			if($satuan=='default')
				$sql="select distinct * from vu_produk_satuan_default WHERE produk_aktif='Aktif'";
			else
				$sql="select distinct * from vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			//echo $sql;
			
			if($filter<>""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.="( produk_kode LIKE '%".addslashes($filter)."%' OR 
						 produk_nama LIKE '%".addslashes($filter)."%' OR 
						 satuan_kode LIKE '%".addslashes($filter)."%' OR 
						 satuan_nama LIKE '%".addslashes($filter)."%')";
			}
			
			$sql.=" ORDER BY produk_kode ASC ";
			
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
		
		function get_periode(){
			$sql="SELECT distinct substr(min(tanggal),1,7) as min_date, substr(max(tanggal),1,7) as max_date from vu_hpp_tanggal";
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				$ds=$query->row();
				$min_date=$ds->min_date;
				$max_date=$ds->max_date;
				$min_year=substr($min_date,0,4);
				$max_year=substr($max_date,0,4);
				$range_year=$max_year-$min_year;
				
				$min_month=substr($min_date,5,2);
				$max_month=substr($max_date,5,2);
				
				//echo $min_year." s/d ".$max_year;
				//echo $min_month."-".$max_month;
				//min year
				$j=0;
				for($i=12;$i>=(int)$min_month;$i--){
					$data[$j]["periode_tanggal"]=$min_year."-".(strlen($i)==1?"0".$i:$i);
					$j++;
				}
				//range year
				for($i=(int)$min_year;$i<(int)$max_year;$i++){
					for($k=1;$k<=12;$k++){
						$data[$j]["periode_tanggal"]=$i."-".(strlen($k)==1?"0".$k:$k);
						$j++;
					}
				}
				
				//max year
				for($i=1;$i<=$max_month;$i++){
					$data[$j]["periode_tanggal"]=$max_year."-".(strlen($i)==1?"0".$i:$i);
					$j++;
				}
				
				return $data;
			}
			else
				return "";
				
		}
		
	
	function get_qty_awal($tanggal_awal, $produk_id){
	
		//Saldo awal master produk (dari semua gudang)
		$sql_saldo_awal=
		   "SELECT
				(produk_saldo_awal + produk_saldo_awal2 + produk_saldo_awal3 + produk_saldo_awal4) / konversi_nilai  as jumlah,
				produk_tgl_nilai_saldo_awal
			FROM produk, satuan_konversi
			WHERE 
				konversi_produk = produk_id
				AND	konversi_default = true
				AND	produk_id = '".$produk_id."'
				AND produk_tgl_nilai_saldo_awal <= ".$tanggal_awal;
				
		$rs_saldo_awal	= $this->db->query($sql_saldo_awal) or die("Error - 1.1 : ".$sql_saldo_awal);
		
		//dari hasil query di atas, akan diketahui apakah tanggal_awal >= produk_tgl_nilai_saldo_awal? jika tidak maka return 0
		if($rs_saldo_awal->num_rows()>0){
					
			$row_saldo_awal	= $rs_saldo_awal->row();
		
			//Saldo transaksi, dihitung sejak produk_tgl_nilai_saldo_awal di master produk
			$sql = "SELECT
						SUM(stok_masuk - stok_keluar) as stok_saldo
					FROM
					(
						SELECT
							ks.ks_masuk as stok_masuk,
							ks.ks_keluar as stok_keluar
						FROM kartu_stok_fix ks
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = ks.ks_satuan_id) AND (sk.konversi_produk = ks.ks_produk_id)
						WHERE 
							ks.ks_produk_id = '".$produk_id."'
							AND ks.ks_tgl_faktur >= '".$row_saldo_awal->produk_tgl_nilai_saldo_awal."' 
							AND ks.ks_tgl_faktur < ".$tanggal_awal."
							
						UNION ALL
						
						SELECT
							0 as stok_masuk,
							d.cabin_jumlah as stok_keluar
						FROM detail_pakai_cabin d
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = d.cabin_satuan) AND (sk.konversi_produk = d.cabin_produk)
						WHERE 
							d.cabin_produk = '".$produk_id."'
							AND date_format(cabin_date_create,'%Y-%m-%d') >= '".$row_saldo_awal->produk_tgl_nilai_saldo_awal."' 
							AND date_format(cabin_date_create,'%Y-%m-%d') <".$tanggal_awal."
					) 
					AS ks_gabungan";
									
			$query = $this->db->query($sql);
		
			if($query->num_rows()>0){
				$row = $query->row();
				$total = $row_saldo_awal->jumlah + $row->stok_saldo;
				//print_r(' sql: '.$sql.', saldo awal: '.$row_saldo_awal->jumlah.', stok saldo: '.$row->stok_saldo);
				return $total;
			}
			elseif($query->num_rows()==0){
				return $row_saldo_awal->jumlah;
				//print_r($tanggal_awal.$row_saldo_awal->jumlah);
			}
		}
		else{
			return 0;
		}
	}

	function get_nilai_awal($tanggal_awal, $bulan_sebelum, $tahun, $produk_id){
	
		//Saldo awal master produk (dari semua gudang), sementara hanya bisa jika tanggalnya 1
		$sql_saldo_awal=
		   "SELECT
				(produk_nilai_saldo_awal + produk_nilai_saldo_awal2 + produk_nilai_saldo_awal3 + produk_nilai_saldo_awal4) as produk_nilai_saldo_awal,
				produk_tgl_nilai_saldo_awal
			FROM produk, satuan_konversi
			WHERE 
				konversi_produk = produk_id
				AND	konversi_default = true
				AND	produk_id = '".$produk_id."'
				AND produk_tgl_nilai_saldo_awal = ".$tanggal_awal;
				
		$rs_saldo_awal	= $this->db->query($sql_saldo_awal) or die("Error - 1.1 : ".$sql_saldo_awal);
		
		//dari hasil query di atas, akan diketahui apakah tanggal_awal >= produk_tgl_nilai_saldo_awal? jika tidak maka return 0
		if($rs_saldo_awal->num_rows()>0){
					
			$row_saldo_awal	= $rs_saldo_awal->row();			
			return $row_saldo_awal->produk_nilai_saldo_awal;
		
		}
		else{
			$sql = "SELECT
						(hpp_nilai_awal + hpp_nilai_masuk - hpp_nilai_keluar) as nilai_awal
					FROM hpp_bulan
					WHERE
						hpp_bulan = '$bulan_sebelum' AND hpp_tahun = '$tahun'";
			
			$rs_sql 	= $this->db->query($sql);
			$row_sql	= $rs_sql->row();
			
			if($rs_sql->num_rows()>0){
				return $row_sql->nilai_awal;
			}
			else return 0;
		}
	}

	function get_qty_masuk($periode_start, $periode_end, $produk_id){
					
		//cek dulu, apakah $periode_start tidak lebih kecil dari inisialisasi awal master produk (produk_tgl_nilai_saldo_awal)
		$sql_tgl_awal =
			   "SELECT produk_tgl_nilai_saldo_awal
				FROM produk
				WHERE 
					produk_id = '".$produk_id."'
					AND produk_tgl_nilai_saldo_awal <= $periode_start";
				
		$query_tgl_awal	= $this->db->query($sql_tgl_awal);
		
		if($query_tgl_awal->num_rows()>0){
						
			$sql = "SELECT 
						SUM(ks.ks_masuk - ks.ks_keluar) as qty_masuk 
					FROM kartu_stok_fix ks
					LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = ks.ks_satuan_id) AND (sk.konversi_produk = ks.ks_produk_id)
					WHERE 
						ks.ks_produk_id = '".$produk_id."'
						AND ks.ks_tgl_faktur BETWEEN ".$periode_start." AND ".$periode_end."
						AND (ks.ks_jenis = 'terima_beli' OR ks.ks_jenis = 'retur_beli')";															
			
			$query_nbeli = $this->db->query($sql);
			
			if($query_nbeli->num_rows()){
				$nbeli =$query_nbeli->row();
				return $nbeli->qty_masuk;
			}else
				return 0;
		}
		else 
			return 0;
	}
		
	function get_nilai_masuk($periode_start, $periode_end, $produk_id){
					
		//cek dulu, apakah $periode_start tidak lebih kecil dari inisialisasi awal master produk (produk_tgl_nilai_saldo_awal)
		$sql_tgl_awal =
			   "SELECT produk_tgl_nilai_saldo_awal
				FROM produk
				WHERE 
					produk_id = '".$produk_id."'
					AND produk_tgl_nilai_saldo_awal <= $periode_start";
				
		$query_tgl_awal	= $this->db->query($sql_tgl_awal);
		
		if($query_tgl_awal->num_rows()>0){				
		
			$sql = "SELECT 
						ifnull(SUM(ks.ks_masuk_rp), 0) as masuk_rp
					FROM kartu_stok_fix ks
					WHERE 
						ks.ks_produk_id = '".$produk_id."'
						AND ks.ks_tgl_faktur BETWEEN ".$periode_start." AND ".$periode_end."
						AND (ks.ks_jenis = 'terima_beli' OR ks.ks_jenis = 'retur_beli')";															
			
			$query_nbeli = $this->db->query($sql);
			
			if($query_nbeli->num_rows()){
				$nbeli =$query_nbeli->row();
				//print_r($nbeli->masuk_rp);
				return $nbeli->masuk_rp;
			}else
				return 0;
		}
		else return 0;
	}	
	
	function get_qty_keluar($periode_start, $periode_end, $produk_id){
					
		//cek dulu, apakah $periode_start tidak lebih kecil dari inisialisasi awal master produk (produk_tgl_nilai_saldo_awal)
		$sql_tgl_awal =
			   "SELECT produk_tgl_nilai_saldo_awal
				FROM produk
				WHERE 
					produk_id = '".$produk_id."'
					AND produk_tgl_nilai_saldo_awal <= $periode_start";
				
		$query_tgl_awal	= $this->db->query($sql_tgl_awal);
		
		if($query_tgl_awal->num_rows()>0){
						
			$sql = "SELECT 
						SUM(stok_keluar - stok_masuk) as qty_keluar
					FROM
					(
						SELECT
							ks.ks_masuk as stok_masuk,
							ks.ks_keluar as stok_keluar
						FROM kartu_stok_fix ks
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = ks.ks_satuan_id) AND (sk.konversi_produk = ks.ks_produk_id)
						WHERE 
							ks.ks_produk_id = '".$produk_id."'
							AND ks.ks_tgl_faktur BETWEEN ".$periode_start." AND ".$periode_end."
							AND (ks.ks_jenis = 'jual_produk' OR ks.ks_jenis = 'retur_produk')
							
						UNION ALL	
						
						SELECT
							0 as stok_masuk,
							d.cabin_jumlah as stok_keluar
						FROM detail_pakai_cabin d
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = d.cabin_satuan) AND (sk.konversi_produk = d.cabin_produk)
						WHERE 
							d.cabin_produk = '".$produk_id."'
							AND date_format(cabin_date_create,'%Y-%m-%d') BETWEEN ".$periode_start." AND ".$periode_end."
					)
					AS ks_gabungan";
									
			$query_nbeli = $this->db->query($sql);
			
			if($query_nbeli->num_rows()){
				$nbeli =$query_nbeli->row();
				return $nbeli->qty_keluar;
			}else
				return 0;
		}
		else 
			return 0;
	}
		

	function get_qty_akhir($tanggal_akhir, $produk_id){
	
		//Saldo Awal Master Produk (dari semua gudang)
		$sql_saldo_awal=
		   "SELECT
				(produk_saldo_awal + produk_saldo_awal2 + produk_saldo_awal3 + produk_saldo_awal4) / konversi_nilai  as jumlah,
				produk_tgl_nilai_saldo_awal
			FROM produk, satuan_konversi
			WHERE 
				konversi_produk = produk_id
				AND	konversi_default = true
				AND	produk_id = '".$produk_id."'
				AND produk_tgl_nilai_saldo_awal < ".$tanggal_akhir;
				
		$rs_saldo_awal	= $this->db->query($sql_saldo_awal) or die("Error - 1.1 : ".$sql_saldo_awal);
		
		//dari hasil query di atas, akan diketahui apakah tanggal_akhir >= produk_tgl_nilai_saldo_awal? jika tidak maka return 0
		if($rs_saldo_awal->num_rows()>0){
					
			$row_saldo_awal	= $rs_saldo_awal->row();
		
			//Saldo transaksi, dihitung sejak produk_tgl_nilai_saldo_awal di master produk
			$sql = "SELECT
						SUM(stok_masuk - stok_keluar) as stok_saldo
					FROM
					(
						SELECT
							ks.ks_masuk as stok_masuk,
							ks.ks_keluar as stok_keluar
						FROM kartu_stok_fix ks
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = ks.ks_satuan_id) AND (sk.konversi_produk = ks.ks_produk_id)
						WHERE 
							ks.ks_produk_id = '".$produk_id."'
							AND ks.ks_tgl_faktur BETWEEN '".$row_saldo_awal->produk_tgl_nilai_saldo_awal."' AND ".$tanggal_akhir."
							
						UNION ALL
						
						SELECT
							0 as stok_masuk,
							d.cabin_jumlah as stok_keluar
						FROM detail_pakai_cabin d
						LEFT JOIN satuan_konversi sk ON (sk.konversi_satuan = d.cabin_satuan) AND (sk.konversi_produk = d.cabin_produk)
						WHERE 
							d.cabin_produk = '".$produk_id."'
							AND date_format(cabin_date_create,'%Y-%m-%d') BETWEEN '".$row_saldo_awal->produk_tgl_nilai_saldo_awal."' AND ".$tanggal_akhir."
					) 
					AS ks_gabungan";
									
			$query = $this->db->query($sql);
		
		
			if($query->num_rows()>0){
				$row = $query->row();
				$total = $row_saldo_awal->jumlah + $row->stok_saldo;
				//print_r(' sql: '.$sql.', saldo awal: '.$row_saldo_awal->jumlah.', stok saldo: '.$row->stok_saldo);
				return $total;
			}
			elseif($query->num_rows()==0){
				return $row_saldo_awal->jumlah;
				//print_r($tanggal_akhir.$row_saldo_awal->jumlah);
			}
		}
		else{
			return 0;
		}
	}

	function hpp_list($produk_id, $tahun/*, $filter, $start, $end*/){
	
		$this->hpp_generate($produk_id, $tahun);
		
		//note: hpp list seharusnya hanya bisa menampilkan 1 produk saja, akan diperbaiki kemudian.
		$query =   "SELECT
						produk_id, produk_kode, produk_nama,
						satuan_id, satuan_nama,	hpp_bulan,
						hpp_qty_awal, hpp_nilai_awal,
						hpp_qty_akhir, hpp_nilai_akhir,
						hpp_qty_masuk, hpp_nilai_masuk,
						hpp_qty_keluar,	hpp_nilai_keluar,
						ifnull(hpp_nilai_keluar / hpp_qty_keluar, 0) as hpp_nilai_keluar_satuan
					FROM hpp_bulan
					LEFT JOIN produk on produk_id = hpp_produk_id
					LEFT JOIN satuan on satuan_id = hpp_satuan_id
					WHERE hpp_produk_id='".$produk_id."'
					ORDER BY hpp_bulan";
																	
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		/*$limit = $query." LIMIT ".$start.",".$end;			
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
		
	function hpp_generate($produk_id, $tahun){
		
		$sql_del = "DELETE FROM hpp_bulan
					WHERE 
						hpp_produk_id = '".$produk_id."'
						AND hpp_tahun = ".$tahun;
		$this->db->query($sql_del);
	
		$sql = "select distinct * 
				from vu_produk_satuan_default 
				WHERE 
					produk_aktif = 'Aktif' 
					AND produk_id = '".$produk_id."'";
					
		if($tahun==""){
			$nbrows = 0;
		}else{
			$query	= $this->db->query($sql);
			$nbrows = $query->num_rows();		
			$row	= $query->row();				
		
			$bulan[1] = '01'; $bulan[2] = '02'; $bulan[3] = '03'; $bulan[4] = '04'; $bulan[5] = '05'; $bulan[6] = '06';
			$bulan[7] = '07'; $bulan[8] = '08'; $bulan[9] = '09'; $bulan[10] = '10'; $bulan[11] = '11'; $bulan[12] = '12';
			
			for($i = 1; $i <= 12; $i++){
				//print_r($bulan);
				
				//inisialisasi variable tanggal
				$tgl_awal	= "'".$tahun.'-'.$bulan[$i].'-01'."'";
				
				$last_day 	= cal_days_in_month(CAL_GREGORIAN, $bulan[$i], $tahun);
				$tgl_akhir	= "'".$tahun.'-'.$bulan[$i].'-'.$last_day."'";
				
				//inisialisasi tgl 1 hari sebelumnya
				if($bulan[$i]=='01'){
					$bulan_sebelum = '12';
					$tahun_sebelum = $tahun - 1;
					$last_day_sebelum 	= cal_days_in_month(CAL_GREGORIAN, $bulan_sebelum, $tahun_sebelum);
				}
				else{
					$bulan_sebelum = $bulan[$i - 1];
					$tahun_sebelum = $tahun;
					$last_day_sebelum 	= cal_days_in_month(CAL_GREGORIAN, $bulan_sebelum, $tahun_sebelum);
				}
				$tgl_akhir_bulan_sebelum	= "'".$tahun_sebelum.'-'.$bulan_sebelum.'-'.$last_day_sebelum."'";
				
			
				$qty_awal		= 0;
				$nilai_awal		= 0;
				$qty_masuk		= 0;
				$nilai_masuk	= 0;
				$qty_keluar		= 0;
				$nilai_keluar	= 0;
				$qty_akhir		= 0;
				$nilai_akhir	= 0;
				$konversi_nilai	= 1/$row->konversi_nilai;
				
				$qty_awal		= $this->get_qty_awal($tgl_awal, $row->produk_id) * $konversi_nilai;
				$nilai_awal		= $this->get_nilai_awal($tgl_awal, $bulan_sebelum, $tahun_sebelum, $row->produk_id);
				$qty_masuk		= $this->get_qty_masuk($tgl_awal, $tgl_akhir, $row->produk_id) * $konversi_nilai;
				$nilai_masuk	= $this->get_nilai_masuk($tgl_awal, $tgl_akhir, $row->produk_id);				
				$qty_keluar		= $this->get_qty_keluar($tgl_awal, $tgl_akhir, $row->produk_id) * $konversi_nilai;
				
				if($qty_awal == 0) 
					$nilai_keluar = 0;
				else
					$nilai_keluar	= $nilai_awal / $qty_awal * $qty_keluar;
				
				$qty_akhir		= $qty_awal + $qty_masuk - $qty_keluar;
				$nilai_akhir	= $nilai_awal + $nilai_masuk - $nilai_keluar;
				
				//$qty_akhir		= $this->get_qty_akhir($tgl_akhir, $row->produk_id) * $konversi_nilai;
				//$nilai_akhir			= $this->get_nilai_akhir($tgl_awal, $bulan_sebelum, $tahun_sebelum, $row->produk_id);								
				
				$data_hpp = array(
					"hpp_bulan"=>$bulan[$i],
					"hpp_tahun"=>$tahun,
					"hpp_produk_id"=>$row->produk_id,
					"hpp_satuan_id"=>$row->satuan_id,
					"hpp_qty_awal"=>$qty_awal,
					"hpp_nilai_awal"=>$nilai_awal,
					"hpp_qty_masuk"=>$qty_masuk,
					"hpp_nilai_masuk"=>$nilai_masuk,
					"hpp_qty_keluar"=>$qty_keluar,
					"hpp_nilai_keluar"=>$nilai_keluar,
					"hpp_qty_akhir"=>$qty_akhir,
					"hpp_nilai_akhir"=>$nilai_akhir					
				);
				$this->db->insert('hpp_bulan', $data_hpp); 
								
			}
		}			
	}
				
		//function for advanced search record
		function hpp_search($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$start,$end){
			//full query
			$query="select * from hpp";
			
			if($produk_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_id LIKE '%".$produk_id."%'";
			};
			if($produk_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_nama LIKE '%".$produk_nama."%'";
			};
			if($satuan_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_id LIKE '%".$satuan_id."%'";
			};
			if($satuan_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " satuan_nama LIKE '%".$satuan_nama."%'";
			};
			if($stok_saldo!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " stok_saldo LIKE '%".$stok_saldo."%'";
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
		function hpp_print($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from hpp";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR satuan_id LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR stok_saldo LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_nama!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($satuan_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_nama!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($stok_saldo!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " stok_saldo LIKE '%".$stok_saldo."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function hpp_export_excel($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter){
			//full query
			$sql="select * from hpp";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR satuan_id LIKE '%".addslashes($filter)."%' OR satuan_nama LIKE '%".addslashes($filter)."%' OR stok_saldo LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($satuan_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " satuan_id LIKE '%".$satuan_id."%'";
				};
				if($satuan_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " satuan_nama LIKE '%".$satuan_nama."%'";
				};
				if($stok_saldo!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " stok_saldo LIKE '%".$stok_saldo."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>