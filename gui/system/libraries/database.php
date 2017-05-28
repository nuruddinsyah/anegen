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
 Library : Database (Using Modified Sidaba 1.9 Library)
------------------------------------------------------------
*/

define('SIDABA_DEFAULT_HOSTNAME', LUXI_DB_HOSTNAME);
define('SIDABA_DEFAULT_USERNAME', LUXI_DB_USERNAME);
define('SIDABA_DEFAULT_PASSWORD', LUXI_DB_PASSWORD);

define('SIDABA_DEFAULT_ERROR_TRACE_TYPE', 0);

define('SIDABA_ERROR_TRACE_MESSAGE_ONLY', 0);          // Do not modify this constant
define('SIDABA_ERROR_TRACE_MESSAGE_WITH_NUMBER', 1);   // Do not modify this constant
define('SIDABA_ERROR_TRACE_NUMBER_ONLY', 2);           // Do not modify this constant


$db = new Sidaba();

if(!$db->is_connected()) error_mysql_connection();
if(!$db->select_database(LUXI_DB_DATABASE_NAME)) error_mysql_database();


class Sidaba{
	var $connection = 0;
	var $hostname;
	var $username;
	var $password;
	var $database_name = '';
	var $table_name = '';
	var $error;
	var $errorno;
	
	function Sidaba($hostname = SIDABA_DEFAULT_HOSTNAME, $username = SIDABA_DEFAULT_USERNAME, $password = SIDABA_DEFAULT_PASSWORD){
		$this->connection = @mysql_connect($hostname, $username, $password);
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
	}
	
	function is_connected(){
		return ($this->connection!=0) ? true : false;
	}
	
	function disconnect(){
		$disconnected = @mysql_close($this->connection);
		if($disconnected){
			$this->connection = 0;
		}
	}
	
	function get_error($trace_type = SIDABA_DEFAULT_ERROR_TRACE_TYPE){
		if($this->is_connected()){
			if($trace_type==SIDABA_ERROR_TRACE_MESSAGE_ONLY){
				$this->error = mysql_error($this->connection);
			}else if($trace_type==SIDABA_ERROR_TRACE_MESSAGE_WITH_NUMBER){
				$this->error = $this->get_error_number() . ': ' . mysql_error($this->connection);
			}else if($trace_type==SIDABA_ERROR_TRACE_NUMBER_ONLY){
				$this->error = $this->get_error_number();
			}else{
				$this->error = mysql_error($this->connection);
			}
		}
		
		return $this->error;
	}
	
	function get_error_number(){
		if($this->is_connected()) $this->errorno = mysql_errno($this->connection);
		return $this->errorno;
	}
	
	function print_error(){
		if(LUXI_DB_PRINT_ERROR && $this->get_error()){
			$content = read_file(BASE_PATH . LUXI_ERROR_MYSQL_QUERY);
			
			echo str_replace("%message%", $this->get_error(), $content);
			exit();
		}else{
			return false;
		}
	}
	
