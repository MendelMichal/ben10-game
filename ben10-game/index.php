<?php
//włączamy bufor
ob_start();
//pobieramy zawartość pliku ustawień
require_once('var/ustawienia.php');
//startujemy lub przedłużamy sesję
session_start();
//pobieramy nagłówek strony
require_once('gora_strony.php');

//pobieramy zawartość menu
require_once('menu.php');

 if(isset($_GET['ref'])) { //sprawdzamy czy gość jest poleconym
    $_GET['ref'] = (int)$_GET['ref']; //rzutujemy na int co by ktoś nam jakiegoś świństwa w get nie podrzucił

    //teraz próbujemy pobrać użytkownika o podanym id z bazy danych, aby sprawdzić czy istnieje (ktoś mógł podać 
    //nieprawidłowe id, albo użytkownik został już skasowany a link polecający wciąż gdzieś w internecie istnieje
    $polecony = mysql_result(mysql_query('SELECT gracz FROM pokemon_gracze WHERE gracz = '.$_GET['ref']),0);
    if(empty($polecony)) { //jeśli gracz nie istnieje, usuwamy zmienną get poprzez przekierowanie na stronę główną
        header('location: index.php');
    } else {
        //zapisujemy id w sesji (trzeba pamiętać by wcześniej sesję zainicjować, jeśli nasza strona tego już nie robi)
        $_SESSION['ref'] = $polecony;

        //Jeśli chcemy by kierowała gościa odrazu do rejestracji to możemy zrobić to np tak:
        header('location: rejestracja.php');
    }
}

?>
<?php

//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');
//pobieramy stopkę
require_once('dol_strony.php');
//wyłączamy bufor
ob_end_flush();
?> 