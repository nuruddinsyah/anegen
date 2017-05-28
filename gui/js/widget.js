/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 JavaScript: Widget
------------------------------------------------------------
*/

var messageTimeout;

$(document).ready(function(){
	$("#message").hide();
	
	$("input, select, textarea").focus(function(){
		try{
			if(document.getElementById("message").style.visibility!='hidden'){
				hideMessage();
			}
		}catch(e){}
	});
	
	$("input, select, textarea").change(function(){
		parent.setInputChanged();
	});
});

function message(pesan, type, timeout){
	window.scroll(0, 0);
	jspAPI.scrollTo(0, 0);
	
	$("#message").html("<table class='messagebox_"+type+"' cellpadding='0px' cellspacing='0px' width='100%'><tr><td>"+pesan+"</td></tr></table><br>");
	$("#message").hide();
	$("#message").fadeIn("slow", function(){
		if(timeout!=null) messageTimeout = setTimeout("hideMessage()", timeout);
		jspAPI.reinitialise();
	});
}

function hideMessage(){
	$("#message").slideUp("slow", function(){
		$("#message").hide();
		jspAPI.reinitialise();
	});
	
	clearTimeout(messageTimeout);
}

function openCalendar(obj){
	parent.openCalendar(obj);
}

function validateText(text){
	if(text==""){
		return false;
	}else{
		return true;
	}
}

function validateNumber(num){
	num = new Number(num);
	
	if(isNaN(num)){
		return false;
	}else{
		return true;
	}
}

function validateEmail(email){		
	atpos = email.indexOf("@");
	dotpos = email.lastIndexOf(".");
	
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
		return false;
	}else{
		return true;
	}
}
