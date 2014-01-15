<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	
	+ Description	: For record view
	+ Filename 		: v_lap_kunjungan.php
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
Ext.namespace('Ext.ux.plugin');

Ext.ux.plugin.triggerfieldTooltip = function(config){
    Ext.apply(this, config);
};

Ext.extend(Ext.ux.plugin.triggerfieldTooltip, Ext.util.Observable,{
    init: function(component){
        this.component = component;
        this.component.on('render', this.onRender, this);
    },
    
    //private
    onRender: function(){
        if(this.component.tooltip){
            if(typeof this.component.tooltip == 'object'){
                Ext.QuickTips.register(Ext.apply({
                      target: this.component.trigger
                }, this.component.tooltip));
            } else {
                this.component.trigger.dom[this.component.tooltipType] = this.component.tooltip;
            }
        }
    }
}); 

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
        /*
         * Always return true since we're only using this vtype to set the
         * min/max allowed values (these are tested for after the vtype test)
         */
        return true;
    }
});
/* declare function */		
var lap_kunjunganDataStore;
var lap_totalkunjungan_DataStore;
var lap_kunjunganColumnModel;
var lap_totalkunjungan_nonColumnModel;
var lap_averageColumnModel;
var lap_kunjunganListEditorGrid;
var lap_kunjunganListEditorGrid2;
var lap_kunjungan_averageListEditorGrid;
var lap_kunjungan_searchForm;
var lap_kunjungan_searchWindow;
var lap_kunjunganSelectedRow;
var lap_kunjunganContextMenu;
//for detail data
var lap_kunjungan_detail_DataStore;
var lap_kunjungan_detail_proxy;
var lap_kunjungan_detail_writer;

var today=new Date().format('d-m-Y');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS=31;

/* declare variable here for Field*/
var lap_kunjungan_idSearchField;

<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
$bulan="";

