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

if(!empty($_GET['aktywny'])){
	$_GET['aktywny'] = (int)$_GET['aktywny'];
	$pokemon = mysql_fetch_array(mysql_query("select * from pokemon_pokemony_gracze where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$_GET['aktywny']));
	if(empty($pokemon)){
		echo "<p class='error'>Nie ma takiego Herosa</p><br class='clear'>";
	} else {
		mysql_query("update pokemon_gracze set aktywny_pokemon = ".$_GET['aktywny']." where gracz = ".$uzytkownik['gracz']);

		$uzytkownik['nazwa'] = $pokemon['nazwa'];
		$uzytkownik['atak'] = $pokemon['atak'];
		$uzytkownik['obrona'] = $pokemon['obrona'];
		$uzytkownik['obrazenia_min'] = $pokemon['obrazenia_min'];
		$uzytkownik['obrazenia_max'] = $pokemon['obrazenia_max'];
		$uzytkownik['zycie'] = $pokemon['zycie'];
		$uzytkownik['zycie_max'] = $pokemon['zycie_max'];
		$uzytkownik['aktywny_pokemon'] = $_GET['aktywny'];

		echo "<p class='note'>Kompilacja Herosa z twoim DNA powiodła się.</p><br class='clear'>";
	}
}
if(!empty($_GET['pokemon']) && !empty($_POST['nazwa'])){
	$_GET['pokemon'] = (int)$_GET['pokemon'];
	if($_GET['pokemon'] == 0){
		echo "<p class='error'>Nie ma takiego Herosa</p><br class='clear'>";
	} else {
		$_POST['nazwa'] = trim(substr($_POST['nazwa'],0,20));
		
		$nazwa_buff = $_POST['nazwa'];
		
		$_POST['nazwa'] = mysql_real_escape_string($_POST['nazwa']);
		mysql_query("update pokemon_pokemony_gracze set nazwa = '".$_POST['nazwa']."' where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$_GET['pokemon']);
		
		if(mysql_affected_rows() == 1){
			echo "<p class='note'>Zmieniono nazwę Herosa</p><br class='clear'>";
			if($_GET['pokemon'] == $uzytkownik['aktywny_pokemon']) $uzytkownik['nazwa'] = $nazwa_buff;

		} else {
			echo "<p class='error'>Nie ma takiej przemiany lub nie wpisałeś poprawnej nazwy</p><br class='clear'>";
		}
	}
	

}
// 

if(($uzytkownik['lvl'] >= $uzytkownik['ewolucjaLvl']) && ($uzytkownik['ewol'] == 0))$ewolucja = "<a href='ewolucja.php'>ewolucja!</a>";
else $ewolucja = "";

if($uzytkownik['ewol'] == 1) $ewol = '_e'; else $ewol = '';
if($uzytkownik['vip'] > 0) $vip = '_vip'; else $vip = '';
echo "<h2><center>Aktywny Heros</h2><hr/></center>
<center>
<table  border='1' rules='none' bordercolor='black' cellpadding='10' width='450'>
<tr>
<td background='images/tbtlo.jpg' ><b><font color='Red'><center><b><i>".$uzytkownik['nazwa']."</i></b></center></font></td>
</font></b></center>
</tr>
		</center>
<tr>
<td width='350' style='background:#E8E8E8'><center><img src='pokemony/".$uzytkownik['aktywny_pokemon'].$ewol.$vip.".png' alt=''/></center>
</td>
</table>

<table>
<thead>
<tr>
<th colspan='2' background='images/tbtlo.jpg' width='600'><b><font color='green'><center><b>Statystyki Herosa</th>
</tr>
</thead>

<tr>
<td background='images/tbtlo.jpg' width='300'><b><font color='green'><center><b>Umiejetnosc</td>	<td background='images/tbtlo.jpg' width='300'><b><font color='green'><center><b>Wartosc</td>
</tr>


<tr style='background:#828282'>
<td><b><font size='5'><center>Atak:</center></font></b></td>
<td><b><font size='5'><center>".$uzytkownik['atak']."</center></font></b></td>
</tr>

<tr style='background:#4F4F4F'>
<td><b><font size='5'><center>Obrona:</center></font></b></td>
<td><b><font size='5'><center>".$uzytkownik['obrona']."</center></font></b></td>
</tr>

<tr style='background:#828282'>
<td><b><font size='5'><center>Moc:</center></font></b></td>
<td><b><font size='5'><center>".$uzytkownik['obrazenia_min']."-".$uzytkownik['obrazenia_max']."</center></font></b></td>
</tr>

<tr style='background:#4F4F4F'>
<td><b><font size='5'><center>Zdrowie:</center></font></b></i></u></size></td>
<td><b><font size='5'><center>".$uzytkownik['zycie']."/".$uzytkownik['zycie_max']."</center></font></b></td>
</tr>

<tr style='background:#828282'>
<td><b><font size='5'><center>EXP:</center></font></b></i></u></size></td>
<td><b><font size='5'><center>".$uzytkownik['exp']."/".$uzytkownik['expMax']."</center></font></b></td>
</tr>

<tr style='background:#4F4F4F'>
<td><b><font size='5'><center>Poziom:</center></font></b></i></u></size></td>
<td><b><font size='5'><center>".$uzytkownik['lvl']." ".$ewolucja."</center></font></b></td>
</tr>
				
			
				<form action='kosmici.php?pokemon=".$uzytkownik['aktywny_pokemon']."' method='post'>
				</form>
			</td>
		</tr>	
		</td>
	</table>
	</center>
		</table>
			</table>	</table>
				</table>	</table>
					</table>
					</left>
					<br>
					<br>
				
";
$pokemony = mysql_query("select * from pokemon_pokemony_gracze where gracz_id = ".$uzytkownik['gracz']." and pokemon_id != ".$uzytkownik['aktywny_pokemon']);
if(mysql_num_rows($pokemony) > 0){
	echo "<h2><center>Twoje pozostałe przemiany</center></h2><hr/>
	<table style='width:100%'>
	";
	while ($pokemon = mysql_fetch_array($pokemony)){
		$i++;
		if($i % 2 == 1) $styl = " style='background:#828282'"; else $styl=" style='background:#4F4F4F'";
		echo "
		<tr ".$styl.">
			<td style='width:250px'>
				<img src='pokemony/".$pokemon['pokemon_id'].".png' alt=''/>
				
			</td>
			
			<td style='padding:5px'>
				<b><i>".$pokemon['nazwa']."</i></b>
				<ul>
					<li>Atak: ".$pokemon['atak']."
					<li>Obrona: ".$pokemon['obrona']."
					<li>Moc: ".$pokemon['obrazenia_min']."-".$pokemon['obrazenia_max']."
					<li>Wytrzymałość: ".$pokemon['zycie']."/".$pokemon['zycie_max']."
				</ul>
				<a href='kosmici.php?aktywny=".$pokemon['pokemon_id']."'>[ustaw jako aktywny]</a><br/>
				<form action='kosmici.php?pokemon=".$pokemon['pokemon_id']."' method='post'>
				</form>
			</td>
		</tr>	
		</center>
		";
	}
	echo "</table>";
} else echo "<p class='note'>Nie posiadasz więcej dostępnych przemian</p><br class='clear'>";

//pobieramy zawartoĹ›Ä‡ prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkÄ™
require_once('dol_strony.php');

//wyĹ‚Ä…czamy bufor
ob_end_flush();
?> 