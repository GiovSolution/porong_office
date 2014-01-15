<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: jurnal_harian View
	+ Description	: For record view
	+ Filename 		: v_jurnal_harian.php
 	+ creator  		:
 	+ Created on 01/Apr/2010 12:13:56

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
var jurnal_harian_DataStore;
var jurnal_harian_ColumnModel;
var jurnal_harianListEditorGrid;
var jurnal_harian_saveForm;
var jurnal_harian_saveWindow;
var jurnal_harian_searchForm;
var jurnal_harian_searchWindow;
var jurnal_harian_SelectedRow;
var jurnal_harian_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS_jh=16;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var jurnal_harian_idField;
var jurnal_harian_tanggalField;
var jurnal_harian_akunField;
var jurnal_harian_keteranganField;
var jurnal_harian_norefField;
var jurnal_harian_debetField;
var jurnal_harian_kreditField;
var jurnal_harian_unitField;
var jurnal_harian_postField;
var jurnal_harian_date_postField;
var jurnal_harian_idSearchField;
var jurnal_harian_tanggal_mulaiSearchField;
var jurnal_harian_akunSearchField;
var jurnal_harian_keteranganSearchField;
var jurnal_harian_norefSearchField;
var jurnal_harian_debetSearchField;
var jurnal_harian_kreditSearchField;
var jurnal_harian_unitSearchField;
var jurnal_harian_postSearchField;
var jurnal_harian_date_postSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */


	/* Function for Retrieve DataStore */
	jurnal_harian_DataStore = new Ext.data.GroupingStore({
		id: 'jurnal_harian_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_jurnal_harian&m=get_action',
			method: 'POST'
		}),
		groupField:'jurnal_no',
		baseParams:{task: "LIST", start: 0, limit: pageS_jh},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jurnal_no'
		},[
			{name: 'jurnal_no', type: 'string', mapping: 'no_jurnal'},
			{name: 'jurnal_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'},
			{name: 'jurnal_akun', type: 'string', mapping: 'akun_kode'},
			{name: 'jurnal_akun_nama', type: 'string', mapping: 'akun_nama'},
			{name: 'jurnal_keterangan', type: 'string', mapping: 'keterangan'},
			{name: 'jurnal_debet', type: 'float', mapping: 'debet'},
			{name: 'jurnal_kredit', type: 'float', mapping: 'kredit'},
			{name: 'jurnal_post', type: 'string', mapping: 'post'}
		]),
		sortInfo:{field: 'jurnal_tanggal', direction: "DESC"}

	});
	/* End of Function */

	Ext.ux.grid.GroupSummary.Calculations['totalSaldo'] = function(v, record, field){
        return v + (record.data.jurnal_debet-record.data.jurnal_kredit);
    };

  	/* Function for Identify of Window Column Model */
	jurnal_harian_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Tanggal',
			dataIndex: 'jurnal_tanggal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			readOnly: true
		},
		{
			header: 'No Jurnal',
			dataIndex: 'jurnal_no',
			width: 100,
			sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
				var jurnal_no="";
				if(record.data.jurnal_post=='Y')
					jurnal_no='<b><font color=RED>'+record.data.jurnal_no+'</font></b>';
				else
					jurnal_no='<b>'+record.data.jurnal_no+'</b>';

                return '<span>' + jurnal_no+ '</span>';
            }
		},
		{
			header: 'Nama Akun',
			dataIndex: 'jurnal_akun_nama',
			width: 200,
			sortable: true,
			readOnly: true
		},
		{
			header: 'Kode',
			dataIndex: 'jurnal_akun',
			width: 100,
			sortable: true,
			readOnly: true,
			summaryType: 'count',
				hideable: false,
				summaryRenderer: function(v, params, data){
					return ((v === 0 || v > 1) ? '(' + v +' data transaksi)' : '(1 data transaksi)');
			}
		},
		{
			header: 'Keterangan',
			dataIndex: 'jurnal_keterangan',
			width: 200,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 50
			})
		},
		{
			header: 'Nilai Debet (Rp)',
			dataIndex: 'jurnal_debet',
			width: 100,
			align: 'right',
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		},
		{
			header: 'Nilai Kredit (Rp)',
			dataIndex: 'jurnal_kredit',
			width: 100,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			summaryType: 'sum',
			sortable: true,
			readOnly: true
		}]);

	jurnal_harian_ColumnModel.defaultSortable= true;
	/* End of Function */
    var summary = new Ext.ux.grid.GroupSummary();

	/* Declare DataStore and  show datagrid list */
	jurnal_harianListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'jurnal_harianListEditorGrid',
		el: 'fp_jurnal_harian',
		title: 'Laporan Jurnal Harian',
		autoHeight: true,
		store: jurnal_harian_DataStore, // DataStore
		cm: jurnal_harian_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_jh,
			store: jurnal_harian_DataStore,
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
		}, '-',
			new Ext.app.SearchField({
			store: jurnal_harian_DataStore,
			params: {start: 0, limit: pageS_jh},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: jurnal_harian_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jurnal_harian_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jurnal_harian_print
		}
		]
	});
	jurnal_harianListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	jurnal_harian_ContextMenu = new Ext.menu.Menu({
		id: 'jurnal_harian_ListEditorGridContextMenu',
		items: [
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jurnal_harian_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jurnal_harian_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onjurnal_harian_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		jurnal_harian_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		jurnal_harian_SelectedRow=rowIndex;
		jurnal_harian_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function jurnal_harian_editContextMenu(){
		jurnal_harian_confirm_update();
  	}
	/* End of Function */

	jurnal_harianListEditorGrid.addListener('rowcontextmenu', onjurnal_harian_ListEditGridContextMenu);
	jurnal_harian_DataStore.load({params: {start: 0, limit: pageS_jh}});	// load DataStore

	/* Function for action list search */
	function jurnal_harian_list_search(){
		// render according to a SQL date format.
		var jurnal_no_search=null;
		var jurnal_tanggal_mulai_search_date="";
		var jurnal_tanggal_akhir_search_date="";

		if(jurnal_harian_noSearchField.getValue()!==null){jurnal_no_search=jurnal_harian_noSearchField.getValue();}
		if(jurnal_harian_tanggal_mulaiSearchField.getValue()!==""){jurnal_tanggal_mulai_search_date=jurnal_harian_tanggal_mulaiSearchField.getValue().format('Y-m-d');}
		if(jurnal_harian_tanggal_akhirSearchField.getValue()!==""){jurnal_tanggal_akhir_search_date=jurnal_harian_tanggal_akhirSearchField.getValue().format('Y-m-d');}

		// change the store parameters
		jurnal_harian_DataStore.baseParams = {
			task				: 'SEARCH',
			jurnal_tgl_awal		:	jurnal_tanggal_mulai_search_date,
			jurnal_tgl_akhir	:	jurnal_tanggal_akhir_search_date,
			jurnal_no			:	jurnal_no_search
		};
		jurnal_harian_DataStore.reload({params: {start: 0, limit: pageS_jh}});
	}

	/* Function for reset search result */
	function jurnal_harian_reset_search(){
		jurnal_harian_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS_jh };
		jurnal_harian_DataStore.reload({params: {start: 0, limit: pageS_jh}});
		jurnal_harian_searchWindow.close();
	};
	/* End of Fuction */


	/* Identify  jurnal_tanggal Search Field */
	jurnal_harian_tanggal_mulaiSearchField= new Ext.form.DateField({
		id: 'jurnal_harian_tanggal_mulaiSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d'

	});

		/* Identify  jurnal_tanggal Search Field */
	jurnal_harian_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'jurnal_harian_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d'

	});

	/* Identify  jurnal_akun Search Field */
	jurnal_harian_noSearchField= new Ext.form.TextField({
		id: 'jurnal_harian_noSearchField',
		fieldLabel: 'No Jurnal',
		anchor: '95%'
	});


	/* Function for retrieve search Form Panel */
	jurnal_harian_searchForm = new Ext.FormPanel({
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
							columnWidth:0.5,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [jurnal_harian_tanggal_mulaiSearchField]
						},
						{
							columnWidth:0.5,
							layout: 'form',
							border:false,
							labelWidth:20,
							defaultType: 'datefield',
							items: [jurnal_harian_tanggal_akhirSearchField]
						}

				        ]
						},jurnal_harian_noSearchField
						]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: jurnal_harian_list_search
			},{
				text: 'Close',
				handler: function(){
					jurnal_harian_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */



	/* Function for retrieve search Window Form, used for andvaced search */
	jurnal_harian_searchWindow = new Ext.Window({
		title: 'Pencarian Jurnal',
		closable:true,
		closeAction: 'hide',
		width: 520,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_jurnal_harian_search',
		items: jurnal_harian_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!jurnal_harian_searchWindow.isVisible()){
			jurnal_harian_searchWindow.show();
		} else {
			jurnal_harian_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function jurnal_harian_print(){
		var searchquery = "";

		var jurnal_no_print=null;
		var jurnal_tanggal_mulai_print_date="";
		var jurnal_tanggal_akhir_print_date="";

		// check if we do have some search data...
		if(jurnal_harian_DataStore.baseParams.query!==null){searchquery = jurnal_harian_DataStore.baseParams.query;}
		if(jurnal_harian_DataStore.baseParams.jurnal_no!==null){jurnal_no_print = jurnal_harian_DataStore.baseParams.jurnal_no;}
		if(jurnal_harian_DataStore.baseParams.jurnal_tgl_awal!==null){ jurnal_tgl_awal_print = jurnal_harian_DataStore.baseParams.jurnal_tgl_awal; }
		if(jurnal_harian_DataStore.baseParams.jurnal_tgl_akhir!==null){ jurnal_tgl_akhir_print = jurnal_harian_DataStore.baseParams.jurnal_tgl_akhir; }

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jurnal_harian&m=get_action',
		timeOut: 300,
		params: {
			task				: "PRINT",
		  	query				: searchquery,
			jurnal_no			: jurnal_no_print,
			jurnal_tgl_awal 	: jurnal_tgl_awal_print,
			jurnal_tgl_akhir	: jurnal_tgl_akhir_print,
		  	currentlisting		: jurnal_harian_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/jurnal_harian_printlist.html','jurnal_harianlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function jurnal_harian_export_excel(){
		var searchquery = "";

		var jurnal_no_print=null;
		var jurnal_tanggal_mulai_print_date="";
		var jurnal_tanggal_akhir_print_date="";

		// check if we do have some search data...
		if(jurnal_harian_DataStore.baseParams.query!==null){searchquery = jurnal_harian_DataStore.baseParams.query;}
		if(jurnal_harian_DataStore.baseParams.jurnal_no!==null){jurnal_no_excel = jurnal_harian_DataStore.baseParams.jurnal_no;}
		if(jurnal_harian_DataStore.baseParams.jurnal_tgl_awal!==null){ jurnal_tgl_awal_excel = jurnal_harian_DataStore.baseParams.jurnal_tgl_awal; }
		if(jurnal_harian_DataStore.baseParams.jurnal_tgl_akhir!==null){ jurnal_tgl_akhir_excel = jurnal_harian_DataStore.baseParams.jurnal_tgl_akhir; }


		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jurnal_harian&m=get_action',
		timeOut: 300,
		params: {
			task				: "EXCEL",
		  	query				: searchquery,
			jurnal_no			: jurnal_no_excel,
			jurnal_tgl_awal 	: jurnal_tgl_awal_excel,
			jurnal_tgl_akhir	: jurnal_tgl_akhir_excel,
		  	currentlisting		: jurnal_harian_DataStore.baseParams.task
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./print/jurnal_harian_printlist.xls');
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


});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_jurnal_harian"></div>
        <div id="fp_detail_jurnal"></div>
		<div id="elwindow_jurnal_harian_save"></div>
        <div id="elwindow_jurnal_harian_search"></div>
    </div>
</div>
</body>
</html>