?>

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

	function is_lap_kunjungan_searchForm_valid(){
		return (lap_kunjungan_tglStartSearchField.isValid()) && (lap_kunjungan_tglEndSearchField.isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	lap_kunjunganDataStore = new Ext.data.Store({
		id: 'lap_kunjunganDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
			{name: 'tgl_tindakan', type: 'date', dateFormat: 'Y-m-d', mapping: 'tgl_tindakan'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			//{name: 'dtrawat_edit', type: 'string', mapping: 'Jumlah_rawat'},
			{name: 'jum_total', type: 'int', mapping: 'sum(jum_total)'},
			{name: 'jum_cust_medis', type: 'int', mapping: 'sum(jum_cust_medis)'},
			{name: 'jum_cust_surgery', type: 'int', mapping: 'sum(jum_cust_surgery)'},
			{name: 'jum_cust_antiaging', type: 'int', mapping: 'sum(jum_cust_antiaging)'},
			{name: 'jum_cust_nonmedis', type: 'int', mapping: 'sum(jum_cust_nonmedis)'},
			{name: 'jum_cust_produk', type: 'int', mapping: 'sum(jum_cust_produk)'},
			{name: 'jum_cust_kelamin', type: 'int', mapping: 'sum(jum_cust_kelamin)'}
		])
		//sortInfo:{field: 'tgl_tindakan', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for summary kredit data store */ 
	lap_totalkunjungan_DataStore = new Ext.data.Store({
		id: 'lap_totalkunjungan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jum_total', type: 'int', mapping: 'sum(jum_total)'},
			{name: 'jum_cust_medis', type: 'int', mapping: 'sum(jum_cust_medis)'},
			{name: 'jum_cust_surgery', type: 'int', mapping: 'sum(jum_cust_surgery)'},
			{name: 'jum_cust_antiaging', type: 'int', mapping: 'sum(jum_cust_antiaging)'},
			{name: 'jum_cust_nonmedis', type: 'int', mapping: 'sum(jum_cust_nonmedis)'},
			{name: 'jum_cust_produk', type: 'int', mapping: 'sum(jum_cust_produk)'}
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for average  data store */ 
	lap_average_kunjungan_DataStore = new Ext.data.Store({
		id: 'lap_average_kunjungan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST3",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'avg_jum_total', type: 'float', mapping: 'avg_jum_total'},
			{name: 'avg_jum_cust_medis', type: 'float', mapping: 'avg_jum_cust_medis'},
			{name: 'avg_jum_cust_surgery', type: 'float', mapping: 'avg_jum_cust_surgery'},
			{name: 'avg_jum_cust_antiaging', type: 'float', mapping: 'avg_jum_cust_antiaging'},
			{name: 'avg_jum_cust_nonmedis', type: 'float', mapping: 'avg_jum_cust_nonmedis'},
			{name: 'avg_jum_cust_produk', type: 'float', mapping: 'avg_jum_cust_produk'}
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	

  	/* Function for Identify of Window Column Model */
	lap_kunjunganColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'tgl_tindakan',
			width: 100,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			sortable: true
		}, 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'jum_cust_medis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'jum_cust_surgery',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'jum_cust_antiaging',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'jum_cust_nonmedis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'jum_cust_produk',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Total' + '</div>',
			tooltip: 'Jumlah ini TIDAK SELALU sama dengan Medis+nonMedis+Produk',
			dataIndex: 'jum_total',
			width: 80,	//55,
			sortable: true
		}
	]);
	
	lap_kunjunganColumnModel.defaultSortable= true;
	/* End of Function */
	 
	lap_totalkunjungan_nonColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: '',
			//hidden : true,
			disabled : false,
			width: 100,	//55,
			//sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'jum_cust_medis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'jum_cust_surgery',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'jum_cust_antiaging',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'jum_cust_nonmedis',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'jum_cust_produk',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Grand Total' + '</div>',
			dataIndex: 'jum_total',
			width: 80,	//55,
			sortable: true
		},
		]);
	
	lap_totalkunjungan_nonColumnModel.defaultSortable= true;
	
	
	lap_averageColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Average</span>' + '</div>',
			dataIndex: '',
			//hidden : true,
			disabled : false,
			width: 100,	//55,
			//sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'avg_jum_cust_medis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'avg_jum_cust_surgery',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'avg_jum_cust_antiaging',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'avg_jum_cust_nonmedis',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'avg_jum_cust_produk',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Average' + '</div>',
			dataIndex: 'avg_jum_total',
			width: 80,	//55,
			sortable: true
		},
		]);
	
	lap_averageColumnModel.defaultSortable= true;
	
	
	
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	lap_kunjunganListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjunganListEditorGrid',
		el: 'fp_lap_kunjungan',
		title: 'Laporan Jumlah Kunjungan',
		autoHeight: true,
		store: lap_kunjunganDataStore, // DataStore
		cm: lap_kunjunganColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			//pageSize: pageS,
			disabled:true,
			store: lap_kunjunganDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled : false,
			handler: lap_kunjungan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled : false,
			handler: lap_kunjungan_print  
		}
		]
	});
	lap_kunjunganListEditorGrid.render();
	/* End of DataStore */
	
	/*ColumnModel utk daftar customer */ 
	detail_customer_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Cust ID' + '</div>',
			dataIndex: 'cust_id',
			hidden : true,
			width: 10
		},
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 4
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Client Card' + '</div>',
			dataIndex: 'cust_no',
			width: 10
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Customer' + '</div>',
			dataIndex: 'cust_nama',
			width: 30
		}
		]
    );
    detail_customer_ColumnModel.defaultSortable= true;
	
		
	/* START Daftar customer */
	detail_customerStore = new Ext.data.GroupingStore({
		id: 'detail_customerStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan&m=get_daftar_customer', 
			method: 'POST'
		}),
		baseParams:{task: "GET",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'app_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'}
		])
		//, sortInfo:{field: 'no_urut', direction: "ASC"}
	});

	
	lap_kunjunganListEditorGrid.on('rowclick', function (lap_kunjunganListEditorGrid, rowIndex, eventObj) {
		var lap_kunjungan_id_detail=null;
		var lap_kunjungan_tgl_start_detail=null;
		var lap_kunjungan_tgl_end_detail=null;
		var lap_kunjungan_kelamin_detail=null;
		var lap_kunjungan_member_detail=null;
		var lap_kunjungan_cust_detail=null;
		var lap_kunjungan_umurstart_detail=null;
		var lap_kunjungan_umurend_detail=null;
		var lap_kunjungan_tgllahir_detail_date="";
		var lap_kunjungan_tgllahir_detail_dateEnd="";
		var lap_kunjungan_tmedis_bulan=null;
		var lap_kunjungan_tmedis_tahun=null;
		var lap_kunjungan_tmedis_periode=null;
		//var lap_kunjungan_dokter_detail=null;

		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_detail=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_detail=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_detail=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_detail=lap_kunjungan_kelaminSearchField.getValue();}
		if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_detail=lap_kunjungan_tglStartSearchField.getValue();}
		if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_detail=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_detail=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_detail=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_detail_date=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_detail_dateEnd=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		if(lap_kunjungan_bulanField.getValue()!==null){lap_kunjungan_tmedis_bulan=lap_kunjungan_bulanField.getValue();}
		if(lap_kunjungan_tahunField.getValue()!==null){lap_kunjungan_tmedis_tahun=lap_kunjungan_tahunField.getValue();}
	
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tmedis_periode='tanggal';
		}else if(lap_kunjungan_opsiblnField.getValue()==true){
			lap_kunjungan_tmedis_periode='bulan';
		}else{
			lap_kunjungan_tmedis_periode='all';
		}
	
        var recordMaster = lap_kunjunganListEditorGrid.getSelectionModel().getSelected();
		var today=new Date().format('Y-m-d');
		detail_customerStore.reload({params : {
			tgl_tindakan : recordMaster.get("tgl_tindakan").format('Y-m-d'),
			lap_kunjungan_id	:	lap_kunjungan_id_detail, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_detail,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_detail,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_detail,
			lap_kunjungan_member : lap_kunjungan_member_detail,
			lap_kunjungan_cust : lap_kunjungan_cust_detail,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_detail,
			lap_kunjungan_umurend : lap_kunjungan_umurend_detail,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_detail_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_detail_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode	
			
			}});
    });

	/*Grid Panel utk daftar customer */
	var daftar_pengunjung_Panel = new Ext.grid.GridPanel({
		id: 'daftar_pengunjung_Panel',
		title: 'Detail Pengunjung',
		el: 'fp_lap_kunjungan_detail',
        store: detail_customerStore,
        cm: detail_customer_ColumnModel,
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
        stripeRows: true,
        autoExpandColumn: 'company',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 600,//940	//800
		tbar: [
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			//disabled: true,
			handler: detail_kunjungan_print 
		}
		]
		/*bbar: new Ext.PagingToolbar({
			//pageSize: 5,
			disabled:true,
			store: detail_customerStore,
			displayInfo: true
		})*/
    });
    daftar_pengunjung_Panel.render();
	
	lap_kunjunganListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjunganListEditorGrid2',
		el: 'fp_lap_kunjungan2',
		title: '',
		autoHeight: true,
		store: lap_totalkunjungan_DataStore, // DataStore
		cm: lap_totalkunjungan_nonColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600,
	
		/* Add Control on ToolBar */
	
	});
	lap_kunjunganListEditorGrid2.render();
	
	lap_kunjungan_averageListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjungan_averageListEditorGrid',
		el: 'fp_lap_kunjungan_average',
		title: '',
		autoHeight: true,
		store: lap_average_kunjungan_DataStore, // DataStore
		cm: lap_averageColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600, 

	});
	lap_kunjungan_averageListEditorGrid.render();
	
	
	/* Create Context Menu */
	lap_kunjunganContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_kunjungan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_kunjungan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_kunjungan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_kunjunganContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_kunjunganSelectedRow=rowIndex;
		lap_kunjunganContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	lap_kunjunganListEditorGrid.addListener('rowcontextmenu', onlap_kunjungan_ListEditGridContextMenu);
	lap_kunjunganDataStore.load({params: {start: 0, limit: 31}});
	lap_totalkunjungan_DataStore.load({params: {start: 0, limit: 31}});	// load DataStore
	lap_average_kunjungan_DataStore.load({params: {start: 0, limit: 31}});	// load DataStore
