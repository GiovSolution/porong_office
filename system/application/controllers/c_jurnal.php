<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,

	+ Module  		: jurnal Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_jurnal.php
 	+ creator 		:
 	+ Created on 01/Apr/2010 12:13:56

*/

//class of jurnal
class C_jurnal extends Controller {

	//constructor
	function C_jurnal(){
		parent::Controller();
		session_start();
		$this->load->model('m_jurnal', '', TRUE);
	}

	//set index
	function index(){

		$this->load->view('main/v_jurnal');
	}

	function print_faktur(){

		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_jurnal->print_faktur($faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
        $data['tanggal'] = $master->tanggal;

		$print_view=$this->load->view("main/p_faktur_jurnal.php",$data,TRUE);

		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/jurnal_faktur.html","w+");

		fwrite($print_file, $print_view);
		echo '1';

	}

	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->jurnal_list();
				break;
			case "UPDATE":
				$this->jurnal_update();
				break;
			case "CREATE":
				$this->jurnal_create();
				break;
			case "DELETE":
				$this->jurnal_delete();
				break;
			case "SEARCH":
				$this->jurnal_search();
				break;
			case "PRINT":
				$this->jurnal_print();
				break;
			case "EXCEL":
				$this->jurnal_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}

	function jurnal_reopen(){
		$jurnal_id=isset($_POST['jurnal_id']) ? @$_POST['jurnal_id'] : "";
		$result=$this->m_jurnal->jurnal_reopen($jurnal_id);
		echo $result;
	}

	//function fot list record
	function jurnal_list(){

		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_jurnal->jurnal_list($query,$start,$end);
		echo $result;
	}

	//function fot list record
	function get_detail_jurnal_list(){

		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];

		$result=$this->m_jurnal->get_detail_jurnal_list($task,$master_id,$query,$start,$end);
		echo $result;
	}

	//function fot list record
	function get_akun_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$master_id = (integer) isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];

		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_jurnal->get_akun_list($task, $master_id, $selected_id,$query,$start,$end);
		echo $result;
	}

	function detail_jurnal_insert($master){
		$jurnal_detailid = isset($_POST["jurnal_detailid"])?@$_POST["jurnal_detailid"]:@$_GET["jurnal_detailid"];
		$jurnal_master = $master;
		$jurnal_akun = isset($_POST["jurnal_akun"])?@$_POST["jurnal_akun"]:@$_GET["jurnal_akun"];
		$jurnal_detail = isset($_POST["jurnal_detail"])?@$_POST["jurnal_detail"]:@$_GET["jurnal_detail"];
		$jurnal_debet = isset($_POST["jurnal_debet"])?@$_POST["jurnal_debet"]:@$_GET["jurnal_debet"];
		$jurnal_kredit = isset($_POST["jurnal_kredit"])?@$_POST["jurnal_kredit"]:@$_GET["jurnal_kredit"];

		//encode array
		$jurnal_detailid = json_decode(stripslashes($jurnal_detailid));
		$jurnal_akun = json_decode(stripslashes($jurnal_akun));
		$jurnal_detail = json_decode(stripslashes($jurnal_detail));
		$jurnal_debet = json_decode(stripslashes($jurnal_debet));
		$jurnal_kredit = json_decode(stripslashes($jurnal_kredit));

		$result=$this->m_jurnal->detail_jurnal_insert($jurnal_detailid,$jurnal_master,$jurnal_akun,$jurnal_detail, $jurnal_debet,$jurnal_kredit);
		return $result;
	}

	function detail_jurnal_purge(){
		$jurnal_master = isset($_POST["jurnal_master"])?@$_POST["jurnal_master"]:@$_GET["jurnal_master"];
		$result=$this->m_jurnal->detail_jurnal_purge($jurnal_master);
		echo $result;
	}

	//function for create new record
	function jurnal_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$jurnal_tanggal=trim(@$_POST["jurnal_tanggal"]);
		$jurnal_keterangan=trim(@$_POST["jurnal_keterangan"]);
		$jurnal_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_keterangan);
		$jurnal_noref=trim(@$_POST["jurnal_noref"]);
		$jurnal_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_noref);
		$jurnal_unit=trim(@$_POST["jurnal_unit"]);
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_author=@$_SESSION[SESSION_USERID];
		$jurnal_date_create=date(LONG_FORMATDATE);
		//$jurnal_update=NULL;
		//$jurnal_date_update=NULL;
//		$jurnal_post=trim(@$_POST["jurnal_post"]);
//		$jurnal_post=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_post);
//		$jurnal_post=str_replace("'", "''",$jurnal_post);
//		$jurnal_date_post=trim(@$_POST["jurnal_date_post"]);
		//$jurnal_revised=0;
		$result=$this->m_jurnal->jurnal_create($jurnal_no,$jurnal_tanggal ,$jurnal_keterangan ,$jurnal_noref ,$jurnal_unit ,
														   $jurnal_author ,$jurnal_date_create );
		if($result>0){
			$result=$this->detail_jurnal_insert($result);
		}
		
		echo $result;
	}


	//function for update record
	function jurnal_update(){
		//POST variable here
		$jurnal_id=trim(@$_POST["jurnal_id"]);
		$jurnal_tanggal=trim(@$_POST["jurnal_tanggal"]);
		$jurnal_keterangan=trim(@$_POST["jurnal_keterangan"]);
		$jurnal_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_keterangan);
		$jurnal_noref=trim(@$_POST["jurnal_noref"]);
		$jurnal_noref=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_noref);
		$jurnal_unit=trim(@$_POST["jurnal_unit"]);
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		//$jurnal_author="jurnal_author";
		//$jurnal_date_create="jurnal_date_create";
		$jurnal_update=@$_SESSION[SESSION_USERID];
		$jurnal_date_update=date(LONG_FORMATDATE);
		/*$jurnal_post=trim(@$_POST["jurnal_post"]);
		$jurnal_post=str_replace("/(<\/?)(p)([^>]*>)", "",$jurnal_post);
		$jurnal_post=str_replace("'", "''",$jurnal_post);
		$jurnal_date_post=trim(@$_POST["jurnal_date_post"]);
*/		//$jurnal_revised="(revised+1)";
		$result = $this->m_jurnal->jurnal_update($jurnal_id,$jurnal_no,$jurnal_tanggal,$jurnal_keterangan,$jurnal_noref,$jurnal_unit,
															 $jurnal_update,$jurnal_date_update);
		if($result>0){
			$result=$this->detail_jurnal_insert($result);
		}
		
		echo $result;
	}

	//function for delete selected record
	function jurnal_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_jurnal->jurnal_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function jurnal_search(){
		//POST varibale here
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);

		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_jurnal->jurnal_search($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$start,$end);
		echo $result;
	}


	function jurnal_print(){
  		//POST varibale here
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];

		$data["data_print"] = $this->m_jurnal->jurnal_print($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$option,$filter);
		$print_view=$this->load->view("main/p_jurnal.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/jurnal_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function jurnal_export_excel(){
		$this->load->plugin('to_excel');
		//POST varibale here
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];

		$query = $this->m_jurnal->jurnal_export_excel($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$option,$filter);

		to_excel($query,"jurnal");
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