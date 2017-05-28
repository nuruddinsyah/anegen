/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 JavaScript: Calendar
------------------------------------------------------------
*/

var month_names = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
var day_names = new Array("M", "S", "S", "R", "K", "J", "S");

var year, month, day;
var object;

var tmp_year;

function openCalendar(obj){
	object = obj;
	s_date = $(obj).val();
	
	initCalendar(s_date);
	showCalendar();
}

function changeYear(){
	new_year = parseInt($("#tahun").val());
	if(isNaN(new_year)) new_year = tmp_year;
	
	tmp_year = new_year;
	
	showCalendar();
}

function nextYear(){
	tmp_year++;
	showCalendar();
}

function previousYear(){
	tmp_year--;
	showCalendar();
}

function assignDate(y, m, d){
	m++;
	
	if(m<10) m = "0" + m;
	if(d<10) d = "0" + d;
	
	s_date = y + "-" + m + "-" + d;
	
	$(object).val(s_date);
	setInputChanged();
	closeCalendar();
	$(object).trigger('change');
}

function showCalendar(){
	str_result = "<div id='calendar_container_x'>";
	
	str_result += "<center>";
	str_result += "Tahun: &nbsp;";
	str_result += "<input type='text' id='tahun' value='" + tmp_year + "' style='width: 50px; text-align: center;'>&nbsp;&nbsp;";
	str_result += "<input type='button'  value=' Ganti ' onclick=\"changeYear();\">";
	str_result += "<br></center>";
	
	str_result += "<div id=\"calendar_next\" title=\"Tahun "+ (tmp_year+1) +"\" onclick=\"nextYear();\"></div>";
	str_result += "<div id=\"calendar_previous\" title=\"Tahun "+ (tmp_year-1) +"\" onclick=\"previousYear();\"></div>";
	
	str_result += "<table class='calendar_table_yearly' cellspacing='0px' cellpadding='5px'><tr valign='top'>";
	l = 0;
	for(k=1; k<=12; k++){
		if(l==4){
			str_result += "</tr><tr valign='top'>";
			l = 0;
		}
		
		if(k-1==month && tmp_year==year){		
			str_result += "<td class='td_focused'>" + month_names[k-1] + " " + tmp_year + "<br>" + createCalendar(tmp_year, k-1) + "</td>";
		}else{
			str_result += "<td>" + month_names[k-1] + " " + tmp_year + "<br>" + createCalendar(tmp_year, k-1) + "</td>";
		}
		
		l++;
	}
	
	str_result += "</tr></table></div>";
	
	openWindowCalendar(str_result);
}

function initCalendar(s_date){
	pieces = new Array();
	pieces = s_date.split("-");
	
	year = new Number(pieces[0]);
	month = new Number(pieces[1])-1;
	day = new Number(pieces[2]);
	
	date = new Date();
	if(isNaN(year)) year = date.getFullYear();
	if(isNaN(month)) month = date.getMonth();
	if(isNaN(day)) day = date.getDate();
	
	if(month>11){
		month = 0;
		year++;
	}
	if(month<0){
		month = 11;
		year--;
	}
	
	tmp_year = year;
}

function createCalendar(v_year, v_month){
	str = '<div class="calendar_container">';
	
	str += '<table class="calendar_table" cellspacing="1px" cellpadding="0px"><tr id="calendar_table_header_tr" onmousedown="return false;">';
	for (i=0; i<7; i++){
		str += "<td id='calendar_table_header_td'>" + day_names[i] + "</td>";
	}
	str += "</tr>";
	
	var firstDay = new Date(v_year, v_month, 1).getDay();
	var lastDay = new Date(v_year, v_month + 1, 0).getDate();
	
	str += "<tr id='calendar_table_tr'>";
	
	dayInWeek = 0;
	
	for (i=0; i<firstDay; i++){
		str += "<td id='calendar_table_td_disabled'>&nbsp;</td>";
		dayInWeek++;
	}
	
	for (i=1; i<=lastDay; i++){
		if(dayInWeek==7){
			str += "</tr><tr id='calendar_table_tr'>";
			dayInWeek = 0;
		}
		if(i==day && v_month==month && v_year==year){
			style = 'id="calendar_table_td_selected"';
		}else{
			style = 'id="calendar_table_td"';
		}
		str += "<td "+style+" onclick=\"assignDate("+v_year+", "+v_month+", "+i+");\">"+i+"</td>";
		dayInWeek++;
	}
	
	for(i=dayInWeek; i<7; i++){
		str += "<td id='calendar_table_td_disabled'>&nbsp;</td>";
	}
	
	str += "</tr></table></div>";
	
	return str;
}

function openWindowCalendar(content){
	resizeScreenLock();
	$("#screen_lock_calendar").css("display", "block");
	
	$("#window_calendar").html("<table id=\"window_table_calendar\" cellpadding=\"0px\" cellspacing=\"2px\"><tr><td valign=\"top\">"+content+"</td></tr></table>");
	
	px = window.scrollX;
	py = window.scrollY;
	
	$("#window_calendar").css({"margin-left": -Math.floor($("#window_calendar").width()/2) + px});
	$("#window_calendar").css({"margin-top": -Math.floor($("#window_calendar").height()/2) + py});
	
	$("#window_calendar").show();
}

function closeCalendar(){
	$("#window_calendar").hide();
	$("#screen_lock_calendar").css("display", "none");
}
