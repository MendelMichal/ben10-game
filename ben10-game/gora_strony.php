<!doctype html>
<html>
    <head>
<title>Ben10-Game.pl</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="css/ben.css" />
        <link href='http://fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>
        <script type="text/javascript"src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="js/mootools-release-1.11.js"></script>
        <script src="js/dropDownMenu.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function(){
                jQuery('#register').hover(function(){
                    jQuery('#register_field_background').show();
                }, function(){
                    jQuery('#register_field_background').hide();                    
                });
            });
        </script>
        <!--[if IE 7]><style>#dropdownMenu li ul ul {margin-left: 100px;}</style><![endif]-->
				<style>
		#toplist{
    border: 3px solid #83d800;
    background: rgba(0, 0, 0, .6);
    position: fixed;
    color: #83d800;
    bottom: 10px;
    left: 15px;
    border-radius: 5px;
}
</style>
    </head>
    <body>
    <div id="top">
	  <?php
	  if(empty($uzytkownik['gracz'])){
        ?>
        <div id="login">
            <form name="login" method="post" action="logowanie.php">
                <input type="text" name="login" value="login" />
                <input type="password" name="haslo" value="password" />
                <input type="submit" name="log_in" value="OK" />
            </form>
        </div>
        <div id="register">
            <a href='rejestracja.php' id="register_link">Rejestracja</a>
            <div id="register_field_background">
                <div id="register_field">
                    <form name="register" method="post" action="rejestracja.php">
                        <input type="text" name="login" value="login" />
                        <input type="password" name="haslo" value="hasło" />
                        <input type="password" name="haslo2" value="powtórz hasło" />
                        <input type="emai" name="email" value="e-mail" />
                        <input type="submit" name="register_n" value="OK" />
                    </form>
                </div>
            </div>
        </div>
        <?php
	  } else {
		echo "<div id=\"login\">
        Witaj ".$uzytkownik['login'].", <a href='wyloguj.php'>wyloguj</a></div>";
	  }
	  ?>
    </div>
    <?php if(basename($_SERVER['PHP_SELF'])=='index.php'): ?>
        <div id="contaiment" class="contaiment_index">
<iframe width="480" height="360" src="http://www.youtube.com/embed/a1qpfbIEd7U" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="fieldr powitanie">
            <center>Witaj nieznajomy !<br> Jesteś gotów na przygodę,<br> której jeszcze nigdy nie przeżyłeś ?<br> Już teraz zarejestruj się<br> i odbierz swój własny OMNITRIX !</center>
        </div>
        <div class="fieldr news">
        <center><b></b>Zapraszamy do zagrania w <br>wersję ALPHA gry.<br>Prosimy o zgłaszanie błędów,<br>sugestii na maila<br>administracja@ben10-game.pl		<br></center>

<body>
    <div id="toplist">
<a href="http://top50.com.pl/"><img src="http://top50.com.pl/button.php?u=ben10game&t=3" alt="TOP50 Gry" border="0" /></a>
<a id="play4now top lista gry online nr 0" href="http://www.play4now.pl/in/513" target="_blank" title="Play4now - Top lista gry online - MMORPG - MMO"><img src="http://www.play4now.pl/img/513/0" alt="Gry w przeglądarce" width="152" height="52" border="0" title="Gry internetowe" /></a>
<a href="http://gry.top-100.pl/?we=ben10game"><img src="http://img217.imageshack.us/img217/3939/buttonyp7.gif" width=100 height=50 border=0 alt="Gry TOP-100"></a>
<a href="http://i-rpg.pl/glosuj,ben10game"><img src="http://i-rpg.pl/button.php?u=ben10game" alt="Internetowe RPG - lista gier RPG online" border="0" /></a><br>
<a href="http://www.wcograc.pl" title="Gry przeglądarkowe"><img src="http://www.wcograc.pl/img/4u/250x50.png" width="250" height="50" border="0" alt="Gry w przeglądarce" title="Gry przeglądarkowe" /></a>
<a href="http://rpgtextowe.topka.pl/?we=ben10game"><span style="width:100px;height:23px;overflow:hidden;background:#EEEE00;border:3px;border-color:#FFFF22;border-style:outset;padding:5px;font:bold 11px verdana;color:black;text-decoration:none;text-align:center;cursor:pointer">Wszystko o grach www</span></a><br>
<a href="http://top30.nboo.eu"><img src="http://top30.nboo.eu/button.php?u=ben10game" border="0" alt="TOP 30 - Via WWW | GRY ONLINE | MMO | MMORPG"/></a>
<a href="http://toplista.gammo.pl/"><img src="http://toplista.gammo.pl/button.php?wersja=2&u=ben10game" alt="Toplista MMO - Wypromuj strone związaną z tematyką gier MMO - Polskie Centrum Gier MMO" border="0" /></a>
</body>
        </div>
    <?php else: ?>
        <div id="contaiment" class="opacity100">     
    <?php endif; ?>