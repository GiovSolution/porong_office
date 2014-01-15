<?
/* 
	+ Module  		: Top Spender View
	+ Description	: For record view
	+ Filename 		: v_report_top_spender.php
 	+ Author  		: Isaac
	Edited by		: Freddy

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
var top_spenderDataStore;
//var sum_kreditDataStore;
var top_spenderColumnModel;
//var sum_kreditColumnModel;
var top_spenderListEditorGrid;
var top_spender_createForm;
var top_spender_createWindow;
var top_spender_searchForm;
var top_spender_searchWindow;
var top_spenderSelectedRow;
var top_spenderContextMenu;
var jenis_top_Field;
var jumlah_top_Field;
//for detail data


var today=new Date().format('d-m-Y');

//declare konstant 
var post2db = '';
var msg = '';
var pageS=30;

/* declare variable here for Field*/
var trawat_medis_idField;
var trawat_medis_idSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return top_spenderListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	// cek valid
	function is_top_spender_searchForm_valid(){
		return (Ext.getCmp('top_spender_tglStartSearchField').isValid() );
		//&& jumlah_top_Field.getValue()!=null && jenis_top_Field.getValue()!=null);
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!top_spender_createWindow.isVisible()){
			//tindakan_medisreset_form();
			//post2db='CREATE';
			msg='created';
			top_spender_createWindow.show();
		} else {
			top_spender_createWindow.toFront();
		}
	}
  	/* End of Function */
  	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	//isc_datastore
	top_spenderDataStore = new Ext.data.Store({
		id: 'top_spenderDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_top_spender&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intotop_spenderColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'total', type: 'float', mapping: 'total'},
			{name: 'customer_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'customer_member', type: 'string', mapping: 'member_no'},
		]),
		sortInfo:{field: 'total', direction: "DESC"}
	});
	/* End of Function */
	

  	/* Function for Identify of Window Column Model */
	//Tampilkan di grid
	top_spenderColumnModel = new Ext.grid.ColumnModel(
		[{
			align : 'Left',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 30,
		},
		{
			header: '<div align="center">' + 'No Customer' + '</div>',
			dataIndex: 'cust_no',
			width: 80,
			sortable: true,
			readOnly:true,
	
		}, 
		{
			header: '<div align="center">' + 'Nama Customer' + '</div>',
			dataIndex: 'customer_nama',
			width: 280,//185,	//210,
			sortable: true,
			readOnly : true,
		}, 
		/*
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'customer_member',
			width: 80,//185,	//210,
			sortable: true,
			readOnly : true,
		},
		*/ 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			dataIndex: 'total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}/*,
		{	
			align : 'Right',
			header: '<div align="center">' + 'Kredit (Satuan)' + '</div>',
			dataIndex: 'dtrawat_skredit',
			width: 80,	//55,
			sortable: false
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Total Kredit' + '</div>',
			dataIndex: 'dtrawat_jkredit',
			width: 80,	//55,
			sortable: false
		},
		*/
	]);
	
	top_spenderColumnModel.defaultSortable= true;
	/* End of Function */
	
	
	/* Declare DataStore and  show datagrid list */
	top_spenderListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'top_spenderListEditorGrid',
		el: 'fp_top_spender',
		title: 'Laporan Top Spender (Cash In)',
		autoHeight: true,
		store: top_spenderDataStore, // DataStore
		cm: top_spenderColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800, //940,//1200,	//970,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: tindakan_medisexport_excel
		}
		]
	});
	top_spenderListEditorGrid.render();
	/* End of DataStore */
	

	/* Create Context Menu */
	top_spenderContextMenu = new Ext.menu.Menu({
		id: 'tindakan_medisListEditorGridContextMenu',
		items: [
		{
			text: 'Search Top Spender (Cash In)',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ontop_spenderListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		top_spenderContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		top_spenderSelectedRow=rowIndex;
		top_spenderContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	top_spenderListEditorGrid.addListener('rowcontextmenu', ontop_spenderListEditGridContextMenu);
	//top_spenderDataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	
	/* Identify  jenis Combo*/
	jenis_top_Field= new Ext.form.ComboBox({
		id: 'jenis_top_Field',
		fieldLabel: 'Jenis Penjualan',
		store:new Ext.data.SimpleStore({
			fields:['jenis_value', 'jenis_display'],
			data:[/*['Perawatan','Perawatan'],*/['Produk','Produk']/*,['Paket','Paket']*/,['Kuitansi','Kuitansi']/*,['Semua','Semua']*/	]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Semua',
		displayField: 'jenis_display',
		valueField: 'jenis_value',
		width: 100,
		triggerAction: 'all'	
	});

	/* Identify  jumlah Combo*/
	jumlah_top_Field= new Ext.form.TextField({
		id: 'jumlah_top_Field',
		fieldLabel: 'Top Rank',
		emptyText: '10',
		width: 50,
		allowBlank: false,
		triggerAction: 'all'	
	});

	
	/* Function for retrieve create Window Form */
	top_spender_createWindow= new Ext.Window({
		id: 'top_spender_createWindow',
		title: post2db+'Tindakan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_top_spender_create',
		items: top_spender_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function top_spender_search(){
		// render according to a SQL date format.
		// KIRIM
		if(is_top_spender_searchForm_valid())
		{
		//var trawat_id_search=null;
		var trawat_tgl_start_app_search=null;
		var trawat_tgl_end_app_search=null;
		var trawat_dokter_search=null;
		var jenis_top_Field_search=null;
		var jumlah_top_Field_search=null;

		//if(trawat_medis_idSearchField.getValue()!==null){trawat_id_search=trawat_medis_idSearchField.getValue();}
		if(Ext.getCmp('top_spender_tglStartSearchField').getValue()!==null){trawat_tgl_start_app_search=Ext.getCmp('top_spender_tglStartSearchField').getValue();}
		if(Ext.getCmp('top_spender_tglEndSearchField').getValue()!==null){trawat_tgl_end_app_search=Ext.getCmp('top_spender_tglEndSearchField').getValue();}
		if(jenis_top_Field.getValue()!==null){jenis_top_Field_search=jenis_top_Field.getValue();}
		if(jumlah_top_Field.getValue()!==null){jumlah_top_Field_search=jumlah_top_Field.getValue();}
		// change the store parameters
		top_spenderDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			/*
			trawat_id	:	trawat_id_search, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_search,
			trawat_tglapp_end	: 	trawat_tgl_end_app_search,
			trawat_dokter	:	trawat_dokter_search,
			*/
			//trawat_id	:	trawat_id_search, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_search,
			trawat_tglapp_end	: 	trawat_tgl_end_app_search,
			top_jenis	:	jenis_top_Field_search,
			top_jumlah	:	jumlah_top_Field_search,
		};
		
		// Cause the datastore to do another query : 
		top_spenderDataStore.reload({params: {start: 0, limit: pageS}});
		
		}
		
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal, Jenis, atau Jumlah belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}

		
	}
		
	/* Function for reset search result */
	function top_spender_reset_search(){
		// reset the store parameters
		top_spenderDataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		top_spenderDataStore.reload({params: {start: 0, limit: pageS}});
		top_spender_searchWindow.close();
	};
	/* End of Fuction */
	

	var dt = new Date(); 
	
	/* Function for retrieve search Form Panel */
	top_spender_searchForm = new Ext.FormPanel({
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
									//fieldLabel: 'Tanggal Tindakan',
									fieldLabel: 'Tanggal',
							        name: 'top_spender_tglStartSearchField',
							        id: 'top_spender_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        endDateField: 'top_spender_tglEndSearchField' // id of the end date field Ext.getCmp('top_spender_tglStartSearchField').isValid()
							    }] 
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
							        name: 'top_spender_tglEndSearchField',
							        id: 'top_spender_tglEndSearchField',
							        vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        startDateField: 'top_spender_tglStartSearchField' // id of the end date field
							    }] 
						}]},
						jenis_top_Field, jumlah_top_Field]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				//handler: tindakan_medislist_search
				handler: top_spender_search
			},{
				text: 'Close',
				handler: function(){
					top_spender_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function top_spender_reset_formSearch(){
		jenis_top_Field.reset();
		jenis_top_Field.setValue(null);
		jumlah_top_Field.reset();
		jumlah_top_Field.setValue(null);
		Ext.getCmp('top_spender_tglStartSearchField').reset();
		Ext.getCmp('top_spender_tglStartSearchField').setValue(null);
		Ext.getCmp('top_spender_tglEndSearchField').reset();
		Ext.getCmp('top_spender_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	top_spender_searchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Top Spender (Cash In)',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_top_spender_search',
		items: top_spender_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!top_spender_searchWindow.isVisible()){
			top_spender_reset_formSearch();
			jenis_top_Field.setValue('Semua');
			jumlah_top_Field.setValue('10');
			top_spender_searchWindow.show();
		} else {
			top_spender_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function tindakan_medisprint(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(top_spenderDataStore.baseParams.query!==null){searchquery = top_spenderDataStore.baseParams.query;}
		if(top_spenderDataStore.baseParams.trawat_cust!==null){trawat_cust_print = top_spenderDataStore.baseParams.trawat_cust;}
		if(top_spenderDataStore.baseParams.trawat_keterangan!==null){trawat_keterangan_print = top_spenderDataStore.baseParams.trawat_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_report_top_spender&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust : trawat_cust_print,
			trawat_keterangan : trawat_keterangan_print,
		  	currentlisting: top_spenderDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./tindakanlist.html','tindakanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function tindakan_medisexport_excel(){
		var searchquery = "";
		var trawat_tgl_start_app_excel=null;
		var trawat_tgl_end_app_excel=null;
		var jenis_top_Field_excel=null;
		var jumlah_top_Field_excel=null;
		var win;              
		// check if we do have some search data...
		if(top_spenderDataStore.baseParams.query!==null){searchquery = top_spenderDataStore.baseParams.query;}
		if(top_spenderDataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_excel = top_spenderDataStore.baseParams.trawat_tglapp_start;}
		if(top_spenderDataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_excel = top_spenderDataStore.baseParams.trawat_tglapp_end;}
		if(top_spenderDataStore.baseParams.top_jenis!==null){jenis_top_Field_excel = top_spenderDataStore.baseParams.top_jenis;}
		if(top_spenderDataStore.baseParams.top_jumlah!==null){jumlah_top_Field_excel = top_spenderDataStore.baseParams.top_jumlah;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_report_top_spender&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_tglapp_start	: 	trawat_tgl_start_app_excel,
			trawat_tglapp_end	: 	trawat_tgl_end_app_excel,
			top_jenis			:	jenis_top_Field_excel,
			top_jumlah			:	jumlah_top_Field_excel,
		  	currentlisting		: 	top_spenderDataStore.baseParams.task // this tells us if we are searching or not
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
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_top_spender"></div>
         <div id="fp_top_tindakan_medisdetail"></div>
		 <div id="fp_top_dtindakan_jual_nonmedis"></div>
		<div id="elwindow_top_spender_create"></div>
        <div id="elwindow_top_spender_search"></div>
    </div>
</div>
</body>