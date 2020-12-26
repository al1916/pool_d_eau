
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
    
    $_SESSION['prenom'] = $_POST['prenom'];
    $bla = $_SESSION['nom'];
    $blo = $_POST['prenom'];
	//query to get data from the table

	//loop through the returned data
		
?>

<!--////////////////////////CE QUE J4AI AJOUTE///////////////////////////////-->
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
$tabnage=array('50 Nage Libre','100 Nage Libre','200 Nage Libre','400 Nage Libre','800 Nage Libre','1500 Nage Libre','50 Brasse','100 Brasse','200 Brasse','50 Dos','100 Dos','200 Dos','50 Papillon','100 Papillon','200 Papillon','200 4 Nages','400 4 Nages');

$tabrecord=array(20,46,102,220,452,871,24,51,111,25,56,126,22,49,110,114,243);

$tab='';
$n=0;
foreach ($tabnage as $type_course) 
{

$reponse_temps = $bdd->query('SELECT min(TIME_TO_SEC(temps)) FROM performance where nom="'.$bla.'" and prenom="'.$blo.'" and type_course="'.$type_course.'" order by pdate');

while($donnees_temps = $reponse_temps->fetch())
{
$temps=$donnees_temps['min(TIME_TO_SEC(temps))'];
$tabtemps[]=$temps;
if (is_null($temps))
{
  $tab=$tab. '0,';
}
else
{
  $tab=$tab.'"'.$tabrecord[$n]/$temps.'",';
}
$n+=1;
}
}

$reponse_temps->closeCursor(); // Termine le traitement de la requête

?>

<!--/////////////////////////////////////////FIN////////////////////////////////////////////-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="stat.css">
  <title>Pool d'eau</title>
     
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

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
       <form action = "statind.php" method="post">
	   <span class="color-picker"></span>
    <span class="custom-dropdown">
          <select name="course">
              <?php 
            $sql = "SELECT distinct type_course from performance where nom='".$bla."' and prenom='".$blo."' order by type_course";
              echo $sql;
    $result = mysqli_query($mysqli, $sql);
              
              while ($row=mysqli_fetch_array($result)) { ?>
            
              <option value="<?php echo $row[0]; ?>"> <?php echo $row[0]; ?></option>

<?php
 }
?>
              </select>
			  </span>
        <input name="envoi" type = "submit" value = "valider" class="bmoi">
  </form>
<!--////////////////////////////////////////ICI AUSSI/////////////////////////////////////////////-->
  <canvas id="radar-chart" width="800" height="600"></canvas>
<!--//////////////////////////////////////////// FIN /////////////////////////////////////////-->
        <form action = "choisage.php" method="post">
            <span class="custom-dropdown">
              <select name="groupe">
            <option value="A">Groupe A</option>
            <option value="B">Groupe B</option>
            <option value="C">Groupe C</option>
              </select>
            </span>
        <input name="envoi" type = "submit" value = "Envoyer" class="bmoi">
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

<!--////////////////////////////////////////LA DERNIERE/////////////////////////////////////////////-->
<script>
    Chart.defaults.global.defaultFontColor = 'white';
new Chart(document.getElementById("radar-chart"), {
    type: 'radar',
    data: {
      labels: ['50 Nage Libre','100 Nage Libre','200 Nage Libre','400 Nage Libre','800 Nage Libre','1500 Nage Libre','50 Brasse','100 Brasse','200 Brasse','50 Dos','100 Dos','200 Dos','50 Papillon','100 Papillon','200 Papillon','200 4 Nages','400 4 Nages'],
      datasets: [
         {
          label: "2050",
          fill: true,
            color : "white",
          backgroundColor: "rgba(56,191,235,0.35)",
          borderColor: "rgba(56,191,250)",
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(0,57,184,1)",
          pointBorderColor: "#fff",
          data: [<?php echo $tab ;?>]
        }
      ]
    },
    options: {
        fontColor : 'white',
      title: {
        display: true,
        text: 'Rapport Record du Monde sur Meilleur Temps Personnel (WR/PB)'
      }
    }
});
</script>
<!--//////////////////////////////////////////  FIN  ///////////////////////////////////////////-->