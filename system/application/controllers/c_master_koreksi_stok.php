<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: master_koreksi_stok Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_master_koreksi_stok.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 15:46:19
	
*/

//class of master_koreksi_stok
class C_master_koreksi_stok extends Controller {

	//constructor
	function C_master_koreksi_stok(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_koreksi_stok', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_koreksi_stok');
	}
	
	function print_faktur(){
		
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
	
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_koreksi_stok->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
        $data['tanggal'] = $master->tanggal;
        $data['gudang_nama'] = $master->gudang_nama;
		$print_view=$this->load->view("main/p_faktur_koreksi.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/koreksi_faktur.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
	
	}
	
	function laporan(){
		$this->load->view('main/v_lap_koreksi');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$faktur="";
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode ".$tgl_awal." s/d ".$tgl_akhir;
		}
		
		$data["data_print"]=$this->m_master_koreksi_stok->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur);
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_koreksi_tanggal.php",$data,TRUE);break;
				case "Gudang": $print_view=$this->load->view("main/p_rekap_koreksi_gudang.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_koreksi.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_koreksi_tanggal.php",$data,TRUE);break;
				case "Gudang": $print_view=$this->load->view("main/p_detail_koreksi_gudang.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_koreksi_produk.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_koreksi.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_koreksi.html","w+");
		else if($opsi=='detail')
			$print_file=fopen("print/report_koreksi.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_gudang_list(){
		$result=$this->m_public_function->get_gudang_list();
		echo $result;
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$gudang = (integer) (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		if($task=='detail')
			$result=$this->m_master_koreksi_stok->get_produk_detail_list($gudang, $master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_koreksi_stok->get_produk_all_list($gudang, $selected_id, $query, $start, $end);
		elseif($task=='selected')
			$result=$this->m_master_koreksi_stok->get_produk_selected_list($gudang, $selected_id,$query,$start,$end);

		echo $result;
	}
	
	function get_produk_stok(){
		$gudang = (integer) (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		$produk_id = isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id'];
		$tanggal=(isset($_POST['tanggal']) ? @$_POST['tanggal'] : @$_GET['tanggal']);
		$result=$this->m_master_koreksi_stok->get_stok_produk_selected($gudang, $produk_id,$tanggal);

		echo $result;
	}
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_master_koreksi_stok->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_koreksi_stok->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_koreksi_stok->get_satuan_selected_list($selected_id);
			
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_detail_koreksi_stok_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_koreksi_stok->detail_detail_koreksi_stok_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_detail_koreksi_stok_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_koreksi_stok->detail_detail_koreksi_stok_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_koreksi_stok->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_koreksi_stok_insert(){
	//POST variable here
		$dkoreksi_id = $_POST['dkoreksi_id']; 
        $dkoreksi_master=trim(@$_POST["dkoreksi_master"]);
        $dkoreksi_produk = $_POST['dkoreksi_produk']; 
		$dkoreksi_satuan = $_POST['dkoreksi_satuan']; 
		$dkoreksi_jmlawal = $_POST['dkoreksi_jmlawal'];
		$dkoreksi_jmlkoreksi = $_POST['dkoreksi_jmlkoreksi'];
		$dkoreksi_jmlsaldo = $_POST['dkoreksi_jmlsaldo'];
		$dkoreksi_ket= $_POST['dkoreksi_ket'];
	
		$array_dkoreksi_id = json_decode(stripslashes($dkoreksi_id));
		$array_dkoreksi_produk = json_decode(stripslashes($dkoreksi_produk));
		$array_dkoreksi_satuan = json_decode(stripslashes($dkoreksi_satuan));
		$array_dkoreksi_jmlawal = json_decode(stripslashes($dkoreksi_jmlawal));
		$array_dkoreksi_jmlkoreksi = json_decode(stripslashes($dkoreksi_jmlkoreksi));
		$array_dkoreksi_jmlsaldo = json_decode(stripslashes($dkoreksi_jmlsaldo));
		$array_dkoreksi_ket = json_decode(stripslashes($dkoreksi_ket));
		
		
		$result=$this->m_master_koreksi_stok->detail_detail_koreksi_stok_insert($array_dkoreksi_id ,$dkoreksi_master ,$array_dkoreksi_produk ,
																				$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
																				$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
																				$array_dkoreksi_ket );
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_koreksi_stok_list();
				break;
			case "UPDATE":
				$this->master_koreksi_stok_update();
				break;
			case "CREATE":
				$this->master_koreksi_stok_create();
				break;
			case "CEK":
				$this->master_koreksi_stok_pengecekan();
				break;
			case "DELETE":
				$this->master_koreksi_stok_delete();
				break;
			case "SEARCH":
				$this->master_koreksi_stok_search();
				break;
			case "PRINT":
				$this->master_koreksi_stok_print();
				break;
			case "EXCEL":
				$this->master_koreksi_stok_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_koreksi_stok_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_koreksi_stok->master_koreksi_stok_list($query,$start,$end);
		echo $result;
	}

	function master_koreksi_stok_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_koreksi_stok_update(){
		//POST variable here
		$koreksi_id=trim(@$_POST["koreksi_id"]);
		$koreksi_no=trim(@$_POST["koreksi_no"]);
		$koreksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_no);
		$koreksi_no=str_replace(",", ",",$koreksi_no);
		$koreksi_no=str_replace("'", '"',$koreksi_no);
		$koreksi_gudang=trim(@$_POST["koreksi_gudang"]);
		$koreksi_tanggal=trim(@$_POST["koreksi_tanggal"]);
		$koreksi_keterangan=trim(@$_POST["koreksi_keterangan"]);
		$koreksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_keterangan);
		$koreksi_keterangan=str_replace(",", ",",$koreksi_keterangan);
		$koreksi_keterangan=str_replace("'", '"',$koreksi_keterangan);
		$koreksi_status=trim(@$_POST["koreksi_status"]);
		$koreksi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_status);
		$koreksi_status=str_replace(",", ",",$koreksi_status);
		$koreksi_status=str_replace("'", '"',$koreksi_status);
		$koreksi_cetak = trim(@$_POST["koreksi_cetak"]);
		
		
		/*Tampungan utk Insert Detail Koreksi Stok */
		$dkoreksi_id = $_POST['dkoreksi_id']; 
        //$dkoreksi_master=trim(@$_POST["dkoreksi_master"]);
        $dkoreksi_produk = $_POST['dkoreksi_produk']; 
		$dkoreksi_satuan = $_POST['dkoreksi_satuan']; 
		$dkoreksi_jmlawal = $_POST['dkoreksi_jmlawal'];
		$dkoreksi_jmlkoreksi = $_POST['dkoreksi_jmlkoreksi'];
		$dkoreksi_jmlsaldo = $_POST['dkoreksi_jmlsaldo'];
		$dkoreksi_ket= $_POST['dkoreksi_ket'];
	
		$array_dkoreksi_id = json_decode(stripslashes($dkoreksi_id));
		$array_dkoreksi_produk = json_decode(stripslashes($dkoreksi_produk));
		$array_dkoreksi_satuan = json_decode(stripslashes($dkoreksi_satuan));
		$array_dkoreksi_jmlawal = json_decode(stripslashes($dkoreksi_jmlawal));
		$array_dkoreksi_jmlkoreksi = json_decode(stripslashes($dkoreksi_jmlkoreksi));
		$array_dkoreksi_jmlsaldo = json_decode(stripslashes($dkoreksi_jmlsaldo));
		$array_dkoreksi_ket = json_decode(stripslashes($dkoreksi_ket));
		
		

		$result = $this->m_master_koreksi_stok->master_koreksi_stok_update($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tanggal ,
																		   $koreksi_keterangan, $koreksi_status,$koreksi_cetak,
																		    $array_dkoreksi_id ,$array_dkoreksi_produk ,
																			$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
																			$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
																			$array_dkoreksi_ket );
		echo $result;
	}
	
	//function for create new record
	function master_koreksi_stok_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$koreksi_no=trim(@$_POST["koreksi_no"]);
		$koreksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_no);
		$koreksi_no=str_replace("'", '"',$koreksi_no);
		$koreksi_gudang=trim(@$_POST["koreksi_gudang"]);
		$koreksi_tanggal=trim(@$_POST["koreksi_tanggal"]);
		$koreksi_keterangan=trim(@$_POST["koreksi_keterangan"]);
		$koreksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_keterangan);
		$koreksi_keterangan=str_replace("'", '"',$koreksi_keterangan);
		$koreksi_status=trim(@$_POST["koreksi_status"]);
		$koreksi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_status);
		$koreksi_status=str_replace("'", '"',$koreksi_status);
		$koreksi_cetak = trim(@$_POST["koreksi_cetak"]);
		
		/*Tampungan utk Insert Detail Koreksi Stok */
		$dkoreksi_id = $_POST['dkoreksi_id']; 
        //$dkoreksi_master=trim(@$_POST["dkoreksi_master"]);
        $dkoreksi_produk = $_POST['dkoreksi_produk']; 
		$dkoreksi_satuan = $_POST['dkoreksi_satuan']; 
		$dkoreksi_jmlawal = $_POST['dkoreksi_jmlawal'];
		$dkoreksi_jmlkoreksi = $_POST['dkoreksi_jmlkoreksi'];
		$dkoreksi_jmlsaldo = $_POST['dkoreksi_jmlsaldo'];
		$dkoreksi_ket= $_POST['dkoreksi_ket'];
	
		$array_dkoreksi_id = json_decode(stripslashes($dkoreksi_id));
		$array_dkoreksi_produk = json_decode(stripslashes($dkoreksi_produk));
		$array_dkoreksi_satuan = json_decode(stripslashes($dkoreksi_satuan));
		$array_dkoreksi_jmlawal = json_decode(stripslashes($dkoreksi_jmlawal));
		$array_dkoreksi_jmlkoreksi = json_decode(stripslashes($dkoreksi_jmlkoreksi));
		$array_dkoreksi_jmlsaldo = json_decode(stripslashes($dkoreksi_jmlsaldo));
		$array_dkoreksi_ket = json_decode(stripslashes($dkoreksi_ket));
		
		$result=$this->m_master_koreksi_stok->master_koreksi_stok_create($koreksi_no, $koreksi_gudang ,$koreksi_tanggal ,$koreksi_keterangan, 
																		 $koreksi_status,$koreksi_cetak,
																		 $array_dkoreksi_id ,$array_dkoreksi_produk ,
																		$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
																		$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
																		$array_dkoreksi_ket );
		echo $result;
	}

	//function for delete selected record
	function master_koreksi_stok_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_koreksi_stok->master_koreksi_stok_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_koreksi_stok_search(){
		//POST varibale here
		$koreksi_id="";
		$koreksi_no=trim(@$_POST["koreksi_no"]);
		$koreksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_no);
		$koreksi_no=str_replace("'", '"',$koreksi_no);
		$koreksi_gudang=trim(@$_POST["koreksi_gudang"]);
		$koreksi_tgl_awal=trim(@$_POST["koreksi_tgl_awal"]);
		$koreksi_tgl_akhir=trim(@$_POST["koreksi_tgl_akhir"]);
		$koreksi_keterangan=trim(@$_POST["koreksi_keterangan"]);
		$koreksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_keterangan);
		$koreksi_keterangan=str_replace("'", '"',$koreksi_keterangan);
		$koreksi_status=trim(@$_POST["koreksi_status"]);

		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_koreksi_stok->master_koreksi_stok_search($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal ,
																		   $koreksi_tgl_akhir, $koreksi_keterangan, $koreksi_status, $start,$end);
		echo $result;
	}


	function master_koreksi_stok_print(){
  		//POST varibale here
		$koreksi_id="";
		$koreksi_no=trim(@$_POST["koreksi_no"]);
		$koreksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_no);
		$koreksi_no=str_replace("'", '"',$koreksi_no);
		$koreksi_gudang=trim(@$_POST["koreksi_gudang"]);
		$koreksi_tgl_awal=trim(@$_POST["koreksi_tgl_awal"]);
		$koreksi_tgl_akhir=trim(@$_POST["koreksi_tgl_akhir"]);
		$koreksi_keterangan=trim(@$_POST["koreksi_keterangan"]);
		$koreksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_keterangan);
		$koreksi_keterangan=str_replace("'", '"',$koreksi_keterangan);
		$koreksi_status=trim(@$_POST["koreksi_status"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_koreksi_stok->master_koreksi_stok_print($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal ,
																		  				 $koreksi_tgl_akhir, $koreksi_keterangan, $koreksi_status, 
																						 $option, $filter);
		$print_view=$this->load->view("main/p_list_koreksi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_koreksi_stoklist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';  
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_koreksi_stok_export_excel(){
		//POST varibale here
		$koreksi_id="";
		$koreksi_no=trim(@$_POST["koreksi_no"]);
		$koreksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_no);
		$koreksi_no=str_replace("'", '"',$koreksi_no);
		$koreksi_gudang=trim(@$_POST["koreksi_gudang"]);
		$koreksi_tgl_awal=trim(@$_POST["koreksi_tgl_awal"]);
		$koreksi_tgl_akhir=trim(@$_POST["koreksi_tgl_akhir"]);
		$koreksi_keterangan=trim(@$_POST["koreksi_keterangan"]);
		$koreksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$koreksi_keterangan);
		$koreksi_keterangan=str_replace("'", '"',$koreksi_keterangan);
		$koreksi_status=trim(@$_POST["koreksi_status"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_koreksi_stok->master_koreksi_stok_export_excel($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal ,
																		  		$koreksi_tgl_akhir, $koreksi_keterangan, $koreksi_status,$option,
																				$filter);
		
		$this->load->plugin('to_excel');		
		to_excel($query,"master_koreksi_stok"); 
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