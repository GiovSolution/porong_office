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
var rpt_jpaket_tglawalField;
var rpt_jpaket_tglakhirField;
var rpt_jpaket_rekapField;
var rpt_jpaket_detailField;
var rpt_jpaket_semuaField;
var rpt_jpaket_tertutupField;
var rpt_jpaket_bulanField;
var rpt_jpaket_tahunField;
var rpt_jpaket_opsitglField;
var rpt_jpaket_opsiblnField;
var rpt_jpaket_opsiallField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],82); ?>";//akan mengembalikan nilai '1' jika centangan 'Semua Tgl' di menu User Groups dicentang, dan mengembalikan tanggal awal periode akun jika tidak tercentang (yyyy-mm-dd)

<? 
	$tahun_cek = $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],82);
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
			data:[['No Faktur'],['Tanggal'],['Tanggal 2 (PPN)'],['Customer'],['Paket'],['Sales'],['Jenis Diskon']]
	});
	
	var rpt_jpaket_groupField=new Ext.form.ComboBox({
		id:'rpt_jpaket_groupField',
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
	
	rpt_jpaket_bulanField=new Ext.form.ComboBox({
		id:'rpt_jpaket_bulanField',
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
	
	rpt_jpaket_tahunField=new Ext.form.ComboBox({
		id:'rpt_jpaket_tahunField',
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
	
	rpt_jpaket_opsitglField=new Ext.form.Radio({
		id:'rpt_jpaket_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_jpaket_opsiblnField=new Ext.form.Radio({
		id:'rpt_jpaket_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_jpaket_opsiallField=new Ext.form.Radio({
		id:'rpt_jpaket_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_jpaket_tglawalField= new Ext.form.DateField({
		id: 'rpt_jpaket_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_jpaket_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
       // endDateField: 'rpt_jpaket_tglakhirField'
	    value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jpaket_tglakhirField= new Ext.form.DateField({
		id: 'rpt_jpaket_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_jpaket_tglakhirField',
       // vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_jpaket_tglawalField',
		value: today,
		minValue: MIN_CREATE_DATE
	});
	
	rpt_jpaket_rekapField=new Ext.form.Radio({
		id: 'rpt_jpaket_rekapField',
		boxLabel: 'Rekap',
		name: 'jpaket_opsi',
		checked: true
	});
	
	rpt_jpaket_detailField=new Ext.form.Radio({
		id: 'rpt_jpaket_detailField',
		boxLabel: 'Detail',
		name: 'jpaket_opsi'
	});
	
	// opsi status
	rpt_jpaket_semuaField=new Ext.form.Radio({
		id: 'rpt_jpaket_semuaField',
		boxLabel: 'Semua',
		name: 'jpaket_opsi_status',
		checked: false
	});
	
	rpt_jpaket_tertutupField=new Ext.form.Radio({
		id: 'rpt_jpaket_tertutupField',
		boxLabel: 'Tertutup',
		name: 'jpaket_opsi_status',
		checked: true
	});
	// eof opsi status
	
	
	var rpt_jpaket_periodeField=new Ext.form.FieldSet({
		id:'rpt_jpaket_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_jpaket_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_jpaket_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jpaket_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jpaket_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_jpaket_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_jpaket_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_jpaket_tahunField]
					   }]
			}]
	});
	
	var	rpt_jpaket_opsiField=new Ext.form.FieldSet({
		id: 'rpt_jpaket_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_jpaket_rekapField ,rpt_jpaket_detailField]
	});
	
	// opsi status
	var	rpt_jpaket_opsistatusField=new Ext.form.FieldSet({
		id: 'rpt_jpaket_opsistatusField',
		title: 'Opsi Status',
		border: true,
		anchor: '98%',
		items: [rpt_jpaket_tertutupField ,rpt_jpaket_semuaField]
	});
	
	var	rpt_jpaket_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_jpaket_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_jpaket_groupField]
	});
	
	function is_valid_form(){
		if(rpt_jpaket_opsitglField.getValue()==true){
			rpt_jpaket_tglawalField.allowBlank=false;
			rpt_jpaket_tglakhirField.allowBlank=false;
			if(rpt_jpaket_tglawalField.isValid() && rpt_jpaket_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_jpaket_tglawalField.allowBlank=true;
			rpt_jpaket_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_jpaket(){
		
		var jpaket_tglawal="";
		var jpaket_tglakhir="";
		var jpaket_opsi="";
		var jpaket_opsi_status="";
		var jpaket_bulan="";
		var jpaket_tahun="";
		var jpaket_periode="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_jpaket_tglawalField.getValue()!==""){jpaket_tglawal = rpt_jpaket_tglawalField.getValue().format('Y-m-d');}
		if(rpt_jpaket_tglakhirField.getValue()!==""){jpaket_tglakhir = rpt_jpaket_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_jpaket_bulanField.getValue()!==""){jpaket_bulan=rpt_jpaket_bulanField.getValue(); }
		if(rpt_jpaket_tahunField.getValue()!==""){jpaket_tahun=rpt_jpaket_tahunField.getValue(); }
		if(rpt_jpaket_opsitglField.getValue()==true){
			jpaket_periode='tanggal';
		}else if(rpt_jpaket_opsiblnField.getValue()==true){
			jpaket_periode='bulan';
		}else{
			jpaket_periode='all';
		}
		if(rpt_jpaket_groupField.getValue()!==""){jpaket_group=rpt_jpaket_groupField.getValue(); }
		if(rpt_jpaket_rekapField.getValue()==true){jpaket_opsi='rekap';}else{jpaket_opsi='detail';}
		if(rpt_jpaket_tertutupField.getValue()==true){jpaket_opsi_status='tertutup';}
		if(rpt_jpaket_semuaField.getValue()==true){jpaket_opsi_status='semua';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_master_jual_paket&m=print_laporan',
				params: {
					tgl_awal	: jpaket_tglawal,
					tgl_akhir	: jpaket_tglakhir,
					opsi		: jpaket_opsi,
					opsi_status	: jpaket_opsi_status,
					bulan		: jpaket_bulan,
					tahun		: jpaket_tahun,
					periode		: jpaket_periode,
					group		: jpaket_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_jpaket.html','report_jpaket','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
		items: [rpt_jpaket_periodeField,rpt_jpaket_opsiField,rpt_jpaket_groupbyField, rpt_jpaket_opsistatusField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_jpaket
			},{
				text: 'Close',
				handler: function(){
					rpt_jpaketWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_jpaketWindow = new Ext.Window({
		title: 'Laporan Penjualan Paket',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_jpaket',
		items: rpt_jrpdukForm
	});
  	rpt_jpaketWindow.show();
	
	//EVENTS
	rpt_jpaket_rekapField.on("check", function(){
		rpt_jpaket_groupField.setValue('No faktur');
		if(rpt_jpaket_rekapField.getValue()==true){
			rpt_jpaket_groupField.bindStore(group_master_Store);
			rpt_jpaket_semuaField.setDisabled(true);
			rpt_jpaket_tertutupField.setDisabled(true);
			rpt_jpaket_tertutupField.setValue(true);
		}else
		{
			rpt_jpaket_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_jpaket_detailField.on("check", function(){
		rpt_jpaket_groupField.setValue('No Faktur');
		if(rpt_jpaket_detailField.getValue()==true){
			rpt_jpaket_groupField.bindStore(group_detail_Store);
			rpt_jpaket_semuaField.setDisabled(false);
			rpt_jpaket_tertutupField.setDisabled(false);
			rpt_jpaket_tertutupField.setValue(true);
		}else
		{
			rpt_jpaket_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_jpaket_opsitglField.on("check",function(){
		if(rpt_jpaket_opsitglField.getValue()==true){
			rpt_jpaket_tglawalField.allowBlank=false;
			rpt_jpaket_tglakhirField.allowBlank=false;
		}else{
			rpt_jpaket_tglawalField.allowBlank=true;
			rpt_jpaket_tglakhirField.allowBlank=true;
		}
	});
	
	// event opsi status
	rpt_jpaket_groupField.on("select",function(){
	if(rpt_jpaket_groupField.getValue()=='No Faktur' && rpt_jpaket_detailField.getValue()==true ){
		rpt_jpaket_semuaField.setDisabled(false);
		rpt_jpaket_tertutupField.setDisabled(false);
		rpt_jpaket_semuaField.setValue(true);
	}
	else
	{
		rpt_jpaket_semuaField.setDisabled(true);
		rpt_jpaket_tertutupField.setDisabled(true);
		rpt_jpaket_tertutupField.setValue(true);
	}
	});
		
	// pertamax
	rpt_jpaket_semuaField.setDisabled(true);
	rpt_jpaket_tertutupField.setDisabled(true);
	rpt_jpaket_tertutupField.setValue(true);
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_jpaket"></div>
    </div>
</div>
</body>