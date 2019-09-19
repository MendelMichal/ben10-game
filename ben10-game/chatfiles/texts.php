<?php
// Texts added in site (English)
$en_site = array(
  'chat'=>'Chat',
  'name'=>'Nazwa',
  'code'=>'Kod',
  'addnmcd'=>'Wpisz swój nick oraz ten kod',
  'chatlogged'=>'<h4 id="chlogged">Żeby dodać wiadomość musisz być zalogowany.</h4>',
  'online'=>'Online',
  'no1online'=>'- Nikt nie jest online',
  'loadroom'=>'<h3>Ładowanie pokoju</h3>',
  'notchat'=>'Żadnych wiadomości dodanych do tego pokoju',
  'addurl'=>'Do linku dodaj http://',
  'logoutchat'=>'Wyloguj z chatu',
  'enterchat'=>'Witaj <b>%s</b> wejdz do chatu',
  'emptyroom'=>'Wybierz pokoj do opróżnienia',
  'cadmpass'=>'Hasło admina:',
  'sbmemptyroom'=>'Pusty pokój',
  'emptedroom'=>'Pokój: <b>%s</b> jest pusty',
  'err_emptedroom'=>'Nie można opróżnić pokoju: ',
  'err_savechat'=>'Nie można zapisać danych w: %s , lub plik nie może zostać utworzony',
  'err_name'=>'Nick musi zawierać od 2 do 16 liter',
  'err_nameused'=>' - jest już używany. \n Wybierz inny nick',
  'err_vcode'=>'Przepisz dobrze kod',
  'err_textchat'=>'Wiadomość musi zawierać od 2 do 200 liter',
  'err_addurl'=>'Niepoprawny format link \n Dodaj url bez http:// \n Example: coursesweb.net/ajax/'
);


// Sets an json object for JavaScript with text messages according to language set
function jsTexts($lsite) {
  // define the JavaScript json object
$texts = 'var texts = {
 "err_name":"'.$lsite['err_name'].'",
 "err_nameused":"'.$lsite['err_nameused'].'",
 "err_vcode":"'.$lsite['err_vcode'].'",
 "err_textchat":"'.$lsite['err_textchat'].'",
 "err_addurl":"'.$lsite['err_addurl'].'",
 "loadroom":"'.$lsite['loadroom'].'",
 "addurl":"'.$lsite['addurl'].'"
};';

  return '<script type="text/javascript"><!--'.PHP_EOL.
  $texts.PHP_EOL.
  '//-->
  </script>';
}