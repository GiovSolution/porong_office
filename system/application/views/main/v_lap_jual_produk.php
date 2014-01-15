<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: info View
	+ Description	: For record view
	+ Filename 		: v_info.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 14/Jul/2009 15:33:36
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<style type="text/css">
	p { width:650px; }
	.search-item {
		font:normal 11px tahoma, arial, helvetica, sans-serif;
		padding:3px 10px 3px 10px;
		border:1px solid #fff;
		border-bottom:1px solid #eeeeee;
		white-space:normal;
		color:#555;
	}
	.search-item h3 {
		display:block;
		font:inherit;
		font-weight:bold;
		color:#222;
	}
	
	.search-item h3 span {
		float: right;
		font-weight:normal;
		margin:0 0 5px 5px;
		width:100px;
		display:block;
		clear:none;
	}
</style>
<script>

var rpt_jrpdukWindow;
var rpt_jrpdukForm;

var rpt_jproduk_tglawalField;
var rpt_jproduk_tglakhirField;
var rpt_jproduk_rekapField;
var rpt_jproduk_detailField;
var rpt_jproduk_groomingField;
var rpt_jproduk_semuaField;
var rpt_jproduk_tertutupField;
var rpt_jproduk_bulanField;
var rpt_jproduk_tahunField;
var rpt_jproduk_opsitglField;
var rpt_jproduk_opsiblnField;
var rpt_jproduk_opsiallField;
var rpt_jproduk_groupField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],80); ?>";//akan mengembalikan nilai '1' jika centangan 'Semua Tgl' di menu User Groups dicentang, dan mengembalikan tanggal awal periode akun jika tidak tercentang (yyyy-mm-dd)

<? 
	$tahun_cek = $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],80);
	$cek = substr($tahun_cek,0,4); //mengambil tahun dr nilai yg dikembalikan dr $tahun_cek
	if(strlen($cek)==1){ //jika 'Semua Tgl' tercentang
		$tahun="[";
		for($i=(date('Y')-4);$i<=date('Y');$i++){
			$tahun.="['$i'],";
		}
		$tahun=substr($tahun,0,strlen($tahun)-1);
		$tahun.="]";
		$bulan="";
	} else { //jika tidak tercentang, mengembalikan tanggal awal periode akun dan $tahun hanya berisi tahun ybs (jd user tidak dpt melihat tahun2 sebelumnya)
		$tahun.="[[".$cek."]]";
	}
?>

<?
$idForm=24;
?>

Ext.apply(Ext.form.VTypes, {
    daterange : function(val, field) {
        var date = field.parseDate(val);

        if(!date){
            return;
        }
        if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
            var start = Ext.getCmp(field.startDateField);
            start.setMaxValue(date);
            start.validate();
            this.dateRangeMax = date;
        } 
        else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
            var end = Ext.getCmp(field.endDateField);
            end.setMinValue(date);
            end.validate();
            this.dateRangeMin = date;
        }
        return true;
    }
});

