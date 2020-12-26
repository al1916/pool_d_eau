<?php
session_start();
  /* Première instruction : démarrage de la session
    A faire avant TOUT le reste */
?>


<?php
/* Database connection settings */
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
$test1=$_SESSION['sexe'];
$test2=$_SESSION['course'];
$test3=$_POST['age'];
$data2='';
$data3='';
$data4='';
$data5='';
$reponse_ancienne = $bdd->query('SELECT saison FROM performance, nageur where nageur.nom=performance.nom and nageur.prenom=performance.prenom and nageur.birth_date=performance.birth_date and type_course = \''.$test2.'\' and sexe=\'F\' and age=\''.$test3.'\' order by saison limit 1;');

$reponse_recente = $bdd->query('SELECT saison FROM performance, nageur where nageur.nom=performance.nom and nageur.prenom=performance.prenom and nageur.birth_date=performance.birth_date and type_course = \''.$test2.'\' and sexe=\''.$test1.'\' and age=\''.$test3.'\' order by saison desc limit 1;');

while($donnees_ancienne = $reponse_ancienne->fetch())
{
$anneeancienne=$donnees_ancienne['saison'];
}
while($donnees_recente = $reponse_recente->fetch())
{
$anneerecente=$donnees_recente['saison'];
}


for ( $saison=$anneeancienne; $saison<$anneerecente+1; $saison++)
{
$reponse_meilleursaison = $bdd->query('SELECT min(TIME_TO_SEC(temps)) from nageur, performance where nageur.nom=performance.nom and nageur.prenom=performance.prenom and nageur.birth_date=performance.birth_date and type_course = \''.$test2.'\' and sexe=\''.$test1.'\' and age=\''.$test3.'\' and saison='.$saison.';');
while($donnees_meilleursaison = $reponse_meilleursaison->fetch())
{
$meilleursaison=$donnees_meilleursaison['min(TIME_TO_SEC(temps))'];
}
$tabmeilleursaison[]=$meilleursaison;
$data3=$data3.'"'.$saison.'",';
?>
<?php
$data2=$data2.'"'.$meilleursaison.'",';
}

for ( $saison=$anneeancienne; $saison<$anneerecente+1; $saison++)
{
$reponse_meilleursaison = $bdd->query('SELECT avg(TIME_TO_SEC(temps)) from nageur, performance where nageur.nom=performance.nom and nageur.prenom=performance.prenom and nageur.birth_date=performance.birth_date and type_course = \''.$test2.'\' and sexe=\''.$test1.'\' and age=\''.$test3.'\' and saison='.$saison.';');
while($donnees_meilleursaison = $reponse_meilleursaison->fetch())
{
$meilleursaison=$donnees_meilleursaison['avg(TIME_TO_SEC(temps))'];
}
$tabmeilleursaison[]=$meilleursaison;
$data4=$data4.'"'.$saison.'",';
?>
<?php
$data5=$data5.'"'.$meilleursaison.'",';
}
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <link rel="stylesheet" href="stat.css">
		<title>Pool d'eau</title>

		<style type="text/css">	
            :root {
  --primary-color: rgba(13, 110, 139, 0.75);
  --overlay-color: rgba(24, 39, 51 , 0.85);
  --menu-speed: 0.75s;
}
           
			body{
				font-family: Arial;
			    margin: 80px 100px 10px 100px;
			    padding: 0;
			    color: white;
			    text-align: center;
			    background:var(--primary-color);
                position: relative
			}
             body:before{
            content: '';
            background: url('https://images.pexels.com/photos/533923/pexels-photo-533923.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260') no-repeat center center/cover;
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              z-index: -1;
            }

			.container {
				color: #E8E9EB;
				background: #222;
				border:  1px solid;
				padding: 10px;
			}
		</style>

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
        <h1>Temps minimum pour <?php echo $test1.' et pour '.$test2 ; ?></h1>
<canvas id="graph1" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;">  </canvas>
    <script>
var ctx = document.getElementById('graph1').getContext('2d')

var data = {
labels: [<?php
echo $data3;
?>],
datasets: [{
borderColor: 'rgb(15,99,132)',
borderWidth: 5,
label : 'Temps',
data: [<?php
echo $data2;
?>]
}]
}

var options

var config = {
type: 'line',
data: data,
options: options
}
var graph1 = new Chart(ctx,config)
</script>
        </div>
    
    
    
    
    
    
     <div class = container>
         <h1>Temps moyen pour <?php echo $test1.' et pour '.$test2 ; ?></h1>
<canvas id="graph2" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;">  </canvas>
    <script>
var ctx = document.getElementById('graph2').getContext('2d')

var data = {
labels: [<?php
echo $data4;
?>],
datasets: [{
borderColor: 'rgb(15,99,132)',
borderWidth: 5,
label : 'Temps',

data: [<?php
echo $data5;
?>]
}]
}

var options

var config = {
type: 'line',
data: data,
options: options
}
var graph1 = new Chart(ctx,config)
</script>
        </div>
    
</body>
</html>