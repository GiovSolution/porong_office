<?
/* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Ganti Password View
	+ Description	: For record view
	+ Filename 		: V_gpass.php
 	+ Author  		: 
 	+ Created on 01/May/2009 06:35:27
	
*/
?>
<div id="welcome">
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

var pass_usersWindow;
var pass_usersForm;

var pass_user_idField;
var pass_user_kodeField;
var pass_user_namaField;
var pass_user_kelaminField;
var pass_user_tgllahirField;
var pass_user_alamatField;
var pass_user_kotaField;
var pass_user_notelpField;
var pass_user_passwdField;

Ext.apply(Ext.form.VTypes, {

	password : function(val, field) {
		if (field.initialPassField) {
			var login = Ext.getCmp(field.initialPassField);
			return (val == login.getValue());
		}
		return true;
	},
	passwordText : 'Passwords tidak sama' //alert if you enter a password that is not the same
});

Ext.onReady(function(){
  Ext.QuickTips.init();
	
	function updatepass_users(){
		if(is_pass_usersFormValid()){
			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_gpass&m=update',
				params: {
					user_passwd		: pass_user_passwdField.getValue(),
					user_passwdlama	: pass_user_passwdlamaField.getValue()
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert('Update OK ','Password berhasil disimpan');
							pass_usersWindow.hide();
							mainPanel.remove(mainPanel.getActiveTab().getId());
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Password tidak bisa disimpan',
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
				msg: 'Form anda belum valid',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	
	function is_pass_usersFormValid(){
		return true;
	}
	
	pass_user_idField= new Ext.form.TextField({
		id: 'pass_user_idField',
		name: 'pass_user_id',
		fieldLabel: 'Username',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%',
		disabled: true
	});
	
	pass_user_passwdField= new Ext.form.TextField({
		id: 'pass_user_passwdField',
		name: 'pass_user_passwd',
		fieldLabel: 'Password Baru',
		minLength: 6,
		maxLength: 15,
		allowBlank: true,
		anchor: '95%',
		inputType: 'password',
		allowBlank:false
	});
	
	pass_user_passwdulangField= new Ext.form.TextField({
		id: 'pass_user_passwdulangField',
		fieldLabel: 'Password Ulang',
		name: 'pass_user_passwdulang',
		minLength: 6,
		maxLength: 15,
		allowBlank: true,
		anchor: '95%',
		inputType: 'password',
		vtype:'password',
		initialPassField: 'pass_user_passwdField',
		allowBlank:false
	});
	
	pass_user_passwdlamaField= new Ext.form.TextField({
		id: 'pass_user_passwdlamaField',
		fieldLabel: 'Password Lama',
		name: 'pass_user_passwdlama',
		minLength: 3,
		maxLength: 15,
		allowBlank: true,
		anchor: '95%',
		inputType: 'password',
		allowBlank:false
	});
	

	pass_userForm = new Ext.FormPanel({
		url: 'index.php?c=c_gpass&m=get',
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		//autoHeight:true,
		width: 300, 
		height: 150,
		reader: new Ext.data.JsonReader({
			root: 'results',
			id: 'pass_user_id'
		},[
			{name: 'pass_user_id', type: 'string', mapping: 'user_id'}
		]),
		items: [{
			layout:'column',
			border:false,
			items:[{
				columnWidth:0.98,
				layout: 'form',
				border:false,
				items: [pass_user_passwdlamaField, pass_user_passwdField, pass_user_passwdulangField ] 
			}]
		}],
		monitorValid:true,
		buttons: [{
				text: 'Save and Close',
				formBind: true,
				handler: updatepass_users
				
			},{
				text: 'Cancel',
				handler: function(){
				// because of the global vars, we can only instantiate one window... so let's just hide it.
				pass_usersWindow.hide();
				mainPanel.remove(mainPanel.getActiveTab().getId());
			}
		}]
		
	});
	
	/* Form Advanced Search */
	pass_usersWindow = new Ext.Window({
		title: 'Ganti Password',
		closable:false,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_pass_users',
		items: pass_userForm
	});
  /* End Function Advanced Search */
	pass_userForm.getForm().load();
  	pass_usersWindow.show();
	
  	
});
	</script>
	<div class="col">
		<div id="elwindow_pass_users"></div>
    </div>
</div>