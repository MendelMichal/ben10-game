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

echo "<h2><center>Legium Domena</center></h2><hr/>";
if(($uzytkownik['pracuje'] < time())  && ($uzytkownik['pracuje'] > 0)){
	mysql_query("update pokemon_gracze set pracuje = 0, pracuje_godzin = 0, kasa = kasa + ".($uzytkownik['pracuje_godzin'] * 100)." where gracz =".$uzytkownik['gracz']);
	header("location: legium.php");
}
if(isset($_GET['przerwij']) && ($uzytkownik['pracuje'] > 0)){
	mysql_query("update pokemon_gracze set pracuje = 0, pracuje_godzin = 0 where gracz =".$uzytkownik['gracz']);
	header("location: legium.php");
}

if(!empty($_GET['praca']) && ($uzytkownik['pracuje'] == 0)){
	switch($_GET['praca']){
		case 1:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 3600).", pracuje_godzin = 1 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 2:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 7200).", pracuje_godzin = 2 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 3:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 10800).", pracuje_godzin = 3 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 4:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 14400).", pracuje_godzin = 4 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 5:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 18000).", pracuje_godzin = 5 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 6:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 21600).", pracuje_godzin = 6 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;	
		case 7:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 25200).", pracuje_godzin = 7 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 8:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 28800).", pracuje_godzin = 8 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		case 9:
			mysql_query("update pokemon_gracze set pracuje = ".(time() + 32400).", pracuje_godzin = 9 where gracz =".$uzytkownik['gracz']);
			header("location: legium.php");
		break;
		default:
			echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
		break;
	}	
}

if($uzytkownik['pracuje'] > 0){
	$pozostalo = $uzytkownik['pracuje'] - time();
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
		Do końca pobytu w Krainie Legium Domena pozostało: <center><br><b><span id='zegar'></span> <a href='legium.php?przerwij' style='color:#76EE00; text-decoration:none' title='przerwij'>[ PRZERWIJ ]</a></b><script type='text/javascript'>liczCzas(".$pozostalo.")</script>  </center>
	</p><br class='clear'>";
} else {

	echo "
		<table style='background:#828282'>
		<tr>
		<td style='background:#828282'><b><center>Plotki krążące po kosmicznym wszechświecie mówią, iż w Krainie Legium Domena można podładować się magiczną energią. Możesz się tam udać, aby zasilić swój Omnitrix</b></center>
		</table>
		</td>
		</tr>
		
		<br>
		<br>
		<table>
		<tr>
		<td background='images/tbtlo.jpg' width='300' > <b><font color='Green'><center>Ilość Godzin</td>		<td background='images/tbtlo.jpg' align='center' width='300' ><b><font color='Green'><center>Zyskana Energia</td>		<td background='images/tbtlo.jpg' align='center' width='300' ><b><font color='Green'><center>Akcja</td></font></b></td></center>
		</tr>
		</table>
		
		<table style='background:#828282' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>1 godzina</font></b></td></center>		<td width='300' > <font color='Green'><center>100 Energii</font></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=1'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#B5B5B5' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>2 godziny</font></b></td></center>		<td width='300' > <font color='Green'><center>200 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=2'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#828282' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>3 godziny</font></b></td></center>		<td width='300' > <font color='Green'><center>300 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=3'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#B5B5B5' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>4 godziny</font></b></td></center>		<td width='300' > <font color='Green'><center>400 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=4'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#828282' id='rank' rules='none' bordercolor='black' border='1'>
		    <tr>
		<td width='300' > <font color='#00FF00'><center>5 godzin</font></b></td></center>		<td width='300' > <font color='Green'><center>500 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=5'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#B5B5B5' id='rank' rules='none' bordercolor='black' border='1'>
		    <tr>
		<td width='300' > <font color='#00FF00'><center>6 godzin</font></b></td></center>		<td width='300' > <font color='Green'><center>600 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=6'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#828282' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>7 godzin</font></b></td></center>		<td width='300' > <font color='Green'><center>700 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=7'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#B5B5B5' id='rank' rules='none' bordercolor='black' border='1'>
		    <tr>
		<td width='300' > <font color='#00FF00'><center>8 godzin</font></b></td></center>		<td width='300' > <font color='Green'><center>800 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=8'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
		
		<table style='background:#828282' id='rank' rules='none' bordercolor='black' border='1'>
	    <tr>
		<td width='300' > <font color='#00FF00'><center>9 godzin</font></b></td></center>		<td width='300' > <font color='Green'><center>900 Energii</font></b></td></center>			<td align='center' width='300' ><font color='Green'><center><a href='legium.php?praca=9'>Udaj się tam</font></b></td></center></a>
		</tr>
		</table>
	";

}




//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 