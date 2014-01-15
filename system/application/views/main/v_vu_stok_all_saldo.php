<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: vu_stok_all_saldo View
	+ Description	: For record view
	+ Filename 		: v_vu_stok_all_saldo.php
 	+ creator  		:
 	+ Created on 09/Apr/2010 10:47:15

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
/* declare function */
var vu_stok_all_saldo_DataStore;
var vu_stok_all_saldo_ColumnModel;
var vu_stok_all_saldoListEditorGrid;
var vu_stok_all_saldo_saveForm;
var vu_stok_all_saldo_saveWindow;
var vu_stok_all_saldo_searchForm;
var vu_stok_all_saldo_searchWindow;
var vu_stok_all_saldo_SelectedRow;
var vu_stok_all_saldo_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
/* declare variable here for Field*/
var produk_idField;
var produk_namaField;
var satuan_idField;
var satuan_namaField;
var stok_saldoField;
var produk_idSearchField;
var produk_namaSearchField;
var satuan_idSearchField;
var satuan_namaSearchField;
var stok_saldoSearchField;
var stok_bulanField;


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

  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('produk_id');
		else
			return 0;
	}
	/* End of Function  */
	/* setValue to EDIT */
	function vu_stok_all_saldo_set_form(){
		var nama_bulan='';
	
		if(stok_opsitglField.getValue()==true){
			produk_periodeField.setValue(Ext.getCmp('stok_tanggal_startSearchField').getValue().format('Y-m-d') + " s/d " + Ext.getCmp('stok_tanggal_endSearchField').getValue().format('Y-m-d'));
			vu_stok_detail_DataStore.setBaseParam('periode','tanggal');
		}else if(stok_opsiblnField.getValue()==true){
			if (stok_bulanField.getValue() == '01') {
				nama_bulan='Januari'
			}else if(stok_bulanField.getValue() == '02') {
				nama_bulan='Februari'
			}else if(stok_bulanField.getValue() == '03') {
				nama_bulan='Maret'
			}else if(stok_bulanField.getValue() == '01') {
				nama_bulan='April'
			}else if(stok_bulanField.getValue() == '05') {
				nama_bulan='Mei'
			}else if(stok_bulanField.getValue() == '06') {
				nama_bulan='Juni'
			}else if(stok_bulanField.getValue() == '07') {
				nama_bulan='Juli'
			}else if(stok_bulanField.getValue() == '08') {
				nama_bulan='Agustus'
			}else if(stok_bulanField.getValue() == '09') {
				nama_bulan='September'
			}else if(stok_bulanField.getValue() == '10') {
				nama_bulan='Oktober'
			}else if(stok_bulanField.getValue() == '11') {
				nama_bulan='November'
			}else if(stok_bulanField.getValue() == '12') {
				nama_bulan='Desember'
			}

			produk_periodeField.setValue(nama_bulan + " " +  stok_tahunField.getValue());
			vu_stok_detail_DataStore.setBaseParam('periode','bulan');
		}else{
			//stok_tmedis_periode='all';
			vu_stok_detail_DataStore.setBaseParam('periode','all');
		}
	
		
		produk_kodeField.setValue(vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('produk_kode'));
		produk_namaField.setValue(vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('produk_nama'));
		satuan_namaField.setValue(vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('satuan_nama'));
		stok_saldoField.setValue(vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('stok_saldo'));
		vu_stok_detail_DataStore.setBaseParam('start',0);
		vu_stok_detail_DataStore.setBaseParam('limit',pageS);
		if(vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('konversi_default')==true)
			vu_stok_detail_DataStore.setBaseParam('satuan','default');
		else
			vu_stok_detail_DataStore.setBaseParam('satuan','terkecil');

		vu_stok_detail_DataStore.setBaseParam('produk_id',get_pk_id());
		vu_stok_detail_DataStore.setBaseParam('tanggal_start',vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('tanggal_start').format('Y-m-d'));
		vu_stok_detail_DataStore.setBaseParam('tanggal_end',vu_stok_all_saldoListEditorGrid.getSelectionModel().getSelected().get('tanggal_end').format('Y-m-d'));
		vu_stok_detail_DataStore.load();

	}
	/* End setValue to EDIT*/

	var stok_tanggal_startField=new Ext.form.DateField({
		id: 'stok_tanggal_startField',
		name: 'stok_tanggal_startField',
		value: firstday,
		format: 'Y-m-d'
	});

	var stok_tanggal_endField=new Ext.form.DateField({
		id: 'stok_tanggal_endField',
		name: 'stok_tanggal_endField',
		value: today,
		format: 'Y-m-d'
	});


	/* Function for Update Confirm */
	function vu_stok_all_saldo_confirm_update(){
		/* only one record is selected here */
		if(vu_stok_all_saldoListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			vu_stok_all_saldo_set_form();
			vu_stok_all_saldo_saveWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

	/* Function for Retrieve DataStore */
	vu_stok_all_saldo_DataStore = new Ext.data.Store({
		id: 'vu_stok_all_saldo_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_vu_stok_all_saldo&m=get_action',
			method: 'POST',
			timeout: 3600000
		}),
		baseParams:{task: "LIST", start:0, limit: pageS, tanggal_start: firstday, tanggal_end: today}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'tanggal_start', type: 'date', formatDate:'Y-m-d', mapping: 'tanggal_start'},
			{name: 'tanggal_end', type: 'date', formatDate:'Y-m-d', mapping: 'tanggal_end'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'stok_awal', type: 'float', mapping: 'stok_awal'},
			{name: 'jumlah_terima', type: 'float', mapping: 'jumlah_terima'},
			{name: 'jumlah_retur_beli', type: 'float', mapping: 'jumlah_retur_beli'},
			{name: 'jumlah_jual', type: 'float', mapping: 'jumlah_jual'},
			{name: 'jumlah_retur_produk', type: 'float', mapping: 'jumlah_retur_produk'},
			{name: 'jumlah_retur_paket', type: 'float', mapping: 'jumlah_retur_paket'},
			{name: 'jumlah_cabin', type: 'float', mapping: 'jumlah_cabin'},
			{name: 'jumlah_koreksi', type: 'float', mapping: 'jumlah_koreksi'},
			{name: 'stok_saldo', type: 'float', mapping: 'stok_saldo'}
		]),
		sortInfo:{field: 'produk_id', direction: "DESC"}
	});
	/* End of Function */

  	/* Function for Identify of Window Column Model */
	vu_stok_all_saldo_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'produk_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">Kode</div>',
			dataIndex: 'produk_kode',
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Nama</div>',
			dataIndex: 'produk_nama',
			width: 350,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'satuan_nama',
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Stok Awal</div>',
			dataIndex: 'stok_awal',
			width: 150,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Beli</div>',
			dataIndex: 'jumlah_terima',
			width: 150,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Retur Beli</div>',
			dataIndex: 'jumlah_retur_beli',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		},
		{
			header: '<div align="center">Jual</div>',
			dataIndex: 'jumlah_jual',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		},
		{
			header: '<div align="center">Retur Jual</div>',
			dataIndex: 'jumlah_retur_produk',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		},
		{
			header: '<div align="center">Pakai Cabin</div>',
			dataIndex: 'jumlah_cabin',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		},
		{
			header: '<div align="center">Koreksi</div>',
			dataIndex: 'jumlah_koreksi',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		},
		{
			header: '<div align="center">Stok Akhir</div>',
			dataIndex: 'stok_saldo',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			readOnly: true
		}
		]);

	vu_stok_all_saldo_ColumnModel.defaultSortable= true;
	/* End of Function */

	function periode_stok(){
		vu_stok_all_saldo_DataStore.setBaseParam('tanggal_start',stok_tanggal_startField.getValue().format('Y-m-d'));
		vu_stok_all_saldo_DataStore.setBaseParam('tanggal_end',stok_tanggal_endField.getValue().format('Y-m-d'));
		vu_stok_all_saldo_DataStore.load();
	}

	/* Declare DataStore and  show datagrid list */
	vu_stok_all_saldoListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'vu_stok_all_saldoListEditorGrid',
		el: 'fp_vu_stok_all_saldo',
		title: 'Laporan Stok Akhir',
		autoHeight: true,
		store: vu_stok_all_saldo_DataStore, // DataStore
		cm: vu_stok_all_saldo_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: vu_stok_all_saldo_DataStore,
			displayInfo: true
		}),
		tbar: [
		{
			text: 'View Detail',
			tooltip: 'View selected record',
			iconCls:'icon-update',
			handler: vu_stok_all_saldo_confirm_update   // Confirm before updating
		},'-',{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		},'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: vu_stok_all_saldo_reset_search,
			iconCls:'icon-refresh'
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: vu_stok_all_saldo_print
		}
		]
	});
	vu_stok_all_saldoListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	vu_stok_all_saldo_ContextMenu = new Ext.menu.Menu({
		id: 'vu_stok_all_saldo_ListEditorGridContextMenu',
		items: [
		{
			text: 'View', tooltip: 'View selected record',
			iconCls:'icon-update',
			handler: vu_stok_all_saldo_confirm_update
		},
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: vu_stok_all_saldo_print
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onvu_stok_all_saldo_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		vu_stok_all_saldo_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		vu_stok_all_saldo_SelectedRow=rowIndex;
		vu_stok_all_saldo_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function vu_stok_all_saldo_editContextMenu(){
		//vu_stok_all_saldoListEditorGrid.startEditing(vu_stok_all_saldo_SelectedRow,1);
		vu_stok_all_saldo_confirm_update();
  	}
	/* End of Function */

	vu_stok_all_saldoListEditorGrid.addListener('rowcontextmenu', onvu_stok_all_saldo_ListEditGridContextMenu);

	/* Identify  produk_id Field */
	produk_idField= new Ext.form.NumberField({
		id: 'produk_idField',
		fieldLabel: 'Produk Id',
		allowNegatife : false,
		blankText: '0',
		readOnly: true,
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  produk_nama Field */
	produk_kodeField= new Ext.form.TextField({
		id: 'produk_kodeField',
		fieldLabel: 'Kode',
		maxLength: 250,
		allowBlank: false,
		readOnly: true,
		anchor: '95%'
	});

	produk_periodeField= new Ext.form.TextField({
		id: 'produk_periodeField',
		fieldLabel: 'Periode',
		maxLength: 250,
		allowBlank: false,
		readOnly: true,
		anchor: '95%'
	});

	produk_namaField= new Ext.form.TextField({
		id: 'produk_namaField',
		fieldLabel: 'Nama',
		maxLength: 250,
		allowBlank: false,
		readOnly: true,
		anchor: '95%'
	});

	/* Identify  satuan_id Field */
	satuan_idField= new Ext.form.NumberField({
		id: 'satuan_idField',
		fieldLabel: 'Satuan Id',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		readOnly: true,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  satuan_nama Field */
	satuan_namaField= new Ext.form.TextField({
		id: 'satuan_namaField',
		fieldLabel: 'Satuan',
		maxLength: 250,
		readOnly: true,
		allowBlank: false,
		anchor: '95%'
	});

	/* Identify  stok_saldo Field */
	stok_saldoField= new Ext.form.NumberField({
		id: 'stok_saldoField',
		fieldLabel: 'Stok Saldo',
		allowNegatife : false,
		readOnly: true,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});



	/* Function for Retrieve DataStore */
	vu_stok_detail_DataStore = new Ext.data.Store({
		id: 'vu_stok_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_vu_stok_all_saldo&m=get_detail_stok',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'gudang_id', type: 'int', mapping: 'gudang_id'},
			{name: 'jumlah_awal', type: 'float', mapping: 'jumlah_awal'},
			{name: 'jumlah_in', type: 'float', mapping: 'jumlah_masuk'},
			{name: 'jumlah_out', type: 'float', mapping: 'jumlah_keluar'},
			{name: 'jumlah_koreksi', type: 'float', mapping: 'jumlah_koreksi'},
			{name: 'gudang_nama', type: 'string', mapping: 'gudang_nama'},
			{name: 'jumlah_stok', type: 'float', mapping: 'jumlah_stok'}
		]),
		sortInfo:{field: 'gudang_id', direction: "ASC"}
	});
	/* End of Function */

	/* Function for Retrieve DataStore */
	produk_DataStore = new Ext.data.Store({
		id: 'produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_hpp&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_jenis', type: 'string', mapping: 'produk_jenis'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'produk_id', direction: "DESC"}
	});
	/* End of Function */
	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Satuan: {satuan_nama}',
        '</div></tpl>'
    );

	/* Function for Retrieve DataStore */
	stok_group_DataStore = new Ext.data.Store({
		id: 'stok_group_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_vu_stok_all_saldo&m=get_group_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
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
	
	vu_stok_detail_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'gudang_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: false
		},
		{
			header: '<div align="center">Gudang</div>',
			dataIndex: 'gudang_nama',
			width: 200,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Stok Awal</div>',
			dataIndex: 'jumlah_awal',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Masuk</div>',
			dataIndex: 'jumlah_in',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Keluar</div>',
			dataIndex: 'jumlah_out',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 150,
			sortable: true,
			readOnly: true
		},{
			header: '<div align="center">Koreksi</div>',
			dataIndex: 'jumlah_koreksi',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Stok Akhir</div>',
			dataIndex: 'jumlah_stok',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 150,
			sortable: true,
			readOnly: true
		}]);

	vu_stok_detail_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	vu_stok_detailListEditorGrid =  new Ext.grid.GridPanel({
		id: 'vu_stok_detailListEditorGrid',
		el: 'fp_vu_stok_detail',
		title: 'Stok Gudang',
		autoHeight: true,
		store: vu_stok_detail_DataStore, // DataStore
		cm: vu_stok_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 590,
		height: 200,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: vu_stok_detail_DataStore,
			displayInfo: true
		})
	});

	/* Function for retrieve create Window Panel*/
	vu_stok_all_saldo_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,
		items:[
			{
				columnWidth:0,
				layout: 'form',
				border:false,
				items: [produk_periodeField,produk_kodeField,produk_namaField,satuan_namaField,stok_saldoField,vu_stok_detailListEditorGrid]
			}
			],
		buttons: [{
				text: 'Close',
				handler: function(){
					vu_stok_all_saldo_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	vu_stok_all_saldo_saveWindow= new Ext.Window({
		id: 'vu_stok_all_saldo_saveWindow',
		title:'Kartu Stok',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_vu_stok_all_saldo_save',
		items: vu_stok_all_saldo_saveForm
	});
	/* End Window */

	/* Function for action list search */
	function vu_stok_all_saldo_list_search(){
		// render according to a SQL date format.
		var produk_nama_search=null;
		var tanggal_start_search="";
		var tanggal_end_search="";
		var opsi_satuan_search='default';
		var opsi_produk_search='all';
		var group_nama_search=null;
		var stok_tmedis_bulan=null;
		var stok_tmedis_tahun=null;
		var stok_tmedis_periode=null;
 
		if(stok_produk_namaSearchField.getValue()!==null){produk_nama_search=stok_produk_namaSearchField.getValue();}
		if(stok_group1SearchField.getValue()!==null){group_nama_search=stok_group1SearchField.getValue();}
		if(stok_bulanField.getValue()!==null){stok_tmedis_bulan=stok_bulanField.getValue();}
		if(stok_tahunField.getValue()!==null){stok_tmedis_tahun=stok_tahunField.getValue();}
		if(stok_produk_allField.getValue()==true){ produk_nama_search=null; }
		if(Ext.getCmp('stok_tanggal_startSearchField').getValue()!==null){tanggal_start_search=Ext.getCmp('stok_tanggal_startSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('stok_tanggal_endSearchField').getValue()!==null){tanggal_end_search=Ext.getCmp('stok_tanggal_endSearchField').getValue().format('Y-m-d');}
		if(stok_satuan_terkecilField.getValue()==true){ opsi_satuan_search='terkecil'; }else{ opsi_satuan_search='default'; }
		
		if(stok_produk_allField.getValue()==true){ 
			opsi_produk_search='all';
		}else if(stok_produk_selectField.getValue()==true){
			opsi_produk_search='produk';
		}else if(stok_group_selectField.getValue()==true){
			opsi_produk_search='group1';
		}
		
		if(stok_opsitglField.getValue()==true){
			stok_tmedis_periode='tanggal';
		}else if(stok_opsiblnField.getValue()==true){
			stok_tmedis_periode='bulan';
		}else{
			stok_tmedis_periode='all';
		}

		// change the store parameters
		vu_stok_all_saldo_DataStore.baseParams = {
			task			: 'LIST',
			produk_id		:	produk_nama_search,
			tanggal_start	:	tanggal_start_search,
			tanggal_end		:	tanggal_end_search,
			opsi_satuan		: 	opsi_satuan_search,
			opsi_produk		: 	opsi_produk_search,
			group1_id		: 	group_nama_search,
			bulan		: stok_tmedis_bulan,
			tahun		: stok_tmedis_tahun,
			periode		: stok_tmedis_periode
		};

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, silakan tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});

		// Cause the datastore to do another query :
		vu_stok_all_saldo_DataStore.reload({
			params: {start: 0, limit: pageS},
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});
	}

	/* Function for reset search result */
	function vu_stok_all_saldo_reset_search(){
		// reset the store parameters
		vu_stok_all_saldo_DataStore.baseParams = { task: 'LIST', start:0 , limit: pageS };
		vu_stok_all_saldo_DataStore.reload({params: {start: 0, limit: pageS}});
		Ext.getCmp('stok_tanggal_startSearchField').reset();
		Ext.getCmp('stok_tanggal_startSearchField').setValue(today);
		Ext.getCmp('stok_tanggal_endSearchField').reset();
		Ext.getCmp('stok_tanggal_endSearchField').setValue(today);
		vu_stok_all_saldo_searchWindow.close();
	};
	/* End of Fuction */

	/* Field for search */
	/* Identify  produk_id Search Field */
		stok_produk_idSearchField= new Ext.form.NumberField({
		id: 'stok_produk_idSearchField',
		fieldLabel: 'Produk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  stok_produk_nama Search Field */
	stok_produk_namaSearchField= new Ext.form.ComboBox({
		id: 'stok_produk_namaSearchField',
		fieldLabel: '-',
		store: produk_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'produk_nama',
		valueField: 'produk_id',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		enableKeyEvents: true,
		tpl: produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		width: 300

	});

	var stok_group_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{group_nama} ({group_kode})</b></span>',
        '</div></tpl>'
    );
	
	stok_group1SearchField= new Ext.form.ComboBox({
		id: 'stok_group1SearchField',
		fieldLabel: '-',
		store: stok_group_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'group_nama',
		valueField: 'group_id',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		enableKeyEvents: true,
		tpl: stok_group_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		width: 300
	
	});
	
	
	
	/////tgl n bulan
	stok_opsitglField=new Ext.form.Radio({
		id:'stok_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	stok_opsiblnField=new Ext.form.Radio({
		id:'stok_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	stok_tanggal_startSearchField= new Ext.form.DateField({
		id: 'stok_tanggal_startSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'stok_tanggal_startSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'stok_tglakhirField'
		value: firstday
	});
	
	stok_tanggal_endSearchField= new Ext.form.DateField({
		id: 'stok_tanggal_endSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'stok_tanggal_endSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'stok_tglawalField',
		value: today
	});
	
	stok_bulanField=new Ext.form.ComboBox({
		id:'stok_bulanField',
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
	
	stok_tahunField=new Ext.form.ComboBox({
		id:'stok_tahunField',
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
	
	var stok_periodeField=new Ext.form.FieldSet({
		id:'stok_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[stok_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[stok_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[stok_tanggal_startSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[stok_tanggal_endSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[stok_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[stok_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[stok_tahunField]
					   }]
			}]
	});
	//// end of tgl n bulan

	stok_produk_allField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Semua',
		checked: true,
		width: 100
	});

	stok_produk_selectField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Produk',
		checked: true,
		width: 100
	});
	
	stok_group_selectField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Group 1',
		width: 100
	});

	stok_satuan_terkecilField=new Ext.form.Radio({
		name:'opsi_satuan',
		boxLabel: 'Satuan Terkecil',
		width: 100
	});

	stok_satuan_defaultField=new Ext.form.Radio({
		name:'opsi_satuan',
		boxLabel: 'Satuan Default',
		checked: true,
		width: 100
	});

	stok_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});

	stok_produk_opsiSearchField=new Ext.form.FieldSet({
		id:'stok_produk_opsiSearchField',
		title: 'Opsi Produk',
		layout: 'form',
		frame: false,
		bodyStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [stok_produk_allField]
			   },
			   {
				   layout	: 'column',
				   bodyStyle: 'padding-bottom: 5px;',
				   border: false,
				   items	: [stok_produk_selectField,stok_produk_namaSearchField]
			   },
			    {
			   		layout	: 'column',
					bodyStyle: 'padding-bottom: 5px;',
					border: false,
					items	: [stok_group_selectField, stok_group1SearchField]
			   }

		]
	});

	stok_satuan_opsiSearchField=new Ext.form.FieldSet({
		id:'stok_satuan_opsiSearchField',
		title: 'Opsi Satuan',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [stok_satuan_defaultField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [stok_satuan_terkecilField]
			   }

		]
	});

	/* Function for retrieve search Form Panel */
	vu_stok_all_saldo_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth: 1,
				layout: 'form',
				border:false,
				items: [stok_produk_opsiSearchField,stok_satuan_opsiSearchField, stok_periodeField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: vu_stok_all_saldo_list_search
			},{
				text: 'Close',
				handler: function(){
					vu_stok_all_saldo_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	vu_stok_all_saldo_searchWindow = new Ext.Window({
		title: 'Pencarian Stok Akhir',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_vu_stok_all_saldo_search',
		items: vu_stok_all_saldo_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!vu_stok_all_saldo_searchWindow.isVisible()){
			vu_stok_all_saldo_searchWindow.show();
		} else {
			vu_stok_all_saldo_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function vu_stok_all_saldo_print(){
		var searchquery = "";
		var produk_id_print=null;
		var tanggal_start_print=null;
		var tanggal_end_print=null;
		var opsi_satuan=null;
		var win;

		// check if we do have some search data...
		if(vu_stok_all_saldo_DataStore.baseParams.query!==null){searchquery = vu_stok_all_saldo_DataStore.baseParams.query;}
		if(vu_stok_all_saldo_DataStore.baseParams.produk_id!==null){produk_id_print = vu_stok_all_saldo_DataStore.baseParams.produk_id;}
		if(vu_stok_all_saldo_DataStore.baseParams.tanggal_start!==null){tanggal_start_print = vu_stok_all_saldo_DataStore.baseParams.tanggal_start;}
		if(vu_stok_all_saldo_DataStore.baseParams.tanggal_end!==null){tanggal_end_print = vu_stok_all_saldo_DataStore.baseParams.tanggal_end;}
		if(vu_stok_all_saldo_DataStore.baseParams.opsi_produk!==null){opsi_produk_print = vu_stok_all_saldo_DataStore.baseParams.opsi_produk;}
		if(vu_stok_all_saldo_DataStore.baseParams.opsi_satuan!==null){opsi_satuan_print = vu_stok_all_saldo_DataStore.baseParams.opsi_satuan;}

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, silakan tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		timeout: 3600000,
		url: 'index.php?c=c_vu_stok_all_saldo&m=get_action',
		params: {
			task			: "PRINT",
		  	query			: searchquery,
			produk_id		: produk_nama_print,
			tanggal_start	: tanggal_start_print,
			tanggal_end		: tanggal_end_print,
			opsi_satuan		: opsi_satuan_print,
			opsi_produk		: opsi_produk_print,
		  	currentlisting	: vu_stok_all_saldo_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				Ext.MessageBox.hide();
				win = window.open('./print/stok_akhir_printlist.html','stok_akhir_printlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');

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
	function vu_stok_all_saldo_export_excel(){
		var searchquery = "";
		var produk_id_2excel=null;
		var produk_nama_2excel=null;
		var satuan_id_2excel=null;
		var satuan_nama_2excel=null;
		var stok_saldo_2excel=null;
		var win;
		// check if we do have some search data...
		if(vu_stok_all_saldo_DataStore.baseParams.query!==null){searchquery = vu_stok_all_saldo_DataStore.baseParams.query;}
		if(vu_stok_all_saldo_DataStore.baseParams.produk_id!==null){produk_id_2excel = vu_stok_all_saldo_DataStore.baseParams.produk_id;}
		if(vu_stok_all_saldo_DataStore.baseParams.produk_nama!==null){produk_nama_2excel = vu_stok_all_saldo_DataStore.baseParams.produk_nama;}
		if(vu_stok_all_saldo_DataStore.baseParams.satuan_id!==null){satuan_id_2excel = vu_stok_all_saldo_DataStore.baseParams.satuan_id;}
		if(vu_stok_all_saldo_DataStore.baseParams.satuan_nama!==null){satuan_nama_2excel = vu_stok_all_saldo_DataStore.baseParams.satuan_nama;}
		if(vu_stok_all_saldo_DataStore.baseParams.stok_saldo!==null){stok_saldo_2excel = vu_stok_all_saldo_DataStore.baseParams.stok_saldo;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_vu_stok_all_saldo&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_id : produk_id_2excel,
			produk_nama : produk_nama_2excel,
			satuan_id : satuan_id_2excel,
			satuan_nama : satuan_nama_2excel,
			stok_saldo : stok_saldo_2excel,
		  	currentlisting: vu_stok_all_saldo_DataStore.baseParams.task // this tells us if we are searching or not
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

	vu_stok_all_saldo_searchWindow.show();
	
	stok_opsitglField.on("check",function(){
		if(stok_opsitglField.getValue()==true){
			stok_tanggal_startSearchField.allowBlank=false;
			stok_tanggal_endSearchField.allowBlank=false;
		}else{
			stok_tanggal_startSearchField.allowBlank=true;
			stok_tanggal_endSearchField.allowBlank=true;
		}
		
	});
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_vu_stok_all_saldo"></div>
         <div id="fp_vu_stok_detail"></div>
		<div id="elwindow_vu_stok_all_saldo_save"></div>
        <div id="elwindow_vu_stok_all_saldo_search"></div>
    </div>
</div>
</body>
</html>