<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Library: Global
------------------------------------------------------------
*/

function logged_in(){
	if(get_id_login()){
		return true;
	}else{
		return false;
	}
}

function require_login(){
	if(!logged_in()){
		redirect('login/?required');
		exit();
	}
}

function identify(){
	require_login();
	
	$args_num = func_num_args();
	$args = func_get_args();
	$match = false;
	
	for($i = 0; $i < $args_num; $i++){
		if($args[$i] == get_role()){
			$match = true;
			break;
		}
	}
	
	if(!$match){
		include(BASE_PATH . 'core/errors/forbidden.php');
		exit();
	}
}

function get_id_login(){
	return isset($_SESSION['ekamitra_id_login']) ? $_SESSION['ekamitra_id_login'] : false;
}

function get_role(){
	return isset($_SESSION['ekamitra_user_role']) ? $_SESSION['ekamitra_user_role'] : false;
}

function get_account(){
	return isset($_SESSION['ekamitra_account']) ? $_SESSION['ekamitra_account'] : false;
}

function get_title(){
	return $GLOBALS['title'];
}

function get_config(){
	return isset($_SESSION['ekamitra_config']) ? $_SESSION['ekamitra_config'] : false;
}

function lang(){
	$args_num = func_num_args();
	$args = func_get_args();
	
	$text = $args[0];

	if($args_num > 1){
		for($i = 1; $i < $args_num; $i++){
			$text = preg_replace('/%s/', $args[$i], $text, 1);
		}
	}
	
	return $text;
}

function load_header($title, $show_execution_frame = false){
	if($title == ''){
		$title = SYSTEM_NAME;
	}else if($title == '(auto)'){
		$title = get_title_auto($menu_focus, $submenu_focus) . ' - ' . SYSTEM_NAME;
	}else{
		$title = SYSTEM_NAME . ' - ' . $title;
	}
	
	if($show_execution_frame) define('SHOW_IFRAME', true); else define('SHOW_IFRAME', false);
	include(BASE_PATH . 'pages/header.php');
}

function load_header2($title, $menu_focus, $submenu_focus, $show_execution_frame = false){
	if($title == ''){
		$title = SYSTEM_NAME;
	}else if($title == '(auto)'){
		$title = get_title_auto($menu_focus, $submenu_focus) . ' - ' . SYSTEM_NAME;
	}else{
		$title = $title . ' - ' . SYSTEM_NAME;
	}
	
	$menu = get_menu($menu_focus, $submenu_focus);
	$menu_tab = get_menu_tab($menu_focus, $submenu_focus);
	
	if($show_execution_frame) define('SHOW_IFRAME', true); else define('SHOW_IFRAME', false);
	include(BASE_PATH . 'core/pages/header.php');
}

function load_footer(){
	include(BASE_PATH . 'pages/footer.php');
}

function load_widget($show_execution_frame = false){
	if($show_execution_frame) define('SHOW_IFRAME', true); else define('SHOW_IFRAME', false);
	include(BASE_PATH . 'pages/widget.php');
}

function get_title_auto($menu_focus, $submenu_focus){
	include(BASE_PATH . 'core/menus/' . get_role() . '.php');
	
	$menu_focus_label = '';
	$submenu_focus_label = '';
	
	foreach($menu as $m){
		$id = $m[0];
		$label = $m[2];
		$submenu = $m[3];
		
		if($id == $menu_focus){
			$menu_focus_label = $label;
		}
		
		if(count($submenu) > 0){
			foreach($submenu as $s){
				$sid = $s[0];
				$slabel = $s[2];
				
				if($sid == $submenu_focus && $id == $menu_focus){
					$submenu_focus_label = $slabel;
				}
			}
		}
	}
	
	if($submenu_focus_label != ''){
		return $menu_focus_label . ' - ' . $submenu_focus_label;
	}else{
		return $menu_focus_label;
	}
}

function get_menu($menu_focus, $submenu_focus){
	include(BASE_PATH . 'core/menus/' . get_role() . '.php');
	$menu_tmp = '';
	
	foreach($menu as $m){
		$id = $m[0];
		$label = $m[2];
		$submenu = $m[3];
		
		if($m[1] == '#' || substr($m[1], 0, 11) == 'javascript:'){
			$url = $m[1];
		}else{
			$url = bp() . $m[1];
		}
		
		if($id == $menu_focus){
			if(count($submenu) == 0) $menu_tmp .= "<li><a href=\"$url\" class=\"focused\">$label</a>"; else $menu_tmp .= "<li><a href=\"$url\" class=\"sub-focused\">$label</a>";
		}else{
			if(count($submenu) == 0) $menu_tmp .= "<li><a href=\"$url\">$label</a>"; else $menu_tmp .= "<li><a href=\"$url\" class=\"sub\">$label</a>";
		}
		
		if(count($submenu) > 0){
			$menu_tmp .= "<ul>";
			
			foreach($submenu as $s){
				$sid = $s[0];
				$slabel = $s[2];
				
				if(substr($s[1], 0, 11) == 'javascript:'){
					$surl = $s[1];
				}else{
					$surl = bp() . $s[1];
				}
				
				if($sid == $submenu_focus && $id == $menu_focus){
					$menu_tmp .= "<li><a href=\"$surl\" class=\"focused\">$slabel</a></li>";
				}else{
					$menu_tmp .= "<li><a href=\"$surl\">$slabel</a></li>";
				}
			}
			
			$menu_tmp .= "</ul>";
		}
		
		$menu_tmp .= "</li>";
	}
	
	return $menu_tmp;
}

