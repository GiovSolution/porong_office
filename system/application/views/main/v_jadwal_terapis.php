<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: users View
	+ Description	: For record view
	+ Filename 		: v_users.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 15:35:27
	
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
var jadwal_terapisDataStore;
var jadwal_terapisColumnModel;
var jadwal_terapisListEditorGrid;
var jadwal_terapis_SelectedRow;
var jadwal_terapis_ContextMenu;
var jterapis_searchForm;

var today=new Date().format('d-m-Y');

//declare konstant
var jterapis_post2db = '';
var msg = '';
var jterapis_pageS=50;
var jterapis_idSearchField;
/* on ready fuction */

Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
  
  	/* Function for Saving inLine Editing */
	function jadwal_terapis_update(oGrid_event){

	var tindakan_adjusment_update=null;
	var adj_id_update_pk="";

	
	adj_id_update_pk = oGrid_event.record.data.adj_id;

	if(oGrid_event.record.data.adj_count!== null){tindakan_adjusment_update = oGrid_event.record.data.adj_count;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_jadwal_terapis&m=get_action',
			params: {
				task: "UPDATE",
				adj_id	: adj_id_update_pk,				
			
				adj_count :tindakan_adjusment_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						jadwal_terapisDataStore.commitChanges();
						jadwal_terapisDataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   //msg: 'We could\'t not save the users.',
							   msg: 'Data penyesuaian tindakan tidak dapat disimpan',
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
  	/* End of Function */
  function is_jterapis_searchForm_valid(){
		return (Ext.getCmp('jterapis_tglStartSearchField').isValid());
	}
  

  	/* Function for get PK field */
	function get_pk_id(){
		if(jterapis_post2db=='UPDATE')
			return jadwal_terapisListEditorGrid.getSelectionModel().getSelected().get('adj_id');
		else 
			return 0;
	}
	/* End of Function  */
  
	/* Function for Retrieve DataStore */
	jadwal_terapisDataStore = new Ext.data.Store({
		id: 'jadwal_terapisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_jadwal_terapis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intousers_ColumnModel, Mapping => for initiate table column */ 
			{name: 'adj_id', type: 'int', mapping: 'adj_id'},
			{name: 'adj_bln', type: 'date', dateFormat: 'Y-m', mapping: 'adj_bln'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'adj_count', type: 'int', mapping: 'adj_count'},
			{name: 'terapis_count', type: 'float', mapping: 'terapis_count'},
			{name: 'terapis_count_day', type: 'float', mapping: 'terapis_count_day'},
			{name: 'absensi_shift', type: 'string', mapping: 'absensi_shift'},
			{name: 'new_count', type: 'int', mapping: 'new_count'},
			{name: 'absensi_keterangan', type: 'string', mapping: 'absensi_keterangan'}
		])
		//sortInfo:{field: 'karyawan_username', direction: "ASC"}
	});
	/* End of Function */
	
  	/* Function for Identify of Window Column Model */
	jadwal_terapisColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'adj_id',
			width: 20,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Bulan',
			dataIndex: 'adj_bln',
			width: 80,
			sortable: true,
			hidden: true,
			renderer: Ext.util.Format.dateRenderer('Y-m')
			/*editor: new Ext.form.DateField({
				format: 'Y-m'
			})*/
		},
		
		
		{
			align : 'Left',
			header: '<div align="center">' + 'Absensi' + '</div>',
			dataIndex: 'absensi_shift',
			width: 50,	//150,
			sortable: true,
		},
		{
			header: '<div align="center">' + 'Therapist' + '</div>',
			dataIndex: 'karyawan_username',
			width: 100,	//150,
			sortable: true,
		
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml Tindakan' + '<br>' +'(Bulan)' + '</div>',
			dataIndex: 'terapis_count',
			width: 70,	//150,
			sortable: true,		
		},		
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml Tindakan' + '<br>' +'(Hari Ini)' + '</div>',
			dataIndex: 'terapis_count_day',
			width: 70,	//150,
			sortable: true,
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'absensi_keterangan',
			width: 150,	//150,
			sortable: true,
		}
		]
	);
	jadwal_terapisColumnModel.defaultSortable= true;
	/* End of Function */
    
	tbar_jterapis_tglField= new Ext.form.DateField({
		id: 'tbar_jterapis_tglField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		emptyText: 'Tgl',
		hidden:false,
		//ref: '../appNonMedisTgl'
	});
	
	/* Declare DataStore and  show datagrid list */
	jadwal_terapisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'jadwal_terapisListEditorGrid',
		el: 'fp_jadwal_terapis',
		title: 'Jadwal dan Jumlah Tindakan Terapis',
		autoHeight: true,
		store: jadwal_terapisDataStore, // DataStore
		cm: jadwal_terapisColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 500,
		bbar: new Ext.PagingToolbar({
			pageSize: jterapis_pageS,
			store: jadwal_terapisDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: jterapis_reset_search,
			iconCls:'icon-refresh'
		}, '-', tbar_jterapis_tglField
		]
	});
	jadwal_terapisListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	jadwal_terapis_ContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		/*{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: ptindakan_terapis_print 
		},*/
		{ 
			text: 'Refresh', 
			tooltip: 'Refresh Datagrid',
			iconCls:'icon-refresh',
			handler: jterapis_reset_search 
		}
		/*{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: ptindakan_export_excel 
		}*/
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onjterapis_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		jadwal_terapis_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		jadwal_terapis_SelectedRow=rowIndex;
		jadwal_terapis_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function jterapis_editContextMenu(){
      jadwal_terapisListEditorGrid.startEditing(jadwal_terapis_SelectedRow,1);
  	}
	/* End of Function */
  	
	jadwal_terapisListEditorGrid.addListener('rowcontextmenu', onjterapis_ListEditGridContextMenu);
	jadwal_terapisDataStore.load({params: {start: 0, limit: jterapis_pageS}});	// load DataStore
	jadwal_terapisListEditorGrid.on('afteredit', jadwal_terapis_update); // inLine Editing Record
	
	
	tbar_jterapis_tglField.on('select',function(){
		jadwal_terapisDataStore.load({params: {
			task: 'LIST',
			start: 0,
			limit: jterapis_pageS,
			tgl_app: tbar_jterapis_tglField.getValue()
		}});
	});
	
	
		function jterapis_search(){
		// render according to a SQL date format.
		
		if(is_jterapis_searchForm_valid())
		{
		var jterapis_id_search=null;
		var jterapis_tgl_start_search=null;
		//var lap_kunjungan_tgl_end_search=null;
		//var report_tindakan_dokter_search=null;

		if(jterapis_idSearchField.getValue()!==null){jterapis_id_search=jterapis_idSearchField.getValue();}
		if(Ext.getCmp('jterapis_tglStartSearchField').getValue()!==null){jterapis_tgl_start_search=Ext.getCmp('jterapis_tglStartSearchField').getValue();}
		// change the store parameters
		jadwal_terapisDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			lap_kunjungan_id	:	jterapis_id_search, 
			trawat_tglapp_start	: 	jterapis_tgl_start_search,
			//trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search
		};
		// Cause the datastore to do another query : 
		jadwal_terapisDataStore.reload({params: {start: 0, limit: 50}});
		//lap_totalkunjungan_DataStore.reload({params: {start: 0, limit: 31}});
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
	
	jterapis_idSearchField= new Ext.form.NumberField({
		id: 'jterapis_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	
	var dt = new Date(); 
	
		jterapis_searchForm = new Ext.FormPanel({
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
							        name: 'jterapis_tglStartSearchField',
							        id: 'jterapis_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y'
							        //endDateField: 'jterapis_tglEndSearchField' // id of the end date field Ext.getCmp('jterapis_tglStartSearchField').isValid()
							    }] 
						}
					]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: jterapis_search
			},{
				text: 'Close',
				handler: function(){
					jterapis_searchWindow.hide();
				}
			}
		]
	});
	
	
	function jterapis_reset_formSearch(){
		jterapis_idSearchField.reset();
		jterapis_idSearchField.setValue(null);
		Ext.getCmp('jterapis_tglStartSearchField').reset();
		Ext.getCmp('jterapis_tglStartSearchField').setValue(null);
	}
	
	jterapis_searchWindow = new Ext.Window({
		title: 'Search Tanggal',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_jterapis_search',
		items: jterapis_searchForm
	});
	
	
	function display_form_search_window(){
		if(!jterapis_searchWindow.isVisible()){
			jterapis_reset_formSearch();
			jterapis_searchWindow.show();
		} else {
			jterapis_searchWindow.toFront();
		}
	}

	/* Function for reset search result */
	function jterapis_reset_search(){
		// reset the store parameters
		jadwal_terapisDataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		jadwal_terapisDataStore.reload({params: {start: 0, limit: jterapis_pageS}});
		//ptindakan_terapis_searchWindow.close();
	};
	/* End of Fuction */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_jadwal_terapis"></div>
		<div id="elwindow_jterapis_create"></div>
        <div id="elwindow_jterapis_search"></div>
    </div>
</div>
</body>