Ext.onReady(function(){
  Ext.QuickTips.init();
  
	// function utk welcome message
	/*Data Store khusus utk menampung welcome mesage */
	lap_produk_welcome_msgDataStore = new Ext.data.Store({
		id: 'lap_produk_welcome_msgDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_welcome_msg&m=get_welcome_message', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results'
		},[
			{name: 'welcome_id', type: 'int', mapping: 'welcome_id'},
			{name: 'welcome_msg', type: 'string', mapping: 'welcome_msg'},
			{name: 'welcome_title', type: 'string', mapping: 'welcome_title'},
			{name: 'welcome_icon', type: 'string', mapping: 'welcome_icon'}
		]),
		sortInfo:{field: 'welcome_id', direction: "ASC"}
	});

	lap_produk_welcome_msgDataStore.load({
		params: {task : "LIST", menu_id : 37},
			callback: function(opts, success, response)  {
				if (success) {					
					if(lap_produk_welcome_msgDataStore.getCount()){
						if (lap_produk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'INFO') {
							var lap_produk_icon = Ext.MessageBox.INFO;
						} else if (lap_produk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'WARNING'){
							var lap_produk_icon = Ext.MessageBox.WARNING;
						} else if (lap_produk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'QUESTION'){
							var lap_produk_icon = Ext.MessageBox.QUESTION;
						} else if (lap_produk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'ERROR'){
							var lap_produk_icon = Ext.MessageBox.ERROR;
						}
					
						Ext.MessageBox.show({
							title: lap_produk_welcome_msgDataStore.getAt(0).data.welcome_title,
							msg: lap_produk_welcome_msgDataStore.getAt(0).data.welcome_msg,
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: lap_produk_icon
						});
					}
				}
			}
	});	
	// eof function utk welcome message

	var group_master_Store= new Ext.data.SimpleStore({
			id: 'group_master_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer'],['Voucher']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Tanggal 2 (PPN)'],['Customer'],['Produk'],['Sales'],['Jenis Diskon'],['Group 1'],['No Faktur BPOM'] ]
	});
	
	var group_grooming_Store= new Ext.data.SimpleStore({
			id: 'group_grooming_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Karyawan']]
	});
	
	var rpt_jproduk_groupField=new Ext.form.ComboBox({
		id:'rpt_jproduk_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 100,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_jproduk_bulanField=new Ext.form.ComboBox({
		id:'rpt_jproduk_bulanField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: thismonth,
		width: 100,
		triggerAction: 'all'
	});
	
	rpt_jproduk_tahunField=new Ext.form.ComboBox({
		id:'rpt_jproduk_tahunField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['tahun'],
			data: <?php echo $tahun; ?>
		}),
		mode: 'local',
		displayField: 'tahun',
		valueField: 'tahun',
		value: thisyear,
		width: 100,
		triggerAction: 'all'
	});
	
	rpt_jproduk_opsitglField=new Ext.form.Radio({
		id:'rpt_jproduk_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_jproduk_opsiblnField=new Ext.form.Radio({
		id:'rpt_jproduk_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_jproduk_opsiallField=new Ext.form.Radio({
		id:'rpt_jproduk_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_jproduk_tglawalField= new Ext.form.DateField({
		id: 'rpt_jproduk_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_jproduk_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_jproduk_tglakhirField'
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jproduk_tglakhirField= new Ext.form.DateField({
		id: 'rpt_jproduk_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_jproduk_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_jproduk_tglawalField',
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jproduk_rekapField=new Ext.form.Radio({
		id: 'rpt_jproduk_rekapField',
		boxLabel: 'Rekap',
		name: 'jproduk_opsi',
		checked: true
	});
	
	rpt_jproduk_detailField=new Ext.form.Radio({
		id: 'rpt_jproduk_detailField',
		boxLabel: 'Detail',
		name: 'jproduk_opsi'
	});
	
	rpt_jproduk_groomingField=new Ext.form.Radio({
		id: 'rpt_jproduk_groomingField',
		boxLabel: 'Grooming',
		name: 'jproduk_opsi'
	});
	
	// opsi status
	rpt_jproduk_tertutupField=new Ext.form.Radio({
		id: 'rpt_jproduk_tertutupField',
		boxLabel: 'Tertutup',
		name: 'jproduk_opsi_status'
	});
	
	rpt_jproduk_semuaField=new Ext.form.Radio({
		id: 'rpt_jproduk_semuaField',
		boxLabel: 'Semua',
		name: 'jproduk_opsi_status'
	});
	

	// eof opsi status
	
	var rpt_jproduk_periodeField=new Ext.form.FieldSet({
		id:'rpt_jproduk_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_jproduk_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_jproduk_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jproduk_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jproduk_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_jproduk_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jproduk_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jproduk_tahunField]
					   }]
			}]
	});
	
	var	rpt_jproduk_opsiField=new Ext.form.FieldSet({
		id: 'rpt_jproduk_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_jproduk_rekapField ,rpt_jproduk_detailField,rpt_jproduk_groomingField]
	});
	
	// opsi status
	var	rpt_jproduk_opsistatusField=new Ext.form.FieldSet({
		id: 'rpt_jproduk_opsistatusField',
		title: 'Opsi Status Dok',
		border: true,
		anchor: '98%',
		items: [rpt_jproduk_tertutupField, rpt_jproduk_semuaField]
	});
	
	var	rpt_jproduk_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_jproduk_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_jproduk_groupField]
	});
	
	function is_valid_form(){
		if(rpt_jproduk_opsitglField.getValue()==true){
			rpt_jproduk_tglawalField.allowBlank=false;
			rpt_jproduk_tglakhirField.allowBlank=false;
			if(rpt_jproduk_tglawalField.isValid() && rpt_jproduk_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_jproduk_tglawalField.allowBlank=true;
			rpt_jproduk_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_jproduk(){
		
		var jproduk_tglawal="";
		var jproduk_tglakhir="";
		var jrpdouk_opsi="";
		var jproduk_bulan="";
		var jproduk_tahun="";
		var jproduk_periode="";
		var jproduk_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_jproduk_tglawalField.getValue()!==""){jproduk_tglawal = rpt_jproduk_tglawalField.getValue().format('Y-m-d');}
		if(rpt_jproduk_tglakhirField.getValue()!==""){jproduk_tglakhir = rpt_jproduk_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_jproduk_bulanField.getValue()!==""){jproduk_bulan=rpt_jproduk_bulanField.getValue(); }
		if(rpt_jproduk_tahunField.getValue()!==""){jproduk_tahun=rpt_jproduk_tahunField.getValue(); }
		if(rpt_jproduk_opsitglField.getValue()==true){
			jproduk_periode='tanggal';
		}else if(rpt_jproduk_opsiblnField.getValue()==true){
			jproduk_periode='bulan';
		}else{
			jproduk_periode='all';
		}
		if(rpt_jproduk_groupField.getValue()!==""){jproduk_group=rpt_jproduk_groupField.getValue(); }
		
		if(rpt_jproduk_rekapField.getValue()==true){jproduk_opsi='rekap';}
		if(rpt_jproduk_detailField.getValue()==true){jproduk_opsi='detail';}
		if(rpt_jproduk_groomingField.getValue()==true){jproduk_opsi='grooming';}
		
		if(rpt_jproduk_semuaField.getValue()==true){jproduk_opsi_status='semua';}
		if(rpt_jproduk_tertutupField.getValue()==true){jproduk_opsi_status='tertutup';}

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_master_jual_produk&m=print_laporan',
				params: {
					tgl_awal	: jproduk_tglawal,
					tgl_akhir	: jproduk_tglakhir,
					opsi		: jproduk_opsi,
					opsi_status	: jproduk_opsi_status,
					bulan		: jproduk_bulan,
					tahun		: jproduk_tahun,
					periode		: jproduk_periode,
					group		: jproduk_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_jproduk.html','report_jproduk','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
						//
						break;
					default:
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Unable to print the report!',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING
						});
						break;
					}  
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});		
				} 	                     
			});
		}else{
			Ext.MessageBox.show({
			   title: 'Warning',
			   msg: 'Not valid form.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.WARNING
			});	
		}
	}
	/* Enf Function */
	
	rpt_jrpdukForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_jproduk_periodeField,rpt_jproduk_opsiField, rpt_jproduk_groupbyField, rpt_jproduk_opsistatusField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_jproduk
			},{
				text: 'Close',
				handler: function(){
					rpt_jprodukWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_jprodukWindow = new Ext.Window({
		title: 'Laporan Penjualan Produk',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_jproduk',
		items: rpt_jrpdukForm
	});
  	rpt_jprodukWindow.show();
	
	//EVENTS
	
	rpt_jproduk_rekapField.on("check", function(){
		rpt_jproduk_groupField.setValue('No faktur');
		if(rpt_jproduk_rekapField.getValue()==true){
			rpt_jproduk_groupField.bindStore(group_master_Store);
			rpt_jproduk_semuaField.setDisabled(true);
			rpt_jproduk_tertutupField.setDisabled(true);
			rpt_jproduk_tertutupField.setValue(true);
		}
	});
	
	rpt_jproduk_detailField.on("check", function(){
		rpt_jproduk_groupField.setValue('No Faktur');
		if(rpt_jproduk_detailField.getValue()==true){
			rpt_jproduk_groupField.bindStore(group_detail_Store);
			rpt_jproduk_semuaField.setDisabled(false);
			rpt_jproduk_tertutupField.setDisabled(false);
			rpt_jproduk_tertutupField.setValue(true);
		}
	});
	
	rpt_jproduk_opsitglField.on("check",function(){
		if(rpt_jproduk_opsitglField.getValue()==true){
			rpt_jproduk_tglawalField.allowBlank=false;
			rpt_jproduk_tglakhirField.allowBlank=false;
		}else{
			rpt_jproduk_tglawalField.allowBlank=true;
			rpt_jproduk_tglakhirField.allowBlank=true;
		}
		
	});
	
	rpt_jproduk_groomingField.on("check", function(){
		rpt_jproduk_groupField.setValue('No faktur');
		if(rpt_jproduk_groomingField.getValue()==true){
			rpt_jproduk_groupField.bindStore(group_grooming_Store);
			rpt_jproduk_semuaField.setDisabled(true);
			rpt_jproduk_tertutupField.setDisabled(true);
			rpt_jproduk_tertutupField.setValue(true);
		}
	});
	// event opsi status
	rpt_jproduk_groupField.on("select",function(){
	if(rpt_jproduk_groupField.getValue()=='No Faktur' && rpt_jproduk_detailField.getValue()==true ){
		rpt_jproduk_semuaField.setDisabled(false);
		rpt_jproduk_tertutupField.setDisabled(false);
		rpt_jproduk_semuaField.setValue(true);
	}
	else
	{
		rpt_jproduk_semuaField.setDisabled(true);
		rpt_jproduk_tertutupField.setDisabled(true);
		rpt_jproduk_tertutupField.setValue(true);
	}
	});
	
	// pertamax
	rpt_jproduk_semuaField.setDisabled(true);
	rpt_jproduk_tertutupField.setDisabled(true);
	rpt_jproduk_tertutupField.setValue(true);

	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_jproduk"></div>
    </div>
</div>
</body>