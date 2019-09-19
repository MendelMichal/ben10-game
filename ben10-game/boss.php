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

echo "
<h2>Bossowie</h2><hr/>";

echo "
<p>
<center>Wybierz z kim chcesz się zmierzyć, aby zrujnować złe plany i powstrzymać postępki zła !<hr/><hr/></center>
<br>
<br>
<br>";

echo "
<a href='ropucha.php'>Doktor Animo</a><hr/>
<br>
<br>
<a href='jonah.php'>Jonah Melville</a><hr/>
<br>
<br>";
		
//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();