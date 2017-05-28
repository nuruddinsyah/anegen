/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 JavaScript: Global
------------------------------------------------------------
*/

var messageTimeout;
var inputChanged = false;
var windowClosedPreventionOpened = false;

$.ajaxSetup({
	error: function(x){
	  if (x.statusText == "abort") return false;
		messageBox("Maaf, sistem tidak dapat menghubungi server. Silakan cek koneksi Internet/LAN Anda, setelah itu refresh halaman ini.", 720);
		
		try{
			hideData("Maaf, sistem tidak dapat menghubungi server. Silakan cek koneksi Internet/LAN Anda, setelah itu refresh halaman ini.", "error");
		}catch(e){}
		
		try{
			$("#resources_list").html("<br><center><i>Maaf, sistem tidak dapat menghubungi server. Silakan cek koneksi Internet/LAN Anda, setelah itu refresh halaman ini.</i></center><br>&nbsp;");
		}catch(e){}
		
		try{
			clearInterval(monitorInt);
		}catch(e){}
		
		return false;
	}
});

$(document).ready(function(){
	closeWindowFirst();
	resizeScreenLock();
	
	$("#message").hide();
	$("#window_closed_prevention").hide();
	
	$("input, select, textarea").focus(function(){
		try{
			if(document.getElementById("message").style.visibility!='hidden'){
				hideMessage();
			}
		}catch(e){}
	});
	
	$(".autoresize").autoResize({
		animate: false,
		extraSpace: 0
	});
	
	$("select").customSelect();
});

$(window).resize(function(){
	resizeScreenLock();
});

function logout(){
	content = "<center><br><font style='position: relative; top: 3px;'>Apakah Anda yakin ingin logout sekarang?</font><br><br><br><input type='submit' value='     Ya     ' onclick=\"location.replace(base_path+'logout');\">&nbsp;<input type='button' value='   Batal   ' onclick='closeWindow();'></center>";
	openWindowContent('', content, 350, 110);
}

function closeWindowFirst(){
	try{
		$("#screen_lock").css("display", "none");
		$("#window").hide();
		$("#screen_lock_calendar").css("display", "none");
		$("#window_calendar").hide();
	}catch(e){}
}

function resizeScreenLock(){
	$("#screen_lock_table").height(1);
	$("#screen_lock_table").width(1);
	$("#screen_lock_calendar_table").height(1);
	$("#screen_lock_calendar_table").width(1);
	
	$("#screen_lock_table").height($(document).height());
	$("#screen_lock_table").width($(document).width());
	$("#screen_lock_calendar_table").height($(document).height());
	$("#screen_lock_calendar_table").width($(document).width());
}

function openWindow(title, url, width, height){
	$("#window").html("<table id=\"window_table\" width=\"100%\" height=\"100%\" cellpadding=\"0px\" cellspacing=\"0px\"><tr><th>"+title+"<div id=\"window_close\" onclick=\"closeWindow();\" title=\"Tutup\"></div></th></tr><tr><td valign=\"top\" style=\"height:"+height+"px;\"><div id='window_loading' style='position: absolute; top: 10px; left: 10px;'><img src=\"" + base_path + "resources/images/icons/loading-alt.gif\" alt=\"Mohon tunggu...\"></div><iframe id=\"window_frame\" src=\""+url+"\" width=\"100%\" height=\"100%\" frameborder=\"0\"></iframe></td></tr></table>");
	
	px = window.scrollX;
	py = window.scrollY;
	
	$("#window").width(width);
	$("#window").css({"margin-left": -Math.floor(width/2) + px});
	$("#window").css({"margin-top": -Math.floor(height/2) + py});
	
	$("#window_loading").show();
	$("#window_loading").css({"left": Math.floor(width/2) - 14});
	$("#window_loading").css({"top": Math.floor(height/2) - 14});
	
	resizeScreenLock();
	$("#screen_lock").css("display", "block");
	$("#window").show();
}

