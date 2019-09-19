<?php
//włączamy bufor
ob_start();

//pobieramy zawartość pliku ustawień
require_once('var/ustawienia.php');

//startujemy lub przedłużamy sesję
session_start();

//dołączamy plik, który sprawdzi czy napewno mamy dostęp do tej strony
require_once('test_zalogowanego.php');
if($uzytkownik['pracuje'] > 0) header('location: legium.php');
if($uzytkownik['misje'] > 0) header('location: misje.php');

//pobieramy nagłówek strony
require_once('gora_strony.php');

//pobieramy zawartość menu
require_once('menu.php');


echo "<h2><center>Walki rankingowe</center></h2><hr/>
<center>Walki o miejsce w rankingu są najbardziej prestiżowe i wynagradzane. Tylko zwycięzca otrzymuje nagrodę.<br/>
Za wygranie pojedynku otrzymasz energię do omnitrixa, która go trochę podładuje, jak również zasili Tobie punkty rankingowe.<br/><br/>
<b>Koszt pojedynku to 10 akcji. Jednym Herosem możesz walczyć raz na 10 minut</b><br/>
Do walki stanie aktywny kosmita przeciwnika</b></center><hr/>
";


if(!empty($_POST['login'])){
	$_POST['login'] = mysql_real_escape_string(trim($_POST['login']));
	

	if($uzytkownik['akcje'] < 10){
		echo "<p class='error'>Posiadasz za mało energii w omnitrixsie</p><br class='clear'>";
	} elseif($uzytkownik['zycie'] == 0){
			echo "<p class='error'>Twój Heros ma mało Punktów Zdrowia</p><br class='clear'>";
	} elseif($uzytkownik['ostatnia_walka'] + 600 > time()){
			$pozostalo = $uzytkownik['ostatnia_walka'] + 600 - time();
			echo "
			<script type='text/javascript'>        
				function liczCzas(ile) {
						godzin = Math.floor((ile )/ 3600);
					minut = Math.floor((ile  - godzin * 3600) / 60);
					sekund = ile  - minut * 60 - godzin * 3600;
					if (godzin < 10){ godzin = '0'+ godzin; }
					if (minut < 10){ minut = '0' + minut; }
					if (sekund < 10){ sekund = '0' + sekund; }
					if (ile > 0) {
						ile--;
						document.getElementById('zegar').innerHTML = godzin + ':' + minut + ':' + sekund;
						setTimeout('liczCzas('+ile+')', 1000);
					} else {
						document.getElementById('zegar').innerHTML = '[koniec]';
					}
				}
			</script>
			<p class='error'>Twój Heros niedawno walczył i już nie ma siły na kolejną walkę. Daj mu odpocząć. Pozostało: <span id='zegar'></span><script type='text/javascript'>liczCzas(".$pozostalo.")</script> </p><br class='clear'>";
	} else {
		$vs = mysql_fetch_array(mysql_query("select * from pokemon_gracze inner join pokemon_pokemony_gracze on gracz_id = gracz and pokemon_id = aktywny_pokemon where login = '".$_POST['login']."'"));
		if(empty($vs)){
			echo "<p class='error'>Nie ma takiego gracza!</p><br class='clear'>";
		} elseif($vs['gracz'] == $uzytkownik['gracz']){
			echo "<p class='error'>Nie możesz walczyć sam ze sobą</p><br class='clear'>";
		} elseif($vs['zycie'] ==0){
			echo "<p class='error'>Przeciwnik nie ma kompletnie energi w omnitrixie i narazie nie może stanąć do pojedynku</p><br class='clear'>";
		} else {
			// przebieg walki
			echo "<p class='note'>Wyzwałeś użytkownika <b>".$vs['login']."</b> na pojedynek Herosów. Twój przeciwnik wybrał <b>".$vs['nazwa']."</b> </p><br class='clear'>

			<table id='rank'>
			<tr>
				<th><b>".$uzytkownik['login']."<b></th>
				<th><b>".$vs['login']."<b></th>
			</tr>
			<tr>
				<td><img src='pokemony/".$uzytkownik['aktywny_pokemon'].".png' alt='' width='125px'/></td>
				<td><img src='pokemony/".$vs['aktywny_pokemon'].".png' alt='' width='125px'/></td>
			</tr>
			<tr>
				<td>
					<b><i>".$uzytkownik['nazwa']."</i></b>
					<ul>
						<li>Umiejętność Ataku: ".$uzytkownik['atak']."
						<li>Umiejętność Obrony: ".$uzytkownik['obrona']."
						<li>Moc: ".$uzytkownik['obrazenia_min']."-".$uzytkownik['obrazenia_max']."
						<li>Zdrowie: ".$uzytkownik['zycie']."/".$uzytkownik['zycie_max']."
					</ul>
				</td>
				<td>
					<b><i>".$vs['nazwa']."</i></b>
					<ul>
						<li>Umiejętność Ataku: ".$vs['atak']."
						<li>Umiejętność Obrony: ".$vs['obrona']."
						<li>Moc: ".$vs['obrazenia_min']."-".$vs['obrazenia_max']."
						<li>Zdrowie: ".$vs['zycie']."/".$vs['zycie_max']."
					</ul>
				</td>
			</tr>
			</table>
			<hr/>
			";
			$runda = 0;
			$punktyA = 0;
			$punktyB = 0;
			$wynik = 0;
			
			while(($vs['zycie'] > 0) && ($uzytkownik['zycie'] > 0) && ($runda < 20)){
				echo "<br/><br/><b>Runda ".++$runda."</b><br/><br/>";
				$szansa = floor($uzytkownik['atak'] / $vs['obrona'] *100);

				//max szansa na trafienie = 75%, a minimalna 25%
				if($szansa >= 75) $szansa = 75;
				elseif ($szansa < 25) $szansa = 25;

				$rand = rand(1,100);
				if($szansa >= $rand) {
					$rany = rand($uzytkownik['obrazenia_min'],$uzytkownik['obrazenia_max']);
					//minimalnie można zadać 1 ranę
					if($rany < 1) $rany = 1;
					$vs['zycie'] -= $rany;
					$punktyA += $rany;

					if($vs['zycie'] < 1){
						$vs['zycie'] = 0;
						echo "<b>".$uzytkownik['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$vs['nazwa']."</b> i wygrywa walkę. <br/>";
						$wynik = 1;
					} else {
						echo "<b>".$uzytkownik['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
						$szansa = floor($vs['atak'] / $uzytkownik['obrona'] *100);

						//max szansa na trafienie = 75%, a minimalna 25%
						if($szansa >= 75) $szansa = 75;
						elseif ($szansa < 25) $szansa = 25;

						$rand = rand(1,100);
						if($szansa >= $rand) {
							$rany = rand($vs['obrazenia_min'],$vs['obrazenia_max']);
							//minimalnie można zadać 1 ranę
							if($rany < 1) $rany = 1;
							$uzytkownik['zycie'] -= $rany;

							$punktyB += $rany;

							if($uzytkownik['zycie'] < 1){
								$uzytkownik['zycie'] = 0;
								echo "<b>".$vs['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
								$wynik = 2;
							} else {
								echo "<b>".$vs['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
							}
						} else {
							echo "<b>".$vs['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						}
					}
				} else {
					echo "<b>".$uzytkownik['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						$szansa = floor($vs['atak'] / $uzytkownik['obrona'] *100);

						//max szansa na trafienie = 75%, a minimalna 25%
						if($szansa >= 75) $szansa = 75;
						elseif ($szansa < 25) $szansa = 25;

						$rand = rand(1,100);
						if($szansa >= $rand) {
							$rany = rand($vs['obrazenia_min'],$vs['obrazenia_max']);
							//minimalnie można zadać 1 ranę
							if($rany < 1) $rany = 1;
							$uzytkownik['zycie'] -= $rany;

							$punktyB += $rany;

							if($uzytkownik['zycie'] < 1){
								$uzytkownik['zycie'] = 0;
								echo "<b>".$vs['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
								$wynik = 2;
							} else {
								echo "<b>".$vs['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
							}
						} else {
							echo "<b>".$vs['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						}
				}
			}

			if($wynik == 0){
				//padł remis, nikt nikogo nie dobił, sprawdzamy punkty
				if($punktyA >= $punktyB) $wynik = 1; else $wynik = 2;
				echo "<br/><b> W walce padł remis, wygrywa ten, kto zadał więcej obrażeń</b><br/>";
			}

			if($wynik == 1){
				$punkty = floor($vs['punkty'] / 100) + 3;
				$exp = floor($vs['punkty'] / 100) + 2;
				$kasa =  floor($vs['punkty'] / 10) + 100;
				echo "
				<p class='note'>
					Po zwycięskiej walce <b>".$uzytkownik['login']."</b> otrzymuje ".$punkty ." punktów do Hydraulicznego Rankingu, ".$kasa." energii do omnitrixa oraz ".$exp." EXPa <br/>
				</p><br class='clear'>";

				mysql_query("update pokemon_gracze set akcje = akcje - 10, kasa = kasa + ".$kasa.", punkty = punkty + ".$punkty." where gracz = ".$uzytkownik['gracz']);
				mysql_query("update pokemon_pokemony_gracze set exp = exp + ".$exp." where gracz_id = ".$uzytkownik['gracz_id']);
				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);

				$uzytkownik['akcje'] -= 10;
				$uzytkownik['kasa'] += $kasa;
				$uzytkownik['punkty'] += $punkty;
				$uzytkownik['exp'] += $exp;
				$uzytkownik['ostatnia_walka'] = time();

				mysql_query("update pokemon_pokemony_gracze set zycie = ".$vs['zycie']." where gracz_id = ".$vs['gracz']." and pokemon_id = ".$vs['aktywny_pokemon']);

				mysql_query("insert into pokemon_poczta(od, do , typ, tytul, tresc, data) value (1,".$vs['gracz'].",1,'Wyzwano Cię na pojedynek Kosmitów','Przegrałeś pojedynek Herosów z graczem ".$uzytkownik['login']."', now())");
				
			} else {
				$punkty = floor($uzytkownik['punkty'] / 100) + 3;
				$exp = floor($vs['punkty'] / 100) + 2;
				$kasa =  floor($uzytkownik['punkty'] / 10) + 100;
				echo "
				<p class='note'>
					Po przegranej walce z  <b>".$vs['nazwa']."</b> opuszczasz pole bitwy ze spuszczoną głową... 
				</p><br class='clear'>";

				mysql_query("update pokemon_gracze set akcje = akcje - 10 where gracz = ".$uzytkownik['gracz']);
				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);

				$uzytkownik['akcje'] -= 10;
				$uzytkownik['ostatnia_walka'] = time();

				mysql_query("update pokemon_pokemony_gracze set zycie = ".$vs['zycie']." where gracz_id = ".$vs['gracz']." and pokemon_id = ".$vs['aktywny_pokemon']);
				mysql_query("update pokemon_gracze set kasa = kasa + ".$kasa.", punkty = punkty + ".$punkty." where gracz = ".$vs['gracz']);

				mysql_query("insert into pokemon_poczta(od, do , typ, tytul, tresc, data) value (1,".$vs['gracz'].",1,'Wyzwano Cię na pojedynek Kosmitów','Wygrałeś pojedynek Herosów z graczem ".$uzytkownik['login']." i zdobyłeś ".$punkty ." punktów, ".$kasa." energii do omnitrixa oraz ".$exp." EXPa', now())");
			}

			
			
		}
	}
}
if(!empty($_GET['walcz'])){
	$_GET['walcz'] = (int)$_GET['walcz'];

	if($_GET['walcz'] == $uzytkownik['gracz']){
		echo "<p class='error'>Nie możesz walczyć sam ze sobą</p><br class='clear'>";
	} elseif($uzytkownik['akcje'] < 10){
		echo "<p class='error'>Posiadasz za mało energii w omnitrixie</p><br class='clear'>";
	} elseif($uzytkownik['zycie'] == 0){
		echo "<p class='error'>Twój Heros ma mało Punktów Zdrowia</p><br class='clear'>";
	} elseif($uzytkownik['ostatnia_walka'] + 600 > time()){
		$pozostalo = $uzytkownik['ostatnia_walka'] + 600 - time();
		echo "
		<script type='text/javascript'>        
			function liczCzas(ile) {
					godzin = Math.floor((ile )/ 3600);
				minut = Math.floor((ile  - godzin * 3600) / 60);
				sekund = ile  - minut * 60 - godzin * 3600;
				if (godzin < 10){ godzin = '0'+ godzin; }
				if (minut < 10){ minut = '0' + minut; }
				if (sekund < 10){ sekund = '0' + sekund; }
				if (ile > 0) {
					ile--;
					document.getElementById('zegar').innerHTML = godzin + ':' + minut + ':' + sekund;
					setTimeout('liczCzas('+ile+')', 1000);
				} else {
					document.getElementById('zegar').innerHTML = '[koniec]';
				}
			}
		</script>
		<p class='error'>Twój Heros niedawno walczył i nie ma siły na dalszą walkę. Daj mu odpocząć. Pozostało: <span id='zegar'></span><script type='text/javascript'>liczCzas(".$pozostalo.")</script> </p><br class='clear'>";
	} else {
		$vs = mysql_fetch_array(mysql_query("select * from pokemon_gracze inner join pokemon_pokemony_gracze on gracz_id = gracz and pokemon_id = aktywny_pokemon where gracz = ".$_GET['walcz']));
		if(empty($vs)){
			echo "<p class='error'>Nie ma takiego gracza!</p><br class='clear'>";
		} elseif($vs['zycie'] ==0){
			echo "<p class='error'>Przeciwnik nie ma kompletnie energii w omnitrixsie i nie może przez to stanąć do pojedynku</p><br class='clear'>";
		} else {
			// przebieg walki
			echo "<p class='note'>Wyzwałeś użytkownika <b>".$vs['login']."</b> na pojedynek Herosów. Przeciwnik przemienił się w <b>".$vs['nazwa']."</b> </p><br class='clear'>

			<table id='rank'>
			<tr>
				<th><b>".$uzytkownik['login']."<b></th>
				<th><b>".$vs['login']."<b></th>
			</tr>
			<tr>
				<td><img src='pokemony/".$uzytkownik['aktywny_pokemon'].".png' alt='' width='125px'/></td>
				<td><img src='pokemony/".$vs['aktywny_pokemon'].".png' alt='' width='125px'/></td>
			</tr>
			<tr>
				<td>
					<b><i>".$uzytkownik['nazwa']."</i></b>
					<ul>
						<li>Umiejętność Ataku: ".$uzytkownik['atak']."
						<li>Umiejętność Obrony: ".$uzytkownik['obrona']."
						<li>Moc: ".$uzytkownik['obrazenia_min']."-".$uzytkownik['obrazenia_max']."
						<li>Zdrowie: ".$uzytkownik['zycie']."/".$uzytkownik['zycie_max']."
					</ul>
				</td>
				<td>
					<b><i>".$vs['nazwa']."</i></b>
					<ul>
						<li>Umiejętność Ataku: ".$vs['atak']."
						<li>Umiejętność Obrony: ".$vs['obrona']."
						<li>Moc: ".$vs['obrazenia_min']."-".$vs['obrazenia_max']."
						<li>Zdrowie: ".$vs['zycie']."/".$vs['zycie_max']."
					</ul>
				</td>
			</tr>
			</table>
			<hr/>
			";
			$runda = 0;
			$punktyA = 0;
			$punktyB = 0;
			$wynik = 0;
			while(($vs['zycie'] > 0) && ($uzytkownik['zycie'] > 0) && ($runda < 20)){
				echo "<br/><br/><b>Runda ".++$runda."</b><br/><br/>";
				$szansa = floor($uzytkownik['atak'] / $vs['obrona'] *100);

				//max szansa na trafienie = 75%, a minimalna 25%
				if($szansa >= 75) $szansa = 75;
				elseif ($szansa < 25) $szansa = 25;

				$rand = rand(1,100);
				if($szansa >= $rand) {
					$rany = rand($uzytkownik['obrazenia_min'],$uzytkownik['obrazenia_max']);
					//minimalnie można zadać 1 ranę
					if($rany < 1) $rany = 1;
					$vs['zycie'] -= $rany;
					$punktyA += $rany;

					if($vs['zycie'] < 1){
						$vs['zycie'] = 0;
						echo "<b>".$uzytkownik['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$vs['nazwa']."</b> i wygrywa walkę. <br/>";
						$wynik = 1;
					} else {
						echo "<b>".$uzytkownik['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
						$szansa = floor($vs['atak'] / $uzytkownik['obrona'] *100);

						//max szansa na trafienie = 75%, a minimalna 25%
						if($szansa >= 75) $szansa = 75;
						elseif ($szansa < 25) $szansa = 25;

						$rand = rand(1,100);
						if($szansa >= $rand) {
							$rany = rand($vs['obrazenia_min'],$vs['obrazenia_max']);
							//minimalnie można zadać 1 ranę
							if($rany < 1) $rany = 1;
							$uzytkownik['zycie'] -= $rany;

							$punktyB += $rany;

							if($uzytkownik['zycie'] < 1){
								$uzytkownik['zycie'] = 0;
								echo "<b>".$vs['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
								$wynik = 2;
							} else {
								echo "<b>".$vs['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
							}
						} else {
							echo "<b>".$vs['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						}
					}
				} else {
					echo "<b>".$uzytkownik['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						$szansa = floor($vs['atak'] / $uzytkownik['obrona'] *100);

						//max szansa na trafienie = 75%, a minimalna 25%
						if($szansa >= 75) $szansa = 75;
						elseif ($szansa < 25) $szansa = 25;

						$rand = rand(1,100);
						if($szansa >= $rand) {
							$rany = rand($vs['obrazenia_min'],$vs['obrazenia_max']);
							//minimalnie można zadać 1 ranę
							if($rany < 1) $rany = 1;
							$uzytkownik['zycie'] -= $rany;

							$punktyB += $rany;

							if($uzytkownik['zycie'] < 1){
								$uzytkownik['zycie'] = 0;
								echo "<b>".$vs['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
								$wynik = 2;
							} else {
								echo "<b>".$vs['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
							}
						} else {
							echo "<b>".$vs['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
						}
				}
			}

			if($wynik == 0){
				//padł remis, nikt nikogo nie dobił, sprawdzamy punkty
				if($punktyA >= $punktyB) $wynik = 1; else $wynik = 2;
				echo "<br/><b> W walce padł remis, wygrywa ten, kto zadał więcej obrażeń</b><br/>";
			}

			if($wynik == 1){
				$punkty = floor($vs['punkty'] / 100) + 3;
				$exp = floor($vs['punkty'] / 100) + 2;
				$kasa =  floor($vs['punkty'] / 10) + 100;
				echo "
				<p class='note'>
					Po zwycięskiej walce <b>".$uzytkownik['login']."</b> otrzymuje ".$punkty ." punktów do Hydraulicznego Rankingu, ".$kasa." energii do omnitrixa oraz ".$exp." EXPa <br/>
				</p><br class='clear'>";

				mysql_query("update pokemon_gracze set akcje = akcje - 10, kasa = kasa + ".$kasa.", punkty = punkty + ".$punkty." where gracz = ".$uzytkownik['gracz']);
				mysql_query("update pokemon_pokemony_gracze set exp = exp + ".$exp." where gracz_id = ".$uzytkownik['gracz_id']);
				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);

				$uzytkownik['akcje'] -= 10;
				$uzytkownik['kasa'] += $kasa;
				$uzytkownik['punkty'] += $punkty;
				$uzytkownik['exp'] += $exp;
				$uzytkownik['ostatnia_walka'] = time();

				mysql_query("update pokemon_pokemony_gracze set zycie = ".$vs['zycie']." where gracz_id = ".$vs['gracz']." and pokemon_id = ".$vs['aktywny_pokemon']);

				mysql_query("insert into pokemon_poczta(od, do , typ, tytul, tresc, data) value (1,".$vs['gracz'].",1,'Wyzwano Cię na pojedynek Herosów','Przegrałeś pojedynek Kosmitów z graczem ".$uzytkownik['login']."', now())");
				
			} else {
				$punkty = floor($uzytkownik['punkty'] / 100) + 3;
				$kasa =  floor($uzytkownik['punkty'] / 10) + 100;
				echo "
				<p class='note'>
					Po przegranej walce z  <b>".$vs['nazwa']."</b> opuszczasz pole bitwy ze spuszczoną głową... 
				</p><br class='clear'>";

				mysql_query("update pokemon_gracze set akcje = akcje - 10 where gracz = ".$uzytkownik['gracz']);
				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);

				$uzytkownik['akcje'] -= 10;
				$uzytkownik['ostatnia_walka'] = time();

				mysql_query("update pokemon_pokemony_gracze set zycie = ".$vs['zycie']." where gracz_id = ".$vs['gracz']." and pokemon_id = ".$vs['aktywny_pokemon']);
				mysql_query("update pokemon_gracze set kasa = kasa + ".$kasa.", punkty = punkty + ".$punkty." where gracz = ".$vs['gracz']);

				mysql_query("insert into pokemon_poczta(od, do , typ, tytul, tresc, data) value (1,".$vs['gracz'].",1,'Wyzwano Cię na pojedynek Kosmitów','Wygrałeś pojedynek Herosów z graczem ".$uzytkownik['login']." i zdobyłeś ".$punkty ." punktów, ".$kasa." energii do omnitrixa oraz ".$exp." EXPa', now())");
			}

			
			
		}
	}
}


$przeciwnicy = mysql_query("select * from pokemon_gracze where punkty >= ".$uzytkownik['punkty']." and gracz  != ".$uzytkownik['gracz']." limit 5");

if(mysql_num_rows($przeciwnicy) == 0){
	echo "<p class='note'>Brak przeciwników wyżej w rankingu, skorzystaj z wyszukiwania po nicku</p><br class='clear'>";
} else {
	echo "
	<table>
	<tr>
	<td background='images/tbtlo.jpg' width='800' > <b><font color='Green'><center>Proponowani Przeciwnicy</td></font></b></td></center>
	</tr>
	</table>
	<table id='rank'>
		<tr style='background:#8F8F8F;'>
		<td background='images/tbtlo.jpg' width='300' > <b><font color='Green'><center>Pozycja</td>		<td background='images/tbtlo.jpg' width='300' > <b><font color='Green'><center>Gracz</td>		<td background='images/tbtlo.jpg' width='300' > <b><font color='Green'><center>Akcja</td></font></b></td></center>
		</tr>
	";

	if($uzytkownik['akcje'] >= 10){
		while($przeciwnik = mysql_fetch_array($przeciwnicy)){
			$i++;
			if($i % 2 == 0) $styl = " style='background:#828282'"; else $styl=" style='background:#4F4F4F'";
			echo "
			<tr align='center' ".$styl.">
				<td>".$i."</td>
				<td><a href='profile.php?player=".$przeciwnik['gracz']."'>".$przeciwnik['login']."</td>
				<td><a href='walki.php?walcz=".$przeciwnik['gracz']."'>Walcz</a></td>
			</tr>";
		}
	} else {
		while($przeciwnik = mysql_fetch_array($przeciwnicy)){
			$i++;
			if($i % 2 == 0) $styl = " style='background:#828282'"; else $styl=" style='background:#4F4F4F'";
			echo "
			<tr align='center' ".$styl.">
				<td>".$i."</td>
				<td>".$przeciwnik['login']."</td>
				<td>Za mało punktów akcji</td>
			</tr>";
		}
	}
	echo "</table>";
}

echo "
<center><b>Lub jeżeli nie chcesz używać podpowiedzi systemu, to wpisz login użytkownika tutaj:</b><br/></center><hr/>


<form action='walki.php' method='post'>
<input type='text' name='login'/> <input type='submit' value='walcz'>
</form>
";



//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 