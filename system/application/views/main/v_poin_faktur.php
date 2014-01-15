<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: poin_faktur View
	+ Description	: For record view
	+ Filename 		: v_poin_faktur.php
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
var poin_faktur_DataStore;
var poin_faktur_ColumnModel;
var poin_fakturListEditorGrid;
var poin_faktur_createForm;
var poin_faktur_createWindow;
var poin_faktur_searchForm;
var poin_faktur_searchWindow;
var poin_faktur_SelectedRow;
var poin_faktur_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var poin_faktur_noSearchField;
var poin_faktur_jenisSearchField;
var poin_faktur_custSearchField;
var poin_faktur_tanggalSearchField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
    
	/* Function for Retrieve DataStore */
	poin_faktur_DataStore = new Ext.data.Store({
		id: 'poin_faktur_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_poin_faktur&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'poin_faktur_no'
		},[
			{name: 'poin_faktur_no', type: 'string', mapping: 'no_bukti'}, 
			{name: 'poin_faktur_jenis', type: 'string', mapping: 'jenis'}, 
			{name: 'poin_faktur_point', type: 'int', mapping: 'point'}, 
			{name: 'poin_faktur_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'poin_faktur_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'}, 
			{name: 'poin_faktur_cust_no', type: 'string', mapping: 'cust_no'}
		]),
		//sortInfo:{field: 'poin_faktur_no', direction: "DESC"}
	});
	/* End of Function */
   	
	/* Function for Retrieve DataStore */
	cbo_cust_poin_DataStore = new Ext.data.Store({
		id: 'cbo_cust_poin_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	var customer_poin_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}',
        '</div></tpl>'
    );
	
  	/* Function for Identify of Window Column Model */
	poin_faktur_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Tgl Faktur' + '</div>',
			dataIndex: 'poin_faktur_tanggal',
			width: 80,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'poin_faktur_no',
			width: 80,
			sortable: true,
			readOnly: true
		},  
		{
			header: '<div align="center">' + 'Poin' + '</div>',
			dataIndex: 'poin_faktur_point',
			align: 'right',
			width: 40,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'poin_faktur_cust_no',
			width: 80,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'poin_faktur_cust',
			width: 200,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Jenis Transaksi' + '</div>',
			dataIndex: 'poin_faktur_jenis',
			width: 80,
			sortable: true,
			readOnly: true
		}
		]);
	
	poin_faktur_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	poin_fakturListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'poin_fakturListEditorGrid',
		el: 'fp_poin_faktur',
		title: 'Daftar Detail Poin Customer per Faktur',
		autoHeight: true,
		store: poin_faktur_DataStore, // DataStore
		cm: poin_faktur_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: poin_faktur_DataStore,
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
			new Ext.app.SearchField({
			store: poin_faktur_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: poin_faktur_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: poin_faktur_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: poin_faktur_print  
		}
		]
	});
	poin_fakturListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	poin_faktur_ContextMenu = new Ext.menu.Menu({
		id: 'poin_faktur_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: poin_faktur_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: poin_faktur_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onpoin_faktur_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		poin_faktur_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		poin_faktur_SelectedRow=rowIndex;
		poin_faktur_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function poin_faktur_editContextMenu(){
		poin_fakturListEditorGrid.startEditing(poin_faktur_SelectedRow,1);
  	}
	/* End of Function */
  	
	poin_fakturListEditorGrid.addListener('rowcontextmenu', onpoin_faktur_ListEditGridContextMenu);
	//poin_faktur_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	/* Function for action list search */
	function poin_faktur_list_search(){
		// render according to a SQL date format.
		var poin_faktur_no_search=null;
		var poin_faktur_jenis_search=null;
		var poin_tanggal_start_search_date="";
		var poin_tanggal_end_search_date="";
		var poin_faktur_cust_search=null;

		if(poin_faktur_noSearchField.getValue()!==null){poin_faktur_no_search=poin_faktur_noSearchField.getValue();}
		if(poin_faktur_custSearchField.getValue()!==null){poin_faktur_cust_search=poin_faktur_custSearchField.getValue();}
		if(poin_faktur_jenisSearchField.getValue()!==null){poin_faktur_jenis_search=poin_faktur_jenisSearchField.getValue();}
		if(poin_tanggal_startSearchField.getValue()!==""){poin_tanggal_start_search_date=poin_tanggal_startSearchField.getValue().format('Y-m-d');}
		if(poin_tanggal_endSearchField.getValue()!==""){poin_tanggal_end_search_date=poin_tanggal_endSearchField.getValue().format('Y-m-d');}
		

		poin_faktur_DataStore.baseParams = {
			task: 'SEARCH',
			poin_faktur_no	:	poin_faktur_no_search, 
			poin_faktur_cust	:	poin_faktur_cust_search, 
			poin_faktur_jenis	:	poin_faktur_jenis_search, 
			poin_tanggal_start : poin_tanggal_start_search_date,
			poin_tanggal_end   : poin_tanggal_end_search_date
			//poin_faktur_tanggal	:	poin_faktur_tanggal_search_date
		};
		poin_faktur_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function poin_faktur_reset_search(){
		// reset the store parameters
		poin_faktur_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		poin_faktur_DataStore.reload({params: {start: 0, limit: pageS}});
		poin_faktur_searchWindow.close();
	};
	/* End of Fuction */

	function poin_faktur_reset_SearchForm(){
		poin_faktur_noSearchField.reset();
		poin_faktur_custSearchField.reset();
		poin_faktur_jenisSearchField.reset();
		//poin_faktur_tanggalSearchField.reset();
	}

	
	poin_faktur_noSearchField= new Ext.form.TextField({
		id: 'poin_faktur_noSearchField',
		fieldLabel: 'No Faktur',
		maxLength: 50,
		anchor: '95%'
	
	});
	
	poin_faktur_custSearchField= new Ext.form.ComboBox({
		id: 'poin_faktur_custSearchField',
		fieldLabel: 'Customer',
		store: cbo_cust_poin_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_poin_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	
	/* Identify  poin_faktur_jenis Search Field */
	poin_faktur_jenisSearchField= new Ext.form.ComboBox({
		id: 'poin_faktur_jenisSearchField',
		fieldLabel: 'Jenis Transaksi',
		store:new Ext.data.SimpleStore({
			fields:['poin_jenis_value', 'poin_jenis_display'],
			data:[['','Semua'],['Produk','Produk'],['Perawatan','Perawatan'],['Paket','Paket']]
		}),
		mode: 'local',
		displayField: 'poin_jenis_display',
		valueField: 'poin_jenis_value',
		editable: false,
		width: 100,
		triggerAction: 'all'
	
	});
	
	/* Identify  poin_faktur_tanggal Search Field */
   
	poin_tanggal_startSearchField=new Ext.form.DateField({
		id: 'poin_tanggal_startSearchField',
		fieldLabel: 'Tanggal',
		format: 'd-m-Y'		
		//value: firstday
	});
    
	poin_tanggal_endSearchField=new Ext.form.DateField({
		id: 'poin_tanggal_endSearchField',
		fieldLabel: 's/d',
		format: 'd-m-Y',
		value: today
	});

	poin_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	poin_faktur_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'poin_faktur_tanggal_opsiSearchField',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[poin_tanggal_startSearchField, poin_label_tanggalField, poin_tanggal_endSearchField]
	});	
		
		
	/* Function for retrieve search Form Panel */
	poin_faktur_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [poin_faktur_noSearchField, poin_faktur_jenisSearchField, poin_faktur_tanggal_opsiSearchField, poin_faktur_custSearchField],
		buttons: [{
				text: 'Search',
				handler: poin_faktur_list_search
			},{
				text: 'Close',
				handler: function(){
					poin_faktur_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	poin_faktur_searchWindow = new Ext.Window({
		title: 'Pencarian Detail Poin Customer per Faktur',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_poin_faktur_search',
		items: poin_faktur_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!poin_faktur_searchWindow.isVisible()){
			poin_faktur_reset_SearchForm();
			poin_faktur_searchWindow.show();
		} else {
			poin_faktur_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function poin_faktur_print(){
		var searchquery = "";
		var poin_faktur_no_print=null;
		var poin_faktur_cust_print=null;
		var poin_faktur_jenis_print=null;
		var poin_faktur_tanggal_print_date="";

		var win;              
		// check if we do have some search data...
		if(poin_faktur_DataStore.baseParams.query!==null){searchquery = poin_faktur_DataStore.baseParams.query;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_no!==null){poin_faktur_no_print = poin_faktur_DataStore.baseParams.poin_faktur_no;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_cust!==null){poin_faktur_cust_print = poin_faktur_DataStore.baseParams.poin_faktur_cust;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_jenis!==null){poin_faktur_jenis_print = poin_faktur_DataStore.baseParams.poin_faktur_jenis;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_tanggal!==""){poin_faktur_tanggal_print_date = poin_faktur_DataStore.baseParams.poin_faktur_tanggal;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_poin_faktur&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			poin_faktur_no : poin_faktur_no_print,
			poin_faktur_cust : poin_faktur_cust_print,
			poin_faktur_jenis : poin_faktur_jenis_print,
		  	poin_faktur_tanggal : poin_faktur_tanggal_print_date,
			currentlisting: poin_faktur_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_poin_fakturlist.html','poin_fakturlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function poin_faktur_export_excel(){
		var searchquery = "";
		var poin_faktur_no_2excel=null;
		var poin_faktur_cust_2excel=null;
		var poin_faktur_jenis_2excel=null;
		var poin_faktur_tanggal_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(poin_faktur_DataStore.baseParams.query!==null){searchquery = poin_faktur_DataStore.baseParams.query;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_no!==null){poin_faktur_no_2excel = poin_faktur_DataStore.baseParams.poin_faktur_no;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_cust!==null){poin_faktur_cust_2excel = poin_faktur_DataStore.baseParams.poin_faktur_cust;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_jenis!==null){poin_faktur_jenis_2excel = poin_faktur_DataStore.baseParams.poin_faktur_jenis;}
		if(poin_faktur_DataStore.baseParams.poin_faktur_tanggal!==""){poin_faktur_tanggal_2excel_date = poin_faktur_DataStore.baseParams.poin_faktur_tanggal;}
		
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_poin_faktur&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			poin_faktur_no : poin_faktur_no_2excel,
			poin_faktur_cust : poin_faktur_cust_2excel,
			poin_faktur_jenis : poin_faktur_jenis_2excel,
		  	poin_faktur_tanggal : poin_faktur_tanggal_2excel_date,
			currentlisting: poin_faktur_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_poin_faktur"></div>
         <div id="fp_poin_faktur_produk"></div>
         <div id="fp_poin_faktur_perawatan"></div>
         <div id="fp_poin_faktur_kupon"></div>
		<div id="elwindow_poin_faktur_create"></div>
        <div id="elwindow_poin_faktur_search"></div>
    </div>
</div>
</body>