<?php
session_start();
  /* Première instruction : démarrage de la session
    A faire avant TOUT le reste */
?>
  
   <?php
  /* Database connection settings */
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'piscine';
  $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);


  //query to get data from the table
  

  //loop through the returned data
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="stat.css">
  <title>Pool d'eau</title>
   
   
</head>
<body>
  <div class="menu-wrap">
    <input type="checkbox" class="toggler">
    <div class="hamburger"><div></div></div>
    <div class="menu">
      <div>
        <div>
          <ul>
            <li><a href="index.php">Page principale</a></li>
            <li><a href="info.html">Information</a></li>

          </ul>
        </div>
      </div>
    </div>
  </div>

  <header class="showcase">
    <div class="container showcase-inner">
        <form action = "versus.php" method="post" id="1">
		<span class="color-picker"></span>
          <div>
        <label for="name1">Nom nageur 1 :</label>
        <input type="text" id="name" name="name1">
    </div>
    <div>
        <label for="prenom1">Prenom nageur 1 :</label>
        <input type="text" id="prenom1" name="prenom1">
    </div>
            <div>
        <label for="name2">Nom nageur 2 :</label>
        <input type="text" id="name2" name="name2">
    </div>
    <div>
        <label for="prenom2">Prenom nageur 2 :</label>
        <input type="text" id="prenom2" name="prenom2">
    </div>
    <div>
        <label for="course">Type de nage :</label>
        <input type="text" id="course" name="course">
    </div>
        <input name="envoi" type = "submit" value = "versus 1" class="bmoi" form="1">
        <input name="envoi" type = "submit" value = "versus 2" class="bmoi" formaction ="versus2.php">
        </form>
    </div>
  </header>
    	 <section id="moi"> 
		<br/> 
		<center style ="color : black"> 
		En savoir plus sur Cergy Pontoise Natation :
		</center>
		<br/>
		<center>
	<a title="" href="https://www.cergypontoisenatation.fr/"><img src="site.png" height="40" width="40"/></a> &nbsp; &nbsp;<a href="https://www.facebook.com/CPN95/"><img src="fb30.png" /></a>
		</center>
	
		<br/>
		<center>
		<figure>
		<img src="copy.png" height="40" width="40">
		
		  <figcaption style ="color : black">by CAP'EISTI in 2019</figcaption>
        </figure>
		</center>
		<br/>  
		<center>
		<a href="https://capeisti.fr/"><img src="cap.png" height="50" width="140"/></a>
		</center>
		<br/>
		<center style ="color : black">
		Gonnet-Marty, Boisseau, Perrono, Rabahi, Toulza
		</center>
	<br/>
		
		</section>
       
      <footer>   
   </footer> 
</body>
</html>