
	/* PROTOTYPE QUE IMPLEMENTA O METODO inArray IGUAL A PHP */
	Array.prototype.inArray = function (value){
		var i;
		if(this.length){
			for (i=0; i < this.length; i++){
				if (this[i] == value){
					return true;
				}
			}
		}
		return false;
	}

	/* PROTOTYPE REMOVE REGISTRO DO VETOR EM JAVASCRIPT */
	Array.prototype.remove = function(from, to) {
		var rest = this.slice((to || from) + 1 || this.length);
		this.length = from < 0 ? this.length + from : from;
		return this.push.apply(this, rest);
	};	
	
	/* TESTA SE A VARIAVEL EXISTE isset IGUAL A PHP */
	function isset(variableName){
		try{
			if(eval(variableName))blah=1/0;
		}catch(e){
			return false;
		}
		return true;
	}
	
	/* FUNCAO QUE GERENCIA AS ABAS */
	function abrirAba(){
		for(var i=0; i < blocoAbas.length; i++){
			document.getElementById(blocoAbas[i]).style.display = 'none';			
			document.getElementById('aba_'+blocoAbas[i]).className = '';
		}	
		for(var i=0; i < arguments.length; i++){
			document.getElementById(arguments[i]).style.display = '';			
			document.getElementById('aba_'+arguments[i]).className = 'atv';
		}
	}
	
	/* FUNCAO PARA LEADING ZERO */
	function strzero(txt,tama) {
		str='';
		for (var i=1; i<=tama; i++) {
			str+='0';
		}
		str+=txt+'';
		return (str.substr(str.length-tama,tama));
	}


	/* FUNCOES PARA GERENCIAMENTO DE COOKIES (CRIAÇÃO, LEITURA, EXCLUSÃO) */
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