//	detail_customerStore.load({params: {start: 0, limit: 31}});
	//lap_kunjunganListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	/*Detail Declaration */	
	/* Function for Retrieve DataStore of detail*/
	lap_kunjungan_detail_DataStore = new Ext.data.Store({
		id: 'lap_kunjungan_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		//reader: lap_kunjungan_detail_reader,
		//baseParams:{master_id: lap_kunjungan_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */

	/* Function for action list search */
	function lap_kunjungan_search(){
		// render according to a SQL date format.
		//lap_kunjungan_searchWindow.hide();
		if(is_lap_kunjungan_searchForm_valid())
		{
		var lap_kunjungan_id_search=null;
		var lap_kunjungan_tgl_start_search=null;
		var lap_kunjungan_tgl_end_search=null;
		var lap_kunjungan_kelamin_search=null;
		var lap_kunjungan_member_search=null;
		var lap_kunjungan_cust_search=null;
		var lap_kunjungan_umurstart_search=null;
		var lap_kunjungan_umurend_search=null;
		var lap_kunjungan_tgllahir_search_date="";
		var lap_kunjungan_tgllahir_search_dateEnd="";
		var lap_kunjungan_tmedis_bulan=null;
		var lap_kunjungan_tmedis_tahun=null;
		var lap_kunjungan_tmedis_periode=null;
		//var lap_kunjungan_dokter_search=null;

		
		
		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_search=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_search=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_search=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_search=lap_kunjungan_kelaminSearchField.getValue();}
		//if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_search=lap_kunjungan_tglStartSearchField.getValue();}
		//if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_search=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_search=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_search=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_search_date=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_search_dateEnd=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		if(lap_kunjungan_bulanField.getValue()!==null){lap_kunjungan_tmedis_bulan=lap_kunjungan_bulanField.getValue();}
		if(lap_kunjungan_tahunField.getValue()!==null){lap_kunjungan_tmedis_tahun=lap_kunjungan_tahunField.getValue();}
		if(Ext.getCmp('lap_kunjungan_tglStartSearchField').getValue()!==null){lap_kunjungan_tgl_start_search=Ext.getCmp('lap_kunjungan_tglStartSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('lap_kunjungan_tglEndSearchField').getValue()!==null){lap_kunjungan_tgl_end_search=Ext.getCmp('lap_kunjungan_tglEndSearchField').getValue().format('Y-m-d');}

		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tmedis_periode='tanggal';
		}else if(lap_kunjungan_opsiblnField.getValue()==true){
			lap_kunjungan_tmedis_periode='bulan';
		}else{
			lap_kunjungan_tmedis_periode='all';
		}
		
		/*untuk detail pengunjung*/
		var lap_kunjungan_id_detail=null;
		var lap_kunjungan_tgl_start_detail=null;
		var lap_kunjungan_tgl_end_detail=null;
		var lap_kunjungan_kelamin_detail=null;
		var lap_kunjungan_member_detail=null;
		var lap_kunjungan_cust_detail=null;
		var lap_kunjungan_umurstart_detail=null;
		var lap_kunjungan_umurend_detail=null;
		var lap_kunjungan_tgllahir_detail_date="";
		var lap_kunjungan_tgllahir_detail_dateEnd="";
		
		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_detail=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_detail=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_detail=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_detail=lap_kunjungan_kelaminSearchField.getValue();}
		if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_detail=lap_kunjungan_tglStartSearchField.getValue();}
		if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_detail=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_detail=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_detail=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_detail_date=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_detail_dateEnd=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		/*end*/

		// change the store parameters
		lap_kunjunganDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_search,
			lap_kunjungan_member : lap_kunjungan_member_search,
			lap_kunjungan_cust : lap_kunjungan_cust_search,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_search,
			lap_kunjungan_umurend : lap_kunjungan_umurend_search,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_search_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_search_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode			
			//trawat_dokter	:	lap_kunjungan_dokter_search,
		};
		lap_totalkunjungan_DataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_search,
			lap_kunjungan_member : lap_kunjungan_member_search,
			lap_kunjungan_cust : lap_kunjungan_cust_search,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_search,
			lap_kunjungan_umurend : lap_kunjungan_umurend_search,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_search_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_search_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode			
			//trawat_dokter	:	lap_kunjungan_dokter_search,
		};
		lap_average_kunjungan_DataStore.baseParams = {
			task: 'SEARCH3',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_search,
			lap_kunjungan_member : lap_kunjungan_member_search,
			lap_kunjungan_cust : lap_kunjungan_cust_search,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_search,
			lap_kunjungan_umurend : lap_kunjungan_umurend_search,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_search_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_search_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode			
			//trawat_dokter	:	lap_kunjungan_dokter_search,
		};
		var today=new Date().format('Y-m-d');
		var recordMaster = lap_kunjunganListEditorGrid.getSelectionModel().getSelected();
		detail_customerStore.reload({params : {
			tgl_tindakan : today,
			lap_kunjungan_id	:	lap_kunjungan_id_detail, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_detail,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_detail,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_detail,
			lap_kunjungan_member : lap_kunjungan_member_detail,
			lap_kunjungan_cust : lap_kunjungan_cust_detail,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_detail,
			lap_kunjungan_umurend : lap_kunjungan_umurend_detail,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_detail_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_detail_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode			
			
			}});
		
		// Cause the datastore to do another query : 
		lap_kunjunganDataStore.reload({params: {start: 0, limit: 31}});
		lap_totalkunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		lap_average_kunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		detail_customerStore.load({params: {start: 0, limit: 0}});
		
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Field for search */
	/* Identify  lap_kunjungan_id Search Field */
	lap_kunjungan_idSearchField= new Ext.form.NumberField({
		id: 'lap_kunjungan_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	var dt = new Date(); 
	
	/* Identify  lap_kunjungan_kelamin Field */
	lap_kunjungan_kelaminSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_kelaminSearchField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_kelamin_value', 'lap_kunjungan_kelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan'],['S','Semua']]
		}),
		mode: 'local',
		blankText:'Semua',
		displayField: 'lap_kunjungan_kelamin_display',
		valueField: 'lap_kunjungan_kelamin_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	
	/* Identify  lap_kunjungan_member Field */
	lap_kunjungan_memberSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_memberSearchField',
		fieldLabel: 'Member',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_member_value', 'lap_kunjungan_member_display'],
			data: [['Lama','Lama'],['Baru','Baru'],['Non Member','Non Member'],['Semua','Semua']]
		}),
		mode: 'local',
		displayField: 'lap_kunjungan_member_display',
		valueField: 'lap_kunjungan_member_value',
		anchor: '95%',
		triggerAction: 'all'
	});

	lap_kunjungan_tgllahirSearchField= new Ext.form.DateField({
		id: 'lap_kunjungan_tgllahirSearchField',
		fieldLabel : 'Antara Tanggal',
		format: 'd-m-Y'
	});
	
	lap_kunjungan_tgllahirSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'lap_kunjungan_tgllahirSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	lap_kunjungan_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'lap_kunjungan_tanggal_opsiSearchField',
		title: 'Tanggal Lahir',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		items:[{

					   		layout: 'form',
							border: false,
							bodyStyle:'padding:3px',
							items:[lap_kunjungan_tgllahirSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_kunjungan_tgllahirSearchFieldEnd]

			}]
	});
	
	/* Identify  umur Field */
	lap_kunjungan_umurstartSearchField= new Ext.form.TextField({
		id: 'lap_kunjungan_umurstartSearchField',
		fieldLabel: 'Umur',
		maxLength: 10,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  batas umur Field */
	lap_kunjungan_umurendSearchField= new Ext.form.TextField({
		id: 'lap_kunjungan_umurendSearchField',
		//fieldLabel: 'Telp. Rumah 2',
		hideLabel:true,
		maxLength: 10,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	lap_kunjungan_label_umurSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	lap_kunjungan_label_thncustSearchField=new Ext.form.Label({ html: ' &nbsp; tahun'});
	lap_kunjungan_umur_groupSearch = new Ext.form.FieldSet({
		title: 'Umur',
		labelWidth: 100,
		anchor: '95%',
		layout:'column',
		items: [lap_kunjungan_umurstartSearchField, lap_kunjungan_label_umurSearchField, lap_kunjungan_umurendSearchField,lap_kunjungan_label_thncustSearchField]

	});
	
	/* Identify  lap_kunjungan_cust Field */
	lap_kunjungan_custSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_custSearchField',
		fieldLabel: 'Customer',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_cust_value', 'lap_kunjungan_cust_display'],
			data: [['Lama','Lama'],['Baru','Baru'],['Semua','Semua']]
		}),
		mode: 'local',
		displayField: 'lap_kunjungan_cust_display',
		valueField: 'lap_kunjungan_cust_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	
		/////tgl n bulan
	lap_kunjungan_opsitglField=new Ext.form.Radio({
		id:'lap_kunjungan_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	lap_kunjungan_opsiblnField=new Ext.form.Radio({
		id:'lap_kunjungan_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	lap_kunjungan_tglStartSearchField= new Ext.form.DateField({
		id: 'lap_kunjungan_tglStartSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'lap_kunjungan_tglStartSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'lap_kunjungan_tglakhirField'
		value: today
	});
	
	lap_kunjungan_tglEndSearchField= new Ext.form.DateField({
		id: 'lap_kunjungan_tglEndSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'lap_kunjungan_tglEndSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'lap_kunjungan_tglawalField',
		value: today
	});
	
	lap_kunjungan_bulanField=new Ext.form.ComboBox({
		id:'lap_kunjungan_bulanField',
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
	
	lap_kunjungan_tahunField=new Ext.form.ComboBox({
		id:'lap_kunjungan_tahunField',
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
	
	var lap_kunjungan_periodeField=new Ext.form.FieldSet({
		id:'lap_kunjungan_periodeField',
		title : 'Periode Transaksi',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[lap_kunjungan_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[lap_kunjungan_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_kunjungan_tglStartSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_kunjungan_tglEndSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[lap_kunjungan_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_kunjungan_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_kunjungan_tahunField]
					   }]
			}]
	});
	//// end of tgl n bulan
	
	////	
	/*lap_kunjungan_tglStartSearchField= new Ext.form.DateField({
		id: 'lap_kunjungan_tglStartSearchField',
		fieldLabel : 'Antara Tanggal',
		format: 'd-m-Y'
	});
	
	lap_kunjungan_tglEndSearchField= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'lap_kunjungan_tglEndSearchField',
		format: 'd-m-Y'
	});
	
	lap_kunjungan_tanggal_antaraSearchField=new Ext.form.FieldSet({
		id:'lap_kunjungan_tanggal_antaraSearchField',
		title: 'Tanggal Kunjungan',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		items:[{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							//labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_kunjungan_tglStartSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_kunjungan_tglEndSearchField]
					   }]
			}]
	});*/
	//////
	
	/* Function for retrieve search Form Panel */
	lap_kunjungan_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:1,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [lap_kunjungan_periodeField,lap_kunjungan_kelaminSearchField,lap_kunjungan_memberSearchField,lap_kunjungan_custSearchField, lap_kunjungan_tanggal_opsiSearchField,lap_kunjungan_umur_groupSearch] 
						}]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: lap_kunjungan_search
			},{
				text: 'Close',
				handler: function(){
					lap_kunjungan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function lap_kunjungan_reset_formSearch(){
		lap_kunjungan_idSearchField.reset();
		lap_kunjungan_kelaminSearchField.reset();
		lap_kunjungan_kelaminSearchField.setValue('S');
		lap_kunjungan_memberSearchField.reset();
		lap_kunjungan_memberSearchField.setValue('Semua');
		lap_kunjungan_custSearchField.reset();
		lap_kunjungan_custSearchField.setValue('Semua');
		lap_kunjungan_idSearchField.setValue(null);
		lap_kunjungan_tglStartSearchField.reset();
		lap_kunjungan_tglStartSearchField.setValue(today);
		lap_kunjungan_tglEndSearchField.reset();
		lap_kunjungan_tglEndSearchField.setValue(today);
		lap_kunjungan_umurstartSearchField.reset();
		lap_kunjungan_umurendSearchField.reset();
		lap_kunjungan_tgllahirSearchField.reset();
		lap_kunjungan_tgllahirSearchFieldEnd.reset();
		Ext.getCmp('lap_kunjungan_tglStartSearchField').reset();
		Ext.getCmp('lap_kunjungan_tglStartSearchField').setValue(today);
		Ext.getCmp('lap_kunjungan_tglEndSearchField').reset();
		Ext.getCmp('lap_kunjungan_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_kunjungan_searchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Kunjungan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_kunjungan_search',
		items: lap_kunjungan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_kunjungan_searchWindow.isVisible()){
			lap_kunjungan_reset_formSearch();
			lap_kunjungan_searchWindow.show();
		} else {
			lap_kunjungan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function is_valid_form(){
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tglStartSearchField.allowBlank=false;
			lap_kunjungan_tglEndSearchField.allowBlank=false;
			if(lap_kunjungan_tglStartSearchField.isValid() && lap_kunjungan_tglEndSearchField.isValid())
				return true;
			else
				return false;
		}else{
			lap_kunjungan_tglStartSearchField.allowBlank=true;
			lap_kunjungan_tglEndSearchField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function lap_kunjungan_print(){
		var searchquery = "";	
		var lap_kunjungan_id_print=null;
		var lap_kunjungan_tgl_start_print=null;
		var lap_kunjungan_tgl_end_print=null;
		var lap_kunjungan_kelamin_print=null;
		var lap_kunjungan_member_print=null;
		var lap_kunjungan_cust_print=null;
		var lap_kunjungan_umurstart_print=null;
		var lap_kunjungan_umurend_print=null;
		var lap_kunjungan_tgllahir_date_print="";
		var lap_kunjungan_tgllahir_dateEnd_print="";
		var lap_kunjungan_tmedis_bulan=null;
		var lap_kunjungan_tmedis_tahun=null;
		var lap_kunjungan_tmedis_periode=null;
		
		var win;              
		// check if we do have some search data...
		if(lap_kunjunganDataStore.baseParams.query!==null){searchquery = lap_kunjunganDataStore.baseParams.query;}
		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_print=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_print=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_print=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_print=lap_kunjungan_kelaminSearchField.getValue();}
		if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_print=lap_kunjungan_tglStartSearchField.getValue();}
		if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_print=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_print=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_print=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_date_print=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_dateEnd_excel=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		if(lap_kunjungan_bulanField.getValue()!==null){lap_kunjungan_tmedis_bulan=lap_kunjungan_bulanField.getValue();}
		if(lap_kunjungan_tahunField.getValue()!==null){lap_kunjungan_tmedis_tahun=lap_kunjungan_tahunField.getValue();}
	
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tmedis_periode='tanggal';
		}else if(lap_kunjungan_opsiblnField.getValue()==true){
			lap_kunjungan_tmedis_periode='bulan';
		}else{
			lap_kunjungan_tmedis_periode='all';
		}

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_kunjungan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			start:0,
			limit:31,
			lap_kunjungan_id	:	lap_kunjungan_id_print, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_print,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_print,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_print,
			lap_kunjungan_member : lap_kunjungan_member_print,
			lap_kunjungan_cust : lap_kunjungan_cust_print,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_print,
			lap_kunjungan_umurend : lap_kunjungan_umurend_print,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_date_print, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_dateEnd_print,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode,	
		  	currentlisting: lap_kunjunganDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				Ext.MessageBox.hide();
				win = window.open('./kunjunganlist.html','kunjunganlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function detail_kunjungan_print(){
		var printquery = "";
		/*var cust_id_2print=null;
		var cust_no_2print=null;
		var cust_nama_2print=null;*/
		var lap_kunjungan_id_detail=null;
		var lap_kunjungan_tgl_start_detail=null;
		var lap_kunjungan_tgl_end_detail=null;
		var lap_kunjungan_kelamin_detail=null;
		var lap_kunjungan_member_detail=null;
		var lap_kunjungan_cust_detail=null;
		var lap_kunjungan_umurstart_detail=null;
		var lap_kunjungan_umurend_detail=null;
		var lap_kunjungan_tgllahir_detail_date="";
		var lap_kunjungan_tgllahir_detail_dateEnd="";
		var lap_kunjungan_tmedis_bulan=null;
		var lap_kunjungan_tmedis_tahun=null;
		var lap_kunjungan_tmedis_periode=null;

		var win2;  
		post2db='PRINT2';   		


		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_detail=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_detail=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_detail=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_detail=lap_kunjungan_kelaminSearchField.getValue();}
		if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_detail=lap_kunjungan_tglStartSearchField.getValue();}
		if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_detail=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_detail=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_detail=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_detail_date=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_detail_dateEnd=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		if(lap_kunjungan_bulanField.getValue()!==null){lap_kunjungan_tmedis_bulan=lap_kunjungan_bulanField.getValue();}
		if(lap_kunjungan_tahunField.getValue()!==null){lap_kunjungan_tmedis_tahun=lap_kunjungan_tahunField.getValue();}
	
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tmedis_periode='tanggal';
		}else if(lap_kunjungan_opsiblnField.getValue()==true){
			lap_kunjungan_tmedis_periode='bulan';
		}else{
			lap_kunjungan_tmedis_periode='all';
		}
	
        var recordMaster = lap_kunjunganListEditorGrid.getSelectionModel().getSelected();
		var today=new Date().format('Y-m-d');

		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_lap_kunjungan&m=get_action',
		params: {
			task: "PRINT2",
		  	query: printquery, 
			//dapaket_dpaket	: 	eval(get_pk_id()),			
			/*cust_id		:	cust_id_2print, 
			cust_no		:	cust_no_2print, 
			cust_nama	:	cust_nama_2print, */
			tgl_tindakan : recordMaster.get("tgl_tindakan").format('Y-m-d'),
			lap_kunjungan_id	:	lap_kunjungan_id_detail, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_detail,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_detail,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_detail,
			lap_kunjungan_member : lap_kunjungan_member_detail,
			lap_kunjungan_cust : lap_kunjungan_cust_detail,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_detail,
			lap_kunjungan_umurend : lap_kunjungan_umurend_detail,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_detail_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_detail_dateEnd,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode,	
		  	currentlisting: detail_customerStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win2 = window.open('./print/detail_kunjungan_list.html','detail_kunjungan_list','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
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
	function lap_kunjungan_export_excel(){
		var searchquery = "";
		var lap_kunjungan_id_excel=null;
		var lap_kunjungan_tgl_start_excel=null;
		var lap_kunjungan_tgl_end_excel=null;
		var lap_kunjungan_kelamin_excel=null;
		var lap_kunjungan_member_excel=null;
		var lap_kunjungan_cust_excel=null;
		var lap_kunjungan_umurstart_excel=null;
		var lap_kunjungan_umurend_excel=null;
		var lap_kunjungan_tgllahir_date_excel="";
		var lap_kunjungan_tgllahir_dateEnd_excel="";
		var lap_kunjungan_tmedis_bulan=null;
		var lap_kunjungan_tmedis_tahun=null;
		var lap_kunjungan_tmedis_periode=null;
		
		var win;              
		// check if we do have some search data...
	
		if(lap_kunjungan_memberSearchField.getValue()!==null){lap_kunjungan_member_excel=lap_kunjungan_memberSearchField.getValue();}
		if(lap_kunjungan_custSearchField.getValue()!==null){lap_kunjungan_cust_excel=lap_kunjungan_custSearchField.getValue();}
		if(lap_kunjungan_idSearchField.getValue()!==null){lap_kunjungan_id_excel=lap_kunjungan_idSearchField.getValue();}
		if(lap_kunjungan_kelaminSearchField.getValue()!==null){lap_kunjungan_kelamin_excel=lap_kunjungan_kelaminSearchField.getValue();}
		if(lap_kunjungan_tglStartSearchField.getValue()!==null){lap_kunjungan_tgl_start_excel=lap_kunjungan_tglStartSearchField.getValue();}
		if(lap_kunjungan_tglEndSearchField.getValue()!==null){lap_kunjungan_tgl_end_excel=lap_kunjungan_tglEndSearchField.getValue();}
		if(lap_kunjungan_umurstartSearchField.getValue()!==null){lap_kunjungan_umurstart_excel=lap_kunjungan_umurstartSearchField.getValue();}
		if(lap_kunjungan_umurendSearchField.getValue()!==null){lap_kunjungan_umurend_excel=lap_kunjungan_umurendSearchField.getValue();}	
		if(lap_kunjungan_tgllahirSearchField.getValue()!==""){lap_kunjungan_tgllahir_date_excel=lap_kunjungan_tgllahirSearchField.getValue().format('Y-m-d');}
		if(lap_kunjungan_tgllahirSearchFieldEnd.getValue()!==""){lap_kunjungan_tgllahir_dateEnd_excel=lap_kunjungan_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		if(lap_kunjungan_bulanField.getValue()!==null){lap_kunjungan_tmedis_bulan=lap_kunjungan_bulanField.getValue();}
		if(lap_kunjungan_tahunField.getValue()!==null){lap_kunjungan_tmedis_tahun=lap_kunjungan_tahunField.getValue();}
	
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tmedis_periode='tanggal';
		}else if(lap_kunjungan_opsiblnField.getValue()==true){
			lap_kunjungan_tmedis_periode='bulan';
		}else{
			lap_kunjungan_tmedis_periode='all';
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_kunjungan&m=get_action',
		params: {
			task: "EXCEL",
			start:0,
			limit:31,
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			lap_kunjungan_id	:	lap_kunjungan_id_excel, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_excel,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_excel,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_excel,
			lap_kunjungan_member : lap_kunjungan_member_excel,
			lap_kunjungan_cust : lap_kunjungan_cust_excel,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_excel,
			lap_kunjungan_umurend : lap_kunjungan_umurend_excel,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_date_excel, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_dateEnd_excel,
			bulan		: lap_kunjungan_tmedis_bulan,
			tahun		: lap_kunjungan_tmedis_tahun,
			periode		: lap_kunjungan_tmedis_periode,	
		  	currentlisting: lap_kunjunganDataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./export2excel.php');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa meng-export data ke dalam format excel!',
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
	/*End of Function */
	
	lap_kunjungan_opsitglField.on("check",function(){
		if(lap_kunjungan_opsitglField.getValue()==true){
			lap_kunjungan_tglStartSearchField.allowBlank=false;
			lap_kunjungan_tglEndSearchField.allowBlank=false;
		}else{
			lap_kunjungan_tglStartSearchField.allowBlank=true;
			lap_kunjungan_tglEndSearchField.allowBlank=true;
		}
		
	});
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lap_kunjungan"></div>
		 <div id="fp_lap_kunjungan2"></div>
		 <div id="fp_lap_kunjungan_average"></div>
         <div id="fp_lap_kunjungan_detail"></div>
		 <div id="fp_dlap_kunjungan"></div>
		<div id="elwindow_lap_kunjungan_create"></div>
        <div id="elwindow_lap_kunjungan_search"></div>
    </div>
</div>
</body>