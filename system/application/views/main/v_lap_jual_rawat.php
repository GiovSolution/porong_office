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
</head>
<script>

var rpt_jrpdukWindow;
var rpt_jrpdukForm;

/* declare variable here */
var rpt_jrawat_tglawalField;
var rpt_jrawat_tglakhirField;
var rpt_jrawat_rekapField;
var rpt_jrawat_detailField;
var rpt_jrawat_groomingField;
var rpt_jrawat_tertutupField;
var rpt_jrawat_semuaField;
var rpt_jrawat_bulanField;
var rpt_jrawat_tahunField;
var rpt_jrawat_opsitglField;
var rpt_jrawat_opsiblnField;
var rpt_jrawat_opsiallField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],81); ?>";//akan mengembalikan nilai '1' jika centangan 'Semua Tgl' di menu User Groups dicentang, dan mengembalikan tanggal awal periode akun jika tidak tercentang (yyyy-mm-dd)

<? 
	$tahun_cek = $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],81);
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
	
	var group_master_Store= new Ext.data.SimpleStore({
			id: 'group_master_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer'],['Voucher']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Tanggal 2 (PPN)'],['Customer'],['Perawatan Semua'],['Perawatan Medis'],['Perawatan Non Medis'],['Perawatan Anti Aging'],['Perawatan Surgery'],['Perawatan Lain-Lain'],['Referal'],['Jenis Diskon']]
	});
	
	var group_grooming_Store= new Ext.data.SimpleStore({
			id: 'group_grooming_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Tanggal 2'],['Karyawan']]
	});
	
	var rpt_jrawat_groupField=new Ext.form.ComboBox({
		id:'rpt_jrawat_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 200,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_jrawat_bulanField=new Ext.form.ComboBox({
		id:'rpt_jrawat_bulanField',
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
	
	rpt_jrawat_tahunField=new Ext.form.ComboBox({
		id:'rpt_jrawat_tahunField',
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
	
	rpt_jrawat_opsitglField=new Ext.form.Radio({
		id:'rpt_jrawat_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_jrawat_opsiblnField=new Ext.form.Radio({
		id:'rpt_jrawat_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_jrawat_opsiallField=new Ext.form.Radio({
		id:'rpt_jrawat_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_jrawat_tglawalField= new Ext.form.DateField({
		id: 'rpt_jrawat_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_jrawat_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_jrawat_tglakhirField'
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jrawat_tglakhirField= new Ext.form.DateField({
		id: 'rpt_jrawat_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_jrawat_tglakhirField',
       // vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_jrawat_tglawalField',
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jrawat_rekapField=new Ext.form.Radio({
		id: 'rpt_jrawat_rekapField',
		boxLabel: 'Rekap',
		name: 'jrawat_opsi',
		checked: true
	});
	
	rpt_jrawat_detailField=new Ext.form.Radio({
		id: 'rpt_jrawat_detailField',
		boxLabel: 'Detail',
		name: 'jrawat_opsi'
	});
	
	rpt_jrawat_groomingField=new Ext.form.Radio({
		id: 'rpt_jrawat_groomingField',
		boxLabel: 'Grooming',
		name: 'jrawat_opsi'
	});
	
	// opsi status
	rpt_jrawat_tertutupField=new Ext.form.Radio({
		id: 'rpt_jrawat_tertutupField',
		boxLabel: 'Tertutup',
		name: 'jrawat_opsi_status',
		checked: true
	});
	
	rpt_jrawat_semuaField=new Ext.form.Radio({
		id: 'rpt_jrawat_semuaField',
		boxLabel: 'Semua',
		name: 'jrawat_opsi_status',
		checked: false
	});
	// eof opsi status
	
	var rpt_jrawat_periodeField=new Ext.form.FieldSet({
		id:'rpt_jrawat_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_jrawat_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_jrawat_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jrawat_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jrawat_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_jrawat_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jrawat_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jrawat_tahunField]
					   }]
			}]
	});
	
	var	rpt_jrawat_opsiField=new Ext.form.FieldSet({
		id: 'rpt_jrawat_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_jrawat_rekapField ,rpt_jrawat_detailField, rpt_jrawat_groomingField]
	});
	
	// opsi status
	var	rpt_jrawat_opsistatusField=new Ext.form.FieldSet({
		id: 'rpt_jrawat_opsistatusField',
		title: 'Opsi_Status',
		border: true,
		anchor: '98%',
		items: [rpt_jrawat_tertutupField ,rpt_jrawat_semuaField]
	});
	
	var	rpt_jrawat_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_jrawat_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_jrawat_groupField]
	});
	
	function is_valid_form(){
		if(rpt_jrawat_opsitglField.getValue()==true){
			rpt_jrawat_tglawalField.allowBlank=false;
			rpt_jrawat_tglakhirField.allowBlank=false;
			if(rpt_jrawat_tglawalField.isValid() && rpt_jrawat_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_jrawat_tglawalField.allowBlank=true;
			rpt_jrawat_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_jrawat(){
		
		var jrawat_tglawal="";
		var jrawat_tglakhir="";
		var jrawat_opsi="";
		var jrawat_opsi_status="";
		var jrawat_bulan="";
		var jrawat_tahun="";
		var jrawat_periode="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_jrawat_tglawalField.getValue()!==""){jrawat_tglawal = rpt_jrawat_tglawalField.getValue().format('Y-m-d');}
		if(rpt_jrawat_tglakhirField.getValue()!==""){jrawat_tglakhir = rpt_jrawat_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_jrawat_bulanField.getValue()!==""){jrawat_bulan=rpt_jrawat_bulanField.getValue(); }
		if(rpt_jrawat_tahunField.getValue()!==""){jrawat_tahun=rpt_jrawat_tahunField.getValue(); }
		if(rpt_jrawat_opsitglField.getValue()==true){
			jrawat_periode='tanggal';
		}else if(rpt_jrawat_opsiblnField.getValue()==true){
			jrawat_periode='bulan';
		}else{
			jrawat_periode='all';
		}
		if(rpt_jrawat_groupField.getValue()!==""){jrawat_group=rpt_jrawat_groupField.getValue(); }
		
		if(rpt_jrawat_rekapField.getValue()==true){jrawat_opsi='rekap';}
		if(rpt_jrawat_detailField.getValue()==true){jrawat_opsi='detail';}
		if(rpt_jrawat_groomingField.getValue()==true){jrawat_opsi='grooming';}
		
		if(rpt_jrawat_tertutupField.getValue()==true){jrawat_opsi_status='tertutup';}
		if(rpt_jrawat_semuaField.getValue()==true){jrawat_opsi_status='semua';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_master_jual_rawat&m=print_laporan',
				params: {
					tgl_awal	: jrawat_tglawal,
					tgl_akhir	: jrawat_tglakhir,
					opsi		: jrawat_opsi,
					bulan		: jrawat_bulan,
					tahun		: jrawat_tahun,
					periode		: jrawat_periode,
					group		: jrawat_group,
					opsi_status	: jrawat_opsi_status
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_jrawat.html','report_jrawat','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
		items: [rpt_jrawat_periodeField,rpt_jrawat_opsiField,rpt_jrawat_groupbyField, rpt_jrawat_opsistatusField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_jrawat
			},{
				text: 'Close',
				handler: function(){
					rpt_jrawatWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_jrawatWindow = new Ext.Window({
		title: 'Laporan Penjualan Perawatan',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_jrawat',
		items: rpt_jrpdukForm
	});
  	rpt_jrawatWindow.show();
	
	//EVENTS
	
	rpt_jrawat_rekapField.on("check", function(){
		rpt_jrawat_groupField.setValue('No faktur');
		if(rpt_jrawat_rekapField.getValue()==true){
			rpt_jrawat_groupField.bindStore(group_master_Store);
			rpt_jrawat_semuaField.setDisabled(true);
			rpt_jrawat_tertutupField.setDisabled(true);
			rpt_jrawat_tertutupField.setValue(true);
		}else
		{
			rpt_jrawat_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_jrawat_detailField.on("check", function(){
		rpt_jrawat_groupField.setValue('No Faktur');
		if(rpt_jrawat_detailField.getValue()==true){
			rpt_jrawat_groupField.bindStore(group_detail_Store);
			rpt_jrawat_semuaField.setDisabled(false);
			rpt_jrawat_tertutupField.setDisabled(false);
			rpt_jrawat_tertutupField.setValue(true);
		}else
		{
			rpt_jrawat_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_jrawat_groomingField.on("check", function(){
		rpt_jrawat_groupField.setValue('No Faktur');
		if(rpt_jrawat_groomingField.getValue()==true){
			rpt_jrawat_groupField.bindStore(group_grooming_Store);
			rpt_jrawat_semuaField.setDisabled(true);
			rpt_jrawat_tertutupField.setDisabled(true);
			rpt_jrawat_tertutupField.setValue(true);
		}else if(rpt_jrawat_detailField.getValue()==true)
		{
			rpt_jrawat_groupField.bindStore(group_detail_Store);
		}
	});
	
	
	rpt_jrawat_opsitglField.on("check",function(){
		if(rpt_jrawat_opsitglField.getValue()==true){
			rpt_jrawat_tglawalField.allowBlank=false;
			rpt_jrawat_tglakhirField.allowBlank=false;
		}else{
			rpt_jrawat_tglawalField.allowBlank=true;
			rpt_jrawat_tglakhirField.allowBlank=true;
		}
	});
	
	// event opsi status
	rpt_jrawat_groupField.on("select",function(){
	if(rpt_jrawat_groupField.getValue()=='No Faktur' && rpt_jrawat_detailField.getValue()==true ){
		rpt_jrawat_semuaField.setDisabled(false);
		rpt_jrawat_tertutupField.setDisabled(false);
		rpt_jrawat_semuaField.setValue(true);
	}
	else
	{
		rpt_jrawat_semuaField.setDisabled(true);
		rpt_jrawat_tertutupField.setDisabled(true);
		rpt_jrawat_tertutupField.setValue(true);
	}
	});
	
	// pertamax
	rpt_jrawat_semuaField.setDisabled(true);
	rpt_jrawat_tertutupField.setDisabled(true);
	rpt_jrawat_tertutupField.setValue(true);
	
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_jrawat"></div>
    </div>
</div>
</body>