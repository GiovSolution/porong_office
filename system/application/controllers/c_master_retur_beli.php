<?php
/*
	GIOV Solution - Keep IT Simple	
*/

//class of master_retur_beli
class C_master_retur_beli extends Controller {

	//constructor
	function C_master_retur_beli(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_retur_beli', '', TRUE);
		
		
	}
	
	//set index
	function index(){
		$this->load->view('main/v_master_retur_beli');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_retur_beli');
	}
	
	function print_faktur(){
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_retur_beli->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		
		$data['no_bukti'] = $master->no_bukti;
		$data['no_order'] = $master->no_order;
		$data['no_terima'] = $master->no_terima;
        $data['tanggal'] = $master->tanggal;
        $data['supplier_nama'] = $master->supplier_nama;
		
		$print_view=$this->load->view("main/p_faktur_retur.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/retur_faktur.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
		
	}
	
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
		
		$data["data_print"]=$this->m_master_retur_beli->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,"");
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_retur_beli_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_rekap_retur_beli_supplier.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_retur_beli.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_retur_beli_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_detail_retur_beli_supplier.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_retur_beli_produk.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_retur_beli.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_retur_beli.html","w+");
		else
			$print_file=fopen("print/report_retur_beli.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	
	function get_terima_beli_list(){
		$result=$this->m_master_retur_beli->get_terima_beli_list();
		echo $result;
	}
	
	
	function get_terima_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_master_retur_beli->get_terima_list($query,$start,$end);
		echo $result;
	}
	
	
	function get_supplier_list(){
		$result=$this->m_public_function->get_supplier_list();
		echo $result;
	}
	
	//get master id, note: not done yet
	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$terima_id = (integer) (isset($_POST['terima_id']) ? @$_POST['terima_id'] : @$_GET['terima_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		if($task=='detail')
			$result=$this->m_master_retur_beli->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_retur_beli->get_produk_all_list($terima_id, $selected_id, $query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_master_retur_beli->get_produk_selected_list($selected_id,$query,$start,$end);
		echo $result;
	}
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_master_retur_beli->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_retur_beli->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_retur_beli->get_satuan_selected_list($selected_id);
			
		echo $result;
	}
	
	
	function get_satuan_by_produkid(){
		$dterima_master = trim(@$_POST["dterima_master"]);
		$dterima_produk = trim(@$_POST["dterima_produk"]);
		$result=$this->m_master_retur_beli->get_satuan_by_produkid($dterima_master, $dterima_produk);
		echo $result;
	}
	
	
	//for detail action
	//list detail handler action
	function  detail_detail_retur_beli_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_retur_beli->detail_detail_retur_beli_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	
	//add detail
	function detail_detail_retur_beli_insert(){
	//POST variable here
		$drbeli_id = $_POST['drbeli_id']; 
        $drbeli_master=trim(@$_POST["drbeli_master"]);
        $drbeli_produk = $_POST['drbeli_produk']; 
		$drbeli_satuan = $_POST['drbeli_satuan']; 
		$drbeli_jumlah = $_POST['drbeli_jumlah'];
		$drbeli_harga = $_POST['drbeli_harga']; 
		$drbeli_diskon = $_POST['drbeli_diskon']; 
		
		$array_drbeli_id = json_decode(stripslashes($drbeli_id));
		$array_drbeli_produk = json_decode(stripslashes($drbeli_produk));
		$array_drbeli_satuan = json_decode(stripslashes($drbeli_satuan));
		$array_drbeli_jumlah = json_decode(stripslashes($drbeli_jumlah));
		$array_drbeli_harga = json_decode(stripslashes($drbeli_harga));
		$array_drbeli_diskon = json_decode(stripslashes($drbeli_diskon));
		
		$result=$this->m_master_retur_beli->detail_detail_retur_beli_insert($array_drbeli_id ,$drbeli_master ,$array_drbeli_produk ,
																			$array_drbeli_satuan ,$array_drbeli_jumlah ,$array_drbeli_harga, 
																			$array_drbeli_diskon );
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_retur_beli_list();
				break;
			case "UPDATE":
				$this->master_retur_beli_update();
				break;
			case "CREATE":
				$this->master_retur_beli_create();
				break;
			case "DELETE":
				$this->master_retur_beli_delete();
				break;
			case "SEARCH":
				$this->master_retur_beli_search();
				break;
			case "PRINT":
				$this->master_retur_beli_print();
				break;
			case "EXCEL":
				$this->master_retur_beli_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_retur_beli_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_retur_beli->master_retur_beli_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function master_retur_beli_update(){
		//POST variable here
		$rbeli_id=trim(@$_POST["rbeli_id"]);
		$rbeli_nobukti=trim(@$_POST["rbeli_nobukti"]);
		$rbeli_terima=trim(@$_POST["rbeli_terima"]);
		$rbeli_supplier=trim(@$_POST["rbeli_supplier"]);
		$rbeli_tanggal=trim(@$_POST["rbeli_tanggal"]);
		$rbeli_keterangan=trim(@$_POST["rbeli_keterangan"]);
		$rbeli_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rbeli_keterangan);
		$rbeli_keterangan=str_replace(",", ",",$rbeli_keterangan);
		$rbeli_keterangan=str_replace("'", '"',$rbeli_keterangan);
		
		$rbeli_status=trim(@$_POST["rbeli_status"]);

		$result = $this->m_master_retur_beli->master_retur_beli_update($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tanggal ,
																	   $rbeli_keterangan, $rbeli_status );
		echo $result;
	}
	
	//function for create new record
	function master_retur_beli_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$rbeli_nobukti=trim(@$_POST["rbeli_nobukti"]);
		$rbeli_terima=trim(@$_POST["rbeli_terima"]);
		$rbeli_supplier=trim(@$_POST["rbeli_supplier"]);
		$rbeli_tanggal=trim(@$_POST["rbeli_tanggal"]);
		$rbeli_keterangan=trim(@$_POST["rbeli_keterangan"]);
		$rbeli_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rbeli_keterangan);
		$rbeli_keterangan=str_replace("'", '"',$rbeli_keterangan);
		