function get_menu_tab($menu_focus, $submenu_focus){
	include(BASE_PATH . 'core/menus/' . get_role() . '.php');
	$menu_tmp = ''; $mt = array();
	
	foreach($menu as $m){
		if($m[0] == $menu_focus){
			$mt = $m;
			break;
		}
	}
	
	if($mt){
		if(count($mt[3]) > 0){
			foreach($mt[3] as $s){
				$sid = $s[0];
				$slabel = $s[2];
				
				if(substr($s[1], 0, 11) == 'javascript:'){
					$surl = $s[1];
				}else{
					$surl = bp() . $s[1];
				}
				
				if($sid == $submenu_focus){
					$menu_tmp .= "<a href=\"$surl\" class=\"focused\">$slabel</a>";
				}else{
					$menu_tmp .= "<a href=\"$surl\">$slabel</a>";
				}
			}
		}else{
			$id = $mt[0];
			$label = ($id != 'home') ? $mt[2] : 'Selamat datang!';
			$submenu = $mt[3];
			
			if(substr($mt[1], 0, 11) == 'javascript:'){
				$url = $mt[1];
			}else{
				$url = bp() . $mt[1];
			}
			
			$menu_tmp .= "<a href=\"$url\" class=\"focused\">$label</a>";
		}
	}
	
	return $menu_tmp;
}

function create_calendarbox($name, $date = '', $parent = false, $attributes = ''){
	if($date==''){
		$date = date_time('Y-m-d');
	}
	
	if($parent){
		$parent = 'parent.';
	}else{
		$parent = '';
	}
	
	return "<input type='text' name='$name' id='$name' class='calendar' value='$date' readonly onclick=\"" . $parent . "openCalendar(this); this.blur();\" " . $attributes . " />";
}

function create_tab_list($id = array(), $labels = array(), $focus = ''){
	if($focus=='') $focus = $id[0];
	
	$content = '<table class="tab_table" cellpadding="0px" cellspacing="0px" style="width:100%;"><tr><td id="tab_item_left" nowrap style="width:15px;">&nbsp;</td>';
	
	for($i=0; $i<count($id); $i++){
		if($focus==$id[$i]){
			$content .= '<td id="tab_' . $id[$i] . '" class="tab_item_focus" nowrap onclick="tab(\'' . $id[$i] . '\');">' . $labels[$i] . '</td>';
		}else{
			$content .= '<td id="tab_' . $id[$i] . '" class="tab_item" nowrap onclick="tab(\'' . $id[$i] . '\');">' . $labels[$i] . '</td>';
		}
	}
	
	$content .= '<td id="tab_item_right" nowrap width="100%">&nbsp;</td></tr><tr><td id="tab_item_bottom" colspan="4">&nbsp;</td></tr></table>';
	
	$script = '<script language="javascript">';
	$script .= 'function untab(){';
	
	for($i=0; $i<count($id); $i++){
		$script .= '$("#tab_' . $id[$i] . '").attr("class", "tab_item");';
		$script .= '$("#div_' . $id[$i] . '").css("display", "none");';
	}
	
	$script .= '}function tab(id){untab(); $("#tab_"+id).attr("class", "tab_item_focus"); $("#div_"+id).css("display", "block");} $(document).ready(function(){tab("' . $focus . '");});</script>';
	
	return $content . $script;
}

function action($file_name, $function = '', $print = true){
	$actions_dir = ACTIONS_DIR;
	$result = '';
	
	if($function == ''){
		$result = $actions_dir . $file_name . '.php';
	}else{
		$result = $actions_dir . $file_name . '.php?function=' . $function;
	}
	
	if($print){
		echo $result;
	}else{
		return $result;
	}
}

function get_gender($gender){
	$g = trim(strtolower($gender));
	
	if($g == 'l'){
		return 'Laki-laki';
	}else{
		return 'Perempuan';
	}
}

function get_account_data_from_id($id, $role){
	$result = $GLOBALS['db']->get_single_record("select * from login where id_user = '$id' and role = '$role'");
	return $result;
}

function get_account_data_from_username($username){
	$result = $GLOBALS['db']->get_single_record("select * from login where username = '$username'");
	return $result;
}

function get_saldo($pelanggan){
	$data = $GLOBALS['db']->get_single_record("select sum(debit) as debit, sum(kredit) as kredit from saldo_pelanggan where id_pelanggan = '$pelanggan'");
	
	if($data){
		return $data['debit'] - $data['kredit'];
	}else{
		return 0;
	}
}

