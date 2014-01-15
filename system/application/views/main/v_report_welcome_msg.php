<?
/* 
	+ Module  		: Welcome Message View
	+ Description	: For record view
	+ Filename 		: v_report_top_spender.php
 	+ Author  		: Isaac

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
var welcome_msgDataStore;
//var sum_kreditDataStore;
var welcome_msgColumnModel;
//var sum_kreditColumnModel;
var welcome_msgListEditorGrid;
var welcome_msg_createForm;
var welcome_msg_createWindow;
var welcome_msg_searchForm;
var welcome_msg_searchWindow;
var welcome_msgSelectedRow;
var welcome_msgContextMenu;
var welcome_msgField;
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
			return welcome_msgListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* setValue to EDIT */
	function welcome_msg_set_form(){
		welcome_msgField.setValue(welcome_msgListEditorGrid.getSelectionModel().getSelected().get('welcome_msg'));
	}
	/* End setValue to EDIT*/
	
	/* Function for Update Confirm */
	function welcome_msg_confirm_update(){
		/* only one record is selected here */
		if(welcome_msgListEditorGrid.selModel.getCount() == 1) {
			welcome_msg_set_form();
			post2db='UPDATE';
			msg='updated';
			welcome_msg_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	//isc_datastore
	welcome_msgDataStore = new Ext.data.Store({
		id: 'welcome_msgDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=C_report_welcome_msg&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			//totalProperty: 'total',
			//id: ''
		},[
		/* dataIndex => insert intotop_spenderColumnModel, Mapping => for initiate table column */ 
			{name: 'welcome_id', type: 'string', mapping: 'welcome_id'},
			{name: 'welcome_tglawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'welcome_tglawal'},
			{name: 'welcome_tglakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'welcome_tglakhir'},
			{name: 'welcome_msg', type: 'string', mapping: 'welcome_msg'},
			{name: 'welcome_title', type: 'string', mapping: 'welcome_title'},
		]),
//		sortInfo:{field: 'welcome_tglawal', direction: "DESC"}
	});
	/* End of Function */
	

  	/* Function for Identify of Window Column Model */
	//Tampilkan di grid
	welcome_msgColumnModel = new Ext.grid.ColumnModel(
		[{
			align : 'Left',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 10,
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'welcome_tglawal',
			width: 40,
			sortable: true,
			readOnly:true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
	
		}, 
		{
			header: '<div align="center">' + 'Tgl Akhir' + '</div>',
			dataIndex: 'welcome_tglakhir',
			width: 60,//185,	//210,
			sortable: true,
			readOnly : true,
			hidden: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'Kategori' + '</div>',
			dataIndex: 'welcome_title',
			width: 80,//185,	//210,
			sortable: true,
			readOnly : true,
		},
		{
			header: '<div align="center">' + 'Pesan' + '</div>',
			dataIndex: 'welcome_msg',
			width: 400,//185,	//210,
			sortable: true,
			readOnly : true,
		}
	]);
	
	welcome_msgColumnModel.defaultSortable= true;
	/* End of Function */
	
	
	/* Declare DataStore and  show datagrid list */
	welcome_msgListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'welcome_msgListEditorGrid',
		el: 'fp_welcome_msg',
		title: 'Laporan Detail Pembaruan MIS',
		autoHeight: true,
		store: welcome_msgDataStore, // DataStore
		cm: welcome_msgColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200, //940,//1200,	//970,
		/* Add Control on ToolBar */
		tbar: [
		/*
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}
		*/
		{
			text: 'Lihat Pesan',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: welcome_msg_confirm_update    // Confirm before updating
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled: true,
			handler: tindakan_medisexport_excel
		}
		]
	});
	welcome_msgListEditorGrid.render();
	/* End of DataStore */

	//welcome_msgListEditorGrid.addListener('rowcontextmenu', ontop_spenderListEditGridContextMenu);
	//welcome_msgDataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	/* Identify  group_keterangan Field */
	welcome_msgField= new Ext.form.TextArea({
		id: 'welcome_msgField',
		fieldLabel: 'Pesan',
		maxLength: 250,
		readOnly: true,
		anchor: '90%'
	});
	
	welcome_msg_createForm = new Ext.FormPanel({
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
							    ] 
						},
						]},
						welcome_msgField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Close',
				handler: function(){
					welcome_msg_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	
	/* Function for retrieve create Window Form */
	welcome_msg_createWindow= new Ext.Window({
		id: 'welcome_msg_createWindow',
		title: 'Detail Pembaruan MIS',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_welcome_msg_create',
		items: welcome_msg_createForm
	});
	/* End Window */
	
	/* Function for print List Grid */
	function tindakan_medisprint(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(welcome_msgDataStore.baseParams.query!==null){searchquery = welcome_msgDataStore.baseParams.query;}
		if(welcome_msgDataStore.baseParams.trawat_cust!==null){trawat_cust_print = welcome_msgDataStore.baseParams.trawat_cust;}
		if(welcome_msgDataStore.baseParams.trawat_keterangan!==null){trawat_keterangan_print = welcome_msgDataStore.baseParams.trawat_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=C_report_welcome_msg&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust : trawat_cust_print,
			trawat_keterangan : trawat_keterangan_print,
		  	currentlisting: welcome_msgDataStore.baseParams.task // this tells us if we are searching or not
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
		if(welcome_msgDataStore.baseParams.query!==null){searchquery = welcome_msgDataStore.baseParams.query;}
		if(welcome_msgDataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_excel = welcome_msgDataStore.baseParams.trawat_tglapp_start;}
		if(welcome_msgDataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_excel = welcome_msgDataStore.baseParams.trawat_tglapp_end;}
		if(welcome_msgDataStore.baseParams.top_jenis!==null){jenis_top_Field_excel = welcome_msgDataStore.baseParams.top_jenis;}
		if(welcome_msgDataStore.baseParams.top_jumlah!==null){jumlah_top_Field_excel = welcome_msgDataStore.baseParams.top_jumlah;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=C_report_welcome_msg&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_tglapp_start	: 	trawat_tgl_start_app_excel,
			trawat_tglapp_end	: 	trawat_tgl_end_app_excel,
			top_jenis			:	jenis_top_Field_excel,
			top_jumlah			:	jumlah_top_Field_excel,
		  	currentlisting		: 	welcome_msgDataStore.baseParams.task // this tells us if we are searching or not
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
	
	welcome_msgDataStore.load();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_welcome_msg"></div>
		<div id="elwindow_welcome_msg_create"></div>
        <div id="elwindow_welcome_msg_search"></div>
    </div>
</div>
</body>