<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: lap_poin_hangus View
	+ Description	: For record view
	+ Filename 		: v_lap_poin_hangus.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	+Modified by 	: -Fred-
	
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
var lap_poin_hangus_DataStore;
var lap_poin_hangus_ColumnModel;
var lap_poin_hangusListEditorGrid;
var lap_poin_hangus_createForm;
var lap_poin_hangus_createWindow;
var lap_poin_hangus_searchForm;
var lap_poin_return_Form;
var lap_poin_hangus_searchWindow;
var lap_poin_return_Window;
var lap_poin_hangus_SelectedRow;
var lap_poin_hangus_ContextMenu;
//for detail data
var lap_poin_produk_DataStore;
var lap_poin_produkListEditorGrid;
var lap_poin_produk_ColumnModel;
var lap_poin_produk_proxy;
var lap_poin_produk_writer;
var lap_poin_produk_reader;
var lap_poin_perawatan_DataStore;
var lap_poin_perawatanListEditorGrid;
var lap_poin_perawatan_ColumnModel;
var lap_poin_perawatan_proxy;
var lap_poin_perawatan_writer;
var lap_poin_perawatan_reader;

var editor_lap_poin_produk;
var editor_lap_poin_perawatan;

//declare konstant
var lap_poin_hangus_post2db = '';
var lap_poin_hangus_msg = '';
var lap_poin_hangus_msg_pageS=15;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var log_idField;
var lap_poin_hangus_namaField;
var lap_poin_hangus_jenisField;
var lap_poin_hangus_pointField;
var lap_poin_hangus_jumlahField;
var lap_poin_hangus_kadaluarsaField;
var lap_poin_hangus_cashbackField;
var lap_poin_hangus_mincashField;
var lap_poin_hangus_diskonField;
var lap_poin_hangus_promoField;
var lap_poin_hangus_allprodukField;
var lap_poin_hangus_allrawatField;
var log_idSearchField;
var lap_poin_hangus_namaSearchField;
var lap_poin_hangus_nmcustSearchField;
var lap_poin_hangus_member_noSearchField;
var lap_poin_hangus_jenisSearchField;
var lap_poin_hangus_pointSearchField;
var lap_poin_hangus_jumlahSearchField;
var lap_poin_hangus_kadaluarsaSearchField;
var lap_poin_hangus_cashbackSearchField;
var lap_poin_hangus_mincashSearchField;
var lap_poin_hangus_diskonSearchField;
var lap_poin_hangus_promoSearchField;
var lap_poin_hangus_allprodukSearchField;
var lap_poin_hangus_allrawatSearchField;
var lap_poin_hangus_transaksi_custField

