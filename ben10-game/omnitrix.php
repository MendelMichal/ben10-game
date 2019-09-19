<?php
//włączamy bufor
ob_start();

//pobieramy zawartość pliku ustawień
require_once('var/ustawienia.php');

//startujemy lub przedłużamy sesję
session_start();

//dołączamy plik, który sprawdzi czy napewno mamy dostęp do tej strony
require_once('test_zalogowanego.php');

//pobieramy nagłówek strony
require_once('gora_strony.php');

//pobieramy zawartość menu
require_once('menu.php');    



echo "<h2>Możliwe do zdobycia Omnitrixy</h2><hr/>";
$query = mysql_query("select *,count(pid) as ile from pokemon_przedmioty_gracze inner join pokemon_przedmioty_misje where gid = ".$uzytkownik['gracz']."");
if(mysql_num_rows($query) == 0) echo "<p class='error'>Posiadasz tylko podstawowego omnitrixa</p><br class='clear'/>";
else {
	while($row = mysql_fetch_array($query)){
		echo $row['nazwa']."<br/>";
		}
		}
	


if(!empty($_GET['aktywny'])){
	$_GET['aktywny'] = (int)$_GET['aktywny'];
	$omnitrixy = mysql_fetch_array(mysql_query("select * from pokemon_przedmioty_gracze where gid = ".$uzytkownik['gracz']." and ppid = ".$_GET['aktywny']));
	if(empty($omnitrixy)){
		echo "<p class='error'>Nie posiadasz takiego Omnitrixa</p><br class='clear'>";
	} else {
		mysql_query("update pokemon_gracze set aktywny_omnitrix = ".$_GET['aktywny']." where gracz = ".$uzytkownik['gracz']);

		$uzytkownik['aktywny_omnitrix'] = $_GET['aktywny'];

		echo "<p class='note'>Zmiana Omnitrixa powiodła się!</p><br class='clear'>";
	}
}

$omnitrixy = mysql_query("select * from pokemon_przedmioty_gracze where gid = ".$uzytkownik['gracz']." and ppid != ".$uzytkownik['aktywny_omnitrix']);
$omni = mysql_query("select nazwa from pokemon_przedmioty_misje where id = ".$omnitrixy['ppid']);
	echo "
	<table style='width:100%'>
	";
	while ($omnitrix = mysql_fetch_array($omnitrixy)){
		$i++;
		if($i % 2 == 1) $styl = " style='background:black'"; else $styl="";
		echo "
		<tr ".$styl.">
			<td style='width:250px'>
				<img src='omnitrix/".$omnitrix['ppid'].".png' alt=''/>
				
			</td>
			
			<td style='padding:5px'>
				<b><i>".$omni."</i></b>
				<a href='omnitrix.php?aktywny=".$omnitrix['ppid']."'>[ustaw jako aktywny]</a><br/>
				<form action='omnitrix.php?omnitrix=".$omnitrix['ppid']."' method='post'>
				</form>
			</td>
		</tr>	
		</center>
		";
	}
	echo "</table>";
	


//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 