<?php
/* 	
	+ Module  		: Summary Report Setup
	+ Description	: For record view
	+ Filename 		: v_summary_report_setup.php
 	+ creator  		: Fred
	
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
var sr_setupListEditorGrid;
var sr_setup_DataStore;
var sr_setup_ColumnModel;
var sr_setup_saveForm;
var sr_setup_saveWindow;
var sr_setup_idField;
var sr_setup_tahunField;


//declare konstant
var post2db = 'CREATE';
var msg = '';
var pageS_sr_setup=20;

/* declare variable here for Field*/

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

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
        return true;
    }
});


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	/* Function for Saving inLine Editing */
	function sr_setup_update(oGrid_event){
		var setsr_id_update_pk="";
		var setsr_jan_update=null;
		var setsr_feb_update=null;
		var setsr_mar_update=null;
		var setsr_apr_update=null;
		var setsr_may_update=null;
		var setsr_jun_update=null;
		var setsr_jul_update=null;
		var setsr_aug_update=null;
		var setsr_sep_update=null;
		var setsr_oct_update=null;
		var setsr_nov_update=null;
		var setsr_dec_update=null;
		
		setsr_id_update_pk = oGrid_event.record.data.setsr_id;
		if(oGrid_event.record.data.setsr_jan!== null){setsr_jan_update = oGrid_event.record.data.setsr_jan;}
		if(oGrid_event.record.data.setsr_feb!== null){setsr_feb_update = oGrid_event.record.data.setsr_feb;}
		if(oGrid_event.record.data.setsr_mar!== null){setsr_mar_update = oGrid_event.record.data.setsr_mar;}
		if(oGrid_event.record.data.setsr_apr!== null){setsr_apr_update = oGrid_event.record.data.setsr_apr;}
		if(oGrid_event.record.data.setsr_may!== null){setsr_may_update = oGrid_event.record.data.setsr_may;}
		if(oGrid_event.record.data.setsr_jun!== null){setsr_jun_update = oGrid_event.record.data.setsr_jun;}
		if(oGrid_event.record.data.setsr_jul!== null){setsr_jul_update = oGrid_event.record.data.setsr_jul;}
		if(oGrid_event.record.data.setsr_aug!== null){setsr_aug_update = oGrid_event.record.data.setsr_aug;}
		if(oGrid_event.record.data.setsr_sep!== null){setsr_sep_update = oGrid_event.record.data.setsr_sep;}
		if(oGrid_event.record.data.setsr_oct!== null){setsr_oct_update = oGrid_event.record.data.setsr_oct;}
		if(oGrid_event.record.data.setsr_nov!== null){setsr_nov_update = oGrid_event.record.data.setsr_nov;}
		if(oGrid_event.record.data.setsr_dec!== null){setsr_dec_update = oGrid_event.record.data.setsr_dec;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_summary_report_setup&m=get_action',
			params: {
				task: "UPDATE",
				mode_edit: "update_list",
				setsr_id		: setsr_id_update_pk,
				setsr_jan	:setsr_jan_update,  
				setsr_feb	:setsr_feb_update, 
				setsr_mar	:setsr_mar_update, 
				setsr_apr	:setsr_apr_update, 
				setsr_may	:setsr_may_update, 
				setsr_jun	:setsr_jun_update, 
				setsr_jul	:setsr_jul_update, 
				setsr_aug	:setsr_aug_update, 
				setsr_sep	:setsr_sep_update, 
				setsr_oct	:setsr_oct_update, 
				setsr_nov	:setsr_nov_update, 
				setsr_dec	:setsr_dec_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					default:
						sr_setup_DataStore.commitChanges();
						sr_setup_DataStore.reload();
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
  	/* End of Function */
	

  	/* Function for add and edit data form, open window form */
	function sr_setup_save(){
	
		if(is_sr_setup_form_valid()){	

			var sr_setup_id_create_pk=null;
			var sr_setup_tahun_field_create=null;
			var cust_asal_id_field = null;
			var cust_tujuan_id_field = null;
			var cust_point_field = null;
			var joincustomer_tanggal_create="";
			var joincustomer_keterangan_create=null;
			
			if(sr_setup_idField.getValue()!== null){sr_setup_id_create_pk = sr_setup_idField.getValue();}
			if(sr_setup_tahunField.getValue()!== null){sr_setup_tahun_field_create = sr_setup_tahunField.getValue();}		
										
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_summary_report_setup&m=get_action',
				params: {
					task: "CREATE",
					setsr_id	: sr_setup_id_create_pk,
					setsr_tahun : sr_setup_tahun_field_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Summary Report Setup berhasil dilakukan.');
							sr_setup_DataStore.reload();
							sr_setup_saveWindow.hide();
							tahunDataStore.load();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Summary Report Setup tidak dapat dilakukan, karena tahun yang di input sudah ada',
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
			
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Your Form is not valid!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
    
	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='CREATE')
			return sr_setupListEditorGrid.getSelectionModel().getSelected().get('setsr_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function sr_setup_reset_form(){
		sr_setup_idField.reset();
		sr_setup_idField.setValue(null);
		sr_setup_tahunField.reset();
		sr_setup_tahunField.setValue(null);
	}
 	/* End of Function */
	
	/* setValue to EDIT */
	function sr_setup_set_form(){
		sr_setup_idField.setValue(sr_setupListEditorGrid.getSelectionModel().getSelected().get('setsr_id'));
		sr_setup_tahunField.setValue(sr_setupListEditorGrid.getSelectionModel().getSelected().get('setsr_tahun'));
	}
	/* End setValue to EDIT*/
	
	/* Function for Check if the form is valid */
	function is_sr_setup_form_valid(){
		return (true && sr_setup_tahunField.isValid() && true);
	}
  	/* End of Function */
  
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!sr_setup_saveWindow.isVisible()){
			sr_setup_reset_form();
			sr_setup_saveWindow.show();
		} else {
			sr_setup_saveWindow.toFront();
		}
	}
  	/* End Function */
  
	function sr_setup_confirm_save(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan generate Summary Report Setup ini?', sr_setup_button);
	}
	
	function sr_setup_button(btn){
		if(btn=='yes'){
			sr_setup_save();
		}
	}
	
	tahunDataStore = new Ext.data.Store({
		id: 'tahunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report_setup&m=get_tahun_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 20 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'tahun', type: 'string', mapping: 'tahun'},
		]),
		//sortInfo:{field: 'dokter_display', direction: "ASC"}
	});
	
	var tahun_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
			'<span>{tahun}',
        '</div></tpl>'
    );

	sr_setup_DataStore = new Ext.data.Store({
		id: 'sr_setup_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report_setup&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS_sr_setup}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'setsr_id', type: 'int', mapping: 'setsr_id'},
			{name: 'setsr_cabang', type: 'int', mapping: 'setsr_cabang'},
			{name: 'setsr_tahun', type: 'int', mapping: 'setsr_tahun'},
			{name: 'setsr_jenis', type: 'string', mapping: 'setsr_jenis'},
			{name: 'setsr_jan', type: 'float', mapping: 'setsr_jan'},
			{name: 'setsr_feb', type: 'float', mapping: 'setsr_feb'},
			{name: 'setsr_mar', type: 'float', mapping: 'setsr_mar'},
			{name: 'setsr_apr', type: 'float', mapping: 'setsr_apr'},
			{name: 'setsr_may', type: 'float', mapping: 'setsr_may'},
			{name: 'setsr_jun', type: 'float', mapping: 'setsr_jun'},
			{name: 'setsr_jul', type: 'float', mapping: 'setsr_jul'},
			{name: 'setsr_aug', type: 'float', mapping: 'setsr_aug'},
			{name: 'setsr_sep', type: 'float', mapping: 'setsr_sep'},
			{name: 'setsr_oct', type: 'float', mapping: 'setsr_oct'},
			{name: 'setsr_nov', type: 'float', mapping: 'setsr_nov'},
			{name: 'setsr_dec', type: 'float', mapping: 'setsr_dec'}
			
		]),
		sortInfo:{field: 'setsr_id', direction: "ASC"}
	});
	/* End of Function */

	
	sr_setup_ColumnModel = new Ext.grid.ColumnModel(
		[
		/*{
			header: '<div align="center">Tahun</div>',
			dataIndex: 'setsr_tahun',
			width: 40,
			hidden : true,
			sortable: true
			
		}, */
		{
			header: '<div align="center">Target</div>',
			dataIndex: 'setsr_jenis',
			width: 100,
			sortable: true
		
		}, 
		{
			header: '<div align="center">Jan</div>',
			dataIndex: 'setsr_jan',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}
		}, 
		
		{
			header: '<div align="center">Feb</div>',
			dataIndex: 'setsr_feb',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Mar</div>',
			dataIndex: 'setsr_mar',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Apr</div>',
			dataIndex: 'setsr_apr',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">May</div>',
			dataIndex: 'setsr_may',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Jun</div>',
			dataIndex: 'setsr_jun',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Jul</div>',
			dataIndex: 'setsr_jul',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Aug</div>',
			dataIndex: 'setsr_aug',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Sep</div>',
			dataIndex: 'setsr_sep',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Oct</div>',
			dataIndex: 'setsr_oct',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Nov</div>',
			dataIndex: 'setsr_nov',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}, 
		{
			header: '<div align="center">Dec</div>',
			dataIndex: 'setsr_dec',
			width: 50,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
				}		
		}
		]
	);
	sr_setup_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	sr_setupListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'sr_setupListEditorGrid',
		el: 'fp_vu_sr_setup',
		title: 'Summary Report Setup',
		autoHeight: true,
		store: sr_setup_DataStore, // DataStore
		cm: sr_setup_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		autoHeight: true,
		bbar: new Ext.PagingToolbar({
			pageS_sr_setupize: pageS_sr_setup,
			store: sr_setup_DataStore,
			displayInfo: true
		}),
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',
			handler: display_form_search_window 
		},
		'-',
		{
			'text':'Tahun : '
		},{
			xtype: 'combo',
			id: 'cbo_tahun',
			text: 'Pilih Tahun',
			emptyText: 'Pilih Tahun',
			width: 100,
			store: tahunDataStore,
            fieldLabel: 'ComboBox Tahun',
            mode: 'remote',
			tpl: tahun_tpl,
			displayField: 'tahun',
			valueField: 'tahun',
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
		}
		/*{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			iconCls:'icon-refresh',
			disabled : true
		}*/]
	});
	sr_setupListEditorGrid.render();
	
	/* Event while selected row via context menu */
	function onsr_setup_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		sr_setup_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		sr_setup_SelectedRow=rowIndex;
		sr_setup_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function sr_setup_editContextMenu(){
      sr_setupListEditorGrid.startEditing(sr_setup_SelectedRow,1);
  	}
	/* End of Function */
  	
	sr_setupListEditorGrid.addListener('rowcontextmenu', onsr_setup_ListEditGridContextMenu);
	//sr_setup_DataStore.load({params: {start: 0, limit: pageS_sr_setup}});
	Ext.getCmp('cbo_tahun').on('select', function(){
		Ext.MessageBox.show({
			msg:   'Sedang mencari data, mohon tunggu...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		sr_setup_DataStore.setBaseParam('query',Ext.getCmp('cbo_tahun').getValue());
		sr_setup_DataStore.load({
			params: {
				task: 'LIST',
				start: 0,
				limit: pageS_sr_setup,
				query: '',
				tahun: Ext.getCmp('cbo_tahun').getValue()
			},
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});		
	});
	sr_setupListEditorGrid.on('afteredit', sr_setup_update); 
	
	/* Identify  setsr_id Field */
	sr_setup_idField= new Ext.form.NumberField({
		id: 'sr_setup_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	sr_setup_tahunField= new Ext.form.TextField({
		id: 'sr_setup_tahunField',
		fieldLabel: 'Tahun',
		width: 50
	});
		
	sr_setup_infoketeranganField=new Ext.form.Label({ html: '<br><br> *Tahun hanya bisa diinputkan sekali saja'});

	/* Function for retrieve create Window Panel*/ 
	sr_setup_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [sr_setup_idField, sr_setup_tahunField,sr_setup_infoketeranganField] 
			}
			],
		buttons: [{
				text: 'Create',
				handler : sr_setup_confirm_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					sr_setup_saveWindow.hide();
					//mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	sr_setup_saveWindow= new Ext.Window({
		id: 'sr_setup_saveWindow',
		title:'Add Summary Report Setup',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_sr_setup_save',
		items: sr_setup_saveForm
	});
	/* End Window */
	
	//sr_setup_saveWindow.show();
	//tahunDataStore.reload();
	
});
	</script>
<body>
<div>
	<div class="col">
		 <div id="fp_vu_sr_setup"></div>
		<div id="elwindow_sr_setup_save"></div>
    </div>
</div>
</body>
</html>