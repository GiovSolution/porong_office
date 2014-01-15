<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: kasbank View
	+ Description	: For record view
	+ Filename 		: v_kasbank.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:45:40

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
var kasbank_keluar_DataStore;
var kasbank_keluar_ColumnModel;
var kasbankKeluarListEditorGrid;
var kasbank_keluar_saveForm;
var kasbank_keluar_saveWindow;
var kasbank_keluar_searchForm;
var kasbank_keluar_searchWindow;
var kasbank_keluar_SelectedRow;
var kasbank_keluar_ContextMenu;
//for detail data
var kasbank_keluar_detail_DataStore;
var kasbank_keluar_detailListEditorGrid;
var kasbank_keluar_detail_ColumnModel;
var kasbank_keluar_detail_proxy;
var kasbank_keluar_detail_writer;
var kasbank_keluar_detail_reader;
var editor_kasbank_keluar_detail;

//declare konstant
var post2db = '';
var msg = '';
var pageS=16;
var today=new Date().format('Y-m-d');
var thismonth=new Date().format('Y-m');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->add_date(date('Y-m-d'),-90,'day'); ?>";
var MAX_CREATE_DATE="<?php echo date('Y-m-d'); ?>";
var MAX_UNPOSTING="<?php echo $this->m_public_function->add_date(date('Y-m-d'),-90,'day') ?>";
/* declare variable here for Field*/
var kasbank_keluar_idField;
var kasbank_keluar_tanggalField;
var kasbank_keluar_nobuktiField;
var kasbank_keluar_akunField;
var kasbank_keluar_terimauntukField;
var kasbank_keluar_jenisField;
var kasbank_keluar_norefField;
var kasbank_keluar_keteranganField;
var kasbank_keluar_authorField;
var kasbank_keluar_postField;
var kasbank_keluar_date_postField;
var kasbank_keluar_idSearchField;
var kasbank_keluar_tanggalSearchField;
var kasbank_keluar_nobuktiSearchField;
var kasbank_keluar_akunSearchField;
var kasbank_keluar_terimauntukSearchField;
var kasbank_keluar_jenisSearchField;
var kasbank_keluar_norefSearchField;
var kasbank_keluar_keteranganSearchField;
var kasbank_keluar_authorSearchField;
var kasbank_keluar_postSearchField;
var kasbank_keluar_date_postSearchField;
var total_kasbank_keluar_debet;
var total_kasbank_keluar_kredit;
var jenis_kasbank = "keluar";
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();
  	/* Function for add and edit data form, open window form */
	function kasbank_keluar_save(opsi){

		if(is_kasbank_keluar_form_valid()){

			if(kasbank_keluar_detail_DataStore.getCount()<1){

				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Maaf, data transaksi tidak boleh kosong.',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});

			}else{

				var kasbank_keluar_id_field_pk=null;
				var kasbank_keluar_tanggal_field_date="";
				var kasbank_keluar_nobukti_field=null;
				var kasbank_keluar_akun_field=null;
				var kasbank_keluar_terimauntuk_field=null;
				var kasbank_keluar_jenis_field=null;
				var kasbank_keluar_noref_field=null;
				var kasbank_keluar_keterangan_field=null;
				var kasbank_keluar_post_field=null;
				var kasbank_keluar_date_post_field_date="";
				var dkasbank_keluar_id = [];
				var dkasbank_keluar_akun = [];
				var dkasbank_keluar_detail = [];
				var dkasbank_keluar_debet = [];
				var dkasbank_keluar_kredit = [];

				kasbank_keluar_id_field_pk=get_pk_id();
				if(kasbank_keluar_tanggalField.getValue()!== ""){kasbank_keluar_tanggal_field_date = kasbank_keluar_tanggalField.getValue().format('Y-m-d');}
				if(kasbank_keluar_nobuktiField.getValue()!== null){kasbank_keluar_nobukti_field = kasbank_keluar_nobuktiField.getValue();}
				if(kasbank_keluar_akunField.getValue()!== null){kasbank_keluar_akun_field = kasbank_keluar_akunField.getValue();}
				if(kasbank_keluar_terimauntukField.getValue()!== null){kasbank_keluar_terimauntuk_field = kasbank_keluar_terimauntukField.getValue();}
				if(kasbank_keluar_jenisField.getValue()!== null){kasbank_keluar_jenis_field = kasbank_keluar_jenisField.getValue();}
				if(kasbank_keluar_norefField.getValue()!== null){kasbank_keluar_noref_field = kasbank_keluar_norefField.getValue();}
				if(kasbank_keluar_keteranganField.getValue()!== null){kasbank_keluar_keterangan_field = kasbank_keluar_keteranganField.getValue();}



				var dcount = kasbank_keluar_detail_DataStore.getCount() - 1;

				if(kasbank_keluar_detail_DataStore.getCount()>0){
					for(i=0; i<kasbank_keluar_detail_DataStore.getCount();i++){
						if((/^\d+$/.test(kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_akun))
						   && kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_akun!==undefined
						   && kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_akun!==''
						   && kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_akun!==0
						   && kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_debet!==0
						   && kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_debet>0){

							dkasbank_keluar_id.push(kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_id);
							dkasbank_keluar_akun.push(kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_akun);
							dkasbank_keluar_detail.push(kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_detail);
							dkasbank_keluar_debet.push(kasbank_keluar_detail_DataStore.getAt(i).data.dkasbank_keluar_debet);
							dkasbank_keluar_kredit.push(0);
						}
					}
				}

				var encoded_array_dkasbank_keluar_id = Ext.encode(dkasbank_keluar_id);
				var encoded_array_dkasbank_keluar_akun = Ext.encode(dkasbank_keluar_akun);
				var encoded_array_dkasbank_keluar_detail = Ext.encode(dkasbank_keluar_detail);
				var encoded_array_dkasbank_keluar_debet = Ext.encode(dkasbank_keluar_debet);
				var encoded_array_dkasbank_keluar_kredit = Ext.encode(dkasbank_keluar_kredit);


				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kasbank_keluar&m=get_action',
					params: {
						kasbank_keluar_id			: kasbank_keluar_id_field_pk,
						kasbank_keluar_tanggal		: kasbank_keluar_tanggal_field_date,
						kasbank_keluar_nobukti		: kasbank_keluar_nobukti_field,
						kasbank_keluar_akun			: kasbank_keluar_akun_field,
						kasbank_keluar_terimauntuk	: kasbank_keluar_terimauntuk_field,
						kasbank_keluar_jenis		: kasbank_keluar_jenis_field,
						kasbank_keluar_noref		: kasbank_keluar_noref_field,
						kasbank_keluar_keterangan	: kasbank_keluar_keterangan_field,
						dkasbank_keluar_id			: encoded_array_dkasbank_keluar_id,
						dkasbank_keluar_akun		: encoded_array_dkasbank_keluar_akun,
						dkasbank_keluar_detail		: encoded_array_dkasbank_keluar_detail,
						dkasbank_keluar_debet		: encoded_array_dkasbank_keluar_debet,
						dkasbank_keluar_kredit		: encoded_array_dkasbank_keluar_kredit,
						task						: post2db
					},
					success: function(response){
						var result=response.responseText;
						/*var rsp_kode=result.substring(0,2);
						var rsp_msg=result.replace(rsp_kode+':','');
						if(rsp_kode=='OK'){
								kasbank_keluar_detail_insert(eval(rsp_msg),opsi);
						}else{
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: rsp_msg,
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
							}*/
						if(result!=='0'){
						    if(opsi=='print'){
								kasbank_keluar_cetak_faktur(result);
							}
							Ext.MessageBox.show({
								title: 'Success',
								msg: 'Data Kas/Bank Keluar sukses disimpan ',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.OK
							 });
							Ext.MessageBox.alert(post2db+' OK','Data Jurnal Kas/Bank berhasil disimpan.');
							kasbank_keluar_saveWindow.hide();
							kasbank_keluar_DataStore.reload();
						}else{
						   Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Data Kas/Bank Keluar gagal disimpan ',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
						    });
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
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, data yang di kirim tidak valid.',
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
			return kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_id');
		else
			return 0;
	}
	/* End of Function  */

	/* Reset form before loading */
	function kasbank_keluar_reset_form(){
		kasbank_keluar_tanggalField.reset();
		kasbank_keluar_tanggalField.setValue(today);
		kasbank_keluar_nobuktiField.reset();
		kasbank_keluar_nobuktiField.setValue('(auto)');
		kasbank_keluar_akunField.reset();
		kasbank_keluar_akunField.setValue(null);
		kasbank_keluar_terimauntukField.reset();
		kasbank_keluar_terimauntukField.setValue(null);
		kasbank_keluar_norefField.reset();
		kasbank_keluar_norefField.setValue(null);
		kasbank_keluar_keteranganField.reset();
		kasbank_keluar_keteranganField.setValue(null);
		kasbank_keluar_kodeakunField.reset();
		kasbank_keluar_kodeakunField.setValue(null);
		kasbank_keluar_jenisField.setValue('Kas');
		kasbank_keluar_jenisField.setDisabled(false);

		kasbank_keluar_detail_DataStore.setBaseParam('master_id',-1);
		kasbank_keluar_detail_DataStore.load();
		cbo_akun_dkasbank_keluarDataStore.setBaseParam('task','all');
		cbo_akun_dkasbank_keluarDataStore.load();
		total_kasbank_keluar_debet.setValue(0);
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		kasbank_keluar_btnSave.setVisible(true);
		//kasbank_keluar_btnSavePrint.setVisible(true);
		kasbank_keluar_btnSavePrint.setDisabled(false);
		<?php } ?>

	}
 	/* End of Function */

	/* setValue to EDIT */
	function kasbank_keluar_set_form(){

		kasbank_keluar_tanggalField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_tanggal'));
		kasbank_keluar_nobuktiField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_nobukti'));
		kasbank_keluar_akunField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_akun'));
		kasbank_keluar_kodeakunField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_kode'));
		kasbank_keluar_terimauntukField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_terimauntuk'));
		kasbank_keluar_norefField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_noref'));
		kasbank_keluar_keteranganField.setValue(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_keterangan'));

		if(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_nobukti').substring(0,1)=='K'){
			jenis_kb='Kas';
 		}else{
			jenis_kb='Bank';
 	 	}
		kasbank_keluar_jenisField.setValue(jenis_kb);
		kasbank_keluar_jenisField.setDisabled(true);

		cbo_akun_dkasbank_keluar_renderDataStore.setBaseParam('task','detail');
		cbo_akun_dkasbank_keluar_renderDataStore.setBaseParam('master_id',get_pk_id());
		cbo_akun_dkasbank_keluar_renderDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					kasbank_keluar_detail_DataStore.setBaseParam('master_id',get_pk_id());
					kasbank_keluar_detail_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								get_total_keluar_debet_kredit();
								Ext.MessageBox.hide();
							}
						}
					});

				}
			}
		});

		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		if(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_post')=='Y'){
			kasbank_keluar_btnSave.setVisible(false);
			//kasbank_keluar_btnSavePrint.setVisible(false);
			kasbank_keluar_btnSavePrint.setDisabled(true);
		}else{
			kasbank_keluar_btnSave.setVisible(true);
			//kasbank_keluar_btnSavePrint.setVisible(true);
			kasbank_keluar_btnSavePrint.setDisabled(false);
		}
		<?php } ?>

	}
	/* End setValue to EDIT*/

	/* Function for Check if the form is valid */
	function is_kasbank_keluar_form_valid(){
		return (kasbank_keluar_tanggalField.isValid() &&
				kasbank_keluar_akunField.isValid() );
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!kasbank_keluar_saveWindow.isVisible()){

			post2db='CREATE';
			msg='created';
			kasbank_keluar_reset_form();

			kasbank_keluar_saveWindow.show();
		} else {
			kasbank_keluar_saveWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function kasbank_keluar_confirm_delete(){
		if(kasbankKeluarListEditorGrid.selModel.getCount() == 1){
			if(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_post')=='Y'){
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Jurnal yang sudah terposting tidak dapat dihapus',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					width: 300,
					icon: Ext.MessageBox.WARNING
				});
			}else{
				Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_keluar_delete);
			}

		} else if(kasbankKeluarListEditorGrid.selModel.getCount() > 1){
			var selections = kasbankKeluarListEditorGrid.selModel.getSelections();
			var count_post=0;
			for(i = 0; i< kasbankKeluarListEditorGrid.selModel.getCount(); i++){
				if(selections[i].json.kasbank_post=='Y') count_post++;
			}
			if(count_post>0){
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Jurnal yang sudah terposting tidak dapat dihapus',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					width: 300,
					icon: Ext.MessageBox.WARNING
				});
			}else{
				Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_keluar_delete);
			}
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Pilih data untuk melakukan delete',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

  	function kasbank_keluar_confirm_reopen(){
		/* only one record is selected here */
		if(kasbankKeluarListEditorGrid.selModel.getCount() == 1) {
				var id="";
				var tanggal=null;

			if(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_post')!=='Y'){
				
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Data yang belum terposting tidak perlu dibuka',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});

			}else if(kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_post')=='Y' &&
			   kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_tanggal').format('Y-m-d')>=MAX_UNPOSTING){

				id = kasbankKeluarListEditorGrid.getSelectionModel().getSelected().get('kasbank_keluar_id');

				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kasbank_keluar&m=kasbank_reopen',
					params:{
						kasbank_id : id
					},
					success:function(response){
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Pembukaan posting Data Sukses',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.OK
						});
						kasbank_keluar_DataStore.reload();
					},
					failure:function(response){
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Pembukaan Posting gagal',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARING
						});
					}
				});

			}else{
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Data yang sudah terposting tidak dapat dibuka karena telah melewati batas pembukaan',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Pilih data untuk melakukan pembukaan posting',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

	function kasbank_keluar_print_only(){
		var kasbank_keluar_id_field_pk='';
		kasbank_keluar_id_field_pk=get_pk_id();
		if(kasbank_keluar_id_field_pk==''){
			Ext.MessageBox.show({
			msg: 'Kas Bank Keluar tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
				
			var kasbank_keluar_id = kasbank_keluar_id_field_pk;
			cetak_kasbank_keluar=1;
			//master_order_beli_create('print');
			kasbank_keluar_cetak_faktur(kasbank_keluar_id);
			kasbank_keluar_DataStore.reload()
			
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			
			kasbank_keluar_saveWindow.hide();
		}

		//jproduk_btn_cancel();
	}
	
	/* Function for Update Confirm */
	function kasbank_keluar_confirm_update(){
		/* only one record is selected here */
		if(kasbankKeluarListEditorGrid.selModel.getCount() == 1) {

			post2db='UPDATE';
			msg='updated';
			kasbank_keluar_set_form();
			kasbank_keluar_saveWindow.show();

			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Pilih data untuk melakukan update',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

  	/* Function for Delete Record */
	function kasbank_keluar_delete(btn){
		if(btn=='yes'){
			var selections = kasbankKeluarListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< kasbankKeluarListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kasbank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_kasbank_keluar&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							kasbank_keluar_DataStore.reload();
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
					   msg: 'Koneksi database gagal.',
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
	kasbank_keluar_DataStore = new Ext.data.Store({
		id: 'kasbank_keluar_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_keluar&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kasbank_keluar_id'
		},[
			{name: 'kasbank_keluar_id', type: 'int', mapping: 'kasbank_id'},
			{name: 'kasbank_keluar_tanggal', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_tanggal'},
			{name: 'kasbank_keluar_nobukti', type: 'string', mapping: 'kasbank_nobukti'},
			{name: 'kasbank_keluar_akun', type: 'string', mapping: 'akun_nama'},
			{name: 'kasbank_keluar_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'kasbank_keluar_terimauntuk', type: 'string', mapping: 'kasbank_terimauntuk'},
			{name: 'kasbank_keluar_jenis', type: 'string', mapping: 'kasbank_jenis'},
			{name: 'kasbank_keluar_noref', type: 'string', mapping: 'kasbank_noref'},
			{name: 'kasbank_keluar_kredit', type: 'float', mapping: 'kasbank_kredit'},
			{name: 'kasbank_keluar_debet', type: 'float', mapping: 'kasbank_debet'},
			{name: 'kasbank_keluar_keterangan', type: 'string', mapping: 'kasbank_keterangan'},
			{name: 'kasbank_keluar_author', type: 'string', mapping: 'kasbank_author'},
			{name: 'kasbank_keluar_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_create'},
			{name: 'kasbank_keluar_update', type: 'string', mapping: 'kasbank_update'},
			{name: 'kasbank_keluar_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_update'},
			{name: 'kasbank_keluar_post', type: 'string', mapping: 'kasbank_post'},
			{name: 'kasbank_keluar_date_post', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_post'},
			{name: 'kasbank_keluar_revised', type: 'int', mapping: 'kasbank_mrevised'}
		]),
		//sortInfo:{field: 'kasbank_keluar_tanggal', direction: "DESC"}
	});
	/* End of Function */



	/* Function for Retrieve DataStore */
	cbo_akun_DataStore= new Ext.data.Store({
		id: 'cbo_akun_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_keluar&m=get_akun_kasbank',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'akun_id', type: 'int', mapping: 'akun_id'},
			{name: 'akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'akun_jenis', type: 'string', mapping: 'akun_jenis'},
			{name: 'akun_parent', type: 'int', mapping: 'akun_parent'},
			{name: 'akun_level', type: 'int', mapping: 'akun_level'},
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'akun_id', direction: "DESC"}
	});
	/* End of Function */

	/* Function for Retrieve DataStore */
	cbo_akun_dkasbank_keluarDataStore = new Ext.data.Store({
		id: 'cbo_akun_dkasbank_keluarDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_keluar&m=get_detail_akun',
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'akun_id', type: 'int', mapping: 'akun_id'},
			{name: 'akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'akun_jenis', type: 'string', mapping: 'akun_jenis'},
			{name: 'akun_parent', type: 'int', mapping: 'akun_parent'},
			{name: 'akun_level', type: 'int', mapping: 'akun_level'},
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'akun_id', direction: "DESC"}
	});

	cbo_akun_dkasbank_keluar_renderDataStore = new Ext.data.Store({
		id: 'cbo_akun_dkasbank_keluar_renderDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_keluar&m=get_detail_akun',
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'akun_id', type: 'int', mapping: 'akun_id'},
			{name: 'akun_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'akun_jenis', type: 'string', mapping: 'akun_jenis'},
			{name: 'akun_parent', type: 'int', mapping: 'akun_parent'},
			{name: 'akun_level', type: 'int', mapping: 'akun_level'},
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'akun_id', direction: "DESC"}
	});
	/* End of Function */

  	/* Function for Identify of Window Column Model */
	kasbank_keluar_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Tanggal',
			dataIndex: 'kasbank_keluar_tanggal',
			width: 130,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			readOnly: true
		},
		{
			header: 'No Jurnal',
			dataIndex: 'kasbank_keluar_nobukti',
			width: 150,
			sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
				var kasbank_no="";
				if(record.data.kasbank_keluar_post=='Y')
					kasbank_no='<b><font color=RED>'+record.data.kasbank_keluar_nobukti+'</font></b>';
				else
					kasbank_no='<b>'+record.data.kasbank_keluar_nobukti+'</b>';

                return '<span>' + kasbank_no+ '</span>';
            }
		},
		{
			header: 'Nama Akun',
			dataIndex: 'kasbank_keluar_akun',
			width: 350,
			sortable: true,
			readOnly: true
		},
		{	header: 'Kode',
			dataIndex: 'kasbank_keluar_kode',
			width: 100,
			readOnly: true
		},
		{
			header: 'Terima Dari',
			dataIndex: 'kasbank_keluar_terimauntuk',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden : true
		},
		{
			 header: 'Keterangan',
			 dataIndex: 'kasbank_keluar_keterangan',
			 width: 250,
			 sortable: true,
			 readOnly: true
		 },
		 {
			 header: 'Kredit (Rp)',
			 dataIndex: 'kasbank_keluar_kredit',
			 width: 150,
			 align: 'right',
			 renderer: Ext.util.Format.numberRenderer('0,000'),
			 sortable: true,
			 readOnly: true
		 },
		{
			header: 'Create on',
			dataIndex: 'kasbank_keluar_date_create',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'kasbank_keluar_update',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'kasbank_keluar_date_update',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Posted',
			dataIndex: 'kasbank_keluar_post',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Posted on',
			dataIndex: 'kasbank_keluar_date_post',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'kasbank_keluar_revised',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}	]);

	kasbank_keluar_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	kasbankKeluarListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kasbankKeluarListEditorGrid',
		el: 'fp_kasbank_keluar',
		title: 'Kas/Bank Keluar',
		autoHeight: true,
		store: kasbank_keluar_DataStore, // DataStore
		cm: kasbank_keluar_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: kasbank_keluar_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kasbank_keluar_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kasbank_keluar_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: kasbank_keluar_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: kasbank_keluar_reset_search,
			iconCls:'icon-refresh'
		}<?php if(ereg('D',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		,'-',
		{
			text: 'Buka Posting',
			tooltip: 'Buka Posting',
			iconCls:'icon-reopen',
			handler: kasbank_keluar_confirm_reopen   // Confirm before updating
		}
		<?php } ?>
		,'-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kasbank_keluar_print
		}
		]
	});
	kasbankKeluarListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	kasbank_keluar_ContextMenu = new Ext.menu.Menu({
		id: 'kasbank_keluar_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kasbank_keluar_editContextMenu
		},
		<?php } ?>
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kasbank_keluar_confirm_delete
		},
		<?php } ?>
		<?php if(ereg('R',$this->m_security->get_access_group_by_kode('MENU_POSTING'))){ ?>
		'-',
		{
			text: 'Buka Posting',
			tooltip: 'Buka Posting',
			iconCls:'icon-reopen',
			handler: kasbank_keluar_confirm_reopen   // Confirm before updating
		}
		<?php } ?>
		,'-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kasbank_keluar_print
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onkasbank_keluar_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		kasbank_keluar_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		kasbank_keluar_SelectedRow=rowIndex;
		kasbank_keluar_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function kasbank_keluar_editContextMenu(){
		kasbank_keluar_confirm_update();
  	}
	/* End of Function */

	kasbankKeluarListEditorGrid.addListener('rowcontextmenu', onkasbank_keluar_ListEditGridContextMenu);
	kasbank_keluar_DataStore.load({params: {task: "LIST", start: 0, limit: pageS}});	// load DataStore

	/* Identify  kasbank_keluar_tanggal Field */
	kasbank_keluar_tanggalField= new Ext.form.DateField({
		id: 'kasbank_keluar_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		anchor: '95%',
		allowBlank: false,
		minValue: MIN_CREATE_DATE,
		maxValue: MAX_CREATE_DATE
	});

	/* Identify  kasbank_keluar_nobukti Field */
	kasbank_keluar_nobuktiField= new Ext.form.TextField({
		id: 'kasbank_keluar_nobuktiField',
		fieldLabel: 'No Jurnal',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%',
		value: '(auto)',
		readOnly: true
	});

	var akun_kasbank_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>[{akun_kode}] {akun_nama}</b></span>',
        '</div></tpl>'
    );

	/* Identify  kasbank_keluar_akun Field */
	kasbank_keluar_akunField= new Ext.form.ComboBox({
		id: 'kasbank_keluar_akunField',
		fieldLabel: 'Akun',
		store: cbo_akun_DataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		anchor: '95%',
		hideTrigger: false,
		allowBlank: false

	});

	kasbank_keluar_kodeakunField= new Ext.form.TextField({
		id: 'kasbank_keluar_kodeakunField',
		fieldLabel: 'Kode Akun',
		maxLength: 250,
		anchor: '50%',
		readOnly: true
	});


	/* Identify  kasbank_keluar_terimauntuk Field */
	kasbank_keluar_terimauntukField= new Ext.form.TextField({
		id: 'kasbank_keluar_terimauntukField',
		fieldLabel: 'Untuk',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kasbank_keluar_jenis Field */
	kasbank_keluar_jenisField= new Ext.form.ComboBox({
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['jenis_value', 'jenis_display'],
			data: [	['Kas','Kas'],
					['Bank','Bank']
				]
			}),
		mode: 'local',
		anchor: '95%',
		displayField: 'jenis_display',
		valueField: 'jenis_value',
		triggerAction: 'all'
	});
	/* Identify  kasbank_keluar_noref Field */
	kasbank_keluar_norefField= new Ext.form.TextField({
		id: 'kasbank_keluar_norefField',
		fieldLabel: 'No Referensi',
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  kasbank_keluar_keterangan Field */
	kasbank_keluar_keteranganField= new Ext.form.TextArea({
		id: 'kasbank_keluar_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});

  	/*Fieldset Master*/
	kasbank_keluar_masterGroup = new Ext.form.FieldSet({
		title: 'Master ',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.35,
				layout: 'form',
				border:false,
				items: [kasbank_keluar_tanggalField, kasbank_keluar_nobuktiField,  kasbank_keluar_jenisField,  kasbank_keluar_norefField]
			},{
				columnWidth:0.65,
				layout: 'form',
				border:false,
				items: [kasbank_keluar_akunField, kasbank_keluar_kodeakunField, kasbank_keluar_terimauntukField, kasbank_keluar_keteranganField]
			}
			]

	});


	/*Detail Declaration */
	// Function for json reader of detail
	var kasbank_keluar_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dkasbank_keluar_id', type: 'int', mapping: 'dkasbank_id'},
			{name: 'dkasbank_keluar_master', type: 'int', mapping: 'dkasbank_master'},
			{name: 'dkasbank_keluar_akun', type: 'int', mapping: 'dkasbank_akun'},
			{name: 'dkasbank_keluar_detail', type: 'string', mapping: 'dkasbank_detail'},
			{name: 'dkasbank_keluar_debet', type: 'float', mapping: 'dkasbank_debet'},
			{name: 'dkasbank_keluar_kredit', type: 'float', mapping: 'dkasbank_kredit'}
	]);
	//eof

	//function for json writer of detail
	var kasbank_keluar_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	kasbank_keluar_detail_DataStore = new Ext.data.Store({
		id: 'kasbank_keluar_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_keluar&m=detail_kasbank_keluar_detail_list',
			method: 'POST'
		}),
		baseParams:{master_id: get_pk_id()},
		reader: kasbank_keluar_detail_reader,
		sortInfo:{field: 'dkasbank_keluar_id', direction: "ASC"}
	});
	/* End of Function */

	//function for editor of detail
	var editor_kasbank_keluar_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	//function combo render
	Ext.util.Format.comboRenderer = function(combo){
		//cbo_akun_DataStore.load();
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}

	// variable combo akun
	var combo_akun_kasbank_detail_keluar_render=new Ext.form.ComboBox({
		store: cbo_akun_dkasbank_keluar_renderDataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: true,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		anchor: '80%',
		hideTrigger: true
	});

	var combo_akun_kasbank_detail_keluar=new Ext.form.ComboBox({
		store: cbo_akun_dkasbank_keluarDataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false, //true,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender: false,
		listClass: 'x-combo-list-small',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		anchor: '80%',
		hideTrigger: false
	});
	//eof

	var combo_akun_kasbank_detail_keluar_kode=new Ext.form.ComboBox({
		store: cbo_akun_dkasbank_keluar_renderDataStore,
		mode: 'remote',
		displayField: 'akun_kode',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: true,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender: false,
		listClass: 'x-combo-list-small',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		anchor: '80%',
		allowBlank: false,
		hideTrigger: false
	});

	//declaration of detail coloumn model
	kasbank_keluar_detail_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: 'ID',
			dataIndex: 'dkasbank_keluar_id',
			width: 350,
			sortable: false,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Nama Akun',
			dataIndex: 'dkasbank_keluar_akun',
			width: 350,
			sortable: false,
			editor: combo_akun_kasbank_detail_keluar,
			renderer: Ext.util.Format.comboRenderer(combo_akun_kasbank_detail_keluar_render)
		},
		{
			header: 'Kode',
			dataIndex: 'dkasbank_keluar_akun',
			width: 100,
			readOnly: true,
			renderer: Ext.util.Format.comboRenderer(combo_akun_kasbank_detail_keluar_kode)
		},

		{
			header: 'Keterangan',
			dataIndex: 'dkasbank_keluar_detail',
			width: 250,
			editor: new Ext.form.TextField({
				maxLength: 250
			})
		},
		{
			header: 'Debet (Rp)',
			dataIndex: 'dkasbank_keluar_debet',
			width: 150,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			align: 'right',
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})
		} ]
	);
	kasbank_keluar_detail_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	kasbank_keluar_detailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kasbank_keluar_detailListEditorGrid',
		el: 'fp_kasbank_keluar_detail',
		title: 'Detail',
		height: 250,
		width: 690,
		autoScroll: true,
		store: kasbank_keluar_detail_DataStore, // DataStore
		colModel: kasbank_keluar_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_kasbank_keluar_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: kasbank_keluar_detail_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: kasbank_keluar_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: kasbank_keluar_detail_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof


	//function of detail add
	function kasbank_keluar_detail_add(){
		var edit_kasbank_keluar_detail= new kasbank_keluar_detailListEditorGrid.store.recordType({
			dkasbank_keluar_id	:'',
			dkasbank_keluar_akun	:'',
			dkasbank_keluar_detail	:'',
			dkasbank_keluar_debet	: 0,
			dkasbank_keluar_kredit	: ''
		});
		editor_kasbank_keluar_detail.stopEditing();
		kasbank_keluar_detail_DataStore.insert(0, edit_kasbank_keluar_detail);
		kasbank_keluar_detailListEditorGrid.getView().refresh();
		kasbank_keluar_detailListEditorGrid.getSelectionModel().selectRow(0);
		editor_kasbank_keluar_detail.startEditing(0);
	}

	//function for refresh detail
	function refresh_kasbank_keluar_detail(){

		kasbank_keluar_detail_DataStore.commitChanges();
		kasbank_keluar_detailListEditorGrid.getView().refresh();
	}
	//eof

	function kasbank_keluar_cetak_faktur(pkid){

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kasbank_keluar&m=print_faktur',
		params: {
			faktur	: pkid
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/kasbank_keluar_faktur.html','kasbank_faktur','height=400,width=720,resizable=1,scrollbars=1, menubar=1');
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

	//function for insert detail
	function kasbank_keluar_detail_insert(pkid,opsi){
		//
	}
	//eof

	/* Function for Delete Confirm of detail */
	function kasbank_keluar_detail_confirm_delete(){
		// only one record is selected here
		if(kasbank_keluar_detailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_keluar_detail_delete);
		} else if(kasbank_keluar_detailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_keluar_detail_delete);
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
	//eof

	//function for Delete of detail
	function kasbank_keluar_detail_delete(btn){
		if(btn=='yes'){
			var s = kasbank_keluar_detailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				kasbank_keluar_detail_DataStore.remove(r);
			}
		}
	}
	//eof

	//event on update of detail data store
	//kasbank_keluar_detail_DataStore.on('update', refresh_kasbank_keluar_detail);

	/* Identify  total_kasbank_keluar_debet Field */
	total_kasbank_keluar_debet= new Ext.form.TextField({
		id: 'total_kasbank_keluar_debet',
		fieldLabel: 'Total Debet',
		readOnly: true,
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/
	});

	total_kasbank_keluar_kredit= new Ext.form.TextField({
		id: 'total_kasbank_keluar_kredit',
		fieldLabel: 'Total Kredit',
		readOnly: true,
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/
	});

  	/*Fieldset Total Jumlah*/
	jumlah_total_kasbank_keluar = new Ext.form.FieldSet({
		title: 'Total Jumlah ',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [total_kasbank_keluar_debet ]
			}
			]

	});

	kasbank_keluar_btnSave=new Ext.Button({
		text: 'Save',
		visible: true,
		handler: function() { kasbank_keluar_save('save'); }
	});

	kasbank_keluar_btnSavePrint=new Ext.Button({
		text: 'Save and Print',
		visible: true,
		handler: function() { kasbank_keluar_save('print'); }
	});

	/* Function for retrieve create Window Panel*/
	kasbank_keluar_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		items: [kasbank_keluar_masterGroup,kasbank_keluar_detailListEditorGrid,jumlah_total_kasbank_keluar],
		buttons: [
			{
				text: 'Print Only',
				handler: kasbank_keluar_print_only
			},
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KASBANKKELUAR'))){ ?>
			kasbank_keluar_btnSavePrint,
			kasbank_keluar_btnSave
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					kasbank_keluar_saveWindow.hide();
				}
			}
		]
	});


	/* Function for retrieve create Window Form */
	kasbank_keluar_saveWindow= new Ext.Window({
		id: 'kasbank_keluar_saveWindow',
		title: post2db+' Kas/Bank Keluar',
		closable:true,
		closeAction: 'hide',
		width: 720,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kasbank_keluar_save',
		items: kasbank_keluar_saveForm
	});
	/* End Window */

	/* Function for action list search */
	function kasbank_keluar_list_search(){
		// render according to a SQL date format.
		var kasbank_keluar_tgl_awal_search_date="";
		var kasbank_keluar_tgl_akhir_search_date="";
		var kasbank_keluar_nobukti_search=null;
		var kasbank_keluar_akun_search=null;
		var kasbank_keluar_terimauntuk_search=null;
		var kasbank_keluar_jenis_search=null;
		var kasbank_keluar_noref_search=null;
		var kasbank_keluar_keterangan_search=null;
		var kasbank_keluar_post_search=null;
		var kasbank_keluar_date_post_search_date="";

		if(kasbank_keluar_tanggal_awalSearchField.getValue()!==""){kasbank_keluar_tgl_awal_search_date=kasbank_keluar_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(kasbank_keluar_tanggal_akhirSearchField.getValue()!==""){kasbank_keluar_tgl_akhir_search_date=kasbank_keluar_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(kasbank_keluar_nobuktiSearchField.getValue()!==null){kasbank_keluar_nobukti_search=kasbank_keluar_nobuktiSearchField.getValue();}
		if(kasbank_keluar_akunSearchField.getValue()!==null){kasbank_keluar_akun_search=kasbank_keluar_akunSearchField.getValue();}
		if(kasbank_keluar_terimauntukSearchField.getValue()!==null){kasbank_keluar_terimauntuk_search=kasbank_keluar_terimauntukSearchField.getValue();}
		//if(kasbank_keluar_jenisSearchField.getValue()!==null){kasbank_keluar_jenis_search=kasbank_keluar_jenisSearchField.getValue();}
		if(kasbank_keluar_norefSearchField.getValue()!==null){kasbank_keluar_noref_search=kasbank_keluar_norefSearchField.getValue();}
		if(kasbank_keluar_keteranganSearchField.getValue()!==null){kasbank_keluar_keterangan_search=kasbank_keluar_keteranganSearchField.getValue();}
		if(kasbank_keluar_postSearchField.getValue()!==null){kasbank_keluar_post_search=kasbank_keluar_postSearchField.getValue();}
		if(kasbank_keluar_date_postSearchField.getValue()!==""){kasbank_keluar_date_post_search_date=kasbank_keluar_date_postSearchField.getValue().format('Y-m-d');}
		// change the store parameters
		kasbank_keluar_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kasbank_keluar_tgl_awal		:	kasbank_keluar_tgl_awal_search_date,
			kasbank_keluar_tgl_akhir	:	kasbank_keluar_tgl_akhir_search_date,
			kasbank_keluar_nobukti		:	kasbank_keluar_nobukti_search,
			kasbank_keluar_akun			:	kasbank_keluar_akun_search,
			kasbank_keluar_terimauntuk	:	kasbank_keluar_terimauntuk_search,
			//kasbank_keluar_jenis		:	kasbank_keluar_jenis_search,
			kasbank_keluar_noref		:	kasbank_keluar_noref_search,
			kasbank_keluar_keterangan	:	kasbank_keluar_keterangan_search,
			kasbank_keluar_post			:	kasbank_keluar_post_search,
			kasbank_keluar_date_post	:	kasbank_keluar_date_post_search_date
		};
		// Cause the datastore to do another query :
		kasbank_keluar_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function kasbank_keluar_reset_search(){
		// reset the store parameters
		kasbank_keluar_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		kasbank_keluar_DataStore.reload({params: {start: 0, limit: pageS}});
		kasbank_keluar_searchWindow.close();
	};
	/* End of Fuction */


	/* Identify  kasbank_masuk_tanggal Search Field */
	kasbank_keluar_tanggal_awalSearchField= new Ext.form.DateField({
		id: 'kasbank_keluar_tanggal_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		anchor: '95%'

	});

	/* Identify  kasbank_masuk_tanggal Search Field */
	kasbank_keluar_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'kasbank_keluar_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		anchor: '95%'

	});

	/* Identify  kasbank_keluar_nobukti Search Field */
	kasbank_keluar_nobuktiSearchField= new Ext.form.TextField({
		id: 'kasbank_keluar_nobuktiSearchField',
		fieldLabel: 'No Bukti',
		maxLength: 50,
		anchor: '50%'

	});
	/* Identify  kasbank_keluar_akun Search Field */
	kasbank_keluar_akunSearchField= new Ext.form.ComboBox({
		id: 'kasbank_keluar_akunSearchField',
		fieldLabel: 'Akun',
		store: cbo_akun_DataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		anchor: '95%',
		hideTrigger: false

	});

	/* Identify  kasbank_keluar_terimauntuk Search Field */
	kasbank_keluar_terimauntukSearchField= new Ext.form.TextField({
		id: 'kasbank_keluar_terimauntukSearchField',
		fieldLabel: 'Untuk',
		maxLength: 250,
		anchor: '95%'

	});
	/* Identify  kasbank_keluar_jenis Search Field */
	kasbank_keluar_jenisSearchField= new Ext.form.ComboBox({
		id: 'kasbank_keluar_jenisSearchField',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['value', 'kasbank_keluar_jenis'],
			data:[['keluar','keluar'],['keluar','keluar']]
		}),
		mode: 'local',
		displayField: 'kasbank_keluar_jenis',
		valueField: 'value',
		anchor: '50%',
		triggerAction: 'all'

	});
	/* Identify  kasbank_keluar_noref Search Field */
	kasbank_keluar_norefSearchField= new Ext.form.TextField({
		id: 'kasbank_keluar_norefSearchField',
		fieldLabel: 'No Referensi',
		maxLength: 50,
		anchor: '50%'

	});
	/* Identify  kasbank_keluar_keterangan Search Field */
	kasbank_keluar_keteranganSearchField= new Ext.form.TextArea({
		id: 'kasbank_keluar_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'

	});
	/* Identify  kasbank_keluar_post Search Field */
	kasbank_keluar_postSearchField= new Ext.form.ComboBox({
		id: 'kasbank_keluar_postSearchField',
		fieldLabel: 'Post',
		store:new Ext.data.SimpleStore({
			fields:['value', 'kasbank_keluar_post'],
			data:[['T','T'],['Y','Y']]
		}),
		mode: 'local',
		displayField: 'kasbank_keluar_post',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'

	});
	/* Identify  kasbank_keluar_date_post Search Field */
	kasbank_keluar_date_postSearchField= new Ext.form.DateField({
		id: 'kasbank_keluar_date_postSearchField',
		fieldLabel: 'Date Post',
		format : 'Y-m-d'

	});

	/* Function for retrieve search Form Panel */
	kasbank_keluar_searchForm = new Ext.FormPanel({
		labelAlign:'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [{
					layout:'column',
					border:false,
					items:[
					{
						columnWidth:0.55,
						layout: 'form',
						border:false,
						defaultType: 'datefield',
						items: [
							kasbank_keluar_tanggal_awalSearchField
						]
					},
					{
						columnWidth:0.35,
						layout: 'form',
						border:false,
						labelWidth:20,
						defaultType: 'datefield',
						items: [
							kasbank_keluar_tanggal_akhirSearchField
						]
					}
			        ]
				}, kasbank_keluar_nobuktiSearchField, kasbank_keluar_akunSearchField,
				   kasbank_keluar_terimauntukSearchField, kasbank_keluar_norefSearchField, kasbank_keluar_keteranganSearchField ]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kasbank_keluar_list_search
			},{
				text: 'Close',
				handler: function(){
					kasbank_keluar_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	kasbank_keluar_searchWindow = new Ext.Window({
		title: 'Pencariam Kas/Bank Keluar',
		closable:true,
		closeAction: 'hide',
		width: 420,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kasbank_keluar_search',
		items: kasbank_keluar_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kasbank_keluar_searchWindow.isVisible()){
			kasbank_keluar_searchWindow.show();
		} else {
			kasbank_keluar_searchWindow.toFront();
		}
	}
  	/* End Function */

	function kasbank_keluar_print(){
		var searchquery = "";
		var kasbank_nobukti_print=null;
		var kasbank_tgl_awal_print_date="";
		var kasbank_tgl_akhir_print_date="";
		var kasbank_akun_print=null;
		var kasbank_keterangan_print=null;
		var kasbank_terimauntuk_print=null;
		var kasbank_post_print=null;
		var kasbank_noref=null;

		var win;

		if(kasbank_keluar_DataStore.baseParams.query!==null){searchquery = kasbank_keluar_DataStore.baseParams.query;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_nobukti!==null){kasbank_nobukti_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_nobukti;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_tgl_awal!==null){kasbank_tgl_awal_print_date = kasbank_keluar_DataStore.baseParams.kasbank_keluar_tgl_awal;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_tgl_akhir!==null){kasbank_tgl_akhir_print_date = kasbank_keluar_DataStore.baseParams.kasbank_keluar_tgl_akhir;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_akun!==null){kasbank_akun_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_akun;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_keterangan!==null){kasbank_keterangan_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_keterangan;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_terimauntuk!==null){kasbank_terimauntuk_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_terimauntuk;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_post!==null){kasbank_post_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_post;}
		if(kasbank_keluar_DataStore.baseParams.kasbank_keluar_noref!==null){kasbank_noref_print = kasbank_keluar_DataStore.baseParams.kasbank_keluar_noref;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kasbank_keluar&m=get_action',
		params: {
			task						: "PRINT",
		  	query						: searchquery,
			kasbank_keluar_nobukti 		: kasbank_nobukti_print,
		  	kasbank_keluar_tgl_awal 	: kasbank_tgl_awal_print_date,
			kasbank_keluar_tgl_akhir	: kasbank_tgl_akhir_print_date,
			kasbank_keluar_keterangan 	: kasbank_keterangan_print,
			kasbank_keluar_terimauntuk	: kasbank_terimauntuk_print,
			kasbank_keluar_post			: kasbank_post_print,
		  	currentlisting				: kasbank_keluar_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/kasbank_keluar_printlist.html','kasbank_keluar_printlist','height=600,width=780,resizable=1,scrollbars=1, menubar=1');
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

	function get_total_keluar_debet_kredit(){
		var jumlah_total_kasbank_keluar_debet=0;
		for(i=0;i<kasbank_keluar_detail_DataStore.getCount();i++){
			record_data=kasbank_keluar_detail_DataStore.getAt(i);
			jumlah_total_kasbank_keluar_debet+=record_data.data.dkasbank_keluar_debet;
			//jumlah_total_kasbank_keluar_kasbank_keluar_kredit+=record_data.data.dkasbank_keluar_kredit;
		}
		total_kasbank_keluar_debet.setValue(CurrencyFormatted(jumlah_total_kasbank_keluar_debet));
	}

	kasbank_keluar_detail_DataStore.on("update",function(){
		kasbank_keluar_detail_DataStore.commitChanges();

		var query_selected="";
		cbo_akun_dkasbank_keluarDataStore.lastQuery=null;
		for(i=0;i<kasbank_keluar_detail_DataStore.getCount();i++){
			detail_record=kasbank_keluar_detail_DataStore.getAt(i);
			query_selected=query_selected+detail_record.data.dkasbank_keluar_akun+",";
		}
		cbo_akun_dkasbank_keluar_renderDataStore.setBaseParam('task','selected');
		cbo_akun_dkasbank_keluar_renderDataStore.setBaseParam('master_id',get_pk_id());
		cbo_akun_dkasbank_keluar_renderDataStore.setBaseParam('selected_id',query_selected);
		cbo_akun_dkasbank_keluar_renderDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					kasbank_keluar_detailListEditorGrid.getView().refresh();
				}
			}
		});

		get_total_keluar_debet_kredit();

	});
	/*End of Function */

	combo_akun_kasbank_detail_keluar.on("focus",function(){
		cbo_akun_dkasbank_keluarDataStore.setBaseParam('task','all');
		cbo_akun_dkasbank_keluarDataStore.load({params:{start:0, limit: pageS}});
	});

	kasbank_keluar_akunField.on('select',function(){
		var j=cbo_akun_DataStore.findExact('akun_id',kasbank_keluar_akunField.getValue());
		if(j>-1){
			var record_akun=cbo_akun_DataStore.getAt(j);
			kasbank_keluar_kodeakunField.setValue(record_akun.data.akun_kode);
		}
	});

	/*End of Function */

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_kasbank_keluar"></div>
        <div id="fp_kasbank_keluar_detail"></div>
		<div id="elwindow_kasbank_keluar_save"></div>
        <div id="elwindow_kasbank_keluar_search"></div>
    </div>
</div>
</body>
</html>