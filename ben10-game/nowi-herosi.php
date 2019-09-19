<?php
//wĹ‚Ä…czamy bufor
ob_start();

//pobieramy zawartoĹ›Ä‡ pliku ustawieĹ„
require_once('var/ustawienia.php');

//startujemy lub przedĹ‚uĹĽamy sesjÄ™
session_start();

//doĹ‚Ä…czamy plik, ktĂłry sprawdzi czy napewno mamy dostÄ™p do tej strony
require_once('test_zalogowanego.php');

//pobieramy nagĹ‚Ăłwek strony
require_once('gora_strony.php');

//pobieramy zawartoĹ›Ä‡ menu
require_once('menu.php');    

if(!empty($_GET['kup'])){
	$_GET['kup'] = (int)$_GET['kup'];
	$pokemon = mysql_fetch_array(mysql_query("select p.* from pokemon_pokemony p left join pokemon_pokemony_gracze on gracz_id = ".$uzytkownik['gracz']." and pokemon_id = p.pokemon where pokemon_id is null and pokemon = ".$_GET['kup']." and omnitrix = ".$uzytkownik['aktywny_omnitrix']));
	if(empty($pokemon)){
		echo "<p class='error'>Niestety, moc ominitrixa nie pozwala na odkrycie kodu, który dawałby Ci tego kosmitę</p><br class='clear'>";
	} elseif($pokemon['cena'] > $uzytkownik['kasa']){
		echo "<p class='error'>Niestety, moc ominitrixa nie pozwala na odkrycie kodu, który dawałby Ci tego kosmitę</p><br class='clear'>";
	} else {

		mysql_query("insert into pokemon_pokemony_gracze(gracz_id, pokemon_id, nazwa, wartosc, atak, obrona, obrazenia_min, obrazenia_max, zycie, zycie_max) value(".$uzytkownik['gracz'].",".$pokemon['pokemon'].",'".$pokemon['nazwa']."',".($pokemon['cena']*0.9).",".$pokemon['atak'].",".$pokemon['obrona'].",".$pokemon['obrazenia_min'].",".$pokemon['obrazenia_max'].",".$pokemon['zycie'].",".$pokemon['zycie'].")");
		mysql_query("update pokemon_gracze set kasa = kasa - ".$pokemon['cena']." where gracz = ".$uzytkownik['gracz']);

		$uzytkownik['kasa'] -= $pokemon['cena'];
	

		echo "<p class='note'>Odkryto nowego Herosa !</p><br class='clear'>";
	}
}

if(!empty($_GET['sprzedaj'])){
	$_GET['sprzedaj'] = (int)$_GET['sprzedaj'];
	$pokemon = mysql_fetch_array(mysql_query("select * from pokemon_pokemony_gracze  where gracz_id = ".$uzytkownik['gracz']." and pokemon_id != ".$uzytkownik['aktywny_pokemon']." and pokemon_id = ".$_GET['sprzedaj']));
	if(empty($pokemon)){
		echo "<p class='error'>Nie ma takiego kosmity</p><br class='clear'>";
	} else {

		mysql_query("delete from pokemon_pokemony_gracze where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$_GET['sprzedaj']);
		mysql_query("update pokemon_gracze set kasa = kasa + ".$pokemon['wartosc']." where gracz = ".$uzytkownik['gracz']);

		$uzytkownik['kasa'] += $pokemon['wartosc'];
	

		echo "<p class='note'>Zresetowano i usunięto kosmitę</p><br class='clear'>";
	}
}

$pokemony = mysql_query("select p.* from pokemon_pokemony p left join pokemon_pokemony_gracze on gracz_id = ".$uzytkownik['gracz']." and pokemon_id = p.pokemon where pokemon_id is null and omnitrix = ".$uzytkownik['omnitrix']);
if(mysql_num_rows($pokemony) > 0){
	echo "<h2><center>Herosi</center></h2><hr/>
	<table style='width:100%'>
	";
	while ($pokemon = mysql_fetch_array($pokemony)){
		$i++;
		if($i % 2 == 1) $styl = " style='background:#838B8B'"; else $styl="style='background:#4F4F4F'";
		echo "
		<tr ".$styl.">
			<td style='width:250px'>
				<img src='pokemony/".$pokemon['pokemon'].".png' alt=''/>
				
			</td>
			
			<td style='padding:5px'>
				<b><i>".$pokemon['nazwa']."</i></b>
				<ul>
					<li>Umiejętność Ataku: ".$pokemon['atak']."
					<li>Umiejętność Obrony: ".$pokemon['obrona']."
					<li>Moc: ".$pokemon['obrazenia_min']."-".$pokemon['obrazenia_max']."
					<li>Wytrzymałość: ".$pokemon['zycie']."/".$pokemon['zycie']."
				</ul>
				<a href='nowi-herosi.php?kup=".$pokemon['pokemon']."'>[Odblokuj za ".$pokemon['cena']." Energii Omnitrixa]</a><br/>
				
			</td>
		</tr>	
		";
	}
	echo "</table>";
} else echo "<p class='note'>Posiadasz już wszystkich dostępnych Herosów !</p><br class='clear'>";

$pokemony = mysql_query("select * from pokemon_pokemony_gracze where gracz_id = ".$uzytkownik['gracz']." and pokemon_id != ".$uzytkownik['aktywny_pokemon']);
if(mysql_num_rows($pokemony) > 0){
	echo "<h2><center>Herosi w twoim omnitrixie</center></h2><hr/>
	<table style='width:100%'>
	";
	while ($pokemon = mysql_fetch_array($pokemony)){
		$i++;
		if($i % 2 == 1) $styl = " style='background:#838B8B'"; else $styl="style='background:#4F4F4F'";
		echo "
		<tr ".$styl.">
			<td style='width:250px'>
				<img src='pokemony/".$pokemon['pokemon_id'].".png' alt=''/>
				
			</td>
			
			<td style='padding:5px'>
				<b><i>".$pokemon['nazwa']."</i></b>
				<ul>
					<li>Umiejętność Ataku: ".$pokemon['atak']."
					<li>Umiejętność Obrony: ".$pokemon['obrona']."
					<li>Moc: ".$pokemon['obrazenia_min']."-".$pokemon['obrazenia_max']."
					<li>Wytrzymałość: ".$pokemon['zycie']."/".$pokemon['zycie_max']."
				</ul>
				<a href='nowi-herosi.php?sprzedaj=".$pokemon['pokemon_id']."'>[Odkoduj za ".$pokemon['wartosc']."Energii Omnitrixa]</a><br/>
				
			</td>
		</tr>	
		";
	}
	echo "</table>";
} else echo "<p class='note'>Nie posiadasz wolnych Herosów</p><br class='clear'>";

//pobieramy zawartoĹ›Ä‡ prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkÄ™
require_once('dol_strony.php');

//wyĹ‚Ä…czamy bufor
ob_end_flush();
?> 