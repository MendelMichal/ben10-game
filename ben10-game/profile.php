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


               $player = $_GET;
      $gracz = mysql_fetch_array(mysql_query("select * from pokemon_gracze where gracz = '".$player['player']."'" ));
	$ben = mysql_fetch_array(mysql_query("select * from pokemon_pokemony_gracze where gracz_id = ".$gracz['gracz']." and pokemon_id = ".$gracz['aktywny_pokemon']));
	  
   
 
               echo "
			  <h2><center>Nazwa Gracza: " .$gracz['login']." </h2><hr/><font color='red'><a href='walki.php?walcz=".$gracz['gracz']."'><center>Akcje : Wyzwij na pojedynek!<b></center></a></font><hr/></center>
<center>
<table  border='1' rules='none' bordercolor='black' cellpadding='10' width='450'>
<tr>
<td background='images/tbtlo.jpg' ><b><font color='Red'><center><b><i>".$gracz['nazwa']."</i></b></center></font></td>
</font></b></center>
</tr>
		</center>
<tr>
<td width='350' style='background:#E8E8E8'><center><img src='pokemony/".$gracz['aktywny_pokemon'].".png' alt=''/></center>
</td>
</table>

<table>
<thead>
<tr>
<th colspan='2' background='images/tbtlo.jpg' width='600'><b><font color='green'><center><b>Statystyki Herosa</th>
</tr>
</thead>

<tr>
<td background='images/tbtlo.jpg' width='300'><b><font color='green'><center><b><i>Umiejętność</td>	<td background='images/tbtlo.jpg' width='300'><b><font color='green'><center><b><i>Wartość</td>
</tr>



<tr style='background:#828282'>
<td><b><font size='5'><center>Atak:</center></font></b></td>
<td><b><font size='5'><center>".$ben['atak']."</center></font></b></td>
</tr>

<tr style='background:#4F4F4F'>
<td><b><font size='5'><center>Obrona:</center></font></b></td>
<td><b><font size='5'><center>".$ben['obrona']."</center></font></b></td>
</tr>

<tr style='background:#828282'>
<td><b><font size='5'><center>Moc:</center></font></b></td>
<td><b><font size='5'><center>".$ben['obrazenia_min']."-".$ben['obrazenia_max']."</center></font></b></td>
</tr>

<tr style='background:#4F4F4F'>
<td><b><font size='5'><center>Zdrowie:</center></font></b></i></u></size></td>
<td><b><font size='5'><center>".$ben['zycie']."/".$ben['zycie_max']."</center></font></b></td>
</tr>
				
			
				<form action='kosmici.php?pokemon=".$gracz['aktywny_pokemon']."' method='post'>
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
	



//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?>