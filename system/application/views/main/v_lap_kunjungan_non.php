<?
/* 
	+ Module  		: Laporan Kunjungan Non Transaksi View
	+ Description	: Melihan Laporan Kunjungan Non-Transaksi
	+ Filename 		: v_lap_kunjungan_non.php
 	+ Author  		: Fred
	
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
Ext.namespace('Ext.ux.plugin');

Ext.ux.plugin.triggerfieldTooltip = function(config){
    Ext.apply(this, config);
};

Ext.extend(Ext.ux.plugin.triggerfieldTooltip, Ext.util.Observable,{
    init: function(component){
        this.component = component;
        this.component.on('render', this.onRender, this);
    },
    
    //private
    onRender: function(){
        if(this.component.tooltip){
            if(typeof this.component.tooltip == 'object'){
                Ext.QuickTips.register(Ext.apply({
                      target: this.component.trigger
                }, this.component.tooltip));
            } else {
                this.component.trigger.dom[this.component.tooltipType] = this.component.tooltip;
            }
        }
    }
}); 

Ext.apply(Ext.form.VTypes, {
    daterange : function(val, field) {
        var date = field.parseDate(val);

        if(!date){
            return;
        }
        if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
            var start = Ext.getCmp(field.startDateField);
            start.setMaxValue(date);
            start.validate();
            this.dateRangeMax = date;
        } 
        else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
            var end = Ext.getCmp(field.endDateField);
            end.setMinValue(date);
            end.validate();
            this.dateRangeMin = date;
        }
        /*
         * Always return true since we're only using this vtype to set the
         * min/max allowed values (these are tested for after the vtype test)
         */
        return true;
    }
});
/* declare function */		
var lap_kunjungan_nontrans_DataStore;
var lap_totalkunjungan_nonDataStore;
var lap_kunjungan_nontrans_ColumnModel;
var lap_totalkunjungan_nonColumnModel;
var lap_kunjungan_nonListEditorGrid;
var lap_kunjungan_nonListEditorGrid2;
var lap_kunjungan_nonSearchForm;
var lap_kunjungan_nonSearchWindow;
var lap_kunjungan_nonSelectedRow;
var lap_kunjungan_nonContextMenu;
//for detail data
var lap_kunjungannondetailListEditorGrid;

