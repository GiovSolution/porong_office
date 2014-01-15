<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: voucher View
	+ Description	: For record view
	+ Filename 		: v_voucher.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
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
var voucher_DataStore;
var voucher_ColumnModel;
var voucherListEditorGrid;
var voucher_createForm;
var voucher_createWindow;
var voucher_searchForm;
var voucher_searchWindow;
var voucher_SelectedRow;
var voucher_ContextMenu;
//for detail data
var voucher_produk_DataStore;
var voucher_produkListEditorGrid;
var voucher_produk_ColumnModel;
var voucher_produk_proxy;
var voucher_produk_writer;
var voucher_produk_reader;
var voucher_perawatan_DataStore;
var voucher_perawatanListEditorGrid;
var voucher_perawatan_ColumnModel;
var voucher_perawatan_proxy;
var voucher_perawatan_writer;
var voucher_perawatan_reader;

var editor_voucher_produk;
var editor_voucher_perawatan;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var voucher_idField;
var voucher_namaField;
var voucher_jenisField;
var voucher_pointField;
var voucher_jumlahField;
var voucher_kadaluarsaField;
var voucher_cashbackField;
var voucher_mincashField;
var voucher_diskonField;
var voucher_promoField;
var voucher_allprodukField;
var voucher_allrawatField;
var voucher_idSearchField;
var voucher_namaSearchField;
var voucher_member_noSearchField;
var voucher_jenisSearchField;
var voucher_pointSearchField;
var voucher_jumlahSearchField;
var voucher_kadaluarsaSearchField;
var voucher_cashbackSearchField;
var voucher_mincashSearchField;
var voucher_diskonSearchField;
var voucher_promoSearchField;
var voucher_allprodukSearchField;
var voucher_allrawatSearchField;
var voucher_transaksi_custField

