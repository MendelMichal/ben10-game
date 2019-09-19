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

echo "<h2>Opcje VIP</h2><hr/>";

if(!empty($_POST['kod'])){
	$kod = mysql_real_escape_string(trim($_POST['kod']));

	$jest = mysql_fetch_array(mysql_query("select id from pokemon_kody where kod = '".$kod."' and status = 0"));
	$jest5 = mysql_fetch_array(mysql_query("select id from pokemon_kody5 where kod = '".$kod."' and status = 0"));

switch($_POST['viper']){
		case 1:
	if(empty($jest)) echo "<p class='error'>Nie ma takiego kodu</p><br class='clear'>"; else {
		if($uzytkownik['vip'] > time()){
			mysql_query("update pokemon_gracze set vip = vip + ".(30*86400).", akcje_max = 1000 where gracz = ".$uzytkownik['gracz']);
			$uzytkownik['vip'] += 30*86400;
			$uzytkownik['akcje_max'] = 1000;
		} else {
			mysql_query("update pokemon_gracze set vip = ".(time() + 30*86400).", akcje_max = 1000 where gracz = ".$uzytkownik['gracz']);
			$uzytkownik['vip'] = time() + 30*86400;
			$uzytkownik['akcje_max'] = 1000;
			$uzytkownik['akcje'] += 900;
			}
		mysql_query("update pokemon_kody set status = 1, gracz_id = ".$uzytkownik['gracz']." where id = ".$jest['id']);			
		echo "<p class='note'>Ustawiono konto VIP</p><br class='clear'>";
		
	}
		break;

		case 2:
	if(empty($jest5)) echo "<p class='error'>Nie ma takiego kodu</p><br class='clear'>"; else {
		if($uzytkownik['vip'] > time()){
			mysql_query("update pokemon_gracze set vip = vip + ".(45*86400).", akcje_max = 1000 where gracz = ".$uzytkownik['gracz']);
			$uzytkownik['vip'] += 45*86400;
			$uzytkownik['akcje_max'] = 1000;
			mysql_query("insert into pokemon_pokemony_gracze(gracz_id, pokemon_id, nazwa, atak, obrona, obrazenia_min, obrazenia_max, zycie, zycie_max, ewolucjaLvl, ewolucjaPrzedmiot) value (".$uzytkownik['gracz'].",9,'Inferno',12,12,12,16,40,40,30,1)") or die(mysql_error());
		} else {
			mysql_query("update pokemon_gracze set vip = ".(time() + 45*86400).", akcje_max = 1000 where gracz = ".$uzytkownik['gracz']);
			$uzytkownik['vip'] = time() + 45*86400;
			$uzytkownik['akcje_max'] = 1000;
			$uzytkownik['akcje'] += 900;
			mysql_query("insert into pokemon_pokemony_gracze(gracz_id, pokemon_id, nazwa, atak, obrona, obrazenia_min, obrazenia_max, zycie, zycie_max, ewolucjaLvl, ewolucjaPrzedmiot) value (".$uzytkownik['gracz'].",9,'Inferno',12,12,12,16,40,40,30,1)") or die(mysql_error());
		}
		mysql_query("update pokemon_kody5 set status = 1, gracz_id = ".$uzytkownik['gracz']." where id = ".$jest5['id']);
		echo "<p class='note'>Ustawiono konto VIP</p><br class='clear'>";
		
		}
		break;
		}
		}
echo"

<p>
Posiadając konto VIP masz do wykorzystania więcej akcji dziennie oraz możesz zyskać premium Herosa<br/>
Używając pierwszy raz lub ponownie kodu przedłużasz czas trwania konta VIP<br/><br/>

		<ul>
<table border cellspacing='8'>
<tr></tr>
<tr></tr>
<td><img src='obrazki/vip.png' alt=''/></td>
    <td><center>Opcja nr. 1:
	<hr/>
	Konto VIP na 30 dni<hr/>
	Aby otrzymać kod wyślij SMS o treści HPAY.BEN10GAME na numer 7355<br/>
Cena 3,69zł z VAT
<tr></tr>
<tr></tr>
<td><img src='pokemony/9_vip.png' alt=''/></td>
    <td><center>Opcja nr. 2:
	<hr/>
	Konto VIP na 45 dni + Specjalny Heros - Inferno 
	<hr/>
	Aby otrzymać kod wyślij SMS o treści HPAY.BEN10GAME na numer 7555<br/>
Cena 6,15 zł z VAT
</table></center>

        </ul>";


if($uzytkownik['vip'] > time()){
	$pozostalo = $uzytkownik['vip'] - time();
	echo "

	<script type='text/javascript'>        
        function liczCzas(ile) {
			dni = Math.floor(ile / 86400);
            godzin = Math.floor((ile - dni * 86400)/ 3600);
            minut = Math.floor((ile - dni * 86400 - godzin * 3600) / 60);
            sekund = ile - dni * 86400 - minut * 60 - godzin * 3600;
            if (godzin < 10){ godzin = '0'+ godzin; }
            if (minut < 10){ minut = '0' + minut; }
            if (sekund < 10){ sekund = '0' + sekund; }
            if (ile > 0) {
                ile--;
                document.getElementById('zegar').innerHTML = dni + ' dni ' +godzin + ':' + minut + ':' + sekund;
                setTimeout('liczCzas('+ile+')', 1000);
            } else {
                document.getElementById('zegar').innerHTML = '[koniec]';
            }
        }
    </script>
	Do końca okresu VIP pozostało: <b><span id='zegar'></span></b><script type='text/javascript'>liczCzas(".$pozostalo.")</script>  
	";
}

echo "
<form action='vip.php' method='post'>
<select name='viper'>
          <option value='0'>Wybierz, rodzaj VIPa</option>
          <option value='1'>Opcja nr. 1</option>
          <option value='2'>Opcja nr. 2</option>
    </select>
Podaj kod: <input type='text' style='width:200px' name='kod' /> <td colspan=2 align='center'><input type='submit' value='użyj'/>
</form>
<hr/>
";






//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 