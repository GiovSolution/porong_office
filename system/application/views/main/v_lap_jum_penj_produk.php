<?
/* 
	+ Module  		: Laporan Jumlah Penjualan Produk View
	+ Description	: For record view
	+ Filename 		: v_lap_jum_penj_produk.php
 	+ Author  		: Fred
	
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
var lap_jum_penj_produkDataStore;
var sum_penj_produkDataStore;
var lap_jum_penj_produk_ColumnModel;
var sum_penj_produkColumnModel;
var lap_jum_penj_produk_ListEditorGrid;
var lap_jum_penj_produk_searchForm;
var lap_jum_penj_produk_searchWindow;
var lap_jum_penj_produk_SelectedRow;
var lap_jum_penj_produk_ContextMenu;
//for detail data
//var report_tindakan_detail_DataStore;
//var report_tindakandetailListEditorGrid;

//var today=new Date().format('d-m-Y');
var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS_pr=250;

/* declare variable here for Field*/
//var ljpp_idField;
var lap_jum_penj_produk_idSearchField;
var lap_jum_penj_produk_groupbyField;

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

	function is_lap_jum_penj_produk_searchform_valid(){
		return (Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').isValid() && lap_jum_penj_produk_karyawanSearchField.isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	lap_jum_penj_produkDataStore = new Ext.data.Store({
		id: 'lap_jum_penj_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_penj_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS_pr, ljpp_karyawan_id : 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_jum_penj_produk_ColumnModel, Mapping => for initiate table column */ 
			//{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'}, 
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jumlah_produk', type: 'string', mapping: 'Jumlah_produk'},
			{name: 'dtrawat_skredit', type: 'string', mapping: 'rawat_kredit'},
			{name: 'dtrawat_jkredit', type: 'string', mapping: 'Total_jumlah'},
			{name: 'komisi_satuan', type: 'float', mapping: 'komisi_satuan'},
			{name: 'komisi', type: 'float', mapping: 'komisi'}
		]),
		sortInfo:{field: 'karyawan_username', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	lap_jum_penj_produk_group1_DataStore = new Ext.data.Store({
		id: 'lap_jum_penj_produk_group1_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_penj_produk&m=get_group1_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS_pr}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
			{name: 'group_id', type: 'int', mapping: 'group_id'}, 
			{name: 'group_kode', type: 'string', mapping: 'group_kode'}, 
			{name: 'group_nama', type: 'string', mapping: 'group_nama'}
		]),
		sortInfo:{field: 'group_id', direction: "DESC"}
	});
	
	/* Function for summary kredit data store */ 
	sum_penj_produkDataStore = new Ext.data.Store({
		id: 'sum_penj_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_penj_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:pageS_pr}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_jum_penj_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'}, 
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jumlah_produk', type: 'string', mapping: 'Jumlah_produk'},
			{name: 'dtrawat_skredit', type: 'string', mapping: 'rawat_kredit'},
			//{name: 'dtrawat_jkredit', type: 'string', mapping: 'Total_jumlah'},
			{name: 'total_kredit', type: 'string', mapping: 'Total_kredit'},
		]),
		sortInfo:{field: 'karyawan_username', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_lap_jum_penj_produk_karyawanDataStore = new Ext.data.Store({
		id: 'cbo_lap_jum_penj_produk_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_penj_produk&m=get_dokter_list', 
			method: 'POST'
		}),baseParams: {task : "LIST", start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id : 'karyawan_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'karyawan_display', direction: "ASC"}
	});
	var cbo_karyawan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_username}</b> | {karyawan_display} </span>',
        '</div></tpl>'
    );
    
	/* Function for Identify of Window Column Model */
	lap_jum_penj_produk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 40,
			autoWidth: true
		},
		{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'produk_kode',
			width: 100,//185,	//210,
			sortable: true,
		}, 
		{
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'produk_nama',
			width: 300,//185,	//210,
			sortable: true,
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'jumlah_produk',
			width: 60,
			sortable: false
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Kredit (Rp)' + '</div>',
			dataIndex: 'komisi_satuan',
			width: 120,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Kredit (Rp)' + '</div>',
			dataIndex: 'komisi',
			width: 120,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		}
	]);
	
	lap_jum_penj_produk_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	
	var lap_jum_penj_produk_karyawanField=new Ext.form.TextField({
		id: 'lap_jum_penj_produk_karyawanField',
		name: 'lap_jum_penj_produk_karyawanField',
		//dataIndex : 'karyawan_username',
		fieldLabel: '<b>Karyawan</b>',
		width: 100,
		readOnly: true,
		disabled: true
	});
	
	sum_penj_produkColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="right">' + 'Grand Tot Kredit (Rp)' + '</div>',
			dataIndex: 'total_kredit',
			width: 80,	//55,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		]);
	
	sum_penj_produkColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	lap_jum_penj_produk_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_jum_penj_produk_ListEditorGrid',
		el: 'fp_lap_jum_penj_produk',
		title: 'Laporan Jumlah Penjualan Produk',
		autoHeight: false,
		height: 444,
		store: lap_jum_penj_produkDataStore, // DataStore
		cm: lap_jum_penj_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_pr,
			disabled:false,
			store: lap_jum_penj_produkDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			'text':'Karyawan : '
		},
		lap_jum_penj_produk_karyawanField,
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
			handler: lap_jum_penj_produk_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_jum_penj_produk_print  
		}
		]
	});
	lap_jum_penj_produk_ListEditorGrid.render();
	/* End of DataStore */
	
	lap_jum_penj_produk_ListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'lap_jum_penj_produk_ListEditorGrid2',
		el: 'fp_lap_jum_penj_produk_detail',
		title: '',
		autoHeight: true,
		store: sum_penj_produkDataStore, // DataStore
		cm: sum_penj_produkColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
	
		/* Add Control on ToolBar */
	
	});
	lap_jum_penj_produk_ListEditorGrid2.render();
	
	/* Create Context Menu */
	lap_jum_penj_produk_ContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_jum_penj_produk_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_jum_penj_produk_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onreport_tindakanListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_jum_penj_produk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_jum_penj_produk_SelectedRow=rowIndex;
		lap_jum_penj_produk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	lap_jum_penj_produk_ListEditorGrid.addListener('rowcontextmenu', onreport_tindakanListEditGridContextMenu);
	//lap_jum_penj_produkDataStore.load({params: {start: 0, limit: pageS_pr}});	// load DataStore
	//lap_jum_penj_produk_ListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
		

	/* Function for action list search */
	function lap_jum_penj_produk_search(){
		// render according to a SQL date format.
		if(is_lap_jum_penj_produk_searchform_valid())
		{
		var ljpp_id_search=null;
		var ljpp_tgl_start_search=null;
		var ljpp_tgl_end_search=null;
		var ljpp_karyawan_search=null;
		var ljpp_groupby_search=null;
		var group1_search=null;
		var jproduk_bulan="";
		var jproduk_tahun="";
		var jproduk_periode="";
		var opsi_jproduk_search=null;
		
		cbo_lap_jum_penj_produk_karyawanDataStore.load({
		 	callback: function(r,opt,success){
				if(success==true){
					var j=cbo_lap_jum_penj_produk_karyawanDataStore.findExact('karyawan_value',lap_jum_penj_produk_karyawanSearchField.getValue(),0);
					if(j>-1){
						var dokter_record=cbo_lap_jum_penj_produk_karyawanDataStore.getAt(j);
						lap_jum_penj_produk_karyawanField.setValue(dokter_record.data.karyawan_username);
					}
				}
			}
		});

		if(lap_jum_penj_produk_idSearchField.getValue()!==null){ljpp_id_search=lap_jum_penj_produk_idSearchField.getValue();}
		if(Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue()!==null){ljpp_tgl_start_search=Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue();}
		if(Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue()!==null){ljpp_tgl_end_search=Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue();}
		if(lap_jum_penj_produk_karyawanSearchField.getValue()!==null){ljpp_karyawan_search=lap_jum_penj_produk_karyawanSearchField.getValue();}
		//if(lap_jum_penj_produk_groupbyField.getValue()!==null){ljpp_groupby_search=lap_jum_penj_produk_groupbyField.getValue();}
		if(lap_jum_penj_produk_bulanField.getValue()!==""){jproduk_bulan=lap_jum_penj_produk_bulanField.getValue(); }
		if(lap_jum_penj_produk_tahunField.getValue()!==""){jproduk_tahun=lap_jum_penj_produk_tahunField.getValue(); }
		if(lap_jum_penj_produk_group1SearchField.getValue()!==null){group1_search=lap_jum_penj_produk_group1SearchField.getValue();}
		if(lap_jum_penj_produk_opsitglField.getValue()==true){
			jproduk_periode='tanggal';
		}else if(lap_jum_penj_produk_opsiblnField.getValue()==true){
			jproduk_periode='bulan';
		}else{
			jproduk_periode='all';
		}
		
		if(lap_jum_penj_produk_allField.getValue()==true){ 
			opsi_jproduk_search='all';
		}else if(lap_jum_penj_produk_group1Field.getValue()==true){
			opsi_jproduk_search='group1';
		}
		
		// change the store parameters
		
		lap_jum_penj_produkDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			ljpp_id	:	ljpp_id_search, 
			ljpp_tgl_start	: 	ljpp_tgl_start_search,
			ljpp_tgl_end	: 	ljpp_tgl_end_search,
			ljpp_karyawan_id	:	ljpp_karyawan_search,
			//ljpp_groupby	:	ljpp_groupby_search,
			bulan		: jproduk_bulan,
			tahun		: jproduk_tahun,
			periode		: jproduk_periode,
			opsi_jproduk	: 	opsi_jproduk_search,
			group1_id		:	group1_search,
			
		};
		sum_penj_produkDataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			ljpp_id	:	ljpp_id_search, 
			ljpp_tgl_start	: 	ljpp_tgl_start_search,
			ljpp_tgl_end	: 	ljpp_tgl_end_search,
			ljpp_karyawan_id	:	ljpp_karyawan_search,
			//ljpp_groupby	:	ljpp_groupby_search,
			bulan		: jproduk_bulan,
			tahun		: jproduk_tahun,
			periode		: jproduk_periode,
			opsi_jproduk	: 	opsi_jproduk_search,
			group1_id		:	group1_search,
		};
		// Cause the datastore to do another query : 
		lap_jum_penj_produkDataStore.reload({params: {start: 0, limit: pageS_pr}});
		sum_penj_produkDataStore.reload({params: {start: 0, limit: pageS_pr}});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form Anda belum lengkap.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Field for search */
	/* Identify  ljpp_id Search Field */
	lap_jum_penj_produk_idSearchField= new Ext.form.NumberField({
		id: 'lap_jum_penj_produk_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	/* Identify  Group_byField*/
	lap_jum_penj_produk_groupbyField= new Ext.form.ComboBox({
		id: 'lap_jum_penj_produk_groupbyField',
		fieldLabel: 'Group By',
		store:new Ext.data.SimpleStore({
			fields:['group_value', 'group_display'],
			data:[['Semua','Semua']]
		}),
		mode: 'local',
		editable:false,
		//emptyText: 'Semua',
		displayField: 'group_display',
		valueField: 'group_value',
		width: 200,
		triggerAction: 'all'	
	});
	
	lap_jum_penj_produk_karyawanSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Nama',
		store: cbo_lap_jum_penj_produk_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_username',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
		minChars : 3,
        hideTrigger:false,
        tpl: cbo_karyawan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		width: 214
	});

	var dt = new Date(); 
	
	lap_jum_penj_produk_bulanField=new Ext.form.ComboBox({
		id:'lap_jum_penj_produk_bulanField',
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
	
	lap_jum_penj_produk_tahunField=new Ext.form.ComboBox({
		id:'lap_jum_penj_produk_tahunField',
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
	
	lap_jum_penj_produk_opsitglField=new Ext.form.Radio({
		id:'lap_jum_penj_produk_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	lap_jum_penj_produk_opsiblnField=new Ext.form.Radio({
		id:'lap_jum_penj_produk_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	lap_jum_penj_produk_tglStartSearchField= new Ext.form.DateField({
		id: 'lap_jum_penj_produk_tglStartSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'lap_jum_penj_produk_tglStartSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_jproduk_tglakhirField'
		value: today
	});
	
	lap_jum_penj_produk_tglEndSearchField= new Ext.form.DateField({
		id: 'lap_jum_penj_produk_tglEndSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'lap_jum_penj_produk_tglEndSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_jproduk_tglawalField',
		value: today
	});
	
	var group1_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{group_nama} ({group_kode})</b></span>',
        '</div></tpl>'
    );
	
	lap_jum_penj_produk_group1SearchField= new Ext.form.ComboBox({
		id: 'lap_jum_penj_produk_group1SearchField',
		fieldLabel: '-',
		store: lap_jum_penj_produk_group1_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'group_nama',
		valueField: 'group_id',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS_pr,
		enableKeyEvents: true,
		tpl: group1_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		width: 300
	
	});
	
	var lap_jum_penj_produk_periodeField=new Ext.form.FieldSet({
		id:'lap_jum_penj_produk_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_jproduk_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[lap_jum_penj_produk_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_jum_penj_produk_tglStartSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_jum_penj_produk_tglEndSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[lap_jum_penj_produk_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_jum_penj_produk_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_jum_penj_produk_tahunField]
					   }]
			}]
	});
	
	lap_jum_penj_produk_allField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Semua Produk',
		width: 100,
		checked: true
	});
	
	lap_jum_penj_produk_group1Field=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Group 1',
		width: 100
	});
	
	lap_jum_penj_produk_opsiSearchField=new Ext.form.FieldSet({
		id:'lap_jum_penj_produk_opsiSearchField',
		title: 'Opsi Produk',
		layout: 'form',
		frame: false,
		bodyStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					bodyStyle: 'padding-bottom: 5px;',
					border: false,
					items	: [lap_jum_penj_produk_allField]
			   },
				{
				   layout	: 'column',
				   bodyStyle: 'padding-bottom: 5px;',
				   border: false,
				   items	: [lap_jum_penj_produk_group1Field,lap_jum_penj_produk_group1SearchField]
			   }
			
		]
	});
	
	/* Function for retrieve search Form Panel */
	lap_jum_penj_produk_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [
				        /*{
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.33,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									fieldLabel: 'Tanggal',
							        name: 'lap_jum_penj_produk_tglStartSearchField',
							        id: 'lap_jum_penj_produk_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        endDateField: 'lap_jum_penj_produk_tglEndSearchField' // id of the end date field Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').isValid()
							    }] 
						},
						{
							columnWidth:0.30,
							layout: 'form',
							labelWidth:20,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'lap_jum_penj_produk_tglEndSearchField',
							        id: 'lap_jum_penj_produk_tglEndSearchField',
							        vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        startDateField: 'lap_jum_penj_produk_tglStartSearchField' // id of the end date field
							    }] 
						}]}*/lap_jum_penj_produk_periodeField, lap_jum_penj_produk_opsiSearchField, lap_jum_penj_produk_karyawanSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: lap_jum_penj_produk_search
			},{
				text: 'Close',
				handler: function(){
					lap_jum_penj_produk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function lap_jum_penj_produk_reset_formSearch(){
		lap_jum_penj_produk_idSearchField.reset();
		lap_jum_penj_produk_idSearchField.setValue(null);
		lap_jum_penj_produk_karyawanSearchField.reset();
		lap_jum_penj_produk_karyawanSearchField.setValue(null);
		//lap_jum_penj_produk_groupbyField.reset();
		//lap_jum_penj_produk_groupbyField.setValue('Semua');
		Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').reset();
		Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').setValue(null);
		Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').reset();
		Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_jum_penj_produk_searchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_jum_penj_produk_search',
		items: lap_jum_penj_produk_searchForm
	});
    /* End of Function */ 
	lap_jum_penj_produk_searchWindow.show();
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_jum_penj_produk_searchWindow.isVisible()){
			lap_jum_penj_produk_reset_formSearch();
			lap_jum_penj_produk_searchWindow.show();

		} else {
			lap_jum_penj_produk_searchWindow.toFront();
		}
	}
  	/* End Function */
	

	/* Function for print List Grid */
	function lap_jum_penj_produk_print(){
		var printquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var jproduk_bulan="";
		var jproduk_tahun="";
		var jproduk_periode="";
		var group1_print=null;
		var win;              
		// check if we do have some search data...
		if(lap_jum_penj_produkDataStore.baseParams.query!==null){printquery = lap_jum_penj_produkDataStore.baseParams.query;}
		if(Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue()!==null){ljpp_tgl_start_print=Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue();}
		if(Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue()!==null){ljpp_tgl_end_print=Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue();}
		if(lap_jum_penj_produk_karyawanSearchField.getValue()!==null){ljpp_karyawan_print=lap_jum_penj_produk_karyawanSearchField.getValue();}
		//if(lap_jum_penj_produk_groupbyField.getValue()!==null){ljpp_groupby_print=lap_jum_penj_produk_groupbyField.getValue();}
		if(lap_jum_penj_produk_group1SearchField.getValue()!==null){group1_print=lap_jum_penj_produk_group1SearchField.getValue();}
		if(lap_jum_penj_produk_bulanField.getValue()!==""){jproduk_bulan=lap_jum_penj_produk_bulanField.getValue(); }
		if(lap_jum_penj_produk_tahunField.getValue()!==""){jproduk_tahun=lap_jum_penj_produk_tahunField.getValue(); }
		if(lap_jum_penj_produk_opsitglField.getValue()==true){
			jproduk_periode='tanggal';
		}else if(lap_jum_penj_produk_opsiblnField.getValue()==true){
			jproduk_periode='bulan';
		}else{
			jproduk_periode='all';
		}
		
		if(lap_jum_penj_produk_allField.getValue()==true){ 
			opsi_jproduk_print='all';
		}else if(lap_jum_penj_produk_group1Field.getValue()==true){
			opsi_jproduk_print='group1';
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_penj_produk&m=get_action',
		params: {
			task: "PRINT",
		  	query: printquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			ljpp_tgl_start	: 	ljpp_tgl_start_print,
			ljpp_tgl_end	: 	ljpp_tgl_end_print,
			ljpp_karyawan_id	:	ljpp_karyawan_print,
			//ljpp_groupby	:	ljpp_groupby_print,
			bulan		: jproduk_bulan,
			tahun		: jproduk_tahun,
			periode		: jproduk_periode,
			opsi_jproduk	: 	opsi_jproduk_print,
			group1_id		:	group1_print,
		  	currentlisting: lap_jum_penj_produkDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./tindakanlist.html','tindakanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function lap_jum_penj_produk_export_excel(){
		var excelquery = "";
		var tindakan_dokter_2excel=null;
		var rawat_kode_2excel=null;
		var tindakan_perawatan_2excel=null;
		var dtrawat_edit_2excel=null;
		var dtrawat_skredit_2excel=null;
		var dtrawat_jkredit_2excel=null;
		//var dtrawat_kredit_2excel=null;
		
		var ljpp_tgl_start_excel=null;
		var ljpp_tgl_end_excel=null;
		var ljpp_karyawan_excel=null;
		var ljpp_groupby_excel=null;
		var group1_excel=null;
		var jproduk_bulan="";
		var jproduk_tahun="";
		var jproduk_periode="";
		
		var win;              
		// check if we do have some search data...
		if(lap_jum_penj_produkDataStore.baseParams.query!==null){excelquery = lap_jum_penj_produkDataStore.baseParams.query;}
		//if(lap_jum_penj_produkDataStore.baseParams.ljpp_karyawan_id!==null){tindakan_dokter_2excel = lap_jum_penj_produkDataStore.baseParams.ljpp_karyawan_id;}
		//if(lap_jum_penj_produkDataStore.baseParams.tindakan_perawatan!==null){tindakan_perawatan_2excel = lap_jum_penj_produkDataStore.baseParams.tindakan_perawatan;}
		//if(lap_jum_penj_produkDataStore.baseParams.dtrawat_edit!==null){dtrawat_edit_2excel = lap_jum_penj_produkDataStore.baseParams.dtrawat_edit;}
		//if(lap_jum_penj_produkDataStore.baseParams.dtrawat_skredit!==null){dtrawat_skredit_2excel = lap_jum_penj_produkDataStore.baseParams.dtrawat_skredit;}
		//if(lap_jum_penj_produkDataStore.baseParams.dtrawat_jkredit!==null){dtrawat_jkredit_2excel = lap_jum_penj_produkDataStore.baseParams.dtrawat_jkredit;}
		//if(lap_jum_penj_produkDataStore.baseParams.dtrawat_kredit!==null){dtrawat_kredit_2excel = lap_jum_penj_produkDataStore.baseParams.dtrawat_kredit;}
		if(lap_jum_penj_produk_group1SearchField.getValue()!==null){group1_excel=lap_jum_penj_produk_group1SearchField.getValue();}
		if(Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue()!==null){ljpp_tgl_start_excel=Ext.getCmp('lap_jum_penj_produk_tglStartSearchField').getValue();}
		if(Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue()!==null){ljpp_tgl_end_excel=Ext.getCmp('lap_jum_penj_produk_tglEndSearchField').getValue();}
		if(lap_jum_penj_produk_karyawanSearchField.getValue()!==null){ljpp_karyawan_excel=lap_jum_penj_produk_karyawanSearchField.getValue();}
		//if(lap_jum_penj_produk_groupbyField.getValue()!==null){ljpp_groupby_excel=lap_jum_penj_produk_groupbyField.getValue();}
		if(lap_jum_penj_produk_bulanField.getValue()!==""){jproduk_bulan=lap_jum_penj_produk_bulanField.getValue(); }
		if(lap_jum_penj_produk_tahunField.getValue()!==""){jproduk_tahun=lap_jum_penj_produk_tahunField.getValue(); }
		if(lap_jum_penj_produk_opsitglField.getValue()==true){
			jproduk_periode='tanggal';
		}else if(lap_jum_penj_produk_opsiblnField.getValue()==true){
			jproduk_periode='bulan';
		}else{
			jproduk_periode='all';
		}
		
		if(lap_jum_penj_produk_allField.getValue()==true){ 
			opsi_jproduk_excel='all';
		}else if(lap_jum_penj_produk_group1Field.getValue()==true){
			opsi_jproduk_excel='group1';
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_penj_produk&m=get_action',
		params: {
			task: "EXCEL",
		  	query: excelquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			ljpp_tgl_start	: 	ljpp_tgl_start_excel,
			ljpp_tgl_end	: 	ljpp_tgl_end_excel,
			ljpp_karyawan_id	:	ljpp_karyawan_excel,
			//ljpp_groupby	:	ljpp_groupby_excel,
			bulan		: jproduk_bulan,
			tahun		: jproduk_tahun,
			periode		: jproduk_periode,
			opsi_jproduk	: 	opsi_jproduk_excel,
			group1_id		:	group1_excel,
		  	currentlisting: lap_jum_penj_produkDataStore.baseParams.task // this tells us if we are searching or not
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
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lap_jum_penj_produk"></div>
         <div id="fp_lap_jum_penj_produk_detail"></div>
        <div id="elwindow_lap_jum_penj_produk_search"></div>
    </div>
</div>
</body>