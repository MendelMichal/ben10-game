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
?>
<h2><center>Ranking</center></h2><hr/>
<table id='rank'>
<table  border='1' rules='none' bordercolor='black' style='background:#FFFFFF'>
<tr style='background:#EFEFEF'>
    <td background='images/tbtlo.jpg' align='center'  width='200' ><b><font color='Green'>Miejsce</font></b></td></center>
    <td background='images/tbtlo.jpg' align='center'  width='200' ><b><font color='Green'>Gracz</font></b></td></center>
    <td background='images/tbtlo.jpg' align='center'  width='200' ><b><font color='Green'>Punkty</font></b></td></center>
	</tr>

<?php
$player = $_GET;
      $gracz = mysql_fetch_array(mysql_query("select * from pokemon_gracze where gracz = '".$player['player']."'" ));
$gracze = mysql_query("select * from pokemon_gracze  order by punkty desc ");
while ($g = mysql_fetch_array($gracze)){
	$i++;
	if($i % 2 == 0) $styl = " style='background:#828282'"; else $styl=" style='background:#4F4F4F'";
	echo "
	<tr align='center' ".$styl.">
		<td>".$i."</td>
		<td><a href='profile.php?player=".$g['gracz']."'>".$g['login']."</td>
		<td>".$g['punkty']."</td>
	</tr>";
}

echo "</table>";


//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 