var today=new Date().format('d-m-Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
//var lap_kunjungan_idField;
var lap_kunjungan_non_idSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

	function is_lap_kunjungan_non_searchForm_valid(){
		return (Ext.getCmp('lap_kunjungan_non_tglStartSearchField').isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	lap_kunjungan_nontrans_DataStore = new Ext.data.Store({
		id: 'lap_kunjungan_nontrans_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan_non&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_kunjungan_nontrans_ColumnModel, Mapping => for initiate table column */ 
			{name: 'tgl_tindakan', type: 'date', dateFormat: 'Y-m-d', mapping: 'tgl_tindakan'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jumlah_cust', type: 'int', mapping: 'count(distinct cust)'},
			{name: 'jum_cust_produk', type: 'int', mapping: 'sum(jum_cust_produk)'},
			{name: 'jum_cust_kelamin', type: 'int', mapping: 'sum(jum_cust_kelamin)'}
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for summary kredit data store */ 
	lap_totalkunjungan_nonDataStore = new Ext.data.Store({
		id: 'lap_totalkunjungan_nonDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_kunjungan_non&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjungan_nontrans_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jumlah_cust', type: 'int', mapping: 'jumlah'},
			{name: 'dtrawat_kredit', type: 'int', mapping: 'total_cust'},
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
  	/* Function for Identify of Window Column Model */
	lap_kunjungan_nontrans_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'tgl_tindakan',
			width: 100,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			sortable: true
		}, 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Kunjungan' + '</div>',
			dataIndex: 'jumlah_cust',
			width: 80,	//55,
			sortable: true
		},
	]);
	
	lap_kunjungan_nontrans_ColumnModel.defaultSortable= true;
	/* End of Function */
	 
	lap_totalkunjungan_nonColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="right">' + 'Total Kunjungan Non Transaksi' + '</div>',
			dataIndex: 'jumlah_cust',
			width: 80,	//55,
			sortable: true
		},
		]);
	
	lap_totalkunjungan_nonColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	lap_kunjungan_nonListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjungan_nonListEditorGrid',
		el: 'fp_lap_kunjungan_non',
		title: 'Laporan Jumlah Kunjungan Non Transaksi',
		autoHeight: true,
		store: lap_kunjungan_nontrans_DataStore, // DataStore
		cm: lap_kunjungan_nontrans_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			//pageSize: pageS,
			disabled:true,
			store: lap_kunjungan_nontrans_DataStore,
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
			{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled : true,
			handler: lap_kunjungan_non_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled : true,
			handler: lap_kunjungan_non_print  
		}
		]
	});
	lap_kunjungan_nonListEditorGrid.render();
	/* End of DataStore */
	
	lap_kunjungan_nonListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjungan_nonListEditorGrid2',
		el: 'fp_lap_kunjungan_non2',
		title: '',
		autoHeight: true,
		store: lap_totalkunjungan_nonDataStore, // DataStore
		cm: lap_totalkunjungan_nonColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600, //940,//1200,	//970,
	
		/* Add Control on ToolBar */
	
	});
	lap_kunjungan_nonListEditorGrid2.render();
	
	/* Create Context Menu */
	lap_kunjungan_nonContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled : true,
			handler: lap_kunjungan_non_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled : true,
			handler: lap_kunjungan_non_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_kunjungan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_kunjungan_nonContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_kunjungan_nonSelectedRow=rowIndex;
		lap_kunjungan_nonContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	lap_kunjungan_nonListEditorGrid.addListener('rowcontextmenu', onlap_kunjungan_ListEditGridContextMenu);
	lap_kunjungan_nontrans_DataStore.load({params: {start: 0, limit: pageS}});
	lap_totalkunjungan_nonDataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	//lap_kunjungan_nonListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	/* Function for action list search */
	function lap_kunjungan_non_search(){
		// render according to a SQL date format.
		
		if(is_lap_kunjungan_non_searchForm_valid())
		{
		var lap_kunjungan_id_search=null;
		var lap_kunjungan_tgl_start_search=null;
		var lap_kunjungan_tgl_end_search=null;
		var lap_kunjungan_nonkelamin_search=null;
		var lap_kunjungan_nonmember_search=null;
		var lap_kunjungan_noncust_search=null;
		//var report_tindakan_dokter_search=null;

		if(lap_kunjungan_non_idSearchField.getValue()!==null){lap_kunjungan_id_search=lap_kunjungan_non_idSearchField.getValue();}
		if(lap_kunjungan_nonmemberSearchField.getValue()!==null){lap_kunjungan_nonmember_search=lap_kunjungan_nonmemberSearchField.getValue();}
		if(lap_kunjungan_noncustSearchField.getValue()!==null){lap_kunjungan_noncust_search=lap_kunjungan_noncustSearchField.getValue();}
		if(lap_kunjungan_nonkelaminSearchField.getValue()!==null){lap_kunjungan_nonkelamin_search=lap_kunjungan_nonkelaminSearchField.getValue();}
		if(Ext.getCmp('lap_kunjungan_non_tglStartSearchField').getValue()!==null){lap_kunjungan_tgl_start_search=Ext.getCmp('lap_kunjungan_non_tglStartSearchField').getValue();}
		if(Ext.getCmp('lap_kunjungan_non_tglEndSearchField').getValue()!==null){lap_kunjungan_tgl_end_search=Ext.getCmp('lap_kunjungan_non_tglEndSearchField').getValue();}
		//if(report_tindakan_dokterSearchField.getValue()!==null){report_tindakan_dokter_search=report_tindakan_dokterSearchField.getValue();}
		// change the store parameters
		lap_kunjungan_nontrans_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_nonkelamin : lap_kunjungan_nonkelamin_search,
			lap_kunjungan_nonmember : lap_kunjungan_nonmember_search,
			lap_kunjungan_noncust : lap_kunjungan_noncust_search
			
			//trawat_dokter	:	report_tindakan_dokter_search,
		};
		lap_totalkunjungan_nonDataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_nonkelamin : lap_kunjungan_nonkelamin_search,
			lap_kunjungan_nonmember : lap_kunjungan_nonmember_search,
			lap_kunjungan_noncust : lap_kunjungan_noncust_search
			//trawat_dokter	:	report_tindakan_dokter_search,
		};
		// Cause the datastore to do another query : 
		lap_kunjungan_nontrans_DataStore.reload({params: {start: 0, limit: pageS}});
		lap_totalkunjungan_nonDataStore.reload({params: {start: 0, limit: pageS}});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Field for search */
	/* Identify  lap_kunjungan_id Search Field */
	lap_kunjungan_non_idSearchField= new Ext.form.NumberField({
		id: 'lap_kunjungan_non_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	var dt = new Date(); 
	
	/* Identify  lap_kunjungan_nonkelamin Field */
	lap_kunjungan_nonkelaminSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_nonkelaminSearchField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_nonkelamin_value', 'lap_kunjungan_nonkelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan'],['S','Semua']]
		}),
		mode: 'local',
		blankText:'Semua',
		displayField: 'lap_kunjungan_nonkelamin_display',
		valueField: 'lap_kunjungan_nonkelamin_value',
		anchor: '100%',
		triggerAction: 'all'	
	});
	
	/* Identify  lap_kunjungan_nonmember Field */
	lap_kunjungan_nonmemberSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_nonmemberSearchField',
		fieldLabel: 'Member',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_nonmember_value', 'lap_kunjungan_nonmember_display'],
			data: [['Lama','Lama'],['Baru','Baru'],['Non Member','Non Member'],['Semua','Semua']]
		}),
		mode: 'local',
		displayField: 'lap_kunjungan_nonmember_display',
		valueField: 'lap_kunjungan_nonmember_value',
		anchor: '100%',
		triggerAction: 'all'
	});
	
	/* Identify  lap_kunjungan_noncust Field */
	lap_kunjungan_noncustSearchField= new Ext.form.ComboBox({
		id: 'lap_kunjungan_noncustSearchField',
		fieldLabel: 'Customer',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['lap_kunjungan_noncust_value', 'lap_kunjungan_noncust_display'],
			data: [['Lama','Lama'],['Baru','Baru'],['Semua','Semua']]
		}),
		mode: 'local',
		displayField: 'lap_kunjungan_noncust_display',
		valueField: 'lap_kunjungan_noncust_value',
		anchor: '100%',
		triggerAction: 'all'
	});
	
	/* Function for retrieve search Form Panel */
	lap_kunjungan_nonSearchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 640,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.33,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									fieldLabel: 'Tanggal',
							        name: 'lap_kunjungan_non_tglStartSearchField',
							        id: 'lap_kunjungan_non_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        endDateField: 'lap_kunjungan_non_tglEndSearchField' // id of the end date field Ext.getCmp('lap_kunjungan_non_tglStartSearchField').isValid()
							    },lap_kunjungan_nonkelaminSearchField,lap_kunjungan_nonmemberSearchField,lap_kunjungan_noncustSearchField] 
						},
						{
							columnWidth:0.30,
							layout: 'form',
							labelWidth:20,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'lap_kunjungan_non_tglEndSearchField',
							        id: 'lap_kunjungan_non_tglEndSearchField',
							        vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        startDateField: 'lap_kunjungan_non_tglStartSearchField' // id of the end date field
							    }] 
						}]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: lap_kunjungan_non_search
			},{
				text: 'Close',
				handler: function(){
					lap_kunjungan_nonSearchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function lap_kunjungan_non_reset_formSearch(){
		lap_kunjungan_non_idSearchField.reset();
		lap_kunjungan_non_idSearchField.setValue(null);
		lap_kunjungan_nonkelaminSearchField.reset();
		lap_kunjungan_nonkelaminSearchField.setValue('S');
		lap_kunjungan_nonmemberSearchField.reset();
		lap_kunjungan_nonmemberSearchField.setValue('Semua');
		lap_kunjungan_noncustSearchField.reset();
		lap_kunjungan_noncustSearchField.setValue('Semua');
		Ext.getCmp('lap_kunjungan_non_tglStartSearchField').reset();
		Ext.getCmp('lap_kunjungan_non_tglStartSearchField').setValue(null);
		Ext.getCmp('lap_kunjungan_non_tglEndSearchField').reset();
		Ext.getCmp('lap_kunjungan_non_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_kunjungan_nonSearchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Kunjungan Non Transaksi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_kunjungan_non_search',
		items: lap_kunjungan_nonSearchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_kunjungan_nonSearchWindow.isVisible()){
			lap_kunjungan_non_reset_formSearch();
			lap_kunjungan_nonSearchWindow.show();
		} else {
			lap_kunjungan_nonSearchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function lap_kunjungan_non_print(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(lap_kunjungan_nontrans_DataStore.baseParams.query!==null){searchquery = lap_kunjungan_nontrans_DataStore.baseParams.query;}
		if(lap_kunjungan_nontrans_DataStore.baseParams.trawat_cust!==null){trawat_cust_print = lap_kunjungan_nontrans_DataStore.baseParams.trawat_cust;}
		if(lap_kunjungan_nontrans_DataStore.baseParams.trawat_keterangan!==null){trawat_keterangan_print = lap_kunjungan_nontrans_DataStore.baseParams.trawat_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_kunjungan_non&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust : trawat_cust_print,
			trawat_keterangan : trawat_keterangan_print,
		  	currentlisting: lap_kunjungan_nontrans_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./tindakanlist.html','tindakanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function lap_kunjungan_non_export_excel(){
		var searchquery = "";
		var tindakan_dokter_2excel=null;
		var win;              
		// check if we do have some search data...
		if(lap_kunjungan_nontrans_DataStore.baseParams.query!==null){searchquery = lap_kunjungan_nontrans_DataStore.baseParams.query;}
		if(lap_kunjungan_nontrans_DataStore.baseParams.trawat_dokter!==null){tindakan_dokter_2excel = lap_kunjungan_nontrans_DataStore.baseParams.trawat_dokter;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_kunjungan_non&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_dokter : tindakan_dokter_2excel,
		  	currentlisting: lap_kunjungan_nontrans_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_lap_kunjungan_non"></div>
		 <div id="fp_lap_kunjungan_non2"></div>
         <div id="fp_lap_kunjungan_non_detail"></div>
		 <div id="fp_dlap_kunjungan_non"></div>
		<div id="elwindow_lap_kunjungan_non_create"></div>
        <div id="elwindow_lap_kunjungan_non_search"></div>
    </div>
</div>
</body>