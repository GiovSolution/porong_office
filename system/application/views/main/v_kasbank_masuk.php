<?php
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
</head>
<script>
/* declare function */
var kasbank_masuk_DataStore;
var kasbank_masuk_ColumnModel;
var kasbankMasukListEditorGrid;
var kasbank_masuk_saveForm;
var kasbank_masuk_saveWindow;
var kasbank_masuk_searchForm;
var kasbank_masuk_searchWindow;
var kasbank_masuk_SelectedRow;
var kasbank_masuk_ContextMenu;
//for detail data
var kasbank_masuk_detail_DataStore;
var kasbank_masuk_detailListEditorGrid;
var kasbank_masuk_detail_ColumnModel;
var kasbank_masuk_detail_proxy;
var kasbank_masuk_detail_writer;
var kasbank_masuk_detail_reader;
var editor_kasbank_masuk_detail;

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
var kasbank_masuk_idField;
var kasbank_masuk_tanggalField;
var kasbank_masuk_nobuktiField;
var kasbank_masuk_akunField;
var kasbank_masuk_terimauntukField;
var kasbank_masuk_jenisField;
var kasbank_masuk_norefField;
var kasbank_masuk_keteranganField;
var kasbank_masuk_authorField;
var kasbank_masuk_postField;
var kasbank_masuk_date_postField;
var kasbank_masuk_idSearchField;
var kasbank_masuk_tanggalSearchField;
var kasbank_masuk_nobuktiSearchField;
var kasbank_masuk_akunSearchField;
var kasbank_masuk_terimauntukSearchField;
var kasbank_masuk_jenisSearchField;
var kasbank_masuk_norefSearchField;
var kasbank_masuk_keteranganSearchField;
var kasbank_masuk_authorSearchField;
var kasbank_masuk_postSearchField;
var kasbank_masuk_date_postSearchField;
var total_kasbank_masuk_debet;
var total_kasbank_masuk_kredit;
var jenis_kasbank = "masuk";
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  	/* Function for add and edit data form, open window form */
	function kasbank_masuk_save(opsi){

		if(is_kasbank_masuk_form_valid()){

			if(kasbank_masuk_detail_DataStore.getCount()<1){

				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Maaf, data transaksi tidak boleh kosong.',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});

			}else{
				var kasbank_masuk_id_field_pk=null;
				var kasbank_masuk_tanggal_field_date="";
				var kasbank_masuk_nobukti_field=null;
				var kasbank_masuk_akun_field=null;
				var kasbank_masuk_terimauntuk_field=null;
				var kasbank_masuk_jenis_field=null;
				var kasbank_masuk_noref_field=null;
				var kasbank_masuk_keterangan_field=null;
				var kasbank_masuk_post_field=null;
				var kasbank_masuk_date_post_field_date="";

				kasbank_masuk_id_field_pk=get_pk_id();
				if(kasbank_masuk_tanggalField.getValue()!== ""){kasbank_masuk_tanggal_field_date = kasbank_masuk_tanggalField.getValue().format('Y-m-d');}
				if(kasbank_masuk_nobuktiField.getValue()!== null){kasbank_masuk_nobukti_field = kasbank_masuk_nobuktiField.getValue();}
				if(kasbank_masuk_akunField.getValue()!== null){kasbank_masuk_akun_field = kasbank_masuk_akunField.getValue();}
				if(kasbank_masuk_terimauntukField.getValue()!== null){kasbank_masuk_terimauntuk_field = kasbank_masuk_terimauntukField.getValue();}
				if(kasbank_masuk_jenisField.getValue()!== null){kasbank_masuk_jenis_field = kasbank_masuk_jenisField.getValue();}
				if(kasbank_masuk_norefField.getValue()!== null){kasbank_masuk_noref_field = kasbank_masuk_norefField.getValue();}
				if(kasbank_masuk_keteranganField.getValue()!== null){kasbank_masuk_keterangan_field = kasbank_masuk_keteranganField.getValue();}


				var dkasbank_masuk_id = [];
				var dkasbank_masuk_akun = [];
				var dkasbank_masuk_detail = [];
				var dkasbank_masuk_kredit = [];
				var dkasbank_masuk_debet = [];

				var dcount = kasbank_masuk_detail_DataStore.getCount() - 1;

				if(kasbank_masuk_detail_DataStore.getCount()>0){
					for(i=0; i<kasbank_masuk_detail_DataStore.getCount();i++){
						if((/^\d+$/.test(kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_akun))
						   && kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_akun!==undefined
						   && kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_akun!==''
						   && kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_akun!==0
						   && kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_kredit!==0
						   && kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_kredit>0){

							dkasbank_masuk_id.push(kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_id);
							dkasbank_masuk_akun.push(kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_akun);
							dkasbank_masuk_detail.push(kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_detail);
							dkasbank_masuk_kredit.push(kasbank_masuk_detail_DataStore.getAt(i).data.dkasbank_masuk_kredit);
							dkasbank_masuk_debet.push(0);
						}
					}
				}

				var encoded_array_dkasbank_masuk_id = Ext.encode(dkasbank_masuk_id);
				var encoded_array_dkasbank_masuk_akun = Ext.encode(dkasbank_masuk_akun);
				var encoded_array_dkasbank_masuk_detail = Ext.encode(dkasbank_masuk_detail);
				var encoded_array_dkasbank_masuk_kredit = Ext.encode(dkasbank_masuk_kredit);
				var encoded_array_dkasbank_masuk_debet = Ext.encode(dkasbank_masuk_debet);


				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kasbank_masuk&m=get_action',
					params: {
						kasbank_masuk_id			: kasbank_masuk_id_field_pk,
						kasbank_masuk_tanggal		: kasbank_masuk_tanggal_field_date,
						kasbank_masuk_nobukti		: kasbank_masuk_nobukti_field,
						kasbank_masuk_akun			: kasbank_masuk_akun_field,
						kasbank_masuk_terimauntuk	: kasbank_masuk_terimauntuk_field,
						kasbank_masuk_jenis			: kasbank_masuk_jenis_field,
						kasbank_masuk_noref			: kasbank_masuk_noref_field,
						kasbank_masuk_keterangan	: kasbank_masuk_keterangan_field,
						dkasbank_masuk_id			: encoded_array_dkasbank_masuk_id,
					    dkasbank_masuk_akun			: encoded_array_dkasbank_masuk_akun,
					    dkasbank_masuk_detail		: encoded_array_dkasbank_masuk_detail,
					    dkasbank_masuk_kredit		: encoded_array_dkasbank_masuk_kredit,
						dkasbank_masuk_debet		: encoded_array_dkasbank_masuk_debet,
						task						: post2db
					},
					success: function(response){
						var result=response.responseText;
						//var rsp_kode=result.substring(0,2);
						//var rsp_msg=result.replace(rsp_kode+':','');
						if(result!=='0'){
								//kasbank_masuk_detail_insert(eval(rsp_msg),opsi);
								if(opsi=='print'){
								   kasbank_masuk_cetak_faktur(result);
							    }
								Ext.MessageBox.show({
								   title: 'Success',
								   msg: 'Data Kas/Bank Masuk sukses disimpan ',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.OK
								});
								kasbank_masuk_DataStore.reload();
								kasbank_masuk_saveWindow.hide();
						}else{
						    Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data Kas/Bank Masuk gagal disimpan',
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
			return kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_id');
		else
			return 0;
	}
	/* End of Function  */

	/* Reset form before loading */
	function kasbank_masuk_reset_form(){
		kasbank_masuk_tanggalField.reset();
		kasbank_masuk_tanggalField.setValue(today);
		kasbank_masuk_nobuktiField.reset();
		kasbank_masuk_nobuktiField.setValue('(auto)');
		kasbank_masuk_akunField.reset();
		kasbank_masuk_akunField.setValue(null);
		kasbank_masuk_terimauntukField.reset();
		kasbank_masuk_terimauntukField.setValue(null);
		kasbank_masuk_norefField.reset();
		kasbank_masuk_norefField.setValue(null);
		kasbank_masuk_keteranganField.reset();
		kasbank_masuk_keteranganField.setValue(null);
		kasbank_masuk_kodeakunField.reset();
		kasbank_masuk_kodeakunField.setValue(null);
		kasbank_masuk_jenisField.reset();
		kasbank_masuk_jenisField.setValue('Bank');
		kasbank_masuk_jenisField.setDisabled(false);

		kasbank_masuk_detail_DataStore.setBaseParam('master_id',-1);
		kasbank_masuk_detail_DataStore.load();
		cbo_akun_dkasbank_masukDataStore.setBaseParam('task','all');
		cbo_akun_dkasbank_masukDataStore.load();
		total_kasbank_masuk_kredit.setValue(0);
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		kasbank_masuk_btnSave.setVisible(true);
		//kasbank_masuk_btnSavePrint.setVisible(true);
		kasbank_masuk_btnSavePrint.setDisabled(false);
		<?php } ?>
	}
 	/* End of Function */

	/* setValue to EDIT */
	function kasbank_masuk_set_form(){

		var jenis_kb='Kas';
		kasbank_masuk_tanggalField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_tanggal'));
		kasbank_masuk_nobuktiField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_nobukti'));
		kasbank_masuk_akunField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_akun'));
		kasbank_masuk_kodeakunField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_kode'));
		kasbank_masuk_terimauntukField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_terimauntuk'));
		kasbank_masuk_norefField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_noref'));
		kasbank_masuk_keteranganField.setValue(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_keterangan'));

		if(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_nobukti').substring(0,1)=='K'){
			jenis_kb='Kas';
 		}else{
			jenis_kb='Bank';
 	 	}
		kasbank_masuk_jenisField.setValue(jenis_kb);
		kasbank_masuk_jenisField.setDisabled(true);

		cbo_akun_dkasbank_masuk_renderDataStore.setBaseParam('task','detail');
		cbo_akun_dkasbank_masuk_renderDataStore.setBaseParam('master_id',get_pk_id());
		cbo_akun_dkasbank_masuk_renderDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					kasbank_masuk_detail_DataStore.setBaseParam('master_id',get_pk_id());
					kasbank_masuk_detail_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								get_total_masuk_debet_kredit();
								Ext.MessageBox.hide();
							}
						}
					});

				}
			}
		});

		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		if(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_post')=='Y'){
			kasbank_masuk_btnSave.setVisible(false);
			//kasbank_masuk_btnSavePrint.setVisible(false);
			kasbank_masuk_btnSavePrint.setDisabled(true);
			//kasbank_masuk_masterGroup.setDisabled(true);
		}else{
			kasbank_masuk_btnSave.setVisible(true);
			//kasbank_masuk_btnSavePrint.setVisible(true);
			kasbank_masuk_btnSavePrint.setDisabled(false);
			//kasbank_masuk_masterGroup.setDisabled(false);
		}
		<?php } ?>
	}
	/* End setValue to EDIT*/

	/* Function for Check if the form is valid */
	function is_kasbank_masuk_form_valid(){
		return (kasbank_masuk_tanggalField.isValid() &&
				kasbank_masuk_akunField.isValid());
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!kasbank_masuk_saveWindow.isVisible()){
			post2db='CREATE';
			msg='created';

			kasbank_masuk_reset_form();
			kasbank_masuk_saveWindow.show();
		} else {
			kasbank_masuk_saveWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function kasbank_masuk_confirm_delete(){

		if(kasbankMasukListEditorGrid.selModel.getCount() == 1){
			if(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_post')=='Y'){
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Jurnal yang sudah terposting tidak dapat dihapus',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					width: 300,
					icon: Ext.MessageBox.WARNING
				});
			}else{
				Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_masuk_delete);
			}

		} else if(kasbankMasukListEditorGrid.selModel.getCount() > 1){
			var selections = kasbankMasukListEditorGrid.selModel.getSelections();
			var count_post=0;
			for(i = 0; i< kasbankMasukListEditorGrid.selModel.getCount(); i++){
				if(selections[i].json.kasbank_post=='Y') count_post++;
			}
			//console.log('count'+count_post);
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
				Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_masuk_delete);
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

	/* Function for Update Confirm */
	function kasbank_masuk_confirm_reopen(){
		/* only one record is selected here */
		if(kasbankMasukListEditorGrid.selModel.getCount() == 1) {
				var id="";
				var tanggal=null;
			if(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_post')!=='Y'){
				
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Data yang belum terposting tidak perlu dibuka',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});

			}else if(kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_post')=='Y' &&
					kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_tanggal').format('Y-m-d')>=MAX_UNPOSTING){

				id = kasbankMasukListEditorGrid.getSelectionModel().getSelected().get('kasbank_masuk_id');

				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kasbank_masuk&m=kasbank_reopen',
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
						kasbank_masuk_DataStore.reload();
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
	
	function kasbank_masuk_print_only(){
		var kasbank_masuk_id_field_pk='';
		kasbank_masuk_id_field_pk=get_pk_id();
		if(kasbank_masuk_id_field_pk==''){
			Ext.MessageBox.show({
			msg: 'Kas Bank Masuk tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
				
			var kasbank_masuk_id = kasbank_masuk_id_field_pk;
			cetak_kasbank_masuk=1;
			//master_order_beli_create('print');
			kasbank_masuk_cetak_faktur(kasbank_masuk_id);
			kasbank_masuk_DataStore.reload()
			
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			
			kasbank_masuk_saveWindow.hide();
		}

		//jproduk_btn_cancel();
	}

  	/* Function for Reopen Confirm */
	function kasbank_masuk_confirm_update(){
		/* only one record is selected here */
		if(kasbankMasukListEditorGrid.selModel.getCount() == 1) {

			post2db='UPDATE';
			msg='updated';
			kasbank_masuk_set_form();
			kasbank_masuk_saveWindow.show();

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
	function kasbank_masuk_delete(btn){
		if(btn=='yes'){
			var selections = kasbankMasukListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< kasbankMasukListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kasbank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_kasbank_masuk&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							kasbank_masuk_DataStore.reload();
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
	kasbank_masuk_DataStore = new Ext.data.Store({
		id: 'kasbank_masuk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_masuk&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kasbank_masuk_id'
		},[
			{name: 'kasbank_masuk_id', type: 'int', mapping: 'kasbank_id'},
			{name: 'kasbank_masuk_tanggal', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_tanggal'},
			{name: 'kasbank_masuk_nobukti', type: 'string', mapping: 'kasbank_nobukti'},
			{name: 'kasbank_masuk_akun', type: 'string', mapping: 'akun_nama'},
			{name: 'kasbank_masuk_kode', type: 'string', mapping: 'akun_kode'},
			{name: 'kasbank_masuk_terimauntuk', type: 'string', mapping: 'kasbank_terimauntuk'},
			{name: 'kasbank_masuk_jenis', type: 'string', mapping: 'kasbank_jenis'},
			{name: 'kasbank_masuk_debet', type: 'float', mapping: 'kasbank_debet'},
			{name: 'kasbank_masuk_kredit', type: 'float', mapping: 'kasbank_kredit'},
			{name: 'kasbank_masuk_noref', type: 'string', mapping: 'kasbank_noref'},
			{name: 'kasbank_masuk_keterangan', type: 'string', mapping: 'kasbank_keterangan'},
			{name: 'kasbank_masuk_author', type: 'string', mapping: 'kasbank_author'},
			{name: 'kasbank_masuk_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_create'},
			{name: 'kasbank_masuk_update', type: 'string', mapping: 'kasbank_update'},
			{name: 'kasbank_masuk_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_update'},
			{name: 'kasbank_masuk_post', type: 'string', mapping: 'kasbank_post'},
			{name: 'kasbank_masuk_date_post', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kasbank_date_post'},
			{name: 'kasbank_masuk_revised', type: 'int', mapping: 'kasbank_mrevised'}
		]),
		//sortInfo:{field: 'kasbank_masuk_tanggal', direction: "DESC"}
	});
	/* End of Function */


	/* Function for Retrieve DataStore */
	cbo_akun_DataStore = new Ext.data.Store({
		id: 'cbo_akun_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_masuk&m=get_akun_kasbank',
			method: 'POST'
		}),
		baseParams:{start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
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
		sortInfo:{field: 'akun_kode', direction: "ASC"}
	});
	/* End of Function */


	/* Function for Retrieve DataStore */
	cbo_akun_dkasbank_masuk_renderDataStore = new Ext.data.Store({
		id: 'cbo_akun_dkasbank_masuk_renderDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_masuk&m=get_detail_akun',
			method: 'POST'
		}),
		baseParams:{task: 'detail', start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
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
		sortInfo:{field: 'akun_kode', direction: "ASC"}
	});
	/* End of Function */

	/* Function for Retrieve DataStore */
	cbo_akun_dkasbank_masukDataStore = new Ext.data.Store({
		id: 'cbo_akun_dkasbank_masukDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_masuk&m=get_detail_akun',
			method: 'POST'
		}),
		baseParams:{start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
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
	kasbank_masuk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Tanggal',
			dataIndex: 'kasbank_masuk_tanggal',
			width: 130,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			readOnly: true
		},
		{
			header: 'No Jurnal',
			dataIndex: 'kasbank_masuk_nobukti',
			width: 150,
			sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
				var kasbank_no="";
				if(record.data.kasbank_masuk_post=='Y')
					kasbank_no='<b><font color=RED>'+record.data.kasbank_masuk_nobukti+'</font></b>';
				else
					kasbank_no='<b>'+record.data.kasbank_masuk_nobukti+'</b>';

                return '<span>' + kasbank_no+ '</span>';
            }
		},
		{
			header: 'Nama Akun',
			dataIndex: 'kasbank_masuk_akun',
			width: 350,
			sortable: true,
			readOnly: true
		},
		{	header: 'Kode',
			dataIndex: 'kasbank_masuk_kode',
			width: 100,
			readOnly: true
		},
		{
			header: 'Terima Dari',
			dataIndex: 'kasbank_masuk_terimauntuk',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden : true
		},
		{
			header: 'Keterangan',
			dataIndex: 'kasbank_masuk_keterangan',
			width: 250,
			sortable: true,
			readOnly: true
		},
		 {
			 header: 'Debet (Rp)',
			 width: 150,
			 align: 'right',
			 renderer: function(v, params, record){
				var nilai_rupiah=record.data.kasbank_masuk_debet;
				return '<span>'+Ext.util.Format.number(nilai_rupiah,'0,000')+'</span>';
             },
			 sortable: true,
			 readOnly: true
		 },
		{
			header: 'Creator',
			dataIndex: 'kasbank_masuk_author',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'kasbank_masuk_date_create',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'kasbank_masuk_update',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'kasbank_masuk_date_update',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Posted',
			dataIndex: 'kasbank_masuk_post',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Posted on',
			dataIndex: 'kasbank_masuk_date_post',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'kasbank_masuk_revised',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}	]);

	kasbank_masuk_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	kasbankMasukListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kasbankMasukListEditorGrid',
		el: 'fp_kasbank_masuk',
		title: 'Jurnal Kas/Bank Masuk',
		autoHeight: true,
		store: kasbank_masuk_DataStore, // DataStore
		cm: kasbank_masuk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1024,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: kasbank_masuk_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kasbank_masuk_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kasbank_masuk_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: kasbank_masuk_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: kasbank_masuk_reset_search,
			iconCls:'icon-refresh'
		}
		<?php if(ereg('D',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		,'-',
		{
			text: 'Buka Posting',
			tooltip: 'Buka Posting',
			iconCls:'icon-reopen',
			handler: kasbank_masuk_confirm_reopen   // Confirm before updating
		}
		<?php } ?>
		,'-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kasbank_masuk_print
		}
		]
	});
	kasbankMasukListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	kasbank_masuk_ContextMenu = new Ext.menu.Menu({
		id: 'kasbank_masuk_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kasbank_masuk_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kasbank_masuk_confirm_delete
		},
		<?php } ?>
		<?php if(eregi('R',$this->m_security->get_access_group_by_kode('MENU_POSTING'))){ ?>
		'-',
		{
			text: 'Buka Posting',
			tooltip: 'Buka Posting',
			iconCls:'icon-reopen',
			handler: kasbank_masuk_confirm_reopen   // Confirm before updating
		}
		<?php } ?>
		,'-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kasbank_masuk_print
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onkasbank_masuk_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		kasbank_masuk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		kasbank_masuk_SelectedRow=rowIndex;
		kasbank_masuk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function kasbank_masuk_editContextMenu(){
		kasbank_masuk_confirm_update();
  	}
	/* End of Function */

	kasbankMasukListEditorGrid.addListener('rowcontextmenu', onkasbank_masuk_ListEditGridContextMenu);
	kasbank_masuk_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore


	/* Identify  kasbank_masuk_tanggal Field */
	kasbank_masuk_tanggalField= new Ext.form.DateField({
		id: 'kasbank_masuk_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		anchor: '95%',
		allowBlank: false,
		minValue: MIN_CREATE_DATE,
		maxValue: MAX_CREATE_DATE
	});

	/* Identify  kasbank_masuk_nobukti Field */
	kasbank_masuk_nobuktiField= new Ext.form.TextField({
		id: 'kasbank_masuk_nobuktiField',
		fieldLabel: 'No Jurnal',
		maxLength: 50,
		anchor: '95%',
		allowBlank: false,
		value: '(auto)',
		readOnly: true
	});

	var akun_kasbank_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>[{akun_kode}] {akun_nama}</b></span>',
        '</div></tpl>'
    );

	/* Identify  kasbank_masuk_akun Field */
	kasbank_masuk_akunField= new Ext.form.ComboBox({
		id: 'kasbank_masuk_akunField',
		fieldLabel: 'Nama Akun',
		store: cbo_akun_DataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		itemSelector: 'div.search-item',
		listClass: 'x-combo-list-small',
		anchor: '95%',
		tpl: akun_kasbank_tpl,
		hideTrigger: false,
		allowBlank: false
	});

	/* Identify  kasbank_masuk_kodeakun Field */
	kasbank_masuk_kodeakunField= new Ext.form.TextField({
		id: 'kasbank_masuk_kodeakunField',
		fieldLabel: 'Kode Akun',
		maxLength: 250,
		anchor: '50%',
		readOnly: true
	});
	/* Identify  kasbank_masuk_terimauntuk Field */
	kasbank_masuk_terimauntukField= new Ext.form.TextField({
		id: 'kasbank_masuk_terimauntukField',
		fieldLabel: 'Terima Dari',
		maxLength: 250,
		anchor: '95%'
	});

	/* Identify  kasbank_masuk_terimauntuk Field */
	kasbank_masuk_jenisField= new Ext.form.ComboBox({
		id: 'kasbank_masuk_jenisField',
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

	/* Identify  kasbank_masuk_noref Field */
	kasbank_masuk_norefField= new Ext.form.TextField({
		id: 'kasbank_masuk_norefField',
		fieldLabel: 'No Referensi',
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  kasbank_masuk_keterangan Field */
	kasbank_masuk_keteranganField= new Ext.form.TextArea({
		id: 'kasbank_masuk_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});

  	/*Fieldset Master*/
	kasbank_masuk_masterGroup = new Ext.form.FieldSet({
		title: 'Master ',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.35,
				layout: 'form',
				border:false,
				items: [kasbank_masuk_tanggalField, kasbank_masuk_nobuktiField,  kasbank_masuk_jenisField,  kasbank_masuk_norefField]
			},{
				columnWidth:0.65,
				layout: 'form',
				border:false,
				items: [kasbank_masuk_akunField, kasbank_masuk_kodeakunField, kasbank_masuk_terimauntukField, kasbank_masuk_keteranganField]
			}
			]

	});


	/*Detail Declaration */
	// Function for json reader of detail
	var kasbank_masuk_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dkasbank_masuk_id'
	},[
			{name: 'dkasbank_masuk_id', type: 'int', mapping: 'dkasbank_id'},
			{name: 'dkasbank_masuk_master', type: 'int', mapping: 'dkasbank_master'},
			{name: 'dkasbank_masuk_akun', type: 'int', mapping: 'dkasbank_akun'},
			{name: 'dkasbank_masuk_detail', type: 'string', mapping: 'dkasbank_detail'},
			{name: 'dkasbank_masuk_debet', type: 'float', mapping: 'dkasbank_debet'},
			{name: 'dkasbank_masuk_kredit', type: 'float', mapping: 'dkasbank_kredit'}
	]);
	//eof

	//function for json writer of detail
	var kasbank_masuk_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	kasbank_masuk_detail_DataStore = new Ext.data.Store({
		id: 'kasbank_masuk_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kasbank_masuk&m=detail_kasbank_masuk_detail_list',
			method: 'POST'
		}),
		baseParams:{master_id: get_pk_id()},
		reader: kasbank_masuk_detail_reader,
		sortInfo:{field: 'dkasbank_masuk_id', direction: "ASC"}
	});
	/* End of Function */

	//function for editor of detail
	var editor_kasbank_masuk_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	//function combo render
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}

	// variable combo akun
	var combo_akun_kasbank_detail_masuk_render=new Ext.form.ComboBox({
		id: 'combo_akun_kasbank_detail_masuk',
		store: cbo_akun_dkasbank_masuk_renderDataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		listClass: 'x-combo-list-small',
		anchor: '95%',
		hideTrigger: false,
		allowBlank: false
	});
	//eof

	var combo_akun_kasbank_detail_masuk=new Ext.form.ComboBox({
		id: 'combo_akun_kasbank_detail_masuk',
		store: cbo_akun_dkasbank_masukDataStore,
		mode: 'remote',
		displayField: 'akun_nama',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: false,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender: false,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		tpl: akun_kasbank_tpl,
		itemSelector: 'div.search-item',
		listClass: 'x-combo-list-small',
		anchor: '95%',
		hideTrigger: false,
		allowBlank: false
	});

	var combo_akun_kasbank_detail_masuk_kode=new Ext.form.ComboBox({
		store: cbo_akun_dkasbank_masuk_renderDataStore,
		mode: 'remote',
		displayField: 'akun_kode',
		valueField: 'akun_id',
		loadingText: 'Searching...',
		typeAhead: true,
		pageSize: pageS,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '80%',
		allowBlank: false,
		hideTrigger: false
	});

	var kode_aku_kasbank_detail_masuk=new Ext.form.TextField({
			readOnly: true
		});
	//declaration of detail coloumn model
	kasbank_masuk_detail_ColumnModel = new Ext.grid.ColumnModel(
		[
		 {
			header: 'ID',
			dataIndex: 'dkasbank_masuk_id',
			width: 350,
			sortable: false,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Nama Akun',
			dataIndex: 'dkasbank_masuk_akun',
			width: 350,
			sortable: false,
			editor: combo_akun_kasbank_detail_masuk,
			renderer: Ext.util.Format.comboRenderer(combo_akun_kasbank_detail_masuk_render)
		},
		{
			header: 'Kode',
			dataIndex: 'dkasbank_masuk_akun',
			width: 100,
			readOnly: true,
			//editor: kode_aku_kasbank_detail_masuk,
			renderer: Ext.util.Format.comboRenderer(combo_akun_kasbank_detail_masuk_kode)
		},

		{
			header: 'Keterangan',
			dataIndex: 'dkasbank_masuk_detail',
			width: 250,
			editor: new Ext.form.TextField({
				maxLength: 250
			})
		},
		/*{
			header: 'Debet (Rp)',
			dataIndex: 'dkasbank_masuk_debet',
			width: 150,
			readOnly: true

		}, */
		{
			header: 'Kredit (Rp)',
			dataIndex: 'dkasbank_masuk_kredit',
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
		}
		]
	);
	kasbank_masuk_detail_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	kasbank_masuk_detailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kasbank_masuk_detailListEditorGrid',
		el: 'fp_kasbank_masuk_detail',
		title: 'Detail Jurnal Masuk [Kredit]',
		height: 250,
		width: 690,
		autoScroll: true,
		store: kasbank_masuk_detail_DataStore, // DataStore
		colModel: kasbank_masuk_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_kasbank_masuk_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: kasbank_masuk_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: kasbank_masuk_detail_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof


	//function of detail add
	function kasbank_masuk_detail_add(){
		var edit_kasbank_masuk_detail= new kasbank_masuk_detailListEditorGrid.store.recordType({
			dkasbank_masuk_id		:0,
			dkasbank_masuk_akun		:'',
			dkasbank_masuk_detail	:'',
			dkasbank_masuk_debet	: 0,
			dkasbank_masuk_kredit	: 0
		});
		editor_kasbank_masuk_detail.stopEditing();
		kasbank_masuk_detail_DataStore.insert(0, edit_kasbank_masuk_detail);
		kasbank_masuk_detailListEditorGrid.getView().refresh();
		kasbank_masuk_detailListEditorGrid.getSelectionModel().selectRow(0);
		editor_kasbank_masuk_detail.startEditing(0);
	}

	//function for refresh detail
	function refresh_kasbank_masuk_detail(){
		kasbank_masuk_detail_DataStore.commitChanges();
		kasbank_masuk_detailListEditorGrid.getView().refresh();
	}
	//eof

	function kasbank_masuk_cetak_faktur(pkid){

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kasbank_masuk&m=print_faktur',
		params: {
			faktur	: pkid
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/kasbank_masuk_faktur.html','kasbank_faktur','height=400,width=720,resizable=1,scrollbars=1, menubar=1');
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

	function kasbank_masuk_detail_insert(pkid,opsi){
       //
	}

	/* Function for Delete Confirm of detail */
	function kasbank_masuk_detail_confirm_delete(){
		// only one record is selected here
		if(kasbank_masuk_detailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_masuk_detail_delete);
		} else if(kasbank_masuk_detailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Perhatian !','Apakah anda benar-benar akan menghapus data ini?', kasbank_masuk_detail_delete);
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
	function kasbank_masuk_detail_delete(btn){
		if(btn=='yes'){
			var s = kasbank_masuk_detailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				kasbank_masuk_detail_DataStore.remove(r);
			}
		}
	}
	//eof

	//event on update of detail data store
	total_kasbank_masuk_kredit= new Ext.form.TextField({
		id: 'total_kasbank_masuk_kredit',
		fieldLabel: 'Total Kredit',
		readOnly: true,
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/
	});

  	/*Fieldset Total Jumlah*/
	jumlah_total_kasbank_masuk = new Ext.form.FieldSet({
		title: 'Total Jumlah ',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [total_kasbank_masuk_kredit]
			}
			]

	});


	kasbank_masuk_btnSave=new Ext.Button({
		text: 'Save',
		visible: true,
		handler: function() { kasbank_masuk_save('save'); }
	});

	kasbank_masuk_btnSavePrint=new Ext.Button({
		text: 'Save and Print',
		visible: true,
		handler: function() { kasbank_masuk_save('print'); }
	});

	/* Function for retrieve create Window Panel*/
	kasbank_masuk_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		items: [kasbank_masuk_masterGroup,kasbank_masuk_detailListEditorGrid,jumlah_total_kasbank_masuk],
		buttons: [
			{
				text: 'Print Only',
				handler: kasbank_masuk_print_only
			},
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KASBANKMASUK'))){ ?>
			kasbank_masuk_btnSavePrint,
			kasbank_masuk_btnSave
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					kasbank_masuk_saveWindow.hide();
				}
			}
		]
	});


	/* Function for retrieve create Window Form */
	kasbank_masuk_saveWindow= new Ext.Window({
		id: 'kasbank_masuk_saveWindow',
		title: post2db+' Jurnal Kas/Bank Masuk',
		closable:true,
		closeAction: 'hide',
		width: 720,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kasbank_masuk_save',
		items: kasbank_masuk_saveForm
	});
	/* End Window */

	/* Function for action list search */
	function kasbank_masuk_list_search(){
		// render according to a SQL date format.
		var kasbank_masuk_tgl_awal_search_date="";
		var kasbank_masuk_tgl_akhir_search_date="";
		var kasbank_masuk_nobukti_search=null;
		var kasbank_masuk_akun_search=null;
		var kasbank_masuk_terimauntuk_search=null;
		var kasbank_masuk_noref_search=null;
		var kasbank_masuk_keterangan_search=null;

		if(kasbank_masuk_tanggal_awalSearchField.getValue()!==""){kasbank_masuk_tgl_awal_search_date=kasbank_masuk_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(kasbank_masuk_tanggal_akhirSearchField.getValue()!==""){kasbank_masuk_tgl_akhir_search_date=kasbank_masuk_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(kasbank_masuk_nobuktiSearchField.getValue()!==null){kasbank_masuk_nobukti_search=kasbank_masuk_nobuktiSearchField.getValue();}
		if(kasbank_masuk_akunSearchField.getValue()!==null){kasbank_masuk_akun_search=kasbank_masuk_akunSearchField.getValue();}
		if(kasbank_masuk_terimauntukSearchField.getValue()!==null){kasbank_masuk_terimauntuk_search=kasbank_masuk_terimauntukSearchField.getValue();}
		if(kasbank_masuk_norefSearchField.getValue()!==null){kasbank_masuk_noref_search=kasbank_masuk_norefSearchField.getValue();}
		if(kasbank_masuk_keteranganSearchField.getValue()!==null){kasbank_masuk_keterangan_search=kasbank_masuk_keteranganSearchField.getValue();}

		// change the store parameters
		kasbank_masuk_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kasbank_masuk_tgl_awal		:	kasbank_masuk_tgl_awal_search_date,
			kasbank_masuk_tgl_akhir		:	kasbank_masuk_tgl_akhir_search_date,
			kasbank_masuk_nobukti		:	kasbank_masuk_nobukti_search,
			kasbank_masuk_akun			:	kasbank_masuk_akun_search,
			kasbank_masuk_terimauntuk	:	kasbank_masuk_terimauntuk_search,
			kasbank_masuk_noref			:	kasbank_masuk_noref_search,
			kasbank_masuk_keterangan	:	kasbank_masuk_keterangan_search
		};
		// Cause the datastore to do another query :
		kasbank_masuk_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function kasbank_masuk_reset_search(){
		// reset the store parameters
		kasbank_masuk_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		kasbank_masuk_DataStore.reload({params: {start: 0, limit: pageS}});
		kasbank_masuk_searchWindow.close();
	};
	/* End of Fuction */

	/* Identify  kasbank_masuk_tanggal Search Field */
	kasbank_masuk_tanggal_awalSearchField= new Ext.form.DateField({
		id: 'kasbank_masuk_tanggal_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		anchor: '95%'

	});

	/* Identify  kasbank_masuk_tanggal Search Field */
	kasbank_masuk_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'kasbank_masuk_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		anchor: '95%'

	});

	/* Identify  kasbank_masuk_nobukti Search Field */
	kasbank_masuk_nobuktiSearchField= new Ext.form.TextField({
		id: 'kasbank_masuk_nobuktiSearchField',
		fieldLabel: 'Nobukti',
		maxLength: 50,
		anchor: '50%'

	});
	/* Identify  kasbank_masuk_akun Search Field */
	kasbank_masuk_akunSearchField= new Ext.form.ComboBox({
		id: 'kasbank_masuk_akunSearchField',
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
		anchor: '95%',
		hideTrigger: false

	});

	/* Identify  kasbank_masuk_terimauntuk Search Field */
	kasbank_masuk_terimauntukSearchField= new Ext.form.TextField({
		id: 'kasbank_masuk_terimauntukSearchField',
		fieldLabel: 'Terima dari',
		maxLength: 250,
		anchor: '95%'

	});

	/* Identify  kasbank_masuk_noref Search Field */
	kasbank_masuk_norefSearchField= new Ext.form.TextField({
		id: 'kasbank_masuk_norefSearchField',
		fieldLabel: 'No Referensi',
		maxLength: 50,
		anchor: '50%'

	});
	/* Identify  kasbank_masuk_keterangan Search Field */
	kasbank_masuk_keteranganSearchField= new Ext.form.TextArea({
		id: 'kasbank_masuk_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'

	});



	/* Function for retrieve search Form Panel */
	kasbank_masuk_searchForm = new Ext.FormPanel({
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
							kasbank_masuk_tanggal_awalSearchField
						]
					},
					{
						columnWidth:0.35,
						layout: 'form',
						border:false,
						labelWidth:20,
						defaultType: 'datefield',
						items: [
							kasbank_masuk_tanggal_akhirSearchField
						]
					}
			        ]
				},
				 kasbank_masuk_nobuktiSearchField, kasbank_masuk_akunSearchField,
				kasbank_masuk_terimauntukSearchField,  kasbank_masuk_norefSearchField, kasbank_masuk_keteranganSearchField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kasbank_masuk_list_search
			},{
				text: 'Close',
				handler: function(){
					kasbank_masuk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	kasbank_masuk_searchWindow = new Ext.Window({
		title: 'Pencarian Kas/Bank',
		closable:true,
		closeAction: 'hide',
		width: 420,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kasbank_masuk_search',
		items: kasbank_masuk_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kasbank_masuk_searchWindow.isVisible()){
			kasbank_masuk_searchWindow.show();
		} else {
			kasbank_masuk_searchWindow.toFront();
		}
	}
  	/* End Function */

	function kasbank_masuk_print(){
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

		if(kasbank_masuk_DataStore.baseParams.query!==null){searchquery = kasbank_masuk_DataStore.baseParams.query;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_nobukti!==null){kasbank_nobukti_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_nobukti;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_tgl_awal!==null){kasbank_tgl_awal_print_date = kasbank_masuk_DataStore.baseParams.kasbank_masuk_tgl_awal;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_tgl_akhir!==null){kasbank_tgl_akhir_print_date = kasbank_masuk_DataStore.baseParams.kasbank_masuk_tgl_akhir;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_akun!==null){kasbank_akun_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_akun;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_keterangan!==null){kasbank_keterangan_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_keterangan;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_terimauntuk!==null){kasbank_terimauntuk_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_terimauntuk;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_post!==null){kasbank_post_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_post;}
		if(kasbank_masuk_DataStore.baseParams.kasbank_masuk_noref!==null){kasbank_noref_print = kasbank_masuk_DataStore.baseParams.kasbank_masuk_noref;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kasbank_masuk&m=get_action',
		params: {
			task						: "PRINT",
		  	query						: searchquery,
			kasbank_masuk_nobukti 		: kasbank_nobukti_print,
		  	kasbank_masuk_tgl_awal 		: kasbank_tgl_awal_print_date,
			kasbank_masuk_tgl_akhir		: kasbank_tgl_akhir_print_date,
			kasbank_masuk_keterangan 	: kasbank_keterangan_print,
			kasbank_masuk_terimauntuk	: kasbank_terimauntuk_print,
			kasbank_masuk_post			: kasbank_post_print,
		  	currentlisting				: kasbank_masuk_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/kasbank_masuk_printlist.html','kasbank_masuk_printlist','height=600,width=780,resizable=1,scrollbars=1, menubar=1');
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

	function get_total_masuk_debet_kredit(){
		var jumlah_total_kasbank_masuk_kredit=0;
		for(i=0;i<kasbank_masuk_detail_DataStore.getCount();i++){
			record_data=kasbank_masuk_detail_DataStore.getAt(i);
			//jumlah_total_kasbank_masuk_kasbank_masuk_debet+=record_data.data.dkasbank_masuk_debet;
			jumlah_total_kasbank_masuk_kredit+=record_data.data.dkasbank_masuk_kredit;
		}
		//total_kasbank_masuk_debet.setValue(jumlah_total_kasbank_masuk_kasbank_masuk_debet);
		total_kasbank_masuk_kredit.setValue(CurrencyFormatted(jumlah_total_kasbank_masuk_kredit));
	}


	kasbank_masuk_detail_DataStore.on("update",function(){
		kasbank_masuk_detail_DataStore.commitChanges();

		var query_selected="";
		cbo_akun_dkasbank_masukDataStore.lastQuery=null;
		for(i=0;i<kasbank_masuk_detail_DataStore.getCount();i++){
			detail_record=kasbank_masuk_detail_DataStore.getAt(i);
			query_selected=query_selected+detail_record.data.dkasbank_masuk_akun+",";
		}
		cbo_akun_dkasbank_masuk_renderDataStore.setBaseParam('task','selected');
		cbo_akun_dkasbank_masuk_renderDataStore.setBaseParam('master_id',get_pk_id());
		cbo_akun_dkasbank_masuk_renderDataStore.setBaseParam('selected_id',query_selected);
		cbo_akun_dkasbank_masuk_renderDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					kasbank_masuk_detailListEditorGrid.getView().refresh();
				}
			}
		});

		get_total_masuk_debet_kredit();

	});
	/*End of Function */

	combo_akun_kasbank_detail_masuk.on("focus",function(){
		cbo_akun_dkasbank_masukDataStore.setBaseParam('task','all');
		cbo_akun_dkasbank_masukDataStore.load({params:{start:0, limit: pageS}});
	});

	kasbank_masuk_akunField.on('select',function(){
		var j=cbo_akun_DataStore.findExact('akun_id',kasbank_masuk_akunField.getValue());
		if(j>-1){
			//var thismonth=new Date().format('y-m');
			var record_akun=cbo_akun_DataStore.getAt(j);
			//var kode=kasbank_masuk_kodeakunField.getValue().substring(0,3);
			kasbank_masuk_kodeakunField.setValue(record_akun.data.akun_kode);
		}
	});



});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_kasbank_masuk"></div>
        <div id="fp_kasbank_masuk_detail"></div>
		<div id="elwindow_kasbank_masuk_save"></div>
        <div id="elwindow_kasbank_masuk_search"></div>
    </div>
</div>
</body>
</html>