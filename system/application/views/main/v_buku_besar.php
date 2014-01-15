<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: buku_besar View
	+ Description	: For record view
	+ Filename 		: v_buku_besar.php
 	+ creator  		:
 	+ Created on 27/May/2010 16:40:49

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
var buku_besar_DataStore;
var buku_besar_ColumnModel;
var buku_besarListEditorGrid;
var buku_besar_saveForm;
var buku_besar_saveWindow;
var buku_besar_searchForm;
var buku_besar_searchWindow;
var buku_besar_SelectedRow;
var buku_besar_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS_bb=10000;

/* declare variable here for Field*/
var buku_idField;
var buku_tanggalField;
var buku_refField;
var buku_akunField;
var buku_debetField;
var buku_kreditField;
var buku_idSearchField;
var buku_tanggalSearchField;
var buku_tanggalEndSearchField;
var buku_refSearchField;
var buku_akunSearchField;
var buku_debetSearchField;
var buku_kreditSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */


	/* Function for Retrieve DataStore */
	buku_besar_DataStore = new Ext.data.GroupingStore({
		id: 'buku_besar_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_buku_besar&m=get_action',
			method: 'POST'
		}),
		groupField:'buku_group_akun',
		baseParams:{task: "LIST", start:0, limit: pageS_bb}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'buku_id'
		},[
			{name: 'buku_id', type: 'int', mapping: 'buku_id'},
			{name: 'buku_tanggal', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'buku_tanggal'},
			{name: 'buku_ref', type: 'string', mapping: 'buku_ref'},
			{name: 'buku_akun', type: 'string', mapping: 'akun_nama'},
			{name: 'buku_group_akun', type: 'string', mapping: 'buku_akun_kode'},
			{name: 'buku_group_nama', type: 'string', mapping: 'buku_akun_nama'},
			{name: 'buku_akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'buku_debet', type: 'float', mapping: 'buku_debet'},
			{name: 'buku_kredit', type: 'float', mapping: 'buku_kredit'},
			{name: 'buku_keterangan', type: 'string', mapping: 'buku_keterangan'},
			{name: 'buku_saldo', type: 'float', mapping: 'buku_saldo'},
			{name: 'buku_author', type: 'string', mapping: 'buku_author'},
			{name: 'buku_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'buku_date_create'},
			{name: 'buku_update', type: 'string', mapping: 'buku_update'},
			{name: 'buku_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'buku_date_update'},
			{name: 'buku_revised', type: 'int', mapping: 'buku_revised'}
		]),
		sortInfo:{field: 'buku_tanggal', direction: "ASC"}
	});

	besar_akun_DataStore = new Ext.data.Store({
		id: 'akun_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_buku_besar&m=get_akun_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS_bb}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'akun_id', type: 'int', mapping: 'akun_id'},
			{name: 'akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'akun_jenis', type: 'string', mapping: 'akun_jenis'},
			{name: 'akun_parent', type: 'int', mapping: 'akun_parent'},
			{name: 'akun_level', type: 'int', mapping: 'akun_level'},
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}

		]),
		sortInfo:{field: 'akun_id', direction: "DESC"}
	});
	/* End of Function */

	var combo_buku_akun = new Ext.form.ComboBox({
		store: besar_akun_DataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: true,
		pageSize: pageS_bb,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '80%',
		hideTrigger: false
	})

	Ext.util.Format.comboRenderer = function(combo){
		besar_akun_DataStore.load();
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}

	Ext.ux.grid.GroupSummary.Calculations['totalSaldo'] = function(v, record, field){
        return v + (record.data.jurnal_debet-record.data.jurnal_kredit);
    };

  	/* Function for Identify of Window Column Model */
	buku_besar_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: 'Rekening',
			dataIndex: 'buku_group_akun',
			width: 100,
			sortable: false,
			readOnly:true,
			renderer: function(v, params, record){
					title=Ext.util.Format.number(record.data.buku_group_akun + ' : ' + record.data.buku_group_nama);
                    return '<span>' + title+ '</span>';
            }
		},
		{
			header: 'Tanggal',
			dataIndex: 'buku_tanggal',
			width: 90,
			sortable: false,
			readOnly:true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
		},
		{
			header: 'Ref',
			dataIndex: 'buku_ref',
			width: 200,
			readOnly:true,
			sortable: false

		},
		{
			header: 'Kode Rekening',
			dataIndex: 'buku_akun_kode',
			width: 100,
			readOnly:true,
			sortable: false
		},
		{
			header: 'Nama Rekening',
			dataIndex: 'buku_akun',
			width: 240,
			sortable: false
		},
		{
			header: 'Keterangan',
			dataIndex: 'buku_keterangan',
			width: 300,
			sortable: false
		},
		{
			header: 'Debet',
			dataIndex: 'buku_debet',
			width: 120,
			align: 'right',
			sortable: false,
			readOnly:true,
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: 'Kredit',
			dataIndex: 'buku_kredit',
			width: 120,
			sortable: false,
			readOnly:true,
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right'
		},
		{
			header: 'Saldo',
			dataIndex: 'buku_saldo',
			width: 120,
			readOnly:true,
			sortable: false,
			align:'right',
			renderer: function(v, params, record){
					subtotal=Ext.util.Format.number(record.data.buku_saldo,'0,000');
                    return '<span><font color=GREEN><b>' + subtotal+ '</b></fotn></span>';
            }

		}]);

	buku_besar_ColumnModel.defaultSortable= true;
	/* End of Function */

	 var summary = new Ext.ux.grid.GroupSummary();

	/* Declare DataStore and  show datagrid list */
	buku_besarListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'buku_besarListEditorGrid',
		el: 'fp_buku_besar',
		title: 'Laporan Buku Besar dan Buku Pembantu',
		autoHeight: false,
		height: 500,
		store: buku_besar_DataStore, // DataStore
		cm: buku_besar_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_bb,
			store: buku_besar_DataStore,
			displayInfo: true
		}),
		view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
			enableGroupingMenu: false,
            hideGroupedColumn: true
        }),
		plugins: summary,
		tbar: [
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		},'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: buku_besar_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: buku_besar_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: buku_besar_print
		}
		]
	});
	buku_besarListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	buku_besar_ContextMenu = new Ext.menu.Menu({
		id: 'buku_besar_ListEditorGridContextMenu',
		items: [
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: buku_besar_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: buku_besar_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onbuku_besar_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		buku_besar_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		buku_besar_SelectedRow=rowIndex;
		buku_besar_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function buku_besar_editContextMenu(){
		buku_besar_confirm_update();
  	}
	/* End of Function */

	buku_besarListEditorGrid.addListener('rowcontextmenu', onbuku_besar_ListEditGridContextMenu);

	/* Function for action list search */
	function buku_besar_list_search(){
		// render according to a SQL date format.

		var buku_tanggal_search_date="";
		var buku_tanggalEnd_search_date="";
		var buku_akun_search=null;


		if(buku_tanggalSearchField.getValue()!==""){buku_tanggal_search_date=buku_tanggalSearchField.getValue().format('Y-m-d');}
		if(buku_tanggalEndSearchField.getValue()!==""){buku_tanggalEnd_search_date=buku_tanggalEndSearchField.getValue().format('Y-m-d');}
		if(buku_akunSearchField.getValue()!==null){buku_akun_search=buku_akunSearchField.getValue();}
		// change the store parameters
		buku_besar_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			buku_tanggal	:	buku_tanggal_search_date,
			buku_tanggalEnd	:	buku_tanggalEnd_search_date,
			buku_akun		:	buku_akun_search
		};
		
		buku_besar_DataStore.reload({params: {start: 0, limit: pageS_bb}});
	}

	/* Function for reset search result */
	function buku_besar_reset_search(){
		// reset the store parameters
		//buku_besar_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS_bb };
		// Cause the datastore to do another query :
		buku_besar_list_search();
		//buku_besar_DataStore.reload({params: {start: 0, limit: pageS_bb}});
		buku_besar_searchWindow.close();
	};
	
	buku_akun_infoLabel=new Ext.form.Label({
		html: "<font size=1>*Kosongkan field Akun untuk melihat semua Akun pada Buku Besar."
	});

	
	buku_tanggalSearchField= new Ext.form.DateField({
		id: 'buku_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d'

	});

	buku_tanggalEndSearchField= new Ext.form.DateField({
		id: 'buku_tanggalEndSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d'

	});

	buku_refSearchField= new Ext.form.TextField({
		id: 'buku_refSearchField',
		fieldLabel: 'Ref',
		maxLength: 50,
		anchor: '95%'

	});
	
	buku_akunSearchField= new Ext.form.ComboBox({
		id: 'buku_akunSearchField',
		fieldLabel: 'Akun',
		store: besar_akun_DataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS_bb,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		hideTrigger: false

	});

	buku_besar_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	buku_besar_buku_tanggalSearchField=new Ext.form.FieldSet({
		id:'buku_besar_buku_tanggalSearchField',
		title: 'Opsi Tanggal',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [buku_tanggalSearchField,buku_besar_label_tanggalField,buku_tanggalEndSearchField]
			   }
		]
	});

	/* Function for retrieve search Form Panel */
	buku_besar_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [{
						layout:'column',
						border:false,
						items:[
						{
							columnWidth:0.45,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
								buku_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [
								buku_tanggalEndSearchField
							]
						}

				        ]
					},	buku_akunSearchField, buku_akun_infoLabel]//, buku_debetSearchField, buku_kreditSearchField,buku_refSearchField

			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: buku_besar_list_search
			},{
				text: 'Close',
				handler: function(){
					buku_besar_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	buku_besar_searchWindow = new Ext.Window({
		title: 'Laporan Buku Besar &amp; Buku Pembantu',
		closable:true,
		closeAction: 'hide',
		width: 520,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_buku_besar_search',
		items: buku_besar_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!buku_besar_searchWindow.isVisible()){
			buku_besar_searchWindow.show();
		} else {
			buku_besar_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function buku_besar_print(){
		var buku_tanggal_print_date="";
		var buku_tanggalEnd_print_date="";
		var buku_akun_print=null;
		var win;
		// check if we do have some search data...
		if(buku_tanggalSearchField.getValue()!==""){buku_tanggal_print_date=buku_tanggalSearchField.getValue().format('Y-m-d');}
		if(buku_tanggalEndSearchField.getValue()!==""){buku_tanggalEnd_print_date=buku_tanggalEndSearchField.getValue().format('Y-m-d');}
		if(buku_besar_DataStore.baseParams.buku_akun!==null){buku_akun_print = buku_besar_DataStore.baseParams.buku_akun;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_buku_besar&m=get_action',
		params: {
			task: "PRINT",
			//if we are doing advanced search, use this
		  	buku_tanggal : buku_tanggal_print_date,
		  	buku_tanggalEnd : buku_tanggalEnd_print_date,
			buku_akun : buku_akun_print,
			start: 0,
			limit: pageS_bb,
		  	currentlisting: buku_besar_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/buku_besar_printlist.html','buku_besarlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
			   msg: 'Koneksi database gagal.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});
		}
		});
	}
	/* Enf Function */

	/* Function for print Export to Excel Grid */
	function buku_besar_export_excel(){
		var buku_tanggal_print_date="";
		var buku_tanggalEnd_print_date="";
		var buku_akun_print=null;
		var win;
		// check if we do have some search data...
		if(buku_tanggalSearchField.getValue()!==""){buku_tanggal_print_date=buku_tanggalSearchField.getValue().format('Y-m-d');}
		if(buku_tanggalEndSearchField.getValue()!==""){buku_tanggalEnd_print_date=buku_tanggalEndSearchField.getValue().format('Y-m-d');}
		if(buku_besar_DataStore.baseParams.buku_akun!==null){buku_akun_print = buku_besar_DataStore.baseParams.buku_akun;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_buku_besar&m=get_action',
		params: {
			task: "EXCEL",
			//if we are doing advanced search, use this
		  	buku_tanggal : buku_tanggal_print_date,
		  	buku_tanggalEnd : buku_tanggalEnd_print_date,
			buku_akun : buku_akun_print,
			start: 0,
			limit: pageS_bb,
		  	currentlisting: buku_besar_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/buku_besar_printlist.xls','buku_besarlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
			   msg: 'Koneksi database gagal.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});
		}
		});
	}
	/*End of Function */
	buku_besar_searchWindow.show();

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_buku_besar"></div>
		<div id="elwindow_buku_besar_save"></div>
        <div id="elwindow_buku_besar_search"></div>
    </div>
</div>
</body>
</html>