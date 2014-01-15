<?
/* 
	+ Module  		: Top Spender View
	+ Description	: For record view
	+ Filename 		: v_report_rekap_penjualan.php
 	+ Author  		: Isaac
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
var group_produk_Store= new Ext.data.SimpleStore({
		id: 'group_produk_Store',
		fields:['group_value','group_display'],
		data:[['Semua','Semua'],['Group','Group']],
		emptyText: 'Semua'
});
	
var group_perawatan_Store= new Ext.data.SimpleStore({
		id: 'group_perawatan_Store',
		fields:['group_value','group_display'],
		data:[['Semua','Semua'],[2,'Medis'],[3,'Non Medis'],[16,'Anti Aging'],[4,'Surgery']],
		emptyText: 'Semua'
});

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
var rekap_penjualanDataStore;
var sum_rekapDataStore;
var sum_voucherDataStore;
var rekap_penjualanColumnModel;
var sum_rekapColumnModel;
var sum_voucherColumnModel;
var rekap_penjualanListEditorGrid;
var rekap_penjualanListEditorGrid2;
var rekap_penjualanListEditorGrid3;
var rekap_penjualan_createForm;
var rekap_penjualan_createWindow;
var rekap_penjualan_searchForm;
var rekap_penjualan_searchWindow;
var rekap_penjualanSelectedRow;
var rekap_penjualanContextMenu;
var jenis_rekap_Field;
var group_rekap_Field;
var group_group_Field;
//var jumlahField;
//for detail data


var today=new Date().format('d-m-Y');

//declare konstant 
var post2db = '';
var msg = '';
var pageS=30;

/* declare variable here for Field*/
var trawat_medis_idField;
var trawat_medis_idSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return rekap_penjualanListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	// cek valid
	function is_rekap_penjualan_searchForm_valid(){
		return (Ext.getCmp('rekap_penjualan_tglStartSearchField').isValid() );
		//&& jumlahField.getValue()!=null && jenis_rekap_Field.getValue()!=null);
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		jenis_rekap_Field.setValue('Produk');
		//group_rekap_Field.setValue('Kode');
		if(!rekap_penjualan_createWindow.isVisible()){
			//tindakan_medisreset_form();
			//post2db='CREATE';
			msg='created';
			rekap_penjualan_createWindow.show();
		} else {
			rekap_penjualan_createWindow.toFront();
		}
	}
  	/* End of Function */
  	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	cbo_groupDataStore = new Ext.data.Store({
		id: 'cbo_groupDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_rekap_penjualan&m=get_group_produk_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'group_group_value', type: 'int', mapping: 'group_id'},
			{name: 'group_group_display', type: 'string', mapping: 'group_nama'}
			/*
			{name: 'produk_group_duproduk', type: 'int', mapping: 'group_duproduk'},
			{name: 'produk_group_dmproduk', type: 'int', mapping: 'group_dmproduk'},
			{name: 'produk_group_dultah', type: 'int', mapping: 'group_dultah'},
			{name: 'produk_group_dcard', type: 'int', mapping: 'group_dcard'},
			{name: 'produk_group_dkolega', type: 'int', mapping: 'group_dkolega'},
			{name: 'produk_group_dkeluarga', type: 'int', mapping: 'group_dkeluarga'},
			{name: 'produk_group_downer', type: 'int', mapping: 'group_downer'},
			{name: 'produk_group_dgrooming', type: 'int', mapping: 'group_dgrooming'},
			{name: 'produk_group_kelompok', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_group_kelompok_id', type: 'int', mapping: 'kategori_id'}
			*/
		]),
		sortInfo:{field: 'group_group_display', direction: "ASC"}
	});
	
	/* Function for Retrieve DataStore */
	//isc_datastore
	rekap_penjualanDataStore = new Ext.data.Store({
		id: 'rekap_penjualanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_rekap_penjualan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */
			{name: 'id', type: 'int', mapping: 'produk_id'},		
			{name: 'kode', type: 'string', mapping: 'kode'},
			{name: 'nama', type: 'string', mapping: 'nama'},
			{name: 'total_jumlah', type: 'float', mapping: 'total_jumlah'},
			{name: 'subtotal', type: 'float', mapping: 'subtotal'},
			{name: 'diskon_tambahan', type: 'float', mapping: 'diskon_tambahan'},
			{name: 'grand_total', type: 'float', mapping: 'grand_total'},
			{name: 'jum_retur', type: 'float', mapping: 'jum_retur'},
			{name: 'tot_retur', type: 'float', mapping: 'tot_retur'},
			{name: 'tot_jum_item', type: 'float', mapping: 'tot_jum_item'},
			{name: 'tot_net', type: 'float', mapping: 'tot_net'},
		]),
		sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	//isc_datastore
	sum_rekapDataStore = new Ext.data.Store({
		id: 'sum_rekapDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_rekap_penjualan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */ 
			{name: 'kode', type: 'string', mapping: 'kode'},
			{name: 'nama', type: 'string', mapping: 'nama'},
			{name: 'sum_jumlah', type: 'float', mapping: 'total_jumlah'},
			{name: 'sum_subtotal', type: 'float', mapping: 'subtotal'},
			{name: 'sum_diskon_tambahan', type: 'float', mapping: 'diskon_tambahan'},
			{name: 'sum_total', type: 'float', mapping: 'grand_total'},
			{name: 'sum_jum_retur', type: 'float', mapping: 'jum_retur'},
			{name: 'sum_tot_retur', type: 'float', mapping: 'tot_retur'},
			{name: 'sum_tot_jum_item', type: 'float', mapping: 'tot_jum_item'},
			{name: 'sum_tot_net', type: 'float', mapping: 'tot_net'},
		]),
		sortInfo:{field: 'sum_tot_net', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	// rekap voucher
	sum_voucherDataStore = new Ext.data.Store({
		id: 'sum_voucherDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_rekap_penjualan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */ 
			{name: 'voucher', type: 'string', mapping: 'voucher'},
			{name: 'voucher_medis', type: 'string', mapping: 'voucher_medis'}
		]),
		sortInfo:{field: 'voucher', direction: "DESC"}
	});
	/* End of Function */

  	/* Function for Identify of Window Column Model */
	//Tampilkan di grid
	rekap_penjualanColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Right',
			header: '<div align="center">' + 'ID' + '</div>',
			dataIndex: 'id',
			width: 60,//185,	//210,
			sortable: true,
			hidden : true,
			readOnly : true,
		},
		{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'kode',
			width: 80,
			sortable: true,
			readOnly:true,
	
		}, 
		{
			header: '<div align="center">' + 'Nama Produk / Perawatan / Paket' + '</div>',
			dataIndex: 'nama',
			width: 210,//185,	//210,
			sortable: true,
			readOnly : true,
		}, 
		{
			align : 'Right',
			header: '<div align="center">' + 'Tot Item' + '</div>',
			dataIndex: 'total_jumlah',
			width: 60,//185,	//210,
			sortable: true,
			readOnly : true,
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Sub Tot (Rp)' + '</div>',
			dataIndex: 'subtotal',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Disk Tmbhn (Rp)' + '</div>',
			dataIndex: 'diskon_tambahan',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot (Rp)' + '</div>',
			dataIndex: 'grand_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Item Retur' + '</div>',
			dataIndex: 'jum_retur',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 60,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Retur (Rp)' + '</div>',
			dataIndex: 'tot_retur',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Item Net' + '</div>',
			dataIndex: 'tot_jum_item',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 60,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Net (Rp)' + '</div>',
			dataIndex: 'tot_net',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}
	]);
	
	rekap_penjualanColumnModel.defaultSortable= true;
	/* End of Function */
	
	sum_rekapColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 80,
			sortable: true,
			readOnly:true,
	
		}, 
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 210,//185,	//210,
			sortable: true,
			readOnly : true,
		}, 
		{
			align : 'Right',
			header: '<div align="center">' + 'Tot Item' + '</div>',
			dataIndex: 'sum_jumlah',
			width: 60,//185,	//210,
			sortable: true,
			readOnly : true,
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Sub Tot (Rp)' + '</div>',
			dataIndex: 'sum_subtotal',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Disk Tmbhn (Rp)' + '</div>',
			dataIndex: 'sum_diskon_tambahan',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot (Rp)' + '</div>',
			dataIndex: 'sum_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Item Retur' + '</div>',
			dataIndex: 'sum_jum_retur',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 60,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Retur (Rp)' + '</div>',
			dataIndex: 'sum_tot_retur',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Item Net' + '</div>',
			dataIndex: 'sum_tot_jum_item',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 60,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Net (Rp)' + '</div>',
			dataIndex: 'sum_tot_net',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}
	]);
	
	sum_rekapColumnModel.defaultSortable= true;
	
	// rekap voucher
	
	sum_voucherColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 80,
			sortable: true,
			readOnly:true,
	
		}, 
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 210,//185,	//210,
			sortable: true,
			readOnly : true,
		}, 
		{
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 60,//185,	//210,
			sortable: true,
			readOnly : true,
		},
		{	
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 60,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},
		// if voucher
		{	
			align : 'Right',
			header: '<div align="center">' + 'Voucher Medis (Rp)' + '</div>',
			dataIndex: 'voucher_medis',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 100,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Voucher Non Medis (Rp)' + '</div>',
			dataIndex: 'voucher',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 150,	//55,
			sortable: true
		}
	]);
	
	sum_voucherColumnModel.defaultSortable= true;
	
	// eof rekap voucher

	/* Declare DataStore and  show datagrid list */
	rekap_penjualanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rekap_penjualanListEditorGrid',
		el: 'fp_rekap_penjualan',
		title: 'Laporan Rekap Penjualan',
		autoHeight: true,
		store: rekap_penjualanDataStore, // DataStore
		cm: rekap_penjualanColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200, //940,//1200,	//970,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_print  
		}
		]
	});
	rekap_penjualanListEditorGrid.render();
	/* End of DataStore */
	
	// rekap voucher 
		rekap_penjualanListEditorGrid3 =  new Ext.grid.EditorGridPanel({
		id: 'rekap_penjualanListEditorGrid3',
		el: 'fp_rekap_penjualan3',
		title: '',
		autoHeight: true,
		store: sum_voucherDataStore, // DataStore
		cm: sum_voucherColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200, //940,//1200,	//970,
	
		/* Add Control on ToolBar */
	
	});
	rekap_penjualanListEditorGrid3.render();
	// eof rekap voucher
	
	rekap_penjualanListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'rekap_penjualanListEditorGrid2',
		el: 'fp_rekap_penjualan2',
		title: '',
		autoHeight: true,
		store: sum_rekapDataStore, // DataStore
		cm: sum_rekapColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200, //940,//1200,	//970,
	
		/* Add Control on ToolBar */
	
	});
	rekap_penjualanListEditorGrid2.render();

	/* Create Context Menu */
	rekap_penjualanContextMenu = new Ext.menu.Menu({
		id: 'rekap_penjualanListEditorGridContextMenu',
		items: [
		{
			text: 'Search Top Spender',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onrekap_penjualanListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		rekap_penjualanContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		rekap_penjualanSelectedRow=rowIndex;
		rekap_penjualanContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	rekap_penjualanListEditorGrid.addListener('rowcontextmenu', onrekap_penjualanListEditGridContextMenu);
	//top_spenderDataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	
	/* Identify  jenis Combo*/
	jenis_rekap_Field= new Ext.form.ComboBox({
		id: 'jenis_rekap_Field',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['jenis_value', 'jenis_display'],
			data:[['Perawatan','Penjualan Perawatan Satuan'],['Pengambilan_Paket','Pengambilan Paket'],['Produk','Penjualan Produk'],['Paket','Penjualan Paket']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Pilih Satu',
		displayField: 'jenis_display',
		valueField: 'jenis_value',
		width: 200,
		triggerAction: 'all'	
	});
	
	/* Identify  jenis Combo*/
	group_rekap_Field= new Ext.form.ComboBox({
		id: 'group_rekap_Field',
		fieldLabel: 'Group by',
		store: group_produk_Store,
		mode: 'local',
		editable:false,
		displayField: 'group_display',
		valueField: 'group_value',
		width: 120,
		triggerAction: 'all'	
	});
	
	/* Identify  jenis Combo*/
	group_group_Field= new Ext.form.ComboBox({
		id: 'group_group_Field',
		fieldLabel: 'Group 1',
		store: cbo_groupDataStore,
		mode: 'remote',
		editable:false,
		displayField: 'group_group_display',
		valueField: 'group_group_value',
		width: 120,
		disabled: true,
		triggerAction: 'all'	
	});

	/* Identify  jumlah Combo*/
	/*
	jumlahField= new Ext.form.ComboBox({
		id: 'jumlahField',
		fieldLabel: 'Top Rank',
		store:new Ext.data.SimpleStore({
			fields:['jumlah_value', 'jumlah_display'],
			data:[['5','5'],['10','10'],['15','15'],['20','20'],['25','25'],['30','30'],['35','35'],['40','40'],['45','45'],['50','50']]
		}),
		mode: 'local',
		editable:false,
		emptyText: '10',
		displayField: 'jumlah_display',
		valueField: 'jumlah_value',
		width: 50,
		triggerAction: 'all'	
	});
	*/
	
	/* Function for retrieve create Window Form */
	rekap_penjualan_createWindow= new Ext.Window({
		id: 'rekap_penjualan_createWindow',
		title: post2db+'Tindakan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_rekap_penjualan_create',
		items: rekap_penjualan_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function rekap_penjualan_search(){
		// render according to a SQL date format.
		// KIRIM
		if(is_rekap_penjualan_searchForm_valid())
		{
			
			if (jenis_rekap_Field.getValue() !== 'Perawatan') 
			{
				sum_voucherColumnModel.setHidden(8,true);
				sum_voucherColumnModel.setHidden(9,false);
				sum_voucherColumnModel.setColumnHeader(9,'Voucher (Rp)');
			} else if (jenis_rekap_Field.getValue() == 'Perawatan') 
			{
				sum_voucherColumnModel.setHidden(8,false);
				sum_voucherColumnModel.setHidden(9,false);
				sum_voucherColumnModel.setColumnHeader(9,'Voucher Non Medis (Rp)');
			}
		
		var rekap_penjualan_tgl_start_app_search=null;
		var rekap_penjualan_tgl_end_app_search=null;
		var jenis_rekap_Field_search=null;
		var group_rekap_Field_search=null;
		var group_group_Field_search=null;

		if(Ext.getCmp('rekap_penjualan_tglStartSearchField').getValue()!==null){rekap_penjualan_tgl_start_app_search=Ext.getCmp('rekap_penjualan_tglStartSearchField').getValue();}
		if(Ext.getCmp('rekap_penjualan_tglEndSearchField').getValue()!==null){rekap_penjualan_tgl_end_app_search=Ext.getCmp('rekap_penjualan_tglEndSearchField').getValue();}
		if(jenis_rekap_Field.getValue()!==null){jenis_rekap_Field_search=jenis_rekap_Field.getValue();}
		if(group_rekap_Field.getValue()!==null){group_rekap_Field_search=group_rekap_Field.getValue();}
		if(group_group_Field.getValue()!==null){group_group_Field_search=group_group_Field.getValue();}
		// change the store parameters
		rekap_penjualanDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			rekap_penjualan_tglapp_start	: 	rekap_penjualan_tgl_start_app_search,
			rekap_penjualan_tglapp_end		: 	rekap_penjualan_tgl_end_app_search,
			rekap_penjualan_jenis			:	jenis_rekap_Field_search,
			rekap_penjualan_group			:	group_rekap_Field_search,
			rekap_penjualan_group_1			:	group_group_Field_search,
		};
		
		sum_rekapDataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			rekap_penjualan_tglapp_start	: 	rekap_penjualan_tgl_start_app_search,
			rekap_penjualan_tglapp_end		: 	rekap_penjualan_tgl_end_app_search,
			rekap_penjualan_jenis			:	jenis_rekap_Field_search,
			rekap_penjualan_group			:	group_rekap_Field_search,
			rekap_penjualan_group_1			:	group_group_Field_search,
		};
		
		sum_voucherDataStore.baseParams = {
			task: 'SEARCH3',
			//variable here
			rekap_penjualan_tglapp_start	: 	rekap_penjualan_tgl_start_app_search,
			rekap_penjualan_tglapp_end		: 	rekap_penjualan_tgl_end_app_search,
			rekap_penjualan_jenis			:	jenis_rekap_Field_search,
			rekap_penjualan_group			:	group_rekap_Field_search,
			rekap_penjualan_group_1			:	group_group_Field_search,
		};
		
		// Cause the datastore to do another query : 
		rekap_penjualanDataStore.reload({params: {start: 0, limit: pageS}});
		sum_rekapDataStore.reload({params: {start: 0, limit: pageS}});
		sum_voucherDataStore.reload({params: {start: 0, limit: pageS}});
		
		}
		
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal awal belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}

		
	}
		
	/* Function for reset search result */
	function rekap_penjualan_reset_search(){
		// reset the store parameters
		rekap_penjualanDataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		rekap_penjualanDataStore.reload({params: {start: 0, limit: pageS}});
		rekap_penjualan_searchWindow.close();
	};
	/* End of Fuction */
	

	var dt = new Date(); 
	
	/* Function for retrieve search Form Panel */
	rekap_penjualan_searchForm = new Ext.FormPanel({
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
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.55,
							labelWidth:100,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									//fieldLabel: 'Tanggal Tindakan',
									fieldLabel: 'Tanggal',
							        name: 'rekap_penjualan_tglStartSearchField',
							        id: 'rekap_penjualan_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        endDateField: 'rekap_penjualan_tglEndSearchField' // id of the end date field Ext.getCmp('top_spender_tglStartSearchField').isValid()
							    }] 
						},
						{
							columnWidth:0.40,
							layout: 'form',
							labelWidth:30,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'rekap_penjualan_tglEndSearchField',
							        id: 'rekap_penjualan_tglEndSearchField',
							        vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
									value : today,
							        startDateField: 'rekap_penjualan_tglStartSearchField' // id of the end date field
							    }] 
						}]},
						jenis_rekap_Field, group_rekap_Field, group_group_Field]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				//handler: tindakan_medislist_search
				handler: rekap_penjualan_search
			},{
				text: 'Close',
				handler: function(){
					rekap_penjualan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function rekap_penjualan_reset_formSearch(){
		jenis_rekap_Field.reset();
		jenis_rekap_Field.setValue(null);
		group_rekap_Field.reset();
		group_rekap_Field.setValue(null);
		group_group_Field.reset();
		group_group_Field.setValue(null);
		//jumlahField.reset();
		//jumlahField.setValue(null);
		Ext.getCmp('rekap_penjualan_tglStartSearchField').reset();
		Ext.getCmp('rekap_penjualan_tglStartSearchField').setValue(null);
		Ext.getCmp('rekap_penjualan_tglEndSearchField').reset();
		Ext.getCmp('rekap_penjualan_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	rekap_penjualan_searchWindow = new Ext.Window({
		title: 'Pencarian Rekap Penjualan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rekap_penjualan_search',
		items: rekap_penjualan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!rekap_penjualan_searchWindow.isVisible()){
			//rekap_penjualan_reset_formSearch();
			//jenis_rekap_Field.setValue('Produk');
			//group_rekap_Field.setValue('Kode');
			//jumlahField.setValue('10');
			rekap_penjualan_searchWindow.show();
		} else {
			rekap_penjualan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function tindakan_medisprint(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(top_spenderDataStore.baseParams.query!==null){searchquery = top_spenderDataStore.baseParams.query;}
		if(top_spenderDataStore.baseParams.trawat_cust!==null){trawat_cust_print = top_spenderDataStore.baseParams.trawat_cust;}
		if(top_spenderDataStore.baseParams.trawat_keterangan!==null){trawat_keterangan_print = top_spenderDataStore.baseParams.trawat_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_report_rekap_penjualan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust : trawat_cust_print,
			trawat_keterangan : trawat_keterangan_print,
		  	currentlisting: top_spenderDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/report_rekap.html','report_rekap','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function produk_print(){
	// KIRIM
		if(is_rekap_penjualan_searchForm_valid())
		{
			var rekap_penjualan_tglapp_start_print=null;
			var rekap_penjualan_tglapp_end_print=null;
			var jenis_rekap_Field_print=null;
			var group_rekap_Field_print=null;
			var group_1_rekap_Field_print=null;
			
			if(rekap_penjualanDataStore.baseParams.rekap_penjualan_tglapp_start!==null){rekap_penjualan_tglapp_start_print = rekap_penjualanDataStore.baseParams.rekap_penjualan_tglapp_start;}
			if(rekap_penjualanDataStore.baseParams.rekap_penjualan_tglapp_end!==null){rekap_penjualan_tglapp_end_print = rekap_penjualanDataStore.baseParams.rekap_penjualan_tglapp_end;}
			if(rekap_penjualanDataStore.baseParams.rekap_penjualan_jenis!==null){jenis_rekap_Field_print = rekap_penjualanDataStore.baseParams.rekap_penjualan_jenis;}
			if(rekap_penjualanDataStore.baseParams.rekap_penjualan_group!==null){group_rekap_Field_print = rekap_penjualanDataStore.baseParams.rekap_penjualan_group;}
			if(rekap_penjualanDataStore.baseParams.rekap_penjualan_group_1!==null){group_1_rekap_Field_print = rekap_penjualanDataStore.baseParams.rekap_penjualan_group_1;}
			
			/*
			if(Ext.getCmp('rekap_penjualan_tglStartSearchField').getValue()!==null){rekap_penjualan_tgl_start_app_search=Ext.getCmp('rekap_penjualan_tglStartSearchField').getValue();}
			if(Ext.getCmp('rekap_penjualan_tglEndSearchField').getValue()!==null){rekap_penjualan_tgl_end_app_search=Ext.getCmp('rekap_penjualan_tglEndSearchField').getValue();}
			if(jenis_rekap_Field.getValue()!==null){jenis_rekap_Field_search=jenis_rekap_Field.getValue();}
			if(group_rekap_Field.getValue()!==null){group_rekap_Field_search=group_rekap_Field.getValue();}
			// change the store parameters
			*/
			// Cause the datastore to do another query : 
			//rekap_penjualanDataStore.reload({params: {start: 0, limit: pageS}});
			//sum_rekapDataStore.reload({params: {start: 0, limit: pageS}});

			Ext.Ajax.request({   
			waitMsg: 'Please Wait...',
			url: 'index.php?c=c_report_rekap_penjualan&m=get_action',
			params: {
				task: "PRINT",
				rekap_penjualan_tglapp_start	: 	rekap_penjualan_tglapp_start_print,
				rekap_penjualan_tglapp_end		: 	rekap_penjualan_tglapp_end_print,
				rekap_penjualan_jenis			:	jenis_rekap_Field_print,
				rekap_penjualan_group			:	group_rekap_Field_print,
				rekap_penjualan_group_1			:	group_1_rekap_Field_print,
				currentlisting					: 	rekap_penjualanDataStore.baseParams.task
			}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./print/report_rekap.html','report_rekap','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
					
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
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function tindakan_medisexport_excel(){
		var searchquery = "";
		var tindakan_dokter_2excel=null;
		//var tindakan_perawatan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(top_spenderDataStore.baseParams.query!==null){searchquery = top_spenderDataStore.baseParams.query;}
		if(top_spenderDataStore.baseParams.trawat_dokter!==null){tindakan_dokter_2excel = top_spenderDataStore.baseParams.trawat_dokter;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_report_rekap_penjualan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_dokter : tindakan_dokter_2excel,
		  	currentlisting: top_spenderDataStore.baseParams.task // this tells us if we are searching or not
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
	rekap_penjualan_searchWindow.show();
});

	// EVENTS
	//jenis_rekap_Field.setValue('Produk');
	jenis_rekap_Field.on("select", function(){
		//jenis_rekap_Field.setValue('Produk');
		jenis_rekap_Field_group=jenis_rekap_Field.getValue();
		if(jenis_rekap_Field_group=='Perawatan'){
			group_rekap_Field.reset();
			group_rekap_Field.bindStore(group_perawatan_Store);
		} 
		else if(jenis_rekap_Field_group=='Produk'){
			group_rekap_Field.reset();
			group_rekap_Field.bindStore(group_produk_Store);
		}
		else if(jenis_rekap_Field_group=='Paket'){
			group_rekap_Field.reset();
			group_rekap_Field.bindStore(group_produk_Store);
		}
		else if(jenis_rekap_Field_group=='Pengambilan_Paket'){
			group_rekap_Field.reset();
			group_rekap_Field.bindStore(group_perawatan_Store);
		}
	});
	
	group_rekap_Field.on("select", function(){
		jenis_rekap_Field_group=jenis_rekap_Field.getValue();
		group_rekap_Field_group=group_rekap_Field.getValue();
		if(group_rekap_Field_group=='Group'){
			group_group_Field.setDisabled(false);	
		} else {
			group_group_Field.setDisabled(true);
			group_group_Field.setValue('Semua');
		}
	});
	/*
	rpt_jproduk_detailField.on("check", function(){
		rpt_jproduk_group_rekap_Field.setValue('No Faktur');
		if(rpt_jproduk_detailField.getValue()==true){
			rpt_jproduk_group_rekap_Field.bindStore(group_detail_Store);
		}else
		{
			rpt_jproduk_group_rekap_Field.bindStore(group_master_Store);
		}
	});
	
	rpt_jproduk_opsitglField.on("check",function(){
		if(rpt_jproduk_opsitglField.getValue()==true){
			rpt_jproduk_tglawalField.allowBlank=false;
			rpt_jproduk_tglakhirField.allowBlank=false;
		}else{
			rpt_jproduk_tglawalField.allowBlank=true;
			rpt_jproduk_tglakhirField.allowBlank=true;
		}
		
	});*/
	</script>
<body>
<div>
	<div class="col">

        <div id="fp_rekap_penjualan"></div>
		<div id="fp_rekap_penjualan3"></div>
		<div id="fp_rekap_penjualan2"></div>
         <div id="fp_top_tindakan_medisdetail"></div>
		 <div id="fp_top_dtindakan_jual_nonmedis"></div>
		<div id="elwindow_rekap_penjualan_create"></div>
        <div id="elwindow_rekap_penjualan_search"></div>
    </div>
</div>
</body>