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

var rpt_invoiceWindow;
var rpt_invoiceForm;

var rpt_invoice_tglawalField;
var rpt_invoice_tglakhirField;
var rpt_invoice_rekapField;
var rpt_invoice_detailField;
var rpt_invoice_bulanField;
var rpt_invoice_tahunField;
var rpt_invoice_opsitglField;
var rpt_invoice_opsiblnField;
var rpt_invoice_opsiallField;
var rpt_invoice_groupField;

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
	
	var rpt_invoice_groupField=new Ext.form.ComboBox({
		id:'rpt_invoice_groupField',
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
	
	rpt_invoice_bulanField=new Ext.form.ComboBox({
		id:'rpt_invoice_bulanField',
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
	
	rpt_invoice_tahunField=new Ext.form.ComboBox({
		id:'rpt_invoice_tahunField',
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
	
	rpt_invoice_opsitglField=new Ext.form.Radio({
		id:'rpt_invoice_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_invoice_opsiblnField=new Ext.form.Radio({
		id:'rpt_invoice_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_invoice_opsiallField=new Ext.form.Radio({
		id:'rpt_invoice_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_invoice_tglawalField= new Ext.form.DateField({
		id: 'rpt_invoice_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_invoice_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_invoice_tglakhirField'
		value: today
	});
	
	rpt_invoice_tglakhirField= new Ext.form.DateField({
		id: 'rpt_invoice_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_invoice_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_invoice_tglawalField',
		value: today
	});
	
	rpt_invoice_rekapField=new Ext.form.Radio({
		id: 'rpt_invoice_rekapField',
		boxLabel: 'Rekap',
		name: 'invoice_opsi',
		checked: true
	});
	
	rpt_invoice_detailField=new Ext.form.Radio({
		id: 'rpt_invoice_detailField',
		boxLabel: 'Detail',
		name: 'invoice_opsi'
	});
	
	var rpt_invoice_periodeField=new Ext.form.FieldSet({
		id:'rpt_invoice_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_invoice_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_invoice_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_invoice_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_invoice_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_invoice_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_invoice_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_invoice_tahunField]
					   }]
			}]
	});
	
	var	rpt_invoice_opsiField=new Ext.form.FieldSet({
		id: 'rpt_invoice_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_invoice_rekapField ,rpt_invoice_detailField]
	});
	
	var	rpt_invoice_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_invoice_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_invoice_groupField]
	});
	
	function is_valid_form(){
		if(rpt_invoice_opsitglField.getValue()==true){
			rpt_invoice_tglawalField.allowBlank=false;
			rpt_invoice_tglakhirField.allowBlank=false;
			if(rpt_invoice_tglawalField.isValid() && rpt_invoice_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_invoice_tglawalField.allowBlank=true;
			rpt_invoice_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_invoice(){
		
		var invoice_tglawal="";
		var invoice_tglakhir="";
		var jrpdouk_opsi="";
		var invoice_bulan="";
		var invoice_tahun="";
		var invoice_periode="";
		var invoice_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_invoice_tglawalField.getValue()!==""){invoice_tglawal = rpt_invoice_tglawalField.getValue().format('Y-m-d');}
		if(rpt_invoice_tglakhirField.getValue()!==""){invoice_tglakhir = rpt_invoice_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_invoice_bulanField.getValue()!==""){invoice_bulan=rpt_invoice_bulanField.getValue(); }
		if(rpt_invoice_tahunField.getValue()!==""){invoice_tahun=rpt_invoice_tahunField.getValue(); }
		if(rpt_invoice_opsitglField.getValue()==true){
			invoice_periode='tanggal';
		}else if(rpt_invoice_opsiblnField.getValue()==true){
			invoice_periode='bulan';
		}else{
			invoice_periode='all';
		}
		if(rpt_invoice_groupField.getValue()!==""){invoice_group=rpt_invoice_groupField.getValue(); }
		
		if(rpt_invoice_rekapField.getValue()==true){invoice_opsi='rekap';}else{invoice_opsi='detail';}
		
			Ext.MessageBox.show({
			   msg: 'Sedang memproses data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
			
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_invoice&m=print_laporan',
				params: {
					tgl_awal	: invoice_tglawal,
					tgl_akhir	: invoice_tglakhir,
					opsi		: invoice_opsi,
					bulan		: invoice_bulan,
					tahun		: invoice_tahun,
					periode		: invoice_periode,
					group		: invoice_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_invoice.html','report_invoice','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_invoiceForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_invoice_periodeField,rpt_invoice_opsiField, rpt_invoice_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_invoice
			},{
				text: 'Close',
				handler: function(){
					rpt_invoiceWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_invoiceWindow = new Ext.Window({
		title: 'Laporan Tagihan Pembelian',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_invoice',
		items: rpt_invoiceForm
	});
  	rpt_invoiceWindow.show();
	
	//EVENTS
	
	rpt_invoice_rekapField.on("check", function(){
		rpt_invoice_groupField.setValue('No faktur');
		if(rpt_invoice_rekapField.getValue()==true){
			rpt_invoice_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_invoice_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_invoice_detailField.on("check", function(){
		rpt_invoice_groupField.setValue('No Faktur');
		if(rpt_invoice_detailField.getValue()==true){
			rpt_invoice_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_invoice_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_invoice_opsitglField.on("check",function(){
		if(rpt_invoice_opsitglField.getValue()==true){
			rpt_invoice_tglawalField.allowBlank=false;
			rpt_invoice_tglakhirField.allowBlank=false;
		}else{
			rpt_invoice_tglawalField.allowBlank=true;
			rpt_invoice_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_invoice"></div>
    </div>
</div>
</body>