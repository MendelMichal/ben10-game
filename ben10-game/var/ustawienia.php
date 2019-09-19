<?php
$config['db']['host'] = 'localhost';  //host bazy danych
$config['db']['user'] = 'root';  //nazwa użytkownika bazy danych
$config['db']['pass'] = '';  //hasło do bazy danych
$config['db']['dbname'] = 'ben10'; //nazwa bazy danych
error_reporting(0);

$config['register'] = true;  //rejestracja 'true' - włączona, 'false' - wyłączona

$connect = mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['pass']) or die('błąd połączenia z bazą') ;
mysql_select_db($config['db']['dbname'],$connect) or die('błąd połączenia z bazą');
mysql_query("SET NAMES 'utf8'") or die('błąd połączenia z bazą');

?>