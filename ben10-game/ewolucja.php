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

if($uzytkownik['lvl'] >= $uzytkownik['ewolucjaLvl']) {
	if($uzytkownik['ewol'] == 0){
		$jest = mysql_num_rows(mysql_query("select * from pokemon_przedmioty_gracze where gid = ".$uzytkownik['gracz']." and pid = ".$uzytkownik['ewolucjaPrzedmiot']));

		if($jest < 1) {
			echo "<p class='error'>Nie masz przedmiotu wymaganego do ewolucji</p><br class='clear'>";
		} else {
			if(isset($_GET['ewolucja'])){
				//po ewolucji dany pokemon dostaje bonusy do siły
				mysql_query("update pokemon_pokemony_gracze set atak = atak * 1.5, obrona = obrona * 1.5, zycie_max = zycie_max + 500, zycie = zycie + 500, obrazenia_min = obrazenia_min * 1.5, obrazenia_max = obrazenia_max * 1.5, ewol = 1, wartosc = wartosc * 5 where ewol = 0 and pokemon_id = ".$uzytkownik['aktywny_pokemon']." limit 1");

				if(mysql_affected_rows() == 1){
					mysql_query("delete from pokemon_przedmioty_gracze where gid = ".$uzytkownik['gracz']." and pid = ".$uzytkownik['ewolucjaPrzedmiot']." limit 1");
				}

				header('location: ewolucja.php');
			}

			$info = mysql_fetch_array(mysql_query("select * from pokemon_przedmioty_misje where id = ".$uzytkownik['ewolucjaPrzedmiot']." limit 1"));

			echo "Do ewolucji tego kosmity potrzebny jest przedmiot: &nbsp;<br/>
			Posiadasz <b>".$jest."</b> takich przedmiotów<br/>
			<a href='?ewolucja'>Ewolucja kosmity</a>
			";
		}
	} else  {
			echo "<p class='error'>Ten kosmita nie może ewoluować</p><br class='clear'>";
		}
} else header('location: kosmici.php');




//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 