function openWindowContent(title, content, width, height){
	if(title!=''){
		$("#window").html("<table id=\"window_table\" width=\"100%\" height=\"100%\" cellpadding=\"0px\" cellspacing=\"0px\"><tr><th>"+title+"<div id=\"window_close\" onclick=\"closeWindow();\" title=\"Tutup\"></div></th></tr><tr><td valign=\"top\" style=\"height:"+height+"px;\">"+content+"</td></tr></table>");
	}else{
		$("#window").html("<table id=\"window_table_no_title\" width=\"100%\" height=\"100%\" cellpadding=\"0px\" cellspacing=\"2px\"><tr><td valign=\"top\" style=\"height:"+height+"px;\">"+content+"</td></tr></table>");
	}
	
	px = window.scrollX;
	py = window.scrollY;
	
	$("#window").width(width);
	$("#window").css({"margin-left": -Math.floor(width/2) + px});
	$("#window").css({"margin-top": -Math.floor(height/2) + py});
	
	resizeScreenLock();
	$("#screen_lock").css("display", "block");
	$("#window").show();
}

function closeWindow(){
	$("#window_loading").hide();
	$("#window_closed_prevention").hide();
	$("#window_frame").hide();
	$("#window").fadeOut("slow");
	$("#screen_lock").css("display", "none");
	inputChanged = false;
	windowClosedPreventionOpened = false;
}

function resizeWindowWidth(width){
	px = window.scrollX;
	$("#window").width(width);
	$("#window").css({"margin-left": -Math.floor(width/2) + px});
}

function safelyCloseWindow(){
	if(inputChanged){
		showWindowClosedPrevention();
		return;
	}
	
	closeWindow();
}

function showWindowClosedPrevention(){
	window.scroll(0, 0);
	
	if(!windowClosedPreventionOpened){
		$("#window_closed_prevention #back").hide();
		$("#window_closed_prevention").slideDown(220);
		windowClosedPreventionOpened = true;
	}else{
		$("#window_closed_prevention #back").fadeIn(300, function(){
			$("#window_closed_prevention #back").fadeOut(400);
		});
	}
}

function hideWindowClosedPrevention(){
	windowClosedPreventionOpened = false;
	$("#window_closed_prevention").slideUp(150);
}

function setInputChanged(){
	inputChanged = true;
}

function messageBox(message, width){
	content = message + "<br><br><br><center><input type='button' value='      OK      ' onclick='closeWindow();'></center>";
	$("#window").html("<table id=\"window_table_no_title\" cellpadding=\"0px\" cellspacing=\"2px\"><tr><td valign=\"top\" style=\"padding: 20px 40px 20px 40px;\">"+content+"</td></tr></table>");
	
	px = window.scrollX;
	py = window.scrollY;
	
	if(width!=null) $("#window").width(width);
	$("#window").css({"margin-left": -Math.floor($("#window").width()/2) + px});
	$("#window").css({"margin-top": -Math.floor($("#window").height()/2) + py});
	
	resizeScreenLock();
	$("#screen_lock").css("display", "block");
	$("#window").show();
}

function message(pesan, type, timeout){
	window.scroll(0, 0);
	$("#message").html("<table class='messagebox_"+type+"' cellpadding='0px' cellspacing='0px' width='100%'><tr><td>"+pesan+"</td></tr></table><br>");
	$("#message").hide();
	$("#message").fadeIn("slow", function(){
		if(timeout!=null) messageTimeout = setTimeout("hideMessage()", timeout);
	});
}

function hideMessage(){
	$("#message").fadeOut("slow", function(){
		$("#message").hide();
	});
	
	clearTimeout(messageTimeout);
}

function hideData(msg, type){
	if(type==null) type = 'info';
	$("#data").html("<table class='messagebox_" + type + "' cellpadding='0px' cellspacing='0px' width='100%'><tr><td align='center'>" + msg + "</td></tr></table>");
}

function loadData(){
	$("#data").html("<br><center><img src=\"" + base_path + "resources/images/icons/loading-alt.gif\" alt=\"Mohon tunggu...\"></center>");
}

String.prototype.trim = function(){
	a = this.replace(/^\s+/, '');
	return a.replace(/\s+$/, '');
};

String.prototype.reverse = function(){
	tmp = "";
	for(i = this.length - 1; i >= 0; i--) tmp += this.charAt(i);
	return tmp;
};

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

function chooseFile(place, filePlace){
	$("#" + filePlace).trigger("click");
	$("#" + place).blur();
}

function fileChoosed(place, filePlace){
	var val = $("#" + filePlace).val();
	
	if(val == ""){
		$("#" + place).val("Pilih file...");
	}else{
		val = val.replace(/\\/g, "/");
		pieces = val.split("/");
		val = pieces[pieces.length - 1];
		
		$("#" + place).val(val);
	}
}