		$rbeli_status=trim(@$_POST["rbeli_status"]);

		$result=$this->m_master_retur_beli->master_retur_beli_create($rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tanggal ,
																	 $rbeli_keterangan, $rbeli_status);
		echo $result;
	}

	//function for delete selected record
	function master_retur_beli_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_retur_beli->master_retur_beli_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_retur_beli_search(){
		//POST varibale here
		$rbeli_id="";
		$rbeli_nobukti=trim(@$_POST["rbeli_nobukti"]);
		$rbeli_terima=trim(@$_POST["rbeli_terima"]);
		$rbeli_supplier=trim(@$_POST["rbeli_supplier"]);
		$rbeli_tgl_awal=trim(@$_POST["rbeli_tgl_awal"]);
		$rbeli_tgl_akhir=trim(@$_POST["rbeli_tgl_akhir"]);
		$rbeli_keterangan=trim(@$_POST["rbeli_keterangan"]);
		$rbeli_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rbeli_keterangan);
		$rbeli_keterangan=str_replace("'", '"',$rbeli_keterangan);
		
		$rbeli_status=trim(@$_POST["rbeli_status"]);

		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_retur_beli->master_retur_beli_search($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tgl_awal ,
																	   $rbeli_tgl_akhir, $rbeli_keterangan, $rbeli_status ,$rbeli_status, $start,
																	   $end);
		echo $result;
	}


	function master_retur_beli_print(){
  		//POST varibale here
		$rbeli_id="";
		$rbeli_nobukti=trim(@$_POST["rbeli_nobukti"]);
		$rbeli_terima=trim(@$_POST["rbeli_terima"]);
		$rbeli_supplier=trim(@$_POST["rbeli_supplier"]);
		$rbeli_tgl_awal=trim(@$_POST["rbeli_tgl_awal"]);
		$rbeli_tgl_akhir=trim(@$_POST["rbeli_tgl_akhir"]);
		$rbeli_keterangan=trim(@$_POST["rbeli_keterangan"]);
		$rbeli_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rbeli_keterangan);
		$rbeli_keterangan=str_replace("'", '"',$rbeli_keterangan);
		
		$rbeli_status=trim(@$_POST["rbeli_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_retur_beli->master_retur_beli_print($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,
																				  $rbeli_tgl_awal, $rbeli_tgl_akhir, $rbeli_keterangan, 
																				  $rbeli_status ,$rbeli_status, $option,$filter);
		$print_view=$this->load->view("main/p_list_retur_beli.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_retur_belilist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';          
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_retur_beli_export_excel(){
		//POST varibale here
		$rbeli_id="";
		$rbeli_nobukti=trim(@$_POST["rbeli_nobukti"]);
		$rbeli_terima=trim(@$_POST["rbeli_terima"]);
		$rbeli_supplier=trim(@$_POST["rbeli_supplier"]);
		$rbeli_tgl_awal=trim(@$_POST["rbeli_tgl_awal"]);
		$rbeli_tgl_akhir=trim(@$_POST["rbeli_tgl_akhir"]);
		$rbeli_keterangan=trim(@$_POST["rbeli_keterangan"]);
		$rbeli_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rbeli_keterangan);
		$rbeli_keterangan=str_replace("'", '"',$rbeli_keterangan);
		
		$rbeli_status=trim(@$_POST["rbeli_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_retur_beli->master_retur_beli_export_excel($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,
																			$rbeli_tgl_awal,$rbeli_tgl_akhir, $rbeli_keterangan, $rbeli_status ,
																			$rbeli_status, $option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"master_retur_beli"); 
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