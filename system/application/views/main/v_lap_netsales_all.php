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

var rpt_netsales_allWindow;
var rpt_netsales_allForm;

var rpt_netsales_all_tglawalField;
var rpt_netsales_all_tglakhirField;
var rpt_netsales_all_rekapField;
var rpt_netsales_all_detailField;
var rpt_netsales_all_bulanField;
var rpt_netsales_all_tahunField;
var rpt_netsales_all_opsitglField;
var rpt_netsales_all_opsiblnField;
var rpt_netsales_all_opsiallField;
var rpt_netsales_all_groupField;

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

  
/*  
  Ext.Ajax.request({
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_lap_netsales_all&m=get_action',
				params: {
					task: 'CHART',
					method: 'POST'
					
				},
				success: function(result, request){
				  	var hasil=eval(result.responseText);
				  	switch(hasil){
				  	case 1:
				  		Ext.MessageBox.hide();
						
						//laporannetsales_allChart.render();
						//laporannetsales_allChart.show();
						//Ext.getCmp('laporannetsales_allChart').update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_all_graph.php'></iframe>");
						
				  		//laporannetsales_allChart.update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_all_graph.php'></iframe>");
						

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
  
*/  
  
  
  
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
	
	cabang_thField=new Ext.form.Checkbox({
		id : 'cabang_thField',
		boxLabel: 'TH',
		name: 'cabang_th',
		checked: true
	});
				
	cabang_kiField=new Ext.form.Checkbox({
		id : 'cabang_kiField',
		boxLabel: 'KI',
		name: 'cabang_ki',
		checked: true
	});

	cabang_hrField=new Ext.form.Checkbox({
		id : 'cabang_hrField',
		boxLabel: 'HR',
		name: 'cabang_hr',
		checked: true
	});

	cabang_tpField=new Ext.form.Checkbox({
		id : 'cabang_tpField',
		boxLabel: 'TP',
		name: 'cabang_tp',
		checked: true
	});

	cabang_mlgField=new Ext.form.Checkbox({
		id : 'cabang_mlgField',
		boxLabel: 'MLG',
		name: 'cabang_mlg',
		disabled: true
	});

	cabang_dpsField=new Ext.form.Checkbox({
		id : 'cabang_dpsField',
		boxLabel: 'DPS',
		name: 'cabang_dps',
		checked: true
	});

	cabang_jktField=new Ext.form.Checkbox({
		id : 'cabang_jktField',
		boxLabel: 'JKT',
		name: 'cabang_jkt',
		disabled: true
	});

	cabang_mtaField=new Ext.form.Checkbox({
		id : 'cabang_mtaField',
		boxLabel: 'MTA',
		name: 'cabang_mta',
		checked: true
	});

	cabang_blpnField=new Ext.form.Checkbox({
		id : 'cabang_blpnField',
		boxLabel: 'BLPN',
		name: 'cabang_blpn',
		checked: true
	});

	cabang_kutaField=new Ext.form.Checkbox({
		id : 'cabang_kutaField',
		boxLabel: 'KUTA',
		name: 'cabang_kuta',
		disabled: true
	});

	cabang_btmField=new Ext.form.Checkbox({
		id : 'cabang_btmField',
		boxLabel: 'BTM',
		name: 'cabang_btm',
		disabled: true
	});

	cabang_mksField=new Ext.form.Checkbox({
		id : 'cabang_mksField',
		boxLabel: 'MKS',
		name: 'cabang_mks',
		disabled: true
	});

	cabang_mdnField=new Ext.form.Checkbox({
		id : 'cabang_mdnField',
		boxLabel: 'MDN',
		name: 'cabang_mdn',
		checked: true
	});

	cabang_lbkField=new Ext.form.Checkbox({
		id : 'cabang_lbkField',
		boxLabel: 'LBK',
		name: 'cabang_lbk',
		checked: true
	});

	cabang_mndField=new Ext.form.Checkbox({
		id : 'cabang_mndField',
		boxLabel: 'MND',
		name: 'cabang_mnd',
		checked: true
	});

	cabang_ygkField=new Ext.form.Checkbox({
		id : 'cabang_ygkField',
		boxLabel: 'YGK',
		name: 'cabang_ygk',
		checked: true	
	});

	cabangGroup = new Ext.form.FieldSet({
		title: 'Cabang',
		layout:'column',
		autoHeight: true,
		collapsed: false,
		mode: 'remote',
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [cabang_thField, cabang_kiField, cabang_hrField, cabang_tpField, cabang_mlgField, cabang_dpsField, cabang_jktField, cabang_mtaField, cabang_blpnField]
			},
			{
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[cabang_kutaField, cabang_btmField, cabang_mksField, cabang_mdnField, cabang_lbkField, cabang_mndField, cabang_ygkField]
			   }
		]
	});
 
 /* Function for Retrieve DataStore */
	//isc_datastore
	netsales_allDataStore = new Ext.data.Store({
		id: 'netsales_allDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_netsales_all&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */
			{name: 'cabang_kode', type: 'string', mapping: 'cabang_kode'},
			{name: 'tns_medis', type: 'float', mapping: 'tns_medis'},
			{name: 'tns_nonmedis', type: 'float', mapping: 'tns_nonmedis'},
			{name: 'tns_produk', type: 'float', mapping: 'tns_produk'},
			{name: 'tns_antiaging', type: 'float', mapping: 'tns_antiaging'},
			{name: 'tns_lainlain', type: 'float', mapping: 'tns_lainlain'},
			{name: 'tns_surgery', type: 'float', mapping: 'tns_surgery'},
			{name: 'tns_total', type: 'float', mapping: 'tns_total'},
			{name: 'tns_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'tns_date_create'},
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	/* End of Function */

	netsales_allTotalDataStore = new Ext.data.Store({
		id: 'netsales_allTotalDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_netsales_all&m=get_action', 
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

	detail_netsalesDataStore = new Ext.data.Store({
		id: 'detail_netsalesDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_netsales_all&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LISTTOTAL",start:0}, // parameter yang di $_POST ke Controller
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
	
	//netsales_allTotalDataStore.load();
	//netsales_allDataStore.load();
	
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!rpt_netsales_allWindow.isVisible()){
			rpt_netsales_allWindow.show();
		} else {
			rpt_netsales_allWindow.toFront();
		}
	}
  	/* End Function */
	
	var netsales_all_periodeField=new Ext.form.TextField({ width: 160, readOnly : true });
	
	netsales_allColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Cabang' + '</div>',
			dataIndex: 'cabang_kode',
			width: 70,
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
			header: '<div align="center">' + 'Non Mds (- Vcr PR)' + '</div>',
			dataIndex: 'tns_nonmedis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 90,	//55,
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
			header: '<div align="center">' + 'Last Recalculated' + '</div>',
			dataIndex: 'tns_date_create',
			width: 80,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i'),
			sortable: true,
			hidden: true
		}
	]);
	
	netsales_allColumnModel.defaultSortable= true;

	netsales_allTotalColumnModel = new Ext.grid.ColumnModel(
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
			header: '<div align="center">' + 'Non Mds (- Vcr PR)' + '</div>',
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
	
	netsales_allTotalColumnModel.defaultSortable= true;

	detail_netsalesColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Left',
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'tns_tanggal',
			width: 70,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			sortable: true	
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'tns_medis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Non Mds (- Vcr PR)' + '</div>',
			dataIndex: 'tns_nonmedis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 90,	//55,
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
	
	detail_netsalesColumnModel.defaultSortable= true;
	
	/* Declare DataStore and  show datagrid list */
	netsales_allListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'netsales_allListEditorGrid',
		el: 'fp_netsales_all_list',
		title: 'Laporan Net Sales Semua Cabang',
		autoHeight: true,
		store: netsales_allDataStore, // DataStore
		cm: netsales_allColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Search',
			tooltip: 'Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},
		'-',
		'<b>Periode : </b>',
		netsales_all_periodeField,
		/*, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_print  
		}*/
		]
	});
	netsales_allListEditorGrid.render();
	/* End of DataStore */
	
	netsales_allTotalListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'netsales_allTotalListEditorGrid',
		el: 'fp_netsales_allTotal_list',
		title: '',
		autoHeight: true,
		store: netsales_allTotalDataStore, // DataStore
		cm: netsales_allTotalColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
	});
	netsales_allTotalListEditorGrid.render();
	/* End of DataStore */
	
	detail_netsalesListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'detail_netsalesListEditorGrid',
		title: 'Detail Net Sales',
		el: 'fp_netsales_detail',
        store: detail_netsalesDataStore,
        cm: detail_netsalesColumnModel,
