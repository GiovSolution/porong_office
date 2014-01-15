<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: neraca View
	+ Description	: For record view
	+ Filename 		: v_neraca.php
 	+ Author  		: 
 	+ Created on 21/Aug/2009 06:51:08
	
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
var neraca_DataStore;
var neraca_ColumnModel;
var neracaListEditorGrid;
var neraca_createForm;
var neraca_createWindow;
var neraca_searchForm;
var neraca_searchWindow;
var neraca_SelectedRow;
var neraca_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var neraca_idField;
var neraca_tanggalField;
var neraca_akunField;
var neraca_debetField;
var neraca_kreditField;
var neraca_saldo_debetField;
var neraca_saldo_kreditField;
var neraca_idSearchField;
var neraca_tanggalSearchField;
var neraca_akunSearchField;
var neraca_debetSearchField;
var neraca_kreditSearchField;
var neraca_saldo_debetSearchField;
var neraca_saldo_kreditSearchField;
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
<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
$bulan="";
?>
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	var neraca_saldoField=new Ext.form.TextField({
		fieldLabel: 'Saldo Laba Rugi',
		readOnly: false,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney'
	});
	
	Ext.ux.grid.GroupSummary.Calculations['totalSaldo'] = function(v, record, field){
        return v + (record.data.jurnal_debet-record.data.jurnal_kredit);
    };
	
	/* Function for Retrieve DataStore */
	neraca_aktiva_DataStore =new Ext.data.GroupingStore({
		id: 'neraca_aktiva_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_neraca&m=get_action', 
			method: 'POST'
		}),
		groupField:'neraca_parent_id',
		baseParams:{task: "LIST", start:0, limit: pageS, neraca_jenis: 'Aktiva'}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'neraca_akun_kode'
		},[
			{name: 'neraca_parent', type: 'string', mapping: 'neraca_jenis'}, 
			{name: 'neraca_parent_id', type: 'int', mapping: 'neraca_jenis_id'}, 
			{name: 'neraca_akun_kode', type: 'string', mapping: 'neraca_akun_kode'}, 
			{name: 'neraca_akun_nama', type: 'string', mapping: 'neraca_akun_nama'}, 
			{name: 'neraca_debet', type: 'float', mapping: 'neraca_debet'}, 
			{name: 'neraca_kredit', type: 'float', mapping: 'neraca_kredit'},
			{name: 'neraca_saldo', type: 'float', mapping: 'neraca_saldo'},
			{name: 'neraca_saldo_periode', type: 'float', mapping: 'neraca_saldo_periode'}
		]),
		sortInfo:{field: 'neraca_akun_kode', direction: "ASC"}
	});
	/* End of Function */
    
	
  	/* Function for Identify of Window Column Model */
	neraca_aktiva_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '',
			dataIndex: 'neraca_parent_id',
			width: 50,
			sortable: false,
			readOnly: true,
			renderer: function(v, params, record){
                    return '<span>' + record.data.neraca_parent+ '</span>';
            }
		},
		{
			header: 'Kode',
			dataIndex: 'neraca_akun_kode',
			width: 80,
			sortable: false,
			readOnly: true
		}, 
		{
			header: 'Nama Akun',
			dataIndex: 'neraca_akun_nama',
			width: 250,
			sortable: false,
			readOnly: true
		}, 
		{
			header: 'Bulan ini',
			dataIndex: 'neraca_saldo_periode',
			width: 150,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: false,
			readOnly: true,
			summaryType: 'sum'
		}, 
		{
			header: 's/d Bulan ini',
			dataIndex: 'neraca_saldo',
			width: 150,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right',
			readOnly: true,
			summaryType: 'sum'
		}
		]);
	
	neraca_aktiva_ColumnModel.defaultSortable= true;
	/* End of Function */
     var summary = new Ext.ux.grid.GroupSummary();
	 
	/* Declare DataStore and  show datagrid list */
	neraca_aktivaListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'neraca_aktivaListEditorGrid',
		el: 'fp_neraca_aktiva',
		title: 'Aktiva',
		autoHeight: true,
		store: neraca_aktiva_DataStore, // DataStore
		cm: neraca_aktiva_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: true,
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
			handler: neraca_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: neraca_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: neraca_print  
		}
		]
	});
	neraca_aktivaListEditorGrid.render();
	/* End of DataStore */
     
	 function rounding(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}
	
	/* Create Context Menu */
	neraca_aktiva_ContextMenu = new Ext.menu.Menu({
		id: 'neraca_aktiva_ContextMenu',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: neraca_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: neraca_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onneraca_aktiva_ContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		neraca_aktiva_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		neraca_SelectedRow=rowIndex;
		neraca_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function neraca_aktiva_ContextMenu(){
		neraca_aktivaListEditorGrid.startEditing(neraca_SelectedRow,1);
  	}
	/* End of Function */
  	

	neraca_aktivaListEditorGrid.addListener('rowcontextmenu', onneraca_aktiva_ContextMenu);

	/* Function for Retrieve Pasiva DataStore */
	neraca_pasiva_DataStore =new Ext.data.GroupingStore({
		id: 'neraca_pasiva_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_neraca&m=get_action', 
			method: 'POST'
		}),
		groupField:'neraca_parent_id',
		baseParams:{task: "LIST", start:0, limit: pageS, neraca_jenis: 'Pasiva'}, 
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'neraca_akun_kode'
		},[
			{name: 'neraca_parent', type: 'string', mapping: 'neraca_jenis'}, 
			{name: 'neraca_parent_id', type: 'int', mapping: 'neraca_jenis_id'}, 
			{name: 'neraca_akun_kode', type: 'string', mapping: 'neraca_akun_kode'}, 
			{name: 'neraca_akun_nama', type: 'string', mapping: 'neraca_akun_nama'}, 
			{name: 'neraca_debet', type: 'float', mapping: 'neraca_debet'}, 
			{name: 'neraca_kredit', type: 'float', mapping: 'neraca_kredit'},
			{name: 'neraca_saldo', type: 'float', mapping: 'neraca_saldo'},
			{name: 'neraca_saldo_periode', type: 'float', mapping: 'neraca_saldo_periode'}
		]),
		sortInfo:{field: 'neraca_akun_kode', direction: "ASC"}
	});
	/* End of Function */
    
	
  	/* Function for Identify of Window Column Model */
	neraca_pasiva_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '',
			dataIndex: 'neraca_parent_id',
			width: 50,
			sortable: false,
			readOnly: true,
			renderer: function(v, params, record){
                    return '<span>' + record.data.neraca_parent+ '</span>';
            }
		},
		{
			header: 'Kode',
			dataIndex: 'neraca_akun_kode',
			width: 80,
			sortable: false,
			readOnly: true
		}, 
		{
			header: 'Nama Akun',
			dataIndex: 'neraca_akun_nama',
			width: 250,
			sortable: false,
			readOnly: true
		}, 
		{
			header: 'Bulan ini',
			dataIndex: 'neraca_saldo_periode',
			width: 150,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: false,
			readOnly: true,
			summaryType: 'sum'
		}, 
		{
			header: 's/d Bulan ini',
			dataIndex: 'neraca_saldo',
			width: 150,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right',
			readOnly: true,
			summaryType: 'sum'
		}
		]);
	
	neraca_pasiva_ColumnModel.defaultSortable= true;
	/* End of Function */
     var summary = new Ext.ux.grid.GroupSummary();
	 
	/* Declare DataStore and  show datagrid list */
	neraca_pasivaListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'neraca_pasivaListEditorGrid',
		el: 'fp_neraca_pasiva',
		title: 'Pasiva',
		autoHeight: true,
		store: neraca_pasiva_DataStore, // DataStore
		cm: neraca_pasiva_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: true,
            enableNoGroups: false,
			enableGroupingMenu: false,
            hideGroupedColumn: true
        }),
		plugins: summary
	});
	neraca_pasivaListEditorGrid.render();

	
	function is_valid_form(){
		if(neraca_opsitgl_searchField.getValue()==true){
			neraca_tglakhir_searchField.allowBlank=false;
			if(neraca_tglakhir_searchField.isValid())
				return true;
			else
				return false;
		}else{
			neraca_tglakhir_searchField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for action list search */
	function neraca_list_search(){
		// render according to a SQL date format.
		
		if(is_valid_form()){
			
			var neraca_tglawal_search="";
			var neraca_tglakhir_search="";
			var neraca_opsi_search="";
			var neraca_bulan_search="";
			var neraca_tahun_search="";
			var neraca_periode_search="";
			var neraca_akun_search=null;
			
			if(neraca_opsitgl_searchField.getValue()==true){
				neraca_periode_search='tanggal';
			}else if(neraca_opsibln_searchField.getValue()==true){
				neraca_periode_search='bulan';
			}else{
				neraca_periode_search='all';
			}
			
			if(neraca_tglakhir_searchField.getValue()!==""){neraca_tglakhir_search = neraca_tglakhir_searchField.getValue().format('Y-m-d');}
			if(neraca_bulan_searchField.getValue()!==""){neraca_bulan_search=neraca_bulan_searchField.getValue(); }
			if(neraca_tahun_searchField.getValue()!==""){neraca_tahun_search=neraca_tahun_searchField.getValue(); }
			
			// change the store parameters
			neraca_aktiva_DataStore.baseParams = {
				task				: 'SEARCH',
				neraca_periode		:	neraca_periode_search,
				neraca_tglakhir		:	neraca_tglakhir_search, 
				neraca_bulan		: 	neraca_bulan_search,
				neraca_tahun		:	neraca_tahun_search,
				neraca_jenis		:   'Aktiva'
			};
			
			neraca_aktiva_DataStore.load({params:{query:null}});

			neraca_pasiva_DataStore.baseParams = {
					task				: 'SEARCH',
					neraca_periode		:	neraca_periode_search,
					neraca_tglakhir		:	neraca_tglakhir_search, 
					neraca_bulan		: 	neraca_bulan_search,
					neraca_tahun		:	neraca_tahun_search,
					neraca_jenis		:   'Pasiva'
			};
				
			neraca_pasiva_DataStore.load({params:{query:null}});
				
		}
	}
		
	/* Function for reset search result */
	function neraca_reset_search(){
		// reset the store parameters
		//neraca_aktiva_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		//neraca_pasiva_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		
		neraca_searchWindow.close();
	};
	/* End of Fuction */
	
	var akun_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>[{akun_kode}] - {akun_nama}</b></span>',
        '</div></tpl>'
    );
	
	neraca_bulan_searchField=new Ext.form.ComboBox({
		id:'neraca_bulan_searchField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],
				['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: thismonth,
		width: 100,
		triggerAction: 'all'
	});
	
	neraca_tahun_searchField=new Ext.form.ComboBox({
		id:'neraca_tahun_searchField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['tahun'],
			data: <?php echo $tahun; ?>
		}),
		mode: 'local',
		displayField: 'tahun',
		valueField: 'tahun',
		value: thisyear,
		width: 100,
		triggerAction: 'all'
	});
	
	
	neraca_opsitgl_searchField=new Ext.form.Radio({
		id:'neraca_opsitgl_searchField',
		boxLabel:'s/d Tanggal',
		width:100,
		name: 'filter_opsi'
	});
	
	neraca_opsibln_searchField=new Ext.form.Radio({
		id:'neraca_opsibln_searchField',
		boxLabel:'s/d Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	neraca_opsiall_searchField=new Ext.form.Radio({
		id:'neraca_opsiall_searchField',
		boxLabel:'s/d Sekarang',
		name: 'filter_opsi',
		checked: true
	});
	
	neraca_tglawal_searchField= new Ext.form.DateField({
		id: 'neraca_tglawal_searchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'neraca_tglawal_searchField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
        endDateField: 'neraca_tglakhir_searchField'
	});
	
	neraca_tglakhir_searchField= new Ext.form.DateField({
		id: 'neraca_tglakhir_searchField',
		format : 'Y-m-d',
		name: 'neraca_tglakhirField',
        vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: today
	});
	
	
	
	var neraca_periode_searchField=new Ext.form.FieldSet({
		id:'neraca_periode_searchField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[neraca_opsiall_searchField]
			},{
				layout: 'column',
				border: false,
				items:[neraca_opsitgl_searchField,
					   {	layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[neraca_tglakhir_searchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[neraca_opsibln_searchField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[neraca_bulan_searchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[neraca_tahun_searchField]
					   }]
			}]
	});
	
	
	
	/* Function for retrieve search Form Panel */
	neraca_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [neraca_periode_searchField],
		buttons: [{
				text: 'Search',
				handler: neraca_list_search
			},{
				text: 'Close',
				handler: function(){
					neraca_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	neraca_searchWindow = new Ext.Window({
		title: 'Laporan Neraca',
		closable:true,
		closeAction: 'hide',
		width: 420, 
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_neraca_search',
		items: neraca_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!neraca_searchWindow.isVisible()){
			neraca_searchWindow.show();
		} else {
			neraca_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function neraca_print(){
		var neraca_tglawal_search="";
		var neraca_tglakhir_search="";
		var neraca_opsi_search="";
		var neraca_bulan_search="";
		var neraca_tahun_search="";
		var neraca_periode_search="";
		var neraca_akun_search=null;
		
		if(neraca_opsitgl_searchField.getValue()==true){
			neraca_periode_search='tanggal';
		}else if(neraca_opsibln_searchField.getValue()==true){
			neraca_periode_search='bulan';
		}else{
			neraca_periode_search='all';
		}
		
		if(neraca_tglakhir_searchField.getValue()!==""){neraca_tglakhir_search = neraca_tglakhir_searchField.getValue().format('Y-m-d');}
		if(neraca_bulan_searchField.getValue()!==""){neraca_bulan_search=neraca_bulan_searchField.getValue(); }
		if(neraca_tahun_searchField.getValue()!==""){neraca_tahun_search=neraca_tahun_searchField.getValue(); }
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_neraca&m=get_action',
		params: {
			task: "PRINT",
		  	neraca_periode		:	neraca_periode_search,
			neraca_tglakhir		:	neraca_tglakhir_search, 
			neraca_bulan		: 	neraca_bulan_search,
			neraca_tahun		:	neraca_tahun_search
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/lap_neraca.html','neracalist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				//win.print();
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
	function neraca_export_excel(){
		var searchquery = "";
		var neraca_tglawal_search="";
		var neraca_tglakhir_search="";
		var neraca_opsi_search="";
		var neraca_bulan_search="";
		var neraca_tahun_search="";
		var neraca_periode_search="";
		var neraca_akun_search=null;
		
		if(neraca_opsitgl_searchField.getValue()==true){
			neraca_periode_search='tanggal';
		}else if(neraca_opsibln_searchField.getValue()==true){
			neraca_periode_search='bulan';
		}else{
			neraca_periode_search='all';
		}
		
		if(neraca_tglakhir_searchField.getValue()!==""){order_tglakhir_search = neraca_tglakhir_searchField.getValue().format('Y-m-d');}
		if(neraca_bulan_searchField.getValue()!==""){order_bulan_search=neraca_bulan_searchField.getValue(); }
		if(neraca_tahun_searchField.getValue()!==""){order_tahun_search=neraca_tahun_searchField.getValue(); }
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_neraca&m=get_action',
		params: {
			task: "EXCEL",
		  	neraca_periode		:	neraca_periode_search,
			neraca_tglakhir		:	neraca_tglakhir_search, 
			neraca_bulan		: 	neraca_bulan_search,
			neraca_tahun		:	neraca_tahun_search
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/lap_neraca.xls','neracalist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	/*End of Function */
	
	display_form_search_window();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_neraca_aktiva"></div>
        <div id="fp_neraca_pasiva"></div>
		<div id="elwindow_neraca_create"></div>
        <div id="elwindow_neraca_search"></div>
    </div>
</div>
</body>