function lap_poin_hangus_cetak(master_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_lap_poin_hangus&m=print_paper',
		params: { klap_poin_hangus_master : master_id}, 
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
		if(lap_poin_hangus_post2db=='UPDATE')
			return lap_poin_hangusListEditorGrid.getSelectionModel().getSelected().get('log_id');
		else 
			return 0;
	}
	/* End of Function  */
	
 
  	/* Function for Delete Confirm */
	function lap_poin_hangus_confirm_poin_return(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk mengembalikan poin customer ini? (Pengembalian Poin ini hanya dapat dilakukan 1 kali saja) ', lap_poin_return);
	}
  	/* End of Function */

	
  	/* Function for Delete Record */
	function lap_poin_hangus_delete(btn){
		if(btn=='yes'){
			var selections = lap_poin_hangusListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< lap_poin_hangusListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.log_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_lap_poin_hangus&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							lap_poin_hangus_DataStore.reload();
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
	lap_poin_hangus_DataStore = new Ext.data.Store({
		id: 'lap_poin_hangus_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_poin_hangus&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: lap_poin_hangus_msg_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'log_id'
		},[
			{name: 'log_id', type: 'int', mapping: 'log_id'}, 
			{name: 'log_cust', type: 'string', mapping: 'log_cust'}, 
			{name: 'log_poin', type: 'string', mapping: 'log_poin'}, 
			{name: 'cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'member_no', type: 'string', mapping: 'member_no'}, 
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'log_date_create',  type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'log_date_create'}, 
			{name: 'log_creator', type: 'string', mapping: 'log_creator'},
			{name: 'log_tgl_poin_return',  type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'log_tgl_poin_return'}, 
			{name: 'log_keterangan', type: 'string', mapping: 'log_keterangan'},
			{name: 'log_stat_poin_return', type: 'string', mapping: 'log_stat_poin_return'}
		]),
		sortInfo:{field: 'log_id', direction: "DESC"}
	});
	/* End of Function */
	
   		//ComboBox ambil data Customer
	cbo_lap_poin_hangus_transaksi_customerDataStore = new Ext.data.Store({
		id: 'cbo_history_transaksi_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_poin_hangus&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:lap_poin_hangus_msg_pageS }, // parameter yang di $_POST ke Controller
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
	var customer_lap_poin_hangus_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	/* Function for Identify of Window Column Model */
	lap_poin_hangus_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'log_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},   
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'log_date_create',
			width: 50,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Client Card' + '</div>',
			dataIndex: 'cust_no',
			width: 50,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'Nama' + '</div>',
			dataIndex: 'cust_nama',
			width: 100,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'member_no',
			width: 70,
			sortable: true,
			readOnly: true,
			renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
		},
		{
			header: '<div align="center">' + 'Poin Hangus' + '</div>',
			dataIndex: 'log_poin',
			align: 'right',
			width: 40,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Stat Pengembalian' + '</div>',
			dataIndex: 'log_stat_poin_return',
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Tgl Pengembalian' + '</div>',
			dataIndex: 'log_tgl_poin_return',
			width: 60,
			sortable: true,
			//hidden : true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'log_keterangan',
			width: 180,
			sortable: true,
			readOnly: true
		}
		]);
	
	lap_poin_hangus_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	lap_poin_hangusListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_poin_hangusListEditorGrid',
		el: 'fp_lap_poin_hangus',
		title: 'Daftar Poin Hangus',
		autoHeight: true,
		store: lap_poin_hangus_DataStore, // DataStore
		cm: lap_poin_hangus_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,
		bbar: new Ext.PagingToolbar({
			lap_poin_hangus_msg_pageSize: lap_poin_hangus_msg_pageS,
			store: lap_poin_hangus_DataStore,
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
			handler: lap_poin_hangus_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		*/
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}//, '-', 
			//new Ext.app.SearchField({
			//store: lap_poin_hangus_DataStore,
			//params: {start: 0, limit: lap_poin_hangus_msg_pageS},
			//width: 120
		//})
		,'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: lap_poin_hangus_reset_search,
			
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
						disabled : true,
			iconCls:'icon-xls',
			handler: lap_poin_hangus_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
						disabled : true,
			iconCls:'icon-print',
			handler: lap_poin_hangus_print  
		}, '-', 
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_POINHANGUS'))){ ?>
		{ 
			text: 'Kembalikan Poin', 
			tooltip: 'Mengembalikan Poin Hangus', 
			iconCls:'icon-inventori',
			ref : '../kembalikan_poin',
			//disabled: true,
			handler: display_form_poin_return_window 
		}
		<?php } ?>
		]
	});
	lap_poin_hangusListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	lap_poin_hangus_ContextMenu = new Ext.menu.Menu({
		id: 'lap_poin_hangus_ContextMenu',
		items: [
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_POINHANGUS'))){ ?>
		{ 
			text: 'Kembalikan Poin', 
			tooltip: 'Mengembalikan Poin Hangus', 
			iconCls:'icon-inventori',
			ref : '../kembalikan_poin_cm',
			//disabled: true,
			handler: display_form_poin_return_window 
		}
		<?php } ?>
		
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_poin_hangus_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_poin_hangus_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_poin_hangus_SelectedRow=rowIndex;
		lap_poin_hangus_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function lap_poin_hangus_editContextMenu(){
		lap_poin_hangusListEditorGrid.startEditing(lap_poin_hangus_SelectedRow,1);
  	}
	/* End of Function */
  	
	lap_poin_hangusListEditorGrid.addListener('rowcontextmenu', onlap_poin_hangus_ListEditGridContextMenu);
	lap_poin_hangusListEditorGrid.addListener('rowcontextmenu', onlap_poin_hangus_ListEditGridContextMenu);
	lap_poin_hangus_DataStore.load({params: {start: 0, limit: lap_poin_hangus_msg_pageS}});	// supaya tidak auto load DataStore
	
	/* Function for action list search */
	function lap_poin_hangus_list_search(){
		// render according to a SQL date format.
		var lap_poin_hangus_nama_search=null;
		var lap_poin_hangus_transaksi_search=null;
		var lap_poin_hangus_nmcust_search=null;
		var lap_poin_hangus_point_search=null;
		var lap_poin_hangus_tanggal_start_search_date="";
		var lap_poin_hangus_tanggal_end_search_date="";
		var lap_poin_hangus_kadaluarsa_search_date="";
		var lap_poin_hangus_cashback_search=null;
		var lap_poin_hangus_cust_search=null;
		
		//if(lap_poin_hangus_nmcustSearchField.getValue()!==null){lap_poin_hangus_nmcust_search=lap_poin_hangus_nmcustSearchField.getValue();}
		if(lap_poin_hangus_namaSearchField.getValue()!==null){lap_poin_hangus_nama_search=lap_poin_hangus_namaSearchField.getValue();}
		if(lap_poin_hangus_transaksi_custField.getValue()!==null){lap_poin_hangus_transaksi_search=lap_poin_hangus_transaksi_custField.getValue();}
		if(lap_poin_hangus_pointSearchField.getValue()!==null){lap_poin_hangus_point_search=lap_poin_hangus_pointSearchField.getValue();}
		if(lap_poin_hangus_tanggal_startSearchField.getValue()!==""){lap_poin_hangus_tanggal_start_search_date=lap_poin_hangus_tanggal_startSearchField.getValue().format('Y-m-d');}
		if(lap_poin_hangus_tanggal_endSearchField.getValue()!==""){lap_poin_hangus_tanggal_end_search_date=lap_poin_hangus_tanggal_endSearchField.getValue().format('Y-m-d');}
		if(lap_poin_hangus_kadaluarsaSearchField.getValue()!==""){lap_poin_hangus_kadaluarsa_search_date=lap_poin_hangus_tanggal_start_search_date.getValue().format('Y-m-d');}
		if(lap_poin_hangus_cashbackSearchField.getValue()!==null){lap_poin_hangus_cashback_search=lap_poin_hangus_cashbackSearchField.getValue();}
		lap_poin_hangus_DataStore.baseParams = {
			task: 'SEARCH',
			//lap_poin_hangus_nama	:	lap_poin_hangus_nama_search,
			lap_poin_hangus_nmcust:	lap_poin_hangus_transaksi_search,
			//lap_poin_hangus_cust	:	lap_poin_hangus_cust_search, 
			//lap_poin_hangus_nmcust		:	lap_poin_hangus_nmcust_search, 
			//lap_poin_hangus_point	:	lap_poin_hangus_point_search, 
			lap_poin_hangus_tanggal_start : lap_poin_hangus_tanggal_start_search_date,
			lap_poin_hangus_tanggal_end   : lap_poin_hangus_tanggal_end_search_date
			//lap_poin_hangus_kadaluarsa	:	lap_poin_hangus_kadaluarsa_search_date, 
			//lap_poin_hangus_cashback	:	lap_poin_hangus_cashback_search
		};
		lap_poin_hangus_DataStore.reload({params: {start: 0, limit: lap_poin_hangus_msg_pageS}});
	}
		
	/* Function for reset search result */
	function lap_poin_hangus_reset_search(){
		// reset the store parameters
		lap_poin_hangus_DataStore.baseParams = { task: 'LIST', start: 0, limit: lap_poin_hangus_msg_pageS };
		lap_poin_hangus_DataStore.reload({params: {start: 0, limit: lap_poin_hangus_msg_pageS}});
		//lap_poin_hangus_searchWindow.close();
	};
	/* End of Fuction */

	function lap_poin_hangus_reset_SearchForm(){
		lap_poin_hangus_namaSearchField.reset();
		lap_poin_hangus_transaksi_custField.reset();
		lap_poin_hangus_transaksi_custField.setValue(null);
		//lap_poin_hangus_nmcustSearchField.reset();
		lap_poin_hangus_pointSearchField.reset();
		lap_poin_hangus_kadaluarsaSearchField.reset();
		lap_poin_hangus_cashbackSearchField.reset();
	}

	/*Reset form utk poin return */
	function lap_poin_return_reset_Form(){
		lap_poin_return_keteranganField.reset();
		lap_poin_return_keteranganField.setValue(null);
	}
	
	/*lap_poin_hangus_nmcustSearchField= new Ext.form.TextField({
		id: 'lap_poin_hangus_nmcustSearchField',
		fieldLabel: 'Nama Customer',
		maxLength: 50,
		anchor: '95%'
	
	});
		
	lap_poin_hangus_custSearchField= new Ext.form.TextField({
		id: 'lap_poin_hangus_custSearchField',
		fieldLabel: 'No Member',
		maxLength: 50,
		anchor: '95%'
	
	});*/
	
	/* Identify  lap_poin_hangus_nama Search Field */
	/*lap_poin_hangus_namaSearchField= new Ext.form.TextField({
		id: 'lap_poin_hangus_namaSearchField',
		fieldLabel: 'Jenis Transaksi',
		maxLength: 50,
		anchor: '95%'
	
	});*/
		
	lap_poin_hangus_namaSearchField= new Ext.form.ComboBox({
		id: 'lap_poin_hangus_namaSearchField',
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
	
	lap_poin_hangus_transaksi_custField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_lap_poin_hangus_transaksi_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        lap_poin_hangus_msg_pageSize:10,
        hideTrigger:false,
        tpl: customer_lap_poin_hangus_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	
	/* Identify  lap_poin_hangus_point Search Field */
	lap_poin_hangus_pointSearchField= new Ext.form.NumberField({
		id: 'lap_poin_hangus_pointSearchField',
		fieldLabel: 'Poin',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '50%',
		maskRe: /([0-9]+)$/
	
	});
	
	/* Identify  lap_poin_hangus_kadaluarsa Search Field */
	lap_poin_hangus_kadaluarsaSearchField= new Ext.form.DateField({
		id: 'lap_poin_hangus_kadaluarsaSearchField',
		fieldLabel: 'Kadaluarsa',
		format : 'Y-m-d'
	
	});
	/* Identify  lap_poin_hangus_cashback Search Field */
	lap_poin_hangus_cashbackSearchField= new Ext.form.NumberField({
		id: 'lap_poin_hangus_cashbackSearchField',
		fieldLabel: 'Nilai',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
		
	lap_poin_hangus_tanggal_startSearchField=new Ext.form.DateField({
		id: 'lap_poin_hangus_tanggal_startSearchField',
		fieldLabel: 'Tanggal',
		format: 'd-m-Y'		
		//value: firstday
	});
    
	lap_poin_hangus_tanggal_endSearchField=new Ext.form.DateField({
		id: 'lap_poin_hangus_tanggal_endSearchField',
		format: 'd-m-Y',
		value: today
	});

	lap_poin_hangus_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	lap_poin_hangus_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'lap_poin_hangus_tanggal_opsiSearchField',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[lap_poin_hangus_tanggal_startSearchField, lap_poin_hangus_label_tanggalField, lap_poin_hangus_tanggal_endSearchField]
	});
	

	/* Identify  Keterangan utk poin return Field */
	lap_poin_return_keteranganField= new Ext.form.TextArea({
		id: 'lap_poin_return_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		allowBlank : false,
		anchor: '95%'
	});
	
	/* Function for retrieve search Form Panel */
	lap_poin_hangus_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [lap_poin_hangus_transaksi_custField, lap_poin_hangus_tanggal_opsiSearchField],
		buttons: [{
				text: 'Search',
				handler: lap_poin_hangus_list_search
			},{
				text: 'Close',
				handler: function(){
					lap_poin_hangus_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	
	/* Function for retrieve Poin Return Form Panel */
	lap_poin_return_Form = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [lap_poin_return_keteranganField],
		buttons: [{
				text: 'Kembalikan',
				handler: lap_poin_return //lap_poin_hangus_confirm_poin_return
			},{
				text: 'Close',
				handler: function(){
					lap_poin_return_Window.hide();
				}
			}
		]
	});
    /* End of Function */
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_poin_hangus_searchWindow = new Ext.Window({
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
		renderTo: 'elwindow_lap_poin_hangus_search',
		items: lap_poin_hangus_searchForm
	});
    /* End of Function */ 
	
	/* Function for retrieve Poin Return Window Form*/
	lap_poin_return_Window = new Ext.Window({
		title: 'Alasan Pengembalian Poin (maks 7 hari)',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_poin_return',
		items: lap_poin_return_Form
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_poin_hangus_searchWindow.isVisible()){
			lap_poin_hangus_reset_SearchForm();
			lap_poin_hangus_searchWindow.show();
		} else {
			lap_poin_hangus_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for Displaying  Poin Return Form */
	function display_form_poin_return_window(){
		if(lap_poin_hangusListEditorGrid.selModel.getCount() == 1) {
			if(!lap_poin_return_Window.isVisible()){
				lap_poin_return_reset_Form();
				lap_poin_return_Window.show();
			} else {
				lap_poin_return_Window.toFront();
			}
		}
		else if(lap_poin_hangusListEditorGrid.selModel.getCount() > 1) {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data yang anda pilih hanya boleh 1 data saja!',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data!',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function lap_poin_hangus_print(){
		var searchquery = "";
		var lap_poin_hangus_nama_print=null;
		var lap_poin_hangus_cust_print=null;
		var lap_poin_hangus_point_print=null;
		var lap_poin_hangus_kadaluarsa_print_date="";
		var lap_poin_hangus_cashback_print=null;

		var win;              
		// check if we do have some search data...
		if(lap_poin_hangus_DataStore.baseParams.query!==null){searchquery = lap_poin_hangus_DataStore.baseParams.query;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_nama!==null){lap_poin_hangus_nama_print = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_nama;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cust!==null){lap_poin_hangus_cust_print = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cust;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_point!==null){lap_poin_hangus_point_print = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_point;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_kadaluarsa!==""){lap_poin_hangus_kadaluarsa_print_date = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_kadaluarsa;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cashback!==null){lap_poin_hangus_cashback_print = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cashback;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_poin_hangus&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			lap_poin_hangus_nama : lap_poin_hangus_nama_print,
			lap_poin_hangus_cust : lap_poin_hangus_cust_print,
			lap_poin_hangus_point : lap_poin_hangus_point_print,
		  	lap_poin_hangus_kadaluarsa : lap_poin_hangus_kadaluarsa_print_date, 
			lap_poin_hangus_cashback : lap_poin_hangus_cashback_print,
			currentlisting: lap_poin_hangus_DataStore.baseParams.task // this tells us if we are searching or not
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
	function lap_poin_hangus_export_excel(){
		var searchquery = "";
		var lap_poin_hangus_nama_2excel=null;
		var lap_poin_hangus_cust_2excel=null;
		var lap_poin_hangus_no_2excel=null;
		var lap_poin_hangus_point_2excel=null;
		var lap_poin_hangus_kadaluarsa_2excel_date="";
		var lap_poin_hangus_cashback_2excel=null;
		var win;              
		// check if we do have some search data...
		if(lap_poin_hangus_DataStore.baseParams.query!==null){searchquery = lap_poin_hangus_DataStore.baseParams.query;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_nama!==null){lap_poin_hangus_nama_2excel = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_nama;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cust!==null){lap_poin_hangus_cust_2excel = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cust;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_no!==null){lap_poin_hangus_no_2excel = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_no;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_point!==null){lap_poin_hangus_point_2excel = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_point;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_kadaluarsa!==""){lap_poin_hangus_kadaluarsa_2excel_date = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_kadaluarsa;}
		if(lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cashback!==null){lap_poin_hangus_cashback_2excel = lap_poin_hangus_DataStore.baseParams.lap_poin_hangus_cashback;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_poin_hangus&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			lap_poin_hangus_nama : lap_poin_hangus_nama_2excel,
			lap_poin_hangus_cust : lap_poin_hangus_cust_2excel,
			lap_poin_hangus_no : lap_poin_hangus_no_2excel,
			lap_poin_hangus_point : lap_poin_hangus_point_2excel,
		  	lap_poin_hangus_kadaluarsa : lap_poin_hangus_kadaluarsa_2excel_date, 
			lap_poin_hangus_cashback : lap_poin_hangus_cashback_2excel,
			currentlisting: lap_poin_hangus_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	
	/* Function for Poin Return Record */
	function lap_poin_return(btn){
		//if(btn=='yes'){
			var selections = lap_poin_hangusListEditorGrid.selModel.getSelections();
			var prez = [];
			var tgl = [];
			var cust_id = [];
			var poin_return_keterangan=null;
			for(i = 0; i< lap_poin_hangusListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.log_id);
				tgl.push(selections[i].json.log_date_create);
				cust_id.push(selections[i].json.log_cust);
			}
			var encoded_array = Ext.encode(prez);
			var tgl_encoded_array = Ext.encode(tgl);
			var cust_id_encoded_array = Ext.encode(cust_id);
			
			if(lap_poin_return_keteranganField.getValue()!== null){poin_return_keterangan = lap_poin_return_keteranganField.getValue();}
			
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_lap_poin_hangus&m=get_action', 
				params: { task: "POIN_RETURN", ids:  encoded_array, tgl_poin : tgl_encoded_array, keterangan : poin_return_keterangan, cust_id : cust_id_encoded_array}, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							lap_poin_hangus_DataStore.reload();
							Ext.MessageBox.alert('OK','Poin berhasil dikembalikan');
							lap_poin_return_Window.hide();
							break;
						case 2:	
							//console.log('mrene');
								Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Poin pernah dikembalikan',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
						case 3:	
							//console.log('mrene');
								Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Poin tidak dapat dikembalikan karena melebihi batas tanggal yang diperbolehkan',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
						
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Poin tidak dapat dikembalikan',
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
		//}  
	}
  	/* End of Function */
	
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lap_poin_hangus"></div>
         <div id="fp_lap_poin_produk"></div>
         <div id="fp_lap_poin_perawatan"></div>
         <div id="fp_lap_poin_hangus_kupon"></div>
		<div id="elwindow_lap_poin_hangus_create"></div>
        <div id="elwindow_lap_poin_hangus_search"></div>
		<div id="elwindow_lap_poin_return"></div>
    </div>
</div>
</body>