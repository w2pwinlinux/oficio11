// JavaScript Documen
$.extend($.fn.validatebox.defaults.rules, {
	minimo: {//nombre funcion 
		validator: function(value, param){//recibe parametros
			nn = value.length >= param[0];
			console.log(nn)
			return value.length >= param[0];//retorno de valor
		},
		message: 'ingree un numero minimo {0} characters.'//mensaje de la app
	}
});
$.extend($.fn.validatebox.defaults.rules, {	
	iguales: {
	validator: function(value,param){
		return value == $(param[0]).val();
	},
	message: 'campos no iguales'
}
});
$.extend($.fn.validatebox.defaults.rules, {	
	solonumeros: {
	validator: function(value,param){
		if (!/^([0-9])*$/.test(value)){
			nn = false;
		}else{
			nn = true;
		}
		return nn
	},
	message: 'Campo solo numeros'
}
});
    

$.extend($.fn.validatebox.defaults.rules, {  
    iguales: {  
        validator: function(value,param){  
			//console.log(value);
			//console.log(param);
			nn = value == $(param[0]).val();  
			//console.log(nn);
            return nn;
        },  
        message: 'Campos diferentes'  
    }  
}); 

$.extend($.fn.datagrid.defaults.editors, {
        numberspinner: {
            init: function(container, options){
                var input = $('<input type="text">').appendTo(container);
                return input.numberspinner(options);
            },
            destroy: function(target){
                $(target).numberspinner('destroy');
            },
            getValue: function(target){
                return $(target).numberspinner('getValue');
            },
            setValue: function(target, value){
                $(target).numberspinner('setValue',value);
            },
            resize: function(target, width){
                $(target).numberspinner('resize',width);
            }
        }
    });

function myformato(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        }
function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
}
function formatoColor(val,row){
	var rojo = parseInt($("#rojo").val());
	var naranja = parseInt($("#naranja").val());
	var celeste = parseInt($("#celeste").val());
	//console.log(rojo);
	//console.log(naranja);
	//console.log(celeste);
	if (val <= rojo){
		return '<span style="color:red;">('+val+')</span>';
	} else {
		if(val <=naranja){
			return '<span style="color:purple;">('+val+')</span>';
		}else{
			return '<span style="color:grey;">('+val+')</span>';
		}
	}
}

function tiene_evidencia(val,row){
	//console.log(val);
	//console.log(row);
	
	if (val.length>2 ){
		return '<a target="_blank" href="'+val+'"><img src="images/buscar.png" width="32" height="32" alt="sdfas" /></a>';
	} else {
	    return '<span style="color:red;">(SIN EVIDENCIA)</span>';
	}
}

function estadoResolucion(val,row){
        if (val == 0){
            return '<span style="color:yellow;">(INGRESADO)</span>';
        }
		if (val == 1){
            return '<span style="color:brown;">(PROCESADO)</span>';
        }
		if (val >= 2){
            return '<span style="color:green;">(ENVIADO)</span>';
        } 		
		
}
function estadoAsignacionResolucion(val,row){
        if (val == 0){
            return '<span style="color:yellow;">(INGRESADO)</span>';
        }
		if (val == 1){
            return '<span style="color:brown;">(PROCESADO)</span>';
        }
		if (val == 2){
            return '<span style="color:green;">(ENVIADO)</span>';
        } 
		
}

function formatPrice2(val,row){
        if (val < 20){
            return '<span style="color:red;">('+val+')</span>';
        } else {
            return val;
        }
}
function formatoNumero(val,row){
        if (val < 20){
            return '<span style="color:red;">('+val+')</span>';
        } else {
            return val;
        }
}

function tipoMonedaN(val,row){
//	return '<span style="color:blue">USD. '+round(val,2)+'</span>';
	if (val==0){
		return '<span style="color:yellow">USD. '+formatoNumero(val,2,",",".")+'</span>';
	}else{
		if (val>0){
			return '<span style="color:blue">USD. '+formatoNumero(val,2,",",".")+'</span>';
		}else{
			return '<span style="color:red">USD. '+formatoNumero(val,2,",",".")+'</span>';
		}
	}

}

function estadoPOAPAC(val,row){
	if (val==0){
		return '<span style="color:red">NO</span>';
	}else{
		return '<span style="color:blue">SI</span>';
	}

}

function tipoMoneda(val,row){
	if (val>0){
		val = formatoNumero(val,2);
		return '<span style="color:blue">USD. '+val+'</span>';
	}else{
		val = formatoNumero(val,2);
		return '<span style="color:red">USD. '+val+'</span>';
	
	}
}
function url_interna(val,row){
	var nn = '<a href="'+val+'" target="_blank"><img src="images/pdf.png" width="32" height="32" /></a>';
	return nn;
}