	function create_database($database_name){
		$created = @mysql_query("create database $database_name", $this->connection);
		if($created){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function select_database($database_name){
		$result = @mysql_select_db($database_name, $this->connection);
		if($result){
			$this->database_name = $database_name;
			return true;
		}else{
			return false;
		}
	}
	
	function select_table($table_name, $database_name = ''){
		if($database_name=='') $database_name = $this->database_name;
		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$result = @mysql_query("select * from $table_name", $this->connection);
		if($result){
			$this->table_name = $table_name;
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function execute($query, $database_name = ''){
		if($database_name=='') $database_name = $this->database_name;
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		$result = @mysql_query($query, $this->connection);
		if($result){
			return $result;
		}else{
			return $this->print_error();
		}
	}
	
	function get_records($query, $database_name = ''){
		if($database_name=='') $database_name = $this->database_name;		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		if(substr(strtolower(trim($query)), 0, strlen('select'))!='select') return false;   // Query must be as 'SELECT ...'
		
		$result = array();
		$mysql_result = @mysql_query($query, $this->connection);
		if(!$mysql_result) return $this->print_error();
		
		$i = 0;		
		while($i < mysql_num_rows($mysql_result)){
			$meta = mysql_fetch_array($mysql_result, MYSQL_BOTH);
			$result[] = $meta;
			$i++;
		}
	
		return $result;
	}
	
	function get_single_record($query, $database_name = ''){
		if($database_name=='') $database_name = $this->database_name;		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		if(substr(strtolower(trim($query)), 0, strlen('select'))!='select') return false;   // Query must be as 'SELECT ...'
		
		$mysql_result = @mysql_query($query, $this->connection);
		if(!$mysql_result) return $this->print_error();
		
		return mysql_fetch_array($mysql_result, MYSQL_BOTH);
	}
	
	function count_records($query, $database_name = ''){
		if($database_name=='') $database_name = $this->database_name;		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		if(substr(strtolower(trim($query)), 0, strlen('select'))!='select') return false;   // Query must be as 'SELECT ...'
		
		$mysql_result = @mysql_query($query, $this->connection);
		if(!$mysql_result) return $this->print_error();
		
		return mysql_num_rows($mysql_result);
	}
	
	function update_record($fields = array(), $values = array(), $where, $table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$set_values = '';
		for($i=0; $i < count($fields); $i++){
			$set_values .= '`' . $fields[$i] . '` = ' . "'" . addslashes($values[$i]) . "', ";
		}
		$set_values = substr($set_values, 0, strlen($set_values)-2);
		
		$result = mysql_query("update $table_name set $set_values where $where", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function delete_record($where, $table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$result = mysql_query("delete from $table_name where $where", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function add_record($fields = array(), $values = array(), $table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$list_values = '(';
		for($i=0; $i < count($values); $i++){
			$list_values .= "'" . addslashes($values[$i]) . "', ";
		}
		$list_values = substr($list_values, 0, strlen($list_values)-2);
		$list_values .= ')';
		
		if(count($fields) > 0){
			$list_fields = '(';
			for($i=0; $i < count($fields); $i++){
				$list_fields  .= '`' . $fields[$i] . '`, ';
			}
			$list_fields  = substr($list_fields, 0, strlen($list_fields)-2);
			$list_fields .= ')';
		}else{
			$list_fields = '';
		}
		
		$result = mysql_query("insert into $table_name $list_fields values $list_values", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function drop_database($database_name = ''){
		if($database_name=='') $database_name = $this->database_name;
		
		$result = mysql_query("drop database $database_name", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function drop_table($table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$result = mysql_query("drop table $table_name", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function drop_field($field_name, $table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$result = mysql_query("alter table $table_name drop $field_name", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
	
	function empty_table($table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		if(!@mysql_select_db($database_name, $this->connection)) return $this->print_error();
		
		$result = mysql_query("truncate table $table_name", $this->connection);
		if($result){
			return true;
		}else{
			return $this->print_error();
		}
	}
		
	function databases_list(){
		$result = array();
		$mysql_result = @mysql_list_dbs($this->connection);
		
		if(!$mysql_result) return $this->print_error();
		
		while($row = mysql_fetch_object($mysql_result)){
  			$result[]=$row->Database;
		}
		
		return $result;
	}
	
	function tables_list($database_name = ''){
		if($database_name=='') $database_name = $this->database_name;
		
		$result = array();		
		$mysql_result = @mysql_list_tables($database_name, $this->connection);
		if(!$mysql_result) return $this->print_error();
		
		$i = 0;
		while($i < mysql_num_rows($mysql_result)){
			$result[$i] = mysql_tablename($mysql_result, $i);
			$i++;
		}
		
		return $result;
	}
	
	function fields_list($table_name = '', $database_name = ''){
		if($table_name=='') $table_name = $this->table_name;
		if($database_name=='') $database_name = $this->database_name;
		
		$result = array();		
		$mysql_result = @mysql_list_fields($database_name, $table_name, $this->connection);
		if(!$mysql_result) return $this->print_error();
		
		for ($i=0; $i < mysql_num_fields($mysql_result); $i++){
  			$result[] = mysql_field_name($mysql_result, $i);
		}
		
		return $result;
	}

    function inserted_id() {
        return mysql_insert_id($this->connection);
    }
}

?>
