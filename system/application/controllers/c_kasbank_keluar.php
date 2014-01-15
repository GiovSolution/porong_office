<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,

	+ Module  		: kasbank Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_kasbank_keluar.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:45:40

*/

//class of kasbank
class C_kasbank_keluar extends Controller {

	//constructor
	function C_kasbank_keluar(){
		parent::Controller();
		session_start();
		$this->load->model('m_kasbank', '', TRUE);
	}

	//set index
	function index(){
		$this->load->view('main/v_kasbank_keluar');
	}

	function print_faktur(){

		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_kasbank->print_faktur($faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
        $data['tanggal'] = $master->tanggal;
        $data['master_akun_nama'] = $master->master_akun_nama;
        $data['master_akun_kode'] = $master->master_akun_kode;

        $data['terima_untuk'] = $master->terima_untuk;

		$print_view=$this->load->view("main/p_faktur_kasbank_keluar.php",$data,TRUE);

		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/kasbank_keluar_faktur.html","w+");

		fwrite($print_file, $print_view);
		echo '1';

	}

	function kasbank_reopen(){
		$kasbank_id=isset($_POST['kasbank_id']) ? @$_POST['kasbank_id'] : "";
		$result=$this->m_kasbank->kasbank_reopen($kasbank_id);
		echo $result;
	}

	function get_akun_kasbank(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_kasbank->get_akun_kasbank($query,$start,$end);
		echo $result;
	}

	function get_detail_akun(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$task = isset($_POST['task']) ? @$_POST['task'] : "";
		$master_id = isset($_POST['master_id']) ? @$_POST['master_id'] : "";
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : "";

		$result=$this->m_kasbank->get_detail_akun($task,$master_id,$selected_id,$query,$start,$end);
		echo $result;
	}

	//for detail action
	//list detail handler action
	function  detail_kasbank_keluar_detail_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_kasbank->detail_kasbank_detail_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler

	//purge all detail
	function detail_kasbank_keluar_detail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_kasbank->detail_kasbank_detail_purge($master_id);
	}
	//eof

	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_kasbank->get_master_id();
		echo $result;
	}
	//

	//add detail
	function detail_kasbank_keluar_detail_insert($master){
	//POST variable here
		$dkasbank_keluar_id=trim(@$_POST["dkasbank_keluar_id"]);
		$dkasbank_keluar_master=$master;
		$dkasbank_keluar_akun=trim(@$_POST["dkasbank_keluar_akun"]);
		$dkasbank_keluar_detail=trim(@$_POST["dkasbank_keluar_detail"]);
		$dkasbank_keluar_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$dkasbank_keluar_detail);
		$dkasbank_keluar_detail=str_replace("'", "''",$dkasbank_keluar_detail);
		$dkasbank_keluar_debet=trim(@$_POST["dkasbank_keluar_debet"]);
		$dkasbank_keluar_kredit=trim(@$_POST["dkasbank_keluar_kredit"]);

		$dkasbank_keluar_id = json_decode(stripslashes($dkasbank_keluar_id));
		$dkasbank_keluar_akun = json_decode(stripslashes($dkasbank_keluar_akun));
		$dkasbank_keluar_detail = json_decode(stripslashes($dkasbank_keluar_detail));
		$dkasbank_keluar_debet = json_decode(stripslashes($dkasbank_keluar_debet));

		$result=$this->m_kasbank->detail_kasbank_detail_insert($dkasbank_keluar_id ,$dkasbank_keluar_master ,$dkasbank_keluar_akun ,
															   $dkasbank_keluar_detail ,$dkasbank_keluar_debet ,$dkasbank_keluar_kredit );

		return $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->kasbank_keluar_list();
				break;
			case "UPDATE":
				$this->kasbank_keluar_update();
				break;
			case "CREATE":
				$this->kasbank_keluar_create();
				break;
			case "DELETE":
				$this->kasbank_keluar_delete();
				break;
			case "SEARCH":
				$this->kasbank_keluar_search();
				break;
			case "PRINT":
				$this->kasbank_keluar_print();
				break;
			case "EXCEL":
				$this->kasbank_keluar_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}

	//function fot list record
	function kasbank_keluar_list(){

		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_kasbank->kasbank_list($query,$start,$end,"keluar");
		echo $result;
	}

	//function for create new record
	function kasbank_keluar_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$kasbank_keluar_tanggal=trim(@$_POST["kasbank_keluar_tanggal"]);
		$kasbank_keluar_nobukti=trim(@$_POST["kasbank_keluar_nobukti"]);
		$kasbank_keluar_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_nobukti);
		$kasbank_keluar_akun=trim(@$_POST["kasbank_keluar_akun"]);
		$kasbank_keluar_terimauntuk=trim(@$_POST["kasbank_keluar_terimauntuk"]);
		$kasbank_keluar_terimauntuk=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_terimauntuk);
		$kasbank_keluar_jenis=trim(@$_POST["kasbank_keluar_jenis"]);
		$kasbank_keluar_noref=trim(@$_POST["kasbank_keluar_noref"]);
		$kasbank_keluar_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_noref);
		$kasbank_keluar_keterangan=trim(@$_POST["kasbank_keluar_keterangan"]);
		$kasbank_keluar_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_keterangan);
		$kasbank_keluar_author=@$_SESSION[SESSION_USERID];
		$kasbank_keluar_date_create=date(LONG_FORMATDATE);
		//$kasbank_keluar_update=NULL;
		//$kasbank_keluar_date_update=NULL;
		$kasbank_keluar_post=trim(@$_POST["kasbank_keluar_post"]);
		$kasbank_keluar_post=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_post);
		$kasbank_keluar_post=str_replace("'", "''",$kasbank_keluar_post);
		$kasbank_keluar_date_post=trim(@$_POST["kasbank_keluar_date_post"]);
		//$kasbank_keluar_revised=0;
		$result=$this->m_kasbank->kasbank_create($kasbank_keluar_tanggal ,$kasbank_keluar_nobukti ,$kasbank_keluar_akun ,
												 $kasbank_keluar_terimauntuk ,"keluar",$kasbank_keluar_jenis ,$kasbank_keluar_noref ,
												 $kasbank_keluar_keterangan ,$kasbank_keluar_author ,$kasbank_keluar_date_create ,
												 $kasbank_keluar_post, $kasbank_keluar_date_post );
		if($result>0){
			$result=$this->detail_kasbank_keluar_detail_insert($result);
		}
		
		echo $result;
	}


	//function for update record
	function kasbank_keluar_update(){
		//POST variable here
		$kasbank_keluar_id=trim(@$_POST["kasbank_keluar_id"]);
		$kasbank_keluar_tanggal=trim(@$_POST["kasbank_keluar_tanggal"]);
		$kasbank_keluar_nobukti=trim(@$_POST["kasbank_keluar_nobukti"]);
		$kasbank_keluar_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_nobukti);
		$kasbank_keluar_akun=trim(@$_POST["kasbank_keluar_akun"]);
		$kasbank_keluar_terimauntuk=trim(@$_POST["kasbank_keluar_terimauntuk"]);
		$kasbank_keluar_terimauntuk=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_terimauntuk);
		$kasbank_keluar_jenis=trim(@$_POST["kasbank_keluar_jenis"]);
		$kasbank_keluar_noref=trim(@$_POST["kasbank_keluar_noref"]);
		$kasbank_keluar_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_noref);
		$kasbank_keluar_keterangan=trim(@$_POST["kasbank_keluar_keterangan"]);
		$kasbank_keluar_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_keterangan);
		//$kasbank_keluar_author="kasbank_keluar_author";
		//$kasbank_keluar_date_create="kasbank_keluar_date_create";
		$kasbank_keluar_update=@$_SESSION[SESSION_USERID];
		$kasbank_keluar_date_update=date(LONG_FORMATDATE);
		$kasbank_keluar_post=trim(@$_POST["kasbank_keluar_post"]);
		$kasbank_keluar_post=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_post);
		$kasbank_keluar_date_post=trim(@$_POST["kasbank_keluar_date_post"]);
		//$kasbank_keluar_revised="(revised+1)";
		$result = $this->m_kasbank->kasbank_update($kasbank_keluar_id,$kasbank_keluar_tanggal,$kasbank_keluar_nobukti,$kasbank_keluar_akun,
												   $kasbank_keluar_terimauntuk,"keluar",$kasbank_keluar_jenis,$kasbank_keluar_noref,
												   $kasbank_keluar_keterangan,$kasbank_keluar_update,$kasbank_keluar_date_update,
												   $kasbank_keluar_post,$kasbank_keluar_date_post);
		if($result>0){
			$result=$this->detail_kasbank_keluar_detail_insert($result);
		}
		
		echo $result;
	}

	//function for delete selected record
	function kasbank_keluar_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_kasbank->kasbank_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function kasbank_keluar_search(){
		//POST varibale here
		$kasbank_keluar_id=trim(@$_POST["kasbank_keluar_id"]);
		$kasbank_keluar_tgl_awal=trim(@$_POST["kasbank_keluar_tgl_awal"]);
		$kasbank_keluar_tgl_akhir=trim(@$_POST["kasbank_keluar_tgl_akhir"]);
		$kasbank_keluar_nobukti=trim(@$_POST["kasbank_keluar_nobukti"]);
		$kasbank_keluar_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_nobukti);
		$kasbank_keluar_akun=trim(@$_POST["kasbank_keluar_akun"]);
		$kasbank_keluar_terimauntuk=trim(@$_POST["kasbank_keluar_terimauntuk"]);
		$kasbank_keluar_terimauntuk=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_terimauntuk);
		$kasbank_keluar_jenis="keluar";
		$kasbank_keluar_noref=trim(@$_POST["kasbank_keluar_noref"]);
		$kasbank_keluar_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_noref);
		$kasbank_keluar_keterangan=trim(@$_POST["kasbank_keluar_keterangan"]);
		$kasbank_keluar_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_keterangan);
		$kasbank_keluar_author=trim(@$_POST["kasbank_keluar_author"]);
		$kasbank_keluar_author=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_author);
		$kasbank_keluar_date_create=trim(@$_POST["kasbank_keluar_date_create"]);
		$kasbank_keluar_update=trim(@$_POST["kasbank_keluar_update"]);
		$kasbank_keluar_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_update);
		$kasbank_keluar_date_update=trim(@$_POST["kasbank_keluar_date_update"]);
		$kasbank_keluar_post=trim(@$_POST["kasbank_keluar_post"]);
		$kasbank_keluar_post=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_post);
		$kasbank_keluar_date_post=trim(@$_POST["kasbank_keluar_date_post"]);
		$kasbank_keluar_revised=trim(@$_POST["kasbank_keluar_revised"]);

		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kasbank->kasbank_search($kasbank_keluar_id ,$kasbank_keluar_tgl_awal , $kasbank_keluar_tgl_akhir, $kasbank_keluar_nobukti ,$kasbank_keluar_akun ,
												   $kasbank_keluar_terimauntuk ,$kasbank_keluar_jenis ,$kasbank_keluar_noref ,
												   $kasbank_keluar_keterangan ,$kasbank_keluar_author ,$kasbank_keluar_date_create ,
												   $kasbank_keluar_update ,$kasbank_keluar_date_update ,$kasbank_keluar_post ,
												   $kasbank_keluar_date_post ,$kasbank_keluar_revised ,$start,$end);
		echo $result;
	}


	function kasbank_keluar_print(){
  		//POST varibale here
		$kasbank_keluar_id=trim(@$_POST["kasbank_keluar_id"]);
		$kasbank_keluar_tgl_awal=trim(@$_POST["kasbank_keluar_tgl_awal"]);
		$kasbank_keluar_tgl_akhir=trim(@$_POST["kasbank_keluar_tgl_akhir"]);
		$kasbank_keluar_nobukti=trim(@$_POST["kasbank_keluar_nobukti"]);
		$kasbank_keluar_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_nobukti);
		$kasbank_keluar_akun=trim(@$_POST["kasbank_keluar_akun"]);
		$kasbank_keluar_terimauntuk=trim(@$_POST["kasbank_keluar_terimauntuk"]);
		$kasbank_keluar_terimauntuk=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_terimauntuk);
		$kasbank_keluar_jenis="keluar";
		$kasbank_keluar_noref=trim(@$_POST["kasbank_keluar_noref"]);
		$kasbank_keluar_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_noref);
		$kasbank_keluar_keterangan=trim(@$_POST["kasbank_keluar_keterangan"]);
		$kasbank_keluar_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_keterangan);
		$kasbank_keluar_author=trim(@$_POST["kasbank_keluar_author"]);
		$kasbank_keluar_author=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_author);
		$kasbank_keluar_date_create=trim(@$_POST["kasbank_keluar_date_create"]);
		$kasbank_keluar_update=trim(@$_POST["kasbank_keluar_update"]);
		$kasbank_keluar_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_update);
		$kasbank_keluar_date_update=trim(@$_POST["kasbank_keluar_date_update"]);
		$kasbank_keluar_post=trim(@$_POST["kasbank_keluar_post"]);
		$kasbank_keluar_post=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_post);
		$kasbank_keluar_date_post=trim(@$_POST["kasbank_keluar_date_post"]);
		$kasbank_keluar_revised=trim(@$_POST["kasbank_keluar_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];

		$data["data_print"] = $this->m_kasbank->kasbank_print($kasbank_keluar_id ,$kasbank_keluar_tgl_awal, $kasbank_keluar_tgl_akhir ,$kasbank_keluar_nobukti ,
															  $kasbank_keluar_akun ,$kasbank_keluar_terimauntuk ,$kasbank_keluar_jenis ,
															  $kasbank_keluar_noref ,$kasbank_keluar_keterangan ,$kasbank_keluar_author ,
															  $kasbank_keluar_date_create ,$kasbank_keluar_update ,$kasbank_keluar_date_update ,
															  $kasbank_keluar_post ,$kasbank_keluar_date_post ,$kasbank_keluar_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_kasbank_keluar.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/kasbank_keluar_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function kasbank_keluar_export_excel(){
		//POST varibale here
		$kasbank_keluar_id=trim(@$_POST["kasbank_keluar_id"]);
		$kasbank_keluar_tanggal=trim(@$_POST["kasbank_keluar_tanggal"]);
		$kasbank_keluar_nobukti=trim(@$_POST["kasbank_keluar_nobukti"]);
		$kasbank_keluar_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_nobukti);
		$kasbank_keluar_akun=trim(@$_POST["kasbank_keluar_akun"]);
		$kasbank_keluar_terimauntuk=trim(@$_POST["kasbank_keluar_terimauntuk"]);
		$kasbank_keluar_terimauntuk=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_terimauntuk);
		$kasbank_keluar_jenis="keluar";
		$kasbank_keluar_noref=trim(@$_POST["kasbank_keluar_noref"]);
		$kasbank_keluar_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_noref);
		$kasbank_keluar_keterangan=trim(@$_POST["kasbank_keluar_keterangan"]);
		$kasbank_keluar_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_keterangan);
		$kasbank_keluar_author=trim(@$_POST["kasbank_keluar_author"]);
		$kasbank_keluar_author=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_author);
		$kasbank_keluar_date_create=trim(@$_POST["kasbank_keluar_date_create"]);
		$kasbank_keluar_update=trim(@$_POST["kasbank_keluar_update"]);
		$kasbank_keluar_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_update);
		$kasbank_keluar_date_update=trim(@$_POST["kasbank_keluar_date_update"]);
		$kasbank_keluar_post=trim(@$_POST["kasbank_keluar_post"]);
		$kasbank_keluar_post=str_replace("/(<\/?)(p)([^>]*>)", "",$kasbank_keluar_post);
		$kasbank_keluar_date_post=trim(@$_POST["kasbank_keluar_date_post"]);
		$kasbank_keluar_revised=trim(@$_POST["kasbank_keluar_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];

		$query = $this->m_kasbank->kasbank_export_excel($kasbank_keluar_id ,$kasbank_keluar_tanggal ,$kasbank_keluar_nobukti ,$kasbank_keluar_akun ,
														$kasbank_keluar_terimauntuk ,$kasbank_keluar_jenis ,$kasbank_keluar_noref ,
														$kasbank_keluar_keterangan ,$kasbank_keluar_author ,$kasbank_keluar_date_create ,
														$kasbank_keluar_update ,$kasbank_keluar_date_update ,$kasbank_keluar_post ,
														$kasbank_keluar_date_post ,$kasbank_keluar_revised ,$option,$filter);

		to_excel($query,"kasbank");
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


}
?>