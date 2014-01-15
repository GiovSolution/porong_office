// JavaScript Document

Ext.BLANK_IMAGE_URL = 'assets/images/s.gif';

//validation vtype
Ext.apply(Ext.form.VTypes, {

	password : function(val, field) {
		if (field.initialPassField) {
			var login = Ext.getCmp(field.initialPassField);
			return (val == login.getValue());
		}
		return true;
	},
//	passwordText : 'Passwords do not match' //alert if you enter a password that is not the same
	passwordText : 'Password tidak sama' //alert if you enter a password that is not the same
});

var usernameField="";
var passwordField="";
var warningField="";
	
Ext.onReady(function(){
	Ext.QuickTips.init();
	
	function authenticate(oGrid_event){
				loginForm.getForm().submit({
					method:'POST',
//					waitTitle:'Please wait.....',
					waitTitle:'Mohon tunggu...',
//					waitMsg:'Authenticate...',
					waitMsg:'Verifikasi...',
					success:function(){
								var redirect = 'index.php?c=main';
								window.location = redirect;
					},
					failure:function(form, action){
						obj = Ext.util.JSON.decode(action.response.responseText);
						if(action.failureType == 'server'){
							Ext.Msg.alert('Server Failed!', 'Authentication server is unreachable : ' + obj.msg);
						} else {
//							Ext.Msg.alert('Login Failed!', obj.msg );
							Ext.Msg.alert('Login gagal', 'Username atau password tidak benar' );
						}
//						loginForm.getForm().reset(); //supaya username & password tidak hilang ketika salah login | by Hendri
					}
				});
	}
	

	
	usernameField=new Ext.form.TextField({
		fieldLabel:'Username',
		name:'username',
		//width:190,
		anchor: '95%',
		allowBlank:false
	});
	
	
	passwordField=new Ext.form.TextField({
			fieldLabel:'Password',
			name:'password',
			//width:190,
			anchor: '95%',
			inputType:'password',
			id: 'pass',
			enableKeyEvents: true,
			allowBlank:false,
			listeners: {
                specialkey: function(field, e){
                    if (e.getKey() == e.ENTER) {
                      //  var form = field.ownerCt.getForm();
                        authenticate();
                    }
                }
            }

	});
	
	infoField=new Ext.form.Label({html:'<center><br/>Tekan tombol <b>F11</b> untuk tampilan full screen<br/></center>'});
	
	warningField=new Ext.form.Label({
			html: '<font color=red>Aplikasi ini dapat berjalan dengan baik di atas browser minimal <a href=\'http://www.mozilla.com\' target=\'_blank\'>Mozilla Firefox 2</a> atau Internet Explorer 7, dengan resolusi terbaik 1024x768 pixel</font>'
	});
	
	var loginForm = new Ext.FormPanel({
		labelWidth:75,
		url:'index.php?c=c_login&m=verify',
		frame:true,
		border: true,
		width:330,
		autoHeight:true,
		margin:50,
		defaultType:'textfield',
		items:[{
			xtype:'box', //create image
			autoEl:{
				tag:'img',
				src:'assets/images/login.png'
			}
		},usernameField
		,passwordField],
		buttonAlign: 'center',
		buttons:[{
			text:'Login',
			handler: authenticate
		},{
			text: 'Reset',
			handler: function(){
//				loginForm.getForm().reset();	//supaya username & password tidak hilang ketika salah login | by Hendri
			}
		}]
});
		
	var createwindow = new Ext.Window({
		frame:true,
//		title:'<center>Login Authentication</center>',
		title:'<center>Silahkan Login</center>',
		width:330,
		height:210,
		closable: false,
		items: [loginForm,infoField]
	});
	
	createwindow.show();
});
