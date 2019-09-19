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


if($uzytkownik['misja'] == 0)
{
echo "<h2>Misja 1 : Jak to się wszystko zaczęło</h2><hr/>";
  echo "<center><hr/><p>
Kosmitka Ksylena ma na swoim statku Omnitrix, najpotężniejsze urządzenie we wszechświecie,  dzięki któremu użytkownik może się transformować w kilku różnych gatunków obcych. Jest ona ścigana przez Vilgaxa, cudzoziemca, który zdobyć urządzenie i stworzyć armię żołnierzy. Ksylena wysyła Omnitrix ma Ziemię, ustawiając DNA na Maxa Tennysona. Vilgax zniszczył statek kosmiczny obcej, ale było już za późno - kapsuła z Omnitrixem znalazła się już na orbicie planety, trafiając prosto w twoje ręce !
<br>
<br>
Vilgax jednak śledzi sygnał Omnitrixa i wysyła kilka swoich robotów. ".$uzytkownik['login']." wpada na pomysł wykorzystania zegarka, aby je zniszczyć ...<br><hr/>
";

  if($uzytkownik['zabitemaleroboty'] >= 5 && $uzytkownik['zabiteduzeroboty'] >= 1)
  {
  
      mysql_query("UPDATE `pokemon_gracze` SET `misja` = misja+1  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_gracze` SET `kasa` = kasa+500  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_pokemony_gracze` SET `exp` = exp+3  WHERE gracz='".$uzytkownik['gracz']."'");
  
  }


echo "<br>
<br>Zabite Małe Roboty : ".$uzytkownik['zabitemaleroboty']."/5 
<br>Zabite Duże Roboty : ".$uzytkownik['zabiteduzeroboty']."/1
<hr/>
Nagroda : 500 Energii Omnitrixa oraz 5 pkt EXPa";
}


if($uzytkownik['misja'] == 1)
{
echo "<h2>Misja 2 : Prehistoria</h2><hr/>";
  echo "<center><hr/><p>
Doktor Animo chce zmutować zwierzęta, by był większe i zniszczyły Waszyngton. ".$uzytkownik['login']." z dziadkiem i Gwen idą do supermarketu, jednak wtedy zmutowane zwierzęta atakują sklep . ".$uzytkownik['login']." zaczyna grać na wzłokę, gdyż czeka na naładowanie się zegarka. Po chwili zmutowana papuga porywa Gwen .
<br>
<br>
Musisz jakoś pogromić ulubione zwierzątko Doktora Animo - Zmutowaną Ropuchę i uratować Gwen !<br><hr/>
";

  if($uzytkownik['zabiteropuchy'] >= 1)
  {
  
      mysql_query("UPDATE `pokemon_gracze` SET `misja` = misja+1  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_gracze` SET `kasa` = kasa+700  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_pokemony_gracze` SET `exp` = exp+5  WHERE gracz='".$uzytkownik['gracz']."'");
  
  }


echo "<br>
<br>Zabite Zmutowane Ropuchy : ".$uzytkownik['zabiteropuchy']."/1
<hr/>
Nagroda : 700 Energii Omnitrixa oraz 5 pkt EXPa";
}



if($uzytkownik['misja'] == 2)
{
echo "<h2>Misja 3 : Krakken</h2><hr/>";
  echo "<center><hr/><p>
".$uzytkownik['login'].", Gwen i dziadek jadą nad jezioro. Tam ".$uzytkownik['login']." zauważa potwora morskiego. Później ".$uzytkownik['login']." i dziadek jadą statkiem kapitana Shawa na jezioro, łowić ryby. Tymczasem pewien statek pod przywództwem Jonah Melville’a chce zdobyć pewną skrzynię i atakuje łowiących. ".$uzytkownik['login']." zamienia się w Herosa i ratuje statek, a także siedzących na brzegu (w tym Gwen) od potwora morskiego, Krakkena. Okazuje się, że potwór wcale nie jest zły, tylko poszukuje swoich jaj, które zostały ukradzione przez wspomnianego Jonah Melville’a
<br>
<br>
Twoim zadaniem jest złapanie Jonah Melville, aby móc odzyskąć jaja i zwrócić je Krakkenowi<br><hr/>
";

  if($uzytkownik['zabitejonah'] >= 1)
  {
  
      mysql_query("UPDATE `pokemon_gracze` SET `misja` = misja+1  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_gracze` SET `kasa` = kasa+700  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_pokemony_gracze` SET `exp` = exp+5  WHERE gracz='".$uzytkownik['gracz']."'");
  
  }


echo "<br>
<br>Pokonany Jonah Melville : ".$uzytkownik['zabitejonah']."/1
<hr/>
Nagroda : 700 Energii Omnitrixa oraz 5 pkt EXPa";
}



if($uzytkownik['misja'] == 3)
{
echo "<h2>Misja 4 : Iskrowice</h2><hr/>";
  echo "<center><hr/><p>
Tennysonowie przyjeżdżają do miasteczka Iskrowice, bardzo staromodnego. ".$uzytkownik['login']." jako heros żongluje piłką z gumek recepturek. Później chłopak opiera się o piłkę ręką, na której ma Omnitrixa i uwalnia z niej potworki Megawhatty, które chcą zniszczyć Iskrowice. Żywią się elektrycznością, i im więcej jej mają, tym są silniejsi.
<br>
<br>
Musisz uratować miasto przed zniszczeniem, a przy okazji siebie przed odpowiedzialnością !<br><hr/>
";

  if($uzytkownik['zabitemegawhatty'] >= 10)
  {
  
      mysql_query("UPDATE `pokemon_gracze` SET `misja` = misja+1  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_gracze` SET `kasa` = kasa+900  WHERE gracz='".$uzytkownik['gracz']."'");
      mysql_query("UPDATE `pokemon_pokemony_gracze` SET `exp` = exp+7  WHERE gracz='".$uzytkownik['gracz']."'");
  
  }


echo "<br>
<br>Pokonane Megawhatty : ".$uzytkownik['zabitemegawhatty']."/10
<hr/>
Nagroda : 900 Energii Omnitrixa oraz 7 pkt EXPa";
}



if($uzytkownik['misja'] > 3)
{
echo "<h2>Tymczasowo Brak Misji</h2><hr/>";
  echo "<center><hr/><p>
Przepraszamy, ale jest to zaledwie ALPHA gry, a nowe misje będą dodawane codziennie.
<br>
<br>
Narazie brak dla Ciebie jakichkolwiek misji !
<br>
<br>
Prosimy o cierpliwość !

";
}






//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 