<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: master_terima_beli Model
	+ Description	: For record model process back-end
	+ Filename 		: c_master_terima_beli.php
 	+ Author  		:
 	+ Created on 20/Aug/2009 15:44:15
get_terima_
*/

class M_master_terima_beli extends Model{

		//constructor
		function M_master_terima_beli() {
			parent::Model();
		}

		function get_cabang(){
			$sql="SELECT info_nama FROM info";

			$query2=$this->db->query($sql);
            return $query2; //by isaac
		}

		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur){

			switch($group){
				case "Tanggal": $order_by=" ORDER BY tanggal";break;
				case "Supplier": $order_by=" ORDER BY supplier_id";break;
				case "No Faktur": $order_by=" ORDER BY no_bukti";break;
				case "Produk": $order_by=" ORDER BY produk_kode";break;
				default: $order_by=" ORDER BY no_bukti";break;
			}

			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT distinct * FROM vu_trans_terima WHERE terima_status<>'Batal' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT distinct * FROM vu_trans_terima WHERE terima_status<>'Batal' AND
						  date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT distinct * FROM vu_trans_terima WHERE terima_status<>'Batal' AND
					      date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='detail'){
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_terima_all WHERE terima_status<>'Batal' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_terima_all WHERE terima_status<>'Batal' AND
						  date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_terima_all WHERE terima_status<>'Batal' AND
					      date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='faktur'){
				$sql="SELECT * FROM vu_detail_terima_all WHERE master='".$faktur."'";
			}
			
			//$this->firephp->log($sql);
			$query=$this->db->query($sql);
			if($opsi=='faktur')
				return $query;
			else
				return $query->result();
		}

		function get_produk_selected_list($master_id, $selected_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk ";

			/*if($master_id!=="")
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id IN(SELECT dterima_produk FROM detail_terima_beli WHERE dterima_order='".$master_id."')";*/

			if($selected_id!==""&strlen($selected_id)>1)
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id IN(".$selected_id.")";
			}

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")."( produk_nama like '%".$query."%' OR produk_kode like '%".$query."%')";
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

		function get_produk_all_list($query,$start,$end){

			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
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

		function get_produk_detail_list($master_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk";
			if($master_id<>"")
					$sql.=" WHERE produk_id IN(SELECT dterima_produk FROM detail_terima_beli WHERE dterima_master='".$master_id."')";

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}

			/*echo $sql;*/


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

		function get_bonus_detail_list($master_id,$query,$start,$end){
			$sql="SELECT produk_id,produk_nama,produk_kode,kategori_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			if($master_id<>"")
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id IN(SELECT dtbonus_produk FROM detail_terima_bonus WHERE dtbonus_master='".$master_id."')";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}

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
		
		function get_terima_gudang_list(){
			$sql="SELECT gudang_id, gudang_nama, gudang_lokasi FROM gudang where gudang_aktif='Aktif'";
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
		
		function get_satuan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			//if($master_id<>""){
				//$sql.=" WHERE satuan_id IN(SELECT dterima_satuan FROM detail_terima_beli WHERE dterima_master='".$master_id."')";
				//$sql.=" OR satuan_id IN(SELECT dtbonus_satuan FROM detail_terima_bonus WHERE dtbonus_master='".$master_id."')";
			//}

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


		function get_produk_order_list($order_id,$query,$start,$end){
			$sql="SELECT produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk";
			if($order_id<>"")
				$sql.=" WHERE produk_id IN(SELECT dorder_produk FROM detail_order_beli WHERE dorder_master='".$order_id."')";

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}

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
		
		function get_satuan_order_list($order_id){
			$sql="SELECT satuan_id,satuan_nama,satuan_kode FROM satuan";
			//if($order_id<>"")
				//$sql.=" WHERE satuan_id IN(SELECT dorder_satuan FROM detail_order_beli WHERE dorder_master='".$order_id."')";

		

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
		
			
		function get_order_beli_search_list(){
			$sql=  "SELECT
						order_id, order_no, order_tanggal, supplier_nama, supplier_id
					FROM master_order_beli, supplier, master_terima_beli
					WHERE order_supplier = supplier_id
					AND order_id=terima_order
					ORDER BY order_tanggal desc";
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
		
		function get_supplier_search_list($query){
			$sql=  "SELECT
						supplier_id, supplier_nama, supplier_alamat, supplier_notelp
					FROM supplier
					WHERE supplier_aktif = 'aktif'";
		
			if($query<>""){
				$sql=$sql." and (supplier_nama like '%".$query."%' or supplier_alamat like '%".$query."%' or supplier_notelp like '%".$query."%') ";
			}
			$sql=$sql." ORDER BY supplier_date_create desc";
			
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


	function get_order_beli_list($filter, $start, $end){
		$date = date('Y-m-d');
		//$date_1 = '01';
		//$date_2 = '02';
		$date_3 = '03';
		$month = substr($date,5,2);
		$year = substr($date,0,4);
		$begin=mktime(0,0,0,$month,1,$year);
		$nextmonth=strtotime("+2months",$begin);
		
		$month_next = substr(date("Y-m-d",$nextmonth),5,2);
		$year_next = substr(date("Y-m-d",$nextmonth),0,4);
		
		//$tanggal_1 = $year_next.'-'.$month_next.'-'.$date_1;
		//$tanggal_2 = $year_next.'-'.$month_next.'-'.$date_2;
		$tanggal_3 = $year_next.'-'.$month_next.'-'.$date_3;
		$datetime_now = date('Y-m-d H:i:s');

		$date_now=date('Y-m-d');
	
		$sql_day = "SELECT trans_op_days from transaksi_setting";
		$query_day= $this->db->query($sql_day);
		$data_day= $query_day->row();
		$day= $data_day->trans_op_days;
		
/*			$sql=  "SELECT order_no, order_id, order_tanggal, supplier_nama, supplier_id, sum(dorder_jumlah) as jumlah_order, 
					(select sum(detail_terima_beli.dterima_jumlah)
					from detail_terima_beli
					left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
					where (master_terima_beli.terima_order = master_order_beli.order_id AND master_terima_beli.terima_status <> 'Batal')
					)as jumlah_terima, 
					(sum(dorder_jumlah) - (select sum(detail_terima_beli.dterima_jumlah)
										from detail_terima_beli
										left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
										where (master_terima_beli.terima_order = master_order_beli.order_id AND master_terima_beli.terima_status <> 'Batal')
										)
					)as sisa
				FROM detail_order_beli
				LEFT JOIN master_order_beli on (master_order_beli.order_id = detail_order_beli.dorder_master)
				LEFT JOIN supplier on (master_order_beli.order_supplier = supplier.supplier_id)
				WHERE master_order_beli.order_status = 'Tertutup'  AND '".$date_now."' < (order_tanggal + INTERVAL '".$day."' DAY)
				";
*/					

		$sql = "SELECT 
					order_no, order_id, order_tanggal, supplier_nama, supplier_id, sum(dorder_jumlah) as jumlah_order	
				FROM detail_order_beli
				LEFT JOIN master_order_beli on master_order_beli.order_id = detail_order_beli.dorder_master
				LEFT JOIN supplier on master_order_beli.order_supplier = supplier.supplier_id
				WHERE 
					master_order_beli.order_status = 'Tertutup' AND '2012-09-10' < (order_tanggal + INTERVAL '60' DAY)";

		if ($filter<>""){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (order_no LIKE '%".addslashes($filter)."%' OR supplier_nama LIKE '%".addslashes($filter)."%')";
		}
		
/*			$sql .= " GROUP BY order_no desc 
					HAVING (sum(detail_order_beli.dorder_jumlah) - (select sum(detail_terima_beli.dterima_jumlah)
																	from detail_terima_beli
																	left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
																	where (master_terima_beli.terima_order = master_order_beli.order_id AND master_terima_beli.terima_status <> 'Batal')
																	)
							) <> 0 OR
							(sum(detail_order_beli.dorder_jumlah) - (select sum(detail_terima_beli.dterima_jumlah)
																	from detail_terima_beli
																	left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
																	where (master_terima_beli.terima_order = master_order_beli.order_id AND master_terima_beli.terima_status <> 'Batal')
																	)
							) IS NULL
					ORDER BY order_no desc ";			
*/

		$sql.= "GROUP BY order_no desc 
				HAVING 
					(
					sum(detail_order_beli.dorder_jumlah) - 
						(
						select sum(mt.terima_total_qty)
						from master_terima_beli mt 
						where 
							mt.terima_order = master_order_beli.order_id AND mt.terima_status <> 'Batal'
						)
					) <> 0
					OR
					(
					sum(detail_order_beli.dorder_jumlah) - 
						(
						select sum(mt.terima_total_qty)
						from master_terima_beli mt 
						where 
							mt.terima_order = master_order_beli.order_id AND mt.terima_status <> 'Batal'
						)
					) IS NULL
				ORDER BY order_no desc";

		$start=($start==""?0:$start);
		$end=($end==""?15:$end);
		
		$query = $this->db->query($sql);
		$nbrows = $query->num_rows();
		$limit = $sql." LIMIT ".$start.",".$end;		
		$result = $this->db->query($limit); 

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

		//function for detail
		//get record list

		function detail_detail_terima_bonus_list($master_id,$query,$start,$end) {
			$query = "SELECT dtbonus_id,dtbonus_master,dtbonus_produk,produk_nama,dtbonus_satuan,dtbonus_jumlah
						FROM vu_detail_terima_bonus where dtbonus_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;
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
		//end of function


		//insert detail record
		function detail_detail_terima_bonus_insert($array_dtbonus_id ,$dtbonus_master ,$array_dtbonus_produk ,
												   $array_dtbonus_satuan ,$array_dtbonus_jumlah ){

			 $query="";
			 for($i = 0; $i < sizeof($array_dtbonus_produk); $i++){

				$data = array(
					"dtbonus_master"=>$dtbonus_master,
					"dtbonus_produk"=>$array_dtbonus_produk[$i],
					"dtbonus_satuan"=>$array_dtbonus_satuan[$i],
					"dtbonus_jumlah"=>$array_dtbonus_jumlah[$i]
				);

				if($array_dtbonus_id[$i]==0){

					$this->db->insert('detail_terima_bonus', $data);

					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dtbonus_id)-1){
						$query = $query . ",";
					}

				}else{
					$query = $query.$array_dtbonus_id[$i];
					if($i<sizeof($array_dtbonus_id)-1){
						$query = $query . ",";
					}
					$this->db->where('dtbonus_id', $array_dtbonus_id[$i]);
					$this->db->update('detail_terima_bonus', $data);
				}
			}

			if($query<>""){
				$sql="DELETE FROM detail_terima_bonus WHERE  dtbonus_master='".$dtbonus_master."' AND
						dtbonus_id NOT IN (".$query.")";
				$this->db->query($sql);
			}

			return '1';

		}
		//end of function

		//function for detail
		//get record list

		function detail_detail_terima_beli_list($master_id,$query,$start,$end) {
			$query = "SELECT  distinct dterima_id,dterima_master,dterima_produk,produk_nama,dterima_satuan,jumlah_order, jumlah_sisa,
								dterima_jumlah,harga_satuan,diskon
						 FROM vu_detail_terima_produk where dterima_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//echo $query;

		/*	$limit = $query." LIMIT ".$start.",".$end;
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
		//end of function

		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(terima_id) as master_id from master_terima_beli";
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

		//check all order are receive
		function check_all_order_done($master_id){

			$is_done=true;

			$sql="SELECT terima_order FROM master_terima_beli WHERE terima_id='".$master_id."'";
			$query=$this->db->query($sql);
			if($query->num_rows()){
				$row=$query->row();
				$no_order=$row->terima_order;
			}else
				$no_order="";

			if($no_order!==""){
				$sql="SELECT dorder_produk,dorder_jumlah FROM detail_order_beli WHERE dorder_master='".$no_order."'";
				$query=$this->db->query($sql);
				foreach($query->result() as $result){

					$sql_terima="SELECT jumlah_terima FROM vu_detail_terima_order
									WHERE master_order='".$no_order."'
									AND produk='".$result->dorder_produk."'
									AND jumlah_terima>=".$result->dorder_jumlah;
					$query_terima=$this->db->query($sql_terima);
					if($query_terima->num_rows()<1)
					{
						$is_done=false;
						break;
					}
				}
			}else{
				$is_done=false;
			}

			if($is_done==true){
				$sql="UPDATE master_order_beli SET order_status='Tertutup' WHERE order_id='".$no_order."'";
				$this->db->query($sql);
			}
			/*else{
				$sql="UPDATE master_order_beli SET order_status='Terbuka' WHERE order_id='".$no_order."'";
				$this->db->query($sql);
			}
			*/

		}


		//insert detail record
		function detail_detail_terima_beli_insert($array_dterima_id ,$dterima_master ,$array_dterima_produk ,$array_dterima_satuan ,
												  $array_dterima_jumlah, $array_dterima_harga, $array_dterima_diskon){

			 $query="";
			 for($i = 0; $i < sizeof($array_dterima_produk); $i++){

				$data = array(
					"dterima_master"=>$dterima_master,
					"dterima_produk"=>$array_dterima_produk[$i],
					"dterima_satuan"=>$array_dterima_satuan[$i],
					"dterima_jumlah"=>$array_dterima_jumlah[$i],
					"dterima_harga"=>$array_dterima_harga[$i],
					"dterima_diskon"=>$array_dterima_diskon[$i]
				);

				if($array_dterima_id[$i]==0){
					$this->db->insert('detail_terima_beli', $data);

					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dterima_id)-1){
						$query = $query . ",";
					}

				}else{
					$query = $query.$array_dterima_id[$i];
					if($i<sizeof($array_dterima_id)-1){
						$query = $query . ",";
					}

					$this->db->where('dterima_id', $array_dterima_id[$i]);
					$this->db->update('detail_terima_beli', $data);
				}
			}
			if($query<>""){
				$sql="DELETE FROM detail_terima_beli WHERE  dterima_master='".$dterima_master."' AND
						dterima_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return $dterima_master;

		}
		//end of function

		//function for get list record
		function master_terima_beli_list($filter,$start,$end){
			$query = "SELECT *  FROM vu_trans_terima";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR
							order_no LIKE '%".addslashes($filter)."%' OR
							supplier_nama LIKE '%".addslashes($filter)."%' OR
							terima_surat_jalan LIKE '%".addslashes($filter)."%' OR
							terima_pengirim LIKE '%".addslashes($filter)."%')";
			}

			$query .= " ORDER BY no_bukti DESC ";

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
		function master_terima_beli_update($terima_id ,$terima_no ,$terima_order, $terima_order_id, $terima_supplier ,$terima_surat_jalan ,
										   $terima_pengirim ,$terima_tanggal ,$terima_keterangan, $terima_status , $cetak, $terima_gudang){
			$data = array(
				"terima_id"=>$terima_id,
				"terima_no"=>$terima_no,
				"terima_surat_jalan"=>$terima_surat_jalan,
				"terima_pengirim"=>$terima_pengirim,
				"terima_tanggal"=>$terima_tanggal,
				"terima_keterangan"=>$terima_keterangan,
				"terima_status"=>$terima_status,
				"terima_update"=>$_SESSION[SESSION_USERID],
				"terima_date_update"=>date('Y-m-d H:i:s')
			);
			$sql="SELECT supplier_id FROM supplier WHERE supplier_id='".$terima_supplier."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["terima_supplier"]=$terima_supplier;

			$sql="SELECT order_id FROM master_order_beli WHERE order_id='".$terima_order."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["terima_order"]=$terima_order;

			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$terima_gudang."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["terima_gudang_id"]=$terima_gudang;
				
			if($cetak==1){
				$data['terima_status'] = 'Tertutup';
			}//else{
				//$data['terima_status'] = 'Terbuka';
			//}
			
				
			$this->db->where('terima_id', $terima_id);
			$this->db->update('master_terima_beli', $data);

			$sql="UPDATE master_terima_beli SET terima_revised=0 WHERE terima_id='".$terima_id."' AND terima_revised is NULL";
			$result = $this->db->query($sql);

			$sql="UPDATE master_terima_beli SET terima_revised=(terima_revised+1) WHERE terima_id='".$terima_id."'";
			$result = $this->db->query($sql);

			return $terima_id;
		}

		//function for create new record
		function master_terima_beli_create($terima_no ,$terima_order , $terima_order_id, $terima_supplier ,$terima_surat_jalan ,$terima_pengirim ,
										   $terima_tanggal , $terima_keterangan, $terima_status, $cetak ,$terima_gudang, $terima_total_qty, $terima_total_rp){
//			$pattern="LPB/".date("y/m")."/";
//			$terima_no=$this->m_public_function->get_kode_1('master_terima_beli','terima_no',$pattern,14);
				
			$terima_tanggal_pattern=strtotime($terima_tanggal);
			$pattern="PB/".date("ym",$terima_tanggal_pattern)."-";
			$terima_no=$this->m_public_function->get_kode_1('master_terima_beli','terima_no',$pattern,12);

			if ($terima_gudang == 'GUDANG BESAR (CABIN)'){
				$terima_gudang = 1;
			}
			
			$sql="SELECT order_id FROM master_order_beli WHERE order_id='".$terima_order."'";
			$result=$this->db->query($sql);
			if($result->num_rows()){
				$data = array(
					"terima_no"=>$terima_no,
					"terima_order"=>$terima_order,
					"terima_supplier"=>$terima_supplier,
					"terima_surat_jalan"=>$terima_surat_jalan,
					"terima_pengirim"=>$terima_pengirim,
					"terima_total_qty"=>$terima_total_qty,
					"terima_total_rp"=>$terima_total_rp,
					"terima_tanggal"=>$terima_tanggal,
					"terima_keterangan"=>$terima_keterangan,
					"terima_status"=>$terima_status,
					"terima_gudang_id"=>$terima_gudang,
					"terima_creator"=>$_SESSION[SESSION_USERID],
					"terima_date_create"=>date('Y-m-d H:i:s'),
					"terima_revised"=>0
				);
				if($cetak==1){
					$data['terima_status'] = 'Tertutup';
				}else{
					$data['terima_status'] = 'Terbuka';
				}
				$this->db->insert('master_terima_beli', $data);
				if($this->db->affected_rows())
					return $this->db->insert_id();
				else
					return '0';
			}else{
				return '-99';
			}
		}

		//fcuntion for delete record
		function master_terima_beli_delete($pkid){
			$no_order=0;

			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				//mencari no order
				$sql="SELECT terima_order FROM master_terima_beli WHERE terima_id='".$pkid."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$no_order=" order_id = '".$row->terima_order."'";
				}

				$query = "DELETE master_terima_beli,detail_terima_beli,detail_terima_bonus
							FROM master_terima_beli,detail_terima_beli,detail_terima_bonus  WHERE terima_id = '".$pkid[0]."'
							AND (dterima_master=terima_id OR dtbonus_master=terima_id)";
				$this->db->query($query);
			} else {
				//mencari no order
				$sql="SELECT terima_order FROM master_terima_beli WHERE ";

				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "terima_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}
				}

				$result=$this->db->query($sql);
				$i=0;
				foreach($result->result() as $row){
					$i++;
					$no_order.=" order_id='".$row->terima_order;
					if($i<$result->num_rows()){
						$no_order.=" OR";
					}
				}


				$query = "DELETE master_terima_beli,detail_terima_beli,detail_terima_bonus
							FROM master_terima_beli,detail_terima_beli,detail_terima_bonus
							WHERE (";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "terima_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}
				}

				$query.=")";
				$query.=" AND (dterima_master=terima_id OR dtbonus_master=terima_id)";
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0){
				//PEMBUKAAN ORDER
				if($no_order<>""){
					$sql="UPDATE master_order_beli SET order_status='Terbuka'
							WHERE ".$no_order;
					$this->db->query($sql);
				}

				return '1';
			}else
				return '0';
		}

		//function for advanced search record
		function master_terima_beli_search($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,
										 $terima_surat_jalan ,$terima_pengirim ,$terima_tgl_awal,
										 $terima_tgl_akhir ,$terima_keterangan ,$terima_status, $start,$end ,$terima_gudang,$terima_supplier){
			//full query
			$query="SELECT *  FROM vu_trans_terima";

			if($terima_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " no_bukti LIKE '%".$terima_no."%'";
			};
			if($terima_order!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_order LIKE '%".$terima_order."%'";
			};
/*			if($terima_supplier!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_supplier LIKE '%".$terima_supplier."%'";
			};*/
			if($terima_surat_jalan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_surat_jalan LIKE '%".$terima_surat_jalan."%'";
			};
			if($terima_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_gudang_id LIKE '%".$terima_gudang."%'";
			};
				
			if($terima_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_id LIKE '%".$terima_supplier."%'";
				};
			if($terima_pengirim!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_pengirim LIKE '%".$terima_pengirim."%'";
			};
			if($terima_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$terima_tgl_awal."'";
			};
			if($terima_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$terima_tgl_akhir."'";
			};
			if($terima_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_keterangan LIKE '%".$terima_keterangan."%'";
			};
			if($terima_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " terima_status LIKE '%".$terima_status."%'";
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
		function master_terima_beli_print($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,$terima_surat_jalan ,$terima_pengirim ,
										  $terima_tgl_awal, $terima_tgl_akhir ,$terima_keterangan ,$terima_status, $option,$filter ,$terima_gudang){
			//full query
			$query="SELECT *  FROM vu_trans_terima";
			if($option=='LIST'){
				if($filter<>""){

				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " no_bukti LIKE '%".addslashes($filter)."%' OR
							order_no LIKE '%".addslashes($filter)."%' OR
							supplier_nama LIKE '%".addslashes($filter)."%' OR
							terima_surat_jalan LIKE '%".addslashes($filter)."%' OR
							terima_pengirim LIKE '%".addslashes($filter)."%'";
				}

			} else if($option=='SEARCH'){
				if($terima_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$terima_no."%'";
				};
				if($terima_order!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_order LIKE '%".$terima_order."%'";
				};
				if($terima_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_id LIKE '%".$terima_supplier."%'";
				};
				if($terima_surat_jalan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_surat_jalan LIKE '%".$terima_surat_jalan."%'";
				};
				if($terima_pengirim!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_pengirim LIKE '%".$terima_pengirim."%'";
				};
				if($terima_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$terima_tgl_awal."'";
				};
				if($terima_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$terima_tgl_akhir."'";
				};
				if($terima_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_gudang_id LIKE '%".$terima_gudang."%'";
				};
				if($terima_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_keterangan LIKE '%".$terima_keterangan."%'";
				};
				if($terima_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_status LIKE '%".$terima_status."%'";
				};

			}

			$result = $this->db->query($query);

			return $result->result();
		}

		//function  for export to excel
		function master_terima_beli_export_excel($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,$terima_surat_jalan ,$terima_pengirim ,
												 $terima_tgl_awal, $terima_tgl_akhir ,$terima_keterangan , $terima_status, $option,$filter ,$terima_gudang){
			//full query
			$query="SELECT tanggal as 'Tanggal', no_bukti as 'No Penerimaan', order_no as 'No Pesanan', supplier_nama as Supplier
					,jumlah_barang as 'Jumlah Item', jumlah_barang_bonus as 'Jumlah Item Bonus', terima_surat_jalan as 'No Surat Jalan',
					terima_pengirim as 'Pengirim', terima_keterangan as 'Keterangan' FROM vu_trans_terima";
			if($option=='LIST'){
				if($filter<>""){

				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " no_bukti LIKE '%".addslashes($filter)."%' OR
							order_no LIKE '%".addslashes($filter)."%' OR
							supplier_nama LIKE '%".addslashes($filter)."%' OR
							terima_surat_jalan LIKE '%".addslashes($filter)."%' OR
							terima_pengirim LIKE '%".addslashes($filter)."%'";
				}

			} else if($option=='SEARCH'){
				if($terima_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$terima_no."%'";
				};
				if($terima_order!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_order LIKE '%".$terima_order."%'";
				};
				if($terima_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_id LIKE '%".$terima_supplier."%'";
				};
				if($terima_surat_jalan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_surat_jalan LIKE '%".$terima_surat_jalan."%'";
				};
				if($terima_pengirim!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_pengirim LIKE '%".$terima_pengirim."%'";
				};
				if($terima_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$terima_tgl_awal."'";
				};
				if($terima_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_gudang_id LIKE '%".$terima_gudang."%'";
				};
				if($terima_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$terima_tgl_akhir."'";
				};
				if($terima_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_keterangan LIKE '%".$terima_keterangan."%'";
				};
				if($terima_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " terima_status LIKE '%".$terima_status."%'";
				};

			}
			$result = $this->db->query($query);

			return $result;
		}

}
?>