<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: hpp View
	+ Description	: For record view
	+ Filename 		: v_hpp.php
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
var hpp_DataStore;
var hpp_ColumnModel;
var hppListEditorGrid;
var hpp_saveForm;
var hpp_saveWindow;
var hpp_searchForm;
var hpp_searchWindow;
var hpp_SelectedRow;
var hpp_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=12;

/* declare variable here for Field*/
var hpp_produk_idField;
var hpp_produk_namaField;
var satuan_idField;
var satuan_namaField;
var hpp_saldoField;
var hpp_produk_idSearchField;
var hpp_produk_namaSearchField;
var satuan_idSearchField;
var satuan_namaSearchField;
var hpp_saldoSearchField;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';

<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
?>

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return hppListEditorGrid.getSelectionModel().getSelected().get('hpp_produk_id');
		else 
			return 0;
	}
	/* End of Function  */
	/* setValue to EDIT */
	function hpp_set_form(){
		hpp_produk_kodeField.setValue(hppListEditorGrid.getSelectionModel().getSelected().get('hpp_produk_kode'));
		hpp_produk_namaField.setValue(hppListEditorGrid.getSelectionModel().getSelected().get('hpp_produk_nama'));
		satuan_namaField.setValue(hppListEditorGrid.getSelectionModel().getSelected().get('satuan_nama'));
		hpp_saldoField.setValue(hppListEditorGrid.getSelectionModel().getSelected().get('hpp_saldo'));
	}
	/* End setValue to EDIT*/
  
 
 	function hpp_reset_form(){
		hpp_produk_namaSearchField.reset();
		hpp_produk_namaSearchField.setValue(null);		
	}
	
	/* Function for Update Confirm */
	function hpp_confirm_update(){
		/* only one record is selected here */
		if(hppListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			hpp_set_form();
			hpp_saveWindow.show();
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
  
  	var summary = new Ext.ux.grid.GroupSummary();
	/* Function for Retrieve DataStore */
	hpp_DataStore = new Ext.data.Store({
		id: 'hpp_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_hpp&m=get_action', 
			method: 'POST',
			timeout: 360000,
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS, produk_id: 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'hpp_id'
		},[
			{name: 'hpp_bulan', type: 'string', mapping: 'hpp_bulan'}, 
			{name: 'hpp_produk_id', type: 'int', mapping: 'produk_id'}, 
			{name: 'hpp_produk_nama', type: 'string', mapping: 'produk_nama'}, 
			{name: 'hpp_produk_kode', type: 'string', mapping: 'produk_kode'}, 
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'}, 
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'}, 
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}, 
			{name: 'hpp_qty_awal', type: 'float', mapping: 'hpp_qty_awal'}, 
			{name: 'hpp_nilai_awal', type: 'float', mapping: 'hpp_nilai_awal'},
			{name: 'hpp_qty_masuk', type: 'float', mapping: 'hpp_qty_masuk'}, 
			{name: 'hpp_nilai_masuk', type: 'float', mapping: 'hpp_nilai_masuk'},
			{name: 'hpp_qty_keluar', type: 'float', mapping: 'hpp_qty_keluar'}, 
			{name: 'hpp_nilai_keluar', type: 'float', mapping: 'hpp_nilai_keluar'}, 
			{name: 'hpp_nilai_keluar_satuan', type: 'float', mapping: 'hpp_nilai_keluar_satuan'},
			{name: 'hpp_qty_akhir', type: 'float', mapping: 'hpp_qty_akhir'}, 
			{name: 'hpp_nilai_akhir', type: 'float', mapping: 'hpp_nilai_akhir'}, 			
		]),
		sortInfo:{field: 'hpp_produk_id', direction: "ASC"}
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
	
  	/* Function for Identify of Window Column Model */
	hpp_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Kode</div>',
			dataIndex: 'hpp_produk_kode',
			width: 80,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Nama Produk</div>',
			dataIndex: 'hpp_produk_nama',
			width: 200,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'satuan_nama',
			width: 50,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Bulan</div>',
			dataIndex: 'hpp_bulan',
			align: 'right',
			width: 40,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Stok Awal</div>',
			dataIndex: 'hpp_qty_awal',
			width: 60,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Nilai (Rp)</div>',
			dataIndex: 'hpp_nilai_awal',
			width: 100,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Pembelian</div>',
			dataIndex: 'hpp_qty_masuk',
			width: 60,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Nilai (Rp)</div>',
			dataIndex: 'hpp_nilai_masuk',
			width: 100,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Penjualan</div>',
			dataIndex: 'hpp_qty_keluar',
			width: 60,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Total HPP (Rp)</div>',
			dataIndex: 'hpp_nilai_keluar',
			width: 100,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},{
			header: '<div align="center">HPP Satuan (Rp)</div>',
			dataIndex: 'hpp_nilai_keluar_satuan',
			width: 100,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Stok Akhir</div>',
			dataIndex: 'hpp_qty_akhir',
			width: 60,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Nilai (Rp)</div>',
			dataIndex: 'hpp_nilai_akhir',
			width: 100,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		}
		
		]);
	
	hpp_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	hpp_tahunSearchField=new Ext.form.ComboBox({
		id:'hpp_tahunSearchField',
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

	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Satuan: {satuan_nama}',
        '</div></tpl>'
    );
	
	
	var hpp_produk_kode_filterField=new Ext.form.ComboBox({
		id: 'hpp_produk_kode_filterField',
		name: 'hpp_produk_kode_filterField',
		fieldLabel: 'Produk',
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
	
	/* Declare DataStore and  show datagrid list */
	hppListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'hppListEditorGrid',
		el: 'fp_hpp',
		title: 'Harga Pokok Penjualan',
		autoHeight: true,
		store: hpp_DataStore, // DataStore
		cm: hpp_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1305,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: hpp_DataStore,
			displayInfo: true
		}),
		tbar: [
		{
			text: 'Search',
			tooltip: 'Search',
			handler: display_form_search_window,
			iconCls:'icon-search'
		},'-',
		{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: hpp_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: hpp_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: hpp_print  
		}
		]
	});
	hppListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	hpp_ContextMenu = new Ext.menu.Menu({
		id: 'hpp_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'View', tooltip: 'View selected record', 
			iconCls:'icon-update',
			handler: hpp_editContextMenu 
		},
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: hpp_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: hpp_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onhpp_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		hpp_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		hpp_SelectedRow=rowIndex;
		hpp_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function hpp_editContextMenu(){
		//hppListEditorGrid.startEditing(hpp_SelectedRow,1);
		hpp_confirm_update();
  	}
	/* End of Function */
  	
	hppListEditorGrid.addListener('rowcontextmenu', onhpp_ListEditGridContextMenu);
	hpp_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	//hppListEditorGrid.on('afteredit', hpp_inline_update); // inLine Editing Record

	/* Identify  hpp_produk_id Field */
	hpp_produk_idField= new Ext.form.NumberField({
		id: 'hpp_produk_idField',
		fieldLabel: 'Produk Id',
		allowNegatife : false,
		blankText: '0',
		readOnly: true,
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  hpp_produk_nama Field */
	hpp_produk_kodeField= new Ext.form.TextField({
		id: 'hpp_produk_kodeField',
		fieldLabel: 'Kode',
		maxLength: 250,
		allowBlank: false,
		readOnly: true,
		anchor: '95%'
	});
	
	hpp_produk_namaField= new Ext.form.ComboBox({
		id: 'hpp_produk_namaField',
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

	/* Identify  hpp_saldo Field */
	hpp_saldoField= new Ext.form.NumberField({
		id: 'hpp_saldoField',
		fieldLabel: 'Stok Saldo',
		allowNegatife : false,
		readOnly: true,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	
	
	

	/* Function for retrieve create Window Panel*/ 
	hpp_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items:[
			{
				columnWidth:0,
				layout: 'form',
				border:false,
				items: [hpp_produk_kodeField,hpp_produk_namaField,satuan_namaField,hpp_saldoField] 
			}
			],
		buttons: [{
				text: 'Close',
				handler: function(){
					hpp_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	hpp_saveWindow= new Ext.Window({
		id: 'hpp_saveWindow',
		title:'Harga Pokok Penjualan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_hpp_save',
		items: hpp_saveForm
	});
	/* End Window */
	
	/* Function for action list search */
	function hpp_list_search(){
		// render according to a SQL date format.
		
		var hpp_produk_nama_search = null;
		var hpp_tahun_search = null;
		

		if(hpp_produk_namaSearchField.getValue()!==null){ hpp_produk_nama_search=hpp_produk_namaSearchField.getValue();}
		if(hpp_produk_allField.getValue()==true){ hpp_produk_nama_search=null; }
		if(hpp_tahunSearchField.getValue()!==null){ hpp_tahun_search = hpp_tahunSearchField.getValue();};
		
		hpp_DataStore.baseParams = {
			task		: 'LIST',
			produk_id	: hpp_produk_nama_search,
			tahun		: hpp_tahun_search
		};
		
		// Cause the datastore to do another query : 
		hpp_DataStore.load({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function hpp_reset_search(){
		// reset the store parameters
		hpp_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		hpp_DataStore.reload({params: {start: 0, limit: pageS}});
		hpp_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  hpp_produk_id Search Field */
	hpp_produk_idSearchField= new Ext.form.NumberField({
		id: 'hpp_produk_idSearchField',
		fieldLabel: 'Produk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  hpp_produk_nama Search Field */
	hpp_produk_namaSearchField= new Ext.form.ComboBox({
		id: 'hpp_produk_namaSearchField',
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
	
	hpp_produk_allField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Semua',
		width: 100
	});
	
	hpp_produk_selectField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Produk',
		checked: true,
		width: 100
	});
		
	hpp_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'hpp_tanggal_opsiSearchField',
		title: 'Periode',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[hpp_tahunSearchField]
	});
	
	hpp_produk_opsiSearchField=new Ext.form.FieldSet({
		id:'hpp_produk_opsiSearchField',
		title: 'Opsi Produk',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [hpp_produk_allField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [hpp_produk_selectField,hpp_produk_namaSearchField]
			   }
			
		]
	});
	
	/* Function for retrieve search Form Panel */
	hpp_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,        
		items: [hpp_produk_opsiSearchField, hpp_tanggal_opsiSearchField],
		buttons: [{
				text: 'Search',
				handler: hpp_list_search
			},{
				text: 'Close',
				handler: function(){
					hpp_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	hpp_searchWindow = new Ext.Window({
		title: 'Pencarian HPP',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_hpp_search',
		items: hpp_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		hpp_reset_form();
		if(!hpp_searchWindow.isVisible()){
			hpp_searchWindow.show();
		} else {
			hpp_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function hpp_print(){
		var searchquery = "";
		var hpp_produk_id_print=null;
		var hpp_produk_nama_print=null;
		var satuan_id_print=null;
		var satuan_nama_print=null;
		var hpp_saldo_print=null;
		var win;              
		// check if we do have some search data...
		if(hpp_DataStore.baseParams.query!==null){searchquery = hpp_DataStore.baseParams.query;}
		if(hpp_DataStore.baseParams.hpp_produk_id!==null){hpp_produk_id_print = hpp_DataStore.baseParams.hpp_produk_id;}
		if(hpp_DataStore.baseParams.hpp_produk_nama!==null){hpp_produk_nama_print = hpp_DataStore.baseParams.hpp_produk_nama;}
		if(hpp_DataStore.baseParams.satuan_id!==null){satuan_id_print = hpp_DataStore.baseParams.satuan_id;}
		if(hpp_DataStore.baseParams.satuan_nama!==null){satuan_nama_print = hpp_DataStore.baseParams.satuan_nama;}
		if(hpp_DataStore.baseParams.hpp_saldo!==null){hpp_saldo_print = hpp_DataStore.baseParams.hpp_saldo;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_hpp&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			hpp_produk_id : hpp_produk_id_print,
			hpp_produk_nama : hpp_produk_nama_print,
			satuan_id : satuan_id_print,
			satuan_nama : satuan_nama_print,
			hpp_saldo : hpp_saldo_print,
		  	currentlisting: hpp_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/hpp_printlist.html','hpplist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function hpp_export_excel(){
		var searchquery = "";
		var hpp_produk_id_2excel=null;
		var hpp_produk_nama_2excel=null;
		var satuan_id_2excel=null;
		var satuan_nama_2excel=null;
		var hpp_saldo_2excel=null;
		var win;              
		// check if we do have some search data...
		if(hpp_DataStore.baseParams.query!==null){searchquery = hpp_DataStore.baseParams.query;}
		if(hpp_DataStore.baseParams.hpp_produk_id!==null){hpp_produk_id_2excel = hpp_DataStore.baseParams.hpp_produk_id;}
		if(hpp_DataStore.baseParams.hpp_produk_nama!==null){hpp_produk_nama_2excel = hpp_DataStore.baseParams.hpp_produk_nama;}
		if(hpp_DataStore.baseParams.satuan_id!==null){satuan_id_2excel = hpp_DataStore.baseParams.satuan_id;}
		if(hpp_DataStore.baseParams.satuan_nama!==null){satuan_nama_2excel = hpp_DataStore.baseParams.satuan_nama;}
		if(hpp_DataStore.baseParams.hpp_saldo!==null){hpp_saldo_2excel = hpp_DataStore.baseParams.hpp_saldo;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_hpp&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			hpp_produk_id : hpp_produk_id_2excel,
			hpp_produk_nama : hpp_produk_nama_2excel,
			satuan_id : satuan_id_2excel,
			satuan_nama : satuan_nama_2excel,
			hpp_saldo : hpp_saldo_2excel,
		  	currentlisting: hpp_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	hpp_searchWindow.show();
	
	hpp_DataStore.on('beforeload',function(){
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, silakan tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
	});
	
	hpp_DataStore.on('load',function(){ Ext.MessageBox.hide(); });
	
	//EVENT
	/*hpp_produk_kode_filterField.on("select", function(){
		hpp_DataStore.setBaseParam('produk_id',hpp_produk_kode_filterField.getValue());
		hpp_DataStore.setBaseParam('task','LIST');
		hpp_DataStore.load();
	});*/
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_hpp"></div>
		<div id="elwindow_hpp_save"></div>
        <div id="elwindow_hpp_search"></div>
    </div>
</div>
</body>
</html>