function formatoNumero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }
	if (typeof separadorDecimal==="undefined") {
		separadorDecimal = ",";
	}
	if (typeof separadorMiles==="undefined") {
		separadorMiles = ".";
	}


    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}
function comboimagen(row){
			var imageFile = 'images/' + row.ID+".png";
            return '<img class="item-img" src="'+imageFile+'"/><span class="item-text">'+row.NOMBRE+'</span>';        
}
function nnumerico(val){
		if (!/^([0-9])*$/.test(val)){
			nn = "";
		}else{
			nn = val;
		}
		return nn
}
function tipodescarga(val,row){
	//autoriza = row.AUTORIZACION;
	//autoriza = base64_encode(autoriza);
	tipo = val;
	tipo = base64_encode(tipo);
	//mes = row.MES;
	//mes = base64_encode(mes);
	//archivo = base64_encode(row.ARCHIVO);
	id = row.ID;
	id = base64_encode(id);
	//var direccion="jquery/download_retencion.php?nn1="+autoriza+"&nn2="+tipo+"&nn3="+mes+"&nn4="+archivo;
	var direccion="jquery/download_retencion.php?nn1="+id+"&nn2="+tipo;
	
	if (val=="PDF"){
		var nn = '<a href="'+direccion+'" target="_blank"><img src="images/pdf.png" width="32" height="32" /></a>';
	}
	if (val=="XML"){
		var nn = '<a href="'+direccion+'" target="_blank"><img src="images/xml.png" width="32" height="32" /></a>';
	}
	
	return nn;
}
function estadoProyecto(val,row){


	if (val==1){
			var val2 = "INGRESADO";
		return '<span style="color:bordeaux">'+val2+'</span>';
	}
	if (val==2){
		var val2 = "APROBADO";
		return '<span style="color:green">'+val2+'</span>';
	}
	if (val==3){
		var val2 = "APROBADO";
		return '<span style="color:green">'+val2+'</span>';
	}
	
}

function estadoN(val,row){
	if (val==0){
			var val2 = "INGRESADO";
		return '<span style="color:bordeaux">'+val2+'</span>';
	}
	if (val==1){
			var val2 = "APROBADO";
		return '<span style="color:green">'+val2+'</span>';
	}	
	if (val==2){
			var val2 = "APROBADO:.";
		return '<span style="color:green">'+val2+'</span>';
	}	

}

function formatoTexto100(val,row){
	return '<div id="jeasyui-div-formatoTexto" style="color:green;width:auto;height:100px;word-wrap:break-word; border: 1px solid #000000;text­align: justify;">'+val+'</div>';

}
function formatoTexto200(val,row){
	console.log(row);
	console.log(val);
	return '<div style="color:green;height:200px;">'+val+'</div>';

}
function formatoTexto300(val,row){
	console.log(row);
	console.log(val);
	return '<div style="color:green;width:200px;height:300px;word-wrap:break-word;">'+val+'</div>';

}
function infosys(val,row){
	if (val != undefined){
		return '<span style="color:#900">'+val+'</span>';
	}else{
		return '<span style="color:green"></span>';
	}
	
	
}

function tipo_pago(val,row){
	if (val == 1){
		return '<span style="color:#900">EFECTIVO</span>';
	}
	if (val == 2){
		return '<span style="color:#990">CHEQUE</span>';
	}
	if (val == 3){
		return '<span style="color:#999">CTAXCOB</span>';
	}
	if (val == 4){
		return '<span style="color:#CC0">DEPOSITO</span>';
	}
	if (val == 5){
		return '<span style="color:#CCFF">TRANSFERENCIA</span>';
	}
	if (val == 6){
		return '<span style="color:#FF0">TARJETA</span>';
	}
	
	
	
	
}

function seguimiento_avance(val,row){
        if (val <=33){
            return '<div id="avance_rojo" class="avance">'+val+'</div>';
        }
		if (val <=66){
            return '<span id="avance_amarillo" class="avance">'+val+'</div>';
        }
		if (val <=100){
            return '<span id="avance_verde" class="avance">'+val+'</div>';
        } 
		
}

// tamanio del texto 
function dato_size_min(val,row){
	return '<div style="font-size:9px">'+val+'</div>';
}
function dato_size_max(val,row){
	return '<div style="font-size:14px">'+val+'</div>';
}
function dato_size_normal(val,row){
	return '<div style="font-size:11px">'+val+'</div>';
}


