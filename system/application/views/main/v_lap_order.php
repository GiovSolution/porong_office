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

var rpt_orderWindow;
var rpt_orderForm;

var rpt_order_tglawalField;
var rpt_order_tglakhirField;
var rpt_order_rekapField;
var rpt_order_detailField;
var rpt_order_bulanField;
var rpt_order_tahunField;
var rpt_order_opsitglField;
var rpt_order_opsiblnField;
var rpt_order_opsiallField;
var rpt_order_groupField;

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
	
	var rpt_order_groupField=new Ext.form.ComboBox({
		id:'rpt_order_groupField',
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
	
	rpt_order_bulanField=new Ext.form.ComboBox({
		id:'rpt_order_bulanField',
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
	
	rpt_order_tahunField=new Ext.form.ComboBox({
		id:'rpt_order_tahunField',
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
	
	rpt_order_opsitglField=new Ext.form.Radio({
		id:'rpt_order_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_order_opsiblnField=new Ext.form.Radio({
		id:'rpt_order_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_order_opsiallField=new Ext.form.Radio({
		id:'rpt_order_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_order_tglawalField= new Ext.form.DateField({
		id: 'rpt_order_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_order_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_order_tglakhirField'
		value: today
	});
	
	rpt_order_tglakhirField= new Ext.form.DateField({
		id: 'rpt_order_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_order_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_order_tglawalField',
		value: today
	});
	
	rpt_order_rekapField=new Ext.form.Radio({
		id: 'rpt_order_rekapField',
		boxLabel: 'Rekap',
		name: 'order_opsi',
		checked: true
	});
	
	rpt_order_detailField=new Ext.form.Radio({
		id: 'rpt_order_detailField',
		boxLabel: 'Detail',
		name: 'order_opsi'
	});
	
	var rpt_order_periodeField=new Ext.form.FieldSet({
		id:'rpt_order_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_order_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_order_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_order_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_order_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_order_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_order_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_order_tahunField]
					   }]
			}]
	});
	
	var	rpt_order_opsiField=new Ext.form.FieldSet({
		id: 'rpt_order_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_order_rekapField ,rpt_order_detailField]
	});
	
	var	rpt_order_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_order_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_order_groupField]
	});
	
	function is_valid_form(){
		if(rpt_order_opsitglField.getValue()==true){
			rpt_order_tglawalField.allowBlank=false;
			rpt_order_tglakhirField.allowBlank=false;
			if(rpt_order_tglawalField.isValid() && rpt_order_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_order_tglawalField.allowBlank=true;
			rpt_order_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_order(){
		
		var order_tglawal="";
		var order_tglakhir="";
		var order_opsi="";
		var order_bulan="";
		var order_tahun="";
		var order_periode="";
		var order_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_order_tglawalField.getValue()!==""){order_tglawal = rpt_order_tglawalField.getValue().format('Y-m-d');}
		if(rpt_order_tglakhirField.getValue()!==""){order_tglakhir = rpt_order_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_order_bulanField.getValue()!==""){order_bulan=rpt_order_bulanField.getValue(); }
		if(rpt_order_tahunField.getValue()!==""){order_tahun=rpt_order_tahunField.getValue(); }
		if(rpt_order_opsitglField.getValue()==true){
			order_periode='tanggal';
		}else if(rpt_order_opsiblnField.getValue()==true){
			order_periode='bulan';
		}else{
			order_periode='all';
		}
		if(rpt_order_groupField.getValue()!==""){order_group=rpt_order_groupField.getValue(); }
		
		if(rpt_order_rekapField.getValue()==true){order_opsi='rekap';}else{order_opsi='detail';}
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_order_beli&m=print_laporan',
				params: {
					tgl_awal	: order_tglawal,
					tgl_akhir	: order_tglakhir,
					opsi		: order_opsi,
					bulan		: order_bulan,
					tahun		: order_tahun,
					periode		: order_periode,
					group		: order_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						win = window.open('./print/report_order.html','report_order','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_orderForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_order_periodeField,rpt_order_opsiField, rpt_order_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_order
			},{
				text: 'Close',
				handler: function(){
					rpt_orderWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_orderWindow = new Ext.Window({
		title: 'Laporan Order Pembelian',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_order',
		items: rpt_orderForm
	});
  	rpt_orderWindow.show();
	
	//EVENTS
	
	rpt_order_rekapField.on("check", function(){
		rpt_order_groupField.setValue('No Faktur');
		if(rpt_order_rekapField.getValue()==true){
			rpt_order_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_order_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_order_detailField.on("check", function(){
		rpt_order_groupField.setValue('No Faktur');
		if(rpt_order_detailField.getValue()==true){
			rpt_order_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_order_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_order_opsitglField.on("check",function(){
		if(rpt_order_opsitglField.getValue()==true){
			rpt_order_tglawalField.allowBlank=false;
			rpt_order_tglakhirField.allowBlank=false;
		}else{
			rpt_order_tglawalField.allowBlank=true;
			rpt_order_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_order"></div>
    </div>
</div>
</body>