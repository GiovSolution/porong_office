<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of master_mutasi
class C_master_mutasi extends Controller {

	//constructor
	function C_master_mutasi(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_mutasi', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_mutasi');
		$this->load->plugin('to_excel');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_mutasi');
	}
	
	function print_faktur(){
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_mutasi->get_laporan("","","",$opsi,"",$faktur);
		$result2 = $this->m_master_mutasi->get_laporan_racikan($faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$master2=$result2->row();
		$data['data_print'] = $result->result();
		$data['data_print2'] = $result2->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->mutasi_no;
        $data['tanggal'] = $master->mutasi_tanggal;
        $data['gudang_asal_nama'] = $master->gudang_asal_nama;
		$data['gudang_tujuan_nama'] = $master->gudang_tujuan_nama;
		if ($result2->row() != null) {
	
		$data['mutasi_racikan'] = $master2->mutasi_racikan;
		$data['produk_nama'] = $master2->produk_nama;
		$data['satuan_nama'] = $master2->satuan_nama;
		$data['mutasi_noref'] = $master2->mutasi_noref;
		$data['jumlah_out'] = $master2->jumlah_out;
		$data['status_mutasi'] = $master2->status_mutasi;
		}

		
		
		$print_view=$this->load->view("main/p_faktur_mutasi.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/mutasi_faktur.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
		
	}
	
	// Function utk Print Laporan Mutasi Barang
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode ".$tgl_awal." s/d ".$tgl_akhir;
		}
		
		$data["data_print"]=$this->m_master_mutasi->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,"");
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_mutasi_tanggal.php",$data,TRUE);break;
				case "Produk Racikan": $print_view=$this->load->view("main/p_rekap_mutasi_produk_racikan.php",$data,TRUE);break;
				case "Produk Non Racikan(Retail)": $print_view=$this->load->view("main/p_rekap_mutasi_produk_non_racikan.php",$data,TRUE);break;
				case "Gudang Asal": $print_view=$this->load->view("main/p_rekap_mutasi_asal.php",$data,TRUE);break;
				case "Gudang Tujuan": $print_view=$this->load->view("main/p_rekap_mutasi_tujuan.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_mutasi.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_mutasi_tanggal.php",$data,TRUE);break;
				case "Gudang Asal": $print_view=$this->load->view("main/p_detail_mutasi_asal.php",$data,TRUE);break;
				case "Gudang Tujuan": $print_view=$this->load->view("main/p_detail_mutasi_tujuan.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_mutasi_produk.php",$data,TRUE);break;
				case "Produk Racikan": $print_view=$this->load->view("main/p_detail_mutasi_produk_racikan.php",$data,TRUE);break;
				case "Barang Keluar": $print_view=$this->load->view("main/p_detail_mutasi_barang_keluar.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_mutasi.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/report_mutasi.html","w+");	
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_gudang_list(){
		$result=$this->m_master_mutasi->get_gudang_list();
		echo $result;
	}
	
	function get_kategori_barang_keluar_list(){
		$result=$this->m_master_mutasi->get_kategori_barang_keluar_list();
		echo $result;
	}
	
	/*Store utk menampilkan semua Gudang */
	function get_gudang_all_list(){
		$result=$this->m_master_mutasi->get_gudang_all_list();
		echo $result;
	}
	
	
	function get_stok_akhir_mutasi(){
		$gudang = (integer) (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		$produk_id = isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id'];
		$tanggal=(isset($_POST['tanggal']) ? @$_POST['tanggal'] : @$_GET['tanggal']);
		$result=$this->m_master_mutasi->get_stok_akhir_mutasi($gudang, $produk_id,$tanggal);

		echo $result;
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$gudang = (integer) (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$no_ref = isset($_POST['no_ref']) ? @$_POST['no_ref'] : @$_GET['no_ref'];
		if($task=='detail')
			$result=$this->m_master_mutasi->get_produk_detail_list($gudang, $master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_mutasi->get_produk_all_list($gudang, $selected_id, $query, $start, $end);
		elseif($task=='selected')
			$result=$this->m_master_mutasi->get_produk_selected_list($gudang, $selected_id,$query,$start,$end);
		elseif($task=='no_ref')
			$result=$this->m_master_mutasi->get_produk_no_ref_list($no_ref, $query,$start,$end);

		echo $result;
	}
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		//$no_ref = isset($_POST['no_ref']) ? @$_POST['no_ref'] : @$_GET['no_ref'];
		
		if($task=='detail')
			$result=$this->m_master_mutasi->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_mutasi->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_mutasi->get_satuan_selected_list($selected_id);
		elseif($task=='all')
			$result=$this->m_master_mutasi->get_satuan_all_list();
			
		echo $result;
	}
	
	/*Function to get_satuan_racikan_list */
	function get_satuan_racikan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_master_mutasi->get_satuan_racikan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_mutasi->get_satuan_racikan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_mutasi->get_satuan_racikan_selected_list($selected_id);
			
		echo $result;
	}
	
	/*Function utk memanggil produk jadi List */
	function get_produk_jadi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		if($task=='detail')
			$result=$this->m_master_mutasi->get_produk_jadi_detail_list($master_id,$query);
		elseif($task=='LIST')
			$result = $this->m_master_mutasi->get_produk_jadi_list($query,$aktif,$master_id);
		echo $result;
	}
	
	/*Function utk menampilkan browse No Ref */
	function get_racikan_noref_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_master_mutasi->get_racikan_noref_list($query,$start, $end);
		echo $result;
	}
	
	/*Function utk mengambil detail produk Jadi dari No Ref */
	function get_detail_item_by_noref(){
		$no_ref = isset($_POST['no_ref']) ? @$_POST['no_ref'] : "";
		$result=$this->m_master_mutasi->get_detail_item_by_noref($no_ref);
		echo $result;
	}
	
	//list utk menampilkan detail mutasi racikan list
	function detail_detail_mutasi_racikan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_mutasi->detail_detail_mutasi_racikan_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//list utk menampilkan detail mutasi produk jadi list
	function detail_detail_mutasi_produk_jadi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$no_ref = (integer) (isset($_POST['no_ref']) ? $_POST['no_ref'] : $_GET['no_ref']);
		if($task=='master_id')
			$result=$this->m_master_mutasi->detail_detail_mutasi_produk_jadi_list($master_id,$query,$start,$end);
		elseif($task=='no_ref')
			$result=$this->m_master_mutasi->load_noref_edit($no_ref,$query,$start,$end);
		
		
		
		echo $result;
	}
	//end of handler
	
	
	//for detail action
	//list detail handler action
	function detail_detail_mutasi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_mutasi->detail_detail_mutasi_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_detail_mutasi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_mutasi->detail_detail_mutasi_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_mutasi->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_mutasi_insert(){
	//POST variable here
		$dmutasi_id=trim(@$_POST["dmutasi_id"]);
		$dmutasi_master=trim(@$_POST["dmutasi_master"]);
		$dmutasi_produk=trim(@$_POST["dmutasi_produk"]);
		$dmutasi_satuan=trim(@$_POST["dmutasi_satuan"]);
		$dmutasi_jumlah=trim(@$_POST["dmutasi_jumlah"]);
		
		$array_mutasi_id = json_decode(stripslashes($dmutasi_id));
		$array_mutasi_produk = json_decode(stripslashes($dmutasi_produk));
		$array_mutasi_satuan = json_decode(stripslashes($dmutasi_satuan));
		$array_mutasi_jumlah = json_decode(stripslashes($dmutasi_jumlah));

						
		$result=$this->m_master_mutasi->detail_detail_mutasi_insert($array_mutasi_id ,$dmutasi_master ,$array_mutasi_produk ,
																	$array_mutasi_satuan ,$array_mutasi_jumlah );
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_mutasi_list();
				break;
			case "UPDATE":
				$this->master_mutasi_update();
				break;
			case "CEK":
				$this->master_mutasi_pengecekan();
				break;	
			case "CEKSAVECLOSE":
				$this->master_mutasi_pengecekan_saveclose();
				break;
			case "CREATE":
				$this->master_mutasi_create();
				break;
			case "DELETE":
				$this->master_mutasi_delete();
				break;
			case "SEARCH":
				$this->master_mutasi_search();
				break;
			case "PRINT":
				$this->master_mutasi_print();
				break;
			case "EXCEL":
				$this->master_mutasi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_mutasi_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_mutasi->master_mutasi_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function master_mutasi_update(){
		//POST variable here
		$mutasi_id=trim(@$_POST["mutasi_id"]);
		$mutasi_no=trim(@$_POST["mutasi_no"]);
		$mutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_no);
		$mutasi_no=str_replace(",", ",",$mutasi_no);
		$mutasi_no=str_replace("'", '"',$mutasi_no);
		
		$mutasi_spb=trim(@$_POST["mutasi_spb"]);
		$mutasi_spb=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_spb);
		$mutasi_spb=str_replace("'", '"',$mutasi_spb);
		
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
		$mutasi_tanggal=trim(@$_POST["mutasi_tanggal"]);
		$mutasi_keterangan=trim(@$_POST["mutasi_keterangan"]);
		$mutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_keterangan);
		$mutasi_keterangan=str_replace(",", ",",$mutasi_keterangan);
		$mutasi_keterangan=str_replace("'", '"',$mutasi_keterangan);
		
		$mutasi_racikan=trim(@$_POST["mutasi_racikan"]);
		
		$mutasi_status=trim(@$_POST["mutasi_status"]);
		$mutasi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_status);
		$mutasi_status=str_replace(",", ",",$mutasi_status);
		$mutasi_status=str_replace("'", '"',$mutasi_status);
		
		$mutasi_kategori_barang_keluar=trim(@$_POST["mutasi_kategori_barang_keluar"]);
		
		$mutasi_status_terima=trim(@$_POST["mutasi_status_terima"]);
		$mutasi_status_terima=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_status_terima);
		$mutasi_status_terima=str_replace(",", ",",$mutasi_status_terima);
		$mutasi_status_terima=str_replace("'", '"',$mutasi_status_terima);
		$mutasi_barang_keluar=trim(@$_POST["mutasi_barang_keluar"]);
		$cetak=trim(@$_POST["cetak"]);
		$printonly=trim(@$_POST["printonly"]);
		$result = $this->m_master_mutasi->master_mutasi_update($mutasi_id ,$mutasi_no, $mutasi_spb, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tanggal ,$mutasi_keterangan, $mutasi_status, $mutasi_status_terima, $mutasi_barang_keluar, $mutasi_racikan, $mutasi_kategori_barang_keluar, $cetak, $printonly);
		echo $result;
	}
	
	//function for create new record
	function master_mutasi_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$mutasi_no=trim(@$_POST["mutasi_no"]);
		$mutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_no);
		$mutasi_no=str_replace("'", '"',$mutasi_no);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
		$mutasi_tanggal=trim(@$_POST["mutasi_tanggal"]);
		$mutasi_keterangan=trim(@$_POST["mutasi_keterangan"]);
		$mutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_keterangan);
		$mutasi_keterangan=str_replace("'", '"',$mutasi_keterangan);
		
		$mutasi_status=trim(@$_POST["mutasi_status"]);
		$mutasi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_status);
		$mutasi_status=str_replace("'", '"',$mutasi_status);
		
		$mutasi_status_terima=trim(@$_POST["mutasi_status_terima"]);
		$mutasi_status_terima=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_status_terima);
		$mutasi_status_terima=str_replace(",", ",",$mutasi_status_terima);
		$mutasi_status_terima=str_replace("'", '"',$mutasi_status_terima);
		
		$mutasi_kategori_barang_keluar=trim(@$_POST["mutasi_kategori_barang_keluar"]);
		
		$mutasi_spb=trim(@$_POST["mutasi_spb"]);
		$mutasi_spb=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_spb);
		$mutasi_spb=str_replace("'", '"',$mutasi_spb);
		$mutasi_racikan=trim(@$_POST["mutasi_racikan"]);
		$racikan_keluar=trim(@$_POST["racikan_keluar"]);
		$racikan_masuk=trim(@$_POST["racikan_masuk"]);
		$racikan_produk=trim(@$_POST["racikan_produk"]);
		$racikan_jumlah=trim(@$_POST["racikan_jumlah"]);
		$racikan_satuan=trim(@$_POST["racikan_satuan"]);
		$racikan_dmracikan_id=trim(@$_POST["racikan_dmracikan_id"]);
		$mutasi_barang_keluar=trim(@$_POST["mutasi_barang_keluar"]);
		$cetak=trim(@$_POST["cetak"]);
		$printonly=trim(@$_POST["printonly"]);
		
		//Data Detail Produk Jadi
		$dmracikan_id = $_POST['dmracikan_id']; // Get our array back and translate it :
		$array_dmracikan_id = json_decode(stripslashes($dmracikan_id));
		
		$dmracikan_produk = $_POST['dmracikan_produk']; // Get our array back and translate it :
		$array_dmracikan_produk = json_decode(stripslashes($dmracikan_produk));
		
		$dmracikan_satuan = $_POST['dmracikan_satuan']; // Get our array back and translate it :
		$array_dmracikan_satuan = json_decode(stripslashes($dmracikan_satuan));
		
		$dmracikan_jumlah = $_POST['dmracikan_jumlah']; // Get our array back and translate it :
		$array_dmracikan_jumlah = json_decode(stripslashes($dmracikan_jumlah));
				
				
		$result=$this->m_master_mutasi->master_mutasi_create($mutasi_no, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tanggal ,$mutasi_keterangan, $mutasi_status, $mutasi_spb, $mutasi_racikan, $racikan_keluar, $racikan_masuk, $racikan_produk, $racikan_jumlah, $racikan_satuan, $racikan_dmracikan_id,$mutasi_barang_keluar,$mutasi_status_terima, $mutasi_kategori_barang_keluar, $cetak, $printonly,
		$array_dmracikan_id, $array_dmracikan_produk, $array_dmracikan_satuan, $array_dmracikan_jumlah);
		echo $result;
	}

	//function for delete selected record
	function master_mutasi_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_mutasi->master_mutasi_delete($pkid);
		echo $result;
	}

	function master_mutasi_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
	
		$result=$this->m_master_mutasi->pengecekan_dokumen($tanggal_pengecekan,$mutasi_asal ,$mutasi_tujuan);
		echo $result;
	}
	
	function master_mutasi_pengecekan_saveclose(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
		$no_mb=trim(@$_POST["no_mb"]);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
	
		$result=$this->m_master_mutasi->master_mutasi_pengecekan_saveclose($tanggal_pengecekan,$no_mb,$mutasi_asal ,$mutasi_tujuan);
		echo $result;
	}
	
	//function for advanced search
	function master_mutasi_search(){
		//POST varibale here
		$mutasi_id=trim(@$_POST["mutasi_id"]);
		$mutasi_no=trim(@$_POST["mutasi_no"]);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
		$mutasi_tgl_awal=trim(@$_POST["mutasi_tgl_awal"]);
		$mutasi_tgl_akhir=trim(@$_POST["mutasi_tgl_akhir"]);
		$mutasi_keterangan=trim(@$_POST["mutasi_keterangan"]);
		$mutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_keterangan);
		$mutasi_keterangan=str_replace("'", '"',$mutasi_keterangan);
		
		$mutasi_status=trim(@$_POST["mutasi_status"]);
		$mutasi_status_terima=trim(@$_POST["mutasi_status_terima"]);
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_mutasi->master_mutasi_search($mutasi_id ,  $mutasi_no, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tgl_awal, 
															   $mutasi_tgl_akhir ,$mutasi_keterangan ,$mutasi_status, $mutasi_status_terima, $start,$end);
		echo $result;
	}


	function master_mutasi_print(){
  		//POST varibale here
		$mutasi_id=trim(@$_POST["mutasi_id"]);
		$mutasi_no=trim(@$_POST["mutasi_no"]);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
		$mutasi_tgl_awal=trim(@$_POST["mutasi_tgl_awal"]);
		$mutasi_tgl_akhir=trim(@$_POST["mutasi_tgl_akhir"]);
		$mutasi_keterangan=trim(@$_POST["mutasi_keterangan"]);
		$mutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_keterangan);
		$mutasi_keterangan=str_replace("'", '"',$mutasi_keterangan);
		$mutasi_status=trim(@$_POST["mutasi_status"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_mutasi->master_mutasi_print($mutasi_id ,  $mutasi_no, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tgl_awal, 
															   $mutasi_tgl_akhir ,$mutasi_keterangan ,$mutasi_status, $option,$filter);
		
		$print_view=$this->load->view("main/p_list_mutasi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_mutasilist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';      
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_mutasi_export_excel(){
		//POST varibale here
		$mutasi_id=trim(@$_POST["mutasi_id"]);
		$mutasi_no=trim(@$_POST["mutasi_no"]);
		$mutasi_asal=trim(@$_POST["mutasi_asal"]);
		$mutasi_tujuan=trim(@$_POST["mutasi_tujuan"]);
		$mutasi_tgl_awal=trim(@$_POST["mutasi_tgl_awal"]);
		$mutasi_tgl_akhir=trim(@$_POST["mutasi_tgl_akhir"]);
		$mutasi_keterangan=trim(@$_POST["mutasi_keterangan"]);
		$mutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mutasi_keterangan);
		$mutasi_keterangan=str_replace("'", '"',$mutasi_keterangan);
		$mutasi_status=trim(@$_POST["mutasi_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_mutasi->master_mutasi_export_excel($mutasi_id ,  $mutasi_no, $mutasi_asal ,$mutasi_tujuan ,$mutasi_tgl_awal, 
															   		$mutasi_tgl_akhir ,$mutasi_keterangan ,$mutasi_status,$option,$filter);
		
		$this->load->plugin("to_excel");
		to_excel($query,"mutasi_list","Mutasi_List.xls"); 
		echo '1';
			
	}
	
	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Decode a SQL array into a JSON formated string
	function JDecode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->decode($arr);  //decode the data in json format
		} else {
			$data = json_decode($arr);  //decode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>