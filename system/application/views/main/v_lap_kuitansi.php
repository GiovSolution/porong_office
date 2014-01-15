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

var rpt_kuitansi_tglawalField;
var rpt_kuitansi_tglakhirField;
var rpt_kuitansi_rekapField;
var rpt_kuitansi_detailField;
var rpt_kuitansi_bulanField;
var rpt_kuitansi_tahunField;
var rpt_kuitansi_opsitglField;
var rpt_kuitansi_opsiblnField;
var rpt_kuitansi_opsiallField;
var rpt_kuitansi_groupField;

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
			data:[['No Kuitansi'],['Tanggal'],['Customer'],['Sisa Kuitansi (Akumulatif)']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Kuitansi'],['Tanggal'],['Tanggal (Adjustment)'],['Customer'],['No Faktur']]
	});
	
	var rpt_kuitansi_groupField=new Ext.form.ComboBox({
		id:'rpt_kuitansi_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Kuitansi',
		width: 200,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_kuitansi_bulanField=new Ext.form.ComboBox({
		id:'rpt_kuitansi_bulanField',
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
	
	rpt_kuitansi_tahunField=new Ext.form.ComboBox({
		id:'rpt_kuitansi_tahunField',
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
	
	rpt_kuitansi_opsitglField=new Ext.form.Radio({
		id:'rpt_kuitansi_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_kuitansi_opsiblnField=new Ext.form.Radio({
		id:'rpt_kuitansi_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_kuitansi_opsiallField=new Ext.form.Radio({
		id:'rpt_kuitansi_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_kuitansi_tglawalField= new Ext.form.DateField({
		id: 'rpt_kuitansi_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_kuitansi_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
       // endDateField: 'rpt_kuitansi_tglakhirField'
	   	value : today
	});
	
	rpt_kuitansi_tglakhirField= new Ext.form.DateField({
		id: 'rpt_kuitansi_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_kuitansi_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_kuitansi_tglawalField',
		value: today
	});
	
	rpt_kuitansi_rekapField=new Ext.form.Radio({
		id: 'rpt_kuitansi_rekapField',
		boxLabel: 'Rekap',
		name: 'kuitansi_opsi',
		checked: true
	});
	
	rpt_kuitansi_detailField=new Ext.form.Radio({
		id: 'rpt_kuitansi_detailField',
		boxLabel: 'Detail',
		name: 'kuitansi_opsi'
	});
	
	var rpt_kuitansi_periodeField=new Ext.form.FieldSet({
		id:'rpt_kuitansi_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_kuitansi_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_kuitansi_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_kuitansi_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_kuitansi_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_kuitansi_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_kuitansi_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_kuitansi_tahunField]
					   }]
			}]
	});
	
	var	rpt_kuitansi_opsiField=new Ext.form.FieldSet({
		id: 'rpt_kuitansi_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_kuitansi_rekapField ,rpt_kuitansi_detailField]
	});
	
	var	rpt_kuitansi_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_kuitansi_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_kuitansi_groupField]
	});
	
	function is_valid_form(){
		if(rpt_kuitansi_opsitglField.getValue()==true){
			rpt_kuitansi_tglawalField.allowBlank=false;
			rpt_kuitansi_tglakhirField.allowBlank=false;
			if(rpt_kuitansi_tglawalField.isValid() && rpt_kuitansi_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_kuitansi_tglawalField.allowBlank=true;
			rpt_kuitansi_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_kuitansi(){
		
		var kuitansi_tglawal="";
		var kuitansi_tglakhir="";
		var jrpdouk_opsi="";
		var kuitansi_bulan="";
		var kuitansi_tahun="";
		var kuitansi_periode="";
		var kuitansi_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_kuitansi_tglawalField.getValue()!==""){kuitansi_tglawal = rpt_kuitansi_tglawalField.getValue().format('Y-m-d');}
		if(rpt_kuitansi_tglakhirField.getValue()!==""){kuitansi_tglakhir = rpt_kuitansi_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_kuitansi_bulanField.getValue()!==""){kuitansi_bulan=rpt_kuitansi_bulanField.getValue(); }
		if(rpt_kuitansi_tahunField.getValue()!==""){kuitansi_tahun=rpt_kuitansi_tahunField.getValue(); }
		if(rpt_kuitansi_opsitglField.getValue()==true){
			kuitansi_periode='tanggal';
		}else if(rpt_kuitansi_opsiblnField.getValue()==true){
			kuitansi_periode='bulan';
		}else{
			kuitansi_periode='all';
		}
		if(rpt_kuitansi_groupField.getValue()!==""){kuitansi_group=rpt_kuitansi_groupField.getValue(); }
		
		if(rpt_kuitansi_rekapField.getValue()==true){kuitansi_opsi='rekap';}else{kuitansi_opsi='detail';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_cetak_kwitansi&m=print_laporan',
				params: {
					tgl_awal	: kuitansi_tglawal,
					tgl_akhir	: kuitansi_tglakhir,
					opsi		: kuitansi_opsi,
					bulan		: kuitansi_bulan,
					tahun		: kuitansi_tahun,
					periode		: kuitansi_periode,
					group		: kuitansi_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_kuitansi.html','report_kuitansi','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
		items: [rpt_kuitansi_periodeField,rpt_kuitansi_opsiField, rpt_kuitansi_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_kuitansi
			},{
				text: 'Close',
				handler: function(){
					rpt_kuitansiWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_kuitansiWindow = new Ext.Window({
		title: 'Laporan Kuitansi',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_kuitansi',
		items: rpt_jrpdukForm
	});
  	rpt_kuitansiWindow.show();
	
	//EVENTS
	
	rpt_kuitansi_rekapField.on("check", function(){
		rpt_kuitansi_groupField.setValue('No Kuitansi');
		if(rpt_kuitansi_rekapField.getValue()==true){
			rpt_kuitansi_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_kuitansi_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_kuitansi_detailField.on("check", function(){
		rpt_kuitansi_groupField.setValue('No Kuitansi');
		if(rpt_kuitansi_detailField.getValue()==true){
			rpt_kuitansi_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_kuitansi_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_kuitansi_opsitglField.on("check",function(){
		if(rpt_kuitansi_opsitglField.getValue()==true){
			rpt_kuitansi_tglawalField.allowBlank=false;
			rpt_kuitansi_tglakhirField.allowBlank=false;
		}else{
			rpt_kuitansi_tglawalField.allowBlank=true;
			rpt_kuitansi_tglakhirField.allowBlank=true;
		}
		
	});
	
	rpt_kuitansi_groupField.on("select",function(){
	
	if(rpt_kuitansi_groupField.getValue()=='Sisa Kuitansi (Akumulatif)'){
		rpt_kuitansi_tglawalField.setDisabled(true);
	}
	else
	{
		rpt_kuitansi_tglawalField.setDisabled(false);
	}
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_kuitansi"></div>
    </div>
</div>
</body>