function get_deposit($loket){
	$data = $GLOBALS['db']->get_single_record("select sum(debit) as debit, sum(kredit) as kredit from deposit_loket where id_loket = '$loket'");
	
	if($data){
		return $data['debit'] - $data['kredit'];
	}else{
		return 0;
	}
}

function get_denda($pelanggan, $periode){
	$periode_now_m = date_time('m');
	$periode_now_d = date_time('d');
	$periode_m = date_time('m', $periode);
	
	$bulan = $periode_now_m - $periode_m;
	if($periode_now_d <= 20) $bulan--;
	
	if($bulan >= 1){
		$tagihan = $GLOBALS['db']->get_single_record("select * from pemakaian_air where id_pelanggan = '$pelanggan' and periode = '$periode'");
		
		if($tagihan['tunggakan'] * 1 != 0){
			$denda_1 = $tagihan['biaya_denda_1'] * 1;
			$denda_2 = $tagihan['biaya_denda_2'] * 1;
			$denda_3 = $tagihan['biaya_denda_3'] * 1;
			
			if($bulan >= 4){
				$denda = $denda_1 + $denda_2 + $denda_3;
			}else if($bulan >= 3){
				$denda = $denda_1 + $denda_2 + $denda_3;
			}else if($bulan >= 2){
				$denda = $denda_1 + $denda_2;
			}else if($bulan >= 1){
				$denda = $denda_1;
			}
			
			return array('bulan' => $bulan, 'denda' => $denda);
		}else{
			return array('bulan' => 0, 'denda' => 0);
		}
	}else{
		return array('bulan' => 0, 'denda' => 0);
	}
}

function get_pemasukan($unit, $hari){
	//return rand() * 100;
	$data = $GLOBALS['db']->get_single_record("select sum(total_tagihan) as pemasukan from pemakaian_air where id_pelanggan in (select id_pelanggan from pelanggan where id_unit = '$unit') and tunggakan = '0' and date(tanggal_eksekusi) = date('$hari')");
	return $data['pemasukan'] * 1;
}

function get_pengeluaran($unit, $hari){
	//return rand() * 100;
	$data = $GLOBALS['db']->get_single_record("select sum(biaya) as pengeluaran from biaya_operasional where id_unit = '$unit' and date(tanggal) = date('$hari')");
	return $data['pengeluaran'] * 1;
}

function formatted_date_time($date_time){
	$date = date_time('Y-m-d', $date_time);
	$time = date_time('g:i A', $date_time);
	
	$day_interval = get_age($date, 'ds');
	
	if($day_interval == 0){
		return 'Today, ' . $time;
	}else if($day_interval == 1){
		return 'Yesterday, ' . $time;
	}else if($day_interval > 1 && $day_interval <= 6){
		return date_time('l', $date_time) . ', ' . $time;
	}else{
		return date_time('l, j F Y - g:i A', $date_time);
	}
}

function clear_temporary_files($tmp_dir = ''){
	if($tmp_dir=='') $tmp_dir = BASE_PATH . 'core/tmp';
	
	$files = list_file_any_ext($tmp_dir);
	foreach($files as $file){
		delete_file($tmp_dir . '/' . $file);
	}
}

function terbilang_ke_kata($x){
	$x = abs($x);
	$angka = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
	$temp = '';
	
	if($x<12){
		$temp = ' ' . $angka[$x];
	}else if($x<20){
		$temp = terbilang_ke_kata($x-10) . ' belas';
	}else if($x<100){
		$temp = terbilang_ke_kata($x/10) . ' puluh' . terbilang_ke_kata($x%10);
	}else if($x<200){
		$temp = ' seratus' . terbilang_ke_kata($x-100);
	}else if($x<1000){
		$temp = terbilang_ke_kata($x/100) . ' ratus' . terbilang_ke_kata($x%100);
	}else if($x<2000){
		$temp = ' seribu' . terbilang_ke_kata($x-1000);
	}else if($x<1000000){
		$temp = terbilang_ke_kata($x/1000) . ' ribu' . terbilang_ke_kata($x%1000);
	}else if($x<1000000000){
		$temp = terbilang_ke_kata($x/1000000) . ' juta' . terbilang_ke_kata($x%1000000);
	}else if($x<1000000000000){
		$temp = terbilang_ke_kata($x/1000000000) . ' milyar' . terbilang_ke_kata(fmod($x, 1000000000));
	}else if($x<1000000000000000){
		$temp = terbilang_ke_kata($x/1000000000000) . ' trilyun' . terbilang_ke_kata(fmod($x, 1000000000000));
	}
	
	return $temp;
}

function terbilang($x, $style = 'ucfirst'){
	if($x<0){
		$hasil = 'minus ' . trim(terbilang_ke_kata($x));
	}else{
		$hasil = trim(terbilang_ke_kata($x));
	}
	
	switch($style){
		case 'uppercase': case 1:
			$hasil = strtoupper($hasil);
			break;
		case 'lowercase': case 2:
			$hasil = strtolower($hasil);
			break;
		case 'ucwords': case 3:
			$hasil = ucwords($hasil);
			break;
		case 'ucfirst': case 4: default:
			$hasil = ucfirst($hasil);
			break;
	}
	
	return $hasil;
}

?>
