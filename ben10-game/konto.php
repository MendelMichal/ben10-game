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


if(isset($_GET['zmien_opis']) && !empty($_POST['opis'])){
	$_POST['opis'] = substr($_POST['opis'],0,100);
	$_POST['opis2'] = mysql_real_escape_string(trim(nl2br($_POST['opis'])));
	mysql_query("update pokemon_gracze set opis = '".$_POST['opis2']."' where gracz = ".$uzytkownik['gracz']);
	$uzytkownik['opis'] = trim(nl2br($_POST['opis']));

}elseif(isset($_GET['zmien_haslo']) && !empty($_POST['haslo']) && !empty($_POST['haslo2']) && !empty($_POST['nowe'])  ){

	if(($_POST['haslo'] != $_POST['haslo2'])){
		echo "<p class='error'>Wypełnij wszystkie pola poprawnie</p><br class='clear'>";		
	} elseif( md5($_POST['haslo']) != $uzytkownik['haslo']){
		echo "<p class='error'>Błędne stare hasło</p><br class='clear'>";		
	} elseif(strlen($_POST['nowe']) <5 ) {
        echo "<p class='error'>hasło za krótkie [5-10 znaków]</p><br class='clear'>";
    } elseif(strlen($_POST['nowe']) >10 ) {
        echo "<p class='error'> hasło za długie [5-10 znaków] </p><br class='clear'>";
    } else {
		$_POST['nowe'] = md5($_POST['nowe']);
		mysql_query("update pokemon_gracze set haslo = '".$_POST['nowe']."' where gracz = ".$uzytkownik['gracz']);
		echo "<p class='note'>Zmieniono hasło</p><br class='clear'>";
	}
}elseif(isset($_GET['zmien_avatar']) && !empty($_FILES['plik'])){
	$plik_tmp = $_FILES['plik']['tmp_name'];
	$plik_nazwa = $_FILES['plik']['name'];
	$plik_rozmiar = $_FILES['plik']['size'];

	if(is_uploaded_file($plik_tmp)) {
		 move_uploaded_file($plik_tmp, "avatar/".$uzytkownik['gracz'].".jpg");
		 mysql_query("update pokemon_gracze set avatar = 1 where gracz = ".$uzytkownik['gracz']);
		 $uzytkownik['avatar'] = 1;
		echo "<p class='note'>Zmieniono avatar</p><br class='clear'>";
	} else {
		echo "<p class='error'>Błąd, spróbuj ponownie</p><br class='clear'>";
	}
}

echo "<h2>Witaj <i>".$uzytkownik['login']."</i></h2><hr/>";
echo "<p>".$uzytkownik['opis']."</p><hr class='clear' style='margin-bottom:40px'/>";

echo "
<p id='zmien_opis'>
	<form action='konto.php?zmien_opis' method='post' style='background:#828282; padding:5px;'>
	Zmień opis (max 100 znaków)<br/>
	<textarea name='opis' style='width:500px; height:70px'>".strip_tags($uzytkownik['opis'])."</textarea><br/>
	<input type='submit' value='zmień opis' name='zmien_opis'/>
	</form>
</p>
<hr class='clear'/>
";

echo "
<p id='zmien_haslo'>
	<form action='konto.php?zmien_haslo' method='post' style='background:#828282; padding:5px;'>
	Zmień hasło
	<table>
        <tr>
            <td>stare hasło:</td>
            <td><input type='password'  name='haslo'/></td>
        </tr>
		<tr>
            <td>powtórz stare hasło:</td>
            <td><input type='password'  name='haslo2'/></td>
        </tr>
		<tr>
            <td>nowe hasło [5-10 znaków]:</td>
            <td><input type='password'  name='nowe'/></td>
        </tr>
        <tr>
			<td></td>
            <td align='center'>
                <input type='submit'  value='zmień' name='zmien_haslo'/>
            </td>
        </tr>
   </table>
   </form>
</p>
<hr class='clear'/>
";

echo "
<hr class='clear'/>
";
echo "<center>Twój Ref-Link to:</center>";
echo '<input type="text" name="link" value="http://ben10-game.pl/?ref='.$uzytkownik['gracz'].'" style="width:100%; text-align: center;" onclick="this.select()" onchange="this.value=\'http://ben10game.pl/?ref='.$uzytkownik['gracz'].'\'"/>'; 

$poleceni = mysql_query('SELECT gracz, login FROM pokemon_gracze WHERE ref = '.$uzytkownik['gracz']);
if(mysql_num_rows($poleceni) != 0) {
    echo  '<h2>Twoi Poleceni</h2>
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