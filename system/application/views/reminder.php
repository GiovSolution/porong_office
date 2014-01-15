<script type="text/javascript">
var pageS=15;

/* Ultah Customer ------------------------------------------------------------------------------------- */
/* Function for Retrieve DataStore */
tbl_cust_ultahDataStore = new Ext.data.Store({
	id: 'tbl_cust_ultahDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_customer&m=get_customer_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'cust_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'cust_id', type: 'int', mapping: 'cust_id'},
		{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
		{name: 'cust_ultah', type: 'int', mapping: 'ultah_ke'},
		{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
		{name: 'cust_ultahtgl', type: 'date', dateFormat: 'd-m', mapping: 'tgl_ultah'}
	]),
	sortInfo:{field: 'cust_tgllahir', direction: "ASC"}
});
/* End Function */
tbl_cust_ultahDataStore.load();

tbl_cust_ultahColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Nama',
		dataIndex: 'cust_nama',
		width: 100,
		sortable: true
	},{
		header: 'Tgl Ultah',
		dataIndex: 'cust_ultahtgl',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	},{
		header: 'Ke-',
		dataIndex: 'cust_ultah',
		width: 50,
		sortable: true
	}
	
]);

tbl_cust_ultahGrid =  new Ext.grid.GridPanel({
	id: 'tbl_cust_ultahGrid',
	el: 'grid-reminder-cust',
	title: '',
	autoHeight: true,
	store: tbl_cust_ultahDataStore, // DataStore
	cm: tbl_cust_ultahColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_ultah_cust_window(){
	var pk_cust=tbl_cust_ultahGrid.getSelectionModel().getSelected().get('cust_id');
	mainPanel.loadClass('?c=c_reminder_customer&id='+pk_cust,'View Customer');
}

tbl_cust_ultahGrid.on("dblclick",show_ultah_cust_window);
/* End of Ultah Customer----------------------------------------------------------- */

/* Ultah Keluarga ------------------------------------------------------------------------------------- */
/* Function for Retrieve DataStore */
tbl_kel_ultahDataStore = new Ext.data.Store({
	id: 'tbl_kel_ultahDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_keluarga&m=get_keluarga_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'kel_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'kel_id', type: 'int', mapping: 'kel_id'},
		{name: 'kel_nama', type: 'string', mapping: 'kel_nama'},
		{name: 'kel_ultah', type: 'int', mapping: 'ultah_ke'},
		{name: 'kel_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kel_tgllahir'},
		{name: 'kel_ultahtgl', type: 'date', dateFormat: 'd-m', mapping: 'tgl_ultah'}
	]),
	sortInfo:{field: 'kel_tgllahir', direction: "ASC"}
});
/* End Function */
tbl_kel_ultahDataStore.load();

tbl_kel_ultahColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Nama',
		dataIndex: 'kel_nama',
		width: 100,
		sortable: true
	},{
		header: 'Tgl Ultah',
		dataIndex: 'kel_ultahtgl',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	},{
		header: 'Ke-',
		dataIndex: 'kel_ultah',
		width: 50,
		sortable: true
	}
	
]);

tbl_kel_ultahGrid =  new Ext.grid.GridPanel({
	id: 'tbl_kel_ultahGrid',
	el: 'grid-reminder-kel',
	title: '',
	autoHeight: true,
	store: tbl_kel_ultahDataStore, // DataStore
	cm: tbl_kel_ultahColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_ultah_kel_window(){
	var pk_kel=tbl_kel_ultahGrid.getSelectionModel().getSelected().get('kel_id');
	mainPanel.loadClass('?c=c_reminder_keluarga&id_kel='+pk_kel,'View Keluarga');
}

tbl_kel_ultahGrid.on("dblclick",show_ultah_kel_window);
/* End of Ultah Keluarga----------------------------------------------------------- */

/* Rencana Kegiatan ------------------------------------------------------------------------------------- */
/* Function for Retrieve DataStore */
tbl_agendaDataStore = new Ext.data.Store({
	id: 'tbl_agendaDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_agenda&m=get_agenda_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'agenda_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'agenda_id', type: 'int', mapping: 'agenda_id'},
		{name: 'agenda_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'agenda_jenis', type: 'string', mapping: 'agenda_jenis'},
		{name: 'agenda_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'agenda_tanggal'}
	]),
	sortInfo:{field: 'agenda_tanggal', direction: "ASC"}
});
/* End Function */
tbl_agendaDataStore.load();

tbl_agendaColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'agenda_tanggal',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	},{
		header: 'Jenis',
		dataIndex: 'agenda_jenis',
		width: 100,
		sortable: true
	},{
		header: 'Customer',
		dataIndex: 'agenda_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_agendaGrid =  new Ext.grid.GridPanel({
	id: 'tbl_agendaGrid',
	el: 'grid-reminder-agenda',
	title: '',
	autoHeight: true,
	store: tbl_agendaDataStore, // DataStore
	cm: tbl_agendaColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_agenda_window(){
	var pk_agenda=tbl_agendaGrid.getSelectionModel().getSelected().get('agenda_id');
	mainPanel.loadClass('?c=c_reminder_agenda&id='+pk_agenda,'View Agenda');
}

tbl_agendaGrid.on("dblclick",show_agenda_window);
/* End of Rencana Kegiatan----------------------------------------------------------- */

/* Rencana Kirim/ Siap STNK-------------------------------------------------------------------------------- */
/* Function for Retrieve DataStore */
tbl_siap_kirimDataStore = new Ext.data.Store({
	id: 'tbl_siap_kirimDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_siap&m=get_siap_kirim_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'spk_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'spk_id', type: 'int', mapping: 'spk_id'},
		{name: 'spk_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'spk_tglsiap', type: 'date', dateFormat: 'Y-m-d', mapping: 'spk_tglsiap'}
	]),
	sortInfo:{field: 'spk_tglsiap', direction: "ASC"}
});
/* End Function */
tbl_siap_kirimDataStore.load();

