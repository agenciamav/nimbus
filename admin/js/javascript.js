//cores TR
function Move(obj){
	obj.style.backgroundColor = '#F5f5f5';
}
function Mout(obj, cor){
	obj.style.backgroundColor = cor;
}
// -------------------------------------------------------------------

// writeObj : embed,object ±â¼ú
function CompilaFlash(arq,largura,altura) {
    document.write("<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+largura+"' height='"+ altura +"' id='flash' align='middle' VIEWASTEXT>"+
	 "<param name='allowScriptAccess' value='always' />"+
	 "<param name='movie' value='"+ arq +"' />"+
	 "<param name='quality' value='high' />"+
	 "<param name='wmode' value='transparent' />"+
	 "<param name='menu' value='false' />"+
	 "<embed src='"+ arq +"' quality='high' wmode='transparent' menu='false' width='"+largura+"' height='"+ altura +"' name='flash' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
	"</object>");
}
//-------
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function SemLetras(){
	if ((window.event.keyCode < 48) | (window.event.keyCode > 57)){
		window.event.keyCode = 0
	}
}

function Pula(f){
	if(f.value.length==f.maxLength){
	for(var i=0;i<f.form.length;i++){
		if(f.form[i]==f){f.form[i+1].focus();break}
		}
	}
}

// mascaras para campos
// chamada: onKeypress="return mascara(this, '99.99999999', event);"
function mascara(campo, sMask, evtKeyPress) {
	var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
 
	if(document.all) { // Internet Explorer
		nTecla = evtKeyPress.keyCode;
	} else if(document.layers) { // Nestcape
		nTecla = evtKeyPress.which;
	} else {
		nTecla = evtKeyPress.which;
		if (nTecla == 8) {
			return true;
		}
	}
 
	sValue = campo.value;
	// Limpa todos os caracteres de formatação que
	// já estiverem no campo.
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( ":", "" );
	sValue = sValue.toString().replace( ":", "" );
	fldLen = sValue.length;
	mskLen = sMask.length;
	 
	i = 0;
	nCount = 0;
	sCod = "";
	mskLen = fldLen;
	 
	while (i <= mskLen) {
		bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ":") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
		bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
	 
		if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++;
		} else {
			sCod += sValue.charAt(nCount);
			nCount++;
		}
		i++;
	}
	 
	campo.value = sCod;
	if (nTecla != 8) { // backspace
		if (sMask.charAt(i-1) == "9") { // apenas números...
			return ((nTecla > 47) && (nTecla < 58)); } // números de 0 a 9
		else { // qualquer caracter...
			return true;
		}
	} else {
		return true;
	}
}
//fim mascaras campos

