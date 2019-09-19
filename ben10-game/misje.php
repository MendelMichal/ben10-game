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

//pobieramy nagłówek strony
require_once('gora_strony.php');


//pobieramy zawartość menu
require_once('menu.php');

echo "<h2>Misje</h2><hr/>";
if(($uzytkownik['misje'] < time())  && ($uzytkownik['misje'] > 0)){
	mysql_query("update pokemon_gracze set misje = 0, misje_godzin = 0 where gracz =".$uzytkownik['gracz']);
	$szansa = rand(10,50) * $uzytkownik['misje_godzin'];
	$item = mysql_fetch_array(mysql_query("select * from pokemon_przedmioty_misje where szansa <= ".$szansa." order by rand() limit 1"));
	if(!empty($item)){
		mysql_query("insert into pokemon_przedmioty_gracze (ppid, gid, pid) value (".$item['id'].",".$uzytkownik['gracz'].",".$item['id'].")");
		echo "<p class='note'>Znalazłeś Azmutha, który podarował Ci ".$item['nazwa'].". Trafia on do twoich omnitrixów</p><br class='clear'>";
	} else {
		echo "<p class='error'>Niestety nic nie znalazłeś...</p><br class='clear'>";
	}

	$uzytkownik['misje'] = 0;
}
if(isset($_GET['przerwij']) && ($uzytkownik['misje'] > 0)){
	mysql_query("update pokemon_gracze set misje = 0, misje_godzin = 0 where gracz =".$uzytkownik['gracz']);
	header("location: misje.php");
}

if(!empty($_GET['misje']) && ($uzytkownik['misje'] == 0)){
	switch($_GET['misje']){
		case 1:
						if($uzytkownik['akcje'] < 9){
		echo "<p class='error'>Posiadasz za mało punktów akcji</p><br class='clear'>";}
										elseif($uzytkownik['akcje'] > 9){
			mysql_query("update pokemon_gracze set misje = ".(time() + 3600).", misje_godzin = 1 where gracz =".$uzytkownik['gracz']);
						mysql_query("update pokemon_gracze set akcje = akcje - 10");}
		
			header("location: misje.php");
		break;
		case 2:
						if($uzytkownik['akcje'] < 9){
		echo "<p class='error'>Posiadasz za mało punktów akcji</p><br class='clear'>";}
										elseif($uzytkownik['akcje'] > 9){
			mysql_query("update pokemon_gracze set misje = ".(time() + 7200).", misje_godzin = 2 where gracz =".$uzytkownik['gracz']);
						mysql_query("update pokemon_gracze set akcje = akcje - 10");}
		
			header("location: misje.php");
		break;
		case 3:
						if($uzytkownik['akcje'] < 9){
		echo "<p class='error'>Posiadasz za mało punktów akcji</p><br class='clear'>";}
								elseif($uzytkownik['akcje'] > 9){
			mysql_query("update pokemon_gracze set misje = ".(time() + 10800).", misje_godzin = 3 where gracz =".$uzytkownik['gracz']);
			mysql_query("update pokemon_gracze set akcje = akcje - 10");}
		
			header("location: misje.php");
		break;
		default:
			echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
		break;
	}
		
}

switch($_POST['mission'])
    {
        case 1:  
header('Location: misje.php?misje=1'); 
        break;  
        
        case 2:
header('Location: misje.php?misje=2'); 
        break;    
        
        case 3:
header('Location: misje.php?misje=3'); 
        break;    
    }

if($uzytkownik['misje'] > 0){
	$pozostalo = $uzytkownik['misje'] - time();
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
	<p class='note'>
		Do końca miji pozostało: <center><br><b><span id='zegar'></span> <a href='misje.php?przerwij' style='color:#76EE00; text-decoration:none' title='przerwij'>[ X ]</a></b><script type='text/javascript'>liczCzas(".$pozostalo.")</script>  </center>
	</p><br class='clear'>";
} else {

echo "
		<center>Możesz iść na poszukiwania miedzygalaktyczne Azmutha - inżyniera Omnitirxa. Zapewnie, jeśli uda Ci się go znaleźć otrzymasz nowego OMNITRIXA. Jeśli jednak misja się nie powiedzie wrócisz z niczym. Im dłużej trwa, tym większa szansa na znalezienie Azmutha<br><br>Koszt wyprawy to 10 akcji</center>
		<ul>
<table border cellspacing='8'>
<tr></tr>
<tr></tr>
<td><img src='postacie/Azmuth.png' alt=''/></td>
    <td>Wyrusz na wyprawę:
	<form method='post' name='theform' action=''>
    <select name='mission'>
          <option value='0'>Wybierz czas wyprawy</option>
          <option value='1'>1 godzina</option>
          <option value='2'>2 godziny</option>
          <option value='3'>3 godziny</option>
    </select><br><br>
	    <input type='submit' value='Idź!'/></td>
		</form>

</table>

        </ul>
	";

}



//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 