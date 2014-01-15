<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	
	+ Description	: For record view
	+ Filename 		: v_lap_waktu_tunggu.php
 	+ Author  		: Natalie

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
var lap_waktu_tungguDataStore;
var lap_waktu_tunggu_average_DataStore;
var lap_waktu_tungguColumnModel;
var lap_waktu_tungguListEditorGrid;
var lap_waktu_tungguListEditorGrid2;
var lap_waktu_tunggu_averageListEditorGrid;
var lap_waktu_tunggu_searchForm;
var lap_waktu_tunggu_searchWindow;
var lap_waktu_tungguSelectedRow;
var lap_waktu_tungguContextMenu;
//for detail data
var lap_waktu_tunggu_detail_DataStore;
var lap_waktu_tunggu_detail_proxy;
var lap_waktu_tunggu_detail_writer;

var today=new Date().format('d-m-Y');
var firstday=(new Date().format('Y-m'))+'-01';
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS=31;

/* declare variable here for Field*/
var lap_waktu_tunggu_idSearchField;

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

	function is_lap_waktu_tunggu_searchForm_valid(){
		return (lap_waktu_tunggu_tglStartSearchField.isValid()) && (lap_waktu_tunggu_tglEndSearchField.isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	lap_waktu_tungguDataStore = new Ext.data.Store({
		id: 'lap_waktu_tungguDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_waktu_tunggu&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_waktu_tungguColumnModel, Mapping => for initiate table column */ 
			{name: 'tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'tgl'},
			{name: 'jum_cust_kurg', type: 'int', mapping: 'jum_cust_kurg'},
			{name: 'jum_cust_lbh', type: 'int', mapping: 'jum_cust_lbh'},
			{name: 'wkt_tunggu_kurg', type: 'string', mapping: 'wkt_tunggu_kurg'},
			{name: 'wkt_tunggu_lbh', type: 'string', mapping: 'wkt_tunggu_lbh'},
			{name: 'rata_total_wkt_tunggu', type: 'string', mapping: 'rata_total_wkt_tunggu'},
			{name: 'tot_cust', type: 'int', mapping: 'tot_cust'},
		])//,
		//sortInfo:{field: 'tgl', direction: "DESC"}
	});
	/* End of Function */
	
  	/* Function for Identify of Window Column Model */
	lap_waktu_tungguColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 4
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'tgl',
			width: 10,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			sortable: true
		}, 
		{	
			align : 'center',
			header: '<div align="center">' + 'Jml Cust <=' + '</div>',
			dataIndex: 'jum_cust_kurg',
			width: 5,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Rata-rata Waktu <=' + '</div>',
			dataIndex: 'wkt_tunggu_kurg',
			width: 10,	//55,
			sortable: true
		},
		{
			align : 'center',
			header: '<div align="center">' + 'Jml Cust >' + '</div>',
			dataIndex: 'jum_cust_lbh',
			width: 5,
			sortable: true
		}, 
		{	
			align : 'center',
			header: '<div align="center">' + 'Rata-rata Waktu >' + '</div>',
			dataIndex: 'wkt_tunggu_lbh',
			width: 10,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Tot Cust' + '</div>',
			dataIndex: 'tot_cust',
			width: 5,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Rata-rata Waktu Tot' + '</div>',
			dataIndex: 'rata_total_wkt_tunggu',
			width: 10,	//55,
			sortable: true
		}
	]);
	
	lap_waktu_tungguColumnModel.defaultSortable= true;
	/* End of Function */
	
		/* Declare DataStore and  show datagrid list */
	lap_waktu_tungguListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_waktu_tungguListEditorGrid',
		el: 'fp_lap_waktu_tunggu',
		title: 'Laporan Waktu Tunggu',
		autoHeight: true,
		store: lap_waktu_tungguDataStore, // DataStore
		cm: lap_waktu_tungguColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			//pageSize: pageS,
			disabled:true,
			store: lap_waktu_tungguDataStore,
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
			disabled : true,
			handler: lap_lunjungan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			//disabled : true,
			handler: lap_waktu_tunggu_print  
		}
		]
	});
	lap_waktu_tungguListEditorGrid.render();
	/* End of DataStore */
	
	/* Function for average  data store */ 
	lap_waktu_tunggu_average_DataStore = new Ext.data.Store({
		id: 'lap_waktu_tunggu_average_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_waktu_tunggu&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
			{name: 'avg_cust_kurg', type: 'int', mapping: 'avg_cust_kurg'},
			{name: 'avg_cust_lbh', type: 'int', mapping: 'avg_cust_lbh'},
			{name: 'avg_waktu_kurg', type: 'string', mapping: 'avg_waktu_kurg'},
			{name: 'avg_waktu_lbh', type: 'string', mapping: 'avg_waktu_lbh'},
			{name: 'total_cust', type: 'int', mapping: 'total_cust'},
			{name: 'avg_waktu_total', type: 'string', mapping: 'avg_waktu_total'},
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	lap_waktu_tunggu_averageColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Total Rata2 Waktu</span>' + '</div>',
			dataIndex: '',
			//hidden : true,
			disabled : false,
			width: 14,	//55,
			//sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Jml Cust <=' + '</div>',
			dataIndex: 'avg_cust_kurg',
			width: 5,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Rata-rata Waktu <=' + '</div>',
			dataIndex: 'avg_waktu_kurg',
			width: 10,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Jml Cust >' + '</div>',
			dataIndex: 'avg_cust_lbh',
			width: 5,	//55,
			sortable: true
		},
		{	
			align : 'center',
			header: '<div align="center">' + 'Rata-rata Waktu >' + '</div>',
			dataIndex: 'avg_waktu_lbh',
			width: 10,	//55,
			sortable: true
		},
		
		{	
			align : 'center',
			header: '<div align="center">' + 'Tot Cust' + '</div>',
			dataIndex: 'total_cust',
			width: 5,	//55,
			sortable: true
		},
		
		{	
			align : 'center',
			header: '<div align="center">' + 'Tot Rata-rata Waktu' + '</div>',
			dataIndex: 'avg_waktu_total',
			width: 10,	//55,
			sortable: true
		},
		]);
	
	lap_waktu_tunggu_averageColumnModel.defaultSortable= true;
	
	lap_waktu_tunggu_averageListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_waktu_tunggu_averageListEditorGrid',
		el: 'fp_lap_waktu_tunggu_average',
		title: '',
		autoHeight: true,
		store: lap_waktu_tunggu_average_DataStore, // DataStore
		cm: lap_waktu_tunggu_averageColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800, 

	});
	lap_waktu_tunggu_averageListEditorGrid.render();
	
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
			url: 'index.php?c=c_lap_waktu_tunggu&m=get_daftar_customer', 
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
	});
			
	/* Create Context Menu */
	lap_waktu_tungguContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_waktu_tunggu_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_lunjungan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_waktu_tunggu_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_waktu_tungguContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_waktu_tungguSelectedRow=rowIndex;
		lap_waktu_tungguContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	lap_waktu_tungguListEditorGrid.addListener('rowcontextmenu', onlap_waktu_tunggu_ListEditGridContextMenu);
	//lap_waktu_tungguDataStore.load({params: {start: 0, limit: 31}});
	//lap_waktu_tunggu_average_DataStore.load({params: {start: 0, limit: 31}});
	
	
	/*Detail Declaration */	
	/* Function for Retrieve DataStore of detail*/
	lap_waktu_tunggu_detail_DataStore = new Ext.data.Store({
		id: 'lap_waktu_tunggu_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_waktu_tunggu&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */

	/* Function for action list search */
	function lap_waktu_tunggu_search(){
		if(is_lap_waktu_tunggu_searchForm_valid())
		{
		var lap_waktu_tunggu_id_search=null;
		var lap_waktu_tunggu_tgl_start_search=null;
		var lap_waktu_tunggu_tgl_end_search=null;
		var lap_waktu_tunggu_groupby=null;
		var lap_waktu_tunggu_tmedis_bulan=null;
		var lap_waktu_tunggu_tmedis_tahun=null;
		var lap_waktu_tunggu_tmedis_periode=null;	
		
		if(lap_waktu_tunggu_group_SearchField.getValue()!==null){lap_waktu_tunggu_groupby=lap_waktu_tunggu_group_SearchField.getValue();}
		if(lap_waktu_tunggu_idSearchField.getValue()!==null){lap_waktu_tunggu_id_search=lap_waktu_tunggu_idSearchField.getValue();}
		if(lap_waktu_tunggu_bulanField.getValue()!==null){lap_waktu_tunggu_tmedis_bulan=lap_waktu_tunggu_bulanField.getValue();}
		if(lap_waktu_tunggu_tahunField.getValue()!==null){lap_waktu_tunggu_tmedis_tahun=lap_waktu_tunggu_tahunField.getValue();}
		if(Ext.getCmp('lap_waktu_tunggu_tglStartSearchField').getValue()!==null){lap_waktu_tunggu_tgl_start_search=Ext.getCmp('lap_waktu_tunggu_tglStartSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('lap_waktu_tunggu_tglEndSearchField').getValue()!==null){lap_waktu_tunggu_tgl_end_search=Ext.getCmp('lap_waktu_tunggu_tglEndSearchField').getValue().format('Y-m-d');}

		if(lap_waktu_tunggu_opsitglField.getValue()==true){
			lap_waktu_tunggu_tmedis_periode='tanggal';
		}else if(lap_waktu_tunggu_opsiblnField.getValue()==true){
			lap_waktu_tunggu_tmedis_periode='bulan';
		}else{
			lap_waktu_tunggu_tmedis_periode='all';
		}
		
		/*untuk detail pengunjung*/
		var lap_waktu_tunggu_id_detail=null;
		var lap_waktu_tunggu_tgl_start_detail=null;
		var lap_waktu_tunggu_tgl_end_detail=null;
		var lap_waktu_tunggu_groupby=null;
		var lap_waktu_tunggu_menit=null;
		
		if(lap_waktu_tunggu_group_SearchField.getValue()!==null){lap_waktu_tunggu_groupby=lap_waktu_tunggu_group_SearchField.getValue();}
		if(lap_waktu_tunggu_idSearchField.getValue()!==null){lap_waktu_tunggu_id_detail=lap_waktu_tunggu_idSearchField.getValue();}
		if(lap_waktu_tunggu_tglStartSearchField.getValue()!==null){lap_waktu_tunggu_tgl_start_detail=lap_waktu_tunggu_tglStartSearchField.getValue();}
		if(lap_waktu_tunggu_tglEndSearchField.getValue()!==null){lap_waktu_tunggu_tgl_end_detail=lap_waktu_tunggu_tglEndSearchField.getValue();}
		if(lap_waktu_tunggu_wktField.getValue()!==null){lap_waktu_tunggu_menit=lap_waktu_tunggu_wktField.getValue();}
		/*end*/

		// change the store parameters
		lap_waktu_tungguDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			lap_waktu_tunggu_id	:	lap_waktu_tunggu_id_search, 
			tgl_start	: 	lap_waktu_tunggu_tgl_start_search,
			tgl_end	: 	lap_waktu_tunggu_tgl_end_search,
			groupby : lap_waktu_tunggu_groupby,
			bulan		: lap_waktu_tunggu_tmedis_bulan,
			tahun		: lap_waktu_tunggu_tmedis_tahun,
			periode		: lap_waktu_tunggu_tmedis_periode,
			menit	: lap_waktu_tunggu_menit			
		};
		lap_waktu_tunggu_average_DataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			lap_waktu_tunggu_id	:	lap_waktu_tunggu_id_search, 
			tgl_start	: 	lap_waktu_tunggu_tgl_start_search,
			tgl_end	: 	lap_waktu_tunggu_tgl_end_search,
			groupby : lap_waktu_tunggu_groupby,
			bulan		: lap_waktu_tunggu_tmedis_bulan,
			tahun		: lap_waktu_tunggu_tmedis_tahun,
			periode		: lap_waktu_tunggu_tmedis_periode,
			menit	: lap_waktu_tunggu_menit			
		};
		var today=new Date().format('Y-m-d');
		// Cause the datastore to do another query : 
		lap_waktu_tungguDataStore.reload({params: {start: 0, limit: 31}});
		lap_waktu_tunggu_average_DataStore.reload({params: {start: 0, limit: 31}});
		//detail_customerStore.load({params: {start: 0, limit: 0}});
		
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
	/* Identify  lap_waktu_tunggu_id Search Field */
	lap_waktu_tunggu_idSearchField= new Ext.form.NumberField({
		id: 'lap_waktu_tunggu_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	var dt = new Date(); 

	
	
	/* Identify  groupby Field */
	lap_waktu_tunggu_group_SearchField= new Ext.form.ComboBox({
		id: 'lap_waktu_tunggu_group_SearchField',
		fieldLabel: 'Kelompokkan',
		maxLength: 50,
		width: 100,
		store:new Ext.data.SimpleStore({
			fields:['lap_waktu_tunggu_cust_value', 'lap_waktu_tunggu_cust_display'],
			data: [['Medis','Medis'],['NonMedis','Non Medis'],['Semua','Semua']]
		}),
		mode: 'local',
		displayField: 'lap_waktu_tunggu_cust_display',
		valueField: 'lap_waktu_tunggu_cust_value',
		anchor: '55%',
		triggerAction: 'all'
	});
	
	lap_waktu_tunggu_groupSearch = new Ext.form.FieldSet({
		title: 'Group By',
		labelWidth: 100,
		anchor: '98%',
		//layout:'form',
		items: [lap_waktu_tunggu_group_SearchField]

	});
	
	lap_waktu_tunggu_wktField= new Ext.form.TextField({
		id: 'lap_waktu_tunggu_wktField',
		fieldLabel: 'Waktu Tunggu (menit)',
		maxLength: 2,
		anchor: '20%'
	});
	lap_waktu_tunggu_label=new Ext.form.Label({ html:  ' &nbsp; menit'});
	
	lap_waktu_tunggu_menitSearch = new Ext.form.FieldSet({
		title: 'Waktu Tunggu',
		labelWidth: 100,
		anchor: '98%',
		layout:'column',
		items: [lap_waktu_tunggu_wktField, lap_waktu_tunggu_label]

	});
	
	/////tgl n bulan
	lap_waktu_tunggu_opsitglField=new Ext.form.Radio({
		id:'lap_waktu_tunggu_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	lap_waktu_tunggu_opsiblnField=new Ext.form.Radio({
		id:'lap_waktu_tunggu_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	lap_waktu_tunggu_tglStartSearchField= new Ext.form.DateField({
		id: 'lap_waktu_tunggu_tglStartSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'lap_waktu_tunggu_tglStartSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'lap_waktu_tunggu_tglakhirField'
		value: firstday
	});
	
	lap_waktu_tunggu_tglEndSearchField= new Ext.form.DateField({
		id: 'lap_waktu_tunggu_tglEndSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'lap_waktu_tunggu_tglEndSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'lap_waktu_tunggu_tglawalField',
		value: today
	});
	
	lap_waktu_tunggu_bulanField=new Ext.form.ComboBox({
		id:'lap_waktu_tunggu_bulanField',
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
	
	lap_waktu_tunggu_tahunField=new Ext.form.ComboBox({
		id:'lap_waktu_tunggu_tahunField',
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
	
	var lap_waktu_tunggu_periodeField=new Ext.form.FieldSet({
		id:'lap_waktu_tunggu_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[lap_waktu_tunggu_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[lap_waktu_tunggu_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_waktu_tunggu_tglStartSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_waktu_tunggu_tglEndSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[lap_waktu_tunggu_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_waktu_tunggu_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_waktu_tunggu_tahunField]
					   }]
			}]
	});
	//// end of tgl n bulan
	
	/* Function for retrieve search Form Panel */
	lap_waktu_tunggu_searchForm = new Ext.FormPanel({
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
							items: [lap_waktu_tunggu_periodeField,lap_waktu_tunggu_menitSearch,lap_waktu_tunggu_groupSearch] 
						}]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: lap_waktu_tunggu_search
			},{
				text: 'Close',
				handler: function(){
					lap_waktu_tunggu_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function lap_waktu_tunggu_reset_formSearch(){
		lap_waktu_tunggu_idSearchField.reset();
		lap_waktu_tunggu_group_SearchField.reset();
		lap_waktu_tunggu_group_SearchField.setValue('Semua');
		lap_waktu_tunggu_idSearchField.setValue(null);
		lap_waktu_tunggu_tglStartSearchField.reset();
		lap_waktu_tunggu_tglStartSearchField.setValue(firstday);
		lap_waktu_tunggu_tglEndSearchField.reset();
		lap_waktu_tunggu_tglEndSearchField.setValue(today);
		Ext.getCmp('lap_waktu_tunggu_tglStartSearchField').setValue(firstday);
		Ext.getCmp('lap_waktu_tunggu_tglEndSearchField').setValue(today);
		lap_waktu_tunggu_wktField.setValue('20');
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_waktu_tunggu_searchWindow = new Ext.Window({
		title: 'Pencarian Waktu Tunggu',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_waktu_tunggu_search',
		items: lap_waktu_tunggu_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_waktu_tunggu_searchWindow.isVisible()){
			lap_waktu_tunggu_reset_formSearch();
			lap_waktu_tunggu_searchWindow.show();
		} else {
			lap_waktu_tunggu_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function is_valid_form(){
		if(lap_waktu_tunggu_opsitglField.getValue()==true){
			lap_waktu_tunggu_tglStartSearchField.allowBlank=false;
			lap_waktu_tunggu_tglEndSearchField.allowBlank=false;
			if(lap_waktu_tunggu_tglStartSearchField.isValid() && lap_waktu_tunggu_tglEndSearchField.isValid())
				return true;
			else
				return false;
		}else{
			lap_waktu_tunggu_tglStartSearchField.allowBlank=true;
			lap_waktu_tunggu_tglEndSearchField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function lap_waktu_tunggu_print(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_tglstart=null;
		var trawat_tglend_print=null;
		var trawat_groupby_print=null;
		var trawat_bulan_print=null;
		var trawat_tahun_print=null;
		var trawat_periode_print=null;
		var trawat_menit_print=null;
		var win;              
		// check if we do have some search data...
		if(lap_waktu_tungguDataStore.baseParams.tgl_start!==null){trawat_tglstart = lap_waktu_tungguDataStore.baseParams.tgl_start;}
		if(lap_waktu_tungguDataStore.baseParams.tgl_end!==null){trawat_tglend_print = lap_waktu_tungguDataStore.baseParams.tgl_end;}
		if(lap_waktu_tungguDataStore.baseParams.groupby!==null){trawat_groupby_print = lap_waktu_tungguDataStore.baseParams.groupby;}
		if(lap_waktu_tungguDataStore.baseParams.bulan!==null){trawat_bulan_print = lap_waktu_tungguDataStore.baseParams.bulan;}
		if(lap_waktu_tungguDataStore.baseParams.tahun!==null){trawat_tahun_print = lap_waktu_tungguDataStore.baseParams.tahun;}
		if(lap_waktu_tungguDataStore.baseParams.periode!==null){trawat_periode_print = lap_waktu_tungguDataStore.baseParams.periode;}
		if(lap_waktu_tungguDataStore.baseParams.menit!==null){trawat_menit_print = lap_waktu_tungguDataStore.baseParams.menit;}
		if(lap_waktu_tungguDataStore.baseParams.query!==null){searchquery = lap_waktu_tungguDataStore.baseParams.query;}
		if(lap_waktu_tungguDataStore.baseParams.trawat_cust!==null){trawat_cust_print = lap_waktu_tungguDataStore.baseParams.trawat_cust;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_waktu_tunggu&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust : trawat_cust_print,
		  	currentlisting: lap_waktu_tungguDataStore.baseParams.task, // this tells us if we are searching or not
			//lap_waktu_tunggu_id	:	lap_waktu_tunggu_id_search, 
			tgl_start	: 	trawat_tglstart,
			tgl_end	: 	trawat_tglend_print,
			groupby : trawat_groupby_print,
			bulan		: trawat_bulan_print,
			tahun		: trawat_tahun_print,
			periode		: trawat_periode_print,
			menit	: trawat_menit_print
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./waktu_tunggu.html','waktu_tunggu','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function lap_lunjungan_export_excel(){
		var searchquery = "";
		var tindakan_dokter_2excel=null;
		var win;              
		// check if we do have some search data...
		if(lap_waktu_tungguDataStore.baseParams.query!==null){searchquery = lap_waktu_tungguDataStore.baseParams.query;}
		if(lap_waktu_tungguDataStore.baseParams.trawat_dokter!==null){tindakan_dokter_2excel = lap_waktu_tungguDataStore.baseParams.trawat_dokter;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_waktu_tunggu&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_dokter : tindakan_dokter_2excel,
		  	currentlisting: lap_waktu_tungguDataStore.baseParams.task // this tells us if we are searching or not
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
	
	lap_waktu_tunggu_opsitglField.on("check",function(){
		if(lap_waktu_tunggu_opsitglField.getValue()==true){
			lap_waktu_tunggu_tglStartSearchField.allowBlank=false;
			lap_waktu_tunggu_tglEndSearchField.allowBlank=false;
		}else{
			lap_waktu_tunggu_tglStartSearchField.allowBlank=true;
			lap_waktu_tunggu_tglEndSearchField.allowBlank=true;
		}
		
	});
	
	lap_waktu_tunggu_searchWindow.show();
	lap_waktu_tunggu_wktField.reset();
	lap_waktu_tunggu_wktField.setValue('20');
	lap_waktu_tunggu_group_SearchField.setValue("Semua");
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lap_waktu_tunggu"></div>
		 <div id="fp_lap_waktu_tunggu2"></div>
		 <div id="fp_lap_waktu_tunggu_average"></div>
         <div id="fp_lap_waktu_tunggu_detail"></div>
		 <div id="fp_dlap_waktu_tunggu"></div>
		<div id="elwindow_lap_waktu_tunggu_create"></div>
        <div id="elwindow_lap_waktu_tunggu_search"></div>
    </div>
</div>
</body>