tbl_siap_kirimColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'spk_tglsiap',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	},{
		header: 'Customer',
		dataIndex: 'spk_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_siap_kirimGrid =  new Ext.grid.GridPanel({
	id: 'tbl_siap_kirimGrid',
	el: 'grid-reminder-siap-kirim',
	title: '',
	autoHeight: true,
	store: tbl_siap_kirimDataStore, // DataStore
	cm: tbl_siap_kirimColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_siap_kirim_window(){
	var pk_siap_kirim=tbl_siap_kirimGrid.getSelectionModel().getSelected().get('spk_id');
	mainPanel.loadClass('?c=c_reminder_siap&id='+pk_siap_kirim,'View Siap Kirim/ STNK');
}

tbl_siap_kirimGrid.on("dblclick",show_siap_kirim_window);
/* End of Siap Kirim/ STNK ----------------------------------------------------------- */

/* Rencana Kirim ----------------------------------------------------------------------------- */
/* Function for Retrieve DataStore */
tbl_kirimDataStore = new Ext.data.Store({
	id: 'tbl_kirimDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_kirim&m=get_kirim_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'spk_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'spk_id', type: 'int', mapping: 'spk_id'},
		{name: 'spk_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'spk_tglkirim', type: 'date', dateFormat: 'Y-m-d', mapping: 'spk_tglkirim'}
	]),
	sortInfo:{field: 'spk_tglkirim', direction: "ASC"}
});
/* End Function */
tbl_kirimDataStore.load();

tbl_kirimColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'spk_tglkirim',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	},{
		header: 'Customer',
		dataIndex: 'spk_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_kirimGrid =  new Ext.grid.GridPanel({
	id: 'tbl_kirimGrid',
	el: 'grid-reminder-kirim',
	title: '',
	autoHeight: true,
	store: tbl_kirimDataStore, // DataStore
	cm: tbl_kirimColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_kirim_window(){
	var pk_kirim=tbl_kirimGrid.getSelectionModel().getSelected().get('spk_id');
	mainPanel.loadClass('?c=c_reminder_kirim&id='+pk_kirim,'View Rencana Kirim');
}

tbl_kirimGrid.on("dblclick",show_kirim_window);
/* End of Rencana Kirim  ----------------------------------------------------------- */

/* Lunas DP/ Akhir------------------------------------------------------------------ */
/* Function for Retrieve DataStore */
tbl_lunasDataStore = new Ext.data.Store({
	id: 'tbl_lunasDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_lunas&m=get_lunas_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'do_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'do_id', type: 'int', mapping: 'do_id'},
		{name: 'do_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'do_jenisbayar', type: 'string', mapping: 'do_jenisbayar'},
		{name: 'do_tgllunas', type: 'date', dateFormat: 'Y-m-d', mapping: 'do_tgllunas'}
	]),
	sortInfo:{field: 'do_tgllunas', direction: "ASC"}
});
/* End Function */
tbl_lunasDataStore.load();

