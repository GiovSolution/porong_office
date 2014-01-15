<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: labarugi View
	+ Description	: For record view
	+ Filename 		: v_labarugi.php
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
var labarugi_DataStore;
var labarugi_ColumnModel;
var labarugiListEditorGrid;
var labarugi_createForm;
var labarugi_createWindow;
var labarugi_searchForm;
var labarugi_searchWindow;
var labarugi_SelectedRow;
var labarugi_ContextMenu;
//for detail data
var _DataStor;
var ListEditorGrid;
var _ColumnModel;
var _proxy;
var _writer;
var _reader;
var editor_;

//declare konstant
var post2db = '';
var msg = '';
var pageS_LR=250;

/* declare variable here for Field*/
var labarugi_idField;
var labarugi_tanggalField;
var labarugi_akunField;
var labarugi_debetField;
var labarugi_kreditField;
var labarugi_saldo_debetField;
var labarugi_saldo_kreditField;
var labarugi_idSearchField;
var labarugi_tanggalSearchField;
var labarugi_akunSearchField;
var labarugi_debetSearchField;
var labarugi_kreditSearchField;
var labarugi_saldo_debetSearchField;
var labarugi_saldo_kreditSearchField;
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
  
  	var labarugi_saldoField=new Ext.form.TextField({
		fieldLabel: 'Saldo Harga Pokok Penjualan',
		readOnly: false,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney'
	});
	
	/* Function for Retrieve DataStore */
	labarugi_DataStore =new Ext.data.GroupingStore({
		id: 'labarugi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_labarugi&m=get_action', 
			method: 'POST'
		}),
		//groupField:'labarugi_jenis_id',
		baseParams:{task: "LIST", start: 0, limit: pageS_LR}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'labarugi_akun'
		},[
			{name: 'labarugi_jenis', type: 'string', mapping: 'labarugi_jenis'},
			{name: 'labarugi_jenis_id', type: 'string', mapping: 'labarugi_jenis_id'},
			{name: 'akun_parent_kode', type: 'string', mapping: 'akun_parent_kode'},
			{name: 'labarugi_akun', type: 'int', mapping: 'labarugi_akun'}, 
			{name: 'labarugi_akun_kode', type: 'string', mapping: 'labarugi_akun_kode'}, 
			{name: 'labarugi_akun_nama', type: 'string', mapping: 'labarugi_akun_nama'}, 
			{name: 'labarugi_saldo', type: 'float', mapping: 'labarugi_saldo'}, 
			{name: 'labarugi_saldo_periode', type: 'float', mapping: 'labarugi_saldo_periode'}, 
		]),
		//sortInfo:{field: 'labarugi_akun_kode', direction: "ASC"}
	});
	/* End of Function */
    
	 var summary = new Ext.ux.grid.GroupSummary();

  	/* Function for Identify of Window Column Model */
	labarugi_ColumnModel = new Ext.grid.ColumnModel(
		[
		/*{
			header: 'Kode Grup Akun',
			dataIndex: 'akun_parent_kode',
			width: 80,
			sortable: false,
			readOnly: true
            }
		},*/
		{
			header: 'Grup Akun', //'Jenis',
			dataIndex: 'labarugi_jenis_id',
			width: 200,
			sortable: false,
			readOnly: true,
			renderer: function(v, params, record){
					var title=record.data.labarugi_jenis;
                    return '<span>' + title+ '</span>';
            }
		},
		{
			header: 'Kode',
			dataIndex: 'labarugi_akun_kode',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Akun',
			dataIndex: 'labarugi_akun_nama',
			width: 250,
			sortable: true,
			readOnly: true
		},
		{
			header: 'Bulan Ini (Rp)',
			dataIndex: 'labarugi_saldo_periode',
			width: 100,
			align :'right',
			sortable: true,
			readOnly: true,
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: 'S/d Bulan Ini (Rp)',
			dataIndex: 'labarugi_saldo',
			width: 100,
			align :'right',
			sortable: true,
			readOnly: true,
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000')
		}/*,
		{
			header: 'Saldo',
			width: 150,
			sortable: true,
			align :'right',
			summaryType: 'sum',
			renderer: function(v, params, record){
					subtotal=Ext.util.Format.number((record.data.labarugi_saldo_periode+record.data.labarugi_saldo),"0,000");
                    return '<span>' + subtotal+ '</span>';
            },
			readOnly: true
		}*/
		]);
	
	//labarugi_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	labarugiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'labarugiListEditorGrid',
		el: 'fp_labarugi',
		title: 'Laporan Laba / Rugi',
		autoHeight: false,
		height: 900,
		store: labarugi_DataStore, // DataStore
		cm: labarugi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
			enableGroupingMenu: false,
            hideGroupedColumn: true
        }),
		bbar: [new Ext.PagingToolbar({
			pageSize: pageS_LR,
			disabled:false,
			store: labarugi_DataStore,
			displayInfo: true
		})/*, {
			'text':'Saldo Harga Pokok Penjualan'
		},
		labarugi_saldoField*/],
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
			handler: labarugi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: labarugi_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: labarugi_print  
		}
		]
	});
	labarugiListEditorGrid.render();
	/* End of DataStore */
     
	 function rounding(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}
	
	/* Create Context Menu */
	labarugi_ContextMenu = new Ext.menu.Menu({
		id: 'labarugi_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: labarugi_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: labarugi_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlabarugi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		labarugi_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		labarugi_SelectedRow=rowIndex;
		labarugi_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function labarugi_editContextMenu(){
		labarugiListEditorGrid.startEditing(labarugi_SelectedRow,1);
  	}
	/* End of Function */
  	
	function labarugi_update(){
	}
	
	labarugiListEditorGrid.addListener('rowcontextmenu', onlabarugi_ListEditGridContextMenu);
	labarugiListEditorGrid.on('afteredit', labarugi_update); // inLine Editing Record
	
	function is_valid_form(){
		if(labarugi_opsitgl_searchField.getValue()==true){
			labarugi_tglawal_searchField.allowBlank=false;
			labarugi_tglakhir_searchField.allowBlank=false;
			if(labarugi_tglawal_searchField.isValid() && labarugi_tglakhir_searchField.isValid())
				return true;
			else
				return false;
		}else{
			labarugi_tglawal_searchField.allowBlank=true;
			labarugi_tglakhir_searchField.allowBlank=true;
			return true;
		}
	}
	
	function get_saldo(){
		var debet=0;
		var kredit=0;
		var saldo=0;
		for(i=0;i<labarugi_DataStore.getCount();i++){
			record_lr=labarugi_DataStore.getAt(i);
			debet+=record_lr.data.labarugi_debet;
			kredit+=record_lr.data.labarugi_kredit;
			
		}
		saldo=kredit-debet;
		labarugi_saldoField.setValue(CurrencyFormatted(saldo));
	}
	
	/* Function for action list search */
	function labarugi_list_search(){
		// render according to a SQL date format.
		
		if(is_valid_form()){
			
			var labarugi_tglawal_search="";
			var labarugi_tglakhir_search="";
			var labarugi_opsi_search="";
			var labarugi_bulan_search="";
			var labarugi_tahun_search="";
			var labarugi_periode_search="";
			var labarugi_akun_search=null;
			
			if(labarugi_opsitgl_searchField.getValue()==true){
				labarugi_periode_search='tanggal';
			}else if(labarugi_opsibln_searchField.getValue()==true){
				labarugi_periode_search='bulan';
			}else{
				labarugi_periode_search='all';
			}
			
			if(labarugi_tglawal_searchField.getValue()!==""){labarugi_tglawal_search = labarugi_tglawal_searchField.getValue().format('Y-m-d');}
			if(labarugi_tglakhir_searchField.getValue()!==""){labarugi_tglakhir_search = labarugi_tglakhir_searchField.getValue().format('Y-m-d');}
			if(labarugi_bulan_searchField.getValue()!==""){labarugi_bulan_search=labarugi_bulan_searchField.getValue(); }
			if(labarugi_tahun_searchField.getValue()!==""){labarugi_tahun_search=labarugi_tahun_searchField.getValue(); }
			
			// change the store parameters
			labarugi_DataStore.baseParams = {
				task: 'SEARCH',
				labarugi_periode	:	labarugi_periode_search,
				labarugi_tglawal	:	labarugi_tglawal_search,
				labarugi_tglakhir	:	labarugi_tglakhir_search, 
				labarugi_bulan		: 	labarugi_bulan_search,
				labarugi_tahun		:	labarugi_tahun_search
			};
			
			labarugi_DataStore.load({
				params:{start:0,limit:pageS_LR, query:null},
				callback: function(r,opt,success){
					if(success==true){
						get_saldo();
					}
				}
			});
		}
	}
		
	/* Function for reset search result */
	function labarugi_reset_search(){
		// reset the store parameters
		labarugi_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS_LR };
		labarugi_searchWindow.close();
	};
	/* End of Fuction */
	
	var akun_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>[{akun_kode}] - {akun_nama}</b></span>',
        '</div></tpl>'
    );
	
	labarugi_bulan_searchField=new Ext.form.ComboBox({
		id:'labarugi_bulan_searchField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: thismonth,
		width: 100,
		triggerAction: 'all'
	});
	
	labarugi_tahun_searchField=new Ext.form.ComboBox({
		id:'labarugi_tahun_searchField',
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
	
	
	labarugi_opsitgl_searchField=new Ext.form.Radio({
		id:'labarugi_opsitgl_searchField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi'
	});
	
	labarugi_opsibln_searchField=new Ext.form.Radio({
		id:'labarugi_opsibln_searchField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	labarugi_opsiall_searchField=new Ext.form.Radio({
		id:'labarugi_opsiall_searchField',
		boxLabel:'s/d Sekarang',
		name: 'filter_opsi',
		checked: true
	});
	
	labarugi_tglawal_searchField= new Ext.form.DateField({
		id: 'labarugi_tglawal_searchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'labarugi_tglawal_searchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: today
        //endDateField: 'labarugi_tglakhir_searchField'
	});
	
	labarugi_tglakhir_searchField= new Ext.form.DateField({
		id: 'labarugi_tglakhir_searchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'labarugi_tglakhirField',
       // vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'labarugi_tglawal_searchField',
		value: today
	});
	
	
	
	var labarugi_periode_searchField=new Ext.form.FieldSet({
		id:'labarugi_periode_searchField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[labarugi_opsiall_searchField]
			},{
				layout: 'column',
				border: false,
				hidden: true,
				items:[labarugi_opsitgl_searchField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[labarugi_tglawal_searchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[labarugi_tglakhir_searchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[labarugi_opsibln_searchField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[labarugi_bulan_searchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[labarugi_tahun_searchField]
					   }]
			}]
	});
	
	
	
	/* Function for retrieve search Form Panel */
	labarugi_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [labarugi_periode_searchField],
		buttons: [{
				text: 'Search',
				handler: labarugi_list_search
			},{
				text: 'Close',
				handler: function(){
					labarugi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	labarugi_searchWindow = new Ext.Window({
		title: 'Laporan Laba / Rugi',
		closable:true,
		closeAction: 'hide',
		width: 420, 
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_labarugi_search',
		items: labarugi_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!labarugi_searchWindow.isVisible()){
			labarugi_searchWindow.show();
		} else {
			labarugi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function labarugi_print(){
			
		var labarugi_tglawal_search="";
		var labarugi_tglakhir_search="";
		var labarugi_opsi_search="";
		var labarugi_bulan_search="";
		var labarugi_tahun_search="";
		var labarugi_periode_search="";
		var labarugi_akun_search=null;
		
		if(labarugi_opsitgl_searchField.getValue()==true){
			labarugi_periode_search='tanggal';
		}else if(labarugi_opsibln_searchField.getValue()==true){
			labarugi_periode_search='bulan';
		}else{
			labarugi_periode_search='all';
		}
		
		if(labarugi_tglawal_searchField.getValue()!==""){order_tglawal_search = labarugi_tglawal_searchField.getValue().format('Y-m-d');}
		if(labarugi_tglakhir_searchField.getValue()!==""){order_tglakhir_search = labarugi_tglakhir_searchField.getValue().format('Y-m-d');}
		if(labarugi_bulan_searchField.getValue()!==""){order_bulan_search=labarugi_bulan_searchField.getValue(); }
		if(labarugi_tahun_searchField.getValue()!==""){order_tahun_search=labarugi_tahun_searchField.getValue(); }
		
	
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_labarugi&m=get_action',
		params: {
			task: "PRINT",                 		
			labarugi_periode	:	labarugi_periode_search,
			labarugi_tglawal	:	labarugi_tglawal_search,
			labarugi_tglakhir	:	labarugi_tglakhir_search, 
			labarugi_bulan		: 	labarugi_bulan_search,
			labarugi_tahun		:	labarugi_tahun_search
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/lap_labarugi.html','labarugilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function labarugi_export_excel(){
		var labarugi_tglawal_search="";
		var labarugi_tglakhir_search="";
		var labarugi_opsi_search="";
		var labarugi_bulan_search="";
		var labarugi_tahun_search="";
		var labarugi_periode_search="";
		var labarugi_akun_search=null;
		
		if(labarugi_opsitgl_searchField.getValue()==true){
			labarugi_periode_search='tanggal';
		}else if(labarugi_opsibln_searchField.getValue()==true){
			labarugi_periode_search='bulan';
		}else{
			labarugi_periode_search='all';
		}
		
		if(labarugi_tglawal_searchField.getValue()!==""){order_tglawal_search = labarugi_tglawal_searchField.getValue().format('Y-m-d');}
		if(labarugi_tglakhir_searchField.getValue()!==""){order_tglakhir_search = labarugi_tglakhir_searchField.getValue().format('Y-m-d');}
		if(labarugi_bulan_searchField.getValue()!==""){order_bulan_search=labarugi_bulan_searchField.getValue(); }
		if(labarugi_tahun_searchField.getValue()!==""){order_tahun_search=labarugi_tahun_searchField.getValue(); }
		
	
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_labarugi&m=get_action',
		params: {
			task: "EXCEL",                 		
			labarugi_periode	:	labarugi_periode_search,
			labarugi_tglawal	:	labarugi_tglawal_search,
			labarugi_tglakhir	:	labarugi_tglakhir_search, 
			labarugi_bulan		: 	labarugi_bulan_search,
			labarugi_tahun		:	labarugi_tahun_search
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/lap_labarugi.xls','labarugilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	/*End of Function */
	
	
	display_form_search_window();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_labarugi"></div>
		<div id="elwindow_labarugi_create"></div>
        <div id="elwindow_labarugi_search"></div>
    </div>
</div>
</body>