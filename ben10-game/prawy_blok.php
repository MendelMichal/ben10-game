		</div>
	<div id="sidebar">
	<?php
	$om = mysql_fetch_array(mysql_query("select * from pokemon_przedmioty_gracze"));
$max = 50; // max dlugosc paska
$h = 10; //wysokość paska życia
$gracz['zycie'] = 10;
$gracz['zycie_max'] = 100;
$stan = floor($gracz['zycie'] / $gracz['zycie_max'] * 100);
if($uzytkownik['vip'] > 0) $vip = '_vip'; else $vip = '';
if($uzytkownik['ewol'] == 1) $ewol = '_e'; else $ewol = '';
?>
	<?php
	if(!empty($uzytkownik['gracz'])){
		echo "
<table  border='1' rules='none' bordercolor='#9C9C9C' style='background:#9C9C9C'>
<tr>
	<td background='images/tbtlo.jpg'  width='240'><center><b><font color='green'>Statystyki</font></b></center></td>
</tr>
<tr style='background:#9C9C9C'>
<td>
<table>
<tr style='background:#9C9C9C'>
			<td colspan=2><img src='omnitrix/".$uzytkownik['aktywny_omnitrix'].".png' alt=''/></td>
</table>
<table style='background:white'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Energia Omnitrixa</td></font></b></td>
			<td width='100' align='center'>".number_format($uzytkownik['kasa'],0,',','.')."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Akcje</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['akcje']." / ".$uzytkownik['akcje_max']."</td>
		</tr>
<table style='background:white'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Punkty Rankingu</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['punkty']."</td>
		</tr>
		</table>

<table  border='1' rules='none' bordercolor='#9C9C9C' style='background:#9C9C9C'>
<tr>
	<td background='images/tbtlo.jpg'  width='240'><center><b><font color='green'>Heros</font></b></center></td>
</tr>
<table style='background:white'>

	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Aktywny Heros</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['nazwa']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Atak</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['atak']."</td>
		</tr>
<table style='background:white'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Obrona</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['obrona']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Wytrzymałość</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zycie']."/".$uzytkownik['zycie_max']."</td>
		</tr>
<table style='background:white'>
	    <tr >
			<td width='150' align='center'><b><font size='2' color='gray'>Moc</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['obrazenia_min']."-".$uzytkownik['obrazenia_max']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Level</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['lvl']."</td>
		</tr>
<table style='background:white'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>EXP</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['exp']."/".$uzytkownik['expMax']."</td>
		</tr>
<table style='background:#9C9C9C'>
		<tr>
			<td colspan=2><img src='pokemony/".$uzytkownik['pokemon_id'].$ewol.$vip.".png' alt=''/></td>
		</tr>
		</table>
		<br>
<table  border='1' rules='none' bordercolor='#9C9C9C' style='background:#9C9C9C'>
<tr>
	<td background='images/tbtlo.jpg'  width='240'><center><b><font color='green'>Ewolucja Herosa</font></b></center></td>
</tr>
<table style='background:white'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Potrzebny level</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['ewolucjaLvl']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Potrzebny omnitrix</td></font></b></td>
			<td width='100' align='center'>Ultimate Omnitrix</td>
		</tr>
			</table>
			<br>
<table  border='1' rules='none' bordercolor='#9C9C9C' style='background:#9C9C9C'>
<tr>
	<td background='images/tbtlo.jpg'  width='240'><center><b><font color='green'>Statystyki Ogólne Gracza</font></b></center></td>
</tr>
<table style='background:white'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Pokonane Małe Roboty</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zabitemaleroboty']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Pokonane Duże Roboty</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zabiteduzeroboty']."</td>
		</tr>
<table style='background:white'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Pokonane Mutanty Animo</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zabiteropuchy']."</td>
		</tr>
<table style='background:#9C9C9C'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Pokonani Źli Ekolodzy</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zabitejonah']."</td>
		</tr>
<table style='background:white'>
	    <tr>
			<td width='150' align='center'><b><font size='2' color='gray'>Pokonane MegoWhatty</td></font></b></td>
			<td width='100' align='center'>".$uzytkownik['zabitemegawhatty']."</td>
		</tr>
			</table>
		
		</td>
</tr>
</table>
</td>
</tr>
</table><br>
		";
	}
	?>
      
   </div>
    