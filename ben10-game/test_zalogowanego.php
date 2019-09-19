<?php
//sprawdzamy czy w sesji zapisano nr gracza, czyli czy jest zalogowany
if(empty($_SESSION['user'])){
    //nie jest zalogowany, przenieś do strony logowania
    header("Location: index.php");
} else {
    //dodatkowo zabezpieczymy sesję, rzutując wartość na liczbę
    $_SESSION['user'] = (int)$_SESSION['user'];

    //pobieramy dane gracza z bazy
    $uzytkownik = mysql_fetch_array(mysql_query("select *, (select count(*) from pokemon_poczta where typ = 1 and do = gracz and status = 0) as poczta from pokemon_gracze left join pokemon_pokemony_gracze on gracz_id = gracz and pokemon_id = aktywny_pokemon where gracz = ".$_SESSION['user']));
	
	
    //jeżeli nie pobrało gracza, to znaczy, że ktoś kombinuje coś z sesją i trzeba go wylogować
    if(empty($uzytkownik)) header("Location: wyloguj.php");

	//nie ma jeszcze pokemona
if($uzytkownik['omnitrix'] == 1 && $uzytkownik['aktywny_pokemon'] == 0){
mysql_query("insert into pokemon_pokemony_gracze(gracz_id, pokemon_id, nazwa, wartosc, atak, obrona, obrazenia_min, obrazenia_max, zycie, zycie_max) value (".$uzytkownik['gracz'].",1,'Czteroręki',600,7,5,3,5,25,25)");
mysql_query("update pokemon_gracze set aktywny_pokemon = 1 where gracz = ".$uzytkownik['gracz']);
header("Location: kosmici.php");
    }

elseif($uzytkownik['omnitrix'] == 2 && $uzytkownik['aktywny_pokemon'] == 0){
mysql_query("insert into pokemon_pokemony_gracze(gracz_id, pokemon_id, nazwa, wartosc, atak, obrona, obrazenia_min, obrazenia_max, zycie, zycie_max) value (".$uzytkownik['gracz'].",2,'Diamentogłowy',600,5,7,3,7,20,20)");
mysql_query("update pokemon_gracze set aktywny_pokemon = 2 where gracz = ".$uzytkownik['gracz']);
		header("Location: kosmici.php");
	}
	
	if($uzytkownik['aktywny_omnitrix'] == 0){
mysql_query("insert into pokemon_przedmioty_gracze(ppid, gid, pid) value (2,".$uzytkownik['gracz'].",1)") or die(mysql_error());
mysql_query("update pokemon_gracze set aktywny_omnitrix = 2 where gracz = ".$uzytkownik['gracz']);
header("Location: kosmici.php");
    }
	

	//jeżeli skończył się okres vip
	if(($uzytkownik['vip'] > 0) && ($uzytkownik['vip'] < time())){
		mysql_query("update pokemon_gracze set vip = 0, akcje_max = 100 where gracz = ".$uzytkownik['gracz']);
		$uzytkownik['vip'] = 0;
		$uzytkownik['akcje_max'] = 100;
		if($uzytkownik['akcje'] > 100) $uzytkownik['akcje'] = 100;
	}

	
		//lvlup pokemonów, atak + 20% obrona + 20% obrażenia + 20%
	mysql_query("update pokemon_pokemony_gracze set atak = atak * 1.2, obrona = obrona * 1.2, zycie_max = zycie_max + 10, zycie = zycie + 10, obrazenia_min = obrazenia_min * 1.2, obrazenia_max = obrazenia_max * 1.2, lvl = lvl + 1, exp = exp - expMax, expMax = expMax * 1.5, wartosc = wartosc * 2 where exp >= expMax");


}
?> 