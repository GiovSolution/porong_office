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

var rpt_returbeliWindow;
var rpt_returbeliForm;

var rpt_returbeli_tglawalField;
var rpt_returbeli_tglakhirField;
var rpt_returbeli_rekapField;
var rpt_returbeli_detailField;
var rpt_returbeli_bulanField;
var rpt_returbeli_tahunField;
var rpt_returbeli_opsitglField;
var rpt_returbeli_opsiblnField;
var rpt_returbeli_opsiallField;
var rpt_returbeli_groupField;

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
			data:[['No Faktur'],['Tanggal'],['Supplier']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Supplier'],['Produk']]
	});
	
	var rpt_returbeli_groupField=new Ext.form.ComboBox({
		id:'rpt_returbeli_groupField',
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
	
	rpt_returbeli_bulanField=new Ext.form.ComboBox({
		id:'rpt_returbeli_bulanField',
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
	
	rpt_returbeli_tahunField=new Ext.form.ComboBox({
		id:'rpt_returbeli_tahunField',
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
	
	rpt_returbeli_opsitglField=new Ext.form.Radio({
		id:'rpt_returbeli_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_returbeli_opsiblnField=new Ext.form.Radio({
		id:'rpt_returbeli_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_returbeli_opsiallField=new Ext.form.Radio({
		id:'rpt_returbeli_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_returbeli_tglawalField= new Ext.form.DateField({
		id: 'rpt_returbeli_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_returbeli_tglawalField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
        endDateField: 'rpt_returbeli_tglakhirField'
	});
	
	rpt_returbeli_tglakhirField= new Ext.form.DateField({
		id: 'rpt_returbeli_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_returbeli_tglakhirField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
        startDateField: 'rpt_returbeli_tglawalField',
		value: today
	});
	
	rpt_returbeli_rekapField=new Ext.form.Radio({
		id: 'rpt_returbeli_rekapField',
		boxLabel: 'Rekap',
		name: 'returbeli_opsi',
		checked: true
	});
	
	rpt_returbeli_detailField=new Ext.form.Radio({
		id: 'rpt_returbeli_detailField',
		boxLabel: 'Detail',
		name: 'returbeli_opsi'
	});
	
	var rpt_returbeli_periodeField=new Ext.form.FieldSet({
		id:'rpt_returbeli_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_returbeli_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_returbeli_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_returbeli_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_returbeli_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_returbeli_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_returbeli_tahunField]
					   }]
			}]
	});
	
	var	rpt_returbeli_opsiField=new Ext.form.FieldSet({
		id: 'rpt_returbeli_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_returbeli_rekapField ,rpt_returbeli_detailField]
	});
	
	var	rpt_returbeli_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_returbeli_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_returbeli_groupField]
	});
	
	function is_valid_form(){
		if(rpt_returbeli_opsitglField.getValue()==true){
			rpt_returbeli_tglawalField.allowBlank=false;
			rpt_returbeli_tglakhirField.allowBlank=false;
			if(rpt_returbeli_tglawalField.isValid() && rpt_returbeli_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_returbeli_tglawalField.allowBlank=true;
			rpt_returbeli_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_returbeli(){
		
		var returbeli_tglawal="";
		var returbeli_tglakhir="";
		var jrpdouk_opsi="";
		var returbeli_bulan="";
		var returbeli_tahun="";
		var returbeli_periode="";
		var returbeli_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_returbeli_tglawalField.getValue()!==""){returbeli_tglawal = rpt_returbeli_tglawalField.getValue().format('Y-m-d');}
		if(rpt_returbeli_tglakhirField.getValue()!==""){returbeli_tglakhir = rpt_returbeli_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_returbeli_bulanField.getValue()!==""){returbeli_bulan=rpt_returbeli_bulanField.getValue(); }
		if(rpt_returbeli_tahunField.getValue()!==""){returbeli_tahun=rpt_returbeli_tahunField.getValue(); }
		if(rpt_returbeli_opsitglField.getValue()==true){
			returbeli_periode='tanggal';
		}else if(rpt_returbeli_opsiblnField.getValue()==true){
			returbeli_periode='bulan';
		}else{
			returbeli_periode='all';
		}
		if(rpt_returbeli_groupField.getValue()!==""){returbeli_group=rpt_returbeli_groupField.getValue(); }
		
		if(rpt_returbeli_rekapField.getValue()==true){returbeli_opsi='rekap';}else{returbeli_opsi='detail';}
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_retur_beli&m=print_laporan',
				params: {
					tgl_awal	: returbeli_tglawal,
					tgl_akhir	: returbeli_tglakhir,
					opsi		: returbeli_opsi,
					bulan		: returbeli_bulan,
					tahun		: returbeli_tahun,
					periode		: returbeli_periode,
					group		: returbeli_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						win = window.open('./print/report_retur_beli.html','report_returbeli','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_returbeliForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_returbeli_periodeField,rpt_returbeli_opsiField, rpt_returbeli_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_returbeli
			},{
				text: 'Close',
				handler: function(){
					rpt_returbeliWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_returbeliWindow = new Ext.Window({
		title: 'Laporan Retur Pembelian',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_returbeli',
		items: rpt_returbeliForm
	});
  	rpt_returbeliWindow.show();
	
	//EVENTS
	
	rpt_returbeli_rekapField.on("check", function(){
		rpt_returbeli_groupField.setValue('No faktur');
		if(rpt_returbeli_rekapField.getValue()==true){
			rpt_returbeli_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_returbeli_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_returbeli_detailField.on("check", function(){
		rpt_returbeli_groupField.setValue('No Faktur');
		if(rpt_returbeli_detailField.getValue()==true){
			rpt_returbeli_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_returbeli_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_returbeli_opsitglField.on("check",function(){
		if(rpt_returbeli_opsitglField.getValue()==true){
			rpt_returbeli_tglawalField.allowBlank=false;
			rpt_returbeli_tglakhirField.allowBlank=false;
		}else{
			rpt_returbeli_tglawalField.allowBlank=true;
			rpt_returbeli_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_returbeli"></div>
    </div>
</div>
</body>