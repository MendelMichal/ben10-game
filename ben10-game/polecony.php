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

    echo  '<h2><center>Twój ref-link</center></h2>
<input type="text" name="link" value="http://ben10game.ugu.pl/?ref='.$uzytkownik['gracz'].'" style="width:100%; text-align: center;" onclick="this.select()" onchange="this.value=\'http://ben10game.ugu.pl/?ref='.$uzytkownik['gracz'].'\'"/>';

$poleceni = mysql_query('SELECT gracz, login FROM pokemon_gracze WHERE ref = '.$uzytkownik['gracz']);
if(mysql_num_rows($poleceni) != 0) {
echo	'<h2><center>Twoi Poleceni</center></h2>
        <table><tr>
        <th>Lp</th>
        <th>Login</th></tr>';
    for($i=1;$q = mysql_fetch_assoc($poleceni);++$i) {
        echo '<tr>
        <td>'.$i.'</td>
        <td>'.$q['login'].'</td></tr>';
    }
echo '</table>';
}
//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 