tbl_lunasColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'do_tgllunas',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	}
	,{
		header: 'Jenis Bayar',
		dataIndex: 'do_jenisbayar',
		width: 100,
		sortable: true
	}
	,{
		header: 'Customer',
		dataIndex: 'do_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_lunasGrid =  new Ext.grid.GridPanel({
	id: 'tbl_lunasGrid',
	el: 'grid-reminder-lunas',
	title: '',
	autoHeight: true,
	store: tbl_lunasDataStore, // DataStore
	cm: tbl_lunasColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_lunas_window(){
	var pk_lunas=tbl_lunasGrid.getSelectionModel().getSelected().get('do_id');
	mainPanel.loadClass('?c=c_reminder_lunas&id='+pk_lunas,'View Lunas');
}

tbl_lunasGrid.on("dblclick",show_lunas_window);
/* End of lunas DP/ Akhir  ----------------------------------------------------------- */

/* stnk habis ------------------------------------------------------------------ */
/* Function for Retrieve DataStore */
tbl_stnkDataStore = new Ext.data.Store({
	id: 'tbl_stnkDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_stnk&m=get_stnk_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'do_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'stnk_id', type: 'int', mapping: 'do_id'},
		{name: 'stnk_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'stnk_nopol', type: 'string', mapping: 'do_nopol'},
		{name: 'stnk_tglstnk', type: 'date', dateFormat: 'Y-m-d', mapping: 'do_tglstnk'}
	]),
	sortInfo:{field: 'stnk_tglstnk', direction: "ASC"}
});
/* End Function */
tbl_stnkDataStore.load();

tbl_stnkColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'stnk_tglstnk',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	}
	,{
		header: 'No Pol',
		dataIndex: 'stnk_nopol',
		width: 100,
		sortable: true
	}
	,{
		header: 'Customer',
		dataIndex: 'stnk_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_stnkGrid =  new Ext.grid.GridPanel({
	id: 'tbl_stnkGrid',
	el: 'grid-reminder-stnk',
	title: '',
	autoHeight: true,
	store: tbl_stnkDataStore, // DataStore
	cm: tbl_stnkColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_stnk_window(){
	var pk_stnk=tbl_stnkGrid.getSelectionModel().getSelected().get('stnk_id');
	mainPanel.loadClass('?c=c_reminder_stnk&id='+pk_stnk,'View STNK Habis');
}

tbl_stnkGrid.on("dblclick",show_stnk_window);
/* End of stnk  ----------------------------------------------------------- */

/* CR Status ------------------------------------------------------------------ */
/* Function for Retrieve DataStore */
tbl_crDataStore = new Ext.data.Store({
	id: 'tbl_crDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_cr&m=get_cr_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'do_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'cr_id', type: 'int', mapping: 'do_id'},
		{name: 'cr_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'cr_status', type: 'string', mapping: 'do_cr'},
		{name: 'cr_tglkirim', type: 'date', dateFormat: 'Y-m-d', mapping: 'do_tglkirim'}
	]),
	sortInfo:{field: 'cr_tglkirim', direction: "ASC"}
});
/* End Function */
tbl_crDataStore.load();

tbl_crColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'cr_tglkirim',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	}
	,{
		header: 'Status CR',
		dataIndex: 'cr_status',
		width: 100,
		sortable: true
	}
	,{
		header: 'Customer',
		dataIndex: 'cr_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_crGrid =  new Ext.grid.GridPanel({
	id: 'tbl_crGrid',
	el: 'grid-reminder-cr',
	title: '',
	autoHeight: true,
	store: tbl_crDataStore, // DataStore
	cm: tbl_crColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_cr_window(){
	var pk_cr=tbl_crGrid.getSelectionModel().getSelected().get('cr_id');
	mainPanel.loadClass('?c=c_reminder_cr&id='+pk_cr,'View Status CR');
}

tbl_crGrid.on("dblclick",show_cr_window);
/* End of cr  ----------------------------------------------------------- */

/* Kredit Status ------------------------------------------------------------------ */
/* Function for Retrieve DataStore */
tbl_kreditDataStore = new Ext.data.Store({
	id: 'tbl_kreditDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_kredit&m=get_kredit_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'do_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'kredit_id', type: 'int', mapping: 'do_id'},
		{name: 'kredit_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'kredit_jenisbayar', type: 'string', mapping: 'do_jenisbayar'},
		{name: 'kredit_jatuhtempo', type: 'date', dateFormat: 'Y-m-d', mapping: 'jatuh_tempo'}
	]),
	sortInfo:{field: 'kredit_jatuhtempo', direction: "ASC"}
});
/* End Function */
tbl_kreditDataStore.load();

