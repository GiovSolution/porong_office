<?
/* 	
	GIOV Solution - Keep IT Simple
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
var supplier_DataStore;
var supplier_ColumnModel;
var supplierListEditorGrid;
var supplier_createForm;
var supplier_createWindow;
var supplier_searchForm;
var supplier_searchWindow;
var supplier_SelectedRow;
var supplier_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var supplier_idField;
var supplier_kategoriField;
var supplier_kategoritxtField;
var supplier_namaField;
var supplier_alamatField;
var supplier_kotaField;
var supplier_kodeposField;
var supplier_propinsiField;
var supplier_negaraField;
var supplier_notelpField;
var supplier_notelp2Field;
var supplier_nofaxField;
var supplier_emailField;
var supplier_websiteField;
var supplier_cpField;
var supplier_contact_cpField;
var supplier_keteranganField;
var supplier_aktifField;

var supplier_idSearchField;
var supplier_kategoriSearchField;
var supplier_namaSearchField;
var supplier_alamatSearchField;
var supplier_kotaSearchField;
var supplier_kodeposSearchField;
var supplier_propinsiSearchField;
var supplier_negaraSearchField;
var supplier_notelpSearchField;
var supplier_notelp2SearchField;
var supplier_nofaxSearchField;
var supplier_emailSearchField;
var supplier_websiteSearchField;
var supplier_cpSearchField;
var supplier_contact_cpSearchField;
var supplier_aktifSearchField;
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
	function supplier_update(oGrid_event){
	var supplier_id_update_pk="";
	var supplier_kategori_update=null;
	var supplier_nama_update=null;
	var supplier_alamat_update=null;
	var supplier_kota_update=null;
	var supplier_kodepos_update=null;
	var supplier_propinsi_update=null;
	var supplier_negara_update=null;
	var supplier_notelp_update=null;
	var supplier_notelp2_update=null;
	var supplier_nofax_update=null;
	var supplier_email_update=null;
	var supplier_website_update=null;
	var supplier_cp_update=null;
	var supplier_contact_cp_update=null;
	var supplier_aktif_update=null;

	supplier_id_update_pk = oGrid_event.record.data.supplier_id;
	if(oGrid_event.record.data.supplier_kategori!== null){supplier_kategori_update = oGrid_event.record.data.supplier_kategori;}
	if(oGrid_event.record.data.supplier_nama!== null){supplier_nama_update = oGrid_event.record.data.supplier_nama;}
	if(oGrid_event.record.data.supplier_alamat!== null){supplier_alamat_update = oGrid_event.record.data.supplier_alamat;}
	if(oGrid_event.record.data.supplier_kota!== null){supplier_kota_update = oGrid_event.record.data.supplier_kota;}
	if(oGrid_event.record.data.supplier_kodepos!== null){supplier_kodepos_update = oGrid_event.record.data.supplier_kodepos;}
	if(oGrid_event.record.data.supplier_propinsi!== null){supplier_propinsi_update = oGrid_event.record.data.supplier_propinsi;}
	if(oGrid_event.record.data.supplier_negara!== null){supplier_negara_update = oGrid_event.record.data.supplier_negara;}
	if(oGrid_event.record.data.supplier_notelp!== null){supplier_notelp_update = oGrid_event.record.data.supplier_notelp;}
	if(oGrid_event.record.data.supplier_notelp2!== null){supplier_notelp2_update = oGrid_event.record.data.supplier_notelp2;}
	if(oGrid_event.record.data.supplier_nofax!== null){supplier_nofax_update = oGrid_event.record.data.supplier_nofax;}
	if(oGrid_event.record.data.supplier_email!== null){supplier_email_update = oGrid_event.record.data.supplier_email;}
	if(oGrid_event.record.data.supplier_website!== null){supplier_website_update = oGrid_event.record.data.supplier_website;}
	if(oGrid_event.record.data.supplier_cp!== null){supplier_cp_update = oGrid_event.record.data.supplier_cp;}
	if(oGrid_event.record.data.supplier_contact_cp!== null){supplier_contact_cp_update = oGrid_event.record.data.supplier_contact_cp;}
	if(oGrid_event.record.data.supplier_aktif!== null){supplier_aktif_update = oGrid_event.record.data.supplier_aktif;}
	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_supplier&m=get_action',
			params: {
				task: "UPDATE",
				supplier_id	: supplier_id_update_pk,				
				supplier_kategori	:supplier_kategori_update,		
				supplier_nama	:supplier_nama_update,		
				supplier_alamat	:supplier_alamat_update,		
				supplier_kota	:supplier_kota_update,		
				supplier_kodepos	:supplier_kodepos_update,		
				supplier_propinsi	:supplier_propinsi_update,		
				supplier_negara	:supplier_negara_update,		
				supplier_notelp	:supplier_notelp_update,		
				supplier_notelp2	:supplier_notelp2_update,		
				supplier_nofax	:supplier_nofax_update,		
				supplier_email	:supplier_email_update,		
				supplier_website	:supplier_website_update,		
				supplier_cp	:supplier_cp_update,		
				supplier_contact_cp	:supplier_contact_cp_update,		
				supplier_aktif	:supplier_aktif_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						supplier_DataStore.commitChanges();
						supplier_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Supplier tidak bisa disimpan.',
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
  
  	/* Function for add data, open window create form */
	function supplier_create(){
		if(is_supplier_form_valid()){
		
		var supplier_id_create_pk=null;
		var supplier_kategori_create=null;
		var supplier_kategoritxt_create=null;
		var supplier_nama_create=null;
		var supplier_alamat_create=null;
		var supplier_kota_create=null;
		var supplier_kodepos_create=null;
		var supplier_propinsi_create=null;
		var supplier_negara_create=null;
		var supplier_notelp_create=null;
		var supplier_notelp2_create=null;
		var supplier_nofax_create=null;
		var supplier_email_create=null;
		var supplier_website_create=null;
		var supplier_cp_create=null;
		var supplier_contact_cp_create=null;
		var supplier_keterangan_create=null;
		var supplier_aktif_create=null;

		supplier_id_create_pk=get_pk_id();
		if(supplier_kategoriField.getValue()!== null){supplier_kategori_create = supplier_kategoriField.getValue();}
		if(supplier_kategoritxtField.getValue()!== null){supplier_kategoritxt_create = supplier_kategoritxtField.getValue();}
		if(supplier_namaField.getValue()!== null){supplier_nama_create = supplier_namaField.getValue();}
		if(supplier_alamatField.getValue()!== null){supplier_alamat_create = supplier_alamatField.getValue();}
		if(supplier_kotaField.getValue()!== null){supplier_kota_create = supplier_kotaField.getValue();}
		if(supplier_kodeposField.getValue()!== null){supplier_kodepos_create = supplier_kodeposField.getValue();}
		if(supplier_propinsiField.getValue()!== null){supplier_propinsi_create = supplier_propinsiField.getValue();}
		if(supplier_negaraField.getValue()!== null){supplier_negara_create = supplier_negaraField.getValue();}
		if(supplier_notelpField.getValue()!== null){supplier_notelp_create = supplier_notelpField.getValue();}
		if(supplier_notelp2Field.getValue()!== null){supplier_notelp2_create = supplier_notelp2Field.getValue();}
		if(supplier_nofaxField.getValue()!== null){supplier_nofax_create = supplier_nofaxField.getValue();}
		if(supplier_emailField.getValue()!== null){supplier_email_create = supplier_emailField.getValue();}
		if(supplier_websiteField.getValue()!== null){supplier_website_create = supplier_websiteField.getValue();}
		if(supplier_cpField.getValue()!== null){supplier_cp_create = supplier_cpField.getValue();}
		if(supplier_contact_cpField.getValue()!== null){supplier_contact_cp_create = supplier_contact_cpField.getValue();}
		if(supplier_keteranganField.getValue()!== null){supplier_keterangan_create = supplier_keteranganField.getValue();}
		if(supplier_aktifField.getValue()!== null){supplier_aktif_create = supplier_aktifField.getValue();}


		// Penambahan Detail Supplier Produk
                    var dsupplier_id = [];
                    var dsupplier_produk = [];
                    var dsupplier_keterangan = [];
                    var dcount_dserahbahan = detail_supplier_produkDataStore.getCount() - 1;
                    
                    if(detail_supplier_produkDataStore.getCount()>0){
                        for(i=0; i<detail_supplier_produkDataStore.getCount();i++){
                           	dsupplier_id.push(detail_supplier_produkDataStore.getAt(i).data.dsupplier_id);
                           	dsupplier_produk.push(detail_supplier_produkDataStore.getAt(i).data.dsupplier_produk);
                           	dsupplier_keterangan.push(detail_supplier_produkDataStore.getAt(i).data.dsupplier_keterangan);
                        }
                    }
                    
                    var encoded_array_dsupplier_id = Ext.encode(dsupplier_id);
                    var encoded_array_dsupplier_produk = Ext.encode(dsupplier_produk);			
                    var encoded_array_dsupplier_keterangan = Ext.encode(dsupplier_keterangan);

		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_supplier&m=get_action',
				params: {
					task: post2db,
					supplier_id	: supplier_id_create_pk,	
					supplier_kategori	: supplier_kategori_create,	
					supplier_kategoritxt	: supplier_kategoritxt_create,	
					supplier_nama	: supplier_nama_create,	
					supplier_alamat	: supplier_alamat_create,	
					supplier_kota	: supplier_kota_create,	
					supplier_kodepos	: supplier_kodepos_create,	
					supplier_propinsi	: supplier_propinsi_create,	
					supplier_negara	: supplier_negara_create,	
					supplier_notelp	: supplier_notelp_create,	
					supplier_notelp2	: supplier_notelp2_create,	
					supplier_nofax	: supplier_nofax_create,	
					supplier_email	: supplier_email_create,	
					supplier_website	: supplier_website_create,	
					supplier_cp	: supplier_cp_create,	
					supplier_contact_cp	: supplier_contact_cp_create,	
					supplier_keterangan	: supplier_keterangan_create,
					supplier_aktif	: supplier_aktif_create,

					//Detail Supplier Produk
					dsupplier_id					: encoded_array_dsupplier_id, 
					dsupplier_master				: eval(get_pk_id()),
					dsupplier_produk				: encoded_array_dsupplier_produk, 
					dsupplier_keterangan			: encoded_array_dsupplier_keterangan
					
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Supplier berhasil disimpan.');
							supplier_DataStore.reload();
							supplier_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Supplier tidak bisa disimpan!.',
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
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Isian belum sempurna!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function supplier_reset_form(){
		supplier_kategoriField.reset();
		supplier_kategoriField.setValue(null);
		supplier_kategoritxtField.reset();
		supplier_kategoritxtField.setValue(null);
		supplier_namaField.reset();
		supplier_namaField.setValue(null);
		supplier_alamatField.reset();
		supplier_alamatField.setValue(null);
		supplier_kotaField.reset();
		supplier_kotaField.setValue(null);
		supplier_kodeposField.reset();
		supplier_kodeposField.setValue(null);
		supplier_propinsiField.reset();
		supplier_propinsiField.setValue(null);
		supplier_negaraField.reset();
		supplier_negaraField.setValue(null);
		supplier_notelpField.reset();
		supplier_notelpField.setValue(null);
		supplier_notelp2Field.reset();
		supplier_notelp2Field.setValue(null);
		supplier_nofaxField.reset();
		supplier_nofaxField.setValue(null);
		supplier_emailField.reset();
		supplier_emailField.setValue(null);
		supplier_websiteField.reset();
		supplier_websiteField.setValue(null);
		supplier_cpField.reset();
		supplier_cpField.setValue(null);
		supplier_contact_cpField.reset();
		supplier_contact_cpField.setValue(null);
		supplier_keteranganField.reset();
		supplier_keteranganField.setValue(null);
		supplier_aktifField.reset();
		supplier_aktifField.setValue('Aktif');
		// cbo_supplier_kategoriDataStore.reload();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function supplier_set_form(){
		supplier_kategoriField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_kategori'));
		supplier_namaField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_nama'));
		supplier_alamatField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_alamat'));
		supplier_kotaField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_kota'));
		supplier_kodeposField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_kodepos'));
		supplier_propinsiField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_propinsi'));
		supplier_negaraField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_negara'));
		supplier_notelpField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_notelp'));
		supplier_notelp2Field.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_notelp2'));
		supplier_nofaxField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_nofax'));
		supplier_emailField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_email'));
		supplier_websiteField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_website'));
		supplier_cpField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_cp'));
		supplier_contact_cpField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_contact_cp'));
		supplier_keteranganField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_keterangan'));
		supplier_aktifField.setValue(supplierListEditorGrid.getSelectionModel().getSelected().get('supplier_aktif'));

		cbo_dsupplier_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_dsupplier_produk_DataStore.setBaseParam('task','detail');
		cbo_dsupplier_produk_DataStore.load({
			callback: function(opts, success, response){
						detail_supplier_produkDataStore.load({params: {master_id: get_pk_id(), start:0, limit: pageS}});
					}
		});

		

		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_supplier_form_valid(){
		return (supplier_namaField.isValid() && supplier_alamatField.isValid() && supplier_notelpField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!supplier_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			supplier_reset_form();
			
			supplier_createWindow.show();
		} else {
			supplier_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function supplier_confirm_delete(){
		// only one supplier is selected here
		if(supplierListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', supplier_delete);
		} else if(supplierListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', supplier_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function supplier_confirm_update(){
		/* only one record is selected here */
		if(supplierListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			supplier_set_form();
			
			supplier_createWindow.show();
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
  
  	/* Function for Delete Record */
	function supplier_delete(btn){
		if(btn=='yes'){
			var selections = supplierListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< supplierListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.supplier_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_supplier&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							supplier_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
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
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	supplier_DataStore = new Ext.data.Store({
		id: 'supplier_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_supplier&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'supplier_id'
		},[
			{name: 'supplier_id', type: 'int', mapping: 'supplier_id'},
			{name: 'supplier_kategori', type: 'string', mapping: 'supplier_kategori'},
			{name: 'supplier_nama', type: 'string', mapping: 'supplier_nama'},
			{name: 'supplier_alamat', type: 'string', mapping: 'supplier_alamat'},
			{name: 'supplier_kota', type: 'string', mapping: 'supplier_kota'},
			{name: 'supplier_kodepos', type: 'string', mapping: 'supplier_kodepos'},
			{name: 'supplier_propinsi', type: 'string', mapping: 'supplier_propinsi'},
			{name: 'supplier_negara', type: 'string', mapping: 'supplier_negara'},
			{name: 'supplier_notelp', type: 'string', mapping: 'supplier_notelp'},
			{name: 'supplier_notelp2', type: 'string', mapping: 'supplier_notelp2'},
			{name: 'supplier_nofax', type: 'string', mapping: 'supplier_nofax'},
			{name: 'supplier_email', type: 'string', mapping: 'supplier_email'},
			{name: 'supplier_website', type: 'string', mapping: 'supplier_website'},
			{name: 'supplier_cp', type: 'string', mapping: 'supplier_cp'},
			{name: 'supplier_contact_cp', type: 'string', mapping: 'supplier_contact_cp'},
			{name: 'supplier_keterangan', type: 'string', mapping: 'supplier_keterangan'},
			{name: 'supplier_aktif', type: 'string', mapping: 'supplier_aktif'},
			{name: 'supplier_creator', type: 'string', mapping: 'supplier_creator'},
			{name: 'supplier_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'supplier_date_create'},
			{name: 'supplier_update', type: 'string', mapping: 'supplier_update'},
			{name: 'supplier_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'supplier_date_update'},
			{name: 'supplier_revised', type: 'int', mapping: 'supplier_revised'}
		]),
		sortInfo:{field: 'supplier_id', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_supplier_kategoriDataStore = new Ext.data.Store({
		id: 'cbo_supplier_kategoriDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_supplier&m=get_supplier_kategori_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'supplier_kategori_display', type: 'string', mapping: 'supplier_kategori'}
		]),
		sortInfo:{field: 'supplier_kategori_display', direction: "ASC"}
	});

	/* Function for Retrieve Combo Produk DataStore */
	var cbo_dsupplier_produk_DataStore = new Ext.data.Store({
		id: 'cbo_dsupplier_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_supplier&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "list",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produksi_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'order_produk_satuan', type: 'string', mapping: 'satuan_id'},
			{name: 'dorder_harga', type: 'float', mapping: 'dorder_harga'},
			{name: 'dorder_harga_log', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dorder_harga_log'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});

	var cbo_dsupplier_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{produksi_produk_kode}| <b>{produk_nama}</b>',
		'</div></tpl>'
    );

	// DataStore Reader untuk Detail Supplier Produk
	var detail_supplier_produk_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
	},[
			{name: 'dsupplier_id', type: 'int', mapping: 'dsupplier_id'},
			{name: 'dsupplier_produk', type: 'int', mapping: 'dsupplier_produk'},
			{name: 'dsupplier_keterangan', type: 'string', mapping: 'dsupplier_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
	]);

	/* Function for Retrieve DataStore of detail Supplier Produk*/
	var detail_supplier_produkDataStore = new Ext.data.Store({
		id: 'detail_supplier_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_supplier&m=detail_supplier_produk_list',
			method: 'POST'
		}),
		reader: detail_supplier_produk_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: pageS},
		sortInfo:{field: 'dsupplier_produk', direction: "ASC"}
	});
	/* End of Function */

    
  	/* Function for Identify of Window Column Model */
	supplier_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'supplier_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		/* //utk saat ini kategori tidak dipakai
		{
			header: 'Kategori',
			dataIndex: 'supplier_kategori',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 150
          	})
			<?php } ?>
		},*/
		{
			header: '<div align="center"> Nama </div>',
			dataIndex: 'supplier_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Alamat </div>',
			dataIndex: 'supplier_alamat',
			width: 250,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Kota </div>',
			dataIndex: 'supplier_kota',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Kode Pos </div>',
			dataIndex: 'supplier_kodepos',
			width: 100,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 5
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Propinsi </div>',
			dataIndex: 'supplier_propinsi',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Negara </div>',
			dataIndex: 'supplier_negara',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> No Telp </div>',
			dataIndex: 'supplier_notelp',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> No Telp Lain </div>',
			dataIndex: 'supplier_notelp2',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> No Fax </div>',
			dataIndex: 'supplier_nofax',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Email </div>',
			dataIndex: 'supplier_email',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Website </div>',
			dataIndex: 'supplier_website',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Contact Person </div>',
			dataIndex: 'supplier_cp',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Telp CP </div>',
			dataIndex: 'supplier_contact_cp',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			header: '<div align="center"> Status </div>',
			dataIndex: 'supplier_aktif',
			width: 60,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['supplier_aktif_value', 'supplier_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'supplier_aktif_display',
               	valueField: 'supplier_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'supplier_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'supplier_date_create',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'supplier_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'supplier_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'supplier_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	supplier_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	supplierListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'supplierListEditorGrid',
		el: 'fp_supplier',
		title: 'Daftar Supplier',
		autoHeight: true,
		store: supplier_DataStore, // DataStore
		cm: supplier_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width:1200,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: supplier_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: supplier_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: supplier_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: supplier_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						supplier_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama<br>- No Telp<br>- Contact Person<br>- Telp CP'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: supplier_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: supplier_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: supplier_print  
		}
		]
	});
	supplierListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	supplier_ContextMenu = new Ext.menu.Menu({
		id: 'supplier_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: supplier_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: supplier_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: supplier_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: supplier_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onsupplier_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		supplier_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		supplier_SelectedRow=rowIndex;
		supplier_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function supplier_editContextMenu(){
      supplierListEditorGrid.startEditing(supplier_SelectedRow,1);
  	}
	/* End of Function */
  	
	supplierListEditorGrid.addListener('rowcontextmenu', onsupplier_ListEditGridContextMenu);
	supplier_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	supplierListEditorGrid.on('afteredit', supplier_update); // inLine Editing Record
	
	//cbo_supplier_kategoriDataStore.load();
	
	/* Identify  supplier_kategori Field */
	supplier_kategoriField= new Ext.form.ComboBox({
		id: 'supplier_kategoriField',
		fieldLabel: 'Kategori',
		store:cbo_supplier_kategoriDataStore,
		mode: 'remote',
		editable:false,
		displayField: 'supplier_kategori_display',
		valueField: 'supplier_kategori_display',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  supplier_kategoritxt Field */
	supplier_kategoritxtField= new Ext.form.TextField({
		id: 'supplier_kategoritxtField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (optional)',
		maxLength: 50,
		allowBlank: true,
		emptyText: 'Kategori lainnya...',
		anchor: '95%'
	});
	/* Identify  supplier_nama Field */
	supplier_namaField= new Ext.form.TextField({
		id: 'supplier_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  supplier_alamat Field */
	supplier_alamatField= new Ext.form.TextField({
		id: 'supplier_alamatField',
		fieldLabel: 'Alamat <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank:false,
		anchor: '95%'
	});
	/* Identify  supplier_kota Field */
	supplier_kotaField= new Ext.form.TextField({
		id: 'supplier_kotaField',
		fieldLabel: 'Kota',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  supplier_kodepos Field */
	supplier_kodeposField= new Ext.form.TextField({
		id: 'supplier_kodeposField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		width: 60
	});
	/* Identify  supplier_propinsi Field */
	supplier_propinsiField= new Ext.form.TextField({
		id: 'supplier_propinsiField',
		fieldLabel: 'Propinsi',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  supplier_negara Field */
	supplier_negaraField= new Ext.form.TextField({
		id: 'supplier_negaraField',
		fieldLabel: 'Negara',
		maxLength: 250,
		anchor: '95%',
		emptyText: 'Indonesia'
	});
	/* Identify  supplier_notelp Field */
	supplier_notelpField= new Ext.form.TextField({
		id: 'supplier_notelpField',
		fieldLabel: 'No. Telepon 1 <span style="color: #ec0000">*</span>',
		maxLength: 25,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  supplier_notelp2 Field */
	supplier_notelp2Field= new Ext.form.TextField({
		id: 'supplier_notelp2Field',
		fieldLabel: 'No. Telepon 2',
		maxLength: 25,
		anchor: '95%'
	});
	/* Identify  supplier_nofax Field */
	supplier_nofaxField= new Ext.form.TextField({
		id: 'supplier_nofaxField',
		fieldLabel: 'Fax',
		maxLength: 25,
		anchor: '95%'
	});
	/* Identify  supplier_email Field */
	supplier_emailField= new Ext.form.TextField({
		id: 'supplier_emailField',
		fieldLabel: 'Email',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  supplier_website Field */
	supplier_websiteField= new Ext.form.TextField({
		id: 'supplier_websiteField',
		fieldLabel: 'Website',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  supplier_cp Field */
	supplier_cpField= new Ext.form.TextField({
		id: 'supplier_cpField',
		fieldLabel: 'Contact Person',
		maxLength: 250,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  supplier_contact_cp Field */
	supplier_contact_cpField= new Ext.form.TextField({
		id: 'supplier_contact_cpField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Telepon',
		maxLength: 25,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  supplier_keterangan Field */
	supplier_keteranganField= new Ext.form.TextArea({
		id: 'supplier_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  supplier_aktif Field */
	supplier_aktifField= new Ext.form.ComboBox({
		id: 'supplier_aktifField',
		name: 'supplier_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['supplier_aktif_value', 'supplier_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'supplier_aktif_display',
		valueField: 'supplier_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});

	//Declaration Combo Supplier Produk
	var combo_dsupplier_produk =new Ext.form.ComboBox({
		store: cbo_dsupplier_produk_DataStore,
		mode: 'remote',
		displayField: 'produk_nama',
		valueField: 'produk_id',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize: pageS,
		hideTrigger:false,
		tpl: cbo_dsupplier_produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//function for editor of detail Supplier Produk
	var editor_dsupplier_produk= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	/*Fieldset Master*/
	supplier_masterGroup = new Ext.form.FieldSet({
		autoHeight: true,
		layout:'column',
		items:[
			{
				columnWidth:0.48,
				layout: 'form',
				border:false,
				items: [supplier_namaField, supplier_alamatField, supplier_kotaField,
						supplier_kodeposField, supplier_propinsiField, supplier_negaraField, supplier_websiteField] 
			},
			{
				columnWidth:0.02,
				layout: 'form',
				border:false,
				items: [{xtype: 'spacer',height:10}] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [supplier_notelpField, supplier_notelp2Field,supplier_nofaxField, supplier_emailField, supplier_cpField, 
						supplier_contact_cpField, supplier_keteranganField, supplier_aktifField] 
			}
			]
	});

	//Column Model Remarks - Detail Supplier Produk
	detail_supplier_produk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dsupplier_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'dsupplier_produk',
			width: 250,
			sortable: false,
			allowBlank : false,
			editor: combo_dsupplier_produk,
			renderer: Ext.util.Format.comboRenderer(combo_dsupplier_produk)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dsupplier_keterangan',
			width: 400,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
		}
		]
	);
	detail_supplier_produk_ColumnModel.defaultSortable= true;


	//declaration of Detail Supplier Produk
	detail_supplier_produk_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_supplier_produk_ListEditorGrid',
		el: 'fp_detail_supplier_produk',
		title: 'Detail Supplier Produk',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: detail_supplier_produkDataStore,
		colModel: detail_supplier_produk_ColumnModel, 
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		plugins: [editor_dsupplier_produk],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			// ref : '../djpaket_add',
			handler: detail_supplier_produk_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			// ref : '../djpaket_delete',
			handler: detail_supplier_produk_delete
		}
		]
	});
	//eof

	//function of detail add Detail Supplier Produk
	function detail_supplier_produk_add(){
		var edit_dsupplier_prod= new detail_supplier_produk_ListEditorGrid.store.recordType({
			dsupplier_id			:'',
			dsupplier_produk		:'',
			dsupplier_keterangan	:''
		});
		editor_dsupplier_produk.stopEditing();
		detail_supplier_produkDataStore.insert(0, edit_dsupplier_prod);
		detail_supplier_produk_ListEditorGrid.getSelectionModel().selectRow(0);
		editor_dsupplier_produk.startEditing(0);
	}

	/* Function for Delete Confirm of detail Supplier Produk*/
	function detail_supplier_produk_delete(){
		// only one record is selected here
		if(detail_supplier_produk_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_supplier_prod_konfirmasi_del);
		} else if(detail_supplier_produk_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_supplier_prod_konfirmasi_del);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}

	//function for Delete of detail
	function detail_supplier_prod_konfirmasi_del(btn){
		if(btn=='yes'){
            var selections = detail_supplier_produk_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dsupplier_id==''){
                    detail_supplier_produkDataStore.remove(record);
                }else if((/^\d+$/.test(record.data.dsupplier_id))){
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_supplier_produkDataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_supplier&m=get_action', 
                        params: { task: "DETAIL_DELETE", dsupplier_id:  record.data.dsupplier_id }, 
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1: 
                                    Ext.MessageBox.hide();
                                    break;
                                default:
                                    Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
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
			}
		}
	}
	//eof



	/* Function for retrieve create Window Panel*/ 
	supplier_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items: [supplier_masterGroup,detail_supplier_produk_ListEditorGrid],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SUPPLIER'))){ ?>
			{
				text: 'Save and Close',
				handler: supplier_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					supplier_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	supplier_createWindow= new Ext.Window({
		id: 'supplier_createWindow',
		title: post2db+'Supplier',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_supplier_create',
		items: supplier_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function supplier_list_search(){
		// render according to a SQL date format.
		var supplier_id_search=null;
		var supplier_kategori_search=null;
		var supplier_nama_search=null;
		var supplier_alamat_search=null;
		var supplier_kota_search=null;
		var supplier_kodepos_search=null;
		var supplier_propinsi_search=null;
		var supplier_negara_search=null;
		var supplier_notelp_search=null;
		var supplier_notelp2_search=null;
		var supplier_nofax_search=null;
		var supplier_email_search=null;
		var supplier_website_search=null;
		var supplier_cp_search=null;
		var supplier_contact_cp_search=null;
		var supplier_aktif_search=null;
		var supplier_revised_search=null;

		if(supplier_idSearchField.getValue()!==null){supplier_id_search=supplier_idSearchField.getValue();}
		if(supplier_kategoriSearchField.getValue()!==null){supplier_kategori_search=supplier_kategoriSearchField.getValue();}
		if(supplier_namaSearchField.getValue()!==null){supplier_nama_search=supplier_namaSearchField.getValue();}
		if(supplier_alamatSearchField.getValue()!==null){supplier_alamat_search=supplier_alamatSearchField.getValue();}
		if(supplier_kotaSearchField.getValue()!==null){supplier_kota_search=supplier_kotaSearchField.getValue();}
		if(supplier_kodeposSearchField.getValue()!==null){supplier_kodepos_search=supplier_kodeposSearchField.getValue();}
		if(supplier_propinsiSearchField.getValue()!==null){supplier_propinsi_search=supplier_propinsiSearchField.getValue();}
		if(supplier_negaraSearchField.getValue()!==null){supplier_negara_search=supplier_negaraSearchField.getValue();}
		if(supplier_notelpSearchField.getValue()!==null){supplier_notelp_search=supplier_notelpSearchField.getValue();}
		if(supplier_notelp2SearchField.getValue()!==null){supplier_notelp2_search=supplier_notelp2SearchField.getValue();}
		if(supplier_nofaxSearchField.getValue()!==null){supplier_nofax_search=supplier_nofaxSearchField.getValue();}
		if(supplier_emailSearchField.getValue()!==null){supplier_email_search=supplier_emailSearchField.getValue();}
		if(supplier_websiteSearchField.getValue()!==null){supplier_website_search=supplier_websiteSearchField.getValue();}
		if(supplier_cpSearchField.getValue()!==null){supplier_cp_search=supplier_cpSearchField.getValue();}
		if(supplier_contact_cpSearchField.getValue()!==null){supplier_contact_cp_search=supplier_contact_cpSearchField.getValue();}
		if(supplier_aktifSearchField.getValue()!==null){supplier_aktif_search=supplier_aktifSearchField.getValue();}
		
		// change the store parameters
		supplier_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			supplier_id	:	supplier_id_search, 
			supplier_kategori	:	supplier_kategori_search, 
			supplier_nama	:	supplier_nama_search, 
			supplier_alamat	:	supplier_alamat_search, 
			supplier_kota	:	supplier_kota_search, 
			supplier_kodepos	:	supplier_kodepos_search, 
			supplier_propinsi	:	supplier_propinsi_search, 
			supplier_negara	:	supplier_negara_search, 
			supplier_notelp	:	supplier_notelp_search, 
			supplier_notelp2	:	supplier_notelp2_search, 
			supplier_nofax	:	supplier_nofax_search, 
			supplier_email	:	supplier_email_search, 
			supplier_website	:	supplier_website_search, 
			supplier_cp	:	supplier_cp_search, 
			supplier_contact_cp	:	supplier_contact_cp_search, 
			supplier_aktif	:	supplier_aktif_search
	};
		// Cause the datastore to do another query : 
		supplier_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function supplier_reset_search(){
		// reset the store parameters
		supplier_DataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		supplier_DataStore.reload({params: {start: 0, limit: pageS}});
		//supplier_searchWindow.close();
	};
	/* End of Fuction */
	
	function supplier_reset_SearchForm(){
		supplier_kategoriSearchField.reset();
		supplier_namaSearchField.reset();
		supplier_alamatSearchField.reset();
		supplier_kotaSearchField.reset();
		supplier_kodeposSearchField.reset();
		supplier_propinsiSearchField.reset();
		supplier_negaraSearchField.reset();
		supplier_notelpSearchField.reset();
		supplier_notelp2SearchField.reset();
		supplier_nofaxSearchField.reset();
		supplier_emailSearchField.reset();
		supplier_websiteSearchField.reset();
		supplier_cpSearchField.reset();
		supplier_contact_cpSearchField.reset();
		supplier_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  supplier_id Search Field */
	supplier_idSearchField= new Ext.form.NumberField({
		id: 'supplier_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  supplier_kategori Search Field */
	supplier_kategoriSearchField= new Ext.form.ComboBox({
		id: 'supplier_kategoriSearchField',
		fieldLabel: 'Kategori',
		store:cbo_supplier_kategoriDataStore,
		mode: 'remote',
		displayField: 'supplier_kategori_display',
		valueField: 'supplier_kategori_display',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  supplier_nama Search Field */
	supplier_namaSearchField= new Ext.form.TextField({
		id: 'supplier_namaSearchField',
		fieldLabel: 'Nama Supplier',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_alamat Search Field */
	supplier_alamatSearchField= new Ext.form.TextField({
		id: 'supplier_alamatSearchField',
		fieldLabel: 'Alamat',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_kota Search Field */
	supplier_kotaSearchField= new Ext.form.TextField({
		id: 'supplier_kotaSearchField',
		fieldLabel: 'Kota',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_kodepos Search Field */
	supplier_kodeposSearchField= new Ext.form.TextField({
		id: 'supplier_kodeposSearchField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		width: 60
	
	});
	/* Identify  supplier_propinsi Search Field */
	supplier_propinsiSearchField= new Ext.form.TextField({
		id: 'supplier_propinsiSearchField',
		fieldLabel: 'Propinsi',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_negara Search Field */
	supplier_negaraSearchField= new Ext.form.TextField({
		id: 'supplier_negaraSearchField',
		fieldLabel: 'Negara',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_notelp Search Field */
	supplier_notelpSearchField= new Ext.form.TextField({
		id: 'supplier_notelpSearchField',
		fieldLabel: 'No. Telepon',
		maxLength: 25,
		anchor: '95%'
	
	});
	/* Identify  supplier_notelp2 Search Field */
	supplier_notelp2SearchField= new Ext.form.TextField({
		id: 'supplier_notelp2SearchField',
		fieldLabel: 'No. Telepon Lain',
		maxLength: 25,
		anchor: '95%'
	
	});
	/* Identify  supplier_nofax Search Field */
	supplier_nofaxSearchField= new Ext.form.TextField({
		id: 'supplier_nofaxSearchField',
		fieldLabel: 'No. Fax',
		maxLength: 25,
		anchor: '50%'
	
	});
	/* Identify  supplier_email Search Field */
	supplier_emailSearchField= new Ext.form.TextField({
		id: 'supplier_emailSearchField',
		fieldLabel: 'Email',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  supplier_website Search Field */
	supplier_websiteSearchField= new Ext.form.TextField({
		id: 'supplier_websiteSearchField',
		fieldLabel: 'Website',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  supplier_cp Search Field */
	supplier_cpSearchField= new Ext.form.TextField({
		id: 'supplier_cpSearchField',
		fieldLabel: 'Contact Person',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  supplier_contact_cp Search Field */
	supplier_contact_cpSearchField= new Ext.form.TextField({
		id: 'supplier_contact_cpSearchField',
		fieldLabel: 'No. Telp Contact Person',
		maxLength: 25,
		anchor: '95%'
	
	});
	/* Identify  supplier_aktif Search Field */
	supplier_aktifSearchField= new Ext.form.ComboBox({
		id: 'supplier_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'supplier_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'supplier_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	
	/* Function for retrieve search Form Panel */
	supplier_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [supplier_kategoriSearchField, supplier_namaSearchField, supplier_alamatSearchField, supplier_kotaSearchField,
						supplier_kodeposSearchField, supplier_propinsiSearchField, supplier_negaraSearchField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [supplier_notelpSearchField, supplier_notelp2SearchField,supplier_nofaxSearchField, supplier_emailSearchField, 
						supplier_websiteSearchField, supplier_cpSearchField, supplier_contact_cpSearchField, supplier_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: supplier_list_search
			},{
				text: 'Close',
				handler: function(){
					supplier_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	supplier_searchWindow = new Ext.Window({
		title: 'Pencarian Supplier',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_supplier_search',
		items: supplier_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!supplier_searchWindow.isVisible()){
			supplier_reset_SearchForm();
			supplier_searchWindow.show();
		} else {
			supplier_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function supplier_print(){
		var searchquery = "";
		var supplier_kategori_print=null;
		var supplier_nama_print=null;
		var supplier_alamat_print=null;
		var supplier_kota_print=null;
		var supplier_kodepos_print=null;
		var supplier_propinsi_print=null;
		var supplier_negara_print=null;
		var supplier_notelp_print=null;
		var supplier_notelp2_print=null;
		var supplier_nofax_print=null;
		var supplier_email_print=null;
		var supplier_website_print=null;
		var supplier_cp_print=null;
		var supplier_contact_cp_print=null;
		var supplier_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(supplier_DataStore.baseParams.query!==null){searchquery = supplier_DataStore.baseParams.query;}
		if(supplier_DataStore.baseParams.supplier_kategori!==null){supplier_kategori_print = supplier_DataStore.baseParams.supplier_kategori;}
		if(supplier_DataStore.baseParams.supplier_nama!==null){supplier_nama_print = supplier_DataStore.baseParams.supplier_nama;}
		if(supplier_DataStore.baseParams.supplier_alamat!==null){supplier_alamat_print = supplier_DataStore.baseParams.supplier_alamat;}
		if(supplier_DataStore.baseParams.supplier_kota!==null){supplier_kota_print = supplier_DataStore.baseParams.supplier_kota;}
		if(supplier_DataStore.baseParams.supplier_kodepos!==null){supplier_kodepos_print = supplier_DataStore.baseParams.supplier_kodepos;}
		if(supplier_DataStore.baseParams.supplier_propinsi!==null){supplier_propinsi_print = supplier_DataStore.baseParams.supplier_propinsi;}
		if(supplier_DataStore.baseParams.supplier_negara!==null){supplier_negara_print = supplier_DataStore.baseParams.supplier_negara;}
		if(supplier_DataStore.baseParams.supplier_notelp!==null){supplier_notelp_print = supplier_DataStore.baseParams.supplier_notelp;}
		if(supplier_DataStore.baseParams.supplier_notelp2!==null){supplier_notelp2_print = supplier_DataStore.baseParams.supplier_notelp2;}
		if(supplier_DataStore.baseParams.supplier_nofax!==null){supplier_nofax_print = supplier_DataStore.baseParams.supplier_nofax;}
		if(supplier_DataStore.baseParams.supplier_email!==null){supplier_email_print = supplier_DataStore.baseParams.supplier_email;}
		if(supplier_DataStore.baseParams.supplier_website!==null){supplier_website_print = supplier_DataStore.baseParams.supplier_website;}
		if(supplier_DataStore.baseParams.supplier_cp!==null){supplier_cp_print = supplier_DataStore.baseParams.supplier_cp;}
		if(supplier_DataStore.baseParams.supplier_contact_cp!==null){supplier_contact_cp_print = supplier_DataStore.baseParams.supplier_contact_cp;}
		if(supplier_DataStore.baseParams.supplier_aktif!==null){supplier_aktif_print = supplier_DataStore.baseParams.supplier_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_supplier&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			supplier_kategori : supplier_kategori_print,
			supplier_nama : supplier_nama_print,
			supplier_alamat : supplier_alamat_print,
			supplier_kota : supplier_kota_print,
			supplier_kodepos : supplier_kodepos_print,
			supplier_propinsi : supplier_propinsi_print,
			supplier_negara : supplier_negara_print,
			supplier_notelp : supplier_notelp_print,
			supplier_notelp2 : supplier_notelp2_print,
			supplier_nofax : supplier_nofax_print,
			supplier_email : supplier_email_print,
			supplier_website : supplier_website_print,
			supplier_cp : supplier_cp_print,
			supplier_contact_cp : supplier_contact_cp_print,
			supplier_aktif : supplier_aktif_print,
		  	currentlisting: supplier_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./supplierlist.html','supplierlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function supplier_export_excel(){
		var searchquery = "";
		var supplier_kategori_2excel=null;
		var supplier_nama_2excel=null;
		var supplier_alamat_2excel=null;
		var supplier_kota_2excel=null;
		var supplier_kodepos_2excel=null;
		var supplier_propinsi_2excel=null;
		var supplier_negara_2excel=null;
		var supplier_notelp_2excel=null;
		var supplier_notelp2_2excel=null;
		var supplier_nofax_2excel=null;
		var supplier_email_2excel=null;
		var supplier_website_2excel=null;
		var supplier_cp_2excel=null;
		var supplier_contact_cp_2excel=null;
		var supplier_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(supplier_DataStore.baseParams.query!==null){searchquery = supplier_DataStore.baseParams.query;}
		if(supplier_DataStore.baseParams.supplier_kategori!==null){supplier_kategori_2excel = supplier_DataStore.baseParams.supplier_kategori;}
		if(supplier_DataStore.baseParams.supplier_nama!==null){supplier_nama_2excel = supplier_DataStore.baseParams.supplier_nama;}
		if(supplier_DataStore.baseParams.supplier_alamat!==null){supplier_alamat_2excel = supplier_DataStore.baseParams.supplier_alamat;}
		if(supplier_DataStore.baseParams.supplier_kota!==null){supplier_kota_2excel = supplier_DataStore.baseParams.supplier_kota;}
		if(supplier_DataStore.baseParams.supplier_kodepos!==null){supplier_kodepos_2excel = supplier_DataStore.baseParams.supplier_kodepos;}
		if(supplier_DataStore.baseParams.supplier_propinsi!==null){supplier_propinsi_2excel = supplier_DataStore.baseParams.supplier_propinsi;}
		if(supplier_DataStore.baseParams.supplier_negara!==null){supplier_negara_2excel = supplier_DataStore.baseParams.supplier_negara;}
		if(supplier_DataStore.baseParams.supplier_notelp!==null){supplier_notelp_2excel = supplier_DataStore.baseParams.supplier_notelp;}
		if(supplier_DataStore.baseParams.supplier_notelp2!==null){supplier_notelp2_2excel = supplier_DataStore.baseParams.supplier_notelp2;}
		if(supplier_DataStore.baseParams.supplier_nofax!==null){supplier_nofax_2excel = supplier_DataStore.baseParams.supplier_nofax;}
		if(supplier_DataStore.baseParams.supplier_email!==null){supplier_email_2excel = supplier_DataStore.baseParams.supplier_email;}
		if(supplier_DataStore.baseParams.supplier_website!==null){supplier_website_2excel = supplier_DataStore.baseParams.supplier_website;}
		if(supplier_DataStore.baseParams.supplier_cp!==null){supplier_cp_2excel = supplier_DataStore.baseParams.supplier_cp;}
		if(supplier_DataStore.baseParams.supplier_contact_cp!==null){supplier_contact_cp_2excel = supplier_DataStore.baseParams.supplier_contact_cp;}
		if(supplier_DataStore.baseParams.supplier_aktif!==null){supplier_aktif_2excel = supplier_DataStore.baseParams.supplier_aktif;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_supplier&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			supplier_kategori : supplier_kategori_2excel,
			supplier_nama : supplier_nama_2excel,
			supplier_alamat : supplier_alamat_2excel,
			supplier_kota : supplier_kota_2excel,
			supplier_kodepos : supplier_kodepos_2excel,
			supplier_propinsi : supplier_propinsi_2excel,
			supplier_negara : supplier_negara_2excel,
			supplier_notelp : supplier_notelp_2excel,
			supplier_notelp2 : supplier_notelp2_2excel,
			supplier_nofax : supplier_nofax_2excel,
			supplier_email : supplier_email_2excel,
			supplier_website : supplier_website_2excel,
			supplier_cp : supplier_cp_2excel,
			supplier_contact_cp : supplier_contact_cp_2excel,
			supplier_aktif : supplier_aktif_2excel,
		  	currentlisting: supplier_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_supplier"></div>
        <div id="fp_detail_supplier_produk"></div>
		<div id="elwindow_supplier_create"></div>
        <div id="elwindow_supplier_search"></div>
    </div>
</div>
</body>