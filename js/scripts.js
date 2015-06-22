$(document).ready(function() {

	// VERIFICA QUAL SERVIDO ESTÁ SENDO USADO
	var server = document.domain;
	if (server == '192.168.0.66'){
		caminhoUrl = 'http://'+server+'/Nimbus/2015/site';
	} else {
		caminhoUrl = 'http://'+server;
	}
 /******************************************************************************************************************************/

	// action button
	// ir para home 
	$('#logo').click(function() {
		var novaURL = caminhoUrl;
		$(window.document.location).attr('href',novaURL);
	});
	// link interno
	$('.linkInterno').click(function() {
		var novaURL = $(this).attr('rel');
		$(window.document.location).attr('href',caminhoUrl+novaURL);
	});
	// link externo
	$('.linkExterno').click(function() {
		var novaURL = $(this).attr('rel');
		window.open(novaURL);
	});
	// mailto
	$(".mailTo").live("click", function () {
		var mailto = $(this).attr('rel');
		$(window.document.location).attr('href',"mailto:"+mailto);
	});

 /*****************************************************************************************************************************/

	// action automatica
	// efeito menus
	$(".overBtn").hover(
		function() { $(this).stop().animate({"opacity": "0"}, 100); },
		function() { $(this).stop().animate({"opacity": "1"}, 1000); }
	);
	
	// mascaras com controle do prefixo mais 9 de SP
	 $('.fone').mask('(00) 0000-0000', 
		{onKeyPress: function(phone, e, currentField, options){
		 var new_sp_phone = phone.match(/^(\(11\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone2 = phone.match(/^(\(12\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone3 = phone.match(/^(\(13\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone4 = phone.match(/^(\(14\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone5 = phone.match(/^(\(15\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone6 = phone.match(/^(\(16\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone7 = phone.match(/^(\(17\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone8 = phone.match(/^(\(18\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone9 = phone.match(/^(\(19\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone10 = phone.match(/^(\(21\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone11 = phone.match(/^(\(22\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone12 = phone.match(/^(\(24\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone13 = phone.match(/^(\(27\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone14 = phone.match(/^(\(28\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone15 = phone.match(/^(\(91\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone16 = phone.match(/^(\(92\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone17 = phone.match(/^(\(93\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone18 = phone.match(/^(\(94\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone19 = phone.match(/^(\(95\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone20 = phone.match(/^(\(96\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone21 = phone.match(/^(\(97\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone22 = phone.match(/^(\(98\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 var new_sp_phone23 = phone.match(/^(\(99\) 9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g);
		 new_sp_phone || new_sp_phone2 || new_sp_phone3 || new_sp_phone4 || new_sp_phone5 || new_sp_phone6 || new_sp_phone7 || new_sp_phone8 || new_sp_phone9 || new_sp_phone10 || new_sp_phone11 || new_sp_phone12 || new_sp_phone13 || new_sp_phone14 || new_sp_phone15 || new_sp_phone16 || new_sp_phone17 || new_sp_phone18 || new_sp_phone19 || new_sp_phone20 || new_sp_phone21 || new_sp_phone22 || new_sp_phone23 ? $(currentField).mask('(00) 00000-0000', options) : $(currentField).mask('(00) 0000-0000', options)
	   }
	 });

	if($.browser.msie == true && $.browser.version != '10.0') {
		// placeholder IE
		$(".placeholder[placeholder], .placeHNews[placeholder]").each(
		function(){
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
				$(this).val($(this).attr("placeholder"));
				$(this).focus(function(){
					if($(this).val()==$(this).attr("placeholder")) $(this).val("");
				});
				$(this).blur(function(){
					if($(this).val()=="") $(this).val($(this).attr("placeholder"));
				});
			}
		});
	}
	
 /*****************************************************************************************************************/

	// carregar biblioteca
	// jqtransform
	$('#formBuscaSelect').jqTransform();

	// fancybox ampliar imgs
	$(".ampliar").fancybox({
		padding: 0,
		mouseWheel: true,
		helpers: {
			overlay: {
				speedIn: 0,
				speedOut: 300,
				opacity: 0.8,
				css: {
					cursor: 'pointer'
				},
				closeClick: true
			},
			title: {
				type: 'inside' // 'float', 'inside', 'outside' or 'over'
			}
		}
	});
		
 /*****************************************************************************************************************/
	
});
// vericacao form  
// form fale conosco
function contact(){
	validateContact('formFaleCon');
	if(validateState){
		document.formFaleCon.action = caminhoUrl+'/inc/controle.php?acao=contact';
		document.formFaleCon.submit();
	}
} 


/* stick carousel - obras */
$(document).ready(function(){
  $('.your-class').slick({
    setting-name: setting-value
  });
});

/* formulário */
$(document).ready(function(){ 
    $('#characterLeft').text('140 characters left');
    $('#message').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');            
        }
    });    
});
