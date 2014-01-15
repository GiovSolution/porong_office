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

var rpt_tnonmedis_tglawalField;
var rpt_tnonmedis_tglakhirField;
var rpt_tnonmedis_rekapField;
var rpt_tnonmedis_detailField;
var rpt_tnonmedis_bulanField;
var rpt_tnonmedis_tahunField;
var rpt_tnonmedis_opsitglField;
var rpt_tnonmedis_opsiblnField;
var rpt_tnonmedis_opsiallField;
var rpt_tnonmedis_groupField;

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
			data:[['Tanggal'],['Customer'],['Perawatan'],['Terapis'],['Status']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['Tanggal'],['Customer'],['Perawatan'],['Dokter']]
	});
	
	var rpt_tnonmedis_groupField=new Ext.form.ComboBox({
		id:'rpt_tnonmedis_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'Tanggal',
		width: 100,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_tnonmedis_bulanField=new Ext.form.ComboBox({
		id:'rpt_tnonmedis_bulanField',
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
	
	rpt_tnonmedis_tahunField=new Ext.form.ComboBox({
		id:'rpt_tnonmedis_tahunField',
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
	
	rpt_tnonmedis_opsitglField=new Ext.form.Radio({
		id:'rpt_tnonmedis_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_tnonmedis_opsiblnField=new Ext.form.Radio({
		id:'rpt_tnonmedis_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_tnonmedis_opsiallField=new Ext.form.Radio({
		id:'rpt_tnonmedis_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_tnonmedis_tglawalField= new Ext.form.DateField({
		id: 'rpt_tnonmedis_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_tnonmedis_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_tnonmedis_tglakhirField'
		value: today
	});
	
	rpt_tnonmedis_tglakhirField= new Ext.form.DateField({
		id: 'rpt_tnonmedis_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_tnonmedis_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_tnonmedis_tglawalField',
		value: today
	});
	
	rpt_tnonmedis_rekapField=new Ext.form.Radio({
		id: 'rpt_tnonmedis_rekapField',
		boxLabel: 'Rekap',
		name: 'tnonmedis_opsi',
		checked: true
	});
	
	rpt_tnonmedis_detailField=new Ext.form.Radio({
		id: 'rpt_tnonmedis_detailField',
		boxLabel: 'Detail',
		name: 'tnonmedis_opsi'
	});
	
	var rpt_tnonmedis_periodeField=new Ext.form.FieldSet({
		id:'rpt_tnonmedis_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_tnonmedis_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_tnonmedis_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_tnonmedis_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_tnonmedis_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_tnonmedis_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_tnonmedis_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_tnonmedis_tahunField]
					   }]
			}]
	});
	
	var	rpt_tnonmedis_opsiField=new Ext.form.FieldSet({
		id: 'rpt_tnonmedis_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_tnonmedis_rekapField]
	});
	
	var	rpt_tnonmedis_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_tnonmedis_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_tnonmedis_groupField]
	});
	
	function is_valid_form(){
		if(rpt_tnonmedis_opsitglField.getValue()==true){
			rpt_tnonmedis_tglawalField.allowBlank=false;
			rpt_tnonmedis_tglakhirField.allowBlank=false;
			if(rpt_tnonmedis_tglawalField.isValid() && rpt_tnonmedis_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_tnonmedis_tglawalField.allowBlank=true;
			rpt_tnonmedis_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_tnonmedis(){
		
		var tnonmedis_tglawal="";
		var tnonmedis_tglakhir="";
		var jrpdouk_opsi="";
		var tnonmedis_bulan="";
		var tnonmedis_tahun="";
		var tnonmedis_periode="";
		var tnonmedis_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_tnonmedis_tglawalField.getValue()!==""){tnonmedis_tglawal = rpt_tnonmedis_tglawalField.getValue().format('Y-m-d');}
		if(rpt_tnonmedis_tglakhirField.getValue()!==""){tnonmedis_tglakhir = rpt_tnonmedis_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_tnonmedis_bulanField.getValue()!==""){tnonmedis_bulan=rpt_tnonmedis_bulanField.getValue(); }
		if(rpt_tnonmedis_tahunField.getValue()!==""){tnonmedis_tahun=rpt_tnonmedis_tahunField.getValue(); }
		if(rpt_tnonmedis_opsitglField.getValue()==true){
			tnonmedis_periode='tanggal';
		}else if(rpt_tnonmedis_opsiblnField.getValue()==true){
			tnonmedis_periode='bulan';
		}else{
			tnonmedis_periode='all';
		}
		if(rpt_tnonmedis_groupField.getValue()!==""){tnonmedis_group=rpt_tnonmedis_groupField.getValue(); }
		
		//if(rpt_tnonmedis_rekapField.getValue()==true){tnonmedis_opsi='rekap';}else{tnonmedis_opsi='detail';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_tindakan_nonmedis&m=print_laporan',
				params: {
					tgl_awal	: tnonmedis_tglawal,
					tgl_akhir	: tnonmedis_tglakhir,
					//opsi		: tnonmedis_opsi,
					bulan		: tnonmedis_bulan,
					tahun		: tnonmedis_tahun,
					periode		: tnonmedis_periode,
					group		: tnonmedis_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_tindakan_nonmedis.html','report_tnonmedis','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
		items: [rpt_tnonmedis_periodeField,rpt_tnonmedis_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_tnonmedis
			},{
				text: 'Close',
				handler: function(){
					rpt_tnonmedisWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_tnonmedisWindow = new Ext.Window({
		title: 'Laporan Tindakan Non Medis',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_tnonmedis',
		items: rpt_jrpdukForm
	});
  	rpt_tnonmedisWindow.show();
	
	//EVENTS
	
	rpt_tnonmedis_rekapField.on("check", function(){
		rpt_tnonmedis_groupField.setValue('Tanggal');
		if(rpt_tnonmedis_rekapField.getValue()==true){
			rpt_tnonmedis_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_tnonmedis_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_tnonmedis_detailField.on("check", function(){
		rpt_tnonmedis_groupField.setValue('Tanggal');
		if(rpt_tnonmedis_detailField.getValue()==true){
			rpt_tnonmedis_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_tnonmedis_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_tnonmedis_opsitglField.on("check",function(){
		if(rpt_tnonmedis_opsitglField.getValue()==true){
			rpt_tnonmedis_tglawalField.allowBlank=false;
			rpt_tnonmedis_tglakhirField.allowBlank=false;
		}else{
			rpt_tnonmedis_tglawalField.allowBlank=true;
			rpt_tnonmedis_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_tnonmedis"></div>
    </div>
</div>
</body>