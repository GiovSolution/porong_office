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

var rpt_apaketWindow;
var rpt_apaketForm;

/* declare variable here */
var rpt_apaket_tglawalField;
var rpt_apaket_tglakhirField;
var rpt_apaket_rekapField;
var rpt_apaket_adjField;
var rpt_apaket_tertutupField;
var rpt_apaket_batalField;
var rpt_apaket_detailField;
var rpt_apaket_bulanField;
var rpt_apaket_tahunField;
var rpt_apaket_opsitglField;
var rpt_apaket_opsiblnField;
var rpt_apaket_opsiallField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],83); ?>"; //akan mengembalikan nilai '1' jika centangan 'Semua Tgl' di menu User Groups dicentang, dan mengembalikan tanggal awal periode akun jika tidak tercentang (yyyy-mm-dd)

<? 
	$tahun_cek = $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],83);
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
			data:[['No Faktur'],['Tanggal'],['Customer'],['Paket'],['Sisa Paket (Akumulatif)']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Tanggal 2 (PPN)'],['Customer'],['Paket'],['Perawatan Semua'],['Perawatan Medis'],['Perawatan Non Medis'],['Perawatan Anti Aging']
			,['Perawatan Surgery'],['Perawatan Lain-Lain'],['Pemakai'],['Referal'],['Sisa Paket (Akumulatif)']]
	});
	
	var rpt_apaket_groupField=new Ext.form.ComboBox({
		id:'rpt_apaket_groupField',
		fieldLabel:'Kelompokkan',
		store: group_detail_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 200,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_apaket_bulanField=new Ext.form.ComboBox({
		id:'rpt_apaket_bulanField',
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
	
	rpt_apaket_tahunField=new Ext.form.ComboBox({
		id:'rpt_apaket_tahunField',
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
	
	rpt_apaket_opsitglField=new Ext.form.Radio({
		id:'rpt_apaket_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_apaket_opsiblnField=new Ext.form.Radio({
		id:'rpt_apaket_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_apaket_opsiallField=new Ext.form.Radio({
		id:'rpt_apaket_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_apaket_tglawalField= new Ext.form.DateField({
		id: 'rpt_apaket_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_apaket_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: today,
		minValue: MIN_CREATE_DATE
        //endDateField: 'rpt_apaket_tglakhirField'
	});
	
	rpt_apaket_tglakhirField= new Ext.form.DateField({
		id: 'rpt_apaket_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_apaket_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_apaket_tglawalField',
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_apaket_rekapField=new Ext.form.Radio({
		id: 'rpt_apaket_rekapField',
		boxLabel: 'Rekap',
		name: 'apaket_opsi',
		checked: false,
		disabled: true
	});
	
	rpt_apaket_detailField=new Ext.form.Radio({
		id: 'rpt_apaket_detailField',
		boxLabel: 'Detail',
		name: 'apaket_opsi',
		checked: true
	});
	
	// opsi status
	rpt_apaket_tertutupField=new Ext.form.Radio({
		id: 'rpt_apaket_tertutupField',
		boxLabel: 'Tertutup',
		name: 'apaket_opsistatus',
		checked: true
	});
	
	rpt_apaket_adjField=new Ext.form.Radio({
		id: 'rpt_apaket_adjField',
		boxLabel: 'Adjustment',
		name: 'apaket_opsistatus',
		checked: false
	});
	
	rpt_apaket_batalField=new Ext.form.Radio({
		id: 'rpt_apaket_batalField',
		boxLabel: 'Batal',
		name: 'apaket_opsistatus',
		checked: false
	});
	
	var rpt_apaket_periodeField=new Ext.form.FieldSet({
		id:'rpt_apaket_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_apaket_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_apaket_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_apaket_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_apaket_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_apaket_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_apaket_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_apaket_tahunField]
					   }]
			}]
	});
	
	var	rpt_apaket_opsiField=new Ext.form.FieldSet({
		id: 'rpt_apaket_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_apaket_rekapField ,rpt_apaket_detailField]
	});
	
	// opsi status
	var	rpt_apaket_opsistatusField=new Ext.form.FieldSet({
		id: 'rpt_apaket_opsistatusField',
		title: 'Opsi Status',
		border: true,
		anchor: '98%',
		items: [rpt_apaket_tertutupField, rpt_apaket_adjField ,rpt_apaket_batalField]
	});
	
	var	rpt_apaket_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_apaket_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_apaket_groupField]
	});
	
	function is_valid_form(){
		if(rpt_apaket_opsitglField.getValue()==true){
			rpt_apaket_tglawalField.allowBlank=false;
			rpt_apaket_tglakhirField.allowBlank=false;
			if(rpt_apaket_tglawalField.isValid() && rpt_apaket_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_apaket_tglawalField.allowBlank=true;
			rpt_apaket_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_apaket(){
		
		var apaket_tglawal="";
		var apaket_tglakhir="";
		var jrpdouk_opsi="";
		var apaket_bulan="";
		var apaket_tahun="";
		var apaket_periode="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_apaket_tglawalField.getValue()!==""){apaket_tglawal = rpt_apaket_tglawalField.getValue().format('Y-m-d');}
		if(rpt_apaket_tglakhirField.getValue()!==""){apaket_tglakhir = rpt_apaket_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_apaket_bulanField.getValue()!==""){apaket_bulan=rpt_apaket_bulanField.getValue(); }
		if(rpt_apaket_tahunField.getValue()!==""){apaket_tahun=rpt_apaket_tahunField.getValue(); }
		if(rpt_apaket_opsitglField.getValue()==true){
			apaket_periode='tanggal';
		}else if(rpt_apaket_opsiblnField.getValue()==true){
			apaket_periode='bulan';
		}else{
			apaket_periode='all';
		}
		if(rpt_apaket_groupField.getValue()!==""){apaket_group=rpt_apaket_groupField.getValue(); }
		if(rpt_apaket_rekapField.getValue()==true){apaket_opsi='rekap';}else{apaket_opsi='detail';}
		if(rpt_apaket_tertutupField.getValue()==true){
			apaket_opsi_status='tertutup';
		}else if (rpt_apaket_adjField.getValue()==true){
			apaket_opsi_status='adjustment';
		}else{
			apaket_opsi_status='batal';
		}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_master_ambil_paket&m=print_laporan',
				params: {
					tgl_awal	: apaket_tglawal,
					tgl_akhir	: apaket_tglakhir,
					opsi		: apaket_opsi,
					opsi_status	: apaket_opsi_status,
					bulan		: apaket_bulan,
					tahun		: apaket_tahun,
					periode		: apaket_periode,
					group		: apaket_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_ambil_paket.html','report_apaket','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_apaketForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_apaket_periodeField,rpt_apaket_opsiField,rpt_apaket_opsistatusField,rpt_apaket_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_apaket
			},{
				text: 'Close',
				handler: function(){
					rpt_apaketWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_apaketWindow = new Ext.Window({
		title: 'Laporan Pengambilan Paket',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_apaket',
		items: rpt_apaketForm
	});
  	rpt_apaketWindow.show();
	
	//EVENTS
	rpt_apaket_rekapField.on("check", function(){
		rpt_apaket_groupField.setValue('No faktur');
		if(rpt_apaket_rekapField.getValue()==true){
			rpt_apaket_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_apaket_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_apaket_detailField.on("check", function(){
		rpt_apaket_groupField.setValue('No Faktur');
		if(rpt_apaket_detailField.getValue()==true){
			rpt_apaket_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_apaket_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_apaket_opsitglField.on("check",function(){
		if(rpt_apaket_opsitglField.getValue()==true){
			rpt_apaket_tglawalField.allowBlank=false;
			rpt_apaket_tglakhirField.allowBlank=false;
		}else{
			rpt_apaket_tglawalField.allowBlank=true;
			rpt_apaket_tglakhirField.allowBlank=true;
		}
	});
	
	rpt_apaket_groupField.on("select",function(){
	if(rpt_apaket_groupField.getValue()=='Sisa Paket (Akumulatif)'){
		rpt_apaket_tglawalField.setDisabled(true);
		rpt_apaket_tertutupField.setValue(true);
		rpt_apaket_adjField.setDisabled(true);
		rpt_apaket_batalField.setDisabled(true);
	}
	else
	{
		rpt_apaket_tglawalField.setDisabled(false);
		rpt_apaket_tertutupField.setValue(true);
		rpt_apaket_adjField.setDisabled(false);
		rpt_apaket_batalField.setDisabled(false);
	}
	});

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_apaket"></div>
    </div>
</div>
</body>