/*		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
       stripeRows: true,
        autoExpandColumn: 'company',
 */		autoHeight: true,
		style: 'margin-top: 10px',
        width: 900,
		viewConfig: { forceFit:true },
    });
    detail_netsalesListEditorGrid.render();
	
	netsales_allListEditorGrid.on('rowclick', function (netsales_allListEditorGrid, rowIndex, eventObj) {
		
		var netsales_all_tglawal="";
		var netsales_all_tglakhir="";
		var netsales_all_opsi="";
		var netsales_all_bulan="";
		var netsales_all_tahun="";
		var netsales_all_periode="";
		var netsales_all_cabang	= "''";		
			
		if(rpt_netsales_all_tglawalField.getValue()!==""){netsales_all_tglawal = rpt_netsales_all_tglawalField.getValue().format('Y-m-d');}
		if(rpt_netsales_all_tglakhirField.getValue()!==""){netsales_all_tglakhir = rpt_netsales_all_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_netsales_all_bulanField.getValue()!==""){netsales_all_bulan=rpt_netsales_all_bulanField.getValue(); }
		if(rpt_netsales_all_tahunField.getValue()!==""){netsales_all_tahun=rpt_netsales_all_tahunField.getValue(); }
		if(rpt_netsales_all_opsitglField.getValue()==true){
			netsales_all_periode='tanggal';
		}else if(rpt_netsales_all_opsiblnField.getValue()==true){
			netsales_all_periode='bulan';
		}
							
		var recordMaster = netsales_allListEditorGrid.getSelectionModel().getSelected();			
		
		detail_netsalesDataStore.reload({params : {
			cabang		: "'"+recordMaster.get("cabang_kode")+"'",
			task		: 'DETAIL',
			tgl_awal	: netsales_all_tglawal,
			tgl_akhir	: netsales_all_tglakhir,
			bulan		: netsales_all_bulan,
			tahun		: netsales_all_tahun,
			periode		: netsales_all_periode
		}});

	});
	
	var rpt_netsales_all_groupField=new Ext.form.ComboBox({
		id:'rpt_netsales_all_groupField',
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
	
	rpt_netsales_all_bulanField=new Ext.form.ComboBox({
		id:'rpt_netsales_all_bulanField',
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
	
	rpt_netsales_all_tahunField=new Ext.form.ComboBox({
		id:'rpt_netsales_all_tahunField',
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
	
	rpt_netsales_all_opsitglField=new Ext.form.Radio({
		id:'rpt_netsales_all_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_netsales_all_opsiblnField=new Ext.form.Radio({
		id:'rpt_netsales_all_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_netsales_all_opsiallField=new Ext.form.Radio({
		id:'rpt_netsales_all_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_netsales_all_tglawalField= new Ext.form.DateField({
		id: 'rpt_netsales_all_tglawalField',
		fieldLabel: ' ',
		format : 'd-m-Y',
		name: 'rpt_netsales_all_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_netsales_all_tglakhirField'
		value: yesterday
	});
	
	rpt_netsales_all_tglakhirField= new Ext.form.DateField({
		id: 'rpt_netsales_all_tglakhirField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		name: 'rpt_netsales_all_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_netsales_all_tglawalField',
		value: yesterday
	});
	
	rpt_netsales_all_rekapField=new Ext.form.Radio({
		id: 'rpt_netsales_all_rekapField',
		boxLabel: 'Rekap',
		name: 'netsales_all_opsi',
		checked: true
	});
	
	rpt_netsales_all_detailField=new Ext.form.Radio({
		id: 'rpt_netsales_all_detailField',
		boxLabel: 'Detail',
		name: 'netsales_all_opsi'
	});
	
	var rpt_netsales_all_periodeField=new Ext.form.FieldSet({
		id:'rpt_netsales_all_periodeField',
		title : 'Periode (maks H-1)',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_netsales_all_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_netsales_all_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_netsales_all_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_netsales_all_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_netsales_all_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_netsales_all_tahunField]
					   }]
			}]
	});
	
	var	rpt_netsales_all_opsiField=new Ext.form.FieldSet({
		id: 'rpt_netsales_all_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_netsales_all_rekapField ,rpt_netsales_all_detailField]
	});
	
	var	rpt_netsales_all_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_netsales_all_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_netsales_all_groupField]
	});
	
	function is_valid_form(){
		if(rpt_netsales_all_opsitglField.getValue()==true){
			rpt_netsales_all_tglawalField.allowBlank=false;
			rpt_netsales_all_tglakhirField.allowBlank=false;
			if(rpt_netsales_all_tglawalField.isValid() && rpt_netsales_all_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_netsales_all_tglawalField.allowBlank=true;
			rpt_netsales_all_tglakhirField.allowBlank=true;
			return true;
		}
	}
	

	/* Function for print List Grid */
	function lap_netsales_all_search(){
		
		var netsales_all_tglawal="";
		var netsales_all_tglakhir="";
		var netsales_all_opsi="";
		var netsales_all_bulan="";
		var netsales_all_tahun="";
		var netsales_all_periode="";
		var netsales_all_th		= "''";
		var netsales_all_ki		= "''";
		var netsales_all_hr		= "''";
		var netsales_all_tp		= "''";
		var netsales_all_dps	= "''";
		var netsales_all_mta	= "''";
		var netsales_all_mdn	= "''";
		var netsales_all_lbk	= "''";
		var netsales_all_mnd	= "''";
		var netsales_all_ygk	= "''";
		var netsales_all_blpn	= "''";
				
		if(is_valid_form()){
		
		
			
		if(rpt_netsales_all_tglawalField.getValue()!==""){netsales_all_tglawal = rpt_netsales_all_tglawalField.getValue().format('Y-m-d');}
		if(rpt_netsales_all_tglakhirField.getValue()!==""){netsales_all_tglakhir = rpt_netsales_all_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_netsales_all_bulanField.getValue()!==""){netsales_all_bulan=rpt_netsales_all_bulanField.getValue(); }
		if(rpt_netsales_all_tahunField.getValue()!==""){netsales_all_tahun=rpt_netsales_all_tahunField.getValue(); }
		if(rpt_netsales_all_opsitglField.getValue()==true){
			netsales_all_periode='tanggal';
			netsales_all_periodeField.setValue(rpt_netsales_all_tglawalField.getValue().format('d-m-Y')+ ' s/d ' + rpt_netsales_all_tglakhirField.getValue().format('d-m-Y'));
		}else if(rpt_netsales_all_opsiblnField.getValue()==true){
			netsales_all_periode='bulan';
			if (rpt_netsales_all_bulanField.getValue() == '01') {
				nama_bulan='Januari'
			}else if(rpt_netsales_all_bulanField.getValue() == '02') {
				nama_bulan='Februari'
			}else if(rpt_netsales_all_bulanField.getValue() == '03') {
				nama_bulan='Maret'
			}else if(rpt_netsales_all_bulanField.getValue() == '04') {
				nama_bulan='April'
			}else if(rpt_netsales_all_bulanField.getValue() == '05') {
				nama_bulan='Mei'
			}else if(rpt_netsales_all_bulanField.getValue() == '06') {
				nama_bulan='Juni'
			}else if(rpt_netsales_all_bulanField.getValue() == '07') {
				nama_bulan='Juli'
			}else if(rpt_netsales_all_bulanField.getValue() == '08') {
				nama_bulan='Agustus'
			}else if(rpt_netsales_all_bulanField.getValue() == '09') {
				nama_bulan='September'
			}else if(rpt_netsales_all_bulanField.getValue() == '10') {
				nama_bulan='Oktober'
			}else if(rpt_netsales_all_bulanField.getValue() == '11') {
				nama_bulan='November'
			}else if(rpt_netsales_all_bulanField.getValue() == '12') {
				nama_bulan='Desember'
			}
			netsales_all_periodeField.setValue(nama_bulan + " " + rpt_netsales_all_tahunField.getValue());
		}
		if(cabang_thField.getValue() == true) {netsales_all_th = "'TH'";}
		if(cabang_kiField.getValue() == true) {netsales_all_ki = "'KI'";}
		if(cabang_hrField.getValue() == true) {netsales_all_hr = "'HR'";}
		if(cabang_tpField.getValue() == true) {netsales_all_tp = "'TP'";}
		if(cabang_dpsField.getValue() == true) {netsales_all_dps = "'DPS'";}
		if(cabang_mtaField.getValue() == true) {netsales_all_mta = "'MTA'";}
		if(cabang_mdnField.getValue() == true) {netsales_all_mdn = "'MDN'";}
		if(cabang_lbkField.getValue() == true) {netsales_all_lbk = "'LBK'";}
		if(cabang_mndField.getValue() == true) {netsales_all_mnd = "'MND'";}
		if(cabang_ygkField.getValue() == true) {netsales_all_ygk = "'YGK'";}
		if(cabang_blpnField.getValue() == true) {netsales_all_ygk = "'BLPN'";}
					
		netsales_allDataStore.baseParams = {
					task		: 'SEARCH',
					tgl_awal	: netsales_all_tglawal,
					tgl_akhir	: netsales_all_tglakhir,
					bulan		: netsales_all_bulan,
					tahun		: netsales_all_tahun,
					periode		: netsales_all_periode,
					cabang_th	: netsales_all_th,
					cabang_ki	: netsales_all_ki,
					cabang_hr	: netsales_all_hr,
					cabang_tp	: netsales_all_tp,
					cabang_dps	: netsales_all_dps,
					cabang_mta	: netsales_all_mta,
					cabang_mdn	: netsales_all_mdn,
					cabang_lbk	: netsales_all_lbk,
					cabang_mnd	: netsales_all_mnd,
					cabang_ygk	: netsales_all_ygk,
					cabang_blpn	: netsales_all_blpn
		};
				
		netsales_allTotalDataStore.baseParams = {
					task		: 'SEARCH2',
					tgl_awal	: netsales_all_tglawal,
					tgl_akhir	: netsales_all_tglakhir,
					bulan		: netsales_all_bulan,
					tahun		: netsales_all_tahun,
					periode		: netsales_all_periode,
					cabang_th	: netsales_all_th,
					cabang_ki	: netsales_all_ki,
					cabang_hr	: netsales_all_hr,
					cabang_tp	: netsales_all_tp,
					cabang_dps	: netsales_all_dps,
					cabang_mta	: netsales_all_mta,
					cabang_mdn	: netsales_all_mdn,
					cabang_lbk	: netsales_all_lbk,
					cabang_mnd	: netsales_all_mnd,
					cabang_ygk	: netsales_all_ygk,
					cabang_blpn	: netsales_all_blpn
		};
				
		
		Ext.MessageBox.show({
		   msg: 'Mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		netsales_allDataStore.reload({
			callback: function(opts, success, response){
				if(success){
					netsales_allTotalDataStore.reload();
					
					Ext.Ajax.request({
						waitMsg: 'Please Wait...',
						url: 'index.php?c=c_lap_netsales_all&m=get_action',
						params: {
							task: 'CHART',						
							tgl_awal	: netsales_all_tglawal,
							tgl_akhir	: netsales_all_tglakhir,
							bulan		: netsales_all_bulan,
							tahun		: netsales_all_tahun,
							periode		: netsales_all_periode,
							cabang_th	: netsales_all_th,
							cabang_ki	: netsales_all_ki,
							cabang_hr	: netsales_all_hr,
							cabang_tp	: netsales_all_tp,
							cabang_dps	: netsales_all_dps,
							cabang_mta	: netsales_all_mta,
							cabang_mdn	: netsales_all_mdn,
							cabang_lbk	: netsales_all_lbk,
							cabang_mnd	: netsales_all_mnd,
							cabang_ygk	: netsales_all_ygk,
							cabang_blpn	: netsales_all_blpn,
							method: 'POST'
							
						},
						success: function(result, request){
							var hasil=eval(result.responseText);
							switch(hasil){
							case 1:
								Ext.MessageBox.hide();
								
								laporannetsales_allChart.render();
								laporannetsales_allChart.update("<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_all_graph.php'></iframe>");
								

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
	
	rpt_netsales_allForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_netsales_all_periodeField, cabangGroup],
		monitorValid:true,
		buttons: 
		[{
			xtype:'spacer',
			width: 140
		},{
			text: 'Search',
			formBind: true,
			//tooltip: 'Menghitung Net Sales dari keseluruhan transaksi pada tanggal terpilih. Fungsi ini membutuhkan waktu cukup lama.',
			handler: lap_netsales_all_search
		},{
			text: 'Close',
			handler: function(){
				rpt_netsales_allWindow.hide();
				//mainPanel.remove(mainPanel.getActiveTab().getId());
			}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_netsales_allWindow = new Ext.Window({
		title: 'Laporan Net Sales',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_netsales_all',
		items: rpt_netsales_allForm
	});
  	rpt_netsales_allWindow.show();
	
	
	laporannetsales_allChart =	new Ext.form.FormPanel ({
							title: 'Grafik Laporan Net Sales Semua Cabang',
							resizeable: true,
							id: 'laporannetsales_allChart',
							el: 'div_chart_laporan_netsales_all',
					        width: 1200,
							height: 450,
							collapsible: true,
							layout: 'fit',
							//autoLoad: 'true',
							frame: true,
							html: "<iframe frameborder='0' width='100%' height='100%' src='<?=base_url();?>print/lap_netsales_all_graph.php'></iframe>",
							autoDestroy: true,
							});
	
	//EVENTS
	
	/*rpt_netsales_all_rekapField.on("check", function(){
		rpt_netsales_all_groupField.setValue('No faktur');
		if(rpt_netsales_all_rekapField.getValue()==true){
			rpt_netsales_all_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_netsales_all_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_netsales_all_detailField.on("check", function(){
		rpt_netsales_all_groupField.setValue('No Faktur');
		if(rpt_netsales_all_detailField.getValue()==true){
			rpt_netsales_all_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_netsales_all_groupField.bindStore(group_master_Store);
		}
	});*/
	
	/*rpt_netsales_all_opsitglField.on("check",function(){
		if(rpt_netsales_all_opsitglField.getValue()==true){
			rpt_netsales_all_tglawalField.allowBlank=false;
			rpt_netsales_all_tglakhirField.allowBlank=false;
		}else{
			rpt_netsales_all_tglawalField.allowBlank=true;
			rpt_netsales_all_tglakhirField.allowBlank=true;
		}
		
	});*/
	
});
	</script>
<body>
<div>
	<div class="col">
		<div id=""></div>
		<div id="div_chart_laporan_netsales_all"></div>
		<div id="fp_netsales_all_list"></div>
        <div id="fp_netsales_allTotal_list"></div>
        <div id="fp_netsales_all"></div>
		<div id="fp_netsales_detail"></div>
		<div id="elwindow_rpt_netsales_all"></div>
		
    </div>
</div>
</body>