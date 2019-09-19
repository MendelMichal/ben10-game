<?php

if(!empty($uzytkownik['gracz'])){
	if($uzytkownik['login'] == 'admin') 
		$opcja = " 
		<li> <a href='#'>Admin <img src='images/nav_bullet.jpg' alt='' /></a>
        <ul>
          <li><a href='admin.php?act=gracze'>Gracze</a></li>
          <li><a href='admin.php?act=vip'>Dodaj kody VIP</a></li>
		  <li><a href='admin.php?act=mass'>Wiadomość masowa</a></li>
		  <li><a href='admin.php?act=cron'>CRON</a></li>
        </ul>
      </li>"; 
	else 
		$opcja="";

	
	if($uzytkownik['poczta'] > 0) $poczta = "( ".$uzytkownik['poczta']." )"; else $poczta = "";
	echo"
    <ul id='nav'>
      <li>&nbsp;</li>
      <li> <a class='active'  href='konto.php'>Konto <img src='images/nav_bullet.jpg' alt='' /></a>
        <ul>
		  <li><a href='kosmici.php'>Kosmici</a></li>
		  <li><a href='omnitrix.php'>Omnitrixy</a></li>
          <li><a href='konto.php#zmien_haslo'>Zmiana hasła</a></li>
          <li><a href='konto.php#zmien_opis'>Opis</a></li>
        </ul>
      </li>
      <li> <a href='#'>Wyzwania <img src='images/nav_bullet.jpg' alt='' /></a>
        <ul>
          <li><a href='walki.php'>Pojedynki</a></li>
          <li><a href='ranking.php'>Ranking</a></li>
          <li><a href='misje.php'>Azmuth</a></li>
          <li><a href='boss.php'>Bossowie</a></li>
          <li><a href='wrogowie.php'>Wrogowie</a></li>
          <li><a href='misja.php'>Misje</a></li>
        </ul>
      </li>
	  <li> <a href='#'>Kryjówka <img src='images/nav_bullet.jpg' alt='' /></a>
        <ul>
          <li><a href='trening.php'>Trening</a></li>
          <li><a href='regeneracja.php'>Regeneracja</a></li>
		  <li><a href='legium.php'>Legium Domena</a></li>
		  <li><a href='nowi-herosi.php'>Nowi Herosi</a></li>
		  <li><a href='chatbox.php'>Chatbox</a></li>
        </ul>
      </li>
	  <li> <a href='#'>Poczta ".$poczta." <img src='images/nav_bullet.jpg' alt='' /></a>
        <ul>
          <li><a href='poczta.php?act=odebrane'>Odebrane</a></li>
          <li><a href='poczta.php?act=wyslane'>Wysłane</a></li>
		  <li><a href='poczta.php?act=nowa'>Nowa wiadomość</a></li>
        </ul>
      </li>
      <li><a href='vip.php'>VIP</a></li>
	  <li><a href='zapros.php'>Zaproś przyjaciela</a></li>
	  ".$opcja ."
     <li class='sep'>&nbsp;</li>
      <li>&nbsp;</li>
    </ul>
	<div id='header'></div>
	";
}
echo "<div id='content'>";