<?php
/* 	
	GIOV Solution - Keep IT Simple

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
var history_transaksi_DataStore;
var history_transaksi_ColumnModel;
var history_transaksiListEditorGrid;
var history_transaksi_saveForm;
var history_transaksi_saveWindow;
var history_transaksi_searchForm;
var history_transaksi_searchWindow;
var history_transaksi_SelectedRow;
var history_transaksi_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
/* declare variable here for Field*/

var history_transaksi_custField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return history_transaksiListEditorGrid.getSelectionModel().getSelected().get('cust_id');
		else 
			return 0;
	}
  	/* End of Function */
	
	/* Function for Retrieve DataStore */
	history_transaksi_DataStore = new Ext.data.Store({
		id: 'history_transaksi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_history_transaksi&m=get_action', 
			method: 'POST',
			timeout: 3600000
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'customer_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'referal', type: 'string', mapping: 'referal'},
			{name: 'customer_member', type: 'string', mapping: 'member_no'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'tanggal_transaksi', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal_transaksi'},
			{name: 'no_bukti', type: 'string', mapping: 'no_bukti'},
			{name: 'keterangan', type: 'string', mapping: 'keterangan'},
			{name: 'jumlah_transaksi', type: 'int', mapping: 'jumlah_transaksi'},
			{name: 'kode_transaksi', type: 'string', mapping: 'kode_transaksi'}
		]),
		sortInfo:{field: 'tanggal_transaksi', direction: "DESC"}
	});
	/* End of Function */

		
	//ComboBox ambil data Customer
	cbo_history_transaksi_customerDataStore = new Ext.data.Store({
		id: 'cbo_history_transaksi_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_history_transaksi&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var customer_history_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}',
        '</div></tpl>'
    );
	
	history_transaksi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'tanggal_transaksi',
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			width: 70,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No Faktur</div>',
			dataIndex: 'no_bukti',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'keterangan',
			width: 250,
			sortable: true,
			//hidden: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">Kode</div>',
			dataIndex: 'kode_transaksi',
			width: 70,
			sortable: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'jumlah_transaksi',
			align: 'right',
			//renderer: Ext.util.Format.numberRenderer('0,000.00'),
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Referal</div>',
			dataIndex: 'referal',
			width: 100,
			sortable: true,
			readOnly: true
		}
		
		]);
	
	history_transaksi_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!history_transaksi_searchWindow.isVisible()){
			history_transaksi_searchWindow.show();
		} else {
			history_transaksi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	history_transaksi_customerField=new Ext.form.TextField({
		id: 'history_transaksi_customerField',
		name: 'history_transaksi_customerField',
		fieldLabel: '<b>Customer</b>',
		width: 200,
		readOnly: true
	});
	
	history_transaksi_custnoField=new Ext.form.TextField({
		id: 'history_transaksi_custnoField',
		name: 'history_transaksi_custnoField',
		fieldLabel: '<b>Cust No</b>',
		width : 80,
		readOnly: true
	});
	
	
	history_transaksi_custalamatField=new Ext.form.TextField({
		id: 'history_transaksi_custalamatField',
		name: 'history_transaksi_custalamatField',
		fieldLabel: '<b>Alamat</b>',
		width: 200,
		readOnly: true
	});
	
	
	history_transaksi_custtelpField=new Ext.form.TextField({
		id: 'history_transaksi_custtelpField',
		name: 'history_transaksi_custtelpField',
		fieldLabel: '<b>Telp</b>',
		width : 120,
		readOnly: true
	});
	

	function rounding(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}
	
	/* Declare DataStore and  show datagrid list */
	history_transaksiListEditorGrid =  new Ext.grid.GridPanel({
		id: 'history_transaksiListEditorGrid',
		title: 'Daftar Detail Transaksi Customer',
		el: 'fp_vu_history_transaksi',
		autoHeight: true,
		store: history_transaksi_DataStore, // DataStore
		cm: history_transaksi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		autoHeight: true,
		bbar: [
			new Ext.PagingToolbar({
			//pageSize: pageS,
			store: history_transaksi_DataStore,
			displayInfo: true
		}),//{
		//	'text':'Alamat : '
		//},
		//history_transaksi_custalamatField,
		//{
		//	'text':'Telp : '
		//},
		//history_transaksi_custtelpField
		],tbar: [
		{
			'text':'Nama Lengkap : '
		},
		history_transaksi_customerField,
		{
			'text':'No Cust : '
		},
		history_transaksi_custnoField
		,
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: history_transaksi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kartu_stok_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kartu_stok_print  
		}]
	});
	
	history_transaksiListEditorGrid.render();
	history_transaksiListEditorGrid.show();
	
	function is_valid_form(){
		if(history_transaksi_custField.isValid() && jenis_searchingField.isValid())
		{
			return true;
		}else
			return false;
	}
	
	/* Function for action list search */
	function history_transaksi_list_search(){
		// render according to a SQL date format.
		var cust_nama_search=null;
		var jenis_search=null;
		var tanggal_start_search="";
		var tanggal_end_search="";

		if(is_valid_form()){
		
		if(history_transaksi_custField.getValue()!==null){cust_nama_search=history_transaksi_custField.getValue();}
		if(history_transaksi_tanggal_startSearchField.getValue()!==null){tanggal_start_search=history_transaksi_tanggal_startSearchField.getValue().format('Y-m-d');}
		if(history_transaksi_tanggal_endSearchField.getValue()!==null){tanggal_end_search=history_transaksi_tanggal_endSearchField.getValue().format('Y-m-d');}
		if(jenis_searchingField.getValue()!==null){jenis_search=jenis_searchingField.getValue();}
		
		cbo_history_transaksi_customerDataStore.load({
		 	params:{jenis: jenis_search },
		 	callback: function(r,opt,success){
				if(success==true){
					var j=cbo_history_transaksi_customerDataStore.findExact('cust_id',history_transaksi_custField.getValue(),0);
					if(j>-1){
						var cust_record=cbo_history_transaksi_customerDataStore.getAt(j);
						history_transaksi_customerField.setValue(cust_record.data.cust_nama);
						history_transaksi_custnoField.setValue(cust_record.data.cust_no);
						history_transaksi_custalamatField.setValue(cust_record.data.cust_alamat);
						history_transaksi_custtelpField.setValue(cust_record.data.cust_telprumah);
					}
				}
			}
		});
		
		history_transaksi_DataStore.baseParams = {
			task			: 'LIST',
			cust_id			:	cust_nama_search, 
			tanggal_start	:	tanggal_start_search, 
			tanggal_end		:	tanggal_end_search,
			jenis			:	jenis_search
		};
		// Cause the datastore to do another query : 
		/*Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});*/
		
		history_transaksi_DataStore.reload({params: {start: 0, limit: pageS}});;
		
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'search',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Function for reset search result */
	function history_transaksi_reset_search(){
		// reset the store parameters
		history_transaksi_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		history_transaksi_DataStore.reload({params: {start: 0, limit: pageS}});
		history_transaksi_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */

	history_transaksi_custField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_history_transaksi_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_history_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	

	/* Identify  jenis Combo*/
	jenis_searchingField= new Ext.form.ComboBox({
		id: 'jenis_searchingField',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['jenis_searching_value', 'jenis_searching_display'],
			data:[['Produk','Produk']]
		}),
		mode: 'local',
		allowBlank: false,
		editable:false,
		//emptyText: 'Pilih Salah Satu...',
		displayField: 'jenis_searching_display',
		valueField: 'jenis_searching_value',
		width: 150,
		triggerAction: 'all'	
	});
	
	
	history_transaksi_tanggal_startSearchField=new Ext.form.DateField({
		id: 'history_transaksi_tanggal_startSearchField',
		fieldLabel: 'Tanggal',
		format: 'd-m-Y',		
		value: firstday
	});
    
	history_transaksi_tanggal_endSearchField=new Ext.form.DateField({
		id: 'history_transaksi_tanggal_endSearchField',
		fieldLabel: 's/d',
		format: 'd-m-Y',
		value: today
	});

	
	history_transaksi_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	history_transaksi_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'history_transaksi_tanggal_opsiSearchField',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[history_transaksi_tanggal_startSearchField, history_transaksi_label_tanggalField, history_transaksi_tanggal_endSearchField]
	});

	
	/* Function for retrieve search Form Panel */
	history_transaksi_searchForm = new Ext.FormPanel({
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
				items: [jenis_searchingField,history_transaksi_custField, history_transaksi_tanggal_opsiSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: history_transaksi_list_search
			},{
				text: 'Close',
				handler: function(){
					history_transaksi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	history_transaksi_searchWindow = new Ext.Window({
		title: 'Pencarian Detail Transaksi Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_history_transaksi_search',
		items: history_transaksi_searchForm
	});
    /* End of Function */ 
	 
	function reset_search_form(){
		jenis_searchingField.reset();;
		jenis_searchingField.setValue(null);
		history_transaksi_custField.reset();
		history_transaksi_custField.setValue(null);
		
	}
	
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		reset_search_form();
		
		if(!history_transaksi_searchWindow.isVisible()){
			history_transaksi_searchWindow.show();
		} else {
			history_transaksi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function kartu_stok_print(){
		var searchquery = "";
		var produk_id_print=null;
		var produk_nama_print=null;
		var satuan_id_print=null;
		var satuan_nama_print=null;
		var stok_saldo_print=null;
		var win;              
		// check if we do have some search data...
		if(history_transaksi_DataStore.baseParams.query!==null){searchquery = history_transaksi_DataStore.baseParams.query;}
		if(history_transaksi_DataStore.baseParams.produk_id!==null){produk_id_print = history_transaksi_DataStore.baseParams.produk_id;}
		if(history_transaksi_DataStore.baseParams.produk_nama!==null){produk_nama_print = history_transaksi_DataStore.baseParams.produk_nama;}
		if(history_transaksi_DataStore.baseParams.satuan_id!==null){satuan_id_print = history_transaksi_DataStore.baseParams.satuan_id;}
		if(history_transaksi_DataStore.baseParams.satuan_nama!==null){satuan_nama_print = history_transaksi_DataStore.baseParams.satuan_nama;}
		if(history_transaksi_DataStore.baseParams.stok_saldo!==null){stok_saldo_print = history_transaksi_DataStore.baseParams.stok_saldo;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_history_transaksi&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_id : produk_id_print,
			produk_nama : produk_nama_print,
			satuan_id : satuan_id_print,
			satuan_nama : satuan_nama_print,
			stok_saldo : stok_saldo_print,
		  	currentlisting: history_transaksi_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/kartu_stok_printlist.html','kartu_stoklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				win.print();
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Unable to print the grid!',
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
			   msg: 'Could not connect to the database. retry later.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function kartu_stok_export_excel(){
		var searchquery = "";
		var produk_id_2excel=null;
		var produk_nama_2excel=null;
		var satuan_id_2excel=null;
		var satuan_nama_2excel=null;
		var stok_saldo_2excel=null;
		var win;              
		// check if we do have some search data...
		if(history_transaksi_DataStore.baseParams.query!==null){searchquery = history_transaksi_DataStore.baseParams.query;}
		if(history_transaksi_DataStore.baseParams.produk_id!==null){produk_id_2excel = history_transaksi_DataStore.baseParams.produk_id;}
		if(history_transaksi_DataStore.baseParams.produk_nama!==null){produk_nama_2excel = history_transaksi_DataStore.baseParams.produk_nama;}
		if(history_transaksi_DataStore.baseParams.satuan_id!==null){satuan_id_2excel = history_transaksi_DataStore.baseParams.satuan_id;}
		if(history_transaksi_DataStore.baseParams.satuan_nama!==null){satuan_nama_2excel = history_transaksi_DataStore.baseParams.satuan_nama;}
		if(history_transaksi_DataStore.baseParams.stok_saldo!==null){stok_saldo_2excel = history_transaksi_DataStore.baseParams.stok_saldo;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_history_transaksi&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_id : produk_id_2excel,
			produk_nama : produk_nama_2excel,
			satuan_id : satuan_id_2excel,
			satuan_nama : satuan_nama_2excel,
			stok_saldo : stok_saldo_2excel,
		  	currentlisting: history_transaksi_DataStore.baseParams.task // this tells us if we are searching or not
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
					msg: 'Unable to convert excel the grid!',
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
			   msg: 'Could not connect to the database. retry later.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */

	history_transaksi_searchWindow.show();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_history_transaksi"></div>
         <div id="fp_vu_history_transaksi"></div>
		<div id="elwindow_history_transaksi_save"></div>
        <div id="elwindow_history_transaksi_search"></div>
    </div>
</div>
</body>
</html>