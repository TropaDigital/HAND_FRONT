$(document).ready(function () {
    	
	$(".data").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
	$(".data_hora").mask("99/99/9999 99:99");
	$(".data_agenda").mask("9999-99-99 99:99");
	$(".telefone").mask("(99) 9999-9999");
	$(".celular").mask("(99) 99999-9999");
	$(".cpf").mask("999-999-999-99");
	$(".horario").mask("99:99");
	$(".cep").mask("99999-999");
    	
	$('.window').bind('click', function(){
		
		$(this).toggleClass('pe-7s-left-arrow');
		$(this).toggleClass('pe-7s-right-arrow');
		$('#lateral').toggleClass('active');
		$('#central').toggleClass('active');
		
	});
    	
});