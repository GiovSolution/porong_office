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

var rpt_netsalesWindow;
var rpt_netsalesForm;

var rpt_netsales_tglawalField;
var rpt_netsales_tglakhirField;
var rpt_netsales_rekapField;
var rpt_netsales_detailField;
var rpt_netsales_bulanField;
var rpt_netsales_tahunField;
var rpt_netsales_opsitglField;
var rpt_netsales_opsiblnField;
var rpt_netsales_opsiallField;

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

  
  
  Ext.Ajax.request({
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_lap_netsales&m=get_action',
				params: {
					task: 'CHART',
					method: 'POST'
					
				},
				success: function(result, request){
				  	var hasil=eval(result.responseText);
				  	switch(hasil){
				  	case 1:
				  		Ext.MessageBox.hide();
						
						laporanNetSalesChart.render();
						//laporanNetSalesChart.show();
						//Ext.getCmp('laporanNetSalesChart').update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
						
				  		//laporanNetSalesChart.update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
						

						break;
				  	default:
				  		Ext.MessageBox.hide();
						Ext.MessageBox.show({
							title: 'Warning',
							//msg: FAILED_PRINT,
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING
						});
						break;
				  	}
				},
				failure: function(response){
				  	Ext.MessageBox.hide();
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: FAILED_CONNECTION,
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});
				}
			});
  
  
  
  
  
	var group_master_Store= new Ext.data.SimpleStore({
			id: 'group_master_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer'],['Produk'],['Sales'],['Jenis Diskon']]
	});
	
	/* Function for Retrieve DataStore */
	//isc_datastore
	net_salesDataStore = new Ext.data.Store({
		id: 'net_salesDataStore',
		proxy: new Ext.data.HttpProxy({
			timeout: 480000,
			url: 'index.php?c=c_lap_netsales&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */
			{name: 'tns_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tns_tanggal'},
			{name: 'tns_medis', type: 'float', mapping: 'tns_medis'},
			{name: 'tns_nonmedis', type: 'float', mapping: 'tns_nonmedis'},
			{name: 'tns_produk', type: 'float', mapping: 'tns_produk'},
			{name: 'tns_antiaging', type: 'float', mapping: 'tns_antiaging'},
			{name: 'tns_lainlain', type: 'float', mapping: 'tns_lainlain'},
			{name: 'tns_surgery', type: 'float', mapping: 'tns_surgery'},
			{name: 'tns_total', type: 'float', mapping: 'tns_total'},
			{name: 'tns_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'tns_date_create'},
			{name: 'tns_source', type: 'string', mapping: 'tns_source'},
		]),
		
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	/* End of Function */

	net_salesTotalDataStore = new Ext.data.Store({
		id: 'net_salesTotalDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_netsales&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LISTTOTAL",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */
			{name: 'tns_medis_total', type: 'float', mapping: 'tns_medis_total'},
			{name: 'tns_nonmedis_total', type: 'float', mapping: 'tns_nonmedis_total'},
			{name: 'tns_produk_total', type: 'float', mapping: 'tns_produk_total'},
			{name: 'tns_antiaging_total', type: 'float', mapping: 'tns_antiaging_total'},
			{name: 'tns_lainlain_total', type: 'float', mapping: 'tns_lainlain_total'},
			{name: 'tns_surgery_total', type: 'float', mapping: 'tns_surgery_total'},
			{name: 'tns_grand_total', type: 'float', mapping: 'tns_grand_total'}
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	/* End of Function */
	
	net_salesTotalDataStore.load();
	net_salesDataStore.load();
	
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!rpt_netsalesWindow.isVisible()){
			rpt_netsalesWindow.show();
		} else {
			rpt_netsalesWindow.toFront();
		}
	}
  	/* End Function */
	
	net_salesColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'tns_tanggal',
			width: 70,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			sortable: true
		}, 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'tns_medis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'tns_nonmedis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'tns_surgery',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'tns_antiaging',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'tns_produk',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Lain-lain' + '</div>',
			dataIndex: 'tns_lainlain',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Total' + '</div>',
			dataIndex: 'tns_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{
			align : 'center',
			header: '<div align="center">' + 'Last Calculated' + '</div>',
			dataIndex: 'tns_date_create',
			width: 80,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i'),
			sortable: true,
			hidden: true
		},{	
			align : 'Center',
			header: '<div align="center">' + 'Sumber' + '</div>',
			dataIndex: 'tns_source',
			readOnly: true,
			width: 80,	//55,
			sortable: true,
			hidden: true
		}
	]);
	
	net_salesColumnModel.defaultSortable= true;

	net_salesTotalColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: '',
			disabled : false,
			width: 70			
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'tns_medis_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'tns_nonmedis_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 90,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'tns_surgery_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'tns_antiaging_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'tns_produk_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Lain-lain' + '</div>',
			dataIndex: 'tns_lainlain_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: 'tns_grand_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{
			align : 'Left',
			header: '',
			dataIndex: '',
			width: 80,
			sortable: true,
			hidden: true
		}
	]);
	
	net_salesTotalColumnModel.defaultSortable= true;

	
	/* Declare DataStore and  show datagrid list */
	net_salesListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'net_salesListEditorGrid',
		el: 'fp_netsales_list',
		title: 'Laporan Net Sales',
		autoHeight: true,
		store: net_salesDataStore, // DataStore
		cm: net_salesColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Search',
			tooltip: 'Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: net_sales_print  
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: net_sales_export_excel
		}
		]
	});
	net_salesListEditorGrid.render();
	/* End of DataStore */
	
	net_salesTotalListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'net_salesTotalListEditorGrid',
		el: 'fp_netsalesTotal_list',
		title: '',
		autoHeight: true,
		store: net_salesTotalDataStore, // DataStore
		cm: net_salesTotalColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
	});
	net_salesTotalListEditorGrid.render();
	/* End of DataStore */
		
	
	rpt_netsales_bulanField=new Ext.form.ComboBox({
		id:'rpt_netsales_bulanField',
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
	
	rpt_netsales_tahunField=new Ext.form.ComboBox({
		id:'rpt_netsales_tahunField',
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
	
	rpt_netsales_opsitglField=new Ext.form.Radio({
		id:'rpt_netsales_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_netsales_opsiblnField=new Ext.form.Radio({
		id:'rpt_netsales_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_netsales_opsiallField=new Ext.form.Radio({
		id:'rpt_netsales_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_netsales_tglawalField= new Ext.form.DateField({
		id: 'rpt_netsales_tglawalField',
		fieldLabel: ' ',
		format : 'd-m-Y',
		name: 'rpt_netsales_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_netsales_tglakhirField'
		value: today
	});
	
	rpt_netsales_tglakhirField= new Ext.form.DateField({
		id: 'rpt_netsales_tglakhirField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		name: 'rpt_netsales_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_netsales_tglawalField',
		value: today
	});
	
	rpt_netsales_rekapField=new Ext.form.Radio({
		id: 'rpt_netsales_rekapField',
		boxLabel: 'Rekap',
		name: 'netsales_opsi',
		checked: true
	});
	
	rpt_netsales_detailField=new Ext.form.Radio({
		id: 'rpt_netsales_detailField',
		boxLabel: 'Detail',
		name: 'netsales_opsi'
	});
	
	var rpt_netsales_periodeField=new Ext.form.FieldSet({
		id:'rpt_netsales_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_netsales_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_netsales_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_netsales_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_netsales_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_netsales_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_netsales_tahunField]
					   }]
			}]
	});
	
	var	rpt_netsales_opsiField=new Ext.form.FieldSet({
		id: 'rpt_netsales_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_netsales_rekapField ,rpt_netsales_detailField]
	});
	
	rpt_netsales_dailyField=new Ext.form.Radio({
		id: 'rpt_netsales_dailyField',
		boxLabel: 'Daily',
		name: 'netsales_opsi',
		checked: true
	});
	
	rpt_netsales_monthlyField=new Ext.form.Radio({
		id: 'rpt_netsales_monthlyField',
		boxLabel: 'Monthly',
		name: 'netsales_opsi',
		disabled: true
	});

	rpt_netsales_yearlyField=new Ext.form.Radio({
		id: 'rpt_netsales_yearlyField',
		boxLabel: 'Yearly',
		name: 'netsales_opsi',
		disabled: true
	});

	var	rpt_netsales_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_netsales_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_netsales_dailyField, rpt_netsales_monthlyField, rpt_netsales_yearlyField]
	});
	
	function is_valid_form(){
		if(rpt_netsales_opsitglField.getValue()==true){
			rpt_netsales_tglawalField.allowBlank=false;
			rpt_netsales_tglakhirField.allowBlank=false;
			if(rpt_netsales_tglawalField.isValid() && rpt_netsales_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_netsales_tglawalField.allowBlank=true;
			rpt_netsales_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	function lap_netsales_recalc(){
	
		var netsales_tglawal="";
		var netsales_tglakhir="";
		var netsales_opsi="";
		var netsales_bulan="";
		var netsales_tahun="";
		var netsales_periode="";
		var netsales_groupby = "";
		
		if(is_valid_form()){
			
		if(rpt_netsales_tglawalField.getValue()!==""){netsales_tglawal = rpt_netsales_tglawalField.getValue().format('Y-m-d');}
		if(rpt_netsales_tglakhirField.getValue()!==""){netsales_tglakhir = rpt_netsales_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_netsales_bulanField.getValue()!==""){netsales_bulan=rpt_netsales_bulanField.getValue(); }
		if(rpt_netsales_tahunField.getValue()!==""){netsales_tahun=rpt_netsales_tahunField.getValue(); }
		if(rpt_netsales_opsitglField.getValue()==true){
			netsales_periode='tanggal';
		}else if(rpt_netsales_opsiblnField.getValue()==true){
			netsales_periode='bulan';
		}
		
		if (rpt_netsales_dailyField.getValue() == true) {
			netsales_groupby	= 'daily';
		} else if (rpt_netsales_monthlyField.getValue() == true) {
			netsales_groupby	= 'monthly';
		} else if (rpt_netsales_yearlyField.getValue() == true) {
			netsales_groupby	= 'yearly';
		}
					
		net_salesDataStore.baseParams = {
					task		: 'RECALC',
					tgl_awal	: netsales_tglawal,
					tgl_akhir	: netsales_tglakhir,
					bulan		: netsales_bulan,
					tahun		: netsales_tahun,
					periode		: netsales_periode,
					groupby		: netsales_groupby
		};
				
		net_salesTotalDataStore.baseParams = {
					task		: 'RECALC2',
					tgl_awal	: netsales_tglawal,
					tgl_akhir	: netsales_tglakhir,
					bulan		: netsales_bulan,
					tahun		: netsales_tahun,
					periode		: netsales_periode			
		};
				
		Ext.MessageBox.show({
		   msg: 'Sedang Proses...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
				
		net_salesDataStore.reload({
			callback: function(opts, success, response){
				if(success){
					net_salesTotalDataStore.reload();
					
					//CHART
					Ext.Ajax.request({
						waitMsg: 'Please Wait...',
						url: 'index.php?c=c_lap_netsales&m=get_action',
						params: {
							task: 'CHART_SEARCH',
							tgl_awal	: netsales_tglawal,
							tgl_akhir	: netsales_tglakhir,
							bulan		: netsales_bulan,
							tahun		: netsales_tahun,
							periode		: netsales_periode,
							method: 'POST'
							
						},
						success: function(result, request){
							var hasil=eval(result.responseText);
							switch(hasil){
							case 1:
								Ext.MessageBox.hide();
								
								//laporanNetSalesChart.render();
								laporanNetSalesChart.show();
								//Ext.getCmp('laporanNetSalesChart').update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
								
								laporanNetSalesChart.update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
								

								break;
							default:
								Ext.MessageBox.hide();
								Ext.MessageBox.show({
									title: 'Warning',
									//msg: FAILED_PRINT,
									buttons: Ext.MessageBox.OK,
									animEl: 'save',
									icon: Ext.MessageBox.WARNING
								});
								break;
							}
						},
						failure: function(response){
							Ext.MessageBox.hide();
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: FAILED_CONNECTION,
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
						}
					});					
					
					Ext.MessageBox.hide();
					}
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
	
	
	
	/* Function for print List Grid */
	function net_sales_print(){
		//var searchquery = "";
	
		var netsales_tglawal_print="";
		var netsales_tglakhir_print="";
		var netsales_bulan_print="";
		var netsales_tahun_print="";
		var netsales_periode_print="";
		var netsales_groupby_print = "";      	
		// check if we do have some search data...
		if(net_salesDataStore.baseParams.tgl_awal!==null){netsales_tglawal_print = net_salesDataStore.baseParams.tgl_awal;}
		if(net_salesDataStore.baseParams.tgl_akhir!==null){netsales_tglakhir_print = net_salesDataStore.baseParams.tgl_akhir;}
		if(net_salesDataStore.baseParams.bulan!==null){netsales_bulan_print = net_salesDataStore.baseParams.bulan;}
		if(net_salesDataStore.baseParams.tahun!==null){netsales_tahun_print = net_salesDataStore.baseParams.tahun;}
		if(net_salesDataStore.baseParams.periode!==null){netsales_periode_print = net_salesDataStore.baseParams.periode;}
		if(net_salesDataStore.baseParams.groupby!==null){netsales_groupby_print = net_salesDataStore.baseParams.groupby;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_netsales&m=get_action',
		params: {
			task: "PRINT",
			tgl_awal	: netsales_tglawal_print,
			tgl_akhir	: netsales_tglakhir_print,
			bulan		: netsales_bulan_print,
			tahun		: netsales_tahun_print,
			periode		: netsales_periode_print,
			groupby		: netsales_groupby_print,
		  	//query		: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
		  	currentlisting: net_salesDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/lap_netsales.html','lap_netsales','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
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
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function net_sales_export_excel(){
		//var searchquery = "";
		var netsales_tglawal_export_excel="";
		var netsales_tglakhir_export_excel="";
		var netsales_bulan_export_excel="";
		var netsales_tahun_export_excel="";
		var netsales_periode_export_excel="";
		var netsales_groupby_export_excel= "";      	
		// check if we do have some search data...
		if(net_salesDataStore.baseParams.tgl_awal!==null){netsales_tglawal_export_excel = net_salesDataStore.baseParams.tgl_awal;}
		if(net_salesDataStore.baseParams.tgl_akhir!==null){netsales_tglakhir_export_excel = net_salesDataStore.baseParams.tgl_akhir;}
		if(net_salesDataStore.baseParams.bulan!==null){netsales_bulan_export_excel = net_salesDataStore.baseParams.bulan;}
		if(net_salesDataStore.baseParams.tahun!==null){netsales_tahun_export_excel = net_salesDataStore.baseParams.tahun;}
		if(net_salesDataStore.baseParams.periode!==null){netsales_periode_export_excel = net_salesDataStore.baseParams.periode;}
		if(net_salesDataStore.baseParams.groupby!==null){netsales_groupby_export_excel = net_salesDataStore.baseParams.groupby;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_netsales&m=get_action',
		params: {
			task: "EXCEL",
			tgl_awal	: netsales_tglawal_export_excel,
			tgl_akhir	: netsales_tglakhir_export_excel,
			bulan		: netsales_bulan_export_excel,
			tahun		: netsales_tahun_export_excel,
			periode		: netsales_periode_export_excel,
			groupby		: netsales_groupby_export_excel,
		  	//query		: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
		  	currentlisting: net_salesDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/Laporan_NetSales.xls','lap_netsales','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
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
	}
	/* Enf Function */

	/* Function for print List Grid */
	function lap_netsales_search(){
		
		var netsales_tglawal="";
		var netsales_tglakhir="";
		var netsales_opsi="";
		var netsales_bulan="";
		var netsales_tahun="";
		var netsales_periode="";
		
		if(is_valid_form()){
			
		if(rpt_netsales_tglawalField.getValue()!==""){netsales_tglawal = rpt_netsales_tglawalField.getValue().format('Y-m-d');}
		if(rpt_netsales_tglakhirField.getValue()!==""){netsales_tglakhir = rpt_netsales_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_netsales_bulanField.getValue()!==""){netsales_bulan=rpt_netsales_bulanField.getValue(); }
		if(rpt_netsales_tahunField.getValue()!==""){netsales_tahun=rpt_netsales_tahunField.getValue(); }
		if(rpt_netsales_opsitglField.getValue()==true){
			netsales_periode='tanggal';
		}else if(rpt_netsales_opsiblnField.getValue()==true){
			netsales_periode='bulan';
		}
					
		net_salesDataStore.baseParams = {
					task		: 'SEARCH',
					tgl_awal	: netsales_tglawal,
					tgl_akhir	: netsales_tglakhir,
					bulan		: netsales_bulan,
					tahun		: netsales_tahun,
					periode		: netsales_periode			
		};
				
		net_salesTotalDataStore.baseParams = {
					task		: 'SEARCH2',
					tgl_awal	: netsales_tglawal,
					tgl_akhir	: netsales_tglakhir,
					bulan		: netsales_bulan,
					tahun		: netsales_tahun,
					periode		: netsales_periode			
		};
				
		Ext.MessageBox.show({
		   msg: 'Sedang Proses...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		net_salesDataStore.reload({
			callback: function(opts, success, response){
				if(success){
					net_salesTotalDataStore.reload();
					
					//CHART
					Ext.Ajax.request({
						waitMsg: 'Please Wait...',
						url: 'index.php?c=c_lap_netsales&m=get_action',
						params: {
							task: 'CHART_SEARCH',
							tgl_awal	: netsales_tglawal,
							tgl_akhir	: netsales_tglakhir,
							bulan		: netsales_bulan,
							tahun		: netsales_tahun,
							periode		: netsales_periode,
							method: 'POST'
							
						},
						success: function(result, request){
							var hasil=eval(result.responseText);
							switch(hasil){
							case 1:
								Ext.MessageBox.hide();
								
								//laporanNetSalesChart.render();
								laporanNetSalesChart.show();
								//Ext.getCmp('laporanNetSalesChart').update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
								
								laporanNetSalesChart.update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>");
								

								break;
							default:
								Ext.MessageBox.hide();
								Ext.MessageBox.show({
									title: 'Warning',
									//msg: FAILED_PRINT,
									buttons: Ext.MessageBox.OK,
									animEl: 'save',
									icon: Ext.MessageBox.WARNING
								});
								break;
							}
						},
						failure: function(response){
							Ext.MessageBox.hide();
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: FAILED_CONNECTION,
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
						}
					});	
					
					Ext.MessageBox.hide();
					}
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
	
	rpt_netsalesForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_netsales_periodeField, rpt_netsales_groupbyField],
		monitorValid:true,
		buttons: 
		[{
			text: 'Quick Search',
			formBind: true,
			tooltip: 'Menampilkan Net Sales dari perhitungan yang telah dilakukan sebelumnya. Fungsi ini tidak membutuhkan waktu lama.',
			handler: lap_netsales_search
		},{
			xtype:'spacer',
			width: 140
		},{
			text: 'Search',
			formBind: true,
			tooltip: 'Menghitung Net Sales dari keseluruhan transaksi pada tanggal terpilih. Fungsi ini membutuhkan waktu cukup lama.',
			handler: lap_netsales_recalc
		},{
			text: 'Close',
			handler: function(){
				rpt_netsalesWindow.hide();
				//mainPanel.remove(mainPanel.getActiveTab().getId());
			}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_netsalesWindow = new Ext.Window({
		title: 'Laporan Net Sales',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_netsales',
		items: rpt_netsalesForm
	});
  	//rpt_netsalesWindow.show();
	
	
	laporanNetSalesChart =	new Ext.form.FormPanel ({
							title: 'Grafik Laporan Net Sales',
							resizeable: true,
							id: 'laporanNetSalesChart',
							el: 'netsales_chart',
					        width: 1200,
							height: 450,
							collapsible: true,
							layout: 'fit',
							//autoLoad: 'true',
							frame: true,
							html: "<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_graph.php'></iframe>",
							autoDestroy: true,
							});
	
});
	</script>
<body>
<div>
	<div class="col">
		<div id="fp_netsales_list"></div>
        <div id="fp_netsalesTotal_list"></div>
        <div id="netsales_chart"></div>
		<!--<div id="fp_netsales"></div>-->
		<div id="elwindow_rpt_netsales"></div>
    </div>
</div>
</body>