// funciones extras 

// nuevas funciones para jeasyui 
function mp(tipo,titulo,cuerpo){
	  titulo = titulo || "ESPERE";
	  cuerpo = cuerpo || "PROCESANDO.....";
	  if (tipo==1){
			$.messager.progress({
			title:titulo,
			msg:cuerpo,
			text:"PROCESANDO......"
			});
				
	  }
	  
	  if (tipo==2){
			$.messager.progress("close");
	  }
}


function ma(titulo,cuerpo){
	  titulo = titulo || "Info";
	  cuerpo = cuerpo || "Datos";
	  $.messager.alert(titulo,cuerpo)				
	  	  
}

function ms(titulo,cuerpo){
	titulo = titulo || "Info";
	cuerpo = cuerpo || "Exitoso";
	$.messager.show({	// show error message
		title: titulo,
		msg: cuerpo
	});
}


function msv1(tipo,dato){
	dato = dato || "Exitoso";
	
	if (tipo==1){

		$.messager.show({title: 'Info',msg: dato});
		
	}
	if (tipo==2){

		$.messager.show({title: 'Warning',msg: dato});
		
	}
	if (tipo==3){

		$.messager.show({title: 'Error',msg: dato});
		
	}
}

function mav1(tipo,dato){
	dato = dato || "Exitoso";
	
	
	if (tipo==1){

		$.messager.alert({title: 'Info',msg: dato});
		
	}

	if (tipo==2){

		$.messager.alert({title: 'Warning',msg: dato});
		
	}
	if (tipo==1){

		$.messager.alert({title: 'Error',msg: dato});
		
	}

}

//2019 
function f_estado_fe(val,row){
	
	if (val==0){
		return '<span style="color:#900;">CREADO</span>';
	}
	if (val==1){
		return '<span style="color:#999">GENERADO XML</span>';
	}
	if (val==2){
		return '<span style="color:#CC0;">FIRMADO</span>';
	}

	if (val==3){
		return '<span style="color:#CCFF;"ENVIADO SRI</span>';
	}
	if (val==4){
		return '<span style="color:green">AUTORIZADO SRI</span>';
	}
	if (val>=5){
		return '<span style="color:green">ENVIADO A CLIENTE / ARCHIVADO</span>';
	}
	
	
}

function periodo_actual(val,row){
    
    return '<div id="avance_verde" class="avance">'+val+'</div>';
        
		
}


function f_estado_deac(val,row){
	
	if (val==0){
		return '<span style="color:#900;">DEFAULT</span>';
	}
	if (val==1){
		return '<span style="color:#999">REGISTRADO / SE PUEDE REALIZAR CAMBIOS</span>';
	}
	if (val==2){
		return '<span style="color:green;">APROBADO/ NO SE PUEDE MODIFICAR</span>';
	}

	if (val>2){
		return '<span style="color:green">APROBADO/ NO SE PUEDE MODIFICAR</span>';
	}
	
	
}

function f_estado_bienes(val,row){
	
	if (val==0){
		return '<span style="color:#900;">INGRESADO</span>';
	}

	if (val>=1){
		return '<span style="color:green">APROBADO</span>';
	}
	
	
}


/** 2021*/
function fontsize8(val,row){
	return '<div style="font-size:8px">'+val+'</div>';
}
function fontsize9(val,row){
	return '<div style="font-size:9px">'+val+'</div>';
}
function fontsize10(val,row){
	return '<div style="font-size:10px">'+val+'</div>';
}


function enlace2021(val,row){
	//console.log(val);
	//console.log(row);
	
	if (val.length>2 ){
		return '<a target="_blank" href="'+val+'"><img src="images/pdf.png" width="32" height="32"  /></a>';
	} else {
	    return '<span style="color:red;">NO</span>';
	}
}


function enlace2021_externo(val,row){
	//console.log(val);
	//console.log(row);
	
	if (val.length>2 ){
		return '<a target="_blank" href="'+val+'"><img src="images/pdf.png" width="32" height="32"  /></a>';
	} else {
	    return '<span style="color:red;">NO</span>';
	}
}

function estado2021(val,row){
	
	if (val==1) return '<span style="color:black;font-size:8px">INGRESADO</span>';
	if (val==2) return '<span style="color:black;font-size:8px">PROCESANDO</span>';
	if (val==3) return '<span style="color:black;font-size:8px">APROBADO</span>';
	if (val==4) return '<span style="color:black;font-size:8px">ARCHIVADO</span</span>';

	
	
}
