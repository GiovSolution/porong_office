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

var rpt_mutasiWindow;
var rpt_mutasiForm;

var rpt_mutasi_tglawalField;
var rpt_mutasi_tglakhirField;
var rpt_mutasi_rekapField;
var rpt_mutasi_detailField;
var rpt_mutasi_bulanField;
var rpt_mutasi_tahunField;
var rpt_mutasi_opsitglField;
var rpt_mutasi_opsiblnField;
var rpt_mutasi_opsiallField;
var rpt_mutasi_groupField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
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
<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
$bulan="";
?>
Ext.onReady(function(){
  Ext.QuickTips.init();

	var group_master_Store= new Ext.data.SimpleStore({
			id: 'group_master_Store',
			fields:['group'],
			data:[['No Bukti'],['Tanggal'],['Gudang Asal'],['Gudang Tujuan'],['Produk Racikan'],['Produk Non Racikan(Retail)']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Bukti'],['Tanggal'],['Gudang Asal'],['Gudang Tujuan'],['Produk'],['Produk Racikan'],['Barang Keluar']]
	});
	
	var rpt_mutasi_groupField=new Ext.form.ComboBox({
		id:'rpt_mutasi_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'Tanggal',
		width: 175,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_mutasi_bulanField=new Ext.form.ComboBox({
		id:'rpt_mutasi_bulanField',
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
	
	rpt_mutasi_tahunField=new Ext.form.ComboBox({
		id:'rpt_mutasi_tahunField',
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
	
	rpt_mutasi_opsitglField=new Ext.form.Radio({
		id:'rpt_mutasi_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_mutasi_opsiblnField=new Ext.form.Radio({
		id:'rpt_mutasi_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_mutasi_opsiallField=new Ext.form.Radio({
		id:'rpt_mutasi_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_mutasi_tglawalField= new Ext.form.DateField({
		id: 'rpt_mutasi_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_mutasi_tglawalField',
        //vtype: 'daterange',
		value: today,
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_mutasi_tglakhirField'
	});
	
	rpt_mutasi_tglakhirField= new Ext.form.DateField({
		id: 'rpt_mutasi_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_mutasi_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_mutasi_tglawalField',
		value: today
	});
	
	rpt_mutasi_rekapField=new Ext.form.Radio({
		id: 'rpt_mutasi_rekapField',
		boxLabel: 'Rekap',
		name: 'mutasi_opsi',
		checked: true
	});
	
	rpt_mutasi_detailField=new Ext.form.Radio({
		id: 'rpt_mutasi_detailField',
		boxLabel: 'Detail',
		name: 'mutasi_opsi'
	});
	
	var rpt_mutasi_periodeField=new Ext.form.FieldSet({
		id:'rpt_mutasi_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_mutasi_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_mutasi_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_mutasi_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_mutasi_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_mutasi_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_mutasi_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_mutasi_tahunField]
					   }]
			}]
	});
	
	var	rpt_mutasi_opsiField=new Ext.form.FieldSet({
		id: 'rpt_mutasi_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_mutasi_rekapField ,rpt_mutasi_detailField]
	});
	
	var	rpt_mutasi_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_mutasi_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_mutasi_groupField]
	});
	
	function is_valid_form(){
		if(rpt_mutasi_opsitglField.getValue()==true){
			rpt_mutasi_tglawalField.allowBlank=false;
			rpt_mutasi_tglakhirField.allowBlank=false;
			if(rpt_mutasi_tglawalField.isValid() && rpt_mutasi_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_mutasi_tglawalField.allowBlank=true;
			rpt_mutasi_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_mutasi(){
		
		var mutasi_tglawal="";
		var mutasi_tglakhir="";
		var jrpdouk_opsi="";
		var mutasi_bulan="";
		var mutasi_tahun="";
		var mutasi_periode="";
		var mutasi_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_mutasi_tglawalField.getValue()!==""){mutasi_tglawal = rpt_mutasi_tglawalField.getValue().format('Y-m-d');}
		if(rpt_mutasi_tglakhirField.getValue()!==""){mutasi_tglakhir = rpt_mutasi_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_mutasi_bulanField.getValue()!==""){mutasi_bulan=rpt_mutasi_bulanField.getValue(); }
		if(rpt_mutasi_tahunField.getValue()!==""){mutasi_tahun=rpt_mutasi_tahunField.getValue(); }
		if(rpt_mutasi_opsitglField.getValue()==true){
			mutasi_periode='tanggal';
		}else if(rpt_mutasi_opsiblnField.getValue()==true){
			mutasi_periode='bulan';
		}else{
			mutasi_periode='all';
		}
		if(rpt_mutasi_groupField.getValue()!==""){mutasi_group=rpt_mutasi_groupField.getValue(); }
		
		if(rpt_mutasi_rekapField.getValue()==true){mutasi_opsi='rekap';}else{mutasi_opsi='detail';}
			
			Ext.MessageBox.show({
			   msg: 'Sedang memproses data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
			
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_mutasi&m=print_laporan',
				params: {
					tgl_awal	: mutasi_tglawal,
					tgl_akhir	: mutasi_tglakhir,
					opsi		: mutasi_opsi,
					bulan		: mutasi_bulan,
					tahun		: mutasi_tahun,
					periode		: mutasi_periode,
					group		: mutasi_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_mutasi.html','report_mutasi','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_mutasiForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_mutasi_periodeField,rpt_mutasi_opsiField, rpt_mutasi_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_mutasi
			},{
				text: 'Close',
				handler: function(){
					rpt_mutasiWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_mutasiWindow = new Ext.Window({
		title: 'Laporan Mutasi',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_mutasi',
		items: rpt_mutasiForm
	});
  	rpt_mutasiWindow.show();
	
	//EVENTS
	
	rpt_mutasi_rekapField.on("check", function(){
		rpt_mutasi_groupField.setValue('No Bukti');
		if(rpt_mutasi_rekapField.getValue()==true){
			rpt_mutasi_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_mutasi_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_mutasi_detailField.on("check", function(){
		rpt_mutasi_groupField.setValue('No Bukti');
		if(rpt_mutasi_detailField.getValue()==true){
			rpt_mutasi_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_mutasi_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_mutasi_opsitglField.on("check",function(){
		if(rpt_mutasi_opsitglField.getValue()==true){
			rpt_mutasi_tglawalField.allowBlank=false;
			rpt_mutasi_tglakhirField.allowBlank=false;
		}else{
			rpt_mutasi_tglawalField.allowBlank=true;
			rpt_mutasi_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_mutasi"></div>
    </div>
</div>
</body>