tbl_kreditColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'kredit_jatuhtempo',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	}
	,{
		header: 'Kredit via',
		dataIndex: 'kredit_jenisbayar',
		width: 100,
		sortable: true
	}
	,{
		header: 'Customer',
		dataIndex: 'kredit_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_kreditGrid =  new Ext.grid.GridPanel({
	id: 'tbl_kreditGrid',
	el: 'grid-reminder-kredit',
	title: '',
	autoHeight: true,
	store: tbl_kreditDataStore, // DataStore
	cm: tbl_kreditColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_kredit_window(){
	var pk_kredit=tbl_kreditGrid.getSelectionModel().getSelected().get('kredit_id');
	mainPanel.loadClass('?c=c_reminder_kredit&id='+pk_kredit,'View Jatuh Tempo Kredit');
}

tbl_kreditGrid.on("dblclick",show_kredit_window);
/* End of kredit  ----------------------------------------------------------- */

/* Asuransi Status ------------------------------------------------------------------ */
/* Function for Retrieve DataStore */
tbl_asuransiDataStore = new Ext.data.Store({
	id: 'tbl_asuransiDataStore',
	proxy: new Ext.data.HttpProxy({
		url: 'index.php?c=c_reminder_asuransi&m=get_asuransi_list', 
		method: 'POST'
	}),
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'do_id'
	},[
	/* dataIndex => insert intotbl_customerColumnModel, Mapping => for initiate table column */ 
		{name: 'asuransi_id', type: 'int', mapping: 'do_id'},
		{name: 'asuransi_cust', type: 'string', mapping: 'cust_nama'},
		{name: 'asuransi_via', type: 'string', mapping: 'do_asuransi'},
		{name: 'asuransi_jatuhtempo', type: 'date', dateFormat: 'Y-m-d', mapping: 'jatuh_tempo'}
	]),
	sortInfo:{field: 'asuransi_jatuhtempo', direction: "ASC"}
});
/* End Function */
tbl_asuransiDataStore.load();

tbl_asuransiColumnModel = new Ext.grid.ColumnModel(
	[{
		header: 'Tanggal',
		dataIndex: 'asuransi_jatuhtempo',
		width: 80,
		sortable: true,
		renderer: Ext.util.Format.dateRenderer('Y-m-d')
	}
	,{
		header: 'Asuransi via',
		dataIndex: 'asuransi_via',
		width: 100,
		sortable: true
	}
	,{
		header: 'Customer',
		dataIndex: 'asuransi_cust',
		width: 100,
		sortable: true
	}
	
]);

tbl_asuransiGrid =  new Ext.grid.GridPanel({
	id: 'tbl_asuransiGrid',
	el: 'grid-reminder-asuransi',
	title: '',
	autoHeight: true,
	store: tbl_asuransiDataStore, // DataStore
	cm: tbl_asuransiColumnModel, // nama-nama Columns
	enableColLock:false,
	frame: false,
	titleCollapse: true,
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
	viewConfig: { forceFit:true },
	width: 290
});

function show_asuransi_window(){
	var pk_asuransi=tbl_asuransiGrid.getSelectionModel().getSelected().get('asuransi_id');
	mainPanel.loadClass('?c=c_reminder_asuransi&id='+pk_asuransi,'View Jatuh Tempo Asuransi');
}


tbl_asuransiGrid.on("dblclick",show_asuransi_window);
/* End of asuransi  ----------------------------------------------------------- */

var reminderPanel=new Ext.TabPanel({
	border:false,
	activeTab:0,
	autoScroll: true,
	animScroll: true,
	enableTabScroll: true, 
	tabPosition:'top',
	items:[{
		   	title: 'Ultah Customer',
			frame: true,
			border: false,
			items: tbl_cust_ultahGrid
		   },
		   {
		   	title: 'Ultah Pejabat/Keluarga',
			frame: true,
			border: false,
			items: tbl_kel_ultahGrid
		   },
		   {
		   	title: 'Rencana Kegiatan',
			frame: true,
			border: false,
			items: tbl_agendaGrid
		   },
		   {
		   	title: 'Siap Kirim/ STNK',
			frame: true,
			border: false,
			items: tbl_siap_kirimGrid
		   },
		   {
		   	title: 'Rencana Kirim',
			frame: true,
			border: false,
			items: tbl_kirimGrid
		   },
		   {
		   	title: 'Lunas DP/ Akhir',
			frame: true,
			border: false,
			items: tbl_lunasGrid
		   },
		   {
		   	title: 'STNK Habis',
			frame: true,
			border: false,
			items: tbl_stnkGrid
		   },
		   {
		   	title: 'Status CR',
			frame: true,
			border: false,
			items: tbl_crGrid
		   },
		   {
		   	title: 'Jatuh Tempo Kredit',
			frame: true,
			border: false,
			items: tbl_kreditGrid
		   },
		   {
		   	title: 'Jatuh Tempo Asuransi',
			frame: true,
			border: false,
			items: tbl_asuransiGrid
		   }
	]
});

var task = {
    run: function(){
       tbl_cust_ultahDataStore.reload();
	   tbl_kel_ultahDataStore.reload();
	   tbl_agendaDataStore.reload();
	   tbl_siap_kirimDataStore.reload();
	   tbl_kirimDataStore.reload();
	   tbl_lunasDataStore.reload();
	   tbl_stnkDataStore.reload();
	   tbl_crDataStore.reload();
	   tbl_kreditDataStore.reload();
	   tbl_asuransiDataStore.reload();
    },
    interval: 10000 //5 second
}
var runner = new Ext.util.TaskRunner();
runner.start(task);

</script>
