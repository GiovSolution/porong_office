<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: trial_balance View
	+ Description	: For record view
	+ Filename 		: v_trial_balance.php
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
var trial_balance_DataStore;
var trial_balance_ColumnModel;
var trial_balanceListEditorGrid;
var trial_balance_saveForm;
var trial_balance_saveWindow;
var trial_balance_searchForm;
var trial_balance_searchWindow;
var trial_balance_SelectedRow;
var trial_balance_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=50;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */


	/* Function for Retrieve DataStore */
	trial_balance_DataStore = new Ext.data.GroupingStore({
		id: 'trial_balance_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_trial_balance&m=get_action',
			method: 'POST',
			timeout: 3600000
		}),
		baseParams:{task: "SEARCH", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'balance_id'
		},[
			{name: 'balance_id', type: 'int', mapping: 'akun_id'},
			{name: 'balance_akun', type: 'string', mapping: 'akun_nama'},
			{name: 'balance_akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'balance_awal_jenis', type: 'string', mapping: 'akun_awal_jenis'},
			{name: 'balance_awal', type: 'float', mapping: 'akun_awal'},
			{name: 'balance_debet', type: 'float', mapping: 'akun_debet'},
			{name: 'balance_kredit', type: 'float', mapping: 'akun_kredit'},
			{name: 'balance_saldo', type: 'float', mapping: 'akun_akhir'},
			{name: 'balance_jenis', type: 'string', mapping: 'akun_jenis'} ,
			{name: 'balance_saldo_jenis', type: 'string', mapping: 'akun_akhir_jenis'},
			{name: 'balance_periode_awal', type: 'date', dateFormat: 'Y-m-d', mapping: 'akun_periode_awal'},
			{name: 'balance_periode_akhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'akun_periode_akhir'}
		]),
		//sortInfo:{field: 'balance_akun_kode', direction: "ASC"}
	});


  	/* Function for Identify of Window Column Model */
	trial_balance_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Kode',
			dataIndex: 'balance_akun_kode',
			width: 100,
			readOnly:true,
			sortable: false,
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span>&nbsp;</span>';
				}else{
					return '<span>'+record.data.balance_akun_kode+'</span>';
				}
			}
		},
		{
			header: 'Nama Rekening',
			dataIndex: 'balance_akun',
			width: 300,
			sortable: false,
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span><b>'+record.data.balance_akun+'</b></span>';
				}else{
					return '<span>'+record.data.balance_akun+'</span>';
				}
			}
		},
		{
			header: 'CR/DB',
			dataIndex: 'balance_awal_jenis',
			width: 80,
			sortable: false
		},
		{
			header: 'Beginning',
			dataIndex: 'balance_awal',
			width: 150,
			align: 'right',
			sortable: false,
			readOnly:true,
			//summaryType: 'sum',
			//renderer: Ext.util.Format.numberRenderer('0,000')
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span><b>'+Ext.util.Format.number(record.data.balance_awal,'0,000')+'</b></span>';
				}else{
						if(record.data.balance_awal<0){
						    return '<span>('+Ext.util.Format.number(Math.abs(record.data.balance_awal),'0,000')+')</span>';
						}else{
							return '<span>'+Ext.util.Format.number(record.data.balance_awal,'0,000')+'</span>';
						}
				}
			}
		},
		{
			header: 'Debet',
			dataIndex: 'balance_debet',
			width: 150,
			align: 'right',
			sortable: false,
			readOnly:true,
			//summaryType: 'sum',
			//renderer: Ext.util.Format.numberRenderer('0,000')
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span><b>'+Ext.util.Format.number(record.data.balance_debet,'0,000')+'</b></span>';
				}else{
					return '<span>'+Ext.util.Format.number(record.data.balance_debet,'0,000')+'</span>';
				}
			}
		},
		{
			header: 'Kredit',
			dataIndex: 'balance_kredit',
			width: 150,
			sortable: false,
			readOnly:true,
			//summaryType: 'sum',
			//renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right',
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span><b>'+Ext.util.Format.number(record.data.balance_kredit,'0,000')+'</b></span>';
				}else{
					return '<span>'+Ext.util.Format.number(record.data.balance_kredit,'0,000')+'</span>';
				}
			}
		},
		{
			header: 'Ending',
			dataIndex: 'balance_saldo',
			width: 150,
			readOnly:true,
			sortable: false,
			//summaryType: 'sum',
			//renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right',
			renderer: function(v, params, record){
				if(record.data.balance_akun=='TOTAL'){
					return '<span><b>'+Ext.util.Format.number(record.data.balance_saldo,'0,000')+'</b></span>';
				}else{
					if(record.data.balance_saldo<0){
						    return '<span>('+Ext.util.Format.number(Math.abs(record.data.balance_saldo),'0,000')+')</span>';
						}else{
							return '<span>'+Ext.util.Format.number(record.data.balance_saldo,'0,000')+'</span>';
						}
				}
			}
		}
		]);

	trial_balance_ColumnModel.defaultSortable= true;
	/* End of Function */

	 var summary = new Ext.ux.grid.GroupSummary();

	/* Declare DataStore and  show datagrid list */
	trial_balanceListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'trial_balanceListEditorGrid',
		el: 'fp_trial_balance',
		title: 'Laporan Trial Balance',
		autoHeight: true,
		store: trial_balance_DataStore, // DataStore
		cm: trial_balance_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: trial_balance_DataStore,
			displayInfo: true
		}),
		/*view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
			enableGroupingMenu: false,
            hideGroupedColumn: true
        }),
		plugins: summary,*/
		tbar: [
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		},'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: trial_balance_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: trial_balance_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: trial_balance_print
		}
		]
	});
	trial_balanceListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	trial_balance_ContextMenu = new Ext.menu.Menu({
		id: 'trial_balance_ListEditorGridContextMenu',
		items: [
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: trial_balance_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: trial_balance_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function ontrial_balance_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		trial_balance_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		trial_balance_SelectedRow=rowIndex;
		trial_balance_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function trial_balance_editContextMenu(){
		trial_balance_confirm_update();
  	}
	/* End of Function */

	trial_balanceListEditorGrid.addListener('rowcontextmenu', ontrial_balance_ListEditGridContextMenu);

	/* Function for action list search */
	function trial_balance_list_search(){
		// render according to a SQL date format.

		var balance_tgl_awal_search_date="";
		var balance_tgl_akhir_search_date="";


		if(balance_tgl_awalSearchField.getValue()=="" || balance_tgl_akhirSearchField.getValue()==""){

			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tanggal Pencarian harus diisi !.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});

		}else{

		if(balance_tgl_awalSearchField.getValue()!==""){balance_tgl_awal_search_date=balance_tgl_awalSearchField.getValue().format('Y-m-d');}
		if(balance_tgl_akhirSearchField.getValue()!==""){balance_tgl_akhir_search_date=balance_tgl_akhirSearchField.getValue().format('Y-m-d');}


		/*trial_balance_DataStore.baseParams = {
			task				: 'SEARCH',
			balance_tanggal		:  balance_tgl_awal_search_date,
			balance_tanggalEnd	:  balance_tgl_akhir_search_date,
			start				: 0,
			limit				: pageS
		};
		trial_balance_DataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});*/

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});

		Ext.Ajax.request({
			waitMsg: 'Please Wait...',
			url: 'index.php?c=c_trial_balance&m=trial_balance_generate',
			timeout: 3600000,
			params: {
				balance_tgl_awal	: balance_tgl_awal_search_date,
				balance_tgl_akhir	: balance_tgl_akhir_search_date
			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
				case 1:
					Ext.MessageBox.hide();
					trial_balance_searchWindow.hide();

					trial_balance_DataStore.baseParams = {
						task				: 'SEARCH',
						balance_tgl_awal	:  balance_tgl_awal_search_date,
						balance_tgl_akhir	:  balance_tgl_akhir_search_date,
						start				:  0,
						limit				:  pageS
					};

					trial_balance_DataStore.load();

					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Error, Please contact your Administrator !',
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

	}

	/* Function for reset search result */
	function trial_balance_reset_search(){
		trial_balance_list_search();
		//trial_balance_DataStore.reload({params: {start: 0, limit: pageS}});
		trial_balance_searchWindow.close();
	};
	/* End of Fuction */

	balance_tgl_awalSearchField= new Ext.form.DateField({
		id: 'balance_tgl_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		allowBlank: false
	});


	balance_tgl_akhirSearchField= new Ext.form.DateField({
		id: 'balance_tgl_akhirSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		allowBlank: false

	});


	/* Function for retrieve search Form Panel */
	trial_balance_searchForm = new Ext.FormPanel({
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
								balance_tgl_awalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [
								balance_tgl_akhirSearchField
							]
						}

				        ]
					}]

			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: trial_balance_list_search
			},{
				text: 'Close',
				handler: function(){
					trial_balance_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	trial_balance_searchWindow = new Ext.Window({
		title: 'Laporan Trial Balance',
		closable:true,
		closeAction: 'hide',
		width: 520,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_trial_balance_search',
		items: trial_balance_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!trial_balance_searchWindow.isVisible()){
			trial_balance_searchWindow.show();
		} else {
			trial_balance_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function trial_balance_print(){
		var balance_tgl_awal_print_date="";
		var balance_tgl_akhir_print_date="";
		var win;

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_trial_balance&m=get_action',
		timeout: 3600000,
		params: {
			task				: "PRINT",
		 	balance_tgl_awal	: trial_balance_DataStore.baseParams.balance_tgl_awal,
		  	balance_tgl_akhir	: trial_balance_DataStore.baseParams.balance_tgl_akhir,
			start				: trial_balance_DataStore.baseParams.start,
			limit				: trial_balance_DataStore.baseParams.limit,
		  	currentlisting		: trial_balance_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				Ext.MessageBox.hide();
				win = window.open('./print/trial_balance_printlist.html','trial_balancelist','height=600,width=800,resizable=1,scrollbars=1, menubar=1');
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
	function trial_balance_export_excel(){
		var balance_tgl_awal_2excel_date="";
		var balance_tgl_akhir_2excel_date="";

		var win;

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_trial_balance&m=get_action',
		timeout: 3600000,
		params: {
			task				: "EXCEL",
			balance_tgl_awal	: trial_balance_DataStore.baseParams.balance_tgl_awal,
		  	balance_tgl_akhir	: trial_balance_DataStore.baseParams.balance_tgl_akhir,
			start				: trial_balance_DataStore.baseParams.start,
			limit				: trial_balance_DataStore.baseParams.limit,
		  	currentlisting		: trial_balance_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				Ext.MessageBox.hide();
				win = window.open('./print/trial_balance_printlist.xls','trial_balancelist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
			   msg: 'Koneksi database gagal.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});
		}
		});
	}
	/*End of Function */
	trial_balance_searchWindow.show();
	trial_balance_DataStore.on('beforeload',function(){
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
	});

	trial_balance_DataStore.on('load',function(){
		Ext.MessageBox.hide();
	});

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_trial_balance"></div>
		<div id="elwindow_trial_balance_save"></div>
        <div id="elwindow_trial_balance_search"></div>
    </div>
</div>
</body>
</html>