<!DOCTYPE php>
<?php
session_start();
  /* Première instruction : démarrage de la session
    A faire avant TOUT le reste */
?>
<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=piscine;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}
$test1 = $_SESSION['nom'];
$test2 = $_SESSION['prenom'];
$test3 = $_SESSION['course'];

$reponse_temps = $bdd->query('SELECT TIME_TO_SEC(temps) FROM performance where nom=\''.$test1.'\' and prenom=\''.$test2.'\' and type_course=\''.$test3.'\'order by pdate');

$reponse_record = $bdd->query('SELECT min(TIME_TO_SEC(temps)) from nageur, performance where nageur.nom=performance.nom and nageur.prenom=performance.prenom and nageur.birth_date=performance.birth_date and type_course = \''.$test3.'\' and sexe=\'F\';');
	# code...

$reponse_ancienne_indiv = $bdd->query('SELECT saison FROM performance where type_course = \''.$test3.'\' and nom=\''.$test1.'\' and prenom=\''.$test2.'\' order by saison limit 1;'); 

$reponse_recente_indiv = $bdd->query('SELECT saison FROM performance where  type_course = \''.$test3.'\' and nom=\''.$test1.'\' and prenom=\''.$test2.'\' order by saison desc limit 1;');

while($donnees_ancienne_indiv = $reponse_ancienne_indiv->fetch())
{
$anneeancienne_indiv=$donnees_ancienne_indiv['saison'];
}
while($donnees_recente_indiv = $reponse_recente_indiv->fetch())
{
$anneerecente_indiv=$donnees_recente_indiv['saison'];
}

while ($donnees_record = $reponse_record->fetch())
{
	$record=$donnees_record['min(TIME_TO_SEC(temps))'];
}

$n=-1;
for ( $saison=$anneeancienne_indiv; $saison<$anneerecente_indiv+1; $saison++)
{
	$reponse_meilleursaison_indiv = $bdd->query('SELECT min(TIME_TO_SEC(temps)) from performance where  type_course = \''.$test3.'\' and prenom=\''.$test2.'\' and nom=\''.$test1.'\' and saison='.$saison.';');
	while($donnees_meilleursaison_indiv = $reponse_meilleursaison_indiv->fetch())
	{
		$meilleursaison_indiv=$donnees_meilleursaison_indiv['min(TIME_TO_SEC(temps))'];
	}
	if ($meilleursaison_indiv>1)
	{
		$tabmeilleursaison_indiv[]=$meilleursaison_indiv;
		$n+=1;
		if  ($n==0)
    	{
    		$b=0.061;
    		$perso=$tabmeilleursaison_indiv[$n];
    		$tabtempstheoriquesaison[]=$tabmeilleursaison_indiv[$n];
		}
		else
		{
			if ($tabmeilleursaison_indiv[$n]<$perso)
			{
				$perso=$tabmeilleursaison_indiv[$n];
			}
			$b1=($perso/$record)*($tabmeilleursaison_indiv[$n-1]-$tabmeilleursaison_indiv[$n])/($tabmeilleursaison_indiv[$n-1]+$tabmeilleursaison_indiv[$n]);
			$b2=(10*abs($tabmeilleursaison_indiv[$n]-(1-$tabmargesaison[$n-1])*$tabmeilleursaison_indiv[$n-1]));
			$b3=($tabmeilleursaison_indiv[$n-1]+$tabmeilleursaison_indiv[$n]);
			$b=$b1*(1-($b2/$b3));
			$tabtempstheoriquesaison[]=$tabmeilleursaison_indiv[$n-1]*(1-$tabmargesaison[$n-1]);
		}
    $tabmargesaison[] = $b;
?>
   
   <p style="color: white">temps prévu par la marge pour la saison suivante <?php echo $tabtempstheoriquesaison[$n] ?><br/>
     temps: <?php echo $tabmeilleursaison_indiv[$n]; ?><br/>
     marge en %: <?php echo 100*$tabmargesaison[$n]; ?><br/><br/></p>
<?php
	}
// $tabmeilleursaison_indiv = tableau des meilleurs performances pour chaque année
// $tabtempsthoriquesaison = tableau des meilleurs temps prévus pour l'année suivante
// $tabmargesaison = tableau des marges prévues pour l'année suivante 
}
// On affiche chaque entrée une à une
$n= -1;
while ($donnees_temps = $reponse_temps->fetch())
{
?>
    <p>
    <?php 
    $n+=1;
    $tabtemps[]=$donnees_temps['TIME_TO_SEC(temps)'];
    if  ($n==0)
    {
    	$b=0.061;
    	$perso=$tabtemps[$n];
    	$tabtempstheorique[]=$tabtemps[$n];
	}
	else
	{
		if ($tabtemps[$n]<$perso)
		{
			$perso=$tabtemps[$n];
		}
		$b1=($perso/$record)*($tabtemps[$n-1]-$tabtemps[$n])/($tabtemps[$n-1]+$tabtemps[$n]);
		$b2=(10*abs($tabtemps[$n]-(1-$tabmarge[$n-1])*$tabtemps[$n-1]));
		$b3=($tabtemps[$n-1]+$tabtemps[$n]);
		$b=$b1*(1-($b2/$b3));
		$tabtempstheorique[]=$tabtemps[$n-1]*(1-$tabmarge[$n-1]);
	}
    $tabmarge[] = $b;
?>
      <p style = "color : white"> temps prévu par la marge pour la course suivante <?php echo $tabtempstheorique[$n] ?><br/>
	 temps: <?php echo $tabtemps[$n]; ?><br/>
     marge en %: <?php echo 100*$tabmarge[$n]; ?><br/></p>
<?php

// $tabtemps = tableau de toutes les performances
// $tabtempsthoriques = tableau des temps prévus pour la course suivant
// $tabmarge = tableau des marges prévues pour la course suivante
}
$reponse_temps->closeCursor(); // Termine le traitement de la requête

?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
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
       <div class="container">
      
        </div>
        <br/><br/><br/>
        <div class="container">
       
        </div>
        
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
       
	</body>
</html>