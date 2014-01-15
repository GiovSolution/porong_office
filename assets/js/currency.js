// JavaScript Document
Ext.ns('Ext.ux.form');

Ext.ux.form.CFTextField = Ext.extend(Ext.form.TextField,{
    valueRenderer: null,
    initComponent: function(config) {
        Ext.ux.form.CFTextField.superclass.initComponent.apply(this, arguments);
    },
	
    setValue: function(v){
        switch(this.valueRenderer){
            case 'numberToCurrency': v = this.currencyFormat(v); break;
            default: break;
        }
        Ext.ux.form.CFTextField.superclass.setValue.apply(this, [v]); 
    },
	
    getValue: function(){
		//return this.value;
		if(this.value==""){
			return 0;
		}else if(this.value==undefined){
			return 0;
		}else if(this.value!==undefined || isNaN(this.value)){
			var to_number = this.convertToNumber(this.value);
			//return this.value;
			return to_number;
		}else{
			return 0;
		}
    },
	
    currencyFormat: function(v) {
		//-- allows clearing of field value (so that $0.00 only shows if you explicitly entered zero for a value).
		if (v == null||v == ''||isNaN(v)) {
			return '';
		} else if (v > 999999999999) {
			return '';
		} else {
			return Ext.util.Format.rpMoney(v);
		}
	},
	
	convertToNumber: function(v){
		v = v.replace(/,/g,"");
		if (isNaN(v)) 
			return "";
		else{
			var tonumber = new parseFloat(v);
			return tonumber;
		}
	}
});

Ext.reg('CFTextField', Ext.ux.form.CFTextField);

function CurrencyFormatted(number){
	var str = new String(number);
	str = str.replace(/,/g,"");
	if (isNaN(str)) {
		return "0";
	}else{
		var result = "";
		var len = str.length;           
		for(var i=len-1;i>=0;i--)
		{           
			if ((i+1)%3 == 0 && i+1!= len) { 
				//if (str[i] != '.')
					result += ",";
			}
			result += str.charAt(len-1-i);
		}       
		return result;
	}
}

function convertToNumber(str){
	str = str.replace(/,/g,"");
	if(isNaN(str)) {
		return "";
	}else{
		var tonumber = parseFloat(str);
		return tonumber;
	}
}