function voucher_cetak(master_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_voucher&m=print_paper',
		params: { kvoucher_master : master_id}, 
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./voucher_paper.html','Cetak Voucher','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
				//
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

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	
    
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return voucherListEditorGrid.getSelectionModel().getSelected().get('voucher_id');
		else 
			return 0;
	}
	/* End of Function  */
	
 
  	/* Function for Delete Confirm */
	function voucher_confirm_delete(){
		// only one voucher is selected here
		if(voucherListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', voucher_delete);
		} else if(voucherListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', voucher_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  
  	/* Function for Delete Record */
	function voucher_delete(btn){
		if(btn=='yes'){
			var selections = voucherListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< voucherListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.voucher_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_voucher&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							voucher_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
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
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	voucher_DataStore = new Ext.data.Store({
		id: 'voucher_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_voucher&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'voucher_id'
		},[
			{name: 'voucher_id', type: 'int', mapping: 'voucher_id'}, 
			{name: 'voucher_no', type: 'string', mapping: 'voucher_no'}, 
			{name: 'voucher_nama', type: 'string', mapping: 'voucher_nama'}, 
			{name: 'cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'voucher_jenis', type: 'string', mapping: 'voucher_jenis'}, 
			{name: 'voucher_point', type: 'int', mapping: 'voucher_point'}, 
			{name: 'voucher_jumlah', type: 'int', mapping: 'voucher_jumlah'}, 
			{name: 'voucher_kadaluarsa', type: 'date', dateFormat: 'Y-m-d', mapping: 'voucher_kadaluarsa'}, 
			{name: 'voucher_tgl', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'voucher_tgl'}, 
			{name: 'voucher_cashback', type: 'float', mapping: 'voucher_cashback'}, 
			{name: 'voucher_cust', type: 'string', mapping: 'voucher_cust'},
			{name: 'voucher_keterangan', type: 'string', mapping: 'voucher_keterangan'}
		]),
		sortInfo:{field: 'voucher_id', direction: "DESC"}
	});
	/* End of Function */
	
   		//ComboBox ambil data Customer
	cbo_voucher_transaksi_customerDataStore = new Ext.data.Store({
		id: 'cbo_history_transaksi_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_voucher&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'member_no', type: 'string', mapping: 'member_no'},
			{name: 'cust_member', type: 'string', mapping: 'cust_member'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});

  	//Template yang akan tampil di ComboBox
	var customer_voucher_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	/* Function for Identify of Window Column Model */
	voucher_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'voucher_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'voucher_tgl',
			width: 60,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Client Card' + '</div>',
			dataIndex: 'cust_no',
			width: 60,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'Nama Cust' + '</div>',
			dataIndex: 'cust_nama',
			width: 120,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'voucher_cust',
			width: 100,
			sortable: true,
			readOnly: true,
			renderer: function(value, cell, record){
				if(value.length>=16)
					return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
				else
					return value;
			}
		},
		{
			header: '<div align="center">' + 'Jenis Transaksi' + '</div>',
			dataIndex: 'voucher_nama',
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Poin' + '</div>',
			dataIndex: 'voucher_point',
			align: 'right',
			width: 40,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Nilai (Rp)' + '</div>',
			dataIndex: 'voucher_cashback',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No Voucher' + '</div>',
			dataIndex: 'voucher_no',
			width: 60,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'voucher_keterangan',
			width: 120,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'Kadaluarsa' + '</div>',
			dataIndex: 'voucher_kadaluarsa',
			width: 60,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}
		]);
	
	voucher_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	voucherListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'voucherListEditorGrid',
		el: 'fp_voucher',
		title: 'Daftar Penambahan, Penukaran dan Edit Poin Customer',
		autoHeight: true,
		store: voucher_DataStore, // DataStore
		cm: voucher_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: voucher_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		/*
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_POIN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: voucher_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		*/
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: voucher_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: voucher_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: voucher_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: voucher_print  
		}
		]
	});
	voucherListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	voucher_ContextMenu = new Ext.menu.Menu({
		id: 'voucher_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_POIN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: voucher_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: voucher_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: voucher_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onvoucher_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		voucher_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		voucher_SelectedRow=rowIndex;
		voucher_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function voucher_editContextMenu(){
		voucherListEditorGrid.startEditing(voucher_SelectedRow,1);
  	}
	/* End of Function */
  	
	voucherListEditorGrid.addListener('rowcontextmenu', onvoucher_ListEditGridContextMenu);
	voucher_DataStore.load({params: {start: 0, limit: pageS}});	// supaya tidak auto load DataStore
	
	/* Function for action list search */
	function voucher_list_search(){
		// render according to a SQL date format.
		var voucher_nama_search=null;
		var voucher_transaksi_search=null;
		var voucher_no_search=null;
		var voucher_point_search=null;
		var voucher_tanggal_start_search_date="";
		var voucher_tanggal_end_search_date="";
		var voucher_kadaluarsa_search_date="";
		var voucher_cashback_search=null;
		var voucher_cust_search=null;

		if(voucher_namaSearchField.getValue()!==null){voucher_nama_search=voucher_namaSearchField.getValue();}
		if(voucher_transaksi_custField.getValue()!==null){voucher_transaksi_search=voucher_transaksi_custField.getValue();}
		if(voucher_pointSearchField.getValue()!==null){voucher_point_search=voucher_pointSearchField.getValue();}
		if(voucher_tanggal_startSearchField.getValue()!==""){voucher_tanggal_start_search_date=voucher_tanggal_startSearchField.getValue().format('Y-m-d');}
		if(voucher_tanggal_endSearchField.getValue()!==""){voucher_tanggal_end_search_date=voucher_tanggal_endSearchField.getValue().format('Y-m-d');}
		if(voucher_kadaluarsaSearchField.getValue()!==""){voucher_kadaluarsa_search_date=voucher_tanggal_start_search_date.getValue().format('Y-m-d');}
		if(voucher_cashbackSearchField.getValue()!==null){voucher_cashback_search=voucher_cashbackSearchField.getValue();}
		voucher_DataStore.baseParams = {
			task: 'SEARCH',
			voucher_nama	:	voucher_nama_search,
			voucher_member_no:	voucher_transaksi_search,
			voucher_cust	:	voucher_cust_search, 
			voucher_no		:	voucher_no_search, 
			voucher_point	:	voucher_point_search, 
			voucher_tanggal_start : voucher_tanggal_start_search_date,
			voucher_tanggal_end   : voucher_tanggal_end_search_date,
			voucher_kadaluarsa	:	voucher_kadaluarsa_search_date, 
			voucher_cashback	:	voucher_cashback_search
		};
		voucher_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function voucher_reset_search(){
		// reset the store parameters
		voucher_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		voucher_DataStore.reload({params: {start: 0, limit: pageS}});
		voucher_searchWindow.close();
	};
	/* End of Fuction */

	function voucher_reset_SearchForm(){
		voucher_namaSearchField.reset();
		voucher_transaksi_custField.reset();
		voucher_transaksi_custField.setValue(null);
		voucher_noSearchField.reset();
		voucher_pointSearchField.reset();
		voucher_kadaluarsaSearchField.reset();
		voucher_cashbackSearchField.reset();
	}

	
	voucher_noSearchField= new Ext.form.TextField({
		id: 'voucher_noSearchField',
		fieldLabel: 'No Voucher',
		maxLength: 50,
		anchor: '95%'
	
	});
		
	/*voucher_custSearchField= new Ext.form.TextField({
		id: 'voucher_custSearchField',
		fieldLabel: 'No Member',
		maxLength: 50,
		anchor: '95%'
	
	});*/
	
	/* Identify  voucher_nama Search Field */
	/*voucher_namaSearchField= new Ext.form.TextField({
		id: 'voucher_namaSearchField',
		fieldLabel: 'Jenis Transaksi',
		maxLength: 50,
		anchor: '95%'
	
	});*/
		
	voucher_namaSearchField= new Ext.form.ComboBox({
		id: 'voucher_namaSearchField',
		fieldLabel: 'Jenis Transaksi',
		maxLength: 50,
		anchor: '95%',
		store:new Ext.data.SimpleStore({
			fields:['cust_trans_value_display'],
			data: [['Pengisian Poin'],['Penukaran Poin']]
		}),
		mode: 'local',
		editable: false,
		displayField: 'cust_trans_value_display',
		valueField: 'cust_trans_value_display',
		allowBlank: false,
		triggerAction: 'all'	
	});
	
	voucher_transaksi_custField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_voucher_transaksi_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'member_no',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_voucher_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	
	
	
	/* Identify  voucher_point Search Field */
	voucher_pointSearchField= new Ext.form.NumberField({
		id: 'voucher_pointSearchField',
		fieldLabel: 'Poin',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '50%',
		maskRe: /([0-9]+)$/
	
	});
	
	/* Identify  voucher_kadaluarsa Search Field */
	voucher_kadaluarsaSearchField= new Ext.form.DateField({
		id: 'voucher_kadaluarsaSearchField',
		fieldLabel: 'Kadaluarsa',
		format : 'Y-m-d'
	
	});
	/* Identify  voucher_cashback Search Field */
	voucher_cashbackSearchField= new Ext.form.NumberField({
		id: 'voucher_cashbackSearchField',
		fieldLabel: 'Nilai',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
		
	voucher_tanggal_startSearchField=new Ext.form.DateField({
		id: 'voucher_tanggal_startSearchField',
		fieldLabel: 'Tanggal',
		format: 'd-m-Y'		
		//value: firstday
	});
    
	voucher_tanggal_endSearchField=new Ext.form.DateField({
		id: 'voucher_tanggal_endSearchField',
		fieldLabel: 's/d',
		format: 'd-m-Y',
		value: today
	});

	voucher_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	voucher_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'voucher_tanggal_opsiSearchField',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[voucher_tanggal_startSearchField, voucher_label_tanggalField, voucher_tanggal_endSearchField]
	});
	
	   
	/* Function for retrieve search Form Panel */
	voucher_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [voucher_noSearchField, voucher_pointSearchField, voucher_tanggal_opsiSearchField, voucher_kadaluarsaSearchField, voucher_cashbackSearchField, 
				voucher_namaSearchField, voucher_transaksi_custField],
		buttons: [{
				text: 'Search',
				handler: voucher_list_search
			},{
				text: 'Close',
				handler: function(){
					voucher_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	voucher_searchWindow = new Ext.Window({
		title: 'Pencarian Penukaran dan Pengisian Poin Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_voucher_search',
		items: voucher_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!voucher_searchWindow.isVisible()){
			voucher_reset_SearchForm();
			voucher_searchWindow.show();
		} else {
			voucher_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function voucher_print(){
		var searchquery = "";
		var voucher_nama_print=null;
		var voucher_cust_print=null;
		var voucher_point_print=null;
		var voucher_kadaluarsa_print_date="";
		var voucher_cashback_print=null;

		var win;              
		// check if we do have some search data...
		if(voucher_DataStore.baseParams.query!==null){searchquery = voucher_DataStore.baseParams.query;}
		if(voucher_DataStore.baseParams.voucher_nama!==null){voucher_nama_print = voucher_DataStore.baseParams.voucher_nama;}
		if(voucher_DataStore.baseParams.voucher_cust!==null){voucher_cust_print = voucher_DataStore.baseParams.voucher_cust;}
		if(voucher_DataStore.baseParams.voucher_point!==null){voucher_point_print = voucher_DataStore.baseParams.voucher_point;}
		if(voucher_DataStore.baseParams.voucher_kadaluarsa!==""){voucher_kadaluarsa_print_date = voucher_DataStore.baseParams.voucher_kadaluarsa;}
		if(voucher_DataStore.baseParams.voucher_cashback!==null){voucher_cashback_print = voucher_DataStore.baseParams.voucher_cashback;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_voucher&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			voucher_nama : voucher_nama_print,
			voucher_cust : voucher_cust_print,
			voucher_point : voucher_point_print,
		  	voucher_kadaluarsa : voucher_kadaluarsa_print_date, 
			voucher_cashback : voucher_cashback_print,
			currentlisting: voucher_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_voucherlist.html','voucherlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function voucher_export_excel(){
		var searchquery = "";
		var voucher_nama_2excel=null;
		var voucher_cust_2excel=null;
		var voucher_no_2excel=null;
		var voucher_point_2excel=null;
		var voucher_kadaluarsa_2excel_date="";
		var voucher_cashback_2excel=null;
		var win;              
		// check if we do have some search data...
		if(voucher_DataStore.baseParams.query!==null){searchquery = voucher_DataStore.baseParams.query;}
		if(voucher_DataStore.baseParams.voucher_nama!==null){voucher_nama_2excel = voucher_DataStore.baseParams.voucher_nama;}
		if(voucher_DataStore.baseParams.voucher_cust!==null){voucher_cust_2excel = voucher_DataStore.baseParams.voucher_cust;}
		if(voucher_DataStore.baseParams.voucher_no!==null){voucher_no_2excel = voucher_DataStore.baseParams.voucher_no;}
		if(voucher_DataStore.baseParams.voucher_point!==null){voucher_point_2excel = voucher_DataStore.baseParams.voucher_point;}
		if(voucher_DataStore.baseParams.voucher_kadaluarsa!==""){voucher_kadaluarsa_2excel_date = voucher_DataStore.baseParams.voucher_kadaluarsa;}
		if(voucher_DataStore.baseParams.voucher_cashback!==null){voucher_cashback_2excel = voucher_DataStore.baseParams.voucher_cashback;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_voucher&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			voucher_nama : voucher_nama_2excel,
			voucher_cust : voucher_cust_2excel,
			voucher_no : voucher_no_2excel,
			voucher_point : voucher_point_2excel,
		  	voucher_kadaluarsa : voucher_kadaluarsa_2excel_date, 
			voucher_cashback : voucher_cashback_2excel,
			currentlisting: voucher_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_voucher"></div>
         <div id="fp_voucher_produk"></div>
         <div id="fp_voucher_perawatan"></div>
         <div id="fp_voucher_kupon"></div>
		<div id="elwindow_voucher_create"></div>
        <div id="elwindow_voucher_search"></div>
    </div>
</div>
</body>