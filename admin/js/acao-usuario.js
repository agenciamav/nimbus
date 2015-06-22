// JavaScript Document
$(document).ready(function() {
	// quando clica no checkbox do modulo marca todas as ações e desmarca todas
	$('.inputCheckbox').click(function() {
		initialValue = $(this).attr('value');
		if(this.checked == true){
			for (i=1; i<4; i++){
				$("input[type=checkbox].marcar"+i+"_"+initialValue).each(function() {
					this.checked = true;
				});
			}
		} else {
			for (i=1; i<4; i++){
				$("input[type=checkbox].marcar"+i+"_"+initialValue).each(function() {
					this.checked = false;
				});
			}
		}
	});
	// quando clica em adicionar marca a edição e o modulo, desmarcando somente a edição
	$('.marcaEdicao').click(function() {
		idModulo = $(this).attr('rel');
		//alert(initialValue2);
		if(this.checked == true){
			$("input[type=checkbox].marcar2_"+idModulo).each(function() {
				this.checked = true;
			});
			$("input[type=checkbox]#permissoes_"+idModulo).each(function() {
				this.checked = true;
			});
		} else {
			$("input[type=checkbox].marcar2_"+idModulo).each(function() {
				this.checked = false;
			});
		}
	});
	// quando clica em editar ou excluir marca o modulo
	$('.marcaModuloExcluir, .marcaModuloEditar').click(function() {
		idModulo = $(this).attr('rel');
		if(this.checked == true){
			$("input[type=checkbox]#permissoes_"+idModulo).each(function() {
				this.checked = true;
			});
		} 
	});
	// quando clica em editar se estiver marcado o adicionar é desmarcado
	$('.marcaModuloEditar').click(function() {
		idModulo = $(this).attr('rel');
		if(this.checked == false){
			$("input[type=checkbox].marcar1_"+idModulo).each(function() {
				this.checked = false;
			});
		} 
	});
});

