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

$NPC = array(
            array(
                'name' => 'Dr. Animo', 
                'lvl' => array(1, 100000000), 
                'heroes' => array(
                    array(
                        'name' => 'Zmutowana Ropucha', 
                        'attack' => 8, 'defense' => 8, 
                        'dmg' => array(7, 12), 
                        'hp' => 45, 'img' => 102, 
                        'points' => 120
                        )
						)
						)
    ); 

//pobieramy zawartość menu
require_once('menu.php');


    function CanFight($lvl, $arr)
    {
        
        if($lvl>=$arr[0] && $lvl<=$arr[1])
            return true;
            
            return false;
        
    }

    echo  '<h2><center>Walka z Ropuchą</center></h2>';
    
    if(!isset($_GET['id']))
    {
	foreach($NPC as $id => $r)
            {
                
                if( CanFight($uzytkownik['lvl'], $r['lvl']) )
                {
	echo "<center><hr/><p>
Już teraz możesz udać się do siedziby Dr. Animo, aby uprzykrzyć mu trochę życie i zapobiec odkryciu nowego gatunku mutanta<br/>
Jeśli uda Ci się pokonać wroga otrzymasz trochę punktów, Energii Omnitrixa oraz EXPa !<br/>
Koszt jednej wyprawy to 10 Punktów Akcji<br/><br/></center><hr/>

		<ul>
<table border cellspacing='8'>
<tr></tr>
<tr></tr>
<td><img src='postacie/animo.png' alt=''/></td>
    <td><center>Siedziba Doktora <br> Animo:
	<hr/>";
echo '<a href="ropucha.php?id='.$id.'">Wyrusz tam !</a></li>';
echo "</table></center>

        </ul>";

        }
		}
		}
     
    
	
    elseif( isset($NPC[$_GET['id']]) && CanFight($uzytkownik['lvl'], $NPC[$_GET['id']]['lvl']) )
    {
        
        $oponent = & $NPC[$_GET['id']];
                    
            	if($uzytkownik['akcje'] < 10){
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
            		if(true) {
            			// przebieg walki
                        
                        $monsters = count($oponent['heroes'])-1;
                        $monster = $oponent['heroes'][rand(0, $monsters)];
                        
            			echo "<p class='note'>Podczas swojej podrózy napotkałeś <b>".$oponent['name']."</b>, który dał do walki <b>".$monster['name']."</b> </p><br class='clear'>
            
            			<table id='rank'>
            			<tr>
            				<th><b>".$uzytkownik['login']."<b></th>
            				<th><b>".$oponent['login']."<b></th>
            			</tr>
            			<tr>
            				<td><img src='pokemony/".$uzytkownik['aktywny_pokemon'].".png' alt='' width='125px'/></td>
            				<td><img src='pokemony/".$monster['img'].".png' alt='' width='125px'/></td>
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
            					<b><i>".$monster['name']."</i></b>
            					<ul>
            						<li>Umiejętność Ataku: ".$monster['attack']."
            						<li>Umiejętność Obrony: ".$monster['defense']."
            						<li>Moc: ".$monster['dmg'][0]."-".$monster['dmg'][1]."
            						<li>Zdrowie: ".$monster['hp']."/".$monster['hp']."
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
            			while(($monster['hp'] > 0) && ($uzytkownik['zycie'] > 0) && ($runda < 20)){
            				echo "<br/><br/><b>Runda ".++$runda."</b><br/><br/>";
            				$szansa = floor($uzytkownik['atak'] / $monster['defense'] *100);
            
            				//max szansa na trafienie = 75%, a minimalna 25%
            				if($szansa >= 75) $szansa = 75;
            				elseif ($szansa < 25) $szansa = 25;
            
            				$rand = rand(1,100);
            				if($szansa >= $rand) {
            					$rany = rand($uzytkownik['obrazenia_min'],$uzytkownik['obrazenia_max']);
            					//minimalnie można zadać 1 ranę
            					if($rany < 1) $rany = 1;
            					$monster['hp'] -= $rany;
            					$punktyA += $rany;
            
            					if($monster['hp'] < 1){
            						$monster['hp'] = 0;
            						echo "<b>".$uzytkownik['nazwa']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$monster['name']."</b> i wygrywa walkę. <br/>";
            						$wynik = 1;
            					} else {
            						echo "<b>".$uzytkownik['nazwa']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
            						$szansa = floor($monster['attack'] / $uzytkownik['obrona'] *100);
            
            						//max szansa na trafienie = 75%, a minimalna 25%
            						if($szansa >= 75) $szansa = 75;
            						elseif ($szansa < 25) $szansa = 25;
            
            						$rand = rand(1,100);
            						if($szansa >= $rand) {
            							$rany = rand($monster['dmg'][0],$monster['dmg'][1]);
            							//minimalnie można zadać 1 ranę
            							if($rany < 1) $rany = 1;
            							$uzytkownik['zycie'] -= $rany;
            
            							$punktyB += $rany;
            
            							if($uzytkownik['zycie'] < 1){
            								$uzytkownik['zycie'] = 0;
            								echo "<b>".$monster['name']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
            								$wynik = 2;
            							} else {
            								echo "<b>".$monster['name']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
            							}
            						} else {
            							echo "<b>".$monster['name']."</b> nie mógł trafić przeciwnika.<br/>";
            						}
            					}
            				} else {
            					echo "<b>".$uzytkownik['nazwa']."</b> nie mógł trafić przeciwnika.<br/>";
            						$szansa = floor($monster['attack'] / $uzytkownik['obrona'] *100);
            
            						//max szansa na trafienie = 75%, a minimalna 25%
            						if($szansa >= 75) $szansa = 75;
            						elseif ($szansa < 25) $szansa = 25;
            
            						$rand = rand(1,100);
            						if($szansa >= $rand) {
            							$rany = rand($monster['dmg'][0],$monster['dmg'][1]);
            							//minimalnie można zadać 1 ranę
            							if($rany < 1) $rany = 1;
            							$uzytkownik['zycie'] -= $rany;
            
            							$punktyB += $rany;
            
            							if($uzytkownik['zycie'] < 1){
            								$uzytkownik['zycie'] = 0;
            								echo "<b>".$monster['name']."</b> <span style='color:#CC0000'>decydującym ciosem</span> powala <b>".$uzytkownik['nazwa']."</b> i wygrywa walkę. <br/>";
            								$wynik = 2;
            							} else {
            								echo "<b>".$monster['name']."</b> zadaje <span style='color:#CC0000'>".$rany."</span> obrażeń przeciwnikowi. <br/>";
            							}
            						} else {
            							echo "<b>".$monster['name']."</b> nie mógł trafić przeciwnika.<br/>";
            						}
            				}
            			}
            
            			if($wynik == 0){
            				//padł remis, nikt nikogo nie dobił, sprawdzamy punkty
            				if($punktyA >= $punktyB) $wynik = 1; else $wynik = 2;
            				echo "<br/><b> W walce padł remis, wygrywa ten, kto zadał więcej obrażeń</b><br/>";
            			}
            
            			if($wynik == 1){
            				$exp = floor($monster['points'] / 100) + 2;
            				$kasa =  floor($monster['points'] / 10) + 100;
            				echo "
            				<p class='note'>
            					Po zwycięskiej walce <b>".$uzytkownik['login']."</b> otrzymuje ".$kasa." energii do omnitrixa oraz ".$exp." EXPa <br/>
            				</p><br class='clear'>";
            
            				mysql_query("update pokemon_gracze set akcje = akcje - 10, kasa = kasa + ".$kasa." where gracz = ".$uzytkownik['gracz']);
            				mysql_query("update pokemon_gracze set zabiteropuchy = zabiteropuchy + 1 where gracz = ".$uzytkownik['gracz']);
            				mysql_query("update pokemon_pokemony_gracze set exp = exp + ".$exp." where gracz_id = ".$uzytkownik['gracz_id']);
            				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);
            
            				$uzytkownik['akcje'] -= 10;
            				$uzytkownik['kasa'] += $kasa;
            				$uzytkownik['exp'] += $exp;
            				$uzytkownik['zabiteropuchy'] += 1;
            				$uzytkownik['ostatnia_walka'] = time();
                        				
            			} else {
            				$punkty = floor($uzytkownik['punkty'] / 100) + 3;
            				$kasa =  floor($uzytkownik['punkty'] / 10) + 100;
            				echo "
            				<p class='note'>
            					Po przegranej walce z  <b>".$monster['name']."</b> opuszczasz pole bitwy  i patrzysz się jak Doktor Animo śmieje Ci się w twarz !
            				</p><br class='clear'>";
            
            				mysql_query("update pokemon_gracze set akcje = akcje - 10 where gracz = ".$uzytkownik['gracz']);
            				mysql_query("update pokemon_pokemony_gracze set zycie = ".$uzytkownik['zycie'].", ostatnia_walka = ".time()." where gracz_id = ".$uzytkownik['gracz']." and pokemon_id = ".$uzytkownik['aktywny_pokemon']);
            
            				$uzytkownik['akcje'] -= 10;
            				$uzytkownik['ostatnia_walka'] = time();
            
            			}
            
            			
            			
            		}
            	}

        
    }
    
//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 