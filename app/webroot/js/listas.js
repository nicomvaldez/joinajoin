$(document).ready(function() {   

    //select all the a tag with name equal to modal 
    $('a[name=modal]').click(function(e) { 
        //Cancel the link behavior 
        e.preventDefault(); 
        //Get the A tag 
        var id = $(this).attr('href'); 

        //Get the screen height and width 
        var maskHeight = $(window).height()/2; 
        var maskWidth = 830; //$(window).width(); 
     
        //Set height and width to mask to fill up the whole screen 
        $('#mask').css({'width':maskWidth,'height':maskHeight}); 
         
        //transition effect       
        $('#mask').fadeIn(1000);     
        $('#mask').fadeTo("slow",0.8);   
     
        //Get the window height and width 
        var winH = $(window).height()/2; 
        var winW = $(window).width()/2; 
               
        //Set the popup window to center 
        $(id).css('top',  winH/2-$(id).height()/2); 
        $(id).css('left', winW/2-$(id).width()/2); 
     
        //transition effect 
        $(id).fadeIn(2000);   
     
    }); 
     
     
    
    
    //area de horas
    
    
//arreglo principal    
var arreglo = {};

	//modifico todos los txt para que sean ingreso de hora
	//$('[id^=txtTime]').ptTimeSelect();
	$('.txtTime').ptTimeSelect();
	
	//evento al hacer clic en el boton agregar
	$('.btnAgregar').on('click',function(){
		
		$this = $(this);

		var $txtTime = $this.parents('.window').find('#txtTime');
		
		//verificamos que el campo no este vacio
		if($.trim($txtTime.val())!=''){
			//variable para contener la lista html
			var $ulLista;
			
			//si la lista html no existe entonces la agregamos al dom
			if(!$this.parents('.window').find('#divLista ul').length) $this.parents('.window').find('#divLista').append('<ul/>');
			
			//obtenemos una instancia de la lista
			$ulLista = $this.parents('.window').find('#divLista ul');
			
			//creamos el item que va a contener el nombre y el boton eliminar
			var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">&nbsp;</a>'+$.trim($txtTime.val()));
			

			//agregamos el elemento al final de la lista (con append)
			$ulLista.append($liNuevoNombre);

		//el campo nombre esta vacio
		}else{
			//enfocamos el campo para ingresar hora
			$txtTime.focus();
		}
		//limpiamos el campo nombre y lo enfocamos
		$txtTime.val('');
	});
	
	//evento al hacer clic en el boton eliminar de cada item de la lista
	//se debe usar "live", ya que son elementos generados donamicamente
	$('.clsEliminarElemento').live('click',function(){
		//buscamos la lista
		var $ulLista=$('#divLista').find('ul');
		//buscamos el padre del boton (el tag li en el que se encuentra)
		var $liPadre=$($(this).parents().get(0));
		
		//eliminamos el elemento
		$liPadre.remove();
		//si la listaesta vacia entonces la eliminamos del dom
		if($ulLista.find('li').length==0) $ulLista.remove();
	});
	
	//eliminamos los elementos impares en la lista (odd)
	$('#btnEliminarPares').on('click',function(){
		$('#divLista ul li:odd').remove();
	});
	
	//eliminamos los elementos pares en la lista (even)
	$('#btnEliminarImpares').on('click',function(){
		$('#divLista ul li:even').remove();
	});
	
	//eliminamos la lista del dom
	$('#btnEliminarTodo').on('click',function(){
		$('#divLista ul').remove();
	});
	
	
	function dameNombre(nomdia){
		switch(nomdia){
			case 0 : return 'Sunday';break;
			case 1 : return 'Monday';break;
			case 2 : return 'Tuesday';break;
			case 3 : return 'Wednesday';break;
			case 4 : return 'Thursday';break;
			case 5 : return 'Friday';break;
			case 6 : return 'Saturday';break;
			case 9 : return 'All';break;
		}
		
	}
	

	
	$('.btnVerArreglo').on('click',function(){
		var max = 0;
		var i = 0;
		var diaNom='';
		for(i = 0; i <= 6; i++) { 
			if(arreglo[i] != undefined){
				max = arreglo[i].length;
				diaNom = dameNombre(i);
	    		console.log(diaNom);
			    for(j = 0; j <= max; j++) {
			    	if(arreglo[i][j] != undefined){
			        	console.log(arreglo[i][j]);
			       	}
			    }
		   	}
		}		
	});	

	
	
	
	
	
	function clavoArreglo(divDia, nroDia){
		$valores = '';
		for(j = 0; j < arreglo[nroDia].length; j++) {
	    	if(arreglo[nroDia][j] != undefined){
	        	$valores = $valores + arreglo[nroDia][j] + ' ';
	       	}
	    }
	    if(($valores != '')&&($valores != ' ')){
			//muestro el texto
			divDia.html('');
			divDia.html($valores);
			//lo clavo en el txt
			$('#TurnoDetalle'+nroDia).val($valores);
			
			$('#view_hours'+nroDia).html($valores);//nuevos divs
			
			//clavo todo el arreglo en json en php
			$jsonArreglo = JSON.stringify(arreglo, null, 2);
			$('#fullArreglo').val($jsonArreglo);
		}
	}
	
	
	
	
	
	
	
	//Salvamos la lista del dom al arreglo
	$('.btnSalvarArreglo').on('click',function(){
		//que dia cargo
		$dia = parseInt($(this).parents('.window').find('#divInfo').data('dia'));
		$lista = $(this).parents('.window').find('#divLista ul li');
		arreglo[$dia] = [];
		$lista.each(function(indice, elemento) {
  			console.log('El elemento con el indice '+indice+' contiene '+$(elemento).text());
  			arreglo[$dia][indice] = $(elemento).text();
  			
		});
  			//paso el div a poner los datos
  			$divDia = $(this).parents('body').find('.content_hours'+$dia+' .view_hours');
  			clavoArreglo($divDia, $dia);
  			
  			//cierro el popup
  			$(this).parents('#boxes').find('#mask, .window').hide(); 
	});
    
    
    
    
    
    
    
    
    
    
    
    
    
     
     
     
    //if close button is clicked 
    $('.window .close').click(function (e) { 
        //Cancel the link behavior 
        e.preventDefault(); 
        $('#mask, .window').hide(); 
    });       
     
    //if mask is clicked 
    $('#mask').click(function () { 
        $(this).hide(); 
        $('.window').hide(); 
    });           
     
}); 
