<?php
/*
------------------------------------------------------------
 Luxi - Simple PHP Framework
------------------------------------------------------------
 Version : 1.9.01
 By : Muhammad Faruq Nuruddinsyah
 Division of D-Webs - DaftLabs, Dafturn Technology
------------------------------------------------------------
 License : GNU/LGPL (GNU Lesser GPL)
 Home Page : http://dafturn.org/daftlabs/dwebs/luxi
------------------------------------------------------------
 Copyright 2011. All Rights Reserved.
------------------------------------------------------------
 Library : GUI Components Builder
------------------------------------------------------------
*/

function create_combobox($name, $values = array(), $labels = array(), $selected = "", $attributes = ""){
	if(count($values)==0) return false;
	
	$result = "<select name='$name' id='$name' $attributes>";
	
	for($i=0; $i<count($values); $i++){
		$value = $values[$i];
		$label = $labels[$i];
		
		if($value==$selected){
			if(substr($label, 0, 1) != '*'){
				$result .= "<option value=\"$value\" selected>$label</option>";
			}else{
				$label = substr($label, 1);
				$result .= "<option value=\"$value\" disabled>$label</option>";
			}
		}else{
			if(substr($label, 0, 1) != '*'){
				$result .= "<option value=\"$value\">$label</option>";
			}else{
				$label = substr($label, 1);
				$result .= "<option value=\"$value\" disabled>$label</option>";
			}
		}
	}
	
	$result .= "</select>";
	
	return $result;
}

function create_combobox_from_query($name, $query, $field_value, $field_label, $selected = '', $additional_items_value = array(), $additional_items_label = array(), $additional_items_order = 'first', $attributes = ''){
	$order = 'first';
	
	if($additional_items_order=='last'){
		$order = 'last';
	}
	
	$record = $GLOBALS['db']->get_records($query);
	$values = array(); $labels = array();
	
	if($order=='first'){
		for($i=0; $i<count($additional_items_value); $i++){
			$values[] = $additional_items_value[$i];
			$labels[] = $additional_items_label[$i];
		}
	}
	
	for($i=0; $i<count($record); $i++){
		$values[] = $record[$i][$field_value];
		$labels[] = $record[$i][$field_label];
	}
	
	if($order=='last'){
		for($i=0; $i<count($additional_items_value); $i++){
			$values[] = $additional_items_value[$i];
			$labels[] = $additional_items_label[$i];
		}
	}
	
	if(count($values)==0){
		$values[] = '';
		$labels[] = '';
	}
	
	return create_combobox($name, $values, $labels, $selected, $attributes);
}

function create_pagination($page, $limit, $n_data, $onchange){
	$values = array(); $labels = array();
	
	$n = ceil($n_data / $limit);
		
	for($i = 0; $i < $n; $i++){
		$values[] = $i * $limit;
		$labels[] = ($i + 1) . ' dari ' . ($n);
	}
	
	if(count($values) > 1){
		return create_combobox('page', $values, $labels, $page, "onchange=\"$onchange\"");
	}else{
		return create_combobox('page', $values, $labels, $page, "disabled");
	}
}

?>
