<?
/* 	
	
	+ Module  		: laporan penerimaan barang tanpa harga View
	+ Description	: For record view
	+ Filename 		: v_lap_terima_beli_no_harga.php
 	+ Author  		: Freddy

	
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

var rpt_terimabeli_nohargaWindow;
var rpt_terimabeli_nohargaForm;

var rpt_terimabeli_noharga_tglawalField;
var rpt_terimabeli_noharga_tglakhirField;
var rpt_terimabeli_noharga_rekapField;
var rpt_terimabeli_noharga_detailField;
var rpt_terimabeli_noharga_bulanField;
var rpt_terimabeli_noharga_tahunField;
var rpt_terimabeli_noharga_opsitglField;
var rpt_terimabeli_noharga_opsiblnField;
var rpt_terimabeli_noharga_opsiallField;
var rpt_terimabeli_noharga_groupField;

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

	var group_master_noharga_Store= new Ext.data.SimpleStore({
			id: 'group_master_noharga_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Supplier']]
	});
	
	var group_detail_noharga_Store= new Ext.data.SimpleStore({
			id: 'group_detail_noharga_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Supplier'],['Produk']]
	});
	
	var rpt_terimabeli_noharga_groupField=new Ext.form.ComboBox({
		id:'rpt_terimabeli_noharga_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_noharga_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 100,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_terimabeli_noharga_bulanField=new Ext.form.ComboBox({
		id:'rpt_terimabeli_noharga_bulanField',
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
	
	rpt_terimabeli_noharga_tahunField=new Ext.form.ComboBox({
		id:'rpt_terimabeli_noharga_tahunField',
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
	
	rpt_terimabeli_noharga_opsitglField=new Ext.form.Radio({
		id:'rpt_terimabeli_noharga_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_terimabeli_noharga_opsiblnField=new Ext.form.Radio({
		id:'rpt_terimabeli_noharga_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_terimabeli_noharga_opsiallField=new Ext.form.Radio({
		id:'rpt_terimabeli_noharga_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_terimabeli_noharga_tglawalField= new Ext.form.DateField({
		id: 'rpt_terimabeli_noharga_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_terimabeli_noharga_tglawalField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
        endDateField: 'rpt_terimabeli_noharga_tglakhirField'
	});
	
	rpt_terimabeli_noharga_tglakhirField= new Ext.form.DateField({
		id: 'rpt_terimabeli_noharga_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_terimabeli_noharga_tglakhirField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
        startDateField: 'rpt_terimabeli_noharga_tglawalField',
		value: today
	});
	
	rpt_terimabeli_noharga_rekapField=new Ext.form.Radio({
		id: 'rpt_terimabeli_noharga_rekapField',
		boxLabel: 'Rekap',
		name: 'terimabeli_opsi',
		checked: true
	});
	
	rpt_terimabeli_noharga_detailField=new Ext.form.Radio({
		id: 'rpt_terimabeli_noharga_detailField',
		boxLabel: 'Detail',
		name: 'terimabeli_opsi'
	});
	
	var rpt_terimabeli_periodeField=new Ext.form.FieldSet({
		id:'rpt_terimabeli_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_terimabeli_noharga_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_terimabeli_noharga_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_terimabeli_noharga_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_terimabeli_noharga_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_terimabeli_noharga_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_terimabeli_noharga_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_terimabeli_noharga_tahunField]
					   }]
			}]
	});
	
	var	rpt_terimabeli_noharga_opsiField=new Ext.form.FieldSet({
		id: 'rpt_terimabeli_noharga_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_terimabeli_noharga_rekapField ,rpt_terimabeli_noharga_detailField]
	});
	
	var	rpt_terimabeli_noharga_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_terimabeli_noharga_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_terimabeli_noharga_groupField]
	});
	
	function is_valid_form(){
		if(rpt_terimabeli_noharga_opsitglField.getValue()==true){
			rpt_terimabeli_noharga_tglawalField.allowBlank=false;
			rpt_terimabeli_noharga_tglakhirField.allowBlank=false;
			if(rpt_terimabeli_noharga_tglawalField.isValid() && rpt_terimabeli_noharga_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_terimabeli_noharga_tglawalField.allowBlank=true;
			rpt_terimabeli_noharga_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_terimabeli_noharga(){
		
		var terimabeli_tglawal="";
		var terimabeli_tglakhir="";
		var jrpdouk_opsi="";
		var terimabeli_bulan="";
		var terimabeli_tahun="";
		var terimabeli_periode="";
		var terimabeli_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_terimabeli_noharga_tglawalField.getValue()!==""){terimabeli_tglawal = rpt_terimabeli_noharga_tglawalField.getValue().format('Y-m-d');}
		if(rpt_terimabeli_noharga_tglakhirField.getValue()!==""){terimabeli_tglakhir = rpt_terimabeli_noharga_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_terimabeli_noharga_bulanField.getValue()!==""){terimabeli_bulan=rpt_terimabeli_noharga_bulanField.getValue(); }
		if(rpt_terimabeli_noharga_tahunField.getValue()!==""){terimabeli_tahun=rpt_terimabeli_noharga_tahunField.getValue(); }
		if(rpt_terimabeli_noharga_opsitglField.getValue()==true){
			terimabeli_periode='tanggal';
		}else if(rpt_terimabeli_noharga_opsiblnField.getValue()==true){
			terimabeli_periode='bulan';
		}else{
			terimabeli_periode='all';
		}
		if(rpt_terimabeli_noharga_groupField.getValue()!==""){terimabeli_group=rpt_terimabeli_noharga_groupField.getValue(); }
		
		if(rpt_terimabeli_noharga_rekapField.getValue()==true){terimabeli_opsi='rekap';}else{terimabeli_opsi='detail';}
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_terima_beli&m=print_laporan_noharga',
				params: {
					tgl_awal	: terimabeli_tglawal,
					tgl_akhir	: terimabeli_tglakhir,
					opsi		: terimabeli_opsi,
					bulan		: terimabeli_bulan,
					tahun		: terimabeli_tahun,
					periode		: terimabeli_periode,
					group		: terimabeli_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						win = window.open('./print/report_terimabeli.html','report_terimabeli','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_terimabeli_nohargaForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_terimabeli_periodeField,rpt_terimabeli_noharga_opsiField, rpt_terimabeli_noharga_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_terimabeli_noharga
			},{
				text: 'Close',
				handler: function(){
					rpt_terimabeli_nohargaWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_terimabeli_nohargaWindow = new Ext.Window({
		title: 'Laporan Penerimaan Barang',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_terimabeli_noharga',
		items: rpt_terimabeli_nohargaForm
	});
  	rpt_terimabeli_nohargaWindow.show();
	
	//EVENTS
	
	rpt_terimabeli_noharga_rekapField.on("check", function(){
		rpt_terimabeli_noharga_groupField.setValue('No faktur');
		if(rpt_terimabeli_noharga_rekapField.getValue()==true){
			rpt_terimabeli_noharga_groupField.bindStore(group_master_noharga_Store);
		}else
		{
			rpt_terimabeli_noharga_groupField.bindStore(group_detail_noharga_Store);
		}
	});
	
	rpt_terimabeli_noharga_detailField.on("check", function(){
		rpt_terimabeli_noharga_groupField.setValue('No Faktur');
		if(rpt_terimabeli_noharga_detailField.getValue()==true){
			rpt_terimabeli_noharga_groupField.bindStore(group_detail_noharga_Store);
		}else
		{
			rpt_terimabeli_noharga_groupField.bindStore(group_master_noharga_Store);
		}
	});
	
	rpt_terimabeli_noharga_opsitglField.on("check",function(){
		if(rpt_terimabeli_noharga_opsitglField.getValue()==true){
			rpt_terimabeli_noharga_tglawalField.allowBlank=false;
			rpt_terimabeli_noharga_tglakhirField.allowBlank=false;
		}else{
			rpt_terimabeli_noharga_tglawalField.allowBlank=true;
			rpt_terimabeli_noharga_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info_noharga"></div>
		<div id="elwindow_rpt_terimabeli_noharga"></div>
    </div>
</div>
</body>