function correctPNG() {
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters)) {
      for(var i=0; i<document.images.length; i++) {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG") {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}
//window.attachEvent("onload", correctPNG);

function relogio(){
	momentoAtual = new Date();
	hora = momentoAtual.getHours();
	minuto = momentoAtual.getMinutes();
	segundo = momentoAtual.getSeconds();

	str_segundo = new String (segundo);
	if (str_segundo.length == 1) {
	   segundo = "0" + segundo;
	}
	str_minuto = new String (minuto);
	if (str_minuto.length == 1) {
	   minuto = "0" + minuto;
	}
	str_hora = new String (hora);
	if (str_hora.length == 1) {
	   hora = "0" + hora;
	}
	// hora : minuto : segundo
	//horaImprimivel = hora + " : " + minuto + " : " + segundo;
	// hora : minuto
	horaImprimivel = hora + " : " + minuto + " : " + segundo;

	document.getElementById('relogio').innerHTML = horaImprimivel;

	setTimeout("relogio()",1000);
} 	



// FUNÇÕES PARA ATIVAR E DESATIVAR LIGHTBOX
function lightbox_disable() {
	document.getElementById('fade').style.display = 'none';
	document.getElementById('light').style.display = 'none';
}

function lightbox_enable() {
	document.getElementById('fade').style.display = 'block';
	document.getElementById('light').style.display = 'block';
}

function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

// MARCAR TODOS OS CHECKBOX DO CAMPO NAME="EXCLUIR" 
function checkAll(cont) {
	var formulario = document.getElementById('formExc');
	var checar = document.getElementById('checar');
	
	if (cont == 0){   
		for (var i=0; i<formulario.elements.length; i++) {
			var x = formulario.elements[i];
			if (x.name == 'excluir[]') {
				x.checked = '';
			}
		}
		cont = 1;
		checar.innerHTML = '<a href="#" onClick="checkAll('+ cont +')">&#8250; Marcar todos</a>';
	} else {
		for (var i=0; i<formulario.elements.length; i++) {
			var x = formulario.elements[i];
			if (x.name == 'excluir[]') {
				x.checked = 'checked';
			}
		}
		cont = 0;
		checar.innerHTML = '<a href="#" onClick="checkAll('+ cont +')">&#8250; Desmarcar todos</a>';
	}
} 


// JAVASCRIPTS DOS MODULOS DO SISTEMA

// modulos
function modulos(form) {
	if (form.nome.value=='') {
		alert('Preencha corretamente o campo nome!');
		form.nome.focus();
		return false;
	}
}

// usuarios
function usuarios(form) {
	if (form.nome.value=='') {
		alert('Preencha corretamente o campo nome!');
		form.nome.focus();
		return false;
	}
	if (form.login.value=='') {
		alert('Preencha corretamente o campo login!');
		form.login.focus();
		return false;
	}
	if (form.validar_senha.value == '1') {
		if (form.senha.value=='') {
			alert('Preencha corretamente o campo senha!');
			form.senha.focus();
			return false;
		}
		if (form.confirmar_senha.value=='') {
			alert('Preencha corretamente o campo confirmar senha!');
			form.confirmar_senha.focus();
			return false;
		}
		if (form.senha.value != form.confirmar_senha.value) {
			alert('A confirmação da senha não confere com a senha!');
			form.senha.value = '';
			form.confirmar_senha.value = '';
			form.senha.focus();
			return false;
		}
	}
}
function inscricao(form) {
	if (form.nome.value=='') {
		alert('Preencha corretamente o campo nome!');
		form.nome.focus();
		return false;
	}
	if (form.email.value=='') {
		alert('Preencha corretamente o campo e-mail!');
		form.login.focus();
		return false;
	}
}

function abreAlteraSenha() {
	document.getElementById('formularioSenha').style.display = 'block';
	document.getElementById('validar_senha').value = '1';
	document.getElementById('alterarSenha').innerHTML = '<strong><a href="javascript: fechaAlteraSenha()">&laquo;&nbsp;Alterar senha</a></strong>';
}
function fechaAlteraSenha() {
	document.getElementById('formularioSenha').style.display = 'none';
	document.getElementById('validar_senha').value = '0';
	document.getElementById('alterarSenha').innerHTML = '<strong><a href="javascript: abreAlteraSenha()">&raquo;&nbsp;Alterar senha</a></strong>';
}

// Modulo Midia
function validaFormModuloMidia(form){
	erro = "Preencha todos os campos do formulário!";
	if ((form.nome.value == "")||(form.texto.value == "")||(form.tempo.value == "")) {
		alert(erro);
		return false;
	}
	if ((form.arquivo.value == "") && (form.arquivo_x.value == "")) {
		alert(erro);
		return false;
	}
	//valida extensao permitida
	if (form.arquivo.value != "") {
		  var arq = form.arquivo.value;
		  var caminho = arq.toLowerCase();
		  var a_caminho = caminho.split("\\");
		  var n_a_caminho = a_caminho.length;
		  var arquivo = a_caminho[n_a_caminho-1];
		  var a_arquivo = arquivo.split(".");
		  var n_a_arquivo = a_arquivo.length;
		  var extensao = a_arquivo[n_a_arquivo-1];
		  if ((extensao != "jpg") && (extensao != "png") && (extensao != "flv")) {
			  alert("Não são aceitos arquivos com extensão '"+extensao+"' somente com extensão 'gif','jpg' e 'jpeg'!");
			  return false;
		  }
	}
}
