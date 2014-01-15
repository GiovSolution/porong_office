<?
/* 	
	GIOV Solution - Keep IT Simple -
	
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
var bs_DataStore;
var bs_ColumnModel;
var bs_ListEditorGrid;
var bs_createForm;
var bs_createWindow;
var bs_searchForm;
var bs_searchWindow;
var bs_SelectedRow;
var bs_ContextMenu;
//declare konstant
var post2db_bs = '';
var msg_bs = '';
var pageS_bs=15;

/* declare variable here */
var bank_idField;
var bank_kodeField;
var bank_namaField;
var bank_norekField;
var kas_tanggalField;
var bank_saldoField;
var kas_keteranganField;
var kas_jumlahField;
var bs_kodeField;
var kas_tipeField;

var bank_idSearchField;
var bank_kodeSearchField;
var bank_namaSearchField;
var bank_norekSearchField;
var bank_atasnamaSearchField;
var bank_saldoSearchField;
var bank_keteranganSearchField;
var bank_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	// utilize custom extension for Group Summary
    var summary = new Ext.ux.grid.GroupSummary();

  	/* Function for Saving inLine Editing */
	function bank_update(oGrid_event){
	var bank_id_update_pk="";
	var bank_kode_update=null;
	var bank_nama_update=null;
	var bank_norek_update=null;
	var bank_atasnama_update=null;
	var bank_saldo_update=null;
	var bank_keterangan_update=null;
	var bank_aktif_update=null;

	bank_id_update_pk = oGrid_event.record.data.bank_id;
	if(oGrid_event.record.data.bank_kode!== null){bank_kode_update = oGrid_event.record.data.bank_kode;}
	if(oGrid_event.record.data.bank_nama!== null){bank_nama_update = oGrid_event.record.data.bank_nama;}
	if(oGrid_event.record.data.bank_norek!== null){bank_norek_update = oGrid_event.record.data.bank_norek;}
	if(oGrid_event.record.data.bank_atasnama!== null){bank_atasnama_update = oGrid_event.record.data.bank_atasnama;}
	if(oGrid_event.record.data.bank_saldo!== null){bank_saldo_update = oGrid_event.record.data.bank_saldo;}
	if(oGrid_event.record.data.bank_keterangan!== null){bank_keterangan_update = oGrid_event.record.data.bank_keterangan;}
	if(oGrid_event.record.data.bank_aktif!== null){bank_aktif_update = oGrid_event.record.data.bank_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_bs&m=get_action',
			params: {
				task: "UPDATE",
				bank_id	: bank_id_update_pk,				
				bank_kode	:bank_kode_update,		
				bank_nama	:bank_nama_update,		
				bank_norek	:bank_norek_update,		
				bank_atasnama	:bank_atasnama_update,		
				bank_saldo	:bank_saldo_update,		
				bank_keterangan	:bank_keterangan_update,		
				bank_aktif	:bank_aktif_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						bs_DataStore.commitChanges();
						bs_DataStore.reload();
						total_kas_list_DataStore.reload();
						break;
					case 2:
						bs_DataStore.reload();
						total_kas_list_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg_bs: 'Data Bon Sementara tidak bisa disimpan.',
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
							   msg_bs: 'Tidak bisa terhubung dengan database server',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function kas_create(){
		if(is_kas_form_valid()){
		
		var kas_id_create_pk=null;
		var kas_tanggal_create=null;
		var kas_nominal_create=null;
		var bs_kode_create=null;
		var kas_keterangan_create=null;
		var kas_aktif_create=null;

		kas_id_create_pk=get_pk_id();
		if(kas_tanggalField.getValue()!== null){kas_tanggal_create = kas_tanggalField.getValue();}
		if(kas_jumlahField.getValue()!== null){kas_nominal_create = convertToNumber(kas_jumlahField.getValue());} 
		if(bs_kodeField.getValue()!== null){bs_kode_create = bs_kodeField.getValue();} 
		if(kas_keteranganField.getValue()!== null){kas_keterangan_create = kas_keteranganField.getValue();}
		if(kas_tipeField.getValue()!== null){kas_aktif_create = kas_tipeField.getValue();}

		Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_bs&m=get_action',
				params: {
					task				: post2db_bs,
					kas_id				: kas_id_create_pk,
					kas_tanggal			: kas_tanggal_create,
					bs_kode				: bs_kode_create,
					kas_jumlah			: kas_nominal_create,
					kas_keterangan		: kas_keterangan_create,
					kas_tipe			: kas_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db_bs+' OK','Data Bon Sementara berhasil disimpan.');
							bs_DataStore.reload();
							total_kas_list_DataStore.reload();
							bs_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg_bs: 'Data Bon Sementara tidak bisa disimpan!.',
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
						   msg_bs: 'Tidak bisa terhubung dengan database server',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Isian belum sempurna!',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db_bs=='UPDATE')
			return bs_ListEditorGrid.getSelectionModel().getSelected().get('kas_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function kas_reset_form(){
		kas_tanggalField.reset();
		kas_tanggalField.setValue(null);
		kas_jumlahField.reset();
		kas_jumlahField.setValue(null);
		bs_kodeField.reset();
		bs_kodeField.setValue(null);
		kas_keteranganField.reset();
		kas_keteranganField.setValue(null);
		kas_tipeField.reset();
		kas_tipeField.setValue('Kas Masuk');
		kas_jumlahField.setValue(0);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function kas_set_form(){
		kas_tanggalField.setValue(bs_ListEditorGrid.getSelectionModel().getSelected().get('kas_tanggal'));
		kas_jumlahField.setValue(CurrencyFormatted(bs_ListEditorGrid.getSelectionModel().getSelected().get('kas_jumlah')));
		bs_kodeField.setValue(bs_ListEditorGrid.getSelectionModel().getSelected().get('bs_kode'));
		kas_keteranganField.setValue(bs_ListEditorGrid.getSelectionModel().getSelected().get('kas_keterangan'));
		kas_tipeField.setValue(bs_ListEditorGrid.getSelectionModel().getSelected().get('kas_tipe'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_kas_form_valid(){
		return (kas_tanggalField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!bs_createWindow.isVisible()){
			
			post2db_bs='CREATE';
			msg_bs='created';
			kas_reset_form();
			
			bs_createWindow.show();
		} else {
			bs_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function bank_confirm_delete(){
		// only one bank is selected here
		if(bs_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', bank_delete);
		} else if(bs_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', bank_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg_bs: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function kas_confirm_update(){
		/* only one record is selected here */
		if(bs_ListEditorGrid.selModel.getCount() == 1) {
			
			post2db_bs='UPDATE';
			msg_bs='updated';
			kas_set_form();
			
			bs_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg_bs: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function bank_delete(btn){
		if(btn=='yes'){
			var selections = bs_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< bs_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.bank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_bs&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							bs_DataStore.reload();
							total_kas_list_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg_bs: 'Tidak bisa menghapus data yang diplih',
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
					   msg_bs: 'Tidak bisa terhubung dengan database server',
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
	bs_DataStore = new Ext.data.Store({
		id: 'bs_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bs&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS_bs}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kas_id'
		},[
			{name: 'kas_id', type: 'int', mapping: 'bs_id'},
			{name: 'kas_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'bs_tanggal'},
			{name: 'kas_jumlah', type: 'float', mapping: 'bs_jumlah'},
			{name: 'bs_kode', type: 'string', mapping: 'bs_kode'},
			{name: 'kas_keterangan', type: 'string', mapping: 'bs_keterangan'},
			{name: 'kas_tipe', type: 'string', mapping: 'bs_tipe'},
			{name: 'kas_creator', type: 'string', mapping: 'bs_creator'},
			{name: 'kas_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'bs_date_create'},
			{name: 'trucking_update', type: 'string', mapping: 'trucking_update'},
			{name: 'kas_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'bs_date_update'},
			{name: 'trucking_revised', type: 'int', mapping: 'trucking_revised'}
		]),
		sortInfo:{field: 'kas_tanggal', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_bank_akunDataStore = new Ext.data.Store({
		id: 'cbo_bank_akunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bs&m=get_akun_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'bank_akun_value', type: 'int', mapping: 'akun_id'},
			{name: 'bank_akun_display', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'bank_akun_value', direction: "ASC"}
	});
	
	cbo_bank_mbankDataStore = new Ext.data.Store({
	id: 'cbo_bank_mbankDataStore',
	proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bs&m=get_mbank_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
			{name: 'bank_mbank_value', type: 'int', mapping: 'mbank_id'},
			{name: 'bank_mbank_display', type: 'string', mapping: 'mbank_nama'}
		]),
	sortInfo:{field: 'bank_mbank_display', direction: "ASC"}
	});
	
	/* Start List Saldo Akhir */
	total_kas_list_DataStore = new Ext.data.GroupingStore({
		id: 'total_kas_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bs&m=saldo_akhir_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS_bs}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
		},[

			{name: 'kas_saldo', type: 'float', mapping: 'kas_saldo'}

		]),
		sortInfo:{field: 'kas_saldo', direction: "ASC"}
		//groupField: 'customer_nama'
	});
	/* End DataStore */


  	/* Function for Identify of Window Column Model */
	bs_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'kas_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'BS No Bukti',
			dataIndex: 'bs_kode',
			width: 150,
			hidden: false,
			sortable: true
		},
		{
			header: 'Tanggal',
			dataIndex: 'kas_tanggal',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		},
		{
			header: 'Keterangan',
			dataIndex: 'kas_keterangan',
			width: 150,
			hidden: false,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: true,
				maxLength: 500
			})
			<?php } ?>
		},
		{
			header: 'Nominal',
			dataIndex: 'kas_jumlah',
			align: 'right',
			width: 150,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		/*
		{
			header: 'Status',
			dataIndex: 'kas_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['kas_tipe_value', 'kas_tipe_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'kas_tipe_display',
               	valueField: 'kas_tipe_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		*/
		{
			header: 'Creator',
			dataIndex: 'kas_creator',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Create on',
			dataIndex: 'kas_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Last Update By',
			dataIndex: 'trucking_update',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Last Update on',
			dataIndex: 'kas_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Revised',
			dataIndex: 'trucking_revised',
			width: 150,
			sortable: true,
			hidden:true
		}]
	);
	bs_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	//ColumnModel for Detail Remarks
	total_kas_list_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Saldo Akhir' + '</div>',
			align : 'Right',
			dataIndex: 'kas_saldo',
			width: 800,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		}]
    );
    total_kas_list_ColumnModel.defaultSortable= true;


	var total_kas_panel = new Ext.grid.GridPanel({
		id: 'total_kas_panel',
		title: 'Saldo Akhir',
        store: total_kas_list_DataStore,
        cm: total_kas_list_ColumnModel,
		// view: new Ext.grid.GroupingView({
            // forceFit:true,
            // groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        // }),
		// plugins: summary,
        stripeRows: true,
        // autoExpandColumn: 'customer_nama',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 800,	//800
        hidden : true
    });
    total_kas_panel.render('fp_total_saldo');


	/* Declare DataStore and  show datagrid list */
	bs_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'bs_ListEditorGrid',
		el: 'fp_kas',
		title: 'Bon Sementara',
		autoHeight: true,
		store: bs_DataStore, // DataStore
		cm: bs_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_bs,
			store: bs_DataStore,
			displayInfo: true
		}),

		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kas_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		/*{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			disabled:true,
			handler: display_form_search_window 
		}, '-',*/ 
			new Ext.app.SearchField({
			store: bs_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS_bs},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						bs_DataStore.baseParams={task:'LIST',start: 0, limit: pageS_bs};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Keterangan -'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: kas_reset_search,
			iconCls:'icon-refresh'
		}
		]
	});
	bs_ListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	bs_ContextMenu = new Ext.menu.Menu({
		id: 'bank_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: kas_confirm_update 
		}/*,
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: bank_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kas_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kas_export_excel 
		}*/
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onkas_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		bs_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		bs_SelectedRow=rowIndex;
		bs_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function kas_editContextMenu(){
      bs_ListEditorGrid.startEditing(bs_SelectedRow,1);
  	}
	/* End of Function */
  	
	bs_ListEditorGrid.addListener('rowcontextmenu', onkas_ListEditGridContextMenu);
	bs_DataStore.load({params: {start: 0, limit: pageS_bs}});	// load DataStore
	total_kas_list_DataStore.load();
	bs_ListEditorGrid.on('afteredit', bank_update); // inLine Editing Record
	
	// cbo_bank_akunDataStore.load();
	
	/* Identify  bank_atasnama Field */
	kas_tanggalField= new Ext.form.DateField({
		id: 'kas_tanggalField',
		fieldLabel: 'Tanggal <span style="color: #ec0000">*</span>',
		allowBlank: false,
		format : 'd-m-Y',
		anchor: '75%'
	});
	/* Identify  kas_jumlah Field */
	bs_kodeField= new Ext.form.TextField({
		id: 'bs_kodeField',
		fieldLabel: 'Kode',
		emptyText : '(Auto)',
		readOnly:true,
		disabled : true,
		anchor: '95%'
	});
	/* Identify  kas_jumlah Field */
	kas_jumlahField= new Ext.form.TextField({
		id: 'kas_jumlahField',
		fieldLabel: 'Nominal',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		maskRe: /([0-9]+)$/,
		anchor: '95%'
	});
	/* Identify  kas_keterangan Field */
	kas_keteranganField= new Ext.form.TextArea({
		id: 'kas_keteranganField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  kas_aktif Field */
	kas_tipeField= new Ext.form.ComboBox({
		id: 'kas_tipeField',
		fieldLabel: 'Tipe',
		store:new Ext.data.SimpleStore({
			fields:['kas_tipe_value', 'kas_tipe_display'],
			data:[['Kas Masuk','Kas Masuk'],['Kas Keluar','Kas Keluar']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Kas Masuk',
		displayField: 'kas_tipe_display',
		valueField: 'kas_tipe_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	bs_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kas_tanggalField, bs_kodeField, kas_jumlahField, kas_keteranganField/*, kas_tipeField*/] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KAS'))){ ?>
			{
				text: 'Save and Close',
				handler: kas_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					bs_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	bs_createWindow= new Ext.Window({
		id: 'bs_createWindow',
		title: post2db_bs+'Kas',
		closable:true,
		closeAction: 'hide',
		Width: 600,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kas_create',
		items: bs_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function kas_list_search(){
		// render according to a SQL date format.
		var bank_id_search=null;
		var bank_kode_search=null;
		var bank_nama_search=null;
		var bank_norek_search=null;
		var bank_atasnama_search=null;
		var bank_saldo_search=null;
		var bank_keterangan_search=null;
		var bank_aktif_search=null;

		if(bank_idSearchField.getValue()!==null){bank_id_search=bank_idSearchField.getValue();}
		if(bank_kodeSearchField.getValue()!==null){bank_kode_search=bank_kodeSearchField.getValue();}
		if(bank_namaSearchField.getValue()!==null){bank_nama_search=bank_namaSearchField.getValue();}
		if(bank_norekSearchField.getValue()!==null){bank_norek_search=bank_norekSearchField.getValue();}
		if(bank_atasnamaSearchField.getValue()!==null){bank_atasnama_search=bank_atasnamaSearchField.getValue();}
		if(bank_saldoSearchField.getValue()!==null){bank_saldo_search=bank_saldoSearchField.getValue();}
		if(bank_keteranganSearchField.getValue()!==null){bank_keterangan_search=bank_keteranganSearchField.getValue();}
		if(bank_aktifSearchField.getValue()!==null){bank_aktif_search=bank_aktifSearchField.getValue();}
		// change the store parameters
		bs_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS_bs,
			//variable here
			bank_id	:	bank_id_search, 
			bank_kode	:	bank_kode_search, 
			bank_nama	:	bank_nama_search, 
			bank_norek	:	bank_norek_search, 
			bank_atasnama	:	bank_atasnama_search, 
			bank_saldo	:	bank_saldo_search, 
			bank_keterangan	:	bank_keterangan_search, 
			bank_aktif	:	bank_aktif_search
		};
		// Cause the datastore to do another query : 
		bs_DataStore.reload({params: {start: 0, limit: pageS_bs}});
	}
		
	/* Function for reset search result */
	function kas_reset_search(){
		// reset the store parameters
		bs_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		bs_DataStore.reload({params: {start: 0, limit: pageS_bs}});
		total_kas_list_DataStore.reload({params: {start: 0, limit: pageS_bs}});
		//bs_searchWindow.close();
	};
	/* End of Fuction */
	
	function bank_reset_SearchForm(){
		bank_kodeSearchField.reset();
		bank_kodeSearchField.setValue(null);
		bank_namaSearchField.reset();
		bank_namaSearchField.setValue(null);
		bank_norekSearchField.reset();
		bank_norekSearchField.setValue(null);
		bank_atasnamaSearchField.reset();
		bank_atasnamaSearchField.setValue(null);
		bank_saldoSearchField.reset();
		bank_saldoSearchField.setValue(null);
		bank_keteranganSearchField.reset();
		bank_keteranganSearchField.setValue(null);
		bank_aktifSearchField.reset();
		bank_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  bank_id Search Field */
	bank_idSearchField= new Ext.form.NumberField({
		id: 'bank_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_kode Search Field */
	bank_kodeSearchField= new Ext.form.ComboBox({
		id: 'bank_kodeSearchField',
		fieldLabel: 'Kode Akun',
		store: cbo_bank_akunDataStore,
		mode: 'local',
		displayField: 'bank_akun_display',
		valueField: 'bank_akun_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  bank_nama Search Field */
	bank_namaSearchField= new Ext.form.ComboBox({
		id: 'bank_namaSearchField',
		fieldLabel: 'Nama Bank',
		typeAhead: true,
		triggerAction: 'all',
		store: cbo_bank_mbankDataStore,
		mode: 'remote',
		displayField: 'bank_mbank_display',
		valueField: 'bank_mbank_value',
		lazyRender:true,
		anchor: '95%',
		listClass: 'x-combo-list-small'
	});
	/* Identify  bank_norek Search Field */
	bank_norekSearchField= new Ext.form.TextField({
		id: 'bank_norekSearchField',
		fieldLabel: 'No. Rekening',
		maxLength: 250,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_atasnama Search Field */
	bank_atasnamaSearchField= new Ext.form.TextField({
		id: 'bank_atasnamaSearchField',
		fieldLabel: 'Atas Nama',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  bank_saldo Search Field */
	bank_saldoSearchField= new Ext.form.NumberField({
		id: 'bank_saldoSearchField',
		fieldLabel: 'Saldo',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_keterangan Search Field */
	bank_keteranganSearchField= new Ext.form.TextArea({
		id: 'bank_keteranganSearchField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  bank_aktif Search Field */
	bank_aktifSearchField= new Ext.form.ComboBox({
		id: 'bank_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'bank_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'bank_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	
	/* Function for retrieve search Form Panel */
	bs_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [bank_namaSearchField, bank_norekSearchField, bank_atasnamaSearchField, bank_saldoSearchField, bank_keteranganSearchField,
						bank_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kas_list_search
			},{
				text: 'Close',
				handler: function(){
					bs_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	bs_searchWindow = new Ext.Window({
		title: 'Pencarian Bon Sementara',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kas_search',
		items: bs_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!bs_searchWindow.isVisible()){
			bank_reset_SearchForm();
			bs_searchWindow.show();
		} else {
			bs_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function kas_print(){
		var searchquery = "";
		var bank_kode_print=null;
		var bank_nama_print=null;
		var bank_norek_print=null;
		var bank_atasnama_print=null;
		var bank_saldo_print=null;
		var bank_keterangan_print=null;
		var bank_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(bs_DataStore.baseParams.query!==null){searchquery = bs_DataStore.baseParams.query;}
		if(bs_DataStore.baseParams.bank_kode!==null){bank_kode_print = bs_DataStore.baseParams.bank_kode;}
		if(bs_DataStore.baseParams.bank_nama!==null){bank_nama_print = bs_DataStore.baseParams.bank_nama;}
		if(bs_DataStore.baseParams.bank_norek!==null){bank_norek_print = bs_DataStore.baseParams.bank_norek;}
		if(bs_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_print = bs_DataStore.baseParams.bank_atasnama;}
		if(bs_DataStore.baseParams.bank_saldo!==null){bank_saldo_print = bs_DataStore.baseParams.bank_saldo;}
		if(bs_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_print = bs_DataStore.baseParams.bank_keterangan;}
		if(bs_DataStore.baseParams.bank_aktif!==null){bank_aktif_print = bs_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bs&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_print,
			bank_nama : bank_nama_print,
			bank_norek : bank_norek_print,
			bank_atasnama : bank_atasnama_print,
			bank_saldo : bank_saldo_print,
			bank_keterangan : bank_keterangan_print,
			bank_aktif : bank_aktif_print,
		  	currentlisting: bs_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./banklist.html','banklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg_bs: 'Tidak bisa mencetak data!',
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
			   msg_bs: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function kas_export_excel(){
		var searchquery = "";
		var bank_kode_2excel=null;
		var bank_nama_2excel=null;
		var bank_norek_2excel=null;
		var bank_atasnama_2excel=null;
		var bank_saldo_2excel=null;
		var bank_keterangan_2excel=null;
		var bank_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(bs_DataStore.baseParams.query!==null){searchquery = bs_DataStore.baseParams.query;}
		if(bs_DataStore.baseParams.bank_kode!==null){bank_kode_2excel = bs_DataStore.baseParams.bank_kode;}
		if(bs_DataStore.baseParams.bank_nama!==null){bank_nama_2excel = bs_DataStore.baseParams.bank_nama;}
		if(bs_DataStore.baseParams.bank_norek!==null){bank_norek_2excel = bs_DataStore.baseParams.bank_norek;}
		if(bs_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_2excel = bs_DataStore.baseParams.bank_atasnama;}
		if(bs_DataStore.baseParams.bank_saldo!==null){bank_saldo_2excel = bs_DataStore.baseParams.bank_saldo;}
		if(bs_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_2excel = bs_DataStore.baseParams.bank_keterangan;}
		if(bs_DataStore.baseParams.bank_aktif!==null){bank_aktif_2excel = bs_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bs&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_2excel,
			bank_nama : bank_nama_2excel,
			bank_norek : bank_norek_2excel,
			bank_atasnama : bank_atasnama_2excel,
			bank_saldo : bank_saldo_2excel,
			bank_keterangan : bank_keterangan_2excel,
			bank_aktif : bank_aktif_2excel,
		  	currentlisting: bs_DataStore.baseParams.task // this tells us if we are searching or not
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
					msg_bs: 'Tidak bisa meng-export data ke dalam format excel!',
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
			   msg_bs: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */
	
	kas_jumlahField.on('focus',function(){ kas_jumlahField.setValue(convertToNumber(kas_jumlahField.getValue())); });
	kas_jumlahField.on('blur',function(){ kas_jumlahField.setValue(CurrencyFormatted(kas_jumlahField.getValue())); });
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_kas"></div>
        <div id="fp_total_saldo"></div>
		<div id="elwindow_kas_create"></div>
        <div id="elwindow_kas_search"></div>
    </div>
</div>
</body>