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

echo "<h2><center>Regeneracja Wytrzymałości</center></h2><hr/>";

if(!empty($_POST['pkt'])){
	$_POST['pkt'] = (int)$_POST['pkt'];

	if($_POST['pkt'] < 1) 
		echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
	elseif($_POST['pkt'] > $uzytkownik['zycie_max'] - $uzytkownik['zycie']) 
		echo "<p class='error'>Podano za dużą wartość</p><br class='clear'>";
	elseif($_POST['pkt'] * 25 > $uzytkownik['kasa']) 
		echo "<p class='error'>Masz za mało energii w Omnitrixie, aby zamienić się w danego herosa i zregenerować mu trochę Punktów Wytrzymałości</p><br class='clear'>";
	else {
		mysql_query("update pokemon_pokemony_gracze set zycie = zycie + ".$_POST['pkt']." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);

		mysql_query("update pokemon_gracze set kasa = kasa - ".($_POST['pkt'] * 25)." where gracz = ".$uzytkownik['gracz']);
		
		$uzytkownik['zycie'] += $_POST['pkt'];
		$uzytkownik['kasa'] -= $_POST['pkt'] * 25;

		echo "<p class='note'>Pomyślnie podłączyłeś się do komputera i zregenerowałeś sobie <i><b>".$_POST['pkt']."</b></i> Punktów Wytrzymałości</p><br class='clear'>";
	}
}

if($uzytkownik['zycie'] < $uzytkownik['zycie_max']){
	echo"
	<table style='background:black'>
	<tr>
	<td style='background:black'><b><center>Jeżeli twój aktywny Heros ma niską wytrzymałość, to możesz podłączyć omnitrix do komputera, który zregeneruje go.
	<br>
	<font color='Red'>1 Punkt Zdrowia = 25 Energii Omnitrixa
		<br></center></b>
		</table>
		</td>
		</tr>
		<center>
		<form action='regeneracja.php' method='post'>
			<input type='text' name='pkt' /> 
			<input type='submit' value='Zregeneruj'/>
		</form>
		</center>
	";
} else echo "<p class='note'>Twój Heros ma dobrą Wytrzymałość</p>";

//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 